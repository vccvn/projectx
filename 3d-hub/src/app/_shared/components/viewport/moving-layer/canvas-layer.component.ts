import { AfterViewInit, Component, ElementRef, Input, OnInit } from '@angular/core';
import { BaseComponent } from '../../base/base.component';
import { ViewportService } from '../viewport.service';

@Component({
    selector: 'moving-layer',
    templateUrl: './moving-layer.component.html',
    styleUrls: ['./moving-layer.component.scss']
})
export class MovingLayerComponent extends BaseComponent implements OnInit, AfterViewInit {

    @Input() canvas: Element;
    @Input() app: any;
    app3D: any = null;
    canvas3D: Element = null;
    appStatus: boolean = false;
    elementStatus: boolean = false;
    constructor(
        private elemRef: ElementRef, 
        private events: ViewportService
    ) {
        super();
    }
    onChangeSubEvents(){
        this.registerEventService(this.subEvents, "resetmoving", () => {
            let s = true;
            const fn = () => {
                if(!s){
                    let t = this.initCanvas();
                    s=!t;
                }
                if(s){
                    setTimeout(fn, 1000);
                }
            };
            fn();
        })
    }

    initFirst(){
        this.registerEventService(window, 'resize',  e => this.updateCanvasSize(e));
    }

    onInit(): void {
        let a: any = {};
        a.canvas = this.canvas ? this.setCanvas(this.canvas) : this.subEvents.on('moving.set', e => this.setCanvas(e.canvas), true);
        a.app = this.app ? this.setApp(this.app) : this.subEvents.on('app.set', e => this.setApp(e.app), true);
        // this.initCanvas();
        a = null;

        this.activeEventServiceRegistered(window);
    }
    onDestroy(){
        this.deactiveEventServiceRegistered(window);
    }


    ngAfterViewInit(): void {
        this.elementStatus = true;
        this.initCanvas();
    }

    updateCanvasSize(event?:Event){
        if(this.app3D){
            this.app3D.engine.updateCanvasSize(event);
        }
    }
    

    initCanvas() {
        if(this.app3D && this.canvas3D && this.elementStatus){
            var wrapper = this.elemRef.nativeElement;
            wrapper.innerHTML = '';
            // wrapper.appendChild(this.canvas3D);
            this.app3D.engine.setWrapper(wrapper);
            setTimeout(() => {
                this.updateCanvasSize();
            }, 10);
            return true;
        }
        return false;
    }

    setApp(app) {
        this.app3D = app;
        if(!this.canvas3D){
            this.canvas3D = this.app3D.engine.getCanvas();
        }
        this.initCanvas();

    }

    setCanvas(canvas){
        this.canvas3D = canvas;
        this.initCanvas();
    }
}
