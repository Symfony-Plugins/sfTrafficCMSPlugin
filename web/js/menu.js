$(document).ready(function(){
     // Menu
    $('.cms_menu ul li').hover(function() {
        $('ul', this).show();
        $(this).addClass('hover');
    }, function() {
        $('ul', this).hide();
        $(this).removeClass('hover');
    }); 
});