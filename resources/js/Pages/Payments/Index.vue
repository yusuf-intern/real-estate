<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <span>Payments</span>
    </template>

    <div class="space-y-6">
      <h1 class="text-2xl font-bold text-slate-900">All Payments</h1>
<div class="bg-white rounded-xl p-4 border border-slate-200">
  <input 
    v-model="search"
    @input="filterResults"
    type="text"
    placeholder="Search by contract ID..."
    class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#137fec]"
  />
</div>
      <div class="bg-white rounded-xl p-4 border border-slate-200">
        <div class="flex gap-4">
<select
  v-model="filters.type"
  @change="filter"
  class="px-4 py-2 pr-10 border border-slate-200 rounded-lg
         focus:ring-2 focus:ring-[#137fec] appearance-none bg-white">
  <option value="">All Types</option>
  <option value="cheque">Cheque</option>
  <option value="online">Online</option>
  <option value="cash">Cash</option>
</select>

<select
  v-model="filters.status"
  @change="filter"
  class="px-4 py-2 pr-10 border border-slate-200 rounded-lg
         focus:ring-2 focus:ring-[#137fec] appearance-none bg-white">
  <option value="">All Status</option>
  <option value="pending">Pending</option>
  <option value="collected">Collected</option>
  <option value="cleared">Cleared</option>
  <option value="bounced">Bounced</option>
</select>

        </div>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Contract</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Property</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Type</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Details</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Due Date</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr v-for="payment in payments.data" :key="payment.id" class="hover:bg-slate-50">
              <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ payment.contract.contract_number }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ payment.contract.unit.building.building_name }} - Unit {{ payment.contract.unit.unit_no }}</td>
              <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-bold rounded-md bg-slate-100 text-slate-700">{{ payment.payment_type }}</span></td>
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

      <div v-if="payments.links.length > 3" class="flex justify-center gap-2">
        <Link 
          v-for="link in payments.links" 
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

defineProps({ payments: Object })

const filters = ref({ type: '', status: '' })

const filter = () => {
  router.get(route('payments.index'), filters.value, { preserveState: true })
}

const formatDate = (date) => new Date(date).toLocaleDateString('en-GB')
const formatMoney = (amount) => new Intl.NumberFormat('en-US').format(amount)

const search = ref('')

const filterResults = () => {
  router.get(route('payments.index'), { search: search.value }, { preserveState: true })
}
</script>