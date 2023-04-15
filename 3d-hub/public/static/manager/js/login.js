
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
            if(typeof auth == "object" && typeof auth.page != "undefined"){
                if(auth.page == 'reset'){
                    x();
                    if(auth.error){
                        var l=e.find(".m-login__forget-password form");
                        l.clearForm(),l.validate().resetForm(),i(l,"danger",auth.error);
                        z();
                    }
                }
                else if(auth.page == 'forgot'){
                    z();
                }
            }
        },
        init:function(){
            l(),
            $("#m_login_signin_submit").click(function(e){
                e.preventDefault();
                var a=$(this),
                    l=$(this).closest("form");
                l.validate({
                    rules:{
                        email:{required:!0},
                        password:{required:!0}
                    }
                }),
                l.valid()&&(
                    a.addClass("m-loader m-loader--right m-loader--light").attr("disabled",!0),
                    // ajaxRequest(auth_urls.login, "post", {a:1}, cl())
                    l.ajaxSubmit({
                        url:auth.login,
                        type:"post",
                        success:function(e,t,r,s){
                            
                            if(e.status){
                                if(e.data.jwt){
                                    if(localStorage && localStorage.setItem){
                                        localStorage.setItem('user', JSON.stringify(e.data.jwt));
                                    }
                                }
                                top.location.href = e.data.redirect;
                                
                            }else{
                                setTimeout(function(){
                                    a.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1),
                                    i(l,"danger","Sai tài khoản hoặc mật khẩu. vui lòng kiểm tra lại")
                                },2e3)
                            }
                            
                        },error:function(){
                            setTimeout(function(){
                                a.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1),
                                i(l,"danger","Lỗi không xác định")
                            },2e3)
                        }
                    })
                )
            }),
            $("#m_login_signup_submit").click(function(l){
                l.preventDefault();
                var t=$(this),
                    r=$(this).closest("form");
                r.validate({rules:{password:{required:!0},token:{required:!0},password_confirmation:{required:!0}}}),
                r.valid()&&(t.addClass("m-loader m-loader--right m-loader--light").attr("disabled",!0),
                r.ajaxSubmit({
                    url:auth.reset,
                    type:"post",
                    success:function(l,s,n,o){
                        if(l.status){
                            setTimeout(function(){
                                t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1),
                                r.clearForm(),
                                r.validate().resetForm(),
                                a();
                                var l=e.find(".m-login__signin form");
                                l.clearForm(),
                                l.validate().resetForm(),
                                i(l,"success","Đặt lại mật khẩu thành công")
                            },1e3)
                        }else{
                            App.modal.error(l.message);
                            t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1)
                        }
                    },
                    error:function(p){
                        App.modal.error("Đã có lỗi bất ngờ xãy ra. Vui lòng thử lại sau giây lát");
                        t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1)
                    }
                }))
            }),
            $("#m_login_forget_password_submit").click(function(l){
                l.preventDefault();
                var t=$(this),
                    r=$(this).closest("form");
                r.validate({rules:{email:{required:!0,email:!0}}}),
                r.valid()&&(t.addClass("m-loader m-loader--right m-loader--light").attr("disabled",!0),r.ajaxSubmit({
                    url:auth.forgot,
                    type:"post",
                    success:function(l,s,n,o){
                        setTimeout(function(){
                            t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1),r.clearForm(),r.validate().resetForm(),a();
                            var l=e.find(".m-login__signin form");
                            l.clearForm(),l.validate().resetForm(),i(l,"success","Email đã được gửi thành công! Hãy kiểm tra hòm thư của bạn để thực hiện đặt lại mật khẩu")
                        },2e3)
                    },
                    error:function(){
                        setTimeout(function(){
                            t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled",!1);
                            App.modal.warning("Lỗi không xác định");
                        },500)
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