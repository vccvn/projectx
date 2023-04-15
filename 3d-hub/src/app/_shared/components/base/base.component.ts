import { AfterViewInit, Component, EventEmitter, Input, OnDestroy, OnInit, Output } from '@angular/core';
import { AppEditorEventService } from '@app/_3D/services/app-editor-event.service';
import { getArguments, getTimeStamp, isArray, isBoolean, isCallable, isEmpty, isFunction, isNumber, isObject, isString, objectHasKey } from '@app/_core/helpers/utils';
import { EventManagerService } from '@app/_core/services/event-manager.service';
import { CallbackFunction } from '@app/_shared/shared.type';

type Listenner = (...args: any[]) => any;

/**
 * mang chua cac object bao gom service va cac event
 */
type EventContainers = Array<{
    service: EventManagerService,
    events: {
        [type: string]: [[Listenner, boolean]]
    }
}>;

export type EventEmit = {
    type?: string,
    data?: any,
    [key: string]: any
}
export type Listener = (event?: EventEmit) => any


export type OnEventListener = {
    [event: string]: (Listener | string)
}

export interface BaseComponent {
    /**
     * the method will call before instance constructor method
     * 
     */
    boot?(): void
    /**
     * the method will call before instance constructor method like as boot
     * 
     */
    onBoot?(): void

    /**
     * method will call on default ngOnInit defined in BaseComponent
     */
    initFirst?(): void
    /**
         * method will call on default ngOnInit defined in BaseComponent
         */
    initOnce?(): void

    /**
     * method will call on default ngOnInit
     */
    init?(): void
    /**
     * method alias init
     */
    onInit?(): void


    afterViewInit?(): void
    /**
     * method alias init
     */
    onAfterViewInit?(): void

    /**
     * the method will call on default ngOnDestroy defined in BaseComponent
     */
    destroy?(): void
    /**
     * alias 
     */
    onDestroy?(): void

    onChangeSubEvents?(): void


    // doAfterViewInit?(fn: CallbackFunction, time: number = 100): any
    // doAfterViewInit?(fn: CallbackFunction, args:any[], time: number = 100): any

}

@Component({
    template: ''
})
export abstract class BaseComponent implements OnInit, OnDestroy, AfterViewInit {
    [prop: string]: any

    // @Input() moduleKey: string = '';
    // @Input() eventService: EventManagerService = null;
    moduleKey: string = '';
    // @Input() eventService: EventManagerService = null;

    @Output() emitter = new EventEmitter<any>();

    eventServiceContainers: EventContainers = [];

    isFocus: boolean = false;
    isInited: boolean = false;

    subEvents: AppEditorEventService = null;

    isChangeSubEvents: boolean = false;

    __show__: boolean = true;

    __refresh_expire__: number = getTimeStamp();
    __refresh_status__: boolean = false;
    viewInited: boolean = false;


    constructor() {
        Object.defineProperty(this, "_listeners", {
            configurable: false,
            enumerable: false,
            value: {}
        });
        Object.defineProperty(this, "_dispatchedEvents", {
            configurable: false,
            enumerable: false,
            value: {}
        });
        if (typeof this.boot == "function") {
            this.boot();
        }
        if (typeof this.onBoot == "function") {
            this.onBoot();
        }
    }
    ngOnInit(): void {
        this.isFocus = true;
        this.isChangeSubEvents = false;
        // if (objectHasKey(this, 'events') && this.events && this.moduleKey) {
        if (objectHasKey(this, 'events') && this.events) {
            const sub = this.events;
            // console.log(sub);
            if (sub && sub !== this.subEvents) {
                this.subEvents = sub;
                this.deactiveEventServiceRegistered(this.subEvents);
                this.deregisterAllEventService(this.subEvents);
                this.isChangeSubEvents = true;
                if (typeof this.onChangeSubEvents == "function") {
                    this.onChangeSubEvents();
                    this.activeEventServiceRegistered(this.subEvents);
                }
            }
        }
        if (!this.isInited) {
            if (typeof this.initOnce == "function") {
                this.initOnce();
            }
            else if (typeof this.initFirst == "function") {
                this.initFirst();
            }
        }
        if (typeof this.init == "function") {
            this.init();
        }
        if (typeof this.onInit == "function") {
            this.onInit();
        }


        this.isChangeSubEvents = false;
    }
    ngOnDestroy(): void {
        //Called once, before the instance is destroyed.
        //Add 'implements OnDestroy' to the class.
        this.isFocus = false;
        if (typeof this.destroy == "function") {
            this.destroy()
        }
        if (typeof this.onDestroy == "function") {
            this.onDestroy()
        }
        if (typeof this.onChangeSubEvents == "function") {
            this.deactiveEventServiceRegistered(this.subEvents);
        }
    }

