require('./bootstrap');

require('alpinejs');

$(document).ready(function() {

    $("button#add-to-cart").on("click", function(e) {
        var quantity = e.currentTarget.previousElementSibling.value;
        var product_id = e.currentTarget.nextElementSibling.innerHTML;
        // var alert = $("#alert");
        // var alert_div = $("#alert-div");

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
                'quantity': quantity,
                'product_id': product_id,
            },
            success: function(data) {
                var alert = $("<div id='alert-div' class='sticky-top shadow alert alert-success alert-dismissible fade show m-3' role='alert'>"
                    + "<p id='alert'>" + data + "</p>"
                    + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                    + "<span aria-hidden='true'>&times;</span>"
                    + "</button></div>");
                $("#alert-target").html(alert);
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
