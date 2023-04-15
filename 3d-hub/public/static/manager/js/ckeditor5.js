jQuery(window).on('load', function () {

    var $mini = $('textarea.crazy-ckeditor');
    if ($mini.length) {

        $mini.each((i, e) => {
            var $e = $(e);
            var id = $e.attr('id');
            var h = 500;
            if ($e.attr('height')) {
                h = $e.attr('height');
            }
            ClassicEditor
                .create(e, {
                    // removePlugins: ['Heading', 'Link'],
                    toolbar: ['bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote']
                })
                .then(editor => {
                    Array.from( editor.ui.componentFactory.names() )
                })
                .catch(error => {
                    console.log(error);
                });

        });
    }
})