function CrazyModal(selector){
    var $modal = $(selector);
    var $header = $modal.find('.modal-header'),
        $body = $modal.find('.modal-body'),
        $footer = $modal.find('.modal-footer');
    var $title = $header.find('.modal-title'),
        $message = $body.find('.modal-message'),
        $buttons = $footer.find('.modal-buttons');
    var hideCallback = null;
    var ShowCallback = null;
    var self = this;

    this.isOpen = false;


    this.show = function(callback){
        
    };

    
}











/**
 * modal
 */

App.modal = {
    confirm_callback: App.log,
    hide_callback:null,
    show_callback:null,
    is_on: false,
    current_open: null,
    last_open:null,
    waiting_for_hide: false,
    popupData:{},
    popupFiles: {},
    /**
     * Hiển thị modal
     * @param {string} id id của modal
     * @param {Function} show_callback ham thuc thi ngay sau khi hien thi modal
     * @param {Function} hide_callback Hàn thực thi sau khi đóng modal
     */
    show:function(id, show_callback, hide_callback) {

        var self = this;
        if (id == self.current_open) return true;
        if (self.is_on) {
            self.hide(null, function() {
                self.show(id, show_callback, hide_callback);
            });
        } else {
            if (typeof show_callback == 'function') {
                self.show_callback = show_callback;
            }
            $('#' + id).modal('show');
                
            if(typeof hide_callback == "function"){
                setTimeout(function(){
                    self.hide_callback = hide_callback;
                }, 201);
            }
        }
    },
    /**
     * ẩn modal
     * @param {string} id id của modal
     * @param {Function} callback Hàn thực thi sau khi đóng modal
     */
    hide: function (id, callback) {
        var self = this;
        if (typeof callback == 'function') {
            self.hide_callback = callback;
        }
        if (id) {
            $('#' + id).modal('hide');
        } else {
            $('.modal').modal('hide');
        }
    },
    

    /**
     * mở hộp thoại xác thực
     * @param {string} message 
     * @param {function} callback 
     */
    confirm: function (message, callback, hide_callback) {
        if (typeof(callback) == 'function') {
            this.confirm_callback = callback;
        } else {
            this.confirm_callback = App.emptyFunc;
        }
        
        $('#confirm-modal .modal-message').html(message);
        this.show('confirm-modal', null, hide_callback);
    },

    answer: function modal(stt) {
        this.confirm_callback(stt ? true : false);
    },
    

    /**
     * Hiển thị thông báo
     * @param {string} message Nội dung thông báo
     * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
     * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
     */
    alert:function (message, callback, hideCallback) {
        $('#alert-modal .modal-message').html(message);
        this.show('alert-modal', callback, hideCallback);
    },
    

    /**
     * Hiển thị thông tin
     * @param {string} message Nội dung thông báo
     * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
     * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
     */
    info:function (message, callback, hideCallback) {
        $('#info-modal .modal-message').html(message);
        this.show('info-modal', callback, hideCallback);
    },
    

    /**
     * Hiển thị thông báo hành động thành công
     * @param {string} message Nội dung thông báo
     * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
     * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
     */
    success:function (message, callback, hideCallback) {
        $('#success-modal .modal-message').html(message);
        this.show('success-modal', callback, hideCallback);
    },
    

    /**
     * Hiển thị thông báo
     * @param {string} message Nội dung thông báo
     * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
     * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
     */
    warning:function (message, callback, hideCallback) {
        $('#warning-modal .modal-message').html(message);
        this.show('warning-modal', callback, hideCallback);
    },
    

    /**
     * Hiển thị thông báo lỗi
     * @param {string} message Nội dung thông báo
     * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
     * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
     */
    error:function (message, callback, hideCallback) {
        $('#error-modal .modal-message').html(message);
        this.show('error-modal', callback, hideCallback);
    },
    
    /**
     * Hiển thị nội dung tùy ý
     * @param {object} data 
     */
    custom: function (data, showCallback, hideCallback) {
        if (data) {
            var t = App.getType(data);
            if (t == 'object') {
                var title = data.title ? data.title : '';
                var content = data.content ? data.content : '';
                var buttons = document.getElementById('custom-modal-buttons');
                var btns = [];
                buttons.innerHTML = '';
                if (data.buttons) {
                    var btnData = data.buttons;
                    var bt = App.getType(btnData);
                    if (bt == 'object') {
                        btns[0] = btnData;
                    } else if (bt == 'array') {
                        btns = btnData;
                    }

                    for (var i = 0; i < btns.length; i++) {
                        let btn = btns[i];
                        let btnText = 'Button';
                        // let btnHtml = '<button';
                        let button = document.createElement('button');
                        if (!btn.type) {
                            button.setAttribute('type', 'button');
                        }
                        for (let prop in btn) {
                            let key = prop.toLowerCase();
                            let val = btn[prop];
                            if (key == 'text') {
                                btnText = val;
                            } else if (key == 'classname' || key == 'class') {
                                button.className = val;
                            } else if (key == 'click' || key == 'onclick') {
                                if(typeof val == 'function'){
                                    button.addEventListener('click', val,false);
                                }else{
                                    button.setAttribute('data-click', val);
                                    button.addEventListener('click', function(e){
                                        App.func.call(this.getAttribute('data-click'));
                                    },false);
                                }
                            } else {
                                button.setAttribute(prop,val);
                            }
                        }
                        button.classList.add('mr-2');
                        // let text = document.createTextNode(btnText);
                        button.innerHTML = btnText;
                        buttons.appendChild(button);
                    }
                }
                $('#custom-modal .custom-modal-content').html(content);
                $('#custom-modal .modal-title').html(title);
                // $('#custom-modal .modal-buttons').html(buttons);
                if (data.size) {
                    $('#custom-modal .modal-dialog').removeClass().addClass('modal-dialog modal-' + data.size);
                }
                this.show('custom-modal', showCallback, hideCallback);
            }
        }
    },
    
    /**
     * Hiển thị popup để nhập thông tin
     * @param {object} options 
     * @param {function} doneCallback hàm sẽ thực thi sau khi du744 liệu được nhập dúng mẫu
     */
    
    popup:function(options, doneCallback, showCallback, hideCallback){
        this.popupData = {};
        var defaults = {
            btnDone:"Xong",
            btnCancel:"Đóng",
            title:"Nhập thông tin",
            options: {}
        };
        var params = {};
        if(typeof doneCallback == 'function'){
            params.done = doneCallback;
        }
        else{
            params.done = App.log;
        }
        if(App.getType(options) == 'object'){
            params.btnDone = options.btnDone || defaults.btnDone;
            params.btnCancel = options.btnCancel || defaults.btnCancel;
            params.title = options.title || defaults.title;
            params.options = options.options || defaults.options;
            if(typeof options.done == 'function') params.done = options.done;
            if(typeof options.inputs != 'undefined' && options.inputs){
                var t = App.getType(options.inputs);
                if(t == "object"){
                    params.inputs = options.inputs;
                }else if(t == "Array" && options.inputs.length){
                    var inputs = {};
                    var l = options.inputs.length;
                    for (let i = 0; i < l; i++) {
                        const input = options.inputs[i];
                        if(App.getType(input) == "object"){
                            if(input.name){
                                inputs[input.name] = input;
                            }
                        }
                    }
                }
            }
            if(typeof options.validate != "undefined" && App.getType(options.validate) == "object"){
                params.validate = options.validate;
            }
        }
        if(params.inputs){
            this.popupData = params;
            var html = "";
            var label_class = "col-sm-4 col-lg-3";
            var input_class = "form-control m-input";
            var wrapper_class = "col-sm-8 col-lg-9";
            var formGroup = '<div class="form-group row" id="{$id}-group"><label for="{$id}" id="{$id}-label" class="{$label_class}">{$label}</label>'
                + '<div class="{$wrapper_class}">{$input}</div>'
            +'</div>';
            if(params.options.label_class) label_class = params.options.label_class;
            if(params.options.input_class) input_class = params.options.input_class;
            if(params.options.wrapper_class) wrapper_class = params.options.wrapper_class;
            var inplist = params.inputs;
            for (const name in inplist) {
                if (inplist.hasOwnProperty(name)) {
                    const inp = inplist[name];
                    if(!inp.name) inp.name = name;
                    if(!inp.type) inp.type = "text";
                    let events = {};
                    let $inp = '';
                    let tagName = '';
                    let label = inp.label?inp.label:inp.name;
                    if(!inp.placeholder) inp.placeholder = label;
                    let id = inp.id?inp.id:inp.name;
                    let type = inp.type.toLowerCase();
                    let props = '';
                    let inp_class = "";
                    var value = (typeof inp.value != "undefined" && inp.value !== null && (inp.value || (""+inp.value).length))?inp.value:((typeof inp.defaultValue != "undefined" && (inp.defaultValue || inp.defaultValue.length))?inp.defaultValue:'');
                    let append = '';
                    let prepend = '';
                    if(type == 'file'){
                        inp_class += ' custom-file-input';
                    }
                    for (const prop in inp) {
                        if (inp.hasOwnProperty(prop)) {
                            const val = inp[prop];
                            let p = prop.toLowerCase();
                            const tv = App.getType(val);
                            if(p != 'type' && p != 'append' && p != 'prepend' && p != 'value' && p != 'label' && (tv == 'string' || tv == 'number')){
                                let vp = App.str.htmlentities(val);
                                if(p=='classname') p = 'class';
                                if(p=='class') {
                                    vp = '{$input_class} '+vp;
                                    inp_class += vp;
                                }
                                props += ' '+prop+'="'+vp+'"';
                            }
                            else if(p == 'validate'){
                                this.addPopupRule(inp.name, val);
                            }
                            else if(p == 'append'){
                                append = val;
                            }
                            else if(p == 'prepend'){
                                prepend = val;
                            }
                            else if(prop.substr(0, 1) == '@'){
                                if(tv == 'function'){
                                    events[p.substr(1)] = val;
                                }else if(App.func.check(val)){
                                    events[p.substr(1)] = function(e){
                                        App.func.call(val,[e]);
                                    }
                                }
                            }
                        }
                    }

                    if(inp_class!=""){
                        input_class = type == 'file'? inp_class : input_class;
                    }
                    props+=' class="{$input_class}"';

                    if(type == 'textarea') $inp = '<'+type+props+'>'+(value)+'</'+type+'>';
                    else if(type == 'select'){
                        let opts = '';
                        let data = inp.data || inp.options || {};
                        if(App.getType(data) == "object"){
                            for (const v in data) {
                                if (data.hasOwnProperty(v)) {
                                    let text = data[v];
                                    opts += '<option value="'+v+'" '+(v == value ? 'selected':'')+'>'+text+'</option>';
                                }
                            }
                        }
                        $inp = '<'+type+props+'>'+(opts)+'</'+type+'>';
                    }
                    
                    else if(type=='file'){
                        $inp = '<div class="custom-file">' +
                            '<input type="file" '+props+' data-on-change="App.modal.onPopupFile">' +
                            '<label class="custom-file-label" for="'+id+'">'+(value.length?App.str.htmlentities(value):'Chọn file')+'</label>' +
                        '</div>';
                    }
                    else{
                        $inp = '<input type="'+type+'"'+props+' value="'+App.str.htmlentities(value)+'">';
                    }

                    if(append || prepend){
                        $inp = '<div class="input-group">' + $inp;
                        if(prepend){
                            $inp = '<div class="input-group-prepend">'+prepend+'</div>' + $inp;
                        }
                        if(append){
                            $inp+= '<div class="input-group-append">'+append+'</div>';
                        }
                        $inp += '</div>';
                    }
                    
                    if(type == "hidden"){
                        html+= App.str.eval($inp, {input_class:input_class});
                    }
                    else{
                        html+=App.str.eval(formGroup, {
                            label_class: label_class + " col-form-label",
                            input_class:input_class,
                            wrapper_class:wrapper_class,
                            label:label,
                            id:id,
                            input:App.str.eval($inp, {input_class:input_class})
                        });
                    }
                    

                }
            }
            let $popup = $('#popup-modal');
            $popup.find('.modal-header .modal-title span').html(params.title);
            $popup.find('.modal-body').html(html);
            $popup.find('.modal-footer .btn-done').html(params.btnDone);
            $popup.find('.modal-footer .btn-cancel').html(params.btnCancel);
            if (options.size) {
                $('#popup-modal .modal-dialog').removeClass().addClass('modal-dialog modal-' + options.size);
            }
            
            this.show('popup-modal', showCallback, hideCallback);
            
        }
    },
    popupDone:function(formData){
        var self = this;
        var errors = [];
        var data = {};
        var $popup = $('#popup-modal');
        let inputs = self.popupData.inputs;
        if(formData.length){
            formData.map(function (e) {
                let name = e.name;
                let value = e.value;
                let input = inputs[name];
                if(typeof self.popupData.validate == 'object' && typeof self.popupData.validate[name] == 'function'){
                    let validate = self.popupData.validate[name];
                    if(validate(value)){
                        data[name] = value;
                    }else{
                        errors[errors.length] = input.label + " Không hợp lệ";
                    }
                }
                else{
                    data[name] = value;
                }
            });
            if(errors.length){
                self.error(errors.join("<br>"), function(){
                    self.hide_callback = function() {
                        self.show('popup-modal');
                    };
                });
            }else{
                self.hide('popup-modal', function(){
                    self.popupData.done(data);
                });
                
            }
        }
    },
    addPopupRule: function(name, rule){
        if(typeof rule != "function") return false;
        if(typeof this.popupData.validate == "undefined"){
            this.popupData.validate = {};
        }
        this.popupData.validate[name] = rule;
        return this;

    },
    onPopupFile: function(input, list){
        this.popupFiles[input.name] = list;
    },
    last: function () {
        if(this.last_open){
            this.show(this.last_open);
        }
    }
}; 







