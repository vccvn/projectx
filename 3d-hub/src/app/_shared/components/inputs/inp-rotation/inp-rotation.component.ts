import { Component, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { assignValue, degreeToRadians, radianToDegrees, Str } from '@app/_core/helpers/utils';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
  selector: 'inp-rotation',
  templateUrl: './inp-rotation.component.html',
  styleUrls: ['./inp-rotation.component.scss']
})
export class InpRotationComponent extends BaseInputComponent implements OnInit, OnChanges {

  degreSymbol : string = "°";
  _value:any = {
    x:0,
    y:0,
    z:0
  };

  canSync: boolean = false;

  constructor() {
    super();
  }



  ngOnInit(): void {
    this.syncFromParent();
    this.canSync = true;
  }


  syncFromParent(){
    this._value = {
      x: radianToDegrees(this.value.x),
      y: radianToDegrees(this.value.y),
      z: radianToDegrees(this.value.z)
    }
  }


  ngOnChanges(changes: SimpleChanges): void {
    if(this.canSync){
      if(changes.value){
        this.syncFromParent();
      }
    }
    
  }

  updateVector(vector, event){
    this.canSync = false;
    assignValue(this.value, {
      x: degreeToRadians(this._value.x),
      y: degreeToRadians(this._value.y),
      z: degreeToRadians(this._value.z),
      
    })
    this.emitAfter(0);
    this.canSync = true;
  }
  formatterX = (value: number) => `x: ${value} ${this.degreSymbol}`;
  parserX = (value: string) => Str.replace(value, ['x', ':', this.degreSymbol, ' '], '');

  formatterY = (value: number) => `y: ${value} ${this.degreSymbol}`;
  parserY = (value: string) => Str.replace(value, ['y', ':', this.degreSymbol, ' '], '');
  
  formatterZ = (value: number) => `z: ${value} ${this.degreSymbol}`;
  parserZ = (value: string) => Str.replace(value, ['z', ':', this.degreSymbol, ' '], '');

}