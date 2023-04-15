$(function(){
    const AdminTheme = function(options) {
        this.el = null;
        this.urls = {};
        this.id = 0;
        this.current_theme = 0;
        this.templates = {item:"", list:""};
        this.btnClass = "btn-outline-info";
        this.btnActiveClass = "btn-info";
        this.btnText = "Kích hoạt";
        this.btnActiveText = "Đã kích hoạt";
        this.init_list = ["urls", "template", 'type', 'keywords', 'el', 'current_theme'];
        this.options = options;
        this.currentPage = 0;
        this.pageTotal = 0;
        this.resultTotal = 0;
        this.keywords = '';
        this.type = 'all';
        this.isLoading = false;
        var $el = null;
        var $seemore, $message, $buttons;
        var self = this;
        /**
         * init
         * @param {object} args 
         */
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        /**
         * khoi chay
         */
        this.onStart = () => {
            $el = $(this.el);
            var tplList = ["list", "item", "detail", "gallery"];
            for (let i = 0; i < tplList.length; i++) {
                const tplKey = tplList[i];
                let tpl = $('.theme-'+tplKey+'-template');
                self.templates[tplKey] = tpl.text();
                tpl.remove();    
            }
            
            $buttons = $el.find('.list-buttons');
            $seemore = $buttons.find('.btn-see-more');
            $message = $el.find('.list-message');
        
            $message.hide();

            
            $('#theme-tabs-list a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var $this = $(e.target) // newly activated tab
                // e.relatedTarget // previous active tab
                var type = $this.data('type');
                self.type = type;
                $('#search-theme-type').val(type);
                var $themeList = $el.find('.'+type+'-theme-list .theme-list-body');
                $themeList.html("");
                self.search();
            });

            $('#search-theme-input').on('input', function(){
                self.keywords = $(this).val();
                self.search();
            });

            $('#search-theme-form').submit(function(e){
                e.preventDefault();
                self.search();
                return false;
            });

            $seemore.on('click', function(){
                self.load();
                return false;
            });
            $(document).on('click', '.btn-active-theme', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                self.active(id);
            });

            $(document).on('click', '.theme-quick-view-btn', function (e) {
                e.preventDefault();
                self.detail($(this).data('id'));
                return false;
            });

            this.load();
        };

        this.active = id => {
            if(parseInt(id) == parseInt(self.current_theme)) return App.modal.alert("Theme đã được kích hoạt!");
            ajaxRequest(this.urls.active, "POST", {id:id}, rs => {
                if(rs.status){
                    self.current_theme = id;
                    $('.theme-list-body .theme-item .btn-active-theme')
                        .removeClass(self.btnActiveClass)
                        .addClass(self.btnClass)
                        .find('.btn-text')
                        .html(self.btnText);
                    $('#theme-item-'+id+' .theme-item .btn-active-theme')
                        .removeClass(self.btnClass)
                        .addClass(self.btnActiveClass)
                        .find('.btn-text')
                        .html(self.btnActiveText);
                    App.modal.alert("Đã kích hoạt thành công!");
                }
            })
        };

        /**
         * search
         */
        this.search = (keywords, type) => {
            if(this.keywords == keywords) return false;
            if(typeof keywords == "undefined") keywords = this.keywords;
            if(typeof type == "undefined") type = this.type;
            if(type == 'all') type = '';
            this.currentPage = 0;
            this.pageTotal = 0;
            this.resultTotal = 0;
            this.load(keywords, type, 1);
        };

        this.load = (keywords, type, page) => {
            if((this.resultTotal > 0 && this.pageTotal > 0 && this.currentPage >= this.pageTotal) || this.isLoading) {
                return;
            }
            self.isLoading = true;
            $seemore.prop('disabled', true);
            $seemore.addClass('m-loader m-loader--light m-loader--right');
            $buttons.show();
            $message.hide();
            var afterLoad = function(){
                self.isLoading = false;
                $seemore.prop('disabled', false);
                $seemore.removeClass('m-loader m-loader--light m-loader--right');    
            };
            
            if(typeof keywords == "undefined") keywords = this.keywords;
            if(typeof type == "undefined") type = this.type;
            if(!page) page = this.currentPage+1;
            if(type == 'all') type = '';
            var data = {keywords:keywords, type:type, page:page};            
            ajaxRequest(this.urls.search, "GET", data, function(rs){
                setTimeout(function(){
                    afterLoad();
                    self.showResults(rs);
                }, App.number.rand(200, 1000));

            }, function (err) {
                afterLoad();
            });
        };

        this.showResults = (rs) => {
            var type = this.type;
            var $themeList = $el.find('.'+type+'-theme-list .theme-list-body');
            if(rs.status){
                if(rs.data && rs.data.length){
                    self.pageTotal = rs.page_total;
                    self.currentPage = rs.page;
                    self.resultTotal = rs.count;
                    var html = '';
                    for (const key in rs.data) {
                        if (rs.data.hasOwnProperty(key)) {
                            let theme = rs.data[key];
                            theme.btn_class = (self.current_theme == theme.id) ? self.btnActiveClass : self.btnClass;
                            theme.btn_text = (self.current_theme == theme.id) ? "Đã kích hoạt" : 'Kích hoạt';
                            
                            html += App.str.eval(self.templates.item, theme);
                        }
                    }
                    
                    if(self.currentPage > 1){
                        $themeList.append(html);
                    }else{
                        $themeList.html(html);
                    }
                    if(self.currentPage == self.pageTotal || !self.pageTotal){
                        $buttons.hide();
                    }else{
                        $buttons.show();
                    }
                    $message.hide();
                }else{
                    if(!self.currentPage || !self.pageTotal){
                        $themeList.html("");
                        $message.show();
                    }
                    else{
                        $message.hide();
                    }
                    
                    $buttons.hide();
                    
                }
            }else if(!self.currentPage || !self.pageTotal){
                $themeList.html("");
                $message.show();
            }
        };

        this.detail = id => {
            ajaxRequest(this.urls.detail, "GET", {id:id}, (rs) => {
                if(rs.status){
                    var data = rs.data;
                    self.id = data.id;
                    data.gallery_html = self.renderGallery(data.gallery);
                    var html = App.str.eval(self.templates.detail, data);
                    App.modal.custom({
                        title:rs.data.name,
                        content:html,
                        size: "md",
                        buttons:[
                            {
                                type: "button",
                                class: "btn btn-info",
                                text:self.current_theme == data.id ? self.btnActiveText : self.btnText,
                                click: function () {
                                    App.modal.hide();
                                    self.active(id);

                                }
                            }
                        ]
                    });
                }
            }, (err) => {
                App.modal.error("Lỗi không xác định!");
            });
        };

        this.renderGallery = gallery => {
            var html = '';
            if(gallery){
                var type = typeof gallery;
                if((type == 'array' || type == 'object') && gallery.length){
                    html+='<div class="col-12">'
                    +'<h4>Thư viện ảnh</h4>'
                    +'<div class="row">';
                        
                    for (const key in gallery) {
                        if (gallery.hasOwnProperty(key)) {
                            const image = gallery[key];
                            html+=App.str.eval(self.templates.gallery, {src:image});
                        }
                    }
                    html += '</div></div>';
                }
            }
            return html;
        };
    };

    
    
    let options = {};
    if(typeof theme_data == 'object'){
        options = theme_data;
    }
    let themes = new AdminTheme(options);
    option = {};
    themes.init();
    App.themes = themes;

});
