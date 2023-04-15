App.permissionRoles = {
    urls: {},
    role_id: 0,
    templates: {},
    init_list: ["urls", "role_id"],

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
    save:function(id) {
        var self = this;
        var users = App.tagInput.getData('users');
        ajaxRequest(self.urls.save, "POST", {role_id:self.role_id, users:users}, function(res){
            if(res.status){
                App.modal.success(res.message);
            }else{
                App.modal.warning(res.message);
            }
        }, function(e){
            App.modal.error("Lỗi không xác định. Vui lòng thử lại sau giay lát.");
        });

    }
    
};

$(function(){
    if (typeof window.permissionRolesInit == 'function') {
        window.permissionRolesInit();
        window.permissionRolesInit = null;
    }
    $('.btn-save-user-role').click(function(){
        App.permissionRoles.save();
    });

});