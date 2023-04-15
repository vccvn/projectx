import { Injectable } from '@angular/core';
import { Actions, ofType, createEffect } from '@ngrx/effects';
import { of } from 'rxjs';
import { map, switchMap, catchError, withLatestFrom, concatMap } from 'rxjs/operators';

import { FolderService } from './service';
import { FoldersActions } from './actions';

import { Store } from '@ngrx/store';
import * as fromFolder from '.';
const {
  getFolders,
  getFoldersFailure,
  getFoldersSuccess,
  getFolder,
  getFolderFailure,
  getFolderSuccess,
  createFolder,
  createFolderFailure,
  createFolderSuccess,
  updateFolder,
  updateFolderFailure,
  updateFolderSuccess,
  deleteFolder,
  deleteFolderFailure,
  deleteFolderSuccess,
} = FoldersActions;

@Injectable()
export class FolderEffects {
  constructor(private actions: Actions, private modelService: FolderService, private store$: Store<fromFolder.FolderState>) {}

  getList$ = createEffect(() =>
    this.actions.pipe(
      ofType(getFolders),
      switchMap((pramas) => {
        return this.modelService.getFolders(pramas.payload).pipe(
          map((payload) => getFoldersSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getFoldersFailure());
          })
        );
      })
    )
  );

  getOne$ = createEffect(() =>
    this.actions.pipe(
      ofType(getFolder),
      switchMap((pramas) => {
        return this.modelService.get(pramas.payload).pipe(
          map((payload) => getFolderSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getFolderFailure());
          })
        );
      })
    )
  );

  create$ = createEffect(() =>
    this.actions.pipe(
      ofType(createFolder),
      switchMap((pramas) => {
        return this.modelService.create(pramas.payload).pipe(
          map((payload) => createFolderSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(createFolderFailure({ payload: err }));
          })
        );
      })
    )
  );

  update$ = createEffect(() =>
    this.actions.pipe(
      ofType(updateFolder),
      switchMap((pramas) => {
        return this.modelService.update(pramas.payload).pipe(
          map((payload) => updateFolderSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(updateFolderFailure({ payload: err }));
          })
        );
      })
    )
  );

  delete$ = createEffect(() =>
    this.actions.pipe(
      ofType(deleteFolder),
      switchMap((pramas) => {
        return this.modelService.delete(pramas.payload).pipe(
          map((payload) => deleteFolderSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(deleteFolderFailure({ payload: err }));
          })
        );
      })
    )
  );

  changeSuccess$ = createEffect(() =>
    this.actions.pipe(
      ofType(deleteFolderSuccess, updateFolderSuccess, createFolderSuccess),
      concatMap((action) => of(action).pipe(withLatestFrom(this.store$.select(fromFolder.getFoldersParams)))),
      map(([action, params]) => {
        const payload = { ...params };
        return getFolders({ payload });
      })
    )
  );
}
