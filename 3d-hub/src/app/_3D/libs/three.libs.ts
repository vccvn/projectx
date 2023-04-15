import {
    arrayJoin,
    assignValue,
    assignWithout,
    checkType,
    copyWithout,
    cutWithout,
    getInputCfg,
    getObjectPropDepth,
    getType,
    inArray,
    isArray,
    isEmpty,
    isFunction,
    isInteger,
    isNumber,
    isObject,
    isString,
    newObj,
    objectHasKey,
    Str,
    _defineProperties
} from '@app/_core/helpers/utils';
// import { assignValue, assignWithout, isArray, isObject, isString, Str } from '@app/_core/helpers/utils';

import * as THREELibs from 'three';
const THREE = THREELibs;
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader.js';
import { RoughnessMipmapper } from 'three/examples/jsm/utils/RoughnessMipmapper.js';
import { OBJLoader } from 'three/examples/jsm/loaders/OBJLoader.js';
import { MTLLoader } from 'three/examples/jsm/loaders/MTLLoader.js';
import { FBXLoader } from 'three/examples/jsm/loaders/FBXLoader.js';
import { TDSLoader } from 'three/examples/jsm/loaders/TDSLoader.js';
import { STLLoader } from 'three/examples/jsm/loaders/STLLoader.js';
import { SVGLoader } from 'three/examples/jsm/loaders/SVGLoader.js';
import { RGBELoader } from 'three/examples/jsm/loaders/RGBELoader.js';
import { getConfig } from '@app/_core/config';
import { _Geometry, _Materials } from '../store/docs.js';

const Geometries: _Geometry = {} as _Geometry, Materials: _Materials = {} as _Materials, Meshes: any = {}, LoaderLib: any = {}, LightLib: any = {};






Object.assign(Geometries, {
    getGeometry: function (type?: any, args?: any) {
        var t, a = {};
        if (isObject(type)) {
            if (!type.type) return null;
            t = String(type.type).toLowerCase();
            assignWithout(a, type.params || type, ['type']);
        }
        else if (isString(type)) {
            t = String(type).toLowerCase();
            if (isObject(args)) {
                a = args;
            }
        }
        t = Str.replace(t, 'geometry', '');
        if (typeof this[t] == "function") {
            Props.parse(a);
            // console.log(type, args)
            return this[t].call(this, a);
        }
        return null;
    },
    get: function (type?: any, args?: any) {
        return this.getGeometry(type, args)
    },
    boxbuffer: function (args?: any) {
        var params = parseParams(args, {
            width: 1, height: 1, depth: 1, widthSegments: undefined, heightSegments: undefined, depthSegments: undefined
        });
        var geo = new THREE.BoxBufferGeometry(params.width, params.height, params.depth, params.widthSegments, params.heightSegments, params.depthSegments);
        // geo._params = params;
        return geo;
    },
    box: function (args?: any) {
        var params = parseParams(args, {
            width: 1,
            height: 1,
            depth: 1,
            widthSegments: undefined,
            heightSegments: undefined,
            depthSegments: undefined
        });

        // console.log(args)

        // console.log(params)
        var geo = new THREE.BoxGeometry(params.width, params.height, params.depth, params.widthSegments, params.heightSegments, params.depthSegments);
        // geo._params = params;
        return geo;
    },
    circlebuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, segments: 8, thetaStart: undefined, thetaLength: undefined
        });
        var geo = new THREE.CircleBufferGeometry(params.radius, params.segments, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },

    circle: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, segments: 8, thetaStart: undefined, thetaLength: undefined
        });
        var geo = new THREE.CircleGeometry(params.radius, params.segments, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    conebuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, height: 1, radialSegments: 8, heightSegments: undefined, openEnded: undefined, thetaStart: undefined, thetaLength: undefined
        });
        var geo = new THREE.ConeBufferGeometry(params.radius, params.height, params.radialSegments, params.heightSegments, params.openEnded, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    cone: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, height: 1, radialSegments: 8, heightSegments: undefined, openEnded: undefined, thetaStart: undefined, thetaLength: undefined
        });
        var geo = new THREE.ConeGeometry(params.radius, params.height, params.radialSegments, params.heightSegments, params.openEnded, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    cylinderbuffer: function (args?: any) {
        var params = parseParams(args, {
            radiusTop: 1, radiusBottom: 1, height: 1, radialSegments: 8, heightSegments: 1, openEnded: undefined, thetaStart: undefined, thetaLength: undefined
        });
        var geo = new THREE.CylinderBufferGeometry(params.radiusTop, params.radiusBottom, params.height, params.radialSegments, params.heightSegments, params.openEnded, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    cylinder: function (args?: any) {
        var params = parseParams(args, {
            radiusTop: 1, radiusBottom: 1, height: 1, radialSegments: 8, heightSegments: 1, openEnded: undefined, thetaStart: undefined, thetaLength: undefined
        });
        var geo = new THREE.CylinderGeometry(params.radiusTop, params.radiusBottom, params.height, params.radialSegments, params.heightSegments, params.openEnded, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    dodecahedronbuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.DodecahedronBufferGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },
    dodecahedron: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.DodecahedronGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },
    edges: function (args?: any) {
        var params = parseParams(args, {
            geometry: null, thresholdAngle: 1
        });
        if (params.geometry && typeof params.geometry == "object") {
            if (params.geometry.type && (params.geometry.params || params.geometry.args)) {
                var geometry = this.getGeometry(params.geometry.type, params.geometry.params || params.geometry.args);
                if (geometry) {
                    var geo = new THREE.EdgesGeometry(geometry, params.thresholdAngle);
                    // geo.___params = params;
                    return geo;
                }
            }
        }
        return null;
    },
    extrudebuffer: function (args?: any) {
        var params = parseParams(args, {
            shape: null, options: {}
        });
        if (params.shape && isArray(params.shape) && params.shape.length) {
            var shape = new THREE.Shape();
            var p0 = params.shape[0];
            if (isArray(p0)) {
                shape.moveTo(p0[0] !== undefined ? p0[0] : 0, p0[1] !== undefined ? p0[1] : 0);
            }
            else if (isObject(p0)) {
                shape.moveTo(p0.x !== undefined ? p0.x : 0, p0.y !== undefined ? p0.y : 0)
            } else {
                shape.moveTo(0, 0);
            }

            for (let i = 1; i < params.shape.length; i++) {
                const point = params.shape[i];
                if (isArray(point)) {
                    shape.lineTo(point[0] !== undefined ? point[0] : 0, point[1] !== undefined ? point[1] : 0);
                }
                else if (isObject(point)) {
                    shape.lineTo(point.x !== undefined ? point.x : 0, point.y !== undefined ? point.y : 0)
                }
            }
            var geo = new THREE.ExtrudeBufferGeometry(shape, params.options);
            // geo.___params = params;
            return geo;
        }
        return null;
    },
    extrude: function (args?: any) {
        var params = parseParams(args, {
            shape: null, options: {}
        });
        if (params.shape && isArray(params.shape)) {
            var shape = new THREE.Shape();
            var p0 = params.shape[0];
            if (isArray(p0)) {
                shape.moveTo(p0[0] !== undefined ? p0[0] : 0, p0[1] !== undefined ? p0[1] : 0);
            }
            else if (isObject(p0)) {
                shape.moveTo(p0.x !== undefined ? p0.x : 0, p0.y !== undefined ? p0.y : 0)
            } else {
                shape.moveTo(0, 0);
            }

            for (let i = 1; i < params.shape.length; i++) {
                const point = params.shape[i];
                if (isArray(point)) {
                    shape.lineTo(point[0] !== undefined ? point[0] : 0, point[1] !== undefined ? point[1] : 0);
                }
                else if (isObject(point)) {
                    shape.lineTo(point.x !== undefined ? point.x : 0, point.y !== undefined ? point.y : 0)
                }
            }
            var geo = new THREE.ExtrudeGeometry(shape, params.options);
            // geo.___params = params;
            return geo;
        }
        return null;
    },
    icosahedronbuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.IcosahedronBufferGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },
    icosahedron: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.IcosahedronGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },
    octahedronbuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.OctahedronBufferGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },
    octahedron: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.OctahedronGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },

    planebuffer: function (args?: any) {
        var params = parseParams(args, {
            width: 1, height: 1, widthSegments: 1, heightSegments: 1
        });
        var geo = new THREE.PlaneBufferGeometry(params.width, params.height, params.widthSegments, params.heightSegments);
        // geo.___params = params;
        return geo;
    },
    plane: function (args?: any) {
        var params = parseParams(args, {
            width: 1, height: 1, widthSegments: 1, heightSegments: 1
        });
        var geo = new THREE.PlaneGeometry(params.width, params.height, params.widthSegments, params.heightSegments);
        // geo.___params = params;
        return geo;
    },
    ringbuffer: function (args?: any) {
        var params = parseParams(args, {
            innerRadius: 0.5, outerRadius: 1, thetaSegments: 8, phiSegments: 1, thetaStart: 0, thetaLength: Math.PI * 2
        });
        var geo = new THREE.RingBufferGeometry(params.innerRadius, params.outerRadius, params.thetaSegments, params.phiSegments, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    ring: function (args?: any) {
        var params = parseParams(args, {
            innerRadius: 0.5, outerRadius: 1, thetaSegments: 8, phiSegments: 1, thetaStart: 0, thetaLength: Math.PI * 2
        });
        var geo = new THREE.RingGeometry(params.innerRadius, params.outerRadius, params.thetaSegments, params.phiSegments, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    shape: function (args?: any) {
        var params = parseParams(args, {
            points: [], curveSegments: 12
        });
        var shape = new THREE.Shape();
        var p0 = params.shape[0];
        if (isArray(p0)) {
            shape.moveTo(p0[0] !== undefined ? p0[0] : 0, p0[1] !== undefined ? p0[1] : 0);
        }
        else if (isObject(p0)) {
            shape.moveTo(p0.x !== undefined ? p0.x : 0, p0.y !== undefined ? p0.y : 0)
        } else {
            shape.moveTo(0, 0);
        }

        for (let i = 1; i < params.shape.length; i++) {
            const point = params.shape[i];
            if (isArray(point)) {
                shape.lineTo(point[0] !== undefined ? point[0] : 0, point[1] !== undefined ? point[1] : 0);
            }
            else if (isObject(point)) {
                shape.lineTo(point.x !== undefined ? point.x : 0, point.y !== undefined ? point.y : 0)
            }
        }

        var geo = new THREE.ShapeGeometry(shape, params.curveSegments);
        // geo.___params = params;
        return geo;
    },
    shapebuffer: function (args?: any) {
        var params = parseParams(args, {
            points: [], curveSegments: 12
        });
        var shape = new THREE.Shape();
        var p0 = params.shape[0];
        if (isArray(p0)) {
            shape.moveTo(p0[0] !== undefined ? p0[0] : 0, p0[1] !== undefined ? p0[1] : 0);
        }
        else if (isObject(p0)) {
            shape.moveTo(p0.x !== undefined ? p0.x : 0, p0.y !== undefined ? p0.y : 0)
        } else {
            shape.moveTo(0, 0);
        }

        for (let i = 1; i < params.shape.length; i++) {
            const point = params.shape[i];
            if (isArray(point)) {
                shape.lineTo(point[0] !== undefined ? point[0] : 0, point[1] !== undefined ? point[1] : 0);
            }
            else if (isObject(point)) {
                shape.lineTo(point.x !== undefined ? point.x : 0, point.y !== undefined ? point.y : 0)
            }
        }

        var geo = new THREE.ShapeBufferGeometry(shape, params.curveSegments);
        // geo.___params = params;
        return geo;
    },
    spherebuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, widthSegments: 8, heightSegments: 8, phiStart: 0, phiLength: Math.PI * 2, thetaStart: 0, thetaLength: Math.PI
        });
        var geo = new THREE.SphereBufferGeometry(params.radius, params.widthSegments, params.heightSegments, params.phiStart, params.phiLength, params.thetaStart, params.thetaLength);
        // geo.___params = params;
        return geo;
    },
    sphere: function (args?: any) {
        var params = parseParams(args, {
            radius: undefined, widthSegments: undefined, heightSegments: undefined, phiStart: undefined, phiLength: undefined, thetaStart: undefined, thetaLength: undefined
        });
        var geo = new THREE.SphereGeometry(params.radius, params.widthSegments, params.heightSegments, params.phiStart, params.phiLength, params.thetaStart, params.thetaLength);
        // geo.___params = params;

        return geo;
    },
    tetrahedronbuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.TetrahedronBufferGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },
    tetrahedron: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, detail: 0
        });
        var geo = new THREE.TetrahedronGeometry(params.radius, params.detail);
        // geo.___params = params;
        return geo;
    },
    textbuffer: function (args?: any) {
        var params = parseParams(args, {
            text: "", font: null, options: {}
        });
        var geo = new THREE.TextBufferGeometry(params.text, Object.assign({
            font: params.font,
            size: 80,
            height: 5,
            curveSegments: 12,
            bevelEnabled: true,
            bevelThickness: 10,
            bevelSize: 8,
            bevelOffset: 0,
            bevelSegments: 5
        }, params.options));
        // geo.___params = params;
        return geo;
    },
    text: function (args?: any) {
        var params = parseParams(args, {
            text: "", font: null, options: {}
        });
        var geo = new THREE.TextGeometry(params.text, Object.assign({
            font: params.font,
            size: 80,
            height: 5,
            curveSegments: 12,
            bevelEnabled: true,
            bevelThickness: 10,
            bevelSize: 8,
            bevelOffset: 0,
            bevelSegments: 5
        }, params.options));
        // geo.___params = params;
        return geo;
    },
    torusbuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, tube: 0.4, radialSegments: 8, tubularSegments: 6, arc: Math.PI * 2
        });
        var geo = new THREE.TorusBufferGeometry(params.radius, params.tobe, params.radialSegments, params.tubularSegments, params.arc);
        // geo.___params = params;
        return geo;
    },
    torus: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, tube: 0.4, radialSegments: 8, tubularSegments: 6, arc: Math.PI * 2
        });
        var geo = new THREE.TorusGeometry(params.radius, params.tobe, params.radialSegments, params.tubularSegments, params.arc);
        // geo.___params = params;
        return geo;
    },
    torusknotbuffer: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, tube: 0.4, tubularSegments: 64, radialSegments: 8, p: 2, q: 3
        });
        var geo = new THREE.TorusKnotBufferGeometry(params.radius, params.tobe, params.tubularSegments, params.radialSegments, params.p, params.q);
        // geo.___params = params;
        return geo;
    },
    torusknot: function (args?: any) {
        var params = parseParams(args, {
            radius: 1, tube: 0.4, tubularSegments: 64, radialSegments: 8, p: 2, q: 3
        });
        var geo = new THREE.TorusKnotGeometry(params.radius, params.tobe, params.tubularSegments, params.radialSegments, params.p, params.q);
        // geo.___params = params;
        return geo;
    },

    getConfig: function (key?: any) {
        if (!key) return this.config.instances;
        if (!isString(key)) return {};
        var k = Str.replace(String(key).toLowerCase(), 'geometry', '');
        var cfg = this.config.instances[k];
        return cfg ? cfg : {};

    },


    config: {
        instances: {
            box: {
                params: {
                    width: "float",
                    height: "float",
                    depth: "float",
                    widthSegments: "integer",
                    heightSegments: "integer",
                    depthSegments: "integer"
                },
                props: {},
                data: {
                    params: {
                        width: 1, height: 1, depth: 1, widthSegments: undefined, heightSegments: undefined, depthSegments: undefined
                    }
                }
            },
            sphere: {
                params: {
                    radius: "float", widthSegments: "integer", heightSegments: "integer", phiStart: "float", phiLength: "float", thetaStart: "float", thetaLength: "float"
                },
                props: {},
                data: {
                    params: {
                        radius: 1, widthSegments: 50, heightSegments: 50, phiStart: undefined, phiLength: undefined, thetaStart: undefined, thetaLength: undefined
                    }
                }
            },

            cone: {
                params: {
                    radius: "float",
                    height: "float",
                    radialSegments: "integer",
                    heightSegments: "integer",
                    openEnded: "boolean",
                    thetaStart: "float",
                    thetaLength: "float"
                },
                props: {},
                data: {
                    params: {
                        radius: 1, height: 1, radialSegments: 8, heightSegments: undefined, openEnded: undefined, thetaStart: undefined, thetaLength: undefined
                    }
                }
            },
            cylinder: {
                params: {
                    radiusTop: "float", radiusBottom: "float", height: "float", radialSegments: "integer", heightSegments: "integer", openEnded: "boolean", thetaStart: "float", thetaLength: "float"
                },
                props: {},
                data: {
                    params: {
                        radiusTop: 1, radiusBottom: 1, height: 1, radialSegments: 8, heightSegments: 1, openEnded: undefined, thetaStart: undefined, thetaLength: undefined
                    }
                }
            },
            plane: {
                params: {
                    width: "float", height: "float", widthSegments: "integer", heightSegments: "integer"
                },
                props: {},
                data: {
                    params: {
                        width: 1, height: 1, widthSegments: 1, heightSegments: 1
                    }
                }
            },


            circle: {
                params: {
                    radius: "float",
                    segments: "integer",
                    thetaStart: "float",
                    thetaLength: "float"
                },
                props: {},
                data: {
                    params: {
                        radius: 1, segments: 8, thetaStart: undefined, thetaLength: undefined
                    }
                }
            },

            ring: {
                params: {
                    innerRadius: "float", outerRadius: "float", thetaSegments: "integer", phiSegments: "integer", thetaStart: "float", thetaLength: "float"
                },
                props: {},
                data: {
                    params: {
                        innerRadius: 0.5, outerRadius: 1, thetaSegments: 8, phiSegments: 1, thetaStart: 0, thetaLength: Math.PI * 2
                    }
                }
            },

            dodecahedron: {
                params: {
                    radius: "float", detail: "integer"
                },
                props: {},
                data: {
                    params: {
                        radius: 1, detail: 0
                    }
                }
            },

            icosahedron: {
                params: {
                    radius: "float", detail: "integer"
                },
                props: {},
                data: {
                    params: {
                        radius: 1, detail: 0
                    }
                }
            },

            octahedron: {
                params: {
                    radius: "float", detail: "integer"
                },
                props: {},
                data: {
                    params: {
                        radius: 1, detail: 0
                    }
                }
            },



            tetrahedron: {
                params: {
                    radius: "float", detail: "integer"
                },
                props: {},
                data: {
                    params: {
                        radius: 1, detail: 0
                    }
                }
            }
        },
        propTypes: {
            buffer: {
                attributes: "object",
                boundingBox: "Box3",
                boundingSphere: "Sphere",
                drawRange: "object",
                groups: "array",
                id: "locked",
                index: "BufferAttribute",
                morphAttributes: "object",
                morphTargetsRelative: "boolean",
                name: "string",
                userData: "object",
                uuid: "string"
            },
            instancedbuffer: {
                instanceCount: "number"
            }
        },
        options: []
    }
});

