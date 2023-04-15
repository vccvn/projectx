

if ($('textarea.tiny-mce').length) {
    var tinyEditor;
    var h = 500;
    var $content = $('textarea.tiny-mce');
    if ($content.attr('height')) {
        h = $content.attr('height');
    }

    var options = {
        selector: 'textarea.tiny-mce',
        branding: false,
        language: "vi",
        height: h,
        plugins: [
            'print preview powerpaste importcss searchreplace autolink autosave save directionality ',
            'visualblocks visualchars fullscreen image link media  template codesample table ',
            'charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists  wordcount  a11ychecker ',
            'imagetools textpattern noneditable help formatpainter charmap mentions emoticons openGallery '
            // "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            // "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            // "table contextmenu directionality emoticons paste textcolor code openGallery" advcode 
        ],
        mobile: {
            plugins: 'print preview powerpaste importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media  template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists  wordcount  a11ychecker textpattern noneditable help formatpainter charmap mentions emoticons openGallery'
        },
        image_advtab: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,

        menubar: false,
        // menubar: 'file edit insert format tools view help',
        // toolbar: 'undo redo | bold italic underline strikethrough | 
        // fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | 
        // outdent indent |  numlist bullist  | forecolor backcolor casechange formatpainter removeformat | 
        // pagebreak | charmap emoticons | preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
        // styleselect

        contextmenu: 'bold italic underline | alignleft aligncenter alignright alignjustify | link',
        content_css: [
            '//fonts.googleapis.com/css?family=Source+Sans+Pro',
            '/static/plugins/tinymce/style.css',
            '/static/plugins/tinymce/bs4/bootstrap-grid.min.css'

        ],
        // toolbar: 'formatselect | fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist
        // |  forecolor backcolor | image | link | table | fullscreen | outdent indent |removeformat',
        toolbar: "undo redo | formatselect |bold italic underline  formatgroup  | alignleft aligncenter alignright | paragraphgroup | table link image media emoticons insertgroup",
        toolbar_groups: {
            formatgroup: {
                icon: 'format',
                tooltip: 'Định dạng',
                items: ' fontselect fontsizeselect | forecolor backcolor | superscript subscript | removeformat'
            },
            paragraphgroup: {
                icon: 'paragraph',
                tooltip: 'Định dạng đoạn văn',
                items: 'bullist numlist | alignleft aligncenter alignright alignjustify | indent outdent'
            },
            insertgroup: {
                icon: 'plus',
                tooltip: 'Chèn',
                items: 'openGallery | charmap hr codesample template | pagebreak nonbreaking anchor insertdatetime advlist '
            }
        },
    };
    tinymce.init(options);
    
    var cmo = {
        value: $content.val(),
        mode: "text/html",
        extraKeys: { "Ctrl-Space": "autocomplete" },
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,

        matchTags: { bothTags: true },
        extraKeys: { "Ctrl-J": "toMatchingTag" },
        lineWrapping: true,
        extraKeys: { "Ctrl-Q": function (cm) { cm.foldCode(cm.getCursor()); } },
        foldGutter: true,
        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
    }

    var myCodeMirror = null;

    // var myCodeMirror = CodeMirror(document.getElementById('code_tab'), cm);

    var currentTab = 'editor_tab';

    $('.tiny-mce-wrapper a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var $this = $(e.target) // newly activated tab
        // e.relatedTarget // previous active tab
        var tab = $this.attr('href').substr(1);
        if (currentTab != tab) {
            currentTab = tab;
            if (tab == 'code_tab') {
                var content = tinymce.activeEditor.getContent();
                if (!myCodeMirror) {
                    cmo.value = content;
                    myCodeMirror = CodeMirror(document.getElementById('code_tab'), cmo);
                    myCodeMirror.setSize(null, parseInt(h));

                    myCodeMirror.on("change", function () {
                        if (currentTab == 'code_tab') {
                            var cnt = myCodeMirror.getValue();
                            $content.val(cnt);
                            tinymce.activeEditor.setContent(cnt);
                        }

                    })
                } else {
                    myCodeMirror.setValue(content);
                }
            } else {
                if (myCodeMirror) {
                    tinymce.activeEditor.setContent(myCodeMirror.getValue());
                }
            }
        }

    });

    $('#'+$content.attr('id')+'-tabs .btn-insert-gallery').click(function(){
        if(currentTab == 'code_tab'){
            var doc = myCodeMirror.getDoc();
            var cursor = doc.getCursor();
            window.GalleryModal.open(myCodeMirror, 'cm', function(editor, content){
                doc.replaceRange(content, cursor);
            });
        }else{
            window.GalleryModal.open(tinymce.activeEditor, 'tinymce');
        }
    });
    
}