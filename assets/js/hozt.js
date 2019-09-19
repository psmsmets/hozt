require('../css/hozt.scss');

require('bootstrap');
require('jquery.scrollTo');
import { CountUp } from 'countup.js';

var $ = require('jquery');
window.$ = $;
window.jQuery = $;

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
    var st = $(window).scrollTop();

    // Make sure they scroll more than delta
    if (Math.abs(lastScrollTop - st) <= delta){
        return;
    }
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('#nav-categories').animate({'top':'-40px'},250);
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('#nav-categories').animate({'top':'0'},250);
        }
    }
    
    lastScrollTop = st;
}

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

function getSessionTimeout( sessionModal, sessionWarn, sessionTime, sessionLogout ) {
    $.getJSON("/api/session/timeout", function(result) {
        var logout = true;
        if (result.success) { 
            if (result.elapsed < sessionWarn) {
                logout = false;
                $(sessionModal).modal('hide');
            } else if (result.elapsed < sessionTime) {
                $('#sessionModalRemaining').html(sessionTime-elapsed);
                $(sessionModal).modal('show');
            }
        }
        if (logout) { 
            document.location.replace(sessionLogout.data('logout'));
        }
    }).fail(function() {
        document.location.replace(sessionLogout.data('logout'));
    });
}

function sessionHandler( sessionModal ){

    if ($(sessionModal).length == 0 ) return;

    var sessionTime = 1200;
    var sessionWarn = 900;
    var sessionLogout = $('#sessionModal [data-logout]');

    getSessionTimeout( sessionModal, sessionWarn, sessionTime, sessionLogout );

    $(sessionLogout).click(function() {
        document.location.replace(sessionLogout.data('logout'));
    });

    $(sessionModal).on('hide.bs.modal', function (e) {
        $.getJSON("/api/session/keep-alive");
    });

    var sessionInterval = setInterval(function() {
        getSessionTimeout( sessionModal, sessionWarn, sessionTime, sessionLogout );
    }, 15000);
}

sessionHandler($('#sessionModal'));


$(document).ready(function(){

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })

    $(function() {
       $('[data-toggle="popover"]').popover();
    })

    $(function () {
        'use strict'
        $('[data-toggle="offcanvas"]').on('click', function(){
            $('.offcanvas-collapse').toggleClass('open')
        })
    });

    $('#toTop').click(function(e){
        $.scrollTo(0, 700); 
    })

    $('#discoverModal').on('shown.bs.modal', function(e){
        var options = {
            useEasing: true, 
            useGrouping: true, 
            separator: ',', 
            decimal: '.',
            duration: 3,
        };
        var cntupTeams = new CountUp('countupTeams', $('#countupTeams').data('value'), options);
        if (!cntupTeams.error){
            cntupTeams.start();
        } else {
            console.error(cntupTeams.error);
        }
        var cntupCoaches = new CountUp('countupCoaches', $('#countupCoaches').data('value'),options);
        if (!cntupCoaches.error){
            cntupCoaches.start();
        } else {
            console.error(cntupCoaches.error);
        } 
        var cntupMembers = new CountUp('countupMembers', $('#countupMembers').data('value'), options);
        if (!cntupMembers.error){
            cntupMembers.start();
        } else {
            console.error(cntupMembers.error);
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
 
    // scroll elements
    var scrollFadeIn = $('.scroll-fade-in');
    var carousel = $('.carousel-item');
    // todo: remove carousel scroll parallax using js

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
        if ( $(scrollFadeIn).length > 0 ) {
            $(scrollFadeIn).each( function(i) {
                if ( $(window).scrollTop() > $(this).position().top - $(window).height()/3 ){

                    $(this).animate({
                        opacity: "1"
                    },{
                        duration: 1000,
                        specialEasing: {},
                        complete: function() {
                            $( this ).removeClass( "scroll-fade-in" );
                        }
                   });
                }
            });
        }
      
        if ( $(carousel).length > 0 ) {
            if (scrollPos <= bannerHeight0) {
                $(carousel).each(function() {
                    bannerImgTop = bannerImgTop0 - 2 * ((bannerHeight0-scrollPos)/bannerHeight0-1)*50 * bannerVelocity;
                    $(this).children('img').css('top', Math.round(bannerImgTop * 100) / 100 + '%'); 
                }); 
            }
        }
 
    });

});


