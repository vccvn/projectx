import { ChangeDetectorRef, Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges } from '@angular/core';
import { Object3DPropDataModel, Object3DPropDefaultData } from '@app/_3D/store/data.type';
import { assignValue, isObject } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
    selector: 'panel-model-object-tab-properties',
    templateUrl: './panel-model-object-tab-properties.component.html',
    styleUrls: ['./panel-model-object-tab-properties.component.scss']
})
export class PanelModelObjectTabPropertiesComponent extends BaseComponent implements OnInit, OnChanges {
    @Input() props: Object3DPropDataModel = null;
    @Input() index: number = 0;
    @Output() onUpdate = new EventEmitter<Object3DPropDataModel>();
    @Input() events: any = null;

    @Output() subcribe = new EventEmitter<InpEvent>();
    constructor(private cd: ChangeDetectorRef) {
        super();
    }

    onInit(): void {
        let defData = assignValue({}, Object3DPropDefaultData);
        let finalData = assignValue(defData, this.props);
        if (!isObject(this.props)) this.props = finalData;
        else assignValue(this.props, finalData);
        this.cd.detectChanges();
    }

    ngOnChanges(change: SimpleChanges){
        if(change.props){
            this.doAfterViewInit(()=>this.cd.detectChanges());
        }
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
