import { Injectable } from '@angular/core';
import { isFunction, isObject } from '@app/_core/helpers/utils';
import { EventManagerService } from '@app/_core/services/event-manager.service';

export interface ApiParams {
    search?: string
    page?: number
    perPage?: number
    orderBy?: string
    orderType?: string
    [x: string]: (string | number)
}

export type LibraryOpenParams = {
    
    title?: string,
    listType?: string,
    url?: string
    params?: ApiParams
    mode?: string,
    done?: (image: (any | any[])) => any,
    cancel?: () => any,
    
    [x: string]: any
}

type libParam = (((...args:any[]) => any) | LibraryOpenParams);

@Injectable({
    providedIn: 'root'
})
export class ImageLibraryService extends EventManagerService {

    constructor() {
        super();
    }

    /**
     * 
     * @param params tham so thu vien
     * @param callback ham khi chon anh xong
     * @returns 
     */
    open(params?: libParam, callback?: (image?: any) => any, cancel?: (...args:any[]) => any): ImageLibraryService {

        var pars: any = {};
        var callb: any;
        if (isFunction(params)) {
            callb = params;
            if (isObject(callback) && callback) pars = callback;
            else if(isFunction(callback)){
                cancel = callback;
            }
        }
        else {
            if (isObject(params)) {
                pars = params;
                if (isFunction(pars.done)) {
                    callb = pars.done;
                }
                if (isFunction(pars.cancel)) {
                    cancel = pars.cancel;
                }
                
            }
            if (!isFunction(callb) && isFunction(callback)) {
                callb = callback;
            }
        }
        this.emit({
            type: "open",
            config: pars,
            callback: callb,
            cancel
        })
        return this;
    }
}
