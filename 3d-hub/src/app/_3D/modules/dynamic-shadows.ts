import createClass, { _class } from '@app/_core/helpers/es5.class';
import * as THREE from 'three';

import { assignValue, inArray, isArray, isEmpty, isObject, isString, queueTask } from '@app/_core/helpers/utils';
import Props from '../libs/props';


const meshes = [];

const PLANE_WIDTH = 2.5;
const PLANE_HEIGHT = 2.5;
const CAMERA_HEIGHT = 2;

const state = {
    shadow: {
        blur: 3.5,
        darkness: 1,
        opacity: 1,
        pcss: true
    },
    plane: {
        color: '#ffffff',
        opacity: 1,
        position_x: 0,
        position_y: 0,
        position_z: 0,
        rotation_x: -Math.PI / 2,
        rotation_y: 0,
        rotation_z: 0
    },
    blur_plane: {
        position: {
            x: 0,
            y: 0,
            z: 0
        },
        rotation: {
            x: 0,
            y: 0,
            z: 0
        }



    },

    showWireframe: false,
    camera: {
        position_x: 0,
        position_y: 0,
        position_z: 0,
        rotation_x: Math.PI / 2,
        rotation_y: 0,
        rotation_z: 0,
        far: 2000
    },
    model: {
        position_x: 0,
        position_y: 0,
        position_z: 0,
        rotation_x: 0,
        rotation_y: 0,
        rotation_z: 0
    }
};




let originShader, isAssigned = false;
let deployed = false;
var _ShaderChunk = {};

if (!isAssigned) {
    isAssigned = true;
    originShader = THREE.ShaderChunk.shadowmap_pars_fragment + ``;
    _ShaderChunk = assignValue(_ShaderChunk, THREE.ShaderChunk);
}




