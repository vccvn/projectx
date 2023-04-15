import { Component, Output, EventEmitter, OnInit, ChangeDetectionStrategy, ChangeDetectorRef } from '@angular/core';
import { BaseComponent } from '@app/_shared/components/base/base.component';
// import { FontModel } from '@app/item-page/_store/font';
// import { EventService } from '@app/item-page/_store/template';

enum TabIndex {
    Meshes = 0,
    Props = 1,

}

@Component({
    selector: 'app-sidebar',
    templateUrl: './sidebar.component.html',
    styleUrls: ['./sidebar.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class SidebarComponent extends BaseComponent implements OnInit {
    
    prevTab: number = TabIndex.Meshes;
    currentTab: number = TabIndex.Meshes;


    constructor(private cd: ChangeDetectorRef) {
        super();
    }

    onInit() {


    }

    onChangeTab(e) {
        this.currentTab = e.index;
        this.cd.detectChanges();
    }

    onClickSearch(event) {
        console.log(event);
    }

    
}
