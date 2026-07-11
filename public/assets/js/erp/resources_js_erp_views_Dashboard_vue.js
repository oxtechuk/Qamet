"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_erp_views_Dashboard_vue"],{

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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=script&setup=true&lang=js":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=script&setup=true&lang=js ***!
  \*************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _layouts_ERPLayout_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../layouts/ERPLayout.vue */ "./resources/js/erp/layouts/ERPLayout.vue");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Dashboard',
  setup: function setup(__props, _ref) {
    var __expose = _ref.expose;
    __expose();
    var __returned__ = {
      ERPLayout: _layouts_ERPLayout_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "dashboard-wrapper"
};
var _hoisted_2 = {
  "class": "d-flex justify-content-between align-items-center mb-4"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["ERPLayout"], null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.$t('common.dashboard')), 1 /* TEXT */)]), _cache[0] || (_cache[0] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "row g-4"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "col-md-3"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "card bg-white border-0 shadow-sm h-100 rounded-4"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "card-body"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "d-flex align-items-center justify-content-between"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", {
        "class": "text-muted mb-2"
      }, "Total Sales"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "mb-0 text-primary"
      }, "0 EGP")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "icon-box bg-primary-subtle text-primary rounded-circle p-3"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-money-dollar-circle-line fs-3"
      })])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "col-md-3"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "card bg-white border-0 shadow-sm h-100 rounded-4"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "card-body"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "d-flex align-items-center justify-content-between"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h6", {
        "class": "text-muted mb-2"
      }, "Active Offers"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
        "class": "mb-0 text-warning"
      }, "0")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "icon-box bg-warning-subtle text-warning rounded-circle p-3"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
        "class": "ri-file-list-3-line fs-3"
      })])])])])])], -1 /* CACHED */))])];
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "\n.icon-box[data-v-281b2ad9] {\n  width: 60px;\n  height: 60px;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n}\n", "",{"version":3,"sources":["webpack://./resources/js/erp/views/Dashboard.vue"],"names":[],"mappings":";AAiDA;EACE,WAAW;EACX,YAAY;EACZ,aAAa;EACb,mBAAmB;EACnB,uBAAuB;AACzB","sourcesContent":["<template>\n  <ERPLayout>\n    <div class=\"dashboard-wrapper\">\n      <div class=\"d-flex justify-content-between align-items-center mb-4\">\n        <h2>{{ $t('common.dashboard') }}</h2>\n      </div>\n\n      <div class=\"row g-4\">\n        <div class=\"col-md-3\">\n          <div class=\"card bg-white border-0 shadow-sm h-100 rounded-4\">\n            <div class=\"card-body\">\n              <div class=\"d-flex align-items-center justify-content-between\">\n                <div>\n                  <h6 class=\"text-muted mb-2\">Total Sales</h6>\n                  <h3 class=\"mb-0 text-primary\">0 EGP</h3>\n                </div>\n                <div class=\"icon-box bg-primary-subtle text-primary rounded-circle p-3\">\n                  <i class=\"ri-money-dollar-circle-line fs-3\"></i>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n\n        <div class=\"col-md-3\">\n          <div class=\"card bg-white border-0 shadow-sm h-100 rounded-4\">\n            <div class=\"card-body\">\n              <div class=\"d-flex align-items-center justify-content-between\">\n                <div>\n                  <h6 class=\"text-muted mb-2\">Active Offers</h6>\n                  <h3 class=\"mb-0 text-warning\">0</h3>\n                </div>\n                <div class=\"icon-box bg-warning-subtle text-warning rounded-circle p-3\">\n                  <i class=\"ri-file-list-3-line fs-3\"></i>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </ERPLayout>\n</template>\n\n<script setup>\nimport ERPLayout from '../layouts/ERPLayout.vue';\n</script>\n\n<style scoped>\n.icon-box {\n  width: 60px;\n  height: 60px;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n}\n</style>\n"],"sourceRoot":""}]);
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

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_style_index_0_id_281b2ad9_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_style_index_0_id_281b2ad9_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_style_index_0_id_281b2ad9_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

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

/***/ "./resources/js/erp/views/Dashboard.vue":
/*!**********************************************!*\
  !*** ./resources/js/erp/views/Dashboard.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Dashboard_vue_vue_type_template_id_281b2ad9_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true */ "./resources/js/erp/views/Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true");
/* harmony import */ var _Dashboard_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=script&setup=true&lang=js */ "./resources/js/erp/views/Dashboard.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _Dashboard_vue_vue_type_style_index_0_id_281b2ad9_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css */ "./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Dashboard_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Dashboard_vue_vue_type_template_id_281b2ad9_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-281b2ad9"],['__file',"resources/js/erp/views/Dashboard.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/erp/views/Dashboard.vue?vue&type=script&setup=true&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/erp/views/Dashboard.vue?vue&type=script&setup=true&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css":
/*!******************************************************************************************************!*\
  !*** ./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_style_index_0_id_281b2ad9_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=style&index=0&id=281b2ad9&scoped=true&lang=css");


/***/ }),

/***/ "./resources/js/erp/views/Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true":
/*!****************************************************************************************!*\
  !*** ./resources/js/erp/views/Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_template_id_281b2ad9_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_templateLoader_js_clonedRuleSet_27_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_template_id_281b2ad9_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/templateLoader.js??clonedRuleSet-27!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/erp/views/Dashboard.vue?vue&type=template&id=281b2ad9&scoped=true");


/***/ })

}]);
//# sourceMappingURL=resources_js_erp_views_Dashboard_vue.js.map?id=44c429ee52814987