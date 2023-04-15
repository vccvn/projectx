import { Component, NgZone, OnInit, ChangeDetectorRef, ViewEncapsulation, AfterViewInit, OnDestroy } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import createClass, { _class } from '@app/_core/helpers/es5.class';

import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { ItemOptions } from '@app/_3D/data/options/item';
import { ItemStorageService } from '../_store/storage.service';
import { ItemDefaultData, ItemModel, ItemService, ItemTableService } from '@app/_store/item';
import { CategoryService } from '@app/_store/category';
import { ViewportService } from '@app/_shared/components/viewport/viewport.service';
import { assignValue, assignWithout, isEmpty, isString, Str } from '@app/_core/helpers/utils';
import { EditorToolbarService } from '@app/_shared/components/viewport/editor-toolbar/editor-toolbar.service';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ItemEventService } from '../_store/event.service';
import { VectorControlsService } from '@app/_shared/components/viewport/vector-controls/vector-controls.service';
import { getConfig } from '@app/_core/config';
import { getTaskManager, runTask } from '@app/_core/tasks';
// import { ItemStateService } from '../_store/state.service';

@Component({
    selector: 'app-workspace',
    templateUrl: './workspace.component.html',
    styleUrls: ['../../../styles/design/_index.scss', '../../../styles/item/_index.scss', './workspace.component.scss'],
    encapsulation: ViewEncapsulation.None,
})
export class WorkspaceComponent extends BaseComponent implements OnInit, AfterViewInit, OnDestroy {
    id: number = 0;
    secret_id: string = "";
    mode: string = 'create';
    isLoading: boolean = true;

    app: ItemEditorService = null;
    subEventService: ItemEventService = null;
    wsKey: string = "itemWorkspace";
    subEditorToolbar: EditorToolbarService = null;
    subViewport: ViewportService = null;
    
    constructor(
        private activatedRoute: ActivatedRoute,
        private itemService: ItemService,
        // private table: ItemTableService,
        private itemEditor: ItemEditorService,
        private categoryService: CategoryService,
        private storage: ItemStorageService,
        private viewportService: ViewportService,
        private editorToolbar: EditorToolbarService,
        private events: ItemEventService,
        private vectorControls: VectorControlsService
    ) {
        super();
        this.subEventService = events.sub(this.wsKey);
        // this.moduleKey = Str.rand();
        this.subEditorToolbar = editorToolbar.sub(this.wsKey);
        this.subViewport = viewportService.sub(this.wsKey);
        
        this.vectorControls = vectorControls.sub(this.workspaceKey);
        this.app = itemEditor;
        this.subEventService.app = itemEditor;
        this.storage.assign({
            item: {},
            modelData: null,
            modelSettings: {},

        });
        this.storage.assign('editorMode', this.mode, mode => this.mode = mode);

        this.categoryService.getAll({ s: "" }).subscribe(data => {
            this.storage.setState("categories", data.data);
        });

        this.registerEventService(itemEditor, {
            "model.added": () => {
                this.storage.modelSettings = itemEditor.data.item.settings;
            },
            "save.clicked": e => this.onClickSave(e),
            "editor.attach:mesh": e => this.subEventService.emit({type: "showmeshpanel", mesh: e.mesh})
        });

        
        this.subViewport.emit({
            type: 'app.set',
            app: this.itemEditor
        }, true);

        
        this.itemEditor.setOptions(ItemOptions);
        this.itemEditor.init();



    }

    ngAfterViewInit(): void {
        this.app.updateCanvasSize();
    }

    onInit() {
        
        this.activeEventServiceRegistered(this.itemEditor);
        this.secret_id = this.activatedRoute.snapshot.paramMap.get("secret_id");
        if (this.secret_id) {
            if (this.secret_id == getConfig('data.item.secret_id')) {
                var data = getConfig('data.item');
                this.storage.editorMode = 'update';
                this.id = data.id;
                this.storage.item = data;
                this.isLoading = false;
                this.setItemData(data);
                this.vectorControls.emit({
                    type: "show",
                    value: true
                }, null, true);
            }else{
                this.storage.editorMode = 'notfound';
            }


        } else {
            this.storage.editorMode = 'notfound';
            this.isLoading = false;
        }


        this.editorToolbar.show({
            saveThumbnail: e => this.saveThumbnail()
        });

    }
    onDestroy() {
        this.deactiveEventServiceRegistered(this.itemEditor);
        this.itemEditor.removeModelItem();
        this.editorToolbar.hide();
        this.vectorControls.emit({
            type: "show",
            value: false
        }, null, true);


    }


    showLoading() {
        if (!this.isFocus) return false;
        this.viewportService.emit("show:loading", null, true);
        this.events.emit("show:sidebar-lock");
    }
    hideLoading() {
        if (!this.isFocus) return false;
        this.viewportService.emit("hide:loading", true, true);
        this.events.emit("hide:sidebar-lock");
    }
    onClickSave(event) {
        if (!this.isFocus) return;
        let data = this.itemEditor.data.item;
        if (this.mode == "update") {
            let id = data.id;
            // var s = this.table.update(data, { id: id });
            this.itemService.update(data).subscribe(d => console.log(d));
        }
    }
    saveThumbnail() {
        if (!this.isFocus) return false;
        this.app.editor.unselect();
        this.showLoading();
        setTimeout(() => {
            this.app.capture(image => {
                this.app.data.item.thumbnail = image;
                this.itemService.updateThumbnail(this.app.data.item).subscribe(rs => {
                    // console.log("Update Thành công")
                });
                this.hideLoading();
            }, () => this.hideLoading());
        }, 1000);
    }
    setItemData(data: ItemModel) {
        if (!this.isFocus) return;
        this.itemEditor.addModelItem(data, obj => {
            this.storage.modelData = obj;
            runTask("model-item.complete", [obj]);
        }, () => {
            runTask("model-item.error", []);
        }, (p) => {
            runTask("model-item.progress", [p]);
        });
    }

}
