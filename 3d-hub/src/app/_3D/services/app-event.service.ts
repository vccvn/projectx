import { Injectable } from '@angular/core';
import { EventManagerService } from '@app/_core/services/event-manager.service';
import { App3DService } from './app-3d.service';

@Injectable({
    providedIn: 'root'
})
export class AppEventService extends EventManagerService {
    app: App3DService = null;
    constructor() {
        super();
        // this.init();
    }

  
}
