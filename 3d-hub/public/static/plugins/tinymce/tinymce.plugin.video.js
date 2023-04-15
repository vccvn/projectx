tinymce.PluginManager.add('addvideourl', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('addvideourl', {
      text: 'Video',
      icon: false,
      onclick: function() {
        // Open window
        editor.windowManager.open({
          title: 'Video plugin',
          width: 600,
          height: 100,
          body: [
            {type: 'textbox', name: 'url', label: 'URL'}
          ],
          onsubmit: function(e) {
            // Insert content when the window form is submitted
            var data = Cube.videos.getVideoUrlData(e.data.url);
            var video = '[Video url="'+e.data.url+'"]';
            if(data.embed_url) {
                video = '<div class="video-responsive" style="max-height: 398px;"><iframe width="640" height="360" src="'+data.embed_url+'&rel=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen=""></iframe></div>';
            }
            editor.insertContent(video);
          }
        });
      }
    });
  
    // Adds a menu item to the tools menu
    editor.addMenuItem('addvideourl', {
      text: 'Video plugin',
      context: 'tools',
      onclick: function() {
        // Open window with a specific url
        editor.windowManager.open({
          title: 'TinyMCE site',
          url: 'https://www.tinymce.com',
          width: 800,
          height: 600,
          buttons: [{
            text: 'Close',
            onclick: 'close'
          }]
        });
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