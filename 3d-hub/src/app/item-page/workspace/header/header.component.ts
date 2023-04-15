import { Component, ChangeDetectorRef, ElementRef, ViewChild, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { ItemStorageService } from '@app/item-page/_store/storage.service';
import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { getConfig } from '@app/_core/config';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ItemService } from '@app/_store/item';
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

    private unsubscribe: Subject<void> = new Subject();



    logo = getConfig('urls.logo_url');
    link = getConfig('urls.logo_link');
    
    constructor(private storage: ItemStorageService, private service: ItemService, private editor: ItemEditorService) {
        super();
        this.storage.subcribe('item', (data) => {
            if (data && data.download_source_url) {
                this.downloadAvailable = true;
                this.downloadUrl = data.download_source_url;
            }
        }, true);
    }

    onInit() {

    }

    download(event: Event) {
        if (!this.downloadAvailable) {
            event.preventDefault();
            return false;
        }
    }

    save(event) {
        this.editor.emit("save.clicked");
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
