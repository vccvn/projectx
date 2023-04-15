import createClass from '@app/_core/helpers/es5.class';
import { assignValue, isArray, isEmpty, isNumber, isObject, isString, objectHasKey } from '@app/_core/helpers/utils';


import Scene from '../traits/scene';
import Camera from '../traits/camera';
import Renderer from '../traits/renderer';
import Controls from '../traits/controls';
import Lights from '../traits/lights';
import ObjectManager from '../traits/object-manager';
import { EventDispatcher } from '../libs/event-dispatcher';



import { Geometries, LightLib, LoaderLib, Materials, Meshes } from '../libs/three.libs';




import Loader from '../modules/loader'
import Composer from '../modules/composer'
import DynamicShadows from '../modules/dynamic-shadows'
import { EngineClass } from './engine.doc';
import { AppData, AppDefaultData } from '../store/data.type';


var ControlsEngine = createClass("ControlsEngine").uses(Scene, Camera, Renderer, Controls, Lights, ObjectManager, EventDispatcher)({
    $data: {},
    $options: {},

    $Mesh: {},
    $Geometry: {},
    $Material: {},
    $Light: {},
    $Composer: {},
    Shadows: {},
    inited: false,
    $mainEngine: null,
    boots: ["bootstrap"],
    bootstrap: function () {
        this.data = {};
        this.options = {};

        this.Mesh = {};
        this.Geometry = {};
        this.Material = {};
        this.Light = {};
        this.Composer = {};
        this.Shadows = {};

    },
    /**
     * Hàm khởi tạo
     * @param {Dom} viewport 
     * @param {*} data 
     */
    constructor: function (data?: any) {
        if (data && isObject(data)) {
            this.data = assignValue({}, data);
        }
        this.Geometry = Geometries;
        this.Material = Materials;
        this.Mesh = Meshes;
        this.Light = LightLib;
        this.Loader = new Loader(this);

        this.Shadows = new DynamicShadows(this, data.shadow || data.shadows || {});
        this.startup();
    },

    startup: function startup(data?: any) {
        if (this.inited) return this;


        if (data && isObject(data) && !isEmpty(data)) {
            this.data = assignValue({}, data);
        }




        this.emit('startup', this.data);

        this.initScene(this.data.scene || {});
        this.setMainCamera(this.data.camera || {});
        this.createRenderer(this.data.renderer || {}, this.data.shadow ? this.data.shadow.enabled : true);

        this.camera.updateProjectionMatrix();
        this.setMainControl(this.data.control || {});


        var self = this;
        this.inited = true;
        
        
        // this.Shadows.init();
        self.ready();
        if (!this.autoRenderStatus) {
            setTimeout(function () {
                self.render();
            }, 500);
        }
        
        var canvas = this.getCanvas();
        var focusIn = false;
        canvas.addEventListener('pointerdown', function(e){
            self.canChangeCamera = false
            focusIn = true;
        }, false)
        document.addEventListener('pointerup', function(e){
            if(focusIn){
                self.canChangeCamera = true
                focusIn = false;
            }
            
        }, false)

        this.setData(this.data);
        return this;

    },

    setData: function (data?: any) {
        // if (data.composer && !isEmpty(data.composer)) {
        //     this.composer = new Composer(this, data.composer);
        // }
        if (data.lights && isArray(data.lights)) {
            this.addLights(data.lights);
        }
        if (data.meshes && isArray(data.meshes)) {
            this.addMeshes(data.meshes);
        }
        if (data.objects && (isArray(data.objects) || isObject(data.objects))) {
            this.addObjects(data.objects);
        }
        if (data.cameras && isArray(data.cameras)) {
            this.addCameras(data.cameras);
        }
        if (data.controls && isArray(data.controls)) {
            this.addControls(data.controls);
        }

        this.emit('setdata', data);
    },
    canChangeCamera: true,
    setMainEngine: function(engine){
        if(engine == this.mainEngine) return false;
        this.mainEngine = engine;
        var self = this
        engine.on("controls.change.camera", function(e){
            self.changeCameraByMain(e.camera);
        });
        engine.on("controls.main.updated", function(e){
            self.control.enabled = e.control.enabled;
            self.control.enableRotate = e.control.enableRotate;

            
        });
        
        

        self.on("controls.change.camera.end", function(){
            engine.emit("controls.change.camera.end");
        });
        self.on("controls.change.camera.animate.end", function(){
            engine.emit("controls.change.camera.animate.end");
        });
        let propKeys = {
            rotation: ['x', 'y', 'z'],
            quaternion: ['x', 'y', 'z', 'z']
            
        }
        for (const key in propKeys) {
            if (objectHasKey(propKeys, key)) {
                const arrKeys = propKeys[key];
                arrKeys.map(s => this.camera[key][s]=engine.camera[key][s]);
            }
        }
        
        self.changeCameraByMain(engine.camera);
        self.control.enabled = engine.control.enabled;
        self.control.enableRotate = engine.control.enableRotate;

        setTimeout(function () {
            self.changeCameraByMain(engine.camera);
        }, 100)
    },
    changeCameraByMain: function(camera){
        if(this.canChangeCamera){
            var p = camera.position;
            var q = this.camera.position;
            var mainX = p.x, mainY = p.y, mainZ = p.z;
            var ctrlX = q.x, ctrlY = q.y, ctrlZ = q.z;
            var mainDistance = Math.sqrt(
                Math.pow(mainX, 2) + Math.pow(mainY, 2) + Math.pow(mainZ, 2)
            );
            var ctrlDistance = Math.sqrt(
                Math.pow(ctrlX, 2) + Math.pow(ctrlY, 2) + Math.pow(ctrlZ, 2)
            );
            var ratio = mainDistance/ctrlDistance;
            q.x = p.x/ratio;
            q.y = p.y/ratio;
            q.z = p.z/ratio;
            this.camera.lookAt(0, 0, 0);
            this.refresh();

        }
    }
}) as EngineClass;


