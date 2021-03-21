require('./bootstrap');

require('alpinejs');

$(document).ready(function() {

    $("button#add-to-cart").on("click", function(e) {
        var quantity = e.currentTarget.previousElementSibling.value;
        var product_id = e.currentTarget.nextElementSibling.innerHTML;

        console.log(e);
        console.log(quantity);
        console.log(product_id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
        }),
        $.ajax({
            url: "/transaction",
            type: "POST",
            async: true,
            data: {
                'quantity': quantity,
                'product_id': product_id,
            },
            success: function(result){
                alert(result);
            }
        });
    });
});
