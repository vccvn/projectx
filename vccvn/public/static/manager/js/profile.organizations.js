if(typeof Profile == "undefined"){
    var Profile = {};
}

Profile.organizations = {
    urls: {},
    id: 0,
    template: "",
    init_list: ["urls"],

    init: function(args) {
        App.setDefault(this, args || this.options);
    },

    addBusiness:function(name, success){
        this.showAddForm("business", name, success);
    },
    addEducation:function(name, success){
        this.showAddForm("education", name, success);
    },
    showAddForm:function(type, name, success) {
        var self = this;
        var t = type.toLowerCase() == "business" ? "business": "education";
        var labels = {"business":"Doanh nghiệp", "education":"Giáo dục"};
        var label = labels[t];
        App.modal.popup({
            title: "Thêm Tổ chức",
            btnDone:"Thêm",
            inputs: {
                type:{
                    type:"hidden",
                    value:t
                },
                name:{
                    type: "text",
                    label: label,
                    placeholder: "Nhập "+label,
                    value:name,
                    validate: function(val){
                        return (val.length > 0);
                    }
                },
                
                website: {
                    type: "text",
                    label: "trang web",
                    placeholder: "Nhập đường dẩn (không bắt buộc)"
                }
            },
            done: function(data){
                ajaxRequest(self.urls.add_url, "POST", data, function(rs){
                    if(rs.status){
                        App.htmlSelect.addOption('org_id', rs.data.id, rs.data.name);
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
    if(typeof profile_organizations == 'object'){
        Profile.organizations.init(profile_organizations);
    }
    else if(typeof profile_data == 'object'){
        if(typeof profile_data.add_organization_url == "string"){
            Profile.organizations.init({
                urls:{
                    add_url: profile_data.add_organization_url
                }
            });
        }
    }


});