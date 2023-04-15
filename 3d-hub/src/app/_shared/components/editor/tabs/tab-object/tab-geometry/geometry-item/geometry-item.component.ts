import { Component, Input, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { MeshGeometryService } from '@app/_shared/components/panels/mesh-geometry/mesh-geometry.service';

@Component({
    selector: 'geometry-item',
    templateUrl: './geometry-item.component.html',
    styleUrls: ['./geometry-item.component.scss']
})
export class GeometryItemComponent extends BaseComponent implements OnInit {
    @Input() geometry: any;
    constructor(
        private geoService: MeshGeometryService,
        private events: AppEditorEventService
    ) {
        super()
    }




    dragStart(event) {
        event.preventDefault();
        this.subEvents.emit({
            type: "geometry.dragstart",
            geometryType: this.geometry.type
        })

    }
}

