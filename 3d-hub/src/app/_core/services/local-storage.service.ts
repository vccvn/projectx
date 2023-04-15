import { Injectable } from '@angular/core';
import LocalStorageEngine from "../helpers/local-storage";
@Injectable({
    providedIn: 'root'
})
export class LocalStorageService {
    key = "__storage__service__";
    __storage__: LocalStorageEngine
    constructor() {
        this.__storage__ = new LocalStorageEngine(this.key);
     }
    /**
     * set gia tri vao storage
     * @param {string} key chuoi khoa de truy cap
     * @param {*} value gia tri
     * @returns {this}
     */
    set(key:any, value:any) {
        return this.__storage__.set(key, value);
    }
    /**
     * Lấy giá trị từ storage
     * @param {string} key chuoi khoa de truy cap
     * @returns {*}
     */
    get(key:any):any {
        return this.__storage__.get(key);
    }
    /**
     * Xóa giá trị
     * @param {string} key 
     */
    remove(key:any):boolean {
        return this.__storage__.remove(key);
    }
}
