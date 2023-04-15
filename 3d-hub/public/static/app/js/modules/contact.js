//contact
App.extend({
    contact: {
        urls: {},
        init_list: ["urls"],
        // kiểm tra giá sdan3 phẩm kèm thuộc tính
        /**
         * 
         * @param {*} data 
         */
        send: function (form, success, error) {
            var self = this;
            var formData = $(form).serialize();
            var url = self.urls.send_contact_url || $(form).attr('data-ajax-url') || $(form).attr('action');

            var successCallback = typeof success == "function" ? success : function (res) {
                if(res.status){
                    App.popup.success("Bạn đã gữi liên hệ thành công!</br>Chúng tôi sẽ phản hồi trong thời gian sớm nhất");
                    var inps = $(form).find('.inp');
                    if(inps.length){
                        for (let i = 0; i < inps.length; i++) {
                            const inp = inps[i];
                            $(inp).val("");
                        }
                    }
                }else{
                    App.popup.warning("Vui lòng điền đầy đủ thông tin!");
                }
            };
            var errorCallback = typeof error == "function" ? error : function (e) {
                App.popup.error(e.responseText);
            };
            App.ajax(url, {
                method: "post",
                data: formData,
                dataType: "json"
            }).then(successCallback).catch(errorCallback);
        }
    }
    // end cart
});


if (typeof window.contactInit == "function" || typeof window.customcontactInit == "function") {
    if (typeof window.contactInit == "function") {
        window.contactInit();
    }
}

var contactForm = $(prefixClass+"contact-form");
contactForm.submit(function (e) {
    e.preventDefault();
    App.contact.send(this);
});
