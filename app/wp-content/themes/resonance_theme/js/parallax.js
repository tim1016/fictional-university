

jQuery(document).ready(function($){
    $(window).scroll(function(){
        parallax();
    });

    function parallax(){
        var wScroll = $(window).scrollTop();
    
        var scrolledY = -0.5 * $(window).scrollTop();
        $('.parallax--bg').css('background-position', 'left ' + (scrolledY) + 'px');
    
        //$('.parallax--bg').css('background-position', 'center ' +(wScroll*0.9) + 'px');
        //jQuery(window).trigger('resize').trigger('scroll');
    }
});

