
App.str = {
    html_char_raw: ['%', '&', '=', '?', '#', '+', ':', '/', ' ', '\n', '{', '}'],
    html_char_enc: ['%25', '%26', '%3D', '%3F', '%23', '%2B', '%3A', '%2F', '+', '%0D%0A', '%7B', '%7D'],
    urlcode: { '%': '%25', '&': '%26', '=': '%3D', '?': '%3F', '#': '%23', '+': '%2B', ':': '%3A', '/': '%2F', ' ': '%20', '\n': '%0D%0A', '{': '%7B', '}': '%7D' },
    unicode: {
        js: ["\\u00e0", "\\u00e1", "\\u1ea1", "\\u1ea3", "\\u00e3", "\\u00e2", "\\u1ea7", "\\u1ea5", "\\u1ead", "\\u1ea9", "\\u1eab", "\\u0103", "\\u1eb1", "\\u1eaf", "\\u1eb7", "\\u1eb3", "\\u1eb5", "\\u00e8", "\\u00e9", "\\u1eb9", "\\u1ebb", "\\u1ebd", "\\u00ea", "\\u1ec1", "\\u1ebf", "\\u1ec7", "\\u1ec3", "\\u1ec5", "\\u00ec", "\\u00ed", "\\u1ecb", "\\u1ec9", "\\u0129", "\\u00f2", "\\u00f3", "\\u1ecd", "\\u1ecf", "\\u00f5", "\\u00f4", "\\u1ed3", "\\u1ed1", "\\u1ed9", "\\u1ed5", "\\u1ed7", "\\u01a1", "\\u1edd", "\\u1edb", "\\u1ee3", "\\u1edf", "\\u1ee1", "\\u00f9", "\\u00fa", "\\u1ee5", "\\u1ee7", "\\u0169", "\\u01b0", "\\u1eeb", "\\u1ee9", "\\u1ef1", "\\u1eed", "\\u1eef", "\\u1ef3", "\\u00fd", "\\u1ef5", "\\u1ef7", "\\u1ef9", "\\u0111", "\\u00c0", "\\u00c1", "\\u1ea0", "\\u1ea2", "\\u00c3", "\\u00c2", "\\u1ea6", "\\u1ea4", "\\u1eac", "\\u1ea8", "\\u1eaa", "\\u0102", "\\u1eb0", "\\u1eae", "\\u1eb6", "\\u1eb2", "\\u1eb4", "\\u00c8", "\\u00c9", "\\u1eb8", "\\u1eba", "\\u1ebc", "\\u00ca", "\\u1ec0", "\\u1ebe", "\\u1ec6", "\\u1ec2", "\\u1ec4", "\\u00cc", "\\u00cd", "\\u1eca", "\\u1ec8", "\\u0128", "\\u00d2", "\\u00d3", "\\u1ecc", "\\u1ece", "\\u00d5", "\\u00d4", "\\u1ed2", "\\u1ed0", "\\u1ed8", "\\u1ed4", "\\u1ed6", "\\u01a0", "\\u1edc", "\\u1eda", "\\u1ee2", "\\u1ede", "\\u1ee0", "\\u00d9", "\\u00da", "\\u1ee4", "\\u1ee6", "\\u0168", "\\u01af", "\\u1eea", "\\u1ee8", "\\u1ef0", "\\u1eec", "\\u1eee", "\\u1ef2", "\\u00dd", "\\u1ef4", "\\u1ef6", "\\u1ef8", "\\u0110"],
        vi: ["\u00e0", "\u00e1", "\u1ea1", "\u1ea3", "\u00e3", "\u00e2", "\u1ea7", "\u1ea5", "\u1ead", "\u1ea9", "\u1eab", "\u0103", "\u1eb1", "\u1eaf", "\u1eb7", "\u1eb3", "\u1eb5", "\u00e8", "\u00e9", "\u1eb9", "\u1ebb", "\u1ebd", "\u00ea", "\u1ec1", "\u1ebf", "\u1ec7", "\u1ec3", "\u1ec5", "\u00ec", "\u00ed", "\u1ecb", "\u1ec9", "\u0129", "\u00f2", "\u00f3", "\u1ecd", "\u1ecf", "\u00f5", "\u00f4", "\u1ed3", "\u1ed1", "\u1ed9", "\u1ed5", "\u1ed7", "\u01a1", "\u1edd", "\u1edb", "\u1ee3", "\u1edf", "\u1ee1", "\u00f9", "\u00fa", "\u1ee5", "\u1ee7", "\u0169", "\u01b0", "\u1eeb", "\u1ee9", "\u1ef1", "\u1eed", "\u1eef", "\u1ef3", "\u00fd", "\u1ef5", "\u1ef7", "\u1ef9", "\u0111", "\u00c0", "\u00c1", "\u1ea0", "\u1ea2", "\u00c3", "\u00c2", "\u1ea6", "\u1ea4", "\u1eac", "\u1ea8", "\u1eaa", "\u0102", "\u1eb0", "\u1eae", "\u1eb6", "\u1eb2", "\u1eb4", "\u00c8", "\u00c9", "\u1eb8", "\u1eba", "\u1ebc", "\u00ca", "\u1ec0", "\u1ebe", "\u1ec6", "\u1ec2", "\u1ec4", "\u00cc", "\u00cd", "\u1eca", "\u1ec8", "\u0128", "\u00d2", "\u00d3", "\u1ecc", "\u1ece", "\u00d5", "\u00d4", "\u1ed2", "\u1ed0", "\u1ed8", "\u1ed4", "\u1ed6", "\u01a0", "\u1edc", "\u1eda", "\u1ee2", "\u1ede", "\u1ee0", "\u00d9", "\u00da", "\u1ee4", "\u1ee6", "\u0168", "\u01af", "\u1eea", "\u1ee8", "\u1ef0", "\u1eec", "\u1eee", "\u1ef2", "\u00dd", "\u1ef4", "\u1ef6", "\u1ef8", "\u0110"],
        en: ["a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D"],
        upper: ["À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ"],
        lower: ["à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ"]
    },
    clearUnicode: function (str) {
        return this.replace(str, this.unicode.vi, this.unicode.en);
    },
    isSN: function (str) {
        if (typeof str == 'undefined') return null;
        var t = App.getType(str);
        if (t == 'string' || t == 'number') return true;
        return false;
    },
    /**
     * thay the chuoi trong chuoi bang mot chuoi =)))))
     * @param {string} str  chuoi dau vao
     * @param {string|object|array} find  tham so tim kiem
     * @param {string|object|array} replace  tham so thay the
     */
    replace: function () {
        var a = arguments;
        var t = a.length;
        if (t == 0) return '';
        if (typeof a[0] != 'string' || t < 2) {
            return a[0];
        }
        var str = a[0];

        var b = App.getType(a[1]);
        if (this.isSN(a[1])) {
            if (t >= 3 && this.isSN(a[2])) {
                var obj = {};
                obj[a[1]] = a[2];
                str = this.replaceByObj(str, obj);
            }
        } else if (b == 'array') {
            if (t >= 3 && App.getType(a[2]) == 'array') {
                str = this.replaceByArr(str, a[1], a[2]);
            } else if (t >= 3 && App.getType(a[2]) == 'string') {
                var obj = {},
                    val = a[2];
                var d = a[1];
                for (var k in d) {
                    obj[d[k]] = val;
                }
                str = this.replaceByObj(str, obj);
            }
        } else if (b == 'object') {
            str = this.replaceByObj(str, a[1]);
        }
        return str;
    },
    replaceByArr: function () {
        var a = arguments;
        var t = a.length;
        if (t == 0) return '';
        if (typeof a[0] != 'string' || t < 2) {
            return a[0];
        }
        var str = a[0];
        var b = App.getType(a[1]);
        if (b == 'object') {
            str = this.replaceByObj(str, a[1]);
        } else if (b == 'array') {
            var obj = {};
            if (t >= 3) {
                var f = App.getType(a[2]);
                if (f == 'string') {
                    for (var k in a[1]) {
                        obj[a[1][k]] = a[2];
                    }
                } else if (f == 'array') {
                    var e = a[1].length,
                        g = a[2].length;
                    var max = (e > g) ? e : g;
                    for (var i = 0; i < max; i++) {
                        obj[a[1][i]] = a[2][i];
                    }
                }
            }
            str = this.replaceByObj(str, obj);
        }
        return str;
    },
    replaceByObj: function () {
        var a = arguments;
        var t = a.length;
        if (t == 0) return '';
        if (typeof a[0] != 'string' || t < 2) {
            return a[0];
        }
        var str = a[0];
        var b = App.getType(a[1]);
        if (b == 'object') {
            var max = null;
            if (typeof a[2] == 'number') {
                max = a[2];
            }
            var i = 1;
            var sts = a[1];
            for (var key in sts) {
                var txt = sts[key];
                str = this.preg_replace(key, txt, str);
                if (max && i >= max) break;
                i++;
            }
        }
        return str;
    },
    escapeRegExp: function (string) {
        var str = "" + string + "";
        return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    },

    preg_replace: function (find, replace, string) {
        var string = "" + string + "";
        return string.replace(new RegExp(this.escapeRegExp(find), 'g'), replace);
    },

    rand: function () {
        var st = 'ABCDEFGHIJKLMNOPQRSTUVWYZabcdefghijklmnopqrstuvwyz0123456789';
        var sp = st.split('');
        var l = sp.length - 1;
        var s = '';
        for (var i = 0; i < 32; i++) {
            s += sp[App.number.rand(0, l)];
        }
        return s;
    },
    camelToSlug: function (str, joinKey) {
        var st = 'ABCDEFGHIJKLMNOPQRSTUVWYZ';
        var sp = st.split('');
        var l = sp.length - 1;
        var s = '';
        var find = [];
        var replace = [];
        var k = isString(joinKey) ? joinKey : "-";
        sp.map(function (c) {
            find.push(c);
            replace.push(k + c.toLowerCase());
        });
        return this.replace(str, find, replace);
    },
    urlencode: function (str) {
        var t = this.html_char_raw.length;
        for (var i = 0; i < t; i++) str = this.replace(str, this.html_char_raw[i], this.html_char_enc[i]);
        return str;
    },
    urldecode: function (str) {
        var t = this.html_char_raw.length;
        for (var i = t - 1; i >= 0; i--) str = this.replace(str, this.html_char_enc[i], this.html_char_raw[i]);
        return str;
    },
    eval: function (template, data) {
        var t = typeof data;
        var tpl = template;
        if (t == 'object' || t == "array") {
            data = this.convertTextObject({}, data);
            for (var k in data) {
                var val = data[k];
                if (val === null) val = '';
                var f = "\{\$" + k + "\}";
                tpl = this.replace(tpl, f, val);
            }
        }
        return tpl;
    },
    convertTextObject: function (root, object, name, joinKey) {
        for (const key in object) {
            if (object.hasOwnProperty(key)) {
                if (typeof joinKey != "string") joinKey = ".";
                const val = object[key];
                var t = typeof val;
                var k = (typeof name != "undefined" && ("" + name).length) ? name + joinKey + key : key;
                if (val != null && (t == 'object' || t == "array")) {
                    root = this.convertTextObject(root, val, k, joinKey);
                } else {
                    root[k] = val;
                }
            }
        }
        return root;
    },
    upper: function (str) {
        if (typeof str == "undefined") return null;
        if (isString(str)) {
            var s = str.toUpperCase();
            return this.replace(s, this.unicode.lower, this.unicode.upper);
        }
        else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
            for (let i = 0; i < str.length; i++) {
                str[i] = this.upper(str[i]);
            }
            return str;
        }
        else if (isObject(str)) {
            for (const key in str) {
                if (str.hasOwnProperty(key)) {
                    const st = str[key];
                    str[key] = this.upper(st);
                }
            }
            return str;

        }
    },
    lower: function (str) {
        if (typeof str == "undefined") return null;
        if (isString(str)) {
            var s = str.toLowerCase();
            str = this.replace(s, this.unicode.upper, this.unicode.lower);
        }
        else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
            for (let i = 0; i < str.length; i++) {
                str[i] = this.upper(str[i]);
            }
        }
        else if (isObject(str)) {
            for (const key in str) {
                if (str.hasOwnProperty(key)) {
                    const st = str[key];
                    str[key] = this.upper(st);
                }
            }
        }

        return str;
    },
    ucfirst: function (str) {
        if (isString(str)) {
            if (str.length) {
                var first = str.substring(0, 1);
                str = this.upper(first) + str.substring(1);
            }
        }
        else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
            for (let i = 0; i < str.length; i++) {
                str[i] = this.ucfirst(str[i]);
            }
        }
        else if (isObject(str)) {
            for (const key in str) {
                if (str.hasOwnProperty(key)) {
                    str[key] = this.ucfirst(str[key]);
                }
            }
        }
        return str;
    },
    ucword: function (str) {
        if (isString(str)) {
            if (str.length) {
                str = str.split(" ").map(function (s) { return App.str.ucfirst(s) }).join(" ");
            }
        }
        else if ((isObject(str) && typeof str.length != "undefined") || isArray(str)) {
            for (let i = 0; i < str.length; i++) {
                str[i] = this.ucword(str[i]);
            }
        }
        else if (isObject(str)) {
            for (const key in str) {
                if (str.hasOwnProperty(key)) {
                    str[key] = this.ucword(str[key]);
                }
            }
        }
        return str;
    },

    htmlentities: function (str) {
        return this.eval(str, {
            "<": "&lt;",
            ">": "&gt;",
            "\"": "&quote;",
            "&": "&amp;"
        });
    },
    formSlug: function (str) {
        return typeof str != "string" ? str : this.replace(this.replace(str, "[]", '.*'), { "[": ".", "]": "" });
    },
    slug: function (str, key) {
        if (!key) key = '-';
        var s = String(str);
        var l = 'ABCDEFGHIJKLMNOPQRSTUVWYZabcdefghijklmnopqrstuvwyz0123456789';
        var list = [];
        var n = 0;
        var t = this.replace(this.replace(
            this.clearUnicode(this.lower(s)),
            "[]{}();:'\"\\|,./?~!@#$%^&*+=".split(""),
            "-"
        ), '--', '-');
        for (let i = 0; i < t.length; i++) {
            const st = t[i];
            if (l.indexOf(st) == -1) {
                if (n > 0) {
                    if (l.indexOf(t[i - 1]) >= 0) n++;
                }
            } else {
                if (typeof list[n] == "undefined") {
                    list[n] = st;
                } else {
                    list[n] += st;
                }
            }
        }
        return list.join(key);
    }

};


