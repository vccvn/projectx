import { ChangeDetectorRef, Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { assignValue } from '@app/_core/helpers/utils';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
    selector: 'inp-select-group',
    templateUrl: './inp-select-group.component.html',
    styleUrls: ['./inp-select-group.component.scss']
})
export class InpSelectGroupComponent extends BaseInpGroupComponent implements OnInit, OnChanges {

    @Input() options: any = null;
    
    configProps = ["options"];
    constructor(private cd: ChangeDetectorRef) {
        super();
    }



    onInit(): void {
        assignValue(this.defaultValues, {
            options: null
          });
        this.inpInit();
        this.cd.detectChanges();
        
    }

    
    ngOnChanges(changes: SimpleChanges): void {
        if (changes.options) {
            this.cd.detectChanges();
        }

    }

}
