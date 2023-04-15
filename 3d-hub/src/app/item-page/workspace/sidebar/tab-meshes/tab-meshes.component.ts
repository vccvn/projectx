import { ChangeDetectorRef, Component, OnDestroy, OnInit } from '@angular/core';
import { ItemEventService } from '@app/item-page/_store/event.service';
import { ItemStorageService } from '@app/item-page/_store/storage.service';
import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { assignValue, assignWithout, copyWithout, isArray, isObject, Str } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ItemModel, ItemService } from '@app/_store/item';

@Component({
    selector: 'app-tab-meshes',
    templateUrl: './tab-meshes.component.html',
    styleUrls: ['./tab-meshes.component.scss']
})
export class TabMeshesComponent extends BaseComponent implements OnInit, OnDestroy {
    // item: ItemModel; // chứa item hiện tại
    // setting quan trong
    settings: any = {};
    settingOriginData: any = {};
    formGroups: any[] = [];


    isShow: boolean = true;
    app: ItemEditorService;

    modelDataSubcribe : (modelData) => any = modelData => this.updateAppData(modelData);
    modelSettingSubcribe: (settings) => any = settings => this.asyncSettings(settings);
    constructor(
        private storage: ItemStorageService,
        private itemService: ItemService,
        private events: ItemEventService,
        private cd : ChangeDetectorRef
    ) {
        super();
        this.setDefaultSettingData();
        
    }


    onChangeSubEvents(){
        this.app = this.subEvents.app as any;
        this.registerEventService(this.subEvents, {
            "panel.update:material": e => {
                this.reload(this.app.data.item.settings);
            },
            "panel.update:title": e => {
                this.reload(this.app.data.item.settings);
            },
            "panel.update:editable": e => {
                this.reload(this.app.data.item.settings);
            }
        })

    }

    initOnce(){
        
    }

    onInit(): void {
        this.storage.subcribe('modelData', this.modelDataSubcribe, true);
        this.storage.subcribe("modelSettings", this.modelSettingSubcribe, true);
        
        // this.state.onChange("item", data => this.updateItemData(data as ItemModel), true);
        
    }

    onDestroy() {
        this.storage.unsubcribe('modelData', this.modelDataSubcribe);
        this.storage.unsubcribe("modelSettings", this.modelSettingSubcribe);
        
    }

    reload(data){
        this.isShow = false;
        this.asyncSettings(data);
        setTimeout(() => {
            this.isShow = true;
            this.cd.detectChanges();
        }, 10);
    }

    setDefaultSettingData() {
        this.settings.options = {};
        this.settings.meshes = [];
    }



    // dong bo setting cua item voi tab
    asyncSettings(settings: any) {
        this.settingOriginData = settings;
        this.settings = settings;
        this.cd.detectChanges();
    }

    updateItemData(item: ItemModel) {
    }

    updateAppData(appDataObject: any): void {
        
    }

    updateProps(props) {
        assignValue(this.settings.props, props);
        this.app.updateSettings(this.settings, { props: true });
    }

    updateMesh(event) {
        if (isObject(event) && Object.prototype.hasOwnProperty.call(event, 'index')) {
            for (let i = 0; i < this.settings.meshes.length; i++) {
                const mesh = this.settings.meshes[i];
                let ref = mesh.__ref__;
                if (mesh.index == event.index) {
                    if (!isArray(ref.material)) {
                        if(!isObject(mesh.data.material)) mesh.data.material = {};
                        mesh.data.material[event.name] = event.value;
                    } else {
                        mesh.data.material = event.material;
                    }

                    const updateData: any = {};
                    updateData[event.name] = event.value;
                    this.app.updateMeshMaterial(mesh.name, updateData);
                }
            }
        }
    }

    updateEditable(event) {
        if (isObject(event) && Object.prototype.hasOwnProperty.call(event, 'index')) {
            for (let i = 0; i < this.settings.meshes.length; i++) {
                const mesh = this.settings.meshes[i];
                if (mesh.index == event.index) {
                    this.app.updateEditable(mesh.name, event.name, event.status);
                }
            }
        }
    }

    onUpdateTitle(event) {
        if (isObject(event) && Object.prototype.hasOwnProperty.call(event, 'index')) {
            if (typeof this.settings.meshes[event.index] != "undefined") {
                this.settings.meshes[event.index].title = event.title;

            }
            for (let i = 0; i < this.settings.meshes.length; i++) {
                const mesh = this.settings.meshes[i];
                if (mesh.index == event.index) {
                    this.app.updateMeshTitle(mesh.name, event.title);
                }
            }
        }
    }
}
