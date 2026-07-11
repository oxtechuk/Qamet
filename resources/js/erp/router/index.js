import { createRouter, createWebHistory } from 'vue-router';

// Lazy loading views
const Login = () => import('../views/Auth/Login.vue');
const Dashboard = () => import('../views/Dashboard.vue');
const ModulesManager = () => import('../views/System/ModulesManager.vue');
const Suppliers = () => import('../views/Purchasing/Suppliers.vue');

const routes = [
    {
        path: '/crm/login',
        name: 'Login',
        component: Login,
        meta: { title: 'تسجيل الدخول', guestOnly: true }
    },
    {
        path: '/crm',
        name: 'Dashboard',
        component: Dashboard,
        meta: { title: 'Dashboard', requiresAuth: true }
    },
    {
        path: '/crm/system/modules',
        name: 'ModulesManager',
        component: ModulesManager,
        meta: { title: 'إدارة الموديولات' }
    },
    {
        path: '/crm/purchasing/suppliers',
        name: 'Suppliers',
        component: Suppliers,
        meta: { title: 'الموردين' }
    },
    {
        path: '/crm/inventory/products',
        name: 'Products',
        component: () => import('../views/Inventory/Products.vue'),
        meta: { title: 'المنتجات' }
    },
    {
        path: '/crm/sales/clients',
        name: 'Clients',
        component: () => import('../views/Sales/Clients.vue'),
        meta: { title: 'العملاء' }
    },
    {
        path: '/crm/cars',
        name: 'CarsManager',
        component: () => import('../views/CRM/CarsManager.vue'),
        meta: { title: 'إدارة السيارات', requiresAuth: true }
    },
    {
        path: '/crm/brands',
        name: 'BrandsManager',
        component: () => import('../views/CRM/BrandsManager.vue'),
        meta: { title: 'الماركات والفئات', requiresAuth: true }
    },
    {
        path: '/crm/cms/settings',
        name: 'CmsSettings',
        component: () => import('../views/Cms/CmsSettings.vue'),
        meta: { title: 'إدارة محتوى المتجر', requiresAuth: true }
    },
    // We will add more routes for modules here later
];

const router = createRouter({
    history: createWebHistory(window.ERP_BASE_URL ? new URL(window.ERP_BASE_URL).pathname : '/'),
    routes
});

// Update page title
router.beforeEach((to, from, next) => {
    document.title = (to.meta.title || 'ERP') + ' - System';
    next();
});

export default router;
