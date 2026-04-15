<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Réservation de Chambre</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Réservez votre séjour en quelques clics</p>
      </div>

      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Reservation Form -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-lg p-8">
            <form @submit.prevent="handleReservation" class="space-y-6">
              <!-- Room Selection -->
              <div>
                <label for="room" class="block text-sm font-medium text-gray-700 mb-2">
                  Choisissez votre chambre <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                  </div>
                  <select 
                    id="room" 
                    v-model="reservationData.roomId"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.roomId }"
                    required
                    @change="updatePrice"
                  >
                    <option value="">Sélectionnez une chambre</option>
                    <option v-for="room in availableRooms" :key="room.id" :value="room.id">
                      {{ room.name }} - {{ room.category }} - {{ room.price }}€/nuit
                    </option>
                  </select>
                </div>
                <p v-if="errors.roomId" class="mt-1 text-sm text-red-500">{{ errors.roomId }}</p>
              </div>

              <!-- Date Enter -->
              <div>
                <label for="date_enter" class="block text-sm font-medium text-gray-700 mb-2">
                  Date d'arrivée <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <input 
                    type="date" 
                    id="date_enter" 
                    v-model="reservationData.date_enter"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.date_enter }"
                    :min="minDate"
                    required
                    @change="calculateNights"
                  >
                </div>
                <p v-if="errors.date_enter" class="mt-1 text-sm text-red-500">{{ errors.date_enter }}</p>
              </div>

              <!-- Date Sortie -->
              <div>
                <label for="date_sortie" class="block text-sm font-medium text-gray-700 mb-2">
                  Date de départ <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <input 
                    type="date" 
                    id="date_sortie" 
                    v-model="reservationData.date_sortie"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.date_sortie }"
                    :min="minDepartureDate"
                    required
                    @change="calculateNights"
                  >
                </div>
                <p v-if="errors.date_sortie" class="mt-1 text-sm text-red-500">{{ errors.date_sortie }}</p>
              </div>

              <!-- Number of Guests -->
              <div>
                <label for="guests" class="block text-sm font-medium text-gray-700 mb-2">
                  Nombre de personnes <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                  </div>
                  <input 
                    type="number" 
                    id="guests" 
                    v-model="reservationData.guests"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.guests }"
                    min="1"
                    max="10"
                    required
                  >
                </div>
                <p v-if="errors.guests" class="mt-1 text-sm text-red-500">{{ errors.guests }}</p>
              </div>

              <!-- Special Requests -->
              <div>
                <label for="requests" class="block text-sm font-medium text-gray-700 mb-2">
                  Demandes spéciales (optionnel)
                </label>
                <textarea 
                  id="requests" 
                  v-model="reservationData.specialRequests"
                  rows="3" 
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                  placeholder="Lit bébé, régime alimentaire, étage préféré, etc."
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
            
            <!-- Selected Room Info -->
            <div v-if="selectedRoom" class="mb-6">
              <div class="bg-indigo-50 rounded-lg p-4 mb-4">
                <h4 class="font-semibold text-gray-900 mb-2">{{ selectedRoom.name }}</h4>
                <p class="text-sm text-gray-600 mb-1">Catégorie: {{ selectedRoom.category }}</p>
                <p class="text-sm text-gray-600">Prix: {{ selectedRoom.price }}€ / nuit</p>
              </div>
            </div>
            <div v-else class="bg-gray-50 rounded-lg p-4 mb-4 text-center text-gray-500">
              <svg class="h-12 w-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
              <p>Sélectionnez une chambre</p>
            </div>

            <!-- Dates Summary -->
            <div v-if="reservationData.date_enter && reservationData.date_sortie" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-2">Dates du séjour</h4>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <span class="text-gray-600">Arrivée:</span>
                  <span class="font-medium">{{ formatDate(reservationData.date_enter) }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Départ:</span>
                  <span class="font-medium">{{ formatDate(reservationData.date_sortie) }}</span>
                </div>
                <div class="flex justify-between pt-2 border-t">
                  <span class="text-gray-600">Nombre de nuits:</span>
                  <span class="font-semibold text-indigo-600">{{ numberOfNights }}</span>
                </div>
              </div>
            </div>

            <!-- Guests -->
            <div v-if="reservationData.guests" class="mb-6">
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Personnes:</span>
                <span class="font-medium">{{ reservationData.guests }}</span>
              </div>
            </div>

            <!-- Price Calculation -->
            <div v-if="totalPrice > 0" class="mb-6">
              <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-3">Détail du prix</h4>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Prix par nuit:</span>
                    <span>{{ roomPrice }}€</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Nombre de nuits:</span>
                    <span>{{ numberOfNights }}</span>
                  </div>
                  <div class="flex justify-between pt-2 border-t font-bold">
                    <span class="text-gray-900">Total:</span>
                    <span class="text-indigo-600 text-xl">{{ totalPrice }}€</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment Info -->
            <div class="text-xs text-gray-500 text-center mt-4">
              <p>✓ Paiement sécurisé</p>
              <p>✓ Annulation gratuite jusqu'à 48h avant l'arrivée</p>
              <p>✓ TVA incluse</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue'

// Interfaces
interface Room {
  id: number
  name: string
  category: string
  price: number
  capacity: number
  description: string
}

interface ReservationData {
  roomId: number | null
  date_enter: string
  date_sortie: string
  guests: number
  specialRequests: string
}

interface Errors {
  roomId?: string
  date_enter?: string
  date_sortie?: string
  guests?: string
}

// Available rooms data
const availableRooms = ref<Room[]>([
  {
    id: 1,
    name: 'Suite Présidentielle',
    category: 'Premium',
    price: 450,
    capacity: 4,
    description: 'Suite luxueuse avec vue panoramique'
  },
  {
    id: 2,
    name: 'Chambre Deluxe',
    category: 'Luxe',
    price: 250,
    capacity: 3,
    description: 'Chambre spacieuse avec lit king size'
  },
  {
    id: 3,
    name: 'Chambre Junior Suite',
    category: 'Confort',
    price: 320,
    capacity: 3,
    description: 'Espace séjour séparé'
  },
  {
    id: 4,
    name: 'Chambre Standard',
    category: 'Économique',
    price: 150,
    capacity: 2,
    description: 'Confortable et fonctionnelle'
  },
  {
    id: 5,
    name: 'Suite Familiale',
    category: 'Premium',
    price: 380,
    capacity: 5,
    description: 'Idéale pour les familles'
  }
])

// Reactive data
const reservationData = reactive<ReservationData>({
  roomId: null,
  date_enter: '',
  date_sortie: '',
  guests: 1,
  specialRequests: ''
})

const errors = reactive<Errors>({})
const loading = ref(false)

// Computed properties
const selectedRoom = computed(() => {
  if (!reservationData.roomId) return null
  return availableRooms.value.find(room => room.id === reservationData.roomId)
})

const roomPrice = computed(() => {
  return selectedRoom.value?.price || 0
})

const numberOfNights = computed(() => {
  if (!reservationData.date_enter || !reservationData.date_sortie) return 0
  
  const start = new Date(reservationData.date_enter)
  const end = new Date(reservationData.date_sortie)
  const diffTime = Math.abs(end.getTime() - start.getTime())
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  
  return diffDays
})

const totalPrice = computed(() => {
  return roomPrice.value * numberOfNights.value
})

const minDate = computed(() => {
  const today = new Date()
  return today.toISOString().split('T')[0]
})

const minDepartureDate = computed(() => {
  if (!reservationData.date_enter) return minDate.value
  return reservationData.date_enter
})

// Methods
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

const updatePrice = () => {
  // Price is automatically updated via computed properties
  console.log('Room selected:', selectedRoom.value)
}

const calculateNights = () => {
  // Nights are automatically calculated via computed properties
  if (reservationData.date_enter && reservationData.date_sortie) {
    if (numberOfNights.value <= 0) {
      errors.date_sortie = 'La date de départ doit être après la date d\'arrivée'
    } else {
      delete errors.date_sortie
    }
  }
}

const validateForm = (): boolean => {
  let isValid = true
  
  // Validate room selection
  if (!reservationData.roomId) {
    errors.roomId = 'Veuillez sélectionner une chambre'
    isValid = false
  } else {
    delete errors.roomId
  }
  
  // Validate date_enter
  if (!reservationData.date_enter) {
    errors.date_enter = 'La date d\'arrivée est requise'
    isValid = false
  } else {
    delete errors.date_enter
  }
  
  // Validate date_sortie
  if (!reservationData.date_sortie) {
    errors.date_sortie = 'La date de départ est requise'
    isValid = false
  } else if (numberOfNights.value <= 0) {
    errors.date_sortie = 'La date de départ doit être après la date d\'arrivée'
    isValid = false
  } else {
    delete errors.date_sortie
  }
  
  // Validate guests
  if (!reservationData.guests || reservationData.guests < 1) {
    errors.guests = 'Le nombre de personnes doit être au moins 1'
    isValid = false
  } else if (selectedRoom.value && reservationData.guests > selectedRoom.value.capacity) {
    errors.guests = `Cette chambre peut accueillir maximum ${selectedRoom.value.capacity} personnes`
    isValid = false
  } else {
    delete errors.guests
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
      room: selectedRoom.value,
      date_enter: reservationData.date_enter,
      date_sortie: reservationData.date_sortie,
      prix: totalPrice.value,
      guests: reservationData.guests,
      specialRequests: reservationData.specialRequests,
      numberOfNights: numberOfNights.value,
      reservationDate: new Date().toISOString()
    }
    
    console.log('Reservation details:', reservation)
    
    // Store reservation in localStorage (example)
    const existingReservations = JSON.parse(localStorage.getItem('reservations') || '[]')
    existingReservations.push({
      id: Date.now(),
      ...reservation
    })
    localStorage.setItem('reservations', JSON.stringify(existingReservations))
    
    // Success message
    alert(`Réservation confirmée !\n\nTotal à payer: ${totalPrice.value}€\nNombre de nuits: ${numberOfNights.value}\nChambre: ${selectedRoom.value?.name}\nDates: ${formatDate(reservationData.date_enter)} au ${formatDate(reservationData.date_sortie)}\n\nMerci pour votre confiance !`)
    
    // Reset form
    reservationData.roomId = null
    reservationData.date_enter = ''
    reservationData.date_sortie = ''
    reservationData.guests = 1
    reservationData.specialRequests = ''
    
  } catch (error) {
    console.error('Reservation error:', error)
    alert('Une erreur est survenue lors de la réservation. Veuillez réessayer.')
  } finally {
    loading.value = false
  }
}

// Set minimum date on mount
onMounted(() => {
  const today = new Date()
  const tomorrow = new Date(today)
  tomorrow.setDate(tomorrow.getDate() + 1)
  
  // Optionally set default values
  // reservationData.date_enter = today.toISOString().split('T')[0]
  // reservationData.date_sortie = tomorrow.toISOString().split('T')[0]
})
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
input, select, textarea, button {
  transition: all 0.3s ease;
}

input:focus, select:focus, textarea:focus {
  transform: translateY(-1px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
</style>