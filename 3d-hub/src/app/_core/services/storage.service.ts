/**
 * Stateservice sử dụng cho angular hoặc bất kỳ một core nào khác
 * @author DoanLN
 */
import { Injectable } from '@angular/core';
import { getType, inArray, isArray, isBoolean, isEmpty, isFunction, isObject, isString, newObj, objectHasKey, Str } from '../helpers/utils';

declare interface StorageEvent {
    key: string,
    value: any,
    oldValue?: any
    newValue?: any
}

/**
 * các key hệ thống mà bất kỳ một state nào muốn khai báo cũng phải né
 */
 const ignoreKeys: string[] = [
  '__data',
  '__listenners',
  '__checks',
  'constructor',
  'assign',
  'take',
  'setState',
  'setValue',
  '__checkChange',
  '__dispatchChange',
  '__keyAvailable',
  'onChange',
  'onCheck',
  'exists',
  'subcribe',
  '$'
]

const SECRET_KEY = Str.rand("BM10001");
@Injectable({
  providedIn: 'root'
})
export class StorageService {
  private __data: {[s: string]: any} = {};
  private __listenners: {[s: string]: Array<(value:any, key?:string, event?:any) => any>} = {};
  private __checks: {[s: string]: (value:any, key?:string, event?:any) => any} = {};

  [s: string]: any | ((s: string) => any);

  
  constructor() {

  }



  /**
   * khai báo state
   * @param key chuỗi tên thuộc tính
   * @param value giá trị
   * @param onChange hàm thực thi khi có thay đỗi
   * @param onCheck hàm kiểm tra trước khi thay đổi
   * @returns {any}
   */
  assign(key: any, value?: any, onChange?: (...args:any[]) => any, onCheck?:  any): any {
      if (isString(key)) {
          if (isFunction(onChange)) {
              this.onChange(key, onChange, isBoolean(onCheck)?onCheck:false);
          }
          if (isFunction(onCheck)) {
              this.onCheck(key, onCheck);
          }
          var ret: any = null;
          if (typeof this.__data[key] != "undefined") {
              ret = this.__data[key];
          }
          else {
              ret = value;
              this.setValue(key, value);
          }
          return ret;
      }
      if (isObject(key)) {
          let returnData = newObj({});
          for (const k in key) {
              if (objectHasKey(key, k)) {
                  const vl = key[k];
                  if (isObject(vl) && typeof vl.$value != "undefined") {
                      let _value = vl.$value;
                      let change = vl.$change || (typeof value == "function" ? value : (typeof onchange == "function" ? onChange : null));
                      let check = vl.$check || null;
                      returnData[k] = this.assign(k, _value, change, check);
                  }
                  else {
                      returnData[k] = this.assign(k, vl, value || onChange || null);
                  }
              }
          }
          return returnData;
      }
      return null;
  }


  /**
   * lấy ra giá trị của thuộc tính có key được truyền vào. Sau khi thực hiện hành động có thể gán lại giá trị cho thuộc tính hoặc là không!
   * @param key key truy cập thuộc tính
   * @param callback hàm xử lý
   * @returns {any}
   */
  take(key: any, callback?: (...args:any[]) => any): any {
      var self: any = this;
      if (isString(key) && objectHasKey(this.__data, key)) {
          var value = this.__data[key];
          var type = getType(value);
          var jsonValue = JSON.stringify(value);
          if (isFunction(callback)) {
              var rs: any = callback(value);
              if (typeof rs != "undefined") {
                  if (jsonValue != JSON.stringify(rs)) {
                      self[key] = rs;
                  }
              } else if (type == "object" || type == "array") {
                  this.__dispatchChange({
                      key: key,
                      value: value,
                      newValue: value,
                      oldValue: value
                  });
              }
              return this.__data[key];
          } else {
              return value;
          }
      } else if (isObject(key)) {
          var returnData = newObj();
          for (const k in key) {
              if (objectHasKey(key, k)) {
                  const fn = key[k];
                  if (objectHasKey(this.__data, k)) {
                      returnData[key] = this.take(k, fn);
                  }

              }
          }
          return returnData;
      }
      else if (isArray(key)) {
          var returnData = newObj();
          for (let k = 0; k < key.length; k++) {
              const pk = key[k];
              if (objectHasKey(this.__data, pk)) {
                  returnData[key] = this.take(k, callback);
              }
          }
          return returnData;
      }
      return null;
  }

  /**
   * thêm hoặc cập nhật state
   * @param {string|object} key tên thuov65 tính
   * @param {mixed} value giá trị
   * @param {Function} onChange hàm xử lý khi có thay đổi
   */
  setState(key: any, value?: any, onChange?: (...args:any[]) => any) {
      if (isObject(key)) {
          if (isFunction(value)) {
              for (const k in key) {
                  if (objectHasKey(key, k)) {
                      const vl = key[k];
                      this.setValue(k, vl, value);
                  }
              }
          }
          else if (isFunction(onChange)) {
              for (const k in key) {
                  if (objectHasKey(key, k)) {
                      const vl = key[k];
                      this.setValue(k, vl, onChange);
                  }
              }
          }
          else {
              for (const k in key) {
                  if (objectHasKey(key, k)) {
                      const vl = key[k];
                      this.setValue(k, vl);
                  }
              }
          }
      } else if (isString(key)) {
          if (isFunction(onChange)) {
              this.setValue(key, value, onChange);
          }
          else {
              this.setValue(key, value);
          }
      }
  }

