import { Injectable } from '@angular/core';
import LocalDB, { DbTableColumns, DbTableRow } from '../helpers/local-db';
import { isEmpty } from '../helpers/utils';
import { LocalStorageService } from './local-storage.service';
import { LostDbService } from './lost-db.service';

@Injectable({
    providedIn: 'root'
})
export class LostDbTableService {

    name: string = 'test';
    dbname: string = '__LOSTDB__';
    columns: DbTableColumns = {};
    database: LostDbService;

    primaryKey: string = "id";
    constructor(private service: LostDbService) {
        if (service) {
            this.database = service;
        }

    }
    init() {
        if (isEmpty(this.columns)) {
            throw new Error("column is not config");

        }
        if (!this.database) {
            this.database = new LostDbService(new LocalStorageService);
        }
        this.database.useDatabase(this.dbname);

        this.database.createIfNotExists(this.name, this.columns);
        if (this.primaryKey == "id") {
            for (const col in this.columns) {
                if (Object.prototype.hasOwnProperty.call(this.columns, col)) {
                    const cfg = this.columns[col];
                    if (cfg.autoIncrement) {
                        this.primaryKey = cfg.name || col
                    }
                }
            }
        }

    }

    hasMany(table: string, foreinKey: string, localKey: string = 'id') {

        return (row: DbTableRow) => {

        }
    }
    addColumn(name: string, config?: any) {
        return this.database.addColumn(this.name, name, config);
    }
    modifyTable(columns?: any) {
        return this.database.modifyTable(this.name, columns);
    }
    dropColumn(...args: any[]) {
        return this.database.dropColumn(this.name, ...args);
    }
    /**
     * Thêm dữ liệu vào bảng
     * @param data dữ liệu của một bản ghi
     * @returns 
     */
    insert(data) {
        return this.database.insert(this.name, data);
    }
    /**
     * Thêm dữ liệu vào bảng
     * @param data dữ liệu của một bản ghi
     * @returns 
     */
    add(data) {
        return this.database.insert(this.name, data);
    }
    /**
     * cập nhật bảng
     * @param data dữ liệu của một bản ghi
     * @param condition diều kiện
     * @returns 
     */
    update(data, condition?: any) {
        return this.database.update(this.name, data, condition);
    }
    /**
     * lấy tất cã dữ liệu trong bảng
     * @param condition diều kiện
     * @param select
     * @returns 
     */
    getAll(condition?: any, select?: any): DbTableRow[] {
        return this.database.select(this.name, select, condition);
    }
    /**
     * lấy tất cã dữ liệu trong bảng
     * @param condition diều kiện
     * @param select các cột cần lấy
     * @param orderBy kiểu sắp sếp
     * @param limit Giới hạn
     * @returns 
     */
    get(condition?: any, select?: any, orderBy?: any, limit?: any): DbTableRow[] {
        return this.database.select(this.name, select, condition, orderBy, limit);
    }
    /**
     * lấy tất cã dữ liệu trong bảng
     * @param condition diều kiện
     * @param select các cột cần lấy
     * @param orderBy kiểu sắp sếp
     * @param limit Giới hạn
     * @returns 
     */
    select(columns?: any, condition?: any, orderBy?: any, limit?: any): DbTableRow[] {
        return this.database.select(this.name, columns, condition, orderBy, limit);
    }
    /**
     * lấy Một bản ghi trong bảng
     * @param condition diều kiện
     * @param select các cột cần lấy
     * @param orderBy kiểu sắp sếp
     * @returns 
     */
    getOne(columns?: any, condition?: any, orderBy?: any): DbTableRow {
        let rs = this.database.select(this.name, columns, condition, orderBy);
        return rs.length == 1 ? rs[0] : null;
    }
    /**
     * lấy Một bản ghi trong bảng
     * @param condition diều kiện
     * @param select các cột cần lấy
     * @param orderBy kiểu sắp sếp
     * @returns 
     */
    first(columns?: any, condition?: any, orderBy?: any): DbTableRow {
        let rs = this.database.select(this.name, columns, condition, orderBy);
        return rs.length == 1 ? rs[0] : null;
    }
    /**
     * lấy Một bản ghi trong bảng
     * @returns 
     */
    find(id: any): DbTableRow {
        var params: any = {};
        params[this.primaryKey] = id;
        return this.first('*', params);
    }
    get lastInsertID(): number {
        return this.database.getLastInsertID(this.name);
    }
    get lastInsertItem(): DbTableRow {
        let lii = this.lastInsertID;
        if (lii > 0) {
            let params: any = {};
            params[this.primaryKey] = lii;
            return this.first('*', params);
        }
        return null;
    }
}
