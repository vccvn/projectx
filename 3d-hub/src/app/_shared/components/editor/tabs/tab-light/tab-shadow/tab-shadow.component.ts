import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { TemplateEventsService } from '@app/template-page/_store/events.service';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { ShadowSetting, ShadowSettingDefaultData } from '@app/_3D/store/data.type';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { InpEvent } from '@app/_shared/shared.type';
import { EditorIO, EditorMethods } from '../../../base/editor-io';

@Component({
    selector: 'app-tab-shadow',
    templateUrl: './tab-shadow.component.html',
    styleUrls: ['./tab-shadow.component.scss']
})
export class TabShadowComponent extends BaseComponent implements OnInit {
    shadow: ShadowSetting = {};
    app: AppEditorService;
    constructor(
        private cd: ChangeDetectorRef,
        private events: AppEditorEventService
    ) {
        super();
    }

        
    initOnce(){
        this.app = this.events.app;
     
    }
    init() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;
        
        }
        assignValue(this.shadow, ShadowSettingDefaultData);
        assignValue(this.shadow, this.app.getShadowSetting());

        this.cd.detectChanges();
    }
    onDestroy(){
        
    }

    updateSetting(event: InpEvent) {
        this.shadow[event.name] = event.value;
        let a: any = {};
        a[event.name] = event.value;
        this.app.updateShadowSetting(a);
    }
}
