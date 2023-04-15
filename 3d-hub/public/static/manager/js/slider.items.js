$(function(){
    const SliderItem = function(options) {
        this.urls = {};
        this.id = 0;
        this.template = "";
        this.init_list = ["urls", "template"];
        this.options = options;
        var self = this;
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };
        this.onStart = function() {
            this.enableSort();
            
            $(document).on('click', '.item-actions .btn-delete-item', function(){
                self.delete($(this).data('id'));
            });
        };

        this.enableSort = function(){
            App.func.call("App.nestable.add", ['#crazy-slider-item-list']);
        };
        this.disableSort = function(){
            App.func.call("App.nestable.remove", ['#crazy-slider-item-list']);
        };

        this.sortCallback = function(l, e){
            var self = this;
            let raw = $(l).nestable('toArray');
            let data = {};
            raw.map(function (item, i) {
                data[item.id] = i+1;
            });
    
            ajaxRequest(self.urls.sort, "POST", {data:data}, function(rs){
                if(rs.status){
                    console.log(rs.message);
                }
                else{
                    App.modal.error(rs.message);
                }
            }, function(err){
                App.modal.error("Lỗi không xác định");
            });
        };
        this.delete = function(id){
            App.modal.confirm("bạn có chắc chắn muốn xóa slider này?", function(status){
                if(status){
                    showLoading();
                    ajaxRequest(self.urls.delete, "POST", {ids:[id]}, function(rs){
                        hideLoading();
                        if(rs.status){
                            $('#crazy-slider-item-list').nestable('remove', id);
                        }else{
                            App.modal.error(rs.message);
                        }
                    }, function(err){
                        //
                        hideLoading();
                        App.modal.error("Lỗi không xác định!");
                    });
                }
            });
        };
    };

    
    
    let options = {};
    if(typeof slider_item_data == 'object'){
        options = slider_item_data;
    }
    else if(typeof crazy_data == 'object'){
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof crazy_data[act+"_slider_item_url"] == "string"){
                urls[act+"_url"] = crazy_data[act+"_slider_item_url"];
            }
        }
        options.urls = urls;
    }

    let slider_item = new SliderItem(options);
    slider_item.init();
    if(typeof App.slider != "object"){
        App.slider = {};
    }
    App.slider.items = slider_item;

});
