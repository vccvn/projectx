var CrazyModule = {
    type:"default",
    url:"",
    init:function(){
        if(typeof crazymodule_data != "undefined"){
            if(typeof crazymodule_data.get_options_url != "undefined"){
                this.url = crazymodule_data.get_options_url;
            }

        }
    },
    changeType:function(type){
        if(type && type != this.type && ["uri", "name", "prefix"].indexOf(type) >= 0){
            this.type = type;
            ajaxRequest(this.url, "GET", {type:type}, function(rs){
                if(rs.status && rs.data){
                    App.htmlSelect.changeOptions('ref', rs.data);
                }
            });
        }
        this.checkType();
    },
    checkType:function(){
        let type = $('input#type').val();
        if(["uri", "name", "prefix"].indexOf(type) >= 0){
            if(!$('#parent_id-form-group').hasClass('d-none')){
                $('#parent_id-form-group').addClass('d-none');
            }
            if($('#ref-form-group').hasClass('d-none')){
                $('#ref-form-group').removeClass('d-none');
            }
        }else{
            if($('#parent_id-form-group').hasClass('d-none')){
                $('#parent_id-form-group').removeClass('d-none');
            }
            if(!$('#ref-form-group').hasClass('d-none')){
                $('#ref-form-group').addClass('d-none');
            }
        }
    }
};

$(function(){
    CrazyModule.init();
    CrazyModule.checkType();
    
    let type = $('input#type').val();
    // CrazyModule.changeType(type);
});