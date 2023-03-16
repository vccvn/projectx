/**
 * hiểm thị màn hình loading
 */
const showLoading = () => {
    $('.crazy-loading').addClass('show');
};

/**
 * ẩn màn hình loading
 */
const hideLoading = () => {
    $('.crazy-loading').removeClass('show');
};


function _xhr(url, method, data, success, error) {
    if (typeof success != 'function') success = cl;
    if (typeof error != 'function') error = cl;
    $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: 'JSON',
        cookie: true,
        success: success,
        error: error
    });
}

/**
 *
 * @param {string} url đường dẫn
 * @param {string} method phương thức gửi data ví dụ GET, POST, PUT, DELETE, OPTIONS
 * @param {object} data dữ liệu gữi đi
 * @param {function} success hàm sẽ được gọi khi có phản hồi 200
 * @param {function} error hàm sẽ được gọi khi có lỗi xảy ra
 */
const ajaxRequest = function(url, method, data, success, error){
    showLoading();

    _xhr(url, method, data, function(rs){
        hideLoading();
        if(typeof success == "function"){
            success(rs);
        }
    }, function(err){
        hideLoading();
        if(typeof error == "function"){
            error(err);
        }
    });
}


// date picker
var CustomBootstrapDatepicker=function(){
    var t;t=mUtil.isRTL()?{leftArrow:'<i class="la la-angle-right"></i>',rightArrow:'<i class="la la-angle-left"></i>'}:{leftArrow:'<i class="la la-angle-left"></i>',rightArrow:'<i class="la la-angle-right"></i>'};
    return{
        init:function(){
            var selectors = ".form-group .inp-date";

            if(typeof datepicker_selectors == 'object'){
                var datepicker_selectors_arr = [];
                for (const k in datepicker_selectors) {
                    datepicker_selectors_arr[datepicker_selectors_arr.length] = datepicker_selectors[k];
                }
                if(datepicker_selectors_arr.length){
                    selectors = datepicker_selectors_arr.join(', ');
                }
            }


            $(selectors).datepicker({
                rtl:mUtil.isRTL(),
                todayHighlight:!0,
                orientation:"bottom left",
                templates:t,
                locale: 'vi',
                format: 'dd/mm/yyyy'
            })
        }
    }
}();

/**
 * thiết lập date range picker
 * @param {*} selector
 */
const setDateRangePicker = selector => {
    let $dateRange = $(selector);
    let $input = $dateRange.find('.form-control');
    let dateFormat = $input.data('format') || 'DD/MM/YYY';
    let useTime = $input.data('use-time') || false;
    let options = {
        buttonClasses:"m-btn btn",
        applyClass:"btn-primary",
        cancelClass:"btn-secondary",
        locale:{format:dateFormat}
    };
    if(["true", "on", true].indexOf(useTime) >= 0){
        options.timePicker=true;
        options.timePickerIncrement=1;
    }

    $dateRange.daterangepicker(options,function(a,t,n){
        $(selector + ' .form-control').val(a.format(dateFormat)+" - "+t.format(dateFormat))
    });
}

/**
 * date range init
 */
var CustomBootstrapDaterangepicker={
    init:function(){
        if(typeof daterange_selectors == 'object'){
            for (const k in daterange_selectors) {
                const selector = daterange_selectors[k];
                setDateRangePicker(selector);
            }
        }

    }
};

var CustomBootstrapTouchspin={
    init:function(){
        if($(".inp-touchspin").length){
            $(".inp-touchspin").each((i, el) => {
                let bdc = $(el).data('buttom-down-class') || "btn btn-secondary";
                let buc = $(el).data('buttom-up-class') || "btn btn-secondary";
                let min = Number($(el).attr('min'));
                let max = Number($(el).attr('max'));
                let _st = Number($(el).attr('step'));
                let step = isNaN(_st)?1:_st;
                let dec = Number($(el).data('decimals'));
                let bta = Number($(el).data('boostat'));
                let mba = Number($(el).data('maxboostedstep'));
                let options = {
                    buttondown_class: bdc,
                    buttonup_class: buc,
                    step: step
                };
                if(!isNaN(min)){
                    options.min = min;
                }
                if(!isNaN(max)){
                    options.max = max;
                }
                if(!isNaN(dec)){
                    options.decimals = dec;
                }
                options.boostat = isNaN(bta)?5:bta;
                options.maxboostedstep = isNaN(mba)?10:mba;
                $(el).TouchSpin(options);
            });
        }

    }
};

