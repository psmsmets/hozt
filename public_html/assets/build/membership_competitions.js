(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["membership_competitions"],{

/***/ "./assets/js/membership_competitions.js":
/*!**********************************************!*\
  !*** ./assets/js/membership_competitions.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

var statusNull = '<i class="fas fa-square text-medium"></i>';
var statusTrue = '<i class="fas fa-check-square text-success" data-value="true"></i>';
var statusFalse = '<i class="fas fa-minus-square text-warning" data-value="false"></i>';

function loadCompetitions() {
  $.getJSON("/api/private/membership/competitions", {
    action: 'load',
    format: "json"
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

function editCompetitions() {
  var edit = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
  $("tr:not(.d-none) td[id^='competition-enrolment-']").each(function () {
    if ($('i', this).attr('data-value') !== undefined) {
      if (edit) {
        $(this).click(function () {
          if ($('i', this).data('value')) {
            $(this).html(statusFalse);
          } else {
            $(this).html(statusTrue);
          }
        });
      } else {
        $(this).unbind();
      }
    }
    /*
            if ($(this).hasClass('competition-editable')) {
                $(this).html(statusTrue);
            } else {
                $(this).html(statusNull);
            }
    */

  });
}

function showTabCompetitions(tab) {
  $('tr.competition').removeClass('d-none');

  switch (tab.id) {
    case 'competitions-all-tab':
      break;

    case 'competitions-new-tab':
      $('tr:not(.competition-new)').addClass('d-none');
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
      $(this).html('<i class="fas fa-edit"></i> bewerken').removeClass('btn-secondary').addClass('btn-medium');
      $('#competitions-tab > a').removeClass("disabled");
      $('tr.competition-locked').removeClass('d-none');
      showTabCompetitions($('#competitions-tab').find('.active')[0]);
      editCompetitions(false);
      loadCompetitions();
    } else {
      $(this).html('<i class="fas fa-save"></i> bewaren').removeClass('btn-medium').addClass('btn-secondary');
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbWVtYmVyc2hpcF9jb21wZXRpdGlvbnMuanMiXSwibmFtZXMiOlsicmVxdWlyZSIsInN0YXR1c051bGwiLCJzdGF0dXNUcnVlIiwic3RhdHVzRmFsc2UiLCJsb2FkQ29tcGV0aXRpb25zIiwiJCIsImdldEpTT04iLCJhY3Rpb24iLCJmb3JtYXQiLCJkb25lIiwiZGF0YSIsInN1Y2Nlc3MiLCJuZXdDb21wZXRpdGlvbnMiLCJlYWNoIiwiaSIsIml0ZW0iLCJ0ZCIsImNvbXBldGl0aW9ucGFydCIsIm1lbWJlciIsImRpc2FibGVkIiwiaHRtbCIsImVucm9sbGVkIiwiZW5yb2xsZWRBdCIsImVkaXRhYmxlIiwiZWRpdENvbXBldGl0aW9ucyIsImVkaXQiLCJhdHRyIiwidW5kZWZpbmVkIiwiY2xpY2siLCJ1bmJpbmQiLCJzaG93VGFiQ29tcGV0aXRpb25zIiwidGFiIiwicmVtb3ZlQ2xhc3MiLCJpZCIsImFkZENsYXNzIiwiZWRpdGluZ0NvbXBldGl0aW9ucyIsImRvY3VtZW50IiwicmVhZHkiLCJoaWRlIiwiZmluZCIsIm9uIiwiZSIsInRhcmdldCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUFBLDREQUFPLENBQUMsZ0VBQUQsQ0FBUDs7QUFHQSxJQUFJQyxVQUFVLEdBQUcsMkNBQWpCO0FBQ0EsSUFBSUMsVUFBVSxHQUFHLG9FQUFqQjtBQUNBLElBQUlDLFdBQVcsR0FBRyxxRUFBbEI7O0FBR0EsU0FBU0MsZ0JBQVQsR0FBNEI7QUFDeEJDLEdBQUMsQ0FBQ0MsT0FBRixDQUFXLHNDQUFYLEVBQW1EO0FBQy9DQyxVQUFNLEVBQUUsTUFEdUM7QUFFL0NDLFVBQU0sRUFBRTtBQUZ1QyxHQUFuRCxFQUlDQyxJQUpELENBSU0sVUFBVUMsSUFBVixFQUFpQjtBQUNuQixRQUFJQSxJQUFJLENBQUNDLE9BQVQsRUFBa0I7QUFDZCxVQUFJQyxlQUFlLEdBQUcsQ0FBdEI7QUFDQVAsT0FBQyxDQUFDUSxJQUFGLENBQU9ILElB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Q0FBRCxDQUEyQjJCLFdBQTNCLENBQXdDLFVBQXhDO0FBQ0EzQixPQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQjJCLFdBQTNCLENBQXVDLFFBQXZDO0FBQ0FGLHlCQUFtQixDQUFDekIsQ0FBQyxDQUFDLG1CQUFELENBQUQsQ0FBdUJrQyxJQUF2QixDQUE0QixTQUE1QixFQUF1QyxDQUF2QyxDQUFELENBQW5CO0FBQ0FmLHNCQUFnQixDQUFDLEtBQUQsQ0FBaEI7QUFDQXBCLHNCQUFnQjtBQUNuQixLQVBELE1BT087QUFDSEMsT0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRZSxJQUFSLENBQWEscUNBQWIsRUFBb0RZLFdBQXBELENBQWdFLFlBQWhFLEVBQThFRSxRQUE5RSxDQUF1RixlQUF2RjtBQUNBN0IsT0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkI2QixRQUEzQixDQUFxQyxVQUFyQztBQUNBN0IsT0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkI2QixRQUEzQixDQUFvQyxRQUFwQztBQUNBVixzQkFBZ0IsQ0FBQyxJQUFELENBQWhCO0FBQ0g7O0FBQ0RXLHVCQUFtQixHQUFHLENBQUNBLG1CQUF2QjtBQUNILEdBZkQ7QUFrQkE5QixHQUFDLENBQUMsbUJBQUQsQ0FBRCxDQUF1Qm1DLEVBQXZCLENBQTBCLGFBQTFCLEVBQXlDLFVBQVVDLENBQVYsRUFBYTtBQUNsRDtBQUNBO0FBQ0FYLHVCQUFtQixDQUFDVyxDQUFDLENBQUNDLE1BQUgsQ0FBbkI7QUFDSCxHQUpEO0FBTUgsQ0E1QkQsRSIsImZpbGUiOiJtZW1iZXJzaGlwX2NvbXBldGl0aW9ucy5qcyIsInNvdXJjZXNDb250ZW50IjpbInJlcXVpcmUoJ2Jvb3RzdHJhcCcpO1xuXG5cbnZhciBzdGF0dXNOdWxsID0gJzxpIGNsYXNzPVwiZmFzIGZhLXNxdWFyZSB0ZXh0LW1lZGl1bVwiPjwvaT4nO1xudmFyIHN0YXR1c1RydWUgPSAnPGkgY2xhc3M9XCJmYXMgZmEtY2hlY2stc3F1YXJlIHRleHQtc3VjY2Vzc1wiIGRhdGEtdmFsdWU9XCJ0cnVlXCI+PC9pPic7XG52YXIgc3RhdHVzRmFsc2UgPSAnPGkgY2xhc3M9XCJmYXMgZmEtbWludXMtc3F1YXJlIHRleHQtd2FybmluZ1wiIGRhdGEtdmFsdWU9XCJmYWxzZVwiPjwvaT4nO1xuXG5cbmZ1bmN0aW9uIGxvYWRDb21wZXRpdGlvbnMoKSB7XG4gICAgJC5nZXRKU09OKCBcIi9hcGkvcHJpdmF0ZS9tZW1iZXJzaGlwL2NvbXBldGl0aW9uc1wiLCB7XG4gICAgICAgIGFjdGlvbjogJ2xvYWQnLFxuICAgICAgICBmb3JtYXQ6IFwianNvblwiLFxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGRhdGEgKSB7XG4gICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MpIHtcbiAgICAgICAgICAgIHZhciBuZXdDb21wZXRpdGlvbnMgPSAwO1xuICAgICAgICAgICAgJC5lYWNoKGRhdGEuZGF0YSwgZnVuY3Rpb24oaSwgaXRlbSkge1xuICAgICAgICAgICAgICAgIHZhciB0ZCA9ICQoJyNjb21wZXRpdGlvbi1lbnJvbG1lbnQtJytpdGVtLmNvbXBldGl0aW9ucGFydCsnLScraXRlbS5tZW1iZXIpO1xuICAgICAgICAgICAgICAgIGlmIChpdGVtLmRpc2FibGVkKSB7XG4gICAgICAgICAgICAgICAgICAgICQodGQpLmh0bWwoIHN0YXR1c051bGwgKTtcbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKGl0ZW0uZW5yb2xsZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgJCh0ZCkuaHRtbCggc3RhdHVzVHJ1ZSApO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICQodGQpLmh0bWwoIHN0YXR1c0ZhbHNlICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGlmICghaXRlbS5lbnJvbGxlZEF0ICYmIGl0ZW0uZWRpdGFibGUpIG5ld0NvbXBldGl0aW9ucyA9IG5ld0NvbXBldGl0aW9ucyArIDE7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIGlmIChuZXdDb21wZXRpdGlvbnMpICQoJyNjb21wZXRpdGlvbnMtbmV3LXRhYiBzcGFuJykuaHRtbChuZXdDb21wZXRpdGlvbnMpO1xuICAgICAgICB9XG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIGVkaXRDb21wZXRpdGlvbnMoZWRpdD1mYWxzZSkge1xuICAgICQoXCJ0cjpub3QoLmQtbm9uZSkgdGRbaWRePSdjb21wZXRpdGlvbi1lbnJvbG1lbnQtJ11cIikuZWFjaCggZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICgkKCdpJyx0aGlzKS5hdHRyKCdkYXRhLXZhbHVlJykhPT11bmRlZmluZWQpIHtcbiAgICAgICAgICAgIGlmIChlZGl0KSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5jbGljayggZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGlmICgkKCdpJyx0aGlzKS5kYXRhKCd2YWx1ZScpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAkKHRoaXMpLmh0bWwoc3RhdHVzRmFsc2UpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgJCh0aGlzKS5odG1sKHN0YXR1c1RydWUpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICQodGhpcykudW5iaW5kKCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbi8qXG4gICAgICAgIGlmICgkKHRoaXMpLmhhc0NsYXNzKCdjb21wZXRpdGlvbi1lZGl0YWJsZScpKSB7XG4gICAgICAgICAgICAkKHRoaXMpLmh0bWwoc3RhdHVzVHJ1ZSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKHRoaXMpLmh0bWwoc3RhdHVzTnVsbCk7XG4gICAgICAgIH1cbiovXG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIHNob3dUYWJDb21wZXRpdGlvbnModGFiKSB7XG4gICAgJCgndHIuY29tcGV0aXRpb24nKS5yZW1vdmVDbGFzcygnZC1ub25lJyk7XG4gICAgc3dpdGNoKHRhYi5pZCkge1xuICAgICAgICBjYXNlICdjb21wZXRpdGlvbnMtYWxsLXRhYic6XG4gICAgICAgICAgICBicmVhaztcbiAgICAgICAgY2FzZSAnY29tcGV0aXRpb25zLW5ldy10YWInOlxuICAgICAgICAgICAgJCgndHI6bm90KC5jb21wZXRpdGlvbi1uZXcpJykuYWRkQ2xhc3MoJ2Qtbm9uZScpO1xuICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgIGNhc2UgJ2NvbXBldGl0aW9ucy11cGNvbWluZy10YWInOlxuICAgICAgICAgICAgJCgndHIuY29tcGV0aXRpb24tcGFzdCcpLmFkZENsYXNzKCdkLW5vbmUnKTtcbiAgICAgICAgICAgIGJyZWFrO1xuICAgIH1cbn1cblxuLy8gb24gcGFnZWxvYWRcbmxvYWRDb21wZXRpdGlvbnMoKTtcblxudmFyIGVkaXRpbmdDb21wZXRpdGlvbnMgPSBmYWxzZTtcblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcblxuICAgICQoJy5jb21wZXRpdGlvbi1wYXN0JykuaGlkZSgpO1xuXG4gICAgJCgnI2NvbXBldGl0aW9ucy1lZGl0JykuY2xpY2soIGZ1bmN0aW9uKCkge1xuICAgICAgICBpZiAoZWRpdGluZ0NvbXBldGl0aW9ucykge1xuICAgICAgICAgICAgJCh0aGlzKS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS1lZGl0XCI+PC9pPiBiZXdlcmtlbicpLnJlbW92ZUNsYXNzKCdidG4tc2Vjb25kYXJ5JykuYWRkQ2xhc3MoJ2J0bi1tZWRpdW0nKTsgXG4gICAgICAgICAgICAkKCcjY29tcGV0aXRpb25zLXRhYiA+IGEnKS5yZW1vdmVDbGFzcyggXCJkaXNhYmxlZFwiICk7XG4gICAgICAgICAgICAkKCd0ci5jb21wZXRpdGlvbi1sb2NrZWQnKS5yZW1vdmVDbGFzcygnZC1ub25lJyk7XG4gICAgICAgICAgICBzaG93VGFiQ29tcGV0aXRpb25zKCQoJyNjb21wZXRpdGlvbnMtdGFiJykuZmluZCgnLmFjdGl2ZScpWzBdKTtcbiAgICAgICAgICAgIGVkaXRDb21wZXRpdGlvbnMoZmFsc2UpO1xuICAgICAgICAgICAgbG9hZENvbXBldGl0aW9ucygpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJCh0aGlzKS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS1zYXZlXCI+PC9pPiBiZXdhcmVuJykucmVtb3ZlQ2xhc3MoJ2J0bi1tZWRpdW0nKS5hZGRDbGFzcygnYnRuLXNlY29uZGFyeScpO1xuICAgICAgICAgICAgJCgnI2NvbXBldGl0aW9ucy10YWIgPiBhJykuYWRkQ2xhc3MoIFwiZGlzYWJsZWRcIiApO1xuICAgICAgICAgICAgJCgndHIuY29tcGV0aXRpb24tbG9ja2VkJykuYWRkQ2xhc3MoJ2Qtbm9uZScpO1xuICAgICAgICAgICAgZWRpdENvbXBldGl0aW9ucyh0cnVlKTtcbiAgICAgICAgfVxuICAgICAgICBlZGl0aW5nQ29tcGV0aXRpb25zID0gIWVkaXRpbmdDb21wZXRpdGlvbnM7XG4gICAgfSk7XG5cblxuICAgICQoJyNjb21wZXRpdGlvbnMtdGFiJykub24oJ3Nob3cuYnMudGFiJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgLy9lLnRhcmdldCAvLyBuZXdseSBhY3RpdmF0ZWQgdGFiXG4gICAgICAgIC8vZS5yZWxhdGVkVGFyZ2V0IC8vIHByZXZpb3VzIGFjdGl2ZSB0YWJcbiAgICAgICAgc2hvd1RhYkNvbXBldGl0aW9ucyhlLnRhcmdldCk7XG4gICAgfSlcblxufSlcbiJdLCJzb3VyY2VSb290IjoiIn0=