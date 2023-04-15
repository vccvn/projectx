// thiết lập truy vấn bàng jquery
// nếu cco1 sẽ dùng jquery, không có cũng ko sao chỉ là ưu tiên jquery

(function(_){
    var __delay = function(){
        App.setSystemOption({
            queryEngine: "jQuery"
        });
        App.task(function($){
            var csrf = $('meta[name="csrf-token"]').attr('content');
            if('jQuery' in window){
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    }
                });
            }
            // css class prefix
            var prefixClass = "."+(App.getSystemOption("cssClassPrefix")||"")+"";
            //[BODY]
        });
    };
    
    if(App.laravel && App.laravel.cache){
        App.request.get(App.laravel.urls.token, {
            data: {key:App.str.rand() },
            dataType: "json"
        }).then(function (res) {
            if(res.status){
                var token = res.data.token;
                App.request.setHeaders({
                    'X-CSRF-TOKEN': token
                });
                _('meta[name="csrf-token"]').attr('content', token);
                _('input[name="_token"]').val(token);
                __delay();
                __delay = null;
            }else{
                __delay();
                App.popup.warning("Có lỗi trong quá trình tải dữ liệu. Một số tính năng có thể sẽ không hoạt động");
                __delay = null;
            }
        }).catch(function (err){
            __delay();
            App.popup.warning("Có lỗi trong quá trình tải dữ liệu. Một số tính năng có thể sẽ không hoạt động");
            __delay = null;
        });
    }else{
        __delay();
        __delay = null;
    }
}(App.query));

