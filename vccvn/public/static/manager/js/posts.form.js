(function () {
    const PostForm = function (options) {
        this.init_list = ["icons", "inputs", "post_type", "use_gallery"];
        this.post_type = 'article';
        this.use_gallery = false;
        this.contentType = "text";
        var self = this;
        /**
         * init
         * @param {object} args 
         */
        this.init = args => {
            App.setDefault(this, args || this.options);
            this.onStart();
        };


        

        this.onStart = function () {
            var contentType = $('#content_type').val();
            self.changePostType(contentType);
            
        };
        
        this.changePostType = function(type){
            this.hideAll();
            $('input#video_url').prop('required', false);
            // $('input#source').prop('required', false);
            if(type == "gallery" || this.use_gallery){
                this.show("gallery");
            }
            else if(type == "video_embed"){
                this.show("video_url");
                $('input#video_url').prop('required', true);
            }else if(type == "news"){
                this.show("source");
            }
        };

        this.hideAll = function(){
            var list = ["video_url", "gallery", "video_embed", "source"];
            for (let index = 0; index < list.length; index++) {
                const field = list[index];
                this.hide(field);
            }
        };

        this.show = function(field){
            $("#"+field + "-form-group").show();
        };
        this.hide = function(field){
            $("#"+field + "-form-group").hide();
        };
        
    };
    
    if(typeof App.posts == "undefined"){
        App.posts = {};
    }
    App.posts.form = new PostForm();
    App.posts.form.hideAll();

    var options = {};
    if(typeof post_data == "object"){
        options = post_data;
    }
    $(function(){
        App.posts.form.init(options);
        
    });

}());