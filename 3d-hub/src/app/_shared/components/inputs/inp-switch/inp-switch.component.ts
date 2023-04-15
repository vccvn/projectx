import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseInputComponent } from '../base-input/base-input.component';

@Component({
  selector: 'inp-switch',
  templateUrl: './inp-switch.component.html',
  styleUrls: ['./inp-switch.component.scss']
})
export class InpSwitchComponent extends BaseInputComponent implements OnInit {
  
  constructor(private cd: ChangeDetectorRef) {
    super();
  }

  ngOnInit(): void {
    this.cd.detectChanges();
  }

  onChangeState(event){
    this.emitAfter(50);
  }

}
