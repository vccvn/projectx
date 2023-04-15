import { Injectable } from '@angular/core';
import { assignIfNotExists, assignValue, assignWithout, date, getArguments, isArray, isFunction, isObject, isString, objectHasKey, Str } from '@app/_core/helpers/utils';
import Viewport from '../components/viewport';
import AppEngine from '../engines/app.emgine';
import { EngineClass, EngineInstance } from '../engines/engine.doc';
import { Materials } from '../libs/three.libs';
import { AppData } from '../store/data.type';
import { EventEmitter } from './event-emitter';
const DEFAULT_VALUE = Str.rand(Str.rand(date('ms')));
import Dom from '@app/_core/helpers/dom';
import { CallbackFunction } from '@app/_shared/shared.type';
import { i } from '@app/_core/helpers/html-elements';
@Injectable({
    providedIn: 'root'
})
export class App3DService extends EventEmitter {
    data: AppData = {};
    root: any = null;
    engineOptions: any = {};
    _engine: EngineInstance = null;
    storageKey: any = null;

    controls: any[] = [];

    canTransferEventToControls: boolean = true;

    engineClass: EngineClass = AppEngine;
    constructor() {
        super();
        // this.init();
    }


    capture(onDone: CallbackFunction, onError?:CallbackFunction) {
        var image = this.engine.capture();


        const imgS = new Image();
        imgS.crossOrigin = "anonymous";
        imgS.onload = () => {
            let { width, height } = imgS;
            let ratio = width / height;

            var cancasDom = Dom("canvas#test-image-canvas", { height, width });
            let canvas: HTMLCanvasElement = cancasDom.el as HTMLCanvasElement;
            var ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            let taskTotal = 0;
            const checkTask = () => {
                if (taskTotal === 0) {
                    if (isFunction(onDone)) {
                        onDone(canvas.toDataURL());

                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                    }
                }
            };


            ctx.drawImage(imgS, 0, 0);
            if (this.data.scene && this.data.scene.foregrounds && this.data.scene.foregrounds.length) {
                this.data.scene.foregrounds.map(fg => {

                    taskTotal++;
                    const url = fg.url;
                    const opacity = objectHasKey(fg, 'opacity') ? fg.opacity : 1;

                    const img = new Image();
                    img.crossOrigin = "anonymous";
                    img.onload = function () {
                        const posX = fg.position.x || 'center', posY = fg.position.y || 'center';
                        let outWidth = img.width;
                        let outHeight = img.height;
                        let outRatio = outWidth / outHeight;
                        if (outWidth > width || outRatio > height) {
                            if (outRatio > ratio) {
                                outWidth = width;
                                outRatio = outWidth / outRatio;
                            } else {
                                outHeight = height;
                                outWidth = outHeight * outRatio;

                            }
                        }

                        let x = posX == 'left' ? 0 :
                            posX == 'right' ? width - outWidth :
                                (width - outWidth) / 2;
                        let y = posY == 'top' ? 0 :
                            posY == 'bottom' ? height - outHeight :
                                (height - outHeight) / 2;
                        //


                        ctx.save();
                        ctx.globalAlpha = opacity;

                        ctx.drawImage(
                            img,
                            // crop image 
                            0, 0, //Where to start the grab (x,y of source image)
                            // crop size
                            img.width, img.height, //How much to grab (width, height)
                            // insert
                            // positiom
                            x, y, //Where to plop the grab on the canvas (x,y of canvas)
                            // size
                            outWidth, outHeight //How large to plop the grab (width, height of incoming stamp)
                        );


                        ctx.restore();
                        taskTotal--;
                        checkTask();
                    };
                    img.onerror = e => {
                        taskTotal--;
                        checkTask();
                    }
                    img.src = url;

                })
            } else {
                checkTask();
            }

        };
        imgS.onerror = (e) => {
            if(!image ){
                if(isFunction(onError)){
                    onError();
                }
            }
            if (isFunction(onDone)) {
                onDone(image);
            }
        }

        imgS.src = image;
    }




    setOptions(options: any) {
        this.engineOptions = options;
    }


    setAppData(data, complete?) {
        this.setOptions(data);
        this.init();
    }

    addControls(control) {
        if (isObject(control) && typeof control.getEventList == "function") {
            let stt = true;
            this.controls.map(c => {
                if (c == control) {
                    stt = false;
                }
            });
            if (stt) {
                this.controls.push({
                    control: control,
                    events: control.getEventList()
                });
            }

        }

    }

    transferEventListenner(event) {
        if (isObject(event) && event.type) {
            if (this._engine) {
                this._engine.emit(event);
            }
            this.emit({
                type: "event.transfer",
                event: event
            });
            
            if(this.canTransferEventToControls){
                this.controls.map(c => {
                    if (isObject(c) && isObject(c.control) && typeof c.control.transferEventListenner == "function" && c.events.indexOf(event.type) >= 0) {
                        c.control.transferEventListenner(event.type, event);
                    }
                });    
                // this.engine.getCanvas().dispatchEvent(event);
            }

            // console.log(event);

        }
    }

    

    set engine(engine) {
        this._engine = engine;
        this.dispatchEvent({
            type: "engine.set",
            data: engine,
            engine: engine
        });
        this._engine.on('ready', () => this.emit({
            type: "engine.ready",
            data: this._engine,
            engine: this._engine
        }));

    }
    get engine(): EngineInstance {
        return this._engine;
    }

    init() {
        if (!this.engine) {
            var Engine = this.engineClass;
            this.engine = new Engine(this.engineOptions);
            this.emit({
                type: "beforeinit"
            }, this.data, true);
            this.engine.startup();
            this.emit({
                type: "init"
            }, this.data, true);
        } else {
            this.engine.reset(this.engineOptions);
            this.emit({
                type: "reset"
            }, this.data, true);
        }


    }


