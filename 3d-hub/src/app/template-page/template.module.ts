import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { EffectsModule } from '@ngrx/effects';
import { StoreModule } from '@ngrx/store';

import { SharedModule } from '../_shared/shared.module';
import { AppUIModule } from '../app-ui.module';
import { AuthModule } from '../auth/auth.module';

import { TemplateRoutingModule, COMPONENTS, ENTRIES_COMPONENTS } from './template-routing.module';
import { DragDropModule } from '@angular/cdk/drag-drop';
import { reducers, effects, services } from './_store';
import { NzCollapseModule } from 'ng-zorro-antd/collapse';

@NgModule({
  declarations: [...COMPONENTS, ...ENTRIES_COMPONENTS],
  imports: [
    DragDropModule,
    AuthModule,
    CommonModule,
    AppUIModule,
    SharedModule,
    TemplateRoutingModule,
    StoreModule.forFeature('templateStore', reducers),
    EffectsModule.forFeature(effects),
    NzCollapseModule,
  ],
  entryComponents: ENTRIES_COMPONENTS,
  providers: [...services],
})
export class TemplateModule {}
