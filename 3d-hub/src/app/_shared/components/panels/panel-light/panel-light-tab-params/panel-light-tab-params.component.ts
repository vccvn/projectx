import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { InpEvent } from '@app/_shared/shared.type';

@Component({
  selector: 'panel-light-tab-params',
  templateUrl: './panel-light-tab-params.component.html',
  styleUrls: ['./panel-light-tab-params.component.scss']
})
export class PanelLightTabParamsComponent implements OnInit {

  @Input() inputs: any;
  @Output() subcribe = new EventEmitter<InpEvent>();
  constructor() { }

  ngOnInit(): void {
  }

  changeHandle(event:InpEvent){
    this.subcribe.emit(event)
  }
}
