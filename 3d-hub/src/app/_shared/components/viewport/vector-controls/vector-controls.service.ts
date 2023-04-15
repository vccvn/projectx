import { Injectable } from '@angular/core';
import { ControlSyncEngine, getControlEngine } from '@app/_3D/engines/controls.engine';
import { EventManagerService } from '@app/_core/services/event-manager.service';
import { ViewportService } from '../viewport.service';
var secret_id = 1;

@Injectable({
    providedIn: 'root'
})
export class VectorControlsService extends EventManagerService {
    engine = getControlEngine();

    constructor() {
        super();
        this.start()
    }

    start() {
        this.on("changeface", e => this.engine.changeCameraLookFace(e.face, true));
    }
    getCanvas(){
        return this.engine.getCanvas();
    }

    setCanvasWrapper(element){
        this.engine.setWrapper(element);
    }

    show(){
        this.emit({
            type: "show",
            value: true
        });
    }
    hide(){
        this.emit({
            type: "show",
            value: false
        });
    }

}
