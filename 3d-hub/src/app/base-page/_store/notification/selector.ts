import { createSelector } from '@ngrx/store';
import * as fromApp from '../reducers';
import * as fromNotification from '.';

export const getNotificationState = createSelector(fromApp.selectContainerState, (state: fromApp.PageState) => state.notifications);

export const getNotificationUnRead = createSelector(getNotificationState, (state: fromNotification.NotificationState) => state.unRead);

export const getNotifications = createSelector(getNotificationState, (state: fromNotification.NotificationState) => state.list);

export const getNotification = createSelector(getNotificationState, (state: fromNotification.NotificationState) => state.item);

export const getNotificationsPagination = createSelector(
  getNotificationState,
  (state: fromNotification.NotificationState) => state.pagination
);

export const getNotificationsParams = createSelector(getNotificationState, (state: fromNotification.NotificationState) => state.params);

export const getNotificationsLoading = createSelector(getNotificationState, (state: fromNotification.NotificationState) => state.loading);

export const getNotificationView = createSelector(getNotificationState, (state: fromNotification.NotificationState) => state.modal);
