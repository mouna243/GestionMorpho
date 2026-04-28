<script setup>
import { useAuth } from '../../composables/useAuth.js';
const { isLoggedIn, user, logout } = useAuth();
</script>

<template>
  <div class="bg-surface text-on-surface font-body overflow-x-hidden">
    <!-- TopAppBar -->
    <nav
      class="fixed top-0 w-full z-50 flex justify-between items-center px-12 py-6 max-w-screen-2xl mx-auto bg-[#fcf9ef]/80 backdrop-blur-md shadow-[0_20px_40px_rgba(28,28,22,0.06)]">
      <div class="font-serif text-2xl uppercase tracking-[0.2em] text-[#9a401f]"><router-link to="/">Kasbah
          Royale</router-link></div>
      <div class="hidden md:flex items-center gap-8">
        <router-link to="/">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#755717] border-b-2 border-[#755717] pb-1 font-semibold">Home</a>
        </router-link>
        <router-link to="/room">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Room</a>

        </router-link>
        <router-link to="/SPA">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">SPA</a>
        </router-link>
        <router-link to="/menu">
          <a
            class="font-noto-serif text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300">Menu</a>
        </router-link>
      </div>
      <div class="flex items-center gap-6">
        <template v-if="isLoggedIn">
          <router-link to="/client/profile"
            class="font-label text-sm uppercase tracking-widest text-[#9a401f] hover:text-[#755717] transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-xl">account_circle</span>
            {{ user?.name?.split(' ')[0] }}
          </router-link>
          <button @click="logout"
            class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-sm uppercase tracking-widest hover:scale-105 transition-all duration-300">
            Logout
          </button>
        </template>
        <template v-else>
          <router-link to="/login"
            class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-sm uppercase tracking-widest hover:scale-105 transition-all duration-300">
            Login
          </router-link>
        </template>
      </div>
    </nav>
    <main>
      <!-- Minimalist Hero -->
      <section class="relative h-screen flex items-center justify-center pt-24">
        <div class="absolute inset-0 z-0 overflow-hidden">
          <img alt="Luxury Riad Interior" class="w-full h-full object-cover opacity-90 scale-105"
            data-alt="wide shot of a sun-drenched traditional marrakech riad courtyard with terracotta walls, emerald pool, and palm trees in soft focus"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDEX3yepeX4OdfrmZrX32ffl77rfDHgEXkU3GdfKPB3xbNfy3L8jIeJwx8eDQBetG0ZHASRuiAPMwVLt4-WLohzIfCVmwk1TuQcwykWZGtqI8miaLzeNDQ-frHSLujWFZc7EuPGrP0lhscEROGEi3Dj1sNZ4XVGbQ4us7LF4GnvRTAEt4oCsgAyjS_tL9XDUz2ryLQLUAFO7lhGluzaT3iapIzSQiJuq7kQq61E_mXIEI7t1tXRr6LzKf8vshWL56lNTe4lQQ-81Tji" />
          <div class="absolute inset-0 bg-gradient-to-b from-surface/20 via-transparent to-surface"></div>
        </div>
        <div class="relative z-10 text-center max-w-4xl px-6">
          <span class="font-label text-xs uppercase tracking-[0.4em] text-tertiary mb-6 block">Est. 1894 •
            Marrakech</span>
          <h1 class="font-headline text-7xl md:text-9xl text-on-surface leading-tight mb-8">Poetry in <span
              class="text-primary italic">Plaster</span></h1>
          <p class="font-noto-serif text-xl text-on-surface-variant max-w-xl mx-auto leading-relaxed">
            A sanctuary of silence where the golden hour never ends. Discover the art of Moroccan slow-living.
          </p>
        </div>
        <div class="absolute bottom-12 left-12 flex flex-col gap-2">
          <div class="w-12 h-[1px] bg-primary"></div>
          <span class="font-label text-[10px] uppercase tracking-widest text-primary">Scroll to explore</span>
        </div>
      </section>
      <!-- The Collection (Suites) Grid Layout -->
      <section class="py-32 px-12 zellige-pattern">
        <div class="max-w-7xl mx-auto">
          <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-md">
              <h2 class="font-headline text-5xl mb-6">The Collection</h2>
              <p class="text-on-surface-variant leading-relaxed">Each suite is a curated narrative of silk, cedar, and
                stone. Private alcoves designed for the modern nomad.</p>
            </div>
            <router-link to="/room">
            <a class="text-tertiary font-label text-sm uppercase tracking-widest border-b border-tertiary/30 pb-2 hover:border-tertiary transition-colors"
             >View All Suites</a>
             </router-link>
          </div>
         
        </div>
      </section>
      <!-- Experiences with Large Typography -->
      <section class="bg-secondary-fixed py-32 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-12 relative z-10">
          <div class="flex flex-col md:flex-row items-center gap-16">
            <div class="w-full md:w-1/2">
              <h2
                class="font-headline text-8xl md:text-[10rem] text-secondary leading-[0.8] tracking-tighter mb-12 select-none opacity-20">
                SOUL</h2>
              <div class="pl-4 md:pl-12">
                <span
                  class="font-label text-xs uppercase tracking-[0.5em] text-on-secondary-fixed-variant mb-6 block">Beyond
                  the Walls</span>
                <h3 class="font-headline text-5xl text-on-secondary-fixed mb-8">Curated Moments of <span
                    class="italic text-primary">Wonder</span></h3>
                <p class="text-on-secondary-fixed-variant text-lg leading-relaxed mb-10 max-w-sm">
                  From secret desert dinners under the stars to private perfume making in the Medina. We design
                  memories.
                </p>
                <button
                  class="bg-secondary text-on-secondary px-10 py-4 rounded-full font-label text-sm uppercase tracking-widest hover:bg-on-secondary-fixed transition-colors">Explore
                  Experiences</button>
              </div>
            </div>
            <div class="w-full md:w-1/2 relative">
              <div
                class="arch-mask overflow-hidden aspect-[3/4] shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-1000">
                <img alt="Experience Image" class="w-full h-full object-cover"
                  data-alt="vibrant marrakech market spices in conical heaps with warm sunlight and bustling medina atmosphere background"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSDP9bkQLI33ThnIjEGMkqw_C8yPKiRDoBIXGkEnKEBdmAMKbKugxGUnyY1IetmEX_zXWrzcmgm_fYDlpmdXDO1qON9l9-MITqjjlLz29euoFY6_u6Nxu2IPqZTJefsxZhCBJ4wUhVnyVvSO4_bjBKKdDrtaGqzPsNcuSS2K_gfkKbL5EFUaxI8GTO04O6YigUSnwZ0TRfnmGT1anaV0bjLMCmS5zOa5XSHS2UAG7oV7Wy819EwPoma-bqg3vPF7mR6MouXt3DT7_Z" />
              </div>
              <div class="absolute -bottom-8 -left-8 bg-tertiary-fixed p-8 rounded-xl shadow-lg max-w-[240px]">
                <p class="font-noto-serif italic text-on-tertiary-fixed-variant">"An experience that touches the spirit
                  as much as the senses."</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Decorative Large Text Background -->
        <div
          class="absolute -right-20 top-1/2 -translate-y-1/2 font-headline text-[20rem] text-secondary/5 pointer-events-none select-none">
          RIAD</div>
      </section>
      <!-- A Sanctuary Wellness Section -->
      <section class="py-32 px-12 bg-surface">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row-reverse items-center gap-20">
          <div class="w-full md:w-1/2 space-y-8">
            <h2 class="font-headline text-6xl">A Sanctuary <br /><span class="text-primary">of Restoration</span></h2>
            <div class="w-20 h-1 bg-tertiary"></div>
            <p class="text-xl font-noto-serif text-on-surface-variant leading-relaxed">
              Our subterranean spa is carved from local marble, offering a modern interpretation of the traditional
              Hammam. Cold-pressed oils and orange blossom rituals await.
            </p>
            <div class="grid grid-cols-2 gap-8 pt-6">
              <div>
                <span class="font-headline text-3xl text-primary">01</span>
                <h4 class="font-label font-bold text-xs uppercase tracking-widest mt-2">Hammam Rituals</h4>
              </div>
              <div>
                <span class="font-headline text-3xl text-primary">02</span>
                <h4 class="font-label font-bold text-xs uppercase tracking-widest mt-2">Sensory Massage</h4>
              </div>
              <div>
                <span class="font-headline text-3xl text-primary">03</span>
                <h4 class="font-label font-bold text-xs uppercase tracking-widest mt-2">Meditation Courtyard</h4>
              </div>
              <div>
                <span class="font-headline text-3xl text-primary">04</span>
                <h4 class="font-label font-bold text-xs uppercase tracking-widest mt-2">Herbal Solarium</h4>
              </div>
            </div>
          </div>
          <div class="w-full md:w-1/2 flex gap-4">
            <div class="w-1/2 space-y-4 pt-12">
              <img alt="Wellness Detail 1" class="w-full rounded-2xl shadow-md"
                data-alt="close-up of essential oil bottle and white jasmine flowers on a marble surface with soft atmospheric lighting"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCXC9oaqdbjaH3cJMEB0ccW6txI6NBO7PIFtx0DvgN7cnO5tzYd5BEIXBVu-vVCAAevqixuD1YBuV8vW7WJEbqv3I5jmOY660kIDpsMiUDXccOCGBx6cOUhbdvLUwW7UntJiO4QWykcwWNhlUW7klMRlo0mNIhQOP9HDs5_ZA8-3DGW2K0sW0saNnCjblLchz0LEe3aX7fFpIedvEJ8-TYwABtMezkKF6YuX8By0Ofjyluha0DUumnp0hSY7vFw-_wU-wR0vYe-vGIo" />
              <img alt="Wellness Detail 2" class="w-full arch-mask shadow-md"
                data-alt="steam rising in a dimly lit traditional marble hammam with candle flickers reflecting on wet stone surfaces"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAk7Ax51iih085lnjtoAbdLRDpTdIZAfDzRjHli9st--n_9BfhqXMcYHGnSgT3C6nC1stQdlKJiIxIojMpvG_BNL-Z_Yp4E6bN9qgms8m4dlgcb68lOtInyQ5mKt0zm5Zq9vnjWa8CflwfwdBDQQqaM6VRdLIA-bYoepfPPDKOfu5RCu8CbiQ4F4wvlhJRBlm43RKywtvV57YeIwgdZrCEb84fSAyQ8_PEJNDtHpLymyeEVHbxMpqCJBZHMaF_uLiZOWEXnrNtOti3K" />
            </div>
            <div class="w-1/2">
              <img alt="Wellness Detail 3" class="w-full h-[600px] object-cover rounded-2xl shadow-xl"
                data-alt="tranquil pool at dusk with floating flower petals and warm surrounding lantern light"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCq0c0fcOHLWeFWl5uCPeYJBzRxsBS3OP_5k_yYzxdsYOD1EgLa5YPPLK-bmgltT12JGFOnasJbhrvJkr8keM6BQv7kNbiR4PW1dbVAsfSj35JLFoEOstGLNM3tmKeIQYuXCNjmUY73CaGCPOpQ3fT682O9uzkeVXmTFGV8Vv0dpCBF81iR0SxX3O0kNfm3CBUzKLrgwh6vepSBqagC5lHRdMT7Nfh5k0jZCXhYJ_JtSqoXxpI4wP2omlSoDIQAPsFbQYeXpXdfjPhh" />
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- Footer -->
    <footer
      class="w-full py-20 px-12 flex flex-col md:flex-row justify-between items-start gap-8 bg-[#436182] rounded-t-[4rem] mt-20 text-[#fcf9ef]">
      <div class="max-w-md">
        <div class="font-serif text-3xl text-[#755717] mb-4">Kasbah Royale</div>
        <p class="font-manrope text-sm uppercase tracking-widest opacity-70 leading-relaxed max-w-xs">
          © 2024 Kasbah Royale. A sensory journey into the heart of Marrakech.
        </p>
      </div>
      <div class="flex flex-col gap-4">
        <h5 class="font-label text-xs uppercase tracking-[0.3em] text-tertiary-fixed mb-2">Explore</h5>
        <a class="font-manrope text-sm uppercase tracking-widest text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity hover:translate-x-1 transition-transform duration-300"
          href="#">Private Events</a>
        <a class="font-manrope text-sm uppercase tracking-widest text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity hover:translate-x-1 transition-transform duration-300"
          href="#">Sustainability</a>
        <a class="font-manrope text-sm uppercase tracking-widest text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity hover:translate-x-1 transition-transform duration-300"
          href="#">Terms of Service</a>
        <a class="font-manrope text-sm uppercase tracking-widest text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity hover:translate-x-1 transition-transform duration-300"
          href="#">Press Kit</a>
        <a class="font-manrope text-sm uppercase tracking-widest text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity hover:translate-x-1 transition-transform duration-300"
          href="#">Contact Us</a>
      </div>
      <div class="max-w-xs">
        <h5 class="font-label text-xs uppercase tracking-[0.3em] text-tertiary-fixed mb-4">Newsletter</h5>
        <div class="flex border-b border-[#fcf9ef]/30 pb-2">
          <input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-[#fcf9ef]/40"
            placeholder="Your Email Address" type="email" />
          <button class="material-symbols-outlined text-tertiary">arrow_forward</button>
        </div>
        <p class="text-[10px] mt-4 opacity-50 uppercase tracking-widest">Stay informed on seasonal availability and
          private retreats.</p>
      </div>
    </footer>
  </div>


</template>
