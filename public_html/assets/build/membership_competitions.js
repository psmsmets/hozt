(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["membership_competitions"],{

/***/ "./assets/js/membership_competitions.js":
/*!**********************************************!*\
  !*** ./assets/js/membership_competitions.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

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

},[["./assets/js/membership_competitions.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275","vendors~carousel~hozt~membership_competitions~membership_preferences~sportadmin_competitions"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbWVtYmVyc2hpcF9jb21wZXRpdGlvbnMuanMiXSwibmFtZXMiOlsicmVxdWlyZSIsInN0YXR1c051bGwiLCJzdGF0dXNUcnVlIiwic3RhdHVzRmFsc2UiLCJsb2FkQ29tcGV0aXRpb25zIiwiJCIsImdldEpTT04iLCJmb3JtYXQiLCJhY3Rpb24iLCJkb25lIiwiZGF0YSIsInN1Y2Nlc3MiLCJuZXdDb21wZXRpdGlvbnMiLCJlYWNoIiwiaSIsIml0ZW0iLCJ0ZCIsImNvbXBldGl0aW9ucGFydCIsIm1lbWJlciIsImRpc2FibGVkIiwiaHRtbCIsImVucm9sbGVkIiwiZW5yb2xsZWRBdCIsImVkaXRhYmxlIiwiZWRpdENvbXBldGl0aW9uIiwiZWxlbWVudCIsImhhc0NsYXNzIiwiYWRkQ2xhc3MiLCJpZCIsInNwbGl0IiwiY29tcGV0aXRpb24iLCJwYXJ0IiwiY29tcGV0aXRpb25QYXJ0IiwicmVtb3ZlQ2xhc3MiLCJlZGl0Q29tcGV0aXRpb25zIiwiZWRpdCIsImF0dHIiLCJ1bmRlZmluZWQiLCJjbGljayIsInVuYmluZCIsInNob3dUYWJDb21wZXRpdGlvbnMiLCJ0YWIiLCJlZGl0aW5nQ29tcGV0aXRpb25zIiwiZG9jdW1lbnQiLCJyZWFkeSIsImZpbmQiLCJvbiIsImUiLCJ0YXJnZXQiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUFBLG1CQUFPLENBQUMsZ0VBQUQsQ0FBUDs7QUFHQSxJQUFJQyxVQUFVLEdBQUcsOENBQWpCO0FBQ0EsSUFBSUMsVUFBVSxHQUFHLGdHQUFqQjtBQUNBLElBQUlDLFdBQVcsR0FBRyw0R0FBbEI7O0FBRUEsU0FBU0MsZ0JBQVQsR0FBNEI7QUFDeEJDLEdBQUMsQ0FBQ0MsT0FBRixDQUFXLHNDQUFYLEVBQW1EO0FBQy9DQyxVQUFNLEVBQUUsTUFEdUM7QUFFL0NDLFVBQU0sRUFBRTtBQUZ1QyxHQUFuRCxFQUlDQyxJQUpELENBSU0sVUFBVUMsSUFBVixFQUFpQjtBQUNu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Q0E5QixzQkFBZ0I7QUFDbkIsS0FQRCxNQU9PO0FBQ0hDLE9BQUMsQ0FBQyxJQUFELENBQUQsQ0FBUWUsSUFBUixDQUFhLDJDQUFiLEVBREcsQ0FDd0Q7O0FBQzNEZixPQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQnNCLFFBQTNCLENBQXFDLFVBQXJDO0FBQ0F0QixPQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQnNCLFFBQTNCLENBQW9DLFFBQXBDO0FBQ0FPLHNCQUFnQixDQUFDLElBQUQsQ0FBaEI7QUFDSDs7QUFDRFEsdUJBQW1CLEdBQUcsQ0FBQ0EsbUJBQXZCO0FBQ0gsR0FmRDtBQWtCQXJDLEdBQUMsQ0FBQyxtQkFBRCxDQUFELENBQXVCeUMsRUFBdkIsQ0FBMEIsYUFBMUIsRUFBeUMsVUFBVUMsQ0FBVixFQUFhO0FBQ2xEO0FBQ0E7QUFDQVAsdUJBQW1CLENBQUNPLENBQUMsQ0FBQ0MsTUFBSCxDQUFuQjtBQUNILEdBSkQ7QUFNSCxDQTFCRCxFIiwiZmlsZSI6Im1lbWJlcnNoaXBfY29tcGV0aXRpb25zLmpzIiwic291cmNlc0NvbnRlbnQiOlsicmVxdWlyZSgnYm9vdHN0cmFwJyk7XG5cblxudmFyIHN0YXR1c051bGwgPSAnPGkgY2xhc3M9XCJmYXMgZmEtc3F1YXJlIHRleHQtbWVkaXVtIGg0XCI+PC9pPic7XG52YXIgc3RhdHVzVHJ1ZSA9ICc8YnV0dG9uIGNsYXNzPVwiYnRuIGJ0bi1zdWNjZXNzIGJ0bi1zbVwiPjxpIGNsYXNzPVwiZmFzIGZhLWNoZWNrXCIgZGF0YS12YWx1ZT1cInRydWVcIj48L2k+PC9idXR0b24+JztcbnZhciBzdGF0dXNGYWxzZSA9ICc8YnV0dG9uIGNsYXNzPVwiYnRuIGJ0bi13YXJuaW5nIGJ0bi1zbSB0ZXh0LWxpZ2h0XCI+PGkgY2xhc3M9XCJmYXMgZmEtbWludXNcIiBkYXRhLXZhbHVlPVwiZmFsc2VcIj48L2k+PC9idXR0b24+JztcblxuZnVuY3Rpb24gbG9hZENvbXBldGl0aW9ucygpIHtcbiAgICAkLmdldEpTT04oIFwiL2FwaS9wcml2YXRlL21lbWJlcnNoaXAvY29tcGV0aXRpb25zXCIsIHtcbiAgICAgICAgZm9ybWF0OiBcImpzb25cIixcbiAgICAgICAgYWN0aW9uOiAnbG9hZCcsXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggZGF0YSApIHtcbiAgICAgICAgaWYgKGRhdGEuc3VjY2Vzcykge1xuICAgICAgICAgICAgdmFyIG5ld0NvbXBldGl0aW9ucyA9IDA7XG4gICAgICAgICAgICAkLmVhY2goZGF0YS5kYXRhLCBmdW5jdGlvbihpLCBpdGVtKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRkID0gJCgnI2NvbXBldGl0aW9uLWVucm9sbWVudC0nK2l0ZW0uY29tcGV0aXRpb25wYXJ0KyctJytpdGVtLm1lbWJlcik7XG4gICAgICAgICAgICAgICAgaWYgKGl0ZW0uZGlzYWJsZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgJCh0ZCkuaHRtbCggc3RhdHVzTnVsbCApO1xuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoaXRlbS5lbnJvbGxlZCkge1xuICAgICAgICAgICAgICAgICAgICAkKHRkKS5odG1sKCBzdGF0dXNUcnVlICk7XG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgJCh0ZCkuaHRtbCggc3RhdHVzRmFsc2UgKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgaWYgKCFpdGVtLmVucm9sbGVkQXQgJiYgaXRlbS5lZGl0YWJsZSkgbmV3Q29tcGV0aXRpb25zID0gbmV3Q29tcGV0aXRpb25zICsgMTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgaWYgKG5ld0NvbXBldGl0aW9ucykgJCgnI2NvbXBldGl0aW9ucy1uZXctdGFiIHNwYW4nKS5odG1sKG5ld0NvbXBldGl0aW9ucyk7XG4gICAgICAgIH1cbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gZWRpdENvbXBldGl0aW9uKGVsZW1lbnQpIHtcbiAgICBpZiAoJChlbGVtZW50KS5oYXNDbGFzcygnZWRpdGluZycpKSByZXR1cm47XG4gICAgJChlbGVtZW50KS5hZGRDbGFzcygnZWRpdGluZycpO1xuXG4gICAgdmFyIFtjb21wZXRpdGlvbiwgcGFydCwgY29tcGV0aXRpb25QYXJ0LCBtZW1iZXJdID0gZWxlbWVudC5pZC5zcGxpdCgnLScpO1xuICAgIHZhciBlbnJvbGxlZCA9ICEkKCdpJyxlbGVtZW50KS5kYXRhKCd2YWx1ZScpO1xuXG4gICAgJC5nZXRKU09OKCBcIi9hcGkvcHJpdmF0ZS9tZW1iZXJzaGlwL2NvbXBldGl0aW9uc1wiLCB7XG4gICAgICAgIGZvcm1hdDogXCJqc29uXCIsXG4gICAgICAgIGFjdGlvbjogJ2VkaXQnLFxuICAgICAgICBjb21wZXRpdGlvbnBhcnQ6IGNvbXBldGl0aW9uUGFydCxcbiAgICAgICAgbWVtYmVyOiBtZW1iZXIsXG4gICAgICAgIGVucm9sbGVkOiBlbnJvbGxlZCA/IDEgOiAwLFxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGRhdGEgKSB7XG4gICAgICAgIGlmIChlbnJvbGxlZCkge1xuICAgICAgICAgICAgJChlbGVtZW50KS5odG1sKHN0YXR1c1RydWUpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJChlbGVtZW50KS5odG1sKHN0YXR1c0ZhbHNlKTtcbiAgICAgICAgfVxuICAgICAgICAkKGVsZW1lbnQpLnJlbW92ZUNsYXNzKCdlZGl0aW5nJyk7XG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIGVkaXRDb21wZXRpdGlvbnMoZWRpdD1mYWxzZSkge1xuICAgICQoXCJ0cjpub3QoLmQtbm9uZSkgdGRbaWRePSdjb21wZXRpdGlvbi1lbnJvbG1lbnQtJ11cIikuZWFjaCggZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICgkKCdpJyx0aGlzKS5hdHRyKCdkYXRhLXZhbHVlJykhPT11bmRlZmluZWQpIHtcbiAgICAgICAgICAgIGlmIChlZGl0KSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5jbGljayggZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGVkaXRDb21wZXRpdGlvbih0aGlzKTtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS51bmJpbmQoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBzaG93VGFiQ29tcGV0aXRpb25zKHRhYikge1xuICAgICQoJ3RyLmNvbXBldGl0aW9uJykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xuICAgIHN3aXRjaCh0YWIuaWQpIHtcbiAgICAgICAgY2FzZSAnY29tcGV0aXRpb25zLWFsbC10YWInOlxuICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgIGNhc2UgJ2NvbXBldGl0aW9ucy1uZXctdGFiJzpcbiAgICAgICAgICAgICQoJ3RyLmNvbXBldGl0aW9uJykuYWRkQ2xhc3MoJ2Qtbm9uZScpO1xuICAgICAgICAgICAgJCgndHIuY29tcGV0aXRpb24tbmV3JykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xuICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgIGNhc2UgJ2NvbXBldGl0aW9ucy11cGNvbWluZy10YWInOlxuICAgICAgICAgICAgJCgndHIuY29tcGV0aXRpb24tcGFzdCcpLmFkZENsYXNzKCdkLW5vbmUnKTtcbiAgICAgICAgICAgIGJyZWFrO1xuICAgIH1cbn1cblxuLy8gb24gcGFnZWxvYWRcbmxvYWRDb21wZXRpdGlvbnMoKTtcblxudmFyIGVkaXRpbmdDb21wZXRpdGlvbnMgPSBmYWxzZTtcblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcblxuICAgICQoJyNjb21wZXRpdGlvbnMtZWRpdCcpLmNsaWNrKCBmdW5jdGlvbigpIHtcbiAgICAgICAgaWYgKGVkaXRpbmdDb21wZXRpdGlvbnMpIHtcbiAgICAgICAgICAgICQodGhpcykuaHRtbCgnPGkgY2xhc3M9XCJmYXMgZmEtbG9ja1wiPjwvaT4gYmV3ZXJrZW4nKTsgLy8ucmVtb3ZlQ2xhc3MoJ2J0bi1tZWRpdW0nKS5hZGRDbGFzcygnYnRuLWRhcmsnKTsgXG4gICAgICAgICAgICAkKCcjY29tcGV0aXRpb25zLXRhYiA+IGEnKS5yZW1vdmVDbGFzcyggXCJkaXNhYmxlZFwiICk7XG4gICAgICAgICAgICAkKCd0ci5jb21wZXRpdGlvbi1sb2NrZWQnKS5yZW1vdmVDbGFzcygnZC1ub25lJyk7XG4gICAgICAgICAgICBzaG93VGFiQ29tcGV0aXRpb25zKCQoJyNjb21wZXRpdGlvbnMtdGFiJykuZmluZCgnLmFjdGl2ZScpWzBdKTtcbiAgICAgICAgICAgIGVkaXRDb21wZXRpdGlvbnMoZmFsc2UpO1xuICAgICAgICAgICAgbG9hZENvbXBldGl0aW9ucygpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCh0aGlzKS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS1sb2NrLW9wZW5cIj48L2k+IGFmcm9uZGVuJyk7IC8vLnJlbW92ZUNsYXNzKCdidG4tZGFyaycpLmFkZENsYXNzKCdidG4tbWVkaXVtJyk7XG4gICAgICAgICAgICAkKCcjY29tcGV0aXRpb25zLXRhYiA+IGEnKS5hZGRDbGFzcyggXCJkaXNhYmxlZFwiICk7XG4gICAgICAgICAgICAkKCd0ci5jb21wZXRpdGlvbi1sb2NrZWQnKS5hZGRDbGFzcygnZC1ub25lJyk7XG4gICAgICAgICAgICBlZGl0Q29tcGV0aXRpb25zKHRydWUpO1xuICAgICAgICB9XG4gICAgICAgIGVkaXRpbmdDb21wZXRpdGlvbnMgPSAhZWRpdGluZ0NvbXBldGl0aW9ucztcbiAgICB9KTtcblxuXG4gICAgJCgnI2NvbXBldGl0aW9ucy10YWInKS5vbignc2hvdy5icy50YWInLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAvL2UudGFyZ2V0IC8vIG5ld2x5IGFjdGl2YXRlZCB0YWJcbiAgICAgICAgLy9lLnJlbGF0ZWRUYXJnZXQgLy8gcHJldmlvdXMgYWN0aXZlIHRhYlxuICAgICAgICBzaG93VGFiQ29tcGV0aXRpb25zKGUudGFyZ2V0KTtcbiAgICB9KVxuXG59KVxuIl0sInNvdXJjZVJvb3QiOiIifQ==