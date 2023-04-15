import { Component, Output, EventEmitter, OnDestroy, OnInit } from '@angular/core';
import { assignValue, copyByList, isArray } from '@app/_core/helpers/utils';
import { PriVacyStatusOptions } from '@app/_store/form';


import { CategoryModel, CategoryService } from '@app/_store/category';
import { AppEditorStorageService } from '@app/_3D/services/app-editor-storage.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { InpEvent } from '@app/_shared/shared.type';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';

@Component({
    selector: 'app-tab-editor-info',
    templateUrl: './tab-info.component.html',
    styleUrls: ['./tab-info.component.scss'],
})
export class TabEditorInfoComponent extends BaseComponent implements OnInit, OnDestroy {
    info: any = {};
    categories: CategoryModel[];
    asyncForm: boolean = true;
    mode: string = 'create';
    categoryOptions: Array<{label:string, value: any}> = [];
    privacyStatusOptions: any = PriVacyStatusOptions.map(stt => ({label:stt.label, value:stt.value}))
    app: AppEditorService = null;
    constructor(private storage: AppEditorStorageService, private events: AppEditorEventService) {
        super();
        this.storage.onChange("info", (data) => {
            this.syncInfo(data);
        }, true);
        

        this.storage.onChange('categories', (categories) => {
            this.updateCategories(categories);
        }, true);

        this.storage.onChange('editorMode', (mode) => {
            this.mode = mode;
        }, true);

    }

    
    initOnce(){
        this.app = this.events.app;
     
    }
    init() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;
        }
    }
    destroy(){
        
    }


    
    
    
    updateCategories(categories: CategoryModel[] = []) {
        this.categories = categories;
        let a : any[] = []
        for (let index = 0; index < categories.length; index++) {
            const cat = categories[index];
            a.push({label: cat.name, value: cat.id})
        }
        this.categoryOptions = a;
    }

    syncInfo(data: any) {
        this.info = copyByList(data, ['name', 'description', 'category_id', 'status']);
    }
    onInpChange(event: InpEvent){
        this.info[event.name] = event.value;
        this.app.updateInfo(this.info);
    }
}
