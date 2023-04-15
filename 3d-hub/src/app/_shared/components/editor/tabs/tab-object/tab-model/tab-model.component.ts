import { Component, Output, EventEmitter, OnDestroy, OnInit, Input, ChangeDetectorRef } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { assignValue, assignWithout, isArray, isObject } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { CategoryModel, CategoryResultsModel } from '@app/_store/category';
import { ItemModel, ItemService, ItemTableService } from '@app/_store/item';
import { ItemResultsModel } from '@app/_store/item/results.model';


@Component({
    selector: 'app-tab-model',
    templateUrl: './tab-model.component.html',
    styleUrls: ['./tab-model.component.scss'],
})
export class TabModelComponent extends BaseComponent implements OnInit, OnDestroy {
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
        category_id: "",
    };


    isSearching: boolean = false;

    hasMoreResults: boolean = false;
    
    hasMoreCategories: boolean = true;

    searchData: ItemResultsModel = null;

    categoryData: CategoryResultsModel = null;


    hasResult: boolean = false;
    app: AppEditorService;
    constructor(
        private itemService: ItemService,
        // private itemTable: ItemTableService,
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
        // this.subEvents.emit("component.checkchange");
        this.refresh(1);
        this.itemService.getByCategories({}).subscribe(rs => {
            this.categoryData = rs;
            this.hasMoreCategories = rs.current_page < rs.page_total;
            if (rs.status) {
                this.categories = rs.data;

                if (rs.data.length) {
                    rs.data.map(cate => this.parseItemList(cate.items));
                }
                // this.subEvents.emit("component.checkchange");
                // this.cd.checkNoChanges();
            }
            this.refresh(20);
        })
    }

    search() {
        this.searchStatus = 'searching';
        this.searchResults.splice(0);
        // this.subEvents.emit("component.checkchange");
        this.refresh(20);
        this.itemService.getAll(this.q).subscribe(rs => {
            this.searchData = rs;
            this.hasMoreResults = rs.current_page < rs.page_total;
            if (rs.count > 0) {
                this.searchResults = rs.data;
                this.parseItemList(this.searchResults);
                this.searchStatus = 'done';
                this.refresh(50);
            } else {
                this.searchStatus = 'notfound';
                this.refresh(50);
            }
            // this.cd.checkNoChanges();
            // this.subEvents.emit("component.checkchange");

        }, error => {
            this.searchStatus = 'error';

            // this.subEvents.emit("component.checkchange");
            this.refresh(20);
            // this.cd.checkNoChanges();
        });
    }

    moreCategory(){
        if(this.hasMoreCategories){
            this.itemService.getByCategories({page: this.categoryData.current_page+1}).subscribe(rs => {
                this.categoryData = rs;
                this.hasMoreCategories = rs.current_page < rs.page_total;
                if (rs.status) {
                    
                    if (rs.data.length) {
                        rs.data.map(cate => this.parseItemList(cate.items));
                    }
                    rs.data.map(cate => {
                        this.categories.push(cate);
                    });
                    // this.subEvents.emit("component.checkchange");
                    this.refresh(20);
                    // this.cd.checkNoChanges();
                }
            })
        }
    }

    moreResult(){
        let a = assignValue({}, this.q);
        a.page = this.searchData.current_page+1;
        this.itemService.getAll(a).subscribe(rs => {
            this.searchData = rs;
            this.hasMoreResult = rs.current_page < rs.page_total;
            if (rs.count > 0) {
                rs.data.map(item => this.searchResults.push(item));
                this.parseItemList(rs.data);
                this.searchStatus = 'done';
            } else {
                // this.searchStatus = 'notfound';
            }
            this.refresh(20);
            // this.cd.checkNoChanges();
            // this.subEvents.emit("component.checkchange");

        }, error => {
            // this.searchStatus = 'error';
            this.refresh(20);
            // this.subEvents.emit("component.checkchange");
            // this.cd.checkNoChanges();
        });
    }

    parseItemList(list) {
        if (isArray(list)) {
            list.map(item => this.parseItem(item));
        }
    }
    parseItem(item) {
        if (isObject(item)) {
            // var rs = this.itemTable.first('*', { id: item.id });
            // if (rs) {
            //     assignWithout(item, rs, ['id', 'settings']);
            //     item.settings = rs.settings;
            // }
        }
    }

    onClickSearch() {
        if (String(this.q.s).length) {
            this.mode = "search";
            this.search();
        } else if (this.mode == "search") {
            this.mode = "explore";
            this.refresh(20);
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