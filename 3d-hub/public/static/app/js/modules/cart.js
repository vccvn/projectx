
// giỏ hàng
App.extend({
    cart: {
        decimal: 2,
        urls: {},
        currency_position: "right",
        templates: {
            item: "<p>{$name} - {$price}</p>"
        },
        currency_unit: "Đ",
        init_list: ["urls", "templates", "decimal", "currency_unit", "currency_position"],
        regionID: 0,
        districtID:0,
        shippingRegionID: 0,
        shippingDistrictID:0,
        // kiểm tra giá sdan3 phẩm kèm thuộc tính
        /**
         * 
         * @param {*} data 
         */
        checkPrice: function (data) {
            App.ajax(this.urls.check_price, {
                method: "post",
                data: data,
                dataType: "json"
            }).then(function (res) {
                if (res.status) {
                    var d = res.data;
                    $(prefixClass + 'product-detail-info-' + d.product.id).find(prefixClass + "product-price").html(App.cart.currency(d.price));
                }
            })
        },

        updateCartData: function (data) {
            if (!App.isObject(data)) data = {};
            var cart_quantity = 0,
                sub_total = data.sub_total || 0,
                taz = data.taz || 0,
                total_money = data.total_money || 0,
                shipping_fee = data.shipping_fee || 0,
                details = data.details && data.details.length ? data.details : [];
            $(prefixClass + "cart-sub-total-ammount").html(this.currency(sub_total));
            $(prefixClass + "cart-total-ammount, " + prefixClass + "cart-total-money-ammount").html(this.currency(total_money));
            $(prefixClass + "cart-tax-ammount, " + prefixClass + "cart-tax-total-ammount").html(this.currency(taz));
            $(prefixClass + "cart-shipping-fee, " + prefixClass + "cart-shipping-fee-ammount").html(this.currency(taz));
            var itemTemplate = this.templates.item;
            var attrTemplate = this.templates.attribute;
            var detailLength = details.length;
            var cartItems = '';
            if (detailLength) {
                for (let i = 0; i < detailLength; i++) {
                    var item = details[i];
                    if (!item.name) item.name = item.product_name;
                    item.price = this.currency(item.final_price);
                    cart_quantity += item.quantity;
                    $(prefixClass + "item-total-price-" + item.id + ", #cart-item-" + item.id)
                        .find(prefixClass + "item-total-price")
                        .html(this.currency(item.quantity * item.list_price));
                    var attributes = "";

                    if (item.attributes && App.isArray(item.attributes)) {
                        var attrLength = item.attributes.length;
                        if (attrLength) {
                            for (let j = 0; j < item.attributes.length; j++) {
                                var attr = item.attributes[j];
                                attr.value = attr.text_value || attr[attr.value_type + "_value"] || "";
                                attributes += App.str.eval(attrTemplate, attr);
                            }
                        }
                    }
                    item.attributes = attributes;
                    cartItems += App.str.eval(itemTemplate, item);
                }
            } else {
                cartItems = '<p>Không có sản phẩm nào</p>';
            }
            $(prefixClass + "cart-quantity").html(cart_quantity);
            $(prefixClass + "cart-items").html(cartItems);
            // code here

        },

        checkCartData: function () {
            App.ajax(this.urls.check_cart_data, {
                method: "POST",
                data: {
                    key: App.str.rand()
                },
                cookie: true,
                dataType: "JSON"
            }).then(function (result) {
                    if (result.status) {
                        App.cart.updateCartData(result.data);
                    }
                })
        },

        addCartItem: function (data) {
            if (!data || !data.product_id) return App.popup.alert("Hành động không hợp lệ!");
            App.log(data);
            App.ajax(this.urls.add_cart_item, {
                method: "POST",
                data: data,
                dataType: "json"
            }).then(function (result) {
                if (result.status) {
                    App.cart.updateCartData(result.data);
                    App.popup.confirm("Sản phẩm đã được thêm vào giỏ hàng thành công!\nBạn có muốn đến trang thanh toán không?", function (p) {
                        top.location.href = App.cart.urls.view_cart;
                    })
                } else {
                    App.popup.alert("Lổi không xác định");
                }
            })
        },

        removeCartItem: function (id) {
            if (!id) return App.popup.alert("ID giỏ hàng không hợp lệ");
            App.ajax(this.urls.remove_cart_item, {
                method: "POST",
                data: { id: id },
                dataType: "json"
            }).then(function (result) {
                if (result.status) {
                    App.cart.updateCartData(result.data);
                    $("#cart-item-" + id + ", " + prefixClass + "cart-item-" + id).hide(300, function (e) {
                        $(this).remove();
                    })
                } else {
                    App.popup.alert("Lỗi không xác định");
                }
            });
        },



        checkPriceOfForm: function (form) {
            var data = {
                product_id: $(form).find(prefixClass + "product-order-id").val(),
                attrs: [],
                quantity: $(form).find(prefixClass + "product-order-quantity").val() || 1
            };
            var inputs = $(form).find(prefixClass + "product-varients").find('select, input[type="radio"]:checked, input[type="rcheckbox"]:checked');
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                data.attrs.push($(inp).val());
            }
            this.checkPrice(data);

        },
        addToCartByForm: function (form) {
            var data = {
                product_id: 0,
                attrs: [],
                quantity: 1
            };

            var inputs = $(form).serializeArray();
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                if (inp.name == "_token") continue;
                else if (inp.name == "product_id" || inp.name == "quantity") data[inp.name] = inp.value;
                else data.attrs.push(inp.value);
            }
            this.addCartItem(data);
        },

        updateCartQuantity: function (data) {
            var self = this;
            App.ajax(this.urls.update_cart_quantity, {
                method: "post",
                data: data,
                dataType: "JSON"
            }).then(function (result) {
                if (result.status) {
                    self.updateCartData(result.data);
                } else {
                    App.popup.alert(result.message);
                }
            }).catch(function (error) {
                App.log(error);
            });
        },
        updateAllCartItemQuantity: function () {
            //var $form = $(prefixClass + "cart-form");
            var data = {};
            var inputs = $(prefixClass + "item-quantity");
            if (inputs.length) {
                for (let i = 0; i < inputs.length; i++) {
                    const inp = inputs[i];
                    var $inp = $(inp);
                    var id = $inp.data('item-id');
                    var qty = parseInt($inp.val());
                    if (!isNaN(qty) && qty > 0) {
                        data[$inp.attr('name')] = qty;
                    }

                }
                if (!App.isEmpty(data)) {
                    this.updateCartQuantity(data);
                }
            }
        },
        currency: function (total) {
            var rt = total;
            var decimal = App.isNumber(this.decimal) ? this.decimal : 0;
            if (decimal == 1) {
                rt = parseInt(Math.round(rt * 10)) / 10;
            } else if (decimal == 0) {
                rt = parseInt(Math.round(rt * 100) / 100);
            }
            var c = App.number.currency(rt);
            if (this.currency_position == "right") {
                c += this.currency_unit;
            } else {
                c = this.currency_unit + c;
            }
            return c;
        },

        changeRegionID: function(value, text, el){
            if(value != this.regionID){
                this.regionID = value;
                App.dom.select.deactive('billing_district_id');
                App.dom.select.deactive('billing_ward_id');
                App.dom.select.changeOptions('billing_district_id', {0: "Chọn một"});
                App.dom.select.changeOptions('billing_ward_id', {0: "Chọn một"});
                if(value && value != "0"){
                    App.ajax(this.urls.district_options, {
                        method: "get",
                        data: {region_id: value},
                        dataType: "JSON"
                    }).then(function(res){
                        if(res.status){
                            App.dom.select.changeOptions('billing_district_id', res.data);
                        }
                    });
                }
            }
        },

        changeDistrictID: function(value, text, el){
            if(value != this.districtID){
                this.districtID = value;
                App.dom.select.deactive('billing_ward_id');
                App.dom.select.changeOptions('billing_ward_id', {0: "Chọn một"});
                if(value && value != "0"){
                    App.ajax(this.urls.ward_options, {
                        method: "get",
                        data: {district_id: value},
                        dataType: "JSON"
                    }).then(function(res){
                        if(res.status){
                            App.dom.select.changeOptions('billing_ward_id', res.data);
                        }
                    });
                }
            }
        },

        
        changeShippingRegionID: function(value, text, el){
            if(value != this.shippingRegionID){
                this.shippingRegionID = value;
                App.dom.select.deactive('shipping_district_id');
                App.dom.select.deactive('shipping_ward_id');
                App.dom.select.changeOptions('shipping_district_id', {0: "Chọn một"});
                App.dom.select.changeOptions('shipping_ward_id', {0: "Chọn một"});
                if(value && value != "0"){
                    App.ajax(this.urls.district_options, {
                        method: "get",
                        data: {region_id: value},
                        dataType: "JSON"
                    }).then(function(res){
                        if(res.status){
                            App.dom.select.changeOptions('shipping_district_id', res.data);
                        }
                    });
                }
            }
        },

        changeShippingDistrictID: function(value, text, el){
            if(value != this.shippingDistrictID){
                this.shippingDistrictID = value;
                App.dom.select.deactive('shipping_ward_id');
                App.dom.select.changeOptions('shipping_ward_id', {0: "Chọn một"});
                if(value && value != "0"){
                    App.ajax(this.urls.ward_options, {
                        method: "get",
                        data: {district_id: value},
                        dataType: "JSON"
                    }).then(function(res){
                        if(res.status){
                            App.dom.select.changeOptions('shipping_ward_id', res.data);
                        }
                    });
                }
            }
        }



    }
    // end cart
});


