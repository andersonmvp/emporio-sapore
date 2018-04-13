/*!
 * Ladda 1.0.0 (2016-03-08, 09:31)
 * http://lab.hakim.se/ladda
 * MIT licensed
 *
 * Copyright (C) 2016 Hakim El Hattab, http://hakim.se
 */
! function(a, b) {
	"object" == typeof exports ? module.exports = b(require("spin.js")) : "function" == typeof define && define.amd ? define(["spin"], b) : a.Ladda = b(a.Spinner)
}(this, function(a) {
	"use strict";

	function b(a) {
		if ("undefined" == typeof a) return void console.warn("Ladda button target must be defined.");
		if (/ladda-button/i.test(a.className) || (a.className += " ladda-button"), a.hasAttribute("data-style") || a.setAttribute("data-style", "expand-right"), !a.querySelector(".ladda-label")) {
			var b = document.createElement("span");
			b.className = "ladda-label", i(a, b)
		}
		var c, d = a.querySelector(".ladda-spinner");
		d || (d = document.createElement("span"), d.className = "ladda-spinner"), a.appendChild(d);
		var e, f = {
			start: function() {
				return c || (c = g(a)), a.setAttribute("disabled", ""), a.setAttribute("data-loading", ""), clearTimeout(e), c.spin(d), this.setProgress(0), this
			},
			startAfter: function(a) {
				return clearTimeout(e), e = setTimeout(function() {
					f.start()
				}, a), this
			},
			stop: function() {
				return a.removeAttribute("disabled"), a.removeAttribute("data-loading"), clearTimeout(e), c && (e = setTimeout(function() {
					c.stop()
				}, 1e3)), this
			},
			toggle: function() {
				return this.isLoading() ? this.stop() : this.start(), this
			},
			setProgress: function(b) {
				b = Math.max(Math.min(b, 1), 0);
				var c = a.querySelector(".ladda-progress");
				0 === b && c && c.parentNode ? c.parentNode.removeChild(c) : (c || (c = document.createElement("div"), c.className = "ladda-progress", a.appendChild(c)), c.style.width = (b || 0) * a.offsetWidth + "px")
			},
			enable: function() {
				return this.stop(), this
			},
			disable: function() {
				return this.stop(), a.setAttribute("disabled", ""), this
			},
			isLoading: function() {
				return a.hasAttribute("data-loading")
			},
			remove: function() {
				clearTimeout(e), a.removeAttribute("disabled", ""), a.removeAttribute("data-loading", ""), c && (c.stop(), c = null);
				for (var b = 0, d = j.length; d > b; b++)
					if (f === j[b]) {
						j.splice(b, 1);
						break
					}
			}
		};
		return j.push(f), f
	}

	function c(a, b) {
		for (; a.parentNode && a.tagName !== b;) a = a.parentNode;
		return b === a.tagName ? a : void 0
	}

	function d(a) {
		for (var b = ["input", "textarea", "select"], c = [], d = 0; d < b.length; d++)
			for (var e = a.getElementsByTagName(b[d]), f = 0; f < e.length; f++) e[f].hasAttribute("required") && c.push(e[f]);
		return c
	}

	function e(a, e) {
		e = e || {};
		var f = [];
		"string" == typeof a ? f = h(document.querySelectorAll(a)) : "object" == typeof a && "string" == typeof a.nodeName && (f = [a]);
		for (var g = 0, i = f.length; i > g; g++) ! function() {
			var a = f[g];
			if ("function" == typeof a.addEventListener) {
				var h = b(a),
					i = -1;
				a.addEventListener("click", function(b) {
					var f = !0,
						g = c(a, "FORM");
					if ("undefined" != typeof g)
						if ("function" == typeof g.checkValidity) f = g.checkValidity();
						else
							for (var j = d(g), k = 0; k < j.length; k++) "" === j[k].value.replace(/^\s+|\s+$/g, "") && (f = !1), "checkbox" !== j[k].type && "radio" !== j[k].type || j[k].checked || (f = !1), "email" === j[k].type && (f = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/.test(j[k].value));
					f && (h.startAfter(1), "number" == typeof e.timeout && (clearTimeout(i), i = setTimeout(h.stop, e.timeout)), "function" == typeof e.callback && e.callback.apply(null, [h]))
				}, !1)
			}
		}()
	}

	function f() {
		for (var a = 0, b = j.length; b > a; a++) j[a].stop()
	}

	function g(b) {
		var c, d, e = b.offsetHeight;
		0 === e && (e = parseFloat(window.getComputedStyle(b).height)), e > 32 && (e *= .8), b.hasAttribute("data-spinner-size") && (e = parseInt(b.getAttribute("data-spinner-size"), 10)), b.hasAttribute("data-spinner-color") && (c = b.getAttribute("data-spinner-color")), b.hasAttribute("data-spinner-lines") && (d = parseInt(b.getAttribute("data-spinner-lines"), 10));
		var f = .2 * e,
			g = .6 * f,
			h = 7 > f ? 2 : 3;
		return new a({
			color: c || "#fff",
			lines: d || 12,
			radius: f,
			length: g,
			width: h,
			zIndex: "auto",
			top: "auto",
			left: "auto",
			className: ""
		})
	}

	function h(a) {
		for (var b = [], c = 0; c < a.length; c++) b.push(a[c]);
		return b
	}

	function i(a, b) {
		var c = document.createRange();
		c.selectNodeContents(a), c.surroundContents(b), a.appendChild(b)
	}
	var j = [];
	return {
		bind: e,
		create: b,
		stopAll: f
	}
});