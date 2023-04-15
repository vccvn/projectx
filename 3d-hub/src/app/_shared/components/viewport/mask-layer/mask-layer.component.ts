import { Component, OnInit } from '@angular/core';
import { BaseComponent } from '../../base/base.component';
import { ViewportService } from '../viewport.service';

@Component({
  selector: 'mask-layer',
  templateUrl: './mask-layer.component.html',
  styleUrls: ['./mask-layer.component.scss']
})
export class MaskLayerComponent extends BaseComponent implements OnInit {

  constructor(private service: ViewportService) {
    super()
  }

  onInit(): void {
  }

}
