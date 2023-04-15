import { getTimeStamp, isBoolean, objectHasKey, Str } from "@app/_core/helpers/utils";
import { CallbackFunction } from "@app/_shared/shared.type";

class Animation {
    tasks:{[name:string]:CallbackFunction[]} = {};
    taskCount = 0;
    isRunning = false;
    
    isShowLog = false;

    add(name:string, callback?:()=>any) {
        if (typeof callback != "function")
            return this;
        if (this.tasks[name] === undefined) {
            this.tasks[name] = [];
            this.taskCount++;
        }
        this.tasks[name].push(callback);
        this.start();
        return this;
    }
    remove(name:string, callback?:()=>any) {
        if (name && typeof this.tasks[name] != "undefined") {
            if (callback) {
                var index = this.tasks[name].indexOf(callback);
                if (index !== -1) {
                    this.tasks[name].splice(index, 1);
                    this.taskCount--;
                }
            } else {
                this.taskCount -= this.tasks[name].length;
                delete this.tasks[name];
            }
        }
        return this;
    }
    has(name:string, callback?:()=>any) {
        if (name && typeof this.tasks[name] != "undefined") {
            if (callback) {
                var index = this.tasks[name].indexOf(callback);
                if (index !== -1) {
                    return true;
                }
            } else {
                return this.tasks[name].length ? true : false;
            }
        }
        return false;
    }
    start() {
        if (!this.isRunning) {
            this.isRunning = true;
            this.animate();
        }
    }
    stop() {
        this.isRunning = false;
    }
    animate () {
        var self = this;
        if(this.isShowLog){
            // console.log("animation run")
        }
        if (this.isRunning && this.taskCount) {
            for (const name in this.tasks) {
                if (Object.hasOwnProperty.call(this.tasks, name)) {
                    const tasklist = this.tasks[name];
                    if (tasklist.length) {
                        tasklist.map(function (callback) {
                            if (typeof callback == "function") {
                                callback();
                            }
                        });
                    }
                }
            }
            requestAnimationFrame(function () { self.animate(); });

        } else {
            this.isRunning = false;
        }
    }

    set enableLog(value){
        if(isBoolean(value)){
            this.isShowLog = value;
        }
    }

    _id: string;
    constructor(id?:string) {
        // lam gi do
        this._id = id?id:Str.rand(getTimeStamp());

    }
}

const animationContainers: {[s:string]:Animation} = {};
const registerAnimationTask = (key: string) => {
    if(!objectHasKey(animationContainers, key)) animationContainers[key] = new Animation(key);

    return animationContainers[key];
};
const AnimationLoop = new Animation();

export default AnimationLoop;
export {AnimationLoop, registerAnimationTask};
