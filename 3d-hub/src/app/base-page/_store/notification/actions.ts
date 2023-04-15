import { createAction, props } from '@ngrx/store';

import { NotificationModel } from './model';
import { NotificationResultsModel, NotificationResultModel } from './results.model';

const getNotifications = createAction('[NOTIFICATION] Get Notifications', props<{ payload: any }>());

const getNotificationsSuccess = createAction('[NOTIFICATION] Get Notifications Success', props<{ payload: NotificationResultsModel }>());

export const getNotificationsFailure = createAction('[NOTIFICATION] Get Notifications Faild');

const getNotificationUnRead = createAction('[NOTIFICATION] Get Notification UnRead');

const getNotificationUnReadSuccess = createAction(
  '[NOTIFICATION] Get Notification UnRead Success',
  props<{ payload: { data: { notSeenCount: number } } }>()
);

export const getNotificationUnReadFailure = createAction('[NOTIFICATION] Get Notification UnRead Faild');

const getNotification = createAction('[NOTIFICATION] Get Notification', props<{ payload: { notificationId: number } }>());

const getNotificationSuccess = createAction('[NOTIFICATION] Get Notification Success', props<{ payload: NotificationResultModel }>());

export const getNotificationFailure = createAction('[NOTIFICATION] Get Notification Faild');

const createNotification = createAction('[NOTIFICATION] Create Notification', props<{ payload: NotificationModel }>());

const createNotificationSuccess = createAction('[NOTIFICATION] Create Notification Success', props<{ payload: NotificationResultModel }>());

export const createNotificationFailure = createAction(
  '[NOTIFICATION] Create Notification Faild',
  props<{ payload: NotificationResultModel }>()
);

const updateNotification = createAction('[NOTIFICATION] Update Notification', props<{ payload: NotificationModel }>());

const updateNotificationSuccess = createAction('[NOTIFICATION] Update Notification Success', props<{ payload: NotificationResultModel }>());

export const updateNotificationFailure = createAction(
  '[NOTIFICATION] Update Notification Faild',
  props<{ payload: NotificationResultModel }>()
);

const deleteNotification = createAction('[NOTIFICATION] Delete Notification', props<{ payload: number }>());

const deleteNotificationSuccess = createAction('[NOTIFICATION] Delete Notification Success', props<{ payload: NotificationResultModel }>());

export const deleteNotificationFailure = createAction(
  '[NOTIFICATION] Delete Notification Faild',
  props<{ payload: NotificationResultModel }>()
);
export const openNotificationView = createAction('[NOTIFICATION] Open Notification View');

const connectOnesignal = createAction('[NOTIFICATION] Connnect Onesignal');

const addNotification = createAction('[NOTIFICATION] Add Notification', props<{ payload: { message: NotificationModel } }>());

export const NotificationsActions = {
  getNotificationUnRead,
  getNotificationUnReadSuccess,
  getNotificationUnReadFailure,
  addNotification,
  connectOnesignal,
  openNotificationView,
  getNotifications,
  getNotificationsSuccess,
  getNotificationsFailure,
  getNotification,
  getNotificationSuccess,
  getNotificationFailure,
  createNotification,
  createNotificationSuccess,
  createNotificationFailure,
  updateNotification,
  updateNotificationSuccess,
  updateNotificationFailure,
  deleteNotification,
  deleteNotificationSuccess,
  deleteNotificationFailure,
};
