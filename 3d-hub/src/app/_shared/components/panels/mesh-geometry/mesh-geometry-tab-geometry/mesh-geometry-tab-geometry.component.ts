import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
  selector: 'mesh-geometry-tab-geometry',
  templateUrl: './mesh-geometry-tab-geometry.component.html',
  styleUrls: ['./mesh-geometry-tab-geometry.component.scss']
})
export class MeshGeometryTabGeometryComponent implements OnInit {

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
  @Output() subcribe = new EventEmitter<InpEvent>();
  constructor() {
    
  }

  ngOnInit(): void {
  }

  inputChange(event: InpEvent) {
    this.subcribe.emit(event);
  }
}
