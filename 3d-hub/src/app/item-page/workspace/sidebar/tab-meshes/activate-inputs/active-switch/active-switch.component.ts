import { Component, OnInit } from '@angular/core';
import { BaseInputComponent } from '@app/_shared/components/inputs/base-input/base-input.component';

@Component({
  selector: 'active-switch',
  templateUrl: './active-switch.component.html',
  styleUrls: ['./active-switch.component.scss']
})
export class ActiveSwitchComponent extends BaseInputComponent implements OnInit {

  constructor() {
    super();
  }

  ngOnInit(): void {
  }

  
  onChangeState(event){
    this.emit();
  }

}
