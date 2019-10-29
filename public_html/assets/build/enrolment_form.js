(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["enrolment_form"],{

/***/ "./assets/js/enrolment_form.js":
/*!*************************************!*\
  !*** ./assets/js/enrolment_form.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$('input.form-control[data-category-title]').each(function () {
  var formGroup = $(this).parent();
  $('<h4 class="pt-4">' + $(this).data('category-title') + '</h4>').insertBefore(formGroup);
});
$('input.form-control[data-category-description]').each(function () {
  var formGroup = $(this).parent();
  $('<p>' + $(this).data('category-description') + '<p>').insertBefore(formGroup);
});
$(".form-control[data-parent-class]").each(function () {
  var formGroup = $(this).parent();
  $(formGroup).addClass($(this).data('parent-class'));
});
$(".form-control[data-parent-parent-class]").each(function () {
  var formGroup = $(this).parent().parent();
  $(formGroup).addClass($(this).data('parent-parent-class'));
});

function getTotals() {
  var totalDefault = 0;
  var totalIncluded = 0;
  var totalSupplement = 0;
  var totalPrice = 0.;
  $('input.form-control[data-category-type]').each(function () {
    if ($(this).val() == '') {
      return true;
    }

    value = parseInt($(this).val());

    if ($(this).data('category-type') === 'default') {
      totalDefault += value;

      if (typeof $(this).data('value') !== 'undefined') {
        totalPrice += value * parseFloat($(this).data('value'));
      }
    } else if ($(this).data('category-type') === 'included') {
      totalIncluded += value;
    } else if ($(this).data('category-type') === 'supplement') {
      totalSupplement += value;

      if (typeof $(this).data('value') !== 'undefined') {
        totalPrice += value * parseFloat($(this).data('value'));
      }
    }
  });
  $('input#enrolment_form_totalPrice').val(totalPrice.toFixed(2).replace(".", ","));
  $('input#enrolment_form_numberOfPersons').val(totalDefault);
  return {
    "default": totalDefault,
    "included": totalIncluded,
    "supplement": totalSupplement,
    "totalPrice": totalPrice
  };
}

function setMaxIncluded(totals) {
  $('input.form-control[data-category-type="included"]').each(function () {
    maxVal = totals["default"] - totals.included;

    if ($(this).val() != '') {
      maxVal += parseInt($(this).val());
    }

    $(this).attr({
      "max": maxVal
    });
  });
}

function setDefaultRequired(totals) {
  if (totals["default"] == 0) {
    $('input.form-control[data-category-type="default"]').attr("min", 1);
  } else {
    $('input.form-control[data-category-type="default"]').attr("min", 0);
  }
}

$('input.form-control[data-category-type]').each(function () {
  $(this).focusout(function () {
    var totals = getTotals();

    if ($(this).data('category-type') !== 'supplement') {
      setMaxIncluded(totals);
    }

    setDefaultRequired(totals);
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/enrolment_form.js","runtime","vendors~calendar~carousel~enrolment_form~eu_cookie~form_default~form_extended~hozt~membership_compet~607ea275"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZW5yb2xtZW50X2Zvcm0uanMiXSwibmFtZXMiOlsiJCIsImVhY2giLCJmb3JtR3JvdXAiLCJwYXJlbnQiLCJkYXRhIiwiaW5zZXJ0QmVmb3JlIiwiYWRkQ2xhc3MiLCJnZXRUb3RhbHMiLCJ0b3RhbERlZmF1bHQiLCJ0b3RhbEluY2x1ZGVkIiwidG90YWxTdXBwbGVtZW50IiwidG90YWxQcmljZSIsInZhbCIsInZhbHVlIiwicGFyc2VJbnQiLCJwYXJzZUZsb2F0IiwidG9GaXhlZCIsInJlcGxhY2UiLCJzZXRNYXhJbmNsdWRlZCIsInRvdGFscyIsIm1heFZhbCIsImluY2x1ZGVkIiwiYXR0ciIsInNldERlZmF1bHRSZXF1aXJlZCIsImZvY3Vzb3V0Il0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQUEsMENBQUMsQ0FBQyx5Q0FBRCxDQUFELENBQTZDQyxJQUE3QyxDQUFrRCxZQUFVO0FBQ3hELE1BQUlDLFNBQVMsR0FBR0YsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRRyxNQUFSLEVBQWhCO0FBQ0FILEdBQUMsQ0FBRSxzQkFBc0JBLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUUksSUFBUixDQUFhLGdCQUFiLENBQXRCLEdBQXVELE9BQXpELENBQUQsQ0FBb0VDLFlBQXBFLENBQWlGSCxTQUFqRjtBQUNILENBSEQ7QUFLQUYsQ0FBQyxDQUFDLCtDQUFELENBQUQsQ0FBbURDLElBQW5ELENBQXdELFlBQVU7QUFDOUQsTUFBSUMsU0FBUyxHQUFHRixDQUFDLENBQUMsSUFBRCxDQUFELENBQVFHLE1BQVIsRUFBaEI7QUFDQUgsR0FBQyxDQUFFLFFBQVFBLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUUksSUFBUixDQUFhLHNCQUFiLENBQVIsR0FBK0MsS0FBakQsQ0FBRCxDQUEwREMsWUFBMUQsQ0FBdUVILFNBQXZFO0FBQ0gsQ0FIRDtBQUtBRixDQUFDLENBQUMsa0NBQUQsQ0FBRCxDQUFzQ0MsSUFBdEMsQ0FBMkMsWUFB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Q0UsUUFBakM7O0FBQ0EsUUFBSXJCLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUVksR0FBUixNQUFpQixFQUFyQixFQUF5QjtBQUNyQlEsWUFBTSxJQUFJTixRQUFRLENBQUNkLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUVksR0FBUixFQUFELENBQWxCO0FBQ0g7O0FBQ0RaLEtBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUXNCLElBQVIsQ0FBYTtBQUNULGFBQVFGO0FBREMsS0FBYjtBQUdILEdBUkQ7QUFTSDs7QUFFRCxTQUFTRyxrQkFBVCxDQUE0QkosTUFBNUIsRUFBb0M7QUFDaEMsTUFBSUEsTUFBTSxXQUFOLElBQWtCLENBQXRCLEVBQXlCO0FBQ3ZCbkIsS0FBQyxDQUFDLGtEQUFELENBQUQsQ0FBc0RzQixJQUF0RCxDQUEyRCxLQUEzRCxFQUFpRSxDQUFqRTtBQUNELEdBRkQsTUFFTztBQUNMdEIsS0FBQyxDQUFDLGtEQUFELENBQUQsQ0FBc0RzQixJQUF0RCxDQUEyRCxLQUEzRCxFQUFpRSxDQUFqRTtBQUNEO0FBQ0o7O0FBRUR0QixDQUFDLENBQUMsd0NBQUQsQ0FBRCxDQUE0Q0MsSUFBNUMsQ0FBaUQsWUFBVTtBQUN2REQsR0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRd0IsUUFBUixDQUFpQixZQUFVO0FBQ3ZCLFFBQUlMLE1BQU0sR0FBR1osU0FBUyxFQUF0Qjs7QUFDQSxRQUFJUCxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFJLElBQVIsQ0FBYSxlQUFiLE1BQWtDLFlBQXRDLEVBQXFEO0FBQ2pEYyxvQkFBYyxDQUFDQyxNQUFELENBQWQ7QUFDSDs7QUFDREksc0JBQWtCLENBQUNKLE1BQUQsQ0FBbEI7QUFDSCxHQU5EO0FBT0gsQ0FSRCxFIiwiZmlsZSI6ImVucm9sbWVudF9mb3JtLmpzIiwic291cmNlc0NvbnRlbnQiOlsiJCgnaW5wdXQuZm9ybS1jb250cm9sW2RhdGEtY2F0ZWdvcnktdGl0bGVdJykuZWFjaChmdW5jdGlvbigpe1xuICAgIHZhciBmb3JtR3JvdXAgPSAkKHRoaXMpLnBhcmVudCgpO1xuICAgICQoICc8aDQgY2xhc3M9XCJwdC00XCI+JyArICQodGhpcykuZGF0YSgnY2F0ZWdvcnktdGl0bGUnKSArICc8L2g0PicgKS5pbnNlcnRCZWZvcmUoZm9ybUdyb3VwKTtcbn0pO1xuXG4kKCdpbnB1dC5mb3JtLWNvbnRyb2xbZGF0YS1jYXRlZ29yeS1kZXNjcmlwdGlvbl0nKS5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgdmFyIGZvcm1Hcm91cCA9ICQodGhpcykucGFyZW50KCk7XG4gICAgJCggJzxwPicgKyAkKHRoaXMpLmRhdGEoJ2NhdGVnb3J5LWRlc2NyaXB0aW9uJykgKyAnPHA+JyApLmluc2VydEJlZm9yZShmb3JtR3JvdXApO1xufSk7XG5cbiQoXCIuZm9ybS1jb250cm9sW2RhdGEtcGFyZW50LWNsYXNzXVwiKS5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgdmFyIGZvcm1Hcm91cCA9ICQodGhpcykucGFyZW50KCk7XG4gICAgJChmb3JtR3JvdXApLmFkZENsYXNzKCQodGhpcykuZGF0YSgncGFyZW50LWNsYXNzJykpO1xufSk7XG5cbiQoXCIuZm9ybS1jb250cm9sW2RhdGEtcGFyZW50LXBhcmVudC1jbGFzc11cIikuZWFjaChmdW5jdGlvbigpe1xuICAgIHZhciBmb3JtR3JvdXAgPSAkKHRoaXMpLnBhcmVudCgpLnBhcmVudCgpO1xuICAgICQoZm9ybUdyb3VwKS5hZGRDbGFzcygkKHRoaXMpLmRhdGEoJ3BhcmVudC1wYXJlbnQtY2xhc3MnKSk7XG59KTtcblxuXG5mdW5jdGlvbiBnZXRUb3RhbHMoKSB7XG5cbiAgICB2YXIgdG90YWxEZWZhdWx0ID0gMDtcbiAgICB2YXIgdG90YWxJbmNsdWRlZCA9IDA7XG4gICAgdmFyIHRvdGFsU3VwcGxlbWVudCA9IDA7XG5cbiAgICB2YXIgdG90YWxQcmljZSA9IDAuO1xuXG4gICAgJCgnaW5wdXQuZm9ybS1jb250cm9sW2RhdGEtY2F0ZWdvcnktdHlwZV0nKS5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgICAgIGlmICgkKHRoaXMpLnZhbCgpID09ICcnKXtcbiAgICAgICAgICAgIHJldHVybiB0cnVlO1xuICAgICAgICB9XG4gICAgICAgIHZhbHVlID0gcGFyc2VJbnQoJCh0aGlzKS52YWwoKSk7XG4gICAgICAgIGlmICgkKHRoaXMpLmRhdGEoJ2NhdGVnb3J5LXR5cGUnKSA9PT0gJ2RlZmF1bHQnKSB7XG4gICAgICAgICAgICB0b3RhbERlZmF1bHQgKz0gdmFsdWU7XG4gICAgICAgICAgICBpZiAodHlwZW9mICQodGhpcykuZGF0YSgndmFsdWUnKSAhPT0gJ3VuZGVmaW5lZCcpIHtcbiAgICAgICAgICAgICAgICB0b3RhbFByaWNlICs9IHZhbHVlICogcGFyc2VGbG9hdCgkKHRoaXMpLmRhdGEoJ3ZhbHVlJykpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIGVsc2UgaWYgKCQodGhpcykuZGF0YSgnY2F0ZWdvcnktdHlwZScpID09PSAnaW5jbHVkZWQnKSB7XG4gICAgICAgICAgICB0b3RhbEluY2x1ZGVkICs9IHZhbHVlO1xuICAgICAgICB9XG4gICAgICAgIGVsc2UgaWYgKCQodGhpcykuZGF0YSgnY2F0ZWdvcnktdHlwZScpID09PSAnc3VwcGxlbWVudCcpIHtcbiAgICAgICAgICAgIHRvdGFsU3VwcGxlbWVudCArPSB2YWx1ZTtcbiAgICAgICAgICAgIGlmICh0eXBlb2YgJCh0aGlzKS5kYXRhKCd2YWx1ZScpICE9PSAndW5kZWZpbmVkJykge1xuICAgICAgICAgICAgICAgIHRvdGFsUHJpY2UgKz0gdmFsdWUgKiBwYXJzZUZsb2F0KCQodGhpcykuZGF0YSgndmFsdWUnKSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJ2lucHV0I2Vucm9sbWVudF9mb3JtX3RvdGFsUHJpY2UnKS52YWwodG90YWxQcmljZS50b0ZpeGVkKDIpLnJlcGxhY2UoXCIuXCIsIFwiLFwiKSk7XG4gICAgJCgnaW5wdXQjZW5yb2xtZW50X2Zvcm1fbnVtYmVyT2ZQZXJzb25zJykudmFsKHRvdGFsRGVmYXVsdCk7XG5cbiAgICByZXR1cm4ge1xuICAgICAgICBcImRlZmF1bHRcIiA6IHRvdGFsRGVmYXVsdCxcbiAgICAgICAgXCJpbmNsdWRlZFwiIDogdG90YWxJbmNsdWRlZCxcbiAgICAgICAgXCJzdXBwbGVtZW50XCIgOiB0b3RhbFN1cHBsZW1lbnQsXG4gICAgICAgIFwidG90YWxQcmljZVwiIDogdG90YWxQcmljZSxcbiAgICB9O1xufVxuXG5mdW5jdGlvbiBzZXRNYXhJbmNsdWRlZCh0b3RhbHMpIHtcbiAgICAkKCdpbnB1dC5mb3JtLWNvbnRyb2xbZGF0YS1jYXRlZ29yeS10eXBlPVwiaW5jbHVkZWRcIl0nKS5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgICAgIG1heFZhbCA9IHRvdGFscy5kZWZhdWx0IC0gdG90YWxzLmluY2x1ZGVkO1xuICAgICAgICBpZiAoJCh0aGlzKS52YWwoKSAhPSAnJykge1xuICAgICAgICAgICAgbWF4VmFsICs9IHBhcnNlSW50KCQodGhpcykudmFsKCkpO1xuICAgICAgICB9XG4gICAgICAgICQodGhpcykuYXR0cih7XG4gICAgICAgICAgICBcIm1heFwiIDogbWF4VmFsLFxuICAgICAgICB9KTtcbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gc2V0RGVmYXVsdFJlcXVpcmVkKHRvdGFscykge1xuICAgIGlmICh0b3RhbHMuZGVmYXVsdCA9PSAwKSB7XG4gICAgICAkKCdpbnB1dC5mb3JtLWNvbnRyb2xbZGF0YS1jYXRlZ29yeS10eXBlPVwiZGVmYXVsdFwiXScpLmF0dHIoXCJtaW5cIiwxKTtcbiAgICB9IGVsc2Uge1xuICAgICAgJCgnaW5wdXQuZm9ybS1jb250cm9sW2RhdGEtY2F0ZWdvcnktdHlwZT1cImRlZmF1bHRcIl0nKS5hdHRyKFwibWluXCIsMCk7XG4gICAgfVxufVxuXG4kKCdpbnB1dC5mb3JtLWNvbnRyb2xbZGF0YS1jYXRlZ29yeS10eXBlXScpLmVhY2goZnVuY3Rpb24oKXtcbiAgICAkKHRoaXMpLmZvY3Vzb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgIHZhciB0b3RhbHMgPSBnZXRUb3RhbHMoKTtcbiAgICAgICAgaWYgKCQodGhpcykuZGF0YSgnY2F0ZWdvcnktdHlwZScpICE9PSAnc3VwcGxlbWVudCcgKSB7XG4gICAgICAgICAgICBzZXRNYXhJbmNsdWRlZCh0b3RhbHMpO1xuICAgICAgICB9XG4gICAgICAgIHNldERlZmF1bHRSZXF1aXJlZCh0b3RhbHMpO1xuICAgIH0pO1xufSk7XG4iXSwic291cmNlUm9vdCI6IiJ9