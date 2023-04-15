import { Component, Output, EventEmitter, OnInit, ChangeDetectionStrategy, ChangeDetectorRef, Input } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';

enum TabIndex {
    CreateForm = 0,
    Object = 1,
    Scene = 2,
    Light = 3,
    Controls = 4,
    settings = 5
}
enum TabIndex2 {
    Object = 0,
    Scene = 1,
    Light = 2,
    Controls = 3,
    settings = 4
}
@Component({
    selector: 'app-project-sidebar',
    templateUrl: './project-sidebar.component.html',
    styleUrls: ['./project-sidebar.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ProjectSidebarComponent extends BaseComponent implements OnInit {

    prevTab: number = 0;
    currentTab: number = 0;

    loadedTemplate = false;
    loadedObject = false;

    mode: string = 'create';

    isInit : boolean = false;
    app: AppEditorService;
    constructor(private cd: ChangeDetectorRef, private storage: AppEditorStorageService, private events: AppEditorEventService) {
        super();
    }
    initFirst(){
        this.app = this.events.app;
        this.storage.subcribe("editMode", mode => {
            this.mode = mode;
            if(this.isFocus){
                this.cd.detectChanges();
            }
        }, true);
    }
    onInit() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;
        }
        this.cd.detectChanges();
    }

    onChangeTab(e) {
        if (this.app && this.app.editor) {
            
            if ((this.mode == "create" && e.index == TabIndex.Light) || (this.mode == "update" && e.index == TabIndex2.Light)) {
                this.app.editor.showLightHelpers();
            } else {
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