import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { LightProps } from '@app/_3D/store/data.type';
import { assignValue, isObject } from '@app/_core/helpers/utils';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
  selector: 'panel-light-tab-properties',
  templateUrl: './panel-light-tab-properties.component.html',
  styleUrls: ['./panel-light-tab-properties.component.scss']
})
export class PanelLightTabPropertiesComponent implements OnInit {
  @Input() props: LightProps = null;
  @Output() onUpdate = new EventEmitter<LightProps>();
  @Input() service: any = null;

  @Input() hasShadow: boolean = false;
  @Input() hasTarget: boolean = false;
  @Input() hasShadowCamera: boolean = false;
  @Output() subcribe = new EventEmitter<InpEvent>();
  constructor() { }

  ngOnInit(): void {
      let defData = assignValue({}, {
        visible: true,
        position: {
            x: 0,
            y: 0,
            z: 0
        },
        // up: {
        //     x: 0,
        //     y: 0,
        //     z: 0
        // },
        rotation: {
            x: 0,
            y: 0,
            z: 0
        }
    
    });
      let finalData = assignValue(defData, this.props);
      if (!isObject(this.props)) this.props = finalData;
      else assignValue(this.props, finalData);
  }

  onInputChange(event) {
      if (event && isObject(event) && event.name) {
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
