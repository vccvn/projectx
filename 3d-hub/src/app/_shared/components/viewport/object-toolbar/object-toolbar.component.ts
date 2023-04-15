import { Component, OnInit } from '@angular/core';
import { assignValue, inArray } from '@app/_core/helpers/utils';
import { BaseComponent } from '../../base/base.component';
import { ObjectToolbarService } from './object-toolbar.service';

interface MenuBtn {
    name: string,
    text: string,
    title?: string,
    icon?: string,
    isActive?: boolean
}

let menuButtons: MenuBtn[] = [
    { name: "translate", text: "Di chuyển", icon: "fullscreen", isActive: false },
    { name: "rotate", text: "Xoay", icon: "transaction", isActive: false },
    { name: "scale", text: "Kéo giãn", icon: "expand", isActive: false },
    { name: "download", text: "Tải tài nguyên", icon: "download", isActive: false },
    { name: "edit", text: "Chỉnh sửa", icon: "edit", isActive: false },
    { name: "delete", text: "Xóa", icon: "delete", isActive: false },
]

@Component({
    selector: 'viewport-object-toolbar',
    templateUrl: './object-toolbar.component.html',
    styleUrls: ['./object-toolbar.component.scss']
})
export class ObjectToolbarComponent extends BaseComponent implements OnInit {

    title: string = '';
    currentMode: string = '';
    show: boolean = false;

    buttons: MenuBtn[] = [];
    btnList = {
        light: ["translate", "rotate", "edit", "delete"],
        object: ["translate", "rotate", "scale", "edit", 'download', "delete"],
        mesh: ["translate", "rotate", "scale", "edit", "delete"]
    }
    secret_key: string = "";

    currentType: string = "";

    
    constructor(private events: ObjectToolbarService) {
        super();
        this.registerEventService(this.events, {
            "show": e => this.showMenu(e.data.secret_key, e.data.type, e.data.mode),
            "hide": e => this.reset(),
            "mode.change": e => this.changeMode(e.mode),
        });
    }

    onChangeSubEvents(){
        
    }

    onInit(): void {
        this.activeEventServiceRegistered(this.events);
    }
    onDestroy(){
        this.deactiveEventServiceRegistered(this.events);
    }

    showMenu(key:string, type:string, mode?:string) {
        this.reset();
        this.secret_key = key;
        this.currentType = type;
        if (typeof this.btnList[type] != "undefined") {
            this.show = true;
            if (mode && inArray(["translate", "rotate", "scale"], mode)) {
                this.currentMode = mode;
            }
            this.setButtons();
        }
    }

    changeMode(mode: string) {
        this.currentMode = mode;
        this.setButtons();
    }
    setButtons() {
        this.buttons = menuButtons.slice(0)
            .filter(btn => this.btnList[this.currentType].indexOf(btn.name) !== -1)
            .map(btn => {
                var a: MenuBtn = assignValue({}, btn);
                if (a.name == this.currentMode) {
                    a.isActive = true;
                }
                return a;
            })
    }

    reset() {
        this.show = false;
        this.buttons = [];
        this.secret_key = "";
    }

    onBtnClick(mode) {
        if (inArray(["translate", "rotate", "scale"], mode)) {
            this.currentMode = mode;
            this.buttons.map(btn => btn.isActive = btn.name == mode);
            this.subEvents.emit({
                type: "mode.select",
                mode: mode
            })
        }
        else {
            this.subEvents.emit({
                type: "action",
                data: {
                    action: mode,
                    type: this.currentType,
                    secret_key: this.secret_key
                }

            })
        }
    }
}
