<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Notre Carte des Plats</h1>
        <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
        <p class="text-xl text-gray-600 mt-4">Découvrez une cuisine raffinée préparée par nos chefs étoilés</p>
      </div>

      <!-- Category Tabs -->
      <div class="flex flex-wrap justify-center gap-4 mb-8">
        <button 
          v-for="category in categories" 
          :key="category.id"
          @click="selectedCategory = category.id"
          class="px-6 py-2 rounded-full transition duration-300"
          :class="selectedCategory === category.id ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100'"
        >
          <div class="flex items-center space-x-2">
            <span>{{ category.icon }}</span>
            <span>{{ category.name }}</span>
          </div>
        </button>
      </div>

      <!-- Search Bar -->
      <div class="max-w-md mx-auto mb-8">
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
            placeholder="Rechercher un plat..."
          >
        </div>
      </div>

      <!-- Results Count -->
      <div class="mb-6 flex justify-between items-center">
        <p class="text-gray-600">
          <span class="font-semibold">{{ filteredPlats.length }}</span> plats disponibles
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

      <!-- Plats Grid View -->
      <div v-if="viewMode === 'grid'" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="plat in filteredPlats" :key="plat.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-105">
          <div class="relative">
            <img :src="plat.image" :alt="plat.nom" class="w-full h-48 object-cover">
            <div class="absolute top-4 right-4">
              <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                {{ plat.categorie }}
              </span>
            </div>
            <div v-if="plat.popular" class="absolute top-4 left-4">
              <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                🌟 Populaire
              </span>
            </div>
            <div v-if="plat.vegetarien" class="absolute bottom-4 left-4">
              <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                🌱 Végétarien
              </span>
            </div>
          </div>
          
          <div class="p-6">
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-xl font-bold text-gray-900">{{ plat.nom }}</h3>
              <span class="text-lg font-bold text-indigo-600">{{ plat.prix }}€</span>
            </div>
            
            <p class="text-gray-600 mb-4 text-sm">{{ plat.description }}</p>
            
            <div class="flex items-center mb-4">
              <div class="flex text-yellow-400">
                <span v-for="star in plat.rating" :key="star">★</span>
                <span v-for="star in (5 - plat.rating)" :key="'empty-' + star" class="text-gray-300">★</span>
              </div>
              <span class="text-gray-500 text-sm ml-2">({{ plat.reviews }} avis)</span>
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
              <span v-for="tag in plat.tags" :key="tag" class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                {{ tag }}
              </span>
            </div>
            
            <button 
              @click="viewPlatDetails(plat)"
              class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300"
            >
              Commander
            </button>
          </div>
        </div>
      </div>

      <!-- Plats List View -->
      <div v-else class="space-y-6">
        <div v-for="plat in filteredPlats" :key="plat.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
          <div class="flex flex-col md:flex-row">
            <img :src="plat.image" :alt="plat.nom" class="md:w-64 h-48 object-cover">
            <div class="flex-1 p-6">
              <div class="flex justify-between items-start mb-2">
                <div>
                  <h3 class="text-xl font-bold text-gray-900">{{ plat.nom }}</h3>
                  <div class="flex items-center mt-1">
                    <div class="flex text-yellow-400">
                      <span v-for="star in plat.rating" :key="star">★</span>
                      <span v-for="star in (5 - plat.rating)" :key="'empty-' + star" class="text-gray-300">★</span>
                    </div>
                    <span class="text-gray-500 text-sm ml-2">({{ plat.reviews }} avis)</span>
                  </div>
                </div>
                <div class="text-right">
                  <span class="text-2xl font-bold text-indigo-600">{{ plat.prix }}€</span>
                  <div class="flex gap-2 mt-1">
                    <span v-if="plat.popular" class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs">Populaire</span>
                    <span v-if="plat.vegetarien" class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Végétarien</span>
                  </div>
                </div>
              </div>
              
              <p class="text-gray-600 mb-3">{{ plat.description }}</p>
              
              <div class="flex flex-wrap gap-2 mb-4">
                <span v-for="tag in plat.tags" :key="tag" class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                  {{ tag }}
                </span>
              </div>

              <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                  <span>🍽️ {{ plat.categorie }}</span>
                </div>
                <button 
                  @click="viewPlatDetails(plat)"
                  class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300"
                >
                  Commander maintenant
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- No Results -->
      <div v-if="filteredPlats.length === 0" class="text-center py-12">
        <svg class="h-24 w-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun plat trouvé</h3>
        <p class="text-gray-600">Essayez de modifier votre recherche ou catégorie</p>
        <button @click="resetSearch" class="mt-4 text-indigo-600 hover:text-indigo-700 font-medium">
          Réinitialiser
        </button>
      </div>
    </div>

    <!-- Plat Details Modal -->
    <div v-if="selectedPlat" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
      <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="relative">
          <img :src="selectedPlat.image" :alt="selectedPlat.nom" class="w-full h-64 object-cover rounded-t-lg">
          <button @click="closeModal" class="absolute top-4 right-4 bg-white rounded-full p-2 hover:bg-gray-100">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <div>
              <h2 class="text-2xl font-bold text-gray-900">{{ selectedPlat.nom }}</h2>
              <div class="flex items-center mt-2">
                <div class="flex text-yellow-400">
                  <span v-for="star in selectedPlat.rating" :key="star">★</span>
                  <span v-for="star in (5 - selectedPlat.rating)" :key="'empty-' + star" class="text-gray-300">★</span>
                </div>
                <span class="text-gray-500 text-sm ml-2">({{ selectedPlat.reviews }} avis)</span>
              </div>
            </div>
            <div class="text-right">
              <span class="text-3xl font-bold text-indigo-600">{{ selectedPlat.prix }}€</span>
            </div>
          </div>
          
          <div class="flex gap-2 mb-4">
            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm">{{ selectedPlat.categorie }}</span>
            <span v-if="selectedPlat.popular" class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">🌟 Populaire</span>
            <span v-if="selectedPlat.vegetarien" class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">🌱 Végétarien</span>
            <span v-if="selectedPlat.epice" class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">🌶️ Épicé</span>
          </div>
          
          <p class="text-gray-600 mb-6">{{ selectedPlat.description }}</p>
          
          <h3 class="font-semibold text-gray-900 mb-2">Informations nutritionnelles</h3>
          <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-sm text-gray-500">Calories</div>
              <div class="font-semibold text-gray-900">{{ selectedPlat.nutrition?.calories || 'N/A' }}</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-sm text-gray-500">Protéines</div>
              <div class="font-semibold text-gray-900">{{ selectedPlat.nutrition?.proteines || 'N/A' }}</div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-sm text-gray-500">Temps prép.</div>
              <div class="font-semibold text-gray-900">{{ selectedPlat.tempsPreparation || '15-20' }} min</div>
            </div>
          </div>
          
          <h3 class="font-semibold text-gray-900 mb-2">Ingrédients</h3>
          <div class="flex flex-wrap gap-2 mb-6">
            <span v-for="ingredient in selectedPlat.ingredients" :key="ingredient" class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
              {{ ingredient }}
            </span>
          </div>
          
          <div class="flex gap-4">
            <button 
              @click="commanderPlat"
              class="flex-1 bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300"
            >
              Commander
            </button>
            <button 
              @click="ajouterAuPanier"
              class="flex-1 border-2 border-indigo-600 text-indigo-600 py-3 rounded-lg hover:bg-indigo-50 transition duration-300"
            >
              Ajouter au panier
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

