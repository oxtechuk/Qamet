<template>
  <div class="cms-settings p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold mb-0">إدارة محتوى المتجر (CMS)</h3>
      <button @click="saveSettings" class="btn btn-primary px-4" :disabled="loading">
        <i class="ri-save-line me-1"></i> حفظ التغييرات
      </button>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4 px-2 border-0">
      <li class="nav-item">
        <a class="nav-link cursor-pointer fw-bold border-0 px-4 py-3" :class="{ 'active text-primary border-bottom-primary': activeTab === 'home' }" @click="activeTab = 'home'">
          <i class="ri-home-line me-2"></i> بانر الرئيسية
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link cursor-pointer fw-bold border-0 px-4 py-3" :class="{ 'active text-primary border-bottom-primary': activeTab === 'cars' }" @click="activeTab = 'cars'">
          <i class="ri-car-line me-2"></i> بانر صفحة السيارات
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link cursor-pointer fw-bold border-0 px-4 py-3" :class="{ 'active text-primary border-bottom-primary': activeTab === 'offers' }" @click="activeTab = 'offers'">
          <i class="ri-percent-line me-2"></i> بانر صفحة العروض
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link cursor-pointer fw-bold border-0 px-4 py-3" :class="{ 'active text-primary border-bottom-primary': activeTab === 'blog' }" @click="activeTab = 'blog'">
          <i class="ri-article-line me-2"></i> بانر صفحة المدونة
        </a>
      </li>
    </ul>

    <div class="row">
      <!-- Settings Form -->
      <div class="col-lg-8">
        <div v-show="activeTab === 'home'" class="card border-0 shadow-sm rounded-lg overflow-hidden">
          <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold">إعدادات بانر الصفحة الرئيسية</h5>
          </div>
          <div class="card-body p-4">
            <div class="mb-4">
              <label class="form-label fw-bold">العنوان</label>
              <input v-model="settings.home_hero.title" type="text" class="form-control form-control-lg">
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">الوصف الفرعي</label>
              <textarea v-model="settings.home_hero.subtitle" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">صورة البانر</label>
              <div class="image-upload-box border rounded-lg p-4 text-center bg-light cursor-pointer" @click="$refs.homeFileInput.click()">
                <div v-if="!settings.home_hero.image" class="py-4">
                  <i class="ri-image-add-line fs-1 text-secondary opacity-50"></i>
                </div>
                <div v-else class="preview-hero">
                  <img :src="getImageUrl(settings.home_hero.image)" class="img-fluid rounded" style="max-height: 200px;">
                  <button @click.stop="settings.home_hero.image = null" class="btn btn-sm btn-danger mt-3 d-block mx-auto">إزالة</button>
                </div>
                <input type="file" ref="homeFileInput" @change="(e) => handleFileUpload(e, 'home_hero')" class="d-none" accept="image/*">
              </div>
            </div>
          </div>
        </div>

        <div v-show="activeTab === 'cars'" class="card border-0 shadow-sm rounded-lg overflow-hidden">
          <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold">إعدادات بانر السيارات</h5>
          </div>
          <div class="card-body p-4">
            <div class="mb-4">
              <label class="form-label fw-bold">العنوان</label>
              <input v-model="settings.hero.title" type="text" class="form-control form-control-lg">
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">الوصف الفرعي</label>
              <textarea v-model="settings.hero.subtitle" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">صورة البانر</label>
              <div class="image-upload-box border rounded-lg p-4 text-center bg-light cursor-pointer" @click="$refs.carFileInput.click()">
                <div v-if="!settings.hero.image" class="py-4">
                  <i class="ri-image-add-line fs-1 text-secondary opacity-50"></i>
                </div>
                <div v-else class="preview-hero">
                  <img :src="getImageUrl(settings.hero.image)" class="img-fluid rounded" style="max-height: 200px;">
                  <button @click.stop="settings.hero.image = null" class="btn btn-sm btn-danger mt-3 d-block mx-auto">إزالة</button>
                </div>
                <input type="file" ref="carFileInput" @change="(e) => handleFileUpload(e, 'hero')" class="d-none" accept="image/*">
              </div>
            </div>
          </div>
        </div>

        <div v-show="activeTab === 'offers'" class="card border-0 shadow-sm rounded-lg overflow-hidden">
          <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold">إعدادات بانر العروض</h5>
          </div>
          <div class="card-body p-4">
            <div class="mb-4">
              <label class="form-label fw-bold">العنوان</label>
              <input v-model="settings.offers_hero.title" type="text" class="form-control form-control-lg">
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">الوصف الفرعي</label>
              <textarea v-model="settings.offers_hero.subtitle" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">صورة البانر</label>
              <div class="image-upload-box border rounded-lg p-4 text-center bg-light cursor-pointer" @click="$refs.offerFileInput.click()">
                <div v-if="!settings.offers_hero.image" class="py-4">
                  <i class="ri-image-add-line fs-1 text-secondary opacity-50"></i>
                </div>
                <div v-else class="preview-hero">
                  <img :src="getImageUrl(settings.offers_hero.image)" class="img-fluid rounded" style="max-height: 200px;">
                  <button @click.stop="settings.offers_hero.image = null" class="btn btn-sm btn-danger mt-3 d-block mx-auto">إزالة</button>
                </div>
                <input type="file" ref="offerFileInput" @change="(e) => handleFileUpload(e, 'offers_hero')" class="d-none" accept="image/*">
              </div>
            </div>
          </div>
        </div>

        <div v-show="activeTab === 'blog'" class="card border-0 shadow-sm rounded-lg overflow-hidden">
          <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold">إعدادات بانر المدونة</h5>
          </div>
          <div class="card-body p-4">
            <div class="mb-4">
              <label class="form-label fw-bold">العنوان</label>
              <input v-model="settings.blog_hero.title" type="text" class="form-control form-control-lg">
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">الوصف الفرعي</label>
              <textarea v-model="settings.blog_hero.subtitle" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">صورة البانر</label>
              <div class="image-upload-box border rounded-lg p-4 text-center bg-light cursor-pointer" @click="$refs.blogFileInput.click()">
                <div v-if="!settings.blog_hero.image" class="py-4">
                  <i class="ri-image-add-line fs-1 text-secondary opacity-50"></i>
                </div>
                <div v-else class="preview-hero">
                  <img :src="getImageUrl(settings.blog_hero.image)" class="img-fluid rounded" style="max-height: 200px;">
                  <button @click.stop="settings.blog_hero.image = null" class="btn btn-sm btn-danger mt-3 d-block mx-auto">إزالة</button>
                </div>
                <input type="file" ref="blogFileInput" @change="(e) => handleFileUpload(e, 'blog_hero')" class="d-none" accept="image/*">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Preview Section -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-lg sticky-top" style="top: 20px;">
          <div class="card-header bg-dark text-white py-3">
             <h5 class="mb-0"><i class="ri-eye-line me-2"></i> معاينة مباشرة ({{ activeTab === 'home' ? 'الرئيسية' : (activeTab === 'cars' ? 'السيارات' : (activeTab === 'offers' ? 'العروض' : 'المدونة')) }})</h5>
          </div>
          <div class="card-body p-0 bg-dark position-relative" style="height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
             <div class="p-4 text-center position-relative" style="z-index: 2;">
                <h2 class="text-white fw-bold mb-3" v-html="activeTabData.title"></h2>
                <p class="text-white opacity-75 small">{{ activeTabData.subtitle }}</p>
             </div>
             <div class="hero-preview-bg position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(238, 30, 38, 0.3) 0%, rgba(0,0,0,0.8) 100%); z-index: 1;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const loading = ref(false);
