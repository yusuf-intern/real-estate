<template>
  <div class="min-h-screen bg-[#f6f7f8] flex items-center justify-center p-4">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">Login</h1>
        
        <form @submit.prevent="submit">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
              <input 
                v-model="form.email" 
                type="email" 
                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#137fec] focus:border-transparent"
                required
              />
              <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
              <input 
                v-model="form.password" 
                type="password" 
                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#137fec] focus:border-transparent"
                required
              />
            </div>

            <div class="flex items-center">
              <input 
                v-model="form.remember" 
                type="checkbox" 
                id="remember"
                class="rounded border-slate-300 text-[#137fec] focus:ring-[#137fec]"
              />
              <label for="remember" class="ml-2 text-sm text-slate-600">Remember me</label>
            </div>

            <button 
              type="submit" 
              class="w-full bg-[#137fec] text-white py-3 rounded-xl font-medium hover:bg-[#137fec]/90 transition-colors"
              :disabled="form.processing"
            >
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

defineProps({
  errors: Object
})

const form = useForm({
  email: '',
  password: '',
  remember: false
})

const submit = () => {
  form.post('/login')  // Change from route('login') to '/login'
}
</script>