    ngAfterViewInit() {
        this.viewInited = true;
        if (typeof this.afterViewInit == "function") {
            this.afterViewInit();
        }
        if (typeof this.onAfterViewInit == "function") {
            this.onAfterViewInit();
        }
    }


    doAfterViewInit(fn: CallbackFunction, ...args: any[]) {
        if (this.viewInited) {
            var params: any[] = [];
            if (args.length >= 1) {
                for (let index = 0; index < args.length; index++) {
                    const v = args[index];
                    if (isArray(v)) {
                        params = v;
                    }
                }
            }
            return fn(...params);
        }
        var time = 100;
        if (args.length >= 1) {
            for (let index = 0; index < args.length; index++) {
                const v = args[index];
                if (isNumber(v) && v > 0) {
                    time = v;
                }
            }
        }
        return setTimeout(() => this.doAfterViewInit(fn, ...args), time);
    }

    __refresh__callback__(time: number = 100) {
        if (getTimeStamp() >= this.__refresh_expire__ && this.__refresh_status__) {
            this.__refresh_status__ = false;
            this.__show__ = true;
            if (this.cd) {
                this.cd.detectChanges();
            }
            return true;
        }
        if (time <= 0) time = 10;
        return setTimeout(() => this.__refresh__callback__(), time);
    }

    refresh(time: number = 10) {
        if (time <= 0) time = 10;
        if (!this.__refresh_status__) this.__refresh_expire__ = getTimeStamp() + time;
        else this.__refresh_expire__ += time;
        if (!this.__refresh_status__) this.__refresh_status__ = true;
        if (this.__show__) {
            if (this.cd) {
                this.cd.detectChanges();
            }
            this.__show__ = false;
        }
        this.__refresh__callback__(20);
    }
    /**
     * đang ký dịch vụ xử lý xự kiện
     * @param service dịch vụ
     * @param type sự kiện
     * @param listenner hàm xử lý
     * @param disptch gọi ngay
     */
    registerEventService(service: EventManagerService | any, type: any, listenner?: Listenner | boolean, disptch?: boolean) {
        let events: {
            [type: string]: [[Listenner, boolean]]
        } = {};
        if (isObject(type)) {
            let dp = isBoolean(listenner) ? (listenner) : disptch;
            for (const key in type) {
                if (Object.prototype.hasOwnProperty.call(type, key)) {
                    const callback = type[key];
                    if (typeof callback == "function") {
                        let k = key.split("|");


                        const d: any = k.length > 1 ? (k[1] == "dispatch" ? true : dp) : dp;
                        // service.on(k[0], callback, d);
                        events[k[0]] = [[callback, d]];
                    }
                }
            }
        } else if (isString(type) && isCallable(listenner)) {
            // service.on(type, listenner, disptch);
            events[type] = [[listenner as Listenner, disptch]];
        }

        let index = -1;

        for (let i = 0; i < this.eventServiceContainers.length; i++) {
            const container = this.eventServiceContainers[i];
            if (container.service == service) {
                index = i;
                for (const key in events) {
                    if (Object.prototype.hasOwnProperty.call(events, key)) {
                        const ev = events[key][0];
                        if (typeof container.events[key] == "undefined") {
                            container.events[key] = [ev];
                        } else {
                            container.events[key].push(ev);
                        }
                    }
                }
                break;
            }
        }
        if (index == -1) {
            this.eventServiceContainers.push({
                service: service,
                events: events
            })
        }
    }

    activeEventServiceRegistered(service: EventManagerService | any, type?: any) {
        this.eventServiceContainers.map(container => {
            if (container.service == service) {
                if (type) {
                    if (isString(type)) {
                        if (isArray(container.events[type])) {
                            container.events[type].map(listennerParams => {
                                container.service.removeEventListener(type, listennerParams[0]);
                                container.service.addEventListener(type, listennerParams[0], listennerParams[1])

                            })
                        }
                    } else if (isArray(type)) {
                        type.map((t) => {
                            if (isArray(container.events[t])) {
                                container.events[t].map(listennerParams => {
                                    container.service.removeEventListener(t, listennerParams[0]);
                                    container.service.addEventListener(t, listennerParams[0], listennerParams[1])

                                });
                            }
                        });
                    }
                } else {
                    for (const key in container.events) {
                        if (Object.prototype.hasOwnProperty.call(container.events, key)) {
                            const list = container.events[key];
                            list.map(listennerParams => {
                                container.service.removeEventListener(key, listennerParams[0]);
                                container.service.addEventListener(key, listennerParams[0], listennerParams[1])

                            });

                        }
                    }
                }
            }
        });
    }
    deactiveEventServiceRegistered(service: EventManagerService | any, type?: any) {
        this.eventServiceContainers.map(container => {
            if (container.service == service) {
                if (type) {
                    if (isString(type)) {
                        if (isArray(container.events[type])) {
                            container.events[type].map(listennerParams => {
                                container.service.removeEventListener(type, listennerParams[0]);
                                // container.service.addEventListener(type, listennerParams[0], listennerParams[1])

                            })
                        }
                    } else if (isArray(type)) {
                        type.map((t) => {
                            if (isArray(container.events[t])) {
                                container.events[t].map(listennerParams => {
                                    container.service.removeEventListener(t, listennerParams[0]);
                                    // container.service.addEventListener(t, listennerParams[0], listennerParams[1])

                                });
                            }
                        });
                    }
                } else {
                    for (const key in container.events) {
                        if (Object.prototype.hasOwnProperty.call(container.events, key)) {
                            const list = container.events[key];
                            list.map(listennerParams => {
                                container.service.removeEventListener(key, listennerParams[0]);
                                // container.service.addEventListener(key, listennerParams[0], listennerParams[1])

                            });

                        }
                    }
                }
            }
        });
    }

