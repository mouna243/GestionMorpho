<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Nos Chambres</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Découvrez notre sélection de chambres luxueuses</p>
      </div>

      <!-- Filters Section -->
      <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="grid md:grid-cols-4 gap-4">
          <!-- Category Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
            <select v-model="filters.category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Toutes les catégories</option>
              <option value="Premium">Premium</option>
              <option value="Luxe">Luxe</option>
              <option value="Confort">Confort</option>
              <option value="Économique">Économique</option>
            </select>
          </div>

          <!-- Price Range Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Prix max / nuit</label>
            <select v-model="filters.maxPrice" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="0">Tous les prix</option>
              <option value="150">Jusqu'à 150€</option>
              <option value="250">Jusqu'à 250€</option>
              <option value="350">Jusqu'à 350€</option>
              <option value="500">Jusqu'à 500€</option>
            </select>
          </div>

          <!-- Capacity Filter -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Capacité</label>
            <select v-model="filters.capacity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="0">Toutes capacités</option>
              <option value="2">2 personnes</option>
              <option value="3">3 personnes</option>
              <option value="4">4 personnes</option>
              <option value="5">5+ personnes</option>
            </select>
          </div>

          <!-- Sort By -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
            <select v-model="filters.sortBy" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
              <option value="price-asc">Prix croissant</option>
              <option value="price-desc">Prix décroissant</option>
              <option value="name-asc">Nom A-Z</option>
              <option value="name-desc">Nom Z-A</option>
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
          <span class="font-semibold">{{ filteredRooms.length }}</span> chambres trouvées
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

      <!-- Rooms Grid View -->
      <div v-if="viewMode === 'grid'" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="room in filteredRooms" :key="room.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-105">
          <div class="relative">
            <img :src="room.image" :alt="room.name" class="w-full h-56 object-cover">
            <div class="absolute top-4 right-4">
              <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                {{ room.category }}
              </span>
            </div>
            <div class="absolute bottom-4 left-4">
              <div class="flex text-yellow-400">
                <span v-for="star in room.rating" :key="star">★</span>
                <span v-for="star in (5 - room.rating)" :key="'empty-' + star" class="text-gray-300">★</span>
              </div>
            </div>
          </div>
          
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ room.name }}</h3>
            <p class="text-gray-600 mb-4">{{ room.description }}</p>
            
            <div class="flex items-center mb-4 text-sm text-gray-500">
              <div class="flex items-center mr-4">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>{{ room.capacity }} personnes</span>
              </div>
              <div class="flex items-center">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>{{ room.size }} m²</span>
              </div>
            </div>
            
            <div class="flex items-center justify-between">
              <div>
                <span class="text-2xl font-bold text-indigo-600">{{ room.price }}€</span>
                <span class="text-gray-500">/nuit</span>
              </div>
              <button 
                @click="viewRoomDetails(room)"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300"
              >
                Réserver
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Rooms List View -->
      <div v-else class="space-y-6">
        <div v-for="room in filteredRooms" :key="room.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
          <div class="flex flex-col md:flex-row">
            <img :src="room.image" :alt="room.name" class="md:w-72 h-48 object-cover">
            <div class="flex-1 p-6">
              <div class="flex justify-between items-start mb-2">
                <div>
                  <h3 class="text-xl font-bold text-gray-900">{{ room.name }}</h3>
                  <div class="flex items-center mt-1">
                    <div class="flex text-yellow-400">
                      <span v-for="star in room.rating" :key="star">★</span>
                      <span v-for="star in (5 - room.rating)" :key="'empty-' + star" class="text-gray-300">★</span>
                    </div>
                    <span class="text-gray-500 text-sm ml-2">({{ room.reviews }} avis)</span>
                  </div>
                </div>
                <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                  {{ room.category }}
                </span>
              </div>
              
              <p class="text-gray-600 mb-4">{{ room.description }}</p>
              
              <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-500">
                <div class="flex items-center">
                  <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                  </svg>
                  <span>{{ room.capacity }} personnes</span>
                </div>
                <div class="flex items-center">
                  <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                  </svg>
                  <span>{{ room.size }} m²</span>
                </div>
                <div class="flex items-center">
                  <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                  <span>WiFi gratuit</span>
                </div>
                <div class="flex items-center">
                  <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                  </svg>
                  <span>Climatisation</span>
                </div>
              </div>
              
              <div class="flex justify-between items-center">
                <div>
                  <span class="text-2xl font-bold text-indigo-600">{{ room.price }}€</span>
                  <span class="text-gray-500">/nuit</span>
                </div>
                <button 
                  @click="viewRoomDetails(room)"
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
      <div v-if="filteredRooms.length === 0" class="text-center py-12">
        <svg class="h-24 w-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune chambre trouvée</h3>
        <p class="text-gray-600">Essayez de modifier vos critères de recherche</p>
        <button @click="resetFilters" class="mt-4 text-indigo-600 hover:text-indigo-700 font-medium">
          Réinitialiser les filtres
        </button>
      </div>
    </div>

    <!-- Room Details Modal -->
    <div v-if="selectedRoom" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
      <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="relative">
          <img :src="selectedRoom.image" :alt="selectedRoom.name" class="w-full h-64 object-cover rounded-t-lg">
          <button @click="closeModal" class="absolute top-4 right-4 bg-white rounded-full p-2 hover:bg-gray-100">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <div>
              <h2 class="text-2xl font-bold text-gray-900">{{ selectedRoom.name }}</h2>
              <div class="flex items-center mt-2">
                <div class="flex text-yellow-400">
                  <span v-for="star in selectedRoom.rating" :key="star">★</span>
                  <span v-for="star in (5 - selectedRoom.rating)" :key="'empty-' + star" class="text-gray-300">★</span>
                </div>
                <span class="text-gray-500 text-sm ml-2">({{ selectedRoom.reviews }} avis)</span>
              </div>
            </div>
            <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
              {{ selectedRoom.category }}
            </span>
          </div>
          
          <p class="text-gray-600 mb-6">{{ selectedRoom.description }}</p>
          
          <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 p-3 rounded-lg">
              <div class="text-sm text-gray-500">Capacité</div>
              <div class="font-semibold text-gray-900">{{ selectedRoom.capacity }} personnes</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
              <div class="text-sm text-gray-500">Superficie</div>
              <div class="font-semibold text-gray-900">{{ selectedRoom.size }} m²</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
              <div class="text-sm text-gray-500">Prix par nuit</div>
              <div class="font-semibold text-indigo-600">{{ selectedRoom.price }}€</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
              <div class="text-sm text-gray-500">Disponibilité</div>
              <div class="font-semibold text-green-600">Disponible</div>
            </div>
          </div>
          
          <h3 class="font-semibold text-gray-900 mb-2">Équipements</h3>
          <div class="grid grid-cols-2 gap-2 mb-6">
            <div v-for="amenity in selectedRoom.amenities" :key="amenity" class="flex items-center text-sm text-gray-600">
              <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              {{ amenity }}
            </div>
          </div>
          
          <button @click="goToReservation" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
            Réserver cette chambre
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
/* import { useRouter } from 'vue-router'

const router = useRouter() */

