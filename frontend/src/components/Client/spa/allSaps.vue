<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Nos Sessions Spa</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Découvrez nos traitements bien-être pour une détente absolue</p>
      </div>

      <!-- Filters Section -->
      <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="grid md:grid-cols-4 gap-4">
          <!-- Category Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
            <select v-model="filters.category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Toutes les catégories</option>
              <option value="Massage">Massages</option>
              <option value="Soin visage">Soins du visage</option>
              <option value="Hammam">Hammam</option>
              <option value="Rituel">Rituels</option>
              <option value="Soin">Soins</option>
            </select>
          </div>

          <!-- Duration Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Durée</label>
            <select v-model="filters.duration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="0">Toutes durées</option>
              <option value="30">30 minutes</option>
              <option value="60">60 minutes</option>
              <option value="90">90 minutes</option>
              <option value="120">120 minutes</option>
            </select>
          </div>

          <!-- Price Range Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Prix max</label>
            <select v-model="filters.maxPrice" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="0">Tous les prix</option>
              <option value="80">Jusqu'à 80€</option>
              <option value="120">Jusqu'à 120€</option>
              <option value="160">Jusqu'à 160€</option>
              <option value="200">Jusqu'à 200€</option>
            </select>
          </div>

          <!-- Sort By -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
            <select v-model="filters.sortBy" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="price-asc">Prix croissant</option>
              <option value="price-desc">Prix décroissant</option>
              <option value="duration-asc">Durée croissante</option>
              <option value="duration-desc">Durée décroissante</option>
              <option value="name-asc">Nom A-Z</option>
            </select>
          </div>
        </div>

        <!-- Reset Filters Button -->
        <div class="mt-4 text-center">
          <button @click="resetFilters" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
            Réinitialiser les filtres
          </button>
        </div>
      </div>

      <!-- Results Count -->
      <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">
          <span class="font-semibold">{{ filteredSessions.length }}</span> traitements disponibles
        </p>
        <div class="flex space-x-2">
          <button 
            @click="viewMode = 'grid'" 
            class="p-2 rounded-lg transition duration-200"
            :class="viewMode === 'grid' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600 hover:bg-gray-300'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
          </button>
          <button 
            @click="viewMode = 'list'" 
            class="p-2 rounded-lg transition duration-200"
            :class="viewMode === 'list' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600 hover:bg-gray-300'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Spa Sessions Grid View -->
      <div v-if="viewMode === 'grid'" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="session in filteredSessions" :key="session.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-105">
          <div class="relative">
            <img :src="session.image" :alt="session.name" class="w-full h-56 object-cover">
            <div class="absolute top-4 right-4">
              <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                {{ session.category }}
              </span>
            </div>
            <div class="absolute bottom-4 left-4">
              <div class="flex items-center bg-black bg-opacity-50 rounded-full px-2 py-1">
                <svg class="h-4 w-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-white text-sm">{{ session.rating }}</span>
              </div>
            </div>
          </div>
          
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ session.name }}</h3>
            <p class="text-gray-600 mb-4 text-sm">{{ session.description }}</p>
            
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session.duration }} minutes</span>
              </div>
              <div class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session.price }}€</span>
              </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
              <span v-for="benefit in session.benefits.slice(0, 3)" :key="benefit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                ✓ {{ benefit }}
              </span>
            </div>
            
            <button 
              @click="viewSessionDetails(session)"
              class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300"
            >
              Réserver
            </button>
          </div>
        </div>
      </div>

      <!-- Spa Sessions List View -->
      <div v-else class="space-y-6">
        <div v-for="session in filteredSessions" :key="session.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
          <div class="flex flex-col md:flex-row">
            <img :src="session.image" :alt="session.name" class="md:w-72 h-56 object-cover">
            <div class="flex-1 p-6">
              <div class="flex justify-between items-start mb-2">
                <div>
                  <h3 class="text-xl font-bold text-gray-900">{{ session.name }}</h3>
                  <div class="flex items-center mt-1">
                    <div class="flex text-yellow-400">
                      <span v-for="star in Math.floor(session.rating)" :key="star">★</span>
                      <span v-for="star in (5 - Math.floor(session.rating))" :key="'empty-' + star" class="text-gray-300">★</span>
                    </div>
                    <span class="text-gray-500 text-sm ml-2">({{ session.reviews }} avis)</span>
                  </div>
                </div>
                <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                  {{ session.category }}
                </span>
              </div>
              
              <p class="text-gray-600 mb-3">{{ session.description }}</p>
              
              <div class="flex flex-wrap gap-4 mb-3 text-sm">
                <div class="flex items-center text-gray-500">
                  <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span>{{ session.duration }} minutes</span>
                </div>
                <div class="flex items-center text-gray-500">
                  <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span>{{ session.price }}€</span>
                </div>
              </div>

              <div class="flex flex-wrap gap-2 mb-4">
                <span v-for="benefit in session.benefits" :key="benefit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                  ✓ {{ benefit }}
                </span>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                  <span>👤 {{ session.therapists }} thérapeutes disponibles</span>
                </div>
                <button 
                  @click="viewSessionDetails(session)"
                  class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300"
                >
                  Réserver maintenant
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- No Results -->
      <div v-if="filteredSessions.length === 0" class="text-center py-12">
        <svg class="h-24 w-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun traitement trouvé</h3>
        <p class="text-gray-600">Essayez de modifier vos critères de recherche</p>
        <button @click="resetFilters" class="mt-4 text-indigo-600 hover:text-indigo-700 font-medium">
          Réinitialiser les filtres
        </button>
      </div>

      <!-- Spa Facilities Section -->
      <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Nos Équipements Spa</h2>
        <div class="grid md:grid-cols-4 gap-6">
          <div class="text-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Hammam</h3>
            <p class="text-sm text-gray-500">Traditionnel marocain</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Sauna</h3>
            <p class="text-sm text-gray-500">Finlandais et infrarouge</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h12m-6-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Jacuzzi</h3>
            <p class="text-sm text-gray-500">Hydromassage</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
              <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Salle de Relaxation</h3>
            <p class="text-sm text-gray-500">Avec thé offert</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Session Details Modal -->
    <div v-if="selectedSession" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
      <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="relative">
          <img :src="selectedSession.image" :alt="selectedSession.name" class="w-full h-64 object-cover rounded-t-lg">
          <button @click="closeModal" class="absolute top-4 right-4 bg-white rounded-full p-2 hover:bg-gray-100">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <div>
              <h2 class="text-2xl font-bold text-gray-900">{{ selectedSession.name }}</h2>
              <div class="flex items-center mt-2">
                <div class="flex text-yellow-400">
                  <span v-for="star in Math.floor(selectedSession.rating)" :key="star">★</span>
                  <span v-for="star in (5 - Math.floor(selectedSession.rating))" :key="'empty-' + star" class="text-gray-300">★</span>
                </div>
                <span class="text-gray-500 text-sm ml-2">({{ selectedSession.reviews }} avis)</span>
              </div>
            </div>
            <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
              {{ selectedSession.category }}
            </span>
          </div>
          
          <p class="text-gray-600 mb-6">{{ selectedSession.fullDescription || selectedSession.description }}</p>
          
          <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-sm text-gray-500">Durée</div>
              <div class="font-semibold text-gray-900">{{ selectedSession.duration }} minutes</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-sm text-gray-500">Prix</div>
              <div class="font-semibold text-indigo-600">{{ selectedSession.price }}€</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-sm text-gray-500">Thérapeutes</div>
              <div class="font-semibold text-gray-900">{{ selectedSession.therapists }} disponibles</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-sm text-gray-500">Disponibilité</div>
              <div class="font-semibold text-green-600">7j/7</div>
            </div>
          </div>
          
          <h3 class="font-semibold text-gray-900 mb-2">Bienfaits</h3>
          <div class="flex flex-wrap gap-2 mb-6">
            <span v-for="benefit in selectedSession.benefits" :key="benefit" class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
              ✓ {{ benefit }}
            </span>
          </div>
          
          <h3 class="font-semibold text-gray-900 mb-2">Informations importantes</h3>
          <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-6">
            <li>Arrivez 15 minutes avant l'heure prévue</li>
            <li>Peignoir et serviettes fournis</li>
            <li>Casiers sécurisés disponibles</li>
            <li>Annulation gratuite jusqu'à 24h avant</li>
          </ul>
          
          <button 
            @click="goToReservation"
            class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300"
          >
            Réserver cette session
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
/* import { useRouter } from 'vue-router'

const router = useRouter() */

