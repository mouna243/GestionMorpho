<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Mes Sessions Spa</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Consultez et gérez toutes vos réservations bien-être</p>
      </div>

      <!-- Search & Filters -->
      <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="grid md:grid-cols-4 gap-4">
          <!-- Search by Number -->
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
                placeholder="SPA-123456"
              >
            </div>
          </div>

          <!-- Filter by Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
            <select v-model="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="all">Tous les statuts</option>
              <option value="confirmée">Confirmée</option>
              <option value="en_attente">En attente</option>
              <option value="en_cours">En cours</option>
              <option value="terminée">Terminée</option>
              <option value="annulée">Annulée</option>
            </select>
          </div>

          <!-- Filter by Date -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date de session</label>
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
          <div class="text-2xl font-bold text-yellow-600">{{ stats.enAttente }}</div>
          <div class="text-sm text-gray-600">En attente</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
          <div class="text-2xl font-bold text-blue-600">{{ stats.enCours }}</div>
          <div class="text-sm text-gray-600">En cours</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
          <div class="text-2xl font-bold text-purple-600">{{ stats.terminee }}</div>
          <div class="text-sm text-gray-600">Terminées</div>
        </div>
      </div>

      <!-- Spa Sessions List -->
      <div v-if="filteredSessions.length > 0" class="space-y-6">
        <div v-for="session in filteredSessions" :key="session.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
          <!-- Status Bar -->
          <div class="h-2" :class="getStatusColor(session.status)"></div>
          
          <div class="p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
              <div>
                <div class="flex items-center space-x-3 mb-2">
                  <h3 class="text-xl font-bold text-gray-900">{{ session.treatmentName }}</h3>
                  <span class="px-2 py-1 rounded-full text-xs font-semibold" :class="getStatusBadge(session.status)">
                    {{ getStatusText(session.status) }}
                  </span>
                </div>
                <p class="text-sm text-gray-500">N° {{ session.number }}</p>
              </div>
              <div class="mt-2 md:mt-0">
                <span class="text-2xl font-bold text-indigo-600">{{ session.totalPrice }}€</span>
              </div>
            </div>

            <!-- Session Details -->
            <div class="grid md:grid-cols-2 gap-4 mb-4">
              <!-- Date & Time -->
              <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex items-center mb-2">
                  <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  <span class="text-sm font-semibold text-gray-700">Date & Heure</span>
                </div>
                <p class="text-sm text-gray-600">{{ formatDateTime(session.dateTime) }}</p>
                <p class="text-xs text-gray-500">Durée: {{ session.duration }} minutes</p>
              </div>

              <!-- Therapist Info -->
              <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex items-center mb-2">
                  <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  <span class="text-sm font-semibold text-gray-700">Thérapeute</span>
                </div>
                <p class="text-sm text-gray-600">{{ session.therapistName }}</p>
                <p class="text-xs text-gray-500">{{ session.therapistSpecialty }}</p>
              </div>
            </div>

            <!-- Client Info -->
            <div class="bg-gray-50 rounded-lg p-3 mb-4">
              <div class="flex items-center mb-2">
                <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Client</span>
              </div>
              <p class="text-sm text-gray-600">{{ session.clientName }}</p>
              <p class="text-xs text-gray-500">{{ session.clientEmail }}</p>
            </div>

            <!-- Options & Extras -->
            <div v-if="session.options && session.options.length > 0" class="mb-4">
              <div class="flex items-center mb-2">
                <svg class="h-4 w-4 text-indigo-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Options supplémentaires</span>
              </div>
              <div class="flex flex-wrap gap-2">
                <span v-for="option in session.options" :key="option" class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">
                  {{ option }}
                </span>
              </div>
            </div>

            <!-- Price Breakdown -->
            <div class="border-t pt-3 mb-4">
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600">Prix du traitement:</span>
                <span>{{ session.treatmentPrice }}€</span>
              </div>
              <div v-if="session.optionsPrice > 0" class="flex justify-between text-sm mb-1">
                <span class="text-gray-600">Options:</span>
                <span>{{ session.optionsPrice }}€</span>
              </div>
              <div class="flex justify-between font-bold pt-2 border-t">
                <span class="text-gray-900">Total:</span>
                <span class="text-indigo-600">{{ session.totalPrice }}€</span>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 pt-4 border-t">
              <button 
                @click="viewDetails(session)"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Voir détails
              </button>
              <button 
                v-if="session.status === 'confirmée'"
                @click="modifySession(session)"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Modifier
              </button>
              <button 
                v-if="session.status === 'confirmée'"
                @click="cancelSession(session)"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Annuler
              </button>
              <button 
                v-if="session.status === 'terminée'"
                @click="rebookSession(session)"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center"
              >
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Réserver à nouveau
              </button>
              <button 
                v-if="session.status === 'terminée'"
                @click="leaveReview(session)"
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
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune session spa trouvée</h3>
        <p class="text-gray-600">Vous n'avez pas encore de réservations spa ou aucune ne correspond à vos critères</p>
        <button @click="goToSpa" class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
          Réserver une session spa
        </button>
      </div>
    </div>

    <!-- Session Details Modal -->
    <div v-if="selectedSession" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
      <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900">Détails de la session spa</h2>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <div class="p-6">
          <div class="space-y-4">
            <!-- Session Header -->
            <div class="flex justify-between items-start">
              <div>
                <p class="text-sm text-gray-500">Numéro de réservation</p>
                <p class="font-semibold text-lg">{{ selectedSession.number }}</p>
              </div>
              <span class="px-3 py-1 rounded-full text-sm font-semibold" :class="getStatusBadge(selectedSession.status)">
                {{ getStatusText(selectedSession.status) }}
              </span>
            </div>

            <!-- Treatment Info -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Traitement</h3>
              <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-4">
                <p class="font-bold text-lg text-indigo-600">{{ selectedSession.treatmentName }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ selectedSession.treatmentDescription }}</p>
              </div>
            </div>

            <!-- Date & Time -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Date et heure</h3>
              <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-gray-600">{{ formatDateTime(selectedSession.dateTime) }}</p>
                <p class="text-sm text-gray-500 mt-1">Durée: {{ selectedSession.duration }} minutes</p>
              </div>
            </div>

            <!-- Therapist -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Thérapeute</h3>
              <div class="bg-gray-50 rounded-lg p-3">
                <p class="font-medium">{{ selectedSession.therapistName }}</p>
                <p class="text-sm text-gray-600">{{ selectedSession.therapistSpecialty }}</p>
                <p class="text-xs text-gray-500 mt-1">Expérience: {{ selectedSession.therapistExperience }} ans</p>
              </div>
            </div>

            <!-- Client Info -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Informations client</h3>
              <div class="bg-gray-50 rounded-lg p-3">
                <p class="font-medium">{{ selectedSession.clientName }}</p>
                <p class="text-sm text-gray-600">{{ selectedSession.clientEmail }}</p>
                <p v-if="selectedSession.clientPhone" class="text-sm text-gray-600">{{ selectedSession.clientPhone }}</p>
              </div>
            </div>

            <!-- Options -->
            <div v-if="selectedSession.options && selectedSession.options.length > 0" class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Options choisies</h3>
              <div class="flex flex-wrap gap-2">
                <span v-for="option in selectedSession.options" :key="option" class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm">
                  {{ option }}
                </span>
              </div>
            </div>

            <!-- Special Requests -->
            <div v-if="selectedSession.specialRequests" class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Demandes spéciales</h3>
              <p class="text-gray-600 bg-yellow-50 p-3 rounded-lg">{{ selectedSession.specialRequests }}</p>
            </div>

            <!-- Price Breakdown -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Détail du prix</h3>
              <div class="space-y-2">
                <div class="flex justify-between text-sm">
                  <span class="text-gray-600">Traitement:</span>
                  <span>{{ selectedSession.treatmentPrice }}€</span>
                </div>
                <div v-if="selectedSession.optionsPrice > 0" class="flex justify-between text-sm">
                  <span class="text-gray-600">Options:</span>
                  <span>{{ selectedSession.optionsPrice }}€</span>
                </div>
                <div class="flex justify-between pt-2 border-t font-bold">
                  <span class="text-gray-900">Total TTC:</span>
                  <span class="text-xl text-indigo-600">{{ selectedSession.totalPrice }}€</span>
                </div>
              </div>
            </div>

            <!-- Preparation Tips -->
            <div class="border-t pt-4">
              <h3 class="font-semibold text-gray-900 mb-2">Conseils de préparation</h3>
              <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                <li>Arrivez 15 minutes avant l'heure prévue</li>
                <li>Apportez votre maillot de bain</li>
                <li>Évitez de manger lourd avant la session</li>
                <li>Prévenez le thérapeute de vos éventuelles allergies</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="border-t p-6 bg-gray-50 flex gap-3">
          <button @click="closeModal" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
            Fermer
          </button>
          <button v-if="selectedSession.status === 'confirmée'" @click="modifySession(selectedSession)" class="flex-1 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
            Modifier
          </button>
          <button v-if="selectedSession.status === 'terminée'" @click="rebookSession(selectedSession)" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Réserver à nouveau
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'


