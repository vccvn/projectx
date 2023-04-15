import { Component, NgZone, OnInit, ChangeDetectorRef, ViewEncapsulation, ElementRef, AfterViewInit, OnDestroy } from '@angular/core';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { assignValue, assignWithout, copyByList, inArray, isEmpty, Str } from '@app/_core/helpers/utils';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';
import { CategoryService } from '@app/_store/category';
import { ItemService, ItemTableService } from '@app/_store/item';
import { TemplateModel, TemplateService } from '@app/_store/template';
import { TemplateTableService } from '@app/_store/template/table';
import { BaseComponent } from '@app/_shared/components/base/base.component';


@Component({
    selector: 'app-root-template-list',
    templateUrl: './list.component.html',
    styleUrls: ['../../../styles/design/_index.scss', './list.component.scss'],
    encapsulation: ViewEncapsulation.None,
})
export class ListComponent extends BaseComponent implements OnInit, AfterViewInit, OnDestroy {
    isInited: boolean = false;
    id: number = 0;
    mode: string = 'list';
    isLoading: boolean = true;
    app: AppEditorService = null;
    urlPath: string = null;
    templates: TemplateModel[] = [];
    defaultThumbnail: string = TransparentBase64Image;
    lockSidebar: boolean = false;
    subEventService: AppEditorEventService;
    workspaceKey: string = Str.rand();
    constructor(
        public cd: ChangeDetectorRef,
        public activatedRoute: ActivatedRoute,
        public router: Router,
        
        private storage: AppEditorStorageService,

        public templateService: TemplateService,
        public categoryService: CategoryService,
        public itemService: ItemService,
        // public itemTable: ItemTableService,
        // public templateTable: TemplateTableService,
        private elemRef: ElementRef
    ) {
        super();
        this.storage.assign('editorMode', this.mode, mode => this.mode = mode);
        // window['templateList'] = this;
    }
    initOnce() {
        this.moduleKey = this.workspaceKey;
    }

    onInit() {

        this.moduleKey = this.workspaceKey;

        this.preload();
        this.cd.detectChanges();

        // this.checkDemoData();

        // this.router.events.subscribe((val) => {
        //     // see also 
        //     // console.log(val instanceof NavigationEnd)

        // });

    }

    onDestroy() {

    }

    preload() {
        if (!this.isFocus) return;
        this.storage.editorMode = 'list';
        // let templates = this.templateTable.select('*', null, { id: 'DESC' });
        
        // if (templates.length) {
        //     this.templates = templates as TemplateModel[];
        //     this.isLoading = false;
        // }
        // else {
            this.templateService.getAll({}).subscribe(rs => {
                this.isLoading = false;
                if (rs.data.length) {
                    this.templates = rs.data;
                    // rs.data.map(template => {
                    //     const temp = this.templateTable.first({id:template.id});
                    //     if (!(temp && !isEmpty(temp))) {
                    //         this.templateTable.insert(assignWithout({}, temp, ['id']));
                    //     }
                    // })
                }
            }, () => this.isLoading = false);
        // }
    }

    checkDemoDAta(){
        if (!this.itemTable.get().length) {
            setTimeout(() => {
                if (!this.itemTable.get().length) {
                    this.itemService.getAll({}).subscribe(rs => {
                        if (rs.data && !this.itemTable.get().length) {
                            rs.data.map(item => {
                                var r = this.itemTable.first({ id: item.id });
                                if (!(r && !isEmpty(r))) {
                                    this.itemTable.insert(assignWithout({}, item, ['id']));
                                }
                            })
                        }
                    });
                }
            }, 100);
        }

        if (!this.templateTable.get().length) {
            setTimeout(() => {
                this.templateService.getAll({}).subscribe(rs => {
                    if (rs.data) {
                        rs.data.map(item => {
                            var r = this.templateTable.first({ id: item.id });
                            if (!(r && !isEmpty(r))) {
                                this.templateTable.insert(assignWithout({}, item, ['id']));
                            }
                        })
                    }
                })
            }, 100);
        }
    }

    nzCollapsedChange(event) {
        if (!this.isFocus) return;
        // this.app.updateCanvasSize();
    }


    ngAfterViewInit(): void {
        if (!this.isFocus) return;
        // this.app.updateCanvasSize();
    }

}