$(window).on( "load", function() {
    api_load_module_training_tyr();
    api_load_module_competition_programs();
    api_load_module_competition_results();
    api_load_module_training_today();
    api_load_module_training_tomorrow();
    api_load_module_calendar_upcoming();
});


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$('.scheduleNotice').each( function() {
  var cname = $(this).data('cname');
  var cvalue = $(this).data('cvalue');
  $(this).on('closed.bs.alert', function () {
    setCookie (cname, cvalue, 60);
  })
});


// api_load_module_training_tyr
function api_load_module_training_tyr() {
    $('#api_load_module_tyr').html('<div class="row justify-content-around p-3"><div class="col col-8 col-md-10"><div class="tyr" data-toggle="tooltip" data-placement="bottom" title="" data-offset="0" data-original-title="Klik om de clubcode te kopiëren"><img class="mx-auto img-fluid" src="/assets/img/logo/tyr.png"><div class="text-center" style="margin-top:.5em; padding-bottom:0;">Clubcode <span id="tyr-clubcode" style="display:inline-block;" class="">HGS15ZM</span></div></div></div></div>');
    $('.tyr').click(function(e){
      toTyr();
    });
}
function toTyr(){
    toClipboard("tyr-clubcode");
    addAnimation("tyr-clubcode","tada");
    var t = setTimeout(function(){window.open('http://www.tyr.nl','_blank');},1000);
}

// api_load_module_training_today
function api_load_module_training_today() {

    var module = "api_load_module_training_today";
    var hoztAPI  = "/api/training/vandaag";

   $('#'+module).html("<div class=\"pt-3 pb-3 pl-3 pr-0\"><h5 class=\"pb-2 mb-0\">Trainingsuren <span class=\"badge badge-primary font-weight-light align-text-top\">vandaag</span></h5><div id=\""+module+"_items\"></div></div>");

    $.getJSON( hoztAPI, {
        format: "json"
    })
    .done(function( training ) {
        if ( training.result ){
            $.each( training.data, function( i, item ) {
                var t = "<div class=\"row no-gutters\"><div class=\"col-5 col-md-9 col-lg-6 text-right pt-1 small\">"+ item.time + "</div>";
                t += "<div class=\"col-7 col-md-3 col-lg-6 pl-1\">";
                $.each( item.teams, function( i, team ) {
                    t += "<span class=\"badge badge-primary badge-team ml-1\">" + team.abbr + "</span>";
                });
                if ( item.comment ){
                   t += "<span class=\"badge badge-secondary ml-1\">" + item.comment + "</span>";
                }
                t += "</div></div>";
                $( t ).appendTo( "#"+module+"_items" );
            });
        } else {
            $( "<div class=\"small ml-3\">Er is vandaag geen training</div>" ).appendTo( "#"+module+"_items" );
        }
    });

}

// api_load_module_training_tomorrow
function api_load_module_training_tomorrow() {

    var module = "api_load_module_training_tomorrow";
    var hoztAPI  = "/api/training/morgen";

   $('#'+module).html("<div class=\"pt-3 pb-3 pl-3 pr-0\"><h5 class=\"pb-2 mb-0\">Trainingsuren <span class=\"badge badge-medium font-weight-light align-text-top\">morgen</span></h5><div id=\""+module+"_items\"></div></div>");

    $.getJSON( hoztAPI, {
        format: "json"
    })
    .done(function( training ) {
        if ( training.result ){
            $.each( training.data, function( i, item ) {
                var t = "<div class=\"row no-gutters\"><div class=\"col-5 col-md-9 col-lg-6 text-right pt-1 small\">"+ item.time + "</div>";
                t += "<div class=\"col-7 col-md-3 col-lg-6 pl-1\">";
                $.each( item.teams, function( i, team ) {
                    t += "<span class=\"badge badge-primary badge-team ml-1\">" + team.abbr + "</span>";
                });
                if ( item.comment ){
                   t += "<span class=\"badge badge-secondary ml-1\">" + item.comment + "</span>";
                }
                t += "</div></div>";
                $( t ).appendTo( "#"+module+"_items" );
            });
        } else {
            $( "<div class=\"small ml-3\">Er is morgen geen training</div>" ).appendTo( "#"+module+"_items" );
        }
    });

}

