import { NgModule } from '@angular/core';

import { Routes, RouterModule } from '@angular/router';

import { SettingComponent } from './account.component';
import { ProfileComponent } from './profile/profile.component';
import { NotificationListComponent } from './notification/list/list.component';
import { ChangePasswordComponent } from './change-password/change-password.component';

export const ENTRIES_COMPONENTS = [];

export const COMPONENTS = [SettingComponent, ProfileComponent, ChangePasswordComponent, NotificationListComponent];

const routes: Routes = [
  {
    path: '',
    component: SettingComponent,
    children: [
      {
        path: '',
        pathMatch: 'full',
        redirectTo: 'profile',
      },
      {
        path: 'profile',
        component: ProfileComponent,
      },
      {
        path: 'transactions',
        component: NotificationListComponent,
      },
      {
        path: 'notifications',
        component: NotificationListComponent,
      },
      {
        path: 'change-password',
        component: ChangePasswordComponent,
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class SettingRoutingModule {}
