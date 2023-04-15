import { Component, Input, OnInit, Output, EventEmitter, ChangeDetectorRef, OnChanges, SimpleChanges } from '@angular/core';
import { assignValue, isObject } from '@app/_core/helpers/utils';
import { EventManagerService } from '@app/_core/services/event-manager.service';

@Component({
    selector: 'object-prop',
    templateUrl: './object-prop.component.html',
    styleUrls: ['./object-prop.component.scss']
})
export class ObjectPropComponent implements OnInit, OnChanges {
    @Input() props: any = {};
    @Input() index: number = 0;
    @Output() onUpdate = new EventEmitter<any>();
    events: EventManagerService = null;
    constructor(private cd: ChangeDetectorRef, private eventService: EventManagerService) {
        this.events = this.eventService;
    }

    emitPropChange(){
        this.eventService.emit({
            type: "props.rotation.change",
            value: this.props.rotation
        });
        this.eventService.emit({
            type: "props.vector.change",
            value: this.props.scale
        });
        
    }

    ngOnInit(): void {

        this.events.on("object.props.change", e => {
            assignValue(this.props, e.props);
            this.emitPropChange();
            this.cd.detectChanges();
        })
        
        setTimeout(() => {
            this.emitPropChange();
            this.cd.detectChanges();
        }, 10);
        
        this.cd.detectChanges();
    }

    
    ngOnChanges(changes: SimpleChanges): void {
        this.emitPropChange();
        this.cd.detectChanges();

    }


    onInputChange(event){
        if(event && isObject(event) && event.name) {
            if(isObject(this.props[event.name]) && isObject(event.value)){
                assignValue(this.props[event.name], event.value);
            }
            else{
                this.props[event.name] = event.value;
            }
            this.emitUpdate();
        }
    }

    emitUpdate(){
        this.onUpdate.emit(this.props);
    }
}
