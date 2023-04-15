import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { WorkspaceComponent } from './workspace/workspace.component';
import { HeaderComponent } from './workspace/header/header.component';



export const ENTRIES_COMPONENTS = [];


export const COMPONENTS = [
  WorkspaceComponent,
  HeaderComponent,
  
];

const routes: Routes = [
  {
    path: '',
    children: [
      {
        path: ':id',
        component: WorkspaceComponent,
      },
      {
        path: '**',
        redirectTo: '/0',
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
export class ViewerRoutingModule { }
