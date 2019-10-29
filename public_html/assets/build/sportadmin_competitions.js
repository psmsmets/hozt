(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["sportadmin_competitions"],{

/***/ "./assets/js/sportadmin_competitions.js":
/*!**********************************************!*\
  !*** ./assets/js/sportadmin_competitions.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

function showTabCompetitions(tab) {
  $('div.competition').removeClass('d-none');

  switch (tab.id) {
    case 'competitions-all-tab':
      break;

    case 'competitions-upcoming-tab':
      $('div.competition-past').addClass('d-none');
      break;
  }
}

$(document).ready(function () {
  $('#competitions-tab').on('show.bs.tab', function (e) {
    //e.target // newly activated tab
    //e.relatedTarget // previous active tab
    showTabCompetitions(e.target);
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/sportadmin_competitions.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275","vendors~carousel~hozt~membership_competitions~membership_preferences~sportadmin_competitions"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvc3BvcnRhZG1pbl9jb21wZXRpdGlvbnMuanMiXSwibmFtZXMiOlsicmVxdWlyZSIsInNob3dUYWJDb21wZXRpdGlvbnMiLCJ0YWIiLCIkIiwicmVtb3ZlQ2xhc3MiLCJpZCIsImFkZENsYXNzIiwiZG9jdW1lbnQiLCJyZWFkeSIsIm9uIiwiZSIsInRhcmdldCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUFBLDREQUFPLENBQUMsZ0VBQUQsQ0FBUDs7QUFFQSxTQUFTQyxtQkFBVCxDQUE2QkMsR0FBN0IsRUFBa0M7QUFDOUJDLEdBQUMsQ0FBQyxpQkFBRCxDQUFELENBQXFCQyxXQUFyQixDQUFpQyxRQUFqQzs7QUFDQSxVQUFPRixHQUFHLENBQUNHLEVBQVg7QUFDSSxTQUFLLHNCQUFMO0FBQ0k7O0FBQ0osU0FBSywyQkFBTDtBQUNJRixPQUFDLENBQUMsc0JBQUQsQ0FBRCxDQUEwQkcsUUFBMUIsQ0FBbUMsUUFBbkM7QUFDQTtBQUxSO0FBT0g7O0FBRURILENBQUMsQ0FBQ0ksUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBVTtBQUV4QkwsR0FBQyxDQUFDLG1CQUFELENBQUQsQ0FBdUJNLEVBQXZCLENBQTBCLGFBQTFCLEVBQXlDLFVBQVVDLENBQVYsRUFBYTtBQUNsRDtBQUNBO0FBQ0FULHVCQUFtQixDQUFDUyxDQUFDLENBQUNDLE1BQUgsQ0FBbkI7QUFDSCxHQUpEO0FBTUgsQ0FSRCxFIiwiZmlsZSI6InNwb3J0YWRtaW5fY29tcGV0aXRpb25zLmpzIiwic291cmNlc0NvbnRlbnQiOlsicmVxdWlyZSgnYm9vdHN0cmFwJyk7XG5cbmZ1bmN0aW9uIHNob3dUYWJDb21wZXRpdGlvbnModGFiKSB7XG4gICAgJCgnZGl2LmNvbXBldGl0aW9uJykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xuICAgIHN3aXRjaCh0YWIuaWQpIHtcbiAgICAgICAgY2FzZSAnY29tcGV0aXRpb25zLWFsbC10YWInOlxuICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgIGNhc2UgJ2NvbXBldGl0aW9ucy11cGNvbWluZy10YWInOlxuICAgICAgICAgICAgJCgnZGl2LmNvbXBldGl0aW9uLXBhc3QnKS5hZGRDbGFzcygnZC1ub25lJyk7XG4gICAgICAgICAgICBicmVhaztcbiAgICB9XG59XG5cbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XG5cbiAgICAkKCcjY29tcGV0aXRpb25zLXRhYicpLm9uKCdzaG93LmJzLnRhYicsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIC8vZS50YXJnZXQgLy8gbmV3bHkgYWN0aXZhdGVkIHRhYlxuICAgICAgICAvL2UucmVsYXRlZFRhcmdldCAvLyBwcmV2aW91cyBhY3RpdmUgdGFiXG4gICAgICAgIHNob3dUYWJDb21wZXRpdGlvbnMoZS50YXJnZXQpO1xuICAgIH0pXG5cbn0pXG4iXSwic291cmNlUm9vdCI6IiJ9