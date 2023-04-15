import { createSelector } from '@ngrx/store';
import * as fromApp from '../reducers';
import * as fromUser from '.';

export const getUserState = createSelector(fromApp.selectContainerState, (state: fromApp.PageState) => state.users);

export const getUsers = createSelector(getUserState, (state: fromUser.UserState) => state.list);

export const getUser = createSelector(getUserState, (state: fromUser.UserState) => state.item);

export const getUsersPagination = createSelector(getUserState, (state: fromUser.UserState) => state.pagination);

export const getUsersParams = createSelector(getUserState, (state: fromUser.UserState) => state.params);

export const getUsersLoading = createSelector(getUserState, (state: fromUser.UserState) => state.loading);

export const getUserView = createSelector(getUserState, (state: fromUser.UserState) => state.modal);
export const getProfile = createSelector(getUserState, (state: fromUser.UserState) => state.profile);

export const getProfileLoading = createSelector(getUserState, (state: fromUser.UserState) => state.profileLoading);
