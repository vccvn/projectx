import { assignValue, assignWithout, combineElenentsJoinStringList, copyByList, copyWithout, date, getEl, getType, inArray, isArray, isEmpty, isNumber, isObject, isString, newObj, Str } from '@app/_core/helpers/utils';
import * as THREE from 'three';

import Props, { parseParams } from '../libs/props';


import { GLTFExporter } from 'three/examples/jsm/exporters/GLTFExporter.js';
import { Geometries, LightLib, LoaderLib, Materials, Meshes } from '../libs/three.libs';

const ObjectManager = {
    $meshes: null,
    $models: null,

    $objects: null,


    draggablePanel: null,

    floorStatus: false,

    downloadLink: null,
    objectLoadingCount: 0,
    objectLoadingTotal: 0,
    boots: ['objectManagerBoot'],
    pendingModels: null,
    pendingObjects: null,

    objectManagerBoot: function () {
        this.meshes = [];
        this.models = {};
        this.objects = [];

        this.pendingModels = [];
        this.pendingObjects = [];

    },


    resetObjects: function () {
        var self = this;
        var objects = [];
        this.meshes.map(function (mesh) {
            objects.push(mesh.secret_key);
        })
        this.objects.map(function (mesh) {
            objects.push(mesh.secret_key);
        })
        objects.map(function (mesh) {
            self.removeObject(mesh);
        })
    },

    /**
     * them doi tuong vao khung
     * @param {object} obj doi tuong
     * @param {function} updateHandler hanh dong khi update
     */
    addObjectData: function (obj: any, updateHandler?: (...args: []) => any, secret_key?: any): string {

        if (!this.scene) return null;
        var type = obj.$type ? String(obj.$type).toLowerCase() : "";
        if (inArray(['smartobject', '3dobject', 'sm', 'model', 'mesh', 'light', 'group'], type)) {
            var data: any = {
                type: type,
                object: obj.object
            };
            const t = typeof updateHandler;
            if (updateHandler && (t == "function" || (t == "object" && !isEmpty(updateHandler)))) {
                data.handler = this.parseUpdateHandler(updateHandler);
            }
            if (obj.animations && isArray(obj.animations) && obj.animations.length) {
                data.animations = obj.animations;
            }
            var propList = ["meshes", 'textures', 'wrapper', 'size', 'raw'];
            for (let index = 0; index < propList.length; index++) {
                const key = propList[index];
                if (typeof obj[key] && obj[key]) {
                    data[key] = obj[key];
                }
            }

            // if (type == 'model') {
                this.scene.add(obj.object);
            // }

            var key = obj.secret_key ? obj.secret_key :
                (secret_key ? secret_key : date().time + '_' + Str.rand(6));
            data.secret_key = key;
            // if (obj.model) data.model = obj.model;
            this.objects.push(data);
            var s = this.emit('object.added', data);
            // console.log(s);
            this.refresh();
            return key;
        }

        else {
            var data: any = {
                object: obj
            };
            const t = typeof updateHandler;
            if (updateHandler && (t == "function" || (t == "object" && !isEmpty(updateHandler)))) {
                data.handler = this.parseUpdateHandler(updateHandler);
            }
            this.scene.add(obj);
            var key = obj.secret_key ? obj.secret_key :
                (secret_key ? secret_key : date().time + '_' + Str.rand(6));
            data.secret_key = key;
            this.objects.push(data);
            var s = this.emit('object.added', data);
            // console.log(s);

            this.refresh();
            return key;
        }
        return null;
    },


    removeObjectData: function (args?: any) {
        for (let index = 0; index < this.objects.length; index++) {
            const obj = this.objects[index];
            if (args == obj || args == obj.object || args == obj.secret_key) {
                this.scene.remove(obj.object);
                this.emit('object.removed', obj);
                this.objects.splice(index, 1);
                this.refresh();
                return true;
            }
        }
    },
    /**
     * Thêm model item để thiết lập 
     * @param {Object} options 
     * @param {function(obj, model)} onSuccess 
     * @param {function(error)} onError 
     * @param {function(proccessing)} onProgress
     */
    addSettingModelItem: function (options: any, onSuccess?: (obj?: any, model?: any) => any, onError?: (error?: any) => any, onProgress?: (percent?: number) => any) {
        var params = copyByList(options, ['type', 'path', 'file', 'custom_file']);
        assignValue(params, options.load_options);

        if (params.custom_file) {
            params.file = params.custom_file;
        }
        var optionData = options.settings || {};
        // console.log(object);
        optionData.options = {
            pivot: {
                x: "center",
                y: "center",
                z: "center"
            }
        };

        var self = this;


        return this.getModel(params, function (obj, model) {
            var data = self.parseModel(obj, optionData);
            if (!data) return console.log(
                "loi"
            )
            // data.model = model;
            data.name = options.name;
            data.secret_key = options.secret_key;
            var secret_key = self.addObjectData(data);
            var ob = self.getObject(secret_key);
            // console.log(options)
            if (options.settings) {
                self.updateObjectSettings(secret_key, options.settings);
            }
            onSuccess(ob);
            self.refresh();
        }, onError, onProgress);
    },



    /**
     * Thêm model item để thiết lập templates
     * @param {string} secret_key 
     * @param {Object} options 
     * @param {function(obj, model)} onSuccess 
     * @param {function(error)} onError 
     * @param {function(proccessing)} onProgress
     */
    addItemToTemplateSettingWorkspace: function (secret_key: string, options?: any, onSuccess?: (object?: any, model?: any) => any, onError?: (error?: any) => any, onProgress?: (percent?: number) => any) {
        var params = copyByList(options, ['type', 'path', 'file', 'custom_file']);
        assignValue(params, options.load_options);

        if (params.custom_file) {
            params.file = params.custom_file;
        }
        var optionData = options.settings || {};
        optionData.options = {
            pivot: {
                x: "center",
                y: "center",
                z: "center"
            }
        };

        var self = this;


        return this.getModel(params, function (obj, model) {
            var data = self.parseModel(obj, optionData);
            if (!data) return console.log(
                "loi"
            )
            // data.model = model;
            data.name = options.name;
            data.secret_key = secret_key || options.secret_key;
            var _secret_key = self.addObjectData(data);
            var ob = self.getObject(_secret_key);
            if (options.settings) {
                self.updateObjectSettings(_secret_key, options.settings);
            }
            onSuccess(ob);
            self.refresh();
        }, onError, onProgress);
    },


    /**
     * them model
     * @param {object} options các thong so load
     * @param {function} success 
     * @param {function} onError 
     */
    addModel: function (options: any, success?: (data?: any) => any, onError?: (error?: any) => any, onProgress?: (percent?: number) => any) {
        if (typeof options != "object") return false;
        var self = this;
        this.getModelAndConvertToAppObjectData(options, function (data) {
            var hd = Props.getObjectAnimateHandler(options);
            if (hd) {
                data.handler = hd;
            }

            // console.log(data)
            // self.scene.add(data.object);
            var secret_key = self.addObjectData(data, hd, options.secret_key);

            // self.models[_id] = data;
            // if (data.custom) {
            //     self.Custom.add(_id);
            // }
            if (options.settings) {
                self.updateObjectSettings(secret_key, options.settings);
            }
            if (typeof success == "function") {
                success(self.getObject(secret_key));
            }

            self.refresh();
        }, onError, onProgress);

    },


    /**
     * Thêm nhiều ánh model
     * @param {array} models mảng các tham số
     */
    addModels: function (models?: any[]) {
        if (isArray(models)) {

            for (let index = 0; index < models.length; index++) {
                const model = models[index];

                if (isObject(model)) {
                    this.pendingModels.push(model)

                }
            }
            var self = this;
            var fn;
            fn = function () {
                if (self.pendingModels.length) {
                    self.addModel(self.pendingModels.shift(), fn, fn);
                }
            };
            fn()
        }
        return this;
    },

    addMesh: function addMesh(options: any, success?: (data?: any) => any) {
        // console.log(options, typeof options == "object" && typeof options.geometry == "object" && typeof options.material == "object")
        if (!isObject(options)) return null;
        var self = this;
        var meshData = isObject(options.data) ? options.data : options;
        if (typeof meshData == "object" && typeof meshData.geometry == "object" && typeof meshData.material == "object") {

            var mesh = this.Mesh.get(meshData, function (e) {
                self.refresh();
            });

            if (mesh) {
                assignWithout(mesh, meshData.props || meshData, ['type', 'geometry', 'material', 'props', 'update', 'handler', 'updateHandler', 'handlerData', 'id', "custom"]);
                var hd = Props.getObjectAnimateHandler(meshData);
                if (!mesh.name) mesh.name = meshData.geometry.type;
                // console.log(mesh);
                var data: any = {
                    $type: "mesh",
                    object: mesh,
                    size: {}
                }
                var box = new THREE.Box3().setFromObject(mesh);
                // box.getCenter(obj['position']); // this re-sets the mesh position
                const dimensions = new THREE.Vector3();
                var size: any = box.getSize(dimensions);
                data.size = newObj({
                    origin: {
                        width: size.x,
                        height: size.y,
                        depth: size.z
                    }
                });
                assignValue(data.size.origin, size);
                var secret_key = this.addObjectData(data, hd, options.secret_key || options.id);

                // this.meshes[secret_key] = data;
                if (typeof success == "function") {
                    success(this.getObject(secret_key))
                }
                this.refresh();

                return secret_key;
            }
        }
        return null;
    },
    addMeshes: function addMeshes(meshes: any[]) {
        if (isArray(meshes)) {
            for (let index = 0; index < meshes.length; index++) {
                const mesh = meshes[index];
                if (isObject(mesh)) {
                    this.addMesh(mesh);
                }
            }
        }
        return this;
    },
    addObject: function (object: any, onSuccess?: (data?: any) => any, onError?: (error?: any) => any, onProgress?: (p?: any) => any) {
        try {
            if (isObject(object) && object.type && isObject(object.data)) {
                // console.log(object);
                var data = object.data;
                var type = String(object.type).toLowerCase();
                // if (object.custom && !data.custom) {
                //     data.custom = object.custom;
                // }
                if (object.secret_key) {
                    data.secret_key = object.secret_key;
                }
                if (type == 'mesh') {
                    this.addMesh(data, onSuccess, onError);
                } else if (type == 'model') {
                    this.addModel(data, onSuccess, onError, onProgress)
                } else if (type == 'grid') {
                    this.addGrid(data, onSuccess, onError)
                } else if (type == 'group') {
                    try {
                        this.addGroup(data, onSuccess, onError);
                    } catch (error) {
                        // console.log(error);
                        if (typeof onError == "function") {
                            onError(error);
                        }
                    }
                }
            }
        } catch (e) {
            if (typeof onError == "function") {
                onError(e);
            }
        }
    },

    addObjects: function addObjects(objects?: any[]) {
        try {
            var self = this;
            this.objectLoadingCount = objects.length;
            this.objectLoadingTotal = objects.length;
            var currentLoad = 0;
            if (isArray(objects)) {
                if (objects.length == 0) {
                    this.emit("object.load.completed");
                } else {
                    this.emit("object.load.starting");
                }
                for (let index = 0; index < objects.length; index++) {
                    const obj = objects[index];
                    if (isObject(obj)) {
                        this.pendingObjects.push(obj);
                    }
                }
                var fn;
                fn = function () {
                    if (self.pendingObjects.length) {
                        self.addObject(self.pendingObjects.shift(), function (data) {
                            self.objectLoadingCount--;
                            currentLoad++;
                            if (self.objectLoadingCount == 0) {
                                self.emit("object.load.completed");
                            }
                            else {
                                fn();
                            }
                        }, function (e) {
                            self.objectLoadingCount--;
                            currentLoad++;
                            if (self.objectLoadingCount == 0) {
                                self.emit("object.load.completed");
                            }else {
                                fn();
                            }
                        }, function(p){
                            var n = currentLoad+(p/100);
                            var pc:number = n/self.objectLoadingTotal;
                            var a = parseInt(String(pc*10000)) / 100;
                            self.emit({
                                type: "loadmore.progress",
                                percent: a
                            })
                        });
                    }
                };
                fn()
            } else if (isObject(objects)) {
                for (const key in objects) {
                    if (objects.hasOwnProperty(key)) {
                        const object = objects[key];
                        if (isObject(object)) {
                            if (!object.id) object.secret_key = key;
                            this.objectLoadingCount += 1;
                            this.addObject(object, function (data) {
                                self.objectLoadingCount--;
                                if (self.objectLoadingCount == 0) {
                                    this.emit("object.load.completes");
                                }
                            }, function (e) {
                                self.objectLoadingCount--;
                                if (self.objectLoadingCount == 0) {
                                    this.emit("object.load.completes");
                                }
                            });
                        }
                    }
                }
            }

        } catch (e) {
            console.log(e);
        }
        return this;
    },


    /**
     * Nhóm các đối tượng
     * @param {object} groupData dữ liệu nhóm
     */
    addGroup: function addGroup(groupData: any, success?: (data?: any) => any) {
        var id = "group_" + Str.rand();
        var objects = [];
        var meshes: any = {};
        var self = this;
        var getObj = function getObj(object: any) {
            var o = null;
            if (isObject(object) && object.type && isObject(object.data)) {
                var data = object.data;
                var type = String(object.type).toLowerCase();
                if (type == 'mesh') {
                    o = self.Mesh.get(data);
                    if (o) {
                        objects.push(o);
                    }
                }
            }
            return o;
        }

        try {
            var children = [];
            if (groupData.children && inArray(['array', 'object'], getType(groupData.children))) {
                children = groupData.children;
            } else if (groupData.objects && inArray(['array', 'object'], getType(groupData.objects))) {
                children = groupData.objects;
            }

            if (isArray(children)) {
                for (let index = 0; index < children.length; index++) {
                    const obj = children[index];
                    if (isObject(obj)) {
                        const m = getObj(obj);
                        if (m) {
                            const n = m.name || "mesh-" + Str.rand();
                            meshes[n] = m;
                        }
                    }
                }
            } else if (isObject(children)) {
                for (const key in children) {
                    if (children.hasOwnProperty(key)) {
                        const object = children[key];
                        if (isObject(object)) {
                            const m = getObj(object);
                            if (m) {
                                const n = m.name || key;
                                meshes[n] = m;
                            }
                        }
                    }
                }
            }


            if (objects.length) {
                var group = new THREE.Group();
                for (let i = 0; i < objects.length; i++) {
                    const obj = objects[i];
                    group.add(obj);
                }
                if (isObject(groupData.props)) {
                    assignValue(group, groupData.props);
                }

                meshes.main = group;
                var hd = Props.getObjectAnimateHandler(groupData);
                var d: any = {
                    $type: "group",
                    object: group,
                    meshes: meshes
                };

                if (groupData.options && isObject(groupData.options)) {
                    d.options = groupData.options;
                }
                if (groupData.id) {
                    d.secret_key = groupData.id;
                }
                if (hd) {
                    d.handler = hd;
                }
                if (isObject(groupData.textures) || isArray(groupData.textures)) {
                    d.textures = groupData.textures;
                }

                var _id = this.addObjectData(d);

                if (typeof success == "function") {
                    success(this.getObject(_id))
                }
                this.refresh();


            }
        } catch (e) {
            console.log(e);
        }

    },

    getObject: function (secret_key: any): any {
        var t = getType(secret_key);
        if (t == "string" || t == "number") {
            for (let i = 0; i < this.objects.length; i++) {
                const obj = this.objects[i];
                if (obj.secret_key == secret_key) return obj;
            }
        } else if (t == "object") {
            if (secret_key.uuid) {
                for (let i = 0; i < this.objects.length; i++) {
                    const obj = this.objects[i];
                    if (obj.object == secret_key) return obj;
                }
            }
            else {
                for (let i = 0; i < this.objects.length; i++) {
                    var s = true;
                    const objectData = this.objects[i];
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

    removeObject: function (args: any) {
        var t = getType(args);
        if (t == "string" || t == "number") {
            for (let i = 0; i < this.objects.length; i++) {
                const obj = this.objects[i];
                if (obj.secret_key == args) {
                    this.objects.splice(i, 1);
                    this.emit('object.removed', obj);
                    this.scene.remove(obj.object);
                    this.refresh();
                    return obj;
                }
            }
        } else if (t == "object") {
            if (args.uuid) {
                for (let i = 0; i < this.objects.length; i++) {
                    const obj = this.objects[i];
                    if (obj.object == args) {
                        this.objects.splice(i, 1);
                        this.emit('object.removed', obj);
                        this.scene.remove(obj.object);
                        this.refresh();
                        return obj;
                    }
                }
            }
            else {

                for (let i = 0; i < this.objects.length; i++) {
                    var s = true;
                    const objectData = this.objects[i];
                    for (const key in args) {
                        if (args.hasOwnProperty(key)) {
                            const cvalue = args[key];
                            if (objectData[key] != cvalue) s = false;
                        }
                    }
                    if (s) {
                        this.scene.remove(objectData.object);
                        this.objects.splice(i, 1);
                        this.emit('object.removed', objectData);
                        return objectData;
                    }
                }
            }
        }
        return null;
    },

    getMesh: function (args: any) {
        if (typeof args == "undefined") return null;
        if (typeof args == "object") {
            args.type = 'mesh';
        } else {
            args = {
                secret_key: args,
                type: "mesh"
            }
        }
        return this.getObject(args);
    },
    parseUpdateHandler: function (handler: any) {
        return function (obj) {
            // lặp qua các option opdate
            for (const key in handler) {
                if (handler.hasOwnProperty(key)) {
                    const props = handler[key];
                    if (isObject(props)) {
                        // nếu là object pos hoac rota
                        if (inArray(['rotation', 'position'], key)) {
                            for (const p in props) {
                                if (props.hasOwnProperty(p) && inArray(['x', 'y', 'z'], p)) {
                                    const prop = props[p];
                                    if (prop.hasOwnProperty('value') && isNumber(prop.value)) {
                                        var v = Number(prop.value);
                                        if (prop.hasOwnProperty('action')) {
                                            if (inArray(['dec', 'decrement', '-'], prop.action)) {
                                                obj[key][p] -= v;
                                            } else {
                                                obj[key][p] += v;
                                            }

                                        } else {
                                            obj[key][p] = v;
                                        }
                                    }
                                }
                            }
                        }
                        // end pos or rota
                    }
                    // nếu là phương thức hoặc
                    else if (isArray(props) && key.substr(0, 1) == "@" && typeof obj[key.substr(1)] == "function") {
                        obj[key.substr(1)].apply(obj, props);
                    }
                }
            }
        }
    },


    /**
     * Cập nhật thuộc tính cho đối tượng
     * @param {string} id key nhan dien doi tuong trong scene
     * @param {*} settings 
     */
    updateObjectSettings: function (id: any, settings?: any, updateList?: any, meshIndex?: any, materialIndex?: number) {

        var objectData = this.getObject(id);
        var self = this;
        if (objectData && settings && isObject(settings)) {
            var settingData = assignValue({}, settings);
            var obj = objectData.object;
            if (isObject(settingData.props) && !isEmpty(settingData.props)) {
                var props = settingData.props;
                var cast = typeof props.castShadow == "boolean";
                var receive = typeof props.receiveShadow == "boolean";
                var ot = obj.type ? String(obj.type).toLowerCase() : "";
                if (cast || receive) {
                    if (obj.isMesh || ot == "mesh") {
                        if (cast) obj.castShadow = props.castShadow;
                        if (receive) obj.receiveShadow = props.receiveShadow;
                        self.Shadows.removeMesh(obj);
                    }
                    if (obj.traverse) {
                        obj.traverse(function (child) {
                            var ct = child.type ? String(child.type).toLowerCase() : "";
                            if (child.isMesh || ct == "mesh") {
                                if (cast) child.castShadow = props.castShadow;
                                if (receive) child.receiveShadow = props.receiveShadow;
                                self.Shadows.removeMesh(obj);
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
                                    if (cast) child.castShadow = props.castShadow;
                                    if (receive) child.receiveShadow = props.receiveShadow;
                                    self.Shadows.removeMesh(obj);
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
                }// end if cast shadow
                assignWithout(obj, props, ['receiveShadow', 'castShadow']);
                this.dispatchEvent({
                    type: "object.update.props",
                    data: objectData
                })
            }// endd props

            var setMeshData = function (mesh: any, data?: any) {
                const paramData = Props.parse(assignWithout({}, data, ['material']), function (x) {
                    self.refresh();
                });
                assignValue(mesh, paramData);
                if (mesh.material && data.material) {
                    if (isArray(mesh.material)) {
                        const inb = isNumber(materialIndex) && materialIndex >= 0;
                        if (isArray(data.material)) {
                            for (let index = 0; index < mesh.material.length; index++) {
                                const mat = mesh.material[index];
                                const a = !inb || materialIndex == index;
                                if (data.material[index] || a) {
                                    const updateData = (updateList && isArray(updateList)) ? copyByList(data.material[index], updateList) : data.material[index];
                                    Materials.setProperties(mat.type, mat, updateData, function (x) {
                                        self.refresh();
                                    });
                                }
                            }
                        }
                    }
                    else if (!isArray(data.material)) {
                        const updateData = (updateList && isArray(updateList)) ? copyByList(data.material, updateList) : data.material;
                        Materials.setProperties(mesh.material.type, mesh.material, updateData, function (x) {
                            self.refresh();
                        });
                    }
                }

            }

            if (settingData.meshes && isArray(settingData.meshes)) {
                const ism = isString(meshIndex);
                const isn = isNumber(meshIndex);
                const hasInd = (ism || isn);
                for (let i = 0; i < settingData.meshes.length; i++) {
                    const mesh = settingData.meshes[i];
                    for (let j = 0; j < objectData.meshes.length; j++) {
                        const meshData = objectData.meshes[j];
                        if (meshData.name == "" || mesh.name == "") {
                            if ((meshData.name == mesh.name && i == j)) {
                                if (!isn || meshIndex == i) {
                                    setMeshData(meshData, mesh.data);
                                    meshData.needsUpdate = true;
                                }

                            }
                        }
                        else if (meshData.name == mesh.name) {
                            // assignValue(meshData, Props.parse(mesh.data));
                            if (!hasInd || ((ism && mesh.name == meshIndex) || (isn && i == meshIndex))) {
                                setMeshData(meshData, mesh.data);
                                meshData.needsUpdate = true;
                            }

                        }

                    }
                }

                this.dispatchEvent({
                    type: "object.update.meshes",
                    data: objectData
                });
            }

            this.dispatchEvent({
                type: "object.update",
                data: objectData
            })
            this.refresh();
        }
    },

    updateMeshMaterial: function (secret_key: any, meshName: any, material: any, materialIndex?: any) {
        var objectData = this.getObject(secret_key);
        var self = this;
        if (objectData && material && isObject(material)) {
            const isSn = isString(meshName);
            const isNi = isNumber(meshName);

            for (let index = 0; index < objectData.meshes.length; index++) {
                const mesh = objectData.meshes[index];
                if ((isNi && meshName == index) || (isSn && mesh.name == meshName)) {
                    if (isArray(mesh.material)) {
                        if (isNumber(materialIndex) && materialIndex >= 0) {
                            if (typeof mesh.material[materialIndex] != "undefined") {
                                if (material.type) {
                                    let updateType = Materials.parseType(material.type);
                                    let materialType = Materials.parseType(mesh.material[materialIndex].type);
                                    if (updateType != materialType) {
                                        mesh.material[materialIndex] = Materials.get(updateType, assignValue(Materials.getPropData(mesh.material[materialIndex]), assignWithout({}, material, ['type'])));
                                    }
                                    else {
                                        Materials.setProperties(mesh.material[materialIndex].type, mesh.material[materialIndex], material, () => self.refresh());
                                    }
                                }
                                else {
                                    Materials.setProperties(mesh.material[materialIndex].type, mesh.material[materialIndex], material, () => self.refresh());
                                }
                                break;
                            }

                        }
                        else {
                            if (material.type) {
                                let updateType = Materials.parseType(material.type);
                                let materialType = Materials.parseType(mesh.material[index].type);
                                if (updateType != materialType) {
                                    mesh.material[index] = Materials.get(updateType, assignValue(Materials.getPropData(mesh.material[index]), assignWithout({}, material, ['type'])));
                                }
                                else {
                                    Materials.setProperties(mesh.material[index].type, mesh.material[index], material, () => self.refresh());
                                }
                            }
                            else {
                                Materials.setProperties(mesh.material[index].type, mesh.material[index], material, () => self.refresh());
                            }
                        }
                    } else {

                        if (material.type) {
                            let updateType = Materials.parseType(material.type);
                            let materialType = Materials.parseType(mesh.material.type);
                            let m = assignWithout({}, material, ['type']);
                            if (updateType != materialType) {
                                mesh.material = Materials.get(updateType, assignValue(Materials.getPropData(mesh.material), m));
                            }
                            else {
                                Materials.setProperties(mesh.material.type, mesh.material, m, () => self.refresh());
                            }
                        }
                        else {
                            Materials.setProperties(mesh.material.type, mesh.material, material, () => self.refresh());
                        }

                    }
                    break;
                }

            }
        }
        self.refresh();
    },

    updateMeshesSettings: function updateMeshesSettings(secret_key: any, settings?: any, onlyProp?: string) {
        var objectData = this.getMesh(secret_key);
        var self = this;
        if (objectData && settings && isObject(settings)) {

            var settingData = assignValue({}, settings);
            var obj = objectData.object;
            if (isObject(settingData.props) && !isEmpty(settingData.props)) {
                var props = settingData.props;
                var cast = typeof props.castShadow == "boolean";
                var receive = typeof props.receiveShadow == "boolean";
                var ot = obj.type ? String(obj.type).toLowerCase() : "";
                if (cast || receive) {
                    if (obj.isMesh || ot == "mesh") {
                        if (cast) obj.castShadow = props.castShadow;
                        if (receive) obj.receiveShadow = props.receiveShadow;
                        self.Shadows.removeMesh(obj);
                    }

                    if (obj.traverse) {
                        obj.traverse(function (child) {
                            var ct = child.type ? String(child.type).toLowerCase() : "";
                            if (child.isMesh || ct == "mesh") {
                                if (cast) child.castShadow = props.castShadow;
                                if (receive) child.receiveShadow = props.receiveShadow;
                                self.Shadows.removeMesh(obj);
                            }
                        });
                    }

                }// end if cast shadow
                assignValue(obj, copyWithout(props, ['receiveShadow', 'castShadow']));

                this.dispatchEvent({
                    type: "object.update.props",
                    data: objectData
                });
            }// endd props
            if (settingData.geometry) {
                var geometry = Geometries.get(settingData.geometry);
                if (geometry) obj.geometry = geometry;
                this.dispatchEvent({
                    type: "object.update.geometry",
                    data: objectData
                });
            }
            if (settingData.material) {
                try {

                    if (isArray(obj.material)) {
                        if (isArray(settingData.material)) {
                            for (let i = 0; i < obj.material.length; i++) {
                                if (typeof settingData.material[i] != "undefined") {
                                    let material = assignWithout({}, settingData.material[i], ['type']);
                                    let type = settingData.material[i].type;
                                    if (type) {
                                        let updateType = Materials.parseType(type);
                                        let materialType = Materials.parseType(obj.material[i].type);
                                        if (updateType != materialType) {
                                            obj.material[i] = Materials.get(updateType, assignValue(Materials.getPropData(obj.material[i]), material));
                                        }
                                        else {
                                            Materials.setProperties(obj.material[i].type, obj.material[i], material, () => self.refresh(), true);
                                        }
                                    }
                                    else {
                                        Materials.setProperties(obj.material[i].type, obj.material[i], material, () => self.refresh(), true);
                                    }
                                }
                            }
                        }
                        else {
                            let material = assignWithout({}, settingData.material, ['type']);
                            let type = settingData.material.type;
                            for (let i = 0; i < obj.material.length; i++) {
                                if (type) {
                                    let updateType = Materials.parseType(type);
                                    let materialType = Materials.parseType(obj.material[i].type);
                                    if (updateType != materialType) {
                                        obj.material[i] = Materials.get(updateType, assignValue(Materials.getPropData(obj.material[i]), material));
                                    }
                                    else {
                                        Materials.setProperties(obj.material[i].type, obj.material[i], material, () => self.refresh(), true);
                                    }
                                }
                                else {
                                    Materials.setProperties(obj.material[i].type, obj.material[i], material, () => self.refresh(), true);
                                }
                            }

                        }
                    } else {

                        let material = assignWithout({}, settingData.material, ['type']);
                        let type = settingData.material.type;
                        if (type) {
                            let updateType = Materials.parseType(type);
                            let materialType = Materials.parseType(obj.material.type);
                            if (updateType != materialType) {
                                obj.material = Materials.get(updateType, assignValue(Materials.getPropData(obj.material), material));
                            }
                            else {
                                Materials.setProperties(obj.material.type, obj.material, material, () => self.refresh(), true);
                            }
                        }
                        else {
                            Materials.setProperties(obj.material.type, obj.material, material, () => self.refresh(), true);
                        }
                    }
                }
                catch (e) {
                    console.log(e);
                }

                this.dispatchEvent({
                    type: "object.update.material",
                    data: objectData
                });
            }

            obj.needsUpdate = true;

            self.refresh();
            this.dispatchEvent({
                type: "object.update",
                data: objectData
            })

        }
    },

    getObjectSize: function (secret_key: any) {
        let objectData = this.getObject(secret_key);
        if (!objectData) return null;
        let obj = objectData.object;
        var box = new THREE.Box3().setFromObject(obj);
        // box.getCenter(obj['position']); // this re-sets the mesh position
        const dimensions = new THREE.Vector3();
        var size: any = box.getSize(dimensions);
        return size;
    },

    getDownloadLinkElement: function () {
        if (!this.downloadLink) {
            const link = document.createElement('a');
            link.style.display = 'none';
            document.body.appendChild(link); // Firefox workaround, see #6594
            this.downloadLink = link;
        }
        return this.downloadLink;


    },

    downloadUrl: function (url?: string, filename?: string) {
        var link = this.getDownloadLinkElement();
        link.href = url;
        link.download = filename;
        link.click();
    },
    exportItemAsGltf: function (id: any, options?: any, callback?: (data: any) => any) {
        var self = this;
        var objectData = this.getObject(id);
        if (objectData) {

            const gltfExporter = new GLTFExporter();

            var opt = {
                trs: false,
                onlyVisible: true,
                truncateDrawRange: true,
                binary: false,
                maxTextureSize: Infinity // To prevent NaN value
            };
            assignValue(opt, options);
            gltfExporter.parse(objectData.raw, function (result) {

                if (typeof callback == "function") {
                    callback(result);
                }
                else if (result instanceof ArrayBuffer) {

                    self.saveArrayBuffer(result, 'scene.glb');

                } else {

                    const output = JSON.stringify(result, null, 2);
                    self.saveString(output, 'scene.gltf');

                }

            }, opt);




        }
    },
    save: function save(blob: any, filename?: string) {
        var url = window.URL || window.webkitURL;
        var link = url.createObjectURL(blob);
        this.downloadUrl(link, filename);


        // URL.revokeObjectURL( url ); breaks Firefox...

    },

    saveString: function (text: string, filename: string) {

        this.save(new Blob([text], { type: 'text/plain' }), filename);

    },


    saveArrayBuffer: function (buffer: any, filename: string) {

        this.save(new Blob([buffer], { type: 'application/octet-stream' }), filename);

    }
};

export default ObjectManager;
export { ObjectManager }