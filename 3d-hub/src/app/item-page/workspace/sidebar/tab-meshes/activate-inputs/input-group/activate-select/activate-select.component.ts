import { Component, OnInit } from '@angular/core';
import { BaseGroupComponent } from '../base-group/base-group.component';

@Component({
  selector: 'activate-select',
  templateUrl: './activate-select.component.html',
  styleUrls: ['./activate-select.component.scss']
})
export class ActivateSelectComponent extends BaseGroupComponent implements OnInit {

  constructor() {
    super()
  }

  ngOnInit(): void {
  }

  onSelect(event){
    this.config.value = event.value;
    this.onChange(event);
  }

}