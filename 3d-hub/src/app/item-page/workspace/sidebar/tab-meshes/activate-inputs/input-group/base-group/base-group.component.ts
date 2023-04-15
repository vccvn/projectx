import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { isBoolean, isObject, objectHasKey } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
    template: ''
})
export abstract class BaseGroupComponent extends BaseComponent {

    @Input() config: any = null;

    @Output() subcribe = new EventEmitter<{ name?: string, value?: any, [x: string]: any }>();
    @Output() editable = new EventEmitter<{ name: string, status: boolean }>();

    parseValue(value) {
        if (objectHasKey(this.config, "valueType")) {
            var vt = this.config.valueType;
            switch (vt) {
                case "number":
                    return Number(value);
                    break;

                case 'boolean':
                    return isBoolean(value) ? value : Boolean(value);
                    break;
                default:
                    break;
            }
        }

        return value;
    }

    onChange(event) {
        if (isObject(event) && Object.prototype.hasOwnProperty.call(event, 'value')) {
            this.config.value = event.value;
        }

        this.subcribe.emit({
            value: this.parseValue(this.config.value),
            name: this.config.name,
            editable: this.config.editable
        });
    }

    onEditable(event) {
        this.config.editable = !!event.value;
        this.editable.emit({
            name: this.config.name,
            status: this.config.editable
        })
    }

    valChange(value) {
        this.onChange({ value });
    }


}
