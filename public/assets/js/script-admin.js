var etat = 'cache';
$('.menu-help').hide();
$(function () {
    $('#help-button').on('click', function (event) {
        if (etat == 'cache') {
            $('.menu-help').show();
            etat = 'visible';
        }
        else if (etat == 'visible') {
            $('.menu-help').hide();
            etat = 'cache';
        }
    }
    );
});