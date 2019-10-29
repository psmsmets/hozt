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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2hvenQuc2NzcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvaG96dC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsIndpbmRvdyIsImRpZFNjcm9sbCIsImxhc3RTY3JvbGxUb3AiLCJkZWx0YSIsIm5hdmJhckhlaWdodCIsIm91dGVySGVpZ2h0Iiwic2Nyb2xsIiwiZXZlbnQiLCJzZXRJbnRlcnZhbCIsImhhc1Njcm9sbGVkIiwic3QiLCJzY3JvbGxUb3AiLCJNYXRoIiwiYWJzIiwiYW5pbWF0ZSIsImhlaWdodCIsImRvY3VtZW50IiwiYWRkQW5pbWF0aW9uIiwiaWQiLCJlZmZlY3QiLCJyZW1vdmVDbGFzcyIsImFkZENsYXNzIiwib25lIiwidG9DbGlwYm9hcmQiLCJlbGVtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJ0ZXh0QXJlYSIsImNyZWF0ZUVsZW1lbnQiLCJ2YWx1ZSIsInRleHRDb250ZW50IiwiYm9keSIsImFwcGVuZENoaWxkIiwic2VsZWN0IiwiZXhlY0NvbW1hbmQiLCJyZW1vdmUiLCJnZXRTZXNzaW9uVGltZW91dCIsInNlc3Npb25Nb2RhbCIsInNlc3Npb25XYXJuIiwic2Vzc2lvblRpbWUiLCJzZXNzaW9uTG9nb3V0IiwiZ2V0SlNPTiIsInJlc3VsdCIsImxvZ291dCIsInN1Y2Nlc3MiLCJlbGFwc2VkIiwibW9kYWwiLCJodG1sIiwibG9jYXRpb24iLCJyZXBsYWNlIiwiZGF0YSIsImZhaWwiLCJyZWxvYWQiLCJzZXNzaW9uSGFuZGxlciIsImxlbmd0aCIsImNsaWNrIiwib24iLCJlIiwic2Vzc2lvbkludGVydmFsIiwicmVhZHkiLCJ0b29sdGlwIiwicG9wb3ZlciIsInRvZ2dsZUNsYXNzIiwic2Nyb2xsVG8iLCJvcHRpb25zIiwidXNlRWFzaW5nIiwidXNlR3JvdXBpbmciLCJzZXBhcmF0b3IiLCJkZWNpbWFsIiwiZHVyYXRpb24iLCJjbnR1cFRlYW1zIiwiQ291bnRVcCIsImVycm9yIiwic3RhcnQiLCJjb25zb2xlIiwiY250dXBDb2FjaGVzIiwiY250dXBNZW1iZXJzIiwic2Nyb2xsUG9zIiwidG9Ub3BWaXNpYmxlIiwidG9Ub3AiLCJiYW5uZXJWZWxvY2l0eSIsImJhbm5lclBvczAiLCJjc3MiLCJzcGxpdCIsImJhbm5lckhlaWdodDAiLCJiYW5uZXJQb3NZMCIsInBhcnNlSW50IiwiYmFubmVyUG9zWSIsImJhbm5lckltZ1RvcDAiLCJiYW5uZXJJbWdUb3AiLCJzY3JvbGxGYWRlSW4iLCJjYXJvdXNlbCIsInN0eWxlIiwidmlzaWJpbGl0eSIsIm9wYWNpdHkiLCJlYWNoIiwiaSIsInBvc2l0aW9uIiwidG9wIiwic3BlY2lhbEVhc2luZyIsImNvbXBsZXRlIiwiY2hpbGRyZW4iLCJyb3VuZCIsImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190eXIiLCJhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXMiLCJhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcmVzdWx0cyIsImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b2RheSIsImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvdyIsImFwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZyIsInNldENvb2tpZSIsImNuYW1lIiwiY3ZhbHVlIiwiZXhkYXlzIiwiZCIsIkRhdGUiLCJzZXRUaW1lIiwiZ2V0VGltZSIsImV4cGlyZXMiLCJ0b1VUQ1N0cmluZyIsImNvb2tpZSIsInRvVHlyIiwidCIsInNldFRpbWVvdXQiLCJvcGVuIiwibW9kdWxlIiwiaG96dEFQSSIsImZvcm1hdCIsImRvbmUiLCJ0cmFpbmluZyIsIml0ZW0iLCJ0aW1lIiwidGVhbXMiLCJ0ZWFtIiwiYWJiciIsImNvbW1lbnQiLCJhcHBlbmRUbyIsImZpbGVzIiwidXJsIiwiZGF0ZXN0ciIsInRpdGxlIiwiZG9jIiwiaXRlbXNJZCIsImNhbGVuZGFyIiwiZGF5IiwibW9udGgiLCJjYW5jZWxsZWQiLCJmb3JtYXR0ZWRQZXJpb2QiXSwibWFw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QUksQ0FBQ1EsR0FBNUUsR0FBa0YsT0FBdkY7QUFDQWhCLFNBQUMsSUFBSSxxREFBb0RRLElBQUksU0FBN0Q7QUFDQVIsU0FBQyxJQUFJLE9BQU1RLElBQUksQ0FBQ2MsR0FBWCxHQUFnQixNQUFoQixHQUF3QmQsSUFBSSxDQUFDZSxLQUE3QixHQUFvQyxTQUF6QztBQUNBdkIsU0FBQyxJQUFJLDRFQUFMOztBQUNBLFlBQUlRLElBQUksQ0FBQ2dCLFNBQVQsRUFBbUI7QUFBRXhCLFdBQUMsSUFBSSwyQkFBTDtBQUFtQyxTQUF4RCxNQUE4RDtBQUFFQSxXQUFDLElBQUksWUFBTDtBQUFvQjs7QUFDcEZBLFNBQUMsSUFBSSxJQUFMO0FBQ0FBLFNBQUMsSUFBSSwyRUFBTDtBQUNBQSxTQUFDLElBQUksMENBQXdDUSxJQUFJLENBQUNVLEtBQTdDLEdBQW1ELFdBQXhEO0FBQ0FsQixTQUFDLElBQUksNkNBQUw7QUFDQUEsU0FBQyxJQUFJLFlBQUw7QUFDQUEsU0FBQyxJQUFJLCtCQUE2QlEsSUFBSSxDQUFDaUIsZUFBbEMsR0FBa0QsU0FBdkQ7QUFDQXpCLFNBQUMsSUFBSSxVQUFMO0FBQ0FBLFNBQUMsSUFBSSxRQUFMO0FBQ0F6SCxTQUFDLENBQUV5SCxDQUFGLENBQUQsQ0FBT2MsUUFBUCxDQUFpQk0sT0FBakI7QUFDSCxPQWhCRDtBQWlCQTdJLE9BQUMsQ0FBQywrR0FBRCxDQUFELENBQW1IdUksUUFBbkgsQ0FBNkhNLE9BQTdIO0FBQ0gsS0FuQkQsTUFtQk87QUFDSDdJLE9BQUMsQ0FBRSw0QkFBRixDQUFELENBQWtDdUksUUFBbEMsQ0FBNENNLE9BQTVDO0FBQ0g7QUFDSixHQTFCRDtBQTRCSCxDIiwiZmlsZSI6ImhvenQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW4iLCJyZXF1aXJlKCcuLi9jc3MvaG96dC5zY3NzJyk7XG5cbnJlcXVpcmUoJ2Jvb3RzdHJhcCcpO1xucmVxdWlyZSgnanF1ZXJ5LnNjcm9sbFRvJyk7XG5pbXBvcnQgeyBDb3VudFVwIH0gZnJvbSAnY291bnR1cC5qcyc7XG5cbnZhciAkID0gcmVxdWlyZSgnanF1ZXJ5Jyk7XG53aW5kb3cuJCA9ICQ7XG53aW5kb3cualF1ZXJ5ID0gJDtcblxuXG4vLyBIaWRlIEhlYWRlciBvbiBvbiBzY3JvbGwgZG93blxudmFyIGRpZFNjcm9sbDtcbnZhciBsYXN0U2Nyb2xsVG9wID0gMDtcbnZhciBkZWx0YSA9IDEwO1xudmFyIG5hdmJhckhlaWdodCA9ICQoJyNuYXYtY2F0ZWdvcmllcycpLm91dGVySGVpZ2h0KCk7XG5cbiQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oZXZlbnQpe1xuICAgIGRpZFNjcm9sbCA9IHRydWU7XG59KTtcblxuc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKSB7XG4gICAgaWYgKGRpZFNjcm9sbCkge1xuICAgICAgICBoYXNTY3JvbGxlZCgpO1xuICAgICAgICBkaWRTY3JvbGwgPSBmYWxzZTtcbiAgICB9XG59LCAyNTApO1xuXG5mdW5jdGlvbiBoYXNTY3JvbGxlZCgpIHtcbiAgICB2YXIgc3QgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XG5cbiAgICAvLyBNYWtlIHN1cmUgdGhleSBzY3JvbGwgbW9yZSB0aGFuIGRlbHRhXG4gICAgaWYgKE1hdGguYWJzKGxhc3RTY3JvbGxUb3AgLSBzdCkgPD0gZGVsdGEpe1xuICAgICAgICByZXR1cm47XG4gICAgfVxuICAgIFxuICAgIC8vIElmIHRoZXkgc2Nyb2xsZWQgZG93biBhbmQgYXJlIHBhc3QgdGhlIG5hdmJhciwgYWRkIGNsYXNzIC5uYXYtdXAuXG4gICAgLy8gVGhpcyBpcyBuZWNlc3Nhcnkgc28geW91IG5ldmVyIHNlZSB3aGF0IGlzIFwiYmVoaW5kXCIgdGhlIG5hdmJhci5cbiAgICBpZiAoc3QgPiBsYXN0U2Nyb2xsVG9wICYmIHN0ID4gbmF2YmFySGVpZ2h0KXtcbiAgICAgICAgLy8gU2Nyb2xsIERvd25cbiAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6Jy00MHB4J30sMjUwKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICAvLyBTY3JvbGwgVXBcbiAgICAgICAgaWYoc3QgKyAkKHdpbmRvdykuaGVpZ2h0KCkgPCAkKGRvY3VtZW50KS5oZWlnaHQoKSkge1xuICAgICAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6JzAnfSwyNTApO1xuICAgICAgICB9XG4gICAgfVxuICAgIFxuICAgIGxhc3RTY3JvbGxUb3AgPSBzdDtcbn1cblxuZnVuY3Rpb24gYWRkQW5pbWF0aW9uKGlkLCBlZmZlY3QpIHtcbiAgICAkKCcjJytpZCkucmVtb3ZlQ2xhc3MoKS5hZGRDbGFzcyhlZmZlY3QgKyAnIGFuaW1hdGVkJykub25lKCd3ZWJraXRBbmltYXRpb25FbmQgbW96QW5pbWF0aW9uRW5kIE1TQW5pbWF0aW9uRW5kIG9hbmltYXRpb25lbmQgYW5pbWF0aW9uZW5kJywgZnVuY3Rpb24oKXtcbiAgICAgICAgJCh0aGlzKS5yZW1vdmVDbGFzcygpO1xuICAgIH0pO1xufTtcblxuZnVuY3Rpb24gdG9DbGlwYm9hcmQoaWQpe1xuICAgIHZhciBlbGVtZW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICAgIHZhciB0ZXh0QXJlYSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJ0ZXh0YXJlYVwiKTtcbiAgICB0ZXh0QXJlYS52YWx1ZSA9IGVsZW1lbnQudGV4dENvbnRlbnQ7XG4gICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCh0ZXh0QXJlYSk7XG4gICAgdGV4dEFyZWEuc2VsZWN0KCk7XG4gICAgZG9jdW1lbnQuZXhlY0NvbW1hbmQoXCJDb3B5XCIpO1xuICAgIHRleHRBcmVhLnJlbW92ZSgpO1xufTtcblxuZnVuY3Rpb24gZ2V0U2Vzc2lvblRpbWVvdXQoIHNlc3Npb25Nb2RhbCwgc2Vzc2lvbldhcm4sIHNlc3Npb25UaW1lLCBzZXNzaW9uTG9nb3V0ICkge1xuICAgICQuZ2V0SlNPTihcIi9hcGkvc2Vzc2lvbi90aW1lb3V0XCIsIGZ1bmN0aW9uKHJlc3VsdCkge1xuICAgICAgICB2YXIgbG9nb3V0ID0gdHJ1ZTtcbiAgICAgICAgaWYgKHJlc3VsdC5zdWNjZXNzKSB7IFxuICAgICAgICAgICAgaWYgKHJlc3VsdC5lbGFwc2VkIDwgc2Vzc2lvbldhcm4pIHtcbiAgICAgICAgICAgICAgICBsb2dvdXQgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAkKHNlc3Npb25Nb2RhbCkubW9kYWwoJ2hpZGUnKTtcbiAgICAgICAgICAgIH0gZWxzZSBpZiAocmVzdWx0LmVsYXBzZWQgPCBzZXNzaW9uVGltZSkge1xuICAgICAgICAgICAgICAgICQoJyNzZXNzaW9uTW9kYWxSZW1haW5pbmcnKS5odG1sKHNlc3Npb25UaW1lLWVsYXBzZWQpO1xuICAgICAgICAgICAgICAgICQoc2Vzc2lvbk1vZGFsKS5tb2RhbCgnc2hvdycpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIGlmIChsb2dvdXQpIHsgXG4gICAgICAgICAgICBkb2N1bWVudC5sb2NhdGlvbi5yZXBsYWNlKHNlc3Npb25Mb2dvdXQuZGF0YSgnbG9nb3V0JykpO1xuICAgICAgICB9XG4gICAgfSkuZmFpbChmdW5jdGlvbigpIHtcbiAgICAgICAgZG9jdW1lbnQubG9jYXRpb24ucmVsb2FkKHRydWUpOyAvLyBmb3JjZSB0byBnZXQgdGhlIGxvZ2luIHdpbmRvd1xuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBzZXNzaW9uSGFuZGxlciggc2Vzc2lvbk1vZGFsICl7XG5cbiAgICBpZiAoJChzZXNzaW9uTW9kYWwpLmxlbmd0aCA9PSAwICkgcmV0dXJuO1xuXG4gICAgdmFyIHNlc3Npb25UaW1lID0gMTIwMDtcbiAgICB2YXIgc2Vzc2lvbldhcm4gPSA5MDA7XG4gICAgdmFyIHNlc3Npb25Mb2dvdXQgPSAkKCcjc2Vzc2lvbk1vZGFsIFtkYXRhLWxvZ291dF0nKTtcblxuICAgIGdldFNlc3Npb25UaW1lb3V0KCBzZXNzaW9uTW9kYWwsIHNlc3Npb25XYXJuLCBzZXNzaW9uVGltZSwgc2Vzc2lvbkxvZ291dCApO1xuXG4gICAgJChzZXNzaW9uTG9nb3V0KS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgZG9jdW1lbnQubG9jYXRpb24ucmVwbGFjZShzZXNzaW9uTG9nb3V0LmRhdGEoJ2xvZ291dCcpKTtcbiAgICB9KTtcblxuICAgICQoc2Vzc2lvbk1vZGFsKS5vbignaGlkZS5icy5tb2RhbCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICQuZ2V0SlNPTihcIi9hcGkvc2Vzc2lvbi9rZWVwLWFsaXZlXCIpO1xuICAgIH0pO1xuXG4gICAgdmFyIHNlc3Npb25JbnRlcnZhbCA9IHNldEludGVydmFsKGZ1bmN0aW9uKCkge1xuICAgICAgICBnZXRTZXNzaW9uVGltZW91dCggc2Vzc2lvbk1vZGFsLCBzZXNzaW9uV2Fybiwgc2Vzc2lvblRpbWUsIHNlc3Npb25Mb2dvdXQgKTtcbiAgICB9LCAxNTAwMCk7XG59XG5cbnNlc3Npb25IYW5kbGVyKCQoJyNzZXNzaW9uTW9kYWwnKSk7XG5cblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcblxuICAgICQoZnVuY3Rpb24gKCkge1xuICAgICAgICAkKCdbZGF0YS10b2dnbGU9XCJ0b29sdGlwXCJdJykudG9vbHRpcCgpO1xuICAgIH0pXG5cbiAgICAkKGZ1bmN0aW9uKCkge1xuICAgICAgICQoJ1tkYXRhLXRvZ2dsZT1cInBvcG92ZXJcIl0nKS5wb3BvdmVyKCk7XG4gICAgfSlcblxuICAgICQoZnVuY3Rpb24gKCkge1xuICAgICAgICAndXNlIHN0cmljdCdcbiAgICAgICAgJCgnW2RhdGEtdG9nZ2xlPVwib2ZmY2FudmFzXCJdJykub24oJ2NsaWNrJywgZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICQoJy5vZmZjYW52YXMtY29sbGFwc2UnKS50b2dnbGVDbGFzcygnb3BlbicpXG4gICAgICAgIH0pXG4gICAgfSk7XG5cbiAgICAkKCcjdG9Ub3AnKS5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgICAgJC5zY3JvbGxUbygwLCA3MDApOyBcbiAgICB9KVxuXG4gICAgJCgnI2Rpc2NvdmVyTW9kYWwnKS5vbignc2hvd24uYnMubW9kYWwnLCBmdW5jdGlvbihlKXtcbiAgICAgICAgdmFyIG9wdGlvbnMgPSB7XG4gICAg4oCD4oCDICAgICAgdXNlRWFzaW5nOiB0cnVlLCBcbiAgICAgIOKAg+KAgyAgICB1c2VHcm91cGluZzogdHJ1ZSwgXG4gICAgICAgIOKAg+KAgyAgc2VwYXJhdG9yOiAnLCcsIFxuICAgICAg4oCD4oCDICAgIGRlY2ltYWw6ICcuJyxcbiAgICAgICAgICAgIGR1cmF0aW9uOiAzLFxuICAgICAgICB9O1xuICAgICAgICB2YXIgY250dXBUZWFtcyA9IG5ldyBDb3VudFVwKCdjb3VudHVwVGVhbXMnLCAkKCcjY291bnR1cFRlYW1zJykuZGF0YSgndmFsdWUnKSwgb3B0aW9ucyk7XG4gICAgICAgIGlmICghY250dXBUZWFtcy5lcnJvcil7XG4gICAgICAgICAgICBjbnR1cFRlYW1zLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnR1cFRlYW1zLmVycm9yKTtcbiAgICAgICAgfVxuICAgICAgICB2YXIgY250dXBDb2FjaGVzID0gbmV3IENvdW50VXAoJ2NvdW50dXBDb2FjaGVzJywgJCgnI2NvdW50dXBDb2FjaGVzJykuZGF0YSgndmFsdWUnKSxvcHRpb25zKTtcbiAgICAgICAgaWYgKCFjbnR1cENvYWNoZXMuZXJyb3Ipe1xu4oCD4oCDICAgICAgICAgIGNudHVwQ29hY2hlcy5zdGFydCgpO1xuICAgICAgICB9IGVsc2Uge1xu4oCD4oCDICAgICAgICAgIGNvbnNvbGUuZXJyb3IoY250dXBDb2FjaGVzLmVycm9yKTtcbiAgICAgICAgfSBcbiAgICAgICAgdmFyIGNudHVwTWVtYmVycyA9IG5ldyBDb3VudFVwKCdjb3VudHVwTWVtYmVycycsICQoJyNjb3VudHVwTWVtYmVycycpLmRhdGEoJ3ZhbHVlJyksIG9wdGlvbnMpO1xuICAgICAgICBpZiAoIWNudHVwTWVtYmVycy5lcnJvcil7XG7igIPigIMgICAgICAgICAgY250dXBNZW1iZXJzLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnR1cE1lbWJlcnMuZXJyb3IpO1xuICAgICAgICB9XG4gICAgfSk7XG5cblxuICAgIC8qICBpbml0IGJhY2sgdG8gdG9wIGljb24gKi9cbiAgICB2YXIgc2Nyb2xsUG9zOyBcbiAgICB2YXIgdG9Ub3BWaXNpYmxlPWZhbHNlO1xuICAgIHZhciB0b1RvcCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCd0b1RvcCcpO1xuXG4gICAgLyogIGluaXQgYmFubmVyIHBhcmFsbGF4IHNjcm9sbCAqLyBcbiAgICB2YXIgYmFubmVyVmVsb2NpdHkgPSAuNDU7XG4gICAgdmFyIGJhbm5lclBvczAgPSAkKCcuYmFubmVyJykuY3NzKCdiYWNrZ3JvdW5kUG9zaXRpb24nKS5zcGxpdChcIiBcIik7XG4gICAgdmFyIGJhbm5lckhlaWdodDAgPSAkKCcuYmFubmVyJykuaGVpZ2h0KCkgKyAkKCcjbmF2LWNhdGVnb3JpZXMnKS5oZWlnaHQoKTtcbiAgICB2YXIgYmFubmVyUG9zWTAgPSBwYXJzZUludChiYW5uZXJQb3MwWzFdKTtcbiAgICB2YXIgYmFubmVyUG9zWTtcbiAgICB2YXIgYmFubmVySW1nVG9wMCA9IDUwO1xuICAgIHZhciBiYW5uZXJJbWdUb3A7XG4gXG4gICAgLy8gc2Nyb2xsIGVsZW1lbnRzXG4gICAgdmFyIHNjcm9sbEZhZGVJbiA9ICQoJy5zY3JvbGwtZmFkZS1pbicpO1xuICAgIHZhciBjYXJvdXNlbCA9ICQoJy5jYXJvdXNlbC1pdGVtJyk7XG4gICAgLy8gdG9kbzogcmVtb3ZlIGNhcm91c2VsIHNjcm9sbCBwYXJhbGxheCB1c2luZyBqc1xuXG4gICAgLyogRXZlcnkgdGltZSB0aGUgd2luZG93IGlzIHNjcm9sbGVkIC4uLiAqL1xuICAgICQod2luZG93KS5zY3JvbGwoIGZ1bmN0aW9uKCl7XG5cbiAgICAgICAgc2Nyb2xsUG9zID0gJCh3aW5kb3cpLnNjcm9sbFRvcCgpO1xuXG4gICAgICAgIC8vIHNob3cgYmFjayB0byB0b3BcbiAgICAgICAgaWYgKCBzY3JvbGxQb3MgPj0gNDAwICYmICF0b1RvcFZpc2libGUgKXtcbiAgICAgICAgICAgIHRvVG9wVmlzaWJsZT10cnVlO1xuICAgICAgICAgICAgdG9Ub3Auc3R5bGUudmlzaWJpbGl0eT1cInZpc2libGVcIjtcbiAgICAgICAgICAgIHRvVG9wLnN0eWxlLm9wYWNpdHk9XCIwXCI7XG4gICAgICAgICAgICAkKCcjdG9Ub3AnKS5hbmltYXRlKHsnb3BhY2l0eSc6JzEnfSw3NTApO1xuICAgICAgICB9IFxuICAgICAgICBpZiAoIHNjcm9sbFBvcyA8IDQwMCAmJiB0b1RvcFZpc2libGUgKXtcbiAgICAgICAgICAgIHRvVG9wVmlzaWJsZT1mYWxzZTtcbiAgICAgICAgICAgICQoJyN0b1RvcCcpLmFuaW1hdGUoeydvcGFjaXR5JzonMCd9LDc1MCxmdW5jdGlvbigpeyBcbiAgICAgICAgICAgICAgICB0b1RvcC5zdHlsZS52aXNpYmlsaXR5PVwiaGlkZGVuXCI7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8qIENoZWNrIHRoZSBsb2NhdGlvbiBvZiBlYWNoIGRlc2lyZWQgZWxlbWVudCAqL1xuICAgICAgICBpZiAoICQoc2Nyb2xsRmFkZUluKS5sZW5ndGggPiAwICkge1xuICAgICAgICAgICAgJChzY3JvbGxGYWRlSW4pLmVhY2goIGZ1bmN0aW9uKGkpIHtcbiAgICAgICAgICAgICAgICBpZiAoICQod2luZG93KS5zY3JvbGxUb3AoKSA+ICQodGhpcykucG9zaXRpb24oKS50b3AgLSAkKHdpbmRvdykuaGVpZ2h0KCkvMyApe1xuXG4gICAgICAgICAgICAgICAgICAgICQodGhpcykuYW5pbWF0ZSh7XG4gICAgICAgICAgICAgICAgICAgICAgICBvcGFjaXR5OiBcIjFcIlxuICAgICAgICAgICAgICAgICAgICB9LHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGR1cmF0aW9uOiAxMDAwLFxuICAgICAgICAgICAgICAgICAgICAgICAgc3BlY2lhbEVhc2luZzoge30sXG4gICAgICAgICAgICAgICAgICAgICAgICBjb21wbGV0ZTogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJCggdGhpcyApLnJlbW92ZUNsYXNzKCBcInNjcm9sbC1mYWRlLWluXCIgKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgXG4gICAgICAgIGlmICggJChjYXJvdXNlbCkubGVuZ3RoID4gMCApIHtcbiAgICAgICAgICAgIGlmIChzY3JvbGxQb3MgPD0gYmFubmVySGVpZ2h0MCkge1xuICAgICAgICAgICAgICAgICQoY2Fyb3VzZWwpLmVhY2goZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGJhbm5lckltZ1RvcCA9IGJhbm5lckltZ1RvcDAgLSAyICogKChiYW5uZXJIZWlnaHQwLXNjcm9sbFBvcykvYmFubmVySGVpZ2h0MC0xKSo1MCAqIGJhbm5lclZlbG9jaXR5O1xuICAgICAgICAgICAgICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCdpbWcnKS5jc3MoJ3RvcCcsIE1hdGgucm91bmQoYmFubmVySW1nVG9wICogMTAwKSAvIDEwMCArICclJyk7IFxuICAgICAgICAgICAgICAgIH0pOyBcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuIFxuICAgIH0pO1xuXG59KTtcblxuXG4kKHdpbmRvdykub24oIFwibG9hZFwiLCBmdW5jdGlvbigpIHtcbiAgICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyKCk7XG4gICAgYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Byb2dyYW1zKCk7XG4gICAgYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Jlc3VsdHMoKTtcbiAgICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXkoKTtcbiAgICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9tb3Jyb3coKTtcbiAgICBhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmcoKTtcbn0pO1xuXG5cbmZ1bmN0aW9uIHNldENvb2tpZShjbmFtZSwgY3ZhbHVlLCBleGRheXMpIHtcbiAgICB2YXIgZCA9IG5ldyBEYXRlKCk7XG4gICAgZC5zZXRUaW1lKGQuZ2V0VGltZSgpICsgKGV4ZGF5cyoyNCo2MCo2MCoxMDAwKSk7XG4gICAgdmFyIGV4cGlyZXMgPSBcImV4cGlyZXM9XCIrIGQudG9VVENTdHJpbmcoKTtcbiAgICBkb2N1bWVudC5jb29raWUgPSBjbmFtZSArIFwiPVwiICsgY3ZhbHVlICsgXCI7XCIgKyBleHBpcmVzICsgXCI7cGF0aD0vXCI7XG59XG5cbiQoJy5zY2hlZHVsZU5vdGljZScpLmVhY2goIGZ1bmN0aW9uKCkge1xuICB2YXIgY25hbWUgPSAkKHRoaXMpLmRhdGEoJ2NuYW1lJyk7XG4gIHZhciBjdmFsdWUgPSAkKHRoaXMpLmRhdGEoJ2N2YWx1ZScpO1xuICAkKHRoaXMpLm9uKCdjbG9zZWQuYnMuYWxlcnQnLCBmdW5jdGlvbiAoKSB7XG4gICAgc2V0Q29va2llIChjbmFtZSwgY3ZhbHVlLCA2MCk7XG4gIH0pXG59KTtcblxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyXG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyKCkge1xuICAgICQoJyNhcGlfbG9hZF9tb2R1bGVfdHlyJykuaHRtbCgnPGRpdiBjbGFzcz1cInJvdyBqdXN0aWZ5LWNvbnRlbnQtYXJvdW5kIHAtM1wiPjxkaXYgY2xhc3M9XCJjb2wgY29sLTggY29sLW1kLTEwXCI+PGRpdiBjbGFzcz1cInR5clwiIGRhdGEtdG9nZ2xlPVwidG9vbHRpcFwiIGRhdGEtcGxhY2VtZW50PVwiYm90dG9tXCIgdGl0bGU9XCJcIiBkYXRhLW9mZnNldD1cIjBcIiBkYXRhLW9yaWdpbmFsLXRpdGxlPVwiS2xpayBvbSBkZSBjbHViY29kZSB0ZSBrb3Bpw6tyZW5cIj48aW1nIGNsYXNzPVwibXgtYXV0byBpbWctZmx1aWRcIiBzcmM9XCIvYXNzZXRzL2ltZy9sb2dvL3R5ci5wbmdcIj48ZGl2IGNsYXNzPVwidGV4dC1jZW50ZXJcIiBzdHlsZT1cIm1hcmdpbi10b3A6LjVlbTsgcGFkZGluZy1ib3R0b206MDtcIj5DbHViY29kZSA8c3BhbiBpZD1cInR5ci1jbHViY29kZVwiIHN0eWxlPVwiZGlzcGxheTppbmxpbmUtYmxvY2s7XCIgY2xhc3M9XCJcIj5IR1MxNVpNPC9zcGFuPjwvZGl2PjwvZGl2PjwvZGl2PjwvZGl2PicpO1xuICAgICQoJy50eXInKS5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgIHRvVHlyKCk7XG4gICAgfSk7XG59XG5mdW5jdGlvbiB0b1R5cigpe1xuICAgIHRvQ2xpcGJvYXJkKFwidHlyLWNsdWJjb2RlXCIpO1xuICAgIGFkZEFuaW1hdGlvbihcInR5ci1jbHViY29kZVwiLFwidGFkYVwiKTtcbiAgICB2YXIgdCA9IHNldFRpbWVvdXQoZnVuY3Rpb24oKXt3aW5kb3cub3BlbignaHR0cDovL3d3dy50eXIubmwnLCdfYmxhbmsnKTt9LDEwMDApO1xufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXlcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b2RheSgpIHtcblxuICAgIHZhciBtb2R1bGUgPSBcImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b2RheVwiO1xuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS90cmFpbmluZy92YW5kYWFnXCI7XG5cbiAgICQoJyMnK21vZHVsZSkuaHRtbChcIjxkaXYgY2xhc3M9XFxcInB0LTMgcGItMyBwbC0zIHByLTBcXFwiPjxoNSBjbGFzcz1cXFwicGItMiBtYi0wXFxcIj5UcmFpbmluZ3N1cmVuIDxzcGFuIGNsYXNzPVxcXCJiYWRnZSBiYWRnZS1wcmltYXJ5IGZvbnQtd2VpZ2h0LWxpZ2h0IGFsaWduLXRleHQtdG9wXFxcIj52YW5kYWFnPC9zcGFuPjwvaDU+PGRpdiBpZD1cXFwiXCIrbW9kdWxlK1wiX2l0ZW1zXFxcIj48L2Rpdj48L2Rpdj5cIik7XG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIHRyYWluaW5nICkge1xuICAgICAgICBpZiAoIHRyYWluaW5nLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCB0cmFpbmluZy5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9IFwiPGRpdiBjbGFzcz1cXFwicm93IG5vLWd1dHRlcnNcXFwiPjxkaXYgY2xhc3M9XFxcImNvbC01IGNvbC1tZC05IGNvbC1sZy02IHRleHQtcmlnaHQgcHQtMSBzbWFsbFxcXCI+XCIrIGl0ZW0udGltZSArIFwiPC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgdCArPSBcIjxkaXYgY2xhc3M9XFxcImNvbC03IGNvbC1tZC0zIGNvbC1sZy02IHBsLTFcXFwiPlwiO1xuICAgICAgICAgICAgICAgICQuZWFjaCggaXRlbS50ZWFtcywgZnVuY3Rpb24oIGksIHRlYW0gKSB7XG4gICAgICAgICAgICAgICAgICAgIHQgKz0gXCI8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2UtcHJpbWFyeSBiYWRnZS10ZWFtIG1sLTFcXFwiPlwiICsgdGVhbS5hYmJyICsgXCI8L3NwYW4+XCI7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgaWYgKCBpdGVtLmNvbW1lbnQgKXtcbiAgICAgICAgICAgICAgICAgICB0ICs9IFwiPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLXNlY29uZGFyeSBtbC0xXFxcIj5cIiArIGl0ZW0uY29tbWVudCArIFwiPC9zcGFuPlwiO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB0ICs9IFwiPC9kaXY+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkVyIGlzIHZhbmRhYWcgZ2VlbiB0cmFpbmluZzwvZGl2PlwiICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9tb3Jyb3dcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvdygpIHtcblxuICAgIHZhciBtb2R1bGUgPSBcImFwaV9sb2FkX21vZHVsZV90cmFpbmluZ190b21vcnJvd1wiO1xuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS90cmFpbmluZy9tb3JnZW5cIjtcblxuICAgJCgnIycrbW9kdWxlKS5odG1sKFwiPGRpdiBjbGFzcz1cXFwicHQtMyBwYi0zIHBsLTMgcHItMFxcXCI+PGg1IGNsYXNzPVxcXCJwYi0yIG1iLTBcXFwiPlRyYWluaW5nc3VyZW4gPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLW1lZGl1bSBmb250LXdlaWdodC1saWdodCBhbGlnbi10ZXh0LXRvcFxcXCI+bW9yZ2VuPC9zcGFuPjwvaDU+PGRpdiBpZD1cXFwiXCIrbW9kdWxlK1wiX2l0ZW1zXFxcIj48L2Rpdj48L2Rpdj5cIik7XG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIHRyYWluaW5nICkge1xuICAgICAgICBpZiAoIHRyYWluaW5nLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCB0cmFpbmluZy5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9IFwiPGRpdiBjbGFzcz1cXFwicm93IG5vLWd1dHRlcnNcXFwiPjxkaXYgY2xhc3M9XFxcImNvbC01IGNvbC1tZC05IGNvbC1sZy02IHRleHQtcmlnaHQgcHQtMSBzbWFsbFxcXCI+XCIrIGl0ZW0udGltZSArIFwiPC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgdCArPSBcIjxkaXYgY2xhc3M9XFxcImNvbC03IGNvbC1tZC0zIGNvbC1sZy02IHBsLTFcXFwiPlwiO1xuICAgICAgICAgICAgICAgICQuZWFjaCggaXRlbS50ZWFtcywgZnVuY3Rpb24oIGksIHRlYW0gKSB7XG4gICAgICAgICAgICAgICAgICAgIHQgKz0gXCI8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2UtcHJpbWFyeSBiYWRnZS10ZWFtIG1sLTFcXFwiPlwiICsgdGVhbS5hYmJyICsgXCI8L3NwYW4+XCI7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgaWYgKCBpdGVtLmNvbW1lbnQgKXtcbiAgICAgICAgICAgICAgICAgICB0ICs9IFwiPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLXNlY29uZGFyeSBtbC0xXFxcIj5cIiArIGl0ZW0uY29tbWVudCArIFwiPC9zcGFuPlwiO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB0ICs9IFwiPC9kaXY+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkVyIGlzIG1vcmdlbiBnZWVuIHRyYWluaW5nPC9kaXY+XCIgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG59XG5cbi8vIGFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9yZXN1bHRzXG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcmVzdWx0cygpIHtcblxuICAgIHZhciBtb2R1bGUgPSBcImFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9yZXN1bHRzXCI7XG4gICAgdmFyIGhvenRBUEkgID0gXCIvYXBpL2RvY3VtZW50ZW4vd2Vkc3RyaWpkZW4vbGFhdHN0ZS91aXRzbGFnLzVcIjtcblxuICAgICQoJyMnK21vZHVsZSkuaHRtbChcIjxkaXYgY2xhc3M9XFxcInAtM1xcXCI+PGg1IGNsYXNzPVxcXCJwYi0yIG1iLTBcXFwiPlVpdHNsYWdlbjwvaDU+PGRpdiBpZD1cXFwiXCIrbW9kdWxlK1wiX2l0ZW1zXFxcIj48L2Rpdj48L2Rpdj5cIik7IFxuXG4gICAgJC5nZXRKU09OKCBob3p0QVBJLCB7XG4gICAgICAgIGZvcm1hdDogXCJqc29uXCJcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKCBmaWxlcyApIHtcbiAgICAgICAgaWYgKCBmaWxlcy5yZXN1bHQgKXtcbiAgICAgICAgICAgICQuZWFjaCggZmlsZXMuZGF0YSwgZnVuY3Rpb24oIGksIGl0ZW0gKSB7XG4gICAgICAgICAgICAgICAgdmFyIHQgPSBcIjxkaXYgY2xhc3M9XFxcIm1sLTMgc21hbGxcXFwiPjxhIGNsYXNzPVxcXCJ0ZXh0LWRhcmtcXFwiIGhyZWY9XFxcIlwiICsgaXRlbS51cmwgKyBcIlxcXCI+PHNwYW4gY2xhc3M9XFxcInRleHQtbXV0ZWQgbXItMlxcXCI+XCIgKyBpdGVtLmRhdGVzdHIgK1wiPC9zcGFuPlwiKyBpdGVtLnRpdGxlICsgXCI8L2E+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkdlZW4gd2Vkc3RyaWpkIHVpdHNsYWdlbiBnZXZvbmRlbjwvZGl2PlwiICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXNcbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9wcm9ncmFtcygpIHtcblxuICAgIHZhciBtb2R1bGUgID0gXCJhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXNcIjtcbiAgICB2YXIgaG96dEFQSSA9IFwiL2FwaS9kb2N1bWVudGVuL3dlZHN0cmlqZGVuL2FhbnN0YWFuZGUvcHJvZ3JhbW1hLzVcIjtcblxuICAgICQoJyMnK21vZHVsZSkuaHRtbChcIjxkaXYgY2xhc3M9XFxcInAtM1xcXCI+PGg1IGNsYXNzPVxcXCJwYi0yIG1iLTBcXFwiPlByb2dyYW1tYSdzPC9oNT48ZGl2IGlkPVxcXCJcIittb2R1bGUrXCJfaXRlbXNcXFwiPjwvZGl2PjwvZGl2PlwiKTsgXG5cbiAgICAkLmdldEpTT04oIGhvenRBUEksIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIlxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGZpbGVzICkge1xuICAgICAgICBpZiAoIGZpbGVzLnJlc3VsdCApe1xuICAgICAgICAgICAgJC5lYWNoKCBmaWxlcy5kYXRhLCBmdW5jdGlvbiggaSwgaXRlbSApIHtcbiAgICAgICAgICAgICAgICB2YXIgdCA9IFwiPGRpdiBjbGFzcz1cXFwibWwtMyBzbWFsbFxcXCI+PGEgY2xhc3M9XFxcInRleHQtZGFya1xcXCIgaHJlZj1cXFwiXCIgKyBpdGVtLmRvYyArIFwiXFxcIiB0YXJnZXQ9XFxcIl9CbGFua1xcXCI+PHNwYW4gY2xhc3M9XFxcInRleHQtbXV0ZWQgbXItMlxcXCI+XCIgKyBpdGVtLmRhdGVzdHIgK1wiPC9zcGFuPlwiKyBpdGVtLnRpdGxlICsgXCI8L2E+PC9kaXY+XCI7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxkaXYgY2xhc3M9XFxcInNtYWxsIG1sLTNcXFwiPkdlZW4gcHJvZ3JhbW1hJ3MgZ2V2b25kZW48L2Rpdj5cIiApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICB9XG4gICAgfSk7XG5cbn1cblxuLy8gYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nXG5cbmZ1bmN0aW9uIGFwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZygpIHtcblxuICAgICQoJyNhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmcnKS5odG1sKCc8ZGl2IGNsYXNzPVwicC0zXCI+PGg1IGNsYXNzPVwicGItMiBtYi0wXCI+S2FsZW5kZXI8L2g1PjxkaXYgaWQ9XCJhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmdfaXRlbXNcIj48L2Rpdj48L2Rpdj4nKTtcblxuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS9rYWxlbmRlci9hYW5zdGFhbmRlXCI7XG4gICAgdmFyIGl0ZW1zSWQgID0gXCIjYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nX2l0ZW1zXCI7IFxuXG4gICAgJC5nZXRKU09OKCBob3p0QVBJLCB7XG4gICAgICAgIGZvcm1hdDogXCJqc29uXCJcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKCBjYWxlbmRhciApIHtcbiAgICAgICAgaWYgKCBjYWxlbmRhci5yZXN1bHQgKXtcbiAgICAgICAgICAgICQuZWFjaCggY2FsZW5kYXIuZGF0YSwgZnVuY3Rpb24oIGksIGl0ZW0gKSB7XG4gICAgICAgICAgICAgICAgdmFyIHQgPSAnJztcbiAgICAgICAgICAgICAgICB0ICs9IFwiPGRpdiBjbGFzcz1cXFwibWVkaWEgY2FsIGNhbC1saW5rIHB0LTJcXFwiIG9uY2xpY2s9XFxcIndpbmRvdy5sb2NhdGlvbj0nXCIgKyBpdGVtLnVybCArIFwiJztcXFwiPlwiO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgPHNwYW4gY2xhc3M9XCJiYWRnZSBiYWRnZS1kYXJrIG1yLTIgY2FsIGNhbC1zbSAnKyBpdGVtLmNsYXNzIFxuICAgICAgICAgICAgICAgIHQgKz0gJ1wiPicrIGl0ZW0uZGF5ICsnPGJyPicrIGl0ZW0ubW9udGggKyc8L3NwYW4+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgIDxkaXYgY2xhc3M9XCJtZWRpYS1ib2R5IHBiLTIgbWItMCBzbWFsbCBsaC0xMjUgYm9yZGVyLWJvdHRvbSBib3JkZXItZ3JheSAnO1xuICAgICAgICAgICAgICAgIGlmIChpdGVtLmNhbmNlbGxlZCl7IHQgKz0gJ2NhbC1jYW5jZWxsZWQgdGV4dC1kYW5nZXInOyB9IGVsc2UgeyB0ICs9ICd0ZXh0LW11dGVkJzsgfVxuICAgICAgICAgICAgICAgIHQgKz0gJ1wiPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICAgIDxkaXYgY2xhc3M9XCJkLWZsZXgganVzdGlmeS1jb250ZW50LWJldHdlZW4gYWxpZ24taXRlbXMtY2VudGVyIHctMTAwXCI+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgICAgICA8c3Ryb25nIGNsYXNzPVwidGV4dC1ncmF5LWRhcmtcIj4nK2l0ZW0udGl0bGUrJzwvc3Ryb25nPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICAgICAgPGEgaHJlZj1cIiNcIiBjbGFzcz1cImQtbm9uZVwiPkJla2lqazwvYT4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgICA8L2Rpdj4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgICA8c3BhbiBjbGFzcz1cImQtYmxvY2tcIj4nK2l0ZW0uZm9ybWF0dGVkUGVyaW9kKyc8L3NwYW4+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgIDwvZGl2Pic7XG4gICAgICAgICAgICAgICAgdCArPSAnPC9kaXY+JztcbiAgICAgICAgICAgICAgICAkKCB0ICkuYXBwZW5kVG8oIGl0ZW1zSWQgKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgJCgnPHAgY2xhc3M9XCJzbWFsbCBtdC0yIHRleHQtcmlnaHRcIj48YSBocmVmPVwiL2thbGVuZGVyXCI+PGkgY2xhc3M9XCJmYXMgZmEtY2FsZW5kYXItcGx1c1wiPjwvaT4gQWxsZSBldmVudHM8L2E+PC9wPicpLmFwcGVuZFRvKCBpdGVtc0lkICk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKCBcIjxwPkVyIHppam4gZ2VlbiBldmVudHM8L3A+XCIgKS5hcHBlbmRUbyggaXRlbXNJZCApO1xuICAgICAgICB9XG4gICAgfSk7XG5cbn1cbiJdLCJzb3VyY2VSb290IjoiIn0=