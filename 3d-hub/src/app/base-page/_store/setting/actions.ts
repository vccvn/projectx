import { Action } from '@ngrx/store';
import { SettingResultsModel, SettingResultModel } from './results.model';
import { SettingModel } from './model';

export enum SettingActionsTypes {
  GET_SETTINGS = '[Setting] Get Settings',
  GET_SETTINGS_SUCCESS = '[Setting] Get Settings Success',
  GET_SETTINGS_FAILURE = '[Setting] Get Settings Failure',

  GET_SETTING = '[Setting] Get Setting',
  GET_SETTING_SUCCESS = '[Setting] Get Setting Success',
  GET_SETTING_FAILURE = '[Setting] Get Setting Failure',

  DELETE_SETTING = '[Setting] Delete Setting',
  DELETE_SETTING_SUCCESS = '[Setting] Delete Setting Success',
  DELETE_SETTING_FAILURE = '[Setting] Delete Setting Failure',

  UPDATE_SETTING = '[Setting] Update Setting',
  UPDATE_SETTING_SUCCESS = '[Setting] Update Setting Success',
  UPDATE_SETTING_FAILURE = '[Setting] Update Setting Failure',

  UPDATE_SETTING_FAST = '[Setting] Update Setting Fast',
  UPDATE_SETTING_FAST_SUCCESS = '[Setting] Update Setting Fast Success',
  UPDATE_SETTING_FAST_FAILURE = '[Setting] Update Setting Fast Failure',

  FETCH_SETTING = '[Setting] Fetch Setting',
  FETCH_SETTING_SUCCESS = '[Setting] Fetch Setting Success',
  FETCH_SETTING_FAILURE = '[Setting] Fetch Setting Failure',

  CREATE_SETTING = '[Setting] Create Setting',
  CREATE_SETTING_SUCCESS = '[Setting] Create Setting Success',
  CREATE_SETTING_FAILURE = '[Setting] Create Setting Failure',

  INIT_SETTING = '[Setting] Init Setting'
}

export class GetSettings implements Action {
  readonly type = SettingActionsTypes.GET_SETTINGS;
  constructor(public payload: {}) {}
}

export class GetSettingsSuccess implements Action {
  readonly type = SettingActionsTypes.GET_SETTINGS_SUCCESS;
  constructor(public payload: SettingResultsModel) {}
}
export class GetSettingsFailure implements Action {
  readonly type = SettingActionsTypes.GET_SETTINGS_FAILURE;
}

export class GetSetting implements Action {
  readonly type = SettingActionsTypes.GET_SETTING;
  constructor(public payload: string) {}
}
export class GetSettingSuccess implements Action {
  readonly type = SettingActionsTypes.GET_SETTING_SUCCESS;
  constructor(public payload: SettingResultModel) {}
}
export class GetSettingFailure implements Action {
  readonly type = SettingActionsTypes.GET_SETTING_FAILURE;
}

export class UpdateSetting implements Action {
  readonly type = SettingActionsTypes.UPDATE_SETTING;
  constructor(public payload: SettingModel) {}
}
export class UpdateSettingSuccess implements Action {
  readonly type = SettingActionsTypes.UPDATE_SETTING_SUCCESS;
  constructor(public payload: SettingResultModel) {}
}
export class UpdateSettingFailure implements Action {
  readonly type = SettingActionsTypes.UPDATE_SETTING_FAILURE;
}

export class UpdateSettingFast implements Action {
  readonly type = SettingActionsTypes.UPDATE_SETTING_FAST;
  constructor(public payload: SettingModel) {}
}
export class UpdateSettingFastSuccess implements Action {
  readonly type = SettingActionsTypes.UPDATE_SETTING_FAST_SUCCESS;
  constructor(public payload: SettingResultModel) {}
}
export class UpdateSettingFastFailure implements Action {
  readonly type = SettingActionsTypes.UPDATE_SETTING_FAST_FAILURE;
}

export class FetchSetting implements Action {
  readonly type = SettingActionsTypes.FETCH_SETTING;
  constructor(public payload: string) {}
}
export class FetchSettingSuccess implements Action {
  readonly type = SettingActionsTypes.FETCH_SETTING_SUCCESS;
  constructor(public payload: SettingModel) {}
}
export class FetchSettingFailure implements Action {
  readonly type = SettingActionsTypes.FETCH_SETTING_FAILURE;
}

export class CreateSetting implements Action {
  readonly type = SettingActionsTypes.CREATE_SETTING;
  constructor(public payload: SettingModel) {}
}
export class CreateSettingSuccess implements Action {
  readonly type = SettingActionsTypes.CREATE_SETTING_SUCCESS;
  constructor(public payload: SettingResultModel) {}
}
export class CreateSettingFailure implements Action {
  readonly type = SettingActionsTypes.CREATE_SETTING_FAILURE;
}

export class DeleteSetting implements Action {
  readonly type = SettingActionsTypes.DELETE_SETTING;
  constructor(public payload: number) {}
}
export class DeleteSettingSuccess implements Action {
  readonly type = SettingActionsTypes.DELETE_SETTING_SUCCESS;
  constructor(public payload: SettingResultModel) {}
}
export class DeleteSettingFailure implements Action {
  readonly type = SettingActionsTypes.DELETE_SETTING_FAILURE;
}

export class InitSetting implements Action {
  readonly type = SettingActionsTypes.INIT_SETTING;
}

export type SettingsActions =
  | GetSettings
  | GetSettingsSuccess
  | GetSettingsFailure
  | GetSetting
  | GetSettingSuccess
  | GetSettingFailure
  | UpdateSetting
  | UpdateSettingSuccess
  | UpdateSettingFailure
  | UpdateSettingFast
  | UpdateSettingFastSuccess
  | UpdateSettingFastFailure
  | FetchSetting
  | FetchSettingSuccess
  | FetchSettingFailure
  | CreateSetting
  | CreateSettingSuccess
  | CreateSettingFailure
  | DeleteSetting
  | DeleteSettingSuccess
  | DeleteSettingFailure
  | InitSetting;
