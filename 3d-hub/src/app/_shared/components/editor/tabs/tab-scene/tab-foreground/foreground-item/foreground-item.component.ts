import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { TemplateEventsService } from '@app/template-page/_store/events.service';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { FG_BGSIZES, FG_DEFAULT_DATA, FG_ITEM, FG_POSKEYS, FG_REPEAT } from '@app/_shared/shared.type';

import { EditorIO, EditorMethods } from '../../../../base/editor-io';

@Component({
    selector: 'app-foreground-item',
    templateUrl: './foreground-item.component.html',
    styleUrls: ['./foreground-item.component.scss']
})
export class ForegroundItemComponent extends BaseComponent implements OnInit {

    @Input() data: FG_ITEM = null;
    @Output() update = new EventEmitter<any>();
    @Output() clickDelete = new EventEmitter<FG_ITEM>();
    isActive: boolean = false;
    position: { x: string[], y: string[], xy: string[] } = FG_POSKEYS;
    repeatOptions = FG_REPEAT;
    sizeOptions = FG_BGSIZES;
    posimg: string = TransparentBase64Image;

    constructor(
        private events: AppEditorEventService
    ) {
        super();
    }
    onInit(): void {
        let a = assignValue({}, FG_DEFAULT_DATA);
        this.data = assignValue(a, this.data);
    }

    toggleActive() {
        this.isActive = !this.isActive;
    }

    onClickDelete() {
        this.clickDelete.emit(this.data);
    }

    onChange(event) {
        if (event.value != this.data[event.name]) {
            this.data[event.name] = event.value;
        }
        this.update.emit(this.data);
        if (event.name == "url") {
            this.emitRefresh();
        }

    }

    changePosition(x, y) {
        this.data.position.x = x;
        this.data.position.y = y;
        this.update.emit(this.data);
    }

    modalCancelSelect() {
        this.emitRefresh();
    }

    emitRefresh() {
        setTimeout(() => {
            this.subEvents.emit("tab.scene.refresh");
        }, 200);
    }
}

