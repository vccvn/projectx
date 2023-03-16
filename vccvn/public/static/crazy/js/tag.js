function InputTag(selector) {
    this.$el = $(selector);
    this.$hidden = this.$el.find('.hidden-input-group');
    this.$tagListGroup = this.$el.find('.tag-list-group');
    this.$tagList = this.$el.find('.tag-list-group .tag-list');
    this.$searchGroup = this.$el.find('.input-search-group');
    this.$search = this.$searchGroup.find('.input-search');
    this.$searchBlock = this.$el.find('.live-search-block');
    this.$searchResults = this.$searchBlock.find('.live-search-results');
    this.$searchMessage = this.$searchBlock.find('.live-search-message');
    this.$searchAdvance = this.$searchBlock.find('.live-search-advance');
    this.$searchLoading = this.$searchBlock.find('.live-search-loading');
    this.$textWidth = this.$el.find('.crazy-text-width');
    this.$btnCreateTags = this.$searchAdvance.find('.btn-create-tags');

    this.type = this.$el.data('type') || 'default';
    this.valueKey = this.$el.data('value-key') || 'id';
    this.textKey = this.$el.data('text-key') || 'name';
    this.searchUrl = this.$el.data('search-url') || '';
    this.createUrl = this.$el.data('create-url') || '';
    this.createField = this.$el.data('create-field') || 'name';
    this.searchField = this.$el.data('search-field') || 'search';
    this.searchParams = this.$el.data('search-params') || null;
    this.addCallback = this.$el.data('add-callback') || this.$el.data('on-add');
    this.removeCallback = this.$el.data('remove-callback') || this.$el.data('on-remove');
    this.createCallback = this.$el.data('create-callback') || this.$el.data('on-create');
    this.isDynamic = this.$el.data('type') == 'dynamic' || this.$el.hasClass('dynamic');
    this.keyword = '';
    this.isShowing = false;
    this.data = {};
    var self = this;

    // thiết lập
    this.init = function () {
        let formdataEl = this.$el.find('.form-data');
        if (formdataEl.length) {
            let fdd = formdataEl.html();
            if (fdd) {
                let data = JSON.parse(fdd);
                if (data) {
                    this.data = data;
                }
            }
            formdataEl.remove();
        }
        // bat su kien click de tat live search
        $(document).on('click', function (event) {
            var $e = $(event.target);
            var $item = self.$tagList.find('.tag-item');
            // nếu click vào item 
            if ($e.closest($item).length) {
                self.hideSearchBlock();
            }

            // click vào kq tk
            else if ($e.closest(self.$searchResults).length) {

                var value = $e.data('value');
                var text = $e.data('text');
                self.addItem(value, text);

                var onc = self.addCallback;
                if (onc) {
                    var fn = new App.fn();
                    if (fn.check(onc)) {
                        fn.call(onc, [value, text, $e]);
                    }
                }

                if (!self.$searchResults.find('.search-result-item').length) {
                    self.showMessage("Hết danh sách");
                    self.$searchResults.hide();
                    self.$search.val('');
                    setTimeout(function () {
                        self.hideSearchBlock();
                    }, 2000);
                }
            }

            // click vào nút thêm
            else if ($e.is(self.$btnCreateTags) || $e.closest(self.$btnCreateTags).length) {
                self.createTags();
            }

            // click linh tinh trong phạm vi khung tag
            else if ($e.closest(self.$el).length || $e.closest(self.$tagListGroup).length) {
                self.focus();
            }

            // click ngoai khung tag
            else {
                self.hideSearchBlock();
            }
        });

        self.$search.on('keyup change mouseup', function () {
            // do some thing
            if (self.$search.val().length) {
                self.search(self.$search.val());
            }
            else {
                self.keyword = '';
                self.hideSearchBlock();
            }
            self.resizeSearchField();
        });

        // remove
        self.$tagList.on('click', '.tag-item .btn-delete', function (e) {
            var $btn = $(e.target);
            var value = $btn.data('value');
            var text = $btn.data('text') || '';

            self.$el.find('.crazy-tag-item-' + value).hide(300, function () {
                var onc = self.removeCallback;
                if (onc) {
                    var fn = new App.fn();
                    if (fn.check(onc)) {
                        fn.call(onc, [value, text, $btn]);
                    }
                }
                $(this).remove();
                self.$el.find('.crazy-tag-input-' + value).remove();
            });
        });

    };

    this.addItem = function (id, name) {
        if (this.exists(id, name)) return false;
        var inp_name = self.$el.data('name') || "name";
        if (inp_name.substr(inp_name.length - 2, 2) != '[]') inp_name = inp_name + "[]";
        self.$hidden.append("<input type=\"hidden\" name=\"" + inp_name + "\" value=\"" + id + "\" class=\"crazy-tag-input-" + id + "\">");
        self.$searchGroup.before("<li class=\"tag-item crazy-tag-item-" + id + "\" data-id=\"" + id + "\" data-name=\"" + name + "\"><div class=\"flex-center\"><span>" + name + "</span> <a href=\"javascript:;\" class=\"btn-delete\" data-value=\"" + id + "\">x</a></div></li>");
        self.$searchResults.find('.search-item-' + id).remove();
        if (name.toLocaleLowerCase() == self.keyword.toLocaleLowerCase()) self.$search.val('');
    }

    this.exists = function (id, name) {
        var stt = false;
        var $items = this.$tagList.find('.tag-item');

        if ($items.length) {
            // var nm = name.toLocaleLowerCase();
            $items.each(function (i, item) {
                if ($(item).data('id') == id) {
                    stt = true;
                }
            });
        }
        return stt;
    };


    this.focus = function () {
        self.$search.focus();
        if (self.$search.val() !== '') {
            self.showResults();
        } else {
            self.hideSearchBlock();
        }
    };

    this.search = function (keyword) {
        if (keyword != self.keyword) {
            self.keyword = keyword;
            setTimeout(function () {
                if (!self.keyword.length) return false;
                self.ajaxSearch(keyword);

            }, 200);
        }
    };
    this.ajaxSearch = function (keyword) {
        this.hideAll();
        var data = {};
        data[self.searchField] = keyword;
        var inputs = self.$hidden.find('input');
        if (inputs.length) {
            var ignore = [];
            inputs.each(function (i, e) {
                ignore[ignore.length] = $(e).val();
            });
            data.ignore = ignore;
        }
        if (self.searchParams) {
            let params = $(self.searchParams);
            if (params.length) {
                $.each(params, function (indexInArray, valueOfElement) {
                    data[$(valueOfElement).attr('name')] = $(valueOfElement).val();
                });
            }
        }
        this.showLoading();
        App.api.get(self.searchUrl, data).then(function (rs) {
            self.hideLoading();
            if (keyword != self.keyword) return false;
            var keyword_lower = String(keyword).toLocaleLowerCase();
            if (rs.status) {
                if (rs.data) {
                    var results = '';
                    var t = false;
                    for (const index in rs.data) {
                        if (rs.data.hasOwnProperty(index)) {
                            const tag = rs.data[index];
                            const value = tag[self.valueKey];
                            const text = tag[self.textKey];

                            if (!self.exists(value, text)) {
                                results += "<a href=\"javascript:;\" class=\"nav-link search-result-item search-item-" + value + "\" data-value=\"" + value + "\" data-text=\"" + App.str.htmlentities(text) + "\">" + App.str.htmlentities(text) + "</a>";
                            }
                            if (String(text).toLocaleLowerCase() == keyword_lower) t = true;
                        }
                    }
                    self.showResults(results);
                    if (!self.exists(0, keyword) && self.isDynamic && !t) {
                        self.showAdvance(keyword);
                    }
                } else {
                    self.showMessage("Không có kết quả");
                    self.showAdvance(keyword);

                }
            } else {
                self.showMessage("Không có kết quả");
                self.showAdvance(keyword);
            }
        }).catch(function (e) {
            self.hideLoading();
            self.showMessage("Lỗi không xác định");
            self.showAdvance(keyword);
        });
    };

    this.createTags = function () {
        if (!self.keyword) return false;
        this.hideAll();
        var data = this.data;
        data[self.createField] = self.keyword;
        this.showLoading();
        ajaxRequest(self.createUrl, "POST", data, function (rs) {
            if (rs.status) {
                if (rs.data) {
                    let data = rs.data;
                    if (App.getType(rs.data) == 'object') data = [rs.data];
                    for (const tag of data) {
                        self.addItem(tag[self.valueKey], tag[self.textKey]);
                    }
                }
            }
            else {
                if (rs.errors) {
                    let messages = [];
                    for (const key in rs.errors) {
                        if (object.hasOwnProperty(key)) {
                            const element = rs.errors[key];
                            messages.push(element);
                        }
                    }
                    App.modal.error(messages.join('<br />'));
                } else {
                    App.modal.error(rs.message);
                }
            }
            self.hideAll();
            self.hideSearchBlock();
            self.$search.val('');
        });

    };
    this.resizeSearchField = function () {
        var str = self.$search.val();
        if (str.length > 20) {
            self.$textWidth.html(str);
            // cl(self.$textWidth.width());
            self.$search.css('width', (self.$textWidth.width() + 50) + 'px');
        } else {
            self.$search.css('width', '160px');
        }
    };

    this.showSearchBlock = function () {
        if (self.isShowing) return;
        self.isShowing = true;
        self.$searchBlock.slideDown(200);
    };

    this.hideSearchBlock = function () {
        if (!self.isShowing) return;
        self.isShowing = false;
        self.$searchBlock.slideUp(200);
    };

    this.showResults = function (results) {
        if (results) {
            self.$searchResults.html(results);
        }
        self.showSearchBlock();
        self.hideLoading();
        if (!self.$searchResults.find('.search-result-item').length) {
            self.showMessage("Không có kết quả");
            self.$searchResults.hide();
        } else {
            self.$searchResults.show();
            self.hideMessage();

        }

    };
    this.hideResults = function () {
        self.$searchResults.hide();
    };


    this.showMessage = function (message) {
        if (message) {
            self.$searchMessage.html(message);
        }
        self.showSearchBlock();
        // self.hideAll();
        self.$searchMessage.show();

    };
    this.hideMessage = function () {
        self.$searchMessage.hide();
    };
    this.showAdvance = function (keyword) {
        if (!self.isDynamic) return false;
        self.showSearchBlock();
        // self.hideAll();
        self.$searchAdvance.find('.keyword').html(keyword);
        self.$searchAdvance.show();
    };
    this.hideAdvance = function () {
        self.$searchAdvance.hide();
    };
    this.showLoading = function (keyword) {
        self.showSearchBlock();
        self.$searchLoading.show();
    };
    this.hideLoading = function () {
        self.$searchLoading.hide();
    };


    this.hideAll = function () {
        this.hideResults();
        this.hideMessage();
        this.hideAdvance();
        this.hideLoading();
    };

    this.getData = function () {
        var data = [];
        var inputs = self.$hidden.find('input');
        if (inputs.length) {
            inputs.each(function (i, e) {
                data[data.length] = $(e).val();
            });
        }
        return data;
    };

}

App.tagInput = {
    list: {},
    add: function (selector) {
        var $el = $(selector);
        if ($el.length) {
            let $select = new InputTag($el[0]);
            $select.init();
            this.list[$el.data('id')] = $select;
        }
    },
    getTag: function (id) {
        if (id) {
            if (typeof this.list[id] != "undefined") {
                return this.list[id];
            }
        }
        return null;
    },
    getData: function (id) {
        var tag = this.getTag(id);
        if (tag) return tag.getData();
        return [];
    }
};



$(function () {
    var $cs = $('.crazy-tag');
    if ($cs.length) {
        $cs.each(function (i, el) {
            App.tagInput.add(el);
        });
    }
});