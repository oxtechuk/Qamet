"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_erp_views_Auth_Login_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=script&setup=true&lang=js":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=script&setup=true&lang=js ***!
  \**************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.mjs");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! axios */ "./node_modules/axios/lib/axios.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return r; }; var t, r = {}, e = Object.prototype, n = e.hasOwnProperty, o = "function" == typeof Symbol ? Symbol : {}, i = o.iterator || "@@iterator", a = o.asyncIterator || "@@asyncIterator", u = o.toStringTag || "@@toStringTag"; function c(t, r, e, n) { return Object.defineProperty(t, r, { value: e, enumerable: !n, configurable: !n, writable: !n }); } try { c({}, ""); } catch (t) { c = function c(t, r, e) { return t[r] = e; }; } function h(r, e, n, o) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype); return c(a, "_invoke", function (r, e, n) { var o = 1; return function (i, a) { if (3 === o) throw Error("Generator is already running"); if (4 === o) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var u = n.delegate; if (u) { var c = d(u, n); if (c) { if (c === f) continue; return c; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (1 === o) throw o = 4, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = 3; var h = s(r, e, n); if ("normal" === h.type) { if (o = n.done ? 4 : 2, h.arg === f) continue; return { value: h.arg, done: n.done }; } "throw" === h.type && (o = 4, n.method = "throw", n.arg = h.arg); } }; }(r, n, new Context(o || [])), !0), a; } function s(t, r, e) { try { return { type: "normal", arg: t.call(r, e) }; } catch (t) { return { type: "throw", arg: t }; } } r.wrap = h; var f = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var l = {}; c(l, i, function () { return this; }); var p = Object.getPrototypeOf, y = p && p(p(x([]))); y && y !== e && n.call(y, i) && (l = y); var v = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(l); function g(t) { ["next", "throw", "return"].forEach(function (r) { c(t, r, function (t) { return this._invoke(r, t); }); }); } function AsyncIterator(t, r) { function e(o, i, a, u) { var c = s(t[o], t, i); if ("throw" !== c.type) { var h = c.arg, f = h.value; return f && "object" == _typeof(f) && n.call(f, "__await") ? r.resolve(f.__await).then(function (t) { e("next", t, a, u); }, function (t) { e("throw", t, a, u); }) : r.resolve(f).then(function (t) { h.value = t, a(h); }, function (t) { return e("throw", t, a, u); }); } u(c.arg); } var o; c(this, "_invoke", function (t, n) { function i() { return new r(function (r, o) { e(t, n, r, o); }); } return o = o ? o.then(i, i) : i(); }, !0); } function d(r, e) { var n = e.method, o = r.i[n]; if (o === t) return e.delegate = null, "throw" === n && r.i["return"] && (e.method = "return", e.arg = t, d(r, e), "throw" === e.method) || "return" !== n && (e.method = "throw", e.arg = new TypeError("The iterator does not provide a '" + n + "' method")), f; var i = s(o, r.i, e.arg); if ("throw" === i.type) return e.method = "throw", e.arg = i.arg, e.delegate = null, f; var a = i.arg; return a ? a.done ? (e[r.r] = a.value, e.next = r.n, "return" !== e.method && (e.method = "next", e.arg = t), e.delegate = null, f) : a : (e.method = "throw", e.arg = new TypeError("iterator result is not an object"), e.delegate = null, f); } function w(t) { this.tryEntries.push(t); } function m(r) { var e = r[4] || {}; e.type = "normal", e.arg = t, r[4] = e; } function Context(t) { this.tryEntries = [[-1]], t.forEach(w, this), this.reset(!0); } function x(r) { if (null != r) { var e = r[i]; if (e) return e.call(r); if ("function" == typeof r.next) return r; if (!isNaN(r.length)) { var o = -1, a = function e() { for (; ++o < r.length;) if (n.call(r, o)) return e.value = r[o], e.done = !1, e; return e.value = t, e.done = !0, e; }; return a.next = a; } } throw new TypeError(_typeof(r) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, c(v, "constructor", GeneratorFunctionPrototype), c(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = c(GeneratorFunctionPrototype, u, "GeneratorFunction"), r.isGeneratorFunction = function (t) { var r = "function" == typeof t && t.constructor; return !!r && (r === GeneratorFunction || "GeneratorFunction" === (r.displayName || r.name)); }, r.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, c(t, u, "GeneratorFunction")), t.prototype = Object.create(v), t; }, r.awrap = function (t) { return { __await: t }; }, g(AsyncIterator.prototype), c(AsyncIterator.prototype, a, function () { return this; }), r.AsyncIterator = AsyncIterator, r.async = function (t, e, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(h(t, e, n, o), i); return r.isGeneratorFunction(e) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, g(v), c(v, u, "Generator"), c(v, i, function () { return this; }), c(v, "toString", function () { return "[object Generator]"; }), r.keys = function (t) { var r = Object(t), e = []; for (var n in r) e.unshift(n); return function t() { for (; e.length;) if ((n = e.pop()) in r) return t.value = n, t.done = !1, t; return t.done = !0, t; }; }, r.values = x, Context.prototype = { constructor: Context, reset: function reset(r) { if (this.prev = this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(m), !r) for (var e in this) "t" === e.charAt(0) && n.call(this, e) && !isNaN(+e.slice(1)) && (this[e] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0][4]; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(r) { if (this.done) throw r; var e = this; function n(t) { a.type = "throw", a.arg = r, e.next = t; } for (var o = e.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i[4], u = this.prev, c = i[1], h = i[2]; if (-1 === i[0]) return n("end"), !1; if (!c && !h) throw Error("try statement without catch or finally"); if (null != i[0] && i[0] <= u) { if (u < c) return this.method = "next", this.arg = t, n(c), !0; if (u < h) return n(h), !1; } } }, abrupt: function abrupt(t, r) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var n = this.tryEntries[e]; if (n[0] > -1 && n[0] <= this.prev && this.prev < n[2]) { var o = n; break; } } o && ("break" === t || "continue" === t) && o[0] <= r && r <= o[2] && (o = null); var i = o ? o[4] : {}; return i.type = t, i.arg = r, o ? (this.method = "next", this.next = o[2], f) : this.complete(i); }, complete: function complete(t, r) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && r && (this.next = r), f; }, finish: function finish(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[2] === t) return this.complete(e[4], e[3]), m(e), f; } }, "catch": function _catch(t) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var e = this.tryEntries[r]; if (e[0] === t) { var n = e[4]; if ("throw" === n.type) { var o = n.arg; m(e); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(r, e, n) { return this.delegate = { i: x(r), r: e, n: n }, "next" === this.method && (this.arg = t), f; } }, r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Login',
  setup: function setup(__props, _ref) {
    var __expose = _ref.expose;
    __expose();
    var router = (0,vue_router__WEBPACK_IMPORTED_MODULE_1__.useRouter)();
    var loading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var errorMsg = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)('');
    var form = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)({
      email: '',
      password: '',
      remember: false
    });
    var handleLogin = /*#__PURE__*/function () {
      var _ref2 = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var response;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              loading.value = true;
              errorMsg.value = '';
              _context.prev = 2;
              _context.next = 5;
              return axios__WEBPACK_IMPORTED_MODULE_2__["default"].get('/sanctum/csrf-cookie');
            case 5:
              _context.next = 7;
              return axios__WEBPACK_IMPORTED_MODULE_2__["default"].post('/api/erp/login', form.value);
            case 7:
              response = _context.sent;
              // On success, redirect to dashboard
              router.push({
                name: 'Dashboard'
              });
              _context.next = 15;
              break;
            case 11:
              _context.prev = 11;
              _context.t0 = _context["catch"](2);
              errorMsg.value = "البيانات المدخلة غير صحيحة، يرجى المحاولة مرة أخرى.";
              console.error("Login Error", _context.t0);
            case 15:
              _context.prev = 15;
              loading.value = false;
              return _context.finish(15);
            case 18:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[2, 11, 15, 18]]);
      }));
      return function handleLogin() {
        return _ref2.apply(this, arguments);
      };
    }();
    var __returned__ = {
      router: router,
      loading: loading,
      errorMsg: errorMsg,
      form: form,
      handleLogin: handleLogin,
      ref: vue__WEBPACK_IMPORTED_MODULE_0__.ref,
      get useRouter() {
        return vue_router__WEBPACK_IMPORTED_MODULE_1__.useRouter;
      },
      get axios() {
        return axios__WEBPACK_IMPORTED_MODULE_2__["default"];
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=template&id=63fb93ad&scoped=true":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=template&id=63fb93ad&scoped=true ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "login-wrapper vh-100 d-flex align-items-center justify-content-center bg-light",
  dir: "rtl"
};
var _hoisted_2 = {
  "class": "row w-100 shadow-lg rounded-4 overflow-hidden",
  style: {
    "max-width": "900px",
    "background": "#fff"
  }
};
var _hoisted_3 = {
  "class": "col-md-6 p-5 d-flex flex-column justify-content-center"
};
var _hoisted_4 = {
  "class": "mb-3"
};
var _hoisted_5 = {
  "class": "input-group"
};
var _hoisted_6 = {
  "class": "mb-4"
};
var _hoisted_7 = {
  "class": "input-group"
};
var _hoisted_8 = {
  "class": "d-flex justify-content-between mb-4"
};
var _hoisted_9 = {
  "class": "form-check"
};
var _hoisted_10 = ["disabled"];
var _hoisted_11 = {
  key: 0,
  "class": "spinner-border spinner-border-sm me-2"
};
var _hoisted_12 = {
  key: 0,
  "class": "alert alert-danger mt-3 py-2 text-center border-0 rounded-3"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [_cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"text-center mb-4\" data-v-63fb93ad><div class=\"brand-box bg-dark text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3\" style=\"width:70px;height:70px;\" data-v-63fb93ad><i class=\"ri-car-fill fs-1\" data-v-63fb93ad></i></div><h2 class=\"fw-bold\" data-v-63fb93ad>GR-Motors ERP</h2><p class=\"text-muted\" data-v-63fb93ad>نظام إدارة المعرض المتكامل</p></div>", 1)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    onSubmit: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)($setup.handleLogin, ["prevent"])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [_cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "form-label text-muted fw-bold"
  }, "البريد الإلكتروني", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [_cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "input-group-text bg-white border-end-0"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "ri-mail-line text-muted"
  })], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $setup.form.email = $event;
    }),
    type: "email",
    "class": "form-control border-start-0 ps-0",
    placeholder: "admin@erp.local",
    required: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.form.email]])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [_cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "form-label text-muted fw-bold"
  }, "كلمة المرور", -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [_cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "input-group-text bg-white border-end-0"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "ri-lock-2-line text-muted"
  })], -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $setup.form.password = $event;
    }),
    type: "password",
    "class": "form-control border-start-0 ps-0",
    placeholder: "••••••••",
    required: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.form.password]])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "class": "form-check-input",
    type: "checkbox",
    id: "remember",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $setup.form.remember = $event;
    })
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $setup.form.remember]]), _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "class": "form-check-label text-muted",
    "for": "remember"
  }, "تذكرني", -1 /* CACHED */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "submit",
    "class": "btn btn-primary w-100 py-2 fw-bold",
    disabled: $setup.loading
  }, [$setup.loading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_11)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), _cache[8] || (_cache[8] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" تسجيل الدخول ", -1 /* CACHED */)), _cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "ri-arrow-left-line ms-1"
  }, null, -1 /* CACHED */))], 8 /* PROPS */, _hoisted_10)], 32 /* NEED_HYDRATION */), $setup.errorMsg ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_12, [_cache[10] || (_cache[10] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "ri-error-warning-line align-middle me-1"
  }, null, -1 /* CACHED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.errorMsg), 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), _cache[12] || (_cache[12] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"col-md-6 d-none d-md-block p-0 position-relative\" data-v-63fb93ad><div class=\"bg-gradient-primary w-100 h-100 justify-content-center align-items-center d-flex position-relative overflow-hidden\" data-v-63fb93ad><div class=\"circle-decoration position-absolute\" data-v-63fb93ad></div><div class=\"text-white text-center position-relative z-1 p-5\" data-v-63fb93ad><h2 class=\"fw-bold mb-3\" data-v-63fb93ad>مرحباً بعودتك!</h2><p class=\"opacity-75\" data-v-63fb93ad>لقد قمنا بترقية النظام ليصبح نظام تخطيط وأتمتة شامل يجمع المبيعات والمخازن والعملاء في واجهة واحدة فائقة السرعة.</p></div></div></div>", 1))])]);
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.bg-gradient-primary[data-v-63fb93ad] {\n    background: linear-gradient(135deg, #2b32b2 0%, #1488cc 100%);\n    background-color: var(--primary);\n}\n.circle-decoration[data-v-63fb93ad] {\n    width: 400px;\n    height: 400px;\n    border-radius: 50%;\n    background: rgba(255, 255, 255, 0.1);\n    top: -100px;\n    right: -100px;\n}\n.form-control[data-v-63fb93ad]:focus {\n    box-shadow: none;\n    border-color: #dee2e6;\n}\n.input-group-text[data-v-63fb93ad] {\n    border-color: #dee2e6;\n}\n.form-control[data-v-63fb93ad] {\n    border-color: #dee2e6;\n}\n", "",{"version":3,"sources":["webpack://./resources/js/erp/views/Auth/Login.vue"],"names":[],"mappings":";AAoGA;IACI,6DAA6D;IAC7D,gCAAgC;AACpC;AACA;IACI,YAAY;IACZ,aAAa;IACb,kBAAkB;IAClB,oCAAoC;IACpC,WAAW;IACX,aAAa;AACjB;AACA;IACI,gBAAgB;IAChB,qBAAqB;AACzB;AACA;IACI,qBAAqB;AACzB;AACA;IACI,qBAAqB;AACzB","sourcesContent":["<template>\n  <div class=\"login-wrapper vh-100 d-flex align-items-center justify-content-center bg-light\" dir=\"rtl\">\n    <div class=\"row w-100 shadow-lg rounded-4 overflow-hidden\" style=\"max-width: 900px; background: #fff;\">\n      <div class=\"col-md-6 p-5 d-flex flex-column justify-content-center\">\n        <div class=\"text-center mb-4\">\n           <div class=\"brand-box bg-dark text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3\" style=\"width: 70px; height: 70px;\">\n              <i class=\"ri-car-fill fs-1\"></i>\n           </div>\n          <h2 class=\"fw-bold\">GR-Motors ERP</h2>\n          <p class=\"text-muted\">نظام إدارة المعرض المتكامل</p>\n        </div>\n        \n        <form @submit.prevent=\"handleLogin\">\n          <div class=\"mb-3\">\n            <label class=\"form-label text-muted fw-bold\">البريد الإلكتروني</label>\n            <div class=\"input-group\">\n                <span class=\"input-group-text bg-white border-end-0\"><i class=\"ri-mail-line text-muted\"></i></span>\n                <input v-model=\"form.email\" type=\"email\" class=\"form-control border-start-0 ps-0\" placeholder=\"admin@erp.local\" required>\n            </div>\n          </div>\n          \n          <div class=\"mb-4\">\n            <label class=\"form-label text-muted fw-bold\">كلمة المرور</label>\n            <div class=\"input-group\">\n                <span class=\"input-group-text bg-white border-end-0\"><i class=\"ri-lock-2-line text-muted\"></i></span>\n                <input v-model=\"form.password\" type=\"password\" class=\"form-control border-start-0 ps-0\" placeholder=\"••••••••\" required>\n            </div>\n          </div>\n          \n          <div class=\"d-flex justify-content-between mb-4\">\n            <div class=\"form-check\">\n              <input class=\"form-check-input\" type=\"checkbox\" id=\"remember\" v-model=\"form.remember\">\n              <label class=\"form-check-label text-muted\" for=\"remember\">تذكرني</label>\n            </div>\n          </div>\n          \n          <button type=\"submit\" class=\"btn btn-primary w-100 py-2 fw-bold\" :disabled=\"loading\">\n            <span v-if=\"loading\" class=\"spinner-border spinner-border-sm me-2\"></span>\n            تسجيل الدخول <i class=\"ri-arrow-left-line ms-1\"></i>\n          </button>\n        </form>\n\n        <div v-if=\"errorMsg\" class=\"alert alert-danger mt-3 py-2 text-center border-0 rounded-3\">\n            <i class=\"ri-error-warning-line align-middle me-1\"></i> {{ errorMsg }}\n        </div>\n      </div>\n      \n      <div class=\"col-md-6 d-none d-md-block p-0 position-relative\">\n        <div class=\"bg-gradient-primary w-100 h-100 justify-content-center align-items-center d-flex position-relative overflow-hidden\">\n            <div class=\"circle-decoration position-absolute\"></div>\n            <div class=\"text-white text-center position-relative z-1 p-5\">\n                <h2 class=\"fw-bold mb-3\">مرحباً بعودتك!</h2>\n                <p class=\"opacity-75\">لقد قمنا بترقية النظام ليصبح نظام تخطيط وأتمتة شامل يجمع المبيعات والمخازن والعملاء في واجهة واحدة فائقة السرعة.</p>\n            </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</template>\n\n<script setup>\nimport { ref } from 'vue';\nimport { useRouter } from 'vue-router';\nimport axios from 'axios';\n\nconst router = useRouter();\nconst loading = ref(false);\nconst errorMsg = ref('');\n\nconst form = ref({\n  email: '',\n  password: '',\n  remember: false\n});\n\nconst handleLogin = async () => {\n    loading.value = true;\n    errorMsg.value = '';\n    try {\n        // Fetch Sanctum CSRF Cookie\n        await axios.get('/sanctum/csrf-cookie');\n        \n        // Use standard laravel api login or directly fallback to crm login logic\n        // Because the user previously used the CRM AuthController for employees and User for SuperAdmin\n        // We will make a generic API login endpoint in our api core later if needed, \n        // For now, post to the standard Laravel login or specialized web login API\n        const response = await axios.post('/api/erp/login', form.value);\n        \n        // On success, redirect to dashboard\n        router.push({ name: 'Dashboard' });\n    } catch (error) {\n        errorMsg.value = \"البيانات المدخلة غير صحيحة، يرجى المحاولة مرة أخرى.\";\n        console.error(\"Login Error\", error);\n    } finally {\n        loading.value = false;\n    }\n};\n</script>\n\n<style scoped>\n.bg-gradient-primary {\n    background: linear-gradient(135deg, #2b32b2 0%, #1488cc 100%);\n    background-color: var(--primary);\n}\n.circle-decoration {\n    width: 400px;\n    height: 400px;\n    border-radius: 50%;\n    background: rgba(255, 255, 255, 0.1);\n    top: -100px;\n    right: -100px;\n}\n.form-control:focus {\n    box-shadow: none;\n    border-color: #dee2e6;\n}\n.input-group-text {\n    border-color: #dee2e6;\n}\n.form-control {\n    border-color: #dee2e6;\n}\n</style>\n"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_style_index_0_id_63fb93ad_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_style_index_0_id_63fb93ad_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_style_index_0_id_63fb93ad_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/erp/views/Auth/Login.vue":
/*!***********************************************!*\
  !*** ./resources/js/erp/views/Auth/Login.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Login_vue_vue_type_template_id_63fb93ad_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Login.vue?vue&type=template&id=63fb93ad&scoped=true */ "./resources/js/erp/views/Auth/Login.vue?vue&type=template&id=63fb93ad&scoped=true");
