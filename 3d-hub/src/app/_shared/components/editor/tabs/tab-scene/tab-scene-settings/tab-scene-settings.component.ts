import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { FloorDefaultData, FloorSetting, SceneSize, SceneSizeDefaultData } from '@app/_3D/store/data.type';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ImageLibraryService } from '@app/_shared/components/modals/image-library/image-library.service';
import { ModalConfirmService } from '@app/_shared/services/modal-confirm.service';

@Component({
    selector: 'app-tab-scene-settings',
    templateUrl: './tab-scene-settings.component.html',
    styleUrls: ['./tab-scene-settings.component.scss']
})
export class TabSceneSettingsComponent extends BaseComponent implements OnInit {
    sceneSize: SceneSize = assignValue({}, SceneSizeDefaultData);
    floor: FloorSetting = assignValue({}, FloorDefaultData);
    app: AppEditorService
    constructor(
        private cd: ChangeDetectorRef,
        private library: ImageLibraryService,
        private cfm: ModalConfirmService,
        private events: AppEditorEventService
    ) {
        super();
    }

    initOnce(){
        this.app = this.events.app;
     
    }
    init() {
        if(this.isChangeSubEvents){
            this.app = this.subEvents.app;
        }
        this.subEvents.on("scene.update-size", e => {
            this.initSize();
            this.initFloor();
            this.cd.detectChanges();
        })
        this.initSize();
        this.initFloor();
        
    }
    destroy(){
        
    }
    initSize() {
        assignValue(this.sceneSize, this.app.getSceneSizeSetting());
    }

    onTextureCancel() {
        this.cd.detectChanges();
        setTimeout(() => {
            this.app.events.emit("tab.scene.refresh");
        }, 200);
    }
    updateSize(event) {
        this.sceneSize[event.name] = event.value;
        this.app.updateSceneSizeSetting(this.sceneSize);
    }

    initFloor() {
        assignValue(this.floor, this.app.getFloorSetting());
    }
    updateFloor(event) {
        this.floor[event.name] = event.value;
        setTimeout(() => {
            this.app.updateSceneFloorSetting(this.floor);    
        }, 10);
        
    }
    updateFloorParams(event) {
        this.floor.params[event.name] = event.value;
        this.app.updateSceneFloorSetting(this.floor);
    }
    updateFloorProps(event) {
        this.floor.props[event.name] = event.value;
        this.app.updateSceneFloorSetting(this.floor);
    }


    updateFloorPosition(event) {
        this.floor.props.position[event.name] = event.value;
        this.app.updateSceneFloorSetting(this.floor);
    }

    updateFloorMaterial(event) {
        this.floor.material[event.name] = event.value;
        this.app.updateSceneFloorSetting(this.floor);
    }

}
