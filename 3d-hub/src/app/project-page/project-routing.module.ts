import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WorkspaceComponent } from './workspace/workspace.component';
import { HeaderComponent } from './header/header.component';



export const ENTRIES_COMPONENTS = [];


export const COMPONENTS = [
  WorkspaceComponent,
  HeaderComponent
  
];

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: ':id/edit',
        component: WorkspaceComponent,
      },
      {
        path: ':id/create',
        component: WorkspaceComponent,
      },
      {
        path: ':id/update',
        component: WorkspaceComponent,
      },
      {
        path: '**',
        redirectTo: '0/update',
      },
    ],
  },
];

@NgModule({
  imports: [
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule],
})
export class ProjectRoutingModule { }
