var CrazySelect = function (selector, template) {
    this.$el = $(selector);
    this.template = template;
    this.searchUrl = '';
    this.addUrl = '';
    this.advanceHandler = '';
    this.addData = {};
    this.addField = 'name';
    this.searchField = 'search';
    this.keywords = '';
    this.hiddenKeywords = '';
    this.type = 'static';
    this.oldValue = '';
    this.hasDefault = false;
    this.activeValue = '';
    this.activeText = '';
    this.$menu = this.$el.find('.select-option-menu');
    this.$message = this.$menu.find('.message');
    this.$buttons = this.$menu.find('.buttons');
    this.$options = this.$menu.find('.option-list');
    this.$text = this.$el.find('.show-text-value');
    this.$select = this.$el.find('.btn-dropdown-select');
    this.$input = $('#' + this.$el.data('id'));
    this.$searchBlock = this.$el.find('.search-block');
    this.$searchInput = this.$el.find('input');
    this.searchParamSelectors = this.$el.data('search-params') || '';

    this.confirmChange = false;
    var self = this;
    this.init = function () {
        var $el = this.$el;
        let selectType = $el.data('select-type') || 'static';
        this.type = selectType;

        let cc = $el.data('confirm-change') || "";
        if (cc && cc != "false") {
            this.confirmChange = true;
        }
        if (selectType == 'static') {
            let itemCount = $el.find('.option-item').length;
            let disableSearch = $el.data('disable-search') || null;
            if (disableSearch && disableSearch != 'false') {
                this.$searchBlock.hide();
            }
            else if (itemCount > 10) {
                this.$searchBlock.show();

            } else if (itemCount > 0) {
                this.$searchBlock.hide();
            } else {
                this.$searchBlock.hide();
                // $el.find('.message').show();
            }


        }// end if type == 'static'
        else if (selectType == 'search') {
            if ($el.data('search-field')) {
                this.searchField = $el.data('search-field');
            }
            if ($el.data('search-url')) {
                this.searchUrl = $el.data('search-url');
            }
        }
        else if (selectType == 'dynamic') {
            if ($el.data('search-field')) {
                this.searchField = $el.data('search-field');
            }
            if ($el.data('search-url')) {
                this.searchUrl = $el.data('search-url');
            }
            this.advanceHandler = $el.data('advance-click') || cl;
        }
        // end if selectType == 'search'

        this.parseMultiLevelText();
        // tim kiếm
        $el.children('.select-option-menu').on('keyup mouseup', function (e) {
            var el = e.target;
            var tag = el.tagName.toLowerCase();
            if (tag == 'input' && el.getAttribute('data-name') == 'search_options') {
                let keywords = el.value;
                var text = el.value.toLocaleLowerCase();
                if (text == self.keywords.toLocaleLowerCase()) return;
                self.keywords = keywords;
                if (selectType == 'static') {
                    self.staticSearch(text);
                } else if (selectType == 'search' || selectType == 'dynamic') {
                    self.ajaxSearch(text);
                }
            }
        });


        $(document).on('click', function (e) {
            var $e = $(e.target);
            if (!$e.closest(self.$el).length) {
                self.hide();
            } else {
                if ($e.is(self.$select) || $e.closest(self.$select).length) {
                    self.toggle();
                } 
                else if($e.is('.search-block') || $e.closest('.search-block').length){
                    // không lam gì cả
                    // có thể làm ngược lại nhưng ko thích
                }
                else {
                    let $item = [];
                    $elm = $e.closest('.select-option-item');
                    if ($e.hasClass('select-option-item')) {
                        $item = $e;
                    } else if ($elm.length) {
                        $item = $elm;
                    }
                    if ($item.length) {
                        var value = $item.data('value');
                        let isl = self.$input;
                        let old = isl.val();
                        if (value != old) {
                            const changeValue = function () {
                                var text = $item.data('text');
                                let datadisable = self.$el.data('disable') || null;
                                if (!datadisable || datadisable == 'false') {
                                    self.$text.html(text);
                                    self.$text.val(value);
                                    isl.val(value);
                                    $el.find('.select-option-menu').find('.option-item').removeClass('active');
                                    $item.addClass('active');
                                    self.parseMultiLevelText();
                                }
                                var onc = $el.data('changed-callback') || $el.data('on-change');
                                if (onc) {
                                    let oncbs = onc.split(',');
                                    if (oncbs.length > 1) {
                                        oncbs.forEach(element => {
                                            let func = element.trim();
                                            if (App.func.check(func)) {
                                                App.func.call(func, [value, text, e.target]);
                                            }
                                        });
                                    }
                                    else if (App.func.check(onc)) {
                                        App.func.call(onc, [value, text, e.target]);
                                    }
                                }
                            };
                            if (self.confirmChange) {
                                let message = self.$el.data('confirm-message') || "Thay đổi giá trị trường này có thể gây sáo trộn hoặc mất dữ liệu một số trường khác.>br>Bạn có muốn thực hiện thay đổi?";
                                App.popup.confirm(message, function (agree) {
                                    if (agree) {
                                        changeValue();
                                        self.hide();
                                    }
                                })
                            } else {
                                changeValue();
                                self.hide();
                            }
                        }else{
                            self.hide();
                        }
                    }
                }
            }
        });

        // this.$el.on('click', '.btn-dropdown-select', function (e) {
        //     self.toggle();
        // });
    };

    this.show = function () {
        if (!this.$el.hasClass('show')) {
            this.$el.addClass('show');
        }
        return this;
    }
    this.hide = function () {
        this.$el.removeClass('show');
        return this;
    };
    this.toggle = function () {
        if (!this.$el.hasClass('show')) {
            this.$el.addClass('show');
        } else {
            this.$el.removeClass('show');
        }
        return this;
    };


    
    /**
     * tim kiem trong danh saxh
     * @param {string} keyword Từ khóa tim kiếm
     * @return {void}
     */
    this.staticSearch = function (keyword){
        var cc = 0;
        var $options = self.$el.children('.select-option-menu');
        var k = App.str.clearUnicode(keyword);
        keyword = k.toLocaleLowerCase();
        var kws = keyword.split(',');
        var keywords = [];
        kws.map(function(kw, ind){
            let k = kw.trim();
            if(k!=='' && k!==' '){
                keywords.push(k);
            }
        });
        $options.find('.option-list .option-item').removeClass('found').removeClass('hidden-item');
        $options.find('.option-list>.option-item').each(function (ind, elem) {
            if(keywords.length){
                let isSearch = false;
                keywords.forEach(text => {
                    if(!isSearch){
                        if(App.str.clearUnicode($(elem).data('text') + "").toLowerCase().split(text).length>1 || App.str.clearUnicode($(elem).data('value') + "").toLowerCase().split(text).length>1){
                            $(elem).show();
                            $(elem).addClass('found');
                            cc++;
                            isSearch = true;
                        }else{
                            $(elem).hide();
                        }
                    }
                });

                if(!isSearch){
                    $(elem).addClass('hidden-item');
                }
            }
            else if(App.str.clearUnicode($(elem).data('text') + "").toLowerCase().split(keyword).length>1 || App.str.clearUnicode($(elem).data('value')).toLowerCase().split(keyword).length>1){
                $(elem).show();
                $(elem).addClass('found');
                cc++;
            }else{
                $(elem).hide();
                $(elem).addClass('hidden-item');
            }
        });

        var checkGroup = function(group, callback){
            var s = false;
            var $selectHeader = $(group).children('.select-option-header');
            if($selectHeader.length){
                if(keywords.length){
                    let isSearch = false;
                    keywords.forEach(text => {
                        if(!isSearch){
                            if(App.str.clearUnicode($($selectHeader[0]).data('text')).toLowerCase().split(text).length>1 || App.str.clearUnicode($($selectHeader[0]).data('value')).toLowerCase().split(text).length>1){
                                $(group).find('.option-group').show();
                                $(group).find('.option-item').show();
                                $(group).find('.option-item').addClass('found');
                                isSearch = true;
                                s = true;
                            }
                        }
                    });
                }
                else if(App.str.clearUnicode($($selectHeader[0]).data('text')).toLowerCase().split(keyword).length>1 || App.str.clearUnicode($($selectHeader[0]).data('value')).toLowerCase().split(keyword).length>1){
                    s = true;
                    $(group).find('.option-group').show();
                    $(group).find('.option-item').show();
                    $(group).find('.option-item').addClass('found');
                }
            }
            if(!s){
                $(group).children().each(function(ind, elm){
                    if($(elm).hasClass('option-item')){
                        if(keywords.length){
                            let isSearch = false;
                            keywords.forEach(text => {
                                if(!isSearch){
                                    if(App.str.clearUnicode($(elm).data('text')).toLowerCase().split(text).length>1 || App.str.clearUnicode($(elm).data('value')).toLowerCase().split(text).length>1){
                                        $(elm).show();
                                        $(elm).addClass('found');
                                        isSearch = true;
                                        s = true;
                                    }
                                }
                            });
                            if(!isSearch){
                                $(elm).hide();
                                $(elm).addClass('hidden-item');
                            }
                        }
                        else if(App.str.clearUnicode($(elm).data('text')).toLowerCase().split(keyword).length>1 || App.str.clearUnicode($(elm).data('value')).toLowerCase().split(keyword).length>1){
                            s = true;
                            $(elm).show();
                            $(elm).addClass('found');
                        }else{
                            $(elm).hide();
                            $(elm).addClass('hidden-item');
                        }
                        
                    }else if($(elm).hasClass('option-group')){
                        var a = callback(elm, callback);
                        if(a) s = a;
                    }
                });
                
            }
            if(s){
                $(group).show();
                $selectHeader.show();
                if($selectHeader.hasClass('option-item')){
                    $selectHeader.addClass('found');
                }
            }else{
                $(group).hide();
                $selectHeader.hide();
                if($selectHeader.hasClass('option-item')){
                    $selectHeader.addClass('hidden-item');
                }
            }
            return s;
        };

        $options.find('.option-list>.option-group').each(function (index, elem) {
            if(checkGroup(elem, checkGroup)) cc++;
        });

        if(!cc){
            self.hideLoader('Không có kết quả');
        }else{
            $options.find('.message').hide();
        }
    };

    /**
     * tim kiem bang ajax
     * @param {string} keyword Từ khóa tim kiếm
     * @return {void}
     */
    this.ajaxSearch = function(keyword, callback){
        var data = {};
        data[this.searchField] = keyword;
        var $el = self.$el;
        if(self.searchParamSelectors && $(self.searchParamSelectors).length){
            $(self.searchParamSelectors).each(function(i, ele){
                let $e = $(ele);
                if($e.attr('name')){
                    data[$e.attr('name')] = $e.val();
                }
            });
        }
        self.showLoader('Đang tìm kiếm...');
        self.$options.hide();
        self.$buttons.hide();
        
        App.ajax(this.searchUrl, {
            type: "GET",
            dataType: "json",
            data: data,
            cookie: true
        }).then(function(rs){
            if(rs.status){
                if(rs.data){
                    self.hideLoader();
                    // do something
                    self.$options.html(self.getSelectOptions(rs.data));
                    if(self.$options.children().length){
                        self.$message.hide();
                        self.$options.show();
                    }
                    if(!self.has(keyword) && keyword.length){
                        if(self.type == 'dynamic'){
                            self.$buttons.show();
                        }
                    }
                    if(typeof callback == "function"){
                        callback();
                    }
                }else{
                    self.hideLoader('Không có kết quả');
                    self.$options.hide();
                    if(self.type == 'dynamic'){
                        self.$buttons.show();
                    }
                }
            }else{
                self.hideLoader('Không có kết quả');
                self.$options.hide();
                if(self.type == 'dynamic'){
                    self.$buttons.show();
                }
            }
        }).catch(function (e) {
            self.hideLoader('Lỗi không xác định!');
            self.$options.hide();
        });
        
    };

    
    /**
     * tim kiem trong danh saxh
     * @param {string} keyword Từ khóa tim kiếm
     * @return {void}
     */
    this.has = function (keyword){
        keyword +="";
        var cc = 0;
        var $options = self.$el.children('.select-option-menu');
        keyword = App.str.clearUnicode(keyword).toLowerCase();
        var kws = keyword.split(',');
        var keywords = [];
        kws.map(function(kw, ind){
            let k = kw.trim();
            if(k!=='' && k!==' '){
                keywords.push(k);
            }
        });
        $options.find('.option-list>.option-item').each(function (ind, elem) {
            if(keywords.length){
                let isSearch = false;
                keywords.forEach(text => {
                    if(!isSearch){
                        if(App.str.clearUnicode($(elem).data('text')+"").toLowerCase() == text){
                            cc++;
                            isSearch = true;
                        }
                    }
                });
            }
            else if(App.str.clearUnicode($(elem).data('text')+"").toLowerCase() == keyword){
                cc++;
            }
        });

        var checkGroup = function(group, callback){
            var s = false;
            var $selectHeader = $(group).children('.select-option-header');
            if($selectHeader.length){
                if(keywords.length){
                    let isSearch = false;
                    keywords.forEach(text => {
                        if(!isSearch){
                            if(App.str.clearUnicode($($selectHeader[0]).data('text')+"").toLowerCase() == text){
                                isSearch = true;
                                s = true;
                            }
                        }
                    });
                }
                else if(App.str.clearUnicode($($selectHeader[0]).data('text')+"").toLowerCase() == keyword){
                    s = true;
                }
            }
            if(!s){
                $(group).children().each(function(ind, elm){
                    if($(elm).hasClass('option-item')){
                        if(keywords.length){
                            let isSearch = false;
                            keywords.forEach(text => {
                                if(!isSearch){
                                    if(App.str.clearUnicode($(elm).data('text')+"").toLowerCase() == text){
                                        isSearch = true;
                                        s = true;
                                    }
                                }
                            });
                        }
                        else if(App.str.clearUnicode($(elm).data('text')+"").toLowerCase() == keyword ){
                            s = true;
                        }
                        
                    }else if($(elm).hasClass('option-group')){
                        var a = callback(elm, callback);
                        if(a) s = a;
                    }
                });
                
            }
            return s;
        };

        $options.find('.option-list>.option-group').each(function (index, elem) {
            if(checkGroup(elem, checkGroup)) cc++;
        });

        return cc;
    };

    
    /**
     * kich hoat option
     * @param {string} value giá trị
     * @return {void}
     */
    this.active = function (value){
        var cc = 0;
        var $options = self.$el.children('.select-option-menu');
        value = App.str.clearUnicode(""+value).toLowerCase();
        $options.find('.option-list>.option-item').each(function (ind, elem) {
            if(App.str.clearUnicode($(elem).data('value')+"").toLowerCase() == value){
                self.deactive();
                self.changeText($(elem).data('text'));
                self.changeValue($(elem).data('value'));
                $(elem).addClass('active');
                cc++;
            }
        });
        if(cc){
            this.parseMultiLevelText();
        }
        if(cc) return true;

        var checkGroup = function(group, callback){
            var s = false;
            $(group).children().each(function(ind, elm){
                if($(elm).hasClass('option-item')){
                    if(App.str.clearUnicode($(elm).data('value')+"").toLowerCase() == value ){
                        self.deactive();
                        self.changeText($(elm).data('text'));
                        self.changeValue($(elm).data('value'));
                        $(elm).addClass('active');
                        s = true;
                    }
                    
                }else if($(elm).hasClass('option-group')){
                    var a = callback(elm, callback);
                    if(a) s = a;
                }
            });
            return s;
        };
        $options.find('.option-list>.option-group').each(function (index, elem) {
            if(checkGroup(elem, checkGroup)) cc++;
        });
        if(cc){
            this.parseMultiLevelText();
        }
        
        return cc;
    };


    this.disableSearch = function(){
        this.$searchBlock.hide();
    }
    this.enableSearch = function(){
        this.$searchBlock.show();
    }

    this.showLoader = function(message){
        self.$message.addClass('m-loader m-loader--success m-loader--right').show();
        if(message){
            self.$message.html(message);
        }
    };

    this.hideLoader = function(message){
        self.$message.removeClass('m-loader m-loader--success m-loader--right').hide();
        if(message){
            self.$message.html(message);
            self.$message.show();
        }
    }

    this.getSelectOptions = function(options, defaultVal, html, level, template)
    {
        var otype = App.getType(options);
        if(otype != 'object' && otype != 'array') return '';
        if(!html) html = '';
        var group_header = self.getOptionLabelType();
        if(!template) template = '<a href="javascript:void(0);" data-value="{$value}" data-text="{$hetext}" class="select-option-item option-item {$class} {$active}">{$text}</a>';
        //die($group_header);
        var df = defaultVal || null;

        for (const key in options) {
            let val = options[key];
            let t = App.getType(val);
            if(['object', 'array'].indexOf(t) >= 0){
                let opt = val;
                let lbl = key;
                
                if(t=='object' && (val.hasOwnProperty('label') || val.hasOwnProperty('text')) && (val.hasOwnProperty('data') || val.hasOwnProperty('list'))){
                    lbl = val.hasOwnProperty('label') ? val.label : val.text;
                    let isset = false;
                    if(val.hasOwnProperty('data')){
                        if(['array', 'object'].indexOf(App.getType(val.data))){
                            opt = val.data;
                            isset = true;
                        }
                    }
                    if(!isset && val.hasOwnProperty('list')){
                        if(['array', 'object'].indexOf(App.getType(val.list))){
                            opt = val.data;
                            isset = true;
                        }
                    }
                }


                html += '<div class="option-group">';
                if(key == df){
                    self.changeText(lbl);
                    self.hasDefault = true;
                    self.activeText = lbl;
                    self.activeValue = key;
                }
                if(group_header!='value'){
                    html += "<h6 class=\"select-option-header\">"+lbl+"</h6>";
                }else{
                    html += App.str.eval(template, {
                        value: key,
                        text: App.str.htmlentities(lbl),
                        hetext: App.str.htmlentities(lbl),
                        active: (df==key)?'active':'',
                        class: "select-option-header option-header"
                    });
                    
                }
                html = self.getSelectOptions(opt, df, html, level+1, template);
                    
                html += '</div>';
                
            }
            else{
                if(key == df){
                    self.changeText(val);
                    self.hasDefault = true;
                    self.activeText = val;
                    self.activeValue = key;
                }
                
                html += App.str.eval(template, {
                    value: key,
                    text: App.str.htmlentities(val),
                    hetext: App.str.htmlentities(val),
                    active: (df==key)?'active':'',
                    class: ""
                });
                
                
            }
        }
        return html;

    };

    this.getOptionLabelType = function ()
    {
        var group_label = 'header';
        var type = self.$el.data('label-type') || null;
        if(type && ['header','value','label'].indexOf(type) >-1 ){
            group_label = type;
        }
        return group_label;
    };

    
    this.parseMultiLevelText = function(){
        var $options = self.$el.children('.select-option-menu');
        var maxLevel = -1;
        var data = {};
        var items = $options.find('.option-list>.option-item.active');
        if(items.length){
            data[0] = $(items[0]).html();
            maxLevel = 0;
        }else{
            var checkGroup = function(group, callback, level){
                var s = false;
                var $selectHeader = $(group).children('.select-option-header');
                if($selectHeader.length){
                    if($($selectHeader[0]).hasClass('active')){
                        data[level] = $($selectHeader[0]).html();
                        if(level > maxLevel) maxLevel = level;
                        s = true;
                    }
                }
                if(!s){
                    $(group).children().each(function(ind, elm){
                        if($(elm).hasClass('option-item')){
                            if($(elm).hasClass('active')){
                                data[level+1] = $(elm).html();
                                s = true;
                                if(level+1 > maxLevel) maxLevel = level+1;
                            }
                        }else if($(elm).hasClass('option-group')){
                            var a = callback(elm, callback, level+1);
                            if(a) s = a;
                        }
                    });
                }
                if(s){
                    data[level] = $selectHeader.html();
                    if(level > maxLevel) maxLevel = level;
                }
                return s;
            };
    
            $options.find('.option-list>.option-group').each(function (index, elem) {
                var $header = $(elem).children('.select-option-header');
                if(checkGroup(elem, checkGroup, 0)) {
                    data[0] = $header.html();
                }
            });
    
        }
        var dataText = [];
        if(maxLevel>=0){
            for (let i = 0; i <= maxLevel; i++) {
                dataText[i] = data[i];
            }
            self.changeText(dataText.join(" / "));
        }
    };

    this.changeText = function(text){
        if(text){
            this.$text.html(text);
            this.$text.val(text);
            
        }
    };

    this.changeValue = function(value){
        var val = (typeof value != "undefined") ? value : '';
        this.$input.val(val);
    }



    this.changeOptions = function(options){
        self.changeText("Chọn một");
        let currentValue = self.$input.val();
        self.hasDefault = false;
        self.activeValue = '';
        self.activeText = "Chọn một";
        self.oldValue = self.$input.val();
        self.$input.val('');
        self.$options.html(self.getSelectOptions(options, self.oldValue));
        if(self.hasDefault){
            self.$input.val(self.activeValue);
            self.changeText(self.activeText);
        }
        self.hasDefault = false;
    
        self.showSearchBlock();
        this.parseMultiLevelText();
    };

    this.addOption = function(value, text){
        var type = App.getType(value);
        var options = {};
        if(type == 'object' || type == 'array'){
            this.deactive();
            self.$options.append(self.getSelectOptions(value, self.oldValue));
        }else{
            options[value] = text;
            this.deactive();
            self.$options.append(self.getSelectOptions(options, value));
            self.changeValue(value);
            self.changeText(text);

        }

        self.$options.show();
        self.$buttons.hide();
        self.$message.hide();
                    
    };

    this.deactive = function(){
        this.$el.find('.select-option-menu').find('.option-item').removeClass('active');
    };

    
    this.showSearchBlock = function(){
        if(self.type == 'static'){
            let itemCount = self.$el.find('.option-item').length;
            if(itemCount>10){
                self.$el.find('.search-block').show();
                
            }else if(itemCount>0){
                self.$el.find('.search-block').hide();
            }else{
                self.$el.find('.search-block').hide();
                // self.$el.find('.message').show();
            }

            
        }// end if type == 'static'
    };
    this.resetDefault = function(){
        let activeItem = this.$options.find('.option-item.active');
        
        if(activeItem.length && !activeItem.hasClass('hidden-item')){
            this.changeValue(activeItem.data('value'));
            this.changeText(activeItem.data('text'));
                    
            return true;
        }
        let foundItem = this.$options.find('.option-item');
        foundItem.removeClass('active');
        let status = false;
        if(foundItem.length){
            for (let index = 0; index < foundItem.length; index++) {
                const element = foundItem[index];
                if(!$(element).hasClass('hidden-item')){
                    this.changeValue($(element).data('value'));
                    this.changeText($(element).data('text'));
                    status = true;
                    break;
                }
                
            }
        }
        if(!status){
            this.changeValue('');
            this.changeText('-- Chọn một --');
            
        }
    };

    this.val = function(){
        return self.$input.val();
    };

};

