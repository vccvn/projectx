import { ChangeDetectionStrategy, ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';
enum TabIndex {
    Scene = 0,
    Light = 1
}
@Component({
    selector: 'app-viewer-sidebar',
    templateUrl: './viewer-sidebar.component.html',
    styleUrls: ['./viewer-sidebar.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ViewerSidebarComponent extends BaseComponent implements OnInit {
    prevTab: number = 0;
    currentTab: number = 0;
    loadedTemplate = false;
    loadedObject = false;
    mode: string = 'create';
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
        if(this.app.editor){
            this.app.editor.hideLightHelpers();
        }
        
        this.cd.detectChanges();
    }
    onChangeTab(e) {
        if (this.app && this.app.editor) {

            if (e.index == TabIndex.Light) {
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
