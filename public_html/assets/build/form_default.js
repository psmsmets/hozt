(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["form_default"],{

/***/ "./assets/js/form_default.js":
/*!***********************************!*\
  !*** ./assets/js/form_default.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {// Disabling form submissions if there are invalid fields
(function () {
  'use strict';

  window.addEventListener('load', function () {
    // Replace label by href 
    $("label[for$='_form_terms']").html("Ik heb het <a href=\"/privacy\">privacybeleid</a> gelezen en ga hiermee akkoord."); // Bootstrap custom-select fix (attribute ends with)

    $('select').addClass('custom-select'); // Fetch all the forms we want to apply custom Bootstrap validation styles to

    var forms = document.getElementsByClassName('needs-validation'); // Loop over them and prevent submission

    var validation = Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/form_default.js","runtime","vendors~calendar~carousel~eu_cookie~form_default~form_extended~hozt~training_category~tryout_enrolle~6e62a6db"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZm9ybV9kZWZhdWx0LmpzIl0sIm5hbWVzIjpbIndpbmRvdyIsImFkZEV2ZW50TGlzdGVuZXIiLCIkIiwiaHRtbCIsImFkZENsYXNzIiwiZm9ybXMiLCJkb2N1bWVudCIsImdldEVsZW1lbnRzQnlDbGFzc05hbWUiLCJ2YWxpZGF0aW9uIiwiQXJyYXkiLCJwcm90b3R5cGUiLCJmaWx0ZXIiLCJjYWxsIiwiZm9ybSIsImV2ZW50IiwiY2hlY2tWYWxpZGl0eSIsInByZXZlbnREZWZhdWx0Iiwic3RvcFByb3BhZ2F0aW9uIiwiY2xhc3NMaXN0IiwiYWRkIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQTtBQUNBLENBQUMsWUFBVztBQUNWOztBQUNBQSxRQUFNLENBQUNDLGdCQUFQLENBQXdCLE1BQXhCLEVBQWdDLFlBQVc7QUFDekM7QUFDQUMsS0FBQyxDQUFDLDJCQUFELENBQUQsQ0FBK0JDLElBQS9CLENBQW9DLGtGQUFwQyxFQUZ5QyxDQUd6Qzs7QUFDQUQsS0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZRSxRQUFaLENBQXFCLGVBQXJCLEVBSnlDLENBS3pDOztBQUNBLFFBQUlDLEtBQUssR0FBR0MsUUFBUSxDQUFDQyxzQkFBVCxDQUFnQyxrQkFBaEMsQ0FBWixDQU55QyxDQU96Qzs7QUFDQSxRQUFJQyxVQUFVLEdBQUdDLEtBQUssQ0FBQ0MsU0FBTixDQUFnQkMsTUFBaEIsQ0FBdUJDLElBQXZCLENBQTRCUCxLQUE1QixFQUFtQyxVQUFTUSxJQUFULEVBQWU7QUFDakVBLFVBQUksQ0FBQ1osZ0JBQUwsQ0FBc0IsUUFBdEIsRUFBZ0MsVUFBU2EsS0FBVCxFQUFnQjtBQUM5QyxZQUFJRCxJQUFJLENBQUNFLGFBQUwsT0FBeUIsS0FBN0IsRUFBb0M7QUFDbENELGVBQUssQ0FBQ0UsY0FBTjtBQUNBRixlQUFLLENBQUNHLGVBQU47QUFDRDs7QUFDREosWUFBSSxDQUFDSyxTQUFMLENBQWVDLEdBQWYsQ0FBbUIsZUFBbkI7QUFDRCxPQU5ELEVBTUcsS0FOSDtBQU9ELEtBUmdCLENBQWpCO0FBU0QsR0FqQkQsRUFpQkcsS0FqQkg7QUFrQkQsQ0FwQkQsSSIsImZpbGUiOiJmb3JtX2RlZmF1bHQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBEaXNhYmxpbmcgZm9ybSBzdWJtaXNzaW9ucyBpZiB0aGVyZSBhcmUgaW52YWxpZCBmaWVsZHNcbihmdW5jdGlvbigpIHtcbiAgJ3VzZSBzdHJpY3QnO1xuICB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcignbG9hZCcsIGZ1bmN0aW9uKCkge1xuICAgIC8vIFJlcGxhY2UgbGFiZWwgYnkgaHJlZiBcbiAgICAkKFwibGFiZWxbZm9yJD0nX2Zvcm1fdGVybXMnXVwiKS5odG1sKFwiSWsgaGViIGhldCA8YSBocmVmPVxcXCIvcHJpdmFjeVxcXCI+cHJpdmFjeWJlbGVpZDwvYT4gZ2VsZXplbiBlbiBnYSBoaWVybWVlIGFra29vcmQuXCIpO1xuICAgIC8vIEJvb3RzdHJhcCBjdXN0b20tc2VsZWN0IGZpeCAoYXR0cmlidXRlIGVuZHMgd2l0aClcbiAgICAkKCdzZWxlY3QnKS5hZGRDbGFzcygnY3VzdG9tLXNlbGVjdCcpO1xuICAgIC8vIEZldGNoIGFsbCB0aGUgZm9ybXMgd2Ugd2FudCB0byBhcHBseSBjdXN0b20gQm9vdHN0cmFwIHZhbGlkYXRpb24gc3R5bGVzIHRvXG4gICAgdmFyIGZvcm1zID0gZG9jdW1lbnQuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZSgnbmVlZHMtdmFsaWRhdGlvbicpO1xuICAgIC8vIExvb3Agb3ZlciB0aGVtIGFuZCBwcmV2ZW50IHN1Ym1pc3Npb25cbiAgICB2YXIgdmFsaWRhdGlvbiA9IEFycmF5LnByb3RvdHlwZS5maWx0ZXIuY2FsbChmb3JtcywgZnVuY3Rpb24oZm9ybSkge1xuICAgICAgZm9ybS5hZGRFdmVudExpc3RlbmVyKCdzdWJtaXQnLCBmdW5jdGlvbihldmVudCkge1xuICAgICAgICBpZiAoZm9ybS5jaGVja1ZhbGlkaXR5KCkgPT09IGZhbHNlKSB7XG4gICAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgfVxuICAgICAgICBmb3JtLmNsYXNzTGlzdC5hZGQoJ3dhcy12YWxpZGF0ZWQnKTtcbiAgICAgIH0sIGZhbHNlKTtcbiAgICB9KTtcbiAgfSwgZmFsc2UpO1xufSkoKTtcbiJdLCJzb3VyY2VSb290IjoiIn0=