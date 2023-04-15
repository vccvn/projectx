import { ChangeDetectorRef, Component, OnChanges, OnInit } from '@angular/core';
import { Geometries, Materials } from '@app/_3D/libs/three.libs';
import { Object3DPropDataModel, Object3DPropDefaultData } from '@app/_3D/store/data.type';
import { assignValue, isEmpty, isObject } from '@app/_core/helpers/utils';
import { InpEvent } from '@app/_shared/shared.type';
import { BaseComponent } from '../../base/base.component';
import { MeshGeometryService } from './mesh-geometry.service';

interface MeshData {
    geometry: {
        type: string
        [key: string]: any
    },
    material: {
        type: string
        [key: string]: any
    },
    props: {
        [key: string]: any
    }
}

type onUpdateFromInputs = (data: { [key: string]: any }) => any;

enum TabIndex {
    Material = 0,
    Geometry = 1,
    Properties = 2,
}

@Component({
    selector: 'panel-mesh-geometry',
    templateUrl: './mesh-geometry.component.html',
    styleUrls: ['./mesh-geometry.component.scss']
})
export class MeshGeometryComponent extends BaseComponent implements OnInit {

    title: string = 'Title';
    hasTitle: boolean = false;
    isShow: boolean = false;

    btnDoneText: string = 'Done';
    materialConfig: any = Materials.config;
    geometryConfig: any = {};
    geoInputs: Array<{
        name: string,
        type: string,
        value: any,
        spin: boolean,
        step: number,
        min: number,
        max: number
    }> = [];

    secretKey: string = '';

    mesh: any = null;
    data: MeshData = {
        geometry: {
            type: "box"
        },
        material: {
            type: "basic"
        },
        props: {}
    }
    props: Object3DPropDataModel = assignValue({}, Object3DPropDefaultData);
    onUpdateHandle: onUpdateFromInputs = null;
    onDoneHandle: onUpdateFromInputs = null;
    _service: MeshGeometryService = null;

    prevTab: number = TabIndex.Material;
    currentTab: number = TabIndex.Material;

    constructor(private cd: ChangeDetectorRef, private service: MeshGeometryService) {
        super();
        this._service = service;
        this.service.on("panel.show", e => this.show(e.data));
        this.service.on("panel.hide", e => this.hide());
        this.service.on("editor.update.props", e => {
            if(isObject(e.data) && e.data.secret_key == this.secretKey){
                assignValue(this.data.props, e.data.key, e.data.value);
                assignValue(this.props, e.data.key, e.data.value);
                if(e.data.key == "rotation"){
                    setTimeout(() => {
                        this.service.emit({
                            type: "props.rotation.change"
                        })
                    }, 1);
                }
            }
        });
        this.service.on("component.checkchange", () => this.cd.detectChanges());
    }
    onInit(): void {
        this.cd.detectChanges();

    }

    onChangeTab(e) {
        this.currentTab = e.index;
        this.cd.detectChanges();
    }

    reset() {
        this.mesh = null;
        this.data = {
            geometry: {
                type: "box"
            },
            material: {
                type: "basic"
            },
            props: {}
        }
        this.props = assignValue({}, Object3DPropDefaultData);
        this.btnDoneText = 'Done';
    }



    show(data: any) {
        if(!this.isFocus) return;
        if (isObject(data)) {

            if(this.isShow){
                if(data.secret_key == this.secretKey) return false;
                this.hide();
                setTimeout(() => this.display(data), 10);
            }
            else{
                this.currentTab = TabIndex.Geometry;
                this.display(data);
            }
        }

    }
    hide() {
        
        if(!this.isFocus) return;
        this.isShow = false;
        this.reset();
    }

    display(data:any){
        if(!this.isFocus) return;
        if (data.title) {
            this.title = data.title;
            this.hasTitle = true;
        }
        if(data.btnDone || data.btnDoneText){
            this.btnDoneText = data.btnDone || data.btnDoneText;
        }
        if (isObject(data.mesh) && data.secret_key) {
            this.setMesh(data);

            this.isShow = true;
        }
    }

