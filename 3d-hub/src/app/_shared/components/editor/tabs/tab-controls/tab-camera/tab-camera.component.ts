import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { TemplateEventsService } from '@app/template-page/_store/events.service';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { CameraDefaultSettings, CameraSetting } from '@app/_3D/store/data.type';
import { checkFacePos } from '@app/_3D/traits/camera';
import { assignValue, isObject } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { EditorToolbarService } from '@app/_shared/components/viewport/editor-toolbar/editor-toolbar.service';
import { InpEvent } from '@app/_shared/shared.type';

interface PosOpt {
    label: string,
    type: string,
    value: any,
    selected: boolean,
    [c: string]: any
}
type PosOpts = PosOpt[];


@Component({
    selector: 'app-tab-camera',
    templateUrl: './tab-camera.component.html',
    styleUrls: ['./tab-camera.component.scss']
})
export class TabCameraComponent extends BaseComponent implements OnInit {

    camera: CameraSetting = {};
    posOptions: PosOpts = [
        {
            label: "Mặc định",
            type: "default",
            value: null,
            selected: true
        },
        {
            label: "Vị trí theo các mặt",
            type: "face",
            value: "front",
            selected: false
        },
        {
            label: "Vị trí Tùy biến",
            type: "custom",
            value: {
                x: 0,
                y: 0,
                z: 2
            },
            selected: false
        }
    ];
    faceMatrix = [
        [null, 'Top', null, null],
        ['Left', 'Front', 'Right', 'Back'],
        [null, 'Bottom', null, null]
    ];

    app: AppEditorService = null;
    constructor(
        private cd: ChangeDetectorRef,
        private editorToolbar: EditorToolbarService,
        private events: AppEditorEventService
    ) {
        super();

        
    }
    onChangeSubEvents(){
        this.app = this.subEvents.app;
        // this.editorToolbar = this.editorToolbar.sub(this.moduleKey);
        this.registerEventService(this.editorToolbar, {
            "saveview": e => this.saveCurrentCameraPosition()
        });
        this.registerEventService(this.app, {
            "camera.position.save": e => {
                setTimeout(() => {
                    this.saveCurrentCameraPosition()
                }, 1);
            }
        });
    }
    onInit() {
        this.activeEventServiceRegistered(this.editorToolbar);
        this.activeEventServiceRegistered(this.app);

        let cam = this.app.engine.camera.position;
        assignValue(this.camera, CameraDefaultSettings);
        assignValue(this.camera, {
            settings: {
                position: {
                    costom: {
                        x: cam.x,
                        y: cam.y,
                        z: cam.z
                    }
                }
            }
        })
        assignValue(this.camera, this.app.getCameraSetting());
        this.initCamera();
        
        this.cd.detectChanges();
    }
    onDestroy(){
        
        this.deactiveEventServiceRegistered(this.editorToolbar);
        this.deactiveEventServiceRegistered(this.app);
    }
    


    initCamera() {
        if (isObject(this.camera.settings) && isObject(this.camera.settings.position)) {
            let cps = this.camera.settings.position;
            this.posOptions.map(opt => {
                opt.selected = opt.type == cps.type;
                opt.value = cps[opt.type];
            });

        }
    }
    emitUpdateSettings(updateEngine?: boolean) {
        this.app.updateCameraSetting({
            settings: this.camera.settings
        }, updateEngine);
    }
    updateCameraProperties(event: InpEvent) {
        let update: any = {}
        update[event.name] = event.value;
        this.camera[event.name] = event.value;

        this.app.updateCameraSetting(update);
    }
    changeFace(face: string) {
        let f = face.toLowerCase();
        if (checkFacePos(f)) {
            this.posOptions[0].value = f;
            this.camera.settings.position.face = f;
            this.emitUpdateSettings(true);
        }
    }
    isFaceActive(face: string) {
        return face.toLowerCase() == this.camera.settings.position.face;
    }
    changeType(type) {
        assignValue(this.camera.settings, {
            position: {
                type
            }
        });
        this.posOptions.map(opt => opt.selected = opt.type == type);
        this.emitUpdateSettings(true);
    }
    updateCustomPos(event) {
        assignValue(this.camera.settings.position.custom, event.value);
        this.emitUpdateSettings(true);
    }

    saveCurrentCameraPosition() {
        let cam = this.app.engine.camera.position;
        assignValue(this.camera.settings, {
            position: {
                type: "custom",
                costom: {
                    x: cam.x,
                    y: cam.y,
                    z: cam.z
                }
            }
        });
        this.posOptions.map(opt => {
            opt.selected = opt.type == 'custom';
            if (opt.selected) {
                assignValue(opt.value, {
                    x: cam.x,
                    y: cam.y,
                    z: cam.z
                });
            }
        });
        this.emitUpdateSettings(false);
        this.cd.detectChanges();
    }

}
