var APIMethods = {
    urls: {},
    init_list: ["urls"],
    url: function (action) {
        return typeof this.urls[action] != "undefined" ? this.urls[action] : null;
    },

    callApi: function (method, url, data, headers) {
        if (!headers) headers = {};
        var apiUrl = this.url(url) || url;
        // console.log(method, apiUrl, data);
        return App.axios(apiUrl, {
            method: method,
            data: data,
            dataType: "JSON",
            cookie: true,
            headers: headers
        }).then(function (response) {
            var res = response.data;
            if (response.statusText != "OK" || !res) {
                throw new Error("Lỗi không xác định");
            } else {
                return res;
            }
        });
    },
    upload: function (url, data, options) {
        return App.axiosUpload(url, data, options).then(function (response) {
            var res = response.data;
            if (response.statusText != "OK" || !res) {
                throw new Error("Lỗi không xác định");
            } else {
                return res;
            }
        });
    }
};

["get", "post", "put", "patch", "delete", "head", "options"].map(function (method) {
    var mt = method.toUpperCase();
    /**
     * gửi request dạng {mt} 
     * @param {string|option} url url hoặc option
     * @param {object|null|undefined} data tham số tùy chọn
     * @param {object|null|undefined} headers tham số tùy chọn
     */

    APIMethods[method] = function (url, data, headers) {
        return this.callApi(mt, url, data, headers);
    }
});

App.extend({
    api: APIMethods
});


if (typeof window.apiInit == "function" || typeof window.custoAapiInit == "function") {
    if (typeof window.apiInit == "function") {
        window.apiInit();
    }
}

