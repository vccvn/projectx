import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { PanelModelObjectService } from '../panel-model-object.service';

@Component({
  selector: 'panel-model-object-tab-meshes',
  templateUrl: './panel-model-object-tab-meshes.component.html',
  styleUrls: ['./panel-model-object-tab-meshes.component.scss']
})
export class PanelModelObjectTabMeshesComponent extends BaseComponent implements OnInit {
  @Input() meshes: any = [];
  _s: PanelModelObjectService;
  @Output() subcribe = new EventEmitter<any>();
  @Output() onUpdate = new EventEmitter<any>();
  @Output() onUpdateTitle = new EventEmitter<any>();
  @Input() secretKey: string = '';
  constructor(private service: PanelModelObjectService) {
    super();
  }

  onInit(): void {
    this._s = this.service;
  }

  onUpdateMaterial(event){
    this.subcribe.emit(event);
  }

}