// Room interface
interface Room {
  id: number
  name: string
  category: string
  price: number
  capacity: number
  size: number
  description: string
  image: string
  rating: number
  reviews: number
  amenities: string[]
}

// All rooms data
const allRooms = ref<Room[]>([
  {
    id: 1,
    name: 'Suite Présidentielle',
    category: 'Premium',
    price: 450,
    capacity: 4,
    size: 85,
    description: 'Suite luxueuse avec vue panoramique sur la ville, jacuzzi et terrasse privée. Équipée de tout le confort moderne pour un séjour inoubliable.',
    image: 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 128,
    amenities: ['Jacuzzi', 'Terrasse privée', 'Vue panoramique', 'Mini-bar', 'Smart TV', 'Climatisation']
  },
  {
    id: 2,
    name: 'Chambre Deluxe',
    category: 'Luxe',
    price: 250,
    capacity: 3,
    size: 45,
    description: 'Chambre spacieuse avec lit king size, bureau et salle de bain privative. Design élégant et matériaux nobles pour votre confort.',
    image: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600&h=400&fit=crop',
    rating: 4,
    reviews: 95,
    amenities: ['Lit king size', 'Bureau', 'Salle de bain privative', 'Mini-bar', 'TV écran plat', 'WiFi gratuit']
  },
  {
    id: 3,
    name: 'Chambre Junior Suite',
    category: 'Confort',
    price: 320,
    capacity: 3,
    size: 55,
    description: 'Espace séjour séparé, équipements modernes et design contemporain. Idéale pour les séjours professionnels ou en couple.',
    image: 'https://images.unsplash.com/photo-1584132967330-3eace6d7b49c?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 67,
    amenities: ['Espace salon', 'Kitchenette', 'Coffre-fort', 'Peignoirs', 'Chaussons', 'Machine à café']
  },
  {
    id: 4,
    name: 'Chambre Standard',
    category: 'Économique',
    price: 150,
    capacity: 2,
    size: 25,
    description: 'Confortable et fonctionnelle, parfaite pour les courts séjours. Tout l\'essentiel pour un séjour agréable à petit prix.',
    image: 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=600&h=400&fit=crop',
    rating: 4,
    reviews: 203,
    amenities: ['Lit double', 'Salle de bain', 'TV', 'WiFi gratuit', 'Climatisation', 'Eau offerte']
  },
  {
    id: 5,
    name: 'Suite Familiale',
    category: 'Premium',
    price: 380,
    capacity: 5,
    size: 75,
    description: 'Idéale pour les familles avec deux chambres séparées, salon spacieux et cuisine équipée. Tout le confort pour des vacances réussies.',
    image: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 156,
    amenities: ['2 chambres', 'Salon', 'Cuisine équipée', '2 salles de bain', 'Balcon', 'Jeux pour enfants']
  },
  {
    id: 6,
    name: 'Chambre Vue Mer',
    category: 'Luxe',
    price: 300,
    capacity: 2,
    size: 35,
    description: 'Chambre romantique avec vue imprenable sur la mer, parfaite pour les couples. Balcon privé et coucher de soleil garanti.',
    image: 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 89,
    amenities: ['Vue mer', 'Balcon', 'Lit queen size', 'Baignoire balnéo', 'Room service', 'Mini-bar']
  }
])

