var Html = R3D.Html, Dom = R3D.Dom, $class = R3D._class, ItemEditorService = R3D.ItemEditorService;
var Div = Html.Div, Span = Html.Span, Input = Html.Input, P = Html.P;


var modelUploaderID = 0;
function ModelForm(){
    
    var editor = new ItemEditorService();




    // editor._options.control.enableDumping = false;
    // editor._options.control.enableDamping = false;

    editor._options.lights.map(function (li) {
        if(li.props) li.props.castShadow = false;
    })
    editor.setOptions(editor._options);
    editor.init();

    var approot = document.getElementById('app-root');
    var prg = document.getElementById('preview-progress-bar');
    editor.addModelItem(model_data, obj => {
        editor.updateCanvasSize();
        approot.appendChild(editor.engine.getCanvas());
        approot.style.display = 'block';
        setTimeout(function () {
            document.querySelector('.pre-loading-image').style.display = 'none';
            document.querySelector('.load-block').style.display = 'none';
            approot.style.opacity = 1;
        }, 2000)
    }, () => {
        // App.Swal.warning('Lỗi không xác định');
        
    }, p => { // progress
        // $('#preview-progress-bar').css('width', p + '%');
        prg.style.width = p+'%';
    });
}
ModelForm();