if (typeof window.orderCartInit == "function" || typeof window.customCartInit == "function") {
    if (typeof window.orderCartInit == "function") {
        window.orderCartInit();
    }
    if (typeof window.customCartInit == "function") {
        window.customCartInit();
    }


    App.cart.checkCartData();

    var detailClass = prefixClass + "product-detail";

    var frmSelector = detailClass + " " + prefixClass + "product-order-form";
    $(document).on("submit", frmSelector, function (e) {
        e.preventDefault();
        App.cart.addToCartByForm(this);
        return false;
    });
    // var productOrderForms = $(frmSelector);

    // if (productOrderForms.length) {
    //     // for (let i = 0; i < productOrderForms.length; i++) {
    //     //     const form = productOrderForms[i];
    //     //     App.cart.checkPriceOfForm(form);
    //     // }
    //     // productOrderForms.change(function (e) {
    //     //     App.cart.checkPriceOfForm(this);
    //     // });

    //     productOrderForms.(function (e) {
    //         e.preventDefault();
    //         App.cart.addToCartByForm(this);
    //         return false;
    //     });

    // }

    $(document).on('click', prefixClass + "remove-cart-item", function (e) {
        e.preventDefault();
        try {
            App.cart.removeCartItem($(this).data('item-id'));
        } catch (error) {
            App.log(error)
        }
        return false;
    });


    $(document).on('click', prefixClass + "add-to-cart", function (e) {
        e.preventDefault();
        try {
            App.cart.addCartItem({
                product_id: $(this).data('product-id')
            });
        } catch (error) {
            App.log(error)
        }
        return false;
    });


    $(document).on('click', prefixClass + "btn-update-cart", function (e) {
        e.preventDefault();
        try {
            App.cart.updateAllCartItemQuantity();
        } catch (error) {
            App.log(error)
        }
        return false;
    });
    $(prefixClass + "cart-form").submit(function (e) {
        e.preventDefault();
        try {
            App.cart.updateAllCartItemQuantity();
        } catch (error) {
            App.log(error)
        }
        return false;
    });


    var createAccountCheckbox = $(prefixClass + "create-account-checkbox");
    if(createAccountCheckbox.length){
        var createAccountGroup = $(prefixClass + "create-account-group");
        var toggleCreateAccountGroup = function(){
            if(createAccountCheckbox.is(':checked')){
                createAccountGroup.show(300);
            }else{
                createAccountGroup.hide(300);
            }
        };
        createAccountCheckbox.on('change', function(e){
            toggleCreateAccountGroup();
        });
        toggleCreateAccountGroup();
    }


    var shiptoDifferentAddressCheckbox = $(prefixClass + "ship-to-different-address");
    if(shiptoDifferentAddressCheckbox.length){
        var shiptoDifferentAddressGroup = $(prefixClass + "shipping-address-group");
        var toggleshiptoDifferentAddressGroup = function(){
            if(shiptoDifferentAddressCheckbox.is(':checked')){
                shiptoDifferentAddressGroup.show(300);
            }else{
                shiptoDifferentAddressGroup.hide(300);
            }
        };
        shiptoDifferentAddressCheckbox.on('change', function(e){
            toggleshiptoDifferentAddressGroup();
        });
        toggleshiptoDifferentAddressGroup();
    }

}

