import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { assignValue, isBoolean, isObject } from '@app/_core/helpers/utils';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
    template: ''
})
export abstract class BaseInputComponent {
    @Input() name: string = 'input';
    @Input() value: any = "";
    @Input() label: string = '';
    @Input() placeholder: string = '';
    @Input() valueType: string;
    old: any = '';
    @Output() subcribe = new EventEmitter<InpEvent>();


    pendingStatus: boolean = false;
    emitAfter(time: number = 0) {
        if (this.pendingStatus) return false;
        if (time < 0) time = 0;

        if (!time) {
            var ov = isObject(this.value) ? assignValue({}, this.value) : this.value;
            var old = this.old;

            this.subcribe.emit({
                name: this.name,
                value: ov,
                old: old
            });
            this.old = ov;
            return false;
        }


        this.pendingStatus = true;
        setTimeout(() => {
            var ov = isObject(this.value) ? assignValue({}, this.value) : this.value;
            var old = this.old;
            this.old = ov;
            this.subcribe.emit({
                name: this.name,
                value: ov,
                old: old
            });
            this.pendingStatus = false;

        }, time);

    }
    parseValue(value) {
        switch (this.valueType) {
            case "number":
                return Number(value);
                break;

            case 'boolean':
                return isBoolean(value) ? value : Boolean(value);
                break;
            default:
                break;
        }

        return value;
    }


    onChange(event) {
        if (isObject(event) && Object.prototype.hasOwnProperty.call(event, 'value')) {
            this.value = event.value;
        }
        if (isObject(this.old) && isObject(this.value)) {
            if (JSON.stringify(this.old) !== JSON.stringify(this.value)) {
                this.emit();
            }
        } else if (this.old !== this.value) {
            this.emit();
        }

    }

    emit() {
        var ov = isObject(this.value) ? assignValue({}, this.value) : this.value;
        var old = this.old;

        this.subcribe.emit({
            name: this.name,
            value: ov,
            old: old
        });
        this.old = ov;
    }

    set val(value) {
        this.value = value;
        this.onChange({ type: "change", value: value });
    }

}
