import { assignValue, assignWithout, getTimeStamp, inArray, isArray, isEmpty, isNumber, isObject, isString, newObj, objectValues, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';
import { EditorClass, iEditor } from '../store/docs';
import Editor from './editor';
import { _class } from '@app/_core/helpers/es5.class';


const Editor__: any = _class("TemplateEditor").extends(Editor)({
    oldPointerUp: null,
    lastPointerUpTime: getTimeStamp(),
    
    constructor: function constructor(app, engine: any) {
        this.lightHelperStatus = false;
        this.setup(app, engine);
        this.startup2();
    },

    startup2: function () {
        var scope = this;

        this.on("dbclick", onDblClick);

        function onDblClick(event) {
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
    }
});

const TemplateEditor = Editor__ as EditorClass;

export default TemplateEditor;