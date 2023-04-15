import createClass, { _class } from '@app/_core/helpers/es5.class';
import { isArray, isEmpty, isNumber, isObject, isString } from '@app/_core/helpers/utils';


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


import Loader from '../modules/loader';
import Composer from '../modules/composer';
import DynamicShadows from '../modules/dynamic-shadows';
import { EngineClass } from './engine.doc';

const ViewEngine = _class("ViewEngine")
.uses(
    Scene, 
    Camera, 
    Renderer, 
    Controls, 
    Models, 
    Lights, 
    ObjectManager, 
    EventDispatcher, 
    GridHelper
)({
    viewport: null,
    data: {},
    options: {},

    Mesh: {},
    Geometry: {},
    Material: {},
    Light: {},
    Composer: {},
    Shadows: {},
    inited: false,
    env: "production",

    /**
     * Hàm khởi tạo
     * @param {Dom.Query} viewport 
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
    },
    setViewport: function (viewport?:any) {
        this.viewport = viewport;
        var rect = this.viewport.getBoundingClientRect();
        var width = rect.width;
        var height = rect.height;
        this.width = Number(width);
        this.height = isNumber(height) ? Number(height) : this.width;
        this.aspect = this.width / this.height;
    },

    startup: function startup(viewport?:any, data?:any) {
        if (this.inited) return this;
        if (viewport) this.setViewport(viewport);


        if (data && isObject(data)) {
            this.data = data;
        }
        
        
        
        this.emit('startup', this.data);

        this.initScene(this.data.scene || {});
        this.setMainCamera(this.data.camera || {});
        this.createRenderer(this.data.renderer || {});
        
        this.viewport.setCanvas(this.getCanvas());
        this.camera.updateProjectionMatrix();
        this.setMainControl(this.data.control || {});


        var self = this;
        window.addEventListener('resize', function (e) {
            self.windowResize(e);
        });




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

    setData: function(data?:any){
        if (data.composer) {
            this.composer = new Composer(this, data.composer);
        }
        this.Shadows = new DynamicShadows(this, data.shadow || data.shadows || {});
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

        this.emit('setdata', data);
        
    }

}) as EngineClass;
export default ViewEngine;
export  {ViewEngine};