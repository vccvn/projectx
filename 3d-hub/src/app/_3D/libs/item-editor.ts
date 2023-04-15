import { getTimeStamp } from '@app/_core/helpers/utils';
import * as THREE from 'three';
import { _class } from '@app/_core/helpers/es5.class';
import { EventDispatcher } from './event-dispatcher';
import { EditorClass, iEditor } from '../store/docs';
import ClientEditor from './client-editor';
import { ItemEditorService } from '../services/item-editor.service';
import { EngineClass, EngineInstance } from '../engines/engine.doc';

export interface ItemEditorInstance extends iEditor{
    app: ItemEditorService
}

export interface ItemEditor extends EditorClass{
    new(app: ItemEditorService, engine: EngineInstance): ItemEditorInstance
}

const Editor__: any = _class("ItemEditor").extends(ClientEditor).uses(EventDispatcher)({
    transformMode: "basic",
    hasSelectedObject: false,
    allowCustom: false,
        
    constructor: function constructor(app, engine: any) {
        this.setup(app, engine);
    },

    startup: function () {
        var scope: ItemEditorInstance = this;

        this.on('pointerdown', onPointerDown);
        this.on('pointerup', onPointerUp);
        this.on('pointermove', onPointerMove);
        this.on('dbclick', onDblClick);

        function onDblClick(event) {
            var rect = scope.engine.wrapper.getBoundingClientRect();
            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;
            const pointer = new THREE.Vector2();
            pointer.x = (scope.onDownPosition.x / rect.width) * 2 - 1;
            pointer.y = - (scope.onDownPosition.y / rect.height) * 2 + 1;
            const detectObj = scope.selectMeshByPointer(pointer);
            if(detectObj){
                const ms = scope.getMeshData(detectObj);
                if(ms){
                    scope.emit({
                        type: "attach:mesh",
                        mesh: ms
                    });
                }
            }
        }


        function onPointerDown(event) {
            scope.poiterDowsStatus = true;
            var rect = scope.engine.wrapper.getBoundingClientRect();

            scope.onDownPosition.x = event.clientX - rect.left;
            scope.onDownPosition.y = event.clientY - rect.top;

            //
            if (!scope.allowCustom) return;
            
            if (!scope.selected || scope.transformMode != "basic" || scope.selected.isLight || (scope.currentTargetControl && scope.currentTargetControl == scope.control.object)) return;

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
            if (!scope.allowCustom) return;
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
            if (!scope.allowCustom) return;
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



        // scope.app.on("model.added", function (e) {
        //     scope.asyncMeshes();
        // })
        this.ready();
        // this.setEngineData();
        this.emit({
            type: "startup",
            data: getTimeStamp()
        });

    },
    addObject: function (object: any) {
        this.objects.push(object);
        // this.setCurrentObject(object);
    },
    // asyncMeshes: function asyncMeshes() {
    //     var scope: ItemEditorInstance = this;
    //     this.meshes = [];
    //     var settings = scope.app.data.item.settings;
    //     settings.meshes.map(function(mesh){
    //         scope.meshes.push(mesh.__ref__);
    //     })
        

    // },

    getMeshData: function (mesh) {
        var settings = this.app.data.item.settings;
        var m = null;
        for (let index = 0; index < settings.meshes.length; index++) {
            const meshSettings = settings.meshes[index];
            if(meshSettings.__ref__ == mesh){
                return meshSettings;
            }
        }
        return null;
    }
    
    
});



export const ItemEditor = Editor__ as ItemEditor;

export default ItemEditor;