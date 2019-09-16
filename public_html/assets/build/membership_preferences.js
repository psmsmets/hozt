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
  var action = button.data('action');
  var id = button.data('id'); // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

  var modal = $(this).find('.modal-dialog');
  modal.html('<div class="spinner-border mx-auto" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>');
  preferencesAction(tab, action, id, modal);
});

function preferencesAction(tab) {
  var action = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'new';
  var id = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  var obj = arguments.length > 3 ? arguments[3] : undefined;
  $.getJSON("/api/private/membership/preferences", {
    tab: tab,
    action: action,
    id: id,
    format: "json"
  }).done(function (data) {
    if (data.success) {
      if (action !== 'remove') {
        obj.html(data.html);
        formSubmit();
      }
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
        //$('#created').html(response); // update the DIV
        loadPreferencesContent();
        $('#preferencesModal').modal('hide');
      }
    });
    return false; // cancel original event to prevent form submitting
  });
}

$("button[data-action='remove']").each(function () {
  $(this).click(function () {
    if (confirm('Bent u zeker?')) {
      preferencesAction($(this).data('tab'), $(this).data('action'), $(this).data('id'));
      loadPreferencesContent();
    }
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/membership_preferences.js","runtime","vendors~calendar~carousel~eu_cookie~form_default~form_extended~hozt~membership_competitions~membersh~262175ed","vendors~carousel~hozt~membership_competitions~membership_preferences"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbWVtYmVyc2hpcF9wcmVmZXJlbmNlcy5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsIm9uIiwiZXZlbnQiLCJidXR0b24iLCJyZWxhdGVkVGFyZ2V0IiwidGFiIiwiZGF0YSIsImFjdGlvbiIsImlkIiwibW9kYWwiLCJmaW5kIiwiaHRtbCIsInByZWZlcmVuY2VzQWN0aW9uIiwib2JqIiwiZ2V0SlNPTiIsImZvcm1hdCIsImRvbmUiLCJzdWNjZXNzIiwiZm9ybVN1Ym1pdCIsImxvYWRQcmVmZXJlbmNlc0NvbnRlbnQiLCJhY3RpdmUiLCJ0YWJwYW5lbCIsInN1Ym1pdCIsImFqYXgiLCJzZXJpYWxpemUiLCJ0eXBlIiwiYXR0ciIsInVybCIsInJlc3BvbnNlIiwiZWFjaCIsImNsaWNrIiwiY29uZmlybSJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUFBLDREQUFPLENBQUMsZ0VBQUQsQ0FBUDs7QUFFQUMsQ0FBQyxDQUFDLG1CQUFELENBQUQsQ0FBdUJDLEVBQXZCLENBQTBCLGVBQTFCLEVBQTJDLFVBQVVDLEtBQVYsRUFBaUI7QUFDMUQsTUFBSUMsTUFBTSxHQUFHSCxDQUFDLENBQUNFLEtBQUssQ0FBQ0UsYUFBUCxDQUFkLENBRDBELENBQ3RCOztBQUNwQyxNQUFJQyxHQUFHLEdBQUdGLE1BQU0sQ0FBQ0csSUFBUCxDQUFZLEtBQVosQ0FBVjtBQUNBLE1BQUlDLE1BQU0sR0FBR0osTUFBTSxDQUFDRyxJQUFQLENBQVksUUFBWixDQUFiO0FBQ0EsTUFBSUUsRUFBRSxHQUFHTCxNQUFNLENBQUNHLElBQVAsQ0FBWSxJQUFaLENBQVQsQ0FKMEQsQ0FLMUQ7QUFDQTs7QUFDQSxNQUFJRyxLQUFLLEdBQUdULENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUVUsSUFBUixDQUFhLGVBQWIsQ0FBWjtBQUNBRCxPQUFLLENBQUNFLElBQU4sQ0FBVyxvSUFBWDtBQUNBQyxtQkFBaUIsQ0FBRVAsR0FBRixFQUFPRSxNQUFQLEVB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QjtBQUNBYSw0QkFBc0I7QUFDekI7QUFDSixHQUxEO0FBTUgsQ0FQRCxFIiwiZmlsZSI6Im1lbWJlcnNoaXBfcHJlZmVyZW5jZXMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJyZXF1aXJlKCdib290c3RyYXAnKTtcblxuJCgnI3ByZWZlcmVuY2VzTW9kYWwnKS5vbignc2hvdy5icy5tb2RhbCcsIGZ1bmN0aW9uIChldmVudCkge1xuICB2YXIgYnV0dG9uID0gJChldmVudC5yZWxhdGVkVGFyZ2V0KSAvLyBCdXR0b24gdGhhdCB0cmlnZ2VyZWQgdGhlIG1vZGFsXG4gIHZhciB0YWIgPSBidXR0b24uZGF0YSgndGFiJylcbiAgdmFyIGFjdGlvbiA9IGJ1dHRvbi5kYXRhKCdhY3Rpb24nKVxuICB2YXIgaWQgPSBidXR0b24uZGF0YSgnaWQnKVxuICAvLyBJZiBuZWNlc3NhcnksIHlvdSBjb3VsZCBpbml0aWF0ZSBhbiBBSkFYIHJlcXVlc3QgaGVyZSAoYW5kIHRoZW4gZG8gdGhlIHVwZGF0aW5nIGluIGEgY2FsbGJhY2spLlxuICAvLyBVcGRhdGUgdGhlIG1vZGFsJ3MgY29udGVudC4gV2UnbGwgdXNlIGpRdWVyeSBoZXJlLCBidXQgeW91IGNvdWxkIHVzZSBhIGRhdGEgYmluZGluZyBsaWJyYXJ5IG9yIG90aGVyIG1ldGhvZHMgaW5zdGVhZC5cbiAgdmFyIG1vZGFsID0gJCh0aGlzKS5maW5kKCcubW9kYWwtZGlhbG9nJylcbiAgbW9kYWwuaHRtbCgnPGRpdiBjbGFzcz1cInNwaW5uZXItYm9yZGVyIG14LWF1dG9cIiBzdHlsZT1cIndpZHRoOiAzcmVtOyBoZWlnaHQ6IDNyZW07XCIgcm9sZT1cInN0YXR1c1wiPjxzcGFuIGNsYXNzPVwic3Itb25seVwiPkxvYWRpbmcuLi48L3NwYW4+PC9kaXY+Jyk7XG4gIHByZWZlcmVuY2VzQWN0aW9uKCB0YWIsIGFjdGlvbiwgaWQsIG1vZGFsICk7XG59KTtcblxuZnVuY3Rpb24gcHJlZmVyZW5jZXNBY3Rpb24oIHRhYiwgYWN0aW9uID0gJ25ldycsIGlkID0gbnVsbCwgb2JqICkge1xuICAgICQuZ2V0SlNPTiggXCIvYXBpL3ByaXZhdGUvbWVtYmVyc2hpcC9wcmVmZXJlbmNlc1wiLCB7XG4gICAgICAgIHRhYjogdGFiLFxuICAgICAgICBhY3Rpb246IGFjdGlvbixcbiAgICAgICAgaWQ6IGlkLFxuICAgICAgICBmb3JtYXQ6IFwianNvblwiLFxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGRhdGEgKSB7XG4gICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MpIHtcbiAgICAgICAgICAgIGlmIChhY3Rpb24gIT09ICdyZW1vdmUnKSB7IFxuICAgICAgICAgICAgICAgIG9iai5odG1sKCBkYXRhLmh0bWwgKTtcbiAgICAgICAgICAgICAgICBmb3JtU3VibWl0KCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gbG9hZFByZWZlcmVuY2VzQ29udGVudCgpIHtcbiAgICB2YXIgYWN0aXZlID0gJCgnI3ByZWZlcmVuY2VzLXRhYicpLmZpbmQoJy5hY3RpdmUnKTtcbiAgICB2YXIgdGFiID0gYWN0aXZlLmRhdGEoJ3RhYicpO1xuICAgIHZhciB0YWJwYW5lbCA9ICQoJyNwcmVmZXJlbmNlcy0nK3RhYik7XG4gICAgJCh0YWJwYW5lbCkuaHRtbCgnPGRpdiBjbGFzcz1cImQtZmxleCBqdXN0aWZ5LWNvbnRlbnQtY2VudGVyXCI+PGRpdiBjbGFzcz1cInNwaW5uZXItYm9yZGVyXCIgcm9sZT1cInN0YXR1c1wiPjxzcGFuIGNsYXNzPVwic3Itb25seVwiPkxvYWRpbmcuLi48L3NwYW4+PC9kaXY+PC9kaXY+Jyk7XG4gICAgJC5nZXRKU09OKCBcIi9hcGkvcHJpdmF0ZS9tZW1iZXJzaGlwL3ByZWZlcmVuY2VzXCIsIHtcbiAgICAgICAgdGFiOiB0YWIsXG4gICAgICAgIGFjdGlvbjogJ2xvYWQnLFxuICAgICAgICBmb3JtYXQ6IFwianNvblwiLFxuICAgIH0pXG4gICAgLmRvbmUoZnVuY3Rpb24oIGRhdGEgKSB7XG4gICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MpIHtcbiAgICAgICAgICAgICQodGFicGFuZWwpLmh0bWwoIGRhdGEuaHRtbCApO1xuICAgICAgICB9XG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIGZvcm1TdWJtaXQoKSB7XG4gICAgJCgnZm9ybScpLnN1Ym1pdChmdW5jdGlvbigpIHtcbiAgICAgICAgJC5hamF4KHsgLy8gY3JlYXRlIGFuIEFKQVggY2FsbC4uLlxuICAgICAgICAgICAgZGF0YTogJCh0aGlzKS5zZXJpYWxpemUoKSwgLy8gZ2V0IHRoZSBmb3JtIGRhdGFcbiAgICAgICAgICAgIHR5cGU6ICQodGhpcykuYXR0cignbWV0aG9kJyksIC8vIEdFVCBvciBQT1NUXG4gICAgICAgICAgICB1cmw6ICQodGhpcykuYXR0cignYWN0aW9uJyksIC8vIHRoZSBmaWxlIHRvIGNhbGxcbiAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKHJlc3BvbnNlKSB7IC8vIG9uIHN1Y2Nlc3MuLlxuICAgICAgICAgICAgICAgIC8vJCgnI2NyZWF0ZWQnKS5odG1sKHJlc3BvbnNlKTsgLy8gdXBkYXRlIHRoZSBESVZcbiAgICAgICAgICAgICAgICBsb2FkUHJlZmVyZW5jZXNDb250ZW50KCk7XG4gICAgICAgICAgICAgICAgJCgnI3ByZWZlcmVuY2VzTW9kYWwnKS5tb2RhbCgnaGlkZScpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICAgICAgcmV0dXJuIGZhbHNlOyAvLyBjYW5jZWwgb3JpZ2luYWwgZXZlbnQgdG8gcHJldmVudCBmb3JtIHN1Ym1pdHRpbmdcbiAgICB9KTtcbn1cblxuJChcImJ1dHRvbltkYXRhLWFjdGlvbj0ncmVtb3ZlJ11cIikuZWFjaChmdW5jdGlvbigpe1xuICAgICQodGhpcykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICAgaWYgKGNvbmZpcm0oJ0JlbnQgdSB6ZWtlcj8nKSkge1xuICAgICAgICAgICAgcHJlZmVyZW5jZXNBY3Rpb24oICQodGhpcykuZGF0YSgndGFiJyksICQodGhpcykuZGF0YSgnYWN0aW9uJyksICQodGhpcykuZGF0YSgnaWQnKSApO1xuICAgICAgICAgICAgbG9hZFByZWZlcmVuY2VzQ29udGVudCgpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcbiJdLCJzb3VyY2VSb290IjoiIn0=