/**
 * console.log
 * @param {*} ob 
 */


if(!window.$ && !window.jQuery){
    // (function(d, s, id) {
    //     var js, fjs = d.getElementsByTagName(s)[0];
    //     if (d.getElementById(id)) return;
    //     js = d.createElement(s); js.id = id;
    //     js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0&appId=472046656204750&autoLogAppEvents=1';
    //     fjs.parentNode.insertBefore(js, fjs);
    //   }(document, 'script', 'jquery-lib'));
    document.write('<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>')
}
 
function cl(ob) {
    console.log(ob);
}



var Crazy = {
    urls: {
        // test
    },
    init: function(args) {
        if (typeof args.urls == 'object') {
            for (var url_name in args.urls) {
                this.urls[url_name] = args.urls[url_name];
            }
        }
    },
    /**
     * using this method instead of jquery.ajax
     * @param {string} url duong dan
     * @param {string} method phuong thuc
     * @param {object} data du lieu
     * @param {function} success
     * @param {function} error
     * 
     * @return {boolean}
     */
    ajax: function(url, method, data, success, error) {
        if (typeof success != 'function') success = cl;
        if (typeof error != 'function') error = cl;
        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'JSON',
            cookie: true,
            success: success,
            error: error
        });
    }
};
/**
 * lay kiey63 dử liệu biến
 */
Crazy.getType = function(obj) {
    var t = 'null';
    if (typeof obj == 'object') {
        if (obj == null) {
            t = 'null';
        } else if (obj.constructor == FormData) {
            t = 'formdata';
        } else if (obj.constructor == Array) {
            t = 'array';
        } else if (obj.constructor == Object) {
            t = 'object';
        } else if (obj.constructor == Number) {
            t = 'number';
        } else {
            t = 'object';
        }
    } else {
        t = typeof obj;
    }
    return t;
};
Crazy.validateEmail = function (email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
};


Crazy.setup = function(object, data){
    if (!data || typeof data == 'undefined') return;
        for (var key of object.init_list) {
            if (typeof data[key] != 'undefined') {
                var d = data[key];
                var t = Crazy.getType(d);

                var t2 = (typeof(object[key]) != 'undefined') ? Crazy.getType(object[key]) : "string";
                if ((t == 'array' && t2 == 'array') || (t == 'object' && t2 == 'object')) {
                    for (var k in d) {
                        var v = d[k];
                        object[key][k] = v;
                    }
                } else {
                    object[key] = d;
                }
            }
        }
    return object;
}

Crazy.getEl = function(obj,key,delimiter){
    if(typeof obj =='undefined'){
        return null;
    }
    if(typeof key == 'undefined'){
        return obj;
    }
    var tpo = Crazy.getType(obj);
    var tpk = Crazy.getType(key);
    if(tpo=='array'){
        var k = NaN;
        if(tpk == 'number'){
            k = key;
        }else if(parseInt(key)!=NaN){
            k = parseInt(key);
        }
        if(!isNaN(k)){
            if(typeof obj[k]!='undefined'){
                return obj[k];
            }
        }
    }else if(tpo=='object'){
        if(tpk=='number'){
            if(typeof obj[key]!='undefined'){
                return obj[key];
            }
        }else if(tpk=='string'){
            if(typeof delimiter == 'undefined'){
                delimiter = '.';
            }else{
                var t = Crazy.getType(delimiter);
                if(t!='string'&&t!='number'){
                    delimiter = '.';
                }
            }
            var _keys = key.split(delimiter);
            var d = obj;
            for(var i = 0; i < _keys.length; i++){
                var k = _keys[i];
                if(typeof d[k] != 'undefined'){
                    d = d[k];
                }else{
                    d = null;
                    i+=_keys.length;
                }
            }
        }
        return d;
    }
    return null;
};