for (const key in Geometries.config.instances) {
    if (Object.hasOwnProperty.call(Geometries.config.instances, key)) {
        const intenceConfig = Geometries.config.instances[key];
        intenceConfig.props = assignValue({ parameters: "object" }, Geometries.config.propTypes.buffer);
        if (inArray(['box', 'plane', 'sphere', 'circle', 'cylinder'], key)) {
            Geometries.config.options.push({
                name: key,
                value: key,
                type: key,
                label: Str.ucfirst(key)
            })
        }

    }
}


const sideOptions = {};
sideOptions[THREE.FrontSide] = "Front Side";
sideOptions[THREE.BackSide] = "Back Side";
sideOptions[THREE.DoubleSide] = "Double Side";
Object.assign(Materials, {
    getMaterial: function (type?: any, args?: any, props?: any, ignoreFlipY?: boolean, success?: any) {
        var self: any = this;
        if (typeof type == "object") {
            args = assignWithout({}, type.params || type, ['type', 'props']);
            props = type.props || assignWithout({}, type, ['type', 'params'], args);
            type = type.type;

        } else {
            if (!args) args = {};
            props = props || args.props || assignWithout({}, args, ['type']);
        }
        var t = String(type).toLowerCase();
        t = Str.replace(t, ['mesh'], '');
        if (!t) t = 'basic';
        else if (t == 'material') t = 'default';
        t = Str.replace(t, ['material'], '');

        if (typeof self['__' + t] == "function") {
            if (!isEmpty(args)) args = this.parseParams(Props.parse(cutWithout(args, ['type'])), ignoreFlipY, success);
            if (!isEmpty(props)) props = Props.parse(props);
            var propTypes = this.getTypeProps(t);
            for (const key in props) {
                if (Object.hasOwnProperty.call(props, key)) {
                    const vl = props[key];
                    if (Object.hasOwnProperty.call(propTypes, key)) {
                        var tp = propTypes[key];
                        if (tp == "Color") {
                            props[key] = parseColor(vl)
                        }
                    }
                }
            }
            for (const key in args) {
                if (Object.hasOwnProperty.call(args, key)) {
                    const vl = args[key];
                    if (Object.hasOwnProperty.call(propTypes, key)) {
                        var tp = propTypes[key];
                        if (tp == "Color") {
                            args[key] = parseColor(vl)
                        }
                    }
                }
            }
            var material = this['__' + t].call(this, args);
            var p = assignWithout({}, props, material.___params, ['type']);

            this.setProperties(t, material, p, ignoreFlipY);
            // console.log(material)
            return material;
        }
        return null;
    },
    get: function (type?: any, args?: any, props?: any, ignoreFlipY?: boolean, success?: any) {
        return this.getMaterial(type, args, props, ignoreFlipY, success);
    },
    parseParams: function (params, ignoreFlipY?: boolean, success?: any) {
        if (isObject(params)) {
            for (const key in params) {
                if (Object.prototype.hasOwnProperty.call(params, key)) {
                    const val = params[key];
                    if (objectHasKey(this.config.properties, key)) {
                        let inp = this.config.properties[key];


                        if (inp.type == "Texture" && isString(val)) {
                            let lo: any = {
                                file: val,
                                ignoreFlipY
                            };
                            if (!ignoreFlipY) {
                                lo.flipY = false;
                            }
                            var map = LoaderLib.load("texture", lo, function (d) {
                                if (typeof success == "function") {
                                    success(d);
                                }
                            });
                            params[key] = map;

                        } else if (inp.type == "Color") {

                            params[key] = parseColor(val);

                        }

                    }

                }
            }
        }
        return params;
    },
    setProperties: function (type?: any, material?: any, properties?: any, success?: any, ignoreFlipY?: boolean) {
        let props: any = {};
        if (typeof properties == "object") {
            if (!isEmpty(properties)) {
                assignWithout(props, properties, ['type']);
                Props.parse(props, success);
            }

            var defProps = this.getTypeProps(type);
            for (const key in props) {
                if (props.hasOwnProperty(key) && typeof defProps[key] != "undefined" && key != "type") {
                    const val = props[key];
                    const typ = typeof defProps[key] != "undefined" ? defProps[key] : null;
                    if (!typ) {
                        continue;
                    }
                    else if (typeof typ == "function") {
                        if (typ(val)) {
                            material[key] = val;
                        }
                    }
                    else if (typeof typ == "string") {
                        if (inArray(["Texture", "Vector2", "Vector3"], typ)) {
                            if (isObject(val) && val.uuid) {
                                material[key] = val;
                            } else if (typ == "Texture" && isString(val)) {
                                let lo: any = {
                                    file: val,
                                    ignoreFlipY
                                };
                                if (!ignoreFlipY) {
                                    lo.flipY = false;
                                }
                                var map = LoaderLib.load("texture", lo, function (d) {
                                    if (typeof success == "function") {
                                        success(d);
                                    }
                                });
                                material[key] = map;
                            }
                        } else if (typ == "Color") {

                            material[key] = parseColor(val);

                        }
                        else {
                            var ts = typ.split("|");
                            var s = false;
                            for (let i = 0; i < ts.length; i++) {
                                const ti = ts[i];
                                const tis = ti.split(':');
                                if (checkType(tis[0].trim(), val)) {
                                    if (tis.length > 1) {
                                        let vl = tis[1].trim().split(',').map(function (v) {
                                            return String(v).trim();
                                        });
                                        if (inArray(vl, String(val))) {
                                            s = true;
                                            i += ts.length;
                                        }
                                    } else {
                                        s = true;
                                        i += ts.length;
                                    }
                                }
                            }
                            if (s) {
                                material[key] = val;
                            }
                        }
                        material.needsUpdate = true;
                    }
                }
            }
        }
        return material;
    },

    /**
     * lay ra kieu thuoc tinh cuar loaai material tuong ung
     * @param {string} type loai material
     */
    getTypeProps: function (type?: any) {
        var properties = {};
        function addPropType(key, prop) {
            properties[key] = prop.type;
        }
        var def = arrayJoin([], this.config.propGroup.default);
        var t = Str.replace(String(type).toLowerCase(), ['mesh', 'material'], '');
        if (t && t != 'default' && typeof this.config.propGroup[t] != "undefined") {
            arrayJoin(def, this.config.propGroup[t]);
        }
        // addPropType(def);
        var self = this;
        def.map(function (t) {
            if (typeof self.config.properties[t] != "undefined") {
                addPropType(t, self.config.properties[t]);
            }
        })
        return properties;

    },

    /**
     * chuan hoa thuoc tinh matẻial
     * @param {string} type loai5 matẻial
     * @param {object} props 
     */
    parseProps: function (type?: any, props?: any) {
        var properties = {};
        var p = this.getTypeProps(type);
        if (isObject(props) && !isEmpty(props)) {
            for (const key in props) {
                if (props.hasOwnProperty(key)) {
                    const val = props[key];
                    if (typeof p[key] == "string") {
                        const typeVal = p[key];
                        var t = typeVal.toLowerCase();
                        if (inArray(['texture', 'texturecube', 'object', 'color', 'vector', 'vector2', 'vector3', 'vector4'], t) && isObject(val)) {
                            properties[key] = val;
                        } else if (t == "color" && (inArray(['string', 'number'], getType(val)))) {
                            properties[key] = createColor(val);
                        } else if (t == "boolean") {
                            if (isString(val)) {
                                var v = val.toLowerCase();
                                properties[key] = v && v !== "false" && v !== "0" && v != "off" ? true : false;
                            } else {
                                properties[key] = val ? true : false;
                            }
                        } else if (checkType(typeVal, val)) {
                            properties[key] = val;
                        }
                    }
                }
            }
        }
        return properties;

    },

    parseType: function (type: any) {
        return Str.replace(String(isObject(type) ? type.type : type).toLowerCase(), ['mesh', 'material'], '');;
    },

    getDetectedProps: function detectProps(material?: any) {
        var props = {};
        if (isObject(material)) {
            var type = material.type ? Str.replace(String(material.type), ['mesh', 'material'], '') : "";
            if (type) {
                var defProps = this.getTypeProps(type);

                for (const key in material) {
                    if (material.hasOwnProperty(key)) {
                        const val = material[key];
                        if (typeof defProps[key] != "undefined") {
                            props[key] = val;
                        }
                    }
                }
            }
        }
        return props;
    },
    getPropData: function getPropData(material?: any) {
        var props = {};
        if (isObject(material)) {
            var type = material.type ? Str.replace(String(material.type), ['mesh', 'material'], '') : "";
            if (!type) type = 'default';

            var defProps = this.getTypeProps(type);

            for (const key in material) {
                if (material.hasOwnProperty(key)) {
                    const val = material[key];
                    if (typeof defProps[key] != "undefined" && key != "uuid") {
                        switch (defProps[key]) {
                            case "Color":
                                props[key] = "#" + val.getHexString();
                                break;

                            default:
                                props[key] = val;
                                break;
                        }

                    }
                }
            }

        }
        return props;
    },
    /**
     * lay map cuar material
     * @param {object} material 
     */
    getMaps: function getMaps(material?: any) {
        var props = {};
        if (isObject(material)) {
            var type = material.type ? Str.replace(String(material.type), ['mesh', 'material'], '') : "";
            if (type) {
                var defProps = this.getTypeProps(type);

                for (const key in defProps) {
                    if (defProps.hasOwnProperty(key)) {
                        const value = defProps[key];
                        if (value.toLowerCase() == "texture") {
                            if (material.hasOwnProperty(key) && material[key]) {
                                props[key] = material[key];
                            } else {
                                props[key] = null;
                            }
                        }
                    }
                }
            }
        }
        return props;
    },
    /**
     * lay map cuar material
     * @param {object} material 
     */
    getColors: function getMaps(material?: any) {
        var props = {};
        if (isObject(material)) {
            var type = material.type ? Str.replace(String(material.type), ['mesh', 'material'], '') : "";
            if (type) {
                var defProps = this.getTypeProps(type);

                for (const key in defProps) {
                    if (defProps.hasOwnProperty(key)) {
                        const value = defProps[key];
                        if (value.toLowerCase() == "color") {
                            if (material.hasOwnProperty(key) && material[key]) {
                                props[key] = material[key];
                            } else {
                                props[key] = null;
                            }
                        }
                    }
                }
            }
        }
        return props;
    },

    /**
     * lay map cuar material
     * @param {object} material 
     */
    getCloneMaps: function getCloneMaps(material?: any) {
        var m = material;
        if (isObject(material)) {
            var type = material.type ? Str.replace(String(material.type), ['mesh', 'material'], '') : "";
            var props = {};
            if (type) {
                var defProps = this.getTypeProps(type);
                for (const key in defProps) {
                    if (defProps.hasOwnProperty(key)) {
                        const value = defProps[key];
                        if (value.toLowerCase() == "texture") {
                            if (material.hasOwnProperty(key) && material[key]) {
                                props[key] = material[key];
                            }
                        }
                    }
                }
                m = this.get(type, props);
            }
        }
        return m;
    },

    getMaterialType: function (str: string) {
        return str ? Str.replace(String(str).toLowerCase(), ['mesh', 'material'], '') : null;
    },

    getMaterialInputs: function (materialType: string, material: any, settings?: any, editableList?: any): any[] {
        let _type = materialType ? Str.replace(String(materialType).toLowerCase(), ['mesh', 'material'], '') : 'basic';
        let _material = this.config.data[_type];
        let _settings = isObject(settings) ? settings : {};
        if (!_material) return [];
        let inputs = [];

        let ignore = [];


        /**
         * 
         * @param type loại input
         * @param name tên input
         * @param value gia tri
         * @param options option
         */
        const addInput = (type: string, name: string, value: (string | number | boolean | { [x: string]: any }), options?: any) => {
            inputs.push(assignValue({
                type: type,
                name: name,
                value: value
            }, options));
        }

        let materialProps = _material.props;
        let editable = _material.editable;
        const isArrayEditAble = isArray(editableList);

        for (let index = 0; index < editable.length; index++) {
            const key = editable[index];

            if (Object.prototype.hasOwnProperty.call(materialProps, key) && key != "name" && ignore.indexOf(key) == -1 && inArray(this.config.availableInputs, key)) {

                const prop = materialProps[key];
                const type = prop.type.split(":")[0].toLowerCase();
                const value = typeof _settings[key] != "undefined" ? _settings[key] : (isObject(material) && typeof material[key] != "undefined" ? material[key] : prop.value);
                var inputType = prop.data.inputType;
                const inputOptions: any = {};
                let isEditAble = (isArrayEditAble && editableList.indexOf(key) !== -1) || (!isArrayEditAble);
                switch (type) {
                    case 'boolean':
                        addInput("checkbox", key, value, { editable: isEditAble });
                        break;
                    case 'string':
                        if (inputType == "select") {
                            addInput("select", key, value, { options: prop.data.options, editable: isEditAble, valueType: prop.data.valueType || null })
                        } else {
                            addInput("text", key, value, { editable: isEditAble })
                        }
                        break;
                    case "number":
                    case "float":
                    case "integer":
                        if (inputType == "select") {
                            addInput("select", key, value, { options: prop.data.options, editable: isEditAble, valueType: prop.data.valueType || null });
                        } else {
                            assignWithout(inputOptions, prop.data, ['inputType']);
                            //  inputOptions.layout = "smart";
                            if (inputType == "range") inputOptions.outputWidth = 2;
                            inputOptions.editable = isEditAble;
                            if (type == "integer") {
                                let a = assignValue({
                                    min: -99999999,
                                    max: 99999999,
                                    step: 1
                                }, inputOptions);
                                assignValue(inputOptions, a);
                            }
                            addInput(inputType == "range" ? inputType : 'number', key, value, inputOptions);
                        }
                        break;

                    case "color":
                    case 'texture':
                        inputOptions.editable = isEditAble;
                        if (typeof materialProps[key + "Intensity"] != "undefined") {
                            inputOptions.attach = assignValue(materialProps[key + "Intensity"].data);
                            inputOptions.attach.name = key + "Intensity";
                            inputOptions.attach.type = inputOptions.attach.inputType || "range";
                            if (_settings[key + "Intensity"] !== undefined) {
                                inputOptions.attach.value = _settings[key + "Intensity"];
                            }
                            else if (_material[key + "Intensity"] !== undefined) {
                                inputOptions.attach.value = _material[key + "Intensity"];
                            } else {
                                inputOptions.attach.value = materialProps[key + "Intensity"].value;
                            }
                            ignore.push(key + "Intensity");
                        }

                        var vl = type == "color" && isObject(value) ? (
                            value.isColor ? "#" + value.getHexString() : (
                                value.$three == "color" ? value.color : "#000000"
                            )
                        ) : value;

                        addInput(type, key, vl, inputOptions);
                        break;


                    default:
                        break;
                }
            }
        }

        return inputs;
    },

    __default: function () {
        return new THREE.Material();
    },

    __linebasic: function (parameters?: any) {
        var options = {
            color: 0xffffff,
            linewidth: 1,
            linecap: 'round', //ignored by WebGLRenderer
            linejoin: 'round' //ignored by WebGLRenderer
        };
        assignValue(options, parameters);
        options.color = parseColorIntVal(options.color);
        return new THREE.LineBasicMaterial(options);

    },

    __linedashed: function (parameters?: any) {
        var options = {
            color: 0xffffff,
            linewidth: 1,
            scale: 1,
            dashSize: 3,
            gapSize: 1,
        };
        assignValue(options, parameters);
        options.color = parseColorIntVal(options.color);
        return new THREE.LineDashedMaterial(options);

    },

    __basic: function (parameters?: any) {
        return new THREE.MeshBasicMaterial(parameters);
    },

    __depth: function (parameters?: any) {
        return new THREE.MeshDepthMaterial(parameters);
    },

    __distance: function (parameters?: any) {
        return new THREE.MeshDistanceMaterial(parameters);
    },

    __lambert: function (parameters?: any) {
        return new THREE.MeshLambertMaterial(parameters);
    },

    __matcap: function (parameters?: any) {
        return new THREE.MeshMatcapMaterial(parameters);
    },

    __normal: function (parameters?: any) {
        return new THREE.MeshNormalMaterial(parameters);
    },

    __phong: function (parameters?: any) {
        return new THREE.MeshPhongMaterial(parameters);
    },

    __physical: function (parameters?: any) {
        return new THREE.MeshPhysicalMaterial(parameters);
    },
    __standard: function (parameters?: any) {
        return new THREE.MeshStandardMaterial(parameters);
    },

    __toon: function (parameters?: any) {
        return new THREE.MeshToonMaterial(parameters);
    },

    __points: function (parameters?: any) {
        return new THREE.PointsMaterial(parameters);
    },
    __shadow: function (parameters?: any) {
        return new THREE.ShadowMaterial(parameters);
    },

    config: {
        data: {
            basic: {
                type: "BasicMaterial",
                props: {},
            },
            lambert: {
                type: "LambertMaterial",
                props: {},
            },
            normal: {
                type: "NormalMaterial",
                props: {},
            },
            phong: {
                type: "PhongMaterial",
                props: {},
            },
            physical: {
                type: "PhysicalMaterial",
                props: {},
            },
            standard: {
                type: "StandardMaterial",
                props: {},
            },
        },
        availableInputs: [
            "type",
            "color",
            "map",
            "bumpMap",
            "bumpScale",
            "normalMap",
            "normalMapType",
            "normalScale",
            "side",
            "opacity",
            "transparent",
            "visible",

        ],
        options: {},
        editable: {
            name: 'String',
            opacity: 'Float',
            side: 'Integer:' + THREE.FrontSide + ',' + THREE.BackSide + ',' + THREE.DoubleSide,
            shadowSide: 'Integer:' + THREE.FrontSide + ',' + THREE.BackSide + ',' + THREE.DoubleSide,
            transparent: 'Boolean',
            visible: 'Boolean',
        },
        properties: {
            type: { type: "String", editable: false, data: {}, value: "Material" },
            color: { type: "Color", editable: true, data: {} },
            map: { type: "Texture", editable: true, data: {}, value: null },
            bumpMap: { type: "Texture", editable: true, data: { addons: ["bumpScale"] }, value: null },
            bumpScale: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            normalMap: { type: "Texture", editable: true, data: { addons: ["normalMapType", "normalScale"] }, value: null },
            normalMapType: { type: "Integer", editable: true, data: {}, value: 0 },
            normalScale: { type: "Vector2", editable: true, data: {} },
            side: { type: "Integer:0,1,2", editable: true, data: { inputType: "select", valueType: "number", options: sideOptions }, value: 0 },
            opacity: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            transparent: { type: "Boolean", editable: true, data: {}, value: true },
            visible: { type: "Boolean", editable: true, data: {}, value: true },



            alphaMap: { type: "Texture", editable: true, data: {}, value: null },
            alphaTest: { type: "number", editable: false, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 0 },
            aoMap: { type: "Texture", editable: true, data: {}, value: null },
            aoMapIntensity: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            blendDst: { type: "integer", editable: false, data: {}, value: 205 },
            blendDstAlpha: { type: "Integer", editable: false, data: {}, value: null },
            blendEquation: { type: "Integer", editable: false, data: {}, value: 100 },
            blendEquationAlpha: { type: "Integer", editable: false, data: {}, value: null },
            blendSrc: { type: "Integer", editable: false, data: {}, value: 204 },
            blendSrcAlpha: { type: "Integer", editable: false, data: {}, value: null },
            blending: { type: "mixed", editable: false, data: {}, value: 1 },
            clearcoat: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 0 },
            clearcoatMap: { type: "Texture", editable: true, data: {}, value: null },
            clearcoatNormalMap: { type: "Texture", editable: true, data: {}, value: null },
            clearcoatNormalScale: { type: "Vector2", editable: true, data: {} },
            clearcoatRoughness: { type: "Float", editable: true, data: {}, value: 0 },
            clearcoatRoughnessMap: { type: "Texture", editable: true, data: {}, value: null },
            clipIntersection: { type: "Boolean", editable: false, data: {}, value: false },
            clipShadows: { type: "Boolean", editable: false, data: {}, value: false },
            clippingPlanes: { type: "Array", editable: false, data: {}, value: null },
            colorWrite: { type: "Boolean", editable: false, data: {}, value: true },
            combine: { type: "Integer", editable: true, data: { min: 0, step: 1 }, value: 0 },
            defines: { type: "Object", editable: false, data: {} },
            depthFunc: { type: "Integer", editable: false, data: {}, value: 3 },
            depthPacking: { type: "Constant", editable: true, data: {}, value: 3200 },
            depthTest: { type: "Boolean", editable: false, data: {}, value: true },
            depthWrite: { type: "Boolean", editable: false, data: {}, value: true },
            displacementBias: { type: "Float", editable: true, data: { min: -1, max: 1, step: 0.01, inputType: "range" }, value: 0 },
            displacementMap: { type: "Texture", editable: true, data: {}, value: null },
            displacementScale: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            dithering: { type: "Boolean", editable: false, data: {}, value: false },
            emissive: { type: "Color", editable: true, data: {} },
            emissiveIntensity: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            emissiveMap: { type: "Texture", editable: true, data: {}, value: null },
            envMap: { type: "TextureCube", editable: true, data: {}, value: null },
            envMapIntensity: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            farDistance: { type: "Float", editable: true, data: { min: 0, step: 0.01, inputType: "range" }, value: 1000 },
            flatShading: { type: "Boolean", editable: false, data: {}, value: false },
            fog: { type: "Boolean", editable: false, data: {}, value: true },
            gradientMap: { type: "Texture", editable: true, data: {}, value: null },
            id: { type: "Integer", editable: false, data: {} },
            lightMap: { type: "Texture", editable: true, data: {}, value: null },
            lightMapIntensity: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            matcap: { type: "Texture", editable: true, data: {}, value: null },
            metalness: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 0 },
            metalnessMap: { type: "Texture", editable: true, data: {}, value: null },
            morphNormals: { type: "boolean", editable: true, data: {}, value: false },
            morphTargets: { type: "Boolean", editable: true, data: {}, value: false },
            name: { type: "String", editable: true, data: {}, value: "" },
            nearDistance: { type: "Float", editable: true, data: { min: 0 }, value: 1 },
            needsUpdate: { type: "Boolean", editable: false, data: {} },
            polygonOffset: { type: "Boolean", editable: false, data: {}, value: false },
            polygonOffsetFactor: { type: "Integer", editable: false, data: {}, value: 0 },
            polygonOffsetUnits: { type: "Integer", editable: false, data: {}, value: 0 },
            precision: { type: "String: highp, mediump, lowp", editable: false, data: {}, value: null },
            premultipliedAlpha: { type: "Boolean", editable: false, data: {}, value: false },
            referencePosition: { type: "Vector3", editable: true, data: {} },
            reflectivity: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            refractionRatio: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 0.98 },
            roughness: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 1 },
            roughnessMap: { type: "Texture", editable: true, data: {}, value: null },
            shadowSide: { type: "Integer:0,1,2", editable: false, data: {}, value: null },
            shininess: { type: "Float", editable: true, data: {}, value: 30 },
            size: { type: "Number", editable: true, data: {}, value: 1 },
            sizeAttenuation: { type: "Boolean", editable: true, data: {}, value: true },
            skinning: { type: "Boolean", editable: true, data: {}, value: false },
            specular: { type: "Color", editable: true, data: {} },
            specularMap: { type: "Texture", editable: true, data: {}, value: null },
            stencilFail: { type: "Integer", editable: false, data: {}, value: 7680 },
            stencilFunc: { type: "Integer", editable: false, data: {}, value: 519 },
            stencilFuncMask: { type: "Integer", editable: false, data: {}, value: 255 },
            stencilRef: { type: "Integer", editable: false, data: {}, value: 0 },
            stencilWrite: { type: "Boolean", editable: false, data: {}, value: false },
            stencilWriteMask: { type: "Integer", editable: false, data: {}, value: 255 },
            stencilZFail: { type: "Integer", editable: false, data: {}, value: 7680 },
            stencilZPass: { type: "Integer", editable: false, data: {}, value: 7680 },
            toneMapped: { type: "Boolean", editable: false, data: {}, value: true },
            transmission: { type: "Float", editable: true, data: { min: 0, max: 1, step: 0.01, inputType: "range" }, value: 0 },
            transmissionMap: { type: "Texture", editable: true, data: {}, value: null },
            userData: { type: "object", editable: false, data: {}, value: {} },
            uuid: { type: "String", editable: false, data: {}, value: "" },
            version: { type: "Integer", editable: false, data: {}, value: 0 },
            vertexColors: { type: "Boolean", editable: false, data: {}, value: false },
            vertexTangents: { type: "Boolean", editable: true, data: {}, value: false },
            wireframe: { type: "Boolean", editable: true, data: {}, value: false },
            wireframeLinecap: { type: "String", editable: true, data: {}, value: "round" },
            wireframeLinejoin: { type: "String", editable: true, data: {}, value: "round" },
            wireframeLinewidth: { type: "Float", editable: true, data: {}, value: 1 }
        },

        propGroup: {
            default: [
                "opacity",
                "side",
                "alphaTest",
                "blendDst",
                "blendDstAlpha",
                "blendEquation",
                "blendEquationAlpha",
                "blending",
                "blendSrc",
                "blendSrcAlpha",
                "clipIntersection",
                "clippingPlanes",
                "clipShadows",
                "colorWrite",
                "defines",
                "depthFunc",
                "depthTest",
                "depthWrite",
                "stencilWrite",
                "stencilWriteMask",
                "stencilFunc",
                "stencilRef",
                "stencilFuncMask",
                "stencilFail",
                "stencilZFail",
                "stencilZPass",
                "flatShading",
                "fog",
                "id",
                "name",
                "needsUpdate",
                "polygonOffset",
                "polygonOffsetFactor",
                "polygonOffsetUnits",
                "precision",
                "premultipliedAlpha",
                "dithering",
                "shadowSide",
                "toneMapped",
                "transparent",
                "type",
                "uuid",
                "version",
                "vertexColors",
                "visible",
                "userData"
            ],
            basic: [
                "name",

                "color",
                "map",
                "side",
                "transparent",
                "opacity",
                "visible",

                "aoMap",
                "aoMapIntensity",
                "combine",
                "envMap",
                "lightMap",
                "lightMapIntensity",
                "morphTargets",
                "reflectivity",
                "refractionRatio",
                "skinning",
                "specularMap",
                "wireframe",
                "wireframeLinecap",
                "wireframeLinejoin",
                "wireframeLinewidth",
                "shadowSide"

            ],
            depth: [
                "name",
                "map",
                "side",
                "transparent",
                "opacity",
                "visible",

                "alphaMap",
                "depthPacking",
                "displacementMap",
                "displacementScale",
                "displacementBias",
                "fog",
                "morphTargets",
                "skinning",
                "wireframe",
                "wireframeLinewidth",
                "shadowSide"
            ],
            distance: [
                "name",
                "map",
                "side",
                "transparent",
                "opacity",
                "visible",

                "alphaMap",
                "displacementMap",
                "displacementScale",
                "displacementBias",
                "farDistance", "fog", "morphTargets", "nearDistance", "referencePosition", "skinning", "shadowSide"
            ],
            lambert: [
                "name", "color", "map", "transparent", "opacity", "side", "visible",
                "emissive", "emissiveMap", "emissiveIntensity",
                "alphaMap", "aoMap", "aoMapIntensity", "combine", "envMap", "lightMap", "lightMapIntensity", "morphNormals", "morphTargets", "reflectivity", "refractionRatio", "skinning", "specularMap", "wireframe", "wireframeLinecap", "wireframeLinejoin", "wireframeLinewidth", "shadowSide"
            ],
            matcap: [
                "name", "color", "map", "bumpMap", "bumpScale", "normalMap", "normalMapType", "normalScale", "transparent", "opacity", "side", "visible",
                "alphaMap", "displacementMap", "displacementScale", "displacementBias", "matcap", "morphNormals", "morphTargets", "skinning", "shadowSide"
            ],
            normal: [
                "name", "bumpMap", "bumpScale", "normalMap", "normalMapType", "normalScale", "transparent", "opacity", "side", "visible", "displacementMap", "displacementScale", "displacementBias", "fog", "morphNormals", "morphTargets", "skinning", "wireframe", "wireframeLinewidth", "shadowSide"
            ],
            phong: [
                "name", "color", "map", "bumpMap", "bumpScale", "normalMap", "normalMapType", "normalScale", "opacity", "side", "transparent", "visible", "alphaMap", "aoMap", "aoMapIntensity",
                "combine", "displacementMap", "displacementScale", "displacementBias", "emissive", "emissiveMap", "emissiveIntensity", "envMap", "lightMap", "lightMapIntensity", "morphNormals", "morphTargets", "reflectivity", "refractionRatio", "shininess", "skinning", "specular", "specularMap", "wireframe", "wireframeLinecap", "wireframeLinejoin", "wireframeLinewidth", "shadowSide"
            ],
            physical: [
                "name", "color", "map", "bumpMap", "bumpScale", "normalMap", "normalMapType", "normalScale", "transparent", "opacity", "side", "visible",
                "alphaMap", "aoMap", "aoMapIntensity",
                "defines", "displacementMap", "displacementScale", "displacementBias", "emissive", "emissiveMap", "emissiveIntensity", "envMap", "envMapIntensity", "lightMap", "lightMapIntensity", "metalness", "metalnessMap", "morphNormals", "morphTargets", "refractionRatio", "roughness", "roughnessMap", "skinning", "vertexTangents", "wireframe", "wireframeLinecap", "wireframeLinejoin", "wireframeLinewidth", "clearcoat", "clearcoatMap", "clearcoatNormalMap", "clearcoatNormalScale", "clearcoatRoughness", "clearcoatRoughnessMap", "reflectivity", "transmission", "transmissionMap", "shadowSide"
            ],
            standard: [
                "name", "color", "map", "bumpMap", "bumpScale", "normalMap", "normalMapType", "normalScale", "transparent", "opacity", "side", "visible",
                "alphaMap", "aoMap", "aoMapIntensity", "defines", "displacementMap", "displacementScale", "displacementBias", "emissive", "emissiveMap", "emissiveIntensity", "envMap", "envMapIntensity", "lightMap", "lightMapIntensity", "metalness", "metalnessMap", "morphNormals", "morphTargets", "refractionRatio", "roughness", "roughnessMap", "skinning", "vertexTangents", "wireframe", "wireframeLinecap", "wireframeLinejoin", "wireframeLinewidth", "shadowSide"
            ],
            toon: [
                "name", "alphaMap", "aoMap", "aoMapIntensity", "bumpMap", "bumpScale", "color", "displacementMap", "displacementScale", "displacementBias", "emissive", "emissiveMap", "emissiveIntensity", "gradientMap", "lightMap", "lightMapIntensity", "map", "morphNormals", "morphTargets", "normalMap", "normalMapType", "normalScale", "skinning", "wireframe", "wireframeLinecap", "wireframeLinejoin", "wireframeLinewidth", "opacity", "side", "shadowSide", "transparent", "visible"
            ],
            points: [
                "name", "alphaMap", "color", "map", "morphTargets", "size", "sizeAttenuation", "opacity", "side", "shadowSide", "transparent", "visible"
            ],
            shadow: [
                "name", "transparent", "opacity", "side", "shadowSide", "visible"
            ]
        }

    }

});

