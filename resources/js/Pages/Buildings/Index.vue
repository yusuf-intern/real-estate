<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <span>Buildings</span>
    </template>

    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-900">Buildings</h1>
        <Link :href="route('buildings.create')" class="px-4 py-2 bg-[#137fec] text-white rounded-lg font-medium hover:bg-[#137fec]/90">
          Add Building
        </Link>
      </div>

      <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Building Name</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Owner</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Address</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">City</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr v-for="building in buildings.data" :key="building.id" class="hover:bg-slate-50">
              <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ building.building_name }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ building.owner?.name }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ building.address }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ building.city }}</td>
              <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-bold rounded-md bg-green-50 text-green-700">{{ building.status }}</span></td>
              <td class="px-6 py-4 text-sm space-x-2">
                <Link :href="route('buildings.edit', building.id)" class="text-[#137fec] hover:underline">Edit</Link>
                <button @click="destroy(building.id)" class="text-red-600 hover:underline">Delete</button>
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

defineProps({ buildings: Object })

const destroy = (id) => {
  if (confirm('Delete this building?')) {
    router.delete(route('buildings.destroy', id))
  }
}
</script>