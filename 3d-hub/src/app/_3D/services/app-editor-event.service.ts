import { Injectable } from '@angular/core';
import { EventManagerService } from '@app/_core/services/event-manager.service';
import { AppEditorService } from './app-editor.service';

@Injectable({
    providedIn: 'root'
})
export class AppEditorEventService extends EventManagerService {
    app: AppEditorService = null;
    [prop: string]: any;
    constructor() {
        super();
    }

  
}
