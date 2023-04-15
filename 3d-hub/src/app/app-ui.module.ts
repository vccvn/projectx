import { NgModule } from '@angular/core';
import { registerLocaleData } from '@angular/common';
import en from '@angular/common/locales/en';

import { ToastrModule, ToastContainerModule } from 'ngx-toastr';
import { Angulartics2Module } from 'angulartics2';

import { NzNotificationModule } from 'ng-zorro-antd/notification';
import { NzRadioModule } from 'ng-zorro-antd/radio';
import { NzButtonModule } from 'ng-zorro-antd/button';
import { NzTabsModule } from 'ng-zorro-antd/tabs';
import { NzLayoutModule } from 'ng-zorro-antd/layout';
import { NzPopoverModule } from 'ng-zorro-antd/popover';
import { NzSliderModule } from 'ng-zorro-antd/slider';
import { NzSwitchModule } from 'ng-zorro-antd/switch';
import { NzModalModule } from 'ng-zorro-antd/modal';
import { NzIconModule } from 'ng-zorro-antd/icon';
import { NzMessageModule } from 'ng-zorro-antd/message';
import { NzAlertModule } from 'ng-zorro-antd/alert';
import { NzTransferModule } from 'ng-zorro-antd/transfer';
import { NzTimelineModule } from 'ng-zorro-antd/timeline';
import { NzCheckboxModule } from 'ng-zorro-antd/checkbox';
import { NzPopconfirmModule } from 'ng-zorro-antd/popconfirm';
import { NzEmptyModule } from 'ng-zorro-antd/empty';
import { NzPaginationModule } from 'ng-zorro-antd/pagination';
import { NzDatePickerModule } from 'ng-zorro-antd/date-picker';
import { NzInputModule } from 'ng-zorro-antd/input';
import { NzInputNumberModule } from 'ng-zorro-antd/input-number';
import { NzStatisticModule } from 'ng-zorro-antd/statistic';
import { NzDrawerModule } from 'ng-zorro-antd/drawer';
import { NzSkeletonModule } from 'ng-zorro-antd/skeleton';
import { NzProgressModule } from 'ng-zorro-antd/progress';
import { NzBadgeModule } from 'ng-zorro-antd/badge';
import { NzPageHeaderModule } from 'ng-zorro-antd/page-header';
import { NzListModule } from 'ng-zorro-antd/list';
import { NzTagModule } from 'ng-zorro-antd/tag';
import { NzAvatarModule } from 'ng-zorro-antd/avatar';
import { NzBreadCrumbModule } from 'ng-zorro-antd/breadcrumb';
import { NzSpinModule } from 'ng-zorro-antd/spin';
import { NzDividerModule } from 'ng-zorro-antd/divider';
import { NzFormModule } from 'ng-zorro-antd/form';
import { NzToolTipModule } from 'ng-zorro-antd/tooltip';
import { NzRateModule } from 'ng-zorro-antd/rate';
import { NzDescriptionsModule } from 'ng-zorro-antd/descriptions';
import { NzTableModule } from 'ng-zorro-antd/table';
import { NzDropDownModule } from 'ng-zorro-antd/dropdown';
import { NzUploadModule } from 'ng-zorro-antd/upload';
import { NzSelectModule } from 'ng-zorro-antd/select';
import { NzCardModule } from 'ng-zorro-antd/card';
import { en_US, NZ_I18N } from 'ng-zorro-antd/i18n';
import { NzPipesModule } from 'ng-zorro-antd/pipes';
import { NzAffixModule } from 'ng-zorro-antd/affix';

registerLocaleData(en);

const ANT_MODULES = [
    NzAffixModule,
    NzCardModule,
    NzSelectModule,
    NzUploadModule,
    NzDropDownModule,
    NzTableModule,
    NzDescriptionsModule,
    NzToolTipModule,
    NzRateModule,
    NzFormModule,
    NzDividerModule,
    NzSpinModule,
    NzButtonModule,
    NzBreadCrumbModule,
    NzAvatarModule,
    NzTagModule,
    NzListModule,
    NzPageHeaderModule,
    NzBadgeModule,
    NzProgressModule,
    NzSkeletonModule,
    NzDrawerModule,
    NzStatisticModule,
    NzInputModule,
    NzInputNumberModule,
    NzDatePickerModule,
    NzPaginationModule,
    NzEmptyModule,
    NzPopconfirmModule,
    NzCheckboxModule,
    NzTimelineModule,
    NzTransferModule,
    NzAlertModule,
    NzMessageModule,
    NzSliderModule,
    NzSwitchModule,
    NzModalModule,
    NzIconModule,
    NzPopoverModule,
    NzLayoutModule,
    NzRadioModule,
    NzTabsModule,
    NzNotificationModule,
    NzPipesModule,
];
import { NgxInfiniteGridModule } from '@egjs/ngx-infinitegrid';

@NgModule({
    imports: [
        ToastrModule.forRoot({
            preventDuplicates: true,
        }),
        Angulartics2Module.forRoot(),
        ToastContainerModule,
        ...ANT_MODULES,
        NgxInfiniteGridModule,
    ],
    exports: [Angulartics2Module, ...ANT_MODULES, NgxInfiniteGridModule],
    providers: [{ provide: NZ_I18N, useValue: en_US }],
})
export class AppUIModule { }
