import { Component, OnInit } from '@angular/core';
import { BaseGroupComponent } from '../base-group/base-group.component';

@Component({
  selector: 'activate-texture',
  templateUrl: './activate-texture.component.html',
  styleUrls: ['./activate-texture.component.scss']
})
export class ActivateTextureComponent extends BaseGroupComponent implements OnInit {

  oldAttachValue: any = null;

  constructor() {
    super();
  }

  ngOnInit(): void {
    if(this.config.attach){
      this.oldAttachValue = this.config.attach.value;
    }
  }
  
  onAttachChange(event){
    if(this.oldAttachValue != event.value){
      
      this.config.attach.value = event.value;
      this.subcribe.emit({
        name: this.config.attach.name,
        value: event.value,
        old: this.oldAttachValue
      });
      this.oldAttachValue = event.value
    }
    
  }
}
