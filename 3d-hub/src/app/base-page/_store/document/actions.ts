import { createAction, props } from '@ngrx/store';

import { DocumentResultsModel, DocumentResultModel } from './results.model';

const getOrganizationDocuments = createAction('[DOCUMENT] Get Organization Documents', props<{ payload: any }>());
const getOrganizationDocumentsSuccess = createAction(
  '[DOCUMENT] Search Organization Documents Success',
  props<{ payload: DocumentResultsModel }>()
);
const getOrganizationDocumentsFailure = createAction('[DOCUMENT] Search Organization Documents Faild');

const getYourDocuments = createAction('[DOCUMENT] Get Your Documents', props<{ payload: any }>());
const getYourDocumentsSuccess = createAction('[DOCUMENT] Get Your Documents Success', props<{ payload: DocumentResultsModel }>());
const getYourDocumentsFailure = createAction('[DOCUMENT] Get Your Documents Faild');

const getDocument = createAction('[DOCUMENT] Get Document', props<{ payload: any }>());
const getDocumentSuccess = createAction('[DOCUMENT] Get Document Success', props<{ payload: DocumentResultModel }>());
const getDocumentFailure = createAction('[DOCUMENT] Get Document Faild');

const render = createAction('[DOCUMENT] Update Document Redner', props<{ payload: { html: string } }>());
const renderSuccess = createAction('[DOCUMENT] Update Document Redner Success', props<{ payload: { data: any } }>());
const renderFailure = createAction('[DOCUMENT] Update Document Redner Faild', props<{ payload: DocumentResultModel }>());

export const DocumentsActions = {
  render,
  renderSuccess,
  renderFailure,
  getYourDocuments,
  getYourDocumentsSuccess,
  getYourDocumentsFailure,
  getDocument,
  getDocumentSuccess,
  getDocumentFailure,
  getOrganizationDocuments,
  getOrganizationDocumentsSuccess,
  getOrganizationDocumentsFailure,
};
