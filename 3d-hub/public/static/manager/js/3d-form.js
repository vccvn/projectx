// var Html = R3D.Html, Dom = R3D.Dom, $class = R3D._class, ItemEditorService = R3D.ItemEditorService;
// var Div = Html.Div, Span = Html.Span, Input = Html.Input, P = Html.P, A = Html.A, I = Html.I, Iframe = Html.Iframe;


var modelUploaderID = 0;
$(function () {
    var $id = $('#hidden-input-id'),
        $secret = $('#hidden-input-secret-id'),
        $status = $('#hidden-input-status'),
        $name = $('#crazy-name'),
        $description = $('#crazy-description'),
        $category = $('#category_id'),
        template = null;

    var editorportlet = new mPortlet("editor-portlet");
    // window.editorportlet = editorportlet;

    // var previewportlet = new mPortlet("preview-portlet");
    // window.previewportlet = previewportlet;

    function createDefault(success, error) {
        if (!$id.val() || !$secret.val()) {
            App.api.post(__3D_Config__.urls.create_default, {
                name: $name.val(),
                category_id: $category.val(),
                description: $description.val(),
                status: $status.val()

            }).then(function (rs) {
                if (rs.status) {
                    $id.val(rs.data.id);
                    $secret.val(rs.data.secret_id);
                    template = rs.data;
                    if (typeof success == "function") {
                        success(rs.data);
                    }
                } else if (typeof error == "function") {
                    error(rs);
                }
            }).catch(function(e){
                error(e);
            });
        }else{
            if (typeof success == "function") {
                success(template);
            }
        }
    }
    var mode = __3D_Config__.mode || 'creator';

    $(document).on("click", ".img-frame", function (e) {
        e.preventDefault();

        createDefault(function(){
            $('#canvas-wrapper').html(
                '<iframe width="560" height="315" src="' + __3D_Config__.urls.preview + '/' + template.secret_id + '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
            )
            $('.frame-preview').addClass('show-canvas')
           
        }, function(e){
            App.Swal.error(e.message||"Lỗi không xác định");
        })
        return false;
        // $('#preview-portlet').removeClass('d-none');
        // previewportlet.fullscreen();
    })
    $(document).on("click", ".btn-edit-3d", function (e) {
        e.preventDefault();
        createDefault(function(){
            $('#canvas-wrapper').html('')
        $('.frame-preview').removeClass('show-canvas')
        // $('#preview-portlet').removeClass('d-none');
        // previewportlet.fullscreen();
        $('#editor-portlet-body .frame').html(
            '<iframe width="560" height="315" src="' + App.str.replace(__3D_Config__.urls[mode], 'SECRET_ID', template.secret_id) + '" title="Crazy 3D" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
        );
        $('#editor-portlet').removeClass('d-none');
        editorportlet.fullscreen();
        }, function(e){
            App.Swal.error(e.message||"Lỗi không xác định");
        })
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