<template>
  <div class="erp-layout d-flex h-100">
    <!-- Sidebar -->
    <aside class="sidebar bg-dark text-white p-3 shadow-lg flex-shrink-0" :class="{ 'collapsed': isSidebarCollapsed }">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="m-0 font-weight-bold" v-if="!isSidebarCollapsed">ERP System</h4>
        <i class="ri-menu-line fs-4 cursor-pointer" @click="toggleSidebar"></i>
      </div>

      <ul class="nav flex-column gap-2 mt-4">
        <li class="nav-item">
          <router-link to="/crm" class="nav-link text-white rounded d-flex align-items-center gap-2" active-class="active bg-primary" exact>
            <i class="ri-dashboard-line fs-5"></i>
            <span v-if="!isSidebarCollapsed">{{ $t('common.dashboard') }}</span>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/crm/system/modules" class="nav-link text-white rounded d-flex align-items-center gap-2" active-class="active bg-primary">
            <i class="ri-settings-3-line fs-5"></i>
            <span v-if="!isSidebarCollapsed">الموديولات والأنظمة</span>
          </router-link>
        </li>
        
        <li class="nav-item mt-3 pt-3 border-top border-secondary">
          <small v-if="!isSidebarCollapsed" class="text-secondary text-uppercase ps-2 mb-2 d-block">المعرض (CRM)</small>
          <router-link to="/crm/cars" class="nav-link text-white rounded d-flex align-items-center gap-2" active-class="active bg-primary">
            <i class="ri-car-fill fs-5 text-info"></i>
            <span v-if="!isSidebarCollapsed">إدارة السيارات</span>
          </router-link>
          <router-link to="/crm/brands" class="nav-link text-white rounded d-flex align-items-center gap-2 mt-1" active-class="active bg-primary">
            <i class="ri-steering-fill fs-5 text-info"></i>
            <span v-if="!isSidebarCollapsed">الماركات التجارية</span>
          </router-link>
          <router-link to="/crm/cms/settings" class="nav-link text-white rounded d-flex align-items-center gap-2 mt-1" active-class="active bg-primary">
            <i class="ri-layout-masonry-line fs-5 text-warning"></i>
            <span v-if="!isSidebarCollapsed">إدارة محتوى المتجر</span>
          </router-link>
        </li>
        
        <li class="nav-item mt-3 pt-3 border-top border-secondary">
          <small v-if="!isSidebarCollapsed" class="text-secondary text-uppercase ps-2 mb-2 d-block">إدارة المشتريات</small>
          <router-link to="/crm/purchasing/suppliers" class="nav-link text-white rounded d-flex align-items-center gap-2" active-class="active bg-primary">
            <i class="ri-store-2-line fs-5"></i>
            <span v-if="!isSidebarCollapsed">الموردين</span>
          </router-link>
        </li>
        
        <li class="nav-item mt-3 pt-3 border-top border-secondary">
          <small v-if="!isSidebarCollapsed" class="text-secondary text-uppercase ps-2 mb-2 d-block">المخازن والمنتجات</small>
          <router-link to="/crm/inventory/products" class="nav-link text-white rounded d-flex align-items-center gap-2" active-class="active bg-primary">
            <i class="ri-archive-line fs-5"></i>
            <span v-if="!isSidebarCollapsed">المنتجات (الأصناف)</span>
          </router-link>
        </li>
        
        <li class="nav-item mt-3 pt-3 border-top border-secondary mb-3">
          <small v-if="!isSidebarCollapsed" class="text-secondary text-uppercase ps-2 mb-2 d-block">المبيعات والعملاء</small>
          <router-link to="/crm/sales/clients" class="nav-link text-white rounded d-flex align-items-center gap-2" active-class="active bg-primary">
            <i class="ri-user-smile-line fs-5"></i>
            <span v-if="!isSidebarCollapsed">الـعــمـــلاء</span>
          </router-link>
        </li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content flex-grow-1 d-flex flex-column bg-light">
      <!-- Topbar -->
      <header class="topbar bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
        <div class="search-bar">
           <input type="text" class="form-control rounded-pill" :placeholder="$t('common.search') || 'Search...'">
        </div>
        
        <div class="user-menu d-flex align-items-center gap-3">
          <button @click="toggleLanguage" class="btn btn-sm btn-outline-secondary">
             {{ $i18n.locale === 'ar' ? 'English' : 'عربي' }}
          </button>
          <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
              <i class="ri-user-line"></i> User
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">{{ $t('common.profile') }}</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="#">{{ $t('common.logout') }}</a></li>
            </ul>
          </div>
        </div>
      </header>

      <!-- Router View Container -->
      <div class="p-4 flex-grow-1 overflow-auto">
        <router-view></router-view>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const isSidebarCollapsed = ref(false);
const { locale } = useI18n();

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const toggleLanguage = () => {
    const newLocale = locale.value === 'ar' ? 'en' : 'ar';
    locale.value = newLocale;
    localStorage.setItem('erp_locale', newLocale);
    document.documentElement.lang = newLocale;
    document.documentElement.dir = newLocale === 'ar' ? 'rtl' : 'ltr';
};
</script>

<style scoped>
.erp-layout {
    height: 100vh;
}
.sidebar {
    width: 250px;
    transition: all 0.3s ease;
    z-index: 1040;
}
.sidebar.collapsed {
    width: 70px;
}
.cursor-pointer {
    cursor: pointer;
}
.main-content {
    overflow-x: hidden;
}
</style>