for (const key in Materials.config.data) {
    if (Object.hasOwnProperty.call(Materials.config.data, key)) {
        const data = Materials.config.data[key];

        data.props = {};
        data.editable = [];
        const material = Materials.get(key);
        const properties = Materials.getPropData(material);
        for (const k in properties) {
            if (Object.hasOwnProperty.call(properties, k)) {
                const vl = properties[k];
                data.props[k] = assignValue({}, Materials.config.properties[k]);
                data.props[k].value = vl;
            }
        }
        data.editable = Materials.config.propGroup[key].filter(function (prop) {
            if (Object.hasOwnProperty.call(data.props, prop)) {
                return data.props[prop].editable;
            }

            return false;
        });

        data.getEditableProps = function () {
            var props = {};
            this.editable.map(function (prop) {
                if (Object.hasOwnProperty.call(this.props, prop)) {
                    props = data.props[prop];
                }
            });
            return props;

        };
        // data.props = copyByList(Materials.config.properties, Materials.config.propGroup[key]);
        Materials.config.options[key] = data.type;

    }
}



Object.assign(Meshes, {

    /**
     * lay ve mot mesh
     * @param {object} options thong tin khoi tao va thuoc tinh
     */
    getMesh: function (options?: any, success?:any) {
        var self = this;
        var opt = typeof options == "object" ? options : {};
        var params = {};
        var t = String(opt.type || "").toLowerCase();
        var geometry = this.getGeometry(opt.geometry);
        var material = this.getMaterial(
            isObject(opt.material) ? opt.material : {}, 
            isObject(opt.geometry) ? opt.geometry : {},
            success
        );
        if (!geometry || !material) return null;
        var mesh = null;
        if (t == 'instanced') {
            mesh = new THREE.InstancedMesh(geometry, material, opt.count);
        } else if (t == 'skinned') {
            mesh = new THREE.SkinnedMesh(geometry, material);
        } else {
            mesh = new THREE.Mesh(geometry, material);
        }
        if (mesh) {
            var props = Props.parse(opt.props || copyWithout(opt, ['geometry', 'material']));
            this.setProperties(mesh, props);
        }
        return mesh;

    },
    /**
     * giong ham tren
     * @param {object} options 
     */
    get: function (options?: any, success?:any) {
        return this.getMesh(options, success);
    },
    /**
     * lay ve mot geometry
     * @param {object} options 
     */
    getGeometry: function (options?: any) {
        if (typeof options != "object") options = {};
        var args = options.params || options.args || options.options || copyWithout(options, ['type']);
        return Geometries.get(options.type, args);
    },

    /**
     * lay ve material cho mesh
     * @param {object} options thuoc tinh cua material
     * @param {object} geometryOptions thuoc tinh cua geometry
     */
    getMaterial: function (options?: any, geometryOptions?: any, success?:any) {
        var material;
        var self = this;
        var t = String(options ? (options.type || 'basic') : 'basic').toLowerCase();
        // neu co thuoc tinh cua geometry va thuoc cac loai box
        if (geometryOptions && inArray(['cube', 'box', 'boxbuffer'], String(geometryOptions.type).toLowerCase())) {
            var item_type = options.item_type ? String(options.item_type).toLowerCase() : 'basic';
            if (inArray(['images', 'boximages', 'boximg'], t)) {
                if (t == 'images') {
                    var cubeMaterials = [

                    ];
                    if (options.images && isArray(options.images)) {
                        for (let i = 0; i < options.images.length; i++) {
                            const image = options.images[i];
                            let o: any = { file: image, ignoreFlipY: true };
                            if (options.path) o.path = options.path;
                            let opt = {
                                map: LoaderLib.load('texture', o),
                                side: inArray([THREE.DoubleSide, THREE.FrontSide, THREE.BackSide], options.side) ? options.side : THREE.DoubleSide
                            };
                            assignWithout(opt, options.item_params || options.item_args || options.params || options.args || options, ['type', 'images', 'files', 'file', 'imagge', 'props', 'path', 'side']);
                            cubeMaterials.push(Materials.get(item_type, opt));
                        }
                    }
                    return cubeMaterials;
                }


                var files = options.files || options.file || options.images;
                if (isArray(files)) {
                    var loadOpt = newObj({ file: files });
                    if (options.path) loadOpt.path = options.path;
                    let opt = newObj({
                        envMap: this.parent.Loader.load('cubetexture', loadOpt)
                    });

                    // console.log(opt)
                    assignWithout(opt, options.params || options.args || options, ['type', 'images', 'files', 'file', 'imagge', 'props', 'params', 'attrs', 'attributes', 'path', 'side']);
                    var params = cutWithout(opt, ['tyoe', 'args', 'params', 'props']);
                    var props = cutWithout(options.props || options.properties || options.attrs || options.attributes || cutWithout(options, ['type', 'images', 'files', 'file', 'imagge', 'props', 'params', 'attrs', 'attributes', 'path']), params);

                    material = Materials.get(item_type, params, props, true);
                    return material;
                }
            }

            else if (t == 'list' || options.children) {
                var materials = [];
                var list = options.list || options.children;
                if (isArray(list)) {
                    for (let j = 0; j < list.length; j++) {
                        const mat = list[j];
                        if (typeof mat == "object") {
                            let op = mat;
                            let tc = op.type || options.item_type || (t != "list" ? t : item_type);
                            let p = op.props || op;
                            materials.push(Materials.get(tc, op.params || op, p));
                        }
                    }
                }
                return materials.length ? materials : Materials.get(t || item_type, {});
            }
            else {
                var params = options.options || options.params || options.args || assignWithout({}, options, ['tyoe', 'args', 'params', 'props']);
                var props = assignWithout({}, options.props || options.properties || options.attrs || options.attributes || assignWithout({}, options, ['tyoe', 'args', 'params', 'props']), params);
                return Materials.get(t, params, props);
            }
        } else {
            var params = options.options || options.params || options.args || assignWithout({}, options, ['tyoe', 'args', 'params', 'props']);
            var props = assignWithout({}, options.props || options.properties || options.attrs || options.attributes || assignWithout({}, options, ['tyoe', 'args', 'params', 'props']), params);
            return Materials.get(t, params, props, true, success);
        }
    },
    setProperties: function (mesh?: any, props?: any) {
        if (typeof props == "object") {
            for (const key in props) {
                if (props.hasOwnProperty(key) && typeof this.propertyTypes[key] != "undefined") {
                    let val = props[key];
                    const type = this.propertyTypes[key];
                    if (!type || type == "locked") {
                        continue;
                    }
                    else if (typeof type == "function") {
                        if (type(val)) {
                            mesh[key] = val;
                        }
                    } else if (typeof type == "string") {
                        var ts = type.split("|");
                        var s = false;
                        for (let i = 0; i < ts.length; i++) {
                            const ti = ts[i];
                            const tis = ti.split(':');
                            if (tis.length == 1) {
                                // console.log(key, type, val);
                                if (ti.toLowerCase() == "boolean") {
                                    val = val === true || val == 1 || String(val).toLowerCase() == "on" ? true : false;
                                    s = true;
                                    i += ts.length;
                                } else if (checkType(ti.trim(), val)) {
                                    s = true;
                                    i += ts.length;
                                }

                            }
                            else if (tis[0].toLowerCase() == "boolean") {
                                val = val === true || val == 1 || String(val).toLowerCase() == "on" ? true : false;
                                s = true;
                                i += ts.length;
                            }


                            else if (checkType(tis[0].trim(), val)) {
                                if (isString(val) || isNumber(val)) {
                                    if (tis.length > 1) {
                                        let vl = tis[1].trim().split(',').map(function (v) {
                                            return String(v).trim();
                                        });

                                        if (inArray(vl, val)) {
                                            s = true;
                                            i += ts.length;
                                        }
                                    }
                                } else {
                                    s = true;
                                }

                            }
                        }
                        if (s) {
                            assignValue(mesh, key, val);
                        }
                    }
                }
            }
        }
        return mesh;
    },
    propertyTypes: {
        castShadow: 'Boolean',
        children: 'Object3D',
        customDepthMaterial: "locked",// 'Material',
        customDistanceMaterial: "locked",// 'Material',
        frustumCulled: 'Boolean',
        id: "locked",// 'Integer',
        layers: "locked",// 'Layers',
        matrix: 'Matrix4',
        matrixAutoUpdate: 'Boolean',
        matrixWorld: "locked",// 'Matrix4',
        matrixWorldNeedsUpdate: 'Boolean',
        modelViewMatrix: "locked",// 'Matrix4',
        name: "string",// 'String',
        normalMatrix: "locked",// 'Matrix3',
        onAfterRender: "locked",// 'Function',
        onBeforeRender: "locked",// 'Function',
        parent: "locked",// 'Object3D',
        position: 'object',
        quaternion: "locked",// 'Quaternion',
        receiveShadow: 'Boolean',
        renderOrder: 'Number',
        rotation: 'object',
        scale: 'object',
        up: 'Vector3',
        userData: 'Object',
        uuid: "locked",// 'String',
        visible: 'Boolean'
    }


});


