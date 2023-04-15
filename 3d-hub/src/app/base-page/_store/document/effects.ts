import { Injectable } from '@angular/core';
import { Actions, ofType, createEffect } from '@ngrx/effects';
import { of } from 'rxjs';
import { map, switchMap, catchError, concatMap } from 'rxjs/operators';
import { DocumentService } from './service';
import { DocumentsActions } from './actions';
import { SettingService } from '@app/_core/services';

const {
  getDocument,
  getDocumentFailure,
  getDocumentSuccess,

  render,
  renderSuccess,
  renderFailure,

  getYourDocuments,
  getYourDocumentsSuccess,
  getYourDocumentsFailure,

  getOrganizationDocuments,
  getOrganizationDocumentsSuccess,
  getOrganizationDocumentsFailure,
} = DocumentsActions;

@Injectable()
export class DocumentEffects {
  constructor(private actions: Actions, private modelService: DocumentService, private settingSerive: SettingService) {}

  getOrganizationDocuments$ = createEffect(() =>
    this.actions.pipe(
      ofType(getOrganizationDocuments),
      concatMap((pramas) => {
        return this.modelService.getOrganizationDocuments(pramas.payload).pipe(
          map((payload) => getOrganizationDocumentsSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getOrganizationDocumentsFailure());
          })
        );
      })
    )
  );

  yours$ = createEffect(() =>
    this.actions.pipe(
      ofType(getYourDocuments),
      concatMap((pramas) => {
        return this.modelService.getMyDocuments(pramas.payload).pipe(
          map((payload) => getYourDocumentsSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getYourDocumentsFailure());
          })
        );
      })
    )
  );

  getOne$ = createEffect(() =>
    this.actions.pipe(
      ofType(getDocument),
      switchMap((pramas) => {
        return this.modelService.get(pramas.payload).pipe(
          map((payload) => getDocumentSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getDocumentFailure());
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
