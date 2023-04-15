import { Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { isArray, isNumber, isObject, isString } from '@app/_core/helpers/utils';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
    selector: 'inp-radio',
    templateUrl: './inp-radio.component.html',
    styleUrls: ['./inp-radio.component.scss']
})
export class InpRadioComponent extends BaseInputComponent implements OnInit, OnChanges {

    @Input() options: any;
    _options: Array<{ label: string, value: string }> = [];
    constructor() {
        super();
    }



    ngOnChanges(changes: SimpleChanges): void {
        if (changes.options) {
            this.syncFromParent();
        }

    }


    ngOnInit(): void {
        this.syncFromParent();

    }

    syncFromParent() {
        let hasValue = false;
        if (isArray(this.options)) {
            this._options = [];
            
            this.options.map((value) => {
                if (isObject(value)) {
                    if (Object.prototype.hasOwnProperty.call(value, 'value') && Object.prototype.hasOwnProperty.call(value, 'label')) {
                        this._options.push(value);
                    }
                } else if (isString(value) || isNumber(value)) {
                    this._options.push({
                        value: value,
                        label: value
                    });
                }
            });
            

        } else if (isObject(this.options)) {
            let s = false;
            this._options.splice(0);
            for (const key in this.options) {
                if (Object.prototype.hasOwnProperty.call(this.options, key)) {
                    const value = this.options[key];
                    if (isObject(value)) {
                        if (Object.prototype.hasOwnProperty.call(value, 'value') && Object.prototype.hasOwnProperty.call(value, 'label')) {
                            this._options.push(value);
                        }
                    } else if (isString(value)) {
                        s = true;
                        this._options.push({
                            value: key,
                            label: value
                        });
                    }
                }
            }
            if (s) {
                this.value = String(this.value);
            }
        }
        if(this._options.length){
            this._options.map(opt => {
                if(opt.value == this.value) hasValue = true;
            })
            if(!hasValue){
                this.value = this._options[0].value;
            }
        }
        


    }

}
