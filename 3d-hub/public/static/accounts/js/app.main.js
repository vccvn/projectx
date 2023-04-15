
var objectKeys = function (obj) {
    var keys = [];
    if (App.isArray(obj) || App.isObject(obj)) {
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                keys.push(key);
            }
        }
    }
    return keys;
};
var objectValues = function (obj) {
    var values = [];
    if (App.isArray(obj) || App.isObject(obj)) {
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                values.push(obj[key]);
            }
        }
    }
    return values;
};
function isMobile() {
    return $(window).width() < 576;
}

function showLoading(timer) {
    let timerInterval
    if (!timer || isNaN(timer)) timer = 2000;
    var getDots = function (t) {
        var dots = '.';
        for (let i = 0; i < t; i++) {
            dots += '.';

        }
        return dots;
    }
    var n = 0;
    Swal.fire({
        title: 'Đang xử lý',
        html: 'Vui lòng chờ trong giây lát...',
        timer: timer,
        timerProgressBar: true,
        onBeforeOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                // const content = Swal.getContent()
                // if (content) {
                //     const b = content.querySelector('b')
                //     if (b) {
                //         b.textContent = getDots(n%5)
                //         n++;
                //     }
                // }
            }, 100)
        },
        onClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            // console.log('I was closed by the timer')
        }
    })
}
function hideLoading(timer) {
    if (timer && App.isNumber(timer)) {
        setTimeout(function () {
            Swal.close();
        }, timer);
    } else {
        Swal.close();
    }
}


window.addEventListener('load', function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('smart-form');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.classList.contains("auto-validation") && form.checkValidity() === false) {
                console.
                event.preventDefault();
                event.stopPropagation();
            } else {
                var submitAction = form.getAttribute("submitting");
                if (submitAction == "lock") {
                    if (form.getAttribute("is-submit") == "true") {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        form.setActiveMenuItem("is-submit", "true");
                    }
                }
                var submitBtn = form.querySelector('[type="submit"]');
                if (submitBtn) {
                    var txt = submitBtn.innerHTML;
                    submitBtn.setAttribute("data-origin-text", txt);
                    var submitLoadingText = submitBtn.getAttribute("data-submit-text") || "Đang xử lý";
                    submitBtn.innerHTML = submitLoadingText;
                    submitBtn.disabled = true;

                }
            }
            form.classList.add('was-validated');
        }, false);
    });
}, false);

