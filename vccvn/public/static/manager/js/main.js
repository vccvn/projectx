var D = {
    urls: {
        
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
D.getType = function(obj) {
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