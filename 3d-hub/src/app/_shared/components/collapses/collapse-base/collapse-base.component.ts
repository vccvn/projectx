import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { InpEvent } from '@app/_shared/shared.type';
import { BaseComponent } from '../../base/base.component';

@Component({
  template: ''
})
export abstract class CollapseBaseComponent extends BaseComponent {

  @Input() show: boolean = false;
  @Output() subcribe = new EventEmitter<InpEvent>();
  @Input() title: string = '';
  
  toggle(){
    this.show = !!!this.show;
  }

}
