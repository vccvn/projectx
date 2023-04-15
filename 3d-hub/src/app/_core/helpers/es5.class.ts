// tạo class theo phong cách php và dùng cú pháp es5 =))))))))

import {
    isArray,
    Str,
    _defineProperties,
    _createClass,
    _defineProperty,
    _instanceof,
    isFunction,
    objectKeys,
    addToGlobal,
    assignValue,
    isEmpty,
    isString,
    isObject,
    inArray,
    getArguments,
    date,
    Num,
    copyArray,
    newObj,
    objectHasKey
} from './utils';

"use strict";

const NORETURN_VALUE = date('time') + '-' + Str.rand(Str.rand(date('ms') + "-" + Num.rand(0, 999999)));
const getArgs = getArguments;
interface ES5Instance {
    instanceID: string,

    getInstanceID(): string,
    __addAccessorValue__(): any,
    __changeAccessorValue__(): any,
    addBootMethod(): ES5Instance,
    removeBootMethod(): ES5Instance,
    resetInitMethods(): ES5Instance,
    removeInitMethod(): ES5Instance,
    resetBootMethods(): ES5Instance,
    __update__properties__(): ES5Instance,
    __callStatic(): any,
    [x: string]: any
}

interface ES5AbstractClass {
    (...args: any[]): ES5Instance,
    new(...args: any[]): ES5Instance,
    getExtends(): { [x: string]: any },
    getUses(): { [x: string]: any },
    getMethods(): { [x: string]: any },
    getProps(): { [x: string]: any },
    getConstants(): { [x: string]: any },
    getContructs(): { [x: string]: any },
    getParents(): { [x: string]: any },
    getParent(): { [x: string]: any },
    getStatic(): { [x: string]: any },
    getIntances(): { [x: string]: any },
    getInits(): { [x: string]: any },
    getAccessorMethods(): { [x: string]: any },
    getBootMethods(): { [x: string]: any },
    getInitMethods(): { [x: string]: any },
    isInstance(): boolean,
    with(key?: any, value?: any): ES5Instance,
    withData(key?: any, value?: any): ES5Instance,
    static(key?: any, value?: any): ES5AbstractClass,
    __addAccessorKey(key): any;
    __addAccessorValue(key): any;

    [x: string]: any

}

interface AbstractClass {
    /**
     * khai báo thuộc tính và phương thức
     * @param props các thuộc tính và phương thức
     */
    (props?: {
        [x: string]: any,
    }): ES5AbstractClass,
    new(...args: any[]): ES5Instance,
    /**
     * thực hiện khai báo và khóa các thuộc tính
     */
    commit(): ES5AbstractClass,
    /**
     * kế thừa class
     * @param superClass Class cha
     * @param superClasses danh sách các class cha khá
     */
    extends(superClass: any, ...superClasses: any[]): AbstractClass,
    /**
     * Sử dụng các trait
     * @param trait đối tượng trait
     * @param traits cá trait khác
     */
    uses(trait: any, ...traits: any[]): AbstractClass,
    /**
     * khai báo thuộc tính và phương thức
     * @param props các thuộc tính và phương thức
     */
    uassign(props: {
        constructor?: (...args: any) => void,
        boots?: string[],
        inits?: string[],
        [x: string]: any,
    }): ES5AbstractClass,

    getExtends(): { [x: string]: any },
    getUses(): { [x: string]: any },
    getMethods(): { [x: string]: any },
    getProps(): { [x: string]: any },
    getConstants(): { [x: string]: any },
    getContructs(): { [x: string]: any },
    getParents(): { [x: string]: any },
    getParent(): { [x: string]: any },
    getStatic(): { [x: string]: any },
    getIntances(): { [x: string]: any },
    getInits(): { [x: string]: any },
    getAccessorMethods(): { [x: string]: any },
    getBootMethods(): { [x: string]: any },
    getInitMethods(): { [x: string]: any },
    isInstance(): boolean,
    with(key?: any, value?: any): ES5Instance,
    withData(key?: any, value?: any): ES5Instance,
    static(key?: any, value?: any): AbstractClass,

}
const _interface = (name: string, props: any) => {

};

const objectCreated: any = {};

function createConstructor(name, checkFn): ES5AbstractClass {
    var esc: any = null;
    var s = "try {" +
        "var " + name + " = function " + name + "(){" +
        "var classChecked = checkFn.call(this, getArgs(arguments));" +
        "if(classChecked!==NORETURN_VALUE) return classChecked;" +
        "};" +
        "esc = " + name + ";" +
        "} catch (error) {" +
        "console.log(\"lỗi\");" +
        "console.error(error);" +
        "}";
    eval(s);
    return esc;
}

function definePropertyGroup(target, groupConfig) {
    var configurable = groupConfig.configurable || false,
        enumerable = groupConfig.enumerable || false,
        writable = groupConfig.writable || false;
    for (const key in groupConfig.props) {
        if (Object.prototype.hasOwnProperty.call(groupConfig.props, key)) {
            const value = groupConfig.props[key];
            Object.defineProperty(target, key, {
                configurable: configurable,
                enumerable: enumerable,
                writable: writable,
                value: value
            });
        }
    }
}

/**
 * khoi tao class
 * @param {string} className
 * @param {boolean} isGlobal
 * @returns {class}
 */
