import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Object3DPropDataModel, Object3DPropDefaultData } from '@app/_3D/store/data.type';
import { assignValue, isObject } from '@app/_core/helpers/utils';
import { CollapseBaseComponent } from '../collapse-base/collapse-base.component';

@Component({
    selector: 'collapse-mesh-props',
    templateUrl: './collapse-mesh-props.component.html',
    styleUrls: ['./collapse-mesh-props.component.scss']
})
export class CollapseMeshPropsComponent extends CollapseBaseComponent implements OnInit {
    @Input() props: Object3DPropDataModel = null;
    @Input() index: number = 0;
    @Output() onUpdate = new EventEmitter<Object3DPropDataModel>();
    @Input() service: any = null;
    constructor() {
        super();
    }
    

    ngOnInit(): void {
        let defData = assignValue({}, Object3DPropDefaultData);
        let finalData = assignValue(defData, this.props);
        if (!isObject(this.props)) this.props = finalData;
        else assignValue(this.props, finalData);
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
