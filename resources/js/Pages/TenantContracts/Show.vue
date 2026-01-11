<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <Link :href="`/${contract.contract_type}-contracts`" class="hover:text-[#137fec]">
        {{ contract.contract_type === 'owner' ? 'Owner' : 'Tenant' }} Contracts
      </Link>
      <span class="mx-2">/</span>
      <span>{{ contract.contract_number }}</span>
    </template>

    <div class="space-y-6">
      <div class="bg-white rounded-xl border border-slate-200 p-6">
        <div class="flex items-start justify-between mb-6">
          <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ contract.unit.building.building_name }}</h1>
            <p class="text-slate-500">Unit {{ contract.unit.unit_no }}, {{ contract.unit.building.address }}, {{ contract.unit.building.city }}</p>
          </div>
          <span 
            class="px-3 py-1 text-sm font-bold rounded-md"
            :class="{
              'bg-green-50 text-green-700': contract.status === 'active',
              'bg-red-50 text-red-700': contract.status === 'expired',
              'bg-slate-50 text-slate-700': contract.status === 'terminated'
            }"
          >
            {{ contract.status }}
          </span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
          <div>
            <p class="text-sm text-slate-500 mb-1">Contract Number</p>
            <p class="font-medium text-slate-900">{{ contract.contract_number }}</p>
          </div>
          <div>
            <p class="text-sm text-slate-500 mb-1">Ejari Number</p>
            <p class="font-medium text-slate-900">{{ contract.ejari_no }}</p>
          </div>
          <div>
            <p class="text-sm text-slate-500 mb-1">{{ contract.contract_type === 'owner' ? 'Owner' : 'Tenant' }}</p>
            <p class="font-medium text-slate-900">{{ contract.person.name }}</p>
          </div>
          <div>
            <p class="text-sm text-slate-500 mb-1">Phone</p>
            <p class="font-medium text-slate-900">{{ contract.person.phone }}</p>
          </div>
          <div>
            <p class="text-sm text-slate-500 mb-1">Start Date</p>
            <p class="font-medium text-slate-900">{{ formatDate(contract.start_date) }}</p>
          </div>
          <div>
            <p class="text-sm text-slate-500 mb-1">End Date</p>
            <p class="font-medium text-slate-900">{{ formatDate(contract.end_date) }}</p>
          </div>
          <div>
            <p class="text-sm text-slate-500 mb-1">Duration</p>
            <p class="font-medium text-slate-900">{{ contract.duration_months }} months</p>
          </div>
          <div>
            <p class="text-sm text-slate-500 mb-1">Total Amount</p>
            <p class="font-bold text-[#137fec] text-lg">AED {{ formatMoney(contract.total_amount) }}</p>
          </div>
        </div>

        <div v-if="contract.subunits?.length" class="mt-6 pt-6 border-t border-slate-200">
          <p class="text-sm text-slate-500 mb-2">Subunits</p>
          <div class="flex flex-wrap gap-2">
            <span v-for="sub in contract.subunits" :key="sub.id" class="px-3 py-1 bg-slate-100 text-slate-700 rounded-md text-sm">
              {{ sub.subunit_type }} {{ sub.subunit_no }} ({{ sub.area_sqft }} sqft)
            </span>
          </div>
        </div>

        <div v-if="contract.unit.assets?.length" class="mt-6 pt-6 border-t border-slate-200">
          <p class="text-sm text-slate-500 mb-2">Assets</p>
          <div class="flex flex-wrap gap-2">
            <span v-for="asset in contract.unit.assets" :key="asset" class="px-3 py-1 bg-blue-50 text-blue-700 rounded-md text-sm">
              {{ asset }}
            </span>
          </div>
        </div>

        <div v-if="contract.notes" class="mt-6 pt-6 border-t border-slate-200">
          <p class="text-sm text-slate-500 mb-2">Notes</p>
          <p class="text-slate-900">{{ contract.notes }}</p>
        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200">
          <h2 class="text-lg font-bold text-slate-900">Payments ({{ contract.payments.length }})</h2>
        </div>
        
        <div v-if="contract.payments.length" class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-slate-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Type</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Details</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Due Date</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
              <tr v-for="payment in contract.payments" :key="payment.id" class="hover:bg-slate-50">
                <td class="px-6 py-4">
                  <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded text-xs font-medium">{{ payment.payment_type }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-slate-900">
                  <div v-if="payment.payment_type === 'cheque'">
                    <p>{{ payment.payment_number }}</p>
                    <p class="text-xs text-slate-500">{{ payment.bank_name }}</p>
                  </div>
                  <span v-else>-</span>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-slate-900">AED {{ formatMoney(payment.amount) }}</td>
                <td class="px-6 py-4 text-sm text-slate-900">{{ formatDate(payment.due_date) }}</td>
                <td class="px-6 py-4">
                  <span 
                    class="px-2 py-1 text-xs font-bold rounded-md"
                    :class="{
                      'bg-green-50 text-green-700': payment.status === 'cleared',
                      'bg-yellow-50 text-yellow-700': payment.status === 'pending',
                      'bg-blue-50 text-blue-700': payment.status === 'collected',
                      'bg-red-50 text-red-700': payment.status === 'bounced'
                    }"
                  >
                    {{ payment.status }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div v-else class="p-12 text-center text-slate-500">
          No payments added yet
        </div>
      </div>

      <div class="flex gap-4">
        <Link 
          :href="`/${contract.contract_type}-contracts`"
          class="px-6 py-3 border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50 transition-colors"
        >
          Back
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  contract: Object
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-GB')
}

const formatMoney = (amount) => {
  return new Intl.NumberFormat('en-US').format(amount)
}
</script>