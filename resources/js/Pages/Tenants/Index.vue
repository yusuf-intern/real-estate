<template>
  <AppLayout>
    <template #breadcrumb>
      <Link href="/" class="hover:text-[#137fec]">Home</Link>
      <span class="mx-2">/</span>
      <span>Tenants</span>
    </template>

    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-900">Tenants</h1>
        <Link :href="route('tenants.create')" class="px-4 py-2 bg-[#137fec] text-white rounded-lg font-medium hover:bg-[#137fec]/90">Add Tenant</Link>
      </div>
<div class="bg-white rounded-xl p-4 border border-slate-200">
  <input 
    v-model="search"
    @input="filterResults"
    type="text"
    placeholder="Search by tenant..."
    class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#137fec]"
  />
</div>
      <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Name</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Phone</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Email</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Nationality</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            <tr v-for="tenant in tenants.data" :key="tenant.id" class="hover:bg-slate-50">
              <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ tenant.name }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ tenant.phone }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ tenant.email }}</td>
              <td class="px-6 py-4 text-sm text-slate-900">{{ tenant.nationality }}</td>
              <td class="px-6 py-4 text-sm space-x-2">
                <div class="flex items-center gap-3">
                <Link :href="route('tenants.edit', tenant.id)" class="text-[#137fec] hover:underline">Edit</Link>
                <button @click="destroy(tenant.id)" class="text-red-600 hover:underline">Delete</button>
             </div>
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
defineProps({ tenants: Object })
const destroy = (id) => {
  if (confirm('Delete this tenant?')) router.delete(route('tenants.destroy', id))
}

const search = ref('')

const filterResults = () => {
  router.get(route('tenants.index'), { search: search.value }, { preserveState: true })
}
</script>
