
// giỏ hàng
App.extend({
    location: {
        urls: {},
        init_list: ["urls"],
        regionID: 0,
        districtID:0,
        
        changeRegionID: function(value, text, el){
            if(value != this.regionID){
                this.regionID = value;
                App.dom.select.deactive('district_id');
                App.dom.select.deactive('ward_id');
                App.dom.select.changeOptions('district_id', {0: "Chọn một"});
                App.dom.select.changeOptions('ward_id', {0: "Chọn một"});
                if(value && value != "0"){
                    App.ajax(this.urls.district_options, {
                        method: "get",
                        data: {region_id: value},
                        dataType: "JSON"
                    }).then(function(res){
                        if(res.status){
                            App.dom.select.changeOptions('district_id', res.data);
                        }
                    });
                }
            }
        },

        changeDistrictID: function(value, text, el){
            if(value != this.districtID){
                this.districtID = value;
                App.dom.select.deactive('ward_id');
                App.dom.select.changeOptions('ward_id', {0: "Chọn một"});
                if(value && value != "0"){
                    App.ajax(this.urls.ward_options, {
                        method: "get",
                        data: {district_id: value},
                        dataType: "JSON"
                    }).then(function(res){
                        if(res.status){
                            App.dom.select.changeOptions('ward_id', res.data);
                        }
                    });
                }
            }
        }



    }
    // location
});


if (typeof window.locationInit == "function") {
    if (typeof window.locationInit == "function") {
        window.locationInit();
    }
}

