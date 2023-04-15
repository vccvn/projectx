import createClass from '@app/_core/helpers/es5.class';
import { assignValue, isArray, isEmpty, isNumber, isObject, isString } from '@app/_core/helpers/utils';


import Scene from '../traits/scene';
import Camera from '../traits/camera';
import Renderer from '../traits/renderer';
import Controls from '../traits/controls';
import GridHelper from '../traits/grid-helper';
import Lights from '../traits/lights';
import ObjectManager from '../traits/object-manager';
import {EventDispatcher} from '../libs/event-dispatcher';

import { Geometries, LightLib, LoaderLib, Materials, Meshes } from '../libs/three.libs';

import Models from '../libs/models';


import Loader from '../modules/loader'
import Composer from '../modules/composer'
import DynamicShadows from '../modules/dynamic-shadows'
import { EngineClass, EngineInstance } from './engine.doc';
import { Floor } from '../traits/floor';

export interface EditorEngineInstance extends EngineInstance {
    setData(data:any): any

}
export interface EditorEngineClass extends EngineClass {
    setData(data:any): any
    new(data: any): EditorEngineInstance
    (data:any): EditorEngineInstance
}


const ClientEditorEngine = createClass("ClientEditorEngine").uses(
    Scene, 
    Camera, 
    Renderer, 
    Controls, 
    Models, 
    Lights, 
    ObjectManager, 
    Floor,
    EventDispatcher, 
    GridHelper
)({
    data: {},
    options: {},

    Mesh: {},
    Geometry: {},
    Material: {},
    Light: {},
    Composer: {},
    Shadows: {},
    inited: false,
    $controlEngine: null,

    setData: function(data?:any){
        if (data.composer && !isEmpty(data.composer)) {
            this.composer = new Composer(this, data.composer);
        }
        if (data.lights && isArray(data.lights)) {
            this.addLights(data.lights);
        }
        if (data.models && isArray(data.models)) {
            this.addModels(data.models);
        }
        if (data.meshes && isArray(data.meshes)) {
            this.addMeshes(data.meshes);
        }
        if (data.objects && (isArray(data.objects) || isObject(data.objects))) {
            this.addObjects(data.objects);
        }else{
            this.emit("object.load.completed");
        }
        if (data.grids && isArray(data.grids)) {
            this.addGrids(data.grids);
        }
        if (data.cameras && isArray(data.cameras)) {
            this.addCameras(data.cameras);
        }
        if (data.floor && isArray(data.floor)) {
            this.addFloor(data.floor);
        }
        if (data.controls && isArray(data.controls)) {
            this.addControls(data.controls);
        }
        this.updateSettings();
        this.emit('setdata', data);
        
        
    },

    /**
     * Hàm khởi tạo
     * @param {Dom} viewport 
     * @param {*} data 
     */
    constructor: function (data?:any) {
        if (data && isObject(data)) {
            this.data = data;
        }
        this.Geometry = Geometries;
        this.Material = Materials;
        this.Mesh = Meshes;
        this.Light = LightLib;
        this.Loader = new Loader(this);
        
        
        var self = this;
        
        var focusIn = false;
        this.on('pointerdown', function(e){
            self.canChangeCamera = false
            focusIn = true;
        }, false)
        document.addEventListener('pointerup', function(e){
            if(focusIn){
                self.canChangeCamera = true
                focusIn = false;
            }
            
        }, false);

        this.on("object.added", function(e){
            if(isObject(self.controlEngine) && self.controlEngine.refresh){
                self.controlEngine.refresh();
            }
        })
    },

    renew: function(data){
        this.data = assignValue({}, data);
        this.inited = false;
        this.emit({
            type: "renew"
        })
    },

    updateSettings: function(){
        if (this.data) {
            var data = this.data;
            if (isObject(data.scene)) {
                var scene = data.scene;
                this.updateSceneSettings(scene);
                if (isObject(scene.background) && !isEmpty(scene.background))
                    this.setBackground(scene.background);
                if (isObject(scene.floor) && !isEmpty(scene.floor))
                    this.updateSceneFloorSetting(scene.floor);
                if (isObject(scene.size) && !isEmpty(scene.size))
                    this.updateSceneSettings(scene.size);
            }
            if(isObject(data.shadow))
                this.updateShadowSettings(data.shadow);
            if(isObject(data.control))
                this.updateControlSettings(data.control);
            if(isObject(data.camera))
                this.updateMainCameraSettings(data.camera, true);
        }

    },

    reset: function (data_) {
        if (isObject(data_)) this.data = assignValue({}, data_);
        this.resetObjects();
        this.resetLights();

        this.updateSettings();   
        this.setData(this.data);

        this.emit({
            type: "reset"
        })
    },


    startup: function startup( data?:any) {
        if (this.inited) return this;


        if (data && isObject(data)) {
            this.data = data;
        }
        this.Shadows = new DynamicShadows(this, this.data.shadow || this.data.shadows || {});
        this.emit('startup', this.data);

        this.initScene(this.data.scene || {});
        this.setMainCamera(this.data.camera || {});
        this.createRenderer(this.data.renderer || {}, this.data.shadow?this.data.shadow.enabled:true);
        
        this.camera.updateProjectionMatrix();
        this.setMainControl(this.data.control || {});

        this.updateSettings();
        var self = this;
        this.inited = true;
        // this.Shadows.init();
        self.ready();
        if (!this.autoRenderStatus) {
            setTimeout(function () {
                self.render();
            }, 500);
        }
    
        
        return this;

    },
    
    canChangeCamera: true,

    setControlEngine: function(controlEngine){
        if(!isObject(controlEngine)||this.controlEngine == controlEngine) return false;
        this.controlEngine = controlEngine;
        controlEngine.setMainEngine(this);
        var self = this;
        controlEngine.on("controls.change.camera", function(e){
            self.changeCameraByControlEngine(e.camera);
        });
        controlEngine.refresh();
        setTimeout(() => {
            controlEngine.refresh();
        }, 10000);
    },
    changeCameraByControlEngine: function(camera){
        if(this.canChangeCamera){
            var mainPosition = this.camera.position;
            var ctrlPosition = camera.position;
            var mainX = mainPosition.x, mainY = mainPosition.y, mainZ = mainPosition.z;
            var ctrlX = ctrlPosition.x, ctrlY = ctrlPosition.y, ctrlZ = ctrlPosition.z;
            var mainDistance = Math.sqrt(
                Math.pow(mainX, 2) + Math.pow(mainY, 2) + Math.pow(mainZ, 2)
            );
            var ctrlDistance = Math.sqrt(
                Math.pow(ctrlX, 2) + Math.pow(ctrlY, 2) + Math.pow(ctrlZ, 2)
            );
            var ratio = mainDistance / ctrlDistance;
            
            mainPosition.x = ctrlPosition.x*ratio;
            mainPosition.y = ctrlPosition.y*ratio;
            mainPosition.z = ctrlPosition.z*ratio;
            this.camera.lookAt(0, 0, 0);
            if (this.control.highPerformance && this.controlCanTurnOffShadow) {
                
                this.startDeactiveShadowTimer(500, "control");
            }
            this.refresh();

        }
    }
}) as EditorEngineClass
export default ClientEditorEngine;
export {ClientEditorEngine};
