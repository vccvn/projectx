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

    // if(typeof Object.prototype.isEmpty != "function"){
    //     Object.prototype.isEmpty = function() {
    //         for(var key in this) {
    //             if(this.hasOwnProperty(key))
    //                 return false;
    //         }
    //         return true;
    //     }
    
    // }
    
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
        object: function(object){
            for (const key in object) {
                if (object.hasOwnProperty(key)) {
                    return false;
                }
            }
            return true;
        },
        array: function(ar){return ar.length == 0;},
        string: function(ar){return ar.length == 0;}
    };
    var isEmpty = function(any){
        if(typeof any == "undefined") return true;
        var type = getType(any);
        
        return typeof checkEmptyType[type] == "function" ? checkEmptyType[type](any) : (!any);
    }
    var emptyFunc = function () { };

    /**
     * gán sự kiện cho đối tượng dom
     * @param {Element} el đối tượng dom
     * @param {string} event sự kiện
     * @param {dunction} HandlerCallbackFunction hàm xử lý sự kiện
     */
    var addEventListener = function addEventListener(el, event, HandlerCallbackFunction) {
        if (!(el instanceof Element) && el != document) return false;
        let cb = (typeof HandlerCallbackFunction == "function") ? HandlerCallbackFunction : function (e) {
            App.func.call(HandlerCallbackFunction, [e.target]);
        };
        if (el.addEventListener) {
            el.addEventListener(event, cb);
        } else if (el.attachEvent) {
            el.attachEvent(event, cb);
        }
    }
    /**
     * Hủy một sự kiện trong dom
     * @param {Element} el 
     * @param {string} event 
     * @param {function} callback 
     */
    var removeEventListener = function removeEventListener(el, event, callback) {
        if (!(el instanceof Element) && el != document) return false;
        let cb = (typeof callback == "function") ? callback : function (e) {
            App.func.call(callback, [e.target]);
        };
        if (el.removeEventListener) {
            el.removeEventListener(event, cb);
        }
    }


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
                        if ((isObject(val) || isArray(val)) && !isFormData(val) && val.constructor != CrazyXHR && val.constructor != CrazyAJAX && val.constructor != Promise && val.constructor != App.dom.HtmlQuery && val.constructor != App.dom.Form) {
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
     * sao chép toàn bp65 thuộc tính của một object sang 1 onject mới
     * @param {object} src 
     * @returns {object}
     */
    var deepCopy = function (src) {
        var dst = {};
        var srclength = arguments.length;
        for (let i = 0; i < srclength; i++) {
            const srcObj = arguments[i];
            if(isArray(srcObj) && srclength == 1){
                dst = [];
                for (let i = 0; i < srcObj.length; i++) {
                    const val = srcObj[i];
                    if ((isObject(val) || isArray(val)) && !isFormData(val) && val.constructor != CrazyXHR && val.constructor != CrazyAJAX && val.constructor != Promise && val.constructor != App.dom.HtmlQuery && val.constructor != App.dom.Form) {
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
                        if ((isObject(val) || isArray(val)) && !isFormData(val) && val.constructor != CrazyXHR && val.constructor != CrazyAJAX && val.constructor != Promise && val.constructor != App.dom.HtmlQuery && val.constructor != App.dom.Form) {
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

    var copyArray = function (src) {
        var arr = [];
        var t = getType(src);
        if(t == 'object' || t == 'array'){
            if(src.length){
                for (let index = 0; index < src.length; index++) {
                    if(typeof src[index] != "undefined"){
                        arr.push(src[index]);
                    }
                }
            }else if(t == 'object'){
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


    var combine = function combine(list){
        var sth = function(lst, i){
            if(!i) i = 0;
            var ls = [];
            if(lst.length <= i) return [];
            var arr = lst[i];
            arr.map(function(c){
                var s = c;
                if(i<lst.length-1){
                    var tl = sth(lst, i+1);
                    if(tl.length){
                        tl.map(function(t){
                            ls.push(c + "" + t);
                        });
                    }else{
                        ls.push(c);
                    }
                }else{
                    ls.push(c);
                }
            });
            return ls;
        };
        return sth(list);
    };

    
    var objectKeys = function (obj) {
        var keys = [];
        if(isArray(obj) || isObject(obj)){
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
        if(isArray(obj) || isObject(obj)){
            for (const key in obj) {
                if (obj.hasOwnProperty(key)) {
                    values.push(obj[key]);
                }
            }
        }
        return values;
    };

    var documentReady = function () {
        if (document.readyState !== 'complete') return;
        return true;
    
        
    };
    
    var isGlobalOrRoot = function (obj) {
        return obj == global || obj == document;
    };


