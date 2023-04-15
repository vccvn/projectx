import * as fromAuth from './auth.reducer';
import { createSelector } from '@ngrx/store';

export const getIsAuthenticating = createSelector(fromAuth.selectAuthState, (state: fromAuth.AuthState) => state.isAuthenticating);
