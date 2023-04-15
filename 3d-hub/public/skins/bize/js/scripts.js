/*==================================
 Template Name: BizDeal - Business Landing Page Template
 Description: BizDeal is a powerful 100% Responsive Multipurpose Corporate Business, Marketing, Startup Agency Landing Page Template.
 Version: 1.0
 Author: https://themeforest.net/user/htmllover/portfolio

 ==================================== */

// TABLE OF CONTENTS

//  1. preloader
//  2. back to top
//  3. easeScroll
//  4. jQuery to collapse the navbar on scroll
//  5. ytplayer for hero background video
//  6. client testimonial slider
//  7. magnific popup video
//  8. hero text slider
//  9. team slider
//  10. why us or biz success story
//  11. hero background slider
//  12. typed js
//  13. magnific popup for project details
//  14. portfolio isotope
// 15. Ajax contact form validator

jQuery(function ($) {

    'use strict';

    //  1. preloader
    $(window).ready(function() {
        $('#status').fadeOut();
        $('#preloader').delay(200).fadeOut('slow');


    });

    //  2. back to top
    (function(){

        $('body').append('<div id="toTop"><span>Up</span></div>');

        $(window).scroll(function () {
            if ($(this).scrollTop() != 0) {
                $('#toTop').fadeIn();
            } else {
                $('#toTop').fadeOut();
            }
        });

        $('#toTop').on('click',function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });

    }());

    //  3. easeScroll
    $("html").easeScroll({
        animationTime: 1200,
        stepSize: 150,
        pulseAlgorithm: 1,
        pulseScale: 8,
        pulseNormalize: 1,
        accelerationDelta: 20,
        accelerationMax: 1,
        keyboardSupport: true,
        arrowScroll: 50,
        touchpadSupport: true,
        fixedBackground: true
    });

    //  4. jQuery to collapse the navbar on scroll
    $(window).scroll(function() {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });

    //jQuery for page scrolling feature - requires jQuery Easing plugin
    $(function() {
        $(document).on('click', 'a.page-scroll', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 900, 'easeInOutExpo');
            event.preventDefault();
        });
    });
    // closes the responsive menu on menu item click
    $(".navbar-nav li a").on("click", function(event) {
        if (!$(this).parent().hasClass('dropdown'))
            $(".navbar-collapse").collapse('hide');
    });


    //  5. ytplayer for hero background video
    $(".player").mb_YTPlayer();


    //  6. client testimonial slider
    $('.client-testimonial').owlCarousel({
        items:1,
        loop:true,
        dots: true,
        margin:10,
        autoplay:true,
        autoplayTimeout:5500,
        autoplayStopOnLast: false
    });

    //  7. magnific popup video
    $('.video').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    //  8. hero text slider
    $('.hero-text-slider').owlCarousel({
        responsiveClass:true,
        margin: 10,
        items:1,
        dots: true,
        autoplay: 2400,
        loop: true,
        autoplayStopOnLast: false,
        autoWidth:false
    });

    //  9. team slider
    $('.team-carousel').owlCarousel({
        responsiveClass:true,
        margin:30,
        dots: false,
        loop: false,
        autoWidth:false,
        nav:true,
        autoplay: 2400,
        navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            800:{
                items:3
            },
            1200:{
                items:4
            }

        }

    });

    //  10. why us or biz success story
    $('.biz-success-story').owlCarousel({
        loop:true,
        items:1,
        responsiveClass:true,
        margin:30,
        dots: false,
        autoWidth:false,
        nav:true,
        autoplay: 2000,
        navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    });


    //  11. hero background slider
    $('.hero-background-slider').owlCarousel({
        loop: true,
        items: 1,
        autoplay: true,
        dots: true,
        nav: false,
        autoplayTimeout:3400

    });

    var type_data_arr = (typeof type_data != 'undefined' && typeof type_data[0] != 'undefined')?type_data:["App Development", "Web Development"];
    //  12. typed js
    var typed = $(".typed");
    $(function() {
        typed.typed({
            strings: type_data_arr,
            typeSpeed: 130,
            loop: true
        });
    });

    //  13. magnific popup for project details
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
            open: function() {
                var lazyLoad = $(this.currItem.inlineElement[0]).find('.biz-lazyload');
                if(lazyLoad.length){
                    
                    for (let index = 0; index < lazyLoad.length; index++) {
                        const element = lazyLoad[index];
                        $(element).attr('src', $(element).data('src'));
                    }
                
                }
            },
            close: function() {
            // Will fire when popup is closed
            }
        }
    });

    //  14. portfolio isotope
    $('.grid').imagesLoaded( function() {
        var $grid = $('.grid').isotope({
            // options
            itemSelector: '.project-item',
            layoutMode: 'fitRows'
        });

        // filter items on button click
        $('.filters-button-group').on( 'click', 'a', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });
        // change is-checked class on buttons
        $('.button-group').each( function( i, buttonGroup ) {
            var $buttonGroup = $( buttonGroup );
            $buttonGroup.on( 'click', 'a', function() {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $( this ).addClass('is-checked');
            });
        });
    });

    // 15. Ajax contact form validator
    $(function() {

        // Get the form.
        var form = $('#contactForm1');

        // Get the messages div.
        var formMessages = $('.form-message');

        // Set up an event listener for the contact form.
        $(form).submit(function(e) {
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
                .done(function(response) {
                    // Make sure that the formMessages div has the 'success' class.
                    $(formMessages).removeClass('error');
                    $(formMessages).addClass('success');

                    // Set the message text.
                    $(formMessages).text(response);

                    // Clear the form.
                    form.find('input[type="text"], input[type="email"], textarea').val('');
                })
                .fail(function(data) {
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

    });

    // var lazyLoad = $('.biz-lazyload');
    // if(lazyLoad.length){
    //     setTimeout(function(){
    //         for (let index = 0; index < lazyLoad.length; index++) {
    //             const element = lazyLoad[index];
    //             $(element).attr('src', $(element).data('src'));
    //         }
    //     }, 1000);
    // }

    // $('.biz-lazyload').Lazy();
}); // JQuery end
