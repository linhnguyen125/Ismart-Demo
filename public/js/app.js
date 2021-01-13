$(function () {
    $('.nav-link.active .sub-menu').slideDown();
    // $("p").slideUp();

    $('#sidebar-menu .arrow').click(function () {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).parents('li').toggleClass('active');
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(':checked');
        $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    });

    $('[data-toggle="tooltip"]').tooltip({
        placement: 'top',
        trigger: 'hover focus',
        html: true
    });

    $(window).on('load', function (event) {
        $('body').removeClass('preloading');
        $('.load').delay(500).fadeOut('slow');
    });
});
