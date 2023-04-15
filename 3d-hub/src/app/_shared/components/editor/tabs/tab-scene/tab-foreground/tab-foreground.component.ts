import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { assignValue, assignWithout, inArray } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ImageLibraryService } from '@app/_shared/components/modals/image-library/image-library.service';
import { ModalConfirmService } from '@app/_shared/services/modal-confirm.service';
import { FG_DEFAULT_DATA, FG_ITEM } from '@app/_shared/shared.type';

@Component({
    selector: 'app-tab-foreground',
    templateUrl: './tab-foreground.component.html',
    styleUrls: ['./tab-foreground.component.scss']
})
export class TabForegroundComponent extends BaseComponent implements OnInit {
    foregrounds: FG_ITEM[] = [];

    app: AppEditorService = null;
    isInited: boolean = false;
    appEvents: any = {
        "scene.foregrounds.added": () => this.loadForeground(),
        "scene.foregrounds.deleted": () => {
            this.loadForeground();
            this.emitRefresh();
        }
    };
    constructor(
        private cd: ChangeDetectorRef,
        private library: ImageLibraryService,
        private cfm: ModalConfirmService,
        // private app: AppEditorService,
        private events: AppEditorEventService
    ) {
        super();
    }

    initOnce(){
        this.app = this.events.app;
     
    }
    init() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;
        }
        this.app.on(this.appEvents);
        this.loadForeground();
        this.cd.detectChanges();
    }
    onDestroy(){
        this.app.off(this.appEvents);
    }


    loadForeground() {
        this.foregrounds = this.app.getForegrounds();
        this.cd.detectChanges();
    }

    add() {
        this.library.open({
            title: "Choose Foreground Image",
            listType: "foreground",
            mode: "simple"
        }, image => this.addForeground(image.source), e => this.onLibraryModalCancel());
    }

    addForeground(url: string): void {
        if (this.app) {
            let fg: FG_ITEM = {
                url: url
            };
            assignWithout(fg, FG_DEFAULT_DATA, 'url');
            this.app.addForegroundData(fg);
        }
    }

    updateForeground(data) {
        this.app.updateForegroundData(data.secret_key, data);
    }

    deleteForeground(fg: FG_ITEM) {
        this.cfm.showDeleteConfirm("Are you sure delete " + fg.name + "?", () => {
            this.app.deleteForeground(fg.secret_key);
        })
    }

    onLibraryModalCancel() {

    }


    emitRefresh() {
        setTimeout(() => {
            this.subEvents.emit("tab.scene.refresh");
        }, 200);
    }

}
