(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["vendors~hozt"],{

/***/ "./node_modules/countup.js/dist/countUp.min.js":
/*!*****************************************************!*\
  !*** ./node_modules/countup.js/dist/countUp.min.js ***!
  \*****************************************************/
/*! exports provided: CountUp */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CountUp", function() { return CountUp; });
var __assign=undefined&&undefined.__assign||function(){return(__assign=Object.assign||function(t){for(var i,a=1,s=arguments.length;a<s;a++)for(var n in i=arguments[a])Object.prototype.hasOwnProperty.call(i,n)&&(t[n]=i[n]);return t}).apply(this,arguments)},CountUp=function(){function t(t,i,a){var s=this;this.target=t,this.endVal=i,this.options=a,this.version="2.0.4",this.defaults={startVal:0,decimalPlaces:0,duration:2,useEasing:!0,useGrouping:!0,smartEasingThreshold:999,smartEasingAmount:333,separator:",",decimal:".",prefix:"",suffix:""},this.finalEndVal=null,this.useEasing=!0,this.countDown=!1,this.error="",this.startVal=0,this.paused=!0,this.count=function(t){s.startTime||(s.startTime=t);var i=t-s.startTime;s.remaining=s.duration-i,s.useEasing?s.countDown?s.frameVal=s.startVal-s.easingFn(i,0,s.startVal-s.endVal,s.duration):s.frameVal=s.easingFn(i,s.startVal,s.endVal-s.startVal,s.duration):s.countDown?s.frameVal=s.startVal-(s.startVal-s.endVal)*(i/s.duration):s.frameVal=s.startVal+(s.endVal-s.startVal)*(i/s.duration),s.countDown?s.frameVal=s.frameVal<s.endVal?s.endVal:s.frameVal:s.frameVal=s.frameVal>s.endVal?s.endVal:s.frameVal,s.frameVal=Math.round(s.frameVal*s.decimalMult)/s.decimalMult,s.printValue(s.frameVal),i<s.duration?s.rAF=requestAnimationFrame(s.count):null!==s.finalEndVal?s.update(s.finalEndVal):s.callback&&s.callback()},this.formatNumber=function(t){var i,a,n,e,r,o=t<0?"-":"";if(i=Math.abs(t).toFixed(s.options.decimalPlaces),n=(a=(i+="").split("."))[0],e=a.length>1?s.options.decimal+a[1]:"",s.options.useGrouping){r="";for(var l=0,h=n.length;l<h;++l)0!==l&&l%3==0&&(r=s.options.separator+r),r=n[h-l-1]+r;n=r}return s.options.numerals&&s.options.numerals.length&&(n=n.replace(/[0-9]/g,function(t){return s.options.numerals[+t]}),e=e.replace(/[0-9]/g,function(t){return s.options.numerals[+t]})),o+s.options.prefix+n+e+s.options.suffix},this.easeOutExpo=function(t,i,a,s){return a*(1-Math.pow(2,-10*t/s))*1024/1023+i},this.options=__assign({},this.defaults,a),this.formattingFn=this.options.formattingFn?this.options.formattingFn:this.formatNumber,this.easingFn=this.options.easingFn?this.options.easingFn:this.easeOutExpo,this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.endVal=this.validateValue(i),this.options.decimalPlaces=Math.max(this.options.decimalPlaces),this.decimalMult=Math.pow(10,this.options.decimalPlaces),this.resetDuration(),this.options.separator=String(this.options.separator),this.useEasing=this.options.useEasing,""===this.options.separator&&(this.options.useGrouping=!1),this.el="string"==typeof t?document.getElementById(t):t,this.el?this.printValue(this.startVal):this.error="[CountUp] target is null or undefined"}return t.prototype.determineDirectionAndSmartEasing=function(){var t=this.finalEndVal?this.finalEndVal:this.endVal;this.countDown=this.startVal>t;var i=t-this.startVal;if(Math.abs(i)>this.options.smartEasingThreshold){this.finalEndVal=t;var a=this.countDown?1:-1;this.endVal=t+a*this.options.smartEasingAmount,this.duration=this.duration/2}else this.endVal=t,this.finalEndVal=null;this.finalEndVal?this.useEasing=!1:this.useEasing=this.options.useEasing},t.prototype.start=function(t){this.error||(this.callback=t,this.duration>0?(this.determineDirectionAndSmartEasing(),this.paused=!1,this.rAF=requestAnimationFrame(this.count)):this.printValue(this.endVal))},t.prototype.pauseResume=function(){this.paused?(this.startTime=null,this.duration=this.remaining,this.startVal=this.frameVal,this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count)):cancelAnimationFrame(this.rAF),this.paused=!this.paused},t.prototype.reset=function(){cancelAnimationFrame(this.rAF),this.paused=!0,this.resetDuration(),this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.printValue(this.startVal)},t.prototype.update=function(t){cancelAnimationFrame(this.rAF),this.startTime=null,this.endVal=this.validateValue(t),this.endVal!==this.frameVal&&(this.startVal=this.frameVal,this.finalEndVal||this.resetDuration(),this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count))},t.prototype.printValue=function(t){var i=this.formattingFn(t);"INPUT"===this.el.tagName?this.el.value=i:"text"===this.el.tagName||"tspan"===this.el.tagName?this.el.textContent=i:this.el.innerHTML=i},t.prototype.ensureNumber=function(t){return"number"==typeof t&&!isNaN(t)},t.prototype.validateValue=function(t){var i=Number(t);return this.ensureNumber(i)?i:(this.error="[CountUp] invalid start or end value: "+t,null)},t.prototype.resetDuration=function(){this.startTime=null,this.duration=1e3*Number(this.options.duration),this.remaining=this.duration},t}();

/***/ }),

/***/ "./node_modules/jquery.scrollTo/jquery.scrollTo.js":
/*!*********************************************************!*\
  !*** ./node_modules/jquery.scrollTo/jquery.scrollTo.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery.scrollTo
 * Copyright (c) 2007-2015 Ariel Flesler - aflesler<a>gmail<d>com | http://flesler.blogspot.com
 * Licensed under MIT
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 * @projectDescription Lightweight, cross-browser and highly customizable animated scrolling with jQuery
 * @author Ariel Flesler
 * @version 2.1.2
 */
