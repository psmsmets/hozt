(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["membership_competitions"],{

/***/ "./assets/js/membership_competitions.js":
/*!**********************************************!*\
  !*** ./assets/js/membership_competitions.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

var statusNull = '<i class="fas fa-square text-medium h4"></i>';
var statusTrue = '<button class="btn btn-success btn-sm"><i class="fas fa-check" data-value="true"></i></button>';
var statusFalse = '<button class="btn btn-warning btn-sm text-light"><i class="fas fa-minus" data-value="false"></i></button>';

function loadCompetitions() {
  $.getJSON("/api/private/membership/competitions", {
    format: "json",
    action: 'load'
  }).done(function (data) {
    if (data.success) {
      var newCompetitions = 0;
      $.each(data.data, function (i, item) {
        var td = $('#competition-enrolment-' + item.competitionpart + '-' + item.member);

        if (item.disabled) {
          $(td).html(statusNull);
        } else if (item.enrolled) {
          $(td).html(statusTrue);
        } else {
          $(td).html(statusFalse);
        }

        if (!item.enrolledAt && item.editable) newCompetitions = newCompetitions + 1;
      });
      if (newCompetitions) $('#competitions-new-tab span').html(newCompetitions);
    }
  });
}

function editCompetition(element) {
  if ($(element).hasClass('editing')) return;
  $(element).addClass('editing');

  var _element$id$split = element.id.split('-'),
      _element$id$split2 = _slicedToArray(_element$id$split, 4),
      competition = _element$id$split2[0],
      part = _element$id$split2[1],
      competitionPart = _element$id$split2[2],
      member = _element$id$split2[3];

  var enrolled = !$('i', element).data('value');
  $.getJSON("/api/private/membership/competitions", {
    format: "json",
    action: 'edit',
    competitionpart: competitionPart,
    member: member,
    enrolled: enrolled ? 1 : 0
  }).done(function (data) {
    if (enrolled) {
      $(element).html(statusTrue);
    } else {
      $(element).html(statusFalse);
    }

    $(element).removeClass('editing');
  });
}

function editCompetitions() {
  var edit = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
  $("tr:not(.d-none) td[id^='competition-enrolment-']").each(function () {
    if ($('i', this).attr('data-value') !== undefined) {
      if (edit) {
        $(this).click(function () {
          editCompetition(this);
        });
      } else {
        $(this).unbind();
      }
    }
  });
}

function showTabCompetitions(tab) {
  $('tr.competition').removeClass('d-none');

  switch (tab.id) {
    case 'competitions-all-tab':
      break;

    case 'competitions-new-tab':
      $('tr.competition').addClass('d-none');
      $('tr.competition-new').removeClass('d-none');
      break;

    case 'competitions-upcoming-tab':
      $('tr.competition-past').addClass('d-none');
      break;
  }
} // on pageload


loadCompetitions();
var editingCompetitions = false;
$(document).ready(function () {
  $('.competition-past').hide();
  $('#competitions-edit').click(function () {
    if (editingCompetitions) {
      $(this).html('<i class="fas fa-lock"></i> bewerken'); //.removeClass('btn-medium').addClass('btn-dark'); 

      $('#competitions-tab > a').removeClass("disabled");
      $('tr.competition-locked').removeClass('d-none');
      showTabCompetitions($('#competitions-tab').find('.active')[0]);
      editCompetitions(false);
      loadCompetitions();
    } else {
      $(this).html('<i class="fas fa-lock-open"></i> afronden'); //.removeClass('btn-dark').addClass('btn-medium');

      $('#competitions-tab > a').addClass("disabled");
      $('tr.competition-locked').addClass('d-none');
      editCompetitions(true);
    }

    editingCompetitions = !editingCompetitions;
  });
  $('#competitions-tab').on('show.bs.tab', function (e) {
    //e.target // newly activated tab
    //e.relatedTarget // previous active tab
    showTabCompetitions(e.target);
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/membership_competitions.js","runtime","vendors~calendar~carousel~eu_cookie~form_default~form_extended~hozt~membership_competitions~membersh~262175ed","vendors~carousel~hozt~membership_competitions~membership_preferences"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbWVtYmVyc2hpcF9jb21wZXRpdGlvbnMuanMiXSwibmFtZXMiOlsicmVxdWlyZSIsInN0YXR1c051bGwiLCJzdGF0dXNUcnVlIiwic3RhdHVzRmFsc2UiLCJsb2FkQ29tcGV0aXRpb25zIiwiJCIsImdldEpTT04iLCJmb3JtYXQiLCJhY3Rpb24iLCJkb25lIiwiZGF0YSIsInN1Y2Nlc3MiLCJuZXdDb21wZXRpdGlvbnMiLCJlYWNoIiwiaSIsIml0ZW0iLCJ0ZCIsImNvbXBldGl0aW9ucGFydCIsIm1lbWJlciIsImRpc2FibGVkIiwiaHRtbCIsImVucm9sbGVkIiwiZW5yb2xsZWRBdCIsImVkaXRhYmxlIiwiZWRpdENvbXBldGl0aW9uIiwiZWxlbWVudCIsImhhc0NsYXNzIiwiYWRkQ2xhc3MiLCJpZCIsInNwbGl0IiwiY29tcGV0aXRpb24iLCJwYXJ0IiwiY29tcGV0aXRpb25QYXJ0IiwicmVtb3ZlQ2xhc3MiLCJlZGl0Q29tcGV0aXRpb25zIiwiZWRpdCIsImF0dHIiLCJ1bmRlZmluZWQiLCJjbGljayIsInVuYmluZCIsInNob3dUYWJDb21wZXRpdGlvbnMiLCJ0YWIiLCJlZGl0aW5nQ29tcGV0aXRpb25zIiwiZG9jdW1lbnQiLCJyZWFkeSIsImhpZGUiLCJmaW5kIiwib24iLCJlIiwidGFyZ2V0Il0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7OztBQUFBQSxtQkFBTyxDQUFDLGdFQUFELENBQVA7O0FBR0EsSUFBSUMsVUFBVSxHQUFHLDhDQUFqQjtBQUNBLElBQUlDLFVBQVUsR0FBRyxnR0FBakI7QUFDQSxJQUFJQyxXQUFXLEdBQUcsNEdBQWxCOztBQUVBLFNBQVNDLGdCQUFULEdBQTRCO0FBQ3hCQyxHQUFDLENBQUNDLE9BQUYsQ0FBVyxzQ0FBWCxFQUFtRDtBQUMvQ0MsVUFBTSxFQUFFLE1BRHVDO0FBRS9DQyxVQUFNLEVBQUU7QUFGdUMsR0FBbkQsRUFJQ0MsSUFKRCxDQUlNLFVBQVVDLElBQVYsRUFB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LENBQXZDLENBQUQsQ0FBbkI7QUFDQVosc0JBQWdCLENBQUMsS0FBRCxDQUFoQjtBQUNBOUIsc0JBQWdCO0FBQ25CLEtBUEQsTUFPTztBQUNIQyxPQUFDLENBQUMsSUFBRCxDQUFELENBQVFlLElBQVIsQ0FBYSwyQ0FBYixFQURHLENBQ3dEOztBQUMzRGYsT0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkJzQixRQUEzQixDQUFxQyxVQUFyQztBQUNBdEIsT0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkJzQixRQUEzQixDQUFvQyxRQUFwQztBQUNBTyxzQkFBZ0IsQ0FBQyxJQUFELENBQWhCO0FBQ0g7O0FBQ0RRLHVCQUFtQixHQUFHLENBQUNBLG1CQUF2QjtBQUNILEdBZkQ7QUFrQkFyQyxHQUFDLENBQUMsbUJBQUQsQ0FBRCxDQUF1QjBDLEVBQXZCLENBQTBCLGFBQTFCLEVBQXlDLFVBQVVDLENBQVYsRUFBYTtBQUNsRDtBQUNBO0FBQ0FSLHVCQUFtQixDQUFDUSxDQUFDLENBQUNDLE1BQUgsQ0FBbkI7QUFDSCxHQUpEO0FBTUgsQ0E1QkQsRSIsImZpbGUiOiJtZW1iZXJzaGlwX2NvbXBldGl0aW9ucy5qcyIsInNvdXJjZXNDb250ZW50IjpbInJlcXVpcmUoJ2Jvb3RzdHJhcCcpO1xuXG5cbnZhciBzdGF0dXNOdWxsID0gJzxpIGNsYXNzPVwiZmFzIGZhLXNxdWFyZSB0ZXh0LW1lZGl1bSBoNFwiPjwvaT4nO1xudmFyIHN0YXR1c1RydWUgPSAnPGJ1dHRvbiBjbGFzcz1cImJ0biBidG4tc3VjY2VzcyBidG4tc21cIj48aSBjbGFzcz1cImZhcyBmYS1jaGVja1wiIGRhdGEtdmFsdWU9XCJ0cnVlXCI+PC9pPjwvYnV0dG9uPic7XG52YXIgc3RhdHVzRmFsc2UgPSAnPGJ1dHRvbiBjbGFzcz1cImJ0biBidG4td2FybmluZyBidG4tc20gdGV4dC1saWdodFwiPjxpIGNsYXNzPVwiZmFzIGZhLW1pbnVzXCIgZGF0YS12YWx1ZT1cImZhbHNlXCI+PC9pPjwvYnV0dG9uPic7XG5cbmZ1bmN0aW9uIGxvYWRDb21wZXRpdGlvbnMoKSB7XG4gICAgJC5nZXRKU09OKCBcIi9hcGkvcHJpdmF0ZS9tZW1iZXJzaGlwL2NvbXBldGl0aW9uc1wiLCB7XG4gICAgICAgIGZvcm1hdDogXCJqc29uXCIsXG4gICAgICAgIGFjdGlvbjogJ2xvYWQnLFxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGRhdGEgKSB7XG4gICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MpIHtcbiAgICAgICAgICAgIHZhciBuZXdDb21wZXRpdGlvbnMgPSAwO1xuICAgICAgICAgICAgJC5lYWNoKGRhdGEuZGF0YSwgZnVuY3Rpb24oaSwgaXRlbSkge1xuICAgICAgICAgICAgICAgIHZhciB0ZCA9ICQoJyNjb21wZXRpdGlvbi1lbnJvbG1lbnQtJytpdGVtLmNvbXBldGl0aW9ucGFydCsnLScraXRlbS5tZW1iZXIpO1xuICAgICAgICAgICAgICAgIGlmIChpdGVtLmRpc2FibGVkKSB7XG4gICAgICAgICAgICAgICAgICAgICQodGQpLmh0bWwoIHN0YXR1c051bGwgKTtcbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKGl0ZW0uZW5yb2xsZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgJCh0ZCkuaHRtbCggc3RhdHVzVHJ1ZSApO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICQodGQpLmh0bWwoIHN0YXR1c0ZhbHNlICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGlmICghaXRlbS5lbnJvbGxlZEF0ICYmIGl0ZW0uZWRpdGFibGUpIG5ld0NvbXBldGl0aW9ucyA9IG5ld0NvbXBldGl0aW9ucyArIDE7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGlmIChuZXdDb21wZXRpdGlvbnMpICQoJyNjb21wZXRpdGlvbnMtbmV3LXRhYiBzcGFuJykuaHRtbChuZXdDb21wZXRpdGlvbnMpO1xuICAgICAgICB9XG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIGVkaXRDb21wZXRpdGlvbihlbGVtZW50KSB7XG4gICAgaWYgKCQoZWxlbWVudCkuaGFzQ2xhc3MoJ2VkaXRpbmcnKSkgcmV0dXJuO1xuICAgICQoZWxlbWVudCkuYWRkQ2xhc3MoJ2VkaXRpbmcnKTtcblxuICAgIHZhciBbY29tcGV0aXRpb24sIHBhcnQsIGNvbXBldGl0aW9uUGFydCwgbWVtYmVyXSA9IGVsZW1lbnQuaWQuc3BsaXQoJy0nKTtcbiAgICB2YXIgZW5yb2xsZWQgPSAhJCgnaScsZWxlbWVudCkuZGF0YSgndmFsdWUnKTtcblxuICAgICQuZ2V0SlNPTiggXCIvYXBpL3ByaXZhdGUvbWVtYmVyc2hpcC9jb21wZXRpdGlvbnNcIiwge1xuICAgICAgICBmb3JtYXQ6IFwianNvblwiLFxuICAgICAgICBhY3Rpb246ICdlZGl0JyxcbiAgICAgICAgY29tcGV0aXRpb25wYXJ0OiBjb21wZXRpdGlvblBhcnQsXG4gICAgICAgIG1lbWJlcjogbWVtYmVyLFxuICAgICAgICBlbnJvbGxlZDogZW5yb2xsZWQgPyAxIDogMCxcbiAgICB9KVxuICAgIC5kb25lKGZ1bmN0aW9uKCBkYXRhICkge1xuICAgICAgICBpZiAoZW5yb2xsZWQpIHtcbiAgICAgICAgICAgICQoZWxlbWVudCkuaHRtbChzdGF0dXNUcnVlKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICQoZWxlbWVudCkuaHRtbChzdGF0dXNGYWxzZSk7XG4gICAgICAgIH1cbiAgICAgICAgJChlbGVtZW50KS5yZW1vdmVDbGFzcygnZWRpdGluZycpO1xuICAgIH0pO1xufVxuXG5cbmZ1bmN0aW9uIGVkaXRDb21wZXRpdGlvbnMoZWRpdD1mYWxzZSkge1xuICAgICQoXCJ0cjpub3QoLmQtbm9uZSkgdGRbaWRePSdjb21wZXRpdGlvbi1lbnJvbG1lbnQtJ11cIikuZWFjaCggZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICgkKCdpJyx0aGlzKS5hdHRyKCdkYXRhLXZhbHVlJykhPT11bmRlZmluZWQpIHtcbiAgICAgICAgICAgIGlmIChlZGl0KSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5jbGljayggZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGVkaXRDb21wZXRpdGlvbih0aGlzKTtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS51bmJpbmQoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBzaG93VGFiQ29tcGV0aXRpb25zKHRhYikge1xuICAgICQoJ3RyLmNvbXBldGl0aW9uJykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xuICAgIHN3aXRjaCh0YWIuaWQpIHtcbiAgICAgICAgY2FzZSAnY29tcGV0aXRpb25zLWFsbC10YWInOlxuICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgIGNhc2UgJ2NvbXBldGl0aW9ucy1uZXctdGFiJzpcbiAgICAgICAgICAgICQoJ3RyLmNvbXBldGl0aW9uJykuYWRkQ2xhc3MoJ2Qtbm9uZScpO1xuICAgICAgICAgICAgJCgndHIuY29tcGV0aXRpb24tbmV3JykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xuICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgIGNhc2UgJ2NvbXBldGl0aW9ucy11cGNvbWluZy10YWInOlxuICAgICAgICAgICAgJCgndHIuY29tcGV0aXRpb24tcGFzdCcpLmFkZENsYXNzKCdkLW5vbmUnKTtcbiAgICAgICAgICAgIGJyZWFrO1xuICAgIH1cbn1cblxuLy8gb24gcGFnZWxvYWRcbmxvYWRDb21wZXRpdGlvbnMoKTtcblxudmFyIGVkaXRpbmdDb21wZXRpdGlvbnMgPSBmYWxzZTtcblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcblxuICAgICQoJy5jb21wZXRpdGlvbi1wYXN0JykuaGlkZSgpO1xuXG4gICAgJCgnI2NvbXBldGl0aW9ucy1lZGl0JykuY2xpY2soIGZ1bmN0aW9uKCkge1xuICAgICAgICBpZiAoZWRpdGluZ0NvbXBldGl0aW9ucykge1xuICAgICAgICAgICAgJCh0aGlzKS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS1sb2NrXCI+PC9pPiBiZXdlcmtlbicpOyAvLy5yZW1vdmVDbGFzcygnYnRuLW1lZGl1bScpLmFkZENsYXNzKCdidG4tZGFyaycpOyBcbiAgICAgICAgICAgICQoJyNjb21wZXRpdGlvbnMtdGFiID4gYScpLnJlbW92ZUNsYXNzKCBcImRpc2FibGVkXCIgKTtcbiAgICAgICAgICAgICQoJ3RyLmNvbXBldGl0aW9uLWxvY2tlZCcpLnJlbW92ZUNsYXNzKCdkLW5vbmUnKTtcbiAgICAgICAgICAgIHNob3dUYWJDb21wZXRpdGlvbnMoJCgnI2NvbXBldGl0aW9ucy10YWInKS5maW5kKCcuYWN0aXZlJylbMF0pO1xuICAgICAgICAgICAgZWRpdENvbXBldGl0aW9ucyhmYWxzZSk7XG4gICAgICAgICAgICBsb2FkQ29tcGV0aXRpb25zKCk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKHRoaXMpLmh0bWwoJzxpIGNsYXNzPVwiZmFzIGZhLWxvY2stb3BlblwiPjwvaT4gYWZyb25kZW4nKTsgLy8ucmVtb3ZlQ2xhc3MoJ2J0bi1kYXJrJykuYWRkQ2xhc3MoJ2J0bi1tZWRpdW0nKTtcbiAgICAgICAgICAgICQoJyNjb21wZXRpdGlvbnMtdGFiID4gYScpLmFkZENsYXNzKCBcImRpc2FibGVkXCIgKTtcbiAgICAgICAgICAgICQoJ3RyLmNvbXBldGl0aW9uLWxvY2tlZCcpLmFkZENsYXNzKCdkLW5vbmUnKTtcbiAgICAgICAgICAgIGVkaXRDb21wZXRpdGlvbnModHJ1ZSk7XG4gICAgICAgIH1cbiAgICAgICAgZWRpdGluZ0NvbXBldGl0aW9ucyA9ICFlZGl0aW5nQ29tcGV0aXRpb25zO1xuICAgIH0pO1xuXG5cbiAgICAkKCcjY29tcGV0aXRpb25zLXRhYicpLm9uKCdzaG93LmJzLnRhYicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIC8vZS50YXJnZXQgLy8gbmV3bHkgYWN0aXZhdGVkIHRhYlxuICAgICAgICAvL2UucmVsYXRlZFRhcmdldCAvLyBwcmV2aW91cyBhY3RpdmUgdGFiXG4gICAgICAgIHNob3dUYWJDb21wZXRpdGlvbnMoZS50YXJnZXQpO1xuICAgIH0pXG5cbn0pXG4iXSwic291cmNlUm9vdCI6IiJ9