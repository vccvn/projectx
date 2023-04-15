import { Component, OnInit } from '@angular/core';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
  selector: 'inp-switch-group',
  templateUrl: './inp-switch-group.component.html',
  styleUrls: ['./inp-switch-group.component.scss']
})
export class InpSwitchGroupComponent extends BaseInpGroupComponent implements OnInit {

  constructor() {
    super();
  }

  onInit(): void {
    this.inpInit();
  }

}
