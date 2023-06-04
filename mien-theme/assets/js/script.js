$(function () {

    
    /*=====================
      14. Product page Quantity Counter
     ==========================*/
     $(".qty-box .quantity-right-plus").on("click", function () {
        var $qty = $(".qty-box .input-number");
        var currentVal = parseInt($qty.val(), 10);
        if (!isNaN(currentVal)) {
            $qty.val(currentVal + 1);
            var f= $qty.closest('.crazy-product-order-form');
            if(f.length){
                App.products.checkPriceOfForm(f[0]);
            }
        }
    });


    $(".qty-box .quantity-left-minus").on("click", function () {
        var $qty = $(".qty-box .input-number");
        var currentVal = parseInt($qty.val(), 10);
        if (!isNaN(currentVal) && currentVal > 1) {
            $qty.val(currentVal - 1);
            var f= $qty.closest('.crazy-product-order-form');
            if(f.length){
                App.products.checkPriceOfForm(f[0]);
            }
        }
    });


    $('.grid').isotope({
        itemSelector: '.grid-item',
        percentPosition: true,
        masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: '.grid-sizer'
        }
    })

    if($('.swiper-viewer').length){

        var swiper = new Swiper(".swiper-thumbnails", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".swiper-viewer", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });
    }
});