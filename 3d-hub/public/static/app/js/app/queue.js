    /**
     * xửu lý hàng đợi
     * @param {function} work hàm thục thi công việc
     * @param {Number} delay thời gian giữa 2 lần chạy task
     * @param {Number} step số lần thực hiện công việc nếu chưa bị reject hay resolve
     */
    var Queue = function (work, delay, step) {
        if(typeof work == "undefined") return this;
        this.status = "pending";
        this.result = null;
        var d = (typeof delay == "undefined" || !isNumber(delay) || delay < 1) ? 10 : delay;
        var s = (typeof step == "undefined" || !isNumber(step) || step < 0) ? -1 : step;
        var self = this;
        var properties = {
            timeDelay: d,
            stepCount: s,
            resolved: false,
            rejected: false,
            cancelled: false,
            stopped: false,
            status: "pending",
            timeId: null,
            turn: 1,
            count: 1
        };
        var methods = {
            then: function (rs) {
                // App.log(rs);
            },
            catch: function (err) {
                App.log(err);
            },
            clear: function () {
                if(properties.timeId){
                    clearTimeout(properties.timeId);
                    self.status = properties.status;
                }
                
            },
            run: function () {
                var comtext = this;
                var time = properties.timeDelay || 10;
                var stop = properties.stepCount;
                var resolve = function (rs) {
                    properties.resolved = rs;
                    if(properties.status == "pending"){
                        properties.status = "resolved";
                        self.result = rs;
                        comtext.clear();
                        return comtext.then(rs);
                    }
                    comtext.clear();
                    return true;
                    
                };
                var reject = function (err) {
                    properties.rejected = err;
                    if(properties.status == "pending"){
                        properties.status = "rejected";
                        self.result = err;
                        comtext.catch(err);
                    }
                    comtext.clear();
                    return err;
                    
                };
                var runtask = function () {
                    properties.timeId = setTimeout(function() {
                        if(properties.stepCount > -1 && properties.turn > properties.stepCount){
                            properties.status = "stoped";
                            properties.stopped = "time out";
                            comtext.clear();
                            return false;
                        }else if(properties.status != "pending"){
                            return false;
                        }else{
                            try {
                                var stt = work(resolve, reject, properties.turn);
                                if(stt!==undefined) {
                                    if(properties.status == "pending"){
                                        comtext.stop();
                                        return false;
                                    }
                                }
                                properties.turn++;
                            } catch (error) {
                                comtext.stop();
                                comtext.catch(error);
                                return false;
                            }
                        }
                        
                        properties.count++;
                        runtask();
                    }, time);
                };
                runtask();
            },
            stop: function () {
                properties.stepCount = 0;
                properties.status = "stopped";
                this.clear();
            },
            delay: function (delay) {
                if(typeof delay == "undefined" || !isNumber(delay) || delay < 1) return;
                properties.timeDelay = delay;
                this.clear();
                this.run();
            },
            step: function (step) {
                if(typeof step == "undefined" || !isNumber(step) || step < -1 || step == 0) return;
                properties.stepCount = step;
                this.clear();
                this.run();
            },
            restart: function () {
                this.clear();
                properties.turn = 1;
                this.run();
            },
            getData: function (){
                return this;
            },
            addThen: function (fn) {
                if(typeof fn == "function"){
                    this.then = fn;
                }
            },
            addCatch: function (fn) {
                if(typeof fn == "function"){
                    this.catch = fn;
                }
            },
            getData:function () {
                return properties;
            }
        };
        this.e = function () {
            if (!arguments.length || typeof arguments[0] != "string") return null;
            var method = arguments[0];
            var r = null;
            if (typeof methods[method] == "function") {
                var args = [];
                for (let i = 1; i < arguments.length; i++) {
                    const arg = arguments[i];
                    args.push(arg);
                }

                r = methods[method].apply(methods, args);
            }
            return r;
        };
        setTimeout(function () {
            methods.run();
        }, 10);
    };

    Queue.prototype = {
        constructor: Queue,
        delay: function(delay){
            if(typeof delay == "undefined" || !isNumber(delay) || delay < 1) return;
            this.e("delay", delay);
            return this;
        }, 
        step: function (step) {
            if(typeof step == "undefined" || !isNumber(step) || step < -1 || step == 0) return;
            this.e("step", step);
            return this;
        },
        try: function (step) {
            if(typeof step == "undefined" || !isNumber(step) || step < -1 || step == 0) return;
            this.e("step", step);
            return this;
        },
        restart: function () {
            this.e("restart");
            return this;
        },
        stop: function () {
            this.e("stop");
            return this;
        },
        then: function (fb) {
            if(typeof fn == "function"){
                this.e("addThen", fn);
            }
            return this;
        },
        catch: function (fb) {
            if(typeof fn == "function"){
                this.e("addCatch", fn);
            }
            return this;
        },
        getData: function () {
            return this.e("getData");
        }
    };



    /**
     * Quản lý tiến trình chạy ngầm
     */
    var background = {
        // trạng thái của document
        documentReady: false,
        tasks: {},
        /**
         * thêm task
         * @param {string} name tên task
         * @param {function} task
         */
        addTask: function (name, task) {
            // do somthing
        },
        /**
         * Xóa task
         * @param {string} name tên task
         */
        removeTask: function (name) { },
        /**
         * kiểm tra app đã dc chạy hay chưa
         */
        checkReady: function () {
            if (this.documentReady) return true;
            var self = this;
            // var tid = setInterval(function () {
            //     if (document.readyState !== 'complete') return;
            //     clearInterval(tid);
            //     self.documentReady = true;
            // }, 50);
            var queue = new Queue(function(resolve, reject){
                if (document.readyState !== 'complete') return;
                self.documentReady = true;
                resolve(true);
            }, 50, 500);
        },
        /**
         * Đưa vào hàng đợi
         * @param {function} work 
         * @param {number} time default 10ms
         */
        queue: function (work, time) {
            if (typeof work == "undefined" || !isCallable(work)) return false;
            if (typeof time == "undefined" || !isNumber(time) || time <= 0) time = 10;
            var tid = setInterval(function () {
                var resolve = function (status) {
                    if (status) {
                        clearInterval(tid);
                    }
                }
                var reject = function () {
                    clearInterval(tid);
                }
                var st = work(resolve, reject);
                if (st !== undefined) clearInterval(tid);
            }, time);
        }
    };