// Interfaces
interface Plat {
  id: number
  nom: string
  categorie: string
  prix: number
  description: string
  image: string
  rating: number
  reviews: number
  popular: boolean
  vegetarien: boolean
  epice: boolean
  tags: string[]
  ingredients: string[]
  nutrition?: {
    calories: string
    proteines: string
  }
  tempsPreparation?: string
}

interface Category {
  id: string
  name: string
  icon: string
}

// Categories data
const categories = ref<Category[]>([
  { id: 'all', name: 'Tous', icon: '🍽️' },
  { id: 'entrees', name: 'Entrées', icon: '🥗' },
  { id: 'plats', name: 'Plats principaux', icon: '🍲' },
  { id: 'poissons', name: 'Poissons', icon: '🐟' },
  { id: 'viandes', name: 'Viandes', icon: '🥩' },
  { id: 'vegetarien', name: 'Végétarien', icon: '🌱' },
  { id: 'desserts', name: 'Desserts', icon: '🍰' }
])

// All plats data
const allPlats = ref<Plat[]>([
  {
    id: 1,
    nom: 'Salade César',
    categorie: 'entrees',
    prix: 12,
    description: 'Salade romaine, poulet grillé, parmesan, croûtons et sauce César maison',
    image: 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 89,
    popular: true,
    vegetarien: false,
    epice: false,
    tags: ['Salade', 'Poulet', 'Frais'],
    ingredients: ['Laitue romaine', 'Poulet', 'Parmesan', 'Croûtons', 'Sauce César'],
    nutrition: { calories: '450 cal', proteines: '25g' },
    tempsPreparation: '10'
  },
  {
    id: 2,
    nom: 'Boeuf Bourguignon',
    categorie: 'viandes',
    prix: 28,
    description: 'Boeuf mijoté au vin rouge, champignons, oignons et lardons, servi avec purée maison',
    image: 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 156,
    popular: true,
    vegetarien: false,
    epice: false,
    tags: ['Plat traditionnel', 'Mijoté', 'Gourmand'],
    ingredients: ['Boeuf', 'Vin rouge', 'Champignons', 'Oignons', 'Lardons', 'Purée'],
    nutrition: { calories: '680 cal', proteines: '45g' },
    tempsPreparation: '20'
  },
  {
    id: 3,
    nom: 'Saumon Grillé',
    categorie: 'poissons',
    prix: 24,
    description: 'Filet de saumon grillé, sauce citron beurre, légumes de saison et riz basmati',
    image: 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=600&h=400&fit=crop',
    rating: 4,
    reviews: 78,
    popular: false,
    vegetarien: false,
    epice: false,
    tags: ['Saumon', 'Grillé', 'Léger'],
    ingredients: ['Saumon', 'Citron', 'Beurre', 'Légumes', 'Riz basmati'],
    nutrition: { calories: '520 cal', proteines: '35g' },
    tempsPreparation: '15'
  },
  {
    id: 4,
    nom: 'Risotto aux Champignons',
    categorie: 'vegetarien',
    prix: 18,
    description: 'Risotto crémeux aux champignons frais, parmesan et truffe noire',
    image: 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 112,
    popular: true,
    vegetarien: true,
    epice: false,
    tags: ['Risotto', 'Champignons', 'Crémeux'],
    ingredients: ['Riz arborio', 'Champignons', 'Parmesan', 'Truffe', 'Bouillon légumes'],
    nutrition: { calories: '580 cal', proteines: '15g' },
    tempsPreparation: '25'
  },
  {
    id: 5,
    nom: 'Poulet Tandoori',
    categorie: 'plats',
    prix: 22,
    description: 'Poulet mariné au yaourt et épices indiennes, grillé au four, servi avec sauce menthe',
    image: 'https://images.unsplash.com/photo-1563379091339-03b21a4a4f2c?w=600&h=400&fit=crop',
    rating: 4,
    reviews: 67,
    popular: false,
    vegetarien: false,
    epice: true,
    tags: ['Épicé', 'Indien', 'Grillé'],
    ingredients: ['Poulet', 'Yaourt', 'Épices tandoori', 'Menthe', 'Citron'],
    nutrition: { calories: '490 cal', proteines: '40g' },
    tempsPreparation: '18'
  },
  {
    id: 6,
    nom: 'Tiramisu',
    categorie: 'desserts',
    prix: 9,
    description: 'Tiramisu maison au café, mascarpone et cacao, recette italienne traditionnelle',
    image: 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 203,
    popular: true,
    vegetarien: true,
    epice: false,
    tags: ['Dessert', 'Café', 'Italien'],
    ingredients: ['Mascarpone', 'Café', 'Biscuits cuillère', 'Cacao', 'Œufs'],
    nutrition: { calories: '380 cal', proteines: '8g' },
    tempsPreparation: '10'
  },
  {
    id: 7,
    nom: 'Soupe à l\'Oignon',
    categorie: 'entrees',
    prix: 10,
    description: 'Soupe traditionnelle à l\'oignon gratinée, croûtons et fromage comté',
    image: 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=600&h=400&fit=crop',
    rating: 4,
    reviews: 94,
    popular: false,
    vegetarien: true,
    epice: false,
    tags: ['Soupe', 'Gratinée', 'Traditionnelle'],
    ingredients: ['Oignons', 'Bouillon boeuf', 'Comté', 'Croûtons', 'Beurre'],
    nutrition: { calories: '320 cal', proteines: '12g' },
    tempsPreparation: '15'
  },
  {
    id: 8,
    nom: 'Magret de Canard',
    categorie: 'viandes',
    prix: 32,
    description: 'Magret de canard rôti, sauce au miel et aux épices, pommes de terre grenaille',
    image: 'https://images.unsplash.com/photo-1558030006-450675393462?w=600&h=400&fit=crop',
    rating: 5,
    reviews: 145,
    popular: true,
    vegetarien: false,
    epice: false,
    tags: ['Canard', 'Rôti', 'Gastronomique'],
    ingredients: ['Magret canard', 'Miel', 'Épices', 'Pommes de terre', 'Échalotes'],
    nutrition: { calories: '720 cal', proteines: '48g' },
    tempsPreparation: '22'
  },
  {
    id: 9,
    nom: 'Salade Niçoise',
    categorie: 'entrees',
    prix: 14,
    description: 'Salade composée au thon, œufs, olives, tomates, artichauts et anchois',
    image: 'https://images.unsplash.com/photo-1565572664659-06daba2eebd8?w=600&h=400&fit=crop',
    rating: 4,
    reviews: 88,
    popular: false,
    vegetarien: false,
    epice: false,
    tags: ['Salade', 'Méditerranéenne', 'Frais'],
    ingredients: ['Thon', 'Œufs', 'Olives', 'Tomates', 'Artichauts', 'Anchois'],
    nutrition: { calories: '410 cal', proteines: '28g' },
    tempsPreparation: '12'
  }
])

