<script setup>
import { ref, onMounted } from 'vue';
import { useAuth } from '../../composables/useAuth.js';

const { isLoggedIn, user: authUser, logout } = useAuth();

const reservations = ref([]);
const spaSessions  = ref([]);
const commandes    = ref([]);
const loading      = ref(false);

const token = localStorage.getItem('token');

async function fetchAll() {
    if (!authUser.value?.id) return;
    loading.value = true;
    const uid = authUser.value.id;

    const [rRes, sRes, cRes] = await Promise.all([
        fetch('http://localhost:8080/api/client/reservations', {
            headers: { 'Authorization': `Bearer ${token}` }
        }),
        fetch('http://localhost:8080/api/client/spaSessions', {
            headers: { 'Authorization': `Bearer ${token}` }
        }),
        fetch('http://localhost:8080/api/client/commandes', {
            headers: { 'Authorization': `Bearer ${token}` }
        }),
    ]);
    const [rJson, sJson, cJson] = await Promise.all([rRes.json(), sRes.json(), cRes.json()]);

    reservations.value = (rJson.data.data ?? rJson.data).filter(r => r.user_id == uid);
    spaSessions.value  = (sJson.data.data ?? sJson.data).filter(s => s.client_id == uid);
    commandes.value    = (cJson.data.data ?? cJson.data).filter(c => c.client_id == uid);
    loading.value = false;
}

onMounted(fetchAll);
</script>

