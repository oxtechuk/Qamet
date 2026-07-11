"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_erp_views_System_ModulesManager_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=script&setup=true&lang=js":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=script&setup=true&lang=js ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var vue_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-i18n */ "./node_modules/vue-i18n/dist/vue-i18n.mjs");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'ERPLayout',
  setup: function setup(__props, _ref) {
    var __expose = _ref.expose;
    __expose();
    var isSidebarCollapsed = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var _useI18n = (0,vue_i18n__WEBPACK_IMPORTED_MODULE_1__.useI18n)(),
      locale = _useI18n.locale;
    var toggleSidebar = function toggleSidebar() {
      isSidebarCollapsed.value = !isSidebarCollapsed.value;
    };
    var toggleLanguage = function toggleLanguage() {
      var newLocale = locale.value === 'ar' ? 'en' : 'ar';
      locale.value = newLocale;
      localStorage.setItem('erp_locale', newLocale);
      document.documentElement.lang = newLocale;
      document.documentElement.dir = newLocale === 'ar' ? 'rtl' : 'ltr';
    };
    var __returned__ = {
      isSidebarCollapsed: isSidebarCollapsed,
      locale: locale,
      toggleSidebar: toggleSidebar,
      toggleLanguage: toggleLanguage,
      ref: vue__WEBPACK_IMPORTED_MODULE_0__.ref,
      get useI18n() {
        return vue_i18n__WEBPACK_IMPORTED_MODULE_1__.useI18n;
      }
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=script&setup=true&lang=js":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=script&setup=true&lang=js ***!
  \*************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! axios */ "./node_modules/axios/lib/axios.js");
/* harmony import */ var _layouts_ERPLayout_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../layouts/ERPLayout.vue */ "./resources/js/erp/layouts/ERPLayout.vue");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'ModulesManager',
  setup: function setup(__props, _ref) {
    var __expose = _ref.expose;
    __expose();
    var modules = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)([]);
    var fetchModules = /*#__PURE__*/function () {
      var _ref2 = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _context.next = 3;
              return axios__WEBPACK_IMPORTED_MODULE_2__["default"].get('/api/erp/modules');
            case 3:
              response = _context.sent;
              modules.value = response.data;
              _context.next = 10;
              break;
            case 7:
              _context.prev = 7;
              _context.t0 = _context["catch"](0);
              console.error('Error fetching modules', _context.t0);
            case 10:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 7]]);
      }));
      return function fetchModules() {
        return _ref2.apply(this, arguments);
      };
    }();
    var toggleModule = /*#__PURE__*/function () {
      var _ref3 = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2(module, status) {
        var action;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              action = status ? 'enable' : 'disable'; // Optimistic UI update
              module.is_active = status;
              _context2.prev = 2;
              _context2.next = 5;
              return axios__WEBPACK_IMPORTED_MODULE_2__["default"].post("/api/erp/modules/".concat(module.alias, "/").concat(action));
            case 5:
              // Reload the page to register new routes and state if necessary
              window.location.reload();
              _context2.next = 13;
              break;
            case 8:
              _context2.prev = 8;
              _context2.t0 = _context2["catch"](2);
              console.error("Error trying to ".concat(action, " module:"), _context2.t0);
              // Revert UI if failed
              module.is_active = !status;
              alert('حدث خطأ أثناء تغيير حالة الموديول');
            case 13:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[2, 8]]);
      }));
      return function toggleModule(_x, _x2) {
        return _ref3.apply(this, arguments);
      };
    }();
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      fetchModules();
    });
    var __returned__ = {
      modules: modules,
      fetchModules: fetchModules,
      toggleModule: toggleModule,
      ref: vue__WEBPACK_IMPORTED_MODULE_0__.ref,
      onMounted: vue__WEBPACK_IMPORTED_MODULE_0__.onMounted,
      get axios() {
        return axios__WEBPACK_IMPORTED_MODULE_2__["default"];
      },
      ERPLayout: _layouts_ERPLayout_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "erp-layout d-flex h-100"
};
var _hoisted_2 = {
  "class": "d-flex align-items-center justify-content-between mb-4"
};
var _hoisted_3 = {
  key: 0,
  "class": "m-0 font-weight-bold"
};
var _hoisted_4 = {
  "class": "nav flex-column gap-2 mt-4"
};
var _hoisted_5 = {
  "class": "nav-item"
};
var _hoisted_6 = {
  key: 0
};
var _hoisted_7 = {
  "class": "nav-item"
};
var _hoisted_8 = {
  key: 0
};
var _hoisted_9 = {
  "class": "nav-item mt-3 pt-3 border-top border-secondary"
};
var _hoisted_10 = {
  key: 0,
  "class": "text-secondary text-uppercase ps-2 mb-2 d-block"
};
var _hoisted_11 = {
  key: 0
};
var _hoisted_12 = {
  key: 0
};
var _hoisted_13 = {
  key: 0
};
var _hoisted_14 = {
  "class": "nav-item mt-3 pt-3 border-top border-secondary"
};
var _hoisted_15 = {
  key: 0,
  "class": "text-secondary text-uppercase ps-2 mb-2 d-block"
};
var _hoisted_16 = {
  key: 0
};
var _hoisted_17 = {
  "class": "nav-item mt-3 pt-3 border-top border-secondary"
};
var _hoisted_18 = {
  key: 0,
  "class": "text-secondary text-uppercase ps-2 mb-2 d-block"
};
var _hoisted_19 = {
  key: 0
};
var _hoisted_20 = {
  "class": "nav-item mt-3 pt-3 border-top border-secondary mb-3"
};
var _hoisted_21 = {
  key: 0,
  "class": "text-secondary text-uppercase ps-2 mb-2 d-block"
};
var _hoisted_22 = {
  key: 0
};
var _hoisted_23 = {
  "class": "main-content flex-grow-1 d-flex flex-column bg-light"
};
var _hoisted_24 = {
  "class": "topbar bg-white shadow-sm p-3 d-flex justify-content-between align-items-center"
};
var _hoisted_25 = {
  "class": "search-bar"
};
var _hoisted_26 = ["placeholder"];
var _hoisted_27 = {
  "class": "user-menu d-flex align-items-center gap-3"
};
var _hoisted_28 = {
  "class": "dropdown"
};
var _hoisted_29 = {
  "class": "dropdown-menu dropdown-menu-end"
};
var _hoisted_30 = {
  "class": "dropdown-item",
  href: "#"
};
var _hoisted_31 = {
  "class": "dropdown-item text-danger",
  href: "#"
};
var _hoisted_32 = {
  "class": "p-4 flex-grow-1 overflow-auto"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  var _component_router_view = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-view");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Sidebar "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("aside", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["sidebar bg-dark text-white p-3 shadow-lg flex-shrink-0", {
      'collapsed': $setup.isSidebarCollapsed
    }])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [!$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("h4", _hoisted_3, "ERP System")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "ri-menu-line fs-4 cursor-pointer",
    onClick: $setup.toggleSidebar
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2",
    "active-class": "active bg-primary",
    exact: ""
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[0] || (_cache[0] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-dashboard-line fs-5"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$t('common.dashboard')), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm/system/modules",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2",
    "active-class": "active bg-primary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[1] || (_cache[1] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-settings-3-line fs-5"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_8, "الموديولات والأنظمة")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_9, [!$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("small", _hoisted_10, "المعرض (CRM)")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm/cars",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2",
    "active-class": "active bg-primary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-car-fill fs-5 text-info"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_11, "إدارة السيارات")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm/brands",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2 mt-1",
    "active-class": "active bg-primary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-steering-fill fs-5 text-info"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_12, "الماركات التجارية")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm/cms/settings",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2 mt-1",
    "active-class": "active bg-primary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-layout-masonry-line fs-5 text-warning"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, "إدارة محتوى المتجر")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_14, [!$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("small", _hoisted_15, "إدارة المشتريات")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm/purchasing/suppliers",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2",
    "active-class": "active bg-primary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-store-2-line fs-5"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_16, "الموردين")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_17, [!$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("small", _hoisted_18, "المخازن والمنتجات")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm/inventory/products",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2",
    "active-class": "active bg-primary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-archive-line fs-5"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_19, "المنتجات (الأصناف)")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_20, [!$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("small", _hoisted_21, "المبيعات والعملاء")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/crm/sales/clients",
    "class": "nav-link text-white rounded d-flex align-items-center gap-2",
    "active-class": "active bg-primary"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-user-smile-line fs-5"
      }, null, -1 /* CACHED */)), !$setup.isSidebarCollapsed ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_22, "الـعــمـــلاء")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
    }),
    _: 1 /* STABLE */
  })])])], 2 /* CLASS */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Main Content "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("main", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Topbar "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("header", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "class": "form-control rounded-pill",
    placeholder: _ctx.$t('common.search') || 'Search...'
  }, null, 8 /* PROPS */, _hoisted_26)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_27, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: $setup.toggleLanguage,
    "class": "btn btn-sm btn-outline-secondary"
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$i18n.locale === 'ar' ? 'English' : 'عربي'), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [_cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-light dropdown-toggle d-flex align-items-center gap-2",
    type: "button",
    "data-bs-toggle": "dropdown"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "ri-user-line"
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" User ")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$t('common.profile')), 1 /* TEXT */)]), _cache[8] || (_cache[8] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("hr", {
    "class": "dropdown-divider"
  })], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$t('common.logout')), 1 /* TEXT */)])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Router View Container "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_view)])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }

