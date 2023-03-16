$(function(){
    const EmbedManager = function(options) {
        this.urls = {};
        this.id = 0;
        this.area_id = 0;
        this.template = "";
        this.actionTemplate = "";
        this.init_list = ["urls", "template"];
        this.options = options;
        var self = this;
        /**
         * init
         * @param {object} args
         */
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };


        this.sortCallback = function(){
            var data = [];
            setTimeout(function(){
                var listArea = $('.embed-list-body');
                if(listArea.length){
                    let btnClass = ["btn-edit-item", "btn-delete-item"];
                    for (let i = 0; i < listArea.length; i++) {
                        const l = listArea[i];
                        let area = {};
                        area.area_id = $(l).data('area-id');
                        let raw = $(l).find('.dd-list .dd-item');
                        area.embeds = {};
                        for (let j = 0; j < raw.length; j++) {
                            const item = raw[j];
                            area.embeds[$(item).data('id')] = j+1;
                            for (let k = 0; k < btnClass.length; k++) {
                                const bc = btnClass[k];
                                let btn = $(item).find('.item-actions .'+bc);
                                if(btn.length && btn.data('area-id') != area.area_id){
                                    btn.data('area-id', area.area_id);
                                }
                            }
                        }
                        data.push(area);
                    }
                    ajaxRequest(self.urls.sort, "POST", {data:data}, function(rs){
                        if(rs.status){
                            console.log(rs.message);
                        }
                        else{
                            App.Swal.error(rs.message);
                        }
                    }, function(err){
                        App.Swal.error("Lỗi không xác định");
                    });
                }
            }, 200);


        };


        this.showForm = function(data){
            var deffaultData = {id:"", area_id: 0, label: "", slug: "", code: "", status: 1};
            for (const key in deffaultData) {
                if (deffaultData.hasOwnProperty(key)) {
                    const value = deffaultData[key];
                    if(!data.hasOwnProperty(key)){
                        data[key] = value;
                    }
                }
            }
            App.modal.popup({
                title: (data.id? "Cập nhật" : "Thêm") + " mã nhúng",
                inputs: {
                    id:{
                        type: "hidden",
                        value: data.id
                    },
                    area_id:{
                        type: "hidden",
                        value: data.area_id
                    },
                    label:{
                        type: "text",
                        label: "Nhãn",
                        value: data.label,
                        validate: function (val){
                            return val.length > 0;
                        }
                    },
                    slug: {
                        type: "text",
                        label: "slug (tùy chọn)",
                        placeholder: "ví dụ: google_map",
                        value: data.slug
                    },
                    code: {
                        type: "textarea",
                        label: "Mã (code)",
                        value: data.code
                    },
                    status: {
                        type: "select",
                        label: "Trạng thái",
                        data:{
                            0: "Không kích hoạt",
                            1: "Kích hoạt"
                        },
                        value: data.status
                    }
                },
                size:"md",
                btnDone: (data.id? "Cập nhật" : "Thêm"),
                done: function(data){
                    if(data.id) self.id = data.id;
                    self.save(data);
                }
            });

        };

        this.save = function(data){
            ajaxRequest(self.urls.save, "POST", data, function(rs){
                if(rs.status){
                    var data = rs.data;
                    var area_id = data.area_id;
                    // data.show_label = data.show?"Có":"";
                    if(self.id && data.id == self.id){
                        //
                        var itemText = $('#embed-area-'+area_id+' li.dd-item[data-id="'+data.id+'"]>.dd-handle>.embed-label');
                        if(itemText.length){
                            itemText.html(data.label);

                        }else{
                            $('#embed-area-'+area_id).nestable('replace', {id:rs.data.id,content:App.str.eval(self.template, data)});
                            var item = $('#embed-area-'+area_id+' li.dd-item[data-id="'+data.id+'"]');
                            if(item.length){
                                var itemActions = item.find('.item-actions');
                                if(!itemActions.length){
                                    item.prepend(App.str.eval(self.actionTemplate, data));
                                }

                            }




                        }
                    }else{
                        $('#embed-area-'+area_id).nestable('add', {id:rs.data.id,content:App.str.eval(self.template, data)});
                        var item = $('#embed-area-'+area_id+' li.dd-item[data-id="'+data.id+'"]');
                        if(item.length){
                            item.prepend(App.str.eval(self.actionTemplate, data));
                        }
                    }

                    var empty = $('#embed-area-'+area_id+' .dd-empty');
                    if(empty.length){
                        empty.remove();
                    }

                    self.id = 0;
                }
                else{
                    var message = '';
                    if(rs.errors){
                        var messages = [];
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
            }, function(err){
                App.Swal.error("Lỗi không xác định!");
            });
        };

        this.detail = function(id, success){
            ajaxRequest(self.urls.detail, "GET", {id:id}, function(rs){
                if(rs.status){
                    var item = rs.data;
                    self.id = item.id;

                    if(typeof success == "function"){
                        success(item);
                    }
                }else{
                    App.Swal.error(rs.message);
                }
            }, function(err){
                App.Swal.error("Lỗi không xác định!");
            });
        };

        this.delete = function(id, label){
            if(!label) label = "embed này";
            App.Swal.confirm("bạn có chắc chắn muốn xóa "+label+"?", function(){

                    ajaxRequest(self.urls.delete, "POST", {id:id}, function(rs){
                        if(rs.status){
                            $('#embed-area-'+self.area_id).nestable('remove', id);
                        }else{
                            App.Swal.error(rs.message);
                        }
                    }, function(err){
                        App.Swal.error("Lỗi không xác định!");
                    });

            });
        };

        this.onStart = function() {
            let tpl = $('.nesttable-template');
            self.template = tpl.html();
            tpl.remove();
            let atpl = $('.item-action-template');
            self.actionTemplate = atpl.html();
            atpl.remove();

            $(document).on('click', '.btn-add-embed', function (e) {
                var area_id = $(this).data('area-id');
                self.showForm({area_id:area_id});
            });

            $(document).on('click', '.item-actions .btn-delete-item', function(){
                var area_id = $(this).data('area-id');
                var id = $(this).data('id');
                self.id = id;
                self.area_id = area_id;

                self.delete(id, $(this).data('label'));
            });
            $(document).on('click', '.item-actions .btn-edit-item',function(){
                var area_id = $(this).data('area-id');
                var id = $(this).data('id');
                self.id = id;
                self.area_id = area_id;
                self.detail(id, function(data){
                    self.showForm(data);
                });
            });
        };

    };



    let options = {};
    if(typeof embed_data == 'object'){
        options = embed_data;
    }
    else if(typeof crazy_data == 'object'){
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof crazy_data[act+"_embed_item_url"] == "string"){
                urls[act+"_url"] = crazy_data[act+"_embed_item_url"];
            }
        }
        options.urls = urls;
    }
    let embeds = new EmbedManager(options);
    option = {};
    embeds.init();
    if(typeof App.embeds != "object"){
        App.embeds = {};
    }
    App.embeds = embeds;

});
