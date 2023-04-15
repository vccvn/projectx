import { Component, OnInit } from '@angular/core';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
  selector: 'inp-text-group',
  templateUrl: './inp-text-group.component.html',
  styleUrls: ['./inp-text-group.component.scss']
})
export class InpTextGroupComponent extends BaseInpGroupComponent implements OnInit {

  
  constructor() {
    super();
  }

  onInit(): void {
    this.inpInit();
    this.old = this.value;
  }

  onChangeValue(event) {
    if (this.old !== this.value) {
      this.emitChange();
    }
  }

}
