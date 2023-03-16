var LibraryModal = function (selector) {
    var $el = $(selector);
    // trinh soan thao
    var $editor = null,
        files = [],
        totalResult = 0,
        currentPage = 0,
        totalPage = 0,
        perpage = 50,
        url = "",
        deleteUrl = "",
        firstLoad = false,
        $message = $el.find('.message'),
        $results = $el.find('.results'),
        $loading = $el.find('.loading'),
        $seemore = $el.find('.results .buttons .btn-see-more'),
        $selectBtn = $('#library-modal .btn-select-image'),
        template = $el.find('.template').text(),
        previewtemplate = $el.find('.preview-template').text(),
        isGettingData = false,
        editorType = 'tinymce',
        selectedCallback = null,
        selectionMode = 'one',
        fileType = null,
        selectedFiles = [],
        previewMode = 'on',
        modalOpened = null,
        checkedFiles = [];

    var $libraryImages = $results.find('.library-images');
    $el.find('.template').remove();
    $el.find('.preview-template').remove()
    if (typeof library_data != "undefined") {
        if (typeof library_data.get_file_url != "undefined") {
            url = library_data.get_file_url;
        }
        if (typeof library_data.delete_file_url != "undefined") {
            deleteUrl = library_data.delete_file_url;
        }
    }

    var self = this;
    // thiết lập ban đầu
    this.init = function () {

        // button gi hien thi dropdown
        $('.btn-toggle-dropzone-library').click(function () {
            $('.dropdown-library-block').slideToggle();
        });

        // su kien click vao view moew
        $seemore.on('click', function () {
            if (!isGettingData) {
                self.getResults();
                $(this).addClass('m-loader m-loader--light m-loader--right');
            }
        });
        // cuon xuong cuoi danh sach
        $results.on('scroll', function () {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                if (totalPage > currentPage && !isGettingData) {
                    self.getResults();
                    $seemore.addClass('m-loader m-loader--light m-loader--right');
                }
            }
        });
        // bat su kien click vao anh
        $libraryImages.on('click', function (e) {
            //
            var $btn = $libraryImages.find('.dz-preview .btn-remove-image-file');
            var $e = $(e.target);
            var $image = $libraryImages.find('.dz-preview');
            // xoa anh
            if ($e.is($btn)) {
                e.preventDefault();
                e.stopPropagation();
                self.remove($e.data('id'));

            } else if ($e.closest($btn).length) {
                e.preventDefault();
                e.stopPropagation();
                self.remove($e.closest($btn).data('id'));
            }

            else {

                // neu click vao anh
                var $item = $e.closest($image);
                if ($item.length) {
                    var hasClass = $item.hasClass('selected');
                    if ($libraryImages.find('.dz-preview.selected').length) {
                        self.clearPreview();
                    }
                    if (hasClass) {
                        $item.removeClass('selected');

                        self.uncheck($item.data('id'));
                    } else {

                        // neu mode la 1 anh thi bo select tat ca
                        if (selectionMode != 'many') {
                            self.unCheckAll();
                        }

                        $item.addClass('selected');

                        self.check($item.data('id'));
                        self.preview($item.data("id"));
                    }

                }

            }
        });
        $selectBtn.on('click', function () {
            self.select();
        });

        // this.getResults();
    };

    this.check = function(id){
        var inArr = false;
        for (let index = 0; index < checkedFiles.length; index++) {
            const checkedid = checkedFiles[index];
            if(id == checkedid) inArr = true;
        }
        if(!inArr) checkedFiles.push(id);
        return !inArr;
    };

    this.uncheck = function(id){
        var inArr = false;
        for (let index = 0; index < checkedFiles.length; index++) {
            const checkedid = checkedFiles[index];
            if(id == checkedid) {
                inArr = true;
                checkedFiles.splice(index, 1);

            }
        }
        return inArr;
    };


    this.setUrl = function (newUrl) {
        url = newUrl;
    };
    /**
     * hien thi modal
     * @param {function} onOpen thuc hien han dong sau khi mo modal
     * @param {function} onClose thuc hien hanh dong sau khi dong modal
     */
    this.showModal = function (onOpen, onClose) {
        App.modal.show('library-modal', onOpen, function () {

            if(modalOpened){
                setTimeout(function(){
                    App.modal.show(modalOpened);
                }, 100);
            }

            if(typeof onClose == "function"){

                onClose();
            }
        });
        if (!firstLoad) {
            this.getResults();
            firstLoad = true;
        }else{
            this.checkList(selectedFiles);
        }
    };
    this.open = function (mode, callback) {
        selectedFiles = [];
        this.unCheckAll();
        if (mode && App.getType(mode) == 'object') {
            var m = (mode.mode == 'many') ? 'many' : 'one';
            var t = (mode.type == 'all' || mode.type == 'video' || mode.type == 'image' || mode.type == 'audio') ? mode.type : null;
            var c = (typeof mode.done == "function") ? mode.done : (
                (typeof mode.onSelect == "function") ? mode.onSelect : (
                    (typeof mode.selectCallback == "function") ? mode.selectCallback : (
                        (typeof mode.insert == "function") ? mode.insert : (
                            (typeof mode.choose == "function") ? mode.choose : (
                                (typeof mode.selecting == "function") ? mode.selecting : (
                                    typeof callback == "function" ? callback : null
                                )
                            )
                        )
                    )
                )
            )
            var selected = (typeof mode.selected != "undefined") ? mode.selected : (
                (typeof mode.data != "undefined") ? mode.data : (
                    (typeof mode.value != "undefined") ? mode.value : (
                        (typeof mode.values != "undefined") ? mode.values : (
                            (typeof mode.activedFiles != "undefined") ? mode.activedFiles : (
                                []
                            )
                        )
                    )
                )
            );


            var pm = (typeof mode.preview != "undefined") ? mode.preview : (
                (typeof mode.previewMode != "undefined") ? mode.previewMode : false
            );
            var md = (typeof mode.modal != "undefined") ? mode.modal : (
                (typeof mode.modalOpened != "undefined") ? mode.modalOpened : null
            );
            var oo = (typeof mode.onOpen != "undefined") ? mode.onOpen : (
                (typeof mode.opened != "undefined") ? mode.opened : null
            );
            var oc = (typeof mode.onClose != "undefined") ? mode.onClose : (
                (typeof mode.closed != "undefined") ? mode.closed : null
            );
            modalOpened = md;


            selectedFiles = selected ? (App.isArray(selected) ? selected : [selected]) : [];
            selectionMode = m;
            fileType = t;
            selectedCallback = c;
            previewMode = pm;
            this.showModal(oo, oc);
            return;
        }
        if (typeof mode == "function") {
            selectionMode = "one";
            selectedCallback = mode;
            this.showModal();
            return;
        }
        if (!mode) mode = 'one';
        selectionMode = mode;
        selectedCallback = callback;
        this.showModal();
    };
    this.openOne = function (callback) {
        this.open('one', callback);
    };
    this.openMany = function (callback) {
        this.open('many', callback);
    };
    this.getResults = function () {
        firstLoad = true;
        var data = {
            page: currentPage + 1,
            per_page: perpage
        };

        if (fileType && fileType != 'all') {
            data.filetype = fileType;
        }
        ajaxRequest(url, "GET", data, function (rs) {
            $loading.hide();
            if (rs.status) {
                totalPage = rs.page_total;
                totalResult = rs.count;
                currentPage = rs.page;
                self.showResults(rs.data);
            } else {
                if ($results.find('.dz-preview').length) {
                    $results.show();
                    $message.hide();
                } else {
                    $results.hide();
                    $message.show();
                }
            }
            $seemore.removeClass('m-loader m-loader--light m-loader--right');
            if (totalPage == currentPage) {
                $seemore.remove();
            }
        });
    };
    this.showResults = function (data) {
        if (data != null && data.length) {
            for (let i = 0; i < data.length; i++) {
                const image = data[i];
                files[image.id] = image;
                if (!$('#library-image-item-' + image.id).length) {
                    $libraryImages.append(App.str.eval(template, image));
                }
            }
            $results.show();
            $message.hide();
            if (currentPage > 1) {
                $results.stop().animate({
                    scrollTop: $results[0].scrollHeight
                }, 800);
            }

        }
        this.checkList(selectedFiles);
    };


    this.prepand = function (image) {
        files[image.id] = image;
        $libraryImages.prepend(App.str.eval(template, image));
        $results.show();
        $message.hide();
        $loading.hide();
        $results.stop().animate({
            scrollTop: 0
        }, 800);
    };

    this.remove = function (id) {
        if (!$('#library-image-item-' + id).length) return false;
        var filename = $('#library-image-item-' + id).find('.dz-filename span').text();
        var msg = "bạn có chắc chắn muốn xóa file " + filename + "?"
        App.Swal.confirm(msg, function(){
            ajaxRequest(deleteUrl, "POST", { ids: [id] }, function(rs) {
                if (rs.status) {
                    if (rs.data) {

                        for (var i = 0; i < rs.data.length; i++) {
                            var rmid = rs.data[i];
                            $('#library-image-item-' + rmid).remove();

                        }

                    }
                    if(rs.errors.length){
                        App.Swal.error(rs.errors.join("\n"));
                    }
                }
                else if(rs.message){
                    App.Swal.error(rs.message);
                }
                else {
                    App.Swal.error("Đã có lỗi bất ngờ xảy ra. Vui lòng thử lại sau giây lát");
                }
            });
        })

    };

    this.checkList = function(list){
        if(list && App.isArray(list) && list.length){
            for (let index = 0; index < list.length; index++) {
                const id = list[index];
                var slf = $libraryImages.find('.dz-preview[data-id="'+id+'"]');
                if(slf.length){
                    slf.addClass('selected');
                }
            }
        }
    };
    this.unCheckAll = function () {
        var $imageSelect = $libraryImages.find('.dz-preview.selected');
        if ($imageSelect.length) {
            $imageSelect.removeClass('selected');
        }
        return true;
    };
    this.preview = function (id) {
        if (!id || typeof files[id] == "undefined") {
            App.Swal.warning("Ãnh bạn chọn không họp lệ");
        }
        else if(previewMode === false || previewMode == "no" || previewMode == "off") return;
        else {
            var image = files[id];
            if (image.filetype != "image") return;
            var $imageList = $results.find("#image-list");
            var $imagePreview = $results.find("#image-preview");
            var previewContent = App.str.eval(previewtemplate, image);
            $imageList.removeClass().addClass("col-12 col-md-8 col-lg-9");
            $imagePreview.removeClass().addClass("col-md-4 col-lg-3");
            setTimeout(function () { $imagePreview.html(previewContent); }, 150);
        }
    };

    this.clearPreview = function () {
        var $imageList = $results.find("#image-list");
        var $imagePreview = $results.find("#image-preview");
        $imageList.removeClass().addClass("col-12");
        $imagePreview.removeClass().addClass("col-1 col-0");
        $imagePreview.html("");
    }
    this.select = function () {
        var text = (fileType && fileType !='image')?'File': "Hình ảnh";
        var $imageSelect = $libraryImages.find('.dz-preview.selected');
        if (!$imageSelect.length) {
            App.Swal.warning("Vui lòng chọn một "+text+" bất kỳ");
        } else {
            var imgs = [];
            for (var index = 0; index < checkedFiles.length; index++) {
                var id = checkedFiles[index];
                var $image = $libraryImages.find('.dz-preview.selected[data-id="'+id+'"]');
                if($image.length){
                    if (typeof files[id] == "undefined") {
                        return App.Swal.warning(text+" bạn chọn không hợp lệ");
                    }
                    imgs.push(files[id]);
                }

            }

            if (typeof selectedCallback == "function") {
                selectedCallback(selectionMode == 'many' ? imgs: imgs[0]);
            }
            selectionMode = 'one';
            App.modal.hide("library-modal");
            $imageSelect.removeClass('selected');
            self.clearPreview();
            checkedFiles = [];
        }

        return true;
    };

}
$(function () {
    var mDropzoneLibrary = {
        init: function () {
            var dropzoneLibrary = new Dropzone("#dropzone-library", {
                paramName: "file",
                maxFiles: 100,
                maxFilesize: 150,
                addRemoveLinks: !0,
                renameFile: true,
                acceptedFiles: "image/*,application/pdf,.psd,*.mp4,*.3gp,*.avi,*.mov,*.h264,audio/*,*.qt",
                accept: function (e, o) { "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o() }
            });
            dropzoneLibrary.on("complete", function (file) {
                if (file.xhr) {
                    if (file.xhr.response) {
                        var response = JSON.parse(file.xhr.response);
                        if (response.status) {
                            setTimeout(function () {
                                App.library.prepand(response.data);
                                dropzoneLibrary.removeFile(file);
                            }, 1000);
                        }
                        else {
                            var error = '';
                            if (response.errors) {
                                var i = 0;
                                var key;
                                for (key in response.errors) {
                                    if (Object.hasOwnProperty.call(response.errors, key)) {
                                        var err = response.errors[key];
                                        error += (i ? '<br>' : '') + err;

                                        i++;
                                    }
                                }
                            }
                            if(!error) error = response.message;
                            App.Swal.error(error);
                        }

                    }
                }
            });
        }
    };

    mDropzoneLibrary.init();
    var library = new LibraryModal('#library-modal .library-body');
    library.init();
    App.extend({
        library: library
    });

    $(document).on("click", ".input-media .input-group", function (e) {
        e.preventDefault();
        var el = e.target;
        var $inputMedia = $(el).closest('.input-media');
        if ($inputMedia.length) {
            var type = $inputMedia.data('type');
            var $hidden = $inputMedia.find('.media-input-hidden');
            var $text = $inputMedia.find('.media-input-text');
            var $img = $inputMedia.find('.media-image-thumbnail');
            var $fileSize = $inputMedia.find('.file-size');
            var modal = null;
            var md = $inputMedia.closest('.modal');
            if(md.length){
                modal = md.attr('id');
            }
            App.library.open({
                modal: modal,
                mode: "one",
                preview: true,
                type: type,
                selected: $hidden.val(),
                done: function (file) {
                    $hidden.val(file.id);
                    $text.val(file.original_filename);
                    $img.attr('src', file.thumbnail);
                    $fileSize.html(file.size + "" + file.size_unit);

                }
            })
        }
    })



});
