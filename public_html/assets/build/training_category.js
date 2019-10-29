(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["training_category"],{

/***/ "./assets/js/training_category.js":
/*!****************************************!*\
  !*** ./assets/js/training_category.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {// Training category
$(document).ready(function () {
  var url = location.href.replace(/\/$/, "");

  if (location.hash) {
    var hash = url.split("#");
    $('#categoryTab a[href="#' + hash[1] + '"]').tab("show");
    $.scrollTo(0, 500); //  } else if (url.endsWith("wedstrijdzwemmers")) {
    //      $('#wedstrijden-tab').tab('show');
  }

  $('a[data-toggle="tab"]').on("click", function () {
    var newUrl;
    var hash = $(this).attr("href");
    newUrl = url.split("#")[0] + hash;
    history.replaceState(null, null, newUrl);
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/training_category.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvdHJhaW5pbmdfY2F0ZWdvcnkuanMiXSwibmFtZXMiOlsiJCIsImRvY3VtZW50IiwicmVhZHkiLCJ1cmwiLCJsb2NhdGlvbiIsImhyZWYiLCJyZXBsYWNlIiwiaGFzaCIsInNwbGl0IiwidGFiIiwic2Nyb2xsVG8iLCJvbiIsIm5ld1VybCIsImF0dHIiLCJoaXN0b3J5IiwicmVwbGFjZVN0YXRlIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQTtBQUNBQSxDQUFDLENBQUNDLFFBQUQsQ0FBRCxDQUFZQyxLQUFaLENBQWtCLFlBQVU7QUFFMUIsTUFBSUMsR0FBRyxHQUFHQyxRQUFRLENBQUNDLElBQVQsQ0FBY0MsT0FBZCxDQUFzQixLQUF0QixFQUE2QixFQUE3QixDQUFWOztBQUVBLE1BQUlGLFFBQVEsQ0FBQ0csSUFBYixFQUFtQjtBQUNmLFFBQU1BLElBQUksR0FBR0osR0FBRyxDQUFDSyxLQUFKLENBQVUsR0FBVixDQUFiO0FBQ0FSLEtBQUMsQ0FBQywyQkFBeUJPLElBQUksQ0FBQyxDQUFELENBQTdCLEdBQWlDLElBQWxDLENBQUQsQ0FBeUNFLEdBQXpDLENBQTZDLE1BQTdDO0FBQ0FULEtBQUMsQ0FBQ1UsUUFBRixDQUFXLENBQVgsRUFBYyxHQUFkLEVBSGUsQ0FJckI7QUFDQTtBQUNHOztBQUVEVixHQUFDLENBQUMsc0JBQUQsQ0FBRCxDQUEwQlcsRUFBMUIsQ0FBNkIsT0FBN0IsRUFBc0MsWUFBVztBQUM3QyxRQUFJQyxNQUFKO0FBQ0EsUUFBTUwsSUFBSSxHQUFHUCxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFhLElBQVIsQ0FBYSxNQUFiLENBQWI7QUFDQUQsVUFBTSxHQUFHVCxHQUFHLENBQUNLLEtBQUosQ0FBVSxHQUFWLEVBQWUsQ0FBZixJQUFvQkQsSUFBN0I7QUFDQU8sV0FBTyxDQUFDQyxZQUFSLENBQXFCLElBQXJCLEVBQTJCLElBQTNCLEVBQWlDSCxNQUFqQztBQUNILEdBTEQ7QUFPRCxDQW5CRCxFIiwiZmlsZSI6InRyYWluaW5nX2NhdGVnb3J5LmpzIiwic291cmNlc0NvbnRlbnQiOlsiLy8gVHJhaW5pbmcgY2F0ZWdvcnlcbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XG5cbiAgbGV0IHVybCA9IGxvY2F0aW9uLmhyZWYucmVwbGFjZSgvXFwvJC8sIFwiXCIpO1xuIFxuICBpZiAobG9jYXRpb24uaGFzaCkge1xuICAgICAgY29uc3QgaGFzaCA9IHVybC5zcGxpdChcIiNcIik7XG4gICAgICAkKCcjY2F0ZWdvcnlUYWIgYVtocmVmPVwiIycraGFzaFsxXSsnXCJdJykudGFiKFwic2hvd1wiKTtcbiAgICAgICQuc2Nyb2xsVG8oMCwgNTAwKTtcbi8vICB9IGVsc2UgaWYgKHVybC5lbmRzV2l0aChcIndlZHN0cmlqZHp3ZW1tZXJzXCIpKSB7XG4vLyAgICAgICQoJyN3ZWRzdHJpamRlbi10YWInKS50YWIoJ3Nob3cnKTtcbiAgfVxuICAgXG4gICQoJ2FbZGF0YS10b2dnbGU9XCJ0YWJcIl0nKS5vbihcImNsaWNrXCIsIGZ1bmN0aW9uKCkge1xuICAgICAgbGV0IG5ld1VybDtcbiAgICAgIGNvbnN0IGhhc2ggPSAkKHRoaXMpLmF0dHIoXCJocmVmXCIpO1xuICAgICAgbmV3VXJsID0gdXJsLnNwbGl0KFwiI1wiKVswXSArIGhhc2g7XG4gICAgICBoaXN0b3J5LnJlcGxhY2VTdGF0ZShudWxsLCBudWxsLCBuZXdVcmwpO1xuICB9KTtcblxufSk7XG4iXSwic291cmNlUm9vdCI6IiJ9