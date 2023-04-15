import { AfterViewInit, ChangeDetectorRef, Component, ElementRef, Input, OnInit } from '@angular/core';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { CallbackFunction } from '@app/_shared/shared.type';
import { BaseComponent } from '../base/base.component';
import { ClientEditToolbarService } from './client-edit-toolbar/client-edit-toolbar.service';
import { ObjectToolbarService } from './object-toolbar/object-toolbar.service';
import { ViewportService } from './viewport.service';
import html2canvas from '@app/_core/libs/html2canvas.esm.js';
@Component({
    selector: 'app-client-viewport',
    templateUrl: './client-viewport.component.html',
    styleUrls: ['./client-viewport.component.scss']
})
export class ClientViewportComponent extends BaseComponent implements OnInit {
    @Input() app: any;
    app3D: AppEditorService = null;
    canvas: Element = null;
    droppable: boolean = false;
    isLoad: boolean = false;
    appTem: AppEditorService = null;
    subToolbar: ClientEditToolbarService = null;
    previewImage = TransparentBase64Image;
    
    constructor(
        private elemRef: ElementRef,
        private events: ViewportService,
        private toolbar: ClientEditToolbarService,
        private cd: ChangeDetectorRef
    ) {
        super();
    }

    onChangeSubEvents(){
        // this.service.on(, true);

        this.registerEventService(this.subEvents, {
            'app.set|dispatch': e => {
                this.appTem = e.app;
            },
            capture: e => this.capture(e.image, e.done)
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
        this.deactiveEventServiceRegistered(this.app3D)
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
            'viewport.pointer.check': e => this.checkPointerPosition(e.event, e.handle,  e.showDroppableLayer),
            'viewport.droppable.show': () => this.droppable = true,
            'viewport.droppable.hide': () => {
                this.droppable = false;
                this.isLoad = false;
            },
            'viewport.show:loading': () => {
                this.isLoad = true;
                this.subEvents.emit("show:loading");
            },
            'viewport.hide:loading': () => {
                this.isLoad = false;
                this.subEvents.emit("hide:loading");
            },
            'viewport.droppable.loading': () => {
                this.isLoad = true;
                this.subEvents.emit("show:loading");
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

    checkPointerPosition(event:PointerEvent, callback?:any, showDroppableLayer?:boolean){
        var rect = this.elemRef.nativeElement.getBoundingClientRect();
        var clientX = event.clientX, clientY = event.clientY;
        let pos: any = {
            x: clientX - rect.x,
            y: clientX - rect.y,
            isHover: (
                clientY > rect.y &&
                clientY < rect.y + rect.height &&
                clientX > rect.x &&
                clientX < rect.x + rect.width
            ),
            rect: rect
        };

        if(showDroppableLayer && ((pos.isHover && !this.droppable) || (!pos.isHover && this.droppable))){
            this.droppable = !this.droppable
        }
        if(typeof callback == "function"){
            callback(pos);
        }
        this.app3D.emit({
            type : "viewport.pointer.emit",
            pointer: pos
        }, false);
        

    }

    capture(image, onDone: CallbackFunction){
        this.previewImage = image;
        setTimeout(() => {
            html2canvas(this.elemRef.nativeElement.querySelector('.frame')).then(canvas => {
                const img = canvas.toDataUrl();
                this.previewImage = TransparentBase64Image;
                
            });
        }, 20);
    }
}