// Reactive data
const selectedCategory = ref('all')
const searchQuery = ref('')
const viewMode = ref<'grid' | 'list'>('grid')
const selectedPlat = ref<Plat | null>(null)

// Computed: Filtered plats
const filteredPlats = computed(() => {
  let plats = [...allPlats.value]
  
  // Filter by category
  if (selectedCategory.value !== 'all') {
    if (selectedCategory.value === 'vegetarien') {
      plats = plats.filter(plat => plat.vegetarien === true)
    } else {
      plats = plats.filter(plat => plat.categorie === selectedCategory.value)
    }
  }
  
  // Filter by search query
  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase()
    plats = plats.filter(plat => 
      plat.nom.toLowerCase().includes(query) ||
      plat.description.toLowerCase().includes(query) ||
      plat.tags.some(tag => tag.toLowerCase().includes(query))
    )
  }
  
  return plats
})

// Reset search
const resetSearch = () => {
  selectedCategory.value = 'all'
  searchQuery.value = ''
}

// View plat details
const viewPlatDetails = (plat: Plat) => {
  selectedPlat.value = plat
}

// Close modal
const closeModal = () => {
  selectedPlat.value = null
}

// Commander plat
const commanderPlat = () => {
  if (selectedPlat.value) {
    alert(`Commande passée pour : ${selectedPlat.value.nom}\nPrix : ${selectedPlat.value.prix}€\nMerci pour votre commande !`)
    closeModal()
  }
}

// Ajouter au panier
const ajouterAuPanier = () => {
  if (selectedPlat.value) {
    // Récupérer le panier existant
    const cart = JSON.parse(localStorage.getItem('cart') || '[]')
    cart.push({
      id: selectedPlat.value.id,
      nom: selectedPlat.value.nom,
      prix: selectedPlat.value.prix,
      quantite: 1
    })
    localStorage.setItem('cart', JSON.stringify(cart))
    alert(`${selectedPlat.value.nom} ajouté au panier !`)
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

/* Category tabs hover effect */
.category-tab {
  transition: all 0.3s ease;
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