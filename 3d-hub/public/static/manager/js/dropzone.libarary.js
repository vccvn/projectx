var mDropzoneLibarary={
    init:function(){
        var dropzoneLibarary = new Dropzone("#dropzone-libarary", {
            paramName:"file",
            maxFiles:10,
            maxFilesize:150,
            addRemoveLinks:!0,
            renameFile:true,
            acceptedFiles:"image/*,application/pdf,.psd",
            accept:function(e,o){"justinbieber.jpg"==e.name?o("Naha, you don't."):o()}
        });
        dropzoneLibarary.on("complete", function(file) { 
            if(file.xhr){
                if(file.xhr.response){
                    var response = JSON.parse(file.xhr.response);
                    if(response.status){
                        setTimeout(function(){
                            App.libarary.prepand(response.data);
                            dropzoneGallery.removeFile(file);
                        }, 1000);
                    }
                    
                }
            }
        });
    }
};

mDropzoneLibarary.init();

// $(function(){
//     // 
//     $("#dropzone-gallery").dropzone({url:'admin/files/upload'});
// });
