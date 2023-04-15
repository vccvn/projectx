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
            var editorMode = $e.attr('mode');
            var toolbar = [
                {
                    name: "basicstyles",
                    groups: ["basicstyles"]
                },
                {
                    name: 'paragraph',
                    groups: ['list']

                },
                {
                    name: "links",
                    groups: ["links"]
                },
                {
                    name: "styles",
                    groups: ["styles"]
                },
                {
                    name: 'colors',
                    groups: ['TextColor', 'BGColor']
                },
                { name: 'document', groups: [ 'mode' ] }
            ];
            var removeButtons = 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,Save,NewPage,Preview,Print,Templates';
            if(editorMode == 'clean'){
                toolbar = [
                    {
                        name: "basicstyles",
                        groups: ["basicstyles"]
                    },
                    {
                        name: "styles",
                        groups: ["styles"]
                    },
                    {
                        name: 'colors',
                        groups: ['TextColor', 'BGColor']
                    },
                    { name: 'document', groups: [ 'mode' ] }
                ];
                removeButtons = 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,Save,NewPage,Preview,Print,Templates,Format,Font';
            }
            // CKEDITOR.editorConfig = function( config ) {
            //     config.extraPlugins = 'sourcearea';
            // };

            // CKEDITOR.replace(id);
            CKEDITOR.replace(id, {
                // Define the toolbar groups as it is a more accessible solution.
                toolbarGroups: toolbar,
                language: 'vi',
                // uiColor: '#F7B42C',
                height: h,
                // toolbarCanCollapse: true,
                extraPlugins: 'colorbutton,sourcearea',
                // Remove the redundant buttons from toolbar groups defined above.
                removeButtons: removeButtons
            });
        });


    }
})