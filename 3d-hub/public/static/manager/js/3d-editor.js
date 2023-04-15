
!function(){
    var approot = document.querySelector('.angular-app-root');
    var prg = document.getElementById('preview-progress-bar');
    var fp = document.querySelector('.fix-pos');
    __3DHubTaskManager__.add('loading.progress', function(p){
        prg.style.width = p+'%';
    });
    __3DHubTaskManager__.add('loading.complete', function(obj){
        setTimeout(function () {
            var a = document.querySelector('.pre-loading-image'), 
                b = document.querySelector('.load-block'), 
                c = document.querySelector('.fix-pos');
                if(a) a.style.display = 'none';
            if(b) b.style.display = 'none';
            if(c) c.style.display = 'none';
            if(fp.parentNode) fp.parentNode.removeChild(fp);
            approot.classList.remove('angular-app-root');
            var link = document.getElementById('pre-loading-css-link');
            if(link) link.parentNode.removeChild(link);
        }, 2000)
    });
    
}();    
