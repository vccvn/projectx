$(function(){
    const SliderManager = function(options) {
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

        this.changeStatus = function (status, e){
            this.postUpdateStatus($(e).data('slider-id'), status?1:0);
        };

        this.postUpdateStatus = function(id, status){
            cl(status);
            showLoading();
            ajaxRequest(this.urls.change_status, "POST", {id:id, slider_status:status}, function(rs){
                hideLoading();
                if(rs.status){
                    // do something
                }
                else{
                    App.Swal.warning(message);
                }
            }, function(error){
                hideLoading();
                App.Swal.error("Lỗi không xác định");
            });
        };

        this.checkCropStatus = function (status){
            this.toggleBy('crop', status);
        };

        this.toggleBy = function (ref, status) {

            var refNode = $('.toggle-by-'+ref);
            if(refNode.length){
                if(status){
                    refNode.removeClass("hide-by-"+ref);
                }else if(!refNode.hasClass("hide-by-"+ref)){
                    refNode.addClass("hide-by-"+ref);
                }
            }

            var rNode = $('.rtoggle-by-'+ref);
            if(rNode.length){
                if(!status){
                    rNode.removeClass("hide-by-"+ref);
                }else if(!rNode.hasClass("hide-by-"+ref)){
                    rNode.addClass("hide-by-"+ref);
                }
            }


        };
        this.enableSort = function(){
            App.func.call("App.nestable.add", ['#crazy-slider-list']);
        };
        this.disableSort = function(){
            App.func.call("App.nestable.remove", ['#crazy-slider-list']);
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
                    App.Swal.error(rs.message);
                }
            }, function(err){
                App.Swal.error("Lỗi không xác định");
            });
        };
        this.delete = function(id){
            App.Swal.confirm("bạn có chắc chắn muốn xóa slider này?", function(){

                    showLoading();
                    ajaxRequest(self.urls.delete, "POST", {ids:[id]}, function(rs){
                        hideLoading();
                        if(rs.status){
                            $('#crazy-slider-list').nestable('remove', id);
                        }else{
                            App.Swal.error(rs.message);
                        }
                    }, function(err){
                        //
                        hideLoading();
                        App.Swal.error("Lỗi không xác định!");
                    });

            });
        };
    };



    let options = {};
    if(typeof slider_data == 'object'){
        options = slider_data;
    }
    else if(typeof crazy_data == 'object'){
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof crazy_data[act+"_slider_url"] == "string"){
                urls[act+"_url"] = crazy_data[act+"_slider_url"];
            }
        }
        options.urls = urls;
    }

    let tpl = $('.slider-item-template');
    if(tpl.length){
        options.template = tpl.text();
        tpl.remove();
    }

    let slider = new SliderManager(options);
    slider.init();
    App.slider = slider;

    if($('input#crop').length){
        App.slider.checkCropStatus($('input#crop').is(':checked'));
    }

});
