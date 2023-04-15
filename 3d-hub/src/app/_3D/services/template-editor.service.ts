import { Injectable } from '@angular/core';
import ClientEditorEngine from '../engines/client-editor.engine';
import ProjectEditor from '../libs/project-editor';
import TemplateEditor from '../libs/template-editor';
import { AppEditorService } from './app-editor.service';

@Injectable({
    providedIn: 'root'
})
export class TemplateEditorService extends AppEditorService {
    editorClass = ProjectEditor
    engineClass = ClientEditorEngine
}
