<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <Link :href="route('owner-contracts.index')" class="hover:text-[#137fec]">Owner Contracts</Link>
      <span class="mx-2">/</span>
      <span>Create</span>
    </template>

    <div class="max-w-3xl">
      <h1 class="text-2xl font-bold text-slate-900 mb-6">Add Owner Contract</h1>

      <form @submit.prevent="submit" class="bg-white rounded-xl border border-slate-200 p-6 space-y-6">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Unit</label>
            <select v-model="form.unit_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
              <option value="">Select Unit</option>
              <option v-for="unit in units" :key="unit.id" :value="unit.id">
                {{ unit.building.building_name }} - Unit {{ unit.unit_no }}
              </option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Owner</label>
            <select v-model="form.person_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
              <option value="">Select Owner</option>
              <option v-for="owner in owners" :key="owner.id" :value="owner.id">{{ owner.name }}</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Contract Number</label>
            <input v-model="form.contract_number" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Ejari Number</label>
            <input v-model="form.ejari_no" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Start Date</label>
            <input v-model="form.start_date" type="date" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Duration (months)</label>
            <input v-model="form.duration_months" @input="calculateEndDate" type="number" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">End Date</label>
            <input v-model="form.end_date" type="date" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Total Amount (AED)</label>
            <input v-model="form.total_amount" @input="distributePayments" type="number" step="0.01" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
            <select v-model="form.status" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
              <option value="active">Active</option>
              <option value="expired">Expired</option>
              <option value="terminated">Terminated</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Number of Payments</label>
            <input v-model="numPayments" @input="updatePayments" type="number" min="1" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
          </div>
        </div>

        <div v-if="form.unit_id">
          <label class="block text-sm font-medium text-slate-700 mb-2">Subunits (optional)</label>
          <div class="flex flex-wrap gap-2">
            <label v-for="subunit in availableSubunits" :key="subunit.id" class="flex items-center gap-2 px-3 py-2 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50">
              <input type="checkbox" :value="subunit.id" v-model="form.subunit_ids" class="rounded" />
              <span class="text-sm">{{ subunit.subunit_type }} {{ subunit.subunit_no }}</span>
            </label>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
          <textarea v-model="form.notes" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" rows="3"></textarea>
        </div>

        <div v-if="form.payments.length" class="space-y-4">
          <h3 class="text-lg font-bold text-slate-900">Payments</h3>
          <p v-if="paymentError" class="text-red-600 text-sm">{{ paymentError }}</p>
          
          <div v-for="(payment, index) in form.payments" :key="index" class="p-4 border border-slate-200 rounded-lg space-y-3">
            <div class="grid grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Payment Type</label>
                <select v-model="payment.payment_type" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]">
                  <option value="cheque">Cheque</option>
                  <option value="online">Online</option>
                  <option value="cash">Cash</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Amount (AED)</label>
                <input v-model="payment.amount" @input="validateTotal" type="number" step="0.01" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
              </div>

              <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Due Date</label>
                <input v-model="payment.due_date" type="date" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
              </div>
            </div>

            <div v-if="payment.payment_type === 'cheque'" class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Cheque Number</label>
                <input v-model="payment.payment_number" type="text" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
              </div>
              <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Bank Name</label>
                <input v-model="payment.bank_name" type="text" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
              </div>
            </div>

            <div>
              <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
              <select v-model="payment.status" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]">
                <option value="pending">Pending</option>
                <option value="collected">Collected</option>
                <option value="cleared">Cleared</option>
                <option value="bounced">Bounced</option>
              </select>
            </div>
          </div>
        </div>

        <div class="flex gap-4 pt-4">
          <button type="submit" :disabled="!!paymentError || form.processing" class="px-6 py-2 bg-[#137fec] text-white rounded-lg font-medium hover:bg-[#137fec]/90 disabled:opacity-50">Save Contract</button>
          <Link :href="route('owner-contracts.index')" class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50">Cancel</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  units: Array,
  owners: Array,
  subunits: Array,
  renewData: Object
})

const numPayments = ref(props.renewData?.payments?.length || 1)
const paymentError = ref('')

const form = useForm({
  unit_id: props.renewData?.unit_id || '',
  person_id: props.renewData?.person_id || '',
  contract_type: 'owner',
  contract_number: '',
  ejari_no: props.renewData?.ejari_no || '',
  start_date: props.renewData?.start_date || '',
  end_date: '',
  duration_months: props.renewData?.duration_months || 12,
  total_amount: props.renewData?.total_amount || '',
  status: 'active',
  notes: '',
  subunit_ids: props.renewData?.subunit_ids || [],
  payments: []
})

const availableSubunits = computed(() => {
  return props.subunits.filter(s => s.unit_id == form.unit_id)
})

const calculateEndDate = () => {
  if (form.start_date && form.duration_months) {
    const start = new Date(form.start_date)
    start.setMonth(start.getMonth() + parseInt(form.duration_months))
    form.end_date = start.toISOString().split('T')[0]
  }
}

const updatePayments = () => {
  const count = parseInt(numPayments.value)
  form.payments = Array.from({ length: count }, (_, i) => ({
    payment_type: 'cheque',
    payment_number: '',
    bank_name: '',
    amount: 0,
    due_date: '',
    status: 'pending'
  }))
  distributePayments()
}

const distributePayments = () => {
  if (form.total_amount && form.payments.length) {
    const perPayment = (parseFloat(form.total_amount) / form.payments.length).toFixed(2)
    form.payments.forEach(p => p.amount = perPayment)
  }
  validateTotal()
}

const validateTotal = () => {
  const sum = form.payments.reduce((acc, p) => acc + parseFloat(p.amount || 0), 0)
  const total = parseFloat(form.total_amount || 0)
  if (Math.abs(sum - total) > 0.01) {
    paymentError.value = `Payment total (${sum.toFixed(2)}) doesn't match contract amount (${total.toFixed(2)})`
  } else {
    paymentError.value = ''
  }
}

watch(() => form.start_date, calculateEndDate)
watch(() => form.duration_months, calculateEndDate)

const submit = () => form.post(route('owner-contracts.store'))
</script>