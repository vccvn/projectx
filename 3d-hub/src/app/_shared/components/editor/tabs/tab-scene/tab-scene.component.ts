import { ChangeDetectorRef, Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';
import { EditorIO, EditorMethods } from '../../base/editor-io';

@Component({
    selector: 'app-tab-scene',
    templateUrl: './tab-scene.component.html',
    styleUrls: ['./tab-scene.component.scss']
})
export class TabSceneComponent extends BaseComponent implements OnInit {
    @Input() loaded: EventEmitter<any> = new EventEmitter();

    @Output() loadedChange: EventEmitter<any> = new EventEmitter();

    loadedForeground = false;
    loadedBackground = false;
    height50: boolean = false;

    constructor(private cd: ChangeDetectorRef) {
        super()
    }
    onInit(): void {
        this.loadedChange.emit(true);
        
    }

}
