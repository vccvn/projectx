Category = {
    categories: {},
    urls:{},
    init_list: ["categories"],
    init: function(args) {
        if (!args || typeof args == 'undefined') return;
        for (var key of this.init_list) {
            if (typeof args[key] != 'undefined') {
                var d = args[key];
                var t = App.getType(d);

                var t2 = (typeof(this[key]) != 'undefined') ? App.getType(this[key]) : "string";
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
    getOptions:function(callback){
        if(typeof callback != "function"){
            callback = function(data){
                console.log(data);
            };
        }
        var self = this;
        ajaxRequest(this.urls.get_option_url, {}, function(rs){
            if(rs.status){
                self.categories = rs.data;
                callback(rs.data);
            }
        })
    },
    getCategoryMap:function(id){
        if(id == 0) return ['Tất cả'];
        var list = [];
        var data = {};
        var self = this;
        let max = -1;
        var searchCategory = function(id, categories, level){
            if(!categories) categories = self.categories;
            var type = App.getType(categories);
            let status = false;
            if(type == 'object' || type == 'array'){
                for (const cate_id in categories) {
                    if (categories.hasOwnProperty(cate_id)) {
                        const cate = categories[cate_id];
                        let valType = App.getType(cate);
                        if(cate_id == id){
                            status = true;
                            data[level] = (valType == "object")? cate.label : cate;
                            if(level>max) max = level;
                        }else if(valType == "object"){
                            let stt2 = searchCategory(id, cate.data, level+1);
                            if(stt2){
                                data[level] = cate.label;
                                status = true;
                                if(level>max) max = level;
                            }
                        }
                        
                    }
                }
            }
            return status;
        };
        if(searchCategory(id, self.categories, 0)){
            for (let i = 0; i <= max; i++) {
                list[i] = data[i];
            }
        }
        return list.length?list:[];
    }


};

$(function(){
    if (typeof window.categoryInit == 'function') {
        window.categoryInit();
        window.categoryInit = null;
        let categories = $('.crazy-list .category-map');
        if(categories.length){
            categories.each(function(i, attr){
                let cateList = Category.getCategoryMap($(attr).data('category-id'));
                if(cateList.length){
                    $(attr).html(cateList.join(' <span class="fa fa-chevron-right"></span> '));
                }
            })
        }
    }
})