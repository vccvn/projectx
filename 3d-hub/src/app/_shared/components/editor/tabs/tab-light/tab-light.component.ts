import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
    selector: 'app-tab-light',
    templateUrl: './tab-light.component.html',
    styleUrls: ['./tab-light.component.scss']
})
export class TabLightComponent extends BaseComponent implements OnInit {

    height50: boolean = false;
    constructor(
        private cd: ChangeDetectorRef,
        private events: AppEditorEventService
    ){
        super();
        
    }

    
    initOnce(){
     
    }
    init() {
        if(this.isChangeSubEvents){
            this.registerEventService(this.subEvents, {
                "tab.light.refresh": e => {
                    // console.log('r11')
                    this.height50 = true;
                    this.cd.detectChanges();
                    setTimeout(() => {
                        this.height50 = false;
                        this.cd.detectChanges();
                            
                    }, 100);
                }
            })
        }
        this.activeEventServiceRegistered(this.subEvents);
        this.cd.detectChanges();
    }
    onDestroy(){
        this.deactiveEventServiceRegistered(this.subEvents);
    }
}
