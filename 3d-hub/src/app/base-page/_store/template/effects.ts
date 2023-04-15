import { Injectable } from '@angular/core';
import { Actions, ofType, createEffect } from '@ngrx/effects';
import { of } from 'rxjs';
import { map, switchMap, catchError, concatMap } from 'rxjs/operators';
import { TemplateService } from './service';
import { TemplatesActions } from './actions';
import { SettingService } from '@app/_core/services';

const {
  getTemplateGroups,
  getTemplateGroupsFailure,
  getTemplateGroupsSuccess,
  getTemplate,
  getTemplateFailure,
  getTemplateSuccess,

  render,
  renderSuccess,
  renderFailure,

  getYourTemplates,
  getYourTemplatesSuccess,
  getYourTemplatesFailure,

  searchTemplates,
  searchTemplatesSuccess,
  searchTemplatesFailure,
} = TemplatesActions;

@Injectable()
export class TemplateEffects {
  constructor(private actions: Actions, private modelService: TemplateService, private settingSerive: SettingService) {}

  searchTemplates$ = createEffect(() =>
    this.actions.pipe(
      ofType(searchTemplates),
      concatMap((pramas) => {
        return this.modelService.searchTemplates(pramas.payload).pipe(
          map((payload) => searchTemplatesSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(searchTemplatesFailure());
          })
        );
      })
    )
  );

  getTemplateGroups$ = createEffect(() =>
    this.actions.pipe(
      ofType(getTemplateGroups),
      concatMap((pramas) => {
        return this.modelService.getTemplateGroups(pramas.payload).pipe(
          map((payload) => getTemplateGroupsSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getTemplateGroupsFailure());
          })
        );
      })
    )
  );

  yours$ = createEffect(() =>
    this.actions.pipe(
      ofType(getYourTemplates),
      concatMap((pramas) => {
        return this.modelService.getMyTemplates(pramas.payload).pipe(
          map((payload) => getYourTemplatesSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getYourTemplatesFailure());
          })
        );
      })
    )
  );

  getOne$ = createEffect(() =>
    this.actions.pipe(
      ofType(getTemplate),
      switchMap((pramas) => {
        return this.modelService.get(pramas.payload).pipe(
          map((payload) => getTemplateSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getTemplateFailure());
          })
        );
      })
    )
  );
  render$ = createEffect(() =>
    this.actions.pipe(
      ofType(render),
      switchMap((params) => {
        return this.modelService.render(params.payload).pipe(
          map((payload) => {
            return renderSuccess({ payload });
          }),
          catchError((err) => {
            console.error(err);
            return of(renderFailure({ payload: err }));
          })
        );
      })
    )
  );
}
