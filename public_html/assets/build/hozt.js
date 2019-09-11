(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["hozt"],{

/***/ "./assets/css/hozt.scss":
/*!******************************!*\
  !*** ./assets/css/hozt.scss ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./assets/js/hozt.js":
/*!***************************!*\
  !*** ./assets/js/hozt.js ***!
  \***************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function(__webpack_provided_window_dot_jQuery) {/* harmony import */ var countup_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! countup.js */ "./node_modules/countup.js/dist/countUp.min.js");
/* harmony import */ var _travishorn_session_timeout__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @travishorn/session-timeout */ "./node_modules/@travishorn/session-timeout/dist/session-timeout.js");
/* harmony import */ var _travishorn_session_timeout__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_travishorn_session_timeout__WEBPACK_IMPORTED_MODULE_1__);
__webpack_require__(/*! ../css/hozt.scss */ "./assets/css/hozt.scss");

__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

__webpack_require__(/*! jquery.scrollTo */ "./node_modules/jquery.scrollTo/jquery.scrollTo.js");




var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

window.$ = $;
__webpack_provided_window_dot_jQuery = $; // Hide Header on on scroll down

var didScroll;
var lastScrollTop = 0;
var delta = 10;
var navbarHeight = $('#nav-categories').outerHeight();
$(window).scroll(function (event) {
  didScroll = true;
});
setInterval(function () {
  if (didScroll) {
    hasScrolled();
    didScroll = false;
  }
}, 250);

function hasScrolled() {
  var st = $(window).scrollTop(); // Make sure they scroll more than delta

  if (Math.abs(lastScrollTop - st) <= delta) {
    return;
  } // If they scrolled down and are past the navbar, add class .nav-up.
  // This is necessary so you never see what is "behind" the navbar.


  if (st > lastScrollTop && st > navbarHeight) {
    // Scroll Down
    $('#nav-categories').animate({
      'top': '-40px'
    }, 250);
  } else {
    // Scroll Up
    if (st + $(window).height() < $(document).height()) {
      $('#nav-categories').animate({
        'top': '0'
      }, 250);
    }
  }

  lastScrollTop = st;
}

function addAnimation(id, effect) {
  $('#' + id).removeClass().addClass(effect + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
    $(this).removeClass();
  });
}

;

function toClipboard(id) {
  var element = document.getElementById(id);
  var textArea = document.createElement("textarea");
  textArea.value = element.textContent;
  document.body.appendChild(textArea);
  textArea.select();
  document.execCommand("Copy");
  textArea.remove();
}

;
$(document).ready(function () {
  if ($(document.body).data('session-timeout')) {
    // todo: integrate bootstrap 4 styling: modal with buttons
    _travishorn_session_timeout__WEBPACK_IMPORTED_MODULE_1___default()({
      //warnAfter: 6000, // test
      appendTimestamp: true,
      keepAliveUrl: '/api/keep-alive',
      message: 'Ben je er nog?',
      timeOutUrl: '/loguit',
      logOutUrl: '/loguit',
      logOutBtnText: 'Uitloggen',
      stayConnectedBtnText: 'Verder doen'
    });
  }

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  $(function () {
    $('[data-toggle="popover"]').popover();
  });
  $(function () {
    'use strict';

    $('[data-toggle="offcanvas"]').on('click', function () {
      $('.offcanvas-collapse').toggleClass('open');
    });
  });
  $('#toTop').click(function (e) {
    $.scrollTo(0, 700);
  });
  $('#discoverModal').on('shown.bs.modal', function (e) {
    var options = {
      useEasing: true,
      useGrouping: true,
      separator: ',',
      decimal: '.',
      duration: 3
    };
    var cntupTeams = new countup_js__WEBPACK_IMPORTED_MODULE_0__["CountUp"]('countupTeams', $('#countupTeams').data('value'), options);

    if (!cntupTeams.error) {
      cntupTeams.start();
    } else {
      console.error(cntupTeams.error);
    }

    var cntupCoaches = new countup_js__WEBPACK_IMPORTED_MODULE_0__["CountUp"]('countupCoaches', $('#countupCoaches').data('value'), options);

    if (!cntupCoaches.error) {
      cntupCoaches.start();
    } else {
      console.error(cntupCoaches.error);
    }

    var cntupMembers = new countup_js__WEBPACK_IMPORTED_MODULE_0__["CountUp"]('countupMembers', $('#countupMembers').data('value'), options);

    if (!cntupMembers.error) {
      cntupMembers.start();
    } else {
      console.error(cntupMembers.error);
    }
  });
  /*  init back to top icon */

  var scrollPos;
  var toTopVisible = false;
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

  $(window).scroll(function () {
    scrollPos = $(window).scrollTop(); // show back to top

    if (scrollPos >= 400 && !toTopVisible) {
      toTopVisible = true;
      toTop.style.visibility = "visible";
      toTop.style.opacity = "0";
      $('#toTop').animate({
        'opacity': '1'
      }, 750);
    }

    if (scrollPos < 400 && toTopVisible) {
      toTopVisible = false;
      $('#toTop').animate({
        'opacity': '0'
      }, 750, function () {
        toTop.style.visibility = "hidden";
      });
    }
    /* Check the location of each desired element */


    $('.scroll-fade-in').each(function (i) {
      /*if (bottom_of_window > bottom_of_object){*/
      if ($(window).scrollTop() > $(this).position().top - $(window).height() / 3) {
        $(this).animate({
          opacity: "1"
        }, {
          duration: 1000,
          specialEasing: {},
          complete: function complete() {
            $(this).removeClass("scroll-fade-in");
          }
        });
      }
    });

    if (scrollPos <= bannerHeight0) {
      $('.carousel-item').each(function () {
        bannerImgTop = bannerImgTop0 - 2 * ((bannerHeight0 - scrollPos) / bannerHeight0 - 1) * 50 * bannerVelocity;
        $(this).children('img').css('top', Math.round(bannerImgTop * 100) / 100 + '%');
      });
    }
  });
});
$(window).on("load", function () {
  api_load_module_training_tyr();
  api_load_module_competition_programs();
  api_load_module_competition_results();
  api_load_module_training_today();
  api_load_module_training_tomorrow();
  api_load_module_calendar_upcoming();
});

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$('.scheduleNotice').each(function () {
  var cname = $(this).data('cname');
  var cvalue = $(this).data('cvalue');
  $(this).on('closed.bs.alert', function () {
    setCookie(cname, cvalue, 60);
  });
}); // api_load_module_training_tyr

function api_load_module_training_tyr() {
  $('#api_load_module_tyr').html('<div class="row justify-content-around p-3"><div class="col col-8 col-md-10"><div class="tyr" data-toggle="tooltip" data-placement="bottom" title="" data-offset="0" data-original-title="Klik om de clubcode te kopiëren"><img class="mx-auto img-fluid" src="/assets/img/logo/tyr.png"><div class="text-center" style="margin-top:.5em; padding-bottom:0;">Clubcode <span id="tyr-clubcode" style="display:inline-block;" class="">HGS15ZM</span></div></div></div></div>');
  $('.tyr').click(function (e) {
    toTyr();
  });
}

