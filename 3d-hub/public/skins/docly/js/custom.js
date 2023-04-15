$(function () {

    //four Item Carousel
    if ($('.docly-carousel').length) {
        var $cic = $('.docly-carousel');
        var dataResponsive = {
            1: { 0: { items: 1 }, 1024: { items: 1 } },
            2: { 0: { items: 1 }, 767: { items: 2 } },
            3: { 0: { items: 1 }, 600: { items: 2 }, 1024: { items: 3 } },
            4: { 0: { items: 1 }, 600: { items: 2 }, 992: { items: 4 }, 1200: { items: 4 } },
            5: { 0: { items: 1 }, 600: { items: 3 }, 800: { items: 4 }, 1024: { items: 4 }, 1200: { items: 5 } },
            6: { 0: { items: 1 }, 600: { items: 3 }, 800: { items: 4 }, 1024: { items: 4 }, 1200: { items: 6 } },
            8: { 0: { items: 1 }, 600: { items: 2 }, 800: { items: 4 }, 1024: { items: 6 }, 1200: { items: 8 } }
        };
        var banned = [undefined, null, NaN];
        $cic.each(function (index, elem) {
            var $el = $(elem);
            var mg = $el.data('margin');
            var sp = $el.data('speed');
            var sh = $el.data('show');
            var show = (banned.indexOf(sh) == -1 && sh !== null) ? parseInt(sh) : 4;
            var loop = $el.data('loop') ? true : false;
            var margin = (banned.indexOf(mg) == -1 && mg !== null) ? parseInt(mg) : 30;
            var dots = $el.data('dots') ? true : false;
            var nav = $el.data('nav') ? true : false;
            var smartSpeed = (banned.indexOf(sp) == -1 && sp !== null) ? parseInt(sp) : 1000;
            var autoplay = $el.data('autoplay') ? true : false;
            var responsive = (typeof dataResponsive[show] != 'undefined') ? dataResponsive[show] : dataResponsive[4];
            var autoplayHoverPause = $el.data("hover-pause");
            var ahp = !autoplayHoverPause || (autoplayHoverPause && autoplayHoverPause != "false" && autoplayHoverPause != "0") ? true : false;
            var option = {
                loop: loop,
                margin: margin,
                nav: nav,
                dots: dots,
                smartSpeed: smartSpeed,
                autoplay: autoplay,
                autoplayHoverPause: ahp,
                navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
                responsive: responsive
            };
            $el.owlCarousel(option);
        });
    }
    //  6. client testimonial slider
    $('.client-testimonial').owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5500,
        autoplayStopOnLast: false
    });
    //  13. magnific popup for project details
    if ($('.details-popup').length && $('.details-popup').magnificPopup) {
        $('.details-popup').magnificPopup({
            type: 'inline',
            fixedContentPos: false, /* keep it false to avoid html tag shift with margin-right: 17px */
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-slide-bottom',
            preloader: true,

            callbacks: {
                open: function () {
                    var lazyLoad = $(this.currItem.inlineElement[0]).find('.biz-lazyload');
                    if (lazyLoad.length) {

                        for (let index = 0; index < lazyLoad.length; index++) {
                            const element = lazyLoad[index];
                            $(element).attr('src', $(element).data('src'));
                        }

                    }
                },
                close: function () {
                    // Will fire when popup is closed
                }
            }
        });
    }

    //  14. portfolio isotope
    $('.grid').imagesLoaded(function () {
        var $grid = $('.grid').isotope({
            // options
            itemSelector: '.project-item',
            layoutMode: 'fitRows'
        });

        // filter items on button click
        $('.filters-button-group').on('click', 'a', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });
        // change is-checked class on buttons
        $('.button-group').each(function (i, buttonGroup) {
            var $buttonGroup = $(buttonGroup);
            $buttonGroup.on('click', 'a', function () {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $(this).addClass('is-checked');
            });
        });
    });

    // Get the form.
    var form = $('#contactForm1');

    // Get the messages div.
    var formMessages = $('.form-message');

    // Set up an event listener for the contact form.
    $(form).submit(function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        // Serialize the form data.
        var formData = $(form).serialize();

        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: $(form).data('ajax-url'),
            data: formData
        })
            .done(function (response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('error');
                $(formMessages).addClass('success');

                // Set the message text.
                $(formMessages).text(response);

                // Clear the form.
                form.find('input[type="text"], input[type="email"], textarea').val('');
            })
            .fail(function (data) {
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass('success');
                $(formMessages).addClass('error');

                // Set the message text.
                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text('Oops! An error occured and your message could not be sent.');
                }
            });
    });

    function doAnimations(elems) {
        //Cache the animationend event in a variable
        var animEndEv = 'webkitAnimationEnd animationend';
        elems.each(function () {
            var $this = $(this),
                $animationType = $this.data('animation');
            $this.addClass($animationType).one(animEndEv, function () {
                $this.removeClass($animationType);
            });
        });
    }
    function undoAnimations(elems) {
        //Cache the animationend event in a variable
        var animEndEv = 'webkitAnimationEnd animationend';
        elems.each(function () {
            var $this = $(this),
                $animationType = $this.data('animation');
            $this.removeClass($animationType);
        });
    }

    //four Item Carousel
    if ($('.animate-carousel').length) {
        var $cic = $('.animate-carousel');
        var dataResponsive = {
            1: { 0: { items: 1 }, 1024: { items: 1 } },
            2: { 0: { items: 1 }, 767: { items: 2 } },
            3: { 0: { items: 1 }, 600: { items: 2 }, 1024: { items: 3 } },
            4: { 0: { items: 1 }, 600: { items: 2 }, 992: { items: 4 }, 1200: { items: 4 } },
            5: { 0: { items: 1 }, 600: { items: 3 }, 800: { items: 4 }, 1024: { items: 4 }, 1200: { items: 5 } },
            6: { 0: { items: 1 }, 600: { items: 3 }, 800: { items: 4 }, 1024: { items: 4 }, 1200: { items: 6 } },
            8: { 0: { items: 1 }, 600: { items: 2 }, 800: { items: 4 }, 1024: { items: 6 }, 1200: { items: 8 } }
        };
        var banned = [undefined, null, NaN];
        $cic.each(function (index, elem) {
            var $el = $(elem);
            var $firstAnimatingElems = $el.find('.item:first').find("[data-animation ^= 'animated']");
            doAnimations($firstAnimatingElems);
            var mg = $el.data('margin');
            var sp = $el.data('speed');
            var sh = $el.data('show');
            var at = $el.data('timeout') || $el.data('delay');
            var autoplayTimeout = (at !== null) ? parseInt(at) : 5000;
            if(isNaN(autoplayTimeout) || autoplayTimeout <= 0) autoplayTimeout = 5000;
            
            var show = (banned.indexOf(sh) == -1 && sh !== null) ? parseInt(sh) : 4;
            var loop = $el.data('loop') ? true : false;
            var margin = (banned.indexOf(mg) == -1 && mg !== null) ? parseInt(mg) : 30;
            var dots = $el.data('dots') ? true : false;
            var nav = $el.data('nav') ? true : false;
            var smartSpeed = (banned.indexOf(sp) == -1 && sp !== null) ? parseInt(sp) : 1000;
            var autoplay = $el.data('autoplay') ? true : false;
            var responsive = (typeof dataResponsive[show] != 'undefined') ? dataResponsive[show] : dataResponsive[4];
            var autoplayHoverPause = $el.data("hover-pause");
            var ahp = !autoplayHoverPause || (autoplayHoverPause && autoplayHoverPause != "false" && autoplayHoverPause != "0") ? true : false;
            var option = {
                autoplayTimeout: autoplayTimeout,
                loop: loop,
                margin: margin,
                nav: nav,
                dots: dots,
                smartSpeed: smartSpeed,
                autoplay: autoplay,
                autoplayHoverPause: ahp,
                navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
                responsive: responsive
            };
            $el.owlCarousel(option);
            

            $el.on('changed.owl.carousel', function(event) {
                var $animatingElems = $(event.target).find("[data-animation ^= 'animated']");
                doAnimations($animatingElems);
                $(event.target).find('.slider-thumb').addClass('animated-zoom');
            });
            $el.on('drag.owl.carousel', function(event) {
                var $animatingElems = $(event.target).find("[data-animation ^= 'animated']");
                undoAnimations($animatingElems);
                
                $(event.target).find('.animated-zoom').removeClass('animated-zoom');
            });
        });
    }
    if($('form.crazy-form').length){
        var isSubmitting = false;
        $('form.crazy-form').on("submit", function(e){
            if(isSubmitting){
                e.preventDefault();
                App.Swal.warning('Đang xử lý. Chờ giây lát', null, function(){
                    App.Swal.showLoading(50000000);
                })
                return false;
            }
            isSubmitting = true;
            $(this).find('[type="submit"]').html("Đang xử lý...");
            App.Swal.showLoading(50000000);
        })
    }
});