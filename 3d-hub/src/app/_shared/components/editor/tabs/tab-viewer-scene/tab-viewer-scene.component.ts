import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
  selector: 'app-tab-viewer-scene',
  templateUrl: './tab-viewer-scene.component.html',
  styleUrls: ['./tab-viewer-scene.component.scss']
})
export class TabViewerSceneComponent extends BaseComponent implements OnInit {
  @Input() loaded: EventEmitter<any> = new EventEmitter();

  @Output() loadedChange: EventEmitter<any> = new EventEmitter();

  loadedForeground = false;
  loadedBackground = false;
  height50: boolean = false;

  constructor(private cd: ChangeDetectorRef) {
      super();
  }
  onInit(): void {
      this.loadedChange.emit(true);
      
  }
}
