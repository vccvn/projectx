import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { BackgroundSetting } from '@app/_3D/store/data.type';
import { assignValue, inArray } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { EditorIO, EditorMethods } from '../../../base/editor-io';


interface BgOption{
    type: string,
    label: string,
    value?: any,
    selected: boolean
}

type BgOptions = Array<BgOption>;


@Component({
    selector: 'app-tab-background',
    templateUrl: './tab-background.component.html',
    styleUrls: ['./tab-background.component.scss']
})
export class TabBackgroundComponent extends BaseComponent implements OnInit {


    background: BackgroundSetting = {
        type: "none"
    };

    bgOptions: BgOptions = [
        {
            type: "none",
            label: "Không có hình nền",
            selected: true
        },
        {
            type: "color",
            label: "Màu sắc",
            value: "#000",
            selected: false
        },
        {
            type: "texture",
            label: "Hình Nền",
            value: null,
            selected: false
        }

    ];

    appEvent = {
        
    }

    constructor(
        private events: AppEditorEventService,
        private cd: ChangeDetectorRef
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
        this.setBackground(this.app.getBackgroundSetting());
    
        this.cd.detectChanges();
    }
    onDestroy(){
        
    }

    setBackground(background:BackgroundSetting){
        assignValue(this.background, background);
        this.bgOptions.map(opt => {
            opt.selected = opt.type == this.background.type;
            if(typeof this.background[opt.type]!="undefined"){
                opt.value = this.background[opt.type];
            }
        });
    }

    changeType(type: string){
        if(inArray(['none', 'color', 'texture'], type) && this.background.type != type){
            this.background.type = type;
            this.bgOptions.map(opt => {
                opt.selected = opt.type == type;
            });
            this.updateBackground();

        }
    }

    updateColor(event){
        this.background.color = event.value;
        this.bgOptions.map(opt => {
            if(opt.type=="color"){
                opt.value = event.value;
            }
        });
        
        this.updateBackground();
    }

    updateTexture(event){
        if(event.file && (event.file.extension == "hdr" || event.file.format == "hdr")){
            
            this.background.texture = {
                file: event.file.source,
                format: "hdr"
            }
        }else{
            this.background.texture = {
                file: event.value,
                format: "jpg"
            }
        }
        this.bgOptions.map(opt => {
            if(opt.type=="texture"){
                opt.value = this.background.texture;
            }
        });
        this.updateBackground();
        this.emitRefresh();
    }

    updateBackground(){
        if(this.app){
            this.app.updateBackgroundData(this.background);
        }

     
    }

    emitRefresh(){
        setTimeout(() => {
            this.subEvents.emit("tab.scene.refresh");
        }, 200);
    }
}
