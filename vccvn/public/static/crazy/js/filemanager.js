/**
 * doi tuong quan li item
 * @type {Object}
 */
App.FileManager = {
    path: "",
    urls: {},
    init_list: ["urls", "path", "module", "title"],

    init: function (args) {
        if (!args || typeof args == 'undefined') return;
        for (var key of this.init_list) {
            if (typeof args[key] != 'undefined') {
                var d = args[key];
                var t = App.getType(d);

                var t2 = (typeof (this[key]) != 'undefined') ? App.getType(this[key]) : "string";
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

    getCheckedValues: function () {
        var check_selector = '.crazy-list input[type="checkbox"].crazy-check-';
        var ids = [];
        var list = $(check_selector + 'item:checked');
        var ids = [];
        if (list.length) {
            for (var i = 0; i < list.length; i++) {
                ids[ids.length] = $(list[i]).val();
            }
        }
        return ids;

    },



    moveItems: function (items) {
        if (!items || !items.length) {
            return App.Swal.alert("Không có mục nào được chọn");
        }
        var self = this;
        App.modal.popup({
            title: "Di chuyển mục",
            inputs: {
                directory: {
                    type: "text",
                    label: "Đường dẫn",
                    value: self.path,
                    placeholder: "Ví dụ: /public/folder",
                    validate: function (val) {
                        if (App.str.replace(val, ['%', '?', '!', '\\', '#', ':', ';', "'", '|', '+', '=', '"', "^", '<', '>', ',', '*'], '') != val) return false;
                        return true;
                    }
                }
            },
            btnDone: "Di chuyển",
            done: function (data) {
                data.path = self.path;
                data.items = items;

                showLoading();
                ajaxRequest(self.urls.move, "POST", data, function (rs) {
                    hideLoading();
                    if (rs.status) {
                        var data = rs.data;
                        if (data.length) {
                            for (let i = 0; i < data.length; i++) {
                                const filename = data[i];
                                $('tr[data-name="' + filename + '"]').hide(300, function () {
                                    $(this).remove();
                                });
                            }
                        }
                    }
                    else if (rs.message) {
                        App.Swal.warning(rs.message);
                    }
                    else {
                        App.Swal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                }, function () {
                    hideLoading();
                });
            }
        });


    },

    rename: function (old_name) {
        var self = this;
        App.modal.popup({
            title: "Đổi tên",
            inputs: {
                new_name: {
                    type: "text",
                    label: "Nhập tên mới",
                    value: old_name,
                    placeholder: "Ví dụ: abc",
                    validate: function (val) {
                        if (App.str.replace(val, ['%', '?', '!', '\\', '#', ':', ';', "'", '|', '+', '=', '"', "^", '<', '>', ',', '*'], '') != val) return false;
                        return true;
                    }
                }
            },
            btnDone: "Đổi tên",
            done: function (data) {
                data.path = self.path;
                data.old_name = old_name;
                showLoading();
                ajaxRequest(self.urls.rename, "POST", data, function (rs) {
                    hideLoading();
                    if (rs.status) {
                        var data = rs.data;
                        App.Swal.success(rs.message, null, () => {
                            top.location.reload();
                        });
                    }
                    else if (rs.message) {
                        App.Swal.warning(rs.message, null, () => {
                            App.Swal.show('popup-modal');
                        });
                    }
                    else {
                        App.Swal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                }, function () {
                    hideLoading();
                });
            }
        });

    },


    makeDir: function () {
        var self = this;
        App.modal.popup({
            title: "Di chuyển mục",
            inputs: {
                name: {
                    type: "text",
                    label: "Tên thư mục",
                    // value: self.path,
                    placeholder: "Ví dụ: folder",
                    validate: function (val) {
                        if (App.str.replace(val, ['%', '?', '!', '\\', '#', ':', ';', "'", '|', '+', '=', '"', "^", '<', '>', ',', '*'], '') != val) return false;
                        return true;
                    }
                }
            },
            btnDone: "Tạo thư mục",
            done: function (data) {
                data.path = self.path;
                showLoading();
                ajaxRequest(self.urls.mkdir, "POST", data, function (rs) {
                    hideLoading();
                    if (rs.status) {
                        var data = rs.data;
                        App.Swal.success(rs.message, null, () => {
                            top.location.reload();
                        });
                    }
                    else if (rs.message) {
                        App.Swal.warning(rs.message, null, () => {
                            App.modal.show('popup-modal');
                        });
                    }
                    else {
                        App.Swal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                }, function () {
                    hideLoading();
                });
            }
        });

    },

    deleteItems: function (items) {
        if (!items || !items.length) {
            return App.modal.alert("Không có mục nào được chọn");
        }
        var self = this;
        var data = {};
        data.path = self.path;
        data.items = items;

        showLoading();
        ajaxRequest(self.urls.delete, "POST", data, function (rs) {
            hideLoading();
            if (rs.status) {
                var data = rs.data;
                if (data.length) {
                    for (let i = 0; i < data.length; i++) {
                        const filename = data[i];
                        $('tr[data-name="' + filename + '"]').hide(300, function () {
                            $(this).remove();
                        });
                    }
                }
            }
            else if (rs.message) {
                App.Swal.warning(rs.message);
            }
            else {
                App.Swal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            }
        }, function () {
            hideLoading();
        });

    },

    installPackage: function (package) {
        if (['laravel', 'wordpress-vi', 'wordpress-en'].indexOf(package)==-1) {
            return App.Swal.alert("Gói không hợp lệ");
        }
        var self = this;
        var a = {
            laravel:"Laravel",
            "wordpress-vi": "WordPress Tiếng Việt",
            "wordpress-en": "WordPress Tiếng Anh"
        };
        App.Swal.confirm("Bạn đang tiến hành cài đặt " + a[package] + "[nl]Việc này có thể sẽ ghi đè lên các file có sãn.[nl]Bạn có muốn tiếp tục không?", function(){
            showLoading();
            var data = {
                package: package
            };
            App.api.post(self.urls.install, data).then(function (rs) {
                hideLoading();
                if (rs.status) {
                    App.Swal.success("Đã cài đặt "+a[package]+" thành công", null, function(){
                        top.location.reload();
                    })
                }
                else if (rs.message) {
                    App.Swal.warning(rs.message);
                }
                else {
                    App.Swal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                }
            }).catch(function () {
                hideLoading();
                App.Swal.error("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
            });
    
        })



        
    },


    unzip: function (filename) {
        var self = this;
        App.modal.popup({
            title: "Giải nén",
            inputs: {
                directory: {
                    type: "text",
                    label: "Đường dẫn",
                    value: self.path,
                    placeholder: "Ví dụ: /puvlic/folder",
                    validate: function (val) {
                        if (App.str.replace(val, ['%', '?', '!', '\\', '#', ':', ';', "'", '|', '+', '=', '"', "^", '<', '>', ',', '*'], '') != val) return false;
                        return true;
                    }
                }
            },
            btnDone: "Giải nén",
            done: function (data) {
                data.path = self.path;
                data.filename = filename;
                showLoading();
                ajaxRequest(self.urls.unzip, "POST", data, function (rs) {
                    hideLoading();
                    if (rs.status) {
                        var data = rs.data;
                        App.Swal.success(rs.message, null, () => {
                            if(data.directory == self.path){
                                top.location.reload();
                            }
                            
                        });
                    }
                    else if (rs.message) {
                        App.Swal.warning(rs.message);
                    }
                    else {
                        App.Swal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                }, function () {
                    hideLoading();
                });
            }
        });
    },

    createFile: function () {
        var self = this;
        var types = ['html', 'js','css', 'php', 'json', 'jsx', 'ts', 'txt', 'java', 'py', 'less', 'sass', 'scss', 'xml', 'gltf', 'asp', 'aspx', 'xhtml', 'htm'];
        var datas = {};
        for (let i = 0; i < types.length; i++) {
            const type = types[i];
            datas[type] = type.toUpperCase() + " (."+type+")";
        }
        App.modal.popup({
            title: "Tạo file",
            inputs: {
                name: {
                    type: "text",
                    label: "Tên file",
                    // value: self.path,
                    placeholder: "Ví dụ: abc.html",
                    validate: function (val) {
                        if (App.str.replace(val, ['%', '?', '!', '\\', '#', ':', ';', "'", '|', '+', '=', '"', "^", '<', '>', ',', '*', '/'], '') != val) return false;
                        return true;
                    }
                },
                extension: {
                    type: "select",
                    label: "Loại file",
                    data: datas
                }
            },
            btnDone: "Tạo file ",
            done: function (data) {
                data.path = self.path;
                showLoading();
                ajaxRequest(self.urls.create, "POST", data, function (rs) {
                    hideLoading();
                    if (rs.status) {
                        var data = rs.data;
                        top.location.href = self.urls.editor + "?p=" + data.path;
                    }
                    else if (rs.message) {
                        App.Swal.warning(rs.message);
                    }
                    else {
                        App.Swal.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                    }
                }, function () {
                    hideLoading();
                });
            }
        });
    }

};

$(function () {
    if (typeof window.filemanagerInit == 'function') {
        window.filemanagerInit();
        window.filemanagerInit = null;
    }
    if ($('.crazy-list').length) {

        $(document).on('click', '.btn-move-all', function (e) {
            e.preventDefault();
            var items = App.FileManager.getCheckedValues();
            App.FileManager.moveItems(items);
            return false;
        });

        $(document).on('click', '.btn-make-dir', function (e) {
            e.preventDefault();
            App.FileManager.makeDir();
            return false;
        });
        $(document).on('click', '.btn-rename', function (e) {
            e.preventDefault();
            App.FileManager.rename($(this).data('filename'));
            return false;
        });

        $(document).on('click', '.btn-move-item', function (e) {
            e.preventDefault();
            App.FileManager.moveItems([$(this).data('filename')]);
            return false;
        });

        $(document).on('click', '.btn-new-file', function (e) {
            e.preventDefault();
            App.FileManager.createFile();
            return false;
        });
        $(document).on('click', '.btn-wp-vi', function (e) {
            e.preventDefault();
            App.FileManager.installPackage("wordpress-vi");
            return false;
        });
        $(document).on('click', '.btn-wp-en', function (e) {
            e.preventDefault();
            App.FileManager.installPackage("wordpress-en");
            return false;
        });
        $(document).on('click', '.btn-laravel', function (e) {
            e.preventDefault();
            App.FileManager.installPackage("laravel");
            return false;
        });


        
        $(document).on('click', '.btn-unzip', function (e) {

            var filename = $(this).data('filename');
            if ($(this).hasClass('dropdown-item')) {
                App.FileManager.unzip(filename);
            } else {

                e.preventDefault();
                App.FileManager.unzip(filename);

                return false;
            }


        });


        $(document).on('click', '.btn-delete-item', function (e) {
            e.preventDefault();
            var fn = $(this).data('filename');
            App.Swal.confirm("Bạn có chắc chắn muốn xoá " + fn, function (stt) {
                // if (stt) {
                    App.FileManager.deleteItems([fn]);
                // }
            });

            return false;
        });


        $(document).on('click', '.btn-delete-items', function (e) {
            e.preventDefault();
            var items = App.FileManager.getCheckedValues();
            if (!items.length) return App.modal.alert('Chưa có mục nào được chọn');
            App.Swal.confirm("Bạn có chắc chắn muốn xoá " + items.length + " mục đã chọn?", function (stt) {
                    App.FileManager.deleteItems(items);
                
            });

            return false;
        });

    }


});