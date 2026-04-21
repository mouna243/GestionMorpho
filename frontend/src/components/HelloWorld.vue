<template>
  <container class="bg-background text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
    <!-- TopAppBar -->
    <header
      class="fixed top-0 w-full z-50 flex justify-between items-center px-12 py-6 max-w-screen-2xl mx-auto bg-[#fcf9ef]/80 backdrop-blur-md shadow-[0_20px_40px_rgba(28,28,22,0.06)]">
      <div class="font-serif text-2xl uppercase tracking-[0.2em] text-[#9a401f]">Kasbah Royale</div>
      <nav class="hidden md:flex items-center gap-8">
        <a class="font-headline text-lg tracking-tight text-[#755717] border-b-2 border-[#755717] pb-1 font-semibold"
          href="#">The Riad</a>
        <a class="font-headline text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300 hover:scale-105 transition-all duration-500 ease-in-out"
          href="#">Suites</a>
        <a class="font-headline text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300 hover:scale-105 transition-all duration-500 ease-in-out"
          href="#">Experiences</a>
        <a class="font-headline text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300 hover:scale-105 transition-all duration-500 ease-in-out"
          href="#">Wellness</a>
        <a class="font-headline text-lg tracking-tight text-[#436182] hover:text-[#9a401f] transition-colors duration-300 hover:scale-105 transition-all duration-500 ease-in-out"
          href="#">Gallery</a>
      </nav>
      <div class="flex items-center gap-6">
        <button
          class="material-symbols-outlined text-[#436182] hover:text-[#9a401f] transition-colors">language</button>
        <button
          class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-3 rounded-full font-label uppercase tracking-widest text-xs hover:scale-105 transition-all duration-500 ease-in-out active:opacity-80 active:scale-95">
          Book a Stay
        </button>
      </div>
    </header>
    <main>
      <!-- Atmospheric Hero -->
      <section class="relative h-screen flex items-center justify-center overflow-hidden bg-on-surface">
        <div class="absolute inset-0 opacity-60">
          <img alt="" class="w-full h-full object-cover"
            data-alt="cinematic interior of a traditional Moroccan Riad courtyard at twilight with indigo sky and warm flickering candle lanterns reflecting on water"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD6-lgMMYQxJII4lBQCttg7IhmlGocoyg0XjrGTpJvTuhYkLnq4gkf7KgItoGdFpm1aAxOi1WetkaPxHFaZ6asdRnIJQ3M-FX2KuvsIKheaqkWqWZalyGL3IJpxHvj_AiHmqlyar5VAwVp0eb8kzmQAkdU-WKVhgnrVn3NiNRvNed-HOfeDV8jW281PAUhH3CjMXMvqvZ5bl9wKWAM01KIc7jWqMFIwzgJURUbl4g7k-SQRj3NqP2CzxP0Kfr1UQINHWLJz3-i94KW8" />
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-on-surface/40 to-on-surface/80"></div>
        <div class="relative z-10 text-center px-4 max-w-5xl">
          <span class="font-label text-tertiary-fixed tracking-[0.4em] uppercase text-sm mb-6 block">Beyond the Medina
            Walls</span>
          <h1 class="font-headline text-7xl md:text-9xl text-background leading-tight mb-8 text-glow">
            A Sensory <br />
            <span class="italic font-light">Sanctuary</span>
          </h1>
          <div class="flex justify-center gap-12 mt-12">
            <div class="flex flex-col items-center">
              <span class="text-tertiary text-sm font-label tracking-widest uppercase">Incense</span>
              <div class="w-px h-12 bg-tertiary/30 my-4"></div>
              <span class="text-background/60 text-xs uppercase tracking-widest">Oud &amp; Rose</span>
            </div>
            <div class="flex flex-col items-center">
              <span class="text-tertiary text-sm font-label tracking-widest uppercase">Soundscape</span>
              <div class="w-px h-12 bg-tertiary/30 my-4"></div>
              <span class="text-background/60 text-xs uppercase tracking-widest">Water Rhythms</span>
            </div>
          </div>
        </div>
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 animate-bounce">
          <span class="material-symbols-outlined text-background/40">expand_more</span>
        </div>
      </section>
      <!-- Echoes of the Past -->
      <section class="py-32 px-12 bg-surface">
        <div class="max-w-screen-2xl mx-auto grid grid-cols-12 gap-16 items-center">
          <div class="col-span-12 lg:col-span-5 relative">
            <div class="arch-mask overflow-hidden shadow-2xl">
              <img alt="" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
                data-alt="extreme close up of intricate hand-carved cedar wood details on a traditional Moroccan door with atmospheric side lighting"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYqncqgjS3s8Av7HkUUSHhTB87ZgCE5NB_6V1r5Kvfle2nRUqyvp3cd_0N-CydUonGydaAqokGLkcu0w-nRKcW4CQlBidkA6cFFf_D2i9qfjX7i7-o2poEU7tNHtLpgpoKW8iRddQLXbZvw6tGfPpijNkFqwc3FUINupjKUGMQLTtYfdw0scR4qhqeIIdiPf4fQ1F7n_XfUglx_oF5lncOapZc8WRe9CxZAZNo8He1-5FtimUy40DUvR_5pz-C3BfCcv7jwSTC3Ls8" />
            </div>
            <div
              class="absolute -bottom-10 -right-10 w-64 h-80 arch-mask overflow-hidden hidden lg:block border-[12px] border-surface shadow-xl">
              <img alt="" class="w-full h-full object-cover"
                data-alt="soft silk textiles in earthy terracotta and indigo draped over a vintage wooden chest in a sun-drenched room"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhDz6GmhN57glkWixLref2lxhfI5xZSv1TQf9-M4asncurAC0Ou19kSRzQZ8ZF38bxCVAVQFy7sbL-h0AYMY9-s4s5FW7vd55IxhYtTFpoalTbLX3cguvqo0boYNQ0EHETOqjAjeAq6LUdx2WLIC4aDADjnLwnIh16Iuc5GYt8BB2AtX119bARH42Yp7pfUW_0UoNfpbEEabVO6oHp7ZocCp2pvxHv-YGou5Vo-0HJ7nMy3XnommR80TdrTZmIH5RXQHveipwUCSAa" />
            </div>
          </div>
          <div class="col-span-12 lg:col-span-6 lg:ml-12">
            <label class="font-label text-primary tracking-[0.3em] uppercase text-xs mb-4 block">Our Heritage</label>
            <h2 class="font-headline text-5xl text-on-surface leading-tight mb-8">
              Echoes of the <br /> <span class="italic text-tertiary">Ancestral Past</span>
            </h2>
            <p class="text-on-surface-variant text-lg leading-relaxed mb-12 max-w-xl">
              Within these walls, time folds. Every hand-carved cedar beam and every hand-poured tile tells a story of
              the artisans who breathed life into this Riad three centuries ago. We have preserved the soul of the
              Kasbah, allowing the textures of history to brush against the comforts of the modern world.
            </p>
            <button
              class="group flex items-center gap-4 font-label text-tertiary uppercase tracking-widest text-sm font-bold">
              Trace the History
              <span class="w-12 h-px bg-tertiary group-hover:w-20 transition-all duration-500"></span>
            </button>
          </div>
        </div>
      </section>
      <!-- Nocturnal Rhythms -->
      <section class="py-32 bg-secondary text-background overflow-hidden">
        <div class="max-w-screen-2xl mx-auto px-12">
          <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-2xl">
              <label class="font-label text-tertiary-fixed tracking-[0.3em] uppercase text-xs mb-4 block">After
                Dusk</label>
              <h2 class="font-headline text-6xl leading-tight">Nocturnal Rhythms</h2>
            </div>
            <p
              class="font-label text-background/60 uppercase tracking-widest text-xs border-b border-background/20 pb-2">
              Experience the Midnight Garden</p>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Dining Card -->
            <div class="group relative aspect-[4/5] bg-on-surface overflow-hidden">
              <img alt=""
                class="w-full h-full object-cover opacity-70 group-hover:scale-110 transition-transform duration-1000"
                data-alt="fine dining table set with candles and traditional tagines in a dim indigo courtyard under a starry night sky"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAbAyIngJqwGMC8t8pWYaY5-LgzxOKiAUic05GtRynm_F8PYAJstZ_Tkfs39FyDJk0TbX4HjWQtlLnZfthihE0vqz2BldjiCw2rlTsK8Z-ft-YDeZHHiNLobMBqYaVFoInW7FzseA2I3UJgkvQEqUczDyyCGt4bQe9shIcJIfLQMn23ZO3AzKd8EWaNvixAe9kjE8irdTa-rhOM23oASnL2pgPe1yc5LiJXcKatZQFp76xRQPHH4nhEzCIOuRfwdKu-Arf9-R_yHNoh" />
              <div class="absolute inset-0 bg-gradient-to-t from-secondary via-transparent to-transparent opacity-80">
              </div>
              <div class="absolute bottom-10 left-10 right-10">
                <h3 class="font-headline text-3xl mb-4 italic">Saffron &amp; Starlight</h3>
                <p class="font-body text-background/70 text-sm mb-6 leading-relaxed">A seven-course odyssey through
                  Moroccan spices under the velvet sky.</p>
                <span class="text-tertiary-fixed text-xs font-label tracking-widest uppercase">The Terrace</span>
              </div>
            </div>
            <!-- Lounge Card -->
            <div class="group relative aspect-[4/5] bg-on-surface overflow-hidden md:translate-y-12">
              <img alt=""
                class="w-full h-full object-cover opacity-70 group-hover:scale-110 transition-transform duration-1000"
                data-alt="luxurious lounge with deep indigo velvet sofas, ornate brass lamps, and shadows playing on the carved walls"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuB39MuKUw1vryuvBlru7QXPuC4yG41EB0WxYKiWKLx8euO3R33dfCknGtzaoSPvTTACRUBjIvwVQIz07R-jEz2uj282AhEqQd5eV8Pga9MABrNzWSAk4AUm20pcNbOPverNHKH3FAGIRwNP4TC4iuSamY9rBcEc-KKqWVrgO1bw662fDEEVRE1J-7yLNo6C_HGsE3Du6vyLiGtc9GWRnhrH0ll7UaaczJl6VtMCnj4-R92pGMhCDyCmoc58XOhkYfplMkwZ3crTD6Yj" />
              <div class="absolute inset-0 bg-gradient-to-t from-secondary via-transparent to-transparent opacity-80">
              </div>
              <div class="absolute bottom-10 left-10 right-10">
                <h3 class="font-headline text-3xl mb-4 italic">The Indigo Den</h3>
                <p class="font-body text-background/70 text-sm mb-6 leading-relaxed">Where the scent of mint tea meets
                  the cool touch of silk textiles.</p>
                <span class="text-tertiary-fixed text-xs font-label tracking-widest uppercase">Secret Lounge</span>
              </div>
            </div>
            <!-- Music Card -->
            <div class="group relative aspect-[4/5] bg-on-surface overflow-hidden">
              <img alt=""
                class="w-full h-full object-cover opacity-70 group-hover:scale-110 transition-transform duration-1000"
                data-alt="musician playing traditional oud in a candlelit courtyard with soft focused architectural background"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDtCUSflPoea8yWnjjEctTVu3gq0GsmCdYsGRJQUMYgVpwhVo39xclymrRqGTCDbrO_rRzxUkMo-laojwVYtN_f6-Y9O3W0d51W526rwlzu4zH4UQSWKe_SWOTLo5Te0LCsq7dS7VCCHPPu0kgnwwOJkhk1SOZXd5DypzeMhgDs5BekjJVcaui3D-vKlVdo4squThusaYUt-iJ6Tr2hHPb0g10BINwzhGO6twYa4T1Q7DeFnFwu5OloRB8Yjc-SN3J7Z7f6lSvnPd4v" />
              <div class="absolute inset-0 bg-gradient-to-t from-secondary via-transparent to-transparent opacity-80">
              </div>
              <div class="absolute bottom-10 left-10 right-10">
                <h3 class="font-headline text-3xl mb-4 italic">Desert Echoes</h3>
                <p class="font-body text-background/70 text-sm mb-6 leading-relaxed">Live rhythmic performances that
                  bridge the ancient and the ambient.</p>
                <span class="text-tertiary-fixed text-xs font-label tracking-widest uppercase">The Inner Court</span>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- The Art of the Hammam -->
      <section class="py-32 px-12 bg-surface-container-low relative">
        <div class="max-w-screen-2xl mx-auto flex flex-col lg:flex-row items-center gap-20">
          <div class="w-full lg:w-1/2 order-2 lg:order-1">
            <label class="font-label text-tertiary tracking-[0.3em] uppercase text-xs mb-4 block">Purification</label>
            <h2 class="font-headline text-6xl text-on-surface leading-tight mb-8">The Art of <br /> the <span
                class="italic font-light">Hammam</span></h2>
            <div class="space-y-8 max-w-lg">
              <div class="flex gap-6">
                <span class="text-primary-container font-headline text-2xl italic">01</span>
                <div>
                  <h4 class="font-headline text-xl mb-2">The Steam Ritual</h4>
                  <p class="text-on-surface-variant text-sm leading-relaxed">Warm marble and aromatic steam open the
                    senses to a world of absolute calm.</p>
                </div>
              </div>
              <div class="flex gap-6">
                <span class="text-primary-container font-headline text-2xl italic">02</span>
                <div>
                  <h4 class="font-headline text-xl mb-2">Beldi Scrub</h4>
                  <p class="text-on-surface-variant text-sm leading-relaxed">Ancient techniques using black soap and
                    eucalyptus to renew the spirit.</p>
                </div>
              </div>
              <div class="flex gap-6">
                <span class="text-primary-container font-headline text-2xl italic">03</span>
                <div>
                  <h4 class="font-headline text-xl mb-2">Golden Oil Anointment</h4>
                  <p class="text-on-surface-variant text-sm leading-relaxed">Pure Argan oil massaged into the skin,
                    leaving a lasting sun-kissed glow.</p>
                </div>
              </div>
            </div>
            <button
              class="mt-12 bg-secondary text-on-secondary px-10 py-4 rounded-full font-label uppercase tracking-[0.2em] text-xs hover:scale-105 transition-all">Book
              Ritual</button>
          </div>
          <div class="w-full lg:w-1/2 order-1 lg:order-2 grid grid-cols-2 gap-4 h-[600px]">
            <div class="col-span-1 rounded-t-full overflow-hidden translate-y-12 shadow-lg">
              <img alt="" class="w-full h-full object-cover"
                data-alt="steam rising in a traditional marble hammam with sunlight filtering through star-shaped roof cutouts"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBmOQTyjP8SgpE9tCULCrD9DyQb34M-FGVHjl6UxHcsulei1Fp34QL7cgptvDuoZo6etMGmMtFrlPdYbcxbghDHcDZKNcGsYr20pZf1VQrd1Ehjd0at8qacoHoilsmkctDCFEyJEJI0AsD-FPktR2cyxUF6eiwZqT6ULDAjUCxPWZ-aT1OUFaL9plmkkFvgau0LqqkrwvsnXtT7gzGa4NjtYDYrCGj98infkcNTJPtAslxnMFvts1_aOqAZxRRH0jdq7vCvfHOeRntz" />
            </div>
            <div class="col-span-1 rounded-b-full overflow-hidden shadow-lg">
              <img alt="" class="w-full h-full object-cover"
                data-alt="close up of hands being massaged with golden argan oil in a luxury spa setting with warm lighting"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC91lqSnmcwGKG1Qi1GNykHO0kDA1bMVdrpA5hX5kv1wJUKlR814u7c91nAMGOPK6iowbFgCjknGXojzz4IosyzGYrhIgQR2vIVC_p-V-HpRhQABAQwktIlpHz8IdclJ3oymU_ZMfn4IeurNg8jU_5RVmg05t4YncdUL1ULQrlclPNagPV8pliLmSlfp8M0TrlwPG_wqze58D9n8tmK5DJUzBDE1ffbA6JxXwij61OGy4b_wsWgcpqjFqu9faZMa2HWLIWx9nazOn9P" />
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- Footer -->
    <footer
      class="w-full py-20 px-12 flex flex-col md:flex-row justify-between items-start gap-8 bg-[#436182] text-[#fcf9ef] rounded-t-[4rem] mt-20">
      <div class="flex flex-col max-w-md">
        <div class="font-serif text-3xl text-[#755717] mb-4">Kasbah Royale</div>
        <p class="font-manrope text-sm uppercase tracking-widest text-[#fcf9ef]/70 mb-8 leading-relaxed">© 2024 Kasbah
          Royale. A sensory journey into the heart of Marrakech.</p>
        <div class="flex gap-6">
          <a class="material-symbols-outlined text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity"
            href="#">public</a>
          <a class="material-symbols-outlined text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity"
            href="#">share</a>
          <a class="material-symbols-outlined text-[#fcf9ef]/70 hover:text-[#fcf9ef] transition-opacity"
            href="#">mail</a>
        </div>
      </div>
      <nav class="flex flex-wrap gap-x-12 gap-y-4">
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
      </nav>
      <div class="flex flex-col items-end">
        <p class="font-label text-xs uppercase tracking-[0.3em] text-[#755717] mb-4">Newsletter</p>
        <div class="flex border-b border-[#fcf9ef]/20 pb-2">
          <input class="bg-transparent border-none focus:ring-0 text-sm placeholder:text-[#fcf9ef]/30 w-48"
            placeholder="Your Email" type="email" />
          <button class="material-symbols-outlined text-[#755717]">arrow_forward</button>
        </div>
      </div>
    </footer>
  </container>
