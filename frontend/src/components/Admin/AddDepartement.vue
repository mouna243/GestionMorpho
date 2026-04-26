<script setup>
import { ref, computed, onMounted } from 'vue';

// ── Départements ──────────────────────────────────────────
const departements = ref([]);
const selectedDept = ref(null);
const errors = ref({});
const successMsg = ref('');
const form = ref({ name: '', description: '', is_active: true });

// edit département modal
const showEditDept = ref(false);
const editDeptForm = ref({ name: '', description: '', is_active: true });
const editDeptId = ref(null);
const editDeptErrors = ref({});

// ── RH / Staff ────────────────────────────────────────────
const showRHModal = ref(false);
const rhModalMode = ref('add'); // 'add' | 'edit'
const rhForm = ref({ name: '', email: '', password: '', password_confirmation: '', telephon: '', CIN: '', age: '', salaire: '', departement_id: '' });
const rhErrors = ref({});
const rhSuccess = ref('');
const editRHId = ref(null);

// ── Computed ──────────────────────────────────────────────
const totalActifs = computed(() => departements.value.filter(d => d.is_active).length);
const tauxActivite = computed(() => departements.value.length
    ? Math.round((totalActifs.value / departements.value.length) * 100) : 0);

// ── Département CRUD ──────────────────────────────────────
async function fetchDepartements() {
    const res = await fetch('http://localhost:8080/api/departements');
    const json = await res.json();
    departements.value = json.data.data ?? json.data;
}

async function fetchStaffs(dept) {
    if (selectedDept.value?.id === dept.id) { selectedDept.value = null; return; }
    const res = await fetch(`http://localhost:8080/api/departements/${dept.id}`);
    const json = await res.json();
    selectedDept.value = json.data;
}

async function addDepartement(e) {
    e.preventDefault();
    errors.value = {};
    successMsg.value = '';
    const res = await fetch('http://localhost:8080/api/departements', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ ...form.value, is_active: form.value.is_active ? 1 : 0 })
    });
    const json = await res.json();
    if (!res.ok) { errors.value = json.errors ?? {}; return; }
    departements.value.unshift(json.data);
    successMsg.value = 'Département ajouté avec succès !';
    form.value = { name: '', description: '', is_active: true };
}

function openEditDept(dept) {
    editDeptId.value = dept.id;
    editDeptForm.value = { name: dept.name, description: dept.description, is_active: !!dept.is_active };
    editDeptErrors.value = {};
    showEditDept.value = true;
}

