<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Inscription</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Créez votre compte pour profiter de nos services exclusifs</p>
      </div>

      <div class="grid md:grid-cols-2 gap-12 items-start">
        <!-- Registration Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
          <form @submit.prevent="handleRegister" class="space-y-6">
            <!-- Name Field -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nom complet <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                </div>
                <input 
                  type="text" 
                  id="name" 
                  v-model="formData.name"
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                  :class="{ 'border-red-500': errors.name }"
                  placeholder="Jean Dupont"
                  required
                >
              </div>
              <p v-if="errors.name" class="mt-1 text-sm text-red-500">{{ errors.name }}</p>
            </div>

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

            <!-- Age Field -->
            <div>
              <label for="age" class="block text-sm font-medium text-gray-700 mb-2">
                Âge <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <input 
                  type="number" 
                  id="age" 
                  v-model="formData.age"
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                  :class="{ 'border-red-500': errors.age }"
                  placeholder="25"
                  min="18"
                  max="120"
                  required
                >
              </div>
              <p v-if="errors.age" class="mt-1 text-sm text-red-500">{{ errors.age }}</p>
              <p class="mt-1 text-xs text-gray-500">Âge minimum requis : 18 ans</p>
            </div>

            <!-- CIN Field -->
            <div>
              <label for="cin" class="block text-sm font-medium text-gray-700 mb-2">
                CIN (Carte d'Identité Nationale) <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2H15a3 3 0 00-2.83-2H9z"></path>
                  </svg>
                </div>
                <input 
                  type="text" 
                  id="cin" 
                  v-model="formData.cin"
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 uppercase"
                  :class="{ 'border-red-500': errors.cin }"
                  placeholder="AB123456"
                  required
                >
              </div>
              <p v-if="errors.cin" class="mt-1 text-sm text-red-500">{{ errors.cin }}</p>
              <p class="mt-1 text-xs text-gray-500">Format: 2 lettres suivies de 6 chiffres (ex: AB123456)</p>
            </div>

            <!-- Telephone Field -->
            <div>
              <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                Téléphone <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                  </svg>
                </div>
                <input 
                  type="tel" 
                  id="telephone" 
                  v-model="formData.telephone"
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                  :class="{ 'border-red-500': errors.telephone }"
                  placeholder="0612345678"
                  required
                >
              </div>
              <p v-if="errors.telephone" class="mt-1 text-sm text-red-500">{{ errors.telephone }}</p>
              <p class="mt-1 text-xs text-gray-500">Format: 10 chiffres (ex: 0612345678)</p>
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
              <div class="mt-2">
                <p class="text-xs text-gray-500">Le mot de passe doit contenir :</p>
                <ul class="text-xs text-gray-500 list-disc list-inside">
                  <li>Au moins 8 caractères</li>
                  <li>Au moins 1 lettre majuscule</li>
                  <li>Au moins 1 chiffre</li>
                </ul>
              </div>
            </div>

            <!-- Confirm Password Field -->
            <div>
              <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                Confirmer le mot de passe <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                  </svg>
                </div>
                <input 
                  :type="showConfirmPassword ? 'text' : 'password'"
                  id="confirmPassword" 
                  v-model="formData.confirmPassword"
                  class="w-full pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                  :class="{ 'border-red-500': errors.confirmPassword }"
                  placeholder="••••••••"
                  required
                >
                <button 
                  type="button"
                  @click="toggleConfirmPassword"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center"
                >
                  <svg v-if="!showConfirmPassword" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  <svg v-else class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                  </svg>
                </button>
              </div>
              <p v-if="errors.confirmPassword" class="mt-1 text-sm text-red-500">{{ errors.confirmPassword }}</p>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input 
                  type="checkbox" 
                  id="terms" 
                  v-model="formData.acceptTerms"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                >
              </div>
              <div class="ml-3">
                <label for="terms" class="text-sm text-gray-600">
                  J'accepte les <a href="#" class="text-indigo-600 hover:text-indigo-500">conditions générales</a> et la <a href="#" class="text-indigo-600 hover:text-indigo-500">politique de confidentialité</a>
                </label>
              </div>
            </div>

            <!-- Submit Button -->
            <button 
              type="submit" 
              class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105"
              :disabled="loading"
            >
              <span v-if="!loading">S'inscrire</span>
              <span v-else class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Inscription en cours...
              </span>
            </button>

            <!-- Login Link -->
            <div class="text-center mt-4">
              <p class="text-sm text-gray-600">
                Vous avez déjà un compte ? 
                <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Connectez-vous</a>
              </p>
            </div>
          </form>
        </div>

        <!-- Info Sidebar -->
        <div class="space-y-6">
          <!-- Benefits Card -->
          <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-8 text-white">
            <h3 class="text-2xl font-bold mb-4">Pourquoi s'inscrire ?</h3>
            <div class="space-y-4">
              <div class="flex items-start space-x-3">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Réductions exclusives jusqu'à 20%</span>
              </div>
              <div class="flex items-start space-x-3">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Accès prioritaire aux offres spéciales</span>
              </div>
              <div class="flex items-start space-x-3">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Programme de fidélité avantageux</span>
              </div>
              <div class="flex items-start space-x-3">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Gestion simplifiée de vos réservations</span>
              </div>
            </div>
          </div>

          <!-- Testimonial Card -->
          <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center mb-4">
              <div class="text-yellow-400 flex">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
              </div>
              <span class="ml-2 text-gray-600">5.0</span>
            </div>
            <p class="text-gray-600 italic mb-4">
              "Une expérience exceptionnelle ! L'inscription est simple et rapide. Les avantages membres sont vraiment intéressants."
            </p>
            <div class="flex items-center">
              <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                <span class="text-indigo-600 font-bold">MS</span>
              </div>
              <div class="ml-3">
                <p class="font-semibold text-gray-900">Marie Simon</p>
                <p class="text-sm text-gray-500">Membre depuis 2023</p>
              </div>
            </div>
          </div>

          <!-- Security Info Card -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center mb-3">
              <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
              <h4 class="font-semibold text-gray-900">Sécurité des données</h4>
            </div>
            <p class="text-sm text-gray-600">
              Vos informations personnelles sont protégées et ne seront jamais partagées avec des tiers.
              Conformité RGPD garantie.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'

// Form data interface
interface FormData {
  name: string
  email: string
  age: number | null
  cin: string
  telephone: string
  password: string
  confirmPassword: string
  acceptTerms: boolean
}

interface Errors {
  name?: string
  email?: string
  age?: string
  cin?: string
  telephone?: string
  password?: string
  confirmPassword?: string
}

// Reactive data
const formData = reactive<FormData>({
  name: '',
  email: '',
  age: null,
  cin: '',
  telephone: '',
  password: '',
  confirmPassword: '',
  acceptTerms: false
})

const errors = reactive<Errors>({})
const loading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)

