import { Component, NgZone, OnInit, ChangeDetectorRef, ViewEncapsulation, ElementRef, AfterViewInit, OnDestroy } from '@angular/core';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { assignValue, assignWithout, copyByList, inArray, isEmpty, Str } from '@app/_core/helpers/utils';
import { CategoryService } from '@app/_store/category';
import { ItemService, ItemTableService } from '@app/_store/item';
import { ProjectModel, ProjectService } from '@app/_store/project';
import { ProjectTableService } from '@app/_store/project/table';
import { TemplateModel, TemplateService } from '@app/_store/template';
import { TemplateTableService } from '@app/_store/template/table';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';



@Component({
    selector: 'app-project-list',
    templateUrl: './list.component.html',
    styleUrls: ['../../../styles/design/_index.scss', './list.component.scss'],
    encapsulation: ViewEncapsulation.None,
})
export class ListComponent extends BaseComponent implements OnInit, OnDestroy {
    isInited: boolean = false;
    id: number = 0;
    mode: string = 'list';
    isLoading: boolean = true;
    urlPath: string = null;
    projects: ProjectModel[] = [];
    templates: TemplateModel[] = [];
    defaultThumbnail: string = TransparentBase64Image;
    lockSidebar: boolean = false;
    isLockEventListenner: boolean = true;
    workspaceKey: string = Str.rand();
    constructor(
        public cd: ChangeDetectorRef,
        private elemRef: ElementRef,
        public activatedRoute: ActivatedRoute,
        public router: Router,
        
        private storage: AppEditorStorageService,
        // app tong quan
        // truy xuất dữ liệu
        public categoryService: CategoryService,
        public itemService: ItemService,
        // public itemTable: ItemTableService,


        public projectService: ProjectService,
        // public projectTable: ProjectTableService,
        public templateService: TemplateService,
        // public templateTable: TemplateTableService

    ) {
        super();

        this.storage.assign('editorMode', this.mode, mode => this.mode = mode);
    }

    initOnce() {
        this.moduleKey = this.workspaceKey;




        // if (!this.itemTable.get().length) {
        //     setTimeout(() => {
        //         if (!this.itemTable.get().length) {
        //             this.itemService.getAll({}).subscribe(rs => {
        //                 if (rs.data && !this.itemTable.get().length) {
        //                     rs.data.map(item => {
        //                         var r = this.itemTable.first({ id: item.id });
        //                         if (!(r && !isEmpty(r))) {
        //                             this.itemTable.insert(assignWithout({}, item, ['id']));
        //                         }
        //                     })
        //                 }
        //             })
        //         }
        //     }, 100);
        // }


        // if (!this.projectTable.get().length) {
        //     setTimeout(() => {
        //         if (!this.projectTable.get().length) {
        //             this.projectService.getAll({}).subscribe(rs => {
        //                 if (rs.data && !this.projectTable.get().length) {
        //                     rs.data.map(item => {
        //                         var r = this.projectTable.first({ id: item.id });
        //                         if (!(r && !isEmpty(r))) {
        //                             this.projectTable.insert(assignWithout({}, item, ['id']));
        //                         }
        //                     })
        //                 }
        //             })
        //         }

        //     }, 100);
        // }
        // this.router.events.subscribe((val) => {
        //     // see also 
        //     // console.log(val instanceof NavigationEnd)

        // });
        // // window['projectList'] = this;


    }

    onInit() {
        this.isLockEventListenner = false;
        this.storage.editorMode = 'list';

        this.preload();

        this.cd.detectChanges();
    }

    onDestroy() {
        this.isLockEventListenner = true;
    }

    showLoading() {
        if (!this.isFocus) return false;
    }
    hideLoading() {
        if (!this.isFocus) return false;
    }

    preload() {
        if (!this.isFocus) return false;
        // let projects = this.projectTable.select('*', null, { id: 'DESC' });
        this.storage.editorMode = 'list';
        // if (projects.length) {
        //     this.projects = projects as ProjectModel[];
        //     this.isLoading = false;
        // }
        // else {
            this.projectService.getAll({}).subscribe(rs => {
                this.isLoading = false;
                if (rs.data.length) {
                    this.projects = rs.data;
                    // rs.data.map(project => {
                        
                    //     const temp = this.projectTable.first({id:project.id});
                    //     if (!(temp && !isEmpty(temp))) {
                    //         this.projectTable.insert(assignWithout({}, temp, ['id']));
                    //     }
                    // })
                }
            }, () => this.isLoading = false);
        // }


    }

}
