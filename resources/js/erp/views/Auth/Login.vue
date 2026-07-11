<template>
  <div class="login-wrapper vh-100 d-flex align-items-center justify-content-center bg-light" dir="rtl">
    <div class="row w-100 shadow-lg rounded-4 overflow-hidden" style="max-width: 900px; background: #fff;">
      <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
        <div class="text-center mb-4">
           <div class="brand-box bg-dark text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
              <i class="ri-car-fill fs-1"></i>
           </div>
          <h2 class="fw-bold">GR-Motors ERP</h2>
          <p class="text-muted">نظام إدارة المعرض المتكامل</p>
        </div>
        
        <form @submit.prevent="handleLogin">
          <div class="mb-3">
            <label class="form-label text-muted fw-bold">البريد الإلكتروني</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="ri-mail-line text-muted"></i></span>
                <input v-model="form.email" type="email" class="form-control border-start-0 ps-0" placeholder="admin@erp.local" required>
            </div>
          </div>
          
          <div class="mb-4">
            <label class="form-label text-muted fw-bold">كلمة المرور</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="ri-lock-2-line text-muted"></i></span>
                <input v-model="form.password" type="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
            </div>
          </div>
          
          <div class="d-flex justify-content-between mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" v-model="form.remember">
              <label class="form-check-label text-muted" for="remember">تذكرني</label>
            </div>
          </div>
          
          <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" :disabled="loading">
            <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
            تسجيل الدخول <i class="ri-arrow-left-line ms-1"></i>
          </button>
        </form>

        <div v-if="errorMsg" class="alert alert-danger mt-3 py-2 text-center border-0 rounded-3">
            <i class="ri-error-warning-line align-middle me-1"></i> {{ errorMsg }}
        </div>
      </div>
      
      <div class="col-md-6 d-none d-md-block p-0 position-relative">
        <div class="bg-gradient-primary w-100 h-100 justify-content-center align-items-center d-flex position-relative overflow-hidden">
            <div class="circle-decoration position-absolute"></div>
            <div class="text-white text-center position-relative z-1 p-5">
                <h2 class="fw-bold mb-3">مرحباً بعودتك!</h2>
                <p class="opacity-75">لقد قمنا بترقية النظام ليصبح نظام تخطيط وأتمتة شامل يجمع المبيعات والمخازن والعملاء في واجهة واحدة فائقة السرعة.</p>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const loading = ref(false);
const errorMsg = ref('');

const form = ref({
  email: '',
  password: '',
  remember: false
});

const handleLogin = async () => {
    loading.value = true;
    errorMsg.value = '';
    try {
        // Fetch Sanctum CSRF Cookie
        await axios.get('/sanctum/csrf-cookie');
        
        // Use standard laravel api login or directly fallback to crm login logic
        // Because the user previously used the CRM AuthController for employees and User for SuperAdmin
        // We will make a generic API login endpoint in our api core later if needed, 
        // For now, post to the standard Laravel login or specialized web login API
        const response = await axios.post('/api/erp/login', form.value);
        
        // On success, redirect to dashboard
        router.push({ name: 'Dashboard' });
    } catch (error) {
        errorMsg.value = "البيانات المدخلة غير صحيحة، يرجى المحاولة مرة أخرى.";
        console.error("Login Error", error);
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
.bg-gradient-primary {
    background: linear-gradient(135deg, #2b32b2 0%, #1488cc 100%);
    background-color: var(--primary);
}
.circle-decoration {
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    top: -100px;
    right: -100px;
}
.form-control:focus {
    box-shadow: none;
    border-color: #dee2e6;
}
.input-group-text {
    border-color: #dee2e6;
}
.form-control {
    border-color: #dee2e6;
}
</style>
