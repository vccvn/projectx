import { TemplatesActions } from './actions';
import { TemplateModel } from './model';
import { createReducer, on } from '@ngrx/store';

const {
  getTemplateGroups,
  getTemplateGroupsFailure,
  getTemplateGroupsSuccess,
  getYourTemplates,
  getYourTemplatesSuccess,
  getYourTemplatesFailure,

  searchTemplates,
  searchTemplatesSuccess,
  searchTemplatesFailure,
  render,
  renderSuccess,
  renderFailure,
} = TemplatesActions;
export interface TemplateState {
  item: TemplateModel;
  templates: Array<TemplateModel>;
  templatesLoading: boolean;
  templatesEnd: boolean;

  templatesParams: {
    page?: number;
    limit?: number;
    sort?: string;
    q?: string;
  };

  renderData: any;
  renderLoading: boolean;

  yourTemplates: Array<TemplateModel>;
  yourTemplatesLoading: boolean;
  yourTemplatesEnd: boolean;

  yourTemplatesParams: {
    page?: number;
    limit?: number;
    sort?: string;
    q?: string;
  };

  templatesFound: Array<TemplateModel>;
  templatesFoundLoading: boolean;
  templatesFoundEnd: boolean;
  templatesFoundParams: {
    page?: number;
    limit?: number;
    sort?: string;
    q?: string;
  };
}

export const initialState: TemplateState = {
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

  renderData: null,
  renderLoading: false,

  yourTemplates: [],
  yourTemplatesLoading: false,
  yourTemplatesEnd: false,
  yourTemplatesParams: {
    page: 0,
    limit: 10,
    sort: null,
    q: null,
  },

  templatesFound: [],
  templatesFoundLoading: false,
  templatesFoundEnd: false,
  templatesFoundParams: {
    page: 0,
    limit: 10,
    sort: null,
    q: null,
  },
};

export const reducer = createReducer(
  initialState,
  on(getTemplateGroups, (state, { payload }) => {
    if (payload.q !== state.templatesParams.q) {
      return { ...state, templatesLoading: true, templatesParams: { ...payload }, templates: [] };
    }
    return { ...state, templatesLoading: true, templatesParams: { ...payload } };
  }),
  on(getTemplateGroupsSuccess, (state, { payload }) => {
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
  on(getTemplateGroupsFailure, (state) => {
    return { ...state, templatesLoading: false };
  }),
  on(render, (state) => {
    return { ...state, renderLoading: true };
  }),
  on(renderSuccess, (state, { payload }) => {
    return {
      ...state,
      renderData: payload,
      renderLoading: false,
    };
  }),
  on(renderFailure, (state) => {
    return {
      ...state,
      renderLoading: false,
    };
  }),

  on(getYourTemplates, (state, { payload }) => {
    if (payload.q !== state.yourTemplatesParams.q) {
      return { ...state, yourTemplatesLoading: true, yourTemplatesParams: { ...payload }, yourTemplates: [] };
    }
    return { ...state, yourTemplatesLoading: true, yourTemplatesParams: { ...payload } };
  }),
  on(getYourTemplatesSuccess, (state, { payload }) => {
    const newData = payload.data.map((d) => {
      return { ...d, groupKey: state.yourTemplatesParams.page };
    });
    const templates = state.yourTemplatesParams.page === 0 ? [...payload.data] : [...state.yourTemplates, ...newData];
    return {
      ...state,
      yourTemplates: templates,
      yourTemplatesEnd: !!payload.data.length,
      yourTemplatesLoading: false,
    };
  }),
  on(getYourTemplatesFailure, (state) => {
    return { ...state, yourTemplatesLoading: false };
  }),

  on(searchTemplates, (state, { payload }) => {
    if (payload.q !== state.templatesFoundParams.q) {
      return { ...state, templatesFoundLoading: true, templatesFoundParams: { ...payload }, templatesFound: [] };
    }
    return { ...state, templatesFoundLoading: true, templatesFoundParams: { ...payload } };
  }),
  on(searchTemplatesSuccess, (state, { payload }) => {
    const newData = payload.data.map((d) => {
      return { ...d, groupKey: state.templatesFoundParams.page };
    });
    const templates = state.templatesFoundParams.page === 0 ? [...payload.data] : [...state.templatesFound, ...newData];
    return {
      ...state,
      templatesFound: templates,
      templatesFoundEnd: !!payload.data.length,
      templatesFoundLoading: false,
    };
  }),
  on(searchTemplatesFailure, (state) => {
    return { ...state, templatesFoundLoading: false };
  })
);
