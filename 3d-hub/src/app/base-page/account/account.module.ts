import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { EffectsModule } from '@ngrx/effects';
import { StoreModule } from '@ngrx/store';

import { LayoutModule } from '../_layout/layout.module';
import { AuthModule } from '@app/auth/auth.module';
import { AppUIModule } from '@app/app-ui.module';
import { SharedModule } from '@app/_shared/shared.module';

import { SettingRoutingModule, COMPONENTS, ENTRIES_COMPONENTS } from './account-routing.module';

import { reducers, effects, services } from '@app/base-page/_store';

@NgModule({
  declarations: [...COMPONENTS, ...ENTRIES_COMPONENTS],
  imports: [
    AuthModule,
    CommonModule,
    AppUIModule,
    LayoutModule,
    SharedModule,
    SettingRoutingModule,
    StoreModule.forFeature('pageStore', reducers),
    EffectsModule.forFeature(effects),
  ],
  entryComponents: ENTRIES_COMPONENTS,
  providers: [...services],
})
export class AccountModule {}
