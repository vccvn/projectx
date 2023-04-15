App.extend({
    storage: {
        key: "__storage__object__list__",
        support: function() {
            if (typeof(Storage) !== "undefined") {
                return true;
            }
            return true;
        },
        /**
         * @returns {array}
         */
        getObjectList: function () {
            if(!this.support()) return [];
            var val = localStorage.getItem(this.key);
            if(val){
                return JSON.parse(val);
            }
            return [];
        },
        addToObjectList: function (key) {
            if(!this.support()) return this;
            var objList = this.getObjectList();
            if(objList.indexOf(key) === -1){
                objList.push(key);
                localStorage.setItem(this.key, JSON.stringify(objList));
            }
            return this;
        },
        removeInObjectList: function(key){
            if(!this.support()) return this;
            var list = this.getObjectList();
            var ind = list.indexOf(key);
            if(ind > -1){
                list.splice(ind, 1);
                localStorage.setItem(this.key, JSON.stringify(list));
            }
            return this;
        },
        checkObjectList: function (key) {
            var stt = false;
            var list = this.getObjectList();
            return list.indexOf(key) >= 0;
        },
        set: function(key,value){
            if(!this.support()) return false;
            if(App.isObject(Key)){
                for (const k in key) {
                    if (key.hasOwnProperty(k)) {
                        const v = key[k];
                        this.set(k, v);
                    }
                }
                return this;
            }
            if(App.isObject(value)) {
                value = JSON.stringify(value);
                this.addToObjectList(key);
            }
            localStorage.setItem(key, value);
            return true;
        },
        get: function(key){
            if(!this.support()) return null;
            var val = localStorage.getItem(key);
            if(this.checkObjectList(key)){
                val = JSON.parse(val);
            }
            return val;
        },
        remove: function(key){
            if(!this.support()) return false;
            this.removeInObjectList(key);
            localStorage.removeItem(key);
            return true;
        }
    }
});
