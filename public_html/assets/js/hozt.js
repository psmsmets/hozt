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
        var demo = new CountUp('count-zwemmers', 0, 114, 0, 3.5, options);
        if (!demo.error){
            demo.start();
        } else {
            console.error(demo.error);
        }
    });
 
    var toTopVisible=false;
    var toTop = document.getElementById('toTop');
 
    /* Every time the window is scrolled ... */
    $(window).scroll( function(){
        // show back to top
        if ( $(window).scrollTop() >= 400 && !toTopVisible ){
            toTopVisible=true;
            toTop.style.visibility="visible";
            toTop.style.opacity="0";
            $('#toTop').animate({'opacity':'1'},750);
        } 
        if ( $(window).scrollTop() < 400 && toTopVisible ){
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
    });
});
