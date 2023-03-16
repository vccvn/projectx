    var $window = null, $root = null;
    /**
     * lớp bao đối tượng
     * @param {syting|Element|DomQuery} selector 
     * @param {object} options 
     */
    var DomQuery = App.dom.DomQuery = function DomQuery(selector, options) {
        var elements = this.getDomElements(selector);
        let n = 0;
        for (let index = 0; index < elements.length; index++) {
            const el = elements[index];
            this[n] = el;
            n++;
        }
        this.length = n;
        var self = this;

        var data = {};
        var methods = {
            all: function () {
                return elements;
            }
        };
        this.e = function () {
            if (!arguments.length || typeof arguments[0] != "string") return null;
            var method = arguments[0];
            var r = null;
            if (typeof methods[method] == "function") {
                var args = [];
                for (let i = 1; i < arguments.length; i++) {
                    const arg = arguments[i];
                    args.push(arg);
                }
                r = methods[method].apply(this, args);
            }
            return r;

        };
    };

    App.query = App.prototype.query = App.dom.query = App.$ = App.prototype.$ = App.dom.$ = function (selector, options) {
        var a;
        if(selector == document){
            if($root){
                a = $root;
            }else{
                $root = a = new App.dom.DomQuery(selector, options);
            }
        }else if(selector == global){
            if($window){
                a = $window;
            }else{
                a = $window = new App.dom.DomQuery(selector, options);
            }
        }else{
            a = new App.dom.DomQuery(selector, options);
        }
        return a;
    }



    DomQuery.prototype = {
        simpleTags: ['img', 'meta', 'link', 'input', 'br', 'hr'],
        splice: arr.splice,
        constructor: App.dom.DomQuery,
        length: 0,
        toArray: function () {
            return slice.call(this);
        },
        // Get the Nth element in the matched element set OR
        // Get the whole matched element set as a clean array
        get: function (num) {

            // Return all the elements in a clean array
            if (num == null) {
                return slice.call(this);
            }

            // Return just the one element from the set
            return num < 0 ? this[num + this.length] : this[num];
        },

        slice: function () {
            return slice.apply(this, arguments);
        },


        getDomElements: function (selector) {
            if (typeof selector == "undefined") return [];
            var elements = [];
            if (typeof selector == "string") {
                if (selector[0] == "<" && selector[selector.length - 1] == ">") {
                    elements.push(App.dom.parse(selector));
                } else if (selector.indexOf(" ") < 0 && selector.indexOf(">") < 0 && selector.indexOf("]") < 0 && selector.indexOf("[") < 0 && selector.indexOf(",") < 0 && selector.split(".").length < 3 && selector.split(",").length < 2 && selector.split("#").length < 2) {
                    if (selector[0] == "#") {
                        var el = document.getElementById(selector.slice(1));
                        if (el) {
                            elements.push(el);
                        }
                    } else if (selector[0] == "." && selector.lastIndexOf(".") == 0) {
                        var elems = document.getElementsByClassName(selector.slice(1));
                        if (elems && elems.length) {
                            elements = elems;
                        }
                    } else {
                        var els = document.getElementsByTagName(selector);
                        if (els && els.length) {
                            elements = els;
                        }
                    }

                } else {
                    elements = document.querySelectorAll(selector) || [];
                }
            }
            else if (selector instanceof Element || selector.constructor == HTMLHeadingElement || selector.constructor == HTMLElement || isGlobalOrRoot(selector)) {
                elements.push(selector);
            }
            else if (selector.constructor == App.dom.jDom) {
                elements.push(selector.el);
            }
            else if (selector.constructor == App.query || selector.constructor == App.dom.DomQuery || selector.constructor == DomQuery || selector.constructor == App.dom.Form) {
                elements = selector.e("all");
            }
            else if (isArray(selector)) {
                for (let i = 0; i < selector.length; i++) {
                    const elm = selector[i];
                    if (elm instanceof Element || elm == document || elm == global) {
                        elements.push(elm);
                    }
                    else if (elm instanceof App.dom.jDom || elm.constructor == App.dom.jDom) {
                        elements.push(elm.el);
                    }
                }
            }
            return elements;
        },
        on: function () {
            if (this.length) {
                var args = [];
                var event = typeof arguments[0] == "string" ? arguments[0] : "error";
                for (let i = 0; i < arguments.length; i++) {
                    const arg = arguments[i];
                    args.push(arg)
                }
                var self = this;
                for (let j = 0; j < this.length; j++) {
                    const element = this[j];
                    let selector = null;

                    let fn = null;

                    if (args.length == 3) {
                        if (typeof args[2] == "function") {
                            fn = args[2];
                        }
                        if (args[1] instanceof App.dom.DomQuery || args[1].constructor == App.dom.DomQuery || isString(args[1]) || args[1] instanceof Element || isGlobalOrRoot(arg[1])) {
                            selector = args[1];
                            if (!fn) fn = args[2];
                        } else if (isFunction(args[1]) && !fn) {
                            fn = args[1];
                        }
                        if (!fn) {
                            // doan này chưa xong
                            App.func.check();
                        }
                    } else if (args.length == 2) {
                        fn = args[1];
                    }

                    let fnc = fn ? fn : function (e) {
                        console.log(e);
                    };


                    let fnt = fnc;

                    if (typeof fn == "string") {
                        fnt = function (e) {
                            return App.func.call(fn, [e]);
                        };
                    }
                    let cb = fnt;
                    if (selector) {
                        cb = function (e) {
                            let tag = e.target;
                            let evtag = null;
                            // danh sách phần tữ con dược giới hạn bởi phần tử element
                            let children = self.getParentNodes(tag, [tag], element);
                            // danh sách phần tữ con trùng khớp với selector
                            var matchChild = App.query(children).filter(selector).getElements();

                            if (children.length) {
                                for (let n = 0; n < children.length; n++) {
                                    const child = children[n];
                                    for (let m = 0; m < matchChild.length; m++) {
                                        const em = matchChild[m];
                                        if (child == em && em) {
                                            evtag = em;
                                            m += matchChild.length;
                                            n += children.length;
                                        }
                                    }
                                }
                            }
                            if (evtag) {
                                e.stopPropagation();
                                return fnt.apply(evtag, [e, element]);
                            }
                        };
                    }
                    event.split(" ").filter(function (evt) { return (domEvents.indexOf(evt) >= 0); }).map(function (evt) {
                        App.dom.addEvent(element, evt, cb, selector);
                    });

                }
            }
        },
        off: function (events, data) {
            data = data || null;
            if (this.length) {
                var evs = (events && events.length) ? events.split(" ") : domEvents;
                if (evs.length) {
                    for (let i = 0; i < this.length; i++) {
                        const el = this[i];
                        for (let j = 0; j < evs.length; j++) {
                            const ev = evs[j];
                            App.dom.removeEvent(el, ev, null, data);
                        }
                    }

                }
            }
            return this;
        },
        unbind: function () {
            this.off.apply(this,arguments);
            return this;
        },
        getElements: function (selector, filter) {
            if (!this.length) {
                return [];
            }
            var elements = [];
            for (let i = 0; i < this.length; i++) {
                if (typeof this[i] != "undefined") {
                    const element = this[i];
                    elements.push(element);
                }

            }
            if (typeof filter == "function") {
                return elements.filter(filter);
            }
            return elements;
        },
        map: function (mapFunc) {
            if (typeof mapFunc != "function") return [];
            var mapArr = [];
            for (let i = 0; i < this.length; i++) {
                if (typeof this[i] != "undefined") {
                    const element = this[i];
                    let mapEl = mapFunc(element, i);
                    if (mapEl !== undefined) mapArr.push();
                }
            }
            return mapArr;

        },
        each: function(eachFunc){
            if (typeof eachFunc != "function") return [];
            var mapArr = [];
            for (let i = 0; i < this.length; i++) {
                if (typeof this[i] != "undefined") {
                    const element = this[i];
                    let mapEl = eachFunc(i, element);
                    if (mapEl !== undefined) mapArr.push();
                }
            }
            return mapArr;
        },
        filter: function (selector) {
            var elems = this.getElements();
            var listMatch = App.query(selector).getElements().filter(function (el) {
                for (let i = 0; i < elems.length; i++) {
                    const elem = elems[i];
                    if (el == elem) return true;
                }
                return false;
            });
            return App.query(listMatch);
        },
        children: function (selector) {
            if (!this.length) return App.query();
            var childList = [];
            this.map(function (el) {
                if (el.children.length) {
                    for (let i = 0; i < el.children.length; i++) {
                        const element = el.children[i];
                        childList.push(element);
                    }
                }
            });
            if (!childList.length) return App.query();
            var children = App.query(childList);
            if (typeof selector == "undefined" || selector == null) return children;
            return children.filter(selector);

        },
        getTree: function (elem, list) {
            if (typeof elem == "undefined") return [];
            if (typeof list == "undefined" || !isArray(list)) {
                list = [];
            }
            if (elem instanceof Element) {
                var self = this;
                if (!elem.children.length) return list;
                for (let i = 0; i < elem.children.length; i++) {
                    const child = elem.children[i];
                    list.push(child);
                    if (child.children.length) {
                        list = self.getTree(child, list);
                    }
                }
            }
            return list;
        },
        getParentNodes: function (elem, list, elementStop) {
            if (typeof elem == "undefined") return [];
            if (typeof list == "undefined" || !isArray(list)) {
                list = [];
            }
            if (elem instanceof Element) {
                if (!elem.parentNode || (elementStop && elementStop == elem)) return list;
                var self = this;
                list.push(elem.parentNode);
                list = self.getParentNodes(elem.parentNode, list, elementStop);
            }
            return list;
        },
        parent: function (selector) {
            var list = [];
            this.map(function (el) {
                if (el.parentNode) {
                    list.push(el.parentNode);
                }
            });
            if (!selector) return App.query(list);
            var finders = App.query(selector).getElements();
            var filterList = (finders.length && list.length) ? list.filter(function (el) {
                for (let i = 0; i < finders.length; i++) {
                    const element = finders[i];
                    if (el == element) return true;
                }
                return false;
            }) : [];
            return App.query(filterList);
        },
        closest: function (selector) {
            if (selector == undefined) return this.parent();
            var finder = App.query(selector).getElements();
            var closestList = [];
            var findLength = finder.length;
            if (findLength) {
                var elements = this.getElements();
                var elementLength = elements.length;
                var parents = [];
                var parentLength = 0;
                var parent, find;
                if (findLength == 1) {
                    
                    finder = finder[0];
                    if (elementLength == 1) {
                        parents = this.getParentNodes(elements[0]);
                    } else {
                        for (let i = 0; i < elementLength; i++) {
                            const element = elements[i];
                            let ps = this.getParentNodes(element);
                            ps.map(function (p) {
                                parents.push(p);
                            });
                        }
                    }
                    parentLength = parents.length;
                    for (let n = 0; n < parentLength; n++) {
                        parent = parents[n];
                        if (parent == finder) {
                            if (closestList.indexOf(parent) < 0) {
                                closestList.push(parent);
                            }

                            n += parentLength;
                            break;
                        }
                    }
                } else {
                    if (elementLength == 1) {
                        parents = this.getParentNodes(elements[0]);
                    } else {
                        for (let i = 0; i < elementLength; i++) {
                            const element = elements[i];
                            let ps = this.getParentNodes(element);
                            ps.map(function (p) {
                                parents.push(p);
                            });
                        }
                    }
                    parentLength = parents.length;

                    for (let n = 0; n < parentLength; n++) {
                        parent = parents[n];
                        for (let m = 0; m < findLength; m++) {
                            find = finder[m];
                            if (parent == find) {
                                if (closestList.indexOf(parent) < 0) {
                                    closestList.push(parent);
                                }

                                m += findLength;
                            }
                        }
                    }
                }
            }
            return App.query(closestList);
        },
        is: function (selector) {
            if(this.length == 1){

                if(isString(selector) && selector.length > 1 && selector.substring(0, 1) == ":"){
                    return (typeof this[0][selector.substring(1)] != 'undefined' && this[0][selector.substring(1)]) ? true : false;
                }
                var $list = App.query(selector);
                if($list.filter(this[0]).length == 1){
                    return true;
                }
            }
            return false;
        },
        find: function (selector) {
            if (typeof selector == "undefined" || !selector) return App.query();
            var listChild = [];
            var self = this;
            this.map(function (el) {
                var ch = el.querySelectorAll(selector) || [];
                var l = ch.length;
                if (l) {
                    for (let i = 0; i < l; i++) {
                        const c = ch[i];
                        listChild.push(c);
                    }
                }

            });
            return App.query(listChild);
        },
        get: function get(index) {
            if (typeof index == "undefined") return this;
            if (isNumber(index)) {
                var elements = this.getElements();
                if (typeof elements[index] != "undefined") {
                    return App.query(elements[index]);
                }
            }
            return App.query();
        },
        first: function () {
            return App.query(this.length ? this.getElements(null, function (el, i) {
                return i == 0;
            }) : [])
        },
        last: function () {
            var elements = this.getElements();
            return App.query(elements.length ? elements[elements.length - 1] : []);
        },

        append: function (child) {
            if (child.constructor == App.dom.jDom) {
                this.map(function (el) {
                    el.appendChild(child.el);
                });
            } else {
                this.map(function (el) {
                    el.appendChild(App.dom.parse(child));
                });

            }

            return this;
        },
        prepend: function (child) {
            if (child.constructor == App.dom.jDom) {
                this.map(function (el) {
                    el.insertBefore(App.dom.parse(child.el), el.firstChild);
                });
            } else {
                this.map(function (el) {
                    el.insertBefore(App.dom.parse(child), el.firstChild);
                });

            }
            return this;
        },
        remove: function () {
            this.map(function (el) {
                if (el.parentNode) {
                    el.parentNode.removeChild(el);
                } else if (el.remove && isFunction(el.remove)) {
                    el.remove();
                }
            });
            return this;
        },

        getProp: function (prop, all) {
            if (!this.length) return "";
            if (!all) {
                return (typeof this[0][prop] != "undefined") ? this[0][prop] : null;
            } else {
                var p = [];
                this.map(function (el) {
                    p.push(el[prop]);
                });
                return p;
            }
        },
        setProp: function (prop, value) {
            if (!this.length) return this;
            var props = {};
            if (typeof prop == "object") {
                props = pros
            } else {
                props[prop] = value;
            }
            var elements = this.getElements();
            for (const p in props) {
                if (props.hasOwnProperty(p)) {
                    const val = props[p];
                    elements.map(function (element, index) {
                        element[prop] = val;
                    });
                }
            }

            return this;
        },
        removeProp: function (prop) {
            if (typeof prop != "undefined") {
                var elements = this.e("all");
                if (isString(prop)) prop = [prop];
                if (isArray(prop)) {
                    elements.map(function (el) {
                        prop.map(function (p) {
                            if (isString(p)) {
                                delete el[p];
                            }
                        })
                    });
                }
            }
            return this;
        },
        prop: function (prop, value) {
            if (prop) {
                if (typeof value != "undefined") {
                    if (!this.length) return this;
                    this.map(function (el) {
                        if (value === false) delete el[prop];
                        else el[prop] = value;
                    });
                } else {
                    if (!this.length) return null;
                    return this[0][prop] || null;
                }
            } else {
                if (!this.length) return {};
                var props = {};
                for (const key in this[0]) {
                    if (this[0].hasOwnProperty(key)) {
                        const propVal = this[0][key];
                        props[key] = propVal;
                    }
                }
                return props;
            }
        },
        val: function (value) {
            if (typeof value == "undefined" || value === null) {
                if (!this.length) return null;
                var inputs = this.getElements().filter(function (el) {
                    if(isGlobalOrRoot(el)) return false;
                    var tag = el.tagName.toLowerCase();
                    return (["input", "select", "textarea"].indexOf(tag) >= 0);
                });
                if (inputs.length) {
                    for (let i = 0; i < inputs.length; i++) {
                        const input = inputs[i];
                        let tag = input.tagName.toLowerCase();
                        let type = input.getAttribute("type");
                        if (tag == "textarea" || type == "textarea") {
                            return input.value || input.innerText;
                        } else if (["rasio", "checkbox"].indexOf(type) >= 0) {
                            if (input.checked) {
                                if (input.value != undefined) {
                                    return input.value;
                                } else {
                                    return "on";
                                }
                            }
                            return null;
                        }
                        else {
                            return input.value;
                        }

                    }
                }
                return null;
            } else {
                var inputs = this.getElements().filter(function (el) {
                    if(isGlobalOrRoot(el)) return false;
                    var tag = el.tagName.toLowerCase();
                    return (["input", "select", "tetxtarea"].indexOf(tag) >= 0);
                });
                if (inputs.length) {
                    for (let i = 0; i < inputs.length; i++) {
                        const input = inputs[i];
                        let tag = input.tagName.toLowerCase();
                        if (tag == "textarea") {
                            input.innerText = value
                        } else {
                            input.value = value;
                        }

                    }
                }
            }

            return this;
        },
        serialize: function () {
            if (!this.length || isGlobalOrRoot(this[0]) || this[0].tagName.toLowerCase() != "form") return "";
            var form = this[0];

            // Setup our serialized data
            var serialized = [];

            // Loop through each field in the form
            for (var i = 0; i < form.elements.length; i++) {

                var field = form.elements[i];

                // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
                if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

                // If a multi-select, get all selections
                if (field.type === 'select-multiple') {
                    for (var n = 0; n < field.options.length; n++) {
                        if (!field.options[n].selected) continue;
                        serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[n].value));
                    }
                }

                // Convert field data to a query string
                else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
                    serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
                }
            }

            return serialized.join('&');

        },
        /*!
        * Serialize all form data into a array
        * (c) 2018 Chris Ferdinandi, MIT License, https://gomakethings.com
        * @param  {Node}   form The form to serialize
        * @return {array}      The serialized form data
        */
        serializeArray: function () {
            if (!this.length || isGlobalOrRoot(this[0]) || this[0].tagName.toLowerCase() != "form") return [];
            var form = this[0];
            // Setup our serialized data
            // Setup our serialized data
            var serialized = [];
            // Loop through each field in the form
            for (var i = 0; i < form.elements.length; i++) {
                var field = form.elements[i];
                // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
                if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'button') continue;
                // If a multi-select, get all selections
                if (field.type === 'select-multiple') {
                    for (var n = 0; n < field.options.length; n++) {
                        if (!field.options[n].selected) continue;
                        serialized.push({
                            name: field.name,
                            value: field.options[n].value
                        });
                    }
                }

                // Convert field data to a query string
                else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
                    serialized.push({
                        name: field.name,
                        value: field.value
                    });
                }
            }
            return serialized;
        },


        formdata: function () {
            if (!this.length || isGlobalOrRoot(this[0]) || this[0].tagName.toLowerCase() != "form") return [];
            var form = this[0];
            // Setup our serialized data

            // Setup our serialized data
            var f = new FormData(form);
            return f;

        },
        serializeObject: function () {
            var serialized = this.serializeArray();
            var data = {};
            serialized.map(function (inp) {
                if(typeof data[inp.name] != undefined){
                    if(App.getType(data[inp.name] == 'array')){
                        data[inp.name].push(inp.value);
                    }else{
                        data[inp.name] = [data[inp.name]];
                    }
                }else{
                    data[inp.name] = inp.value;
                }
            });
            return data;
        },

        getHtml: function (all, joinKey) {
            if (!this.length) return "";
            if (!all && !isGlobalOrRoot(this[0])) {
                return this[0].innerHTML;
            } else {
                var html = "";
                if (!joinKey) joinKey = "";
                html = this.getElements().map(function (el) { return (isGlobalOrRoot(el)) ? "" :  el.innerHTML; }).join(joinKey);
                return html;
            }
        },
        html: function (str, all) {
            if (this.length) {
                if (typeof str == "undefined" || str === null) {
                    return this.getHtml(all, "");
                } else {
                    var self = this;
                    var elements = this.getElements(null, function (el) {
                        if(isGlobalOrRoot(el)) return false;
                        var tag = el.tagName.toLowerCase();
                        return self.simpleTags.indexOf(tag) < 0;
                    }).map(function (el) {
                        el.innerHTML = str;
                    });

                }
            }
            return this;
        },
        getAttribute: function (attr) {
            return this.length > 0 ? this[0].getAttribute(attr) : null;
        },
        setAttribute: function (attr, value) {
            this.getElements().map(function (el) { el.setAttribute(attr, value) });
            return this;
        },
        attr: function (attr, value) {
            if ((typeof value == "undefined" || value === null) && typeof attr != "object") {
                return this.getAttribute(attr);
            }
            else if (typeof attr != "undefined" && getType(attr) == "object") {
                var elements = this.getElements();
                for (const key in attr) {
                    if (attr.hasOwnProperty(key)) {
                        const ava = attr[key];
                        elements.map(function (t) {
                            t.setAttribute(key, ava);
                        })
                    }
                }
            }
            else if (typeof attr == "undefined" || attr === null) {
                return this.length ? this[0].attributes : {};
            }

            return this.setAttribute(attr, value)
        },
        data: function (key) {
            if (!this.length) return null;
            if (!this.__data) {
                var data = {};
                var dataRaw = {};

                var attrs = this[0].attributes;
                if (attrs.length) {
                    for (let i = 0; i < attrs.length; i++) {
                        const attr = attrs[i];
                        if (attr.name.toLowerCase().indexOf("data-") === 0) {
                            let a = attr.name.substring(5);
                            dataRaw[a] = attr.value;
                            let b = a.split("-");
                            let c = b.shift();
                            let d = b.map(function (v) { return App.str.ucfirst(v) });
                            let k = c + (d.length ? d.join("") : "");
                            data[k] = attr.value;
                        }
                    }
                }
                this.__data = {
                    raw: dataRaw,
                    parse: data
                };
            }
            if (typeof key == "undefined" || key == null) {
                return this.__data.parse;
            }
            if (typeof key == "string") {
                return (typeof this.__data.raw[key] != "undefined") ? this.__data.raw[key] : null;
            }
            if (isArray(key)) {
                var arrData = {};
                for (let i = 0; i < key.length; i++) {
                    const kk = key[i];
                    if (typeof this.__data.raw[kk] != "undefined") {
                        arrData[kk] = this.__data.raw[kk];
                    }
                }
                return arrData;
            }
            return null;
        },
        addClass: function (classname) {
            var classlist = [];
            var mapFunc = function (val) {
                if (isString(val)) {
                    classlist.push(val);
                } else if (isArray(val)) {
                    val.map(mapFunc);
                }
            };
            if (arguments.length) {
                for (let i = 0; i < arguments.length; i++) {
                    const arg = arguments[i];
                    mapFunc(arg);
                }

            }
            this.getElements(null, function (el) { return !isGlobalOrRoot(el); }).map(function (el) {
                classlist.map(function (str) {
                    el.classList.add(str);
                });
            });
            return this;
        },
        removeClass: function (classname) {
            var elems = this.getElements(null, function (el) { return !isGlobalOrRoot(el); });
            var classlist = [];
            var mapFunc = function (val) {
                if (isString(val)) {
                    classlist.push(val);
                } else if (isArray(val)) {
                    val.map(mapFunc);
                }
            };
            var args = [];

            if (arguments.length) {
                for (let i = 0; i < arguments.length; i++) {
                    const arg = arguments[i];
                    mapFunc(arg);
                }
                elems.map(function (el) {
                    classlist.map(function (str) {
                        el.classList.remove(str);
                    });
                });
            } else {
                elems.map(function (el) {
                    el.className = "";
                });
            }
            return this;
        },
        hasClass: function (classname) {
            if (this.length) {
                return this.length == this.getElements(null, function (el) { return (!isGlobalOrRoot(el) && el.classList.contains(classname)) }).length;
            }
            return false;
        },
        setCssProp: function (element, prop, value) {
            if(element instanceof Element && isString(prop) && isString(value)){
                element.style[prop] = value;
            }
        },
        getCssProp: function (element, prop) {
            if(element instanceof Element && isString(prop)){
                return typeof element.style[prop] != "undefined" ? String(element.style[prop]) : "";
            }
            return "";
        },
        css: function (prop, value) {
            var self = this;
            if(!prop || isEmpty(value) || !this.length){
                return this;
            }
            if(isString(prop)){
                this.map(function (e) {
                    self.setCssProp(e, App.str.camelToSlug(prop), value);
                });
            }else if(isObject(prop)){
                var props = {};
                for (const key in prop) {
                    if (prop.hasOwnProperty(key)) {
                        const v = prop[key];
                        var p = App.str.camelToSlug(key);
                        props[p] = v;
                        
                    }
                }
                this.map(function (e) {
                    for (const key in props) {
                        if (props.hasOwnProperty(key)) {
                            const v = props[key];
                            self.setCssProp(e, key, v);
                        }
                    }
                });
            }
            return this;
        },
        show: function (time, callback) {
            var self = this;
            var t = isNumber(time) ? parseInt(time): 0;
            var cb = isCallable(time)?time:(isCallable(callback)?callback:emptyFunc);
            this.css("display", "block");
            if(t > 0){
                var vpt = 1/time;
                var opc = 0;
                this.map(function (e) {
                    var opacity = self.getCssProp(e, "opacity");
                    if(opacity == "1") {
                        setTimeout(function () {
                            cb.call(e);
                        }, t);
                        return;
                    }
                    self.setCssProp(e, "opacity", 0);
                    for (let i = 0; i < t; i++) {
                        setTimeout(function () {
                            opc += vpt;
                            self.setCssProp(e, "opacity", opc);
                        }, i+1);
                    }
                    setTimeout(function () {
                        self.setCssProp(e, "opacity", 1);
                        cb.call(e);
                    }, t);
                });
            }else{
                this.map(function (e) {
                    var opacity = self.getCssProp(e, "opacity");
                    if(opacity == "1") {
                        cb.call(e);
                        return;
                    }
                    self.setCssProp(e, "opacity", 1);
                    cb.call(e);
                });
            }
            return this;
        },
        hide: function (time, callback) {
            var self = this;
            var t = isNumber(time) ? parseInt(time): 0;
            var cb = isCallable(time)?time:(isCallable(callback)?callback:emptyFunc);
            
            if(t > 0){
                var vpt = 1/time;
                var opc = 1;
                this.map(function (e) {
                    var opacity = self.getCssProp(e, "opacity");
                    if(opacity == "0" || opacity == "") {
                        setTimeout(function () {
                            cb.call(e);
                            self.setCssProp(e, "display", "none");
                        }, t);
                        return;
                    }
                    for (let i = 0; i < t; i++) {
                        setTimeout(function () {
                            opc -= vpt;
                            self.setCssProp(e, "opacity", opc);
                        }, i+1);
                    }
                    setTimeout(function () {
                        self.setCssProp(e, "opacity", 0);
                        self.setCssProp(e, "display", "none");
                        cb.call(e);
                    }, t);
                });
            }else{
                this.map(function (e) {
                    self.setCssProp(e, "opacity", 0);
                    self.setCssProp(e, "display", "none");
                    cb.call(e);
                });
            }
            
            return this;
        }


    };

    for (let i = 0; i < domEvents.length; i++) {
        const ev = domEvents[i];
        DomQuery.prototype[ev] = function (fn) {
            var args = [ev];
            for (let i = 0; i < arguments.length; i++) {
                const param = arguments[i];
                args.push(param);
            }
            if (args.length == 1) {
                this.map(function (el) {
                    if (el[ev] != undefined && isFunction(el[ev])) {
                        el[ev].call(el);
                    }
                });
                return this;
            }
            return this.on.apply(this, args);

        }
    }



    /**
     * triển khai thêm module
     * @param {object|string} moduleName
     * @param {*} moduleData
     */
    App.addQueryModule = App.prototype.addQueryModule = App.dom.addQueryModule = DomQuery.prototype.extends = function(moduleName, moduleData){
        if(moduleName){
            if(isString(moduleName) && !isNumber(moduleName)){
                DomQuery.prototype[moduleName] = moduleData;
            }else if(isObject(moduleName)){
                for (const key in moduleName) {
                    if (moduleName.hasOwnProperty(key)) {
                        const val = moduleName[key];
                        DomQuery.prototype[key] = val;
                    }
                }
            }
        }
    }

    