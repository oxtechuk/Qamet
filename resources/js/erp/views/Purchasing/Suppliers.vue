<template>
  <ERPLayout>
    <div class="suppliers-wrapper">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1">نظام الموردين والمشتريات</h2>
          <p class="text-muted">إدارة بيانات الموردين وأوامر الشراء</p>
        </div>
        <button class="btn btn-primary shadow-sm" @click="showAddModal = true">
          <i class="ri-add-line"></i> إضافة مورد جديد
        </button>
      </div>

      <!-- Suppliers Table -->
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th class="ps-4">المورد</th>
                  <th>الشركة</th>
                  <th>الهاتف</th>
                  <th>الرقم الضريبي</th>
                  <th>الحالة</th>
                  <th class="text-end pe-4">الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="suppliers.length === 0">
                  <td colspan="6" class="text-center py-5 text-muted">
                    <i class="ri-inbox-line fs-1 d-block mb-2"></i>
                    لا يوجد موردين مسجلين حتى الآن
                  </td>
                </tr>
                <tr v-for="supplier in suppliers" :key="supplier.id">
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                        {{ supplier.name_ar ? supplier.name_ar.charAt(0) : supplier.name.charAt(0) }}
                      </div>
                      <div>
                        <h6 class="mb-0 fw-bold">{{ supplier.name_ar || supplier.name }}</h6>
                        <small class="text-muted">{{ supplier.emails && supplier.emails.length ? supplier.emails[0] : 'لا يوجد إيميل' }}</small>
                      </div>
                    </div>
                  </td>
                  <td>{{ supplier.company ? supplier.company.name : 'N/A' }}</td>
                  <td>{{ supplier.phones && supplier.phones.length ? supplier.phones[0] : 'غير متوفر' }}</td>
                  <td>{{ supplier.tax_number || '-' }}</td>
                  <td>
                    <span class="badge" :class="{
                      'bg-success': supplier.status === 'active',
                      'bg-secondary': supplier.status === 'inactive',
                      'bg-danger': supplier.status === 'blacklisted'
                    }">{{ supplier.status }}</span>
                  </td>
                  <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light me-2"><i class="ri-eye-line text-primary"></i></button>
                    <button class="btn btn-sm btn-light"><i class="ri-edit-line text-secondary"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
      <!-- Example Add Modal placeholder -->
      <div v-if="showAddModal" class="modal fade show d-block" style="background: rgba(0,0,0,0.5)">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
               <div class="modal-header border-bottom-0 pb-0">
                  <h5 class="modal-title fw-bold">إضافة مورد</h5>
                  <button type="button" class="btn-close" @click="showAddModal = false"></button>
               </div>
               <div class="modal-body">
                  <p class="text-muted">هذا نموذج مبدئي، سيتم برمجة الحفظ لاحقاً.</p>
               </div>
               <div class="modal-footer border-top-0 pt-0">
                  <button type="button" class="btn btn-light" @click="showAddModal = false">إلغاء</button>
                  <button type="button" class="btn btn-primary px-4" @click="showAddModal = false">حفظ</button>
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

const suppliers = ref([]);
const showAddModal = ref(false);

const fetchSuppliers = async () => {
  try {
    const response = await axios.get('/api/erp/purchasing/suppliers');
    suppliers.value = response.data.data; // assuming paginated response
  } catch (error) {
    console.error('Error fetching suppliers', error);
  }
};

onMounted(() => {
  fetchSuppliers();
});
</script>
