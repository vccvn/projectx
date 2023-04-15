import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Materials } from '@app/_3D/libs/three.libs';
import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { assignValue, isEmpty, Str } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
    selector: 'material-activate-inputs',
    templateUrl: './material-activate-inputs.component.html',
    styleUrls: ['./material-activate-inputs.component.scss']
})
export class MaterialActivateInputsComponent extends BaseComponent implements OnInit {
    @Input() material: any;
    @Input() settings: any;
    @Input() editable: any[];
    @Input() index: number;
    @Input() isArray: boolean = false;
    @Output() onUpdate = new EventEmitter<{name:string, value:any, editable?:boolean, index?:number, isArray?:boolean}>();
    @Output() updateEditable = new EventEmitter<{name:string, status:boolean, index?:number, isArray?:boolean}>();

    data: any = {};

    inputs: any[] = [];
    types: any[] = [];
    type: string = 'basic';
    constructor(private itemEditor: ItemEditorService) {
        super()
        this.types.splice(0);
        for (const value in Materials.config.options) {
            if (Object.prototype.hasOwnProperty.call(Materials.config.options, value)) {
                const label = Materials.config.options[value];
                this.types.push({value, label});
            }
        }
    }

    onInit(): void {

        
        this.data = Materials.getPropData(this.material);

        assignValue(this.data, this.settings);
        this.setType(this.data.type || this.settings.type || this.material.type);
        if(!this.settings || isEmpty(this.settings)) this.settings = {};
    }

    update(name:string, value:any, editable?:boolean, index?:number){
        this.onUpdate.emit({
            name,
            value,
            editable,
            index,
            isArray: this.isArray
        })
    }

    setType(type:string){
        var _type = Str.replace(String(type).toLowerCase(), ['mesh', 'material'], '');
        if(typeof Materials.config.options[_type] != "undefined"){
            this.type = _type;
            this.inputs = Materials.getMaterialInputs(_type, this.material, this.data, this.editable);
        }
    }
    changeType(event){
        this.setType(event.value);
        this.update('type', event.value);

    }

    toggleEditable(event){
        if(event.status){
            if(this.editable.indexOf(event.name) === -1){
                this.editable.push(event.name);
                this.activeEditavle(event.name);
            }
        }else{
            var i = this.editable.indexOf(event.name);
            if(i !== -1){
                this.editable.splice(i, 1);
                this.deactiveEditavle(event.name);
            }
        }

        this.updateEditable.emit({
            name:event.name,
            status: event.status,
            index: this.index,
            isArray: this.isArray
        })

    }

    activeEditavle(name:string){
        for (let index = 0; index < this.inputs.length; index++) {
            const input = this.inputs[index];
            if(input.name == name) input.editable = true;
            
        }
    }
    deactiveEditavle(name:string){
        for (let index = 0; index < this.inputs.length; index++) {
            const input = this.inputs[index];
            if(input.name == name) input.editable = false;
            
        }
    }

    onChangeHandle(event){
        this.data[event.name] = event.value;
        this.settings[event.name] = event.value;
        this.update(event.name, event.value, event.editable);
    }
}
