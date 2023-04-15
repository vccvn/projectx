import { date, getArguments, isBoolean, isFunction, isObject, isString, Str } from '@app/_core/helpers/utils';

const DEFAULT_VALUE = Str.rand(Str.rand(date('ms')));


type EventEmit = {
    type: string,
    data?:any,
    [key:string]:any 
}
type Listener = (event?:EventEmit)=>any


type OnEventListener = {
    [event:string]: (Listener | string)
}


export interface EventDispatcherInstance {
    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} dispatch Thực thi trên tất cả các sự kiện trước đó
     * @returns this
     */
    addEventListener (type:string, handler?:Listener, dispatch?:boolean) : Listener

    /**
     * Kiểm tra sự kiện có tồn tại hay không
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    hasEventListener (type:string, listener?:Listener): boolean

    /**
     * Xóa / Gỡ sự kiện
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    removeEventListener(type:string, listener?:Listener): boolean


    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    dispatchEvent (event:(EventEmit | String), data?:any):boolean 
    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} passed tham số báo có cần kiểm tra hay ko
     * @returns this
     */
    on(type:(OnEventListener|string), listener?:Listener|string|boolean, dispatch?:boolean) : this
    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} passed tham số báo có cần kiểm tra hay ko
     * @returns this
     */
    subcribe(type:(OnEventListener|string), listener?:Listener, dispatch?:boolean): this

    off(type?:any, listener?:Listener):this

    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    emit(event:(EventEmit | String), data?:any): boolean

    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    trigger(event:(EventEmit | String), data?:any): boolean
}

export const EventDispatcher = {

    $_listeners: null,
    $_dispatchedEvents: null,
    boots: ['setDefaultEventOptions'],
    setDefaultEventOptions: function(){
        this._listeners = {};
        this._dispatchedEvents = {};
    },
    

    /**
     * chuẩn hóa hàn lắng nghe sự kiện
     * @param {string|function} handler tên phương thức hoạc hàm handler
     * @returns function
     */

     parseEventHandler(handler:any):Listener{
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
     * @param {boolean} dispatch Thực thi trên tất cả các sự kiện trước đó
     * @returns this
     */
     addEventListener (type:string, handler:any, dispatch?:any) {
        var self = this;
        var listener = this.parseEventHandler(handler);
        
        if (this._listeners === undefined || this._listeners === null) this._listeners = {};

        type = String(type).toLowerCase();



        // if (isDomEvent(type)) return this.addDomEvent(type, listener, DEFAULT_VALUE);
        const listeners = this._listeners;

        if (listeners[type] === undefined) {

            listeners[type] = [];

        }
        if(dispatch === true){
            this.handleDispatchedEvents(type, listener);
        }
        
        if (listeners[type].indexOf(listener) === - 1) {
            listeners[type].push(listener);
        }
        return listener;
    },

    /**
     * Kiểm tra sự kiện có tồn tại hay không
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    hasEventListener (type:string, listener:any = undefined): boolean {

        if (this._listeners === undefined || this._listeners === null) return false;

        const listeners = this._listeners;
        type = String(type).toLowerCase();
        return listeners[type] !== undefined && (listener?listeners[type].indexOf(listener) !== - 1:true);

    },

    /**
     * Xóa / Gỡ sự kiện
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    removeEventListener(type:string, listener:any = undefined): boolean {

        if (this._listeners === undefined || this._listeners === null) return false;
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

                return true;
            }

        }
        return false;


    },


    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    dispatchEvent (event:any, data:any=undefined):boolean {
        if (this._listeners === undefined || this._listeners === null || !event) return null;
        var e:any = {};
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

        this.addDispatchedEvent(e);

        if (listenerArray !== undefined) {
            // Make a copy, in case listeners are removed while iterating.
            const array = listenerArray.slice(0);

            for (var i = 0, l = array.length; i < l; i++) {
                array[i].call(this, e);
                if (!s) break;

            }
            return s;
        }
        
    },
    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} passed tham số báo có cần kiểm tra hay ko
     * @returns this
     */
    on(type:any, listener?:any, dispatch?:any){
        if(isObject(type)){
            var listeners = {};
            var d = isBoolean(listener)?listener:dispatch;
            for (const key in type) {
                if (Object.hasOwnProperty.call(type, key)) {
                    const fn = type[key];
                    if(isFunction(fn) || isString(fn)){
                        const fnAdded = this.addEventListener(key, fn, d);
                        if(fnAdded){
                            listeners[type]=fnAdded;
                        }
                    }
                }
            }
            return listeners;
        }
        return this.addEventListener(type, listener, dispatch);
    },

    off(type:any=undefined, listener:any=undefined){
        if(isObject(type)){
            for (const key in type) {
                if (Object.prototype.hasOwnProperty.call(type, key)) {
                    const l = type[key];
                    this.removeEventListener(key, l);
                }
            }
            return true;
        }
        return this.removeEventListener(type, listener);
    },
    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    emit(event:any=undefined, data:any=undefined): boolean{
        return this.dispatchEvent.apply(this, getArguments(arguments));
    },
    
    addDispatchedEvent(event:any=undefined){
        if(this._dispatchedEvents[event.type] === undefined) this._dispatchedEvents[event.type] = [];
        this._dispatchedEvents[event.type].push(event);
        // console.log(event.type, this._pendingListeners[event.type])
        return this
    },

    handleDispatchedEvents(type:string, handler:(...args:any[]) => any){
        var listenerArray = this._dispatchedEvents[type];
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
