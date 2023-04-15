import { createSelector } from '@ngrx/store';
import * as fromApp from '../reducers';
import * as fromTeam from '.';

export const getTeamState = createSelector(fromApp.selectContainerState, (state: fromApp.PageState) => state.teams);

export const getTeams = createSelector(getTeamState, (state: fromTeam.TeamState) => state.list);

export const getTeam = createSelector(getTeamState, (state: fromTeam.TeamState) => state.item);

export const getTeamsPagination = createSelector(getTeamState, (state: fromTeam.TeamState) => state.pagination);

export const getTeamsParams = createSelector(getTeamState, (state: fromTeam.TeamState) => state.params);

export const getTeamsLoading = createSelector(getTeamState, (state: fromTeam.TeamState) => state.loading);

export const getTeamView = createSelector(getTeamState, (state: fromTeam.TeamState) => state.modal);

export const getTeamMembers = createSelector(getTeamState, (state: fromTeam.TeamState) => state.members);

export const getTeamMembersLoading = createSelector(getTeamState, (state: fromTeam.TeamState) => state.membersLoading);

export const getTeamMembersPagination = createSelector(getTeamState, (state: fromTeam.TeamState) => {
  const totalRecords = state.members.length;
  const limit = 100;
  const page = 0;
  return { totalRecords, limit, page };
});
