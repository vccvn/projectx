var prefixClass = ".crazy-";
var detailClass = prefixClass+"product-detail";

$(detailClass+" "+prefixClass+"product-varients").on("click", ".variant-value-item", function (e, owner) {
    e.stopPropagation();
    console.log(this);
    var data = {
        product_id: $(this).closest(detailClass).data("id"),
        properties: []
    };
    setTimeout(function () {
        $(detailClass+" "+prefixClass+"product-varients").find('select, input[type="radio"]:checked, input[type="rcheckbox"]:checked').map(function (inp) {
            data.properties.push($(inp).val());
        });
        console.log(data);
    }, 10);

});