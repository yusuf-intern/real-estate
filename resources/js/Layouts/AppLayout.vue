<template>
  <div class="min-h-screen bg-[#f6f7f8] flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 fixed h-full overflow-y-auto">
      <div class="p-6 border-b border-slate-200">
        <h1 class="text-xl font-bold text-slate-900">Real Estate</h1>
      </div>
      <nav class="p-4 space-y-1">
        <Link :href="route('dashboard')" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="route().current('dashboard') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-900'">
          <span class="text-sm font-medium">Home</span>
        </Link>

        <!-- Contracts Dropdown -->
        <div>
          <button @click="contractsOpen = !contractsOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-900">
            <span class="text-sm font-medium">Contracts</span>
            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': contractsOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div v-show="contractsOpen" class="ml-4 mt-1 space-y-1">
            <Link :href="route('owner-contracts.index')" class="flex items-center px-4 py-2 rounded-lg text-sm transition-colors" :class="route().current('owner-contracts.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-700'">
              Owner Contracts
            </Link>
            <Link :href="route('tenant-contracts.index')" class="flex items-center px-4 py-2 rounded-lg text-sm transition-colors" :class="route().current('tenant-contracts.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-700'">
              Tenant Contracts
            </Link>
          </div>
        </div>

        <!-- Properties Dropdown -->
        <div>
          <button @click="propertiesOpen = !propertiesOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-900">
            <span class="text-sm font-medium">Properties</span>
            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': propertiesOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div v-show="propertiesOpen" class="ml-4 mt-1 space-y-1">
            <Link :href="route('buildings.index')" class="flex items-center px-4 py-2 rounded-lg text-sm transition-colors" :class="route().current('buildings.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-700'">
              Buildings
            </Link>
            <Link :href="route('units.index')" class="flex items-center px-4 py-2 rounded-lg text-sm transition-colors" :class="route().current('units.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-700'">
              Units
            </Link>
            <Link :href="route('subunits.index')" class="flex items-center px-4 py-2 rounded-lg text-sm transition-colors" :class="route().current('subunits.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-700'">
              Subunits
            </Link>
          </div>
        </div>

        <Link :href="route('owners.index')" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="route().current('owners.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-900'">
          <span class="text-sm font-medium">Owners</span>
        </Link>

        <Link :href="route('tenants.index')" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="route().current('tenants.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-900'">
          <span class="text-sm font-medium">Tenants</span>
        </Link>

        <Link :href="route('payments.index')" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="route().current('payments.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-900'">
          <span class="text-sm font-medium">Payments</span>
        </Link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="ml-64 flex-1">
      <!-- Top Bar -->
      <header class="bg-white border-b border-slate-200 px-6 py-4 sticky top-0 z-10">
        <div class="flex items-center justify-between">
          <nav class="text-sm text-slate-600">
            <slot name="breadcrumb" />
          </nav>
          <form @submit.prevent="logout" method="post">
            <button type="submit" class="text-sm text-slate-600 hover:text-slate-900">Logout</button>
          </form>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const contractsOpen = ref(true)
const propertiesOpen = ref(true)

const logout = () => {
  router.post('/logout')
}
</script>