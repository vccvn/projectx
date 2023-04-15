
!function(){
    var approot = document.querySelector('.angular-app-root');
    var prg = document.getElementById('preview-progress-bar');
    var fp = document.querySelector('.fix-pos');
    __3DHubTaskManager__.add('model-item.progress', function(p){
        prg.style.width = p+'%';
    });
    __3DHubTaskManager__.add('model-item.complete', function(obj){
        setTimeout(function () {
            document.querySelector('.pre-loading-image').style.display = 'none';
            document.querySelector('.load-block').style.display = 'none';
            document.querySelector('.fix-pos').style.display = 'none';
            fp.parentNode.removeChild(fp);
            approot.classList.remove('angular-app-root');
            var link = document.getElementById('pre-loading-css-link');
            link.parentNode.removeChild(link);
        }, 2000)
    });
    
}();    
