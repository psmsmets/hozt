(window.webpackJsonp=window.webpackJsonp||[]).push([["tryout_enrolled"],{"5o5y":function(n,e,t){(function(n,e){var t;n.fn.sortElements=(t=[].sort,function(n,e){e=e||function(){return this};var o=this.map((function(){var n=e.call(this),t=n.parentNode,o=t.insertBefore(document.createTextNode(""),n.nextSibling);return function(){if(t===this)throw new Error("You can't sort elements if any one is a descendant of another.");t.insertBefore(this,o),t.removeChild(o)}}));return t.call(this,n).each((function(n){o[n].call(e.call(this))}))}),e(window).on("load",(function(){e.each(e(".api_load_tryout_enrolled"),(function(n,t){var o=e(t).data("tryout");e.getJSON("/api/ingeschreven/testmoment/"+o,{}).done((function(n){e(t).html(n.content);var r=e("#"+o);e("#"+o+" th.sortable").wrapInner('<button class="btn btn-link btn-sm"/>').each((function(){var n=e(this),t=n.index(),i=!1;n.click((function(){e("#"+o+" th button").removeClass("dropdown-toggle"),e(n).children("button").addClass("dropdown-toggle"),e(n).removeClass(i?"dropup":"dropdown").addClass(i?"dropdown":"dropup"),r.find("td").filter((function(){return e(this).index()===t})).sortElements((function(n,t){return e.text([n])>e.text([t])?i?-1:1:i?1:-1}),(function(){return this.parentNode})),i=!i}))}))}))}))})),e.each(e(".send-reminder"),(function(n,t){e(t).click((function(){var n=e(t).data("tryout");e(t).html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> verzenden'),e(t).prop("disabled",!0),alert("Reminder emails worden verzonden."),e.getJSON("/api/herinnering/testmoment/"+n,{}).done((function(n){n.success?e(t).html('<i class="fas fa-check"></i> reminder'):e(t).html('<i class="fas fa-times"></i> reminder'),alert(n.message)}))}))}))}).call(this,t("EVdn"),t("EVdn"))}},[["5o5y","runtime",0]]]);