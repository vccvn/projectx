$(function(){
    const MyTheme = function(options) {
        this.el = null;
        this.urls = {};
        this.id = 0;
        this.current_theme = 0;
        this.templates = {item:"", list:"", available:"", pending:"", delete:""};
        this.btnClass = "btn-outline-info";
        this.btnActiveClass = "btn-info";
        this.btnText = "Kích hoạt";
        this.btnActiveText = "Đã kích hoạt";
        this.init_list = ["urls", "template", 'tab', 'keywords', 'el', 'current_theme', "available", "pending"];
        this.options = options;
        this.currentPage = 0;
        this.pageTotal = 0;
        this.resultTotal = 0;
        this.keywords = '';
        this.tab = 'all';
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
            var tplList = ["list", "item", "detail", "gallery", "available", "pending", "delete"];
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
                var tab = $this.data('tab');
                if(tab!='upload'){
                    self.tab = tab;
                    $('#search-theme-tab').val(tab);
                    var $themeList = $el.find('.'+tab+'-theme-list .theme-list-body');
                    $themeList.html("");
                    self.search();
                }
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
            $(document).on('click', '.btn-delete-theme', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                self.delete(id);
            });



            $(document).on('click', '.theme-quick-view-btn', function (e) {
                e.preventDefault();
                self.detail($(this).data('id'));
                return false;
            });

            this.load();
        };

        this.active = id => {
            if(parseInt(id) == parseInt(self.current_theme)) return App.Swal.alert("Theme đã được kích hoạt!");
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
                    App.Swal.alert("Đã kích hoạt thành công!");
                }
            })
        };

        /**
         * search
         */
        this.search = (keywords, tab) => {
            if(this.keywords == keywords) return false;
            if(typeof keywords == "undefined") keywords = this.keywords;
            if(typeof tab == "undefined") tab = this.tab;
            if(tab == 'all') tab = '';
            this.currentPage = 0;
            this.pageTotal = 0;
            this.resultTotal = 0;
            this.load(keywords, tab, 1);
        };

        this.load = (keywords, tab, page) => {
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
            if(typeof tab == "undefined") tab = this.tab;
            if(!page) page = this.currentPage+1;
            if(tab == 'all') tab = '';
            var data = {keywords:keywords, tab:tab, page:page};
            App.api.get(this.urls.search, data)
            .then(rs => {
                setTimeout(function(){
                    afterLoad();
                    self.showResults(rs);
                }, App.number.rand(200, 1000));
            })
            .catch( e => afterLoad(e));
        };

        this.showResults = (rs) => {
            var tab = this.tab;
            var $themeList = $el.find('.'+tab+'-theme-list .theme-list-body');
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
                            let tool = '';
                            if(theme.available){
                                tool = App.str.eval(self.templates.available, theme);
                            }else{
                                tool = App.str.eval(self.templates.pending, theme);
                            }
                            if(!theme.available || theme.privacy == "protected"){
                                tool += App.str.eval(self.templates.delete, theme);
                            }
                            theme.tool = tool;
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
                    data.tab_text = data.ref_text;
                    data.gallery_html = self.renderGallery(data.gallery);
                    var html = App.str.eval(self.templates.detail, data);
                    let bns = [];
                    if(data.available){
                        btns = [
                            {
                                type: "button",
                                class: "btn btn-info",
                                text:self.current_theme == data.id ? self.btnActiveText : self.btnText,
                                click: function () {
                                    App.modal.hide();
                                    self.active(id);

                                }
                            }
                        ];
                    }
                    App.modal.custom({
                        title:data.name,
                        content:html,
                        size: "md",
                        buttons:bns
                    });
                }
            }, (err) => {
                App.Swal.error("Lỗi không xác định!");
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


        this.delete = id => {
            App.Swal.confirm("bạn có chắc chắn muốn xóa item này?", function(){

                    ajaxRequest(self.urls.delete, "POST", {id:id}, function(rs){
                        if(rs.status){
                            if(rs.data.length){
                                for (let i = 0; i < rs.data.length; i++) {
                                    const rmid = rs.data[i];
                                    $('#theme-item-' + rmid).hide(400, function() {
                                        $(this).remove();
                                    });
                                }
                            }
                        }else{
                            App.Swal.error(rs.message);
                        }
                    }, function(err){
                        App.Swal.error("Lỗi không xác định!");
                    });

            });
        };

    };



    let options = {};
    if(typeof theme_data == 'object'){
        options = theme_data;
    }
    let themes = new MyTheme(options);
    option = {};
    themes.init();
    App.mythemes = themes;

});
