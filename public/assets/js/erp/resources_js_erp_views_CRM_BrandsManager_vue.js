"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_erp_views_CRM_BrandsManager_vue"],{

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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=script&setup=true&lang=js":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=script&setup=true&lang=js ***!
  \*********************************************************************************************************************************************************************************************************************/
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
  __name: 'BrandsManager',
  setup: function setup(__props, _ref) {
    var __expose = _ref.expose;
    __expose();
    var brands = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)([]);
    var pagination = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)({
      current: 1,
      last: 1,
      total: 0,
      per_page: 20
    });
    var fetchBrands = /*#__PURE__*/function () {
      var _ref2 = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var page,
          response,
          _args = arguments;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              page = _args.length > 0 && _args[0] !== undefined ? _args[0] : 1;
              _context.prev = 1;
              _context.next = 4;
              return axios__WEBPACK_IMPORTED_MODULE_2__["default"].get("/api/erp/crm/brands?page=".concat(page));
            case 4:
              response = _context.sent;
              brands.value = response.data.data;
              pagination.value = {
                current: response.data.current_page,
                last: response.data.last_page,
                total: response.data.total,
                per_page: response.data.per_page,
                next: response.data.next_page_url,
                prev: response.data.prev_page_url
              };
              _context.next = 12;
              break;
            case 9:
              _context.prev = 9;
              _context.t0 = _context["catch"](1);
              console.error("Error fetching brands", _context.t0);
            case 12:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[1, 9]]);
      }));
      return function fetchBrands() {
        return _ref2.apply(this, arguments);
      };
    }();
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      return fetchBrands();
    });
    var __returned__ = {
      brands: brands,
      pagination: pagination,
      fetchBrands: fetchBrands,
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "brands-manager"
};
var _hoisted_2 = {
  "class": "row"
};
var _hoisted_3 = {
  "class": "card border-0 shadow-sm rounded-4 h-100 position-relative brand-card"
};
var _hoisted_4 = {
  "class": "card-body text-center p-4"
};
var _hoisted_5 = ["src", "alt"];
var _hoisted_6 = {
  key: 1,
  "class": "ri-steering-2-line text-muted fs-1"
};
var _hoisted_7 = {
  "class": "fw-bold mb-1"
};
var _hoisted_8 = {
  "class": "mb-3"
};
var _hoisted_9 = {
  "class": "badge bg-light text-dark border"
};
var _hoisted_10 = {
  "class": "position-absolute top-0 end-0 p-3"
};
var _hoisted_11 = ["title"];
var _hoisted_12 = {
  key: 0,
  "class": "d-flex justify-content-center mt-3"
};
var _hoisted_13 = ["disabled"];
var _hoisted_14 = {
  "class": "btn btn-light",
  style: {
    "cursor": "default"
  }
};
var _hoisted_15 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["ERPLayout"], null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "d-flex justify-content-between align-items-center mb-4"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
        "class": "mb-1 text-indigo fw-bold"
      }, "إدارة الماركات (Brands)"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
        "class": "text-muted"
      }, "التحكم في ماركات السيارات وشعاراتها المتاحة بالمعرض")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-indigo shadow px-4"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-add-circle-line me-2"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" إضافة ماركة جديدة ")])], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.brands, function (brand) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          "class": "col-md-3 mb-4",
          key: brand.id
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["brand-logo shadow-sm mb-3 mx-auto d-flex align-items-center justify-content-center bg-white", {
            'border-danger': !brand.is_active
          }])
        }, [brand.logo ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("img", {
          key: 0,
          src: '/storage/' + brand.logo,
          "class": "img-fluid p-2",
          alt: brand.name.ar
        }, null, 8 /* PROPS */, _hoisted_5)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("i", _hoisted_6))], 2 /* CLASS */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(brand.name.ar || brand.name.en), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(brand.cars_count) + " سيارة مسجلة", 1 /* TEXT */)]), _cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
          "class": "d-flex justify-content-center gap-2"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
          "class": "btn btn-sm btn-outline-secondary px-3"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
          "class": "ri-edit-line"
        }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" تعديل")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
          "class": "btn btn-sm btn-outline-danger px-3"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
          "class": "ri-delete-bin-line"
        })])], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Status Badge "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
          "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["badge rounded-circle p-2", brand.is_active ? 'bg-success' : 'bg-danger']),
          title: brand.is_active ? 'مفعل' : 'موقف'
        }, null, 10 /* CLASS, PROPS */, _hoisted_11)])])]);
      }), 128 /* KEYED_FRAGMENT */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Pagination "), $setup.pagination.total > $setup.pagination.per_page ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-outline-indigo border-0 me-2",
        disabled: !$setup.pagination.prev,
        onClick: _cache[0] || (_cache[0] = function ($event) {
          return $setup.fetchBrands($setup.pagination.current - 1);
        })
      }, "السابق", 8 /* PROPS */, _hoisted_13), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_14, "صفحة " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.pagination.current) + " من " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.pagination.last), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "btn btn-outline-indigo border-0 ms-2",
        disabled: !$setup.pagination.next,
        onClick: _cache[1] || (_cache[1] = function ($event) {
          return $setup.fetchBrands($setup.pagination.current + 1);
        })
      }, "التالي", 8 /* PROPS */, _hoisted_15)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.text-indigo[data-v-d5dbe216] { color: #6610f2;\n}\n.btn-indigo[data-v-d5dbe216] { background-color: #6610f2; color: #fff;\n}\n.btn-outline-indigo[data-v-d5dbe216] { border-color: #6610f2; color: #6610f2;\n}\n.btn-outline-indigo[data-v-d5dbe216]:hover { background-color: #6610f2; color: #fff;\n}\n.brand-logo[data-v-d5dbe216] {\n    width: 80px; height: 80px;\n    border-radius: 50%;\n    border: 3px solid #f8f9fa;\n    overflow: hidden;\n}\n.brand-card[data-v-d5dbe216] {\n    transition: transform 0.3s ease, box-shadow 0.3s ease;\n}\n.brand-card[data-v-d5dbe216]:hover {\n    transform: translateY(-5px);\n    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;\n}\n", "",{"version":3,"sources":["webpack://./resources/js/erp/views/CRM/BrandsManager.vue"],"names":[],"mappings":";AAgFA,gCAAe,cAAc;AAAE;AAC/B,+BAAc,yBAAyB,EAAE,WAAW;AAAE;AACtD,uCAAsB,qBAAqB,EAAE,cAAc;AAAE;AAC7D,6CAA4B,yBAAyB,EAAE,WAAW;AAAE;AACpE;IACI,WAAW,EAAE,YAAY;IACzB,kBAAkB;IAClB,yBAAyB;IACzB,gBAAgB;AACpB;AACA;IACI,qDAAqD;AACzD;AACA;IACI,2BAA2B;IAC3B,kDAAkD;AACtD","sourcesContent":["<template>\n  <ERPLayout>\n    <div class=\"brands-manager\">\n      <div class=\"d-flex justify-content-between align-items-center mb-4\">\n        <div>\n          <h2 class=\"mb-1 text-indigo fw-bold\">إدارة الماركات (Brands)</h2>\n          <p class=\"text-muted\">التحكم في ماركات السيارات وشعاراتها المتاحة بالمعرض</p>\n        </div>\n        <button class=\"btn btn-indigo shadow px-4\">\n          <i class=\"ri-add-circle-line me-2\"></i> إضافة ماركة جديدة\n        </button>\n      </div>\n\n      <div class=\"row\">\n        <div class=\"col-md-3 mb-4\" v-for=\"brand in brands\" :key=\"brand.id\">\n            <div class=\"card border-0 shadow-sm rounded-4 h-100 position-relative brand-card\">\n                <div class=\"card-body text-center p-4\">\n                    <div class=\"brand-logo shadow-sm mb-3 mx-auto d-flex align-items-center justify-content-center bg-white\" \n                         :class=\"{'border-danger': !brand.is_active}\">\n                        <img v-if=\"brand.logo\" :src=\"'/storage/' + brand.logo\" class=\"img-fluid p-2\" :alt=\"brand.name.ar\">\n                        <i v-else class=\"ri-steering-2-line text-muted fs-1\"></i>\n                    </div>\n                    <h5 class=\"fw-bold mb-1\">{{ brand.name.ar || brand.name.en }}</h5>\n                    <div class=\"mb-3\">\n                        <span class=\"badge bg-light text-dark border\">{{ brand.cars_count }} سيارة مسجلة</span>\n                    </div>\n                    \n                    <div class=\"d-flex justify-content-center gap-2\">\n                        <button class=\"btn btn-sm btn-outline-secondary px-3\"><i class=\"ri-edit-line\"></i> تعديل</button>\n                        <button class=\"btn btn-sm btn-outline-danger px-3\"><i class=\"ri-delete-bin-line\"></i></button>\n                    </div>\n                </div>\n                <!-- Status Badge -->\n                <div class=\"position-absolute top-0 end-0 p-3\">\n                    <span class=\"badge rounded-circle p-2\" :class=\"brand.is_active ? 'bg-success' : 'bg-danger'\" :title=\"brand.is_active ? 'مفعل' : 'موقف'\"> </span>\n                </div>\n            </div>\n        </div>\n      </div>\n      \n       <!-- Pagination -->\n      <div v-if=\"pagination.total > pagination.per_page\" class=\"d-flex justify-content-center mt-3\">\n        <button class=\"btn btn-outline-indigo border-0 me-2\" :disabled=\"!pagination.prev\" @click=\"fetchBrands(pagination.current - 1)\">السابق</button>\n        <span class=\"btn btn-light\" style=\"cursor:default\">صفحة {{ pagination.current }} من {{ pagination.last }}</span>\n        <button class=\"btn btn-outline-indigo border-0 ms-2\" :disabled=\"!pagination.next\" @click=\"fetchBrands(pagination.current + 1)\">التالي</button>\n      </div>\n\n    </div>\n  </ERPLayout>\n</template>\n\n<script setup>\nimport { ref, onMounted } from 'vue';\nimport axios from 'axios';\nimport ERPLayout from '../../layouts/ERPLayout.vue';\n\nconst brands = ref([]);\nconst pagination = ref({ current: 1, last: 1, total: 0, per_page: 20 });\n\nconst fetchBrands = async (page = 1) => {\n    try {\n        const response = await axios.get(`/api/erp/crm/brands?page=${page}`);\n        brands.value = response.data.data;\n        pagination.value = {\n            current: response.data.current_page,\n            last: response.data.last_page,\n            total: response.data.total,\n            per_page: response.data.per_page,\n            next: response.data.next_page_url,\n            prev: response.data.prev_page_url,\n        };\n    } catch (error) {\n        console.error(\"Error fetching brands\", error);\n    }\n};\n\nonMounted(() => fetchBrands());\n</script>\n\n<style scoped>\n.text-indigo { color: #6610f2; }\n.btn-indigo { background-color: #6610f2; color: #fff; }\n.btn-outline-indigo { border-color: #6610f2; color: #6610f2; }\n.btn-outline-indigo:hover { background-color: #6610f2; color: #fff; }\n.brand-logo {\n    width: 80px; height: 80px;\n    border-radius: 50%;\n    border: 3px solid #f8f9fa;\n    overflow: hidden;\n}\n.brand-card {\n    transition: transform 0.3s ease, box-shadow 0.3s ease;\n}\n.brand-card:hover {\n    transform: translateY(-5px);\n    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;\n}\n</style>\n"],"sourceRoot":""}]);
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

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_style_index_0_id_d5dbe216_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_style_index_0_id_d5dbe216_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_style_index_0_id_d5dbe216_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

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

/***/ "./resources/js/erp/views/CRM/BrandsManager.vue":
/*!******************************************************!*\
  !*** ./resources/js/erp/views/CRM/BrandsManager.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _BrandsManager_vue_vue_type_template_id_d5dbe216_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true */ "./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true");
/* harmony import */ var _BrandsManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BrandsManager.vue?vue&type=script&setup=true&lang=js */ "./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _BrandsManager_vue_vue_type_style_index_0_id_d5dbe216_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css */ "./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_BrandsManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_BrandsManager_vue_vue_type_template_id_d5dbe216_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-d5dbe216"],['__file',"resources/js/erp/views/CRM/BrandsManager.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=script&setup=true&lang=js":
/*!*****************************************************************************************!*\
  !*** ./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=script&setup=true&lang=js ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./BrandsManager.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_style_index_0_id_d5dbe216_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=style&index=0&id=d5dbe216&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true":
/*!************************************************************************************************!*\
  !*** ./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_template_id_d5dbe216_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_BrandsManager_vue_vue_type_template_id_d5dbe216_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/CRM/BrandsManager.vue?vue&type=template&id=d5dbe216&scoped=true");


/***/ })

}]);
//# sourceMappingURL=resources_js_erp_views_CRM_BrandsManager_vue.js.map?id=2b189c20513d76ae