(window.webpackJsonp=window.webpackJsonp||[]).push([["membership_preferences"],{mKiv:function(e,t,a){(function(e){a("SYky"),e("#preferencesModal").on("show.bs.modal",(function(t){var a=e(t.relatedTarget),n=a.data("tab"),s=a.data("form"),i=a.data("action"),r=a.data("id"),o=e(this).find(".modal-dialog");o.html('<div class="spinner-border mx-auto" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>'),function(t,a){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"edit",s=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null,i=arguments.length>4?arguments[4]:void 0;e.getJSON("/api/private/membership/preferences",{tab:t,form:a,action:n,id:s,format:"json"}).done((function(t){t.success&&(i.html(t.html),e("form").submit((function(){return e.ajax({data:e(this).serialize(),type:e(this).attr("method"),url:e(this).attr("action"),success:function(t){var a,n;a=e("#preferences-tab").find(".active").data("tab"),n=e("#preferences-"+a),e(n).html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>'),e.getJSON("/api/private/membership/preferences",{tab:a,action:"load",format:"json"}).done((function(t){t.success&&e(n).html(t.html)})),e("#preferencesModal").modal("hide")}}),!1})))}))}(n,s,i,r,o)}))}).call(this,a("EVdn"))}},[["mKiv","runtime",0,1]]]);