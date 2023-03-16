    /**
     * doi tuong quan li item
     * @type {object}
     */
    App.extend({
        comments: {
            urls: {},
            init_list: ["urls"],
            form: null,
            send: function (form) {
                var self = this;
                try {
                    let $form = $(form);
                    let data = {};
                    let errors = [];
                    this.form = $form;
                    $form.find('textarea, input, select').each(function (index, el) {
                        let $inp = $(el);
                        let name = $inp.attr('name');
                        if (name != '_token') {
                            let value = $inp.val();
                            data[name] = value;
                        }

                        //cl(el);
                    });
                    let url = $form.data('ajax-url');
                    let btn = $form.find('.post-comment');
                    let btnClass = btn.data('class') || "btn-primary";
                    let btnDisableClass = btn.data('disable-class') || "btn-default";
                    let BtnHtml = btn.html();
                    let sendingText = btn.data('sending-text') || 'Đang gửi liên hệ...';
                    if (btn.length) {
                        btn.prop('disable', true);
                        btn.html(sendingText);
                        btn.removeClass(btnClass).addClass(btnDisableClass);
                        // btn.attr('type', 'button');
                    }

                    App.ajax(url, {
                        method: "post",
                        data: data,
                        cookie: true
                    })
                    .then(function (res) {
                        if(App.isString(res)) res = JSON.parse(res);
                        if (res.status) {
                            self.alert("Bạn đã gửi bình luận thành công! <br />Chúng tôi sẽ phản hồi trong thời gian sớm nhất!", 'success');
                            $(form).find('.inp').each(function (ind, el) {
                                let $inp = $(el);
                                $inp.val('');
                            });

                            $(form).find('.cancel-reply').hide(300, function () {
                                $('input#comment-reply-id').val(0);
                                $(this).parent().parent().removeClass('reply-mode');
                                $(this).parent().remove();
                            });
                        } else {
                            var message = '';
                            if (res.errors) {
                                var messages = [];
                                for (const key in res.errors) {
                                    if (res.errors.hasOwnProperty(key)) {
                                        const error = res.errors[key];
                                        messages.push(error);
                                    }
                                }
                                message = messages.join("<br>");
                            } else {
                                message = res.message;
                            }
                            self.alert(message);
                        }
                        if (btn.length) {
                            btn.prop('disable', false);
                            btn.html(BtnHtml);
                            btn.removeClass(btnDisableClass).addClass(btnClass);
                        }

                    })
                    .catch(function (e) {
                        let msg = e.responseText;
                        self.alert(msg, e.status == 200 ? 'success' : 'danger');
                        if (btn.length) {
                            btn.prop('disable', false);
                            btn.html(BtnHtml);
                            btn.removeClass(btnDisableClass).addClass(btnClass);
                        }
                    });
                }
                catch (e) {

                    self.alert("Đã có lỗi bất ngờ xảy ra. vui lòng thử lại trong giây lát");
                }
            },
            alert: function (message, type) {
                var self = this;
                if (!type) type = 'danger';
                if (self.form.find('#contact-alert-' + type).length) {
                    self.form.find('#contact-alert-' + type).remove();
                }
                let alertTag = '<div id="contact-alert-' + type + '" class="alert alert-' + type + ' mt-4" role="' + type + '">' + message + '</div>';
                self.form.append(alertTag);
                self.form.find('#contact-alert-' + type).show(400);
                setTimeout(function () {
                    self.form.find('#contact-alert-' + type).hide(400, function () {
                        $(this).remove();
                    });
                }, 10000);

            }

        }
    });

$(function(){
    
    var $commentForm = $(prefixClass+'comment-form');
    $(prefixClass+'comment-form').submit(function(e){
        e.preventDefault();
        App.comments.send(this);
        return false;
    });

    
    
    
    $(document).on('click', '.btn-reply-comment, '+prefixClass+"btn-reply-comment", function(){
        let replyID = $(this).data('id');
        let user = $(this).data('reply-for');
        if(replyID){
            $('input#comment-reply-id').val(replyID);
            if(user){
                let txtField = $('.comment-message-content');
                if(txtField.length){
                    let wrapper = txtField.parent();
                    wrapper.addClass('reply-mode');
                    wrapper.find('.reply-item').remove();
                    wrapper.prepend('<div class="reply-item">Trả lời '+user+' <a href="javascripy:void(0);" class="cancel-reply" data-id="'+replyID+'">x</a></div>')
                    if($commentForm.length){
                        $commentForm[0].scrollIntoView(false);
                    }
                }
            }
        }

    });

    $(document).on('click', '.cancel-reply', function(){
        $('input#comment-reply-id').val(0);
        $(this).parent().parent().removeClass('reply-mode');
        $(this).parent().remove();
    });
});
