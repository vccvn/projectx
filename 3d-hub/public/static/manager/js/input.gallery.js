function InputGallery(selector) {
    var $gallery = $(selector);
    var template = $gallery.find('.template').text();
    var $galleryImages = $gallery.find('.gallery-images');
    var $hiddenGroup = $gallery.find('.gallery-hidden-input-group');
    var dragBlock = $gallery.find('.drag-and-drop')[0];
    var inputFile = $gallery.find('input[type=file]')[0];
    var hiddenImageName = $gallery.data('name')+'_data[]';
    var isAdvancedUpload = function () {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();

    var self = this;

    $gallery.find('.template').remove();

    this.init = function () {
        if(!$galleryImages.find('.dz-preview').length){
            $galleryImages.hide();
        }
        // drag&drop files if the feature is available
        if (isAdvancedUpload) {
            $gallery.addClass('has-advanced-upload'); // letting the CSS part to know drag&drop is supported by the browser

            ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function (event) {
                dragBlock.addEventListener(event, function (e) {
                    // preventing the unwanted behaviours
                    e.preventDefault();
                    e.stopPropagation();
                });
            });
            ['dragover', 'dragenter'].forEach(function (event) {
                dragBlock.addEventListener(event, function () {
                    dragBlock.classList.add('is-dragover');
                });
            });
            ['dragleave', 'dragend', 'drop'].forEach(function (event) {
                dragBlock.addEventListener(event, function () {
                    dragBlock.classList.remove('is-dragover');
                });
            });
            dragBlock.addEventListener('drop', function (e) {
                var droppedFiles = e.dataTransfer.files;
                self.addFiles(droppedFiles);

            });
        }

        inputFile.addEventListener('change', function (e) {
            self.addFiles(e.target.files);
        });

        $galleryImages.on('click', '.btn-remove-file', function(){
            self.remove($(this).data('id'));
        });
    };

    this.addFiles = function(files){
        for (var i = 0; i < files.length; i++) {
            (function(file) {
                let fs = self.parseSise(file.size, 0);
                if (file.type.indexOf("image") == 0) {
                    let fileReader = new FileReader();
                    fileReader.onload = function(f) {
                        let src = f.target.result;
                        let id = 'crazy-' + App.str.rand();
                        let data = {
                            id: id,
                            thumbnail: src,
                            url:src,
                            src:src,
                            title: file.name,
                            original_filename: file.name,
                            size: fs.size,
                            size_unit: fs.size_unit    
                        };

                        let item = App.str.eval(template, data);
                        $galleryImages.append(item);
                        $hiddenGroup.append('<input type="hidden" name="' + hiddenImageName + '" id="hidden-input-gallery-image-' + id + '" value="'+ file.name + "@" + data.thumbnail + '">')
                        $galleryImages.show();
                    };

                    fileReader.readAsDataURL(file);
                }
            })(files[i]);
        }
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