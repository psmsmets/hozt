(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["eu_cookie"],{

/***/ "./assets/js/eu_cookie.js":
/*!********************************!*\
  !*** ./assets/js/eu_cookie.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {// eu cookie
$('#cookie-law-modal').modal('show');
var cookieBar = document.getElementById('cookie-law-modal'),
    button = document.getElementById('cookie-law-close-button');

function hideCookieBar() {
  cookieBar.style.display = 'none';
  $('#cookie-law-modal').modal('hide');
}

function setCookieAccepted() {
  expiry = new Date();
  expiry.setTime(expiry.getTime() + 180 * 1000 * 60 * 60 * 24);
  document.cookie = "cookie_law_accepted=1; expires=" + expiry.toGMTString();
}

button.onclick = function () {
  hideCookieBar();
  setCookieAccepted();
  return false;
};
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/eu_cookie.js","runtime","vendors~calendar~carousel~eu_cookie~form_default~form_extended~hozt~membership_competitions~membersh~262175ed"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZXVfY29va2llLmpzIl0sIm5hbWVzIjpbIiQiLCJtb2RhbCIsImNvb2tpZUJhciIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJidXR0b24iLCJoaWRlQ29va2llQmFyIiwic3R5bGUiLCJkaXNwbGF5Iiwic2V0Q29va2llQWNjZXB0ZWQiLCJleHBpcnkiLCJEYXRlIiwic2V0VGltZSIsImdldFRpbWUiLCJjb29raWUiLCJ0b0dNVFN0cmluZyIsIm9uY2xpY2siXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBO0FBQ0FBLENBQUMsQ0FBQyxtQkFBRCxDQUFELENBQXVCQyxLQUF2QixDQUE2QixNQUE3QjtBQUNBLElBQUlDLFNBQVMsR0FBR0MsUUFBUSxDQUFDQyxjQUFULENBQXdCLGtCQUF4QixDQUFoQjtBQUFBLElBQ0lDLE1BQU0sR0FBR0YsUUFBUSxDQUFDQyxjQUFULENBQXdCLHlCQUF4QixDQURiOztBQUdBLFNBQVNFLGFBQVQsR0FBeUI7QUFDckJKLFdBQVMsQ0FBQ0ssS0FBVixDQUFnQkMsT0FBaEIsR0FBMEIsTUFBMUI7QUFDQVIsR0FBQyxDQUFDLG1CQUFELENBQUQsQ0FBdUJDLEtBQXZCLENBQTZCLE1BQTdCO0FBQ0g7O0FBRUQsU0FBU1EsaUJBQVQsR0FBNkI7QUFDekJDLFFBQU0sR0FBRyxJQUFJQyxJQUFKLEVBQVQ7QUFDQUQsUUFBTSxDQUFDRSxPQUFQLENBQWVGLE1BQU0sQ0FBQ0csT0FBUCxLQUFtQixNQUFNLElBQU4sR0FBYSxFQUFiLEdBQWtCLEVBQWxCLEdBQXVCLEVBQXpEO0FBQ0FWLFVBQVEsQ0FBQ1csTUFBVCxHQUFrQixvQ0FBb0NKLE1BQU0sQ0FBQ0ssV0FBUCxFQUF0RDtBQUNIOztBQUVEVixNQUFNLENBQUNXLE9BQVAsR0FBaUIsWUFBVztBQUN4QlYsZUFBYTtBQUNiRyxtQkFBaUI7QUFFakIsU0FBTyxLQUFQO0FBQ0gsQ0FMRCxDIiwiZmlsZSI6ImV1X2Nvb2tpZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIGV1IGNvb2tpZVxuJCgnI2Nvb2tpZS1sYXctbW9kYWwnKS5tb2RhbCgnc2hvdycpXG52YXIgY29va2llQmFyID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2Nvb2tpZS1sYXctbW9kYWwnKSxcbiAgICBidXR0b24gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnY29va2llLWxhdy1jbG9zZS1idXR0b24nKTtcblxuZnVuY3Rpb24gaGlkZUNvb2tpZUJhcigpIHtcbiAgICBjb29raWVCYXIuc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICAkKCcjY29va2llLWxhdy1tb2RhbCcpLm1vZGFsKCdoaWRlJylcbn1cblxuZnVuY3Rpb24gc2V0Q29va2llQWNjZXB0ZWQoKSB7XG4gICAgZXhwaXJ5ID0gbmV3IERhdGUoKTtcbiAgICBleHBpcnkuc2V0VGltZShleHBpcnkuZ2V0VGltZSgpKyggMTgwICogMTAwMCAqIDYwICogNjAgKiAyNCkpO1xuICAgIGRvY3VtZW50LmNvb2tpZSA9IFwiY29va2llX2xhd19hY2NlcHRlZD0xOyBleHBpcmVzPVwiICsgZXhwaXJ5LnRvR01UU3RyaW5nKCk7XG59XG5cbmJ1dHRvbi5vbmNsaWNrID0gZnVuY3Rpb24oKSB7XG4gICAgaGlkZUNvb2tpZUJhcigpO1xuICAgIHNldENvb2tpZUFjY2VwdGVkKCk7XG5cbiAgICByZXR1cm4gZmFsc2U7XG59XG4iXSwic291cmNlUm9vdCI6IiJ9