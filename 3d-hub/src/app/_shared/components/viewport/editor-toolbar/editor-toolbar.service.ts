import { Injectable } from '@angular/core';
import { isArray, isObject, isString, objectHasKey } from '@app/_core/helpers/utils';
import { EventManagerService } from '@app/_core/services/event-manager.service';

@Injectable({
    providedIn: 'root'
})
export class EditorToolbarService extends EventManagerService {
    keyListenners: any = {};
    constructor() {
        super();
        this.on("click", e => {
            this.onClickHandle(e);
        });

    }
    onClickHandle(event){
        if(objectHasKey(this.keyListenners, event.key)){
            this.keyListenners[event.key].map(f => f(event));
        }
    }
    show(...buttons: any[]) {
        let btns: any[] = [];
        for (let index = 0; index < buttons.length; index++) {
            const btn = buttons[index];
            if (isArray(btn)) btn.map(b => btns.push(b));
            else if (isObject(btn)) {
                for (const bk in btn) {
                    if (Object.prototype.hasOwnProperty.call(btn, bk)) {
                        const listener = btn[bk];
                        if (typeof listener == "function") {
                            this.listen(bk, listener);
                            btns.push(bk);
                        }
                    }
                }
            }
            else btns.push(btn);
        }
        this.emit({
            type: "show",
            buttons: btns
        }, null, true);
    }

    listen(key, callback) {
        if(typeof callback == "function" && isString(key)){
            if(!objectHasKey(this.keyListenners, key)) this.keyListenners[key] = [];
            this.keyListenners[key].push(callback);
        }
    }

    hide() {
        this.keyListenners = {};
        this.emit({
            type: "show",
            buttons: []
        }, null, true);
    }
}
