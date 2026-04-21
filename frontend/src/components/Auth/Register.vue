<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const user = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
  age: '',
  cin: '',
  telephon: ''
})

const error = ref(null);
const loading = ref(false);
const validationErrors = ref({});

const register = async () => {
  error.value = null;
  loading.value = true;
  validationErrors.value = {};

  try {
    const response = await fetch('http://localhost:8080/api/auth/register', { 
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json' // Add this!
      },
      body: JSON.stringify({
        name: user.name,
        email: user.email,
        password: user.password,
        password_confirmation: user.confirmPassword,
        age: user.age,
        CIN: user.cin,
        telephon: user.telephon
      })
    });

    const data = await response.json(); 

    if (!response.ok) { 
      validationErrors.value = data.errors;
      throw new Error(data.message || "Register failed");
    }

    console.log('Response status:', response.status);  
    router.push('/login');

  } catch (e) {
    error.value = e.message;
    console.error('Fetch error:', error.value); 
    console.log('Validation errors:', validationErrors.value.name[0]);
     
  } finally {
    loading.value = false;
  }
}

</script>
<template>

  <div class="bg-background text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
    <!-- TopAppBar from JSON -->
    <header
      class="bg-[#fcf9ef]/80 dark:bg-stone-950/80 backdrop-blur-xl docked full-width top-0 sticky z-50 transition-opacity duration-500">
      <div class="flex justify-between items-center w-full px-8 py-6 max-w-screen-2xl mx-auto">
        <div class="text-2xl font-serif italic text-[#9a401f] dark:text-[#c05c39]">Kasbah Royale</div>
        <nav class="hidden md:flex items-center space-x-12">
          <a class="text-stone-600 dark:text-stone-400 font-medium Manrope uppercase tracking-widest text-xs hover:text-[#436182] transition-all duration-300 ease-in-out"
            href="#">The Estate</a>
          <a class="text-stone-600 dark:text-stone-400 font-medium Manrope uppercase tracking-widest text-xs hover:text-[#436182] transition-all duration-300 ease-in-out"
            href="#">Suites</a>
          <a class="text-stone-600 dark:text-stone-400 font-medium Manrope uppercase tracking-widest text-xs hover:text-[#436182] transition-all duration-300 ease-in-out"
            href="#">Experiences</a>
          <a class="text-stone-600 dark:text-stone-400 font-medium Manrope uppercase tracking-widest text-xs hover:text-[#436182] transition-all duration-300 ease-in-out"
            href="#">Inquiry</a>
        </nav>
        <button
          class="bg-primary text-on-primary px-6 py-2.5 rounded-full font-label text-xs uppercase tracking-widest font-semibold hover:shadow-lg transition-all duration-300">
          Reserve Now
        </button>
      </div>
    </header>
    <main class="min-h-screen relative zellige-overlay overflow-hidden">
      <div class="max-w-screen-2xl mx-auto px-6 py-12 md:py-24 grid lg:grid-cols-12 gap-12 items-center">
        <!-- Visual Anchor Column -->
        <div class="lg:col-span-5 hidden lg:block relative">
          <div class="keyhole-arch overflow-hidden h-[750px] w-full bg-surface-container-high shadow-xl relative">
            <img alt="Interior Courtyard" class="absolute inset-0 w-full h-full object-cover"
              data-alt="Intricate Moroccan courtyard with terracotta walls, a central pool reflecting the sun, and ornate arched doorways in soft morning light"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-9cigS9-4aTrOXwM3sume2Q4YbKqWazc_RWG63OaVknOEtTA1_c3dwP1VaAddggSjyQgx3eV73l2pn_xvw5OtlS9RTSRgCQy01rrE0XiI8Js2r1_B5x16aUJcQo7DRaB2CDJLS3xtA_qxoAEBoEE8YRRmFMTSkEBlethFPH48oqkdatKe3tMkXUyVmKnEvYKgXH9brX3Dm6u-unzCG7xMSyUgTJ0_o5-VJXjdwr5nHlS_IBcsMOMzdd_F1BWFBKi-SUK2qu0bUjoM" />
            <div class="absolute inset-0 bg-gradient-to-t from-on-surface/40 to-transparent"></div>
            <div class="absolute bottom-12 left-12 right-12 text-white">
              <h2 class="font-headline text-4xl italic mb-4">A Sanctuary for the Senses.</h2>
              <p class="font-body text-sm tracking-wide opacity-90 leading-relaxed max-w-xs">
                Discover a world where timeless elegance meets the warmth of Moroccan hospitality.
              </p>
            </div>
          </div>
          <!-- Floating Element -->
          <div class="absolute -bottom-6 -right-6 bg-tertiary-fixed p-8 rounded-xl shadow-2xl max-w-[240px]">
            <span class="material-symbols-outlined text-tertiary mb-4" data-icon="auto_awesome">auto_awesome</span>
            <p class="text-on-tertiary-fixed text-xs font-label uppercase tracking-widest mb-1">Membership</p>
            <p class="text-on-tertiary-fixed font-headline italic text-lg">Preferred Access to Secret Gardens</p>
          </div>
        </div>
        <!-- Form Column -->
        <div class="lg:col-span-7 flex flex-col justify-center">
          <div class="max-w-2xl mx-auto w-full">
            <div class="mb-12">
              <h1 class="font-headline text-5xl md:text-6xl text-primary mb-4">Begin Your Journey</h1>
              <p class="font-body text-on-surface-variant text-lg">Create your account to unlock curated experiences and
                private suites.</p>
            </div>
            <form @submit.prevent="register" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
              <!-- Full Name -->
              <div class="flex flex-col space-y-2 group">
                <label
                class="font-label text-xs uppercase tracking-[0.15em] text-on-surface-variant group-focus-within:text-primary transition-colors"
                for="full_name">Full Name</label>
                <input v-model="user.name"
                class="bg-transparent border-0 border-b border-outline-variant focus:border-primary focus:ring-0 py-3 px-0 font-body placeholder:text-outline text-lg transition-all"
                id="full_name" placeholder="Yasmine Al-Fassi" type="text" />
                <p v-if="validationErrors.name" style="color:red;">{{validationErrors.name[0]}} </p>  
                </div>
              <!-- Email Address -->
              <div class="flex flex-col space-y-2 group">
                <label
                  class="font-label text-xs uppercase tracking-[0.15em] text-on-surface-variant group-focus-within:text-primary transition-colors"
                  for="email">Email Address</label>
                <input v-model="user.email"
                  class="bg-transparent border-0 border-b border-outline-variant focus:border-primary focus:ring-0 py-3 px-0 font-body placeholder:text-outline text-lg transition-all"
                  id="email" placeholder="yasmine@royale.com" type="email" />
                <p v-if="validationErrors.email" style="color:red;">{{validationErrors.email[0]}} </p>
              </div>
              <!-- Password -->
              <div class="flex flex-col space-y-2 group">
                <label
                  class="font-label text-xs uppercase tracking-[0.15em] text-on-surface-variant group-focus-within:text-primary transition-colors"
                  for="password">Password</label>
                <input v-model="user.password"
                  class="bg-transparent border-0 border-b border-outline-variant focus:border-primary focus:ring-0 py-3 px-0 font-body placeholder:text-outline text-lg transition-all"
                  id="password" placeholder="••••••••" type="password" />
                <p v-if="validationErrors.password" style="color:red;">{{validationErrors.password[0]}} </p>
              </div>
              <!-- Confirm Password -->
              <div class="flex flex-col space-y-2 group">
                <label
                  class="font-label text-xs uppercase tracking-[0.15em] text-on-surface-variant group-focus-within:text-primary transition-colors"
                  for="confirm_password">Confirm Password</label>
                <input v-model="user.confirmPassword"
                  class="bg-transparent border-0 border-b border-outline-variant focus:border-primary focus:ring-0 py-3 px-0 font-body placeholder:text-outline text-lg transition-all"
                  id="confirm_password" placeholder="••••••••" type="password" />
                <p v-if="validationErrors.confirmPassword" style="color:red;">{{validationErrors.confirmPassword[0]}} </p>
              </div>
              <!-- Age -->
              <div class="flex flex-col space-y-2 group">
                <label
                  class="font-label text-xs uppercase tracking-[0.15em] text-on-surface-variant group-focus-within:text-primary transition-colors"
                  for="age">Age</label>
                <input v-model="user.age"
                  class="bg-transparent border-0 border-b border-outline-variant focus:border-primary focus:ring-0 py-3 px-0 font-body placeholder:text-outline text-lg transition-all"
                  id="age" placeholder="25" type="number" />
                <p v-if="validationErrors.age" style="color:red;">{{validationErrors.age[0]}} </p>
              </div>
              <!-- CIN (National ID) -->
              <div class="flex flex-col space-y-2 group">
                <label
                  class="font-label text-xs uppercase tracking-[0.15em] text-on-surface-variant group-focus-within:text-primary transition-colors"
                  for="cin">CIN (National ID)</label>
                <input v-model="user.cin"
                  class="bg-transparent border-0 border-b border-outline-variant focus:border-primary focus:ring-0 py-3 px-0 font-body placeholder:text-outline text-lg transition-all"
                  id="cin" placeholder="BK 123456" type="text" />
                <p v-if="validationErrors.cin" style="color:red;">{{validationErrors.cin[0]}} </p>
              </div>
              <!-- Telephone Number -->
              <div class="md:col-span-2 flex flex-col space-y-2 group">
                <label
                  class="font-label text-xs uppercase tracking-[0.15em] text-on-surface-variant group-focus-within:text-primary transition-colors"
                  for="phone">Telephone Number</label>
                <input v-model="user.telephon"
                  class="bg-transparent border-0 border-b border-outline-variant focus:border-primary focus:ring-0 py-3 px-0 font-body placeholder:text-outline text-lg transition-all"
                  id="phone" placeholder="+212 5XX XX XX XX" type="tel" />
                <p v-if="validationErrors.telephon" style="color:red;">{{validationErrors.telephon[0]}} </p>
              </div>
              <!-- CTA Section -->
              <div class="md:col-span-2 pt-10 flex flex-col items-center space-y-6">
                <button @click="register" :disabled="loading"
                  class="w-full py-5 rounded-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-label uppercase tracking-widest text-sm font-bold shadow-xl hover:scale-[1.02] active:scale-95 transition-all duration-300"
                  type="submit"> {{ loading ? 'loading...' : 'register' }}

                </button>
                <p class="font-body text-on-surface-variant text-sm">
                  Already part of the estate?
                  <a class="text-tertiary font-bold hover:underline underline-offset-4 transition-all ml-1" href="#">Log
                    In</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <!-- Footer from JSON -->
    <footer class="bg-stone-100 dark:bg-stone-900 full-width py-12 transition-all">
      <div
        class="flex flex-col md:flex-row justify-between items-center px-12 w-full max-w-screen-2xl mx-auto space-y-6 md:space-y-0">
        <div class="font-sans text-xs tracking-tight uppercase text-stone-500">
          © 2024 Kasbah Royale. A Sanctuary for the Senses.
        </div>
        <div class="flex space-x-8">
          <a class="font-sans text-xs tracking-tight uppercase text-stone-500 hover:text-[#755717] underline-offset-4 hover:underline transition-all"
            href="#">Privacy</a>
          <a class="font-sans text-xs tracking-tight uppercase text-stone-500 hover:text-[#755717] underline-offset-4 hover:underline transition-all"
            href="#">Sustainability</a>
          <a class="font-sans text-xs tracking-tight uppercase text-stone-500 hover:text-[#755717] underline-offset-4 hover:underline transition-all"
            href="#">The Medina Guide</a>
        </div>
      </div>
    </footer>
  </div>
</template>