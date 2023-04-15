import { createAction, props } from '@ngrx/store';

import { TemplateResultsModel, TemplateResultModel } from './results.model';

const searchTemplates = createAction('[TEMPLATE] Search Templates', props<{ payload: any }>());
const searchTemplatesSuccess = createAction('[TEMPLATE] Search Templates Success', props<{ payload: TemplateResultsModel }>());
const searchTemplatesFailure = createAction('[TEMPLATE] Search Templates Faild');

const getTemplateGroups = createAction('[TEMPLATE] Get Global Templates', props<{ payload: any }>());
const getTemplateGroupsSuccess = createAction('[TEMPLATE] Get Global Templates Success', props<{ payload: TemplateResultsModel }>());
const getTemplateGroupsFailure = createAction('[TEMPLATE] Get Global Templates Faild');

const getYourTemplates = createAction('[TEMPLATE] Get Your Templates', props<{ payload: any }>());
const getYourTemplatesSuccess = createAction('[TEMPLATE] Get Your Templates Success', props<{ payload: TemplateResultsModel }>());
const getYourTemplatesFailure = createAction('[TEMPLATE] Get Your Templates Faild');

const getTemplate = createAction('[TEMPLATE] Get Template', props<{ payload: any }>());
const getTemplateSuccess = createAction('[TEMPLATE] Get Template Success', props<{ payload: TemplateResultModel }>());
const getTemplateFailure = createAction('[TEMPLATE] Get Template Faild');

const render = createAction('[TEMPLATE] Update Template Redner', props<{ payload: { html: string } }>());
const renderSuccess = createAction('[TEMPLATE] Update Template Redner Success', props<{ payload: { data: any } }>());
const renderFailure = createAction('[TEMPLATE] Update Template Redner Faild', props<{ payload: TemplateResultModel }>());

export const TemplatesActions = {
  render,
  renderSuccess,
  renderFailure,
  getYourTemplates,
  getYourTemplatesSuccess,
  getYourTemplatesFailure,
  getTemplateGroups,
  getTemplateGroupsSuccess,
  getTemplateGroupsFailure,
  getTemplate,
  getTemplateSuccess,
  getTemplateFailure,
  searchTemplates,
  searchTemplatesSuccess,
  searchTemplatesFailure,
};
