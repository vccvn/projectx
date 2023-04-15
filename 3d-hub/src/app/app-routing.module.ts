import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { PreloadAllModules } from '@angular/router';
import { AuthGuard } from './_core/guards';

const routes: Routes = [
  // {
  //   path: '',
  //   pathMatch: 'full',
  //   redirectTo: 'project/list',
  // },
  // {
  //   path: '',
  //   loadChildren: () => import('./base-page/page.module').then((m) => m.PageModule),
  //   canActivate: [AuthGuard],
  // },
  {
    path: 'auth',
    loadChildren: () => import('./auth/auth.module').then((m) => m.AuthModule),
  },
  {
    path: 'admin/3d/items',
    loadChildren: () => import('./item-page/item.module').then((m) => m.ItemModule),
    // canActivate: [AuthGuard],
  },
  {
    path: 'admin/3d/templates',
    loadChildren: () => import('./template-page/template.module').then((m) => m.TemplateModule),
    // canActivate: [AuthGuard],
  },
  {
    path: 'admin/3d/projects',
    loadChildren: () => import('./project-page/project.module').then((m) => m.ProjectModule),
    // canActivate: [AuthGuard],
  },
  // {
  //   path: 'view',
  //   loadChildren: () => import('./viewer-page/viewer.module').then((m) => m.ViewerModule),
  //   canActivate: [AuthGuard],
  // },
  {
    path: '**',
    redirectTo: 'admin/3d/items/0/edit',
  },
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, {
      enableTracing: false,
      relativeLinkResolution: 'legacy',
      preloadingStrategy: PreloadAllModules,
    }),
  ],
  exports: [RouterModule],
})
export class AppRoutingModule {}
