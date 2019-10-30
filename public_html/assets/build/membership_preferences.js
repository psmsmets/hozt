(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["membership_preferences"],{

/***/ "./assets/js/membership_preferences.js":
/*!*********************************************!*\
  !*** ./assets/js/membership_preferences.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {__webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");

$('#preferencesModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal

  var tab = button.data('tab');
  var form = button.data('form');
  var action = button.data('action');
  var id = button.data('id'); // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

  var modal = $(this).find('.modal-dialog');
  modal.html('<div class="spinner-border mx-auto" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>');
  preferencesAction(tab, form, action, id, modal);
});

function preferencesAction(tab, form) {
  var action = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'edit';
  var id = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  var obj = arguments.length > 4 ? arguments[4] : undefined;
  $.getJSON("/api/private/membership/preferences", {
    tab: tab,
    form: form,
    action: action,
    id: id,
    format: "json"
  }).done(function (data) {
    if (data.success) {
      obj.html(data.html);
      formSubmit();
    }
  });
}

function loadPreferencesContent() {
  var active = $('#preferences-tab').find('.active');
  var tab = active.data('tab');
  var tabpanel = $('#preferences-' + tab);
  $(tabpanel).html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
  $.getJSON("/api/private/membership/preferences", {
    tab: tab,
    action: 'load',
    format: "json"
  }).done(function (data) {
    if (data.success) {
      $(tabpanel).html(data.html);
    }
  });
}

function formSubmit() {
  $('form').submit(function () {
    $.ajax({
      // create an AJAX call...
      data: $(this).serialize(),
      // get the form data
      type: $(this).attr('method'),
      // GET or POST
      url: $(this).attr('action'),
      // the file to call
      success: function success(response) {
        // on success..
        loadPreferencesContent();
        $('#preferencesModal').modal('hide');
      }
    });
    return false; // cancel original event to prevent form submitting
  });
}
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/membership_preferences.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275","vendors~carousel~hozt~membership_competitions~membership_preferences~sportadmin_competitions"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbWVtYmVyc2hpcF9wcmVmZXJlbmNlcy5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsIm9uIiwiZXZlbnQiLCJidXR0b24iLCJyZWxhdGVkVGFyZ2V0IiwidGFiIiwiZGF0YSIsImZvcm0iLCJhY3Rpb24iLCJpZCIsIm1vZGFsIiwiZmluZCIsImh0bWwiLCJwcmVmZXJlbmNlc0FjdGlvbiIsIm9iaiIsImdldEpTT04iLCJmb3JtYXQiLCJkb25lIiwic3VjY2VzcyIsImZvcm1TdWJtaXQiLCJsb2FkUHJlZmVyZW5jZXNDb250ZW50IiwiYWN0aXZlIiwidGFicGFuZWwiLCJzdWJtaXQiLCJhamF4Iiwic2VyaWFsaXplIiwidHlwZSIsImF0dHIiLCJ1cmwiLCJyZXNwb25zZSJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUFBLDREQUFPLENBQUMsZ0VBQUQsQ0FBUDs7QUFFQUMsQ0FBQyxDQUFDLG1CQUFELENBQUQsQ0FBdUJDLEVBQXZCLENBQTBCLGVBQTFCLEVBQTJDLFVBQVVDLEtBQVYsRUFBaUI7QUFDMUQsTUFBSUMsTUFBTSxHQUFHSCxDQUFDLENBQUNFLEtBQUssQ0FBQ0UsYUFBUCxDQUFkLENBRDBELENBQ3RCOztBQUNwQyxNQUFJQyxHQUFHLEdBQUdGLE1BQU0sQ0FBQ0csSUFBUCxDQUFZLEtBQVosQ0FBVjtBQUNBLE1BQUlDLElBQUksR0FBR0osTUFBTSxDQUFDRyxJQUFQLENBQVksTUFBWixDQUFYO0FBQ0EsTUFBSUUsTUFBTSxHQUFHTCxNQUFNLENBQUNHLElBQVAsQ0FBWSxRQUFaLENBQWI7QUFDQSxNQUFJRyxFQUFFLEdBQUdOLE1BQU0sQ0FBQ0csSUFBUCxDQUFZLElBQVosQ0FBVCxDQUwwRCxDQU0xRDtBQUNBOztBQUNBLE1BQUlJLEtBQUssR0FBR1YsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRVyxJQUFSLENBQWEsZUFBYixDQUFaO0FBQ0FELE9BQUssQ0FBQ0UsSUFBTixDQUFXLG9JQUFYO0FBQ0FDLG1CQUFpQixDQUFFUixHQUFGLEVBQU9FLElBQVAsRUFBYUMsTUFBYixFQUFxQkMsRUFBckIsRUFBeUJDLEtBQXpCLENBQWpCO0FBQ0QsQ0FYRDs7QUFhQSxTQUFTRyxpQkFBVCxDQUE0QlIsR0FBNUIsRUFBaUNFLElBQWpDLEVBQXlFO0FBQUEsTUFBbENDLE1BQWtDLHVFQUF6QixNQUF5QjtBQUFBLE1BQWpCQyxFQUFpQix1RUFBWixJQUFZO0FBQUEsTUFBTkssR0FBTTtBQUNyRWQsR0FBQyxDQUFDZSxPQUFGLENBQVcscUNBQVgsRUFBa0Q7QUFDOUNWLE9BQUcsRUFBRUEsR0FEeUM7QUFFOUNFLFFBQUksRUFBRUEsSUFGd0M7QUFHOUNDLFVBQU0sRUFBRUEsTUFIc0M7QUFJOUNDLE1BQUUsRUFBRUEsRUFKMEM7QUFLOUNPLFVBQU0sRUFBRTtBQUxzQyxHQUFsRCxFQU9DQyxJQVBELENBT00sVUFBVVgsSUFBVixFQUFpQjtBQUNuQixRQUFJQSxJQUFJLENBQUNZLE9BQVQsRUFBa0I7QUFDZEosU0FBRyxDQUFDRixJQUFKLENBQVVOLElBQUksQ0FBQ00sSUFBZjtBQUNBTyxnQkFBVTtBQUNiO0FBQ0osR0FaRDtBQWFIOztBQUVELFNBQVNDLHNCQUFULEdBQWtDO0FBQzlCLE1BQUlDLE1BQU0sR0FBR3JCLENBQUMsQ0FBQyxrQkFBRCxDQUFELENBQXNCVyxJQUF0QixDQUEyQixTQUEzQixDQUFiO0FBQ0EsTUFBSU4sR0FBRyxHQUFHZ0IsTUFBTSxDQUFDZixJQUFQLENBQVksS0FBWixDQUFWO0FBQ0EsTUFBSWdCLFFBQVEsR0FBR3RCLENBQUMsQ0FBQyxrQkFBZ0JLLEdBQWpCLENBQWhCO0FBQ0FMLEdBQUMsQ0FBQ3NCLFFBQUQsQ0FBRCxDQUFZVixJQUFaLENBQWlCLDBJQUFqQjtBQUNBWixHQUFDLENBQUNlLE9BQUYsQ0FBVyxxQ0FBWCxFQUFrRDtBQUM5Q1YsT0FBRyxFQUFFQSxHQUR5QztBQUU5Q0csVUFBTSxFQUFFLE1BRnNDO0FBRzlDUSxVQUFNLEVBQUU7QUFIc0MsR0FBbEQsRUFLQ0MsSUFMRCxDQUtNLFVBQVVYLElBQVYsRUFBaUI7QUFDbkIsUUFBSUEsSUFBSSxDQUFDWSxPQUFULEVBQWtCO0FBQ2RsQixPQUFDLENBQUNzQixRQUFELENBQUQsQ0FBWVYsSUFBWixDQUFrQk4sSUFBSSxDQUFDTSxJQUF2QjtBQUNIO0FBQ0osR0FURDtBQVVIOztBQUVELFNBQVNPLFVBQVQsR0FBc0I7QUFDbEJuQixHQUFDLENBQUMsTUFBRCxDQUFELENBQVV1QixNQUFWLENBQWlCLFlBQVc7QUFDeEJ2QixLQUFDLENBQUN3QixJQUFGLENBQU87QUFBRTtBQUNMbEIsVUFBSSxFQUFFTixDQUFDLENBQUMsSUFBRCxDQUFELENBQVF5QixTQUFSLEVBREg7QUFDd0I7QUFDM0JDLFVBQUksRUFBRTFCLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUTJCLElBQVIsQ0FBYSxRQUFiLENBRkg7QUFFMkI7QUFDOUJDLFNBQUcsRUFBRTVCLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUTJCLElBQVIsQ0FBYSxRQUFiLENBSEY7QUFHMEI7QUFDN0JULGFBQU8sRUFBRSxpQkFBU1csUUFBVCxFQUFtQjtBQUFFO0FBQzFCVCw4QkFBc0I7QUFDdEJwQixTQUFDLENBQUMsbUJBQUQsQ0FBRCxDQUF1QlUsS0FBdkIsQ0FBNkIsTUFBN0I7QUFDSDtBQVBFLEtBQVA7QUFTQSxXQUFPLEtBQVAsQ0FWd0IsQ0FVVjtBQUNqQixHQVhEO0FBWUgsQyIsImZpbGUiOiJtZW1iZXJzaGlwX3ByZWZlcmVuY2VzLmpzIiwic291cmNlc0NvbnRlbnQiOlsicmVxdWlyZSgnYm9vdHN0cmFwJyk7XG5cbiQoJyNwcmVmZXJlbmNlc01vZGFsJykub24oJ3Nob3cuYnMubW9kYWwnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgdmFyIGJ1dHRvbiA9ICQoZXZlbnQucmVsYXRlZFRhcmdldCkgLy8gQnV0dG9uIHRoYXQgdHJpZ2dlcmVkIHRoZSBtb2RhbFxuICB2YXIgdGFiID0gYnV0dG9uLmRhdGEoJ3RhYicpXG4gIHZhciBmb3JtID0gYnV0dG9uLmRhdGEoJ2Zvcm0nKVxuICB2YXIgYWN0aW9uID0gYnV0dG9uLmRhdGEoJ2FjdGlvbicpXG4gIHZhciBpZCA9IGJ1dHRvbi5kYXRhKCdpZCcpXG4gIC8vIElmIG5lY2Vzc2FyeSwgeW91IGNvdWxkIGluaXRpYXRlIGFuIEFKQVggcmVxdWVzdCBoZXJlIChhbmQgdGhlbiBkbyB0aGUgdXBkYXRpbmcgaW4gYSBjYWxsYmFjaykuXG4gIC8vIFVwZGF0ZSB0aGUgbW9kYWwncyBjb250ZW50LiBXZSdsbCB1c2UgalF1ZXJ5IGhlcmUsIGJ1dCB5b3UgY291bGQgdXNlIGEgZGF0YSBiaW5kaW5nIGxpYnJhcnkgb3Igb3RoZXIgbWV0aG9kcyBpbnN0ZWFkLlxuICB2YXIgbW9kYWwgPSAkKHRoaXMpLmZpbmQoJy5tb2RhbC1kaWFsb2cnKVxuICBtb2RhbC5odG1sKCc8ZGl2IGNsYXNzPVwic3Bpbm5lci1ib3JkZXIgbXgtYXV0b1wiIHN0eWxlPVwid2lkdGg6IDNyZW07IGhlaWdodDogM3JlbTtcIiByb2xlPVwic3RhdHVzXCI+PHNwYW4gY2xhc3M9XCJzci1vbmx5XCI+TG9hZGluZy4uLjwvc3Bhbj48L2Rpdj4nKTtcbiAgcHJlZmVyZW5jZXNBY3Rpb24oIHRhYiwgZm9ybSwgYWN0aW9uLCBpZCwgbW9kYWwgKTtcbn0pO1xuXG5mdW5jdGlvbiBwcmVmZXJlbmNlc0FjdGlvbiggdGFiLCBmb3JtLCBhY3Rpb24gPSAnZWRpdCcsIGlkID0gbnVsbCwgb2JqICkge1xuICAgICQuZ2V0SlNPTiggXCIvYXBpL3ByaXZhdGUvbWVtYmVyc2hpcC9wcmVmZXJlbmNlc1wiLCB7XG4gICAgICAgIHRhYjogdGFiLFxuICAgICAgICBmb3JtOiBmb3JtLFxuICAgICAgICBhY3Rpb246IGFjdGlvbixcbiAgICAgICAgaWQ6IGlkLFxuICAgICAgICBmb3JtYXQ6IFwianNvblwiLFxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGRhdGEgKSB7XG4gICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MpIHtcbiAgICAgICAgICAgIG9iai5odG1sKCBkYXRhLmh0bWwgKTtcbiAgICAgICAgICAgIGZvcm1TdWJtaXQoKTtcbiAgICAgICAgfVxuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBsb2FkUHJlZmVyZW5jZXNDb250ZW50KCkge1xuICAgIHZhciBhY3RpdmUgPSAkKCcjcHJlZmVyZW5jZXMtdGFiJykuZmluZCgnLmFjdGl2ZScpO1xuICAgIHZhciB0YWIgPSBhY3RpdmUuZGF0YSgndGFiJyk7XG4gICAgdmFyIHRhYnBhbmVsID0gJCgnI3ByZWZlcmVuY2VzLScrdGFiKTtcbiAgICAkKHRhYnBhbmVsKS5odG1sKCc8ZGl2IGNsYXNzPVwiZC1mbGV4IGp1c3RpZnktY29udGVudC1jZW50ZXJcIj48ZGl2IGNsYXNzPVwic3Bpbm5lci1ib3JkZXJcIiByb2xlPVwic3RhdHVzXCI+PHNwYW4gY2xhc3M9XCJzci1vbmx5XCI+TG9hZGluZy4uLjwvc3Bhbj48L2Rpdj48L2Rpdj4nKTtcbiAgICAkLmdldEpTT04oIFwiL2FwaS9wcml2YXRlL21lbWJlcnNoaXAvcHJlZmVyZW5jZXNcIiwge1xuICAgICAgICB0YWI6IHRhYixcbiAgICAgICAgYWN0aW9uOiAnbG9hZCcsXG4gICAgICAgIGZvcm1hdDogXCJqc29uXCIsXG4gICAgfSlcbiAgICAuZG9uZShmdW5jdGlvbiggZGF0YSApIHtcbiAgICAgICAgaWYgKGRhdGEuc3VjY2Vzcykge1xuICAgICAgICAgICAgJCh0YWJwYW5lbCkuaHRtbCggZGF0YS5odG1sICk7XG4gICAgICAgIH1cbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gZm9ybVN1Ym1pdCgpIHtcbiAgICAkKCdmb3JtJykuc3VibWl0KGZ1bmN0aW9uKCkge1xuICAgICAgICAkLmFqYXgoeyAvLyBjcmVhdGUgYW4gQUpBWCBjYWxsLi4uXG4gICAgICAgICAgICBkYXRhOiAkKHRoaXMpLnNlcmlhbGl6ZSgpLCAvLyBnZXQgdGhlIGZvcm0gZGF0YVxuICAgICAgICAgICAgdHlwZTogJCh0aGlzKS5hdHRyKCdtZXRob2QnKSwgLy8gR0VUIG9yIFBPU1RcbiAgICAgICAgICAgIHVybDogJCh0aGlzKS5hdHRyKCdhY3Rpb24nKSwgLy8gdGhlIGZpbGUgdG8gY2FsbFxuICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24ocmVzcG9uc2UpIHsgLy8gb24gc3VjY2Vzcy4uXG4gICAgICAgICAgICAgICAgbG9hZFByZWZlcmVuY2VzQ29udGVudCgpO1xuICAgICAgICAgICAgICAgICQoJyNwcmVmZXJlbmNlc01vZGFsJykubW9kYWwoJ2hpZGUnKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICAgIHJldHVybiBmYWxzZTsgLy8gY2FuY2VsIG9yaWdpbmFsIGV2ZW50IHRvIHByZXZlbnQgZm9ybSBzdWJtaXR0aW5nXG4gICAgfSk7XG59XG4iXSwic291cmNlUm9vdCI6IiJ9