const controlData: AppData = assignValue({}, AppDefaultData);
assignValue(controlData, {
    scene: {
        floor: {
            enabled: false,
            above: false
        }
    },
    renderer: {
        params: {
            alpha: true
        }
    },
    control: {
        type: "orbit",
        autoUpdateScene: true,
        maxDistance: 3,
        minDistance: 3,
        enableDamping: true,
        dampingFactor: 0.1,
        enablePan: false,
        enabled: true,
        highPerformance: false,
        constraint: {
            smoothZoom: true,
            zoomDampingFactor: 0.2,
            smoothZoomSpeed: 5
        },
        settings: {
            enabled: true
        }
    },
    camera: {
        fov: 45,
        near: 0.001,
        far: 10,
        position: {
            x: 0,
            y: 0,
            z: 3
        },

        autofit: true,
        settings: {
            position: {
                type: "default",
                face: "front",
                custom: {
                    x: 0,
                    y: 0,
                    z: 2
                }
            }
        }
    },
    shadow:{
        enabled: false,
    },
    lights: [
        {
            type: "ambient",
            data: {
                params: {
                    color: "#ffffff",
                    intensity: 0.5
                }
            },
            secret_key: "DUkWmYXqHLn30h8srtGc1fClZ5VBh7Vs"
        },
        {
            type: "point",
            data: {
                params: {
                    color: "#4444cc",
                    intensity: 0.3
                },
                props: {
                    position: {
                        x: 0,
                        y: -10
                    }
                }
            },
            secret_key: "QT2uvl11GYiE9lBJ31kWLN7uZ4LVUY5h"
        },
        {
            type: "Directionallight",
            data: {
                params: {
                    color: "#FFE0B5",
                    intensity: 0.4
                },
                props: {
                    position: {
                        x: 4,
                        y: 4,
                        z: 3
                    }
                }
            },
            secret_key: "4SBlh9qasmkym2qVinqXZQmrE1wyPz4g"
        },
        {
            type: "Directionallight",
            data: {
                params: {
                    color: "#FFE0B5",
                    intensity: 0.4
                },
                props: {
                    position: {
                        x: 6,
                        y: 3,
                        z: 3
                    }
                }
            },
            secret_key: "FSFhrzuO3FGYgYwdNRfMIaTuF0vwNr53"
        },
        {
            type: "Directionallight",
            data: {
                params: {
                    color: "#FFE0B5",
                    intensity: 0.4
                },
                props: {
                    position: {
                        x: -6,
                        y: -2,
                        z: 1
                    }
                }
            },
            secret_key: "FSFhrzuO3FGYgYwdNRfMIaTuF0vwNr53"
        },
        {
            secret_key: "wnrnh6P4c3lYDTJDWv3MUOkjp1ds3eOF",
            type: "Directionallight",
            data: {
                params: {
                    color: "#FFE0B5",
                    intensity: 0.28
                },
                props: {
                    position: {
                        x: 5.521934041179776,
                        y: 10,
                        z: -9.240062491735568
                    }
                }
            }
        }
    ],
    meshes: [
        {
            secret_key: "GvhCqPx4aBGSCkBQUvPoyMI2uw0EGWWj",
            data: {
                geometry: {
                    type: "plane",
                    width: 1,
                    height: 1
                },
                material: {
                    type: "physical",
                    color: "#b9e6ff",
                    side: "2",
                    map: "/assets/images/controls/cube/front.png"

                },
                props: {
                    name: "front",
                    position: {
                        x: 0,
                        y: 0,
                        z: 0.5
                    }
                }
            }
        },
        {
            secret_key: "GvhCqPx4aBGSCkBQUvPoyMI2uhityurtfut",
            data: {
                geometry: {
                    type: "plane",
                    width: 1,
                    height: 1
                },
                material: {
                    type: "physical",
                    color: "#b9e6ff",
                    side: "2",
                    map: "/assets/images/controls/cube/back.png"

                },
                props: {
                    name: "back",
                    position: {
                        x: 0,
                        y: 0,
                        z: -0.5
                    },
                    rotation: {
                        y: Math.PI
                    }
                }
            }
        },
        {
            secret_key: "GvhCqPx4aBGSCkBQUvPoyMI5452uhityurtfut",
            data: {
                geometry: {
                    type: "plane",
                    width: 1,
                    height: 1
                },
                material: {
                    type: "physical",
                    color: "#b9e6ff",
                    side: "2",
                    map: "/assets/images/controls/cube/left.png"

                },
                props: {
                    name: "left",
                    position: {
                        x: -0.5,
                        y: 0,
                        z: 0
                    },
                    rotation: {
                        y: -Math.PI / 2
                    }
                }
            }
        },
        {
            secret_key: "GvhCqP5452uhityurtfut",
            data: {
                geometry: {
                    type: "plane",
                    width: 1,
                    height: 1
                },
                material: {
                    type: "physical",
                    color: "#b9e6ff",
                    side: "2",
                    map: "/assets/images/controls/cube/right.png"

                },
                props: {
                    name: "right",
                    position: {
                        x: 0.5,
                        y: 0,
                        z: 0
                    },
                    rotation: {
                        y: Math.PI / 2
                    }
                }
            }
        },
        {
            secret_key: "GvhCqP54mkljh52uhityurtfut",
            data: {
                geometry: {
                    type: "plane",
                    width: 1,
                    height: 1
                },
                material: {
                    type: "physical",
                    color: "#b9e6ff",
                    side: "2",
                    map: "/assets/images/controls/cube/top.png"

                },
                props: {
                    name: "top",
                    position: {
                        x: 0,
                        y: 0.5,
                        z: 0
                    },
                    rotation: {
                        x: -Math.PI / 2
                    }
                }
            }
        },
        {
            secret_key: "GvhCqPkojojibh52uhityurtfut",
            data: {
                geometry: {
                    type: "plane",
                    width: 1,
                    height: 1
                },
                material: {
                    type: "physical",
                    color: "#b9e6ff",
                    side: "2",
                    map: "/assets/images/controls/cube/bottom.png"

                },
                props: {
                    name: "bottom",
                    position: {
                        x: 0,
                        y: -0.5,
                        z: 0
                    },
                    rotation: {
                        x: Math.PI / 2
                    }
                }
            }
        }
    ]
});

export const ControlSyncEngine = new ControlsEngine(controlData);
export const getControlEngine = () => new ControlsEngine(controlData);
export { ControlsEngine };
export default ControlsEngine;
