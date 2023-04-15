import { Component, Output, EventEmitter, OnInit, ChangeDetectionStrategy, ChangeDetectorRef, Input } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';

enum TabIndex {
    Object = 0,
    Scene = 1,
    Light = 2,
    Controls = 3,
    settings  = 4
}

@Component({
    selector: 'app-template-sidebar',
    templateUrl: './sidebar.component.html',
    styleUrls: ['./sidebar.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class TemplateSidebarComponent extends BaseComponent implements OnInit {

    
    prevTab: number = TabIndex.Object;
    currentTab: number = TabIndex.Object;

    loadedObject = false;
    app: AppEditorService = null;
    constructor(private cd: ChangeDetectorRef, private events: AppEditorEventService) {
        super();
    }
    initFirst(){
        this.app = this.events.app;
    }
    onInit() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;
        }
        this.cd.detectChanges();
    }



    onChangeTab(e) {
        if(this.app && this.app.editor){
            if(e.index == TabIndex.Light){
                this.app.editor.showLightHelpers();
            }else{
                this.app.editor.hideLightHelpers();
                this.app.editor.detachLight();
            }
        }
        this.currentTab = e.index;
        
        this.cd.detectChanges();
    }

    onClickSearch(event) {
        console.log(event);
    }


}