    deregisterEventService(service: EventManagerService | any, type?: any, listenner?: Listenner) {
        this.eventServiceContainers.map((container, index) => {
            if (container.service == service) {
                if (type) {
                    if (isString(type)) {
                        if (isArray(container.events[type])) {
                            container.events[type].map((listennerParams, i) => {
                                if (listenner) {
                                    if (listenner == listennerParams[0]) {
                                        container.service.removeEventListener(type, listennerParams[0]);
                                        container.events[type].splice(i, 1);
                                    }
                                } else {
                                    container.service.removeEventListener(type, listennerParams[0]);
                                    container.events[type].splice(i, 1);
                                }

                            })
                        }
                    } else if (isArray(type)) {
                        type.map((t) => {
                            if (isArray(container.events[t])) {
                                container.events[t].map(listennerParams => {
                                    container.service.removeEventListener(t, listennerParams[0]);
                                });
                                container.events[t].splice(0);
                                delete container.events[t];
                            }
                        });
                    }
                } else {
                    for (const key in container.events) {
                        if (Object.prototype.hasOwnProperty.call(container.events, key)) {
                            const list = container.events[key];
                            list.map(listennerParams => {
                                container.service.removeEventListener(key, listennerParams[0]);
                                // container.service.addEventListener(key, listennerParams[0], listennerParams[1])

                            });
                            container.events[key].splice(0);
                            delete container.events[key];

                        }
                    }
                    this.eventServiceContainers.splice(index, 1);
                }
            }
        });
    }
    deregisterAllEventService(service?: EventManagerService | any) {
        this.eventServiceContainers.map((container, index) => {
            if (!service || service === container.service) {
                for (const key in container.events) {
                    if (Object.prototype.hasOwnProperty.call(container.events, key)) {
                        const list = container.events[key];
                        list.map(listennerParams => {
                            container.service.removeEventListener(key, listennerParams[0]);
                        });
                        container.events[key].splice(0);
                        delete container.events[key];

                    }
                }
                this.eventServiceContainers.splice(index, 1);
            }

        });
    }


    /**
     * chuẩn hóa hàn lắng nghe sự kiện
     * @param {string|function} handler tên phương thức hoạc hàm handler
     * @returns function
     */

