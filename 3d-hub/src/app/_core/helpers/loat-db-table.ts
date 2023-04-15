import LocalDB, { DbTable, DbTableColumns, DbTableRow } from "./local-db";
import { isEmpty } from "./utils";

export class LostTable{
    name: string = 'test';
    dbname: string = 'test';
    columns: DbTableColumns = {};
    database: LocalDB = null;
    constructor(){
        this.__init();
    }
    __init(){
        if(isEmpty(this.columns)){
            throw new Error("column is not config");
            
        }
        this.database = new LocalDB(this.dbname);
        this.database.createTable(this.name, this.columns);
    }
    insert(data){
        return this.database.insert(this.name, data);
    }
    add(data){
        return this.database.insert(this.name, data);
    }
    update(data, condition?:any){
        return this.database.update(this.name, data, condition);
    }
    getAll(condition?:any, select?:any){
        return this.database.select(this.name, select, condition);
    }
    get(condition?:any, select?:any, orderBy?: any, limit?: any){
        return this.database.select(this.name, select, condition, orderBy, limit);
    }
    select(columns?: any, condition?: any, orderBy?: any, limit?: any): DbTableRow[] {
        return this.database.select(this.name, columns, condition, orderBy, limit);
    }
    getOne(columns?: any, condition?: any, orderBy?: any): DbTableRow {
        let rs = this.database.select(this.name, columns, condition, orderBy);
        return rs.length == 1?rs[0]:null;
    }
    first(columns?: any, condition?: any, orderBy?: any): DbTableRow {
        let rs = this.database.select(this.name, columns, condition, orderBy);
        return rs.length == 1?rs[0]:null;
    }

}