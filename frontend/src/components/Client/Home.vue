<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold text-indigo-600">HotelManager</h1>
          </div>
          <div class="flex items-center space-x-4">
            <a href="#home" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Accueil</a>
            <a href="#about" class="text-gray-700 hover:text-indigo-600 px-3 py-2">À propos</a>
            <a href="#rooms" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Chambres</a>
            <a href="#contact" class="text-gray-700 hover:text-indigo-600 px-3 py-2">Contact</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Introduction Section -->
    <section id="home" class="pt-16">
      <div class="relative h-screen bg-cover bg-center" :style="{ backgroundImage: `url(${heroImage})` }">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
          <div class="text-center text-white w-full">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
              Bienvenue à l'Hôtel Manager
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-slide-up">
              Découvrez un lieu d'exception où le confort et l'élégance se rencontrent pour créer des moments inoubliables
            </p>
            <div class="space-x-4 animate-slide-up">
              <button class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                Réserver maintenant
              </button>
              <button class="border-2 border-white text-white px-8 py-3 rounded-lg hover:bg-white hover:text-gray-900 transition duration-300">
                Découvrir nos offres
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">À propos de nous</h2>
          <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
          <p class="text-xl text-gray-600 mt-4 max-w-3xl mx-auto">
            Découvrez l'excellence de l'hospitalité depuis plus de 20 ans
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Notre Histoire</h3>
            <p class="text-gray-600 mb-6 leading-relaxed">
              Fondé en 2004, l'Hôtel Manager est devenu une référence dans le domaine de l'hôtellerie de luxe. 
              Notre engagement envers l'excellence et le service personnalisé nous a permis de créer un lieu unique 
              où chaque client se sent chez lui.
            </p>
            <div class="space-y-4">
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
                <p class="text-gray-600">Plus de 10,000 clients satisfaits</p>
              </div>
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
                <p class="text-gray-600">Certifié 5 étoiles depuis 2010</p>
              </div>
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
                <p class="text-gray-600">Équipe professionnelle multilingue</p>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop" alt="Hotel interior" class="rounded-lg shadow-md h-48 w-full object-cover">
            <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?w=400&h=300&fit=crop" alt="Hotel lobby" class="rounded-lg shadow-md h-48 w-full object-cover mt-8">
            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400&h=300&fit=crop" alt="Hotel room" class="rounded-lg shadow-md h-48 w-full object-cover">
            <img src="https://images.unsplash.com/photo-1584132967330-3eace6d7b49c?w=400&h=300&fit=crop" alt="Hotel restaurant" class="rounded-lg shadow-md h-48 w-full object-cover -mt-8">
          </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mt-16">
          <div class="text-center p-6 bg-gray-50 rounded-lg">
            <div class="text-indigo-600 text-4xl mb-4">✓</div>
            <h4 class="text-xl font-semibold mb-2">Service Premium</h4>
            <p class="text-gray-600">Service personnalisé 24h/24 pour répondre à tous vos besoins</p>
          </div>
          <div class="text-center p-6 bg-gray-50 rounded-lg">
            <div class="text-indigo-600 text-4xl mb-4">🏨</div>
            <h4 class="text-xl font-semibold mb-2">Chambres Luxueuses</h4>
            <p class="text-gray-600">Équipements modernes et design élégant pour votre confort</p>
          </div>
          <div class="text-center p-6 bg-gray-50 rounded-lg">
            <div class="text-indigo-600 text-4xl mb-4">🍽️</div>
            <h4 class="text-xl font-semibold mb-2">Restaurant Gastronomique</h4>
            <p class="text-gray-600">Cuisine raffinée préparée par nos chefs étoilés</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Top Chambers Section -->
    <section id="rooms" class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">Nos Meilleures Chambres</h2>
          <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
          <p class="text-xl text-gray-600 mt-4">Découvrez notre sélection de chambres premium</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="room in topChambers" :key="room.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
            <img :src="room.image" :alt="room.name" class="w-full h-56 object-cover">
            <div class="p-6">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-xl font-bold text-gray-900">{{ room.name }}</h3>
                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">{{ room.category }}</span>
              </div>
              <p class="text-gray-600 mb-4">{{ room.description }}</p>
              <div class="flex items-center mb-4">
                <div class="flex text-yellow-400">
                  <span v-for="star in room.rating" :key="star">★</span>
                </div>
                <span class="text-gray-500 text-sm ml-2">({{ room.reviews }} avis)</span>
              </div>
              <div class="flex justify-between items-center">
                <div>
                  <span class="text-2xl font-bold text-indigo-600">{{ room.price }}</span>
                  <span class="text-gray-500">/nuit</span>
                </div>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">
                  Réserver
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center mt-12">
          <button class="border-2 border-indigo-600 text-indigo-600 px-8 py-3 rounded-lg hover:bg-indigo-600 hover:text-white transition duration-300">
            Voir toutes les chambres
          </button>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h2>
          <div class="w-24 h-1 bg-indigo-600 mx-auto"></div>
          <p class="text-xl text-gray-600 mt-4">Nous sommes à votre disposition pour répondre à toutes vos questions</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
          <!-- Contact Form -->
          <div>
            <form @submit.prevent="submitContact" class="space-y-6">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                <input 
                  type="text" 
                  id="name" 
                  v-model="contactForm.name"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                  required
                >
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                  type="email" 
                  id="email" 
                  v-model="contactForm.email"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                  required
                >
              </div>
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                <input 
                  type="tel" 
                  id="phone" 
                  v-model="contactForm.phone"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                >
              </div>
              <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea 
                  id="message" 
                  v-model="contactForm.message"
                  rows="4" 
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                  required
                ></textarea>
              </div>
              <button 
                type="submit" 
                class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300"
              >
                Envoyer le message
              </button>
            </form>
          </div>

          <!-- Contact Info -->
          <div>
            <div class="bg-gray-50 rounded-lg p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Informations de contact</h3>
              <div class="space-y-4">
                <div class="flex items-start space-x-3">
                  <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                  <div>
                    <h4 class="font-semibold text-gray-900">Adresse</h4>
                    <p class="text-gray-600">123 Avenue des Hôtels<br>75001 Paris, France</p>
                  </div>
                </div>
                <div class="flex items-start space-x-3">
                  <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                  </svg>
                  <div>
                    <h4 class="font-semibold text-gray-900">Téléphone</h4>
                    <p class="text-gray-600">+33 1 23 45 67 89</p>
                  </div>
                </div>
                <div class="flex items-start space-x-3">
                  <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                  </svg>
                  <div>
                    <h4 class="font-semibold text-gray-900">Email</h4>
                    <p class="text-gray-600">contact@hotelmanager.com</p>
                  </div>
                </div>
              </div>

              <!-- Map -->
              <div class="mt-6">
                <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                  <p class="text-gray-500">Carte interactive ici</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p>&copy; 2024 HotelManager. Tous droits réservés.</p>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

