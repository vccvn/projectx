import { isCallable, isObject, objectHasKey, Str, inArray, isArray } from "./helpers/utils";
const NO_VALUE = Str.rand();
export interface __3DHubTaskManager__{
    tasks: {
        [task:string]: CallableFunction[]
    }
    add(task: string, callable: CallableFunction): boolean
    has(task: string, callable?: CallableFunction): boolean
    remove(task: string, callable?: CallableFunction): boolean
    run(task: string, args?: any[]): any
    
}
export const __3DHubTaskManager__: __3DHubTaskManager__ = typeof window['__3DHubTaskManager__'] != "undefined" && isObject(window['__3DHubTaskManager__']) ? window['__3DHubTaskManager__'] : {
    tasks: {},
    add: function(task, callable){
        if(!objectHasKey(this.tasks, task)) this.tasks[task] = [];
        return isCallable(callable) && this.tasks[task].push(callable)? true: false;
    },
    has: function(task, callable?:CallableFunction){
        if(!objectHasKey(this.tasks, task)) return false;
        if(!this.tasks[task].length) return false;
        if(callable) return this.tasks[task].indexOf(callable) != -1;
        return  true;
    },
    remove: function(task, callable?:CallableFunction){
        if(!objectHasKey(this.tasks, task)) return false;
        if(!this.tasks[task].length) return false;
        if(callable){
            let i = this.tasks[task].indexOf(callable);
            if(i!=-1){
                this.tasks[task].splice(callable, 1);
                return true;
            }
            return false;
        }
        this.tasks[task].splice(0);
        delete this.tasks[task];
        return  true;
    },
    run: function(task, args?:any[]){
        if(!objectHasKey(this.tasks, task)) return false;
        if(!this.tasks[task].length) return false;
        let a = args && isArray(args) ? args: []
        if(this.tasks[task].length == 1){
            return isCallable( this.tasks[task][0])? this.tasks[task][0](...a):null;
        }
        let r:any[] = [];
        for (let index = 0; index < this.tasks[task].length; index++) {
            const callable = this.tasks[task][index];
            if(isCallable(callable)){
                r.push(callable(...a));
            }
        }
        return  r;
    }
}

export const getTaskManager: () => __3DHubTaskManager__ = () => __3DHubTaskManager__;
export const addTask = (task: string, callable: CallableFunction) => __3DHubTaskManager__.add(task, callable);
export const removeTask = (task: string, callable?: CallableFunction) => __3DHubTaskManager__.remove(task, callable);
export const hasTask = (task: string, callable?: CallableFunction) => __3DHubTaskManager__.has(task, callable);
export const runTask = (task: string, args?:any[]) => __3DHubTaskManager__.run(task, args);

export const Demo = function Demo(...args){
    this.a = args.length > 0?args[0]:null;
    this.b = args.length > 1?args[1]:null;
    this.c = args.length > 2?args[2]:null;
}
export const Test = function Test(...args){
    return new Demo(...args);
}