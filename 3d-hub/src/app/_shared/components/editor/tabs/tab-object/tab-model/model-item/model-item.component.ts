import { Component, ElementRef, Input, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { getTimeStamp } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ItemModel } from '@app/_store/item';

@Component({
    selector: 'model-item',
    templateUrl: './model-item.component.html',
    styleUrls: ['./model-item.component.scss']
})
export class ModelItemComponent extends BaseComponent implements OnInit {
    @Input() item: ItemModel;
    pos = {
        x: 0,
        y: 0
    }
    curTime = getTimeStamp();

    constructor(
        private elem: ElementRef,
        private events: AppEditorEventService
    ) {
        super()
    }
    onInit(){}

    onPointerDown(event){
        this.onDragStart(event)
    }

    onPointerUp(event){
        let ct = getTimeStamp();
        if(event.clientX == this.pos.x && event.clientY == this.pos.y && ct - this.curTime <= 300){
            let evt = {
                type: "item.dropcenter",
                clientX: event.clientX,
                clientY: event.clientY
            };
            this.subEvents.emit(evt);
        }
        this.curTime = ct;
        this.pos.x = event.clientX;
        this.pos.y = event.clientY;
        
    }

    onDragStart(event) {
        event.preventDefault();
        let item = this.item;
        var itemElement = this.elem.nativeElement.querySelector('.model-item');
        var rect = itemElement.getBoundingClientRect();
        
        let evt = {
            type: "item.dragstart",
            clientX: event.clientX,
            clientY: event.clientY,
            width: rect.width,
            height: rect.height,
            left: rect.left,
            top: rect.top,
            item: item,
            data: item
        };
        this.subEvents.emit(evt);
        // this.templateEvent.dragItem(item);
    }

}
