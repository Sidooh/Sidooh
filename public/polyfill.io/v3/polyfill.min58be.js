/* Disable minification (remove `.min` from URL path) for more info */

(function (self, undefined) {
    function IsCallable(n) {
        return "function" == typeof n
    }

    if (!("Date" in self && "now" in self.Date && "getTime" in self.Date.prototype
    )) {
        Date.now = function e() {
            return (new Date).getTime()
        };
    }
    if (!("defineProperty" in Object && function () {
            try {
                var e = {}
                return Object.defineProperty(e, "test", {value: 42}), !0
            } catch (t) {
                return !1
            }
        }()
    )) {
        !function (e) {
            var t = Object.prototype.hasOwnProperty.call(Object.prototype, "__defineGetter__"),
                r = "A property cannot both have accessors and be writable or have a value";
            Object.defineProperty = function n(o, i, f) {
                if (e && (o === window || o === document || o === Element.prototype || o instanceof Element)) return e(o, i, f);
                if (null === o || !(o instanceof Object || "object" == typeof o)) throw new TypeError("Object.defineProperty called on non-object");
                if (!(f instanceof Object)) throw new TypeError("Property description must be an object");
                var c = String(i), a = "value" in f || "writable" in f, p = "get" in f && typeof f.get,
                    s = "set" in f && typeof f.set;
                if (p) {
                    if (p === undefined) return o;
                    if ("function" !== p) throw new TypeError("Getter must be a function");
                    if (!t) throw new TypeError("Getters & setters cannot be defined on this javascript engine");
                    if (a) throw new TypeError(r);
                    Object.__defineGetter__.call(o, c, f.get)
                } else o[c] = f.value;
                if (s) {
                    if (s === undefined) return o;
                    if ("function" !== s) throw new TypeError("Setter must be a function");
                    if (!t) throw new TypeError("Getters & setters cannot be defined on this javascript engine");
                    if (a) throw new TypeError(r);
                    Object.__defineSetter__.call(o, c, f.set)
                }
                return "value" in f && (o[c] = f.value), o
            }
        }(Object.defineProperty);
    }

    function CreateMethodProperty(e, r, t) {
        var a = {value: t, writable: !0, enumerable: !1, configurable: !0};
        Object.defineProperty(e, r, a)
    }

    if (!("bind" in Function.prototype
    )) {
        CreateMethodProperty(Function.prototype, "bind", function t(n) {
            var r = Array, o = Object, e = r.prototype, l = function g() {
            }, p = e.slice, a = e.concat, i = e.push, c = Math.max, u = this;
            if (!IsCallable(u)) throw new TypeError("Function.prototype.bind called on incompatible " + u);
            for (var y, h = p.call(arguments, 1), s = function () {
                if (this instanceof y) {
                    var t = u.apply(this, a.call(h, p.call(arguments)));
                    return o(t) === t ? t : this
                }
                return u.apply(n, a.call(h, p.call(arguments)))
            }, f = c(0, u.length - h.length), b = [], d = 0; d < f; d++) i.call(b, "$" + d);
            return y = Function("binder", "return function (" + b.join(",") + "){ return binder.apply(this, arguments); }")(s), u.prototype && (l.prototype = u.prototype, y.prototype = new l, l.prototype = null), y
        });
    }
    if (!("requestAnimationFrame" in self
    )) {
        !function (n) {
            var e, t = Date.now(), o = function () {
                return n.performance && "function" == typeof n.performance.now ? n.performance.now() : Date.now() - t
            };
            if ("mozRequestAnimationFrame" in n ? e = "moz" : "webkitRequestAnimationFrame" in n && (e = "webkit"), e) n.requestAnimationFrame = function (t) {
                return n[e + "RequestAnimationFrame"](function () {
                    t(o())
                })
            }, n.cancelAnimationFrame = n[e + "CancelAnimationFrame"]; else {
                var i = Date.now();
                n.requestAnimationFrame = function (n) {
                    if ("function" != typeof n) throw new TypeError(n + " is not a function");
                    var e = Date.now(), t = 16 + i - e;
                    return t < 0 && (t = 0), i = e, setTimeout(function () {
                        i = Date.now(), n(o())
                    }, t)
                }, n.cancelAnimationFrame = function (n) {
                    clearTimeout(n)
                }
            }
        }(self);
    }
    if (!("Window" in self
    )) {
        "undefined" == typeof WorkerGlobalScope && "function" != typeof importScripts && function (o) {
            o.constructor ? o.Window = o.constructor : (o.Window = o.constructor = new Function("return function Window() {}")()).prototype = self
        }(self);
    }
    if (!("getComputedStyle" in self
    )) {
        !function (t) {
            function e(t, o, r) {
                var n, i = t.document && t.currentStyle[o].match(/([\d.]+)(%|cm|em|in|mm|pc|pt|)/) || [0, 0, ""],
                    l = i[1], u = i[2];
                return r = r ? /%|em/.test(u) && t.parentElement ? e(t.parentElement, "fontSize", null) : 16 : r, n = "fontSize" == o ? r : /width/i.test(o) ? t.clientWidth : t.clientHeight, "%" == u ? l / 100 * n : "cm" == u ? .3937 * l * 96 : "em" == u ? l * r : "in" == u ? 96 * l : "mm" == u ? .3937 * l * 96 / 10 : "pc" == u ? 12 * l * 96 / 72 : "pt" == u ? 96 * l / 72 : l
            }

            function o(t, e) {
                var o = "border" == e ? "Width" : "", r = e + "Top" + o, n = e + "Right" + o, i = e + "Bottom" + o,
                    l = e + "Left" + o;
                t[e] = (t[r] == t[n] && t[r] == t[i] && t[r] == t[l] ? [t[r]] : t[r] == t[i] && t[l] == t[n] ? [t[r], t[n]] : t[l] == t[n] ? [t[r], t[n], t[i]] : [t[r], t[n], t[i], t[l]]).join(" ")
            }

            function r(t) {
                var r, n = this, i = t.currentStyle, l = e(t, "fontSize"), u = function (t) {
                    return "-" + t.toLowerCase()
                };
                for (r in i) if (Array.prototype.push.call(n, "styleFloat" == r ? "float" : r.replace(/[A-Z]/, u)), "width" == r) n[r] = t.offsetWidth + "px"; else if ("height" == r) n[r] = t.offsetHeight + "px"; else if ("styleFloat" == r) n["float"] = i[r]; else if (/margin.|padding.|border.+W/.test(r) && "auto" != n[r]) n[r] = Math.round(e(t, r, l)) + "px"; else if (/^outline/.test(r)) try {
                    n[r] = i[r]
                } catch (c) {
                    n.outlineColor = i.color, n.outlineStyle = n.outlineStyle || "none", n.outlineWidth = n.outlineWidth || "0px", n.outline = [n.outlineColor, n.outlineWidth, n.outlineStyle].join(" ")
                } else n[r] = i[r];
                o(n, "margin"), o(n, "padding"), o(n, "border"), n.fontSize = Math.round(l) + "px"
            }

            r.prototype = {
                constructor: r, getPropertyPriority: function () {
                    throw new Error("NotSupportedError: DOM Exception 9")
                }, getPropertyValue: function (t) {
                    return this[t.replace(/-\w/g, function (t) {
                        return t[1].toUpperCase()
                    })]
                }, item: function (t) {
                    return this[t]
                }, removeProperty: function () {
                    throw new Error("NoModificationAllowedError: DOM Exception 7")
                }, setProperty: function () {
                    throw new Error("NoModificationAllowedError: DOM Exception 7")
                }, getPropertyCSSValue: function () {
                    throw new Error("NotSupportedError: DOM Exception 9")
                }
            }, t.getComputedStyle = function n(t) {
                return new r(t)
            }
        }(self);
    }
    if (!((function () {
            if ("document" in self && "documentElement" in self.document && "style" in self.document.documentElement && "scrollBehavior" in document.documentElement.style) return !0
            if (Element.prototype.scrollTo && Element.prototype.scrollTo.toString().indexOf("[native code]") > -1) return !1
            try {
                var e = !1, t = {top: 1, left: 0}
                Object.defineProperty(t, "behavior", {
                    get: function () {
                        return e = !0, "smooth"
                    }, enumerable: !0
                })
                var o = document.createElement("DIV"), n = document.createElement("DIV")
                return o.setAttribute("style", "height: 1px; overflow: scroll;"), n.setAttribute("style", "height: 2px; overflow: scroll;"), o.appendChild(n), o.scrollTo(t), e
            } catch (r) {
                return !1
            }
        })()
    )) {
        !function (e, t) {
            var n = {};
            !function (e) {
                "use strict";

                function t(e) {
                    var t = "function" == typeof Symbol && Symbol.iterator, n = t && e[t], o = 0;
                    if (n) return n.call(e);
                    if (e && "number" == typeof e.length) return {
                        next: function () {
                            return e && o >= e.length && (e = void 0), {value: e && e[o++], done: !e}
                        }
                    };
                    throw new TypeError(t ? "Object is not iterable." : "Symbol.iterator is not defined.")
                }

                var n = function (e) {
                    return .5 * (1 - Math.cos(Math.PI * e))
                }, o = function () {
                    return "scrollBehavior" in document.documentElement.style
                }, r = {
                    _elementScroll: undefined, get elementScroll() {
                        return this._elementScroll || (this._elementScroll = HTMLElement.prototype.scroll || HTMLElement.prototype.scrollTo || function (e, t) {
                            this.scrollLeft = e, this.scrollTop = t
                        })
                    }, _elementScrollIntoView: undefined, get elementScrollIntoView() {
                        return this._elementScrollIntoView || (this._elementScrollIntoView = HTMLElement.prototype.scrollIntoView)
                    }, _windowScroll: undefined, get windowScroll() {
                        return this._windowScroll || (this._windowScroll = window.scroll || window.scrollTo)
                    }
                }, i = function (e) {
                    [HTMLElement.prototype, SVGElement.prototype, Element.prototype].forEach(function (t) {
                        return e(t)
                    })
                }, l = function () {
                    var e, t, n;
                    return null !== (n = null === (t = null === (e = window.performance) || void 0 === e ? void 0 : e.now) || void 0 === t ? void 0 : t.call(e)) && void 0 !== n ? n : Date.now()
                }, c = function (e) {
                    var t = l(), o = (t - e.timeStamp) / (e.duration || 500);
                    if (o > 1) return e.method(e.targetX, e.targetY), void e.callback();
                    var r = (e.timingFunc || n)(o), i = e.startX + (e.targetX - e.startX) * r,
                        a = e.startY + (e.targetY - e.startY) * r;
                    e.method(i, a), e.rafId = requestAnimationFrame(function () {
                        c(e)
                    })
                }, a = function (e) {
                    return isFinite(e) ? Number(e) : 0
                }, u = function (e) {
                    var t = typeof e;
                    return null !== e && ("object" === t || "function" === t)
                }, f = function () {
                    return f = Object.assign || function e(t) {
                        for (var n, o = 1, r = arguments.length; o < r; o++) {
                            n = arguments[o];
                            for (var i in n) Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i])
                        }
                        return t
                    }, f.apply(this, arguments)
                }, s = function (e, t) {
                    var n, o, i = r.elementScroll.bind(e);
                    if (t.left !== undefined || t.top !== undefined) {
                        var u = e.scrollLeft, f = e.scrollTop, s = a(null !== (n = t.left) && void 0 !== n ? n : u),
                            d = a(null !== (o = t.top) && void 0 !== o ? o : f);
                        if ("smooth" !== t.behavior) return i(s, d);
                        var w = function () {
                            window.removeEventListener("wheel", h), window.removeEventListener("touchmove", h)
                        }, m = {
                            timeStamp: l(),
                            duration: t.duration,
                            startX: u,
                            startY: f,
                            targetX: s,
                            targetY: d,
                            rafId: 0,
                            method: i,
                            timingFunc: t.timingFunc,
                            callback: w
                        }, h = function () {
                            cancelAnimationFrame(m.rafId), w()
                        };
                        window.addEventListener("wheel", h, {
                            passive: !0,
                            once: !0
                        }), window.addEventListener("touchmove", h, {passive: !0, once: !0}), c(m)
                    }
                }, d = function (e) {
                    if (!o()) {
                        var t = r.elementScroll;
                        i(function (n) {
                            return n.scroll = function o() {
                                if (1 === arguments.length) {
                                    var n = arguments[0];
                                    if (!u(n)) throw new TypeError("Failed to execute 'scroll' on 'Element': parameter 1 ('options') is not an object.");
                                    return s(this, f(f({}, n), e))
                                }
                                return t.apply(this, arguments)
                            }
                        })
                    }
                }, w = function (e, t) {
                    var n = a(t.left || 0) + e.scrollLeft, o = a(t.top || 0) + e.scrollTop;
                    return s(e, f(f({}, t), {left: n, top: o}))
                }, m = function (e) {
                    o() || i(function (t) {
                        return t.scrollBy = function n() {
                            if (1 === arguments.length) {
                                var t = arguments[0];
                                if (!u(t)) throw new TypeError("Failed to execute 'scrollBy' on 'Element': parameter 1 ('options') is not an object.");
                                return w(this, f(f({}, t), e))
                            }
                            var n = Number(arguments[0]), o = Number(arguments[1]);
                            return w(this, {left: n, top: o})
                        }
                    })
                }, h = function (e, t, n, o) {
                    var r = 0 === t && n || 1 === t && !n ? e.inline : e.block;
                    return "center" === r ? 1 : "nearest" === r ? 0 : "start" === r ? 0 === t ? o ? 5 : 4 : 2 : "end" === r ? 0 === t ? o ? 4 : 5 : 3 : n ? 0 === t ? 0 : 2 : 0 === t ? 4 : 0
                }, p = function (e, t, n, o, r, i, l, c) {
                    return i < e && l > t || i > e && l < t ? 0 : i <= e && c <= n || l >= t && c >= n ? i - e - o : l > t && c < n || i < e && c > n ? l - t + r : 0
                }, v = function (e) {
                    return "visible" !== e && "clip" !== e
                }, b = function (e) {
                    if (e.clientHeight < e.scrollHeight || e.clientWidth < e.scrollWidth) {
                        var t = getComputedStyle(e);
                        return v(t.overflowY) || v(t.overflowX)
                    }
                    return !1
                }, g = function (e) {
                    var t = e.parentNode;
                    return t && (t.nodeType === Node.DOCUMENT_FRAGMENT_NODE ? t.host : t)
                }, y = function (e, n) {
                    var o, r;
                    if (e.ownerDocument.documentElement.contains(e)) {
                        for (var i = document.scrollingElement || document.documentElement, l = [], c = g(e); null !== c; c = g(c)) {
                            if (c === i) {
                                l.push(c);
                                break
                            }
                            c === document.body && b(c) && !b(document.documentElement) || b(c) && l.push(c)
                        }
                        var a = window.visualViewport ? window.visualViewport.width : innerWidth,
                            u = window.visualViewport ? window.visualViewport.height : innerHeight,
                            d = window.scrollX || window.pageXOffset, w = window.scrollY || window.pageYOffset,
                            m = e.getBoundingClientRect(), v = m.height, y = m.width, S = m.top, E = m.right,
                            T = m.bottom, k = m.left, I = getComputedStyle(e),
                            j = I.writingMode || I.getPropertyValue("-webkit-writing-mode") || I.getPropertyValue("-ms-writing-mode") || "horizontal-tb",
                            L = ["horizontal-tb", "lr", "lr-tb", "rl"].some(function (e) {
                                return e === j
                            }), F = ["vertical-rl", "tb-rl"].some(function (e) {
                                return e === j
                            }), M = h(n, 0, L, F), O = h(n, 1, L, F), V = function () {
                                switch (O) {
                                    case 2:
                                    case 0:
                                        return S;
                                    case 3:
                                        return T;
                                    default:
                                        return S + v / 2
                                }
                            }(), X = function () {
                                switch (M) {
                                    case 1:
                                        return k + y / 2;
                                    case 5:
                                        return E;
                                    default:
                                        return k
                                }
                            }(), Y = [];
                        try {
                            for (var N = t(l), W = N.next(); !W.done; W = N.next()) {
                                var x = W.value;
                                !function (e) {
                                    var t = e.getBoundingClientRect(), o = t.height, r = t.width, l = t.top,
                                        c = t.right, m = t.bottom, h = t.left, b = getComputedStyle(e),
                                        g = parseInt(b.borderLeftWidth, 10), S = parseInt(b.borderTopWidth, 10),
                                        E = parseInt(b.borderRightWidth, 10), T = parseInt(b.borderBottomWidth, 10),
                                        k = 0, I = 0,
                                        j = "offsetWidth" in e ? e.offsetWidth - e.clientWidth - g - E : 0,
                                        L = "offsetHeight" in e ? e.offsetHeight - e.clientHeight - S - T : 0;
                                    if (i === e) {
                                        switch (O) {
                                            case 2:
                                                k = V;
                                                break;
                                            case 3:
                                                k = V - u;
                                                break;
                                            case 1:
                                                k = V - u / 2;
                                                break;
                                            case 0:
                                                k = p(w, w + u, u, S, T, w + V, w + V + v, v)
                                        }
                                        switch (M) {
                                            case 4:
                                                I = X;
                                                break;
                                            case 5:
                                                I = X - a;
                                                break;
                                            case 1:
                                                I = X - a / 2;
                                                break;
                                            case 0:
                                                I = p(d, d + a, a, g, E, d + X, d + X + y, y)
                                        }
                                        k = Math.max(0, k + w), I = Math.max(0, I + d)
                                    } else {
                                        switch (O) {
                                            case 2:
                                                k = V - l - S;
                                                break;
                                            case 3:
                                                k = V - m + T + L;
                                                break;
                                            case 1:
                                                k = V - (l + o / 2) + L / 2;
                                                break;
                                            case 0:
                                                k = p(l, m, o, S, T + L, V, V + v, v)
                                        }
                                        switch (M) {
                                            case 4:
                                                I = X - h - g;
                                                break;
                                            case 5:
                                                I = X - c + E + j;
                                                break;
                                            case 1:
                                                I = X - (h + r / 2) + j / 2;
                                                break;
                                            case 0:
                                                I = p(h, c, r, g, E + j, X, X + y, y)
                                        }
                                        var F = e.scrollLeft, N = e.scrollTop;
                                        k = Math.max(0, Math.min(N + k, e.scrollHeight - o + L)), I = Math.max(0, Math.min(F + I, e.scrollWidth - r + j)), V += N - k, X += F - I
                                    }
                                    Y.push(function () {
                                        return s(e, f(f({}, n), {top: k, left: I}))
                                    })
                                }(x)
                            }
                        } catch (_) {
                            o = {error: _}
                        } finally {
                            try {
                                W && !W.done && (r = N["return"]) && r.call(N)
                            } finally {
                                if (o) throw o.error
                            }
                        }
                        Y.forEach(function (e) {
                            return e()
                        })
                    }
                }, S = function (e) {
                    if (!o()) {
                        var t = r.elementScrollIntoView;
                        i(function (n) {
                            return n.scrollIntoView = function o() {
                                var n = arguments[0];
                                return 1 === arguments.length && u(n) ? y(this, f(f({}, n), e)) : t.apply(this, arguments)
                            }
                        })
                    }
                }, E = function (e) {
                    if (!o()) {
                        var t = r.elementScroll;
                        i(function (n) {
                            return n.scrollTo = function o() {
                                if (1 === arguments.length) {
                                    var n = arguments[0];
                                    if (!u(n)) throw new TypeError("Failed to execute 'scrollTo' on 'Element': parameter 1 ('options') is not an object.");
                                    var o = Number(n.left), r = Number(n.top);
                                    return s(this, f(f(f({}, n), {left: o, top: r}), e))
                                }
                                return t.apply(this, arguments)
                            }
                        })
                    }
                }, T = function (e) {
                    var t, n, o = r.windowScroll.bind(window);
                    if (e.left !== undefined || e.top !== undefined) {
                        var i = window.scrollX || window.pageXOffset, u = window.scrollY || window.pageYOffset,
                            f = a(null !== (t = e.left) && void 0 !== t ? t : i),
                            s = a(null !== (n = e.top) && void 0 !== n ? n : u);
                        if ("smooth" !== e.behavior) return o(f, s);
                        var d = function () {
                            window.removeEventListener("wheel", m), window.removeEventListener("touchmove", m)
                        }, w = {
                            timeStamp: l(),
                            duration: e.duration,
                            startX: i,
                            startY: u,
                            targetX: f,
                            targetY: s,
                            rafId: 0,
                            method: o,
                            timingFunc: e.timingFunc,
                            callback: d
                        }, m = function () {
                            cancelAnimationFrame(w.rafId), d()
                        };
                        window.addEventListener("wheel", m, {
                            passive: !0,
                            once: !0
                        }), window.addEventListener("touchmove", m, {passive: !0, once: !0}), c(w)
                    }
                }, k = function (e) {
                    if (!o()) {
                        var t = r.windowScroll;
                        window.scroll = function n() {
                            if (1 === arguments.length) {
                                var n = arguments[0];
                                if (!u(n)) throw new TypeError("Failed to execute 'scroll' on 'Window': parameter 1 ('options') is not an object.");
                                return T(f(f({}, n), e))
                            }
                            return t.apply(this, arguments)
                        }
                    }
                }, I = function (e) {
                    var t = a(e.left || 0) + (window.scrollX || window.pageXOffset),
                        n = a(e.top || 0) + (window.scrollY || window.pageYOffset);
                    return "smooth" !== e.behavior ? r.windowScroll.call(window, t, n) : T(f(f({}, e), {
                        left: t,
                        top: n
                    }))
                }, j = function (e) {
                    o() || (window.scrollBy = function t() {
                        if (1 === arguments.length) {
                            var t = arguments[0];
                            if (!u(t)) throw new TypeError("Failed to execute 'scrollBy' on 'Window': parameter 1 ('options') is not an object.");
                            return I(f(f({}, t), e))
                        }
                        var n = Number(arguments[0]), o = Number(arguments[1]);
                        return I({left: n, top: o})
                    })
                }, L = function (e) {
                    if (!o()) {
                        var t = r.windowScroll;
                        window.scrollTo = function n() {
                            if (1 === arguments.length) {
                                var n = arguments[0];
                                if (!u(n)) throw new TypeError("Failed to execute 'scrollTo' on 'Window': parameter 1 ('options') is not an object.");
                                var o = Number(n.left), r = Number(n.top);
                                return T(f(f(f({}, n), {left: o, top: r}), e))
                            }
                            return t.apply(this, arguments)
                        }
                    }
                }, F = function (e) {
                    o() || (k(e), L(e), j(e), d(e), E(e), m(e), S(e))
                };
                e.elementScroll = s, e.elementScrollBy = w, e.elementScrollByPolyfill = m, e.elementScrollIntoView = y, e.elementScrollIntoViewPolyfill = S, e.elementScrollPolyfill = d, e.elementScrollTo = s, e.elementScrollToPolyfill = E, e.polyfill = F, e.seamless = F, e.windowScroll = T, e.windowScrollBy = I, e.windowScrollByPolyfill = j, e.windowScrollPolyfill = k, e.windowScrollTo = T, e.windowScrollToPolyfill = L, Object.defineProperty(e, "__esModule", {value: !0})
            }(n), n.polyfill()
        }();
    }
})('object' === typeof window && window || 'object' === typeof self && self || 'object' === typeof global && global || {});