;(function(factory) {
	'use strict';
	if (true) {
		// AMD
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
})(function($) {
	'use strict';

	var $scrollTo = $.scrollTo = function(target, duration, settings) {
		return $(window).scrollTo(target, duration, settings);
	};

	$scrollTo.defaults = {
		axis:'xy',
		duration: 0,
		limit:true
	};

	function isWin(elem) {
		return !elem.nodeName ||
			$.inArray(elem.nodeName.toLowerCase(), ['iframe','#document','html','body']) !== -1;
	}		

	$.fn.scrollTo = function(target, duration, settings) {
		if (typeof duration === 'object') {
			settings = duration;
			duration = 0;
		}
		if (typeof settings === 'function') {
			settings = { onAfter:settings };
		}
		if (target === 'max') {
			target = 9e9;
		}

		settings = $.extend({}, $scrollTo.defaults, settings);
		// Speed is still recognized for backwards compatibility
		duration = duration || settings.duration;
		// Make sure the settings are given right
		var queue = settings.queue && settings.axis.length > 1;
		if (queue) {
			// Let's keep the overall duration
			duration /= 2;
		}
		settings.offset = both(settings.offset);
		settings.over = both(settings.over);

		return this.each(function() {
			// Null target yields nothing, just like jQuery does
			if (target === null) return;

			var win = isWin(this),
				elem = win ? this.contentWindow || window : this,
				$elem = $(elem),
				targ = target, 
				attr = {},
				toff;

			switch (typeof targ) {
				// A number will pass the regex
				case 'number':
				case 'string':
					if (/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(targ)) {
						targ = both(targ);
						// We are done
						break;
					}
					// Relative/Absolute selector
					targ = win ? $(targ) : $(targ, elem);
					/* falls through */
				case 'object':
					if (targ.length === 0) return;
					// DOMElement / jQuery
					if (targ.is || targ.style) {
						// Get the real position of the target
						toff = (targ = $(targ)).offset();
					}
			}

			var offset = $.isFunction(settings.offset) && settings.offset(elem, targ) || settings.offset;

			$.each(settings.axis.split(''), function(i, axis) {
				var Pos	= axis === 'x' ? 'Left' : 'Top',
					pos = Pos.toLowerCase(),
					key = 'scroll' + Pos,
					prev = $elem[key](),
					max = $scrollTo.max(elem, axis);

				if (toff) {// jQuery / DOMElement
					attr[key] = toff[pos] + (win ? 0 : prev - $elem.offset()[pos]);

					// If it's a dom element, reduce the margin
					if (settings.margin) {
						attr[key] -= parseInt(targ.css('margin'+Pos), 10) || 0;
						attr[key] -= parseInt(targ.css('border'+Pos+'Width'), 10) || 0;
					}

					attr[key] += offset[pos] || 0;

					if (settings.over[pos]) {
						// Scroll to a fraction of its width/height
						attr[key] += targ[axis === 'x'?'width':'height']() * settings.over[pos];
					}
				} else {
					var val = targ[pos];
					// Handle percentage values
					attr[key] = val.slice && val.slice(-1) === '%' ?
						parseFloat(val) / 100 * max
						: val;
				}

				// Number or 'number'
				if (settings.limit && /^\d+$/.test(attr[key])) {
					// Check the limits
					attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max);
				}

				// Don't waste time animating, if there's no need.
				if (!i && settings.axis.length > 1) {
					if (prev === attr[key]) {
						// No animation needed
						attr = {};
					} else if (queue) {
						// Intermediate animation
						animate(settings.onAfterFirst);
						// Don't animate this axis again in the next iteration.
						attr = {};
					}
				}
			});

			animate(settings.onAfter);

			function animate(callback) {
				var opts = $.extend({}, settings, {
					// The queue setting conflicts with animate()
					// Force it to always be true
					queue: true,
					duration: duration,
					complete: callback && function() {
						callback.call(elem, targ, settings);
					}
				});
				$elem.animate(attr, opts);
			}
		});
	};

	// Max scrolling position, works on quirks mode
	// It only fails (not too badly) on IE, quirks mode.
	$scrollTo.max = function(elem, axis) {
		var Dim = axis === 'x' ? 'Width' : 'Height',
			scroll = 'scroll'+Dim;

		if (!isWin(elem))
			return elem[scroll] - $(elem)[Dim.toLowerCase()]();

		var size = 'client' + Dim,
			doc = elem.ownerDocument || elem.document,
			html = doc.documentElement,
			body = doc.body;

		return Math.max(html[scroll], body[scroll]) - Math.min(html[size], body[size]);
	};

	function both(val) {
		return $.isFunction(val) || $.isPlainObject(val) ? val : { top:val, left:val };
	}

	// Add special hooks so that window scroll properties can be animated
	$.Tween.propHooks.scrollLeft = 
	$.Tween.propHooks.scrollTop = {
		get: function(t) {
			return $(t.elem)[t.prop]();
		},
		set: function(t) {
			var curr = this.get(t);
			// If interrupt is true and user scrolled, stop animating
			if (t.options.interrupt && t._last && t._last !== curr) {
				return $(t.elem).stop();
			}
			var next = Math.round(t.now);
			// Don't waste CPU
			// Browsers don't render floating point scroll
			if (curr !== next) {
				$(t.elem)[t.prop](next);
				t._last = this.get(t);
			}
		}
	};

	// AMD requirement
	return $scrollTo;
});


