import { Component, Input, OnInit } from '@angular/core';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
  selector: 'inp-range',
  templateUrl: './inp-range.component.html',
  styleUrls: ['./inp-range.component.scss']
})
export class InpRangeComponent extends BaseInputComponent implements OnInit {

  @Input() step: number = 1;
  @Input() max: number = 9999999999999999;
  @Input() min: number =-9999999999999999;

  @Input() output: boolean = false;

  constructor() {
    super()
   }

  ngOnInit(): void {
  }

}