App.number = {
    rand: function(from, to) {
        if (!from) from = 0;
        if (!to) to = 0;
        if (from == 0) to++;
        var rand = Math.floor(Math.random() * to) + from;
        return rand;
    },
    currency: function(x) {
        return x.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1\.");
    }
};



App.date = function(format, offset){
    if(!offset) offset = 0;
    var d = new Date();
    var t = {};
    var dl = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    
    
    // convert to msec
    // add local time zone offset 
    // get UTC time in msec
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
    
    // create new Date object for different city
    // using supplied offset
    d = new Date(utc + (3600000*offset));
    


    t.ms = d.getMilliseconds();
    t.Y = d.getFullYear();
    t.y = d.getYear();
    t.H = d.getHours();
    t.i = d.getMinutes();
    t.m = d.getMonth()+1;
    t.s = d.getSeconds();
    t.time = d.getTime();
    t.d = d.getDate();
    t.D = dl[d.getDay()];
    if(!format) return t;
    var f = App.getType(format);
    if(f=='string'){
        var txt = format;
        txt = this.str.replace(txt,'ms',t.ms);
        txt = this.str.replace(txt,'time',t.time);
        txt = this.str.replace(txt,t);
        return txt;
    }
    return null;
};

App.fn = function(){
    this.timeout_status = true;
    this.args_type = 'array';
    this.calling = null;
    this.system_list = {};
    
    this.disableTimeout = function(){
        this.timeout_status = false;
    };
    this.enableTimeout = function(){
        this.timeout_status = true;
        if(this.args_type=='list'){
            this.args_type = 'array';
        }
    };
    this.setArgsType = function(){
        var a = arguments;
        var t = 'array';
        var tt = 0;
        if(a.length>0){
            t = a[0];
        }
        if(typeof t == 'string'){
            var t2 = t.toLowerCase();
            if(t2!='array' && t2 != '0'){
                tt = 1;
            }
        }else if(t){
            tt = 1;
        }else{
            tt = 0;
        }
        if(tt){
            this.args_type = 'list';
            this.disableTimeout();
        }else{
            this.args_type = 'array';
        }
    };
    
    this.getFuncPath = function(fn){
        if(!fn) return null;
        var t = App.getType(fn);
        var f = '';
        if(t=='function'){
            f = 'fn';
        }else if(t == 'string'){
            var a = App.str.replace(fn,' ','');
            if(!a) return null;
            
            if(App.getType(App.getEl(this,a))=='function'){
                f = '_this.'+a;
            }
            else if(App.getType(App.getEl(Crazy,a))=='function'){
                f = 'App.'+a;
            }
            else{
                var func_paths = a.split('.');
                if(func_paths.length<2){
                    if(typeof window[a] == 'function'){
                        f = a;
                    }
                }else{
                    var kk = func_paths[0];
                    if(typeof window[kk] == 'object'){
                        var kz = '';
                        for(var i = 1; i < func_paths.length; i++){
                            var dt = '';
                            if(i>1) dt = '.';
                            kz+=(dt+func_paths[i]);
                            dt = '';
                        }
                        if(App.getType(App.getEl(window[kk],kz))=='function'){
                            f = a;
                        }
                    }
                }
            }
        }
        return f;
    };
    this.get = function(fn){
        var r = function(){console.log(arguments);};
        if(!fn) return r;
        var t = App.getType(fn);
        var f = '';
		var _this = this;
        if(t=='function'){
            f = 'fn';
        }else if(t == 'string'){
            var fp = this.getFuncPath(fn);
            if(fp){
                f = fp;
            }
        }
        
        if(f){
            eval('r = '+f+";");
        }
        return r;
    };
    this.check = function (fn){
        if(typeof fn != 'string') return false;
        // console.log(this.getFuncPath(fn));
        if(this.getFuncPath(fn)){
            return true
        }else return false;
    };
    this.add = function(func_name,fn,main){
        if(typeof func_name != 'string'|| typeof fn!='function') return false;
        var s = false;
        if(!this.system_list[func_name]){
            this[func_name] = fn;
            s = true;
        }
    
        
        return s;
    };
    this.remove = function(fn){
        if(typeof fn != 'string') return false;
        if(!this.system_list[fn] && typeof this[fn]=='function'){
            this[fn] = undefined;
            delete this[fn];
        }
        return true;
    };
    this.call = function(fn,args,time){
        if(!fn) return null;
        var t = App.getType(fn);
        var f = '';
        var agm = arguments;
        if(t=='function'){
            f = 'fn';
        }else if(t == 'string'){
            var fp = this.getFuncPath(fn);
            if(fp){
                f = fp;
            }
        }
        if(!f) return undefined;
		var _this = this;
        var arg = [];
        if(this.args_type=='array'){
            if(typeof args!='undefined'){
                if(App.getType(args)=='array'){
                    arg = args;
                }else{
                    arg[0] = args;
                }
            }
        }else{
            var n = 0;
            for(var i=1; i< agm.length; i++){
                arg[n] = agm[i];
                n++;
            }
        }
		var t = arg.length;
        f+="(";
        for(var i = 0; i < t; i++){
            f+="arg["+i+"]";
            if(i < t-1) f+=",";
        }
        f+=");";
        var r = null;
        var o = "r = "+f;
        
        if(this.timeout_status && time){
            if(App.getType(time)=='number' && time > 0){
                this.calling = setTimeout(function(){
                    eval(o);
                    return r;
                },time);
                return true;
            }
        }
        eval(o);
        return r;
    };
    this.parse = function (fn){
        var f = function(){
            
        };
        if(!fn) return f;
        var t = App.getType(fn);
        
        if(t=='function'){
            f = fn;
        }
        else if(t=='string'){
            if(this.check(fn)){
                f = this.get(fn);
            }
        }
        return f;
    };
    this.goTo = function (url){
        window.open(url,'_blank');
    };
    
    this.openWindow = function (url,title,width,height,x,y){
        var swidth = screen.width,
            sheight = screen.height;
        if(!width) width = 600;
        if(!height) height = 300;
        var left = (x)?x:((swidth - width) / 2),
            top = (y)?y:((sheight - height)/2 - 100);
        if(top<0) top = 0;
        if(!title) title = 'Blank Page';
        window.open(url,title,'targetWindow,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width='+width+',height='+height+',top='+top+',left='+left);
    };
    var a = this;
    var st = {};
    for(var k in a){
        st[k] = k;
    }
    this.system_list = st;
};

