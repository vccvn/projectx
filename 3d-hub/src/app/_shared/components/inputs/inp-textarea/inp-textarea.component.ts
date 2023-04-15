import { Component, Input, OnInit } from '@angular/core';
import { isNumber } from '@app/_core/helpers/utils';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
  selector: 'inp-textarea',
  templateUrl: './inp-textarea.component.html',
  styleUrls: ['./inp-textarea.component.scss']
})
export class InpTextareaComponent extends BaseInputComponent implements OnInit {

  @Input() minRows: number = 3;
  @Input() maxRows: Number = 5;
  
  _old: any = null;

  size: any = {
    minRows: 3,
    maxRows: 5
  }
  constructor() {
    super();
   }

  ngOnInit(): void {
    this._old = this.value;
    if(!isNumber(this.minRows) || this.minRows < 1) this.minRows = 3;
    if(!isNumber(this.maxRows) || this.maxRows < this.maxRows) this.maxRows = this.minRows;

    this.size.minRows = this.minRows;
    this.size.maxRows = this.maxRows;
    
  }

  onChangeValue(event){
    if(this._old !== this.value){
      this.emit();
      this._old = this.value;
    }
  }

}
