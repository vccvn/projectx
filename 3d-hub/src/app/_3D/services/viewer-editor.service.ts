import { Injectable } from '@angular/core';
import ClientEditorEngine from '../engines/client-editor.engine';
import ViewerEngine from '../engines/viewer.engine';
import ViewerEditor from '../libs/viewer-editor';
import { AppEditorService } from './app-editor.service';

@Injectable({
    providedIn: 'root'
})
export class ViewerEditorService extends AppEditorService {
    engineClass = ViewerEngine;
    editorClass = ViewerEditor;
}
