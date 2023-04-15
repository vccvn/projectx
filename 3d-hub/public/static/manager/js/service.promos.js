App.ServicePromos = {
    urls: {},
    services: {},
    id: 0,
    init_list: ["urls", "services"],

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
    changeServiceID:function(id){
        if(typeof this.services[id] != "undefined"){
            var options = this.services[id].options;
            App.htmlSelect.changeOptions('package_id', options);
        }else{
            App.htmlSelect.changeOptions('package_id', {"0": "Tất cả các gói"});
        }
    },
    changeTaskStatus:function (status, elem) {
        // var data = {status:status,id:$(elem).data('task-id')};
        // ajaxRequest(this.urls.change_status_url, "POST", data, function(rs){
        //     cl(rs.status);
        // })
    }
    
};

$(function(){
    var check_selector = '.crazy-list input[type="checkbox"].crazy-check-';
    if(service_package_data !== undefined){
        App.ServicePromos.init(service_package_data);
    } 
});