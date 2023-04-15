import { isArray, isNumber, isObject, isString, objectHasKey, Str } from "./helpers/utils";
const NO_VALUE = Str.rand();
export interface __CONFIG__ {
    key?: string
    urls?: {
        assets?: string
        [url: string]: string
    }
    view?: string
    data?: {
        [key: string]: any
    },
    [key: string]: any
}
export const __CONFIG__: __CONFIG__ = typeof window['__3DHub__'] != "undefined" && isObject(window['__3DHub__']) ? window['__3DHub__'] : {
    key: "",
    urls: {
        assets: "/assets"
    },
    view: "home",
    data: {},
}

export const getConfig: (key?:string) => any = (key?:string) => {
    if((isString(key) || isNumber(key)) && String(key).length){
        return getElement(__CONFIG__, key);
    }
    return __CONFIG__ ;
}

function getElement(elem, key){
    if(!isObject(elem)) return undefined;
    let c : any = elem;
    let s = String(key).split(".");
    for (let i = 0; i < s.length; i++) {
        const k = s[i];
        if((!isObject(c) && !isArray(c)) || !objectHasKey(c, k)) return undefined;
        c = c[k];
    }
    return c;
}