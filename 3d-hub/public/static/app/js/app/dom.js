



    /**
     * thao tác với dom thông qua html query gần giống jquery nhưng ít chức năng hơn
     */
    var domEvents = ("blur focus focusin focusout resize scroll click dblclick " +
        "mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " +
        "change select submit keydown keypress keyup contextmenu load").split(" ");


    /**
     * cái này là thao tác dom ảo
     */


    App.dom = App.prototype.dom = {
        simpleTags: ['img', 'meta', 'link', 'input', 'br', 'hr'],
        parse: function (str) {
            var div = document.createElement('div');
            if ((str instanceof Element)) return str;
            else if (typeof str == "object") {
                if (str instanceof App.dom.DomQuery || str.constructor == App.dom.Query || str.constructor == App.dom.Form || str.constructor == App.query) {
                    if (str.length > 0) {
                        return str[0];
                    } else {
                        return div;
                    }
                }
                else {
                    return this.create(str);
                }
            }
            var div = document.createElement('div');

            div.innerHTML = str.trim();

            // Change this to div.childNodes to support multiple top-level nodes
            return div.firstChild;
        },
        create: function (tag, content, attrs) {
            var tagName = 'div';
            var isSimple = false;
            if (typeof tag == "object") {
                attrs = {};
                for (const kk in tag) {
                    if (tag.hasOwnProperty(kk)) {
                        const vv = tag[kk];
                        let tt = kk.toLowerCase();
                        if (tt == "tag" || tt == "tagname") {
                            tagName = vv.toLowerCase();
                        }
                        else if (tt == "content") {
                            content = vv;
                        }
                        else {
                            attrs[kk] = vv;
                        }
                    }
                }
                if (this.simpleTags.indexOf(tagName.toLowerCase()) >= 0) {
                    isSimple = true;
                }

            } else if (typeof tag == "string") {
                tagName = tag;
            }
            if (isSimple || this.simpleTags.indexOf(tagName.toLowerCase()) >= 0) {
                attrs = content;
                isSimple = true;
            }

            var htmlObject = document.createElement(tagName);
            if (attrs && typeof attrs == "object") {
                for (const prop in attrs) {
                    if (attrs.hasOwnProperty(prop)) {
                        let val = attrs[prop];
                        let key = prop.toLowerCase();
                        let k = key;
                        let f = k.substring(0, 1);
                        let f2 = k.substring(0, 2);
                        let isEvent = domEvents.indexOf(key) >= 0;
                        if (f == '@' || f2 == 'on' || isEvent) {
                            let a = isEvent ? key : k.substring(f == '@' ? 1 : 2);
                            let cb = (typeof val == "function") ? val : function (e) {
                                App.func.call(val, [e.target]);
                            };
                            if (htmlObject.addEventListener) {
                                htmlObject.addEventListener(a, cb);
                            } else if (htmlObject.attachEvent) {
                                htmlObject.attachEvent(a, cb);
                            }
                        } else if (typeof val == 'object') {
                            let attrObj = App.str.convertTextObject({}, val, prop, '-');
                            for (const ak in attrObj) {
                                if (attrObj.hasOwnProperty(ak)) {
                                    const v = attrObj[ak];
                                    htmlObject.setAttribute(ak, v);
                                }
                            }
                        } else if (key == 'class' || key == 'classname') {
                            htmlObject.className = val;
                        }
                        else {
                            htmlObject.setAttribute(prop, val);
                        }
                    }
                }
            }
            if (!isSimple) {
                var cnt = null;
                if (tagName.toLowerCase() == 'textarea') {
                    htmlObject.innerText = content;
                } else if (content instanceof Element) {
                    htmlObject.appendChild(content);
                } else if (content && (typeof content == "object" || content.constructor == Array)) {
                    if (isArray(content)) {
                        for (let i = 0; i < content.length; i++) {
                            const el = content[i];
                            if (el instanceof Element) {
                                htmlObject.appendChild(el);
                            } else if (isObject(el) || isString(el)) {
                                htmlObject.appendChild(this.parse(el));
                            }
                        }
                    }
                    else {
                        htmlObject.appendChild(this.parse(content));
                    }

                } else if (typeof content == "string") {
                    htmlObject.appendChild(this.parse(content));
                }
            }
            return htmlObject;
        },
        input: function (args) {
            if (typeof args == "object") {
                var tagName = 'input';
                var attrs = {};
                var content = null;
                var value = null;
                var type = "text";
                var ignore = [];
                var data = [];
                for (const prop in args) {
                    if (args.hasOwnProperty(prop)) {
                        const val = args[prop];
                        let p = prop.toLowerCase();
                        if (p == 'type') {
                            let v = (typeof val == 'string') ? val.toLowerCase() : 'text';
                            type = v;
                            if (v == 'textarea') {
                                tagName = v;
                                ignore.push("type", "value");
                            } else if (v == "select") {
                                tagName = "select";
                                ignore.push("type", "value", "data");
                            } else {
                                attrs[p] = v;
                            }
                        } else if (ignore.indexOf(p) >= 0) {
                            // next
                        } else {
                            attrs[prop] = val;
                        }
                        if (p == 'value') {
                            value = val;
                        } else if (p == 'data') {
                            data = val;
                        }
                    }
                }
                var attributes = {};
                for (const key in attrs) {
                    if (attrs.hasOwnProperty(key)) {
                        const va = attrs[key];
                        if (ignore.indexOf(key.toLowerCase()) >= 0) {
                            // next
                        } else {
                            attributes[key] = va;
                        }
                    }
                }
                if (type == 'select') {
                    content = [];
                    if (typeof data == "object") {
                        for (const vl in data) {
                            if (data.hasOwnProperty(vl)) {
                                const text = data[vl];
                                let option = { value: vl };
                                if (vl == value) {
                                    option.selected = "selected";
                                }
                                content.push(this.create('option', text, option));
                            }
                        }
                    }
                } else if (type == "textarea") {
                    content = value;
                } else {
                    content = attributes;
                }
                return this.create(tagName, content, attributes);
            }
            return null;
        },
        encode: function (html) {
            var div = document.createElement("div");
            div.appendChild(this.make(html));
            return div.innerHTML;
        },
        decode: function (html) {
            return this.make(html);
        },
        render: function (html, root) {
            if (root instanceof Element) {
                root.appendChild(this.parse(html));
            } else {
                document.body.appendChild(this.parse(html));
            }
        },
        parseClass: function (className) {
            var prefix = App.getSystemOption("cssClassPrefix");
            var cls = '';
            cls += prefix + className;
            if(arguments.length > 1){
                for (let i = 1; i < arguments.length; i++) {
                    const cln = arguments[i];
                    cls += " "+prefix+cln;
                }
            }
            return cls;
        },
        make: function (tag, content, attributes) {
            return new this.jDom(tag, content, attributes);
        },
        jDom: function (tag, content, attributes) {
            var $html = App.dom;
            this.el = $html.create(tag, content, attributes);
            this.children = [];
            this.parent = null;
            var self = this;
            this.addClass = function (className) {
                this.el.classList.add(className);
                return this;
            };
            this.removeClass = function (className) {
                if (className) {
                    this.el.classList.remove(className);
                } else {
                    this.el.className = "";
                }
                return this;
            };
            this.append = function (child) {
                if (child.constructor == App.dom.jDom) {
                    this.children.push(child);
                    this.el.appendChild(child.el);
                } else {
                    this.el.appendChild($html.parse(child));
                }

                return this;
            };
            this.prepend = function (child) {
                if (child.constructor == App.dom.jDom) {
                    this.children.unshift(child);
                    this.el.insertBefore($html.parse(child.el), this.el.firstChild);
                } else {
                    this.el.insertBefore($html.parse(child), this.el.firstChild);
                }
                return this;
            };

            this.toHTML = function () {
                return $html.encode(this.el);
            };

            this.html = function () {
                return this.el.innerHTML;
            };
            this.text = function () {
                return this.el.innerText;
            };
            this.appendTo = function (parent) {
                if (parent.constructor == App.dom.jDom) {
                    this.parent = parent;
                    parent.append(this);
                } else if (parent instanceof Element) {
                    parent.appendChild(this.el);
                }
                return this;
            }
            this.prependTo = function (parent) {
                if (parent.constructor == App.dom.jDom) {
                    this.parent = parent;
                    parent.prepend(this);
                } else if (parent instanceof Element) {
                    parent.insertBefore(this.el, parent.firstChild);
                }
                return this;
            }
            this.render = function (root) {
                if (root instanceof Element) {
                    root.appendChild(this.el);
                } else {
                    document.body.appendChild(this.el);
                }
            };
            this.remove = function () {
                if (this.parent) {
                    this.parent.removeChild(this);
                } else if (this.el.parentNode) {
                    this.el.parentNode.removeChild(this.el);

                } else {
                    this.el.innerHTML = "";
                    this.el.style.display = "none";
                }
            };
            this.on = function (envent, callback) {
                addEventListener(this.el, envent, callback);
            };
            if (this.el.tagName == "input") {
                this.val = function (value) {
                    if (typeof value != "undefined") {
                        this.el.value = value;
                    }
                    return this.el.value;
                };
            } else if (this.el.tagName == "input") {
                this.val = function (value) {
                    if (typeof value != "undefined") {
                        this.el.innerText = value;
                    }
                    return this.el.innerText;
                }
            } else if (this.el.tagName == "select") {
                this.val = function (value) {
                    if (typeof value != "undefined") {
                        this.el.value = value;
                    }
                    return this.el.value;
                }
            }
        }

    };


    var eventHandler = function (e) {
        console.log(e.target);
    };

    /**
     * mảng chứ các event sự kiện
     * mỗi phần tử trong mảng chứa element, tên sự kiện, handle, và task
     * task là một danh sách gồm callback và data
     */
    App.dom.events = [];
    // thêm sự kiện 

    /**
     * them su kien cho element
     * @param {Element} element dom element
     * @param {string} event ten su kien
     * @param {function} callback
     * @param {string} data 
     * @return {boolean}
     */
    App.dom.addEvent = function (element, event, callback, data) {
        if (!element || !event || (!(element instanceof Element) && !isGlobalOrRoot(element)) || !isString(event) || !callback || !isCallable(callback)) return false;
        event = event.toLowerCase();
        data = data || null;

        // tìm trong danh sách sự kiện có tồn tại sự kiện này chưa
        for (let i = 0; i < this.events.length; i++) {
            const eventData = this.events[i];
            // một cặp element và event là key của một bản ghi dom event
            if (eventData.element === element && eventData.event === event) {
                for (let j = 0; j < eventData.tasks.length; j++) {
                    const evCallback = eventData.tasks[j];
                    if (data) {
                        if (data == evCallback.data && evCallback.callback === callback) return true;
                    } else if (evCallback.callback === callback) return true;
                }
                addEventListener(element, event, callback);
                this.events[i].tasks.push({
                    callback: callback,
                    data: data
                });


                return true;
            }
        }
        addEventListener(element, event, callback);
        this.events.push({
            element: element,
            event: event,
            data: data,
            tasks: [
                {
                    callback: callback,
                    data: data
                }
            ]
        });
        return true;
    };

    /**
     * them su kien cho element
     * @param {Element} element dom element
     * @param {string} event ten su kien
     * @param {function} callback
     * @param {string} data 
     * @return {boolean}
     */

    App.dom.removeEvent = function (element, event, callback, data) {
        // trưởng hợp không gửi element nào thì xóa tất cả
        if (!element || (!(element instanceof Element) && !isGlobalOrRoot(element)) || !isString(event)) {
            for (let i = 0; i < this.events.length; i++) {
                const eventData = this.events[i];
                if (eventData.tasks.length) {
                    eventData.tasks.map(function (task) {
                        removeEventListener(eventData.element, eventData.event, task.callback);
                    });
                }

            }
            this.events = [];

            // 
            return false;
        }
        event = event ? event.toLowerCase() : null;
        data = data || null;
        // duyệt mảng để tím element và event phù hợp
        for (let i = 0; i < this.events.length; i++) {
            const eventData = this.events[i];
            if (eventData.element === element) {
                if (!event) {
                    if (eventData.tasks.length) {
                        eventData.tasks.map(function (task) {
                            removeEventListener(eventData.element, eventData.event, task.callback);
                        });
                    }
                    this.events.splice(i, 1);
                    i--;
                }
                else if (eventData.event === event) {
                    for (let j = 0; j < eventData.tasks.length; j++) {
                        const evCallback = eventData.tasks[j];
                        if (data) {
                            if (data == evCallback.data) {
                                if (callback && isFunction(callback)) {
                                    if (evCallback.callback === callback) {
                                        removeEventListener(eventData.element, eventData.event, evCallback.callback);
                                        this.events[i].tasks.splice(j, 1);
                                        j--;
                                    }
                                }
                            }
                        } else if (callback && isFunction(callback)) {
                            if (evCallback.callback === callback) {
                                removeEventListener(eventData.element, eventData.event, evCallback.callback);
                                this.events[i].tasks.splice(j, 1);
                                j--;
                            }
                        } else {
                            removeEventListener(eventData.element, eventData.event, evCallback.callback);
                            this.events[i].tasks.splice(j, 1);
                            j--;
                        }
                    }
                    if (!this.events[i].tasks.length) {
                        // removeEventListener(eventData.element, eventData.event, eventData.handle);
                        this.events.splice(i, 1);
                        i--;
                    }
                }
            }
        }
    };
    App.dom.getEvents = function (element, event, data) {
        event = event || null;
        element = element || null;
        data = data || null;
        var list = [];
        if (!element && !event) return this.events;
        for (let i = 0; i < this.events.length; i++) {
            const eventData = this.events[i];
            if ((!element || element == eventData.element) && (!event || event == eventData.event)) {
                list.push(eventData);
            }
        }
        return list;
    };
    App.dom.getEventData = function (element, event, data) {
        event = event || null;
        element = element || null;
        data = data || null;
        if (!element && !event) return null;
        for (let i = 0; i < this.events.length; i++) {
            const eventData = this.events[i];
            if ((!element || element == eventData.element) && (!event || event == eventData.event)) {
                return eventData;
            }
        }
        return null;
    };
