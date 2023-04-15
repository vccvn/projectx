function SlugInput(selector){
    this.$el = $(selector);
    this.$check = this.$el.find('input[type="checkbox"]');
    this.$input = this.$el.find('#'+this.$el.data('id'));
    this.$ajaxInput = $(this.$el.data('ajax-param-selectors'));
    this.$source = $('#'+this.$el.data('source-id'));
    this.getSlugInputName = this.$el.data('ajax-get-name');
    this.checkSlugInputName = this.$el.data('ajax-check-name');
    this.$message = null;
    this.isCustom = false;

    this.sourceValue = '';
    this.inputValue = '';
    this.getSlugValue = '';
    this.checkingValue = '';

    this.message = '';

    this.urls = {
        get: this.$el.data('get-slug-url'),
        check: this.$el.data('check-slug-url')
    };


    var self = this;
    
    this.createMessageTag = function(){
        var id = 'input-'+this.$el.data('id')+'-message-alert';
        if($('#'+id).length) return $('#'+id);
        this.$el.after('<div class=" input-message-alert" id="'+id+'"></div>');
        return $('#'+id);
    }

    this.init = function (){
        this.$message = this.createMessageTag();
        this.$check.on('change click', function(){
            self.check();
        });
        if(this.$source.length){
            this.$source.on("change mouseup keyup", function(){
                self.checkSource();
            });
        }
        this.$input.on('change mouseup keyup', function(){
            if(!self.isCustom) return false;
            self.checkSlug();
        })

        this.check();
    };
    this.enable = function(){
        this.$input.prop('readonly', false);
    };
    this.disable = function(){
        this.$input.prop('readonly', true);
    };
    this.check = function(){
        if(this.$check.is(':checked')){
            this.isCustom = true;
            this.enable();
        }else{
            this.isCustom = false;
            this.disable();
            this.getSlugValue = '';
            this.checkSource();
            if(this.message.length){
                this.$message.html("");
            }
        }
    };
    this.checkSource = function (){
        if(this.isCustom) return false;
        if(self.$source.val() != self.sourceValue){
            self.sourceValue = self.$source.val();
            setTimeout(function(){
                self.checkSource();
            }, 200);
            return false;
        }
        if(self.$source.val() != self.getSlugValue){
            self.getSlugValue = self.$source.val();
            this.getSlug(self.getSlugValue);
        }
        
    };
    this.getSlug = function(str){
        if(this.isCustom) return false;
        var data = this.getFormData();
        data[this.getSlugInputName] = str;
        App.api.get(this.urls.get, data)
            .then(rs => {
                if (rs.status) {
                    if (!self.isCustom) {
                        if (str != self.getSlugValue) return self.getSlug(self.getSlugValue);
                        self.$input.val(rs.data);
                    }
                } else {
                    cl(rs.message);
                }
            });
        
    };

    this.checkSlug = function (){
        if(!this.isCustom) return false;
        if(self.$input.val() != self.checkingValue){
            self.checkingValue = self.$input.val();
            setTimeout(function(){
                self.checkSlug();
            }, 200);
            return false;
        }
        if(self.$input.val() != self.inputValue){
            self.inputValue = self.$input.val();
            this.checkSlugValue(self.inputValue);
        }
    };

    this.checkSlugValue = function(str){
        if(!this.isCustom) return false;
        var data = this.getFormData();
        data[this.checkSlugInputName] = str;
        ajaxRequest(this.urls.check, "POST", data, function(rs){
            self.showMessage(rs.message,rs.status);
            self.message = rs.message;
            if(self.isCustom){
                if(str!=self.inputValue) return self.checkSlugValue(self.inputValue);
            }
        });
        
    };


    this.getFormData = function(){
        // 
        var data = {};
        if(this.$ajaxInput.length){
            this.$ajaxInput.each(function(i, e){
                data[$(e).attr('name')] = $(e).val();
            });
        }
        return data;
    };
    

    this.showMessage = function(message, status){
        this.$message.removeClass('form-control-feedback')
                    .removeClass('text-danger')
                    .removeClass('text-success')
                    .addClass(status?'text-success':'text-danger')
                    .html(message);

    };

    
}



App.slugInput = {
    list:{},
    add: function (selector){
        var $el = $(selector);
        if($el.length){
            let $select = new SlugInput($el[0]);
            $select.init();
            this.list[$el.data('id')] = $select;
        }
    },
    getTag:function(id){
        if(id){
            if(typeof this.list[id] != "undefined"){
                return this.list[id];
            }
        }
        return null;
    },
    getData:function(id){
        var tag = this.getTag(id);
        if(tag) return tag.getData();
        return [];
    }
};



$(function(){
    var $cs = $('.crazy-slug');
    if($cs.length){
        $cs.each(function(i, el){
            App.slugInput.add(el);
        });
    }
});