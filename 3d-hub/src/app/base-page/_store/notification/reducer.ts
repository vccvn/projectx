import { NotificationsActions } from './actions';
import { NotificationModel } from './model';
import { createReducer, on } from '@ngrx/store';

export enum NotificationModalStatus {
  Init = 0,
  Called = 1,
  Success = 2,
  Failure = 3,
}

export enum NotificationModalType {
  Create = 0,
  Edit = 1,
  View = 2,
}

const {
  getNotifications,
  getNotificationsFailure,
  getNotificationsSuccess,
  getNotification,
  getNotificationFailure,
  getNotificationSuccess,
  createNotification,
  createNotificationFailure,
  createNotificationSuccess,
  updateNotification,
  updateNotificationFailure,
  updateNotificationSuccess,
  deleteNotification,
  deleteNotificationFailure,
  deleteNotificationSuccess,
  openNotificationView,
  addNotification,
  getNotificationUnRead,
  getNotificationUnReadSuccess,
  getNotificationUnReadFailure,
} = NotificationsActions;
export interface NotificationState {
  list: Array<NotificationModel>;
  item: NotificationModel;
  pagination: {
    page: number;
    limit: number;
    totalRecords: number;
  };
  params: {
    page?: number;
    limit?: number;
    sort?: string;
    search?: string;
    name?: string;
    fullName?: string;
  };
  loading: boolean;
  modal: {
    type: NotificationModalType;
    data: any;
    isLoading: boolean;
    errors: Array<any>;
    status: NotificationModalStatus;
  };
  unRead: number;
}

export const initialState: NotificationState = {
  list: [],
  item: null,
  pagination: {
    page: 0,
    limit: 10,
    totalRecords: 0,
  },
  params: {
    page: 0,
    limit: 10,
    sort: null,
    search: null,
    fullName: null,
    name: null,
  },
  loading: false,
  modal: {
    type: NotificationModalType.View,
    data: null,
    isLoading: false,
    errors: [],
    status: NotificationModalStatus.Init,
  },
  unRead: 0,
};

export const reducer = createReducer(
  initialState,
  on(getNotifications, (state, { payload }) => {
    return { ...state, loading: true, params: { ...payload } };
  }),
  on(getNotificationsSuccess, (state, { payload }) => {
    return {
      ...state,
      list: [...payload.data],
      pagination: { ...payload.pagination },
      loading: false,
    };
  }),
  on(getNotificationsFailure, (state) => {
    return {
      ...state,
      loading: false,
    };
  }),
  on(updateNotification, (state) => {
    const modal = {
      ...state.modal,
      isLoading: true,
      status: NotificationModalStatus.Called,
      type: NotificationModalType.Edit,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(updateNotificationSuccess, (state) => {
    const modal = {
      ...state.modal,
      isLoading: false,
      status: NotificationModalStatus.Success,
    };
    return {
      ...state,
      modal,
    };
  }),
  on(updateNotificationFailure, (state, { payload }) => {
    const { validationErrors = [] } = payload;
    const modal = {
      ...state.modal,
      isLoading: false,
      status: NotificationModalStatus.Failure,
      errors: [...validationErrors],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createNotification, (state, { payload }) => {
    const modal = {
      ...state.modal,
      isLoading: true,
      status: NotificationModalStatus.Init,
      type: NotificationModalType.Create,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createNotificationSuccess, (state) => {
    const modal = {
      ...state.modal,
      isLoading: false,
      status: NotificationModalStatus.Success,
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createNotificationFailure, (state, { payload }) => {
    const { validationErrors = [] } = payload;
    const modal = {
      ...state.modal,
      isLoading: false,
      status: NotificationModalStatus.Failure,
      errors: [...validationErrors],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(deleteNotification, (state) => {
    return { ...state, loading: true };
  }),
  on(deleteNotificationSuccess, (state) => {
    return { ...state, loading: false };
  }),
  on(deleteNotificationFailure, (state) => {
    return { ...state, loading: false };
  }),
  on(openNotificationView, (state) => {
    const modal = {
      ...state.modal,
      status: NotificationModalStatus.Init,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(addNotification, (state, { payload }) => {
    const list = [payload.message].concat(state.list);

    return {
      ...state,
      list,
      unRead: state.unRead + 1,
    };
  }),
  on(getNotificationUnRead, (state) => {
    return { ...state, loading: true };
  }),
  on(getNotificationUnReadSuccess, (state, { payload }) => {
    return {
      ...state,
      unRead: payload.data.notSeenCount,
      loading: false,
    };
  }),
  on(getNotificationUnReadFailure, (state) => {
    return {
      ...state,
      loading: false,
    };
  })
);
