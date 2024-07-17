(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
  ["common/main"], {
    "15cf": function (e, t, n) {
      "use strict";
      n.r(t);
      var o = n("c832");
      for (var r in o)["default"].indexOf(r) < 0 && function (e) {
        n.d(t, e, (function () {
          return o[e]
        }))
      }(r);
      n("67d7");
      var c = n("f0c5"),
        u = Object(c["a"])(o["default"], void 0, void 0, !1, null, null, null, !1, void 0, void 0);
      t["default"] = u.exports
    },
    "5abd": function (e, t, n) {
      "use strict";
      (function (e, t) {
        var o = n("4ea4"),
          r = o(n("9523"));
        n("982d");
        var c = o(n("15cf"));
        n("3009");
        var u = o(n("66fd"));

        function i(e, t) {
          var n = Object.keys(e);
          if (Object.getOwnPropertySymbols) {
            var o = Object.getOwnPropertySymbols(e);
            t && (o = o.filter((function (t) {
              return Object.getOwnPropertyDescriptor(e, t).enumerable
            }))), n.push.apply(n, o)
          }
          return n
        }
        n("478d"), e.__webpack_require_UNI_MP_PLUGIN__ = n, u.default.config.productionTip = !1, c.default.mpType = "app";
        var f = new u.default(function (e) {
          for (var t = 1; t < arguments.length; t++) {
            var n = null != arguments[t] ? arguments[t] : {};
            t % 2 ? i(Object(n), !0).forEach((function (t) {
              (0, r.default)(e, t, n[t])
            })) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n)) : i(Object(n)).forEach((function (t) {
              Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t))
            }))
          }
          return e
        }({}, c.default));
        t(f).$mount()
      }).call(this, n("bc2e")["default"], n("543d")["createApp"])
    },
    "67d7": function (e, t, n) {
      "use strict";
      var o = n("8385"),
        r = n.n(o);
      r.a
    },
    8385: function (e, t, n) {},
    c832: function (e, t, n) {
      "use strict";
      n.r(t);
      var o = n("f21f"),
        r = n.n(o);
      for (var c in o)["default"].indexOf(c) < 0 && function (e) {
        n.d(t, e, (function () {
          return o[e]
        }))
      }(c);
      t["default"] = r.a
    },
    f21f: function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: !0
      }), t.default = void 0;
      var o = {
        onLaunch: function () {
          console.log("App Launch")
        },
        onShow: function () {
          console.log("App Show")
        },
        onHide: function () {
          console.log("App Hide")
        },
        globalData: {
          url: "https://nianb8.qingfengkeji.vip/",
          isLogin: !1,
          userInfo: null,
          mobile: "",
          config: [],
          access_token: ""
        }
      };
      t.default = o
    }
  },
  [
    ["5abd", "common/runtime", "common/vendor"]
  ]
]);