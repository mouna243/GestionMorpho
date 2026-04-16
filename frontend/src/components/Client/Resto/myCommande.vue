<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Mes Commandes</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Consultez et gérez toutes vos commandes culinaires</p>
      </div>

      <!-- Search & Filters -->
      <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="grid md:grid-cols-4 gap-4">
          <!-- Search by Order Number -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher par numéro</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
              <input 
                type="text" 
                v-model="searchQuery"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="CMD-123456"
              >
            </div>
          </div>

          <!-- Filter by Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
            <select v-model="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="all">Tous les statuts</option>
              <option value="confirmée">Confirmée</option>
              <option value="en_preparation">En préparation</option>
              <option value="en_livraison">En livraison</option>
              <option value="livrée">Livrée</option>
              <option value="annulée">Annulée</option>
            </select>
          </div>

          <!-- Filter by Date -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date de commande</label>
            <input type="date" v-model="dateFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
          </div>

          <!-- Reset Button -->
          <div class="flex items-end">
            <button @click="resetFilters" class="w-full bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 transition">
              Réinitialiser les filtres
            </button>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center">
          <div class="text-2xl font-bold text-indigo-600">{{ stats.total }}</div>
          <div class="text-sm text-gray-600">Total</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
          <div class="text-2xl font-bold text-green-600">{{ stats.confirmee }}</div>
          <div class="text-sm text-gray-600">Confirmées</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
          <div class="text-2xl font-bold text-yellow-600">{{ stats.enPreparation }}</div>
          <div class="text-sm text-gray-600">En préparation</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
          <div class="text-2xl font-bold text-blue-600">{{ stats.enLivraison }}</div>
          <div class="text-sm text-gray-600">En livraison</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
          <div class="text-2xl font-bold text-purple-600">{{ stats.livree }}</div>
          <div class="text-sm text-gray-600">Livrées</div>
        </div>
      </div>

      <!-- Orders List -->
      <div v-if="filteredOrders.length > 0" class="space-y-6">
        <div v-for="order in filteredOrders" :key="order.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
          <!-- Status Bar -->
          <div class="h-2" :class="getStatusColor(order.status)"></div>
          
          <div class="p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
              <div>
                <div class="flex items-center space-x-3 mb-2">
                  <h3 class="text-xl font-bold text-gray-900">Commande {{ order.number }}</h3>
                  <span class="px-2 py-1 rounded-full text-xs font-semibold" :class="getStatusBadge(order.status)">
                    {{ getStatusText(order.status) }}
                  </span>
                </div>
                <p class="text-sm text-gray-500">{{ formatDateTime(order.date) }}</p>
              </div>
              <div class="mt-2 md:mt-0">
                <span class="text-2xl font-bold text-indigo-600">{{ order.totalPrice }}€</span>
              </div>
            </div>

            <!-- Order Details -->
            <div class="grid md:grid-cols-2 gap-4 mb-4">
              <!-- Client Info -->
              <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex items-center mb-2">
                  <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  <span class="text-sm font-semibold text-gray-700">Client</span>
                </div>
                <p class="text-sm text-gray-600">{{ order.clientName }}</p>
                <p class="text-xs text-gray-500">{{ order.clientEmail }}</p>
              </div>

              <!-- Service Info -->
              <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex items-center mb-2">
                  <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                  <span class="text-sm font-semibold text-gray-700">Service</span>
                </div>
                <p class="text-sm text-gray-600">{{ order.serviceName }}</p>
                <p class="text-xs text-gray-500">{{ order.serviceType }}</p>
              </div>
            </div>

            <!-- Plats List -->
            <div class="mb-4">
              <div class="flex items-center mb-2">
                <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Plats commandés</span>
              </div>
              <div class="space-y-2">
                <div v-for="plat in order.plats" :key="plat.id" class="flex justify-between items-center text-sm border-b pb-2">
                  <div>
                    <span class="font-medium text-gray-800">{{ plat.nom }}</span>
                    <span class="text-gray-500 text-xs ml-2">x{{ plat.quantite }}</span>
                  </div>
                  <span class="text-gray-600">{{ plat.prix * plat.quantite }}€</span>
                </div>
                <div class="flex justify-between items-center pt-2 font-bold">
                  <span>Total</span>
                  <span class="text-indigo-600">{{ order.totalPrice }}€</span>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 pt-4 border-t">
              <button 
                @click="viewDetails(order)"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Voir détails
              </button>
              <button 
                v-if="order.status === 'confirmée' || order.status === 'en_preparation'"
                @click="trackOrder(order)"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Suivre ma commande
              </button>
              <button 
                v-if="order.status === 'confirmée'"
                @click="cancelOrder(order)"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Annuler
              </button>
              <button 
                v-if="order.status === 'livrée'"
                @click="reorder(order)"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Commander à nouveau
              </button>
              <button 
                v-if="order.status === 'livrée'"
                @click="leaveReview(order)"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Laisser un avis
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- No Results -->
      <div v-else class="text-center py-12">
        <svg class="h-24 w-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune commande trouvée</h3>
        <p class="text-gray-600">Vous n'avez pas encore de commandes ou aucune ne correspond à vos critères</p>
        <button @click="goToOrder" class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
          Passer une commande
        </button>
      </div>
    </div>

    <!-- Order Details Modal -->
    <div v-if="selectedOrder" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
      <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900">Détails de la commande</h2>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <div class="p-6">
          <div class="space-y-4">
            <!-- Order Header -->
            <div class="flex justify-between items-start">
              <div>
                <p class="text-sm text-gray-500">Numéro de commande</p>
                <p class="font-semibold text-lg">{{ selectedOrder.number }}</p>
              </div>
              <span class="px-3 py-1 rounded-full text-sm font-semibold" :class="getStatusBadge(selectedOrder.status)">
                {{ getStatusText(selectedOrder.status) }}
              </span>
            </div>

            <!-- Date -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Date de commande</h3>
              <p class="text-gray-600">{{ formatDateTime(selectedOrder.date) }}</p>
            </div>

            <!-- Client Info -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Informations client</h3>
              <div class="bg-gray-50 rounded-lg p-3">
                <p class="font-medium">{{ selectedOrder.clientName }}</p>
                <p class="text-sm text-gray-600">{{ selectedOrder.clientEmail }}</p>
                <p v-if="selectedOrder.clientPhone" class="text-sm text-gray-600">{{ selectedOrder.clientPhone }}</p>
              </div>
            </div>

            <!-- Service Info -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Service</h3>
              <div class="bg-gray-50 rounded-lg p-3">
                <p class="font-medium">{{ selectedOrder.serviceName }}</p>
                <p class="text-sm text-gray-600">{{ selectedOrder.serviceType }}</p>
              </div>
            </div>

            <!-- Plats -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Plats commandés</h3>
              <div class="space-y-2">
                <div v-for="plat in selectedOrder.plats" :key="plat.id" class="flex justify-between items-center border-b pb-2">
                  <div>
                    <span class="font-medium">{{ plat.nom }}</span>
                    <span class="text-gray-500 text-sm ml-2">x{{ plat.quantite }}</span>
                  </div>
                  <span>{{ plat.prix * plat.quantite }}€</span>
                </div>
                <div class="flex justify-between items-center pt-2 font-bold">
                  <span>Total</span>
                  <span class="text-indigo-600 text-lg">{{ selectedOrder.totalPrice }}€</span>
                </div>
              </div>
            </div>

            <!-- Delivery Info -->
            <div v-if="selectedOrder.deliveryAddress" class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Adresse de livraison</h3>
              <p class="text-gray-600">{{ selectedOrder.deliveryAddress }}</p>
            </div>

            <!-- Special Requests -->
            <div v-if="selectedOrder.specialRequests" class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Instructions spéciales</h3>
              <p class="text-gray-600">{{ selectedOrder.specialRequests }}</p>
            </div>

            <!-- Timeline -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-3">Suivi de commande</h3>
              <div class="space-y-3">
                <div v-for="(step, index) in orderTimeline" :key="index" class="flex items-start">
                  <div class="flex-shrink-0">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" :class="getTimelineIconColor(step.status, selectedOrder.status)">
                      <svg v-if="isStepCompleted(step.status, selectedOrder.status)" class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg>
                      <span v-else class="text-xs font-bold" :class="getTimelineNumberColor(step.status, selectedOrder.status)">{{ index + 1 }}</span>
                    </div>
                  </div>
                  <div class="ml-3 flex-1">
                    <p class="font-medium text-gray-900">{{ step.title }}</p>
                    <p class="text-sm text-gray-500">{{ step.description }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="border-t p-6 bg-gray-50 flex gap-3">
          <button @click="closeModal" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
            Fermer
          </button>
          <button v-if="selectedOrder.status === 'livrée'" @click="reorder(selectedOrder)" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Commander à nouveau
          </button>
        </div>
      </div>
    </div>

    <!-- Tracking Modal -->
    <div v-if="showTracking" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeTracking">
      <div class="bg-white rounded-lg max-w-md w-full p-6">
        <div class="text-center mb-4">
          <div class="animate-pulse">
            <div class="inline-block">
              <svg class="h-16 w-16 text-indigo-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mt-2">Commande en cours</h3>
          <p class="text-gray-600 mt-1">Votre commande est en cours de préparation</p>
        </div>
        
        <div class="space-y-3 mb-6">
          <div class="flex items-center justify-between text-sm">
            <span class="text-gray-600">Statut actuel:</span>
            <span class="font-semibold text-indigo-600">{{ getStatusText(trackingOrder?.status || '') }}</span>
          </div>
          <div class="flex items-center justify-between text-sm">
            <span class="text-gray-600">Temps estimé:</span>
            <span class="font-semibold">20-30 minutes</span>
          </div>
          <div class="flex items-center justify-between text-sm">
            <span class="text-gray-600">Commande N°:</span>
            <span class="font-semibold">{{ trackingOrder?.number }}</span>
          </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <div class="flex justify-between text-sm">
            <span>Confirmée</span>
            <span>Préparation</span>
            <span>Livraison</span>
            <span>Livrée</span>
          </div>
          <div class="relative mt-2">
            <div class="h-2 bg-gray-200 rounded-full">
              <div class="h-2 bg-indigo-600 rounded-full" :style="{ width: getProgressWidth(trackingOrder?.status || '') }"></div>
            </div>
          </div>
        </div>

        <button @click="closeTracking" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
          OK
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'


// Interfaces
interface Plat {
  id: number
  nom: string
  prix: number
  quantite: number
}

interface Order {
  id: number
  number: string
  date: string
  clientName: string
  clientEmail: string
  clientPhone?: string
  serviceName: string
  serviceType: string
  plats: Plat[]
  totalPrice: number
  status: 'confirmée' | 'en_preparation' | 'en_livraison' | 'livrée' | 'annulée'
  deliveryAddress?: string
  specialRequests?: string
  createdAt: string
}

// Filters
const searchQuery = ref('')
const statusFilter = ref('all')
const dateFilter = ref('')

// Selected order for modal
const selectedOrder = ref<Order | null>(null)
const showTracking = ref(false)
const trackingOrder = ref<Order | null>(null)

// Order timeline steps
const orderTimeline = [
  { status: 'confirmée', title: 'Commande confirmée', description: 'Votre commande a été validée' },
  { status: 'en_preparation', title: 'En préparation', description: 'Notre chef prépare vos plats' },
  { status: 'en_livraison', title: 'En livraison', description: 'Votre commande est en chemin' },
  { status: 'livrée', title: 'Commandée livrée', description: 'Bon appétit !' }
]

// Mock orders data
const orders = ref<Order[]>([
  {
    id: 1,
    number: 'CMD-123456',
    date: '2024-12-20T19:30:00',
    clientName: 'Jean Dupont',
    clientEmail: 'jean.dupont@email.com',
    clientPhone: '+33 6 12 34 56 78',
    serviceName: 'Room Service',
    serviceType: 'Chambre 405',
    plats: [
      { id: 1, nom: 'Boeuf Bourguignon', prix: 28, quantite: 2 },
      { id: 2, nom: 'Tiramisu', prix: 9, quantite: 1 }
    ],
    totalPrice: 65,
    status: 'livrée',
    specialRequests: 'Sans oignons pour le boeuf',
    createdAt: '2024-12-20T19:30:00'
  },
  {
    id: 2,
    number: 'CMD-789012',
    date: '2024-12-21T12:15:00',
    clientName: 'Marie Martin',
    clientEmail: 'marie.martin@email.com',
    serviceName: 'Restaurant',
    serviceType: 'Sur place - Table 12',
    plats: [
      { id: 3, nom: 'Saumon Grillé', prix: 24, quantite: 1 },
      { id: 4, nom: 'Salade César', prix: 12, quantite: 1 },
      { id: 5, nom: 'Tiramisu', prix: 9, quantite: 1 }
    ],
    totalPrice: 45,
    status: 'confirmée',
    createdAt: '2024-12-21T12:15:00'
  },
  {
    id: 3,
    number: 'CMD-345678',
    date: '2024-12-21T18:45:00',
    clientName: 'Pierre Durand',
    clientEmail: 'pierre.durand@email.com',
    serviceName: 'Takeaway',
    serviceType: 'À emporter',
    plats: [
      { id: 6, nom: 'Poulet Tandoori', prix: 22, quantite: 2 },
      { id: 7, nom: 'Risotto aux Champignons', prix: 18, quantite: 1 }
    ],
    totalPrice: 62,
    status: 'en_preparation',
    deliveryAddress: 'À emporter - Restaurant',
    createdAt: '2024-12-21T18:45:00'
  },
  {
    id: 4,
    number: 'CMD-901234',
    date: '2024-12-22T13:00:00',
    clientName: 'Sophie Bernard',
    clientEmail: 'sophie.bernard@email.com',
    clientPhone: '+33 6 78 90 12 34',
    serviceName: 'Livraison',
    serviceType: 'Domicile',
    plats: [
      { id: 8, nom: 'Magret de Canard', prix: 32, quantite: 1 },
      { id: 9, nom: 'Soupe à l\'Oignon', prix: 10, quantite: 2 },
      { id: 10, nom: 'Tiramisu', prix: 9, quantite: 2 }
    ],
    totalPrice: 61,
    status: 'en_livraison',
    deliveryAddress: '15 Rue de Paris, 75001 Paris',
    specialRequests: 'Sonnette à l\'étage',
    createdAt: '2024-12-22T13:00:00'
  },
  {
    id: 5,
    number: 'CMD-567890',
    date: '2024-12-20T20:00:00',
    clientName: 'Lucas Petit',
    clientEmail: 'lucas.petit@email.com',
    serviceName: 'Room Service',
    serviceType: 'Chambre 210',
    plats: [
      { id: 11, nom: 'Salade Niçoise', prix: 14, quantite: 1 }
    ],
    totalPrice: 14,
    status: 'annulée',
    createdAt: '2024-12-20T20:00:00'
  }
])

// Computed: Filtered orders
const filteredOrders = computed(() => {
  let filtered = [...orders.value]
  
  // Filter by search query (order number)
  if (searchQuery.value.trim()) {
    filtered = filtered.filter(o => 
      o.number.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }
  
  // Filter by status
  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(o => o.status === statusFilter.value)
  }
  
  // Filter by date
  if (dateFilter.value) {
    filtered = filtered.filter(o => o.date.split('T')[0] === dateFilter.value)
  }
  
  // Sort by date (most recent first)
  filtered.sort((a, b) => new Date(b.createdAt).getTime() - new Date(a.createdAt).getTime())
  
  return filtered
})

// Stats
const stats = computed(() => {
  return {
    total: orders.value.length,
    confirmee: orders.value.filter(o => o.status === 'confirmée').length,
    enPreparation: orders.value.filter(o => o.status === 'en_preparation').length,
    enLivraison: orders.value.filter(o => o.status === 'en_livraison').length,
    livree: orders.value.filter(o => o.status === 'livrée').length
  }
})

// Helper functions
const formatDateTime = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getStatusColor = (status: string) => {
  const colors = {
    confirmée: 'bg-green-500',
    en_preparation: 'bg-yellow-500',
    en_livraison: 'bg-blue-500',
    livrée: 'bg-purple-500',
    annulée: 'bg-red-500'
  }
  return colors[status as keyof typeof colors] || 'bg-gray-500'
}

const getStatusBadge = (status: string) => {
  const badges = {
    confirmée: 'bg-green-100 text-green-800',
    en_preparation: 'bg-yellow-100 text-yellow-800',
    en_livraison: 'bg-blue-100 text-blue-800',
    livrée: 'bg-purple-100 text-purple-800',
    annulée: 'bg-red-100 text-red-800'
  }
  return badges[status as keyof typeof badges] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status: string) => {
  const texts = {
    confirmée: 'Confirmée',
    en_preparation: 'En préparation',
    en_livraison: 'En livraison',
    livrée: 'Livrée',
    annulée: 'Annulée'
  }
  return texts[status as keyof typeof texts] || status
}

const getTimelineIconColor = (stepStatus: string, orderStatus: string) => {
  const stepOrder = ['confirmée', 'en_preparation', 'en_livraison', 'livrée']
  const stepIndex = stepOrder.indexOf(stepStatus)
  const orderIndex = stepOrder.indexOf(orderStatus)
  
  if (orderIndex >= stepIndex) {
    return 'bg-green-500'
  }
  return 'bg-gray-300'
}

const getTimelineNumberColor = (stepStatus: string, orderStatus: string) => {
  const stepOrder = ['confirmée', 'en_preparation', 'en_livraison', 'livrée']
  const stepIndex = stepOrder.indexOf(stepStatus)
  const orderIndex = stepOrder.indexOf(orderStatus)
  
  if (orderIndex >= stepIndex) {
    return 'text-white'
  }
  return 'text-gray-500'
}

const isStepCompleted = (stepStatus: string, orderStatus: string) => {
  const stepOrder = ['confirmée', 'en_preparation', 'en_livraison', 'livrée']
  const stepIndex = stepOrder.indexOf(stepStatus)
  const orderIndex = stepOrder.indexOf(orderStatus)
  
  return orderIndex >= stepIndex
}

const getProgressWidth = (status: string) => {
  const widths = {
    confirmée: '25%',
    en_preparation: '50%',
    en_livraison: '75%',
    livrée: '100%'
  }
  return widths[status as keyof typeof widths] || '0%'
}

// Actions
const resetFilters = () => {
  searchQuery.value = ''
  statusFilter.value = 'all'
  dateFilter.value = ''
}

const viewDetails = (order: Order) => {
  selectedOrder.value = order
}

const closeModal = () => {
  selectedOrder.value = null
}

const trackOrder = (order: Order) => {
  trackingOrder.value = order
  showTracking.value = true
}

const closeTracking = () => {
  showTracking.value = false
  trackingOrder.value = null
}

const cancelOrder = (order: Order) => {
  if (confirm(`Êtes-vous sûr de vouloir annuler la commande ${order.number} ?`)) {
    const index = orders.value.findIndex(o => o.id === order.id)
    if (index !== -1) {
      orders.value[index].status = 'annulée'
      alert(`La commande ${order.number} a été annulée avec succès.`)
    }
  }
}

const reorder = (order: Order) => {
  // Store the plats for reordering
  localStorage.setItem('reorderData', JSON.stringify(order.plats))
}

const leaveReview = (order: Order) => {
  alert(`Vous allez laisser un avis pour la commande ${order.number}\n\nCette fonctionnalité sera disponible prochainement.`)
}

const goToOrder = () => {
}

// Load any existing orders from localStorage
onMounted(() => {
  const savedOrders = localStorage.getItem('orders')
  if (savedOrders) {
    try {
      const parsed = JSON.parse(savedOrders)
      // Convert stored orders to match our format
      const converted = parsed.map((o: any, index: number) => ({
        id: o.id || Date.now() + index,
        number: o.number || `CMD-${Math.floor(Math.random() * 1000000)}`,
        date: o.date || new Date().toISOString(),
        clientName: 'Client',
        clientEmail: 'client@email.com',
        serviceName: o.serviceName || 'Restaurant',
        serviceType: o.serviceType || 'Sur place',
        plats: o.plat_id?.map((p: any) => ({
          id: p.id,
          nom: p.nom || 'Plat',
          prix: p.prix || 0,
          quantite: p.quantite || 1
        })) || [],
        totalPrice: o.prix || 0,
        status: 'confirmée',
        createdAt: new Date().toISOString()
      }))
      
      // Merge with existing orders
      orders.value = [...converted, ...orders.value]
    } catch (e) {
      console.error('Error loading orders:', e)
    }
  }
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

/* Hover effects */
.hover\:shadow-xl:hover {
  transform: translateY(-2px);
}

/* Modal scrollbar */
.overflow-y-auto::-webkit-scrollbar {
  width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* Print styles */
@media print {
  button, .filters, .stats-cards {
    display: none !important;
  }
}

/* Animation for tracking */
@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.animate-bounce {
  animation: bounce 1s infinite;
}
</style>