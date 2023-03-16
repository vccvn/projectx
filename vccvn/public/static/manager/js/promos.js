!function () {
    const Promo = function (options) {
        this.urls = {};
        
        this.init_list = ["urls", "template", "list"];
        this.options = options;
        var self = this;
        var $form = $('form[class*="promo"]');
        var productGroups = $('#map_id-form-group,#products-form-group');
        var porderGroups = $('#limited_total-form-group');
        var userGroup = $('#user_list-form-group,#quantity_per_user-form-group');
        /**
         * init
         * @param {object} args 
         */
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };

        this.onChangeType = function(value){
            this.checkFormData();
        };
        this.onChangeRef = function(value){
            this.checkFormData();
        }

        this.checkFormData = function(){
            var dataStr = $form.serialize();
            var data = JSON.parse('{"' + dataStr.replace(/&/g, '","').replace(/=/g,'":"') + '"}', function(key, value) { return key===""?value:decodeURIComponent(value) })
            if(data.scope == "product"){
                if(data.type == "2"){
                    $('#radio-inp-type--0').prop("checked", true);
                }
                $('#radio-label-type--2').addClass('d-none');
                porderGroups.addClass('d-none');
                userGroup.addClass('d-none');
                productGroups.removeClass('d-none');
                
            }else if(data.scope == "user"){
                $('#radio-label-type--2').removeClass('d-none');
                productGroups.addClass('d-none');
                porderGroups.addClass('d-none');
                userGroup.removeClass('d-none');
            }else{
                $('#radio-label-type--2').removeClass('d-none');
                productGroups.addClass('d-none');
                userGroup.addClass('d-none');
                porderGroups.removeClass('d-none');
                
            }
        };

        
        this.onStart = function () {
            this.checkFormData();
        };
    };




    let options = {};
    if (typeof promo_data == 'object') {
        options = promo_data;
    }
    if (typeof crazy_data == 'object') {
        let urls = {};
        let list = ["add", "create", "update", "detail", "delete", "sort"];
        for (let i = 0; i < list.length; i++) {
            const act = list[i];
            if (typeof crazy_data[act + "_promo_url"] == "string") {
                urls[act + "_url"] = crazy_data[act + "_promo_url"];
            }
        }
        options.urls = urls;
    }
    let promos = new Promo(options);
    promos.init();
    if (typeof Crazy != "object") {
        Crazy = {};
    }
    App.promos = promos;

}();
