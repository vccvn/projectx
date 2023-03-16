if (typeof App.payments != "object") {
    App.payments = {};
}

App.payments.methods = {
    urls: {},
    id: 0,
    template: "",
    configMethods: {},
    init_list: ["urls", "configMethods"],


    init: function (args) {
        App.setDefault(this, args);

    },

    saveMethod: function (data) {
        App.api.post(this.urls.ajax_save, data)
            .then(function (rs) {
                if (rs.status) {
                    App.Swal.success(rs.message, null, function () {
                        top.location.reload();
                    });
                } else {
                    if (rs.errors) {
                        App.Swal.errorDetail(rs.message, rs.errors, null, function () {
                            App.modal.show("popup-modal");
                        });
                    } else {
                        App.Swal.warning(rs.message, null, function () {
                            App.modal.show("popup-modal");
                        });
                    }

                }
            })
            .catch(function (err) {
                App.Swal.error(err.message);
            })
    },
    updateMethod: function (data) {
        App.api.post(this.urls.ajax_save, data)
            .then(function (rs) {
                if (rs.status) {
                    App.Swal.success(rs.message);
                } else {
                    if (rs.errors) {
                        App.Swal.errorDetail(rs.message, rs.errors);
                    } else {
                        App.Swal.warning(rs.message);
                    }

                }
            })
            .catch(function (err) {
                App.Swal.error(err.message);
            })
    },
    changeStatus: function (value, el) {
        var data = {
            id: $(el).data('method-id'),
            status: value
        };
        App.api.post(this.urls.ajax_status, data)
            .then(function (rs) {
                if (!rs.status) {
                    App.Swal.warning(rs.message);
                    $(el).prop('checked', 'false');
                }
            })
            .catch(function (err) {
                App.Swal.error(err.message);
                $(el).prop('checked', 'false');
            })
    },
    updatePriority: function(){
        var self = this;
        setTimeout(function(){
            var data = [];
            var i = 0;
            var exists = {};
            var items = $("#m_sortable_portlets").find('.m-portlet.method-item');
            if(items.length){
                for (let index = 0; index < items.length; index++) {
                    const item = items[index];
                    var id = $(item).data('id');
                    if(typeof exists[id] == "undefined"){
                        data.push({
                            id: id,
                            priority: i
                        });
                        exists[id] = 1;
                        i++;
                    }

                }
            }
            App.api.post(self.urls.ajax_priority, {data:data})
            .then(function (rs) {
                if (!rs.status) {
                    App.Swal.warning(rs.message);
                }
            })
            .catch(function (err) {
                App.Swal.error(err.message);
            })

        }, 500);
        return true;
    },

    getInputsByMethod: function (method) {
        var self = this;
        var data = { method: method };
        App.api.post(this.urls.method_inputs, data)
            .then(function (rs) {
                if (rs.status) {
                    var options = rs.data;
                    options.btnDone = "Thêm mới";
                    options.size = 'md';
                    options.done = function (data) {
                        var d = {
                            name: data.name,
                            description: data.description,
                            method: method,
                            config: {}
                        };
                        for (const key in data) {
                            if (data.hasOwnProperty(key)) {
                                const val = data[key];
                                if (key != 'name' && key != 'description' && key != 'method') {
                                    d.config[key] = val;
                                }
                            }
                        }
                        self.saveMethod(d);

                    };
                    App.modal.popup(options);
                }
                else {
                    App.Swal.warning(rs.message);
                }
            })
            .catch(function (err) {
                App.Swal.error(err);
                console.log(err);
            })
    },

    showEditMethodForm: function (id) {
        var self = this;
        App.api.get(this.urls.ajax_detail, { id: id })
            .then(function (rs) {
                if (rs.status) {
                    var detail = rs.data;
                    var method = detail.method;
                    if (typeof self.configMethods[method] != "undefined") {
                        var mtData = self.configMethods[method];
                        var inputs = {
                            id: {
                                type: "hidden",
                                value: id
                            }
                        };
                        for (const key in detail) {
                            if (detail.hasOwnProperty(key)) {
                                const val = detail[key];
                                if (typeof mtData.inputs[key] != "undefined") {
                                    inputs[key] = mtData.inputs[key];
                                    inputs[key].value = val;
                                }
                                else if (key == "config" && App.isObject(val)) {
                                    for (const k in val) {
                                        if (val.hasOwnProperty(k)) {
                                            const v = val[k];
                                            if (typeof mtData.inputs[k] != "undefined") {
                                                inputs[k] = mtData.inputs[k];
                                                inputs[k].value = v;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        App.modal.popup({
                            title: "Cập nhật " + detail.name,
                            btnDone: "Cập nhật",
                            inputs: inputs,
                            size: 'md',
                            done: function(data){
                                data.method = method;
                                self.saveMethod(data);
                            }
                        })
                    }
                } else {
                    App.Swal.warning(rs.message);

                }
            });
    },


    getMethodDetail: function (id) {
        var self = this;
        App.api.get(this.urls.ajax_detail, { id: id })
            .then(function (rs) {
                if (rs.status) {
                    self.showDetail(rs.data);
                } else {
                    App.Swal.warning(rs.message);

                }
            });
    },
    showDetail: function (detail) {
        var template = '<tr><td class="w-200" style="width:150px">{$label}</td><td>{$value}</td></tr>';
        var table = '' +
            '<div class="table-responsive">' +
            '<table class="table table-bordered">' +
            '<thead>' +
            '<tr>' +
            '<th class="w-200" style="width:150px">Nhãn</th>' +
            '<th>Giá trị</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '{$tr}' +
            '</tbody>' +
            '</table>' +
            '</div>';
        var tr = '';
        var method = detail.method;
        if (typeof this.configMethods[method] != "undefined") {
            var mtData = this.configMethods[method];

            for (const key in detail) {
                if (detail.hasOwnProperty(key)) {
                    const val = detail[key];
                    if (typeof mtData.inputs[key] != "undefined") {
                        tr += App.str.eval(template, {
                            label: mtData.inputs[key].label,
                            value: val
                        });
                    }
                    else if (key == "config" && App.isObject(val)) {
                        for (const k in val) {
                            if (val.hasOwnProperty(k)) {
                                const v = val[k];
                                if (typeof mtData.inputs[k] != "undefined") {
                                    tr += App.str.eval(template, {
                                        label: mtData.inputs[k].label,
                                        value: v
                                    });
                                }
                            }
                        }
                    }
                }
            }
            App.modal.custom({
                title: mtData.title,
                content: App.str.eval(table, { tr: tr }),
                size: "md"
            });
        }
    }
}



$(function () {
    if (typeof window.paymentMethodInit == 'function') {
        window.paymentMethodInit();
        window.paymentMethodInit = null;
        $(document).on('click', '.btn-create-payment', function () {
            App.payments.methods.getInputsByMethod($(this).data('method'));
        });

        $(document).on('click', '.btn-view-detail', function () {
            App.payments.methods.getMethodDetail($(this).data('id'));
        });
        $(document).on('click', '.btn-edit-method', function () {
            App.payments.methods.showEditMethodForm($(this).data('id'));
        });

        $(document).on('submit', '.update-payment-method-form', function (e) {
            try {
                e.preventDefault();
                var formData = $(this).serializeArray();
                var data = {};
                if(formData.length){
                    formData.map(function (e) {
                        let name = e.name;
                        let value = e.value;
                        data[name] = value;
                    });
                }
                var d = {
                    id: data.id,
                    name: data.name,
                    description: data.description,
                    method: data.method,
                    guide: data.guide,
                    config: {}
                };
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const val = data[key];
                        if (key != 'name' && key != 'description' && key != 'guide' && key != 'method') {
                            d.config[key] = val;
                        }
                    }
                }
                App.payments.methods.updateMethod(d);
            } catch (error) {
                console.log(error);
            }

            return false;
        });


    }
})


var PortletDraggable = {
    init: function () {
        if(!$("#m_sortable_portlets").length){
            console.log("khong ");
            return false;
        }
        $("#m_sortable_portlets").sortable({
            connectWith: ".m-portlet__head",
            items: ".m-portlet",
            opacity: .8,
            handle: ".m-portlet__head",
            coneHelperSize: !0,
            placeholder: "m-portlet--sortable-placeholder",
            forcePlaceholderSize: !0,
            tolerance: "pointer",
            helper: "clone",
            tolerance: "pointer",
            forcePlaceholderSize: !0,
            helper: "clone",
            cancel: ".m-portlet--sortable-empty",
            revert: 250,
            update: function (e, t) { t.item.prev().hasClass("m-portlet--sortable-empty") && t.item.prev().before(t.item) },
            stop: function( event, ui ) {
                App.payments.methods.updatePriority();
            }
        })
    }
};
jQuery(document).ready(function () { PortletDraggable.init() });