async function updateDepartement(e) {
    e.preventDefault();
    editDeptErrors.value = {};
    const res = await fetch(`http://localhost:8080/api/departements/${editDeptId.value}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ ...editDeptForm.value, is_active: editDeptForm.value.is_active ? 1 : 0 })
    });
    const json = await res.json();
    if (!res.ok) { editDeptErrors.value = json.errors ?? {}; return; }
    const idx = departements.value.findIndex(d => d.id === editDeptId.value);
    if (idx !== -1) departements.value[idx] = json.data;
    if (selectedDept.value?.id === editDeptId.value) selectedDept.value = { ...selectedDept.value, ...json.data };
    showEditDept.value = false;
}

async function deleteDepartement(id) {
    if (!confirm('Supprimer ce département ?')) return;
    await fetch(`http://localhost:8080/api/departements/${id}`, { method: 'DELETE' });
    departements.value = departements.value.filter(d => d.id !== id);
    if (selectedDept.value?.id === id) selectedDept.value = null;
}

// ── RH / Staff CRUD ───────────────────────────────────────
function openAddRH() {
    rhModalMode.value = 'add';
    rhForm.value = { name: '', email: '', password: '', password_confirmation: '', telephon: '', CIN: '', age: '', salaire: '', departement_id: '' };
    rhErrors.value = {};
    rhSuccess.value = '';
    showRHModal.value = true;
}

function openEditRH(staff) {
    rhModalMode.value = 'edit';
    editRHId.value = staff.id;
    rhForm.value = { name: staff.name, email: staff.email, password: '', password_confirmation: '', telephon: staff.telephon, CIN: staff.CIN, age: staff.age, salaire: staff.salaire, departement_id: staff.departement_id };
    rhErrors.value = {};
    rhSuccess.value = '';
    showRHModal.value = true;
}

async function submitRH(e) {
    e.preventDefault();
    rhErrors.value = {};
    rhSuccess.value = '';
    const isEdit = rhModalMode.value === 'edit';
    const url = isEdit
        ? `http://localhost:8080/api/admin/staff/${editRHId.value}/edit`
        : 'http://localhost:8080/api/admin/staff/add';
    const res = await fetch(url, {
        method: isEdit ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(rhForm.value)
    });
    const json = await res.json();
    if (!res.ok) { rhErrors.value = json.errors ?? {}; return; }
    rhSuccess.value = isEdit ? 'Personnel mis à jour !' : 'Personnel ajouté avec succès !';
    // refresh staff panel if open on same dept
    if (selectedDept.value) fetchStaffs({ id: selectedDept.value.id });
    if (!isEdit) setTimeout(() => { showRHModal.value = false; }, 1200);
}

async function deleteRH(staffId) {
    if (!confirm('Supprimer ce membre du personnel ?')) return;
    await fetch(`http://localhost:8080/api/admin/staff/${staffId}/delete`, { method: 'DELETE' });
    if (selectedDept.value) fetchStaffs({ id: selectedDept.value.id });
}

onMounted(fetchDepartements);
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
                <a
                    class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold">
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

        <!-- TopAppBar Component -->
        <header
            class="fixed top-0 right-0 w-[calc(100%-260px)] h-16 z-40 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 shadow-sm border-b border-slate-100">
            <div class="flex items-center space-x-4 flex-1">
                <div class="relative max-w-md w-full">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                    <input
                        class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-[#6b38d4]/20 placeholder:text-slate-400"
                        placeholder="Rechercher un département..." type="text" />
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-4">
                    <button class="text-slate-500 hover:text-[#6b38d4] transition-colors relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span
                            class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full border-2 border-white"></span>
                    </button>
                    <button class="text-slate-500 hover:text-[#6b38d4] transition-colors">
                        <span class="material-symbols-outlined">help_outline</span>
                    </button>
                </div>
                <div class="h-8 w-px bg-slate-200 mx-2"></div>
                <button
                    class="flex items-center space-x-2 text-slate-900 font-medium hover:text-[#6b38d4] transition-colors">
                    <span class="text-sm font-semibold">Morpho Gestion</span>
                    <span class="material-symbols-outlined text-[#6b38d4]">expand_more</span>
                </button>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="ml-[260px] pt-16 min-h-screen p-8"
            style="background-image: radial-gradient(circle at 2px 2px, rgba(107, 56, 212, 0.05) 1px, transparent 0); background-size: 24px 24px;">
            <div class="max-w-7xl mx-auto space-y-8">
                <!-- Page Header -->
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-[28px] leading-9 font-bold text-slate-900">Gestion des Départements</h2>
                        <p class="text-[#494454] text-sm">Organisez et gérez votre structure organisationnelle.</p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">download</span> Exporter
                        </button>
                    </div>
                </div>

                <!-- Bento Layout Content -->
                <div class="grid grid-cols-12 gap-6">
                    <!-- Départements List Section (Left Column) -->
                    <div class="col-span-12 lg:col-span-8 space-y-6">
                        <div
                            class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden">
                            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-slate-900">Liste des Départements</h3>
                                <span class="bg-[#e9ddff] text-[#5516be] text-xs font-bold px-3 py-1 rounded-full">{{ totalActifs }} Actifs</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50/50">
                                        <tr>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                                Département</th>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                                Description</th>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                                Statut</th>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <tr v-if="departements.length === 0">
                                            <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-sm">Aucun département trouvé</td>
                                        </tr>
                                        <tr v-for="dept in departements" :key="dept.id"
                                            class="hover:bg-slate-50/80 transition-colors cursor-pointer"
                                            @click="fetchStaffs(dept)">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="w-10 h-10 rounded-lg bg-[#e9ddff] flex items-center justify-center text-[#6b38d4]">
                                                        <span class="material-symbols-outlined">domain</span>
                                                    </div>
                                                    <span class="font-bold text-slate-900">{{ dept.name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">{{ dept.description }}</td>
                                            <td class="px-6 py-4">
                                                <span :class="dept.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                                    class="text-xs px-2 py-1 rounded-full">
                                                    {{ dept.is_active ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2" @click.stop>
                                                <button
                                                    class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all"
                                                    @click="openEditDept(dept)">
                                                    <span class="material-symbols-outlined text-xl">edit</span>
                                                </button>
                                                <button
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                    @click="deleteDepartement(dept.id)">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Personnel du département sélectionné -->
                        <div v-if="selectedDept" class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden">
                            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold text-slate-900">Personnel — {{ selectedDept.name }}</h3>
                                    <p class="text-xs text-[#494454] mt-0.5">{{ selectedDept.staffs?.length ?? 0 }} membre(s)</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="openAddRH()" class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                        <span class="material-symbols-outlined">person_add</span>
                                    </button>
                                    <button @click="selectedDept = null" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                </div>
                            </div>
                            <div class="p-6">
                                <p v-if="!selectedDept.staffs?.length" class="text-center text-slate-400 text-sm py-4">Aucun personnel dans ce département</p>
                                <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="staff in selectedDept.staffs" :key="staff.id"
                                        class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-[#6b38d4]/30 hover:bg-[#e9ddff]/20 transition-all">
                                        <div class="w-11 h-11 rounded-full bg-[#e9ddff] flex items-center justify-center text-[#6b38d4] font-black text-lg flex-shrink-0">
                                            {{ staff.name.charAt(0).toUpperCase() }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="font-bold text-slate-800 truncate">{{ staff.name }}</p>
                                            <p class="text-xs text-slate-500 truncate">{{ staff.email }}</p>
                                            <p class="text-xs text-slate-400">{{ staff.telephon }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-xs font-bold text-[#6b38d4]">{{ staff.salaire }} DH</p>
                                            <p class="text-xs text-slate-400">Âge: {{ staff.age }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1 flex-shrink-0">
                                            <button @click="openEditRH(staff)" class="p-1.5 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                                <span class="material-symbols-outlined text-base">edit</span>
                                            </button>
                                            <button @click="deleteRH(staff.id)" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                <span class="material-symbols-outlined text-base">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Insight Card -->
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-[#6b38d4] text-white p-6 rounded-xl shadow-lg relative overflow-hidden group">
                                <div class="relative z-10">
                                    <p class="text-white/80 font-semibold text-xs mb-1">Total Départements</p>
                                    <h4 class="text-3xl font-black">{{ departements.length }}</h4>
                                    <div
                                        class="mt-4 inline-flex items-center text-xs font-bold bg-white/20 px-2 py-1 rounded-md">
                                        {{ totalActifs }} actifs
                                    </div>
                                </div>
                                <span
                                    class="material-symbols-outlined absolute -bottom-4 -right-4 text-white/10 text-9xl group-hover:scale-110 transition-transform">domain</span>
                            </div>
                            <div
                                class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 relative overflow-hidden">
                                <p class="text-[#494454] font-semibold text-xs mb-1">Taux d'activité</p>
                                <h4 class="text-3xl font-black text-slate-900">{{ tauxActivite }}%</h4>
                                <div class="mt-4 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#006947] h-full transition-all" :style="`width:${tauxActivite}%`"></div>
                                </div>
                                <p class="mt-2 text-[10px] font-bold text-slate-400">{{ totalActifs }} actifs sur {{ departements.length }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Department Section (Right Column) -->
                    <div class="col-span-12 lg:col-span-4">
                        <div
                            class="sticky top-24 bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] p-6 border border-slate-50">
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-slate-900">Ajouter un Département</h3>
                                <p class="text-[#494454] text-sm mt-1">Créez une nouvelle catégorie organisationnelle.
                                </p>
                            </div>
                            <div v-if="successMsg" class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm font-semibold flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">check_circle</span>{{ successMsg }}
                            </div>

                            <form @submit="addDepartement" class="space-y-6">
                                <!-- Champ Name (obligatoire) -->
                                <div class="space-y-2">
                                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                        Nom du département <span class="text-red-500">*</span>
                                    </label>
                                    <input v-model="form.name" type="text" required
                                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all"
                                        placeholder="Ex: Marketing, RH, Finance..." />
                                    <p v-if="errors.name" class="text-red-500 text-xs">{{ errors.name[0] }}</p>
                                </div>

                                <!-- Champ Description (obligatoire) -->
                                <div class="space-y-2">
                                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea v-model="form.description" required rows="4"
                                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all resize-none"
                                        placeholder="Décrivez les responsabilités et objectifs de ce département..."></textarea>
                                    <p v-if="errors.description" class="text-red-500 text-xs">{{ errors.description[0] }}</p>
                                </div>

                                <!-- Champ Is_active (obligatoire) -->
                                <div class="space-y-2">
                                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                        Statut <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-6 pt-2">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" v-model="form.is_active" :value="true"
                                                class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4] focus:ring-2 border-slate-300" />
                                            <span class="text-sm text-slate-700">Actif</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" v-model="form.is_active" :value="false"
                                                class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4] focus:ring-2 border-slate-300" />
                                            <span class="text-sm text-slate-700">Inactif</span>
                                        </label>
                                    </div>
                                    <p v-if="errors.is_active" class="text-red-500 text-xs">{{ errors.is_active[0] }}</p>
                                </div>

                                <!-- Bouton de soumission -->
                                <div class="pt-2">
                                    <button
                                        class="w-full bg-[#6b38d4] text-white font-bold py-4 rounded-xl shadow-lg shadow-[#6b38d4]/20 hover:bg-[#8455ef] active:scale-[0.98] transition-all"
                                        type="submit">
                                        Ajouter le département
                                    </button>
                                    <p class="text-xs text-center text-slate-400 mt-3 italic">Formulaire avec champs
                                        obligatoires : nom, description, statut</p>
                                </div>
                            </form>

                            <!-- Message informatif -->
                            <div class="mt-8 p-4 bg-[#d8e2ff] rounded-xl flex items-start space-x-3">
                                <span class="material-symbols-outlined text-[#004395]">info</span>
                                <p class="text-[11px] leading-tight text-[#004395] font-medium">
                                    Les champs <strong>Nom</strong>, <strong>Description</strong> et
                                    <strong>Statut</strong> sont obligatoires pour créer un département.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <!-- Modal : Modifier Département -->
    <div v-if="showEditDept" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-slate-900">Modifier le Département</h3>
                <button @click="showEditDept = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form @submit="updateDepartement" class="p-6 space-y-5">
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Nom du département <span class="text-red-500">*</span></label>
                    <input v-model="editDeptForm.name" type="text" required
                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all" />
                    <p v-if="editDeptErrors.name" class="text-red-500 text-xs">{{ editDeptErrors.name[0] }}</p>
                </div>
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Description <span class="text-red-500">*</span></label>
                    <textarea v-model="editDeptForm.description" required rows="3"
                        class="w-full border border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none transition-all resize-none"></textarea>
                    <p v-if="editDeptErrors.description" class="text-red-500 text-xs">{{ editDeptErrors.description[0] }}</p>
                </div>
                <div class="space-y-2">
                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Statut <span class="text-red-500">*</span></label>
                    <div class="flex gap-6 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" v-model="editDeptForm.is_active" :value="true" class="w-4 h-4 text-[#6b38d4] border-slate-300" />
                            <span class="text-sm text-slate-700">Actif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" v-model="editDeptForm.is_active" :value="false" class="w-4 h-4 text-[#6b38d4] border-slate-300" />
                            <span class="text-sm text-slate-700">Inactif</span>
                        </label>
                    </div>
                    <p v-if="editDeptErrors.is_active" class="text-red-500 text-xs">{{ editDeptErrors.is_active[0] }}</p>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showEditDept = false"
                        class="flex-1 py-3 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 transition-all text-sm">Annuler</button>
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-[#6b38d4] hover:bg-[#8455ef] text-white font-bold transition-all text-sm">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal : Ajouter / Modifier RH -->
    <div v-if="showRHModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-slate-900">{{ rhModalMode === 'add' ? 'Ajouter un Personnel' : 'Modifier le Personnel' }}</h3>
                <button @click="showRHModal = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form @submit="submitRH" class="p-6 space-y-4">
                <div v-if="rhSuccess" class="p-3 bg-green-50 text-green-700 rounded-lg text-sm font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">check_circle</span>{{ rhSuccess }}
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">Nom complet <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.name" type="text" required
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm" />
                        <p v-if="rhErrors.name" class="text-red-500 text-xs">{{ rhErrors.name[0] }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">Email <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.email" type="email" required
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm" />
                        <p v-if="rhErrors.email" class="text-red-500 text-xs">{{ rhErrors.email[0] }}</p>
                    </div>
                </div>
                <div v-if="rhModalMode === 'add'" class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">Mot de passe <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.password" type="password" required
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm"
                            placeholder="Min. 8 caractères" />
                        <p v-if="rhErrors.password" class="text-red-500 text-xs">{{ rhErrors.password[0] }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">Confirmation <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.password_confirmation" type="password" required
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">Téléphone <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.telephon" type="text" required
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm" />
                        <p v-if="rhErrors.telephon" class="text-red-500 text-xs">{{ rhErrors.telephon[0] }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">CIN <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.CIN" type="text" required
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm" />
                        <p v-if="rhErrors.CIN" class="text-red-500 text-xs">{{ rhErrors.CIN[0] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">Âge <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.age" type="number" required min="18" max="100"
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm" />
                        <p v-if="rhErrors.age" class="text-red-500 text-xs">{{ rhErrors.age[0] }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-semibold text-xs text-slate-700">Salaire <span class="text-red-500">*</span></label>
                        <input v-model="rhForm.salaire" type="text" required
                            class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm"
                            placeholder="5000 DH" />
                        <p v-if="rhErrors.salaire" class="text-red-500 text-xs">{{ rhErrors.salaire[0] }}</p>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="font-semibold text-xs text-slate-700">Département <span class="text-red-500">*</span></label>
                    <select v-model="rhForm.departement_id" required
                        class="w-full border border-slate-200 rounded-lg py-2.5 px-3 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] outline-none text-sm">
                        <option value="" disabled>Sélectionner un département</option>
                        <option v-for="dept in departements" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                    </select>
                    <p v-if="rhErrors.departement_id" class="text-red-500 text-xs">{{ rhErrors.departement_id[0] }}</p>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showRHModal = false"
                        class="flex-1 py-3 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50 transition-all text-sm">Annuler</button>
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-[#6b38d4] hover:bg-[#8455ef] text-white font-bold transition-all text-sm">
                        {{ rhModalMode === 'add' ? 'Ajouter' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</template>