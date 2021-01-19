// const { update } = require("lodash");

$(function () {
    // hiệu ứng load trang
    $(window).on('load', function (event) {
        $('.load').delay(500).fadeOut('slow');
    });
    // hiển thị slider ảnh detail sản phẩm
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

    // search ajax
    $(function () {
        $("#s").keyup(function () {
            var keywords = $(this).val();
            var url = $(this).attr("data-uri");
            if (keywords != '') {
                $.get(
                    url,
                    { keywords: keywords },
                    function (data) {
                        $("#search-ajax").fadeIn();
                        $("#search-ajax").html(data);
                        console.log(data);
                    }
                );
            } else {
                $("#search-ajax").fadeOut();
            }
        });
    });
    // auto complete form search ajax
    $(document).on('click', '.li-search-ajax', function () {
        $("#s").val($(this).text());
        $("#search-ajax").fadeOut();
    });

});
// update cart ajax
function updateCart(qty, rowId) {
    var urlUpdate = $(".num-order").attr('data-uri');
    var url = location.href;
    url += " #cartx";
    $.get(
        urlUpdate,
        { qty: qty, rowId: rowId },
        function () {
            $("#info-cart-wp").load(url);
        }
    );
};
// load quận huyện ajax
function selectProvince(provinceId, urlUpdate) {
    $.get(
        urlUpdate,
        { provinceId: provinceId },
        function (data) {
            $("#district").html(data);
        }
    );
};
// load phường xã ajax
function selectDistrict(districtId, urlUpdate) {
    $.get(
        urlUpdate,
        { districtId: districtId },
        function (data) {
            $("#ward").html(data);
        }
    );
};




