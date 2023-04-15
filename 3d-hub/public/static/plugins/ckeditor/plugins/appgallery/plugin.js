/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @fileOverview The Source Editing Area plugin. It registers the "source" editing
 *		mode, which displays raw  HTML data being edited in the editor.
 */

(function () {
	CKEDITOR.plugins.add('appgallery', {
		// jscs:disable maximumLineLength
		// jscs:enable maximumLineLength
		lang: 'en,vi', // %REMOVE_LINE_CORE%
		icons: 'source,source-rtl', // %REMOVE_LINE_CORE%
		hidpi: true, // %REMOVE_LINE_CORE%
		init: function (editor) {
			console.log("hahaha")

			var appgallery = CKEDITOR.plugins.appgallery;

			editor.addCommand('gallery', appgallery.commands.gallery);

			if (editor.ui.addButton) {
				editor.ui.addButton('gallery', {
					label: editor.lang.appgallery.toolbar,
					command: 'gallery',
					toolbar: 'mode,10'
				});
				window.__ckeditor = editor;
			}

		}
	});

})();

CKEDITOR.plugins.appgallery = {
	commands: {
		gallery: {
			modes: { wysiwyg: 1, source: 1 },
			editorFocus: false,
			readOnly: 1,
			exec: function (editor) {
				
				GalleryModal.open(editor);
			},

			canUndo: false
		}
	}
};
