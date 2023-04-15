import { getTimeStamp} from '@app/_core/helpers/utils';
import * as THREE from 'three';
import { _class } from '@app/_core/helpers/es5.class';
import { EventDispatcher } from './event-dispatcher';
import { EditorClass, iEditor } from '../store/docs';
import ClientEditor from './client-editor';


const Editor__: any = _class("ViewerEditor").extends(ClientEditor).uses(EventDispatcher)({
    transformMode: "basic",
    hasSelectedObject: false,
    allowCustom: false,
    constructor: function constructor(app, engine: any) {
        this.setup(app, engine);
    },
    
    startup: function () {
        var scope: iEditor = this;

        
        if(typeof this.engine.data.allow_custom != "undefined"){
            scope.allowCustom = this.engine.data.allow_custom;
        }

        setTimeout(function(){
            if(!scope.allowCustom) scope.removeDropAreaAreas();
        }, 1);

        scope.engine.on('reset', function(){
            if(typeof scope.engine.data.allow_custom != "undefined"){
                scope.allowCustom = scope.engine.data.allow_custom;
            }
            setTimeout(function(){
                if(!scope.allowCustom) scope.removeDropAreaAreas();
            }, 1);
    
        });



        this.on('pointerdown', onPointerDown);
        this.on('pointerup', onPointerUp);
        this.on('pointermove', onPointerMove);


        
        function onPointerDown(event) {
            if(!scope.allowCustom) return;
            scope.poiterDowsStatus = true;
            var rect = scope.engine.wrapper.getBoundingClientRect();

            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;
            
            //
            if (!scope.selected || scope.transformMode!="basic" || scope.selected.isLight || (scope.currentTargetControl && this.currentTargetControl == this.control.object)) return;
            
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

            } else {
                scope.engine.control.enabled = true;
                scope.control.enabled = true;
                scope.hasSelectedObject = false;

            }

        }

        function onPointerUp(event) {
            if(!scope.allowCustom) return;
            // scope.poiterDowsStatus = false;
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
                    return;
                }

                var rect = scope.engine.wrapper.getBoundingClientRect();
                scope.onUpPosition.x = event.clientX - rect.left;
                scope.onUpPosition.y = event.clientY - rect.top;
                if (scope.onUpPosition.x < 0 || scope.onUpPosition.y < 0) return;

                if (scope.onDownPosition.distanceTo(scope.onUpPosition) === 0) {
                    scope.pointer.x = (scope.onUpPosition.x / rect.width) * 2 - 1;
                    scope.pointer.y = - (scope.onUpPosition.y / rect.height) * 2 + 1;
                    scope.setCurrentObjectByPointer(scope.pointer);
                    

                }
            }
            scope.poiterDowsStatus = false;

        }

        function onPointerMove(event) {
            if(!scope.allowCustom) return;
            if (scope.poiterDowsStatus) {
                // scope.turnOffShadow();
                
            }
            if (scope.hasSelectedObject) {
                // var rect = scope.engine.wrapper.getBoundingClientRect();
                const pointer = new THREE.Vector2();
                pointer.x = event.clientX;
                pointer.y = event.clientY;

                scope.checkDObjectMovablePosition(pointer);
                return;
            }
        }
        this.ready();
        this.setEngineData();
        this.emit({
            type: "startup",
            data: getTimeStamp()
        })

        this.startup2();
    },

    startup2: function () {
        var scope = this;

        this.on("dbclick", onDblClick);

        function onDblClick(event) {
            if(!scope.allowCustom) return;
            var rect = scope.engine.wrapper.getBoundingClientRect();
            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;
            const pointer = new THREE.Vector2();
            pointer.x = (scope.onDownPosition.x / rect.width) * 2 - 1;
            pointer.y = - (scope.onDownPosition.y / rect.height) * 2 + 1;
            const detectObj = scope.selectMeshByPointer(pointer);
            if (detectObj) {
                scope.emit({
                    type: "select:mesh",
                    mesh: detectObj
                });

            }
        }
    },    
    addObject: function (object: any) {
        this.objects.push(object);
        // this.setCurrentObject(object);
    },
    removeDropAreaAreas: function(){
        var self = this;
        if (this.areaObjects.length) {
            this.areaObjects.map(function (o) {
                self.engine.scene.remove(o);
            });
        }
    }



    
});

const ViewerEditor = Editor__ as EditorClass;

export default ViewerEditor;