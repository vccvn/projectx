import { assignValue, assignWithout, getTimeStamp, inArray, isArray, isEmpty, isNumber, isObject, isString, newObj, objectValues, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';
import { TransformControls } from '../threejs/jsm/controls/TransformControls';
import { _class } from '@app/_core/helpers/es5.class';
import { EventDispatcher, EventDispatcherInstance } from './event-dispatcher';
import { registerAnimationTask } from './animation-loop';
import { SceneSize, SizeIn3D, Vector2, Vector3 } from '../store/data.type';
import { EditorClass, iEditor } from '../store/docs';
import { getMovingEngine } from '../engines/moving.engine';

const Editor__: any = _class("Editor").uses(EventDispatcher)({
    $dynamicCreateMode: true,
    $control: null,
    $engine: null,
    $selected: null,
    $pickers: null,
    $currentLight: null,
    $currentObject: null,
    $currentTargetControl: null,
    animationTasks: null,
    animationStatus: false,
    animationTimeStart: 0,
    animationTimeCount: 0,
    poiterDowsStatus: false,
    isHoldObject: false,
    hasDroppablePosition: false,
    animation: null,
    app: null,
    meshes: null,
    moving: null,
    movingRaycaster: null,
    dragMoveColRows: 101,
    
    constructor: function constructor(app, engine: any) {
        this.setup(app, engine);
    },

    setup: function setup(app, engine) {
        this.app = app;
        var scope: iEditor = this;
        this.engine = engine;
        if (engine.inited) {
            this.startup();
            // console.log(engine);
        } else {
            this.engine.on('ready', function () {
                scope.startup();
            });

        }
    },
    refresh: function () {
        this.engine.refresh();
    },

    ready: function () {
        var scope: iEditor = this;
        scope.animation = registerAnimationTask(scope.getInstanceID())
        this.moving = getMovingEngine(this.engine);
        // this.moving.setSize(this.engine.width, this.engine.height);
        // this.moving.setMainEngine(this.engine);
        this.animationTasks = {
            check: function () {
                var currentTime = getTimeStamp();
                if (scope.animationStatus && currentTime - scope.animationTimeStart >= scope.animationTimeCount) {
                    if (scope.restoreShadow()) {
                        scope.animationStatus = false;
                        scope.animationTimeCount = 0;
                        scope.engine.refresh();
                        scope.animation.remove("editorCheck");
                    }

                    // console.log("remove check and remove")
                }
            }
        };

        // document.addEventListener("pointerup", function () {
        //     scope.poiterDowsStatus = false;
        // })

        this.meshes = [];

        scope.scene = scope.engine.scene;
        var box = new THREE.Box3();

        var selectionBox = new THREE.BoxHelper();
        selectionBox.material.depthTest = false;
        selectionBox.material.transparent = true;
        selectionBox.visible = false;
        scope.selectionBox = selectionBox;
        scope.box = box;
        scope.scene.add(selectionBox);

        scope.cursor = {
            x: 0,
            y: 0
        };
        scope.objects = [];
        scope.lights = [];
        scope.pickers = [];
        scope.attachObjects = [];
        scope.targets = [];
        scope.targetControlObjects = {};
        scope.helpers = {};
        scope.currentLight = null;
        scope.currentObject = null;
        scope.currentTargetControl = null;

        // scope.sceneHelper = scope.engine.sceneHelper;
        // scope.engine.showSceneHelper = true;

        scope.raycaster = new THREE.Raycaster();
        scope.pointer = new THREE.Vector2();
        scope.onUpPosition = new THREE.Vector2();
        scope.onDownPosition = new THREE.Vector2();
        scope.movingRaycaster = new THREE.Raycaster();


        var control = new TransformControls(scope.engine.camera, scope.engine.renderer.domElement);
        scope.engine.scene.add(control);

        control.addEventListener('change', function () {
            var object = control.object;
            if (object) {
                if (object.isTargetControlObject) {
                    scope.updateLightTargetByTargetControlObject(object)
                }
                else if (object.isLight) {
                    scope.updateHelperByLight(object);
                }
                else {
                    scope.updateHelperByObject(object);
                }
            }
            if (scope.isHoldObject) {
                scope.turnOffShadow();
            }

            scope.engine.refresh();
        });

        control.addEventListener('dragging-changed', function (event) {
            if (event.value) {
                scope.engine.controlCanUpdate = false;
            }
            if (scope.engine.enableControl) {
                scope.engine.control.enabled = !event.value;
            }

            // console.log(JSON.stringify(control));
            // console.log(event.value);
            var object = control.object;
            var e = newObj({
                type: "object.changed",
                data: scope.currentObject,
                mode: control.mode
            })
            if (object !== undefined) {
                if (object.isTargetControlObject) {
                    scope.updateLightTargetByTargetControlObject(object);
                    e.type = 'light.update.target';
                    e.data = {
                        x: object.position.x,
                        y: object.position.y,
                        z: object.position.z
                    };
                    e.light = object.light;
                }
                else if (object.isLight) {
                    e.type = 'light.update.props';
                    e.data = {
                        x: object.position.x,
                        y: object.position.y,
                        z: object.position.z
                    };
                    e.light = object;
                }

            }
            if (event.value) {
                scope.turnOffShadow();
            }
            scope.isHoldObject = event.value;
            // scope.turnOffShadow();

            scope.engine.refresh();
            if (!event.value) {
                scope.engine.controlCanUpdate = true;
            }

            scope.dispatchEvent(e);

        });
        control.addEventListener('objectChange', function () {
            // console.log("change");
        });

        // control.enabled = false;
        scope.control = control;


        window.addEventListener('keyup', function (event) {
            switch (event.keyCode) {
                case 16: // Shift
                    scope.control.setTranslationSnap(null);
                    scope.control.setRotationSnap(null);
                    scope.control.setScaleSnap(null);
                    scope.engine.refresh();
                    break;

            }

        });


        scope.engine.on('object.added', function (event) {
            var data = event.data;
            // if(data.type == "model"){
            scope.addObject(data.object);
            // }
            scope.addMeshByObject(data.object);


        });


        scope.engine.on('object.removed', function (event) {
            var data = event.data;
            scope.removeObject(data.object);

            scope.removeMeshByObject(data.object);


        });
        scope.engine.on('light.added', function (event) {
            var data = event.data;
            scope.addLight(data.object);
        });




        scope.engine.on('light.removing', function (event) {
            if (event.light) {
                if (scope.currentLight == event.light.object) {
                    scope.detachLight();
                }
            }

        });
        scope.engine.on('light.removed', function (event) {
            // console.log(event.data.object)
            scope.removeLight(event.data.object)

        });

        scope.engine.on('object.update.props', function (event) {
            scope.updateHelperByObject(event.data.object);

        });

        scope.engine.on('object.update.geometry', function (event) {
            scope.updateHelperByObject(event.data.object);

        });

        scope.engine.on('light.update', function (event) {
            scope.updateHelperByLight(event.data.object);

        });


        var pointerDownPos = {
            x: 0,
            y: 0
        }
        var pointerUpPos = {
            x: 0,
            y: 0
        }
        var lastPointerUpTime = getTimeStamp();
        var pointerDownStatus = false;
        this.on("pointerdown", function (e) {
            pointerDownPos = {
                x: e.clientX,
                y: e.clientY
            };
            pointerDownStatus = true;
        });
        this.on('pointerup', function (event) {
            if (!pointerDownStatus) return;

            var currentTime = getTimeStamp();
            if (
                pointerUpPos && pointerDownPos
                && pointerDownPos.x == event.clientX && pointerUpPos.x == event.clientX
                && pointerDownPos.y == event.clientY && pointerUpPos.y == event.clientY
                && currentTime - lastPointerUpTime <= 400
            ) {
                scope.emit({
                    type: "dbclick",
                    clientX: event.clientX,
                    clientY: event.clientY
                });

            }
            lastPointerUpTime = currentTime;
            pointerUpPos = {
                x: event.clientX,
                y: event.clientY
            };
            pointerDownStatus = false;
        });





    },
    changeCameraByMain: function (camera) {
        this.camera.copy(camera, true);

    },
    addEventDefault: function () {
        var scope: iEditor = this;

        this.addEventListener('pointerdown', onPointerDown);
        this.addEventListener('pointerup', onPointerUp);
        this.addEventListener('pointermove', onPointerMove);

        // window['editor'] = this;


        window.addEventListener('keydown', function (event) {

            switch (event.keyCode) {
                case 81: // Q
                    scope.executeCommand("space");
                    break;
                case 16: // Shift
                    scope.executeCommand("snap");
                    break;
                case 87: // W
                    scope.executeCommand("translate");
                    scope.emit({
                        type: "control.mode.change",
                        node: "translate"
                    });

                    break;
                case 69: // E
                    scope.executeCommand("rotate");
                    scope.emit({
                        type: "control.mode.change",
                        node: "rotate"
                    });

                    break;
                case 82: // R
                    scope.executeCommand("scale");
                    scope.emit({
                        type: "control.mode.change",
                        node: "scale"
                    });
                    break;
                case 187:
                case 107: // +, =, num+
                    scope.executeCommand("upsize");
                    break;
                case 189:
                case 109: // -, _, num-
                    scope.executeCommand("downsize");
                    break;
                case 88: // X
                    scope.executeCommand("toggle:x");
                    break;
                case 89: // Y
                    scope.executeCommand("toggle:y");
                    break;
                case 90: // Z
                    scope.executeCommand("toggle:z");
                    break;
                case 32: // Spacebar
                    scope.executeCommand("enable");
                    break;
                case 46: // delete
                    scope.deleteAttach();
                    break;

                default:
                    break;
            }
        });


        function onPointerDown(event) {
            scope.poiterDowsStatus = true;
            var rect = scope.engine.wrapper.getBoundingClientRect();

            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;
        }

        function onPointerUp(event) {
            // scope.poiterDowsStatus = false;
            var rect = scope.engine.wrapper.getBoundingClientRect();
            scope.onUpPosition.x = event.clientX - rect.left;
            scope.onUpPosition.y = event.clientY - rect.top;
            if (scope.onUpPosition.x < 0 || scope.onUpPosition.y < 0) return;

            if (scope.onDownPosition.distanceTo(scope.onUpPosition) === 0) {
                scope.pointer.x = (scope.onUpPosition.x / rect.width) * 2 - 1;
                scope.pointer.y = - (scope.onUpPosition.y / rect.height) * 2 + 1;
                scope.selectObjectByPointer(scope.pointer);

            }

        }

        function onPointerMove(event) {
            if (scope.poiterDowsStatus) {
                // scope.turnOffShadow();
            }

        }
    },

    startup: function () {
        this.addEventDefault();
        this.ready();
        this.setEngineData();
        this.emit({
            type: "startup",
            data: getTimeStamp()
        })

    },

    setEngineData: function () {
        this.engine.setData(this.engine.data);
        this.engine.refresh();

    },

    addMeshByObject: function (object) {
        var scope: iEditor = this;
        var o = scope.engine.getObject(object);
        if (o && o.type == "model") {
            if (o.meshes && o.meshes.length) {
                o.meshes.map(function (mesh) {
                    Object.defineProperty(mesh, "__parent__id__", {
                        enumerable: false,
                        writable: false,
                        configurable: false,
                        value: o.object.id
                    })
                    Object.defineProperty(mesh, "__parent__key__", {
                        enumerable: false,
                        writable: false,
                        configurable: false,
                        value: o.secret_key
                    })
                    scope.meshes.push(mesh);
                })
            }
        }
    },
    removeMeshByObject: function (object) {
        var a = [];
        var scope: iEditor = this;
        this.meshes.map(function (mesh) {
            if (mesh.__parent_id__ == object.id) {
                a.push(mesh);
            }
        });
        if (a.length) {
            for (let i = 0; i < a.length; i++) {
                const m = a[i];
                var index = this.meshes.indexOf(m);
                if (m >= 0) {
                    this.meshes.splice(index, 1);
                }
            }
        }
    },







    restoreShadow: function () {
        if (this.animationStatus && !this.engine.deactiveShadowStatus) {
            this.engine.Shadows.restore();
            this.animationStatus = false;
            return true;
        }
        return false;

    },
    turnOffShadow: function (timer) {
        var scope = this;
        this.animationTimeCount = isNumber(timer) && timer > 0 ? timer : 500;
        this.animationTimeStart = getTimeStamp();
        if (!this.animationStatus && !this.engine.deactiveShadowStatus) {
            this.animationStatus = true;
            this.engine.Shadows.off();
            // this.engine.refresh();
            if (!scope.animation.has("editorCheck")) {
                scope.animation.add("editorCheck", this.animationTasks.check);
            }
        }

    },

    updateHelperByObject: function (object: any) {
        var scope = this;
        if (object !== undefined) {
            var helper = scope.helpers[object.id];

            if (helper !== undefined && helper.isSkeletonHelper !== true) {
                if (object.position) helper.position.copy(object.position);
                if (object.rotation) helper.rotation.copy(object.rotation);
                if (object.scale) helper.scale.copy(object.scale);
                helper.update();

            }

            // signals.refreshSidebarObject3D.dispatch(object);
            scope.engine.refresh();
        }
    },
    updateHelperByLight: function (object: any) {
        var scope = this;
        if (object !== undefined) {


            // scope.helper.scale.copy(object.scale);
            // selectionBox.setFromObject(object);

            var helper = scope.helpers[object.id];

            if (helper !== undefined && helper.isSkeletonHelper !== true) {
                if (object.position) helper.position.copy(object.position);
                if (object.rotation) helper.rotation.copy(object.rotation);
                if (object.scale) helper.scale.copy(object.scale);
                helper.update();

            }

            // signals.refreshSidebarObject3D.dispatch(object);
            scope.engine.refresh();
        }
    },

    /**
     * cập nhật vị trí target light
     * @param
     */
    updateLightTargetByTargetControlObject: function (targetControl: any) {
        if (targetControl.isTargetControlObject) {
            var target = targetControl.targetControl;
            target.position.copy(targetControl.position);
            target.needsUpdate = true;
            this.updateHelperByLight(targetControl.light);

        }
    },
    addObject: function (object: any) {
        this.objects.push(object);
        this.select(object);
    },


    removeObject: function (object: any) {

        this.removeHelper(object);
        // if (object.parent === null) return; // avoid deleting the camera or scene


        var scope = this;
        if (object == scope.currentObject) {
            scope.control.detach();
        }
        for (let i = 0; i < scope.objects.length; i++) {
            const obj = scope.objects[i];
            if (obj == object) {
                scope.objects.splice(i, 1);
            }
        }
        // scope.engine.refresh();
    },

    addLight: function addLight(light: any) {
        if (isObject(light) && light.isLight) {
            var helper = this.getHelper(light);
            if (helper) {
                helper.position.copy(light.position);
                this.scene.add(helper);
                helper.visible = false;
                if (helper.children) {
                    for (let index = 0; index < helper.children.length; index++) {
                        const child = helper.children[index];
                        const i = this.pickers.indexOf(child);
                        if (i == -1) {
                            this.pickers.push(child);
                        }
                    }
                }
            }
            if (light.target) {
                light.target.position.y = this.engine.dropbyPositionY;
                this.scene.add(light.target);
            }
            this.lights.push(light);
            this.select(light);
        }
    },

    removeLight: function removeLight(light: any) {
        var helper = this.getHelper(light);
        if (helper) {
            if (helper.children) {
                for (let index = 0; index < helper.children.length; index++) {
                    const child = helper.children[index];
                    const i = this.pickers.indexOf(child);
                    if (i != -1) {
                        this.pickers.splice(i, 1);

                    }
                }
            }
            this.removeHelper(light);
        }

        if (light.target) {
            this.removeLightTargetControlObject(light);
            this.scene.remove(light.target);
        }
        var index = this.lights.indexOf(light);

        if (index !== -1) {
            this.lights.splice(index, 1);

            if (this.currentLight == light) {
                this.detachLight();
            }
        }
        this.engine.refresh();
    },

    lightHelperStatus: true,
    showLightHelpers: function () {
        var self = this;
        this.lightHelperStatus = true;
        this.lights.map(function (light) {
            var helper = self.getHelper(light);
            if (helper) helper.visible = true;
        });
        this.targets.map(function (target) {
            target.visible = true;
        })
        this.engine.refresh()
    },


    hideLightHelpers: function () {
        var self = this;
        this.lights.map(function (light) {
            var helper = self.getHelper(light);
            if (helper) helper.visible = false;
        });
        this.lightHelperStatus = false;

        this.targets.map(function (target) {
            target.visible = false;
        });

        this.detachLight();

        this.engine.refresh()
    },

    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestObjectInScene: function closestObjectInScene(obj: any) {
        if (isObject(obj) && !obj.isSczene) {

            for (let i = 0; i < this.objects.length; i++) {
                const sobj = this.objects[i];
                if (obj == sobj || obj.uuid == sobj.uuid || (obj.id && obj.id == sobj.id)) return sobj;
            }
            if (obj.parent) {
                return this.closestObjectInScene(obj.parent);
            }

        }
        return null;
    },

    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestLightInScene: function closestLightInScene(obj: any) {
        if (isObject(obj) && !obj.isScene) {

            for (let i = 0; i < this.lights.length; i++) {
                const sobj = this.lights[i];
                if (obj == sobj || obj.userData == sobj || obj.attachObject == sobj) return sobj;


            }
            if (obj.parent) {
                return this.closestLightInScene(obj.parent);
            }


        }
        return null;
    },

    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestLightTargetControlInScene: function closestLightTargetControlInScene(obj: any) {
        if (isObject(obj) && !obj.isScene && this.currentLight) {
            var light = this.currentLight;
            for (let i = 0; i < this.targets.length; i++) {
                const sobj = this.targets[i];
                if (obj == sobj && sobj.light == light) return sobj;


            }
            if (obj.parent) {
                return this.closestLightInScene(obj.parent);
            }


        }
        return null;
    },

    /**
     * chọn object
     * @param {Vector3} pointer diểm click
     * @returns 
     */
    selectMeshByPointer: function (pointer: any) {
        var scope = this;
        this.raycaster.setFromCamera(pointer, this.engine.camera);
        const intersects = this.raycaster.intersectObjects(this.meshes, true);
        if (intersects.length > 0) {
            return intersects[0].object;
        }
        return null;
    },
    /**
     * chọn object
     * @param {Vector3} pointer diểm click
     * @returns 
     */
    selectObjectByPointer: function (pointer: any) {
        var scope = this;
        this.raycaster.setFromCamera(pointer, this.engine.camera);

        /**
         * thứ tự ưu tiên
         * 1 object
         * 2 target
         * 3 light
         */



        const intersects = this.raycaster.intersectObjects(this.objects, true);
        // objects

        if (intersects.length > 0) {
            const object = intersects[0].object;
            const obj = this.closestObjectInScene(object);
            if (obj) {

                if (obj !== this.control.object) {
                    if (this.currentObject && this.currentObject != obj) {
                        this.select(null);
                    }
                    this.select(obj);
                }
                return;
            }


        }





        const targetIntersects = this.raycaster.intersectObjects(this.targets, true);
        if (targetIntersects.length) {
            const target = this.closestLightTargetControlInScene(targetIntersects[0].object);
            if (target) {
                this.attachLightTargetControl(target);

                return;
            }
        }



        if (this.currentLight && this.currentTargetControl && this.currentTargetControl.light == this.currentLight) {
            this.detactLightTargetControl();
            this.control.attach(this.currentLight);

        } else {
            this.detactLightTargetControl();
        }



        // ligjy
        const lightIntersects = this.raycaster.intersectObjects(this.lights, true);

        if (lightIntersects.length > 0) {
            const object = lightIntersects[0].object;
            const light = this.closestLightInScene(object);

            if (light) {
                if (light != this.control.object) {
                    if (this.currentLight && this.currentLight != light) {
                        this.select(null);
                    }
                    this.select(light);
                }
                return;

            }
        }



        const pickerIntersects = this.raycaster.intersectObjects(this.pickers, true);
        if (pickerIntersects.length > 0) {
            const object = pickerIntersects[0].object.parent;
            const light = this.closestLightInScene(object);

            if (light) {
                if (light != this.control.object) {
                    if (this.currentLight && this.currentLight != light) {
                        this.select(null);
                    }
                    this.select(light);
                }
                return;

            }

        }




        if (this.currentLight) this.detachLight();
        if (this.currentObject) this.detachObject();
        if (this.currentTargetControl) {
            this.scene.remove(this.currentTargetControl);
            // this.select(null);
        }
        this.control.detach();
        this.select(null);
        this.selected = null;
        this.engine.refresh();


    },

    select: function (object: any) {
        if (!object) {

            if (this.selected) {
                if (this.selected.isTargetControlObject) {
                    this.detactLightTargetControl();
                } else if (this.currentLightt) {
                    this.detachLight();
                } else {
                    this.detachObject();
                }
            }
            // else {
            this.control.detach();
            // }
            this.selected = null;
            this.engine.refresh();
            return this;
        }
        if (this.selected === object) return;
        var uuid = null;

        uuid = object.uuid;

        this.selected = object;

        if (!object.isLight) {
            this.attachObject(object);
        }
        else {
            this.attachLight(object);
        }

        // this.config.setKey( 'selected', uuid );
        // this.signals.objectSelected.dispatch( object );
        this.engine.refresh();
    },

    selectById: function (id: any) {

        if (id === this.camera.id) {

            this.select(this.camera);
            return;

        }

        this.select(this.scene.getObjectById(id, true));

    },

    selectByUuid: function (uuid: any) {

        var scope = this;

        this.scene.traverse(function (child) {

            if (child.uuid === uuid) {

                scope.select(child);

            }

        });

    },

    deselect: function () {

        this.select(null);

    },

    focus: function (object: any) {

        if (object !== undefined) {


        }
        this.engine.refresh();
    },

    focusById: function (id: any) {

        this.focus(this.scene.getObjectById(id, true));

    },

    isSelected: function (object: any) {
        return object == this.selected ? true : (
            (object.isScene || !object.parent) ? false : this.isSelected(object.parent)
        )
    },

    /**
     * attach
     * @param {string|object} object 
     */

    attach: function (object: any) {
        // console.log(object);
        if (isObject(object)) {
            this.attachObject(object);
        }
        if (isString(object)) {
            var o = this.engine.getObject(object);
            if (o) {
                this.attachObject(o.object);
            }
        }
    },
    attachObject: function (object3D: any) {
        if (this.currentLight) {
            this.detachLight();
        }
        if (this.currentObject) {
            this.detachObject();
        }
        this.currentObject = object3D;
        var helper = this.getHelper(object3D);

        this.helper = helper;
        this.control.attach(object3D);
        this.scene.add(helper);

        this.dispatchEvent({
            type: 'object.attach',
            object: object3D,
            mode: this.control.mode
        });
        this.engine.refresh();
        return false;


    },
    detachObject: function () {
        this.control.detach();
        if (this.helper) {
            this.helper.position.set(0, 0, 0);
            this.helper.rotation.set(0, 0, 0);
            this.helper.scale.set(1, 1, 1);
            this.scene.remove(this.helper);

        }
        var obj = this.currentObject;
        this.currentObject = null;
        this.dispatchEvent({
            type: 'object.detach',
            object: obj
        });

        this.engine.refresh();
    },


    attachLight: function (light: any) {
        if (!light) {
            console.warn("Lỗi kkho có ligh");
            return;
        }
        if (this.currentObject) {
            this.detachObject();
        }
        if (this.currentLight) {
            this.detachLight();
        }
        this.currentLight = light;
        this.control.attach(light);
        var targetControl = this.getLightTargetControlObject(light);
        if (targetControl) {
            this.scene.add(targetControl);
        }
        this.dispatchEvent({
            type: 'light.attach',
            light: light,
            mode: this.control.mode
        });

    },
    detachLight: function () {
        this.control.detach();
        var obj = this.currentLight;
        var targetControl = this.getLightTargetControlObject(obj);
        if (targetControl) {
            this.scene.remove(targetControl);
        }

        this.currentLight = null;
        this.selected = null;
        this.dispatchEvent({
            type: 'light.detach',
            light: obj
        });
    },

    attachLightTargetControl: function (target: any) {
        this.currentTargetControl = target;
        this.control.detach();
        this.control.attach(target);
        this.engine.refresh();
    },

    detactLightTargetControl: function () {
        if (this.currentTargetControl && this.currentTargetControl == this.control.object) {
            this.control.detach();
            this.currentTargetControl = null;
        }
    },


    /**
     * Them target vontrol
     * @param {Object} light anh sang
     */
    getLightTargetControlObject: function (light: any) {
        if (!isObject(light) || !light.isLight || !light.target) return null;
        if (typeof this.targetControlObjects[light.target.id] != "undefined") return this.targetControlObjects[light.target.id];

        const geometry = new THREE.CircleGeometry(1, 32);
        const material = new THREE.MeshBasicMaterial({ color: 0xffffff, opacity: 0.1, side: THREE.DoubleSide, transparent: true });
        const circle = new THREE.Mesh(geometry, material);
        circle.targetControl = light.target;
        circle.light = light;
        // copy position
        circle.position.copy(light.target.position);
        circle.name = "targetcontrol";
        circle.isTargetControlObject = true;
        circle.rotation.x = - Math.PI / 2;
        this.targetControlObjects[light.target.id] = circle;
        circle.visible = this.lightHelperStatus;
        this.targets.push(circle);
        return circle;
    },

    removeLightTargetControlObject: function (light) {
        if (!isObject(light) || !light.isLight || !light.target) return null;
        if (typeof this.targetControlObjects[light.target.id] != "undefined" && isObject(this.targetControlObjects[light.target.id])) {
            var target = this.targetControlObjects[light.target.id];
            this.engine.scene.remove(target);
            let i = this.targets.indexOf(target);
            if (i > -1) {

                this.targets.splice(i, 1);
            }
        }

    },
    getHelper: function () {

        var geometry = new THREE.SphereGeometry(2, 4, 2);
        var material = new THREE.MeshBasicMaterial({ color: 0xff0000, visible: false });

        return function (object, helper) {

            if (this.helpers[object.id] != undefined) {
                helper = this.helpers[object.id];
            }
            else if (helper === undefined) {

                if (object.isCamera) {

                    helper = new THREE.CameraHelper(object);

                } else if (object.isPointLight) {

                    helper = new THREE.PointLightHelper(object, 1);

                } else if (object.isDirectionalLight) {

                    helper = new THREE.DirectionalLightHelper(object, 1);

                } else if (object.isSpotLight) {

                    helper = new THREE.SpotLightHelper(object, 1);

                } else if (object.isHemisphereLight) {

                    helper = new THREE.HemisphereLightHelper(object, 1);

                } else if (object.isSkinnedMesh) {

                    helper = new THREE.SkeletonHelper(object.skeleton.bones[0]);

                } else if (object.type == "Object3D") {

                    helper = new THREE.BoxHelper(object, 0xffff00);

                } else if (object.isGroup) {

                    helper = new THREE.BoxHelper(object, 0xffff00);

                } else if (object.isMesh) {

                    helper = new THREE.BoxHelper(object, 0xffff00);

                }

                else {

                    // no helper for this object type
                    return;

                }


            }

            var picker = new THREE.Mesh(geometry, material);
            picker.name = 'picker';
            picker.userData.object = object;
            helper.add(picker);
            helper.attachObject = object;
            this.helpers[object.id] = helper;
            return helper;
        };

    }(),

    removeHelper: function (object: any) {

        if (this.helpers[object.id] !== undefined) {

            var helper = this.helpers[object.id];
            if (helper.parent) {
                helper.parent.remove(helper);
            }
            delete this.helpers[object.id];

            // this.engine.refresh();
        }

    },

    deleteAttach: function () {
        if (this.currentLight) {
            this.emit({
                type: "delete:object",
                objectType: "light",
                light: this.currentLight
            })
        } else if (this.currentObject) {
            this.emit({
                type: "delete:object",
                objectType: "object",
                object: this.currentObject
            });
        }
    },


    unselect: function () {
        this.control.detach();
        this.select(null);
        this.selected = null;
    },


    executeCommand: function (command: any) {
        if (this.control.object && this.control.object.isTargetControlObject) {
            command = 'translate';
        }
        switch (command) {

            case "space":
                this.control.setSpace(this.control.space === "local" ? "world" : "local");
                break;

            case "snap":
                this.control.setTranslationSnap(100);
                this.control.setRotationSnap(THREE.MathUtils.degToRad(15));
                this.control.setScaleSnap(0.25);
                break;

            case 'unsnap':
                this.control.setTranslationSnap(null);
                this.control.setRotationSnap(null);
                this.control.setScaleSnap(null);
                break;

            case "translate":
                this.control.setMode("translate");
                break;

            case "rotate":
                this.control.setMode("rotate");
                break;

            case "scale":
                this.control.setMode("scale");
                break;

            case "upsize":
                this.control.setSize(this.control.size + 0.1);
                break;

            case "downsize":
                this.control.setSize(Math.max(this.control.size - 0.1, 0.1));
                break;

            case "toggle:x":
                this.control.showX = !this.control.showX;
                break;

            case "toggle:y":
                this.control.showY = !this.control.showY;
                break;

            case "toggle:z":
                this.control.showZ = !this.control.showZ;
                break;

            case "enable":
                this.control.enabled = !this.control.enabled;
                break;

            default:
                break;
        }
        this.engine.refresh();
    },
    itemSize: null,
    itemShadowObject: null,
    areaObjects: null,
    shadowPosY: 0,
    dropPreviewCustomObject: false,

    dropPosY: 0,

    boots: ["initDropPos"],
    sceneSize: null,
    initDropPos: function () {
        this.sceneSize = {
            width: 4,
            height: 4,
            depth: 4
        };
        this.areaObjects = [];
    },

    checkMovingEngine: function(){
        if(!this.moving) this.moving = getMovingEngine(this.engine);
        return this;
    },

    updateDropAreaAreas: function (sceneSize: SceneSize, floorPositionY: number, addItemAboveFloor?: boolean) {
        var self = this;
        assignValue(this.sceneSize, sceneSize);
        this.checkMovingEngine();
        if (this.areaObjects.length) {
            
            this.areaObjects.map(function (o) {
                self.moving.remove(o);
                // self.scene.remove(o);
            });
        }
        var xStart = -sceneSize.width / 2, xEnd = sceneSize.width / 2,
            zStart = -sceneSize.depth / 2, zEnd = sceneSize.depth / 2;
        let colRow = this.dragMoveColRows;
        var areaWidth = sceneSize.width / colRow;
        var areaDepth = sceneSize.depth / colRow;
        var areaHeight = (areaDepth < areaWidth ? areaDepth : areaWidth) / 5;
        
        
        xStart += (areaWidth / 2);
        xEnd -= (areaWidth / 2);
        zStart += (areaDepth / 2);
        zEnd -= (areaDepth / 2);
        
        var y = (addItemAboveFloor && isNumber(floorPositionY) ? floorPositionY : 0);
        this.dropPosY = y;
        
        let boxOrigin = this.engine.Mesh.get({
            geometry: { type: "box", width: areaWidth, height: areaHeight, depth: areaDepth },
            material: { type: "basic", params: { opacity: 0}, props: {transparent: true,visible: false}},
            props: { visible: false}
        });
        let xC = 0;
        let zC = 0;

        while (xC <= xEnd) {
            // if (i > 10000) break;
            // i++;
            let zz = zC;
            while (zz <= zEnd) {
                // if (j > 10000) break;
                // j++;
                let box = boxOrigin.clone(true);
                box.position.x = xC;
                box.position.y = y;
                box.position.z = zz;

                this.areaObjects.push(box);

                zz += areaDepth;
            }
            xC += areaWidth;
        }
        
        xC = -areaWidth;
        zC = 0;

        while (xC >= xStart) {
            let zz = zC;
            while (zz <= zEnd) {
                // if (j > 10000) break;
                // j++;
                let box = boxOrigin.clone(true);
                box.position.x = xC;
                box.position.y = y;
                box.position.z = zz;

                this.areaObjects.push(box);

                zz += areaDepth;
            }
            xC -= areaWidth;
        }
        

        xC = 0;
        zC = -areaDepth;

        while (xC <= xEnd) {
            let zz = zC;
            while (zz >= zStart) {
                // if (j > 10000) break;
                // j++;
                let box = boxOrigin.clone(true);
                box.position.x = xC;
                box.position.y = y;
                box.position.z = zz;

                this.areaObjects.push(box);

                zz -= areaDepth;
            }
            xC += areaWidth;
        }
        

        xC = -areaWidth;
        zC = -areaDepth;

        while (xC >= xStart) {
            let zz = zC;
            while (zz >= zStart) {
                // if (j > 10000) break;
                // j++;
                let box = boxOrigin.clone(true);
                box.position.x = xC;
                box.position.y = y;
                box.position.z = zz;

                this.areaObjects.push(box);

                zz -= areaDepth;
            }
            xC -= areaWidth;
        }
        
        // var self = this;
        this.areaObjects.map(function (b) {
            self.moving.add(b);
            // self.scene.add(b);
        });



    },



    setDragMoveItem: function (itemSize: Vector3, itemPosition?: Vector2, customObject?: any) {
        if (this.sceneSize.width < itemSize.x || this.sceneSize.depth < itemSize.z) {
            this.hasDroppablePosition = false;
            return false;
        }
        var self = this;
        // this.moving.updateCamera(this.engine.camera);

        this.hasDroppablePosition = true;
        this.itemSize = itemSize;
        var planeWidth = itemSize.x, planeDepth = itemSize.z;

        ['x', 'y', 'z'].map(s => {
            if (itemSize[s] <= 0) itemSize[s] = 0.04;
        });
        this.shadowPosY = this.dropPosY;
        if (this.itemShadowObject) {
            this.engine.scene.remove(this.itemShadowObject);
            this.itemShadowObject.isAdded = false;
        }
        if (customObject && isObject(customObject) && customObject.uuid) {
            this.dropPreviewCustomObject = true;

            this.itemShadowObject = customObject;
            this.itemShadowObject.position.y = this.shadowPosY + itemSize.y / 2;

            this.itemShadowObject.visible = false;
        } else {
            this.dropPreviewCustomObject = false;
            let plane = this.engine.Mesh.get({
                geometry: {
                    type: "box", width: planeWidth, height: itemSize.y, depth: planeDepth
                },
                material: {
                    type: "physical",
                    params: {
                        color: "#9ad9f3"
                    },
                    props: {
                        transparent: true,
                        opacity: 0.4
                    }
                },
                props: {
                    position: {
                        x: 0,
                        y: this.shadowPosY + itemSize.y / 2,
                        z: 0
                    }
                }
            });
            

            plane.isAdded = false;
            this.itemShadowObject = plane;

        }


        var py = this.itemShadowObject.position.y;

        this.areaObjects.map(function (area) {
            area.position.y = py;
        });



        this.turnOffShadow(1000);
        this.refresh();
        if (itemPosition) {
            this.checkDroppablePosition(itemPosition);
        }
        setTimeout(function () {
            self.moving.updateCamera(self.engine.camera);
        }, 10)


    },
    removeDragMoveItem: function () {
        if (!this.hasDroppablePosition) return false;
        if (this.itemShadowObject && !this.dropPreviewCustomObject) {
            if (this.itemShadowObject.isAdded) {
                this.engine.scene.remove(this.itemShadowObject);
            }
            this.itemShadowObject = null;

        }
        this.hasDroppablePosition = false;
        var self = this;

        var py = this.dropPosY;

        this.areaObjects.map(function (area) {
            area.position.y = py;
        });


        this.refresh();
        this.emit({
            type: "additem.position.reset"
        })

    },
    

    checkDroppablePosition: function (pointer: Vector2) {
        var scope = this;
        if (!this.hasDroppablePosition) return false;
        // scope.poiterDowsStatus = false;
        var rect = scope.engine.wrapper.getBoundingClientRect();
        var x = pointer.x - rect.left;
        var y = pointer.y - rect.top;
        if (x < 0 || y < 0) return;

        pointer.x = (x / rect.width) * 2 - 1;
        pointer.y = - (y / rect.height) * 2 + 1;
        this.checkMovingEngine();
        this.movingRaycaster.setFromCamera(pointer, this.moving.camera);
        // this.raycaster.setFromCamera(pointer, this.engine.camera);

        const intersects = this.movingRaycaster.intersectObjects(this.areaObjects, true);
        // objects
        // console.log(intersects);
        if (intersects.length > 0) {
            const object = intersects[0].object;
            const obj = this.closestAreaScene(object);
            if (obj) {
                if (this.itemShadowObject) {
                    let o = {
                        x: this.itemShadowObject.position.x,
                        z: this.itemShadowObject.position.z
                    }, n = {
                        x: obj.position.x,
                        z: obj.position.z
                    };
                    var a = o.x != n.x || o.z != n.z;
                    var b = n.x >= -(this.sceneSize.width - this.itemSize.x) / 2 && n.x <= (this.sceneSize.width - this.itemSize.x) / 2;
                    var c = n.z >= -(this.sceneSize.depth - this.itemSize.z) / 2 && n.z <= (this.sceneSize.depth - this.itemSize.z) / 2;

                    if (a && b && c) {
                        let pos = {
                            x: n.x,
                            y: this.itemShadowObject.position.y,
                            z: n.z
                        }
                        assignValue(this.itemShadowObject.position, n);
                        this.emit({
                            type: "additem.position.set",
                            position: pos
                        })
                        
                    }
                    if (!this.dropPreviewCustomObject && !this.itemShadowObject.isAdded) {

                        this.engine.scene.add(this.itemShadowObject);
                        this.itemShadowObject.isAdded = true;
                    }
                    else if (this.dropPreviewCustomObject) {
                        this.itemShadowObject.visible = true;
                    }
                    this.turnOffShadow(1000);
                    this.refresh();
                }

            } else if (this.itemShadowObject) {
                if (!this.dropPreviewCustomObject && this.itemShadowObject.isAdded) {
                    this.engine.scene.remove(this.itemShadowObject);
                    this.itemShadowObject.isAdded = false;
                } if (this.dropPreviewCustomObject) {
                    this.itemShadowObject.visible = false;
                }
                this.emit({
                    type: "additem.position.lock"
                })
                this.turnOffShadow(1000);
                this.refresh();
            }
        } else {
            this.emit({
                type: "additem.position.lock"
            });

        }
    },

    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestAreaScene: function closestAreaScene(obj: any) {
        if (this.hasDroppablePosition && isObject(obj) && !obj.isSczene) {

            for (let i = 0; i < this.areaObjects.length; i++) {
                const sobj = this.areaObjects[i];
                if (obj == sobj || obj.uuid == sobj.uuid || (obj.id && obj.id == sobj.id)) return sobj;
            }
            if (obj.parent) {
                return this.closestAreaScene(obj.parent);
            }

        }
        return null;
    }


});

const Editor = Editor__ as EditorClass;

export default Editor;
export { Editor };