Object.assign(LoaderLib, {

    loadingCount: 0,
    engine: null,
    /**
     * @var {App} parent
     */
    parent: null,
    setParent: function (parent: any) {
        this.parent = parent;
    },
    setEngine: function (engine: any) {
        LoaderLib.engine = engine;
    },



    /**
     * load gì đó
     * @param {string} format định dạng
     * @param {object} options các tham số load
     * @param {function} success hàm sẽ được gôi khi thành công
     * @param {function} progressing 
     * @param {function} error 
     */
    load: function (format?: any, options?: any, success?: any, progressing?: any, error?: any) {
        var f;
        if (isObject(format)) {
            f = String(format.type || format.format).toLowerCase();
            options = options || assignWithout({}, format, ['type', 'format'])
        } else {
            f = String(format).toLowerCase();
        }

        if (typeof options == "string" || !options) {
            options = {
                file: options
            };
        }
        var loader = this.getLoader(f, options.path || null);


        if (!loader) return undefined;
        if (!options.file && !options.files) return false;
        var self = this;

        var file = options.file || options.files;

        if (inArray(['texture', 'cubetexture'], f)) {
            return loader.load(file, function (texture) {
                var ps = copyWithout(options.props || options, ['file', 'files', 'images', 'path', 'type', 'format']);
                if (!isEmpty(ps)) {
                    assignValue(texture, ps);
                    if (!ps.flipY && !options.ignoreFlipY) texture.flipY = false;
                } else {
                    if (!options.ignoreFlipY) texture.flipY = false;
                }
                if (typeof success == "function") success(texture);

            }, progressing, error);
        }

        self.loadingCount++;
        if ((f == "gltf" || f == "glb") && typeof loader.setDRACOLoader == "function") {
            var dracoLoader = new DRACOLoader();
            dracoLoader.setDecoderPath(String(getConfig('urls.assets')) + '/libs/draco/gltf/');
            loader.setDRACOLoader(dracoLoader);
        }

        var roughnessMipmapper = null;
        if (self.parent) {
            roughnessMipmapper = new RoughnessMipmapper(self.parent.renderer)
        }

        var setMaterialNeedsUpdate = material => {
            if (isArray(material)) {
                for (let index = 0; index < material.length; index++) {
                    const mat = material[index];
                    setMaterialNeedsUpdate(mat);
                }
            } else if (isObject(material)) {
                material.needsUpdate = true;
            }
        };

        var ps = copyWithout(options.props || options, ['file', 'files', 'images', 'path', 'type', 'format']);


        var traverseChild = function (obj, fn) {
            obj.castShadow = ps.castShadow || false;
            obj.receiveShadow = ps.receiveShadow || false;

            if (obj.isMesh) {
                if (options.materialNeedsUpdate) {
                    setMaterialNeedsUpdate(obj.material);
                }
                // obj.geometry.computeFaceNormals();
                // obj.geometry.computeVertexNormals();
                if (options.useRoughnessMipmapper && roughnessMipmapper) {
                    roughnessMipmapper.generateMipmaps(obj.material);
                }

                obj.traverse(function (child) {
                    if (child.isMesh) {
                        // child.geometry.computeFaceNormals();
                        // child.geometry.computeVertexNormals();
                        if (options.materialNeedsUpdate) {
                            setMaterialNeedsUpdate(child.material);
                        }
                    }

                    if (child.isMesh || (child.type && String(child.type).toLowerCase() == "mesh")) {
                        // child.geometry.mergeVertices();

                        // child.geometry.computeVertexNormals(true);
                        if (options.useRoughnessMipmapper && roughnessMipmapper) {
                            roughnessMipmapper.generateMipmaps(child.material);
                        }
                        child.castShadow = ps.castShadow || false;
                        child.receiveShadow = ps.receiveShadow || false;
                        if (options.materialNeedsUpdate) {
                            setMaterialNeedsUpdate(child.material);
                        }

                        if (isFunction(fn)) {
                            fn(child);
                        }
                    }

                    if (typeof options.traverse == "function") {
                        options.traverse(child);
                    }

                });

            }
            else if (obj.children && obj.children.length) {

                for (let gi = 0; gi < obj.children.length; gi++) {
                    const child = obj.children[gi];
                    var ct = child.type ? String(child.type).toLowerCase() : "";
                    if (child.isMesh || ct == "mesh") {
                        child.castShadow = ps.castShadow || false;
                        child.receiveShadow = ps.receiveShadow || false;

                        if (options.materialNeedsUpdate) {
                            setMaterialNeedsUpdate(obj.material);
                        }

                        child.traverse(traverseChild);
                    }
                    if (child.children && child.children.length) {
                        traverseChild(child, fn);
                    }
                }


            }

        };

        var loadArgs = [
            file,
            // called when the resource is loaded
            function (modelData) {

                var succ = typeof options.success == "function" ? options.success :
                    typeof success == "function" ? success : function (data) {
                        // console.log(data)
                    };

                if (typeof modelData.scene != "undefined") {
                    modelData.scene.castShadow = true;
                    modelData.scene.receiveShadow = true;
                    modelData.scene.traverse(function (child) {
                        traverseChild(child, options.traverse);
                    });

                }
                else if (modelData.isMesh) {
                    traverseChild(modelData, options.traverse);

                }
                else if (modelData.isGroup) {
                    traverseChild(modelData, options.traverse);
                } else if (modelData.isObject3D) {
                    traverseChild(modelData, options.traverse);
                }

                


                self.loadingCount--;
                succ(modelData);
                
                if (self.parent) self.parent.emit('load.success', {data: modelData, tasks: self.loadingCount});

            },
            // called while loading is progressing
            function (xhr) {
                var pro = typeof options.progressing == "function" ? options.progressing :
                    typeof progressing == "function" ? progressing : function (msg) {
                        // console.log(msg + '% loaded');
                    };


                var pc = xhr.loaded / xhr.total * 100;
                pro(pc);

            },
            // called when loading has errors
            function (e) {

                // console.log('An error happened');
                var err = typeof options.error == "function" ? options.error :
                    typeof error == "function" ? error : function (msg) {
                        // console.log("Loõi", e);
                    }

                self.loadingCount--;
                err(e);
                
                if (self.parent) self.parent.emit('load.fail', {error: e, tasks: self.loadingCount});
            }
        ];
        var result = null;
        try {
            result = f == "obj" ? loader.loadWithMaterials.apply(loader, loadArgs) : loader.load.apply(loader, loadArgs);
        } catch (error) {
            result = null;
            this.loadingCount--;
        }
        return result;


    },

    getLoader: function (format: any, path?: any) {
        var loader = null;
        if (typeof this.loaders[format] != "undefined") {
            loader = this.loaders[format]();
            if (path) loader.setPath(path);
        }
        return loader;
    },

    loadFont: function (file?: any, success?: any, progressing?: any, error?: any) {
        var self = this;

        if (!file) return false;
        // Instantiate a loader
        var loader = new THREE.FontLoader();

        loader.load(
            file,
            function (font) {
                var succ = typeof success == "function" ? success :
                    typeof success == "function" ? success : function (data) {
                        // console.log(data)
                    };



                if (self.parent) self.parent.emit('font.load.success', font);

                succ(font);

            },
            // called while loading is progressing
            function (xhr?: any) {
                var pro = typeof progressing == "function" ? progressing :
                    typeof progressing == "function" ? progressing : function (msg?: any) {
                        // console.log(msg + '% loaded');
                    };


                var pc = xhr.loaded / xhr.total * 100;
                if (self.parent) self.parent.emit('font.load.progressing', pc);
                pro(pc);

            },
            // called when loading has errors
            function (e?: any) {

                var err = typeof error == "function" ? error :
                    typeof error == "function" ? error : function (msg?: any) {
                        // console.log("Lỗi", e);
                    }

                if (self.parent) self.parent.emit('font.load.error', e);
                err(e);

            }
        );
    },

    /**
     * Load moi truong
     * @param {object} options tham so tải
     * @param {function(Texture)} onSuccess ham xu ly khi load thanh cong
     * @param {function(Error)} onError ham xử lý khi gặp lổi
     */
    LoadEnv: function LoadEnv(options?: any, onSuccess?: any, onError?: any) {
        var opt = typeof options == "object" ? options : {};
        Props.parse(opt);
        var f = opt && opt.format ? String(opt.format).toLowerCase() : "";
        var self = this;
        if (opt.file) {
            if (f == 'hdr') {
                var engine = self.parent || LoaderLib.engine;
                var pmremGenerator = new THREE.PMREMGenerator(engine.renderer);
                pmremGenerator.compileEquirectangularShader();
                var loader = new RGBELoader();
                loader.setDataType(THREE.UnsignedByteType);
                if (opt.path) {
                    loader.setPath(opt.path);
                }
                loader.load(opt.file, function (texture) {

                    var envMap = pmremGenerator.fromEquirectangular(texture).texture;
                    if (typeof onSuccess == "function") {
                        onSuccess(envMap, texture);
                    }
                    // texture.dispose();
                    pmremGenerator.dispose();


                }, function () { }, onError);
            }
        }
    },

    loaders: {
        gltf: function () { return new GLTFLoader(); },
        obj: function () { return new OBJLoader(); },
        fbx: function () { return new FBXLoader(); },
        texture: function () { return new THREE.TextureLoader(); },
        cubetexture: function () { return new THREE.CubeTextureLoader(); },
        max: function () { return new TDSLoader(); },
        stl: function () { return new STLLoader(); },
        mtl: function () { return new MTLLoader(); },
        svg: function () { return new SVGLoader(); },
        tds: function () { return new TDSLoader(); },
        "3ds": function () { return new TDSLoader(); },

    }
});


