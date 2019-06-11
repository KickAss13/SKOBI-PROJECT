$(document).ready(function() {
    console.log("kikou");
    console.log("cache");
    $("#cache").hide();
    $('.fournisseur').hover(function(){
        $("#cache").show();
    });
    $('.fournisseur').mouseleave(function(){
        $("#cache").hide();
    });
})
