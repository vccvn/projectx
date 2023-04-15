import { Injectable } from '@angular/core';
import { isObject } from '@app/_core/helpers/utils';

import { NzModalService } from 'ng-zorro-antd/modal';
import { CallbackFunction } from '@app/_shared/shared.type';
import { EventManagerService } from '@app/_core/services/event-manager.service';


@Injectable({
    providedIn: 'root'
})
export class ModalConfirmService extends EventManagerService {
    onOkHandle: CallbackFunction = null;
    onCancelHandle: CallbackFunction = null;
    defaultTexts = {
        del: {
            ok: "Yes",
            cancel: "No",
            title: "Are you sure delete this",
            description: ""
        },
        conf: {
            cancel: "Cancel",
            no: "No",
            title: "Do yeu want to do this action?",
            description: ""

        }
    };

    constructor(private modal: NzModalService) {
        super();
    }

    open(type: string, message: any, onOk?: CallbackFunction, onCancel?: CallbackFunction): any {
        this.onOkHandle = null;
        this.onCancelHandle = null;
        let options: any = {};
        if (typeof onOk == "function") {
            this.onOkHandle = onOk;
        }
        if (typeof onCancel == "function") {
            this.onCancelHandle = onCancel;
        }

        if (isObject(message)) {
            options.nzTitle = message.title || message.message || this.defaultTexts[type].title;
            if (message.content || message.description)
                options.nzContent = message.content || message.description;
            if (message.btnOkType) {
                options.nzOkType = message.btnOkType;
            } else if (type == "del") {
                options.nzOkType = "primary";
            }
            options.nzOkText = message.btnOkText || this.defaultTexts[type].ok;
            if (type == "del") {
                if (typeof message.isDanger == "boolean") {
                    options.nzOkDanger = message.isDanger;
                } else {
                    options.nzOkDanger = true;
                }
            }

            options.nzCancelText = message.btnCancelText || this.defaultTexts[type].cancel;
            ['ok', 'onOk', 'onOk', 'OK', 'onOkClick', "onDone", 'onYes', 'onDoneClick', 'onYesClick', 'yes'].map(s => {
                if (typeof message[s] == "function") {
                    this.onOkHandle = message[s];
                }
            });
            ['cancel', 'onCancel', 'onCancelClick', 'no', 'onNoClick', "onNo"].map(s => {
                if (typeof message[s] == "function") {
                    this.onCancelHandle = message[s];
                }
            })


        }
        else{
            options.nzTitle = message || this.defaultTexts[type].title;
            options.nzOkText = this.defaultTexts[type].ok;
            if (type == "del") {
                options.nzOkDanger = true;
            }

            options.nzCancelText = this.defaultTexts[type].cancel;

        }
        options.nzOnOk = () => this.onclickOk();
        options.nzOnCancel = () => this.onClickCancel();
        this.modal.confirm(options);
    }


    showConfirm(message: any, onOk?: CallbackFunction, onCancel?: CallbackFunction): void {
        this.open("conf", message, onOk, onCancel);
    }

    showDeleteConfirm(message: any, onOk?: CallbackFunction, onCancel?: CallbackFunction): void {
        this.open("del", message, onOk, onCancel);
    }

    onclickOk() {
        if(typeof this.onOkHandle == "function"){
            this.onOkHandle();
        }
        
        this.emit("close");
    }
    onClickCancel() {
        if(typeof this.onCancelHandle == "function"){
            this.onCancelHandle();
        }
        this.emit("close");
    }
}
