if(typeof Profile == "undefined"){
    var Profile = {};
}

Profile.works = {
    urls: {},
    id: 0,
    template: "",
    init_list: ["urls"],

    init: function(args) {
        App.setDefault(this, args || this.options);
        
    },
    showAddForm:function(name, success) {
        var self = this;
        App.modal.popup({
            size: 'md',
            title: "Thêm nghề nghiệp",
            btnDone:"Thêm",
            inputs: {
                title:{
                    type: "text",
                    label: "Tên công việc",
                    placeholder: "Nhập tên",
                    value:name,
                    validate: function(val){
                        return (val.length > 0);
                    }
                },
                work_group: {
                    type: "select",
                    label: "Nhóm công việc",
                    data: {
                        it: "Công nghệ thông tin",
                        office: "Văn phòng",
                        other: "khác"
                    }
                },
                description: {
                    type: "textarea",
                    label: "Mô tả công việc",
                    placeholder: "Nhập mô tả"
                }
            },
            done: function(data){
                ajaxRequest(self.urls.add_url, "POST", data, function(rs){
                    if(rs.status){
                        App.htmlSelect.addOption('work_id', rs.data.id, rs.data.title);
                        if(typeof success == "function"){
                            success(rs.data);
                        }
                    }else{
                        App.Swal.error(rs.message, function(){
                            // App.modal.hide_callback = function(){
                            //     App.modal.show("popup-modal");
                            // };
                        });
                    }
                }, function(e){
                    App.Swal.error("lỗi ko xác định", function(){
                        // App.modal.hide_callback = function(){
                        //     App.modal.show("popup-modal");
                        // };
                    });
                })
            }
        })
    }
    
};

$(function(){
    if(typeof profile_works == 'object'){
        Profile.works.init(profile_works);
    }
    else if(typeof profile_data == 'object'){
        if(typeof profile_data.add_work_url == "string"){
            Profile.works.init({
                urls:{
                    add_url: profile_data.add_work_url
                }
            });
        }
    }


});