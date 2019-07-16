(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["carousel"],{

/***/ "./assets/js/carousel.js":
/*!*******************************!*\
  !*** ./assets/js/carousel.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

__webpack_require__(/*! bcswipe */ "./node_modules/bcswipe/lib/main.js");

$('.carousel').carousel({
  interval: 6500
});
$('.carousel').bcSwipe({
  threshold: 60
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./node_modules/bcswipe/lib/main.js":
/*!******************************************!*\
  !*** ./node_modules/bcswipe/lib/main.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {/**
 * Bootstrap Carousel Swipe v1.1
 *
 * jQuery plugin to enable swipe gestures on Bootstrap 3 carousels.
 * Examples and documentation: https://github.com/briggySmalls/bcSwipe
 *
 * @license MIT
 */
var detectPassiveEvents = __webpack_require__(/*! detect-passive-events */ "./node_modules/detect-passive-events/lib/index.js");

(function($) {
  $.fn.bcSwipe = function(settings) {
    var config = { threshold: 50 };
    if (settings) {
      $.extend(config, settings);
    }

    this.each(function() {
      var stillMoving = false;
      var start;

      if ('ontouchstart' in document.documentElement) {
        this.addEventListener(
          'touchstart',
          onTouchStart,
          detectPassiveEvents.hasSupport ? {'passive': true} : false);
      }

      function onTouchStart(e) {
        if (e.touches.length == 1) {
          start = e.touches[0].pageX;
          stillMoving = true;
          this.addEventListener(
            'touchmove',
            onTouchMove,
            detectPassiveEvents.hasSupport ? {'passive': true} : false);
        }
      }

      function onTouchMove(e) {
        if (stillMoving) {
          var x = e.touches[0].pageX;
          var difference = start - x;
          if (Math.abs(difference) >= config.threshold) {
            cancelTouch.call(this);
            if (difference > 0) {
              $(this).carousel('next');
            }
            else {
              $(this).carousel('prev');
            }
          }
        }
      }

      function cancelTouch() {
        this.removeEventListener('touchmove', onTouchMove);
        start = null;
        stillMoving = false;
      }
    });

    return this;
  };
})(jQuery);

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./node_modules/detect-passive-events/lib/index.js":
/*!*********************************************************!*\
  !*** ./node_modules/detect-passive-events/lib/index.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
// adapted from https://github.com/WICG/EventListenerOptions/blob/gh-pages/explainer.md
var detectPassiveEvents = {
  update: function update() {
    if (typeof window !== 'undefined' && typeof window.addEventListener === 'function') {
      var passive = false;
      var options = Object.defineProperty({}, 'passive', {
        get: function get() {
          passive = true;
        }
      });
      // note: have to set and remove a no-op listener instead of null
      // (which was used previously), becasue Edge v15 throws an error
      // when providing a null callback.
      // https://github.com/rafrex/detect-passive-events/pull/3
      var noop = function noop() {};
      window.addEventListener('testPassiveEventSupport', noop, options);
      window.removeEventListener('testPassiveEventSupport', noop, options);
      detectPassiveEvents.hasSupport = passive;
    }
  }
};

detectPassiveEvents.update();
exports.default = detectPassiveEvents;

/***/ })

},[["./assets/js/carousel.js","runtime","vendors~calendar~carousel~eu_cookie~form_default~form_extended~hozt~training_category~tryout_enrolle~6e62a6db","vendors~carousel~hozt"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvY2Fyb3VzZWwuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2Jjc3dpcGUvbGliL21haW4uanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2RldGVjdC1wYXNzaXZlLWV2ZW50cy9saWIvaW5kZXguanMiXSwibmFtZXMiOlsicmVxdWlyZSIsIiQiLCJjYXJvdXNlbCIsImludGVydmFsIiwiYmNTd2lwZSIsInRocmVzaG9sZCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUFBLDREQUFPLENBQUMsZ0VBQUQsQ0FBUDs7QUFDQUEsbUJBQU8sQ0FBQyxtREFBRCxDQUFQOztBQUVBQyxDQUFDLENBQUMsV0FBRCxDQUFELENBQWVDLFFBQWYsQ0FBd0I7QUFBRUMsVUFBUSxFQUFFO0FBQVosQ0FBeEI7QUFDQUYsQ0FBQyxDQUFDLFdBQUQsQ0FBRCxDQUFlRyxPQUFmLENBQXVCO0FBQUVDLFdBQVMsRUFBRTtBQUFiLENBQXZCLEU7Ozs7Ozs7Ozs7OztBQ0pBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwwQkFBMEIsbUJBQU8sQ0FBQyxnRkFBdUI7O0FBRXpEO0FBQ0E7QUFDQSxrQkFBa0I7QUFDbEI7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDRDQUE0QyxnQkFBZ0I7QUFDNUQ7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSw4Q0FBOEMsZ0JBQWdCO0FBQzlEO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxDQUFDOzs7Ozs7Ozs7Ozs7OztBQ2hFWTs7QUFFYjtBQUNBO0FBQ0EsQ0FBQztBQUNEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSw0Q0FBNEM7QUFDNUM7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxzQyIsImZpbGUiOiJjYXJvdXNlbC5qcyIsInNvdXJjZXNDb250ZW50IjpbInJlcXVpcmUoJ2Jvb3RzdHJhcCcpO1xucmVxdWlyZSgnYmNzd2lwZScpO1xuXG4kKCcuY2Fyb3VzZWwnKS5jYXJvdXNlbCh7IGludGVydmFsOiA2NTAwIH0pO1xuJCgnLmNhcm91c2VsJykuYmNTd2lwZSh7IHRocmVzaG9sZDogNjAgfSk7XG4iLCIvKipcbiAqIEJvb3RzdHJhcCBDYXJvdXNlbCBTd2lwZSB2MS4xXG4gKlxuICogalF1ZXJ5IHBsdWdpbiB0byBlbmFibGUgc3dpcGUgZ2VzdHVyZXMgb24gQm9vdHN0cmFwIDMgY2Fyb3VzZWxzLlxuICogRXhhbXBsZXMgYW5kIGRvY3VtZW50YXRpb246IGh0dHBzOi8vZ2l0aHViLmNvbS9icmlnZ3lTbWFsbHMvYmNTd2lwZVxuICpcbiAqIEBsaWNlbnNlIE1JVFxuICovXG52YXIgZGV0ZWN0UGFzc2l2ZUV2ZW50cyA9IHJlcXVpcmUoJ2RldGVjdC1wYXNzaXZlLWV2ZW50cycpO1xuXG4oZnVuY3Rpb24oJCkge1xuICAkLmZuLmJjU3dpcGUgPSBmdW5jdGlvbihzZXR0aW5ncykge1xuICAgIHZhciBjb25maWcgPSB7IHRocmVzaG9sZDogNTAgfTtcbiAgICBpZiAoc2V0dGluZ3MpIHtcbiAgICAgICQuZXh0ZW5kKGNvbmZpZywgc2V0dGluZ3MpO1xuICAgIH1cblxuICAgIHRoaXMuZWFjaChmdW5jdGlvbigpIHtcbiAgICAgIHZhciBzdGlsbE1vdmluZyA9IGZhbHNlO1xuICAgICAgdmFyIHN0YXJ0O1xuXG4gICAgICBpZiAoJ29udG91Y2hzdGFydCcgaW4gZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50KSB7XG4gICAgICAgIHRoaXMuYWRkRXZlbnRMaXN0ZW5lcihcbiAgICAgICAgICAndG91Y2hzdGFydCcsXG4gICAgICAgICAgb25Ub3VjaFN0YXJ0LFxuICAgICAgICAgIGRldGVjdFBhc3NpdmVFdmVudHMuaGFzU3VwcG9ydCA/IHsncGFzc2l2ZSc6IHRydWV9IDogZmFsc2UpO1xuICAgICAgfVxuXG4gICAgICBmdW5jdGlvbiBvblRvdWNoU3RhcnQoZSkge1xuICAgICAgICBpZiAoZS50b3VjaGVzLmxlbmd0aCA9PSAxKSB7XG4gICAgICAgICAgc3RhcnQgPSBlLnRvdWNoZXNbMF0ucGFnZVg7XG4gICAgICAgICAgc3RpbGxNb3ZpbmcgPSB0cnVlO1xuICAgICAgICAgIHRoaXMuYWRkRXZlbnRMaXN0ZW5lcihcbiAgICAgICAgICAgICd0b3VjaG1vdmUnLFxuICAgICAgICAgICAgb25Ub3VjaE1vdmUsXG4gICAgICAgICAgICBkZXRlY3RQYXNzaXZlRXZlbnRzLmhhc1N1cHBvcnQgPyB7J3Bhc3NpdmUnOiB0cnVlfSA6IGZhbHNlKTtcbiAgICAgICAgfVxuICAgICAgfVxuXG4gICAgICBmdW5jdGlvbiBvblRvdWNoTW92ZShlKSB7XG4gICAgICAgIGlmIChzdGlsbE1vdmluZykge1xuICAgICAgICAgIHZhciB4ID0gZS50b3VjaGVzWzBdLnBhZ2VYO1xuICAgICAgICAgIHZhciBkaWZmZXJlbmNlID0gc3RhcnQgLSB4O1xuICAgICAgICAgIGlmIChNYXRoLmFicyhkaWZmZXJlbmNlKSA+PSBjb25maWcudGhyZXNob2xkKSB7XG4gICAgICAgICAgICBjYW5jZWxUb3VjaC5jYWxsKHRoaXMpO1xuICAgICAgICAgICAgaWYgKGRpZmZlcmVuY2UgPiAwKSB7XG4gICAgICAgICAgICAgICQodGhpcykuY2Fyb3VzZWwoJ25leHQnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAkKHRoaXMpLmNhcm91c2VsKCdwcmV2Jyk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICB9XG5cbiAgICAgIGZ1bmN0aW9uIGNhbmNlbFRvdWNoKCkge1xuICAgICAgICB0aGlzLnJlbW92ZUV2ZW50TGlzdGVuZXIoJ3RvdWNobW92ZScsIG9uVG91Y2hNb3ZlKTtcbiAgICAgICAgc3RhcnQgPSBudWxsO1xuICAgICAgICBzdGlsbE1vdmluZyA9IGZhbHNlO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgcmV0dXJuIHRoaXM7XG4gIH07XG59KShqUXVlcnkpO1xuIiwiJ3VzZSBzdHJpY3QnO1xuXG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHtcbiAgdmFsdWU6IHRydWVcbn0pO1xuLy8gYWRhcHRlZCBmcm9tIGh0dHBzOi8vZ2l0aHViLmNvbS9XSUNHL0V2ZW50TGlzdGVuZXJPcHRpb25zL2Jsb2IvZ2gtcGFnZXMvZXhwbGFpbmVyLm1kXG52YXIgZGV0ZWN0UGFzc2l2ZUV2ZW50cyA9IHtcbiAgdXBkYXRlOiBmdW5jdGlvbiB1cGRhdGUoKSB7XG4gICAgaWYgKHR5cGVvZiB3aW5kb3cgIT09ICd1bmRlZmluZWQnICYmIHR5cGVvZiB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lciA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgdmFyIHBhc3NpdmUgPSBmYWxzZTtcbiAgICAgIHZhciBvcHRpb25zID0gT2JqZWN0LmRlZmluZVByb3BlcnR5KHt9LCAncGFzc2l2ZScsIHtcbiAgICAgICAgZ2V0OiBmdW5jdGlvbiBnZXQoKSB7XG4gICAgICAgICAgcGFzc2l2ZSA9IHRydWU7XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgICAgLy8gbm90ZTogaGF2ZSB0byBzZXQgYW5kIHJlbW92ZSBhIG5vLW9wIGxpc3RlbmVyIGluc3RlYWQgb2YgbnVsbFxuICAgICAgLy8gKHdoaWNoIHdhcyB1c2VkIHByZXZpb3VzbHkpLCBiZWNhc3VlIEVkZ2UgdjE1IHRocm93cyBhbiBlcnJvclxuICAgICAgLy8gd2hlbiBwcm92aWRpbmcgYSBudWxsIGNhbGxiYWNrLlxuICAgICAgLy8gaHR0cHM6Ly9naXRodWIuY29tL3JhZnJleC9kZXRlY3QtcGFzc2l2ZS1ldmVudHMvcHVsbC8zXG4gICAgICB2YXIgbm9vcCA9IGZ1bmN0aW9uIG5vb3AoKSB7fTtcbiAgICAgIHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKCd0ZXN0UGFzc2l2ZUV2ZW50U3VwcG9ydCcsIG5vb3AsIG9wdGlvbnMpO1xuICAgICAgd2luZG93LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ3Rlc3RQYXNzaXZlRXZlbnRTdXBwb3J0Jywgbm9vcCwgb3B0aW9ucyk7XG4gICAgICBkZXRlY3RQYXNzaXZlRXZlbnRzLmhhc1N1cHBvcnQgPSBwYXNzaXZlO1xuICAgIH1cbiAgfVxufTtcblxuZGV0ZWN0UGFzc2l2ZUV2ZW50cy51cGRhdGUoKTtcbmV4cG9ydHMuZGVmYXVsdCA9IGRldGVjdFBhc3NpdmVFdmVudHM7Il0sInNvdXJjZVJvb3QiOiIifQ==