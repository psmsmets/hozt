function addAnimation(id, effect) {
    $('#'+id).removeClass().addClass(effect + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
};

function toClipboard(id){
    var element = document.getElementById(id);
    var textArea = document.createElement("textarea");
    textArea.value = element.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
};


// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 10;
var navbarHeight = $('#nav-categories').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('#nav-categories').animate({'opacity':'0'},200,function(){ 
            $(this).removeClass('nav-down').addClass('nav-up');
        });
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('#nav-categories').removeClass('nav-up').addClass('nav-down');
            $('#nav-categories').animate({'opacity':'1'},200);
        }
    }
    
    lastScrollTop = st;
}


$(document).ready(function(){

    $(function () {
        'use strict'
        $('[data-toggle="offcanvas"]').on('click', function(){
            $('.offcanvas-collapse').toggleClass('open')
        })
    })

    // activate tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('#toTop').click(function(e){
        $.scrollTo(0, 800); 
    });

    $('#navbarHeader').on('shown.bs.collapse', function(e){
        var options = {
            useEasing: true, 
            useGrouping: true, 
            separator: ',', 
            decimal: '.', 
        };
        var demo = new CountUp('count-groepen', 0, 9, 0, 3.5, options);
        if (!demo.error){
            demo.start();
        } else {
            console.error(demo.error);
        }
        var demo = new CountUp('count-trainers', 0, 10, 0, 3.5, options);
        if (!demo.error){
            demo.start();
        } else {
            console.error(demo.error);
        } 
        var demo = new CountUp('count-zwemmers', 0, 124, 0, 3.5, options);
        if (!demo.error){
            demo.start();
        } else {
            console.error(demo.error);
        }
    });


    /*  init back to top icon */
    var scrollPos; 
    var toTopVisible=false;
    var toTop = document.getElementById('toTop');

    /*  init banner parallax scroll */ 
    var bannerVelocity = .45;
    var bannerPos0 = $('.banner').css('backgroundPosition').split(" ");
    var bannerHeight0 = $('.banner').height() + $('#nav-categories').height();
    var bannerPosY0 = parseInt(bannerPos0[1]);
    var bannerPosY;
    var bannerImgTop0 = 50;
    var bannerImgTop;
 
    /* Every time the window is scrolled ... */
    $(window).scroll( function(){
        scrollPos = $(window).scrollTop();
        // show back to top
        if ( scrollPos >= 400 && !toTopVisible ){
            toTopVisible=true;
            toTop.style.visibility="visible";
            toTop.style.opacity="0";
            $('#toTop').animate({'opacity':'1'},750);
        } 
        if ( scrollPos < 400 && toTopVisible ){
            toTopVisible=false;
            $('#toTop').animate({'opacity':'0'},750,function(){ 
                toTop.style.visibility="hidden";
            });
        }
        /* Check the location of each desired element */
        $('.scroll-fade-in').each( function(i){     
            var bottom_of_object = $(this).position().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();      
            /* If the object is completely visible in the window, fade it it */
            if (bottom_of_window-300 > bottom_of_object){
                $(this).animate({'opacity':'1'},1500);
            }      
        });
      
        if (scrollPos <= bannerHeight0) {
            $('.banner').each(function() {
                bannerPosY = bannerPosY0 + ((bannerHeight0-scrollPos)/bannerHeight0-1)*50 * bannerVelocity;
                $(this).css('backgroundPosition',bannerPos0[0] + ' ' + bannerPosY + '%'); 
            }); 
            $('.carousel-item').each(function() {
                bannerImgTop = bannerImgTop0 - 2 * ((bannerHeight0-scrollPos)/bannerHeight0-1)*50 * bannerVelocity;
                $(this).children('img').css('top', bannerImgTop + '%'); 
            }); 
        }
 
    });

});
