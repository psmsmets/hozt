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
__webpack_require__(/*! ../css/hozt.scss */ "./assets/css/hozt.scss");

__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

__webpack_require__(/*! jquery.scrollTo */ "./node_modules/jquery.scrollTo/jquery.scrollTo.js");



__webpack_require__(/*! @fortawesome/fontawesome-pro/css/all.min.css */ "./node_modules/@fortawesome/fontawesome-pro/css/all.min.css");

__webpack_require__(/*! @fortawesome/fontawesome-pro/js/all.js */ "./node_modules/@fortawesome/fontawesome-pro/js/all.js");

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

function getSessionTimeout(sessionModal, sessionWarn, sessionTime, sessionLogout) {
  $.getJSON("/api/session/timeout", function (result) {
    var logout = true;

    if (result.success) {
      if (result.elapsed < sessionWarn) {
        logout = false;
        $(sessionModal).modal('hide');
      } else if (result.elapsed < sessionTime) {
        $('#sessionModalRemaining').html(sessionTime - elapsed);
        $(sessionModal).modal('show');
      }
    }

    if (logout) {
      document.location.replace(sessionLogout.data('logout'));
    }
  }).fail(function () {
    document.location.reload(true); // force to get the login window
  });
}

function sessionHandler(sessionModal) {
  if ($(sessionModal).length == 0) return;
  var sessionTime = 1200;
  var sessionWarn = 900;
  var sessionLogout = $('#sessionModal [data-logout]');
  getSessionTimeout(sessionModal, sessionWarn, sessionTime, sessionLogout);
  $(sessionLogout).click(function () {
    document.location.replace(sessionLogout.data('logout'));
  });
  $(sessionModal).on('hide.bs.modal', function (e) {
    $.getJSON("/api/session/keep-alive");
  });
  var sessionInterval = setInterval(function () {
    getSessionTimeout(sessionModal, sessionWarn, sessionTime, sessionLogout);
  }, 15000);
}

