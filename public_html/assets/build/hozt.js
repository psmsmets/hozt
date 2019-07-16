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
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var countup_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! countup.js */ "./node_modules/countup.js/dist/countUp.min.js");
__webpack_require__(/*! ../css/hozt.scss */ "./assets/css/hozt.scss");

__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

__webpack_require__(/*! jquery.scrollTo */ "./node_modules/jquery.scrollTo/jquery.scrollTo.js");

 // Hide Header on on scroll down

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
  $('#navbarHeader').on('shown.bs.collapse', function (e) {
    var options = {
      useEasing: true,
      useGrouping: true,
      separator: ',',
      decimal: '.',
      duration: 3
    };
    var cntGroup = new countup_js__WEBPACK_IMPORTED_MODULE_0__["CountUp"]('count-groepen', $(document.body).data('nofteams'), options);

    if (!cntGroup.error) {
      cntGroup.start();
    } else {
      console.error(cntGroup.error);
    }

    var cntCoach = new countup_js__WEBPACK_IMPORTED_MODULE_0__["CountUp"]('count-trainers', $(document.body).data('nofcoaches'), options);

    if (!cntCoach.error) {
      cntCoach.start();
    } else {
      console.error(cntCoach.error);
    }

    var cntSwimmer = new countup_js__WEBPACK_IMPORTED_MODULE_0__["CountUp"]('count-zwemmers', $(document.body).data('nofswimmers'), options);

    if (!cntSwimmer.error) {
      cntSwimmer.start();
    } else {
      console.error(cntSwimmer.error);
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
        $(this).children('img').css('top', bannerImgTop + '%');
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
    tagmode: "any",
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
    tagmode: "any",
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
    tagmode: "any",
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
  var hoztAPI = "/api/documenten/wedstrijden/aanstaande/programma";
  $('#' + module).html("<div class=\"p-3\"><h5 class=\"pb-2 mb-0\">Programma's</h5><div id=\"" + module + "_items\"></div></div>");
  $.getJSON(hoztAPI, {
    tagmode: "any",
    format: "json"
  }).done(function (files) {
    if (files.result) {
      $.each(files.data, function (i, item) {
        var t = "<div class=\"ml-3 small\"><a class=\"text-dark\" href=\"" + item.doc + "\"><span class=\"text-muted mr-2\">" + item.datestr + "</span>" + item.title + "</a></div>";
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
    tagmode: "any",
    format: "json"
  }).done(function (calendar) {
    if (calendar.result) {
      $.each(calendar.data, function (i, item) {
        var t = '';
        t += "<div class=\"media cal pt-2\" onclick=\"window.location='" + item.url + "';\">";
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

},[["./assets/js/hozt.js","runtime","vendors~calendar~carousel~eu_cookie~form_default~form_extended~hozt~training_category~tryout_enrolle~6e62a6db","vendors~carousel~hozt","vendors~hozt"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2hvenQuc2NzcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvaG96dC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiZGlkU2Nyb2xsIiwibGFzdFNjcm9sbFRvcCIsImRlbHRhIiwibmF2YmFySGVpZ2h0IiwiJCIsIm91dGVySGVpZ2h0Iiwid2luZG93Iiwic2Nyb2xsIiwiZXZlbnQiLCJzZXRJbnRlcnZhbCIsImhhc1Njcm9sbGVkIiwic3QiLCJzY3JvbGxUb3AiLCJNYXRoIiwiYWJzIiwiYW5pbWF0ZSIsImhlaWdodCIsImRvY3VtZW50IiwiYWRkQW5pbWF0aW9uIiwiaWQiLCJlZmZlY3QiLCJyZW1vdmVDbGFzcyIsImFkZENsYXNzIiwib25lIiwidG9DbGlwYm9hcmQiLCJlbGVtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJ0ZXh0QXJlYSIsImNyZWF0ZUVsZW1lbnQiLCJ2YWx1ZSIsInRleHRDb250ZW50IiwiYm9keSIsImFwcGVuZENoaWxkIiwic2VsZWN0IiwiZXhlY0NvbW1hbmQiLCJyZW1vdmUiLCJyZWFkeSIsInRvb2x0aXAiLCJwb3BvdmVyIiwib24iLCJ0b2dnbGVDbGFzcyIsImNsaWNrIiwiZSIsInNjcm9sbFRvIiwib3B0aW9ucyIsInVzZUVhc2luZyIsInVzZUdyb3VwaW5nIiwic2VwYXJhdG9yIiwiZGVjaW1hbCIsImR1cmF0aW9uIiwiY250R3JvdXAiLCJDb3VudFVwIiwiZGF0YSIsImVycm9yIiwic3RhcnQiLCJjb25zb2xlIiwiY250Q29hY2giLCJjbnRTd2ltbWVyIiwic2Nyb2xsUG9zIiwidG9Ub3BWaXNpYmxlIiwidG9Ub3AiLCJiYW5uZXJWZWxvY2l0eSIsImJhbm5lclBvczAiLCJjc3MiLCJzcGxpdCIsImJhbm5lckhlaWdodDAiLCJiYW5uZXJQb3NZMCIsInBhcnNlSW50IiwiYmFubmVyUG9zWSIsImJhbm5lckltZ1RvcDAiLCJiYW5uZXJJbWdUb3AiLCJzdHlsZSIsInZpc2liaWxpdHkiLCJvcGFjaXR5IiwiZWFjaCIsImkiLCJwb3NpdGlvbiIsInRvcCIsInNwZWNpYWxFYXNpbmciLCJjb21wbGV0ZSIsImNoaWxkcmVuIiwiYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3R5ciIsImFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9wcm9ncmFtcyIsImFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9yZXN1bHRzIiwiYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvZGF5IiwiYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvbW9ycm93IiwiYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nIiwic2V0Q29va2llIiwiY25hbWUiLCJjdmFsdWUiLCJleGRheXMiLCJkIiwiRGF0ZSIsInNldFRpbWUiLCJnZXRUaW1lIiwiZXhwaXJlcyIsInRvVVRDU3RyaW5nIiwiY29va2llIiwiaHRtbCIsInRvVHlyIiwidCIsInNldFRpbWVvdXQiLCJvcGVuIiwibW9kdWxlIiwiaG96dEFQSSIsImdldEpTT04iLCJ0YWdtb2RlIiwiZm9ybWF0IiwiZG9uZSIsInRyYWluaW5nIiwicmVzdWx0IiwiaXRlbSIsInRpbWUiLCJ0ZWFtcyIsInRlYW0iLCJhYmJyIiwiY29tbWVudCIsImFwcGVuZFRvIiwiZmlsZXMiLCJ1cmwiLCJkYXRlc3RyIiwidGl0bGUiLCJkb2MiLCJpdGVtc0lkIiwiY2FsZW5kYXIiLCJkYXkiLCJtb250aCIsImNhbmNlbGxlZCIsImZvcm1hdHRlZFBlcmlvZCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUEsdUM7Ozs7Ozs7Ozs7OztBQ0FBQTtBQUFBQTtBQUFBQSxtQkFBTyxDQUFDLGdEQUFELENBQVA7O0FBRUFBLG1CQUFPLENBQUMsZ0VBQUQsQ0FBUDs7QUFDQUEsbUJBQU8sQ0FBQywwRUFBRCxDQUFQOztDQUlBOztBQUNBLElBQUlDLFNBQUo7QUFDQSxJQUFJQyxhQUFhLEdBQUcsQ0FBcEI7QUFDQSxJQUFJQyxLQUFLLEdBQUcsRUFBWjtBQUNBLElBQUlDLFlBQVksR0FB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TDs7QUFDQSxZQUFJVyxJQUFJLENBQUNnQixTQUFULEVBQW1CO0FBQUUzQixXQUFDLElBQUksMkJBQUw7QUFBbUMsU0FBeEQsTUFBOEQ7QUFBRUEsV0FBQyxJQUFJLFlBQUw7QUFBb0I7O0FBQ3BGQSxTQUFDLElBQUksSUFBTDtBQUNBQSxTQUFDLElBQUksMkVBQUw7QUFDQUEsU0FBQyxJQUFJLDBDQUF3Q1csSUFBSSxDQUFDVSxLQUE3QyxHQUFtRCxXQUF4RDtBQUNBckIsU0FBQyxJQUFJLDZDQUFMO0FBQ0FBLFNBQUMsSUFBSSxZQUFMO0FBQ0FBLFNBQUMsSUFBSSwrQkFBNkJXLElBQUksQ0FBQ2lCLGVBQWxDLEdBQWtELFNBQXZEO0FBQ0E1QixTQUFDLElBQUksVUFBTDtBQUNBQSxTQUFDLElBQUksUUFBTDtBQUNBaEcsU0FBQyxDQUFFZ0csQ0FBRixDQUFELENBQU9pQixRQUFQLENBQWlCTSxPQUFqQjtBQUNILE9BaEJEO0FBaUJBdkgsT0FBQyxDQUFDLCtHQUFELENBQUQsQ0FBbUhpSCxRQUFuSCxDQUE2SE0sT0FBN0g7QUFDSCxLQW5CRCxNQW1CTztBQUNIdkgsT0FBQyxDQUFFLDRCQUFGLENBQUQsQ0FBa0NpSCxRQUFsQyxDQUE0Q00sT0FBNUM7QUFDSDtBQUNKLEdBM0JEO0FBNkJILEMiLCJmaWxlIjoiaG96dC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsInJlcXVpcmUoJy4uL2Nzcy9ob3p0LnNjc3MnKTtcblxucmVxdWlyZSgnYm9vdHN0cmFwJyk7XG5yZXF1aXJlKCdqcXVlcnkuc2Nyb2xsVG8nKTtcbmltcG9ydCB7IENvdW50VXAgfSBmcm9tICdjb3VudHVwLmpzJztcblxuXG4vLyBIaWRlIEhlYWRlciBvbiBvbiBzY3JvbGwgZG93blxudmFyIGRpZFNjcm9sbDtcbnZhciBsYXN0U2Nyb2xsVG9wID0gMDtcbnZhciBkZWx0YSA9IDEwO1xudmFyIG5hdmJhckhlaWdodCA9ICQoJyNuYXYtY2F0ZWdvcmllcycpLm91dGVySGVpZ2h0KCk7XG5cbiQod2luZG93KS5zY3JvbGwoZnVuY3Rpb24oZXZlbnQpe1xuICAgIGRpZFNjcm9sbCA9IHRydWU7XG59KTtcblxuc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKSB7XG4gICAgaWYgKGRpZFNjcm9sbCkge1xuICAgICAgICBoYXNTY3JvbGxlZCgpO1xuICAgICAgICBkaWRTY3JvbGwgPSBmYWxzZTtcbiAgICB9XG59LCAyNTApO1xuXG5mdW5jdGlvbiBoYXNTY3JvbGxlZCgpIHtcbiAgICB2YXIgc3QgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XG5cbiAgICAvLyBNYWtlIHN1cmUgdGhleSBzY3JvbGwgbW9yZSB0aGFuIGRlbHRhXG4gICAgaWYgKE1hdGguYWJzKGxhc3RTY3JvbGxUb3AgLSBzdCkgPD0gZGVsdGEpe1xuICAgICAgICByZXR1cm47XG4gICAgfVxuICAgIFxuICAgIC8vIElmIHRoZXkgc2Nyb2xsZWQgZG93biBhbmQgYXJlIHBhc3QgdGhlIG5hdmJhciwgYWRkIGNsYXNzIC5uYXYtdXAuXG4gICAgLy8gVGhpcyBpcyBuZWNlc3Nhcnkgc28geW91IG5ldmVyIHNlZSB3aGF0IGlzIFwiYmVoaW5kXCIgdGhlIG5hdmJhci5cbiAgICBpZiAoc3QgPiBsYXN0U2Nyb2xsVG9wICYmIHN0ID4gbmF2YmFySGVpZ2h0KXtcbiAgICAgICAgLy8gU2Nyb2xsIERvd25cbiAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6Jy00MHB4J30sMjUwKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICAvLyBTY3JvbGwgVXBcbiAgICAgICAgaWYoc3QgKyAkKHdpbmRvdykuaGVpZ2h0KCkgPCAkKGRvY3VtZW50KS5oZWlnaHQoKSkge1xuICAgICAgICAgICAgJCgnI25hdi1jYXRlZ29yaWVzJykuYW5pbWF0ZSh7J3RvcCc6JzAnfSwyNTApO1xuICAgICAgICB9XG4gICAgfVxuICAgIFxuICAgIGxhc3RTY3JvbGxUb3AgPSBzdDtcbn1cblxuZnVuY3Rpb24gYWRkQW5pbWF0aW9uKGlkLCBlZmZlY3QpIHtcbiAgICAkKCcjJytpZCkucmVtb3ZlQ2xhc3MoKS5hZGRDbGFzcyhlZmZlY3QgKyAnIGFuaW1hdGVkJykub25lKCd3ZWJraXRBbmltYXRpb25FbmQgbW96QW5pbWF0aW9uRW5kIE1TQW5pbWF0aW9uRW5kIG9hbmltYXRpb25lbmQgYW5pbWF0aW9uZW5kJywgZnVuY3Rpb24oKXtcbiAgICAgICAgJCh0aGlzKS5yZW1vdmVDbGFzcygpO1xuICAgIH0pO1xufTtcblxuZnVuY3Rpb24gdG9DbGlwYm9hcmQoaWQpe1xuICAgIHZhciBlbGVtZW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICAgIHZhciB0ZXh0QXJlYSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJ0ZXh0YXJlYVwiKTtcbiAgICB0ZXh0QXJlYS52YWx1ZSA9IGVsZW1lbnQudGV4dENvbnRlbnQ7XG4gICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZCh0ZXh0QXJlYSk7XG4gICAgdGV4dEFyZWEuc2VsZWN0KCk7XG4gICAgZG9jdW1lbnQuZXhlY0NvbW1hbmQoXCJDb3B5XCIpO1xuICAgIHRleHRBcmVhLnJlbW92ZSgpO1xufTtcblxuXG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpe1xuXG4gICAgJChmdW5jdGlvbiAoKSB7XG4gICAgICAgICQoJ1tkYXRhLXRvZ2dsZT1cInRvb2x0aXBcIl0nKS50b29sdGlwKCk7XG4gICAgfSlcblxuICAgICQoZnVuY3Rpb24oKSB7XG4gICAgICAgJCgnW2RhdGEtdG9nZ2xlPVwicG9wb3ZlclwiXScpLnBvcG92ZXIoKTtcbiAgICB9KVxuXG4gICAgJChmdW5jdGlvbiAoKSB7XG4gICAgICAgICd1c2Ugc3RyaWN0J1xuICAgICAgICAkKCdbZGF0YS10b2dnbGU9XCJvZmZjYW52YXNcIl0nKS5vbignY2xpY2snLCBmdW5jdGlvbigpe1xuICAgICAgICAgICAgJCgnLm9mZmNhbnZhcy1jb2xsYXBzZScpLnRvZ2dsZUNsYXNzKCdvcGVuJylcbiAgICAgICAgfSlcbiAgICB9KTtcblxuICAgICQoJyN0b1RvcCcpLmNsaWNrKGZ1bmN0aW9uKGUpe1xuICAgICAgICAkLnNjcm9sbFRvKDAsIDcwMCk7IFxuICAgIH0pXG5cbiAgICAkKCcjbmF2YmFySGVhZGVyJykub24oJ3Nob3duLmJzLmNvbGxhcHNlJywgZnVuY3Rpb24oZSl7XG4gICAgICAgIHZhciBvcHRpb25zID0ge1xuICAgIOKAg+KAgyAgICAgIHVzZUVhc2luZzogdHJ1ZSwgXG4gICAgICDigIPigIMgICAgdXNlR3JvdXBpbmc6IHRydWUsIFxuICAgICAgICDigIPigIMgIHNlcGFyYXRvcjogJywnLCBcbiAgICAgIOKAg+KAgyAgICBkZWNpbWFsOiAnLicsXG4gICAgICAgICAgICBkdXJhdGlvbjogMyxcbiAgICAgICAgfTtcbiAgICAgICAgdmFyIGNudEdyb3VwID0gbmV3IENvdW50VXAoJ2NvdW50LWdyb2VwZW4nLCAkKGRvY3VtZW50LmJvZHkpLmRhdGEoJ25vZnRlYW1zJyksIG9wdGlvbnMpO1xuICAgICAgICBpZiAoIWNudEdyb3VwLmVycm9yKXtcbiAgICAgICAgICAgIGNudEdyb3VwLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnRHcm91cC5lcnJvcik7XG4gICAgICAgIH1cbiAgICAgICAgdmFyIGNudENvYWNoID0gbmV3IENvdW50VXAoJ2NvdW50LXRyYWluZXJzJywgJChkb2N1bWVudC5ib2R5KS5kYXRhKCdub2Zjb2FjaGVzJyksb3B0aW9ucyk7XG4gICAgICAgIGlmICghY250Q29hY2guZXJyb3Ipe1xu4oCD4oCDICAgICAgICAgIGNudENvYWNoLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnRDb2FjaC5lcnJvcik7XG4gICAgICAgIH0gXG4gICAgICAgIHZhciBjbnRTd2ltbWVyID0gbmV3IENvdW50VXAoJ2NvdW50LXp3ZW1tZXJzJywgJChkb2N1bWVudC5ib2R5KS5kYXRhKCdub2Zzd2ltbWVycycpLCBvcHRpb25zKTtcbiAgICAgICAgaWYgKCFjbnRTd2ltbWVyLmVycm9yKXtcbuKAg+KAgyAgICAgICAgICBjbnRTd2ltbWVyLnN0YXJ0KCk7XG4gICAgICAgIH0gZWxzZSB7XG7igIPigIMgICAgICAgICAgY29uc29sZS5lcnJvcihjbnRTd2ltbWVyLmVycm9yKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG5cbiAgICAvKiAgaW5pdCBiYWNrIHRvIHRvcCBpY29uICovXG4gICAgdmFyIHNjcm9sbFBvczsgXG4gICAgdmFyIHRvVG9wVmlzaWJsZT1mYWxzZTtcbiAgICB2YXIgdG9Ub3AgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgndG9Ub3AnKTtcblxuICAgIC8qICBpbml0IGJhbm5lciBwYXJhbGxheCBzY3JvbGwgKi8gXG4gICAgdmFyIGJhbm5lclZlbG9jaXR5ID0gLjQ1O1xuICAgIHZhciBiYW5uZXJQb3MwID0gJCgnLmJhbm5lcicpLmNzcygnYmFja2dyb3VuZFBvc2l0aW9uJykuc3BsaXQoXCIgXCIpO1xuICAgIHZhciBiYW5uZXJIZWlnaHQwID0gJCgnLmJhbm5lcicpLmhlaWdodCgpICsgJCgnI25hdi1jYXRlZ29yaWVzJykuaGVpZ2h0KCk7XG4gICAgdmFyIGJhbm5lclBvc1kwID0gcGFyc2VJbnQoYmFubmVyUG9zMFsxXSk7XG4gICAgdmFyIGJhbm5lclBvc1k7XG4gICAgdmFyIGJhbm5lckltZ1RvcDAgPSA1MDtcbiAgICB2YXIgYmFubmVySW1nVG9wO1xuIFxuICAgIC8qIEV2ZXJ5IHRpbWUgdGhlIHdpbmRvdyBpcyBzY3JvbGxlZCAuLi4gKi9cbiAgICAkKHdpbmRvdykuc2Nyb2xsKCBmdW5jdGlvbigpe1xuICAgICAgICBzY3JvbGxQb3MgPSAkKHdpbmRvdykuc2Nyb2xsVG9wKCk7XG4gICAgICAgIC8vIHNob3cgYmFjayB0byB0b3BcbiAgICAgICAgaWYgKCBzY3JvbGxQb3MgPj0gNDAwICYmICF0b1RvcFZpc2libGUgKXtcbiAgICAgICAgICAgIHRvVG9wVmlzaWJsZT10cnVlO1xuICAgICAgICAgICAgdG9Ub3Auc3R5bGUudmlzaWJpbGl0eT1cInZpc2libGVcIjtcbiAgICAgICAgICAgIHRvVG9wLnN0eWxlLm9wYWNpdHk9XCIwXCI7XG4gICAgICAgICAgICAkKCcjdG9Ub3AnKS5hbmltYXRlKHsnb3BhY2l0eSc6JzEnfSw3NTApO1xuICAgICAgICB9IFxuICAgICAgICBpZiAoIHNjcm9sbFBvcyA8IDQwMCAmJiB0b1RvcFZpc2libGUgKXtcbiAgICAgICAgICAgIHRvVG9wVmlzaWJsZT1mYWxzZTtcbiAgICAgICAgICAgICQoJyN0b1RvcCcpLmFuaW1hdGUoeydvcGFjaXR5JzonMCd9LDc1MCxmdW5jdGlvbigpeyBcbiAgICAgICAgICAgICAgICB0b1RvcC5zdHlsZS52aXNpYmlsaXR5PVwiaGlkZGVuXCI7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgICAvKiBDaGVjayB0aGUgbG9jYXRpb24gb2YgZWFjaCBkZXNpcmVkIGVsZW1lbnQgKi9cbiAgICAgICAgJCgnLnNjcm9sbC1mYWRlLWluJykuZWFjaCggZnVuY3Rpb24oaSl7XG5cbiAgICAgICAgICAgIC8qaWYgKGJvdHRvbV9vZl93aW5kb3cgPiBib3R0b21fb2Zfb2JqZWN0KXsqL1xuICAgICAgICAgICAgaWYgKCAkKHdpbmRvdykuc2Nyb2xsVG9wKCkgPiAkKHRoaXMpLnBvc2l0aW9uKCkudG9wIC0gJCh3aW5kb3cpLmhlaWdodCgpLzMgKXtcblxuICAgICAgICAgICAgICAkKHRoaXMpLmFuaW1hdGUoe1xuICAgICAgICAgICAgICAgIG9wYWNpdHk6IFwiMVwiXG4gICAgICAgICAgICAgIH0sIHtcbiAgICAgICAgICAgICAgICBkdXJhdGlvbjogMTAwMCxcbiAgICAgICAgICAgICAgICBzcGVjaWFsRWFzaW5nOiB7XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBjb21wbGV0ZTogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAkKCB0aGlzICkucmVtb3ZlQ2xhc3MoIFwic2Nyb2xsLWZhZGUtaW5cIiApO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIH0gICAgICBcbiAgICAgICAgfSk7XG4gICAgICBcbiAgICAgICAgaWYgKHNjcm9sbFBvcyA8PSBiYW5uZXJIZWlnaHQwKSB7XG4gICAgICAgICAgICAkKCcuY2Fyb3VzZWwtaXRlbScpLmVhY2goZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgYmFubmVySW1nVG9wID0gYmFubmVySW1nVG9wMCAtIDIgKiAoKGJhbm5lckhlaWdodDAtc2Nyb2xsUG9zKS9iYW5uZXJIZWlnaHQwLTEpKjUwICogYmFubmVyVmVsb2NpdHk7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5jaGlsZHJlbignaW1nJykuY3NzKCd0b3AnLCBiYW5uZXJJbWdUb3AgKyAnJScpOyBcbiAgICAgICAgICAgIH0pOyBcbiAgICAgICAgfVxuIFxuICAgIH0pO1xuXG59KTtcblxuXG4kKHdpbmRvdykub24oIFwibG9hZFwiLCBmdW5jdGlvbigpIHtcblxuICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdHlyKCk7XG4gIGFwaV9sb2FkX21vZHVsZV9jb21wZXRpdGlvbl9wcm9ncmFtcygpO1xuICBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcmVzdWx0cygpO1xuICBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXkoKTtcbiAgYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvbW9ycm93KCk7XG4gIGFwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZygpO1xuXG59KTtcblxuXG5mdW5jdGlvbiBzZXRDb29raWUoY25hbWUsIGN2YWx1ZSwgZXhkYXlzKSB7XG4gICAgdmFyIGQgPSBuZXcgRGF0ZSgpO1xuICAgIGQuc2V0VGltZShkLmdldFRpbWUoKSArIChleGRheXMqMjQqNjAqNjAqMTAwMCkpO1xuICAgIHZhciBleHBpcmVzID0gXCJleHBpcmVzPVwiKyBkLnRvVVRDU3RyaW5nKCk7XG4gICAgZG9jdW1lbnQuY29va2llID0gY25hbWUgKyBcIj1cIiArIGN2YWx1ZSArIFwiO1wiICsgZXhwaXJlcyArIFwiO3BhdGg9L1wiO1xufVxuXG4kKCcuc2NoZWR1bGVOb3RpY2UnKS5lYWNoKCBmdW5jdGlvbigpIHtcbiAgdmFyIGNuYW1lID0gJCh0aGlzKS5kYXRhKCdjbmFtZScpO1xuICB2YXIgY3ZhbHVlID0gJCh0aGlzKS5kYXRhKCdjdmFsdWUnKTtcbiAgJCh0aGlzKS5vbignY2xvc2VkLmJzLmFsZXJ0JywgZnVuY3Rpb24gKCkge1xuICAgIHNldENvb2tpZSAoY25hbWUsIGN2YWx1ZSwgNjApO1xuICB9KVxufSk7XG5cblxuLy8gYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3R5clxuZnVuY3Rpb24gYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3R5cigpIHtcbiAgICAkKCcjYXBpX2xvYWRfbW9kdWxlX3R5cicpLmh0bWwoJzxkaXYgY2xhc3M9XCJyb3cganVzdGlmeS1jb250ZW50LWFyb3VuZCBwLTNcIj48ZGl2IGNsYXNzPVwiY29sIGNvbC04IGNvbC1tZC0xMFwiPjxkaXYgY2xhc3M9XCJ0eXJcIiBkYXRhLXRvZ2dsZT1cInRvb2x0aXBcIiBkYXRhLXBsYWNlbWVudD1cImJvdHRvbVwiIHRpdGxlPVwiXCIgZGF0YS1vZmZzZXQ9XCIwXCIgZGF0YS1vcmlnaW5hbC10aXRsZT1cIktsaWsgb20gZGUgY2x1YmNvZGUgdGUga29wacOrcmVuXCI+PGltZyBjbGFzcz1cIm14LWF1dG8gaW1nLWZsdWlkXCIgc3JjPVwiL2Fzc2V0cy9pbWcvbG9nby90eXIucG5nXCI+PGRpdiBjbGFzcz1cInRleHQtY2VudGVyXCIgc3R5bGU9XCJtYXJnaW4tdG9wOi41ZW07IHBhZGRpbmctYm90dG9tOjA7XCI+Q2x1YmNvZGUgPHNwYW4gaWQ9XCJ0eXItY2x1YmNvZGVcIiBzdHlsZT1cImRpc3BsYXk6aW5saW5lLWJsb2NrO1wiIGNsYXNzPVwiXCI+SEdTMTVaTTwvc3Bhbj48L2Rpdj48L2Rpdj48L2Rpdj48L2Rpdj4nKTtcbiAgICAkKCcudHlyJykuY2xpY2soZnVuY3Rpb24oZSl7XG4gICAgICB0b1R5cigpO1xuICAgIH0pO1xufVxuZnVuY3Rpb24gdG9UeXIoKXtcbiAgICB0b0NsaXBib2FyZChcInR5ci1jbHViY29kZVwiKTtcbiAgICBhZGRBbmltYXRpb24oXCJ0eXItY2x1YmNvZGVcIixcInRhZGFcIik7XG4gICAgdmFyIHQgPSBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7d2luZG93Lm9wZW4oJ2h0dHA6Ly93d3cudHlyLm5sJywnX2JsYW5rJyk7fSwxMDAwKTtcbn1cblxuLy8gYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvZGF5XG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXkoKSB7XG5cbiAgICB2YXIgbW9kdWxlID0gXCJhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9kYXlcIjtcbiAgICB2YXIgaG96dEFQSSAgPSBcIi9hcGkvdHJhaW5pbmcvdmFuZGFhZ1wiO1xuXG4gICAkKCcjJyttb2R1bGUpLmh0bWwoXCI8ZGl2IGNsYXNzPVxcXCJwdC0zIHBiLTMgcGwtMyBwci0wXFxcIj48aDUgY2xhc3M9XFxcInBiLTIgbWItMFxcXCI+VHJhaW5pbmdzdXJlbiA8c3BhbiBjbGFzcz1cXFwiYmFkZ2UgYmFkZ2UtcHJpbWFyeSBmb250LXdlaWdodC1saWdodFxcXCI+dmFuZGFhZzwvc3Bhbj48L2g1PjxkaXYgaWQ9XFxcIlwiK21vZHVsZStcIl9pdGVtc1xcXCI+PC9kaXY+PC9kaXY+XCIpO1xuXG4gICAgJC5nZXRKU09OKCBob3p0QVBJLCB7XG4gICAgICAgIHRhZ21vZGU6IFwiYW55XCIsXG4gICAgICAgIGZvcm1hdDogXCJqc29uXCJcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKCB0cmFpbmluZyApIHtcbiAgICAgICAgaWYgKCB0cmFpbmluZy5yZXN1bHQgKXtcbiAgICAgICAgICAgICQuZWFjaCggdHJhaW5pbmcuZGF0YSwgZnVuY3Rpb24oIGksIGl0ZW0gKSB7XG4gICAgICAgICAgICAgICAgdmFyIHQgPSBcIjxkaXYgY2xhc3M9XFxcInJvdyBuby1ndXR0ZXJzXFxcIj48ZGl2IGNsYXNzPVxcXCJjb2wtNSBjb2wtbWQtOSBjb2wtbGctNiB0ZXh0LXJpZ2h0IHB0LTEgc21hbGxcXFwiPlwiKyBpdGVtLnRpbWUgKyBcIjwvZGl2PlwiO1xuICAgICAgICAgICAgICAgIHQgKz0gXCI8ZGl2IGNsYXNzPVxcXCJjb2wtNyBjb2wtbWQtMyBjb2wtbGctNiBwbC0xXFxcIj5cIjtcbiAgICAgICAgICAgICAgICAkLmVhY2goIGl0ZW0udGVhbXMsIGZ1bmN0aW9uKCBpLCB0ZWFtICkge1xuICAgICAgICAgICAgICAgICAgICB0ICs9IFwiPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLXByaW1hcnkgYmFkZ2UtdGVhbSBtbC0xXFxcIj5cIiArIHRlYW0uYWJiciArIFwiPC9zcGFuPlwiO1xuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIGlmICggaXRlbS5jb21tZW50ICl7XG4gICAgICAgICAgICAgICAgICAgdCArPSBcIjxzcGFuIGNsYXNzPVxcXCJiYWRnZSBiYWRnZS1zZWNvbmRhcnkgbWwtMVxcXCI+XCIgKyBpdGVtLmNvbW1lbnQgKyBcIjwvc3Bhbj5cIjtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgdCArPSBcIjwvZGl2PjwvZGl2PlwiO1xuICAgICAgICAgICAgICAgICQoIHQgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCggXCI8ZGl2IGNsYXNzPVxcXCJzbWFsbCBtbC0zXFxcIj5FciBpcyB2YW5kYWFnIGdlZW4gdHJhaW5pbmc8L2Rpdj5cIiApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICB9XG4gICAgfSk7XG5cbn1cblxuLy8gYXBpX2xvYWRfbW9kdWxlX3RyYWluaW5nX3RvbW9ycm93XG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9tb3Jyb3coKSB7XG5cbiAgICB2YXIgbW9kdWxlID0gXCJhcGlfbG9hZF9tb2R1bGVfdHJhaW5pbmdfdG9tb3Jyb3dcIjtcbiAgICB2YXIgaG96dEFQSSAgPSBcIi9hcGkvdHJhaW5pbmcvbW9yZ2VuXCI7XG5cbiAgICQoJyMnK21vZHVsZSkuaHRtbChcIjxkaXYgY2xhc3M9XFxcInB0LTMgcGItMyBwbC0zIHByLTBcXFwiPjxoNSBjbGFzcz1cXFwicGItMiBtYi0wXFxcIj5UcmFpbmluZ3N1cmVuIDxzcGFuIGNsYXNzPVxcXCJiYWRnZSBiYWRnZS1tZWRpdW0gZm9udC13ZWlnaHQtbGlnaHRcXFwiPm1vcmdlbjwvc3Bhbj48L2g1PjxkaXYgaWQ9XFxcIlwiK21vZHVsZStcIl9pdGVtc1xcXCI+PC9kaXY+PC9kaXY+XCIpO1xuXG4gICAgJC5nZXRKU09OKCBob3p0QVBJLCB7XG4gICAgICAgIHRhZ21vZGU6IFwiYW55XCIsXG4gICAgICAgIGZvcm1hdDogXCJqc29uXCJcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKCB0cmFpbmluZyApIHtcbiAgICAgICAgaWYgKCB0cmFpbmluZy5yZXN1bHQgKXtcbiAgICAgICAgICAgICQuZWFjaCggdHJhaW5pbmcuZGF0YSwgZnVuY3Rpb24oIGksIGl0ZW0gKSB7XG4gICAgICAgICAgICAgICAgdmFyIHQgPSBcIjxkaXYgY2xhc3M9XFxcInJvdyBuby1ndXR0ZXJzXFxcIj48ZGl2IGNsYXNzPVxcXCJjb2wtNSBjb2wtbWQtOSBjb2wtbGctNiB0ZXh0LXJpZ2h0IHB0LTEgc21hbGxcXFwiPlwiKyBpdGVtLnRpbWUgKyBcIjwvZGl2PlwiO1xuICAgICAgICAgICAgICAgIHQgKz0gXCI8ZGl2IGNsYXNzPVxcXCJjb2wtNyBjb2wtbWQtMyBjb2wtbGctNiBwbC0xXFxcIj5cIjtcbiAgICAgICAgICAgICAgICAkLmVhY2goIGl0ZW0udGVhbXMsIGZ1bmN0aW9uKCBpLCB0ZWFtICkge1xuICAgICAgICAgICAgICAgICAgICB0ICs9IFwiPHNwYW4gY2xhc3M9XFxcImJhZGdlIGJhZGdlLXByaW1hcnkgYmFkZ2UtdGVhbSBtbC0xXFxcIj5cIiArIHRlYW0uYWJiciArIFwiPC9zcGFuPlwiO1xuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIGlmICggaXRlbS5jb21tZW50ICl7XG4gICAgICAgICAgICAgICAgICAgdCArPSBcIjxzcGFuIGNsYXNzPVxcXCJiYWRnZSBiYWRnZS1zZWNvbmRhcnkgbWwtMVxcXCI+XCIgKyBpdGVtLmNvbW1lbnQgKyBcIjwvc3Bhbj5cIjtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgdCArPSBcIjwvZGl2PjwvZGl2PlwiO1xuICAgICAgICAgICAgICAgICQoIHQgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCggXCI8ZGl2IGNsYXNzPVxcXCJzbWFsbCBtbC0zXFxcIj5FciBpcyBtb3JnZW4gZ2VlbiB0cmFpbmluZzwvZGl2PlwiICkuYXBwZW5kVG8oIFwiI1wiK21vZHVsZStcIl9pdGVtc1wiICk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufVxuXG4vLyBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcmVzdWx0c1xuZnVuY3Rpb24gYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Jlc3VsdHMoKSB7XG5cbiAgICB2YXIgbW9kdWxlID0gXCJhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcmVzdWx0c1wiO1xuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS9kb2N1bWVudGVuL3dlZHN0cmlqZGVuL2xhYXRzdGUvdWl0c2xhZy81XCI7XG5cbiAgICAkKCcjJyttb2R1bGUpLmh0bWwoXCI8ZGl2IGNsYXNzPVxcXCJwLTNcXFwiPjxoNSBjbGFzcz1cXFwicGItMiBtYi0wXFxcIj5VaXRzbGFnZW48L2g1PjxkaXYgaWQ9XFxcIlwiK21vZHVsZStcIl9pdGVtc1xcXCI+PC9kaXY+PC9kaXY+XCIpOyBcblxuICAgICQuZ2V0SlNPTiggaG96dEFQSSwge1xuICAgICAgICB0YWdtb2RlOiBcImFueVwiLFxuICAgICAgICBmb3JtYXQ6IFwianNvblwiXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggZmlsZXMgKSB7XG4gICAgICAgIGlmICggZmlsZXMucmVzdWx0ICl7XG4gICAgICAgICAgICAkLmVhY2goIGZpbGVzLmRhdGEsIGZ1bmN0aW9uKCBpLCBpdGVtICkge1xuICAgICAgICAgICAgICAgIHZhciB0ID0gXCI8ZGl2IGNsYXNzPVxcXCJtbC0zIHNtYWxsXFxcIj48YSBjbGFzcz1cXFwidGV4dC1kYXJrXFxcIiBocmVmPVxcXCJcIiArIGl0ZW0udXJsICsgXCJcXFwiPjxzcGFuIGNsYXNzPVxcXCJ0ZXh0LW11dGVkIG1yLTJcXFwiPlwiICsgaXRlbS5kYXRlc3RyICtcIjwvc3Bhbj5cIisgaXRlbS50aXRsZSArIFwiPC9hPjwvZGl2PlwiO1xuICAgICAgICAgICAgICAgICQoIHQgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCggXCI8ZGl2IGNsYXNzPVxcXCJzbWFsbCBtbC0zXFxcIj5HZWVuIHdlZHN0cmlqZCB1aXRzbGFnZW4gZ2V2b25kZW48L2Rpdj5cIiApLmFwcGVuZFRvKCBcIiNcIittb2R1bGUrXCJfaXRlbXNcIiApO1xuICAgICAgICB9XG4gICAgfSk7XG5cbn1cblxuLy8gYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Byb2dyYW1zXG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfY29tcGV0aXRpb25fcHJvZ3JhbXMoKSB7XG5cbiAgICB2YXIgbW9kdWxlICA9IFwiYXBpX2xvYWRfbW9kdWxlX2NvbXBldGl0aW9uX3Byb2dyYW1zXCI7XG4gICAgdmFyIGhvenRBUEkgPSBcIi9hcGkvZG9jdW1lbnRlbi93ZWRzdHJpamRlbi9hYW5zdGFhbmRlL3Byb2dyYW1tYVwiO1xuXG4gICAgJCgnIycrbW9kdWxlKS5odG1sKFwiPGRpdiBjbGFzcz1cXFwicC0zXFxcIj48aDUgY2xhc3M9XFxcInBiLTIgbWItMFxcXCI+UHJvZ3JhbW1hJ3M8L2g1PjxkaXYgaWQ9XFxcIlwiK21vZHVsZStcIl9pdGVtc1xcXCI+PC9kaXY+PC9kaXY+XCIpOyBcblxuICAgICQuZ2V0SlNPTiggaG96dEFQSSwge1xuICAgICAgICB0YWdtb2RlOiBcImFueVwiLFxuICAgICAgICBmb3JtYXQ6IFwianNvblwiXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggZmlsZXMgKSB7XG4gICAgICAgIGlmICggZmlsZXMucmVzdWx0ICl7XG4gICAgICAgICAgICAkLmVhY2goIGZpbGVzLmRhdGEsIGZ1bmN0aW9uKCBpLCBpdGVtICkge1xuICAgICAgICAgICAgICAgIHZhciB0ID0gXCI8ZGl2IGNsYXNzPVxcXCJtbC0zIHNtYWxsXFxcIj48YSBjbGFzcz1cXFwidGV4dC1kYXJrXFxcIiBocmVmPVxcXCJcIiArIGl0ZW0uZG9jICsgXCJcXFwiPjxzcGFuIGNsYXNzPVxcXCJ0ZXh0LW11dGVkIG1yLTJcXFwiPlwiICsgaXRlbS5kYXRlc3RyICtcIjwvc3Bhbj5cIisgaXRlbS50aXRsZSArIFwiPC9hPjwvZGl2PlwiO1xuICAgICAgICAgICAgICAgICQoIHQgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCggXCI8ZGl2IGNsYXNzPVxcXCJzbWFsbCBtbC0zXFxcIj5HZWVuIHByb2dyYW1tYSdzIGdldm9uZGVuPC9kaXY+XCIgKS5hcHBlbmRUbyggXCIjXCIrbW9kdWxlK1wiX2l0ZW1zXCIgKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG59XG5cbi8vIGFwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZ1xuXG5mdW5jdGlvbiBhcGlfbG9hZF9tb2R1bGVfY2FsZW5kYXJfdXBjb21pbmcoKSB7XG5cbiAgICAkKCcjYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nJykuaHRtbCgnPGRpdiBjbGFzcz1cInAtM1wiPjxoNSBjbGFzcz1cInBiLTIgbWItMFwiPkthbGVuZGVyPC9oNT48ZGl2IGlkPVwiYXBpX2xvYWRfbW9kdWxlX2NhbGVuZGFyX3VwY29taW5nX2l0ZW1zXCI+PC9kaXY+PC9kaXY+Jyk7XG5cbiAgICB2YXIgaG96dEFQSSAgPSBcIi9hcGkva2FsZW5kZXIvYWFuc3RhYW5kZVwiO1xuICAgIHZhciBpdGVtc0lkICA9IFwiI2FwaV9sb2FkX21vZHVsZV9jYWxlbmRhcl91cGNvbWluZ19pdGVtc1wiOyBcblxuICAgICQuZ2V0SlNPTiggaG96dEFQSSwge1xuICAgICAgICB0YWdtb2RlOiBcImFueVwiLFxuICAgICAgICBmb3JtYXQ6IFwianNvblwiXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggY2FsZW5kYXIgKSB7XG4gICAgICAgIGlmICggY2FsZW5kYXIucmVzdWx0ICl7XG4gICAgICAgICAgICAkLmVhY2goIGNhbGVuZGFyLmRhdGEsIGZ1bmN0aW9uKCBpLCBpdGVtICkge1xuICAgICAgICAgICAgICAgIHZhciB0ID0gJyc7XG4gICAgICAgICAgICAgICAgdCArPSBcIjxkaXYgY2xhc3M9XFxcIm1lZGlhIGNhbCBwdC0yXFxcIiBvbmNsaWNrPVxcXCJ3aW5kb3cubG9jYXRpb249J1wiICsgaXRlbS51cmwgKyBcIic7XFxcIj5cIjtcbiAgICAgICAgICAgICAgICB0ICs9ICcgIDxzcGFuIGNsYXNzPVwiYmFkZ2UgYmFkZ2UtZGFyayBtci0yIGNhbCBjYWwtc20gJysgaXRlbS5jbGFzcyBcbiAgICAgICAgICAgICAgICB0ICs9ICdcIj4nKyBpdGVtLmRheSArJzxicj4nKyBpdGVtLm1vbnRoICsnPC9zcGFuPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICA8ZGl2IGNsYXNzPVwibWVkaWEtYm9keSBwYi0yIG1iLTAgc21hbGwgbGgtMTI1IGJvcmRlci1ib3R0b20gYm9yZGVyLWdyYXkgJztcbiAgICAgICAgICAgICAgICBpZiAoaXRlbS5jYW5jZWxsZWQpeyB0ICs9ICdjYWwtY2FuY2VsbGVkIHRleHQtZGFuZ2VyJzsgfSBlbHNlIHsgdCArPSAndGV4dC1tdXRlZCc7IH1cbiAgICAgICAgICAgICAgICB0ICs9ICdcIj4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgICA8ZGl2IGNsYXNzPVwiZC1mbGV4IGp1c3RpZnktY29udGVudC1iZXR3ZWVuIGFsaWduLWl0ZW1zLWNlbnRlciB3LTEwMFwiPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICAgICAgPHN0cm9uZyBjbGFzcz1cInRleHQtZ3JheS1kYXJrXCI+JytpdGVtLnRpdGxlKyc8L3N0cm9uZz4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJyAgICAgIDxhIGhyZWY9XCIjXCIgY2xhc3M9XCJkLW5vbmVcIj5CZWtpams8L2E+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgICAgPC9kaXY+JztcbiAgICAgICAgICAgICAgICB0ICs9ICcgICAgPHNwYW4gY2xhc3M9XCJkLWJsb2NrXCI+JytpdGVtLmZvcm1hdHRlZFBlcmlvZCsnPC9zcGFuPic7XG4gICAgICAgICAgICAgICAgdCArPSAnICA8L2Rpdj4nO1xuICAgICAgICAgICAgICAgIHQgKz0gJzwvZGl2Pic7XG4gICAgICAgICAgICAgICAgJCggdCApLmFwcGVuZFRvKCBpdGVtc0lkICk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICQoJzxwIGNsYXNzPVwic21hbGwgbXQtMiB0ZXh0LXJpZ2h0XCI+PGEgaHJlZj1cIi9rYWxlbmRlclwiPjxpIGNsYXNzPVwiZmFzIGZhLWNhbGVuZGFyLXBsdXNcIj48L2k+IEFsbGUgZXZlbnRzPC9hPjwvcD4nKS5hcHBlbmRUbyggaXRlbXNJZCApO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCggXCI8cD5FciB6aWpuIGdlZW4gZXZlbnRzPC9wPlwiICkuYXBwZW5kVG8oIGl0ZW1zSWQgKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG59XG4iXSwic291cmNlUm9vdCI6IiJ9