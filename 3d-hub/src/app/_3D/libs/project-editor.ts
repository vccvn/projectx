import { getTimeStamp } from '@app/_core/helpers/utils';
import * as THREE from 'three';
import { _class } from '@app/_core/helpers/es5.class';
import { EventDispatcher } from './event-dispatcher';
import { EditorClass, iEditor } from '../store/docs';
import ClientEditor from './client-editor';
import { ItemEditorService } from '../services/item-editor.service';
import { EngineClass, EngineInstance } from '../engines/engine.doc';
import { ProjectEditorService } from '../services/project-editor.service';

export interface ProjectEditorInstance extends iEditor{
    app: ProjectEditorService
}

export interface ProjectEditor extends EditorClass{
    new(app: ProjectEditorService, engine: EngineInstance): ProjectEditorInstance
}

const Editor__: any = _class("ProjectEditor").extends(ClientEditor).uses(EventDispatcher)({
        
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



export const ProjectEditor = Editor__ as ProjectEditor;

export default ProjectEditor;