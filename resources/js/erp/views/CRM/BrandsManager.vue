<template>
  <ERPLayout>
    <div class="brands-manager">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1 text-indigo fw-bold">إدارة الماركات (Brands)</h2>
          <p class="text-muted">التحكم في ماركات السيارات وشعاراتها المتاحة بالمعرض</p>
        </div>
        <button class="btn btn-indigo shadow px-4">
          <i class="ri-add-circle-line me-2"></i> إضافة ماركة جديدة
        </button>
      </div>

      <div class="row">
        <div class="col-md-3 mb-4" v-for="brand in brands" :key="brand.id">
            <div class="card border-0 shadow-sm rounded-4 h-100 position-relative brand-card">
                <div class="card-body text-center p-4">
                    <div class="brand-logo shadow-sm mb-3 mx-auto d-flex align-items-center justify-content-center bg-white" 
                         :class="{'border-danger': !brand.is_active}">
                        <img v-if="brand.logo" :src="'/storage/' + brand.logo" class="img-fluid p-2" :alt="brand.name.ar">
                        <i v-else class="ri-steering-2-line text-muted fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ brand.name.ar || brand.name.en }}</h5>
                    <div class="mb-3">
                        <span class="badge bg-light text-dark border">{{ brand.cars_count }} سيارة مسجلة</span>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary px-3"><i class="ri-edit-line"></i> تعديل</button>
                        <button class="btn btn-sm btn-outline-danger px-3"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <!-- Status Badge -->
                <div class="position-absolute top-0 end-0 p-3">
                    <span class="badge rounded-circle p-2" :class="brand.is_active ? 'bg-success' : 'bg-danger'" :title="brand.is_active ? 'مفعل' : 'موقف'"> </span>
                </div>
            </div>
        </div>
      </div>
      
       <!-- Pagination -->
      <div v-if="pagination.total > pagination.per_page" class="d-flex justify-content-center mt-3">
        <button class="btn btn-outline-indigo border-0 me-2" :disabled="!pagination.prev" @click="fetchBrands(pagination.current - 1)">السابق</button>
        <span class="btn btn-light" style="cursor:default">صفحة {{ pagination.current }} من {{ pagination.last }}</span>
        <button class="btn btn-outline-indigo border-0 ms-2" :disabled="!pagination.next" @click="fetchBrands(pagination.current + 1)">التالي</button>
      </div>

    </div>
  </ERPLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ERPLayout from '../../layouts/ERPLayout.vue';

const brands = ref([]);
const pagination = ref({ current: 1, last: 1, total: 0, per_page: 20 });

const fetchBrands = async (page = 1) => {
    try {
        const response = await axios.get(`/api/erp/crm/brands?page=${page}`);
        brands.value = response.data.data;
        pagination.value = {
            current: response.data.current_page,
            last: response.data.last_page,
            total: response.data.total,
            per_page: response.data.per_page,
            next: response.data.next_page_url,
            prev: response.data.prev_page_url,
        };
    } catch (error) {
        console.error("Error fetching brands", error);
    }
};

onMounted(() => fetchBrands());
</script>

<style scoped>
.text-indigo { color: #6610f2; }
.btn-indigo { background-color: #6610f2; color: #fff; }
.btn-outline-indigo { border-color: #6610f2; color: #6610f2; }
.btn-outline-indigo:hover { background-color: #6610f2; color: #fff; }
.brand-logo {
    width: 80px; height: 80px;
    border-radius: 50%;
    border: 3px solid #f8f9fa;
    overflow: hidden;
}
.brand-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.brand-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
</style>
