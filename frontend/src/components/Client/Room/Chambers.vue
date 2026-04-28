<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const roomList = ref([]);
const error = ref(null);
const loading = ref(false);

// reservation modal
const showModal = ref(false);
const selectedRoom = ref(null);
const resForm = ref({ date_enter: '', date_sortie: '' });
const resError = ref('');
const resSuccess = ref('');
const resLoading = ref(false);

const me = reactive(JSON.parse(localStorage.getItem('user') || 'null'));

const chambers = async () => {
    try {
        error.value = null;
        loading.value = true;
        // refresh user from API to ensure we have the correct id
        const token = localStorage.getItem('token');
        if (token) {
            const meRes = await fetch('http://localhost:8080/api/auth/me', {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            if (meRes.ok) {
                const meJson = await meRes.json();
                me.value = meJson.user;
                localStorage.setItem('user', JSON.stringify(meJson.user));
            }
        }
        const result = await fetch('http://localhost:8080/api/chambers');
        const json = await result.json();
        if (!result.ok) throw new Error(json.message || 'Failed to fetch rooms');
        roomList.value = json.data.data ?? json.data;
    } catch (e) {
        error.value = e.message;
    } finally {
        loading.value = false;
    }
};

function openReservation(room) {
    selectedRoom.value = room;
    resForm.value = { date_enter: '', date_sortie: '' };
    resError.value = '';
    resSuccess.value = '';
    showModal.value = true;
}

async function submitReservation(e) {
    e.preventDefault();
    resError.value = '';
    resSuccess.value = '';
    resLoading.value = true;

 
    

    const prix = selectedRoom.value.chamber_type?.prix ?? 0;
    const res = await fetch('http://localhost:8080/api/reservations', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': `Bearer ${localStorage.getItem('token')}` },
        body: JSON.stringify({
            date_enter: resForm.value.date_enter,
            date_sortie: resForm.value.date_sortie,
            prix: prix,
            chamber_id: selectedRoom.value.id,
            user_id: me?.id ?? 1
        })
    });
    const json = await res.json();
    resLoading.value = false;
    if (!res.ok) { resError.value = json.message ?? 'Erreur lors de la réservation'; return; }
    resSuccess.value = 'Réservation effectuée avec succès !';
    setTimeout(() => { showModal.value = false; }, 1500);
}

onMounted(chambers);
</script>

<template>
  <div class="bg-surface text-on-surface font-body selection:bg-primary-fixed-dim">
        <!-- TopAppBar -->
    <nav
      class="fixed top-0 w-full z-50 flex justify-between items-center px-12 py-6 max-w-screen-2xl mx-auto bg-[#fcf9ef]/80 backdrop-blur-md shadow-[0_20px_40px_rgba(28,28,22,0.06)]">
      <div class="font-serif text-2xl uppercase tracking-[0.2em] text-[#9a401f]"><router-link to="/">Kasbah Royale</router-link></div>
      <div class="hidden md:flex items-center gap-8">
        <router-link to="/">
          <a class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300" >Home</a>
        </router-link>
          <router-link to="/room">
       <a class="font-noto-serif text-lg tracking-tight text-[#755717] border-b-2 border-[#755717] pb-1 font-semibold"
         >Room</a>
        </router-link>
        <router-link to="/SPA">
        <a class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300" >SPA</a>
        </router-link>
        <router-link to="/menu">
        <a class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Menu</a>
        </router-link>
      </div>
      <div class="flex items-center gap-6">
        <button
          class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-sm uppercase tracking-widest hover:scale-105 transition-all duration-500 ease-in-out active:opacity-80 active:scale-95">
          <div v-if="!auth">
              <router-link to="/login">Login</router-link>
          </div>
          <div v-else>
            <router-link to="/client/profile">
                 <span class="material-symbols-outlined">person</span>
            </router-link>
          </div>
                 
        </button>
      </div>
    </nav>
    
    <main class="zellige-pattern min-h-screen">
      <!-- Hero Section -->
      <section class="relative pt-24 pb-12 px-12 max-w-screen-2xl mx-auto overflow-hidden">
        <div class="grid grid-cols-12 gap-8 items-end">
          <div class="col-span-12 lg:col-span-7">
            <span class="font-label text-xs uppercase tracking-[0.3em] text-tertiary mb-4 block">Private
              Sanctuaries</span>
            <h1 class="font-headline text-7xl lg:text-8xl font-light tracking-tighter text-on-surface leading-tight">
              Suites <span class="italic font-light">&amp;</span> Riads
            </h1>
            <p class="mt-8 text-on-surface-variant max-w-xl text-lg font-light leading-relaxed">
              Each residence is a curated dialogue between Moroccan heritage and contemporary serenity. Discover a world
              of textured plaster, carved cedar, and the gentle murmur of falling water.
            </p>
          </div>
          <div class="col-span-12 lg:col-span-5 hidden lg:block">
            <div class="h-[1px] bg-outline-variant/20 w-full mb-8"></div>
            <div class="flex gap-12">
              <div>
                <span class="block font-headline text-3xl text-primary italic">12</span>
                <span class="font-label text-[10px] uppercase tracking-widest opacity-60">Signature Suites</span>
              </div>
              <div>
                <span class="block font-headline text-3xl text-primary italic">03</span>
                <span class="font-label text-[10px] uppercase tracking-widest opacity-60">Private Riads</span>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Gallery Grid -->
      <section class="px-12 py-20 max-w-screen-2xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16">
          <!-- Room Card 1: The Amber Suite -->
          <div v-if="roomList.length > 0">
            <div v-for="room in roomList" :key="room.id" class="group flex flex-col">
              <div
                class="relative overflow-hidden arch-mask h-[500px] bg-surface-container-low transition-all duration-500 hover:shadow-2xl">
                <img alt="Luxury Moroccan Suite with amber lighting"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                  :src="`http://localhost:8080/storage/${room.image}`" />
                <div class="absolute inset-0 bg-gradient-to-t from-background/40 to-transparent"></div>
              </div>
              <div class="mt-8 space-y-4">
                <div class="flex justify-between items-end">
                  <h3 class="font-headline text-3xl font-light">{{ room.name }}</h3>
                  <span class="font-label text-[10px] uppercase tracking-widest text-primary font-bold">From {{ room.chamber_type.prix }}</span>
                </div>
                <p class="text-on-surface-variant font-light text-sm leading-relaxed">
                 {{ room.description }}
                </p>
                <div class="flex gap-4 pt-2">
                  <div class="flex items-center gap-2 text-on-surface-variant">
                    <span class="font-label text-[10px] uppercase tracking-widest">{{ room.is_available ? 'Available' : 'Not Available' }}</span>
                  </div>
                </div>
                <button @click="openReservation(room)"
                  class="w-full mt-4 py-4 rounded-full border border-outline-variant/30 font-label text-[10px] uppercase tracking-[0.2em] hover:bg-primary hover:text-on-primary hover:border-transparent transition-all duration-300">
                  Réserver
                </button>
              </div>
            </div>
          </div>
          <p v-else class="flex justify-center items-center h-96"> no chamber found</p>

        </div>
        
      </section>
        <!-- Call to Action Card -->
        <div class="col-span-1 md:col-span-2 lg:col-span-2 mt-12 bg-surface-container-high rounded-3xl p-12 flex flex-col md:flex-row items-center gap-12 overflow-hidden relative">
          <div class="flex-1 space-y-6 relative z-10">
            <h2 class="font-headline text-4xl font-light leading-tight text-on-surface">Experience Unparalleled
              <br /><span class="italic text-primary">Sensory Luxury</span>
            </h2>
            <p class="text-on-surface-variant font-light leading-relaxed max-w-md">
              Not sure which sanctuary suits your journey? Allow our curators to help you select the perfect space for
              your stay in the heart of the Medina.
            </p>
            <div class="flex gap-4">
              <button
              class="bg-primary text-on-primary px-8 py-3 rounded-full font-label text-xs uppercase tracking-widest hover:bg-primary-container transition-all">Curate
              My Stay</button>
                <button
                  class="text-tertiary font-label text-xs uppercase tracking-widest border-b border-tertiary/30 pb-1 hover:border-tertiary transition-all">Talk
                  to a Specialist</button>
              </div>
            </div>
            <div class="flex-1 relative h-64 md:h-80 w-full group overflow-hidden rounded-2xl">
              <img alt="Guest experience at the Riad"
                class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700"
                data-alt="ethereal portrait of a person in white linen walking through a sun-drenched corridor of a Moroccan palace with dappled light shadows"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBP2lvVT6WgLNSJjTir6wp--1JFiqWz0y4Wfqva2Ki-B7Dd51voNMBGq9bU6-pImxFl3gRY9v_0UBAO8LHmgfLz-hWAqYWp-O_1DtugUUjGPawQpeuGx4sh8hT3x4KH_l1yFXD0RaMGKafLs4k2oCa1gH6_XMIIZ8XHOxTNQS8JVDavvgIkU5crNbbTDieYgAVE-TOIGgkiQZhn4ZVt6qvKtIo15W3Q8fLIf2UVnfIAyzcEx3t2s93Lz1ioDbVlqli2IP0lhyvh6gsv" />
            </div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
          </div>

        </main>
        <!-- Footer -->
    <footer class="bg-[#fcf9ef] dark:bg-stone-950 w-full border-t border-[#9a401f]/10 mt-20">
      <div class="flex flex-col items-center justify-center py-16 gap-8 w-full">
        <div class="font-['Noto_Serif'] text-lg text-[#755717]">The Sensory Riad</div>
        <div class="flex flex-wrap justify-center gap-10">
          <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
            href="#">The Estate</a>
          <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
            href="#">Curated Experiences</a>
          <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
            href="#">Private Events</a>
          <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
            href="#">Contact</a>
          <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
            href="#">Privacy</a>
        </div>
        <div class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em]">© 2024 The
          Sensory Riad. A sanctuary of the soul.</div>
      </div>
    </footer>
  </div>

  <!-- Modal Réservation -->
  <div v-if="showModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
    <div class="bg-[#fcf9ef] rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
      <div class="px-8 py-6 border-b border-[#9a401f]/10 flex items-center justify-between">
        <div>
          <h3 class="font-headline text-2xl text-[#9a401f]">Réserver</h3>
          <p class="text-sm text-[#755717]/70 mt-0.5 font-light">{{ selectedRoom?.name }}</p>
        </div>
        <button @click="showModal = false" class="p-2 text-[#9a401f]/50 hover:text-[#9a401f] hover:bg-[#9a401f]/10 rounded-full transition-all">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <form @submit.prevent="submitReservation" class="px-8 py-6 space-y-5">
        <div v-if="resSuccess" class="p-3 bg-green-50 text-green-700 rounded-xl text-sm font-semibold flex items-center gap-2">
          <span class="material-symbols-outlined text-base">check_circle</span>{{ resSuccess }}
        </div>
        <div v-if="resError" class="p-3 bg-red-50 text-red-600 rounded-xl text-sm font-semibold flex items-center gap-2">
          <span class="material-symbols-outlined text-base">error</span>{{ resError }}
        </div>
        <div class="space-y-1.5">
          <label class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Date d'arrivée</label>
          <input v-model="resForm.date_enter" type="date" required
            class="w-full bg-transparent border-0 border-b border-[#9a401f]/20 py-3 px-0 text-[#9a401f] focus:ring-0 focus:border-[#9a401f] transition-all" />
        </div>
        <div class="space-y-1.5">
          <label class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Date de départ</label>
          <input v-model="resForm.date_sortie" type="date" required
            class="w-full bg-transparent border-0 border-b border-[#9a401f]/20 py-3 px-0 text-[#9a401f] focus:ring-0 focus:border-[#9a401f] transition-all" />
        </div>
        <div class="pt-2 p-4 bg-[#9a401f]/5 rounded-2xl">
          <div class="flex justify-between items-center">
            <span class="font-label text-[10px] uppercase tracking-widest text-[#755717]">Prix / nuit</span>
            <span class="font-headline text-xl text-[#9a401f]">{{ selectedRoom?.chamber_type?.prix ?? '—' }} DH</span>
          </div>
        </div>
        <div class="flex gap-3 pt-2">
          <button type="button" @click="showModal = false"
            class="flex-1 py-3 rounded-full border border-[#9a401f]/20 font-label text-[10px] uppercase tracking-widest text-[#9a401f] hover:bg-[#9a401f]/5 transition-all">Annuler</button>
          <button type="submit" :disabled="resLoading"
            class="flex-1 py-3 rounded-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-label text-[10px] uppercase tracking-widest hover:scale-[1.02] transition-all">
            {{ resLoading ? 'En cours...' : 'Confirmer' }}
          </button>
        </div>
      </form>
    </div>
  </div>

</template>