import createClass from '@app/_core/helpers/es5.class';
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
import Loader from '../modules/loader'
import Composer from '../modules/composer'
import DynamicShadows from '../modules/dynamic-shadows'
import Models from '../libs/models';
import { EngineClass } from './engine.doc';
import { Floor } from '../traits/floor';



const AppEngine:EngineClass = createClass("AppEngine").uses(Scene, Camera, Renderer, Controls, Models, Lights, ObjectManager, Floor, EventDispatcher, GridHelper)({
    /**
     * @property {object} data
     */
    data: {},
    /**
     * @property {object} options
     */
    options: {},

    /**
     * 
     * @property {Mesh} Mesh 
     */
    Mesh: {},
    /**
     * @property {Geometry} Geometry
     */
    Geometry: {},
    /**
     * @property {Material} Material
     */
    Material: {},
    /**
     * @property {Light} Light
     */
    Light: {},
    /**
     * @property {Composer} Composer
     */
    Composer: {},
    /**
     * @property {Custom}
     */
    // Custom: {},

    /**
     * 
     * @property {Shadows} options 
     */
    Shadows: {},

    inited: false,

    /**
     * Hàm khởi tạo
     * @param {Dom.Query} viewport 
     * @param {*} options 
     */
    constructor: function (options?:any) {
        if (options && isObject(options)) this.setOptions(options);
    },
    setOptions: function (options?:any) {
        if (isObject(options)) this.options = options;
        if (this.options.data && isObject(this.options.data)) {
            this.data = this.options.data;
        }
    },
    startup: function startup(options?:any) {
        if (this.inited) return this;
        this.inited = true;


        if (options && isObject(options)) this.setOptions(options);
        this.emit('startup', this.options);

        this.createScene(this.data.scene || {});
        this.setMainCamera(this.data.camera || {});
        this.createRenderer(this.data.renderer || {});


        if (this.data.composer) {
            this.composer = new Composer(this, this.data.composer);
        }
        
        this.Shadows = new DynamicShadows(this, this.data.shadow || this.data.shadows || {});
        this.Geometry = Geometries;
        this.Material = Materials;
        this.Mesh = Meshes;
        this.Light = LightLib;
        this.Loader = new Loader(this);
        this.viewport.setCanvas(this.getCanvas());
        this.camera.updateProjectionMatrix();
        this.setMainControl(this.data.control || {});

        var self = this;


        if (this.data.lights && isArray(this.data.lights)) {
            this.addLights(this.data.lights);
        }
        if (this.data.models && isArray(this.data.models)) {
            this.addModels(this.data.models);
        }
        if (this.data.meshes && isArray(this.data.meshes)) {
            this.addMeshes(this.data.meshes);
        }
        if (this.data.objects && (isArray(this.data.objects) || isObject(this.data.objects))) {
            this.addObjects(this.data.objects);
        }
        if (this.data.grids && isArray(this.data.grids)) {
            this.addGrids(this.data.grids);
        }
        if (this.data.cameras && isArray(this.data.cameras)) {
            this.addCameras(this.data.cameras);
        }
        if (this.data.foregrounds && isArray(this.data.foregrounds)) {
            this.addForegrounds(this.data.foregrounds);
        }
        if (this.data.floor && isArray(this.data.floor)) {
            this.addFloor(this.data.floor);
        }
        if (this.data.controls && isArray(this.data.controls)) {
            this.addControls(this.data.controls);
        }


        // this.Shadows = new Shadows(this, this.data.shadow || this.data.shadows || {});
        // this.Shadows.init();
        self.ready();
        if (!this.autoRenderStatus) {
            setTimeout(function () {
                self.render();
            }, 500);
        }
        return this;

    }
}) as EngineClass;
export default AppEngine;
export {AppEngine};
