import { Injectable } from '@angular/core';
import { isObject } from '@app/_core/helpers/utils';
import { EventManagerService } from '@app/_core/services/event-manager.service';

@Injectable({
    providedIn: 'root'
})
export class PanelLightService extends EventManagerService {

    constructor() {
        super();
    }


    open(data: any, onChange?: (...args: any[]) => any, onDone?: (...args: any[]) => any) {
        if (!isObject(data)) return false;
        if (typeof onChange == "function") {
            if (typeof data.onChange != "function") {
                data.onChange = onChange;
            }
            else if (typeof data.change != "function") {
                data.change = onChange;
            }
        }

        if (typeof onChange == "function") {
            if (typeof data.onDone != "function") {
                data.onDone = onDone;
            }
            else if (typeof data.done != "function") {
                data.done = onDone;
            }
        }

        this.emit({
            type: "panel.show",
            data: data
        })
    }
    close() {
        this.emit("panel.hide");
    }


    updateProps(data) {
        if (isObject(data) && data.secret_key) {
            this.emit({
                type: "editor.update.props",
                data: data
            })
        }
    }


    updateTargetProps(data) {
        if (isObject(data) && data.secret_key) {
            this.emit({
                type: "editor.update.props.target",
                data: data
            })
        }
    }

    
}