/***/ })

}]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY291bnR1cC5qcy9kaXN0L2NvdW50VXAubWluLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9qcXVlcnkuc2Nyb2xsVG8vanF1ZXJ5LnNjcm9sbFRvLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQTtBQUFBO0FBQUEsYUFBYSxTQUFJLEVBQUUsU0FBSSxzQkFBc0IsMkNBQTJDLGlDQUFpQyxJQUFJLHVGQUF1RixTQUFTLHdCQUF3QixvQkFBb0Isa0JBQWtCLFdBQVcsK0VBQStFLCtKQUErSiwrSEFBK0gsNkJBQTZCLG9CQUFvQiw0bkJBQTRuQiwrQkFBK0IsMkJBQTJCLDRJQUE0SSxLQUFLLHVCQUF1QixJQUFJLDBEQUEwRCxJQUFJLHdGQUF3Riw4QkFBOEIsbUNBQW1DLDhCQUE4QiwyQ0FBMkMsb0NBQW9DLDZDQUE2Qyx5QkFBeUIsa3VCQUFrdUIsK0RBQStELG9EQUFvRCwrQkFBK0Isc0JBQXNCLGtEQUFrRCxtQkFBbUIsMEJBQTBCLDZFQUE2RSx5Q0FBeUMseUVBQXlFLCtCQUErQiwrS0FBK0ssb0NBQW9DLHNPQUFzTyw4QkFBOEIsc0xBQXNMLGdDQUFnQywwUUFBMFEsb0NBQW9DLDJCQUEyQix3SUFBd0ksc0NBQXNDLG9DQUFvQyx1Q0FBdUMsZ0JBQWdCLDJGQUEyRixzQ0FBc0MsaUdBQWlHLEdBQUcsRzs7Ozs7Ozs7Ozs7QUNBM2xKO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLENBQUM7QUFDRDtBQUNBLEtBQUssSUFBMEM7QUFDL0M7QUFDQSxFQUFFLGlDQUFPLENBQUMseUVBQVEsQ0FBQyxvQ0FBRSxPQUFPO0FBQUE7QUFBQTtBQUFBLG9HQUFDO0FBQzdCLEVBQUUsTUFBTSxFQU1OO0FBQ0YsQ0FBQztBQUNEOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEU7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsZUFBZTtBQUNmO0FBQ0E7QUFDQTtBQUNBOztBQUVBLHdCQUF3QjtBQUN4QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxhQUFhO0FBQ2I7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsZUFBZTtBQUNmOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU07QUFDTjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxJQUFJOztBQUVKOztBQUVBO0FBQ0EsMEJBQTBCO0FBQzFCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQSw0REFBNEQ7QUFDNUQ7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLENBQUMiLCJmaWxlIjoidmVuZG9yc35ob3p0LmpzIiwic291cmNlc0NvbnRlbnQiOlsidmFyIF9fYXNzaWduPXRoaXMmJnRoaXMuX19hc3NpZ258fGZ1bmN0aW9uKCl7cmV0dXJuKF9fYXNzaWduPU9iamVjdC5hc3NpZ258fGZ1bmN0aW9uKHQpe2Zvcih2YXIgaSxhPTEscz1hcmd1bWVudHMubGVuZ3RoO2E8czthKyspZm9yKHZhciBuIGluIGk9YXJndW1lbnRzW2FdKU9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChpLG4pJiYodFtuXT1pW25dKTtyZXR1cm4gdH0pLmFwcGx5KHRoaXMsYXJndW1lbnRzKX0sQ291bnRVcD1mdW5jdGlvbigpe2Z1bmN0aW9uIHQodCxpLGEpe3ZhciBzPXRoaXM7dGhpcy50YXJnZXQ9dCx0aGlzLmVuZFZhbD1pLHRoaXMub3B0aW9ucz1hLHRoaXMudmVyc2lvbj1cIjIuMC40XCIsdGhpcy5kZWZhdWx0cz17c3RhcnRWYWw6MCxkZWNpbWFsUGxhY2VzOjAsZHVyYXRpb246Mix1c2VFYXNpbmc6ITAsdXNlR3JvdXBpbmc6ITAsc21hcnRFYXNpbmdUaHJlc2hvbGQ6OTk5LHNtYXJ0RWFzaW5nQW1vdW50OjMzMyxzZXBhcmF0b3I6XCIsXCIsZGVjaW1hbDpcIi5cIixwcmVmaXg6XCJcIixzdWZmaXg6XCJcIn0sdGhpcy5maW5hbEVuZFZhbD1udWxsLHRoaXMudXNlRWFzaW5nPSEwLHRoaXMuY291bnREb3duPSExLHRoaXMuZXJyb3I9XCJcIix0aGlzLnN0YXJ0VmFsPTAsdGhpcy5wYXVzZWQ9ITAsdGhpcy5jb3VudD1mdW5jdGlvbih0KXtzLnN0YXJ0VGltZXx8KHMuc3RhcnRUaW1lPXQpO3ZhciBpPXQtcy5zdGFydFRpbWU7cy5yZW1haW5pbmc9cy5kdXJhdGlvbi1pLHMudXNlRWFzaW5nP3MuY291bnREb3duP3MuZnJhbWVWYWw9cy5zdGFydFZhbC1zLmVhc2luZ0ZuKGksMCxzLnN0YXJ0VmFsLXMuZW5kVmFsLHMuZHVyYXRpb24pOnMuZnJhbWVWYWw9cy5lYXNpbmdGbihpLHMuc3RhcnRWYWwscy5lbmRWYWwtcy5zdGFydFZhbCxzLmR1cmF0aW9uKTpzLmNvdW50RG93bj9zLmZyYW1lVmFsPXMuc3RhcnRWYWwtKHMuc3RhcnRWYWwtcy5lbmRWYWwpKihpL3MuZHVyYXRpb24pOnMuZnJhbWVWYWw9cy5zdGFydFZhbCsocy5lbmRWYWwtcy5zdGFydFZhbCkqKGkvcy5kdXJhdGlvbikscy5jb3VudERvd24/cy5mcmFtZVZhbD1zLmZyYW1lVmFsPHMuZW5kVmFsP3MuZW5kVmFsOnMuZnJhbWVWYWw6cy5mcmFtZVZhbD1zLmZyYW1lVmFsPnMuZW5kVmFsP3MuZW5kVmFsOnMuZnJhbWVWYWwscy5mcmFtZVZhbD1NYXRoLnJvdW5kKHMuZnJhbWVWYWwqcy5kZWNpbWFsTXVsdCkvcy5kZWNpbWFsTXVsdCxzLnByaW50VmFsdWUocy5mcmFtZVZhbCksaTxzLmR1cmF0aW9uP3MuckFGPXJlcXVlc3RBbmltYXRpb25GcmFtZShzLmNvdW50KTpudWxsIT09cy5maW5hbEVuZFZhbD9zLnVwZGF0ZShzLmZpbmFsRW5kVmFsKTpzLmNhbGxiYWNrJiZzLmNhbGxiYWNrKCl9LHRoaXMuZm9ybWF0TnVtYmVyPWZ1bmN0aW9uKHQpe3ZhciBpLGEsbixlLHIsbz10PDA/XCItXCI6XCJcIjtpZihpPU1hdGguYWJzKHQpLnRvRml4ZWQocy5vcHRpb25zLmRlY2ltYWxQbGFjZXMpLG49KGE9KGkrPVwiXCIpLnNwbGl0KFwiLlwiKSlbMF0sZT1hLmxlbmd0aD4xP3Mub3B0aW9ucy5kZWNpbWFsK2FbMV06XCJcIixzLm9wdGlvbnMudXNlR3JvdXBpbmcpe3I9XCJcIjtmb3IodmFyIGw9MCxoPW4ubGVuZ3RoO2w8aDsrK2wpMCE9PWwmJmwlMz09MCYmKHI9cy5vcHRpb25zLnNlcGFyYXRvcityKSxyPW5baC1sLTFdK3I7bj1yfXJldHVybiBzLm9wdGlvbnMubnVtZXJhbHMmJnMub3B0aW9ucy5udW1lcmFscy5sZW5ndGgmJihuPW4ucmVwbGFjZSgvWzAtOV0vZyxmdW5jdGlvbih0KXtyZXR1cm4gcy5vcHRpb25zLm51bWVyYWxzWyt0XX0pLGU9ZS5yZXBsYWNlKC9bMC05XS9nLGZ1bmN0aW9uKHQpe3JldHVybiBzLm9wdGlvbnMubnVtZXJhbHNbK3RdfSkpLG8rcy5vcHRpb25zLnByZWZpeCtuK2Urcy5vcHRpb25zLnN1ZmZpeH0sdGhpcy5lYXNlT3V0RXhwbz1mdW5jdGlvbih0LGksYSxzKXtyZXR1cm4gYSooMS1NYXRoLnBvdygyLC0xMCp0L3MpKSoxMDI0LzEwMjMraX0sdGhpcy5vcHRpb25zPV9fYXNzaWduKHt9LHRoaXMuZGVmYXVsdHMsYSksdGhpcy5mb3JtYXR0aW5nRm49dGhpcy5vcHRpb25zLmZvcm1hdHRpbmdGbj90aGlzLm9wdGlvbnMuZm9ybWF0dGluZ0ZuOnRoaXMuZm9ybWF0TnVtYmVyLHRoaXMuZWFzaW5nRm49dGhpcy5vcHRpb25zLmVhc2luZ0ZuP3RoaXMub3B0aW9ucy5lYXNpbmdGbjp0aGlzLmVhc2VPdXRFeHBvLHRoaXMuc3RhcnRWYWw9dGhpcy52YWxpZGF0ZVZhbHVlKHRoaXMub3B0aW9ucy5zdGFydFZhbCksdGhpcy5mcmFtZVZhbD10aGlzLnN0YXJ0VmFsLHRoaXMuZW5kVmFsPXRoaXMudmFsaWRhdGVWYWx1ZShpKSx0aGlzLm9wdGlvbnMuZGVjaW1hbFBsYWNlcz1NYXRoLm1heCh0aGlzLm9wdGlvbnMuZGVjaW1hbFBsYWNlcyksdGhpcy5kZWNpbWFsTXVsdD1NYXRoLnBvdygxMCx0aGlzLm9wdGlvbnMuZGVjaW1hbFBsYWNlcyksdGhpcy5yZXNldER1cmF0aW9uKCksdGhpcy5vcHRpb25zLnNlcGFyYXRvcj1TdHJpbmcodGhpcy5vcHRpb25zLnNlcGFyYXRvciksdGhpcy51c2VFYXNpbmc9dGhpcy5vcHRpb25zLnVzZUVhc2luZyxcIlwiPT09dGhpcy5vcHRpb25zLnNlcGFyYXRvciYmKHRoaXMub3B0aW9ucy51c2VHcm91cGluZz0hMSksdGhpcy5lbD1cInN0cmluZ1wiPT10eXBlb2YgdD9kb2N1bWVudC5nZXRFbGVtZW50QnlJZCh0KTp0LHRoaXMuZWw/dGhpcy5wcmludFZhbHVlKHRoaXMuc3RhcnRWYWwpOnRoaXMuZXJyb3I9XCJbQ291bnRVcF0gdGFyZ2V0IGlzIG51bGwgb3IgdW5kZWZpbmVkXCJ9cmV0dXJuIHQucHJvdG90eXBlLmRldGVybWluZURpcmVjdGlvbkFuZFNtYXJ0RWFzaW5nPWZ1bmN0aW9uKCl7dmFyIHQ9dGhpcy5maW5hbEVuZFZhbD90aGlzLmZpbmFsRW5kVmFsOnRoaXMuZW5kVmFsO3RoaXMuY291bnREb3duPXRoaXMuc3RhcnRWYWw+dDt2YXIgaT10LXRoaXMuc3RhcnRWYWw7aWYoTWF0aC5hYnMoaSk+dGhpcy5vcHRpb25zLnNtYXJ0RWFzaW5nVGhyZXNob2xkKXt0aGlzLmZpbmFsRW5kVmFsPXQ7dmFyIGE9dGhpcy5jb3VudERvd24/MTotMTt0aGlzLmVuZFZhbD10K2EqdGhpcy5vcHRpb25zLnNtYXJ0RWFzaW5nQW1vdW50LHRoaXMuZHVyYXRpb249dGhpcy5kdXJhdGlvbi8yfWVsc2UgdGhpcy5lbmRWYWw9dCx0aGlzLmZpbmFsRW5kVmFsPW51bGw7dGhpcy5maW5hbEVuZFZhbD90aGlzLnVzZUVhc2luZz0hMTp0aGlzLnVzZUVhc2luZz10aGlzLm9wdGlvbnMudXNlRWFzaW5nfSx0LnByb3RvdHlwZS5zdGFydD1mdW5jdGlvbih0KXt0aGlzLmVycm9yfHwodGhpcy5jYWxsYmFjaz10LHRoaXMuZHVyYXRpb24+MD8odGhpcy5kZXRlcm1pbmVEaXJlY3Rpb25BbmRTbWFydEVhc2luZygpLHRoaXMucGF1c2VkPSExLHRoaXMuckFGPXJlcXVlc3RBbmltYXRpb25GcmFtZSh0aGlzLmNvdW50KSk6dGhpcy5wcmludFZhbHVlKHRoaXMuZW5kVmFsKSl9LHQucHJvdG90eXBlLnBhdXNlUmVzdW1lPWZ1bmN0aW9uKCl7dGhpcy5wYXVzZWQ/KHRoaXMuc3RhcnRUaW1lPW51bGwsdGhpcy5kdXJhdGlvbj10aGlzLnJlbWFpbmluZyx0aGlzLnN0YXJ0VmFsPXRoaXMuZnJhbWVWYWwsdGhpcy5kZXRlcm1pbmVEaXJlY3Rpb25BbmRTbWFydEVhc2luZygpLHRoaXMuckFGPXJlcXVlc3RBbmltYXRpb25GcmFtZSh0aGlzLmNvdW50KSk6Y2FuY2VsQW5pbWF0aW9uRnJhbWUodGhpcy5yQUYpLHRoaXMucGF1c2VkPSF0aGlzLnBhdXNlZH0sdC5wcm90b3R5cGUucmVzZXQ9ZnVuY3Rpb24oKXtjYW5jZWxBbmltYXRpb25GcmFtZSh0aGlzLnJBRiksdGhpcy5wYXVzZWQ9ITAsdGhpcy5yZXNldER1cmF0aW9uKCksdGhpcy5zdGFydFZhbD10aGlzLnZhbGlkYXRlVmFsdWUodGhpcy5vcHRpb25zLnN0YXJ0VmFsKSx0aGlzLmZyYW1lVmFsPXRoaXMuc3RhcnRWYWwsdGhpcy5wcmludFZhbHVlKHRoaXMuc3RhcnRWYWwpfSx0LnByb3RvdHlwZS51cGRhdGU9ZnVuY3Rpb24odCl7Y2FuY2VsQW5pbWF0aW9uRnJhbWUodGhpcy5yQUYpLHRoaXMuc3RhcnRUaW1lPW51bGwsdGhpcy5lbmRWYWw9dGhpcy52YWxpZGF0ZVZhbHVlKHQpLHRoaXMuZW5kVmFsIT09dGhpcy5mcmFtZVZhbCYmKHRoaXMuc3RhcnRWYWw9dGhpcy5mcmFtZVZhbCx0aGlzLmZpbmFsRW5kVmFsfHx0aGlzLnJlc2V0RHVyYXRpb24oKSx0aGlzLmRldGVybWluZURpcmVjdGlvbkFuZFNtYXJ0RWFzaW5nKCksdGhpcy5yQUY9cmVxdWVzdEFuaW1hdGlvbkZyYW1lKHRoaXMuY291bnQpKX0sdC5wcm90b3R5cGUucHJpbnRWYWx1ZT1mdW5jdGlvbih0KXt2YXIgaT10aGlzLmZvcm1hdHRpbmdGbih0KTtcIklOUFVUXCI9PT10aGlzLmVsLnRhZ05hbWU/dGhpcy5lbC52YWx1ZT1pOlwidGV4dFwiPT09dGhpcy5lbC50YWdOYW1lfHxcInRzcGFuXCI9PT10aGlzLmVsLnRhZ05hbWU/dGhpcy5lbC50ZXh0Q29udGVudD1pOnRoaXMuZWwuaW5uZXJIVE1MPWl9LHQucHJvdG90eXBlLmVuc3VyZU51bWJlcj1mdW5jdGlvbih0KXtyZXR1cm5cIm51bWJlclwiPT10eXBlb2YgdCYmIWlzTmFOKHQpfSx0LnByb3RvdHlwZS52YWxpZGF0ZVZhbHVlPWZ1bmN0aW9uKHQpe3ZhciBpPU51bWJlcih0KTtyZXR1cm4gdGhpcy5lbnN1cmVOdW1iZXIoaSk/aToodGhpcy5lcnJvcj1cIltDb3VudFVwXSBpbnZhbGlkIHN0YXJ0IG9yIGVuZCB2YWx1ZTogXCIrdCxudWxsKX0sdC5wcm90b3R5cGUucmVzZXREdXJhdGlvbj1mdW5jdGlvbigpe3RoaXMuc3RhcnRUaW1lPW51bGwsdGhpcy5kdXJhdGlvbj0xZTMqTnVtYmVyKHRoaXMub3B0aW9ucy5kdXJhdGlvbiksdGhpcy5yZW1haW5pbmc9dGhpcy5kdXJhdGlvbn0sdH0oKTtleHBvcnR7Q291bnRVcH07IiwiLyohXG4gKiBqUXVlcnkuc2Nyb2xsVG9cbiAqIENvcHlyaWdodCAoYykgMjAwNy0yMDE1IEFyaWVsIEZsZXNsZXIgLSBhZmxlc2xlcjxhPmdtYWlsPGQ+Y29tIHwgaHR0cDovL2ZsZXNsZXIuYmxvZ3Nwb3QuY29tXG4gKiBMaWNlbnNlZCB1bmRlciBNSVRcbiAqIGh0dHA6Ly9mbGVzbGVyLmJsb2dzcG90LmNvbS8yMDA3LzEwL2pxdWVyeXNjcm9sbHRvLmh0bWxcbiAqIEBwcm9qZWN0RGVzY3JpcHRpb24gTGlnaHR3ZWlnaHQsIGNyb3NzLWJyb3dzZXIgYW5kIGhpZ2hseSBjdXN0b21pemFibGUgYW5pbWF0ZWQgc2Nyb2xsaW5nIHdpdGggalF1ZXJ5XG4gKiBAYXV0aG9yIEFyaWVsIEZsZXNsZXJcbiAqIEB2ZXJzaW9uIDIuMS4yXG4gKi9cbjsoZnVuY3Rpb24oZmFjdG9yeSkge1xuXHQndXNlIHN0cmljdCc7XG5cdGlmICh0eXBlb2YgZGVmaW5lID09PSAnZnVuY3Rpb24nICYmIGRlZmluZS5hbWQpIHtcblx0XHQvLyBBTURcblx0XHRkZWZpbmUoWydqcXVlcnknXSwgZmFjdG9yeSk7XG5cdH0gZWxzZSBpZiAodHlwZW9mIG1vZHVsZSAhPT0gJ3VuZGVmaW5lZCcgJiYgbW9kdWxlLmV4cG9ydHMpIHtcblx0XHQvLyBDb21tb25KU1xuXHRcdG1vZHVsZS5leHBvcnRzID0gZmFjdG9yeShyZXF1aXJlKCdqcXVlcnknKSk7XG5cdH0gZWxzZSB7XG5cdFx0Ly8gR2xvYmFsXG5cdFx0ZmFjdG9yeShqUXVlcnkpO1xuXHR9XG59KShmdW5jdGlvbigkKSB7XG5cdCd1c2Ugc3RyaWN0JztcblxuXHR2YXIgJHNjcm9sbFRvID0gJC5zY3JvbGxUbyA9IGZ1bmN0aW9uKHRhcmdldCwgZHVyYXRpb24sIHNldHRpbmdzKSB7XG5cdFx0cmV0dXJuICQod2luZG93KS5zY3JvbGxUbyh0YXJnZXQsIGR1cmF0aW9uLCBzZXR0aW5ncyk7XG5cdH07XG5cblx0JHNjcm9sbFRvLmRlZmF1bHRzID0ge1xuXHRcdGF4aXM6J3h5Jyxcblx0XHRkdXJhdGlvbjogMCxcblx0XHRsaW1pdDp0cnVlXG5cdH07XG5cblx0ZnVuY3Rpb24gaXNXaW4oZWxlbSkge1xuXHRcdHJldHVybiAhZWxlbS5ub2RlTmFtZSB8fFxuXHRcdFx0JC5pbkFycmF5KGVsZW0ubm9kZU5hbWUudG9Mb3dlckNhc2UoKSwgWydpZnJhbWUnLCcjZG9jdW1lbnQnLCdodG1sJywnYm9keSddKSAhPT0gLTE7XG5cdH1cdFx0XG5cblx0JC5mbi5zY3JvbGxUbyA9IGZ1bmN0aW9uKHRhcmdldCwgZHVyYXRpb24sIHNldHRpbmdzKSB7XG5cdFx0aWYgKHR5cGVvZiBkdXJhdGlvbiA9PT0gJ29iamVjdCcpIHtcblx0XHRcdHNldHRpbmdzID0gZHVyYXRpb247XG5cdFx0XHRkdXJhdGlvbiA9IDA7XG5cdFx0fVxuXHRcdGlmICh0eXBlb2Ygc2V0dGluZ3MgPT09ICdmdW5jdGlvbicpIHtcblx0XHRcdHNldHRpbmdzID0geyBvbkFmdGVyOnNldHRpbmdzIH07XG5cdFx0fVxuXHRcdGlmICh0YXJnZXQgPT09ICdtYXgnKSB7XG5cdFx0XHR0YXJnZXQgPSA5ZTk7XG5cdFx0fVxuXG5cdFx0c2V0dGluZ3MgPSAkLmV4dGVuZCh7fSwgJHNjcm9sbFRvLmRlZmF1bHRzLCBzZXR0aW5ncyk7XG5cdFx0Ly8gU3BlZWQgaXMgc3RpbGwgcmVjb2duaXplZCBmb3IgYmFja3dhcmRzIGNvbXBhdGliaWxpdHlcblx0XHRkdXJhdGlvbiA9IGR1cmF0aW9uIHx8IHNldHRpbmdzLmR1cmF0aW9uO1xuXHRcdC8vIE1ha2Ugc3VyZSB0aGUgc2V0dGluZ3MgYXJlIGdpdmVuIHJpZ2h0XG5cdFx0dmFyIHF1ZXVlID0gc2V0dGluZ3MucXVldWUgJiYgc2V0dGluZ3MuYXhpcy5sZW5ndGggPiAxO1xuXHRcdGlmIChxdWV1ZSkge1xuXHRcdFx0Ly8gTGV0J3Mga2VlcCB0aGUgb3ZlcmFsbCBkdXJhdGlvblxuXHRcdFx0ZHVyYXRpb24gLz0gMjtcblx0XHR9XG5cdFx0c2V0dGluZ3Mub2Zmc2V0ID0gYm90aChzZXR0aW5ncy5vZmZzZXQpO1xuXHRcdHNldHRpbmdzLm92ZXIgPSBib3RoKHNldHRpbmdzLm92ZXIpO1xuXG5cdFx0cmV0dXJuIHRoaXMuZWFjaChmdW5jdGlvbigpIHtcblx0XHRcdC8vIE51bGwgdGFyZ2V0IHlpZWxkcyBub3RoaW5nLCBqdXN0IGxpa2UgalF1ZXJ5IGRvZXNcblx0XHRcdGlmICh0YXJnZXQgPT09IG51bGwpIHJldHVybjtcblxuXHRcdFx0dmFyIHdpbiA9IGlzV2luKHRoaXMpLFxuXHRcdFx0XHRlbGVtID0gd2luID8gdGhpcy5jb250ZW50V2luZG93IHx8IHdpbmRvdyA6IHRoaXMsXG5cdFx0XHRcdCRlbGVtID0gJChlbGVtKSxcblx0XHRcdFx0dGFyZyA9IHRhcmdldCwgXG5cdFx0XHRcdGF0dHIgPSB7fSxcblx0XHRcdFx0dG9mZjtcblxuXHRcdFx0c3dpdGNoICh0eXBlb2YgdGFyZykge1xuXHRcdFx0XHQvLyBBIG51bWJlciB3aWxsIHBhc3MgdGhlIHJlZ2V4XG5cdFx0XHRcdGNhc2UgJ251bWJlcic6XG5cdFx0XHRcdGNhc2UgJ3N0cmluZyc6XG5cdFx0XHRcdFx0aWYgKC9eKFsrLV09Pyk/XFxkKyhcXC5cXGQrKT8ocHh8JSk/JC8udGVzdCh0YXJnKSkge1xuXHRcdFx0XHRcdFx0dGFyZyA9IGJvdGgodGFyZyk7XG5cdFx0XHRcdFx0XHQvLyBXZSBhcmUgZG9uZVxuXHRcdFx0XHRcdFx0YnJlYWs7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdC8vIFJlbGF0aXZlL0Fic29sdXRlIHNlbGVjdG9yXG5cdFx0XHRcdFx0dGFyZyA9IHdpbiA/ICQodGFyZykgOiAkKHRhcmcsIGVsZW0pO1xuXHRcdFx0XHRcdC8qIGZhbGxzIHRocm91Z2ggKi9cblx0XHRcdFx0Y2FzZSAnb2JqZWN0Jzpcblx0XHRcdFx0XHRpZiAodGFyZy5sZW5ndGggPT09IDApIHJldHVybjtcblx0XHRcdFx0XHQvLyBET01FbGVtZW50IC8galF1ZXJ5XG5cdFx0XHRcdFx0aWYgKHRhcmcuaXMgfHwgdGFyZy5zdHlsZSkge1xuXHRcdFx0XHRcdFx0Ly8gR2V0IHRoZSByZWFsIHBvc2l0aW9uIG9mIHRoZSB0YXJnZXRcblx0XHRcdFx0XHRcdHRvZmYgPSAodGFyZyA9ICQodGFyZykpLm9mZnNldCgpO1xuXHRcdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0dmFyIG9mZnNldCA9ICQuaXNGdW5jdGlvbihzZXR0aW5ncy5vZmZzZXQpICYmIHNldHRpbmdzLm9mZnNldChlbGVtLCB0YXJnKSB8fCBzZXR0aW5ncy5vZmZzZXQ7XG5cblx0XHRcdCQuZWFjaChzZXR0aW5ncy5heGlzLnNwbGl0KCcnKSwgZnVuY3Rpb24oaSwgYXhpcykge1xuXHRcdFx0XHR2YXIgUG9zXHQ9IGF4aXMgPT09ICd4JyA/ICdMZWZ0JyA6ICdUb3AnLFxuXHRcdFx0XHRcdHBvcyA9IFBvcy50b0xvd2VyQ2FzZSgpLFxuXHRcdFx0XHRcdGtleSA9ICdzY3JvbGwnICsgUG9zLFxuXHRcdFx0XHRcdHByZXYgPSAkZWxlbVtrZXldKCksXG5cdFx0XHRcdFx0bWF4ID0gJHNjcm9sbFRvLm1heChlbGVtLCBheGlzKTtcblxuXHRcdFx0XHRpZiAodG9mZikgey8vIGpRdWVyeSAvIERPTUVsZW1lbnRcblx0XHRcdFx0XHRhdHRyW2tleV0gPSB0b2ZmW3Bvc10gKyAod2luID8gMCA6IHByZXYgLSAkZWxlbS5vZmZzZXQoKVtwb3NdKTtcblxuXHRcdFx0XHRcdC8vIElmIGl0J3MgYSBkb20gZWxlbWVudCwgcmVkdWNlIHRoZSBtYXJnaW5cblx0XHRcdFx0XHRpZiAoc2V0dGluZ3MubWFyZ2luKSB7XG5cdFx0XHRcdFx0XHRhdHRyW2tleV0gLT0gcGFyc2VJbnQodGFyZy5jc3MoJ21hcmdpbicrUG9zKSwgMTApIHx8IDA7XG5cdFx0XHRcdFx0XHRhdHRyW2tleV0gLT0gcGFyc2VJbnQodGFyZy5jc3MoJ2JvcmRlcicrUG9zKydXaWR0aCcpLCAxMCkgfHwgMDtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRhdHRyW2tleV0gKz0gb2Zmc2V0W3Bvc10gfHwgMDtcblxuXHRcdFx0XHRcdGlmIChzZXR0aW5ncy5vdmVyW3Bvc10pIHtcblx0XHRcdFx0XHRcdC8vIFNjcm9sbCB0byBhIGZyYWN0aW9uIG9mIGl0cyB3aWR0aC9oZWlnaHRcblx0XHRcdFx0XHRcdGF0dHJba2V5XSArPSB0YXJnW2F4aXMgPT09ICd4Jz8nd2lkdGgnOidoZWlnaHQnXSgpICogc2V0dGluZ3Mub3Zlcltwb3NdO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHR2YXIgdmFsID0gdGFyZ1twb3NdO1xuXHRcdFx0XHRcdC8vIEhhbmRsZSBwZXJjZW50YWdlIHZhbHVlc1xuXHRcdFx0XHRcdGF0dHJba2V5XSA9IHZhbC5zbGljZSAmJiB2YWwuc2xpY2UoLTEpID09PSAnJScgP1xuXHRcdFx0XHRcdFx0cGFyc2VGbG9hdCh2YWwpIC8gMTAwICogbWF4XG5cdFx0XHRcdFx0XHQ6IHZhbDtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIE51bWJlciBvciAnbnVtYmVyJ1xuXHRcdFx0XHRpZiAoc2V0dGluZ3MubGltaXQgJiYgL15cXGQrJC8udGVzdChhdHRyW2tleV0pKSB7XG5cdFx0XHRcdFx0Ly8gQ2hlY2sgdGhlIGxpbWl0c1xuXHRcdFx0XHRcdGF0dHJba2V5XSA9IGF0dHJba2V5XSA8PSAwID8gMCA6IE1hdGgubWluKGF0dHJba2V5XSwgbWF4KTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIERvbid0IHdhc3RlIHRpbWUgYW5pbWF0aW5nLCBpZiB0aGVyZSdzIG5vIG5lZWQuXG5cdFx0XHRcdGlmICghaSAmJiBzZXR0aW5ncy5heGlzLmxlbmd0aCA+IDEpIHtcblx0XHRcdFx0XHRpZiAocHJldiA9PT0gYXR0cltrZXldKSB7XG5cdFx0XHRcdFx0XHQvLyBObyBhbmltYXRpb24gbmVlZGVkXG5cdFx0XHRcdFx0XHRhdHRyID0ge307XG5cdFx0XHRcdFx0fSBlbHNlIGlmIChxdWV1ZSkge1xuXHRcdFx0XHRcdFx0Ly8gSW50ZXJtZWRpYXRlIGFuaW1hdGlvblxuXHRcdFx0XHRcdFx0YW5pbWF0ZShzZXR0aW5ncy5vbkFmdGVyRmlyc3QpO1xuXHRcdFx0XHRcdFx0Ly8gRG9uJ3QgYW5pbWF0ZSB0aGlzIGF4aXMgYWdhaW4gaW4gdGhlIG5leHQgaXRlcmF0aW9uLlxuXHRcdFx0XHRcdFx0YXR0ciA9IHt9O1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fSk7XG5cblx0XHRcdGFuaW1hdGUoc2V0dGluZ3Mub25BZnRlcik7XG5cblx0XHRcdGZ1bmN0aW9uIGFuaW1hdGUoY2FsbGJhY2spIHtcblx0XHRcdFx0dmFyIG9wdHMgPSAkLmV4dGVuZCh7fSwgc2V0dGluZ3MsIHtcblx0XHRcdFx0XHQvLyBUaGUgcXVldWUgc2V0dGluZyBjb25mbGljdHMgd2l0aCBhbmltYXRlKClcblx0XHRcdFx0XHQvLyBGb3JjZSBpdCB0byBhbHdheXMgYmUgdHJ1ZVxuXHRcdFx0XHRcdHF1ZXVlOiB0cnVlLFxuXHRcdFx0XHRcdGR1cmF0aW9uOiBkdXJhdGlvbixcblx0XHRcdFx0XHRjb21wbGV0ZTogY2FsbGJhY2sgJiYgZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRjYWxsYmFjay5jYWxsKGVsZW0sIHRhcmcsIHNldHRpbmdzKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0pO1xuXHRcdFx0XHQkZWxlbS5hbmltYXRlKGF0dHIsIG9wdHMpO1xuXHRcdFx0fVxuXHRcdH0pO1xuXHR9O1xuXG5cdC8vIE1heCBzY3JvbGxpbmcgcG9zaXRpb24sIHdvcmtzIG9uIHF1aXJrcyBtb2RlXG5cdC8vIEl0IG9ubHkgZmFpbHMgKG5vdCB0b28gYmFkbHkpIG9uIElFLCBxdWlya3MgbW9kZS5cblx0JHNjcm9sbFRvLm1heCA9IGZ1bmN0aW9uKGVsZW0sIGF4aXMpIHtcblx0XHR2YXIgRGltID0gYXhpcyA9PT0gJ3gnID8gJ1dpZHRoJyA6ICdIZWlnaHQnLFxuXHRcdFx0c2Nyb2xsID0gJ3Njcm9sbCcrRGltO1xuXG5cdFx0aWYgKCFpc1dpbihlbGVtKSlcblx0XHRcdHJldHVybiBlbGVtW3Njcm9sbF0gLSAkKGVsZW0pW0RpbS50b0xvd2VyQ2FzZSgpXSgpO1xuXG5cdFx0dmFyIHNpemUgPSAnY2xpZW50JyArIERpbSxcblx0XHRcdGRvYyA9IGVsZW0ub3duZXJEb2N1bWVudCB8fCBlbGVtLmRvY3VtZW50LFxuXHRcdFx0aHRtbCA9IGRvYy5kb2N1bWVudEVsZW1lbnQsXG5cdFx0XHRib2R5ID0gZG9jLmJvZHk7XG5cblx0XHRyZXR1cm4gTWF0aC5tYXgoaHRtbFtzY3JvbGxdLCBib2R5W3Njcm9sbF0pIC0gTWF0aC5taW4oaHRtbFtzaXplXSwgYm9keVtzaXplXSk7XG5cdH07XG5cblx0ZnVuY3Rpb24gYm90aCh2YWwpIHtcblx0XHRyZXR1cm4gJC5pc0Z1bmN0aW9uKHZhbCkgfHwgJC5pc1BsYWluT2JqZWN0KHZhbCkgPyB2YWwgOiB7IHRvcDp2YWwsIGxlZnQ6dmFsIH07XG5cdH1cblxuXHQvLyBBZGQgc3BlY2lhbCBob29rcyBzbyB0aGF0IHdpbmRvdyBzY3JvbGwgcHJvcGVydGllcyBjYW4gYmUgYW5pbWF0ZWRcblx0JC5Ud2Vlbi5wcm9wSG9va3Muc2Nyb2xsTGVmdCA9IFxuXHQkLlR3ZWVuLnByb3BIb29rcy5zY3JvbGxUb3AgPSB7XG5cdFx0Z2V0OiBmdW5jdGlvbih0KSB7XG5cdFx0XHRyZXR1cm4gJCh0LmVsZW0pW3QucHJvcF0oKTtcblx0XHR9LFxuXHRcdHNldDogZnVuY3Rpb24odCkge1xuXHRcdFx0dmFyIGN1cnIgPSB0aGlzLmdldCh0KTtcblx0XHRcdC8vIElmIGludGVycnVwdCBpcyB0cnVlIGFuZCB1c2VyIHNjcm9sbGVkLCBzdG9wIGFuaW1hdGluZ1xuXHRcdFx0aWYgKHQub3B0aW9ucy5pbnRlcnJ1cHQgJiYgdC5fbGFzdCAmJiB0Ll9sYXN0ICE9PSBjdXJyKSB7XG5cdFx0XHRcdHJldHVybiAkKHQuZWxlbSkuc3RvcCgpO1xuXHRcdFx0fVxuXHRcdFx0dmFyIG5leHQgPSBNYXRoLnJvdW5kKHQubm93KTtcblx0XHRcdC8vIERvbid0IHdhc3RlIENQVVxuXHRcdFx0Ly8gQnJvd3NlcnMgZG9uJ3QgcmVuZGVyIGZsb2F0aW5nIHBvaW50IHNjcm9sbFxuXHRcdFx0aWYgKGN1cnIgIT09IG5leHQpIHtcblx0XHRcdFx0JCh0LmVsZW0pW3QucHJvcF0obmV4dCk7XG5cdFx0XHRcdHQuX2xhc3QgPSB0aGlzLmdldCh0KTtcblx0XHRcdH1cblx0XHR9XG5cdH07XG5cblx0Ly8gQU1EIHJlcXVpcmVtZW50XG5cdHJldHVybiAkc2Nyb2xsVG87XG59KTtcbiJdLCJzb3VyY2VSb290IjoiIn0=