const DynamicShadows = createClass('DynamicShadows')({
    /**
     * @property App
     */
    parent: null,
    origin: originShader,
    defaultProps: { frustrum: 3.75, size: 0.005, near: 9.5, samples: 17, rings: 11 },
    options: {},
    isActive: false,
    queueTask: null,
    shadowLights: {},
    lightShadowList: {},
    cloneLightShadowList: {},
    meshes: {},

    type: "no",
    shader: "",
    boots: ["bootstrap"],
    bootstrap: function(){
        this.options = {};
        this.isActive = false;
        this.queueTask = null;
        this.shadowLights = {};
        this.lightShadowList = {};
        this.cloneLightShadowList = {};
        this.meshes = {};
    
    },
    constructor: function (parent, options) {
        this.parent = parent;
        if (isObject(options)) {
            this.options = options;
            this.defaultProps = Props.parseParams(options.data || options, this.defaultProps);
        }
    },

    init: function () {
        var self = this;
        if (this.options.pcss || (this.options.type == 'pcss' && this.options.active)) {
            self.pcssInit();
        }

    },




    pcssInit: function () {
        var self = this;
        self.type = 'pcss';
        self.active();
        // return false;
        if (self.parent.lights && self.parent.lights.length) {
            self.active();
            // self.cloneLightShadows();
            // self.active();
            // self.refreshShadows();
        } else {
            self.parent.on('setdata', () => {
                if (self.parent.lights && self.parent.lights.length) {
                    // self.cloneLightShadows();
                    self.active();
                    // self.refreshShadows();
                }
            })
        }


    },

    turnOffPcss: function () {
        var self = this;
        if (self.isActive) {
            self.deactive();
            this.type = "no";
            self.refreshShadows();

            // self.setAllLightProps({ castShadow: false, intensity: 0, visible: false });
            // self.setCloneLightIntensityNyReference();
        }
    },
    turnOnPcss: function () {
        var self: any = this;
        if (!state.shadow.pcss) return false;
        this.type = "pcss";
        self.active();
        if (self.isActive) {
            self.refreshShadows();
            var light_intensity = 1;
            var clone_intensity = 0;
        }
    },

    active: function (args: any = undefined) {
        if (this.isActive || deployed) return this;
        var self = this;
        var defaultProps = this.defaultProps;
        var params = assignValue({}, defaultProps);
        if (isObject(args)) {
            params = Props.parseParams(args, defaultProps);
        } else if (arguments.length) {
            args = [];
            for (let index = 0; index < arguments.length; index++) {
                const element = arguments[index];
                args[index] = element;
            }
            params = Props.parseParams(args, defaultProps);
        }


        this.isActive = true;
        deployed = true;
        let shader = this.shader;
        if (!this.shader) {
            shader = this.origin + "";
            let pcss = this.getPCSS(params);


            shader = shader.replace(
                '#ifdef USE_SHADOWMAP',
                '#ifdef USE_SHADOWMAP' +
                pcss
            );

            shader = shader.replace(
                '#if defined( SHADOWMAP_TYPE_PCF )',
                `            
			return PCSS( shadowMap, shadowCoord );

            ` +
                '#if defined( SHADOWMAP_TYPE_PCF )'
            );


            this.shader = shader;
        }

        THREE.ShaderChunk.shadowmap_pars_fragment = shader;

        // self.refreshShadows();
        return this;
    },
    deactive: function () {
        if (!this.isActive || !deployed) return this;
        var self = this;
        THREE.ShaderChunk.shadowmap_pars_fragment = this.origin;
        deployed = false;
        this.isActive = false;
        // self.refreshShadows();

        return this;
    },


    addMesh: function (object: any = undefined) {
        if ((typeof this.meshes[object.id] === "undefined" || !this.meshes[object.id]) && (object.castShadow || object.receiveShadow)) {
            this.meshes[object.id] = {
                castShadow: object.castShadow,
                receiveShadow: object.receiveShadow
            };
        }
        return object;
    },

    removeMesh: function (object) {
        var id = isObject(object) ? object.id : object;
        if (typeof this.meshes[id] != "undefined") {
            this.meshes[id] = null;
            delete this.meshes[id];
        }

    },

    cloneLightShadows: function () {
        var scope = this;
        if (!scope.parent) return false;
        // for (const id in scope.parent.l) {
        //     if (Object.hasOwnProperty.call(scope.parent.objects, id)) {
        //         if (scope.parent.objects[id].type == 'light') {
        //             if (scope.parent.objects[id].object.castShadow == true) {
        //                 if (typeof scope.lightShadowList[id] == "undefined") {
        //                     scope.lightShadowList[id] = scope.parent.objects[id].object.intensity;
        //                 }
        //                 const light = scope.parent.objects[id].object.clone(true);
        //                 light.intensity = 0;
        //                 const sid = scope.parent.addToScene({
        //                     $type: "light",
        //                     object: light
        //                 });
        //                 if (sid) {
        //                     scope.cloneLightShadowList[id] = sid;
        //                 }
        //             }
        //         }
        //     }
        // }
    },

    /**
     * thay doi thuoc tinh
     * @param {string|object} prop thuoc tinh
     * @param {*} val 
     */

    setAllLightProps: function (prop, val) {
        var scope = this;
        if (prop) {
            var props = {};
            if (isString(prop)) props[prop] = val;
            else if (isObject(prop)) props = prop;
            else return null;
            if (!isEmpty(scope.lightShadowList)) {
                for (const id in scope.lightShadowList) {
                    if (Object.hasOwnProperty.call(scope.lightShadowList, id)) {

                        const intensity = scope.lightShadowList[id];
                        if (typeof scope.parent.objects[id] != "undefined") {
                            if (scope.parent.objects[id].type == "light") {

                                assignValue(scope.parent.objects[id].object, props);
                            }
                        }
                    }
                }
            }
        }
    },



    /**
     * thay doi thuoc tinh
     * @param {string|object} prop thuoc tinh
     * @param {*} val 
     */

    setAllCloneLightProps: function (prop, val) {
        var scope = this;
        if (prop && !isEmpty(scope.cloneLightShadowList)) {
            var props = {};
            if (isString(prop)) props[prop] = val;
            else if (isObject(prop)) props = prop;
            else return null;
            for (const lightID in scope.cloneLightShadowList) {
                if (Object.hasOwnProperty.call(scope.cloneLightShadowList, lightID)) {
                    const cloneLightID = scope.cloneLightShadowList[lightID];
                    if (typeof scope.parent.objects[cloneLightID] != "undefined" && scope.parent.objects[cloneLightID].type == "light") {
                        assignValue(scope.parent.objects[cloneLightID].object, props);
                    }
                }
            }
        }
    },


    /**
     * thiết lập cường độ ánh sáng cho tất cả ánh sáng đổ bóng
     * @param {float} percentage phần trăn cường độ ánh sáng
     */
    setAllLightIntensityNyPercentage: function (percentage) {
        var scope = this;
        if (!isEmpty(scope.lightShadowList)) {
            for (const id in scope.lightShadowList) {
                if (Object.hasOwnProperty.call(scope.lightShadowList, id)) {
                    const intensity = scope.lightShadowList[id];

                    if (typeof scope.parent.objects[id] != "undefined") {
                        if (scope.parent.objects[id].type == "light") {
                            const pc = intensity * percentage;
                            scope.parent.objects[id].object.intensity = pc;
                        }
                    }
                }
            }
        }
    },


    /**
     * thay doi thuoc tinh
     * @param {string|object} prop thuoc tinh
     * @param {*} val 
     */

    setCloneLightIntensityNyPercentage: function (percentage, visible) {
        var scope = this;

        if (!isEmpty(scope.lightShadowList)) {
            for (const id in scope.lightShadowList) {
                if (Object.hasOwnProperty.call(scope.lightShadowList, id) && Object.hasOwnProperty.call(scope.cloneLightShadowList, id)) {
                    const intensity = scope.lightShadowList[id];
                    const cloneLightID = scope.cloneLightShadowList[id];
                    if (typeof scope.parent.objects[cloneLightID] != "undefined" && scope.parent.objects[cloneLightID].type == "light") {
                        scope.parent.objects[cloneLightID].object.intensity = intensity * percentage;
                        if (typeof visible == "boolean") scope.parent.objects[cloneLightID].object.visible = visible;
                    }

                }
            }
        }

    },


    updateLightShadows: function () {
        var scope = this;

        if (scope.parent.lights) {
            scope.parent.lights.map(function (lightData) {
                var object = lightData.object;
                if (object.isLight && (object.isDirectionalLight || object.isPointLight || object.isSpotLight)) {
                    if (typeof scope.shadowLights[object.id] === "undefined" && object.castShadow) {
                        scope.shadowLights[object.id] = object.castShadow;
                    }
                }
            })
        }

    },
    updateMeshShadows: function () {
        var scope = this;
        if (scope.parent.objects) {
            scope.parent.objects.map(function (objectDAta) {
                if (objectDAta.type == "mesh") {
                    var object = objectDAta.object;
                    scope.addMesh(object);
                } else if (objectDAta.meshes) {
                    objectDAta.meshes.map(function (object) {
                        scope.addMesh(object);
                    })
                }

            })
        }
    },

    off: function () {
        if (this.parent) {
            var scope = this;
            this.parent.renderer.shadowMap.enabled = false;
            // if(this.type=="pcss") this.deactive();
            if (this.type == 'pcss') {
                if (scope.parent.lights) {
                    scope.parent.lights.map(function (lightData) {
                        var object = lightData.object;
                        if (object.isLight && (object.isDirectionalLight || object.isPointLight || object.isSpotLight)) {
                            if (typeof scope.shadowLights[object.id] !== "boolean" && object.castShadow) {
                                scope.shadowLights[object.id] = object.castShadow;
                            }
                            object.castShadow = false;
                            object.needsUpdate = true;
                        }
                    });

                }
            }

            if (scope.parent.objects) {
                scope.parent.objects.map(function (objectDAta) {
                    if (objectDAta.type == "mesh") {
                        var object = objectDAta.object;
                        var o = scope.addMesh(object);
                        o.castShadow = false;
                        o.receiveShadow = false;
                        o.needsUpdate = true;

                    } else if (objectDAta.meshes) {
                        objectDAta.meshes.map(function (object) {
                            var o = scope.addMesh(object);
                            o.castShadow = false;
                            o.receiveShadow = false;
                            o.needsUpdate = true;
                        })
                    }

                })
            }
            if (scope.parent.floorObject && scope.parent.floorObject.isMesh && scope.parent.floorObject.inScene) {
                var o = scope.addMesh(scope.parent.floorObject);
                o.castShadow = false;
                o.receiveShadow = false;
                o.needsUpdate = true;
            }


        }
    },

    restore: function () {
        if (this.parent) {
            var scope = this;
            this.parent.renderer.shadowMap.enabled = true;
            // if(this.type=="pcss") this.active();
            if (this.type == 'pcss') {
                if (scope.parent.lights) {
                    scope.parent.lights.map(function (lightData) {
                        var object = lightData.object;
                        if (object.isLight && (object.isDirectionalLight || object.isPointLight || object.isSpotLight)) {
                            if (typeof scope.shadowLights[object.id] === "boolean") {
                                object.castShadow = scope.shadowLights[object.id];
                                object.needsUpdate = true;
                                scope.shadowLights[object.id] = null;
                                delete scope.shadowLights[object.id];
                            }

                        }
                    });

                }
            }


            if (scope.parent.objects) {
                scope.parent.objects.map(function (objectDAta) {
                    if (objectDAta.type == "mesh") {
                        var object = objectDAta.object;
                        var o = scope.addMesh(object);
                        if(typeof scope.meshes[o.id] != "undefined"){
                            object.castShadow = scope.meshes[o.id].castShadow;
                            object.receiveShadow = scope.meshes[o.id].receiveShadow;
                            object.needsUpdate = true;
                            delete scope.meshes[o.id];
                        }
                        

                    } else if (objectDAta.meshes) {
                        objectDAta.meshes.map(function (object) {
                            var o = scope.addMesh(object);
                            if (typeof scope.meshes[o.id] != "undefined" && scope.meshes[o.id]) {
                                object.castShadow = scope.meshes[o.id].castShadow;
                                object.receiveShadow = scope.meshes[o.id].receiveShadow;
                                object.needsUpdate = true;
                                scope.meshes[o.id] = null;
                                delete scope.meshes[o.id];
                            }

                        })
                    }

                })
            }
            if (scope.parent.floorObject && scope.parent.floorObject.isMesh) {
                var o = scope.addMesh(scope.parent.floorObject);

                o.castShadow = scope.meshes[o.id].castShadow;
                o.receiveShadow = scope.meshes[o.id].receiveShadow;
                o.needsUpdate = true;
                delete scope.meshes[o.id];
            }

        }
    },

    refreshShadows: function () {
        var self = this;
        var _parent = self.parent;
        self.off();
        if (_parent) {
            _parent.refresh();
        }
        self.restore();

    },


    updateShaderChunk: function () {
        var list = ['shadowmap_pars_fragment', 'meshlambert_frag', 'meshtoon_frag', 'meshphong_frag', 'meshphysical_frag', 'shadow_frag'];
        var updateList = {
            basic: ["meshbasic_vert", "meshbasic_frag"],
            lambert: ["meshlambert_vert", "meshlambert_frag"],
            phong: ["meshphong_vert", "meshphong_frag"],
            standard: ["meshphysical_vert", "meshphysical_frag"],
            toon: ["meshtoon_vert", "meshtoon_frag"],
            matcap: ["meshmatcap_vert", "meshmatcap_frag"],
            points: ["points_vert", "points_frag"],
            dashed: ["linedashed_vert", "linedashed_frag"],
            depth: ["depth_vert", "depth_frag"],
            normal: ["normal_vert", "normal_frag"],
            sprite: ["sprite_vert", "sprite_frag"],
            background: ["background_vert", "background_frag"],
            /* -------------------------------------------------------------------------
            //	Cube map shader
             ------------------------------------------------------------------------- */
            cube: ["cube_vert", "cube_frag"],
            equirect: ["equirect_vert", "equirect_frag"],
            distanceRGBA: ["distanceRGBA_vert", "distanceRGBA_frag"],
            shadow: ["shadow_vert", "shadow_frag"],
            physical: ["meshphysical_vert", "meshphysical_frag"]

        }
        for (const key in updateList) {
            if (Object.hasOwnProperty.call(updateList, key)) {
                const keyArr = updateList[key];
                THREE.ShaderLib[key].vertexShader = THREE.ShaderChunk[keyArr[0]];
                THREE.ShaderLib[key].fragmentShader = THREE.ShaderChunk[keyArr[0]];

            }
        }

    },

    updateAllMaterial: function () {
        var self = this;
        const setMaterialNeedsUpdate = material => {
            if (isArray(material)) {
                for (let index = 0; index < material.length; index++) {
                    const mat = material[index];
                    setMaterialNeedsUpdate(mat);
                }
            } else if (isObject(material)) {
                material.needsUpdate = true;
            }
        };
        if (this.parent.objects) {

            for (const a in this.parent.objects) {
                if (Object.hasOwnProperty.call(this.parent.objects, a)) {
                    const obj = this.parent.objects[a];
                    if (obj.meshes) {
                        for (const b in obj.meshes) {
                            if (Object.hasOwnProperty.call(obj.meshes, b)) {
                                const mesh = obj.meshes[b];
                                setMaterialNeedsUpdate(mesh.material);
                            }
                        }
                    }
                }
            }
        }
    },


    getCurrentFragment: function () {
        return THREE.ShaderChunk.shadowmap_pars_fragment;
    },
    getPCSS: function (args) {
        var defaultProps = this.defaultProps;
        var params = assignValue({}, defaultProps);
        if (isObject(args)) {
            params = Props.parseParams(args, defaultProps);
        } else if (arguments.length) {
            args = [];
            for (let index = 0; index < arguments.length; index++) {
                const element = arguments[index];
                args[index] = element;
            }
            params = Props.parseParams(args, defaultProps);
        }
        var frustrum = params.frustrum,
            size = params.size,
            near = params.near,
            samples = params.samples,
            rings = params.rings;

        return `
        
				#define LIGHT_WORLD_SIZE 0.005
				#define LIGHT_FRUSTUM_WIDTH 3.75
				#define LIGHT_SIZE_UV (LIGHT_WORLD_SIZE / LIGHT_FRUSTUM_WIDTH)
				#define NEAR_PLANE 9.5

				#define NUM_SAMPLES 17
				#define NUM_RINGS 11
				#define BLOCKER_SEARCH_NUM_SAMPLES NUM_SAMPLES
				#define PCF_NUM_SAMPLES NUM_SAMPLES

				vec2 poissonDisk[NUM_SAMPLES];

				void initPoissonSamples( const in vec2 randomSeed ) {
					float ANGLE_STEP = PI2 * float( NUM_RINGS ) / float( NUM_SAMPLES );
					float INV_NUM_SAMPLES = 1.0 / float( NUM_SAMPLES );

					// jsfiddle that shows sample pattern: https://jsfiddle.net/a16ff1p7/
					float angle = rand( randomSeed ) * PI2;
					float radius = INV_NUM_SAMPLES;
					float radiusStep = radius;

					for( int i = 0; i < NUM_SAMPLES; i ++ ) {
						poissonDisk[i] = vec2( cos( angle ), sin( angle ) ) * pow( radius, 0.75 );
						radius += radiusStep;
						angle += ANGLE_STEP;
					}
				}

				float penumbraSize( const in float zReceiver, const in float zBlocker ) { // Parallel plane estimation
					return (zReceiver - zBlocker) / zBlocker;
				}

				float findBlocker( sampler2D shadowMap, const in vec2 uv, const in float zReceiver ) {
					// This uses similar triangles to compute what
					// area of the shadow map we should search
					float searchRadius = LIGHT_SIZE_UV * ( zReceiver - NEAR_PLANE ) / zReceiver;
					float blockerDepthSum = 0.0;
					int numBlockers = 0;

					for( int i = 0; i < BLOCKER_SEARCH_NUM_SAMPLES; i++ ) {
						float shadowMapDepth = unpackRGBAToDepth(texture2D(shadowMap, uv + poissonDisk[i] * searchRadius));
						if ( shadowMapDepth < zReceiver ) {
							blockerDepthSum += shadowMapDepth;
							numBlockers ++;
						}
					}

					if( numBlockers == 0 ) return -1.0;

					return blockerDepthSum / float( numBlockers );
				}

				float PCF_Filter(sampler2D shadowMap, vec2 uv, float zReceiver, float filterRadius ) {
					float sum = 0.0;
					for( int i = 0; i < PCF_NUM_SAMPLES; i ++ ) {
						float depth = unpackRGBAToDepth( texture2D( shadowMap, uv + poissonDisk[ i ] * filterRadius ) );
						if( zReceiver <= depth ) sum += 1.0;
					}
					for( int i = 0; i < PCF_NUM_SAMPLES; i ++ ) {
						float depth = unpackRGBAToDepth( texture2D( shadowMap, uv + -poissonDisk[ i ].yx * filterRadius ) );
						if( zReceiver <= depth ) sum += 1.0;
					}
					return sum / ( 2.0 * float( PCF_NUM_SAMPLES ) );
				}

				float PCSS ( sampler2D shadowMap, vec4 coords ) {
					vec2 uv = coords.xy;
					float zReceiver = coords.z; // Assumed to be eye-space z in this code

					initPoissonSamples( uv );
					// STEP 1: blocker search
					float avgBlockerDepth = findBlocker( shadowMap, uv, zReceiver );

					//There are no occluders so early out (this saves filtering)
					if( avgBlockerDepth == -1.0 ) return 1.0;

					// STEP 2: penumbra size
					float penumbraRatio = penumbraSize( zReceiver, avgBlockerDepth );
					float filterRadius = penumbraRatio * LIGHT_SIZE_UV * NEAR_PLANE / zReceiver;

					// STEP 3: filtering
					//return avgBlockerDepth;
					return PCF_Filter( shadowMap, uv, zReceiver, filterRadius );
				}

        `;
    }
});
export default DynamicShadows;
export { DynamicShadows };