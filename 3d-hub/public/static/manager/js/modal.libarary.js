const LibararyModal = function(selector){
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
        $selectBtn = $('#libarary-modal .btn-select-image'),
        template = $el.find('.template').text(),
        previewtemplate = $el.find('.preview-template').text(),
        isGettingData = false,
        editorType = 'tinymce',
        icb = null;
    var $libararyImages = $results.find('.libarary-images');
    $el.find('.template').remove();
    if(typeof libarary_data != "undefined"){
        if(typeof libarary_data.get_file_url != "undefined"){
            url = libarary_data.get_file_url;
        }
        if(typeof libarary_data.delete_file_url != "undefined"){
            deleteUrl = libarary_data.delete_file_url;
        }
    }
    
    var self = this;
    this.init = function(){
        
        $('.btn-toggle-dropzone-libarary').click(function(){
            $('.dropdown-libarary-block').slideToggle();
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
        $libararyImages.on('click', function(e){
            //
            var $btn = $libararyImages.find('.dz-preview .btn-remove-image-file');
            var $e = $(e.target);
            var $image = $libararyImages.find('.dz-preview');
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
                if($item.length){
                    var hasClass = $item.hasClass('selected');
                    if($libararyImages.find('.dz-preview.selected').length){
                        self.clearPreview();
                    }
                    if(hasClass){
                        $item.removeClass('selected');
                    }else{
                        
                        self.unCheckAll();
                        $item.addClass('selected');
                        self.preview($item.data("id"));
                    }
                    
                }
                
            }
        });
        $selectBtn.on('click', function(){
            self.select();
        });

        // this.getResults();
    };
    this.setUrl = function(newUrl){
        url = newUrl;
    };
    this.open = function(callback){
        icb = callback;
        App.modal.show('libarary-modal');
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
                images[image.id] = image;
                if(!$('#libarary-image-item-'+image.id).length){
                    $libararyImages.append(App.str.eval(template, image));
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
        images[image.id] = image;
        $libararyImages.prepend(App.str.eval(template, image));
        $results.show();
        $message.hide();
        $loading.hide();
        $results.stop().animate({
            scrollTop: 0
        }, 800);
    };

    this.remove = function(id){
        if(!$('#libarary-image-item-'+id).length) return false;
        var filename = $('#libarary-image-item-'+id).find('.dz-filename span').text();
        var msg = "bạn có chắc chắn muốn xóa file "+ filename + "?"
        var ans = window.confirm(msg);
        if (ans) {
            ajaxRequest(deleteUrl, "POST", { ids: [id] }, function(rs) {
                if (rs.status) {
                    if (rs.data) {

                        for (var i = 0; i < rs.data.length; i++) {
                            var rmid = rs.data[i];
                            $('#libarary-image-item-' + rmid).remove();
                            
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
    this.unCheckAll = function(){
        var $imageSelect = $libararyImages.find('.dz-preview.selected');
        if($imageSelect.length){
            $imageSelect.removeClass('selected');
        }
        return true;
    };
    this.preview = function(id){
        if(!id || typeof images[id] == "undefined"){
            App.Swal.warning("Ãnh bạn chọn không họp lệ");
        }
        else{
            var image = images[id];
            var $imageList = $results.find("#image-list");
            var $imagePreview = $results.find("#image-preview");
            var previewContent = App.str.eval(previewtemplate, image);
            $imageList.removeClass().addClass("col-12 col-md-8 col-lg-9");
            $imagePreview.removeClass().addClass("col-md-4 col-lg-3");
            setTimeout(function(){$imagePreview.html(previewContent);}, 150);
        }
    };

    this.clearPreview = function(){
        var $imageList = $results.find("#image-list");
        var $imagePreview = $results.find("#image-preview");
        $imageList.removeClass().addClass("col-12");
        $imagePreview.removeClass().addClass("col-1");
        $imagePreview.html("");
    }
    this.select = function(){
        var $imageSelect = $libararyImages.find('.dz-preview.selected');
        if(!$imageSelect.length){
            App.Swal.warning("Vui lòng chọn một hình ảnh bất kỳ");
        }else {
            var imgs = [];
            for (let index = 0; index < $imageSelect.length; index++) {
                const element = $imageSelect[index];
                let id = $(element).data("id");
                if(typeof images[id] == "undefined"){
                    return App.Swal.warning("Ảnh bạn chọn không hợp lệ");
                }
                imgs.push(images[id]);
            }
            

            if(typeof icb == "function"){
                icb(imgs);
            }
            App.modal.hide("libarary-modal");
            $imageSelect.removeClass('selected');
            self.clearPreview();
        }
        
        return true;
        if($editor){
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
            
            
            
        }
    };
    
}
$(function(){
    var mDropzoneLibarary={
        init:function(){
            var dropzoneLibarary = new Dropzone("#dropzone-libarary", {
                paramName:"file",
                maxFiles:10,
                maxFilesize:150,
                addRemoveLinks:!0,
                renameFile:true,
                acceptedFiles:"image/*,application/pdf,.psd",
                accept:function(e,o){"justinbieber.jpg"==e.name?o("Naha, you don't."):o()}
            });
            dropzoneLibarary.on("complete", function(file) { 
                if(file.xhr){
                    if(file.xhr.response){
                        var response = JSON.parse(file.xhr.response);
                        if(response.status){
                            setTimeout(function(){
                                App.libarary.prepand(response.data);
                                dropzoneLibarary.removeFile(file);
                            }, 1000);
                        }
                        
                    }
                }
            });
        }
    };
    
    mDropzoneLibarary.init();
    var libarary = new LibararyModal('#libarary-modal .libarary-body');
    libarary.init();
    App.extend({
        libarary: libarary
    });
});