import { ChangeDetectorRef, Component, EventEmitter, Input, OnDestroy, OnInit, Output } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { assignValue, assignWithout, copyByList, isArray, isObject } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { InpEvent } from '@app/_shared/shared.type';
import { CategoryModel, CategoryResultsModel } from '@app/_store/category';
import { PriVacyStatusOptions } from '@app/_store/form';
import { ItemModel } from '@app/_store/item';
import { TemplateService } from '@app/_store/template';
import { TemplateResultsModel } from '@app/_store/template/results.model';
import { TemplateTableService } from '@app/_store/template/table';

@Component({
    selector: 'app-tab-template-create-form',
    templateUrl: './tab-template-create-form.component.html',
    styleUrls: ['./tab-template-create-form.component.scss']
})
export class TabTemplateCreateFormComponent extends BaseComponent implements OnInit, OnDestroy {
    @Input() loaded: EventEmitter<any> = new EventEmitter();

    @Output() loadedChange: EventEmitter<any> = new EventEmitter();

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
    info: any = {};
    asyncForm: boolean = true;
    categoryOptions: Array<{ label: string, value: any }> = [];
    privacyStatusOptions: any[] = PriVacyStatusOptions.map(stt => ({ label: stt.label, value: stt.value }))

    showForm: boolean = false;

    app: AppEditorService;


    hasMoreResults: boolean = false;

    hasMoreCategories: boolean = true;

    searchData: TemplateResultsModel = null;

    categoryData: CategoryResultsModel = null;

    constructor(
        public templateService: TemplateService,
        // public templateTable: TemplateTableService,
        private events: AppEditorEventService,
        private storage: AppEditorStorageService,
        private cd: ChangeDetectorRef
    ) {

        super();

        // this.storage.subcribe('editorMode', (mode) => {
        //     this.mode = mode;
        // }, true);
    }



    initOnce() {
        this.app = this.events.app;

    }
    init() {
        if (this.isChangeSubEvents) {
            this.app = this.subEvents.app;
        }
        if (this.mode == "explore") {
            this.explore();
        } else {
            this.search();
        }
    }


    explore() {
        this.subEvents.emit("component.checkchange");
        this.templateService.getByCategories({}).subscribe(rs => {
            if (rs.status) {
                this.categoryData = rs;
                this.hasMoreCategories = rs.current_page < rs.page_total;
                if (rs.status) {
                    this.categories = rs.data;

                    if (rs.data.length) {
                        rs.data.map(cate => this.parseItemList(cate.templates));
                    }
                    // this.subEvents.emit("component.checkchange");
                    // this.cd.checkNoChanges();
                }
                this.refresh(20);
            }
        })
    }

    search() {
        this.searchStatus = 'searching';
        this.searchResults.splice(0);
        this.subEvents.emit("component.checkchange");
        this.templateService.getAll(this.q).subscribe(rs => {
            this.searchData = rs;
            this.hasMoreResult = rs.current_page < rs.page_total;
            if (rs.count > 0) {
                this.searchResults = rs.data;
                this.parseItemList(this.searchResults);
                this.searchStatus = 'done';
                this.refresh(50);
            } else {
                this.searchStatus = 'notfound';
                this.refresh(50);
            }

        }, error => {
            this.searchStatus = 'error';
            
            this.refresh(20);
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
        this.templateService.getAll(a).subscribe(rs => {
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
            
        }
    }




    updateCategories(categories: CategoryModel[] = []) {
        this.categories = categories;
        let a: any[] = []
        for (let index = 0; index < categories.length; index++) {
            const cat = categories[index];
            a.push({ label: cat.name, value: cat.id })
        }
        this.categoryOptions = a;
    }

    syncInfo(data: any) {
        this.info = copyByList(data, ['name', 'description', 'category_id', 'status', 'allow_custom']);
    }
    onInpChange(event: InpEvent) {
        this.info[event.name] = event.value;
        this.app.updateInfo(this.info);
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
