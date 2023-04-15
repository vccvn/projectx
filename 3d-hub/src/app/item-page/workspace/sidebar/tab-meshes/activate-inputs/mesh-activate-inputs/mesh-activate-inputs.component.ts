import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { ItemEventService } from '@app/item-page/_store/event.service';
import { assignValue, isObject } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';



@Component({
    selector: 'mesh-activate-inputs',
    templateUrl: './mesh-activate-inputs.component.html',
    styleUrls: ['./mesh-activate-inputs.component.scss']
})
export class MeshActivateInputsComponent extends BaseComponent implements OnInit {
    @Input() mesh: any;
    @Input() index: number = 0;
    @Output() onUpdate = new EventEmitter<{
        material: any,
        index: number,
        name: string,
        value: any
    }>();
    @Output() onUpdateTitle = new EventEmitter<any>();
    @Output() onUpdateEditable = new EventEmitter<{
        index: number,
        name: string,
        status: any
    }>();

    constructor(private events: ItemEventService, private cd: ChangeDetectorRef) {
        super()
    }

    onChangeSubEvents() {
        // this.registerEventService(this.subEvents, {
        //     "panel.update:material": e => {
        //         if (e.name == this.mesh.name) {
        //             assignValue(this.mesh.data.material, e.data);
        //             setTimeout(() => {
        //                 this.cd.checkNoChanges();

        //             }, 10);
        //         }
        //     },
        //     "panel.update:title": e => {
        //         if (e.name == this.mesh.name) {
        //             this.mesh.data.title = e.title;
        //             setTimeout(() => {
        //                 this.cd.checkNoChanges();
        //             }, 10);
        //         }
        //     },
        //     "panel.update:editable": e => {
        //         if (e.name == this.mesh.name) {
        //             var index = this.mesh.editable.indexOf(e.name);
        //             if (e.status && index == -1) {
        //                 this.mesh.editable.push(e.name);
        //             }
        //             else if (!e.status && index != -1) {
        //                 this.mesh.editable.splice(index, 1);
        //             }
        //             setTimeout(() => {
        //                 this.cd.checkNoChanges();
        //             }, 10);
        //         }
        //     }
        // })


    }

    onInit(): void {
    }

    updateMaterialOfArray(event) {
        if (typeof event.index != "undefined" && typeof this.mesh.data.material[event.index] != "undefined") {
            this.mesh.data.material[event.index][event.name] = event.value;
        }
    }

    updateMaterial(event) {
        if(!isObject(this.mesh.data.material)) this.mesh.data.material = {};
        this.mesh.data.material[event.name] = event.value;
        this.onUpdate.emit({
            material: this.mesh.data.material,
            index: this.index,
            name: event.name,
            value: event.value
        })
    }

    updateMeshTitle(event) {
        // console.log(this.data.title);
        // return;
        this.mesh.data.title = event.value;
        this.onUpdateTitle.emit({
            index: this.index,
            title: this.mesh.data.title
        })
    }

    updateEditable(event) {
        this.onUpdateEditable.emit({
            index: this.index,
            name: event.name,
            status: event.status
        })
    }

}
