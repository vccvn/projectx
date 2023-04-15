import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { InpEvent } from '@app/_shared/shared.type';
import { CollapseBaseComponent } from '../collapse-base/collapse-base.component';

@Component({
  selector: 'collapse-mesh-geometry-params',
  templateUrl: './collapse-mesh-geometry-params.component.html',
  styleUrls: ['./collapse-mesh-geometry-params.component.scss']
})
export class CollapseMeshGeometryParamsComponent extends CollapseBaseComponent implements OnInit {
  @Input() inputs: Array<{
    name: string,
    type: string,
    value: any,
    spin: boolean,
    step: number,
    min: number,
    max: number
  }> = [];
  @Output() onUpdate = new EventEmitter<any>();
  constructor() {
    super();
  }

  ngOnInit(): void {
  }

  inputChange(event: InpEvent) {
    this.subcribe.emit(event);
  }

}
