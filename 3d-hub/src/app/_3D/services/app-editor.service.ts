import { Injectable } from '@angular/core';
import { App3DService } from './app-3d.service';
import Editor from '../libs/editor';
import { assignValue, assignWithout, copyByList, date, isArray, isBoolean, isNumber, isObject, isString, objectHasKey, Str } from '@app/_core/helpers/utils';
import { LS } from '@app/_core/helpers/local-storage';
import { TemplateModel } from '@app/_store/template';
// import { LoaderLib } from '../libs/three.libs';
import { FG_ITEM } from '@app/_shared/shared.type';
import { AppDefaultData, CameraSetting, ControlSetting, FloorSetting, SceneSize, SceneSizeDefaultData, ShadowSetting, Vector3 } from '../store/data.type';
import { EditorClass, iEditor } from '../store/docs';
import { LoaderLib } from '../libs/three.libs';
import EditorEngine from '../engines/editor.engine';
import { AppEditorEventService } from './app-editor-event.service';
import { ProjectModel } from '@app/_store/project';

import * as THREE from 'three';

@Injectable({
    providedIn: 'root'
})
export class AppEditorService extends App3DService {
    _editor: iEditor;
    _events: AppEditorEventService;
    [prop: string]: any;

    engineClass = EditorEngine;
    editorClass = Editor;
    itemDropable: boolean = false;
    geometryDropable: boolean = false;

    items: any;

    addItemMode: string = 'auto';
    addItemPosition: Vector3 = {
        x: 0,
        y: 0,
        z: 0
    };


    eventHandlers = {
        'item.dragmove': e => this.checkItemDragHover(e),
        'item.dropped': e => this.checkItemDropped(e),
        'geometry.dragmove': e => this.checkGeometryDragHover(e),
        'geometry.dropped': e => this.checkGeometryDropped(e),
        'viewport.droppable.show': e => this.emit(e),
        'viewport.droppable.hide': e => this.emit(e),
        'viewport.droppable.loading': e => this.emit(e),
        'engine.geometry.add': e => this.addMesh(e.data, e.success),
        'engine.geometry.remove': e => this.deleteMesh(e.secret_key),
        'engine.geometry.update': e => this.updateMeshSettingDataAndScene(e.secret_key, e.data, true),
        'mesh.setting.update': e => {
            this.updateMeshSettingDataAndScene(e.secret_key, e.data, true)
        },
        "show:light.panel": e => this.showPanelLight(e.secret_key),
        'app.instance.get': e => {
            if (typeof e.data == "function") {
                e.data(this);
            } else if (typeof e.success == "function") {
                e.success(this);
            }
            return this;
        },
        "droppable.areas.add": e => this.addDraggablePosition(e.item, e.position),
        "droppable.areas.remove": e => this.removeDraggablePosition()
        // ,
        // "scene.update-size" : e => this.editor.updateDropAreaAreas(this.data.scene.size, this.data.scene.floor.props.position.y, this.data.scene.floor.above)
    };

    set editor(editor: iEditor) {
        this._editor = editor;
        this.dispatchEvent({
            type: "seteditor",
            eventData: editor
        });

        editor.on("additem.position.set", e => {
            this.addItemMode = "custom";
            assignValue(this.addItemPosition, e.position);
        });
        editor.on("additem.position.reset", e => {
            this.addItemMode = "auto";
            this.resetAddItemPosition();
        });
        editor.on("additem.position.lock", e => {
            this.addItemMode = "lock";
            this.resetAddItemPosition();
        });

    }
    get editor() {
        return this._editor;
    }


    constructor() {
        super();
        this.setDefaultData();
        this.start();
    }


    get events() {
        return this._events;
    }
    set events(events: AppEditorEventService) {
        if (events == this._events) return;

        this._events = events;
        events.app = this;
        events.on(this.eventHandlers);
        this.on("init", (e) => {
            this.events.emit({
                type: "app.init"
            }, null, true);
        }, true);



    }

