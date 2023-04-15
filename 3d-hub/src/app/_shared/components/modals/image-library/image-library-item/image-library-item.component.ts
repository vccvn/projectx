import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'app-image-library-item',
    templateUrl: './image-library-item.component.html',
    styleUrls: ['./image-library-item.component.scss']
})
export class ImageLibraryItemComponent implements OnInit {

    data: any = {};
    thumbnail: string = '';
    constructor() { }

    ngOnInit(): void {

    }

}
