$('.menu-scroll').hide();
var hauteur = 100;
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > hauteur) {
            $('.menu-principal').fadeOut();
            $('.menu-scroll').fadeIn();
        } else {

            $('.menu-scroll').fadeOut();
            $('.menu-principal').fadeIn();
        }
    });
});




