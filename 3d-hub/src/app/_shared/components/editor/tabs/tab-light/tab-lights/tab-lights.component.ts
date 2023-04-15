import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ModalConfirmService } from '@app/_shared/services/modal-confirm.service';
import { EditorIO, EditorMethods } from '../../../base/editor-io';

@Component({
    selector: 'app-tab-lights',
    templateUrl: './tab-lights.component.html',
    styleUrls: ['./tab-lights.component.scss']
})
export class TabLightsComponent extends BaseComponent implements OnInit {

    // app: TemplateEditorService = null;
    isShow: boolean = false;
    lights: any[] = [];
    lightTemplates: string[] = [
        "Ambient",
        "Directional",
        "Hemisphere",
        "Point",
        "RectArea",
        "Spot"
    ];
    height50: boolean = false;
    app: AppEditorService;

    constructor(
        private confirmService: ModalConfirmService, 
        private cd: ChangeDetectorRef,
        private events: AppEditorEventService
    ) {
        super();
        
    }

    
    initFirst(){
        this.app = this.events.app;
        this.registerEventService(this.confirmService, {
            "close": e => {
                this.changeHeight()
                this.subEvents.emit("tab.light.refresh");
            }
        })
    }
    onInit() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;
            this.registerEventService(this.app, {
                "light.deleted": l => {
                    this.loadLight();
                    this.subEvents.emit("component.checkchange");
                }
            })
        
        }
        this.activeEventServiceRegistered(this.app);
        this.activeEventServiceRegistered(this.confirmService);
        this.loadLight();
        this.isShow = true;
        this.cd.detectChanges();
    }
    onDestroy(){
        
        this.deactiveEventServiceRegistered(this.app);
        this.deactiveEventServiceRegistered(this.confirmService);
        this.isShow = false;
    }

    changeHeight(){
        this.height50 = true;
            this.cd.detectChanges();
            setTimeout(() => {
                this.height50 = false;
                this.cd.detectChanges();
                    
            }, 50);
    }

    loadLight() {
        this.lights = this.app.getLightList();
    }

    addLight(name) {
        if (this.app) {
            this.app.addLightByTemplate(name, e => {
                this.loadLight();
                this.subEvents.emit("component.checkchange");
            })
        }
    }

    deleteLight(secret_key) {
        if (this.app) {
            var name: string;
            this.lights.map(light => {
                if (light.secret_key == secret_key) {
                    name = light.name;
                }
            });

            if (name) {
                this.confirmService.showDeleteConfirm("Are you sure delete " + name + " light?", () => {
                    this.app.deleteLight(secret_key);
                })
            }
        }
    }

    clickLight(secret_key) {
        if (this.app) {
            this.app.attachLightInEditor(secret_key);
            this.app.engine.refresh();
        }
        this.subEvents.emit({
            type: "show:light.panel",
            secret_key: secret_key
        })
    }

}
