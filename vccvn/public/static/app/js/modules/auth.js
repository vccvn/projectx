//auth
App.extend({
    auth: {
        urls: {},
        templates: {
            link: "<li><a href='{$link}'>{$text}</a></li>",
            account_section: "{$name}"
        },
        init_list: ["urls", "templates"],
        // kiểm tra giá sdan3 phẩm kèm thuộc tính
        /**
         * 
         * @param {*} data 
         */
        check: function (callback) {
            var self = this;
            App.ajax(this.urls.check, {
                method: "post",
                data: { a: 1 },
                dataType: "json"
            }).then(function (res) {
                var d = res.data;
                if (res.status) {
                    $(prefixClass+"account-section").html(App.str.eval(self.templates.account_section||"{$name}", d));
                }
                if(d.links && d.links.length){
                    // var l = d.links.length;
                    var links = d.links;
                    var $links = $(prefixClass+"account-links");
                    $links.html("");
                    for (const key in links) {
                        if (links.hasOwnProperty(key)) {
                            const item = links[key];
                            $links.append(App.str.eval(self.templates.link||"<li><a href='{$link}'>{$text}</a></li>", item));
                        }
                    }
                }
                //return res;
                var a = typeof callback == "function" ? callback(res) : null;
            });
        }
    }
    // end cart
});


if (typeof window.authInit == "function" || typeof window.customauthInit == "function") {
    if (typeof window.authInit == "function") {
        window.authInit();
    }
}

