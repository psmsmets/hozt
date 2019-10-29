(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["form_extended"],{

/***/ "./assets/js/form_extended.js":
/*!************************************!*\
  !*** ./assets/js/form_extended.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {function initSubmit() {
  $('#submit').prop('disabled', false);
  $("#submit").html('<i class="fas fa-paper-plane"></i> Verzend');
} // Disabling form submissions if there are invalid fields


(function () {
  'use strict';

  window.addEventListener('load', function () {
    // Append to form
    $(".needs-validation").append('<div class="form-group row pt-3"><div class="col-sm-10"><button type="submit" class="btn btn-primary" id="submit" value="Send"></button><small id="submitHelp" class="form-text text-muted d-none">Gelieve de pagina <strong>niet</strong> te herladen tijdens het verzenden.</small></div></div>'); // Set submit button

    initSubmit(); // Replace label by href 

    $("label[for$='_form_terms']").html("Ik heb het <a href=\"/privacy\">privacybeleid</a> gelezen en ga hiermee akkoord."); // Bootstrap custom-select fix (attribute ends with)

    $('select').addClass('custom-select'); // Fetch all the forms we want to apply custom Bootstrap validation styles to

    var forms = document.getElementsByClassName('needs-validation'); // Loop over them and prevent submission

    var validation = Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        $('#submit').prop('disabled', 'disabled');
        $('#submit').html('<i class="fas fa-sync-alt"></i> Verwerken');
        $('#submitHelp').removeClass("d-none");

        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          initSubmit();
        }

        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/form_extended.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZm9ybV9leHRlbmRlZC5qcyJdLCJuYW1lcyI6WyJpbml0U3VibWl0IiwiJCIsInByb3AiLCJodG1sIiwid2luZG93IiwiYWRkRXZlbnRMaXN0ZW5lciIsImFwcGVuZCIsImFkZENsYXNzIiwiZm9ybXMiLCJkb2N1bWVudCIsImdldEVsZW1lbnRzQnlDbGFzc05hbWUiLCJ2YWxpZGF0aW9uIiwiQXJyYXkiLCJwcm90b3R5cGUiLCJmaWx0ZXIiLCJjYWxsIiwiZm9ybSIsImV2ZW50IiwicmVtb3ZlQ2xhc3MiLCJjaGVja1ZhbGlkaXR5IiwicHJldmVudERlZmF1bHQiLCJzdG9wUHJvcGFnYXRpb24iLCJjbGFzc0xpc3QiLCJhZGQiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBLGtEQUFTQSxVQUFULEdBQXNCO0FBQ25CQyxHQUFDLENBQUMsU0FBRCxDQUFELENBQWFDLElBQWIsQ0FBa0IsVUFBbEIsRUFBOEIsS0FBOUI7QUFDQUQsR0FBQyxDQUFDLFNBQUQsQ0FBRCxDQUFhRSxJQUFiLENBQWtCLDRDQUFsQjtBQUNGLEMsQ0FFRDs7O0FBQ0EsQ0FBQyxZQUFXO0FBQ1Y7O0FBQ0FDLFFBQU0sQ0FBQ0MsZ0JBQVAsQ0FBd0IsTUFBeEIsRUFBZ0MsWUFBVztBQUN6QztBQUNBSixLQUFDLENBQUMsbUJBQUQsQ0FBRCxDQUF1QkssTUFBdkIsQ0FBOEIsbVNBQTlCLEVBRnlDLENBR3pDOztBQUNBTixjQUFVLEdBSitCLENBS3pDOztBQUNBQyxLQUFDLENBQUMsMkJBQUQsQ0FBRCxDQUErQkUsSUFBL0IsQ0FBb0Msa0ZBQXBDLEVBTnlDLENBT3pDOztBQUNBRixLQUFDLENBQUMsUUFBRCxDQUFELENBQVlNLFFBQVosQ0FBcUIsZUFBckIsRUFSeUMsQ0FTekM7O0FBQ0EsUUFBSUMsS0FBSyxHQUFHQyxRQUFRLENBQUNDLHNCQUFULENBQWdDLGtCQUFoQyxDQUFaLENBVnlDLENBV3pDOztBQUNBLFFBQUlDLFVBQVUsR0FBR0MsS0FBSyxDQUFDQyxTQUFOLENBQWdCQyxNQUFoQixDQUF1QkMsSUFBdkIsQ0FBNEJQLEtBQTVCLEVBQW1DLFVBQVNRLElBQVQsRUFBZTtBQUNqRUEsVUFBSSxDQUFDWCxnQkFBTCxDQUFzQixRQUF0QixFQUFnQyxVQUFTWSxLQUFULEVBQWdCO0FBQzlDaEIsU0FBQyxDQUFDLFNBQUQsQ0FBRCxDQUFhQyxJQUFiLENBQWtCLFVBQWxCLEVBQThCLFVBQTlCO0FBQ0FELFNBQUMsQ0FBQyxTQUFELENBQUQsQ0FBYUUsSUFBYixDQUFrQiwyQ0FBbEI7QUFDQUYsU0FBQyxDQUFDLGFBQUQsQ0FBRCxDQUFpQmlCLFdBQWpCLENBQThCLFFBQTlCOztBQUNBLFlBQUlGLElBQUksQ0FBQ0csYUFBTCxPQUF5QixLQUE3QixFQUFvQztBQUNsQ0YsZUFBSyxDQUFDRyxjQUFOO0FBQ0FILGVBQUssQ0FBQ0ksZUFBTjtBQUNBckIsb0JBQVU7QUFDWDs7QUFDRGdCLFlBQUksQ0FBQ00sU0FBTCxDQUFlQyxHQUFmLENBQW1CLGVBQW5CO0FBQ0QsT0FWRCxFQVVHLEtBVkg7QUFXRCxLQVpnQixDQUFqQjtBQWFELEdBekJELEVBeUJHLEtBekJIO0FBMEJELENBNUJELEkiLCJmaWxlIjoiZm9ybV9leHRlbmRlZC5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIGluaXRTdWJtaXQoKSB7XG4gICAkKCcjc3VibWl0JykucHJvcCgnZGlzYWJsZWQnLCBmYWxzZSk7XG4gICAkKFwiI3N1Ym1pdFwiKS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS1wYXBlci1wbGFuZVwiPjwvaT4gVmVyemVuZCcpO1xufVxuXG4vLyBEaXNhYmxpbmcgZm9ybSBzdWJtaXNzaW9ucyBpZiB0aGVyZSBhcmUgaW52YWxpZCBmaWVsZHNcbihmdW5jdGlvbigpIHtcbiAgJ3VzZSBzdHJpY3QnO1xuICB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcignbG9hZCcsIGZ1bmN0aW9uKCkge1xuICAgIC8vIEFwcGVuZCB0byBmb3JtXG4gICAgJChcIi5uZWVkcy12YWxpZGF0aW9uXCIpLmFwcGVuZCgnPGRpdiBjbGFzcz1cImZvcm0tZ3JvdXAgcm93IHB0LTNcIj48ZGl2IGNsYXNzPVwiY29sLXNtLTEwXCI+PGJ1dHRvbiB0eXBlPVwic3VibWl0XCIgY2xhc3M9XCJidG4gYnRuLXByaW1hcnlcIiBpZD1cInN1Ym1pdFwiIHZhbHVlPVwiU2VuZFwiPjwvYnV0dG9uPjxzbWFsbCBpZD1cInN1Ym1pdEhlbHBcIiBjbGFzcz1cImZvcm0tdGV4dCB0ZXh0LW11dGVkIGQtbm9uZVwiPkdlbGlldmUgZGUgcGFnaW5hIDxzdHJvbmc+bmlldDwvc3Ryb25nPiB0ZSBoZXJsYWRlbiB0aWpkZW5zIGhldCB2ZXJ6ZW5kZW4uPC9zbWFsbD48L2Rpdj48L2Rpdj4nKTtcbiAgICAvLyBTZXQgc3VibWl0IGJ1dHRvblxuICAgIGluaXRTdWJtaXQoKTtcbiAgICAvLyBSZXBsYWNlIGxhYmVsIGJ5IGhyZWYgXG4gICAgJChcImxhYmVsW2ZvciQ9J19mb3JtX3Rlcm1zJ11cIikuaHRtbChcIklrIGhlYiBoZXQgPGEgaHJlZj1cXFwiL3ByaXZhY3lcXFwiPnByaXZhY3liZWxlaWQ8L2E+IGdlbGV6ZW4gZW4gZ2EgaGllcm1lZSBha2tvb3JkLlwiKTtcbiAgICAvLyBCb290c3RyYXAgY3VzdG9tLXNlbGVjdCBmaXggKGF0dHJpYnV0ZSBlbmRzIHdpdGgpXG4gICAgJCgnc2VsZWN0JykuYWRkQ2xhc3MoJ2N1c3RvbS1zZWxlY3QnKTtcbiAgICAvLyBGZXRjaCBhbGwgdGhlIGZvcm1zIHdlIHdhbnQgdG8gYXBwbHkgY3VzdG9tIEJvb3RzdHJhcCB2YWxpZGF0aW9uIHN0eWxlcyB0b1xuICAgIHZhciBmb3JtcyA9IGRvY3VtZW50LmdldEVsZW1lbnRzQnlDbGFzc05hbWUoJ25lZWRzLXZhbGlkYXRpb24nKTtcbiAgICAvLyBMb29wIG92ZXIgdGhlbSBhbmQgcHJldmVudCBzdWJtaXNzaW9uXG4gICAgdmFyIHZhbGlkYXRpb24gPSBBcnJheS5wcm90b3R5cGUuZmlsdGVyLmNhbGwoZm9ybXMsIGZ1bmN0aW9uKGZvcm0pIHtcbiAgICAgIGZvcm0uYWRkRXZlbnRMaXN0ZW5lcignc3VibWl0JywgZnVuY3Rpb24oZXZlbnQpIHtcbiAgICAgICAgJCgnI3N1Ym1pdCcpLnByb3AoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XG4gICAgICAgICQoJyNzdWJtaXQnKS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS1zeW5jLWFsdFwiPjwvaT4gVmVyd2Vya2VuJyk7XG4gICAgICAgICQoJyNzdWJtaXRIZWxwJykucmVtb3ZlQ2xhc3MoIFwiZC1ub25lXCIgKTtcbiAgICAgICAgaWYgKGZvcm0uY2hlY2tWYWxpZGl0eSgpID09PSBmYWxzZSkge1xuICAgICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgaW5pdFN1Ym1pdCgpO1xuICAgICAgICB9XG4gICAgICAgIGZvcm0uY2xhc3NMaXN0LmFkZCgnd2FzLXZhbGlkYXRlZCcpO1xuICAgICAgfSwgZmFsc2UpO1xuICAgIH0pO1xuICB9LCBmYWxzZSk7XG59KSgpO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==