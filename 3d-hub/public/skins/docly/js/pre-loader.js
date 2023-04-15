;(function ($) {
    "use strict";

    /*============= preloader js css =============*/
    if(typeof preloader_texts == "object"){
        var cites = [];
        for (const key in preloader_texts) {
            if (preloader_texts.hasOwnProperty(key)) {
                const text = preloader_texts[key];
                cites.push(text);
            }
        }
        if(cites.length){
            var cite = cites[Math.floor(Math.random() * cites.length)];
            $('#preloader p').text(cite);
        }
        
        
    }
    $('#preloader').addClass('loading');

    $(window).on( 'load', function() {
        setTimeout(function () {
            $('#preloader').fadeOut(500, function () {
                $('#preloader').removeClass('loading');
            });
        }, 500);
    });

})(jQuery)