    protected __parseEventHandler(handler: any): (...args: any[]) => any {
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
    }

    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} handler hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} dispatch Thực thi trên tất cả các sự kiện trước đó
     * @returns this
     */
    protected __addEventListener(type: string, handler?: Listener, dispatch?: boolean) {
        var self = this;
        var listener = this.__parseEventHandler(handler);

        if (this._listeners === undefined || this._listeners === null) this._listeners = {};

        type = String(type).toLowerCase();



        // if (isDomEvent(type)) return this.addDomEvent(type, listener, DEFAULT_VALUE);
        const listeners = this._listeners;

        if (listeners[type] === undefined) {

            listeners[type] = [];

        }
        if (dispatch === true) {
            this.__handleDispatchedEvents(type, listener);
        }

        if (listeners[type].indexOf(listener) === - 1) {
            listeners[type].push(listener);
        }
        return listener;
    }

    /**
     * Kiểm tra sự kiện có tồn tại hay không
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    protected __hasEventListener(type: string, listener?: Listener): boolean {

        if (this._listeners === undefined || this._listeners === null) return false;

        const listeners = this._listeners;
        type = String(type).toLowerCase();
        return listeners[type] !== undefined && (listener ? listeners[type].indexOf(listener) !== - 1 : true);

    }

    /**
     * Xóa / Gỡ sự kiện
     * @param {string} type tên sự kiện
     * @param {function} listener hàm xử lý
     * @returns {boolean}
     */
    protected __removeEventListener(type: string, listener?: Listener): boolean {
        if (this._listeners === undefined || this._listeners === null) return false;
        type = String(type).toLowerCase();
        const listeners = this._listeners;
        const listenerArray = listeners[type];
        if (listenerArray !== undefined) {
            if (!listener) {
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
    }


    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @param {boolean} log lưu lại du lieu khi emit
     * @returns {boolean}
     */
    protected __dispatchEvent(event: (EventEmit | String), data?: any, log?: boolean): boolean {
        if (this._listeners === undefined || this._listeners === null || !event) return null;

        var e: any = {};
        if (isString(event)) {
            e.type = event;
            if (data) {
                e.data = data;
            }
            // console.log(event, data);
        } else if (isObject(event)) {
            e = event;
            if (!e.type) return false;
            if (!e.data && data) {
                e.data = data;
            }
            if (isBoolean(data) && typeof log == "undefined") {
                log = data;
            }
        }
        else {
            return false;
        }
        if (e.constructor === Object) e.type = String(e.type).toLowerCase();
        const listeners = this._listeners;
        const listenerArray = listeners[e.type];
        var s = true;
        if (!e.target) {
            e.target = this;
        }

        if (!e.stopImmediatePropagation)
            e.stopImmediatePropagation = function () {
                s = false;
            };

        if (log === true) {
            this.__addDispatchedEvent(e);
        }


        if (listenerArray !== undefined) {
            // Make a copy, in case listeners are removed while iterating.
            const array1 = listenerArray.slice(0);
            var rs: any[] = [];
            for (var i = 0, l = array1.length; i < l; i++) {
                let a = array1[i].call(this, e);
                if (!s) break;
                if (a !== undefined) {
                    rs.push(a)
                }

            }
            if (s && rs.length) {
                return rs.length == 1 && array1.length == 1 ? rs[0] : rs;
            }
            return s;
        }

    }
    /**
     * lắng nghe sự kiện
     * @param {string} type loại hoạc tên sự kiện
     * @param {function|string} listener hàm hoặc tên phương thức xử lý sự kiện
     * @param {boolean} dispatch có cần cần gọi ham voi cac su kien truoc do hay ko
     * @returns this
     */
    on(type: (OnEventListener | string), listener?: Listener | boolean, dispatch?: boolean) {
        if (isObject(type)) {
            var listeners = {};
            const events: OnEventListener = type as OnEventListener;
            var d: boolean = isBoolean(listener) ? listener as boolean : (isBoolean(dispatch) ? dispatch : false);
            for (const key in events) {
                if (Object.hasOwnProperty.call(events, key)) {
                    const fn = type[key];
                    if (isFunction(fn) || isString(fn)) {
                        const fnAdded = this.__addEventListener(key, fn, d);
                        if (fnAdded) {
                            listeners[key] = fnAdded;
                        }
                    }
                }
            }
            return listeners;
        }
        return this.__addEventListener(type as string, listener as Listener, dispatch);
    }

    off(type?: any, listener?: Listener) {
        return this.__removeEventListener(type, listener);
    }
    __addDispatchedEvent(event: EventEmit) {
        if (this._dispatchedEvents[event.type] === undefined) this._dispatchedEvents[event.type] = [];
        this._dispatchedEvents[event.type].push(event);
        // console.log(event.type, this._pendingListeners[event.type])
        return this
    }

    __handleDispatchedEvents(type: string, handler: Listener) {
        var listenerArray = this._dispatchedEvents[type];
        // console.log(type, this._pendingListeners[type], this);
        if (listenerArray !== undefined) {


            // console.log(type)
            // Make a copy, in case listeners are removed while iterating.
            const array = listenerArray.slice(0);

            for (var i = 0, l = array.length; i < l; i++) {
                // array[i].call(this, e);
                var s = handler.call(this, array[i]);
                if (s === false) {
                    return s;
                }

            }
        }
    }


    listen(event: EventEmit) {
        var a = this.__dispatchEvent(event);
        var b = true;
        if (typeof this.eventHandler == "function") {
            b = this.eventHandler(event);
        }
        if (a !== false && b !== false) {
            this.emit(event);
        }
    }


    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */
    emit(event: any, data?: any, log?: boolean): boolean {
        var e: any = {};
        if (isString(event)) {
            e.type = event;
            if (data) {
                e.data = data;
            }
            // console.log(event, data);
        } else if (isObject(event)) {
            e = event;
            if (!e.type) return false;
            if (!e.data && data) {
                e.data = data;
            }
            if (isBoolean(data) && typeof log == "undefined") {
                log = data;
            }
        }
        else {
            return false;
        }
        if (e.constructor === Object) e.type = String(e.type).toLowerCase();
        this.emitter.emit(e);
    }


}
