<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Réserver une Session Spa</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Offrez-vous un moment de détente et de bien-être</p>
      </div>

      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Reservation Form -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-lg p-8">
            <form @submit.prevent="handleReservation" class="space-y-6">
              <!-- Treatment Selection -->
              <div>
                <label for="treatment" class="block text-sm font-medium text-gray-700 mb-2">
                  Choisissez votre traitement <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <select 
                    id="treatment" 
                    v-model="reservationData.treatment_id"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.treatment_id }"
                    required
                    @change="updateTreatmentDetails"
                  >
                    <option value="">Sélectionnez un traitement</option>
                    <option v-for="treatment in treatments" :key="treatment.id" :value="treatment.id">
                      {{ treatment.name }} - {{ treatment.duration }} min - {{ treatment.price }}€
                    </option>
                  </select>
                </div>
                <p v-if="errors.treatment_id" class="mt-1 text-sm text-red-500">{{ errors.treatment_id }}</p>
              </div>

              <!-- Treatment Description -->
              <div v-if="selectedTreatment" class="bg-indigo-50 rounded-lg p-4">
                <div class="flex items-start">
                  <svg class="h-5 w-5 text-indigo-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <div>
                    <p class="text-sm text-gray-600">{{ selectedTreatment.description }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                      <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">
                        Durée: {{ selectedTreatment.duration }} min
                      </span>
                      <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">
                        Prix: {{ selectedTreatment.price }}€
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Date Debut (Date d'arrivée) -->
              <div>
                <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">
                  Date de début <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <input 
                    type="datetime-local" 
                    id="date_debut" 
                    v-model="reservationData.date_debut"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.date_debut }"
                    :min="minDateTime"
                    required
                    @change="calculateDateFin"
                  >
                </div>
                <p v-if="errors.date_debut" class="mt-1 text-sm text-red-500">{{ errors.date_debut }}</p>
                <p class="mt-1 text-xs text-gray-500">Format: JJ/MM/AAAA HH:MM</p>
              </div>

              <!-- Date Fin (Date de fin) -->
              <div>
                <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">
                  Date de fin <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <input 
                    type="datetime-local" 
                    id="date_fin" 
                    v-model="reservationData.date_fin"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.date_fin }"
                    :min="minDateTime"
                    required
                    @change="validateDates"
                  >
                </div>
                <p v-if="errors.date_fin" class="mt-1 text-sm text-red-500">{{ errors.date_fin }}</p>
                <p class="mt-1 text-xs text-gray-500">La date de fin doit être après la date de début</p>
              </div>

              <!-- Duration Display -->
              <div v-if="durationMinutes > 0" class="bg-green-50 rounded-lg p-3">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Durée totale:</span>
                  </div>
                  <span class="text-lg font-bold text-green-600">{{ durationMinutes }} minutes</span>
                </div>
              </div>

              <!-- Therapist Selection -->
              <div>
                <label for="therapist" class="block text-sm font-medium text-gray-700 mb-2">
                  Thérapeute préféré (optionnel)
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                  <select 
                    id="therapist" 
                    v-model="reservationData.therapist_id"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                  >
                    <option value="">Sélectionnez un thérapeute (optionnel)</option>
                    <option v-for="therapist in therapists" :key="therapist.id" :value="therapist.id">
                      {{ therapist.name }} - {{ therapist.specialty }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Options supplémentaires -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Options supplémentaires
                </label>
                <div class="space-y-2">
                  <div v-for="option in additionalOptions" :key="option.id" class="flex items-center">
                    <input 
                      type="checkbox" 
                      :id="'option_' + option.id"
                      :value="option.id"
                      v-model="reservationData.options"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                      @change="updateTotalPrice"
                    >
                    <label :for="'option_' + option.id" class="ml-2 text-sm text-gray-700">
                      {{ option.name }} - <span class="text-indigo-600">{{ option.price }}€</span>
                      <span class="text-gray-500 text-xs ml-1">({{ option.description }})</span>
                    </label>
                  </div>
                </div>
              </div>

              <!-- Special Requests -->
              <div>
                <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">
                  Demandes spéciales
                </label>
                <textarea 
                  id="special_requests" 
                  v-model="reservationData.special_requests"
                  rows="3" 
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                  placeholder="Allergies, préférences, besoins particuliers..."
                ></textarea>
              </div>

              <!-- Submit Button -->
              <button 
                type="submit" 
                class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105"
                :disabled="loading"
              >
                <span v-if="!loading">Réserver maintenant</span>
                <span v-else class="flex items-center justify-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Réservation en cours...
                </span>
              </button>
            </form>
          </div>
        </div>

        <!-- Reservation Summary -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-lg p-8 sticky top-24">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Résumé de la réservation</h3>
            
            <!-- Selected Treatment -->
            <div v-if="selectedTreatment" class="mb-6">
              <div class="bg-indigo-50 rounded-lg p-4 mb-4">
                <h4 class="font-semibold text-gray-900 mb-2">{{ selectedTreatment.name }}</h4>
                <p class="text-sm text-gray-600 mb-1">Durée: {{ selectedTreatment.duration }} minutes</p>
                <p class="text-sm text-gray-600">Prix de base: {{ selectedTreatment.price }}€</p>
              </div>
            </div>
            <div v-else class="bg-gray-50 rounded-lg p-4 mb-4 text-center text-gray-500">
              <svg class="h-12 w-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <p>Sélectionnez un traitement</p>
            </div>

            <!-- Dates Summary -->
            <div v-if="reservationData.date_debut && reservationData.date_fin" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-2">Date et heure</h4>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <span class="text-gray-600">Début:</span>
                  <span class="font-medium">{{ formatDateTime(reservationData.date_debut) }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Fin:</span>
                  <span class="font-medium">{{ formatDateTime(reservationData.date_fin) }}</span>
                </div>
                <div class="flex justify-between pt-2 border-t">
                  <span class="text-gray-600">Durée:</span>
                  <span class="font-semibold text-indigo-600">{{ durationMinutes }} minutes</span>
                </div>
              </div>
            </div>

            <!-- Selected Options -->
            <div v-if="selectedOptionsList.length > 0" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-2">Options choisies</h4>
              <div class="space-y-1 text-sm">
                <div v-for="option in selectedOptionsList" :key="option.id" class="flex justify-between">
                  <span class="text-gray-600">{{ option.name }}</span>
                  <span class="font-medium">{{ option.price }}€</span>
                </div>
              </div>
            </div>

            <!-- Therapist Info -->
            <div v-if="selectedTherapist" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-2">Thérapeute</h4>
              <div class="bg-gray-50 rounded-lg p-3 text-sm">
                <p class="font-medium">{{ selectedTherapist.name }}</p>
                <p class="text-gray-600">{{ selectedTherapist.specialty }}</p>
                <p class="text-xs text-gray-500 mt-1">Expérience: {{ selectedTherapist.experience }} ans</p>
              </div>
            </div>

            <!-- Price Breakdown -->
            <div v-if="totalPrice > 0" class="mb-6">
              <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-3">Détail du prix</h4>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Traitement:</span>
                    <span>{{ selectedTreatment?.price || 0 }}€</span>
                  </div>
                  <div v-if="selectedOptionsList.length > 0" class="flex justify-between">
                    <span class="text-gray-600">Options:</span>
                    <span>{{ optionsTotal }}€</span>
                  </div>
                  <div class="flex justify-between pt-2 border-t font-bold">
                    <span class="text-gray-900">Total:</span>
                    <span class="text-indigo-600 text-xl">{{ totalPrice }}€</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Important Info -->
            <div class="text-xs text-gray-500 text-center space-y-1">
              <p>✓ Annulation gratuite jusqu'à 24h avant</p>
              <p>✓ Peignoir et serviettes fournis</p>
              <p>✓ Arriver 15 minutes avant l'heure prévue</p>
              <p>✓ TVA incluse</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="showConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeConfirmation">
      <div class="bg-white rounded-lg max-w-md w-full p-6 text-center">
        <div class="mb-4">
          <div class="mx-auto h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Réservation confirmée !</h3>
        <p class="text-gray-600 mb-4">
          Votre session spa a été réservée avec succès.<br>
          Numéro de réservation: <span class="font-semibold text-indigo-600">{{ reservationNumber }}</span>
        </p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-left">
          <p class="text-sm text-gray-600"><span class="font-semibold">Traitement:</span> {{ selectedTreatment?.name }}</p>
          <p class="text-sm text-gray-600"><span class="font-semibold">Date:</span> {{ formatDateTime(reservationData.date_debut) }}</p>
          <p class="text-sm text-gray-600"><span class="font-semibold">Durée:</span> {{ durationMinutes }} minutes</p>
          <p class="text-sm text-gray-600"><span class="font-semibold">Total:</span> {{ totalPrice }}€</p>
        </div>
        <button 
          @click="closeConfirmation"
          class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition"
        >
          OK
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue'
/* import { useRouter } from 'vue-router'

const router = useRouter() */

// Interfaces
interface Treatment {
  id: number
  name: string
  description: string
  duration: number
  price: number
  category: string
}

interface Therapist {
  id: number
  name: string
  specialty: string
  experience: number
  available: boolean
}

interface Option {
  id: number
  name: string
  description: string
  price: number
}

interface ReservationData {
  treatment_id: number | null
  date_debut: string
  date_fin: string
  therapist_id: number | null
  options: number[]
  special_requests: string
}

interface Errors {
  treatment_id?: string
  date_debut?: string
  date_fin?: string
}

// Treatments data
const treatments = ref<Treatment[]>([
  {
    id: 1,
    name: 'Massage Relaxant aux Huiles Essentielles',
    description: 'Un massage doux qui combine des techniques suédoises et des huiles essentielles pour une relaxation profonde.',
    duration: 60,
    price: 120,
    category: 'Massage'
  },
  {
    id: 2,
    name: 'Soin du Visage Anti-Âge',
    description: 'Un soin complet utilisant des produits naturels pour revitaliser et rajeunir votre peau.',
    duration: 60,
    price: 95,
    category: 'Soin visage'
  },
  {
    id: 3,
    name: 'Soin Hammam & Gommage',
    description: 'Un rituel traditionnel incluant hammam, gommage au savon noir et modelage relaxant.',
    duration: 90,
    price: 150,
    category: 'Hammam'
  },
  {
    id: 4,
    name: 'Massage Sportif',
    description: 'Massage ciblé pour soulager les tensions musculaires et améliorer la récupération.',
    duration: 60,
    price: 110,
    category: 'Massage'
  },
  {
    id: 5,
    name: 'Rituel Bien-être Complet',
    description: 'Une expérience unique combinant soin du corps, massage et moment de méditation.',
    duration: 120,
    price: 180,
    category: 'Rituel'
  },
  {
    id: 6,
    name: 'Soin Express Détente',
    description: 'Une pause bien-être rapide pour se ressourcer pendant la journée.',
    duration: 30,
    price: 70,
    category: 'Soin'
  }
])

// Therapists data
const therapists = ref<Therapist[]>([
  { id: 1, name: 'Sophie Martin', specialty: 'Massothérapeute certifiée', experience: 8, available: true },
  { id: 2, name: 'Marie Lambert', specialty: 'Esthéticienne spécialisée', experience: 12, available: true },
  { id: 3, name: 'Fatima Zahra', specialty: 'Spécialiste hammam', experience: 15, available: true },
  { id: 4, name: 'Thomas Dubois', specialty: 'Kinésithérapeute du sport', experience: 10, available: true },
  { id: 5, name: 'Julie Renard', specialty: 'Thérapeute bien-être', experience: 7, available: true }
])

// Additional options
const additionalOptions = ref<Option[]>([
  { id: 1, name: 'Aromathérapie', description: 'Huiles essentielles personnalisées', price: 15 },
  { id: 2, name: 'Musique personnalisée', description: 'Playlist selon vos préférences', price: 10 },
  { id: 3, name: 'Champagne offert', description: 'Coupe de champagne après le soin', price: 25 },
  { id: 4, name: 'Prolongation 30 min', description: '30 minutes supplémentaires', price: 40 },
  { id: 5, name: 'Soin des pieds', description: 'Pédicure et massage des pieds', price: 30 }
])

// Reactive data
const reservationData = reactive<ReservationData>({
  treatment_id: null,
  date_debut: '',
  date_fin: '',
  therapist_id: null,
  options: [],
  special_requests: ''
})

const errors = reactive<Errors>({})
const loading = ref(false)
const showConfirmation = ref(false)
const reservationNumber = ref('')

// Computed properties
const selectedTreatment = computed(() => {
  if (!reservationData.treatment_id) return null
  return treatments.value.find(t => t.id === reservationData.treatment_id)
})

const selectedTherapist = computed(() => {
  if (!reservationData.therapist_id) return null
  return therapists.value.find(t => t.id === reservationData.therapist_id)
})

const selectedOptionsList = computed(() => {
  return additionalOptions.value.filter(opt => reservationData.options.includes(opt.id))
})

const optionsTotal = computed(() => {
  return selectedOptionsList.value.reduce((sum, opt) => sum + opt.price, 0)
})

const totalPrice = computed(() => {
  return (selectedTreatment.value?.price || 0) + optionsTotal.value
})

const durationMinutes = computed(() => {
  if (!reservationData.date_debut || !reservationData.date_fin) return 0
  
  const start = new Date(reservationData.date_debut)
  const end = new Date(reservationData.date_fin)
  const diffMs = end.getTime() - start.getTime()
  const diffMins = Math.floor(diffMs / 60000)
  
  return diffMins > 0 ? diffMins : 0
})

const minDateTime = computed(() => {
  const now = new Date()
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
  return now.toISOString().slice(0, 16)
})

// Methods
const formatDateTime = (dateTime: string) => {
  if (!dateTime) return ''
  const date = new Date(dateTime)
  return date.toLocaleString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const updateTreatmentDetails = () => {
  // Reset date_fin when treatment changes
  if (reservationData.date_debut && selectedTreatment.value) {
    calculateDateFin()
  }
}

const calculateDateFin = () => {
  if (reservationData.date_debut && selectedTreatment.value) {
    const startDate = new Date(reservationData.date_debut)
    const endDate = new Date(startDate.getTime() + (selectedTreatment.value.duration * 60000))
    reservationData.date_fin = endDate.toISOString().slice(0, 16)
    validateDates()
  }
}

const validateDates = () => {
  if (reservationData.date_debut && reservationData.date_fin) {
    const start = new Date(reservationData.date_debut)
    const end = new Date(reservationData.date_fin)
    
    if (end <= start) {
      errors.date_fin = 'La date de fin doit être après la date de début'
    } else {
      delete errors.date_fin
    }
  }
}

const updateTotalPrice = () => {
  // Price is automatically updated via computed property
}

const validateForm = (): boolean => {
  let isValid = true
  
  if (!reservationData.treatment_id) {
    errors.treatment_id = 'Veuillez sélectionner un traitement'
    isValid = false
  } else {
    delete errors.treatment_id
  }
  
  if (!reservationData.date_debut) {
    errors.date_debut = 'La date de début est requise'
    isValid = false
  } else {
    delete errors.date_debut
  }
  
  if (!reservationData.date_fin) {
    errors.date_fin = 'La date de fin est requise'
    isValid = false
  } else if (durationMinutes.value <= 0) {
    errors.date_fin = 'La date de fin doit être après la date de début'
    isValid = false
  } else {
    delete errors.date_fin
  }
  
  return isValid
}

const handleReservation = async () => {
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
    
    // Prepare reservation data
    const reservation = {
      id: Date.now(),
      number: `SPA-${Math.floor(Math.random() * 1000000)}`,
      treatment: selectedTreatment.value,
      date_debut: reservationData.date_debut,
      date_fin: reservationData.date_fin,
      duration: durationMinutes.value,
      therapist: selectedTherapist.value,
      options: selectedOptionsList.value,
      total_price: totalPrice.value,
      special_requests: reservationData.special_requests,
      status: 'confirmée',
      created_at: new Date().toISOString()
    }
    
    console.log('Spa reservation details:', reservation)
    
    // Store reservation in localStorage
    const existingReservations = JSON.parse(localStorage.getItem('spaSessions') || '[]')
    existingReservations.push(reservation)
    localStorage.setItem('spaSessions', JSON.stringify(existingReservations))
    
    // Set reservation number for confirmation
    reservationNumber.value = reservation.number
    
    // Show confirmation
    showConfirmation.value = true
    
    // Reset form
    reservationData.treatment_id = null
    reservationData.date_debut = ''
    reservationData.date_fin = ''
    reservationData.therapist_id = null
    reservationData.options = []
    reservationData.special_requests = ''
    
  } catch (error) {
    console.error('Reservation error:', error)
    alert('Une erreur est survenue lors de la réservation. Veuillez réessayer.')
  } finally {
    loading.value = false
  }
}

const closeConfirmation = () => {
  showConfirmation.value = false
  reservationNumber.value = ''
/*   router.push('/check-spa')
 */}

// Set default minimum date
onMounted(() => {
  const now = new Date()
  now.setHours(now.getHours() + 1)
  now.setMinutes(0, 0, 0)
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
  reservationData.date_debut = now.toISOString().slice(0, 16)
})
</script>

<style scoped>
/* Animations */
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
input, select, textarea, button {
  transition: all 0.3s ease;
}

input:focus, select:focus, textarea:focus {
  transform: translateY(-1px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

button:active {
  transform: scale(0.98);
}

/* Sticky sidebar */
.sticky {
  position: sticky;
  top: 2rem;
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

/* Modal animation */
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}
</style>