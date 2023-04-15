const CrazyGallery = function(selector){
    var $el = $(selector);
    var $editor = null,
        images=[],
        totalResult=0,
        currentPage = 0,
        totalPage =0,
        perpage = 50,
        url = "",
        deleteUrl = "",
        firstLoad = false,
        $message = $el.find('.message'),
        $results = $el.find('.results'),
        $loading = $el.find('.loading'),
        $seemore = $el.find('.results .buttons .btn-see-more'),
        $insertBtn = $('#gallery-modal .btn-insert-images'),
        template = $el.find('.template').text(),
        isGettingData = false,
        editorType = 'tinymce',
        icb = null;
    var $galleryImages = $results.find('.gallery-images');
    $el.find('.template').remove();
    if(typeof gallery_data != "undefined"){
        if(typeof gallery_data.get_file_url != "undefined"){
            url = gallery_data.get_file_url;
        }
        if(typeof gallery_data.delete_file_url != "undefined"){
            deleteUrl = gallery_data.delete_file_url;
        }
    }
    
    var self = this;
    this.init = function(){
        
        $('.btn-toggle-dropzone-gallery').click(function(){
            $('.dropdown-gallery-block').slideToggle();
        });

        $seemore.on('click', function(){
            if(!isGettingData){
                self.getResults();
                $(this).addClass('m-loader m-loader--light m-loader--right');
            }
        });
        $results.on('scroll', function() {
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                if(totalPage > currentPage && !isGettingData){
                    self.getResults();
                    $seemore.addClass('m-loader m-loader--light m-loader--right');
                }
            }
        })
        $galleryImages.on('click', function(e){
            //
            var $btn = $galleryImages.find('.dz-preview .btn-remove-image-file');
            var $e = $(e.target);
            var $image = $galleryImages.find('.dz-preview');
            if($e.is($btn)){
                e.preventDefault();
                e.stopPropagation();
                self.remove($e.data('id'));
            }else if($e.closest($btn).length){
                e.preventDefault();
                e.stopPropagation();
                self.remove($e.closest($btn).data('id'));
            }else{
                var $item = $e.closest($image);
                $item.toggleClass('selected');
            }
        });
        $insertBtn.on('click', function(){
            self.insert();
        });

        // this.getResults();
    };
    this.setUrl = function(newUrl){
        url = newUrl;
    };
    this.open = function(editor, et, cb){
        $editor = editor;
        if(et) editorType = et;
        else{
            editorType ='tinymce';
        }
        icb = cb;
        App.modal.show('gallery-modal');
        if(!firstLoad){
            this.getResults();
            firstLoad = true;
        }
    };
    this.getResults = function(){
        firstLoad = true;
        var data = {
            page: currentPage+1,
            per_page: perpage
        };
        ajaxRequest(url, "GET",data, function(rs){
            $loading.hide();
            if(rs.status){
                totalPage = rs.page_total;
                totalResult = rs.count;
                currentPage = rs.page;
                self.showResults(rs.data);
            }else{
                if($results.find('.dz-preview').length){
                    $results.show();
                    $message.hide();
                }else{
                    $results.hide();
                    $message.show();
                }
            }
            $seemore.removeClass('m-loader m-loader--light m-loader--right');
            if(totalPage == currentPage){
                $seemore.remove();
            }
        });
    };
    this.showResults = function(data){
        if(data != null && data.length){
            for (let i = 0; i < data.length; i++) {
                const image = data[i];
                if(!$('#gallery-image-item-'+image.id).length){
                    $galleryImages.append(App.str.eval(template, image));
                }
            }
            $results.show();
            $message.hide();
            if(currentPage > 1){
                $results.stop().animate({
                    scrollTop: $results[0].scrollHeight
                }, 800);
            }
            
        }
    };
    this.prepand = function(image){
        $galleryImages.prepend(App.str.eval(template, image));
        $results.show();
        $message.hide();
        $loading.hide();
        $results.stop().animate({
            scrollTop: 0
        }, 800);
    };

    this.remove = function(id){
        if(!$('#gallery-image-item-'+id).length) return false;
        var filename = $('#gallery-image-item-'+id).find('.dz-filename span').text();
        var msg = "bạn có chắc chắn muốn xóa file "+ filename + "?"
        var ans = window.confirm(msg);
        if (ans) {
            ajaxRequest(deleteUrl, "POST", { ids: [id] }, function(rs) {
                if (rs.status) {
                    if (rs.data) {

                        for (var i = 0; i < rs.data.length; i++) {
                            var rmid = rs.data[i];
                            $('#gallery-image-item-' + rmid).remove();
                            
                        }

                    }
                    if(rs.errors.length){
                        window.alert(rs.errors.join("\n"));
                    }
                }
                else if(rs.message){
                    window.alert(rs.message);
                }
                else {
                    window.alert("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                }
            });
        }
        
    };
    this.insert = function(){
        var $imageSelect = $galleryImages.find('.dz-preview.selected');
        if(!$imageSelect.length){
            window.alert("Vui lòng chọn một hình ảnh bất kỳ");
        }else if($editor){
            //
            var content = "";


            

            $imageSelect.each(function (i, img) {
                var $im = $(img);
                content += '<figure>'
                    + '<img src="'+$im.data('src')+'" alt="'+$im.data('filename')+'">'
                    + '<figcaption>Hình '+(i+1)+'</figcaption>'
                +'</figure>';
            });

            if(typeof icb == "function"){
                icb($editor, content);
            }else if(editorType == "ckeditor"){
                $imageSelect.each(function (i, img) {
                    var $im = $(img);
                    $editor.insertHtml('<img src="'+$im.data('src')+'" alt="'+$im.data('filename')+'" />');
                })
            }
            else if(!editorType || editorType == "tinymce"){
                $editor.insertContent(content);
            }
            
            
            App.modal.hide("gallery-modal");
            $imageSelect.removeClass('selected');
        }
    };
    
}
$(function(){
    window.GalleryModal = new CrazyGallery('#gallery-modal .gallery-body');
    window.GalleryModal.init();

});