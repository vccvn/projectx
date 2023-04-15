    



    /**
     * Lớp ứng dụng nền tảng
     * @param {string} mod 
     * @param {object} options 
     */
    var App = function App(mod, options) {
        // thêm module và trả về luôn module đó

        var isConstructor = false;
        if (this instanceof App || this.constructor == App) {
            isConstructor = true;
        }
        var m = mod || null;
        var o = options || null;

        // nếu không được sử sụng từ khóa new
        if (!isConstructor) {
            if (isObject(m)) {

            }
            return App.parse(m, o);
        } else {
            if (typeof m == "object") o = m;
            if (isObject(m)) {
                for (const key in o) {
                    if (o.hasOwnProperty(key)) {
                        const v = o[key];
                        this[key] = v;
                    }
                }
            } else {
                if (isString(m) && m) {
                    this[m] = p;
                }
            }
        }

    };

    /**
     * thuộc tính và phương thức ẩn
     */
    var initOptions = {
        getType: getType,
        isArray: isArray,
        isObject: isObject,
        isString: isString,
        isNumber: isNumber,
        isEmail: isEmail,
        isNull: isNull,
        isFormData: isFormData,
        isEmpty: isEmpty,
        isCallable: isCallable,
        isFunction: isFunction,
        
        oeiginModules: [],
        log: cl,
        deepCopy: deepCopy,
        copyArray: copyArray,
        objectKeys: objectKeys,
        objectValues: objectValues,
        merge: merge,
        combine:combine,
        addModule: function (name, options) {
            if (!App.exists(name) && !App.isOrigin(name)) {
                if(isObject(options) && typeof options.init != "object"){
                    if(!options.init_list) options.init_list = [];
                    options.init = function (args) {
                        if (!args || typeof args == 'undefined') return;
                        for (var key of this.init_list) {
                            if (typeof args[key] != 'undefined') {
                                var d = args[key];
                                var t = App.getType(d);
            
                                var t2 = (typeof (this[key]) != 'undefined') ? App.getType(this[key]) : "string";
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
                App[name] = App.prototype[name] = options;
            }
        },
        parse: function (name, options) {
            if (!name) return null;
            if (isObject(name)) {
                for (const key in name) {
                    if (name.hasOwnProperty(key)) {
                        const opt = name[key];
                        App.parse(key, opt);
                    }
                }
                return true;
            }
            if (App.exists(name)) return App[name];
            App.addModule(name, options);
            if (App.exists(name)) return App[name];
            return null;
        },
        extend: function (name, options) {
            return this.parse(name, options);
        },
        exists: function (name) {
            return typeof App[name] != "undefined";
        },
        isOrigin: function (name) {
            return (App.oeiginModules.indexOf(name) >= 0);
        },
        isReady: function () {
            return background.documentReady;
        },
        setDefault: function(object, data){
            if (!data || typeof data == 'undefined') return;
                for (var key of object.init_list) {
                    if (typeof data[key] != 'undefined') {
                        var d = data[key];
                        var t = this.getType(d);
        
                        var t2 = (typeof(object[key]) != 'undefined') ? this.getType(object[key]) : "string";
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
        }
    };
    App.modules = App.prototype;

    for (const key in initOptions) {
        if (initOptions.hasOwnProperty(key)) {
            const val = initOptions[key];
            App[key] = App.modules[key] = App.prototype[key] = val;
        }
    }

    App.queue = App.prototype.queue = function (work, delay, step) {
        if(typeof work == "undefined") return new Faker();
        var d = (typeof delay == "undefined" || !isNumber(delay) || delay < 1) ? 10 : delay;
        var s = (typeof step == "undefined" || !isNumber(step) || step < 0) ? -1 : step;
        return new Queue(work, delay, step);
    };





    /**
     * thiet lap hệ thống
     */
    var systemOptions = {
        cssClassPrefix: "crazy-",
        test: "test",
        domQuery: "D",
        queryEngine: "App.query"
    };


    App.getSystemOption = App.prototype.getSystemOption = function (key) {
        return (typeof key == "undefined") ? systemOptions : (
            isString(key) && typeof systemOptions[key] != "undefined" ? systemOptions[key] : null
        );
    };

    App.setSystemOption = App.prototype.setSystemOption = function (key, value) {
        var self = this;
        if(typeof key == "undefined") return this;
        if(isString(key)) {
            if (key == "domQuery") {
                let t = systemOptions[key];
                if (global[t] == App.query) {
                    delete global[t];
                    global[value] = App.query;
                }
            }
            systemOptions[key] = value;
        }
        else if(isObject(key)) {
            App.setup(key);
        }
        return this;
    };




    App.setup = App.prototype.setup = function (options) {
        if (options && isObject(options)) {
            for (const key in options) {
                if (options.hasOwnProperty(key)) {
                    const value = options[key];
                    this.setSystemOption(key, value);
                }
            }
        }
        return this;
    };
