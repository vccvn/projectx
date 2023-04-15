"use strict";
var tinymce = tinymce || {};
//Register the plugin
tinymce.PluginManager.add('customplateplugin', function (ed, url) {// ed as editor

    var cssClass = "plate";// your classname
    //your custom logic when button clicked
    ed.addCommand('customplatecmd', function () {
        if (ed.selection.getNode().parentElement.className === cssClass) {
                    var bm = ed.selection.getBookmark();
                    ed.selection.getNode().parentElement.outerHTML = ed.selection.getNode().parentElement.innerHTML;
                    ed.selection.moveToBookmark(bm);
                }
        else if (ed.selection.getNode().parentElement.parentElement != undefined &&
                ed.selection.getNode().parentElement.parentElement.className === cssClass) {
                    var bm = ed.selection.getBookmark();
                    ed.selection.getNode().parentElement.parentElement.outerHTML = ed.selection.getNode().parentElement.parentElement.innerHTML;
                    ed.selection.moveToBookmark(bm);
        }
        else {

            if (ed.selection.getSelectedBlocks().length > 1) {
                ed.selection.setContent('<div class="' + cssClass+'">' +
                    ed.selection.getContent() +
                    '</div>');
                ed.focus();
            }
            else {
                if (ed.selection.getNode().nodeName === "P") {
                    // Stores a bookmark of the current selection
                    var bm = ed.selection.getBookmark();
                    ed.selection.select(ed.selection.getNode(), true);
                    ed.selection.setContent('<div class="' + cssClass+'">' +
                        ed.selection.getNode().outerHTML +
                        '</div>');
                    // Restore the selection bookmark
                    ed.selection.moveToBookmark(bm);
                }
                else if (ed.selection.getNode().parentNode.nodeName === "P") {
                    ed.selection.select(ed.selection.getNode().parentNode, true);
                    ed.selection.setContent('<div class="' + cssClass+'">' +
                        ed.selection.getNode().outerHTML +
                        '</div>');
                }
                ed.focus();
            }
        }
     });

    // Register custom button
    ed.addButton('customplateplugin', {
        title: 'Plate',
        cmd: 'customplatecmd',
        image: url + '/img/plate.png',
        onclick: function () {
            ed.focus();
            //ed.selection.setContent('Hello world!');
            window.tinyMCE.activeEditor.execCommand('customplatecmd');
        }
        , onpostrender: monitorNodeChange //remove this if you would be able to mark several blocks
    });

    // Add a node change handler, selects the button in the UI when a P tag is selected
    function monitorNodeChange() {
        var btn = this;
        ed.on('NodeChange',
            function (e) {
                btn.disabled(!e.element || !e.element.nodeName ||
                    (e.element.nodeName.toLowerCase() !== "p" && e.element.parentNode.nodeName.toLowerCase() !== "p"));//
            });
    }

    return {
        getMetadata: function () {
            return {
                name: 'Gray plate plugin',
                url: 'https://devblog.gosso.se/?p=796'
            };
        }
    };
 });
