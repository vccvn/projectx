import { Component, Input, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
  selector: 'app-tab-controls',
  templateUrl: './tab-controls.component.html',
  styleUrls: ['./tab-controls.component.scss']
})
export class TabControlsComponent extends BaseComponent implements OnInit {

  constructor(
  ) {
    super();
  }


}
