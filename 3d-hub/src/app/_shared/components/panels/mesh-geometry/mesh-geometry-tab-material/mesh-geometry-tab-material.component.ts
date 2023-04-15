import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
  selector: 'mesh-geometry-tab-material',
  templateUrl: './mesh-geometry-tab-material.component.html',
  styleUrls: ['./mesh-geometry-tab-material.component.scss']
})
export class MeshGeometryTabMaterialComponent implements OnInit {

  @Input() material: {
    type: string,
    [propKey: string]: any
  } = null;
  @Input() settings: {
    type: string,
    [propKey: string]: any
  };
  @Output() subcribe = new EventEmitter<InpEvent>();
  constructor() {
    
  }

  ngOnInit() {

  }

  onUpdate(event: InpEvent){
    this.subcribe.emit(event);
  }
}
