import { Component, OnInit } from '@angular/core';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
  selector: 'inp-text',
  templateUrl: './inp-text.component.html',
  styleUrls: ['./inp-text.component.scss']
})
export class InpTextComponent extends BaseInputComponent implements OnInit {

  _old: any = null;
  constructor() {
    super();
   }

  ngOnInit(): void {
    this._old = this.value;
  }

  onChangeValue(event){
    if(this._old !== this.value){
      this.emit();
      this._old = this.value;
    }
  }

}
