import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { BaseComponent } from '../../base/base.component';

@Component({
    selector: 'app-panel-mesh-customize',
    templateUrl: './panel-mesh-customize.component.html',
    styleUrls: ['./panel-mesh-customize.component.scss']
})
export class PanelMeshCustomizeComponent extends BaseComponent implements OnInit {
    title: string = "Mesh";
    mesh: any = null;

    isShow: boolean = false;

    inputs: any[] = [];


    constructor(private events: AppEditorEventService, private cd: ChangeDetectorRef) {
        super();
    }

    onChangeSubEvents() {
        this.registerEventService(this.subEvents, {
            "editor.select:mesh": e => this.showPanel(e.mesh),
            hidemeshpanel: e => this.hidePanel()
        });
    }



    onInit(): void {

    }

    showPanel(mesh) {
        if (!(mesh && mesh.editable && mesh.editable.length)) return;
        if (this.isShow) {
            this.isShow = false;
            this.mesh = null;
            setTimeout(() => {
                this.asyncMeshSetting(mesh);
                this.isShow = true;
            }, 10);
        } else {
            this.asyncMeshSetting(mesh);
            this.isShow = true;
        }

    }
    hidePanel() {

    }
    asyncMeshSetting(mesh) {
        this.mesh = mesh;
        
        this.title = mesh.title || mesh.name || "name";

        this.inputs = mesh.__inputs__.filter(i=>i.editable);
        this.cd.detectChanges();
    }

    updateMaterial(event) {
        if (!this.mesh.data) this.mesh.data = {};
        if (!this.mesh.data.material) this.mesh.data.material = {};

        this.mesh.data.material[event.name] = event.value;

        var app = this.subEvents.app;
        var update: any = {};
        update[event.name] = event.value
        app.updateModelMeshMaterial(this.mesh.__parent__key__, this.mesh.name, update);


        this.subEvents.emit({
            type: "panel.mesh.update:material",
            name: this.mesh.name,
            data: update,
            secretKey: this.mesh.__parent__key__
        })
    }



    close() {
        this.isShow = false;
    }
    onDone() {
        this.isShow = false;

    }
}
