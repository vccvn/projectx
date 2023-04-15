import { FoldersActions } from './actions';
import { FolderModel } from './model';
import { createReducer, on } from '@ngrx/store';

export enum FolderModalStatus {
  Init = 0,
  Called = 1,
  Success = 2,
  Failure = 3,
}

export enum FolderModalType {
  Create = 0,
  Edit = 1,
  View = 2,
}

const {
  getFolders,
  getFoldersFailure,
  getFoldersSuccess,
  getFolder,
  getFolderFailure,
  getFolderSuccess,
  createFolder,
  createFolderFailure,
  createFolderSuccess,
  updateFolder,
  updateFolderFailure,
  updateFolderSuccess,
  deleteFolder,
  deleteFolderFailure,
  deleteFolderSuccess,

  openFolderView,
} = FoldersActions;
export interface FolderState {
  list: Array<FolderModel>;
  item: FolderModel;
  currentFolder: FolderModel;
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
    type: FolderModalType;
    data: any;
    isLoading: boolean;
    errors: Array<any>;
    status: FolderModalStatus;
  };
  profile: FolderModel;
  profileLoading: boolean;
}

export const initialState: FolderState = {
  list: [],
  item: null,
  currentFolder: null,
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
    type: FolderModalType.View,
    data: null,
    isLoading: false,
    errors: [],
    status: FolderModalStatus.Init,
  },
  profile: null,
  profileLoading: false,
};

export const reducer = createReducer(
  initialState,
  on(getFolders, (state, { payload }) => {
    return { ...state, loading: true, params: { ...payload } };
  }),
  on(getFoldersSuccess, (state, { payload }) => {
    return {
      ...state,
      list: [...payload.data],
      currentFolder: { ...payload.currentFolder },
      pagination: { ...payload.pagination },
      loading: false,
    };
  }),
  on(getFoldersFailure, (state) => {
    return {
      ...state,
      loading: false,
    };
  }),
  on(updateFolder, (state) => {
    const modal = {
      ...state.modal,
      isLoading: true,
      status: FolderModalStatus.Called,
      type: FolderModalType.Edit,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(updateFolderSuccess, (state) => {
    const modal = {
      ...state.modal,
      isLoading: false,
      status: FolderModalStatus.Success,
    };
    return {
      ...state,
      modal,
    };
  }),
  on(updateFolderFailure, (state, { payload }) => {
    const { validationErrors = [] } = payload;
    const modal = {
      ...state.modal,
      isLoading: false,
      status: FolderModalStatus.Failure,
      errors: [...validationErrors],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createFolder, (state, { payload }) => {
    const modal = {
      ...state.modal,
      isLoading: true,
      status: FolderModalStatus.Init,
      type: FolderModalType.Create,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createFolderSuccess, (state) => {
    const modal = {
      ...state.modal,
      isLoading: false,
      status: FolderModalStatus.Success,
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createFolderFailure, (state, { payload }) => {
    const { validationErrors = [] } = payload;
    const modal = {
      ...state.modal,
      isLoading: false,
      status: FolderModalStatus.Failure,
      errors: [...validationErrors],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(deleteFolder, (state) => {
    return { ...state, loading: true };
  }),
  on(deleteFolderSuccess, (state) => {
    return { ...state, loading: false };
  }),
  on(deleteFolderFailure, (state) => {
    return { ...state, loading: false };
  }),
  on(openFolderView, (state) => {
    const modal = {
      ...state.modal,
      status: FolderModalStatus.Init,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  })
);
