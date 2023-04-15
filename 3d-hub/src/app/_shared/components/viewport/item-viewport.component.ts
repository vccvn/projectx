import { AfterViewInit, ChangeDetectorRef, Component, ElementRef, Input, OnInit } from '@angular/core';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BaseComponent } from '../base/base.component';
import { ClientEditToolbarService } from './client-edit-toolbar/client-edit-toolbar.service';
import { ObjectToolbarService } from './object-toolbar/object-toolbar.service';
import { ViewportService } from './viewport.service';

@Component({
    selector: 'app-item-viewport',
    templateUrl: './client-viewport.component.html',
    styleUrls: ['./client-viewport.component.scss']
})
export class ItemViewportComponent extends BaseComponent implements OnInit {
    @Input() app: any;
    app3D: AppEditorService = null;
    canvas: Element = null;
    droppable: boolean = false;
    isLoad: boolean = false;
    appTem: AppEditorService = null;
    subToolbar: ObjectToolbarService = null;
    constructor(
        private elemRef: ElementRef,
        private events: ViewportService,
        private toolbar: ObjectToolbarService,
        private cd: ChangeDetectorRef
    ) {
        super();
        
    }

    onChangeSubEvents(){
        // this.service.on(, true);

        this.registerEventService(this.subEvents, {
            'app.set|dispatch': e => {
                this.appTem = e.app;
            }
        })
        this.registerEventService(document, {
            pointerup: e => this.transferEvent(e),
        })
    }

    onInit(): void {
        const st = this.toolbar.sub(this.moduleKey);
        if(this.subToolbar != st){
            this.subToolbar = st;
        }
        this.hasChangeApp = false;
        if (this.app) {
            this.setApp(this.app);
        }else if(!this.app3D){
            if(this.appTem) this.setApp(this.appTem);
            else this.subEvents.on('app.set', e => this.setApp(e.app), true);
        }

        if(!this.hasChangeApp && this.app3D){
            this.activeEventServiceRegistered(this.app3D);
        }
        this.hasChangeApp = false;
        this.cd.detectChanges();
        this.activeEventServiceRegistered(document)
    }

    onDestroy(){
        this.deactiveEventServiceRegistered(this.app3D);
        this.deregisterAllEventService(document)
    }

    initCanvas() {
        this.canvas = this.app3D.engine.getCanvas();
    }

    setApp(app) {
        if(app == this.app3D) return this.initCanvas();
        if(this.app3D){
            this.deactiveEventServiceRegistered(this.app3D);
            this.deregisterAllEventService(this.app3D);
        }

        this.app3D = app;
        this.registerEventService(this.app3D, {
            'viewport.show:loading': () => {
                this.isLoad = true;
                this.subEvents.emit("show:loading");
            },
            'viewport.hide:loading': () => {
                this.isLoad = false;
                this.subEvents.emit("hide:loading");
            },
            
            "control.mode.change": e => this.subToolbar.changeMode(e.node),
            "init": () => this.subEvents.emit("resetcanvas")    
        });

        this.activeEventServiceRegistered(this.app3D);
        this.hasChangeApp = true;
        this.initCanvas();
        
    }

    transferEvent(event){
        if(this.app3D){
            this.app3D.transferEventListenner(event)
        }
    }

}
