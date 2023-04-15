import { Component, OnInit } from '@angular/core';
import { assignValue, inArray } from '@app/_core/helpers/utils';
import { BaseComponent } from '../../base/base.component';
import { ClientEditToolbarService } from './client-edit-toolbar.service';

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
    { name: "more", text: "Thêm", icon: "more", isActive: false },
]


@Component({
    selector: 'client-viewport-edit-toolbar',
    templateUrl: './client-edit-toolbar.component.html',
    styleUrls: ['./client-edit-toolbar.component.scss']
})
export class ClientEditToolbarComponent extends BaseComponent implements OnInit {

    title: string = '';
    currentMode: string = '';
    show: boolean = false;

    buttons: MenuBtn[] = [];
    moreMenu: MenuBtn[] = [];
    btnList = {
        light: ["translate", "rotate", "edit", "delete"],
        object: ['download', "edit", "delete"],
        mesh: ["edit", "delete"],
        more: ["translate", "rotate", "scale"],

    }
    secret_key: string = "";

    currentType: string = "";

    constructor(private events: ClientEditToolbarService) {
        super();
        this.registerEventService(this.events, {
            "show": e => this.isFocus && this.showMenu(e.data.secret_key, e.data.type, e.data.mode),
            "hide": e => this.isFocus && this.reset(),
            "mode.change": e => this.isFocus && this.changeMode(e.mode)
        });        
    }
    // onChangeSubEvents(){
        
    // }

    onInit(): void {
        this.activeEventServiceRegistered(this.events);

    }

    onDestroy(){
        this.deactiveEventServiceRegistered(this.events);
    }

    showMenu(key: string, type: string, mode?: string) {
        
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
            });

        this.moreMenu = [];
        if (inArray(['object', 'mesh'], this.currentType)) {
            this.moreMenu = menuButtons.slice(0)
                .filter(btn => this.btnList.more.indexOf(btn.name) !== -1)
                .map(btn => {
                    var a: MenuBtn = assignValue({}, btn);
                    return a;
                });

        }

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
            this.events.emit({
                type: "mode.select",
                mode: mode
            })
        }
        else {
            this.events.emit({
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