/* harmony import */ var _Login_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Login.vue?vue&type=script&setup=true&lang=js */ "./resources/js/erp/views/Auth/Login.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _Login_vue_vue_type_style_index_0_id_63fb93ad_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css */ "./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Login_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Login_vue_vue_type_template_id_63fb93ad_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-63fb93ad"],['__file',"resources/js/erp/views/Auth/Login.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/erp/views/Auth/Login.vue?vue&type=script&setup=true&lang=js":
/*!**********************************************************************************!*\
  !*** ./resources/js/erp/views/Auth/Login.vue?vue&type=script&setup=true&lang=js ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Login.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_style_index_0_id_63fb93ad_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=style&index=0&id=63fb93ad&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/erp/views/Auth/Login.vue?vue&type=template&id=63fb93ad&scoped=true":
/*!*****************************************************************************************!*\
  !*** ./resources/js/erp/views/Auth/Login.vue?vue&type=template&id=63fb93ad&scoped=true ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_template_id_63fb93ad_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Login_vue_vue_type_template_id_63fb93ad_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Login.vue?vue&type=template&id=63fb93ad&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Auth/Login.vue?vue&type=template&id=63fb93ad&scoped=true");


/***/ })

}]);
//# sourceMappingURL=resources_js_erp_views_Auth_Login_vue.js.map?id=7c54663d1e04767d