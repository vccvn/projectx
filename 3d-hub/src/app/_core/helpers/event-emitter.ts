
import { assignValue, date, getArguments, isFunction, isObject, isString, newObj, Str } from "@app/_core/helpers/utils";


const DEFAULT_VALUE = Str.rand(Str.rand(date('ms')));

export const EventEmitter = {

    $_listeners: null,
    $_pendingListeners: null,
    boots: ['setDefaultEventOptions'],
    setDefaultEventOptions: function(){
        this._listeners = {};
        this._pendingListeners = {};
    },
    /**
     * lấy về một callback đến hàm hiện tại
     * @param {string} method tên phương thức
     * @returns {function(Event)}
     */
    const$getTreeMethod: function getTreeMethod(method) {
        var self = this;
        if (!isString(method)) return function (e) { console.log(e) };
        var args = getArguments(arguments);
        if (typeof self[method] != "function") {
            return null;
        }

        var fn = self[method];
        return function (e) {
            // e.component = this;
            args[0] = e;
            return fn.apply(self, args);
        };
    },

    /**
     * chuẩn hóa hàn lắng nghe sự kiện
     * @param {string|function} handler tên phương thức hoạc hàm handler
     * @returns function
     */

    parseEventHandler: function (handler) {
        var self = this;
        if (typeof handler == "function") {
            return handler;
        }
        var fnt = handler ? handler : function (e) {
            console.log(e);
        };

        if (typeof handler == "string") {
            var params = [];
            var handleParams = handler.split(":");
            if (handleParams.length == 2) {
                handler = handleParams[0];
                params = handleParams[1].split(",").map(function (s) { return s.trim(); });

            }

            fnt = function (e) {
                var args = [e];
                params.map(function (p) { args.push(p); });
                
                if (typeof self[handler] == "function") {
                    return self[handler].apply(self, args);
                }
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
     addEventListener: function (type, handler, passed) {
        var self = this;
        var listener = passed === DEFAULT_VALUE ? handler : this.parseEventHandler(handler);
        
        if (this._listeners === undefined || this._listeners === null) this._listeners = {};

        type = String(type).toLowerCase();



        // if (isDomEvent(type)) return this.addDomEvent(type, listener, DEFAULT_VALUE);
        const listeners = this._listeners;

        if (listeners[type] === undefined) {

            listeners[type] = [];

        }
        
        if (listeners[type].indexOf(listener) === - 1) {

            listeners[type].push(listener);
            
            this.callPendingEvent(type, listener);

        }
        return listener;
    },

    /**
     * Kiểm tra sự kiện có tồn tại hay không
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    hasEventListener: function (type, listener) {

        if (this._listeners === undefined || this._listeners === null) return false;

        const listeners = this._listeners;
        type = String(type).toLowerCase();
        return listeners[type] !== undefined && (listener?listeners[type].indexOf(listener) !== - 1:true);

    },

    /**
     * Xóa / Gỡ sự kiện
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {this}
     */
    removeEventListener: function (type, listener) {

        if (this._listeners === undefined || this._listeners === null) return;
        type = String(type).toLowerCase();
        const listeners = this._listeners;
        const listenerArray = listeners[type];

        if (listenerArray !== undefined) {
            if(!listener){
                this._listeners[type].splice(0, this._listeners[type].length);
                return true;
            }

            const index = listenerArray.indexOf(listener);

            if (index !== - 1) {

                listenerArray.splice(index, 1);

            }

        }

    },


    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @param {boolean} pending hàng đợi
     * @returns {boolean}
     */
    dispatchEvent: function (event, data, pending) {
        if (this._listeners === undefined || this._listeners === null || !event) return null;
        var e = newObj({});
        if(isString(event)){
            e.type = event;
            if(data){
                e.data = data;
            }
            // console.log(event, data);
        }else if(isObject(event)){
            if(!event.type) return false;
            e = event;
            if(!e.data && data){
                e.data = data;
            }
        }
        else{
            return false;
        }

        // if (isDomEvent(event.type)) return this.trigger.apply(this, getArguments(arguments));
        const listeners = this._listeners;
        const listenerArray = listeners[e.type];
        var s = true;
        if(!e.target){
            e.target = this;
        }

        e.stopImmediatePropagation = function () {
            s = false;
        }
        if (listenerArray !== undefined) {
            // Make a copy, in case listeners are removed while iterating.
            const array = listenerArray.slice(0);

            for (var i = 0, l = array.length; i < l; i++) {
                array[i].call(this, e);
                if (!s) break;

            }
            return s;
        }
        else if(pending){
            this.dispatchPendingEvent(e);
        }
    },
    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} passed tham số báo có cần kiểm tra hay ko
     * @returns this
     */
    on: function on(type, listener){
        if(isObject(type)){
            var listeners = {};
            for (const key in type) {
                if (Object.hasOwnProperty.call(type, key)) {
                    const fn = type[key];
                    if(isFunction(fn) || isString(fn)){
                        const fnAdded = this.addEventListener(key, fn);
                        if(fnAdded){
                            listeners[type]=fnAdded;
                        }
                    }
                }
            }
            return listeners;
        }
        return this.addEventListener(type, listener);
    },
    off: function off(type, listener){
        return this.removeEventListener(type, listener);
    },
    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    trigger: function trigger(event, data, pending){
        return this.dispatchEvent.apply(this, getArguments(arguments));
    },
    dispatchPendingEvent: function(event){
        if(this._pendingListeners[event.type] === undefined) this._pendingListeners[event.type] = [];
        this._pendingListeners[event.type].push(event);
        // console.log(event.type, this._pendingListeners[event.type])
        return this
    },

    callPendingEvent: function(type, handler){
        var listenerArray = this._pendingListeners[type];
        // console.log(type, this._pendingListeners[type], this);
        if (listenerArray !== undefined) {
            
        
            // console.log(type)
            // Make a copy, in case listeners are removed while iterating.
            const array = listenerArray.slice(0);

            for (var i = 0, l = array.length; i < l; i++) {
                // array[i].call(this, e);
                var s = handler.call(this, array[i]);
                if(s === false){
                    return s;
                }

            }
        }
    }


    

}

