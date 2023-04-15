import { assignValue, assignWithout, inArray, isArray, isEmpty, isObject, isString, objectValues, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';

import Props from '../libs/props';

import { OrbitControls } from '../threejs/jsm/controls/OrbitControls.js';
import { DragControls } from '../threejs/jsm/controls/DragControls.js';
import { FirstPersonControls } from '../threejs/jsm/controls/FirstPersonControls.js';
import { FlyControls } from '../threejs/jsm/controls/FlyControls.js';
import { PointerLockControls } from '../threejs/jsm/controls/PointerLockControls.js';
import { TransformControls } from '../threejs/jsm/controls/TransformControls.js';
// import { DeviceOrientationControls } from '../threejs/jsm/controls/DeviceOrientationControls.js';
// import { EditorControls } from '../libs/EditorControls.js';


import Dom from '@app/_core/helpers/dom';



const Controls = {

    control: null,
    enableControl: true,
    controlEnableDamping: false,
    controlList: null,

    controlChangingStatus: false,

    controlDoActionAfter: 0,

    controlActionTimeout: 16,
    
    controlCheckTimer: 16,

    controlEffectTimer: 2000,

    controlActionTimeoutID: null,

    controlActionWaiting: false,

    maskLayer: null,

    controlChangingByFPSStatus: false,
    controlChangingByFPSID: null,

    boots: ['controlBoot'],
    controlBoot: function(){
        this.controlList = {};
    },
    /**
     * set control chính
     * @param {object} opts thuộc tính, tham số tạo 
     */
    setMainControl: function (opts?:any) {
        var opt = typeof opts == "object" ? opts : {};
        Props.parse(opt);
        if (opt.disabled) return this;
        var self = this;
        var control = this.getControl(opt);
        this.control = control;
        var id = opt.id || "main";
        this.controlEnableDamping = opt.enableDamping || false;
        this.control.__id = id;
        this.controlList[id] = this.control;
        
        this.control.autoUpdateScene = opt.autoUpdateScene || false;
        this.enableControl = this.control.enabled;
        // if(typeof this.control.addEventListener == "function"){
        //     this.control.addEventListener('change',  e => {
        //         self.emit('control.main.change', e);
        //         if(control.autoUpdateScene && !self.autoRenderMode && !self.controlChangeAnimateStatus){ 
        //             self.refresh();
        //         }
        //     });
        // }
        
        return this;
    },

    updateControlSettings: function(settings){
        assignWithout(this.control, settings, ['type']);
        if(isObject(settings)){
            for (const key in settings) {
                if (Object.prototype.hasOwnProperty.call(settings, key)) {
                    const vl = settings[key];
                    if(key=="enableDamping"){
                        this.controlEnableDamping = vl;
                    }else if(key == "enabled"){
                        this.enableControl = vl;
                    }
                }
            }
        }
        this.emit({
            type: "controls.main.updated",
            control: this.control
        })
        return this;
    },

    /**
     * tao control
     * @param {object} options tham số + thuộc tính
     */
    addControl: function (options?:any) {
        options.type = Str.replace(String(options.type || "").toLowerCase(), ['controls', 'control'], '');
        var control = this.getControl(options);
        control.__id = options.id || "control_" + Str.rand();
        this.scene.add(control);
        this.controlList[control.__id] = control;

        return control;
    },

    /**
     * Tạo nhiều control
     * @param {array} controls 
     */
    addControls: function (controls?:any[]) {
        if (isArray(controls)) {
            for (let i = 0; i < controls.length; i++) {
                const ctlopt = controls[i];
                if (isObject(ctlopt)) {
                    this.addControl(ctlopt);
                }
            }
        }
    },


    /**
     * lấy control từ ThreeJS
     * @param {object} options thuộc tính và tham số
     */
    getControl: function (options?:any) {
        if (!isObject(options) || isEmpty(options)) return null;
        var self = this;
        Props.parse(options);
        var control;
        var type = Str.replace(String(options.type || "").toLowerCase(), ['controls', 'controls'], '');
        var p = options.params || options;

        // device animatetion
        // if (inArray(['deviceorientation', 'device'], type)) {
        //     if (options.object) {
        //         control = new DeviceOrientationControls(options.object);
        //     }
        // }

        // else 
        if (inArray(['drag', 'drop'], type)) {
            var dfo = objectValues(this.objects).map(function (o:any) { return o.object });
            var params = Props.parseParams(p, {
                objects: [...dfo], camera: this.camera, domElement: this.renderer.domElement
            });
            control = new DragControls(params.objects, params.camera, params.domElement);

            control.addEventListener('dragstart', function (event) {

                event.object.material.emissive.set(0xaaaaaa);

            });

            control.addEventListener('dragend', function (event) {

                event.object.material.emissive.set(0x000000);

            });
        }

        else if (inArray(['firstperson', 'fp', 'person'], type)) {
            var params = Props.parseParams(p, {
                camera: this.camera, domElement: this.renderer.domElement
            });
            control = new FirstPersonControls(params.camera, params.domElement);

        }

        else if (inArray(['fly', 'f'], type)) {
            var params = Props.parseParams(p, {
                camera: this.camera, domElement: this.renderer.domElement
            });
            control = new FlyControls(params.camera, params.domElement);

        }

        else if (inArray(['pointerlock', 'pointer', 'pl'], type)) {
            var params = Props.parseParams(p, {
                camera: this.camera, domElement: document.body
            });
            control = new PointerLockControls(params.camera, params.domElement);

            var instructions = Dom('div.instructions',{
                    onClick: function () {
                        control.lock();
                    }
                },
                [
                    Dom('span', 'Click to play', {
                        style: {
                            fontSize: '14px'
                        }
                    }),
                    Dom("br"),
                    Dom("br"),
                    'Move: WASD',
                    Dom("br"),
                    'Jump: SPACE',
                    Dom("br"),
                    'Look: MOUSE'
                ]
            );


            var blocker = Dom('div.blocker', instructions);

            document.body.appendChild(blocker.el);


            control.addEventListener('lock', function () {

                instructions.el.style.display = 'none';
                blocker.el.style.display = 'none';

            });


            control.addEventListener('unlock', function () {

                blocker.el.style.display = 'block';
                instructions.el.style.display = '';

            });

        }

        else if (inArray(['transform', 'tf'], type)) {
            var params = Props.parseParams(p, {
                camera: this.camera, domElement: this.renderer.domElement
            });
            control = new TransformControls(params.camera, params.domElement);

            var orbit = self.getAddedControl(options.orbit);
            if (!orbit) return false;

            var cameraOrtho = self.getAddedCamera(options.ortho);
            var cameraPersp = self.getAddedCamera(options.persp);
            if (!orbit || !cameraOrtho || cameraPersp) return false;

            control.addEventListener('change', function (e) {
                self.refresh();
            });

            control.addEventListener('dragging-changed', function (event) {

                orbit.enabled = !event.value;

            });

            if (options.mesh) {
                var mesh;
                if (typeof options.mesh == "object") {
                    if (options.mesh.isMesh) {
                        mesh = options.mesh;
                        this.addToScene(mesh);
                    } else {
                        var id = this.addMesh(options.mesh);
                        if (id) {
                            mesh = this.getObject(id).object;
                        }
                    }
                } else {
                    var o = this.getObject(options.mesh);
                    if (o) {
                        mesh = o.object;
                    }
                }
                if (mesh) {
                    control.attach(mesh);
                }
            } else if (options.object) {
                var mesh;
                if (typeof options.object == "object") {
                    if (options.object.isMesh) {
                        mesh = options.object;
                        this.addToScene(mesh);
                    } else {
                        var id = this.addMesh(options.object);
                        if (id) {
                            mesh = this.getObject(id).object;
                        }
                    }
                } else {
                    var o = this.getObject(options.object);
                    if (o) {
                        mesh = o.object;
                    }
                }
                if (mesh) {
                    control.attach(mesh);
                }
            }

            window.addEventListener('keydown', function (event) {
                switch (event.keyCode) {

                    case 81: // Q
                        control.setSpace(control.space === "local" ? "world" : "local");
                        break;

                    case 16: // Shift
                        control.setTranslationSnap(100);
                        control.setRotationSnap(THREE.MathUtils.degToRad(15));
                        control.setScaleSnap(0.25);
                        break;

                    case 87: // W
                        control.setMode("translate");
                        break;

                    case 69: // E
                        control.setMode("rotate");
                        break;

                    case 82: // R
                        control.setMode("scale");
                        break;

                    case 67: // C
                        const position = self.camera.position.clone();

                        self.camera = self.camera.isPerspectiveCamera ? cameraOrtho : cameraPersp;
                        self.camera.position.copy(position);

                        orbit.object = self.camera;
                        control.camera = self.camera;

                        self.camera.lookAt(orbit.target.x, orbit.target.y, orbit.target.z);
                        self.windowResize();
                        break;

                    case 86: // V
                        const randomFoV = Math.random() + 0.1;
                        const randomZoom = Math.random() + 0.1;

                        cameraPersp.fov = randomFoV * 160;
                        cameraOrtho.bottom = - randomFoV * 500;
                        cameraOrtho.top = randomFoV * 500;

                        cameraPersp.zoom = randomZoom * 5;
                        cameraOrtho.zoom = randomZoom * 5;
                        self.windowResize();
                        break;

                    case 187:
                    case 107: // +, =, num+
                        control.setSize(control.size + 0.1);
                        break;

                    case 189:
                    case 109: // -, _, num-
                        control.setSize(Math.max(control.size - 0.1, 0.1));
                        break;

                    case 88: // X
                        control.showX = !control.showX;
                        break;

                    case 89: // Y
                        control.showY = !control.showY;
                        break;

                    case 90: // Z
                        control.showZ = !control.showZ;
                        break;

                    case 32: // Spacebar
                        control.enabled = !control.enabled;
                        break;

                }

            });

            window.addEventListener('keyup', function (event) {

                switch (event.keyCode) {

                    case 16: // Shift
                        control.setTranslationSnap(null);
                        control.setRotationSnap(null);
                        control.setScaleSnap(null);
                        break;

                }

            });


        }
        else if (inArray(['editor', 'editorcontrols', 'ec'], type)) {
            var params = Props.parseParams(p, {
                camera: this.camera, domElement: this.renderer.domElement
            });
            control = new FlyControls(params.camera, params.domElement);

        }

        else {
            control = new OrbitControls(this.camera, this.renderer.domElement);
            // control.enableDamping = true;
        }

        
        assignWithout(control, options, ['type', 'disabled', 'params', 'args', 'useMask']);
        return control;
    },

    getAddedControl: function (id) {
        return typeof this.controlList[id] != "undefined" ? this.controlList[id] : null;
    },

    setCurrentConttrolProp: function (prop, value) {
        if (isString(prop)) {
            this.control[prop] = value;
        } else if (isObject(prop) && !isEmpty(prop)) {
            assignValue(this.control, prop);
        }
    }
};

export default Controls;
export {Controls};
