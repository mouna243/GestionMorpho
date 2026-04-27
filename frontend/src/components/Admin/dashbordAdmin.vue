<script setup>
import { ref, onMounted } from 'vue';

const stats = ref({});
const absences = ref([]);
const tasks = ref([]);

async function fetchStats() {
  const res = await fetch('http://localhost:8080/api/admin/stats');
  const json = await res.json();
  stats.value = json.data;
}

async function fetchAbsences() {
  const res = await fetch('http://localhost:8080/api/admin/absences');
  const json = await res.json();
  absences.value = json.data;
}

async function fetchTasks() {
  const res = await fetch('http://localhost:8080/api/tasks');
  const json = await res.json();
  tasks.value = json.data.data ?? json.data;
}

onMounted(() => {
  fetchStats();
  fetchAbsences();
  fetchTasks();
});
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
        <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
          href="#">
                    <span class="material-symbols-outlined">sentiment_calm</span>
          <span><router-link to="/admin/SpaSession">Gestion des SPA Sessions</router-link></span>
        </a>
      </nav>
      <div class="px-4 mt-auto pt-6 border-t border-violet-500/30">

        <div class="space-y-1">
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
      <header
        class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm flex justify-between items-center px-8 py-4">
        <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Dashboard</h2>
        <div class="flex items-center gap-4 border-l pl-6 border-gray-200">
          <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center text-violet-600">
            <span class="material-symbols-outlined">account_circle</span>
          </div>
          <span class="text-sm font-bold text-gray-700">Admin</span>
        </div>
      </header>

      <main class="p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-blue-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Chambres Totales</p>
                <p class="text-2xl font-bold text-gray-800">{{ stats.total_chambres ?? '...' }}</p>
              </div>
              <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                  </path>
                </svg>
              </div>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-purple-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Plats Disponibles</p>
                <p class="text-2xl font-bold text-gray-800">{{ stats.plats_dispo ?? '...' }}</p>
              </div>
              <div class="p-3 bg-purple-100 rounded-full">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 17v4"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-green-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Personnel Total</p>
                <p class="text-2xl font-bold text-gray-800">{{ stats.total_staff ?? '...' }}</p>
              </div>
              <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                  </path>
                </svg>
              </div>
            </div>
          </div>

          <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-yellow-500 wave-card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Départements</p>
                <p class="text-2xl font-bold text-gray-800">{{ stats.total_departements ?? '...' }}</p>
              </div>
              <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                  </path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Admin Tasks Section -->
        <div class="mb-8">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Tâches Administratives</h2>
            <span class="px-3 py-1 text-sm bg-violet-100 text-violet-700 rounded-full font-semibold">{{ tasks.length }}
              tâche(s)</span>
          </div>
          <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="divide-y divide-gray-200">
              <div v-if="tasks.length === 0" class="p-6 text-center text-sm text-gray-400">Aucune tâche trouvée</div>
              <div v-for="task in tasks" :key="task.id" class="p-4 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <div :class="task.is_completed ? 'bg-green-100' : 'bg-violet-100'"
                      class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                      <span :class="task.is_completed ? 'text-green-600' : 'text-violet-600'"
                        class="material-symbols-outlined text-base">
                        {{ task.is_completed ? 'check_circle' : 'pending' }}
                      </span>
                    </div>
                    <div>
                      <p class="font-medium text-gray-800">{{ task.name }}</p>
                      <p class="text-sm text-gray-500">{{ task.description }}</p>
                    </div>
                  </div>
                  <span :class="task.is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'"
                    class="px-2 py-1 text-xs rounded-full font-semibold">
                    {{ task.is_completed ? 'Terminée' : 'En cours' }}
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
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Personnel</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="absences.length === 0">
                      <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-400">Aucune absence enregistrée
                      </td>
                    </tr>
                    <tr v-for="absence in absences" :key="absence.id">
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                        {{ absence.staff?.name ?? '—' }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ absence.created_at?.substring(0, 10) }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="absence.is_justified ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                          class="px-2 py-1 text-xs rounded-full">
                          {{ absence.is_justified ? 'Justifiée' : 'Non justifiée' }}
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
                <p class="text-sm">Chambres Disponibles</p>
                <p class="text-2xl font-bold">{{ stats.chambres_dispo ?? '...' }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg text-white">
                <p class="text-sm">Total Plats</p>
                <p class="text-2xl font-bold">{{ stats.total_plats ?? '...' }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg text-white">
                <p class="text-sm">Workshifts</p>
                <p class="text-2xl font-bold">{{ stats.total_workshifts ?? '...' }}</p>
              </div>
              <div class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg text-white">
                <p class="text-sm">Absences Justifiées</p>
                <p class="text-2xl font-bold">{{ stats.absences_justifiees ?? '...' }}</p>
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