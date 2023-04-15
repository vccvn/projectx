import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { TemplateEventsService } from '@app/template-page/_store/events.service';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { ControlDefaultSetting, ControlSetting } from '@app/_3D/store/data.type';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { EditorToolbarService } from '@app/_shared/components/viewport/editor-toolbar/editor-toolbar.service';
import { InpEvent } from '@app/_shared/shared.type';
import { EditorIO, EditorMethods } from '../../../base/editor-io';

@Component({
    selector: 'app-tab-control',
    templateUrl: './tab-control.component.html',
    styleUrls: ['./tab-control.component.scss']
})
export class TabControlComponent extends BaseComponent implements OnInit {

    controls: ControlSetting = {};
    app: AppEditorService;
    constructor(
        private cd: ChangeDetectorRef,
        private events: AppEditorEventService
    ) {
        super();
    }

    initFirst(){
        this.app = this.events.app;
    }
    onInit() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;

        }
        assignValue(this.controls, ControlDefaultSetting);
        assignValue(this.controls, this.app.getControlSetting());
        this.cd.detectChanges();
    }
    onDestroy(){
        
    }

    updateControlSetting(event: InpEvent){
        this.controls[event.name] = event.value;
        setTimeout(() => {
            this.app.updateControlSetting(this.controls);
        }, 10);
    }
}