// Toggle password visibility
const togglePassword = () => {
  showPassword.value = !showPassword.value
}

const toggleConfirmPassword = () => {
  showConfirmPassword.value = !showConfirmPassword.value
}

// Validation functions
const validateName = (name: string): boolean => {
  if (!name || name.trim().length < 2) {
    errors.name = 'Le nom doit contenir au moins 2 caractères'
    return false
  }
  if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(name)) {
    errors.name = 'Le nom ne doit contenir que des lettres'
    return false
  }
  delete errors.name
  return true
}

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

const validateAge = (age: number | null): boolean => {
  if (!age) {
    errors.age = 'L\'âge est requis'
    return false
  }
  if (age < 18) {
    errors.age = 'Vous devez avoir au moins 18 ans'
    return false
  }
  if (age > 120) {
    errors.age = 'Âge invalide'
    return false
  }
  delete errors.age
  return true
}

const validateCIN = (cin: string): boolean => {
  const cinRegex = /^[A-Z]{2}[0-9]{6}$/
  if (!cin) {
    errors.cin = 'Le CIN est requis'
    return false
  }
  if (!cinRegex.test(cin.toUpperCase())) {
    errors.cin = 'Format CIN invalide (ex: AB123456)'
    return false
  }
  delete errors.cin
  return true
}

const validateTelephone = (telephone: string): boolean => {
  const phoneRegex = /^[0-9]{10}$/
  if (!telephone) {
    errors.telephone = 'Le numéro de téléphone est requis'
    return false
  }
  if (!phoneRegex.test(telephone)) {
    errors.telephone = 'Numéro de téléphone invalide (10 chiffres requis)'
    return false
  }
  delete errors.telephone
  return true
}

const validatePassword = (password: string): boolean => {
  const passwordRegex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/
  if (!password) {
    errors.password = 'Le mot de passe est requis'
    return false
  }
  if (!passwordRegex.test(password)) {
    errors.password = 'Le mot de passe doit contenir au moins 8 caractères, 1 majuscule et 1 chiffre'
    return false
  }
  delete errors.password
  return true
}

const validateConfirmPassword = (confirmPassword: string): boolean => {
  if (!confirmPassword) {
    errors.confirmPassword = 'Veuillez confirmer votre mot de passe'
    return false
  }
  if (confirmPassword !== formData.password) {
    errors.confirmPassword = 'Les mots de passe ne correspondent pas'
    return false
  }
  delete errors.confirmPassword
  return true
}

// Main validation function
const validateForm = (): boolean => {
  const isNameValid = validateName(formData.name)
  const isEmailValid = validateEmail(formData.email)
  const isAgeValid = validateAge(formData.age)
  const isCINValid = validateCIN(formData.cin)
  const isTelephoneValid = validateTelephone(formData.telephone)
  const isPasswordValid = validatePassword(formData.password)
  const isConfirmPasswordValid = validateConfirmPassword(formData.confirmPassword)
  
  return isNameValid && isEmailValid && isAgeValid && isCINValid && 
         isTelephoneValid && isPasswordValid && isConfirmPasswordValid
}

// Handle form submission
const handleRegister = async () => {
  // Clear previous errors
  Object.keys(errors).forEach(key => delete errors[key as keyof Errors])
  
  // Validate form
  if (!validateForm()) {
    return
  }
  
  // Check terms acceptance
  if (!formData.acceptTerms) {
    alert('Veuillez accepter les conditions générales')
    return
  }
  
  loading.value = true
  
  // Simulate API call
  try {
    await new Promise(resolve => setTimeout(resolve, 2000))
    
    // Prepare data for API
    const userData = {
      name: formData.name,
      email: formData.email,
      age: formData.age,
      cin: formData.cin.toUpperCase(),
      telephone: formData.telephone,
      password: formData.password // In real app, hash this before sending
    }
    
    console.log('Registration data:', userData)
    
    // Success message
    alert('Inscription réussie ! Bienvenue chez HotelManager.')
    
    // Reset form
    formData.name = ''
    formData.email = ''
    formData.age = null
    formData.cin = ''
    formData.telephone = ''
    formData.password = ''
    formData.confirmPassword = ''
    formData.acceptTerms = false
    
  } catch (error) {
    console.error('Registration error:', error)
    alert('Une erreur est survenue. Veuillez réessayer.')
  } finally {
    loading.value = false
  }
}
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

.bg-gradient-to-r {
  animation: fadeIn 0.6s ease-out;
}

/* Smooth transitions */
input, button {
  transition: all 0.3s ease;
}

input:focus {
  transform: translateY(-1px);
}

button:active {
  transform: scale(0.98);
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>