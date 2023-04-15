import { createAction, props } from '@ngrx/store';

import { DraftTemplateResultsModel, DraftTemplateResultModel } from './results.model';

const getDraftTemplates = createAction('[DRAFTTEMPLATE] Get Draft Templates', props<{ payload: any }>());
const getDraftTemplatesSuccess = createAction(
  '[DRAFTTEMPLATE] Get Draft Templates Success',
  props<{ payload: DraftTemplateResultsModel }>()
);
const getDraftTemplatesFailure = createAction('[DRAFTTEMPLATE] Get Draft Templates Faild');

const getDraftTemplate = createAction('[DRAFTTEMPLATE] Get Template', props<{ payload: any }>());
const getDraftTemplateSuccess = createAction('[DRAFTTEMPLATE] Get Template Success', props<{ payload: DraftTemplateResultModel }>());
const getDraftTemplateFailure = createAction('[DRAFTTEMPLATE] Get Template Faild');

export const DraftTemplatesActions = {
  getDraftTemplates,
  getDraftTemplatesSuccess,
  getDraftTemplatesFailure,
  getDraftTemplate,
  getDraftTemplateSuccess,
  getDraftTemplateFailure,
};
