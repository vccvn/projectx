import { Injectable } from '@angular/core';
import { Actions, ofType, createEffect } from '@ngrx/effects';
import { of } from 'rxjs';
import { map, switchMap, catchError, concatMap } from 'rxjs/operators';
import { DraftTemplateService } from './service';
import { DraftTemplatesActions } from './actions';

const {
  getDraftTemplates,
  getDraftTemplatesFailure,
  getDraftTemplatesSuccess,
  getDraftTemplate,
  getDraftTemplateSuccess,
  getDraftTemplateFailure,
} = DraftTemplatesActions;

@Injectable()
export class DraftTemplateEffects {
  constructor(private actions: Actions, private modelService: DraftTemplateService) {}

  getList$ = createEffect(() =>
    this.actions.pipe(
      ofType(getDraftTemplates),
      concatMap((pramas) => {
        return this.modelService.getAll(pramas.payload).pipe(
          map((payload) => getDraftTemplatesSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getDraftTemplatesFailure());
          })
        );
      })
    )
  );

  getOne$ = createEffect(() =>
    this.actions.pipe(
      ofType(getDraftTemplate),
      switchMap((pramas) => {
        return this.modelService.get(pramas.payload).pipe(
          map((payload) => getDraftTemplateSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getDraftTemplateFailure());
          })
        );
      })
    )
  );
}
