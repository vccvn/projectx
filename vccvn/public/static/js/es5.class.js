var createClass = (function () {

    'use strict';
    var isArray = Helper.isArray;
    var JSClass = function JSClass(className, isGlobal) {
        // rảnh chã làm gì cả
        this.className = className;
    };

    var global = this || window;

    function addToGlobal(name, value) {
        global[name] = value;
    }


    // gán biên

    JSClass.$class = 'className';
    JSClass.$type = 'class'
    JSClass.$extends = {};
    JSClass.$uses = {};
    JSClass.$methods = {};
    JSClass.$props = {};
    JSClass.$constructs = {};
    JSClass.$parents = {};
    JSClass.$parent = {};
    JSClass.$static = {};
    JSClass.$inits = [];
    /**
     * kế thừa class
     * @param {function|object|class} superClass class cha
     * @returns {JSClass}
     */
    JSClass.inherit = function (superClass) { return this; };

    /**
     * kế thừa class
     * @param {function|object|class} superClass class cha
     * @returns {JSClass}
     */
    JSClass.extends = function (superClass) { return this; };

    // khai báo

    /**
     * khai báo thuộc tính hoặc phương thức
     * @param {object} props thuộc tính hoặc phuong thức
     * @returns {JSClass}
     */
    JSClass.assign = function (props) { return JSClass; };

    /**
     * khai báo static
     * @param {string|object} props
     * @param {mixed} value
     */
    JSClass.static = function (props, value) { return JSClass; };

    /**
     * kế thừa các trait
     * @param {object} trait các thuộc tính và phương thức
     * @returns {JSClass}
     */
    JSClass.uses = function (trait) { return JSClass; };



    /**
     * khoi tao class
     * @param {string} className
     * @param {boolean} isGlobal
     * @returns {JSClass}
     */
    var createClass = function createClass(className, isGlobal) {
        "use strict";

        function _instanceof(left, right) {
            if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) {
                return !!right[Symbol.hasInstance](left);
            } else {
                return left instanceof right;
            }
        }

        function _classCallCheck(instance, Constructor) {
            if (!_instanceof(instance, Constructor)) {
                throw new TypeError("Cannot call a class as a function");
            }
        }

        function _defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
                var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false;
                descriptor.configurable = true;
                if ("value" in descriptor) descriptor.writable = true;
                Object.defineProperty(target, descriptor.key, descriptor);
            }
        }

        function _createClass(Constructor, protoProps, staticProps) {
            if (protoProps) _defineProperties(Constructor.prototype, protoProps);
            if (staticProps) _defineProperties(Constructor, staticProps);
            return Constructor;
        }

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
        }
        function _defineSetterAndGeter(obj, key, value) {
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
        }

        return function (c, ig) {
            var className = c;
            // khai báo hàm
            var __contruct = null;

            var commited = false;


            // khai báo  class
            var stdClass = function () {
                if (!_instanceof(this, stdClass)) return stdClass.assign.apply(null, arguments);
                else {
                    this.__contruct = __contruct;
                }
            };

            function stdParent(instance, cn) {
                this.__instance = instance;
                var self = this;
                if (stdClass.$parents[cn]) {
                    for (const pcl in stdClass.$parents[cn]) {
                        if (stdClass.$parents[cn].hasOwnProperty(pcl)) {
                            const props = stdClass.$parents[cn][pcl];
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
                            if (stdClass.$parents[pcl]) {
                                this.__parent = new stdParent(this, pcl);
                            }
                        }
                    }
                }
            }


            // hàm gọi trong construct
            var stdCt = function () {
                this.__class = className;

                this.__properties = {};
                var args = [];
                this.__update__properties__(true);

                if (!commited) {
                    stdClass.commit();
                }

                for (const key in stdClass.$parent) {
                    if (stdClass.$parent.hasOwnProperty(key)) {
                        const parentOpt = stdClass.$parent[key];
                        this.__parent = new stdParent(this, stdClass.$class);
                    }
                }


                this.__contruct.apply(this, arguments);

                if (stdClass.$inits.length) {
                    for (let i = 0; i < stdClass.$inits.length; i++) {
                        const fn = stdClass.$inits[i];
                        if (typeof fn == "function") {
                            fn.apply(this, []);
                        }
                    }
                }

                stdClass.$instances.push(this);
            };

            eval('stdClass = function ' + className + ' () {' +
                'if (!_instanceof(this, ' + className + ')) return stdClass.assign.apply(null, arguments);' +
                'else {' +
                '' +
                'stdCt.apply(this, arguments)' +
                '}' +
                '};');

            if (ig !== false) {
                // global[className] = stdClass;
                addToGlobal(className, stdClass);
            }

            // gán biên

            stdClass.$class = className;
            stdClass.$type = 'class'
            stdClass.$extends = {};
            stdClass.$uses = {};
            stdClass.$methods = {};
            stdClass.$props = {};
            stdClass.$constructs = {};
            stdClass.$parents = {};
            stdClass.$parent = {};
            stdClass.$static = {};
            stdClass.$instances = [];

            stdClass.$inits = [];



            /**
             * them ham khoi tao
             * @param {function} constructor ham khoi tao
             */
            function addConstructor(constructor) {
                stdClass.$methods.constructor = stdClass.$methods[className] = function () {
                    if (this.__contructs.length) {
                        this.super = function parentConstructor() {
                            var args1 = []
                            for (let i = 0; i < arguments.length; i++) {

                                args1.push(arguments[i]);
                            }
                            var pConstructor = this.__contructs.pop();
                            pConstructor.apply(this, args1);
                        }
                    }
                    constructor.apply(this, arguments);
                }
            }

            /**
             * kế thừa class
             * @param {function|object|class} superClass class cha
             * @returns {stdClass}
             */
            stdClass.inherit = function (superClass) {
                if (superClass) {
                    var $parents = {};
                    var $extends = {
                        'props': {},
                        'methods': {}
                    };

                    var cn = null;
                    var $parent = {

                    };

                    if (superClass.$type == 'class') {// trường hợp là std class
                        cn = superClass.$class;
                        parent.__class = superClass;
                        // lay danh sach construct
                        for (const fn in superClass.$constructs) {
                            if (superClass.$constructs.hasOwnProperty(fn)) {
                                const callback = superClass.$constructs[fn];
                                stdClass.$constructs[fn] = callback;
                            }
                        }
                        if (superClass.$methods[cn]) {
                            stdClass.$constructs[cn] = superClass.$methods[cn];

                        }
                        else if (superClass.$methods.hasOwnProperty('constructor')) {
                            stdClass.$constructs[cn] = superClass.$methods.constructor;
                        }

                        // ke thu
                        for (const cln in superClass.$extends) {
                            if (superClass.$extends.hasOwnProperty(cln)) {
                                const exts = superClass.$extends[cln];
                                for (const k in exts.props) {
                                    if (exts.props.hasOwnProperty(k)) {
                                        const p = exts.props[k];
                                        $extends.props[k] = p;
                                    }
                                }
                                for (const m in exts.methods) {
                                    if (exts.methods.hasOwnProperty(m)) {
                                        const mt = exts.methods[m];
                                        $extends.methods[m] = mt;
                                    }
                                }
                            }
                        }

                        // uses
                        for (const key in superClass.$uses) {
                            if (superClass.$uses.hasOwnProperty(key)) {
                                const vl = superClass.$uses[key];
                                // $extends.uses[key] = vl;
                                $parent[key] = vl;

                                if (typeof vl == "function") {
                                    $extends.methods[key] = vl;
                                }
                                else {
                                    $extends.props[key] = vl;
                                }
                            }
                        }

                        if (superClass.$inits && superClass.$inits.length) {
                            for (let i = 0; i < superClass.$inits.length; i++) {
                                const initFn = superClass.$inits[i];
                                stdClass.$inits.push(initFn);
                            }
                        }

                        // thuoc tinh
                        for (const key in superClass.$props) {
                            if (superClass.$props.hasOwnProperty(key)) {
                                const vl = superClass.$props[key];
                                $extends.props[key] = vl;
                                if (!superClass.$extends || !superClass.$extends.props || !superClass.$extends.props[key]) {
                                    $parent[key] = vl;
                                }
                            }
                        }

                        // phuong thuc
                        for (const key in superClass.$methods) {
                            if (superClass.$methods.hasOwnProperty(key)) {
                                const vl = superClass.$methods[key];
                                if (key != "constructor") {
                                    $extends.methods[key] = vl;
                                    $parent[key] = vl;
                                }
                                if (!superClass.$extends || !superClass.$extends.methods || !superClass.$extends.methods[key] || key == "constructor") {
                                    $parent[key] = vl;
                                }

                            }
                        }

                        for (const fn in superClass.$parents) {
                            if (superClass.$parents.hasOwnProperty(fn)) {
                                const callback = superClass.$parents[fn];
                                stdClass.$parents[fn] = callback;
                            }
                        }

                        for (const fn in superClass.$static) {
                            if (superClass.$static.hasOwnProperty(fn)) {
                                const callback = superClass.$static[fn];
                                stdClass.$static[fn] = callback;

                                _defineProperty(stdClass, fn, callback);
                            }
                        }


                        stdClass.$extends[superClass.$class] = $extends;
                    }
                    else if (typeof superClass == "function" && typeof superClass.prototype == "object") {
                        cn = superClass.name || "parent_" + Helper.str.rand(8);
                        if (typeof superClass.prototype.constructor == "function") {
                            $parent.constructor = superClass.prototype.constructor;
                            $parent[cn] = superClass.prototype.constructor;
                            $extends.methods[cn] = superClass.prototype.constructor;
                            stdClass.$constructs[cn] = superClass.prototype.constructor;
                        }
                        for (const mt in superClass.prototype) {
                            if (superClass.prototype.hasOwnProperty(mt)) {
                                const method = superClass.prototype[mt];
                                if (mt == "constructor") {
                                    $parent.constructor = method;
                                    $parent[cn] = method;
                                    $extends.methods[cn] = method;
                                    stdClass.$constructs[cn] = method;
                                }
                                else if (typeof method == "function") {
                                    $extends.methods[mt] = method;
                                }
                                else {
                                    $extends.props[mt] = method;
                                }
                                $parent[mt] = method;
                            }
                        }

                        stdClass.$extends[cn] = $extends;
                    }

                    if (!Helper.isEmpty($parent) && cn) {
                        if (typeof stdClass.$parents[stdClass.$class] == "undefined") {
                            stdClass.$parents[stdClass.$class] = {};
                        }
                        $parent.__class = cn;
                        stdClass.$parent[cn] = $parent;
                        stdClass.$parents[stdClass.$class][cn] = $parent;
                    }
                }
            };

            /**
             * kế thừa class
             * @param {function|object|class} superClass class cha
             * @returns {stdClass}
             */
            stdClass.extends = function (superClass) {
                for (let index = 0; index < arguments.length; index++) {
                    const arg = arguments[index];
                    stdClass.inherit(arg);
                }
                return stdClass;
            };

            // khai báo

            /**
             * khai báo thuộc tính hoặc phương thức
             * @param {object} props thuộc tính hoặc phuong thức
             * @returns {stdClass}
             */
            stdClass.assign = function (props) {
                if (typeof props == "object") {
                    for (const key in props) {
                        if (props.hasOwnProperty(key)) {
                            const el = props[key];
                            if ((key == "constructor" || key == stdClass.$class) && typeof el == "function") {
                                addConstructor(el);

                            }
                            else if (typeof el == "function") {
                                stdClass.$methods[key] = el;
                            }
                            else {
                                stdClass.$props[key] = el;
                            }
                        }
                    }
                }
                stdClass.commit();
                return stdClass;
            };

            var $ignore = [
                '$class', '$type', '$extends', '$uses', '$methods', '$props', '$constructs', '$parents', '$parent',
                '$static', '$instances', '$inits',
                'constructor', stdClass.$class, 'extends', 'uses', 'assign', 'inherit', 'static'
            ];

            /**
             * khai báo static
             * @param {string|object} props
             * @param {mixed} value
             */
            stdClass.static = function (props, value) {

                if (typeof props == "object") {
                    for (const key in props) {
                        if (props.hasOwnProperty(key)) {
                            const el = props[key];

                            if (Helper.inArray($ignore, key)) {
                                // addConstructor(el);

                            }
                            else {
                                stdClass.$static[key] = el;
                                _defineProperty(stdClass, key, el);
                            }
                        }
                    }
                }
                else if (typeof props == "string") {
                    var key = props;
                    if (Helper.inArray($ignore, key)) {
                        // addConstructor(value);

                    }
                    else {
                        stdClass.$static[key] = value;
                        _defineProperty(stdClass, key, el);
                    }
                }
                return stdClass;
            };


            /**
             * kế thừa các trait
             * @param {object} trait các thuộc tính và phương thức
             * @returns {stdClass}
             */
            stdClass.uses = function (trait) {

                for (let index = 0; index < arguments.length; index++) {
                    const props = arguments[index];
                    if (typeof props == "object") {
                        for (const key in props) {
                            if (props.hasOwnProperty(key)) {
                                const el = props[key];
                                if (Helper.inArray(['constructor', stdClass.$class], key)) {

                                }
                                else if (key == "__init") {
                                    stdClass.$inits.push(el);
                                }
                                else {
                                    stdClass.$uses[key] = el;
                                }
                            }
                        }
                    }

                }
                return stdClass;
            };

            /**
             * kiểm tra xem có phải là instance của StdClas không
             * @param {mixed} instance bien doi tuong can kiem tra
             */
            stdClass.isInstance = function (instance) {
                if (Helper._instanceof(instance, stdClass)) return true;
                if (Helper.isObject(instance)) {
                    if (typeof instance.constructor == "function") {
                        if (instance.constructor.$type == "class") {
                            var cl = instance.constructor;
                            if (!Helper.isEmpty(cl.$parents)) {
                                for (const key in cl.$parents) {
                                    if (cl.$parents.hasOwnProperty(key)) {
                                        const pa = cl.$parents[key];
                                        if (pa.__class == stdClass) return true;
                                    }
                                }
                            }
                        }
                    }
                }
                return false;
            }






            /**
             * Cập nhật các thuộc tính mới
             */
            stdClass.commit = function () {
                var methods = {};
                if (stdClass.$extends) {
                    for (const std in stdClass.$extends) {
                        if (stdClass.$extends.hasOwnProperty(std)) {
                            const $extends = stdClass.$extends[std];
                            for (const method in $extends.methods) {
                                if ($extends.methods.hasOwnProperty(method)) {
                                    const cb = $extends.methods[method];
                                    methods[method] = cb;
                                }
                            }


                        }
                    }
                }

                if (stdClass.$uses) {
                    for (const key in stdClass.$uses) {
                        if (stdClass.$uses.hasOwnProperty(key)) {
                            const val = stdClass.$uses[key];
                            if (typeof val == "function") {
                                methods[key] = val;
                            }
                        }
                    }
                }



                for (const method in stdClass.$methods) {
                    if (stdClass.$methods.hasOwnProperty(method)) {
                        const cb = stdClass.$methods[method];
                        methods[method] = cb;
                    }
                }

                for (const key in methods) {
                    if (methods.hasOwnProperty(key) && key != "constructor") {
                        const mt = methods[key];
                        _defineProperty(stdClass.prototype, key, mt);
                    }
                }

                commited = true;

                return stdClass;
            };



            /**
             * cập nhật thuộc tính
             * @param {boolean} override ghi ghi đè
             */
            stdClass.prototype.__update__properties__ = function updateProperties(override) {
                var props = {};
                if (stdClass.$extends) {
                    for (const std in stdClass.$extends) {
                        if (stdClass.$extends.hasOwnProperty(std)) {
                            const $extends = stdClass.$extends[std];
                            for (const prop in $extends.props) {
                                if ($extends.props.hasOwnProperty(prop)) {
                                    if ((!override && typeof this[prop] == "undefined") || override == true) {
                                        const cb = $extends.props[prop];
                                        props[prop] = cb;
                                    }

                                }
                            }

                        }
                    }
                }

                if (stdClass.$uses) {
                    for (const key in stdClass.$uses) {
                        if (stdClass.$uses.hasOwnProperty(key)) {
                            const val = stdClass.$uses[key];
                            if (typeof val != "function") {
                                if ((!override && typeof this[key] == "undefined") || override == true) {
                                    props[key] = val;
                                }
                            }
                        }
                    }
                }

                for (const prop in stdClass.$props) {
                    if (stdClass.$props.hasOwnProperty(prop)) {
                        const cb = stdClass.$props[prop];
                        props[prop] = cb;
                        if ((!override && typeof this[prop] == "undefined") || override == true) {
                            props[prop] = cb;
                        }
                    }
                }

                var a = 0;

                for (const key in props) {
                    if (props.hasOwnProperty(key)) {
                        const val = props[key];
                        _defineProperty(this, key, val);
                        a++;
                    }
                }

                return a;

            };


            stdClass.prototype.__callStatic = function __callStatic(name, args) {
                if (typeof stdClass[name] == "function") {
                    return stdClass[name].apply(stdClass, isArray(args) ? args : []);
                }
                return false;
            };






            // hàm khởi tạo
            stdClass.prototype.__contruct = function () {
                this.__contructs = [];
                var self = this;

                if (stdClass.$constructs) {
                    for (const fn in stdClass.$constructs) {
                        if (stdClass.$constructs.hasOwnProperty(fn)) {
                            const cb = stdClass.$constructs[fn];
                            this.__contructs.push(cb);
                        }
                    }
                }

                return (typeof this[className] == "function" ? this[className] : (
                    this.__contructs.length ? this.__contructs.pop() : function () { console.log("create instance of " + stdClass.$class) }
                )).apply(this, arguments);

            };


            return stdClass;
        }(className, isGlobal);
    };
    return createClass;

}())