// Interfaces
interface SpaSession {
  id: number
  name: string
  category: string
  duration: number
  price: number
  description: string
  fullDescription?: string
  image: string
  rating: number
  reviews: number
  benefits: string[]
  therapists: number
}

// Filters
const filters = ref({
  category: '',
  duration: 0,
  maxPrice: 0,
  sortBy: 'price-asc'
})

const viewMode = ref<'grid' | 'list'>('grid')
const selectedSession = ref<SpaSession | null>(null)

// All spa sessions data
const allSessions = ref<SpaSession[]>([
  {
    id: 1,
    name: 'Massage Relaxant aux Huiles Essentielles',
    category: 'Massage',
    duration: 60,
    price: 120,
    description: 'Un massage doux qui combine des techniques suédoises et des huiles essentielles pour une relaxation profonde.',
    fullDescription: 'Ce massage relaxant utilise des mouvements lents et fluides pour détendre les muscles et apaiser l\'esprit. Les huiles essentielles sont sélectionnées selon vos besoins : lavande pour la détente, eucalyptus pour la respiration, ou citron pour l\'énergie. Idéal pour évacuer le stress et les tensions quotidiennes.',
    image: 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=600&h=400&fit=crop',
    rating: 4.9,
    reviews: 156,
    benefits: ['Réduction du stress', 'Détente musculaire', 'Amélioration du sommeil'],
    therapists: 5
  },
  {
    id: 2,
    name: 'Soin du Visage Anti-Âge',
    category: 'Soin visage',
    duration: 60,
    price: 95,
    description: 'Un soin complet utilisant des produits naturels pour revitaliser et rajeunir votre peau.',
    fullDescription: 'Ce soin du visage anti-âge combine nettoyage en profondeur, exfoliation douce, massage facial liftant et masque hydratant. Utilisation de produits naturels riches en antioxydants pour lutter contre les signes de l\'âge et redonner éclat et fermeté à votre peau.',
    image: 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600&h=400&fit=crop',
    rating: 4.8,
    reviews: 98,
    benefits: ['Raffermissement', 'Hydratation intense', 'Éclat immédiat'],
    therapists: 4
  },
  {
    id: 3,
    name: 'Soin Hammam & Gommage',
    category: 'Hammam',
    duration: 90,
    price: 150,
    description: 'Un rituel traditionnel incluant hammam, gommage au savon noir et modelage relaxant.',
    fullDescription: 'Vivez un véritable rituel de bien-être traditionnel : vapeur envoûtante du hammam, gommage exfoliant au savon noir et au gant de crin, puis modelage relaxant à l\'huile d\'argan. Une expérience sensorielle complète pour purifier et revitaliser votre corps.',
    image: 'https://images.unsplash.com/photo-1600606081210-5f6c49620341?w=600&h=400&fit=crop',
    rating: 4.9,
    reviews: 203,
    benefits: ['Purification profonde', 'Exfoliation', 'Détente totale'],
    therapists: 3
  },
  {
    id: 4,
    name: 'Massage Sportif',
    category: 'Massage',
    duration: 60,
    price: 110,
    description: 'Massage ciblé pour soulager les tensions musculaires et améliorer la récupération.',
    fullDescription: 'Spécialement conçu pour les sportifs, ce massage utilise des techniques profondes pour cibler les zones de tension, améliorer la circulation sanguine et accélérer la récupération musculaire. Idéal avant ou après une compétition.',
    image: 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=600&h=400&fit=crop',
    rating: 4.7,
    reviews: 87,
    benefits: ['Récupération accélérée', 'Soulagement des courbatures', 'Meilleure performance'],
    therapists: 4
  },
  {
    id: 5,
    name: 'Rituel Bien-être Complet',
    category: 'Rituel',
    duration: 120,
    price: 180,
    description: 'Une expérience unique combinant soin du corps, massage et moment de méditation.',
    fullDescription: 'Notre rituel signature : un parcours bien-être complet débutant par un bain de vapeur, suivi d\'un gommage corporel, d\'un enveloppement hydratant, d\'un massage aux pierres chaudes et se terminant par une séance de méditation guidée. 2 heures de pur bonheur !',
    image: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&h=400&fit=crop',
    rating: 5.0,
    reviews: 245,
    benefits: ['Détox complète', 'Relaxation profonde', 'Harmonie corps-esprit'],
    therapists: 3
  },
  {
    id: 6,
    name: 'Soin Express Détente',
    category: 'Soin',
    duration: 30,
    price: 70,
    description: 'Une pause bien-être rapide pour se ressourcer pendant la journée.',
    fullDescription: 'Parfait pour une pause déjeuner ou une courte escapade, ce soin express combine un massage rapide du dos, des épaules et de la nuque avec une courte séance de relaxation. Idéal pour décompresser en milieu de journée.',
    image: 'https://images.unsplash.com/photo-1600334129128-685c5582fd35?w=600&h=400&fit=crop',
    rating: 4.6,
    reviews: 67,
    benefits: ['Rapide et efficace', 'Anti-stress', 'Recharge d\'énergie'],
    therapists: 5
  },
  {
    id: 7,
    name: 'Massage aux Pierres Chaudes',
    category: 'Massage',
    duration: 80,
    price: 140,
    description: 'Massage thérapeutique utilisant des pierres volcaniques chauffées pour une relaxation en profondeur.',
    fullDescription: 'Les pierres chaudes placées sur les points d\'énergie du corps permettent une relaxation musculaire intense. La chaleur des pierres pénètre en profondeur, dénouant les tensions et apaisant l\'esprit. Une expérience unique et enveloppante.',
    image: 'https://images.unsplash.com/photo-1600948836101-f9ffda59d250?w=600&h=400&fit=crop',
    rating: 4.9,
    reviews: 134,
    benefits: ['Relaxation intense', 'Dénouement des tensions', 'Bien-être profond'],
    therapists: 4
  },
  {
    id: 8,
    name: 'Soin Découverte en Duo',
    category: 'Rituel',
    duration: 90,
    price: 260,
    description: 'Un moment privilégié à partager en couple ou entre amis.',
    fullDescription: 'Profitez d\'un moment unique à deux avec notre soin duo : deux praticiennes pour vous offrir simultanément un massage relaxant, suivis d\'un bain moussant et d\'une coupe de champagne. Le cadeau idéal pour une occasion spéciale.',
    image: 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=600&h=400&fit=crop',
    rating: 5.0,
    reviews: 189,
    benefits: ['Moment de partage', 'Détente à deux', 'Expérience unique'],
    therapists: 2
  }
])

