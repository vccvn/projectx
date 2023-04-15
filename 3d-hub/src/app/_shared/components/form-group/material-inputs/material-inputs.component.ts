import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Materials } from '@app/_3D/libs/three.libs';
import { isObject, isString, Str } from '@app/_core/helpers/utils';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
    selector: 'material-inputs',
    templateUrl: './material-inputs.component.html',
    styleUrls: ['./material-inputs.component.scss']
})
export class MaterialInputsComponent implements OnInit {
    @Input() material: {
        type: string,
        [propKey: string]: any
    } = null;
    @Input() settings: {
        type: string,
        [propKey: string]: any
    };

    @Output() subcribe = new EventEmitter<any>();

    types: any[] = [];
    type: string = 'basic';

    
    inputs: any[] = [];

    constructor() { }

    emit(name:string){
        this.subcribe.emit({
            name: name,
            value: this.settings[name],
            settings: this.settings,
            material:this.material
        })
    }

    ngOnInit(): void {
        if (!isObject(this.settings)) {
            this.settings = {
                type: (this.material?this.material.type:"basic")
            }
        }else if(!isString(this.settings.type) || !Materials.getMaterialType(this.material.type)){
            this.settings.type = this.material?this.material.type:"basic";
        }
        this.settings.type = Materials.getMaterialType(this.settings.type)

        this.settings.name = this.settings.name || this.material.name || "";
        
        this.types.splice(0);
        for (const value in Materials.config.options) {
            if (Object.prototype.hasOwnProperty.call(Materials.config.options, value)) {
                const label = Materials.config.options[value];
                this.types.push({value, label});
            }
        }

        
        this.setType(this.settings.type);
    }


    
    setType(type:string){
        var _type = Str.replace(String(type).toLowerCase(), ['mesh', 'material'], '');
        if(typeof Materials.config.options[_type] != "undefined"){
            this.type = _type;
            this.inputs = Materials.getMaterialInputs(_type, this.material, this.settings);
        }
    }
    changeType(event){
        this.setType(event.value);
        this.settings.type = event.value;
        this.emit("type");
        

    }

    changeHandle(event: InpEvent){
        this.settings[event.name] = event.value;
        this.emit(event.name);
    }

}
