
/**
 * doi tuong quan li item
 * @type {Object}
 */
App.Commands = {
    path: "",
    urls: {},
    commands: {},
    init_list: ["urls", "commands"],

    isCommandRunning: false,
    init: function (args) {
        if (!args || typeof args == 'undefined') return;
        for (var key of this.init_list) {
            if (typeof args[key] != 'undefined') {
                var d = args[key];
                var t = App.getType(d);

                var t2 = (typeof (this[key]) != 'undefined') ? App.getType(this[key]) : "string";
                if ((t == 'array' && t2 == 'array') || (t == 'object' && t2 == 'object')) {
                    for (var k in d) {
                        var v = d[k];
                        this[key][k] = v;
                    }
                } else {
                    this[key] = d;
                }
            }
        }
    },
    change: function (c) {
        var command = $('input#command').val();
        if (typeof this.commands[command] != "undefined") {
            if (this.commands[command][1]) {
                $('input#parameters').prop('disabled', false);
            }
            else {
                $('input#parameters').prop('disabled', true);
            }

        }
    },
    execCommand: function () {
        if (this.isCommandRunning) return App.Swal.warning("Đang xử lý...");
        var self = this;
        var command = $('input#command').val();
        if (typeof this.commands[command] != "undefined") {
            var data = {
                command: command
            };
            if (this.commands[command][1]) {
                var parameters = $('input#parameters').val();
                if (!parameters || parameters.split("&").length > 1) {
                    $('.output-command').append('<div>' + this.commands[command][1] + " is required Parameter</div>");
                    return false;
                } else {
                    data.parameters = parameters;
                }
            }
            var $btn = $('#terminal-form button.btn-go');
            $btn.prop("disabled", true);
            $btn.html("Running...");
            App.api.post(this.urls.command, data).then(function (rs) {
                if (rs.status) {
                    $('.output-command').append('<div>' + App.str.replace(rs.data.result, ["\n", "[nl]", "\r\n"], "<br>") + "</div>");
                } else {
                    $('.output-command').append('<div>' + rs.message + "</div>");
                }
                $btn.prop("disabled", false);
                $btn.html("Go");
                self.isCommandRunning = false;
                $('input#parameters').val("");
            }).catch(function (e) {
                $('.output-command').append('<div>Error</div>');
                $btn.prop("disabled", false);
                $btn.html("Go")
                self.isCommandRunning = false;
                $('input#parameters').val("");
            });

        }
    }

};

$(function () {
    if (typeof window.commandInit == 'function') {
        window.commandInit();
        window.commandInit = null;
    }
    if ($('.crazy-list').length) {
        $(document).on("click", '.btn-show-terminal', function () {
            App.modal.show('command-modal');
        })


    }

    $('#terminal-form').on("submit", function (e) {
        e.preventDefault();
        App.Commands.execCommand();
        return false;
    })


});