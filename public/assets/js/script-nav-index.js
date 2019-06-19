$('.menu-scroll').hide();
var hauteur = 1000;
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > hauteur) {
            $('.menu-scroll').fadeIn();
        } else {

            $('.menu-scroll').fadeOut();
        }
    });
});