import { createSelector } from '@ngrx/store';
import * as fromApp from '../reducers';
import * as fromDocument from '.';

export const getDocumentState = createSelector(fromApp.selectContainerState, (state: fromApp.PageState) => state.documents);

export const getDocument = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.item);
export const getRenderDataDocument = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.renderData);
export const getRenderDocumentLoading = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.renderLoading);

export const getYourDocuments = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.yourDocuments);
export const getYourDocumentsParams = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.yourDocumentsParams);
export const getYourDocumentsLoading = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.yourDocumentsLoading);
export const getYourDocumentsEnd = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.yourDocumentsEnd);

export const getOrganizationDocuments = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.ogranizationDocuments);
export const getOrganizationDocumentsParams = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.ogranizationDocumentsParams);
export const getOrganizationDocumentsLoading = createSelector(
  getDocumentState,
  (state: fromDocument.DocumentState) => state.ogranizationDocumentsLoading
);
export const getOrganizationDocumentsEnd = createSelector(getDocumentState, (state: fromDocument.DocumentState) => state.ogranizationDocumentsEnd);
