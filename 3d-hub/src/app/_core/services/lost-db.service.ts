/**
 * author Doan Le
 */
import { Injectable } from '@angular/core';
import { Database, DbTableRow, defaultTypeValues } from '../helpers/local-db';
import { checkType, getType, inArray, isObject, isString, isEmpty, isNumber, isBoolean, assignValue, isFunction, isInteger, isArray, Str, objectHasKey } from '../helpers/utils';
import { LocalStorageService } from './local-storage.service';

@Injectable({
    providedIn: 'root'
})
export class LostDbService {
    key = '__LOSTDB__';
    db: Database = null;
    taskCount: number = 0;
    constructor(private storage: LocalStorageService) {
        this.useDatabase(this.key);

    }
    open(){
        if(this.taskCount == 0){
            this.db = this.storage.get(this.key);
            if (!this.db) {
                this.storage.set(this.key, {
                    version: 1.0,
                    tables: {}
                })
                this.db = this.storage.get(this.key);
            }
        }
        this.taskCount++;
    }
    close(){
        if(this.taskCount > 0){
            this.taskCount--;
            if(this.taskCount==0){
                this.db = null;
            }
        }
    }
    useDatabase(dbname: string) {
        this.key = dbname;
    }
    getDB() {
        return this.db;
    }

    isTableExists(tableName: string) {
        this.open();
        let exists = Object.prototype.hasOwnProperty.call(this.db.tables, tableName);
        this.close();
        return exists;
    }

    getTable(tableName) {
        this.open();
        var tables = this.db.tables;
        let tb = Object.prototype.hasOwnProperty.call(tables, tableName) ? tables[tableName] : null;
        this.close();
        return tb;
    }

    updateTable(tableName, data: any) {
        this.open();
        var table = this.getTable(tableName);
        if (!table) {
            this.close();
            return false;
        }
        table.data = data;
        this.db.tables[tableName] = table;
        this.storage.set(this.key, this.db);
        this.close();
    }
    /**
     * 
     * @param {string} name tên cộ
     * @param {string} type loại dự liệu
     * @param {*} defaultValue gia tri mac dinh
     * @param {booluan} autoIncrement 
     * @returns {{name, type, defaultValue, autoIncrement}}
     */
    parseColumn(name, type?, length?, required?, defaultValue?, autoIncrement?): any {
        var t = String(type).toLowerCase();
        if (t == "text") t = "string";

        if (!defaultTypeValues.hasOwnProperty(t) || !isString(name) || String(name).length == 0) {
            return null;
        }
        return {
            name: name,
            type: t,
            length: length,
            required: isBoolean(required) ? required : false,
            defVal: typeof defaultValue !== "undefined" ? defaultValue : defaultTypeValues[t],
            autoIncrement: isBoolean(autoIncrement) ? autoIncrement : false
        };
    }


    /**
     * chuẩn hóa tất cả các cột
     * @param {array|object} columns các cột
     * @param {boolean} isA isArray
     * @param {boolean} isO isObject
     * @returns {object}
     */
    parseColumns(config): any {
        let cfg: any = {};
        let defTypeVals = {
            boolean: false,
            number: 0,
            object: {},
            array: [],
            string: ''
        }
        for (const key in config) {
            if (Object.prototype.hasOwnProperty.call(config, key)) {
                const type = config[key];
                let ty = getType(type);
                if (ty == "object" && type.type) {
                    let t = String(type.type).toLowerCase();
                    if (inArray(['boolean', 'object', 'number', 'array', "string"], t)) {
                        cfg[key] = {
                            type: t,
                            length: isNumber(type.length) && type.length > 0 ? type.length : null,
                            required: isBoolean(type.required) ? type.required : false,
                            defval: typeof type['default'] != "undefined" && getType(type['default']) == t ? type['default'] : (typeof type['defVal'] != "undefined" && getType(type['defValt']) == t ? type['defVal'] : defTypeVals[t]),
                            autoIncrement: isBoolean(type.autoIncrement) ? type.autoIncrement : false
                        }
                    } else {
                        cfg[key] = {
                            type: ty,
                            length: null,
                            required: false,
                            defVal: type,
                            autoIncrement: false
                        }
                    }
                }
                else if (inArray(['boolean', 'object', 'number', 'array'], ty)) {
                    cfg[key] = {
                        type: ty,
                        length: null,
                        required: false,
                        defVal: type,
                        autoIncrement: false
                    }
                }
                else if (ty == "string") {
                    let t = String(type).toLowerCase();
                    if (inArray(['boolean', 'object', 'number', 'array', "string"], t)) {
                        cfg[key] = {
                            type: t,
                            length: null,
                            required: false,
                            autoIncrement: false,
                            defval: defTypeVals[t]
                        }
                    } else {
                        cfg[key] = {
                            type: ty,
                            length: null,
                            required: false,
                            autoIncrement: false,
                            defVal: type
                        }
                    }

                }
            }
        }
        return cfg;
    }

