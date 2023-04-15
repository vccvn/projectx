import { createSelector } from '@ngrx/store';
import * as fromApp from '../reducers';
import * as fromFolder from '.';

export const getFolderState = createSelector(fromApp.selectContainerState, (state: fromApp.PageState) => state.folders);

export const getFolders = createSelector(getFolderState, (state: fromFolder.FolderState) => state.list);

export const getFolder = createSelector(getFolderState, (state: fromFolder.FolderState) => state.item);

export const getFoldersPagination = createSelector(getFolderState, (state: fromFolder.FolderState) => state.pagination);

export const getFoldersParams = createSelector(getFolderState, (state: fromFolder.FolderState) => state.params);

export const getFoldersLoading = createSelector(getFolderState, (state: fromFolder.FolderState) => state.loading);
export const getCurrentFolder = createSelector(getFolderState, (state: fromFolder.FolderState) => state.currentFolder);

export const getFolderView = createSelector(getFolderState, (state: fromFolder.FolderState) => state.modal);
