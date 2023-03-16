var Helper = (function () {
    

    'use strict';

    // var Helper;
    var global = this || window;
    var Helper = function () { };
    function addToGlobal(name, value) {
        global[name] = value;
    }

    // console log
    var cl = function () {
        console.log.apply(console, arguments);
    };


    // mang
    var arr = [];

    var document = window.document;

    var div = document.createElement("div");

    // var getProto = Object.getPrototypeOf;

    var slice = arr.slice;

    var createElement = document.createElement;


    // var $$;
    if (typeof Object.assign != 'function') {

        Object.assign = function (target, varArgs) { // .length của function là 2
            'use strict';
            if (target == null) { // TypeError nếu undefined hoặc null
                throw new TypeError('Cannot convert undefined or null to object');
            }

            var to = Object(target);

            for (var index = 1; index < arguments.length; index++) {
                var nextSource = arguments[index];

                if (nextSource != null) { // Bỏ qua nếu undefined hoặc null
                    for (var nextKey in nextSource) {
                        // Avoid bugs when hasOwnProperty is shadowed
                        if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                            to[nextKey] = nextSource[nextKey];
                        }
                    }
                }
            }
            return to;
        };
    }


    var isFunction = function isFunction(obj) {

        // Support: Chrome <=57, Firefox <=52
        // In some browsers, typeof returns "function" for HTML <object> elements
        // (i.e., `typeof document.createElement( "object" ) === "function"`).
        // We don't want to classify *any* DOM node as a function.
        return typeof obj === "function" && typeof obj.nodeType !== "number";
    };

    var isCallable = function (variable) {
        return typeof variable === "function";
    };

    /**
     * lấy kiểu giá trị của biến
     * @param {*} obj
     * @return {string}
     */
    var getType = function (obj) {
        var t = 'null';
        var type = typeof obj;
        if (type == 'object') {
            if (obj === null) {
                t = 'null';
            } else if (obj.constructor == FormData) {
                t = 'formdata';
            } else if (obj.constructor == Array) {
                t = 'array';
            } else if (obj.constructor == Object) {
                t = 'object';
            } else if (obj.constructor == Number) {
                t = 'number';
            } else {
                t = 'object';
            }
        } else {
            t = type;
        }
        return t;
    };
    /**
     * kiềm tra có phải chuỗi
     * @param {*} variable biến bất kỳ
     */
    var isString = function isString(variable) {
        var type = getType(variable);
        return type == "string" || type == "number";
    }
    /**
     * kiềm tra có phải null
     * @param {*} variable biến bất kỳ
     */
    var isNull = function isNull(variable) {
        return getType(variable) == "null";
    }
    /**
     * kiềm tra có phải array
     * @param {*} variable biến bất kỳ
     */
    var isArray = function isArray(variable) {
        return getType(variable) == "array";
    }
    /**
     * kiềm tra có phải object
     * @param {*} variable biến bất kỳ
     */
    var isObject = function isObject(variable) {
        return getType(variable) == "object";
    }

    /**
     * kiềm tra có phải number
     * @param {*} variable biến bất kỳ
     */
    var isNumber = function isNumber(variable) {
        var type = getType(variable);
        return (type === "number" || type === "string") && !isNaN(variable - parseFloat(variable));
    }
    /**
     * kiềm tra có phải number
     * @param {*} variable biến bất kỳ
     */
    var isInteger = function isInteger(variable) {
        return isNumber(variable) && String(parseInt(variable)) == String(variable);
    }
    /**
     * kiềm tra có phải Formdata
     * @param {*} variable biến bất kỳ
     */
    var isFormData = function isFormData(variable) {
        return getType(variable) == "formdata";
    }

    /**
     * kiềm tra có phải chuỗi
     * @param {*} variable biến bất kỳ
     */
    var isEmail = function isEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    };

    var checkEmptyType = {
        object: function (object) {
            for (const key in object) {
                if (object.hasOwnProperty(key)) {
                    return false;
                }
            }
            return true;
        },
        array: function (ar) { return ar.length == 0; },
        string: function (ar) { return ar.length == 0; }
    };
    var isEmpty = function (any) {
        if (typeof any == "undefined") return true;
        var type = getType(any);

        return typeof checkEmptyType[type] == "function" ? checkEmptyType[type](any) : (!any);
    }
    var emptyFunc = function () { };

    /**
     *
     * @param {object} dst
     * @param {object} src
     * @returns {object}
     */
    var merge = function (dst, src) {
        if (!dst || !isObject(dst)) dst = {};
        var to = Object(dst);
        var srclength = arguments.length;
        for (let i = 1; i < srclength; i++) {
            const srcObj = arguments[i];
            if (isObject(srcObj)) {
                for (const key in srcObj) {
                    if (srcObj.hasOwnProperty(key)) {
                        const val = srcObj[key];
                        if ((isObject(val) || isArray(val)) && !isFormData(val) && val.constructor != CrazyXHR && val.constructor != CrazyAJAX && val.constructor != Promise) {
                            var d = {};
                            to[key] = merge(d, val);
                        } else {
                            to[key] = val;
                        }
                    }
                }
            }
        }
        return dst;
    }

    /**
     * sao chép toàn bộ thuộc tính của một object sang 1 onject mới
     * @param {object} src
     * @returns {object}
     */
    var deepCopy = function (src) {
        var dst = {};
        var srclength = arguments.length;
        for (let i = 0; i < srclength; i++) {
            const srcObj = arguments[i];
            if (isArray(srcObj) && srclength == 1) {
                dst = [];
                for (let i = 0; i < srcObj.length; i++) {
                    const val = srcObj[i];
                    if ((isObject(val) || isArray(val)) && !isFormData(val)) {
                        dst[i] = deepCopy(val);
                    }
                    else {
                        dst[i] = val;
                    }
                }
            }
            else if (isObject(srcObj)) {
                for (const key in srcObj) {
                    if (srcObj.hasOwnProperty(key)) {
                        const val = srcObj[key];
                        if ((isObject(val) || isArray(val)) && !isFormData(val)) {
                            dst[key] = deepCopy(val);
                        }
                        else {
                            dst[key] = val;
                        }
                    }
                }
            }
        }
        return dst;
    };

    /**
     * sao chep gia tri trong mang
     * @param {array|object} src mang doi tuong  can sao chep
     */
    var copyArray = function (src) {
        var arr = [];
        var t = getType(src);
        if (t == 'object' || t == 'array') {
            if (src.length) {
                for (let index = 0; index < src.length; index++) {
                    if (typeof src[index] != "undefined") {
                        arr.push(src[index]);
                    }
                }
            } else if (t == 'object') {
                for (const key in src) {
                    if (src.hasOwnProperty(key)) {
                        const item = src[key];
                        arr.push(item);
                    }
                }
            }
        }
        return arr;
    };


    var combine = function combine(list) {
        var sth = function (lst, i) {
            if (!i) i = 0;
            var ls = [];
            if (lst.length <= i) return [];
            var arr = lst[i];
            arr.map(function (c) {
                var s = c;
                if (i < lst.length - 1) {
                    var tl = sth(lst, i + 1);
                    if (tl.length) {
                        tl.map(function (t) {
                            ls.push(c + "" + t);
                        });
                    } else {
                        ls.push(c);
                    }
                } else {
                    ls.push(c);
                }
            });
            return ls;
        };
        return sth(list);
    };


    var objectKeys = function (obj) {
        var keys = [];
        if (isArray(obj) || isObject(obj)) {
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    keys.push(key);
                }
            }
        }
        return keys;
    };
    var objectValues = function (obj) {
        var values = [];
        if (isArray(obj) || isObject(obj)) {
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    values.push(obj[key]);
                }
            }
        }
        return values;
    };

    var isProperty = function isProperty(object, key) {
        return Object.hasOwnProperty.call(object, key);
    }
    var isMethod = function isisMethod(object, key) {
        return typeof object[key] == "function";
    }

    /**
     * kiểm tra giá trị có trong mảng / object hay không
     * @param {array} arr mảng
     * @param {*} value
     * @returns {boolean}
     */
    var hasValue = function hasValue(arr, value, checkType) {
        if (typeof arr == "undefined") return false;
        var t = getType(arr);
        if (t == 'array') {
            if (checkType == true) {
                for (let index = 0; index < arr.length; index++) {
                    const v = arr[index];
                    if (v === value) return true;
                }
            } else {
                return arr.indexOf(value) >= 0;
            }
        } else if (t == 'object') {
            if (checkType) {
                for (const key in arr) {
                    if (arr.hasOwnProperty(key)) {
                        const v = arr[key];
                        if (v === value) {
                            return true;
                        }
                    }
                }
            } else {
                for (const key in arr) {
                    if (arr.hasOwnProperty(key)) {
                        const v = arr[key];
                        if (v == value) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * kiểm tra giá trị có trong mảng / object hay không
     * @param {array} arr mảng
     * @param {*} value
     * @returns {boolean}
     */
    var inArray = function inArray(arr, value, checkType) {
        if (typeof arr == "undefined") return false;
        var t = getType(arr);
        if (t != "array" && t != "object" && (isArray(value) || isObject(value))) {
            var c = arr;
            arr = value;
            value = c;
            t = getType(arr);
        }
        if (t == 'array') {
            if (checkType == true) {
                for (let index = 0; index < arr.length; index++) {
                    const v = arr[index];
                    if (v === value) return true;
                }
            } else {
                return arr.indexOf(value) >= 0;
            }
        } else if (t == 'object') {
            if (checkType) {
                for (const key in arr) {
                    if (arr.hasOwnProperty(key)) {
                        const v = arr[key];
                        if (v === value) {
                            return true;
                        }
                    }
                }
            } else {
                for (const key in arr) {
                    if (arr.hasOwnProperty(key)) {
                        const v = arr[key];
                        if (v == value) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    var cutWithout = function cutWithout(obj, keys) {
        var newObj = {};
        if (isArray(obj) || isObject(obj)) {
            var list = [];
            if (isArray(keys)) list = keys;
            else if (isObject(keys)) {
                for (const key in keys) {
                    if (keys.hasOwnProperty(key)) {
                        const v = keys[key];
                        list.push(key);
                    }
                }
            }

            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    const val = obj[key];
                    if (!inArray(list, key)) {
                        newObj[key] = val;
                    }
                }
            }
        }
        return newObj;
    }

    var copyWithout = function cutWithout(obj, keys) {
        var newObj = {};
        if (isArray(obj) || isObject(obj)) {
            var list = [];
            if (isArray(keys)) list = keys;
            else if (isObject(keys)) {
                for (const key in keys) {
                    if (keys.hasOwnProperty(key)) {
                        const v = keys[key];
                        list.push(key);
                    }
                }
            }

            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    const val = obj[key];
                    if (!inArray(list, key)) {
                        newObj[key] = val;
                    }
                }
            }
        }
        return newObj;
    };




    var documentReady = function () {
        if (document.readyState !== 'complete') return;
        return true;


    };

    var isGlobalOrRoot = function (obj) {
        return obj == global || obj == document;
    };

    /**
     * so sánh giá trị bên trong 2 đối tượng
     * @param {object} left đối tượng muốn so sánh
     * @param {object} right đối tượng dùng để so sánh
     * @param {undefined|string} k prefix key
     * @param {undefined|array} list kết quả so sánh. rỗng nghĩa là không có khax1 biệt
     * @returns {array}
     */
    var compareObject = function compareObject(left, right, k, list) {
        if (!k) k = "";
        if (k) k = k + ".";
        if (list) list = [];
        if (typeof left != "object" || typeof right != "object") {
            list.push({
                key: k,
                value_left: left,
                value_right: right
            });
        }
        for (const key in left) {

            if (left.hasOwnProperty(key)) {
                const vl = left[key];
                if (!right || typeof right[key] != typeof vl) {
                    list.push({
                        key: k + key,
                        value_left: vl,
                        value_right: right[key]
                    });
                } else if ((isObject(vl) || isArray(vl)) && isObject(right[key]) || isArray(right[key])) {
                    list = compareObject(vl, right[key], k + key, list);
                } else if (vl != right[key]) {

                    list.push({
                        key: k + key,
                        value_left: vl,
                        value_right: right[key]
                    });
                }

            }
        }
    }

    /**
     * lay ra gia tri nho nhat
     * @param {array|object} obj doi tuong mang chua cac gia tri 
     */
    var minOf = function minOf(obj) {
        var min = NaN;
        if (arguments.length > 1 && !(isArray(obj) || isObject(obj))) {
            obj = copyArray(arguments);
        }
        if (isArray(obj)) {
            for (let index = 0; index < obj.length; index++) {
                if (!isNumber(obj[index])) continue;
                const n = Number(obj[index]);

                if (isNaN(min) || !index)
                    min = n;
                else if (n < min) min = n;
            }
        }
        else if (isObject(obj)) {
            var index = 0;
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    if (!isNumber(obj[index])) continue;
                    else {
                        const n = Number(obj[index]);
                        if (isNaN(min) || !index) min = n;
                        else if (n < min) min = n;
                    }
                    index++;
                }
            }
        }
        return min;
    };

    /**
     * lay ra gia tri lon nhat
     * @param {array|object} obj doi tuong mang chua cac gia tri 
     */
    var maxOf = function maxOf(obj) {
        var min = NaN;
        if (arguments.length > 1 && !(isArray(obj) || isObject(obj))) {
            obj = copyArray(arguments);
        }
        if (isArray(obj)) {
            for (let index = 0; index < obj.length; index++) {
                if (!isNumber(obj[index])) continue;
                else {
                    const n = Number(obj[index]);
                    if (isNaN(min) || !index) min = n;
                    else if (n > min) min = n;
                }
            }
        }
        else if (isObject(obj)) {
            var index = 0;
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    if (!isNumber(obj[index])) continue;
                    else {
                        const n = Number(obj[index]);
                        if (isNaN(min) || !index) min = n;
                        else if (n > min) min = n;
                    }
                    index++;
                }
            }
        }
        return min;
    };

    function _instanceof(left, right) {
        if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) {
            return !!right[Symbol.hasInstance](left);
        } else {
            return left instanceof right;
        }
    };

    function _classCallCheck(instance, Constructor) {
        if (!_instanceof(instance, Constructor)) {
            throw new TypeError("Cannot call a class as a function");
        }
    };

    function _defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ("value" in descriptor) descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    };

    function _createClass(Constructor, protoProps, staticProps) {
        if (protoProps) _defineProperties(Constructor.prototype, protoProps);
        if (staticProps) _defineProperties(Constructor, staticProps);
        return Constructor;
    };

    function _defineProperty(obj, key, value) {
        if (key in obj) {
            Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true
            });
        } else {
            obj[key] = value;
        }
        return obj;
    };
    var checkType = function checkType(type, value, absolultely) {
        if (typeof type !== "string" || !type) return false;
        var tl = type.toLowerCase();
        if (tl == "float") tl = 'number';
        if (tl == 'mixed') return true;
        var t = type.substr(0, 1).toUpperCase() + type.substr(1).toLowerCase();

        if (typeof this['is' + t] == "function") {
            return this['is' + t].call(this, value);
        }
        var t2 = getType(value);

        return absolultely ? t2 === tl : t2 == tl;
    }.bind(Helper);
    Helper.addModule = function (name, options) {
        if (!this.exists(name) && !this.isOrigin(name)) {
            if (isObject(options) && typeof options.init != "object") {
                if (!options.init_list) options.init_list = [];
                options.init = function (args) {
                    if (!args || typeof args == 'undefined') return;
                    for (var key of this.init_list) {
                        if (typeof args[key] != 'undefined') {
                            var d = args[key];
                            var t = getType(d);

                            var t2 = (typeof (this[key]) != 'undefined') ? getType(this[key]) : "string";
                            if ((t == 'array' && t2 == 'array') || (t == 'object' && t2 == 'object')) {
                                for (var k in d) {
                                    var v = d[k];
                                    this[key][k] = v;
                                }
                            } else {
                                this[key] = d;
                            }
                        }
                    }
                }
            }
            this[name] = options;
        }
    };
    Helper.parse = function (name, options) {
        if (!name) return null;
        if (isObject(name)) {
            for (const key in name) {
                if (name.hasOwnProperty(key)) {
                    const opt = name[key];
                    this.parse(key, opt);
                }
            }
            return true;
        }
        if (exists(name)) return this[name];
        this.addModule(name, options);
        if (this.exists(name)) return this[name];
        return null;
    };
    Helper.extend = function (name, options) {
        return this.parse(name, options);
    };
    Helper.exists = function (name) {
        return typeof this[name] != "undefined";
    };
    Helper.isOrigin = function (name) {
        return (this.originModules.indexOf(name) >= 0);
    };
    // Helper.isReady = function () {
    //     return background.documentReady;
    // };
    Helper.setDefault = function (object, data) {
        if (!data || typeof data == 'undefined') return;
        for (var key of object.init_list) {
            if (typeof data[key] != 'undefined') {
                var d = data[key];
                var t = this.getType(d);

                var t2 = (typeof (object[key]) != 'undefined') ? this.getType(object[key]) : "string";
                if ((t == 'array' && t2 == 'array') || (t == 'object' && t2 == 'object')) {
                    for (var k in d) {
                        var v = d[k];
                        object[key][k] = v;
                    }
                } else {
                    object[key] = d;
                }
            }
        }
        return object;
    };



    var getEl = function (obj, key, delimiter) {
        if (typeof obj == 'undefined') {
            return null;
        }
        if (typeof key == 'undefined') {
            return obj;
        }
        var tpo = getType(obj);
        var tpk = getType(key);
        if (tpo == 'array') {
            var k = NaN;
            if (tpk == 'number') {
                k = key;
            } else if (parseInt(key) != NaN) {
                k = parseInt(key);
            }
            if (!isNaN(k)) {
                if (typeof obj[k] != 'undefined') {
                    return obj[k];
                }
            }
        } else if (tpo == 'object' || obj == App) {
            if (tpk == 'number') {
                if (typeof obj[key] != 'undefined') {
                    return obj[key];
                }
            } else if (tpk == 'string') {
                if (typeof delimiter == 'undefined') {
                    delimiter = '.';
                } else {
                    var t = getType(delimiter);
                    if (t != 'string' && t != 'number') {
                        delimiter = '.';
                    }
                }
                var _keys = key.split(delimiter);
                var d = obj;
                for (var i = 0; i < _keys.length; i++) {
                    var k = _keys[i];
                    if (typeof d[k] != 'undefined') {
                        d = d[k];
                    } else {
                        d = null;
                        i += _keys.length;
                    }
                }
            }
            return d;
        }
        return null;
    };

    var Num = {
        rand: function (from, to) {
            if (!from) from = 0;
            if (!to) to = 0;
            if (from == 0) to++;
            var rand = Math.floor(Math.random() * to) + from;
            return rand;
        },
        currency: function (x) {
            return x.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1\.");
        }
    };

    var Str = {
        html_char_raw: ['%', '&', '=', '?', '#', '+', ':', '/', ' ', '\n', '{', '}'],
        html_char_enc: ['%25', '%26', '%3D', '%3F', '%23', '%2B', '%3A', '%2F', '+', '%0D%0A', '%7B', '%7D'],
        urlcode: { '%': '%25', '&': '%26', '=': '%3D', '?': '%3F', '#': '%23', '+': '%2B', ':': '%3A', '/': '%2F', ' ': '%20', '\n': '%0D%0A', '{': '%7B', '}': '%7D' },
        unicode: {
            js: ["\\u00e0", "\\u00e1", "\\u1ea1", "\\u1ea3", "\\u00e3", "\\u00e2", "\\u1ea7", "\\u1ea5", "\\u1ead", "\\u1ea9", "\\u1eab", "\\u0103", "\\u1eb1", "\\u1eaf", "\\u1eb7", "\\u1eb3", "\\u1eb5", "\\u00e8", "\\u00e9", "\\u1eb9", "\\u1ebb", "\\u1ebd", "\\u00ea", "\\u1ec1", "\\u1ebf", "\\u1ec7", "\\u1ec3", "\\u1ec5", "\\u00ec", "\\u00ed", "\\u1ecb", "\\u1ec9", "\\u0129", "\\u00f2", "\\u00f3", "\\u1ecd", "\\u1ecf", "\\u00f5", "\\u00f4", "\\u1ed3", "\\u1ed1", "\\u1ed9", "\\u1ed5", "\\u1ed7", "\\u01a1", "\\u1edd", "\\u1edb", "\\u1ee3", "\\u1edf", "\\u1ee1", "\\u00f9", "\\u00fa", "\\u1ee5", "\\u1ee7", "\\u0169", "\\u01b0", "\\u1eeb", "\\u1ee9", "\\u1ef1", "\\u1eed", "\\u1eef", "\\u1ef3", "\\u00fd", "\\u1ef5", "\\u1ef7", "\\u1ef9", "\\u0111", "\\u00c0", "\\u00c1", "\\u1ea0", "\\u1ea2", "\\u00c3", "\\u00c2", "\\u1ea6", "\\u1ea4", "\\u1eac", "\\u1ea8", "\\u1eaa", "\\u0102", "\\u1eb0", "\\u1eae", "\\u1eb6", "\\u1eb2", "\\u1eb4", "\\u00c8", "\\u00c9", "\\u1eb8", "\\u1eba", "\\u1ebc", "\\u00ca", "\\u1ec0", "\\u1ebe", "\\u1ec6", "\\u1ec2", "\\u1ec4", "\\u00cc", "\\u00cd", "\\u1eca", "\\u1ec8", "\\u0128", "\\u00d2", "\\u00d3", "\\u1ecc", "\\u1ece", "\\u00d5", "\\u00d4", "\\u1ed2", "\\u1ed0", "\\u1ed8", "\\u1ed4", "\\u1ed6", "\\u01a0", "\\u1edc", "\\u1eda", "\\u1ee2", "\\u1ede", "\\u1ee0", "\\u00d9", "\\u00da", "\\u1ee4", "\\u1ee6", "\\u0168", "\\u01af", "\\u1eea", "\\u1ee8", "\\u1ef0", "\\u1eec", "\\u1eee", "\\u1ef2", "\\u00dd", "\\u1ef4", "\\u1ef6", "\\u1ef8", "\\u0110"],
            vi: ["\u00e0", "\u00e1", "\u1ea1", "\u1ea3", "\u00e3", "\u00e2", "\u1ea7", "\u1ea5", "\u1ead", "\u1ea9", "\u1eab", "\u0103", "\u1eb1", "\u1eaf", "\u1eb7", "\u1eb3", "\u1eb5", "\u00e8", "\u00e9", "\u1eb9", "\u1ebb", "\u1ebd", "\u00ea", "\u1ec1", "\u1ebf", "\u1ec7", "\u1ec3", "\u1ec5", "\u00ec", "\u00ed", "\u1ecb", "\u1ec9", "\u0129", "\u00f2", "\u00f3", "\u1ecd", "\u1ecf", "\u00f5", "\u00f4", "\u1ed3", "\u1ed1", "\u1ed9", "\u1ed5", "\u1ed7", "\u01a1", "\u1edd", "\u1edb", "\u1ee3", "\u1edf", "\u1ee1", "\u00f9", "\u00fa", "\u1ee5", "\u1ee7", "\u0169", "\u01b0", "\u1eeb", "\u1ee9", "\u1ef1", "\u1eed", "\u1eef", "\u1ef3", "\u00fd", "\u1ef5", "\u1ef7", "\u1ef9", "\u0111", "\u00c0", "\u00c1", "\u1ea0", "\u1ea2", "\u00c3", "\u00c2", "\u1ea6", "\u1ea4", "\u1eac", "\u1ea8", "\u1eaa", "\u0102", "\u1eb0", "\u1eae", "\u1eb6", "\u1eb2", "\u1eb4", "\u00c8", "\u00c9", "\u1eb8", "\u1eba", "\u1ebc", "\u00ca", "\u1ec0", "\u1ebe", "\u1ec6", "\u1ec2", "\u1ec4", "\u00cc", "\u00cd", "\u1eca", "\u1ec8", "\u0128", "\u00d2", "\u00d3", "\u1ecc", "\u1ece", "\u00d5", "\u00d4", "\u1ed2", "\u1ed0", "\u1ed8", "\u1ed4", "\u1ed6", "\u01a0", "\u1edc", "\u1eda", "\u1ee2", "\u1ede", "\u1ee0", "\u00d9", "\u00da", "\u1ee4", "\u1ee6", "\u0168", "\u01af", "\u1eea", "\u1ee8", "\u1ef0", "\u1eec", "\u1eee", "\u1ef2", "\u00dd", "\u1ef4", "\u1ef6", "\u1ef8", "\u0110"],
            en: ["a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D"],
            upper: ["À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ"],
            lower: ["à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ"]
        },
        clearUnicode: function (str) {
            return this.replace(str, this.unicode.vi, this.unicode.en);
        },
        isSN: function (str) {
            if (typeof str == 'undefined') return null;
            var t = getType(str);
            if (t == 'string' || t == 'number') return true;
            return false;
        },
        /**
         * thay the chuoi trong chuoi bang mot chuoi =)))))
         * @param {string} str  chuoi dau vao
         * @param {string|object|array} find  tham so tim kiem
         * @param {string|object|array} replace  tham so thay the
         */
        replace: function () {
            var a = arguments;
            var t = a.length;
            if (t == 0) return '';
            if (typeof a[0] != 'string' || t < 2) {
                return a[0];
            }
            var str = a[0];

            var b = getType(a[1]);
            if (this.isSN(a[1])) {
                if (t >= 3 && this.isSN(a[2])) {
                    var obj = {};
                    obj[a[1]] = a[2];
                    str = this.replaceByObj(str, obj);
                }
            } else if (b == 'array') {
                if (t >= 3 && getType(a[2]) == 'array') {
                    str = this.replaceByArr(str, a[1], a[2]);
                } else if (t >= 3 && getType(a[2]) == 'string') {
                    var obj = {},
                        val = a[2];
                    var d = a[1];
                    for (var k in d) {
                        obj[d[k]] = val;
                    }
                    str = this.replaceByObj(str, obj);
                }
            } else if (b == 'object') {
                str = this.replaceByObj(str, a[1]);
            }
            return str;
        },
        replaceByArr: function () {
            var a = arguments;
            var t = a.length;
            if (t == 0) return '';
            if (typeof a[0] != 'string' || t < 2) {
                return a[0];
            }
            var str = a[0];
            var b = getType(a[1]);
            if (b == 'object') {
                str = this.replaceByObj(str, a[1]);
            } else if (b == 'array') {
                var obj = {};
                if (t >= 3) {
                    var f = getType(a[2]);
                    if (f == 'string') {
                        for (var k in a[1]) {
                            obj[a[1][k]] = a[2];
                        }
                    } else if (f == 'array') {
                        var e = a[1].length,
                            g = a[2].length;
                        var max = (e > g) ? e : g;
                        for (var i = 0; i < max; i++) {
                            obj[a[1][i]] = a[2][i];
                        }
                    }
                }
                str = this.replaceByObj(str, obj);
            }
            return str;
        },
        replaceByObj: function () {
            var a = arguments;
            var t = a.length;
            if (t == 0) return '';
            if (typeof a[0] != 'string' || t < 2) {
                return a[0];
            }
            var str = a[0];
            var b = getType(a[1]);
            if (b == 'object') {
                var max = null;
                if (typeof a[2] == 'number') {
                    max = a[2];
                }
                var i = 1;
                var sts = a[1];
                for (var key in sts) {
                    var txt = sts[key];
                    str = this.preg_replace(key, txt, str);
                    if (max && i >= max) break;
                    i++;
                }
            }
            return str;
        },
        escapeRegExp: function (string) {
            var str = "" + string + "";
            return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
        },

        preg_replace: function (find, replace, string) {
            var string = "" + string + "";
            return string.replace(new RegExp(this.escapeRegExp(find), 'g'), replace);
        },

        rand: function () {
            var st = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var sp = st.split('');
            var l = sp.length - 1;
            var s = '';
            for (var i = 0; i < 32; i++) {
                s += sp[Num.rand(0, l)];
            }
            return s;
        },
        camelToSlug: function (str, joinKey) {
            var st = 'BCDEFGHIJKLMNOPQRSTUVWXYZ';
            var sp = st.split('');
            var l = sp.length - 1;
            var s = '';
            var find = [];
            var replace = [];
            var k = isString(joinKey) ? joinKey : "-";
            sp.map(function (c) {
                find.push(c);
                replace.push(k + c.toLowerCase());
            });
            return this.replace(str, find, replace);
        },
        upperToWord: function (str) {
            var st = 'abcdefghijklmnopqrstuvwxyz';
            var sp = st.split('');
            var l = sp.length - 1;
            var s = this.clearUnicode(String(str));
            var find = [];
            var replace = "";
            sp.map(function (c) {
                find.push(c);
            });

            return this.lower(s.substr(0, 1)) + this.lower(this.replace(s.substr(1), find, replace));
        },


        urlencode: function (str) {
            var t = this.html_char_raw.length;
            for (var i = 0; i < t; i++) str = this.replace(str, this.html_char_raw[i], this.html_char_enc[i]);
            return str;
        },
        urldecode: function (str) {
            var t = this.html_char_raw.length;
            for (var i = t - 1; i >= 0; i--) str = this.replace(str, this.html_char_enc[i], this.html_char_raw[i]);
            return str;
        },
        eval: function (template, data) {
            var t = typeof data;
            var tpl = template;
            if (t == 'object' || t == "array") {
                data = this.convertTextObject({}, data);
                for (var k in data) {
                    var val = data[k];
                    if (val === null) val = '';
                    var f = "\{\$" + k + "\}";
                    tpl = this.replace(tpl, f, val);
                }
            }
            return tpl;
        },
        convertTextObject: function (root, object, name, joinKey) {
            for (const key in object) {
                if (object.hasOwnProperty(key)) {
                    if (typeof joinKey != "string") joinKey = ".";
                    const val = object[key];
                    var t = typeof val;
                    var k = (typeof name != "undefined" && ("" + name).length) ? name + joinKey + key : key;
                    if (val != null && (t == 'object' || t == "array")) {
                        root = this.convertTextObject(root, val, k, joinKey);
                    } else {
                        root[k] = val;
                    }
                }
            }
            return root;
        },
        upper: function (str) {
            if (typeof str == "undefined") return null;
            if (isString(str)) {
                var s = str.toUpperCase();
                return this.replace(s, this.unicode.lower, this.unicode.upper);
            }
            else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
                for (let i = 0; i < str.length; i++) {
                    str[i] = this.upper(str[i]);
                }
                return str;
            }
            else if (isObject(str)) {
                for (const key in str) {
                    if (str.hasOwnProperty(key)) {
                        const st = str[key];
                        str[key] = this.upper(st);
                    }
                }
                return str;

            }
        },
        lower: function (str) {
            if (typeof str == "undefined") return null;
            if (isString(str)) {
                var s = str.toLowerCase();
                str = this.replace(s, this.unicode.upper, this.unicode.lower);
            }
            else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
                for (let i = 0; i < str.length; i++) {
                    str[i] = this.upper(str[i]);
                }
            }
            else if (isObject(str)) {
                for (const key in str) {
                    if (str.hasOwnProperty(key)) {
                        const st = str[key];
                        str[key] = this.upper(st);
                    }
                }
            }

            return str;
        },
        ucfirst: function (str) {
            if (isString(str)) {
                if (str.length) {
                    var first = str.substring(0, 1);
                    str = this.upper(first) + str.substring(1);
                }
            }
            else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
                for (let i = 0; i < str.length; i++) {
                    str[i] = this.ucfirst(str[i]);
                }
            }
            else if (isObject(str)) {
                for (const key in str) {
                    if (str.hasOwnProperty(key)) {
                        str[key] = this.ucfirst(str[key]);
                    }
                }
            }
            return str;
        },
        ucword: function (str) {
            if (isString(str)) {
                if (str.length) {
                    str = str.split(" ").map(function (s) { return this.ucfirst(s) }).join(" ");
                }
            }
            else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
                for (let i = 0; i < str.length; i++) {
                    str[i] = this.ucword(str[i]);
                }
            }
            else if (isObject(str)) {
                for (const key in str) {
                    if (str.hasOwnProperty(key)) {
                        str[key] = this.ucword(str[key]);
                    }
                }
            }
            return str;
        },

        htmlentities: function (str) {
            return this.eval(str, {
                "<": "&lt;",
                ">": "&gt;",
                "\"": "&quote;",
                "&": "&amp;"
            });
        },
        formSlug: function (str) {
            return typeof str != "string" ? str : this.replace(this.replace(str, "[]", '.*'), { "[": ".", "]": "" });
        },
        slug: function (str, key) {
            if (!key) key = '-';
            var s = String(str);
            var l = 'BCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var list = [];
            var n = 0;
            var t = this.replace(this.replace(
                this.clearUnicode(this.lower(s)),
                "[]{}();:'\"\\|,./?~!@#$%^&*+=".split(""),
                "-"
            ), '--', '-');
            for (let i = 0; i < t.length; i++) {
                const st = t[i];
                if (l.indexOf(st) == -1) {
                    if (n > 0) {
                        if (l.indexOf(t[i - 1]) >= 0) n++;
                    }
                } else {
                    if (typeof list[n] == "undefined") {
                        list[n] = st;
                    } else {
                        list[n] += st;
                    }
                }
            }
            return list.join(key);
        }

    };





    var date = function (format, offset) {
        if (!offset) offset = 0;
        var d = new Date();
        var t = {};
        var dl = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];


        // convert to msec
        // add local time zone offset
        // get UTC time in msec
        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

        // create new Date object for different city
        // using supplied offset
        d = new Date(utc + (3600000 * offset));



        t.ms = d.getMilliseconds();
        t.Y = d.getFullYear();
        t.y = d.getYear();
        t.H = d.getHours();
        t.i = d.getMinutes();
        t.m = d.getMonth() + 1;
        t.s = d.getSeconds();
        t.time = d.getTime();
        t.d = d.getDate();
        t.D = dl[d.getDay()];
        if (!format) return t;
        var f = getType(format);
        if (f == 'string') {
            var txt = format;
            txt = Str.replace(txt, 'ms', t.ms);
            txt = Str.replace(txt, 'time', t.time);
            txt = Str.replace(txt, t);
            return txt;
        }
        return null;
    };

    var fn = function () {
        this.timeout_status = true;
        this.args_type = 'array';
        this.calling = null;
        this.system_list = {};

        this.disableTimeout = function () {
            this.timeout_status = false;
        };
        this.enableTimeout = function () {
            this.timeout_status = true;
            if (this.args_type == 'list') {
                this.args_type = 'array';
            }
        };
        this.setArgsType = function () {
            var a = arguments;
            var t = 'array';
            var tt = 0;
            if (a.length > 0) {
                t = a[0];
            }
            if (typeof t == 'string') {
                var t2 = t.toLowerCase();
                if (t2 != 'array' && t2 != '0') {
                    tt = 1;
                }
            } else if (t) {
                tt = 1;
            } else {
                tt = 0;
            }
            if (tt) {
                this.args_type = 'list';
                this.disableTimeout();
            } else {
                this.args_type = 'array';
            }
        };

        this.getFuncPath = function (fn) {
            if (!fn) return null;
            var t = getType(fn);
            var f = '';
            if (t == 'function') {
                f = 'fn';
            } else if (t == 'string') {
                var a = Str.replace(fn, ' ', '');
                if (!a) return null;

                if (getType(getEl(this, a)) == 'function') {
                    f = '_this.' + a;
                } else {
                    var func_paths = a.split('.');
                    if (func_paths.length < 2) {
                        if (typeof window[a] == 'function') {
                            f = a;
                        }
                    } else {
                        var kk = func_paths[0];
                        if (typeof window[kk] == 'object' || kk == "Helper") {
                            var kz = '';
                            for (var i = 1; i < func_paths.length; i++) {
                                var dt = '';
                                if (i > 1) dt = '.';
                                kz += (dt + func_paths[i]);
                                dt = '';
                            }
                            if (getType(getEl(window[kk], kz)) == 'function') {
                                f = a;
                            }
                        }

                    }
                }
            }
            return f;
        };
        this.get = function (fn) {
            var r = function () { console.log(arguments); };
            if (!fn) return r;
            var t = getType(fn);
            var f = '';
            var _this = this;
            if (t == 'function') {
                f = 'fn';
            } else if (t == 'string') {
                var fp = this.getFuncPath(fn);
                if (fp) {
                    f = fp;
                }
            }

            if (f) {
                eval('r = ' + f + ";");
            }
            return r;
        };
        this.check = function (fn) {
            if (typeof fn != 'string') return false;
            // console.log(this.getFuncPath(fn));
            if (this.getFuncPath(fn)) {
                return true;
            }
            return false;
        };
        this.add = function (func_name, fn, main) {
            if (typeof func_name != 'string' || typeof fn != 'function') return false;
            var s = false;
            if (!this.system_list[func_name]) {
                this[func_name] = fn;
                s = true;
            }


            return s;
        };
        this.remove = function (fn) {
            if (typeof fn != 'string') return false;
            if (!this.system_list[fn] && typeof this[fn] == 'function') {
                this[fn] = undefined;
                delete this[fn];
            }
            return true;
        };
        this.call = function (fn, args, time) {
            if (!fn) return null;
            var t = getType(fn);
            var f = '';
            var agm = arguments;
            if (t == 'function') {
                f = 'fn';
            } else if (t == 'string') {
                var fp = this.getFuncPath(fn);
                if (fp) {
                    f = fp;
                }
            }
            if (!f) return undefined;
            var _this = this;
            var arg = [];
            if (this.args_type == 'array') {
                if (typeof args != 'undefined') {
                    if (getType(args) == 'array') {
                        arg = args;
                    } else {
                        arg[0] = args;
                    }
                }
            } else {
                var n = 0;
                for (var i = 1; i < agm.length; i++) {
                    arg[n] = agm[i];
                    n++;
                }
            }
            var t = arg.length;
            f += "(";
            for (var i = 0; i < t; i++) {
                f += "arg[" + i + "]";
                if (i < t - 1) f += ",";
            }
            f += ");";
            var r = null;
            var o = "r = " + f;

            if (this.timeout_status && time) {
                if (getType(time) == 'number' && time > 0) {
                    this.calling = setTimeout(function () {
                        eval(o);
                        return r;
                    }, time);
                    return true;
                }
            }
            try {
                eval(o);
            } catch (error) {
                // ..
            }
            return r;
        };
        this.parse = function (fn) {
            var f = function () {

            };
            if (!fn) return f;
            var t = getType(fn);

            if (t == 'function') {
                f = fn;
            }
            else if (t == 'string') {
                if (this.check(fn)) {
                    f = this.get(fn);
                }
            }
            return f;
        };
        this.goTo = function (url) {
            window.open(url, '_blank');
        };

        this.openWindow = function (url, title, width, height, x, y) {
            var swidth = screen.width,
                sheight = screen.height;
            if (!width) width = 600;
            if (!height) height = 300;
            var left = (x) ? x : ((swidth - width) / 2),
                top = (y) ? y : ((sheight - height) / 2 - 100);
            if (top < 0) top = 0;
            if (!title) title = 'Blank Page';
            window.open(url, title, 'targetWindow,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=' + width + ',height=' + height + ',top=' + top + ',left=' + left);
        };
        var a = this;
        var st = {};
        for (var k in a) {
            st[k] = k;
        }
        this.system_list = st;
    };


    var func = new fn();



    var assignValue = function (target, key, value) {
        if (typeof target != "object") return target;
        if (Helper.isObject(key)) {
            for (const k in key) {
                if (key.hasOwnProperty(k)) {
                    const v = key[k];
                    assignValue(target, k, v);
                }
            }
        } else if ((isString(key) || isNumber(key)) && String(key).length) {
            if (String(key).substr(0, 1) == '@') {
                var f = key.substr(1);
                if (typeof target[f] == "function") {
                    target[f].apply(target, isArray(value) ? value : [value]);
                }
            }
            else if (isObject(value)) {
                if (typeof target[key] == "object") {
                    assignValue(target[key], value);
                } else {
                    target[key] = value;
                }
            } else {
                target[key] = value;

            }
        }
        return target;
    };

    var assignWithout = function (target, source) {
        if (typeof target != "object" || typeof source != "object") return target;
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
        for (const key in source) {
            if (source.hasOwnProperty(key)) {
                const val = source[key];
                if (!inArray(il, key)) {
                    assignValue(target, key, val);
                }
            }
        }
        return target;
    };
    var rgbToHex = function (rgb) {
        var hex = Number(rgb).toString(16);
        if (hex.length < 2) {
            hex = "0" + hex;
        }
        return hex;
    };
    var colorToHex = function (r, g, b) {
        var red = rgbToHex(r);
        var green = rgbToHex(g);
        var blue = rgbToHex(b);
        return "#" + red + green + blue;
    };

    Helper._instanceof = _instanceof;
    Helper.classCallCheck = _classCallCheck;
    Helper.defineProperties = _defineProperties;
    Helper.createClass = _createClass;
    Helper.defineProperty = _defineProperty;
    Helper.getType = getType;
    Helper.isArray = isArray;
    Helper.isObject = isObject;
    Helper.isString = isString;
    Helper.isNumber = isNumber;
    Helper.isInteger = isInteger;
    Helper.isEmail = isEmail;
    Helper.isNull = isNull;
    Helper.isFormData = isFormData;
    Helper.isEmpty = isEmpty;
    Helper.isCallable = isCallable;
    Helper.isFunction = isFunction;
    Helper.isProperty = isProperty;
    Helper.isMethod = isMethod;
    Helper.hasValue = hasValue;
    Helper.inArray = inArray;
    Helper.cutWithout = cutWithout;
    Helper.copyWithout = copyWithout;
    Helper.compareObject = compareObject;
    Helper.checkType = checkType;
    Helper.originModules = [];
    Helper.log = cl;
    Helper.deepCopy = deepCopy;
    Helper.copyArray = copyArray;
    Helper.objectKeys = objectKeys;
    Helper.objectValues = objectValues;
    Helper.merge = merge;
    Helper.combine = combine;
    Helper.number = Num;
    Helper.minOf = minOf;
    Helper.maxOf = maxOf;
    Helper.str = Str;
    Helper.date = date;
    Helper.func = func;
    Helper.fn = fn;
    Helper.getEl = getEl;
    Helper.assignValue = assignValue;

    Helper.assignWithout = assignWithout;
    Helper.colorToHex = colorToHex;

    return Helper;

}());