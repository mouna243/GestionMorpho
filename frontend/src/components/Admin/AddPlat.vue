<script setup>
import { ref, onMounted } from 'vue';

const API = 'http://localhost:8080/api/plats';

const plats = ref([]);
const totalPlats = ref(0);
const displayEditForm = ref(false);
const currentPlatId = ref(null);
const deleteConfirmId = ref(null);

const newPlat = ref({ name: '', description: '', prix: '', image: null });
const editPlat = ref({ name: '', description: '', prix: '', is_available: true, image: null });
const errors = ref({});

async function fetchPlats() {
    const res = await fetch(API);
    const json = await res.json();
    plats.value = json.data.data ?? json.data;
    totalPlats.value = json.data.total ?? plats.value.length;
}

async function addPlat(e) {
    e.preventDefault();
    errors.value = {};
    const fd = new FormData();
    fd.append('name', newPlat.value.name);
    fd.append('description', newPlat.value.description);
    fd.append('prix', newPlat.value.prix);
    if (newPlat.value.image) fd.append('image', newPlat.value.image);

    const res = await fetch(API, { method: 'POST', body: fd });
    const json = await res.json();
    if (!res.ok) { errors.value = json.errors ?? {}; return; }
    plats.value.unshift(json.data);
    totalPlats.value++;
    newPlat.value = { name: '', description: '', prix: '', image: null };
    e.target.reset();
}

function openEdit(plat) {
    currentPlatId.value = plat.id;
    editPlat.value = { name: plat.name, description: plat.description, prix: plat.prix, is_available: plat.is_available, image: null };
    errors.value = {};
    displayEditForm.value = true;
}

async function updatePlat(e) {
    e.preventDefault();
    errors.value = {};
    const fd = new FormData();
    fd.append('_method', 'PATCH');
    fd.append('name', editPlat.value.name);
    fd.append('description', editPlat.value.description);
    fd.append('prix', editPlat.value.prix);
    fd.append('is_available', editPlat.value.is_available ? 1 : 0);
    if (editPlat.value.image) fd.append('image', editPlat.value.image);

    const res = await fetch(`${API}/${currentPlatId.value}`, { method: 'POST', body: fd });
    const json = await res.json();
    if (!res.ok) { errors.value = json.errors ?? {}; return; }
    const idx = plats.value.findIndex(p => p.id === currentPlatId.value);
    if (idx !== -1) plats.value[idx] = { ...plats.value[idx], ...editPlat.value };
    displayEditForm.value = false;
}

async function deletePlat(id) {
    const res = await fetch(`${API}/${id}`, { method: 'DELETE' });
    if (res.ok) {
        plats.value = plats.value.filter(p => p.id !== id);
        totalPlats.value--;
        deleteConfirmId.value = null;
        if (currentPlatId.value === id) displayEditForm.value = false;
    }
}

onMounted(fetchPlats);
</script>

