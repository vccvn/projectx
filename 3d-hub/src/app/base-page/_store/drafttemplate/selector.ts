import { createSelector } from '@ngrx/store';
import * as fromApp from '../reducers';
import * as fromTemplate from '.';

export const getDraftTemplateState = createSelector(fromApp.selectContainerState, (state: fromApp.PageState) => state.drafttemplates);

export const getDraftTemplate = createSelector(getDraftTemplateState, (state: fromTemplate.DraftTemplateState) => state.item);

export const getDraftTemplates = createSelector(getDraftTemplateState, (state: fromTemplate.DraftTemplateState) => state.templates);

export const getDraftTemplatesParams = createSelector(
  getDraftTemplateState,
  (state: fromTemplate.DraftTemplateState) => state.templatesParams
);

export const getDraftTemplatesLoading = createSelector(
  getDraftTemplateState,
  (state: fromTemplate.DraftTemplateState) => state.templatesLoading
);

export const getDraftTemplatesEnd = createSelector(getDraftTemplateState, (state: fromTemplate.DraftTemplateState) => state.templatesEnd);