$(function() {


    if ($('.modal').length > 0) {
        $('#confirm-modal .btn-confirm-answer').on("click", function() {
            var $this = $(this);
            App.modal.hide('confirm-modal');
            if ($this.hasClass('yes')) {
                App.modal.answer(true);
            } else {
                App.modal.answer(false);
            }
        });

        $('#popup-modal #crazy-popup-form').on("submit",function(e) {
            e.preventDefault();
            var data = $(this).serializeArray();
            var files = $(this).find('input[type="file"]');
            
            if(files.length){
                for (let i = 0; i < files.length; i++) {
                    const inp = files[i];
                    if(typeof App.modal.popupFiles[inp.name] != "undefined"){
                        data.push({
                            name: inp.name,
                            value: App.modal.popupFiles[inp.name]
                        })
                    }
                }
            }
            App.modal.popupDone(data);
            return false;
        });

        $('.modal').on('hidden.bs.modal', function() {
            App.modal.is_on = false;
            var $this = this;
            setTimeout(function(){
                if (typeof App.modal.hide_callback == 'function') {
                    App.modal.hide_callback($this, App.modal);
                }
                
                App.modal.last_open = App.modal.current_open;
                App.modal.current_open = null;
            
                App.modal.hide_callback = null;
            }, 200);
        

        });
        $('.modal').on('show.bs.modal', function(e) {
            var $this = this;
            App.modal.is_on = true;
            
            setTimeout(function(){
                App.modal.current_open = $($this).attr('id');
                if (typeof App.modal.show_callback == 'function') {
                    App.modal.show_callback($this, App.modal);
                }
                App.modal.show_callback = null;
            }, 200);
            
        });
    }
});