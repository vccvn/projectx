import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { BaseComponent } from '../../base/base.component';
import { ViewportService } from '../viewport.service';

@Component({
    selector: 'viewport-loading-layer',
    templateUrl: './loading-layer.component.html',
    styleUrls: ['./loading-layer.component.scss']
})
export class LoadingLayerComponent extends BaseComponent implements OnInit {
    isActive: boolean = false;
    isInited: boolean = false;
    constructor(private events: ViewportService, private cd: ChangeDetectorRef) {
        super();
    }

    onChangeSubEvents(){
        this.registerEventService(this.subEvents, {
            "show:loading|dispatch": () => {
                this.isActive = true;
                // this.cd.checkNoChanges();
            },
            "hide:loading|dispatch": () => {
                this.isActive = false;
                // this.cd.checkNoChanges();
            }
        });
    }
    onInit(): void {
        // this.activeEventServiceRegistered(this.viewport);

    }
    onDestroy(){
        // this.deactiveEventServiceRegistered(this.viewport);
    }

}
