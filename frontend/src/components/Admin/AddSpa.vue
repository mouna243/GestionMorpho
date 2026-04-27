<script setup>
import { ref, computed, onMounted } from 'vue';

const API_TYPES = 'http://localhost:8080/api/typeSpaSession';
const API_SESSIONS = 'http://localhost:8080/api/spaSessions';

// data
const types = ref([]);
const sessions = ref([]);
const loading = ref(false);

// stats
const totalSessions = computed(() => sessions.value.length);
const sessionsValidees = computed(() => sessions.value.filter(s => s.is_validated).length);
const sessionsEnAttente = computed(() => sessions.value.filter(s => !s.is_validated).length);

// --- Type SPA modal ---
const showTypeModal = ref(false);
const typeModeEdit = ref(false);
const editTypeId = ref(null);
const typeForm = ref({ name: '', description: '', prix: '', is_available: true });
const typeErrors = ref({});

// --- Session modal ---
const showSessionModal = ref(false);
const sessionForm = ref({ type_spa_session_id: '', client_id: '', date_debut: '', date_fin: '' });
const sessionErrors = ref({});

async function fetchAll() {
    loading.value = true;
    const [tRes, sRes] = await Promise.all([
        fetch(API_TYPES),
        fetch(API_SESSIONS)
    ]);
    const tJson = await tRes.json();
    const sJson = await sRes.json();
    types.value = tJson.data.data ?? tJson.data;
    sessions.value = sJson.data.data ?? sJson.data;
    loading.value = false;
}

// --- Type CRUD ---
function openAddType() {
    typeModeEdit.value = false;
    editTypeId.value = null;
    typeForm.value = { name: '', description: '', prix: '', is_available: true };
    typeErrors.value = {};
    showTypeModal.value = true;
}

function openEditType(type) {
    typeModeEdit.value = true;
    editTypeId.value = type.id;
    typeForm.value = { name: type.name, description: type.description, prix: type.prix, is_available: !!type.is_available };
    typeErrors.value = {};
    showTypeModal.value = true;
}

async function submitType(e) {
    e.preventDefault();
    typeErrors.value = {};
    const isEdit = typeModeEdit.value;
    const url = isEdit ? `${API_TYPES}/${editTypeId.value}` : API_TYPES;
    const res = await fetch(url, {
        method: isEdit ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ ...typeForm.value, is_available: typeForm.value.is_available ? 1 : 0 })
    });
    const json = await res.json();
    if (!res.ok) { typeErrors.value = json.errors ?? {}; return; }
    showTypeModal.value = false;
    await fetchAll();
}

async function deleteType(id) {
    if (!confirm('Supprimer ce type de service SPA ?')) return;
    await fetch(`${API_TYPES}/${id}`, { method: 'DELETE' });
    await fetchAll();
}