</template>

<script setup lang="ts">
import { ref } from 'vue'

// Images
const heroImage = ref('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920&h=1080&fit=crop')

// Top chambers data
interface Room {
  id: number
  name: string
  category: string
  description: string
  image: string
  price: string
  rating: number
  reviews: number
}

const topChambers = ref<Room[]>([
  {
    id: 1,
    name: 'Suite Présidentielle',
    category: 'Premium',
    description: 'Suite luxueuse avec vue panoramique sur la ville, jacuzzi et terrasse privée.',
    image: 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=400&h=300&fit=crop',
    price: '450€',
    rating: 5,
    reviews: 128
  },
  {
    id: 2,
    name: 'Chambre Deluxe',
    category: 'Luxe',
    description: 'Chambre spacieuse avec lit king size, bureau et salle de bain privative.',
    image: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400&h=300&fit=crop',
    price: '250€',
    rating: 4,
    reviews: 95
  },
  {
    id: 3,
    name: 'Chambre Junior Suite',
    category: 'Confort',
    description: 'Espace séjour séparé, équipements modernes et design contemporain.',
    image: 'https://images.unsplash.com/photo-1584132967330-3eace6d7b49c?w=400&h=300&fit=crop',
    price: '320€',
    rating: 5,
    reviews: 67
  }
])

// Contact form data
const contactForm = ref({
  name: '',
  email: '',
  phone: '',
  message: ''
})

// Submit contact form
const submitContact = () => {
  console.log('Contact form submitted:', contactForm.value)
  // Here you would typically send the data to your backend API
  alert('Merci pour votre message ! Nous vous répondrons dans les plus brefs délais.')
  contactForm.value = { name: '', email: '', phone: '', message: '' }
}
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

@keyframes slide-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 1s ease-out;
}

.animate-slide-up {
  animation: slide-up 0.8s ease-out;
}

html {
  scroll-behavior: smooth;
}
</style>