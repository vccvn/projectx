import { Component, Input, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { TemplateModel } from '@app/_store/template';

@Component({
    selector: 'template-item',
    templateUrl: './template-item.component.html',
    styleUrls: ['./template-item.component.scss']
})
export class TemplateItemComponent extends BaseComponent implements OnInit {
    @Input() item: TemplateModel;
    constructor(private events: AppEditorEventService) {
        super();
    }

    onInit(): void {
    }

    importTemplate(){
        this.subEvents.emit({
            type: "template.import",
            template: this.item
        })
    }
}
