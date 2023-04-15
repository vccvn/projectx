import Dom, { DomFactory, DomEl } from '@app/_core/helpers/dom';
import createClass, { _class } from '@app/_core/helpers/es5.class';
import { Div, Input, Label, Span } from "@app/_core/helpers/html-elements";
import { isArray, isObject } from "@app/_core/helpers/utils";

interface Viewport extends DomEl {
    setCanvas(canvas):void

    /**
     * thêm mặt nạ thay thế cho control
     */
    addControlMaskLayer():void
    makeControlMask():DomEl
    get0ControlMask():DomEl,
    addControlTransferEvent(control):void
    addMaskEvent(control, ev):void
    showMessage(msg):void
    hideMessage():void
}
interface ViewportClass extends DomFactory {
    (...args:any[]):Viewport,
    new(...args:any[]):Viewport
}

/**
 * @var {class} Viewport Class
 */
const Viewport = _class("Viewport").extends(Dom)({
    $canvas: null,
    $id: "viewport",
    $className: "viewport",
    const$isViewport: true,
    $maskLayer: null,
    $transferEventControls: null,
    $softAnimationActivateButton: null,
    $messageComponent: null,
    inits: ['initDefault'],
    initDefault: function(){
        this.transferEventControls = [];
        var self = this;
        // this.softAnimationActivateButton = Input('checkbox', 'soft_animation_activate', true, {
        //     checked: true
        // }).on('change', function(e){
        //     self.dispatchEvent({
        //         type: "softanimation.status.change",
        //         value: this.is(':checked')
        //     })
        // });
        // this.append(Div('.form-group.btn-saa', [
            
        //     Label('.switch', [
        //         this.softAnimationActivateButton,
        //         Span('.slider.round') 
        //     ]),
        //     Label('.lbl.ms-2', 'Làm mượt chuyển động')
        // ]));
        this.messageComponent = Div('.system-message');
        this.append(this.messageComponent);
        this.addControlMaskLayer();
    },
    setCanvas: function(canvas){
        if(this.canvas) this.removeChild(this.canvas);
        // this.find("canvas").remove();
        this.canvas = canvas;
        this.append(canvas);
        

    },

    /**
     * thêm mặt nạ thay thế cho control
     */
    addControlMaskLayer: function(){
        if(!this.maskLayer){
            var scope = this;
            
            var maskLayer = Div("#control-mask.control-mask-layer");
            this.maskLayer = maskLayer;
            this.append(maskLayer);
            this.dispatchEvent({
                type: 'mask.added',
                mask: maskLayer
            });
            
        }
    },
    makeControlMask: function() {
        this.addControlMaskLayer();
        return this.maskLayer;
    },
    get0ControlMask: function() {
        this.addControlMaskLayer();
        return this.maskLayer;
    },
    addControlTransferEvent: function(control){
        if(!control || !isObject(control) || this.transferEventControls.indexOf(control) != -1 || typeof control.getEventList != "function") return false;
        
        var list = control.getEventList();

        this.makeControlMask();
        if(isArray(list)){
            for (let i = 0; i < list.length; i++) {
                const ev = list[i];
                this.addMaskEvent(control,ev);
            }
        }
    },
    addMaskEvent: function addMaskEvent(control, ev){
        var scope = this;
        scope.maskLayer.on(ev, function(event){
            if(typeof control.transferEventListenner == "function"){
                
                control.transferEventListenner(ev, event);
            }
        }, false);
    },

    showMessage: function(msg){
        this.messageComponent.setContent(msg);
        this.messageComponent.show();
    },
    hideMessage: function(){
        // this.messageComponent.setContent(msg);
        this.messageComponent.hide();
    }
}) as ViewportClass;


export default Viewport;