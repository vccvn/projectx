function FormSetting(selector) {
    var $el = $(selector);
    var $title = $el.find('input.group-input-title');
    var $class = $el.find('input.group-input-class');
    var $btnOpenTitleForm = $el.find('.btn-open-title-form-group');
    var $btnCloseTitleForm = $el.find('.btn-close-title-form-group');
    var $btnOpenClassForm = $el.find('.btn-open-class-form-group');
    var $btnCloseClassForm = $el.find('.btn-close-class-form-group');

    var $btnDeleteGroup = $el.find('.btn-delete-form-group');
    
    var $titleTextGroup = $el.find('.setting-group-title');
    var $titleFormGroup = $el.find('.form-setting-group-title');
    var $classTextGroup = $el.find('.setting-group-class');
    var $classFormGroup = $el.find('.form-setting-group-class');
    
    var $dd = $el.find('.dd');

    this.index = $el.data('index');
    
    var fsSstatus = true;
    var self = this;

    /**
     * thiết lập cấu hình
     * @return {void}
     */
    this.init = function(){
        // show form chinh sua title
        $btnOpenTitleForm.on('click', function(){
            $titleTextGroup.addClass('d-none');
            $classTextGroup.addClass('d-none');
            $titleFormGroup.removeClass('d-none');
        });

        // luu chinh sua
        $btnCloseTitleForm.on('click', function(){
            $titleTextGroup.removeClass('d-none');
            $classTextGroup.removeClass('d-none');
            $titleFormGroup.addClass('d-none');
            $titleTextGroup.find('.title-text').html($title.val());
        });

        // mo form chinh sua class
        $btnOpenClassForm.on('click', function(){
            $titleTextGroup.addClass('d-none');
            $classTextGroup.addClass('d-none');
            $classFormGroup.removeClass('d-none');
        });
        // luu class mới
        $btnCloseClassForm.on('click', function(){
            $titleTextGroup.removeClass('d-none');
            $classTextGroup.removeClass('d-none');
            $classFormGroup.addClass('d-none');
            var oldClass = $el.attr('data-class');
            var newClass = $class.val();
            if(oldClass){
                $el.removeClass(oldClass);
            }
            $el.addClass(newClass);
            $el.attr('data-class', newClass);
            $classTextGroup.find('.class-text').html(newClass);
        });

        // xóa group
        $btnDeleteGroup.on('click', function(){self.remove();});

        // nestable
        let options = {
            group:1,
            callback: function(l,e){
                if($(l).data('callback')){
                    App.func.call($(l).data('callback'),[l,e]);
                }
            }
        };
        if($dd.data('max-depth')){
            options.maxDepth = Number($dd.data('max-depth'));
        }

        $dd.nestable(options)//.on('change', updateOutput);
    };
    this.addNestable = function(){
        
    };
    /**
     * lấy dữ liệu
     * @return {object}
     */
    this.getData = function(){
        var data = {
            "title":$title.val(),
            "class":$class.val()
        };
        var inputs = [];
        var $list = $el.find('.dd-list .dd-item');
        if($list.length){
            $list.each(function(i, e){
                inputs[inputs.length] = $(e).data('id');
            });
        }
        data['inputs'] = inputs;
        return data;
    };

    /**
     * lấy thông tin trạng thái
     * @return {boolean}
     */
    this.isActive = function(){
        return fsSstatus;
    }

    this.remove = function(){

        App.Swal.confirm("Bạn có chắc là muốn xóa group này không?", function(stt){
            fsSstatus = false;
            $el.hide(400);
            var data = {
                remove_index: self.index,
                form_groups: FSetting.getFormGroupData()
            };
            showLoading();
            ajaxRequest(FSetting.delete_url, "POST", data, function(res){
                if(res.status){
                    top.location.reload();
                }else{
                    hideLoading();
                    $el.show(400);
                }
            }, function(e) {
                hideLoading();
                console.log(e);
            });
        });




        
        // function(){
        //     $el.remove();
        //     $title = null;
        //     $class = null;
        //     $btnOpenTitleForm = null;
        //     $btnCloseTitleForm = null;
        //     $btnOpenClassForm = null;
        //     $btnCloseClassForm = null;

            
        //     $titleTextGroup = null;
        //     $titleFormGroup = null;
        //     $classTextGroup = null;
        //     $classFormGroup = null;
            
        //     $dd = null;
        //     self.init = function(){};
        //     self.addNestable = function(){};
        //     self.remove = function(){};
        //     self.getData = function(){return{}};

        // });
    };



    this.init();
}


var FSetting = {
    list:{},
    submit_url:'',
    delete_url:'',
    template:'',
    maxIndex:-1,
    addon:null,
    nestableCallback:function(l, e){

    },
    add:function(id){
        const group = new FormSetting('#'+id);
        // group.init();
        this.maxIndex = parseInt(group.index);
        this.list[id] = group;
    },
    getFormGroupData:function(){
        var form_groups = {};
        var list = this.list;
        for (const key in list) {
            if (list.hasOwnProperty(key)) {
                const elem = list[key];
                if(elem.isActive())
                    form_groups[elem.index] = elem.getData();
                else delete this.list[key];
            }
        }

        return form_groups;
    },
    getData:function(){
        return {
            name:"",
            layout_type:"column",
            form_groups:this.getFormGroupData()
        };
    },
    save: function(success, fail){
        if(self.isSendingRequest){
            if(typeof fail == "function") fail();
            return App.Swal.alert("Đang xử lý yêu cầu");
        }
        self.isSendingRequest = false;
        var data = {
            name:"",
            layout_type:"column",
            form_groups:this.getFormGroupData()
        };
        ajaxRequest(this.submit_url, "POST", data, function(rs) {
            self.isSendingRequest = false;
            if(rs.status){
                App.Swal.success(rs.message);
                if(typeof success == "function") success();
            }else{
                App.Swal.warning(rs.message);
                if(typeof fail == "function") fail();
            }
            
        });
        
    },
    init:function(){
        this.template = $('.group-template').html();
        $('.group-template').remove();
        this.addon = $('.add-group-addon');
        if(typeof form_setting_groups != "undefined"){
            for(var i = 0; i < form_setting_groups.length; i++){
                this.add(form_setting_groups[i]);
            }
        }
        if(typeof form_setting_submit_url != "undefined"){
            this.submit_url = form_setting_submit_url;
        }
        if(typeof delete_form_group_url != "undefined"){
            this.delete_url = delete_form_group_url;
        }
    
    
        $('.btn-save-form-setting').click(function(){
            var $this = $(this);
            $this.removeClass('btn-info');
            $this.addClass('btn-default');
            $this.html('Đang xử lý...')
            var callback = function(){
                $this.removeClass('btn-default');
                $this.addClass('btn-info');
                $this.html('Lưu');
                
            };
            FSetting.save(callback, callback);
        });
        

        var self = this;
        this.addon.find('.btn-add-group').on('click', function(){
            
            App.modal.popup({
                title: "Thêm group",
                btnDone:"Thêm",
                inputs:{
                    title:{
                        type: "text",
                        label:"Tiêu đề",
                        placeholder:"Nhập tiêu đề"
                    },
                    class:{
                        type: "text",
                        label:"class",
                        placeholder:"Nhập Class"
                    }
                },
                done:function(data){
                    data.index =self.maxIndex+1; 
                    self.addon.before(App.str.eval(self.template,data));
                    self.add('form-setting-group-'+data.index);
                }
            });
            
        });
    }

};

$(function () {
    FSetting.init();
});