App.crawler = {
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
    changeDynamicID:function(id){
        ajaxRequest(this.urls.get_category_url, "GET", {dynamic_id:id}, function(rs){
            if(rs.status){
                if(rs.data){
                    App.htmlSelect.changeOptions('category_id', rs.data);
                }else{
                    App.htmlSelect.changeOptions('category_id', {"0": "Không"});
                }
            }else{
                App.htmlSelect.changeOptions('category_id', {"0": "Không"});
            }
        })
    },
    changeTaskStatus:function (status, elem) {
        var data = {status:status,id:$(elem).data('task-id')};
        ajaxRequest(this.urls.change_status_url, "POST", data, function(rs){
            cl(rs.status);
        })
    },
    runTask: function(ids) {
        var self = this;
        var msg = "bạn có chắc chắn muốn chạy " + (ids.length > 1 ? ids.length + " Task" : "<strong>" + $('#crazy-item-' + ids[0]).data('name') + "</strong>") + "?";
        App.Swal.confirm(msg, function(ans) {
            // if (ans) {
                showLoading();
                ajaxRequest(self.urls.run_url, "POST", { ids: ids }, function(rs) {
                    hideLoading();
                    if (rs.status) {
                        if (rs.data.count) {
                            App.Swal.info("Đã crawl được "+rs.data.count+" mới");
                        }else{
                            App.Swal.warning("Chông crawl được bài viết nào!");
                        }
                    } else {
                        App.Swal.error("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                }, function (e){
                    hideLoading();
                    App.Swal.error("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                });
            // }
        });
    },

};

$(function(){
    var check_selector = '.crazy-list input[type="checkbox"].crazy-check-';
    if (typeof window.crawlerInit == 'function') {
        window.crawlerInit();
        window.tagsInit = null;
    }
    if(typeof crawler_urls != 'undefined' && App.getType(crawler_urls) == 'object'){
        for (const key in crawler_urls) {
            if (crawler_urls.hasOwnProperty(key)) {
                const url = crawler_urls[key];
                App.crawler.urls[key] = url;
            }
        }
    }

    if($('.btn-run-task').length){
        $(document).on('click', '.btn-run-task', function() {
            var id = $(this).data('id');
            App.crawler.runTask([id]);
            return false;
        });
    }
    if($('.crazy-btn-run-all-task').length){
        $(document).on('click', '.crazy-btn-run-all-task', function() {
            var list = $(check_selector+'item:checked');
            var ids = [];
            if (list.length == 0) {
                return App.Swal.alert("Bạn chưa chọn mục nào");
            }
            for (var i = 0; i < list.length; i++) {
                ids[ids.length] = $(list[i]).val();
            }
            App.crawler.runTask(ids);
            return false;
        });
    }
    
});