import { Component, OnInit } from '@angular/core';
import { BaseGroupComponent } from '../base-group/base-group.component';

@Component({
  selector: 'activate-range',
  templateUrl: './activate-range.component.html',
  styleUrls: ['./activate-range.component.scss']
})
export class ActivateRangeComponent extends BaseGroupComponent implements OnInit {

  constructor() {
    super();
   }

  ngOnInit(): void {
  }

  valChange(value){
    this.onChange({value: value});
  }

}
