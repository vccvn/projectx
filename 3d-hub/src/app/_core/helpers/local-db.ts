import { assignValue, getArguments, getType, inArray, isArray, isBoolean, isEmpty, isFunction, isInteger, isNumber, isObject, isString, Str } from "./utils";
import LocalStorageEngine from "./local-storage";

export const defaultTypeValues = {
    string: "",
    number: 0,
    boolean: false,
    object: {},
    array: [],
    html: "<div></div>",

}

export interface DbTableColumn {
    name?: string
    type: string
    length?:number
    required?: boolean
    defVal?: any
    autoIncrement?: boolean
}
export interface DbTableColumns{
    [column: string]: DbTableColumn
}

export interface DbTableRow{
    [column:string]: any
}

export interface DbTable{
    name: string,
    config: DbTableColumns,
    data: DbTableRow[],
    autoIncrement: number
}

export interface Database {
    version: string
    name: string,
    tables: {
        [tableName:string]: DbTable
    }
}

class LocalDB {
    key: string = "__storage__database__";
    storage: LocalStorageEngine;

    dbname: string;

    database: Database;
    constructor(database) {
        if (!(isString(database) && database == Str.objectKey(database))) {
            throw new Error("Database Name is not valid");
        }
        this.dbname = database;
        this.storage = new LocalStorageEngine(this.key);

        this.init();
    }

    init(){
        var db = this.storage.get(this.dbname);
        if(db){
            this.database = db;
        }
        else{
            this.database = {
                version: "1.0",
                name: this.dbname,
                tables: {}
            };
            this.storage.set(this.dbname, this.database);
        }
    }
    
    updateDatabase(){
        this.storage.set(this.dbname, this.database);
    }

    getTable(tableName: string): (DbTable|null){
        return typeof this.database.tables[tableName] == "object" && isArray(this.database.tables[tableName].data) ? this.database.tables[tableName] : null;
    }