var CustomSelect2={init:function(){$(".inp-select2").select2({placeholder:"Chọn một"})}};


var CustomCropitEditor = {
    init:function(){
        if(typeof cropit_data == 'object'){
            const startCropitEditor = (selector,src) => {
                let $editor = $(selector + ' .cropit-editor');
                const saveImageData = () =>{
                    var imageData = $editor.cropit('export');
                    $editor.find('.hidden-image-data').val(imageData);
                };
                let status = false
                const setStatus = stt => {status = stt;};
                const hasData = () => status;
                $editor.cropit({
                    imageState: {
                        src: src
                    },
                    smallImage:'allow',
                    onFileChange:function(e) {
                        setStatus(true);
                        setTimeout(saveImageData,100);
                    }
                });

                $editor.find('.cropit-image-zoom-input').change(function() {
                    setStatus(true);
                    setTimeout(saveImageData,100);
                });
                // Handle rotation
                $editor.find('.rotate-cw-btn').click(function() {
                    $editor.cropit('rotateCW');
                });
                $editor.find('.rotate-ccw-btn').click(function() {
                    $editor.cropit('rotateCCW');
                });

                // if($editor.find('.cropit-preview img').length){
                //     $editor.find('.cropit-preview img').on('mouseup mouseout',()=>{
                //         saveImageData();
                //     });
                // }
                // lang nghe su kiem submit
                $('form').submit(() => {
                    if(hasData()) saveImageData();
                });
            };

            for (const k in cropit_data) {
                const data = cropit_data[k];
                startCropitEditor(data.selector, data.image);
            }
        }
    }
};

var Notice = {
    page:0,
    page_size:10,
    page_total: 0,
    first_open:false,
    data:[],
    get_notice_url:'',
    getNotices: function(){
        if(this.page > 0 && this.page_total > 0 && this.page >= this.page_total) return true;
        var self = this;
        var page = this.page + 1;
        var loading = '<div class="loading text-center">Đang tải <div class="m-loader m-loader--info" style="width: 30px; display: inline-block;"></div></div>';
        $('#topbar-notification-list').append(loading);
        ajaxRequest(this.get_notice_url, "get", {page:page, page_size:this.page_size}, function (rs){
            if(rs.status){
                self.first_open = !0;
                self.page = rs.page;
                self.page_total = rs.page_total;
                self.page_size = rs.page_size;
                if(rs.data) {
                    var template = '<div class="m-list-timeline__item">'
                    +'<span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>'
                    +'<span class="m-list-timeline__text">{$title}</span>'
                    +'<span class="m-list-timeline__time">{$time}</span>'
                    +'</div>';
                    var html = '';
                    for(var i = 0; i < rs.data.length; i++){
                        var notify = rs.data[i];
                        html += App.str.eval(template, notify);
                    }
                    $('#topbar-notification-list').append(html);

                }
                else{
                    $('#topbar-notification-list').append('<span>Không có thông báo mới nào</span>');
                }

                $('#topbar-notification-list .loading').remove();

            }
        })
    },
    show:function(){
        if(!this.first_open){
            this.getNotices();
        }
    }
};


var Select2={
    init:function(){
        $(".multi-select").select2({
            placeholder:"Select a state"
        })
    }
};

var TimePickerInit = function(){
    var addTimePicker = function(selector, format){
        $(selector).datetimepicker({
            format:format,
            todayHighlight:!0,
            autoclose:!0
        });
    };
    if($('input.inp-time').length){
        $('input.inp-time').each(function(i, e){
            let format = $(e).data("format") || 'hh:ii:ss';
            addTimePicker(e, format);
        });
    }
};

