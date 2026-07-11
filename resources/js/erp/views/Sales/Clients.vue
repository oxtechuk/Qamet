<template>
  <ERPLayout>
    <div class="clients-wrapper">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1">نظام المبيعات والعملاء</h2>
          <p class="text-muted">إدارة بيانات العملاء الخاصين بالشركة</p>
        </div>
        <button class="btn btn-primary shadow-sm">
          <i class="ri-user-add-line"></i> إضافة عميل جديد
        </button>
      </div>

      <!-- Clients Table -->
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th class="ps-4">العميل</th>
                  <th>النوع</th>
                  <th>الهاتف</th>
                  <th>رقم ضريبي/هوية</th>
                  <th>الحالة</th>
                  <th class="text-end pe-4">الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="clients.length === 0">
                  <td colspan="6" class="text-center py-5 text-muted">
                    <i class="ri-user-smile-line fs-1 d-block mb-2"></i>
                    لا يوجد عملاء مسجلين حتى الآن
                  </td>
                </tr>
                <tr v-for="client in clients" :key="client.id">
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                        {{ client.name_ar ? client.name_ar.charAt(0) : client.name.charAt(0) }}
                      </div>
                      <div>
                        <h6 class="mb-0 fw-bold">{{ client.name_ar || client.name }}</h6>
                        <small class="text-muted">{{ client.emails && client.emails.length ? client.emails[0] : 'لا يوجد إيميل' }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge" :class="client.type === 'corporate' ? 'bg-indigo text-white' : 'bg-light text-dark border'">
                        {{ client.type === 'corporate' ? 'شركة' : 'فرد' }}
                    </span>
                  </td>
                  <td>{{ client.phones && client.phones.length ? client.phones[0] : 'غير متوفر' }}</td>
                  <td>{{ client.type === 'corporate' ? client.tax_number : client.national_id }}</td>
                  <td>
                    <span class="badge" :class="{
                      'bg-success': client.status === 'active',
                      'bg-secondary': client.status === 'inactive',
                      'bg-danger': client.status === 'blacklisted'
                    }">{{ client.status }}</span>
                  </td>
                  <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light me-2"><i class="ri-file-list-3-line text-primary" title="عروض الأسعار"></i></button>
                    <button class="btn btn-sm btn-light"><i class="ri-edit-line text-secondary"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
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

const clients = ref([]);

const fetchClients = async () => {
  try {
    const response = await axios.get('/api/erp/sales/clients');
    clients.value = response.data.data;
  } catch (error) {
    console.error('Error fetching clients', error);
  }
};

onMounted(() => {
  fetchClients();
});
</script>

<style scoped>
.bg-indigo {
    background-color: #6610f2;
}
</style>