// Filters
const filters = ref({
  category: '',
  maxPrice: 0,
  capacity: 0,
  sortBy: 'price-asc'
})

const viewMode = ref<'grid' | 'list'>('grid')
const selectedRoom = ref<Room | null>(null)

// Computed: Filtered and sorted rooms
const filteredRooms = computed(() => {
  let rooms = [...allRooms.value]
  
  // Filter by category
  if (filters.value.category) {
    rooms = rooms.filter(room => room.category === filters.value.category)
  }
  
  // Filter by max price
  if (filters.value.maxPrice > 0) {
    rooms = rooms.filter(room => room.price <= filters.value.maxPrice)
  }
  
  // Filter by capacity
  if (filters.value.capacity > 0) {
    rooms = rooms.filter(room => room.capacity >= filters.value.capacity)
  }
  
  // Sort rooms
  switch (filters.value.sortBy) {
    case 'price-asc':
      rooms.sort((a, b) => a.price - b.price)
      break
    case 'price-desc':
      rooms.sort((a, b) => b.price - a.price)
      break
    case 'name-asc':
      rooms.sort((a, b) => a.name.localeCompare(b.name))
      break
    case 'name-desc':
      rooms.sort((a, b) => b.name.localeCompare(a.name))
      break
  }
  
  return rooms
})

// Reset all filters
const resetFilters = () => {
  filters.value = {
    category: '',
    maxPrice: 0,
    capacity: 0,
    sortBy: 'price-asc'
  }
}

// View room details
const viewRoomDetails = (room: Room) => {
  selectedRoom.value = room
}

// Close modal
const closeModal = () => {
  selectedRoom.value = null
}

// Go to reservation page
const goToReservation = () => {
  if (selectedRoom.value) {
    // Store selected room in localStorage for reservation page
    localStorage.setItem('selectedRoom', JSON.stringify(selectedRoom.value))
    /* router.push('/reservation') */
  }
}

// Load saved filters from localStorage
onMounted(() => {
  const savedFilters = localStorage.getItem('roomFilters')
  if (savedFilters) {
    try {
      filters.value = JSON.parse(savedFilters)
    } catch (e) {
      console.error('Error loading filters:', e)
    }
  }
})

// Save filters to localStorage when changed
import { watch } from 'vue'
watch(filters, (newFilters) => {
  localStorage.setItem('roomFilters', JSON.stringify(newFilters))
}, { deep: true })
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

.bg-white, .modal {
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

/* Modal styles */
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
  opacity: 0;
}

/* Scrollbar */
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