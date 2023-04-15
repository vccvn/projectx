import { ChangeDetectorRef, Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { assignValue, degreeToRadians, radianToDegrees, Str } from '@app/_core/helpers/utils';
import { EventManagerService } from '@app/_core/services/event-manager.service';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
  selector: 'inp-rotation-group',
  templateUrl: './inp-rotation-group.component.html',
  styleUrls: ['./inp-rotation-group.component.scss']
})
export class InpRotationGroupComponent extends BaseInpGroupComponent implements OnInit, OnChanges {

  @Input() events: EventManagerService;

  degreSymbol : string = "°";
  _value:any = {
    x:0,
    y:0,
    z:0
  };

  canSync: boolean = false;

  rotateCallnack =  e => {
    if(e.value){
      this.value = e.value;

    }
    this.syncFromParent();
  };

  constructor(private cd: ChangeDetectorRef) {
    super();
  }




  onInit(): void {
    this.inpInit();
    this.syncFromParent();
    this.canSync = true;
    if(this.events){
      this.events.on("props.rotation.change",this.rotateCallnack)
    }
  }

  onDestroy(){
    if(this.events){
      this.events.off("props.rotation.change",this.rotateCallnack)
    }
  }


  syncFromParent(){
    assignValue(this._value, {
      x: radianToDegrees(this.value.x),
      y: radianToDegrees(this.value.y),
      z: radianToDegrees(this.value.z)
  });
    this.cd.detectChanges();
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
    this.emitChange();
    this.canSync = true;
  }

  formatterX = (value: number) => `x: ${value} ${this.degreSymbol}`;
  parserX = (value: string) => Str.replace(value, ['x', ':', this.degreSymbol, ' '], '');

  formatterY = (value: number) => `y: ${value} ${this.degreSymbol}`;
  parserY = (value: string) => Str.replace(value, ['y', ':', this.degreSymbol, ' '], '');
  
  formatterZ = (value: number) => `z: ${value} ${this.degreSymbol}`;
  parserZ = (value: string) => Str.replace(value, ['z', ':', this.degreSymbol, ' '], '');

}