function toTyr() {
  toClipboard("tyr-clubcode");
  addAnimation("tyr-clubcode", "tada");
  var t = setTimeout(function () {
    window.open('http://www.tyr.nl', '_blank');
  }, 1000);
} // api_load_module_training_today


function api_load_module_training_today() {
  var module = "api_load_module_training_today";
  var hoztAPI = "/api/training/vandaag";
  $('#' + module).html("<div class=\"pt-3 pb-3 pl-3 pr-0\"><h5 class=\"pb-2 mb-0\">Trainingsuren <span class=\"badge badge-primary font-weight-light\">vandaag</span></h5><div id=\"" + module + "_items\"></div></div>");
  $.getJSON(hoztAPI, {
    format: "json"
  }).done(function (training) {
    if (training.result) {
      $.each(training.data, function (i, item) {
        var t = "<div class=\"row no-gutters\"><div class=\"col-5 col-md-9 col-lg-6 text-right pt-1 small\">" + item.time + "</div>";
        t += "<div class=\"col-7 col-md-3 col-lg-6 pl-1\">";
        $.each(item.teams, function (i, team) {
          t += "<span class=\"badge badge-primary badge-team ml-1\">" + team.abbr + "</span>";
        });

        if (item.comment) {
          t += "<span class=\"badge badge-secondary ml-1\">" + item.comment + "</span>";
        }

        t += "</div></div>";
        $(t).appendTo("#" + module + "_items");
      });
    } else {
      $("<div class=\"small ml-3\">Er is vandaag geen training</div>").appendTo("#" + module + "_items");
    }
  });
} // api_load_module_training_tomorrow


function api_load_module_training_tomorrow() {
  var module = "api_load_module_training_tomorrow";
  var hoztAPI = "/api/training/morgen";
  $('#' + module).html("<div class=\"pt-3 pb-3 pl-3 pr-0\"><h5 class=\"pb-2 mb-0\">Trainingsuren <span class=\"badge badge-medium font-weight-light\">morgen</span></h5><div id=\"" + module + "_items\"></div></div>");
  $.getJSON(hoztAPI, {
    format: "json"
  }).done(function (training) {
    if (training.result) {
      $.each(training.data, function (i, item) {
        var t = "<div class=\"row no-gutters\"><div class=\"col-5 col-md-9 col-lg-6 text-right pt-1 small\">" + item.time + "</div>";
        t += "<div class=\"col-7 col-md-3 col-lg-6 pl-1\">";
        $.each(item.teams, function (i, team) {
          t += "<span class=\"badge badge-primary badge-team ml-1\">" + team.abbr + "</span>";
        });

        if (item.comment) {
          t += "<span class=\"badge badge-secondary ml-1\">" + item.comment + "</span>";
        }

        t += "</div></div>";
        $(t).appendTo("#" + module + "_items");
      });
    } else {
      $("<div class=\"small ml-3\">Er is morgen geen training</div>").appendTo("#" + module + "_items");
    }
  });
} // api_load_module_competition_results


function api_load_module_competition_results() {
  var module = "api_load_module_competition_results";
  var hoztAPI = "/api/documenten/wedstrijden/laatste/uitslag/5";
  $('#' + module).html("<div class=\"p-3\"><h5 class=\"pb-2 mb-0\">Uitslagen</h5><div id=\"" + module + "_items\"></div></div>");
  $.getJSON(hoztAPI, {
    format: "json"
  }).done(function (files) {
    if (files.result) {
      $.each(files.data, function (i, item) {
        var t = "<div class=\"ml-3 small\"><a class=\"text-dark\" href=\"" + item.url + "\"><span class=\"text-muted mr-2\">" + item.datestr + "</span>" + item.title + "</a></div>";
        $(t).appendTo("#" + module + "_items");
      });
    } else {
      $("<div class=\"small ml-3\">Geen wedstrijd uitslagen gevonden</div>").appendTo("#" + module + "_items");
    }
  });
} // api_load_module_competition_programs


function api_load_module_competition_programs() {
  var module = "api_load_module_competition_programs";
  var hoztAPI = "/api/documenten/wedstrijden/aanstaande/programma/5";
  $('#' + module).html("<div class=\"p-3\"><h5 class=\"pb-2 mb-0\">Programma's</h5><div id=\"" + module + "_items\"></div></div>");
  $.getJSON(hoztAPI, {
    format: "json"
  }).done(function (files) {
    if (files.result) {
      $.each(files.data, function (i, item) {
        var t = "<div class=\"ml-3 small\"><a class=\"text-dark\" href=\"" + item.doc + "\" target=\"_Blank\"><span class=\"text-muted mr-2\">" + item.datestr + "</span>" + item.title + "</a></div>";
        $(t).appendTo("#" + module + "_items");
      });
    } else {
      $("<div class=\"small ml-3\">Geen programma's gevonden</div>").appendTo("#" + module + "_items");
    }
  });
} // api_load_module_calendar_upcoming


