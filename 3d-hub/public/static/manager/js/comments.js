App.comments = {
    urls: {},
    id: 0,
    init_list: ["urls"],

    init: function(args) {
        if (!args || typeof args == 'undefined') return;
        for (var key of this.init_list) {
            if (typeof args[key] != 'undefined') {
                var d = args[key];
                var t = App.getType(d);

                var t2 = (typeof(this[key]) != 'undefined') ? App.getType(this[key]) : "string";
                if ((t == 'array' && t2 == 'array') || (t == 'object' && t2 == 'object')) {
                    for (var k in d) {
                        var v = d[k];
                        this[key][k] = v;
                    }
                } else {
                    this[key] = d;
                }
            }
        }
        var $tpl = $('.tag-templates');
        if($tpl.length){
            this.template = $tpl.text();
            $tpl.remove();
        }
    },
    changeApproveStatus:function (status, elem) {
        var data = {approved:status?1:0,id:$(elem).data('comment-id')};
        cl(data)
        ajaxRequest(this.urls.change_approve_url, "POST", data, function(rs){
            cl(rs.status);
        })
    }
};

$(function(){
    var check_selector = '.crazy-list input[type="checkbox"].crazy-check-';
    if (typeof window.commentInit == 'function') {
        window.commentInit();
        window.commentInit = null;
    }
    if(typeof comment_urls != 'undefined' && App.getType(comment_urls) == 'object'){
        for (const key in comment_urls) {
            if (comment_urls.hasOwnProperty(key)) {
                const url = comment_urls[key];
                App.comments.urls[key] = url;
            }
        }
    }

});

function getdomains(a,b,c){
    var s = "abcdefghijklmnopqrstuvwxyz";
    var arr = [];
    for(var i = 0; i < s.length; i++){
        var s1 = s[i];
        if(a && a!=s1) continue;
        for (let j = 0; j < s.length; j++) {
            const s2 = s[j];
            if(b && b!=s2) continue;
            for (let k = 0; k < s.length; k++) {
                const s3 = s[k];
                if(c && c!=s3) continue;
                arr.push(s1+s2+s3+".vn");
            }
        }
    }
    return arr.join("\n");
}