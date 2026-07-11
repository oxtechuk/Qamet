<template>
  <ERPLayout>
    <div class="modules-wrapper">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1">نظام إدارة الموديولات (Add-ons)</h2>
          <p class="text-muted">التحكم في تفعيل أو إيقاف الميزات الإضافية للنظام</p>
        </div>
        <button class="btn btn-primary shadow-sm" @click="fetchModules">
          <i class="ri-refresh-line"></i> تحديث القائمة
        </button>
      </div>

      <div class="row g-4">
        <!-- Module Card -->
        <div class="col-md-4" v-for="module in modules" :key="module.id">
          <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden">
            <!-- Active indicator ribbon -->
            <div v-if="module.is_active" class="position-absolute bg-success text-white px-3 py-1" style="top: 15px; right: -25px; transform: rotate(45deg); font-size: 0.75rem; width: 100px; text-align: center; z-index: 1;">
               مفعل
            </div>

            <div class="card-body p-4">
              <div class="d-flex align-items-center mb-3">
                <div class="icon-box rounded-circle p-3 me-3 text-white d-flex align-items-center justify-content-center" :style="{ backgroundColor: module.color, width: '50px', height: '50px' }">
                  <i :class="module.icon" class="fs-4"></i>
                </div>
                <div>
                  <h5 class="mb-0 fw-bold">{{ module.name }}</h5>
                  <small class="text-muted text-uppercase">v{{ module.version }} • {{ module.alias }}</small>
                </div>
              </div>
              <p class="text-secondary" style="min-height: 50px;">
                {{ module.description || 'لا يوجد وصف متاح.' }}
              </p>
            </div>
            <div class="card-footer bg-white border-0 p-4 pt-0 d-flex justify-content-end align-items-center gap-2">
              <div class="form-check form-switch fs-5 m-0" v-if="module.alias !== 'core'">
                <input class="form-check-input cursor-pointer" type="checkbox" :id="'module_' + module.alias" :checked="module.is_active" @change="toggleModule(module, $event.target.checked)">
              </div>
              <span v-else class="badge bg-secondary">System Core</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ERPLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ERPLayout from '../../layouts/ERPLayout.vue';

const modules = ref([]);

const fetchModules = async () => {
  try {
    const response = await axios.get('/api/erp/modules');
    modules.value = response.data;
  } catch (error) {
    console.error('Error fetching modules', error);
  }
};

const toggleModule = async (module, status) => {
  const action = status ? 'enable' : 'disable';
  // Optimistic UI update
  module.is_active = status; 
  
  try {
    await axios.post(`/api/erp/modules/${module.alias}/${action}`);
    // Reload the page to register new routes and state if necessary
    window.location.reload();
  } catch (error) {
    console.error(`Error trying to ${action} module:`, error);
    // Revert UI if failed
    module.is_active = !status;
    alert('حدث خطأ أثناء تغيير حالة الموديول');
  }
};

onMounted(() => {
  fetchModules();
});
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
.icon-box {
  width: 50px;
  height: 50px;
}
</style>
