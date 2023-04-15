import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { assignValue, isArray, isEmpty, isObject } from '@app/_core/helpers/utils';
import { InpEvent } from '@app/_shared/shared.type';
import { BaseComponent } from '../../base/base.component';

@Component({
    template: ''
})
export abstract class BaseInpGroupComponent extends BaseComponent {
    @Input() name: string = '';
    @Input() value: any = "";
    @Input() label: string = '';
    @Input() placeholder: string = '';
    @Input() valueType: string = null;
    @Input() config: {
        label: string,
        name: string,
        value: any,
        [key: string]: any
    } = null;
    @Input() attach: {
        label?: string,
        name?: string,
        value?: any,
        [key: string]: any
    } = null;

    hasAttach: boolean = false;

    old: any = '';

    @Output() subcribe = new EventEmitter<InpEvent>();

    defaultValues: {
        label: string,
        name: string,
        value: any,
        [key: string]: any
    } = {
            name: "",
            label: "",
            value: "",
            placeholder: ""
        }




    onChange(event) {
        if (isObject(event) && Object.prototype.hasOwnProperty.call(event, 'value')) {
            this.value = event.value;
        }
        if (isObject(this.old) && isObject(this.value)) {
            if (JSON.stringify(this.old) !== JSON.stringify(this.value)) {
                this.emitChange();
            }
        } else if (this.old !== this.value) {
            this.emitChange();
        }

    }
    onAttachChange(event) {
        this.subcribe.emit({
            name: event.name,
            value: event.value
        });

    }

    emitChange() {
        var ov = isObject(this.value) ? assignValue({}, this.value) : this.value;
        var self: any = this;
        var old = this.old;
        if (typeof self.onInpValChange == "function") {
            self.onInpValChange(ov);
        }
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

    inpInit() {
        var self: any = this;
        var checkList = ['name', 'label', 'value', "placeholder", "valueType"];

        if (this.config && isObject(this.config) && !isEmpty(this.config)) {
            if (typeof self.configProps != "undefined" && isArray(self.configProps)) {
                self.configProps.map(s => checkList.indexOf(s) == -1 ? checkList.push(s) : s);
            }
            checkList.map(p => {
                if (Object.prototype.hasOwnProperty.call(self, p)) {
                    if (Object.prototype.hasOwnProperty.call(this.config, p)) {
                        if (self[p] === this.defaultValues[p]) {
                            self[p] = this.config[p];
                        }
                    }
                }
            });

            if (!this.label) {
                this.label = this.name;
            }
            if (this.config.attach && isObject(this.config.attach) && !isEmpty(this.config.attach)) {
                if (!isObject(this.attach)) this.attach = {}
                var checkattach = ['name', 'label', 'value', "placeholder", 'min', 'max', 'step'];
                checkattach.map(p => {
                    if (Object.prototype.hasOwnProperty.call(this.attach, p)) {
                        if (Object.prototype.hasOwnProperty.call(this.config.attach, p)) {
                            if (this.attach[p] === this.defaultValues[p]) {
                                this.attach[p] = this.config.attach[p];
                            }
                        }
                    } else {
                        if (Object.prototype.hasOwnProperty.call(this.config.attach, p)) {
                            this.attach[p] = this.config.attach[p];
                        }
                    }

                });


            }

        }
        if (!isEmpty(this.attach)) {
            this.hasAttach = true;
        }
    }

}



