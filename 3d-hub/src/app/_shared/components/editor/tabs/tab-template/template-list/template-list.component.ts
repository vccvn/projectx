import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { TemplateModel } from '@app/_store/template';

@Component({
    selector: 'template-list',
    templateUrl: './template-list.component.html',
    styleUrls: ['./template-list.component.scss']
})
export class TemplateListComponent extends BaseComponent implements OnInit {

    @Input() title: string = 'All Template';

    @Input() items: TemplateModel[];


    @Output() clickMore = new EventEmitter<any>();
    @Output() clickItem = new EventEmitter<any>();
    
    
}

