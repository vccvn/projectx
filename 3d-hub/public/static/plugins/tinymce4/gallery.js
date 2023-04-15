tinymce.PluginManager.add('openGallery', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('openGallery', {
        text: 'Thư viện',
        icon: 'image',
        onclick: function() {
            GalleryModal.open(editor);
            // Crazy.modal.confirm("Bạn có chắc chắc muốn thêm Doãn Đẹp Trai vào nội dung ko", function(rs){
            //     if(rs){
            //         editor.insertContent("Doãn Đẹp Trai");
            //     }
            // });

        }
    });
    return {
        getMetadata: function () {
            return  {
                name: "Video plugin",
                url: "http://exampleplugindocsurl.com"
            };
        }
    };
});