    start() {
        var self = this;
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

            editor.on('object.attach', event => {

                var obj = self.engine.getObject(event.object);
                if (obj) {
                    let type = obj.type == 'mesh' ? 'mesh' : 'object';
                    self.emit({
                        type: "editor.attach:" + type,
                        secret_key: obj.secret_key,
                        mode: event.mode
                    });


                }
            });


            editor.on('object.set-current', event => {

                var obj = self.engine.getObject(event.object);
                if (obj) {
                    let type = obj.type == 'mesh' ? 'mesh' : 'object';
                    self.emit({
                        type: "editor.attach:" + type,
                        secret_key: obj.secret_key,
                        mode: event.mode
                    });


                }
            });

            editor.on('select:mesh', event => {
                const appDataObject = this.getObject(event.mesh.__parent__key__);
                const engineDataObject = this.engine.getObject(event.mesh.__parent__key__);
                if (appDataObject && engineDataObject && appDataObject.data.settings.meshes) {
                    let mesh = null;
                    for (let i = 0; i < appDataObject.data.settings.meshes.length; i++) {
                        const m = appDataObject.data.settings.meshes[i];
                        if (m.name == event.mesh.name) {
                            mesh = m;
                            break;
                        }
                    }
                    if (mesh) {
                        if (!mesh.__parent__key__) {
                            Object.defineProperty(mesh, "__parent__key__", {
                                configurable: true,
                                enumerable: false,
                                writable: false,
                                value: event.mesh.__parent__key__
                            });
                        }
                        if (!mesh.__ref__) {
                            Object.defineProperty(mesh, "__ref__", {
                                configurable: true,
                                enumerable: false,
                                writable: false,
                                value: event.mesh
                            });
                        }
                        Object.defineProperty(mesh, "__inputs__", {
                            configurable: true,
                            enumerable: false,
                            writable: false,
                            value: this.events.app.getMaterialInputs(
                                mesh.data && mesh.data.material && mesh.data.material.type ? mesh.data.material.type : mesh.__ref__.material.type,
                                mesh.__ref__.material,
                                mesh.data && mesh.data.material ? mesh.data.material : null,
                                mesh.editable ? mesh.editable : []

                            )
                        });

                        this._events.emit({
                            type: "editor.select:mesh",
                            mesh: mesh
                        })
                    }
                }
            });



            editor.on('delete:object', event => {

                if (event.objectType == "object") {
                    let obj = self.engine.getObject(event.object);
                    if (obj) {
                        self.emit({
                            type: "editor.delete:object",
                            secret_key: obj.secret_key
                        });


                    }
                }
                else if (event.objectType == "light") {
                    let obj = self.engine.getLight(event.object);
                    if (obj) {
                        self.emit({
                            type: "editor.delete:light",
                            secret_key: obj.secret_key
                        });


                    }
                }

            });



            editor.on('light.attach', event => {
                var light = self.engine.getLight(event.light);
                if (light) {
                    self.emit({
                        type: "editor.attach:light",
                        secret_key: light.secret_key,
                        mode: event.mode
                    });
                }
            });

            editor.on('light.set-current', event => {
                var light = self.engine.getLight(event.light);
                if (light) {
                    self.emit({
                        type: "editor.attach:light",
                        secret_key: light.secret_key,
                        mode: event.mode
                    });
                }
            });

            editor.on('object.detach', function (e) {
                self.emit({
                    type: "editor.detach.object",

                });
                self.emit({
                    type: "editor.detach",

                });
            });
            editor.on('object.unset-current', function (e) {
                self.emit({
                    type: "editor.detach.object",

                });
                self.emit({
                    type: "editor.detach",

                });
            });
            editor.on('light.detach', function (e) {
                self.emit({
                    type: "editor.detach:light",

                });
                self.emit({
                    type: "editor.detach",

                });
            });
            editor.on('light.unset-current', function (e) {
                self.emit({
                    type: "editor.detach:light",

                });
                self.emit({
                    type: "editor.detach",

                });
            });

            editor.on("object.changed", event => {
                self.changeObjectDataByEditor(event.data, event.mode);
                // console.log(event)
            });

            editor.on("light.update.props", event => {
                self.changeLightDataByEditor(event.light, event.mode, event.data);
            });

            editor.on("light.update.target", event => {
                self.changeLightTargetDataByEditor(event.light, event.mode, event.data);
            });
            editor.on("control.mode.change", event => {
                self.emit(event);
            });


            self.on("toolbar.change:mode", function (event) {
                editor.executeCommand(event.mode);
            })


        });


        this.on("toolbar.delete:object", event => {

            var obj = self.engine.getObject(event.secret_key);
            if (obj) {

                if (obj.type == "mesh") {
                    this.deleteMesh(obj.secret_key);
                } else {
                    this.deleteObject(obj.secret_key);
                }


                if (typeof event.success == "function") {
                    event.success();
                }


            }
        })

        this.on("event.transfer", e => {
            // console.log(e.event.type);
            if (this.editor) {
                this.editor.emit(e.event);
            }
        });

        const updateDropAreaAreas = () => {
            if (this.editor) {
                this.editor.updateDropAreaAreas(this.data.scene.size, this.data.scene.floor.props.position.y, this.data.scene.floor.above);
            }
        };
        this.on({
            "data.renew": updateDropAreaAreas,
            "data.reset": updateDropAreaAreas,
            "data.imported": updateDropAreaAreas,
            "scene.settings.updated:floor": updateDropAreaAreas,
            "scene.settings.updated:size": updateDropAreaAreas,
            "scene.update-size": updateDropAreaAreas

        })


    }

    addDraggablePosition(item, pos) {
        this.editor.setDragMoveItem(
            item.size,
            pos,
            item.object
        );

    }
    removeDraggablePosition() {
        this.editor.removeDragMoveItem();

    }

    resetAddItemPosition() {
        this.addItemPosition = {
            x: 0,
            y: 0,
            z: 0
        };
    }

    setAddItemPosition(position: Vector3) {
        assignValue(this.addItemPosition, position);
    }
    // camera
    getCameraSetting(): CameraSetting {
        return this.data.camera;
    }

    syncCameraProps() {
        let propKeys = {
            position: ['x', 'y', 'z'],
            rotation: ['x', 'y', 'z'],
            quaternion: ['x', 'y', 'z', 'z']

        }
        for (const key in propKeys) {
            if (Object.prototype.hasOwnProperty.call(propKeys, key)) {
                const arrKeys = propKeys[key];
                if (!isObject(this.data.camera[key])) this.data.camera[key] = {};
                arrKeys.map(s => this.data.camera[key][s] = this.engine.camera[key][s]);
            }
        }

    }



    updateCameraSetting(setting: CameraSetting, update?: boolean) {
        assignValue(this.data.camera, setting);
        if (this.engine.updateMainCameraSettings(setting, update)) this.syncCameraProps();
    }

    saveCurrentCameraPosition() {
        let cam = this.engine.camera.position;
        assignValue(this.data.camera, {
            settings: {
                position: {
                    type: "custom",
                    custom: {
                        x: cam.x,
                        y: cam.y,
                        z: cam.z
                    }
                }
            }
        });
        this.syncCameraProps();
        this.emit({
            type: "camera.position.save",
            data: this.data.camera.settings.position
        });
    }
    getControlSetting(): ControlSetting {
        return this.data.control;
    }

    updateControlSetting(setting: ControlSetting) {
        assignValue(this.data.control, setting);
        this.engine.updateControlSettings(setting);
        let camera = this.engine.camera
    }




    getShadowSetting() {
        return this.data.shadow;
    }

    updateShadowSetting(setting: ShadowSetting) {
        assignValue(this.data.shadow, setting);
        this.engine.updateShadowSettings(setting);
    }

    getBackgroundSetting() {
        return typeof this.data.scene.background ? this.data.scene.background : { type: "none" };
    }

    updateBackgroundData(data) {

        assignValue(this.data.scene, 'background', data);
        this.engine.setBackground(data);
    }

    getFloorSetting() {
        const setting = assignValue({}, SceneSizeDefaultData);
        assignValue(setting, this.data.scene.floor);
        return setting;
    }


    updateSceneFloorSetting(floor) {
        assignValue(this.data.scene.floor, floor);
        this.engine.updateSceneFloorSetting(floor);
        this.emit({
            type: "scene.settings.updated:floor",
            data: floor
        })
    }


    getSceneSizeSetting(): SceneSize {
        const setting = assignValue({}, SceneSizeDefaultData);
        assignValue(setting, this.data.scene.size);
        return setting;
    }


    getRealSceneSize() {
        var sceneData: any = {
            min: {
                x: null, y: null, z: null
            },
            max: {
                x: null, y: null, z: null
            }
        };

        ['meshes', 'objects'].map(t => {
            let a = this.data[t];
            if (a.length) {
                a.map(o => {
                    let obj = this.engine.getObject(o.secret_key);
                    if (obj && (obj.type == 'mesh' || obj.type == 'model')) {
                        const box = new THREE.Box3().setFromObject(obj.object);
                        for (const sizeKey in sceneData) {
                            if (Object.hasOwnProperty.call(sceneData, sizeKey) && Object.hasOwnProperty.call(box, sizeKey)) {
                                const sizeData = sceneData[sizeKey];
                                const boxData = box[sizeKey];
                                for (const posKey in boxData) {
                                    if (Object.hasOwnProperty.call(boxData, posKey)) {
                                        if (sizeData[posKey] === null) sizeData[posKey] = boxData[posKey];
                                        else if (sizeKey == 'min' && boxData[posKey] < sizeData[posKey]) sizeData[posKey] = boxData[posKey];
                                        else if (sizeKey == 'max' && boxData[posKey] > sizeData[posKey]) sizeData[posKey] = boxData[posKey];
                                    }
                                }
                            }
                        }
                    }
                })
            }
        });
        var x0 = Math.abs(sceneData.min.x), x1 = Math.abs(sceneData.max.x),
            y0 = Math.abs(sceneData.min.y), y1 = Math.abs(sceneData.max.y),
            z0 = Math.abs(sceneData.min.z), z1 = Math.abs(sceneData.max.z);

        sceneData.size = {
            x: (x0 > x1 ? x0 : x1) * 2,
            y: (y0 > y1 ? y0 : y1) * 2,
            z: (z0 > z1 ? z0 : z1) * 2
        };
        return sceneData;
    }

    updateSceneSizeSetting(data) {
        assignValue(this.data.scene.size, data);
        this.engine.updateSceneSettings(data);
        this.emit({
            type: "scene.settings.updated:size",
            data: data
        })
    }


    updateSceneSizeAndFloorAndGridNyChildren(scale: number = 1) {
        let sceneData = this.getRealSceneSize();
        let size = sceneData.size;
        if (scale <= 0) scale = 1;
        var s = size.x > size.z ? size.x : size.z;
        this.updateSceneSizeSetting({
            width: s * scale,
            height: size.y * scale,
            depth: s * scale
        });

        let floor: FloorSetting = this.getFloorSetting();
        assignValue(floor, {
            params: {
                width: s* scale,
                height: s* scale
            },
            props:{
                y: sceneData.min.y
            }
        });
        this.updateSceneFloorSetting(floor);
        this.events.emit("scene.update-size");
        this.emit("scene.update-size");
        
        setTimeout(() => {
            this.events.emit("scene.update-size");
        
            this.emit("scene.update-size");
        }, 500);
    }

    getForegrounds(): FG_ITEM[] {
        if (!isArray(this.data.scene.foregrounds)) this.data.scene.foregrounds = [];
        return this.data.scene.foregrounds;
    }

    addForegroundData(data: FG_ITEM): FG_ITEM {
        if (isObject(data) && data.url) {
            var a = assignValue({}, data);
            if (!a.secret_key) a.secret_key = Str.rand(date('ms'));
            if (!isArray(this.data.scene.foregrounds)) this.data.scene.foregrounds = [];
            this.data.scene.foregrounds.push(a);
            this.emit({
                type: "scene.foregrounds.added",
                data: a
            });

            return a;
        }
        return null;
    }

    updateForegroundData(secret_key: string, data: FG_ITEM): FG_ITEM {
        if (isArray(this.data.scene.foregrounds)) {
            for (let index = 0; index < this.data.scene.foregrounds.length; index++) {
                const fg = this.data.scene.foregrounds[index];
                if (fg.secret_key == secret_key) {
                    assignWithout(fg, data, 'secret_key');
                    // console.log(fg)
                    this.emit({
                        type: "scene.foregrounds.updated",
                        data: fg
                    });

                    return assignValue({}, fg);
                }
            }
        }
        return null;
    }


    deleteForeground(secret_key: string): boolean {
        if (isArray(this.data.scene.foregrounds)) {
            for (let index = 0; index < this.data.scene.foregrounds.length; index++) {
                const fg = this.data.scene.foregrounds[index];
                if (fg.secret_key == secret_key) {
                    this.data.scene.foregrounds.splice(index, 1);
                    this.emit({
                        type: "scene.foregrounds.deleted",
                        data: fg
                    })
                    return true;
                }
            }
        }
        return false;
    }

    getForeground(secret_key: string): FG_ITEM {
        if (isArray(this.data.scene.foregrounds)) {
            for (let index = 0; index < this.data.scene.foregrounds.length; index++) {
                const fg = this.data.scene.foregrounds[index];
                if (fg.secret_key == secret_key) {
                    return fg;
                }
            }
        }
        return null;
    }




    changeObjectDataByEditor(object: any, mode: any) {
        if (mode == 'translate') mode = 'position';
        else if (mode == 'rotate') mode = 'rotation';
        var o = this.engine.getObject(object);
        // console.log(o);
        if (o) {
            var d = o.object[mode];
            if (isObject(d)) {
                if (o.type == 'mesh') {
                    this.updateMeshDataAndView(o.secret_key, mode, {
                        x: d.x,
                        y: d.y,
                        z: d.z
                    })
                }
                else {
                    this.updateObjectDataAndView(o.secret_key, mode, {
                        x: d.x,
                        y: d.y,
                        z: d.z
                    })
                }

            }

        }
    }

    /**
     * cập nhật thuộc tinh1q cho object
     * @param {string} secret_key chuỗi nhận diện của mỗi onject
     * @param {string} key tên thuộc tính
     * @param {*} value 
     */
    updateMeshDataAndView(secret_key: string, key: string, value: any) {

        var stt = this.updateMeshSettingProp(secret_key, key, value);
        if (stt) {
            this.emit({
                type: "editor.update.mesh.props",
                data: {
                    propType: "vector3",
                    secret_key: secret_key,
                    key: key,
                    value: value
                }
            })
        }
    }




    /**
     * cập nhật thuộc tinh1q cho object
     * @param {string} secret_key chuỗi nhận diện của mỗi onject
     * @param {string} key tên thuộc tính
     * @param {*} value 
     */
    updateObjectDataAndView(secret_key: string, key: string, value: any) {
        var stt = this.updateObjectSettingProp(secret_key, key, value);
        if (stt) {

            this.emit({
                type: "editor.update.model.props",
                data: {
                    propType: "vector3",
                    secret_key: secret_key,
                    key: key,
                    value: value
                }
            })
        }
    }



    changeLightDataByEditor(object, mode, data) {
        if (mode == 'translate') mode = 'position';
        else if (mode == 'rotate') mode = 'rotation';
        var o = this.engine.getLight(object);
        if (o) {
            var d = o.object[mode];
            if (isObject(d)) {
                this.updateLightDataAndView(o.secret_key, mode, {
                    x: d.x,
                    y: d.y,
                    z: d.z
                })
            }

        }
    }

    /**
     * cập nhật thuộc tinh1q cho object
     * @param {string} secret_key chuỗi nhận diện của mỗi onject
     * @param {string} key tên thuộc tính
     * @param {*} value 
     */
    updateLightDataAndView(secret_key, key, value) {
        var stt = this.updateLightSettingProp(secret_key, key, value);
        if (stt) {
            this.emit({
                type: "editor.update.light.props",
                data: {
                    secret_key,
                    key,
                    value
                }
            })

        }
    }

    changeLightTargetDataByEditor(object, mode: string, data: any) {
        if (mode == 'translate') mode = 'position';
        else if (mode == 'rotate') mode = 'rotation';
        var o = this.engine.getLight(object);
        if (o) {
            var d = o.object.target[mode];
            if (isObject(d)) {
                this.updateLightTargetDataAndView(o.secret_key, mode, {
                    x: d.x,
                    y: d.y,
                    z: d.z
                })
            }

        }
    }


    /**
     * cập nhật thuộc tinh1q cho object
     * @param {string} secret_key chuỗi nhận diện của mỗi onject
     * @param {string} key tên thuộc tính
     * @param {*} value 
     */
    updateLightTargetDataAndView(secret_key, key, value) {
        var stt = this.updateLightTargetSettingProp(secret_key, key, value);
        if (stt) {
            this.emit({
                type: "editor.update.light.props.target",
                data: { secret_key, key, value }
            });

        }
    }



    checkItemDragHover(event) {
        var self = this;
        this.emit({
            type: "viewport.pointer.check",
            event: event,
            showDroppableLayer: true,
            handle: function (pos) {
                if (pos.isHover) {
                    if (!self.itemDropable) {
                        self.itemDropable = true;
                        self.events.emit({
                            type: "item.draghover",
                            dropable: true,
                            pos: pos
                        }, false);
                    }
                }
                else {
                    if (self.itemDropable) {
                        self.itemDropable = false;
                        self.events.emit({
                            type: "item.dragout",
                            dropable: false
                        }, false)
                    }
                }
            }
        });
        if (event.checkArea) {
            this.editor.checkDroppablePosition(event.position)
        }

    }

    checkItemDropped(event) {
        this.itemDropable = false;
        this.addObjectModelItem(event.item, event.success);
        this.resetAddItemPosition();
        this.editor.removeDragMoveItem();

    }



    checkGeometryDragHover(event) {
        var self = this;
        this.emit({
            type: "viewport.pointer.check",
            event: event,
            showDroppableLayer: false,
            handle: function (pos) {
                if (pos.isHover) {
                    if (!self.geometryDropable) {
                        self.geometryDropable = true;
                        self.events.emit({
                            type: "geometry.draghover",
                            dropable: true,
                            pos: pos
                        }, false);
                    }
                }
                else {
                    if (self.geometryDropable) {
                        self.geometryDropable = false;
                        self.events.emit({
                            type: "geometry.dragout",
                            dropable: false
                        }, false)
                    }
                }
            }
        });
        if (event.checkArea) {
            this.editor.checkDroppablePosition(event.position)
        }
    }

    checkGeometryDropped(event) {
        this.geometryDropable = false;
        // this.addObjectModelItem(event.item, event.success);

    }



    setTemplate(data: TemplateModel, complete?: (...args: any[]) => any, error?: (...args: any[]) => any, progress?: (...args: any[]) => any) {
        this.setDefaultData();
        assignValue(this.data, data);
        this.setAppData(this.data);
        this.emit("data.renew");

    }

    setProject(data: ProjectModel, complete?: (...args: any[]) => any, error?: (...args: any[]) => any, progress?: (...args: any[]) => any) {
        this.setDefaultData();
        assignValue(this.data, data);
        this.setAppData(this.data);
        this.emit("data.renew");
    }

    importTemplate(data, complete?: (...args: any[]) => any, error?: (...args: any[]) => any, progress?: (...args: any[]) => any) {
        let d: any = copyByList(this.data, ['id', 'name', 'category_id', 'description', 'status', 'allow_custom']);
        this.setDefaultData();
        assignValue(this.data, data);
        assignValue(this.data, d);
        console.log(data)
        this.setAppData(this.data);
        this.emit("data.imported");
    }


    updateInfo(data) {
        assignValue(this.data, data);
    }


    getObject(secret_key: string) {

        if (this.data.objects) {
            for (let i = 0; i < this.data.objects.length; i++) {
                const obj = this.data.objects[i];
                if (secret_key == obj.secret_key || obj == secret_key || obj.object == secret_key) return obj;
            }
        }
        return null;
    }

    getMesh(secret_key: string) {

        if (this.data.meshes) {
            for (let i = 0; i < this.data.meshes.length; i++) {
                const obj = this.data.meshes[i];
                if (secret_key == obj.secret_key || obj == secret_key || obj.object == secret_key) return obj;
            }
        }
        return null;
    }

    getLight(secret_key: string) {

        if (this.data.lights) {
            for (let i = 0; i < this.data.lights.length; i++) {
                const obj = this.data.lights[i];
                if (secret_key == obj.secret_key || obj == secret_key || obj.object == secret_key) return obj;
            }
        }
        return null;
    }

    getLightList() {
        var lights: any[] = []
        this.data.lights.map(li => {
            let lightObj = this.engine.getLight(li.secret_key);
            var l: any = {
                secret_key: li.secret_key,
                data: li.data,
                name: lightObj.type,
                type: lightObj.type,
                ref: lightObj.object
            };
            lights.push(l);
        })
        return lights;
    }

    showPanelLight(secret_key: string) {
        var light = this.getLight(secret_key);
        if (!light) return false;
        let lightObj = this.engine.getLight(secret_key);
        if (!lightObj) return false;

        var l: any = {
            secret_key: light.secret_key,
            type: lightObj.type,
            name: lightObj.type,
            data: light.data,
            ref: lightObj.object
        };
        this.emit({
            type: "light.showform",
            data: l
        });
    }

    getEditObjectData(secret_key: string): any {
        var obj = this.engine.getObject(secret_key);
        if (obj) {
            if (obj.type == "mesh") {
                var setting = this.getMesh(secret_key);
                return {
                    type: "mesh",
                    secret_key: obj.secret_key,
                    mesh: obj.object,
                    data: setting.data
                }
            }
            else if (obj.type == "model") {
                var model = this.getObject(obj.secret_key);
                return {
                    type: "model",
                    secret_key: obj.secret_key,
                    data: this.getModelSettingData(model.data, obj)
                };
            }
        }
        var light = this.getLight(secret_key);
        if (!light) return false;
        let lightObj = this.engine.getLight(secret_key);
        if (!lightObj) return false;

        var l: any = {

            type: "light",
            data: {
                secret_key: light.secret_key,
                type: lightObj.type,
                name: lightObj.type,
                data: light.data,
                ref: lightObj.object
            }
        };
        return l;
    }

    /**
     * Thêm object model
     * @param {object} data dữ liệu của item
     * @param {function(Object)} onSuccess hàm sử lý khi add dữ liệu thành công
     * @param {function(Error)} onError Hàm sử lý khi có lỗi
     * @param {function(Number)} onProgress hàm sử lý tiến trình
     * @returns {string}
     */
    addObjectModelItem(data, onSuccess?, onError?, onProgress?) {
        var obj = {
            type: "model",
            secret_key: "a_" + Str.rand(),
            data: data
        }
        var self = this;
        // var rollnack = true;
        self.data.objects.push(obj);
        // return null;
        try {
            // self.dom.showLoading();
            // lấy dử liệu sau khi dc load
            this.engine.addItemToTemplateSettingWorkspace(obj.secret_key, data, (object) => {
                if (obj.secret_key != object.secret_key) {
                    obj.secret_key = object.secret_key
                }

                // rollnack = false;
                // obj.object = object.object;

                if (typeof onSuccess == "function") {
                    onSuccess(obj);
                }
            }, (e) => {
                if (typeof onError == "function") {
                    var index = self.data.objects.indexOf(obj);
                    if (index !== -1) {
                        self.data.objects.splice(index, 1);
                    }
                    onError(e);
                }
            }, (p) => {
                if (typeof onProgress == "function") {
                    onProgress(p);
                }
            });

        } catch (error) {
            var index = self.data.objects.indexOf(obj);
            if (index !== -1) {
                self.data.objects.splice(index, 1);
            }
            if (typeof onError == "function") {
                onError(error);
            }
        }

        return obj;
    }



    /**
     * Thêm light Template
     * @param {string} type dữ liệu của item
     * @param {function(Object)} onSuccess hàm sử lý khi add dữ liệu thành công
     * @param {function(Error)} onError Hàm sử lý khi có lỗi
     * @returns {string}
     */
    addLightByTemplate(type, onSuccess?: (object: any) => any, onError?: (error: any) => any) {
        var obj = {
            secret_key: Str.rand(date("ms"))
        }
        var lightTemp = this.engine.getLightTemplateData(type);
        if (lightTemp) {
            assignValue(obj, lightTemp);
            var light = this.engine.addLight(obj);
            if (light) {
                if (light.secret_key != obj.secret_key) {
                    obj.secret_key = light.secret_key;
                }
                this.data.lights.push(obj);
                if (typeof onSuccess == "function") {
                    onSuccess(obj);
                }
                // addli--
                this.emit({
                    type: "light.added",
                    light: this.getLight(obj.secret_key),
                    ref: this.engine.getLight(obj.secret_key).object
                });
                return obj;

            }
        }
        if (typeof onError == "function") {
            onError(new Error("Lỗi không xác định"));
        }
        return false;

    }

    /**
     * Thêm light Template
     * @param {any} meshData dữ liệu của item
     * @param {function(Object)} onSuccess hàm sử lý khi add dữ liệu thành công
     * @param {function(Error)} onError Hàm sử lý khi có lỗi
     * @returns {string}
     */
    addMesh(meshData: any, onSuccess?: (object: any) => any) {
        var obj = {
            secret_key: Str.rand(date("ms")),
            data: assignValue({}, meshData)
        };
        this.data.meshes.push(obj);
        var secret_key = this.engine.addMesh(obj);

        if (secret_key) {
            if (secret_key != obj.secret_key) obj.secret_key = secret_key;
            // this.data.meshes.push(obj);
            if (typeof onSuccess == "function") {
                onSuccess(obj);
            }
            return obj;
        }
        var index = this.data.meshes.indexOf(obj);
        if (index !== -1) {
            this.data.meshes.splice(index, 1);
        }

        return null;
    }

    getMeshEngineData(secret_key: string) {
        return this.engine.getMesh(secret_key);
    }

    attachLightInEditor(secret_key) {
        var lightData = this.engine.getLight(secret_key);
        if (lightData) {
            this.editor.attachLight(lightData.object);
        }
    }


    updateObjectSettingDataAndScene(secret_key, settings, refresh) {
        // assignValue(this.data.item, data);
        // console.log(data);
        if (this.data.objects && this.data.objects.length) {
            for (let index = 0; index < this.data.objects.length; index++) {
                const object = this.data.objects[index];
                // console.log(object);
                if (object.secret_key == secret_key) {

                    if (!object.data.settings) object.data.settings = settings;
                    else assignValue(object.data.settings, settings);
                }
            }
        }
        var updateData: any = {};
        if (isObject(refresh)) {
            if (refresh.props) {
                updateData.props = settings.props;
            }
            if (refresh.meshes) {
                updateData.meshes = settings.meshes;
            }

        } else if (isBoolean(refresh) && refresh) {
            updateData = settings;
        }
        if (refresh) this.engine.updateObjectSettings(secret_key, updateData);
    }

    updateMeshSettingDataAndScene(secret_key, data, refresh) {
        var meshData = null;

        if (this.data.meshes && this.data.meshes.length) {
            for (let index = 0; index < this.data.meshes.length; index++) {
                const mesh = this.data.meshes[index];
                // console.log(object);
                if (mesh.secret_key == secret_key) {

                    if (!mesh.data) mesh.data = data;
                    else assignValue(mesh.data, data);

                    meshData = assignValue({}, mesh.data);
                }
            }
        }
        var updateData: any = {};
        if (isObject(refresh)) {
            if (refresh.props) {
                updateData.props = meshData.props;
            }
            if (refresh.geometry) {
                updateData.geometry = meshData.geometry;
            }
            if (refresh.material) {
                updateData.material = meshData.material;
            }
        }
        else if (isString(refresh)) {
            if (Object.hasOwnProperty.call(meshData, refresh)) {
                updateData[refresh] = meshData[refresh];
            }
        }
        else if (isBoolean(refresh) && refresh) {
            updateData = meshData;
        }

        if (refresh) {
            this.engine.updateMeshesSettings(secret_key, updateData);
        }
    }

    updateModelMeshMaterial(secret_key: string, meshIndex: any, material?: { [x: string]: any }) {
        let settings: any = null
        if (this.data.objects && this.data.objects.length) {
            for (let index = 0; index < this.data.objects.length; index++) {
                const object = this.data.objects[index];
                if (object.secret_key == secret_key) {
                    settings = object.data.settings;
                }
            }
        }
        if (!settings) return false;

        if (isNumber(meshIndex)) {
            for (let index = 0; index < settings.meshes.length; index++) {
                const mesh = settings.meshes[index];
                if (index == meshIndex) {
                    assignValue(mesh.data.material, material);
                    this.engine.updateMeshMaterial(secret_key, mesh.name, material.type ? mesh.data.material : material);
                }
            }
        }
        else if (isString(meshIndex)) {
            for (let index = 0; index < settings.meshes.length; index++) {
                const mesh = settings.meshes[index];
                if (mesh.name == meshIndex) {
                    assignValue(mesh.data.material, material);
                    this.engine.updateMeshMaterial(secret_key, mesh.name, material.type ? mesh.data.material : material);
                }
            }
        }

    }

    /**
     * cập nhật ánh sáng
     * @param {string} secret_key key truy cap
     * @param {object} data dữ liệu thuộc tính
     */
    updateLightDataAndScene(secret_key, data) {
        var updateData = {};
        var s = false;
        if (this.data.lights && this.data.lights.length) {
            for (let index = 0; index < this.data.lights.length; index++) {
                const object = this.data.lights[index];
                if (object.secret_key == secret_key) {
                    if (!object.data) object.data = data;
                    else assignValue(object.data, data);
                    s = true;
                }
            }
        }
        if (!s) return false;
        if (data.params) {
            assignValue(updateData, data.params);
        }
        if (data.props) {
            assignValue(updateData, data.props);
        }
        assignWithout(updateData, data, ["props", "params"]);
        return this.engine.updateLightProps(secret_key, updateData);

    }

    updateObjectSettingProp(secret_key, key, value) {
        var object = this.getObject(secret_key);
        if (object) {
            if (!object.data.settings) object.data.settings = {};
            if (!object.data.settings.props) object.data.settings.props = {};
            assignValue(object.data.settings.props, key, value);
            return true;
        }
        return false;
    }

    updateMeshSettingProp(secret_key, key, value) {
        var object = this.getMesh(secret_key);

        if (object) {
            if (!object.data) object.data = {};
            if (!object.data.props) object.data.props = {};
            assignValue(object.data.props, key, value);
            return true;
        }
        // console.log(this.data.meshes);
        return false;
    }

    updateLightSettingProp(secret_key, key, value) {
        var object = this.getLight(secret_key);
        if (object) {
            if (!object.data.props) object.data.props = {};
            assignValue(object.data.props, key, value);
            return true;
        }
        return false;
    }

    updateLightTargetSettingProp(secret_key, key, value) {
        var object = this.getLight(secret_key);
        if (object) {

            if (!object.data.props) object.data.props = {};
            if (!object.data.props.target) object.data.props.target = {};
            assignValue(object.data.props.target, key, value);
            return true;
        }
        return false;
    }


    updateObjects(objects) {
        this.data.objects = objects;
    }

    deleteObject(secret_key) {
        if (this.data.objects && this.data.objects.length) {
            for (let index = 0; index < this.data.objects.length; index++) {
                const object = this.data.objects[index];
                if (object == secret_key || object.secret_key == secret_key || object.object == secret_key) {
                    this.data.objects.splice(index, 1);
                    if (!this.engine.removeObject(secret_key)) return false;
                    return true;
                }
            }
        }
        return false;
    }

    deleteMesh(secret_key) {
        if (this.data.meshes && this.data.meshes.length) {
            for (let index = 0; index < this.data.meshes.length; index++) {
                const object = this.data.meshes[index];
                if (object == secret_key || object.secret_key == secret_key || object.object == secret_key) {
                    this.data.meshes.splice(index, 1);
                    if (!this.engine.removeObject(secret_key)) return false;
                    return true;
                }
            }
        }
        return false;
    }
    deleteLight(secret_key: any, onSuccess?: (light?: any) => any) {
        if (this.data.lights && this.data.lights.length) {
            for (let index = 0; index < this.data.lights.length; index++) {
                const object = this.data.lights[index];
                if (object == secret_key || object.secret_key == secret_key || object.object == secret_key) {
                    this.editor.emit({
                        type: "light.deleting",
                        light: this.engine.getLight(secret_key)
                    });
                    if (!this.engine.removeLight(secret_key)) return false;
                    this.data.lights.splice(index, 1);
                    if (typeof onSuccess == "function") {
                        onSuccess(object);
                    }
                    this.emit({
                        type: "light.deleted",
                        light: object
                    });
                    return true;
                }
            }
        }
        return false;
    }


    saveView() {
        var camera = this.engine.camera;
        var camPos = camera.position;
        var camRot = camera.rotation;
        assignValue(this.data.camera, {
            position: {
                x: camPos.x,
                y: camPos.y,
                z: camPos.z,
            },
            rotation: {
                x: camRot.x,
                y: camRot.y,
                z: camRot.z,
            }
        });
        this.saveData();
    }

    saveData() {
        if (LS.__support()) {
            var key = this.storageKey;
            if (key) {
                LS.set(key, this.data);
                var answer = null;
                alert("Đã cập nhật thành công");
                // e.preventDefault();

                return true;
            }
        }
        return false;
    }


    setDefaultData() {
        this.data = assignValue({}, AppDefaultData)
    }

    parseData() {
        if (this.data.objects && this.data.objects.length) {
            for (let i = 0; i < this.data.objects.length; i++) {
                const obj = this.data.objects[i];
                if (!obj.secret_key) {
                    obj.secret_key = Str.rand(date("ms"));
                }
            }
        }
        if (this.data.lights && this.data.lights.length) {
            for (let i = 0; i < this.data.lights.length; i++) {
                const light = this.data.lights[i];
                if (!light.secret_key) {
                    light.secret_key = Str.rand(date("ms"));
                }
            }
        }

        if (this.data.scene.foregrounds && this.data.scene.foregrounds.length) {
            for (let i = 0; i < this.data.scene.foregrounds.length; i++) {
                const light = this.data.scene.foregrounds[i];
                if (!light.secret_key) {
                    light.secret_key = Str.rand(date("ms"));
                }
            }
        }

    }

}