function api_load_module_calendar_upcoming() {
  $('#api_load_module_calendar_upcoming').html('<div class="p-3"><h5 class="pb-2 mb-0">Kalender</h5><div id="api_load_module_calendar_upcoming_items"></div></div>');
  var hoztAPI = "/api/kalender/aanstaande";
  var itemsId = "#api_load_module_calendar_upcoming_items";
  $.getJSON(hoztAPI, {
    format: "json"
  }).done(function (calendar) {
    if (calendar.result) {
      $.each(calendar.data, function (i, item) {
        var t = '';
        t += "<div class=\"media cal cal-link pt-2\" onclick=\"window.location='" + item.url + "';\">";
        t += '  <span class="badge badge-dark mr-2 cal cal-sm ' + item["class"];
        t += '">' + item.day + '<br>' + item.month + '</span>';
        t += '  <div class="media-body pb-2 mb-0 small lh-125 border-bottom border-gray ';

        if (item.cancelled) {
          t += 'cal-cancelled text-danger';
        } else {
          t += 'text-muted';
        }

        t += '">';
        t += '    <div class="d-flex justify-content-between align-items-center w-100">';
        t += '      <strong class="text-gray-dark">' + item.title + '</strong>';
        t += '      <a href="#" class="d-none">Bekijk</a>';
        t += '    </div>';
        t += '    <span class="d-block">' + item.formattedPeriod + '</span>';
        t += '  </div>';
        t += '</div>';
        $(t).appendTo(itemsId);
      });
      $('<p class="small mt-2 text-right"><a href="/kalender"><i class="fas fa-calendar-plus"></i> Alle events</a></p>').appendTo(itemsId);
    } else {
      $("<p>Er zijn geen events</p>").appendTo(itemsId);
    }
  });
}
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/hozt.js","runtime","vendors~calendar~carousel~eu_cookie~form_default~form_extended~hozt~membership_competitions~membersh~262175ed","vendors~carousel~hozt~membership_competitions~membership_preferences","vendors~hozt"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2hvenQuc2NzcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvaG96dC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsIndpbmRvdyIsImRpZFNjcm9sbCIsImxhc3RTY3JvbGxUb3AiLCJkZWx0YSIsIm5hdmJhckhlaWdodCIsIm91dGVySGVpZ2h0Iiwic2Nyb2xsIiwiZXZlbnQiLCJzZXRJbnRlcnZhbCIsImhhc1Njcm9sbGVkIiwic3QiLCJzY3JvbGxUb3AiLCJNYXRoIiwiYWJzIiwiYW5pbWF0ZSIsImhlaWdodCIsImRvY3VtZW50IiwiYWRkQW5pbWF0aW9uIiwiaWQiLCJlZmZlY3QiLCJyZW1vdmVDbGFzcyIsImFkZENsYXNzIiwib25lIiwidG9DbGlwYm9hcmQiLCJlbGVtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJ0ZXh0QXJlYSIsImNyZWF0ZUVsZW1lbnQiLCJ2YWx1ZSIsInRleHRDb250ZW50IiwiYm9keSIsImFwcGVuZENoaWxkIiwic2VsZWN0IiwiZXhlY0NvbW1hbmQiLCJyZW1vdmUiLCJyZWFkeSIsImRhdGEiLCJzZXNzaW9uVGltZW91dCIsImFwcGVuZFRpbWVzdGFtcCIsImtlZXBBbGl2ZVVybCIsIm1lc3NhZ2UiLCJ0aW1lT3V0VXJsIiwibG9nT3V0VXJsIiwibG9nT3V0QnRuVGV4dCIsInN0YXlDb25uZWN0ZWRCdG5UZXh0IiwidG9vbHRpcCIsInBvcG92ZXIiLCJvbiIsInRvZ2dsZUNsYXNzIiwiY2xpY2siLCJlIiwic2Nyb2xsVG8iLCJvcHRpb25zIiwidXNlRWFzaW5nIiwidXNlR3JvdXBpbmciLCJzZXBhcmF0b3IiLCJkZWNpbWFsIiwiZHVyYXRpb24iLCJjbnR1cFRlYW1zIiwiQ291bnRVcCIsImVycm9yIiwic3RhcnQiLCJjb25zb2xlIiwiY250dXBDb2FjaGVzIiwiY250dXBNZW1iZXJzIiwic2Nyb2xsUG9zIiwidG9Ub3BWaXNpYmxlIiwidG9Ub3AiLCJiYW5uZXJWZWxvY2l0eSIsImJhbm5lclBvczAiLCJjc3MiLCJzcGxpdCIsImJhbm5lckhlaWdodDAiLCJiYW5uZXJQb3NZMCIsInBhcnNlSW50IiwiYmFubmVyUG9zWSIsImJhbm5lckltZ1RvcDAiLCJiYW5uZXJJbWdUb3AiLCJzdHlsZSIsInZpc2liaWxpdHkiLCJvcGFjaXR5IiwiZWFjaCIsImkiLCJwb3NpdGlvbiIsInRvcCIsInNwZWNpYWxFYXNpbmciLCJjb21wbGV0ZSIsImNoaWxkcmVuIiwicm91bmQiLCJhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyIiwiYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Byb2dyYW1zIiwiYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Jlc3VsdHMiLCJhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXkiLCJhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9tb3Jyb3ciLCJhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmciLCJzZXRDb29raWUiLCJjbmFtZSIsImN2YWx1ZSIsImV4ZGF5cyIsImQiLCJEYXRlIiwic2V0VGltZSIsImdldFRpbWUiLCJleHBpcmVzIiwidG9VVENTdHJpbmciLCJjb29raWUiLCJodG1sIiwidG9UeXIiLCJ0Iiwic2V0VGltZW91dCIsIm9wZW4iLCJtb2R1bGUiLCJob3p0QVBJIiwiZ2V0SlNPTiIsImZvcm1hdCIsImRvbmUiLCJ0cmFpbmluZyIsInJlc3VsdCIsIml0ZW0iLCJ0aW1lIiwidGVhbXMiLCJ0ZWFtIiwiYWJiciIsImNvbW1lbnQiLCJhcHBlbmRUbyIsImZpbGVzIiwidXJsIiwiZGF0ZXN0ciIsInRpdGxlIiwiZG9jIiwiaXRlbXNJZCIsImNhbGVuZGFyIiwiZGF5IiwibW9udGgiLCJjYW5jZWxsZWQiLCJmb3JtYXR0ZWRQZXJpb2QiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBLHVDOzs7Ozs7Ozs7Ozs7QUNBQUE7QUFBQUE7QUFBQUE7QUFBQUE7QUFBQUEsbUJBQU8sQ0FBQyxnREFBRCxDQUFQOztBQUVBQSxtQkFB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SDZILFFBQW5ILENBQTZITSxPQUE3SDtBQUNILEtBbkJELE1BbUJPO0FBQ0huSSxPQUFDLENBQUUsNEJBQUYsQ0FBRCxDQUFrQzZILFFBQWxDLENBQTRDTSxPQUE1QztBQUNIO0FBQ0osR0ExQkQ7QUE0QkgsQyIsImZpbGUiOiJob3p0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luIiwicmVxdWlyZSgnLi4vY3NzL2hvenQuc2NzcycpO1xuXG5yZXF1aXJlKCdib290c3RyYXAnKTtcbnJlcXVpcmUoJ2pxdWVyeS5zY3JvbGxUbycpO1xuaW1wb3J0IHsgQ291bnRVcCB9IGZyb20gJ2NvdW50dXAuanMnO1xuaW1wb3J0IHNlc3Npb25UaW1lb3V0IGZyb20gJ0B0cmF2aXNob3JuL3Nlc3Npb24tdGltZW91dCc7XG5cbnZhciAkID0gcmVxdWlyZSgnanF1ZXJ5Jyk7XG53aW5kb3cuJCA9ICQ7XG53aW5kb3cualF1ZXJ5ID0gJDtcblxuXG4vLyBIaWRlIEhlYWRlciBvbiBvbiBzY3JvbGwgZG93blxudmFyIGRpZFNjcm9sbDtcbnZhciBsYXN0U2Nyb2xsVG9wID0gMDtcbnZhciBkZWx0YSA9IDEwO1xudmFyIG5hdmJhckhlaWdodCA9ICQoJyNuYXYtY2F0ZWdvcmllcycpLm91dGVySGVpZ2h0KCk7XG5cbiQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oZXZlbnQpe1xuICAgIGRpZFNjcm9sbCA9IHRydWU7XG59KTtcblxuc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKSB7XG4gICAgaWYgKGRpZFNjcm9sbCkge1xuICAgICAgICBoYXNTY3JvbGxlZCgpO1xuICAgICAgICBkaWRTY3JvbGwgPSBmYWxzZTtcbiAgICB9XG59LCAyNTApO1xuXG5mdW5jdGlvbiBoYXNTY3JvbGxlZCgpIHtcbiAgICB2YXIgc3QgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XG5cbiAgICAvLyBNYWtlIHN1cmUgdGhleSBzY3JvbGwgbW9yZSB0aGFuIGRlbHRhXG4gICAgaWYgKE1hdGguYWJzKGxhc3RTY3JvbGxUb3AgLSBzdCkgPD0gZGVsdGEpe1xuICAgICAgICByZXR1cm47XG4gICAgfVxuICAgIFxuICAgIC8vIElmIHRoZXkgc2Nyb2xsZWQgZG93biBhbmQgYXJlIHBhc3QgdGhlIG5hdmJhciwgYWRkIGNsYXNzIC5uYXYtdXAuXG4gICAgLy8gVGhpcyBpcyBuZWNlc3Nhcnkgc28geW91IG5ldmVyIHNlZSB3aGF0IGlzIFwiYmVoaW5kXCIgdGhlIG5hdmJhci5cbiAgICBpZiAoc3QgPiBsYXN0U2Nyb2xsVG9wICYmIHN0ID4gbmF2YmFySGVpZ2h0KXtcbiAgICAgICAgLy8gU2Nyb2xsIERvd25cbiAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6Jy00MHB4J30sMjUwKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICAvLyBTY3JvbGwgVXBcbiAgICAgICAgaWYoc3QgKyAkKHdpbmRvdykuaGVpZ2h0KCkgPCAkKGRvY3VtZW50KS5oZWlnaHQoKSkge1xuICAgICAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6JzAnfSwyNTApO1xuICAgICAgICB9XG4gICAgfVxuICAgIFxuICAgIGxhc3RTY3JvbGxUb3AgPSBzdDtcbn1cblxuZnVuY3Rpb24gYWRkQW5pbWF0aW9uKGlkLCBlZmZlY3QpIHtcbiAgICAkKCcjJytpZCkucmVtb3ZlQ2xhc3MoKS5hZGRDbGFzcyhlZmZlY3QgKyAnIGFuaW1hdGVkJykub25lKCd3ZWJraXRBbmltYXRpb25FbmQgbW96QW5pbWF0aW9uRW5kIE1TQW5pbWF0aW9uRW5kIG9hbmltYXRpb25lbmQgYW5pbWF0aW9uZW5kJywgZnVuY3Rpb24oKXtcbiAgICAgICAgJCh0aGlzKS5yZW1vdmVDbGFzcygpO1xuICAgIH0pO1xufTtcblxuZnVuY3Rpb24gdG9DbGlwYm9hcmQoaWQpe1xuICAgIHZhciBlbGVtZW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICAgIHZhciB0ZXh0QXJlYSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJ0ZXh0YXJlYVwiKTtcbiAgICB0ZXh0QXJlYS52YWx1ZSA9IGVsZW1lbnQudGV4dENvbnRlbnQ7XG4gICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCh0ZXh0QXJlYSk7XG4gICAgdGV4dEFyZWEuc2VsZWN0KCk7XG4gICAgZG9jdW1lbnQuZXhlY0NvbW1hbmQoXCJDb3B5XCIpO1xuICAgIHRleHRBcmVhLnJlbW92ZSgpO1xufTtcblxuXG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpe1xuXG4gICAgaWYgKCAkKGRvY3VtZW50LmJvZHkpLmRhdGEoJ3Nlc3Npb24tdGltZW91dCcpICkge1xuICAgICAgICAvLyB0b2RvOiBpbnRlZ3JhdGUgYm9vdHN0cmFwIDQgc3R5bGluZzogbW9kYWwgd2l0aCBidXR0b25zXG4gICAgICAgIHNlc3Npb25UaW1lb3V0KHtcbiAgICAgICAgICAgIC8vd2FybkFmdGVyOiA2MDAwLCAvLyB0ZXN0XG4gICAgICAgICAgICBhcHBlbmRUaW1lc3RhbXA6IHRydWUsXG4gICAgICAgICAgICBrZWVwQWxpdmVVcmw6ICcvYXBpL2tlZXAtYWxpdmUnLFxuICAgICAgICAgICAgbWVzc2FnZTogJ0JlbiBqZSBlciBub2c/JyxcbiAgICAgICAgICAgIHRpbWVPdXRVcmw6ICcvbG9ndWl0JyxcbiAgICAgICAgICAgIGxvZ091dFVybDogJy9sb2d1aXQnLFxuICAgICAgICAgICAgbG9nT3V0QnRuVGV4dDogJ1VpdGxvZ2dlbicsXG4gICAgICAgICAgICBzdGF5Q29ubmVjdGVkQnRuVGV4dDogJ1ZlcmRlciBkb2VuJyxcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgJChmdW5jdGlvbiAoKSB7XG4gICAgICAgICQoJ1tkYXRhLXRvZ2dsZT1cInRvb2x0aXBcIl0nKS50b29sdGlwKCk7XG4gICAgfSlcblxuICAgICQoZnVuY3Rpb24oKSB7XG4gICAgICAgJCgnW2RhdGEtdG9nZ2xlPVwicG9wb3ZlclwiXScpLnBvcG92ZXIoKTtcbiAgICB9KVxuXG4gICAgJChmdW5jdGlvbiAoKSB7XG4gICAgICAgICd1c2Ugc3RyaWN0J1xuICAgICAgICAkKCdbZGF0YS10b2dnbGU9XCJvZmZjYW52YXNcIl0nKS5vbignY2xpY2snLCBmdW5jdGlvbigpe1xuICAgICAgICAgICAgJCgnLm9mZmNhbnZhcy1jb2xsYXBzZScpLnRvZ2dsZUNsYXNzKCdvcGVuJylcbiAgICAgICAgfSlcbiAgICB9KTtcblxuICAgICQoJyN0b1RvcCcpLmNsaWNrKGZ1bmN0aW9uKGUpe1xuICAgICAgICAkLnNjcm9sbFRvKDAsIDcwMCk7IFxuICAgIH0pXG5cbiAgICAkKCcjZGlzY292ZXJNb2RhbCcpLm9uKCdzaG93bi5icy5tb2RhbCcsIGZ1bmN0aW9uKGUpe1xuICAgICAgICB2YXIgb3B0aW9ucyA9IHtcbiAgICDigIPigIMgICAgICB1c2VFYXNpbmc6IHRydWUsIFxuICAgICAg4oCD4oCDICAgIHVzZUdyb3VwaW5nOiB0cnVlLCBcbiAgICAgICAg4oCD4oCDICBzZXBhcmF0b3I6ICcsJywgXG4gICAgICDigIPigIMgICAgZGVjaW1hbDogJy4nLFxuICAgICAgICAgICAgZHVyYXRpb246IDMsXG4gICAgICAgIH07XG4gICAgICAgIHZhciBjbnR1cFRlYW1zID0gbmV3IENvdW50VXAoJ2NvdW50dXBUZWFtcycsICQoJyNjb3VudHVwVGVhbXMnKS5kYXRhKCd2YWx1ZScpLCBvcHRpb25zKTtcbiAgICAgICAgaWYgKCFjbnR1cFRlYW1zLmVycm9yKXtcbiAgICAgICAgICAgIGNudHVwVGVhbXMuc3RhcnQoKTtcbiAgICAgICAgfSBlbHNlIHtcbuKAg+KAgyAgICAgICAgICBjb25zb2xlLmVycm9yKGNudHVwVGVhbXMuZXJyb3IpO1xuICAgICAgICB9XG4gICAgICAgIHZhciBjbnR1cENvYWNoZXMgPSBuZXcgQ291bnRVcCgnY291bnR1cENvYWNoZXMnLCAkKCcjY291bnR1cENvYWNoZXMnKS5kYXRhKCd2YWx1ZScpLG9wdGlvbnMpO1xuICAgICAgICBpZiAoIWNudHVwQ29hY2hlcy5lcnJvcil7XG7igIPigIMgICAgICAgICAgY250dXBDb2FjaGVzLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnR1cENvYWNoZXMuZXJyb3IpO1xuICAgICAgICB9IFxuICAgICAgICB2YXIgY250dXBNZW1iZXJzID0gbmV3IENvdW50VXAoJ2NvdW50dXBNZW1iZXJzJywgJCgnI2NvdW50dXBNZW1iZXJzJykuZGF0YSgndmFsdWUnKSwgb3B0aW9ucyk7XG4gICAgICAgIGlmICghY250dXBNZW1iZXJzLmVycm9yKXtcbuKAg+KAgyAgICAgICAgICBjbnR1cE1lbWJlcnMuc3RhcnQoKTtcbiAgICAgICAgfSBlbHNlIHtcbuKAg+KAgyAgICAgICAgICBjb25zb2xlLmVycm9yKGNudHVwTWVtYmVycy5lcnJvcik7XG4gICAgICAgIH1cbiAgICB9KTtcblxuXG4gICAgLyogIGluaXQgYmFjayB0byB0b3AgaWNvbiAqL1xuICAgIHZhciBzY3JvbGxQb3M7IFxuICAgIHZhciB0b1RvcFZpc2libGU9ZmFsc2U7XG4gICAgdmFyIHRvVG9wID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3RvVG9wJyk7XG5cbiAgICAvKiAgaW5pdCBiYW5uZXIgcGFyYWxsYXggc2Nyb2xsICovIFxuICAgIHZhciBiYW5uZXJWZWxvY2l0eSA9IC40NTtcbiAgICB2YXIgYmFubmVyUG9zMCA9ICQoJy5iYW5uZXInKS5jc3MoJ2JhY2tncm91bmRQb3NpdGlvbicpLnNwbGl0KFwiIFwiKTtcbiAgICB2YXIgYmFubmVySGVpZ2h0MCA9ICQoJy5iYW5uZXInKS5oZWlnaHQoKSArICQoJyNuYXYtY2F0ZWdvcmllcycpLmhlaWdodCgpO1xuICAgIHZhciBiYW5uZXJQb3NZMCA9IHBhcnNlSW50KGJhbm5lclBvczBbMV0pO1xuICAgIHZhciBiYW5uZXJQb3NZO1xuICAgIHZhciBiYW5uZXJJbWdUb3AwID0gNTA7XG4gICAgdmFyIGJhbm5lckltZ1RvcDtcbiBcbiAgICAvKiBFdmVyeSB0aW1lIHRoZSB3aW5kb3cgaXMgc2Nyb2xsZWQgLi4uICovXG4gICAgJCh3aW5kb3cpLnNjcm9sbCggZnVuY3Rpb24oKXtcblxuICAgICAgICBzY3JvbGxQb3MgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XG5cbiAgICAgICAgLy8gc2hvdyBiYWNrIHRvIHRvcFxuICAgICAgICBpZiAoIHNjcm9sbFBvcyA+PSA0MDAgJiYgIXRvVG9wVmlzaWJsZSApe1xuICAgICAgICAgICAgdG9Ub3BWaXNpYmxlPXRydWU7XG4gICAgICAgICAgICB0b1RvcC5zdHlsZS52aXNpYmlsaXR5PVwidmlzaWJsZVwiO1xuICAgICAgICAgICAgdG9Ub3Auc3R5bGUub3BhY2l0eT1cIjBcIjtcbiAgICAgICAgICAgICQoJyN0b1RvcCcpLmFuaW1hdGUoeydvcGFjaXR5JzonMSd9LDc1MCk7XG4gICAgICAgIH0gXG4gICAgICAgIGlmICggc2Nyb2xsUG9zIDwgNDAwICYmIHRvVG9wVmlzaWJsZSApe1xuICAgICAgICAgICAgdG9Ub3BWaXNpYmxlPWZhbHNlO1xuICAgICAgICAgICAgJCgnI3RvVG9wJykuYW5pbWF0ZSh7J29wYWNpdHknOicwJ30sNzUwLGZ1bmN0aW9uKCl7IFxuICAgICAgICAgICAgICAgIHRvVG9wLnN0eWxlLnZpc2liaWxpdHk9XCJoaWRkZW5cIjtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG5cbiAgICAgICAgLyogQ2hlY2sgdGhlIGxvY2F0aW9uIG9mIGVhY2ggZGVzaXJlZCBlbGVtZW50ICovXG4gICAgICAgICQoJy5zY3JvbGwtZmFkZS1pbicpLmVhY2goIGZ1bmN0aW9uKGkpe1xuXG4gICAgICAgICAgICAvKmlmIChib3R0b21fb2Zfd2luZG93ID4gYm90dG9tX29mX29iamVjdCl7Ki9cbiAgICAgICAgICAgIGlmICggJCh3aW5kb3cpLnNjcm9sbFRvcCgpID4gJCh0aGlzKS5wb3NpdGlvbigpLnRvcCAtICQod2luZG93KS5oZWlnaHQoKS8zICl7XG5cbiAgICAgICAgICAgICAgJCh0aGlzKS5hbmltYXRlKHtcbiAgICAgICAgICAgICAgICBvcGFjaXR5OiBcIjFcIlxuICAgICAgICAgICAgICB9LCB7XG4gICAgICAgICAgICAgICAgZHVyYXRpb246IDEwMDAsXG4gICAgICAgICAgICAgICAgc3BlY2lhbEVhc2luZzoge1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgY29tcGxldGU6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgJCggdGhpcyApLnJlbW92ZUNsYXNzKCBcInNjcm9sbC1mYWRlLWluXCIgKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICB9ICAgICAgXG4gICAgICAgIH0pO1xuICAgICAgXG4gICAgICAgIGlmIChzY3JvbGxQb3MgPD0gYmFubmVySGVpZ2h0MCkge1xuICAgICAgICAgICAgJCgnLmNhcm91c2VsLWl0ZW0nKS5lYWNoKGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIGJhbm5lckltZ1RvcCA9IGJhbm5lckltZ1RvcDAgLSAyICogKChiYW5uZXJIZWlnaHQwLXNjcm9sbFBvcykvYmFubmVySGVpZ2h0MC0xKSo1MCAqIGJhbm5lclZlbG9jaXR5O1xuICAgICAgICAgICAgICAgICQodGhpcykuY2hpbGRyZW4oJ2ltZycpLmNzcygndG9wJywgTWF0aC5yb3VuZChiYW5uZXJJbWdUb3AgKiAxMDApIC8gMTAwICsgJyUnKTsgXG4gICAgICAgICAgICB9KTsgXG4gICAgICAgIH1cbiBcbiAgICB9KTtcblxufSk7XG5cblxuJCh3aW5kb3cpLm9uKCBcImxvYWRcIiwgZnVuY3Rpb24oKSB7XG5cbiAgYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3R5cigpO1xuICBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXMoKTtcbiAgYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Jlc3VsdHMoKTtcbiAgYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvZGF5KCk7XG4gIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvdygpO1xuICBhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmcoKTtcblxufSk7XG5cblxuZnVuY3Rpb24gc2V0Q29va2llKGNuYW1lLCBjdmFsdWUsIGV4ZGF5cykge1xuICAgIHZhciBkID0gbmV3IERhdGUoKTtcbiAgICBkLnNldFRpbWUoZC5nZXRUaW1lKCkgKyAoZXhkYXlzKjI0KjYwKjYwKjEwMDApKTtcbiAgICB2YXIgZXhwaXJlcyA9IFwiZXhwaXJlcz1cIisgZC50b1VUQ1N0cmluZygpO1xuICAgIGRvY3VtZW50LmNvb2tpZSA9IGNuYW1lICsgXCI9XCIgKyBjdmFsdWUgKyBcIjtcIiArIGV4cGlyZXMgKyBcIjtwYXRoPS9cIjtcbn1cblxuJCgnLnNjaGVkdWxlTm90aWNlJykuZWFjaCggZnVuY3Rpb24oKSB7XG4gIHZhciBjbmFtZSA9ICQodGhpcykuZGF0YSgnY25hbWUnKTtcbiAgdmFyIGN2YWx1ZSA9ICQodGhpcykuZGF0YSgnY3ZhbHVlJyk7XG4gICQodGhpcykub24oJ2Nsb3NlZC5icy5hbGVydCcsIGZ1bmN0aW9uICgpIHtcbiAgICBzZXRDb29raWUgKGNuYW1lLCBjdmFsdWUsIDYwKTtcbiAgfSlcbn0pO1xuXG5cbi8vIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190eXJcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190eXIoKSB7XG4gICAgJCgnI2FwaV9sb2FkX21vZHVsZV90eXInKS5odG1sKCc8ZGl2IGNsYXNzPVwicm93IGp1c3RpZnktY29udGVudC1hcm91bmQgcC0zXCI+PGRpdiBjbGFzcz1cImNvbCBjb2wtOCBjb2wtbWQtMTBcIj48ZGl2IGNsYXNzPVwidHlyXCIgZGF0YS10b2dnbGU9XCJ0b29sdGlwXCIgZGF0YS1wbGFjZW1lbnQ9XCJib3R0b21cIiB0aXRsZT1cIlwiIGRhdGEtb2Zmc2V0PVwiMFwiIGRhdGEtb3JpZ2luYWwtdGl0bGU9XCJLbGlrIG9tIGRlIGNsdWJjb2RlIHRlIGtvcGnDq3JlblwiPjxpbWcgY2xhc3M9XCJteC1hdXRvIGltZy1mbHVpZFwiIHNyYz1cIi9hc3NldHMvaW1nL2xvZ28vdHlyLnBuZ1wiPjxkaXYgY2xhc3M9XCJ0ZXh0LWNlbnRlclwiIHN0eWxlPVwibWFyZ2luLXRvcDouNWVtOyBwYWRkaW5nLWJvdHRvbTowO1wiPkNsdWJjb2RlIDxzcGFuIGlkPVwidHlyLWNsdWJjb2RlXCIgc3R5bGU9XCJkaXNwbGF5OmlubGluZS1ibG9jaztcIiBjbGFzcz1cIlwiPkhHUzE1Wk08L3NwYW4+PC9kaXY+PC9kaXY+PC9kaXY+PC9kaXY+Jyk7XG4gICAgJCgnLnR5cicpLmNsaWNrKGZ1bmN0aW9uKGUpe1xuICAgICAgdG9UeXIoKTtcbiAgICB9KTtcbn1cbmZ1bmN0aW9uIHRvVHlyKCl7XG4gICAgdG9DbGlwYm9hcmQoXCJ0eXItY2x1YmNvZGVcIik7XG4gICAgYWRkQW5pbWF0aW9uKFwidHlyLWNsdWJjb2RlXCIsXCJ0YWRhXCIpO1xuICAgIHZhciB0ID0gc2V0VGltZW91dChmdW5jdGlvbigpe3dpbmRvdy5vcGVuKCdodHRwOi8vd3d3LnR5ci5ubCcsJ19ibGFuaycpO30sMTAwMCk7XG59XG5cbi8vIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b2RheVxuZnVuY3Rpb24gYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvZGF5KCkge1xuXG4gICAgdmFyIG1vZHVsZSA9IFwiYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvZGF5XCI7XG4gICAgdmFyIGhvenRBUEkgID0gXCIvYXBpL3RyYWluaW5nL3ZhbmRhYWdcIjtcblxuICAgJCgnIycrbW9kdWxlKS5odG1sKFwiPGRpdiBjbGFzcz1cXFwicHQtMyBwYi0zIHBsLTMgcHItMFxcXCI+PGg1IGNsYXNzPVxcXCJwYi0yIG1iLTBcXFwiPlRyYWluaW5nc3VyZW4gPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLXByaW1hcnkgZm9udC13ZWlnaHQtbGlnaHRcXFwiPnZhbmRhYWc8L3NwYW4+PC9oNT48ZGl2IGlkPVxcXCJcIittb2R1bGUrXCJfaXRlbXNcXFwiPjwvZGl2PjwvZGl2PlwiKTtcblxuICAgICQuZ2V0SlNPTiggaG96dEFQSSwge1xuICAgICAgICBmb3JtYXQ6IFwianNvblwiXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggdHJhaW5pbmcgKSB7XG4gICAgICAgIGlmICggdHJhaW5pbmcucmVzdWx0ICl7XG4gICAgICAgICAgICAkLmVhY2goIHRyYWluaW5nLmRhdGEsIGZ1bmN0aW9uKCBpLCBpdGVtICkge1xuICAgICAgICAgICAgICAgIHZhciB0ID0gXCI8ZGl2IGNsYXNzPVxcXCJyb3cgbm8tZ3V0dGVyc1xcXCI+PGRpdiBjbGFzcz1cXFwiY29sLTUgY29sLW1kLTkgY29sLWxnLTYgdGV4dC1yaWdodCBwdC0xIHNtYWxsXFxcIj5cIisgaXRlbS50aW1lICsgXCI8L2Rpdj5cIjtcbiAgICAgICAgICAgICAgICB0ICs9IFwiPGRpdiBjbGFzcz1cXFwiY29sLTcgY29sLW1kLTMgY29sLWxnLTYgcGwtMVxcXCI+XCI7XG4gICAgICAgICAgICAgICAgJC5lYWNoKCBpdGVtLnRlYW1zLCBmdW5jdGlvbiggaSwgdGVhbSApIHtcbiAgICAgICAgICAgICAgICAgICAgdCArPSBcIjxzcGFuIGNsYXNzPVxcXCJiYWRnZSBiYWRnZS1wcmltYXJ5IGJhZGdlLXRlYW0gbWwtMVxcXCI+XCIgKyB0ZWFtLmFiYnIgKyBcIjwvc3Bhbj5cIjtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICBpZiAoIGl0ZW0uY29tbWVudCApe1xuICAgICAgICAgICAgICAgICAgIHQgKz0gXCI8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2Utc2Vjb25kYXJ5IG1sLTFcXFwiPlwiICsgaXRlbS5jb21tZW50ICsgXCI8L3NwYW4+XCI7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIHQgKz0gXCI8L2Rpdj48L2Rpdj5cIjtcbiAgICAgICAgICAgICAgICAkKCB0ICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoIFwiPGRpdiBjbGFzcz1cXFwic21hbGwgbWwtM1xcXCI+RXIgaXMgdmFuZGFhZyBnZWVuIHRyYWluaW5nPC9kaXY+XCIgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG59XG5cbi8vIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvd1xuZnVuY3Rpb24gYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvbW9ycm93KCkge1xuXG4gICAgdmFyIG1vZHVsZSA9IFwiYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvbW9ycm93XCI7XG4gICAgdmFyIGhvenRBUEkgID0gXCIvYXBpL3RyYWluaW5nL21vcmdlblwiO1xuXG4gICAkKCcjJyttb2R1bGUpLmh0bWwoXCI8ZGl2IGNsYXNzPVxcXCJwdC0zIHBiLTMgcGwtMyBwci0wXFxcIj48aDUgY2xhc3M9XFxcInBiLTIgbWItMFxcXCI+VHJhaW5pbmdzdXJlbiA8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2UtbWVkaXVtIGZvbnQtd2VpZ2h0LWxpZ2h0XFxcIj5tb3JnZW48L3NwYW4+PC9oNT48ZGl2IGlkPVxcXCJcIittb2R1bGUrXCJfaXRlbXNcXFwiPjwvZGl2PjwvZGl2PlwiKTtcblxuICAgICQuZ2V0SlNPTiggaG96dEFQSSwge1xuICAgICAgICBmb3JtYXQ6IFwianNvblwiXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggdHJhaW5pbmcgKSB7XG4gICAgICAgIGlmICggdHJhaW5pbmcucmVzdWx0ICl7XG4gICAgICAgICAgICAkLmVhY2goIHRyYWluaW5nLmRhdGEsIGZ1bmN0aW9uKCBpLCBpdGVtICkge1xuICAgICAgICAgICAgICAgIHZhciB0ID0gXCI8ZGl2IGNsYXNzPVxcXCJyb3cgbm8tZ3V0dGVyc1xcXCI+PGRpdiBjbGFzcz1cXFwiY29sLTUgY29sLW1kLTkgY29sLWxnLTYgdGV4dC1yaWdodCBwdC0xIHNtYWxsXFxcIj5cIisgaXRlbS50aW1lICsgXCI8L2Rpdj5cIjtcbiAgICAgICAgICAgICAgICB0ICs9IFwiPGRpdiBjbGFzcz1cXFwiY29sLTcgY29sLW1kLTMgY29sLWxnLTYgcGwtMVxcXCI+XCI7XG4gICAgICAgICAgICAgICAgJC5lYWNoKCBpdGVtLnRlYW1zLCBmdW5jdGlvbiggaSwgdGVhbSApIHtcbiAgICAgICAgICAgICAgICAgICAgdCArPSBcIjxzcGFuIGNsYXNzPVxcXCJiYWRnZSBiYWRnZS1wcmltYXJ5IGJhZGdlLXRlYW0gbWwtMVxcXCI+XCIgKyB0ZWFtLmFiYnIgKyBcIjwvc3Bhbj5cIjtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICBpZiAoIGl0ZW0uY29tbWVudCApe1xuICAgICAgICAgICAgICAgICAgIHQgKz0gXCI8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2Utc2Vjb25kYXJ5IG1sLTFcXFwiPlwiICsgaXRlbS5jb21tZW50ICsgXCI8L3NwYW4+XCI7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIHQgKz0gXCI8L2Rpdj48L2Rpdj5cIjtcbiAgICAgICAgICAgICAgICAkKCB0ICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoIFwiPGRpdiBjbGFzcz1cXFwic21hbGwgbWwtM1xcXCI+RXIgaXMgbW9yZ2VuIGdlZW4gdHJhaW5pbmc8L2Rpdj5cIiApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICB9XG4gICAgfSk7XG5cbn1cblxuLy8gYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Jlc3VsdHNcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9yZXN1bHRzKCkge1xuXG4gICAgdmFyIG1vZHVsZSA9IFwiYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Jlc3VsdHNcIjtcbiAgICB2YXIgaG96dEFQSSAgPSBcIi9hcGkvZG9jdW1lbnRlbi93ZWRzdHJpamRlbi9sYWF0c3RlL3VpdHNsYWcvNVwiO1xuXG4gICAgJCgnIycrbW9kdWxlKS5odG1sKFwiPGRpdiBjbGFzcz1cXFwicC0zXFxcIj48aDUgY2xhc3M9XFxcInBiLTIgbWItMFxcXCI+VWl0c2xhZ2VuPC9oNT48ZGl2IGlkPVxcXCJcIittb2R1bGUrXCJfaXRlbXNcXFwiPjwvZGl2PjwvZGl2PlwiKTsgXG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGZpbGVzICkge1xuICAgICAgICBpZiAoIGZpbGVzLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCBmaWxlcy5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9IFwiPGRpdiBjbGFzcz1cXFwibWwtMyBzbWFsbFxcXCI+PGEgY2xhc3M9XFxcInRleHQtZGFya1xcXCIgaHJlZj1cXFwiXCIgKyBpdGVtLnVybCArIFwiXFxcIj48c3BhbiBjbGFzcz1cXFwidGV4dC1tdXRlZCBtci0yXFxcIj5cIiArIGl0ZW0uZGF0ZXN0ciArXCI8L3NwYW4+XCIrIGl0ZW0udGl0bGUgKyBcIjwvYT48L2Rpdj5cIjtcbiAgICAgICAgICAgICAgICAkKCB0ICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoIFwiPGRpdiBjbGFzcz1cXFwic21hbGwgbWwtM1xcXCI+R2VlbiB3ZWRzdHJpamQgdWl0c2xhZ2VuIGdldm9uZGVuPC9kaXY+XCIgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG59XG5cbi8vIGFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9wcm9ncmFtc1xuZnVuY3Rpb24gYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Byb2dyYW1zKCkge1xuXG4gICAgdmFyIG1vZHVsZSAgPSBcImFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9wcm9ncmFtc1wiO1xuICAgIHZhciBob3p0QVBJID0gXCIvYXBpL2RvY3VtZW50ZW4vd2Vkc3RyaWpkZW4vYWFuc3RhYW5kZS9wcm9ncmFtbWEvNVwiO1xuXG4gICAgJCgnIycrbW9kdWxlKS5odG1sKFwiPGRpdiBjbGFzcz1cXFwicC0zXFxcIj48aDUgY2xhc3M9XFxcInBiLTIgbWItMFxcXCI+UHJvZ3JhbW1hJ3M8L2g1PjxkaXYgaWQ9XFxcIlwiK21vZHVsZStcIl9pdGVtc1xcXCI+PC9kaXY+PC9kaXY+XCIpOyBcblxuICAgICQuZ2V0SlNPTiggaG96dEFQSSwge1xuICAgICAgICBmb3JtYXQ6IFwianNvblwiXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggZmlsZXMgKSB7XG4gICAgICAgIGlmICggZmlsZXMucmVzdWx0ICl7XG4gICAgICAgICAgICAkLmVhY2goIGZpbGVzLmRhdGEsIGZ1bmN0aW9uKCBpLCBpdGVtICkge1xuICAgICAgICAgICAgICAgIHZhciB0ID0gXCI8ZGl2IGNsYXNzPVxcXCJtbC0zIHNtYWxsXFxcIj48YSBjbGFzcz1cXFwidGV4dC1kYXJrXFxcIiBocmVmPVxcXCJcIiArIGl0ZW0uZG9jICsgXCJcXFwiIHRhcmdldD1cXFwiX0JsYW5rXFxcIj48c3BhbiBjbGFzcz1cXFwidGV4dC1tdXRlZCBtci0yXFxcIj5cIiArIGl0ZW0uZGF0ZXN0ciArXCI8L3NwYW4+XCIrIGl0ZW0udGl0bGUgKyBcIjwvYT48L2Rpdj5cIjtcbiAgICAgICAgICAgICAgICAkKCB0ICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoIFwiPGRpdiBjbGFzcz1cXFwic21hbGwgbWwtM1xcXCI+R2VlbiBwcm9ncmFtbWEncyBnZXZvbmRlbjwvZGl2PlwiICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmdcblxuZnVuY3Rpb24gYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nKCkge1xuXG4gICAgJCgnI2FwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZycpLmh0bWwoJzxkaXYgY2xhc3M9XCJwLTNcIj48aDUgY2xhc3M9XCJwYi0yIG1iLTBcIj5LYWxlbmRlcjwvaDU+PGRpdiBpZD1cImFwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZ19pdGVtc1wiPjwvZGl2PjwvZGl2PicpO1xuXG4gICAgdmFyIGhvenRBUEkgID0gXCIvYXBpL2thbGVuZGVyL2FhbnN0YWFuZGVcIjtcbiAgICB2YXIgaXRlbXNJZCAgPSBcIiNhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmdfaXRlbXNcIjsgXG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGNhbGVuZGFyICkge1xuICAgICAgICBpZiAoIGNhbGVuZGFyLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCBjYWxlbmRhci5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9ICcnO1xuICAgICAgICAgICAgICAgIHQgKz0gXCI8ZGl2IGNsYXNzPVxcXCJtZWRpYSBjYWwgY2FsLWxpbmsgcHQtMlxcXCIgb25jbGljaz1cXFwid2luZG93LmxvY2F0aW9uPSdcIiArIGl0ZW0udXJsICsgXCInO1xcXCI+XCI7XG4gICAgICAgICAgICAgICAgdCArPSAnICA8c3BhbiBjbGFzcz1cImJhZGdlIGJhZGdlLWRhcmsgbXItMiBjYWwgY2FsLXNtICcrIGl0ZW0uY2xhc3MgXG4gICAgICAgICAgICAgICAgdCArPSAnXCI+JysgaXRlbS5kYXkgKyc8YnI+JysgaXRlbS5tb250aCArJzwvc3Bhbj4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgPGRpdiBjbGFzcz1cIm1lZGlhLWJvZHkgcGItMiBtYi0wIHNtYWxsIGxoLTEyNSBib3JkZXItYm90dG9tIGJvcmRlci1ncmF5ICc7XG4gICAgICAgICAgICAgICAgaWYgKGl0ZW0uY2FuY2VsbGVkKXsgdCArPSAnY2FsLWNhbmNlbGxlZCB0ZXh0LWRhbmdlcic7IH0gZWxzZSB7IHQgKz0gJ3RleHQtbXV0ZWQnOyB9XG4gICAgICAgICAgICAgICAgdCArPSAnXCI+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgICAgPGRpdiBjbGFzcz1cImQtZmxleCBqdXN0aWZ5LWNvbnRlbnQtYmV0d2VlbiBhbGlnbi1pdGVtcy1jZW50ZXIgdy0xMDBcIj4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgICAgIDxzdHJvbmcgY2xhc3M9XCJ0ZXh0LWdyYXktZGFya1wiPicraXRlbS50aXRsZSsnPC9zdHJvbmc+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgICAgICA8YSBocmVmPVwiI1wiIGNsYXNzPVwiZC1ub25lXCI+QmVraWprPC9hPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICAgIDwvZGl2Pic7XG4gICAgICAgICAgICAgICAgdCArPSAnICAgIDxzcGFuIGNsYXNzPVwiZC1ibG9ja1wiPicraXRlbS5mb3JtYXR0ZWRQZXJpb2QrJzwvc3Bhbj4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgPC9kaXY+JztcbiAgICAgICAgICAgICAgICB0ICs9ICc8L2Rpdj4nO1xuICAgICAgICAgICAgICAgICQoIHQgKS5hcHBlbmRUbyggaXRlbXNJZCApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAkKCc8cCBjbGFzcz1cInNtYWxsIG10LTIgdGV4dC1yaWdodFwiPjxhIGhyZWY9XCIva2FsZW5kZXJcIj48aSBjbGFzcz1cImZhcyBmYS1jYWxlbmRhci1wbHVzXCI+PC9pPiBBbGxlIGV2ZW50czwvYT48L3A+JykuYXBwZW5kVG8oIGl0ZW1zSWQgKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoIFwiPHA+RXIgemlqbiBnZWVuIGV2ZW50czwvcD5cIiApLmFwcGVuZFRvKCBpdGVtc0lkICk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ==