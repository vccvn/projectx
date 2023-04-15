import { Component, Output, EventEmitter, OnInit, Input } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { EditorIO, EditorMethods } from '../../base/editor-io';

@Component({
  selector: 'app-tab-object',
  templateUrl: './tab-object.component.html',
  styleUrls: ['./tab-object.component.scss'],
})
export class TabObjectComponent extends BaseComponent implements OnInit {
  @Input() loaded: EventEmitter<any> = new EventEmitter();

  @Output() loadedChange: EventEmitter<any> = new EventEmitter();

  loadedPhoto = false;
  loadedElement = false;
  loadedBackground = false;

  onInit(): void {
    this.loadedChange.emit(true);
  }
}
