<script setup>
import { ref, onMounted } from 'vue';
import { useAuth } from '../../../composables/useAuth.js';

const { isLoggedIn, user: authUser, logout } = useAuth();

const token = localStorage.getItem('token');

const types = ref([]);
const loading = ref(false);
const showModal = ref(false);
const selectedType = ref(null);
const spaForm = ref({ date_debut: '', date_fin: '' });
const spaError = ref('');
const spaSuccess = ref('');
const spaLoading = ref(false);
const me = ref(JSON.parse(localStorage.getItem('user') || 'null'));

async function fetchTypes() {
  loading.value = true;
  const res = await fetch('http://localhost:8080/api/client/typeSpaSession');
  const json = await res.json();
  types.value = json.data.data ?? json.data;
  loading.value = false;
}

function openBook(type) {
  selectedType.value = type;
  spaForm.value = { date_debut: '', date_fin: '' };
  spaError.value = '';
  spaSuccess.value = '';
  showModal.value = true;
}

async function submitSpa(e) {
  e.preventDefault();
  spaError.value = '';
  spaSuccess.value = '';
  if (!me.value?.id) { spaError.value = 'Vous devez être connecté.'; return; }
  spaLoading.value = true;
  const res = await fetch('http://localhost:8080/api/client/spaSessions', {
    method: 'POST',
    headers: { 
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json', 
      'Accept': 'application/json' 
    },
    body: JSON.stringify({
      type_spa_session_id: selectedType.value.id,
      client_id: me.value.id,
      date_debut: spaForm.value.date_debut,
      date_fin: spaForm.value.date_fin
    })
  });
  const json = await res.json();
  spaLoading.value = false;
  if (!res.ok) { spaError.value = json.message ?? 'Erreur'; return; }
  spaSuccess.value = 'Session réservée avec succès !';
  setTimeout(() => { showModal.value = false; }, 1500);
}

onMounted(fetchTypes);
</script>

