<template>
  <ERPLayout>
    <div class="cars-manager">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1 text-primary fw-bold">إدارة السيارات</h2>
          <p class="text-muted">نظام متكامل واحترافي لإضافة سيارات كراجك</p>
        </div>
        <button class="btn btn-primary shadow px-4" @click="openCreateModal">
          <i class="ri-roadster-line me-2"></i> إضافة سيارة جديدة
        </button>
      </div>

      <!-- Cars Table -->
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th class="ps-4 py-3">صورة/اسم السيارة</th>
                  <th class="py-3">الماركة والفئة</th>
                  <th class="py-3">النوع والموديل</th>
                  <th class="py-3">السعر النـقدي</th>
                  <th class="py-3">الحالة</th>
                  <th class="text-end pe-4 py-3">إجراءات</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="loading">
                    <td colspan="6" class="text-center py-5">
                       <span class="spinner-border text-primary"></span>
                    </td>
                </tr>
                <tr v-else-if="cars.length === 0">
                  <td colspan="6" class="text-center py-5 text-muted">
                    <i class="ri-car-line fs-1 d-block mb-2 opacity-50"></i>
                    لا يوجد سيارات مضافة حالياً. أضف سيارتك الأولى!
                  </td>
                </tr>
                <tr v-for="car in cars" :key="car.id">
                  <td class="ps-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="car-thumbnail shadow-sm border" :style="{ backgroundImage: 'url(/storage/' + (car.thumbnail || 'default.jpg') + ')' }"></div>
                      <div>
                        <h6 class="mb-0 fw-bold">{{ car.name.ar || car.name.en }}</h6>
                        <small class="text-muted"><i class="ri-calendar-2-line"></i> {{ car.year }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border d-block w-fit mb-1">{{ car.brand?.name?.ar || 'غير محدد' }}</span>
                    <small class="text-muted">{{ car.category?.name?.ar || 'متنوع' }}</small>
                  </td>
                  <td>
                     <h6 class="mb-0 text-dark">{{ typesMap[car.type] || car.type }}</h6>
                     <small class="text-muted">{{ car.model }}</small>
                  </td>
                  <td>
                     <span class="text-success fw-bold">{{ Number(car.cash_price).toLocaleString() }} ريال</span>
                  </td>
                  <td>
                    <span class="badge" :class="car.is_active ? 'bg-success text-white' : 'bg-secondary'">{{ car.is_active ? 'مفعلة بالموقع' : 'مخفية' }}</span>
                    <span v-if="car.is_featured" class="badge bg-warning text-dark ms-1"><i class="ri-star-fill"></i> مميزة</span>
                  </td>
                  <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light me-2" title="الصور وتفاصيل المعرض" @click="editCar(car)">
                        <i class="ri-image-add-line text-primary"></i>
                    </button>
                    <button class="btn btn-sm btn-light btn-hover-danger" @click="deleteCar(car.id)">
                        <i class="ri-delete-bin-line text-danger"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.total > pagination.per_page" class="d-flex justify-content-center mt-4">
        <button class="btn btn-outline-primary border-0 me-2" :disabled="!pagination.prev" @click="fetchCars(pagination.current - 1)">السابق</button>
        <span class="btn btn-light" style="cursor:default">صفحة {{ pagination.current }} من {{ pagination.last }}</span>
        <button class="btn btn-outline-primary border-0 ms-2" :disabled="!pagination.next" @click="fetchCars(pagination.current + 1)">التالي</button>
      </div>
      
    </div>
  </ERPLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ERPLayout from '../../layouts/ERPLayout.vue';

const cars = ref([]);
const loading = ref(true);
const typesMap = ref({});

const pagination = ref({
    current: 1, last: 1, total: 0, per_page: 15, next: null, prev: null
});

const fetchCars = async (page = 1) => {
    loading.value = true;
    try {
        const response = await axios.get(`/api/erp/crm/cars?page=${page}`);
        cars.value = response.data.cars.data;
        typesMap.value = response.data.types;
        
        pagination.value = {
            current: response.data.cars.current_page,
            last: response.data.cars.last_page,
            total: response.data.cars.total,
            per_page: response.data.cars.per_page,
            next: response.data.cars.next_page_url,
            prev: response.data.cars.prev_page_url,
        };
    } catch (error) {
        console.error("Error fetching cars data", error);
    } finally {
        loading.value = false;
    }
};

const deleteCar = async (id) => {
    if(!confirm("هل أنت متأكد من رغبتك بحذف هذه السيارة؟ لن يمكن التراجع المستقبلي.")) return;
    try {
        await axios.delete(`/api/erp/crm/cars/${id}`);
        fetchCars(pagination.value.current);
    } catch (err) {
        alert("حدث خطأ أثناء الحذف");
    }
};

const openCreateModal = () => {
    alert("سيتم استعراض شاشة الإضافة العصرية في الخطوة القادمة");
};

const editCar = (car) => {
    alert("سيتم عرض شاشة التعديل لهذه السيارة قريبا");
};

onMounted(() => {
    fetchCars();
});
</script>

<style scoped>
.car-thumbnail {
    width: 60px;
    height: 40px;
    background-size: cover;
    background-position: center;
    border-radius: 6px;
}
.btn-hover-danger:hover i {
    color: white !important;
}
.btn-hover-danger:hover {
    background-color: #dc3545 !important;
}
.w-fit {
    width: fit-content;
}
</style>
