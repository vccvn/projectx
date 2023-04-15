(function ($) {
    function SmartTable(options) {
        this.urls = {};
        this.el = null;
        this.columns = {};
        this.filterForm = null;
        this.item = {};
        this.pagination = {};
        this.checklist = null;
        this.tools = '';
        this.title = "Khoản mục";
        this.handle = {};
        this.numberFormat = [];
        this.autoload = true;
        this.labels = {
            delete: "xóa",
            restore: "Khôi phục",
            trash: "chuyển vào thùng rác",
            deactive: "ngưng kích hoạt"
        };
        this.parseItem = null;
        this.transform = null;
        this.run = null;
        this.data = null;
        this.init_list = [
            "urls", "el", "columns", "filterForm", "item",
            "pagination", "checklist", "tools", "title",
            "handle", "autoload", 'parseItem', "run",
            "transform",
            "numberFormat", 'data'
        ];
        var $navTool = null;
        var $pagelinks = null;
        var $tool = null;
        var $filterForm = null;

        var $el = null;

        var $filter = {

            search: "",
            searchby: "",
            orderby: "",
            sorttype: "",

        };

        var $pagination = {
            show: true,
            size: 5,
            total: 0,
            current_page: 1,
            last_page: 1,
            per_page: 10,
            from: null,
            to: null,
            first_page_url: "",
            last_page_url: "",
            next_page_url: null,
            prev_page_url: null,
            path: ""
        };

        var $data = [];

        var $header = [];

        var $columns = [];

        var $template = '';

        var self = this;

        function searchToObject() {
            var pairs = window.location.search.substring(1).split("&"),
                obj = {},
                pair,
                i;

            for (i in pairs) {
                if (pairs.hasOwnProperty(i)) {
                    if (pairs[i] === "") continue;

                    pair = pairs[i].split("=");
                    obj[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);

                }
            }

            return obj;
        };

        this.init = (args) => {
            var opt = args || options || {};
            App.setDefault(this, opt);
            $el = $(this.el);
            $filterForm = $(this.filterForm);
            var st = typeof opt.filter == "object" ? opt.filter : null;
            this.setDefaultSorting(st);
            this.setPagination(this.pagination);

            for (const key in this.handle) {
                if (this.handle.hasOwnProperty(key)) {
                    const val = this.handle[key];
                    var k = key.toLowerCase();
                    if (typeof val == "function") {
                        val.bind(this);
                    }
                    this.handle[k] = val;
                }
            }
            this.title = $el.data("title") || $el.data("name") || this.title;

            this.setup();

            this.start();

            if(this.data && !App.isEmpty(this.data)){
                this.setData(this.data);
            }
            if (this.autoload !== false) {

                this.fire("prepare");
                this.filter();
            }

        };

        this.getLabel = function (key) {
            return this.labels[key] || key;
        };

        this.fire = function (event) {

            if (typeof this.handle[event] == "function") {
                var args = [];
                if (arguments.length > 1) {
                    for (let i = 1; i < arguments.length; i++) {
                        const param = arguments[i];
                        args.push(param);
                    }
                }
                try {
                    this.handle[event].apply(this, args);    
                } catch (error) {
                    console.log(error);
                }
                
            }
        }
        this.getData = function () {
            // self.renderTableData("Đang xử lý... ")
            var params = this.getParams();
            $data = [];
            App.api.get(this.urls.data, params)
                .then(res => {
                    self.fire("load", res);
                    var rs = res;
                    hideLoading(500);
                    if (typeof self.transform == "function") {
                        var d = self.transform(res);
                        if (d) rs = d;
                    }

                    if (rs.data) {
                        if (rs.data.length) {
                            self.setPagination(rs);
                            $data = rs.data;
                            self.renderTableData(rs.data);
                            return true;
                        }
                    } else {
                        $data = [];
                    }
                    return self.renderTableData("Không có kết quả")
                })
                .catch(err => {
                    self.fire("lerror", err);
                    console.log(err);
                    self.renderTableData("Lỗi khong tải dược dữ liệu");

                    hideLoading(500);
                });
        };
        this.setData = function(rs){
            if (rs.data) {
                if (rs.data.length) {
                    self.setPagination(rs);
                    $data = rs.data;
                    self.renderTableData(rs.data);
                    return true;
                }
            } else {
                $data = [];
            }
            return self.renderTableData("Không có kết quả")
        };
        this.loadPage = function (page) {
            var data = this.getParams();
            if (page > $pagination.last_page) page = $pagination.last_page;
            if (page == $pagination.current_page) return false;
            data.page = page;
            showLoading(100000);

            this.load(data);
        };

        this.reload = function () {
            $pagination.current_page = 1;
            $pagination.last_page = 0;
            $pagination.total = 0;
            showLoading(1000 * 60 * 60);

            this.getData();
        };

        this.load = function (data) {
            this.setParam(data);
            this.renderFilter();
            $pagination.current_page = 1;
            $pagination.last_page = 0;
            $pagination.total = 0;
            this.getData();
        };

        this.filter = function (data) {
            if (!data) data = this.getFilterData();
            data.page = 1;
            this.load(data);

        };

        this.sorting = function (data) {
            if (!data) data = $filter;
            data.page = 1;
            this.setDefaultSorting(data);
            this.load($filter);
        };

        this.callApi = function (action, id) {
            var url = typeof this.urls[action] == "string" && this.urls[action] ? this.urls[action] : (
                typeof this.urls[action + 'Url'] == "string" && this.urls[action + 'Url'] ? this.urls[action + 'Url'] : (
                    action.indexOf('http://') == 0 ? action : null
                )
            )
            if (url) {
                App.api.post(url, { id: id })
                    .then(function (res) {
                        if (res.status) {
                            var ids = res.data;
                            var lbl = self.getLabel(action);
                            App.Swal.success("Đã " + lbl + " " + ids.length + " " + self.title + " thành công!");
                            if (ids.length) {
                                ids.map(function (tid) {
                                    if (action == 'deactive') {
                                        $el.find('tr[data-id="' + tid + '"]').css('opacity', 0.4);
                                    } else {
                                        self.removeDataItem(tid);
                                    }

                                });
                                if (action != "deactive") {
                                    if (!$data.length) {
                                        self.renderTableData("Đang xử lý");
                                        if ($pagination.current_page < $pagination.last_page) {
                                            self.reload();
                                        } else if ($pagination.current_page > 1) {
                                            self.loadPage($pagination.current_page - 1);
                                        } else {
                                            self.renderTableData("Không có kết quả");
                                        }
                                    } else {
                                        self.renderTableData($data);
                                    }
                                }

                            }

                            if (typeof self.handle["on" + action] == "function") {
                                self.handle["on" + action](res.data);
                            }
                        } else {
                            App.Swal.warning("Thao tác không hợp lệ! Vui lòng thử lại sau giây lát");
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                        App.Swal.warning("Lỗi không xác định! Vui lòng thử lại sau giây lát");
                    });
            }
        };

        this.getFilterData = function () {
            var indexed_array = App.deepCopy($filter);
            if ($filterForm.length) {
                var unindexed_array = $filterForm.serializeArray();
                $.map(unindexed_array, function (n, i) {
                    indexed_array[n['name']] = n['value'];
                });
            }
            return indexed_array;
        };

        this.setup = function () {
            //
            if (this.columns.length) {
                //
                var thead = [];
                var tbody = [];


                if (this.checklist) {
                    thead.push({
                        className: "check-col text-center w-70px",
                        title: ' <label class="ms-checkbox-wrap ms-checkbox-warning">' +
                            '<input type="checkbox" class="checkbox check-all" name="items[]" value="all"> ' +
                            '<i class="ms-checkbox-check"></i>' +
                            '</label>'
                    });
                    tbody.push({
                        className: "check-col text-center w-70px",
                        content: '<label class="ms-checkbox-wrap"><input type="checkbox" class="checkbox check-item" name="items[]" value="{$' + this.checklist + '}"> <i class="ms-checkbox-check"></i></label>'
                    });

                }


                for (let i = 0; i < this.columns.length; i++) {
                    const column = this.columns[i];
                    if (App.isObject(column)) {
                        let th = {};
                        let td = {};
                        for (const key in column) {
                            if (column.hasOwnProperty(key)) {
                                const val = column[key];
                                if (['title', 'orderby', 'sortby', 'sorttype', 'className'].indexOf(key) != -1) {
                                    th[key] = val;
                                    if (['className'].indexOf(key) != -1) {
                                        td[key] = val;
                                    }
                                } else {
                                    td[key] = val;
                                }
                            }
                        }
                        thead.push(th);
                        tbody.push(td);

                    }
                }
                $header = thead;
                $columns = tbody;
            }

            this.renderHeader();
            this.makeTemplate();
            this.makeNavTool();
            if (!$el.find('tbody').length) {
                if ($el.find('thead').length) {
                    $el.find('thead').after('<tbody></tbody>');
                } else {
                    $el.prepend('<tbody></tbody>');
                }
            }

        };

        this.setDefaultSorting = function (option) {
            if (!option) {
                option = searchToObject();
            }
            if (option.sortby) option.orderby = option.sortby;
            for (const key in option) {
                if (option.hasOwnProperty(key) && key != "data") {
                    const val = option[key];
                    if (key == "per_page") {
                        $pagination[key] = val;
                    } else {
                        $filter[key] = val;
                    }

                }
            }
            return this;
        };

        this.setParam = function (option, value) {
            if (!option) {
                option = {};
            } else if (App.isString(option)) {
                var b = option + "";
                option = {};
                option[b] = value !== undefined ? value : "";
            }
            if (option.sortby) option.orderby = option.sortby;
            for (const key in option) {
                if (option.hasOwnProperty(key) && key != "data") {
                    const val = option[key];
                    if (key == "per_page") {
                        $pagination[key] = val;
                    } else if (!$pagination.hasOwnProperty(key)) {
                        $filter[key] = val;
                    }

                }
            }

            if ($filterForm && $filterForm.length) {
                for (const key in option) {
                    if (option.hasOwnProperty(key)) {
                        const val = option[key];
                        var $inp = $filterForm.find('[name="' + key + '"]');
                        if ($inp.length) {
                            $inp.val(val);
                        }
                    }
                }
            }

            return this;
        };
        this.removeParam = function (key) {
            if (typeof key == "string") {
                if (typeof $filter[key] != "undefined") {
                    $filter[key] = '';
                    delete $filter[key];

                    if ($filterForm && $filterForm.length) {
                        var $inp = $filterForm.find('[name="' + key + '"]');
                        if ($inp.length) {
                            $inp.val("");
                        }
                    }

                }
            } else if (!key) {
                if ($filterForm && $filterForm.length) {
                    for (const key in $filter) {
                        if (option.hasOwnProperty(key)) {
                            const val = option[key];
                            var $inp = $filterForm.find('[name="' + key + '"]');
                            if ($inp.length) {
                                $inp.val("");
                            }
                        }
                    }
                }
                $filter = {

                    search: "",
                    searchby: "",
                    orderby: "",
                    sorttype: "",
                }

            }
        };

        this.setPagination = function (option) {
            if (!option) {
                option = searchToObject();
            }
            for (const key in option) {
                if (option.hasOwnProperty(key) && key != "data") {
                    const val = option[key];

                    $pagination[key] = val;
                    if (key == "per_page") {
                        this.setFilterFormData({
                            per_page: val
                        });
                    }
                }
            }
            return this;
        };

        this.resetPagination = function () {
            return this.setPagination({
                total: 0,
                current_page: 1,
                last_page: 1,
                from: null,
                to: null,
                first_page_url: "",
                last_page_url: "",
                next_page_url: null,
                prev_page_url: null,
                path: null

            })
        };

        this.setFilterFormData = function (option) {
            if (App.isObject(option)) {
                if ($filterForm && $filterForm.length) {
                    for (const key in option) {
                        if (option.hasOwnProperty(key)) {
                            const val = option[key];
                            var $inp = $filterForm.find('[name="' + key + '"]');
                            if ($inp.length) {
                                $inp.val(val);
                            }
                        }
                    }
                }
            }
        };

        this.getParams = function () {
            var d = {};
            var ignore = [
                'current_page', 'total', 'last_page', "from", "to",
                "first_page_url", "last_page_url", "next_page_url", "prev_page_url", "path",
                "data"
            ];

            for (const key in $filter) {
                if ($filter.hasOwnProperty(key)) {
                    const val = $filter[key];
                    if (ignore.indexOf(key) == -1) {
                        d[key] = val;
                    }
                }
            }
            d.per_page = $pagination.per_page;
            return d;
        };

        this.renderHeader = function () {
            if ($el.find('thead').length == 0) {
                $el.prepend('<thead></thead>');
            }
            var html = '';
            for (let i = 0; i < $header.length; i++) {
                const th = $header[i];
                var sort = th.sortby || th.orderby || null;
                var type = th.sorttype || null;
                var cl = th.className || null;
                var tm = type || $filter.sorttype;
                var title = th.title || "";
                var g = String(tm).toLowerCase();
                var tp = g == 'desc' ? 'down' : 'up';
                var t = '<th ' + (sort ? 'data-sortby="' + sort + '" ' : '')
                    + (sort ? ('data-sorttype="' + (sort == $filter.orderby && tm ? g : '') + '" ') : '')
                    + (cl ? 'class="' + cl + '"' : '')
                    + (sort && sort == $filter.orderby ? ' data-active="actived"' : '')
                    + '>' + title +
                    (sort ? (sort == $filter.orderby ? ' <i class="fa fa-sort-' + tp + '">' : ' <i class="fa fa-sort">') : '')
                    + '</th>';
                html += t;
            }
            $el.find('thead').html('<tr>' + html + '</tr>');
        };

        this.makeTemplate = function () {
            $template = '<tr';
            if (App.isObject(this.item)) {
                for (const key in this.item) {
                    if (this.item.hasOwnProperty(key)) {
                        const val = this.item[key];
                        var k = key.toLowerCase() == "classname" ? "class": key;
                        if(k == "class"){
                            $template += ' ' + k + (val !== true && val !== null ? '="' + val + ' {$className} {$' + val + '}""' : '');
                        }else{
                            $template += ' data-' + key + (val !== true && val !== null ? '="{$' + val + '}"' : '');
                        }
                        
                    }
                }
            }

            $template += '>';
            for (let i = 0; i < $columns.length; i++) {
                const column = $columns[i];
                $template += '<td'

                if (App.isObject(column)) {
                    for (const attr in column) {
                        if (column.hasOwnProperty(attr)) {
                            const v = column[attr];
                            if (attr == "className") {
                                $template += ' class' + (v !== true && v !== null ? '="' + v + '"' : '');
                            }
                            else if (attr != 'content') {
                                $template += ' ' + attr + (v !== true && v !== null ? '="' + v + '"' : '');
                            }
                        }
                    }
                }

                $template += '>' + (String(column.content).length ? column.content : '') + '</td>';
            }
            $template += '</tr>'

        };

        this.renderFilter = function () {
            var sortby = $filter.orderby;
            var sorttype = $filter.sorttype;
            if (sortby) {
                var $th = $el.find('thead tr th[data-sortby]');
                $th.attr("data-active", "");
                $th.attr("data-sorttype", "");
                $th.find('i').removeClass().addClass('fa fa-sort');
                var $active = $el.find('thead tr th[data-sortby="' + sortby + '"]');
                $active.attr("data-sorttype", sorttype);
                $active.attr("data-active", 'actived');
                var $i = $active.find('i');
                if (sorttype == 'desc') $i.addClass('fa fa-sort-down');
                else $i.addClass('fa fa-sort-up');



            }
        };

        this.makeNavTool = function () {
            if (!$el.parent().parent().find('.smarttable-nav-tool').length) {
                $el.parent().after(
                    '<div class="row smarttable-nav-tool">' +
                    '<div class="col-md-auto text-center smart-tool text-md-left mb-2">' +


                    '</div>' +
                    '<div class="col-md-auto ml-auto text-center text-md-right">' +
                    '<div class="d-inline-block">' +
                    '<ul class="pagination"></ul>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                )
            }
            $navTool = $el.parent().parent().find('.smarttable-nav-tool');
            $tool = $navTool.find('.smart-tool');
            $pagelinks = $navTool.find('.pagination');
        };

        this.renderTool = function () {

            var tool = ($data.length && this.checklist ? '<a class="btn btn-primary btn-check-all px-2 py-1 ml-md-3" href="#"><i class="fas fa-check"></i></a>' : '');

            if ($data.length && this.tools) {
                var tools = {
                    trash: '<a class="btn-trash-all btn btn-danger  px-2 py-1 text-white" href="#"><i class="far fa-trash-alt"></i></a>',
                    restore: '<a class="btn-restore-all btn btn-info  px-2 py-1 text-white" href="#"><i class="fa fa-history"></i></a>',
                    deactive: '<a class="btn-deactive-all btn btn-warning  px-2 py-1 text-white" href="#"><i class="fa fa-ban"></i></a>'
                }
                if (App.isArray(this.tools)) {
                    for (let i = 0; i < this.tools.length; i++) {
                        const k = this.tools[i];
                        if (App.isString(k)) {
                            if (k.length < 10) {
                                if (typeof tools[k] != "undefined") tool += " " + tools[k];
                            } else {
                                tool += k;
                            }
                        }
                    }
                } else if (App.isString(this.tools)) {
                    if (this.tools.length < 10) {
                        if (typeof tools[this.tools] != "undefined") tool += " " + tools[this.tools];
                    } else {
                        tool += " " + this.tools;
                    }
                }
            }
            $tool.html(tool);
        };

        this.renderPagination = function () {

            var html = '';
            // previous disabled
            // active

            // areia 
            // 
            var $li = '<li class="paginate_button page-item {$class}" {$attr}>{$content}</li>';
            var dot = '<li class="paginate_button page-item disabled"><a href="javascript:void(0)" class="page-link"><span>...</span></a></li>';

            // 

            // <i class="fa fa-angle-double-right"></i>
            var $a = '<a href="javascript:void(0)" class="page-link" data-page="{$page}">{$content}</a>';


            var size = $pagination.size;
            var page_total = $pagination.last_page, current_page = $pagination.current_page;

            var distance = parseInt(size / 2);
            if ($pagination.show && page_total > 1) {
                var previewAtttr = 'aria-label="pagination.previous" ';
                var previewNumber = current_page - 1;
                var previewClass = 'previous '
                if (current_page < 2) {
                    previewAtttr = 'aria-disabled="true" '
                    previewNumber = 1;
                    previewClass += 'disabled'
                }

                html += App.str.eval($li, {
                    "class": previewClass,
                    attr: previewClass,
                    content: App.str.eval($a, {
                        page: previewNumber,
                        content: '<i class="fa fa-angle-double-left"></i>'
                    })
                });

                var bf = current_page - distance;
                var af = current_page + distance;

                var start = bf;
                var end = af;

                if (end < size) {
                    end = size;
                }
                if (end > page_total) {
                    end = page_total;
                }
                if (end == page_total) {
                    start = page_total - size;
                }

                if (start < 1) {
                    start = 1;
                }
                if (start > 1) {

                    html += App.str.eval($li, {
                        content: App.str.eval($a, {
                            page: 1,
                            content: 1
                        })
                    });
                    if (bf > 2) {
                        html += dot;
                    }
                }

                for (let i = start; i <= end; i++) {
                    html += App.str.eval($li, {
                        "class": current_page == i ? 'active' : '',
                        content: App.str.eval($a, {
                            page: i,
                            content: i
                        })
                    });
                }


                if (end < page_total) {
                    if (end < page_total - 1) {
                        html += dot;
                    }
                    html += App.str.eval($li, {
                        content: App.str.eval($a, {
                            page: page_total,
                            content: page_total
                        })
                    });
                }


                var nextAtttr = 'aria-label="pagination.next" ';
                var nextNumber = current_page + 1;
                var nextClass = 'next '
                if (current_page == page_total) {
                    nextAtttr = 'aria-disabled="true" '
                    nextNumber = 1;
                    nextClass += 'disabled'
                }

                html += App.str.eval($li, {
                    "class": nextClass,
                    attr: nextClass,
                    content: App.str.eval($a, {
                        page: nextNumber,
                        content: '<i class="fa fa-angle-double-right"></i>'
                    })
                });


            }

            $pagelinks.html(html);
        };

        this.update = function (data) {
            $data = data;
            this.renderTableData($data);
        };

        this.addRow = function (data) {
            var d = '';
            if (App.isObject(data)) {
                if (typeof this.parseItem == "function") {
                    this.parseItem.bind(this);
                    let dt = this.parseItem(data);
                    if (dt && App.isObject(dt)) {
                        d += App.str.eval($template, dt);
                    } else {
                        d += App.str.eval($template, data);
                    }
                }
                else {
                    d += App.str.eval($template, data);
                }
            } else {
                d = '<tr><td class="text-center" colspan="' + $columns.length + '"> ' + (App.isString(data) ? data : 'Không có kết quả') + ' </td></tr>';
            }
            $el.find('tbody').append(d);
            this.renderTool();
            this.renderPagination();

        };
        this.renderTableData = function (data) {
            var d = '';
            if (App.isArray(data) && data.length) {
                if (typeof this.parseItem == "function") {
                    this.parseItem.bind(this);
                    for (let index = 0; index < data.length; index++) {
                        let item = data[index];
                        let dt = this.parseItem(item);
                        if (dt && App.isObject(dt)) {
                            d += App.str.eval($template, this.formatData(dt));
                        } else {
                            d += App.str.eval($template, this.formatData(item));
                        }
                    }
                }
                else {
                    for (let index = 0; index < data.length; index++) {
                        let item = this.formatData(data[index]);
                        d += App.str.eval($template, item);
                    }
                }
            } else {
                d = '<tr><td class="text-center" colspan="' + $columns.length + '"> ' + (App.isString(data) ? data : 'Không có kết quả') + ' </td></tr>';
            }
            $el.find('tbody').html(d);
            this.renderTool();
            this.renderPagination();
            self.fire("rendered");
        };

        this.render = function () {
            this.renderTableData($data);
        };

        this.formatData = function(data){
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const val = parseInt(data[key]);
                    if(this.numberFormat.indexOf(key) >= 0){
                        data[key] = App.number.currency(val);
                    }
                }
            }
            return data;
        }
        this.removeDataItem = function (id) {
            if ($data.length) {
                if (id) {
                    for (let index = 0; index < $data.length; index++) {
                        const item = $data[index];
                        var s = true;
                        if (App.isObject(id)) {

                            for (const key in id) {
                                if (id.hasOwnProperty(key)) {
                                    const v = id[key];
                                    if (item.hasOwnProperty(key) && item[key] != v) {
                                        // dung ma
                                    } else {
                                        s = false;
                                    }
                                }
                            }

                        }
                        else if (App.isArray(id)) {
                            if (id.indexOf(item.id) == -1) {
                                s = false;
                            }
                        }
                        else if (!item.id || item.id != id) {
                            s = false;

                        }
                        if (s) {
                            $data.splice(index, 1);
                            index--;
                        }
                    }

                }
            }
        };

        this.getAttrData = function (key) {
            //
            var d = [];
            if (key) {
                $el.find('tbody tr').each(function (tr) {
                    var v = $(tr).data(key);
                    if (v !== null && String(v).length) {
                        d.push(v);
                    }
                })
            }
            return d;
        };

        this.footer = function(data){
            if(data){
                console.log(data)
                if($el.find('tfoot').length == 0){
                    $el.find('tbody').after('<tfoot></tfoot>');
                }
                var $tfoot = $el.find('tfoot');
                if(App.isString(data)){
                    $tfoot.html('<tr><td colspan="' + $columns.length + '">' + data + '</td></tr>');
                }else if(App.isObject(data)){
                    $tfoot.html(
                        App.str.eval($template, data)
                    );
                }
            }
        };
        this.start = function () {

            $filterForm.submit(function (e) {
                e.preventDefault();
                var data = self.getFilterData();
                self.filter(data);
                return false;
            })


            $el.on("click", "thead tr th[data-sortby]", function () {
                var sortby = $(this).data('sortby');
                var sorttype = $(this).attr("data-sorttype") == 'asc' ? 'desc' : 'asc';
                self.setDefaultSorting({
                    orderby: sortby,
                    sorttype: sorttype
                });
                self.sorting();
            });

            $navTool.on("click", ".pagination", function (e) {
                e.preventDefault();
                var link = null;
                var $e = $(e.target);
                if ($e.is("li:not(.disabled) a[data-page].page-link")) {
                    link = $e;
                } else if ($e.closest(" li:not(.disabled) a[data-page].page-link").length) {
                    link = $e.closest(" li:not(.disabled) a[data-page].page-link");
                }
                if (!link) return false;
                var page = parseInt(link.attr('data-page'));
                if (!isNaN(page)) {
                    self.loadPage(page);
                }
            })

            $el.on("click", 'input[type="checkbox"].check-all', function (e) {
                if ($(this).is(":checked")) {
                    self.checkAll();
                } else {
                    self.unCheckAll();
                }

            });
            $el.on("click", 'input[type="checkbox"].check-item', function (e) {
                if ($el.find('input[type="checkbox"].check-item').length == $el.find('input[type="checkbox"].check-item:checked').length) {
                    $el.find('input[type="checkbox"].check-all').prop("checked", true);
                } else {
                    $el.find('input[type="checkbox"].check-all').prop("checked", false);
                }
            });
            $navTool.on("click", '.btn-check-all', function (e) {
                e.preventDefault();
                $(this).removeClass("btn-check-all").addClass("btn-uncheck-all");
                self.checkAll();
            });

            $navTool.on("click", '.btn-uncheck-all', function (e) {
                e.preventDefault();
                $(this).removeClass("btn-uncheck-all").addClass("btn-check-all");
                self.unCheckAll();
            });


            $navTool.on("click", '.btn-trash-all', function (e) {
                e.preventDefault();
                var ids = self.getCheckedValues();
                if (ids.length) {
                    App.Swal.confirm("Bạn có chắc chắn muốn xóa " + ids.length + " " + self.title + " này?", function () {
                        self.callApi("trash", ids);
                    });
                } else {
                    App.Swal.warning("Không có mục nào được chọn");
                }
            });

            $navTool.on("click", '.btn-deactive-all', function (e) {
                e.preventDefault();
                var ids = self.getCheckedValues();
                if (ids.length) {
                    App.Swal.confirm("Bạn có chắc chắn muốn Ngưng kích hoạt " + ids.length + " " + self.title + " này?", function () {
                        self.callApi("deactive", ids);
                    });
                } else {
                    App.Swal.warning("Không có " + self.title + " nào được chọn");
                }
            });
            $navTool.on("click", '.btn-restore-all', function (e) {
                e.preventDefault();
                var ids = self.getCheckedValues();
                if (ids.length) {
                    App.Swal.confirm("Bạn có chắc chắn muốn khôi phục hoạt " + ids.length + " " + self.title + " này?", function () {
                        self.callApi("restore", ids);
                    });
                } else {
                    App.Swal.warning("Không có " + self.title + " nào được chọn");
                }
            });



            $el.on("click", '.btn-delete-item', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                App.Swal.confirm("Bạn có chắc chắn muốn xóa vĩnh viễn " + self.title + " này không?", function () {
                    self.callApi("delete", id);
                });
            });

            $el.on("click", '.btn-trash-item', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                App.Swal.confirm("Bạn có chắc chắn muốn xóa " + self.title + " này không?", function () {
                    self.callApi("trash", id);
                });
            });

            $el.on("click", '.btn-restore-item', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                App.Swal.confirm("Bạn có chắc chắn muốn khôi phục " + self.title + " này không?", function () {
                    self.callApi("restore", id);
                });
            });

            $el.on("click", '.btn-deactive-item', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                App.Swal.confirm("Bạn có chắc chắn muốn ngừng kích hoạt " + self.title + " này không?", function () {
                    self.callApi("deactive", id);
                });
            });

            if (typeof this.run == "function") {
                this.run($el, $navTool);
            }
        };

        this.checkAll = function () {
            $el.find('input[type="checkbox"].check-all').prop("checked", true);
            $el.find('input[type="checkbox"].check-item').prop("checked", true);

        };

        this.unCheckAll = function () {
            $el.find('input[type="checkbox"].check-all').prop("checked", false);
            $el.find('input[type="checkbox"].check-item').prop("checked", false);

        };

        this.getCheckedValues = function () {
            var data = [];
            $el.find('input[type="checkbox"].check-item').each(function (i, inp) {
                if ($(inp).is(":checked")) {
                    data.push($(inp).val());
                }
            });
            return data;
        };

        this.row = function (id) {
            if (!id) return $el.find('tr[nullid]');
            if (App.isObject(id)) {
                if (!App.isEmpty(id)) {
                    var $tr = $el.find('tr');
                    if ($tr.length) {
                        for (let i = 0; i < $tr.length; i++) {
                            const tr = $tr[i];
                            var s = true;
                            for (const k in id) {
                                if (id.hasOwnProperty(k)) {
                                    const v = id[k];
                                    if ($(tr).data(k) != v) s = false;
                                }
                            }
                            if (s) return $(tr);
                        }
                    }
                }
            } else {
                return $el.find('tr[data-id="' + id + '"]');
            }
            return $el.find('tr[nullid]');
        }

    }


    App.extend({
        smarttable: {
            list: {},
            add: function (id, options) {
                if (!id) id = App.str.rand();
                var st = new SmartTable(options);
                st.init(options);
                this.list[id] = st;
                return st;
            },
            setup: function (id, option) {
                if (App.isObject(id)) {
                    option = App.deepCopy(id);
                    id = App.str.rand();
                }
                var st = new SmartTable(option);
                st.init(option);
                this.list[id] = st;
                return st;
            },
            get: function (id) {
                var st = null;
                if (typeof this.list[id] != "undefined") {
                    st = this.list[id];
                }
                return st;
            },
            getCheckedValues: function (id) {
                var values = [];
                var st = this.get(id);
                if (st) {
                    values = st.getCheckedValues();
                }
                return values;
            },
            reload: function (id) {
                var value = null;
                var st = this.get(id);
                if (st) {
                    value = st.reload();
                }
                return value;
            },
            goToPage: function (id, page) {
                var value = null;
                var st = this.get(id);
                if (st) {
                    value = st.loadPage(page);
                }
                return value;
            },
            remove: function (id) {
                delete this.list[id];
                return this;
            }
        }
    });


    if (typeof window.smarttableInit == "function") {
        window.smarttableInit();
        window.smarttableInit = null;
    }



}(jQuery));