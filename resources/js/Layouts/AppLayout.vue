<template>
  <div class="min-h-screen bg-[#f6f7f8] flex">
    <!-- Sidebar -->
    <aside class="bg-white border-r border-slate-200 fixed h-full overflow-y-auto transition-all duration-300" :class="sidebarOpen ? 'w-64' : 'w-16'">
      <div class="p-4 border-b border-slate-200 flex items-center justify-between">
        <h1 v-show="sidebarOpen" class="text-xl font-bold text-slate-900">Real Estate</h1>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-100 rounded-lg">
          <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
      <nav class="p-4 space-y-1">
        <Link :href="route('dashboard')" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="route().current('dashboard') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-900'">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          <span v-show="sidebarOpen" class="text-sm font-medium">Home</span>
        </Link>

        <!-- Contracts Dropdown -->
        <div>
          <button @click="contractsOpen = !contractsOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-900">
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <span v-show="sidebarOpen" class="text-sm font-medium">Contracts</span>
            </div>
            <svg v-show="sidebarOpen" class="w-4 h-4 transition-transform" :class="{'rotate-180': contractsOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div v-show="contractsOpen && sidebarOpen" class="ml-4 mt-1 space-y-1">
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
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
              <span v-show="sidebarOpen" class="text-sm font-medium">Properties</span>
            </div>
            <svg v-show="sidebarOpen" class="w-4 h-4 transition-transform" :class="{'rotate-180': propertiesOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div v-show="propertiesOpen && sidebarOpen" class="ml-4 mt-1 space-y-1">
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
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          <span v-show="sidebarOpen" class="text-sm font-medium">Owners</span>
        </Link>

        <Link :href="route('tenants.index')" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="route().current('tenants.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-900'">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          <span v-show="sidebarOpen" class="text-sm font-medium">Tenants</span>
        </Link>

        <Link :href="route('payments.index')" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="route().current('payments.*') ? 'bg-[#137fec] text-white' : 'hover:bg-slate-50 text-slate-900'">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span v-show="sidebarOpen" class="text-sm font-medium">Payments</span>
        </Link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-16'">
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

const sidebarOpen = ref(true)
const contractsOpen = ref(true)
const propertiesOpen = ref(true)

const logout = () => {
  router.post('/logout')
}
</script>