App.dom.select = {
    list: {},
    add: function (selector) {
        var $el = $(selector);
        if ($el.length) {
            let $select = new CrazySelect($el[0]);
            $select.init();
            this.list[$el.data('id')] = $select;
        }
    },
    /**
     * lấy thẻ select
     * @param {string} id 
     * 
     * @return {CrazySelect}
     */
    getTag: function (id) {
        if (id) {
            if (typeof this.list[id] != "undefined") {
                return this.list[id];
            }
        }
        return null;
    },
    changeOptions: function (id, options) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].changeOptions(options);
        }
    },
    addOption: function (id, value, text) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].addOption(value, text);
        }
    },
    ajaxSearch: function (id, keywords, callback) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].ajaxSearch(keywords, callback);
        }
    },
    staticSearch: function (id, keywords) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].staticSearch(keywords);
        }
    },
    deactive: function (id) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].deactive();
        }
    },
    active: function (id, value) {
        if (typeof this.list[id] != "undefined") {
            this.list[id].active(value);
        }
    },
    getValue: function (id, defaultValue) {
        var val = !defaultValue ? null : defaultValue;
        if (typeof this.list[id] != "undefined") {
            val = this.list[id].val();
        }
        return val;
    }
};

var $cs = $('.crazy-select');
if ($cs.length) {
    $cs.each(function (i, el) {
        App.dom.select.add(el);
    });
}