(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["tryout_enrolled"],{

/***/ "./assets/js/tryout_enrolled.js":
/*!**************************************!*\
  !*** ./assets/js/tryout_enrolled.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery, $) {/**
 * jQuery.fn.sortElements
 * --------------
 * @author James Padolsey (http://james.padolsey.com)
 * @version 0.11
 * @updated 18-MAR-2010
 * --------------
 * @param Function comparator:
 *   Exactly the same behaviour as [1,2,3].sort(comparator)
 *   
 * @param Function getSortable
 *   A function that should return the element that is
 *   to be sorted. The comparator will run on the
 *   current collection, but you may want the actual
 *   resulting sort to occur on a parent or another
 *   associated element.
 *   
 *   E.g. $('td').sortElements(comparator, function(){
 *      return this.parentNode; 
 *   })
 *   
 *   The <td>'s parent (<tr>) will be sorted instead
 *   of the <td> itself.
 */
jQuery.fn.sortElements = function () {
  var sort = [].sort;
  return function (comparator, getSortable) {
    getSortable = getSortable || function () {
      return this;
    };

    var placements = this.map(function () {
      var sortElement = getSortable.call(this),
          parentNode = sortElement.parentNode,
          // Since the element itself will change position, we have
      // to have some way of storing it's original position in
      // the DOM. The easiest way is to have a 'flag' node:
      nextSibling = parentNode.insertBefore(document.createTextNode(''), sortElement.nextSibling);
      return function () {
        if (parentNode === this) {
          throw new Error("You can't sort elements if any one is a descendant of another.");
        } // Insert before flag:


        parentNode.insertBefore(this, nextSibling); // Remove flag:

        parentNode.removeChild(nextSibling);
      };
    });
    return sort.call(this, comparator).each(function (i) {
      placements[i].call(getSortable.call(this));
    });
  };
}(); // get the encrypted data


$(window).on("load", function () {
  var hoztAPI = "/api/ingeschreven/testmoment/";
  $.each($('.api_load_tryout_enrolled'), function (i, tryout) {
    var uuid = $(tryout).data('tryout');
    $.getJSON(hoztAPI + uuid, {}).done(function (enrolments) {
      $(tryout).html(enrolments.content);
      var table = $('#' + uuid);
      $('#' + uuid + ' th.sortable').wrapInner('<button class="btn btn-link btn-sm"/>').each(function () {
        var th = $(this);
        var thIndex = th.index();
        var inverse = false;
        th.click(function () {
          $("#" + uuid + " th button").removeClass("dropdown-toggle");
          $(th).children('button').addClass('dropdown-toggle');
          $(th).removeClass(inverse ? 'dropup' : 'dropdown').addClass(inverse ? 'dropdown' : 'dropup');
          table.find('td').filter(function () {
            return $(this).index() === thIndex;
          }).sortElements(function (a, b) {
            return $.text([a]) > $.text([b]) ? inverse ? -1 : 1 : inverse ? 1 : -1;
          }, function () {
            // parentNode is the element we want to move
            return this.parentNode;
          });
          inverse = !inverse;
        });
      });
    });
  });
}); // send reminders

$.each($('.send-reminder'), function (i, tryout) {
  $(tryout).click(function () {
    var uuid = $(tryout).data('tryout');
    $(tryout).html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> verzenden');
    $(tryout).prop('disabled', true);
    alert("Reminder emails worden verzonden.");
    $.getJSON("/api/herinnering/testmoment/" + uuid, {}).done(function (data) {
      if (data.success) {
        $(tryout).html('<i class="fas fa-check"></i> reminder');
      } else {
        $(tryout).html('<i class="fas fa-times"></i> reminder');
      }

      alert(data.message);
    });
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"), __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/tryout_enrolled.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvdHJ5b3V0X2Vucm9sbGVkLmpzIl0sIm5hbWVzIjpbImpRdWVyeSIsImZuIiwic29ydEVsZW1lbnRzIiwic29ydCIsImNvbXBhcmF0b3IiLCJnZXRTb3J0YWJsZSIsInBsYWNlbWVudHMiLCJtYXAiLCJzb3J0RWxlbWVudCIsImNhbGwiLCJwYXJlbnROb2RlIiwibmV4dFNpYmxpbmciLCJpbnNlcnRCZWZvcmUiLCJkb2N1bWVudCIsImNyZWF0ZVRleHROb2RlIiwiRXJyb3IiLCJyZW1vdmVDaGlsZCIsImVhY2giLCJpIiwiJCIsIndpbmRvdyIsIm9uIiwiaG96dEFQSSIsInRyeW91dCIsInV1aWQiLCJkYXRhIiwiZ2V0SlNPTiIsImRvbmUiLCJlbnJvbG1lbnRzIiwiaHRtbCIsImNvbnRlbnQiLCJ0YWJsZSIsIndyYXBJbm5lciIsInRoIiwidGhJbmRleCIsImluZGV4IiwiaW52ZXJzZSIsImNsaWNrIiwicmVtb3ZlQ2xhc3MiLCJjaGlsZHJlbiIsImFkZENsYXNzIiwiZmluZCIsImZpbHRlciIsImEiLCJiIiwidGV4dCIsInByb3AiLCJhbGVydCIsInN1Y2Nlc3MiLCJtZXNzYWdlIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBd0JBQSxNQUFNLENBQUNDLEVBQVAsQ0FBVUMsWUFBVixHQUEwQixZQUFVO0FBRWhDLE1BQUlDLElBQUksR0FBRyxHQUFHQSxJQUFkO0FBRUEsU0FBTyxVQUFTQyxVQUFULEVBQXFCQyxXQUFyQixFQUFrQztBQUVyQ0EsZUFBVyxHQUFHQSxXQUFXLElBQUksWUFBVTtBQUFDLGFBQU8sSUFBUDtBQUFhLEtBQXJEOztBQUVBLFFBQUlDLFVBQVUsR0FBRyxLQUFLQyxHQUFMLENBQVMsWUFBVTtBQUVoQyxVQUFJQyxXQUFXLEdBQUdILFdBQVcsQ0FBQ0ksSUFBWixDQUFpQixJQUFqQixDQUFsQjtBQUFBLFVBQ0lDLFVBQVUsR0FBR0YsV0FBVyxD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bGxlZC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8qKlxuICogalF1ZXJ5LmZuLnNvcnRFbGVtZW50c1xuICogLS0tLS0tLS0tLS0tLS1cbiAqIEBhdXRob3IgSmFtZXMgUGFkb2xzZXkgKGh0dHA6Ly9qYW1lcy5wYWRvbHNleS5jb20pXG4gKiBAdmVyc2lvbiAwLjExXG4gKiBAdXBkYXRlZCAxOC1NQVItMjAxMFxuICogLS0tLS0tLS0tLS0tLS1cbiAqIEBwYXJhbSBGdW5jdGlvbiBjb21wYXJhdG9yOlxuICogICBFeGFjdGx5IHRoZSBzYW1lIGJlaGF2aW91ciBhcyBbMSwyLDNdLnNvcnQoY29tcGFyYXRvcilcbiAqICAgXG4gKiBAcGFyYW0gRnVuY3Rpb24gZ2V0U29ydGFibGVcbiAqICAgQSBmdW5jdGlvbiB0aGF0IHNob3VsZCByZXR1cm4gdGhlIGVsZW1lbnQgdGhhdCBpc1xuICogICB0byBiZSBzb3J0ZWQuIFRoZSBjb21wYXJhdG9yIHdpbGwgcnVuIG9uIHRoZVxuICogICBjdXJyZW50IGNvbGxlY3Rpb24sIGJ1dCB5b3UgbWF5IHdhbnQgdGhlIGFjdHVhbFxuICogICByZXN1bHRpbmcgc29ydCB0byBvY2N1ciBvbiBhIHBhcmVudCBvciBhbm90aGVyXG4gKiAgIGFzc29jaWF0ZWQgZWxlbWVudC5cbiAqICAgXG4gKiAgIEUuZy4gJCgndGQnKS5zb3J0RWxlbWVudHMoY29tcGFyYXRvciwgZnVuY3Rpb24oKXtcbiAqICAgICAgcmV0dXJuIHRoaXMucGFyZW50Tm9kZTsgXG4gKiAgIH0pXG4gKiAgIFxuICogICBUaGUgPHRkPidzIHBhcmVudCAoPHRyPikgd2lsbCBiZSBzb3J0ZWQgaW5zdGVhZFxuICogICBvZiB0aGUgPHRkPiBpdHNlbGYuXG4gKi9cbmpRdWVyeS5mbi5zb3J0RWxlbWVudHMgPSAoZnVuY3Rpb24oKXtcbiAgICBcbiAgICB2YXIgc29ydCA9IFtdLnNvcnQ7XG4gICAgXG4gICAgcmV0dXJuIGZ1bmN0aW9uKGNvbXBhcmF0b3IsIGdldFNvcnRhYmxlKSB7XG4gICAgICAgIFxuICAgICAgICBnZXRTb3J0YWJsZSA9IGdldFNvcnRhYmxlIHx8IGZ1bmN0aW9uKCl7cmV0dXJuIHRoaXM7fTtcbiAgICAgICAgXG4gICAgICAgIHZhciBwbGFjZW1lbnRzID0gdGhpcy5tYXAoZnVuY3Rpb24oKXtcbiAgICAgICAgICAgIFxuICAgICAgICAgICAgdmFyIHNvcnRFbGVtZW50ID0gZ2V0U29ydGFibGUuY2FsbCh0aGlzKSxcbiAgICAgICAgICAgICAgICBwYXJlbnROb2RlID0gc29ydEVsZW1lbnQucGFyZW50Tm9kZSxcbiAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgICAgICAvLyBTaW5jZSB0aGUgZWxlbWVudCBpdHNlbGYgd2lsbCBjaGFuZ2UgcG9zaXRpb24sIHdlIGhhdmVcbiAgICAgICAgICAgICAgICAvLyB0byBoYXZlIHNvbWUgd2F5IG9mIHN0b3JpbmcgaXQncyBvcmlnaW5hbCBwb3NpdGlvbiBpblxuICAgICAgICAgICAgICAgIC8vIHRoZSBET00uIFRoZSBlYXNpZXN0IHdheSBpcyB0byBoYXZlIGEgJ2ZsYWcnIG5vZGU6XG4gICAgICAgICAgICAgICAgbmV4dFNpYmxpbmcgPSBwYXJlbnROb2RlLmluc2VydEJlZm9yZShcbiAgICAgICAgICAgICAgICAgICAgZG9jdW1lbnQuY3JlYXRlVGV4dE5vZGUoJycpLFxuICAgICAgICAgICAgICAgICAgICBzb3J0RWxlbWVudC5uZXh0U2libGluZ1xuICAgICAgICAgICAgICAgICk7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIHJldHVybiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgICAgICBpZiAocGFyZW50Tm9kZSA9PT0gdGhpcykge1xuICAgICAgICAgICAgICAgICAgICB0aHJvdyBuZXcgRXJyb3IoXG4gICAgICAgICAgICAgICAgICAgICAgICBcIllvdSBjYW4ndCBzb3J0IGVsZW1lbnRzIGlmIGFueSBvbmUgaXMgYSBkZXNjZW5kYW50IG9mIGFub3RoZXIuXCJcbiAgICAgICAgICAgICAgICAgICAgKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgLy8gSW5zZXJ0IGJlZm9yZSBmbGFnOlxuICAgICAgICAgICAgICAgIHBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKHRoaXMsIG5leHRTaWJsaW5nKTtcbiAgICAgICAgICAgICAgICAvLyBSZW1vdmUgZmxhZzpcbiAgICAgICAgICAgICAgICBwYXJlbnROb2RlLnJlbW92ZUNoaWxkKG5leHRTaWJsaW5nKTtcbiAgICAgICAgICAgICAgICBcbiAgICAgICAgICAgIH07XG4gICAgICAgICAgICBcbiAgICAgICAgfSk7XG4gICAgICAgXG4gICAgICAgIHJldHVybiBzb3J0LmNhbGwodGhpcywgY29tcGFyYXRvcikuZWFjaChmdW5jdGlvbihpKXtcbiAgICAgICAgICAgIHBsYWNlbWVudHNbaV0uY2FsbChnZXRTb3J0YWJsZS5jYWxsKHRoaXMpKTtcbiAgICAgICAgfSk7XG4gICAgICAgIFxuICAgIH07XG4gICAgXG59KSgpO1xuXG4vLyBnZXQgdGhlIGVuY3J5cHRlZCBkYXRhXG4kKHdpbmRvdykub24oIFwibG9hZFwiLCBmdW5jdGlvbigpIHtcblxuICAgIHZhciBob3p0QVBJICA9IFwiL2FwaS9pbmdlc2NocmV2ZW4vdGVzdG1vbWVudC9cIjtcblxuICAgICQuZWFjaCggJCgnLmFwaV9sb2FkX3RyeW91dF9lbnJvbGxlZCcpLCBmdW5jdGlvbihpLHRyeW91dCkge1xuXG4gICAgICAgIHZhciB1dWlkID0gJCh0cnlvdXQpLmRhdGEoJ3RyeW91dCcpO1xuXG4gICAgICAgICQuZ2V0SlNPTiggaG96dEFQSSt1dWlkLCB7fSkuZG9uZShmdW5jdGlvbihlbnJvbG1lbnRzKSB7XG5cbiAgICAgICAgICAgICQodHJ5b3V0KS5odG1sKGVucm9sbWVudHMuY29udGVudCk7XG5cbiAgICAgICAgICAgIHZhciB0YWJsZSA9ICQoJyMnK3V1aWQpO1xuIFxuICAgICAgICAgICAgJCgnIycrIHV1aWQgKyAnIHRoLnNvcnRhYmxlJylcbiAgICAgICAgICAgICAgICAud3JhcElubmVyKCc8YnV0dG9uIGNsYXNzPVwiYnRuIGJ0bi1saW5rIGJ0bi1zbVwiLz4nKVxuICAgICAgICAgICAgICAgIC5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgICAgICB2YXIgdGggPSAkKHRoaXMpO1xuICAgICAgICAgICAgICAgIHZhciB0aEluZGV4ID0gdGguaW5kZXgoKTtcbiAgICAgICAgICAgICAgICB2YXIgaW52ZXJzZSA9IGZhbHNlO1xuICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgdGguY2xpY2soZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgICAgICAkKFwiI1wiICsgdXVpZCArIFwiIHRoIGJ1dHRvblwiKS5yZW1vdmVDbGFzcyhcImRyb3Bkb3duLXRvZ2dsZVwiKTtcbiAgICAgICAgICAgICAgICAgICAgJCh0aCkuY2hpbGRyZW4oJ2J1dHRvbicpLmFkZENsYXNzKCdkcm9wZG93bi10b2dnbGUnKTtcbiAgICAgICAgICAgICAgICAgICAgJCh0aCkucmVtb3ZlQ2xhc3MoaW52ZXJzZSA/ICdkcm9wdXAnIDogJ2Ryb3Bkb3duJykuYWRkQ2xhc3MoaW52ZXJzZSA/ICdkcm9wZG93bicgOiAnZHJvcHVwJyk7XG5cbiAgICAgICAgICAgICAgICAgICAgdGFibGUuZmluZCgndGQnKS5maWx0ZXIoZnVuY3Rpb24oKXtcblxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuICQodGhpcykuaW5kZXgoKSA9PT0gdGhJbmRleDtcblxuICAgICAgICAgICAgICAgICAgICB9KS5zb3J0RWxlbWVudHMoZnVuY3Rpb24oYSwgYil7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiAkLnRleHQoW2FdKSA+ICQudGV4dChbYl0pID9cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpbnZlcnNlID8gLTEgOiAxXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgOiBpbnZlcnNlID8gMSA6IC0xO1xuXG4gICAgICAgICAgICAgICAgICAgIH0sIGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgICAgICAgICAvLyBwYXJlbnROb2RlIGlzIHRoZSBlbGVtZW50IHdlIHdhbnQgdG8gbW92ZVxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHRoaXMucGFyZW50Tm9kZTtcbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgICAgIGludmVyc2UgPSAhaW52ZXJzZTtcbiAgICAgICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgXG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KTtcbiAgICB9KTtcblxufSk7XG5cbi8vIHNlbmQgcmVtaW5kZXJzXG4kLmVhY2goICQoJy5zZW5kLXJlbWluZGVyJyksIGZ1bmN0aW9uKGksdHJ5b3V0KSB7XG5cbiAgJCh0cnlvdXQpLmNsaWNrKGZ1bmN0aW9uKCkge1xuXG4gICAgdmFyIHV1aWQgPSAkKHRyeW91dCkuZGF0YSgndHJ5b3V0Jyk7XG4gICAgXG4gICAgJCh0cnlvdXQpLmh0bWwoJzxzcGFuIGNsYXNzPVwic3Bpbm5lci1ib3JkZXIgc3Bpbm5lci1ncm93LXNtXCIgcm9sZT1cInN0YXR1c1wiIGFyaWEtaGlkZGVuPVwidHJ1ZVwiPjwvc3Bhbj4gdmVyemVuZGVuJyk7XG4gICAgJCh0cnlvdXQpLnByb3AoJ2Rpc2FibGVkJyx0cnVlKTtcblxuICAgIGFsZXJ0KFwiUmVtaW5kZXIgZW1haWxzIHdvcmRlbiB2ZXJ6b25kZW4uXCIpO1xuXG4gICAgJC5nZXRKU09OKCBcIi9hcGkvaGVyaW5uZXJpbmcvdGVzdG1vbWVudC9cIit1dWlkLCB7fSkuZG9uZShmdW5jdGlvbihkYXRhKSB7XG4gICAgICBpZiAoZGF0YS5zdWNjZXNzKSB7XG4gICAgICAgICQodHJ5b3V0KS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS1jaGVja1wiPjwvaT4gcmVtaW5kZXInKTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgICQodHJ5b3V0KS5odG1sKCc8aSBjbGFzcz1cImZhcyBmYS10aW1lc1wiPjwvaT4gcmVtaW5kZXInKTsgXG4gICAgICB9XG4gICAgICBhbGVydChkYXRhLm1lc3NhZ2UpO1xuXG4gICAgfSk7XG5cbiAgfSk7XG5cbn0pO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==