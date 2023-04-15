import { DocumentsActions } from './actions';
import { DocumentModel } from './model';
import { createReducer, on } from '@ngrx/store';

const {
  getYourDocuments,
  getYourDocumentsSuccess,
  getYourDocumentsFailure,

  getOrganizationDocuments,
  getOrganizationDocumentsSuccess,
  getOrganizationDocumentsFailure,

  render,
  renderSuccess,
  renderFailure,
} = DocumentsActions;

export interface DocumentState {
  item: DocumentModel;

  documents: Array<DocumentModel>;
  documentsLoading: boolean;
  documentsEnd: boolean;
  documentsParams: {
    page?: number;
    limit?: number;
    sort?: string;
    q?: string;
  };

  ogranizationDocuments: Array<DocumentModel>;
  ogranizationDocumentsLoading: boolean;
  ogranizationDocumentsEnd: boolean;
  ogranizationDocumentsParams: {
    page?: number;
    limit?: number;
    sort?: string;
    q?: string;
  };

  renderData: any;
  renderLoading: boolean;

  yourDocuments: Array<DocumentModel>;
  yourDocumentsLoading: boolean;
  yourDocumentsEnd: boolean;

  yourDocumentsParams: {
    page?: number;
    limit?: number;
    sort?: string;
    q?: string;
  };
}

export const initialState: DocumentState = {
  item: null,
  documents: [],
  documentsLoading: false,
  documentsEnd: false,
  documentsParams: {
    page: 0,
    limit: 10,
    sort: null,
    q: null,
  },

  ogranizationDocuments: [],
  ogranizationDocumentsLoading: false,
  ogranizationDocumentsEnd: false,
  ogranizationDocumentsParams: {
    page: 0,
    limit: 10,
    sort: null,
    q: null,
  },

  renderData: null,
  renderLoading: false,

  yourDocuments: [],
  yourDocumentsLoading: false,
  yourDocumentsEnd: false,
  yourDocumentsParams: {
    page: 0,
    limit: 10,
    sort: null,
    q: null,
  },
};

export const reducer = createReducer(
  initialState,
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

  on(getYourDocuments, (state, { payload }) => {
    if (payload.q !== state.yourDocumentsParams.q) {
      return { ...state, yourDocumentsLoading: true, yourDocumentsParams: { ...payload }, yourDocuments: [] };
    }
    return { ...state, yourDocumentsLoading: true, yourDocumentsParams: { ...payload } };
  }),
  on(getYourDocumentsSuccess, (state, { payload }) => {
    const newData = payload.data.map((d) => {
      return { ...d, groupKey: state.yourDocumentsParams.page };
    });
    const documents = state.yourDocumentsParams.page === 0 ? [...payload.data] : [...state.yourDocuments, ...newData];
    return {
      ...state,
      yourDocuments: documents,
      yourDocumentsEnd: !!payload.data.length,
      yourDocumentsLoading: false,
    };
  }),
  on(getYourDocumentsFailure, (state) => {
    return { ...state, yourDocumentsLoading: false };
  }),

  on(getOrganizationDocuments, (state, { payload }) => {
    return { ...state, ogranizationDocumentsLoading: true, ogranizationDocumentsParams: { ...payload } };
  }),
  on(getOrganizationDocumentsSuccess, (state, { payload }) => {
    const newData = payload.data.map((d) => {
      return { ...d, groupKey: state.ogranizationDocumentsParams.page };
    });
    const documents = state.ogranizationDocumentsParams.page === 0 ? [...payload.data] : [...state.ogranizationDocuments, ...newData];

    return {
      ...state,
      ogranizationDocuments: documents,
      ogranizationDocumentsEnd: !!payload.data.length,
      ogranizationDocumentsLoading: false,
    };
  }),
  on(getOrganizationDocumentsFailure, (state) => {
    return { ...state, ogranizationDocumentsLoading: false };
  })
);
