
// giỏ hàng
App.extend({
    subcribes: {
        urls: {},
        init_list: ["urls"],
        subcribe: function (email) {
            return App.ajax(this.urls.subcribe, {
                method: "POST",
                dataType: "json",
                data: {email:email}
            }).then(function (result) {
                if(result.status){
                    App.popup.alert("Đăng ký theo dõi thành công!");
                    return true;
                }else{
                    var message = '';
                    if(result.errors){
                        var errors = result.errors;
                        var messages = [];
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                const error = errors[key];
                                messages.push(error);
                            }
                        }
                        message = messages.join("<br>");
                    }else{
                        message = result.message;
                    }
                    App.popup.alert(message);
                }
            }).catch(function(err){
                App.popup.alert("Lỗi không xác định");
            });

        }
    }
    // end subcribes
});


if (typeof window.subcribeInit == "function") {
    if (typeof window.subcribeInit == "function") {
        window.subcribeInit();
    }
    var subcribeForm = $(prefixClass+"subcribe-form");
    if(subcribeForm.length){
        subcribeForm.submit(function (e) {
            e.preventDefault();
            var self = this;
            App.subcribes.subcribe($(this).find('input[name="email"]').val())
            .then(function(res){
                $(self).find('input[name="email"]').val("");
            });
            return false;
        });
    }

}