  /**
   * thiết lập giá trị cho thuộc tính
   * @param key tên thuộc tính
   * @param value giá trị
   * @param onChange hàm xử lý thay đổi
   */
  private setValue(key: string, value: any, onChange?: (...args:any[]) => any): boolean {
      if (!this.__keyAvailable(key)) return false;
      var self: any = this;
      if (!objectHasKey(this.__data, key)) {
          if (isFunction(onChange)) {
              this.onChange(key, onChange);
          }
          Object.defineProperty(this, key, {
              enumerable: true,
              configurable: true,
              get: function () {
                  return this.__data[key]
              },
              set: function (val: any) {
                  var old = this.__data[key];
                  var s: boolean = this.__checkChange({
                      key: key,
                      value: val,
                      newValue: val,
                      oldValue: old
                  });
                  if (s) {
                      this.__data[key] = val;
                      this.__dispatchChange({
                          key: key,
                          value: val,
                          newValue: val,
                          oldValue: old
                      });
                  }
              }
          })
          this.__data[key] = value;
          this.__dispatchChange({
              key: key,
              value: value,
              newValue: value,
              oldValue: undefined
          });
      } else {
          if (isFunction(onChange)) {
              this.onChange(key, onChange);
          }
          self[key] = value;
      }
      return true;
  }

  exists(key: any): boolean {
      return (isString(key) && objectHasKey(this.__data, key))
  }

  private __keyAvailable(key: any): boolean {
      return (isString(key) && !inArray(ignoreKeys, key));
  }

  __checkChange(event: StorageEvent) {
      var s: boolean = true;
      for (const key in this.__checks) {
          if (objectHasKey(this.__checks, key)) {
              const fn = this.__checks[key];
              if (isFunction(fn) && key == event.key) {
                  let a = fn(event.value, event.key, event);
                  if (a === false) s = a;
              }
          }
      }
      return s;
  }

  private __dispatchChange(event: StorageEvent) {
      var s: number = 0;
      if(event && event.key && objectHasKey(this.__listenners, event.key)){
          const fns = this.__listenners[event.key];
          if (isArray(fns)) {
              fns.map(fn => {
                  if (isFunction(fn)) {
                      fn(event.value, event.key, event);
                      s++;

                  }
              })
          }
      }
      if(objectHasKey(this.__listenners, SECRET_KEY)){
          const fns = this.__listenners[SECRET_KEY];
          if (isArray(fns)) {
              fns.map(fn => {
                  if (isFunction(fn)) {
                      fn(event.value, event.key, event);
                      s++;
                  }
              })
          }
      }
      return s;
  }

  /**
   * 
   * @param {string|array|object} key key hoạc cụm key
   * @param callback 
   */
  onChange(key: any, callback?: (...args:any[]) => any, callIfHasValue: boolean = false) {
      if (isString(key) && isFunction(callback)) {
        if (typeof this.__listenners[key] == "undefined") {
            this.__listenners[key] = [];
        }
        this.__listenners[key].push(callback);
          if (callIfHasValue && this.exists(key)) {
              var value = this.__data[key];
              callback(value, key, {
                  key: key,
                  value: value,
                  newValue: value,
                  oldValue: undefined
              })
          }
      }
      else if (isObject(key)) {
          for (const k in key) {
              if (objectHasKey(key, k)) {
                  const cb = key[k];
                  if (isFunction(cb)) {
                      this.onChange(k, cb, callIfHasValue);
                  }
              }
          }
      }
      else if (isArray(key) && key.length && isFunction(callback)) {
          for (let i = 0; i < key.length; i++) {
              const k = key[i];
              this.onChange(k, callback, callIfHasValue);
          }
      }else if(isFunction(key)){
          this.onChange(SECRET_KEY, key);
      }
  }

  subcribe(key:any, callback?:(...args:any[])=>any, callIfHasValue: boolean = false):any{
      return this.onChange(key, callback, callIfHasValue);
  }

  unsubcribe(key: string, callback?:(...args: any[]) => any){
    if (typeof this.__listenners[key] == "undefined") {
        return true;
    }
    if(this.__listenners[key].length){
        this.__listenners[key].map((cb, i) => (!isFunction(callback) || callback == cb) && this.__listenners[key].splice(i, 1));
    }
    
  }

  /**
   * kiem tra gia tri truoc khi thay doi
   * @param key key truy cap
   * @param callback ham kiem tra
   */
  onCheck(key: any, callback: any = undefined) {
      if (isString(key) && isFunction(callback)) {
          this.__checks[key] = callback;
      }
      else if (isObject(key)) {
          for (const k in key) {
              if (objectHasKey(key, k)) {
                  const cb = key[k];
                  if (isFunction(cb)) {
                      this.onCheck(k, cb);
                  }
              }
          }
      }
      else if (isArray(key) && key.length && isFunction(callback)) {
          for (let i = 0; i < key.length; i++) {
              const k = key[i];
              this.onCheck(k, callback);
          }
      }
  }

}
