$(document).ready(function () {
    var url = location.href;
    url += "/1";

    filter_data(); 

    function filter_data() {
        var action = 'get_data';
        var minimum_price = $("#hidden_minimum_price").val();
        var maximum_price = $("#hidden_maximum_price").val();
        var brand = get_filter('brand');
        var status = $("#status_filter").find(":selected").val();
        
        $.ajax({
            url: url,
            method: "GET",
            data: { action: action, minimum_price: minimum_price, maximum_price: maximum_price, brand: brand, status: status },
            type: Text,
            success: function (data) {
                $("#list_products").html(data);
            }
        });
    }

    $("#status_filter").on('change', function(){
        filter_data();
    });
    

    function get_filter(class_name) {
        var filter = [];
        $("." + class_name + ':checked').each(function () {
            filter.push($(this).val());
        });
        return filter;
    }

    $(".common_selector").click(function () {
        filter_data();
    });

    $("#price_range").slider({
        range: true,
        min: 500000,
        max: 100000000,
        values: [500000, 100000000],
        step: 500000,
        stop: function (event, ui) {
            $("#price_show").html("Từ: " + ui.values[0] + " - " + ui.values[1]);
            $("#hidden_minimum_price").val(ui.values[0]);
            $("#hidden_maximum_price").val(ui.values[1]);
            filter_data();
        }
    })
});