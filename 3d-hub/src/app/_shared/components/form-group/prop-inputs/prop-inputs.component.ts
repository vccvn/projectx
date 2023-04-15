import { Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges } from '@angular/core';
import { Object3DPropDataModel, Object3DPropDefaultData } from '@app/_3D/store/data.type';
import { assignValue, isObject } from '@app/_core/helpers/utils';


@Component({
    selector: 'prop-inputs',
    templateUrl: './prop-inputs.component.html',
    styleUrls: ['./prop-inputs.component.scss']
})
export class PropInputsComponent implements OnInit, OnChanges {
    @Input() props: Object3DPropDataModel = null;
    @Input() index: number = 0;
    @Output() onUpdate = new EventEmitter<Object3DPropDataModel>();
    constructor() { }

    ngOnInit(): void {
        let defData = assignValue({}, Object3DPropDefaultData);
        let finalData = assignValue(defData, this.props);
        if (!isObject(this.props)) this.props = finalData;
        else assignValue(this.props, finalData);
    }

    ngOnChanges(changes: SimpleChanges): void {
        //Called before any other lifecycle hook. Use it to inject dependencies, but avoid any serious work here.
        //Add '${implements OnChanges}' to the class.
        console.log(changes)

    }
    onInputChange(event) {
        if (event && isObject(event) && event.name) {
            if (isObject(this.props[event.name]) && isObject(event.value)) {
                assignValue(this.props[event.name], event.value);
            }
            else {
                this.props[event.name] = event.value;
            }
            this.emitUpdate();
        }
    }

    emitUpdate() {
        this.onUpdate.emit(this.props);
    }

}
