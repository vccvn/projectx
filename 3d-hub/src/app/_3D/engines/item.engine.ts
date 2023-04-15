import createClass, { _class } from '@app/_core/helpers/es5.class';
import { assignValue, isArray, isEmail, isEmpty, isNumber, isObject, isString } from '@app/_core/helpers/utils';


import Scene from '../traits/scene';
import Camera from '../traits/camera';
import Renderer from '../traits/renderer';
import Controls from '../traits/controls';
import GridHelper from '../traits/grid-helper';
import Lights from '../traits/lights';
import ObjectManager from '../traits/object-manager';
import { EventDispatcher } from '../libs/event-dispatcher';


import { Geometries, LightLib, LoaderLib, Materials, Meshes } from '../libs/three.libs';

import Loader from '../modules/loader';
import Composer from '../modules/composer';
import DynamicShadows from '../modules/dynamic-shadows'
import Models from '../libs/models';
import { EngineClass } from './engine.doc';
import { Floor } from '../traits/floor';


const ItemEngine = _class("ItemEngine")
    .uses(
        Scene,
        Camera,
        Renderer,
        Controls,
        Models,
        Lights,
        Floor,
        ObjectManager,
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
        /**
         * Hàm khởi tạo
         * @param {Dom.Query} viewport 
         * @param {*} data 
         */
        constructor: function (config?: any) {
            var data = isObject(config) ? config.data || config : {};
            if (data && isObject(data)) {
                this.data = data;
            }
            this.Geometry = Geometries;
            this.Material = Materials;
            this.Mesh = Meshes;
            this.Light = LightLib;
            this.Loader = new Loader(this);
        },



        renew: function (data) {
            this.data = assignValue({}, data);
            // this.inited = false;

        },


        reset: function (data_) {
            if (isObject(data_)) this.data = assignValue({}, data_);
            this.resetObjects();
            this.resetLights();

            if (this.data) {
                var data = this.data;
                if (isObject(data.scene)) {
                    var scene = data.scene;
                    this.updateSceneSettings(scene);
                    if (isObject(scene.background) && !isEmpty(scene.background))
                        this.setBackground(scene.floor);
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
            
            this.setData(this.data);
        },

        startup: function startup(data?: any) {
            if (this.inited) return this;


            if (data && isObject(data)) {
                this.data = data;
            }

            this.emit('startup', this.data);

            this.initScene(this.data.scene || {});
            this.setMainCamera(this.data.camera || {});
            this.createRenderer(this.data.renderer || {});

            this.camera.updateProjectionMatrix();
            this.setMainControl(this.data.control || {});
            if (this.data.composer && !isEmail(this.data.composer)) {
                this.composer = new Composer(this, this.data.composer);
            }
            this.Shadows = new DynamicShadows(this, this.data.shadow || this.data.shadows || {});


            var self = this;
            this.setData(this.data);

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

        setData: function (data?: any) {
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


export default ItemEngine;
export { ItemEngine }