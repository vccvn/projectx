import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { FG_ITEM } from '@app/_shared/shared.type';
import { BaseComponent } from '../../base/base.component';
import { ViewportService } from '../viewport.service';

@Component({
    selector: 'foreground-layer',
    templateUrl: './foreground-layer.component.html',
    styleUrls: ['./foreground-layer.component.scss']
})
export class ForegroundLayerComponent extends BaseComponent implements OnInit {
    @Input() app: AppEditorService;
    app3D: AppEditorService = null;
    foregrounds: FG_ITEM[] = [];
    service: ViewportService;
    constructor(private _service: ViewportService, private cd: ChangeDetectorRef) {
        super();
    }

    onInit(): void {
        const s = this._service.sub(this.moduleKey);
        if(s && s!== this.service){
            this.service = s;
        }
        if (this.app) {
            this.setApp(this.app);
        } else {
            this.service.on('app.set', e => this.setApp(e.app), true);
        }
        

    }

    setApp(app) {
        this.app3D = app;
        const f = () => this.loadForegrounds() ;
        this.app3D.on({
            "scene.foregrounds.added": f,
            "scene.foregrounds.deleted": f,
            "scene.foregrounds.updated": f,
            "data.imported": f,
            "data.renew": f,
            "data.resetted": f
        });
        f();
    }

    loadForegrounds(){
        this.foregrounds = this.app3D.getForegrounds();
        this.cd.detectChanges();
    }
}
