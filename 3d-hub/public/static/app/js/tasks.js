window.__3DHubTaskManager__ = {
    tasks: {},
    add: function(task, callable){
        if(!Object.prototype.hasOwnProperty.call(this.tasks, task)) this.tasks[task] = [];
        return typeof callable == "function" && this.tasks[task].push(callable)? true: false;
    },
    has: function(task, callable){
        if(!Object.prototype.hasOwnProperty.call(this.tasks, task)) return false;
        if(!this.tasks[task].length) return false;
        if(callable) return this.tasks[task].indexOf(callable) != -1;
        return  true;
    },
    remove: function(task, callable){
        if(!Object.prototype.hasOwnProperty.call(this.tasks, task)) return false;
        if(!this.tasks[task].length) return false;
        if(callable){
            var i = this.tasks[task].indexOf(callable);
            if(i!=-1){
                this.tasks[task].splice(callable, 1);
                return true;
            }
            return false;
        }
        this.tasks[task].splice(0);
        delete this.tasks[task];
        return true;
    },
    run: function(task, args){
        if(!Object.prototype.hasOwnProperty.call(this.tasks, task)) return false;
        if(!this.tasks[task].length) return false;
        var a = args && Array.isArray(args) ? args: []
        if(this.tasks[task].length == 1){
            return typeof( this.tasks[task][0] )  == "function"? this.tasks[task][0].apply(null, a): undefined;
        }
        var r = [];
        var callable;
        for (let index = 0; index < this.tasks[task].length; index++) {
            callable = this.tasks[task][index];
            if(typeof callable == "function"){
                r.push(callable.apply(null, a));
            }
        }
        return  r;
    }
}