$(function () {
    var $dateTimePicker = $(".datetime-picker");
    if ($dateTimePicker.length) {

        $dateTimePicker.each(function (i, el) {
            var $el = $(el);
            var format = $el.data('format') || "yyyy-mm-dd HH:ii:ss";
            $el.datetimepicker({
                format: format
            });
        })
    }

    var $datePicker = $(".date-picker");
    if ($datePicker.length) {

        $datePicker.each(function (i, el) {
            var $el = $(el);
            var format = $el.data('format') || "yyyy-MM-DD";
            $el.datepicker({
                dateFormat: format
            });
            // $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
        })
    }


    (function () {
        var $dateRangePickers = $('input.daterange');
        if ($dateRangePickers.length) {
            $dateRangePickers.each(function (i, el) {
                let $el = $(el);
                let format = $el.data("format") || "DD/MM/YYYY";
                $el.daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: format
                    }
                });
                $el.on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format(format) + ' - ' + picker.endDate.format(format));
                });

                $el.on('cancel.daterangepicker', function (ev, picker) {
                    $(this).val('');
                });

            });
        }
    }());



    function showChecklistRef(ref, id) {
        var $toggleWrapper = $('[data-ref-toggle="' + ref + '"]');
        if ($toggleWrapper.length) {
            $toggleWrapper.find('.ref-item').removeClass("active");
            if (App.getType(id) == 'array') {
                id.map(function (i) {
                    $toggleWrapper.find('[data-ref-id="' + i + '"]').addClass("active");
                })
            }
            else {
                $toggleWrapper.find('[data-ref-id="' + id + '"]').addClass("active");
            }
        }
    }

    function checkChecklistRef(wrapper) {
        var $w = $(wrapper);
        var ids = [];
        if ($w.data('ref')) {
            var ref = $w.data('ref');
            var $checked = $w.find('input:checked');
            if ($checked.length) {
                $checked.each(function (i, inp) {
                    ids.push($(inp).val());
                });
            }
            showChecklistRef(ref, ids);
        }

    }
    var $checkWrapper = $('.checklist');
    if ($checkWrapper.length) {
        $checkWrapper.each(function (i, w) {
            if ($(w).data("ref")) {
                checkChecklistRef(w);
            }

        });
        $checkWrapper.on("click", 'input[type="checkbox"], input[type="radio"]', function (e) {
            let w = $(e.target).closest('.checklist');
            if (w.length) {
                let $w = $(w[0]);
                if ($(w).data("ref")) {
                    checkChecklistRef(w[0], true, e.target);
                }
                let fn = $w.data('change') || $w.data('callback');
                if (App.func.check(fn)) {
                    var values = [];
                    var $checked = $w.find('input:checked');
                    if ($checked.length) {
                        $checked.each(function (i, inp) {
                            values.push($(inp).val());
                        });
                    }

                    App.func.call(fn, [values, e.target]);
                }
            }
        })
    }


    function showRadiolistRef(ref, id) {

        var $toggleWrapper = $('[data-ref-toggle="' + ref + '"]');

        if ($toggleWrapper.length) {
            var $remo = $toggleWrapper.find('[data-ref="' + ref + '"].ref-item');
            $remo.removeClass('active');
            var $active = $toggleWrapper.find('[data-ref-id="' + id + '"]');
            $active.addClass("active");

        }
    }


    function checkRadioRef(wrapper, change, el) {
        var $w = $(wrapper);
        var id = null;

        if ($w.data('ref')) {

            var ref = $w.data('ref');

            var $checked = $w.find('input:checked');
            if ($checked.length) {
                $checked.each(function (i, inp) {
                    if (!id) id = $(inp).val();
                });
            }
            showRadiolistRef(ref, id);
        }
        var fn = $w.data('change') || $w.data('callback');
        if (change && App.func.check(fn)) {
            App.func.call(fn, [id, el]);
        }
    }
    var $radioWrapper = $('[data-ref].radio-nav');
    if ($radioWrapper.length) {
        $radioWrapper.each(function (i, w) {
            checkRadioRef(w);
        });
        $radioWrapper.on("click", 'input[type="checkbox"], input[type="radio"]', function (e) {
            var w = $(e.target).closest('[data-ref].radio-nav');
            if (w.length) {
                checkRadioRef(w[0], true, e.target);
            }
        });
    }

    function checkMenuTab(wrapper) {
        var $w = $(wrapper);
        $active = $w.find('li a.active');

        if ($active.length) {
            var st = $($active[0]).attr('href');
            var id = $w.attr('id');
            var $ref = $('[menu-controller="' + id + '"]');
            $ref.find('.lottery-tab-content').removeClass('active');
            if (st.substr(0, 1) == '#') {
                $(st).addClass('active');
            }
            var control = $($active[0]).data('control');
            if (control) {
                $ref.find('[data-ref="' + control + '"]').addClass('active');
            }
        }
    }

    var meslt = '.lottery-menu.menu-tab';
    $(meslt + " li a.menu-link").click(function (e) {
        e.preventDefault();
        var par = $(this).closest(meslt);
        if (par.length) {
            var $nav = $(par[0]);
            $nav.find('li a.menu-link').removeClass("active");
            $(this).addClass("active");
            checkMenuTab(par[0]);
        }
        return false;
    });

    var $tableHover = $('table.table-hover');
    if ($tableHover.length) {
        $tableHover.each(function (i, tbl) {
            var $tbl = $(tbl);
            $tbl.find('[data-col]').hover(function () {
                $tbl.find('[data-col]').removeClass('hover');
                $tbl.find('[data-col="' + $(this).data('col') + '"]').addClass('hover');
            }, function () {
                $tbl.find('[data-col="' + $(this).data('col') + '"]').removeClass('hover');
            });
        });
    }
    $(document).on("click", 'input[type="checkbox"].checkbox-control', function (e) {
        var ref = $(this).data('ref');
        if (ref) {
            var $ref = $('[data-controller="' + ref + '"].checkbox-list input[type="checkbox"].checkbox-item');
            if ($(this).is(":checked")) {
                $ref.prop("checked", true);
            } else {
                $ref.prop("checked", false);
            }
        }
    });
    $(document).on("click", '[data-controller].checkbox-list input[type="checkbox"].checkbox-item', function (e) {
        var wrapper = $(this).closest('[data-controller].checkbox-list');

        if (wrapper.length) {
            var $controller = $('input[data-ref="' + wrapper.data("controller") + '"].checkbox-control');
            if ($controller.length) {
                var $item = wrapper.find('input[type="checkbox"].checkbox-item');
                var $itemChecked = wrapper.find('input[type="checkbox"].checkbox-item:checked');
                if ($item.length == $itemChecked.length) {
                    $controller.prop("checked", true);
                } else {
                    $controller.prop("checked", false);
                }
            }
        }
    });


    $("#ajax-2fa").submit(function (e) {
        e.preventDefault();
        // var google_code = .val();
        var action = $(this).attr("action");
        var data = {};
        $(this).find('input').each(function (i, el) {
            data[el.name] = el.value;
        })
        if (!data.google_code) return false;
        App.request.post(action, {
            data: data,
            dataType: "json"
        })
            .then(function (res) {
                if (res.status) {
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Đã có lỗi xảy ra',
                        text: res.message,
                        // footer: '<a href>Why do I have this issue?</a>'
                    });
                }
            })
            .catch(function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Đã có lỗi xảy ra',
                    text: "Vui lòng thử lại sau giay lát",
                    // footer: '<a href>Why do I have this issue?</a>'
                });
            })
    });



    if ($(window).width() < 768) {
        $('.nav-tabs.left-tabs').removeClass('left-tabs');
    }


    $(document).on("click", ".smart-table.sortable thead tr th", function () {
        var url = $(this).data('url');
        if (url) {
            top.location.href = url;
        }
    });


    var $dateSelect = $('.date-select');
    if ($dateSelect.length) {
        $dateSelect.each(function (i, el) {
            var $el = $(el);
            var options = "";
            var defVal = null;
            if ($el.data("default-option")) {
                var txt = $el.data("default-option");
                var val = "";
                var divStr = txt.split(":");
                if (divStr.length > 1) {
                    val = divStr[1].trim();
                    defVal = val;
                    txt = divStr[0].trim();
                }
                options += "<option value=\"" + val + "\">" + txt + "</option>";
            }

            var start = 1;
            var end = 12;
            var item = ($el.data("item") + "").toLowerCase();
            if (item == "year" || $el.hasClass("year")) {
                start = 2020;
                end = 2020 - 70;
                if ($el.data("start")) {
                    var s = parseInt($el.data("start"));
                    if (isNaN(s) || s < 0) s = 2020;
                    start = s;
                }
                if ($el.data("finish")) {
                    var f = parseInt($el.data("finish"));
                    if (isNaN(f)) f = start - 50;
                    end = f;
                }
            } else if (item == "month" || $el.hasClass("month")) {
                start = 1;
                end = 12;
            } else {
                start = 1;
                end = 31;
            }
            if (start < end) {
                for (let i = start; i <= end; i++) {
                    options += "<option value=\"" + i + "\" " + (defVal == i ? "selected" : "") + ">" + i + "</option>";

                }
            } else {
                for (let i = start; i >= end; i--) {
                    options += "<option value=\"" + i + "\" " + (defVal == i ? "selected" : "") + ">" + i + "</option>";

                }
            }
            $el.html(options);
        })
    }


    $(".custom-file-input").off();
    $(document).on("change", ".custom-file-input", function () {
        var t = $(this).val();
        var self = this;
        $(this).next(".custom-file-label").addClass("selected").html(t);

        var onc = $(self).data('on-change');
        var files = this.files;
        var callback = function (fs) {
            if (!fs) fs = [];
            if (onc) {
                let oncbs = onc.split(',');
                if (oncbs.length > 1) {
                    oncbs.forEach(element => {
                        let func = element.trim();
                        if (App.func.check(func)) {
                            App.func.call(func, [self, fs]);
                        }
                    });

                }
                else if (App.func.check(onc)) {
                    App.func.call(onc, [self, fs]);
                }

            }
        };
        if (window.File && window.FileList && files && files.length) {
            var list = [];
            var lsName = [];
            let max = files.length - 1;
            for (var i = 0; i < files.length; i++) {
                let file = files[i];
                lsName.push(file.name);
                if (onc && window.FileReader) {
                    (function (file, index, coumt) {
                        let fileReader = new FileReader();
                        fileReader.onload = function (f) {
                            let src = f.target.result;
                            let data = {
                                filename: file.name,
                                size: file.size,
                                data: src
                            };

                            list.push(data);
                            if (index == coumt) {
                                callback(list);
                            }
                        };
                        fileReader.readAsDataURL(file);
                    })(file, i, max);
                }
                if (i == max) {
                    $(self).next(".custom-file-label").addClass("selected").html(lsName.join(', '));
                }

            }
        } else {
            callback([]);
        }
    });


   
    // $(document).on('click', '.btn-lock-my-account', function(e){
    //     e.preventDefault();
    //     App.Swal.confirm("Bạn có chắc chắn muốn khóa tài khoản của mình không?<br> Nếu khóa bạn không thể tự kích hoạt được mà phải nhờ chủ nhánh!", function(){
    //         App.modal.popup({
    //             title: 'Khóa tài khoản',
    //             inputs:{
    //                 otp:{
    //                     type: "number",
    //                     label: "Mã OTP",
    //                     placeholder: "Nhập mã OTP (Google 2FA)"
    //                 }
    //             }, 
    //             done: function(data){
    //                 App.api.post("lock", data).then(res => {
    //                     if(res.status){
    //                         App.Swal.success("Đã khóa tài khoản thành công!", null, () => location.reload());
    //                     } else {
    //                         App.Swal.warning(res.message);
    //                     }
    //                 }).catch(err => {
    //                     console.log(err);
    //                     App.Swal.error("Lỗi không xác định");
    //                 });
    //             }
    //         })
    //     })
    // });

    $(document).on("click", ".notify-item", function (e) {
        e.preventDefault();
        var read = $(this).data('read');
        var url = $(this).data('url');
        var type = $(this).data('type');
        var g = function () {
            if(type == 'route' || type=='url' || type=='link'){
                if(url && url.substr(0,4) == 'http'){
                    location.href = url;
                }
            }
        }
        if(read != "1"){
            App.api.post("markread", {id: $(this).data("id")})
            .then(function(res){
                if(res.status){
                    g();
                }
            })
        }else{
            g();
        }
    })
});