import { inArray, isArray, isEmpty, isObject, isString } from '../helpers/utils';
import { LocalStorageService } from './local-storage.service';
import { LostDbService } from './lost-db.service';

export class LostQuery {
  params: any = {};
  name : string = null;
  db: LostDbService = null;
  orderByData: any = {};
  limitNumber: number = -1;
  skipNumber: number = 0;
  takeNumber: number = -1;

  constructor(db:any, tableName:string) {
    this.name = tableName;
    if(isObject(db)){
      this.db = db;
    }else if(isString(db)){
      this.db = new LostDbService(new LocalStorageService());
      this.db.useDatabase(db);
    }
    else {
      throw new Error("DB is Not Set");
    }
    
  }
  getAll(){
    var rs = this.db.select(this.name, '*', this.params, !isEmpty(this.orderByData)?this.orderByData:undefined, this.limitNumber > 0?this.limitNumber : undefined);;
    this.params = {};
    this.orderByData = {};
    this.limitNumber = -1;
    this.takeNumber = -1;
    this.skipNumber = 0;
    return rs;
  }
  getOne(){
    let rs = this.db.select(this.name, '*', this.params, !isEmpty(this.orderByData)?this.orderByData:undefined, 1);
    this.params = {};
    this.orderByData = {};
    this.limitNumber = -1;
    this.takeNumber = -1;
    this.skipNumber = 0;
    return rs.length?rs[0]:null;
  }
  orderBy(key: string, type?:string){
    if(isString(key) && key){
      let t = String(type).toLowerCase();
      if(type && inArray(['asc', 'desc'], t)){
        this.orderByData[key] = t;
      }else{
        this.orderByData[key] = 'asc';
      }
    }
    return this;
  }
  pushParam(key, value:any = undefined){
    if(!isArray(this.params[key]))this.params[key]=[];
    this.params[key].push(value);
    return this;
  }
  addParam(key:string, value?:any){
    this.params[key]=value;
    return this;
  }
}
