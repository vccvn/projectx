import { assignValue, assignWithout, date, getType, inArray, isArray, isBoolean, isCallable, isEmpty, isFunction, isNull, isNumber, isObject, isString, objectHasProperty, Str, _defineProperty, _instanceof } from './utils';
// import Dom, { $, Query, query } from './dom.js';
import createClass, { _class, ES5AbstractClass } from './es5.class';
"use strict";

const global = window;

const DEFAULT_VALUE = Str.rand(Str.rand(date('ms')));

var $document = window.document, div = $document.createElement("div"), simpleTags = ['img', 'meta', 'link', 'input', 'br', 'hr'], createElement = $document.createElement;

/**
 * thao tác với dom thông qua html query gần giống jquery nhưng ít chức năng hơn
 */
var domEvents = (
    "blur focus focusin focusout resize scroll click dblclick " +
    "mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " +
    "change select submit keydown keypress keyup contextmenu load input"
).split(" ");
var allEvents = (
    "abort afterprint animationend animationiteration animationstart beforeprint beforeunload blur canplay canplaythrough " +
    "change click contextmenu copy cut dblclick drag dragend dragenter dragleave dragover dragstart drop durationchange " +
    "ended error focus focusin focusout fullscreenchange fullscreenerror hashchange input invalid keydown keypress keyup " +
    "load loadeddata loadedmetadata loadstart message " +
    "mousedown mouseenter mouseleave mousemove mouseover mouseout mouseup mousewheel pointerdown pointerup pointermove " +
    "offline online open pagehide pageshow paste pause play playing popstate progress ratechange resize reset scroll " +
    "search seeked seeking select show stalled storage submit suspend timeupdate toggle " +
    "touchcancel touchend touchmove touchstart transitionend unload volumechange waiting wheel"
).split(" ").filter(function (s) { return s.length > 0 });

// danh sách tag hợp lệ
var htmlTags = ("a abbr acronym address applet area article aside audio b base basefont bb bdo big blockquote body br button canvas caption center cite code col colgroup command datagrid datalist dd del details dfn dialog dir div dl dt em embed eventsource fieldset figcaption figure font footer form frame frameset h1 h2 h3 h4 h5 h6 head header hgroup hr  html i iframe img input ins isindex kbd keygen label legend li link map mark menu meta meter nav noframes noscript object ol optgroup option output p param pre progress q rp rt ruby s samp script section select small source span strike strong style sub sup table tbody td textarea tfoot th thead time title tr track tt u ul var video wbr").split(" ");


/**
* mảng chứ các event sự kiện
* mỗi phần tử trong mảng chứa element, tên sự kiện, handle, và task
* task là một danh sách gồm callback và data
*/
var events = [];


var inputTypes = [
    "button", "submit", "image", "reset", "checkbox", "radio", // click

    "color", "range",
    "file", "hidden",

    "date", "datetime-local", "month", "time", "week",

    "text", "number", "email", "password", "search", "tel", "url"

];
var inputTags = ['input', 'textarea', 'select'];


var $window = null, $root = null;

var oneTimeData: any = {};

var isset = false;


/**
 * 
 */
var stopCallChildrenTask: any = {};

var curremtCallChildrenMethodID: any = null;
/**
 * các phương thức và thuộc tính của dom element
 */

/**
 * Lấy ra phần tử cha có kết quả trùng khớp
 * @param {Element} element
 * @param {string|Element|Query|Dom} selector 
 * @returns {Element}
 */
function closest(selector: any, element?: any) {
    if (!element) return null;
    if (selector == undefined) return element ? element.parentNode || null : null;
    var finder = [];
    if (isObject(selector)) {
        if (selector.isDom) {
            finder.push(selector.el);
        }
        else if (selector.isQuery) {
            for (var index = 0; index < selector.length; index++) {
                var el = selector[index];
                finder.push(el);
            }
        }
        else if (selector instanceof Element) {
            finder.push(selector);
        }
    }
    else if (selector instanceof Element) {
        finder.push(selector);
    }
    else if (isString(selector)) {
        var els = document.querySelectorAll(selector);
        if (els.length) {
            for (var index = 0; index < els.length; index++) {
                var el = els[index];
                finder.push(el);
            }
        }
    }
    var closestList = null;
    var findLength = finder.length;
    if (findLength) {
        var parents: any = getParentNodes(element);
        var parentLength = parents.length;
        var parent: any = undefined, find: any = undefined;

        for (let n = 0; n < parentLength; n++) {
            parent = parents[n];
            for (let m = 0; m < findLength; m++) {
                find = finder[m];
                if (parent == find) {
                    closestList = parent;

                    m += findLength;
                    n += parentLength;
                }
            }
        }

    }
    return closestList;
}
interface DomEl {
    el: HTMLElement,
    isDom: boolean,
    tagName: string,
    id: string,
    className: string,
    children: DomEl[],
    parent: DomEl,
    setup: (...args: any[]) => this,
    /**
     * thêm lang nghe su kien
     */
    addEventListener: (type: string, handler: (arg0: Event) => any, passed?: any) => this,
    hasEventListener: (type: string, handler: (arg0: Event) => any) => boolean,
    removeEventListener: (type: string, handler?: (arg0: Event) => any) => this,
    dispatchEvent: (event: any) => this,
    addDomEvent: (event: any, handler?: (arg0: Event) => any, passed?: any) => this,
    hasEvent: (type: string, handler?: (arg0: Event) => any) => boolean,
    off: (events: any, handler?: (arg0: Event) => any) => this,
    trigger: (event: any, data: any) => this,
    on: (event: any, handler?: (arg0: Event) => any) => this,
    fn: (method: any) => (e: Event) => any,
    is: (selector: any, el: any) => boolean,
    closest: (selector: any, el: any) => any,
    getProp: (prop: any, all?: any) => any,
    setProp: (prop: any, value?: any) => this,
    removeProp: (prop: any) => this,
    prop: (prop: any, value?: any) => this,
    val: (value?: any) => any,
    getHtml: () => any,
    setHtml: (html?: any) => any,
    html: (html?: any) => string,
    getAttribute: (attr?: any) => any,
    setAttribute: (attr: any, value?: any) => this,
    attr: (attr?: any, value?: any) => any,
    attrData: (key?: any) => any,
    addClass: (className: any) => this,
    removeClass: (classname?: any) => this,
    hasClass: (classname: any) => boolean,
    css: (prop: any, value?: any) => any,
    height: (height?: any) => number,
    width: (width?: any) => number,
    append: (child: any) => this,
    prepend: (child: any) => this,
    appendTo: (parent: any) => this,
    prependTo: (parent: any) => this,
    hasDomChild: (child?: any) => boolean,
    removeDomChild: (child?: any) => void,
    removeChild: (child?: any, removeDomEl?: any) => this,
    remove: () => this,
    setContent: (content: any) => this,
    sendToChildren: (channel: any, data: any) => boolean,
    onParentTransmission: (channel: any, handler?: (arg0: Event) => any) => this,
    onParentData: (channel: any, handler?: (arg0: Event) => any) => this,
    sendToParent: (channel: any, data?: any) => this,
    onChildrenTransmission: (channel: any, handler?: (arg0: Event) => any) => this,
    onChildrenData: (channel: any, handler?: (arg0: Event) => any) => this,
    callParentMethod: (method: any, args?: any[]) => any,
    cpm: (method: string, args?: any[]) => any,
    parentCall: (method: string, args?: any[]) => any,
    callParent: (method: string, args?: any[]) => any,
    onChildrenCallMethod: (method: string, args?: any[]) => any,
    callChildrenMethod: (method: string, args: any, className: any) => any,
    ccm: (method: string, args: any, className: any) => any,
    childrenCall: (method: string, args: any, className: any) => any,
    callChildren: (method: string, args: any, className: any) => any,
    onCallMethodFromParent: (method: string, args: any, className: any) => any,
    sendToSiblings: (slug: any, data: any) => any,
    onReceiveFromSiblings: (channel: any, data: any) => any,
    callSiblingMethod: (method: string, args: any) => any,
    callSiblings: (method: string, args: any) => any,
    siblingCall: (method: string, args: any) => any,
    csm: (method: string, args: any) => any,
    getRootElement: () => DomEl,
    moveTo: (parent: any, pos: any) => any,
    moveChild: (child: any, receiveDomEl: any, pos: any) => any,
    moveIn: (child: any, pos: any, oldparent: any) => any
}


interface DomFactory extends ES5AbstractClass {

