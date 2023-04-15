tinymce.PluginManager.add('openGallery', function(editor, url) {
    // Add a button that opens a window
    
    editor.ui.registry.addButton('openGallery', {
        text: 'Thư viện',
        icon: 'image',
        onAction: function () {
            GalleryModal.open(editor);
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