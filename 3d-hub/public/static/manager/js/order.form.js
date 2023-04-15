function OrderItem(selector){
    var $el = $(selector);
    this.$el = $el;
    this.name = $el.data('name');
    this.maxIndex = parseInt($el.data('max-index'));
    this.nextIndex = this.maxIndex;
    this.addProductUrl = $el.data('add-url');
    this.search = $el.find('#'+$el.data('name')+'-items');
    this.$itemBlock = $el.find('.product-items');
    var self = this;
    this.init = function(){
        if($el.find('.next-index').length){
            let nextIndex = $el.find('.next-index').data('next-index') || 0;
            let nI = parseInt(nextIndex);
            if(!isNaN(nI)){
                this.nextIndex = nI;
            }
        }
        $el.on('click', '.btn-add-product-item',function(){
            let product_id = self.search.val();
            if(!product_id || product_id == "0") return false;
            let data = {
                product_id: product_id,
                index: self.nextIndex,
                name: self.name
            }
            ajaxRequest(self.addProductUrl, "GET", data, function(res){
                if(res.status){
                    self.nextIndex++;
                    self.$itemBlock.append(res.data);
                }
            });
        });
        $el.on('click', '.btn-delete-order-product-item', function(){
            let index = $(this).data('index');
            $el.find('#order-item-'+index).hide(300, function(){
                $(this).remove();
            });
        });
    };
}


if(typeof Order == "undefined"){
    var Order = {};
}

Order.form = {
    list:{},
    urls: {},
    districtID:0,
    shippingRegionID: 0,
    shippingDistrictID:0,
    
    add: function (selector){
        var $el = $(selector);
        if($el.length){
            let $select = new OrderItem($el[0]);
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
    },
    shippingSelectors: "",
    changShippingAddress: function(value, el){
        return value ? this.showShipping() : this.hideShipping();
    },
    hideShipping: function(){
        $(this.shippingSelectors).addClass('d-none');
    },
    showShipping: function(){
        $(this.shippingSelectors).removeClass('d-none');
    },
    
    changeRegionID: function(value, text, el){
        if(value != this.regionID){
            this.regionID = value;
            App.htmlSelect.deactive('billing_district_id');
            App.htmlSelect.deactive('billing_ward_id');
            App.htmlSelect.changeOptions('billing_district_id', {0: "Chọn một"});
            App.htmlSelect.changeOptions('billing_ward_id', {0: "Chọn một"});
            if(value && value != "0"){
                ajaxRequest(this.urls.district_options, "get", {region_id: value}, function(res){
                    if(res.status){
                        App.htmlSelect.changeOptions('billing_district_id', res.data);
                    }
                });
            }
        }
    },

    changeDistrictID: function(value, text, el){
        if(value != this.districtID){
            this.districtID = value;
            App.htmlSelect.deactive('billing_ward_id');
            App.htmlSelect.changeOptions('billing_ward_id', {0: "Chọn một"});
            if(value && value != "0"){
                ajaxRequest(this.urls.ward_options, "get", {district_id: value}, function(res){
                    if(res.status){
                        App.htmlSelect.changeOptions('billing_ward_id', res.data);
                    }
                });
            }
        }
    },

    
    changeShippingRegionID: function(value, text, el){
        if(value != this.shippingRegionID){
            this.shippingRegionID = value;
            App.htmlSelect.deactive('shipping_district_id');
            App.htmlSelect.deactive('shipping_ward_id');
            App.htmlSelect.changeOptions('shipping_district_id', {0: "Chọn một"});
            App.htmlSelect.changeOptions('shipping_ward_id', {0: "Chọn một"});
            if(value && value != "0"){
                ajaxRequest(this.urls.district_options, "get", {region_id: value}, function(res){
                    if(res.status){
                        App.htmlSelect.changeOptions('shipping_district_id', res.data);
                    }
                });
            }
        }
    },

    changeShippingDistrictID: function(value, text, el){
        if(value != this.shippingDistrictID){
            this.shippingDistrictID = value;
            App.htmlSelect.deactive('shipping_ward_id');
            App.htmlSelect.changeOptions('shipping_ward_id', {0: "Chọn một"});
            if(value && value != "0"){
                ajaxRequest(this.urls.ward_options, "get", {district_id: value}, function(res){
                    if(res.status){
                        App.htmlSelect.changeOptions('shipping_ward_id', res.data);
                    }
                });
            }
        }
    }
};

Order.form.shippingSelectors = "#shipping_" + 
("name email phone_number region_id district_id ward_id address" .split(" ").join("-form-group, #shipping_")) + 
"-form-group";



$(function(){
    var $cs = $('.crazy-products');
    if($cs.length){
        $cs.each(function(i, el){
            Order.form.add(el);
        });
    }

    if(typeof order_data == 'object'){
        Order.form.urls = order_data.urls || {};
    }
    Order.form.changShippingAddress($("#ship_to_different_address").is(":checked"));
});
