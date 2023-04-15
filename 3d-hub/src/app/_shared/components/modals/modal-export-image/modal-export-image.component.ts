import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { App3DService } from '@app/_3D/services/app-3d.service';
import { assignValue, inArray, isObject } from '@app/_core/helpers/utils';
import { BaseComponent } from '../../base/base.component';

@Component({
    selector: 'app-modal-export-image',
    templateUrl: './modal-export-image.component.html',
    styleUrls: ['./modal-export-image.component.scss']
})
export class ModalExportImageComponent extends BaseComponent implements OnInit {

    @Input() app: App3DService;
    title: string = "Image Library";
    oldTitle: string = "Image Library";

    isVisible = false;
    isConfirmLoading = false;

    containerStyle: string = '';
    onDone: (...args: any[]) => any = null;

    onCancel: (...args: any[]) => any = null;

    listType: string = "list";
    oldListType: string = "list";




    constructor(
        private cd: ChangeDetectorRef
    ) {
        super();
        // this.registerEventService(events, {
        //     open: e => this.show(e.config, e.callback, e.cancel)
        // });
    }


    onInit() {
        this.activeEventServiceRegistered(this.events);
    }
    onDestroy() {
        this.deactiveEventServiceRegistered(this.events);
    }

    show(config, callback?: any, cancel?: any) {
        this.onDone = null;
        this.onCancel = null;
        if (isObject(config)) {
            if (config.title) this.title = config.title;
            if (isObject(config.params)) assignValue(this.params, config.params);

            if (typeof callback == "function") {
                this.onDone = callback;
            }
            else if (typeof config.done == "function") {
                this.onDone = config.done;
            }
            if (typeof cancel == "function") {
                this.onCancel = cancel;
            }

            else if (typeof config.cancel == "function") {
                this.onCancel = config.cancel;
            }

        }
        this.showModal();
    }

    showModal(): void {
        this.isVisible = true;
        if (this.images.length == 0) {
            this.firstLoad();
        } else if (this.listType != this.oldListType) {
            this.images = [];
            this.firstLoad();
        }
    }



    handleOk(): void {
        let result = null;
        if (this.mode != "many") {
            this.images.map((image, index, array) => {
                if (image.selected) {
                    result = image;
                    image.selected = false;
                }
            });
            if (!result) return window.alert("Vui lòng chọn ảnh");

        } else {
            result = [];
            this.images.map((image, index, array) => {
                if (image.selected) {
                    result.push(image);
                    image.selected = false;
                }
            });
            if (!result.length) return window.alert("Vui lòng chọn ảnh");

        }


        this.isConfirmLoading = true;
        setTimeout(() => {
            if (typeof this.onDone == "function") {
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
        if (typeof this.onCancel == "function") {
            this.onCancel();
        }
    }

}
