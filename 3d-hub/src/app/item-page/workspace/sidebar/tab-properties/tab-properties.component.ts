import { AfterViewInit, ChangeDetectorRef, Component, OnDestroy, OnInit } from '@angular/core';
import { ItemStorageService } from '@app/item-page/_store/storage.service';
import { ItemEditorService } from '@app/_3D/services/item-editor.service';
import { assignValue, assignWithout } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ItemService } from '@app/_store/item';
import {EventManagerService} from '@app/_core/services/event-manager.service';
@Component({
    selector: 'app-tab-properties',
    templateUrl: './tab-properties.component.html',
    styleUrls: ['./tab-properties.component.scss']
})
export class TabPropertiesComponent extends BaseComponent implements OnInit, OnDestroy {
    // item: ItemModel; // chứa item hiện tại
    // setting quan trong
    settings: any = {};
    settingOriginData: any = {};

    index: number = 0;

    constructor(
        private storage: ItemStorageService,
        private app: ItemEditorService,
        private itemService: ItemService,
        private cd: ChangeDetectorRef,
        private events: EventManagerService
    ) {
        super();
        this.setDefaultSettingData();
        // this.state.onChange("item", data => this.updateItemData(data as ItemModel), true);
        this.storage.subcribe("modelSettings", settings => this.asyncSettings(settings), true);
        
    }

    onInit(): void {

    }

    onDestroy() {

    }

    // afterViewInit(){
    //     this.viewInited = true;
    // }

    

    setDefaultSettingData() {
        this.settings.props = {
            castShadow: false,
            receiveShadow: false,
            rotation: { x: 0, y: 0, z: 0 },
            scale: { x: 1, y: 1, z: 1 },
        };
    }



    // dong bo setting cua item voi tab
    asyncSettings(settings: any) {
        this.settingOriginData = settings;
        assignWithout(this.settings, settings, ['meshes']);
        this.doAfterViewInit(()=>{
            this.events.emit({
                type: "object.props.change",
                props: this.settings.props
            })
            this.cd.detectChanges();
            this.refresh(200);
        }, 50);
    }

    updateProps(props) {
        assignValue(this.settings.props, props);
        this.app.updateSettings(this.settings, { props: true });

    }

}
