"use strict";
var tinymce = tinymce || {};
//Register the plugin
tinymce.PluginManager.add('customimagebuttonplugin', function (editor, url) {

    //your custom logic when button clicked
    editor.addCommand('tinymcecustombutton', function () {
        var isUpdate = false;

        //default values 
        var align = "left";
        var width = "50%";
        var description = "";

        //On open
        if (editor.selection.getNode().parentElement.tagName === "DIV"
            && editor.selection.getNode().parentElement.className.includes("image")) {
            width = editor.selection.getNode().parentElement.style.maxWidth;
            description = editor.selection.getNode().parentElement.textContent;
            align = editor.selection.getNode().parentElement.className.replace("image", "");
            isUpdate = true;
        } 

        // Open window
        editor.windowManager.open({
            title: 'Image description',
            body: [
                { type: 'textbox', name: 'description', label: 'Description', value: description },
                { type: 'textbox', name: 'width', label: 'Width (px eller %)', value: width },
                {
                    type: 'listbox',
                    name: 'align',
                    label: 'Align',
                    values: [
                        { text: 'Left', value: 'left' }, //tinymce.DOM.decode("V&auml;nster") <-- for swedish
                        { text: 'Right', value: 'right' },
                        { text: 'Center', value: 'center' }
                    ],
                    value: align // Sets the default
                }
            ],
            onsubmit: function (e) {
                var alignmentclass = 'image' + e.data.align;
                var selectedimg = editor.selection.getNode();
                var width = e.data.width;
                if (width !== undefined && !width.includes("px") && !width.includes("%")) {
                    if (width > 100)
                        width += "px";
                    else if (width === "")
                        width = "50%";
                    else
                        width += "%";
                }

                if (isUpdate) {
                    selectedimg.parentElement.dataset.mceStyle = "max-width: " + width;
                    window.tinyMCE.DOM.setStyle(selectedimg.parentElement, "max-width", width);
                    selectedimg.parentElement.className = alignmentclass;
                    selectedimg.parentElement.childNodes[1].innerText = e.data.description;
                } else { //first time use
                    if (selectedimg.src) {
                        var arr = selectedimg.src.split("/");
                        var src = "/" + arr.splice(3, arr.length).join("/");
                        editor.selection.setContent('<div style=max-width:' +
                            width +
                            ' class=' +
                            alignmentclass +
                            '><img src=' +
                            src +
                            ' class="img-responsive" alt="" /><p>' +
                            e.data.description +
                            '</p></div>');
                    }
                }
            }
        });
    });

    // Register custom button
    editor.addButton('customimagebuttonplugin', {
        title: 'Image description',
        cmd: 'tinymcecustombutton',
        image: url + '/img/img.png',
        onpostrender: monitorNodeChange
    });

    //highlight the button when IMG is selected
    function monitorNodeChange() {
        var btn = this;
        editor.on('NodeChange',
            function (e) {
                btn.disabled(!e.element ||
                    !e.element.nodeName ||
                    e.element.nodeName.toLowerCase() !== "img");
            });
    }

    //information shown on help-button
    return {
        getMetadata: function () {
            return {
                name: 'Image description plugin',
                url: 'https://devblog.gosso.se/?p=792'
            };
        }
    };
});