Object.assign(LightLib, {
    /**
     * 
     * @param {App} parent 
     */
    setParent: function (parent?: any) {
        this.parent = parent;
    },

    get: function (type?: any, args?: any, props?: any) {
        return this.getLight(type, args, props);
    },


    /**
     * hiệu ung anh sang
     * @param {string} type loai hieu ung anh sang
     * @param {object} options thiet lap
     */
    getLight: function (type?: any, options?: any, props?: any) {
        return this.create(type, options, props);
    },

    /**
     * hiệu ung anh sang
     * @param {string} type loai hieu ung anh sang
     * @param {object} options thiet lap
     */
    create: function (type?: any, options?: any, props?: any) {
        var light: any, args: any, t: any, params = newObj(), udf = undefined, prop = newObj();
        if (typeof type == "object") {
            t = String(type.type || "").toLowerCase();
            args = type.params || type.args || type;
            prop = type.props || props || copyWithout(type, ["params", "type"]) || null;
        } else {
            args = typeof options == "object" ? (options.params || options.args || options) : {};
            t = String(type).toLowerCase();
            prop = typeof options == "object" ? (options.props || copyWithout(options, ["params", "type"])) : (props || null);
        }
        if (!t) t = 'light';

        var config = this.getConfigData(t);
        if (!config && isEmpty(config)) return null;
        params = Props.parseParams(args, config.params);
        var str = "light = new THREE." + config.name + "(";
        var i = 0;
        for (const key in params) {
            if (Object.hasOwnProperty.call(params, key)) {
                const value = params[key];
                if (config.props[key] == "color" && !isColor(value)) params[key] = Props.parseColorIntVal(value);
                str += (i ? ', ' : '') + "params." + key;
                i++;
            }
        }
        str += ");";

        try {
            eval(str);
        } catch (error) {
            // console.log(error);
        }
        // console.log(light);
        if (!light) return null;
        if (light.type == "ReactAreaLight") {
            var la = [0, 0, 0];
            if (args.lookAt) {
                if (isArray(args.lookAt)) {
                    for (let i = 0; i < args.lookAt.length; i++) {
                        const v = args.lookAt[i];
                        la[i] = v;
                    }
                }
                else if (isObject(args.lookAt)) {
                    var p = ["x", "y", "z"];
                    for (let i = 0; i < p.length; i++) {
                        const v = p[i];
                        if (typeof args.lookAt[v] != "undefined" && isNumber(args.lookAt[v])) la[i] = args.lookAt[v];
                    }

                }
            }
            light.lookAt.apply(light, la);
        }
        var lightProps = assignWithout({}, prop, params, ["type", "params", "args", "options"]);
        this.setProperties(light, lightProps);
        // console.log(light)
        return light;

    },

    parseProperties: function parseProperties(light?: any, inputProps?: any) {
        var outputProps = {};
        if (typeof inputProps == "object") {
            // console.log("light obj");
            var il = [];
            for (let index = 2; index < arguments.length; index++) {
                const list = arguments[index];
                if (isArray(list)) {
                    for (let i = 0; i < list.length; i++) {
                        const field = list[i];
                        il.push(field);
                    }
                } else if (isObject(list)) {
                    for (const field in list) {
                        if (list.hasOwnProperty(field)) {
                            const val = list[field];
                            il.push(field);
                        }
                    }
                }
            }

            var propTypes = this.getTypeProps(light.type);
            for (const key in inputProps) {
                if (inputProps.hasOwnProperty(key) && typeof propTypes[key] != "undefined" && !inArray(il, key)) {
                    let val = inputProps[key];
                    var setable = [
                        "Boolean", "Integer", "String", "Function", "Number", "Object"
                    ];
                    var checkBefore = ["Object3D", "Euler", "Vector3", "Euler"];
                    const type = typeof propTypes[key] != "undefined" ? propTypes[key] : null;
                    if (!type || type == "Locked") {
                        continue;
                    }
                    // else if (type == "set") {
                    //     var tv = getType(val);
                    //     if (!inArray(["object", "array"], tv)) continue;
                    //     if (tv == "array") {
                    //         if (typeof light[key] == "object" && typeof light[key].set == "function") {
                    //             light[key].set.apply(light[key], val);
                    //         }
                    //     }
                    //     else {
                    //         assignValue(light, key, val);
                    //     }

                    // }
                    else if (type === "Color") {
                        outputProps[key] = parseColor(val);
                    }
                    else if (inArray(setable, type)) {
                        if (checkType(type, val)) {
                            assignValue(obj, key, val);
                        }
                    }

                    else if (inArray(checkBefore, type)) {

                        if (isObject(val)) {
                            if (val["is" + type]) {
                                outputProps[key] = val
                            } else if (val.$three) {
                                var obj = Props.parse(val);
                                if (obj && obj["is" + type]) {
                                    outputProps[key] = obj;
                                }
                            }
                            else {
                                if (light[key] && isObject(light[key])) {
                                    assignValue(outputProps, key, val)
                                }
                            }
                        }
                    }

                    else if (key == "shadow" && light[key] != undefined && isObject(val)) {

                        assignValue(outputProps, key, val)

                    }
                    else if (typeof type == "function") {
                        if (type(val)) {
                            assignValue(outputProps, key, val);
                        }
                    } else if (typeof type == "string") {
                        var ts = type.split("|");
                        var s = false;

                        for (let i = 0; i < ts.length; i++) {
                            const ti = ts[i];
                            const tis = ti.split(":");
                            if (tis.length == 1) {
                                // console.log(key, type, val);
                                if (ti.toLowerCase() == "boolean") {
                                    val = val === true || val == 1 || String(val).toLowerCase() == "on" ? true : false;
                                    s = true;
                                    i += ts.length;
                                } else if (checkType(ti.trim(), val)) {
                                    s = true;
                                    i += ts.length;
                                }

                            }
                            else if (tis[0].toLowerCase() == "boolean") {
                                val = val === true || val == 1 || String(val).toLowerCase() == "on" ? true : false;
                                s = true;
                                i += ts.length;
                            }

                            else if (checkType(tis[0].trim(), val)) {
                                if (tis.length > 1) {
                                    let vl = tis[1].trim().split(",").map(function (v) {
                                        return String(v).trim();
                                    });
                                    if (inArray(vl, String(val))) {
                                        s = true;
                                        i += ts.length;
                                    }
                                }
                            }
                        }
                        if (s) {
                            assignValue(outputProps, key, val);
                            // console.log(obj[key])

                        }
                    }
                }
            }
        }
        return outputProps;
    },
    setProperties: function setProperties(light?: any, props?: any) {
        if (typeof props == "object") {
            // console.log("light obj");
            var il = [];
            for (let index = 2; index < arguments.length; index++) {
                const list = arguments[index];
                if (isArray(list)) {
                    for (let i = 0; i < list.length; i++) {
                        const field = list[i];
                        il.push(field);
                    }
                } else if (isObject(list)) {
                    for (const field in list) {
                        if (list.hasOwnProperty(field)) {
                            const val = list[field];
                            il.push(field);
                        }
                    }
                }
            }

            var propTypes = this.getTypeProps(light.type);
            for (const key in props) {

                if (props.hasOwnProperty(key) && typeof propTypes[key] != "undefined" && !inArray(il, key)) {
                    let val = props[key];
                    var setable = [
                        "Boolean", "Integer", "String", "Function", "Number", "Object"
                    ];
                    var checkBefore = ["Object3D", "Euler", "Vector3", "Euler"];
                    const type = typeof propTypes[key] != "undefined" ? propTypes[key] : null;
                    if (!type || type == "Locked") {
                        continue;

                    }
                    else if (type == "set") {
                        var tv = getType(val);
                        if (!inArray(["object", "array"], tv)) continue;
                        if (tv == "array") {
                            if (typeof light[key] == "object" && typeof light[key].set == "function") {
                                light[key].set.apply(light[key], val);
                            }
                        }
                        else {
                            assignValue(light, key, val);
                        }

                    }
                    else if (type === "Color") {
                        light[key] = parseColor(val);
                    }
                    else if (inArray(setable, type)) {
                        if (checkType(type, val)) {
                            assignValue(light, key, val);
                        }
                    }

                    else if (inArray(checkBefore, type)) {

                        if (isObject(val)) {
                            if (val["is" + type]) {
                                light[key] = val
                            } else if (val.$three) {
                                var obj = Props.parse(val);
                                if (obj && obj["is" + type]) {
                                    light[key] = obj;
                                }
                            }
                            else {
                                if (light[key] && isObject(light[key])) {
                                    assignValue(light, key, val)
                                }
                            }
                        }
                    }

                    else if (key == "shadow" && light[key] != undefined && isObject(val)) {

                        assignValue(light[key], val)

                    }
                    else if (typeof type == "function") {
                        if (type(val)) {
                            assignValue(light, key, val);
                        }
                    } else if (typeof type == "string") {
                        var ts = type.split("|");
                        var s = false;

                        for (let i = 0; i < ts.length; i++) {
                            const ti = ts[i];
                            const tis = ti.split(":");
                            if (tis.length == 1) {
                                // console.log(key, type, val);
                                if (ti.toLowerCase() == "boolean") {
                                    val = val === true || val == 1 || String(val).toLowerCase() == "on" ? true : false;
                                    s = true;
                                    i += ts.length;
                                } else if (checkType(ti.trim(), val)) {
                                    s = true;
                                    i += ts.length;
                                }

                            }
                            else if (tis[0].toLowerCase() == "boolean") {
                                val = val === true || val == 1 || String(val).toLowerCase() == "on" ? true : false;
                                s = true;
                                i += ts.length;
                            }

                            else if (checkType(tis[0].trim(), val)) {
                                if (tis.length > 1) {
                                    let vl = tis[1].trim().split(",").map(function (v) {
                                        return String(v).trim();
                                    });
                                    if (inArray(vl, String(val))) {
                                        s = true;
                                        i += ts.length;
                                    }
                                }
                            }
                        }
                        if (s) {
                            assignValue(light, key, val);
                            // console.log(obj[key])

                        }
                    }
                }
            }

            // console.log("end light");
        }
        return light;
    },

    getLightProperties: function getLightProperties(light?: any) {
        var props = {};
        if (isObject(light) && light.isLight) {
            var propTypes = this.getTypeProps(light.type);
            for (const key in propTypes) {
                if (Object.hasOwnProperty.call(propTypes, key)) {
                    const type = propTypes[key];
                    if (typeof light[key] != "undefined") {
                        props[key] = light[key];
                    }
                }
            }
        }
        return props;
    },



    /**
     * lay thuoc tinh cua anh sang
     * @param {string} lightType loai anh sanh
     * @returns {object}
     */
    getTypeProps: function (lightType?: any) {
        var propTypes = {},
            type = String(lightType).toLowerCase();
        if (typeof this.lightPropertyTypes[type] == "undefined") return propTypes;
        assignValue(propTypes, this.lightPropertyTypes.object3d);
        assignValue(propTypes, this.lightPropertyTypes.light);
        if (type != "light") {
            assignValue(propTypes, this.lightPropertyTypes[type]);
        }
        return propTypes;

    },


    /**
     * lay thuoc tinh cua anh sang
     * @param {string} lightType loai anh sanh
     * @returns {object}
     */
    getShadowPropTypes: function (lightType?: any) {
        var propTypes = {},
            type = String(lightType).toLowerCase();

        if (typeof this.shadowPropertyTypes[type] == "undefined") return propTypes;
        assignValue(propTypes, this.shadowPropertyTypes.light);
        if (type != "light") {
            assignValue(propTypes, this.shadowPropertyTypes[type]);
        }
        return propTypes;
    },

    getConfigData: function (type?: any) {
        type = String(type).toLowerCase();
        for (const key in this.lightConfigData) {
            if (Object.hasOwnProperty.call(this.lightConfigData, key)) {
                const config = this.lightConfigData[key];
                if (type == key || inArray(config.keywords, type)) {
                    return config;
                }
            }
        }
        return {};
    },

    lightConfigData: {
        ambientlight: {
            name: "AmbientLight",
            keywords: ["ambient", "a", "ambientlight", "al"],
            params: ["color", "intensity"],
            props: {}
        },
        ambientlightprobe: {
            name: "AmbientLightProbe",
            keywords: ["ambientlightprobe", "ambientprobe", "ap", "alp"],
            params: ["color", "intensity"],
            props: {}
        },
        directionallight: {
            name: "DirectionalLight",
            keywords: ["directionallight", "directional", "direction", "d"],
            params: ["color", "intensity"],
            props: {}
        },
        hemispherelight: {
            name: "HemisphereLight",
            keywords: ["hemispherelight", "hemisphere", "h", "hl"],
            params: ["color", "groundColor", "intensity"],
            props: {}
        },
        hemispherelightprobe: {
            name: "HemisphereLight",
            keywords: ["hemispherelightprobe", "hemisphereprobe", "hp", "hlp"],
            params: ["skyColor", "groundColor", "intensity"],
            props: {}
        },
        pointlight: {
            name: "PointLight",
            keywords: ["pointlight", "point", "p", "pl"],
            params: ["color", "intensity", "distance", "decay"],
            props: {}
        },
        rectarealight: {
            name: "RectAreaLight",
            keywords: ["rectarealight", "rectarea", "rect", "rectlight", "r", "rl", "ral"],
            params: ["color", "intensity", "width", "height"],
            props: {}
        },
        spotlight: {
            name: "SpotLight",
            keywords: ["rectarealight", "rectarea", "rect", "rectlight", "r", "rl", "ral"],
            params: ["color", "intensity", "distance", "angle", "penumbra", "decay"],
            props: {}
        },
        lightprobe: {
            name: "LightProbe",
            keywords: ["lightprobe", "lp", "probe"],
            params: [],
            props: {}
        },
        light: {
            name: "Light",
            keywords: ["light", "l"],
            params: ["color", "intensity"],
            props: {}
        },

    },


    lightPropertyTypes: {
        object3d: {
            // animations: "AnimationClip",
            castShadow: "Locked",
            children: "Object3D",
            // customDepthMaterial: "Material",
            // customDistanceMaterial: "Material",
            // frustumCulled: "Boolean",
            // id: "Integer",
            // layers: "Layers",
            // matrix: "Matrix4",
            // matrixAutoUpdate: "Boolean",
            // matrixWorld: "Matrix4",
            // matrixWorldNeedsUpdate: "Boolean",
            // modelViewMatrix: "Matrix4",
            name: "String",
            // normalMatrix: "Matrix3",
            // onAfterRender: "Function",
            onBeforeRender: "Function",
            // parent: "Object3D",
            position: "Vector3",
            // quaternion: "Quaternion",
            // receiveShadow: "Boolean",
            renderOrder: "Number",
            rotation: "Euler",
            scale: "Vector3",
            up: "Vector3",
            userData: "Object",
            // uuid: "String",
            visible: "Boolean"
        },
        light: {
            color: "Color",
            intensity: "Float"

        },
        lightprobe: {
            sh: "SphericalHarmonics3"
        },
        ambientlight: {

        },
        ambientlightprobe: {

        },
        directionallight: {
            castShadow: "Boolean",
            position: "Vector3",
            shadow: "DirectionalLightShadow",
            target: "Object3D"
        },
        hemispherelight: {
            color: "Color",
            groundColor: "Color",
            position: "Vector3"
        },
        hemispherelightprobe: {

        },
        pointlight: {
            decay: "Float",
            distance: "Float",
            power: "Float",
            shadow: "PointLightShadow",
            castShadow: "Boolean"

        },
        rectarealight: {

        },
        spotlight: {
            angle: "Float",
            castShadow: "Boolean",
            decay: "Float",
            distance: "Float",
            penumbra: "Float",
            position: "Vector3",
            power: "Float",
            shadow: "SpotLightShadow",
            target: "Object3D"
        }

    },
    shadowPropertyTypes: {
        light: {
            autoUpdate: "Boolean",
            camera: "Camera",
            bias: "Float",
            map: "WebGLRenderTarget",
            mapPass: "WebGLRenderTarget",
            mapSize: "Vector2",
            matrix: "Matrix4",
            needsUpdate: "Boolean",
            normalBias: "Float",
            radius: "Float"
        },
        pointlight: {

        },
        directionallight: {
            camera: "Camera"
        },
        spotlight: {
            camera: "Camera",
            focus: "Number"
        }

    }
});