var noUiSliderDemos={
    init:function(){
        var $noUiSliders = $('.crazy-nouislider');
        if($noUiSliders.length){
            $noUiSliders.each(function(i, el){
                var $el = $(el);

                var listNumberNames = ["start", "step", "min", "max", "value"];
                var listNumberValues = [0, 1, 0, 0, 0];
                var params = {};
                for (let i = 0; i < listNumberNames.length; i++) {
                    const paramName = listNumberNames[i];
                    params[paramName] = Number($el.data(paramName));
                    if(isNaN(params[paramName])) params[paramName] = listNumberValues[i];
                }
                var formatData = {decimals:0};
                var d = $el.data('format');
                if(d){
                    try {
                        var f = JSON.parse(d);
                        if(typeof d.decimals !== "undefined"){
                            FormData = f;
                        }
                    } catch (error) {
                        // nothing
                    }
                }
                var options = {
                    start:[params.start],
                    step:params.step,

                    range:{
                        min:[params.min],
                        max:[params.max]
                    },
                    format:wNumb(formatData)
                };
                noUiSlider.create(el,options);

                var onc = $el.data('on-change');

                var oncbs = [];
                if(onc){
                    onc = onc.trim();
                    let oncbs1 = onc.split(',');

                    if(oncbs1.length>1){
                        for (let i = 0; i < oncbs1.length; i++) {
                            const f = oncbs1[i].trim();
                            if(f){
                                oncbs[oncbs.length] = f;
                            }
                        }
                    }
                    else{
                        oncbs[0] = onc;
                    }
                }

                var inputId = $el.data('input-id');
                var inp = null;

                if(inputId){
                    var n=document.getElementById(inputId);
                    if(n){
                        inp=n;
                    }
                }

                if(inp){
                    var inpVal = Number(inp.value);
                    if(!isNaN(inpVal) && inpVal != 0 && params.start == 0){
                        el.noUiSlider.set(inpVal);
                    }
                    var inpOnChanges = [];
                    var onchange = inp.getAttribute('data-on-change');

                    if(onchange){
                        onchange = onchange.trim();
                        let oncbs2 = onchange.split(',');

                        if(oncbs2.length>1){
                            for (let i = 0; i < oncbs2.length; i++) {
                                const f = oncbs2[i].trim();
                                if(f){
                                    inpOnChanges[inpOnChanges.length] = f;
                                }
                            }
                        }
                        else{
                            inpOnChanges[0] = onchange;
                        }
                    }
                    el.noUiSlider.on("update",function(e,t){
                        inp.value=e[t];
                        if(oncbs.length){
                            oncbs.forEach(element => {
                                let func = element.trim();
                                if(App.func.check(func)){
                                    App.func.call(func, [e[t], e]);
                                }
                            });

                        }
                    });
                    inp.addEventListener("change",function(){
                        el.noUiSlider.set(this.value);
                        var $this = this;
                        if(inpOnChanges.length){
                            inpOnChanges.forEach(element => {
                                let func = element.trim();
                                if(App.func.check(func)){
                                    App.func.call(func, [$this.value, $this]);
                                }
                            });

                        }
                    });
                }
                else{
                    el.noUiSlider.on("update",function(e,t){
                        if(oncbs.length){
                            oncbs.forEach(element => {
                                let func = element.trim();
                                if(App.func.check(func)){
                                    App.func.call(func, [e[t], e]);
                                }
                            });
                        }
                    })
                }
            });
        }
    }
};



App.location = {
    urls: {},
    init_list: ["urls"],
    regionID: 0,
    districtID: 0,

    changeRegionID: function(value, text, el){
        if(value != this.regionID){
            this.regionID = value;
            App.htmlSelect.deactive('district_id');
            App.htmlSelect.deactive('ward_id');
            App.htmlSelect.changeOptions('district_id', {0: "Chọn một"});
            App.htmlSelect.changeOptions('ward_id', {0: "Chọn một"});
            if(value && value != "0"){
                ajaxRequest(this.urls.district_options, "get", {region_id: value}, function(res){
                    if(res.status){
                        App.htmlSelect.changeOptions('district_id', res.data);
                    }
                });
            }
        }
    },

    changeDistrictID: function(value, text, el){
        if(value != this.districtID){
            this.districtID = value;
            App.htmlSelect.deactive('ward_id');
            App.htmlSelect.changeOptions('ward_id', {0: "Chọn một"});
            if(value && value != "0"){
                ajaxRequest(this.urls.ward_options, "get", {district_id: value}, function(res){
                    if(res.status){
                        App.htmlSelect.changeOptions('ward_id', res.data);
                    }
                });
            }
        }
    }

};