const createClass = function createClass(className: any, isGlobal?: any): AbstractClass {
    return function createClass$($class?: any, $isGlobal?: any): any {
        var $className = isString($class) ? Str.replace(Str.clearUnicode($class), [' ', '-', '+'], '') : (isFunction($class) ? $class.name : (isFunction($isGlobal) && $isGlobal.name ? $isGlobal.name : "Class" + Str.rand().substr(4, 4)));
        var hasClassName = isString($class) && $class.length;
        // khai báo hàm

        // tình trạng commit
        var commited = false;

        var oneTimeData = newObj({});

        // chứa dữ liệu hằng
        var $constants = newObj({});

        /**
         * chứa dữ liệu
         */
        var $data = newObj({});


        var $props = newObj({});

        var $dynamics = newObj({});

        /**
         * chứa các phương thức boot
         */
        var $boots = newObj({});

        var $inits = newObj({});

        var $calls = [];

        var $classData = newObj({
            extends: {},
            uses: {},
            methods: {},
            props: {},
            constructs: {},
            parents: {},
            parent: {},
            static: {},
            instances: [],
            constants: {},
            accessorMethods: {},
            events: {},
            inits: [],
            boots: [],
            calls: []

        });

        var __contructs = [];

        // khai báo  class
        /**
         * @var {class}
         */
        var ES5Class: ES5AbstractClass = function () {
            var checked = checkConstructorCalled.call(this, getArgs(arguments));
            if (checked !== NORETURN_VALUE) return checked;
        } as ES5AbstractClass;


        function stdParent(instance: any, cn: any, scope?: any) {
            this.__instance = instance;
            const self = this;


            if (!scope) {
                if (!isEmpty($classData.parent[cn])) {
                    const props = $classData.parent[cn];
                    for (const key in props) {
                        if (props.hasOwnProperty(key)) {
                            const val = props[key];
                            if (typeof val == "function") {
                                this[key] = function () {
                                    val.apply(self, arguments);
                                    self.instance[key].apply(self.instance, arguments);
                                    return self;
                                }
                            } else {
                                this[key] = val;
                            }
                        }
                    }
                    if (!isEmpty($classData.parents[cn])) {
                        for (const k in $classData.parents[cn]) {
                            if (Object.prototype.hasOwnProperty.call($classData.parents[cn], k)) {
                                this.__parent = new stdParent(this, k, cn);
                                if (typeof self.__parents) {
                                    self.__parents = {};
                                }
                                self.__parents[k] = this.__parent;
                            }

                        }

                    }

                }
            }
            else if (isString(scope) && objectHasKey($classData.parents, scope)) {
                if (!isEmpty($classData.parents[scope][cn])) {
                    const props = $classData.parents[scope][cn];
                    for (const key in props) {
                        if (props.hasOwnProperty(key)) {
                            const val = props[key];
                            if (typeof val == "function") {
                                this[key] = function () {
                                    val.apply(self, arguments);
                                    self.instance[key].apply(self.instance, arguments);
                                    return self;
                                }
                            } else {
                                this[key] = val;
                            }
                        }
                    }
                    if (!isEmpty($classData.parents[cn])) {
                        for (const k in $classData.parents[cn]) {
                            if (Object.prototype.hasOwnProperty.call($classData.parents[cn], k)) {
                                this.__parent = new stdParent(this, k, cn);
                                if (typeof self.__parents) {
                                    self.__parents = {};
                                }
                                self.__parents[k] = this.__parent;
                            }

                        }

                    }

                }
            }



        }

        var iof = _instanceof;


        // hàm gọi trong construct

        if (hasClassName) {
            try {
                let esc = createConstructor($className, checkConstructorCalled);
                if (esc !== null) {
                    ES5Class = esc;
                }
            } catch (error) {
                console.log("lỗi")
                console.error(error);
            }
        }


        function checkConstructorCalled(args?: any[]) {
            if (!iof(this, ES5Class)) {
                if (commited) {
                    if ($calls.length) {
                        const caller = $calls[$calls.length - 1];
                        if (typeof caller == "function") {
                            return caller.apply(this, args);
                        }
                    }
                    if (checkCreateNewInstanceByStaticConstructorCall()) {
                        return newInstance(args);
                    }

                }
                return ES5Class.assign.apply(null, args);
            }
            else {
                classContructor.apply(this, args);
            }
            return NORETURN_VALUE;
        }



        function newInstance(args?: any[]) {
            var instance = null;
            // console.log("create intance of " + ES5Class.__class, args);
            var a = 'instance = new ES5Class(';
            if (args && args.length) {
                for (var index = 0; index < args.length; index++) {
                    a += 'args[' + index + ']' + (index < args.length - 1 ? ',' : '');
                }
            }
            a += ');';
            try {
                eval(a);
            } catch (error) {
                console.warn(error);

            }
            return instance;
        }

        var copyContructs = [];
        // hàm khởi tạo
        function __contruct() {
            var self = this;
            copyContructs = copyArray(__contructs);

            return (typeof this[$className] == "function" ? this[$className] : (
                copyContructs.length ? copyContructs.pop() : function () { console.log("create instance of " + ES5Class.__class) }
            )).apply(this, arguments);

        };

        /**
         * them ham khoi tao
         * @param {function(...args)} constructor ham khoi tao
         */
        function addConstructor(constructor?: any) {

            $classData.methods.constructor = $classData.methods[$className] = function () {
                if (copyContructs.length) {
                    copyContructs = copyArray(__contructs);
                    Object.defineProperty(this, "super", {
                        value: function parentConstructor() {
                            var args1 = getArguments(arguments);
                            var pConstructor = copyContructs.pop();
                            pConstructor.apply(this, args1);
                        },
                        enumerable: false

                    })
                }
                constructor.apply(this, arguments);
            }
        }



        if ($isGlobal === true) {
            // global[$className] = ES5Class;
            addToGlobal($className, ES5Class);
        }

        /**
         * ham dc goi trong constructor
         */
        function classContructor() {

            if (!commited) {
                ES5Class.commit();
            }

            this.__update__properties__(true);

            var instanceID = "a" + Str.rand() + "_" + date("time");
            Object.defineProperty(this, '__instance__id__', {
                value: instanceID,
                enumerable: false,
                configurable: false,
                writable: false
            });

            
            if (!isEmpty($dynamics)) {
                for (var key in $dynamics) {
                    if (Object.hasOwnProperty.call($dynamics, key)) {
                        var val = $dynamics[key];
                        __addAccessorValue(instanceID, key, val);
                    }
                }
            }

            if (!isEmpty($classData.parent)) {
                for (var key in $classData.parent) {
                    if ($classData.parent.hasOwnProperty(key)) {
                        var parentOpt = $classData.parent[key];
                        __addAccessorValue(instanceID, "__parent",
                            new stdParent(this, key)
                        );
                    }
                }
            }


            if (oneTimeData && isObject(oneTimeData) && !isEmpty(oneTimeData)) {
                for (const key in oneTimeData) {
                    if (Object.hasOwnProperty.call(oneTimeData, key)) {
                        const value = oneTimeData[key];
                        this[key] = value;
                    }
                }
                oneTimeData = {};
            }







            if (typeof this.boot == "function") {
                this.boot();
                this.boot = function () {
                    console.warn(ES5Class.__class + " boot đã được gọi khi khởi tạo");
                };
            }
            if (!isEmpty($boots)) {
                for (var key in $boots) {
                    if (Object.hasOwnProperty.call($boots, key)) {
                        var params = $boots[key];
                        if (typeof this[key] == "function") {
                            this[key].apply(this, params);
                        }
                    }
                }

            }

            __contruct.apply(this, arguments);

            if (typeof this.init == "function") {
                // console.log(this)
                this.init();
                // this.boot = function () {
                //     console.warn(ES5Class.__class + " boot đã được gọi khi khởi tạo");
                // };
            }
            if (!isEmpty($inits)) {
                for (var key in $inits) {
                    if (Object.hasOwnProperty.call($inits, key)) {
                        var params = $inits[key];
                        if (typeof this[key] == "function") {
                            this[key].apply(this, params);
                        }
                    }
                }

            }

            $classData.instances.push(this);
        };

        // gán biên


        var $ignore = [
            'getClass', 'getType', 'getExtends', 'getUses', 'getMethods', 'getProps', 'getConstructs', 'getParents', 'getParent',
            'getStatic', 'getInstances', 'getInits', 'getAccessorMethods',
            'constructor', ES5Class.__class, 'extends', 'uses', 'assign', 'inherit', 'static', '__update__properties__',
            'resetBootMethods', 'resetInitMethods', 'commit', "getInstanceID"
        ];

        definePropertyGroup(ES5Class, {
            configurable: false,
            enumerable: false,
            writable: false,
            props: {
                __type: 'class',
                __class: $className,

                /**
                 * kế thừa class
                 * @param {function|object|class|ES5Class} superClass class cha
                 * @returns {ES5Class}
                 */

                inherit: function (superClass: any) {
                    if (commited) {
                        throw new Error("Không thể gọi hàm inherit sau khi đã khai báo phương thức cho class");
                    }

                    if (superClass) {
                        var _parents = {};
                        var _extends = {
                            props: {},
                            methods: {},
                            accessorMethods: {}
                        };

                        var cn = null;
                        var _parent: any = {};

                        if (superClass.__type == 'class') {// trường hợp là std class
                            cn = superClass.__class;
                            _parent.__class = superClass;
                            var superContructs = superClass.getContructs();
                            var superExtends = superClass.getExtends();
                            var superInits = superClass.getInits();
                            var superContants = superClass.getConstants();
                            var superUses = superClass.getUses();
                            var superProps = superClass.getProps();
                            var superMethods = superClass.getMethods();
                            var superAccessorMethods = superClass.getAccessorMethods();
                            var superParents = superClass.getParents();
                            var superStatic = superClass.getStatic();
                            // console.log("set get", superAccessorMethods);

                            // lay danh sach construct
                            var bms = superClass.getBootMethods();
                            addBootMethod(bms);
                            var ims = superClass.getInitMethods();
                            addInitMethod(ims);

                            for (var fn in superContructs) {
                                if (superContructs.hasOwnProperty(fn)) {
                                    $classData.constructs[fn] = superContructs[fn];
                                }
                            }
                            if (superMethods[cn]) {
                                $classData.constructs[cn] = superMethods[cn];

                            }
                            else if (superMethods.hasOwnProperty('constructor')) {
                                $classData.constructs[cn] = superMethods.constructor;
                            }


                            // ke thua
                            for (var cln in superExtends) {
                                if (superExtends.hasOwnProperty(cln)) {
                                    var exts = superExtends[cln];
                                    for (var k in exts.props) {
                                        if (exts.props.hasOwnProperty(k)) {
                                            var p = exts.props[k];
                                            _extends.props[k] = p;
                                        }
                                    }

                                    for (var m in exts.methods) {
                                        if (exts.methods.hasOwnProperty(m)) {
                                            var mt = exts.methods[m];
                                            _extends.methods[m] = mt;
                                        }
                                    }

                                    for (var m in exts.accessorMethods) {
                                        if (exts.accessorMethods.hasOwnProperty(m)) {
                                            var mt = exts.accessorMethods[m];
                                            _extends.accessorMethods[m] = mt;
                                        }
                                    }
                                }
                            }


                            if (superInits && superInits.length) {
                                for (var i = 0; i < superInits.length; i++) {
                                    $classData.inits.push(superInits[i]);
                                }
                            }


                            for (var key in superContants) {
                                if (Object.hasOwnProperty.call(superContants, key)) {
                                    if (!isConst(key)) {
                                        $classData.constants[key] = superContants[key];
                                    } else {
                                        throwConstError(superClass.__class, key, superContants[key])
                                    }
                                }
                            }
                            // uses
                            for (var key in superUses) {
                                if (superUses.hasOwnProperty(key)) {
                                    var vl = superUses[key];
                                    // _extends.uses[key] = vl;
                                    _parent[key] = vl;

                                    if (isConst(key)) {
                                        throwConstError(superClass.__class, key, vl)
                                    }
                                    else if (typeof vl == "function") {
                                        _extends.methods[key] = vl;
                                    }
                                    else {
                                        _extends.props[key] = vl;
                                    }
                                }
                            }


                            // thuoc tinh
                            for (var key in superProps) {
                                if (superProps.hasOwnProperty(key)) {
                                    var vl = superProps[key];

                                    if (isConst(key)) {
                                        throwConstError(superClass.__class, key, vl)
                                    }
                                    _extends.props[key] = vl;
                                    if (!superExtends || !superExtends.props || !superExtends.props[key]) {
                                        _parent[key] = vl;
                                    }
                                }
                            }
                            // phuong thuc
                            for (var key in superMethods) {
                                if (superMethods.hasOwnProperty(key)) {
                                    var vl = superMethods[key];

                                    if (isConst(key)) {
                                        throwConstError(superClass.__class, key, vl)
                                    }
                                    if (key != "constructor") {
                                        _extends.methods[key] = vl;
                                        _parent[key] = vl;
                                    }
                                    if (!superExtends || !superExtends.methods || !superExtends.methods[key] || key == "constructor") {
                                        _parent[key] = vl;
                                    }

                                }
                            }


                            for (var key in superAccessorMethods) {
                                if (superAccessorMethods.hasOwnProperty(key)) {
                                    assignValue(_extends.accessorMethods, key, superAccessorMethods[key]);
                                    _parent[key] = superAccessorMethods[key];
                                    $classData.accessorMethods[key] = superAccessorMethods[key];

                                }
                            }

                            for (var fn in superParents) {
                                if (superParents.hasOwnProperty(fn)) {
                                    $classData.parents[fn] = superParents[fn];
                                }
                            }



                            for (var fn in superStatic) {
                                if (superStatic.hasOwnProperty(fn)) {
                                    $classData.static[fn] = superStatic[fn];

                                    _defineProperty(ES5Class, fn, superStatic[fn]);
                                }
                            }


                            $classData.extends[superClass.__class] = _extends;
                        }
                        else if (typeof superClass == "function" && typeof superClass.prototype == "object") {
                            cn = superClass.name || "parent_" + Str.rand(8);
                            if (typeof superClass.prototype.constructor == "function") {
                                _parent.constructor = superClass.prototype.constructor;
                                _parent[cn] = superClass.prototype.constructor;
                                _extends.methods[cn] = superClass.prototype.constructor;
                                $classData.constructs[cn] = superClass.prototype.constructor;
                            }
                            for (let mt in superClass.prototype) {
                                if (superClass.prototype.hasOwnProperty(mt)) {
                                    var method = superClass.prototype[mt];

                                    if (isConst(key)) {
                                        throwConstError(superClass.__class, key, vl)
                                    }
                                    if (mt == "constructor") {
                                        _parent.constructor = method;
                                        _parent[cn] = method;
                                        _extends.methods[cn] = method;
                                        $classData.constructs[cn] = method;
                                    }
                                    else if (typeof method == "function") {
                                        _extends.methods[mt] = method;
                                    }
                                    else {
                                        _extends.props[mt] = method;
                                    }
                                    _parent[mt] = method;
                                }
                            }

                            $classData.extends[cn] = _extends;
                        }

                        if (!isEmpty(_parent) && cn) {
                            if (typeof $classData.parents[ES5Class.__class] == "undefined") {
                                $classData.parents[ES5Class.__class] = {};
                            }
                            _parent.__class = cn;
                            $classData.parent[cn] = _parent;
                            $classData.parents[ES5Class.__class][cn] = _parent;
                        }
                    }
                },

                "extends": function (superClass?: any) {
                    if (commited) {
                        throw new Error("Không thể gọi hàm extends sau khi đã khai báo phương thức cho class");
                    }

                    for (var index = 0; index < arguments.length; index++) {
                        var arg = arguments[index];
                        ES5Class.inherit(arg);
                    }
                    return ES5Class;
                },
                /**
                 * kế thừa các trait
                 * @param {object} trait các thuộc tính và phương thức
                 * @returns {ES5Class}
                 */
                uses: function (...traits: any) {
                    if (commited) {
                        throw new Error("Không thể gọi hàm uses sau khi đã khai báo phương thức cho class");
                    }

                    function assignUses(props?: any) {

                        for (var key in props) {
                            if (props.hasOwnProperty(key)) {
                                var el = props[key];

                                if (inArray(['constructor', ES5Class.__class], key)) {

                                }
                                else if (isConst(key)) {
                                    throwConstError("trait", key, el)
                                }

                                else if (inArray(['boots', 'bootmethods'], String(key).toLowerCase()) && typeof el != "function") {
                                    addBootMethod(el);
                                }

                                else if (inArray(['inits', 'initmethods'], String(key).toLowerCase()) && typeof el != "function") {
                                    addInitMethod(el);
                                }

                                else {
                                    assignPropMethod('uses', key, el);
                                    // $classData.uses[key] = el;
                                }
                            }
                        }
                    }
                    var prototype = {};
                    for (var index = 0; index < arguments.length; index++) {
                        var props = arguments[index];
                        if (typeof props == "object") {
                            assignUses(props);
                        } else if (isFunction(props)) {
                            if (objectKeys(props.prototype).length > 1) {
                                Object.assign(prototype, props.prototype);
                            }
                        }

                    }

                    assignUses(prototype);

                    return ES5Class;
                },


                // khai báo

                /**
                 * khai báo thuộc tính hoặc phương thức
                 * @param {object} props thuộc tính hoặc phuong thức
                 * @returns {ES5Class}
                 */
                assign: function (props?: any) {
                    if (typeof props == "object") {
                        for (var key in props) {
                            if (props.hasOwnProperty(key)) {
                                var el = props[key];

                                if (isConst(key)) {
                                    throwConstError(ES5Class.__class, key, el)
                                }
                                else if ((key == "constructor" || key == ES5Class.__class)) {
                                    if (typeof el == "function") addConstructor(el);
                                }

                                else if (inArray(['boots', 'bootmethods'], String(key).toLowerCase())) {
                                    addBootMethod(el);
                                }

                                else if (inArray(['inits', 'initmethods'], String(key).toLowerCase()) && typeof el != "function") {
                                    addInitMethod(el);
                                }

                                else if (typeof el == "function") {
                                    assignPropMethod('methods', key, el);
                                    // $classData.methods[key] = el;
                                }

                                else {
                                    assignPropMethod('props', key, el);
                                    // $classData.props[key] = el;
                                }
                            }
                        }
                    }
                    ES5Class.commit();
                    return ES5Class;
                },

                /**
                 * khai báo static
                 * @param {string|object} props
                 * @param {mixed} value
                 * @returns {ES5Class}
                 */
                static: function (props?: any, value?: any) {

                    if (typeof props == "object") {
                        for (var key in props) {
                            if (props.hasOwnProperty(key)) {
                                var el = props[key];

                                if (!inArray($ignore, key)) {
                                    $classData.static[key] = el;
                                    _defineProperty(ES5Class, key, el);
                                }
                            }
                        }
                    }
                    else if (typeof props == "string") {
                        var key = props;
                        if (!inArray($ignore, key)) {
                            $classData.static[key] = value;
                            _defineProperty(ES5Class, key, el);
                        }
                    }
                    return ES5Class;
                },

                /**
                 * Cập nhật các thuộc tính mới
                 */
                commit: function () {

                    if (commited) {
                        return ES5Class;
                    }

                    for (var key in $classData.constants) {
                        if (Object.hasOwnProperty.call($classData.constants, key)) {
                            if (!inArray(['constructor', ES5Class.__class], key)) {
                                Object.defineProperty(ES5Class.prototype, key, {
                                    value: $classData.constants[key],
                                    enumerable: true,
                                    configurable: false,
                                    writable: false
                                })
                            }
                        }
                    }

                    // for (var key in $constants) {
                    //     if (Object.hasOwnProperty.call($constants, key)) {
                    //         var constData = $constants[key];
                    //         Object.defineProperty(this, key, {
                    //             get: constData.get,
                    //             set: constData.set
                    //         });
                    //     }
                    // }


                    var methods = {};
                    if ($classData.extends) {
                        for (var std in $classData.extends) {
                            if ($classData.extends.hasOwnProperty(std)) {
                                var _extends = $classData.extends[std];
                                for (var method in _extends.methods) {
                                    if (_extends.methods.hasOwnProperty(method)) {
                                        var cb = _extends.methods[method];
                                        methods[method] = cb;
                                    }
                                }


                            }
                        }
                    }

                    if ($classData.uses) {
                        for (var key in $classData.uses) {
                            if ($classData.uses.hasOwnProperty(key)) {
                                var val = $classData.uses[key];
                                if (typeof val == "function") {
                                    methods[key] = val;
                                }
                            }
                        }
                    }



                    for (var method in $classData.methods) {
                        if ($classData.methods.hasOwnProperty(method)) {
                            var cb = $classData.methods[method];
                            methods[method] = cb;
                        }
                    }

                    var mts = {};
                    Object.assign(mts, methods);
                    for (var key in mts) {
                        if (mts.hasOwnProperty(key) && key != "constructor") {
                            var mt = mts[key];
                            __addMethod(key, mt);
                        }
                    }

                    commited = true;
                    // __contructs = [];
                    if ($classData.constructs) {
                        for (var fn in $classData.constructs) {
                            if ($classData.constructs.hasOwnProperty(fn)) {
                                __contructs.push($classData.constructs[fn]);
                            }
                        }
                    }



                    if (!isEmpty($dynamics)) {
                        for (var key in $dynamics) {
                            if (Object.hasOwnProperty.call($dynamics, key)) {
                                var val = $dynamics[key];
                                __addAccessorKey(key);
                            }
                        }
                    }


                    parseDataProps();
                    return ES5Class;
                },




                /**
                 * kiểm tra xem có phải là instance của StdClas không
                 * @param {mixed} instance bien doi tuong can kiem tra
                 */
                isInstance: function (instance?: any) {
                    if (_instanceof(instance, ES5Class)) return true;
                    if (isObject(instance)) {
                        if (typeof instance.constructor == "function") {
                            if (instance.constructor.__type == "class") {
                                var cl = instance.constructor;
                                var parents = instance.constructor.getParents();
                                if (!isEmpty(parents)) {
                                    for (var key in parents) {
                                        if (parents.hasOwnProperty(key)) {
                                            var pa = parents[key];
                                            if (pa.__class == ES5Class) return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return false;
                },


                getExtends: function () {
                    return $classData.extends;
                },
                getUses: function () {
                    return $classData.uses;
                },
                getMethods: function () {
                    return $classData.methods;
                },
                getProps: function () {
                    return $classData.props;
                },
                getConstants: function () {
                    return $classData.constants;
                },
                getContructs: function () {
                    return $classData.constructs;
                },
                getParents: function () {
                    return $classData.parents;
                },
                getParent: function () {
                    return $classData.parent;
                },
                getStatic: function () {
                    return $classData.static;
                },
                getIntances: function () {
                    return $classData.instances;
                },
                getInits: function () {
                    return $classData.inits;
                },
                getAccessorMethods: function () {
                    return $classData.accessorMethods;
                },
                getBootMethods: function () {
                    return $boots;
                },
                getInitMethods: function () {
                    return $inits;
                },
                /**
                 * Thêm phương thức
                 * @param {string|string[]|object|functiong} method 
                 */
                addBootMethod: function (method?: any) {
                    addBootMethod.apply(null, arguments);
                },
                /**
                 * Thêm phương thức
                 * @param {string|string[]|object|functiong} method 
                 */
                removeBootMethod: function (method?: any) {
                    if (isString(method)) {
                        if (typeof $boots[method]) {
                            delete $boots[method];
                        }
                    }
                    else if (isArray(method)) {
                        for (var i = 0; i < method.length; i++) {
                            var mt = method[i];
                            if (isString(mt)) {
                                if (typeof $boots[mt]) {
                                    delete $boots[mt];
                                }
                            }
                        }
                    }
                },

                resetBootMethods: function () {
                    $boots = {};
                },


                /**
                * Thêm phương thức
                * @param {string|string[]|object|functiong} method 
                */
                removeInitMethod: function (method?: any) {
                    if (isString(method)) {
                        if (typeof $inits[method]) {
                            delete $inits[method];
                        }
                    }
                    else if (isArray(method)) {
                        for (var i = 0; i < method.length; i++) {
                            var mt = method[i];
                            if (isString(mt)) {
                                if (typeof $inits[mt]) {
                                    delete $inits[mt];
                                }
                            }
                        }
                    }
                },



                /**
                 * thêm dữ liệu vho clSS trước khi tạo mới
                 * @param {string} key key hoặc object
                 * @param {mixed} value phần tử cha
                 * @returns {ES5Class}
                 */
                "with": function (key: any, value?: any) {
                    var self = this;
                    if (isObject(key)) {
                        for (const k in key) {
                            if (Object.hasOwnProperty.call(key, k)) {
                                const valu = key[k];
                                oneTimeData[k] = valu;
                            }
                        }
                    }
                    else if (isString(key)) {
                        oneTimeData[key] = value;
                    }
                    return self;
                },
                withData: function (key: any, value?: any) {
                    var self = this;
                    if (isObject(key)) {
                        for (const k in key) {
                            if (Object.hasOwnProperty.call(key, k)) {
                                const valu = key[k];
                                oneTimeData[k] = valu;
                            }
                        }
                    }
                    else if (isString(key)) {
                        oneTimeData[key] = value;
                    }
                    return self;
                },

                /**
                 * thêm dữ liệu vho clSS trước khi tạo mới
                 * @param {...} args key hoặc object
                 * @returns {ES5Class}
                 */
                create: function createInstance(...args) {
                    var self = this;
                    return self.apply(null, args);
                },



                resetInitMethods: function () {
                    $inits = {};
                }




            }
        })


        definePropertyGroup(ES5Class.prototype, {
            configurable: false,
            enumerable: false,
            writable: false,
            props: {
                noReturn: NORETURN_VALUE,

                "static": ES5Class,
                /**
                 * cập nhật thuộc tính
                 * @param {boolean} override ghi ghi đè
                 */
                __update__properties__: function updateProperties(override?: any) {


                    for (var key in $props) {
                        if ($props.hasOwnProperty(key)) {
                            var val = $props[key];
                            _defineProperty(this, key, val);
                        }
                    }

                },


                __callStatic: function __callStatic(name?: any, args?: any) {
                    if (typeof ES5Class[name] == "function") {
                        return ES5Class[name].apply(ES5Class, isArray(args) ? args : []);
                    }
                    return false;
                },








                // boot

                /**
                 * Thêm phương thức
                 * @param {string|string[]|object|functiong} method 
                 */
                addBootMethod: function (method?: any) {
                    addBootMethod.apply(this, arguments);
                },

                /**
                 * Thêm phương thức
                 * @param {string|string[]|object|functiong} method 
                 */
                removeBootMethod: function (method?: any) {
                    ES5Class.removeBootMethod.apply(this, arguments);
                },
                /**
                 * Thêm phương thức
                 */
                resetBootMethods: function (method?: any) {
                    $boots = {};
                },

                /**
                 * Thêm phương thức
                 * @param {string|string[]|object|functiong} method 
                 */
                removeInitMethod: function (method?: any) {
                    ES5Class.removeInitMethod.apply(this, arguments);
                },
                /**
                 * Thêm phương thức
                 */
                resetInitMethods: function (method?: any) {
                    $inits = {};
                },




                /**
                 * get Intance ID
                 * @return {string}
                 */
                getInstanceID: function getInstanceID() {
                    return this.__instance__id__;
                },



                __addAccessorValue__: function (objectData?: any) {
                    if (isObject(objectData) && objectData.key) {
                        var key = objectData.key;
                        var g, s;
                        if (typeof objectData.get == "function")
                            g = objectData.get;
                        if (typeof objectData.set == "function")
                            s = objectData.set;
                        var instanceID = this.__instance__id__;
                        if (typeof $data[instanceID] == "undefined") $data[instanceID] = {};
                        var isExists = typeof $data[instanceID][key] != "undefined";
                        $data[instanceID][key] = typeof objectData.value != "undefined" ? objectData.value : null;
                        if (isExists) return;
                        var da = {
                            get: function () {
                                var value = $data[instanceID][key];
                                if (g) {
                                    var r = g.apply(this, [value]);
                                    if (typeof r != "undefined") return r;
                                }
                                return value;
                            },
                            set: function set(value) {
                                var stt = true;
                                var oldVal = $data[instanceID][key];

                                if (this.isDom && key == "parent") {
                                    $data[instanceID][key] = value;
                                    if (s) {
                                        var a = s.call(this, value, oldVal);
                                        if (a === false) stt = false;
                                    }
                                    if (!stt) {
                                        $data[instanceID][key] = oldVal;
                                    }
                                    return $data[instanceID][key];
                                }
                                if (s) {
                                    var a = s.call(this, value, oldVal);
                                    if (a === false) stt = false;
                                }

                                if (stt) $data[instanceID][key] = value;
                                return $data[instanceID][key];
                            }
                        };

                        Object.defineProperty(this, key, da);
                    }
                },

                __changeAccessorValue__: function (key?: any, value?: any) {
                    var instanceID = this.__instance__id__;
                    if (typeof $data[instanceID] == "undefined") return false;
                    if (isString(key)) {

                        $data[instanceID][key] = value;
                    }

                    else if (isObject(key)) {
                        for (var k in key) {
                            if (Object.hasOwnProperty.call(key, k)) {
                                this.__changeAccessorValue__(k, key[k]);
                            }
                        }
                    }
                    return true;
                },








            }
        })







        function parseDataProps() {
            var props = {};
            if ($classData.extends) {
                for (var std in $classData.extends) {
                    if ($classData.extends.hasOwnProperty(std)) {
                        var _extends = $classData.extends[std];
                        for (var prop in _extends.props) {
                            if (_extends.props.hasOwnProperty(prop)) {
                                var cb = _extends.props[prop];
                                props[prop] = cb;

                            }
                        }

                    }
                }
            }

            if ($classData.uses) {
                for (var key in $classData.uses) {
                    if ($classData.uses.hasOwnProperty(key)) {
                        var val = $classData.uses[key];
                        if (typeof val != "function") {
                            // if ((!override && typeof this[key] == "undefined") || override == true) {
                            props[key] = val;
                            // }
                        }
                    }
                }
            }

            for (var prop in $classData.props) {
                if ($classData.props.hasOwnProperty(prop)) {
                    var cb = $classData.props[prop];
                    props[prop] = cb;
                    // if ((!override && typeof this[prop] == "undefined") || override == true) {
                    //     $props[prop] = cb;
                    // }
                }
            }

            for (var key in props) {
                if (props.hasOwnProperty(key)) {
                    var val = props[key];
                    if (key.substr(0, 1) == '$') {
                        var ks = key.substr(1);
                        // __addAccessorValue(this, ks, val);

                        __addAccessorKey(ks);
                        $dynamics[ks] = val;
                    }
                    else {
                        $props[key] = val;
                        // _defineProperty(this, key, val);
                    }
                }
            }

        }


        function addBootMethod(method) {
            if (isString(method)) {
                $boots[method] = [];
            } else if (isArray(method)) {
                method.map(function (mt) {
                    if (isString(mt)) {
                        $boots[mt] = [];
                    }
                });
            } else if (isObject(method)) {
                for (var key in method) {
                    if (Object.hasOwnProperty.call(method, key)) {
                        var params = method[key];
                        $boots[key] = isArray(params) ? params : [params];
                    }
                }
            }
        }


        function addInitMethod(method?: any) {
            if (isString(method)) {
                $inits[method] = [];
            } else if (isArray(method)) {
                method.map(function (mt) {
                    if (isString(mt)) {
                        $inits[mt] = [];
                    }
                });
            } else if (isObject(method)) {
                for (var key in method) {
                    if (Object.hasOwnProperty.call(method, key)) {
                        var params = method[key];
                        $inits[key] = isArray(params) ? params : [params];
                    }
                }
            }
        }




        function isConst(key?: any) {
            return Object.hasOwnProperty.call($classData.constants, key);
        }

        function throwConstError(className?: any, key?: any, value?: any) {
            throw new Error("Không thể kế thừa " + (typeof value == "function" ? "phương thức" : "thuộc tính") + " [" + key + "] từ class [" + className + "] do trùng vời hàng số đã được khai báo");
        }


        function addConstValue(key?: any, value?: any) {
            $constants[key] = {
                value: value,
                set: function (val: any) {
                    console.warn("bạn không thể set giá trị cho một hằng " + key);
                },
                get: function () {
                    return $constants[key] ? $constants[key].value : null;
                }
            };
        }

        /**
         * khai bao thuoc tinh hoac phuong thuc
         * @param {string} scope 
         * @param {string} key 
         * @param {*} value 
         */
        function assignPropMethod(scope?: any, key?: any, value?: any) {
            if (!isString(key)) return false;
            var a = String(key).split("$");
            if (a.length == 2 && a[0].length) {
                var s = a[0].toLowerCase();
                if (s == "const" || s == "final") {
                    if (!isConst(a[1])) {
                        if (a[1] == "constructor") {
                            if (typeof value == 'function') addConstructor(value);
                        }

                        // if (typeof value != "function" && !inArray($ignore, a[1])) {
                        //     _defineProperty(ES5Class.prototype, a[1], value);
                        // }
                        if (typeof value == "function" && (a[1] == "call" || a[1] == "caller" || a[1] == "__call" || a[1] == "__call__")) {
                            $calls.push(value);
                        }
                        // else{
                        $classData.constants[a[1]] = value;
                        // }

                    } else {
                        throw new Error("Bạn không thể ghi đè một Hằng");
                    }
                }
                else if (s == 'onset' || s == 'set') {
                    if (typeof value == "function") {
                        if (typeof $classData.accessorMethods[a[1]] == "undefined") {
                            $classData.accessorMethods[a[1]] = {};
                        }
                        $classData.accessorMethods[a[1]].set = value;
                    }

                }
                else if (s == 'onget' || s == 'get') {
                    if (typeof value == "function") {
                        if (typeof $classData.accessorMethods[a[1]] == "undefined") {
                            $classData.accessorMethods[a[1]] = {};
                        }
                        $classData.accessorMethods[a[1]].get = value;
                    }
                }
                else if (s == 'static') {
                    ES5Class.static(a[1], value);
                }
                else if (!isConst(key)) {
                    $classData.constants[a[1]] = value;
                    if (typeof value == "function" && (a[1] == "call" || a[1] == "caller" || a[1] == "__call" || a[1] == "__call__")) {
                        $calls.push(value);
                    }
                    else if (typeof $classData[scope] == "object") {
                        if (typeof $classData.uses[key] != "undefined") delete $classData.uses[key];
                        if (typeof $classData.methods[key] != "undefined") delete $classData.methods[key];
                        if (typeof $classData.props[key] != "undefined") delete $classData.props[key];
                        $classData[scope][key] = value;
                    }
                }
            }
            else if (!isConst(key)) {
                let kl = String(key).toLowerCase();
                if (typeof value == "function" && (kl == "call" || kl == "caller" || kl == "__call" || kl == "__call__")) {
                    $calls.push(value);
                }

                else if (typeof $classData[scope] == "object") {
                    if (typeof $classData.uses[key] != "undefined") delete $classData.uses[key];
                    if (typeof $classData.methods[key] != "undefined") delete $classData.methods[key];
                    if (typeof $classData.props[key] != "undefined") delete $classData.props[key];
                    $classData[scope][key] = value;
                }
            }
        }

        function __addAccessorValue(instanceID?: any, key?: any, val?: any) {
            if (typeof $data[instanceID] == "undefined") $data[instanceID] = {};
            // if (typeof $data[instanceID][key] != "undefined") return false;
            $data[instanceID][key] = val;
            return true;

        }




        function __addAccessorKey(key: any) {
            
            var g, s;
            if (typeof $classData.accessorMethods[key] == "object") {
                if (typeof $classData.accessorMethods[key].get == "function")
                    g = $classData.accessorMethods[key].get;
                if (typeof $classData.accessorMethods[key].set == "function")
                    s = $classData.accessorMethods[key].set;
            }

            Object.defineProperty(ES5Class.prototype, key, {
                get: function get() {
                    var value = $data[this.__instance__id__][key];
                    if (g) {
                        var r = g.apply(this, [value]);
                        if (typeof r != "undefined") return r;
                    }
                    return value;
                },
                set: function set(value) {
                    var stt = true;
                    var oldVal = $data[this.__instance__id__][key];

                    if (s) {
                        var a = s.call(this, value, oldVal);
                        if (a === false) stt = false;
                    }

                    if (stt) $data[this.__instance__id__][key] = value;
                    return $data[this.__instance__id__][key];
                }
            });
        }



        function __addMethod(name?: any, handle?: any) {
            if (name.length > 6) {
                var pre = name.substr(0, 6).toLowerCase();

                var n = name.substr(6, 1).toLowerCase() + (name.length > 7 ? name.substr(7) : '');
                if (inArray(['$onset', 'onset$', '$set', 'set$'], pre)) {
                    if (typeof $classData.accessorMethods[n] == "undefined") {
                        $classData.accessorMethods[n] = {};
                    }
                    $classData.accessorMethods[n].set = handle;
                    return;
                }
                else if (inArray(['$onget', 'onget$', '$get', 'get$'], pre)) {
                    if (typeof $classData.accessorMethods[n] == "undefined") {
                        $classData.accessorMethods[n] = {};
                    }
                    $classData.accessorMethods[n].get = handle;
                    return;
                }
            }
            _defineProperty(ES5Class.prototype, name, handle);

        };


        function checkCreateNewInstanceByStaticConstructorCall() {
            if (commited && ($props.dynamicCreateMode || $dynamics.dynamicCreateMode || $constants.dynamicCreateMode)) {
                return true;
            }
            return false;
        }


        ES5Class.__addAccessorKey = __addAccessorKey;
        ES5Class.__addAccessorValue = __addAccessorValue;


        if (isObject($class)) {
            ES5Class.assign($class);
        }
        else if (isFunction($class)) {
            addConstructor($class);
        }
        else if (isFunction($isGlobal)) {
            addConstructor($isGlobal);
        }



        // if(typeof $constants.noReturn == "undefined"){
        //     addConstValue('noReturn', NORETURN_VALUE)
        // }

        return ES5Class;

    }(className, isGlobal);
};

const _class = createClass;
export default createClass;
export { createClass, _class, ES5AbstractClass, ES5Instance };
