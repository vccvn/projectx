import { Component, OnInit } from '@angular/core';
import { BaseGroupComponent } from '../base-group/base-group.component';

@Component({
  selector: 'activate-text',
  templateUrl: './activate-text.component.html',
  styleUrls: ['./activate-text.component.scss']
})
export class ActivateTextComponent extends BaseGroupComponent implements OnInit {

  constructor() {
    super()
  }

  ngOnInit(): void {
  }


}
