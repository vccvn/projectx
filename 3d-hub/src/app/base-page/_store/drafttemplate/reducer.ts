import { DraftTemplatesActions } from './actions';
import { DraftTemplateModel } from './model';
import { createReducer, on } from '@ngrx/store';

const {
  getDraftTemplates,
  getDraftTemplatesFailure,
  getDraftTemplatesSuccess,
  getDraftTemplate,
  getDraftTemplateFailure,
  getDraftTemplateSuccess,
} = DraftTemplatesActions;

export interface DraftTemplateState {
  item: DraftTemplateModel;
  templates: Array<DraftTemplateModel>;
  templatesLoading: boolean;
  templatesEnd: boolean;
  templatesParams: {
    page?: number;
    limit?: number;
    sort?: string;
    q?: string;
  };
}

export const initialState: DraftTemplateState = {
  item: null,
  templates: [],
  templatesLoading: false,
  templatesEnd: false,
  templatesParams: {
    page: 0,
    limit: 10,
    sort: null,
    q: null,
  },
};

export const reducer = createReducer(
  initialState,
  on(getDraftTemplates, (state, { payload }) => {
    if (payload.q !== state.templatesParams.q) {
      return { ...state, templatesLoading: true, templatesParams: { ...payload }, templates: [] };
    }
    return { ...state, templatesLoading: true, templatesParams: { ...payload } };
  }),
  on(getDraftTemplatesSuccess, (state, { payload }) => {
    const newData = payload.data.map((d) => {
      return { ...d, groupKey: state.templatesParams.page };
    });
    const templates = state.templatesParams.page === 0 ? [...payload.data] : [...state.templates, ...newData];
    return {
      ...state,
      templates: templates,
      templatesEnd: !!payload.data.length,
      templatesLoading: false,
    };
  }),
  on(getDraftTemplatesFailure, (state) => {
    return { ...state, templatesLoading: false };
  })
);