for (const key in LightLib.lightConfigData) {
    if (Object.hasOwnProperty.call(LightLib.lightConfigData, key)) {
        const data = LightLib.lightConfigData[key];
        data.props = LightLib.getTypeProps(key);
        data.inputs = {};
        for (const key in data.props) {
            if (Object.prototype.hasOwnProperty.call(data.props, key)) {
                const type = data.props[key];
                let t = type.toLowerCase();
                if (inArray(['Vector3', 'Color', 'Number', 'Boolean', 'Float', 'String'], type)) {
                    let options: any = {};
                    let val = null;
                    if (type == "Vector3") {
                        if (key == "scale") {
                            val = {
                                x: 1, y: 1, z: 1
                            }
                        } else {
                            val = {
                                x: 0, y: 0, z: 0
                            }
                        }
                    } else if (type == "Color") {
                        val = "#FFF";
                    }
                    else if (type == "Boolean") {
                        val = false;
                    }
                    else if (key == "intensity") {
                        t = "range";
                        options = {
                            min: 0,
                            max: 4,
                            step: 0.01,
                            output: true
                        }
                        val = 1;
                    }
                    else if (type == "Float") {
                        options = {
                            min: 0,
                            step: 0.01
                        }
                        val = 0;
                    }
                    let inpCfg = getInputCfg(t, key, val, options);
                    // console.log(t, inpCfg);
                    if (inpCfg != null) {
                        data.inputs[key] = inpCfg;
                    }
                }
            }
        }
    }
}

