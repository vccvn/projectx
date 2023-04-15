/**
 * quản lý form
 */



var Form = App.dom.Form = function (selector, opts) {
    var elements = this.getDomElements(selector);
    let n = 0;
    for (let index = 0; index < elements.length; index++) {
        const el = elements[index];
        this[n] = el;
        n++;
    }
    this.length = n;
    var current = this.length ? this[0] : null;


    var $data = {};
    var self = this;
    var options = {
        url: null,
        submitType: 'redirect',
        dataType: null,
        validate: null,
        method: null,
        test: ""
    };
    var eventListeners = {};
    var methods = {
        all: function () {
            return elements;
        },
        el: function (num) {
            if (typeof num == "undefined") {
                return self.length ? self[0] : null
            } else if (isNumber(num)) {
                return (typeof self[num] != "undefined") ? self[num] : null;
            }
            return null;
        },
        form: function (num) {
            if (typeof num == "undefined") {
                num = this.getCurrentIndex();
                return self.length < 2 ? self : self.get(num);
            } else if (isNumber(num)) {
                return (typeof self[num] != "undefined") ? App.query(self[num]) : App.query();
            }
            else if (num == 'all') {
                return $form;
            }
            App.query();
        },
        setCurrent: function (element) {
            if (element && element instanceof Element) current = element;
            return self;
        },
        getCurrent: function () {
            return current;
        },
        getCurrentIndex: function () {
            var index = -1;
            if (current) {
                for (let i = 0; i < elements.length; i++) {
                    const element = elements[i];
                    if (element == current) {
                        index = i;
                        break;
                    }
                }
            }
            return index;
        },
        getCurrentData: function () {
            var ci = this.getCurrentIndex();
            return (ci >= 0 && typeof $data[ci] != "undefined") ? $data[ci] : null;
        },
        updateCurrentData: function (data) {
            var ci = this.getCurrentIndex();
            if (ci >= 0 && typeof $data[ci] != "undefined") {
                $data[ci] = data;
            }
        },
        get: function (key) {
            var d = this.getCurrentData();
            if (d == null) return null;
            if (typeof key == "undefined") {
                return d.data;
            } else if (isString(key)) {
                return (typeof d.data[key] != "undefined") ? d.data[key] : null;
            }
            return null;
        },
        set: function (key, value) {
            var d = this.getCurrentData();
            if (d == null) return self;
            if (typeof key == "undefined") {
                return self;
            } else if (isString(key)) {
                d.data[key] = value;
            }
            else if (isObject(key)) {
                for (const k in key) {
                    if (key.hasOwnProperty(k)) {
                        const v = key[k];
                        d.data[k] = v;
                    }
                }
            }
            this.updateCurrentData(d);
            return this;
        },
        getFile: function (key) {
            var d = this.getCurrentData();
            if (d == null) return [];
            if (typeof key == "undefined") {
                return d.filedata;
            } else if (isString(key)) {
                return (typeof d.filedata[key] != "undefined") ? d.filedata[key] : [];
            }
            return [];
        },
        setFile: function (key, value) {
            var d = this.getCurrentData();
            if (d == null || typeof key == "undefined") return self;
            else if (isString(key)) {
                d.filedata[key] = value;
            }
            else if (isObject(key)) {
                for (const k in key) {
                    if (key.hasOwnProperty(k)) {
                        const v = key[k];
                        d.filedata[k] = v;
                    }
                }
            }
            this.updateCurrentData(d);
            return self;
        },
        getEvent: function (event) {
            if (typeof event == "undefined") {
                return eventListeners;
            } else if (isString(event)) {
                return (typeof eventListeners[event] != "undefined") ? eventListeners[event] : null;
            }
            return null;
        },
        addEvent: function (event, handler) {
            if (typeof event == "undefined") {
                return self;
            } else if (isString(event) && typeof handler == "function") {
                eventListeners[event] = handler;
            }
            else if (isObject(event)) {
                for (const k in event) {
                    if (key.hasOwnProperty(k)) {
                        const v = event[k];
                        if (typeof v == "function")
                            eventListeners[k] = v;
                    }
                }
            }
            return this;
        },
        setOption: function (key, value) {
            if (typeof key == "undefined") return this;
            if (isObject(key)) {
                for (const k in key) {
                    const v = key[k];
                    if (key.hasOwnProperty(k)) {
                        if (["done", "error", "then", "catch", "transform", "beforeSenf"].indexOf(k) != -1) {
                            if (typeof v == "function") {
                                if (typeof self[k] == "function") {
                                    self[k].call(self, v);
                                }
                            }
                        } else {

                            options[k] = v;
                        }

                    }
                }
            } else if (typeof value != "undefined") {
                if (["done", "error", "then", "catch", "transform", "beforeSenf"].indexOf(key) != -1) {
                    if (typeof value == "function") {
                        if (typeof self[key] == "function") {
                            self[key].call(self, value);
                        }
                    }
                } else {
                    options[key] = value;
                }

            }
        },
        getOption: function (key) {
            if (typeof key == "undefined") return options;
            return ((isString(key) || isNumber(key)) && typeof options[key] != "undefined") ? options[key] : null;
        },
        getContext: function () {
            return self;
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

    methods.setOption(opts);

    this.off("submit").on("submit", function (e) {
        self.e("setCurrent", e.target);
        try {
            var rs = self.onSubmit(e);
            if (methods.getOption("submitType") == "redirect") {
                return rs;
            }
            else {
                e.preventDefault();
                return false;
            }

        } catch (error) {
            cl(error)
            return false;
        }

    });

    this.off("change").on("change", function (e) {
        self.e("setCurrent", App.query(e.target).closest("form")[0]);
        return self.onChange(e);
    });

    for (let i = 0; i < elements.length; i++) {
        const f = elements[i];
        $data[i] = {
            data: {},
            filedata: {}
        };
    }
    $data.length = elements.length;
};

Form.prototype = deepCopy(DomQuery.prototype, {
    constructor: App.dom.Form,
    /**
     * Lắng nghe sự kiện change
     * @param {Event} e 
     */
    onChange: function (e) {
        var self = this;
        var tag = e.target;
        var tagname = tag.tagName.toLowerCase();
        var type = tag.type.toLowerCase();
        var $form = this.e("form");
        if (["input", "textarea", "select"].indexOf(tagname) >= 0) {
            if ((this.e("getOption", "serializeFile") || $form.attr("submit-type") == "ajax") && type == "file") {
                var test = App.files.readFileInput(tag, function (list) {
                    self.e("setFile", tag.name, list);
                });
            }

        }
    },
    /**
     * Lắng nghe sự kiện submit
     * @param {Event} e sự kiện
     */
    onSubmit: function (e) {
        // lấy môi trường thực thi
        var self = this.e("getContext");
        // lấy sự kiện đính kèm
        var handler = this.e('getEvent', 'submit');
        // lấy form hiện tại
        var currentForm = this.e("getCurrent") || e.target;
        // kết quả dược trả về từ handle sự kiễm submit
        var rs = null;

        try {
            // các thiết lập form
            var options = self.e("getOption");

            var $form = App.query(currentForm); // dối dome query không phải jquery
            // kiểu gửi data
            var submitType = $form.data("submit-type") || $form.attr("submit-type") || options.submitType || "redirect";
            submitType = submitType.toLowerCase();
            var firstSubmitType = submitType;

            var validateData = this.e("getOption", "validate") || this.e("getOption", "validation");
            if(typeof validateData.rules == "object"){
                var vs = this.validate(
                    validateData.rules,
                    typeof validateData.messages == "object"? validateData.messages : {},
                    typeof validateData.fails == "function" ? validateData.fails : function(validator){
                        cl(validator);
                    }
                );
                if(!vs){
                    e.preventDefault();
                    return false;
                }
            }
            
            // nếu  sử dụng form api
            if (isCallable(handler)) {
                rs = handler.apply(currentForm, [e]);
            }
            if (["fetch", "api", "ajax", "xhr", "axios"].indexOf(submitType) == -1) {
                return rs;
            }
            if (submitType == "ajax" && !globalThis.jQuery && $form.attr("submit-type") == "ajax") {
                $form.attr("submit-type", "xhr");
                submitType = "xhr";
            }

            // dường dẫn gửi data
            var url = $form.attr("submit-url") || $form.attr("ajax-url") || $form.data("ajax-url") || options.url || $form.attr("action");

            // kiểu data gửi đi
            var dataType = $form.data("type") || options.dataType || "raw";
            dataType = isString(dataType) ? dataType.toLowerCase() : "raw";

            // phương thức
            var method = options.method || $form.attr("method");
            method = isString(method) ? method.toUpperCase() : "GET";

            // kiểm tra hợp lệ
            if (["POST", "PUT", "PATCH", "DELETE", "OPTIONS", "GET", "HEAD"].indexOf(method) === -1) method = "GET";


            var IsPost = method.toLowerCase() === "post";
            /* console.log("AJAXSubmit - Serializing form..."); */
            var contentType = IsPost && currentForm.enctype ? currentForm.enctype : "application/x-www-form-urlencoded";

            var isUpload = contentType.toLowerCase() == "multipart/form-data" || options.isUpload || false;

            // thân form
            var body = null;


            var responseType = $form.attr("response-type") || options.responseType || "";
            responseType = (responseType + "").toLowerCase();
            if (["arraybuffer", "blob", "document", "json", "text"].indexOf(responseType) == -1) responseType = "";
            // content type
            var contentTypes = [];
            var accept = [];

            if (method == "GET" || dataType == "encoded") {
                body = self.serialize();
                contentTypes.push("application/x-www-form-urlencoded", "charset=UTF-8")
                if (method == "GET") url += ((url.indexOf("?") >= 0) ? "&" : "?") + body;
            }
            else if (!isUpload || submitType == "ajax") {
                body = self.serializeArray();
                if (submitType != "ajax") {
                    accept.push("application/json", "text/javascript", "text/html");
                }
            }
            else if (!isUpload && dataType == "json") {
                contentTypes.push("application/json");
                accept.push("application/json")
                body = self.serializeObject();
            }
            else {
                body = self.toFormData();
                accept.push("application/json", "text/javascript", "text/html");
            }



            var headers = {};
            if (contentTypes.length) {
                headers['Content-type'] = contentTypes.join("; ");
            }

            if (responseType == "json" && accept.indexOf("application/json") == -1) {
                accept.push("application/json");
            }

            if (accept.length) {
                headers.Accept = accept.join("; ")
            }
            var eventListeners = self.e("getEvent");
            var success = eventListeners.success || emptyFunc;
            var error = eventListeners.error || emptyFunc;
            var transform = eventListeners.transform || function (rs) { return rs; };
            var beforeSend = eventListeners.beforeSend || emptyFunc;

            var params = {
                method: method, // 'GET', 'PUT', 'DELETE', etc.
                responseType: responseType,
                success: success,
                error: error,
                transform: transform,
                beforeSend: beforeSend,
                requestApi: firstSubmitType
            };
            if (headers) {
                params.headers = headers;
            }

            if (submitType == "fetch" || submitType == "api") {
                params.credentials = "same-origin";
                params.headers = new Headers(headers);
                if (["GET", "HEAD"].indexOf(method) == -1) {
                    if (dataType == "json") body = JSON.stringify(body);
                    params.body = body;
                }
                var fetchdata = App.fetch(url, params);
            }
            else if (submitType == "xhr" || !submitType) {
                var xhr;
                if (["GET", "HEAD"].indexOf(method) == -1) {
                    params.body = body;
                }
                xhr = App.xhr(url, params);
            }
            else if (submitType == "axios") {
                var axiosData;
                if (isUpload) {
                    axiosData = App.axiosUpload(url, body, params);
                } else {
                    params.body = body;
                    axiosData = App.axios(url, params);
                }

            }
            else if (submitType == "ajax") {
                var ajax;

                params.data = body;
                params.url = url;
                ajax = App.ajax(params);

            }

        } catch (error) {
            cl(error);
            e.preventDefault();
        }



        e.preventDefault();
        return false;

    },
    segments: [],
    fileload: 0,
    fileloadSuccess: 0,
    readComplete: false,
    callback: cl,
    segmentList: [],
    segmentsDone: function () {
        var self = this;
        if (self.fileload == self.fileloadSuccess && !self.readComplete) {
            self.callback(self.segments.map(function (t) {
                return t;
            }));
            self.readComplete = true;
        }

    },
    pushSegments: function (form, callback) {
        var self = this;
        self.segments = [];
        self.segmentList = [];
        self.fileload = 0;
        self.fileloadSuccess = 0;
        self.readComplete = false;
        if (!form) return;
        if (isCallable(form)) {
            callback = form;
            form = self.e("getCurrent");
        }
        if (!callback || !isCallable(callback)) {
            callback = cl;
        }

        self.callback = callback;
        var elements = form.elements;
        var elength = elements.length;
        var field, n, oFile, fileReader, sFieldType;
        function onFileLoad(oFREvt) {
            this.owner.segments[this.segmentIdx] += oFREvt.target.result + "\r\n";
            self.fileloadSuccess++;
            self.segmentList.push(this.segmentIdx);
            self.segmentsDone();

        }
        for (var i = 0; i < elength; i++) {
            field = elements[i];
            if (!field.hasAttribute("name") || field.disabled) { continue; }

            sFieldType = field.nodeName.toUpperCase() === "INPUT" ? field.getAttribute("type").toUpperCase() : "TEXT";
            if (sFieldType === "FILE" && field.files.length > 0) {

                /* enctype is multipart/form-data */
                for (n = 0; n < field.files.length; n++) {
                    oFile = field.files[n];
                    fileReader = new FileReader();
                    /* (custom properties:) */
                    fileReader.segmentIdx = this.segments.length;
                    fileReader.owner = this;
                    /* (end of custom properties) */
                    fileReader.onload = onFileLoad;
                    this.segments.push("Content-Disposition: form-data; name=\"" +
                        field.name + "\"; filename=\"" + oFile.name +
                        "\"\r\nContent-Type: " + oFile.type + "\r\n\r\n");
                    self.fileload++;
                    fileReader.readAsBinaryString(oFile);
                }

            }
            else if ((sFieldType !== "RADIO" && sFieldType !== "CHECKBOX") || field.checked) {
                this.segments.push(
                    "Content-Disposition: form-data; name=\"" + field.name + "\"\r\n\r\n" + field.value + "\r\n"

                );
            }
        }
        if (self.fileload == self.fileloadSuccess) {
            self.segmentsDone();
        }

    },

    hasFile: function () {
        var form = this.e("getCurrent");
        var elements = form.elements;
        var elength = elements.length;

        if (elength == 0) return false;

        for (var i = 0; i < elength; i++) {
            var field = elements[i];
            if (field.type === 'file') {
                if (field.files.length) {
                    return true;
                }

            }
        }
        return true;
    },
    toFormData: function () {

        var form = this.e("getCurrent");
        // Setup our serialized data
        var formData = new FormData();
        // Loop through each field in the form
        for (var i = 0; i < form.elements.length; i++) {
            var field = form.elements[i];
            // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
            if (!field.name || field.disabled || field.type === 'reset' || field.type === 'button') continue;
            if (field.type === 'file') {
                let files = field.files;
                if (files.length) {
                    for (let j = 0; j < files.length; j++) {
                        const file = files[j];
                        formData.append(field.name, file);
                    }
                }
            }
            // If a multi-select, get all selections
            else if (field.type === 'select-multiple') {
                for (var n = 0; n < field.options.length; n++) {
                    if (!field.options[n].selected) continue;
                    formData.append(field.name, field.options[n].value);
                }
            }

            // Convert field data to a query string
            else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
                formData.append(field.name, field.value);
            }
        }
        return formData;

    },
    getValidateData: function () {

        var form = this.e("getCurrent");
        // Setup our serialized data
        var formData = {};
        var addDataValue = function (field, value) {
            if (!field) return;
            var slug = App.str.formSlug(field.name);
            if (typeof formData[slug] == "undefined") {
                formData[slug] = {
                    el: field,
                    name: field.name,
                    type: field.type,
                    value: value
                };
                return true;
            }
            if (!isArray(formData[slug].value)) {
                formData[slug].value = [formData[slug].value];
            }
            formData[slug].value.push(value);
        }
        // Loop through each field in the form
        for (var i = 0; i < form.elements.length; i++) {
            var field = form.elements[i];
            var inputType = field.type.toLowerCase();
            // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
            if (!field.name || field.disabled || field.type === 'reset' || field.type === 'button') continue;
            if (field.type === 'file') {
                let files = field.files;
                var fieldvals = [];
                if (files.length) {
                    for (let j = 0; j < files.length; j++) {
                        const file = files[j];
                        fieldvals.push({ name: file.name, type: file.type, size: file.size });
                    }
                }
                addDataValue(field, fieldvals);
            }
            // If a multi-select, get all selections
            else if (field.type === 'select-multiple') {
                var fieldvals = [];
                for (var n = 0; n < field.options.length; n++) {
                    if (!field.options[n].selected) continue;
                    fieldvals.push(field.options[n].value);
                }
                addDataValue(field, fieldvals);
            }

            // Convert field data to a query string
            else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
                addDataValue(field, field.value);
            }
        }
        return formData;

    },
    serialize: function (serializeFile) {
        serializeFile = typeof serializeFile == "undefined" ? null : serializeFile;
        var self = this;
        var $form = this.e("form");
        var form = self.e("getCurrent");
        // Setup our serialized data
        var serialized = [];

        // Loop through each field in the form
        for (var i = 0; i < form.elements.length; i++) {

            var field = form.elements[i];

            // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
            if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

            // If a multi-select, get all selections
            if (field.type === 'select-multiple') {
                for (var n = 0; n < field.options.length; n++) {
                    if (!field.options[n].selected) continue;
                    serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[n].value));
                }
            }

            // Convert field data to a query string
            else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
                serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
            }
        }
        if (this.e("getOption", "serializeFile")) {
            var filedata = self.e("getFile");
            if (filedata) {
                for (const fn in filedata) {
                    if (filedata.hasOwnProperty(fn)) {
                        const data = filedata[fn];
                        if (isArray(data)) {
                            if (data && data.length) {
                                for (let i = 0; i < data.length; i++) {
                                    const d = data[i];
                                    serialized.push(encodeURIComponent(fn) + "=" + encodeURIComponent(d));
                                }
                            }
                        } else {
                            serialized.push(encodeURIComponent(fn) + "=" + encodeURIComponent(data));
                        }

                    }
                }
            }
        }

        return serialized.join('&');
    },
    serializeArray: function (serializeFile) {
        serializeFile = typeof serializeFile == "undefined" ? null : serializeFile;
        var self = this;
        var form = self.e("getCurrent");
        var $form = self.e("form");

        var serialized = [];
        // Loop through each field in the form
        for (var i = 0; i < form.elements.length; i++) {
            var field = form.elements[i];
            // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
            if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'button') continue;
            // If a multi-select, get all selections
            if (field.type === 'select-multiple') {
                for (var n = 0; n < field.options.length; n++) {
                    if (!field.options[n].selected) continue;
                    serialized.push({
                        name: field.name,
                        value: field.options[n].value
                    });
                }
            }

            // Convert field data to a query string
            else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
                serialized.push({
                    name: field.name,
                    value: field.value
                });
            }
        }

        if (this.e("getOption", "serializeFile") || $form.attr("submit-type") == "ajax" || this.e("getOption", "submitType") == "ajax") {
            var filedata = self.e("getFile");
            if (filedata) {
                for (const fn in filedata) {
                    if (filedata.hasOwnProperty(fn)) {
                        const data = filedata[fn];

                        if (data && data.length) {
                            serialized.push({
                                name: fn,
                                value: data
                            });
                        }
                    }
                }

            }
        }
        return serialized;
    },
    serializeObject: function () {
        var serialized = this.serializeArray();
        var data = {};
        serialized.map(function (inp) {
            if(typeof data[inp.name] != undefined){
                if(App.getType(data[inp.name] == 'array')){
                    data[inp.name].push(inp.value);
                }else{
                    data[inp.name] = [data[inp.name]];
                }
            }else{
                data[inp.name] = inp.value;
            }
        });
        return data;
    },
    formdata: function () {
        var self = this;
        var $form = this.e("form");
        var $data = $form.formdata();
        return $data;
    },
    /**
     * submit hoặc thêm sự kiện
     * @param {function} fn 
     */
    submit: function (fn) {
        if (typeof fn == "undefined") {
            var form = this.e('form');
            if (form.length) {
                form[0].submit();
            }
        } else if (isCallable(fn)) {
            this.e('addEvent', 'submit', fn);
        }
        return this;
    },
    /**
     * thêm sự kiện
     * @param {function} fn 
     */
    change: function (fn) {
        if (typeof fn == "undefined") {
            return this;
        } else if (isCallable(fn)) {
            this.e('addEvent', 'change', fn);
        }
        return this;
    },
    done: function (fn) {
        if (typeof fn != "undefined" && isCallable(fn)) {
            this.e('addEvent', 'success', fn);
        }
        return this;
    },
    success: function (fb) {
        return this.done.apply(this, arguments);
    },
    then: function (fb) {
        return this.done.apply(this, arguments);
    },
    transform: function (fn) {
        if (typeof fn != "undefined" && isCallable(fn)) {
            this.e('addEvent', 'transform', fn);
        }
        return this;
    },
    beforeSend: function (fn) {
        if (typeof fn != "undefined" && isCallable(fn)) {
            this.e('addEvent', 'beforeSend', fn);
        }
        return this;
    },

    error: function (fn) {
        if (typeof fn != "undefined" && isCallable(fn)) {
            this.e('addEvent', 'error', fn);
        }
        return this;
    },
    catch: function (fb) {
        return this.error.apply(this, arguments);
    },
    setOption: function (key, value) {
        var k = key || null,
            v = (typeof value != "undefined") ? value : null;
        if (k) {
            this.e("setOption", k, v);
        }
        return this;
    },
    /**
     * thêm các rule để validate
     * @param {object} rules thêm các rule để validate
     */
    validate: function (rules, messages, fails) {
        var validateData = this.e("getOption", "validate") || this.e("getOption", "validation");
        var isValidate = typeof validateData == "object";
        var r = typeof rules == "object"? rules: ((isValidate && typeof validateData.rules == "object")?validateData.rules:null)
        var m = typeof messages == "object"?messages:((isValidate && typeof validateData.messages == "object")?validateData.messages:{});
        if(!r) return true;
        var validator = Validator.make(this.getValidateData(), r, m);
        if(!validator.status){
            var f = typeof fails == "function"?fails:(
                typeof rules == "function" ? rules : (
                    typeof messages == "function" ? messages : (
                        (isValidate && typeof validateData.fails == "function")?validateData.fails:emptyFunc
                    )
                )
            );
            f.call(this, validator);
        }
        return validator.status;
        
    },
    /**
     * thao tác trước khi gọi api
     * @param {function} callback 
     */
    beforeSend: function (callback) {
        this.e("addEvent", "beforeSend", callback);
        return this;
    }

});



