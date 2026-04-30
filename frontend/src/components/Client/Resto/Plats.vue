<script setup>
import { ref, computed, onMounted } from 'vue';
import { useAuth } from '../../../composables/useAuth.js';

const { isLoggedIn, user: authUser, logout } = useAuth();

const token = localStorage.getItem('token');

const plats = ref([]);
const cart = ref([]); // [{ plat, quantite }]
const note = ref('');
const loading = ref(false);
const orderLoading = ref(false);
const orderError = ref('');
const bill = ref(null); // show bill after order

// --- computed ---
const cartTotal = computed(() => cart.value.reduce((s, i) => s + i.plat.prix * i.quantite, 0));
const cartCount = computed(() => cart.value.reduce((s, i) => s + i.quantite, 0));

// --- fetch plats ---
async function fetchPlats() {
    loading.value = true;
    const res = await fetch('http://localhost:8080/api/client/plats', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    const json = await res.json();
    plats.value = json.data.data ?? json.data;
    loading.value = false;
}

// --- cart ---
function addToCart(plat) {
    const item = cart.value.find(i => i.plat.id === plat.id);
    if (item) item.quantite++;
    else cart.value.push({ plat, quantite: 1 });
}

function increment(item) { item.quantite++; }
function decrement(item) {
    if (item.quantite > 1) item.quantite--;
    else cart.value = cart.value.filter(i => i.plat.id !== item.plat.id);
}
function removeItem(item) {
    cart.value = cart.value.filter(i => i.plat.id !== item.plat.id);
}

// --- submit order ---
async function submitOrder() {
    if (!cart.value.length) return;
    if (!authUser.value?.id) { orderError.value = 'Vous devez être connecté.'; return; }
    orderError.value = '';
    orderLoading.value = true;

    const res = await fetch('http://localhost:8080/api/client/commandes', {
        method: 'POST',
        headers: { 
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json', 
            'Accept': 'application/json' 
        },
        body: JSON.stringify({
            client_id: authUser.value.id,
            plats: cart.value.map(i => ({ plat_id: i.plat.id, quantite: i.quantite }))
        })
    });
    const json = await res.json();
    orderLoading.value = false;
    if (!res.ok) { orderError.value = json.message ?? 'Erreur lors de la commande'; return; }

    // build bill from response
    bill.value = {
        id: json.data.id,
        date: json.data.date ?? new Date().toISOString().substring(0, 10),
        items: cart.value.map(i => ({ name: i.plat.name, quantite: i.quantite, prix: i.plat.prix })),
        total: cartTotal.value,
        client: authUser.value?.name
    };
    cart.value = [];
    note.value = '';
}

onMounted(fetchPlats);
</script>

<template>
    <div class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 flex justify-between items-center px-12 py-6 max-w-screen-2xl mx-auto bg-[#fcf9ef]/80 backdrop-blur-md shadow-[0_20px_40px_rgba(28,28,22,0.06)]">
            <div class="font-serif text-2xl uppercase tracking-[0.2em] text-[#9a401f]"><router-link to="/">Kasbah Royale</router-link></div>
            <div class="hidden md:flex items-center gap-8">
                <router-link to="/"><a class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Home</a></router-link>
                <router-link to="/room"><a class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Room</a></router-link>
                <router-link to="/SPA"><a class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">SPA</a></router-link>
                <router-link to="/menu"><a class="font-noto-serif text-lg tracking-tight text-[#755717] border-b-2 border-[#755717] pb-1 font-semibold">Menu</a></router-link>
            </div>
            <div class="flex items-center gap-6">
                <template v-if="isLoggedIn">
                    <router-link to="/client/profile" class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300 flex items-center gap-1">
                        <span class="material-symbols-outlined">account_circle</span>
                        {{ authUser?.name?.split(' ')[0] }}
                    </router-link>
                    <button @click="logout" class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-sm uppercase tracking-widest hover:scale-105 transition-all duration-300">Logout</button>
                </template>
                <template v-else>
                    <router-link to="/login" class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-sm uppercase tracking-widest hover:scale-105 transition-all duration-300">Login</router-link>
                </template>
            </div>
        </nav>

        <main class="max-w-screen-2xl mx-auto px-12 pt-32 pb-24 zellige-pattern">
            <div class="mb-12">
                <span class="font-label text-xs uppercase tracking-[0.3em] text-tertiary mb-2 block">In-Room Culinary Service</span>
                <h1 class="font-headline text-5xl font-light text-on-background tracking-tight mb-4">Kasbah Royale Selection</h1>
                <p class="text-on-surface-variant max-w-xl font-light leading-relaxed">Savor the essence of the Atlas Mountains from the privacy of your sanctuary.</p>
            </div>

            <div class="flex flex-col md:flex-row gap-16">
                <!-- Plats list -->
                <section class="flex-1">
                    <div v-if="loading" class="text-center py-12 text-on-surface-variant">Chargement...</div>
                    <div v-else class="space-y-6">
                        <div v-for="plat in plats" :key="plat.id"
                            class="flex items-center gap-6 p-6 bg-surface-container-low rounded-xl group transition-all duration-300 hover:bg-surface-container-high">
                            <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0 bg-surface-container flex items-center justify-center">
                                <img v-if="plat.image" :src="`http://localhost:8080/storage/${plat.image}`"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" :alt="plat.name" />
                                <span v-else class="material-symbols-outlined text-4xl text-on-surface-variant">restaurant</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h3 class="font-headline text-lg text-on-surface">{{ plat.name }}</h3>
                                    <span class="font-label text-sm text-tertiary font-bold">{{ plat.prix }} DH</span>
                                </div>
                                <p class="text-sm text-on-surface-variant font-light mb-4">{{ plat.description }}</p>
                                <div class="flex items-center gap-4">
                                    <!-- if in cart show qty controls -->
                                    <template v-if="cart.find(i => i.plat.id === plat.id)">
                                        <div class="flex items-center border border-outline-variant/30 rounded-full px-3 py-1 bg-surface">
                                            <button @click="decrement(cart.find(i => i.plat.id === plat.id))" class="material-symbols-outlined text-xs hover:text-primary transition-colors">remove</button>
                                            <span class="px-4 font-label text-sm">{{ cart.find(i => i.plat.id === plat.id).quantite }}</span>
                                            <button @click="increment(cart.find(i => i.plat.id === plat.id))" class="material-symbols-outlined text-xs hover:text-primary transition-colors">add</button>
                                        </div>
                                        <button @click="removeItem(cart.find(i => i.plat.id === plat.id))"
                                            class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-error transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">delete</span> Retirer
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button @click="addToCart(plat)"
                                            :disabled="!plat.is_available"
                                            class="px-6 py-2 rounded-full border border-primary text-primary font-label text-[10px] uppercase tracking-widest hover:bg-primary hover:text-on-primary transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                                            {{ plat.is_available ? 'Ajouter' : 'Indisponible' }}
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="mt-12">
                        <label class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant mb-3 block">Notes pour notre équipe culinaire</label>
                        <textarea v-model="note"
                            class="w-full bg-surface-container-low border-b border-outline-variant/30 focus:border-primary focus:ring-0 rounded-t-xl transition-all p-6 font-light text-sm italic outline-none resize-none"
                            placeholder="Préférences alimentaires, allergies..." rows="3"></textarea>
                    </div>
                </section>

                <!-- Order summary -->
                <aside class="w-full md:w-[400px]">
                    <div class="bg-surface-container shadow-[0_20px_40px_rgba(28,28,22,0.06)] rounded-3xl p-8 sticky top-32 overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="material-symbols-outlined text-8xl">restaurant</span>
                        </div>
                        <h2 class="font-headline text-xl mb-6 relative z-10">Votre Commande</h2>

                        <div class="relative z-10">
                            <!-- empty cart -->
                            <div v-if="cart.length === 0" class="text-center py-8 text-on-surface-variant font-light text-sm">
                                <span class="material-symbols-outlined text-4xl block mb-2 opacity-30">shopping_cart</span>
                                Votre panier est vide
                            </div>

                            <!-- cart items -->
                            <div v-else class="space-y-4 mb-6">
                                <div v-for="item in cart" :key="item.plat.id" class="flex justify-between items-center text-sm">
                                    <div>
                                        <span class="font-medium">{{ item.plat.name }}</span>
                                        <span class="text-on-surface-variant ml-2">x{{ item.quantite }}</span>
                                    </div>
                                    <span class="font-label text-tertiary font-bold">{{ (item.plat.prix * item.quantite).toFixed(2) }} DH</span>
                                </div>
                                <div class="flex justify-between items-end pt-4 border-t border-outline-variant/20">
                                    <span class="font-label text-xs uppercase tracking-widest">Total</span>
                                    <span class="font-headline text-3xl text-primary">{{ cartTotal.toFixed(2) }} DH</span>
                                </div>
                            </div>

                            <div v-if="orderError" class="mb-4 p-3 bg-red-50 text-red-600 rounded-xl text-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">error</span>{{ orderError }}
                            </div>

                            <button @click="submitOrder" :disabled="!cart.length || orderLoading"
                                class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary py-5 rounded-full font-label text-xs uppercase tracking-[0.2em] shadow-lg hover:scale-[1.02] active:scale-95 transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed">
                                {{ orderLoading ? 'En cours...' : 'Finaliser la Commande' }}
                            </button>
                            <p class="text-center text-[9px] font-light text-on-surface-variant leading-relaxed px-4 mt-4">
                                Les frais seront appliqués à votre compte suite.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </main>

        <footer class="bg-[#fcf9ef] dark:bg-stone-950 w-full border-t border-[#9a401f]/10 mt-20">
            <div class="flex flex-col items-center justify-center py-16 gap-8 w-full">
                <div class="font-['Noto_Serif'] text-lg text-[#755717]">The Sensory Riad</div>
                <p class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-xs tracking-widest opacity-60">© 2024 The Sensory Riad.</p>
            </div>
        </footer>
    </div>

    <!-- Bill Modal -->
    <div v-if="bill" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
        <div class="bg-[#fcf9ef] rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="px-8 py-6 border-b border-[#9a401f]/10 flex items-center justify-between">
                <div>
                    <h3 class="font-headline text-2xl text-[#9a401f]">Votre Facture</h3>
                    <p class="text-xs text-[#755717]/70 mt-0.5 font-light">Commande #{{ bill.id }} — {{ bill.date }}</p>
                </div>
                <button @click="bill = null" class="p-2 text-[#9a401f]/50 hover:text-[#9a401f] hover:bg-[#9a401f]/10 rounded-full transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-4">
                <div class="flex justify-between text-sm text-[#755717]/70">
                    <span class="font-label text-[10px] uppercase tracking-widest">Client</span>
                    <span class="font-medium">{{ bill.client }}</span>
                </div>
                <div class="border-t border-[#9a401f]/10 pt-4 space-y-3">
                    <div v-for="item in bill.items" :key="item.name" class="flex justify-between text-sm">
                        <span class="font-light">{{ item.name }} <span class="text-[#755717]/60">x{{ item.quantite }}</span></span>
                        <span class="font-medium text-[#9a401f]">{{ (item.prix * item.quantite).toFixed(2) }} DH</span>
                    </div>
                </div>
                <div class="border-t border-[#9a401f]/20 pt-4 flex justify-between items-end">
                    <span class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Total</span>
                    <span class="font-headline text-3xl text-[#9a401f]">{{ bill.total.toFixed(2) }} DH</span>
                </div>
                <div class="pt-2 p-4 bg-[#9a401f]/5 rounded-2xl text-center">
                    <span class="material-symbols-outlined text-green-600 text-3xl block mb-1">check_circle</span>
                    <p class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Commande confirmée avec succès</p>
                </div>
                <button @click="bill = null"
                    class="w-full py-4 rounded-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-label text-[10px] uppercase tracking-widest hover:scale-[1.02] transition-all">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</template>
