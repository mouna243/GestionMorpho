<script setup>
import { ref, onMounted } from 'vue';
import { useAuth } from '../../composables/useAuth';

const { logout } = useAuth();

const API = 'http://localhost:8080/api/admin/workshifts';
const API_DEPT = 'http://localhost:8080/api/admin/departements';
const token = localStorage.getItem('token');

const workshifts = ref([]);
const departements = ref([]);
const errors = ref({});
const successMsg = ref('');

const form = ref({ departement_id: '', date_debut: '', date_fin: '', check_in: '', check_out: '' });

// edit
const showEditModal = ref(false);
const editId = ref(null);
const editForm = ref({ departement_id: '', date_debut: '', date_fin: '', check_in: '', check_out: '' });
const editErrors = ref({});

function deptName(id) {
    return departements.value.find(d => d.id == id)?.name ?? id;
}

function formatDate(d) {
    if (!d) return '';
    return d.replace('T', ' ').substring(0, 16);
}

async function fetchAll() {
    const [ws, dp] = await Promise.all([
        fetch(API, { headers: { 'Authorization': `Bearer ${token}` } }).then(r => r.json()),
        fetch(API_DEPT, { headers: { 'Authorization': `Bearer ${token}` } }).then(r => r.json())
    ]);
    workshifts.value = ws.data.data ?? ws.data;
    departements.value = dp.data.data ?? dp.data;
}

async function addWorkshift(e) {
    e.preventDefault();
    errors.value = {};
    successMsg.value = '';
    const res = await fetch(API, {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(form.value)
    });
    const json = await res.json();
    if (!res.ok) { errors.value = json.errors ?? {}; return; }
    workshifts.value.unshift(json.data);
    successMsg.value = 'Workshift créé avec succès !';
    form.value = { departement_id: '', date_debut: '', date_fin: '', check_in: '', check_out: '' };
    setTimeout(() => successMsg.value = '', 3000);
}

function openEdit(ws) {
    editId.value = ws.id;
    editForm.value = {
        departement_id: ws.departement_id,
        date_debut: ws.date_debut,
        date_fin: ws.date_fin,
        check_in: ws.check_in,
        check_out: ws.check_out
    };
    editErrors.value = {};
    showEditModal.value = true;
}