    setMesh(data: any) {
        if(!this.isFocus) return;
        this.onUpdateHandle = null;
        if (typeof data.onUpdate == "function") {
            this.onUpdateHandle = data.onUpdate;
        }
        if (typeof data.onChange == "function") {
            this.onUpdateHandle = data.onChange;
        }
        if (typeof data.change == "function") {
            this.onUpdateHandle = data.change;
        }
        if (typeof data.done == "function") {
            this.onDoneHandle = data.done;
        } else if(typeof data.onDone == "function"){
            this.onDoneHandle = data.onDone;
        }

        
        let d = data.data;
        let mesh = data.mesh;
        this.secretKey = data.secret_key;
        this.data = {
            geometry: {
                type: "box"
            },
            material: {
                type: "physical"
            },
            props: {}
        };
        this.geoInputs = [];
        this.mesh = mesh;

        
        assignValue(this.data, d);

        if(!this.data.props.name){
            if(this.mesh.name){
                this.data.props.name = this.mesh.name;
            }
        }
        if(this.data.props.name && !this.hasTitle){
            this.title = this.data.props.name;
        }

        var cfg = Geometries.getConfig(this.data.geometry.type);
        if (!isEmpty(cfg)) {
            this.geometryConfig = cfg;
            for (const key in cfg.params) {
                if (Object.prototype.hasOwnProperty.call(cfg.params, key)) {
                    const inpType = cfg.params[key].toLowerCase();
                    let iType = 'number';
                    let step = 1;
                    let spin = false;
                    let value = Object.prototype.hasOwnProperty.call(this.data.geometry, key) ? this.data.geometry[key] : cfg.data.params[key];
                    switch (inpType) {
                        case "integer":
                            // do somthing
                            break;

                        case "float":
                            step = 0.001;
                            spin = true;
                            break;

                        default:
                            break;
                    }
                    this.geoInputs.push({
                        name: key,
                        type: iType,
                        value: value,
                        spin: spin,
                        min: -9999999,
                        max: 9999999,
                        step: step
                    })
                }
            }
            this.initProps();
        }
    }

    initProps() {
        
        if(!this.isFocus) return;
        for (const key in Object3DPropDefaultData) {
            if (Object.prototype.hasOwnProperty.call(Object3DPropDefaultData, key)) {
                const value = Object3DPropDefaultData[key];
                assignValue(this.props, key, value);
                if (isObject(value)) {
                    if (Object.prototype.hasOwnProperty.call(this.mesh, key) && isObject(this.mesh[key])) {
                        for (const k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                if (typeof this.mesh[key][k] != "undefined") {
                                    this.props[key][k] = this.mesh[key][k];
                                }
                            }
                        }
                    }
                    if (Object.prototype.hasOwnProperty.call(this.data.props, key)) {
                        for (const k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                if (Object.prototype.hasOwnProperty.call(this.data.props[key], k)) {
                                    this.props[key][k] = this.data.props[key][k];
                                }

                            }
                        }
                    }
                } else {
                    if (Object.prototype.hasOwnProperty.call(this.mesh, key)) {
                        this.props[key] = this.mesh[key];
                    }
                    if (Object.prototype.hasOwnProperty.call(this.data.props, key)) {
                        this.props[key] = this.data.props[key];
                    }
                }


            }
        }
        console.log(this.props)
    }

    onNameChange(event){
        this.data.props.name = event.valur;
        if(!this.hasTitle){
            this.title = this.data.props.name;
        }

    }
    updateProps(event: InpEvent) {

        this.data.props[event.name] = event.value;
        
        if(event.name == "name"){
            if(!this.hasTitle){
                this.title = event.value;
            }
        }

        if(typeof this.onUpdateHandle == "function"){
            this.onUpdateHandle({
                key: "props",
                data: this.data
            });
        }
        this.service.emit({
            type: "data.change",
            key: "props",
            data: this.data
        });

    }

    onGeometryParamChange(event: InpEvent) {
        this.data.geometry[event.name] = event.value;
        if(typeof this.onUpdateHandle == "function"){
            this.onUpdateHandle({
                key: "geometry",
                data: this.data
            });
        }
        this.service.emit({
            type: "data.change",
            key: "geometry",
            data: this.data
        });

    }

    onMaterialChange(event){
        this.data.material[event.name] = event.value;
        
        if(typeof this.onUpdateHandle == "function"){
            this.onUpdateHandle({
                key: "material",
                data: this.data,
                updateKey: event.name
            });
        }
        this.service.emit({
            type: "data.change",
            key: "material",
            data: this.data,
            updateKey: event.name
        });
    }

    onDone(){
        this.hide();

        return typeof this.onDoneHandle == "function" ? this.onDoneHandle(this.data): 0;
    }
}
