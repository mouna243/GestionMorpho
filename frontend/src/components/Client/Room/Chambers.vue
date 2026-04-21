<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const roomList = ref([])
const error = ref(null)
const loading = ref(false)
const chambers = async () => {
  try {
    error.value = null
    loading.value = true
    const result = await fetch('http://localhost:8080/api/chambers')
    const data = await result.json()


    if (!result.ok) {
      throw new Error(data.message)
      console.log(data)
    }

    roomList.value = data
    console.log(roomList.value)
  }catch (e){
    error.value = e.message
    console.log(error.value)
  }finally{
    loading.value = false
  }
}
</script>

<template>
  <div class="bg-surface text-on-surface font-body selection:bg-primary-fixed-dim">
    <!-- TopAppBar -->
    <header
      class="bg-[#fcf9ef]/80 dark:bg-stone-900/80 backdrop-blur-md text-[#9a401f] dark:text-[#c05c39] docked full-width top-0 sticky z-50 shadow-[0_20px_40px_rgba(28,28,22,0.06)]">
      <nav class="flex justify-between items-center w-full px-12 py-6 max-w-screen-2xl mx-auto">
        <div class="text-2xl font-['Noto_Serif'] italic text-[#9a401f] dark:text-[#c05c39]">The Sensory Riad</div>
        <div class="hidden md:flex items-center gap-10">
          <a class="text-[#9a401f] dark:text-[#c05c39] border-b-2 border-[#755717] pb-1 font-['Noto_Serif'] font-light tracking-tight hover:text-[#755717] transition-all duration-300 ease-in-out"
            href="#">Suites</a>
          <a class="text-[#436182] dark:text-stone-400 font-['Manrope'] uppercase tracking-widest text-[10px] hover:text-[#755717] transition-all duration-300 ease-in-out"
            href="#">Dining</a>
          <a class="text-[#436182] dark:text-stone-400 font-['Manrope'] uppercase tracking-widest text-[10px] hover:text-[#755717] transition-all duration-300 ease-in-out"
            href="#">Wellness</a>
          <a class="text-[#436182] dark:text-stone-400 font-['Manrope'] uppercase tracking-widest text-[10px] hover:text-[#755717] transition-all duration-300 ease-in-out"
            href="#">Reservations</a>
        </div>
        <div class="flex items-center gap-6">
          <button
            class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label text-sm uppercase tracking-widest hover:scale-105 transition-all duration-300">Book
            Now</button>
          <span class="material-symbols-outlined cursor-pointer text-2xl hover:text-tertiary transition-colors"
            data-icon="account_circle">account_circle</span>
        </div>
      </nav>
    </header>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
          <!-- Room Card 1: The Amber Suite -->
          <div class="group flex flex-col">
            <div
              class="relative overflow-hidden arch-mask h-[500px] bg-surface-container-low transition-all duration-500 hover:shadow-2xl">
              <img alt="Luxury Moroccan Suite with amber lighting"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                data-alt="luxury Moroccan suite interior with warm amber lighting, ornate carved wood details, and plush terracotta textiles at dusk"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAM69Vnhq0dQSgDqnmbgdLBlHkSAv0Ug9xZWlGgJmse6gHXyiqntGYlI26pGXXgCl1ZDvzImJVo2yuwJNmML_PxngjLSyZZv3xh4_K47ejyyKv7NIIHANICEP5ntofpxtKqkPcNgowzfbMxaEl9Pgl730lr7NAe1lyKsAX6gWTkuzPQCRu7ub84FAIWvUzfVpf-lJCCTsHcV56vfiLNOxidioyF_7pjsu3xTPCxiC5niwGxM3Lu_XKctht6wDn01NkPJv9aH1pSr6kH" />
              <div class="absolute inset-0 bg-gradient-to-t from-background/40 to-transparent"></div>
            </div>
            <div class="mt-8 space-y-4">
              <div class="flex justify-between items-end">
                <h3 class="font-headline text-3xl font-light">The Amber Suite</h3>
                <span class="font-label text-[10px] uppercase tracking-widest text-primary font-bold">From $650</span>
              </div>
              <p class="text-on-surface-variant font-light text-sm leading-relaxed">
                A sun-drenched sanctuary featuring warm cedar accents and custom-crafted zellige tilework that captures
                the golden hour.
              </p>
              <div class="flex gap-4 pt-2">
                <div class="flex items-center gap-2 text-on-surface-variant">
                  <span class="material-symbols-outlined text-lg" data-icon="deck">deck</span>
                  <span class="font-label text-[10px] uppercase tracking-widest">Courtyard View</span>
                </div>
                <div class="flex items-center gap-2 text-on-surface-variant">
                  <span class="material-symbols-outlined text-lg" data-icon="king_bed">king_bed</span>
                  <span class="font-label text-[10px] uppercase tracking-widest">King Bed</span>
                </div>
              </div>
              <button
                class="w-full mt-4 py-4 rounded-full border border-outline-variant/30 font-label text-[10px] uppercase tracking-[0.2em] hover:bg-primary hover:text-on-primary hover:border-transparent transition-all duration-300">View
                Details</button>
            </div>
          </div>


          <!-- Call to Action Card -->
          <div
            class="col-span-1 md:col-span-2 lg:col-span-2 mt-12 bg-surface-container-high rounded-3xl p-12 flex flex-col md:flex-row items-center gap-12 overflow-hidden relative">
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
        </div>
      </section>
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

</template>