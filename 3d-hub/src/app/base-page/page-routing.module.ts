import { NgModule } from '@angular/core';

import { Routes, RouterModule } from '@angular/router';

import { DraftTemplateComponent } from './draft-template/draft-template.component';
import { HomeComponent } from './home/global-template.component';

import { SliderComponent } from './_components/slider/slider.component';
import { TemplateCardComponent } from './_components/template-card/template-card.component';
import { CarouselComponent } from './_components/carousel/carousel.component';
import { FeatureCardComponent } from './_components/feature-card/feature-card.component';
import { YourTemplateComponent } from './your-template/your-template.component';
import { YourDesignComponent } from './your-design/your-design.component';
import { SearchTemplateComponent } from './search-template/search-template.component';

import { FullLayoutComponent } from './_layout/full/full.component';
import { MainLayoutComponent } from './_layout/main/main.component';
import { PricingComponent } from './pricing/pricing.component';
import { OrganizationComponent } from './organization/organization.component';
import { DesignTabComponent } from './organization/tabs/design-tab/design-tab.component';
import { DraftTemplateTabComponent } from './organization/tabs/draf-template-tab/draft-template-tab.component';

import { FolderComponent } from './folder/folder.component';
import { FolderChildComponent } from './folder-child/folder.component';
import { CreateFolderModalComponent } from './folder/create-folder-modal/view.component';

export const ENTRIES_COMPONENTS = [CreateFolderModalComponent];

export const COMPONENTS = [
  CarouselComponent,
  SliderComponent,
  YourDesignComponent,
  DesignTabComponent,
  DraftTemplateTabComponent,
  OrganizationComponent,
  PricingComponent,
  SearchTemplateComponent,
  TemplateCardComponent,
  FeatureCardComponent,
  HomeComponent,
  DraftTemplateComponent,
  YourTemplateComponent,
  FolderComponent,
  FolderChildComponent,
];

const routes: Routes = [
  {
    path: '',
    component: MainLayoutComponent,
    children: [
      {
        path: 'home',
        component: HomeComponent,
      },
      {
        path: 'folders',
        component: FolderComponent,
      },
      {
        path: 'folders/designs',
        component: YourDesignComponent,
      },
      {
        path: 'folders/:folderId',
        component: FolderChildComponent,
      },
      {
        path: 'organization',
        component: OrganizationComponent,
      },

      {
        path: 'account',
        loadChildren: () => import('./account/account.module').then((module) => module.AccountModule),
      },
    ],
  },
  {
    path: 'pricing',
    component: FullLayoutComponent,
    children: [{ path: '', component: PricingComponent }],
  },
  {
    path: 'templates',
    component: FullLayoutComponent,
    children: [{ path: '', component: SearchTemplateComponent }],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PageRoutingModule {}
