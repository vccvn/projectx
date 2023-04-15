import { ChangeDetectorRef, Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { Materials } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { Object3DPropDataModel, Object3DPropDefaultData } from '@app/_3D/store/data.type';
import { assignValue, assignWithout, isArray, isObject, Str } from '@app/_core/helpers/utils';
import { CallbackFunction, InpEvent } from '@app/_shared/shared.type';
import { ItemModel, ItemSettings } from '@app/_store/item';
import { BaseComponent } from '../../base/base.component';
import { PanelModelObjectService } from './panel-model-object.service';

enum TabIndex {
    Meshes = 0,
    Properties = 1,
}
const propDefault = {
    castShadow: false,
    receiveShadow: false,
    scale: {
        x: 1,
        y: 1,
        z: 1
    },
    rotation: {
        x: 0,
        y: 0,
        z: 0
    },
    position: {
        x: 0,
        y: 0,
        z: 0
    }
};

@Component({
    selector: 'panel-model-object',
    templateUrl: './panel-model-object.component.html',
    styleUrls: ['./panel-model-object.component.scss']
})
export class PanelModelObjectComponent extends BaseComponent implements OnInit, OnChanges {
    title: string = 'Title';
    hasTitle: boolean = false;
    isShow: boolean = false;

    btnDoneText: string = 'Done';
    onUpdateHandle: CallbackFunction = null;
    onDoneHandle: CallbackFunction = null;
    // _service: PanelModelObjectService = null;


    settings: ItemSettings = {};
    secretKey: string = '';

    prevTab: number = TabIndex.Meshes;
    currentTab: number = TabIndex.Meshes;
    data: ItemSettings = {};
    object: any = null;

    meshFormGroup: any[] = [];

    meshes: any[] = [];
    props: Object3DPropDataModel = assignValue({}, Object3DPropDefaultData);
    isInited: boolean = false;
    app: AppEditorService = null;
    _service: PanelModelObjectService = null;
    constructor(private cd: ChangeDetectorRef, private service: PanelModelObjectService, private events: AppEditorEventService) {
        super();
        this._service = service;

        this.registerEventService(service, {
            "panel.show": e => this.show(e.data),
            "panel.hide": e => this.hide(),
            "editor.update.props": e => {
                
                if (!this.isFocus) return;
                if (isObject(e.data) && e.data.secret_key == this.secretKey) {
                    assignValue(this.settings.props, e.data.key, e.data.value);
                    assignValue(this.props, e.data.key, e.data.value);
                    if (e.data.key == "rotation") {
                        setTimeout(() => {
                            this.service.emit({
                                type: "props.rotation.change",
                                value: e.data.value
                            })
                        }, 1);
                    }
                    if (e.data.key == "position") {
                        setTimeout(() => {
                            this.service.emit({
                                type: "props.vector.change",
                                name: "position",
                                value: e.data.value
                            })
                        }, 1);
                    }
                    if (e.data.key == "scale") {
                        setTimeout(() => {
                            this.service.emit({
                                type: "props.vector.change",
                                name: "scale",
                                value: e.data.value
                            })
                        }, 1);
                    }
                    
                    this.cd.checkNoChanges();
                }
                this.refresh(10);
            },
            "component.checkchange": () => this.cd.detectChanges()
        });

    }


    onChangeSubEvents(){
        this.app = this.subEvents.app;
    }

    onInit(): void {
        this.activeEventServiceRegistered(this.service);
        this.cd.detectChanges();
    }


    destroy(){
        this.deactiveEventServiceRegistered(this.service);
    }

    
    ngOnChanges(changes: SimpleChanges) {

    }


    onChangeTab(e) {
        this.currentTab = e.index;
        this.cd.detectChanges();
    }

    reset() {

        this.btnDoneText = 'Done';
    }



    show(data: any) {
        if(!this.isFocus) return;
        if (isObject(data)) {

            if (this.isShow) {
                if (data.secret_key == this.secretKey) return false;
                this.hide();
                setTimeout(() => this.display(data), 10);
            }
            else {
                this.currentTab = TabIndex.Meshes;
                this.display(data);
            }
        }

    }
    hide() {
        this.isShow = false;
        this.reset();
    }

    display(data: any) {
        if (data.title) {
            this.title = data.title;
            this.hasTitle = true;
        }
        if (data.btnDone || data.btnDoneText) {
            this.btnDoneText = data.btnDone || data.btnDoneText;
        }
        if (isObject(data.data) && data.secret_key) {
            this.setData(data);

            this.isShow = true;
        }
    }

    setData(data: any) {
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
        } else if (typeof data.onDone == "function") {
            this.onDoneHandle = data.onDone;
        }

        this.secretKey = data.secret_key;
        this.data = data.data;
        this.object = data.object;
        this.setDefaultSettingData();
        this.asyncSettings(data.data);
        this.initProps();


    }

    initProps() {
        for (const key in Object3DPropDefaultData) {
            if (Object.prototype.hasOwnProperty.call(Object3DPropDefaultData, key)) {
                const value = Object3DPropDefaultData[key];
                assignValue(this.props, key, value);
                if (isObject(value)) {
                    if (Object.prototype.hasOwnProperty.call(this.object, key) && isObject(this.object[key])) {
                        for (const k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                if (typeof this.object[key][k] != "undefined") {
                                    this.props[key][k] = this.object[key][k];
                                }
                            }
                        }
                    }
                    if (Object.prototype.hasOwnProperty.call(this.settings.props, key)) {
                        for (const k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                if (Object.prototype.hasOwnProperty.call(this.settings.props[key], k)) {
                                    this.props[key][k] = this.settings.props[key][k];
                                }

                            }
                        }
                    }
                } else {
                    if (Object.prototype.hasOwnProperty.call(this.object, key)) {
                        this.props[key] = this.object[key];
                    }
                    if (Object.prototype.hasOwnProperty.call(this.settings.props, key)) {
                        this.props[key] = this.settings.props[key];
                    }
                }


            }
        }
    }

    // updateProps(event: InpEvent) {

    // }

    onDone() {
        this.hide();

        return typeof this.onDoneHandle == "function" ? this.onDoneHandle() : 0;
    }




    /**
     * thiết lập giá trị mặc định
     */
    setDefaultSettingData() {
        this.settings = {
            props: assignValue({}, propDefault),
            options: {},
            meshes: []
        }
    }



    // dong bo setting cua item voi tab
    asyncSettings(settings: any) {
        this.settings = settings;
        if(!this.settings.meshes){
            this.settings.meshes = [];
        }
        this.meshes = [];
        if(this.settings.meshes.length){
            var o = this.app.engine.getObject(this.secretKey);
            if(o){
                this.settings.meshes.map((mesh) => {
                    if(!mesh.__ref__){
                        o.meshes.map((m) => {
                            if(m.name == mesh.name){
                                Object.defineProperty(mesh, '__ref__', {
                                    enumerable: false,
                                    configurable: true,
                                    writable: true,
                                    value: m
                                })
                            }
                            
                        })
                    }
                    Object.defineProperty(mesh, '__inputs__', {
                        enumerable: false,
                        configurable: true,
                        writable: true,
                        value: this.app.getMaterialInputs(
                            mesh.data && mesh.data.material && mesh.data.material.type?mesh.data.material.type: mesh.__ref__.material.type,
                            mesh.__ref__.material,
                            mesh.data && mesh.data.material?mesh.data.material:null,
                            mesh.editable?mesh.editable:[]
                        )
                    })
                

                    if(!mesh.__parent_key__){
                        Object.defineProperty(mesh, '__parent_key__', {
                            enumerable: false,
                            configurable: true,
                            writable: true,
                            value: this.secretKey
                        })
                    }
                })
            }
        }

    }


    updateProps(data) {
        assignValue(this.settings.props, data.props);

        if (typeof this.onUpdateHandle == "function") {
            this.onUpdateHandle({
                secret_key: this.secretKey,
                type: "props",
                key: data.name,
                data: this.settings.props
            });
        }
        this.service.emit({
            type: "props.change",
            secret_key: this.secretKey,
            data: this.settings.props
        });
    }


    updateMesh(event) {
        if (isObject(event) && Object.prototype.hasOwnProperty.call(event, 'index')) {
            for (let i = 0; i < this.settings.meshes.length; i++) {
                const mesh = this.settings.meshes[i];
                if (mesh.index == event.index) {
                    if (!isArray(mesh.data.material)) {
                        if (!isObject(mesh.data.material)) mesh.data.material = {};
                        mesh.data.material[event.name] = event.value;
                        const updateData = {};
                        updateData[event.name] = event.value;
                        this.emitUpdateMaterial(i, mesh.name, updateData);
                    }
                    else {
                        mesh.data.material = event.settings;
                    }

                }
            }
        }
    }

    emitUpdateMaterial(index: number, name: string, updateDAta: any) {
        if (typeof this.onUpdateHandle == "function") {
            this.onUpdateHandle({
                secret_key: this.secretKey,
                type: "material",
                index: index,
                name: name,
                data: updateDAta
            });
        }
        this.service.emit({
            type: "material.change",
            index: index,

            data: this.settings.meshes[index].data.material
        });
    }


}
