import { ChangeDetectorRef, Component, OnInit, SimpleChanges } from '@angular/core';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
  selector: 'inp-vector3',
  templateUrl: './vector3.component.html',
  styleUrls: ['./vector3.component.scss']
})
export class Vector3Component extends BaseInputComponent implements OnInit {
  degreSymbol : string = "°";
  _value:any = {
    x:0,
    y:0,
    z:0
  };

  canSync: boolean = false;

  constructor(private cd: ChangeDetectorRef) {
    super();
  }



  ngOnInit(): void {
    this.syncFromParent();
    this.canSync = true;

  }


  syncFromParent(){
    // this._value = {
    //   x: this.value.x,
    //   y: this.value.y,
    //   z: this.value.z
    // }
    this.cd.detectChanges()
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
    // assignValue(this.value, {
    //   x: this._value.x,
    //   y: this._value.y,
    //   z: this._value.z,
      
    // });
    
    this.emit();
    this.canSync = true;
  }

  formatterX = (value: number) => `x: ${value}`;
  parserX = (value: string) => value.replace('x: ', '');
  formatterY = (value: number) => `y: ${value}`;
  parserY = (value: string) => value.replace('y: ', '');
  formatterZ = (value: number) => `z: ${value}`;
  parserZ = (value: string) => value.replace('z: ', '');

}
