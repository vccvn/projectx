import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { FG_DEFAULT_DATA, FG_ITEM, FG_POSKEYS } from '@app/_shared/shared.type';
import { ViewportService } from '../../viewport.service';

@Component({
    selector: 'foreground-layer-item',
    templateUrl: './foreground-layer-item.component.html',
    styleUrls: ['./foreground-layer-item.component.scss']
})
export class ForegroundLayerItemComponent extends BaseComponent implements OnInit {

    @Input() data: FG_ITEM = null;
    @Input() index: number = 0;
    @Output() update = new EventEmitter<any>();
    @Output() clickDelete = new EventEmitter<FG_ITEM>();
    bgImageUrl: string;
    zIndex: number = 0;

    app: AppEditorService = null;

    updateEvent: (e) => any = e => {
        
        if (e.data.secret_key == this.data.secret_key) {
            this.data = e.data;
            this.setStyle();
        }
    }
    constructor(private events: ViewportService, private cd: ChangeDetectorRef) {
        super();
    }
    onChangeSubEvents(){
        this.registerEventService(this.subEvents, 'app.set', e => this.setApp(e.app), true)
    }

    onInit(): void {
        this.setStyle();

    }
    onDestroy(){
        if(this.app){
            this.app.off("scene.foregrounds.updated", this.updateEvent)
        }
    }
    setStyle() {
        let a = assignValue({}, FG_DEFAULT_DATA);
        this.data = assignValue(a, this.data);
        this.bgImageUrl = "url(" + this.data.url + ")";
        this.zIndex = 1 + this.index;
        this.cd.detectChanges();
    }

    setApp(app: AppEditorService) {
        this.app = app;
        app.on("scene.foregrounds.updated", this.updateEvent)

    }
}
