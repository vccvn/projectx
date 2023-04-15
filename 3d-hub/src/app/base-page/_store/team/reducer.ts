import { TeamsActions } from './actions';
import { TeamModel } from './model';
import { createReducer, on } from '@ngrx/store';
import { UserModel } from '../user';

export enum TeamModalStatus {
  Init = 0,
  Called = 1,
  Success = 2,
  Failure = 3,
}

export enum TeamModalType {
  Create = 0,
  Edit = 1,
  View = 2,
}

const {
  getTeams,
  getTeamsFailure,
  getTeamsSuccess,
  getTeam,
  getTeamFailure,
  getTeamSuccess,
  createTeam,
  createTeamFailure,
  createTeamSuccess,
  updateTeam,
  updateTeamFailure,
  updateTeamSuccess,
  deleteTeam,
  deleteTeamFailure,
  deleteTeamSuccess,
  openTeamView,
  getTeamMembers,
  getTeamMembersSuccess,
  getTeamMembersFailure,
  cleanTeamMembers,
  removeTeamMember,
  addTeamMember,
} = TeamsActions;
export interface TeamState {
  list: Array<TeamModel>;
  item: TeamModel;
  pagination: {
    page: number;
    limit: number;
    totalRecords: number;
  };
  params: {
    page?: number;
    limit?: number;
    sort?: string;
    search?: string;
    name?: string;
    fullName?: string;
  };
  loading: boolean;
  modal: {
    type: TeamModalType;
    data: any;
    isLoading: boolean;
    errors: Array<any>;
    status: TeamModalStatus;
  };
  members: Array<UserModel>;
  membersLoading: boolean;
}

export const initialState: TeamState = {
  list: [],
  item: null,
  pagination: {
    page: 0,
    limit: 10,
    totalRecords: 0,
  },
  params: {
    page: 0,
    limit: 10,
    sort: null,
    search: null,
    fullName: null,
    name: null,
  },
  loading: false,
  modal: {
    type: TeamModalType.View,
    data: null,
    isLoading: false,
    errors: [],
    status: TeamModalStatus.Init,
  },
  members: [],
  membersLoading: false,
};

export const reducer = createReducer(
  initialState,
  on(getTeams, (state, { payload }) => {
    return { ...state, loading: true, params: { ...payload } };
  }),
  on(getTeamsSuccess, (state, { payload }) => {
    return {
      ...state,
      list: [...payload.data],
      pagination: { ...payload.pagination },
      loading: false,
    };
  }),
  on(getTeamsFailure, (state) => {
    return {
      ...state,
      loading: false,
    };
  }),
  on(updateTeam, (state) => {
    const modal = {
      ...state.modal,
      isLoading: true,
      status: TeamModalStatus.Called,
      type: TeamModalType.Edit,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(updateTeamSuccess, (state) => {
    const modal = {
      ...state.modal,
      isLoading: false,
      status: TeamModalStatus.Success,
    };
    return {
      ...state,
      modal,
    };
  }),
  on(updateTeamFailure, (state, { payload }) => {
    const { validationErrors = [] } = payload;
    const modal = {
      ...state.modal,
      isLoading: false,
      status: TeamModalStatus.Failure,
      errors: [...validationErrors],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createTeam, (state, { payload }) => {
    const modal = {
      ...state.modal,
      isLoading: true,
      status: TeamModalStatus.Init,
      type: TeamModalType.Create,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(createTeamSuccess, (state) => {
    const modal = {
      ...state.modal,
      isLoading: false,
      status: TeamModalStatus.Success,
    };
    return {
      ...state,
      modal,
      members: [],
    };
  }),
  on(createTeamFailure, (state, { payload }) => {
    const { validationErrors = [] } = payload;
    const modal = {
      ...state.modal,
      isLoading: false,
      status: TeamModalStatus.Failure,
      errors: [...validationErrors],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(deleteTeam, (state) => {
    return { ...state, loading: true };
  }),
  on(deleteTeamSuccess, (state) => {
    return { ...state, loading: false };
  }),
  on(deleteTeamFailure, (state) => {
    return { ...state, loading: false };
  }),
  on(openTeamView, (state) => {
    const modal = {
      ...state.modal,
      status: TeamModalStatus.Init,
      errors: [],
    };
    return {
      ...state,
      modal,
    };
  }),
  on(getTeamMembers, (state) => {
    return { ...state, membersLoading: true };
  }),
  on(getTeamMembersSuccess, (state, { payload }) => {
    return {
      ...state,
      members: [...payload.data],
      membersLoading: false,
    };
  }),
  on(getTeamMembersFailure, (state) => {
    return {
      ...state,
      membersLoading: false,
    };
  }),
  on(cleanTeamMembers, (state) => {
    return {
      ...state,
      members: [],
    };
  }),
  on(removeTeamMember, (state, { memberId }) => {
    const newMembers = state.members.filter((member) => member.id !== memberId);
    return {
      ...state,
      members: newMembers,
    };
  }),
  on(addTeamMember, (state, { member }) => {
    const newMembers = [member].concat(state.members);
    return {
      ...state,
      members: newMembers,
    };
  })
);