interface AnyObject {
    [x: string]: any
}

var checkedValues = [];
function addCheckedItem(item) {
    if (inArray(checkedValues, item, true)) checkedValues.push(item);
}
/**
 * chuẩn hóa đối tượng và các giá trị của three js
 * @param {object} obj doi tuomg dau vao
 * @returns {object}
 */
const parseObject = function parseObject(obj: any, success?: any): AnyObject {
    if (typeof obj != "object") return obj;
    if (inArray(checkedValues, obj, true) || obj.uuid || obj.isMesh || obj.isColor || obj.isGeometry || obj.isMaterial) return obj;

    if (isObject(obj)) {
        if (obj.$three) {
            var newObj = {};
            let params = parseObject(assignWithout({}, obj.data || obj, ['$three']));
            var t = obj.$three.toLowerCase();
            switch (t) {
                case 'geometry':
                    newObj = Geometries.get(params);
                    break;
                case 'material':
                    newObj = Materials.get(params);
                    break;
                case 'mesh':
                    newObj = Meshes.get(params);
                    break;
                case 'texture':

                    newObj = LoaderLib.load(t, params, success);
                    break;
                case 'cubetexture':
                    newObj = LoaderLib.load(t, params, success);
                    break;

                case 'color':
                    newObj = createColor(params.hex || params.rgb || params.hsl || params.color);
                    break;


                default:
                    break;
            }
            return newObj;
        }
        else {
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    let element = obj[key];

                    var s = String(key).substr(0, 1);
                    if (s == '@') {
                        let n = String(key).substr(1);
                        let k = n.toLowerCase();
                        let params = parseObject(element, success);
                        if (k == 'geometry') {
                            let geo = Geometries.get(params);
                            delete obj[key];
                            obj[n] = geo;
                        } else if (k == 'material') {
                            let mesh = Materials.get(params);
                            delete obj[key];
                            obj[n] = mesh;
                        } else if (k == 'mesh') {
                            let mesh = Meshes.get(params);
                            delete obj[key];
                            obj[n] = mesh;
                        } else if (k == 'coler') {
                            let color = createColor(element);
                            delete obj[key];
                            obj[n] = color;
                        }
                        else if (isArray(element)) {
                            parse(obj[key], success);
                            addCheckedItem(obj[key]);
                        }

                    }
                    else if (isNumber(element)) {
                        obj[key] = Number(element);
                    }
                    else if (isString(element)) {
                        obj[key] = parseString(element);
                    }
                    else if (isObject(element)) {
                        if (Object.hasOwnProperty.call(element, '$three')) {
                            obj[key] = parseObject(element, success);

                        } else {
                            parseObject(obj[key], success);
                            addCheckedItem(obj[key]);
                        }
                    } else if (isArray(element)) {
                        parse(obj[key], success);
                        addCheckedItem(obj[key]);
                    }
                }
            }

        }
    }
    addCheckedItem(obj);
    return obj;
};