Crazy.html = {
    simpleTags: ['img','meta','link', 'input', 'br', 'hr'],
    make: function(str){
        if((str instanceof Element)) return str;
        else if(typeof str == "object") return this.create(str);
        var div = document.createElement('div');
        
        div.innerHTML = str.trim();

        // Change this to div.childNodes to support multiple top-level nodes
        return div.firstChild; 
    },
    parse: function (T) {
        return this.make(T);
    },
    create: function(tag, content, attrs){
        var tagNAme = 'div';
        var isSimple = false;
        if(typeof tag == "object"){
            attrs = {};
            for (const kk in tag) {
                if (tag.hasOwnProperty(kk)) {
                    const vv = tag[kk];
                    let tt = kk.toLowerCase();
                    if(tt == "tag" || tt == "tagname"){
                        tagNAme = vv.toLowerCase();
                    }
                }
            }
            if(this.simpleTags.indexOf(tagNAme.toLowerCase()) >= 0) {
                isSimple = true;
            }
            for (const kk in tag) {
                if (tag.hasOwnProperty(kk)) {
                    const vv = tag[kk];
                    let tt = kk.toLowerCase();
                    if(tt == "content" && !isSimple){
                        content = vv;
                    }else{
                        attrs[kk] = vv;
                    }
                }
            }
        }else if(typeof tag == "string"){
            tagNAme = tag;
        }
        if(this.simpleTags.indexOf(tagNAme.toLowerCase()) >= 0) {
            attrs = content;
            isSimple = true;
        }

        var htmlObject = document.createElement(tagNAme);
        if(attrs && typeof attrs == "object"){
            for (const prop in attrs) {
                if (attrs.hasOwnProperty(prop)) {
                    let val = attrs[prop];
                    let key = prop.toLowerCase();
                    let k = key;
                    let f = k.substring(0, 1);
                    let f2 = k.substring(0, 2);
                    if(f == '@' || f2 == 'on'){
                        let a = k.substring(f == '@' ? 1 : 2);
                        let cb = (typeof val == "function") ? val : function (e) {
                            Crazy.func.call(val, [e.target]);
                        };
                        if(htmlObject.addEventListener){
                            htmlObject.addEventListener(a, cb);
                        }else if(htmlObject.attachEvent){
                            htmlObject.attachEvent(a, cb);
                        }
                    }else if(typeof val == 'object'){
                        let attrObj = Crazy.str.convertTextObject({}, val, prop, '-');
                        for (const ak in attrObj) {
                            if (attrObj.hasOwnProperty(ak)) {
                                const v = attrObj[ak];
                                htmlObject.setAttribute(ak,v);
                            }
                        }
                    }else if(key == 'class' || key == 'classname'){
                        htmlObject.className = val;
                    }
                    else {
                        htmlObject.setAttribute(prop,val);
                    }
                }
            }
        }
        if(!isSimple){
            if(tagNAme.toLowerCase() == 'textarea'){
                htmlObject.innerText = content;
            }else if(content instanceof Element){
                htmlObject.appendChild(content);
            }else if(content && typeof content == "object" && content.constructor == Array){
                for (let i = 0; i < content.length; i++) {
                    const el = content[i];
                    if(el instanceof Element){
                        htmlObject.appendChild(el);
                    }else if(typeof el == "string"){
                        htmlObject.appendChild(this.make(el));
                    }
                }
            }else if(typeof content == "string"){
                htmlObject.appendChild(this.make(content));
            }
        }
        return htmlObject;
    },
    input: function(args){
        if(typeof args == "object"){
            var tagNAme = 'input';
            var attrs = {};
            var content = null;
            var value = null;
            var type = "text";
            var ignore = [];
            var data = [];
            for (const prop in args) {
                if (args.hasOwnProperty(prop)) {
                    const val = args[prop];
                    let p = prop.toLowerCase();
                    if(p == 'type'){
                        let v = (typeof val == 'string') ? val.toLowerCase() : 'text';
                        type = v;
                        if(v == 'textarea'){
                            tagNAme = v;
                            ignore.push("type", "value");
                        }else if(v == "select"){
                            tagNAme = "select";
                            ignore.push("type", "value", "data");
                        }else{
                            attrs[p] = v;
                        }
                    }else if(ignore.indexOf(p) >= 0){
                        // next
                    }else{
                        attrs[prop] = val;
                    }
                    if(p == 'value'){
                        value = val;
                    }else if(p == 'data'){
                        data = val;
                    }
                }
            }
            var attributes = {};
            for (const key in attrs) {
                if (attrs.hasOwnProperty(key)) {
                    const va = attrs[key];
                    if(ignore.indexOf(key.toLowerCase()) >= 0){
                        // next
                    }else{
                        attributes[key] = va;
                    }
                }
            }
            if(type == 'select'){
                content = [];
                if(typeof data == "object"){
                    for (const vl in data) {
                        if (data.hasOwnProperty(vl)) {
                            const text = data[vl];
                            let option = {value: vl};
                            if(vl == value){
                                option.selected = "selected";
                            }
                            content.push(this.create('option', text, option));
                        }
                    }
                }
            }else if(type == "textarea"){
                content = value;
            }else{
                content = attributes;
            }
            return this.create(tagNAme, content, attributes);
        }
        return null;
    },
    encode: function(html){
        var div = document.createElement("div");
        div.appendChild(this.make(html));
        return div.innerHTML;
    },
    decode: function(html){
        return this.make(html);
    },
    render: function (html, root) {
        if(root instanceof Element){
            root.appendChild(this.parse(html));
        }else{
            document.body.appendChild(this.parse(html));
        }
    },
    jdom: function(tag, content, attributes){
        return new this.dom(tag,content,attributes);
    },
    dom: function(tag, content, attributes){
        var $html = Crazy.html;
        this.el = $html.create(tag, content, attributes);
        this.children = [];
        this.parent = null;
        var self = this;
        this.addClass = function(className){
            this.el.classList.add(className);
            return this;
        };
        this.removeClass = function(className){
            if(className){
                this.el.classList.remove(className);
            }else{
                this.el.className = "";
            }
            return this;
        };
        this.append = function(child){
            if(child.constructor == Crazy.html.dom) {
                this.children.push(child);
                this.el.appendChild(child.el);
            }else{
                this.el.appendChild($html.parse(child));
            }
            
            return this;
        };
        this.prepend = function(child){
            if(child.constructor == Crazy.html.dom) {
                this.children.unshift(child);
                this.el.insertBefore($html.parse(child.el), this.el.firstChild);
            }else{
                this.el.insertBefore($html.parse(child), this.el.firstChild);
            }
            return this;
        };

        this.toHTML = function(){
            return $html.encode(this.el);
        };

        this.html = function(){
            return this.el.innerHTML;
        };
        this.text = function(){
            return this.innerText;
        };
        this.appendTo = function (parent) {
            if(parent.constructor == Crazy.html.dom){
                this.parent = parent;
                parent.append(this);
            }else if(parent instanceof Element){
                parent.appendChild(this.el);
            }
            return this;
        }
        this.prependTo = function (parent) {
            if(parent.constructor == Crazy.html.dom){
                this.parent = parent;
                parent.prepend(this);
            }else if(parent instanceof Element){
                parent.insertBefore(this.el, parent.firstChild);
            }
            return this;
        }
        this.render = function (root) {
            if(root instanceof Element){
                root.appendChild(this.el);
            }else{
                document.body.appendChild(this.el);
            }
        };
        if(this.el.tagNAme == "input"){
            this.val = function(value){
                if(typeof value != "undefined"){
                    this.el.value = value;
                }
                return this.el.value;
            };
        }else if(this.el.tagNAme == "input"){
            this.val = function(value){
                if(typeof value != "undefined"){
                    this.el.innerText = value;
                }
                return this.el.innerText;
            }
        }else if(this.el.tagNAme == "select"){
            this.val = function(value){
                if(typeof value != "undefined"){
                    this.el.value = value;
                }
                return this.el.value;
            }
        }

    }
};