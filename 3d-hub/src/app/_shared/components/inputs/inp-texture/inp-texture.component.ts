import { ChangeDetectorRef, Component, ElementRef, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseInputComponent } from '../base-input/base-input.component';
import { LoaderLib, TransparentBase64Image } from '@app/_3D/libs/three.libs';
import { ImageLibraryService } from '../../modals/image-library/image-library.service';
import { isObject, isString, resizeImage } from '@app/_core/helpers/utils';
import Object2Image from '@app/_3D/modules/object-image';

@Component({
    selector: 'inp-texture',
    templateUrl: './inp-texture.component.html',
    styleUrls: ['./inp-texture.component.scss']
})
export class InpTextureComponent extends BaseInputComponent implements OnInit {
    outputImage = TransparentBase64Image;
    @Input() listType: string = "list";
    @Output() modalCancelSelect = new EventEmitter<any>();
    @Output() onCloseLibrary = new EventEmitter<any>();
    constructor(private libraryService: ImageLibraryService, private cd: ChangeDetectorRef) {
        super();
    }

    ngOnInit(): void {
        if (this.value) {
            this.image = this.value;

        }
    }

    set image(value) {
        if (isString(value)) this.outputImage = value;
        else if (isObject(value)) {
            var map = value;
            if (map.image) {
                var image = Object2Image.get2DMap(map, 100, 100);
                if (image) {
                    this.outputImage = image;
                }
            } else {
                var self = this;
                // var value = map;
                if (value != null && isObject(value) && value.file) {
                    var p = '';
                    if (value.path) {
                        if (value.substr(value.path.length - 1, 1) == '/') {
                            p = value.path;
                        }
                        else {
                            p = value.path + '/';
                        }
                        if (value.file.substr(0, 1) == '/') {
                            p += value.file.substr(1);
                        } else {
                            p += value.file;
                        }
                    } else {
                        p = value.file;
                    }
                    if(value.format != "hdr" && value.extension != "hdr"){
                        resizeImage(p, 60, 60, function (thumbnail) {
                            // mapImage.attr('src', thumbnail);
                            self.outputImage = thumbnail;
                        });
                    }else{
                        LoaderLib.LoadEnv({
                            format: "hdr",
                            file: p
                        },  (envMap, texture) => {
                            var src = Object2Image.get2DMap(texture, 240, 120);
                            if(src){
                                this.outputImage = src;
                                this.cd.detectChanges();

                            }
                        });

                    }
                }
            }

        }
    }
    chooseTexture() {
        this.libraryService.open(
            {
                title: this.name,
                mode: "simple",
                listType: this.listType
            }, 
            image => {
                this.onSelectImage(image);
                this.onCloseLibrary.emit(true);
            }, 
            () => {
                this.modalCancelSelect.emit(true);
                this.onCloseLibrary.emit(true);
            }
        );
    }

    onSelectImage(image) {
        this.outputImage = image.thumbnail;
        this.value = image.source;

        this.subcribe.emit({
            name: this.name,
            value: this.value,
            old: this.old,
            file: image
        });
        this.old = this.value;
        if(image.extension == "hdr"){
            this.image = {
                file: image.source,
                format: 'hdr'
            }
        }
        
    }



}
