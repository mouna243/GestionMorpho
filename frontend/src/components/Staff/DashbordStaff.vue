<script setup>
import { ref, computed, onMounted } from 'vue';
import { useAuth } from '../../composables/useAuth';

const { logout } = useAuth();

const me = ref(null);
const stats = ref({});
const absences = ref([]);
const tasks = ref([]);

const token = localStorage.getItem('token');

async function fetchMe() {
    const res = await fetch('http://localhost:8080/api/auth/me', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    me.value = json.user;
}

async function fetchStats() {
    const res = await fetch('http://localhost:8080/api/staff/stats', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    stats.value = json.data;
}

async function fetchAbsences() {
    const res = await fetch('http://localhost:8080/api/staff/absences', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    const all = json.data.data ?? json.data;
    // filter by authenticated user staff_id
    absences.value = me.value
        ? all.filter(a => a.staff_id == me.value.id)
        : all;
}

async function fetchTasks() {
    const res = await fetch('http://localhost:8080/api/staff/tasks', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    const all = json.data.data ?? json.data;
    // filter tasks by the authenticated user's departement_id
    tasks.value = me.value?.departement_id
        ? all.filter(t => t.departement_id == me.value.departement_id)
        : all;
}

const myAbsencesJustified = computed(() => absences.value.filter(a => a.is_justified).length);
const myAbsencesNonJustified = computed(() => absences.value.filter(a => !a.is_justified).length);

onMounted(async () => {
    await fetchMe();
    await Promise.all([fetchStats(), fetchAbsences(), fetchTasks()]);
});
</script>

<template>
  <div class="app-container">
    <!-- Sidebar Shell -->
    <aside class="fixed left-0 top-0 h-full w-[260px] bg-[#a23759] shadow-2xl flex flex-col h-full py-6 z-50">
      <div class="px-8 mb-10">
        <h1 class="text-2xl font-black text-white font-headline-xl">Morpho Gestion</h1>
        <p class="text-[#fdf2f5] text-label-md">Staff Dashboard</p>
      </div>
      <nav class="flex-1 space-y-2">
        <!-- Active State: Tableau de bord -->
         <router-link to="/Staff/dashbord">
        <a class="bg-white text-[#a23759] rounded-full mx-4 px-4 py-3 flex items-center gap-3 font-bold transition-all scale-95 active:scale-90" href="#">
          <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
          <span class="font-body-md">Tableau de bord</span>
        </a>
    </router-link>
      </nav>
      <div class="mt-auto px-6">
        <div class="bg-[#8a2f4b]/30 rounded-xl p-4 flex items-center gap-3">
          <!-- icon deconnection -->
          <span class="text-white material-symbols-outlined" data-icon="logout">logout</span>
          <div class="overflow-hidden">
         <!--   logout  -->
            <button @click="logout" class="text-white font-bold text-label-md leading-none block cursor-pointer">Déconnexion</button>
          </div>
        </div>
      </div>
    </aside>

    <!-- Top Navigation -->
    <header class="fixed top-0 right-0 left-[260px] h-16 bg-white/80 backdrop-blur-md border-b border-slate-100 flex justify-between items-center px-8 w-full z-40">
     
      <div class="flex items-center space-x-4 flex-1">
        <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Tableau de bord</h2>
      </div>

    </header>

    <!-- Main Content Canvas -->
    <main class="ml-[260px] pt-24 px-8 pb-12">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="font-headline-xl text-[#191c1e]">Bonjour, {{ me?.name ?? '...' }}</h2>
          <p class="text-[#494454] font-body-md">Voici l'aperçu de vos effectifs aujourd'hui.</p>
        </div>
    
      </div>

      <!-- Metrics Bento Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <!-- Total Workers -->
        <div class="bg-white p-6 rounded-xl shadow-[0_15px_30px_-15px_rgba(112,207,203,0.04)] border border-slate-50 flex items-center gap-4">
          <div class="w-14 h-14 bg-[#a23759]/10 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#a23759] text-3xl" data-icon="groups">groups</span>
          </div>
          <div>
            <p class="text-label-md text-[#494454] uppercase tracking-wider">Total Workers</p>
            <p class="text-headline-xl text-[#191c1e]">{{ stats.total_staff ?? '...' }}</p>
          </div>
        </div>
        <!-- Absences Justifiées -->
        <div class="bg-white p-6 rounded-xl shadow-[0_15px_30px_-15px_rgba(112,207,203,0.04)] border border-slate-50 flex items-center gap-4">
          <div class="w-14 h-14 bg-[#a23759]/20 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#a23759] text-3xl" data-icon="verified_user">verified_user</span>
          </div>
          <div>
            <p class="text-label-md text-[#494454] uppercase tracking-wider">Absences Justifiées</p>
            <p class="text-headline-xl text-[#191c1e]">{{ myAbsencesJustified }}</p>
          </div>
        </div>
        <!-- Absences Non Justifiées -->
        <div class="bg-white p-6 rounded-xl shadow-[0_15px_30px_-15px_rgba(112,207,203,0.04)] border border-slate-50 flex items-center gap-4">
          <div class="w-14 h-14 bg-[#ffdad6] rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#ba1a1a] text-3xl" data-icon="warning">warning</span>
          </div>
          <div>
            <p class="text-label-md text-[#494454] uppercase tracking-wider">Absences Non Justifiées</p>
            <p class="text-headline-xl text-[#191c1e]">{{ myAbsencesNonJustified }}</p>
          </div>
        </div>
        <!-- Total Départements -->
        <div class="bg-white p-6 rounded-xl shadow-[0_15px_30px_-15px_rgba(112,207,203,0.04)] border border-slate-50 flex items-center gap-4">
          <div class="w-14 h-14 bg-[#d8e2ff] rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#0058be] text-3xl" data-icon="domain">domain</span>
          </div>
          <div>
            <p class="text-label-md text-[#494454] uppercase tracking-wider">Total des Départements</p>
            <p class="text-headline-xl text-[#191c1e]">{{ stats.total_departements ?? '...' }}</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Left Side: Absences of the RH -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(112,207,203,0.04)] overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-headline-lg text-[#191c1e]">Mes Absences</h3>
            <span class="px-3 py-1 bg-[#a23759]/10 text-[#a23759] text-label-md rounded-full">{{ absences.length }} absence(s)</span>
          </div>
          <div class="p-6">
            <table class="w-full text-left">
              <thead>
                <tr class="text-label-md text-[#494454] border-b border-slate-100">
                  <th class="pb-4 font-semibold uppercase">Workshift</th>
                  <th class="pb-4 font-semibold uppercase">Date</th>
                  <th class="pb-4 font-semibold uppercase">Statut</th>
                </tr>
              </thead>
              <tbody class="text-body-sm">
                <tr v-if="absences.length === 0">
                  <td colspan="3" class="py-6 text-center text-[#494454] text-sm">Aucune absence enregistrée</td>
                </tr>
                <tr v-for="absence in absences" :key="absence.id" class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                  <td class="py-4 text-[#494454]"># {{ absence.workshift_id }}</td>
                  <td class="py-4 text-[#494454]">{{ absence.created_at?.substring(0, 10) }}</td>
                  <td class="py-4">
                    <span :class="absence.is_justified ? 'bg-[#a23759]/30 text-[#a23759]' : 'bg-[#ffdad6] text-[#ba1a1a]'"
                      class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold">
                      <span :class="absence.is_justified ? 'bg-[#a23759]' : 'bg-[#ba1a1a]'" class="w-1.5 h-1.5 rounded-full"></span>
                      {{ absence.is_justified ? 'Justifiée' : 'Non Justifiée' }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Right Side: Tasks & Quick Actions -->
        <div class="space-y-5">
          <div class="bg-[#a23759] p-6 rounded-xl text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
              <h3 class="font-headline-lg mb-1">Tâches du jour</h3>
              <p class="text-[#fdf2f5] text-body-sm mb-4">{{ tasks.length }} tâche(s) assignée(s)</p>
              <ul class="space-y-3">
                <li v-if="tasks.length === 0" class="text-[#fdf2f5] text-sm">Aucune tâche trouvée</li>
                <li v-for="task in tasks" :key="task.id"
                  :class="task.is_completed ? 'opacity-60 line-through' : ''"
                  class="flex items-start gap-3 bg-white/10 p-3 rounded-lg backdrop-blur-sm">
                  <span class="material-symbols-outlined text-[#fdf2f5]">
                    {{ task.is_completed ? 'check_circle' : 'task_alt' }}
                  </span>
                  <div>
                    <p class="text-label-md font-bold">{{ task.name }}</p>
                    <p class="text-[10px] text-[#fdf2f5] opacity-80">{{ task.description }}</p>
                  </div>
                </li>
              </ul>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>



