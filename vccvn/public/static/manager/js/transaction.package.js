if(typeof Transaction == "undefined"){
    var Transaction = {};
}

Transaction.package = {
    id:0,
    urls:{},
    init_list: ["urls"],
    fields:{
        ref_id: "Mã gói Dịch vụ",
        customer_id: "Mã khách hàng",
        customer_name: "Tên khách hàng",
        customer_email: "Email",
        type: "Loại",
        code: "Mã giao dịch",
        amount: "Số tiền",
        status: "Trạng thái",
        time: "Thời gian",
        bills: "Biên lai"
    },
    data:{
        type:{
            payment: "Thanh toán / Mua dịch vụ",
            extension: "Gia hạn dịch vụ",
            upgrade: "Nâng cấp dịch vụ",
            refund: "Hoàn tiền",
            othoe: "Khác"
        },
        status: {"1": "Đã duyệt", "0": "Đang chờ", "-1": "Bị từ chôi"}
    },

    detail:{},

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
        $('.view-transaction-detail').click(function(e){
            e.preventDefault();
            let id = $(this).data('id'), get_detail = self.urls.get_detail;
            self.id = id;
            showLoading();
            ajaxRequest(get_detail, "GET", {id:id}, function(rs){
                if(rs.status){
                    self.detail = rs.data;
                    self.showDetail(rs.data);
                }
                hideLoading();
            }, function(err){
                hideLoading();
            });
            return false;
        });
        $(document).on('click', '.btn-approve-transaction', function(e){
            self.doAction("approve");
            return false;
        });

        $(document).on('click', '.btn-unapprove-transaction', function(e){
            self.doAction("unapprove");
            return false;
        });
        $(document).on('click', '.btn-decline-transaction', function(e){
            self.doAction("decline");
            return false;
        });

        $(document).on('click', '.btn-delete-transaction', function(e){
            self.doAction("delete", "POST", function(data){
                if(data.length){
                    for (let index = 0; index < data.length; index++) {
                        const id = data[index];
                        $('.crazy-list #crazy-item-'+id).hide(300, function(){
                            $(this).remove();
                        })
                        
                    }
                }
            });
            return false;
        });

        

        
        
    },
    

    doAction:function(action, method, success){
        var self = this;
        let id = self.id, url = self.urls[action];
        let acction_messages = {
            approve: "duyệt",
            unapprove: "hoàn tác",
            decline: "từ chối",
            delete: "xóa"
        };
        if(!method) method = "POST";
        showLoading();
        ajaxRequest(url, method, {id:id}, function(rs){
            hideLoading();
            if(rs.status){
                let message = "Đã "+acction_messages[action]+" giao dịch có id là "+id+"  với mã là: "+self.detail.code + " thành công";
                if(action != 'delete') $('.crazy-list #crazy-item-'+id+' .col-transaction-status').html(self.data.status[rs.data.status]);
                App.Swal.success(message, function(){
                    if(typeof success == "function"){
                        success(rs.data);
                    }
                });
            }else{
                App.Swal.warning("Đã có lỗi xảy ra vui lòng kiểm tra thông tin và thử lại sau giây lát");
            }
            
        }, function(err){
            hideLoading();
            
            App.Swal.error("Lỗi không xác dịnh. Vui lòng thử lại sau giây lát");
            
        });
    },


    changeCustomer:function(customer_id){
        var self = this;
        showLoading();
        ajaxRequest(self.urls.get_service_options, "get", {customer_id:customer_id}, function(rs){
            if(rs.status && rs.data){
                App.htmlSelect.changeOptions('ref_id', rs.data);
            }else{
                App.htmlSelect.changeOptions('ref_id', ["Danh sách trống"]);
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
        
        data.amount = App.number.currency(parseInt(data.amount));
        for (const key in self.fields) {
            if (data.hasOwnProperty(key)) {
                const raw = data[key];
                const label = self.fields[key];
                let value = null;
                let row_tpl = tpl;

                if(key == 'bills'){
                    row_tpl = itemtpl;
                    value = self.renderBills(raw);
                }
                else if(self.data.hasOwnProperty(key) && self.data[key].hasOwnProperty(raw)){
                    value = self.data[key][raw];
                }
                else{
                    value = raw;
                }
                content += App.str.eval(row_tpl, {label: label, value: value});
            }
        }
        let modalData = {
            title: "Chi tiết Giao dịch",
            content:content,
            size: "lg"
        };
        let = buttons = [
            
        ];
        if(data.status == 0){
            buttons = [
                {
                    type: "button",
                    class: "btn btn-info btn-approve-transaction",
                    text: "Duyệt"
                },
                {
                    type: "button",
                    class: "btn btn-warning btn-decline-transaction",
                    text: "Từ chối"
                }
            ];
        }else if(data.status == 1){
            buttons[0] = {
                type: "button",
                class: "btn btn-warning btn-unapprove-transaction",
                text: "Hoàn tác"
            };
        }else if(data.status == -1){
            buttons[0] = {
                type: "button",
                class: "btn btn-success btn-undo-transaction",
                text: "Hoàn tác"
            };
        }
        buttons[buttons.length] = {
            type: "button",
            class: "btn btn-danger btn-delete-transaction",
            text: "Xóa"
        }

        modalData.buttons = buttons;
        App.modal.custom(modalData);
    },
    renderBills:function(bills){
        if(bills){
            let tpl = '<div class="bill-image modal-image"><img src="{$url}" alt="{$filename}"></div>';
            let html = '';
            for (const index in bills) {
                if (bills.hasOwnProperty(index)) {
                    const bill = bills[index];
                    html += App.str.eval(tpl,bill);
                }
            }
            return html;
        }
        return '';
    }
};




$(function(){
    if(typeof transaction_package == 'object'){
        Transaction.package.init(transaction_package);
    }
});
