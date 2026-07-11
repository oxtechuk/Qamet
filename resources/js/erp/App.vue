<template>
  <div :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'" class="erp-wrapper h-100">
    <router-view></router-view>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();

onMounted(() => {
    // You can fetch user preferred locale from API/meta tags here
    const savedLocale = localStorage.getItem('erp_locale') || 'ar';
    locale.value = savedLocale;
    document.documentElement.lang = savedLocale;
    document.documentElement.dir = savedLocale === 'ar' ? 'rtl' : 'ltr';
});
</script>

<style>
/* Base overrides for ERP */
.erp-wrapper {
  min-height: 100vh;
  background-color: #f3f4f6; /* Modern light gray background */
}
</style>