sessionHandler($('#sessionModal'));
$(document).ready(function () {
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
  var bannerImgTop; // scroll elements

  var scrollFadeIn = $('.scroll-fade-in');
  var carousel = $('.carousel-item'); // todo: remove carousel scroll parallax using js

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


    if ($(scrollFadeIn).length > 0) {
      $(scrollFadeIn).each(function (i) {
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
    }

    if ($(carousel).length > 0) {
      if (scrollPos <= bannerHeight0) {
        $(carousel).each(function () {
          bannerImgTop = bannerImgTop0 - 2 * ((bannerHeight0 - scrollPos) / bannerHeight0 - 1) * 50 * bannerVelocity;
          $(this).children('img').css('top', Math.round(bannerImgTop * 100) / 100 + '%');
        });
      }
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
  $('#' + module).html("<div class=\"pt-3 pb-3 pl-3 pr-0\"><h5 class=\"pb-2 mb-0\">Trainingsuren <span class=\"badge badge-primary font-weight-light align-text-top\">vandaag</span></h5><div id=\"" + module + "_items\"></div></div>");
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
  $('#' + module).html("<div class=\"pt-3 pb-3 pl-3 pr-0\"><h5 class=\"pb-2 mb-0\">Trainingsuren <span class=\"badge badge-medium font-weight-light align-text-top\">morgen</span></h5><div id=\"" + module + "_items\"></div></div>");
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

},[["./assets/js/hozt.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275","vendors~carousel~hozt~membership_competitions~membership_preferences~sportadmin_competitions","vendors~hozt"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2hvenQuc2NzcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvaG96dC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsIndpbmRvdyIsImRpZFNjcm9sbCIsImxhc3RTY3JvbGxUb3AiLCJkZWx0YSIsIm5hdmJhckhlaWdodCIsIm91dGVySGVpZ2h0Iiwic2Nyb2xsIiwiZXZlbnQiLCJzZXRJbnRlcnZhbCIsImhhc1Njcm9sbGVkIiwic3QiLCJzY3JvbGxUb3AiLCJNYXRoIiwiYWJzIiwiYW5pbWF0ZSIsImhlaWdodCIsImRvY3VtZW50IiwiYWRkQW5pbWF0aW9uIiwiaWQiLCJlZmZlY3QiLCJyZW1vdmVDbGFzcyIsImFkZENsYXNzIiwib25lIiwidG9DbGlwYm9hcmQiLCJlbGVtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJ0ZXh0QXJlYSIsImNyZWF0ZUVsZW1lbnQiLCJ2YWx1ZSIsInRleHRDb250ZW50IiwiYm9keSIsImFwcGVuZENoaWxkIiwic2VsZWN0IiwiZXhlY0NvbW1hbmQiLCJyZW1vdmUiLCJnZXRTZXNzaW9uVGltZW91dCIsInNlc3Npb25Nb2RhbCIsInNlc3Npb25XYXJuIiwic2Vzc2lvblRpbWUiLCJzZXNzaW9uTG9nb3V0IiwiZ2V0SlNPTiIsInJlc3VsdCIsImxvZ291dCIsInN1Y2Nlc3MiLCJlbGFwc2VkIiwibW9kYWwiLCJodG1sIiwibG9jYXRpb24iLCJyZXBsYWNlIiwiZGF0YSIsImZhaWwiLCJyZWxvYWQiLCJzZXNzaW9uSGFuZGxlciIsImxlbmd0aCIsImNsaWNrIiwib24iLCJlIiwic2Vzc2lvbkludGVydmFsIiwicmVhZHkiLCJ0b29sdGlwIiwicG9wb3ZlciIsInRvZ2dsZUNsYXNzIiwic2Nyb2xsVG8iLCJvcHRpb25zIiwidXNlRWFzaW5nIiwidXNlR3JvdXBpbmciLCJzZXBhcmF0b3IiLCJkZWNpbWFsIiwiZHVyYXRpb24iLCJjbnR1cFRlYW1zIiwiQ291bnRVcCIsImVycm9yIiwic3RhcnQiLCJjb25zb2xlIiwiY250dXBDb2FjaGVzIiwiY250dXBNZW1iZXJzIiwic2Nyb2xsUG9zIiwidG9Ub3BWaXNpYmxlIiwidG9Ub3AiLCJiYW5uZXJWZWxvY2l0eSIsImJhbm5lclBvczAiLCJjc3MiLCJzcGxpdCIsImJhbm5lckhlaWdodDAiLCJiYW5uZXJQb3NZMCIsInBhcnNlSW50IiwiYmFubmVyUG9zWSIsImJhbm5lckltZ1RvcDAiLCJiYW5uZXJJbWdUb3AiLCJzY3JvbGxGYWRlSW4iLCJjYXJvdXNlbCIsInN0eWxlIiwidmlzaWJpbGl0eSIsIm9wYWNpdHkiLCJlYWNoIiwiaSIsInBvc2l0aW9uIiwidG9wIiwic3BlY2lhbEVhc2luZyIsImNvbXBsZXRlIiwiY2hpbGRyZW4iLCJyb3VuZCIsImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190eXIiLCJhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXMiLCJhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcmVzdWx0cyIsImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b2RheSIsImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvdyIsImFwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZyIsInNldENvb2tpZSIsImNuYW1lIiwiY3ZhbHVlIiwiZXhkYXlzIiwiZCIsIkRhdGUiLCJzZXRUaW1lIiwiZ2V0VGltZSIsImV4cGlyZXMiLCJ0b1VUQ1N0cmluZyIsImNvb2tpZSIsInRvVHlyIiwidCIsInNldFRpbWVvdXQiLCJvcGVuIiwibW9kdWxlIiwiaG96dEFQSSIsImZvcm1hdCIsImRvbmUiLCJ0cmFpbmluZyIsIml0ZW0iLCJ0aW1lIiwidGVhbXMiLCJ0ZWFtIiwiYWJiciIsImNvbW1lbnQiLCJhcHBlbmRUbyIsImZpbGVzIiwidXJsIiwiZGF0ZXN0ciIsInRpdGxlIiwiZG9jIiwiaXRlbXNJZCIsImNhbGVuZGFyIiwiZGF5IiwibW9udGgiLCJjYW5jZWxsZWQiLCJmb3JtYXR0ZWRQZXJpb2QiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBLHVDOzs7Ozs7Ozs7Ozs7QUNBQUE7QUFBQUE7QUFBQUEsbUJBQU8sQ0FBQyxnREFBRCxDQUFQOztBQUVBQSxtQkFBTyxDQUFDLGdFQUFELENBQVA7O0FBQ0FBLG1CQUFPLENBQUMsMEVBQUQsQ0FBUDs7QUFDQTs7QUFFQUEsbUJBQU8sQ0FBQyxpSEFBRCxDQUFQOztBQUNBQSxtQkFBTyxDQUFDLHFHQUFELENBQVA7O0FBRUEsSUFBSUMsQ0FBQyxHQUFHRCxtQkFBTyxDQUFDLG9EQUFELENBQWY7O0FBQ0FFLE1BQU0sQ0FBQ0QsQ0FBUCxHQUFXQSxDQUFYO0FBQ0FDLG9DQUFBLEdBQWdCRCxDQUFoQixDLENBRUE7O0FBQ0EsSUFBSUUsU0FBSjtBQUNBLElBQUlDLGFBQWEsR0FBRyxDQUFwQjtBQUNBLElBQUlDLEtBQUssR0FBRyxFQUFaO0FBQ0EsSUFBSUMsWUFBWSxHQUFHTCxDQUFDLENBQUMsaUJBQUQsQ0FBRCxDQUFxQk0sV0FBckIsRUFBbkI7QUFFQU4sQ0FBQyxDQUFDQyxNQUFELENBQUQsQ0FBVU0sTUFBVixDQUFpQixVQUFTQyxLQUFULEVBQWU7QUFDNUJOLFdBQVMsR0FBRyxJQUFaO0FBQ0gsQ0FGRDtBQUlBTyxXQUFXLENBQUMsWUFBVztBQUNuQixNQUFJUCxTQUFKLEVBQWU7QUFDWFEsZUFBVztBQUNYUixhQUFTLEdBQUcsS0FBWjtBQUNIO0FBQ0osQ0FMVSxFQUtSLEdBTFEsQ0FBWDs7QUFPQSxTQUFTUSxXQUFULEdBQXVCO0FBQ25CLE1BQUlDLEVBQUUsR0FBR1gsQ0FBQyxDQUFDQyxNQUFELENBQUQsQ0FBVVcsU0FBVixFQUFULENBRG1CLENBR25COztBQUNBLE1BQUlDLElBQUksQ0FBQ0MsR0FBTCxDQUFTWCxhQUFhLEdBQUdRLEVBQXpCLEtBQWdDUCxLQUFwQyxFQUEwQztBQUN0QztBQUNILEdBTmtCLENBUW5CO0FBQ0E7OztBQUNBLE1BQUlPLEVBQUUsR0FBR1IsYUFBTCxJQUFzQlEsRUFBRSxHQUFHTixZQUEvQixFQUE0QztBQUN4QztBQUNBTCxLQUFDLENBQUMsaUJBQUQsQ0FBRCxDQUFxQmUsT0FBckIsQ0FBNkI7QUFBQyxhQUFNO0FBQVAsS0FBN0IsRUFBNkMsR0FBN0M7QUFDSCxHQUhELE1BR087QUFDSDtBQUNBLFFBQUdKLEVBQUUsR0FBR1gsQ0FBQyxDQUFDQyxNQUFELENBQUQsQ0FBVWUsTUFBVixFQUFMLEdBQTBCaEIsQ0FBQyxDQUFDaUIsUUFBRCxDQUFELENBQVlELE1BQVosRUFBN0IsRUFBbUQ7QUFDL0NoQixPQUFDLENBQUMsaUJBQUQsQ0FBRCxDQUFxQmUsT0FBckIsQ0FBNkI7QUFBQyxlQUFNO0FBQVAsT0FBN0IsRUFBeUMsR0FBekM7QUFDSDtBQUNKOztBQUVEWixlQUFhLEdBQUdRLEVBQWhCO0FBQ0g7O0FBRUQsU0FBU08sWUFBVCxDQUFzQkMsRUFBdEIsRUFBMEJDLE1BQTFCLEVBQWtDO0FBQzlCcEIsR0FBQyxDQUFDLE1BQUltQixFQUFMLENBQUQsQ0FBVUUsV0FBVixHQUF3QkMsUUFBeEIsQ0FBaUNGLE1BQU0sR0FBRyxXQUExQyxFQUF1REcsR0FBdkQsQ0FBMkQsOEVBQTNELEVBQTJJLFlBQVU7QUFDakp2QixLQUFDLENBQUMsSUFBRCxDQUFELENBQVFxQixXQUFSO0FBQ0gsR0FGRDtBQUdIOztBQUFBOztBQUVELFNBQVNHLFdBQVQsQ0FBcUJMLEVBQXJCLEVBQXdCO0FBQ3BCLE1BQUlNLE9BQU8sR0FBR1IsUUFBUSxDQUFDUyxjQUFULENBQXdCUCxFQUF4QixDQUFkO0FBQ0EsTUFBSVEsUUFBUSxHQUFHVixRQUFRLENBQUNXLGFBQVQsQ0FBdUIsVUFBdkIsQ0FBZjtBQUNBRCxVQUFRLENBQUNFLEtBQVQsR0FBaUJKLE9BQU8sQ0FBQ0ssV0FBekI7QUFDQWIsVUFBUSxDQUFDYyxJQUFULENBQWNDLFdBQWQsQ0FBMEJMLFFBQTFCO0FBQ0FBLFVBQVEsQ0FBQ00sTUFBVDtBQUNBaEIsVUFBUSxDQUFDaUIsV0FBVCxDQUFxQixNQUFyQjtBQUNBUCxVQUFRLENBQUNRLE1BQVQ7QUFDSDs7QUFBQTs7QUFFRCxTQUFTQyxpQkFBVCxDQUE0QkMsWUFBNUIsRUFBMENDLFdBQTFDLEVBQXVEQyxXQUF2RCxFQUFvRUMsYUFBcEUsRUFBb0Y7QUFDaEZ4QyxHQUFDLENBQUN5QyxPQUFGLENBQVUsc0JBQVYsRUFBa0MsVUFBU0MsTUFBVCxFQUFpQjtBQUMvQyxRQUFJQyxNQUFNLEdBQUcsSUFBYjs7QUFDQSxRQUFJRCxNQUFNLENBQUNFLE9BQVgsRUFBb0I7QUFDaEIsVUFBSUYsTUFBTSxDQUFDRyxPQUFQLEdBQWlCUCxXQUFyQixFQUFrQztBQUM5QkssY0FBTSxHQUFHLEtBQVQ7QUFDQTNDLFNBQUMsQ0FBQ3FDLFlBQUQsQ0FBRCxDQUFnQlMsS0FBaEIsQ0FBc0IsTUFBdEI7QUFDSCxPQUhELE1BR08sSUFBSUosTUFBTSxDQUFDRyxPQUFQLEdBQWlCTixXQUFyQixFQUFrQztBQUNyQ3ZDLFNBQUMsQ0FBQyx3QkFBRCxDQUFELENBQTRCK0MsSUFBNUIsQ0FBaUNSLFdBQVcsR0FBQ00sT0FBN0M7QUFDQTdDLFNBQUMsQ0FBQ3FDLFlBQUQsQ0FBRCxDQUFnQlMsS0FBaEIsQ0FBc0IsTUFBdEI7QUFDSDtBQUNKOztBQUNELFFBQUlILE1BQUosRUFBWTtBQUNSMUIsY0FBUSxDQUFDK0IsUUFBVCxDQUFrQkMsT0FBbEIsQ0FBMEJULGFBQWEsQ0FBQ1UsSUFBZCxDQUFtQixRQUFuQixDQUExQjtBQUNIO0FBQ0osR0FkRCxFQWNHQyxJQWRILENBY1EsWUFBVztBQUNmbEMsWUFBUSxDQUFDK0IsUUFBVCxDQUFrQkksTUFBbEIsQ0FBeUIsSUFBekIsRUFEZSxDQUNpQjtBQUNuQyxHQWhCRDtBQWlCSDs7QUFFRCxTQUFTQyxjQUFULENBQXlCaEIsWUFBekIsRUFBdUM7QUFFbkMsTUFBSXJDLENBQUMsQ0FBQ3FDLFlBQUQsQ0FBRCxDQUFnQmlCLE1BQWhCLElBQTBCLENBQTlCLEVBQWtDO0FBRWxDLE1BQUlmLFdBQVcsR0FBRyxJQUFsQjtBQUNBLE1BQUlELFdBQVcsR0FBRyxHQUFsQjtBQUNBLE1BQUlFLGFBQWEsR0FBR3hDLENBQUMsQ0FBQyw2QkFBRCxDQUFyQjtBQUVBb0MsbUJBQWlCLENBQUVDLFlBQUYsRUFBZ0JDLFdBQWhCLEVBQTZCQyxXQUE3QixFQUEwQ0MsYUFBMUMsQ0FBakI7QUFFQXhDLEdBQUMsQ0FBQ3dDLGFBQUQsQ0FBRCxDQUFpQmUsS0FBakIsQ0FBdUIsWUFBVztBQUM5QnRDLFlBQVEsQ0FBQytCLFFBQVQsQ0FBa0JDLE9BQWxCLENBQTBCVCxhQUFhLENBQUNVLElBQWQsQ0FBbUIsUUFBbkIsQ0FBMUI7QUFDSCxHQUZEO0FBSUFsRCxHQUFDLENBQUNxQyxZQUFELENBQUQsQ0FBZ0JtQixFQUFoQixDQUFtQixlQUFuQixFQUFvQyxVQUFVQyxDQUFWLEVBQWE7QUFDN0N6RCxLQUFDLENBQUN5QyxPQUFGLENBQVUseUJBQVY7QUFDSCxHQUZEO0FBSUEsTUFBSWlCLGVBQWUsR0FBR2pELFdBQVcsQ0FBQyxZQUFXO0FBQ3pDMkIscUJBQWlCLENBQUVDLFlBQUYsRUFBZ0JDLFdBQWhCLEVBQTZCQyxXQUE3QixFQUEwQ0MsYUFBMUMsQ0FBakI7QUFDSCxHQUZnQyxFQUU5QixLQUY4QixDQUFqQztBQUdIOztBQUVEYSxjQUFjLENBQUNyRCxDQUFDLENBQUMsZUFBRCxDQUFGLENBQWQ7QUFHQUEsQ0FBQyxDQUFDaUIsUUFBRCxDQUFELENBQVkwQyxLQUFaLENBQWtCLFlBQVU7QUFFeEIzRCxHQUFDLENBQUMsWUFBWTtBQUNWQSxLQUFDLENBQUMseUJBQUQsQ0FBRCxDQUE2QjRELE9BQTdCO0FBQ0gsR0FGQSxDQUFEO0FBSUE1RCxHQUFDLENBQUMsWUFBVztBQUNWQSxLQUFDLENBQUMseUJBQUQsQ0FBRCxDQUE2QjZELE9BQTdCO0FBQ0YsR0FGQSxDQUFEO0FBSUE3RCxHQUFDLENBQUMsWUFBWTtBQUNWOztBQUNBQSxLQUFDLENBQUMsMkJBQUQsQ0FBRCxDQUErQndELEVBQS9CLENBQWtDLE9BQWxDLEVBQTJDLFlBQVU7QUFDakR4RCxPQUFDLENBQUMscUJBQUQsQ0FBRCxDQUF5QjhELFdBQXpCLENBQXFDLE1BQXJDO0FBQ0gsS0FGRDtBQUdILEdBTEEsQ0FBRDtBQU9BOUQsR0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZdUQsS0FBWixDQUFrQixVQUFTRSxDQUFULEVBQVc7QUFDekJ6RCxLQUFDLENBQUMrRCxRQUFGLENBQVcsQ0FBWCxFQUFjLEdBQWQ7QUFDSCxHQUZEO0FBSUEvRCxHQUFDLENBQUMsZ0JBQUQsQ0FBRCxDQUFvQndELEVBQXBCLENBQXVCLGdCQUF2QixFQUF5QyxVQUFTQyxDQUFULEVBQVc7QUFDaEQsUUFBSU8sT0FBTyxHQUFHO0FBQ1ZDLGVBQVMsRUFBRSxJQUREO0FBRVZDLGlCQUFXLEVBQUUsSUFGSDtBQUdWQyxlQUFTLEVBQUUsR0FIRDtBQUlWQyxhQUFPLEVBQUUsR0FKQztBQUtWQyxjQUFRLEVBQUU7QUFMQSxLQUFkO0FBT0EsUUFBSUMsVUFBVSxHQUFHLElBQUlDLGtEQUFKLENBQVksY0FBWixFQUE0QnZFLENBQUMsQ0FBQyxlQUFELENBQUQsQ0FBbUJrRCxJQUFuQixDQUF3QixPQUF4QixDQUE1QixFQUE4RGMsT0FBOUQsQ0FBakI7O0FBQ0EsUUFBSSxDQUFDTSxVQUFVLENBQUNFLEtBQWhCLEVBQXNCO0FBQ2xCRixnQkFBVSxDQUFDRyxLQUFYO0FBQ0gsS0FGRCxNQUVPO0FBQ0hDLGFBQU8sQ0FBQ0YsS0FBUixDQUFjRixVQUFVLENBQUNFLEtBQXpCO0FBQ0g7O0FBQ0QsUUFBSUcsWUFBWSxHQUFHLElBQUlKLGtEQUFKLENBQVksZ0JBQVosRUFBOEJ2RSxDQUFDLENBQUMsaUJBQUQsQ0FBRCxDQUFxQmtELElBQXJCLENBQTBCLE9BQTFCLENBQTlCLEVBQWlFYyxPQUFqRSxDQUFuQjs7QUFDQSxRQUFJLENBQUNXLFlBQVksQ0FBQ0gsS0FBbEIsRUFBd0I7QUFDcEJHLGtCQUFZLENBQUNGLEtBQWI7QUFDSCxLQUZELE1BRU87QUFDSEMsYUFBTyxDQUFDRixLQUFSLENBQWNHLFlBQVksQ0FBQ0gsS0FBM0I7QUFDSDs7QUFDRCxRQUFJSSxZQUFZLEdBQUcsSUFBSUwsa0RBQUosQ0FBWSxnQkFBWixFQUE4QnZFLENBQUMsQ0FBQyxpQkFBRCxDQUFELENBQXFCa0QsSUFBckIsQ0FBMEIsT0FBMUIsQ0FBOUIsRUFBa0VjLE9BQWxFLENBQW5COztBQUNBLFFBQUksQ0FBQ1ksWUFBWSxDQUFDSixLQUFsQixFQUF3QjtBQUNwQkksa0JBQVksQ0FBQ0gsS0FBYjtBQUNILEtBRkQsTUFFTztBQUNIQyxhQUFPLENBQUNGLEtBQVIsQ0FBY0ksWUFBWSxDQUFDSixLQUEzQjtBQUNIO0FBQ0osR0ExQkQ7QUE2QkE7O0FBQ0EsTUFBSUssU0FBSjtBQUNBLE1BQUlDLFlBQVksR0FBQyxLQUFqQjtBQUNBLE1BQUlDLEtBQUssR0FBRzlELFFBQVEsQ0FBQ1MsY0FBVCxDQUF3QixPQUF4QixDQUFaO0FBRUE7O0FBQ0EsTUFBSXNELGNBQWMsR0FBRyxHQUFyQjtBQUNBLE1BQUlDLFVBQVUsR0FBR2pGLENBQUMsQ0FBQyxTQUFELENBQUQsQ0FBYWtGLEdBQWIsQ0FBaUIsb0JBQWpCLEVBQXVDQyxLQUF2QyxDQUE2QyxHQUE3QyxDQUFqQjtBQUNBLE1BQUlDLGFBQWEsR0FBR3BGLENBQUMsQ0FBQyxTQUFELENBQUQsQ0FBYWdCLE1BQWIsS0FBd0JoQixDQUFDLENBQUMsaUJBQUQsQ0FBRCxDQUFxQmdCLE1BQXJCLEVBQTVDO0FBQ0EsTUFBSXFFLFdBQVcsR0FBR0MsUUFBUSxDQUFDTCxVQUFVLENBQUMsQ0FBRCxDQUFYLENBQTFCO0FBQ0EsTUFBSU0sVUFBSjtBQUNBLE1BQUlDLGFBQWEsR0FBRyxFQUFwQjtBQUNBLE1BQUlDLFlBQUosQ0E5RHdCLENBZ0V4Qjs7QUFDQSxNQUFJQyxZQUFZLEdBQUcxRixDQUFDLENBQUMsaUJBQUQsQ0FBcEI7QUFDQSxNQUFJMkYsUUFBUSxHQUFHM0YsQ0FBQyxDQUFDLGdCQUFELENBQWhCLENBbEV3QixDQW1FeEI7O0FBRUE7O0FBQ0FBLEdBQUMsQ0FBQ0MsTUFBRCxDQUFELENBQVVNLE1BQVYsQ0FBa0IsWUFBVTtBQUV4QnNFLGFBQVMsR0FBRzdFLENBQUMsQ0FBQ0MsTUFBRCxDQUFELENBQVVXLFNBQVYsRUFBWixDQUZ3QixDQUl4Qjs7QUFDQSxRQUFLaUUsU0FBUyxJQUFJLEdBQWIsSUFBb0IsQ0FBQ0MsWUFBMUIsRUFBd0M7QUFDcENBLGtCQUFZLEdBQUMsSUFBYjtBQUNBQyxXQUFLLENBQUNhLEtBQU4sQ0FBWUMsVUFBWixHQUF1QixTQUF2QjtBQUNBZCxXQUFLLENBQUNhLEtBQU4sQ0FBWUUsT0FBWixHQUFvQixHQUFwQjtBQUNBOUYsT0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZZSxPQUFaLENBQW9CO0FBQUMsbUJBQVU7QUFBWCxPQUFwQixFQUFvQyxHQUFwQztBQUNIOztBQUNELFFBQUs4RCxTQUFTLEdBQUcsR0FBWixJQUFtQkMsWUFBeEIsRUFBc0M7QUFDbENBLGtCQUFZLEdBQUMsS0FBYjtBQUNBOUUsT0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZZSxPQUFaLENBQW9CO0FBQUMsbUJBQVU7QUFBWCxPQUFwQixFQUFvQyxHQUFwQyxFQUF3QyxZQUFVO0FBQzlDZ0UsYUFBSyxDQUFDYSxLQUFOLENBQVlDLFVBQVosR0FBdUIsUUFBdkI7QUFDSCxPQUZEO0FBR0g7QUFFRDs7O0FBQ0EsUUFBSzdGLENBQUMsQ0FBQzBGLFlBQUQsQ0FBRCxDQUFnQnBDLE1BQWhCLEdBQXlCLENBQTlCLEVBQWtDO0FBQzlCdEQsT0FBQyxDQUFDMEYsWUFBRCxDQUFELENBQWdCSyxJQUFoQixDQUFzQixVQUFTQyxDQUFULEVBQVk7QUFDOUIsWUFBS2hHLENBQUMsQ0FBQ0MsTUFBRCxDQUFELENBQVVXLFNBQVYsS0FBd0JaLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUWlHLFFBQVIsR0FBbUJDLEdBQW5CLEdBQXlCbEcsQ0FBQyxDQUFDQyxNQUFELENBQUQsQ0FBVWUsTUFBVixLQUFtQixDQUF6RSxFQUE0RTtBQUV4RWhCLFdBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUWUsT0FBUixDQUFnQjtBQUNaK0UsbUJBQU8sRUFBRTtBQURHLFdBQWhCLEVBRUU7QUFDRXpCLG9CQUFRLEVBQUUsSUFEWjtBQUVFOEIseUJBQWEsRUFBRSxFQUZqQjtBQUdFQyxvQkFBUSxFQUFFLG9CQUFXO0FBQ2pCcEcsZUFBQyxDQUFFLElBQUYsQ0FBRCxDQUFVcUIsV0FBVixDQUF1QixnQkFBdkI7QUFDSDtBQUxILFdBRkY7QUFTSDtBQUNKLE9BYkQ7QUFjSDs7QUFFRCxRQUFLckIsQ0FBQyxDQUFDMkYsUUFBRCxDQUFELENBQVlyQyxNQUFaLEdBQXFCLENBQTFCLEVBQThCO0FBQzFCLFVBQUl1QixTQUFTLElBQUlPLGFBQWpCLEVBQWdDO0FBQzVCcEYsU0FBQyxDQUFDMkYsUUFBRCxDQUFELENBQVlJLElBQVosQ0FBaUIsWUFBVztBQUN4Qk4sc0JBQVksR0FBR0QsYUFBYSxHQUFHLEtBQUssQ0FBQ0osYUFBYSxHQUFDUCxTQUFmLElBQTBCTyxhQUExQixHQUF3QyxDQUE3QyxJQUFnRCxFQUFoRCxHQUFxREosY0FBcEY7QUFDQWhGLFdBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUXFHLFFBQVIsQ0FBaUIsS0FBakIsRUFBd0JuQixHQUF4QixDQUE0QixLQUE1QixFQUFtQ3JFLElBQUksQ0FBQ3lGLEtBQUwsQ0FBV2IsWUFBWSxHQUFHLEdBQTFCLElBQWlDLEdBQWpDLEdBQXVDLEdBQTFFO0FBQ0gsU0FIRDtBQUlIO0FBQ0o7QUFFSixHQTdDRDtBQStDSCxDQXJIRDtBQXdIQXpGLENBQUMsQ0FBQ0MsTUFBRCxDQUFELENBQVV1RCxFQUFWLENBQWMsTUFBZCxFQUFzQixZQUFXO0FBQzdCK0MsOEJBQTRCO0FBQzVCQyxzQ0FBb0M7QUFDcENDLHFDQUFtQztBQUNuQ0MsZ0NBQThCO0FBQzlCQyxtQ0FBaUM7QUFDakNDLG1DQUFpQztBQUNwQyxDQVBEOztBQVVBLFNBQVNDLFNBQVQsQ0FBbUJDLEtBQW5CLEVBQTBCQyxNQUExQixFQUFrQ0MsTUFBbEMsRUFBMEM7QUFDdEMsTUFBSUMsQ0FBQyxHQUFHLElBQUlDLElBQUosRUFBUjtBQUNBRCxHQUFDLENBQUNFLE9BQUYsQ0FBVUYsQ0FBQyxDQUFDRyxPQUFGLEtBQWVKLE1BQU0sR0FBQyxFQUFQLEdBQVUsRUFBVixHQUFhLEVBQWIsR0FBZ0IsSUFBekM7QUFDQSxNQUFJSyxPQUFPLEdBQUcsYUFBWUosQ0FBQyxDQUFDSyxXQUFGLEVBQTFCO0FBQ0FyRyxVQUFRLENBQUNzRyxNQUFULEdBQWtCVCxLQUFLLEdBQUcsR0FBUixHQUFjQyxNQUFkLEdBQXVCLEdBQXZCLEdBQTZCTSxPQUE3QixHQUF1QyxTQUF6RDtBQUNIOztBQUVEckgsQ0FBQyxDQUFDLGlCQUFELENBQUQsQ0FBcUIrRixJQUFyQixDQUEyQixZQUFXO0FBQ3BDLE1BQUllLEtBQUssR0FBRzlHLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUWtELElBQVIsQ0FBYSxPQUFiLENBQVo7QUFDQSxNQUFJNkQsTUFBTSxHQUFHL0csQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRa0QsSUFBUixDQUFhLFFBQWIsQ0FBYjtBQUNBbEQsR0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRd0QsRUFBUixDQUFXLGlCQUFYLEVBQThCLFlBQVk7QUFDeENxRCxhQUFTLENBQUVDLEtBQUYsRUFBU0MsTUFBVCxFQUFpQixFQUFqQixDQUFUO0FBQ0QsR0FGRDtBQUdELENBTkQsRSxDQVNBOztBQUNBLFNBQVNSLDRCQUFULEdBQXdDO0FBQ3BDdkcsR0FBQyxDQUFDLHNCQUFELENBQUQsQ0FBMEIrQyxJQUExQixDQUErQiw2Y0FBL0I7QUFDQS9DLEdBQUMsQ0FBQyxNQUFELENBQUQsQ0FBVXVELEtBQVYsQ0FBZ0IsVUFBU0UsQ0FBVCxFQUFXO0FBQ3pCK0QsU0FBSztBQUNOLEdBRkQ7QUFHSDs7QUFDRCxTQUFTQSxLQUFULEdBQWdCO0FBQ1poRyxhQUFXLENBQUMsY0FBRCxDQUFYO0FBQ0FOLGNBQVksQ0FBQyxjQUFELEVBQWdCLE1BQWhCLENBQVo7QUFDQSxNQUFJdUcsQ0FBQyxHQUFHQyxVQUFVLENBQUMsWUFBVTtBQUFDekgsVUFBTSxDQUFDMEgsSUFBUCxDQUFZLG1CQUFaLEVBQWdDLFFBQWhDO0FBQTJDLEdBQXZELEVBQXdELElBQXhELENBQWxCO0FBQ0gsQyxDQUVEOzs7QUFDQSxTQUFTakIsOEJBQVQsR0FBMEM7QUFFdEMsTUFBSWtCLE1BQU0sR0FBRyxnQ0FBYjtBQUNBLE1BQUlDLE9BQU8sR0FBSSx1QkFBZjtBQUVEN0gsR0FBQyxDQUFDLE1BQUk0SCxNQUFMLENBQUQsQ0FBYzdFLElBQWQsQ0FBbUIsZ0xBQThLNkUsTUFBOUssR0FBcUwsdUJBQXhNO0FBRUM1SCxHQUFDLENBQUN5QyxPQUFGLENBQVdvRixPQUFYLEVBQW9CO0FBQ2hCQyxVQUFNLEVBQUU7QUFEUSxHQUFwQixFQUdDQyxJQUhELENBR00sVUFBVUMsUUFBVixFQUFxQjtBQUN2QixRQUFLQSxRQUFRLENBQUN0RixNQUFkLEVBQXNCO0FBQ2xCMUMsT0FBQyxDQUFDK0YsSUFBRixDQUFRaUMsUUFBUSxDQUFDOUUsSUFBakIsRUFBdUIsVUFBVThDLENBQVYsRUFBYWlDLElBQWIsRUFBb0I7QUFDdkMsWUFBSVIsQ0FBQyxHQUFHLGdHQUErRlEsSUFBSSxDQUFDQyxJQUFwRyxHQUEyRyxRQUFuSDtBQUNBVCxTQUFDLElBQUksOENBQUw7QUFDQXpILFNBQUMsQ0FBQytGLElBQUYsQ0FBUWtDLElBQUksQ0FBQ0UsS0FBYixFQUFvQixVQUFVbkMsQ0FBVixFQUFhb0MsSUFBYixFQUFvQjtBQUNwQ1gsV0FBQyxJQUFJLHlEQUF5RFcsSUFBSSxDQUFDQyxJQUE5RCxHQUFxRSxTQUExRTtBQUNILFNBRkQ7O0FBR0EsWUFBS0osSUFBSSxDQUFDSyxPQUFWLEVBQW1CO0FBQ2hCYixXQUFDLElBQUksZ0RBQWdEUSxJQUFJLENBQUNLLE9BQXJELEdBQStELFNBQXBFO0FBQ0Y7O0FBQ0RiLFNBQUMsSUFBSSxjQUFMO0FBQ0F6SCxTQUFDLENBQUV5SCxDQUFGLENBQUQsQ0FBT2MsUUFBUCxDQUFpQixNQUFJWCxNQUFKLEdBQVcsUUFBNUI7QUFDSCxPQVhEO0FBWUgsS0FiRCxNQWFPO0FBQ0g1SCxPQUFDLENBQUUsNkRBQUYsQ0FBRCxDQUFtRXVJLFFBQW5FLENBQTZFLE1BQUlYLE1BQUosR0FBVyxRQUF4RjtBQUNIO0FBQ0osR0FwQkQ7QUFzQkgsQyxDQUVEOzs7QUFDQSxTQUFTakIsaUNBQVQsR0FBNkM7QUFFekMsTUFBSWlCLE1BQU0sR0FBRyxtQ0FBYjtBQUNBLE1BQUlDLE9BQU8sR0FBSSxzQkFBZjtBQUVEN0gsR0FBQyxDQUFDLE1BQUk0SCxNQUFMLENBQUQsQ0FBYzdFLElBQWQsQ0FBbUIsOEtBQTRLNkUsTUFBNUssR0FBbUwsdUJBQXRNO0FBRUM1SCxHQUFDLENBQUN5QyxPQUFGLENBQVdvRixPQUFYLEVBQW9CO0FBQ2hCQyxVQUFNLEVBQUU7QUFEUSxHQUFwQixFQUdDQyxJQUhELENBR00sVUFBVUMsUUFBVixFQUFxQjtBQUN2QixRQUFLQSxRQUFRLENBQUN0RixNQUFkLEVBQXNCO0FBQ2xCMUMsT0FBQyxDQUFDK0YsSUFBRixDQUFRaUMsUUFBUSxDQUFDOUUsSUFBakIsRUFBdUIsVUFBVThDLENBQVYsRUFBYWlDLElBQWIsRUFBb0I7QUFDdkMsWUFBSVIsQ0FBQyxHQUFHLGdHQUErRlEsSUFBSSxDQUFDQyxJQUFwRyxHQUEyRyxRQUFuSDtBQUNBVCxTQUFDLElBQUksOENBQUw7QUFDQXpILFNBQUMsQ0FBQytGLElBQUYsQ0FBUWtDLElBQUksQ0FBQ0UsS0FBYixFQUFvQixVQUFVbkMsQ0FBVixFQUFhb0MsSUFBYixFQUFvQjtBQUNwQ1gsV0FBQyxJQUFJLHlEQUF5RFcsSUFBSSxDQUFDQyxJQUE5RCxHQUFxRSxTQUExRTtBQUNILFNBRkQ7O0FBR0EsWUFBS0osSUFBSSxDQUFDSyxPQUFWLEVBQW1CO0FBQ2hCYixXQUFDLElBQUksZ0RBQWdEUSxJQUFJLENBQUNLLE9BQXJELEdBQStELFNBQXBFO0FBQ0Y7O0FBQ0RiLFNBQUMsSUFBSSxjQUFMO0FBQ0F6SCxTQUFDLENBQUV5SCxDQUFGLENBQUQsQ0FBT2MsUUFBUCxDQUFpQixNQUFJWCxNQUFKLEdBQVcsUUFBNUI7QUFDSCxPQVhEO0FBWUgsS0FiRCxNQWFPO0FBQ0g1SCxPQUFDLENBQUUsNERBQUYsQ0FBRCxDQUFrRXVJLFFBQWxFLENBQTRFLE1BQUlYLE1BQUosR0FBVyxRQUF2RjtBQUNIO0FBQ0osR0FwQkQ7QUFzQkgsQyxDQUVEOzs7QUFDQSxTQUFTbkIsbUNBQVQsR0FBK0M7QUFFM0MsTUFBSW1CLE1BQU0sR0FBRyxxQ0FBYjtBQUNBLE1BQUlDLE9BQU8sR0FBSSwrQ0FBZjtBQUVBN0gsR0FBQyxDQUFDLE1BQUk0SCxNQUFMLENBQUQsQ0FBYzdFLElBQWQsQ0FBbUIsd0VBQXNFNkUsTUFBdEUsR0FBNkUsdUJBQWhHO0FBRUE1SCxHQUFDLENBQUN5QyxPQUFGLENBQVdvRixPQUFYLEVBQW9CO0FBQ2hCQyxVQUFNLEVBQUU7QUFEUSxHQUFwQixFQUdDQyxJQUhELENBR00sVUFBVVMsS0FBVixFQUFrQjtBQUNwQixRQUFLQSxLQUFLLENBQUM5RixNQUFYLEVBQW1CO0FBQ2YxQyxPQUFDLENBQUMrRixJQUFGLENBQVF5QyxLQUFLLENBQUN0RixJQUFkLEVBQW9CLFVBQVU4QyxDQUFWLEVBQWFpQyxJQUFiLEVBQW9CO0FBQ3BDLFlBQUlSLENBQUMsR0FBRyw2REFBNkRRLElBQUksQ0FBQ1EsR0FBbEUsR0FBd0UscUNBQXhFLEdBQWdIUixJQUFJLENBQUNTLE9BQXJILEdBQThILFNBQTlILEdBQXlJVCxJQUFJLENBQUNVLEtBQTlJLEdBQXNKLFlBQTlKO0FBQ0EzSSxTQUFDLENBQUV5SCxDQUFGLENBQUQsQ0FBT2MsUUFBUCxDQUFpQixNQUFJWCxNQUFKLEdBQVcsUUFBNUI7QUFDSCxPQUhEO0FBSUgsS0FMRCxNQUtPO0FBQ0g1SCxPQUFDLENBQUUsbUVBQUYsQ0FBRCxDQUF5RXVJLFFBQXpFLENBQW1GLE1BQUlYLE1BQUosR0FBVyxRQUE5RjtBQUNIO0FBQ0osR0FaRDtBQWNILEMsQ0FFRDs7O0FBQ0EsU0FBU3BCLG9DQUFULEdBQWdEO0FBRTVDLE1BQUlvQixNQUFNLEdBQUksc0NBQWQ7QUFDQSxNQUFJQyxPQUFPLEdBQUcsb0RBQWQ7QUFFQTdILEdBQUMsQ0FBQyxNQUFJNEgsTUFBTCxDQUFELENBQWM3RSxJQUFkLENBQW1CLDBFQUF3RTZFLE1BQXhFLEdBQStFLHVCQUFsRztBQUVBNUgsR0FBQyxDQUFDeUMsT0FBRixDQUFXb0YsT0FBWCxFQUFvQjtBQUNoQkMsVUFBTSxFQUFFO0FBRFEsR0FBcEIsRUFHQ0MsSUFIRCxDQUdNLFVBQVVTLEtBQVYsRUFBa0I7QUFDcEIsUUFBS0EsS0FBSyxDQUFDOUYsTUFBWCxFQUFtQjtBQUNmMUMsT0FBQyxDQUFDK0YsSUFBRixDQUFReUMsS0FBSyxDQUFDdEYsSUFBZCxFQUFvQixVQUFVOEMsQ0FBVixFQUFhaUMsSUFBYixFQUFvQjtBQUNwQyxZQUFJUixDQUFDLEdBQUcsNkRBQTZEUSxJQUFJLENBQUNXLEdBQWxFLEdBQXdFLHVEQUF4RSxHQUFrSVgsSUFBSSxDQUFDUyxPQUF2SSxHQUFnSixTQUFoSixHQUEySlQsSUFBSSxDQUFDVSxLQUFoSyxHQUF3SyxZQUFoTDtBQUNBM0ksU0FBQyxDQUFFeUgsQ0FBRixDQUFELENBQU9jLFFBQVAsQ0FBaUIsTUFBSVgsTUFBSixHQUFXLFFBQTVCO0FBQ0gsT0FIRDtBQUlILEtBTEQsTUFLTztBQUNINUgsT0FBQyxDQUFFLDJEQUFGLENBQUQsQ0FBaUV1SSxRQUFqRSxDQUEyRSxNQUFJWCxNQUFKLEdBQVcsUUFBdEY7QUFDSDtBQUNKLEdBWkQ7QUFjSCxDLENBRUQ7OztBQUVBLFNBQVNoQixpQ0FBVCxHQUE2QztBQUV6QzVHLEdBQUMsQ0FBQyxvQ0FBRCxDQUFELENBQXdDK0MsSUFBeEMsQ0FBNkMsb0hBQTdDO0FBRUEsTUFBSThFLE9BQU8sR0FBSSwwQkFBZjtBQUNBLE1BQUlnQixPQUFPLEdBQUksMENBQWY7QUFFQTdJLEdBQUMsQ0FBQ3lDLE9BQUYsQ0FBV29GLE9BQVgsRUFBb0I7QUFDaEJDLFVBQU0sRUFBRTtBQURRLEdBQXBCLEVBR0NDLElBSEQsQ0FHTSxVQUFVZSxRQUFWLEVBQXFCO0FBQ3ZCLFFBQUtBLFFBQVEsQ0FBQ3BHLE1BQWQsRUFBc0I7QUFDbEIxQyxPQUFDLENBQUMrRixJQUFGLENBQVErQyxRQUFRLENBQUM1RixJQUFqQixFQUF1QixVQUFVOEMsQ0FBVixFQUFhaUMsSUFBYixFQUFvQjtBQUN2QyxZQUFJUixDQUFDLEdBQUcsRUFBUjtBQUNBQSxTQUFDLElBQUksdUVBQXVFUSxJQUFJLENBQUNRLEdBQTVFLEdBQWtGLE9BQXZGO0FBQ0FoQixTQUFDLElBQUkscURBQW9EUSxJQUFJLFNBQTdEO0FBQ0FSLFNBQUMsSUFBSSxPQUFNUSxJQUFJLENBQUNjLEdBQVgsR0FBZ0IsTUFBaEIsR0FBd0JkLElBQUksQ0FBQ2UsS0FBN0IsR0FBb0MsU0FBekM7QUFDQXZCLFNBQUMsSUFBSSw0RUFBTDs7QUFDQSxZQUFJUSxJQUFJLENBQUNnQixTQUFULEVBQW1CO0FBQUV4QixXQUFDLElBQUksMkJBQUw7QUFBbUMsU0FBeEQsTUFBOEQ7QUFBRUEsV0FBQyxJQUFJLFlBQUw7QUFBb0I7O0FBQ3BGQSxTQUFDLElBQUksSUFBTDtBQUNBQSxTQUFDLElBQUksMkVBQUw7QUFDQUEsU0FBQyxJQUFJLDBDQUF3Q1EsSUFBSSxDQUFDVSxLQUE3QyxHQUFtRCxXQUF4RDtBQUNBbEIsU0FBQyxJQUFJLDZDQUFMO0FBQ0FBLFNBQUMsSUFBSSxZQUFMO0FBQ0FBLFNBQUMsSUFBSSwrQkFBNkJRLElBQUksQ0FBQ2lCLGVBQWxDLEdBQWtELFNBQXZEO0FBQ0F6QixTQUFDLElBQUksVUFBTDtBQUNBQSxTQUFDLElBQUksUUFBTDtBQUNBekgsU0FBQyxDQUFFeUgsQ0FBRixDQUFELENBQU9jLFFBQVAsQ0FBaUJNLE9BQWpCO0FBQ0gsT0FoQkQ7QUFpQkE3SSxPQUFDLENBQUMsK0dBQUQsQ0FBRCxDQUFtSHVJLFFBQW5ILENBQTZITSxPQUE3SDtBQUNILEtBbkJELE1BbUJPO0FBQ0g3SSxPQUFDLENBQUUsNEJBQUYsQ0FBRCxDQUFrQ3VJLFFBQWxDLENBQTRDTSxPQUE1QztBQUNIO0FBQ0osR0ExQkQ7QUE0QkgsQyIsImZpbGUiOiJob3p0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luIiwicmVxdWlyZSgnLi4vY3NzL2hvenQuc2NzcycpO1xuXG5yZXF1aXJlKCdib290c3RyYXAnKTtcbnJlcXVpcmUoJ2pxdWVyeS5zY3JvbGxUbycpO1xuaW1wb3J0IHsgQ291bnRVcCB9IGZyb20gJ2NvdW50dXAuanMnO1xuXG5yZXF1aXJlKCdAZm9ydGF3ZXNvbWUvZm9udGF3ZXNvbWUtcHJvL2Nzcy9hbGwubWluLmNzcycpO1xucmVxdWlyZSgnQGZvcnRhd2Vzb21lL2ZvbnRhd2Vzb21lLXByby9qcy9hbGwuanMnKTtcblxudmFyICQgPSByZXF1aXJlKCdqcXVlcnknKTtcbndpbmRvdy4kID0gJDtcbndpbmRvdy5qUXVlcnkgPSAkO1xuXG4vLyBIaWRlIEhlYWRlciBvbiBvbiBzY3JvbGwgZG93blxudmFyIGRpZFNjcm9sbDtcbnZhciBsYXN0U2Nyb2xsVG9wID0gMDtcbnZhciBkZWx0YSA9IDEwO1xudmFyIG5hdmJhckhlaWdodCA9ICQoJyNuYXYtY2F0ZWdvcmllcycpLm91dGVySGVpZ2h0KCk7XG5cbiQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oZXZlbnQpe1xuICAgIGRpZFNjcm9sbCA9IHRydWU7XG59KTtcblxuc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKSB7XG4gICAgaWYgKGRpZFNjcm9sbCkge1xuICAgICAgICBoYXNTY3JvbGxlZCgpO1xuICAgICAgICBkaWRTY3JvbGwgPSBmYWxzZTtcbiAgICB9XG59LCAyNTApO1xuXG5mdW5jdGlvbiBoYXNTY3JvbGxlZCgpIHtcbiAgICB2YXIgc3QgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XG5cbiAgICAvLyBNYWtlIHN1cmUgdGhleSBzY3JvbGwgbW9yZSB0aGFuIGRlbHRhXG4gICAgaWYgKE1hdGguYWJzKGxhc3RTY3JvbGxUb3AgLSBzdCkgPD0gZGVsdGEpe1xuICAgICAgICByZXR1cm47XG4gICAgfVxuICAgIFxuICAgIC8vIElmIHRoZXkgc2Nyb2xsZWQgZG93biBhbmQgYXJlIHBhc3QgdGhlIG5hdmJhciwgYWRkIGNsYXNzIC5uYXYtdXAuXG4gICAgLy8gVGhpcyBpcyBuZWNlc3Nhcnkgc28geW91IG5ldmVyIHNlZSB3aGF0IGlzIFwiYmVoaW5kXCIgdGhlIG5hdmJhci5cbiAgICBpZiAoc3QgPiBsYXN0U2Nyb2xsVG9wICYmIHN0ID4gbmF2YmFySGVpZ2h0KXtcbiAgICAgICAgLy8gU2Nyb2xsIERvd25cbiAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6Jy00MHB4J30sMjUwKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICAvLyBTY3JvbGwgVXBcbiAgICAgICAgaWYoc3QgKyAkKHdpbmRvdykuaGVpZ2h0KCkgPCAkKGRvY3VtZW50KS5oZWlnaHQoKSkge1xuICAgICAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6JzAnfSwyNTApO1xuICAgICAgICB9XG4gICAgfVxuICAgIFxuICAgIGxhc3RTY3JvbGxUb3AgPSBzdDtcbn1cblxuZnVuY3Rpb24gYWRkQW5pbWF0aW9uKGlkLCBlZmZlY3QpIHtcbiAgICAkKCcjJytpZCkucmVtb3ZlQ2xhc3MoKS5hZGRDbGFzcyhlZmZlY3QgKyAnIGFuaW1hdGVkJykub25lKCd3ZWJraXRBbmltYXRpb25FbmQgbW96QW5pbWF0aW9uRW5kIE1TQW5pbWF0aW9uRW5kIG9hbmltYXRpb25lbmQgYW5pbWF0aW9uZW5kJywgZnVuY3Rpb24oKXtcbiAgICAgICAgJCh0aGlzKS5yZW1vdmVDbGFzcygpO1xuICAgIH0pO1xufTtcblxuZnVuY3Rpb24gdG9DbGlwYm9hcmQoaWQpe1xuICAgIHZhciBlbGVtZW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICAgIHZhciB0ZXh0QXJlYSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJ0ZXh0YXJlYVwiKTtcbiAgICB0ZXh0QXJlYS52YWx1ZSA9IGVsZW1lbnQudGV4dENvbnRlbnQ7XG4gICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCh0ZXh0QXJlYSk7XG4gICAgdGV4dEFyZWEuc2VsZWN0KCk7XG4gICAgZG9jdW1lbnQuZXhlY0NvbW1hbmQoXCJDb3B5XCIpO1xuICAgIHRleHRBcmVhLnJlbW92ZSgpO1xufTtcblxuZnVuY3Rpb24gZ2V0U2Vzc2lvblRpbWVvdXQoIHNlc3Npb25Nb2RhbCwgc2Vzc2lvbldhcm4sIHNlc3Npb25UaW1lLCBzZXNzaW9uTG9nb3V0ICkge1xuICAgICQuZ2V0SlNPTihcIi9hcGkvc2Vzc2lvbi90aW1lb3V0XCIsIGZ1bmN0aW9uKHJlc3VsdCkge1xuICAgICAgICB2YXIgbG9nb3V0ID0gdHJ1ZTtcbiAgICAgICAgaWYgKHJlc3VsdC5zdWNjZXNzKSB7IFxuICAgICAgICAgICAgaWYgKHJlc3VsdC5lbGFwc2VkIDwgc2Vzc2lvbldhcm4pIHtcbiAgICAgICAgICAgICAgICBsb2dvdXQgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAkKHNlc3Npb25Nb2RhbCkubW9kYWwoJ2hpZGUnKTtcbiAgICAgICAgICAgIH0gZWxzZSBpZiAocmVzdWx0LmVsYXBzZWQgPCBzZXNzaW9uVGltZSkge1xuICAgICAgICAgICAgICAgICQoJyNzZXNzaW9uTW9kYWxSZW1haW5pbmcnKS5odG1sKHNlc3Npb25UaW1lLWVsYXBzZWQpO1xuICAgICAgICAgICAgICAgICQoc2Vzc2lvbk1vZGFsKS5tb2RhbCgnc2hvdycpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIGlmIChsb2dvdXQpIHsgXG4gICAgICAgICAgICBkb2N1bWVudC5sb2NhdGlvbi5yZXBsYWNlKHNlc3Npb25Mb2dvdXQuZGF0YSgnbG9nb3V0JykpO1xuICAgICAgICB9XG4gICAgfSkuZmFpbChmdW5jdGlvbigpIHtcbiAgICAgICAgZG9jdW1lbnQubG9jYXRpb24ucmVsb2FkKHRydWUpOyAvLyBmb3JjZSB0byBnZXQgdGhlIGxvZ2luIHdpbmRvd1xuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBzZXNzaW9uSGFuZGxlciggc2Vzc2lvbk1vZGFsICl7XG5cbiAgICBpZiAoJChzZXNzaW9uTW9kYWwpLmxlbmd0aCA9PSAwICkgcmV0dXJuO1xuXG4gICAgdmFyIHNlc3Npb25UaW1lID0gMTIwMDtcbiAgICB2YXIgc2Vzc2lvbldhcm4gPSA5MDA7XG4gICAgdmFyIHNlc3Npb25Mb2dvdXQgPSAkKCcjc2Vzc2lvbk1vZGFsIFtkYXRhLWxvZ291dF0nKTtcblxuICAgIGdldFNlc3Npb25UaW1lb3V0KCBzZXNzaW9uTW9kYWwsIHNlc3Npb25XYXJuLCBzZXNzaW9uVGltZSwgc2Vzc2lvbkxvZ291dCApO1xuXG4gICAgJChzZXNzaW9uTG9nb3V0KS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgZG9jdW1lbnQubG9jYXRpb24ucmVwbGFjZShzZXNzaW9uTG9nb3V0LmRhdGEoJ2xvZ291dCcpKTtcbiAgICB9KTtcblxuICAgICQoc2Vzc2lvbk1vZGFsKS5vbignaGlkZS5icy5tb2RhbCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICQuZ2V0SlNPTihcIi9hcGkvc2Vzc2lvbi9rZWVwLWFsaXZlXCIpO1xuICAgIH0pO1xuXG4gICAgdmFyIHNlc3Npb25JbnRlcnZhbCA9IHNldEludGVydmFsKGZ1bmN0aW9uKCkge1xuICAgICAgICBnZXRTZXNzaW9uVGltZW91dCggc2Vzc2lvbk1vZGFsLCBzZXNzaW9uV2Fybiwgc2Vzc2lvblRpbWUsIHNlc3Npb25Mb2dvdXQgKTtcbiAgICB9LCAxNTAwMCk7XG59XG5cbnNlc3Npb25IYW5kbGVyKCQoJyNzZXNzaW9uTW9kYWwnKSk7XG5cblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcblxuICAgICQoZnVuY3Rpb24gKCkge1xuICAgICAgICAkKCdbZGF0YS10b2dnbGU9XCJ0b29sdGlwXCJdJykudG9vbHRpcCgpO1xuICAgIH0pXG5cbiAgICAkKGZ1bmN0aW9uKCkge1xuICAgICAgICQoJ1tkYXRhLXRvZ2dsZT1cInBvcG92ZXJcIl0nKS5wb3BvdmVyKCk7XG4gICAgfSlcblxuICAgICQoZnVuY3Rpb24gKCkge1xuICAgICAgICAndXNlIHN0cmljdCdcbiAgICAgICAgJCgnW2RhdGEtdG9nZ2xlPVwib2ZmY2FudmFzXCJdJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICQoJy5vZmZjYW52YXMtY29sbGFwc2UnKS50b2dnbGVDbGFzcygnb3BlbicpXG4gICAgICAgIH0pXG4gICAgfSk7XG5cbiAgICAkKCcjdG9Ub3AnKS5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgICAgJC5zY3JvbGxUbygwLCA3MDApOyBcbiAgICB9KVxuXG4gICAgJCgnI2Rpc2NvdmVyTW9kYWwnKS5vbignc2hvd24uYnMubW9kYWwnLCBmdW5jdGlvbihlKXtcbiAgICAgICAgdmFyIG9wdGlvbnMgPSB7XG4gICAg4oCD4oCDICAgICAgdXNlRWFzaW5nOiB0cnVlLCBcbiAgICAgIOKAg+KAgyAgICB1c2VHcm91cGluZzogdHJ1ZSwgXG4gICAgICAgIOKAg+KAgyAgc2VwYXJhdG9yOiAnLCcsIFxuICAgICAg4oCD4oCDICAgIGRlY2ltYWw6ICcuJyxcbiAgICAgICAgICAgIGR1cmF0aW9uOiAzLFxuICAgICAgICB9O1xuICAgICAgICB2YXIgY250dXBUZWFtcyA9IG5ldyBDb3VudFVwKCdjb3VudHVwVGVhbXMnLCAkKCcjY291bnR1cFRlYW1zJykuZGF0YSgndmFsdWUnKSwgb3B0aW9ucyk7XG4gICAgICAgIGlmICghY250dXBUZWFtcy5lcnJvcil7XG4gICAgICAgICAgICBjbnR1cFRlYW1zLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnR1cFRlYW1zLmVycm9yKTtcbiAgICAgICAgfVxuICAgICAgICB2YXIgY250dXBDb2FjaGVzID0gbmV3IENvdW50VXAoJ2NvdW50dXBDb2FjaGVzJywgJCgnI2NvdW50dXBDb2FjaGVzJykuZGF0YSgndmFsdWUnKSxvcHRpb25zKTtcbiAgICAgICAgaWYgKCFjbnR1cENvYWNoZXMuZXJyb3Ipe1xu4oCD4oCDICAgICAgICAgIGNudHVwQ29hY2hlcy5zdGFydCgpO1xuICAgICAgICB9IGVsc2Uge1xu4oCD4oCDICAgICAgICAgIGNvbnNvbGUuZXJyb3IoY250dXBDb2FjaGVzLmVycm9yKTtcbiAgICAgICAgfSBcbiAgICAgICAgdmFyIGNudHVwTWVtYmVycyA9IG5ldyBDb3VudFVwKCdjb3VudHVwTWVtYmVycycsICQoJyNjb3VudHVwTWVtYmVycycpLmRhdGEoJ3ZhbHVlJyksIG9wdGlvbnMpO1xuICAgICAgICBpZiAoIWNudHVwTWVtYmVycy5lcnJvcil7XG7igIPigIMgICAgICAgICAgY250dXBNZW1iZXJzLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnR1cE1lbWJlcnMuZXJyb3IpO1xuICAgICAgICB9XG4gICAgfSk7XG5cblxuICAgIC8qICBpbml0IGJhY2sgdG8gdG9wIGljb24gKi9cbiAgICB2YXIgc2Nyb2xsUG9zOyBcbiAgICB2YXIgdG9Ub3BWaXNpYmxlPWZhbHNlO1xuICAgIHZhciB0b1RvcCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0b1RvcCcpO1xuXG4gICAgLyogIGluaXQgYmFubmVyIHBhcmFsbGF4IHNjcm9sbCAqLyBcbiAgICB2YXIgYmFubmVyVmVsb2NpdHkgPSAuNDU7XG4gICAgdmFyIGJhbm5lclBvczAgPSAkKCcuYmFubmVyJykuY3NzKCdiYWNrZ3JvdW5kUG9zaXRpb24nKS5zcGxpdChcIiBcIik7XG4gICAgdmFyIGJhbm5lckhlaWdodDAgPSAkKCcuYmFubmVyJykuaGVpZ2h0KCkgKyAkKCcjbmF2LWNhdGVnb3JpZXMnKS5oZWlnaHQoKTtcbiAgICB2YXIgYmFubmVyUG9zWTAgPSBwYXJzZUludChiYW5uZXJQb3MwWzFdKTtcbiAgICB2YXIgYmFubmVyUG9zWTtcbiAgICB2YXIgYmFubmVySW1nVG9wMCA9IDUwO1xuICAgIHZhciBiYW5uZXJJbWdUb3A7XG4gXG4gICAgLy8gc2Nyb2xsIGVsZW1lbnRzXG4gICAgdmFyIHNjcm9sbEZhZGVJbiA9ICQoJy5zY3JvbGwtZmFkZS1pbicpO1xuICAgIHZhciBjYXJvdXNlbCA9ICQoJy5jYXJvdXNlbC1pdGVtJyk7XG4gICAgLy8gdG9kbzogcmVtb3ZlIGNhcm91c2VsIHNjcm9sbCBwYXJhbGxheCB1c2luZyBqc1xuXG4gICAgLyogRXZlcnkgdGltZSB0aGUgd2luZG93IGlzIHNjcm9sbGVkIC4uLiAqL1xuICAgICQod2luZG93KS5zY3JvbGwoIGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgc2Nyb2xsUG9zID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xuXG4gICAgICAgIC8vIHNob3cgYmFjayB0byB0b3BcbiAgICAgICAgaWYgKCBzY3JvbGxQb3MgPj0gNDAwICYmICF0b1RvcFZpc2libGUgKXtcbiAgICAgICAgICAgIHRvVG9wVmlzaWJsZT10cnVlO1xuICAgICAgICAgICAgdG9Ub3Auc3R5bGUudmlzaWJpbGl0eT1cInZpc2libGVcIjtcbiAgICAgICAgICAgIHRvVG9wLnN0eWxlLm9wYWNpdHk9XCIwXCI7XG4gICAgICAgICAgICAkKCcjdG9Ub3AnKS5hbmltYXRlKHsnb3BhY2l0eSc6JzEnfSw3NTApO1xuICAgICAgICB9IFxuICAgICAgICBpZiAoIHNjcm9sbFBvcyA8IDQwMCAmJiB0b1RvcFZpc2libGUgKXtcbiAgICAgICAgICAgIHRvVG9wVmlzaWJsZT1mYWxzZTtcbiAgICAgICAgICAgICQoJyN0b1RvcCcpLmFuaW1hdGUoeydvcGFjaXR5JzonMCd9LDc1MCxmdW5jdGlvbigpeyBcbiAgICAgICAgICAgICAgICB0b1RvcC5zdHlsZS52aXNpYmlsaXR5PVwiaGlkZGVuXCI7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8qIENoZWNrIHRoZSBsb2NhdGlvbiBvZiBlYWNoIGRlc2lyZWQgZWxlbWVudCAqL1xuICAgICAgICBpZiAoICQoc2Nyb2xsRmFkZUluKS5sZW5ndGggPiAwICkge1xuICAgICAgICAgICAgJChzY3JvbGxGYWRlSW4pLmVhY2goIGZ1bmN0aW9uKGkpIHtcbiAgICAgICAgICAgICAgICBpZiAoICQod2luZG93KS5zY3JvbGxUb3AoKSA+ICQodGhpcykucG9zaXRpb24oKS50b3AgLSAkKHdpbmRvdykuaGVpZ2h0KCkvMyApe1xuXG4gICAgICAgICAgICAgICAgICAgICQodGhpcykuYW5pbWF0ZSh7XG4gICAgICAgICAgICAgICAgICAgICAgICBvcGFjaXR5OiBcIjFcIlxuICAgICAgICAgICAgICAgICAgICB9LHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGR1cmF0aW9uOiAxMDAwLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BlY2lhbEVhc2luZzoge30sXG4gICAgICAgICAgICAgICAgICAgICAgICBjb21wbGV0ZTogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJCggdGhpcyApLnJlbW92ZUNsYXNzKCBcInNjcm9sbC1mYWRlLWluXCIgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgXG4gICAgICAgIGlmICggJChjYXJvdXNlbCkubGVuZ3RoID4gMCApIHtcbiAgICAgICAgICAgIGlmIChzY3JvbGxQb3MgPD0gYmFubmVySGVpZ2h0MCkge1xuICAgICAgICAgICAgICAgICQoY2Fyb3VzZWwpLmVhY2goZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGJhbm5lckltZ1RvcCA9IGJhbm5lckltZ1RvcDAgLSAyICogKChiYW5uZXJIZWlnaHQwLXNjcm9sbFBvcykvYmFubmVySGVpZ2h0MC0xKSo1MCAqIGJhbm5lclZlbG9jaXR5O1xuICAgICAgICAgICAgICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCdpbWcnKS5jc3MoJ3RvcCcsIE1hdGgucm91bmQoYmFubmVySW1nVG9wICogMTAwKSAvIDEwMCArICclJyk7IFxuICAgICAgICAgICAgICAgIH0pOyBcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuIFxuICAgIH0pO1xuXG59KTtcblxuXG4kKHdpbmRvdykub24oIFwibG9hZFwiLCBmdW5jdGlvbigpIHtcbiAgICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyKCk7XG4gICAgYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Byb2dyYW1zKCk7XG4gICAgYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Jlc3VsdHMoKTtcbiAgICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXkoKTtcbiAgICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9tb3Jyb3coKTtcbiAgICBhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmcoKTtcbn0pO1xuXG5cbmZ1bmN0aW9uIHNldENvb2tpZShjbmFtZSwgY3ZhbHVlLCBleGRheXMpIHtcbiAgICB2YXIgZCA9IG5ldyBEYXRlKCk7XG4gICAgZC5zZXRUaW1lKGQuZ2V0VGltZSgpICsgKGV4ZGF5cyoyNCo2MCo2MCoxMDAwKSk7XG4gICAgdmFyIGV4cGlyZXMgPSBcImV4cGlyZXM9XCIrIGQudG9VVENTdHJpbmcoKTtcbiAgICBkb2N1bWVudC5jb29raWUgPSBjbmFtZSArIFwiPVwiICsgY3ZhbHVlICsgXCI7XCIgKyBleHBpcmVzICsgXCI7cGF0aD0vXCI7XG59XG5cbiQoJy5zY2hlZHVsZU5vdGljZScpLmVhY2goIGZ1bmN0aW9uKCkge1xuICB2YXIgY25hbWUgPSAkKHRoaXMpLmRhdGEoJ2NuYW1lJyk7XG4gIHZhciBjdmFsdWUgPSAkKHRoaXMpLmRhdGEoJ2N2YWx1ZScpO1xuICAkKHRoaXMpLm9uKCdjbG9zZWQuYnMuYWxlcnQnLCBmdW5jdGlvbiAoKSB7XG4gICAgc2V0Q29va2llIChjbmFtZSwgY3ZhbHVlLCA2MCk7XG4gIH0pXG59KTtcblxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyXG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyKCkge1xuICAgICQoJyNhcGlfbG9hZF9tb2R1bGVfdHlyJykuaHRtbCgnPGRpdiBjbGFzcz1cInJvdyBqdXN0aWZ5LWNvbnRlbnQtYXJvdW5kIHAtM1wiPjxkaXYgY2xhc3M9XCJjb2wgY29sLTggY29sLW1kLTEwXCI+PGRpdiBjbGFzcz1cInR5clwiIGRhdGEtdG9nZ2xlPVwidG9vbHRpcFwiIGRhdGEtcGxhY2VtZW50PVwiYm90dG9tXCIgdGl0bGU9XCJcIiBkYXRhLW9mZnNldD1cIjBcIiBkYXRhLW9yaWdpbmFsLXRpdGxlPVwiS2xpayBvbSBkZSBjbHViY29kZSB0ZSBrb3Bpw6tyZW5cIj48aW1nIGNsYXNzPVwibXgtYXV0byBpbWctZmx1aWRcIiBzcmM9XCIvYXNzZXRzL2ltZy9sb2dvL3R5ci5wbmdcIj48ZGl2IGNsYXNzPVwidGV4dC1jZW50ZXJcIiBzdHlsZT1cIm1hcmdpbi10b3A6LjVlbTsgcGFkZGluZy1ib3R0b206MDtcIj5DbHViY29kZSA8c3BhbiBpZD1cInR5ci1jbHViY29kZVwiIHN0eWxlPVwiZGlzcGxheTppbmxpbmUtYmxvY2s7XCIgY2xhc3M9XCJcIj5IR1MxNVpNPC9zcGFuPjwvZGl2PjwvZGl2PjwvZGl2PjwvZGl2PicpO1xuICAgICQoJy50eXInKS5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgIHRvVHlyKCk7XG4gICAgfSk7XG59XG5mdW5jdGlvbiB0b1R5cigpe1xuICAgIHRvQ2xpcGJvYXJkKFwidHlyLWNsdWJjb2RlXCIpO1xuICAgIGFkZEFuaW1hdGlvbihcInR5ci1jbHViY29kZVwiLFwidGFkYVwiKTtcbiAgICB2YXIgdCA9IHNldFRpbWVvdXQoZnVuY3Rpb24oKXt3aW5kb3cub3BlbignaHR0cDovL3d3dy50eXIubmwnLCdfYmxhbmsnKTt9LDEwMDApO1xufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXlcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b2RheSgpIHtcblxuICAgIHZhciBtb2R1bGUgPSBcImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b2RheVwiO1xuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS90cmFpbmluZy92YW5kYWFnXCI7XG5cbiAgICQoJyMnK21vZHVsZSkuaHRtbChcIjxkaXYgY2xhc3M9XFxcInB0LTMgcGItMyBwbC0zIHByLTBcXFwiPjxoNSBjbGFzcz1cXFwicGItMiBtYi0wXFxcIj5UcmFpbmluZ3N1cmVuIDxzcGFuIGNsYXNzPVxcXCJiYWRnZSBiYWRnZS1wcmltYXJ5IGZvbnQtd2VpZ2h0LWxpZ2h0IGFsaWduLXRleHQtdG9wXFxcIj52YW5kYWFnPC9zcGFuPjwvaDU+PGRpdiBpZD1cXFwiXCIrbW9kdWxlK1wiX2l0ZW1zXFxcIj48L2Rpdj48L2Rpdj5cIik7XG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIHRyYWluaW5nICkge1xuICAgICAgICBpZiAoIHRyYWluaW5nLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCB0cmFpbmluZy5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9IFwiPGRpdiBjbGFzcz1cXFwicm93IG5vLWd1dHRlcnNcXFwiPjxkaXYgY2xhc3M9XFxcImNvbC01IGNvbC1tZC05IGNvbC1sZy02IHRleHQtcmlnaHQgcHQtMSBzbWFsbFxcXCI+XCIrIGl0ZW0udGltZSArIFwiPC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgdCArPSBcIjxkaXYgY2xhc3M9XFxcImNvbC03IGNvbC1tZC0zIGNvbC1sZy02IHBsLTFcXFwiPlwiO1xuICAgICAgICAgICAgICAgICQuZWFjaCggaXRlbS50ZWFtcywgZnVuY3Rpb24oIGksIHRlYW0gKSB7XG4gICAgICAgICAgICAgICAgICAgIHQgKz0gXCI8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2UtcHJpbWFyeSBiYWRnZS10ZWFtIG1sLTFcXFwiPlwiICsgdGVhbS5hYmJyICsgXCI8L3NwYW4+XCI7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgaWYgKCBpdGVtLmNvbW1lbnQgKXtcbiAgICAgICAgICAgICAgICAgICB0ICs9IFwiPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLXNlY29uZGFyeSBtbC0xXFxcIj5cIiArIGl0ZW0uY29tbWVudCArIFwiPC9zcGFuPlwiO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB0ICs9IFwiPC9kaXY+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkVyIGlzIHZhbmRhYWcgZ2VlbiB0cmFpbmluZzwvZGl2PlwiICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9tb3Jyb3dcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvdygpIHtcblxuICAgIHZhciBtb2R1bGUgPSBcImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvd1wiO1xuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS90cmFpbmluZy9tb3JnZW5cIjtcblxuICAgJCgnIycrbW9kdWxlKS5odG1sKFwiPGRpdiBjbGFzcz1cXFwicHQtMyBwYi0zIHBsLTMgcHItMFxcXCI+PGg1IGNsYXNzPVxcXCJwYi0yIG1iLTBcXFwiPlRyYWluaW5nc3VyZW4gPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLW1lZGl1bSBmb250LXdlaWdodC1saWdodCBhbGlnbi10ZXh0LXRvcFxcXCI+bW9yZ2VuPC9zcGFuPjwvaDU+PGRpdiBpZD1cXFwiXCIrbW9kdWxlK1wiX2l0ZW1zXFxcIj48L2Rpdj48L2Rpdj5cIik7XG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIHRyYWluaW5nICkge1xuICAgICAgICBpZiAoIHRyYWluaW5nLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCB0cmFpbmluZy5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9IFwiPGRpdiBjbGFzcz1cXFwicm93IG5vLWd1dHRlcnNcXFwiPjxkaXYgY2xhc3M9XFxcImNvbC01IGNvbC1tZC05IGNvbC1sZy02IHRleHQtcmlnaHQgcHQtMSBzbWFsbFxcXCI+XCIrIGl0ZW0udGltZSArIFwiPC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgdCArPSBcIjxkaXYgY2xhc3M9XFxcImNvbC03IGNvbC1tZC0zIGNvbC1sZy02IHBsLTFcXFwiPlwiO1xuICAgICAgICAgICAgICAgICQuZWFjaCggaXRlbS50ZWFtcywgZnVuY3Rpb24oIGksIHRlYW0gKSB7XG4gICAgICAgICAgICAgICAgICAgIHQgKz0gXCI8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2UtcHJpbWFyeSBiYWRnZS10ZWFtIG1sLTFcXFwiPlwiICsgdGVhbS5hYmJyICsgXCI8L3NwYW4+XCI7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgaWYgKCBpdGVtLmNvbW1lbnQgKXtcbiAgICAgICAgICAgICAgICAgICB0ICs9IFwiPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLXNlY29uZGFyeSBtbC0xXFxcIj5cIiArIGl0ZW0uY29tbWVudCArIFwiPC9zcGFuPlwiO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB0ICs9IFwiPC9kaXY+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkVyIGlzIG1vcmdlbiBnZWVuIHRyYWluaW5nPC9kaXY+XCIgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG59XG5cbi8vIGFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9yZXN1bHRzXG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcmVzdWx0cygpIHtcblxuICAgIHZhciBtb2R1bGUgPSBcImFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9yZXN1bHRzXCI7XG4gICAgdmFyIGhvenRBUEkgID0gXCIvYXBpL2RvY3VtZW50ZW4vd2Vkc3RyaWpkZW4vbGFhdHN0ZS91aXRzbGFnLzVcIjtcblxuICAgICQoJyMnK21vZHVsZSkuaHRtbChcIjxkaXYgY2xhc3M9XFxcInAtM1xcXCI+PGg1IGNsYXNzPVxcXCJwYi0yIG1iLTBcXFwiPlVpdHNsYWdlbjwvaDU+PGRpdiBpZD1cXFwiXCIrbW9kdWxlK1wiX2l0ZW1zXFxcIj48L2Rpdj48L2Rpdj5cIik7IFxuXG4gICAgJC5nZXRKU09OKCBob3p0QVBJLCB7XG4gICAgICAgIGZvcm1hdDogXCJqc29uXCJcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKCBmaWxlcyApIHtcbiAgICAgICAgaWYgKCBmaWxlcy5yZXN1bHQgKXtcbiAgICAgICAgICAgICQuZWFjaCggZmlsZXMuZGF0YSwgZnVuY3Rpb24oIGksIGl0ZW0gKSB7XG4gICAgICAgICAgICAgICAgdmFyIHQgPSBcIjxkaXYgY2xhc3M9XFxcIm1sLTMgc21hbGxcXFwiPjxhIGNsYXNzPVxcXCJ0ZXh0LWRhcmtcXFwiIGhyZWY9XFxcIlwiICsgaXRlbS51cmwgKyBcIlxcXCI+PHNwYW4gY2xhc3M9XFxcInRleHQtbXV0ZWQgbXItMlxcXCI+XCIgKyBpdGVtLmRhdGVzdHIgK1wiPC9zcGFuPlwiKyBpdGVtLnRpdGxlICsgXCI8L2E+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkdlZW4gd2Vkc3RyaWpkIHVpdHNsYWdlbiBnZXZvbmRlbjwvZGl2PlwiICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXNcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9wcm9ncmFtcygpIHtcblxuICAgIHZhciBtb2R1bGUgID0gXCJhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXNcIjtcbiAgICB2YXIgaG96dEFQSSA9IFwiL2FwaS9kb2N1bWVudGVuL3dlZHN0cmlqZGVuL2FhbnN0YWFuZGUvcHJvZ3JhbW1hLzVcIjtcblxuICAgICQoJyMnK21vZHVsZSkuaHRtbChcIjxkaXYgY2xhc3M9XFxcInAtM1xcXCI+PGg1IGNsYXNzPVxcXCJwYi0yIG1iLTBcXFwiPlByb2dyYW1tYSdzPC9oNT48ZGl2IGlkPVxcXCJcIittb2R1bGUrXCJfaXRlbXNcXFwiPjwvZGl2PjwvZGl2PlwiKTsgXG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGZpbGVzICkge1xuICAgICAgICBpZiAoIGZpbGVzLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCBmaWxlcy5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9IFwiPGRpdiBjbGFzcz1cXFwibWwtMyBzbWFsbFxcXCI+PGEgY2xhc3M9XFxcInRleHQtZGFya1xcXCIgaHJlZj1cXFwiXCIgKyBpdGVtLmRvYyArIFwiXFxcIiB0YXJnZXQ9XFxcIl9CbGFua1xcXCI+PHNwYW4gY2xhc3M9XFxcInRleHQtbXV0ZWQgbXItMlxcXCI+XCIgKyBpdGVtLmRhdGVzdHIgK1wiPC9zcGFuPlwiKyBpdGVtLnRpdGxlICsgXCI8L2E+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkdlZW4gcHJvZ3JhbW1hJ3MgZ2V2b25kZW48L2Rpdj5cIiApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICB9XG4gICAgfSk7XG5cbn1cblxuLy8gYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nXG5cbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZygpIHtcblxuICAgICQoJyNhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmcnKS5odG1sKCc8ZGl2IGNsYXNzPVwicC0zXCI+PGg1IGNsYXNzPVwicGItMiBtYi0wXCI+S2FsZW5kZXI8L2g1PjxkaXYgaWQ9XCJhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmdfaXRlbXNcIj48L2Rpdj48L2Rpdj4nKTtcblxuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS9rYWxlbmRlci9hYW5zdGFhbmRlXCI7XG4gICAgdmFyIGl0ZW1zSWQgID0gXCIjYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nX2l0ZW1zXCI7IFxuXG4gICAgJC5nZXRKU09OKCBob3p0QVBJLCB7XG4gICAgICAgIGZvcm1hdDogXCJqc29uXCJcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKCBjYWxlbmRhciApIHtcbiAgICAgICAgaWYgKCBjYWxlbmRhci5yZXN1bHQgKXtcbiAgICAgICAgICAgICQuZWFjaCggY2FsZW5kYXIuZGF0YSwgZnVuY3Rpb24oIGksIGl0ZW0gKSB7XG4gICAgICAgICAgICAgICAgdmFyIHQgPSAnJztcbiAgICAgICAgICAgICAgICB0ICs9IFwiPGRpdiBjbGFzcz1cXFwibWVkaWEgY2FsIGNhbC1saW5rIHB0LTJcXFwiIG9uY2xpY2s9XFxcIndpbmRvdy5sb2NhdGlvbj0nXCIgKyBpdGVtLnVybCArIFwiJztcXFwiPlwiO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgPHNwYW4gY2xhc3M9XCJiYWRnZSBiYWRnZS1kYXJrIG1yLTIgY2FsIGNhbC1zbSAnKyBpdGVtLmNsYXNzIFxuICAgICAgICAgICAgICAgIHQgKz0gJ1wiPicrIGl0ZW0uZGF5ICsnPGJyPicrIGl0ZW0ubW9udGggKyc8L3NwYW4+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgIDxkaXYgY2xhc3M9XCJtZWRpYS1ib2R5IHBiLTIgbWItMCBzbWFsbCBsaC0xMjUgYm9yZGVyLWJvdHRvbSBib3JkZXItZ3JheSAnO1xuICAgICAgICAgICAgICAgIGlmIChpdGVtLmNhbmNlbGxlZCl7IHQgKz0gJ2NhbC1jYW5jZWxsZWQgdGV4dC1kYW5nZXInOyB9IGVsc2UgeyB0ICs9ICd0ZXh0LW11dGVkJzsgfVxuICAgICAgICAgICAgICAgIHQgKz0gJ1wiPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICAgIDxkaXYgY2xhc3M9XCJkLWZsZXgganVzdGlmeS1jb250ZW50LWJldHdlZW4gYWxpZ24taXRlbXMtY2VudGVyIHctMTAwXCI+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgICAgICA8c3Ryb25nIGNsYXNzPVwidGV4dC1ncmF5LWRhcmtcIj4nK2l0ZW0udGl0bGUrJzwvc3Ryb25nPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICAgICAgPGEgaHJlZj1cIiNcIiBjbGFzcz1cImQtbm9uZVwiPkJla2lqazwvYT4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgICA8L2Rpdj4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgICA8c3BhbiBjbGFzcz1cImQtYmxvY2tcIj4nK2l0ZW0uZm9ybWF0dGVkUGVyaW9kKyc8L3NwYW4+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgIDwvZGl2Pic7XG4gICAgICAgICAgICAgICAgdCArPSAnPC9kaXY+JztcbiAgICAgICAgICAgICAgICAkKCB0ICkuYXBwZW5kVG8oIGl0ZW1zSWQgKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgJCgnPHAgY2xhc3M9XCJzbWFsbCBtdC0yIHRleHQtcmlnaHRcIj48YSBocmVmPVwiL2thbGVuZGVyXCI+PGkgY2xhc3M9XCJmYXMgZmEtY2FsZW5kYXItcGx1c1wiPjwvaT4gQWxsZSBldmVudHM8L2E+PC9wPicpLmFwcGVuZFRvKCBpdGVtc0lkICk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxwPkVyIHppam4gZ2VlbiBldmVudHM8L3A+XCIgKS5hcHBlbmRUbyggaXRlbXNJZCApO1xuICAgICAgICB9XG4gICAgfSk7XG5cbn1cbiJdLCJzb3VyY2VSb290IjoiIn0=