App.func = new App.fn();

App.videos = {
	getVideoUrlData:function(url) {
		if(!url) return {};
		var data = {};
		var u1 = url.match(/.*youtu\.be\/(.*?)($|\?|#)/i);
		var u2 = url.match(/youtube\.com\/watch\?.*v=(.*?)($|&|#)/i);
		var u3 = url.match(/\.*vimeo.com\/(.*?)($|\?)/i);
		var u4 = url.match(/.*facebook.com\/(.*?)\/videos\/(.*?)\//i);
		
		if(u1){
			var id = u1[1];
			data = {
				id:id,
				server: 'youtube',
				thumbnail: 'http://img.youtube.com/vi/'+id+'/hqdefault.jpg',
				embed_url: "http://www.youtube.com/embed/"+id+"?rel=0&wmode=opaque"
			};
		}else if(u2){
			var id = u2[1];
			data = {
				id:id,
				server: 'youtube',
				thumbnail: 'http://img.youtube.com/vi/'+id+'/hqdefault.jpg',
				embed_url: "http://www.youtube.com/embed/"+id+"?rel=0&wmode=opaque"
			};
		}else if(u3){
			var d = u3[1].split("/");
			var id = d[d.length - 1];
			data = {
				id:id,
				server: 'vimeo',
				thumbnail: null,
				embed_url: "http://player.vimeo.com/video/"+id+"?rel=0&wmode=opaque"
			};
		}
		else if(u4){
			var page_id = u4[1];
			var id = u4[2];
			data = {
				id:id,
				server: 'vimeo',
				thumbnail: 'http://img.youtube.com/vi/'+id+'/hqdefault.jpg',
				embed_url: "https://www.facebook.com/v2.0/plugins/video.php?allowfullscreen=true&container_width=620&href=$ac%2F"+page_id+"%2Fvideos%2Fvb."+page_id+"%2F"+id+"%2F%3Ftype%3D3&locale=en_US&sdk=joey"
			};
		}
        return data;
	}
};

