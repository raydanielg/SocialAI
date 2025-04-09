
var e;
var t;
var r;
var i;
var s;
var o;
var a;
var n;
var l;
var c;
var d;
var p;
var h;
var g;
var u = () => e || "undefined" != typeof window && (e = window.gsap) && e.registerPlugin && e;
var f = 1;
var m = [];
var v = [];
var y = [];
var x = Date.now;
var b = (e2, t2) => t2;
var w = (e2, t2) => ~y.indexOf(e2) && y[y.indexOf(e2) + 1][t2];
var _ = (e2) => !!~d.indexOf(e2);
var T = (e2, t2, r2, i2, s2) => e2.addEventListener(t2, r2, { passive: false !== i2, capture: !!s2 });
var k = (e2, t2, r2, i2) => e2.removeEventListener(t2, r2, !!i2);
var S = () => p && p.isPressed || v.cache++;
var C = (e2, t2) => {
  let r2 = (s2) => {
    if (s2 || 0 === s2) {
      f && (i.history.scrollRestoration = "manual");
      let t3 = p && p.isPressed;
      s2 = r2.v = Math.round(s2) || (p && p.iOS ? 1 : 0), e2(s2), r2.cacheID = v.cache, t3 && b("ss", s2);
    } else
      (t2 || v.cache !== r2.cacheID || b("ref")) && (r2.cacheID = v.cache, r2.v = e2());
    return r2.v + r2.offset;
  };
  return r2.offset = 0, e2 && r2;
};
var E = { s: "scrollLeft", p: "left", p2: "Left", os: "right", os2: "Right", d: "width", d2: "Width", a: "x", sc: C(function(e2) {
  return arguments.length ? i.scrollTo(e2, P.sc()) : i.pageXOffset || s.scrollLeft || o.scrollLeft || a.scrollLeft || 0;
}) };
var P = { s: "scrollTop", p: "top", p2: "Top", os: "bottom", os2: "Bottom", d: "height", d2: "Height", a: "y", op: E, sc: C(function(e2) {
  return arguments.length ? i.scrollTo(E.sc(), e2) : i.pageYOffset || s.scrollTop || o.scrollTop || a.scrollTop || 0;
}) };
var M = (t2, r2) => (r2 && r2._ctx && r2._ctx.selector || e.utils.toArray)(t2)[0] || ("string" == typeof t2 && false !== e.config().nullTargetWarn ? console.warn("Element not found:", t2) : null);
var O = (t2, { s: r2, sc: i2 }) => {
  _(t2) && (t2 = s.scrollingElement || o);
  let a2 = v.indexOf(t2), n2 = i2 === P.sc ? 1 : 2;
  !~a2 && (a2 = v.push(t2) - 1), v[a2 + n2] || T(t2, "scroll", S);
  let l2 = v[a2 + n2], c2 = l2 || (v[a2 + n2] = C(w(t2, r2), true) || (_(t2) ? i2 : C(function(e2) {
    return arguments.length ? t2[r2] = e2 : t2[r2];
  })));
  return c2.target = t2, l2 || (c2.smooth = "smooth" === e.getProperty(t2, "scrollBehavior")), c2;
};
var A = (e2, t2, r2) => {
  let i2 = e2, s2 = e2, o2 = x(), a2 = o2, n2 = t2 || 50, l2 = Math.max(500, 3 * n2), c2 = (e3, t3) => {
    let l3 = x();
    t3 || l3 - o2 > n2 ? (s2 = i2, i2 = e3, a2 = o2, o2 = l3) : r2 ? i2 += e3 : i2 = s2 + (e3 - s2) / (l3 - a2) * (o2 - a2);
  };
  return { update: c2, reset: () => {
    s2 = i2 = r2 ? 0 : i2, a2 = o2 = 0;
  }, getVelocity: (e3) => {
    let t3 = a2, n3 = s2, d2 = x();
    return (e3 || 0 === e3) && e3 !== i2 && c2(e3), o2 === a2 || d2 - a2 > l2 ? 0 : (i2 + (r2 ? n3 : -n3)) / ((r2 ? d2 : o2) - t3) * 1e3;
  } };
};
var R = (e2, t2) => (t2 && !e2._gsapAllow && e2.preventDefault(), e2.changedTouches ? e2.changedTouches[0] : e2);
var D = (e2) => {
  let t2 = Math.max(...e2), r2 = Math.min(...e2);
  return Math.abs(t2) >= Math.abs(r2) ? t2 : r2;
};
var Y = () => {
  c = e.core.globals().ScrollTrigger, c && c.core && (() => {
    let e2 = c.core, t2 = e2.bridge || {}, r2 = e2._scrollers, i2 = e2._proxies;
    r2.push(...v), i2.push(...y), v = r2, y = i2, b = (e3, r3) => t2[e3](r3);
  })();
};
var B = (c2) => (e = c2 || u(), !t && e && "undefined" != typeof document && document.body && (i = window, s = document, o = s.documentElement, a = s.body, d = [i, s, o, a], r = e.utils.clamp, g = e.core.context || function() {
}, l = "onpointerenter" in a ? "pointer" : "mouse", n = I.isTouch = i.matchMedia && i.matchMedia("(hover: none), (pointer: coarse)").matches ? 1 : "ontouchstart" in i || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0 ? 2 : 0, h = I.eventTypes = ("ontouchstart" in o ? "touchstart,touchmove,touchcancel,touchend" : "onpointerdown" in o ? "pointerdown,pointermove,pointercancel,pointerup" : "mousedown,mousemove,mouseup,mouseup").split(","), setTimeout(() => f = 0, 500), Y(), t = 1), t);
E.op = P, v.cache = 0;
var I = class {
  constructor(e2) {
    this.init(e2);
  }
  init(r2) {
    t || B(e) || console.warn("Please gsap.registerPlugin(Observer)"), c || Y();
    let { tolerance: d2, dragMinimum: u2, type: f2, target: v2, lineHeight: y2, debounce: b2, preventDefault: w2, onStop: C2, onStopDelay: I2, ignore: X2, wheelSpeed: z2, event: L2, onDragStart: N2, onDragEnd: F2, onDrag: W2, onPress: H2, onRelease: q2, onRight: U2, onLeft: V2, onUp: G2, onDown: j2, onChangeX: K2, onChangeY: Z2, onChange: $2, onToggleX: J2, onToggleY: Q2, onHover: ee2, onHoverEnd: te2, onMove: re2, ignoreCheck: ie2, isNormalizer: se2, onGestureStart: oe2, onGestureEnd: ae2, onWheel: ne2, onEnable: le2, onDisable: ce2, onClick: de2, scrollSpeed: pe2, capture: he2, allowClicks: ge2, lockAxis: ue2, onLockAxis: fe2 } = r2;
    this.target = v2 = M(v2) || o, this.vars = r2, X2 && (X2 = e.utils.toArray(X2)), d2 = d2 || 1e-9, u2 = u2 || 0, z2 = z2 || 1, pe2 = pe2 || 1, f2 = f2 || "wheel,touch,pointer", b2 = false !== b2, y2 || (y2 = parseFloat(i.getComputedStyle(a).lineHeight) || 22);
    let me2, ve2, ye2, xe2, be2, we2, _e2, Te2 = this, ke2 = 0, Se2 = 0, Ce2 = r2.passive || !w2, Ee2 = O(v2, E), Pe2 = O(v2, P), Me2 = Ee2(), Oe2 = Pe2(), Ae2 = ~f2.indexOf("touch") && !~f2.indexOf("pointer") && "pointerdown" === h[0], Re2 = _(v2), De2 = v2.ownerDocument || s, Ye2 = [0, 0, 0], Be2 = [0, 0, 0], Ie2 = 0, Xe2 = () => Ie2 = x(), ze2 = (e2, t2) => (Te2.event = e2) && X2 && ~X2.indexOf(e2.target) || t2 && Ae2 && "touch" !== e2.pointerType || ie2 && ie2(e2, t2), Le2 = () => {
      let e2 = Te2.deltaX = D(Ye2), t2 = Te2.deltaY = D(Be2), r3 = Math.abs(e2) >= d2, i2 = Math.abs(t2) >= d2;
      $2 && (r3 || i2) && $2(Te2, e2, t2, Ye2, Be2), r3 && (U2 && Te2.deltaX > 0 && U2(Te2), V2 && Te2.deltaX < 0 && V2(Te2), K2 && K2(Te2), J2 && Te2.deltaX < 0 != ke2 < 0 && J2(Te2), ke2 = Te2.deltaX, Ye2[0] = Ye2[1] = Ye2[2] = 0), i2 && (j2 && Te2.deltaY > 0 && j2(Te2), G2 && Te2.deltaY < 0 && G2(Te2), Z2 && Z2(Te2), Q2 && Te2.deltaY < 0 != Se2 < 0 && Q2(Te2), Se2 = Te2.deltaY, Be2[0] = Be2[1] = Be2[2] = 0), (xe2 || ye2) && (re2 && re2(Te2), ye2 && (W2(Te2), ye2 = false), xe2 = false), we2 && !(we2 = false) && fe2 && fe2(Te2), be2 && (ne2(Te2), be2 = false), me2 = 0;
    }, Ne2 = (e2, t2, r3) => {
      Ye2[r3] += e2, Be2[r3] += t2, Te2._vx.update(e2), Te2._vy.update(t2), b2 ? me2 || (me2 = requestAnimationFrame(Le2)) : Le2();
    }, Fe2 = (e2, t2) => {
      ue2 && !_e2 && (Te2.axis = _e2 = Math.abs(e2) > Math.abs(t2) ? "x" : "y", we2 = true), "y" !== _e2 && (Ye2[2] += e2, Te2._vx.update(e2, true)), "x" !== _e2 && (Be2[2] += t2, Te2._vy.update(t2, true)), b2 ? me2 || (me2 = requestAnimationFrame(Le2)) : Le2();
    }, We2 = (e2) => {
      if (ze2(e2, 1))
        return;
      let t2 = (e2 = R(e2, w2)).clientX, r3 = e2.clientY, i2 = t2 - Te2.x, s2 = r3 - Te2.y, o2 = Te2.isDragging;
      Te2.x = t2, Te2.y = r3, (o2 || Math.abs(Te2.startX - t2) >= u2 || Math.abs(Te2.startY - r3) >= u2) && (W2 && (ye2 = true), o2 || (Te2.isDragging = true), Fe2(i2, s2), o2 || N2 && N2(Te2));
    }, He2 = Te2.onPress = (e2) => {
      ze2(e2, 1) || e2 && e2.button || (Te2.axis = _e2 = null, ve2.pause(), Te2.isPressed = true, e2 = R(e2), ke2 = Se2 = 0, Te2.startX = Te2.x = e2.clientX, Te2.startY = Te2.y = e2.clientY, Te2._vx.reset(), Te2._vy.reset(), T(se2 ? v2 : De2, h[1], We2, Ce2, true), Te2.deltaX = Te2.deltaY = 0, H2 && H2(Te2));
    }, qe2 = Te2.onRelease = (t2) => {
      if (ze2(t2, 1))
        return;
      k(se2 ? v2 : De2, h[1], We2, true);
      let r3 = !isNaN(Te2.y - Te2.startY), s2 = Te2.isDragging, o2 = s2 && (Math.abs(Te2.x - Te2.startX) > 3 || Math.abs(Te2.y - Te2.startY) > 3), a2 = R(t2);
      !o2 && r3 && (Te2._vx.reset(), Te2._vy.reset(), w2 && ge2 && e.delayedCall(0.08, () => {
        if (x() - Ie2 > 300 && !t2.defaultPrevented) {
          if (t2.target.click)
            t2.target.click();
          else if (De2.createEvent) {
            let e2 = De2.createEvent("MouseEvents");
            e2.initMouseEvent("click", true, true, i, 1, a2.screenX, a2.screenY, a2.clientX, a2.clientY, false, false, false, false, 0, null), t2.target.dispatchEvent(e2);
          }
        }
      })), Te2.isDragging = Te2.isGesturing = Te2.isPressed = false, C2 && s2 && !se2 && ve2.restart(true), F2 && s2 && F2(Te2), q2 && q2(Te2, o2);
    }, Ue2 = (e2) => e2.touches && e2.touches.length > 1 && (Te2.isGesturing = true) && oe2(e2, Te2.isDragging), Ve2 = () => (Te2.isGesturing = false) || ae2(Te2), Ge2 = (e2) => {
      if (ze2(e2))
        return;
      let t2 = Ee2(), r3 = Pe2();
      Ne2((t2 - Me2) * pe2, (r3 - Oe2) * pe2, 1), Me2 = t2, Oe2 = r3, C2 && ve2.restart(true);
    }, je2 = (e2) => {
      if (ze2(e2))
        return;
      e2 = R(e2, w2), ne2 && (be2 = true);
      let t2 = (1 === e2.deltaMode ? y2 : 2 === e2.deltaMode ? i.innerHeight : 1) * z2;
      Ne2(e2.deltaX * t2, e2.deltaY * t2, 0), C2 && !se2 && ve2.restart(true);
    }, Ke2 = (e2) => {
      if (ze2(e2))
        return;
      let t2 = e2.clientX, r3 = e2.clientY, i2 = t2 - Te2.x, s2 = r3 - Te2.y;
      Te2.x = t2, Te2.y = r3, xe2 = true, C2 && ve2.restart(true), (i2 || s2) && Fe2(i2, s2);
    }, Ze2 = (e2) => {
      Te2.event = e2, ee2(Te2);
    }, $e2 = (e2) => {
      Te2.event = e2, te2(Te2);
    }, Je2 = (e2) => ze2(e2) || R(e2, w2) && de2(Te2);
    ve2 = Te2._dc = e.delayedCall(I2 || 0.25, () => {
      Te2._vx.reset(), Te2._vy.reset(), ve2.pause(), C2 && C2(Te2);
    }).pause(), Te2.deltaX = Te2.deltaY = 0, Te2._vx = A(0, 50, true), Te2._vy = A(0, 50, true), Te2.scrollX = Ee2, Te2.scrollY = Pe2, Te2.isDragging = Te2.isGesturing = Te2.isPressed = false, g(this), Te2.enable = (e2) => (Te2.isEnabled || (T(Re2 ? De2 : v2, "scroll", S), f2.indexOf("scroll") >= 0 && T(Re2 ? De2 : v2, "scroll", Ge2, Ce2, he2), f2.indexOf("wheel") >= 0 && T(v2, "wheel", je2, Ce2, he2), (f2.indexOf("touch") >= 0 && n || f2.indexOf("pointer") >= 0) && (T(v2, h[0], He2, Ce2, he2), T(De2, h[2], qe2), T(De2, h[3], qe2), ge2 && T(v2, "click", Xe2, true, true), de2 && T(v2, "click", Je2), oe2 && T(De2, "gesturestart", Ue2), ae2 && T(De2, "gestureend", Ve2), ee2 && T(v2, l + "enter", Ze2), te2 && T(v2, l + "leave", $e2), re2 && T(v2, l + "move", Ke2)), Te2.isEnabled = true, e2 && e2.type && He2(e2), le2 && le2(Te2)), Te2), Te2.disable = () => {
      Te2.isEnabled && (m.filter((e2) => e2 !== Te2 && _(e2.target)).length || k(Re2 ? De2 : v2, "scroll", S), Te2.isPressed && (Te2._vx.reset(), Te2._vy.reset(), k(se2 ? v2 : De2, h[1], We2, true)), k(Re2 ? De2 : v2, "scroll", Ge2, he2), k(v2, "wheel", je2, he2), k(v2, h[0], He2, he2), k(De2, h[2], qe2), k(De2, h[3], qe2), k(v2, "click", Xe2, true), k(v2, "click", Je2), k(De2, "gesturestart", Ue2), k(De2, "gestureend", Ve2), k(v2, l + "enter", Ze2), k(v2, l + "leave", $e2), k(v2, l + "move", Ke2), Te2.isEnabled = Te2.isPressed = Te2.isDragging = false, ce2 && ce2(Te2));
    }, Te2.kill = Te2.revert = () => {
      Te2.disable();
      let e2 = m.indexOf(Te2);
      e2 >= 0 && m.splice(e2, 1), p === Te2 && (p = 0);
    }, m.push(Te2), se2 && _(v2) && (p = Te2), Te2.enable(L2);
  }
  get velocityX() {
    return this._vx.getVelocity();
  }
  get velocityY() {
    return this._vy.getVelocity();
  }
};
I.version = "3.12.5", I.create = (e2) => new I(e2), I.register = B, I.getAll = () => m.slice(), I.getById = (e2) => m.filter((t2) => t2.vars.id === e2)[0], u() && e.registerPlugin(I);
var X;
var z;
var L;
var N;
var F;
var W;
var H;
var q;
var U;
var V;
var G;
var j;
var K;
var Z;
var $;
var J;
var Q;
var ee;
var te;
var re;
var ie;
var se;
var oe;
var ae;
var ne;
var le;
var ce;
var de;
var pe;
var he;
var ge;
var ue;
var fe;
var me;
var ve;
var ye;
var xe;
var be;
var we = 1;
var _e = Date.now;
var Te = _e();
var ke = 0;
var Se = 0;
var Ce = (e2, t2, r2) => {
  let i2 = Ne(e2) && ("clamp(" === e2.substr(0, 6) || e2.indexOf("max") > -1);
  return r2["_" + t2 + "Clamp"] = i2, i2 ? e2.substr(6, e2.length - 7) : e2;
};
var Ee = (e2, t2) => !t2 || Ne(e2) && "clamp(" === e2.substr(0, 6) ? e2 : "clamp(" + e2 + ")";
var Pe = () => Se && requestAnimationFrame(Pe);
var Me = () => Z = 1;
var Oe = () => Z = 0;
var Ae = (e2) => e2;
var Re = (e2) => Math.round(1e5 * e2) / 1e5 || 0;
var De = () => "undefined" != typeof window;
var Ye = () => X || De() && (X = window.gsap) && X.registerPlugin && X;
var Be = (e2) => !!~H.indexOf(e2);
var Ie = (e2) => ("Height" === e2 ? ge : L["inner" + e2]) || F["client" + e2] || W["client" + e2];
var Xe = (e2) => w(e2, "getBoundingClientRect") || (Be(e2) ? () => (zt.width = L.innerWidth, zt.height = ge, zt) : () => $e(e2));
var ze = (e2, { s: t2, d2: r2, d: i2, a: s2 }) => Math.max(0, (t2 = "scroll" + r2) && (s2 = w(e2, t2)) ? s2() - Xe(e2)()[i2] : Be(e2) ? (F[t2] || W[t2]) - Ie(r2) : e2[t2] - e2["offset" + r2]);
var Le = (e2, t2) => {
  for (let r2 = 0; r2 < te.length; r2 += 3)
    (!t2 || ~t2.indexOf(te[r2 + 1])) && e2(te[r2], te[r2 + 1], te[r2 + 2]);
};
var Ne = (e2) => "string" == typeof e2;
var Fe = (e2) => "function" == typeof e2;
var We = (e2) => "number" == typeof e2;
var He = (e2) => "object" == typeof e2;
var qe = (e2, t2, r2) => e2 && e2.progress(t2 ? 0 : 1) && r2 && e2.pause();
var Ue = (e2, t2) => {
  if (e2.enabled) {
    let r2 = e2._ctx ? e2._ctx.add(() => t2(e2)) : t2(e2);
    r2 && r2.totalTime && (e2.callbackAnimation = r2);
  }
};
var Ve = Math.abs;
var Ge = "padding";
var je = "px";
var Ke = (e2) => L.getComputedStyle(e2);
var Ze = (e2, t2) => {
  for (let r2 in t2)
    r2 in e2 || (e2[r2] = t2[r2]);
  return e2;
};
var $e = (e2, t2) => {
  let r2 = t2 && "matrix(1, 0, 0, 1, 0, 0)" !== Ke(e2)[$] && X.to(e2, { x: 0, y: 0, xPercent: 0, yPercent: 0, rotation: 0, rotationX: 0, rotationY: 0, scale: 1, skewX: 0, skewY: 0 }).progress(1), i2 = e2.getBoundingClientRect();
  return r2 && r2.progress(0).kill(), i2;
};
var Je = (e2, { d2: t2 }) => e2["offset" + t2] || e2["client" + t2] || 0;
var Qe = (e2) => {
  let t2, r2 = [], i2 = e2.labels, s2 = e2.duration();
  for (t2 in i2)
    r2.push(i2[t2] / s2);
  return r2;
};
var et = (e2) => {
  let t2 = X.utils.snap(e2), r2 = Array.isArray(e2) && e2.slice(0).sort((e3, t3) => e3 - t3);
  return r2 ? (e3, i2, s2 = 1e-3) => {
    let o2;
    if (!i2)
      return t2(e3);
    if (i2 > 0) {
      for (e3 -= s2, o2 = 0; o2 < r2.length; o2++)
        if (r2[o2] >= e3)
          return r2[o2];
      return r2[o2 - 1];
    }
    for (o2 = r2.length, e3 += s2; o2--; )
      if (r2[o2] <= e3)
        return r2[o2];
    return r2[0];
  } : (r3, i2, s2 = 1e-3) => {
    let o2 = t2(r3);
    return !i2 || Math.abs(o2 - r3) < s2 || o2 - r3 < 0 == i2 < 0 ? o2 : t2(i2 < 0 ? r3 - e2 : r3 + e2);
  };
};
var tt = (e2, t2, r2, i2) => r2.split(",").forEach((r3) => e2(t2, r3, i2));
var rt = (e2, t2, r2, i2, s2) => e2.addEventListener(t2, r2, { passive: !i2, capture: !!s2 });
var it = (e2, t2, r2, i2) => e2.removeEventListener(t2, r2, !!i2);
var st = (e2, t2, r2) => {
  (r2 = r2 && r2.wheelHandler) && (e2(t2, "wheel", r2), e2(t2, "touchmove", r2));
};
var ot = { startColor: "green", endColor: "red", indent: 0, fontSize: "16px", fontWeight: "normal" };
var at = { toggleActions: "play", anticipatePin: 0 };
var nt = { top: 0, left: 0, center: 0.5, bottom: 1, right: 1 };
var lt = (e2, t2) => {
  if (Ne(e2)) {
    let r2 = e2.indexOf("="), i2 = ~r2 ? +(e2.charAt(r2 - 1) + 1) * parseFloat(e2.substr(r2 + 1)) : 0;
    ~r2 && (e2.indexOf("%") > r2 && (i2 *= t2 / 100), e2 = e2.substr(0, r2 - 1)), e2 = i2 + (e2 in nt ? nt[e2] * t2 : ~e2.indexOf("%") ? parseFloat(e2) * t2 / 100 : parseFloat(e2) || 0);
  }
  return e2;
};
var ct = (e2, t2, r2, i2, { startColor: s2, endColor: o2, fontSize: a2, indent: n2, fontWeight: l2 }, c2, d2, p2) => {
  let h2 = N.createElement("div"), g2 = Be(r2) || "fixed" === w(r2, "pinType"), u2 = -1 !== e2.indexOf("scroller"), f2 = g2 ? W : r2, m2 = -1 !== e2.indexOf("start"), v2 = m2 ? s2 : o2, y2 = "border-color:" + v2 + ";font-size:" + a2 + ";color:" + v2 + ";font-weight:" + l2 + ";pointer-events:none;white-space:nowrap;font-family:sans-serif,Arial;z-index:1000;padding:4px 8px;border-width:0;border-style:solid;";
  return y2 += "position:" + ((u2 || p2) && g2 ? "fixed;" : "absolute;"), (u2 || p2 || !g2) && (y2 += (i2 === P ? "right" : "bottom") + ":" + (c2 + parseFloat(n2)) + "px;"), d2 && (y2 += "box-sizing:border-box;text-align:left;width:" + d2.offsetWidth + "px;"), h2._isStart = m2, h2.setAttribute("class", "gsap-marker-" + e2 + (t2 ? " marker-" + t2 : "")), h2.style.cssText = y2, h2.innerText = t2 || 0 === t2 ? e2 + "-" + t2 : e2, f2.children[0] ? f2.insertBefore(h2, f2.children[0]) : f2.appendChild(h2), h2._offset = h2["offset" + i2.op.d2], dt(h2, 0, i2, m2), h2;
};
var dt = (e2, t2, r2, i2) => {
  let s2 = { display: "block" }, o2 = r2[i2 ? "os2" : "p2"], a2 = r2[i2 ? "p2" : "os2"];
  e2._isFlipped = i2, s2[r2.a + "Percent"] = i2 ? -100 : 0, s2[r2.a] = i2 ? "1px" : 0, s2["border" + o2 + "Width"] = 1, s2["border" + a2 + "Width"] = 0, s2[r2.p] = t2 + "px", X.set(e2, s2);
};
var pt = [];
var ht = {};
var gt = () => _e() - ke > 34 && (ve || (ve = requestAnimationFrame(At)));
var ut = () => {
  (!oe || !oe.isPressed || oe.startX > W.clientWidth) && (v.cache++, oe ? ve || (ve = requestAnimationFrame(At)) : At(), ke || bt("scrollStart"), ke = _e());
};
var ft = () => {
  le = L.innerWidth, ne = L.innerHeight;
};
var mt = () => {
  v.cache++, !K && !se && !N.fullscreenElement && !N.webkitFullscreenElement && (!ae || le !== L.innerWidth || Math.abs(L.innerHeight - ne) > 0.25 * L.innerHeight) && q.restart(true);
};
var vt = {};
var yt = [];
var xt = () => it(Ut, "scrollEnd", xt) || Pt(true);
var bt = (e2) => vt[e2] && vt[e2].map((e3) => e3()) || yt;
var wt = [];
var _t = (e2) => {
  for (let t2 = 0; t2 < wt.length; t2 += 5)
    (!e2 || wt[t2 + 4] && wt[t2 + 4].query === e2) && (wt[t2].style.cssText = wt[t2 + 1], wt[t2].getBBox && wt[t2].setAttribute("transform", wt[t2 + 2] || ""), wt[t2 + 3].uncache = 1);
};
var Tt = (e2, t2) => {
  let r2;
  for (J = 0; J < pt.length; J++)
    r2 = pt[J], !r2 || t2 && r2._ctx !== t2 || (e2 ? r2.kill(1) : r2.revert(true, true));
  ue = true, t2 && _t(t2), t2 || bt("revert");
};
var kt = (e2, t2) => {
  v.cache++, (t2 || !ye) && v.forEach((e3) => Fe(e3) && e3.cacheID++ && (e3.rec = 0)), Ne(e2) && (L.history.scrollRestoration = pe = e2);
};
var St = 0;
var Ct = () => {
  W.appendChild(he), ge = !oe && he.offsetHeight || L.innerHeight, W.removeChild(he);
};
var Et = (e2) => U(".gsap-marker-start, .gsap-marker-end, .gsap-marker-scroller-start, .gsap-marker-scroller-end").forEach((t2) => t2.style.display = e2 ? "none" : "block");
var Pt = (e2, t2) => {
  if (ke && !e2 && !ue)
    return void rt(Ut, "scrollEnd", xt);
  Ct(), ye = Ut.isRefreshing = true, v.forEach((e3) => Fe(e3) && ++e3.cacheID && (e3.rec = e3()));
  let r2 = bt("refreshInit");
  re && Ut.sort(), t2 || Tt(), v.forEach((e3) => {
    Fe(e3) && (e3.smooth && (e3.target.style.scrollBehavior = "auto"), e3(0));
  }), pt.slice(0).forEach((e3) => e3.refresh()), ue = false, pt.forEach((e3) => {
    if (e3._subPinOffset && e3.pin) {
      let t3 = e3.vars.horizontal ? "offsetWidth" : "offsetHeight", r3 = e3.pin[t3];
      e3.revert(true, 1), e3.adjustPinSpacing(e3.pin[t3] - r3), e3.refresh();
    }
  }), fe = 1, Et(true), pt.forEach((e3) => {
    let t3 = ze(e3.scroller, e3._dir), r3 = "max" === e3.vars.end || e3._endClamp && e3.end > t3, i2 = e3._startClamp && e3.start >= t3;
    (r3 || i2) && e3.setPositions(i2 ? t3 - 1 : e3.start, r3 ? Math.max(i2 ? t3 : e3.start + 1, t3) : e3.end, true);
  }), Et(false), fe = 0, r2.forEach((e3) => e3 && e3.render && e3.render(-1)), v.forEach((e3) => {
    Fe(e3) && (e3.smooth && requestAnimationFrame(() => e3.target.style.scrollBehavior = "smooth"), e3.rec && e3(e3.rec));
  }), kt(pe, 1), q.pause(), St++, ye = 2, At(2), pt.forEach((e3) => Fe(e3.vars.onRefresh) && e3.vars.onRefresh(e3)), ye = Ut.isRefreshing = false, bt("refresh");
};
var Mt = 0;
var Ot = 1;
var At = (e2) => {
  if (2 === e2 || !ye && !ue) {
    Ut.isUpdating = true, be && be.update(0);
    let e3 = pt.length, t2 = _e(), r2 = t2 - Te >= 50, i2 = e3 && pt[0].scroll();
    if (Ot = Mt > i2 ? -1 : 1, ye || (Mt = i2), r2 && (ke && !Z && t2 - ke > 200 && (ke = 0, bt("scrollEnd")), G = Te, Te = t2), Ot < 0) {
      for (J = e3; J-- > 0; )
        pt[J] && pt[J].update(0, r2);
      Ot = 1;
    } else
      for (J = 0; J < e3; J++)
        pt[J] && pt[J].update(0, r2);
    Ut.isUpdating = false;
  }
  ve = 0;
};
var Rt = ["left", "top", "bottom", "right", "marginBottom", "marginRight", "marginTop", "marginLeft", "display", "flexShrink", "float", "zIndex", "gridColumnStart", "gridColumnEnd", "gridRowStart", "gridRowEnd", "gridArea", "justifySelf", "alignSelf", "placeSelf", "order"];
var Dt = Rt.concat(["width", "height", "boxSizing", "maxWidth", "maxHeight", "position", "margin", Ge, "paddingTop", "paddingRight", "paddingBottom", "paddingLeft"]);
var Yt = (e2, t2, r2, i2) => {
  if (!e2._gsap.swappedIn) {
    let s2, o2 = Rt.length, a2 = t2.style, n2 = e2.style;
    for (; o2--; )
      s2 = Rt[o2], a2[s2] = r2[s2];
    a2.position = "absolute" === r2.position ? "absolute" : "relative", "inline" === r2.display && (a2.display = "inline-block"), n2.bottom = n2.right = "auto", a2.flexBasis = r2.flexBasis || "auto", a2.overflow = "visible", a2.boxSizing = "border-box", a2.width = Je(e2, E) + je, a2.height = Je(e2, P) + je, a2.padding = n2.margin = n2.top = n2.left = "0", It(i2), n2.width = n2.maxWidth = r2.width, n2.height = n2.maxHeight = r2.height, n2.padding = r2.padding, e2.parentNode !== t2 && (e2.parentNode.insertBefore(t2, e2), t2.appendChild(e2)), e2._gsap.swappedIn = true;
  }
};
var Bt = /([A-Z])/g;
var It = (e2) => {
  if (e2) {
    let t2, r2, i2 = e2.t.style, s2 = e2.length, o2 = 0;
    for ((e2.t._gsap || X.core.getCache(e2.t)).uncache = 1; o2 < s2; o2 += 2)
      r2 = e2[o2 + 1], t2 = e2[o2], r2 ? i2[t2] = r2 : i2[t2] && i2.removeProperty(t2.replace(Bt, "-$1").toLowerCase());
  }
};
var Xt = (e2) => {
  let t2 = Dt.length, r2 = e2.style, i2 = [], s2 = 0;
  for (; s2 < t2; s2++)
    i2.push(Dt[s2], r2[Dt[s2]]);
  return i2.t = e2, i2;
};
var zt = { left: 0, top: 0 };
var Lt = (e2, t2, r2, i2, s2, o2, a2, n2, l2, c2, d2, p2, h2, g2) => {
  Fe(e2) && (e2 = e2(n2)), Ne(e2) && "max" === e2.substr(0, 3) && (e2 = p2 + ("=" === e2.charAt(4) ? lt("0" + e2.substr(3), r2) : 0));
  let u2, f2, m2, v2 = h2 ? h2.time() : 0;
  if (h2 && h2.seek(0), isNaN(e2) || (e2 = +e2), We(e2))
    h2 && (e2 = X.utils.mapRange(h2.scrollTrigger.start, h2.scrollTrigger.end, 0, p2, e2)), a2 && dt(a2, r2, i2, true);
  else {
    Fe(t2) && (t2 = t2(n2));
    let o3, d3, p3, h3, g3 = (e2 || "0").split(" ");
    m2 = M(t2, n2) || W, o3 = $e(m2) || {}, o3 && (o3.left || o3.top) || "none" !== Ke(m2).display || (h3 = m2.style.display, m2.style.display = "block", o3 = $e(m2), h3 ? m2.style.display = h3 : m2.style.removeProperty("display")), d3 = lt(g3[0], o3[i2.d]), p3 = lt(g3[1] || "0", r2), e2 = o3[i2.p] - l2[i2.p] - c2 + d3 + s2 - p3, a2 && dt(a2, p3, i2, r2 - p3 < 20 || a2._isStart && p3 > 20), r2 -= r2 - p3;
  }
  if (g2 && (n2[g2] = e2 || -1e-3, e2 < 0 && (e2 = 0)), o2) {
    let t3 = e2 + r2, s3 = o2._isStart;
    u2 = "scroll" + i2.d2, dt(o2, t3, i2, s3 && t3 > 20 || !s3 && (d2 ? Math.max(W[u2], F[u2]) : o2.parentNode[u2]) <= t3 + 1), d2 && (l2 = $e(a2), d2 && (o2.style[i2.op.p] = l2[i2.op.p] - i2.op.m - o2._offset + je));
  }
  return h2 && m2 && (u2 = $e(m2), h2.seek(p2), f2 = $e(m2), h2._caScrollDist = u2[i2.p] - f2[i2.p], e2 = e2 / h2._caScrollDist * p2), h2 && h2.seek(v2), h2 ? e2 : Math.round(e2);
};
var Nt = /(webkit|moz|length|cssText|inset)/i;
var Ft = (e2, t2, r2, i2) => {
  if (e2.parentNode !== t2) {
    let s2, o2, a2 = e2.style;
    if (t2 === W) {
      for (s2 in e2._stOrig = a2.cssText, o2 = Ke(e2), o2)
        +s2 || Nt.test(s2) || !o2[s2] || "string" != typeof a2[s2] || "0" === s2 || (a2[s2] = o2[s2]);
      a2.top = r2, a2.left = i2;
    } else
      a2.cssText = e2._stOrig;
    X.core.getCache(e2).uncache = 1, t2.appendChild(e2);
  }
};
var Wt = (e2, t2, r2) => {
  let i2 = t2, s2 = i2;
  return (t3) => {
    let o2 = Math.round(e2());
    return o2 !== i2 && o2 !== s2 && Math.abs(o2 - i2) > 3 && Math.abs(o2 - s2) > 3 && (t3 = o2, r2 && r2()), s2 = i2, i2 = t3, t3;
  };
};
var Ht = (e2, t2, r2) => {
  let i2 = {};
  i2[t2.p] = "+=" + r2, X.set(e2, i2);
};
var qt = (e2, t2) => {
  let r2 = O(e2, t2), i2 = "_scroll" + t2.p2, s2 = (t3, o2, a2, n2, l2) => {
    let c2 = s2.tween, d2 = o2.onComplete, p2 = {};
    a2 = a2 || r2();
    let h2 = Wt(r2, a2, () => {
      c2.kill(), s2.tween = 0;
    });
    return l2 = n2 && l2 || 0, n2 = n2 || t3 - a2, c2 && c2.kill(), o2[i2] = t3, o2.inherit = false, o2.modifiers = p2, p2[i2] = () => h2(a2 + n2 * c2.ratio + l2 * c2.ratio * c2.ratio), o2.onUpdate = () => {
      v.cache++, s2.tween && At();
    }, o2.onComplete = () => {
      s2.tween = 0, d2 && d2.call(c2);
    }, c2 = s2.tween = X.to(e2, o2), c2;
  };
  return e2[i2] = r2, r2.wheelHandler = () => s2.tween && s2.tween.kill() && (s2.tween = 0), rt(e2, "wheel", r2.wheelHandler), Ut.isTouch && rt(e2, "touchmove", r2.wheelHandler), s2;
};
var Ut = class _Ut {
  constructor(e2, t2) {
    z || _Ut.register(X) || console.warn("Please gsap.registerPlugin(ScrollTrigger)"), de(this), this.init(e2, t2);
  }
  init(e2, t2) {
    if (this.progress = this.start = 0, this.vars && this.kill(true, true), !Se)
      return void (this.update = this.refresh = this.kill = Ae);
    e2 = Ze(Ne(e2) || We(e2) || e2.nodeType ? { trigger: e2 } : e2, at);
    let r2, i2, s2, o2, a2, n2, l2, c2, d2, p2, h2, g2, u2, f2, m2, x2, b2, _2, T2, k2, S2, C2, A2, R2, D2, Y2, B2, I2, z2, H2, q2, j2, $2, Q2, ee2, te2, se2, oe2, ae2, { onUpdate: ne2, toggleClass: le2, id: ce2, onToggle: de2, onRefresh: pe2, scrub: he2, trigger: ge2, pin: ue2, pinSpacing: ve2, invalidateOnRefresh: Te2, anticipatePin: Pe2, onScrubComplete: Me2, onSnapComplete: Oe2, once: De2, snap: Ye2, pinReparent: Le2, pinSpacer: tt2, containerAnimation: st2, fastScrollEnd: nt2, preventOverlaps: dt2 } = e2, gt2 = e2.horizontal || e2.containerAnimation && false !== e2.horizontal ? E : P, ft2 = !he2 && 0 !== he2, vt2 = M(e2.scroller || L), yt2 = X.core.getCache(vt2), bt2 = Be(vt2), wt2 = "fixed" === ("pinType" in e2 ? e2.pinType : w(vt2, "pinType") || bt2 && "fixed"), _t2 = [e2.onEnter, e2.onLeave, e2.onEnterBack, e2.onLeaveBack], Tt2 = ft2 && e2.toggleActions.split(" "), kt2 = "markers" in e2 ? e2.markers : at.markers, Ct2 = bt2 ? 0 : parseFloat(Ke(vt2)["border" + gt2.p2 + "Width"]) || 0, Et2 = this, Mt2 = e2.onRefreshInit && (() => e2.onRefreshInit(Et2)), At2 = ((e3, t3, { d: r3, d2: i3, a: s3 }) => (s3 = w(e3, "getBoundingClientRect")) ? () => s3()[r3] : () => (t3 ? Ie(i3) : e3["client" + i3]) || 0)(vt2, bt2, gt2), Rt2 = ((e3, t3) => !t3 || ~y.indexOf(e3) ? Xe(e3) : () => zt)(vt2, bt2), Dt2 = 0, Bt2 = 0, Nt2 = 0, Wt2 = O(vt2, gt2);
    var Vt2;
    if (Et2._startClamp = Et2._endClamp = false, Et2._dir = gt2, Pe2 *= 45, Et2.scroller = vt2, Et2.scroll = st2 ? st2.time.bind(st2) : Wt2, o2 = Wt2(), Et2.vars = e2, t2 = t2 || e2.animation, "refreshPriority" in e2 && (re = 1, -9999 === e2.refreshPriority && (be = Et2)), yt2.tweenScroll = yt2.tweenScroll || { top: qt(vt2, P), left: qt(vt2, E) }, Et2.tweenTo = r2 = yt2.tweenScroll[gt2.p], Et2.scrubDuration = (e3) => {
      $2 = We(e3) && e3, $2 ? j2 ? j2.duration(e3) : j2 = X.to(t2, { ease: "expo", totalProgress: "+=0", inherit: false, duration: $2, paused: true, onComplete: () => Me2 && Me2(Et2) }) : (j2 && j2.progress(1).kill(), j2 = 0);
    }, t2 && (t2.vars.lazy = false, t2._initted && !Et2.isReverted || false !== t2.vars.immediateRender && false !== e2.immediateRender && t2.duration() && t2.render(0, true, true), Et2.animation = t2.pause(), t2.scrollTrigger = Et2, Et2.scrubDuration(he2), H2 = 0, ce2 || (ce2 = t2.vars.id)), Ye2 && (He(Ye2) && !Ye2.push || (Ye2 = { snapTo: Ye2 }), "scrollBehavior" in W.style && X.set(bt2 ? [W, F] : vt2, { scrollBehavior: "auto" }), v.forEach((e3) => Fe(e3) && e3.target === (bt2 ? N.scrollingElement || F : vt2) && (e3.smooth = false)), s2 = Fe(Ye2.snapTo) ? Ye2.snapTo : "labels" === Ye2.snapTo ? /* @__PURE__ */ ((e3) => (t3) => X.utils.snap(Qe(e3), t3))(t2) : "labelsDirectional" === Ye2.snapTo ? (Vt2 = t2, (e3, t3) => et(Qe(Vt2))(e3, t3.direction)) : false !== Ye2.directional ? (e3, t3) => et(Ye2.snapTo)(e3, _e() - Bt2 < 500 ? 0 : t3.direction) : X.utils.snap(Ye2.snapTo), Q2 = Ye2.duration || { min: 0.1, max: 2 }, Q2 = He(Q2) ? V(Q2.min, Q2.max) : V(Q2, Q2), ee2 = X.delayedCall(Ye2.delay || $2 / 2 || 0.1, () => {
      let e3 = Wt2(), i3 = _e() - Bt2 < 500, o3 = r2.tween;
      if (!(i3 || Math.abs(Et2.getVelocity()) < 10) || o3 || Z || Dt2 === e3)
        Et2.isActive && Dt2 !== e3 && ee2.restart(true);
      else {
        let a3, c3, d3 = (e3 - n2) / f2, p3 = t2 && !ft2 ? t2.totalProgress() : d3, h3 = i3 ? 0 : (p3 - q2) / (_e() - G) * 1e3 || 0, g3 = X.utils.clamp(-d3, 1 - d3, Ve(h3 / 2) * h3 / 0.185), u3 = d3 + (false === Ye2.inertia ? 0 : g3), { onStart: m3, onInterrupt: v2, onComplete: y2 } = Ye2;
        if (a3 = s2(u3, Et2), We(a3) || (a3 = u3), c3 = Math.round(n2 + a3 * f2), e3 <= l2 && e3 >= n2 && c3 !== e3) {
          if (o3 && !o3._initted && o3.data <= Ve(c3 - e3))
            return;
          false === Ye2.inertia && (g3 = a3 - d3), r2(c3, { duration: Q2(Ve(0.185 * Math.max(Ve(u3 - p3), Ve(a3 - p3)) / h3 / 0.05 || 0)), ease: Ye2.ease || "power3", data: Ve(c3 - e3), onInterrupt: () => ee2.restart(true) && v2 && v2(Et2), onComplete() {
            Et2.update(), Dt2 = Wt2(), t2 && (j2 ? j2.resetTo("totalProgress", a3, t2._tTime / t2._tDur) : t2.progress(a3)), H2 = q2 = t2 && !ft2 ? t2.totalProgress() : Et2.progress, Oe2 && Oe2(Et2), y2 && y2(Et2);
          } }, e3, g3 * f2, c3 - e3 - g3 * f2), m3 && m3(Et2, r2.tween);
        }
      }
    }).pause()), ce2 && (ht[ce2] = Et2), ge2 = Et2.trigger = M(ge2 || true !== ue2 && ue2), ae2 = ge2 && ge2._gsap && ge2._gsap.stRevert, ae2 && (ae2 = ae2(Et2)), ue2 = true === ue2 ? ge2 : M(ue2), Ne(le2) && (le2 = { targets: ge2, className: le2 }), ue2 && (false === ve2 || "margin" === ve2 || (ve2 = !(!ve2 && ue2.parentNode && ue2.parentNode.style && "flex" === Ke(ue2.parentNode).display) && Ge), Et2.pin = ue2, i2 = X.core.getCache(ue2), i2.spacer ? m2 = i2.pinState : (tt2 && (tt2 = M(tt2), tt2 && !tt2.nodeType && (tt2 = tt2.current || tt2.nativeElement), i2.spacerIsNative = !!tt2, tt2 && (i2.spacerState = Xt(tt2))), i2.spacer = _2 = tt2 || N.createElement("div"), _2.classList.add("pin-spacer"), ce2 && _2.classList.add("pin-spacer-" + ce2), i2.pinState = m2 = Xt(ue2)), false !== e2.force3D && X.set(ue2, { force3D: true }), Et2.spacer = _2 = i2.spacer, z2 = Ke(ue2), R2 = z2[ve2 + gt2.os2], k2 = X.getProperty(ue2), S2 = X.quickSetter(ue2, gt2.a, je), Yt(ue2, _2, z2), b2 = Xt(ue2)), kt2) {
      g2 = He(kt2) ? Ze(kt2, ot) : ot, p2 = ct("scroller-start", ce2, vt2, gt2, g2, 0), h2 = ct("scroller-end", ce2, vt2, gt2, g2, 0, p2), T2 = p2["offset" + gt2.op.d2];
      let e3 = M(w(vt2, "content") || vt2);
      c2 = this.markerStart = ct("start", ce2, e3, gt2, g2, T2, 0, st2), d2 = this.markerEnd = ct("end", ce2, e3, gt2, g2, T2, 0, st2), st2 && (oe2 = X.quickSetter([c2, d2], gt2.a, je)), wt2 || y.length && true === w(vt2, "fixedMarkers") || (((e4) => {
        let t3 = Ke(e4).position;
        e4.style.position = "absolute" === t3 || "fixed" === t3 ? t3 : "relative";
      })(bt2 ? W : vt2), X.set([p2, h2], { force3D: true }), Y2 = X.quickSetter(p2, gt2.a, je), I2 = X.quickSetter(h2, gt2.a, je));
    }
    if (st2) {
      let e3 = st2.vars.onUpdate, t3 = st2.vars.onUpdateParams;
      st2.eventCallback("onUpdate", () => {
        Et2.update(0, 0, 1), e3 && e3.apply(st2, t3 || []);
      });
    }
    if (Et2.previous = () => pt[pt.indexOf(Et2) - 1], Et2.next = () => pt[pt.indexOf(Et2) + 1], Et2.revert = (e3, r3) => {
      if (!r3)
        return Et2.kill(true);
      let i3 = false !== e3 || !Et2.enabled, s3 = K;
      i3 !== Et2.isReverted && (i3 && (te2 = Math.max(Wt2(), Et2.scroll.rec || 0), Nt2 = Et2.progress, se2 = t2 && t2.progress()), c2 && [c2, d2, p2, h2].forEach((e4) => e4.style.display = i3 ? "none" : "block"), i3 && (K = Et2, Et2.update(i3)), !ue2 || Le2 && Et2.isActive || (i3 ? ((e4, t3, r4) => {
        It(r4);
        let i4 = e4._gsap;
        if (i4.spacerIsNative)
          It(i4.spacerState);
        else if (e4._gsap.swappedIn) {
          let r5 = t3.parentNode;
          r5 && (r5.insertBefore(e4, t3), r5.removeChild(t3));
        }
        e4._gsap.swappedIn = false;
      })(ue2, _2, m2) : Yt(ue2, _2, Ke(ue2), D2)), i3 || Et2.update(i3), K = s3, Et2.isReverted = i3);
    }, Et2.refresh = (i3, s3, g3, v2) => {
      if ((K || !Et2.enabled) && !s3)
        return;
      if (ue2 && i3 && ke)
        return void rt(_Ut, "scrollEnd", xt);
      !ye && Mt2 && Mt2(Et2), K = Et2, r2.tween && !g3 && (r2.tween.kill(), r2.tween = 0), j2 && j2.pause(), Te2 && t2 && t2.revert({ kill: false }).invalidate(), Et2.isReverted || Et2.revert(true, true), Et2._subPinOffset = false;
      let y2, w2, T3, S3, R3, Y3, I3, z3, L2, H3, q3, U2, V2, G2 = At2(), Z2 = Rt2(), $3 = st2 ? st2.duration() : ze(vt2, gt2), J2 = f2 <= 0.01, Q3 = 0, re2 = v2 || 0, oe3 = He(g3) ? g3.end : e2.end, ae3 = e2.endTrigger || ge2, ne3 = He(g3) ? g3.start : e2.start || (0 !== e2.start && ge2 ? ue2 ? "0 0" : "0 100%" : 0), le3 = Et2.pinnedContainer = e2.pinnedContainer && M(e2.pinnedContainer, Et2), ce3 = ge2 && Math.max(0, pt.indexOf(Et2)) || 0, de3 = ce3;
      for (kt2 && He(g3) && (U2 = X.getProperty(p2, gt2.p), V2 = X.getProperty(h2, gt2.p)); de3--; )
        Y3 = pt[de3], Y3.end || Y3.refresh(0, 1) || (K = Et2), I3 = Y3.pin, !I3 || I3 !== ge2 && I3 !== ue2 && I3 !== le3 || Y3.isReverted || (H3 || (H3 = []), H3.unshift(Y3), Y3.revert(true, true)), Y3 !== pt[de3] && (ce3--, de3--);
      for (Fe(ne3) && (ne3 = ne3(Et2)), ne3 = Ce(ne3, "start", Et2), n2 = Lt(ne3, ge2, G2, gt2, Wt2(), c2, p2, Et2, Z2, Ct2, wt2, $3, st2, Et2._startClamp && "_startClamp") || (ue2 ? -1e-3 : 0), Fe(oe3) && (oe3 = oe3(Et2)), Ne(oe3) && !oe3.indexOf("+=") && (~oe3.indexOf(" ") ? oe3 = (Ne(ne3) ? ne3.split(" ")[0] : "") + oe3 : (Q3 = lt(oe3.substr(2), G2), oe3 = Ne(ne3) ? ne3 : (st2 ? X.utils.mapRange(0, st2.duration(), st2.scrollTrigger.start, st2.scrollTrigger.end, n2) : n2) + Q3, ae3 = ge2)), oe3 = Ce(oe3, "end", Et2), l2 = Math.max(n2, Lt(oe3 || (ae3 ? "100% 0" : $3), ae3, G2, gt2, Wt2() + Q3, d2, h2, Et2, Z2, Ct2, wt2, $3, st2, Et2._endClamp && "_endClamp")) || -1e-3, Q3 = 0, de3 = ce3; de3--; )
        Y3 = pt[de3], I3 = Y3.pin, I3 && Y3.start - Y3._pinPush <= n2 && !st2 && Y3.end > 0 && (y2 = Y3.end - (Et2._startClamp ? Math.max(0, Y3.start) : Y3.start), (I3 === ge2 && Y3.start - Y3._pinPush < n2 || I3 === le3) && isNaN(ne3) && (Q3 += y2 * (1 - Y3.progress)), I3 === ue2 && (re2 += y2));
      if (n2 += Q3, l2 += Q3, Et2._startClamp && (Et2._startClamp += Q3), Et2._endClamp && !ye && (Et2._endClamp = l2 || -1e-3, l2 = Math.min(l2, ze(vt2, gt2))), f2 = l2 - n2 || (n2 -= 0.01) && 1e-3, J2 && (Nt2 = X.utils.clamp(0, 1, X.utils.normalize(n2, l2, te2))), Et2._pinPush = re2, c2 && Q3 && (y2 = {}, y2[gt2.a] = "+=" + Q3, le3 && (y2[gt2.p] = "-=" + Wt2()), X.set([c2, d2], y2)), !ue2 || fe && Et2.end >= ze(vt2, gt2)) {
        if (ge2 && Wt2() && !st2)
          for (w2 = ge2.parentNode; w2 && w2 !== W; )
            w2._pinOffset && (n2 -= w2._pinOffset, l2 -= w2._pinOffset), w2 = w2.parentNode;
      } else
        y2 = Ke(ue2), S3 = gt2 === P, T3 = Wt2(), C2 = parseFloat(k2(gt2.a)) + re2, !$3 && l2 > 1 && (q3 = (bt2 ? N.scrollingElement || F : vt2).style, q3 = { style: q3, value: q3["overflow" + gt2.a.toUpperCase()] }, bt2 && "scroll" !== Ke(W)["overflow" + gt2.a.toUpperCase()] && (q3.style["overflow" + gt2.a.toUpperCase()] = "scroll")), Yt(ue2, _2, y2), b2 = Xt(ue2), w2 = $e(ue2, true), z3 = wt2 && O(vt2, S3 ? E : P)(), ve2 ? (D2 = [ve2 + gt2.os2, f2 + re2 + je], D2.t = _2, de3 = ve2 === Ge ? Je(ue2, gt2) + f2 + re2 : 0, de3 && (D2.push(gt2.d, de3 + je), "auto" !== _2.style.flexBasis && (_2.style.flexBasis = de3 + je)), It(D2), le3 && pt.forEach((e3) => {
          e3.pin === le3 && false !== e3.vars.pinSpacing && (e3._subPinOffset = true);
        }), wt2 && Wt2(te2)) : (de3 = Je(ue2, gt2), de3 && "auto" !== _2.style.flexBasis && (_2.style.flexBasis = de3 + je)), wt2 && (R3 = { top: w2.top + (S3 ? T3 - n2 : z3) + je, left: w2.left + (S3 ? z3 : T3 - n2) + je, boxSizing: "border-box", position: "fixed" }, R3.width = R3.maxWidth = Math.ceil(w2.width) + je, R3.height = R3.maxHeight = Math.ceil(w2.height) + je, R3.margin = R3.marginTop = R3.marginRight = R3.marginBottom = R3.marginLeft = "0", R3.padding = y2.padding, R3.paddingTop = y2.paddingTop, R3.paddingRight = y2.paddingRight, R3.paddingBottom = y2.paddingBottom, R3.paddingLeft = y2.paddingLeft, x2 = ((e3, t3, r3) => {
          let i4, s4 = [], o3 = e3.length, a3 = r3 ? 8 : 0;
          for (; a3 < o3; a3 += 2)
            i4 = e3[a3], s4.push(i4, i4 in t3 ? t3[i4] : e3[a3 + 1]);
          return s4.t = e3.t, s4;
        })(m2, R3, Le2), ye && Wt2(0)), t2 ? (L2 = t2._initted, ie(1), t2.render(t2.duration(), true, true), A2 = k2(gt2.a) - C2 + f2 + re2, B2 = Math.abs(f2 - A2) > 1, wt2 && B2 && x2.splice(x2.length - 2, 2), t2.render(0, true, true), L2 || t2.invalidate(true), t2.parent || t2.totalTime(t2.totalTime()), ie(0)) : A2 = f2, q3 && (q3.value ? q3.style["overflow" + gt2.a.toUpperCase()] = q3.value : q3.style.removeProperty("overflow-" + gt2.a));
      H3 && H3.forEach((e3) => e3.revert(false, true)), Et2.start = n2, Et2.end = l2, o2 = a2 = ye ? te2 : Wt2(), st2 || ye || (o2 < te2 && Wt2(te2), Et2.scroll.rec = 0), Et2.revert(false, true), Bt2 = _e(), ee2 && (Dt2 = -1, ee2.restart(true)), K = 0, t2 && ft2 && (t2._initted || se2) && t2.progress() !== se2 && t2.progress(se2 || 0, true).render(t2.time(), true, true), (J2 || Nt2 !== Et2.progress || st2 || Te2) && (t2 && !ft2 && t2.totalProgress(st2 && n2 < -1e-3 && !Nt2 ? X.utils.normalize(n2, l2, 0) : Nt2, true), Et2.progress = J2 || (o2 - n2) / f2 === Nt2 ? 0 : Nt2), ue2 && ve2 && (_2._pinOffset = Math.round(Et2.progress * A2)), j2 && j2.invalidate(), isNaN(U2) || (U2 -= X.getProperty(p2, gt2.p), V2 -= X.getProperty(h2, gt2.p), Ht(p2, gt2, U2), Ht(c2, gt2, U2 - (v2 || 0)), Ht(h2, gt2, V2), Ht(d2, gt2, V2 - (v2 || 0))), J2 && !ye && Et2.update(), !pe2 || ye || u2 || (u2 = true, pe2(Et2), u2 = false);
    }, Et2.getVelocity = () => (Wt2() - a2) / (_e() - G) * 1e3 || 0, Et2.endAnimation = () => {
      qe(Et2.callbackAnimation), t2 && (j2 ? j2.progress(1) : t2.paused() ? ft2 || qe(t2, Et2.direction < 0, 1) : qe(t2, t2.reversed()));
    }, Et2.labelToScroll = (e3) => t2 && t2.labels && (n2 || Et2.refresh() || n2) + t2.labels[e3] / t2.duration() * f2 || 0, Et2.getTrailing = (e3) => {
      let t3 = pt.indexOf(Et2), r3 = Et2.direction > 0 ? pt.slice(0, t3).reverse() : pt.slice(t3 + 1);
      return (Ne(e3) ? r3.filter((t4) => t4.vars.preventOverlaps === e3) : r3).filter((e4) => Et2.direction > 0 ? e4.end <= n2 : e4.start >= l2);
    }, Et2.update = (e3, i3, s3) => {
      if (st2 && !s3 && !e3)
        return;
      let c3, d3, h3, g3, u3, m3, v2, y2, w2 = true === ye ? te2 : Et2.scroll(), T3 = e3 ? 0 : (w2 - n2) / f2, k3 = T3 < 0 ? 0 : T3 > 1 ? 1 : T3 || 0, E2 = Et2.progress;
      if (i3 && (a2 = o2, o2 = st2 ? Wt2() : w2, Ye2 && (q2 = H2, H2 = t2 && !ft2 ? t2.totalProgress() : k3)), Pe2 && ue2 && !K && !we && ke && (!k3 && n2 < w2 + (w2 - a2) / (_e() - G) * Pe2 ? k3 = 1e-4 : 1 === k3 && l2 > w2 + (w2 - a2) / (_e() - G) * Pe2 && (k3 = 0.9999)), k3 !== E2 && Et2.enabled) {
        if (c3 = Et2.isActive = !!k3 && k3 < 1, d3 = !!E2 && E2 < 1, m3 = c3 !== d3, u3 = m3 || !!k3 != !!E2, Et2.direction = k3 > E2 ? 1 : -1, Et2.progress = k3, u3 && !K && (h3 = k3 && !E2 ? 0 : 1 === k3 ? 1 : 1 === E2 ? 2 : 3, ft2 && (g3 = !m3 && "none" !== Tt2[h3 + 1] && Tt2[h3 + 1] || Tt2[h3], y2 = t2 && ("complete" === g3 || "reset" === g3 || g3 in t2))), dt2 && (m3 || y2) && (y2 || he2 || !t2) && (Fe(dt2) ? dt2(Et2) : Et2.getTrailing(dt2).forEach((e4) => e4.endAnimation())), ft2 || (!j2 || K || we ? t2 && t2.totalProgress(k3, !(!K || !Bt2 && !e3)) : (j2._dp._time - j2._start !== j2._time && j2.render(j2._dp._time - j2._start), j2.resetTo ? j2.resetTo("totalProgress", k3, t2._tTime / t2._tDur) : (j2.vars.totalProgress = k3, j2.invalidate().restart()))), ue2)
          if (e3 && ve2 && (_2.style[ve2 + gt2.os2] = R2), wt2) {
            if (u3) {
              if (v2 = !e3 && k3 > E2 && l2 + 1 > w2 && w2 + 1 >= ze(vt2, gt2), Le2)
                if (e3 || !c3 && !v2)
                  Ft(ue2, _2);
                else {
                  let e4 = $e(ue2, true), t3 = w2 - n2;
                  Ft(ue2, W, e4.top + (gt2 === P ? t3 : 0) + je, e4.left + (gt2 === P ? 0 : t3) + je);
                }
              It(c3 || v2 ? x2 : b2), B2 && k3 < 1 && c3 || S2(C2 + (1 !== k3 || v2 ? 0 : A2));
            }
          } else
            S2(Re(C2 + A2 * k3));
        Ye2 && !r2.tween && !K && !we && ee2.restart(true), le2 && (m3 || De2 && k3 && (k3 < 1 || !me)) && U(le2.targets).forEach((e4) => e4.classList[c3 || De2 ? "add" : "remove"](le2.className)), ne2 && !ft2 && !e3 && ne2(Et2), u3 && !K ? (ft2 && (y2 && ("complete" === g3 ? t2.pause().totalProgress(1) : "reset" === g3 ? t2.restart(true).pause() : "restart" === g3 ? t2.restart(true) : t2[g3]()), ne2 && ne2(Et2)), !m3 && me || (de2 && m3 && Ue(Et2, de2), _t2[h3] && Ue(Et2, _t2[h3]), De2 && (1 === k3 ? Et2.kill(false, 1) : _t2[h3] = 0), m3 || (h3 = 1 === k3 ? 1 : 3, _t2[h3] && Ue(Et2, _t2[h3]))), nt2 && !c3 && Math.abs(Et2.getVelocity()) > (We(nt2) ? nt2 : 2500) && (qe(Et2.callbackAnimation), j2 ? j2.progress(1) : qe(t2, "reverse" === g3 ? 1 : !k3, 1))) : ft2 && ne2 && !K && ne2(Et2);
      }
      if (I2) {
        let e4 = st2 ? w2 / st2.duration() * (st2._caScrollDist || 0) : w2;
        Y2(e4 + (p2._isFlipped ? 1 : 0)), I2(e4);
      }
      oe2 && oe2(-w2 / st2.duration() * (st2._caScrollDist || 0));
    }, Et2.enable = (e3, t3) => {
      Et2.enabled || (Et2.enabled = true, rt(vt2, "resize", mt), bt2 || rt(vt2, "scroll", ut), Mt2 && rt(_Ut, "refreshInit", Mt2), false !== e3 && (Et2.progress = Nt2 = 0, o2 = a2 = Dt2 = Wt2()), false !== t3 && Et2.refresh());
    }, Et2.getTween = (e3) => e3 && r2 ? r2.tween : j2, Et2.setPositions = (e3, t3, r3, i3) => {
      if (st2) {
        let r4 = st2.scrollTrigger, i4 = st2.duration(), s3 = r4.end - r4.start;
        e3 = r4.start + s3 * e3 / i4, t3 = r4.start + s3 * t3 / i4;
      }
      Et2.refresh(false, false, { start: Ee(e3, r3 && !!Et2._startClamp), end: Ee(t3, r3 && !!Et2._endClamp) }, i3), Et2.update();
    }, Et2.adjustPinSpacing = (e3) => {
      if (D2 && e3) {
        let t3 = D2.indexOf(gt2.d) + 1;
        D2[t3] = parseFloat(D2[t3]) + e3 + je, D2[1] = parseFloat(D2[1]) + e3 + je, It(D2);
      }
    }, Et2.disable = (e3, t3) => {
      if (Et2.enabled && (false !== e3 && Et2.revert(true, true), Et2.enabled = Et2.isActive = false, t3 || j2 && j2.pause(), te2 = 0, i2 && (i2.uncache = 1), Mt2 && it(_Ut, "refreshInit", Mt2), ee2 && (ee2.pause(), r2.tween && r2.tween.kill() && (r2.tween = 0)), !bt2)) {
        let e4 = pt.length;
        for (; e4--; )
          if (pt[e4].scroller === vt2 && pt[e4] !== Et2)
            return;
        it(vt2, "resize", mt), bt2 || it(vt2, "scroll", ut);
      }
    }, Et2.kill = (r3, s3) => {
      Et2.disable(r3, s3), j2 && !s3 && j2.kill(), ce2 && delete ht[ce2];
      let o3 = pt.indexOf(Et2);
      o3 >= 0 && pt.splice(o3, 1), o3 === J && Ot > 0 && J--, o3 = 0, pt.forEach((e3) => e3.scroller === Et2.scroller && (o3 = 1)), o3 || ye || (Et2.scroll.rec = 0), t2 && (t2.scrollTrigger = null, r3 && t2.revert({ kill: false }), s3 || t2.kill()), c2 && [c2, d2, p2, h2].forEach((e3) => e3.parentNode && e3.parentNode.removeChild(e3)), be === Et2 && (be = 0), ue2 && (i2 && (i2.uncache = 1), o3 = 0, pt.forEach((e3) => e3.pin === ue2 && o3++), o3 || (i2.spacer = 0)), e2.onKill && e2.onKill(Et2);
    }, pt.push(Et2), Et2.enable(false, false), ae2 && ae2(Et2), t2 && t2.add && !f2) {
      let e3 = Et2.update;
      Et2.update = () => {
        Et2.update = e3, n2 || l2 || Et2.refresh();
      }, X.delayedCall(0.01, Et2.update), f2 = 0.01, n2 = l2 = 0;
    } else
      Et2.refresh();
    ue2 && (() => {
      if (xe !== St) {
        let e3 = xe = St;
        requestAnimationFrame(() => e3 === St && Pt(true));
      }
    })();
  }
  static register(e2) {
    return z || (X = e2 || Ye(), De() && window.document && _Ut.enable(), z = Se), z;
  }
  static defaults(e2) {
    if (e2)
      for (let t2 in e2)
        at[t2] = e2[t2];
    return at;
  }
  static disable(e2, t2) {
    Se = 0, pt.forEach((r2) => r2[t2 ? "kill" : "disable"](e2)), it(L, "wheel", ut), it(N, "scroll", ut), clearInterval(j), it(N, "touchcancel", Ae), it(W, "touchstart", Ae), tt(it, N, "pointerdown,touchstart,mousedown", Me), tt(it, N, "pointerup,touchend,mouseup", Oe), q.kill(), Le(it);
    for (let e3 = 0; e3 < v.length; e3 += 3)
      st(it, v[e3], v[e3 + 1]), st(it, v[e3], v[e3 + 2]);
  }
  static enable() {
    if (L = window, N = document, F = N.documentElement, W = N.body, X && (U = X.utils.toArray, V = X.utils.clamp, de = X.core.context || Ae, ie = X.core.suppressOverwrites || Ae, pe = L.history.scrollRestoration || "auto", Mt = L.pageYOffset, X.core.globals("ScrollTrigger", _Ut), W)) {
      Se = 1, he = document.createElement("div"), he.style.height = "100vh", he.style.position = "absolute", Ct(), Pe(), I.register(X), _Ut.isTouch = I.isTouch, ce = I.isTouch && /(iPad|iPhone|iPod|Mac)/g.test(navigator.userAgent), ae = 1 === I.isTouch, rt(L, "wheel", ut), H = [L, N, F, W], X.matchMedia ? (_Ut.matchMedia = (e3) => {
        let t3, r3 = X.matchMedia();
        for (t3 in e3)
          r3.add(t3, e3[t3]);
        return r3;
      }, X.addEventListener("matchMediaInit", () => Tt()), X.addEventListener("matchMediaRevert", () => _t()), X.addEventListener("matchMedia", () => {
        Pt(0, 1), bt("matchMedia");
      }), X.matchMedia("(orientation: portrait)", () => (ft(), ft))) : console.warn("Requires GSAP 3.11.0 or later"), ft(), rt(N, "scroll", ut);
      let e2, t2, r2 = W.style, i2 = r2.borderTopStyle, s2 = X.core.Animation.prototype;
      for (s2.revert || Object.defineProperty(s2, "revert", { value: function() {
        return this.time(-0.01, true);
      } }), r2.borderTopStyle = "solid", e2 = $e(W), P.m = Math.round(e2.top + P.sc()) || 0, E.m = Math.round(e2.left + E.sc()) || 0, i2 ? r2.borderTopStyle = i2 : r2.removeProperty("border-top-style"), j = setInterval(gt, 250), X.delayedCall(0.5, () => we = 0), rt(N, "touchcancel", Ae), rt(W, "touchstart", Ae), tt(rt, N, "pointerdown,touchstart,mousedown", Me), tt(rt, N, "pointerup,touchend,mouseup", Oe), $ = X.utils.checkPrefix("transform"), Dt.push($), z = _e(), q = X.delayedCall(0.2, Pt).pause(), te = [N, "visibilitychange", () => {
        let e3 = L.innerWidth, t3 = L.innerHeight;
        N.hidden ? (Q = e3, ee = t3) : Q === e3 && ee === t3 || mt();
      }, N, "DOMContentLoaded", Pt, L, "load", Pt, L, "resize", mt], Le(rt), pt.forEach((e3) => e3.enable(0, 1)), t2 = 0; t2 < v.length; t2 += 3)
        st(it, v[t2], v[t2 + 1]), st(it, v[t2], v[t2 + 2]);
    }
  }
  static config(e2) {
    "limitCallbacks" in e2 && (me = !!e2.limitCallbacks);
    let t2 = e2.syncInterval;
    t2 && clearInterval(j) || (j = t2) && setInterval(gt, t2), "ignoreMobileResize" in e2 && (ae = 1 === _Ut.isTouch && e2.ignoreMobileResize), "autoRefreshEvents" in e2 && (Le(it) || Le(rt, e2.autoRefreshEvents || "none"), se = -1 === (e2.autoRefreshEvents + "").indexOf("resize"));
  }
  static scrollerProxy(e2, t2) {
    let r2 = M(e2), i2 = v.indexOf(r2), s2 = Be(r2);
    ~i2 && v.splice(i2, s2 ? 6 : 2), t2 && (s2 ? y.unshift(L, t2, W, t2, F, t2) : y.unshift(r2, t2));
  }
  static clearMatchMedia(e2) {
    pt.forEach((t2) => t2._ctx && t2._ctx.query === e2 && t2._ctx.kill(true, true));
  }
  static isInViewport(e2, t2, r2) {
    let i2 = (Ne(e2) ? M(e2) : e2).getBoundingClientRect(), s2 = i2[r2 ? "width" : "height"] * t2 || 0;
    return r2 ? i2.right - s2 > 0 && i2.left + s2 < L.innerWidth : i2.bottom - s2 > 0 && i2.top + s2 < L.innerHeight;
  }
  static positionInViewport(e2, t2, r2) {
    Ne(e2) && (e2 = M(e2));
    let i2 = e2.getBoundingClientRect(), s2 = i2[r2 ? "width" : "height"], o2 = null == t2 ? s2 / 2 : t2 in nt ? nt[t2] * s2 : ~t2.indexOf("%") ? parseFloat(t2) * s2 / 100 : parseFloat(t2) || 0;
    return r2 ? (i2.left + o2) / L.innerWidth : (i2.top + o2) / L.innerHeight;
  }
  static killAll(e2) {
    if (pt.slice(0).forEach((e3) => "ScrollSmoother" !== e3.vars.id && e3.kill()), true !== e2) {
      let e3 = vt.killAll || [];
      vt = {}, e3.forEach((e4) => e4());
    }
  }
};
Ut.version = "3.12.5", Ut.saveStyles = (e2) => e2 ? U(e2).forEach((e3) => {
  if (e3 && e3.style) {
    let t2 = wt.indexOf(e3);
    t2 >= 0 && wt.splice(t2, 5), wt.push(e3, e3.style.cssText, e3.getBBox && e3.getAttribute("transform"), X.core.getCache(e3), de());
  }
}) : wt, Ut.revert = (e2, t2) => Tt(!e2, t2), Ut.create = (e2, t2) => new Ut(e2, t2), Ut.refresh = (e2) => e2 ? mt() : (z || Ut.register()) && Pt(true), Ut.update = (e2) => ++v.cache && At(true === e2 ? 2 : 0), Ut.clearScrollMemory = kt, Ut.maxScroll = (e2, t2) => ze(e2, t2 ? E : P), Ut.getScrollFunc = (e2, t2) => O(M(e2), t2 ? E : P), Ut.getById = (e2) => ht[e2], Ut.getAll = () => pt.filter((e2) => "ScrollSmoother" !== e2.vars.id), Ut.isScrolling = () => !!ke, Ut.snapDirectional = et, Ut.addEventListener = (e2, t2) => {
  let r2 = vt[e2] || (vt[e2] = []);
  ~r2.indexOf(t2) || r2.push(t2);
}, Ut.removeEventListener = (e2, t2) => {
  let r2 = vt[e2], i2 = r2 && r2.indexOf(t2);
  i2 >= 0 && r2.splice(i2, 1);
}, Ut.batch = (e2, t2) => {
  let r2, i2 = [], s2 = {}, o2 = t2.interval || 0.016, a2 = t2.batchMax || 1e9, n2 = (e3, t3) => {
    let r3 = [], i3 = [], s3 = X.delayedCall(o2, () => {
      t3(r3, i3), r3 = [], i3 = [];
    }).pause();
    return (e4) => {
      r3.length || s3.restart(true), r3.push(e4.trigger), i3.push(e4), a2 <= r3.length && s3.progress(1);
    };
  };
  for (r2 in t2)
    s2[r2] = "on" === r2.substr(0, 2) && Fe(t2[r2]) && "onRefreshInit" !== r2 ? n2(0, t2[r2]) : t2[r2];
  return Fe(a2) && (a2 = a2(), rt(Ut, "refresh", () => a2 = t2.batchMax())), U(e2).forEach((e3) => {
    let t3 = {};
    for (r2 in s2)
      t3[r2] = s2[r2];
    t3.trigger = e3, i2.push(Ut.create(t3));
  }), i2;
};
var Vt;
var Gt = (e2, t2, r2, i2) => (t2 > i2 ? e2(i2) : t2 < 0 && e2(0), r2 > i2 ? (i2 - t2) / (r2 - t2) : r2 < 0 ? t2 / (t2 - r2) : 1);
var jt = (e2, t2) => {
  true === t2 ? e2.style.removeProperty("touch-action") : e2.style.touchAction = true === t2 ? "auto" : t2 ? "pan-" + t2 + (I.isTouch ? " pinch-zoom" : "") : "none", e2 === F && jt(W, t2);
};
var Kt = { auto: 1, scroll: 1 };
var Zt = ({ event: e2, target: t2, axis: r2 }) => {
  let i2, s2 = (e2.changedTouches ? e2.changedTouches[0] : e2).target, o2 = s2._gsap || X.core.getCache(s2), a2 = _e();
  if (!o2._isScrollT || a2 - o2._isScrollT > 2e3) {
    for (; s2 && s2 !== W && (s2.scrollHeight <= s2.clientHeight && s2.scrollWidth <= s2.clientWidth || !Kt[(i2 = Ke(s2)).overflowY] && !Kt[i2.overflowX]); )
      s2 = s2.parentNode;
    o2._isScroll = s2 && s2 !== t2 && !Be(s2) && (Kt[(i2 = Ke(s2)).overflowY] || Kt[i2.overflowX]), o2._isScrollT = a2;
  }
  (o2._isScroll || "x" === r2) && (e2.stopPropagation(), e2._gsapAllow = true);
};
var $t = (e2, t2, r2, i2) => I.create({ target: e2, capture: true, debounce: false, lockAxis: true, type: t2, onWheel: i2 = i2 && Zt, onPress: i2, onDrag: i2, onScroll: i2, onEnable: () => r2 && rt(N, I.eventTypes[0], Qt, false, true), onDisable: () => it(N, I.eventTypes[0], Qt, true) });
var Jt = /(input|label|select|textarea)/i;
var Qt = (e2) => {
  let t2 = Jt.test(e2.target.tagName);
  (t2 || Vt) && (e2._gsapAllow = true, Vt = t2);
};
var er = (e2) => {
  He(e2) || (e2 = {}), e2.preventDefault = e2.isNormalizer = e2.allowClicks = true, e2.type || (e2.type = "wheel,touch"), e2.debounce = !!e2.debounce, e2.id = e2.id || "normalizer";
  let t2, r2, i2, s2, o2, a2, n2, l2, { normalizeScrollX: c2, momentum: d2, allowNestedScroll: p2, onRelease: h2 } = e2, g2 = M(e2.target) || F, u2 = X.core.globals().ScrollSmoother, f2 = u2 && u2.get(), m2 = ce && (e2.content && M(e2.content) || f2 && false !== e2.content && !f2.smooth() && f2.content()), y2 = O(g2, P), x2 = O(g2, E), b2 = 1, w2 = (I.isTouch && L.visualViewport ? L.visualViewport.scale * L.visualViewport.width : L.outerWidth) / L.innerWidth, _2 = 0, T2 = Fe(d2) ? () => d2(t2) : () => d2 || 2.8, k2 = $t(g2, e2.type, true, p2), S2 = () => s2 = false, C2 = Ae, A2 = Ae, R2 = () => {
    r2 = ze(g2, P), A2 = V(ce ? 1 : 0, r2), c2 && (C2 = V(0, ze(g2, E))), i2 = St;
  }, D2 = () => {
    m2._gsap.y = Re(parseFloat(m2._gsap.y) + y2.offset) + "px", m2.style.transform = "matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, " + parseFloat(m2._gsap.y) + ", 0, 1)", y2.offset = y2.cacheID = 0;
  }, Y2 = () => {
    R2(), o2.isActive() && o2.vars.scrollY > r2 && (y2() > r2 ? o2.progress(1) && y2(r2) : o2.resetTo("scrollY", r2));
  };
  return m2 && X.set(m2, { y: "+=0" }), e2.ignoreCheck = (e3) => ce && "touchmove" === e3.type && (() => {
    if (s2) {
      requestAnimationFrame(S2);
      let e4 = Re(t2.deltaY / 2), r3 = A2(y2.v - e4);
      if (m2 && r3 !== y2.v + y2.offset) {
        y2.offset = r3 - y2.v;
        let e5 = Re((parseFloat(m2 && m2._gsap.y) || 0) - y2.offset);
        m2.style.transform = "matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, " + e5 + ", 0, 1)", m2._gsap.y = e5 + "px", y2.cacheID = v.cache, At();
      }
      return true;
    }
    y2.offset && D2(), s2 = true;
  })() || b2 > 1.05 && "touchstart" !== e3.type || t2.isGesturing || e3.touches && e3.touches.length > 1, e2.onPress = () => {
    s2 = false;
    let e3 = b2;
    b2 = Re((L.visualViewport && L.visualViewport.scale || 1) / w2), o2.pause(), e3 !== b2 && jt(g2, b2 > 1.01 || !c2 && "x"), a2 = x2(), n2 = y2(), R2(), i2 = St;
  }, e2.onRelease = e2.onGestureStart = (e3, t3) => {
    if (y2.offset && D2(), t3) {
      v.cache++;
      let t4, i3, s3 = T2();
      c2 && (t4 = x2(), i3 = t4 + 0.05 * s3 * -e3.velocityX / 0.227, s3 *= Gt(x2, t4, i3, ze(g2, E)), o2.vars.scrollX = C2(i3)), t4 = y2(), i3 = t4 + 0.05 * s3 * -e3.velocityY / 0.227, s3 *= Gt(y2, t4, i3, ze(g2, P)), o2.vars.scrollY = A2(i3), o2.invalidate().duration(s3).play(0.01), (ce && o2.vars.scrollY >= r2 || t4 >= r2 - 1) && X.to({}, { onUpdate: Y2, duration: s3 });
    } else
      l2.restart(true);
    h2 && h2(e3);
  }, e2.onWheel = () => {
    o2._ts && o2.pause(), _e() - _2 > 1e3 && (i2 = 0, _2 = _e());
  }, e2.onChange = (e3, t3, r3, s3, o3) => {
    if (St !== i2 && R2(), t3 && c2 && x2(C2(s3[2] === t3 ? a2 + (e3.startX - e3.x) : x2() + t3 - s3[1])), r3) {
      y2.offset && D2();
      let t4 = o3[2] === r3, i3 = t4 ? n2 + e3.startY - e3.y : y2() + r3 - o3[1], s4 = A2(i3);
      t4 && i3 !== s4 && (n2 += s4 - i3), y2(s4);
    }
    (r3 || t3) && At();
  }, e2.onEnable = () => {
    jt(g2, !c2 && "x"), Ut.addEventListener("refresh", Y2), rt(L, "resize", Y2), y2.smooth && (y2.target.style.scrollBehavior = "auto", y2.smooth = x2.smooth = false), k2.enable();
  }, e2.onDisable = () => {
    jt(g2, true), it(L, "resize", Y2), Ut.removeEventListener("refresh", Y2), k2.kill();
  }, e2.lockAxis = false !== e2.lockAxis, t2 = new I(e2), t2.iOS = ce, ce && !y2() && y2(1), ce && X.ticker.add(Ae), l2 = t2._dc, o2 = X.to(t2, { ease: "power4", paused: true, inherit: false, scrollX: c2 ? "+=0.1" : "+=0", scrollY: "+=0.1", modifiers: { scrollY: Wt(y2, y2(), () => o2.pause()) }, onUpdate: At, onComplete: l2.vars.onComplete }), t2;
};
Ut.sort = (e2) => pt.sort(e2 || ((e3, t2) => -1e6 * (e3.vars.refreshPriority || 0) + e3.start - (t2.start + -1e6 * (t2.vars.refreshPriority || 0)))), Ut.observe = (e2) => new I(e2), Ut.normalizeScroll = (e2) => {
  if (void 0 === e2)
    return oe;
  if (true === e2 && oe)
    return oe.enable();
  if (false === e2)
    return oe && oe.kill(), void (oe = e2);
  let t2 = e2 instanceof I ? e2 : er(e2);
  return oe && oe.target === t2.target && oe.kill(), Be(t2.target) && (oe = t2), t2;
}, Ut.core = { _getVelocityProp: A, _inputObserver: $t, _scrollers: v, _proxies: y, bridge: { ss: () => {
  ke || bt("scrollStart"), ke = _e();
}, ref: () => K } }, Ye() && X.registerPlugin(Ut);
var ScrollTrigger_default = Ut;
export {
  Ut as ScrollTrigger,
  ScrollTrigger_default as default
};
/*! Bundled license information:

gsap/SplitText.js:
  (*!
   * SplitText 3.12.5
   * https://gsap.com
   * 
   * @license Copyright 2024, GreenSock. All rights reserved.
   *)
*/
//
