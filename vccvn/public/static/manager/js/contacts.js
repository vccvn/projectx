$(function(){
    const ContactList = function(options) {
        this.urls = {};
        this.id = 0;
        this.template = "";
        this.init_list = ["urls", "template"];
        this.options = options;

        this.fields = {
            name: "Họ và Tên ",
            email: "Email",
            phone_number:"Số điện thoại",
            address: "Địa chỉ",
            time: "Thời gian",
            subject: "Chủ đề",
            message: "Nội dung",
            replies: "Trả lời"
        };
        this.data = {};

        this.detail = {};

        var self = this;
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };
        this.onStart = function() {

            $(document).on('click', '.btn-view-contact-detail', function(){
                self.getDetail($(this).data('id'), function(team){
                    self.showDetail(team);
                });
                return false;
            });
            
        };

        /**
         * lấy thông tin team
         * @param {int} id mã team
         * @param {function} callback ham se duoc goi khi lay data thanh cong
         * @return {void}
         */
        this.getDetail = function(id, callback){
            this.id = id;
            self.detail = {};
            showLoading();
            ajaxRequest(this.urls.detail, "GET", {id:id}, function(rs){
                hideLoading();
                if(rs.status){
                    if(typeof callback == "function"){
                        self.detail = rs.data;
                        callback(rs.data);
                    }
                }else{
                    App.Swal.warning(rs.message);
                }
            }, function(err){
                App.Swal.error("Lỗi không xác định");
            });
        };

        this.showDetail = function(data){
            let tpl = '<div class="row mb-2 bt-1">'
                + '<div class="col-sm-5 col-md-4"><strong>{$label}</strong></div>'
                + '<div class="col-sm-7 col-md-8">{$value}</div>'
            +'</div>';
            let itemtpl = '<div class="row mb-2 bt-1">'
                + '<div class="col-12">{$label}</div>'
                + '<div class="col-12">{$value}</div>'
            +'</div>';
            let content = '';
            
            for (const key in self.fields) {
                if (data.hasOwnProperty(key)) {
                    const raw = data[key];
                    const label = self.fields[key];
                    let value = null;
                    let row_tpl = tpl;

                    if(key == 'replies'){
                        row_tpl = itemtpl;
                        value = self.renderReplies(raw);
                    }
                    else if(key == "message"){
                        value = String(raw??"").split("\n").join("<br>");
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
                title: "Chi tiết Liên hệ",
                content:content,
                size: "lg"
            };
            let = buttons = [
                {
                    type: "button",
                    text: "Trả lời",
                    class: "btn btn-info",
                    click: function(){
                        self.showReplyForm(self.id);
                    }
                }
            ];
            
            modalData.buttons = buttons;
            App.modal.custom(modalData);
        };

        this.renderReplies = function (replies) {
            if(!replies || !replies.length) return '';
            let tpl = '<div class="row mb-2 mt-1 contact-reply-item">'
                + '<div class="col-12 name"><strong>{$name}</strong></div>'
                + '<div class="col-12 message">{$message}</div>'
                + '<div class="col-12 time">{$time}</div>'
            +'</div>';

            let html = "";
            for (const key in replies) {
                if (replies.hasOwnProperty(key)) {
                    const reply = replies[key];
                    html += App.str.eval(tpl, reply);
                }
            }
            return html;
        };

        this.showReplyForm = function(id){
            App.modal.popup({
                title:"Trả lời liên hệ cũa " + self.detail.name,
                size:"md",
                inputs:{
                    contact_id:{
                        type: "hidden",
                        value: self.id
                    },
                    message:{
                        type: "textarea",
                        label: "Nội dung",
                        class: "height-100",
                        placeholder:"Viết gì đó",
                        validate: function (value) {
                            return (""+value).length > 0;
                        }
                    }
                },
                options: {
                    label_class: "col-12",
                    wrapper_class: "col-12"
                },
                btnDone: "Trả lòi liên hệ",
                done: function (data) {
                    self.postReply(data);
                }
            });
        };

        this.postReply = function(data){
            showLoading();
            ajaxRequest(self.urls.add_reply, "POST", data, function(rs){
                hideLoading();
                if(rs.status){
                    App.Swal.success("Gửi câu trả lời thành công!", null, function(){
                        self.getDetail(self.id, function(d){
                            self.showDetail(d);
                        });
                    });
                }else{
                    let message = '';
                    if(rs.errors){
                        let messages = [];
                        for (const key in rs.errors) {
                            if (rs.errors.hasOwnProperty(key)) {
                                const error = rs.errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    }else{
                        message = rs.message;
                    }
                    App.Swal.error(message, null, function(){
                        App.modal.show('popup-modal');
                    });
                }
            }, function (err) {
                hideLoading();
                App.modal.error("Lỗi không xác định!", null, function(){
                    App.modal.show('popup-modal');
                });
            });
        }
        
    };






    let options = {};
    if(typeof contact_data == 'object'){
        options = contact_data;
    }
    else if(typeof crazy_data == 'object'){
        let urls = {};
        let list = ["reply", "delete_reply"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof crazy_data[act+"_url"] == "string"){
                urls[act+"_url"] = crazy_data[act+"_url"];
            }
        }
        options.urls = urls;
    }

    let contact = new ContactList(options);
    contact.init();
    window.contact = contact;
});
