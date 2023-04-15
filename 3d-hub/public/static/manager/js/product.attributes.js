if(typeof Product == "undefined"){
    Product = {};
}

Product.attributes = {
    categories: {},
    init_list: ["categories"],
    isOrderOption: false,
    hasPrice:false,
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
    },
    // code here
    checkValueType: function(value){
        var self = this;
        if(value == 'text'){
            this.addHiddenClassBy('value-type');
            
        }else{
            this.removeHiddenClassBy('value-type');
            if(value == "varchar"){
                setTimeout(function(){
                    self.addGroupsClass(['value_unit'], 'hide-by-value-type');
                }, 100);
            }
        }
    },
    // code here
    checkInoutType: function(value){
        if(value != 'checklist'){
            this.addHiddenClassBy('input-type');
            
        }else{
            this.removeHiddenClassBy('input-type');
        }
    },
    checkRequiredStatus: function(stt){
        if(stt){
            this.removeHiddenClassBy('required-status');
        }else{
            this.addHiddenClassBy('required-status');
        }
    },
    checkUniqueStatus: function(stt){
        if(stt){
            this.addHiddenClassBy('unique-status');
        }else{
            this.removeHiddenClassBy('unique-status');
        }
    },
    checkIsOrderOption: function(stt){
        this.isOrderOption = stt;
        if(stt){
            this.removeHiddenClassBy('is-order-option-status');
        }else{
            this.addHiddenClassBy('is-order-option-status');
        }
        this.parseInputTypeOption();
    },
    checkIsVariant: function(stt){
        this.hasPrice = stt;
        if(stt){
            this.removeHiddenClassBy('is-variant-status');
        }else{
            this.addHiddenClassBy('is-variant-status');
        }
        this.parseInputTypeOption();
    },

    parseInputTypeOption: function(){
        let hasPrice = this.hasPrice;
        let isOrderOption = this.isOrderOption;
        let types = '';
        if(isOrderOption){
            if(hasPrice) types = 'checkbox';
            else types = "multiselect,checklist,taga"
        }else{
            types = '';
        }
        this.changeInputType(types);

    },
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
    changeInputType: function(fields){
        var inputType = App.htmlSelect.getTag('input_type');
        if(inputType){
            inputType.staticSearch(fields);
            setTimeout(function(){inputType.resetDefault();},10);
        }
    },
    getCategoryMap:function(id){
        if(id == 0) return ['Tất cả'];
        var list = [];
        var data = {};
        var self = this;
        let max = -1;
        var searchCategory = function(id, categories, level){
            if(!categories) categories = self.categories;
            var type = App.getType(categories);
            let status = false;
            if(type == 'object' || type == 'array'){
                for (const cate_id in categories) {
                    if (categories.hasOwnProperty(cate_id)) {
                        const cate = categories[cate_id];
                        let valType = App.getType(cate);
                        if(cate_id == id){
                            status = true;
                            data[level] = (valType == "object")? cate.label : cate;
                            if(level>max) max = level;
                        }else if(valType == "object"){
                            let stt2 = searchCategory(id, cate.data, level+1);
                            if(stt2){
                                data[level] = cate.label;
                                status = true;
                                if(level>max) max = level;
                            }
                        }
                        
                    }
                }
            }
            return status;
        };
        if(searchCategory(id, self.categories, 0)){
            for (let i = 0; i <= max; i++) {
                list[i] = data[i];
            }
        }
        return list.length?list:['Tất cả'];
    }


};

$(function(){
    if($('.crazy-form').length){
        if($('input#value_type').length){
            Product.attributes.checkValueType($('input#value_type').val());
        }
        // if($('input#input_type').length){
        //     Product.attributes.checkInputType($('input#input_type').val());
        // }
        
        if($('input#is_order_option').length){
            let stt = $('input#is_order_option').is(':checked');
            Product.attributes.checkIsOrderOption(stt);
        }
    
        if($('input#is_variant').length){
            Product.attributes.checkIsVariant($('input#is_variant').is(':checked'));
        }
    
        if($('input#is_required').length){
            Product.attributes.checkRequiredStatus($('input#is_required').is(':checked'));
        }
    
        if($('input#is_unique').length){
            Product.attributes.checkUniqueStatus($('input#is_unique').is(':checked'));
        }

        setTimeout(function(){
            Product.attributes.parseInputTypeOption();
        }, 200);
        
    }

    if (typeof window.productAttributeInit == 'function') {
        window.productAttributeInit();
        window.productAttributeInit = null;
        let attributes = $('.crazy-list .attribute-category');
        if(attributes.length){
            attributes.each(function(i, attr){
                let cateList = Product.attributes.getCategoryMap($(attr).data('id'));
                if(cateList.length){
                    $(attr).html(cateList.join(' <span class="fa fa-chevron-right"></span> '));
                }
            })
        }
    }
})