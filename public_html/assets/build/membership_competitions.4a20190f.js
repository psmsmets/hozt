(window.webpackJsonp=window.webpackJsonp||[]).push([["membership_competitions"],{nqpY:function(t,n,i){(function(t){function n(t,n){return function(t){if(Array.isArray(t))return t}(t)||function(t,n){if(!(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t)))return;var i=[],e=!0,o=!1,a=void 0;try{for(var s,c=t[Symbol.iterator]();!(e=(s=c.next()).done)&&(i.push(s.value),!n||i.length!==n);e=!0);}catch(t){o=!0,a=t}finally{try{e||null==c.return||c.return()}finally{if(o)throw a}}return i}(t,n)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}()}i("SYky");var e='<i class="fas fa-square text-medium h4"></i>',o='<button class="btn btn-success btn-sm"><i class="fas fa-check" data-value="true"></i></button>',a='<button class="btn btn-warning btn-sm text-light"><i class="fas fa-minus" data-value="false"></i></button>';function s(){t.getJSON("/api/private/membership/competitions",{format:"json",action:"load"}).done((function(n){if(n.success){var i=0;t.each(n.data,(function(n,s){var c=t("#competition-enrolment-"+s.competitionpart+"-"+s.member);s.disabled?t(c).html(e):s.enrolled?t(c).html(o):t(c).html(a),!s.enrolledAt&&s.editable&&(i+=1)})),i&&t("#competitions-new-tab span").html(i)}}))}function c(){var i=arguments.length>0&&void 0!==arguments[0]&&arguments[0];t("tr:not(.d-none) td[id^='competition-enrolment-']").each((function(){void 0!==t("i",this).attr("data-value")&&(i?t(this).click((function(){!function(i){if(!t(i).hasClass("editing")){t(i).addClass("editing");var e=n(i.id.split("-"),4),s=(e[0],e[1],e[2]),c=e[3],r=!t("i",i).data("value");t.getJSON("/api/private/membership/competitions",{format:"json",action:"edit",competitionpart:s,member:c,enrolled:r?1:0}).done((function(n){r?t(i).html(o):t(i).html(a),t(i).removeClass("editing")}))}}(this)})):t(this).unbind())}))}function r(n){switch(t("tr.competition").removeClass("d-none"),n.id){case"competitions-all-tab":break;case"competitions-new-tab":t("tr.competition").addClass("d-none"),t("tr.competition-new").removeClass("d-none");break;case"competitions-upcoming-tab":t("tr.competition-past").addClass("d-none")}}s();var l=!1;t(document).ready((function(){t(".competition-past").hide(),t("#competitions-edit").click((function(){l?(t(this).html('<i class="fas fa-lock"></i> bewerken'),t("#competitions-tab > a").removeClass("disabled"),t("tr.competition-locked").removeClass("d-none"),r(t("#competitions-tab").find(".active")[0]),c(!1),s()):(t(this).html('<i class="fas fa-lock-open"></i> afronden'),t("#competitions-tab > a").addClass("disabled"),t("tr.competition-locked").addClass("d-none"),c(!0)),l=!l})),t("#competitions-tab").on("show.bs.tab",(function(t){r(t.target)}))}))}).call(this,i("EVdn"))}},[["nqpY","runtime",0,1]]]);