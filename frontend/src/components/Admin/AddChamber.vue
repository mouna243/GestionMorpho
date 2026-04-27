<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
let loading = ref(false);
let error = ref(null);
let allChambers = ref([]);
let addTypeForm = ref(false);
let addChamberForm = ref(false);
let editTypeForm = ref(false);
let editChamberForm = ref(false);
let currentType = ref(null);
let currentChamber = ref(null);
let dataType = ref([]);
let dataAddType = reactive({
    name: '',
    description: '',
    prix: ''
})
let dataEditType = reactive({
    name: '',
    description: '',
    prix: ''
})

let dataAddChamber = reactive({

    name: '',
    image: null,
    description: '',
    is_available: '',
})
let dataEditChamber = reactive({
    name: '',
    image: null,
    description: '',
    is_available: '',
})
const openEditModal = (type) => {
    dataEditType.name = type.name;
    dataEditType.description = type.description;
    dataEditType.prix = type.prix;
    dataEditType.is_available = type.is_available;
    currentType.value = type.id;
};

const openEditChamberModal = (type) => {
    dataEditChamber.name = type.name;
    dataEditChamber.description = type.description;
    dataEditChamber.is_available = type.is_available;
    if (dataEditChamber.image instanceof File) {
        formData.append('image', dataEditChamber.image);
    }
    dataEditChamber.chamber_type_id = type.chamber_type_id;
    currentChamber.value = type.id;
};

const handleEditFileUpload = (e) => {
    const file = e.target.files[0];
    dataEditChamber.image = file;
};
const handleFileUpload = (e) => {
    const file = e.target.files[0];
    dataAddChamber.image = file;
};


const gestionChambers = async () => {

    loading.value = true
    error.value = null
    try {
        const response = await fetch('http://localhost:8080/api/chamberTypes');
        const json = await response.json();
        allChambers.value = json.data.data;


        if (!allChambers.ok) {
            throw new Error(json.message || 'Failed to fetch rooms')
        }
    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }


}
onMounted(gestionChambers);

const addType = async () => {
    try {
        const response = await fetch('http://localhost:8080/api/chamberTypes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: dataAddType.name,
                description: dataAddType.description,
                prix: dataAddType.prix,
                is_available: addTypeForm.is_available
            })
        })

        const json = await response.json();
        console.log(json);
        if (!response.ok) {
            throw new Error(json.message || 'Failed to fetch rooms');
        }

        addTypeForm.value = false
    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }
}


const addChamber = async () => {
    error.value = null
    loading.value = true

    const formData = new FormData();

    formData.append('name', dataAddChamber.name);
    formData.append('image', dataAddChamber.image);
    formData.append('description', dataAddChamber.description);
    formData.append('is_available', dataAddChamber.is_available ? 1 : 0);
    formData.append("chamber_type_id", currentType.value)

    try {
        const response = await fetch('http://localhost:8080/api/chambers', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }

        })

        const json = await response.json();
        if (!response.ok) {
            throw new Error(json.message || 'Failed to fetch rooms');
        }

        addChamberForm.value = false
        currentType.value = null
    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }
}

