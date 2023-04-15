import { AfterViewInit, Component, ElementRef, OnInit } from '@angular/core';
import { BaseInputComponent } from '../base-input/base-input.component';
import Picker from 'vanilla-picker';
import { isObject } from '@app/_core/helpers/utils';
import { TransparentBase64Image } from '@app/_3D/libs/three.libs';
@Component({
    selector: 'inp-color',
    templateUrl: './inp-color.component.html',
    styleUrls: ['./inp-color.component.scss']
})
export class InpColorComponent extends BaseInputComponent implements OnInit, AfterViewInit {
    transparentBase64Image = TransparentBase64Image;
    constructor(private elemRef: ElementRef) {
        super();
    }

    ngOnInit(): void {
    }

    ngAfterViewInit(): void {
        this.value = this.value && isObject(this.value) ?(
            this.value.isColor ? "#" + this.value.getHexString(): (
                this.value.$three=="color"?this.value.color:"#000"
            )
        ) : this.value as any;
        var self = this;
        // self.elemRef.nativeElement.style.backgroundColor = vl;
        var inp = new Picker({
            parent: this.elemRef.nativeElement.querySelector(".output-color"),
            color: this.value,
            alpha: false,
            editor: true,
            layout: 'default',
            popup: 'bottom',
            editorFormat: 'hex', // or 'rgb', 'hsl'
            cancelButton: false,

            // defaultColor: vl,

            onChange: function (color) { },
            onDone: function (color) {
                var hex = color.hex.substr(0, 7);
                self.value = hex;
                self.emit();
            },
            onOpen: function (color) { },
            onClose: function (color) { }
        });

    }



}
