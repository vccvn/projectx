import { Component, Output, EventEmitter, OnDestroy, OnInit, Input } from '@angular/core';
import { Geometries } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { inArray, isEmpty, Str } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { MeshGeometryService } from '@app/_shared/components/panels/mesh-geometry/mesh-geometry.service';

@Component({
    selector: 'app-tab-geometry',
    templateUrl: './tab-geometry.component.html',
    styleUrls: ['./tab-geometry.component.scss']
})
export class TabGeometryComponent extends BaseComponent implements OnInit, OnDestroy {
    geometries: any[] = Geometries.config.options;

    constructor(private geoService: MeshGeometryService, private events: AppEditorEventService) {
        super();
        
    }
    onChangeSubEvents(){
        this.registerEventService(this.subEvents, "geometry.added", e => this.onAddSuccess(e.data));
    }
    initFirst(){
        
    }


    onAddSuccess(data) {
        if(!this.isFocus) return false;
        this.geoService.open(data, e => {
            let d: any = {};
            if (inArray(['props', 'geometry', 'material'], e.key)) {
                d[e.key] = e.data[e.key];
                switch (e.key) {
                    case "props":

                        break;
                    case "geometry":

                        break;

                    case "material":

                        break;


                    default:
                        break;
                }
                this.subEvents.emit({
                    type: "mesh.setting.update",
                    secret_key: data.secret_key,
                    data: d
                });
            }

        });

    }
}