async function updateWorkshift(e) {
    e.preventDefault();
    editErrors.value = {};
    const res = await fetch(`${API}/${editId.value}`, {
        method: 'PUT',
        headers: { 
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(editForm.value)
    });
    const json = await res.json();
    if (!res.ok) { editErrors.value = json.errors ?? {}; return; }
    const idx = workshifts.value.findIndex(w => w.id === editId.value);
    if (idx !== -1) workshifts.value[idx] = json.data;
    showEditModal.value = false;
}

async function deleteWorkshift(id) {
    if (!confirm('Supprimer ce workshift ?')) return;
    await fetch(`${API}/${id}`, { 
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
    });
    workshifts.value = workshifts.value.filter(w => w.id !== id);
}

onMounted(fetchAll);
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
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
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
                <a class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold"
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
                    <button class="text-violet-100 hover:text-white px-4 py-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold cursor-pointer"
                        @click="logout">
                        <span class="material-symbols-outlined" data-icon="logout">logout</span>
                        <span>Déconnexion</span>
                    </button>
                </div>
            </div>
        </aside>


        <header
            class="fixed top-0 right-0 w-[calc(100%-260px)] h-16 z-40 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 shadow-sm border-b border-slate-100">
            <div class="flex items-center space-x-4 flex-1">
                <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Gestion des WorkShift</h2>
            </div>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-4">
               
                </div>
              
              <div class="flex items-center gap-4 border-l pl-6 border-gray-200">
                <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center text-violet-600">
                    <span class="material-symbols-outlined">account_circle</span>
                </div>
                <span class="text-sm font-bold text-gray-700">Admin</span>
            </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="ml-[260px] pt-16 min-h-screen p-8"
            style="background-image: radial-gradient(circle at 2px 2px, rgba(107, 56, 212, 0.05) 1px, transparent 0); background-size: 24px 24px;">
            <div class="max-w-7xl mx-auto space-y-8">
                        <!-- TopAppBar Component -->
                <!-- Page Header -->
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-[28px] leading-9 font-bold text-slate-900">Gestion des Workshifts
                        </h2>
                        <p class="text-[#494454] text-sm">Planifiez les équipes et suivez les absences du personnel.</p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">download</span> Exporter
                        </button>
                    </div>
                </div>

                <!-- Section 1: Ajout Workshift -->
                <div class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#6b38d4]">schedule</span>
                            Ajouter un Workshift
                        </h3>
                        <p class="text-[#494454] text-sm mt-1">Planifiez une nouvelle période de travail</p>
                    </div>
                    <div class="p-6">
                        <form @submit="addWorkshift" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- departement_id -->
                            <div class="space-y-2">
                                <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                    Département <span class="text-red-500">*</span>
                                </label>
                                <select v-model="form.departement_id" required
                                    class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all bg-white">
                                    <option value="">Sélectionner un département</option>
                                    <option v-for="dept in departements" :key="dept.id" :value="dept.id">{{ dept.name }}
                                    </option>
                                </select>
                                <p v-if="errors.departement_id" class="text-red-500 text-xs">{{ errors.departement_id[0]
                                }}</p>
                            </div>

                            <!-- date_debut -->
                            <div class="space-y-2">
                                <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                    Date de début <span class="text-red-500">*</span>
                                </label>
                                <input v-model="form.date_debut" type="date" required
                                    class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all" />
                                <p v-if="errors.date_debut" class="text-red-500 text-xs">{{ errors.date_debut[0] }}</p>
                            </div>

                            <!-- date_fin -->
                            <div class="space-y-2">
                                <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                    Date de fin <span class="text-red-500">*</span>
                                </label>
                                <input v-model="form.date_fin" type="date" required
                                    class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all" />
                                <p v-if="errors.date_fin" class="text-red-500 text-xs">{{ errors.date_fin[0] }}</p>
                            </div>

                            <!-- check_in -->
                            <div class="space-y-2">
                                <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                    Check-in (heure d'arrivée) <span class="text-red-500">*</span>
                                </label>
                                <input v-model="form.check_in" type="time" required
                                    class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all" />
                                <p class="text-xs text-slate-400 mt-1">Heure de début de poste</p>
                                <p v-if="errors.check_in" class="text-red-500 text-xs">{{ errors.check_in[0] }}</p>
                            </div>

                            <!-- check_out -->
                            <div class="space-y-2">
                                <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                    Check-out (heure de sortie) <span class="text-red-500">*</span>
                                </label>
                                <input v-model="form.check_out" type="time" required
                                    class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all" />
                                <p class="text-xs text-slate-400 mt-1">Heure de fin de poste</p>
                                <p v-if="errors.check_out" class="text-red-500 text-xs">{{ errors.check_out[0] }}</p>
                            </div>

                            <div class="md:col-span-2 pt-4">
                                <div v-if="successMsg"
                                    class="mb-3 p-3 bg-green-50 text-green-700 rounded-lg text-sm font-semibold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-base">check_circle</span>{{ successMsg
                                    }}
                                </div>
                                <button type="submit"
                                    class="w-full md:w-auto bg-[#6b38d4] text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-[#6b38d4]/20 hover:bg-[#8455ef] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined">add</span>
                                    Créer le Workshift
                                </button>
                            </div>
                        </form>

                        <!-- Récapitulatif des champs obligatoires -->

                    </div>
                </div>

                <!-- Section 2: Liste des Workshifts actifs -->
                <div class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden mt-6">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#6b38d4]">event_note</span>
                            Workshifts en cours
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                        Département</th>
                                    <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                        Date début</th>
                                    <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                        Date fin</th>
                                    <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                        Check-in</th>
                                    <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                        Check-out</th>
                                    <th
                                        class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-if="workshifts.length === 0">
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">Aucun workshift
                                        trouvé</td>
                                </tr>
                                <tr v-for="ws in workshifts" :key="ws.id"
                                    class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[#6b38d4] text-lg">domain</span>
                                            <span class="font-medium">{{ deptName(ws.departement_id) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ ws.date_debut }}</td>
                                    <td class="px-6 py-4 text-sm">{{ ws.date_fin }}</td>
                                    <td class="px-6 py-4 text-sm">{{ ws.check_in }}</td>
                                    <td class="px-6 py-4 text-sm">{{ ws.check_out }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <button @click="openEdit(ws)"
                                            class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                            <span class="material-symbols-outlined text-xl">edit</span>
                                        </button>
                                        <button @click="deleteWorkshift(ws.id)"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



                <!-- Note informative -->

            </div>
        </main>
    </div>

    <!-- Modal : Modifier Workshift -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#6b38d4]">edit_calendar</span>
                    Modifier le Workshift
                </h3>
                <button @click="showEditModal = false"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form @submit="updateWorkshift" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700">Département <span
                            class="text-red-500">*</span></label>
                    <select v-model="editForm.departement_id" required
                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all bg-white">
                        <option value="">Sélectionner un département</option>
                        <option v-for="dept in departements" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                    </select>
                    <p v-if="editErrors.departement_id" class="text-red-500 text-xs">{{ editErrors.departement_id[0] }}
                    </p>
                </div>
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700">Date de début <span
                            class="text-red-500">*</span></label>
                    <input v-model="editForm.date_debut" type="date" required
                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all" />
                    <p v-if="editErrors.date_debut" class="text-red-500 text-xs">{{ editErrors.date_debut[0] }}</p>
                </div>
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700">Date de fin <span
                            class="text-red-500">*</span></label>
                    <input v-model="editForm.date_fin" type="date" required
                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all" />
                    <p v-if="editErrors.date_fin" class="text-red-500 text-xs">{{ editErrors.date_fin[0] }}</p>
                </div>
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700">Check-in <span
                            class="text-red-500">*</span></label>
                    <input v-model="editForm.check_in" type="date" required
                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all" />
                    <p v-if="editErrors.check_in" class="text-red-500 text-xs">{{ editErrors.check_in[0] }}</p>
                </div>
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700">Check-out <span
                            class="text-red-500">*</span></label>
                    <input v-model="editForm.check_out" type="date" required
                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all" />
                    <p v-if="editErrors.check_out" class="text-red-500 text-xs">{{ editErrors.check_out[0] }}</p>
                </div>
                <div class="md:col-span-2 flex gap-3 pt-2">
                    <button type="button" @click="showEditModal = false"
                        class="flex-1 py-3 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 transition-all text-sm">Annuler</button>
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-[#6b38d4] hover:bg-[#8455ef] text-white font-bold transition-all text-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base">save</span> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

</template>