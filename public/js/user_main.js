// const { update } = require("lodash");

$(function () {

    $(window).on('load', function (event) {
        $('.load').delay(500).fadeOut('slow');
    });

    $(function () {
        var get_src;
        // hiển thị hình ảnh mặc định
        get_src = $("#list-thumb a:first-child img").attr('src');
        $("#show img#show_img").attr('src', get_src);
        // lấy src đẩy lên #show
        $("#list-thumb a#onn").click(function () {
            get_src = $(this).children('img').attr('src');
            $("#show img#show_img").attr('src', get_src);

            return false;
        });
    });


});

function updateCart(qty, rowId) {
    var urlUpdate = $(".num-order").attr('data-uri');
    var url = location.href;
    url += " #cartx";
    $.get(
        urlUpdate,
        { qty: qty, rowId: rowId },
        function () {
            // location.reload();
            $("#info-cart-wp").load(url);
        }
    );
}


