

// doi tượng fake de tranh bi mot vai loi
var Faker = function () {
    this.then = function () {
        // test
        return this;
    };
    this.catch = function () {
        //
        return this;
    }
};



var httpMethods = ["get", "post", "put", "patch", "delete", "head", "options"];

var crazyRequestApi = {
    getStatus: function () {
        return this.e("get", "status");
    },
    done: function (fn) {
        if (fn) {
            this.e("done", fn);
        }
        return this;
    },
    success: function (fn) {
        if (fn) {
            this.e("done", fn);
        }
        return this;
    },
    then: function (fn) {
        if (fn) {
            this.e("done", fn);
        }
        return this;
    },
    catch: function (fn) {
        if (fn) {
            this.e("error", fn);
        }
        return this;
    },
    error: function (fn) {
        if (fn) {
            this.e("error", fn);
        }
        return this;
    },
    progress: function (fn) {
        if (fn) {
            this.e("progress", fn);
        }
        return this;
    },

    onAbort: function (fn) {
        if (fn) {
            this.e("onAbort", fn);
        }
        return this;
    },

    beforeSend: function (fn) {
        if (fn) {
            this.e("beforeSend", fn);
        }
        return this;
    },
    transform: function (fn) {
        if (fn) {
            this.e("transform", fn);
        }
        return this;
    },
    abort: function (fn) {
        return this.e("abort", fn || null);
    },
    cancel: function (fn) {
        return this.e("abort", fn || null);
    }
};


if (!XMLHttpRequest.prototype.sendAsBinary) {
    XMLHttpRequest.prototype.sendAsBinary = function (sData) {
        var nBytes = sData.length, ui8Data = new Uint8Array(nBytes);
        for (var nIdx = 0; nIdx < nBytes; nIdx++) {
            ui8Data[nIdx] = sData.charCodeAt(nIdx) & 0xff;
        }
        /* send as ArrayBufferView...: */
        this.send(ui8Data);
        /* ...or as ArrayBuffer (legacy)...: this.send(ui8Data.buffer); */
    };
}

