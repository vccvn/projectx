import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WorkspaceComponent } from './workspace/workspace.component';
import { HeaderComponent } from './header/header.component';
import { ListComponent } from './list/list.component';



export const ENTRIES_COMPONENTS = [];


export const COMPONENTS = [
  WorkspaceComponent,
  HeaderComponent,
  ListComponent
];

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: ':id/edit',
        component: WorkspaceComponent,
      },
      // {
      //   path: ':id/update',
      //   component: WorkspaceComponent,
      // },
      // {
      //   path: 'create',
      //   component: WorkspaceComponent,
      // },
      // {
      //   path: 'list',
      //   component: ListComponent,
      // },
      // {
      //   path: '**',
      //   redirectTo: 'list',
      // },
    ],
  },
];

@NgModule({
  imports: [
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule],
})
export class TemplateRoutingModule { }
