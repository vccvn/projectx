import { createAction, props } from '@ngrx/store';

import { UserModel, PasswordModel } from './model';
import { UserResultsModel, UserResultModel } from './results.model';

const getUsers = createAction('[USER] Get Users', props<{ payload: any }>());

const getUsersSuccess = createAction('[USER] Get Users Success', props<{ payload: UserResultsModel }>());

export const getUsersFailure = createAction('[USER] Get Users Faild');

const getUser = createAction('[USER] Get User', props<{ payload: any }>());

const getUserSuccess = createAction('[USER] Get User Success', props<{ payload: UserResultModel }>());

export const getUserFailure = createAction('[USER] Get User Faild');

const createUser = createAction('[USER] Create User', props<{ payload: UserModel }>());

const createUserSuccess = createAction('[USER] Create User Success', props<{ payload: UserResultModel }>());

export const createUserFailure = createAction('[USER] Create User Faild', props<{ payload: UserResultModel }>());

const updateUser = createAction('[USER] Update User', props<{ payload: UserModel }>());

const updateUserSuccess = createAction('[USER] Update User Success', props<{ payload: UserResultModel }>());

export const updateUserFailure = createAction('[USER] Update User Faild', props<{ payload: UserResultModel }>());

const deleteUser = createAction('[USER] Delete User', props<{ payload: number }>());

const deleteUserSuccess = createAction('[USER] Delete User Success', props<{ payload: UserResultModel }>());
export const openUserView = createAction('[User] Open User View');
export const deleteUserFailure = createAction('[USER] Delete User Faild', props<{ payload: UserResultModel }>());

const getProfile = createAction('[USER] Get Profile');

const getProfileSuccess = createAction('[USER] Get Profile Success', props<{ payload: UserResultModel }>());

export const getProfileFailure = createAction('[USER] Get Profile Faild');

const updateProfilePassword = createAction('[USER] Update User Profile Password', props<{ payload: PasswordModel }>());

const updateProfilePasswordSuccess = createAction('[USER] Update User Profile Password Success', props<{ payload: UserResultModel }>());

export const updateProfilePasswordFailure = createAction('[USER] Update User Profile Password Faild');

const updateMyProfile = createAction('[USER] Update My Profile', props<{ payload: UserModel }>());

const updateMyProfileSuccess = createAction('[USER] Update  My Profile Success', props<{ payload: UserResultModel }>());

export const updateMyProfileFailure = createAction('[USER] Update  My Profile Faild', props<{ payload: UserResultModel }>());

const changeMyPassword = createAction('[USER] Change My Password', props<{ payload: PasswordModel }>());

const changeMyPasswordSuccess = createAction('[USER] Change My Password Success', props<{ payload: UserResultModel }>());

export const changeMyPasswordFailure = createAction('[USER] Change My Password Faild', props<{ payload: UserResultModel }>());

export const UsersActions = {
  updateMyProfile,
  updateMyProfileSuccess,
  updateMyProfileFailure,
  changeMyPassword,
  changeMyPasswordSuccess,
  changeMyPasswordFailure,
  openUserView,

  getUsers,
  getUsersSuccess,
  getUsersFailure,
  getUser,
  getUserSuccess,
  getUserFailure,
  createUser,
  createUserSuccess,
  createUserFailure,
  updateUser,
  updateUserSuccess,
  updateUserFailure,
  deleteUser,
  deleteUserSuccess,
  deleteUserFailure,

  getProfile,
  getProfileSuccess,
  getProfileFailure,
  updateProfilePassword,
  updateProfilePasswordSuccess,
  updateProfilePasswordFailure,
};
