import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { MaterialSettingData } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { assignValue, objectKeys } from '@app/_core/helpers/utils';
import { ItemMeshSettings } from '@app/_store/item';
import { CollapseBaseComponent } from '../collapse-base/collapse-base.component';



@Component({
    selector: 'collapse-mesh-material',
    templateUrl: './collapse-mesh-material.component.html',
    styleUrls: ['./collapse-mesh-material.component.scss']
})
export class CollapseMeshMaterialComponent extends CollapseBaseComponent implements OnInit {
    @Input() index: number = 0;
    @Output() onUpdate = new EventEmitter<any>();
    @Output() onUpdateTitle = new EventEmitter<{ index: number, title: string }>();
    @Input() service: any = null;
    @Input() mesh: ItemMeshSettings;

    inputs: any[] = [];
    constructor(private events: AppEditorEventService, private cd: ChangeDetectorRef) {
        super();
    }


    onChangeSubEvents(){
        this.registerEventService(this.subEvents, {
            "panel.mesh.update:material": e => this.updateInputs(e)
        })
    }

    onInit(): void {
        if (this.mesh.title) {
            this.title = this.mesh.title;
        } else {
            this.title = this.mesh.name;
        }
        this.inputs = this.mesh.__inputs__.filter(i => i.editable);
    }
    updateInputs(e){
        if(e.secretKey == this.mesh.__parent_key__ && e.name == this.mesh.name){
            if(!this.mesh.data) this.mesh.data={};
            if(!this.mesh.data.material) this.mesh.data.material={};
            assignValue(this.mesh.data.material, e.data);
            
            let ns = objectKeys(e.data);
            let name = ns[0];
            // console.log(objectKeys(e.data))
            // console.log(name)
            this.mesh.__inputs__.map(inp => {
                if(inp.name == name && inp.value != e.data[name]){
                    inp.value = e.data[name];
                }
            })
            this.inputs = this.mesh.__inputs__.filter(i => i.editable);
            if(this.show){
                this.show = false;
                setTimeout(() => {
                    this.show = true;
                    this.cd.detectChanges();
                }, 10);
                
            }
            this.cd.detectChanges();
            
        }
    }
    changeHandle(event) {
        if (!this.mesh.data.material) this.mesh.data.material = {};
        this.mesh.data.material[event.name] = event.value;
        this.onUpdate.emit({
            data: this.mesh.data,
            index: this.index
        })
        this.subcribe.emit({
            name: event.name,
            value: event.value,
            index: this.mesh.index,
            settings: this.mesh.data.material
        })
    }
}