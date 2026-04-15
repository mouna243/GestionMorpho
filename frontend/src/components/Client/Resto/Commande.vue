<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Passer une Commande</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Commandez vos plats préférés en quelques clics</p>
      </div>

      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Order Form -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-lg p-8">
            <form @submit.prevent="handleOrder" class="space-y-6">
              <!-- Date Field -->
              <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                  Date de commande <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <input 
                    type="datetime-local" 
                    id="date" 
                    v-model="orderData.date"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.date }"
                    :min="minDateTime"
                    required
                  >
                </div>
                <p v-if="errors.date" class="mt-1 text-sm text-red-500">{{ errors.date }}</p>
              </div>

              <!-- Client Selection -->
              <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                  Client <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                  <select 
                    id="client_id" 
                    v-model="orderData.client_id"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.client_id }"
                    required
                  >
                    <option value="">Sélectionnez un client</option>
                    <option v-for="client in clients" :key="client.id" :value="client.id">
                      {{ client.nom }} - {{ client.email }}
                    </option>
                  </select>
                </div>
                <p v-if="errors.client_id" class="mt-1 text-sm text-red-500">{{ errors.client_id }}</p>
              </div>

              <!-- Service Selection -->
              <div>
                <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">
                  Service <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  <select 
                    id="service_id" 
                    v-model="orderData.service_id"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                    :class="{ 'border-red-500': errors.service_id }"
                    required
                  >
                    <option value="">Sélectionnez un service</option>
                    <option v-for="service in services" :key="service.id" :value="service.id">
                      {{ service.nom }} - {{ service.type }}
                    </option>
                  </select>
                </div>
                <p v-if="errors.service_id" class="mt-1 text-sm text-red-500">{{ errors.service_id }}</p>
              </div>

              <!-- Plat Selection (Multiple) -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Plats <span class="text-red-500">*</span>
                </label>
                <div class="space-y-3">
                  <div v-for="(plat, index) in orderData.plat_id" :key="index" class="flex gap-2">
                    <div class="flex-1 relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                      </div>
                      <select 
                        v-model="plat.plat_id"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        :class="{ 'border-red-500': errors.plat_id && index === orderData.plat_id.length - 1 }"
                        required
                        @change="updateTotalPrice"
                      >
                        <option value="">Sélectionnez un plat</option>
                        <option v-for="platItem in availablePlats" :key="platItem.id" :value="platItem.id">
                          {{ platItem.nom }} - {{ platItem.prix }}€
                        </option>
                      </select>
                    </div>
                    <div class="w-24">
                      <input 
                        type="number" 
                        v-model="plat.quantite"
                        min="1"
                        max="10"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-center"
                        placeholder="Qté"
                        @change="updateTotalPrice"
                      >
                    </div>
                    <button 
                      v-if="orderData.plat_id.length > 1"
                      type="button"
                      @click="removePlat(index)"
                      class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                    >
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>
                  <button 
                    type="button"
                    @click="addPlat"
                    class="w-full py-2 border-2 border-dashed border-indigo-300 text-indigo-600 rounded-lg hover:border-indigo-600 hover:bg-indigo-50 transition"
                  >
                    + Ajouter un autre plat
                  </button>
                </div>
                <p v-if="errors.plat_id" class="mt-1 text-sm text-red-500">{{ errors.plat_id }}</p>
              </div>

              <!-- Submit Button -->
              <button 
                type="submit" 
                class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105"
                :disabled="loading"
              >
                <span v-if="!loading">Confirmer la commande</span>
                <span v-else class="flex items-center justify-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Commande en cours...
                </span>
              </button>
            </form>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-lg p-8 sticky top-24">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Résumé de la commande</h3>
            
            <!-- Selected Items -->
            <div v-if="orderData.plat_id.length > 0 && orderData.plat_id.some(p => p.plat_id)" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-3">Plats commandés</h4>
              <div class="space-y-3">
                <template v-for="(plat, index) in orderData.plat_id" :key="index">
                  <div v-if="plat.plat_id" class="flex justify-between text-sm">
                    <div>
                      <span class="text-gray-600">{{ getPlatName(plat.plat_id) }}</span>
                      <span class="text-gray-500 text-xs ml-1">x{{ plat.quantite }}</span>
                    </div>
                    <span class="font-medium">{{ getPlatPrice(plat.plat_id) * plat.quantite }}€</span>
                  </div>
                </template>
              </div>
            </div>

            <!-- Client Info -->
            <div v-if="orderData.client_id" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-2">Client</h4>
              <div class="bg-gray-50 rounded-lg p-3 text-sm">
                <p class="font-medium">{{ getClientName(orderData.client_id) }}</p>
                <p class="text-gray-600">{{ getClientEmail(orderData.client_id) }}</p>
              </div>
            </div>

            <!-- Service Info -->
            <div v-if="orderData.service_id" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-2">Service</h4>
              <div class="bg-gray-50 rounded-lg p-3 text-sm">
                <p class="font-medium">{{ getServiceName(orderData.service_id) }}</p>
                <p class="text-gray-600">{{ getServiceType(orderData.service_id) }}</p>
              </div>
            </div>

            <!-- Date Info -->
            <div v-if="orderData.date" class="mb-6">
              <h4 class="font-semibold text-gray-900 mb-2">Date de commande</h4>
              <div class="bg-gray-50 rounded-lg p-3 text-sm">
                <p>{{ formatDateTime(orderData.date) }}</p>
              </div>
            </div>

            <!-- Total Price -->
            <div class="border-t pt-4">
              <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Sous-total:</span>
                <span class="font-medium">{{ calculateSubtotal() }}€</span>
              </div>
              <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">TVA (10%):</span>
                <span class="font-medium">{{ calculateTax() }}€</span>
              </div>
              <div class="flex justify-between items-center pt-2 border-t">
                <span class="text-lg font-bold text-gray-900">Total:</span>
                <span class="text-2xl font-bold text-indigo-600">{{ totalPrice }}€</span>
              </div>
            </div>

            <!-- Payment Info -->
            <div class="mt-6 text-xs text-gray-500 text-center">
              <p>✓ Paiement sécurisé</p>
              <p>✓ Livraison gratuite</p>
              <p>✓ Service client 24/7</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Order Confirmation Modal -->
    <div v-if="showConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeConfirmation">
      <div class="bg-white rounded-lg max-w-md w-full p-6 text-center">
        <div class="mb-4">
          <div class="mx-auto h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Commande confirmée !</h3>
        <p class="text-gray-600 mb-4">
          Votre commande a été enregistrée avec succès.<br>
          Numéro de commande: <span class="font-semibold text-indigo-600">{{ orderNumber }}</span>
        </p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-left">
          <p class="text-sm text-gray-600"><span class="font-semibold">Total:</span> {{ totalPrice }}€</p>
          <p class="text-sm text-gray-600"><span class="font-semibold">Date:</span> {{ formatDateTime(orderData.date) }}</p>
          <p class="text-sm text-gray-600"><span class="font-semibold">Client:</span> {{ getClientName(orderData.client_id) }}</p>
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

