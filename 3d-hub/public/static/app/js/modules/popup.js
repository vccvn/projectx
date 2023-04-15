App.extend({
    popup: {
        alert: function (message, showCallback, hideCallback) {
            Swal.fire({
                title: "Thông báo",
                text: message,
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
                text: message,
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
                text: message,
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
                text: message,
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
    }
});