App.addQueryModule("form", function (options) {
    return new App.dom.Form(this.getElements(), options || {});
});


App.form = App.prototype.form = function (selector, options) {
    var s = selector || null,
        o = options || {};
    return new App.dom.Form(s, 0);
};




App.files = App.prototype.files = {
    data: {},
    readFileInput: function (input, callback) {
        if (!input || !(input instanceof Element) || input.type != "file") return null;
        var tagname = input.tagName.toLowerCase();
        var type = input.type.toLowerCase();
        var self = this;
        var dataList = [];
        var segments = [];
        var files = input.files;
        if (window.File && window.FileList && window.FileReader && files && files.length) {

            var l = files.length;
            var base64 = false;
            var binary = false;

            for (var i = 0; i < l; i++) {
                (function (file, index, coumt) {
                    let fileReader = new FileReader();
                    fileReader.onload = function (f) {
                        let src = f.target.result;
                        dataList.push(src);
                        if (index == coumt) {
                            if (!input.multiple) dataList = dataList.length ? dataList[0] : null;
                            self.data[input.name] = dataList;
                            if (callback && isCallable(callback)) {
                                callback(dataList);
                            }
                        }
                    };
                    fileReader.readAsDataURL(file);
                })(files[i], i, files.length - 1);
            }
        }
        else {
            self.data[input.name] = dataList;
            if (callback && isCallable(callback)) {
                callback(dataList, segments);
            }
        }
        return dataList;
    }
};