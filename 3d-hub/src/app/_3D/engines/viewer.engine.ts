import { _class } from '@app/_core/helpers/es5.class';

import { EngineClass } from './engine.doc';
import ClientEditorEngine, { EditorEngineClass, EditorEngineInstance } from './client-editor.engine';
export interface ViewerEngineInstance extends EditorEngineInstance {

}

export interface ViewerEngine extends EditorEngineClass {
    new(data: any): ViewerEngineInstance
    (data: any): ViewerEngineInstance
}

const ViewerEngine = _class("ViewerEngine").extends(ClientEditorEngine)({
    env: "production"
}) as ViewerEngine;
export default ViewerEngine;
export { ViewerEngine };