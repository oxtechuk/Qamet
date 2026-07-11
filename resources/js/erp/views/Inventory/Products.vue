<template>
  <ERPLayout>
    <div class="products-wrapper">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1">نظام المخزون والمنتجات</h2>
          <p class="text-muted">إدارة بيانات المنتجات وأرصدة المخازن</p>
        </div>
        <button class="btn btn-primary shadow-sm">
          <i class="ri-add-box-line"></i> إضافة منتج جديد
        </button>
      </div>

      <!-- Products Table -->
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th class="ps-4">المنتج</th>
                  <th>النوع</th>
                  <th>SKU / الباركود</th>
                  <th>سعر البيع</th>
                  <th>سعر الشراء</th>
                  <th>الحالة</th>
                  <th class="text-end pe-4">الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="products.length === 0">
                  <td colspan="7" class="text-center py-5 text-muted">
                    <i class="ri-archive-line fs-1 d-block mb-2"></i>
                    لا يوجد منتجات مسجلة في المخزن
                  </td>
                </tr>
                <tr v-for="product in products" :key="product.id">
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="bg-primary-subtle text-primary rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i v-if="product.type === 'service'" class="ri-service-line fs-4"></i>
                        <i v-else class="ri-box-3-line fs-4"></i>
                      </div>
                      <div>
                        <h6 class="mb-0 fw-bold">{{ product.name_ar || product.name }}</h6>
                        <small class="text-muted">{{ product.category ? product.category.name : 'بدون تصنيف' }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                     <span class="badge bg-light text-dark border">{{ product.type }}</span>
                  </td>
                  <td>
                     <small class="d-block text-muted">SKU: {{ product.sku || '-' }}</small>
                     <small class="d-block text-muted">Bar: {{ product.barcode || '-' }}</small>
                  </td>
                  <td class="fw-bold text-success">{{ Number(product.selling_price).toLocaleString() }}</td>
                  <td>{{ Number(product.purchase_price).toLocaleString() }}</td>
                  <td>
                    <span class="badge" :class="product.is_active ? 'bg-success' : 'bg-secondary'">
                        {{ product.is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                  </td>
                  <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light me-2"><i class="ri-stock-line text-primary"></i></button>
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

const products = ref([]);

const fetchProducts = async () => {
  try {
    const response = await axios.get('/api/erp/inventory/products');
    products.value = response.data.data;
  } catch (error) {
    console.error('Error fetching products', error);
  }
};

onMounted(() => {
  fetchProducts();
});
</script>