// Interfaces
interface SpaSession {
  id: number
  number: string
  dateTime: string
  duration: number
  treatmentName: string
  treatmentDescription: string
  treatmentPrice: number
  therapistName: string
  therapistSpecialty: string
  therapistExperience: number
  clientName: string
  clientEmail: string
  clientPhone?: string
  options: string[]
  optionsPrice: number
  totalPrice: number
  status: 'confirmée' | 'en_attente' | 'en_cours' | 'terminée' | 'annulée'
  specialRequests?: string
  createdAt: string
}

// Filters
const searchQuery = ref('')
const statusFilter = ref('all')
const dateFilter = ref('')

// Selected session for modal
const selectedSession = ref<SpaSession | null>(null)

// Mock spa sessions data
const sessions = ref<SpaSession[]>([
  {
    id: 1,
    number: 'SPA-123456',
    dateTime: '2024-12-25T14:00:00',
    duration: 90,
    treatmentName: 'Massage Relaxant aux Huiles Essentielles',
    treatmentDescription: 'Un massage doux qui combine des techniques suédoises et des huiles essentielles pour une relaxation profonde.',
    treatmentPrice: 120,
    therapistName: 'Sophie Martin',
    therapistSpecialty: 'Massothérapeute certifiée',
    therapistExperience: 8,
    clientName: 'Jean Dupont',
    clientEmail: 'jean.dupont@email.com',
    clientPhone: '+33 6 12 34 56 78',
    options: ['Musique personnalisée', 'Aromathérapie'],
    optionsPrice: 20,
    totalPrice: 140,
    status: 'confirmée',
    specialRequests: 'Préférence pour une pression moyenne',
    createdAt: '2024-12-01T10:30:00'
  },
  {
    id: 2,
    number: 'SPA-789012',
    dateTime: '2024-12-26T10:00:00',
    duration: 60,
    treatmentName: 'Soin du Visage Anti-Âge',
    treatmentDescription: 'Un soin complet utilisant des produits naturels pour revitaliser et rajeunir votre peau.',
    treatmentPrice: 95,
    therapistName: 'Marie Lambert',
    therapistSpecialty: 'Esthéticienne spécialisée',
    therapistExperience: 12,
    clientName: 'Marie Martin',
    clientEmail: 'marie.martin@email.com',
    clientPhone: '+33 6 98 76 54 32',
    options: ['Masque hydratant', 'Modelage du cou'],
    optionsPrice: 25,
    totalPrice: 120,
    status: 'confirmée',
    createdAt: '2024-12-02T14:15:00'
  },
  {
    id: 3,
    number: 'SPA-345678',
    dateTime: '2024-12-27T16:30:00',
    duration: 120,
    treatmentName: 'Soin Hammam & Gommage',
    treatmentDescription: 'Un rituel traditionnel incluant hammam, gommage au savon noir et modelage relaxant.',
    treatmentPrice: 150,
    therapistName: 'Fatima Zahra',
    therapistSpecialty: 'Spécialiste hammam',
    therapistExperience: 15,
    clientName: 'Sophie Bernard',
    clientEmail: 'sophie.bernard@email.com',
    clientPhone: '+33 6 78 90 12 34',
    options: ['Huile d\'argan', 'Thé à la menthe'],
    optionsPrice: 15,
    totalPrice: 165,
    status: 'en_attente',
    createdAt: '2024-12-03T09:45:00'
  },
  {
    id: 4,
    number: 'SPA-901234',
    dateTime: '2024-12-20T11:00:00',
    duration: 60,
    treatmentName: 'Massage Sportif',
    treatmentDescription: 'Massage ciblé pour soulager les tensions musculaires et améliorer la récupération.',
    treatmentPrice: 110,
    therapistName: 'Thomas Dubois',
    therapistSpecialty: 'Kinésithérapeute du sport',
    therapistExperience: 10,
    clientName: 'Pierre Durand',
    clientEmail: 'pierre.durand@email.com',
    options: [],
    optionsPrice: 0,
    totalPrice: 110,
    status: 'terminée',
    createdAt: '2024-12-10T16:20:00'
  },
  {
    id: 5,
    number: 'SPA-567890',
    dateTime: '2024-12-22T09:30:00',
    duration: 90,
    treatmentName: 'Rituel Bien-être Complet',
    treatmentDescription: 'Une expérience unique combinant soin du corps, massage et moment de méditation.',
    treatmentPrice: 180,
    therapistName: 'Julie Renard',
    therapistSpecialty: 'Thérapeute bien-être',
    therapistExperience: 7,
    clientName: 'Lucas Petit',
    clientEmail: 'lucas.petit@email.com',
    options: ['Bain de pieds', 'Collation saine'],
    optionsPrice: 30,
    totalPrice: 210,
    status: 'annulée',
    createdAt: '2024-12-05T11:00:00'
  },
  {
    id: 6,
    number: 'SPA-654321',
    dateTime: '2024-12-28T15:00:00',
    duration: 45,
    treatmentName: 'Soin Express Détente',
    treatmentDescription: 'Une pause bien-être rapide pour se ressourcer pendant la journée.',
    treatmentPrice: 70,
    therapistName: 'Nadia Benali',
    therapistSpecialty: 'Praticienne en relaxation',
    therapistExperience: 5,
    clientName: 'Emma Richard',
    clientEmail: 'emma.richard@email.com',
    clientPhone: '+33 6 45 67 89 01',
    options: [],
    optionsPrice: 0,
    totalPrice: 70,
    status: 'en_cours',
    createdAt: '2024-12-06T13:30:00'
  }
])

