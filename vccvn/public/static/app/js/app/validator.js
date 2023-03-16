

var Validator = {

    rules: {
        required: function (value) {
            return typeof value == "undefined" ? undefined : ((isString(value) || isArray(value)) ? value.length > 0 : true);
        },
        email: function (value) {
            return typeof value == "undefined" ? undefined : (isString(value) && isEmail(value));
        },
        number: function (value) {
            return typeof value == "undefined" ? undefined : isNumber(value);
        },
        array: function (value) {
            return typeof value == "undefined" ? undefined : isArray(value);
        },
        min: function (value, params) {
            if (typeof value == "undefined") {
                return undefined;
            } else if (!isNumber(value)) {
                return 0;
            } else if (typeof params == "undefined" || !isArray(params) || !params.length || !isNumber(params[0])) {
                return null;
            }
            return parseFloat(value) >= parseFloat(params[0]);
        },
        max: function (value, params) {
            if (typeof value == "undefined") {
                return undefined;
            } else if (!isNumber(value)) {
                return 0;
            } else if (typeof params == "undefined" || !isArray(params) || !params.length || !isNumber(params[0])) {
                return null;
            }
            return parseFloat(value) <= parseFloat(params[0]);
        },
        not: function (value, params) {
            if (typeof value == "undefined") {
                return undefined;
            } else if (typeof params == "undefined" || !isArray(params) || !params.length) {
                return null;
            }
            for (var i = 0, val = params[i]; i < params.length; i++) {
                if (value === val) return false;
            }
            return true;
        },
        equalTo: function (value, params) {
            if (typeof value == "undefined") {
                return undefined;
            } else if (typeof params == "undefined" || !isArray(params) || !params.length) {
                return null;
            }
            for (var i = 0, val = params[i]; i < params.length; i++) {
                if (value === val) return true;
            }
            return false;
        },
        minlength: function (value, params) {
            if (typeof value == "undefined") {
                return undefined;
            } else if (typeof params == "undefined" || !isArray(params) || !params.length || !isNumber(params[0])) {
                return null;
            }
            return String(value).length >= parseFloat(params[0]);
        },
        maxlength: function (value, params) {
            if (typeof value == "undefined") {
                return undefined;
            } else if (typeof params == "undefined" || !isArray(params) || !params.length || !isNumber(params[0])) {
                return null;
            }
            return String(value).length <= parseFloat(params[0]);
        },
        mimes: function (value, params) {
            if (typeof value == "undefined") {
                return undefined;
            } else if (typeof params == "undefined" || !isArray(params) || !params.length) {
                return null;
            }
            for (let i = 0; i < params.length; i++) {
                const v = params[i];
                if (value == v) return true;
            }
            return false;
        }
    },
    messages: {
        required: ":label Không được bỏ trống",
        email: ":label không đúng định dạng email",
        number: ":label phải là số",
        min: ":label phải nhỏ hơn :params",
        min_number: ":label không phải là số",
        min_null: "Tham số validate.min không hợp lệ",
        max: ":label phải lớn hơn :params",
        max_number: ":label không phải là số",
        max_null: "Tham số validate.max không hợp lệ",
        minlength: ":label phải chứa tối thiểu :params ký tự",
        minlength_null: "Tham số validate.minlength không hợp lệ",
        maxlength: ":label không được vượt quá :params ký tự",
        maxlength_null: "Tham số validate.maxlength không hợp lệ",
        not: ":label phải khác :params",
        not_null: "Tham số validate.maxlength không hợp lệ",
        equalTo: ":label phải nằm trong các giá trị :params",
        equalTo_null: "Tham số validate.equalTo không hợp lệ",
    },
    currentMessages: {},
    /**
     * 
     * @param {string|object} rule teên rule
     * @param {function} func hàn thực thi
     * @param {string} message thông báo looi64
     */
    extend: function (rule, func, message) {
        if (!rule) return;
        if (isObject(rule)) {
            if (typeof rule.name == "string" && typeof rule.rule == "function") {
                this.rules[rule.name] = rule.rule;
                if (typeof rule.message == "string") this.messages[rule.name] = rule.message;
            } else {
                for (const n in rule) {
                    if (rule.hasOwnProperty(n)) {
                        const r = rule[n];
                        if (isObject(r) || isCallable(r)) {
                            this.extend(n, r);
                        }
                    }
                }
            }
            return;
        }
        if (isCallable(rule) && rule.name) {
            this.rules[rule.name] = rule;
            return;
        }
        if (!isString(rule)) return;
        if (!func) return;
        if (isCallable(func)) {
            this.rules[rule] = func;
            if (typeof message == "string") this.messages[rule] = message;
            return;
        }
        if (!isObject(func)) return;
        if (typeof func.rule != "function") return;
        this.rules[rule] = func;
        if (typeof func.message == "string")
            this.messages[rule] = func.message;
    },
    /**
     * lấy về đối tượng chứ các tên hàm được gán kèm tham số
     * @param {string} str chuỗi rule gồm tên và tham số
     */
    parseRule: function (str) {
        if (!str) return null;
        var rule = App.str.replace(str, " ", "").split("|");
        var rules = {};
        var paramStr, params, ruleName = "";

        for (let i = 0; i < rule.length; i++) {
            const rp = rule[i];
            if (rp.length == 0) continue;
            var st = rp.indexOf(":");
            if (st < 1 || st == rp.length - 1) {
                var rn = App.str.replace(rp, ":", "0");
                rules[rn] = { rule: rn, str_params: "", params: [] };
                continue;
            }
            var rps = rp.split(":");
            ruleName = rps[0];
            paramStr = rps[1];
            params = paramStr.split(",");
            rules[ruleName] = {
                rule: ruleName,
                str_params: paramStr,
                params: params
            };
        }
        return rules;
    },
    /**
     * lấy thông báo lỗi
     * @param {string} slug key truy cập data hoặc rule, mwssage
     * @param {string} rule tên rule
     * @param {string} ruleExt phần mở rộng
     * @param {string} label nhãn input
     * @param {strimh} params tham số của rule dạng chuỗi
     * @param {Element} elem 
     * @returns {string}
     */
    parseMessage: function (slug, rule, ruleExt, label, params, elem) {
        var msg = "";
        if (!slug || !isString(slug)) return "";
        ruleExt = ruleExt ? rule + "_" + ruleExt : rule;
        if (!rule) msg = this.currentMessages[slug] || "";
        else if (this.currentMessages[slug + "_" + rule]) msg = this.currentMessages[slug + "_" + rule];
        else if (this.currentMessages[slug]) msg = this.currentMessages[slug];
        else if (this.messages[ruleExt]) msg = this.messages[ruleExt];
        else if (this.messages[rule]) msg = this.messages[rule];
        label = label || slug;
        params = params || label;
        return App.str.replace(msg, { ":label": label, ":params": String(params) });
    },
    /**
     * lấy đói tượng validator
     * @param {object} data dữ liệu lấy từ form
     * @param {object} rules các rule dưới dạng chuỗi key:"rule:tham số"
     * @param {object} messages thông báo lỗi
     */
    make: function (data, rules, messages) {
        rules = (rules && isObject(rules)) ? rules : null;
        var validate = {
            status: true,
            messages: [],
            errors: {},
            errorMap: {},
            errorData: {},
            fields: {},
            allMessage: function(){
                var list = [];
                for (const key in this.errors) {
                    if (this.errors.hasOwnProperty(key)) {
                        const msg = this.errors[key];
                        list.push(msg);
                    }
                }
                return list;
            }
        };
        if (!rules) return validate;
        var firstError = function () {
            for (const rk in this.errors) {
                if (this.errors.hasOwnProperty(rk)) {
                    const mess = this.errors[rk];
                    if (isArray(mess)) {
                        if (mess.length) return mess[0];
                    } else {
                        return mess;
                    }

                }
            }
            return "";
        }
        var getMessage = function (ruleKey, index) {
            var isKey = typeof ruleKey == "string" && ruleKey.length;
            var IsIndex = typeof index == "undefined" && isNumber(index);
            var list = [];
            for (const rk in this.errors) {
                if (this.errors.hasOwnProperty(rk)) {
                    const mess = this.errors[rk];
                    if (isArray(mess)) {
                        if (isKey && ruleKey == rk) {
                            if (IsIndex) {
                                if (typeof mess[index] != "undefined") {
                                    return mess[index];
                                }
                                return "";
                            } else {
                                return mess.join(", ");
                            }
                        } else {
                            list.push(mess.join(", "));
                        }
                    } else {
                        if (isKey && ruleKey == rk) {
                            return mess;
                        } else {
                            list.push(mess);
                        }
                    }
                }
            }
            return list;
        };
        var addFieldError = function (field, name, rule, message) {
            if(!(field instanceof Element)) return;
            name = name || field.name;
            if (typeof validate.fields[name] == "undefined") {
                validate.fields[name] = {
                    field: field,
                    errors: {},
                    firstError: firstError,
                    getMessage: getMessage
                }
            }
            validate.fields[name].errors[rule] = message;
        };
        this.currentMessages = (messages && isObject(messages)) ? deepCopy(this.messages, messages) : this.messages;
        isEmptyData = typeof data != "object";
        for (const name in rules) {
            if (rules.hasOwnProperty(name)) {
                var input = data[name] || null;
                const ruleStr = rules[name];
                var ruleObj = this.parseRule(ruleStr);
                if (ruleObj) {
                    var isRequired = (typeof ruleObj.required != "undefined");

                    // nếu data trống
                    if (isEmptyData) {
                        if (isRequired) {
                            validate.status = false;
                            var msg = this.parseMessage(name, "required");
                            if (msg) {
                                validate.messages.push(msg);
                                validate.errors[name] = msg;

                            }
                        }
                    }
                    else if (isRequired && (typeof data[name] == "undefined" || !this.rules.required(data[name].value))) {
                        validate.status = false;
                        var msg = this.parseMessage(name, "required", null, input ? (input.label || input.name) : null);
                        if (msg) {
                            validate.messages.push(msg);
                            validate.errors[name] = msg;
                            validate.errorMap[name + "_required"] = msg;
                            if (typeof validate.errorData[name] == "undefined") validate.errorData[name] = {};
                            validate.errorData[name].required = msg;
                            if (input) {
                                addFieldError(input.el, nameR, "required", msg);
                            }
                        }

                    } 
                    else {
                        // duyệt qua các mãng chứa rules
                        for (const ruleKey in ruleObj) {
                            if (ruleObj.hasOwnProperty(ruleKey)) {
                                const ruleData = ruleObj[ruleKey];
                                var f = ruleData.rule;
                                var check = true;
                                if (f != "required" && typeof this.rules[f] == "function") {
                                    if (name.lastIndexOf("*") == NamedNodeMap.length - 1 && isArray(input.value) && f != "array") {
                                        var ts = true;
                                        var nameR = name.substring(0, name.length - 2);
                                        for (let n = 0; n < input.value.length; n++) {
                                            const v = input.value[n];
                                            var ruleExt;
                                            var nameN = nameR + "." + n;
                                            check = this.rules[f].call(this.rules, v, ruleData.params, input ? input.el : null);
                                            if (!check) {
                                                ts = false;
                                                ruleExt = typeof check == "undefined" ? "undefined" : getType(check);
                                                var msg = this.parseMessage(nameN, f, ruleExt == "boolean" ? null : ruleExt, input.label || input.name, ruleData.str_params, input.el);
                                                if (msg) {
                                                    if (validate.messages.indexOf(msg) < 0) validate.messages.push(msg);
                                                    // validate.errors[nameN] = msg;
                                                    if (typeof validate.errorData[nameR] == "undefined") {
                                                        validate.errorData[nameR] = {};
                                                    }
                                                    if (typeof validate.errorData[nameR][n] == "undefined") {
                                                        validate.errorData[nameR][n] = {};
                                                    }
                                                    validate.errorData[nameR][n][f] = msg;
                                                    validate.errorMap[nameR + '_' + n + "_" + "_" + f] = msg;
                                                }
                                                validate.status = false;
                                            }
                                        }
                                        if (!ts) {
                                            var msg = this.parseMessage(name, f, ruleExt == "boolean" ? null : ruleExt, input.label || input.name, ruleData.str_params, input.el);
                                            if (msg) {
                                                if (validate.messages.indexOf(msg) < 0) validate.messages.push(msg);
                                                addFieldError(input.el, nameR, f, msg);
                                                validate.errors[name] = msg;
                                                // validate.errors[nameR] = msg;
                                                validate.errorMap[nameR + "_" + f] = msg;
                                                if (typeof validate.errorData[nameR] == "undefined") {
                                                    validate.errorData[nameR] = {};
                                                }
                                                validate.errorData[nameR][f] = msg;

                                            }


                                        }
                                    } // if end of name  
                                    else {
                                        check = this.rules[f].call(this.rules, input.value, ruleData.params, input ? input.el : null);
                                        if (!check) {
                                            if ((check === undefined || input.value.length == 0) && !isRequired) {
                                                // không làm gì cả
                                            }
                                            else {
                                                var ruleExt = typeof check == "undefined" ? "undefined" : getType(check);
                                                var msg = this.parseMessage(name, f, ruleExt == "boolean" ? null : ruleExt, input.label || input.name, ruleData.str_params, input.el);
                                                if (msg) {
                                                    validate.messages.push(msg);
                                                    addFieldError(input.el, name, f, msg);
                                                    validate.errors[name] = msg;
                                                    validate.status = false;

                                                    if (typeof validate.errorData[name] == "undefined") {
                                                        validate.errorData[name] = {};
                                                    }
                                                    validate.errorData[name][f] = msg;
                                                    validate.errorMap[name + '_' + f] = msg;
                                                }

                                            }
                                        } // end if check fail
                                    } // end if end name condition
                                } // end if rule in rule object is function
                            } // end if rule has own property (by key)
                        } // end for in rule object
                    } // end if rule item and data condition
                } // end if rule objext available
            } // end if has own property
        } // end for in rules
        return validate;
    }
};

App.validator = App.prototype = Validator;
App.validate = App.prototype.validate = function (data, rules, messages, fails) {
    var valid = Validator.make(
        data || null,
        rules || null,
        messages || messages
    );
    if (!valid.status) {
        if (typeof fails == "function") {
            return fails(valid);
        }
        console.log(valid);
    }
    return valid.status;
}