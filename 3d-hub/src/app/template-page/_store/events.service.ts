import { Injectable } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { TemplateEditorService } from '@app/_3D/services/template-editor.service';

@Injectable({
    providedIn: 'root'
})
export class TemplateEventsService extends AppEditorEventService {

    app: TemplateEditorService;
    constructor() {
        super();
    }

    dragItem(item) {
        this.emit({
            type: "item.drag",
            data: item
        });
    }
    dropItem(item) {
        this.emit({
            type: "item.drop",
            data: item
        });
    }

}
