(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["sportadmin_competition"],{

/***/ "./assets/js/sportadmin_competition.js":
/*!*********************************************!*\
  !*** ./assets/js/sportadmin_competition.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {//require('bootstrap');
var statusNull = '<i class="fas fa-square text-medium h4"></i>';
var statusTrue = '<i class="fas fa-check-square text-success" data-value="true"></i>';
var statusFalse = '<i class="fas fa-minus-square text-warning" data-value="false"></i>';

function loadCompetitionEnrolments(id) {
  $.getJSON("/api/private/sportadmin/competition/" + id).done(function (data) {
    if (data.success) {
      $.each(data.data, function (i, item) {
        var td = $('#competition-enrolment-' + item.competitionpart + '-' + item.member);

        if (item.enabled) {
          if (item.enrolled) {
            $(td).html(statusTrue);
          } else {
            $(td).html(statusFalse);
          }

          td.closest('tr').removeClass('competition-disabled');

          if (!item.enrolledAt) {
            td.addClass('table-active');
          }
        } else {
          $(td).html(statusNull);
        }
      });
    }
  }).fail(function () {
    $('#competition-enrolments-error').removeClass('d-none');
  });
} // on pageload


loadCompetitionEnrolments($('#competition-enrolments').data('competition'));
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/sportadmin_competition.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvc3BvcnRhZG1pbl9jb21wZXRpdGlvbi5qcyJdLCJuYW1lcyI6WyJzdGF0dXNOdWxsIiwic3RhdHVzVHJ1ZSIsInN0YXR1c0ZhbHNlIiwibG9hZENvbXBldGl0aW9uRW5yb2xtZW50cyIsImlkIiwiJCIsImdldEpTT04iLCJkb25lIiwiZGF0YSIsInN1Y2Nlc3MiLCJlYWNoIiwiaSIsIml0ZW0iLCJ0ZCIsImNvbXBldGl0aW9ucGFydCIsIm1lbWJlciIsImVuYWJsZWQiLCJlbnJvbGxlZCIsImh0bWwiLCJjbG9zZXN0IiwicmVtb3ZlQ2xhc3MiLCJlbnJvbGxlZEF0IiwiYWRkQ2xhc3MiLCJmYWlsIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQTtBQUVBLElBQUlBLFVBQVUsR0FBRyw4Q0FBakI7QUFDQSxJQUFJQyxVQUFVLEdBQUcsb0VBQWpCO0FBQ0EsSUFBSUMsV0FBVyxHQUFHLHFFQUFsQjs7QUFFQSxTQUFTQyx5QkFBVCxDQUFtQ0MsRUFBbkMsRUFBdUM7QUFDbkNDLEdBQUMsQ0FBQ0MsT0FBRixDQUFXLHlDQUF1Q0YsRUFBbEQsRUFDQ0csSUFERCxDQUNNLFVBQVVDLElBQVYsRUFBaUI7QUFDbkIsUUFBSUEsSUFBSSxDQUFDQyxPQUFULEVBQWtCO0FBQ2RKLE9BQUMsQ0FBQ0ssSUFBRixDQUFPRixJQUFJLENBQUNBLElBQVosRUFBa0IsVUFBU0csQ0FBVCxFQUFZQyxJQUFaLEVBQWtCO0FBQ2hDLFlBQUlDLEVBQUUsR0FBR1IsQ0FBQyxDQUFDLDRCQUEwQk8sSUFBSSxDQUFDRSxlQUEvQixHQUErQyxHQUEvQyxHQUFtREYsSUFBSSxDQUFDRyxNQUF6RCxDQUFWOztBQUNBLFlBQUlILElBQUksQ0FBQ0ksT0FBVCxFQUFrQjtBQUNkLGNBQUlKLElBQUksQ0FBQ0ssUUFBVCxFQUFtQjtBQUNmWixhQUFDLENBQUNRLEVBQUQsQ0FBRCxDQUFNSyxJQUFOLENBQVlqQixVQUFaO0FBQ0gsV0FGRCxNQUVPO0FBQ0hJLGFBQUMsQ0FBQ1EsRUFBRCxDQUFELENBQU1LLElBQU4sQ0FBWWhCLFdBQVo7QUFDSDs7QUFDRFcsWUFBRSxDQUFDTSxPQUFILENBQVcsSUFBWCxFQUFpQkMsV0FBakIsQ0FBNkIsc0JBQTdCOztBQUNBLGNBQUksQ0FBQ1IsSUFBSSxDQUFDUyxVQUFWLEVBQXNCO0FBQ2xCUixjQUFFLENBQUNTLFFBQUgsQ0FBWSxjQUFaO0FBQ0g7QUFDSixTQVZELE1BVU87QUFDSGpCLFdBQUMsQ0FBQ1EsRUFBRCxDQUFELENBQU1LLElBQU4sQ0FBWWxCLFVBQVo7QUFDSDtBQUNKLE9BZkQ7QUFnQkg7QUFDSixHQXBCRCxFQW9CR3VCLElBcEJILENBb0JRLFlBQVc7QUFDZmxCLEtBQUMsQ0FBQywrQkFBRCxDQUFELENBQW1DZSxXQUFuQyxDQUErQyxRQUEvQztBQUNILEdBdEJEO0FBdUJILEMsQ0FFRDs7O0FBQ0FqQix5QkFBeUIsQ0FBQ0UsQ0FBQyxDQUFDLHlCQUFELENBQUQsQ0FBNkJHLElBQTdCLENBQWtDLGFBQWxDLENBQUQsQ0FBekIsQyIsImZpbGUiOiJzcG9ydGFkbWluX2NvbXBldGl0aW9uLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLy9yZXF1aXJlKCdib290c3RyYXAnKTtcblxudmFyIHN0YXR1c051bGwgPSAnPGkgY2xhc3M9XCJmYXMgZmEtc3F1YXJlIHRleHQtbWVkaXVtIGg0XCI+PC9pPic7XG52YXIgc3RhdHVzVHJ1ZSA9ICc8aSBjbGFzcz1cImZhcyBmYS1jaGVjay1zcXVhcmUgdGV4dC1zdWNjZXNzXCIgZGF0YS12YWx1ZT1cInRydWVcIj48L2k+JztcbnZhciBzdGF0dXNGYWxzZSA9ICc8aSBjbGFzcz1cImZhcyBmYS1taW51cy1zcXVhcmUgdGV4dC13YXJuaW5nXCIgZGF0YS12YWx1ZT1cImZhbHNlXCI+PC9pPic7XG5cbmZ1bmN0aW9uIGxvYWRDb21wZXRpdGlvbkVucm9sbWVudHMoaWQpIHtcbiAgICAkLmdldEpTT04oIFwiL2FwaS9wcml2YXRlL3Nwb3J0YWRtaW4vY29tcGV0aXRpb24vXCIraWQgKVxuICAgIC5kb25lKGZ1bmN0aW9uKCBkYXRhICkge1xuICAgICAgICBpZiAoZGF0YS5zdWNjZXNzKSB7XG4gICAgICAgICAgICAkLmVhY2goZGF0YS5kYXRhLCBmdW5jdGlvbihpLCBpdGVtKSB7XG4gICAgICAgICAgICAgICAgdmFyIHRkID0gJCgnI2NvbXBldGl0aW9uLWVucm9sbWVudC0nK2l0ZW0uY29tcGV0aXRpb25wYXJ0KyctJytpdGVtLm1lbWJlcik7XG4gICAgICAgICAgICAgICAgaWYgKGl0ZW0uZW5hYmxlZCkge1xuICAgICAgICAgICAgICAgICAgICBpZiAoaXRlbS5lbnJvbGxlZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgJCh0ZCkuaHRtbCggc3RhdHVzVHJ1ZSApO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgJCh0ZCkuaHRtbCggc3RhdHVzRmFsc2UgKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB0ZC5jbG9zZXN0KCd0cicpLnJlbW92ZUNsYXNzKCdjb21wZXRpdGlvbi1kaXNhYmxlZCcpO1xuICAgICAgICAgICAgICAgICAgICBpZiAoIWl0ZW0uZW5yb2xsZWRBdCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgdGQuYWRkQ2xhc3MoJ3RhYmxlLWFjdGl2ZScpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgJCh0ZCkuaHRtbCggc3RhdHVzTnVsbCApO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfSkuZmFpbChmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnI2NvbXBldGl0aW9uLWVucm9sbWVudHMtZXJyb3InKS5yZW1vdmVDbGFzcygnZC1ub25lJyk7XG4gICAgfSk7XG59XG5cbi8vIG9uIHBhZ2Vsb2FkXG5sb2FkQ29tcGV0aXRpb25FbnJvbG1lbnRzKCQoJyNjb21wZXRpdGlvbi1lbnJvbG1lbnRzJykuZGF0YSgnY29tcGV0aXRpb24nKSk7XG4iXSwic291cmNlUm9vdCI6IiJ9