import { assignValue, assignWithout, inArray, isArray, isEmpty, isNumber, isObject, objectHasKey, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';

import Props from '../libs/props';
import { CameraSetting, FacePosKeyValues } from '../store/data.type';
export const caculateFacePos = (key: string, val: number) => {
    const pos = {
        x:0, y: 0, z: val
    };

    if(checkFacePos(key)){
        const posRefs = FacePosKeyValues[key];
        let i = 0;
        for (const key in posRefs) {
            if (Object.prototype.hasOwnProperty.call(posRefs, key)) {
                const v = posRefs[key];
                let c = Math.abs(v);
                if(c > 0) i++;
            }
        }

        if(i > 0){
            let powVal = Math.pow(val, 2);
            let p = Math.sqrt(powVal/i);
            for (const k in posRefs) {
                if (Object.prototype.hasOwnProperty.call(posRefs, k)) {
                    const v = posRefs[k];
                    pos[k] = p*v;
                }
            }
        }
    }

    return pos;

}

// objectHasKey(FacePosKeys, key) ? (inArray(['left', 'bottom', 'back'], key) ? -val : val) : val;
export const checkFacePos = (face: string) => objectHasKey(FacePosKeyValues, face);
const Camera = {
    camera: null,
    cameraList: null,
    boots: ['bootCamera'],
    bootCamera: function () {
        this.cameraList = {};
    },
    /**
     * thiết lập cam chính
     * @param {object} opts 
     */
    setMainCamera: function (opts?: any) {
        var self = this;
        var opt = assignValue({}, opts);
        Props.parse(opt);
        var fov = isNumber(opt.fov) && opt.fov > 0 ? opt.fov : 45;
        var aspect = isNumber(this.aspect) && this.aspect > 0 ? this.aspect : 1;
        var near = isNumber(opt.near) && opt.near > 0 ? opt.near : 0.01;
        var far = isNumber(opt.far) && opt.far > 0 ? opt.far : 10000;
        
        var camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
        this.camera = camera;
        // return this;
        if (camera) {
            
            // không có tác dụng gì nhiều nhưng không muốn dùng if
            // var r = this.scene ? this.scene.add(this.camera) : 0;

            // kiểm tra và set vị trí
            if (opt.position) {
                self.setCameraPosition(opt.position);
            }

            // kiểm tra và set góc xoay
            if (opt.rotation) {
                self.setCameraRotation(opt.rotation);
            }

            /**
             * kiểm tra và thiết lập vị trí
             */
            if (this.data.control && !this.data.control.disabled && (opt.rotation || opt.position)) {
                setTimeout(function () {
                    if (opt.position) {
                        assignValue(camera.position, opt.position);
                    }
                    if (opt.rotation) {
                        assignValue(camera.rotation, opt.rotation);
                    }
                    if (opt.quaternion) {
                        assignValue(camera.quaternion, opt.quaternion);
                    }
                    

                }, 10);
            }
            var id = opt.id || "main";
            this.cameraList[id] = camera;
            if(isObject(opt.settings)) this.updateControlSettings({
                settings: opt.settings
            }, true);
        }

        return this;
    },

    changeCameraLookFace: function (face, update?: any) {
        if (checkFacePos(face)) {
            let camera = this.camera;
            let camPos = camera.position;
            let distence = Math.sqrt(
                Math.pow(camPos.x, 2) + Math.pow(camPos.y, 2) + Math.pow(camPos.z, 2)
            );

            // let pk = objectHasKey(FacePosKeyValues, face) ? FacePosKeyValues[face] : FacePosKeyValues.front;
            assignValue(camera.position, caculateFacePos(face, distence));
            this.camera.lookAt(0, 0, 0);
            this.camera.updateProjectionMatrix();
                
            if (update) {
                this.refresh()
                this.emit({
                    type: "controls.change.camera",
                    camera: this.camera
                });
            }
        }
    },

    /** 
     * thiết lập cam chính
     * @param {object} opts 
    */
    updateMainCameraSettings: function (setting, update?: boolean) {
        let camera = this.camera;
        var props = assignValue({}, setting);
        assignWithout(camera, props, ['id', 'type', 'lookat', 'lookAt', 'settings', 'rotation', 'position']);
        // var la = props.lookAt || props.lookat;
        var refresh = false;
        if (isObject(props.settings)) {
            if (isObject(props.settings.position)) {
                let camPos = camera.position;
                let posSetting = props.settings.position;
                if (posSetting.type == "system" || posSetting.type == "faces" || posSetting.type == "face") {
                    this.changeCameraLookFace(posSetting.face);
                    refresh = true;
                } else if (update && posSetting.type == "custom") {
                    assignValue(camera.position, posSetting.custom);
                    refresh = true;

                }

            }
        }
        if(objectHasKey(props, 'fov')) refresh = true;
        if (refresh) {
            this.camera.lookAt(0, 0, 0);
            this.camera.updateProjectionMatrix();
            this.refresh()
            this.emit({
                type: "controls.change.camera",
                camera: this.camera
            });
        }
        else{
            this.emit({
                type: "camera.settings.updated",
                camera: this.camera
            });
        }


        return this
    },

    /**
     * thêm vào danh sách camera
     * @param {option} options thuộc tính
     */
    addCamera: function (options?: any) {
        if (!isObject(options) || isEmpty(options)) return null;
        var id = options.id || "camera_" + Str.rand();

        var camera = this.getCamera(options);
        if (camera) {
            this.cameraList[id] = camera;
        }

    },

    /**
     * thêm nhiều camera
     * @param {Array} cameras array
     */
    addCameras: function (cameras?: any[]) {
        if (isArray(cameras)) {
            for (let i = 0; i < cameras.length; i++) {
                const ctlopt = cameras[i];
                if (isObject(ctlopt)) {
                    this.addCamera(ctlopt);
                }
            }
        }
    },
    /**
     * 
     * @param {object} opts 
     */
    getCamera: function (opts?: any) {
        var self = this;
        var opt = typeof opts == "object" ? assignWithout({}, opts, ['id']) : {};

        Props.parse(opt);
        var pars = isObject(opt.params) || isArray(opt.params) ? opt.params : opt;

        var params: any = {};
        var camera;
        if (opt.type == "cube") {
            params = Props.parseParams(pars, {
                near: 0.1,
                far: 10000
            });
            var cubeRenderTarget = new THREE.WebGLCubeRenderTarget(128, {
                format: THREE.RGBFormat,
                generateMipmaps: true,
                minFilter: THREE.LinearMipmapLinearFilter
            });
            camera = new THREE.CubeCamera(
                params.near || 0.1,
                params.far || 1000,
                cubeRenderTarget
            );
        }
        else if (opt.type == 'orthographic') {
            params = Props.parseParams(pars, {
                left: - this.width / 2,
                right: this.width / 2,
                top: this.height / 2,
                bottom: - this.height / 2,
                near: 0.1,
                far: 10000
            });

            camera = new THREE.OrthographicCamera(
                params.left,
                params.right,
                params.top,
                params.bottom,
                params.near,
                params.far
            );
        }
        else if (opt.type == "stereo") {
            camera = new THREE.StereoCamera();
        }
        else {
            params = Props.parseParams(pars, {
                fov: 45,
                aspect: this.aspect,
                near: 0.1,
                far: 10000
            });

            camera = new THREE.PerspectiveCamera(
                params.fov,
                params.aspect,
                params.near,
                params.far
            );
        }
        if (camera) {
            var props = assignWithout({}, opt.props || opt, params, ['id']);

            assignWithout(camera, props, ['id', 'lookat', 'lookAt']);
            var la = props.lookAt || props.lookat;

            if (la) {
                params = Props.parseParams(la, {
                    x: 0,
                    y: 0,
                    z: 0
                });

                camera.lookAt(params.x, params.y, params.z);
                camera.updateProjectionMatrix();
            }


        }
        return camera;
    },

    /**
     * thiết lập vị trí
     * @param {int} x vĩ trí x
     * @param {number} y vị trí y
     * @param {number} z vị trí z
     */
    setCameraPosition: function (x?: any, y?: number, z?: number) {
        if (typeof x == "object") {
            if (x.x !== undefined && isNumber(x.x)) {
                this.camera.position.x = x.x;
            }
            if (x.y !== undefined && isNumber(x.y)) {
                this.camera.position.y = x.y;
            }
            if (x.z !== undefined && isNumber(x.z)) {
                this.camera.position.z = x.z;
            }
        } else {
            if (x !== undefined && isNumber(x)) {
                this.camera.position.x = x;
            }
            if (y !== undefined && isNumber(y)) {
                this.camera.position.y = y;
            }
            if (z !== undefined && isNumber(z)) {
                this.camera.position.z = z;
            }
        }
        return this;
    },
    setCameraRotation: function (x?: any, y?: number, z?: number) {
        if (typeof x == "object") {
            if (x.x !== undefined && isNumber(x.x)) {
                this.camera.rotation.x = x.x;
            }
            if (x.y !== undefined && isNumber(x.y)) {
                this.camera.rotation.y = x.y;
            }
            if (x.z !== undefined && isNumber(x.z)) {
                this.camera.rotation.z = x.z;
            }
        } else {
            if (x !== undefined && isNumber(x)) {
                this.camera.rotation.x = x;
            }
            if (y !== undefined && isNumber(y)) {
                this.camera.rotation.y = y;
            }
            if (z !== undefined && isNumber(z)) {
                this.camera.rotation.z = z;
            }
        }
        return this;
    },

    /**
     * lấy ra các camera đã dc add
     * @param {string} id 
     */
    getAddedCamera: function (id: any) {
        return typeof this.cameraList[id] != "undefined" ? this.cameraList[id] : null;
    },

    changeCamera: function (id: any, options?: any) {
        var camera = this.getAddedCamera(id, options);
        if (camera) {
            const position = this.camera.position.clone();

            this.camera = camera;
            this.camera.position.copy(position);

            this.control.object = camera;
            this.camera.lookAt(this.control.target.x, this.control.target.y, this.control.target.z);
        }
    }




};

export default Camera;
export { Camera }