// Computed: Filtered and sorted sessions
const filteredSessions = computed(() => {
  let sessions = [...allSessions.value]
  
  // Filter by category
  if (filters.value.category) {
    sessions = sessions.filter(session => session.category === filters.value.category)
  }
  
  // Filter by duration
  if (filters.value.duration > 0) {
    sessions = sessions.filter(session => session.duration === filters.value.duration)
  }
  
  // Filter by max price
  if (filters.value.maxPrice > 0) {
    sessions = sessions.filter(session => session.price <= filters.value.maxPrice)
  }
  
  // Sort sessions
  switch (filters.value.sortBy) {
    case 'price-asc':
      sessions.sort((a, b) => a.price - b.price)
      break
    case 'price-desc':
      sessions.sort((a, b) => b.price - a.price)
      break
    case 'duration-asc':
      sessions.sort((a, b) => a.duration - b.duration)
      break
    case 'duration-desc':
      sessions.sort((a, b) => b.duration - a.duration)
      break
    case 'name-asc':
      sessions.sort((a, b) => a.name.localeCompare(b.name))
      break
  }
  
  return sessions
})

// Reset filters
const resetFilters = () => {
  filters.value = {
    category: '',
    duration: 0,
    maxPrice: 0,
    sortBy: 'price-asc'
  }
}

// View session details
const viewSessionDetails = (session: SpaSession) => {
  selectedSession.value = session
}

// Close modal
const closeModal = () => {
  selectedSession.value = null
}

// Go to reservation
const goToReservation = () => {
  if (selectedSession.value) {
    localStorage.setItem('selectedSpaTreatment', JSON.stringify(selectedSession.value))
    /* router.push('/spa-reservation') */
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
</style>