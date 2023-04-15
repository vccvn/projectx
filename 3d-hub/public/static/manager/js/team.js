$(function(){
    const TeamManager = function(options) {
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

            $(document).on('click', '.btn-view-team-detail', function(){
                self.getDetail($(this).data('id'), function(team){
                    self.showDetail(team);
                });
                return false;
            });

            $(document).on('click', '.modal .btn-add-member', function(){
                self.showFormData({team_id:self.id});
                return false;
            });

            $(document).on('click', '.btn-delete-member', function(){
                let $this = $(this);
                let id = $this.data('id');
                let item = $('#member-item-'+id);
                let message = "bạn có chắc chắn muốn xía " + (item.length ? item.data('name'): "thành viên này") + " ra khỏi nhóm?";
                App.modal.confirm(message, function(stt){
                    // if(stt){
                        showLoading();
                        ajaxRequest(self.urls.delete_member, "DELETE", {id:id}, function(rs){
                            hideLoading();
                            if(rs.status){
                                item.remove();
                            }
                            App.modal.show('team-modal');

                        }, function(error){
                            hideLoading();
                            App.modal.show('team-modal');
                            
                        });
                    // }
                }, function(){
                    App.Swal.show('team-modal');
                });
                return false;
            });
            
            
            $(document).on('click', '.btn-edit-member', function(){
                showLoading();
                ajaxRequest(self.urls.member_detail, "get", {id:$(this).data('id')}, function(rs){
                    hideLoading();
                    if(rs.status){
                        self.showFormData(rs.data);
                    }
                    else{
                        let message = rs.message;
                        
                        App.Swal.error(message, null, function(){
                            self.showForm();
                        });
                    }
                }, function(error){
                    hideLoading();
                    App.Swal.error("Lỗi không xác định. Vui lòng thử lại sau giay lát", null, function(){
                        self.showForm();
                    });
                });
                return false;
            });
            
            $('#add-team-member-form').submit(function(e){
                e.preventDefault();
                let data = $(this).serialize();
                App.modal.hide();
                showLoading();
                ajaxRequest($(this).attr('action'), "POST", data, function(rs){
                    hideLoading();
                    if(rs.status){
                        self.getDetail(self.id, function(team){
                            self.showDetail(team);
                        });
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
                    App.Swal.error("Lỗi không xác định. Vui lòng thử lại sau giay lát", null, function(){
                        self.showForm();
                    });
                });
                return false;
            })
            //
        };

        /**
         * lấy thông tin team
         * @param {int} id mã team
         * @param {function} callback ham se duoc goi khi lay data thanh cong
         * @return {void}
         */
        this.getDetail = function(id, callback){
            this.id = id;
            showLoading();
            ajaxRequest(this.urls.detail, "GET", {id:id}, function(rs){
                hideLoading();
                if(rs.status){
                    if(typeof callback == "function"){
                        callback(rs.data);
                    }
                }else{
                    App.Swal.warning(rs.message);
                }
            }, function(err){
                App.Swal.error("Lỗi không xác định");
            });
        };

        this.showDetail = function(data){
            $('#team-modal-title span').html(data.name);
            let members = "";
            let leader = "";
            if(data.members){
                data.members.map(function(member){
                    if(member.is_leader && !leader){
                        leader = member.name;
                    }
                    members += App.str.eval(self.template, member);
                    
                });
                
            }
            if(!leader) leader = "Chưa có";
            $('#team-leader-info').html(leader);
            $('#team-member-list').html(members);
            
            App.modal.show('team-modal');
        }

        this.showForm = function(){
            App.modal.show('team-member-modal', null, function(){
                App.modal.show('team-modal');
            });
        };

        this.showFormData = function(data){
            let form = {id: "", team_id: 0, member_id: 0, job: "", is_leader: 0};
            if(typeof data != "undefined" && App.getType(data) == "object"){
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const value = data[key];
                        form[key] = value;
                    }
                }
            }
            $("#team-member-id").val(form.id);
            $("#team-id").val(form.team_id);
            $("#team-member-job").val(form.job);
            $('#team-leader').prop('checked', form.is_leader ? true : false);
            App.htmlSelect.ajaxSearch('member_id', form.member_id, function(){
                App.htmlSelect.active('member_id', form.member_id);
            });
            let submitText = form.id ? "Cập nhật" : "Thêm";
            $('#member-btn-submit').html(submitText);
            self.showForm();
            
        }

    };






    let options = {};
    if(typeof team_data == 'object'){
        options = team_data;
    }
    else if(typeof crazy_data == 'object'){
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if(typeof crazy_data[act+"_team_url"] == "string"){
                urls[act+"_url"] = crazy_data[act+"_team_url"];
            }
        }
        options.urls = urls;
    }

    let tpl = $('.member-item-template');
    if(tpl.length){
        options.template = tpl.text();
        tpl.remove();
    }

    let team = new TeamManager(options);
    team.init();
    window.team = team;
});
