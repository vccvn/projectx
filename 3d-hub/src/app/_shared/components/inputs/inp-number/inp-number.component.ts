import { Component, Input, OnInit } from '@angular/core';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
  selector: 'inp-number',
  templateUrl: './inp-number.component.html',
  styleUrls: ['./inp-number.component.scss']
})
export class InpNumberComponent extends BaseInputComponent implements OnInit {

  @Input() step: number = 1;
  @Input() max: number = 9999999999999999;
  @Input() min: number =-9999999999999999;

  @Input() spin: boolean = false;
  

  constructor() {
    super()
   }

  ngOnInit(): void {
  }

  valChange(value){
    this.onChange({value});
  }
}
