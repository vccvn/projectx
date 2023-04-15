

    var paymentMethods = $(prefixClass + "payment-methods");
    
    if(paymentMethods.length){
        var hidePaymentMethodDescription = function(){
            paymentMethods.find(prefixClass+"payment-method-description").removeClass('show');

        };
        var showPaymentMethodDescription = function(value){
            hidePaymentMethodDescription();
            paymentMethods.find(prefixClass+"payment-method-description[data-method="+value+"]").addClass('show');
        }

        var paymentValues = paymentMethods.find(prefixClass + "payment-method-value");
        // hidePaymentMethodDescription();
        paymentValues.map(function(e){
            if($(e).is(":checked")){
                showPaymentMethodDescription($(e).val());
            }
        });
        $(document).on('change', prefixClass + "payment-method-value", function(e){
            if($(this).is(":checked")){
                showPaymentMethodDescription($(this).val());
            }
        });

    }