$(function(){
    const AttributeValue = function(options) {
        this.urls = {};
        this.id = 0;
        this.attributeData = {};
        this.isGetting = false;
        this.init_list = ["urls"];

        var self = this;

        var $imgSrc = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=";

        /**
         * init
         * @param {object} args 
         */
        this.init = function(args) {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        this.onStart = function() {
            //
        };

        this.getAttributeDetail = function(id){
            if(this.isGetting) return false;
            this.isGetting = true;
            ajaxRequest(this.urls.attribute_detail_url, "GET", {id:id}, function(rs){
                self.isGetting = false;
                if(rs.status){
                    var attribute = rs.data;
                    var title = attribute.label || attribute.name;
                    self.attributeData = rs.data;
                    var valueList = '';
                    if(rs.data.values){
                        valueList = self.renderValueList(rs.data.values);
                    }
                    var content = "<div class=\"attribute-value-list\">"+valueList+"</div>";
                    var buttons = [
                        {
                            type: "button",
                            class: "btn btn-info btn-add-attr-value",
                            text: "<i class=\"fa fa-plus\"></i> Thêm giá trị",
                            click: function(){
                                self.addCurrentAttributeValue();
                            }
                        }
                    ];
    
                    App.modal.custom({
                        size: "lg",
                        title: title,
                        content: content,
                        buttons: buttons
                    });
                }
            }, function(e){
                self.isGetting = false;
                App.modal.error("Lỗi không xác định");
            });
        };
        this.renderValueList = function(values){
            if(!values || !values.length) return '<div class="alert alert-warning">Chưa có giá trị nào</div>';
            var t = self.attributeData.advance_value_type;
            var labels = {
                image: "Hình ảnh",
                color: "Màu sắc",
                default: "không"
            };
            var label = (typeof labels[t] != "undefined") ? labels[t]: "không";

            var table = '<div class="table-responsive attribute-value-list">' +
                '<table class="table table-bordered table-striped ">' + 
                    '<thead>' +
                        '<tr>' +
                            '<th class="id-col">ID</th>' +
                            '<th class="min-160">Giá trị</th>' +
                            '<th class="min-160">Text Hiển thị</th>' +
                            (t != 'default' ? '<th class="min-160 text-center">'+label+'</th>':'') +
                            '<th class="min-100 actions">Thao tác</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                        '{$items}' +
                    '</tbody>' +
                '</table>' +
            '</div>';
            var advance_value_tpl = (t == 'image') ? '<img src="{$image_url}" class="attribute-value-image" />': (
                (t == 'color') ? '<div class="attribute-value-color-background" style="background: {$color}"><img class="attribute-value-image-preview" src="'+$imgSrc+'"></div>': "Không"
            );
            var tr = '<tr id="attribute-value-item-{$id}" class="attribute-value-item" data-name="{$text}">' +
                '<td class="id-col">{$id}</td>' +
                '<td class="min-160">{$value}</td>' +
                '<td class="min-160">{$text}</td>' +
                (t != 'default' ? '<td class="min-160 text-center">'+advance_value_tpl+'</td>':'') +
                '<td class="min-100 actions">' +
                    '<a href="javascript:void(0)" data-id="{$id}" title="Sửa" ' +
                    'class="btn-edit-value text-accent btn btn-outline-accent btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">' +
                        '<i class="flaticon-edit-1"></i>' +
                    '</a>' +
                    '<a href="javascript:void(0);" data-id="{$id}" title="Xóa giá trị" ' +
                    'class="btn-delete-value text-danger btn btn-outline-danger btn-sm m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">' +
                        '<i class="flaticon-delete-1"></i>' +
                    '</a>' +
                '</td>' +
            '</tr>' ;

            var items = '';
            for (let i = 0; i < values.length; i++) {
                const val = values[i];
                items += App.str.eval(tr, val);
            }
            return App.str.eval(table, {items:items});
        };
        this.delete = function(ids){
            var msg = "Bạn có chắc muốn xóa giá trị này không?";
            if(window.confirm(msg)) {
                ajaxRequest(this.urls.delete_url, "DELETE", { ids: ids }, function(rs) {
                    if (rs.status) {
                        if (rs.data) {
    
                            for (var i = 0; i < rs.data.length; i++) {
                                var rmid = rs.data[i];
                                $('.attribute-value-list #attribute-value-item-' + rmid).hide(400, function() {
                                    $(this).remove();
                                });
                            }
    
                        }
                        if(rs.errors.length){
                            App.modal.warning(rs.errors.join("<br>"));
                        }
                    }
                    else if(rs.message){
                        App.modal.warning(rs.message);
                    }
                    else {
                        App.modal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                });
            
            }
        };
        this.edit = function (id){
            ajaxRequest(this.urls.detail_url+"/"+id, "GET", {}, function(rs) {
                if (rs.status) {
                    self.showForm(rs.data);
                }
                else if(rs.message){
                    App.modal.warning(rs.message);
                }
                else {
                    App.modal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                }
            }, function(error){
                App.modal.error("Lỗi không xác định");
            });
        
        };

        this.showForm = function(attributeValue){
            var attrVal = (typeof attributeValue == "object") ? attributeValue : {};
            let attr = this.attributeData;
            let inputTypes = {
                int: "number",
                decimal: "number",
                varchar: "text",
                text: "textarea"
            };
            let inputType = inputTypes[attr.value_type];
            let label = attr.label || attr.name;
            let placeholder = "nhập "+label;
            let inputs = {};

            if(attrVal && attrVal.id){
                inputs.id = {
                    type: "hidden",
                    value: attrVal.id
                };
            }
            inputs.value = {
                type: inputType,
                label: label,
                placeholder: placeholder,
                id: attr.name + '-value',
                validate: function (value) {
                    if(value.length == 0) return false;
                    if(inputType == "number"){
                        if(attr.value_type == "int" && parseInt(value) != value){
                            return false
                        }
                        let numberValue = Number(value);
                        return !isNaN(numberValue);
                    }
                    return true;
                }
            }

            if(attr.value_type == "decimal"){
                inputs.value.step = 0.1;
            }

            if(attr.value_type != 'text'){
                inputs.text = {
                    type: "text",
                    label: "Text hiển thị",
                    placeholder: "Không bắt buộc"
                }
            }
            if(attr.advance_value_type == "image"){
                inputs.image_data = {
                    type: "file",
                    label: "Hình ảnh",
                    id: "attribute-value-image-input",
                    value: attrVal.advance_value
                };
            }
            else if(attr.advance_value_type == "color"){
                inputs.color = {
                    type: "text",
                    label: "Màu sắc",
                    id: "attribute-value-color-input",
                    append: '<button type="button" class="btn btn-info color-picker-btn" data-input-id="attribute-value-color-input"><i class="fa fa-paint-brush"></i></button>',
                    value: attrVal.advance_value
                };
            }
            if(attrVal){
                if(typeof attrVal[attr.value_type + "_value"] != "undefined"){
                    inputs.value.value = attrVal[attr.value_type + "_value"];
                }
                if(attr.value_type != 'text'){
                    inputs.text.value = attrVal.text_value || ""; 
                }

            }
            var popup_data = {
                title: "Thêm giá trị "+label,
                inputs: inputs,
                btnDone: "Thêm",
                size: "md",
                done: function(data){
                    if(data.image_data){
                        if(data.image_data.length){
                            data.image = data.image_data[0].data;
                        }
                        data.image_data = null;
                    }
                    let failCallback = function(){
                        setTimeout(function(){
                            App.modal.hide_callback = function(){
                                App.modal.show('popup-modal');
                            }
                        })
                    };
                    data.attribute_id = attr.id;
                    self.saveAttributeValue(data, function(rs){
                        self.getAttributeDetail(attr.id);
                    }, function(ers){
                        if(ers.errors){
                            let messages = [];
                            for (const key in rs.errors) {
                                if (object.hasOwnProperty(key)) {
                                    const element = rs.errors[key];
                                     messages.push(element);
                                }
                            }
                            App.modal.error(messages.join('<br />'), failCallback);
                        }
                    });
                }
            };
            App.modal.popup(popup_data, null, null, function(popup, modal){
                if(modal.last_open != "color-picker-modal"){
                    modal.show('custom-modal');
                }
            });
        };

        /**
         * thêm giá trị tro attribute hiện ại
         */
        this.addCurrentAttributeValue = function(){
            this.showForm();
        };
        /**
         * thêm giá trị cho thuộc tính
         * @param {object} data 
         * @param {function} calback
         * @return {void}
         */
        this.saveAttributeValue = function(data, success, fail){
            if(typeof success != "function") success = cl;
            if(typeof fail != "function") fail = null;
            var url = self.urls.add_url;
            var method = "POST";
            if(data.id){
                url = self.urls.update_url + "/"+data.id;
                method = "PUT";
            }
            ajaxRequest(url, method, data, function(rs){
                if(rs.status){
                    success(rs);
                }else if(fail){
                    fail(rs);
                }
                else if(rs.errors){
                    let messages = [];
                    for (const key in rs.errors) {
                        if (object.hasOwnProperty(key)) {
                            const element = rs.errors[key];
                             messages.push(element);
                        }
                    }
                    App.modal.error(messages.join('<br />'));
                }else{
                    App.modal.warning(rs.message);
                }
            }, function(e){
                if(fail){
                    fail(e);
                }
                else{
                    App.modal.error("Lỗi không xác định");
                }
                
            })
    
        };
        
    };

    
    if(typeof Attribute == "undefined"){
        Attribute = {};
    }

    Attribute.values = new AttributeValue({});

    if (typeof window.attributeValuesInit == 'function') {
        window.attributeValuesInit();
        window.attributeValuesInit = null;
        $('.btn-view-attribute-values').click(function(){
            Attribute.values.getAttributeDetail($(this).data('id'));
        });

        $(document).on('click', '.attribute-value-item .btn-delete-value', function(){
            Attribute.values.delete([$(this).data('id')]);
        });
        $(document).on('click', '.attribute-value-item .btn-edit-value', function(){
            Attribute.values.edit([$(this).data('id')]);
        });

        
    }
});