    /**
     * Tạo đối tượng dome element với 3 tham số:
     * @param {string} selector selector không băt buộc có dạng #id.class[attribute="value"]:prop tất caa3 cá thành phần đều không bắt buộc và có thể lặp lại nhiều lần tức là nhiều class hoặc thuộc tính. chỉ có id là duy nhất
     * @param {Element[]|DomEl[]|string[]} children Mảng các phần tử con
     * @param {object} attributes các thuộc tính
     * @returns {DomEl}
     */
    new(selector: string, children?: (DomEl | string | Element)[], attributes?: { [x: string]: any }, ...args: any[]): DomEl,
    new(selector: string, attributes?: { [x: string]: any }, children?: (DomEl | string | Element)[], ...args: any[]): DomEl,
    new(selector?: string, children?: (DomEl | string | Element)[], attributes?: { [x: string]: any }, ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    new(children?: (DomEl | string | Element)[], attributes?: { [x: string]: any }, ...args: any[]): DomEl,
    new(attributes?: { [x: string]: any }, children?: (DomEl | string | Element)[], ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    new(attributes?: { [x: string]: any }, ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    new(): DomEl,

    (selector: string, children?: (DomEl | string | Element)[], attributes?: { [x: string]: any }, ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    (children: (DomEl | string | Element)[], attributes?: { [x: string]: any }, ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    (attributes: { [x: string]: any }, ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    (child: (DomEl | string | Element), attributes?: { [x: string]: any }, ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    (attributes: { [x: string]: any }, child: (DomEl | string | Element), ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    (attributes: { [x: string]: any }, children?: (DomEl | string | Element)[], ...args: ((DomEl | string | Element) | ((DomEl | string | Element))[] | any)[]): DomEl,
    (): DomEl
    // with(key:any, value?:any):DomEl,
    withParent?(parent: DomEl): DomEl

}

/**
 * Tạo đối tượng dom
 * @param {string|object} selector
 * @param {string|Element|string[]|Element[]} children
 * @param {object} attributes
 * @returns {DomEl}
 * @note {string} Đoạn này thật ra không cần thiết. nhưng viết bào để trình soạn thảo sử dụng gợi ỳ
 */
//  var Dom = function Dom(selector?: any, children?: any, attributes?: any):DomEl {
//     this.setup.apply(this, getArguments(arguments));
//     this.isDom = true;
//     return this;
// };

// Dom.prototype.isDom = true;

/**
 * tạo đối tượng với phẩn tử cha
 * @param {DomElement} parent phần tử cha
 * @param {*} args danh sách tham số
 */


var Dom: DomFactory = _class("Dom")({
    static$isDomClass: true,
    $el: null,
    // const$isQuery: true,
    const$isDom: true,
    $tagName: null,
    $id: "",
    $className: "",

    $children: null,
    $parent: null,

    // gọi hàm hoặc truyền dữ liệu
    $__transmissionEventListeners: null,

    $__transmissionStatus: true,

    $dynamicCreateMode: true,

    $__canSetChildren: false,

    $__dynamicSync: false,

    // khai bao ham se dc boot
    boots: ["__boot__", '__setBootData__', '___assignDynamicProperties___'],

    inits: ["__init__"],

    $__dynamicAttrs: null,

    $_listeners: null,

    $_pendingContents: null,
    $___show___: false,
    $___parentNode___: null,
    $___markcomment___: null,

    $__dataTypes__: null,
    $__syncOnChange__: true,
    $__dataSync__: true,

    __setBootData__: function () {
        if (oneTimeData && isObject(oneTimeData) && !isEmpty(oneTimeData)) {
            for (const key in oneTimeData) {
                if (Object.hasOwnProperty.call(oneTimeData, key)) {
                    const value = oneTimeData[key];
                    this[key] = value;
                }
            }
            oneTimeData = {};
        }
    },


    __boot__: function () {
        this.__transmissionEventListeners = {
            fromChildren: {},
            fromParent: {},
            fromSiblings: {},

            events: {},
        };
        this.__dynamicAttrs = {};
        this._pendingContents = [];
        this.__canSetChildren = true;
        this.children = [];
        this.__dataTypes__ = [];
        this.__canSetChildren = false;
        // this.static.__addAccessorKey("hide");
        // this.static.__addAccessorKey("show");
        // this.static.__addAccessorKey("next");
        // this.static.__addAccessorKey("previous");


    },

    __init__: function () {
        if (!this.el) {
            this.setup(this.getDefaultSelector())
        }

        var self = this;
        if (typeof this.render == "function") {
            var children = this.render();
            if (children) {
                this.removeChild();
                this.append(children);
            }
        }
        // bắt sự kiện change và thay đổi cá thuộc tính dộng cho nó dồng bộ
        this.on("change", function (event) {
            if (event.target == self.el) {
                if (this.__dynamicSync) {
                    var attrs = self.attr();
                    for (var key in self.__dynamicAttrs) {
                        if (Object.hasOwnProperty.call(self.dyna1micAttrs, key)) {
                            var val = self.__dynamicAttrs[key];
                            var camelKey = Str.slugToCamel(key),
                                slugKey = Str.camelToSlug(key);
                            var s = null;
                            var v = null;
                            if (Object.hasOwnProperty.call(attrs, key) && attrs[key] != val) {
                                self.__changeAccessorValue__(key, attrs[key]);
                                s = key;
                                v = attrs[key];
                            }
                            else if (Object.hasOwnProperty.call(attrs, slugKey) && attrs[slugKey] != val) {
                                self.__changeAccessorValue__(key, attrs[slugKey]);
                                s = camelKey;
                                v = attrs[camelKey];
                            }
                            else if (Object.hasOwnProperty.call(attrs, camelKey) && attrs[camelKey] != val) {
                                self.__changeAccessorValue__(key, attrs[camelKey]);
                                s = slugKey;
                                v = attrs[slugKey];
                            }
                            if (s) {
                                self.trigger({
                                    type: "change.attr." + s,
                                    preventDefault: function () {
                                        // stt = false;
                                    },
                                    target: self.el,
                                    data: {
                                        attr: s,
                                        value: v
                                    }
                                });
                            } // end if status == true
                        } // end has prop
                    } // wnd for
                } // end if dynamic sync
            } // end if target == el
        }) // end call 
    },

    ___assignDynamicProperties___: function () {
        var self: any = this;
        function show(time?: any, callback?: any) {

            // function _show() {
            if (self.___show___) return self;
            var t = isNumber(time) ? parseInt(time) : 0;
            var cb = isCallable(time) ? time : (isCallable(callback) ? callback : emptyFunc);

            function _show() {
                var e = self.el;
                if (t > 0) {
                    var vpt = 1 / time;
                    var opc = 0;

                    var opacity = getCssProp(e, "opacity");

                    if (opacity == "1") {
                        setTimeout(function () {
                            cb.call(e);
                        }, t);
                        return;
                    }
                    self.setCssProp(e, "opacity", 0);
                    for (var i = 0; i < t; i++) {
                        setTimeout(function () {
                            opc += vpt;
                            setCssProp(e, "opacity", opc);
                        }, i + 1);
                    }
                    setTimeout(function () {
                        setCssProp(e, "opacity", 1);
                        cb.call(e);
                    }, t);
                } else {
                    var opacity = getCssProp(e, "opacity");
                    if (opacity == "1") {
                        cb.call(e);
                        return;
                    }
                    setCssProp(e, "opacity", 1);
                    cb.call(e);
                }

            }

            // if(!_show()) return this;

            if (self.___markcomment___) {
                self.___markcomment___.parentNode.insertBefore(self.el, self.___markcomment___);
                self.___show___ = true;
                _show();
            } else {
                var next = next({ ___show___: true });
                if (next) {
                    next.el.parentNode.insertBefore(self.el, next.el);
                    self.___show___ = true;
                    _show();
                } else if (self.parent) {
                    self.parent.el.appendChild(self.el);
                    self.___show___ = true;
                    _show();
                }
            }


            return self;
        }

        /**
         * 
         * @param {int} time thời gian tinh bang ms
         * @param {function} callback làm gì đó sau khi hoàn thành
         */
        function hide(time: any = 0, callback?: any) {
            var e = self.el;
            var t = isNumber(time) ? parseInt(time) : 0;
            var cb = isCallable(time) ? time : (isCallable(callback) ? callback : emptyFunc);
            if (!self.el.parentNode) return self;
            if (!self.___parentNode___) self.___parentNode___ = self.el.parentNode;
            if (!self.___markcomment___) {
                self.___markcomment___ = document.createComment("/" + self.tagName + (self.el.id ? "#" + self.id : "") + (self.el.className ? "." + self.el.className.split(" ").map(function (t) { return t.trim(); }).filter(function (t) { return t.length > 0; }).join(".") : ""))
                self.___parentNode___.insertBefore(self.___markcomment___, self.el);
            }
            self.___show___ = false;
            if (t > 0) {
                var vpt = 1 / time;
                var opc = 1;
                var opacity = getCssProp(e, "opacity");
                if (opacity == "0" || opacity == "") {
                    setTimeout(function () {
                        self.el.parentNode.removeChild(self.el);
                        cb.call(e);

                    }, t);
                    return;
                }
                for (var i = 0; i < t; i++) {
                    setTimeout(function () {
                        opc -= vpt;
                        setCssProp(e, "opacity", opc);
                    }, i + 1);
                }
                setTimeout(function () {
                    setCssProp(e, "opacity", 0);
                    self.el.parentNode.removeChild(self.el);
                    cb.call(e);
                }, t);
            } else {
                setCssProp(e, "opacity", 0);
                self.el.parentNode.removeChild(self.el);
                cb.call(e);
            }

            return self;
        }

        function next(args?: any) {

            if (self.parent) {
                let index = self.parent.children.indexOf(self);
                var s = false;
                for (let i = index+1; i < self.parent.children.length; i++) {
                    const child = self.parent.children[i];
                    if (isObject(args)) {
                        var a = true;
                        for (const key in args) {
                            if (Object.hasOwnProperty.call(args, key)) {
                                const value = args[key];
                                if (child[key] != value) a = false;
                            }
                        }
                        if (a) return child;
                    }
                    else if (isFunction(args) && args(child)) return child;
                    else if (!args) return child;

                }
            }
            return null;
        }

        function previous(args?: any) {
            if (self.parent) {
                let index = self.parent.children.indexOf(self);
                for (let i = index-1; i > -1; i--) {
                    const child = self.parent.children[i];
                    if (isObject(args)) {
                        var a = true;
                        for (const key in args) {
                            if (Object.hasOwnProperty.call(args, key)) {
                                const value = args[key];
                                if (child[key] != value) a = false;
                            }
                        }
                        if (a) return child;
                    }
                    else if (isFunction(args) && args(child)) return child;
                    else if (!args) return child;
                }
            }
            return null;
        }
        Object.defineProperties(show, {
            toString: {
                configurable: false,
                enumerable: false,
                value: function () {
                    return self.___show___;
                }
            },
            __toData__: {
                configurable: false,
                enumerable: false,
                value: function () {
                    return self.___show___;
                }
            },
            isBoolean: {
                value: true,
                writable: false,
                configurable: false,
                enumerable: false
            }
        })
        Object.defineProperties(hide, {
            toString: {
                configurable: false,
                enumerable: false,
                value: function () {
                    return !self.___show___;
                }
            },
            __toData__: {
                configurable: false,
                enumerable: false,
                value: function () {
                    return !self.___show___;
                }
            },
            isBoolean: {
                value: true,
                writable: false,
                configurable: false,
                enumerable: false
            }
        })

        Object.defineProperties(this, {
            show: {
                configurable: false,
                enumerable: false,
                set: function (status) {
                    if (isBoolean(status)) {
                        if (status) show();
                        else hide();
                    }
                },
                get: function () {
                    return show;
                }
            },
            hide: {
                configurable: false,
                enumerable: false,
                set: function (status) {
                    if (isBoolean(status)) {
                        if (status) hide();
                        else show();
                    }
                },
                get: function () {
                    return hide;
                }
            },
            next: {
                configurable: false,
                enumerable: false,
                set: function (value) {
                    // lam gi do
                },
                get: function () {
                    return next();
                }
            },
            previous: {
                configurable: false,
                enumerable: false,
                set: function (value) {
                    // lam gi do
                },
                get: function () {
                    return previous();
                }
            }

        });

    },

    /**
     * set id cho element khi set cho object
     * @param {string} id id của element
     */
    onSet$id: function (id) {
        this.attr('id', id);
    },
    onSet$className: function (className) {
        this.removeClass().addClass(className);
    },

    onSet$children: function onSetChildren(value) {
        if (!this.__canSetChildren) console.warn("Bạn không thể set giá trị cho children");
        return this.__canSetChildren;
    },
    onGet$children: function getChildren(value) {
        var returnValue = value;
        if (!isArray(value)) {
            returnValue = [];
            this.__canSetChildren = true;
            this.children = returnValue;
            this.__canSetChildren = false;
        }
        return returnValue;
    },

    onSet$parent: function onSetParent(parent) {
        if (!parent || !parent.isDom) {
            return false;
        }
        var s = this.dispatchEvent({
            type: "setparent",
            target: this.el,
            eventData: parent,
            parent: parent
        });
        if (s !== false) {
            if (typeof this.onSetParent == "function") {
                s = this.onSetParent(parent);
            }

            if (s !== false) {
                this.___parentNode___ = parent.el;
                if (typeof this.becomeAChild == "function") {
                    this.becomeAChild(parent);
                }
            }
        }

    },
    constructor: function Dom() {
        if (arguments.length) {
            this.setElement.apply(this, arguments);
        }
    },
    const$getDefaultSelector: function () {
        return "div#" + (
            this.id ? this.id : Str.rand()
        ) + "." + (
                this.className ? this.className.split(" ").map(function (v) {
                    return v.trim();
                }).filter(function (v) {
                    return v.length > 0;
                }).join('.') : 'dom-element'
            );
    },
    /**
     * thiết lập
     * @param {string|object}
     */
    final$setElement: function setElement(params) {
        var args = getArguments(arguments);
        if (args.length && typeof args[0] != "string") {
            args.unshift(this.getDefaultSelector());
        }
        var elem = create.apply(this, args);
        var el = elem.el;
        if (el) {

            if (!el.id && this.id) el.id = this.id;
            if (!el.className && this.className) el.className = this.className;

            this.el = el;
            if (!isEmpty(elem.__dynamicAttrs)) {
                this.addDynamicAttr(elem.__dynamicAttrs);
            }
            if (!isEmpty(elem.dataTypeAttrs)) {
                for (const key in elem.dataTypeAttrs) {
                    if (Object.hasOwnProperty.call(elem.dataTypeAttrs, key)) {
                        const vl = elem.dataTypeAttrs[key];
                        this.setDataTypeAttribute(key, vl);

                    }
                }
            }
            // console.log(this, args, elem.contents);
            if (!isEmpty(elem.contents)) {
                for (var index = 0; index < elem.contents.length; index++) {
                    this.append(elem.contents[index]);

                }
            }
            if (!isEmpty(elem.events)) {
                this.on(elem.events);
            }

            if (!isEmpty(elem.methods)) {
                for (var method in elem.methods) {
                    if (Object.hasOwnProperty.call(elem.methods, method)) {
                        var fn = elem.methods[method];
                        // console.log(method, fn)
                        _defineProperty(this, method, fn);
                    }
                }
            }
            if (this._pendingContents.length) {
                while (this._pendingContents.length) {
                    var a = this._pendingContents.shift();
                    this[a.key] = a.content;
                    this.append(a.content);
                }
            }
        }
        return this;
    },
    /**
     * giống element
     * @param {*} args thông tin element
     */
    final$setup: function setElement(args) {
        return this.setElement.apply(this, getArguments(arguments));
    },
    final$setDataTypeAttribute: function (key, value, sync) {
        if (!((isObject(value) && (value.isObjectData || value.isArrayData) || value.isPrimitive) || (isFunction(value) && value.isPrimitive))) return sync ? this.addDynamicAttr(key, value) : this.setAttribute(key, value);
        this.__dataSync__ = false;
        this.setAttribute(key, value.__toData__());
        var vl = value;
        if (this.__dataTypes__[key] === undefined) {
            var self = this;
            this.__dataTypes__[key] = value;
            value.__addChangeEvent__(function (e) {
                self.__dataSync__ = false;
                self.__syncOnChange__ = false;
                vl = e.value;
                this.setAttribute(key, e.value.__toData__());
                self.__dataSync__ = true;
                self.__syncOnChange__ = true;
            });
            Object.defineProperty(this, key, {
                configurable: true,
                enumerable: true,
                get: function () {
                    return vl;
                },
                set: function (value2) {
                    if (vl.__PARENT__) {
                        var key = vl.__PARENT__.keyOf(vl);
                        if (key !== undefined) {
                            self.__syncOnChange__ = false;
                            self.__dataSync__ = false;
                            vl.__PARENT__[key] = value2;
                            self.__dataSync__ = true;
                            self.__syncOnChange__ = true;
                        }
                    }
                }
            })
            if (sync) {
                this.on("change", function (e) {
                    if (e.target == self.el) {
                        var vlchange = self.attr(key);
                        if (vlchange != vl.__toData__() && self.__syncOnChange__) {
                            self.__syncOnChange__ = false;
                            self[key] = vlchange;
                            self.__syncOnChange__ = true;

                        }
                    }
                })
            }
        }
    },
    /**
     * Thêm thuộc tính động
     * @param {string} attr tên thuộc tính
     * @param {string|number} value 
     * @returns this
     */
    final$addDynamicAttr: function (attr, value) {
        if (isString(attr)) {
            var self = this;
            if ((isObject(value) && (value.isObjectData || value.isArrayData) || value.isPrimitive) || (isFunction(value) && value.isPrimitive)) return this.setDataTypeAttribute(key, value);
            this.attr(attr, value);
            this.__addSetGetValue__({
                key: attr,
                value: value,
                set: function (val) {
                    self.__dynamicSync = false;
                    var stt = true;
                    this.trigger({
                        type: "change.attr." + attr,
                        preventDefault: function () {
                            stt = false;
                        },
                        target: this.el,
                        data: {
                            attr: attr,
                            value: val
                        }
                    });

                    if (stt) {
                        this.__dynamicAttrs[attr] = val;
                        this.attr(attr, val);

                    }
                    self.__dynamicSync = true;
                },
                get: function () {
                    return this.dyna1micAttrs[attr] || null;
                }
            })
        }
        else if (isObject(attr)) {
            for (var key in attr) {
                if (Object.hasOwnProperty.call(attr, key)) {
                    this.addDynamicAttr(key, attr[key]);
                }
            }
        }
        return this;
    },

    /**
     * chuẩn hóa hàn lắng nghe sự kiện
     * @param {string|function} handler tên phương thức hoạc hàm handler
     * @returns function
     */

    parseEventHandler: function (handler?: any) {
        var self: any = this;
        var element = this.el;

        var fnt = handler ? handler : function (e) {
            console.log(e);
        };

        if (typeof handler == "string") {
            var instanceID: any = undefined;


            var handleInfo = handler.split(".");
            if (handleInfo.length == 2) {
                instanceID = handleInfo[0];
                handler = handleInfo[1];
            }
            var params = [];
            var handleParams = handler.split(":");
            if (handleParams.length == 2) {
                handler = handleParams[0];
                params = handleParams[1].split(",").map(function (s) { return s.trim(); });

            }

            if (this.parent && this.parent.isDom) {

                if (!instanceID) {
                    params.unshift(handler);
                    var fn = self.getTreeMethod.apply(self, params);
                    if (fn) {
                        fnt = fn;
                    }
                    else fnt = function (e) {
                        e.component = self;
                        console.log(e);
                    };
                } else {
                    fnt = function (e) {
                        // e.preventDefault();
                        e.component = self;
                        var args = [e];

                        params.map(function (p) { args.push(p); });
                        if (!instanceID) {
                            params.unshift(handler);
                            var fn = self.getTreeMethod.apply(self, params);

                            if (typeof fn == "function") {
                                return fn.apply(self, args);
                            }
                        }

                        if (typeof self[handler] == "function") {
                            return self[handler].apply(self, args);
                        } else {
                            return self.callChildrenMethod(handler, args, instanceID);
                        }
                    };
                }
            }
            else {
                fnt = function (e) {
                    // e.preventDefault();
                    e.component = self;
                    var args = [e];
                    params.map(function (p) { args.push(p); });
                    if (!instanceID) {
                        params.unshift(handler);
                        var fn = self.getTreeMethod.apply(self, params);

                        if (typeof fn == "function") {
                            return fn.apply(self, args);
                        }
                    }

                    if (typeof self[handler] == "function") {
                        return self[handler].apply(self, args);
                    } else {
                        return self.callChildrenMethod(handler, args, instanceID);
                    }
                };
            }

        }
        else if (typeof handler == "function") {
            fnt = function (e) {
                return handler.call(self, e);
            };
        }

        return fnt;
    },

    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} passed tham số báo có cần kiểm tra hay ko
     * @returns this
     */
    addEventListener: function (type?: any, handler?: any, passed?: any) {
        var self = this;
        var element = this.el;
        var listener = passed === DEFAULT_VALUE ? handler : this.parseEventHandler(handler);


        if (this._listeners === undefined || this._listeners === null) this._listeners = {};

        type = String(type).toLowerCase();



        if (isDomEvent(type)) return this.addDomEvent(type, listener, DEFAULT_VALUE);
        const listeners = this._listeners;

        if (listeners[type] === undefined) {

            listeners[type] = [];

        }

        if (listeners[type].indexOf(listener) === - 1) {

            listeners[type].push(listener);

        }

        return this;
    },

    hasEventListener: function (type?: any, listener?: any) {

        if (this._listeners === undefined || this._listeners === null) return false;

        const listeners = this._listeners;
        type = String(type).toLowerCase();
        return listeners[type] !== undefined && listeners[type].indexOf(listener) !== - 1;

    },

    removeEventListener: function (type?: any, listener?: any) {

        if (this._listeners === undefined || this._listeners === null) return;
        type = String(type).toLowerCase();
        if (isDomEvent(type)) return this.off.apply(getArguments(arguments));
        const listeners = this._listeners;
        const listenerArray = listeners[type];

        if (listenerArray !== undefined) {

            const index = listenerArray.indexOf(listener);

            if (index !== - 1) {

                listenerArray.splice(index, 1);

            }

        }

        return this;
    },


    dispatchEvent: function (event?: any) {
        if (this._listeners === undefined || this._listeners === null) return;

        if (isDomEvent(event.type)) return this.trigger.apply(this, getArguments(arguments));
        const listeners = this._listeners;
        const listenerArray = listeners[event.type];

        if (listenerArray !== undefined) {

            var s = true;
            event.target = this.el;

            event.stopImmediatePropagation = function () {
                s = false;
            }
            // Make a copy, in case listeners are removed while iterating.
            const array = listenerArray.slice(0);

            for (var i = 0, l = array.length; i < l; i++) {

                array[i].call(this, event);
                if (!s) break;

            }
            return s;

        }

    },

    /**
     * lắng nghe sự kiện của dom
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} passed tham số báo có cần kiểm tra hay ko
     * @returns this
     */
    addDomEvent: function (event?: any, handler?: any, passed?: any) {
        var self = this;
        var element = this.el;
        var listener = passed === DEFAULT_VALUE ? handler : this.parseEventHandler(handler);


        if (!isDomEvent(event)) return this.addEventListener(event, listener, DEFAULT_VALUE);

        event.split(" ").filter(function (evt) { return (allEvents.indexOf(evt) >= 0); }).map(function (evt) {
            addEvent(element, evt, listener, null);
        });
        return this;
    },
    hasEvent: function (event?: any, listener?: any) {
        return isDomEvent(event) ? hasEvent(this.el, event, listener) : this.hasEventListener(event, listener);
    },
    /**
     * Huỷ sự kiện 
     * @param {string} events Danh sách sự kiện
     * @param {function} handler 
     * @returns {Query|Dom}
     */
    off: function (events?: any, handler?: any) {
        handler = handler || null;
        if (this.el) {
            var evs = (events && events.length) ? events.split(" ") : domEvents;
            if (evs.length) {
                for (var j = 0; j < evs.length; j++) {
                    var ev = evs[j];
                    if (!isDomEvent(ev)) {
                        this.removeEventListener(ev, handler);
                    }
                    else {
                        removeEvent(this.el, ev, null, handler);
                    }

                }

            }
        }
        return this;
    },
    /**
     * Gán sự kiện
     * @param {string|Event} event sự kiện
     * @returns {Query|Dom}
     */
    trigger: function trigger(event?: any, data?: any) {
        var ev = isString(event) ? event : (event ? event.type : null);
        var e = !isObject(event) ? { type: ev } : event;
        var el = this.el;
        if (!e.target) {
            e.target = el;
        }
        if (!e.data && data !== undefined) e.data = data;
        if (!isDomEvent(ev)) return this.dispatchEvent(e);

        triggerEvent(el, ev, e);
        return this;
    },

    emit: function(){
        return this.trigger.apply(this, arguments);
    },
    /**
     * Huỳ sự kiện
     */
    unbind: function () {
        this.off.apply(this, arguments);
        return this;
    },
    /**
     * lang nghe su kien
     * @param {string} event tên sự kiện
     * @param {function(Event)} handler hàm xử lý sự kiện
     * @returns {this}
     * 
     */
    on: function on(event?: any, handler?: any) {
        if (isString(event)) {
            var args = getArguments(arguments);
            var self = this;

            var s = event.toLowerCase().split(".");
            if (event == 'transmission' || (s.length > 1 && s[0] == 'transmission')) {
                event = event.toLowerCase();
                if (typeof handler != "function") return this;
                if (event != 'transmission') {
                    if (typeof this.__transmissionEventListeners.events[event] == "undefined") {
                        this.__transmissionEventListeners.events[event] = [];
                    }
                    this.__transmissionEventListeners.events[event].push(handler);
                } else {
                    if (typeof this.__transmissionEventListeners.events.transmission == "undefined") {
                        this.__transmissionEventListeners.events.transmission = [];
                    }
                    this.__transmissionEventListeners.events.transmission.push(handler);
                }
                return this;
            }
            else if (isDomEvent(event)) {
                self.addDomEvent.apply(this, args);
            } else {
                this.addEventListener(event, handler);
            }

        }
        else if (isObject(event)) {
            for (var key in event) {
                if (Object.hasOwnProperty.call(event, key)) {
                    this.on(key, event[key]);
                }
            }
        }
        return this;
    },
    /**
     * lấy về một callback đến hàm hiện tại
     * @param {string} method tên phương thức
     * @returns function(e:Event)
     */
    const$fn: function fn(method?: any) {
        var self = this;
        if (!isString(method) || typeof self[method] != "function") return function (e) { console.log(e) };
        var args = getArguments(arguments);
        var fn = self[method];
        return function (e) {
            e.component = this;
            args[0] = e;
            return fn.apply(self, args);
        };
    },
    /**
     * lấy về một callback đến hàm hiện tại
     * @param {string} method tên phương thức
     * @returns {function(Event)}
     */
    const$getTreeMethod: function getTreeMethod(method?: any) {
        var self = this;
        if (!isString(method)) return function (e) { console.log(e) };
        var args = getArguments(arguments);
        if (typeof self[method] != "function") {
            if (this.parent && typeof this.parent.getTreeMethod == "function") {
                return this.parent.getTreeMethod.apply(this.parent, args);
            }
            return null;
        }

        var fn = self[method];
        return function (e) {
            e.component = this;
            args[0] = e;
            return fn.apply(self, args);
        };
    },
    /**
     * Kiểm tra phần từ có trùng khớp với trạng thái hay phần tử đầu vào hay không
     * @param {string|Element} selector 
     * @returns {boolean}
     */
    is: function is(selector?: any, el?: any) {
        var e = null;
        if (el) {
            if (isObject(el)) {
                if (el.isDom) {
                    e = el.el;
                }
                else if (_instanceof(el, Element)) {
                    e = el;
                }
                else return false;
            }
            else if (isString(el)) {
                var elm = $document.querySelectorAll(el);
                if (elm.length) {
                    e = elm;
                }
                else return false;
            }
            else return false;
        }
        else if (this.el) {
            e = this.el;
        }
        else {
            return false;
        }


        if (isString(selector)) {
            if (selector.length > 1 && selector.substring(0, 1) == ":") {
                var s = selector.substring(1);
                if (_instanceof(e, Element)) return (typeof e[s] != 'undefined' && e[s]) ? true : false;
                for (let i = 0; i < e.length; i++) {
                    const ell = e[i];
                    if (typeof ell[s] != 'undefined' && ell[s]) return true;
                }
                return false;
            }
            var elem = $document.querySelectorAll(selector);
            for (let i = 0; i < elem.length; i++) {
                const ele = elem[i];
                if (_instanceof(e, Element)) {
                    if (e == ele) return true;
                }
                else if (e.length) {
                    for (let j = 0; j < e.length; j++) {
                        const ee = e[j];
                        if (ee == ele) return true;
                    }
                }
            }

        }
        if (selector instanceof Element) {
            if (_instanceof(e, Element)) {
                if (e == selector) return true;
            }
            else if (e.length) {
                for (let j = 0; j < e.length; j++) {
                    const ee = e[j];
                    if (ee == selector) return true;
                }
            }
        }
        if (isObject(selector) && selector.isDom) {
            if (_instanceof(e, Element)) {
                if (e == selector.el) return true;
            }
            else if (e.length) {
                for (let j = 0; j < e.length; j++) {
                    const ee = e[j];
                    if (ee == selector.el) return true;
                }
            }
        }

        return false;
    },

    closest: function (selector?: any, el?: any) {
        if (!(el instanceof Element)) el = this.el;
        return closest(selector, el);
    },


    getProp: function (prop?: any, all?: any) {
        if (!this.el) return "";
        return (typeof this.el[prop] != "undefined") ? this.el[prop] : null;
    },
    setProp: function (prop?: any, value?: any) {
        if (!this.el) return this;
        var props = {};
        if (typeof prop == "object") {
            props = prop
        } else {
            props[prop] = value;
        }
        // var elements = this.getElements();
        for (var p in props) {
            if (props.hasOwnProperty(p)) {
                var val = props[p];
                this.el[prop] = val;
            }
        }

        return this;
    },

    removeProp: function (prop?: any) {
        if (typeof prop != "undefined") {
            if (isString(prop)) prop = [prop];
            if (isArray(prop)) {
                prop.map(function (p) {
                    if (isString(p)) {
                        delete this.el[p];
                    }
                })
            }
        }
        return this;
    },

    /**
     * 
     * @param {string|string{}} prop 
     * @param {*} value 
     */
    prop: function (prop?: any, value?: any) {
        if (!this.el) return this;
        if (prop) {
            if (typeof value != "undefined") {

                if (value === false) {
                    this.el[prop] = value;
                    delete this.el[prop];
                }
                else this.el[prop] = value;
                return this;
            } else {
                return this.el[prop] || null;
            }
        } else {
            var props = {};
            for (var key in this[0]) {
                if (this.el.hasOwnProperty(key)) {
                    var propVal = this.el[key];
                    props[key] = propVal;
                }
            }
            return props;
        }
    },
    val: function val(value?: any) {
        if (typeof value == "undefined" || value === null) {
            var input = this.el;
            var tag = input.tagName.toLowerCase();
            var type = input.getAttribute("type");
            if (tag == "textarea" || type == "textarea") {
                return input.value || input.innerText;
            } else if (["radio", "checkbox"].indexOf(type) >= 0) {
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
        } else {
            var input = this.el;
            var tag = input.tagName.toLowerCase();
            if (tag == "textarea") {
                input.innerText = value
            } else {
                input.value = value;
            }
        }

        return this;
    },

    getHtml: function () {
        if (!this.el || isGlobalOrRoot(this.el)) return "";
        return this.el.innerHTML;
    },
    setHtml: function (html?: any) {
        if (this.el) {
            this.removeChild();
            this.el.innerHTML = html;
        }
        return this;
    },
    html: function (str?: any) {
        if (this.el) {
            if (typeof str == "undefined" || str === null) {
                return this.getHtml();
            } else {
                this.setContent(str)
            }
        }
        return this;
    },
    getAttribute: function (attr?: any) {
        return this.el ? this.el.getAttribute(attr) : null;
    },
    setAttribute: function (attr?: any, value?: any) {
        this.el.setAttribute(attr, value);
        return this;
    },
    attr: function attr(attr?: any, value?: any) {
        if (typeof attr == "undefined" || attr === null) {
            return this.el ? this.el.attributes : {};
        }
        else if ((typeof value == "undefined" || value === null) && typeof attr != "object") {
            return this.getAttribute(attr);
        }
        else if (typeof attr != "undefined" && getType(attr) == "object") {

            for (var key in attr) {
                if (attr.hasOwnProperty(key)) {
                    var ava = attr[key];
                    this.setAttribute(key, value)
                }
            }
        }

        return this.setAttribute(attr, value)
    },
    attrData: function (key?: any) {
        if (!this.el) return null;
        if (!this.__data) {
            var data = {};
            var dataRaw = {};

            var attrs = this.el.attributes;
            if (attrs.length) {
                for (var i = 0; i < attrs.length; i++) {
                    var attr = attrs[i];
                    if (attr.name.toLowerCase().indexOf("data-") === 0) {
                        var a = attr.name.substring(5);
                        dataRaw[a] = attr.value;
                        var b = a.split("-");
                        var c = b.shift();
                        var d = b.map(function (v) { return Str.ucfirst(v) });
                        var k = c + (d.length ? d.join("") : "");
                        data[k] = attr.value;
                    }
                }
            }
            this.__addSetGetValue__({
                key: '__data',
                value: {
                    raw: dataRaw,
                    parse: data
                }
            });
        }
        if (typeof key == "undefined" || key == null) {
            return this.__data.parse;
        }
        if (typeof key == "string") {
            return (typeof this.__data.raw[key] != "undefined") ? this.__data.raw[key] : null;
        }
        if (isArray(key)) {
            var arrData = {};
            for (var i = 0; i < key.length; i++) {
                var kk = key[i];
                if (typeof this.__data.raw[kk] != "undefined") {
                    arrData[kk] = this.__data.raw[kk];
                }
            }
            return arrData;
        }
        return null;
    },
    /**
     * thêm class
     * @param {string} className 
     */
    addClass: function (className?: any) {
        var classlist = [];
        var mapFunc = function (val) {
            if (isString(val)) {
                classlist.push(val);
            } else if (isArray(val)) {
                val.map(mapFunc);
            }
        };
        if (arguments.length) {
            for (var i = 0; i < arguments.length; i++) {
                var arg = arguments[i];
                if (isString(arg)) {
                    mapFunc(arg.split(" ").map(function (v) {
                        return v.trim();
                    }).filter(function (v) { return v.length > 0 }));
                } else {
                    mapFunc(arg);
                }

            }

        }
        var self = this;
        classlist.map(function (str) {
            self.el.classList.add(str);
        });
        return this;
    },

    removeClass: function (classname?: any) {
        var classlist = [];
        var mapFunc = function (val?: any) {
            if (isString(val)) {
                classlist.push(val);
            } else if (isArray(val)) {
                val.map(mapFunc);
            }
        };
        var args = [];
        var self = this;
        if (arguments.length) {
            for (var i = 0; i < arguments.length; i++) {
                var arg = arguments[i];
                if (isString(arg)) {
                    mapFunc(arg.split(" ").map(function (v) {
                        return v.trim();
                    }).filter(function (v) { return v.length > 0 }));
                } else {
                    mapFunc(arg);
                }
            }
            classlist.map(function (str) {
                self.el.classList.remove(str);
            });
        } else {
            self.el.className = "";
        }
        return this;
    },

    hasClass: function (classname?: any) {
        if (this.el) {
            return this.el.classList.contains(classname);
        }
        return false;
    },

    css: function (prop?: any, value?: any) {
        var self = this;
        if (!this.el) {
            return {};
        }
        else if (!prop) {
            return this.el.style;
        }
        else if (isString(prop) && isEmpty(value)) {
            var style = this.el.style;
            var p = Str.camelToSlug(prop, '-');
            var s = p[0].toLowerCase() + prop.substr(1);
            if (Object.hasOwnProperty.call(style, p)) return style[p];
            if (Object.hasOwnProperty.call(style, s)) return style[s];
            return "";
        }
        if (isString(prop)) {
            setCssProp(this.el, prop, value);
        } else if (isObject(prop)) {
            for (var key in prop) {
                if (prop.hasOwnProperty(key)) {
                    var v = prop[key];
                    setCssProp(this.el, key, v);
                }
            }
        }
        return this;
    },

    height: function (height?: any) {
        return typeof height == "undefined" ? (this.el ? (this.el.clientHeight || this.el.offsetHeight) : 0) : this.css({ height: height });
    },
    width: function (width?: any) {
        return typeof width == "undefined" ? (this.el ? (this.el.clientWidth || this.el.offsetWidth) : 0) : this.css({ width: width });
    },
    /**
     * Thêm phần tử con vào cuối danh danh sách phần tử con của element
     * @param {*} child 
     * @returns {DomElement}
     */
    const$append: function (child?: any) {
        if (typeof child == "undefined" || isNull(child) || simpleTags.indexOf(this.tagName) !== -1) return this;
        var self = this;
        if (isFunction(child) && child.isDomClass) child = child('#inp-' + Str.rand());
        if (isObject(child)) {
            if (child.isDom) {
                child.parent = this;
                this.el.appendChild(child.el);
                this.children.push(child);
            }
            else if (child.isDomQuery) {
                this.el.appendChild(child.el);
                this.children.push(child);
            }
            else if (child.isQuery) {
                child.map(function (el) {
                    self.el.appendChild(el);
                });
                this.children.push(child);
            }
            else if (child instanceof Element) {
                this.el.appendChild(child);
                this.children.push(child);
            }
        }
        else if (isArray(child)) {
            for (var index = 0; index < child.length; index++) {
                this.append(child[index]);

            }
        } else if (child instanceof Element) {
            this.el.appendChild(child);
            this.children.push(child);
        }
        else {
            var c = parse(child);
            if (c) {
                this.el.appendChild(c);
                this.children.push(c);
            }


        }

        return this;
    },
    /**
     * Thêm phần tử con vào Đầu danh sách phần tử con cvua3 element
     * @param {*} child 
     * @returns {Query|Dom}
     */
    const$prepend: function (child?: any) {
        if (typeof child == "undefined" || isNull(child) || simpleTags.indexOf(this.tagName) !== -1) return this;

        var self = this;
        if (isFunction(child) && child.isDomClass) child = child('#inp-' + Str.rand());

        if (isObject(child)) {
            if (child.isDom) {
                child.parent = self;
                this.children.unshift(child);
                this.el.insertBefore(child.el, this.el.firstChild);
            }
            else if (child.isDomQuery) {
                this.el.insertBefore(child.el, this.el.firstChild);
                this.children.unshift(child);
            }
            else if (child.isQuery) {
                for (var index = child.length - 1; index > -1; index--) {
                    const c = child[index];
                    this.el.insertBefore(c, this.el.firstChild);
                }
                this.children.unshift(child);
            }
            else if (child instanceof Element) {
                this.el.insertBefore(child, this.el.firstChild);
                this.children.unshift(child);
            }


        } else {
            var c = parse(child);
            this.el.insertBefore(c, this.el.firstChild);
            this.children.unshift(c);
        }

        return this;
    },

    /**
     * Thêm phần tử con vào cuối danh danh sách phần tử con cvua3 element
     * @param {*} parent 
     * @returns {Query|Dom}
     */

    const$appendTo: function (parent?: any) {
        if (typeof parent == "undefined") return this;
        if (parent.isDom) {
            parent.append(this);
        } else if (parent instanceof Element) {
            parent.appendChild(this.el);
            this.___parentNode___ = parent;

        }
        else if (isString(parent)) {
            var domEl = $document.querySelector(parent);
            if (domEl && _instanceof(domEl, Element)) {
                domEl.appendChild(this.el);
                this.___parentNode___ = domEl;
            }
        }
        return this;
    },
    const$prependTo: function (parent?: any) {
        if (typeof parent == "undefined") return this;
        if (parent.isDom) {
            parent.prepend(this);
        } else if (parent instanceof Element) {
            parent.insertBefore(this.el, parent.firstChild);
            this.___parentNode___ = parent;
        } else if (isString(parent)) {
            var domEl = $document.querySelector(parent);
            if (domEl && _instanceof(domEl, Element)) {
                domEl.insertBefore(this.el, domEl.firstChild)
                this.___parentNode___ = domEl;
            }
        }



        return this;
    },

    /**
     * kiểm tra vó phần tử dom con của el hay không
     * @param {Element} child Dom Element - phàn tử html con cần kiểm tra
     * @returns {boolean}
     */
    hasDomChild: function (child?: any) {
        if (_instanceof(child, Element)) {
            if (this.el.children.length) {
                for (var index = 0; index < this.el.children.length; index++) {
                    var chl = this.el.children[index];
                    if (chl === child) return true;
                }
            }
        }
        return false;
    },

    removeDomChild: function (child?: any) {
        if (this.hasDomChild(child)) {
            this.el.removeChild(child);
        }
    },


    /**
     * xóa phần tử con
     * @param {Element|Dom|DomElement|Dom.Query} child 
     * @param {boolean} removeDomEl Xóa dom el
     */
    final$removeChild: function (child?: any, removeDomEl?: any) {
        if (typeof removeDomEl == "undefined") removeDomEl = true;
        if (!isBoolean(removeDomEl)) removeDomEl = true;

        if (child) {
            var self = this;
            if (child.isDom || child.isDomQuery) {
                if (removeDomEl) {
                    this.removeDomChild(child.el);
                }
            }
            else if (child.isQuery) {
                child.map(function (ch) {
                    try {
                        self.el.removeChild(ch)
                    } catch (error) {
                        if (ch.parentNode) {
                            ch.parentNode.removeChild(ch)
                        }
                    }

                });

            }
            else if (child instanceof Element) {
                this.removeDomChild(child);

            }

            if (!isArray(this.children)) return this;

            for (var index = 0; index < this.children.length; index++) {
                const c = this.children[index];
                if (c == child) {
                    this.children.splice(index, 1);
                }
            }
            if (this.children.length == 0) {
                this.el.innerHTML = "";
            }
        }
        else {
            if (!isArray(this.children)) return this;

            while (this.children.length) {
                this.removeChild(this.children[0]);
            }
        }
        return this;

    },

    /**
     * Xóa
     */
    final$remove: function () {
        var children = getArguments(arguments);
        if (children.length) {
            var self = this;
            children.map(function (child) {
                self.removeChild(child);
            });
        }
        else if (this.parent) {
            this.parent.removeChild(this);
        }
        else if (this.el.parentNode) {
            this.el.parentNode.removeChild(this.el);
        }
        return this;
    },

    /**
     * thay thế / thêm nội dung cho thẻ
     * @param {Element|DomElement|string|Element[]|DomElement[]|string[]} content nội dung
     */
    final$setContent: function (content?: any) {
        this.removeChild();
        return this.append(content);
    },


    final$stopTransmission: function () {
        this.__transmissionStatus = false;
    },


    /**
     * nhận dữ liệu giữ các component cha -> con
     * @param {string} channel tên sự kiện
     * @param {*} data dữ liệu bất kỳ
     */
    final$receiveFromParent: function receiveFromParent(channel?: any, data?: any, sentId?: any) {
        var next = true;
        var self = this;
        var a = 0;
        var stop = false;
        var arr, fn, s = undefined;
        var eventData = {
            type: "",
            preventDefault: function () {
                next = false;
                a++;
            },
            stopTransmission: function () {
                next = false;
                self.stopTransmission();
                a++;
            },
            stopPropagation: function stopPropagation() {
                self.stopTransmission();
                next = false;
                a++;
            },
            data: data
        };

        if (Object.hasOwnProperty.call(this.__transmissionEventListeners.fromParent, channel)) {
            arr = this.__transmissionEventListeners.fromParent[channel];
            try {
                if (arr.length) {
                    for (var index = 0; index < arr.length; index++) {
                        fn = arr[index];
                        if (typeof fn == "function") {
                            a++;
                            s = fn.call(this, data);
                            if (s === false) {
                                next = false;
                                self.parent.stopTransmission();
                                break;
                            }
                        }

                    }
                }

            } catch (error) {
                console.log(error);
            }
        }
        if (next) {
            if (!a) {
                var c = Str.replace(
                    Str.ucword(
                        channel.split("-").join(" ")
                    ),
                    " ",
                    ""
                );
                var listFn = [
                    "onReceive" + c + "FromParent",
                    "on" + c + "FromParent",
                    "onReceive" + c + "Data",
                    "onReceive" + c,
                    "onParent" + c + "Data"
                ];
                var mt = "";
                for (var i = 0; i < listFn.length; i++) {
                    mt = listFn[i];
                    if (next && typeof self[mt] == "function") {
                        var stt = self[mt].call(self, data);
                        if (stt === false) {
                            next = false;
                            self.parent.stopTransmission();
                            break;
                        }
                    }
                }
            }
        }
        if (next) {
            var slug = channel.toLowerCase();
            var mtfs = ["transmission.fromparent." + slug, "transmission.fromparent", "transmission"];
            var mt = "";
            for (var n = 0; n < mtfs.length; n++) {
                mt = mtfs[n];
                if (next && Object.hasOwnProperty.call(self.__transmissionEventListeners.events, mt)) {
                    eventData.type = mt;
                    arr = self.__transmissionEventListeners.events[mt];
                    if (arr.length) {
                        for (var index = 0; index < arr.length; index++) {
                            fn = arr[index];
                            if (typeof fn == "function") {
                                // a++;
                                s = fn.call(self, eventData);
                                if (s === false || !next) {
                                    next = false;
                                    self.parent.stopTransmission();
                                    index += arr.length;
                                }
                            }

                        }
                    }
                }
                if (!next) break;

            }
        }
        // truyền cho các thằng con
        if (next) {
            this.__sendToChildren__(channel, data, sentId);
        }
    },
    /**
     * tuyền dữ liệu giữ các component cha -> con
     * @param {string} channel tên sự kiện
     * @param {*} data dữ liệu bất kỳ
     * @param {string} sentId id của class gửi
     */
    final$__sendToChildren__: function (channel?: any, data?: any, sentId?: any) {
        var instanceID = this.getInstanceID();
        if (!sentId) sentId = instanceID;
        this.__transmissionStatus = true;
        // truyền cho các thằng con
        if (this.children.length) {
            for (var i = 0; i < this.children.length; i++) {
                var child = this.children[i];
                if (typeof child.receiveFromParent == "function") {
                    child.receiveFromParent(channel, data, sentId);
                    if (this.__transmissionStatus == false) {
                        if (sentId != instanceID && this.parent) {
                            this.parent.stopTransmission();
                        }
                        break;
                    }
                }
            }
        }
        this.__transmissionStatus = true;
        return this;
    },
    /**
     * tuyền dữ liệu giữ các component cha -> con
     * @param {string} channel tên sự kiện
     * @param {*} data dữ liệu bất kỳ
     */
    final$sendToChildren: function (channel?: any, data?: any) {
        return this.__sendToChildren__(channel, data);
    },
    /**
     * Nhận dữ liệu từ cha
     * @param {string} channel tên đường truyền
     * @param {function} handler 
     * @returns {DomElement}
     */
    final$onParentTransmission: function (channel?: any, handler?: any) {
        if (isString(channel) && isFunction(handler)) {
            if (typeof this.__transmissionEventListeners.fromParent[channel] == "undefined") {
                this.__transmissionEventListeners.fromParent[channel] = [];
            }
            this.__transmissionEventListeners.fromParent[channel].push(handler);
        }
        if (isObject(channel)) {
            for (var s in channel) {
                if (Object.hasOwnProperty.call(channel, s)) {
                    if (typeof channel[s] == "function") {
                        this.onParentTransmission(s, channel[s]);
                    }
                }
            }
        }
        return this;
    },
    /**
     * Nhận dữ liệu từ cha
     * @param {string} channel tên đường truyền
     * @param {function} handler 
     * @returns {DomElement}
     */
    final$onParentData: function (channel?: any, handler?: any) {
        return this.onParentTransmission(channel, handler);
    },

    /**
     * tuyền dữ liệu giữ các component con -> cha
     * @param {string} channel tên sự kiện
     * @param {*} data dữ liệu bất kỳ
     */
    final$receiveFromChildren: function (channel?: any, data?: any) {
        var self = this;
        var next = true;
        var a = 0;
        var arr, fn, s = undefined;
        this.__transmissionStatus = true;
        if (Object.hasOwnProperty.call(this.__transmissionEventListeners.fromChildren, channel)) {
            arr = this.__transmissionEventListeners.fromChildren[channel];
            if (arr.length) {
                for (var index = 0; index < arr.length; index++) {
                    fn = arr[index];
                    if (typeof fn == "function") {
                        a++;
                        s = fn.call(this, data);
                        if (s === false) {
                            next = false;
                            break;
                        }
                    }

                }
            }
        }
        if (next) {
            if (!a) {
                var c = Str.replace(
                    Str.ucword(
                        channel.split("-").join(" ")
                    ),
                    " ",
                    ""
                );

                var fnList = ["onReceive" + c + "FromChildren", "on" + c + "FromChildren", "onChildren" + c + "Data", "onReceive" + c, "onReceive" + c + "Data"];
                fnList.map(function (mt, i) {
                    if (next && typeof self[mt] == "function") {

                        var stt = self[mt].call(self, data);
                        if (stt === false) {
                            next = false
                        }
                    }
                });

            }

        }
        if (next) {
            var eventData = {
                type: "",
                preventDefault: function () {
                    next = false;
                    a++;
                },
                stopTransmission: function () {
                    next = false;
                    self.stopTransmission();
                    a++;
                },
                stopPropagation: function stopPropagation() {
                    self.stopTransmission();
                    next = false;
                    a++;
                },
                data: data
            }

            var slug = channel.toLowerCase();
            ["transmission.fromchildren." + slug, "transmission.fromchildren", "transmission"].map(function (mt) {
                if (next && Object.hasOwnProperty.call(self.__transmissionEventListeners.events, mt)) {
                    eventData.type = mt;
                    arr = self.__transmissionEventListeners.events[mt];

                    if (arr.length) {
                        for (var index = 0; index < arr.length; index++) {
                            fn = arr[index];
                            if (typeof fn == "function") {
                                // a++;
                                s = fn.call(self, eventData);
                                if (s === false || !next) {
                                    next = false;
                                    self.parent.stopTransmission();
                                    break;
                                }
                            }

                        }
                    }
                }

            });



        }
        // truyền cho các thằng con
        if (next && this.parent) {

            this.sendToParent(channel, data);
        }
        this.__transmissionStatus = true;

    },


    /**
     * tuyền dữ liệu giữ các component con -> cha
     * @param {string} channel tên sự kiện
     * @param {*} data dữ liệu bất kỳ
     */
    final$sendToParent: function (channel?: any, data?: any) {
        if (this.parent && this.parent != this && this.parent.receiveFromChildren) {
            this.parent.receiveFromChildren(channel, data);
        } else {
            console.warn("Không có đối tượng cha");
        }
        return this;
    },



    /**
     * Nhận dữ liệu từ con
     * @param {string} channel tên đường truyền
     * @param {function} handler 
     * @returns {DomElement}
     */
    final$onChildrenTransmission: function (channel?: any, handler?: any) {
        if (isString(channel) && isFunction(handler)) {
            if (typeof this.__transmissionEventListeners.fromChildren[channel] == "undefined") {
                this.__transmissionEventListeners.fromChildren[channel] = [];
            }
            this.__transmissionEventListeners.fromChildren[channel].push(handler);
        }
        if (isObject(channel)) {
            for (var s in channel) {
                if (Object.hasOwnProperty.call(channel, s)) {
                    if (typeof channel[s] == "function") {
                        this.onChildrenTransmission(s, channel[s]);
                    }
                }
            }
        }
        return this;
    },

    /**
     * Nhận dữ liệu từ con
     * @param {string} channel tên đường truyền
     * @param {function} handler 
     * @returns {DomElement}
     */
    final$onChildrenData: function (channel?: any, handler?: any) {
        return this.onChildrenTransmission(channel, handler);
    },

    /**
     * gọi phương thức của cha, ngược cây phả hệ cho đến khi có tồn tại phương thức dược định nghĩa hoặc hết cây phả hệ
     * @param {string} method tên phuong thức của thằng cha
     * @param {array} args các tham số dưới dạng mảng
     * @returns {mixed}
     */
    final$callParentMethod: function (method?: any, args?: any) {
        if (this.parent && typeof this.parent.onChildrenCallMethod == "function") {
            return this.parent.onChildrenCallMethod(method, args);
        }

        return null;

    },

    /**
     * gọi phương thức của cha, ngược cây phả hệ cho đến khi có tồn tại phương thức dược định nghĩa hoặc hết cây phả hệ
     * @param {string} method tên phuong thức của thằng cha
     * @param {array} args các tham số dưới dạng mảng
     * @returns {mixed}
     */
    final$cpm: function cpm(method?: any, args?: any) {
        return this.callParentMethod.call(this, method, args);
    },
    /**
     * gọi phương thức của cha, ngược cây phả hệ cho đến khi có tồn tại phương thức dược định nghĩa hoặc hết cây phả hệ
     * @param {string} method tên phuong thức của thằng cha
     * @param {array} args các tham số dưới dạng mảng
     * @returns {mixed}
     */
    final$parentCall: function (method?: any, args?: any) {
        return this.callParentMethod.call(this, method, args);
    },

    /**
     * gọi phương thức của cha, ngược cây phả hệ cho đến khi có tồn tại phương thức dược định nghĩa hoặc hết cây phả hệ
     * @param {string} method tên phuong thức của thằng cha
     * @param {array} args các tham số dưới dạng mảng
     * @returns {mixed}
     */
    final$callParent: function (method?: any, args?: any) {
        return this.callParentMethod.call(this, method, args);
    },

    /**
     * lsng81 nghe lời gọi hàm của thằng con
     * @param {string} method tên phương thức
     * @param {array} args tham số
     */
    final$onChildrenCallMethod: function (method?: any, args?: any) {
        if (typeof this[method] == "function") {
            var fn = this[method];
            return fn.apply(this, isArray(args) ? args : [args]);
        }
        return this.callParentMethod(method, args);
    },

    /**
     * gọi phương thức của thang con trong cây phả hệ
     * @param {string} method phương thức
     * @param {array} args tham so
     */
    final$callChildrenMethod: function (method?: any, args?: any, className?: any) {
        curremtCallChildrenMethodID = this.getInstanceID();
        return this.__callChildrenMethod__(method, args, className);
    },

    /**
     * gọi phương thức của thang con trong cây phả hệ
     * @param {string} method phương thức
     * @param {array} args tham so
     */
    final$ccm: function (method?: any, args?: any, className?: any) {
        return this.callChildrenMethod(method, args, className);
    },

    /**
     * gọi phương thức của thang con trong cây phả hệ
     * @param {string} method phương thức
     * @param {array} args tham so
     */
    final$childrenCall: function (method?: any, args?: any, className?: any) {
        return this.callChildrenMethod(method, args, className);
    },

    /**
     * gọi phương thức của thang con trong cây phả hệ
     * @param {string} method phương thức
     * @param {array} args tham so
     */
    final$callChildren: function (method?: any, args?: any, className?: any) {
        return this.callChildrenMethod(method, args, className);
    },

    /**
     * gọi phương thức của thang con trong cây phả hệ
     * @param {string} method phương thức
     * @param {array} args tham so
     */

    final$__callChildrenMethod__: function (method?: any, args?: any, className?: any) {
        var instanceId = this.getInstanceID();
        if (!curremtCallChildrenMethodID) curremtCallChildrenMethodID = instanceId;
        stopCallChildrenTask[instanceId] = false;
        var result = DEFAULT_VALUE;
        if (this.children.length) {
            for (var index = 0; index < this.children.length; index++) {
                var child = this.children[index];
                if (child && child.isDom && typeof child.onCallMethodFromParent == "function") {
                    var r = child.onCallMethodFromParent(method, args, className);
                    if (r !== DEFAULT_VALUE && typeof r != "undefined") {
                        result = r;
                        break;
                    } else if (stopCallChildrenTask[curremtCallChildrenMethodID]) {
                        result = undefined;
                        break;
                    }
                }

            }
        }
        stopCallChildrenTask[instanceId] = false;

        if (instanceId == curremtCallChildrenMethodID) {
            stopCallChildrenTask[curremtCallChildrenMethodID] = false;
            curremtCallChildrenMethodID = null;
            if (result == DEFAULT_VALUE) {
                return undefined;
            }
        }
        return result;
    },

    /**
     * lắng nghe sự kiện từ parent
     * @param {string} method phương thức 
     * @param {array} args mảng tham số
     * @param {string} className Tên claass cuối
     */
    final$onCallMethodFromParent: function (method?: any, args?: any, className?: any) {
        var self = this;
        function f() {
            if (typeof self[method] == "function") {
                var fn = self[method];
                var res = fn.apply(self, isArray(args) ? args : [args]);
                if (typeof res != "undefined") stopCallChildrenTask[curremtCallChildrenMethodID] = true;
                return res;
            }
            return DEFAULT_VALUE;

        }
        if (className) {
            return f();
        }
        var r = f();
        return r != DEFAULT_VALUE ? r : this.__callChildrenMethod__(method, args);
    },
    final$stopCallChildrenMethod: function () {
        if (curremtCallChildrenMethodID) stopCallChildrenTask[curremtCallChildrenMethodID] = true;
    },

    /**
     * gui data cho dong bon
     * @param {string} cslug chuoi key
     * @param {*} data du lieu
     */
    final$sendToSiblings: function (slug?: any, data?: any) {
        if (this.parent && this.parent.children && this.parent.children.length > 1) {
            for (var index = 0; index < this.parent.children.length; index++) {
                var sibling = this.parent.children[index];
                if (typeof sibling == "object" && sibling != this && typeof sibling.onReceiveFromSiblings == "function") {
                    var s = sibling.onReceiveFromSiblings(slug, data)
                    if (s === false) break;
                }
            }
        }
    },
    /**
     * nhan du liieu tu dong bon
     * @param {string} slug chuoi khoa
     * @param {*} data du lieu
     */
    final$onReceiveFromSiblings: function (channel?: any, data?: any) {
        var self = this;
        var next = true;
        var a = 0;
        var arr, fn, s = undefined;
        var eventData = {
            type: "",
            preventDefault: function () {
                next = false;
                a++;
            },
            stopTransmission: function () {
                next = false;
                a++;
            },
            stopPropagation: function stopPropagation() {
                next = false;
                a++;
            },
            data: data
        };

        if (Object.hasOwnProperty.call(this.__transmissionEventListeners.fromSiblings, channel)) {
            arr = this.__transmissionEventListeners.fromSiblings[channel];
            try {
                if (arr.length) {
                    for (var index = 0; index < arr.length; index++) {
                        fn = arr[index];
                        if (typeof fn == "function") {
                            a++;
                            s = fn.call(this, data);
                            if (s === false) {
                                return false;
                            }
                        }

                    }
                }

            } catch (error) {
                console.log(error);
            }
        }
        if (!a) {
            var c = Str.replace(
                Str.ucword(
                    channel.split("-").join(" ")
                ),
                " ",
                ""
            );
            var listFn = [
                "onReceive" + c + "fromSiblings",
                "onReceive" + c
            ];
            var mt = "";
            for (var i = 0; i < listFn.length; i++) {
                mt = listFn[i];
                if (typeof self[mt] == "function") {
                    var stt = self[mt].call(self, data);
                    if (stt === false) {
                        return false;
                    }
                }
            }
        }
        var slug = channel.toLowerCase();
        var mtfs = ["transmission.fromsiblings." + slug, "transmission.fromsiblings", "transmission"];
        var mt = "";
        for (var n = 0; n < mtfs.length; n++) {
            mt = mtfs[n];
            if (Object.hasOwnProperty.call(self.__transmissionEventListeners.events, mt)) {
                eventData.type = mt;
                arr = self.__transmissionEventListeners.events[mt];
                if (arr.length) {
                    for (var index = 0; index < arr.length; index++) {
                        fn = arr[index];
                        if (typeof fn == "function") {
                            // a++;
                            s = fn.call(self, eventData);
                            if (s === false || !next) {
                                return false;
                            }
                        }

                    }
                }
            }
        }
    },

    /**
     * gọi hàm của dong bọn
     * @param {string} method tên phương thưc
     * @param {*[]} args tham số
     */
    final$callSiblingMethod: function (method?: any, args?: any) {
        if (this.parent && this.parent.children && this.parent.children.length > 1) {
            var a = typeof args == "undefined" ? [] : (isArray(args) ? args : [args]);
            for (var i = 0; i < this.parent.children.length; i++) {
                var child = this.parent.children[i];
                if (isObject(child) && child != this && typeof child[method] == "function") {
                    var fn = child[method];
                    var r = fn.apply(child, a);
                    if (r !== undefined) return r;
                }
            }
        }
    },


    /**
     * gọi hàm của dong bọn
     * @param {string} method tên phương thưc
     * @param {*[]} args tham số
     */
    final$callSiblings: function (method?: any, args?: any) {
        return this.callSiblingMethod(method, args);
    },

    /**
     * gọi hàm của dong bọn
     * @param {string} method tên phương thưc
     * @param {*[]} args tham số
     */
    final$siblingCall: function (method?: any, args?: any) {
        return this.callSiblingMethod(method, args);
    },


    /**
     * gọi hàm của dong bọn
     * @param {string} method tên phương thưc
     * @param {*[]} args tham số
     */
    final$csm: function (method?: any, args?: any) {
        return this.callSiblingMethod(method, args);
    },



    getElementArgsData: function (args?: any, rules?: any) {
        // var rules = {

        // };
        var selector = '';
        var attrs: any = {};
        var data: any = [];
        var hasTag = false;
        // duyệt qua mảng tham so
        for (var index = 0; index < args.length; index++) {
            var vl = args[index];
            if (isString(vl)) {
                if (index == 0) {
                    var a: any = getDomInf(vl);
                    if (a.isElement) {
                        if (a.isDefault) {
                            selector = args[0];
                        } else {
                            selector = args[0].substr(a.tagName.length);
                        }
                    }
                }
            }
        }
    },

    /**
     * lấy về Element cha   
     * @returns {Dom}
     */
    final$getRootElement: function () {
        if (this.parent && isObject(this.parent) && this.parent.isDom) return this.parent.getRootElement();
        return this;
    },


    // dịch chuyển element trong dom
    final$moveTo: function (parent?: any, pos?: any) {
        if (!isObject(parent)) return false;
        if (_instanceof(parent, Element)) {
            parent.appendChild(this.el);
            return this;
        }
        if (!pos) pos = 'bottom';
        if (parent.isDom) {
            parent.moveIn(this, pos, this.parent);
        }
    },

    /**
     * 
     * @param {DomeElement|Element} child doi tuong con
     * @param {DomeElement|Element} receiveDomEl 
     * @param {string} pos 
     * @returns {Dom}
     */
    final$moveChild: function moveChild(child?: any, receiveDomEl?: any, pos?: any) {
        if (!isObject(receiveDomEl)) return false;

        for (var index = 0; index < this.children.length; index++) {
            var ch = this.children[index];
            if (ch == child) {
                this.children.splice(index, 1);
                if (ch.isDom) {
                    ch.parent = null;
                    ch.moveTo(receiveDomEl, pos);

                }
                else if (_instanceof(ch, Element)) {
                    if (receiveDomEl.isDom) {
                        receiveDomEl.moveIn(ch);
                    }
                }
            }

        }
        return this;
    },
    /**
     * 
     * @param {DomElement} child 
     * @param {boolean} pos 
     */
    final$moveIn: function moveIn(child?: any, pos?: any, oldparent?: any) {
        if (isObject(child)) {
            var t;
            if ((isBoolean(pos) && pos === true) || inArray(['top', 'start', 'prepend'], pos)) t = true;
            else t = false;
            var self = this;
            if (t) {
                if (child.isDom) {

                    this.children.unshift(child);
                    if (this.el.firstChild) this.el.insertBefore(child.el, this.el.firstChild);
                    else this.el.appendChild(child.el);

                    if (child.parent && child.parent.isDom) {
                        child.parent.removeChild(child, false);
                    }
                    child.parent = this;
                }
                else if (child.isDomQuery) {
                    this.el.insertBefore(child.el, this.el.firstChild);
                    this.children.unshift(child);
                }
                else if (child.isQuery) {
                    for (var index = child.length - 1; index > -1; index--) {
                        const c = child[index];
                        this.el.insertBefore(c, this.el.firstChild);
                    }
                    this.children.unshift(child);
                }
                else if (child instanceof Element) {
                    this.el.insertBefore(child, this.el.firstChild);
                    this.children.unshift(child);
                }

            } else {
                if (child.isDom) {
                    this.el.appendChild(child.el);
                    this.children.push(child);

                    if (child.parent && child.parent.isDom) {
                        child.parent.removeChild(child, false);
                    }
                    child.parent = this;

                }
                else if (child.isDomQuery) {
                    this.el.appendChild(child.el);
                    this.children.push(child);
                }
                else if (child.isQuery) {
                    child.map(function (el) {
                        self.el.appendChild(el);
                    });
                    this.children.push(child);
                }
                else if (child instanceof Element) {
                    this.el.appendChild(child);
                    this.children.push(child);
                }
            }

        }

    },
    static$toString: function () {
        var self = this;
        return self('#' + Str.rand());
    },
    static$withParent: function (parent?: any) {
        var self = this;
        if (!isObject(parent) || !parent.isDom) {
            console.error("Parent must be instance of DomElement");
            return false;
        }
        if (typeof self != "function") {
            console.error("The context of withParent Method mush be Dom or Dom's Children");
            return false;
        }
        var params = [];
        for (let i = 1; i < arguments.length; i++) {
            const arg = arguments[i];
            params.push(arg);
        }
        oneTimeData = {
            parent: parent
        };
        return self.apply(null, params);

    }
}) as DomFactory;
Dom['$doc'] = $document;
/**
 * Tạo đối tượng dom
 * @param {string|object} tag ten the hoặc tất cả các thông tin của thẻ
 */
function create(tag?: any, children?: any, attributes?: any) {
    var tagName = 'div',
        id = '',
        className = '',
        attrs: any = {},
        __dynamicAttrs: any = {},
        events: any = {},
        props: any = {},
        methods: any = {},
        contents: any = [],
        contentf = "",
        inf: any = { isElement: false },
        isSimple = false,
        isArrayContent = false,
        isTwoContent = 0,
        dataTypeAttrs: any = {},
        biddingAttrs: any = {}
        ;

    function addAttrValue(k, vl) {

        var s = String(k).toLowerCase();
        if (s.substr(0, 1) == '$') {
            __dynamicAttrs[k.substr(1)] = vl;
        }
        else if (inArray(['tag', 'tagname'], s)) {
            // tagName = vl;
        }
        else if (s.substr(0, 2) == 'on' && isDomEvent(s.substr(2))) {
            events[s.substr(2)] = vl;
        }
        else if (s.substr(0, 1) == '@' && isDomEvent(s.substr(1))) {
            events[s.substr(1)] = vl;
        }
        else if (s == "on" && isObject(vl)) {
            for (const v in vl) {
                if (Object.hasOwnProperty.call(vl, v)) {
                    const ev = vl[v];
                    events[v] = ev;
                }
            }

        }
        else if (inArray(["content", "children"], s)) {
            if (isArray(vl)) {
                for (var j = 0; j < vl.length; j++) {
                    contents.push(vl[j]);
                }
            } else {
                contents.push(vl);
            }
        }
        else if (typeof vl == "function") {
            if (vl.isPrimitive) {
                dataTypeAttrs[k] = vl;
            } else {
                methods[k] = vl;
            }
        }
        else if (isString(vl) && !isNumber(vl) && vl.substr(0, 2) == '{{' && vl.substr(vl, length - 2) == '}}') {
            biddingAttrs[k] = vl.substr(2, vl, length - 4).trim();
        }
        else if (isObject(vl) && (vl.isArrayData || vl.isObjectData)) {
            dataTypeAttrs[k] = vl;
        }
        else {
            attrs[k] = vl;
        }
    }
    if ((isObject(tag) && (tag.isQuery || tag.isDomQuery))) {
        contents.push(tag);
    }
    else if (isObject(tag) && tag.isDom) {
        contents.push(tag);
    }

    else if (isObject(tag)) {
        for (var k in tag) {
            if (tag.hasOwnProperty(k)) {
                var vl = tag[k];
                var s = String(k).toLowerCase();
                if (inArray(['tag', 'tagname'], s)) {
                    tagName = vl;
                }
                else if (inArray(["content", "children"], s)) {
                    if (isArray(vl)) {
                        for (var j = 0; j < vl.length; j++) {
                            var cnt = vl[j];
                            contents.push(cnt);
                        }
                    } else {
                        contents.push(vl);
                    }
                }
                else {
                    addAttrValue(k, vl);
                }
            }
        }
    }

    else if (isString(tag)) tagName = tag;


    for (var i = 1; i < arguments.length; i++) {
        var arg = arguments[i];
        if (isObject(arg) && (arg.isQuery || arg.isDomQuery)) {
            contents.push(arg);
        }
        else if (isObject(arg) && arg.isDom) {
            contents.push(arg);
        }
        else if (_instanceof(arg, Element)) {
            contents.push(arg);
        }
        else if (_instanceof(arg, Dom)) {
            contents.push(arg.el);
        }
        else if (isObject(arg)) {
            for (var k in arg) {
                if (arg.hasOwnProperty(k)) {
                    addAttrValue(k, arg[k]);
                }
            }

        }
        else if (isString(arg)) {
            isTwoContent = 0;
            contents.push(arg);
        } else if (isArray(arg)) {
            isArrayContent = true;
            for (var j = 0; j < arg.length; j++) {
                contents.push(arg[j]);
            }
        } else if (isFunction(arg) && arg.isDomClass) {
            contents.push(arg);
        }
    }

    inf = getDomInf(tagName);

    if (inf.isElement) {
        if (tagName != inf.tagName) {
            tagName = inf.tagName;
            isSimple = simpleTags.indexOf(tagName.toLowerCase()) >= 0;
            if (inf.id) {
                id = inf.id;
            }
            if (inf.className) {
                className = inf.className;
            }
            if (!isEmpty(inf.attrs)) {
                for (var k in inf.attrs) {
                    if (Object.hasOwnProperty.call(inf.attrs, k)) {
                        addAttrValue(k, inf.attrs[k]);
                    }
                }
            }
            if (!isEmpty(inf.props)) {
                assignValue(props, inf.props);
            }
            if (inf.content) {
                if (!isSimple) {
                    contentf = inf.content;
                }
                // else if (typeof attrs.content == "undefined") attrs.content = inf.content;
            }
        }
    }
    if (id) {
        if (typeof attrs.id == "undefined") {
            attrs.id = id;
        }
    }

    if (this && this.tagName && this.tagName != tagName && tagName == 'div') {
        tagName = this.tagName;
    }

    isSimple = simpleTags.indexOf(tagName.toLowerCase()) >= 0;
    var htmlObject = $document.createElement(tagName);
    if (!isEmpty(attrs)) {

        var csk, v;
        var css = {};
        for (var prop in attrs) {
            if (Object.prototype.hasOwnProperty.call(attrs, prop)) {
                var val = attrs[prop];
                var key = prop.toLowerCase();
                var k = key;
                var f = k.substring(0, 1);
                var f2 = k.substring(0, 2);
                var isEvent = domEvents.indexOf(key) >= 0;
                if (inArray(['tag', 'tagname'], s)) {
                    // tagName = vl;
                }
                else if (f == '$' && (isString(vl) || isNumber(vl) || getType(vl) == "boolean")) {
                    __dynamicAttrs[k.substr(1)] = vl;
                }
                else if (key == "style") {

                    if (typeof val == "object") {
                        for (var cssKey in val) {
                            if (Object.prototype.hasOwnProperty.call(val, cssKey)) {
                                v = val[cssKey];
                                css[cssKey] = v;
                            }
                        }

                        for (var ck in css) {
                            if (css.hasOwnProperty(ck)) {
                                var cv = css[ck];
                                // htmlObject.style[ck] = cv;
                                // console.log(`htmlObject.style['${ck}'] = ${cv};`)
                                setCssProp(htmlObject, ck, cv);
                            }
                        }
                    } else {
                        htmlObject.setAttribute(key, val);
                    }
                }
                else if (isObject(val)) {
                    if (val.isDom || val.isDomQuery || _instanceof(val, Element)) {
                        this._pendingContents.push({ key: key, content: val });
                    }
                    else if (val.constructor != Object) {
                        this[key] = val;
                    }
                    else {

                        var attrObj = Str.convertTextObject({}, val, prop, '-');
                        for (var ak in attrObj) {
                            if (attrObj.hasOwnProperty(ak)) {
                                var v = attrObj[ak];
                                htmlObject.setAttribute(ak, v);
                            }
                        }
                    }


                }
                else if (key == 'class' || key == 'classname') {
                    htmlObject.className = val;
                }
                else if (typeof vl == "function") {
                    methods[k] = vl;
                }
                else if (isBoolean(val)) {
                    if (val === false) {
                        htmlObject.removeAttribute(key);

                    } else {
                        htmlObject.setAttribute(key, key);
                    }
                }
                else if (key != "content" || isSimple) {
                    var slug = Str.camelToSlug(prop, '-');
                    htmlObject.setAttribute(slug, val);
                }
            }
        }
    }

    if (!isEmpty(props)) {
        for (const key in props) {
            if (Object.hasOwnProperty.call(props, key)) {
                const value = props[key];
                htmlObject[key] = value;
            }
        }
    }
    var childrenContents = [];
    if (!isSimple) {
        var cnt = null;
        var tn = tagName.toLowerCase();
        if (contents.length) {
            if (tn == 'textarea') {
                htmlObject.innerText = contents[0];
                if (contentf) {
                    htmlObject.innerText += contentf;
                }
            }
            else if (tn == 'a' && !attrs.hasOwnProperty('href') && isTwoContent == 2 && !isArrayContent && contents.length == 2) {
                attrs.href = contents[0];
                childrenContents[0] = contents[1];
            }
            else {
                childrenContents = contents.slice(0);

            }
        }
        else if (contentf) {
            if (tagName.toLowerCase() == 'textarea') {
                htmlObject.innerText += contentf;
                childrenContents = [];
            } else {
                childrenContents.unshift(parse(contentf));

            }

        }
    }
    else if (tagName == 'img') {
        if (!attrs.hasOwnProperty('src')) {
            if (contents.length) {
                htmlObject['src'] = contents[0];
            }
            else if (contentf) {
                htmlObject['src'] = contentf;
            }
        }
    }

    else if (contentf && !attrs.hasOwnProperty('content')) {
        htmlObject.setAttribute('content', contentf);
    }
    if (className) {
        className.split(" ").filter(function (str) {
            return str.length > 0;
        }).map(function (str) {
            htmlObject.classList.add(str);
        })

    }

    return {
        el: htmlObject,
        contents: childrenContents,
        __dynamicAttrs: __dynamicAttrs,
        biddingAttrs: biddingAttrs,
        dataTypeAttrs: dataTypeAttrs,
        events: events,
        methods: methods,
        tag: tagName
    };

}

/**
 * Tạo đối tượng dom
 * @param {string|object} tag ten the hoặc tất cả các thông tin của thẻ
 * @returns {Element}
 */
var createEl = function createEl(tag?: any, ...args: any[]): HTMLElement {
    var tagName = 'div',
        id = '',
        className = '',
        attrs: any = {},
        __dynamicAttrs: any = {},
        events: any = {},
        props: any = {},
        contents = [],
        contentf = "",
        inf: any = { isElement: false },
        isSimple = false,
        boot = null,
        init = null;

    /**
     * phan tich objec chưa cac thuoc tinh
     * @param {object} object doi tuong thuoc tinh
     * @param {boolean} changeTagName 
     */
    var parseAttrs = function (object = undefined, changeTagName = undefined) {
        for (var k in object) {
            if (object.hasOwnProperty(k)) {
                var vl = object[k];
                var s = String(k).toLowerCase();
                if (s.substr(0, 1) == '$') {
                    __dynamicAttrs[k.substr(1)] = vl;
                }
                else if (inArray(['tag', 'tagname'], s)) {
                    // tagName = vl;
                    if (changeTagName) {
                        tagName = vl;
                    }
                }
                else if (inArray(['init', 'boot'], s)) {
                    if (s == 'boot') boot = vl;
                    else init = vl;
                }
                else if (s.substr(0, 2) == 'on' && isDomEvent(s.substr(2))) {
                    events[s.substr(2)] = vl;
                }
                else if (s.substr(0, 1) == '@' && isDomEvent(s.substr(1))) {
                    events[s.substr(1)] = vl;
                }
                else if (inArray(["content", "content", "children"], s)) {
                    if (isArray(vl)) {
                        for (var j = 0; j < vl.length; j++) {
                            var cnt = vl[j];
                            contents.push(cnt);
                        }
                    } else {
                        contents.push(vl);
                    }
                }
                else {
                    attrs[k] = vl;
                }
            }
        }
    }

    if ((isObject(tag) && (tag.isQuery || tag.isDomQuery))) {
        contents.push(tag);
    }
    else if (isObject(tag) && tag.isDom) {
        contents.push(tag.el);
    }
    else if (isObject(tag)) {
        parseAttrs(tag, true);
    }
    else if (isString(tag)) tagName = tag;
    var max = arguments.length > 3 ? 3 : arguments.length;
    for (var i = 1; i < max; i++) {
        var arg = arguments[i];
        if (isObject(arg) && arg.isDom) {
            contents.push(arg.el);
        }
        else if (_instanceof(arg, Element)) {
            contents.push(arg);
        }
        else if (_instanceof(arg, Dom)) {
            contents.push(arg.el);
        }
        else if (isObject(arg)) {
            parseAttrs(arg);
        }
        else if (isString(arg)) {
            contents.push(arg);
        } else if (isArray(arg)) {
            for (var j = 0; j < arg.length; j++) {
                var cnt = arg[j];
                contents.push(cnt);
            }
        }
    }

    // lọc xong tất cả content va attr


    inf = getDomInf(tagName);
    if (inf.isElement) {

        if (tagName != inf.tagName) {

            tagName = inf.tagName;
            isSimple = simpleTags.indexOf(tagName.toLowerCase()) >= 0;
            if (inf.id) {
                id = inf.id;
            }
            if (inf.className) {
                className = inf.className;
            }
            if (!isEmpty(inf.attrs)) {
                parseAttrs(inf.attrs);
            }
            if (!isEmpty(inf.props)) {
                assignValue(props, inf.props);
            }
            if (inf.content) {
                if (!isSimple) {
                    contentf = inf.content;
                }
                // else if (typeof attrs.content == "undefined") attrs.content = inf.content;
            }
        }
    }
    if (id) {
        if (typeof attrs.id == "undefined") {
            attrs.id = id;
        }
    }

    isSimple = simpleTags.indexOf(tagName.toLowerCase()) >= 0;
    /**
     * 
     */
    var htmlObject = document.createElement(tagName);
    if (typeof boot == "function") boot.call(htmlObject, attrs, events);
    if (!isEmpty(attrs)) {
        var csk, v;
        var css = {};
        for (var prop in attrs) {
            if (attrs.hasOwnProperty(prop)) {
                var val = attrs[prop];
                var key = prop.toLowerCase();
                var k = key;
                var f = k.substring(0, 1);
                var f2 = k.substring(0, 2);
                var isEvent = isDomEvent(key)
                if (inArray(['tag', 'tagname'], key)) {
                    // tagName = vl;
                }
                else if (key == "style") {
                    if (typeof val == "object") {
                        for (var cssKey in val) {
                            if (val.hasOwnProperty(cssKey)) {
                                v = val[cssKey];
                                css[cssKey] = v;
                            }
                        }

                        for (var ck in css) {
                            if (css.hasOwnProperty(ck)) {
                                var cv = css[ck];
                                htmlObject.style[ck] = cv;
                            }
                        }
                    } else {
                        htmlObject.setAttribute(key, val);
                    }
                }
                else if (typeof val == 'object') {
                    if (val.isQuery || val.isDomQuery || val.isDom) {

                    } else {
                        let attrObj = Str.convertTextObject({}, val, prop, '-');
                        for (var ak in attrObj) {
                            if (attrObj.hasOwnProperty(ak)) {
                                var v = attrObj[ak];
                                htmlObject.setAttribute(ak, v);
                            }
                        }
                    }

                } else if (key == 'class' || key == 'classname') {
                    htmlObject.className = val;
                }
                else if (key != "content" || isSimple) {
                    var slug = Str.camelToSlug(prop, '-');
                    htmlObject.setAttribute(slug, val);
                }
            }
        }
    }

    if (!isSimple) {
        if (contents.length) {
            if (tagName.toLowerCase() == 'textarea') {
                htmlObject.innerText = contents[0];
                if (contentf) {
                    htmlObject.innerText += contentf;
                }
            } else {
                for (var i = 0; i < contents.length; i++) {
                    var el = contents[i];
                    if (isObject(el) && el.isDom) {
                        htmlObject.appendChild(el.el);
                    }
                    else if (el instanceof Element) {
                        htmlObject.appendChild(el);
                    }
                    else if (isObject(el) || isString(el)) {
                        var a = parse(el);
                        if (a) htmlObject.appendChild(a);
                    }
                }

            }
        }
        else if (contentf) {
            if (tagName.toLowerCase() == 'textarea') {
                htmlObject.innerText += contentf;
            } else {
                htmlObject.appendChild(parse(contentf));

            }

        }

    }
    else if (contentf && !attrs.hasOwnProperty('content')) {
        htmlObject.setAttribute('content', contentf);
        contents = [];
    }

    if (className) {
        className.split(" ").filter(function (str) {
            return str.length > 0;
        }).map(function (str) {
            htmlObject.classList.add(str);
        })

    }

    var addEv = function (ev, fn) {
        var cb = (typeof fn == "function") ? fn : function (e) {

        };
        if (htmlObject.addEventListener) {
            htmlObject.addEventListener(ev, cb);
        }
    };


    if (!isEmpty(events)) {
        for (var key in events) {
            if (Object.hasOwnProperty.call(events, key)) {
                var fn = events[key];
                addEv(key, fn);
            }
        }


    }
    if (typeof init == "function") {
        init.call(htmlObject);
    }

    return htmlObject;

}
/**
 * lấy ra đối tượng dom từ tham số đầu vào
 * @param {*} str giá trị bất kì
 * @returns {Element}
 */
function parse(str: any) {
    var div = document.createElement('div');
    if ((str instanceof Element)) return str;
    else if (typeof str == "object" && !isNull(str)) {
        if (isQuery(str)) {
            if (str.length > 0) {
                return str[0];
            } else {
                return div;
            }
        }
        else if (str instanceof Dom || str.constructor == Dom) {
            return str.el;
        }
        else if (str.isDom) {
            return str.el;
        }

        else {
            return createEl(str);
        }
    }
    div.innerHTML = isString(str) && !isNumber(str) ? String(str).trim() : str;

    // Change this to div.childNodes to support multiple top-level nodes
    return div.firstChild;
}


/**
 * gán sự kiện cho đối tượng dom
 * @param {Element} el đối tượng dom
 * @param {string} event sự kiện
 * @param {dunction} handler hàm xử lý sự kiện
 */
function addEventListener(el?: any, event?: any, handler?: any) {
    if (!(el instanceof Element) && el != document && el != window) return false;
    var cb = (typeof handler == "function") ? handler : function (e) {
        // func.call(handler, [e.target]);
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
function removeEventListener(el?: any, event?: any, callback?: any) {
    if (!(el instanceof Element) && el != document) return false;
    var cb = (typeof callback == "function") ? callback : function (e) {
        // func.call(callback, [e.target]);
    };
    if (el.removeEventListener) {
        el.removeEventListener(event, cb);
    }
}
function documentReady() {
    if (document.readyState !== 'complete') return;
    return true;

}

function isGlobalOrRoot(obj?: any) {
    return obj == global || obj == document;
}



/**
 * lấy thông tin thẻ từ chuỗi đầu vào có dạng css selector
 * @param {string} s css selector
 */
function getDomInf(s?: any) {
    var obj: any = { tagName: "", id: "", className: "", props: "", attrs: "", content: "", other: "" };
    var a = String(s).split("");
    var m = "tagName";
    // số lượng các cổng đang mở 
    var contentMode = 0;
    var attrMode = 0;

    var isDefault = false;
    var status = false;
    var fail = false;
    // lặp qua từng ký tự để tách chuỗi thông qua việc đêm các ký tự đặc biệt
    for (var i = 0; i < a.length; i++) {
        var c = a[i];
        // nếu nội dung dang được kích hoạt
        if (c == " ") {
            if (!obj.id && !obj.className && !obj.props && !obj.attrs && !obj.content) fail = true;
        }
        if (contentMode > 0) {
            if (c == "{") {
                contentMode++;
            }
            else if (c == "}") {
                contentMode--;
            }
            if (contentMode) {
                obj[m] += "" + c;
            }
            else {
                m = "other";
                obj.other += " ";
            }



        }
        // bắt đầu đọc thuộc tính có giá trị
        else if (attrMode > 0) {
            if (c == "[") {
                attrMode++;
            }
            else if (c == "]") {
                attrMode--;
            }
            if (attrMode) {
                obj[m] += "" + c;
            } else {
                m = "other";
                obj.other += " ";
            }

        }

        // bắt đầu dặc id
        else if (c == "#") {
            m = "id";
        }
        // bắt đầu dọc class
        else if (c == ".") {
            m = "className";
            obj.className += " ";
        }
        // bắt đầu đọc thuộc tính trạng thái
        else if (c == ":") {
            m = "props";
            obj.props += " ";
        }
        // bắt đầu đọc thuộc tính có giá trị
        else if (c == "[") {
            m = "attrs";
            attrMode++;
            obj.attrs += "\n";
        }
        // kết thúc việc đọc
        else if (c == "]") {
            attrMode--;
            m = "other";
            obj.other += " ";

        }
        // dọc nội dung
        else if (c == "{") {
            m = "content";
            // obj.content+= "";
            contentMode++;
        }
        // kết thúc đọc nội dung
        else if (c == "}") {
            m = "other";
            obj.other += " ";
            contentMode--;
        }
        // đang làm việc gì tiếp tục làm việc đó
        else {
            obj[m] += "" + c;
        }
    }
    var obj2: any = { tagName: "", id: "", className: "", props: {}, attrs: {}, other: "", content: '', isElement: false };
    var tagName = obj.tagName.trim();
    var id = obj.id.trim();
    var className = obj.className.trim();
    var props = obj.props.trim();
    var attrs = obj.attrs.trim();
    var content = obj.content.trim();

    if (tagName) {
        obj2.tagName = tagName;
        status = true;
    } else if (s) {
        obj2.tagName = "div";
        isDefault = true;
    }

    if (id) {
        obj2.id = id;
        status = true;
    }

    if (className) {
        obj2.className = className;
        status = true;
    }

    if (props) {
        var p = props.split(" ");
        for (var i = 0; i < p.length; i++) {
            var prop = p[i];
            obj2.props[prop] = true;
            status = true;
        }
    }
    if (attrs) {
        var p = attrs.split("\n");
        for (var i = 0; i < p.length; i++) {
            var attr = p[i].split("=");
            if (attr.length == 2) {
                status = true;
                if (inArray(['"', "'"], attr[1][0]) && inArray(['"', "'"], attr[1][attr[1].length - 1])) {
                    obj2.attrs[attr[0]] = attr[1].substr(1, attr[1].length - 2);
                }
                else {
                    obj2.attrs[attr[0]] = attr[1];
                }
            }

        }
    }

    if (content) {
        obj2.content = content;
    }

    if (!obj.id && !obj.className && !obj.props && !obj.attrs && !obj.content && fail && (tagName.split(" ").length > 1 || htmlTags.indexOf(tagName) == -1)) {
        return { tagName: "", id: "", className: "", props: {}, attrs: {}, other: "", content: '', isElement: false };
    }

    obj2.isDefault = isDefault;

    obj2.isElement = status;

    obj2.isHtmlTag = htmlTags.indexOf(obj2.tagName.toLowerCase()) !== -1;
    return obj2;

}



function make(tag?: any, attributes?: any, content?: any) {
    return Dom(tag, attributes, content);
}


function eventHandler(e?: any) {
    console.log(e.target);
}


/**
* them su kien cho element
* @param {Element} element dom element
* @param {string} event ten su kien
* @param {function} callback
* @param {string} data
* @return {boolean}
*/
function addEvent(element?: any, event?: any, callback?: any, data?: any) {
    if (!element || !event || (!(element instanceof Element) && !isGlobalOrRoot(element)) || !isString(event) || !callback || !isCallable(callback)) return false;
    event = event.toLowerCase();
    data = data || null;

    // tìm trong danh sách sự kiện có tồn tại sự kiện này chưa
    for (var i = 0; i < events.length; i++) {
        var eventData = events[i];
        // một cặp element và event là key của một bản ghi dom event
        if (eventData.element === element && eventData.event === event) {
            for (var j = 0; j < eventData.tasks.length; j++) {
                var evCallback = eventData.tasks[j];
                if (data) {
                    if (data == evCallback.data && evCallback.callback === callback) return true;
                } else if (evCallback.callback === callback) return true;
            }
            addEventListener(element, event, callback);
            events[i].tasks.push({
                callback: callback,
                data: data
            });


            return true;
        }
    }
    addEventListener(element, event, callback);
    events.push({
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
}

/**
* them su kien cho element
* @param {Element} element dom element
* @param {string} event ten su kien
* @param {function} callback
* @param {string} data
* @return {boolean}
*/
function removeEvent(element?: any, event?: any, callback?: any, data?: any) {
    // trưởng hợp không gửi element nào thì xóa tất cả
    if (!element || (!(element instanceof Element) && !isGlobalOrRoot(element)) || !isString(event)) {
        for (var i = 0; i < events.length; i++) {
            var eventData = events[i];
            if (eventData.tasks.length) {
                eventData.tasks.map(function (task) {
                    removeEventListener(eventData.element, eventData.event, task.callback);
                });
            }

        }
        events = [];

        //
        return false;
    }
    event = event ? event.toLowerCase() : null;
    data = data || null;
    // duyệt mảng để tím element và event phù hợp
    for (var i = 0; i < events.length; i++) {
        var eventData = events[i];
        if (eventData.element === element) {
            if (!event) {
                if (eventData.tasks.length) {
                    eventData.tasks.map(function (task) {
                        removeEventListener(eventData.element, eventData.event, task.callback);
                    });
                }
                events.splice(i, 1);
                i--;
            }
            else if (eventData.event === event) {
                for (var j = 0; j < eventData.tasks.length; j++) {
                    var evCallback = eventData.tasks[j];
                    if (data) {
                        if (data == evCallback.data) {
                            if (callback && isFunction(callback)) {
                                if (evCallback.callback === callback) {
                                    removeEventListener(eventData.element, eventData.event, evCallback.callback);
                                    events[i].tasks.splice(j, 1);
                                    j--;
                                }
                            }
                        }
                    } else if (callback && isFunction(callback)) {
                        if (evCallback.callback === callback) {
                            removeEventListener(eventData.element, eventData.event, evCallback.callback);
                            events[i].tasks.splice(j, 1);
                            j--;
                        }
                    } else {
                        removeEventListener(eventData.element, eventData.event, evCallback.callback);
                        events[i].tasks.splice(j, 1);
                        j--;
                    }
                }
                if (!events[i].tasks.length) {
                    // removeEventListener(eventData.element, eventData.event, eventData.handle);
                    events.splice(i, 1);
                    i--;
                }
            }
        }
    }
}

function getEvents(element?: any, event?: any, data?: any) {
    event = event || null;
    element = element || null;
    data = data || null;
    var list = [];
    if (!element && !event) return events;
    for (var i = 0; i < events.length; i++) {
        var eventData = events[i];
        if ((!element || element == eventData.element) && (!event || event == eventData.event)) {
            list.push(eventData);
        }
    }
    return list;
}

/**
* kiem tra su kien cua element
* @param {Element} element dom element
* @param {string} event ten su kien
* @param {function} callback
* @param {string} data
* @return {boolean}
*/
function hasEvent(element?: any, event?: any, callback?: any, data?: any) {
    // trưởng hợp không gửi element nào thì xóa tất cả
    if (!element || (!(element instanceof Element) && !isGlobalOrRoot(element)) || !isString(event)) {
        return false;
    }
    event = event ? event.toLowerCase() : null;
    data = data || null;
    // duyệt mảng để tím element và event phù hợp
    for (var i = 0; i < events.length; i++) {
        var eventData = events[i];
        if (eventData.element === element) {
            if (eventData.event === event) {
                for (var j = 0; j < eventData.tasks.length; j++) {
                    var evCallback = eventData.tasks[j];
                    if (data) {
                        if (data == evCallback.data) {
                            if (callback && isFunction(callback)) {
                                if (evCallback.callback === callback) {
                                    removeEventListener(eventData.element, eventData.event, evCallback.callback);
                                    events[i].tasks.splice(j, 1);
                                    j--;
                                }
                            }
                        }
                    } else if (callback && isFunction(callback)) {
                        if (evCallback.callback === callback) {
                            removeEventListener(eventData.element, eventData.event, evCallback.callback);
                            events[i].tasks.splice(j, 1);
                            j--;
                        }
                    } else {
                        removeEventListener(eventData.element, eventData.event, evCallback.callback);
                        events[i].tasks.splice(j, 1);
                        j--;
                    }
                }
                if (!events[i].tasks.length) {
                    // removeEventListener(eventData.element, eventData.event, eventData.handle);
                    events.splice(i, 1);
                    i--;
                }
            }
        }
    }
}

function triggerEvent(element?: any, event?: any, data?: any) {
    event = event || null;
    element = element || null;
    data = data || null;
    if (!element && !event) return events;
    for (var i = 0; i < events.length; i++) {
        var eventData = events[i];
        if (element == eventData.element && event == eventData.event) {
            if (eventData.tasks.length) {
                eventData.tasks.map(function (task) {
                    // removeEventListener(eventData.element, eventData.event,);
                    if (typeof task.callback == "function") {
                        task.callback.apply(eventData.element, data)
                    }
                });
            }
        }
    }
}
function getEventData(element?: any, event?: any, data?: any) {
    event = event || null;
    element = element || null;
    data = data || null;
    if (!element && !event) return null;
    for (var i = 0; i < events.length; i++) {
        var eventData = events[i];
        if ((!element || element == eventData.element) && (!event || event == eventData.event)) {
            return eventData;
        }
    }
    return null;
}

/**
 * kiểm tra xem có phải sự kiện dom hay ko
 * @param {string|string[]} eventName 
 * @returns {boolean}
 */
function isDomEvent(eventName?: any) {
    var stt = false;
    if (isArray(eventName)) eventName.map(function (e) { if (allEvents.indexOf(String(e).toLowerCase()) != -1) stt = true; });
    else if (isString(eventName) && allEvents.indexOf(eventName.toLowerCase()) != -1) stt = true;
    return stt;
};


/**
 * kiểm tra xem có phải sự kiện dom hay ko
 * @param {string|string[]} eventName 
 * @returns {boolean}
 */
function isDomBasicEvent(eventName?: any) {
    var stt = false;
    if (isArray(eventName)) eventName.map(function (e) { if (domEvents.indexOf(String(e).toLowerCase()) != -1) stt = true; });
    else if (isString(eventName) && domEvents.indexOf(eventName.toLowerCase()) != -1) stt = true;
    return stt;
};



function setCssProp(element: HTMLElement, prop: string, value: any) {
    if (element instanceof HTMLElement && isString(prop)) {
        try {
            var c = Str.slugToCamel(prop);
            var s = "element.style." + c + " = value;";
            eval(s);
        } catch (error) {
            element['style'][prop] = value;
        }
    }
}
function getCssProp(element?: any, prop?: any) {
    if (element instanceof Element && isString(prop)) {
        return typeof element['style'][prop] != "undefined" ? String(element['style'][prop]) : "";
    }
    return "";
}

function getTree(elem?: any, list?: any) {
    if (typeof elem == "undefined") return [];
    if (typeof list == "undefined" || !isArray(list)) {
        list = [];
    }
    if (elem instanceof Element) {
        var self = this;
        if (!elem.children.length) return list;
        for (var i = 0; i < elem.children.length; i++) {
            var child = elem.children[i];
            list.push(child);
            if (child.children.length) {
                list = getTree(child, list);
            }
        }
    }
    return list;
}
function getParentNodes(elem?: any, list?: any, elementStop?: any) {
    if (typeof elem == "undefined") return [];
    if (typeof list == "undefined" || !isArray(list)) {
        list = [];
    }
    if (elem instanceof Element) {
        if (!elem.parentNode || (elementStop && elementStop == elem)) return list;
        list.push(elem.parentNode);
        list = getParentNodes(elem.parentNode, list, elementStop);
    }
    return list;
}

function isQuery(obj?: any) {
    if (!isObject(obj)) return false;
    if (obj.isQuery || obj.isDomQuery) return true;
    return false;
}

function getArguments(args?: any) {
    var a = [];
    if (args && args.length) {
        for (var i = 0; i < args.length; i++) {
            const arg = args[i];
            a.push(arg);
        }
    }
    return a;
}

function isHTML(str?: any) {
    return isString(str) ? (
        /<(?=.*? .*?\/*>|br|hr|input|!--|wbr)[a-z\-_\:]+.*?>|<([a-z\-_\:]+).*?<\/\1>/i.test(str)
    ) :
        _instanceof(str, Element);
}


function checkHtmlStr(str?: any) {
    return !(str || '')
        // replace html tag with content
        .replace(/<([^>]+?)([^>]*?)>(.*?)<\/\1>/ig, '')
        // remove remaining self closing tags
        .replace(/(<([^>]+)>)/ig, '')
        // remove extra space at start and end
        .trim();
}

function emptyFunc() { }
window['Dom'] = Dom

export default Dom;

export {
    createEl, create, getDomInf, Dom, DomEl, DomFactory, inputTypes, inputTags, htmlTags, domEvents
}
