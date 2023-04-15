import { Component, Input, OnInit, Output } from '@angular/core';
import { InpEvent } from '@app/_shared/shared.type';
import { CollapseBaseComponent } from '../collapse-base/collapse-base.component';

@Component({
  selector: 'collapse-material',
  templateUrl: './collapse-material.component.html',
  styleUrls: ['./collapse-material.component.scss']
})
export class CollapseMaterialComponent extends CollapseBaseComponent implements OnInit {
  @Input() material: {
    type: string,
    [propKey: string]: any
  } = null;
  @Input() settings: {
    type: string,
    [propKey: string]: any
  };
  constructor() {
    super();
  }

  ngOnInit() {

  }

  onUpdate(event: InpEvent){
    this.subcribe.emit(event);
  }
}