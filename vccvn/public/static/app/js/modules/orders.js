
// giỏ hàng
App.extend({
    orders: {
        urls: {},
        init_list: ["urls"],
        cancel: function (id, success) {
            App.ajax(this.urls.cancel, {
                method: "POST",
                dataType: "json",
                data: {id:id}
            }).then(function (result) {
                if(result.status){
                    App.popup.alert("Đã hủy đơn hàng "+id + " thành công!");
                    if(typeof success == "function"){
                        success();
                    }
                }else{
                    App.popup.alert(result.message);
                }
            }).catch(function(err){
                App.popup.alert("Lỗi không xác định");
            });

        }
    }
    // end orders
});


if (typeof window.orderInit == "function") {
    if (typeof window.orderInit == "function") {
        window.orderInit();
    }
    $(document).on('click', prefixClass+"btn-cancel-order", function(e){
        e.preventDefault();
        var self = this;
        var id = $(this).data('id');
        App.popup.confirm("Bạn có chắc chắn muốn hủy đơn hàng "+id+" không?", function(){
            App.orders.cancel(id, function(){
                $(self).remove();
            });
        });
        return false;
    });
}