const editType = async () => {
    error.value = null
    loading.value = true


    try {
        const response = await fetch(`http://localhost:8080/api/chamberTypes/${currentType.value}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: dataEditType.name,
                description: dataEditType.description,
                prix: dataEditType.prix,
                is_available: dataEditType.is_available
            })
        })
        const json = await response.json();
        if (!response.ok) {
            throw new Error(json.message || 'Failed to fetch rooms');
        }
        editTypeForm.value = false
        currentType.value = null
    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }
}


const editChamber = async () => {
    error.value = null
    loading.value = true
    const formData = new FormData();

    formData.append('_method', 'PATCH');
    formData.append('name', dataEditChamber.name);
    formData.append('image', dataEditChamber.image);
    formData.append('description', dataEditChamber.description);
    formData.append('is_available', dataEditChamber.is_available ? 1 : 0);
    formData.append("chamber_type_id", dataEditChamber.chamber_type_id)

    try {
        const response = await fetch(`http://localhost:8080/api/chambers/${currentChamber.value}`, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }

        })

        const json = await response.json();
        console.log(json);
        if (!response.ok) {
            throw new Error(json.message || 'Failed to fetch rooms');
        }

        editChamberForm.value = false
        currentType.value = null
    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }
}

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
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                    href="#">
                    <span class="material-symbols-outlined">calendar_clock</span>
                    <span><router-link to="/admin/WorkShift">Gestion des WorkShifts</router-link></span>
                </a>
                <a
                    class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold">
                    <span class="material-symbols-outlined">king_bed</span>
                    <span><router-link to="/admin/chambers">Gestion des Chambers</router-link></span>
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

        <!-- TopAppBar Component -->
              <header
            class="fixed top-0 right-0 w-[calc(100%-260px)] h-16 z-40 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 shadow-sm border-b border-slate-100">
            <div class="flex items-center space-x-4 flex-1">
                <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Gestion des departements</h2>
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
        <main class="ml-[260px] pt-16 min-h-screen p-8">
            <div class="max-w-7xl mx-auto space-y-8">
                <!-- Page Header -->
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-[28px] leading-9 font-bold text-slate-900">Gestion des Chambres</h2>
                        <p class="text-[#494454] text-sm">Gérez les types de chambres et les chambres individuelles.</p>
                    </div>
                    <button @click="addTypeForm = true"
                        class="bg-[#6b38d4] text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-[#8455ef] transition-all flex items-center gap-2 shadow-lg shadow-[#6b38d4]/20">
                        <span class="material-symbols-outlined text-lg">add</span>
                        Nouveau Type
                    </button>
                </div>

                <!-- Types de Chambres Section -->
                <template v-if="allChambers.length > 0">

                    <div v-for="type in allChambers" id="roomTypesContainer" class="space-y-6">
                        <p v-if="type.length == 0" class="text-slate-400 text-sm italic">Aucune type</p>

                        <div
                            class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] border border-slate-100">
                            <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-[#e9ddff] flex items-center justify-center">
                                                <span
                                                    class="material-symbols-outlined text-[#6b38d4] text-2xl">king_bed</span>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-bold text-slate-900">{{ type.name }}</h3>
                                                <p class="text-sm text-slate-500 mt-1">
                                                    {{ type.description }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex gap-4 mt-3">
                                            <span class="text-2xl font-bold text-[#6b38d4]">
                                                {{ type.prix }}dh
                                            </span>
                                            <span class="text-sm px-2 py-1 rounded-full bg-green-100 text-green-700">
                                                {{ type.is_available ? 'Disponible' : 'Indisponible' }}
                                                {{ type.is_available }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click="editTypeForm = true; openEditModal(type)"
                                            class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button @click="addChamberForm = true; currentType.value = type.id"
                                        class="text-sm bg-[#6b38d4] text-white px-4 py-2 rounded-lg hover:bg-[#8455ef] transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">add</span>
                                        Ajouter une chambre
                                    </button>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[#6b38d4] text-base">meeting_room</span>
                                    Chambres ({{ type.chambers.length }})
                                </h4>
                                <p v-if="type.chambers.length == 0" class="text-slate-400 text-sm italic">Aucune chambre
                                    pour ce type</p>
                                <div class="space-y-3">
                                    <div v-for="chamber in type.chambers">
                                        <div
                                            class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-all">
                                            <div class="flex items-center gap-3 flex-1">
                                                <img :src="`http://localhost:8080/storage/${chamber.image}`"
                                                    class="w-12 h-12 rounded-lg object-cover">
                                                `<div
                                                    class="w-12 h-12 rounded-lg bg-slate-200 flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-slate-400">bed</span>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-slate-900">{{ chamber.name }}</p>
                                                    <p class="text-xs text-slate-500">{{ type.prix }}DH/nuit</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="text-xs px-2 py-1 rounded-full ${room.is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                                    {{ chamber.is_available ? 'Disponible' : 'Indisponible' }}
                                                </span>
                                                <button @click="editChamberForm = true; openEditChamberModal(chamber)"
                                                    class="p-1.5 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-sm">edit</span>
                                                </button>
                                                <button
                                                    class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <!-- Modal Ajouter Type de Chambre -->
            <div v-if="addTypeForm" id="typeModal"
                class="fixed inset-0 z-50  items-center justify-center modal-overlay">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                    <div class="flex justify-between p-6 border-b border-slate-100">
                        <h3 id="typeModalTitle" class="text-xl font-semibold text-slate-900">Ajouter un Type de Chambre
                        </h3>
                        <button @click="addTypeForm = false"
                            class="p-2 text-slate-400 hover:text-slate-500 hover:bg-slate-100 rounded-lg transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form @submit.prevent="addType" id="typeForm" class="p-6 space-y-4">
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Nom <span
                                    class="text-red-500">*</span></label>
                            <input v-model="dataAddType.name" type="text" id="typeName" required
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Ex: Suite Deluxe, Standard...">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700">Description</label>
                            <textarea v-model="dataAddType.description" id="typeDescription" rows="3"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Description du type de chambre..."></textarea>
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Prix / Nuit (€)
                                <span class="text-red-500">*</span></label>
                            <input v-model="dataAddType.prix" type="number" id="typePrix" required step="0.01"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="99.00">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Disponible <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-6 pt-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataAddType.is_available" type="radio" name="typeIsAvailable"
                                        value="true" checked class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Oui
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataAddType.is_available" type="radio" name="typeIsAvailable"
                                        value="false" class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Non
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button @click="editTypeForm = false" type="button"
                                class="flex-1 px-4 py-2 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 transition-all">Annuler</button>
                            <button type="submit" :disabled="loading"
                                class="flex-1 px-4 py-2 bg-[#6b38d4] text-white rounded-lg hover:bg-[#8455ef] transition-all font-semibold">
                                {{ loading ? "Enregistrement..." : 'Enregistrer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!--Modal modifier type de chamber -->
            <div v-if="editTypeForm" id="typeModal"
                class="fixed inset-0 z-50  items-center justify-center modal-overlay">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                    <div class="flex justify-between p-6 border-b border-slate-100">
                        <h3 id="typeModalTitle" class="text-xl font-semibold text-slate-900">Editer un Type de Chambre
                        </h3>
                        <button @click="editTypeForm = false"
                            class="p-2 text-slate-400 hover:text-slate-500 hover:bg-slate-100 rounded-lg transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form @submit.prevent="editType" id="typeForm" class="p-6 space-y-4">
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Nom <span
                                    class="text-red-500">*</span></label>
                            <input v-model="dataEditType.name" type="text" id="typeName" value="" required
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Ex: Suite Deluxe, Standard...">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700">Description</label>
                            <textarea v-model="dataEditType.description" id="typeDescription" rows="3"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Description du type de chambre..."></textarea>
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Prix / Nuit (€)
                                <span class="text-red-500">*</span></label>
                            <input v-model="dataEditType.prix" type="number" id="typePrix" required step="0.01"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="99.00">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Disponible <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-6 pt-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataEditType.is_available" type="radio" name="typeIsAvailable"
                                        value="true" checked class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Oui
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataEditType.is_available" type="radio" name="typeIsAvailable"
                                        value="false" class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Non
                                </label>
                            </div>
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button @click="editTypeForm = false" type="button"
                                class="flex-1 px-4 py-2 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 transition-all">Annuler</button>
                            <button type="submit" :disabled="loading"
                                class="flex-1 px-4 py-2 bg-[#6b38d4] text-white rounded-lg hover:bg-[#8455ef] transition-all font-semibold">
                                {{ loading ? "Enregistrement..." : 'Enregistrer' }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal Ajouter Chambre -->
            <div v-if="addChamberForm" id="roomModal"
                class="fixed inset-0 z-50  items-center justify-center modal-overlay">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                    <div class="flex justify-between p-6 border-b border-slate-100">
                        <h3 id="roomModalTitle" class="text-xl font-semibold text-slate-900">Ajouter une Chambre</h3>
                        <button @click="addChamberForm = false"
                            class="p-2 text-slate-400 hover:text-slate-500 hover:bg-slate-100 rounded-lg transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form @submit.prevent="addChamber" id="roomForm" class="p-6 space-y-4">
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Nom / Numéro
                                <span class="text-red-500">*</span></label>
                            <input v-model="dataAddChamber.name" type="text" id="roomName" required
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Ex: Chambre 101, Suite Royale...">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700">Image URL</label>
                            <input type="file" id="roomImage" @change="handleFileUpload"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="https://example.com/image.jpg">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700">Description</label>
                            <textarea v-model="dataAddChamber.description" id="roomDescription" rows="3"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Description de la chambre..."></textarea>
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Disponible <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-6 pt-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataAddChamber.is_available" type="radio" name="roomIsAvailable"
                                        value="true" checked class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Oui
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataAddChamber.is_available" type="radio" name="roomIsAvailable"
                                        value="false" class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Non
                                </label>
                            </div>
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button @click="addChamberForm = false" type="button"
                                class="flex-1 px-4 py-2 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 transition-all">Annuler</button>
                            <button type="submit" :disabled="loading"
                                class="flex-1 px-4 py-2 bg-[#6b38d4] text-white rounded-lg hover:bg-[#8455ef] transition-all font-semibold">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal modifier Chambre -->
            <div v-if="editChamberForm" id="roomModal"
                class="fixed inset-0 z-50  items-center justify-center modal-overlay">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                    <div class="flex justify-between p-6 border-b border-slate-100">
                        <h3 id="roomModalTitle" class="text-xl font-semibold text-slate-900">Modifier une Chambre</h3>
                        <button @click="editChamberForm = false"
                            class="p-2 text-slate-400 hover:text-slate-500 hover:bg-slate-100 rounded-lg transition-all">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form @submit.prevent="editChamber" id="roomForm" class="p-6 space-y-4">
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Nom / Numéro
                                <span class="text-red-500">*</span></label>
                            <input v-model="dataEditChamber.name" type="text" id="roomName" required
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Ex: Chambre 101, Suite Royale...">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700">Image URL</label>
                            <input type="file" id="roomImage" @change="handleEditFileUpload"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all">
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700">Description</label>
                            <textarea v-model="dataEditChamber.description" id="roomDescription" rows="3"
                                class="w-full border-slate-200 rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                placeholder="Description de la chambre..."></textarea>
                        </div>
                        <div>
                            <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">Disponible <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-6 pt-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataEditChamber.is_available" type="radio" name="roomIsAvailable"
                                        value="true" checked class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Oui
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input v-model="dataEditChamber.is_available" type="radio" name="roomIsAvailable"
                                        value="false" class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4]"> Non
                                </label>
                            </div>
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button @click="editChamberForm = false" type="button"
                                class="flex-1 px-4 py-2 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 transition-all">Annuler</button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 bg-[#6b38d4] text-white rounded-lg hover:bg-[#8455ef] transition-all font-semibold">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>
</template>

<style>
body {
    background-image: radial-gradient(circle at 2px 2px, rgba(107, 56, 212, 0.05) 1px, transparent 0);
    background-size: 24px 24px;
}

.modal-overlay {
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.transition-all-custom {
    transition: all 0.2s ease;
}
</style>
