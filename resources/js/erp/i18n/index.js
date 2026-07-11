import { createI18n } from 'vue-i18n';

const messages = {
    en: {
        common: {
            dashboard: 'Dashboard',
            logout: 'Logout',
            profile: 'Profile',
            save: 'Save',
            cancel: 'Cancel',
            edit: 'Edit',
            delete: 'Delete'
        }
    },
    ar: {
        common: {
            dashboard: 'لوحة القيادة',
            logout: 'تسجيل الخروج',
            profile: 'الملف الشخصي',
            save: 'حفظ',
            cancel: 'إلغاء',
            edit: 'تعديل',
            delete: 'حذف'
        }
    }
};

const i18n = createI18n({
    legacy: false, // Set to false to use Composition API
    locale: 'ar', // Default locale
    fallbackLocale: 'en',
    messages,
});

export default i18n;
