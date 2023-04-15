import { AfterViewInit, Component, ElementRef, Input, OnInit } from '@angular/core';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { AppEditorService } from '@app/_3D/services/app-editor.service';
import { Vector3 } from '@app/_3D/store/data.type';
import { assignValue, Str } from '@app/_core/helpers/utils';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { ViewportService } from '@app/_shared/components/viewport/viewport.service';
import { ModalConfirmService } from '@app/_shared/services/modal-confirm.service';
// import { Div, Img } from '@app/_core/helpers/html-elements';
import { ItemModel } from '@app/_store/item';

interface mousePosition {
    x: number,
    y: number
}

@Component({
    selector: 'dragging-item',
    templateUrl: './dragging-item.component.html',
    styleUrls: ['./dragging-item.component.scss']
})
export class DraggingItemComponent extends BaseComponent implements OnInit, AfterViewInit {

    item: ItemModel = {
        name: "No Name",
        id: 0,
        thumbnail: TransparentBase64Image
    };
    canMove: boolean = true;
    dragingItem: any;
    show: boolean = false;
    dragElement: HTMLElement;
    draggingStyle: string = '';
    isDragging: boolean = false;
    droppable: boolean = false;
    isLoading: boolean = false;
    cssEffect: boolean = false;
    pointer: mousePosition = {
        x: 0,
        y: 0
    };
    mousePosition: mousePosition = {
        x: 0,
        y: 0
    };

    viewportPointerPosition: mousePosition = {
        x: 0,
        y: 0
    }

    viewportBounding: any = {
        left: 0,
        top: 0,
        width: 0,
        height: 0
    };


    size = {
        width: 100,
        height: 100
    }
    constructor(
        private elemRef: ElementRef,
        private cfm: ModalConfirmService,
        private events: AppEditorEventService,
        private viewport: ViewportService
    ) {
        super();

    }

    initEvents() {
        this.registerEventService(this.subEvents, {
            'item.dragstart': e => {
                if (this.isLoading) return false;
                this.dragStart(e.data);
                this.updateDropElem(e);
            },

            'item.dropcenter': e => {
                if (this.isLoading) return false;
                if (this.isDragging) {
                    // e.preventDefault();
                    this.dropCenter();
                }
            },
            'pointerup': e => {
                if (this.isLoading) return false;
                if (this.isDragging) {
                    e.preventDefault();
                    this.dragEnd(e);
                }
            },

            'pointermove': e => {
                if (this.isLoading) return false;
                if (this.isDragging) {
                    this.onMove(e);
                }
            },

            'item.draghover': e => {
                if (this.isLoading || !this.isDragging) return false;

                // nếu dang kéo
                this.viewportBounding = e.pos.rect;
                if (!this.droppable) {
                    this.updateViewportPointerPosition();
                    // nếu chưa cho thả thì thêm vùng thả
                    this.subEvents.emit({
                        type: "droppable.areas.add",
                        item: this.item,
                        position: this.mousePosition
                    });
                }
                this.droppable = true;
            },
            'item.dragout': e => {
                // if(this.isLoading) return false;
                this.droppable = false;
                this.subEvents.emit({
                    type: "droppable.areas.remove"
                });
            }

        });
    }
    onInit() {
        if (this.isChangeSubEvents) {
            this.initEvents();
        }
        this.activeEventServiceRegistered(this.subEvents);
    }
    onDestroy() {
        this.deactiveEventServiceRegistered(this.subEvents);
    }

    ngAfterViewInit(): void {
        this.dragElement = this.elemRef.nativeElement.querySelector('.model-item');
    }

    dragStart(item) {
        this.item = item;
        this.isDragging = true;
    }


    onMove(event) {
        if (!this.canMove) return false;
        this.updatePoistion(event);
        this.mousePosition.x = event.clientX;
        this.mousePosition.y = event.clientY;

        if (this.droppable) {
            this.updateViewportPointerPosition();

        }
        this.subEvents.emit({
            type: "item.dragmove",
            clientX: event.clientX,
            clientY: event.clientY,
            checkArea: this.droppable,
            position: this.mousePosition
        });

    }


    dragEnd(e) {
        if (this.isDragging) {
            e.preventDefault();
            if (!this.droppable) {

                this.hideDraggingIten();
            } else {
                this.dropItem();


            }
        }
    }

    hideDraggingIten() {
        this.isDragging = false;
        this.item = {
            name: "No Name",
            id: 0,
            thumbnail: TransparentBase64Image
        };
        this.cssEffect = false;
        this.draggingStyle = '';
        this.droppable = false;
        this.isLoading = false;
        this.canMove = true;
    }

    addMode: string = "auto";
    addPosition: Vector3 = {
        x: 0,
        y: 0,
        z: 0
    }

    dropItem() {
        this.canMove = false;
        let app = this.subEvents.app;
        this.addMode = app.addItemMode;
        assignValue(this.addPosition, app.addItemPosition);
        this.subEvents.emit({
            type: "droppable.areas.remove"
        });
        if (app.addItemMode == "auto") {
            if (app.data.scene.size.width < this.item.size.x || app.data.scene.size.depth < this.item.size.z || app.data.scene.size.height < this.item.size.y) {
                this.subEvents.emit({
                    type: "modelitem.drop.confirm",
                    data: {
                        mode: this.addMode,
                        position: assignValue({}, this.addPosition),
                        item: assignValue({}, this.item)
                    }
                });
                this.hideDraggingIten();
                return false;

            } else {
                this.dropItemAnimate();
            }
            
        }
        else if (app.addItemMode == "lock") {
            this.hideDraggingIten();
        }
        else if (app.addItemMode == "custom") {
            this.dropItemAnimate();
        }


    }



