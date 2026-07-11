<template>
  <ERPLayout>
    <div class="dashboard-wrapper">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $t('common.dashboard') }}</h2>
      </div>

      <div class="row g-4">
        <div class="col-md-3">
          <div class="card bg-white border-0 shadow-sm h-100 rounded-4">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="text-muted mb-2">Total Sales</h6>
                  <h3 class="mb-0 text-primary">0 EGP</h3>
                </div>
                <div class="icon-box bg-primary-subtle text-primary rounded-circle p-3">
                  <i class="ri-money-dollar-circle-line fs-3"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card bg-white border-0 shadow-sm h-100 rounded-4">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="text-muted mb-2">Active Offers</h6>
                  <h3 class="mb-0 text-warning">0</h3>
                </div>
                <div class="icon-box bg-warning-subtle text-warning rounded-circle p-3">
                  <i class="ri-file-list-3-line fs-3"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ERPLayout>
</template>

<script setup>
import ERPLayout from '../layouts/ERPLayout.vue';
</script>

<style scoped>
.icon-box {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
