import { Component, Input, OnInit } from '@angular/core';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
  selector: 'inp-textarea-group',
  templateUrl: './inp-textarea-group.component.html',
  styleUrls: ['./inp-textarea-group.component.scss']
})
export class InpTextareaGroupComponent extends BaseInpGroupComponent implements OnInit {

  @Input() minRows: number = 3;
  @Input() maxRows: Number = 5;
  
  configProps = ["minRows", "maxRows"];
  constructor() {
      super();
  }



  onInit(): void {
      assignValue(this.defaultValues,{
        minRows: 3,
        maxRows: 5
      });
      this.inpInit();
      // this.syncFromParent();

  }

}
