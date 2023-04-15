import { createSelector } from '@ngrx/store';
import * as fromApp from '../reducers';
import * as fromTemplate from '.';

export const getTemplateState = createSelector(fromApp.selectContainerState, (state: fromApp.PageState) => state.templates);

export const getTemplate = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.item);

export const getTemplateGroups = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.templates);

export const getTemplateGroupsParams = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.templatesParams);

export const getTemplateGroupsLoading = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.templatesLoading);

export const getTemplateGroupsEnd = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.templatesEnd);

export const getRenderData = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.renderData);

export const getRenderLoading = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.renderLoading);

export const getYourTemplates = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.yourTemplates);
export const getYourTemplatesParams = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.yourTemplatesParams);
export const getYourTemplatesLoading = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.yourTemplatesLoading);
export const getYourTemplatesEnd = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.yourTemplatesEnd);

export const getSearchTemplates = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.templatesFound);
export const getSearchTemplatesParams = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.templatesFoundParams);
export const getSearchTemplatesLoading = createSelector(
  getTemplateState,
  (state: fromTemplate.TemplateState) => state.templatesFoundLoading
);
export const getSearchTemplatesEnd = createSelector(getTemplateState, (state: fromTemplate.TemplateState) => state.templatesFoundEnd);
