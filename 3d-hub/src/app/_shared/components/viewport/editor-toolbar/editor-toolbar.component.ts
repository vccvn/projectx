import { Component, OnInit } from '@angular/core';
import { isArray, objectHasKey } from '@app/_core/helpers/utils';
import { BaseComponent } from '../../base/base.component';
import { EditorToolbarService } from './editor-toolbar.service';

interface Btn {
    key: string
    text: string,
    type?: string
    icon?: string
}

@Component({
    selector: 'viewport-editor-toolbar',
    templateUrl: './editor-toolbar.component.html',
    styleUrls: ['./editor-toolbar.component.scss']
})
export class EditorToolbarComponent extends BaseComponent implements OnInit {
    buttons: Btn[] = [
        {
            key: "saveView",
            text: "Save View",
        },
        {
            key: "saveThumbnail",
            text: "Save Thumbnail",
        },
        {
            key: "exportImage",
            text: "Export Image",
        }
    ];
    showBtns: Btn[] = [];
    show: boolean = false;
    constructor(private events: EditorToolbarService) {
        super();
        this.registerEventService(this.events, {
            "show|dispatch": e => this.showButtons(...e.buttons),
            "hide|dispatch": e => this.hideButtons()
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
    showButtons(...args: any[]) {
        if(args.length == 0) return this.hideButtons();
        this.showBtns = [];
        let list: any[] = [];
        let hasShow: boolean = false;
        for (let index = 0; index < args.length; index++) {
            const arg = args[index];
            if (isArray(arg)) arg.map(s => list.push(s));
            else list.push(arg)
        }
        list.map(key => {
            this.buttons.map(btn => {
                if (btn.key == key) {
                    this.showBtns.push(btn);
                    hasShow = true;
                }
            })
        })
        this.show = hasShow;
    }

    hideButtons() {
        this.show = false
        this.showBtns = []
    }

    onClick(key) {
        this.events.emit({
            type: "click",
            key: key
        });
    }

}
