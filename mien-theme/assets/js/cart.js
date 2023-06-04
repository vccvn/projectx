function wisestyle_update_cart_attribute(item){
    if(item){
        
        if(item.attributes && item.attributes.length){
            for (let index = 0; index < item.attributes.length; index++) {
                const attr = item.attributes[index];
                
                $('#cart-item-' + item.id + " .crazy-cart-item-attribute-value-" + attr.name).html(attr.text);
            }
        }
    }
}

    /*=====================
      15.5. cart Quantity Counter
     ==========================*/
     $(".cart-item-qty .quantity-right-plus").on("click", function () {
        var $qty = $(this).closest(".cart-item-qty").find('.crazy-item-quantity');
        var currentVal = parseInt($qty.val(), 10);
        if (!isNaN(currentVal)) {
            $qty.val(currentVal + 1);
            App.cart.updateAllCartItemQuantity();

        }
    });


    $(".cart-item-qty .quantity-left-minus").on("click", function () {
        var $qty = $(this).closest(".cart-item-qty").find('.crazy-item-quantity');
        var currentVal = parseInt($qty.val(), 10);
        if (!isNaN(currentVal) && currentVal > 1) {
            $qty.val(currentVal - 1);
            App.cart.updateAllCartItemQuantity();
        }
    });