    createIfNotExists(name: string, config: any) {
        this.open();
        var stt = false;
        if (!this.isTableExists(name) && isObject(config)) {
            let cfg = this.parseColumns(config);
            if (!isEmpty(cfg)) {

                this.db.tables[name] = {
                    name: name,
                    config: cfg,
                    data: [],
                    autoIncrement: 0
                }
                this.storage.set(this.key, this.db);

                stt = true;
            }
        }
        this.close()
        return stt;
    }

    /**
     * sửa bảng
     * @param {string} tableName tên bảng
     * @param {array|object} columns các cột
     * @returns {boolean}
     */
    modifyTable(tableName, columns) {

        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName)) {
            this.close();
            return false;
        }
        const table = this.db.tables[tableName];

        var columns = this.parseColumns(columns);

        if (!isEmpty(columns)) {
            for (var key in columns) {
                if (Object.hasOwnProperty.call(columns, key)) {
                    var cfg = columns[key];
                    table.config[key] = cfg;
                }
            }
            if (table.data.length) {
                for (var i = 0; i < table.data.length; i++) {
                    var row = table.data.length[i];
                    for (var key in columns) {
                        if (Object.hasOwnProperty.call(columns, key)) {
                            var cfg = columns[key];
                            if (Object.hasOwnProperty.call(row, key)) {
                                var t = getType(row[key]);
                                if (t != cfg.type) {
                                    if (t == "number" && cfg.type == "string") {
                                        row[key] = String(row[key]);
                                    } else if (t == "string" && cfg.type == "number") {
                                        var a = Number(row[key]);
                                        row[key] = !isNaN(a) ? a : cfg.defaultValue;
                                    } else if (cfg.type == "boolean" && t == "number") {
                                        row[key] = row[key] > 0;
                                    } else if (cfg.type == "array") {
                                        row[key] = [row[key]];
                                    }
                                    else if (cfg.type == "object") {
                                        row[key] = Object.create(row[key]);
                                    }
                                    else {
                                        row[key] = cfg.defVal;
                                    }
                                }
                            } else {
                                row[key] = cfg.defVal;
                            }
                        }
                    }
                }
            }
            // this.database.tables[tableName] = table;
            this.storage.set(this.key, this.db);
            this.close();
            return true;
        }
        this.close();
        return false;
    }
    dropTable(tableName) {
        this.open();
        var s = false;
        if (Object.prototype.hasOwnProperty.call(this.db.tables, tableName)) {
            delete this.db.tables[tableName];
            this.storage.set(this.key, this.db);
            s = true;

        }
        this.close();
        return s;
    }

    /**
    * thêm cột
    * @param {string} tableName tên bảng
    * @param {string} columnName tên cột
    * @param {object} config cấu hình cột
    */
    addColumn(tableName, columnName, config): any {
        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName)) {
            this.close();
            return false;
        }
        const table = this.db.tables[tableName];

        var ct = getType(columnName);
        var column = null;
        if (ct == "string") {
            if (isObject(config)) {
                var col = this.parseColumn(columnName, config.type || "string", config.length || null, config.required || false, config.default || config.defaultValue, config.autoIncrement);
                if (col) {
                    column = col;
                }
            } else if (isString(config)) {
                var type, defVal;
                if (typeof defaultTypeValues[String(config).toLowerCase()] != "undefined") {
                    type = config;
                } else {
                    type = 'string';
                    defVal = config;
                }
                var col = this.parseColumn(columnName, type, null, false, defVal);
                if (col) {
                    column = col;
                }
            } else {
                var col = this.parseColumn(columnName, typeof config != "undefined" ? getType(config) : "string", config);
                if (col) {
                    column = col;
                }
            }
        } else if (ct == "object" && Object.prototype.hasOwnProperty.call(columnName, 'name')) {
            var col = this.parseColumn(
                columnName.name,
                typeof columnName.type != "undefined" ? columnName.type : "string",
                isNumber(columnName.length) ? columnName.length : null,
                columnName.default || columnName.defaultValue,
                columnName.autoIncrement || false
            );
            if (col) {
                column = col;
            }
        }
        if (column) {
            if (Object.prototype.hasOwnProperty.call(table.config, column.name)) {
                this.close();
                return false;
            }
            table.config[column.name] = column;
            for (var index = 0; index < table.data.length; index++) {
                var row = table.data[index];
                row[column.name] = column.defVal;
            }

            this.storage.set(this.key, this.db);
        }
        this.close();
    }
    /**
     * xóa cột
     * @param {string} tableName tyên bảng
     * @param {string} columns danh sách cột cần xóa
     * @returns {boolean}
     */
    dropColumn(tableName: string, ...args: any[]) {
        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName)) {
            this.close();
            return false;
        }
        const table = this.db.tables[tableName];

        var list = []
        for (var index = 0; index < args.length; index++) {
            var a = args[index];
            if (isArray(a)) {
                a.map(function (s) {
                    if (Object.prototype.hasOwnProperty.call(table.config, s)) {
                        table.config[s] = null;
                        list.push(s);
                        try {
                            delete table.config[s];

                        } catch (error) {

                        }
                    }
                })
            } else if (Object.prototype.hasOwnProperty.call(table.config, a)) {
                table.config[a] = null;
                list.push(a);
                try {
                    delete table.config[a];
                } catch (error) {

                }

            }
        }
        if (list.length && table.data.length) {
            table.data.map(function (row) {
                list.map(function (col) {
                    row[col] = null;
                    try {
                        delete row[col];
                    } catch (error) {

                    }
                })
            })
        }
        this.storage.set(this.key, this.db);
        this.close();
        return true;
    }


    parseColumnData(tableName, data, $id: number = 0) {
        this.open();
        let config = this.db.tables[tableName].config;
        let d: any = {};
        for (const k in config) {
            if (Object.prototype.hasOwnProperty.call(config, k)) {
                let dhk = Object.prototype.hasOwnProperty.call(data, k);
                const column = config[k];
                if (column.autoIncrement) {
                    if ($id) {
                        d[k] = $id;
                    }
                }
                else if (!((column.type == "string" && isNumber(data[k])) || (column.type == "number" && isNumber(data[k]))) && column.type != getType(data[k])) {
                    this.close();
                    throw new Error(k + " type is not match");
                }
                else if (column.required && !dhk && $id) {
                    this.close();
                    throw new Error(k + " is required");
                }
                else if ($id && !column.required && !dhk) {
                    d[k] = column.defVal;
                } else if (dhk && column.type == "number") {
                    d[k] = Number(data[k]);
                } else if (dhk) {
                    d[k] = data[k];
                }
            }
        }
        this.close();
        return d;
    }

    insert(tableName: string, data: any) {
        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName) || !isObject(data))
        {
            this.close();
            return false;
        }
            
        const table = this.db.tables[tableName];
        let $id = table.autoIncrement +1;

        let d = this.parseColumnData(tableName, data, $id);
        if(d){
            table.data.push(d);
            table.autoIncrement++;
            this.storage.set(this.key, this.db);
        }
        this.close();
        return true;

    }

    /**
     * cập nhật dữ liệu 
     * @param {string} tableName tên bảng
     * @param {object} data dữ liệu
     * @param {function|object} condition diều kiện
     * @returns {integer}
     */
    update(tableName: string, data: any, condition?: any) {
        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName) || !isObject(data)){
            this.close();
            return 0;
        }
            
        const table = this.db.tables[tableName];
        var d: any = this.parseColumnData(tableName, data, 0);
        if (!d){
            this.close();
            return 0;
        }
        var count = 0;
        if (!condition) {
            table.data.map(function (row) {
                for (const k in d) {
                    if (Object.prototype.hasOwnProperty.call(d, k)) {
                        const v = d[k];
                        row[k] = v;
                    }
                }
                count++;
            });
        }
        else if (isObject(condition) && !isEmpty(condition)) {
            table.data.map(function (row) {
                var s = true;
                for (var key in condition) {
                    if (Object.hasOwnProperty.call(condition, key)) {
                        if (!Object.hasOwnProperty.call(row, key)) s = false;
                        if (isFunction(condition[key])) {
                            if (!condition[key](row[key])) s = false;
                        }
                        else if (row[key] != condition[key]) s = false;
                    }
                }
                if (s) {
                    for (const k in d) {
                        if (Object.prototype.hasOwnProperty.call(d, k)) {
                            const v = d[k];
                            row[k] = v;
                        }
                    }
                    count++;
                }
            });
        }
        else if (isFunction(condition)) {
            table.data.map(function (row) {
                var s = condition(assignValue({}, row));
                if (s) {
                    for (const k in d) {
                        if (Object.prototype.hasOwnProperty.call(d, k)) {
                            const v = d[k];
                            row[k] = v;
                        }
                    }
                    count++;
                }
            });
        }
        this.storage.set(this.key, this.db);
        this.close();
        return count;
    }

    delete(tableName: string, condition?: any) {
        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName)) {
            return 0;
        }
        const table = this.db.tables[tableName];
       var count = 0;
        if (!condition) {
            count = table.data.length;
            table.data.splice(0);
        }
        else if (isObject(condition) && !isEmpty(condition)) {
            var i = 0;
            while (i < table.data.length) {
                var s = true;
                var row = table.data[i];
                for (var key in condition) {
                    if (Object.hasOwnProperty.call(condition, key)) {
                        if (!Object.hasOwnProperty.call(row, key)) s = false;
                        if (isFunction(condition[key])) {
                            if (!condition[key](row[key])) s = false;
                        }
                        else if (row[key] != condition[key]) s = false;
                    }
                }
                if (s) {
                    table.data.splice(i, 1);
                    count++;
                } else {
                    i++;
                }
            }
        }
        else if (isFunction(condition)) {
            var i = 0;
            while (i < table.data.length) {
                var s = true;
                var row = table.data[i];
                s = condition(assignValue({}, row));
                if (s) {
                    table.data.splice(i, 1);
                    count++;
                } else {
                    i++;
                }
            }
        }
        this.storage.set(this.key, this.db);
        this.close();
        return count;
    }

    /**
    * lấy về dữ liệu
    * @param tableName tên bảng
    * @param columns danh sach cot
    * @param condition dieu kien lay du lieu
    * @param orderBy sap xep
    * @param limit gioi han
    * @returns 
    */
    select(tableName: string, columns?: any, condition?: any, orderBy?: any, limit?: any): DbTableRow[] {
        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName)) {
            this.close();
            return [];
        }
        const table = this.db.tables[tableName];

        var maskTable = null;
        var m = null;

        var isN = isInteger(limit) && limit > 0;
        // var count = 0;
        var raw = [];
        var results = [];
        var selectColumns: any = '*';
        if (!columns || columns == '*') {
            // ko lam gi
        }
        else {
            selectColumns = [];

            if (isString(columns)) {
                var ca = columns.split(",").map(function (a) {
                    return a.trim();
                }).filter(function (t) {
                    return t.length > 0;
                }).map(function (t) {
                    var a = t.split(" ").filter(function (v) {
                        return v.length > 0
                    });
                    if (a.length == 3 && a[1].toLowerCase() == "as") {
                        return [a[0], a[2]];
                    }
                    return a;
                }).filter(function (a) {
                    return a.length > 0;
                }).map(function (a) {
                    if (Object.prototype.hasOwnProperty.call(table.config, a[0])) {
                        selectColumns.push(a);
                    }
                });
            }
            else if (isArray(columns) && columns.length) {
                columns.map(function (t) {
                    var a = t.split(" ").filter(function (v) {
                        return v.length > 0
                    });
                    if (a.length == 3 && a[1].toLowerCase() == "as") {
                        return [a[0], a[2]];
                    }
                    return a;
                }).filter(function (a) {
                    return a.length > 0;
                }).map(function (a) {
                    if (Object.prototype.hasOwnProperty.call(table.config, a[0])) {
                        selectColumns.push(a);
                    }
                });
            }
        }
        var isCondFunc = isFunction(condition);
        var isCondObj = isObject(condition);
        if (!condition) {
            // count = this.data.length;
            table.data.map(function (row) {
                raw.push(assignValue({}, row));
            });
        }
        else if (isCondFunc || isCondObj) {
            var masks = [];
            var types = {};
            var cfg = table.config;
            if (selectColumns != "*") {
                selectColumns.map(function (a) {
                    if(objectHasKey(cfg, a[0])){
                        types[a[0]] = cfg[a[0]].type;
                        if(a.length > 1){
                            types[a[1]] = cfg[a[0]].type;
                        }
                    }
                    masks.push({
                        column: a[0],
                        mask: a.length > 1 ? a[1] : null
                    });
                })
            }
            else {
                for (var key in table.config) {
                    if (Object.hasOwnProperty.call(table.config, key)) {
                        var col = table.config[key];
                        types[key] = col.type;
                        masks.push({
                            column: col.name,
                            mask: null
                        });
                    }
                }
            }

            table.data.map(function (row) {
                var b = assignValue({}, row);
                masks.map(function (c) {
                    if (c.mask) {
                        b[c.mask] = b[c.column];
                    }
                });
                if (isCondFunc) {
                    var whereStt = condition(b);
                    if (whereStt === true) {
                        raw.push(b);
                    }
                } else if (isCondObj) {
                    var s = true;
                    for (const key in condition) {
                        if (Object.hasOwnProperty.call(condition, key)) {
                            const vl = condition[key];
                            if (isFunction(vl)) {
                                if (!vl(b[key])) s = false;
                            }
                            else if(objectHasKey(types, key) && types[key] != "array" && isArray(vl)){
                                if(!inArray(vl, b[key])){
                                    s = false;
                                }
                            }
                            else if (b[key] != vl) {
                                s = false;
                            }
                        }
                    }
                    if (s) {
                        raw.push(b);
                    }
                }
            })
        }

        if (raw.length) {
            if (isObject(orderBy) && !isEmpty(orderBy)) {
                var orderByList = [];
                for (var key in orderBy) {
                    if (Object.hasOwnProperty.call(orderBy, key)) {
                        var type = String(orderBy[key]).toLowerCase();
                        if (Object.hasOwnProperty.call(raw[0], key) && inArray(['asc', 'desc', 1, 0], type)) {
                            orderByList.push({
                                key: key,
                                type: type
                            })
                        }

                    }
                }
                for (var i = 0; i < orderByList.length; i++) {
                    var order = orderByList[i];

                    if (i == 0) {
                        for (var j = 0; j < raw.length - 1; j++) {
                            for (var k = j + 1; k < raw.length; k++) {
                                var a = Str.compare(raw[j][order.key], raw[k][order.key]);
                                // console.log(`${raw[j][order.key]} <> ${raw[k][order.key]}`, a)
                                if (order.type == 'desc') {
                                    if (a == -1) {
                                        var t = raw[j];
                                        raw[j] = raw[k];
                                        raw[k] = t;
                                    }
                                } else if (a == 1) {
                                    var t = raw[j];
                                    raw[j] = raw[k];
                                    raw[k] = t;
                                }
                            }
                        }
                    }
                    else {
                        for (var j = 0; j < raw.length - 1; j++) {
                            for (var k = j + 1; k < raw.length; k++) {
                                var s = true;
                                for (var l = 0; l < i; l++) {
                                    var o = orderByList[l];

                                    if (raw[j] == raw[k] || raw[j][o.key] != raw[k][o.key]) {
                                        s = false;
                                    }

                                }
                                if (s) {
                                    var a = Str.compare(raw[j][order.key], raw[k][order.key]);
                                    if (order.type == 'desc') {
                                        if (a == -1) {
                                            var t = raw[j];
                                            raw[j] = raw[k];
                                            raw[k] = t;
                                        }
                                    } else if (a == 1) {
                                        var t = raw[j];
                                        raw[j] = raw[k];
                                        raw[k] = t;
                                    }
                                }

                            }
                        }
                    }
                }
            }
            if (isN) {
                results = raw.slice(0, limit);
            }
            else {
                results = raw;
            }
        }
        if (selectColumns != "*") {
            var rs = results.map(function (row) {
                var obj = {};
                for (var i = 0; i < selectColumns.length; i++) {
                    var col = selectColumns[i];
                    if (col[1]) {
                        obj[col[1]] = row[col[0]];
                    }
                }
                return obj;
            }) as DbTableRow[];
            this.close();
            return rs;
        }
        this.close();
        return results;
    }
    getLastInsertID(table: string): number {
        this.open();
        var count = Object.prototype.hasOwnProperty.call(this.db.tables, table) ? this.db.tables[table].autoIncrement : 0;
        this.close();
        return count;
    }

    getLastRecord(tableName) {
        this.open();
        if (!Object.prototype.hasOwnProperty.call(this.db.tables, tableName)) {
            this.close();
            return null;
        }
        const table = this.db.tables[tableName];
        const rs = table.data.length ? table.data[table.data.length - 1] : null;
        this.close();
        return rs;

    }

}
