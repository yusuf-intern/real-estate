<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <span>Owner Contracts</span>
    </template>

    <div class="space-y-6">
      <div class="bg-white rounded-xl p-4 border border-slate-200">
        <div class="flex gap-4">
          <input 
            v-model="filters.search"
            @input="filter"
            type="text"
            placeholder="Search by building..."
            class="flex-1 px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#137fec]"
          />
          <select 
            v-model="filters.status"
            @change="filter"
            class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#137fec]"
          >
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="expired">Expired</option>
            <option value="terminated">Terminated</option>
          </select>
        </div>
      </div>

      <div v-if="contracts.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="contract in contracts.data" 
          :key="contract.id"
          class="bg-white rounded-xl border border-slate-100 overflow-hidden hover:shadow-md transition-shadow"
        >
          <div class="p-6 space-y-4">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <h3 class="font-bold text-slate-900 text-lg">{{ contract.unit.building.building_name }}</h3>
                <p class="text-slate-500 text-sm">Unit {{ contract.unit.unit_no }}, {{ contract.unit.building.address }}</p>
              </div>
              <span 
                class="px-2 py-1 text-xs font-bold rounded-md"
                :class="{
                  'bg-green-50 text-green-700': contract.status === 'active',
                  'bg-red-50 text-red-700': contract.status === 'expired',
                  'bg-slate-50 text-slate-700': contract.status === 'terminated'
                }"
              >
                {{ contract.status }}
              </span>
            </div>

            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span class="text-slate-500">Owner:</span>
                <span class="font-medium text-slate-900">{{ contract.person?.name }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Contract #:</span>
                <span class="font-medium text-slate-900">{{ contract.contract_number }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Duration:</span>
                <span class="font-medium text-slate-900">{{ formatDate(contract.start_date) }} - {{ formatDate(contract.end_date) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Amount:</span>
                <span class="font-bold text-[#137fec]">AED {{ formatMoney(contract.total_amount) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Payments:</span>
                <span class="font-medium text-slate-900">{{ contract.payments?.length || 0 }}</span>
              </div>
            </div>

            <div class="flex gap-2 pt-4 border-t border-slate-100">
              <Link 
                :href="`/owner-contracts/${contract.id}`"
                class="flex-1 text-center px-4 py-2 bg-[#137fec] text-white rounded-lg text-sm font-medium hover:bg-[#137fec]/90 transition-colors"
              >
                View
              </Link>
              <button 
                @click="deleteContract(contract.id)"
                class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition-colors"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-12 text-slate-500">
        No contracts found
      </div>

      <div v-if="contracts.links.length > 3" class="flex justify-center gap-2">
        <Link 
          v-for="link in contracts.links" 
          :key="link.label"
          :href="link.url"
          v-html="link.label"
          class="px-4 py-2 border rounded-lg text-sm"
          :class="link.active ? 'bg-[#137fec] text-white border-[#137fec]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
        />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  contracts: Object
})

const filters = ref({
  search: '',
  status: ''
})

const filter = () => {
  router.get('/owner-contracts', filters.value, { preserveState: true })
}

const deleteContract = (id) => {
  if (confirm('Delete this contract?')) {
    router.delete(`/owner-contracts/${id}`)
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-GB')
}

const formatMoney = (amount) => {
  return new Intl.NumberFormat('en-US').format(amount)
}
</script>