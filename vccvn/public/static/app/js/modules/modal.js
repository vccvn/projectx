App.extened({
    modal: {
        alert: function (message, showCallback, hideCallback) {
            Swal.fire({
                title: message,
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
                confirmButtonText: 'Yes, delete it!'
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