import { Injectable } from '@angular/core';
import { assignValue, assignWithout, degreeToRadians, isArray, isBoolean, isNumber, isObject, isString, Str } from '@app/_core/helpers/utils';
import { FG_ITEM } from '@app/_shared/shared.type';
import Viewport from '../components/viewport';
import ItemEngine from '../engines/item.engine';
import ItemEditor from '../libs/item-editor';
import { LoaderLib } from '../libs/three.libs';
import { iEditor } from '../store/docs';
import { App3DService } from './app-3d.service';

@Injectable({
    providedIn: 'root'
})
export class ItemEditorService extends App3DService {


    engineClass = ItemEngine;
    editorClass = ItemEditor;
    _editor: iEditor;
    

    set editor(editor: iEditor) {
        this._editor = editor;
        this.dispatchEvent({
            type: "seteditor",
            eventData: editor
        });


    }
    get editor() {
        return this._editor;
    }

    constructor() {
        super();

        
        this.start();
    }

    
    start() {
        var self = this;
        
        this.on('init', () => this.addControls(this.engine.control));
        this.on('engine.set', () => {

            LoaderLib.setEngine(this.engine);
            const EC = this.editorClass;
            const editor = new EC(this, this.engine);

            this.editor = editor;
            this.controls = [];

            function addControlEvent() {

                if (!self.engine.control || !self.editor.control) {
                    return setTimeout(addControlEvent, 10);
                }

                self.addControls(self.engine.control);
                self.addControls(self.editor.control);

            }
            this.editor.on("startup", () => addControlEvent(), true);
            this.editor.on("attach:mesh", e => this.emit({
                type: "editor.attach:mesh",
                mesh: e.mesh
            }));

            
        });



        this.on("event.transfer", e => {
            // e.event.tyoe=="dbclick" && console.log(e);
            if (this.editor) {
                this.editor.emit(e.event);
            }
        });

        

    }



    getForegrounds(): FG_ITEM[] {
        return [];
    }

    updateItemSize() {
        let size = this.engine.getObjectSize(this.data.appData.secret_key);
        if (size != null) {
            if(!isObject(this.data.item.size)) this.data.item.size = this.data.item.size = {};
            assignValue(this.data.item.size, size);
        }

    }

    captureScene(){
        return this.engine.capture();
    }


    parseItemData(model: any, object3DModel: any) {
        var settings: any = {
            options: {},
            props: {},
            meshes: []
        };
        var vectors = ["rotation", "scale"],
            vprops = ["x", "y", "z"],
            shadows = ["castShadow", "receiveShadow"];
        var obj = object3DModel.object;
        var modelSettings: any = model.settings || {};
        shadows.map(k => {
            settings.props[k] = (typeof modelSettings.props == "object" && typeof modelSettings.props[k] != "undefined") ? modelSettings.props[k] : obj[k];
        });
        vectors.map(k => {
            settings.props[k] = {};
            if (typeof modelSettings.props == "object" && typeof modelSettings.props[k] == "object") {
                vprops.map(v => {
                    if (typeof modelSettings.props[k][v] != "undefined") {
                        settings.props[k][v] = modelSettings.props[k][v];
                    } else {
                        settings.props[k][v] = obj[k][v];
                    }
                })
            }
            else {
                vprops.map(v => {
                    settings.props[k][v] = obj[k][v];
                })
            }
        });
        if (modelSettings.options) {
            assignValue(settings.options, modelSettings.options);
        }

        const addMeshSettings = (index: number, mesh: any, setting: any) => {
            var settingDefaultData = {
                ref: mesh,
                name: mesh.name,
                sid: Str.slug(mesh.name + " " + index, '_'),
                index: index,
                title: mesh.name,
                data: {

                },
                editable: []
            }

            if (isObject(setting)) {
                assignWithout(settingDefaultData, setting, ['sid']);
            }
            settings.meshes[index] = settingDefaultData;
            if (!isArray(settings.meshes[index].editable)) {
                settings.meshes[index].editable = [];
            }

            // let materialData = Materials.getPropData(mesh.material);


        }


        if (modelSettings.meshes && modelSettings.meshes.length) {
            for (let i = 0; i < object3DModel.meshes.length; i++) {
                const objMesh = object3DModel.meshes[i];
                let setting = null;
                for (let j = 0; j < modelSettings.meshes.length; j++) {
                    const mesh = modelSettings.meshes[j];
                    if (objMesh.name == mesh.name) {
                        setting = mesh;
                        j == modelSettings.meshes.length;
                    }

                }
                addMeshSettings(i, objMesh, setting);
            }
        } else {
            for (let i = 0; i < object3DModel.meshes.length; i++) {
                const objMesh = object3DModel.meshes[i];
                addMeshSettings(i, objMesh, null);
            }
        }


        return settings;
    }