App.posts = {
    urls: {},
    init_list: ["urls"],
    changeDynamicID:function(id, $select){

        if(!this.urls.get_category_url) return false;
        var category_id = $select.$el.data("ref") || "category_id";
        ajaxRequest(this.urls.get_category_url, "GET", {dynamic_id:id}, function(rs){
            if(rs.status){
                if(rs.data){
                    App.htmlSelect.changeOptions(category_id, rs.data);
                }else{
                    App.htmlSelect.changeOptions(category_id, {"0": "Không"});
                }
            }else{
                App.htmlSelect.changeOptions(category_id, {"0": "Không"});
            }
        })
    }
};

jQuery(function($){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    CustomBootstrapDatepicker.init();
    CustomBootstrapDaterangepicker.init();
    CustomBootstrapTouchspin.init();
    CustomSelect2.init();
    CustomCropitEditor.init();
    Select2.init();

    noUiSliderDemos.init();

    TimePickerInit();



    setTimeout(function(){
        $(".custom-file-input").off();
        $(document).on("change", ".custom-file-input",function(){
            var t=$(this).val();
            var self = this;
            $(this).next(".custom-file-label").addClass("selected").html(t);

            var onc = $(self).data('on-change');
            var files = this.files;
            var callback = function (fs){
                if(!fs) fs = [];
                if(onc){
                    let oncbs = onc.split(',');
                    if(oncbs.length>1){
                        oncbs.forEach(element => {
                            let func = element.trim();
                            if(App.func.check(func)){
                                App.func.call(func, [self, fs]);
                            }
                        });

                    }
                    else if(App.func.check(onc)){
                        App.func.call(onc, [self, fs]);
                    }

                }
            };
            if (window.File && window.FileList && files && files.length) {
                var list = [];
                var lsName  = [];
                let max = files.length - 1;
                for (var i = 0; i < files.length; i++) {
                    let file = files[i];
                    lsName.push(file.name);
                    if(onc && window.FileReader){
                        (function(file, index, coumt) {
                            let fileReader = new FileReader();
                            fileReader.onload = function(f) {
                                let src = f.target.result;
                                let data = {
                                    filename: file.name,
                                    size: file.size,
                                    data: src
                                };

                                list.push(data);
                                if(index == coumt){
                                    callback(list);
                                }
                            };
                            fileReader.readAsDataURL(file);
                        })(file, i, max);
                    }
                    if(i == max){
                        $(self).next(".custom-file-label").addClass("selected").html(lsName.join(', '));
                    }

                }
            }else{
                callback([]);
            }
        });

    }, 500);



    $('#m_topbar_notification_icon').click(function(){
        if($(this).parent().hasClass('m-dropdown--open')){

        }else{
            Notice.show();
        }
    });

    if(typeof crazyweb == "object"){
        if(typeof crazyweb.get_notice_url != "undefined"){
            Notice.get_notice_url = crazyweb.get_notice_url;
        }
    }

    if($('.crazy-form').length){
        $('.crazy-form').submit(function(){
            var $this = $(this);
            if($this.data('submitting')) {
                console.log('this form is submitting!');
                return false;
            }
            $this.data('submitting', "true");
            $this.find('.btn-submit-form,button[type="submit"],input[type="submit"]').addClass("m-loader m-loader--right m-loader--light").attr("disabled",!0);
            $this.find('.crazy-hidden-template').remove();
            if($this.find('.input-gallery.has-advanced-upload').length){
                $this.find('.input-gallery.has-advanced-upload input[type="file"]').remove();
            }
            return true;
        });
        $(document).keydown(function(event) {
            // If Control or Command key is pressed and the S key is pressed
            // run save function. 83 is the key code for S.
            if((event.ctrlKey || event.metaKey) && event.which == 83) {
                // Save Function
                event.preventDefault();
                $('.crazy-form').submit();
                return false;
            }
        });
        $(document).on('click', '.sticky-btn-submit-form', function (e) {
            e.preventDefault();
            $('.crazy-form').submit();
            $(this).addClass("m-loader m-loader--right m-loader--light").attr("disabled",!0);
            return false;
        })
    }
    $(document).on('change', '.crazy-checkbox', function(){
        var self = this;
        setTimeout(function(){
            var stt = $(self).is(':checked');
            if($(self).data('on-check') && stt){
                App.func.call($(self).data('on-check'), [stt, self]);
            }
            if($(self).data('on-uncheck') && !stt){
                App.func.call($(self).data('on-uncheck'), [stt, self]);
            }
            if($(self).data('on-change')){
                var onc = $(self).data('on-change');
                if(onc){
                    let oncbs = onc.split(',');
                    if(oncbs.length>1){
                        oncbs.forEach(element => {
                            let func = element.trim();
                            if(App.func.check(func)){
                                App.func.call(func, [stt, self]);
                            }
                        });

                    }
                    else if(App.func.check(onc)){
                        App.func.call(onc, [stt, self]);
                    }
                }
            }
        }, 50);
    });

    var autoHeight = function (el) {
        var min = 40;
        var max = 400;
        var textHeight = el.scrollHeight;
        var value = el.innerText;
        // var fz = $(el).css("font-size");
        if(value && fz) min = value.split("\r\n").length + "rem";
        else{
            min = "40px";
        }
        if(textHeight < min) textHeight = min;
        else if(textHeight > max) textHeight = max + "px";
        
        
        $(el).css({
            height: textHeight
        });
        // $(el).autoResize();
    }
    var autoHeightSelector = 'textarea.auto-height';
    var $tah = $(autoHeightSelector);
    if($tah.length){
        $tah.map(e => {
            autoHeight(e);
        })
    }
    $(document).on('keyup mouseup', autoHeightSelector, function (e) {
        autoHeight(e.target);
    });



    if (typeof window.locationInit == "function") {
        if (typeof window.locationInit == "function") {
            window.locationInit();
        }
    }
    else{

        if(typeof location_data == 'object'){
            App.location.urls = location_data.urls || {};
        }
    }

    if (typeof window.postsInit == "function") {
        if (typeof window.postsInit == "function") {
            window.postsInit();
        }
    }
    else{
        if(typeof posts_data == 'object'){
            App.posts.urls = posts_data.urls || {};
        }
    }


    var radioGroups = $('.crazy-radio-group');
    if(radioGroups.length){
        radioGroups.each(function(i, group){
            var _value = null;
            var $group = $(group);
            var change = $group.attr('crazy-on-change');
            
            if(change && App.func.check(change)){
                var _dispatch = function(v, target){
                    App.func.call(change, [v, target]);
                }
                
                // $group.find('input[type="radio"]').each(function(index, inp){
                //     var $inp = $(inp);
                //     if($inp.is(":checked")){
                //         _value = $inp.val();
                //     }
                //     $inp.on("change", function(e){
                //         if($(this).is(":checked")){
                //             _value = $inp.val();
                //             _dispatch(_value, e.target);
                //         }
                //     });
                // });
                // console.log($group.find('.checkbox-label'));

                $group.find('.checkbox-label').each(function(index, g){
                    var $g = $(g);
                    var $inp = $g.find('input[type="radio"]');
                    if($inp.is(":checked")){
                        _value = $inp.val();
                    }
                    $g.on("click", function(e){
                        if($inp.is(":checked")){
                            var vl = $inp.val();
                            if(vl!=_value){
                                _value = vl;
                                _dispatch(_value, e.target);
                            }
                            
                        }
                    });
                });
                
                _dispatch(_value, null);
            }

        })
    }


});



var prefixClass = '.crazy-';
var paymentMethods = $(prefixClass + "payment-methods");
    
if(paymentMethods.length){
    var hidePaymentMethodDescription = function(){
        paymentMethods.find(prefixClass+"payment-method-description").removeClass('show');

    };
    var showPaymentMethodDescription = function(value){
        hidePaymentMethodDescription();
        paymentMethods.find(prefixClass+"payment-method-description[data-method="+value+"]").addClass('show');
    }

    var paymentValues = paymentMethods.find(prefixClass + "payment-method-value");
    // hidePaymentMethodDescription();
    paymentValues.map(function(e){
        if($(e).is(":checked")){
            showPaymentMethodDescription($(e).val());
        }
    });
    $(document).on('change', prefixClass + "payment-method-value", function(e){
        if($(this).is(":checked")){
            showPaymentMethodDescription($(this).val());
        }
    });

}