// Computed: Filtered sessions
const filteredSessions = computed(() => {
  let filtered = [...sessions.value]
  
  // Filter by search query
  if (searchQuery.value.trim()) {
    filtered = filtered.filter(s => 
      s.number.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      s.treatmentName.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }
  
  // Filter by status
  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(s => s.status === statusFilter.value)
  }
  
  // Filter by date
  if (dateFilter.value) {
    filtered = filtered.filter(s => s.dateTime.split('T')[0] === dateFilter.value)
  }
  
  // Sort by date (most recent first)
  filtered.sort((a, b) => new Date(b.createdAt).getTime() - new Date(a.createdAt).getTime())
  
  return filtered
})

// Stats
const stats = computed(() => {
  return {
    total: sessions.value.length,
    confirmee: sessions.value.filter(s => s.status === 'confirmée').length,
    enAttente: sessions.value.filter(s => s.status === 'en_attente').length,
    enCours: sessions.value.filter(s => s.status === 'en_cours').length,
    terminee: sessions.value.filter(s => s.status === 'terminée').length
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
    en_attente: 'bg-yellow-500',
    en_cours: 'bg-blue-500',
    terminée: 'bg-purple-500',
    annulée: 'bg-red-500'
  }
  return colors[status as keyof typeof colors] || 'bg-gray-500'
}

const getStatusBadge = (status: string) => {
  const badges = {
    confirmée: 'bg-green-100 text-green-800',
    en_attente: 'bg-yellow-100 text-yellow-800',
    en_cours: 'bg-blue-100 text-blue-800',
    terminée: 'bg-purple-100 text-purple-800',
    annulée: 'bg-red-100 text-red-800'
  }
  return badges[status as keyof typeof badges] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status: string) => {
  const texts = {
    confirmée: 'Confirmée',
    en_attente: 'En attente',
    en_cours: 'En cours',
    terminée: 'Terminée',
    annulée: 'Annulée'
  }
  return texts[status as keyof typeof texts] || status
}

// Actions
const resetFilters = () => {
  searchQuery.value = ''
  statusFilter.value = 'all'
  dateFilter.value = ''
}

const viewDetails = (session: SpaSession) => {
  selectedSession.value = session
}

const closeModal = () => {
  selectedSession.value = null
}

const modifySession = (session: SpaSession) => {
 /*  router.push('/spa-reservation') */
  localStorage.setItem('modifySpaSession', JSON.stringify(session))
  alert(`Modification de la session ${session.number}\n\nVous allez être redirigé vers le formulaire de réservation.`)
}

const cancelSession = (session: SpaSession) => {
  if (confirm(`Êtes-vous sûr de vouloir annuler la session spa ${session.number} ?\n\nAnnulation gratuite jusqu'à 24h avant la session.`)) {
    const index = sessions.value.findIndex(s => s.id === session.id)
    if (index !== -1) {
      sessions.value[index].status = 'annulée'
      alert(`La session ${session.number} a été annulée avec succès.`)
    }
  }
}

const rebookSession = (session: SpaSession) => {
 /*  router.push('/spa-reservation') */
  localStorage.setItem('rebookSpaData', JSON.stringify(session))
  alert(`Réserver à nouveau le traitement: ${session.treatmentName}\n\nVous allez être redirigé vers le formulaire de réservation.`)
}

const leaveReview = (session: SpaSession) => {
  alert(`Vous allez laisser un avis pour la session ${session.number}\n\nTraitement: ${session.treatmentName}\nThérapeute: ${session.therapistName}\n\nCette fonctionnalité sera disponible prochainement.`)
}

const goToSpa = () => {
 /*  router.push('/spa-reservation') */
}

// Load any existing spa sessions from localStorage
onMounted(() => {
  const savedSessions = localStorage.getItem('spaSessions')
  if (savedSessions) {
    try {
      const parsed = JSON.parse(savedSessions)
      // Convert stored sessions to match our format
      const converted = parsed.map((s: any, index: number) => ({
        id: s.id || Date.now() + index,
        number: s.number || `SPA-${Math.floor(Math.random() * 1000000)}`,
        dateTime: s.dateTime || new Date().toISOString(),
        duration: s.duration || 60,
        treatmentName: s.treatmentName || 'Traitement Spa',
        treatmentDescription: s.treatmentDescription || 'Description du traitement',
        treatmentPrice: s.treatmentPrice || 0,
        therapistName: s.therapistName || 'À confirmer',
        therapistSpecialty: s.therapistSpecialty || 'Thérapeute',
        therapistExperience: s.therapistExperience || 5,
        clientName: s.clientName || 'Client',
        clientEmail: s.clientEmail || 'client@email.com',
        options: s.options || [],
        optionsPrice: s.optionsPrice || 0,
        totalPrice: s.totalPrice || 0,
        status: 'confirmée',
        specialRequests: s.specialRequests || '',
        createdAt: new Date().toISOString()
      }))
      
      // Merge with existing sessions
      sessions.value = [...converted, ...sessions.value]
    } catch (e) {
      console.error('Error loading spa sessions:', e)
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

/* Gradient background */
.bg-gradient-to-r {
  transition: all 0.3s ease;
}
</style>