/**
 * chuẩn hóa đối tượng và các giá trị của three js
 * @param {array} obj doi tuomg dau vao
 * @returns {object}
 */
const parseArray = function parseArray(obj?: any, success?: any) {
    if (isArray(obj)) {
        for (let index = 0; index < obj.length; index++) {
            const element = obj[index];
            if (isObject(element)) {
                if (typeof element.$three != "undefined") {
                    obj[index] = parseObject(element, success);
                } else {
                    parseObject(element, success);
                }
            }
            else if (isArray(element)) {
                parseArray(element, success);
            } else if (isString(element)) {
                obj[index] = parseString(element);
            }
        }
        // if(typeof success == "function") success(obj);
    }
    return obj;

};


const parseThree = (key:string) => getObjectPropDepth(THREE, key);


/**
 * chuẩn hóa chuỗi thành giá trị trong js
 * @param {string} str chuoi dau vao
 * @returns {string}
 */
const parseString = function parseString(str?: any) {
    var e = String(str);
    // console.log(e);
    if (e.substr(0, 1) == '{' && e.substr(e.length - 1) == '}') {
        var f = e.substr(1, e.length - 2);
        var fp = f.split(".");
        var t = fp.shift();
        if(t=='THREE') return parseThree(fp.join("."));
        var vl = null;
        var exp = "vl = " + f + ";";
        try {
            eval(exp);
        } catch (error) {
            console.log(error);
        }
        if (vl !== null) {
            str = vl;
        }
    }
    return str;
};


/**
 * chuẩn hóa đối tượng và các giá trị của three js
 * @param {object|array|string} obj doi tuomg dau vao
 * @returns {object|array|string}
 */

const parse = function parse(obj?: any, success?: any): AnyObject {
    if (isObject(obj)) return parseObject(obj, success);
    else if (isArray(obj)) return parseArray(obj, success);
    else if (isString(obj)) return parseString(obj);
    return obj;
}




/**
 * lấy các tham số chứa trong phầm thông tin thiết lập đối tượng
 * @param {object|array} argms tham so cau hinh
 * @param {object|array} list tham so cau hinh
 * @param {array|object} opt danh sachs cac key trong constructor
 * @returns {object}
 */
const parseParams = function parseParams(argms?: any, list?: any, opt?: any): AnyObject {
    var params = newObj();
    opt = typeof opt == "object" ? opt : {};
    var args = argms && (isArray(argms) || isObject(argms)) ? argms : [];
    // nếu list đầu vào là một màng tên các tham số
    if (isArray(list)) {
        // và tham số cũng là 1 mảng
        if (isArray(args)) {
            for (let i = 0; i < list.length; i++) {
                const p = list[i];
                if (typeof args[i] != "undefined") {
                    params[p] = args[i];
                } else {
                    params[p] = typeof opt[p] != "undefined" ? opt[p] : undefined
                }
            }
        }
        // nếu tham số là object
        else {
            for (let i = 0; i < list.length; i++) {
                const p = list[i];
                if (typeof args[p] != "undefined") {
                    params[p] = args[p];
                } else {
                    params[p] = typeof opt[p] != "undefined" ? opt[p] : undefined
                }
            }
        }

    }
    // nếu list là một object có dạng key là tên tham số còn value gla giá trị mặc định
    else if (isObject(list)) {
        // duyệt list với các giá trị mặc định
        if (isArray(args)) {
            // biến đếm để lấy giá trị tham số theo thứ tự
            var i = 0;
            for (const key in list) {
                if (list.hasOwnProperty(key)) {
                    const defVal = list[key];
                    // opt là mảng giá trị mặc định không cần thứ tự
                    // lấy giá trị opt trước
                    params[key] = typeof opt[key] != 'undefined' ? opt[key] : (
                        // không có sẽ lấy trong args. không có nữa sẽ lấy bên list cũng là default
                        args && typeof args[i] != "undefined" ? args[i] : defVal
                    )
                    i++;
                }
            }
        } else {
            for (const key in list) {
                if (list.hasOwnProperty(key)) {
                    const defVal = list[key];
                    params[key] = args && typeof args[key] != "undefined" ? args[key] : (
                        typeof opt[key] != 'undefined' ? opt[key] : defVal
                    );
                }
            }
        }

    }
    if (params.color && (isString(params.color) || isNumber(params.color) || (isObject(params.color) && !params.color.isColor))) {
        params.color = createColor(params.color);
    }
    return parse(params);
};

const createColor = function createColor(color?: any) {
    var c = new THREE.Color(0xffffff).convertSRGBToLinear();
    if (isColor(color)) {
        if (isObject(color)) {
            c = new THREE.Color(color.r, color.g, color.b);
            c.convertSRGBToLinear();
        } else {
            c = new THREE.Color(parseColorIntVal(color));
            c.convertSRGBToLinear();
        }
    }
    return c;
}

/**
 * 
 * @param {THREE.Color} val 
 * @returns 
 */
const parseColor = (val) => {
    // console.log(val);
    return (isObject(val) && val.isColor) ? (val.totalSRGBToLinear ? val : val.convertSRGBToLinear()) : createColor(val);
}

const parseColorIntVal = function (val) {
    if (!isColor(val)) return 0;
    if (typeof val == "string") {
        if (val.substr(0, 1) == "#") {
            var b = parseInt(val.substr(1), 16);
            if (!isNaN(b) && isNumber(b)) {
                return b;
            }
        } else {
            var b = parseInt(val, 16);
            if (!isNaN(b) && isNumber(b)) {
                return b;
            }
        }
    } else if (isNumber(val)) {
        return val;
    }

    return 0;
};

const isColor = function isColor(obj: any): boolean {
    if (isInteger(obj)) return true;
    if (isString(obj)) {
        var re = /[0-9A-Fa-f]{6}/g;
        var re2 = /[0-9A-Fa-f]{3}/g;

        if (obj.substr(0, 1) == "#") {
            var hex = obj.substr(1);
            if (re.test(hex) || re2.test(hex)) return true;
        }
        else if (re.test(obj) || re2.test(obj)) return true;
    } else if (isObject(obj) && obj.isColor) return true;

    return false;
}


function getObjectAnimateHandler(options?: any): any {
    if (!isObject(options)) return null;
    var keys = [
        "updateHhndler",
        "handler",
        "animate",
        "animatehandler",
        "handlerdata",
        "updatehandlerdata",
        "animatedata",
        "updateanimatedata",
        "updateanimatehandlerdata"
    ];
    if (isObject(options.props)) {
        for (const key in options.props) {
            if (options.props.hasOwnProperty(key)) {
                const d = options.props[key];
                if (inArray(keys, key)) {
                    return d;
                }
            }
        }
    }
    for (const key in options) {
        if (options.hasOwnProperty(key)) {
            const d = options[key];
            if (inArray(keys, key)) {
                return d;
            }
        }
    }
    return null;
}

function Props(params?: any) {
    this.origin = params;
    this.parseData = parse(params);
}
Object.assign(Props.prototype, {
    constructor: Props,
    parse: parse,
    parseArray: parseArray,
    parseObject: parseObject,
    parseString: parseString,
    parseParams: parseParams,
    parseColorIntVal: parseColorIntVal,
    parseColor: parseColor,
    isColor: isColor,
    createColor: createColor,
    getObjectAnimateHandler: getObjectAnimateHandler,
    toString: function () {
        return this.toJSON();
    }
});
Props.parse = parse;
Props.parseArray = parseArray;
Props.parseObject = parseObject;
Props.parseString = parseString;
Props.createColor = createColor;
Props.isColor = isColor;
Props.parseColorIntVal = parseColorIntVal;
Props.parseColor = parseColor;
Props.parseParams = parseParams;
Props.getObjectAnimateHandler = getObjectAnimateHandler;


const TransparentBase64Image = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAQAAAAm93DmAAAAJ0lEQVR42u3MMQEAAAgDIGf/vN6G0BMCkOl6FaFQKBQKhUKhUCi8WVAwJunuz1eHAAAAAElFTkSuQmCC";

export {
    Meshes, Geometries, Materials, LoaderLib, LightLib, TransparentBase64Image
}

interface ThreeVector3 {
    x: number,
    y: number,
    z: number
}

interface ThreeVector2 {
    x: number,
    y: number
}

interface ThreeColor {
    r: number,
    g: number,
    b: number
}

export interface MeshMaterial {
    alphaMap: string,
    alphaTest: number,
    aoMap: string,
    aoMapIntensity: number,
    blendDst: number,
    blendDstAlpha: number,
    blendEquation: number,
    blendEquationAlpha: number,
    blendSrc: number,
    blendSrcAlpha: number,
    blending: any,
    bumpMap: string,
    bumpScale: number,
    clearcoat: number,
    clearcoatMap: string,
    clearcoatNormalMap: string,
    clearcoatNormalScale: ThreeVector3,
    clearcoatRoughness: number,
    clearcoatRoughnessMap: string,
    clipIntersection: boolean,
    clipShadows: boolean,
    clippingPlanes: any[],
    color: ThreeColor,
    colorWrite: boolean,
    combine: number,
    defines: Object,
    depthFunc: number,
    depthPacking: any,
    depthTest: boolean,
    depthWrite: boolean,
    displacementBias: number,
    displacementMap: string,
    displacementScale: number,
    dithering: boolean,
    emissive: ThreeColor,
    emissiveIntensity: number,
    emissiveMap: string,
    envMap: any,
    envMapIntensity: number,
    farDistance: number,
    flatShading: Boolean,
    fog: Boolean,
    gradientMap: string,
    id: number,
    lightMap: string,
    lightMapIntensity: number,
    map: string,
    matcap: string,
    metalness: number,
    metalnessMap: string,
    morphNormals: boolean,
    morphTargets: Boolean,
    name: String,
    nearDistance: number,
    needsUpdate: Boolean,
    normalMap: string,
    normalMapType: number,
    normalScale: ThreeVector2,
    opacity: number,
    polygonOffset: Boolean,
    polygonOffsetFactor: number,
    polygonOffsetUnits: number,
    precision: String,
    premultipliedAlpha: Boolean,
    referencePosition: ThreeVector3,
    reflectivity: number,
    refractionRatio: number,
    roughness: number,
    roughnessMap: string,
    shadowSide: number,
    shininess: number,
    side: number,
    size: number,
    sizeAttenuation: boolean,
    skinning: boolean,
    specular: ThreeColor,
    specularMap: string,
    stencilFail: number,
    stencilFunc: number,
    stencilFuncMask: number,
    stencilRef: number,
    stencilWrite: Boolean,
    stencilWriteMask: number,
    stencilZFail: number,
    stencilZPass: number,
    toneMapped: Boolean,
    transmission: number,
    transmissionMap: string,
    transparent: Boolean,
    type: string,
    userData: object,
    uuid: String,
    version: number,
    vertexColors: Boolean,
    vertexTangents: Boolean,
    visible: Boolean,
    wireframe: Boolean,
    wireframeLinecap: String,
    wireframeLinejoin: String,
    wireframeLinewidth: number
}

export interface MaterialSettingData {
    index: number,
    isArrayMAterial?: boolean,
    material: {
        ref: MeshMaterial,
        settings: { [prop: string]: any },
        editable: string[],
        type: string,
        inputs?: any[]
    },
    title: string
}