// This file handles dynamic public path setting for Webpack lazy loading chunks in Vue router
if (window.ERP_BASE_URL) {
    __webpack_public_path__ = window.ERP_BASE_URL + '/';
}
