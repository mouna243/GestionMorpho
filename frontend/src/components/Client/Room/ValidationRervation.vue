frontend/src/components/HelloWorld.vue<template>
  <div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Success Animation -->
      <div class="text-center mb-8 animate-success">
        <div class="success-checkmark">
          <div class="check-icon">
            <span class="icon-line line-tip"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
          </div>
        </div>
      </div>

      <!-- Confirmation Card -->
      <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 text-white text-center">
          <h1 class="text-3xl font-bold mb-2">Réservation Confirmée !</h1>
          <p class="text-green-100">Votre réservation a été enregistrée avec succès</p>
        </div>

        <!-- Confirmation Message -->
        <div class="p-8 border-b border-gray-200">
          <div class="text-center mb-6">
            <div class="inline-block bg-green-100 rounded-full px-4 py-2 mb-4">
              <span class="text-green-600 font-semibold">✓ Confirmation immédiate</span>
            </div>
            <p class="text-gray-600">
              Un email de confirmation a été envoyé à votre adresse email avec tous les détails de votre réservation.
            </p>
          </div>

          <!-- Reservation Number -->
          <div class="bg-gray-50 rounded-lg p-4 text-center mb-6">
            <p class="text-sm text-gray-500 mb-1">Numéro de réservation</p>
            <p class="text-2xl font-bold text-indigo-600">{{ reservationNumber }}</p>
            <button 
              @click="copyReservationNumber"
              class="mt-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium"
            >
              📋 Copier le numéro
            </button>
          </div>

          <!-- Reservation Details -->
          <div class="space-y-6">
            <h2 class="text-xl font-bold text-gray-900 flex items-center">
              <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Détails de la réservation
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
              <!-- Dates -->
              <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center mb-3">
                  <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  <h3 class="font-semibold text-gray-900">Dates du séjour</h3>
                </div>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Arrivée :</span>
                    <span class="font-medium">{{ formatDate(reservationData.date_enter) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Départ :</span>
                    <span class="font-medium">{{ formatDate(reservationData.date_sortie) }}</span>
                  </div>
                  <div class="flex justify-between pt-2 border-t">
                    <span class="text-gray-600">Nombre de nuits :</span>
                    <span class="font-semibold text-indigo-600">{{ reservationData.numberOfNights }}</span>
                  </div>
                </div>
              </div>

              <!-- Room Info -->
              <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center mb-3">
                  <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                  </svg>
                  <h3 class="font-semibold text-gray-900">Chambre réservée</h3>
                </div>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Type :</span>
                    <span class="font-medium">{{ reservationData.roomName }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Catégorie :</span>
                    <span class="font-medium">{{ reservationData.roomCategory }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Personnes :</span>
                    <span class="font-medium">{{ reservationData.guests }} personne(s)</span>
                  </div>
                </div>
              </div>

              <!-- Price Details -->
              <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center mb-3">
                  <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <h3 class="font-semibold text-gray-900">Détail du prix</h3>
                </div>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Prix par nuit :</span>
                    <span>{{ reservationData.pricePerNight }}€</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Nombre de nuits :</span>
                    <span>{{ reservationData.numberOfNights }}</span>
                  </div>
                  <div class="flex justify-between pt-2 border-t font-bold">
                    <span class="text-gray-900">Total à payer :</span>
                    <span class="text-xl text-indigo-600">{{ reservationData.totalPrice }}€</span>
                  </div>
                </div>
              </div>

              <!-- Client Info -->
              <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center mb-3">
                  <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  <h3 class="font-semibold text-gray-900">Informations client</h3>
                </div>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Nom :</span>
                    <span class="font-medium">{{ clientInfo.name }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Email :</span>
                    <span>{{ clientInfo.email }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Téléphone :</span>
                    <span>{{ clientInfo.phone }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Special Requests -->
            <div v-if="reservationData.specialRequests" class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
              <div class="flex items-start">
                <svg class="h-5 w-5 text-yellow-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                  <h3 class="font-semibold text-yellow-800 mb-1">Demandes spéciales</h3>
                  <p class="text-sm text-yellow-700">{{ reservationData.specialRequests }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-200">
          <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Prochaines étapes
          </h2>
          <div class="grid md:grid-cols-3 gap-4">
            <div class="text-center">
              <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="text-indigo-600 font-bold">1</span>
              </div>
              <p class="font-medium text-gray-900">Vérification</p>
              <p class="text-sm text-gray-500">Vérifiez vos emails</p>
            </div>
            <div class="text-center">
              <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="text-indigo-600 font-bold">2</span>
              </div>
              <p class="font-medium text-gray-900">Préparation</p>
              <p class="text-sm text-gray-500">Nous préparons votre séjour</p>
            </div>
            <div class="text-center">
              <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="text-indigo-600 font-bold">3</span>
              </div>
              <p class="font-medium text-gray-900">Arrivée</p>
              <p class="text-sm text-gray-500">Profitez de votre séjour</p>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="px-8 py-6 bg-white">
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button 
              @click="printConfirmation"
              class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-300 flex items-center justify-center"
            >
              <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
              </svg>
              Imprimer
            </button>
            <button 
              @click="downloadPDF"
              class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center justify-center"
            >
              <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
              </svg>
              Télécharger PDF
            </button>
            <button 
              @click="goToHome"
              class="px-6 py-3 border-2 border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition duration-300 flex items-center justify-center"
            >
              <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Retour à l'accueil
            </button>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-500">
          <p>Une question ? Contactez notre service client au <span class="font-semibold">+33 1 23 45 67 89</span></p>
          <p class="mt-1">ou par email : <span class="font-semibold">reservations@hotelmanager.com</span></p>
        </div>
      </div>

      <!-- Share Section -->
      <div class="mt-8 text-center">
        <p class="text-gray-600 mb-3">Partagez votre réservation</p>
        <div class="flex justify-center space-x-4">
          <button class="text-blue-600 hover:text-blue-700 transition">
            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
            </svg>
          </button>
          <button class="text-blue-400 hover:text-blue-500 transition">
            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.968-11.962c0-.21-.005-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
            </svg>
          </button>
          <button class="text-green-600 hover:text-green-700 transition">
            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451c.98 0 1.771-.773 1.771-1.729V1.729C24 .774 23.203 0 22.225 0z"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'


// Reservation data
const reservationNumber = ref('')
const reservationData = ref({
  date_enter: '',
  date_sortie: '',
  numberOfNights: 0,
  roomName: '',
  roomCategory: '',
  pricePerNight: 0,
  totalPrice: 0,
  guests: 0,
  specialRequests: ''
})

const clientInfo = ref({
  name: '',
  email: '',
  phone: ''
})

// Copy reservation number
const copyReservationNumber = () => {
  navigator.clipboard.writeText(reservationNumber.value)
  alert('Numéro de réservation copié !')
}

// Print confirmation
const printConfirmation = () => {
  window.print()
}

// Download PDF (simulation)
const downloadPDF = () => {
  alert('Fonctionnalité de téléchargement PDF à venir. Pour l\'instant, vous pouvez imprimer la page.')
}

// Go to home
const goToHome = () => {
}

// Format date
const formatDate = (dateString: string) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

// Load reservation data from localStorage
onMounted(() => {
  // Generate random reservation number
  reservationNumber.value = `RES-${Math.floor(Math.random() * 1000000)}`.padEnd(11, '0')
  
  // Load data from localStorage (sent from reservation page)
  const savedReservation = localStorage.getItem('lastReservation')
  if (savedReservation) {
    try {
      const data = JSON.parse(savedReservation)
      reservationData.value = data.reservation
      clientInfo.value = data.client
    } catch (e) {
      console.error('Error loading reservation data:', e)
      // Set default demo data
      setDefaultData()
    }
  } else {
    // Set default demo data for testing
    setDefaultData()
  }
})

// Default demo data
const setDefaultData = () => {
  reservationData.value = {
    date_enter: new Date().toISOString().split('T')[0],
    date_sortie: new Date(Date.now() + 3 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
    numberOfNights: 3,
    roomName: 'Suite Présidentielle',
    roomCategory: 'Premium',
    pricePerNight: 450,
    totalPrice: 1350,
    guests: 2,
    specialRequests: 'Lit bébé supplémentaire, vue sur la mer si possible'
  }
  
  clientInfo.value = {
    name: 'Jean Dupont',
    email: 'jean.dupont@email.com',
    phone: '+33 6 12 34 56 78'
  }
}
</script>

<style scoped>
/* Success Animation */
.success-checkmark {
  width: 80px;
  height: 115px;
  margin: 0 auto;
}

.success-checkmark .check-icon {
  width: 80px;
  height: 80px;
  position: relative;
  border-radius: 50%;
  box-sizing: content-box;
  border: 4px solid #4caf50;
}

.success-checkmark .check-icon::before {
  top: 3px;
  left: -2px;
  width: 30px;
  transform-origin: 100% 50%;
  border-radius: 100px;
  position: absolute;
  height: 50px;
  content: "";
  background-color: white;
}

.success-checkmark .check-icon::after {
  top: 0;
  left: 0;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  position: absolute;
  content: "";
  background-color: white;
}

.success-checkmark .icon-line {
  height: 5px;
  background-color: #4caf50;
  display: block;
  border-radius: 2px;
  position: absolute;
  z-index: 10;
}

.success-checkmark .icon-line.line-tip {
  top: 46px;
  left: 14px;
  width: 25px;
  transform: rotate(45deg);
  animation: icon-line-tip 0.75s;
}

.success-checkmark .icon-line.line-long {
  top: 38px;
  right: 8px;
  width: 47px;
  transform: rotate(-45deg);
  animation: icon-line-long 0.75s;
}

.success-checkmark .icon-circle {
  top: -4px;
  left: -4px;
  z-index: 10;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  position: absolute;
  box-sizing: content-box;
  border: 4px solid rgba(76, 175, 80, 0.5);
}

.success-checkmark .icon-fix {
  top: 8px;
  width: 5px;
  left: 26px;
  z-index: 1;
  height: 85px;
  position: absolute;
  transform: rotate(-45deg);
  background-color: white;
}

@keyframes icon-line-tip {
  0% {
    width: 0;
    left: 1px;
    top: 19px;
  }
  54% {
    width: 0;
    left: 1px;
    top: 19px;
  }
  70% {
    width: 50px;
    left: -8px;
    top: 37px;
  }
  84% {
    width: 17px;
    left: 21px;
    top: 48px;
  }
  100% {
    width: 25px;
    left: 14px;
    top: 46px;
  }
}

@keyframes icon-line-long {
  0% {
    width: 0;
    right: 46px;
    top: 54px;
  }
  65% {
    width: 0;
    right: 46px;
    top: 54px;
  }
  84% {
    width: 55px;
    right: 0px;
    top: 35px;
  }
  100% {
    width: 47px;
    right: 8px;
    top: 38px;
  }
}

/* Print styles */
@media print {
  button, .share-section, .action-buttons {
    display: none !important;
  }
  
  body {
    background: white;
    padding: 0;
    margin: 0;
  }
  
  .min-h-screen {
    padding: 0;
  }
  
  .shadow-xl {
    box-shadow: none;
  }
}

/* Animation */
.animate-success {
  animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>