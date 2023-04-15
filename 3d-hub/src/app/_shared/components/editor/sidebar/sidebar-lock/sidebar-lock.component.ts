import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
    selector: 'app-sidebar-lock',
    templateUrl: './sidebar-lock.component.html',
    styleUrls: ['./sidebar-lock.component.scss']
})
export class SidebarLockComponent extends BaseComponent implements OnInit {

    show: boolean = false;
    constructor(private events: AppEditorEventService, private cd: ChangeDetectorRef) {
        super();
        
    }

    init(){
        if(this.isChangeSubEvents){
            this.registerEventService(this.subEvents, {
                "show:sidebar-lock|dispatch": () => {
                    this.show = true;
                },
                "hide:sidebar-lock|dispatch": () => {
                    this.show = false;
                }
            })
        }
        this.activeEventServiceRegistered(this.subEvents);
    }
    onDestroy(){
        this.deactiveEventServiceRegistered(this.subEvents);
    }
}
