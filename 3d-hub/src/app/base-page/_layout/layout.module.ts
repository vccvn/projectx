import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AppUIModule } from '@app/app-ui.module';
import { RouterModule } from '@angular/router';
import { LayoutProWidgetUserComponent } from './_components/user/user.component';
import { LayoutProWidgetSwitchGroupComponent } from './_components/switch-group/switch-group.component';
import { LayoutProLogoComponent } from './_components/logo/logo.component';
import { LayoutProHeaderComponent } from './_components/header/header.component';
import { LayoutProMenuComponent } from './_components/menu/menu.component';
import { ProPageHeaderWrapperComponent } from './_components/page-header-wrapper/page-header-wrapper.component';
import { ProPageGridComponent } from './_components/page-grid/page-grid.component';
import { LayoutProHeaderWidgetComponent } from './_components/widget/widget.component';
import { LayoutProWidgetNotifyComponent } from './_components/notify/notify.component';

import { SharedModule } from '@app/_shared/shared.module';
import { FullLayoutComponent } from './full/full.component';
import { MainLayoutComponent } from './main/main.component';

import { AlainThemeModule } from '@delon/theme';
import { NoticeIconModule } from '@delon/abc/notice-icon';
import { GlobalFooterModule } from '@delon/abc/global-footer';
import { PageHeaderModule } from '@delon/abc/page-header';
import { STModule } from '@delon/abc/st';
import { SEModule } from '@delon/abc/se';
import { DelonACLModule } from '@delon/acl';
import { TagSelectModule } from '@delon/abc/tag-select';

@NgModule({
  declarations: [
    LayoutProWidgetNotifyComponent,
    FullLayoutComponent,
    MainLayoutComponent,
    LayoutProWidgetSwitchGroupComponent,
    LayoutProHeaderWidgetComponent,
    LayoutProLogoComponent,
    LayoutProHeaderComponent,
    LayoutProMenuComponent,
    ProPageHeaderWrapperComponent,
    ProPageGridComponent,
    LayoutProWidgetUserComponent,
  ],
  exports: [
    ProPageHeaderWrapperComponent,
    ProPageGridComponent,
    FullLayoutComponent,
    MainLayoutComponent,
    AlainThemeModule,
    NoticeIconModule,
    GlobalFooterModule,
    PageHeaderModule,
    STModule,
    SEModule,
    TagSelectModule,
    DelonACLModule,
  ],
  imports: [
    AppUIModule,
    RouterModule,
    CommonModule,
    SharedModule,
    AlainThemeModule,
    NoticeIconModule,
    GlobalFooterModule,
    PageHeaderModule,
    STModule,
    SEModule,
    TagSelectModule,
    DelonACLModule,
  ],
})
export class LayoutModule {}