    addModelItem(data: any, onSuccess?: (objectData: any, ...args: any[]) => any, onError?: (...args: any[]) => any, onProgress?: (...args: any[]) => any) {
        var self = this;
        try {
            // self.dom.showLoading();
            // lấy dử liệu sau khi dc load
            this.engine.addSettingModelItem(data, function (object) {
                self.data.appData = object;
                self.data.item = data;
        
                var a = assignValue({}, self.data.item.settings);
                assignValue(a, self.parseItemData(self.data.item, object));
                let b: any = assignWithout({}, a, ['meshes']);
                b.meshes = []
                if (a.meshes && a.meshes.length) {
                    for (let index = 0; index < a.meshes.length; index++) {
                        const m = a.meshes[index];
                        const mm = assignWithout({}, m, ['ref']);
                        Object.defineProperty(mm, '__ref__', {
                            value: m.ref,
                            configurable: false,
                            enumerable: false,
                            writable: false
                        })
                        b.meshes.push(mm);
                    }
                }

                self.data.item.settings = b;

                self.updateItemSize();
                self.engine.updateFloor();
                // truyền data cho panel
                // self.dom.setModelItem(self.data);
                // var settings = self.getModelSettingData(
                //     self.data.item,
                //     self.data.appData
                // );

                // self.data.settings = settings;
                var sceneData = self.engine.getSceneSize();
                var x = sceneData.size.x;
                var y = sceneData.size.y;
                var z = sceneData.size.z;
                var fov = self.engine.camera.fov;
                var tan = Math.tan(degreeToRadians(fov / 2));
                var ds = (z / 2) + ((x > y ? x : y) / 2) / tan;
                var dz = ds * 1.5;
                self.engine.camera['position'].z = dz;
                self.engine.camera['position'].y = y/2;

                if(dz*5 >= self.engine.camera.far){
                    self.engine.camera.far = dz*5;
                }
                if(z >= 50){
                    self.engine.camera.near = 1;
                }
                else if(z >= 20){
                    self.engine.camera.near = 0.5;
                }
                else if(z >= 5){
                    self.engine.camera.near = 0.1;
                }

                self.engine.camera.lookAt(0, 0, 0);

                self.engine.camera.updateProjectionMatrix();
                self.engine.refresh();
                if (typeof onSuccess == "function") {
                    onSuccess(object);
                }

                self.dispatchEvent('model.added', object);

            }, function (w) {
                let a = onError && typeof onError == "function" ? onError() : 0;
            }, function (p) {
                // self.dom.updateLoadingPercentage(p);
                let b =onProgress && typeof onProgress == "function"? onProgress(p) : 0
            });

        } catch (error) {
            console.log(error);
            let c = onError && typeof onError == "function" ? onError() : 0;
        }
    }

    removeModelItem(){
        if(this.data && this.data.appData){
            this.engine.removeObject(this.data.appData.secret_key);
            this.emit("model.removed");
        }
    }

    updateInfo(data) {
        assignValue(this.data.item, data);
    }

    updateSettings(data: any, refresh?: any, updateList?: any, meshIndex?: any) {

        assignValue(this.data.item.settings, data);
        // console.log(data);
        var updateData: any = {};
        if (isObject(refresh)) {
            if (refresh.props) {
                updateData.props = this.data.item.settings.props;
            }
            if (refresh.meshes) {
                updateData.meshes = this.data.item.settings.meshes;
            }

        } else if (isBoolean(refresh) && refresh) {
            updateData = this.data.item.settings;
        }
        if (refresh) {
            this.engine.updateObjectSettings(this.data.appData.secret_key, updateData, updateList, meshIndex);
            this.engine.updateFloor();
        }
        this.updateItemSize();
        

    }

    updateMeshMaterial(meshIndex: any, material?: { [x: string]: any }) {
        if (isNumber(meshIndex)) {
            for (let index = 0; index < this.data.item.settings.meshes.length; index++) {
                const mesh = this.data.item.settings.meshes[index];
                if (index == meshIndex) {
                    assignValue(mesh.data.material, material);
                    if(!isObject(mesh.data)) mesh.data = {};
                    if(!isObject(mesh.data.material)) mesh.data.material = {};
                    
                    this.engine.updateMeshMaterial(this.data.appData.secret_key, mesh.name, material.type ? mesh.data.material : material);
                }
            }
        }
        else if (isString(meshIndex)) {
            for (let index = 0; index < this.data.item.settings.meshes.length; index++) {
                const mesh = this.data.item.settings.meshes[index];
                if (mesh.name == meshIndex) {
                    if(!isObject(mesh.data)) mesh.data = {};
                    if(!isObject(mesh.data.material)) mesh.data.material = {};
                    
                    assignValue(mesh.data.material, material);
                    this.engine.updateMeshMaterial(this.data.appData.secret_key, mesh.name, material.type ? mesh.data.material : material);
                }
            }
        }

    }

    updateEditable(meshIndex: any, name?: string, status?: boolean) {
        if (isNumber(meshIndex)) {
            for (let index = 0; index < this.data.item.settings.meshes.length; index++) {
                const mesh = this.data.item.settings.meshes[index];
                if (index == meshIndex) {
                    if (!isArray(mesh.editable)) mesh.editable = [];
                    var id = mesh.editable.indexOf(name);
                    if (id != -1 && status == false) {
                        mesh.editable.splice(id, 1);
                    } else if (id == -1 && status) {
                        mesh.editable.push(name);
                    }
                }
            }
        }
        else if (isString(meshIndex)) {
            for (let index = 0; index < this.data.item.settings.meshes.length; index++) {
                const mesh = this.data.item.settings.meshes[index];
                if (mesh.name == meshIndex) {
                    if (!isArray(mesh.editable)) mesh.editable = [];
                    var id = mesh.editable.indexOf(name);
                    if (id != -1 && status == false) {
                        mesh.editable.splice(id, 1);
                    } else if (id == -1 && status) {
                        mesh.editable.push(name);
                    }
                }
            }
        }

    }

    updateMeshTitle(meshIndex: any, title:string) {
        if (isNumber(meshIndex)) {
            for (let index = 0; index < this.data.item.settings.meshes.length; index++) {
                const mesh = this.data.item.settings.meshes[index];
                if (index == meshIndex) {
                    mesh.title = title;
                }
            }
        }
        else if (isString(meshIndex)) {
            for (let index = 0; index < this.data.item.settings.meshes.length; index++) {
                const mesh = this.data.item.settings.meshes[index];
                if (mesh.name == meshIndex) {
                    mesh.title = title;
                }
            }
        }

    }

}