// Interfaces
interface Client {
  id: number
  nom: string
  email: string
  telephone: string
}

interface Service {
  id: number
  nom: string
  type: string
  prix: number
}

interface Plat {
  id: number
  nom: string
  prix: number
  categorie: string
}

interface OrderPlat {
  plat_id: number | null
  quantite: number
}

interface OrderData {
  date: string
  client_id: number | null
  service_id: number | null
  plat_id: OrderPlat[]
}

interface Errors {
  date?: string
  client_id?: string
  service_id?: string
  plat_id?: string
}

// Mock data
const clients = ref<Client[]>([
  { id: 1, nom: 'Jean Dupont', email: 'jean.dupont@email.com', telephone: '0612345678' },
  { id: 2, nom: 'Marie Martin', email: 'marie.martin@email.com', telephone: '0698765432' },
  { id: 3, nom: 'Pierre Durand', email: 'pierre.durand@email.com', telephone: '0654321890' },
  { id: 4, nom: 'Sophie Bernard', email: 'sophie.bernard@email.com', telephone: '0789012345' }
])

const services = ref<Service[]>([
  { id: 1, nom: 'Room Service', type: 'Chambre', prix: 5 },
  { id: 2, nom: 'Restaurant', type: 'Sur place', prix: 0 },
  { id: 3, nom: 'Takeaway', type: 'À emporter', prix: 0 },
  { id: 4, nom: 'Livraison', type: 'Domicile', prix: 8 }
])

const availablePlats = ref<Plat[]>([
  { id: 1, nom: 'Salade César', prix: 12, categorie: 'Entrée' },
  { id: 2, nom: 'Boeuf Bourguignon', prix: 28, categorie: 'Plat' },
  { id: 3, nom: 'Saumon Grillé', prix: 24, categorie: 'Plat' },
  { id: 4, nom: 'Risotto aux Champignons', prix: 18, categorie: 'Plat' },
  { id: 5, nom: 'Poulet Tandoori', prix: 22, categorie: 'Plat' },
  { id: 6, nom: 'Tiramisu', prix: 9, categorie: 'Dessert' },
  { id: 7, nom: 'Soupe à l\'Oignon', prix: 10, categorie: 'Entrée' },
  { id: 8, nom: 'Magret de Canard', prix: 32, categorie: 'Plat' }
])

