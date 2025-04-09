
var u;
var e;
var t;
var F;
var C;
var i;
var n = /(?:\r|\n|\t\t)/g;
var s = /(?:\s\s+)/g;
var E = String.fromCharCode(160);
var l = (D2)=>{
    u = document,
    e = window,
    F = F || D2 || e.gsap || console.warn("Please gsap.registerPlugin(SplitText)"),
    F && (i = F.utils.toArray,
    C = F.core.context || function() {}
    ,
    t = 1);
}
;
var o = function() {
    return String.fromCharCode.apply(null, arguments);
};


var h = (D2)=>e.getComputedStyle(D2);
var B = (D2)=>"absolute" === D2.position || true === D2.absolute;
var A = (D2,u2)=>{
    let e2, t2 = u2.length;
    for (; --t2 > -1; )
        if (e2 = u2[t2],
        D2.substr(0, e2.length) === e2)
            return e2.length;
}
;
var f = (D2="",u2)=>{
    let e2 = ~D2.indexOf("++")
      , t2 = 1;
    return e2 && (D2 = D2.split("++").join("")),
    ()=>"<" + u2 + " style='position:relative;display:inline-block;'" + (D2 ? " class='" + D2 + (e2 ? t2++ : "") + "'>" : ">");
}
;
var c = (D2,u2,e2)=>{
    let t2 = D2.nodeType;
    if (1 === t2 || 9 === t2 || 11 === t2)
        for (D2 = D2.firstChild; D2; D2 = D2.nextSibling)
            c(D2, u2, e2);
    else
        3 !== t2 && 4 !== t2 || (D2.nodeValue = D2.nodeValue.split(u2).join(e2));
}
;
var g = (D2,u2)=>{
    let e2 = u2.length;
    for (; --e2 > -1; )
        D2.push(u2[e2]);
}
;
var x = (D2,u2,e2)=>{
    let t2;
    for (; D2 && D2 !== u2; ) {
        if (t2 = D2._next || D2.nextSibling,
        t2)
            return t2.textContent.charAt(0) === e2;
        D2 = D2.parentNode || D2._parent;
    }
}
;
var y = (D2)=>{
    let u2, e2, t2 = i(D2.childNodes), F2 = t2.length;
    for (u2 = 0; u2 < F2; u2++)
        e2 = t2[u2],
        e2._isSplit ? y(e2) : u2 && e2.previousSibling && 3 === e2.previousSibling.nodeType ? (e2.previousSibling.nodeValue += 3 === e2.nodeType ? e2.nodeValue : e2.firstChild.nodeValue,
        D2.removeChild(e2)) : 3 !== e2.nodeType && (D2.insertBefore(e2.firstChild, e2),
        D2.removeChild(e2));
}
;
var b = (D2,u2)=>parseFloat(u2[D2]) || 0;
var _ = (D2,e2,t2,F2,C2,i2,n2)=>{
    let s2, E2, l2, o2, r2, d2, a2, p2, A2, f2, _2, w2, S2 = h(D2), m2 = b("paddingLeft", S2), v = -999, T = b("borderBottomWidth", S2) + b("borderTopWidth", S2), N = b("borderLeftWidth", S2) + b("borderRightWidth", S2), L = b("paddingTop", S2) + b("paddingBottom", S2), W = b("paddingLeft", S2) + b("paddingRight", S2), O = b("fontSize", S2) * (e2.lineThreshold || 0.2), H = S2.textAlign, V = [], R = [], j = [], M = e2.wordDelimiter || " ", k = e2.tag ? e2.tag : e2.span ? "span" : "div", P = e2.type || e2.split || "chars,words,lines", z = C2 && ~P.indexOf("lines") ? [] : null, $ = ~P.indexOf("words"), q = ~P.indexOf("chars"), G = B(e2), I = e2.linesClass, J = ~(I || "").indexOf("++"), K = [], Q = "flex" === S2.display, U = D2.style.display;
    for (J && (I = I.split("++").join("")),
    Q && (D2.style.display = "block"),
    E2 = D2.getElementsByTagName("*"),
    l2 = E2.length,
    r2 = [],
    s2 = 0; s2 < l2; s2++)
        r2[s2] = E2[s2];
    if (z || G)
        for (s2 = 0; s2 < l2; s2++)
            o2 = r2[s2],
            d2 = o2.parentNode === D2,
            (d2 || G || q && !$) && (w2 = o2.offsetTop,
            z && d2 && Math.abs(w2 - v) > O && ("BR" !== o2.nodeName || 0 === s2) && (a2 = [],
            z.push(a2),
            v = w2),
            G && (o2._x = o2.offsetLeft,
            o2._y = w2,
            o2._w = o2.offsetWidth,
            o2._h = o2.offsetHeight),
            z && ((o2._isSplit && d2 || !q && d2 || $ && d2 || !$ && o2.parentNode.parentNode === D2 && !o2.parentNode._isSplit) && (a2.push(o2),
            o2._x -= m2,
            x(o2, D2, M) && (o2._wordEnd = true)),
            "BR" === o2.nodeName && (o2.nextSibling && "BR" === o2.nextSibling.nodeName || 0 === s2) && z.push([])));
    for (s2 = 0; s2 < l2; s2++)
        if (o2 = r2[s2],
        d2 = o2.parentNode === D2,
        "BR" !== o2.nodeName)
            if (G && (A2 = o2.style,
            $ || d2 || (o2._x += o2.parentNode._x,
            o2._y += o2.parentNode._y),
            A2.left = o2._x + "px",
            A2.top = o2._y + "px",
            A2.position = "absolute",
            A2.display = "block",
            A2.width = o2._w + 1 + "px",
            A2.height = o2._h + "px"),
            !$ && q)
                if (o2._isSplit)
                    for (o2._next = E2 = o2.nextSibling,
                    o2.parentNode.appendChild(o2); E2 && 3 === E2.nodeType && " " === E2.textContent; )
                        o2._next = E2.nextSibling,
                        o2.parentNode.appendChild(E2),
                        E2 = E2.nextSibling;
                else
                    o2.parentNode._isSplit ? (o2._parent = o2.parentNode,
                    !o2.previousSibling && o2.firstChild && (o2.firstChild._isFirst = true),
                    o2.nextSibling && " " === o2.nextSibling.textContent && !o2.nextSibling.nextSibling && K.push(o2.nextSibling),
                    o2._next = o2.nextSibling && o2.nextSibling._isFirst ? null : o2.nextSibling,
                    o2.parentNode.removeChild(o2),
                    r2.splice(s2--, 1),
                    l2--) : d2 || (w2 = !o2.nextSibling && x(o2.parentNode, D2, M),
                    o2.parentNode._parent && o2.parentNode._parent.appendChild(o2),
                    w2 && o2.parentNode.appendChild(u.createTextNode(" ")),
                    "span" === k && (o2.style.display = "inline"),
                    V.push(o2));
            else
                o2.parentNode._isSplit && !o2._isSplit && "" !== o2.innerHTML ? R.push(o2) : q && !o2._isSplit && ("span" === k && (o2.style.display = "inline"),
                V.push(o2));
        else
            z || G ? (o2.parentNode && o2.parentNode.removeChild(o2),
            r2.splice(s2--, 1),
            l2--) : $ || D2.appendChild(o2);
    for (s2 = K.length; --s2 > -1; )
        K[s2].parentNode.removeChild(K[s2]);
    if (z) {
        for (G && (f2 = u.createElement(k),
        D2.appendChild(f2),
        _2 = f2.offsetWidth + "px",
        w2 = f2.offsetParent === D2 ? 0 : D2.offsetLeft,
        D2.removeChild(f2)),
        A2 = D2.style.cssText,
        D2.style.cssText = "display:none;"; D2.firstChild; )
            D2.removeChild(D2.firstChild);
        for (p2 = " " === M && (!G || !$ && !q),
        s2 = 0; s2 < z.length; s2++) {
            for (a2 = z[s2],
            f2 = u.createElement(k),
            f2.style.cssText = "display:block;text-align:" + H + ";position:" + (G ? "absolute;" : "relative;"),
            I && (f2.className = I + (J ? s2 + 1 : "")),
            j.push(f2),
            l2 = a2.length,
            E2 = 0; E2 < l2; E2++)
                "BR" !== a2[E2].nodeName && (o2 = a2[E2],
                f2.appendChild(o2),
                p2 && o2._wordEnd && f2.appendChild(u.createTextNode(" ")),
                G && (0 === E2 && (f2.style.top = o2._y + "px",
                f2.style.left = m2 + w2 + "px"),
                o2.style.top = "0px",
                w2 && (o2.style.left = o2._x - w2 + "px")));
            0 === l2 ? f2.innerHTML = "&nbsp;" : $ || q || (y(f2),
            c(f2, String.fromCharCode(160), " ")),
            G && (f2.style.width = _2,
            f2.style.height = o2._h + "px"),
            D2.appendChild(f2);
        }
        D2.style.cssText = A2;
    }
    G && (n2 > D2.clientHeight && (D2.style.height = n2 - L + "px",
    D2.clientHeight < n2 && (D2.style.height = n2 + T + "px")),
    i2 > D2.clientWidth && (D2.style.width = i2 - W + "px",
    D2.clientWidth < i2 && (D2.style.width = i2 + N + "px"))),
    Q && (U ? D2.style.display = U : D2.style.removeProperty("display")),
    g(t2, V),
    $ && g(F2, R),
    g(C2, j);
}
;
var w = (e2,t2,F2,C2)=>{
    let i2, l2, o2, r2, d2, a2, p2, h2, f2 = t2.tag ? t2.tag : t2.span ? "span" : "div", g2 = ~(t2.type || t2.split || "chars,words,lines").indexOf("chars"), x2 = B(t2), y2 = t2.wordDelimiter || " ", b2 = (D2)=>D2 === y2 || D2 === E && " " === y2, _2 = " " !== y2 ? "" : x2 ? "&#173; " : " ", w2 = "</" + f2 + ">", S2 = 1, m2 = t2.specialChars ? "function" == typeof t2.specialChars ? t2.specialChars : A : null, v = u.createElement("div"), T = e2.parentNode;
    for (T.insertBefore(v, e2),
    v.textContent = e2.nodeValue,
    T.removeChild(e2),
    i2 = function D2(u2) {
        let e3 = u2.nodeType
          , t3 = "";
        if (1 === e3 || 9 === e3 || 11 === e3) {
            if ("string" == typeof u2.textContent)
                return u2.textContent;
            for (u2 = u2.firstChild; u2; u2 = u2.nextSibling)
                t3 += D2(u2);
        } else if (3 === e3 || 4 === e3)
            return u2.nodeValue;
        return t3;
    }(e2 = v),
    p2 = -1 !== i2.indexOf("<"),
    false !== t2.reduceWhiteSpace && (i2 = i2.replace(s, " ").replace(n, "")),
    p2 && (i2 = i2.split("<").join("{{LT}}")),
    d2 = i2.length,
    l2 = (" " === i2.charAt(0) ? _2 : "") + F2(),
    o2 = 0; o2 < d2; o2++)
        if (a2 = i2.charAt(o2),
        m2 && (h2 = m2(i2.substr(o2), t2.specialChars)))
            a2 = i2.substr(o2, h2 || 1),
            l2 += g2 && " " !== a2 ? C2() + a2 + "</" + f2 + ">" : a2,
            o2 += h2 - 1;
        else if (b2(a2) && !b2(i2.charAt(o2 - 1)) && o2) {
            for (l2 += S2 ? w2 : "",
            S2 = 0; b2(i2.charAt(o2 + 1)); )
                l2 += _2,
                o2++;
            o2 === d2 - 1 ? l2 += _2 : ")" !== i2.charAt(o2 + 1) && (l2 += _2 + F2(),
            S2 = 1);
        } else
            "{" === a2 && "{{LT}}" === i2.substr(o2, 6) ? (l2 += g2 ? C2() + "{{LT}}</" + f2 + ">" : "{{LT}}",
            o2 += 5) : a2.charCodeAt(0) >= 55296 && a2.charCodeAt(0) <= 56319 || i2.charCodeAt(o2 + 1) >= 65024 && i2.charCodeAt(o2 + 1) <= 65039 ? (r2 = ((i2.substr(o2, 12).split(D) || [])[1] || "").length || 2,
            l2 += g2 && " " !== a2 ? C2() + i2.substr(o2, r2) + "</" + f2 + ">" : i2.substr(o2, r2),
            o2 += r2 - 1) : l2 += g2 && " " !== a2 ? C2() + a2 + "</" + f2 + ">" : a2;
    e2.outerHTML = l2 + (S2 ? w2 : ""),
    p2 && c(T, "{{LT}}", "<");
}
;
var S = (D2,u2,e2,t2)=>{
    let F2, C2, n2 = i(D2.childNodes), s2 = n2.length, E2 = B(u2);
    if (3 !== D2.nodeType || s2 > 1) {
        for (u2.absolute = false,
        F2 = 0; F2 < s2; F2++)
            C2 = n2[F2],
            C2._next = C2._isFirst = C2._parent = C2._wordEnd = null,
            (3 !== C2.nodeType || /\S+/.test(C2.nodeValue)) && (E2 && 3 !== C2.nodeType && "inline" === h(C2).display && (C2.style.display = "inline-block",
            C2.style.position = "relative"),
            C2._isSplit = true,
            S(C2, u2, e2, t2));
        return u2.absolute = E2,
        void (D2._isSplit = true);
    }
    w(D2, u2, e2, t2);
}
;
var m = class _m {
    constructor(D2, u2) {
        t || l(),
        this.elements = i(D2),
        this.chars = [],
        this.words = [],
        this.lines = [],
        this._originals = [],
        this.vars = u2 || {},
        C(this),
        this.split(u2);
    }
    split(D2) {
        this.isSplit && this.revert(),
        this.vars = D2 = D2 || this.vars,
        this._originals.length = this.chars.length = this.words.length = this.lines.length = 0;
        let u2, e2, t2, F2 = this.elements.length, C2 = D2.tag ? D2.tag : D2.span ? "span" : "div", i2 = f(D2.wordsClass, C2), n2 = f(D2.charsClass, C2);
        for (; --F2 > -1; )
            t2 = this.elements[F2],
            this._originals[F2] = {
                html: t2.innerHTML,
                style: t2.getAttribute("style")
            },
            u2 = t2.clientHeight,
            e2 = t2.clientWidth,
            S(t2, D2, i2, n2),
            _(t2, D2, this.chars, this.words, this.lines, e2, u2);
        return this.chars.reverse(),
        this.words.reverse(),
        this.lines.reverse(),
        this.isSplit = true,
        this;
    }
    revert() {
        let D2 = this._originals;
        if (!D2)
            throw "revert() call wasn't scoped properly.";
        return this.elements.forEach((u2,e2)=>{
            u2.innerHTML = D2[e2].html,
            u2.setAttribute("style", D2[e2].style);
        }
        ),
        this.chars = [],
        this.words = [],
        this.lines = [],
        this.isSplit = false,
        this;
    }
    static create(D2, u2) {
        return new _m(D2,u2);
    }
}
;
m.version = "3.12.5",
m.register = l;
var SplitText_default = m;
export {m as SplitText, SplitText_default as default};
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
