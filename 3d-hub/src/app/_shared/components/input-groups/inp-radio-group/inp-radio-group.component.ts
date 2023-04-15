import { Component, Input, OnInit } from '@angular/core';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
    selector: 'inp-radio-group',
    templateUrl: './inp-radio-group.component.html',
    styleUrls: ['./inp-radio-group.component.scss']
})
export class InpRadioGroupComponent extends BaseInpGroupComponent implements OnInit {

    @Input() options: any = null;
    _options: Array<{ label: string, value: string }> = [];

    configProps = ["options"];
    constructor() {
        super();
    }



    onInit(): void {
        assignValue(this.defaultValues, {
            options: null
        });
        this.inpInit();;

    }

}

