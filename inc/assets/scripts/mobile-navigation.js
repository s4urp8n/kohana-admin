$(document).ready(function () {
    $('.mobile-navigation__checkbox').on('change', function () {
        $(".mobile-navigation__content").animate({
            height: "toggle"
        }, 500);
    });
});