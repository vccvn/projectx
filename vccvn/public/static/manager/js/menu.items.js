$(function(){
    const MenuItem = function(options) {
        this.urls = {};
        this.id = 0;
        this.icons = {};
        this.template = "";
        this.actionTemplate = "";
        this.init_list = ["urls", "template"];
        this.options = options;
        this.selectTypes = ["page", "dynamic", "product_category", "project_category", "post_category", "route"];
        this.currentModal = null;
        this.iconInput = null;
        this.iconSearchKeywords = '';
        this.subTypes = {
            "default": "Mặc định",
            "item": "Chỉ theo loại Item",
            "custom": "Chỉ tùy biến "
        };
        var self = this;
        /**
         * init
         * @param {object} args
         */
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        this.applyProps = (item, props) => {
            for (const key in props) {
                if (props.hasOwnProperty(key)) {
                    const value = props[key];
                    item[key] = value;
                }
            }
            item.props = null;
        };

        this.enableSort = function(){
            App.nestable.add('#crazy-menu-item-list');
        };
        this.disableSort = function(){
            App.nestable.remove('#crazy-menu-item-list');
        };

        this.sortCallback = function(l, e){
            var items = $(l).nestable('serialize');
            App.api.post(self.urls.sort, {items:items}).then(function(rs){
                if(rs.status){
                    console.log(rs.message);
                }
                else{
                    App.Swal.error(rs.message);
                }
            }).catch(function(err){
                App.Swal.error("Lỗi không xác định");
            });
        };

        this.delete = function(id){
            App.Swal.confirm("bạn có chắc chắn muốn xóa item này?", function(){
                    ajaxRequest(self.urls.delete, "POST", {id:id}, function(rs){
                        if(rs.status){
                            $('#crazy-menu-item-list').nestable('remove', id);
                        }else{
                            App.Swal.error(rs.message);
                        }
                    }, function(err){
                        //
                        App.Swal.error("Lỗi không xác định!");
                    });

            });
        };

        this.fill = function(group, data, list){
            if(list && list.length){
                for (let i = 0; i < list.length; i++) {
                    const key = list[i];
                    let input = $('#'+group+'-'+key);
                    if(input.length){
                        if(data.hasOwnProperty(key)){
                            input.val(data[key]);
                        }
                    }else{
                        input.val(data[key]);
                    }
                }
            }else{
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const value = data[key];
                        let input = $('#'+group+'-'+key);
                        if(input.length){
                            input.val(value);
                        }
                    }
                }
            }
        }

        this.showForm = function(prefix){
            App.modal.show('menu-item-modal-'+prefix, null, function(){
                //
                $('#menu-item-modal-'+prefix +' form').find('input[type="text"]').val("");
            });
        };

        this.showFormData = function(data){
            let prefix = data.type;
            if(prefix == 'post_category'){
                prefix += '-'+data.dynamic_id;
            }
            this.fill(prefix, data, ["id", "text", "class", "link_class", "icon", "active_key", "url", "show_submenu"]);
            let target = $('#'+prefix+'-target');
            if(target.length){
                target.find('option').prop('selected', false);
                target.find('#'+prefix+'-target-'+data.target).prop('selected', true);
            }
            let sub_type = $('#'+prefix+'-sub_type');
            if(sub_type.length){
                sub_type.find('option').prop('selected', false);
                sub_type.find('#'+prefix+'-sub_type-'+data.sub_type).prop('selected', true);
            }

            if(self.selectTypes.indexOf(data.type) >= 0){
                console.log(data)
                if(data.type == 'route'){
                    App.htmlSelect.active(prefix+'-'+data.type, data.route);
                }else if(data.type != 'post_category'){
                    App.htmlSelect.active(prefix+'-'+data.type+"_id", data.ref_id);
                }else{
                    // cl (prefix+'-'+data.type+"_id-dynamic-"+data.dynamic_id);
                    App.htmlSelect.active(prefix+'-'+data.type+"_id-dynamic-"+data.dynamic_id, data.ref_id);
                }

            }

            this.showForm(prefix);


        };
        this.showUpdateForm = function(id){
            ajaxRequest(self.urls.detail, "GET", {id:id}, function(rs){
                if(rs.status){
                    self.id = id;
                    var item = rs.data;
                    self.applyProps(item, item.props);
                    self.showFormData(item);
                }else{
                    App.Swal.error(rs.message);
                }
            }, function(err){
                App.Swal.error("Lỗi không xác định!");
            });
        };

        this.resetForm = function(form, data) {
            var $f = $(form);
            $f.find('input[type="text"]').val("");
            var type = $f.find('input[name="type"]').val();
            var prefix = $f.data('prefix');
            var select = $f.find('select#'+prefix+'-target');
            if(select.length){
                select.find('option').prop('selected', false);
                $f.find('#'+prefix+'-target-default').prop('selected', false);
            }
            if(self.selectTypes.indexOf(data.type) >= 0){
                if(data.type != 'post_category'){
                    App.htmlSelect.active(prefix+'-'+data.type+"_id", 0);
                }else{
                    App.htmlSelect.active(prefix+'-'+data.type+"_id-dynamic-"+data.dynamic_id, 0);
                }
            }
            else if(type == 'route'){

            }

        };

        this.save = function(data, success){
            App.modal.hide();
            ajaxRequest(self.urls.save, "POST", data, function(rs){
                if(rs.status){
                    var data = rs.data;
                    data.subType = (typeof data.sub_type != "undefined" && typeof self.subTypes[data.sub_type] != "undefined") ? self.subTypes[data.sub_type] : self.subTypes['default'];
                    data.text = data.props.text?data.props.text:"icon: " + (data.props.icon || "default");
                    if(self.id && data.id == self.id){
                        //
                        var itemText = $('#crazy-menu-item-list li.dd-item[data-id="'+data.id+'"]>.dd-handle>.item-text');
                        if(itemText.length){
                            itemText.html(data.text + '<span class="submenu-type-label"> sub menu: '+data.subType+'</span>');
                        }else{
                            $('#crazy-menu-item-list').nestable('replace', {id:rs.data.id,content:App.str.eval(self.template, data)});
                            var item = $('#crazy-menu-item-list li.dd-item[data-id="'+data.id+'"]');
                            if(item.length){
                                var itemActions = item.find('.item-actions');
                                if(!itemActions.length){
                                    item.prepend(App.str.eval(self.actionTemplate, data));
                                }
                            }
                        }
                    }else{
                        $('#crazy-menu-item-list').nestable('add', {id:rs.data.id,content:App.str.eval(self.template, data)});
                        var item = $('#crazy-menu-item-list li.dd-item[data-id="'+data.id+'"]');
                        if(item.length){
                            item.prepend(App.str.eval(self.actionTemplate, {id:data.id}));
                        }
                    }

                    var empty = $('#crazy-menu-item-list .dd-empty');
                    if(empty.length){
                        empty.remove();
                    }

                    self.id = 0;
                    if(typeof success == "function"){
                        success(data);
                    }
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
                    App.Swal.error(message);
                }
            }, function(error){
                App.Swal.error("Lỗi không xác định!");
            });
        };

        this.onStart = function() {
            let tpl = $('.nesttable-template');
            self.template = tpl.html();
            tpl.remove();
            let atpl = $('.item-action-template');
            self.actionTemplate = atpl.html();
            atpl.remove();
            this.enableSort();

            $(document).on('click', '.btn-add-menu-item', function(){
                self.showFormData();
            });
            $(document).on('click', '.item-actions .btn-delete-item', function(){
                self.delete($(this).data('id'));
            });
            $(document).on('click', '.item-actions .btn-edit-item',function(){
                self.showUpdateForm($(this).data('id'));
            });

            $('.add-menu-item-form').submit(function(e){
                e.preventDefault();
                var $form = $(this);
                var data = $form.serializeArray();

                self.save(data, function (rs) {
                    self.resetForm($form, rs);
                });

                return false;
            });

            $('.update-menu-item-form').submit(function(e){
                e.preventDefault();
                var $form = $(this);
                var data = $form.serializeArray();
                self.save(data, function (rs) {
                    self.resetForm($form, rs);
                });
                return false;
            });


        };

    };



    let options = {};
    if(typeof menu_data == 'object'){
        options = menu_data;
    }
    else if(typeof crazy_data == 'object'){
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof crazy_data[act+"_menu_item_url"] == "string"){
                urls[act+"_url"] = crazy_data[act+"_menu_item_url"];
            }
        }
        options.urls = urls;
    }
    let menu_item = new MenuItem(options);
    option = {};
    menu_item.init();
    if(typeof App.menu != "object"){
        App.menu = {};
    }
    App.menu.items = menu_item;

});
