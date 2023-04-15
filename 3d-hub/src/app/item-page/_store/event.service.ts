/**
 * Stateservice sử dụng cho angular hoặc bất kỳ một core nào khác
 * @author DoanLN
 */
import { Injectable } from '@angular/core';
import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { EventManagerService } from '@app/_core/services/event-manager.service';

@Injectable({
    providedIn: 'root'
})
export class ItemEventService extends EventManagerService {
    app: ItemEditorService = null;
    constructor(){
        super();
    }
}
