import { Component, ChangeDetectorRef, ElementRef, ViewChild, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { TemplateModel, TemplateService } from '@app/_store/template';
import { Subject, Observable } from 'rxjs';

@Component({
    selector: 'app-header',
    templateUrl: './header.component.html',
    styleUrls: ['./header.component.scss'],
})
export class HeaderComponent extends BaseComponent implements OnInit {
    @ViewChild('inputElement', { static: false }) inputElement?: ElementRef;

    @Output() clickSave = new EventEmitter<any>();

    renderData$: Observable<Blob>;
    renderLoading$: Observable<boolean>;

    isVisible = false;
    data: any;
    percent = 0;
    renderLoading = true;

    downloadUrl: string = 'javascript:void(0);';
    downloadAvailable: boolean = false;


    mode: string = 'list';

    isInited: boolean = false;
    constructor(
        private storage: AppEditorStorageService,

        private cd: ChangeDetectorRef
    ) {
        super();
    }

    initOnce() {
        this.storage.subcribe('template', (data) => {
            if (data && data.download_source_url) {
                this.downloadAvailable = true;
                this.downloadUrl = data.download_source_url;
            }
        }, true);
        this.storage.subcribe('editorMode', mode => {
            this.mode = mode;
            this.cd.detectChanges();
        }, true);
    }

    download(event: Event) {
        if (!this.downloadAvailable) {
            event.preventDefault();
            return false;
        }
    }

    save(event) {
        // console.log(this.editor.data);
        this.clickSave.emit(true);
    }

    handleOk(): void {
        this.isVisible = false;
    }

    handleCancel(): void {
        this.isVisible = false;
    }

    onClickUndo() {
        // this.editor.historyManager.undo();
    }
    onClickRedo() {
        // this.editor.historyManager.redo();
    }
}