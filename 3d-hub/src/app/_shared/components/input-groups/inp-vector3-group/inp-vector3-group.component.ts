import { ChangeDetectorRef, Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { assignValue } from '@app/_core/helpers/utils';
import { EventManagerService } from '@app/_core/services/event-manager.service';
import { BaseInpGroupComponent } from '../base-inp-group/base-inp-group.component';

@Component({
    selector: 'inp-vector3-group',
    templateUrl: './inp-vector3-group.component.html',
    styleUrls: ['./inp-vector3-group.component.scss']
})
export class InpVector3GroupComponent extends BaseInpGroupComponent implements OnInit {

    @Input() btnCenter: boolean = false;

    @Input() events: EventManagerService;

    degreSymbol: string = "°";
    _value: any = {
        x: 0,
        y: 0,
        z: 0
    };

    canSync: boolean = false;

    vectorCallback = e => {
        if (e.name == this.name) {
            
            if (e.value) {
                this.value = e.value;
            }
            this.syncFromParent();
        }
    };


    constructor(private cd: ChangeDetectorRef) {
        super();
    }



    onInit(): void {
        this.inpInit();
        this.syncFromParent();
        this.canSync = true;
        if (this.events) {
            this.events.on("props.vector.change", this.vectorCallback);
        }
    }

    onDestroy() {
        if (this.events) {
            this.events.off("props.vector.change", this.vectorCallback);
        }
    }

    syncFromParent() {
        assignValue(this._value, {
            x: this.value.x,
            y: this.value.y,
            z: this.value.z
        });
        this.cd.detectChanges();
    }


    ngOnChanges(changes: SimpleChanges): void {
        if (this.canSync) {
            if (changes.value) {
                this.syncFromParent();
            }
        }
    }

    updateVector(event) {
        this.canSync = false;
        assignValue(this.value, {
            x: this._value.x,
            y: this._value.y,
            z: this._value.z,

        })
        this.emitChange();
        this.canSync = true;
    }
    setCenter() {
        this.value.x = 0;
        this.value.z = 0;
        this.syncFromParent();
        this.emitChange();
        this.cd.detectChanges();
    }


}
