import { assignValue, assignWithout, getTimeStamp, inArray, isArray, isEmpty, isNumber, isObject, isString, newObj, objectValues, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';
import { _class } from '@app/_core/helpers/es5.class';
import { SceneSize, Vector2 } from '../store/data.type';
import { EditorClass, iEditor } from '../store/docs';
import Editor from './editor';
import { Div, i, Span } from '@app/_core/helpers/html-elements';


const Editor__: any = _class("ClientEditor").extends(Editor)({
    transformMode: "basic",
    hasSelectedObject: false,
    posInfo: null,
    constructor: function constructor(app, engine: any) {
        this.setup(app, engine);
    },
    startup: function () {
        var scope: iEditor = this;

        this.on('pointerdown', onPointerDown);
        this.on('pointerup', onPointerUp);
        this.on('pointermove', onPointerMove);


        (function () {

            window.addEventListener('keydown', function (event) {

                switch (event.keyCode) {
                    case 81: // Q
                        scope.executeCommand("space");
                        break;
                    case 16: // Shift
                        scope.executeCommand("snap");
                        break;
                    case 46: // delete
                        scope.deleteAttach();
                        break;

                    default:
                        break;
                }
            });



        }());

        function onPointerDown(event) {

            scope.poiterDowsStatus = true;
            var rect = scope.engine.wrapper.getBoundingClientRect();

            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;
            //
            // console.log("point down");
            if (!scope.selected || scope.transformMode != "basic" || scope.selected.isLight || (scope.currentTargetControl && scope.currentTargetControl == scope.control.object)) {
                scope.app.canTransferEventToControls = true;
                return;
            }

            const pointer = new THREE.Vector2();
            pointer.x = (scope.onDownPosition.x / rect.width) * 2 - 1;
            pointer.y = - (scope.onDownPosition.y / rect.height) * 2 + 1;
            const detectObj = scope.selectObjectByPointer(pointer);
            if (detectObj && detectObj == scope.selected && !detectObj.isLight) {
                event.preventDefault();
                scope.engine.control.enabled = false;
                scope.control.enabled = false;
                scope.hasSelectedObject = true;
                scope.setObjectMovable(scope.selected);
                scope.app.canTransferEventToControls = false;
                // console.log("has obj");
            } else {
                scope.engine.control.enabled = true;
                scope.control.enabled = true;
                scope.hasSelectedObject = false;
                // scope.app.canTransferEventToControls = true;
                // console.log("no obj");

            }

        }

        function onPointerUp(event) {
            scope.app.canTransferEventToControls = true;
            if (scope.poiterDowsStatus) {
                if (scope.hasSelectedObject) {
                    this.emit({
                        type: "object.changed",
                        data: scope.selected,
                        mode: "translate"
                    })
                    scope.engine.control.enabled = true;
                    scope.control.enabled = true;
                    scope.hasSelectedObject = false;
                    // do somehing
                    scope.removeObjectMovable();

                    scope.poiterDowsStatus = false;
                    return;
                }

                var rect = scope.engine.wrapper.getBoundingClientRect();
                scope.onUpPosition.x = event.clientX - rect.left;
                scope.onUpPosition.y = event.clientY - rect.top;
                // console.log(scope.onUpPosition.x, scope.onUpPosition.y)
                if (scope.onUpPosition.x < 0 || scope.onUpPosition.y < 0) {
                    // scope.app.canTransferEventToControls = true;
                    // console.log("out wp");
                    return;
                }

                if (scope.onDownPosition.distanceTo(scope.onUpPosition) === 0) {
                    scope.pointer.x = (scope.onUpPosition.x / rect.width) * 2 - 1;
                    scope.pointer.y = - (scope.onUpPosition.y / rect.height) * 2 + 1;
                    scope.setCurrentObjectByPointer(scope.pointer);
                    // console.log("check current");

                } else {
                    // scope.app.canTransferEventToControls = true;
                }
            }
            // else if (scope.hasSelectedObject) {
            //     scope.engine.control.enabled = true;
            //     scope.control.enabled = true;
            //     scope.hasSelectedObject = false;
            //     // do somehing
            //     scope.removeObjectMovable();
            //     setTimeout(function(){
            //         scope.app.canTransferEventToControls = true;
            //     }, 1);
            //     return;
            // }
            else {
                // scope.app.canTransferEventToControls = true;
                // console.log("nm");
            }
            scope.poiterDowsStatus = false;

        }

        function onPointerMove(event) {
            if (scope.poiterDowsStatus) {
                // scope.turnOffShadow();

            }
            if (scope.hasSelectedObject) {
                // var rect = scope.engine.wrapper.getBoundingClientRect();
                const pointer = new THREE.Vector2();
                pointer.x = event.clientX;
                pointer.y = event.clientY;
                // scope.app.canTransferEventToControls = false;
                scope.checkObjectMovablePosition(pointer);
                return;
            }
        }
        this.ready();
        this.setEngineData();
        this.emit({
            type: "startup",
            data: getTimeStamp()
        });
        this.posInfo = Div("#" + this.getInstanceID(), {
            style: {
                display: 'none',
                position: "absolute",
                opacity: 0,
                zIndex: 1000,
                width: "120px"
            },
            setPos: function (...args: any[]) {
                if (args.length >= 3) {
                    this.callChildren("setX", [args[0]]);
                    this.callChildren("setY", [args[1]]);
                    this.callChildren("setZ", [args[2]]);
                } else if (args.length >= 1) {
                    if (isObject(args[0])) {
                        if (typeof args[0].x != "undefined") this.callChildren("setX", [args[0].x]);
                        if (typeof args[0].y != "undefined") this.callChildren("setY", [args[0].y]);
                        if (typeof args[0].z != "undefined") this.callChildren("setZ", [args[0].z]);

                    }

                }
            },
            children: [
                Div(".x", [
                    Span(".label", "x"), Span(".space", " "), Span(".value", {
                        setX: function (x) {
                            this.html(x);
                        }
                    })
                ]),
                Div(".y", [
                    Span(".label", "y"), Span(".space", " "), Span(".value", {
                        setY: function (x) {
                            this.html(x);
                        }
                    })
                ]),
                Div(".z", [
                    Span(".label", "z"), Span(".space", " "), Span(".value", {
                        setZ: function (x) {
                            this.html(x);
                        }
                    })
                ])
            ]
        });

        document.body.appendChild(this.posInfo.el);

    },


    updateDropAreaAreas: function (sceneSize: SceneSize, floorPositionY: number, addItemAboveFloor?: boolean) {
        var self = this;
        assignValue(this.sceneSize, sceneSize);
        // this.checkMovingEngine();
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
            material: { type: "basic", params: { opacity: 0 }, props: { transparent: true, visible: false } },
            props: { visible: false }
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



    setObjectMovable: function (item, itemPosition?: Vector2) {
        this.hasDroppablePosition = true;
        var box = new THREE.Box3().setFromObject(item);
        // box.getCenter(obj.position); // this re-sets the mesh position
        const dimensions = new THREE.Vector3();
        var size: any = box.getSize(dimensions);
        this.itemSize = size;

        this.dropPreviewCustomObject = true;
        this.itemShadowObject = item;


        this.areaObjects.map(function (area) {
            area.position.y = item.position.y;
        });

        // this.moving.checkCamera();
        this.turnOffShadow(1000);
        // this.refresh();
        if (itemPosition) {
            this.checkObjectMovablePosition(itemPosition);
        }

    },
    removeObjectMovable: function () {
        if (!this.hasDroppablePosition) return false;
        this.itemShadowObject = null;
        this.hasDroppablePosition = false;

        var y = this.dropPosY;
        this.areaObjects.map(function (area) {
            area.position.y = y;
        });

    },

    checkObjectMovablePosition: function (pointer: Vector2) {
        var scope = this;
        if (!this.hasDroppablePosition) return false;
        // scope.poiterDowsStatus = false;
        var rect = scope.engine.wrapper.getBoundingClientRect();
        var x = pointer.x - rect.left;
        var y = pointer.y - rect.top;
        // console.log("check", x, y)
        if (x < 0 || y < 0) return;

        pointer.x = (x / rect.width) * 2 - 1;
        pointer.y = - (y / rect.height) * 2 + 1;

        this.movingRaycaster.setFromCamera(pointer, this.engine.camera);


        const intersects = this.movingRaycaster.intersectObjects(this.areaObjects, true);
        // objects
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
                        this.posInfo.css({
                            display: "block",
                            opacity: 1,
                            top: pointer.y + 20 + "px",
                            left: pointer.x + 20 + "px"
                        });
                        this.posInfo.setPos(pos);
                        assignValue(this.itemShadowObject.position, n);
                        this.emit({
                            type: "object.position.move",
                            position: pos
                        });
                        scope.updateHelperByObject(this.itemShadowObject);

                        this.turnOffShadow(1000);
                        this.refresh();

                    }
                    else {
                        this.posInfo.css({
                            display: "none"
                        });

                    }
                } else {
                    this.posInfo.css({
                        display: "none"
                    });

                }

            } else {

                this.turnOffShadow(1000);
                this.refresh();
            }


        }
        else {
            this.posInfo.css({
                display: "none"
            });

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
            // scope.engine.refresh();
        }
    },
    addObject: function (object: any) {
        this.objects.push(object);
        this.setCurrentObject(object);
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
            // this.setCurrentLight(light);
        }
    },

    setCurrent: function (object: any) {
        if (!object) {

            if (this.selected) {
                if (this.selected.isTargetControlObject) {
                    this.detactLightTargetControl();

                } else if (this.currentLightt) {
                    this.unsetCurrentLight();

                } else {
                    this.unsetCurrentObject();
                }
            }
            // else {
            this.control.detach();
            // }
            // this.selected = null;
            this.engine.refresh();
            return this;
        }
        if (this.selected === object) return;
        var uuid = null;

        uuid = object.uuid;

        this.selected = object;

        if (!object.isLight) {
            this.setCurrentObject(object);
        }
        else {
            this.setCurrentLight(object);
        }

        // this.config.setKey( 'selected', uuid );
        // this.signals.objectSelected.dispatch( object );
        this.engine.refresh();
    },
    setCurrentObject: function (object3D: any) {
        if (this.currentLight) {
            this.unsetCurrentLight();
        }
        if (this.currentObject) {
            this.unsetCurrentObject();
        }
        this.currentObject = object3D;
        this.selected = object3D;

        var helper = this.getHelper(object3D);

        this.helper = helper;
        // this.control.attach(object3D);

        this.scene.remove(helper);
        this.scene.add(helper);

        this.dispatchEvent({
            type: 'object.set-current',
            object: object3D,
            mode: this.transformMode
        });
        this.engine.refresh();
        return false;


    },

    setCurrentLight: function (light: any) {
        if (!light) {
            console.warn("Lỗi kkho có ligh");
            return;
        }
        if (this.currentLight) {
            this.unsetCurrentLight();
        }
        if (this.currentObject) {
            this.unsetCurrentObject();
        }
        this.currentLight = light;
        this.control.detach();
        this.control.attach(light);
        this.selected = light;
        if (!light.targetControlObject) {
            var targetControl = this.getLightTargetControlObject(light);
            if (targetControl) {
                light.targetControlObject = targetControl;

                this.scene.remove(targetControl);
                this.scene.add(targetControl);

            }

        }
        this.dispatchEvent({
            type: 'light.set-current',
            light: light,
            mode: this.control.mode
        });

    },



    unsetCurrentLight: function () {
        this.detachLight();
        this.dispatchEvent({
            type: 'light.unset-current',
            mode: this.control.mode
        });
    },
    unsetCurrentObject: function () {
        this.detachObject();
        this.dispatchEvent({
            type: 'object.unset-current',
            mode: this.control.mode
        });
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

                return obj;
            }


        }
        const targetIntersects = this.raycaster.intersectObjects(this.targets, true);
        if (targetIntersects.length) {
            const target = this.closestLightTargetControlInScene(targetIntersects[0].object);
            if (target) {
                // this.attachLightTargetControl(target);
                return target;
            }
        }


        // ligjy
        const lightIntersects = this.raycaster.intersectObjects(this.lights, true);

        if (lightIntersects.length > 0) {
            const object = lightIntersects[0].object;
            const light = this.closestLightInScene(object);

            if (light) {

                return light;

            }
        }
        const pickerIntersects = this.raycaster.intersectObjects(this.pickers, true);
        if (pickerIntersects.length > 0) {
            const object = pickerIntersects[0].object;
            const light = this.closestLightInScene(object);

            if (light) {
                return light;
            }

        }
        return null;


    },



    /**
     * chọn object
     * @param {Vector3} pointer diểm click
     * @returns 
     */
    setCurrentObjectByPointer: function (pointer: any) {
        var scope = this;
        this.raycaster.setFromCamera(pointer, this.engine.camera);

        /**
         * thứ tự ưu tiên
         * 1 object
         * 2 target
         * 3 light
         */



        if (!this.lightHelperStatus) {
            const intersects = this.raycaster.intersectObjects(this.objects, true);
            // objects

            if (intersects.length > 0) {
                const object = intersects[0].object;
                const obj = this.closestObjectInScene(object);
                if (obj) {
                    if (obj !== this.selected) {
                        if (this.currentObject && this.currentObject != obj) {
                            this.setCurrent(null);
                        }
                        this.transformMode = 'basic';
                        this.setCurrent(obj);
                        // scope.app.canTransferEventToControls = true;
                    }
                    return;
                }


            }

        }

        else {
            const targetIntersects = this.raycaster.intersectObjects(this.targets, true);
            if (targetIntersects.length) {
                const target = this.closestLightTargetControlInScene(targetIntersects[0].object);
                if (target) {
                    this.transformMode = 'basic';
                    this.attachLightTargetControl(target);
                    // scope.app.canTransferEventToControls = true;
                    return;
                }
            }

            /// light
            if (this.currentLight && this.currentTargetControl && this.currentTargetControl.light == this.currentLight) {
                this.detactLightTargetControl();
                this.transformMode = 'basic';
                this.control.attach(this.currentLight);
                // scope.app.canTransferEventToControls = true;
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
                            this.setCurrent(null);
                        }
                        this.setCurrent(light);
                        this.transformMode = 'basic';
                    }
                    // scope.app.canTransferEventToControls = true;
                    return;

                }
            }
            const pickerIntersects = this.raycaster.intersectObjects(this.pickers, true);
            if (pickerIntersects.length > 0) {
                const object = pickerIntersects[0].object;
                const light = this.closestLightInScene(object);

                if (light) {
                    if (light != this.control.object) {
                        if (this.currentLight && this.currentLight != light) {
                            this.setCurrent(null);
                        }
                        this.setCurrent(light);
                        this.transformMode = 'basic';
                    }
                    // scope.app.canTransferEventToControls = true;
                    return;

                }

            }

        }
        if (this.currentLight) this.detachLight();
        if (this.currentObject) this.detachObject();
        if (this.currentTargetControl) {
            this.scene.remove(this.currentTargetControl);
            // this.select(null);
        }
        this.transformMode = 'basic';
        this.control.detach();
        this.setCurrent(null);
        this.select(null);
        this.selected = null;
        // this.engine.refresh();



    },

    unselect: function () {
        this.transformMode = 'basic';
        this.control.detach();
        this.setCurrent(null);
        this.select(null);
        this.selected = null;
    },


    /**
     * tìm object trong bảng
     * @param {Object} obj 
     * @returns {Object#d|Group|Mesh}
     */
    closestLightTargetControlInScene: function (obj: any) {
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




    isSelected: function (object: any) {
        return object == this.selected ? true : (
            (object.isScene || !object.parent) ? false : this.isSelected(object.parent)
        )
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

        this.scene.remove(helper);
        this.scene.add(helper);

        // this.dispatchEvent({
        //     type: 'object.attach',
        //     object: object3D,
        //     mode: this.control.mode
        // });
        // this.engine.refresh();
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
        // this.dispatchEvent({
        //     type: 'object.detach',
        //     object: obj
        // });

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
            this.scene.remove(targetControl);
            this.scene.add(targetControl);
        }
        // this.dispatchEvent({
        //     type: 'light.attach',
        //     light: light,
        //     mode: this.control.mode
        // });

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
        // this.dispatchEvent({
        //     type: 'light.detach',
        //     light: obj
        // });
    },

    executeCommand: function (command: any) {
        if (!this.control.object) {
            if (this.selected) {
                if (!this.selected.isLight) {
                    this.attachObject(this.selected);
                } else {
                    this.attachLight(this.selected);
                }
                this.transformMode = command;
            }
        }
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





});

const ClientEditor = Editor__ as EditorClass;

export default ClientEditor;