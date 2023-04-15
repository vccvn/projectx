import { Injectable } from '@angular/core';
import { Actions, Effect, ofType } from '@ngrx/effects';
import { map, switchMap, catchError, tap } from 'rxjs/operators';
import * as authActions from './auth.actions';
import { AuthenticationService } from '../services';
import { Router } from '@angular/router';
import { Observable, of } from 'rxjs';
import { SettingService } from '@app/_core/services/setting/setting.service';

const { AuthActionTypes } = authActions;

@Injectable()
export class AuthEffects {
  constructor(
    private actions$: Actions<authActions.AuthActions>,
    private authenticationService: AuthenticationService,
    private settingService: SettingService,
    private router: Router
  ) {}

  @Effect()
  login$: Observable<any> = this.actions$.pipe(
    ofType(AuthActionTypes.LOGIN),
    map((action: authActions.Login) => action.payload),
    switchMap((payload) => {
      return this.authenticationService.login(payload.email, payload.password).pipe(
        map((user) => new authActions.LoginSuccess(user)),
        catchError((error) => {
          return of(new authActions.LoginFailure({ error }));
        })
      );
    })
  );

  @Effect({ dispatch: false })
  loginSuccess$: Observable<any> = this.actions$.pipe(
    ofType(AuthActionTypes.LOGIN_SUCCESS),
    tap((res) => {
      this.settingService.setUser(res.payload);
      this.router.navigate(['p/teams']);
    })
  );
}
