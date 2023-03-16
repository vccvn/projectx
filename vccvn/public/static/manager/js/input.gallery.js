function InputGallery(selector) {
    var $gallery = $(selector);
    var template = $gallery.find('.template').text();
    var $galleryImages = $gallery.find('.gallery-images');
    var $hiddenGroup = $gallery.find('.gallery-hidden-input-group');
    var hiddenImageName = $gallery.data('name')+'[]';
    var $addBtn = $gallery.find(".button-add");
    var self = this;

    $gallery.find('.template').remove();

    this.init = function () {
        if(!$galleryImages.find('.dz-preview').length){
            $galleryImages.hide();
        }
        
        $galleryImages.on('click', '.btn-remove-file', function(){
            self.remove($(this).data('id'));
        });
        $addBtn.on("click", function(e){
            var selected = [];
            $hiddenGroup.find("input").each(function(i, el){
                selected.push($(el).val());
            });
            App.library.open({
                modal: null,
                mode: "many",
                preview: false,
                type: 'image',
                // selected: selected,
                done: function (files) {
                    self.addFiles(files);
                }
            })
        })
    };

    this.addFiles = function(files){
        /**
         * @var {Element}
         */
        var addButton = $addBtn[0];

        var list = [];
        for (var i = 0; i < files.length; i++) {

            const file = files[i];

            // let id = 'crazy-' + App.str.rand();
            
            list.push(file.id);
            let item = App.str.eval(template, file);
            // $galleryImages.append(item);
            $addBtn.before(item);
            $hiddenGroup.append('<input type="hidden" name="' + hiddenImageName + '" id="hidden-input-gallery-image-' + file.id + '" value="'+ file.id + '">')
            $galleryImages.show();

        }
        // $hiddenGroup.find("input").each(function(i, el){
        //     var id = $(el).val();
        //     if(list.indexOf(id)<0) self.remove(id);
        // });
        

    }
    this.parseSise = function(originSize, level){
        if(!level) level = 0;
        var unit_level = ["B", "KB", "MB", "GB", "TB"];
        var size = originSize;
        if(size){
            if(size >= 1024){
                return this.parseSise(parseInt(size*10/1024)/10, level+1);
            }
        }
        // cl(size)
        return {
            size:size,
            size_unit:unit_level[level]
        };
    };
    this.remove = function(id){
        $galleryImages.find('#input-gallery-image-'+id).hide(300, function(){
            $(this).remove();
            setTimeout(function(){
                if(!$galleryImages.find('.dz-preview').length){
                    $galleryImages.hide();
                }
            }, 100);
        });
        $hiddenGroup.find('#hidden-input-gallery-image-'+id).remove();
    }
}

App.galleryInput = {
    list:{},
    add: function (selector){
        var $el = $(selector);
        if($el.length){
            let $select = new InputGallery($el[0]);
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
    var $cs = $('.input-gallery');
    if($cs.length){
        $cs.each(function(i, el){
            App.galleryInput.add(el);
        });
    }
});