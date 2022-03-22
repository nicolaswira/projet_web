$(document).ready(function(){
    $("#li_stages").delay(2000).addClass("hover");

    $(".heart-1").click(function() {
        $(".heart-1").css("display", "none");
        $(".heart-2").css("display", "block");
    });
    $(".heart-2").click(function() {
        $(".heart-2").css("display", "none");
        $(".heart-1").css("display", "block");
    });
});