import { Component, Input, OnInit } from '@angular/core';
import { isArray, isObject, isString } from '@app/_core/helpers/utils';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
    selector: 'select-box',
    templateUrl: './select-box.component.html',
    styleUrls: ['./select-box.component.scss']
})
export class SelectBoxComponent extends BaseInputComponent implements OnInit {

    @Input() options: any;
    _options: Array<{ label: string, value: string }> = [];
    constructor() {
        super();
    }

    ngOnInit(): void {
        if(isArray(this.options)){
            this.options.map((value) => {
                if(isObject(value)){
                    if(Object.prototype.hasOwnProperty.call(value, 'value') && Object.prototype.hasOwnProperty.call(value, 'label')){
                        this._options.push(value);
                    }
                }else if(isString(value)){
                    this._options.push({
                        value: value,
                        label: value
                    });
                }
            })
        }else if(isObject(this.options)){
            for (const key in this.options) {
                if (Object.prototype.hasOwnProperty.call(this.options, key)) {
                    const value = this.options[key];
                    if(isObject(value)){
                        if(Object.prototype.hasOwnProperty.call(value, 'value') && Object.prototype.hasOwnProperty.call(value, 'label')){
                            this._options.push(value);
                        }
                    }else if(isString(value)){
                        this._options.push({
                            value: key,
                            label: value
                        });
                    }
                }
            }
        }
    }
}
