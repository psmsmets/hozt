(window.webpackJsonp=window.webpackJsonp||[]).push([["hozt"],{GiOn:function(t,a,e){"use strict";e.d(a,"a",(function(){return i}));var n=function(){return(n=Object.assign||function(t){for(var a,e=1,n=arguments.length;e<n;e++)for(var i in a=arguments[e])Object.prototype.hasOwnProperty.call(a,i)&&(t[i]=a[i]);return t}).apply(this,arguments)},i=function(){function t(t,a,e){var i=this;this.target=t,this.endVal=a,this.options=e,this.version="2.0.4",this.defaults={startVal:0,decimalPlaces:0,duration:2,useEasing:!0,useGrouping:!0,smartEasingThreshold:999,smartEasingAmount:333,separator:",",decimal:".",prefix:"",suffix:""},this.finalEndVal=null,this.useEasing=!0,this.countDown=!1,this.error="",this.startVal=0,this.paused=!0,this.count=function(t){i.startTime||(i.startTime=t);var a=t-i.startTime;i.remaining=i.duration-a,i.useEasing?i.countDown?i.frameVal=i.startVal-i.easingFn(a,0,i.startVal-i.endVal,i.duration):i.frameVal=i.easingFn(a,i.startVal,i.endVal-i.startVal,i.duration):i.countDown?i.frameVal=i.startVal-(i.startVal-i.endVal)*(a/i.duration):i.frameVal=i.startVal+(i.endVal-i.startVal)*(a/i.duration),i.countDown?i.frameVal=i.frameVal<i.endVal?i.endVal:i.frameVal:i.frameVal=i.frameVal>i.endVal?i.endVal:i.frameVal,i.frameVal=Math.round(i.frameVal*i.decimalMult)/i.decimalMult,i.printValue(i.frameVal),a<i.duration?i.rAF=requestAnimationFrame(i.count):null!==i.finalEndVal?i.update(i.finalEndVal):i.callback&&i.callback()},this.formatNumber=function(t){var a,e,n,s,o,r=t<0?"-":"";if(a=Math.abs(t).toFixed(i.options.decimalPlaces),n=(e=(a+="").split("."))[0],s=e.length>1?i.options.decimal+e[1]:"",i.options.useGrouping){o="";for(var l=0,d=n.length;l<d;++l)0!==l&&l%3==0&&(o=i.options.separator+o),o=n[d-l-1]+o;n=o}return i.options.numerals&&i.options.numerals.length&&(n=n.replace(/[0-9]/g,(function(t){return i.options.numerals[+t]})),s=s.replace(/[0-9]/g,(function(t){return i.options.numerals[+t]}))),r+i.options.prefix+n+s+i.options.suffix},this.easeOutExpo=function(t,a,e,n){return e*(1-Math.pow(2,-10*t/n))*1024/1023+a},this.options=n({},this.defaults,e),this.formattingFn=this.options.formattingFn?this.options.formattingFn:this.formatNumber,this.easingFn=this.options.easingFn?this.options.easingFn:this.easeOutExpo,this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.endVal=this.validateValue(a),this.options.decimalPlaces=Math.max(this.options.decimalPlaces),this.decimalMult=Math.pow(10,this.options.decimalPlaces),this.resetDuration(),this.options.separator=String(this.options.separator),this.useEasing=this.options.useEasing,""===this.options.separator&&(this.options.useGrouping=!1),this.el="string"==typeof t?document.getElementById(t):t,this.el?this.printValue(this.startVal):this.error="[CountUp] target is null or undefined"}return t.prototype.determineDirectionAndSmartEasing=function(){var t=this.finalEndVal?this.finalEndVal:this.endVal;this.countDown=this.startVal>t;var a=t-this.startVal;if(Math.abs(a)>this.options.smartEasingThreshold){this.finalEndVal=t;var e=this.countDown?1:-1;this.endVal=t+e*this.options.smartEasingAmount,this.duration=this.duration/2}else this.endVal=t,this.finalEndVal=null;this.finalEndVal?this.useEasing=!1:this.useEasing=this.options.useEasing},t.prototype.start=function(t){this.error||(this.callback=t,this.duration>0?(this.determineDirectionAndSmartEasing(),this.paused=!1,this.rAF=requestAnimationFrame(this.count)):this.printValue(this.endVal))},t.prototype.pauseResume=function(){this.paused?(this.startTime=null,this.duration=this.remaining,this.startVal=this.frameVal,this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count)):cancelAnimationFrame(this.rAF),this.paused=!this.paused},t.prototype.reset=function(){cancelAnimationFrame(this.rAF),this.paused=!0,this.resetDuration(),this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.printValue(this.startVal)},t.prototype.update=function(t){cancelAnimationFrame(this.rAF),this.startTime=null,this.endVal=this.validateValue(t),this.endVal!==this.frameVal&&(this.startVal=this.frameVal,this.finalEndVal||this.resetDuration(),this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count))},t.prototype.printValue=function(t){var a=this.formattingFn(t);"INPUT"===this.el.tagName?this.el.value=a:"text"===this.el.tagName||"tspan"===this.el.tagName?this.el.textContent=a:this.el.innerHTML=a},t.prototype.ensureNumber=function(t){return"number"==typeof t&&!isNaN(t)},t.prototype.validateValue=function(t){var a=Number(t);return this.ensureNumber(a)?a:(this.error="[CountUp] invalid start or end value: "+t,null)},t.prototype.resetDuration=function(){this.startTime=null,this.duration=1e3*Number(this.options.duration),this.remaining=this.duration},t}()},a50V:function(t,a,e){"use strict";e.r(a),function(t){var a=e("GiOn");e("geyN"),e("SYky"),e("h1wg");var n,i=e("EVdn");window.$=i;var s=0,o=10,r=i("#nav-categories").outerHeight();function l(t,a,e,n){i.getJSON("/api/session/timeout",(function(s){var o=!0;s.success&&(s.elapsed<a?(o=!1,i(t).modal("hide")):s.elapsed<e&&(i("#sessionModalRemaining").html(e-elapsed),i(t).modal("show"))),o&&document.location.replace(n.data("logout"))})).fail((function(){document.location.reload(!0)}))}i(window).scroll((function(t){n=!0})),setInterval((function(){n&&(!function(){var t=i(window).scrollTop();if(Math.abs(s-t)<=o)return;t>s&&t>r?i("#nav-categories").animate({top:"-40px"},250):t+i(window).height()<i(document).height()&&i("#nav-categories").animate({top:"0"},250);s=t}(),n=!1)}),250),function(t){if(0!=i(t).length){var a=i("#sessionModal [data-logout]");l(t,900,1200,a),i(a).click((function(){document.location.replace(a.data("logout"))})),i(t).on("hide.bs.modal",(function(t){i.getJSON("/api/session/keep-alive")}));setInterval((function(){l(t,900,1200,a)}),15e3)}}(i("#sessionModal")),i(document).ready((function(){var t;i((function(){i('[data-toggle="tooltip"]').tooltip()})),i((function(){i('[data-toggle="popover"]').popover()})),i((function(){i('[data-toggle="offcanvas"]').on("click",(function(){i(".offcanvas-collapse").toggleClass("open")}))})),i("#toTop").click((function(t){i.scrollTo(0,700)})),i("#discoverModal").on("shown.bs.modal",(function(t){var e={useEasing:!0,useGrouping:!0,separator:",",decimal:".",duration:3},n=new a.a("countupTeams",i("#countupTeams").data("value"),e);n.error?console.error(n.error):n.start();var s=new a.a("countupCoaches",i("#countupCoaches").data("value"),e);s.error?console.error(s.error):s.start();var o=new a.a("countupMembers",i("#countupMembers").data("value"),e);o.error?console.error(o.error):o.start()}));var e,n=!1,s=document.getElementById("toTop"),o=i(".banner").css("backgroundPosition").split(" "),r=i(".banner").height()+i("#nav-categories").height(),l=(parseInt(o[1]),i(".scroll-fade-in")),d=i(".carousel-item");i(window).scroll((function(){(t=i(window).scrollTop())>=400&&!n&&(n=!0,s.style.visibility="visible",s.style.opacity="0",i("#toTop").animate({opacity:"1"},750)),t<400&&n&&(n=!1,i("#toTop").animate({opacity:"0"},750,(function(){s.style.visibility="hidden"}))),i(l).length>0&&i(l).each((function(t){i(window).scrollTop()>i(this).position().top-i(window).height()/3&&i(this).animate({opacity:"1"},{duration:1e3,specialEasing:{},complete:function(){i(this).removeClass("scroll-fade-in")}})})),i(d).length>0&&t<=r&&i(d).each((function(){e=50-2*((r-t)/r-1)*50*.45,i(this).children("img").css("top",Math.round(100*e)/100+"%")}))}))})),i(window).on("load",(function(){i("#api_load_module_tyr").html('<div class="row justify-content-around p-3"><div class="col col-8 col-md-10"><div class="tyr" data-toggle="tooltip" data-placement="bottom" title="" data-offset="0" data-original-title="Klik om de clubcode te kopiëren"><img class="mx-auto img-fluid" src="/assets/img/logo/tyr.png"><div class="text-center" style="margin-top:.5em; padding-bottom:0;">Clubcode <span id="tyr-clubcode" style="display:inline-block;" class="">HGS15ZM</span></div></div></div></div>'),i(".tyr").click((function(t){var a,e,n;a="tyr-clubcode",e=document.getElementById(a),(n=document.createElement("textarea")).value=e.textContent,document.body.appendChild(n),n.select(),document.execCommand("Copy"),n.remove(),function(t,a){i("#"+t).removeClass().addClass(a+" animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",(function(){i(this).removeClass()}))}("tyr-clubcode","tada"),setTimeout((function(){window.open("http://www.tyr.nl","_blank")}),1e3)})),function(){var t="api_load_module_competition_programs";i("#"+t).html('<div class="p-3"><h5 class="pb-2 mb-0">Programma\'s</h5><div id="'+t+'_items"></div></div>'),i.getJSON("/api/documenten/wedstrijden/aanstaande/programma/5",{format:"json"}).done((function(a){a.result?i.each(a.data,(function(a,e){var n='<div class="ml-3 small"><a class="text-dark" href="'+e.doc+'" target="_Blank"><span class="text-muted mr-2">'+e.datestr+"</span>"+e.title+"</a></div>";i(n).appendTo("#"+t+"_items")})):i('<div class="small ml-3">Geen programma\'s gevonden</div>').appendTo("#"+t+"_items")}))}(),function(){var t="api_load_module_competition_results";i("#"+t).html('<div class="p-3"><h5 class="pb-2 mb-0">Uitslagen</h5><div id="'+t+'_items"></div></div>'),i.getJSON("/api/documenten/wedstrijden/laatste/uitslag/5",{format:"json"}).done((function(a){a.result?i.each(a.data,(function(a,e){var n='<div class="ml-3 small"><a class="text-dark" href="'+e.url+'"><span class="text-muted mr-2">'+e.datestr+"</span>"+e.title+"</a></div>";i(n).appendTo("#"+t+"_items")})):i('<div class="small ml-3">Geen wedstrijd uitslagen gevonden</div>').appendTo("#"+t+"_items")}))}(),function(){var t="api_load_module_training_today";i("#"+t).html('<div class="pt-3 pb-3 pl-3 pr-0"><h5 class="pb-2 mb-0">Trainingsuren <span class="badge badge-primary font-weight-light align-text-top">vandaag</span></h5><div id="'+t+'_items"></div></div>'),i.getJSON("/api/training/vandaag",{format:"json"}).done((function(a){a.result?i.each(a.data,(function(a,e){var n='<div class="row no-gutters"><div class="col-5 col-md-9 col-lg-6 text-right pt-1 small">'+e.time+"</div>";n+='<div class="col-7 col-md-3 col-lg-6 pl-1">',i.each(e.teams,(function(t,a){n+='<span class="badge badge-primary badge-team ml-1">'+a.abbr+"</span>"})),e.comment&&(n+='<span class="badge badge-secondary ml-1">'+e.comment+"</span>"),i(n+="</div></div>").appendTo("#"+t+"_items")})):i('<div class="small ml-3">Er is vandaag geen training</div>').appendTo("#"+t+"_items")}))}(),function(){var t="api_load_module_training_tomorrow";i("#"+t).html('<div class="pt-3 pb-3 pl-3 pr-0"><h5 class="pb-2 mb-0">Trainingsuren <span class="badge badge-medium font-weight-light align-text-top">morgen</span></h5><div id="'+t+'_items"></div></div>'),i.getJSON("/api/training/morgen",{format:"json"}).done((function(a){a.result?i.each(a.data,(function(a,e){var n='<div class="row no-gutters"><div class="col-5 col-md-9 col-lg-6 text-right pt-1 small">'+e.time+"</div>";n+='<div class="col-7 col-md-3 col-lg-6 pl-1">',i.each(e.teams,(function(t,a){n+='<span class="badge badge-primary badge-team ml-1">'+a.abbr+"</span>"})),e.comment&&(n+='<span class="badge badge-secondary ml-1">'+e.comment+"</span>"),i(n+="</div></div>").appendTo("#"+t+"_items")})):i('<div class="small ml-3">Er is morgen geen training</div>').appendTo("#"+t+"_items")}))}(),function(){i("#api_load_module_calendar_upcoming").html('<div class="p-3"><h5 class="pb-2 mb-0">Kalender</h5><div id="api_load_module_calendar_upcoming_items"></div></div>');var t="#api_load_module_calendar_upcoming_items";i.getJSON("/api/kalender/aanstaande",{format:"json"}).done((function(a){a.result?(i.each(a.data,(function(a,e){var n="";n+='<div class="media cal cal-link pt-2" onclick="window.location=\''+e.url+"';\">",n+='  <span class="badge badge-dark mr-2 cal cal-sm '+e.class,n+='">'+e.day+"<br>"+e.month+"</span>",n+='  <div class="media-body pb-2 mb-0 small lh-125 border-bottom border-gray ',e.cancelled?n+="cal-cancelled text-danger":n+="text-muted",n+='">',n+='    <div class="d-flex justify-content-between align-items-center w-100">',n+='      <strong class="text-gray-dark">'+e.title+"</strong>",n+='      <a href="#" class="d-none">Bekijk</a>',n+="    </div>",n+='    <span class="d-block">'+e.formattedPeriod+"</span>",n+="  </div>",i(n+="</div>").appendTo(t)})),i('<p class="small mt-2 text-right"><a href="/kalender"><i class="fas fa-calendar-plus"></i> Alle events</a></p>').appendTo(t)):i("<p>Er zijn geen events</p>").appendTo(t)}))}()})),i(".scheduleNotice").each((function(){var t=i(this).data("cname"),a=i(this).data("cvalue");i(this).on("closed.bs.alert",(function(){!function(t,a,e){var n=new Date;n.setTime(n.getTime()+24*e*60*60*1e3);var i="expires="+n.toUTCString();document.cookie=t+"="+a+";"+i+";path=/"}(t,a,60)}))}))}.call(this,e("EVdn"))},geyN:function(t,a,e){},h1wg:function(t,a,e){var n,i,s;
/*!
 * jQuery.scrollTo
 * Copyright (c) 2007-2015 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Licensed under MIT
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 * @projectDescription Lightweight, cross-browser and highly customizable animated scrolling with jQuery
 * @author Ariel Flesler
 * @version 2.1.2
 */!function(o){"use strict";i=[e("EVdn")],void 0===(s="function"==typeof(n=function(t){var a=t.scrollTo=function(a,e,n){return t(window).scrollTo(a,e,n)};function e(a){return!a.nodeName||-1!==t.inArray(a.nodeName.toLowerCase(),["iframe","#document","html","body"])}function n(a){return t.isFunction(a)||t.isPlainObject(a)?a:{top:a,left:a}}return a.defaults={axis:"xy",duration:0,limit:!0},t.fn.scrollTo=function(i,s,o){"object"==typeof s&&(o=s,s=0),"function"==typeof o&&(o={onAfter:o}),"max"===i&&(i=9e9),o=t.extend({},a.defaults,o),s=s||o.duration;var r=o.queue&&o.axis.length>1;return r&&(s/=2),o.offset=n(o.offset),o.over=n(o.over),this.each((function(){if(null!==i){var l,d=e(this),c=d?this.contentWindow||window:this,u=t(c),m=i,p={};switch(typeof m){case"number":case"string":if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(m)){m=n(m);break}m=d?t(m):t(m,c);case"object":if(0===m.length)return;(m.is||m.style)&&(l=(m=t(m)).offset())}var h=t.isFunction(o.offset)&&o.offset(c,m)||o.offset;t.each(o.axis.split(""),(function(t,e){var n="x"===e?"Left":"Top",i=n.toLowerCase(),s="scroll"+n,g=u[s](),v=a.max(c,e);if(l)p[s]=l[i]+(d?0:g-u.offset()[i]),o.margin&&(p[s]-=parseInt(m.css("margin"+n),10)||0,p[s]-=parseInt(m.css("border"+n+"Width"),10)||0),p[s]+=h[i]||0,o.over[i]&&(p[s]+=m["x"===e?"width":"height"]()*o.over[i]);else{var b=m[i];p[s]=b.slice&&"%"===b.slice(-1)?parseFloat(b)/100*v:b}o.limit&&/^\d+$/.test(p[s])&&(p[s]=p[s]<=0?0:Math.min(p[s],v)),!t&&o.axis.length>1&&(g===p[s]?p={}:r&&(f(o.onAfterFirst),p={}))})),f(o.onAfter)}function f(a){var e=t.extend({},o,{queue:!0,duration:s,complete:a&&function(){a.call(c,m,o)}});u.animate(p,e)}}))},a.max=function(a,n){var i="x"===n?"Width":"Height",s="scroll"+i;if(!e(a))return a[s]-t(a)[i.toLowerCase()]();var o="client"+i,r=a.ownerDocument||a.document,l=r.documentElement,d=r.body;return Math.max(l[s],d[s])-Math.min(l[o],d[o])},t.Tween.propHooks.scrollLeft=t.Tween.propHooks.scrollTop={get:function(a){return t(a.elem)[a.prop]()},set:function(a){var e=this.get(a);if(a.options.interrupt&&a._last&&a._last!==e)return t(a.elem).stop();var n=Math.round(a.now);e!==n&&(t(a.elem)[a.prop](n),a._last=this.get(a))}},a})?n.apply(a,i):n)||(t.exports=s)}()}},[["a50V","runtime",0,1]]]);