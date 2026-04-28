<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const user = reactive(
  {
    email : '',
    password :'',
  }
)

const error = ref(null);
const loading = ref(false) ;
const validationErrors = ref({});
const login = async () => {
  error.value = null
  loading.value = true
  validationErrors.value = {}

  try {
    const result = await fetch('http://localhost:8080/api/auth/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ email: user.email, password: user.password })
    })

    const data = await result.json()

    if (!result.ok) {
      validationErrors.value = data.errors ?? {}
      throw new Error(data.message || 'Login failed')
    }

    localStorage.setItem('token', data.token)
    
    const meRes = await fetch('http://localhost:8080/api/auth/me', {
      headers: { 'Authorization': `Bearer ${data.token}`, 'Accept': 'application/json' }
    })
    const meData = await meRes.json()
    const role = meData.user?.role
    
    localStorage.setItem('user', JSON.stringify(meData.user))

    if (role === 'admin') {
      router.push('/admin/dashboard')
    } else if (role === 'staff') {
      router.push('/Staff/dashbord')
    } else if (role === 'client') {
      router.push('/')
    } else {
      router.push('/')
    }

  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
}
</script>

<template>

  <div class="bg-background font-body text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed">
    <main class="min-h-screen flex flex-col md:flex-row relative zellige-pattern overflow-hidden">
      <!-- Left Visual Panel: Asymmetric Hero -->
      <section class="hidden md:flex md:w-1/2 lg:w-3/5 relative items-center justify-center p-12 overflow-hidden">
        <div class="relative w-full h-full max-w-4xl">
          <!-- Background Image with Arch Detail -->
          <div class="absolute inset-0 rounded-t-[12rem] overflow-hidden shadow-2xl">
            <img class="w-full h-full object-cover brightness-90"
              data-alt="Luxurious Moroccan riad courtyard at dusk with warm lantern lighting reflected in a central turquoise pool and terracotta arches"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuDA2BJYPNnTnaYONjPTTDgOFpFtXjZ8hKIJYrDs1x95s4V4lIF2qMDqQ2nvxvKygwms0O_WYj5Zj_nmRbFtoTAPv4ssKWfTDeCgVVXJnSvJw4rYV6xfHQIiRRPPuXl_6OzbjWpc7R3yxyUewhEsZW1YgF3Qgof2jXtVl6l99SIAHtsZb9Skw929JokSvpX2m--KKwh31npDNSd5kh0I1mclim54AgLOJLSVGERirtn-hyqAlDxwZx4iBxKuVFeQFlgZh-xoc_Nx8CJo" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
          </div>
          <!-- Floating Editorial Content -->
          <div class="absolute bottom-16 left-16 right-16 text-on-primary">
            <span class="font-label text-xs uppercase tracking-[0.2em] mb-4 block">Est. MCMXXIV</span>
            <h2 class="font-headline text-5xl italic leading-tight max-w-lg">
              The art of slow living begins within our walls.
            </h2>
          </div>
        </div>
      </section>
      <!-- Right Interaction Panel: Focus Journey -->
      <section class="flex-1 flex items-center justify-center p-6 md:p-12 lg:p-24 bg-surface/80 backdrop-blur-sm">
        <div class="w-full max-w-md flex flex-col">
          <!-- Brand Anchor -->
          <header class="mb-12 text-center md:text-left">
            <a class="inline-block" href="/">
              <span class="text-3xl font-serif italic text-primary">Kasbah Royale</span>
            </a>
          </header>
          <!-- Form Section -->
          <div class="space-y-10">
            <div class="space-y-2">
              <h1 class="font-headline text-4xl text-on-surface">Welcome back</h1>
              <p class="text-on-surface-variant font-light">Please enter your credentials to access your sanctuary.</p>
            </div>
            <form class="space-y-8" @submit.prevent="login">
              <div v-if="error" class="p-3 bg-red-50 text-red-600 rounded-lg text-sm font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">error</span>{{ error }}
              </div>
              <div class="space-y-6">
                <!-- Email Input -->
                <div class="group">
                  <label 
                    class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant mb-2 transition-colors group-focus-within:text-primary"
                    for="email">Email Address</label>
                  <div class="relative">
                    <input v-model="user.email"
                      class="w-full bg-transparent border-0 border-b border-outline-variant/30 py-3 px-0 text-on-surface placeholder:text-stone-400 focus:ring-0 focus:border-primary transition-all duration-300"
                      id="email" name="email" placeholder="marrakech@kasbahroyale.com" type="email"  />
                      <p v-if="validationErrors.email" class="text-sm text-red-500">{{ validationErrors.email[0] }}</p>
                    <span
                      class="material-symbols-outlined absolute right-0 top-3 text-stone-400 text-sm">alternate_email</span>
                  </div>
                </div>
                <!-- Password Input -->
                <div class="group">
                  <div class="flex justify-between items-center mb-2">
                    <label 
                      class="block font-label text-[10px] uppercase tracking-widest text-on-surface-variant transition-colors group-focus-within:text-primary"
                      for="password">Password</label>
                  </div>
                  <div class="relative">
                    <input v-model="user.password"
                      class="w-full bg-transparent border-0 border-b border-outline-variant/30 py-3 px-0 text-on-surface placeholder:text-stone-400 focus:ring-0 focus:border-primary transition-all duration-300"
                      id="password" name="password" placeholder="••••••••" type="password" />
                      <p v-if="validationErrors.password" class="text-sm text-red-500">{{ validationErrors.password[0] }}
                      </p>
                    <span class="material-symbols-outlined absolute right-0 top-3 text-stone-400 text-sm">lock</span>
                  </div>
                </div>
              </div>
              <!-- CTA Row -->
              <div class="pt-4 flex flex-col space-y-6">
                <button :disabled="loading"
                  class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary py-5 rounded-full font-label text-xs uppercase tracking-[0.2em] font-bold shadow-lg shadow-primary/10 hover:shadow-primary/20 hover:scale-[1.02] transition-all duration-500 flex items-center justify-center space-x-2"
                  type="submit">
                 {{ loading ? "loading..." : "login" }}
                 
                </button>
                <div class="relative flex items-center py-2">
                  <div class="flex-grow border-t border-outline-variant/20"></div>
                  <span class="flex-shrink mx-4 font-label text-[10px] uppercase tracking-widest text-stone-400">Or
                    Continue With</span>
                  <div class="flex-grow border-t border-outline-variant/20"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <button
                    class="flex items-center justify-center space-x-2 py-4 px-6 border border-outline-variant/10 rounded-full hover:bg-surface-container-low transition-colors duration-300"
                    type="button">
                    <span class="material-symbols-outlined text-lg">public</span>
                    <span class="font-label text-[10px] uppercase tracking-widest">Passport</span>
                  </button>
                  <button
                    class="flex items-center justify-center space-x-2 py-4 px-6 border border-outline-variant/10 rounded-full hover:bg-surface-container-low transition-colors duration-300"
                    type="button">
                    <span class="material-symbols-outlined text-lg">mail</span>
                    <span class="font-label text-[10px] uppercase tracking-widest">Google</span>
                  </button>
                </div>
              </div>
            </form>
            <footer class="pt-8 text-center md:text-left">
              <p class="text-stone-500 font-light text-sm">
                Do you have an account?
                <a class="text-primary font-semibold hover:underline underline-offset-4 transition-all" > <router-link to="/register"> Register </router-link></a>
               
              </p>
            </footer>
          </div>
        </div>
      </section>
    </main>
    <!-- Subtle Brand Accents -->
    <div class="fixed top-8 right-8 pointer-events-none opacity-20">
      <span class="material-symbols-outlined text-6xl text-tertiary">settings_input_component</span>
    </div>
    <!-- Secondary Footer for Login Page -->
    <footer
      class="w-full bg-stone-100 py-12 flex flex-col md:flex-row justify-between items-center px-12 space-y-6 md:space-y-0">
      <p class="font-sans text-xs tracking-tight uppercase text-stone-500">© 2024 Kasbah Royale. A Sanctuary for the
        Senses.</p>
      <div class="flex space-x-8">
        <a class="font-sans text-xs tracking-tight uppercase text-stone-500 hover:text-[#755717] underline-offset-4 hover:underline transition-all duration-300"
          href="#">Privacy</a>
        <a class="font-sans text-xs tracking-tight uppercase text-stone-500 hover:text-[#755717] underline-offset-4 hover:underline transition-all duration-300"
          href="#">Sustainability</a>
        <a class="font-sans text-xs tracking-tight uppercase text-stone-500 hover:text-[#755717] underline-offset-4 hover:underline transition-all duration-300"
          href="#">The Medina Guide</a>
      </div>
    </footer>
  </div>
</template>
