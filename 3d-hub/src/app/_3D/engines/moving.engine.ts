import createClass from '@app/_core/helpers/es5.class';
import { assignValue, assignWithout, isArray, isEmpty, isNumber, isObject, isString } from '@app/_core/helpers/utils';


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
import { BlankData } from '../store/data.type';
import { i } from '@app/_core/helpers/html-elements';

export interface EditorEngineInstance extends EngineInstance {
    setData(data:any): any

}
export interface EditorEngineClass extends EngineClass {
    setData(data:any): any
    new(data: any): EditorEngineInstance
    (data:any): EditorEngineInstance
}


const MovingEngine = createClass("MovingEngine").uses(
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
    $mainEngine: null,

    setData: function(data?:any){
        if (data.composer && !isEmpty(data.composer)) {
            this.composer = new Composer(this, data.composer);
        }
        if (data.meshes && isArray(data.meshes)) {
            this.addMeshes(data.meshes);
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
        
        
        this.startup();
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



    startup: function startup( data?:any) {
        if (this.inited) return this;


        if (data && isObject(data)) {
            this.data = data;
        }
        this.emit('startup', this.data);

        this.initScene(this.data.scene || {});
        this.setMainCamera(this.data.camera || {});
        this.createRenderer(this.data.renderer || {}, this.data.shadow?this.data.shadow.enabled:true);
        
        this.camera.updateProjectionMatrix();

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

    setMainEngine: function(mainEngine){
        if(!isObject(mainEngine)||this.mainEngine == mainEngine) return false;
        this.mainEngine = mainEngine;
        var scope = this;
        this.setSize(mainEngine.width, mainEngine.height);
        this.updateCamera(mainEngine.camera);
        mainEngine.on("controls.change.camera.end", function(){
            scope.updateCamera(mainEngine.camera);
        });
        mainEngine.on("controls.change.camera.animate.end", function(){
            scope.updateCamera(mainEngine.camera);
        });

        mainEngine.on("resize", function (e) {
            scope.setSize(mainEngine.width, mainEngine.height);
        });
        mainEngine.on("canvas.size.update", function (e) {
            scope.setSize(mainEngine.width, mainEngine.height);
        });
        mainEngine.on("camera.settings.updated", function (e) {
            scope.updateCamera(mainEngine.camera);
        });
        mainEngine.on("setdata", function (e) {
            scope.updateCamera(mainEngine.camera);
        });
        mainEngine.on("object.load.completed", function (e) {
            scope.updateCamera(mainEngine.camera);
        });
        
        
        if (mainEngine.inited) {
            scope.updateCamera(mainEngine.camera);
        } else {
            mainEngine.on('ready', function () {
                scope.updateCamera(scope.engine.camera);
            });

        }


    },
    updateCamera: function(camera){
        let propKeys = {
            position: ['x', 'y', 'z'],
            rotation: ['x', 'y', 'z'],
            up: ['x', 'y', 'z'],
            quaternion: ['x', 'y', 'z', 'z']
            
        }
        for (const key in propKeys) {
            if (Object.prototype.hasOwnProperty.call(propKeys, key)) {
                const arrKeys = propKeys[key];
                // arrKeys.map(s => this.camera[key][s]=camera[key][s]);
                this.camera[key].copy(camera[key], true);
            }
        }
        if(this.camera.fov != camera.fov || this.camera.aspect != camera.aspect || this.camera.near != camera.near || this.camera.far != camera.far){
            this.camera.fov = camera.fov;
            this.camera.aspect = camera.aspect;
            this.camera.near = camera.near;
            this.camera.far = camera.far;
            this.camera.updateProjectionMatrix();
        }
        this.refresh();
        
    },
    checkCamera: function(){
        this.updateCamera(this.mainEngine.camera);
    },
    add: function(){
        if(arguments.length){
            for (let index = 0; index < arguments.length; index++) {
                const arg = arguments[index];
                this.scene.add(arg);
            }
        }
    },
    remove: function(){
        if(arguments.length){
            for (let index = 0; index < arguments.length; index++) {
                const arg = arguments[index];
                this.scene.remove(arg);
            }
        }
    }
}) as EditorEngineClass
export default MovingEngine;
export {MovingEngine};
export const getMovingEngine = (mainEngine?:any) => {
    const engine = new MovingEngine(assignWithout({}, BlankData, 'lights'));
    engine.startup();
    if(mainEngine){
        engine.setMainEngine(mainEngine);
    }
    return engine;
};
