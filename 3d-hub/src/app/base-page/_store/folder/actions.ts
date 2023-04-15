import { createAction, props } from '@ngrx/store';

import { FolderModel } from './model';
import { FolderResultsModel, FolderResultModel } from './results.model';

const getFolders = createAction('[FOLDER] Get Folders', props<{ payload: any }>());
const getFoldersSuccess = createAction('[FOLDER] Get Folders Success', props<{ payload: FolderResultsModel }>());
const getFoldersFailure = createAction('[FOLDER] Get Folders Faild');

const getFolder = createAction('[FOLDER] Get Folder', props<{ payload: any }>());
const getFolderSuccess = createAction('[FOLDER] Get Folder Success', props<{ payload: FolderResultModel }>());
const getFolderFailure = createAction('[FOLDER] Get Folder Faild');

const createFolder = createAction('[FOLDER] Create Folder', props<{ payload: FolderModel }>());
const createFolderSuccess = createAction('[FOLDER] Create Folder Success', props<{ payload: FolderResultModel }>());
const createFolderFailure = createAction('[FOLDER] Create Folder Faild', props<{ payload: FolderResultModel }>());

const updateFolder = createAction('[FOLDER] Update Folder', props<{ payload: FolderModel }>());
const updateFolderSuccess = createAction('[FOLDER] Update Folder Success', props<{ payload: FolderResultModel }>());
const updateFolderFailure = createAction('[FOLDER] Update Folder Faild', props<{ payload: FolderResultModel }>());

const deleteFolder = createAction('[FOLDER] Delete Folder', props<{ payload: number }>());
const deleteFolderSuccess = createAction('[FOLDER] Delete Folder Success', props<{ payload: FolderResultModel }>());
const deleteFolderFailure = createAction('[FOLDER] Delete Folder Faild', props<{ payload: FolderResultModel }>());

const openFolderView = createAction('[Folder] Open Folder View');

export const FoldersActions = {
  openFolderView,
  getFolders,
  getFoldersSuccess,
  getFoldersFailure,
  getFolder,
  getFolderSuccess,
  getFolderFailure,
  createFolder,
  createFolderSuccess,
  createFolderFailure,
  updateFolder,
  updateFolderSuccess,
  updateFolderFailure,
  deleteFolder,
  deleteFolderSuccess,
  deleteFolderFailure,
};
