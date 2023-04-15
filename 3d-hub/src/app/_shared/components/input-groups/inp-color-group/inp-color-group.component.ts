import { Component, Input, OnInit } from '@angular/core';
import { isObject } from '@app/_core/helpers/utils';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
  selector: 'inp-color-group',
  templateUrl: './inp-color-group.component.html',
  styleUrls: ['./inp-color-group.component.scss']
})
export class InpColorGroupComponent extends BaseInpGroupComponent implements OnInit {

  @Input() output: boolean = false;
  @Input() typeEnable: boolean = false;
  constructor() {
    super();
  }

  onInit(): void {
    this.inpInit();
    this.value = this.value && isObject(this.value) ? (
      this.value.isColor ? "#" + this.value.getHexString() : (
        this.value.$three == "color" ? this.value.color : "#000"
      )
    ) : this.value as any;
  }

}
