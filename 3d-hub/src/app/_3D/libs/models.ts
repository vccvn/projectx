import {
    assignValue,
    assignWithout,
    copyByList,
    copyWithout,
    getEl,
    inArray,
    isArray,
    isEmpty,
    isFunction,
    isObject,
    isString,
    newObj
} from '@app/_core/helpers/utils';
import * as THREE from 'three';
import {LoaderLib} from './three.libs';

import Props from './props';


const Models = {

    /**
     * 
     * @param {object} obj 
    */
    getMeshFromObject: function (obj: any = undefined) {
        var meshes = [];
        if (obj && typeof obj.traverse == "function") {
            try {
                obj.traverse(function (object) {
                    if (object.isMesh || (object.type && String(object.type).toLowerCase() == "mesh")) {
                        meshes.push(object);
                    }
                });
            } catch (error) {
                console.log(error);
            }
        }
        return meshes;
    },
    /**
     * load moidel
     * @param {object} option các thông số load
     * @param {function} success hoàn thành quá trình load
     * @param {function} progress tiến trình load
     * @param {function} error xảy ra lổi
     */
    loadModel: function (option: any = undefined, success: any = undefined, progress: any = undefined, error: any = undefined) {
        if (typeof option != "object") return false;
        if (!option.type || !isString(option.type)) return this;
        var self = this;
        var loadParams = [option.type.toLowerCase(), option, function (data) {
            if (self.trigger) {
                self.emit("model.load.success", data);

            }
            if (typeof success == "function") {
                success(data);
            }
        }, function (percentage) {
            if (self.trigger) {
                self.emit("model.load.proccessing", percentage);
            }
            if (typeof progress == "function") {
                progress(percentage)
            }
        }, function (e) {
            if (self.trigger) {
                self.emit("model.load.error", e);
            }
            if (typeof error == "function") {
                error(e)
            }
        }];
        if (self.Loader) {
            self.Loader.load.apply(self.Loader, loadParams);
        } else {
            LoaderLib.load.apply(self.Loader, loadParams);
        }

    },

    /**
     * 
     * @param {Object3D} obj 
     * @param {Object} options 
     */
    parseModel: function (obj:any=undefined, options:any=undefined, model:any=undefined) {
        var data = newObj()
        try {

            var castShadow = (options.props ? (options.props.castShadow || false) : (options.data ? (options.data.castShadow || false) : (options.castShadow || false))),
                receiveShadow = (options.props ? (options.props.receiveShadow || false) : (options.data ? (options.data.receiveShadow || false) : (options.receiveShadow || false)));
            
            data = newObj({
                meshes: this.getMeshFromObject(obj)
            });
            
            // neu co object
            if (obj) {
                obj.castShadow = true;
                obj.receiveShadow = true;
                var props = {};
                if (options.props) {

                    try {
                        props = Props.parse(options.props);

                    } catch (error) {
                        console.log(error);
                    }

                    var ignore = ['params', 'animateData', 'handle', 'type', 'file', 'path', 'format', 'traverse', '__trans', 'custom', '$id', 'obj_id'];

                    if (options.options && isObject(options.options)) ignore.push('position');
                    assignWithout(obj, props || options, ignore);
                }
                var ot = obj.type ? String(obj.type).toLowerCase() : "";
                if (castShadow || receiveShadow) {
                    if (obj.isMesh || ot == "mesh") {
                        if (castShadow) obj.castShadow = true;
                        if (receiveShadow) obj.receiveShadow = receiveShadow;
                    }
                    if (obj.traverse) {
                        obj.traverse(function (child) {
                            var ct = child.type ? String(child.type).toLowerCase() : "";
                            if (child.isMesh || ct == "mesh") {
                                if (castShadow) child.castShadow = true;
                                if (receiveShadow) child.receiveShadow = receiveShadow;
                            }
                        });
                    }
                    else if (ot == "group" && obj.children && obj.children.length) {
                        var trans;

                        trans = function (o, lv) {
                            for (let gi = 0; gi < o.children.length; gi++) {
                                const child = o.children[gi];
                                var ct = child.type ? String(child.type).toLowerCase() : "";
                                if (child.isMesh || ct == "mesh") {
                                    // data.meshes.push(child);
                                    child.castShadow = castShadow;
                                    child.receiveShadow = receiveShadow;
                                }

                                if (child.children && child.children.length) {
                                    if (!lv) lv = 0;
                                    lv++;
                                    trans(child, lv);
                                }
                            }
                        };
                        trans(obj);
                    }
                }



                var box = new THREE.Box3().setFromObject(obj);
                box.getCenter(obj.position); // this re-sets the mesh position
                const dimensions = new THREE.Vector3();
                var size:any = box.getSize(dimensions);
                data.size = newObj({
                    origin: {
                        width: size.x,
                        height: size.y,
                        depth: size.z
                    }
                });
                assignValue(data.size.origin, size);
                // console.log(box);
                // return false;
                var ps = copyByList(props || options, ['position']);
                var opt = options.options;
                // nếu can giua doi tuong
                // data.raw = obj;
                if (opt && isObject(opt)) {

                    if (opt.pivot || opt.centerPivot) {
                        obj.position.multiplyScalar(-1);
                        var pivot = new THREE.Object3D();
                        pivot.add(obj);
                        if (opt.centerPivot) {
                            assignValue(pivot, ps);
                        }
                        if (isString(opt.pivot)) {
                            assignValue(pivot, ps);
                        }
                        else if (isObject(opt.pivot)) {
                            if (opt.pivot.x) {

                            }
                            assignValue(pivot, ps);
                        }
                        pivot.castShadow = castShadow;
                        pivot.receiveShadow = castShadow;
                        data.object = pivot;
                    } else {
                        assignValue(obj, ps);
                        data.object = obj;
                    }


                } else {

                    assignValue(obj, ps);

                    data.object = obj;
                }
                data.$type = 'model';

                if (options.options && isObject(options.options)) {
                    data.options = options.options;
                }

            }

        } catch (error) {
            console.log(error);
        }
        return data;

    },
    /**
     * Get model
     * @param {Object} options các thong so load
     * @param {function(obj, model)} onSuccess 
     * @param {function(error)} onError 
     * @param {function(proccessing)} onProgress
     */
    getModel: function getModel(options:any=undefined, onSuccess:any=undefined, onError:any=undefined, onProgress:any=undefined) {
        if (typeof options != "object") return false;
        var params = isObject(options.params) ? options.params : options;
        var t = String(params.type ? params.type : (options.type ? options.type : '')).toLowerCase();
        var self = this;


        var select = params.select || options.select || null;


        // load model
        this.loadModel(params, function (model) {

            // neu thuoc cac dinh dang thong thuong
            if (inArray(['fbx', 'gltf', 'obj', 'max', '3ds', 'stl'], t)) {
                try {
                    // var animations = null;
                    var obj = null;
                    var box = null;
                    // neu co kem thong tin select
                    if (t == 'gltf') {
                        if (model.scene) {
                            if (select && select != 'default') {
                                var o = getEl(model.scene, select);
                                if (o) obj = o;

                            } else {
                                obj = model.scene;
                            }
                        }
                        else {
                            obj = model;
                        }
                    }
                    else {
                        obj = model;
                    }

                    if (typeof onSuccess == "function") {
                        onSuccess(obj, model)
                    }


                } catch (error) {
                    if (typeof onError == "function") {
                        console.log(error)
                        onError(error);
                    }
                }
            }
        }, function (p) {
            if (typeof onProgress == "function") {
                onProgress(p);
            }
        }, onError);

    },

    /**
     * them model
     * @param {object} options các thong so load
     * @param {function(data)} onSuccess 
     * @param {function(s)} onError 
     */
    getModelAndConvertToAppObjectData: function(options:any=undefined, onSuccess:any=undefined, onError:any=undefined, onProgress:any=undefined) {
        if (typeof options != "object") return false;
        var params = isObject(options.params) ? options.params : options;
        var t = String(params.type ? params.type : (options.type ? options.type : '')).toLowerCase();
        var self = this;

        var data = newObj({
            meshes:[]
        });
        
        var select = params.select || options.select || null;
        var trans = typeof params.traverse == "function" ? params.traverse :
            typeof options.traverse == "function" ? options.traverse : null;

        if (trans) {
            params.__trans = trans;
        }
        params.traverse = function (object) {

            try {
                if (typeof params.__trans == "function") {
                    params.__trans(object);
                }
                if (object.isMesh || (object.type && String(object.type).toLowerCase() == "mesh")) {

                    if (data.meshes.indexOf(object) == -1) {
                        data.meshes.push(object);
                    }

                    if (options.castShadow || (typeof options.props == "object" && options.props.castShadow)) {
                        object.castShadow = true;
                        object.receiveShadow = true;

                    }
                }
            } catch (error) {
                console.log(error);
            }
        };

        // load model
        this.loadModel(params, function (model) {

            // neu thuoc cac dinh dang thong thuong
            if (inArray(['fbx', 'gltf', 'obj', 'max', '3ds', 'stl'], t)) {
                try {
                    var animations = null;
                    var obj = null;
                    var box = null;
                    // neu co kem thong tin select
                    if (t == 'gltf') {
                        if (model.scene) {
                            if (select && select != 'default') {
                                var o = getEl(model.scene, select);
                                if (o) obj = o;

                            } else {
                                obj = model.scene;
                            }
                        }
                        else {
                            obj = model;
                        }
                    }
                    else {
                        obj = model;
                    }
                    if (model.animations) {
                        animations = model.animations;
                    }

                    // neu co object
                    if (obj) {
                        obj.castShadow = true;
                        obj.receiveShadow = true;
                        var props = {};
                        if (options.props) {

                            try {
                                props = Props.parse(options.props);

                            } catch (error) {
                                console.log(error);
                            }

                            var ignore = ['params', 'animateData', 'handle', 'type', 'file', 'path', 'format', 'traverse', '__trans', 'custom', '$id', 'obj_id'];

                            if (options.options && isObject(options.options)) ignore.push('position');
                            assignWithout(obj, props || options, ignore);
                        }
                        var ot = obj.type ? String(obj.type).toLowerCase() : "";
                        if (obj.isMesh || ot == "mesh") {
                            obj.castShadow = true;
                            // data.meshes.push(obj);
                        } else if (ot == "group" && obj.children && obj.children.length) {
                            var trans;

                            trans = function (o, lv) {
                                for (let gi = 0; gi < o.children.length; gi++) {
                                    const child = o.children[gi];
                                    var ct = child.type ? String(child.type).toLowerCase() : "";
                                    if (child.isMesh || ct == "mesh") {
                                        // data.meshes.push(child);
                                        child.castShadow = true;
                                        child.receiveShadow = true;
                                    }

                                    if (child.children && child.children.length) {
                                        if (!lv) lv = 0;
                                        lv++;
                                        trans(child, lv);
                                    }
                                }
                            };
                            trans(obj);
                        } else if (typeof obj.traverse == "function") {
                            obj.traverse(params.traverse);
                        }


                        var box = new THREE.Box3().setFromObject(obj);
                        box.getCenter(obj.position); // this re-sets the mesh position
                        // console.log(box.min, box.max, box.getSize());
                        var sizeA = new THREE.Vector3();
                        var size = box.getSize(sizeA);
                        data.size = {
                            origin: {
                                length: size.x,
                                width: size.z,
                                height: size.y
                            }
                        };
                        assignValue(data.size.origin, size);
                        // console.log(box);
                        // return false;
                        var ps = copyByList(props || options, ['position']);
                        var opt = options.options || (options.settings ? options.settings.options : undefined);
                        // nếu can giua doi tuong
                        if (opt && isObject(opt)) {
                            if (opt.pivot || opt.centerPivot) {
                                obj.position.multiplyScalar(-1);
                                var pivot = new THREE.Object3D();
                                pivot.add(obj);
                                if (opt.centerPivot) {
                                    assignValue(pivot, ps);
                                }
                                if (isString(opt.pivot)) {
                                    assignValue(pivot, ps);
                                }
                                else if (isObject(opt.pivot)) {
                                    if (opt.pivot.x) {

                                    }
                                    assignValue(pivot, ps);
                                }
                                pivot.castShadow = true;
                                pivot.receiveShadow = true;
                                data.object = pivot;
                            } else {
                                assignValue(obj, ps);
                                data.object = obj;
                            }


                        } else {

                            assignValue(obj, ps);

                            data.object = obj;
                        }
                        data.$type = 'model';

                        if (animations) {
                            data.animations = animations;
                        }
                        if (typeof onSuccess == "function") {
                            onSuccess(data);
                        }
                    }

                } catch (error) {
                    if (typeof onError == "function") {
                        console.log(error)
                        onError(error);
                    }
                }
            }
        }, function (p) {
            if (typeof onProgress == "function") onProgress(p);
        }, onError);

    }
};

export default Models;