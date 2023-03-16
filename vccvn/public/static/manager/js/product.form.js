if(typeof Product == "undefined"){
    Product = {};
}

Product.form = {
    getAttrInputUrl:'',
    jsTagSrc:'',
    onSale:false,
    removeGroupsClasss:function(groups, groupClass, time){
        if(typeof time == "undefined") time = 0;
        if(time){
            for (let i = 0; i < groups.length; i++) {
                const group = groups[i];
                setTimeout(function(){
                    $('#'+group+'-form-group').removeClass(groupClass);
                }, time+i*50);
                
            }
            return true;
        }
        for (let i = 0; i < groups.length; i++) {
            const group = groups[i];
            $('#'+group+'-form-group').removeClass(groupClass);
        }
        return true;
        
    },
    addGroupsClass:function(groups, groupClass, time){
        if(typeof time == "undefined") time = 0;
        if(time){
            for (let i = 0; i < groups.length; i++) {
                const group = groups[i];
                setTimeout(function(){
                    $('#'+group+'-form-group').addClass(groupClass);
                }, time+i*50);
                
            }
            return true;
        }
        for (let i = 0; i < groups.length; i++) {
            const group = groups[i];
            $('#'+group+'-form-group').addClass(groupClass);
        }
        return true;
    },
    getTagsHaveToggle: function(togglePrefix){
        var toggle = $('.crazy-form .toggle-by-'+togglePrefix);
        return toggle.length ? toggle : null;
    },
    addHiddenClassBy: function(togglePrefix){
        var toggle = this.getTagsHaveToggle(togglePrefix);
        if(toggle) toggle.addClass('hide-by-'+togglePrefix);
    },
    removeHiddenClassBy: function(togglePrefix){
        var toggle = this.getTagsHaveToggle(togglePrefix);
        if(toggle) toggle.removeClass('hide-by-'+togglePrefix);
    },
    checkOnSaleStatus: function(stt){
        if(stt){
            this.removeHiddenClassBy('on-sale-status');
        }else{
            this.addHiddenClassBy('on-sale-status');
        }
    },

    changeCategory:function(id){
        let product_id = $('.crazy-form #hidden-id').val();
        let data = {
            category_id: id,
            product_id: product_id
        };
        var self = this;
        ajaxRequest(this.getAttrInputUrl, "GET", data, function(rs){
            if(rs.status){
                let category_group = $('#attributes-form-group .scope-category');
                if(category_group.length){
                    category_group.addClass('d-none');
                }
                
                if(rs.data){
                    for (let i = 0; i < rs.data.length; i++) {
                        const attr = rs.data[i];
                        let code = attr.html_code;

                        if(attr.input_group == 'variants'){
                            let variantexistsGroup = $('#product-variants-tab #variants-'+attr.input_name+'-'+attr.input_id+'-form-group');
                            if(variantexistsGroup.length){
                                variantexistsGroup.removeClass('d-none');
                                // existsGroup.remove();
                            }
                            else{
                                $('#product-attributes-'+attr.input_group).append(code);
                                if(attr.input_type == 'tags'){
                                    self.addTagInput(attr.input_name);
                                }
                            }
                        }
                        else{
                            let existsGroup = $('#product-attributes-tab #attributes-'+attr.input_name+'-'+attr.input_id+'-form-group');
                        
                            if(existsGroup.length){
                                existsGroup.removeClass('d-none');
                                // existsGroup.remove();
                            }
                            else{
                                $('#product-attributes-'+attr.input_group).append(code);
                                if(attr.input_type == 'tags'){
                                    self.addTagInput(attr.input_name);
                                }
                            }
                        }
                        
                    }
                }
            }
        }, function(res){
            cl(res);
        });
    },

    addTagInput: function(name){
        let $input = $('#attributes-'+name+'.crazy-tag');
        if(!App.tagInput){
            this.addTagLib();
            // setTimeout(function(){
            //     App.tagInput.add($input);
            // }, 300);
        }else{
            App.tagInput.add($input);
        }
    },

    addTagLib:function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.src=this.jsTagSrc;
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    },

    onVariantChange: function (status, el) { 
        var value_id = $(el).data('value');
        var $wrapper = $('#product-variant-value-'+value_id);
        if($wrapper.length){
            var $option = $wrapper.find('.variant-option');
            if(status){
                $option.addClass('show');
            }else{
                $option.removeClass('show');
            }
        }
        
    },
    checkType: function(value){
        if(value == 'digital'){
            $('#download_url-form-group').removeClass('d-none');
        }else{
            $('#download_url-form-group').addClass('d-none');
        }
    }
};



$(function(){
    if(crazy_form_data){
        if(crazy_form_data.attributes){
            let attributes = crazy_form_data.attributes;
            Product.form.getAttrInputUrl = attributes.input_url;
            Product.form.jsTagSrc = attributes.tag_srx;
            
        }
    }
    if($('.crazy-form').length){
        if($('input#on_sale').length){
            Product.form.checkOnSaleStatus($('input#on_sale').is(':checked'));
        }
        var variantAttributes = $('.product-variant-input .variant-input-checkbox');
        if(variantAttributes.length){
            variantAttributes.each(function(i, el){
                Product.form.onVariantChange($(el).is(':checked'), el);
            });
        }
    }

    
})