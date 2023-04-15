import { Injectable } from '@angular/core';
import ClientEditorEngine from '../engines/client-editor.engine';
import ProjectEditor from '../libs/project-editor';
import { AppEditorService } from './app-editor.service';

@Injectable({
    providedIn: 'root'
})
export class ProjectEditorService extends AppEditorService {
    engineClass = ClientEditorEngine;
    editorClass = ProjectEditor;
}
