import { AfterViewInit, Component, ElementRef, OnInit } from '@angular/core';
import { CameraDefaultFacePositions } from '@app/_3D/store/data.type';
import { checkFacePos } from '@app/_3D/traits/camera';
import { objectHasKey } from '@app/_core/helpers/utils';
import { BaseComponent } from '../../base/base.component';
import { ViewportService } from '../viewport.service';
import { VectorControlsService } from './vector-controls.service';


const faceOpts = [
    {
        value: "custom",
        label: "Custom"
    }
]
CameraDefaultFacePositions.map(opt=>faceOpts.push(opt));

@Component({
    selector: 'app-vector-controls',
    templateUrl: './vector-controls.component.html',
    styleUrls: ['./vector-controls.component.scss']
})
export class VectorControlsComponent extends BaseComponent implements OnInit, AfterViewInit {

    isShow: boolean = false;
    canvas: Element = null;
    css: string = '';
    faceOptions = faceOpts;
    currentFace = 'custom';
    constructor(
        private events: VectorControlsService,
        // private viewportService: ViewportService,
        private elemRef: ElementRef
    ) {
        super();

        // this.initCanvas();

        this.registerEventService(window, 'resize', e => this.updateCanvasSize(e));

    }

    onChangeSubEvents() {
        this.registerEventService(this.subEvents, {
            "show|dispatch": e => {
                if(objectHasKey(e, 'value')){
                    this.isShow = e.value
                }else{
                    this.isShow = true
                }
            },
            "hide|dispatch": e => this.isShow = !1
        });

    }

    onInit(): void {
        // this.activeEventServiceRegistered(this.service);
        this.activeEventServiceRegistered(window);
    }
    onDestroy() {
        // this.deactiveEventServiceRegistered(this.service);
        this.deactiveEventServiceRegistered(window);
    }

    changeFace(face: string) {
        let f = face.toLowerCase();
        if (checkFacePos(f)) {
            this.subEvents.emit({
                type: "changeface",
                face: f
            })
        }
    }


    ngAfterViewInit(): void {
        this.initCanvas();
    }

    updateCanvasSize(event?: Event) {
        // if (this.app3D) {
        //     this.app3D.engine.updateCanvasSize(event);
        // }
    }


    initCanvas() {
        // if (this.app3D && this.canvas3D && this.elementStatus) {
        setTimeout(() => {
            var wrapper = this.elemRef.nativeElement.querySelector(".canvas-wrapper");

            if (wrapper) {
                wrapper.innerHTML = '';
                this.subEvents.setCanvasWrapper(wrapper);
            }
        }, 5);

        // }
    }

    setApp(app) {

        this.initCanvas();

    }

    setCanvas(canvas) {
        // this.canvas3D = canvas;
        this.initCanvas();
    }
}