// Reactive data
const orderData = reactive<OrderData>({
  date: '',
  client_id: null,
  service_id: null,
  plat_id: [{ plat_id: null, quantite: 1 }]
})

const errors = reactive<Errors>({})
const loading = ref(false)
const showConfirmation = ref(false)
const orderNumber = ref('')

// Computed properties
const minDateTime = computed(() => {
  const now = new Date()
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
  return now.toISOString().slice(0, 16)
})

const totalPrice = computed(() => {
  return calculateSubtotal() + calculateTax()
})

// Methods
const getPlatName = (platId: number | null) => {
  const plat = availablePlats.value.find(p => p.id === platId)
  return plat ? plat.nom : ''
}

const getPlatPrice = (platId: number | null) => {
  const plat = availablePlats.value.find(p => p.id === platId)
  return plat ? plat.prix : 0
}

const getClientName = (clientId: number | null) => {
  const client = clients.value.find(c => c.id === clientId)
  return client ? client.nom : ''
}

const getClientEmail = (clientId: number | null) => {
  const client = clients.value.find(c => c.id === clientId)
  return client ? client.email : ''
}

const getServiceName = (serviceId: number | null) => {
  const service = services.value.find(s => s.id === serviceId)
  return service ? service.nom : ''
}

const getServiceType = (serviceId: number | null) => {
  const service = services.value.find(s => s.id === serviceId)
  return service ? service.type : ''
}

const calculateSubtotal = () => {
  let subtotal = 0
  orderData.plat_id.forEach(item => {
    if (item.plat_id && item.quantite) {
      subtotal += getPlatPrice(item.plat_id) * item.quantite
    }
  })
  return subtotal
}

const calculateTax = () => {
  return parseFloat((calculateSubtotal() * 0.1).toFixed(2))
}

const updateTotalPrice = () => {
  // Price is automatically updated via computed property
}

const addPlat = () => {
  orderData.plat_id.push({ plat_id: null, quantite: 1 })
}

const removePlat = (index: number) => {
  orderData.plat_id.splice(index, 1)
}

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

const validateForm = (): boolean => {
  let isValid = true
  
  // Validate date
  if (!orderData.date) {
    errors.date = 'La date de commande est requise'
    isValid = false
  } else {
    delete errors.date
  }
  
  // Validate client
  if (!orderData.client_id) {
    errors.client_id = 'Veuillez sélectionner un client'
    isValid = false
  } else {
    delete errors.client_id
  }
  
  // Validate service
  if (!orderData.service_id) {
    errors.service_id = 'Veuillez sélectionner un service'
    isValid = false
  } else {
    delete errors.service_id
  }
  
  // Validate plats
  const hasValidPlat = orderData.plat_id.some(item => item.plat_id && item.quantite > 0)
  if (!hasValidPlat) {
    errors.plat_id = 'Veuillez sélectionner au moins un plat'
    isValid = false
  } else {
    delete errors.plat_id
  }
  
  return isValid
}

const handleOrder = async () => {
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
    
    // Filter valid plats
    const validPlats = orderData.plat_id.filter(item => item.plat_id && item.quantite > 0)
    
    // Prepare order data
    const order = {
      id: Date.now(),
      date: orderData.date,
      client_id: orderData.client_id,
      service_id: orderData.service_id,
      plat_id: validPlats.map(p => ({
        id: p.plat_id,
        quantite: p.quantite
      })),
      prix: totalPrice.value,
      status: 'confirmée',
      createdAt: new Date().toISOString()
    }
    
    console.log('Order details:', order)
    
    // Store order in localStorage
    const existingOrders = JSON.parse(localStorage.getItem('orders') || '[]')
    existingOrders.push(order)
    localStorage.setItem('orders', JSON.stringify(existingOrders))
    
    // Generate order number
    orderNumber.value = `CMD-${Date.now()}`
    
    // Show confirmation
    showConfirmation.value = true
    
    // Reset form
    orderData.date = ''
    orderData.client_id = null
    orderData.service_id = null
    orderData.plat_id = [{ plat_id: null, quantite: 1 }]
    
  } catch (error) {
    console.error('Order error:', error)
    alert('Une erreur est survenue lors de la commande. Veuillez réessayer.')
  } finally {
    loading.value = false
  }
}

const closeConfirmation = () => {
  showConfirmation.value = false
  orderNumber.value = ''
}

// Set default date to now
onMounted(() => {
  const now = new Date()
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset())
  orderData.date = now.toISOString().slice(0, 16)
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
input, select, button {
  transition: all 0.3s ease;
}

input:focus, select:focus {
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