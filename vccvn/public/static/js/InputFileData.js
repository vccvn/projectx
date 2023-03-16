
var inputFileData = (el, callback) => {
    if (!(el instanceof Element)) return false;
    var files = el.files;
    if (window.File && window.FileList && files && files.length) {
        var list = [];
        let max = files.length - 1;
        for (var i = 0; i < files.length; i++) {
            let file = files[i];
            if (window.FileReader) {
                (function (file, index, coumt) {
                    let fileReader = new FileReader();
                    fileReader.onload = function (f) {
                        let src = f.target.result;
                        let data = {
                            filename: file.name,
                            size: file.size,
                            data: src
                        };

                        list.push(data);
                        if (index == coumt) {
                            if ('multyple' in el) callback(list);
                            callback(list[0]);

                        }
                    };
                    fileReader.readAsDataURL(file);
                })(file, i, max);
            }

        }
    }
}