<template>

  <div class="bg-surface text-on-surface font-body selection:bg-primary-fixed-dim selection:text-on-primary-fixed">
    <!-- TopAppBar -->
    <nav
      class="fixed top-0 w-full z-50 flex justify-between items-center px-12 py-6 max-w-screen-2xl mx-auto bg-[#fcf9ef]/80 backdrop-blur-md shadow-[0_20px_40px_rgba(28,28,22,0.06)]">
      <div class="font-serif text-2xl uppercase tracking-[0.2em] text-[#9a401f]"><router-link to="/">Kasbah
          Royale</router-link></div>
      <div class="hidden md:flex items-center gap-8">
        <router-link to="/">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Home</a>
        </router-link>
        <router-link to="/room">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Room</a>
        </router-link>
        <router-link to="/SPA">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#755717] border-b-2 border-[#755717] pb-1 font-semibold">SPA</a>
        </router-link>
        <router-link to="/menu">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Menu</a>
        </router-link>
      </div>
      <div class="flex items-center gap-6">
        <template v-if="isLoggedIn">
          <router-link to="/client/profile"
            class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300 flex items-center gap-1">
            <span class="material-symbols-outlined">account_circle</span>
            {{ authUser?.name?.split(' ')[0] }}
          </router-link>
          <button @click="logout"
            class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-xs uppercase tracking-[0.15em] hover:scale-105 transition-all duration-300 shadow-lg">
            Logout
          </button>
        </template>
        <template v-else>
          <router-link to="/login"
            class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-xs uppercase tracking-[0.15em] hover:scale-105 transition-all duration-300 shadow-lg">
            Login
          </router-link>
        </template>
      </div>
    </nav>
    <main class="pt-24 zellige-pattern">
      <!-- Hero Section -->
      <section class="relative h-[921px] flex flex-col items-center justify-center px-12 overflow-hidden">
        <div class="absolute inset-0 z-0">
          <img class="w-full h-full object-cover brightness-75 scale-110"
            data-alt="Luxurious traditional Moroccan hammam with marble steam room, warm sunlight filtering through geometric vents, and soft incense smoke"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC23I96eMhhCWge5piQNYoF1NTTxX8q94nz9lvP8QUkAoxtREUFL1bZAQ5zjdcqXzlElBoIuhh0n3YwICqmedr-PDHM77_OYNdNKiA5r1pk_H90to0-paXaxJu3YNQZ1c-Wu-KMenkk9GdEi09nonrGuj-gMjv5ZEW5HybrTsUfUuJ6yzKIF0gsC6-SwoKCRmaF5AUsxPFPtEDahk_95xpofuxgtETPeuK6au9jUvJ1Dj8YdvNMGrEhCoCqA1eL6j29KuVOj3RqcyLp" />
          <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-surface"></div>
        </div>
        <div class="relative z-10 text-center max-w-4xl">
          <span class="inline-block font-label text-white/90 uppercase tracking-[0.3em] text-[10px] mb-6">Sanctuary of
            the Soul</span>
          <h1 class="text-display-lg text-7xl md:text-8xl font-headline font-light text-white leading-tight mb-8">The
            Royal <br /><span class="italic text-tertiary-fixed-dim">Wellness Sanctuary</span></h1>
          <p class="text-white/80 font-body text-lg leading-relaxed max-w-2xl mx-auto mb-10">
            A celestial journey through ancient Moorish rituals. From the cleansing heat of the hammam to the infusion
            of rare Atlas botanicals.
          </p>
          <div class="flex justify-center gap-6">
            <button
              class="bg-primary text-on-primary px-10 py-4 rounded-full font-label text-xs uppercase tracking-widest hover:bg-primary-container transition-all">
              Explore Treatments
            </button>
            <button
              class="border border-white/30 backdrop-blur-md text-white px-10 py-4 rounded-full font-label text-xs uppercase tracking-widest hover:bg-white/10 transition-all">
              View Menu
            </button>
          </div>
        </div>
        <!-- Architectural Accent -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[80%] h-32 bg-surface hero-arch"></div>
      </section>
      <!-- Intro Content -->
      <section class="py-24 px-12 max-w-screen-2xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-16 items-center">
        <div class="md:col-span-5">
          <div class="relative">
            <img class="w-full aspect-[4/5] object-cover arch-mask shadow-2xl"
              data-alt="Close up of essential oils and Moroccan argan oil in amber glass bottles on a terracotta tile surface"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuAx7UHXz_aFPHSnM5hX9laIJGmZgZ1COvMq4OV08Yxjn7FCgf0w5Z9bXQxn_pa0Yj5ln_swqqqo0DJGBLKLVtxWKzl_J1sWuo2-D_ZrFyeWZ2D_9638ZbidPyMd9kQ73LO6MNf2YORZRHtgJ3ZYDJ5MscqRQ7ulq_8BaOOoMS7tnSUwAXSfO0ST5Mz41uTvpdj28Bo3bYanOR__gxBDpeaaNl1WYfipwanxbvluWtmwJL6NZ1HF550HrcrYw77P3mwjj_6X5TGJBVV0" />
            <div
              class="absolute -bottom-8 -right-8 w-48 h-48 bg-tertiary-container/10 backdrop-blur-xl rounded-full flex items-center justify-center p-8 border border-tertiary/20">
              <p class="text-[10px] font-label text-tertiary text-center uppercase tracking-widest">Est. 1924 <br />
                Legacy of Purity</p>
            </div>
          </div>
        </div>
        <div class="md:col-span-7">
          <h2 class="font-headline text-5xl text-primary mb-8 leading-tight">The Art of <span class="italic">The Slow
              Reveal</span></h2>
          <p class="font-body text-on-surface-variant text-lg leading-relaxed mb-8">
            In the heart of Kasbah Royale, time operates differently. Our wellness philosophy is rooted in the "Slow
            Reveal"—a process of peeling back the layers of daily life to uncover a state of profound tranquility. We
            pair centuries-old Moroccan traditions with modern therapeutic precision.
          </p>
          <div class="grid grid-cols-2 gap-8">
            <div>
              <span class="block text-3xl font-headline text-tertiary mb-2">12</span>
              <span class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest">Private Treatment
                Alcovs</span>
            </div>
            <div>
              <span class="block text-3xl font-headline text-tertiary mb-2">100%</span>
              <span class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest">Organic Atlas
                Botanicals</span>
            </div>
          </div>
        </div>
      </section>
      <!-- Treatments Grid -->
      <section class="bg-surface-container-low py-32 px-12">
        <div class="max-w-screen-2xl mx-auto">
          <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-2xl">
              <span class="font-label text-primary uppercase tracking-[0.4em] text-[10px] mb-4 block">Signature
                Rituals</span>
              <h2 class="font-headline text-5xl text-on-surface">Curated Restorative Journeys</h2>
            </div>
            <button
              class="text-tertiary font-label text-xs uppercase tracking-widest border-b-2 border-tertiary pb-1 hover:text-primary hover:border-primary transition-all duration-300">
              Download Spa Menu
            </button>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div v-if="loading" class="md:col-span-3 text-center py-12 text-on-surface-variant">Chargement...</div>
            <div v-else-if="types.length === 0" class="md:col-span-3 text-center py-12 text-on-surface-variant">Aucun
              service disponible</div>
            <div v-for="type in types" :key="type.id" class="group">
              <div class="space-y-4">
                <div class="flex justify-between items-center">
                  <h3 class="font-headline text-2xl text-on-surface group-hover:text-primary transition-colors">{{
                    type.name }}</h3>
                  <span class="text-tertiary font-headline italic">{{ type.prix }} DH</span>
                </div>
                <div class="flex items-center gap-4">
                  <span :class="type.status ? 'text-green-600' : 'text-red-500'"
                    class="text-[10px] font-label uppercase tracking-widest flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">{{ type.status ? 'check_circle' : 'cancel' }}</span>
                    {{ type.status ? 'Disponible' : 'Indisponible' }}
                  </span>
                </div>
                <p class="font-body text-on-surface-variant text-sm leading-relaxed">{{ type.description }}</p>
                <button @click="openBook(type)" :disabled="!type.status"
                  class="w-full py-4 border border-outline-variant rounded-full font-label text-[10px] uppercase tracking-widest hover:bg-secondary hover:text-on-secondary transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed">
                  Book Session
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Amenity Bento Grid -->
      <section class="py-32 px-12 max-w-screen-2xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-8 h-auto md:h-[800px]">
          <div class="md:col-span-2 md:row-span-2 bg-surface-container-high relative overflow-hidden group">
            <img
              class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000"
              data-alt="Indoor infinity pool with Moroccan tile arches reflecting in the turquoise water"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuAsoLbNzDFixZiDvm8O4GbhnKmRaPbL3pLnLyUuvX37C_c08bt4Ves3epXFybHA1K2mMhsRmoqKTptHRTunNY_9AJ8sMrmqn_NGAG78bJceGZ1_eVo-fd2ZywS5u__9wGcuH8TtsCOAzmYb3k07jQ5h9A9BP0SmEBXk56XYRvkV8LYGF2DfifCi7tkX70ItE3sP8SS_2VuFBWZRpga1IeQeKpbil_uo6-lcSDSf2DnbYY9HObhKT5awkFvj0imYuSsv822-8YFhaH3i" />
            <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 to-transparent"></div>
            <div class="absolute bottom-10 left-10">
              <h4 class="font-headline text-3xl text-white mb-2">The Emerald Pool</h4>
              <p class="text-white/80 font-body text-sm uppercase tracking-widest">Indoor Vitality Oasis</p>
            </div>
          </div>
          <div
            class="md:col-span-2 bg-secondary text-on-secondary p-12 flex flex-col justify-center relative overflow-hidden">
            <div class="z-10">
              <span class="material-symbols-outlined text-4xl mb-6 text-secondary-fixed">self_improvement</span>
              <h4 class="font-headline text-3xl mb-4">Rooftop Yoga Pavilion</h4>
              <p class="font-body text-on-secondary/80 leading-relaxed mb-6">Greeting the dawn with guided Vinyasa
                overlooking the Medina and the distant peaks of the High Atlas.</p>
              <a class="inline-block text-[10px] font-label uppercase tracking-widest border-b border-on-secondary/40 pb-1"
                href="#">View Schedule</a>
            </div>
            <div class="absolute -right-10 -bottom-10 opacity-10">
              <span class="material-symbols-outlined text-[200px]">filter_vintage</span>
            </div>
          </div>
          <div
            class="md:col-span-1 bg-surface-container p-8 flex flex-col justify-end border border-outline-variant/10">
            <h4 class="font-headline text-xl text-primary mb-2">Steam &amp; Mist</h4>
            <p class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest">Herbal Infusion Sauna
            </p>
          </div>
          <div class="md:col-span-1 bg-tertiary-container text-on-tertiary-container p-8 flex flex-col justify-end">
            <h4 class="font-headline text-xl mb-2">The Zest Bar</h4>
            <p class="text-[10px] font-label text-on-tertiary-container/80 uppercase tracking-widest">Fresh Cold-Pressed
              Elixirs</p>
          </div>
        </div>
      </section>
      <!-- Newsletter / Booking Teaser -->
      <section class="py-32 bg-surface">
        <div class="max-w-4xl mx-auto text-center px-6">
          <span class="material-symbols-outlined text-primary text-5xl mb-8">mail</span>
          <h2 class="font-headline text-4xl mb-6 text-on-surface">Join the Royal Circle</h2>
          <p class="font-body text-on-surface-variant text-lg mb-12">Receive exclusive wellness insights and seasonal
            ritual offers from our sanctuary.</p>
          <div class="flex flex-col md:flex-row gap-4">
            <input
              class="flex-grow bg-surface-container-low border-none border-b-2 border-outline-variant focus:ring-0 focus:border-primary px-6 py-4 font-body text-sm rounded-none"
              placeholder="Your Email Address" type="email" />
            <button
              class="bg-primary text-on-primary px-12 py-4 rounded-full font-label text-[10px] uppercase tracking-widest hover:bg-primary-container transition-all">Subscribe</button>
          </div>
        </div>
      </section>
    </main>
    <!-- Footer -->
    <footer class="bg-[#fcf9ef] dark:bg-stone-950 border-t border-[#755717]/10">
      <div class="flex flex-col md:flex-row justify-between items-center px-12 py-16 w-full max-w-screen-2xl mx-auto">
        <div class="mb-8 md:mb-0">
          <span class="font-['Noto_Serif'] text-lg text-[#755717]">Kasbah Royale</span>
          <p class="text-stone-500 font-['Manrope'] text-xs tracking-[0.1em] uppercase mt-2">© 2024 Kasbah Royale. A
            Legacy of Moroccan Splendor.</p>
        </div>
        <div class="flex gap-12">
          <a class="text-stone-500 font-['Manrope'] text-xs tracking-[0.1em] uppercase hover:text-[#755717] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100"
            href="#">Heritage</a>
          <a class="text-stone-500 font-['Manrope'] text-xs tracking-[0.1em] uppercase hover:text-[#755717] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100"
            href="#">Contact Us</a>
          <a class="text-stone-500 font-['Manrope'] text-xs tracking-[0.1em] uppercase hover:text-[#755717] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100"
            href="#">Press</a>
          <a class="text-stone-500 font-['Manrope'] text-xs tracking-[0.1em] uppercase hover:text-[#755717] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100"
            href="#">Privacy Policy</a>
        </div>
      </div>
    </footer>

    <!-- Modal Réservation SPA -->
    <div v-if="showModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
      <div class="bg-[#fcf9ef] rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-8 py-6 border-b border-[#9a401f]/10 flex items-center justify-between">
          <div>
            <h3 class="font-headline text-2xl text-[#9a401f]">Réserver une Session</h3>
            <p class="text-sm text-[#755717]/70 mt-0.5 font-light">{{ selectedType?.name }} — {{ selectedType?.prix }}
              DH</p>
          </div>
          <button @click="showModal = false"
            class="p-2 text-[#9a401f]/50 hover:text-[#9a401f] hover:bg-[#9a401f]/10 rounded-full transition-all">
            <span class="material-symbols-outlined">close</span>
          </button>
        </div>
        <form @submit="submitSpa" class="px-8 py-6 space-y-5">
          <div v-if="spaSuccess"
            class="p-3 bg-green-50 text-green-700 rounded-xl text-sm font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-base">check_circle</span>{{ spaSuccess }}
          </div>
          <div v-if="spaError"
            class="p-3 bg-red-50 text-red-600 rounded-xl text-sm font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-base">error</span>{{ spaError }}
          </div>
          <div class="space-y-1.5">
            <label class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Date de début</label>
            <input v-model="spaForm.date_debut" type="date" required
              class="w-full bg-transparent border-0 border-b border-[#9a401f]/20 py-3 px-0 text-[#9a401f] focus:ring-0 focus:border-[#9a401f] transition-all" />
          </div>
          <div class="space-y-1.5">
            <label class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Date de fin</label>
            <input v-model="spaForm.date_fin" type="date" required
              class="w-full bg-transparent border-0 border-b border-[#9a401f]/20 py-3 px-0 text-[#9a401f] focus:ring-0 focus:border-[#9a401f] transition-all" />
          </div>
          <div class="pt-2 p-4 bg-[#9a401f]/5 rounded-2xl flex justify-between items-center">
            <span class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Prix</span>
            <span class="font-headline text-xl text-[#9a401f]">{{ selectedType?.prix }} DH</span>
          </div>
          <div class="flex gap-3 pt-2">
            <button type="button" @click="showModal = false"
              class="flex-1 py-3 rounded-full border border-[#9a401f]/20 font-label text-[10px] uppercase tracking-widest text-[#9a401f] hover:bg-[#9a401f]/5 transition-all">Annuler</button>
            <button type="submit" :disabled="spaLoading"
              class="flex-1 py-3 rounded-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-label text-[10px] uppercase tracking-widest hover:scale-[1.02] transition-all">
              {{ spaLoading ? 'En cours...' : 'Confirmer' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>