<script setup>
import { ref, computed, onMounted } from 'vue';
import { useAuth } from '../../../composables/useAuth';

const { logout } = useAuth();

const token = localStorage.getItem('token');

const me = ref(null);
const stats = ref({});
const myTasks = ref([]);
const myAbsences = ref([]);
const departements = ref([]);
const allTasks = ref([]);

// task modal
const showTaskModal = ref(false);
const taskModalMode = ref('add');
const editTaskId = ref(null);
const taskForm = ref({ name: '', description: '', departement_id: '' });
const taskErrors = ref({});

const tasksTerminees = computed(() => allTasks.value.filter(t => t.is_completed).length);
const tasksEnCours = computed(() => allTasks.value.filter(t => !t.is_completed).length);

async function fetchMe() {
    const res = await fetch('http://localhost:8080/api/auth/me', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    me.value = json.user;
}

async function fetchStats() {
    const res = await fetch('http://localhost:8080/api/staff/chef/stats', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    stats.value = json.data;
}

async function fetchMyTasks() {
    const res = await fetch('http://localhost:8080/api/staff/chef/tasks', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    allTasks.value = json.data.data ?? json.data;
    myTasks.value = allTasks.value;
}

async function fetchMyAbsences() {
    const res = await fetch('http://localhost:8080/api/staff/chef/absences', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    const all = json.data.data ?? json.data;
    myAbsences.value = me.value ? all.filter(a => a.staff_id == me.value.id) : all;
}

async function fetchDepartements() {
    const res = await fetch('http://localhost:8080/api/staff/chef/departements', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    const depts = json.data.data ?? json.data;
    departements.value = await Promise.all(
        depts.map(async d => {
            const r = await fetch(`http://localhost:8080/api/staff/chef/departements/${d.id}`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            const j = await r.json();
            return j.data;
        })
    );
}

function deptTasks(deptId) {
    return allTasks.value.filter(t => t.departement_id == deptId);
}

function openAddTask(deptId) {
    taskModalMode.value = 'add';
    editTaskId.value = null;
    taskForm.value = { name: '', description: '', departement_id: deptId };
    taskErrors.value = {};
    showTaskModal.value = true;
}

function openEditTask(task) {
    taskModalMode.value = 'edit';
    editTaskId.value = task.id;
    taskForm.value = { name: task.name, description: task.description, departement_id: task.departement_id };
    taskErrors.value = {};
    showTaskModal.value = true;
}

async function submitTask(e) {
    e.preventDefault();
    taskErrors.value = {};
    const isEdit = taskModalMode.value === 'edit';
    const url = isEdit ? `http://localhost:8080/api/staff/chef/tasks/${editTaskId.value}` : 'http://localhost:8080/api/staff/chef/tasks';
    const res = await fetch(url, {
        method: isEdit ? 'PUT' : 'POST',
        headers: { 
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json', 
          'Accept': 'application/json' 
        },
        body: JSON.stringify({ ...taskForm.value, is_completed: false })
    });
    const json = await res.json();
    if (!res.ok) { taskErrors.value = json.errors ?? {}; return; }
    showTaskModal.value = false;
    await fetchMyTasks();
}

async function deleteTask(id) {
    if (!confirm('Supprimer cette tâche ?')) return;
    await fetch(`http://localhost:8080/api/staff/chef/tasks/${id}`, { 
      method: 'DELETE',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }});
    await fetchMyTasks();
}

onMounted(async () => {
    await fetchMe();
    await Promise.all([fetchStats(), fetchMyTasks(), fetchMyAbsences(), fetchDepartements()]);
});
</script>

<template>
  <div class="app-container">
    <!-- Sidebar Shell -->
    <aside class="fixed left-0 top-0 h-full w-[260px] bg-[#467434] shadow-2xl flex flex-col h-full py-6 z-50">
      <div class="px-8 mb-10">
        <h1 class="text-2xl font-black text-white font-headline-xl">Morpho Gestion</h1>
        <p class="text-[#f9f9f1]/80 text-label-md">RH Dashboard</p>
      </div>
      <nav class="flex-1 space-y-2">
        <router-link to="/ChefPersonnel/dashbord">
        <a class="text-white/80 hover:bg-[#356128]/50 rounded-full mx-4 px-4 py-3 flex items-center gap-3 transition-all scale-95 active:scale-90" href="#">
          <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
          <span class="font-body-md">Tableau de bord</span>
        </a> 
        </router-link>
        
      </nav>
      <div class="mt-auto px-6">
        <button @click="logout"  class="bg-[#356128]/30 rounded-xl p-4 flex items-center gap-3 cursor-pointer block">
          <!-- logout icone -->
           <span class="material-symbols-outlined text-[#f9f9f1]">logout</span>
          <div class="overflow-hidden">
            <p class="text-white font-bold text-body-sm truncate">Logout</p>
          </div>
        </button>
      </div>
    </aside>

    <!-- Top Navigation -->
    <header class="fixed top-0 right-0 left-[260px] h-16 bg-[#f9f9f1]/80 backdrop-blur-md border-b border-[#a9bd83]/20 flex justify-between items-center px-8 w-full z-40">
      <div class="flex items-center gap-4">
        <div class="h-8 w-[1px] bg-[#a9bd83] mx-2"></div>
        <p class="text-body-sm font-bold text-[#467434]">Morpho Gestion</p>
      </div>
    </header>

      <main class="ml-[260px] pt-24 px-8 pb-12 bg-[#f9f9f1]">
          <div class="statistics-container">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <!-- Total Personnel -->
      <div class="bg-white rounded-xl shadow-lg border border-[#a9bd83]/20 p-6 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-label-md text-[#467434]/60 uppercase tracking-wider">Total Personnel</p>
            <p class="text-headline-xl text-[#467434] mt-2">{{ stats.total_staff ?? '...' }}</p>
            <p class="text-body-sm text-[#467434]/50 mt-1">Employés actifs</p>
          </div>
          <div class="w-14 h-14 bg-[#a9bd83]/20 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#467434] text-3xl">groups</span>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-[#a9bd83]/10">
          <div class="flex justify-between text-xs">
            <span class="text-[#467434]/60">8 Départements</span>
            <span class="text-[#467434]/60">+12 cette année</span>
          </div>
        </div>
      </div>

      <!-- Tâches Finies -->
      <div class="bg-white rounded-xl shadow-lg border border-[#a9bd83]/20 p-6 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-label-md text-[#467434]/60 uppercase tracking-wider">Tâches Terminées</p>
            <p class="text-headline-xl text-[#467434] mt-2">{{ tasksTerminees }}</p>
            <p class="text-body-sm text-[#467434]/50 mt-1">Ce mois</p>
          </div>
          <div class="w-14 h-14 bg-[#a9bd83]/20 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#467434] text-3xl">task_alt</span>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-[#a9bd83]/10">
          <div class="flex justify-between text-xs">
            <span class="text-green-600">✓ 15 complétées</span>
            <span class="text-[#467434]/60">68% de réussite</span>
          </div>
        </div>
      </div>

      <!-- Tâches Non Finies -->
      <div class="bg-white rounded-xl shadow-lg border border-[#a9bd83]/20 p-6 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-label-md text-[#467434]/60 uppercase tracking-wider">Tâches en Cours</p>
            <p class="text-headline-xl text-[#467434] mt-2">{{ tasksEnCours }}</p>
            <p class="text-body-sm text-[#467434]/50 mt-1">En attente</p>
          </div>
          <div class="w-14 h-14 bg-[#a9bd83]/20 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#467434] text-3xl">pending</span>
          </div>
        </div>
        <div class="mt-4 pt-4 border-t border-[#a9bd83]/10">
          <div class="flex justify-between text-xs">
            <span class="text-orange-600">⚠ 7 en retard</span>
            <span class="text-[#467434]/60">4 à temps</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Tâches et Absences Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Tâches Liste -->
      <div class="bg-white rounded-xl shadow-lg border border-[#a9bd83]/20 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-[#a9bd83]/10 to-transparent border-b border-[#a9bd83]/20">
          <div class="flex items-center justify-between">
            <h3 class="font-headline-lg text-[#467434] flex items-center gap-2">
              <span class="material-symbols-outlined text-[#a9bd83]">checklist</span>
              Tâches Récents
            </h3>
            <span class="text-xs text-[#467434]/50">Cette semaine</span>
          </div>
        </div>
        <div class="divide-y divide-[#a9bd83]/10">
          <div v-if="myTasks.length === 0" class="px-6 py-4 text-sm text-[#467434]/50 text-center">Aucune tâche</div>
          <div v-for="task in myTasks.slice(0,5)" :key="task.id" class="px-6 py-4 flex items-center justify-between hover:bg-[#f9f9f1] transition-colors">
            <div class="flex items-center gap-3">
              <span :class="task.is_completed ? 'text-green-600' : 'text-[#a9bd83]'" class="material-symbols-outlined text-base">
                {{ task.is_completed ? 'check_circle' : 'pending' }}
              </span>
              <div>
                <p :class="task.is_completed ? 'line-through text-[#467434]/40' : 'text-[#467434]'" class="font-bold text-sm">{{ task.name }}</p>
                <p class="text-xs text-[#467434]/50">{{ task.description }}</p>
              </div>
            </div>
            <span :class="task.is_completed ? 'bg-green-100 text-green-700' : 'bg-[#a9bd83]/20 text-[#467434]'" class="text-xs px-2 py-1 rounded-full">
              {{ task.is_completed ? 'Terminée' : 'En cours' }}
            </span>
          </div>
        </div>
        <div class="px-6 py-3 bg-[#f9f9f1] border-t border-[#a9bd83]/10">
          <button class="text-sm text-[#467434] font-medium hover:text-[#a9bd83] transition-colors flex items-center gap-1">
            Voir toutes les tâches
            <span class="material-symbols-outlined text-sm">chevron_right</span>
          </button>
        </div>
      </div>

      <!-- Absences Liste -->
      <div class="bg-white rounded-xl shadow-lg border border-[#a9bd83]/20 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-[#a9bd83]/10 to-transparent border-b border-[#a9bd83]/20">
          <div class="flex items-center justify-between">
            <h3 class="font-headline-lg text-[#467434] flex items-center gap-2">
              <span class="material-symbols-outlined text-[#a9bd83]">event_busy</span>
              Absences Certifiées
            </h3>
            <span class="text-xs text-[#467434]/50">Ce mois</span>
          </div>
        </div>
        <div class="divide-y divide-[#a9bd83]/10">
          <div v-if="myAbsences.length === 0" class="px-6 py-4 text-sm text-[#467434]/50 text-center">Aucune absence</div>
          <div v-for="absence in myAbsences.slice(0,5)" :key="absence.id" class="px-6 py-4 flex items-center justify-between hover:bg-[#f9f9f1] transition-colors">
            <div class="flex items-center gap-3">
              <span :class="absence.is_justified ? 'text-green-600' : 'text-red-500'" class="material-symbols-outlined text-base">
                {{ absence.is_justified ? 'verified' : 'warning' }}
              </span>
              <div>
                <p class="font-bold text-sm text-[#467434]">Absence #{{ absence.id }}</p>
                <p class="text-xs text-[#467434]/50">{{ absence.created_at?.substring(0,10) }}</p>
              </div>
            </div>
            <span :class="absence.is_justified ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600'" class="text-xs px-2 py-1 rounded-full">
              {{ absence.is_justified ? 'Justifiée' : 'Non justifiée' }}
            </span>
          </div>
        </div>
        <div class="px-6 py-3 bg-[#f9f9f1] border-t border-[#a9bd83]/10">
          <button class="text-sm text-[#467434] font-medium hover:text-[#a9bd83] transition-colors flex items-center gap-1">
            Voir toutes les absences
            <span class="material-symbols-outlined text-sm">chevron_right</span>
          </button>
        </div>
      </div>
    </div>
  </div>
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="font-headline-xl text-[#467434]">Gestion des Départements & Tâches</h2>
          <p class="text-[#467434]/70 font-body-md">Consultez les départements, créez des tâches et assignez-les aux employés.</p>
        </div>
      </div>

      <!-- Départements Grid -->
      <div class="space-y-8">
        <div v-if="departements.length === 0" class="text-center text-[#467434]/50 py-8">Chargement...</div>

        <div v-for="dept in departements" :key="dept.id" class="bg-white rounded-xl shadow-lg border border-[#a9bd83]/20 overflow-hidden">
          <div class="px-6 py-5 bg-gradient-to-r from-[#a9bd83]/10 to-transparent border-b border-[#a9bd83]/20">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="font-headline-lg text-[#467434] flex items-center gap-2">
                  <span class="material-symbols-outlined text-[#a9bd83]">domain</span>
                  {{ dept.name }}
                </h3>
                <p class="text-label-md text-[#467434]/60 mt-1">{{ dept.staffs?.length ?? 0 }} employé(s)</p>
              </div>
              <button @click="openAddTask(dept.id)" class="bg-[#a9bd83] text-[#467434] px-4 py-2 rounded-lg font-bold flex items-center gap-2 hover:bg-[#9aad76] transition-all active:scale-95 text-sm">
                <span class="material-symbols-outlined text-base">add_task</span>
                Ajouter une tâche
              </button>
            </div>
          </div>

          <!-- Tâches du département -->
          <div class="px-6 py-4 bg-[#f9f9f1]/50 border-b border-[#a9bd83]/10">
            <h4 class="font-bold text-[#467434] text-sm flex items-center gap-2 mb-3">
              <span class="material-symbols-outlined text-[#a9bd83] text-base">checklist</span>
              Tâches ({{ deptTasks(dept.id).length }})
            </h4>
            <div v-if="deptTasks(dept.id).length === 0" class="text-sm text-[#467434]/40 italic">Aucune tâche pour ce département</div>
            <div class="space-y-3">
              <div v-for="task in deptTasks(dept.id)" :key="task.id" class="bg-white rounded-lg border border-[#a9bd83]/20 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <div class="flex items-center gap-3 mb-1">
                      <span :class="task.is_completed ? 'text-green-600' : 'text-[#a9bd83]'" class="material-symbols-outlined text-base">
                        {{ task.is_completed ? 'check_circle' : 'pending' }}
                      </span>
                      <h5 :class="task.is_completed ? 'line-through text-[#467434]/40' : 'text-[#467434]'" class="font-bold">{{ task.name }}</h5>
                      <span :class="task.is_completed ? 'bg-green-100 text-green-700' : 'bg-[#a9bd83]/20 text-[#467434]'" class="text-xs px-2 py-0.5 rounded-full">
                        {{ task.is_completed ? 'Terminée' : 'En cours' }}
                      </span>
                    </div>
                    <p class="text-sm text-[#467434]/70 ml-7">{{ task.description }}</p>
                  </div>
                  <div class="flex gap-1">
                    <button @click="openEditTask(task)" class="p-1 hover:bg-[#a9bd83]/20 rounded-lg transition-colors">
                      <span class="material-symbols-outlined text-sm text-[#467434]">edit</span>
                    </button>
                    <button @click="deleteTask(task.id)" class="p-1 hover:bg-[#ffdad6] rounded-lg transition-colors">
                      <span class="material-symbols-outlined text-sm text-[#ba1a1a]">delete</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Personnel Table -->
          <div class="p-6">
            <div class="overflow-x-auto">
              <table class="w-full text-left">
                <thead>
                  <tr class="text-label-md text-[#467434] border-b border-[#a9bd83]/20">
                    <th class="pb-4 font-semibold uppercase">Employé</th>
                    <th class="pb-4 font-semibold uppercase">Email</th>
                    <th class="pb-4 font-semibold uppercase">Téléphone</th>
                    <th class="pb-4 font-semibold uppercase">Salaire</th>
                  </tr>
                </thead>
                <tbody class="text-body-sm">
                  <tr v-if="!dept.staffs?.length">
                    <td colspan="4" class="py-4 text-center text-sm text-[#467434]/40">Aucun personnel</td>
                  </tr>
                  <tr v-for="staff in dept.staffs" :key="staff.id" class="border-b border-[#a9bd83]/10 hover:bg-[#f9f9f1] transition-colors">
                    <td class="py-4">
                      <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#a9bd83]/30 flex items-center justify-center text-[#467434] font-black text-sm">
                          {{ staff.name.charAt(0).toUpperCase() }}
                        </div>
                        <span class="font-bold text-[#467434]">{{ staff.name }}</span>
                      </div>
                    </td>
                    <td class="py-4 text-[#467434]/70">{{ staff.email }}</td>
                    <td class="py-4 text-[#467434]/70">{{ staff.telephon }}</td>
                    <td class="py-4 text-[#467434]/70">{{ staff.salaire }} DH</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal Tâche -->
  <div v-if="showTaskModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
      <div class="p-6 border-b border-[#a9bd83]/20 flex items-center justify-between">
        <h3 class="font-headline-lg text-[#467434]">{{ taskModalMode === 'add' ? 'Ajouter une Tâche' : 'Modifier la Tâche' }}</h3>
        <button @click="showTaskModal = false" class="p-2 text-[#467434]/50 hover:bg-[#a9bd83]/20 rounded-lg transition-all">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <form @submit="submitTask" class="p-6 space-y-4">
        <div class="space-y-1.5">
          <label class="text-label-md font-semibold text-[#467434]">Nom <span class="text-red-500">*</span></label>
          <input v-model="taskForm.name" type="text" required
            class="w-full border border-[#a9bd83]/40 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#a9bd83]/30 outline-none text-sm" />
          <p v-if="taskErrors.name" class="text-red-500 text-xs">{{ taskErrors.name[0] }}</p>
        </div>
        <div class="space-y-1.5">
          <label class="text-label-md font-semibold text-[#467434]">Description <span class="text-red-500">*</span></label>
          <textarea v-model="taskForm.description" required rows="3"
            class="w-full border border-[#a9bd83]/40 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#a9bd83]/30 outline-none text-sm resize-none"></textarea>
          <p v-if="taskErrors.description" class="text-red-500 text-xs">{{ taskErrors.description[0] }}</p>
        </div>
        <div class="space-y-1.5">
          <label class="text-label-md font-semibold text-[#467434]">Département <span class="text-red-500">*</span></label>
          <select v-model="taskForm.departement_id" required
            class="w-full border border-[#a9bd83]/40 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#a9bd83]/30 outline-none text-sm">
            <option value="" disabled>Sélectionner</option>
            <option v-for="d in departements" :key="d.id" :value="d.id">{{ d.name }}</option>
          </select>
          <p v-if="taskErrors.departement_id" class="text-red-500 text-xs">{{ taskErrors.departement_id[0] }}</p>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" @click="showTaskModal = false"
            class="flex-1 py-3 rounded-xl border border-[#a9bd83]/40 font-bold text-[#467434] hover:bg-[#f9f9f1] transition-all text-sm">Annuler</button>
          <button type="submit"
            class="flex-1 py-3 rounded-xl bg-[#467434] hover:bg-[#356128] text-white font-bold transition-all text-sm">
            {{ taskModalMode === 'add' ? 'Ajouter' : 'Enregistrer' }}
          </button>
        </div>
      </form>
    </div>
  </div>

</template>