var _hoisted_1 = {
  "class": "modules-wrapper"
};
var _hoisted_2 = {
  "class": "row g-4"
};
var _hoisted_3 = {
  "class": "card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden"
};
var _hoisted_4 = {
  key: 0,
  "class": "position-absolute bg-success text-white px-3 py-1",
  style: {
    "top": "15px",
    "right": "-25px",
    "transform": "rotate(45deg)",
    "font-size": "0.75rem",
    "width": "100px",
    "text-align": "center",
    "z-index": "1"
  }
};
var _hoisted_5 = {
  "class": "card-body p-4"
};
var _hoisted_6 = {
  "class": "d-flex align-items-center mb-3"
};
var _hoisted_7 = {
  "class": "mb-0 fw-bold"
};
var _hoisted_8 = {
  "class": "text-muted text-uppercase"
};
var _hoisted_9 = {
  "class": "text-secondary",
  style: {
    "min-height": "50px"
  }
};
var _hoisted_10 = {
  "class": "card-footer bg-white border-0 p-4 pt-0 d-flex justify-content-end align-items-center gap-2"
};
var _hoisted_11 = {
  key: 0,
  "class": "form-check form-switch fs-5 m-0"
};
var _hoisted_12 = ["id", "checked", "onChange"];
var _hoisted_13 = {
  key: 1,
  "class": "badge bg-secondary"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["ERPLayout"], null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "d-flex justify-content-between align-items-center mb-4"
      }, [_cache[1] || (_cache[1] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
        "class": "mb-1"
      }, "نظام إدارة الموديولات (Add-ons)"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-muted"
      }, "التحكم في تفعيل أو إيقاف الميزات الإضافية للنظام")], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-primary shadow-sm",
        onClick: $setup.fetchModules
      }, _toConsumableArray(_cache[0] || (_cache[0] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-refresh-line"
      }, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" تحديث القائمة ", -1 /* CACHED */)])))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Module Card "), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.modules, function (module) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          "class": "col-md-4",
          key: module.id
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Active indicator ribbon "), module.is_active ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_4, " مفعل ")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "icon-box rounded-circle p-3 me-3 text-white d-flex align-items-center justify-content-center",
          style: (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeStyle)({
            backgroundColor: module.color,
            width: '50px',
            height: '50px'
          })
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
          "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([module.icon, "fs-4"])
        }, null, 2 /* CLASS */)], 4 /* STYLE */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(module.name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("small", _hoisted_8, "v" + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(module.version) + " • " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(module.alias), 1 /* TEXT */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(module.description || 'لا يوجد وصف متاح.'), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [module.alias !== 'core' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
          "class": "form-check-input cursor-pointer",
          type: "checkbox",
          id: 'module_' + module.alias,
          checked: module.is_active,
          onChange: function onChange($event) {
            return $setup.toggleModule(module, $event.target.checked);
          }
        }, null, 40 /* PROPS, NEED_HYDRATION */, _hoisted_12)])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_13, "System Core"))])])]);
      }), 128 /* KEYED_FRAGMENT */))])])];
    }),
    _: 1 /* STABLE */
  });
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/cssWithMappingToString.js */ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.erp-layout[data-v-7b4bd8e6] {\n    height: 100vh;\n}\n.sidebar[data-v-7b4bd8e6] {\n    width: 250px;\n    transition: all 0.3s ease;\n    z-index: 1040;\n}\n.sidebar.collapsed[data-v-7b4bd8e6] {\n    width: 70px;\n}\n.cursor-pointer[data-v-7b4bd8e6] {\n    cursor: pointer;\n}\n.main-content[data-v-7b4bd8e6] {\n    overflow-x: hidden;\n}\n", "",{"version":3,"sources":["webpack://./resources/js/erp/layouts/ERPLayout.vue"],"names":[],"mappings":";AAuHA;IACI,aAAa;AACjB;AACA;IACI,YAAY;IACZ,yBAAyB;IACzB,aAAa;AACjB;AACA;IACI,WAAW;AACf;AACA;IACI,eAAe;AACnB;AACA;IACI,kBAAkB;AACtB","sourcesContent":["<template>\n  <div class=\"erp-layout d-flex h-100\">\n    <!-- Sidebar -->\n    <aside class=\"sidebar bg-dark text-white p-3 shadow-lg flex-shrink-0\" :class=\"{ 'collapsed': isSidebarCollapsed }\">\n      <div class=\"d-flex align-items-center justify-content-between mb-4\">\n        <h4 class=\"m-0 font-weight-bold\" v-if=\"!isSidebarCollapsed\">ERP System</h4>\n        <i class=\"ri-menu-line fs-4 cursor-pointer\" @click=\"toggleSidebar\"></i>\n      </div>\n\n      <ul class=\"nav flex-column gap-2 mt-4\">\n        <li class=\"nav-item\">\n          <router-link to=\"/crm\" class=\"nav-link text-white rounded d-flex align-items-center gap-2\" active-class=\"active bg-primary\" exact>\n            <i class=\"ri-dashboard-line fs-5\"></i>\n            <span v-if=\"!isSidebarCollapsed\">{{ $t('common.dashboard') }}</span>\n          </router-link>\n        </li>\n        <li class=\"nav-item\">\n          <router-link to=\"/crm/system/modules\" class=\"nav-link text-white rounded d-flex align-items-center gap-2\" active-class=\"active bg-primary\">\n            <i class=\"ri-settings-3-line fs-5\"></i>\n            <span v-if=\"!isSidebarCollapsed\">الموديولات والأنظمة</span>\n          </router-link>\n        </li>\n        \n        <li class=\"nav-item mt-3 pt-3 border-top border-secondary\">\n          <small v-if=\"!isSidebarCollapsed\" class=\"text-secondary text-uppercase ps-2 mb-2 d-block\">المعرض (CRM)</small>\n          <router-link to=\"/crm/cars\" class=\"nav-link text-white rounded d-flex align-items-center gap-2\" active-class=\"active bg-primary\">\n            <i class=\"ri-car-fill fs-5 text-info\"></i>\n            <span v-if=\"!isSidebarCollapsed\">إدارة السيارات</span>\n          </router-link>\n          <router-link to=\"/crm/brands\" class=\"nav-link text-white rounded d-flex align-items-center gap-2 mt-1\" active-class=\"active bg-primary\">\n            <i class=\"ri-steering-fill fs-5 text-info\"></i>\n            <span v-if=\"!isSidebarCollapsed\">الماركات التجارية</span>\n          </router-link>\n          <router-link to=\"/crm/cms/settings\" class=\"nav-link text-white rounded d-flex align-items-center gap-2 mt-1\" active-class=\"active bg-primary\">\n            <i class=\"ri-layout-masonry-line fs-5 text-warning\"></i>\n            <span v-if=\"!isSidebarCollapsed\">إدارة محتوى المتجر</span>\n          </router-link>\n        </li>\n        \n        <li class=\"nav-item mt-3 pt-3 border-top border-secondary\">\n          <small v-if=\"!isSidebarCollapsed\" class=\"text-secondary text-uppercase ps-2 mb-2 d-block\">إدارة المشتريات</small>\n          <router-link to=\"/crm/purchasing/suppliers\" class=\"nav-link text-white rounded d-flex align-items-center gap-2\" active-class=\"active bg-primary\">\n            <i class=\"ri-store-2-line fs-5\"></i>\n            <span v-if=\"!isSidebarCollapsed\">الموردين</span>\n          </router-link>\n        </li>\n        \n        <li class=\"nav-item mt-3 pt-3 border-top border-secondary\">\n          <small v-if=\"!isSidebarCollapsed\" class=\"text-secondary text-uppercase ps-2 mb-2 d-block\">المخازن والمنتجات</small>\n          <router-link to=\"/crm/inventory/products\" class=\"nav-link text-white rounded d-flex align-items-center gap-2\" active-class=\"active bg-primary\">\n            <i class=\"ri-archive-line fs-5\"></i>\n            <span v-if=\"!isSidebarCollapsed\">المنتجات (الأصناف)</span>\n          </router-link>\n        </li>\n        \n        <li class=\"nav-item mt-3 pt-3 border-top border-secondary mb-3\">\n          <small v-if=\"!isSidebarCollapsed\" class=\"text-secondary text-uppercase ps-2 mb-2 d-block\">المبيعات والعملاء</small>\n          <router-link to=\"/crm/sales/clients\" class=\"nav-link text-white rounded d-flex align-items-center gap-2\" active-class=\"active bg-primary\">\n            <i class=\"ri-user-smile-line fs-5\"></i>\n            <span v-if=\"!isSidebarCollapsed\">الـعــمـــلاء</span>\n          </router-link>\n        </li>\n      </ul>\n    </aside>\n\n    <!-- Main Content -->\n    <main class=\"main-content flex-grow-1 d-flex flex-column bg-light\">\n      <!-- Topbar -->\n      <header class=\"topbar bg-white shadow-sm p-3 d-flex justify-content-between align-items-center\">\n        <div class=\"search-bar\">\n           <input type=\"text\" class=\"form-control rounded-pill\" :placeholder=\"$t('common.search') || 'Search...'\">\n        </div>\n        \n        <div class=\"user-menu d-flex align-items-center gap-3\">\n          <button @click=\"toggleLanguage\" class=\"btn btn-sm btn-outline-secondary\">\n             {{ $i18n.locale === 'ar' ? 'English' : 'عربي' }}\n          </button>\n          <div class=\"dropdown\">\n            <button class=\"btn btn-light dropdown-toggle d-flex align-items-center gap-2\" type=\"button\" data-bs-toggle=\"dropdown\">\n              <i class=\"ri-user-line\"></i> User\n            </button>\n            <ul class=\"dropdown-menu dropdown-menu-end\">\n              <li><a class=\"dropdown-item\" href=\"#\">{{ $t('common.profile') }}</a></li>\n              <li><hr class=\"dropdown-divider\"></li>\n              <li><a class=\"dropdown-item text-danger\" href=\"#\">{{ $t('common.logout') }}</a></li>\n            </ul>\n          </div>\n        </div>\n      </header>\n\n      <!-- Router View Container -->\n      <div class=\"p-4 flex-grow-1 overflow-auto\">\n        <router-view></router-view>\n      </div>\n    </main>\n  </div>\n</template>\n\n<script setup>\nimport { ref } from 'vue';\nimport { useI18n } from 'vue-i18n';\n\nconst isSidebarCollapsed = ref(false);\nconst { locale } = useI18n();\n\nconst toggleSidebar = () => {\n    isSidebarCollapsed.value = !isSidebarCollapsed.value;\n};\n\nconst toggleLanguage = () => {\n    const newLocale = locale.value === 'ar' ? 'en' : 'ar';\n    locale.value = newLocale;\n    localStorage.setItem('erp_locale', newLocale);\n    document.documentElement.lang = newLocale;\n    document.documentElement.dir = newLocale === 'ar' ? 'rtl' : 'ltr';\n};\n</script>\n\n<style scoped>\n.erp-layout {\n    height: 100vh;\n}\n.sidebar {\n    width: 250px;\n    transition: all 0.3s ease;\n    z-index: 1040;\n}\n.sidebar.collapsed {\n    width: 70px;\n}\n.cursor-pointer {\n    cursor: pointer;\n}\n.main-content {\n    overflow-x: hidden;\n}\n</style>\n"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/cssWithMappingToString.js */ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.cursor-pointer[data-v-e1e6a42a] {\n  cursor: pointer;\n}\n.icon-box[data-v-e1e6a42a] {\n  width: 50px;\n  height: 50px;\n}\n", "",{"version":3,"sources":["webpack://./resources/js/erp/views/System/ModulesManager.vue"],"names":[],"mappings":";AAwFA;EACE,eAAe;AACjB;AACA;EACE,WAAW;EACX,YAAY;AACd","sourcesContent":["<template>\n  <ERPLayout>\n    <div class=\"modules-wrapper\">\n      <div class=\"d-flex justify-content-between align-items-center mb-4\">\n        <div>\n          <h2 class=\"mb-1\">نظام إدارة الموديولات (Add-ons)</h2>\n          <p class=\"text-muted\">التحكم في تفعيل أو إيقاف الميزات الإضافية للنظام</p>\n        </div>\n        <button class=\"btn btn-primary shadow-sm\" @click=\"fetchModules\">\n          <i class=\"ri-refresh-line\"></i> تحديث القائمة\n        </button>\n      </div>\n\n      <div class=\"row g-4\">\n        <!-- Module Card -->\n        <div class=\"col-md-4\" v-for=\"module in modules\" :key=\"module.id\">\n          <div class=\"card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden\">\n            <!-- Active indicator ribbon -->\n            <div v-if=\"module.is_active\" class=\"position-absolute bg-success text-white px-3 py-1\" style=\"top: 15px; right: -25px; transform: rotate(45deg); font-size: 0.75rem; width: 100px; text-align: center; z-index: 1;\">\n               مفعل\n            </div>\n\n            <div class=\"card-body p-4\">\n              <div class=\"d-flex align-items-center mb-3\">\n                <div class=\"icon-box rounded-circle p-3 me-3 text-white d-flex align-items-center justify-content-center\" :style=\"{ backgroundColor: module.color, width: '50px', height: '50px' }\">\n                  <i :class=\"module.icon\" class=\"fs-4\"></i>\n                </div>\n                <div>\n                  <h5 class=\"mb-0 fw-bold\">{{ module.name }}</h5>\n                  <small class=\"text-muted text-uppercase\">v{{ module.version }} • {{ module.alias }}</small>\n                </div>\n              </div>\n              <p class=\"text-secondary\" style=\"min-height: 50px;\">\n                {{ module.description || 'لا يوجد وصف متاح.' }}\n              </p>\n            </div>\n            <div class=\"card-footer bg-white border-0 p-4 pt-0 d-flex justify-content-end align-items-center gap-2\">\n              <div class=\"form-check form-switch fs-5 m-0\" v-if=\"module.alias !== 'core'\">\n                <input class=\"form-check-input cursor-pointer\" type=\"checkbox\" :id=\"'module_' + module.alias\" :checked=\"module.is_active\" @change=\"toggleModule(module, $event.target.checked)\">\n              </div>\n              <span v-else class=\"badge bg-secondary\">System Core</span>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </ERPLayout>\n</template>\n\n<script setup>\nimport { ref, onMounted } from 'vue';\nimport axios from 'axios';\nimport ERPLayout from '../../layouts/ERPLayout.vue';\n\nconst modules = ref([]);\n\nconst fetchModules = async () => {\n  try {\n    const response = await axios.get('/api/erp/modules');\n    modules.value = response.data;\n  } catch (error) {\n    console.error('Error fetching modules', error);\n  }\n};\n\nconst toggleModule = async (module, status) => {\n  const action = status ? 'enable' : 'disable';\n  // Optimistic UI update\n  module.is_active = status; \n  \n  try {\n    await axios.post(`/api/erp/modules/${module.alias}/${action}`);\n    // Reload the page to register new routes and state if necessary\n    window.location.reload();\n  } catch (error) {\n    console.error(`Error trying to ${action} module:`, error);\n    // Revert UI if failed\n    module.is_active = !status;\n    alert('حدث خطأ أثناء تغيير حالة الموديول');\n  }\n};\n\nonMounted(() => {\n  fetchModules();\n});\n</script>\n\n<style scoped>\n.cursor-pointer {\n  cursor: pointer;\n}\n.icon-box {\n  width: 50px;\n  height: 50px;\n}\n</style>\n"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_style_index_0_id_7b4bd8e6_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_style_index_0_id_7b4bd8e6_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_style_index_0_id_7b4bd8e6_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_style_index_0_id_e1e6a42a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_style_index_0_id_e1e6a42a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_style_index_0_id_e1e6a42a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/erp/layouts/ERPLayout.vue":
/*!************************************************!*\
  !*** ./resources/js/erp/layouts/ERPLayout.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ERPLayout_vue_vue_type_template_id_7b4bd8e6_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true */ "./resources/js/erp/layouts/ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true");
