<script setup>
import { ref, onMounted } from 'vue';
import { useAuth } from '../../../composables/useAuth';

const { logout } = useAuth();

const token = localStorage.getItem('token');

const departements = ref([]);
const showModal = ref(false);
const modalMode = ref('add'); // 'add' | 'edit'
const currentDeptId = ref(null);
const editStaffId = ref(null);
const errors = ref({});
const successMsg = ref('');

const form = ref({ name: '', email: '', password: '', password_confirmation: '', telephon: '', CIN: '', age: '', salaire: '', departement_id: '', experiences: [], langages: [] });

async function fetchDepartements() {
    const res = await fetch('http://localhost:8080/api/staff/rh/departements', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    const depts = json.data.data ?? json.data;
    // fetch staffs for each dept
    departements.value = await Promise.all(
        depts.map(async d => {
            const r = await fetch(`http://localhost:8080/api/staff/rh/departements/${d.id}`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            const j = await r.json();
            return j.data;
        })
    );
}

function openAdd(deptId) {
    modalMode.value = 'add';
    currentDeptId.value = deptId;
    editStaffId.value = null;
    form.value = { name: '', email: '', password: '', password_confirmation: '', telephon: '', CIN: '', age: '', salaire: '', departement_id: deptId, experiences: [], langages: [] };
    errors.value = {};
    successMsg.value = '';
    showModal.value = true;
}

function openEdit(staff) {
    modalMode.value = 'edit';
    editStaffId.value = staff.id;
    currentDeptId.value = staff.departement_id;
    form.value = { name: staff.name, email: staff.email, password: '', password_confirmation: '', telephon: staff.telephon, CIN: staff.CIN, age: staff.age, salaire: staff.salaire, departement_id: staff.departement_id, experiences: staff.experiences ?? [], langages: staff.langages ?? [] };
    errors.value = {};
    successMsg.value = '';
    showModal.value = true;
}

async function submitForm(e) {
    e.preventDefault();
    errors.value = {};
    const isEdit = modalMode.value === 'edit';
    const url = isEdit
        ? `http://localhost:8080/api/staff/rh/staff/${editStaffId.value}/edit`
        : 'http://localhost:8080/api/staff/rh/staff/add';
    const res = await fetch(url, {
        method: isEdit ? 'PUT' : 'POST',
        headers: { 
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json', 
          'Accept': 'application/json' 
        },
        body: JSON.stringify(form.value)
    });
    const json = await res.json();
    if (!res.ok) { errors.value = json.errors ?? {}; return; }
    successMsg.value = isEdit ? 'Personnel mis à jour !' : 'Personnel ajouté !';
    await fetchDepartements();
    setTimeout(() => { showModal.value = false; successMsg.value = ''; }, 1200);
}

async function deleteStaff(staffId) {
    if (!confirm('Supprimer ce membre du personnel ?')) return;
    const res = await fetch(`http://localhost:8080/api/staff/rh/staff/${staffId}/delete`, { 
      headers: { 'Authorization': `Bearer ${token}` },
      method: 'DELETE' 
    });
    if (res.ok || res.status === 204) await fetchDepartements();
}

onMounted(fetchDepartements);
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
        <a class="bg-white text-[#70cfcb] rounded-full mx-4 px-4 py-3 flex items-center gap-3 font-bold transition-all scale-95 active:scale-90">
          <span class="material-symbols-outlined" data-icon="group">group</span>
          <span class="font-body-md">Gestion des personnel</span>
        </a>
        </router-link>
        <router-link to="/RH/Absences">
        <a class="text-white/80 hover:bg-[#5db8b4]/50 rounded-full mx-4 px-4 py-3 flex items-center gap-3 transition-all scale-95 active:scale-90" href="#">
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
        <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Gestion des Personnel</h2>
      </div>

    </header>
    <!-- Main Content Canvas -->
    <main class="ml-[260px] pt-24 px-8 pb-12">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="font-headline-xl text-[#191c1e]">Gestion des Départements</h2>
          <p class="text-[#494454] font-body-md">Consultez tous les départements et gérez leurs employés.</p>
        </div>
      </div>

      <!-- Départements Grid -->
      <div class="space-y-8">
        <div v-if="departements.length === 0" class="text-center text-[#494454] py-12">Chargement...</div>

        <div v-for="dept in departements" :key="dept.id"
          class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(112,207,203,0.04)] border border-slate-50 overflow-hidden">
          <div class="px-6 py-5 bg-gradient-to-r from-[#70cfcb]/10 to-transparent border-b border-slate-100">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="font-headline-lg text-[#191c1e] flex items-center gap-2">
                  <span class="material-symbols-outlined text-[#70cfcb]">domain</span>
                  {{ dept.name }}
                </h3>
                <p class="text-label-md text-[#494454] mt-1">{{ dept.staffs?.length ?? 0 }} employé(s)</p>
              </div>
              <div class="flex items-center gap-3">
                <span :class="dept.is_active ? 'bg-[#70cfcb]/10 text-[#006947]' : 'bg-[#ffdad6] text-[#ba1a1a]'"
                  class="px-3 py-1 text-label-md rounded-full">
                  {{ dept.is_active ? 'Actif' : 'Inactif' }}
                </span>
                <button @click="openAdd(dept.id)"
                  class="bg-[#70cfcb] text-white px-4 py-2 rounded-xl font-bold flex items-center gap-2 hover:shadow-lg transition-all active:scale-95">
                  <span class="material-symbols-outlined text-sm">add</span>
                  Ajouter
                </button>
              </div>
            </div>
          </div>

          <!-- Personnel Table -->
          <div class="p-6">
            <div class="overflow-x-auto">
              <table class="w-full text-left">
                <thead>
                  <tr class="text-label-md text-[#494454] border-b border-slate-100">
                    <th class="pb-4 font-semibold uppercase">Employé</th>
                    <th class="pb-4 font-semibold uppercase">Email</th>
                    <th class="pb-4 font-semibold uppercase">Téléphone</th>
                    <th class="pb-4 font-semibold uppercase">Salaire</th>
                    <th class="pb-4 font-semibold uppercase text-center">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-body-sm">
                  <tr v-if="!dept.staffs?.length">
                    <td colspan="5" class="py-6 text-center text-[#494454] text-sm">Aucun personnel dans ce département</td>
                  </tr>
                  <tr v-for="staff in dept.staffs" :key="staff.id"
                    class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                    <td class="py-4">
                      <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#70cfcb]/20 flex items-center justify-center text-[#70cfcb] font-black text-sm flex-shrink-0">
                          {{ staff.name.charAt(0).toUpperCase() }}
                        </div>
                        <span class="font-bold">{{ staff.name }}</span>
                      </div>
                    </td>
                    <td class="py-4 text-[#494454]">{{ staff.email }}</td>
                    <td class="py-4 text-[#494454]">{{ staff.telephon }}</td>
                    <td class="py-4 text-[#494454]">{{ staff.salaire }} DH</td>
                    <td class="py-4">
                      <div class="flex items-center justify-center gap-2">
                        <button @click="openEdit(staff)"
                          class="p-2 bg-[#70cfcb]/10 text-[#70cfcb] rounded-lg hover:bg-[#70cfcb]/20 transition-all">
                          <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                        <button @click="deleteStaff(staff.id)"
                          class="p-2 bg-[#ffdad6] text-[#ba1a1a] rounded-lg hover:bg-[#ffdad6]/80 transition-all">
                          <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
    </div>

    <!-- Modal Add / Edit Personnel -->
    <div v-if="showModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
          <h3 class="font-headline-lg text-[#191c1e]">{{ modalMode === 'add' ? 'Ajouter un Personnel' : 'Modifier le Personnel' }}</h3>
          <button @click="showModal = false" class="p-2 text-[#494454] hover:bg-slate-100 rounded-lg transition-all">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
        <form @submit="submitForm" class="p-6 space-y-4">
          <div v-if="successMsg" class="p-3 bg-[#70cfcb]/10 text-[#006947] rounded-lg text-sm font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-base">check_circle</span>{{ successMsg }}
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">Nom complet <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.name" type="text" required
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" />
              <p v-if="errors.name" class="text-[#ba1a1a] text-xs">{{ errors.name[0] }}</p>
            </div>
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">Email <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.email" type="email" required
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" />
              <p v-if="errors.email" class="text-[#ba1a1a] text-xs">{{ errors.email[0] }}</p>
            </div>
          </div>
          <div v-if="modalMode === 'add'" class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">Mot de passe <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.password" type="password" required
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" placeholder="Min. 8 caractères" />
              <p v-if="errors.password" class="text-[#ba1a1a] text-xs">{{ errors.password[0] }}</p>
            </div>
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">Confirmation <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.password_confirmation" type="password" required
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">Téléphone <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.telephon" type="text" required
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" />
              <p v-if="errors.telephon" class="text-[#ba1a1a] text-xs">{{ errors.telephon[0] }}</p>
            </div>
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">CIN <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.CIN" type="text" required
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" />
              <p v-if="errors.CIN" class="text-[#ba1a1a] text-xs">{{ errors.CIN[0] }}</p>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">Âge <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.age" type="number" required min="18" max="100"
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" />
              <p v-if="errors.age" class="text-[#ba1a1a] text-xs">{{ errors.age[0] }}</p>
            </div>
            <div class="space-y-1.5">
              <label class="text-label-md font-semibold text-[#494454]">Salaire <span class="text-[#ba1a1a]">*</span></label>
              <input v-model="form.salaire" type="text" required
                class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm" placeholder="5000 DH" />
              <p v-if="errors.salaire" class="text-[#ba1a1a] text-xs">{{ errors.salaire[0] }}</p>
            </div>
          </div>
          <div class="space-y-1.5">
            <label class="text-label-md font-semibold text-[#494454]">Département <span class="text-[#ba1a1a]">*</span></label>
            <select v-model="form.departement_id" required
              class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-sm">
              <option value="" disabled>Sélectionner</option>
              <option v-for="d in departements" :key="d.id" :value="d.id">{{ d.name }}</option>
            </select>
            <p v-if="errors.departement_id" class="text-[#ba1a1a] text-xs">{{ errors.departement_id[0] }}</p>
          </div>

          <!-- Expériences -->
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <label class="text-label-md font-semibold text-[#494454]">Expériences</label>
              <button type="button" @click="form.experiences.push({ title: '', description: '', date_debut: '', date_fin: '', entreprise: '' })"
                class="text-xs text-[#70cfcb] hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">add</span> Ajouter
              </button>
            </div>
            <div v-for="(exp, i) in form.experiences" :key="i" class="p-3 border border-slate-200 rounded-lg space-y-2">
              <div class="grid grid-cols-2 gap-2">
                <input v-model="exp.title" type="text" placeholder="Titre"
                  class="w-full border border-slate-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-xs" />
                <input v-model="exp.entreprise" type="text" placeholder="Entreprise"
                  class="w-full border border-slate-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-xs" />
              </div>
              <div class="grid grid-cols-2 gap-2">
                <input v-model="exp.date_debut" type="date"
                  class="w-full border border-slate-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-xs" />
                <input v-model="exp.date_fin" type="date"
                  class="w-full border border-slate-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-xs" />
              </div>
              <div class="flex gap-2">
                <input v-model="exp.description" type="text" placeholder="Description"
                  class="flex-1 border border-slate-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-xs" />
                <button type="button" @click="form.experiences.splice(i, 1)"
                  class="p-1.5 text-[#494454] hover:text-[#ba1a1a] hover:bg-[#ffdad6] rounded-lg transition-all">
                  <span class="material-symbols-outlined text-sm">delete</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Langages -->
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <label class="text-label-md font-semibold text-[#494454]">Langages</label>
              <button type="button" @click="form.langages.push({ name: '', level: '' })"
                class="text-xs text-[#70cfcb] hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">add</span> Ajouter
              </button>
            </div>
            <div v-for="(lang, i) in form.langages" :key="i" class="flex gap-2 items-center">
              <input v-model="lang.name" type="text" placeholder="Langage (ex: Français)"
                class="flex-1 border border-slate-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-xs" />
              <select v-model="lang.level"
                class="border border-slate-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#70cfcb]/30 outline-none text-xs">
                <option value="" disabled>Niveau</option>
                <option value="Débutant">Débutant</option>
                <option value="Intermédiaire">Intermédiaire</option>
                <option value="Avancé">Avancé</option>
                <option value="Natif">Natif</option>
              </select>
              <button type="button" @click="form.langages.splice(i, 1)"
                class="p-1.5 text-[#494454] hover:text-[#ba1a1a] hover:bg-[#ffdad6] rounded-lg transition-all">
                <span class="material-symbols-outlined text-sm">delete</span>
              </button>
            </div>
          </div>
          <div class="flex gap-3 pt-2">
            <button type="button" @click="showModal = false"
              class="flex-1 py-3 rounded-xl border border-slate-200 font-bold text-[#494454] hover:bg-slate-50 transition-all text-sm">Annuler</button>
            <button type="submit"
              class="flex-1 py-3 rounded-xl bg-[#70cfcb] hover:bg-[#5db8b4] text-white font-bold transition-all text-sm">
              {{ modalMode === 'add' ? 'Ajouter' : 'Enregistrer' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    </template>