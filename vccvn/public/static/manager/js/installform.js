
var SnippetLogin=function(){
    var e=$("#m_login"),
    i=function(e,i,a){
        var l=$('<div class="m-alert m-alert--outline alert alert-'+i+' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
        e.find(".alert").remove(),l.prependTo(e),mUtil.animateClass(l[0],"fadeIn animated"),l.find("span").html(a)
    },
    a=function(){
        e.removeClass("m-login--forget-password"),
        e.removeClass("m-login--signup"),
        e.addClass("m-login--signin"),
        mUtil.animateClass(e.find(".m-login__signin")[0],"flipInX animated")
    },
    x=function(){
        e.removeClass("m-login--forget-password"),
        e.removeClass("m-login--signin"),
        e.addClass("m-login--signup"),
        mUtil.animateClass(e.find(".m-login__signup")[0],"flipInX animated")
    },
    z=function(){
        e.removeClass("m-login--signin"),
        e.removeClass("m-login--signup"),
        e.addClass("m-login--forget-password"),
        mUtil.animateClass(e.find(".m-login__forget-password")[0],"flipInX animated")
    },
    l=function(){
        $("#m_login_forget_password").click(function(i){
            i.preventDefault(),
            e.removeClass("m-login--signin"),
            e.removeClass("m-login--signup"),
            e.addClass("m-login--forget-password"),
            mUtil.animateClass(e.find(".m-login__forget-password")[0],"flipInX animated")
        }),
        $("#m_login_forget_password_cancel").click(function(e){
            e.preventDefault(),
            a()
        }),
        $("#m_login_signup").click(function(i){
            i.preventDefault(),
            e.removeClass("m-login--forget-password"),
            e.removeClass("m-login--signin"),
            e.addClass("m-login--signup"),
            mUtil.animateClass(e.find(".m-login__signup")[0],"flipInX animated")
        }),
        $("#m_login_signup_cancel").click(function(e){
            e.preventDefault(),
            a()
        })
    };
    return{
        prepare:function(){
            if(typeof install == "object" && typeof install.page != "undefined"){
                if(install.page == 'reset'){
                    x();
                    if(install.error){
                        var l=e.find(".m-login__forget-password form");
                        l.clearForm(),l.validate().resetForm(),i(l,"danger",install.error);
                        z();
                    }
                }
                else if(install.page == 'forgot'){
                    z();
                }
            }
        },
        init:function(){
            l(),
            $("#m_login_signup_submit").click(function(l){
                l.preventDefault();
                var t=$(this),
                    r=$(this).closest("form");
                r.validate({rules:{
                    email:{required:!0},
                    password:{required:!0},
                    password_confirmation:{required:!0}}
                }),
                r.valid()&&(t.addClass("m-loader m-loader--right m-loader--light").attr("disabled",!0),
                r.ajaxSubmit({
                    url:install.create,
                    type:"post",
                    success:function(l,s,n,o){
                        if(l.status){
                            var redirect = l.data.redirect;
                            top.location.href = redirect;
                        }else{
                            App.Swal.error(l.message);
                            t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1)
                        }
                    },
                    error:function(p){
                        App.Swal.error("Đã có lỗi bất ngờ xãy ra. Vui lòng thử lại sau giây lát");
                        t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1)
                    }
                }))
            })
        }
    }
}();
jQuery(document).ready(function(){

    SnippetLogin.init()
    SnippetLogin.prepare();

});
