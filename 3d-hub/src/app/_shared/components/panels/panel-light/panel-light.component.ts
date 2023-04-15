import { ChangeDetectorRef, Component, OnInit, SimpleChanges } from '@angular/core';
import { LightLib } from '@app/_3D/libs/three.libs';
import { LightPropDefaultData, LightProps, ShadowMap } from '@app/_3D/store/data.type';
import { assignValue, assignWithout, inArray, isObject, Str } from '@app/_core/helpers/utils';
import { CallbackFunction } from '@app/_shared/shared.type';
import { BaseComponent } from '../../base/base.component';
import { PanelLightService } from './panel-light.service';

enum TabIndex {
    Params = 0,
    Properties = 1,
}

@Component({
    selector: 'panel-light',
    templateUrl: './panel-light.component.html',
    styleUrls: ['./panel-light.component.scss']
})
export class PanelLightComponent extends BaseComponent implements OnInit {

    title: string = 'Title';
    hasTitle: boolean = false;
    isShow: boolean = false;

    btnDoneText: string = 'Done';
    onUpdateHandle: CallbackFunction = null;
    onDoneHandle: CallbackFunction = null;
    _service: PanelLightService = null;



    prevTab: number = TabIndex.Params;
    currentTab: number = TabIndex.Params;

    secretKey: string = '';

    data: any = {};
    object: any = null;

    settings: any = {};

    paramFormGroup: any[] = [];
    params: any = {};
    props: LightProps = assignValue({}, LightPropDefaultData);
    hasShadow:boolean = true;
    hasTarget: boolean = false;
    hasShadowCamera: boolean = false;
    shadow: ShadowMap = {};

    constructor(private cd: ChangeDetectorRef, private service: PanelLightService) {
        super();
        this._service = service;
        this.service.on("panel.show", e => this.show(e.data));
        this.service.on("panel.hide", e => this.hide());
        this.service.on("editor.update.props", e => {

            if(!this.isFocus) return;
            if (isObject(e.data) && e.data.secret_key == this.secretKey) {
                assignValue(this.settings.props, e.data.key, e.data.value);
                assignValue(this.props, e.data.key, e.data.value);
                if (e.data.key == "rotation") {
                    setTimeout(() => {
                        this.service.emit({
                            type: "props.rotation.change"
                        });
                    }, 1);
                }
                this.cd.detectChanges();
            }
        });
        this.service.on("editor.update.props.target", e => {
            if(!this.isFocus) return;
            if (isObject(e.data) && e.data.secret_key == this.secretKey && this.hasTarget) {
                assignValue(this.settings.props.target, e.data.key, e.data.value);
                assignValue(this.props.target, e.data.key, e.data.value);
                // if (e.data.key == "rotation") {
                //     setTimeout(() => {
                //         this.service.emit({
                //             type: "props.rotation.change"
                //         });
                //     }, 1);
                // }
                this.cd.detectChanges();
            }
        });


        this.service.on("component.checkchange", () => this.cd.detectChanges());
    }

    onInit(): void {
        // this._service = this.service;
        this.cd.detectChanges();
        

    }

    setData(data: any) {
        this.secretKey = data.secret_key;
        this.data = data.data;
        this.object = data.ref;
        this.setDefaultSettingData();
        this.asyncSettings(data.data);
    }

    // dong bo setting cua item voi tab
    asyncSettings(settings: any) {

        this.paramFormGroup = [];
        assignWithout(this.settings, settings, ['meshes']);
        var config = LightLib.getConfigData(this.object.type);
        let params: any = {}
        for (const key in config.inputs) {
            if (Object.prototype.hasOwnProperty.call(config.inputs, key)) {
                const inp = config.inputs[key];
                if (inArray(config.params, inp.name)) {
                    inp.value = typeof this.settings.params[inp.name] != "undefined" ? this.settings.params[inp.name] : this.object[inp.name];
                    params[inp.name] = inp;
                }
            }
        }
        config.params.map(name => Object.prototype.hasOwnProperty.call(params, name)? this.paramFormGroup.push(params[name]) : null);

        var castShadow = config.props.castShadow == "Boolean";
        this.initProps(castShadow);
        this.hasShadow = false;
        this.hasShadowCamera = false;
        this.hasTarget = false;
        if(castShadow){
            this.hasShadow = true;
            this.props.castShadow = typeof this.settings.props.castShadow == "boolean"?this.settings.props.castShadow:this.object.castShadow;

            var lightShadow = this.object.shadow;
            var mapSize = lightShadow.mapSize;
            var camera = lightShadow.camera;
            var shadowTemp = {
                mapSize: {
                    width: mapSize.width,
                    height: mapSize.height
                },
                camera: {
                    near: camera.near,
                    far: camera.far,
                    left: camera.left,
                    right: camera.right,
                    top: camera.top,
                    bottom: camera.bottom
                },
                darkness: lightShadow.darkness,
                bias: lightShadow.bias,
                radius: lightShadow.radius
            };

            assignValue(shadowTemp, settings.props ? settings.props.shadow : {});
            if(!this.object.isPointLight){
                this.hasShadowCamera = true;
            }
            this.props.shadow = shadowTemp;


        }
        if(config.props.target && config.props.target == "Object3D"){
            this.hasTarget = true;
            let defPos = {x: 0, y: 0, z: 0};
            this.props.target = {
                position: {
                    x: 0,
                    y: 0, 
                    z: 0
                }
            }
            for (const key in defPos) {
                if (Object.prototype.hasOwnProperty.call(defPos, key)) {
                    const vl = defPos[key];
                    this.props.target.position[key] = typeof this.settings.props.target == "object" && typeof this.settings.props.target.position =="object" && typeof this.settings.props.target.position[key] != "undefined" ? this.settings.props.target.position[key] : (
                        typeof this.object.target == "object"? this.object.target.position[key] : vl
                    );
                }
            }
        }

    }



