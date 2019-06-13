/*$('.menu-scroll').hide();
var hauteur = 100;
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > hauteur) {
            console.log("Test");
            $('.menu-principal').hide();
            $('.menu-scroll').show();
        } else {
            console.log("Retour");
            $('.menu-scroll').hide();
            $('.menu-principal').show();
        }
    });
}); */



$('.menu-scroll').hide();

$(window).scroll(function () {
    posScroll = $(document).scrollTop();
    if (posScroll >= 100) {
        console.log("Retour");
        $('.menu-scroll').slideDown('slow');
    }
    else {
        $('.menu-scroll').slideUp('slow');
    }
});


