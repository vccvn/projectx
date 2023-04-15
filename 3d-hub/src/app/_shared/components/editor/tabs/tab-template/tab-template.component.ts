import { Component, Output, EventEmitter, OnDestroy, OnInit, Input, ChangeDetectorRef } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { assignValue, assignWithout, copyByList, isArray, isObject } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { CategoryModel } from '@app/_store/category';
import { ItemModel, ItemService, ItemTableService } from '@app/_store/item';
import { TemplateService } from '@app/_store/template';
import { TemplateTableService } from '@app/_store/template/table';
@Component({
    selector: 'app-tab-template',
    templateUrl: './tab-template.component.html',
    styleUrls: ['./tab-template.component.scss']
})
export class TabTemplateComponent extends BaseComponent implements OnInit, OnDestroy {
    @Output()
    clickItem: EventEmitter<any> = new EventEmitter();

    @Input()
    loaded: EventEmitter<any> = new EventEmitter();

    @Output()
    loadedChange: EventEmitter<any> = new EventEmitter();

    mode: string = "explore";

    searchStatus: string = 'ready';

    categories: CategoryModel[] = [];

    searchResults: ItemModel[] = [];

    q = {
        s: null,
        category_id: null,
    };


    isSearching: boolean = false;

    hasResult: boolean = false;

    constructor(
        public templateService: TemplateService,
        // public templateTable: TemplateTableService,
        private events: AppEditorEventService,
        private cd: ChangeDetectorRef
    ) {
        super();
    }

    onInit(): void {
        if (this.mode == "explore") {
            this.explore();
        } else {
            this.search();
        }
    }

    onDestroy() {


    }

    explore() {
        this.subEvents.emit("component.checkchange");
        this.templateService.getByCategories({}).subscribe(rs => {
            if (rs.status) {
                this.categories = rs.data;

                if (rs.data.length) {
                    rs.data.map(cate => this.parseItemList(cate.templates));
                }
                this.subEvents.emit("component.checkchange");
                this.cd.detectChanges();
            }
        })
    }

    search() {
        this.searchStatus = 'searching';
        this.searchResults.splice(0);
        this.subEvents.emit("component.checkchange");
        this.templateService.getAll(this.q).subscribe(rs => {
            if (rs.count > 0) {
                this.searchResults = rs.data;
                this.parseItemList(this.searchResults);
                this.searchStatus = 'done';
                this.cd.detectChanges();
            } else {
                this.searchStatus = 'notfound';
                this.cd.detectChanges();
            }
            this.subEvents.emit("component.checkchange");

        }, error => {
            this.searchStatus = 'error';
            this.subEvents.emit("component.checkchange");
            this.cd.detectChanges();
        });
    }

    parseItemList(list) {
        if (isArray(list)) {
            list.map(item => this.parseItem(item));
        }
    }
    parseItem(item) {
        if (isObject(item)) {
            // var rs = this.templateTable.first('*', { id: item.id });
            // if (rs) {
            //     // assignValue(item, copyByList(rs, ['name', 'id', 'category_id', 'status', 'description', 'status', '']))
            //     assignWithout(item, rs, ['id', 'lights', 'meshes', 'objects']);
            //     item.objects = rs.objects;
            //     item.lights = rs.lights;
            //     item.meshes = rs.meshes;
            // }
        }
    }

    onClickSearch() {
        if (String(this.q.s).length) {
            this.mode = "search";
            this.search();
        } else if (this.mode == "search") {
            this.mode = "explore";
        }
    }

    onLayoutComplete({ isLayout, endLoading }) {
        if (!isLayout) {
            endLoading();
        }
    }

    // getFileUrl(files) {
    //   const file = files.find((f) => f.quanlity === EMediaFileQuanlity.screen);
    //   return (file && file.url) || '';
    // }

}
