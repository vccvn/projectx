import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ItemEventService } from '@app/item-page/_store/event.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
    selector: 'app-panel-mesh-settings',
    templateUrl: './panel-mesh-settings.component.html',
    styleUrls: ['./panel-mesh-settings.component.scss']
})
export class PanelMeshSettingsComponent extends BaseComponent implements OnInit {
    title: string = "Mesh";
    mesh: any = null;

    isShow: boolean = false;



    constructor(private events: ItemEventService, private cd: ChangeDetectorRef) {
        super();
    }

    onChangeSubEvents() {
        this.registerEventService(this.subEvents, {
            showmeshpanel: e => this.showPanel(e.mesh),
            hidemeshpanel: e => this.hidePanel()
        });
    }



    onInit(): void {

    }

    showPanel(mesh) {
        console.log(mesh)
        if(this.isShow){
            this.isShow = false;
            this.mesh = null;
            setTimeout(() => {
                this.asyncMeshSetting(mesh);
                this.isShow = true;
            }, 10);
        }else{
            this.asyncMeshSetting(mesh);
            this.isShow = true;
        }
        
    }
    hidePanel() {

    }
    asyncMeshSetting(mesh) {
        this.mesh = mesh;
        this.title = mesh.title || mesh.name || "Mesh"
        this.cd.detectChanges();
    }

    updateMaterial(event) {
        if(!this.mesh.data) this.mesh.data = {};
        if(!this.mesh.data.material) this.mesh.data.material = {};
        
        this.mesh.data.material[event.name] = event.value;

        var app = this.subEvents.app;
        var update:any = {};
        update[event.name] = event.value
        app.updateMeshMaterial(this.mesh.name, update);
        
        this.subEvents.emit({
            type: "panel.update:material",
            name: this.mesh.name,
            data: update
        })
        

    }

    updateEditable(event) {
        var app = this.subEvents.app;
        
        app.updateEditable(this.mesh.name, event.name, event.status);

        var index = this.mesh.editable.indexOf(event.name);
        if(event.status && index == -1){
            this.mesh.editable.push(event.name);
        }
        else if(!event.status && index != -1){
            this.mesh.editable.splice(index, 1);
        }


        
        this.subEvents.emit({
            type: "panel.update:editable",
            name: this.mesh.name,
            inpName: event.name,
            status: event.status
            
        })
        
        
    }
    updateMeshTitle(event) {
        this.title = this.mesh.title = event.value;
        var app = this.subEvents.app;
        app.updateMeshTitle(this.mesh.name, event.value);
        this.subEvents.emit({
            type: "panel.update:title",
            name: this.mesh.name,
            title: event.value
        })

    }
    close(){
        this.isShow = false;
    }
    onDone() {
        this.isShow = false;

    }
}
