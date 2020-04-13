$("#mobile-menu").click(function(){
    $(".navmenu").css('width','100%');
    $("#close-menu").css('display','block');
});
$("#close-menu").click(function(){
    $(".navmenu").css('width','0');
    $(this).css('display','none');
});
