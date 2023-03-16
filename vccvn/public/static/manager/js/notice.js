App.noticeForm = {
    checkType: function(type){
        if(type=='personal'){
            this.showSelectUser();
            this.hideSelectGroup();
        }
        else if(type=='group'){
            this.showSelectGroup();
            this.hideSelectUser();
        }
        else{
            this.hideSelectUser();
            this.hideSelectGroup();
        }
    },
    showSelectUser:function(){
        $('#to_id-form-group').removeClass('d-none');
    },
    hideSelectUser:function(){
        $('#to_id-form-group').addClass('d-none');
    },
    showSelectGroup:function(){
        $('#to_group-form-group').removeClass('d-none');
    },
    hideSelectGroup:function(){
        $('#to_group-form-group').addClass('d-none');
    }
    
};

$(function(){
    if($('#notices-create, #notices-update').length){
        var $type = $('form input#type');
        if($type.length){
            App.noticeForm.checkType($type.val());
        }
    }
});