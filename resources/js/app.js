require('./bootstrap');

require('alpinejs');

$(document).ready(function() {

    $("button#add-to-cart").on("click", function(e) {
        var quantity = e.currentTarget.previousElementSibling;
        var product_id = e.currentTarget.nextElementSibling;
        var available = $("#available-" + product_id.innerHTML);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        $.ajax({
            url: "/transaction",
            type: "POST",
            dataType: 'JSON',
            data: {
                'quantity': quantity.value,
                'product_id': product_id.innerHTML,
            },
            success: function(data) {
                // create alert of successful purchase
                var alert = $("<div id='alert-div' class='sticky-top shadow alert alert-success alert-dismissible fade show m-3' role='alert'>"
                    + "<p id='alert'>" + data.msg + "</p>"
                    + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                    + "<span aria-hidden='true'>&times;</span>"
                    + "</button></div>");
                $("#alert-target").html(alert);

                // update availability
                if(data.new_quantity > 0)
                {
                    available.html(data.new_status + " - " + data.new_quantity + " left");
                } else {
                    available.html(data.new_status)
                        .removeClass("green-text")
                        .addClass("red-text");
                    $("#quantity-" + product_id.innerHTML).remove();
                    e.currentTarget.remove();
                }

            },
            error: function(data) {
                var msg = "Invalid purchase request";
                if(data.responseJSON.errors.product_id)
                {
                    msg = data.responseJSON.errors.product_id[0];
                } else if(data.responseJSON.errors.quantity)
                {
                    msg = data.responseJSON.errors.quantity[0];
                }

                var alert = $("<div id='alert-div' class='sticky-top shadow alert alert-danger alert-dismissible fade show m-3' role='alert'>"
                    + "<p id='alert'>" + msg + "</p>"
                    + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                    + "<span aria-hidden='true'>&times;</span>"
                    + "</button></div>");
                $("#alert-target").html(alert);
            }

        });
    });
});
