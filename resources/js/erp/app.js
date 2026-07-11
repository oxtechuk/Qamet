import './public-path.js';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import i18n from './i18n';
import axios from 'axios';

// Ensure Bootstrap is available if needed, usually loaded globally
// import 'bootstrap'; 

// Axios Default Configuration
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Configure base URL if API is separate, currently same origin

import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

const app = createApp(App);

// Use Plugins
app.use(router);
app.use(i18n);
app.use(Toast, {
    position: 'top-right',
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: 'button',
    icon: true,
    rtl: true
});

// Mount the Vue application
app.mount('#erp-app');
