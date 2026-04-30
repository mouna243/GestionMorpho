<script setup>
import { ref, computed, onMounted } from 'vue';
import { useAuth } from '../../../composables/useAuth';

const { logout } = useAuth();

const absences = ref([]);
const loading = ref(false);
const staffList = ref([]);
const workshifts = ref([]);

const token = localStorage.getItem('token');

// justify modal
const showJustifyModal = ref(false);
const currentAbsence = ref(null);
const justifyForm = ref({ is_justified: true, pdf: null });
const justifyError = ref('');
const justifySuccess = ref('');

// create modal
const showCreateModal = ref(false);
const createForm = ref({ staff_id: '', workshift_id: '' });
const createError = ref('');
const createSuccess = ref('');

const totalJustifiees = computed(() => absences.value.filter(a => a.is_justified).length);
const totalNonJustifiees = computed(() => absences.value.filter(a => !a.is_justified).length);

async function fetchAbsences() {
    loading.value = true;
    const res = await fetch('http://localhost:8080/api/staff/rh/absences', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    absences.value = json.data.data ?? json.data;
    loading.value = false;
}

async function fetchStaffAndWorkshifts() {
    const [sRes, wRes] = await Promise.all([
        fetch('http://localhost:8080/api/staff/rh/staff/all', {
            headers: { 'Authorization': `Bearer ${token}` }
        }),
        fetch('http://localhost:8080/api/staff/rh/workshifts', {
            headers: { 'Authorization': `Bearer ${token}` }
        })
    ]);
    const sJson = await sRes.json();
    const wJson = await wRes.json();
    staffList.value = sJson.data.data ?? sJson.data;
    workshifts.value = wJson.data.data ?? wJson.data;
}

function openCreate() {
    createForm.value = { staff_id: '', workshift_id: '' };
    createError.value = '';
    createSuccess.value = '';
    showCreateModal.value = true;
}

async function submitCreate(e) {
    e.preventDefault();
    createError.value = '';
    createSuccess.value = '';
    const res = await fetch('http://localhost:8080/api/staff/rh/absences', {
        method: 'POST',
        headers: { 
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json', 
          'Accept': 'application/json' 
        },
        body: JSON.stringify(createForm.value)
    });
    const json = await res.json();
    if (!res.ok) { createError.value = json.message ?? 'Erreur'; return; }
    createSuccess.value = 'Absence créée avec succès !';
    await fetchAbsences();
    setTimeout(() => { showCreateModal.value = false; }, 1200);
}

function openJustify(absence) {
    currentAbsence.value = absence;
    justifyForm.value = { is_justified: !!absence.is_justified, pdf: null };
    justifyError.value = '';
    justifySuccess.value = '';
    showJustifyModal.value = true;
}

async function submitJustification(e) {
    e.preventDefault();
    justifyError.value = '';
    justifySuccess.value = '';

    const fd = new FormData();
    fd.append('_method', 'PUT');
    fd.append('workshift_id', currentAbsence.value.workshift_id);
    fd.append('staff_id', currentAbsence.value.staff_id);
    fd.append('is_justified', justifyForm.value.is_justified ? 1 : 0);
    if (justifyForm.value.pdf) fd.append('pdf', justifyForm.value.pdf);

    const res = await fetch(`http://localhost:8080/api/staff/rh/absences/${currentAbsence.value.id}`, {
        method: 'POST',
        headers: { 
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json' 
        },
        body: fd
    });
    const json = await res.json();
    if (!res.ok) {
        justifyError.value = json.message ?? 'Erreur lors de la mise à jour';
        return;
    }
    justifySuccess.value = 'Absence mise à jour avec succès !';
    await fetchAbsences();
    setTimeout(() => { showJustifyModal.value = false; }, 1200);
}

onMounted(() => {
    fetchAbsences();
    fetchStaffAndWorkshifts();
});
</script>

<template>
   <div class="app-container">
   <!-- Sidebar Shell -->
    <aside class="fixed left-0 top-0 h-full w-[260px] bg-[#70cfcb] shadow-2xl flex flex-col h-full py-6 z-50">
      <div class="px-8 mb-10">
        <h1 class="text-2xl font-black text-white font-headline-xl">Morpho Gestion</h1>
        <p class="text-[#e0f7f5] text-label-md">RH Dashboard</p>
      </div>
      <nav class="flex-1 space-y-2">
        <!-- Active State: Tableau de bord -->
         <router-link to="/RH/dashbord">
        <a class="text-white/80 hover:bg-[#5db8b4]/50 rounded-full mx-4 px-4 py-3 flex items-center gap-3 transition-all scale-95 active:scale-90">
          <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
          <span class="font-body-md">Tableau de bord</span>
        </a>
        </router-link>
         <router-link to="/RH/personnel">
        <a class="text-white/80 hover:bg-[#5db8b4]/50 rounded-full mx-4 px-4 py-3 flex items-center gap-3 transition-all scale-95 active:scale-90">
          <span class="material-symbols-outlined" data-icon="group">group</span>
          <span class="font-body-md">Gestion des personnel</span>
        </a>
        </router-link>
        <router-link to="/RH/Absences">
        <a class="bg-white text-[#70cfcb] rounded-full mx-4 px-4 py-3 flex items-center gap-3 font-bold transition-all scale-95 active:scale-90">
          <span class="material-symbols-outlined" data-icon="group">group</span>
          <span class="font-body-md">Gestion des Absences</span>
        </a>
        </router-link>
      </nav>
      <div class="mt-auto px-6">
        <div class="bg-[#5db8b4]/30 rounded-xl p-4 flex items-center gap-3">
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
        <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Gestion des Absences</h2>
      </div>
      <button @click="openCreate()"
        class="inline-flex items-center gap-2 px-4 py-2 bg-[#70cfcb] text-white text-sm font-bold rounded-xl hover:bg-[#5db8b4] transition-all">
        <span class="material-symbols-outlined text-base">add</span>
        Nouvelle Absence
      </button>
    </header>

    <!-- Main -->
    <main class="ml-[260px] pt-24 px-8 pb-12">

      <!-- Stats -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-6 rounded-xl shadow border border-slate-100 flex items-center gap-4">
          <div class="w-12 h-12 bg-[#70cfcb]/10 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[#70cfcb] text-2xl">event_busy</span>
          </div>
          <div>
            <p class="text-xs text-[#494454] uppercase tracking-wider">Total Absences</p>
            <p class="text-3xl font-black text-[#191c1e]">{{ absences.length }}</p>
          </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border border-slate-100 flex items-center gap-4">
          <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-green-600 text-2xl">verified_user</span>
          </div>
          <div>
            <p class="text-xs text-[#494454] uppercase tracking-wider">Justifiées</p>
            <p class="text-3xl font-black text-[#191c1e]">{{ totalJustifiees }}</p>
          </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border border-slate-100 flex items-center gap-4">
          <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-red-500 text-2xl">warning</span>
          </div>
          <div>
            <p class="text-xs text-[#494454] uppercase tracking-wider">Non Justifiées</p>
            <p class="text-3xl font-black text-[#191c1e]">{{ totalNonJustifiees }}</p>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
          <h3 class="font-bold text-lg text-[#191c1e] flex items-center gap-2">
            <span class="material-symbols-outlined text-[#70cfcb]">list_alt</span>
            Liste des Absences
          </h3>
          <span class="px-3 py-1 bg-[#70cfcb]/10 text-[#006947] text-xs font-bold rounded-full">{{ absences.length }} absence(s)</span>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="bg-slate-50">
              <tr>
                <th class="px-6 py-4 text-xs font-semibold text-[#494454] uppercase tracking-wider">#</th>
                <th class="px-6 py-4 text-xs font-semibold text-[#494454] uppercase tracking-wider">Personnel</th>
                <th class="px-6 py-4 text-xs font-semibold text-[#494454] uppercase tracking-wider">Workshift</th>
                <th class="px-6 py-4 text-xs font-semibold text-[#494454] uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-xs font-semibold text-[#494454] uppercase tracking-wider">Statut</th>
                <th class="px-6 py-4 text-xs font-semibold text-[#494454] uppercase tracking-wider">PDF</th>
                <th class="px-6 py-4 text-xs font-semibold text-[#494454] uppercase tracking-wider text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-if="loading">
                <td colspan="7" class="px-6 py-8 text-center text-[#494454] text-sm">Chargement...</td>
              </tr>
              <tr v-else-if="absences.length === 0">
                <td colspan="7" class="px-6 py-8 text-center text-[#494454] text-sm">Aucune absence enregistrée</td>
              </tr>
              <tr v-for="absence in absences" :key="absence.id" class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 text-sm text-[#494454]">{{ absence.id }}</td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#70cfcb]/20 flex items-center justify-center text-[#70cfcb] font-black text-sm flex-shrink-0">
                      {{ absence.staff?.name?.charAt(0).toUpperCase() ?? '?' }}
                    </div>
                    <span class="font-bold text-[#191c1e] text-sm">{{ absence.staff?.name ?? '—' }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-[#494454]"># {{ absence.workshift_id }}</td>
                <td class="px-6 py-4 text-sm text-[#494454]">{{ absence.created_at?.substring(0, 10) }}</td>
                <td class="px-6 py-4">
                  <span :class="absence.is_justified ? 'bg-[#70cfcb]/20 text-[#006947]' : 'bg-red-100 text-red-600'"
                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold">
                    <span :class="absence.is_justified ? 'bg-[#006947]' : 'bg-red-500'" class="w-1.5 h-1.5 rounded-full"></span>
                    {{ absence.is_justified ? 'Justifiée' : 'Non justifiée' }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <a v-if="absence.pdf" :href="`http://localhost:8080/storage/${absence.pdf}`" target="_blank"
                    class="inline-flex items-center gap-1 text-xs text-[#70cfcb] hover:underline">
                    <span class="material-symbols-outlined text-sm">picture_as_pdf</span> Voir
                  </a>
                  <span v-else class="text-xs text-slate-400">—</span>
                </td>
                <td class="px-6 py-4 text-right">
                  <button @click="openJustify(absence)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#70cfcb] text-white text-xs font-bold rounded-lg hover:bg-[#5db8b4] transition-all">
                    <span class="material-symbols-outlined text-sm">edit_note</span>
                    Justifier
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal Créer Absence -->
  <div v-if="showCreateModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
      <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
          <h3 class="font-bold text-lg text-[#191c1e]">Nouvelle Absence</h3>
          <p class="text-xs text-[#494454] mt-0.5">Enregistrer une absence pour un membre du personnel</p>
        </div>
        <button @click="showCreateModal = false" class="p-2 text-[#494454] hover:bg-slate-100 rounded-lg transition-all">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <form @submit="submitCreate" class="p-6 space-y-5">
        <div v-if="createSuccess" class="p-3 bg-[#70cfcb]/10 text-[#006947] rounded-lg text-sm font-semibold flex items-center gap-2">
          <span class="material-symbols-outlined text-base">check_circle</span>{{ createSuccess }}
        </div>
        <div v-if="createError" class="p-3 bg-red-50 text-red-600 rounded-lg text-sm font-semibold flex items-center gap-2">
          <span class="material-symbols-outlined text-base">error</span>{{ createError }}
        </div>
        <div class="space-y-1.5">
          <label class="text-xs font-semibold text-[#494454] uppercase tracking-wider">Personnel <span class="text-red-500">*</span></label>
          <select v-model="createForm.staff_id" required
            class="w-full border border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm">
            <option value="" disabled>Sélectionner un membre du personnel</option>
            <option v-for="staff in staffList" :key="staff.id" :value="staff.id">
              {{ staff.name }} — {{ staff.email }}
            </option>
          </select>
        </div>
        <div class="space-y-1.5">
          <label class="text-xs font-semibold text-[#494454] uppercase tracking-wider">Workshift <span class="text-red-500">*</span></label>
          <select v-model="createForm.workshift_id" required
            class="w-full border border-slate-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm">
            <option value="" disabled>Sélectionner un workshift</option>
            <option v-for="ws in workshifts" :key="ws.id" :value="ws.id">
              #{{ ws.id }} — {{ ws.date_debut }} / {{ ws.date_fin }}
            </option>
          </select>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" @click="showCreateModal = false"
            class="flex-1 py-3 rounded-xl border border-slate-200 font-bold text-[#494454] hover:bg-slate-50 transition-all text-sm">Annuler</button>
          <button type="submit"
            class="flex-1 py-3 rounded-xl bg-[#70cfcb] hover:bg-[#5db8b4] text-white font-bold transition-all text-sm flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-base">add</span> Créer
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Justification -->
  <div v-if="showJustifyModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
      <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
          <h3 class="font-bold text-lg text-[#191c1e]">Justifier l'Absence</h3>
          <p class="text-xs text-[#494454] mt-0.5">Absence #{{ currentAbsence?.id }} — {{ currentAbsence?.staff?.name ?? '' }}</p>
        </div>
        <button @click="showJustifyModal = false" class="p-2 text-[#494454] hover:bg-slate-100 rounded-lg transition-all">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <form @submit="submitJustification" class="p-6 space-y-5">
        <div v-if="justifySuccess" class="p-3 bg-[#70cfcb]/10 text-[#006947] rounded-lg text-sm font-semibold flex items-center gap-2">
          <span class="material-symbols-outlined text-base">check_circle</span>{{ justifySuccess }}
        </div>
        <div v-if="justifyError" class="p-3 bg-red-50 text-red-600 rounded-lg text-sm font-semibold flex items-center gap-2">
          <span class="material-symbols-outlined text-base">error</span>{{ justifyError }}
        </div>

        <!-- Statut -->
        <div class="space-y-2">
          <label class="text-xs font-semibold text-[#494454] uppercase tracking-wider">Statut de justification</label>
          <div class="grid grid-cols-2 gap-3">
            <label :class="justifyForm.is_justified ? 'border-[#70cfcb] bg-[#70cfcb]/10' : 'border-slate-200'"
              class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all">
              <input type="radio" v-model="justifyForm.is_justified" :value="true" class="accent-[#70cfcb]" />
              <div>
                <p class="font-bold text-sm text-[#191c1e]">Justifiée</p>
                <p class="text-xs text-[#494454]">Absence validée</p>
              </div>
            </label>
            <label :class="!justifyForm.is_justified ? 'border-red-400 bg-red-50' : 'border-slate-200'"
              class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all">
              <input type="radio" v-model="justifyForm.is_justified" :value="false" class="accent-red-500" />
              <div>
                <p class="font-bold text-sm text-[#191c1e]">Non justifiée</p>
                <p class="text-xs text-[#494454]">Absence refusée</p>
              </div>
            </label>
          </div>
        </div>

        <!-- PDF Upload -->
        <div class="space-y-2">
          <label class="text-xs font-semibold text-[#494454] uppercase tracking-wider">
            Justificatif PDF <span v-if="justifyForm.is_justified && !currentAbsence?.pdf" class="text-red-500">*</span>
          </label>
          <div class="relative group cursor-pointer">
            <div :class="justifyForm.pdf ? 'border-[#70cfcb] bg-[#70cfcb]/5' : 'border-slate-200 bg-slate-50'"
              class="w-full h-24 border-2 border-dashed rounded-xl flex flex-col items-center justify-center gap-2 group-hover:border-[#70cfcb] group-hover:bg-[#70cfcb]/5 transition-all">
              <span class="material-symbols-outlined text-[#70cfcb]">upload_file</span>
              <span class="text-xs font-bold text-[#494454]">
                {{ justifyForm.pdf ? justifyForm.pdf.name : 'Cliquez pour uploader un PDF' }}
              </span>
            </div>
            <input @change="e => justifyForm.pdf = e.target.files[0]" type="file" accept=".pdf"
              class="absolute inset-0 opacity-0 cursor-pointer" />
          </div>
          <a v-if="currentAbsence?.pdf" :href="`http://localhost:8080/storage/${currentAbsence.pdf}`" target="_blank"
            class="inline-flex items-center gap-1 text-xs text-[#70cfcb] hover:underline">
            <span class="material-symbols-outlined text-sm">picture_as_pdf</span> PDF actuel
          </a>
        </div>

        <div class="flex gap-3 pt-2">
          <button type="button" @click="showJustifyModal = false"
            class="flex-1 py-3 rounded-xl border border-slate-200 font-bold text-[#494454] hover:bg-slate-50 transition-all text-sm">Annuler</button>
          <button type="submit"
            class="flex-1 py-3 rounded-xl bg-[#70cfcb] hover:bg-[#5db8b4] text-white font-bold transition-all text-sm flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-base">save</span> Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>

</template>