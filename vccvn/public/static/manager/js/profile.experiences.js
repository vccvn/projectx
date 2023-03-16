if(typeof Profile == "undefined"){
    var Profile = {};
}

Profile.experiences = {
    urls: {},
    id: 0,
    template: "",
    actionTemplate:"",
    type: "work",
    init_list: ["urls", "type"],

    init: function(args) {
        App.setDefault(this, args || this.options);
            this.onStart();
    },
    onStart:function(){
        var self = this;

        let tpl = $('.timeline-item-template');
        self.template = tpl.html();
        tpl.remove();

        $('.btn-add-profile-experience').click(function(){
            self.id = 0;
            self.showFormData();
        });

        $('.crazy-timeline').on('click', '.btn-edit', function(){
            let id = $(this).data('id');
            self.id = id;
            self.detail(id, function(data){
                self.showFormData(data);
            });
        });

        $('#add-experience-form').submit(function(e){
            e.preventDefault();
            let data = $(this).serialize();
            App.modal.hide();
            showLoading();
            ajaxRequest($(this).attr('action'), "POST", data, function(rs){
                hideLoading();
                if(rs.status){
                    let data = self.parseData(rs.data);
                    if(data.id == self.id){
                        self.updateInfo(data.id, data);
                    }else{
                        self.addItem(data);
                    }
                }
                else{
                    let message = '';
                    if(rs.errors){
                        let messages = [];
                        for (const key in rs.errors) {
                            if (rs.errors.hasOwnProperty(key)) {
                                const error = rs.errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    }else{
                        message = rs.message;
                    }
                    App.Swal.error(message, null, function(){
                        self.showForm();
                    });
                }
            }, function(error){
                hideLoading();
            });
            return false;
        });


        $('.crazy-timeline').on('click', '.btn-delete', function(){
            let id = $(this).data('id');
            self.delete(id);
        });

    },
    detail:function(id, callback){
        var self = this;
        showLoading();
        ajaxRequest(self.urls.detail_url, "GET", {id:id}, function(rs){
            hideLoading();
            if(rs.status){
                if(typeof callback == "function"){
                    callback(rs.data);
                }
            }else{
                App.Swal.error(rs.message);
            }
        }, function(err){
            //
            hideLoading();
            App.Swal.error("Lỗi không xác định!");
        });
    },
    toggleStartDate:function(checked){
        this.toggleBy(checked, 'has-start-date');
    },
    toggleFinishDate:function(checked){
        this.toggleBy(checked, 'has-finish-date');
    },
    showBy:function(s){
        $('.toggle-by-'+s).removeClass('hide-by-'+s);
    },
    hideBy:function(s){
        $('.toggle-by-'+s).addClass('hide-by-'+s);
    },
    rShowBy:function(s){
        $('.rtoggle-by-'+s).removeClass('hide-by-'+s);
    },
    rHideBy:function(s){
        $('.rtoggle-by-'+s).addClass('hide-by-'+s);
    },
    toggleBy:function(stt, cls){
        if(stt){
            this.showBy(cls);
            this.rHideBy(cls);
        }else{
            this.rShowBy(cls);
            this.hideBy(cls);
        }
    },

    addBusiness:function(name){
        var self = this;
        Profile.organizations.addBusiness(name, function (data) {
            self.showForm();
        });
    },
    addEducation:function(name){
        var self = this;
        Profile.organizations.addEducation(name, function (data) {
            self.showForm();
        });
    },
    checkForm : function(){
        this.toggleBy($('#experience-has-start-date').is(":checked"), "has-start-date");
        this.toggleBy($('#experience-has-finish-date').is(":checked"), "has-finish-date");
    },
    showForm: function(){
        App.modal.show("experience-modal");
        this.checkForm();
    },
    showFormData:function(data){
        let form = {id: "", title: "", org_id: 0, description: "", has_start_date: false, has_finish_date: false, started: {year: 0, month: 0, day: 0}, finished: {year: 0, month: 0, day: 0}};
        if(typeof data != "undefined" && App.getType(data) == 'object'){
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const val = data[key];
                    if(form.hasOwnProperty(key)){
                        if(key == "started" || key == "finished"){
                            if(App.getType(val) == "object"){
                                if(val.hasOwnProperty("day") && val.hasOwnProperty("month") && val.hasOwnProperty("year")){
                                    form[key] = val;
                                }
                            }
                        }else{
                            form[key] = val;
                        }
                    }
                }
            }
        }

        let exid = "experience";
        $("#"+exid+"-id").val(form.id);
        $("#"+exid+"-title").val(form.title);
        $("#"+exid+"-description").val(form.description);

        App.htmlSelect.active("org_id", form.org_id);

        App.htmlSelect.active("started-day", form.started.day);
        App.htmlSelect.active("started-month", form.started.month);
        App.htmlSelect.active("started-year", form.started.year);

        App.htmlSelect.active("finished-day", form.finished.day);
        App.htmlSelect.active("finished-month", form.finished.month);
        App.htmlSelect.active("finished-year", form.finished.year);

        if(form.has_start_date){
            $('#experience-has-start-date').prop('checked', true);
            if(form.has_finish_date){
                $('#experience-has-finish-date').prop('checked', true);
            }else{
                $('#experience-has-finish-date').prop('checked', false);
            }
        }else{
            $('#experience-has-start-date').prop('checked', false);
            $('#experience-has-finish-date').prop('checked', false);

        }
        App.modal.show("experience-modal");
        this.checkForm();
    },
    parseData: function(data){
        var self = this;
        data.timeinfo = '';
        if(data.has_start_date){
            data.timeinfo = data.started.day + '/' + data.started.month + '/' + data.started.year + ' - ';
            if(data.has_finish_date){
                data.timeinfo += data.finished.day + '/' + data.finished.month + '/' + data.finished.year
            }else{
                data.timeinfo += "Hiện tại";
            }
        }
        data.timetitle = data.title;
        if(data.org_name){
            data.timetitle += " - tại: "+data.org_name;
        }
        return data;
    },
    addItem:function(data){
        $('.crazy-timeline .timeline-body').append(App.str.eval(this.template, data));
        this.updateItemsClass();
    },
    updateInfo:function(id, data){
        let $item = $('#crazy-timeline-item-'+id);
        if($item.length){
            $item.find('.m--font-brand').html(data.timeinfo);
            $item.find('.m-timeline-1__item-title').html(data.timetitle);
            $item.find('.m-timeline-1__item-body').html(data.description);
        }
    },

    updateItemsClass: function(){
        // m-timeline-1__item--left m-timeline-1__item--first
        let $itens = $('.crazy-timeline .timeline-body .crazy-timeline-item');
        if($itens.length){
            $itens.each(function(index, element){
                $(element).removeClass(['m-timeline-1__item--left', 'm-timeline-1__item--right', 'm-timeline-1__item--first']);
                if(index == 0){
                    $(element).addClass('m-timeline-1__item--first');
                }
                $(element).addClass('m-timeline-1__item--'+(index % 2 == 0 ? 'left': 'right'));
            });
        }
    },
    delete: function(id){
        var self = this;
        let item = $('#crazy-timeline-item-'+id);
        if(item.length){
            App.Swal.confirm('Bạn có chắc chắn muốn xóa '+item.data('title')+' không?', function () {

                    ajaxRequest(self.urls.delete_url, "DELETE", {id:id},function(rs){
                        if(rs.status){
                            item.remove();
                            self.updateItemsClass();
                        }else{
                            App.Swal.warning(rs.message);
                        }
                    }, function(err){
                        App.Swal.error("Lỗi không xác định");
                    });

            });
        }
    }

};

$(function(){
    if(typeof profile_experiences == 'object'){
        Profile.experiences.init(profile_experiences);
    }
    else if(typeof profile_data == 'object'){
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof profile_data[act+"_experience_url"] == "string"){
                urls[act+"_url"] = profile_data[act+"_experience_url"];
            }
        }

        Profile.experiences.init({
            urls:urls
        });
    }

});