var CrazyXHR = function (url, optionData) {

    var status = null;
    var self = this;

    var xhr = null;
    var isAbort = false;
    var properties = {
        status: 0,
        response: null,
        result: null,
        message: ""
    };

    var events = {
        done: [],
        error: [],
        progress: [],
        abort: [],
        beforeSend: [],
        transform: []
    };
    var options = optionData || {};

    setTimeout(function () {
        if (isAbort) {
            var ab = events.abort.length ? events.abort.shift() : emptyFunc;
            ab("Bị hủy");
            return;
        }
        var eventList = ["done", "success", "error", "transform", "progress", "beforeSend"];
        eventList.map(function (evt) {
            if (evt == "success") evt = "done";
            if (options[evt] && events[evt] != undefined && events[evt].length == 0 && isCallable(options[evt])) {
                events[evt].push(options[evt]);
            }
        });

        if (url) {
            if (isObject(url)) {
                options = url;
            }
            else {
                options.url = url;
            }
            var method = options.method ? options.method.toUpperCase() : "GET";
            var dataType = options.dataType || options.responseType || "";
            dataType = (dataType + "").toLowerCase();
            var sUrl = options.url || null;
            var headers = App.request.getHeaders();
            var data = options.data || options.body || {};
            var isUpload = options.isUpload || false;
            var responseType = options.responseType || dataType || "";
            responseType = (responseType + "").toLowerCase();
            if (["arraybuffer", "blob", "document", "json", "text"].indexOf(responseType) == -1) responseType = "";

            if(dataType == "json"){
                data = JSON.stringify(data);
            }
            else if (!isFormData(data) && (isArray(data) || isObject(data)) && !isUpload) data = App.request.toEncodedData(data);
            else if (isUpload) {
                var d = options.segments || data;
                data = d;
            }
            if (options.headers && isObject(options.headers)) {
                for (const key in options.headers) {
                    if (options.headers.hasOwnProperty(key)) {
                        const value = options.headers[key];
                        let k = App.request.strHeaderKey(key);
                        if (typeof headers[k] != "undefined") {
                            if (headers[k].indexOf(value) == -1) {
                                headers[k] += "; " + value;
                            }
                        } else {
                            headers[k] = value;
                        }
                    }
                }
            }

            if(dataType == "json"){
                headers["Content-Type"] = "application/json; charset=UTF-8";
            }
            else if(!Headers["Content-Type"] && isString(data)){
                headers["Content-Type"] = "application/x-www-form-urlencoded; charset=UTF-8";
            }
            if(!headers.Accept){
                headers.Accept = "application/json; text/javascript; text/html; */*";
            }

            
            xhr = new XMLHttpRequest();
            
            xhr.responseType = responseType;

            // progress on transfers from the server to the client (downloads)
            xhr.addEventListener("progress", function (oEvent) {
                if (oEvent.lengthComputable) {
                    var percentComplete = oEvent.loaded / oEvent.total * 100;
                    var pfn = events.progress.length ? events.progress[0] : emptyFunc;
                    pfn(percentComplete);
                } else {
                    // Unable to compute progress information since the total size is unknown
                }
            });
            // load thanh cong
            xhr.addEventListener("load", function (evt) {
                // console.log("The transfer finished (although we don't know if it succeeded or not).");
                var success = events.done.length ? events.done.shift() : (typeof options.success == "function" ? options.success : emptyFunc);
                var error = events.error.length ? events.error.shift() : (typeof options.error == "function" ? options.error : emptyFunc);
                var transform = events.transform.length ? events.transform.shift() : (typeof options.transform == "function" ? options.transform : null);
                var progress = events.progress.length ? events.progress.shift() : (typeof options.progress == "function" ? options.progress : emptyFunc);
                var d = responseType == "text" ? this.responseText : this.response;
                var data = transform ? transform(d) : d;
                properties.response = d;
                properties.result = data;
                properties.status = this.status;
                // kết quả trả về từ success
                var rs = success(data, this);
                if (rs !== undefined) {

                    var parseResult = function (result) {
                        if (result) {
                            // nếu là promiss hoặc xhr
                            if (result.constructor == CrazyXHR || (("Promise" in global) && result.constructor == Promise)) {
                                if (events.done.length) {
                                    do {
                                        result.then(events.done.shift());
                                    } while (events.done.length > 0);
                                }
                                if (events.error.length) {
                                    do {
                                        result.catch(events.error.shift());
                                    } while (events.error.length > 0);
                                } else {
                                    result.catch(error);
                                }
                                if (result.constructor == CrazyXHR) {
                                    if (events.transform.length) {
                                        do {
                                            result.transform(events.transform.shift());
                                        } while (events.transform.length > 0);
                                    }
                                    if (events.progress.length) {
                                        do {
                                            result.progress(events.progress.shift());
                                        } while (events.progress.length > 0);
                                    } else {
                                        result.progress(progress);
                                    }

                                }
                            }
                            else if (events.done.length) {
                                var succeeded = events.done.shift();
                                result = succeeded(result);
                            }
                        }
                        else if (events.done.length && result !== undefined) {
                            do {
                                var succeeded = events.done.shift();
                                result = parseResult(succeeded(result));
                                if (result === undefined) {
                                    events.done = [];
                                    break;
                                }
                            } while (events.done.length);
                        }
                        if (result === undefined) {
                            events.done = [];
                        }
                        return result;
                    }
                    // gọi hàm chuẩ kết quả
                    parseResult(rs);
                }

            });
            // lỗi
            xhr.addEventListener("error", function (evt) {
                var error = events.error.length ? events.error.shift() : emptyFunc;
                error(new Error("Lỗi không xác định"));
            });
            // hủy
            xhr.addEventListener("abort", function (evt) {
                properties.status = -1;
                var ab = events.abort.length ? events.abort.shift() : emptyFunc;
                ab(evt);
            });
            // kết thúc
            xhr.addEventListener("loadend", function (e) {

            });
            xhr.open(method, sUrl);
            for (const key in headers) {
                if (headers.hasOwnProperty(key)) {
                    const value = headers[key];
                    xhr.setRequestHeader(key, value);
                }
            }
            if (isUpload) {
                var sBoundary = "---------------------------" + Date.now().toString(16);

                var fdata = isArray(data) ? data.join("--" + sBoundary + "\r\n") : "";
                xhr.setRequestHeader("Content-Type", "multipart\/form-data; boundary=" + sBoundary);
                xhr.sendAsBinary("--" + sBoundary + "\r\n" + fdata + "--" + sBoundary + "--\r\n");
            } else {
                xhr.send(data);
            }

        } else {
            var error1 = events.error.length ? events.error.shift() : emptyFunc;
            error1(new Error("URL ko hợp lệ"));
        }
    }, 10);

    var methods = {
        set: function (prop, vai) {
            properties[prop] = value;
        },
        get: function (prop) {
            if (prop) {
                return typeof properties[prop] != "undefined" ? properties[prop] : null;
            }
            return properties;
        },
        done: function (fn) {
            if (typeof fn == "function") {
                events.done.push(fn);
            }
        },
        error: function (fn) {
            if (typeof fn == "function") {
                events.error.push(fn);
            }
        },
        onAbort: function (fn) {
            if (typeof fn == "function") {
                events.abort.push(fn);
            }
        },
        beforeSend: function (fn) {
            if (typeof fn == "function") {
                events.beforeSend.push(fn);
            }
        },
        progress: function (fn) {
            if (typeof fn == "function") {
                events.progress.push(fn);
            }
        },

        getXHR: function () {
            return xhr;
        },
        abort: function (fn) {
            isAbort = true;
            if (xhr) {
                xhr.abort();
                if (typeof fn == "function") {
                    return fn(xhr);
                }
            } else {
                if (typeof fn == "function") {
                    events.abort.push(fn);
                }
            }

        },
        transform: function (fn) {
            if (typeof fn == "function") {
                events.transform.push(fn);
            }
        },
        getEvents: function () {
            return events;
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


};


CrazyXHR.prototype = deepCopy(crazyRequestApi);
CrazyXHR.prototype.constructor = CrazyXHR;


// ajax

var CrazyAJAX = function (url, optionData) {
    var status = null;
    var self = this;

    var $ajax = null;
    var isAbort = false;
    var properties = {
        status: 0,
        response: null,
        result: null,
        message: ""
    };

    var events = {
        done: [],
        error: [],
        progress: [],
        abort: [],
        beforeSend: [],
        transform: []
    };

    var options = typeof url == "object" ? url : (typeof optionData == "object" ? optionData : {});

    setTimeout(function () {
        if (isAbort) {
            var ab = events.abort.length ? events.abort.shift() : emptyFunc;
            ab("Bị hủy");
            return;
        }


        if (url) {

            if (!isObject(url)) {
                options.url = url;
            }
            var eventList = ["done", "success", "error", "transform", "progress", "beforeSend"];
            eventList.map(function (evt) {
                if (evt == "success") evt = "done";
                if (options[evt] && events[evt] != undefined && events[evt].length == 0 && isCallable(options[evt])) {
                    events[evt].push(options[evt]);
                }
            });

            var data = options.data || options.body || {};
            var method = options.method || options.type || "GET";
            method = method.toUpperCase();
            var sUrl = options.url || null;

            var responseType = options.responseType || options.dataType || "JSON";
            responseType = (responseType + "").toLowerCase();
            if (["arraybuffer", "blob", "document", "json", "text"].indexOf(responseType) == -1) responseType = "JSON";



            var ajaxData = {
                url: sUrl,
                type: method,
                cookie: true,
                data: data
            };
            if (options.headers) {
                ajaxData.headers = options.headers;
            }
            if (responseType) {
                ajaxData.dataType = responseType;
            }
            ajaxData.success = function (res) {
                // console.log("The transfer finished (although we don't know if it succeeded or not).");
                var success = events.done.length ? events.done.shift() : (typeof options.success == "function" ? options.success : emptyFunc);
                var error = events.error.length ? events.error.shift() : (typeof options.error == "function" ? options.error : emptyFunc);
                var transform = events.transform.length ? events.transform.shift() : (typeof options.transform == "function" ? options.transform : null);
                var progress = events.progress.length ? events.progress.shift() : (typeof options.progress == "function" ? options.progress : emptyFunc);
                var d = res;
                var data = transform ? transform(d) : d;
                properties.response = d;
                properties.result = data;
                // kết quả trả về từ success
                var rs = success(data);
                if (rs !== undefined) {

                    var parseResult = function (result) {
                        if (result) {
                            // nếu là promiss hoặc xhr
                            if (result.constructor == CrazyXHR || (("Promise" in global) && result.constructor == Promise) || result.constructor == CrazyAJAX) {
                                if (events.done.length) {
                                    do {
                                        result.then(events.done.shift());
                                    } while (events.done.length > 0);
                                }
                                if (events.error.length) {
                                    do {
                                        result.catch(events.error.shift());
                                    } while (events.error.length > 0);
                                } else {
                                    result.catch(error);
                                }
                                if (result.constructor == CrazyXHR || result.constructor == CrazyAJAX) {
                                    if (events.transform.length) {
                                        do {
                                            result.transform(events.transform.shift());
                                        } while (events.transform.length > 0);
                                    }
                                    if (events.progress.length) {
                                        do {
                                            result.progress(events.progress.shift());
                                        } while (events.progress.length > 0);
                                    } else {
                                        result.progress(progress);
                                    }

                                }
                            }
                            else if (events.done.length) {
                                var succeeded = events.done.shift();
                                result = succeeded(result);
                            }
                        }
                        else if (events.done.length && result !== undefined) {
                            do {
                                var succeeded = events.done.shift();
                                result = parseResult(succeeded(result));
                                if (result === undefined) {
                                    events.done = [];
                                    break;
                                }
                            } while (events.done.length);
                        }
                        if (result === undefined) {
                            events.done = [];
                        }
                        return result;
                    }
                    // gọi hàm chuẩ kết quả
                    parseResult(rs);
                }
            };

            ajaxData.error = function (err) {
                var error1 = events.error.length ? events.error.shift() : emptyFunc;
                error1(err);
            };
            $ajax = global.jQuery.ajax(ajaxData);


        } else {
            var error1 = events.error.length ? events.error.shift() : emptyFunc;
            error1(new Error("URL ko hợp lệ"));
        }
    }, 10);

    var methods = {
        set: function (prop, vai) {
            properties[prop] = value;
        },
        get: function (prop) {
            if (prop) {
                return typeof properties[prop] != "undefined" ? properties[prop] : null;
            }
            return properties;
        },
        done: function (fn) {
            if (typeof fn == "function") {
                events.done.push(fn);
            }
        },
        error: function (fn) {
            if (typeof fn == "function") {
                events.error.push(fn);
            }
        },
        onAbort: function (fn) {
            if (typeof fn == "function") {
                events.abort.push(fn);
            }
        },
        beforeSend: function (fn) {
            if (typeof fn == "function") {
                events.beforeSend.push(fn);
            }
        },
        progress: function (fn) {
            if (typeof fn == "function") {
                events.progress.push(fn);
            }
        },

        getXHR: function () {
            return $ajax;
        },
        abort: function (fn) {
            isAbort = true;
            if (xhr) {
                xhr.abort();
                if (typeof fn == "function") {
                    return fn(xhr);
                }
            } else {
                if (typeof fn == "function") {
                    events.abort.push(fn);
                }
            }

        },
        transform: function (fn) {
            if (typeof fn == "function") {
                events.transform.push(fn);
            }
        },
        getEvents: function () {
            return events;
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


};

CrazyAJAX.prototype = deepCopy(crazyRequestApi);
CrazyAJAX.prototype.constructor = CrazyAJAX;

App.xhr = App.prototype.xhr = function (url, optionData) {
    if (typeof url == "undefined") return new Faker();
    return new CrazyXHR(url, optionData || {});
}

/**
 * fetch data
 */
App.fetch = App.prototype.fetch = function (url, optionData) {
    if (typeof url == "undefined") return new Faker();
    var data = typeof url == "object" ? url : (typeof optionData == "object" ? optionData : {});
    if (!('fetch' in global)) {
        return App.xhr(url, data);
    }
    if (isObject(url)) {
        date = url;
        url = data.url || null;

    }// set các tham so
    data.headers = new Headers(merge(App.request.getHeaders(), data.headers || {}));
    data.body = data.body || data.data || data.segments || null
    // header, abc 
    var f = fetch(url, data);
    if (typeof data.success == "function") {
        f.then(data.success);
    }
    if (typeof data.error == "function") {
        f.catch(data.error);
    }
    return f;
}

App.ajax = App.prototype.ajax = function (url, optionData) {
    if (typeof url == "undefined") return new Faker();

    var data = typeof url == "object" ? url : (typeof optionData == "object" ? optionData : {});

    if (!('jQuery' in global)) {
        return App.xhr(url, data);
    }
    if (isString(url)) {
        data.url = url;
    }
    data.headers = merge(App.request.getHeaders(), data.headers || {});
    // làm gì đó
    return new CrazyAJAX(data);
}



App.axios = App.prototype.axios = function (url, optionData) {
    if (typeof url == "undefined") return new Faker();
    var data = optionData || {};
    if (!('axios' in global)) {
        return App.xhr(url, data);
    }
    if (isObject(url)) {
        date = url;
        url = data.url || null;
    } else if (isString(url)) {
        data.url = url;
    }
    data.headers = merge(App.request.getHeaders(), data.headers || {});

    var success, error;
    if (typeof data.success == "function") {
        success = data.success;
        delete data.success;
    }
    if (typeof data.error == "function") {
        error = data.error;
        delete data.error;
    }

    // làm gì đó

    var axiosPromiss = global.axios(url, data);
    if (success) {
        axiosPromiss.then(success);
    }
    if (error) {
        axiosPromiss.catch(error);
    }
    return axiosPromiss;
}




App.axiosUpload = App.prototype.axiosUpload = function (url, data, optionData) {
    if (typeof url == "undefined") return new Faker();
    var options = optionData || {};
    var body = null;
    if (isObject(url)) {
        options = url;
        url = options.url || null;
        body = options.body || options.data || data || null;
    } else if (isString(url)) {
        if (optionData) {
            body = data;
        } else {
            if (isFormData(data)) {
                body = data;
            } else if (data.body || data.data) {
                body = data.body || data.data;
                if (typeof data.body != "undefined") delete data.body;
                if (typeof data.data != "undefined") delete data.data;
                options = data;
            } else {
                body = options;
            }
        }
    }

    if (!('axios' in global)) {
        options.data = body;
        options.url = url;
        return App.xhr(options);
    }
    options.headers = merge(App.request.getHeaders(), options.headers || {});

    var success, error;
    if (typeof options.success == "function") {
        success = options.success;
        delete options.success;
    }
    if (typeof options.error == "function") {
        error = options.error;
        delete options.error;
    }

    var axiosPromiss = global.axios.post(url, body, options);
    if (success) {
        axiosPromiss.then(success);
    }
    if (error) {
        axiosPromiss.catch(error);
    }
    return axiosPromiss;
}



App.request = App.prototype.request = {
    headers: {},
    engine: "xhr",
    engineList: ["xhr", "axios", "fetch", "ajax"],
    setHeaders: function (key, value) {
        if (!key) return this;
        if (isString(key)) {
            key = this.strHeaderKey(key);
            if (value) {

                if (typeof this.headers[key] == "undefined") {
                    this.headers[key] = [];
                }
                if (this.headers[key].indexOf(value) == -1) {
                    this.headers[key].push(value);
                }
            }
        } else if (isObject(key)) {
            var s;
            for (const k in key) {
                if (key.hasOwnProperty(k)) {
                    const v = key[k];
                    // s = this.strHeaderKey(k);
                    this.setHeaders(k, v);
                }
            }
        }
        return this;
    },
    getHeaders: function () {
        var headers = {};
        for (const key in this.headers) {
            if (this.headers.hasOwnProperty(key)) {
                const values = this.headers[key];
                headers[key] = values.join("; ");
            }
        }
        return headers;
    },
    toFormData: function (data) {
        var f = new FormData();
        if (typeof data == "undefined") return f;
        if (isFormData(data)) return data;
        if (data) {
            if (isObject(data)) {
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const value = data[key];
                        f.append(key, value);
                    }
                }
            } else if (isArray(data)) {
                data.map(function (d) {
                    if (isObject(d) && d.name && typeof d.value != "undefined") {
                        f.append(d.name, d.value);
                    }
                });
            }
        }
        return f;
    },
    strHeaderKey: function (key) {
        return App.str.replace(App.str.ucword(App.str.replace(key, "-", " ")), " ", "-");
    },
    toEncodedData: function (data) {
        var s = [];
        var addData = function (d) {
            if (d && isObject(d)) {
                for (const fn in d) {
                    if (d.hasOwnProperty(fn)) {
                        const dat = d[fn];
                        if (isArray(dat)) {
                            if (dat && dat.length) {
                                for (let i = 0; i < dat.length; i++) {
                                    const d = dat[i];
                                    if(isArray(d)){
                                        var fname = fn.substring(fn.length - 2) == '[]' ? fn : fn+'[]';
                                        for (let j = 0; j < d.length; j++) {
                                            const vd = d[j];
                                            s.push(encodeURIComponent(fname) + "=" + encodeURIComponent(vd));
                                        }
                                    }else{
                                        s.push(encodeURIComponent(fn) + "=" + encodeURIComponent(d));
                                    }
                                }
                            }
                        } else {
                            if(isArray(dat)){
                                var fname = fn.substring(fn.length - 2) == '[]' ? fn : fn+'[]';
                                for (let j = 0; j < dat.length; j++) {
                                    const vd = dat[j];
                                    s.push(encodeURIComponent(fname) + "=" + encodeURIComponent(vd));
                                }
                            }else{
                                s.push(encodeURIComponent(fn) + "=" + encodeURIComponent(dat));
                            }

                            
                        }
                    }
                }

            }
        }
        if (isObject(data)) addData(data);
        else if (isArray(data)) {
            data.map(function (t) {
                if (t.name && typeof t.value != "undefined") {
                    var d = {};
                    d[t.name] = t.value;
                    addData(d);
                } else {
                    addData(t);
                }

            })
        }
        return s.join("&");
    },
    setEngine: function (engine) {
        if (engine && isString(engine)) {
            var eng = engine.toLowerCase();
            if (this.engineList.indexOf(eng) >= 0) {
                this.engine = eng;
            }
        }
        return this;
    },
    getEngine: function () {
        var eng = this.engine.toLowerCase();
        var engineFunc = this.engineList.indexOf(eng) >= 0 ? App[eng] : App.xhr;
        return engineFunc;
    }
};

httpMethods.map(function (method) {
    var mt = method.toUpperCase();
    /**
     * gửi request dạng {mt} 
     * @param {string|option} url url hoặc option
     * @param {object|null|undefined} options tham số tùy chọn
     */

    App.request[method] = function (url, options) {
        if (typeof url == "undefined") return new Faker();
        var data = options || {};
        if (isObject(url)) {
            date = deepCopy(url);
            url = data.url || null;
        }
        data.method = mt;
        return this.getEngine()(url, data);
    }
});

App.request.axiosUpload = App.axiosUpload;


App.request.queryString = function queryString(key) {
    var pairs = window.location.search.substring(1).split("&"),
        obj = {},
        pair,
        i;

    for (i in pairs) {
        if (pairs.hasOwnProperty(i)) {
            if (pairs[i] === "") continue;

            pair = pairs[i].split("=");
            obj[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);

        }
    }

    if(typeof key != "undefined"){
        return typeof obj[key] != "undefined" ? obj[key] : null;
    }
    return obj;
};