<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <Link :href="route('units.index')" class="hover:text-[#137fec]">Units</Link>
      <span class="mx-2">/</span>
      <span>Create</span>
    </template>

    <div class="max-w-2xl">
      <h1 class="text-2xl font-bold text-slate-900 mb-6">Add Unit</h1>

      <form @submit.prevent="submit" class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Building</label>
          <select v-model="form.building_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
            <option value="">Select Building</option>
            <option v-for="building in buildings" :key="building.id" :value="building.id">{{ building.building_name }}</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Unit Number</label>
          <input v-model="form.unit_no" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Floor Number</label>
          <input v-model="form.floor_no" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Area (sqft)</label>
          <input v-model="form.area_sqft" type="number" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Assets (comma separated)</label>
          <input v-model="assetsInput" type="text" placeholder="AC, Fridge, Washing Machine" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
          <select v-model="form.status" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
            <option value="vacant">Vacant</option>
            <option value="occupied">Occupied</option>
          </select>
        </div>

        <div class="flex gap-4 pt-4">
          <button type="submit" class="px-6 py-2 bg-[#137fec] text-white rounded-lg font-medium hover:bg-[#137fec]/90">Save</button>
          <Link :href="route('units.index')" class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50">Cancel</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ buildings: Array })

const assetsInput = ref('')
const form = useForm({
  building_id: '',
  unit_no: '',
  floor_no: '',
  area_sqft: '',
  assets: [],
  status: 'vacant'
})

watch(assetsInput, (val) => {
  form.assets = val ? val.split(',').map(s => s.trim()) : []
})

const submit = () => form.post(route('units.store'))
</script>