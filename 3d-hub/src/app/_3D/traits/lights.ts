import { assignValue, assignWithout, date, getType, inArray, isArray, isObject, objectKeys, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';

import Props from '../libs/props';

import { LightLib } from '../libs/three.libs';

import { Lensflare, LensflareElement } from 'three/examples/jsm/objects/Lensflare.js';
// const textureLoader = new THREE.TextureLoader();

// const textureFlare0 = textureLoader.load('/textures/lensflare/lensflare0.png');
// const textureFlare3 = textureLoader.load('/textures/lensflare/lensflare3.png');
const Lights = {
    lightTypes: [
        "AmbientLight",
        "AmbientLightProbe",
        "DirectionalLight",
        "HemisphereLight",
        "HemisphereLightProbe",
        "Light",
        "LightProbe",
        "PointLight",
        "RectAreaLight",
        "SpotLight"
    ],
    $lights: null,
    resetLights: function(){
        var self = this;
        var lights = [];
        if(isArray(this.lights)){
            this.lights.map(function(light){
                lights.push(light.secret_key);
            });
        }
        
        lights.map(function(light){
            self.removeLight(light);
        });
    },
    /**
     * them doi tuong vao khung
     * @param {object} obj doi tuong
     * @param {function(<object>)} success
     */
    addLightObject: function (obj:any, secret_key?:string, success?:(...args:any[])=>any) {

        if (!this.scene) return false;
        if (this.lights == null) this.lights = [];
        var t = obj.$type ? String(obj.$type) : "";
        if (inArray(this.lightTypes, t)) {
            var data:any = {
                type: t,
                object: obj.light || obj.object
            };

            this.scene.add(data.object);
            var key = obj.secret_key ? obj.secret_key : (secret_key ? secret_key : date().time + '_' + Str.rand(6));
            data.secret_key = key;
            // if (obj.model) data.model = obj.model;
            this.lights.push(data);
            if (typeof success == "function") {
                success(data);
            }
            this.emit('light.added', data);
            this.refresh();
            return data;
        }

        return null;
    },


    removeLightObject: function (args:any) {
        if (this.lights == null) return false;
        for (let index = 0; index < this.lights.length; index++) {
            const obj = this.lights[index];
            if (args == obj || args == obj.object || args == obj.secret_key) {
                this.scene.remove(obj.object);
                this.emit('light.removed', obj);
                this.lights.splice(index, 1);
                return true;
            }
        }
    },

    /**
     * them êm hiệu ung anh sang
     * @param {string} type loai hieu ung anh sang
     * @param {function(lightData:<Object>)} success 
     */
    addLight: function (lightOptions:any, success?:(...args:any[])=>any) {
        var light:any, opt:any, t:any;

        if (isObject(lightOptions)) {
            if (lightOptions.data && isObject(lightOptions.data)) {
                opt = assignWithout({}, lightOptions.data, ['type']);
                if (lightOptions.data.type) t = lightOptions.data.type;
            }
            else {
                opt = assignWithout({}, lightOptions, ['type']);

            }
            if (!t && lightOptions.type) t = lightOptions.type;
        }
        
        if (t && opt) {
            light = LightLib.getLight(t, opt);
            
            if (light) {

                if(light.target){
                    if(!(opt.props && opt.props.target && opt.target.position)){
                        light.target.position.y = this.dropbyPositionY;
                    }
                }

                return this.addLightObject({
                    $type: light.type,
                    secret_key: lightOptions.id || lightOptions.secret_key || undefined,
                    light: light
                }, null, success);
            }

        }
        return false;
    },



    /**
     * Thêm nhiều ánh sáng
     * @param {array} lights mảng các tham số
     */
    addLights: function (lights:any[]) {
        if (isArray(lights)) {
            for (let index = 0; index < lights.length; index++) {
                const light = lights[index];
                if (isObject(light)) {
                    this.addLight(light);
                }
            }
        }
        return this;
    },

    /**
     * 
     * @param {string} secret_key
     * @returns 
     */
    getLight: function (secret_key:any) {
        var t = getType(secret_key);
        if (t == "string" || t == "number") {
            for (let i = 0; i < this.lights.length; i++) {
                const obj = this.lights[i];
                // console.log(obj.secret_key == secret_key);
                if (obj.secret_key == secret_key) return obj;
            }
        } else if (t == "object") {
            if (secret_key.uuid) {
                for (let i = 0; i < this.lights.length; i++) {
                    const obj = this.lights[i];
                    if (obj.object == secret_key) return obj;
                }
            }
            else {
                for (let i = 0; i < this.lights.length; i++) {
                    var s = true;
                    const objectData = this.lights[i];
                    for (const key in secret_key) {
                        if (secret_key.hasOwnProperty(key)) {
                            const cvalue = secret_key[key];
                            if (objectData[key] != cvalue) s = false;
                        }
                    }
                    if (s) return objectData;
                }
            }
        }
        return null;
    },


    /**
     * 
     * @param {string} secret_key
     * @returns 
     */
     removeLight: function (secret_key?:any) {
        var t = getType(secret_key);
        var light = null;
        var index = -1;
        if (t == "string" || t == "number") {
            for (let i = 0; i < this.lights.length; i++) {
                const obj = this.lights[i];
                // console.log(obj.secret_key == secret_key);
                if (obj.secret_key == secret_key) {
                    light = obj;
                    index = i;
                    break;
                }
            }
        } else if (t == "object") {
            if (secret_key.uuid) {
                for (let i = 0; i < this.lights.length; i++) {
                    const obj = this.lights[i];
                    if (obj.object == secret_key) {
                        light = obj;
                        index = i;
                        break;
                    }
                }
            }
            else {
                for (let i = 0; i < this.lights.length; i++) {
                    var s = true;
                    const objectData = this.lights[i];
                    for (const key in secret_key) {
                        if (secret_key.hasOwnProperty(key)) {
                            const cvalue = secret_key[key];
                            if (objectData[key] != cvalue) s = false;
                        }
                    }
                    if (s) {

                        light = objectData;
                        index = i;
                        break;
                    }
                }
            }
        }
        if(light && index !== -1){
            this.emit({
                type: "light.removing",
                light: light
            });
            
            this.scene.remove(light.object);
            this.lights.splice(index, 1);
            this.emit({
                type:"light.removed",
                data: light
            });
            return light;
        }
        return false;
    },


    updateLightProps: function(secret_key?:any, properties?:any){
        var data = this.getLight(secret_key);
        if(!data) return false;
        var props = Props.parse(properties);
        var light = data.object;
        LightLib.setProperties(light, props);
        light.needsUpdate = true;
        // console.log(light.object);
        this.emit({
            type: "light.update",
            data: data
        })

    },

    addFlare: function (light) {

        const lensflare = new Lensflare();
        // lensflare.addElement(new LensflareElement(textureFlare0, 700, 0, light.color));
        // lensflare.addElement(new LensflareElement(textureFlare3, 60, 0.6));
        // lensflare.addElement(new LensflareElement(textureFlare3, 70, 0.7));
        // lensflare.addElement(new LensflareElement(textureFlare3, 120, 0.9));
        // lensflare.addElement(new LensflareElement(textureFlare3, 70, 1));
        light.add(lensflare);
    },

    getLightTemplateData: function(type?:any){
        var t = String(type).toLowerCase();
        return this.lightTemplateData[t] || this.lightTemplateData[t+"light"] || null;
    },
    lightTemplateData: {
        ambientlight: {
            type: "ambientlight",
            data: {
                params: {
                    color: "#222222"
                },
                props: {

                }
            }
        },
        directionallight: {
            type: "Directionallight",
            data: {
                params: {
                    color: "#FFE0B5",
                    intensity: 1
                },
                props: {
                    position: {
                        x: 10,
                        y: 10,
                        z: 0
                    },
                    castShadow: true,
                    shadow: {
                        mapSize: {
                            width: 4096,
                            height: 4096
                        },
                        camera: {
                            near: 0.1,
                            far: 100,
                            left: 10,
                            right: -10,
                            top: 10,
                            bottom: -10
                        },
                        darkness: 0.1,
                        bias: -0.0002,
                        radius: 5
                    }
                }
            }
        },
        hemispherelight: {
            type: "hemispherelight",
            data: {
                params: {

                    color: "#00aaff",
                    groundColor: "#ffaa00",
                    intensity: 1

                }
            }

        },
        pointlight: {

            type: "pointlight",
            data: {
                params: {

                    color: "#00aaff",
                    intensity: 1

                },
                props: {
                    position: {
                        x: 0,
                        y: 1,
                        z: 0
                    }
                }
            }
        },
        rectarealight: {
            type: "rectarealight",
            data: {
                params: {
                    color: 0xffffff,
                    intensity: 1,
                    width: 10,
                    height: 10
                },
                props: {
                    position: {
                        x: -2,
                        y: 2,
                        z: 1
                    }
                }
            }
        },
        spotlight: {
            type: "spotlight",
            data: {
                params: {
                    color: 0xffffff,
                    intensity: 1,
                    distance: 0,
                    angle: Math.PI * 0.1,
                    penumbra: 0
                },
                props: {
                    position: {
                        x: 5, y: 10, z: 6
                    }
                }
            }

        }

    },
};

export default Lights;
export {Lights}