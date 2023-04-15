
// localStorage

import { EventEmit, EventManager } from "./event-manager";
import { date, getArguments, inArray, isArray, isBoolean, isEmpty, isFunction, isObject, isString, Str } from "./utils";
const DEFAULT_VALUE = Str.rand(Str.rand(date('ms')));
var ignoreKeys = ['__data', '__namespace', '__version', '_listeners', '_dispatchedEvents'];

class LocalStorageEngine extends EventManager {
    __namespace: string = "__crushjs__";
    __verison = "1.0";
    __data: any = {};

    constructor(namespace: string, data?: any, verison?: any) {
        super();
        if (!namespace) throw new Error("param 0: Namespace is required");
        this.__namespace = namespace ? namespace : "__crushjs__";
        this.__verison = verison ? verison : "1.0";
        this.__data = isObject(data) ? data : {};
        this.__init();
    }

    __init() {
        var data = this.__getNamespaceData();
        if (data) {
            this.__data = data;
            for (var key in data) {
                if (Object.hasOwnProperty.call(data, key)) {
                    this.__addAccessors(key);
                }
            }
        } else {
            if (!isEmpty(this.__data)) {
                for (var key in this.__data) {
                    if (Object.hasOwnProperty.call(this.__data, key)) {
                        this.__addAccessors(key);
                    }
                }
            }
            this.__setNamespaceData(this.__data);
        }

        
    }

    __addAccessors(key): void {
        Object.defineProperty(this, key, {
            configurable: true,
            enumerable: true,
            set: function (val) {
                this.set(key, val);
            },
            get: function () {
                return this.get(key);
            }
        })
    }


    set(key: string, value: any) {
        var old = this.__data[key];
        if (!inArray(ignoreKeys, key) && Str.objectKey(key) == key && (typeof this.__data[key] == "undefined" || !Object.prototype.hasOwnProperty.call(this.__data, key))) {
            this.__addAccessors(key);
        }
        this.__data[key] = value;
        this.__updateNamespaceData();
        this.dispatchEvent({
            key: key + ".set",
            value: value,
            old: old
        });
        this.dispatchEvent({
            key: key,
            value: value,
            old: old
        })
    }

    get(key: string, defaultValue?: any): any {
        var value = typeof this.__data[key] !== "undefined" ? this.__data[key] : defaultValue;
        this.dispatchEvent({
            key: key + ".get",
            value: value
        })
        return value;
    }

    remove(key: string): boolean {
        var value = typeof this.__data[key] !== "undefined" ? this.__data[key] : undefined;
        if (value !== undefined) {
            this.__data[key] = undefined;
            delete this.__data[key];
            this.__updateNamespaceData();
            this.dispatchEvent({
                key: key + ".remove",
                value: value
            })
            return true;
        }
        return false;
    }
    /**
     * set gia tri vao storage
     * @param {*} value gia tri
     * @returns {this}
     */
    __setNamespaceData(value: any) {
        if (!this.__support()) return false;
        if (isObject(value) || isArray(value)) {
            value = JSON.stringify(value);
        }
        localStorage.setItem(this.__namespace, value);
        return true;
    }

    __updateNamespaceData(): void {
        localStorage.setItem(this.__namespace, JSON.stringify(this.__data));
    }

    /**
     * Lấy giá trị từ storage
     * @param {string} key chuoi khoa de truy cap
     * @returns {*}
     */
    __getNamespaceData(): any {
        if (!this.__support()) return null;
        var val = localStorage.getItem(this.__namespace);
        if (val) {
            try {
                val = JSON.parse(val);
            } catch (error) {

            }
        }
        return val;
    }

    /**
     * Xóa giá trị
     * @param {string} key 
     */
    __removeNamespace(): boolean {
        if (!this.__support()) return false;
        // this.removeInObjectList(key);

        localStorage.removeItem(this.__namespace);
        return true;
    }

    /**
     * kiểm tra trình duyệt có hỗ trợ hay ko
     */
    __support(): boolean {

        if (typeof (Storage) !== "undefined") {
            return true;
        }
        return false;
    }


    /**
     * Tạo, gọi ra một sự kiện
     * @param {string|object} event Tên hoặc sự kiện
     * @param {*} data dữ liệu
     * @returns {boolean}
     */

    dispatchEvent(event: (EventEmit | String), value?: any, log?: boolean): boolean {
        if (this._listeners === undefined || this._listeners === null || !event) return null;

        var e: any = {};
        if (isString(event)) {
            e.key = event;
            if (value!=undefined) {
                e.value = value;
            }
            // console.log(event, data);
        } else if (isObject(event)) {
            e = event;
            if (!e.key) return false;
            if (!e.data && value) {
                e.value = value;
            }
            if (isBoolean(value) && typeof log == "undefined") {
                log = value;
            }
        }
        else {
            return false;
        }

        const listeners = this._listeners;
        const listenerArray = listeners[e.value];
        var s = true;
        if (!e.target) {
            e.target = this;
        }

        if (!e.stopImmediatePropagation)
            e.stopImmediatePropagation = function () {
                s = false;
            };

        if (log !== false) {
            this.addDispatchedEvent(e);
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
}

for (var key in LocalStorageEngine.prototype) {
    if (Object.hasOwnProperty.call(LocalStorageEngine.prototype, key)) {
        ignoreKeys.push(LocalStorageEngine.prototype[key]);
    }
}
const LS = new LocalStorageEngine('crushjs', {}, "1.0");

export default LocalStorageEngine;
export { LS, LocalStorageEngine };