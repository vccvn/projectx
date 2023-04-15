import { ActionReducerMap, createFeatureSelector, MetaReducer } from '@ngrx/store';
import { Params, RouterStateSnapshot } from '@angular/router';
import { Injectable } from '@angular/core';

import { RouterStateSerializer } from '@ngrx/router-store';
import * as fromRouter from '@ngrx/router-store';
import { environment } from '@env/environment';

export interface RouterStateUrl {
  url: string;
  queryParams: Params;
  params: Params;
}

export interface GlobalState {
  routerReducer: fromRouter.RouterReducerState<RouterStateUrl>;
}

export const reducers: ActionReducerMap<GlobalState> = {
  routerReducer: fromRouter.routerReducer,
};

export const getRouterState = createFeatureSelector<fromRouter.RouterReducerState<RouterStateUrl>>('routerReducer');

/**
 * By default, @ngrx/store uses combineReducers with the reducer map to compose
 * the root meta-reducer. To add more meta-reducers, provide an array of meta-reducers
 * that will be composed to form the root meta-reducer.
 */
export const metaReducers: MetaReducer<GlobalState>[] = !environment.production ? [] : [];

@Injectable()
export class CustomRouterStateSerializer implements RouterStateSerializer<RouterStateUrl> {
  serialize(routerState: RouterStateSnapshot): RouterStateUrl {
    let route = routerState.root;

    while (route.firstChild) {
      route = route.firstChild;
    }

    const {
      url,
      root: { queryParams },
    } = routerState;
    const { params } = route;

    // Only return an object including the URL, params and query params
    // instead of the entire snapshot
    return { url, params, queryParams };
  }
}
