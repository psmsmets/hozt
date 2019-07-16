(window.webpackJsonp=window.webpackJsonp||[]).push([["carousel"],{"A/ap":function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o={update:function(){if("undefined"!=typeof window&&"function"==typeof window.addEventListener){var e=!1,t=Object.defineProperty({},"passive",{get:function(){e=!0}}),n=function(){};window.addEventListener("testPassiveEventSupport",n,t),window.removeEventListener("testPassiveEventSupport",n,t),o.hasSupport=e}}};o.update(),t.default=o},dMQp:function(e,t,n){(function(e){n("SYky"),n("gu4o"),e(".carousel").carousel({interval:6500}),e(".carousel").bcSwipe({threshold:60})}).call(this,n("EVdn"))},gu4o:function(e,t,n){(function(e){
/**
 * Bootstrap Carousel Swipe v1.1
 *
 * jQuery plugin to enable swipe gestures on Bootstrap 3 carousels.
 * Examples and documentation: https://github.com/briggySmalls/bcSwipe
 *
 * @license MIT
 */
var t,o=n("A/ap");(t=e).fn.bcSwipe=function(e){var n={threshold:50};return e&&t.extend(n,e),this.each(function(){var e,i=!1;function s(o){if(i){var u=o.touches[0].pageX,a=e-u;Math.abs(a)>=n.threshold&&(function(){this.removeEventListener("touchmove",s),e=null,i=!1}.call(this),a>0?t(this).carousel("next"):t(this).carousel("prev"))}}"ontouchstart"in document.documentElement&&this.addEventListener("touchstart",function(t){1==t.touches.length&&(e=t.touches[0].pageX,i=!0,this.addEventListener("touchmove",s,!!o.hasSupport&&{passive:!0}))},!!o.hasSupport&&{passive:!0})}),this}}).call(this,n("EVdn"))}},[["dMQp","runtime",0,1]]]);