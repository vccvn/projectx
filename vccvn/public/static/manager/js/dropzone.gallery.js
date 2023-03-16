var mDropzoneGallery={
    init:function(){
        var dropzoneGallery = new Dropzone("#dropzone-gallery", {
            paramName:"file",
            maxFiles:10,
            maxFilesize:150,
            addRemoveLinks:!0,
            renameFile:true,
            acceptedFiles:"image/*,application/pdf,.psd",
            accept:function(e,o){"justinbieber.jpg"==e.name?o("Naha, you don't."):o()}
        });
        dropzoneGallery.on("complete", function(file) { 
            if(file.xhr){
                if(file.xhr.response){
                    var response = JSON.parse(file.xhr.response);
                    if(response.status){
                        setTimeout(function(){
                            GalleryModal.prepand(response.data);
                            dropzoneGallery.removeFile(file);
                        }, 1000);
                    }
                    
                }
            }
        });
    }
};

mDropzoneGallery.init();

// $(function(){
//     // 
//     $("#dropzone-gallery").dropzone({url:'admin/files/upload'});
// });