// api_load_module_competition_results
function api_load_module_competition_results() {

    var module = "api_load_module_competition_results";
    var hoztAPI  = "/api/documenten/wedstrijden/laatste/uitslag/5";

    $('#'+module).html("<div class=\"p-3\"><h5 class=\"pb-2 mb-0\">Uitslagen</h5><div id=\""+module+"_items\"></div></div>"); 

    $.getJSON( hoztAPI, {
        format: "json"
    })
    .done(function( files ) {
        if ( files.result ){
            $.each( files.data, function( i, item ) {
                var t = "<div class=\"ml-3 small\"><a class=\"text-dark\" href=\"" + item.url + "\"><span class=\"text-muted mr-2\">" + item.datestr +"</span>"+ item.title + "</a></div>";
                $( t ).appendTo( "#"+module+"_items" );
            });
        } else {
            $( "<div class=\"small ml-3\">Geen wedstrijd uitslagen gevonden</div>" ).appendTo( "#"+module+"_items" );
        }
    });

}

// api_load_module_competition_programs
function api_load_module_competition_programs() {

    var module  = "api_load_module_competition_programs";
    var hoztAPI = "/api/documenten/wedstrijden/aanstaande/programma/5";

    $('#'+module).html("<div class=\"p-3\"><h5 class=\"pb-2 mb-0\">Programma's</h5><div id=\""+module+"_items\"></div></div>"); 

    $.getJSON( hoztAPI, {
        format: "json"
    })
    .done(function( files ) {
        if ( files.result ){
            $.each( files.data, function( i, item ) {
                var t = "<div class=\"ml-3 small\"><a class=\"text-dark\" href=\"" + item.doc + "\" target=\"_Blank\"><span class=\"text-muted mr-2\">" + item.datestr +"</span>"+ item.title + "</a></div>";
                $( t ).appendTo( "#"+module+"_items" );
            });
        } else {
            $( "<div class=\"small ml-3\">Geen programma's gevonden</div>" ).appendTo( "#"+module+"_items" );
        }
    });

}

// api_load_module_calendar_upcoming

function api_load_module_calendar_upcoming() {

    $('#api_load_module_calendar_upcoming').html('<div class="p-3"><h5 class="pb-2 mb-0">Kalender</h5><div id="api_load_module_calendar_upcoming_items"></div></div>');

    var hoztAPI  = "/api/kalender/aanstaande";
    var itemsId  = "#api_load_module_calendar_upcoming_items"; 

    $.getJSON( hoztAPI, {
        format: "json"
    })
    .done(function( calendar ) {
        if ( calendar.result ){
            $.each( calendar.data, function( i, item ) {
                var t = '';
                t += "<div class=\"media cal cal-link pt-2\" onclick=\"window.location='" + item.url + "';\">";
                t += '  <span class="badge badge-dark mr-2 cal cal-sm '+ item.class 
                t += '">'+ item.day +'<br>'+ item.month +'</span>';
                t += '  <div class="media-body pb-2 mb-0 small lh-125 border-bottom border-gray ';
                if (item.cancelled){ t += 'cal-cancelled text-danger'; } else { t += 'text-muted'; }
                t += '">';
                t += '    <div class="d-flex justify-content-between align-items-center w-100">';
                t += '      <strong class="text-gray-dark">'+item.title+'</strong>';
                t += '      <a href="#" class="d-none">Bekijk</a>';
                t += '    </div>';
                t += '    <span class="d-block">'+item.formattedPeriod+'</span>';
                t += '  </div>';
                t += '</div>';
                $( t ).appendTo( itemsId );
            });
            $('<p class="small mt-2 text-right"><a href="/kalender"><i class="fas fa-calendar-plus"></i> Alle events</a></p>').appendTo( itemsId );
        } else {
            $( "<p>Er zijn geen events</p>" ).appendTo( itemsId );
        }
    });

}
