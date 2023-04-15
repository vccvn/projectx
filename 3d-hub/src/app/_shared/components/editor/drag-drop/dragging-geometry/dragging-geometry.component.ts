import { Component, ElementRef, Input, OnDestroy, OnInit } from '@angular/core';
import { Geometries, TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { Vector2 } from '@app/_3D/store/data.type';
import { assignValue, isEmpty } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';

interface mousePosition {
    x: number,
    y: number
}

const THUMBNAIL_ASSDT_URL = '/assets/icons/geometries/';

@Component({
    selector: 'dragging-geometry',
    templateUrl: './dragging-geometry.component.html',
    styleUrls: ['./dragging-geometry.component.scss']
})
export class DraggingGeometryComponent extends BaseComponent implements OnInit, OnDestroy {
    show: boolean = false;
    droppable: boolean = false;
    isDragging: boolean = false;
    thumbnail: string = TransparentBase64Image;

    pointer: mousePosition = {
        x: 0,
        y: 0
    }; 
    viewportBounding: any = {
        left:0,
        top:0,
        width: 0,
        height: 0
    };
    currentPos: Vector2 = {
        x: 0,
        y: 0
    };

    geometryType: string = '';

    draggingStyle: string = '';

    previewSecretKey: string = '';


    previewObject: any = null;
    constructor(
        private elemRef: ElementRef,
        private events: AppEditorEventService
        
    ) { 
        super();
    }

    initEvents(){
        this.registerEventService(this.subEvents, {
            'geometry.dragstart': e => {
                this.dragStart(e.geometryType);
                this.updatePoistion(e);
            },
            'pointerup': e => {
                if (this.isDragging) {
                    e.preventDefault();
                    this.dragEnd(e);
                }
            },
            'pointermove': e => {
                if (this.isDragging) {
                    this.onMove(e);
                }
            },
            'geometry.draghover': e => {
                if (this.isDragging) {
                    if(!this.droppable){
                        this.droppable = true;
                        this.createGeometryPreview();
                    }
                }
            },
            'geometry.dragout': e => {
                if(this.droppable){
                    this.removeGeometryPreview();
                }
                this.droppable = false;
    
            }
        });
    }
    init(): void{
        if(this.isChangeSubEvents){
            this.initEvents();
        }
        this.activeEventServiceRegistered(this.subEvents);
    }
    onDestroy(){
        this.deactiveEventServiceRegistered(this.subEvents);
    }

    dragStart(geometryType) {
        this.geometryType = geometryType;
        this.thumbnail = THUMBNAIL_ASSDT_URL + geometryType + ".svg";
        this.isDragging = true;
    }

    
    onMove(event) {
        this.updatePoistion(event, true);
        this.subEvents.emit({
            type: "geometry.dragmove",
            clientX: event.clientX,
            clientY: event.clientY,
            checkArea: this.droppable,
            position: this.currentPos
        }, false);

    }


    dragEnd(e) {
        if (this.isDragging) {
            e.preventDefault();

            if (!this.droppable) {

                this.hideDraggingIten();
            }else{
                this.dropGeometry();
                

            }
        }
    }

    hideDraggingIten(){
        this.isDragging = false;
        this.draggingStyle = '';
        this.droppable = false;
        this.previewSecretKey = "";
    }

    dropGeometry(){
        const app = this.subEvents.app;
        if(app.addItemMode == "lock"){
            app.deleteMesh(this.previewSecretKey);
        }else{
            app.updateMeshSettingDataAndScene(this.previewSecretKey, {
                material: {
                    transparent: false,
                    opacity: 1
                },
                props:{
                    position:{
                        y: this.previewObject.position.y
                    }
                }
            }, true);

            const meshEngineData = app.getMeshEngineData(this.previewSecretKey).object;
            const meshSettingData = app.getMesh(this.previewSecretKey).data;
            
            this.subEvents.emit({
                type: "geometry.added",
                data: {
                    mesh: meshEngineData,
                    data: meshSettingData,
                    secret_key:  this.previewSecretKey
                }
            }, false);
            this.subEvents.emit({
                type: "droppable.areas.remove"
            });
        }

        this.previewObject = null;
        this.hideDraggingIten();
    }

    updatePoistion(event, fixSize?:boolean) {
        
        this.currentPos.x = event.clientX;
        this.currentPos.y = event.clientY;
            
        var itemElement = this.elemRef.nativeElement.querySelector('.mesh-geometry-handling');
        if (itemElement) {
            var width = 100, height = 100;
            if(fixSize){
                var rect = itemElement.getBoundingClientRect();
                width = rect.width; 
                height = rect.height;
            }

            this.pointer.x = event.clientX - width / 2;
            this.pointer.y = event.clientY - height / 2;
            if (this.droppable) {
                this.pointer.x = event.clientX + width * 0.5;
                this.pointer.y = event.clientY - height * 1.5;

            }
            this.draggingStyle = `left: ${this.pointer.x}px; top: ${this.pointer.y}px;`;

        }
    }

    createGeometryPreview(){
        const config = Geometries.getConfig(this.geometryType);
        if(!isEmpty(config)){
            var self = this;
            this.subEvents.app.addMesh({
                geometry: assignValue({type:this.geometryType}, config.data.params),
                material: {
                    type: "physical",
                    color: "#9ad9f3",
                    transparent: true,
                    opacity: 0.4
                },
                props: {
                    castShadow: true
                }
            }, (object:any) => {
                let eo = this.subEvents.app.engine.getObject(object.secret_key);
                let io : any = {
                    size: eo.size.origin,
                    object: eo.object
                };
                this.previewObject = io.object;
                this.subEvents.app.editor.detachObject();
                this.subEvents.emit({
                    type: "droppable.areas.add",
                    item: io,
                    position: this.currentPos
                });
                self.previewSecretKey = object.secret_key;

            });
            
        }
    }
    removeGeometryPreview(){
        this.subEvents.emit({
            type: "droppable.areas.remove"
        });
        this.subEvents.emit({
            type: "engine.geometry.remove",
            secret_key: this.previewSecretKey
        }, false);
    }
}
