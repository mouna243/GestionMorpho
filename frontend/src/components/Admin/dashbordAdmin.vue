<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-green-50">
    <!-- SideNavBar -->
    <aside
        class="fixed left-0 top-0 h-full w-[260px] bg-violet-600 dark:bg-violet-900 shadow-2xl flex flex-col py-6 z-50">
        <div class="px-6 mb-10">
            <h1 class="text-2xl font-black text-white font-plus-jakarta">Morpho Gestion</h1>
            <p class="text-violet-200 text-xs font-semibold uppercase tracking-widest mt-1">Administration</p>
        </div>
        <nav class="flex-1 space-y-2">
            <a class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span><router-link to="/admin/dashboard">Dashboard</router-link></span>
            </a>
            <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined" data-icon="restaurant_menu"
                    style="font-variation-settings: 'FILL' 1;">restaurant_menu</span>
                <span><router-link to="/admin/plats">Gestion des plats</router-link></span>
            </a>
            <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                <span><router-link to="/admin/departements">Gestion Départements</router-link></span>
            </a>
            <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined">calendar_clock</span>
                <span><router-link to="/admin/WorkShift">Gestion des WorkShifts</router-link></span>
            </a>
                        <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined">king_bed</span>
                <span><router-link to="/admin/chambers">Gestion des Chambers</router-link></span>
            </a>
        </nav>
        <div class="px-4 mt-auto pt-6 border-t border-violet-500/30">

            <div class="space-y-1">
                <a class="text-violet-100 hover:text-white px-4 py-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                    href="#">
                    <span class="material-symbols-outlined" data-icon="help">help</span>
                    <span>Aide</span>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                    href="#">
                    <span class="material-symbols-outlined" data-icon="logout">logout</span>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </aside>


    <!-- Main Content -->
    <div class="ml-64">
      <!-- Header with Search -->
      <header class="bg-white/70 backdrop-blur-lg shadow-sm sticky top-0 z-30">
        <div class="flex items-center justify-between px-8 py-4">
          <div class="flex-1 max-w-md">
            <div class="relative">
              <input 
                type="text" 
                v-model="searchQuery"
                placeholder="Rechercher..." 
                class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
              >
              <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
          </div>
          
          <div class="flex items-center space-x-4">
            <div class="relative">
              <button class="relative p-2 text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
              </button>
            </div>
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
          </div>
        </div>
      </header>

      <main class="p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-blue-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Chambres Totales</p>
                <p class="text-2xl font-bold text-gray-800">452</p>
                
              </div>
              <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-purple-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Plats Disponibles</p>
                <p class="text-2xl font-bold text-gray-800">45</p>
              </div>
              <div class="p-3 bg-purple-100 rounded-full">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 17v4"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-green-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Personnel Total</p>
                <p class="text-2xl font-bold text-gray-800">45</p>
              </div>
              <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-yellow-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Taux Occupation</p>
                <p class="text-2xl font-bold text-gray-800">55%</p>
              </div>
              <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Admin Tasks Section -->
        <div class="mb-8">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Tâches Administratives</h2>
            <button class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
              + Nouvelle Tâche
            </button>
          </div>
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="divide-y divide-gray-200">
              <div v-for="task in adminTasks" :key="task.id" class="p-4 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="font-medium text-gray-800">menage</p>
                    <p class="text-sm text-gray-500">organiser les chambers</p>
                  </div>
                  <span :class="task.priority === 'high' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'" class="px-2 py-1 text-xs rounded-full">
                   normale
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
          <!-- Absences Section -->
          <div>
            <h2 class="mb-4 text-xl font-semibold text-gray-800">Absences</h2>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">check</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="absence in absences" :key="absence.id">
                        <td class="flex justify-center items-center"> <input type="checkbox"></td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12/12/2023</td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="absence.justified ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 py-1 text-xs rounded-full">
                         justifier
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Quick Stats Section -->
          <div>
            <h2 class="mb-4 text-xl font-semibold text-gray-800">Statistiques Rapides</h2>
            <div class="grid grid-cols-2 gap-4">
              <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg text-white">
                <p class="text-sm">Chambres Occupées</p>
                <p class="text-2xl font-bold">12</p>
                
              </div>
              <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg text-white">
                <p class="text-sm">Sessions SPA</p>
                <p class="text-2xl font-bold">15</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg text-white">
                <p class="text-sm">Types de Chambres</p>
                <p class="text-2xl font-bold">78</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg text-white">
                <p class="text-sm">Workshifts Actifs</p>
                <p class="text-2xl font-bold">12</p>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>



<style scoped>
.wave-card {
  position: relative;
  overflow: hidden;
}


</style>