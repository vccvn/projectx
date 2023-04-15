import { createAction, props } from '@ngrx/store';

import { TeamModel } from './model';
import { TeamResultsModel, TeamResultModel } from './results.model';
import { UserResultsModel, UserModel } from '../user';

const getTeams = createAction('[TEAM] Get Teams', props<{ payload: any }>());

const getTeamsSuccess = createAction(
  '[TEAM] Get Teams Success',
  props<{ payload: TeamResultsModel }>()
);

export const getTeamsFailure = createAction('[TEAM] Get Teams Faild');

const getTeam = createAction('[TEAM] Get Team', props<{ payload: any }>());

const getTeamSuccess = createAction(
  '[TEAM] Get Team Success',
  props<{ payload: TeamResultModel }>()
);

export const getTeamFailure = createAction('[TEAM] Get Team Faild');

const createTeam = createAction(
  '[TEAM] Create Team',
  props<{ payload: TeamModel }>()
);

const createTeamSuccess = createAction(
  '[TEAM] Create Team Success',
  props<{ payload: TeamResultModel }>()
);

export const createTeamFailure = createAction(
  '[TEAM] Create Team Faild',
  props<{ payload: TeamResultModel }>()
);

const updateTeam = createAction(
  '[TEAM] Update Team',
  props<{ payload: TeamModel }>()
);

const updateTeamSuccess = createAction(
  '[TEAM] Update Team Success',
  props<{ payload: TeamResultModel }>()
);

export const updateTeamFailure = createAction(
  '[TEAM] Update Team Faild',
  props<{ payload: TeamResultModel }>()
);

const deleteTeam = createAction(
  '[TEAM] Delete Team',
  props<{ payload: number }>()
);

const deleteTeamSuccess = createAction(
  '[TEAM] Delete Team Success',
  props<{ payload: TeamResultModel }>()
);

export const deleteTeamFailure = createAction(
  '[TEAM] Delete Team Faild',
  props<{ payload: TeamResultModel }>()
);

export const openTeamView = createAction('[TEAM] Open Team View');

const getTeamMembers = createAction(
  '[TEAM] Get Team Members',
  props<{ teamId: number }>()
);

const getTeamMembersSuccess = createAction(
  '[TEAM] Get Team Members Success',
  props<{ payload: UserResultsModel }>()
);

export const getTeamMembersFailure = createAction(
  '[TEAM] Get Team Members Faild'
);

const cleanTeamMembers = createAction('[TEAM] Clean Team Members');

const removeTeamMember = createAction(
  '[TEAM] Remove Team Member',
  props<{ memberId: number }>()
);

const addTeamMember = createAction(
  '[TEAM] Add Team Member',
  props<{ member: UserModel }>()
);

export const TeamsActions = {
  addTeamMember,
  removeTeamMember,
  cleanTeamMembers,
  getTeamMembers,
  getTeamMembersSuccess,
  getTeamMembersFailure,
  openTeamView,
  getTeams,
  getTeamsSuccess,
  getTeamsFailure,
  getTeam,
  getTeamSuccess,
  getTeamFailure,
  createTeam,
  createTeamSuccess,
  createTeamFailure,
  updateTeam,
  updateTeamSuccess,
  updateTeamFailure,
  deleteTeam,
  deleteTeamSuccess,
  deleteTeamFailure,
};
