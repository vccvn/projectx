function InputVideo(selector) {
    var $video = $(selector);
    var $input = $video.find('input');
    var $preview = $video.find('.video-preview');
    $preview.hide();
    var self = this;
    var oldUrl = '';
    this.init = function (){
        if($input.val()){
            this.preview($input.val());
        }
        $input.on('change keyup mouseup', function(){
            self.preview($(this).val());
        })
    };
    this.preview = function(url){
        if(url == oldUrl) return false;
        oldUrl = url;
        var video = App.videos.getVideoUrlData(url);
        var embed = '<div class="p-5 text-center">không có thông tin video</div>';
        if(video.embed_url){
            embed = '<p class="mt-3 mb-1">Xem trước:</p><div class="video-responsive" style="max-height: 398px;"><iframe width="640" height="360" src="'+video.embed_url+'&rel=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen=""></iframe></div>';
        }
        $preview.html(embed);
        $preview.show(300);
    };
}

App.inputVideo = {
    list:{},
    add: function (selector){
        var $el = $(selector);
        if($el.length){
            let $select = new InputVideo($el[0]);
            $select.init();
            this.list[$el.data('id')] = $select;
        }
    },
    getTag:function(id){
        if(id){
            if(typeof this.list[id] != "undefined"){
                return this.list[id];
            }
        }
        return null;
    },
    getData:function(id){
        var tag = this.getTag(id);
        if(tag) return tag.getData();
        return [];
    }
};




$(function(){
    var $cs = $('.video-url-input');
    if($cs.length){
        $cs.each(function(i, el){
            App.inputVideo.add(el);
        });
    }
});