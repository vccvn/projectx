var Html = R3D.Html, Dom = R3D.Dom, $class = R3D._class, ItemEditorService = R3D.ItemEditorService;
var Div = Html.Div, Span = Html.Span, Input = Html.Input, P = Html.P, A = Html.A, I = Html.I, Iframe = Html.Iframe;


var modelUploaderID = 0;
$(function () {
    var editorportlet = new mPortlet("editor-portlet");
    // window.editorportlet = editorportlet;
    
    // var previewportlet = new mPortlet("preview-portlet");
    // window.previewportlet = previewportlet;

    $(document).on("click", ".img-frame", function (e) {
        e.preventDefault();
        $('#canvas-wrapper').html(
            '<iframe width="560" height="315" src="'+model_config.urls.preview +'/' +model_data.secret_id+'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
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
            '<iframe width="560" height="315" src="'+model_config.urls.editor+'" title="Crazy 3D" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
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

    
    
     
    
});