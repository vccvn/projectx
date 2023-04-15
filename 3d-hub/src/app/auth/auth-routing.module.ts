import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { UnAuthGuard } from '../_core/guards';
import { LayoutAuthComponent } from './layout/layout.component';

const routes: Routes = [
  {
    path: '',
    component: LayoutAuthComponent,
    canActivate: [UnAuthGuard],
    children: [
      {
        path: 'login',
        component: LoginComponent,
      },
    ],
  },
];

export const COMPONENTS = [LoginComponent, LayoutAuthComponent];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AuthRoutingModule {}
