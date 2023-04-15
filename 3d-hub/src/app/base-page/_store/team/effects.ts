import { Injectable } from '@angular/core';
import { Actions, ofType, createEffect } from '@ngrx/effects';
import { of } from 'rxjs';
import {
  map,
  switchMap,
  catchError,
  withLatestFrom,
  concatMap,
} from 'rxjs/operators';

import { TeamService } from './service';
import { TeamsActions } from './actions';

import { Store } from '@ngrx/store';
import * as fromBussiness from '.';
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
  getTeamMembers,
  getTeamMembersSuccess,
  getTeamMembersFailure,
} = TeamsActions;

@Injectable()
export class TeamEffects {
  constructor(
    private actions: Actions,
    private modelService: TeamService,
    private store$: Store<fromBussiness.TeamState>
  ) {}

  getList$ = createEffect(() =>
    this.actions.pipe(
      ofType(getTeams),
      switchMap((pramas) => {
        return this.modelService.getAll(pramas.payload).pipe(
          map((payload) => getTeamsSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getTeamsFailure());
          })
        );
      })
    )
  );

  getOne$ = createEffect(() =>
    this.actions.pipe(
      ofType(getTeam),
      switchMap((pramas) => {
        return this.modelService.get(pramas.payload).pipe(
          map((payload) => getTeamSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getTeamFailure());
          })
        );
      })
    )
  );

  create$ = createEffect(() =>
    this.actions.pipe(
      ofType(createTeam),
      switchMap((pramas) => {
        return this.modelService.create(pramas.payload).pipe(
          map((payload) => createTeamSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(createTeamFailure({ payload: err }));
          })
        );
      })
    )
  );

  update$ = createEffect(() =>
    this.actions.pipe(
      ofType(updateTeam),
      switchMap((pramas) => {
        return this.modelService.update(pramas.payload).pipe(
          map((payload) => updateTeamSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(updateTeamFailure({ payload: err }));
          })
        );
      })
    )
  );

  delete$ = createEffect(() =>
    this.actions.pipe(
      ofType(deleteTeam),
      switchMap((pramas) => {
        return this.modelService.delete(pramas.payload).pipe(
          map((payload) => deleteTeamSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(deleteTeamFailure({ payload: err }));
          })
        );
      })
    )
  );

  changeSuccess$ = createEffect(() =>
    this.actions.pipe(
      ofType(deleteTeamSuccess, updateTeamSuccess, createTeamSuccess),
      concatMap((action) =>
        of(action).pipe(
          withLatestFrom(this.store$.select(fromBussiness.getTeamsParams))
        )
      ),
      map(([action, params]) => {
        const payload = { ...params };
        return getTeams({ payload });
      })
    )
  );

  getMembers$ = createEffect(() =>
    this.actions.pipe(
      ofType(getTeamMembers),
      switchMap((pramas) => {
        return this.modelService.getMembers(pramas.teamId).pipe(
          map((payload) => getTeamMembersSuccess({ payload })),
          catchError((err) => {
            console.error(err);
            return of(getTeamMembersFailure());
          })
        );
      })
    )
  );
}