// Images
const heroImage = ref('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920&h=1080&fit=crop')

// Top chambers data
interface Room {
  id: number
  name: string
  category: string
  description: string
  image: string
  price: string
  rating: number
  reviews: number
}

const topChambers = ref<Room[]>([
  {
    id: 1,
    name: 'Suite Présidentielle',
    category: 'Premium',
    description: 'Suite luxueuse avec vue panoramique sur la ville, jacuzzi et terrasse privée.',
    image: 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=400&h=300&fit=crop',
    price: '450€',
    rating: 5,
    reviews: 128
  },
  {
    id: 2,
    name: 'Chambre Deluxe',
    category: 'Luxe',
    description: 'Chambre spacieuse avec lit king size, bureau et salle de bain privative.',
    image: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400&h=300&fit=crop',
    price: '250€',
    rating: 4,
    reviews: 95
  },
  {
    id: 3,
    name: 'Chambre Junior Suite',
    category: 'Confort',
    description: 'Espace séjour séparé, équipements modernes et design contemporain.',
    image: 'https://images.unsplash.com/photo-1584132967330-3eace6d7b49c?w=400&h=300&fit=crop',
    price: '320€',
    rating: 5,
    reviews: 67
  }
])

// Contact form data
const contactForm = ref({
  name: '',
  email: '',
  phone: '',
  message: ''
})

// Submit contact form
const submitContact = () => {
  console.log('Contact form submitted:', contactForm.value)
  // Here you would typically send the data to your backend API
  alert('Merci pour votre message ! Nous vous répondrons dans les plus brefs délais.')
  contactForm.value = { name: '', email: '', phone: '', message: '' }
}
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slide-up {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 1s ease-out;
}

.animate-slide-up {
  animation: slide-up 0.8s ease-out;
}

html {
  scroll-behavior: smooth;
}
</style>