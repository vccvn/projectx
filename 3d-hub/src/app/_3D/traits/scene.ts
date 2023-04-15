import { assignValue, inArray, isArray, isEmpty, isNumber, isObject, isString, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';
import Props, { isColor } from '../libs/props';
import { RGBELoader } from 'three/examples/jsm/loaders/RGBELoader.js';
import { RoomEnvironment } from 'three/examples/jsm/environments/RoomEnvironment.js';





// var initCount = 0;
/**
 * Các thuộc tính và phương thức xử lý scene
 */
const Scene = {
    scene: null,

    sceneHelper: null,
    showSceneHelper: false,

    sceneSettings: null,

    getScene: function (opts:any, cmt?:any) {
        var scene = new THREE.Scene();
        // this.scene = scene;
        // return null;
        var opt:any = typeof opts == "object" ? opts : {};
        Props.parse(opt);
        if (opt.env) {
            if (isString(opt.env)) {
                var env = opt.env.toLowerCase();
                this.addSimpleEnv(env, scene);
            } else if (isObject(opt.env)) {
                var t = opt.env.type ? String(opt.env.type).toLowerCase() : null;
                switch (t) {
                    case "room":
                        this.addSimpleEnv("room", scene);
                        break;

                    default:
                        break;
                }
            }
        }
        if (opt.fog) {
            if (isArray(opt.fog)) {
                scene.fog = new THREE.Fog(
                    typeof opt.fog[0] != "undefined" ? opt.fog[0] : 0xffffff,
                    typeof opt.fog[1] != "undefined" ? opt.fog[1] : 0,
                    typeof opt.fog[2] != "undefined" ? opt.fog[2] : 20000
                );
                this.renderer.setClearColor(scene.fog.color);
            } else if (isObject(opt.fog)) {
                if (opt.fog.type == 2) {
                    var params = Props.parseParams(opt.fog, ['color', 'density']);
                    scene.fog = new THREE.FogExp2(
                        params.color,
                        params.density
                    );
                } else {
                    var params = Props.parseParams(opt.fog, ['color', 'near', 'far']);
                    scene.fog = new THREE.Fog(
                        params.color,
                        params.near,
                        params.far
                    );
                }
                this.renderer.setClearColor(scene.fog.color);

            }
        } else if (opt.fogExp2) {
            if (isArray(opt.fogExp2)) {
                scene.fog = new THREE.FogExp2(
                    typeof opt.fog[0] != "undefined" ? opt.fog[0] : 0xffffff,
                    typeof opt.fog[1] != "undefined" ? opt.fog[1] : 0,
                    typeof opt.fog[2] != "undefined" ? opt.fog[2] : 20000
                );
                this.renderer.setClearColor(scene.fog.color);
            } else if (isObject(opt.fogExp2)) {

                scene.fog = new THREE.FogExp2(
                    typeof opt.fog.color != "undefined" ? opt.fog.color : 0xffffff,
                    typeof opt.fog.near != "undefined" ? opt.fog.near : 0,
                    typeof opt.fog.far != "undefined" ? opt.fog.far : 20000
                );
                this.renderer.setClearColor(scene.fog.color);

            }

            scene.fog = new THREE.Fog();
        }
        if (opt.background && !isEmpty(opt.background)) {
            this.setBackground(opt.background, scene, cmt);
        }
        if (opt.axesHelper) {
            this.addAxesHelper(opt.axesHelper, scene);
        }

        return scene;
    },
    /**
     * khởi tạo scene
     * @param {object} opts thuộc tính của scene
     */
    initScene: function (opts?:any) {
        this.sceneSettings = assignValue({}, opts);
        this.scene = this.getScene(opts, "init");
        this.sceneHelper = this.getScene(opts);
        // console.log(++initCount)
        this.emit({
            type: "scene.inited",
            data: opts
        });
        return this;
    },
    updateSceneSettings: function(data){
        assignValue(this.sceneSettings, data);
        this.emit({
            type:"scene.settings.updated",
            data: data
        });
    },

    updateSceneSizeSetting: function(size){
        assignValue(this.sceneSettings.size, size);
        this.emit({
            type:"scene.settings.updated:size",
            data: size
        });

    },
    updateSceneFloorSetting: function(floor){
        assignValue(this.sceneSettings.floor, floor);
        this.emit({
            type:"scene.settings.updated:floor",
            data: floor
        });

    },
    
    setScene: function (scene?:any) {

        this.scene.uuid = scene.uuid;
        this.scene.name = scene.name;

        this.scene.background = (scene.background !== null) ? scene.background.clone() : null;

        if (scene.fog !== null) this.scene.fog = scene.fog.clone();

        this.scene.userData = JSON.parse(JSON.stringify(scene.userData));

        // avoid render per object

        // this.signals.sceneGraphChanged.active = false;

        while (scene.children.length > 0) {

            this.addObject(scene.children[0]);

        }

        // this.signals.sceneGraphChanged.active = true;
        // this.signals.sceneGraphChanged.dispatch();

    },

    /**
     * Thêm môi trường
     * @param {string} env môi trường
     */
    addSimpleEnv: function (env?:any) {
        switch (env.toLowerCase()) {
            case "room":
                var environment = new RoomEnvironment();
                var pmremGenerator = new THREE.PMREMGenerator(this.renderer);
                this.scene.environment = pmremGenerator.fromScene(environment).texture;
                break;

            default:
                break;
        }

    },

    /**
     * set Màu nền
     * @param {int|string} color màu
     */
    setBackgroundCokor: function (color?:any, scene?:any) {
        if (!scene) scene = this.scene;
        scene.background = new THREE.Color(color);
    },

    /**
     * Set nền khung cảnh
     * @param {object} opts tham số
     */
    setBackground: function (opts?:any, scene?:any, cmt?:any) {
        if (!scene) scene = this.scene;

        if (isString(opts)) {
            if (isColor(opts)) {
                scene.background = new THREE.Color(Props.parseColorIntVal(opts)).convertSRGBToLinear();
                return true;
            }
        }
        var opt = typeof opts == "object" ? opts : {};
        Props.parse(opt);
        var t = opt && opt.type ? String(opt.type).toLowerCase() : "";

        var self = this;
        if (t == "color") {
            scene.environment = null;
            scene.background = new THREE.Color(Props.parseColorIntVal(opt.color)).convertSRGBToLinear();
            self.refresh();
            return true;
        }
        else if (inArray(['file', 'texture'], t)) {
            if (isObject(opt.texture)) opt = opt.texture;
            var f = opt && opt.format ? String(opt.format).toLowerCase() : "";
            if (opt.file) {
                if (f == 'hdr') {

                    if (this.inited) {
                        this.Loader.LoadEnv({ format: f, file: opt.file, path: opt.path || null }, function (envMap, texture) {

                            scene.background = envMap;
                            scene.environment = envMap;
                            texture.dispose();
                            self.refresh();
                        });
                        
                    }
                    else{
                        this.on('ready', function () {
                            self.setBackground(opts, scene);
                        });
            
                    }
                }
                else{
                    this.Loader.load('texture', { format: f, file: opt.file, path: opt.path || null }, function (envMap, texture) {

                        scene.background = envMap;
                        // scene.environment = envMap;
                        self.refresh();
                    });
                }
                return true;
            }
        }
        scene.background = null;
        scene.environment = null;
        self.refresh();
    },


    /**
     * them doi tuong vao khung
     * @param {object} obj doi tuong
     */
    addToScene: function (obj?:any) {

        if (!this.scene) return false;
        this.scene.add(obj);
        return true;
    },



    removeFromScene: function (object?:any) {
        this.scene.remove(object);
    },

    addAxesHelper: function (size?:any) {
        if (isNumber(size) && size > 0) {
            this.scene.add(new THREE.AxesHelper(size));
            return true;
        }
        return false;
    },


    getSceneSize: function () {

        var sceneData:any = {
            min: {
                x: null, y: null, z: null
            },
            max: {
                x: null, y: null, z: null
            }
        };
        if (this.objects) {
            this.dispatchEvent({
                type: "scene.size.get.begin"
            });
            for (var i = 0; i < this.objects.length; i++) {
                // if (Object.hasOwnProperty.call(this.objects, id)) {
                const obj = this.objects[i];
                if (obj.type == 'mesh' || obj.type == 'model') {
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
                // }

            }

            
            this.dispatchEvent({
                type: "scene.size.get.end"
            });
        }
        sceneData.size = {
            x: sceneData.max.x - sceneData.min.x,
            y: sceneData.max.y - sceneData.min.y,
            z: sceneData.max.z - sceneData.min.z
        };
        return sceneData;
    }

};

export default Scene;