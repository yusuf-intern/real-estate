<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <Link :href="route('subunits.index')" class="hover:text-[#137fec]">Subunits</Link>
      <span class="mx-2">/</span>
      <span>Edit</span>
    </template>

    <div class="max-w-2xl">
      <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Subunit</h1>

      <form @submit.prevent="submit" class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Unit</label>
          <select v-model="form.unit_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
            <option value="">Select Unit</option>
            <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.building.building_name }} - Unit {{ unit.unit_no }}</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Subunit Number</label>
          <input v-model="form.subunit_no" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Type</label>
          <input v-model="form.subunit_type" type="text" placeholder="room, partition, hall, etc." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Area (sqft)</label>
          <input v-model="form.area_sqft" type="number" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
          <select v-model="form.status" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
            <option value="vacant">Vacant</option>
            <option value="occupied">Occupied</option>
          </select>
        </div>

        <div class="flex gap-4 pt-4">
          <button type="submit" class="px-6 py-2 bg-[#137fec] text-white rounded-lg font-medium hover:bg-[#137fec]/90">Update</button>
          <Link :href="route('subunits.index')" class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50">Cancel</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ subunit: Object, units: Array })

const form = useForm({
  unit_id: props.subunit.unit_id,
  subunit_no: props.subunit.subunit_no,
  subunit_type: props.subunit.subunit_type,
  area_sqft: props.subunit.area_sqft,
  status: props.subunit.status
})

const submit = () => form.put(route('subunits.update', props.subunit.id))
</script>