import { assignValue, assignWithout, isObject, objectHasKey } from "@app/_core/helpers/utils";
import { parseParams } from "../libs/props";
import { FloorDefaultData } from "../store/data.type";
import * as THREELibs from 'three';
const THREE = THREELibs;

export const Floor = {
    enableFloor: false,

    aboveFloor: false,

    dropbyPositionY: FloorDefaultData.props.position.y,


    floorSettings: {},

    floorObject: null,
    boots: ['bootFloor'],
    inits: ['initFloor'],
    bootFloor: function () {
        this.floorSettings = {}
    },
    initFloor: function () {
        // this.floorSettings = assignValue({}, FloorDefaultData);
        // assignValue(this.floorSettings, this.data.scene.floor);
        this.on("scene.inited", () => this.updateFloorSetting(this.data.scene.floor));
        var self = this;
        this.on("scene.settings.updated:floor", function (e) {
            self.updateFloorSetting(e.data);
        })
    },
    updateFloorSetting: function (setting) {
        if (objectHasKey(setting, 'enabled')) {
            this.enableFloor = setting.enabled;
        } else if (objectHasKey(setting, "above")) {
            this.aboveFloor = setting.above;
        }
        else if (objectHasKey(setting, "props")) {
            if (objectHasKey(setting, "position")) {
                this.dropbyPositionY = setting.props.position.y;
            }
        }

        assignValue(this.floorSettings, setting);

        this.updateFloorObject(this.floorSettings);
        
        this.updateGridHelper();

        // this.updateAxesHelper();

    },

    gridHelperObject: null,
    updateGridHelper: function () {
        if (this.env != "production") {
            if (this.gridHelperObject) {
                this.scene.remove(this.gridHelperObject)
            }

            if (!this.floorSettings.enableGrid) {
                return;
            }
            const size = this.floorSettings.params.width;
            const divisions = size < 10 ? 10 : size;

            const gridHelper = new THREE.GridHelper(size, divisions);
            gridHelper.position.y = this.floorSettings.props.position.y;
            this.gridHelperObject = gridHelper;

            this.scene.add(gridHelper);
            this.refresh();
        }
    },
    showGridHelper: function(){
        if (this.gridHelperObject) {
            this.scene.remove(this.gridHelperObject);
            this.scene.add(this.gridHelperObject);
        }
    },
    hideGridHelper: function(){
        if (this.gridHelperObject) {
            this.scene.remove(this.gridHelperObject);
        }
    },
    
    axesHelperObject: null,
    updateAxesHelper: function () {
        if (this.env != "production") {
            if (this.axesHelperObject) {
                this.scene.remove(this.axesHelperObject)
            }

            if (!this.floorSettings.enableAxes) {
                return;
            }
            let ss = this.sceneSettings.size;
            let min = ss.width;
            if (ss.height < min) min = ss.height;
            else if (ss.depth < min) min = ss.depth;

            const axesHelper = new THREE.AxesHelper(min / 10);
            axesHelper.position.y = this.floorSettings.props.position.y;;
            this.axesHelperObject = axesHelper;

            this.scene.add(axesHelper);


            this.refresh();
        }
    },

    showAxesHelper: function(){
        if (this.axesHelperObject) {
            this.scene.remove(this.axesHelperObject);
            this.scene.add(this.axesHelperObject);
        }
    },
    hideAxesHelper: function(){
        if (this.axesHelperObject) {
            this.scene.remove(this.axesHelperObject);
        }
    },
    updateFloorObject: function (setting) {
        let floorParams = {
            geometry: setting.params,
            material: setting.material,
            props: setting.props
        };
        if (!this.floorObject) {
            this.floorObject = this.Mesh.get(floorParams);
        }
        else {
            this.floorObject.copy(this.Mesh.get(floorParams));
        }
        if (setting.enabled) {
            if (this.floorObject && this.floorObject.isMesh) {
                this.floorObject.rotation.x = -Math.PI / 2;
                if (!this.floorObject.inScene) {
                    this.scene.add(this.floorObject);
                    this.floorObject.inScene = true;
                }
                this.refresh();
            }

        } else {
            if (this.floorObject && this.floorObject.isMesh && this.floorObject.inScene) {
                this.scene.remove(this.floorObject);
                this.floorObject.inScene = false;
                this.refresh();
            }
        }
    },







    floorStatus: false,

    __floorObject: null,
    addFloor: function (options: any) {
        var self = this;
        if (this.Loader.loadingCount) {
            this.on('model.load.success', function (data) {
                if (!self.Loader.loadingCount && !self.floorStatus) {
                    self.addFloor(options);
                }
            });
            return this;
        }
        this.floorStatus = true;
        var option = isObject(options) ? options : {};
        var params = parseParams(option.params || option, { type: "circle", radius : 0.5, segments : 50 });
        if (params.type == 'square') params.type = "planebuffer";

        if (!params.radius) params.radius = 0.5;


        var materialOptions = {
            type: "physical",
            params: {
                roughness: 0.8,
                color: "#d9d9d9",
                metalness: 0.2,
                bumpScale: 0.5
            },
            props: {
                transparent: true,
                opacity: 0.8,
                receiveShadow: true,
            }
        };
        assignValue(materialOptions, option.material);
        var props = assignWithout({}, option.props || option, ['rotation'], params);
        var sceneSize = this.getSceneSize();
        if (sceneSize.size.x/2 > params.radius) params.radius = sceneSize.size.x * 1.6;
        if (sceneSize.size.z/2 > params.radius) params.radius = sceneSize.size.z * 1.6;

        assignValue(props, {
            receiveShadow: true,
            position: {
                y: sceneSize.min.y - 0.001
            },
            rotation: {
                x: - Math.PI / 2
            }
        });

        this.addMesh({
            geometry: params,
            material: materialOptions,
            props: props
        }, function (object) {
            self.__floorObject = object;
        });
        // console.log(self.__floorObject);

        this.on('scene.size.get.begin', function () {
            if (self.floorStatus) {
                let index = this.objects.indexOf(self.__floorObject);
                if (index != -1) {
                    self.objects.splice(index, 1);
                }
                self.scene.remove(self.__floorObject.object);
            }
        })
        this.on('scene.size.get.end', function () {
            if (self.floorStatus && self.__floorObject) {
                self.scene.add(self.__floorObject.object);
                let index = self.objects.indexOf(self.__floorObject);
                if (index == -1) {
                    self.objects.push(self.__floorObject);
                }
            }
        })


    },

    updateFloor: function () {
        if (!this.__floorObject) {
            this.addFloor({});
        } else {
            var sceneSize = this.getSceneSize();
            assignValue(this.__floorObject.object, {
                position: {
                    y: sceneSize.min.y - 0.0001
                },
                rotation: {
                    x: - Math.PI / 2
                }
            });
            var params = this.__floorObject.object.geometry.parameters

            if (sceneSize.size.x/2 > params.radius) params.radius = sceneSize.size.x * 2;
            if (sceneSize.size.z/2 > params.radius) params.radius = sceneSize.size.z * 2;
            this.__floorObject.object.needsUpdate = true;

        }
        this.refresh();
    },

    removeFloor: function(){
        this.scene.remove(this.__floorObject.object);
    }
}