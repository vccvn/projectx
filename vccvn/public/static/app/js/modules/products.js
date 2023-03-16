
// giỏ hàng
App.extend({
    products: {
        decimal: 0,
        urls: {},
        templates: {
            item: "<p>{$name} - {{$price}}</p>"
        },
        init_list: ["urls", "templates", "decimal"],
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
            })
                .then(function (res) {
                    if (res.status) {
                        var d = res.data;
                        $(prefixClass + 'product-detail-info-' + d.product.id).find(prefixClass + "product-price").html(App.cart.currency(d.price));
                    }
                });
        },

        checkPriceOfForm: function (form) {
            var data = {
                product_id: $(form).find(prefixClass + "product-order-id").val(),
                attrs: [],
                quantity: $(form).find(prefixClass + "product-order-quantity").val() || 1
            };
            var inputs = $(form).find(prefixClass + "product-variants").find('select, input[type="radio"]:checked, input[type="rcheckbox"]:checked');
            for (let i = 0; i < inputs.length; i++) {
                const inp = inputs[i];
                data.attrs.push($(inp).val());
            }
            this.checkPrice(data);

        },
        getData: function (id, callback) {
            var ajax = App.ajax(this.urls.get_data, {
                method: "GET",
                data: { id: id },
                dataType: "json"
            });
            if (App.isCallable(callback)) {
                ajax.then(callback);
            }
            return ajax;
        },
        currency: function (total) {
            var c = App.config.currency;
            return App.number.format(total, c.decimal, c.decimal_poiter, c.thousands_sep, c.currency_type, c.currency_position)
        },
        review: function (form) {
            var serialized = $(form).serializeArray();
            var data = {};
            var $form = $(form);
            serialized.map(function (inp) {
                if (inp.name == '_token') return null;
                if (typeof data[inp.name] != "undefined") {

                    if (App.getType(data[inp.name]) == 'array') {
                        data[inp.name].push(inp.value);
                    } else {
                        data[inp.name] = [data[inp.name], inp.value];
                    }
                } else {
                    data[inp.name] = inp.value;
                }
            });
            if (!data.rating || data.rating == "0" || !data.name || !data.email) {
                App.popup.warning("Vui lòng xếp hạn sản phẩm, điều đầy dủ họ tên và email!");
            } else {
                App.ajax(this.urls.review, {
                    method: "post",
                    data: data,
                    dataType: "JSON"
                }).then(function (res) {
                    if (res.status) {
                        App.popup.alert(res.message);
                        $form.find("input,textarea").map(function (inp) {
                            if (["comment", "name", "email"].indexOf(inp.name) >= 0) {
                                $(inp).val("");
                            }
                        })
                    } else {
                        var errMessage = "";
                        if(res.errors){
                            for (const key in res.errors) {
                                if (res.errors.hasOwnProperty(key)) {
                                    const error = res.errors[key];
                                    errMessage = error;
                                    break;
                                }
                            }
                        }
                        App.popup.error(errMessage?errMessage:"Kiểm tra lại thông tin");
                    }
                }).catch(function (e) {
                    App.popup.error("Lỗi không xác định");
                });
            }
        }
    },
    orderFormSelector: null
    // end cart
});


if (typeof window.productAppInit == "function" || typeof window.customProductAppInit == "function") {
    if (typeof window.productAppInit == "function") {
        window.productAppInit();
    }
    if (typeof window.customProductAppInit == "function") {
        window.customProductAppInit();
    }


    var detailClass = prefixClass + "product-detail";


    var frmSelector = detailClass + " " + prefixClass + "product-order-form";
    App.products.orderFormSelector = frmSelector;
    $(document).on("change", frmSelector, function (e) {
        App.products.checkPriceOfForm(this);
    });

    var productOrderForms = $(frmSelector);
    if (productOrderForms.length) {
        for (let i = 0; i < productOrderForms.length; i++) {
            const form = productOrderForms[i];
            App.products.checkPriceOfForm(form);
        }
    }

    $(prefixClass + "product-review-form").submit(function (e) {
        e.preventDefault();
        App.products.review(this);
        return false;
    });

}

