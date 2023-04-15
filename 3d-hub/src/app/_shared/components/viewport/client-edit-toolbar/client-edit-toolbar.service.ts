import { Injectable } from '@angular/core';
import { EventManagerService } from '@app/_core/services/event-manager.service';

@Injectable({
    providedIn: 'root'
})
export class ClientEditToolbarService extends EventManagerService {

    constructor() {
        super();
    }

    show(type: string, secret_key: string, mode?: string) {
        this.emit({
            type: "show",
            data: {
                type: type,
                secret_key: secret_key,
                mode: mode
            }
        })
    }
    hide() {
        this.emit({
            type: "hide"
        })
    }

    changeMode(mode) {
        this.emit({
            type: "mode.change",
            mode: mode
        })
    }
    selectMode(mode) {
        this.emit({
            type: "mode.select",
            mode: mode
        })
    }

}
