import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { isString } from '@app/_core/helpers/utils';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
  selector: 'inp-texture-group',
  templateUrl: './inp-texture-group.component.html',
  styleUrls: ['./inp-texture-group.component.scss']
})
export class InpTextureGroupComponent extends BaseInpGroupComponent implements OnInit {
  @Output() modalCancelSelect = new EventEmitter<any>();
  @Output() onCloseLibrary = new EventEmitter<any>();
  @Input() output: boolean = false;
  @Input() listType: string = "list";
  filename: string = "Chu7a chon5 file";
  constructor() {
    super();
  }

  onInit(): void {
    this.inpInit();
    this.onInpValChange();
  }
  onInpValChange(){
    this.filename = isString(this.value)? this.value.split("/").pop():"";
  }

  onCancel(){
    this.modalCancelSelect.emit(true);
    this.onCloseLibrary.emit(true);
  }
}
