import { Injectable } from '@angular/core';
import { Actions, ofType, createEffect } from '@ngrx/effects';
import { of } from 'rxjs';
import { map, switchMap, catchError, withLatestFrom, concatMap } from 'rxjs/operators';

import { NotificationService } from './service';
import { NotificationsActions } from './actions';

import { Store } from '@ngrx/store';
import * as fromBusiness from '.';
const {
  getNotificationUnRead,
  getNotificationUnReadSuccess,
  getNotificationUnReadFailure,
  getNotifications,
  getNotificationsFailure,
  getNotificationsSuccess,
  getNotification,
  getNotificationFailure,
  getNotificationSuccess,
  createNotification,
  createNotificationFailure,
  createNotificationSuccess,
  updateNotification,
  updateNotificationFailure,
  updateNotificationSuccess,
  deleteNotification,
  deleteNotificationFailure,
  deleteNotificationSuccess,
} = NotificationsActions;

@Injectable()
export class NotificationEffects {
  constructor(private actions: Actions, private modelService: NotificationService, private store$: Store<fromBusiness.NotificationState>) {}

  getList$ = createEffect(() =>
    this.actions.pipe(
      ofType(getNotifications),
      switchMap((params) => {
        return this.modelService.getAll(params.payload).pipe(
          map((payload) => getNotificationsSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getNotificationsFailure());
          })
        );
      })
    )
  );

  getOne$ = createEffect(() =>
    this.actions.pipe(
      ofType(getNotification),
      switchMap((params) => {
        return this.modelService.get(params.payload.notificationId).pipe(
          map((payload) => getNotificationSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getNotificationFailure());
          })
        );
      })
    )
  );

  create$ = createEffect(() =>
    this.actions.pipe(
      ofType(createNotification),
      switchMap((params) => {
        return this.modelService.create(params.payload).pipe(
          map((payload) => createNotificationSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(createNotificationFailure({ payload: err }));
          })
        );
      })
    )
  );

  update$ = createEffect(() =>
    this.actions.pipe(
      ofType(updateNotification),
      switchMap((params) => {
        return this.modelService.update(params.payload).pipe(
          map((payload) => updateNotificationSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(updateNotificationFailure({ payload: err }));
          })
        );
      })
    )
  );

  delete$ = createEffect(() =>
    this.actions.pipe(
      ofType(deleteNotification),
      switchMap((params) => {
        return this.modelService.delete(params.payload).pipe(
          map((payload) => deleteNotificationSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(deleteNotificationFailure({ payload: err }));
          })
        );
      })
    )
  );

  getUnRead$ = createEffect(() =>
    this.actions.pipe(
      ofType(getNotificationUnRead),
      switchMap(() => {
        return this.modelService.getUnRead().pipe(
          map((payload) => getNotificationUnReadSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getNotificationUnReadFailure());
          })
        );
      })
    )
  );

  changeSuccess$ = createEffect(() =>
    this.actions.pipe(
      ofType(deleteNotificationSuccess, updateNotificationSuccess, createNotificationSuccess),
      concatMap((action) => of(action).pipe(withLatestFrom(this.store$.select(fromBusiness.getNotificationsParams)))),
      map(([action, params]) => {
        const payload = { ...params };
        return getNotifications({ payload });
      })
    )
  );
}