    initProps(castShadow?:boolean) {
        for (const key in LightPropDefaultData) {
            if (Object.prototype.hasOwnProperty.call(LightPropDefaultData, key)) {
                const value = LightPropDefaultData[key];
                assignValue(this.props, key, value);
                if (isObject(value)) {
                    if (Object.prototype.hasOwnProperty.call(this.object, key) && isObject(this.object[key]) && key != "shadow") {
                        for (const k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                if (typeof this.object[key][k] != "undefined") {
                                    this.props[key][k] = this.object[key][k];
                                }
                            }
                        }
                    }
                    if (Object.prototype.hasOwnProperty.call(this.settings.props, key)) {
                        for (const k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                if (Object.prototype.hasOwnProperty.call(this.settings.props[key], k)) {
                                    this.props[key][k] = this.settings.props[key][k];
                                }

                            }
                        }
                    }
                } else {
                    if (Object.prototype.hasOwnProperty.call(this.object, key)) {
                        this.props[key] = this.object[key];
                    }
                    if (Object.prototype.hasOwnProperty.call(this.settings.props, key)) {
                        this.props[key] = this.settings.props[key];
                    }
                }


            }
        }
    }

    // updateProps(event: InpEvent) {

    // }

    onDone() {
        this.hide();

        return typeof this.onDoneHandle == "function" ? this.onDoneHandle() : 0;
    }




    /**
     * thiết lập giá trị mặc định
     */
    setDefaultSettingData() {
        this.settings = {
            params: {},
            props: assignValue({}, LightPropDefaultData),

        }
    }





    updateProps(event) {
        let name = event.name;
        let value = event.value;
        var accessName = Str.replace(name, ["[", "]"], [".", ""]);
        var temp = {};
        var accNs = accessName.split(".");
        // if(!this.lightData[group]) this.lightData[group] = {};
        // var d = this.lightData[group];
        let updateName = accNs[0];
        function mkObjMap(o, k, v) {
            o[k] = v;
            return v;
        }
        if (accNs.length == 1) {
            temp[accessName] = value;
        } else {
            var d = null;
            for (let i = 0; i < accNs.length; i++) {
                const ns = accNs[i];
                if (i == 0) {
                    d = mkObjMap(temp, ns, {});
                }
                else if (i < accNs.length - 1) {
                    d = mkObjMap(d, ns, {});

                } else {
                    mkObjMap(d, ns, value);
                }
            }
        }
        
        assignValue(this.settings.props, temp);

        if (typeof this.onUpdateHandle == "function") {
            this.onUpdateHandle({
                secret_key: this.secretKey,
                type: "props",
                name: updateName,
                value: temp[updateName],
                data: this.settings.props
            });
        }
        this.service.emit({
            type: "props.change",
            secret_key: this.secretKey,
            data: this.settings.props
        });
    }

    updateParams(event) {
        this.settings.params[event.name] = event.value;
        if (typeof this.onUpdateHandle == "function") {
            this.onUpdateHandle({
                secret_key: this.secretKey,
                type: "params",
                name: event.name,
                value: event.value,
                data: this.settings.params
            });
        }
        this.service.emit({
            type: "params.change",
            secret_key: this.secretKey,
            data: this.settings.params
        });
    }



    ngOnChanges(changes: SimpleChanges) {

    }

    onChangeTab(e) {
        this.currentTab = e.index;
        this.cd.detectChanges();
    }

    reset() {
        this.settings = {};
        this.object = null;
        this.data = null;
        this.btnDoneText = 'Done';
    }



    show(data: any) {
        if(!this.isFocus) return;
        if (isObject(data)) {

            if (this.isShow) {
                if (data.secret_key == this.secretKey) return false;
                this.hide();
                setTimeout(() => this.display(data), 10);
            }
            else {
                this.currentTab = TabIndex.Params;
                this.display(data);
            }
        }

    }
    hide() {
        if(!this.isFocus) return;
        this.isShow = false;
        this.reset();
    }

    display(data: any) {
        if(!this.isFocus) return;
        if (data.title) {
            this.title = data.title;
            this.hasTitle = true;
        }
        if (data.btnDone || data.btnDoneText) {
            this.btnDoneText = data.btnDone || data.btnDoneText;
        }
        this.onUpdateHandle = null;
        if (typeof data.onUpdate == "function") {
            this.onUpdateHandle = data.onUpdate;
        }
        if (typeof data.onChange == "function") {
            this.onUpdateHandle = data.onChange;
        }
        if (typeof data.change == "function") {
            this.onUpdateHandle = data.change;
        }
        if (typeof data.done == "function") {
            this.onDoneHandle = data.done;
        } else if (typeof data.onDone == "function") {
            this.onDoneHandle = data.onDone;
        }

        if (isObject(data.data) && data.secret_key) {
            this.setData(data);

            this.isShow = true;
        }
    }

}