// --- Session validation ---
async function validateSession(session) {
    const res = await fetch(`${API_SESSIONS}/${session.id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({
            type_spa_session_id: session.type_spa_session_id,
            date_debut: session.date_debut,
            date_fin: session.date_fin,
            is_validated: 1
        })
    });
    if (res.ok) await fetchAll();
}

async function deleteSession(id) {
    if (!confirm('Supprimer cette session SPA ?')) return;
    await fetch(`${API_SESSIONS}/${id}`, { method: 'DELETE' });
    await fetchAll();
}

function typeName(id) {
    return types.value.find(t => t.id == id)?.name ?? '—';
}

onMounted(fetchAll);
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-green-50">

        <!-- SideNavBar -->
        <aside class="fixed left-0 top-0 h-full w-[260px] bg-violet-600 dark:bg-violet-900 shadow-2xl flex flex-col py-6 z-50">
            <div class="px-6 mb-10">
                <h1 class="text-2xl font-black text-white font-plus-jakarta">Morpho Gestion</h1>
                <p class="text-violet-200 text-xs font-semibold uppercase tracking-widest mt-1">Administration</p>
            </div>
            <nav class="flex-1 space-y-2">
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">dashboard</span>
                    <router-link to="/admin/dashboard">Dashboard</router-link>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">restaurant_menu</span>
                    <router-link to="/admin/plats">Gestion des plats</router-link>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">add_circle</span>
                    <router-link to="/admin/departements">Gestion Départements</router-link>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">calendar_clock</span>
                    <router-link to="/admin/WorkShift">Gestion des WorkShifts</router-link>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">king_bed</span>
                    <router-link to="/admin/chambers">Gestion des Chambers</router-link>
                </a>
                <a class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">sentiment_calm</span>
                    <router-link to="/admin/SpaSession">Gestion des SPA</router-link>
                </a>
            </nav>
            <div class="px-4 mt-auto pt-6 border-t border-violet-500/30">
                <a class="text-violet-100 hover:text-white px-4 py-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- TopAppBar -->
        <header class="fixed top-0 right-0 w-[calc(100%-260px)] h-16 z-40 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 shadow-sm border-b border-slate-100">
            <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Gestion des SPA Sessions</h2>
            <div class="flex items-center gap-4 border-l pl-6 border-gray-200">
                <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center text-violet-600">
                    <span class="material-symbols-outlined">account_circle</span>
                </div>
                <span class="text-sm font-bold text-gray-700">Admin</span>
            </div>
        </header>

        <main class="ml-[260px] pt-24 px-8 pb-12">

            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 font-plus-jakarta">Sessions SPA</h2>
                    <p class="text-gray-500 text-sm mt-1">Gérez les services et sessions de bien-être</p>
                </div>
                <button @click="openAddType()"
                    class="bg-violet-600 hover:bg-violet-700 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg transition-all active:scale-95">
                    <span class="material-symbols-outlined">add</span>
                    Nouveau Service SPA
                </button>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase font-semibold">Total Sessions</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ totalSessions }}</p>
                        </div>
                        <div class="w-12 h-12 bg-violet-100 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-violet-600 text-2xl">spa</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase font-semibold">Validées</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ sessionsValidees }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 text-2xl">check_circle</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase font-semibold">En Attente</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ sessionsEnAttente }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-yellow-600 text-2xl">pending</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm uppercase font-semibold">Services SPA</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ types.length }}</p>
                        </div>
                        <div class="w-12 h-12 bg-violet-100 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-violet-600 text-2xl">self_improvement</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sessions Table -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-violet-50 to-transparent flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Liste des Sessions SPA</h3>
                    <span class="px-3 py-1 bg-violet-100 text-violet-700 text-xs font-bold rounded-full">{{ totalSessions }} session(s)</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type de Service</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date Début</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date Fin</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Prix</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-if="loading">
                                <td colspan="8" class="px-6 py-8 text-center text-gray-400 text-sm">Chargement...</td>
                            </tr>
                            <tr v-else-if="sessions.length === 0">
                                <td colspan="8" class="px-6 py-8 text-center text-gray-400 text-sm">Aucune session trouvée</td>
                            </tr>
                            <tr v-for="session in sessions" :key="session.id" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ session.id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-violet-500 text-sm">spa</span>
                                        <span class="text-sm text-gray-700">{{ typeName(session.type_spa_session_id) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ session.client?.name ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ session.date_debut }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ session.date_fin }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ session.prix }} DH</td>
                                <td class="px-6 py-4">
                                    <span :class="session.is_validated ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full">
                                        <span :class="session.is_validated ? 'bg-green-600' : 'bg-yellow-500'" class="w-1.5 h-1.5 rounded-full"></span>
                                        {{ session.is_validated ? 'Validée' : 'En attente' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button v-if="!session.is_validated" @click="validateSession(session)"
                                            class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-all" title="Valider">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                        </button>
                                        <button @click="deleteSession(session.id)"
                                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all" title="Supprimer">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Services SPA Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-violet-600">spa</span>
                    Services SPA Disponibles
                </h3>
                <div v-if="types.length === 0" class="text-center text-gray-400 py-8">Aucun service SPA créé</div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="type in types" :key="type.id"
                        class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-violet-100 rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-violet-600">self_improvement</span>
                                </div>
                                <h4 class="font-bold text-gray-800">{{ type.name }}</h4>
                            </div>
                            <div class="flex gap-1">
                                <button @click="openEditType(type)" class="p-1.5 text-violet-600 hover:bg-violet-50 rounded-lg transition-all">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <button @click="deleteType(type.id)" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-3">{{ type.description }}</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                            <span class="text-sm font-semibold text-gray-800">{{ type.prix }} DH</span>
                            <span :class="type.status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                class="text-xs px-2 py-0.5 rounded-full font-semibold">
                                {{ type.status ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Type SPA -->
    <div v-if="showTypeModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800">{{ typeModeEdit ? 'Modifier le Service' : 'Nouveau Service SPA' }}</h3>
                <button @click="showTypeModal = false" class="p-2 text-gray-400 hover:bg-gray-100 rounded-lg transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form @submit="submitType" class="p-6 space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom <span class="text-red-500">*</span></label>
                    <input v-model="typeForm.name" type="text" required
                        class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-violet-300 outline-none text-sm" />
                    <p v-if="typeErrors.name" class="text-red-500 text-xs">{{ typeErrors.name[0] }}</p>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Description <span class="text-red-500">*</span></label>
                    <textarea v-model="typeForm.description" required rows="3"
                        class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-violet-300 outline-none text-sm resize-none"></textarea>
                    <p v-if="typeErrors.description" class="text-red-500 text-xs">{{ typeErrors.description[0] }}</p>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Prix (DH) <span class="text-red-500">*</span></label>
                    <input v-model="typeForm.prix" type="number" step="0.01" required
                        class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-violet-300 outline-none text-sm" />
                    <p v-if="typeErrors.prix" class="text-red-500 text-xs">{{ typeErrors.prix[0] }}</p>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Disponibilité</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" v-model="typeForm.is_available" :value="true" class="accent-violet-600" />
                            <span class="text-sm">Disponible</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" v-model="typeForm.is_available" :value="false" class="accent-violet-600" />
                            <span class="text-sm">Indisponible</span>
                        </label>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showTypeModal = false"
                        class="flex-1 py-3 rounded-xl border border-gray-200 font-bold text-gray-600 hover:bg-gray-50 transition-all text-sm">Annuler</button>
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-bold transition-all text-sm">
                        {{ typeModeEdit ? 'Enregistrer' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</template>
