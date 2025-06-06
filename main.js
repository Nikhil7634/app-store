var TouchSlide = function (e) {
  var t = {
      slideCell: (e = e || {}).slideCell || "#touchSlide",
      titCell: e.titCell || ".hd li",
      mainCell: e.mainCell || ".bd",
      effect: e.effect || "left",
      autoPlay: e.autoPlay || !1,
      noTouch: e.noTouch || !1,
      delayTime: e.delayTime || 200,
      interTime: e.interTime || 2500,
      defaultIndex: e.defaultIndex || 0,
      titOnClassName: e.titOnClassName || "on",
      autoPage: e.autoPage || !1,
      prevCell: e.prevCell || ".prev",
      nextCell: e.nextCell || ".next",
      pageStateCell: e.pageStateCell || ".pageState",
      pnLoop: "undefined " == e.pnLoop || e.pnLoop,
      startFun: e.startFun || null,
      endFun: e.endFun || null,
      switchLoad: e.switchLoad || null,
    },
    n = document.getElementById(t.slideCell.replace("#", ""));
  if (!n) return !1;
  var a = function (e, t) {
      e = e.split(" ");
      var n = [],
        a = [(t = t || document)];
      for (var l in e) 0 != e[l].length && n.push(e[l]);
      for (var l in n) {
        if (0 == a.length) return !1;
        var i = [];
        for (var o in a)
          if ("#" == n[l][0])
            i.push(document.getElementById(n[l].replace("#", "")));
          else if ("." == n[l][0])
            for (
              var r = a[o].getElementsByTagName("*"), s = 0;
              s < r.length;
              s++
            ) {
              var c = r[s].className;
              "string" == typeof c &&
                -1 !=
                  c.search(new RegExp("\\b" + n[l].replace(".", "") + "\\b")) &&
                i.push(r[s]);
            }
          else
            for (r = a[o].getElementsByTagName(n[l]), s = 0; s < r.length; s++)
              i.push(r[s]);
        a = i;
      }
      return 0 != a.length && a[0] != t && a;
    },
    l = function (e, t) {
      !e ||
        !t ||
        (e.className &&
          -1 != e.className.search(new RegExp("\\b" + t + "\\b"))) ||
        (e.className += (e.className ? " " : "") + t);
    },
    i = function (e, t) {
      !e ||
        !t ||
        (e.className &&
          -1 == e.className.search(new RegExp("\\b" + t + "\\b"))) ||
        (e.className = e.className.replace(
          new RegExp("\\s*\\b" + t + "\\b", "g"),
          ""
        ));
    },
    o = t.effect,
    r = a(t.prevCell, n)[0],
    s = a(t.nextCell, n)[0],
    c = a(t.pageStateCell)[0],
    u = a(t.mainCell, n)[0];
  if (!u) return !1;
  var d,
    p,
    f = u.children.length,
    v = a(t.titCell, n),
    m = v ? v.length : f,
    h = t.switchLoad,
    g = parseInt(t.defaultIndex),
    T = parseInt(t.delayTime),
    L = parseInt(t.interTime),
    b = "false" != t.autoPlay && 0 != t.autoPlay,
    C = "false" != t.autoPage && 0 != t.autoPage,
    w = "false" != t.noTouch && 0 != t.noTouch,
    y = "false" != t.pnLoop && 0 != t.pnLoop,
    x = null,
    N = null,
    E = null,
    P = 0,
    k = 0,
    I = 0,
    M = 0,
    S = /hp-tablet/gi.test(navigator.appVersion),
    F = "ontouchstart" in window && !S,
    D = F ? "touchstart" : "mousedown",
    B = F ? "touchmove" : "",
    O = F ? "touchend" : "mouseup",
    A = u.parentNode.clientWidth,
    H = f;
  if ((0 == m && (m = f), C)) {
    (m = f), ((v = v[0]).innerHTML = "");
    var R = "";
    if (1 == t.autoPage || "true" == t.autoPage)
      for (var z = 0; z < m; z++) R += "<li>" + (z + 1) + "</li>";
    else for (z = 0; z < m; z++) R += t.autoPage.replace("$", z + 1);
    (v.innerHTML = R), (v = v.children);
  }
  "leftLoop" == o &&
    ((H += 2),
    u.appendChild(u.children[0].cloneNode(!0)),
    u.insertBefore(u.children[f - 1].cloneNode(!0), u.children[0])),
    (d = (function (e, t) {
      var n = document.createElement("div");
      (n.innerHTML = t), (n = n.children[0]);
      var a = e.cloneNode(!0);
      return n.appendChild(a), e.parentNode.replaceChild(n, e), (u = a), n;
    })(
      u,
      '<div class="tempWrap" style="overflow:hidden; position:relative;"></div>'
    )),
    (u.style.cssText =
      "width:" +
      H * A +
      "px;position:relative;overflow:hidden;padding:0;margin:0;");
  for (z = 0; z < H; z++)
    u.children[z].style.cssText =
      "display:table-cell;vertical-align:top;width:" + A + "px";
  var W = function (e) {
    var t = ("leftLoop" == o ? g + 1 : g) + e,
      n = function (e) {
        for (
          var t = u.children[e].getElementsByTagName("img"), n = 0;
          n < t.length;
          n++
        )
          t[n].getAttribute(h) &&
            (t[n].setAttribute("src", t[n].getAttribute(h)),
            t[n].removeAttribute(h));
      };
    if ((n(t), "leftLoop" == o))
      switch (t) {
        case 0:
          n(f);
          break;
        case 1:
          n(f + 1);
          break;
        case f:
          n(0);
          break;
        case f + 1:
          n(1);
      }
  };
  window.addEventListener(
    "resize",
    function () {
      (A = d.clientWidth), (u.style.width = H * A + "px");
      for (var e = 0; e < H; e++) u.children[e].style.width = A + "px";
      X(-("leftLoop" == o ? g + 1 : g) * A, 0);
    },
    !1
  );
  var X = function (e, t, n) {
      ((n = n ? n.style : u.style).webkitTransitionDuration =
        n.MozTransitionDuration =
        n.msTransitionDuration =
        n.OTransitionDuration =
        n.transitionDuration =
          t + "ms"),
        (n.webkitTransform = "translate(" + e + "px,0)translateZ(0)"),
        (n.msTransform =
          n.MozTransform =
          n.OTransform =
            "translateX(" + e + "px)");
    },
    Y = function (e) {
      switch (o) {
        case "left":
          g >= m ? (g = e ? g - 1 : 0) : g < 0 && (g = e ? 0 : m - 1),
            null != h && W(0),
            X(-g * A, T),
            g;
          break;
        case "leftLoop":
          null != h && W(0),
            X(-(g + 1) * A, T),
            -1 == g
              ? ((N = setTimeout(function () {
                  X(-m * A, 0);
                }, T)),
                (g = m - 1))
              : g == m &&
                ((N = setTimeout(function () {
                  X(-A, 0);
                }, T)),
                (g = 0)),
            g;
      }
      "function" == typeof t.startFun && t.startFun(g, m),
        (E = setTimeout(function () {
          "function" == typeof t.endFun && t.endFun(g, m);
        }, T));
      for (var n = 0; n < m; n++)
        i(v[n], t.titOnClassName), n == g && l(v[n], t.titOnClassName);
      0 == y &&
        (i(s, "nextStop"),
        i(r, "prevStop"),
        0 == g ? l(r, "prevStop") : g == m - 1 && l(s, "nextStop")),
        c && (c.innerHTML = "<span>" + (g + 1) + "</span>/" + m);
    };
  Y();
  var V = function () {
      b &&
        (x = setInterval(function () {
          g++, Y();
        }, L));
    },
    Z = function () {
      b && clearInterval(x);
    };
  if ((V(), v))
    for (z = 0; z < m; z++)
      !(function () {
        var e = z;
        v[e].addEventListener("click", function (t) {
          clearTimeout(N), clearTimeout(E), Z(), (g = e), Y(), V();
        });
      })();
  s &&
    s.addEventListener("click", function (e) {
      (1 != y && g == m - 1) ||
        (clearTimeout(N), clearTimeout(E), Z(), g++, Y(), V());
    }),
    r &&
      r.addEventListener("click", function (e) {
        (1 != y && 0 == g) ||
          (clearTimeout(N), clearTimeout(E), Z(), g--, Y(), V());
      });
  var $ = function (e) {
      if (!F || !(e.touches.length > 1 || (e.scale && 1 !== e.scale))) {
        var t = F ? e.touches[0] : e;
        if (
          ((I = t.pageX - P),
          (M = t.pageY - k),
          void 0 === p && (p = !!(p || Math.abs(I) < Math.abs(M))),
          !p)
        ) {
          switch ((e.preventDefault(), Z(), o)) {
            case "left":
              ((0 == g && I > 0) || (g >= m - 1 && I < 0)) && (I *= 0.4),
                X(-g * A + I, 0);
              break;
            case "leftLoop":
              X(-(g + 1) * A + I, 0);
          }
          null != h && Math.abs(I) > A / 3 && W(I > -0 ? -1 : 1);
        }
      }
    },
    j = function (e) {
      0 != I &&
        (e.preventDefault(),
        p || (Math.abs(I) > A / 10 && (I > 0 ? g-- : g++), Y(!0), V()),
        u.removeEventListener(B, $, !1),
        u.removeEventListener(O, j, !1));
    };
  w ||
    u.addEventListener(
      D,
      function (e) {
        clearTimeout(N), clearTimeout(E), (p = void 0), (I = 0);
        var t = F ? e.touches[0] : e;
        (P = t.pageX),
          (k = t.pageY),
          u.addEventListener(B, $, { passive: !1 }),
          u.addEventListener(O, j, { passive: !1 });
      },
      { passive: !1 }
    );
};
!(function (a, e) {
  var s,
    r = e.querySelector("link[rel='canonical']");
  (s = r ? r.getAttribute("href") : location.href),
    "object" == typeof addthis_share &&
      addthis_share.url &&
      (s = addthis_share.url),
    $(e).on("click", "[data-sharer]", function () {
      var a = $(this).attr("data-sharer");
      (a += "|"), $$.analytics.send("event", "share", s, e.title, a);
    }),
    $.ajax({
      url: "https://a.apkpure.com/api-shares.json?url=" + encodeURIComponent(s),
      type: "GET",
      dataType: "jsonp",
      jsonp: "callback",
      success: function (a) {
        a &&
          a.shares &&
          ($(".share-toolbox").append(
            '<span class="share-counter">' + a.shares + "</span>"
          ),
          $(".share-mob .share-more .text")
            .html(a.shares + "<br>SHARES")
            .toggleClass("share-bottom-counter text"),
          $(".share-side-counter").html(
            '<div class="share-side-count">' +
              a.shares +
              '</div><div class="share-side-text">SHARES</div>'
          ));
      },
    });
})(window, document);

!(function () {
  "use strict";
  $(function () {
    var e = window,
      t = e.TouchSlide,
      a = e.Redirect;
    new t({
      slideCell: "#top-slide-banner",
      mainCell: ".container .list",
      titCell: ".dots",
      effect: "leftLoop",
      autoPage: !0,
      autoPlay: !0,
      interTime: 5e3,
      startFun: function () {
        var e;
        null === (e = window.defaultLazyLoadInstance) ||
          void 0 === e ||
          e.update();
      },
    }),
      a.isShowLangTip &&
        $(".lang-tip .lang-go").append(
          '<a class="lang-yes" href="" title="yes"></a>'
        );
  }),
    (window.onSideSearchSubmit = function (e) {
      (location.href = "search?q=".concat(
        e.target.querySelector("[name=q]").value ||
          e.target.querySelector("[name=q]").placeholder
      )),
        (e.target.querySelector("[name=q]").value =
          e.target.querySelector("[name=q]").value ||
          e.target.querySelector("[name=q]").placeholder);
    });
})();