<template>
  <div class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">

    <!-- Header -->
    <header class="bg-[#fcf9ef]/80 backdrop-blur-xl top-0 sticky z-50 shadow-[0_20px_40px_rgba(28,28,22,0.04)]">
      <div class="flex justify-between items-center px-8 py-6 w-full max-w-screen-2xl mx-auto">
        <div class="text-2xl font-serif text-orange-900 tracking-tighter italic">
          <router-link to="/">Kasbah Royale</router-link>
        </div>
        <div class="flex items-center space-x-6 text-orange-900">
          <template v-if="isLoggedIn">
            <button @click="logout"
              class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-6 py-2 rounded-full font-label text-xs uppercase tracking-widest hover:scale-105 transition-all">
              Logout
            </button>
          </template>
          <template v-else>
            <router-link to="/login"
              class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-6 py-2 rounded-full font-label text-xs uppercase tracking-widest hover:scale-105 transition-all">
              Login
            </router-link>
          </template>
        </div>
      </div>
    </header>

    <div class="flex min-h-screen max-w-screen-2xl mx-auto">

      <!-- Sidebar -->
      <aside class="hidden md:flex flex-col h-[calc(100vh-88px)] w-72 rounded-r-[48px] bg-[#fcf9ef] py-12 px-6 sticky top-[88px]">
        <div class="mb-12 px-4">
          <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary font-headline text-2xl mb-4">
            {{ authUser?.name?.charAt(0).toUpperCase() ?? '?' }}
          </div>
          <h2 class="font-headline text-xl text-orange-900 mb-1">{{ authUser?.name ?? 'Traveler' }}</h2>
          <p class="text-stone-500 text-xs font-sans tracking-tight">{{ authUser?.email }}</p>
          <span class="inline-block mt-2 px-3 py-1 bg-primary/10 text-primary text-[10px] font-label uppercase tracking-widest rounded-full capitalize">
            {{ authUser?.role ?? 'client' }}
          </span>
        </div>
        <nav class="flex-1 space-y-2">
          <a href="#identity" class="flex items-center space-x-4 px-6 py-4 bg-stone-100 text-orange-800 font-semibold rounded-l-full hover:translate-x-1 transition-transform duration-300">
            <span class="material-symbols-outlined">person</span>
            <span class="font-sans tracking-tight">Identity</span>
          </a>
          <a href="#sanctuary" class="flex items-center space-x-4 px-6 py-4 text-stone-500 hover:bg-stone-50 hover:translate-x-1 transition-transform duration-300">
            <span class="material-symbols-outlined">bed</span>
            <span class="font-sans tracking-tight">Reservations</span>
          </a>
          <a href="#wellness" class="flex items-center space-x-4 px-6 py-4 text-stone-500 hover:bg-stone-50 hover:translate-x-1 transition-transform duration-300">
            <span class="material-symbols-outlined">spa</span>
            <span class="font-sans tracking-tight">Wellness</span>
          </a>
          <a href="#commandes" class="flex items-center space-x-4 px-6 py-4 text-stone-500 hover:bg-stone-50 hover:translate-x-1 transition-transform duration-300">
            <span class="material-symbols-outlined">restaurant</span>
            <span class="font-sans tracking-tight">Commandes</span>
          </a>
        </nav>
      </aside>

      <!-- Main -->
      <main class="flex-1 px-8 py-12 md:px-16 zellige-pattern">

        <!-- Loading -->
        <div v-if="loading" class="text-center py-20 text-stone-400 font-light">Chargement...</div>

        <template v-else>

          <!-- Identity -->
          <section class="mb-20" id="identity">
            <div class="flex items-baseline justify-between mb-8">
              <h1 class="font-display text-4xl text-on-surface tracking-tight italic">Identity</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 bg-surface-container-lowest p-10 rounded-[32px] shadow-[0_20px_40px_rgba(28,28,22,0.02)]">
              <div class="border-b border-outline-variant/20 pb-2">
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Full Name</label>
                <p class="font-headline text-lg text-on-surface">{{ authUser?.name ?? '—' }}</p>
              </div>
              <div class="border-b border-outline-variant/20 pb-2">
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Email Address</label>
                <p class="font-headline text-lg text-on-surface">{{ authUser?.email ?? '—' }}</p>
              </div>
              <div class="border-b border-outline-variant/20 pb-2">
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Phone Number</label>
                <p class="font-headline text-lg text-on-surface">{{ authUser?.telephon ?? '—' }}</p>
              </div>
              <div class="border-b border-outline-variant/20 pb-2">
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">CIN / Passport</label>
                <p class="font-headline text-lg text-on-surface">{{ authUser?.CIN ?? '—' }}</p>
              </div>
              <div class="border-b border-outline-variant/20 pb-2">
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Age</label>
                <p class="font-headline text-lg text-on-surface">{{ authUser?.age ?? '—' }}</p>
              </div>
              <div class="border-b border-outline-variant/20 pb-2">
                <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Role</label>
                <p class="font-headline text-lg text-on-surface capitalize">{{ authUser?.role ?? '—' }}</p>
              </div>
            </div>
          </section>

          <!-- Reservations -->
          <section class="mb-20" id="sanctuary">
            <div class="flex items-baseline justify-between mb-10">
              <h2 class="font-display text-3xl text-on-surface tracking-tight">My Reservations</h2>
              <span class="text-tertiary font-label text-xs">{{ reservations.length }} réservation(s)</span>
            </div>
            <div v-if="reservations.length === 0" class="text-center py-8 text-stone-400 font-light">Aucune réservation trouvée</div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div v-for="res in reservations" :key="res.id"
                class="bg-surface-container-low group overflow-hidden transition-all duration-500 hover:bg-surface-container-high rounded-xl p-8">
                <div class="flex items-center gap-2 mb-4">
                  <span class="material-symbols-outlined text-primary">king_bed</span>
                  <h3 class="font-headline text-2xl text-on-surface">Chambre #{{ res.chamber_id }}</h3>
                </div>
                <div class="flex justify-between items-end">
                  <p class="text-stone-500 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">calendar_today</span>
                    {{ res.date_enter }} — {{ res.date_sortie }}
                  </p>
                  <div class="text-right">
                    <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Prix</p>
                    <p class="text-primary font-headline text-xl">{{ res.prix }} DH</p>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Spa Sessions -->
          <section class="mb-20" id="wellness">
            <div class="flex items-baseline justify-between mb-8">
              <h2 class="font-display text-3xl text-on-surface tracking-tight">SPA Sessions</h2>
              <span class="text-tertiary font-label text-xs">{{ spaSessions.length }} session(s)</span>
            </div>
            <div v-if="spaSessions.length === 0" class="text-center py-8 text-stone-400 font-light">Aucune session SPA trouvée</div>
            <div class="space-y-4">
              <div v-for="spa in spaSessions" :key="spa.id"
                class="flex items-center justify-between p-6 bg-surface-container-lowest rounded-2xl hover:bg-surface-container transition-colors duration-300">
                <div class="flex items-center space-x-6">
                  <div class="w-14 h-14 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined">spa</span>
                  </div>
                  <div>
                    <h4 class="font-headline text-lg text-on-surface">Session SPA #{{ spa.id }}</h4>
                    <p class="text-stone-400 text-xs font-sans">{{ spa.date_debut }} — {{ spa.date_fin }}</p>
                  </div>
                </div>
                <div class="flex items-center space-x-6">
                  <p class="text-primary font-headline text-lg">{{ spa.prix }} DH</p>
                  <span :class="spa.is_validated ? 'text-green-600' : 'text-amber-500'" class="material-symbols-outlined">
                    {{ spa.is_validated ? 'check_circle' : 'pending' }}
                  </span>
                </div>
              </div>
            </div>
          </section>

          <!-- Commandes -->
          <section class="mb-20" id="commandes">
            <div class="flex items-baseline justify-between mb-8">
              <h2 class="font-display text-3xl text-on-surface tracking-tight">Mes Commandes</h2>
              <span class="text-tertiary font-label text-xs">{{ commandes.length }} commande(s)</span>
            </div>
            <div v-if="commandes.length === 0" class="text-center py-8 text-stone-400 font-light">Aucune commande trouvée</div>
            <div class="space-y-4">
              <div v-for="cmd in commandes" :key="cmd.id"
                class="flex items-center justify-between p-6 bg-surface-container-lowest rounded-2xl hover:bg-surface-container transition-colors duration-300">
                <div class="flex items-center space-x-6">
                  <div class="w-14 h-14 rounded-full bg-tertiary-container/20 flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined">restaurant</span>
                  </div>
                  <div>
                    <h4 class="font-headline text-lg text-on-surface">Commande #{{ cmd.id }}</h4>
                    <p class="text-stone-400 text-xs font-sans">{{ cmd.date }}</p>
                  </div>
                </div>
                <p class="text-primary font-headline text-lg">{{ cmd.prix }} DH</p>
              </div>
            </div>
          </section>

        </template>
      </main>
    </div>

    <!-- Footer -->
    <footer class="bg-[#fcf9ef] w-full border-t border-[#9a401f]/10 mt-8">
      <div class="flex flex-col items-center justify-center py-12 gap-4">
        <div class="font-serif text-lg text-[#755717]">Kasbah Royale</div>
        <p class="text-stone-400 text-xs tracking-widest">© 2024 Kasbah Royale. A sanctuary of the soul.</p>
      </div>
    </footer>

  </div>
</template>
