$(function(){
    const ProductVariant = function (options) {
        this.getAttrInputUrl = '';
        this.jsTagSrc = '';
        this.onSale = false;
        this.options = options;
        this.init_list = ["getAttrInputUrl", "jsTagSrc"];
        var self = this;
        /**
         * init
         * @param {object} args 
         */
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        // dc gọi khi object dc khoi tao
        this.onStart = () => {
            // code

        };

        // thêm hoặc xóa bỏ class ẩn hiện chỗ này lằng nhằng
        this.toggleBy = function (ref, status) {
            var refNode = $('.toggle-by-'+ref);
            if(refNode.length){
                if(status){
                    refNode.removeClass("hide-by-"+ref);
                }else if(!refNode.hasClass("hide-by-"+ref)){
                    refNode.addClass("hide-by-"+ref);
                }
            }

            var rNode = $('.rtoggle-by-'+ref);
            if(rNode.length){
                if(!status){
                    rNode.removeClass("hide-by-"+ref);
                }else if(!rNode.hasClass("hide-by-"+ref)){
                    rNode.addClass("hide-by-"+ref);
                }
            }
        };
        
        /**
         * kiểm tra trạng thái sale
         */
        this.checkOnSaleStatus = function(stt){
            this.toggleBy('on-sale-status', stt);
        };
    
        this.changeProduct = function(id){
            let variant_id = $('.crazy-form #hidden-id').val();
            let data = {
                product_id: id,
                variant_id: variant_id
            };
            ajaxRequest(this.getAttrInputUrl, "GET", data, function(rs){
                if(rs.status){
                    let category_group = $('#product-attributes .scope-category');
                        if(category_group.length){
                            category_group.remove();
                        }
                        
                    if(rs.data){
                        for (let i = 0; i < rs.data.length; i++) {
                            const attr = rs.data[i];
                            let code = attr.html_code;
                            let existsGroup = $('#attributes-'+attr.input_name+'-'+attr.input_id+'-form-group');
                            if(existsGroup.length){
                                existsGroup.removeClass('d-none');
                            }
                            else{
                                $('#product-attributes .attribute-inputs').append(code);
                                // if(attr.input_type == 'tags'){
                                //     self.addTagInput(attr.input_name);
                                // }
                            }
                        }
                    }
                }
            }, function(res){
                cl(res);
            });
        }
    
        this.addTagInput = function(name){
            let $input = $('#attributes-'+name+'.crazy-tag');
            if(!App.tagInput){
                this.addTagLib();
                // setTimeout(function(){
                //     App.tagInput.add($input);
                // }, 300);
            }else{
                App.tagInput.add($input);
            }
        };

    };

    var options = {};
    if(crazy_form_data){
        if(crazy_form_data.attributes){
            let attributes = crazy_form_data.attributes;
            options.getAttrInputUrl = attributes.input_url;
            options.jsTagSrc = attributes.tag_srx;
        }
    }
    var product_variant = new ProductVariant(options);
    product_variant.init();
    if(typeof window.Product != 'object'){
        window.Product = {};
    }
    window.Product.variant = product_variant;
    if($('.crazy-form').length){
        if($('input#on_sale').length){
            Product.variant.checkOnSaleStatus($('input#on_sale').is(':checked'));
        }
    }

});
