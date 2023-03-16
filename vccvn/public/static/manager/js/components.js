$(function () {
    const Component = function (options) {
        this.urls = {};
        this.id = 0;
        this.area_id = 0;
        this.template = "";
        this.actionTemplate = "";
        this.list = {};
        
        this.searchKeywords = '';
        this.init_list = ["urls", "template", "list"];
        this.options = options;
        this.files = {};
        var self = this;
        this.titleBy = 'name';

        /**
         * init
         * @param {object} args 
         */
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        this.getItemList = function(ddlist){
            var list = [];
            var children = ddlist.children('.dd-item');
            if(children.length){
                for (let i = 0; i < children.length; i++) {
                    const child = children[i];
                    const $child = $(child);
                    var item = {
                        id: $child.data('id'),
                        priority: i,
                        children: []
                    };

                    var l = $child.children('.dd-list');
                    if(l.length){
                        
                        item.children = this.getItemList(l);
                    }
                    list.push(item);

                }
            }
            return list;
        };

        this.sortCallback = function (l,e) {
            var data = [];
            // var items = $(l).nestable('serialize');
            // console.log(items);
            setTimeout(function () {
                var listArea = $('.component-list-body');
                if (listArea.length) {
                    let btnClass = ["btn-edit-item", "btn-delete-item"];
                    for (let i = 0; i < listArea.length; i++) {
                        const l = listArea[i];
                        let area = {};
                        area.area_id = $(l).data('area-id');
                        area.components = [];
                        let raw = $(l).find('.dd-list .dd-item');
                        let ddlist = $(l).children('.dd-list');
                        if(ddlist.length){
                            area.components = self.getItemList(ddlist);
                        }
                        for (let j = 0; j < raw.length; j++) {
                            const item = raw[j];
                            // area.components[$(item).data('id')] = j + 1;
                            for (let k = 0; k < btnClass.length; k++) {
                                const bc = btnClass[k];
                                let btn = $(item).find('.item-actions .' + bc);
                                if (btn.length && btn.data('area-id') != area.area_id) {
                                    btn.data('area-id', area.area_id);
                                }
                            }
                        }
                        data.push(area);
                    }

                    App.api.post(self.urls.sort, { data: data })
                    .then(function (rs) {
                        if (rs.status) {
                            console.log(rs.message);
                        }
                        else {
                            App.Swal.error(rs.message);
                        }
                    })
                    .catch(function (err) {
                        App.Swal.error("Lỗi không xác định");
                    });
                }
            }, 200);


        };

        this.changeComponentSelected = function (component_id) {
            var area_id = $("#component-area-id").val();
            var id = $("#component-html-id").val();
            var data = {
                component_id: component_id,
                area_id: area_id
            };
            if (id) {
                data.id = id;
            }
            if (!data.component_id) {
                return App.Swal.warning("Vui lòng chọn một component", null, function () {
                    self.show();
                });
            }
            ajaxRequest(this.urls.inputs, "POST", data, function (rs) {
                if (rs.status) {
                    var inputs = rs.data || '';
                    $('.componnent-data-input').html(inputs);
                    self.files = {};
                    var inputFiles = $('#component-form').find('input[type="file"]');
                    if (inputFiles.length) {
                        inputFiles.attr("data-on-change", "App.components.onFileChange");
                    }
                    var select = $('.componnent-data-input .crazy-select');
                    if (select.length) {
                        select.each(function (i, el) {
                            App.htmlSelect.add(el);
                        });
                    }
                } else {
                    App.Swal.warning(rs.message, null, function () {
                        self.show();
                    });
                }
            }, function (error) {
                App.Swal.error(error + "");
            });
        };


        this.showForm = function (data) {
            var d = {
                area_id: data.area_id || "",
                id: data.id || "",
                component_id: data.component_id || 0,
                inputs: data.inputs || ""
            };
            $("#component-area-id").val(d.area_id);
            $("#component-html-id").val(d.id);
            $('.componnent-data-input').html(d.inputs);
            $('#component_id').val(d.component_id)
            self.files = {};
            var inputFiles = $('#component-form').find('input[type="file"]');
            if (inputFiles.length) {
                inputFiles.attr("data-on-change", "App.components.onFileChange");
            }
            var select = $('.componnent-data-input .crazy-select');
            if (select.length) {
                select.each(function (i, el) {
                    App.htmlSelect.add(el);
                });
            }
            var text = 'Thêm';
            if(d.id){
                text = "Cập nhật";
            }
            $('#component-modal-title span').html(text + " component");
            $('#component-form').find('button[type="submit"]').html(text);
            var ckeditors = $('#component-form').find('textarea.text-editor');
            if(ckeditors.length){
                ckeditors.each(function(i, e){
                    addCkeditor(e);
                })
            }
            App.modal.show('component-modal');
        };

        this.onFileChange = function (input, files) {
            if (files.length) {
                self.files[input.name] = files[0].data;
            } else {
                self.files[input.name] = "";
            }
        }

        this.hide = function () {
            App.modal.hide('component-modal');
        };

        this.show = function () {
            App.modal.show('component-modal');
        };

        this.save = function (data) {
            self.hide();
            if (!data.component_id) return App.modal.error("component không hợp lệ", null, function () {
                self.show();
            });
            ajaxRequest(self.urls.save, "POST", data, function (rs) {
                if (rs.status) {
                    var data = rs.data;
                    var area_id = data.area_id;
                    // data.show_label = data.show?"Có":"";
                    if (self.id && data.id == self.id) {
                        //
                        var titleBy = $('#component-area-' + area_id).data('title-by'); 
                        var itemText = $('#component-area-' + area_id + ' li.dd-item[data-id="' + data.id + '"]>.dd-handle>.component-name');
                        if (itemText.length) {
                            if(titleBy && data.data[titleBy]){
                                itemText.html(data.data[titleBy]);
                            }
                            else{
                                itemText.html(data.name);
                            }

                        } else {
                            if(titleBy && data.data[titleBy]){
                                data.name = data.data[titleBy];
                            }
                            $('#component-area-' + area_id).nestable('replace', { id: rs.data.id, content: App.str.eval(self.template, data) });
                            var item = $('#component-area-' + area_id + ' li.dd-item[data-id="' + data.id + '"]');
                            if (item.length) {
                                var itemActions = item.find('.item-actions');
                                if (!itemActions.length) {
                                    item.prepend(App.str.eval(self.actionTemplate, data));
                                }
                            }
                        }
                    } else {
                        if(titleBy && data.data[titleBy]){
                            data.name = data.data[titleBy];
                        }
                        
                        $('#component-area-' + area_id).nestable('add', { id: rs.data.id, content: App.str.eval(self.template, data) });
                        var item = $('#component-area-' + area_id + ' li.dd-item[data-id="' + data.id + '"]');
                        if (item.length) {
                            item.prepend(App.str.eval(self.actionTemplate, data));
                        }
                    }

                    var empty = $('#component-area-' + area_id + ' .dd-empty');
                    if (empty.length) {
                        empty.remove();
                    }

                    self.id = 0;
                }
                else {
                    var message = '';
                    if (rs.errors) {
                        var messages = [];
                        for (const key in rs.errors) {
                            if (rs.errors.hasOwnProperty(key)) {
                                const error = rs.errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    } else {
                        message = rs.message;
                    }
                    App.Swal.error(message, null, function () {
                        self.show();
                    });
                }
            }, function (err) {
                App.Swal.error("Lỗi không xác định!", null, function () {
                    self.show();
                });
            });
        };


        this.detail = function (id, success) {
            ajaxRequest(self.urls.detail, "GET", { id: id }, function (rs) {
                if (rs.status) {
                    var item = rs.data;
                    self.id = item.id;

                    if (typeof success == "function") {
                        success(item);
                    }
                } else {
                    App.Swal.error(rs.message);
                }
            }, function (err) {
                App.Swal.error("Lỗi không xác định!");
            });
        };

        this.delete = function (id, label) {
            if (!label) label = "component này";
            App.Swal.confirm("bạn có chắc chắn muốn xóa " + label + "?", function (status) {
                // if (status) {
                    ajaxRequest(self.urls.delete, "POST", { id: id }, function (rs) {
                        if (rs.status) {
                            $('#component-area-' + self.area_id).nestable('remove', id);
                        } else {
                            App.Swal.error(rs.message);
                        }
                    }, function (err) {
                        App.Swal.error("Lỗi không xác định!");
                    });
                // }
            });
        };

        this.generalCpmponents = function(keyword){
            var keywords = [];

            if(typeof keyword != "undefined"){
                let k = App.str.clearUnicode(''+keyword);
                keyword = String(k).toLocaleLowerCase();
                let kws = keyword.split(',');
                kws.map(function(kw, ind){
                    let k = kw.trim();
                    if(k!=='' && k!==' '){
                        keywords.push(k);
                    }
                });
            }
            if(this.list){
                for (const groupName in this.list) {
                    if (this.list.hasOwnProperty(groupName)) {
                        const list = this.list[groupName];
                        var listHtml = '<div class="row">';
                        var t = list.length;
                        if(keywords.length){
                            for (const id in list) {
                                if (list.hasOwnProperty(id)) {
                                    const name = list[id];
                                    let isSearch = false;
                                    keywords.forEach(text => {
                                        if(!isSearch){
                                            var n = App.str.clearUnicode(String(name).toLocaleLowerCase());
                                            if(n.split(text).length > 1){
                                                listHtml += '<div class="col-sm-6 col-md-6 col-lg-3">'
                                                    +'<div class="m-demo-icon component-item" data-id="'+id+'">'
                                                        +'<div class="m-demo-icon__preview">'
                                                            +'<i class="fa fa-puzzle-piece"></i>'
                                                        +'</div>'
                                                        +'<div class="m-demo-icon__class">' + name + '</div>'
                                                    +'</div>'
                                                +'</div>';            
                                            }
                                        }
                                    });
                                }
                            }
                        }else{
                            for (const id in list) {
                                if (list.hasOwnProperty(id)) {
                                    const name = list[id];
                                    listHtml += '<div class="col-sm-6 col-md-6 col-lg-3">'
                                        +'<div class="m-demo-icon component-item" data-id="'+id+'">'
                                            +'<div class="m-demo-icon__preview">'
                                                +'<i class="fa fa-puzzle-piece"></i>'
                                            +'</div>'
                                            +'<div class="m-demo-icon__class">' + name + '</div>'
                                        +'</div>'
                                    +'</div>';            
                                }
                            }
                        }
                        listHtml+='</div>';
                        $('#component-select-modal .'+groupName+'-component-list').html(listHtml);
                    
                    
                    }
                }
            }
                
        };
        this.changeDynamicID = function(id){
            App.api.get(this.urls.get_category_url, {dynamic_id:id}).then(function(rs){
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
        };
        this.onStart = function () {

            let tpl = $('.nesttable-template');
            self.template = tpl.html();
            tpl.remove();
            let atpl = $('.item-action-template');
            self.actionTemplate = atpl.html();
            atpl.remove();

            
            this.generalCpmponents();

            
            $(document).on('input', '#search-component-select-input', function () {
                var keyword = $(this).val();
                self.searchKeywords = keyword;
                self.generalCpmponents(keyword);
            });

            
            $(document).on('click', '.component-select-modal .component-item', function(){
                var id = $(this).data('id');
                self.showForm({ area_id: self.area_id, component_id: id });
                self.changeComponentSelected(id);
            });
        
            $(document).on('click', '.btn-add-component', function (e) {
                var area_id = $(this).data('area-id');
                self.area_id = area_id;
                App.modal.show("component-select-modal");
            });

            $(document).on('click', '.item-actions .btn-delete-item', function () {
                var area_id = $(this).data('area-id');
                var id = $(this).data('id');
                self.id = id;
                self.area_id = area_id;

                self.delete(id, $(this).data('name'));
            });
            $(document).on('click', '.item-actions .btn-edit-item', function () {
                var area_id = $(this).data('area-id');
                var id = $(this).data('id');
                self.id = id;
                self.area_id = area_id;
                self.detail(id, function (data) {
                    self.showForm(data);
                });
            });

            $('#component-form').submit(function (e) {
                e.preventDefault();

                try {
                    var data = $(this).serializeArray();
                    var d = {};
                    for (let i = 0; i < data.length; i++) {
                        const inp = data[i];
                        if(inp.name.substr(inp.name.length - 2, 2) == '[]'){
                            let n = inp.name.substr(0, inp.name.length - 2);

                            if(typeof d[n] == "undefined"){
                                d[n] = [];
                            }
                            d[n].push(inp.value);
                        }else{
                            d[inp.name] = inp.value;
                        }
                        
                    }

                    var inputFiles = $(this).find('input[type="file"]');
                    if (inputFiles.length) {
                        for (let n = 0; n < inputFiles.length; n++) {
                            const inp = inputFiles[n];
                            if (typeof self.files[inp.name] != "undefined" && self.files[inp.name].length) {
                                d[inp.name + "_data"] = self.files[inp.name];
                            }
                        }
                    }

                    self.save(d);

                } catch (error) {

                }
                return false;
            });

        };
    };



    let options = {};
    if (typeof component_data == 'object') {
        options = component_data;
    }
    if (typeof crazy_data == 'object') {
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if (typeof crazy_data[act + "_component_item_url"] == "string") {
                urls[act + "_url"] = crazy_data[act + "_component_item_url"];
            }
        }
        options.urls = urls;
    }
    let components = new Component(options);
    option = {};
    components.init();
    if (typeof Crazy != "object") {
        Crazy = {};
    }
    App.components = components;

});
