import { Component, OnInit } from '@angular/core';
import { BaseComponent } from '../../base/base.component';
import { ViewportService } from '../viewport.service';

@Component({
  selector: 'droppable-layer',
  templateUrl: './droppable-layer.component.html',
  styleUrls: ['./droppable-layer.component.scss']
})
export class DroppableLayerComponent extends BaseComponent implements OnInit {

  constructor(private service: ViewportService) {
    super();
  }

  ngOnInit(): void {
  }

}
