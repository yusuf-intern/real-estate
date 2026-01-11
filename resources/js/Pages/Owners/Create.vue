<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <Link :href="route('owners.index')" class="hover:text-[#137fec]">Owners</Link>
      <span class="mx-2">/</span>
      <span>{{ owner ? 'Edit' : 'Create' }}</span>
    </template>

    <div class="max-w-2xl">
      <h1 class="text-2xl font-bold text-slate-900 mb-6">{{ owner ? 'Edit' : 'Add' }} Owner</h1>

      <form @submit.prevent="submit" class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Name</label>
          <input v-model="form.name" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Phone</label>
          <input v-model="form.phone" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
          <input v-model="form.email" type="email" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Emirates ID</label>
          <input v-model="form.emirates_id" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Passport No</label>
          <input v-model="form.passport_no" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Nationality</label>
          <input v-model="form.nationality" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Address</label>
          <textarea v-model="form.address" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" rows="3"></textarea>
        </div>

        <div class="flex gap-4 pt-4">
          <button type="submit" class="px-6 py-2 bg-[#137fec] text-white rounded-lg font-medium hover:bg-[#137fec]/90">{{ owner ? 'Update' : 'Save' }}</button>
          <Link :href="route('owners.index')" class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50">Cancel</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ owner: Object })

const form = useForm({
  name: props.owner?.name || '',
  phone: props.owner?.phone || '',
  email: props.owner?.email || '',
  emirates_id: props.owner?.emirates_id || '',
  passport_no: props.owner?.passport_no || '',
  nationality: props.owner?.nationality || '',
  address: props.owner?.address || ''
})

const submit = () => {
  if (props.owner) {
    form.put(route('owners.update', props.owner.id))
  } else {
    form.post(route('owners.store'))
  }
}
</script>