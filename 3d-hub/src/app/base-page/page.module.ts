import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { EffectsModule } from '@ngrx/effects';
import { StoreModule } from '@ngrx/store';

import { SharedModule } from '../_shared/shared.module';
import { AppUIModule } from '../app-ui.module';
import { AuthModule } from '../auth/auth.module';
import { LayoutModule } from './_layout/layout.module';
import { PageRoutingModule, COMPONENTS, ENTRIES_COMPONENTS } from './page-routing.module';

import { reducers, effects, services } from './_store';
import { NgxFlickingModule } from '@egjs/ngx-flicking';
@NgModule({
  declarations: [...COMPONENTS, ...ENTRIES_COMPONENTS],
  imports: [
    LayoutModule,
    AuthModule,
    CommonModule,
    AppUIModule,
    SharedModule,
    PageRoutingModule,
    NgxFlickingModule,
    StoreModule.forFeature('pageStore', reducers),
    EffectsModule.forFeature(effects),
  ],
  entryComponents: ENTRIES_COMPONENTS,
  providers: [...services],
})
export class PageModule {}
