$(function(){
    const SettingItem = function(options) {
        this.urls = {};
        this.id = 0;
        this.template = "";
        this.actionTemplate = "";
        this.init_list = ["urls", "template"];
        this.options = options;
        var self = this;
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        this.onStart = function() {
            let tpl = $('.nesttable-template');
            self.template = tpl.html();
            tpl.remove();
            let atpl = $('.item-action-template');
            self.actionTemplate = atpl.html();
            atpl.remove();
            this.enableSort();

            $(document).on('click', '.btn-add-setting-item', function(){
                self.showFormData();
            });
            $(document).on('click', '.item-actions .btn-delete-item', function(){
                self.delete($(this).data('id'));
            });
            $(document).on('click', '.item-actions .btn-edit-item',function(){
                self.showUpdateForm($(this).data('id'));
            });

            $('#add-setting-item-form').submit(function(e){
                e.preventDefault();
                let data = $(this).serializeArray();
                App.modal.hide();
                ajaxRequest($(this).attr('action'), "POST", data, function(rs){
                    if(rs.status){

                        let data = rs.data;
                        // data.show_label = data.show?"Có":"";
                        if(self.id){
                            //
                            let item = $('#crazy-setting-item-list li.dd-item[data-id="'+data.id+'"]');
                            if(item.length){
                                item.find('.skill-name').html(data.name);

                            }else{
                                $('#crazy-setting-item-list').nestable('replace', {id:rs.data.id,content:App.str.eval(self.template, data)});
                            }
                        }else{
                            $('#crazy-setting-item-list').nestable('add', {id:rs.data.id,content:App.str.eval(self.template, data)});
                            let item = $('#crazy-setting-item-list li.dd-item[data-id="'+data.id+'"]');
                            if(item.length){
                                item.prepend(App.str.eval(self.actionTemplate, {id:data.id}));

                            }
                        }
                        self.id = 0;
                    }
                    else{
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
                            self.showForm();
                        });
                    }
                }, function(error){
                    self.showForm();
                });
                return false;
            });
        };

        this.enableSort = function(){
            App.func.call("App.nestable.add", ['#crazy-setting-item-list']);
        };
        this.disableSort = function(){
            App.func.call("App.nestable.remove", ['#crazy-setting-item-list']);
        };

        this.sortCallback = function(l, e){
            var self = this;
            let raw = $(l).nestable('toArray');
            let data = {};
            raw.map(function (item, i) {
                data[item.id] = i+1;
            });

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
        };
        this.delete = function(id){
            App.Swal.confirm("bạn có chắc chắn muốn xóa setting này?", function(){
                    showLoading();
                    ajaxRequest(self.urls.delete, "POST", {id:id}, function(rs){
                        hideLoading();
                        if(rs.status){
                            $('#crazy-setting-item-list').nestable('remove', id);
                        }else{
                            App.Swal.error(rs.message);
                        }
                    }, function(err){
                        //
                        hideLoading();
                        App.Swal.error("Lỗi không xác định!");
                    });

            });
        };
        this.changeInputType = function(type){
            var search = '';
            var val = '';
            if (type == 'number'){
                search = type;
                val = type;
            }
            else if(type == 'checkbox' || type == 'switch'){
                val = 'boolean',
                search = 'text,number,boolean';
            }else if(type == 'email' || type == 'tel' || type == 'date' || type == 'daterange' || type == 'time' || type == 'file'){
                val = 'text',
                search = 'text';
            }else{
                val = 'text',
                search = 'text,number';
            }
            App.htmlSelect.staticSearch('value_type', search);
            App.htmlSelect.active('value_type', val);
        };

        this.showForm = function(){
            App.modal.show('setting-item-modal');
        };

        this.showFormData = function(data){
            let form = {id: "", name: "", label: "", type: "text", value_type: "text"};
            if(typeof data != "undefined" && App.getType(data) == 'object'){
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const val = data[key];
                        form[key] = val;
                    }
                }
            }

            $("#setting-item-id").val(form.id);
            $("#setting-item-name").val(form.name);
            $("#setting-item-label").val(form.label);

            App.htmlSelect.active("value_type", form.type);

            App.htmlSelect.active("value_type", form.value_type);
            if(form.id){
                $('#add-setting-item-form .btn-submit').html("Cập nhật");
            }else{
                $('#add-setting-item-form .btn-submit').html("Thêm");
            }
            this.showForm();

        };
        this.showUpdateForm = function(id){
            ajaxRequest(self.urls.detail, "GET", {id:id}, function(rs){
                if(rs.status){
                    self.id = id;
                    self.showFormData(rs.data);
                }else{
                    App.Swal.error(rs.message);
                }
            }, function(err){
                App.Swal.error("Lỗi không xác định!");
            });
        };
    };



    let options = {};
    if(typeof setting_data == 'object'){
        options = setting_data;
    }
    else if(typeof crazy_data == 'object'){
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof crazy_data[act+"_setting_item_url"] == "string"){
                urls[act+"_url"] = crazy_data[act+"_setting_item_url"];
            }
        }
        options.urls = urls;
    }

    let setting_item = new SettingItem(options);
    setting_item.init();
    if(typeof App.setting != "object"){
        App.setting = {};
    }
    App.setting.items = setting_item;

});
