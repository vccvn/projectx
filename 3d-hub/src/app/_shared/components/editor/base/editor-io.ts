import { Component, Input, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { StorageService } from '@app/_core/services/storage.service';

@Component({
    template: ''
})
export abstract class EditorIO implements OnInit{
     
    @Input() app: AppEditorService = null;
    @Input() events: AppEditorEventService = null;
    @Input() storage: StorageService = null;
    oldApp: AppEditorService = null;
    oldEvents: AppEditorEventService = null;
    oldStorage: StorageService = null;
    isInited: boolean = false;

    checkAppEventService() {
        if (this.app && this.app != this.oldApp) {
            this.oldApp = this.app;
            // startAppTask()
            if (typeof this['onAppinit'] == "function") {
                this['onAppinit']()
            }
        }
        if (this.events && this.events != this.oldEvents) {
            this.oldEvents = this.events;
            if (typeof this['onEventInit'] == "function") {
                this['onEventInit']()
            }
        }

        if (this.storage && this.storage != this.oldStorage) {
            this.oldStorage = this.storage;
            if (typeof this['onStorageInit'] == "function") {
                this['onStorageInit']()
            }
        }
    }


    ngOnInit(): void{
        this.checkAppEventService();
        if (typeof this['init'] == "function") {
            this['init']()
        }
    }
}

export interface EditorMethods{
    /**
     * thược hiện các hành động giống ngOnInit
     */
    init():void
    /**
     * Hành động sẽ dc thực hiện khi app dc set lần đầu
     */
    onAppInit?():void
    /**
     * hanh dộng sẽ dc thuc hiện khi event dc set lân dau tien
     */
    onEventInit?():void

    /**
     * hanh dộng sẽ dc thuc hiện khi Storage dc set lân dau tien
     */

    onStorageInit?():void

}