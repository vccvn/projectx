import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
  selector: 'tab-light-item',
  templateUrl: './light-item.component.html',
  styleUrls: ['./light-item.component.scss']
})
export class LightItemComponent extends BaseComponent implements OnInit {
  @Input() light: any;
  @Output() clickLight = new EventEmitter<any>();
  @Output() clickDelete = new EventEmitter<any>();
  
  ngOnInit(): void {
  }

  onClick(){
    this.clickLight.emit(this.light.secret_key);
  }

  onClickDelete(){
    this.clickDelete.emit(this.light.secret_key);
  }

}

