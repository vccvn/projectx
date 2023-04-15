import { Component, Input, OnInit } from '@angular/core';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
  selector: 'inp-range-group',
  templateUrl: './inp-range-group.component.html',
  styleUrls: ['./inp-range-group.component.scss']
})
export class InpRangeGroupComponent extends BaseInpGroupComponent implements OnInit {

  @Input() step: number = 1;
  @Input() max: number = 9999999999999999;
  @Input() min: number =-9999999999999999;

  @Input() output: boolean = false;

  
  configProps = ["step", "min", "max", "spin", "output"];

  constructor() {
    super();
  }

  onInit(): void {
    assignValue(this.defaultValues, {
      step: 1,
      min: -9999999999999999,
      max:  9999999999999999,
      output: false
    });
    this.inpInit();
  }

  
  valChange(value){
    this.onChange({value});
  }

  
}