<template>
    <div class="bg-background text-on-surface">

        <!-- SideNavBar -->
        <aside class="fixed left-0 top-0 h-full w-[260px] bg-violet-600 dark:bg-violet-900 shadow-2xl flex flex-col py-6 z-50">
            <div class="px-6 mb-10">
                <h1 class="text-2xl font-black text-white font-plus-jakarta">Morpho Gestion</h1>
                <p class="text-violet-200 text-xs font-semibold uppercase tracking-widest mt-1">Administration</p>
            </div>
            <nav class="flex-1 space-y-2">
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold" href="#">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span><router-link to="/admin/dashboard">Dashboard</router-link></span>
                </a>
                <a class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold" href="#">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">restaurant_menu</span>
                    <span><router-link to="/admin/plats">Gestion des plats</router-link></span>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold" href="#">
                    <span class="material-symbols-outlined">add_circle</span>
                    <span><router-link to="/admin/departements">Gestion Départements</router-link></span>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold" href="#">
                    <span class="material-symbols-outlined">calendar_clock</span>
                    <span><router-link to="/admin/WorkShift">Gestion des WorkShifts</router-link></span>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold" href="#">
                    <span class="material-symbols-outlined">king_bed</span>
                    <span><router-link to="/admin/chambers">Gestion des Chambers</router-link></span>
                </a>
            </nav>
            <div class="px-4 mt-auto pt-6 border-t border-violet-500/30">
                <div class="space-y-1">
                    <a class="text-violet-100 hover:text-white px-4 py-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold" href="#">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-[260px] min-h-screen">
            <!-- TopAppBar -->
            <header class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm flex justify-between items-center px-8 py-4">
                <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Gestion des Plats</h2>
                <div class="flex items-center gap-4 border-l pl-6 border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center text-violet-600">
                        <span class="material-symbols-outlined">account_circle</span>
                    </div>
                    <span class="text-sm font-bold text-gray-700">Admin</span>
                </div>
            </header>

            <!-- Canvas -->
            <div class="p-8">
                <div class="grid grid-cols-12 gap-8">

                    <!-- Plate Gallery -->
                    <section class="col-span-12 lg:col-span-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="font-bold text-xl text-gray-800">Galerie des Plats</h3>
                                <p class="text-sm text-gray-500">Visualisez et gérez votre menu actuel</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div v-for="plat in plats" :key="plat.id"
                                class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all group overflow-hidden border border-gray-100">
                                <div class="h-48 overflow-hidden relative">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        :src="plat.image ? `http://localhost:8080/storage/${plat.image}` : 'https://via.placeholder.com/400x200?text=Plat'"
                                        :alt="plat.name" />
                                    <span v-if="!plat.is_available"
                                        class="absolute top-3 left-3 bg-red-100 text-red-600 px-3 py-1 rounded-full text-[10px] font-bold uppercase">
                                        Indisponible
                                    </span>
                                </div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg text-gray-800">{{ plat.name }}</h4>
                                        <span class="text-violet-600 font-extrabold">{{ plat.prix }} €</span>
                                    </div>
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ plat.description }}</p>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end items-center gap-2">
                                        <button @click="openEdit(plat)"
                                            class="text-violet-600 hover:bg-violet-50 p-2 rounded-full transition-colors">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                        <button @click="deleteConfirmId = plat.id"
                                            class="text-red-500 hover:bg-red-50 p-2 rounded-full transition-colors">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Add Form -->
                    <aside class="col-span-12 lg:col-span-4">
                        <div class="sticky top-24 bg-white rounded-2xl shadow-2xl p-6 border border-violet-50">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-12 h-12 bg-violet-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-violet-200">
                                    <span class="material-symbols-outlined">add_circle</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800">Nouveau Plat</h3>
                                    <p class="text-xs text-gray-500">Ajouter à la carte</p>
                                </div>
                            </div>
                            <form @submit="addPlat" class="space-y-4">
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Nom du Plat</label>
                                    <input v-model="newPlat.name"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none"
                                        placeholder="ex: Risotto aux truffes" type="text" />
                                    <p v-if="errors.name" class="text-red-500 text-xs">{{ errors.name[0] }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Description</label>
                                    <textarea v-model="newPlat.description"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none resize-none"
                                        placeholder="Description du plat..." rows="3"></textarea>
                                    <p v-if="errors.description" class="text-red-500 text-xs">{{ errors.description[0] }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Prix (€)</label>
                                    <div class="relative">
                                        <input v-model="newPlat.prix"
                                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-violet-500 outline-none"
                                            placeholder="0.00" step="0.01" type="number" />
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">€</span>
                                    </div>
                                    <p v-if="errors.prix" class="text-red-500 text-xs">{{ errors.prix[0] }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Image du Plat</label>
                                    <div class="relative group cursor-pointer">
                                        <div class="w-full h-28 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center gap-2 bg-gray-50 group-hover:bg-violet-50 group-hover:border-violet-200 transition-all">
                                            <span class="material-symbols-outlined text-gray-400 group-hover:text-violet-500">cloud_upload</span>
                                            <span class="text-xs font-bold text-gray-500 group-hover:text-violet-600">
                                                {{ newPlat.image ? newPlat.image.name : 'Cliquez pour télécharger' }}
                                            </span>
                                        </div>
                                        <input @change="e => newPlat.image = e.target.files[0]" class="absolute inset-0 opacity-0 cursor-pointer" type="file" accept="image/*" />
                                    </div>
                                    <p v-if="errors.image" class="text-red-500 text-xs">{{ errors.image[0] }}</p>
                                </div>
                                <div class="pt-2 space-y-3">
                                    <button class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-violet-200 active:scale-95 transition-all flex items-center justify-center gap-2" type="submit">
                                        <span class="material-symbols-outlined">save</span>
                                        Enregistrer le plat
                                    </button>
                                </div>
                            </form>

                            <!-- Stats -->
                            <div class="mt-6 bg-violet-600 text-white rounded-2xl p-6 shadow-xl relative overflow-hidden">
                                <div class="relative z-10">
                                    <h4 class="font-bold text-lg mb-1">Résumé du Menu</h4>
                                    <div class="space-y-3 mt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm opacity-80">Total des plats</span>
                                            <span class="font-black">{{ totalPlats }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -right-4 -bottom-4 opacity-10">
                                    <span class="material-symbols-outlined !text-8xl">restaurant</span>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <!-- Edit Form -->
                    <div v-if="displayEditForm" class="col-span-12 lg:col-span-4">
                        <div class="sticky top-24 bg-white rounded-2xl shadow-2xl p-6 border border-violet-50">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center text-white shadow-lg">
                                        <span class="material-symbols-outlined">edit</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800">Modifier le Plat</h3>
                                        <p class="text-xs text-gray-500">Mettre à jour les informations</p>
                                    </div>
                                </div>
                                <button @click="displayEditForm = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            <form @submit="updatePlat" class="space-y-4">
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Nom du Plat</label>
                                    <input v-model="editPlat.name"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-amber-400 outline-none"
                                        type="text" />
                                    <p v-if="errors.name" class="text-red-500 text-xs">{{ errors.name[0] }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Description</label>
                                    <textarea v-model="editPlat.description"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-amber-400 outline-none resize-none"
                                        rows="3"></textarea>
                                    <p v-if="errors.description" class="text-red-500 text-xs">{{ errors.description[0] }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Prix (€)</label>
                                    <div class="relative">
                                        <input v-model="editPlat.prix"
                                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-amber-400 outline-none"
                                            step="0.01" type="number" />
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">€</span>
                                    </div>
                                    <p v-if="errors.prix" class="text-red-500 text-xs">{{ errors.prix[0] }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <label class="text-sm font-bold text-gray-700">Disponible</label>
                                    <input v-model="editPlat.is_available" type="checkbox" class="w-4 h-4 accent-violet-600" />
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700">Nouvelle Image (optionnel)</label>
                                    <div class="relative group cursor-pointer">
                                        <div class="w-full h-24 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center gap-2 bg-gray-50 group-hover:bg-amber-50 group-hover:border-amber-200 transition-all">
                                            <span class="material-symbols-outlined text-gray-400 group-hover:text-amber-500">cloud_upload</span>
                                            <span class="text-xs font-bold text-gray-500">
                                                {{ editPlat.image ? editPlat.image.name : 'Changer l\'image' }}
                                            </span>
                                        </div>
                                        <input @change="e => editPlat.image = e.target.files[0]" class="absolute inset-0 opacity-0 cursor-pointer" type="file" accept="image/*" />
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <button class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl shadow-lg active:scale-95 transition-all flex items-center justify-center gap-2" type="submit">
                                        <span class="material-symbols-outlined">save</span>
                                        Mettre à jour
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <!-- Delete Confirm Modal -->
        <div v-if="deleteConfirmId" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-sm w-full mx-4">
                <div class="flex flex-col items-center gap-4 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-red-500 !text-3xl">delete</span>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800">Confirmer la suppression</h3>
                    <p class="text-gray-500 text-sm">Cette action est irréversible.</p>
                    <div class="flex gap-3 w-full mt-2">
                        <button @click="deleteConfirmId = null" class="flex-1 py-3 rounded-xl border border-gray-200 font-bold text-gray-600 hover:bg-gray-50 transition-all">
                            Annuler
                        </button>
                        <button @click="deletePlat(deleteConfirmId)" class="flex-1 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold transition-all">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
