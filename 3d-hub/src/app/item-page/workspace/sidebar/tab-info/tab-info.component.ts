import { Component, Output, EventEmitter, OnDestroy, OnInit, ChangeDetectorRef } from '@angular/core';
import { PriVacyStatusOptions } from '@app/_store/form';


import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ItemStorageService } from '@app/item-page/_store/storage.service';
import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { ItemModel, ItemService } from '@app/_store/item';
import { CategoryModel, CategoryService } from '@app/_store/category';
import { copyByList } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';

@Component({
    selector: 'app-tab-info',
    templateUrl: './tab-info.component.html',
    styleUrls: ['./tab-info.component.scss'],
})
export class TabInfoComponent extends BaseComponent implements OnInit, OnDestroy {
    item: ItemModel; // chứa item hiện tại
    categories: CategoryModel[];
    asyncForm: boolean = true;
    mode: string = 'create';
    categoryOptions: Array<{label:string, value: any}> = [];

    privacyStatusOptions: any = PriVacyStatusOptions.map(stt => ({label:stt.label, value:stt.value}))
    constructor(
        private storage: ItemStorageService,
        private itemService: ItemService,
        private categoryService: CategoryService,
        private itemEditor: ItemEditorService,
        private cd: ChangeDetectorRef
    ) {
        super();
        
    }

    initFirst(){
        this.storage.subcribe("item", data => {
            this.updateItemData(data as ItemModel);
            this.cd.detectChanges();
        }, true);

        this.storage.subcribe('categories', categories => {
            this.updateCategories(categories);
            this.cd.detectChanges();
        }, true);

        this.storage.onChange('editorMode', mode => {
            this.mode = mode;
            this.cd.detectChanges();
        }, true);
        this.isInited = true;
        return true;
    }

    onDestroy(){

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

    updateItemData(item: ItemModel) {
        this.item = item;
        this.asyncForm = true;
    }

    onInpChange(event){
        let update : any = {};
        update[event.name] = event.value;
        let d = copyByList(this.item, )
        this.itemEditor.updateInfo(update);
    }


}
