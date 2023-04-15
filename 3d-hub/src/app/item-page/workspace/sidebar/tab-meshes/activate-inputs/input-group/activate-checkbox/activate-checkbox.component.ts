import { Component, OnInit } from '@angular/core';
import { BaseGroupComponent } from '../base-group/base-group.component';

@Component({
  selector: 'activate-checkbox',
  templateUrl: './activate-checkbox.component.html',
  styleUrls: ['./activate-checkbox.component.scss']
})
export class ActivateCheckboxComponent extends BaseGroupComponent implements OnInit {

  constructor() {
    super();
   }

  ngOnInit(): void {
  }

}
