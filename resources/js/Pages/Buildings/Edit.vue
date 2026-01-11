<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <Link :href="route('buildings.index')" class="hover:text-[#137fec]">Buildings</Link>
      <span class="mx-2">/</span>
      <span>Edit</span>
    </template>

    <div class="max-w-2xl">
      <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Building</h1>

      <form @submit.prevent="submit" class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Owner</label>
          <select v-model="form.owner_id" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required>
            <option value="">Select Owner</option>
            <option v-for="owner in owners" :key="owner.id" :value="owner.id">{{ owner.name }}</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Building Name</label>
          <input v-model="form.building_name" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Address</label>
          <input v-model="form.address" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">City</label>
          <input v-model="form.city" type="text" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#137fec]" required />
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
          <Link :href="route('buildings.index')" class="px-6 py-2 border border-slate-200 text-slate-600 rounded-lg font-medium hover:bg-slate-50">Cancel</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ building: Object, owners: Array })

const form = useForm({
  owner_id: props.building.owner_id,
  building_name: props.building.building_name,
  address: props.building.address,
  city: props.building.city,
  status: props.building.status
})

const submit = () => form.put(route('buildings.update', props.building.id))
</script>