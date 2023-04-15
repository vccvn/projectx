import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { EditorIO, EditorMethods } from '@app/_shared/components/editor/base/editor-io';
import { ItemModel } from '@app/_store/item';

@Component({
    selector: 'model-list',
    templateUrl: './model-list.component.html',
    styleUrls: ['./model-list.component.scss']
})
export class ModelListComponent extends BaseComponent implements OnInit {

    @Input() title: string = 'All Item';

    @Input() items: ItemModel[];


    @Output() clickMore = new EventEmitter<any>();
    @Output() clickItem = new EventEmitter<any>();
    constructor(){
        super();
    }
    onInit(){
        
    }
}