    parseTableRowData(table, data, isUpdate?: any): any {
        var d = {};

        var $id = table.autoIncrement + 1;
        for (var k in table.config) {
            if (Object.prototype.hasOwnProperty.call(table.config, k)) {
                var dhk = Object.prototype.hasOwnProperty.call(data, k);
                var column = table.config[k];
                if (column.autoIncrement) {
                    if (!isUpdate) {
                        d[k] = $id;
                    }
                }
                else if (!((column.type == "string" && isNumber(data[k]) || column.type == "number" && isNumber(data[k]))) && column.type != getType(data[k])) {
                    return null;
                }
                else if (!dhk) {
                    if (!isUpdate) {
                        d[k] = column.defVal;
                    }
                } else if (column.type == "number") {
                    d[k] = Number(data[k]);
                } else {
                    d[k] = data[k];
                }
            }
        }

        return d;
    }
    /**
     * 
     * @param {string} name tên cộ
     * @param {string} type loại dự liệu
     * @param {*} defaultValue gia tri mac dinh
     * @param {booluan} autoIncrement 
     * @returns {{name, type, defaultValue, autoIncrement}}
     */
    parseColumn(name, type?, defaultValue?, autoIncrement?): any {
        var t = String(type).toLowerCase();
        if (t == "text") t = "string";

        if (!defaultTypeValues.hasOwnProperty(t) || !isString(name) || String(name).length == 0) {
            return null;
        }
        return {
            name: name,
            type: t,
            length: null,
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
    parseColumns(columns, isA, isO): any {
        var cols = {};
        var columnCount = 0;
        var self = this;
        var addColumn = function (name, type, defaultValue?, autoIncrement?) {
            var cl = self.parseColumn(name, type, defaultValue, autoIncrement);
            if (cl) {
                columnCount++;
                cols[name] = cl;
                return true;

            }
            return false;
        }
        if (isA) {
            columns.map(function (col: any) {
                if (isObject(col) && col.name) {
                    addColumn(col.name, col.type || "string", col.defaultValue || col['default'], col.autoIncrement);
                } else if (isString(col)) {
                    addColumn(col, "string");
                }
            })
        }
        else if (isO) {
            for (var key in columns) {
                if (Object.hasOwnProperty.call(columns, key)) {
                    var col = columns[key];
                    var type = getType(col);
                    if (type == "object") {
                        if (col.type === undefined) {
                            addColumn(key, "object", col);
                        } else if (Object.hasOwnProperty.call(defaultTypeValues, String(col.type).toLowerCase())) {
                            addColumn(col.name || key, col.type, defaultTypeValues[String(col.type).toLowerCase()], col.autoIncrement);
                        }
                    } else {
                        if (type == "string") {
                            var t = String(col).toLowerCase();
                            if (Object.hasOwnProperty.call(defaultTypeValues, t)) {
                                addColumn(key, t);
                            } else {
                                addColumn(key, type, col);
                            }
                        } else {
                            addColumn(key, type, col);
                        }
                    }
                }
            }
        }
        return {
            count: columnCount,
            columns: cols
        };
    }
    /**
     * 
     * @param {string} tableName tên tên bảng
     * @param {*} columns 
     * @returns 
     */
    createTable(tableName: string, columns: any) {
        if (!(isString(tableName) && tableName == Str.objectKey(tableName))) {
            return false;
        }
        var isA = isArray(columns);
        var isO = isObject(columns);
        if (!(isA || isO)) {
            return false;
        }
        if (this.getTable(tableName)) {
            return false;
        }
        var colCfg = this.parseColumns(columns, isA, isO);
        if (colCfg.count) {
            this.database.tables[tableName] = {
                name: tableName,
                config: colCfg.columns,
                data: [],
                autoIncrement: 0
            };
            this.updateDatabase();
            return true;
        }
        return false;
    }
    /**
     * Xóa bảng
     * @param {string} tableName tên bảng
     * @returns {boolean}
     */
    dropTable(tableName: string):boolean {
        if(typeof this.database.tables[tableName] == "object"){
            this.database.tables[tableName] = null;
            delete this.database.tables[tableName];
            this.updateDatabase();
            return true;
        }
        return false;
    }
    /**
     * sửa bảng
     * @param {string} tableName tên bảng
     * @param {array|object} columns các cột
     * @returns {boolean}
     */
    modifyTable(tableName, columns) {
        
        var table = this.getTable(tableName);
        if (!table) {
            throw new Error("Table is not exists");
        }
        var isA = isArray(columns);
        var isO = isObject(columns);
        if (!(isA || isO)) {
            throw new Error("Table columns is not valid");
        }
        var colCfg = this.parseColumn(columns, isA, isO);

        if (colCfg.count) {
            for (var key in colCfg.config) {
                if (Object.hasOwnProperty.call(colCfg.config, key)) {
                    var cfg = colCfg.config[key];
                    table.config[key] = cfg;
                }
            }
            if (table.data.length) {
                for (var i = 0; i < table.data.length; i++) {
                    var row = table.data.length[i];
                    for (var key in colCfg.columns) {
                        if (Object.hasOwnProperty.call(colCfg.columns, key)) {
                            var cfg = colCfg.columns[key];
                            if (Object.hasOwnProperty.call(row, key)) {
                                var t = getType(row[key]);
                                if (t != cfg.type) {
                                    if (t == "number" && cfg.type == "string") {
                                        row[key] = String(row[key]);
                                    } else if (t == "string" && cfg.type == "number") {
                                        var a = Number(row[key]);
                                        row[key] = !isNaN(a) ? a : cfg.defVal;
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
            this.updateDatabase();
            return true;
        }
        return false;
    }
    /**
     * thêm cột
     * @param {string} tableName tên bảng
     * @param {string} columnName tên cột
     * @param {object} config cấu hình cột
     */
    addColumn(tableName, columnName, config): any {
        if (!(isString(tableName) && tableName == Str.objectKey(tableName))) {
            return false;
        }
        var ct = getType(columnName);
        var table = this.getTable(tableName);
        if (!table) {
            return false;
        }
        var column = null;
        if (ct == "string") {
            if (isObject(config)) {
                var col = this.parseColumn(columnName, config.type || "string", columnName.default || config.defVal, config.autoIncrement);
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
                var col = this.parseColumn(columnName, type, defVal);
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
            var col = this.parseColumn(columnName.name, typeof columnName.type != "undefined" ? columnName.type : "string", columnName.default || columnName.defVal);
            if (col) {
                column = col;
            }
        }
        if (column) {
            if (Object.prototype.hasOwnProperty.call(table.config, column.name)) {
                return false;
            }
            table.config[column.name] = column;
            for (var index = 0; index < table.data.length; index++) {
                var row = table.data[index];
                row[column.name] = column.defVal;
            }

            this.updateDatabase();
        }
    }
    /**
     * xóa cột
     * @param {string} tableName tyên bảng
     * @param {string} columns danh sách cột cần xóa
     * @returns {boolean}
     */
    dropColumn(tableName: string, columns?: any) {
        
        var table = this.getTable(tableName);
        if (!table) {
            return false;
        }
        var list = [];
        var args = getArguments(arguments, 1);
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
        this.updateDatabase();
        return true;
    }
    /**
     * thêm dữ liệu
     * @param {string} tableName tên bảng
     * @param {object} data dữ liệu
     * @returns {boolean}
     */
    insert(tableName: any, data: any) {
        var table = this.getTable(tableName);
        if (!table || !isObject(data)) {
            return false;
        }
        var rowData = this.parseTableRowData(table, data);
        if (!rowData) return false;
        table.data.push(rowData);
        table.autoIncrement++;
        this.updateDatabase();
        return true;
    }
    /**
     * cập nhật dữ liệu 
     * @param {string} tableName tên bảng
     * @param {object} data dữ liệu
     * @param {function|object} condition diều kiện
     * @returns {integer}
     */
    update(tableName:string, data:any, condition?:any) {
        var table = this.getTable(tableName);
        if (!table || !isObject(data)) {
            return 0;
        }
        var d: any = this.parseTableRowData(table, data, true);
        if (!d) return 0;
        var count = 0;
        if (!condition) {
            table.data.map(function (row) {
                assignValue(row, d);
                count++;
            });
        }
        else if (isObject(condition) && !isEmpty(condition)) {
            table.data.map(function (row) {
                var s = true;
                for (var key in condition) {
                    if (Object.hasOwnProperty.call(condition, key)) {
                        if (!Object.hasOwnProperty.call(row, key) || row[key] != condition[key]) {
                            s = false;
                        }
                    }
                }
                if (s) {
                    assignValue(row, d);
                    count++;
                }
            });
        }
        else if (isFunction(condition)) {
            table.data.map(function (row) {
                var s = condition(assignValue({}, row));
                if (s) {
                    assignValue(row, d);
                    count++;
                }
            });
        }
        this.updateDatabase();
        return count;
    }

    delete(tableName: string, condition?: any) {
        var table = this.getTable(tableName);
        if (!table) {
            return 0;
        }
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
                        if (!Object.hasOwnProperty.call(row, key) || row[key] != condition[key]) {
                            s = false;
                        }
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
        this.updateDatabase();
        return count;
    }
    /**
     * lấy về dữ liệu
     * @param tableName tên bảng
     * @param columns danh sach cot
     * @param condition dieu kien lay du lieu
     * @param orderBy sap xep
     * @param limit gioi han
     * @returns {DbTable[]}
     */
    select(tableName: string, columns?: any, condition?: any, orderBy?: any, limit?: any): DbTableRow[] {
        var maskTable = null;
        var m = null;
        var table = this.getTable(tableName);

        if (!table) {
            return [];
        }
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
            if (selectColumns != "*") {
                selectColumns.map(function (a) {
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
                            if (b[key] != vl) {
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
            return results.map(function (row) {
                var obj = {};
                for (var i = 0; i < selectColumns.length; i++) {
                    var col = selectColumns[i];
                    if (col[1]) {
                        obj[col[1]] = row[col[0]];
                    }
                }
                return obj;
            }) as DbTableRow[]
        }
        return results;

    }


}

export default LocalDB;
export { LocalDB };
