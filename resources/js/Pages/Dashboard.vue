<template>
  <AppLayout>
    <template #breadcrumb>
      <span>Home</span>
    </template>

    <div class="space-y-6">
      <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 border border-slate-200">
          <p class="text-sm text-slate-500 mb-2">Total Contracts</p>
          <p class="text-3xl font-bold text-slate-900">{{ stats.total_contracts }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-slate-200">
          <p class="text-sm text-slate-500 mb-2">Active Contracts</p>
          <p class="text-3xl font-bold text-green-600">{{ stats.active_contracts }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-slate-200">
          <p class="text-sm text-slate-500 mb-2">Total Buildings</p>
          <p class="text-3xl font-bold text-slate-900">{{ stats.total_buildings }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-slate-200">
          <p class="text-sm text-slate-500 mb-2">Pending Payments</p>
          <p class="text-3xl font-bold text-orange-600">{{ stats.pending_payments }}</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  stats: Object
})
</script>