<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <span>Subunits</span>
    </template>

    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-900">Subunits</h1>
        <Link :href="route('subunits.create')" class="px-4 py-2 bg-[#137fec] text-white rounded-lg font-medium hover:bg-[#137fec]/90">
          Add Subunit
        </Link>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Building</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Unit</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Subunit No</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Type</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Area (sqft)</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr v-for="subunit in subunits.data" :key="subunit.id" class="hover:bg-slate-50">
              <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ subunit.unit?.building?.building_name }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ subunit.unit?.unit_no }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ subunit.subunit_no }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ subunit.subunit_type }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ subunit.area_sqft }}</td>
              <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-bold rounded-md bg-green-50 text-green-700">{{ subunit.status }}</span></td>
              <td class="px-6 py-4 text-sm space-x-2">
                <Link :href="route('subunits.edit', subunit.id)" class="text-[#137fec] hover:underline">Edit</Link>
                <button @click="destroy(subunit.id)" class="text-red-600 hover:underline">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({ subunits: Object })

const destroy = (id) => {
  if (confirm('Delete this subunit?')) {
    router.delete(route('subunits.destroy', id))
  }
}
</script>