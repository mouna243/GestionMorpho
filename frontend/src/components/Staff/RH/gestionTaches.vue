<template>
    <div>
   <!-- Sidebar Shell -->
    <aside class="fixed left-0 top-0 h-full w-[260px] bg-[#70cfcb] shadow-2xl flex flex-col h-full py-6 z-50">
      <div class="px-8 mb-10">
        <h1 class="text-2xl font-black text-white font-headline-xl">Morpho Gestion</h1>
        <p class="text-[#e0f7f5] text-label-md">RH Dashboard</p>
      </div>
      <nav class="flex-1 space-y-2">
        <!-- Active State: Tableau de bord -->
         <router-link to="/RH/dashbord">
        <a class="text-white/80 hover:bg-[#5db8b4]/50 rounded-full mx-4 px-4 py-3 flex items-center gap-3 transition-all scale-95 active:scale-90">
          <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
          <span class="font-body-md">Tableau de bord</span>
        </a>
        </router-link>
         <router-link to="/RH/personnel">
        <a class="text-white/80 hover:bg-[#5db8b4]/50 rounded-full mx-4 px-4 py-3 flex items-center gap-3 transition-all scale-95 active:scale-90">
          <span class="material-symbols-outlined" data-icon="group">group</span>
          <span class="font-body-md">Gestion des personnel</span>
        </a>
        </router-link>
        <router-link to="/RH/taches">
        <a class="bg-white text-[#70cfcb] rounded-full mx-4 px-4 py-3 flex items-center gap-3 font-bold transition-all scale-95 active:scale-90">
          <span class="material-symbols-outlined" data-icon="assignment">assignment</span>
          <span class="font-body-md">Taches</span>
        </a>
        </router-link>
      </nav>
      <div class="mt-auto px-6">
        <div class="bg-[#5db8b4]/30 rounded-xl p-4 flex items-center gap-3">
          <!-- icon deconnection -->
          <span class="text-white material-symbols-outlined" data-icon="logout">logout</span>
          <div class="overflow-hidden">
         <!--   logout  -->
            <a href="/login" class="text-white font-bold text-label-md leading-none block">Déconnexion</a>
          </div>
        </div>
      </div>
    </aside>

    <!-- Top Navigation -->
    <header class="fixed top-0 right-0 left-[260px] h-16 bg-white/80 backdrop-blur-md border-b border-slate-100 flex justify-between items-center px-8 w-full z-40">
     
      <div class="flex items-center space-x-4 flex-1">
        <h2 class="text-xl font-bold text-gray-900 font-plus-jakarta">Gestion des taches</h2>
      </div>

    </header>

    </div>
</template>