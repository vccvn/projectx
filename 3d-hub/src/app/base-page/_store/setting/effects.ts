import { Injectable } from '@angular/core';
import { Actions, Effect, ofType } from '@ngrx/effects';
import { of } from 'rxjs';
import { map, switchMap, catchError } from 'rxjs/operators';

import { SettingService } from './service';
import {
  SettingActionsTypes,
  GetSetting,
  GetSettingSuccess,
  GetSettingFailure,
  GetSettingsSuccess,
  GetSettingsFailure,
  CreateSetting,
  CreateSettingSuccess,
  UpdateSetting,
  UpdateSettingFast,
  UpdateSettingFastFailure,
  UpdateSettingFastSuccess,
  GetSettings
} from './actions';

@Injectable()
export class SettingEffects {
  constructor(private actions: Actions, private modelService: SettingService) {}

  @Effect()
  getList$ = this.actions.pipe(
    ofType(SettingActionsTypes.GET_SETTINGS),
    switchMap((params: GetSettings) => {
      return this.modelService.getAll(params.payload).pipe(
        map(res => new GetSettingsSuccess(res)),
        catchError(err => {
          console.error(err);
          return of(new GetSettingsFailure());
        })
      );
    })
  );

  @Effect()
  getOne$ = this.actions.pipe(
    ofType(SettingActionsTypes.GET_SETTING),
    switchMap((res: GetSetting) => {
      const key = res.payload;
      return this.modelService.get(key).pipe(
        map(res2 => new GetSettingSuccess(res2)),
        catchError(err => {
          console.error(err);
          return of(new GetSettingFailure());
        })
      );
    })
  );

  @Effect()
  create$ = this.actions.pipe(
    ofType(SettingActionsTypes.CREATE_SETTING),
    switchMap((data: CreateSetting) => {
      return this.modelService.create(data.payload).pipe(
        map(res => new CreateSettingSuccess(res)),
        catchError(err => {
          console.error(err);
          return of(new GetSettingsFailure());
        })
      );
    })
  );

  @Effect()
  update$ = this.actions.pipe(
    ofType(SettingActionsTypes.UPDATE_SETTING),
    switchMap((data: UpdateSetting) => {
      return this.modelService.update(data.payload).pipe(
        map(res => new CreateSettingSuccess(res)),
        catchError(err => {
          console.error(err);
          return of(new GetSettingsFailure());
        })
      );
    })
  );

  @Effect()
  updateFast$ = this.actions.pipe(
    ofType(SettingActionsTypes.UPDATE_SETTING_FAST),
    switchMap((data: UpdateSettingFast) => {
      return this.modelService.updateFast(data.payload).pipe(
        map(res => new UpdateSettingFastSuccess(res)),
        catchError(err => {
          console.error(err);
          return of(new UpdateSettingFastFailure());
        })
      );
    })
  );
}
