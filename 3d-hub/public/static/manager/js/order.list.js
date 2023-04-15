if(typeof Order == "undefined"){
    var Order = {};
}

Order.list = {
    urls:{},
    init_list: ["urls"],
    updateUrl:'#',
    fields:{
        id: "Mã đơn hàng",
        billing: "Thong tin thanh toán",
        shipping: "Thông tin giao hàng",
        created_at: "Thời gian khỏi tạo",
        total_money: "Tổng giá trị dơn hàng",
        ship_fee: "Phí giao hàng",
        vat: "VAT",
        total_pay: "Tổng số tiền phải trả",
        payment_method: "Phương thức thanh toán",
        note: "Ghi chú",
        status: "Trạng thái đơn hàng",
        details: "Chi tiết đơn hàng"
    },
    data:{
        status:{
            "0": "Đang chờ xác nhận", 
            "100": "Đã xác nhận", 
            "200": "Chờ thanh toán", 
            "300": "Đã thanh toán", 
            "400": "Đang xử lý", 
            "500": "Đang giao hàng", 
            "1000": "Đã hoàn thành", 
            "-1":"Bị hủy"
        },
        payment_method: ["Giao hàng trả tiền", "Thanh toán online"],
        types: {
            standard: "SP tiêu chuẩn",
            design: "SP thiết kế",
            custom: "SP tùy chọn"
        }
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
        $('.order-item-status-select').change(function(){
            let $this = $(this);
            let data = {
                id: $this.data('id'),
                status: $this.val()
            };
            ajaxRequest(self.urls.change_status, "POST", data, function(rs){
                console.log(rs.message);
            });
        });
        $('.view-order-detail').click(function(){
            let id = $(this).data('id');
            self.updateUrl = $(this).attr('href');
            showLoading();
            ajaxRequest(self.urls.get_detail, "GET", {id:id}, function(rs){
                if(rs.status){
                    self.showDetail(rs.data);
                }
                hideLoading();
            }, function(err){
                hideLoading();
            });
            return false;
        });
        $(document).on('click', '.btn-edit-order', function(){
            if(self.updateUrl && self.updateUrl != '#'){
                top.location.href = self.updateUrl;
            }
        });
    },
    getTypeText: function (type) {
        return type && typeof this.data.types[type] != "undefined" ? this.data.types[type] : "";
    },
    showDetail:function(data){
        var self = this;
        let tpl = '<div class="row mb-2 bt-1">'
            + '<div class="col-sm-5 col-md-4"><strong>{$label}</strong></div>'
            + '<div class="col-sm-7 col-md-8">{$value}</div>'
        +'</div>';
        let itemtpl = '<div class="row mb-2 bt-1">'
            + '<div class="col-12">{$label}</div>'
            + '<div class="col-12">{$value}</div>'
        +'</div>';
        let content = '';
        data.total_pay = App.number.currency(parseInt(data.total_money + data.ship_fee + data.vat));
        for (const key in self.fields) {
            if (data.hasOwnProperty(key) || key == "address") {
                const raw = data[key];
                let label = self.fields[key];
                let value = null;
                let row_tpl = tpl;
                if(self.data.hasOwnProperty(key) && self.data[key].hasOwnProperty(raw)){
                    value = self.data[key][raw];
                }else if(key == "details"){
                    value = self.renderItems(raw);
                    row_tpl = itemtpl;
                }
                else if(key == "total_money"){
                    value = App.number.currency(parseInt(raw));
                }
                else if(key == "billing" || key == "shipping"){
                    if(data.ship_to_different_address){
                        value = this.renderAddress(raw);
                    }else if(key == "billing"){
                        label += " và giao hàng";
                        value = this.renderAddress(raw);
                    }else{
                        continue;
                    }
                    
                }else{
                    value = raw;
                }
                content += App.str.eval(row_tpl, {label: label, value: value});
            }
            
        }
        App.modal.custom({
            title: "Chi tiết đơn hàng",
            content:content,
            buttons:[
                {
                    type: "button",
                    class: "btn btn-info btn-edit-order",
                    text: "Sửa"
                }
            ],
            size: "max"
        });
    },
    renderAddress: function(s){
        return s ? (
            "<p><strong>Họ tên</strong>: "+s.name + "</p>" +
            "<p><strong>Số điện thoại</strong>: "+s.phone_number + "</p>" +
            "<p><strong>Email</strong>: "+s.email + "</p>" +
            "<p><strong>Địa chỉ</strong>: " +(
                s.address + (s.ward ? ", "+ s.ward.name : "") + (s.district ? ", "+ s.district.name : "") + (s.region ? ", "+ s.region.name : "")
            ) +
            "</p>"
        ) : "";

    },
    renderItems: function (items) {
        var self = this;
        if(items){
            let html_header = '<div class="table-responsive">'
                + '<table class="table table-bordered table-striped">'
                    + '<thead>'
                        + '<tr>'
                            + '<th class="text-center">Mã SP</th>'
                            + '<th class="text-center">Ảnh sản phẩm</th>'
                            + '<th class="min-160 max-250">Tên sản phẩm</th>'
                            + '<th class="min-100">Thuộc tính</th>'
                            + '<th class="min-100 text-right">Đơn giá</th>'
                            + '<th class="text-right">Số lượng</th>'
                            + '<th class="min-100 text-right">Tổng giá</th>'
                        + '</tr>'
                    + '</thead>'
                    + '<tbody>'
            let html_body = ''
                        + '<tr>'
                            + '<td class="text-center">{$product_id}</td>'
                            + '<td class="product-image thumbnail-image text-center"><img src="{$image}"></td>'
                            + '<td class="min-160 max-250"><strong>{$product_name}</strong><div class="type-data">{$type_data}</div></td>'
                            + '<td class="min-100">{$attrs}</td>'
                            + '<td class="min-100 text-right">{$final_price} VNĐ</td>'
                            + '<td class="text-right">{$quantity}</td>'
                            + '<td class="min-100 text-right">{$total_price} VNĐ</td>'
                        + '</tr>'
            let html_footer = ''
                    + '</tbody>'
                + '</table>'
            + '</div>';

            let content = html_header;
            let tpl = '<div class="attr-item"><span class="mr-3">{$label}:</span> <i>{$text}</i></div>';
            for (const key in items) {
                if (items.hasOwnProperty(key)) {
                    let item = items[key];
                    item.final_price = App.number.currency(parseInt(item.final_price));
                    item.total_price = App.number.currency(parseInt(item.final_price*item.quantity));
                    item.attrs = self.renderAttributes(item.attributes);


                    var type_data = '';
                    if(item.product_type){
                        type_data += App.str.eval(tpl,{
                            label: "loại sản phẩm",
                            text: this.getTypeText(item.product_type)
                        });
                        if(item.product_type == 'design'){
                            type_data += App.str.eval(tpl,{
                                label: "Link File",
                                text: '<a target="_blank" href="'+(item.design_full_url || item.design_url || item.image)+'">' + (item.design_full_file || item.design_file) + '</a>'
                            });
                            if(item.image_uploads && item.image_uploads.length){
                                type_data += '<p>Danh sách file upload</p>';
                                for (const key in item.image_uploads) {
                                    if (item.image_uploads.hasOwnProperty(key)) {
                                        const src = item.image_uploads[key];
                                        var fn = src.split("/").pop();
                                        type_data += '<p><a target="_blank" href="'+src+'">' + fn + '</a></p>';
                                    }
                                }
                            }
                        }
                    }

                    item.type_data = type_data;
                    content += App.str.eval(html_body, item);
                }
            }
            content+=html_footer;
            return content;
        }
        return "";
    },
    renderAttributes:function(attributes){
        let tpl = '<div class="attr-item"><span class="mr-3">{$label}:</span> <i>{$text}</i></div>';
        let html = '';
        if(attributes){
            for (const index in attributes) {
                if (attributes.hasOwnProperty(index)) {
                    const attr = attributes[index];
                    let data = {
                        label: attr.label || attr.name,
                        text: attr.text_value || attr[attr.value_type+'_value']
                    };
                    html += App.str.eval(tpl,data);
                }
            }
        }
        return html;
    }
};




$(function(){
    if(typeof order_data == 'object'){
        Order.list.init(order_data);
    }
});
