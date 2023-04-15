import { Component, OnInit } from '@angular/core';
import { BaseGroupComponent } from '../base-group/base-group.component';

@Component({
  selector: 'activate-number',
  templateUrl: './activate-number.component.html',
  styleUrls: ['./activate-number.component.scss']
})
export class ActivateNumberComponent extends BaseGroupComponent implements OnInit {

  constructor() {
    super()
  }

  ngOnInit(): void {
  }


}