import {
    assignValue,
    assignWithout,
    getObjectPropDepth,
    inArray,
    isArray,
    isInteger,
    isNumber,
    isObject,
    isString,
    newObj,
    _defineProperties
} from '@app/_core/helpers/utils';
import * as THREEjs from 'three';
import { Geometries, LoaderLib, Materials, Meshes } from './three.libs';
const THREE = THREEjs;

interface AnyObject {
    [x:string]:any
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
const parseObject = function parseObject(obj:any, success:any=undefined):AnyObject {
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
const parseArray = function parseArray(obj:any=undefined, success:any=undefined) {
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
const parseString = function parseString(str:any=undefined) {
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

const parse = function parse(obj:any=undefined, success:any=undefined):AnyObject {
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
const parseParams = function parseParams(argms:any=undefined, list:any=undefined, opt:any=undefined):AnyObject {
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

const createColor = function createColor(color:any=undefined) {
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
    return (isObject(val) && val.isColor) ? (val.totalSRGBToLinear?val:val.convertSRGBToLinear() ) : createColor(val);
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

const isColor = function isColor(obj:any):boolean {
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


function getObjectAnimateHandler(options:any=undefined):any {
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

function Props(params:any=undefined) {
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
export default Props;
export { Props, parse, parseArray, parseObject, parseString, createColor, isColor, parseColorIntVal, parseParams, parseColor };