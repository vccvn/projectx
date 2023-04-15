import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { LoaderLib, TransparentBase64Image } from '@app/_3D/libs/three.libs';
import Object2Image from '@app/_3D/modules/object-image';
import { App3DService } from '@app/_3D/services/app-3d.service';
import { assignValue, inArray, isArray, isObject } from '@app/_core/helpers/utils';
import { ImageModel, ImageService, imgListTypes } from '@app/_store/images';
import { BaseComponent } from '../../base/base.component';
import { ImageLibraryService, ApiParams } from './image-library.service';

@Component({
    selector: 'modal-image-library',
    templateUrl: './image-library.component.html',
    styleUrls: ['./image-library.component.scss']
})
export class ImageLibraryComponent extends BaseComponent implements OnInit {

    @Input() app: App3DService;
    title: string = "Image Library";
    oldTitle: string = "Image Library";
    
    url: string = '';
    params: ApiParams = {};
    lastUrl: string = '';
    lastParams: ApiParams = {};
    

    mode = 'single';

    results: any;

    images: any[] = [];


    isVisible = false;
    isConfirmLoading = false;

    onDone: (...args:any[]) => any = null;

    onCancel: (...args:any[]) => any = null;

    listType:string = "list";
    oldListType: string = "list";




    constructor(
        private events: ImageLibraryService,
        private imageService: ImageService,
        private cd: ChangeDetectorRef
    ) {
        super();
        this.registerEventService(events, {
            open: e => this.show(e.config, e.callback, e.cancel)
        });
    }
    

    onInit() {
        this.activeEventServiceRegistered(this.events);
    }
    onDestroy(){
        this.deactiveEventServiceRegistered(this.events);
    }

    show(config, callback?:any, cancel?:any) {
        this.onDone = null;
        this.onCancel = null;
        if (isObject(config)) {
            if(config.title) this.title = config.title;
            if(config.url) this.url = config.url;
            if(config.mode && inArray(['single', 'simple', 'many', 'one'], String(config.mode).toLowerCase())) this.mode = config.mode;
            if(isObject(config.params)) assignValue(this.params, config.params);
            if(config.listType && inArray(imgListTypes, config.listType)){
                this.listType = config.listType;
            }else{
                this.listType = "list";
            }
            if(typeof callback == "function"){
                this.onDone = callback;
            }
            else if(typeof config.done == "function"){
                this.onDone = config.done;
            }
            if(typeof cancel == "function"){
                this.onCancel = cancel;
            }
            
            else if(typeof config.cancel == "function"){
                this.onCancel = config.cancel;
            }

        }
        this.showModal();
    }

    showModal(): void {
        this.isVisible = true;
        if(this.images.length == 0){
            this.firstLoad();
        }else if(this.listType != this.oldListType){
            this.images = [];
            this.firstLoad();
        }
    }


    firstLoad(){
        this.imageService.getImages(this.listType,this.params).subscribe(res => {
            if(res.status){
                if(res.data && res.data.length){
                    this.appendImageFiles(res.data);
                }
            }
        })
    }

    appendImageFiles(images:ImageModel[]){
        images.map((image) => {
            image.selected = false;
            this.images.push(image);
            if(image.extension == "hdr"){
                this.proccessHDRThumbnail(image);
            }
        });
    }

    proccessHDRThumbnail(image: ImageModel){
        image.thumbnail = TransparentBase64Image;
        if(this.app){
            this.app.engine.Loader.LoadEnv({
                format: "hdr",
                file: image.source || image.url || image.file
            }, function (envMap, texture) {
                var src = Object2Image.get2DMap(texture, 240, 120);
                if(src){
                    image.thumbnail = src;
                }
            });
        }
    }

    selectImage(id:any){

        if(this.mode != "many"){
            this.images.map((image, index, array) => {
                image.selected = image.id == id;
            })
        }

        // this.handleOk();
    }

    handleOk(): void {
        let result = null;
        if(this.mode != "many"){
            this.images.map((image, index, array) => {
                if(image.selected) {
                    result = image;
                    image.selected = false;
                }
            });
            if(!result) return window.alert("Vui lòng chọn ảnh");
            
        }else{
            result = [];
            this.images.map((image, index, array) => {
                if(image.selected) {
                    result.push(image);
                    image.selected = false;
                }
            });
            if(!result.length) return window.alert("Vui lòng chọn ảnh");
            
        }


        this.isConfirmLoading = true;
        setTimeout(() => {
            if(typeof this.onDone == "function"){
                this.onDone(result);
            }

            this.isVisible = false;
            this.oldListType = this.listType;
            this.isConfirmLoading = false;
        }, 1000);
    }

    handleCancel(): void {
        this.isVisible = false;
        this.oldListType = this.listType;
        if(typeof this.onCancel == "function"){
            this.onCancel();
        }
    }

}
