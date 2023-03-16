if(typeof Order == "undefined"){
    var Order = {};
}

Order.feedback = {
    id:0,
    urls:{},
    init_list: ["urls"],
    fields:{
        order_id: "Mã đơn hàng",
        customer_id: "Mã khách hàng",
        customer_name: "Tên khách hàng",
        customer_email: "Email",
        type: "Loại",
        title: "Tiêu đề",
        description: "Mô tả chi tiết",
        solved: "Đã xử lý chưa?",
        created_at: "Thời gian gửi"
    },
    data:{
        type:{
            feedback:"Phản hồi",
            complain: "Khiếu nại",
            return: "Đổi trả"
        },
        solved: ["Chưa được xử lý", "Đã được xử lý"]
    },
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
        this.onStart();
    },
    onStart:function(){
        var self = this;
        $('.btn-view-feedback-detail').click(function(e){
            e.preventDefault();
            let id = $(this).data('id'), get_detail = $(this).attr('href');
            self.id = id;
            showLoading();
            ajaxRequest(get_detail, "GET", {id:id}, function(rs){
                if(rs.status){
                    self.showDetail(rs.data);
                }
                hideLoading();
            }, function(err){
                hideLoading();
            });
            return false;
        });
        $(document).on('click', '.btn-resolve-feedback', function(){
            ajaxRequest(self.urls.resolve, "POST",{id:self.id}, function(rs){
                if(rs.status){
                    App.Swal.success(rs.message);
                }
                else{
                    App.Swal.error("Lỗi không xác định");
                }
            }, function(res){
                App.Swal.error("Lỗi không xác định");
            });
        });
    },
    
    changeCustomer:function(customer_id){
        var self = this;
        showLoading();
        ajaxRequest(self.urls.get_order_options, "get", {customer_id:customer_id}, function(rs){
            if(rs.status && rs.data){
                App.htmlSelect.changeOptions('order_id', rs.data);
            }else{
                App.htmlSelect.changeOptions('order_id', ["Danh sách trống"]);
            }
            hideLoading();
        }, function(err){
            hideLoading();
        })
    },
    showDetail:function(data){
        var self = this;
        let tpl = '<div class="row mb-2 bt-1">'
            + '<div class="col-sm-5 col-md-4">{$label}</div>'
            + '<div class="col-sm-7 col-md-8">{$value}</div>'
        +'</div>';
        let itemtpl = '<div class="row mb-2 bt-1">'
            + '<div class="col-12">{$label}</div>'
            + '<div class="col-12">{$value}</div>'
        +'</div>';
        let content = '';
        data.total_pay = App.number.currency(parseInt(data.total_money + data.ship_fee + data.vat));
        for (const key in self.fields) {
            if (data.hasOwnProperty(key)) {
                const raw = data[key];
                const label = self.fields[key];
                let value = null;
                let row_tpl = tpl;
                if(self.data.hasOwnProperty(key) && self.data[key].hasOwnProperty(raw)){
                    value = self.data[key][raw];
                }
                else{
                    value = raw;
                }
                content += App.str.eval(row_tpl, {label: label, value: value});
            }
        }
        let modalData = {
            title: "Chi tiết feedback",
            content:content,
            size: "lg"
        };
        if(!data.solved){
            modalData.buttons = [
                {
                    type: "button",
                    class: "btn btn-info btn-resolve-feedback",
                    text: "Đã xử lý"
                }
            ];
        }
        App.modal.custom(modalData);
    }
};




$(function(){
    if(typeof order_feedback == 'object'){
        Order.feedback.init(order_feedback);
    }
});
