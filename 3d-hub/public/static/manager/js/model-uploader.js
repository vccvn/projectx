var Html = R3D.Html, Dom = R3D.Dom, $class = R3D._class, ItemEditorService = R3D.ItemEditorService;
var Div = Html.Div, Span = Html.Span, Input = Html.Input, P = Html.P;


var modelUploaderID = 0;
function ModelUploader(selector, frmselect) {
    this.listeners = {};
    var $uploader = $(selector);
    var inputs = {};
    var firstData = {};

    var modelItem = null;
    var config = typeof window.model_uploader_data != "undefined" ? window.model_uploader_data : model_config;
    var urls = config.urls || {};
    var firstUpdateUrl = urls.first_update || "";

    $uploader.find('input').each(function (i, e) {
        e.type != 'file?' ? (inputs[e.name] = $(e).val()) : "";
    });
    var url = $uploader.attr('action');

    var dragBlock = $uploader.find('.drag-and-drop')[0];
    var inputName = $uploader.attr('field') || "file";
    var inputFile = document.createElement("input");
    inputFile.type = 'file';
    inputFile.name = inputName;
    // inputFile.id = 'model-upload-file-'+(++modelUploaderID);
    inputFile.style.display = 'none';
    inputFile.accept = "*.zip,*.gltf,*.glb, *.stl, *.obj, *.json";
    $uploader.find('label').append(inputFile);
    $uploader.addClass('model-uploader');
    var $pbar = $('#upload-progress-bar');
    var $previewImage = $('#image-preview-target');

    var $infoForm = $('#model-info-form');
    var taskNeedCompleteTotal = 2;
    var doingTaskTotal = 0;

    // var inputFile = $uploader.find('input[type=file]')[0];
    // var hiddenImageName = $uploader.data('name')+'_data[]';
    var isAdvancedUpload = function () {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();



    var self = this;
    var portlet = new mPortlet(frmselect);
    window.portlet = portlet;
    var canvasWrapper = document.getElementById('canvas-wrapper');

    var editor = new ItemEditorService();

    editor.on("model.added", function (a) {
        // console.log(a);
    });


    // editor._options.control.enableDumping = false;
    editor._options.control.enableDamping = false;
    editor._options.lights.map(function (li) {
        if (li.props) li.props.castShadow = false;
    });
    editor._options.camera.far = 10000;
    editor.setOptions(editor._options);
    editor.init();

    window.editor = editor;

    function init() {
        // drag&drop files if the feature is available
        if (isAdvancedUpload) {
            $uploader.addClass('has-advanced-upload'); // letting the CSS part to know drag&drop is supported by the browser

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
                addFiles(droppedFiles);

            });
        }

        inputFile.addEventListener('change', function (e) {
            e.target.files.length ? addFiles(e.target.files) : 0
        });

        portlet.on("reload", function (e) {
            mApp.block(e.getSelf(), {
                overlayColor: "#ffffff", type: "loader", state: "accent", opacity: .3, size: "lg"
            }), setTimeout(function () { mApp.unblock(e.getSelf()) }, 2e3)
        });
        portlet.on("afterFullscreenOn", function (e) {
            var t = $(e.getBody()).find("> .m-scrollable");
            t && (t.data("original-height", t.css("height")), t.css("height", "100%"), mUtil.scrollerUpdate(t[0]))
        });
        portlet.on("afterFullscreenOff", function (e) {
            var t;
            (t = $(e.getBody()).find("> .m-scrollable")) && ((t = $(e.getBody()).find("> .m-scrollable")).css("height", t.data("original-height")), mUtil.scrollerUpdate(t[0]))
        });
        editor.engine.setWrapper(canvasWrapper);
        editor.updateCanvasSize();
        // editor.engine.updateCanvasSize();

        $(document).on("click", '.btn-close-form', function (e) {
            e.preventDefault();
            editor.removeModelItem();
            removeBg()
            $pbar.addClass('bg-warning');
            // portlet.unFullscreen();
            $('#model-upload-progress-bar').addClass('d-none');
            $('.form-upload-block').removeClass('d-none');
            $('.filename-text').html("");
            $('#info-form').addClass('d-none');
            $('.frame-preview').removeClass('show-canvas');
        });


        $(document).on("click", '.img-preview', function (e) {
            e.preventDefault();
            $('.frame-preview').addClass('show-canvas')
        });

        $(document).on("click", '.btn-save-public', function (e) {
            e.preventDefault();
            $('#hidden-input-status').val('published');
            $infoForm.trigger("submit");
        });
        $infoForm.on("submit", function (e) {
            if ($('#model-name').val() == "") {
                e.preventDefault();
                return false;
            }
            return true;
        })


        var editorportlet = new mPortlet("editor-portlet");
        // window.editorportlet = editorportlet;

        // var previewportlet = new mPortlet("preview-portlet");
        // window.previewportlet = previewportlet;

        $(document).on("click", ".img-frame", function (e) {
            e.preventDefault();
            $('#canvas-wrapper').html(
                '<iframe width="560" height="315" src="' + model_config.urls.preview + '/' + modelItem.secret_id + '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            )
            $('.frame-preview').addClass('show-canvas')
            // $('#preview-portlet').removeClass('d-none');
            // previewportlet.fullscreen();
        })
        $(document).on("click", ".btn-edit-3d", function (e) {
            e.preventDefault();
            $('#canvas-wrapper').html('')
            $('.frame-preview').removeClass('show-canvas')
            // $('#preview-portlet').removeClass('d-none');
            // previewportlet.fullscreen();
            $('#editor-portlet-body .frame').html(
                '<iframe width="560" height="315" src="' + App.str.replace(model_config.urls.editor, 'SECRET_ID', modelItem.secret_id) + '" title="Crazy 3D" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            );
            $('#editor-portlet').removeClass('d-none');
            editorportlet.fullscreen();
        })
        $(document).on("click", ".btn-close-editor", function (e) {
            e.preventDefault();
            $('#editor-portlet-body .frame').html(
                ''
            );
            editorportlet.unFullscreen();
            $('#editor-portlet').addClass('d-none');

        })

        // console.log("dm");
    }

    function addFiles(files) {
        if (files.length < 1) return App.Swal.warning('Bạn chưa chọn file');
        if (!validate(files[0])) return App.Swal.warning('File không đúng định dạng');
        upload(files[0]);
        return 0;
    }

    function validate(file) {
        return ['gltf', 'glb', 'stl', 'obg', 'tds', '3ds', 'zip', 'json'].indexOf(file.name.split(".").pop().toLowerCase()) != -1;
    };
    function parseSise(originSize, level) {
        if (!level) level = 0;
        var unit_level = ["B", "KB", "MB", "GB", "TB"];
        var size = originSize;
        if (size) {
            if (size >= 1024) {
                return parseSise(parseInt(size * 10 / 1024) / 10, level + 1);
            }
        }
        // cl(size)
        return {
            size: size,
            size_unit: unit_level[level]
        };
    };

    function removeBg() {
        ['bg-success', 'bg-danger', 'bg-info', 'ng-primary', 'bg-warning', 'bg-accent'].map(function (s) {
            $pbar.removeClass(s);
        });
    }
    function upload(file) {
        var fd = new FormData();
        for (const key in inputs) {
            if (Object.hasOwnProperty.call(inputs, key)) {
                const value = inputs[key];
                fd.append(key, value);
            }
        }
        fd.append(inputName, file);
        // return false;
        var size = file.size;

        doingTaskTotal = 0;
        firstData = {};
        $('#model-upload-filename').html(file.name);
        $('.filename-text').html(file.name);
        // $uploader.addClass('d-none');
        $('#model-upload-progress-bar').removeClass('d-none');
        $('.form-upload-block').addClass('d-none');
        removeBg()
        $pbar.addClass('bg-warning');
        $pbar.addClass('progress-bar-animated');
        $('.loading-text').html('Đang tải...')

        var pass70 = false;
        $pbar.css('width', 0);
        App.api.upload(url, fd, {
            onUploadProgress: function (e) {
                let p = parseInt(e.loaded / size * 10000) / 100;
                // console.log(p);
                if (p > 100) p = 100;
                $pbar.css('width', p + '%');
                if (p >= 70 && !pass70) {
                    removeBg();
                    $pbar.addClass('bg-accent');
                    pass70 = true;
                }
                if (p == 100) {
                    removeBg()
                    $pbar.removeClass('progress-bar-animated');
                    $pbar.addClass('bg-success');
                    $('.loading-text').html('Đang xử lý...')
                }

            }
        }).then(function (rs) {
            // console.log(rs);

            editor.engine.setWrapper(canvasWrapper);
            editor.updateCanvasSize();
            // editor.engine.updateCanvasSize();
            if (rs.status) {
                removeBg()
                $pbar.removeClass('progress-bar-animated');
                $pbar.addClass('bg-success');
                $('.loading-text').html('Đang xử lý...');

                editor.addModelItem(rs.data, obj => {
                    $('#info-form').removeClass('d-none');
                    $('#model-upload-progress-bar').addClass('d-none');

                    editor.updateCanvasSize();
                    // editor.engine.updateCanvasSize();
                    modelItem = rs.data
                    $('#model-name').val(rs.data.name);
                    $('.filename-text').html("");
                    getSize();
                    capture();
                }, () => {
                    App.Swal.warning('Lỗi không xác định');
                    removeBg()
                    $pbar.addClass('bg-danger');
                    $('#model-upload-progress-bar').addClass('d-none');
                    $('.form-upload-block').removeClass('d-none');
                    $('.filename-text').html("");
                    removeCanvas();
                }, p => { // progress
                    // console.log(p)
                });


            } else {
                $('#model-upload-progress-bar').addClass('d-none');
                $('.form-upload-block').removeClass('d-none');
                App.Swal.warning(rs.message + "<br> " + (function () {
                    var a = [];
                    for (const key in rs.errors) {
                        if (Object.hasOwnProperty.call(rs.errors, key)) {
                            const v = rs.errors[key];
                            a.push(v);
                        }
                    }
                    return a;
                }()).join("<br>"));
                $('.filename-text').html("");
                removeCanvas()

            }
        }).catch((e) => {
            console.log(e)
            removeBg()
            $pbar.removeClass('progress-bar-animated');
            $pbar.addClass('bg-danger');
            App.Swal.error("Lỗi: Không thể upload file", null, function () {
                $('#model-upload-progress-bar').addClass('d-none');
                $('.form-upload-block').removeClass('d-none');
                // App.Swal.warning(rs.message);
            })
        })
    }

    function getSize() {
        firstData.size = editor.data.item.size;
        doingTaskTotal++;
        checkTask();
    }

    function capture() {
        editor.capture(img => {
            $previewImage.attr('src', img);
            firstData.thumbnail = img;
            doingTaskTotal++;
            checkTask();
        })
    }

    function checkTask() {
        console.log(doingTaskTotal)
        if (doingTaskTotal == taskNeedCompleteTotal) {

            // portlet.fullscreen();
            firstData.id = editor.data.item.id;
            $('#hidden-input-id').val(firstData.id);
            if (firstUpdateUrl) {
                App.api.post(firstUpdateUrl, firstData).then(function (rs) {
                    if (rs.status) {
                        console.log(rs);
                    }
                    else {
                        $('#model-upload-progress-bar').addClass('d-none');
                        $('.form-upload-block').removeClass('d-none');
                        App.Swal.warning("Lỗi không xác dinh")
                    }
                    removeCanvas()
                })
                    .catch(function (e) {
                        $('#model-upload-progress-bar').addClass('d-none');
                        $('.form-upload-block').removeClass('d-none');
                        App.Swal.warning("Lỗi không xác dinh")
                        removeCanvas()
                    })

            }

        }
    }
    function removeCanvas() {
        // editor.removeModelItem();
        // canvasWrapper.innerHTML = '';
    }
    init();
}


$(function () {
    // var $cs = $('#model-upload-form');
    // if($cs.length){
    //     $cs.each(function(i, el){
    //         App.modelUploaderContainers.add(el);
    //     });
    // }

});