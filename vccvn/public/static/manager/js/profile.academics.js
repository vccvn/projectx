if(typeof Profile == "undefined"){
    var Profile = {};
}

Profile.academics = {
    urls: {},
    id: 0,
    template: "",
    init_list: ["urls"],

    init: function(args) {
        App.setDefault(this, args || this.options);
        
    },
    showAddForm:function(name) {
        var self = this;
        App.modal.popup({
            title: "Thêm Trình độ học vấn",
            btnDone:"Thêm",
            inputs: {
                title:{
                    type: "text",
                    label: "Trình độ",
                    placeholder: "Nhập trình dộ học vấn",
                    value:name,
                    validate: function(val){
                        return (val.length > 0);
                    }
                },
                keywords: {
                    type: "text",
                    label: "Từ khóa",
                    placeholder: "Nhập Từ khóa"
                }
            },
            done: function(data){
                ajaxRequest(self.urls.add_url, "POST", data, function(rs){
                    if(rs.status){
                        App.htmlSelect.addOption('academic_id', rs.data.id, rs.data.title);
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
    if(typeof profile_academics == 'object'){
        Profile.academics.init(profile_academics);
    }
    else if(typeof profile_data == 'object'){
        if(typeof profile_data.add_academic_url == "string"){
            Profile.academics.init({
                urls:{
                    add_url: profile_data.add_academic_url
                }
            });
        }
    }

});