    updateCanvasSize() {
        if (this.engine) {
            this.engine.updateCanvasSize();
        }
    }

    onDataUpdate(data: any) {
        console.log(data);
    }


    getModelSettingData(model: any, object3DModel: any) {
        var settings: any = {
            options: {},
            props: {},
            meshes: []
        };
        var vectors = ["position", "rotation", "scale"],
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
                name: mesh.name,
                sid: Str.slug(mesh.name + " " + index, '_'),
                index: index,
                title: mesh.name,
                data: {

                },
                editable: []
            }


            if (isObject(setting)) {
                settingDefaultData = assignIfNotExists(setting, settingDefaultData);
            }
            settings.meshes[index] = settingDefaultData;
            if (!isArray(settings.meshes[index].editable)) {
                settings.meshes[index].editable = [];
            }

            Object.defineProperty(settingDefaultData, '__ref__', {
                configurable: true,
                enumerable: false,
                writable: true,
                value: mesh
            })
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


    getMeshMaterialFormData(meshMaterial: any, settingMaterial: any) {
        let materialInputs: any;
        if (isArray(meshMaterial)) {
            materialInputs = [];
            if (isArray(settingMaterial)) {
                for (let index = 0; index < meshMaterial.length; index++) {
                    const mat = meshMaterial[index];
                    let setting = settingMaterial[index] === undefined ? null : settingMaterial[index];
                    let type = setting && setting.type ? setting.type : mat.type;
                    materialInputs.push(this.getMaterialInputs(type, mat, setting));
                }
            }
            else {
                let setting = isObject(settingMaterial) ? settingMaterial : null;
                let type = setting && setting.type ? setting.type : null;
                for (let index = 0; index < meshMaterial.length; index++) {
                    const mat = meshMaterial[index];

                    materialInputs.push(this.getMaterialInputs(type || mat.type, mat, setting));
                }
            }

        } else {
            let setting = isObject(settingMaterial) ? settingMaterial : null;
            let type = setting && setting.type ? setting.type : meshMaterial.type;
            materialInputs = this.getMaterialInputs(type, meshMaterial, settingMaterial);
        }
        return materialInputs;
    }

    getMaterialInputs(materialType: string, material: any, settings: any, editableList?: any): any[] {
        let _type = materialType ? Str.replace(String(materialType).toLowerCase(), ['mesh', 'material'], '') : 'basic';
        let _material = Materials.config.data[_type];
        let _settings = isObject(settings) ? settings : {};
        if (!_material) return [];
        let inputs = [];

        let ignore = [];


        /**
         * 
         * @param type loại input
         * @param name tên input
         * @param value gia tri
         * @param options option
         */
        const addInput = (type: string, name: string, value: (string | number | boolean | { [x: string]: any }), options?: any) => {
            inputs.push(assignValue({
                type: type,
                name: name,
                value: value
            }, options));
        }

        let materialProps = _material.props;
        let editable = _material.editable;
        const isArrayEditAble = isArray(editableList);
        for (let i = 0; i < editable.length; i++) {
            const key = editable[i];
            if (Object.hasOwnProperty.call(materialProps, key) && ignore.indexOf(key) == -1) {
                const prop = materialProps[key];
                const type = prop.type.split(":")[0].toLowerCase();
                const value = typeof _settings[key] != "undefined" ? _settings[key] : (typeof material[key] != "undefined" ? material[key] : prop.value);
                var inputType = prop.data.inputType;
                const inputOptions: any = {};
                let isEditAble = isArrayEditAble && editableList.indexOf(key) !== -1;
                switch (type) {
                    case 'boolean':
                        addInput("checkbox", key, value, { editable: isEditAble });
                        break;
                    case 'string':
                        if (inputType == "select") {
                            addInput("select", key, value, { options: prop.data.options, editable: isEditAble })
                        } else {
                            addInput("text", key, value, { editable: isEditAble })
                        }
                        break;
                    case "number":
                    case "float":
                    case "integer":
                        if (inputType == "select") {
                            addInput("select", key, value, { options: prop.data.options, editable: isEditAble });
                        } else {
                            assignWithout(inputOptions, prop.data, ['inputType']);
                            //  inputOptions.layout = "smart";
                            if (inputType == "range") inputOptions.outputWidth = 2;
                            inputOptions.editable = isEditAble;
                            if (type == "integer") {
                                let a = assignValue({
                                    min: -99999999,
                                    max: 99999999,
                                    step: 1
                                }, inputOptions);
                                assignValue(inputOptions, a);
                            }
                            addInput(inputType == "range" ? inputType : 'number', key, value, inputOptions);
                        }
                        break;

                    case "color":
                    case 'texture':
                        inputOptions.editable = isEditAble;
                        if (typeof materialProps[key + "Intensity"] != "undefined") {
                            inputOptions.attach = assignValue(materialProps[key + "Intensity"].data);
                            inputOptions.attach.name = key + "Intensity";
                            inputOptions.attach.type = inputOptions.attach.inputType || "range";
                            if (_settings[key + "Intensity"] !== undefined) {
                                inputOptions.attach.value = _settings[key + "Intensity"];
                            }
                            else if (_material[key + "Intensity"] !== undefined) {
                                inputOptions.attach.value = _material[key + "Intensity"];
                            } else {
                                inputOptions.attach.value = materialProps[key + "Intensity"].value;
                            }
                            ignore.push(key + "Intensity");
                        }

                        var vl = type == "color" && isObject(value) ? (
                            value.isColor ? "#" + value.getHexString() : "#000000"
                        ) : value;

                        addInput(type, key, vl, inputOptions);
                        break;


                    default:
                        break;
                }
            }
        }

        return inputs;
    }

}