/* harmony import */ var _ERPLayout_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ERPLayout.vue?vue&type=script&setup=true&lang=js */ "./resources/js/erp/layouts/ERPLayout.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _ERPLayout_vue_vue_type_style_index_0_id_7b4bd8e6_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css */ "./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_ERPLayout_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_ERPLayout_vue_vue_type_template_id_7b4bd8e6_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-7b4bd8e6"],['__file',"resources/js/erp/layouts/ERPLayout.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/erp/layouts/ERPLayout.vue?vue&type=script&setup=true&lang=js":
/*!***********************************************************************************!*\
  !*** ./resources/js/erp/layouts/ERPLayout.vue?vue&type=script&setup=true&lang=js ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ERPLayout.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css":
/*!********************************************************************************************************!*\
  !*** ./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_style_index_0_id_7b4bd8e6_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=style&index=0&id=7b4bd8e6&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/erp/layouts/ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true":
/*!******************************************************************************************!*\
  !*** ./resources/js/erp/layouts/ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_template_id_7b4bd8e6_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ERPLayout_vue_vue_type_template_id_7b4bd8e6_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/layouts/ERPLayout.vue?vue&type=template&id=7b4bd8e6&scoped=true");


/***/ }),

/***/ "./resources/js/erp/views/System/ModulesManager.vue":
/*!**********************************************************!*\
  !*** ./resources/js/erp/views/System/ModulesManager.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ModulesManager_vue_vue_type_template_id_e1e6a42a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true */ "./resources/js/erp/views/System/ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true");
/* harmony import */ var _ModulesManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModulesManager.vue?vue&type=script&setup=true&lang=js */ "./resources/js/erp/views/System/ModulesManager.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _ModulesManager_vue_vue_type_style_index_0_id_e1e6a42a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css */ "./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_ModulesManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_ModulesManager_vue_vue_type_template_id_e1e6a42a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-e1e6a42a"],['__file',"resources/js/erp/views/System/ModulesManager.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/erp/views/System/ModulesManager.vue?vue&type=script&setup=true&lang=js":
/*!*********************************************************************************************!*\
  !*** ./resources/js/erp/views/System/ModulesManager.vue?vue&type=script&setup=true&lang=js ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModulesManager.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_style_index_0_id_e1e6a42a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=style&index=0&id=e1e6a42a&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/erp/views/System/ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true":
/*!****************************************************************************************************!*\
  !*** ./resources/js/erp/views/System/ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_template_id_e1e6a42a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_ModulesManager_vue_vue_type_template_id_e1e6a42a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/System/ModulesManager.vue?vue&type=template&id=e1e6a42a&scoped=true");


/***/ })

}]);
//# sourceMappingURL=resources_js_erp_views_System_ModulesManager_vue.js.map?id=f276dbfde2818f10