const activeTab = ref('home');
const settings = ref({
  home_hero: { title: '', subtitle: '', image: null, file: null },
  hero: { title: '', subtitle: '', image: null, file: null },
  offers_hero: { title: '', subtitle: '', image: null, file: null },
  blog_hero: { title: '', subtitle: '', image: null, file: null }
});

const activeTabData = computed(() => {
    if (activeTab.value === 'home') return settings.value.home_hero;
    if (activeTab.value === 'cars') return settings.value.hero;
    if (activeTab.value === 'offers') return settings.value.offers_hero;
    return settings.value.blog_hero;
});

const getImageUrl = (path) => {
  if (path && path.startsWith('data:')) return path;
  return `/storage/${path}`;
};

const handleFileUpload = (e, target) => {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (event) => {
    settings.value[target].image = event.target.result;
    settings.value[target].file = file;
  };
  reader.readAsDataURL(file);
};

const fetchSettings = async () => {
  try {
    const res = await axios.get('/api/erp/crm/cms/settings');
    settings.value.home_hero = { ...res.data.home_hero, file: null };
    settings.value.hero = { ...res.data.hero, file: null };
    settings.value.offers_hero = { ...res.data.offers_hero, file: null };
    settings.value.blog_hero = { ...res.data.blog_hero, file: null };
  } catch (err) {
    console.error(err);
  }
};

const saveSettings = async () => {
    loading.value = true;
    try {
        const formData = new FormData();
        
        // Append Home Hero
        formData.append('home_hero[title]', settings.value.home_hero.title);
        formData.append('home_hero[subtitle]', settings.value.home_hero.subtitle);
        if (settings.value.home_hero.file) formData.append('home_hero_image', settings.value.home_hero.file);
        else formData.append('home_hero[image]', settings.value.home_hero.image || '');

        // Append Cars Hero
        formData.append('hero[title]', settings.value.hero.title);
        formData.append('hero[subtitle]', settings.value.hero.subtitle);
        if (settings.value.hero.file) formData.append('hero_image', settings.value.hero.file);
        else formData.append('hero[image]', settings.value.hero.image || '');

        // Append Offers Hero
        formData.append('offers_hero[title]', settings.value.offers_hero.title);
        formData.append('offers_hero[subtitle]', settings.value.offers_hero.subtitle);
        if (settings.value.offers_hero.file) formData.append('offers_hero_image', settings.value.offers_hero.file);
        else formData.append('offers_hero[image]', settings.value.offers_hero.image || '');

        // Append Blog Hero
        formData.append('blog_hero[title]', settings.value.blog_hero.title);
        formData.append('blog_hero[subtitle]', settings.value.blog_hero.subtitle);
        if (settings.value.blog_hero.file) formData.append('blog_hero_image', settings.value.blog_hero.file);
        else formData.append('blog_hero[image]', settings.value.blog_hero.image || '');

        await axios.post('/api/erp/crm/cms/settings', formData);
        toast.success("تم حفظ الإعدادات بنجاح");
        fetchSettings();
    } catch (err) {
        toast.error("حدث خطأ أثناء الحفظ");
        console.error(err);
    } finally {
        loading.value = false;
    }
};

onMounted(fetchSettings);

</script>

<style scoped>
.nav-tabs .nav-link { background: none; color: #666; }
.nav-tabs .nav-link.active { border-bottom: 2px solid #EE1E26 !important; color: #EE1E26 !important; }
.border-bottom-primary { border-bottom: 3px solid #EE1E26; }
.rounded-lg { border-radius: 12px; }
.cursor-pointer { cursor: pointer; }
.highlight { color: #EE1E26; }
</style>
