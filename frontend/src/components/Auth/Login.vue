<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
            <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Connexion</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-gray-600 mt-4">Connectez-vous à votre compte HotelManager</p>
      </div>

      <!-- Login Form -->
      <div class="bg-white rounded-lg shadow-lg p-8">
        <form @submit.prevent="handleLogin" class="space-y-6">
          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              Email <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </div>
              <input 
                type="email" 
                id="email" 
                v-model="formData.email"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': errors.email }"
                placeholder="jean.dupont@email.com"
                required
              >
            </div>
            <p v-if="errors.email" class="mt-1 text-sm text-red-500">{{ errors.email }}</p>
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              Mot de passe <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <input 
                :type="showPassword ? 'text' : 'password'"
                id="password" 
                v-model="formData.password"
                class="w-full pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                :class="{ 'border-red-500': errors.password }"
                placeholder="••••••••"
                required
              >
              <button 
                type="button"
                @click="togglePassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <svg v-if="!showPassword" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <svg v-else class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                </svg>
              </button>
            </div>
            <p v-if="errors.password" class="mt-1 text-sm text-red-500">{{ errors.password }}</p>
          </div>

          <!-- Remember me & Forgot password -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input 
                type="checkbox" 
                id="remember" 
                v-model="formData.remember"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
              >
              <label for="remember" class="ml-2 block text-sm text-gray-700">
                Se souvenir de moi
              </label>
            </div>
            <div class="text-sm">
              <a href="#" class="text-indigo-600 hover:text-indigo-500">
                Mot de passe oublié ?
              </a>
            </div>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105"
            :disabled="loading"
          >
            <span v-if="!loading">Se connecter</span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Connexion en cours...
            </span>
          </button>

          <!-- Register Link -->
          <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
              Vous n'avez pas de compte ? 
              <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Inscrivez-vous</a>
            </p>
          </div>
        </form>

        <!-- Demo Credentials (for testing) -->
        <div class="mt-6 pt-6 border-t border-gray-200">
          <p class="text-xs text-center text-gray-500 mb-2">
            🔐 Démo - Identifiants de test
          </p>
          <div class="bg-gray-50 rounded-lg p-3 text-xs">
            <p class="text-gray-600"><span class="font-semibold">Email:</span> demo@hotelmanager.com</p>
            <p class="text-gray-600"><span class="font-semibold">Mot de passe:</span> Demo1234</p>
          </div>
        </div>
      </div>

      <!-- Security Info -->
      <div class="mt-6 text-center">
        <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
          <div class="flex items-center">
            <svg class="h-4 w-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <span>Connexion sécurisée</span>
          </div>
          <div class="flex items-center">
            <svg class="h-4 w-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span>Données protégées</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
/* import { useRouter } from 'vue-router'

// Router
const router = useRouter() */

// Form data interface
interface FormData {
  email: string
  password: string
  remember: boolean
}

interface Errors {
  email?: string
  password?: string
  general?: string
}

// Reactive data
const formData = reactive<FormData>({
  email: '',
  password: '',
  remember: false
})

const errors = reactive<Errors>({})
const loading = ref(false)
const showPassword = ref(false)

// Toggle password visibility
const togglePassword = () => {
  showPassword.value = !showPassword.value
}

// Validation functions
const validateEmail = (email: string): boolean => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!email) {
    errors.email = 'L\'email est requis'
    return false
  }
  if (!emailRegex.test(email)) {
    errors.email = 'Veuillez entrer un email valide'
    return false
  }
  delete errors.email
  return true
}

const validatePassword = (password: string): boolean => {
  if (!password) {
    errors.password = 'Le mot de passe est requis'
    return false
  }
  if (password.length < 6) {
    errors.password = 'Le mot de passe doit contenir au moins 6 caractères'
    return false
  }
  delete errors.password
  return true
}

// Main validation function
const validateForm = (): boolean => {
  const isEmailValid = validateEmail(formData.email)
  const isPasswordValid = validatePassword(formData.password)
  
  return isEmailValid && isPasswordValid
}

// Handle login
const handleLogin = async () => {
  // Clear previous errors
  Object.keys(errors).forEach(key => delete errors[key as keyof Errors])
  
  // Validate form
  if (!validateForm()) {
    return
  }
  
  loading.value = true
  
  // Simulate API call
  try {
    await new Promise(resolve => setTimeout(resolve, 2000))
    
    // Demo authentication
    // In real app, replace with actual API call
    if (formData.email === 'demo@hotelmanager.com' && formData.password === 'Demo1234') {
      console.log('Login successful:', {
        email: formData.email,
        remember: formData.remember
      })
      
      // Store auth token (example)
      if (formData.remember) {
        localStorage.setItem('userEmail', formData.email)
      } else {
        sessionStorage.setItem('userEmail', formData.email)
      }
      
      // Success message
      alert('Connexion réussie ! Bienvenue sur HotelManager.')
      
      // Redirect to home page or dashboard
      /*router.push('/')  */
    } else {
      errors.general = 'Email ou mot de passe incorrect'
      alert('Email ou mot de passe incorrect')
    }
    
  } catch (error) {
    console.error('Login error:', error)
    errors.general = 'Une erreur est survenue. Veuillez réessayer.'
    alert('Une erreur est survenue. Veuillez réessayer.')
  } finally {
    loading.value = false
  }
}

// Check if user was previously logged in
const checkRememberedUser = () => {
  const rememberedEmail = localStorage.getItem('userEmail')
  if (rememberedEmail) {
    formData.email = rememberedEmail
    formData.remember = true
  }
}

// Run on component mount
checkRememberedUser()
</script>

<style scoped>
/* Custom animations */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bg-white {
  animation: fadeIn 0.5s ease-out;
}

/* Smooth transitions */
input, button {
  transition: all 0.3s ease;
}

input:focus {
  transform: translateY(-1px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

button:active {
  transform: scale(0.98);
}

/* Loading animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
</style>