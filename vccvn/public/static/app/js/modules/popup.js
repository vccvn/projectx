App.extend({
    popup: {
        alert: function (message, showCallback, hideCallback) {
            Swal.fire({
                title: "Thông báo",
                html: message,
                icon: 'info',
                type: 'info',
                width: 500,
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        },
        warning: function (message, showCallback, hideCallback) {
            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: "Cảnh báo",
                width: 500,
                html: message,
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        },
        error: function (message, showCallback, hideCallback) {
            Swal.fire({
                icon: 'error',
                title: "Ối! Lỗi rồi!...",
                html: message,
                animation: false,
                width: 500,
                customClass: {
                    popup: 'animated tada'
                }
            })
        },
        success: function (message, showCallback, hideCallback) {
            Swal.fire({
                icon: 'success',
                title: "Thành công!",
                html: message,
                animation: false,
                width: 500,
                customClass: {
                    popup: 'animated tada'
                }
            })
        },
        show: function (message, options) {
            Swal.fire({
                title: message,
                width: 500,
                animation: false,
                customClass: {
                    popup: 'animated tada'
                }
            })
        },
        confirm: function (question, callback) {
            Swal.fire({
                title: 'Xác nhận',
                text: question,
                // type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Không',
                confirmButtonText: 'Có',
                animation: false,
                customClass: {
                    popup: 'animated tada'
                },
                width: 500,
            }).then((result) => {
                if (result.value) {
                    if (typeof callback == "function") {
                        callback();
                    }
                }
            })
        }
    },
    Swal: {
        /**
        * Hiển thị thông báo
        * @param {string} message Nội dung thông báo
        * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
        * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
        */
        alert: function (message, callback, hideCallback) {
            Swal.fire({
                title: 'Thông báo',
                html: message,
                type: 'info',
                onBeforeOpen: function onBeforeOpen() {
                    if (typeof callback == "function") {
                        callback();
                    }
                },
                onClose: function onClose() {
                    if (typeof hideCallback == "function") {
                        hideCallback();
                    }
                }
            });
        },


        /**
         * Hiển thị thông tin
         * @param {string} message Nội dung thông báo
         * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
         * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
         */
        info: function (message, callback, hideCallback) {
            Swal.fire({
                title: 'Thông tin',
                html: message,
                type: 'info',
                onBeforeOpen: function onBeforeOpen() {
                    if (typeof callback == "function") {
                        callback();
                    }
                },
                onClose: function onClose() {
                    if (typeof hideCallback == "function") {
                        hideCallback();
                    }
                }
            });
        },


        /**
         * Hiển thị thông báo hành động thành công
         * @param {string} message Nội dung thông báo
         * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
         * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
         */
        success: function (message, callback, hideCallback) {
            Swal.fire({
                title: 'Thành công!',
                html: message,
                type: 'success',
                onBeforeOpen: function onBeforeOpen() {
                    if (typeof callback == "function") {
                        callback();
                    }
                },
                onClose: function onClose() {
                    if (typeof hideCallback == "function") {
                        hideCallback();
                    }
                }
            });
        },


        /**
         * Hiển thị thông báo
         * @param {string} message Nội dung thông báo
         * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
         * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
         */
        warning: function (message, callback, hideCallback) {
            Swal.fire({
                title: 'Cảnh báo!',
                html: message,
                type: 'warning',
                onBeforeOpen: function onBeforeOpen() {
                    if (typeof callback == "function") {
                        callback();
                    }
                },
                onClose: function onClose() {
                    if (typeof hideCallback == "function") {
                        hideCallback();
                    }
                }
            });
        },


        /**
         * Hiển thị thông báo lỗi
         * @param {string} message Nội dung thông báo
         * @param {function} callback hàm sẽ thực thi sau khi hiển thị modal
         * @param {function} hideCallback hàm sẽ thực thi sau khi ẩn modal
         */
        error: function (message, callback, hideCallback) {
            Swal.fire({
                title: 'Lỗi rồi!',
                html: message,
                type: 'error',
                onBeforeOpen: function onBeforeOpen() {
                    if (typeof callback == "function") {
                        callback();
                    }
                },
                onClose: function onClose() {
                    if (typeof hideCallback == "function") {
                        hideCallback();
                    }
                }
            });
        },

        errorDetail: function (title, detail, callback, hideCallback){
            var message = '';
            var tyoe = App.getType(detail);
            if(tyoe == 'string'){
                message = App.str.replace(detail, ['[nl]', "\r\n", "\n" ], '<br />');
            }
            else if(type == 'array'){
                message = detail.map(function(m){
                    return App.str.replace(m, ['[nl]', "\r\n", "\n" ], '<br />');
                }).join('<br />');
            }
            else if(type == 'object'){
                message = Object.keys(detail).map(function(m){
                    return App.str.replace(detail[m], ['[nl]', "\r\n", "\n" ], '<br />');
                }).join('<br />');
            }
            
            return Swal.fire({
                title: title,
                html: message,
                type: 'error',
                onBeforeOpen: function onBeforeOpen() {
                    if (typeof callback == "function") {
                        callback();
                    }
                },
                onClose: function onClose() {
                    if (typeof hideCallback == "function") {
                        hideCallback();
                    }
                }
            });
        },
        

        confirm: function (message, yes, no, callback, hideCallback) {
            Swal.fire({
                title: 'Xác nhận',
                html: message,
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0000FF',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Không',
                onBeforeOpen: function onBeforeOpen() {
                    if (typeof callback == "function") {
                        callback();
                    }
                },
                onClose: function onClose() {
                    if (typeof hideCallback == "function") {
                        hideCallback();
                    }
                }
            }).then(function (result) {
                if (result.value) {
                    if (typeof yes == "function") {
                        yes();
                    }
                } else {
                    if (typeof no == "function") {
                        no();
                    }
                }
            });
        },
        timer: function (timer, message, title, type, button, position) {
            if (!timer) timer = 1500;
            if (!type) type = 'success';
            var option = {
                type: type,
                timer: timer
            };
            if (typeof button != "undefined") {
                if (button === false) {
                    option.showConfirmButton = false;
                } else if (App.isString(button)) {
                    option.confirmButtonText = button;
                }
            }
            if (position) {
                option.position = position;
            }
            if (message) {
                if (!title) {
                    option.title = message;
                    // option.html = message;
                } else {
                    option.title = message;
                    option.html = title;
                }
            }
            Swal.fire(option);
        },

        showLoading: function (timer, title, message) {
            let timerInterval
            if (!timer || isNaN(timer)) {
                if(App.isObject(timer)){
                    //
                }else{
                    
                }
            }
            var getDots = function (t) {
                var dots = '.';
                for (let i = 0; i < t; i++) {
                    dots += '.';

                }
                return dots;
            }
            var n = 0;
            Swal.fire({
                title: 'Đang xử lý',
                html: 'Vui lòng chờ trong giây lát...',
                timer: timer,
                timerProgressBar: true,
                onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        // const content = Swal.getContent()
                        // if (content) {
                        //     const b = content.querySelector('b')
                        //     if (b) {
                        //         b.textContent = getDots(n%5)
                        //         n++;
                        //     }
                        // }
                    }, 100)
                },
                onClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    // console.log('I was closed by the timer')
                }
            })
        },
        hideLoading: function (timer) {
            if (timer && App.isNumber(timer)) {
                setTimeout(function () {
                    Swal.close();
                }, timer);
            } else {
                Swal.close();
            }
        }

    }
});