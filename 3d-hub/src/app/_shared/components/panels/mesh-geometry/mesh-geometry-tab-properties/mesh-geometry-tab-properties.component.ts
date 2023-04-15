import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Object3DPropDataModel, Object3DPropDefaultData } from '@app/_3D/store/data.type';
import { assignValue, isObject } from '@app/_core/helpers/utils';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
    selector: 'mesh-geometry-tab-properties',
    templateUrl: './mesh-geometry-tab-properties.component.html',
    styleUrls: ['./mesh-geometry-tab-properties.component.scss']
})
export class MeshGeometryTabPropertiesComponent implements OnInit {
    @Input() props: Object3DPropDataModel = null;
    @Input() index: number = 0;
    @Output() onUpdate = new EventEmitter<Object3DPropDataModel>();
    @Input() events: any = null;

    @Output() subcribe = new EventEmitter<InpEvent>();
    constructor() { }

    ngOnInit(): void {
        let defData = assignValue({}, Object3DPropDefaultData);
        let finalData = assignValue(defData, this.props);
        if (!isObject(this.props)) this.props = finalData;
        else assignValue(this.props, finalData);
        // console.log(this.props)

    }

    onInputChange(event) {
        if (event && isObject(event) && event.name) {
            if (isObject(this.props[event.name]) && isObject(event.value)) {
                assignValue(this.props[event.name], event.value);
            }
            else {
                this.props[event.name] = event.value;
            }
            this.emitUpdate(event.name, event.value);
        }
    }

    emitUpdate(name, value) {
        this.onUpdate.emit(this.props);
        this.subcribe.emit({
            name: name,
            value: value,
            props: this.props
        });
    }
}
