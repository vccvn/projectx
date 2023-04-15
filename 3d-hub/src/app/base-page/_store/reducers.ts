import { ActionReducerMap, createFeatureSelector } from '@ngrx/store';

import * as formUsers from './user/reducer';
import * as fromSettings from './setting/reducer';
import * as fromTeam from './team/reducer';

import * as fromCart from './cart/reducer';
import * as fromFolder from './folder/reducer';
import * as fromNotification from './notification/reducer';
import * as fromTemplate from './template/reducer';
import * as fromDraftTemplate from './drafttemplate/reducer';
import * as fromDocument from './document/reducer';

export interface PageState {
  users: formUsers.UserState;
  folders: fromFolder.FolderState;
  settings: fromSettings.State;
  teams: fromTeam.TeamState;
  carts: fromCart.CartState;
  notifications: fromNotification.NotificationState;
  templates: fromTemplate.TemplateState;
  drafttemplates: fromDraftTemplate.DraftTemplateState;
  documents: fromDocument.DocumentState;
}

export const reducers: ActionReducerMap<PageState> = {
  users: formUsers.reducer,
  folders: fromFolder.reducer,
  settings: fromSettings.reducer,
  teams: fromTeam.reducer,
  carts: fromCart.reducer,
  notifications: fromNotification.reducer,
  templates: fromTemplate.reducer,
  drafttemplates: fromDraftTemplate.reducer,
  documents: fromDocument.reducer,
};

export const selectContainerState = createFeatureSelector<PageState>('pageStore');