    dropCenter() {
        this.canMove = false;
        let app = this.subEvents.app;
        this.addMode = app.addItemMode;
        app.addItemMode = "auto";
        this.addMode = "custom";
        assignValue(this.addPosition, {
            x: 0,
            y: app.data.scene.floor.props.position.y + this.item.size.y / 2,
            z: 0
        });

        this.subEvents.emit({
            type: "droppable.areas.remove"
        });
        if (app.addItemMode == "auto") {
            if (app.data.scene.size.width < this.item.size.x || app.data.scene.size.depth < this.item.size.z || app.data.scene.size.height < this.item.size.y) {
                this.subEvents.emit({
                    type: "modelitem.drop.confirm",
                    data: {
                        mode: this.addMode,
                        position: assignValue({}, this.addPosition),
                        item: assignValue({}, this.item)
                    }
                });
                this.hideDraggingIten();
                return false;

            } else {
                this.subEvents.emit('app.loading.show');
                this.addModelTiem();
                this.cssEffect = false;
                this.draggingStyle = '';
            }
        }
        else if (app.addItemMode == "lock") {
            this.hideDraggingIten();
        }
        else if (app.addItemMode == "custom") {
            this.subEvents.emit('app.loading.show');
            this.addModelTiem();
            this.cssEffect = false;
            this.draggingStyle = '';
        }

        

    }


    dropItemAnimate() {
        if (this.viewportBounding && this.viewportBounding.width) {
            this.isLoading = true;
            var t = this.draggingStyle;

            var size = `height: ${this.size.height}px; width: ${this.size.width}px; `;
            this.draggingStyle = size + this.draggingStyle;
            this.cssEffect = true;
            var left = this.viewportBounding.left + this.viewportBounding.width / 2;
            var top = this.viewportBounding.top + this.viewportBounding.height / 2;
            setTimeout(() => {
                this.draggingStyle = Str.replace(this.draggingStyle, [t, size], [`left: ${left}px; top: ${top}px; `, 'width:0; height:0;']);
                setTimeout(() => {
                    this.subEvents.emit('app.loading.show');
                    this.addModelTiem();
                    this.cssEffect = false;
                    setTimeout(() => {
                        this.draggingStyle = '';
                    }, 20);
                }, 320);
            }, 50);
        } else {
            this.hideDraggingIten();
            this.subEvents.emit('app.loading.hide');
        }
    }

    addModelTiem() {
        var self = this;
        let app: AppEditorService = this.subEvents.app;
        console.log(this.addPosition)
        this.subEvents.emit({
            type: 'item.dropped',
            item: this.item,
            success: function (data) {
                self.subEvents.emit('app.loading.hide');
                if (self.addMode == "custom") {
                    var size = data.data.size;
                    if (app.data.scene.floor.above) {
                        self.addPosition.y = app.data.scene.floor.props.position.y + size.y / 2;
                    } else {
                        self.addPosition.y = size.y / 2;
                    }
                    app.updateObjectSettingDataAndScene(data.secret_key, {
                        props: {
                            position: self.addPosition
                        }
                    }, { props: true })
                    console.log(self.addPosition)
                }
                self.hideDraggingIten();
                
            }
        })
    }

    updateDropElem(event) {
        if (this.isLoading) return false;
        var itemElement = this.elemRef.nativeElement.querySelector('.model-item');
        if (itemElement) {
            var rect = itemElement.getBoundingClientRect();
            var width = rect.width, height = rect.height;

            if (Object.prototype.hasOwnProperty.call(event, 'width') && Object.prototype.hasOwnProperty.call(event, 'height')) {
                width = event.width;
                height = event.height;
            }
            this.pointer.x = event.clientX - width / 2;
            this.pointer.y = event.clientY - height / 2;
            if (this.droppable) {
                this.pointer.x = event.clientX + width * 0.5;
                this.pointer.y = event.clientY - height * 1.5;

            }

            this.draggingStyle = `left: -100px; top: -100px;`;

        }
    }

    updatePoistion(event) {
        if (this.isLoading) return false;
        var itemElement = this.elemRef.nativeElement.querySelector('.model-item');
        if (itemElement) {
            var rect = itemElement.getBoundingClientRect();
            var width = rect.width, height = rect.height;

            if (event.type == 'item.dragstart' && Object.prototype.hasOwnProperty.call(event, 'width') && Object.prototype.hasOwnProperty.call(event, 'height')) {
                width = event.width;
                height = event.height;
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

    updateViewportPointerPosition() {
        this.viewportPointerPosition.x = ((this.mousePosition.x - this.viewportBounding.left) / this.viewportBounding.width) * 2 - 1;
        this.viewportPointerPosition.y = ((this.mousePosition.y - this.viewportBounding.top) / this.viewportBounding.height) * 2 + 1;

    }
}
