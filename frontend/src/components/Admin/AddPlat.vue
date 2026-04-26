<template>
    <div class="bg-background text-on-surface">

    <!-- SideNavBar -->
    <aside
        class="fixed left-0 top-0 h-full w-[260px] bg-violet-600 dark:bg-violet-900 shadow-2xl flex flex-col py-6 z-50">
        <div class="px-6 mb-10">
            <h1 class="text-2xl font-black text-white font-plus-jakarta">Morpho Gestion</h1>
            <p class="text-violet-200 text-xs font-semibold uppercase tracking-widest mt-1">Administration</p>
        </div>
        <nav class="flex-1 space-y-2">
            <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span><router-link to="/admin/dashboard">Dashboard</router-link></span>
            </a>
            <a class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined" data-icon="restaurant_menu"
                    style="font-variation-settings: 'FILL' 1;">restaurant_menu</span>
                <span><router-link to="/admin/plats">Gestion des plats</router-link></span>
            </a>
            <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                <span><router-link to="/admin/departements">Gestion Départements</router-link></span>
            </a>
            <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined">calendar_clock</span>
                <span><router-link to="/admin/WorkShift">Gestion des WorkShifts</router-link></span>
            </a>
                        <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined">king_bed</span>
                <span><router-link to="/admin/chambers">Gestion des Chambers</router-link></span>
            </a>
        </nav>
        <div class="px-4 mt-auto pt-6 border-t border-violet-500/30">

            <div class="space-y-1">
                <a class="text-violet-100 hover:text-white px-4 py-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                    href="#">
                    <span class="material-symbols-outlined" data-icon="help">help</span>
                    <span>Aide</span>
                </a>
                <a class="text-violet-100 hover:text-white px-4 py-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                    href="#">
                    <span class="material-symbols-outlined" data-icon="logout">logout</span>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </aside>

        <!-- Main Content Area -->
        <main class="ml-[260px] min-h-screen">
            <!-- TopAppBar -->
            <header
                class="sticky top-0 z-40 w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 shadow-sm flex justify-between items-center px-8 py-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white font-plus-jakarta">Gestion des Plats</h2>
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-violet-600">search</span>
                        <input
                            class="pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-violet-500 transition-all outline-none"
                            placeholder="Rechercher un plat..." type="text" />
                    </div>
                    <div class="flex items-center gap-4 border-l pl-6 border-gray-200">
                        <button class="relative text-gray-500 hover:text-violet-600 transition-colors">
                            <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full"></span>
                        </button>
                        <div class="flex items-center gap-2 cursor-pointer group">
                            <div
                                class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center text-violet-600">
                                <span class="material-symbols-outlined" data-icon="account_circle">account_circle</span>
                            </div>
                            <span
                                class="text-sm font-bold text-gray-700 group-hover:text-violet-600 transition-colors">Admin</span>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Canvas -->
            <div class="p-8">
                <div class="grid grid-cols-12 gap-8">
                    <!-- Plate Gallery Section -->
                    <section class="col-span-12 lg:col-span-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="font-headline-lg text-headline-lg text-on-surface">Galerie des Plats</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Visualisez et gérez votre
                                    menu actuel</p>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    class="p-2 rounded-lg bg-white shadow-sm border border-gray-100 text-violet-600">
                                    <span class="material-symbols-outlined">grid_view</span>
                                </button>
                                <button class="p-2 rounded-lg bg-white shadow-sm border border-gray-100 text-gray-400">
                                    <span class="material-symbols-outlined">list</span>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Plate Card 1 -->
                            <div
                                class="bg-surface-container-lowest rounded-xl shadow-md hover:shadow-xl transition-all group overflow-hidden border border-white">
                                <div class="h-48 overflow-hidden relative">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        data-alt="Gourmet wagyu beef burger with melted cheddar, caramelized onions, and fresh arugula on a toasted brioche bun, professional food photography"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5Wwq243iJurSYmOb2-E4NK9GwtT8nilIeJoM8Nbl5aay3tKZLYQb1_-zWSqeEAWzb3uDrjSOZGzHBeLBiMiVtPdruOVg8BKNargqUm1GsHg5jDPP729ryReCNOF6fDhVNza5Nui06luOQhORxjdn7V95SlfiGrjpQxnbYJrocmof37_mz_ebf42h4_g5ggUwjFW5-fLQ0ubC15c-8Sjzm_o6Qvn65NXOlUZ9ECDK2sP_eW5wUsuwC-pgqC-wtF1C_ARoq0UVX0C0" />
                                    <span
                                        class="absolute top-3 right-3 bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Best
                                        Seller</span>
                                </div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg text-on-surface">Burger Wagyu Signature</h4>
                                        <span class="text-violet-600 font-extrabold">24.50 €</span>
                                    </div>
                                    <span
                                        class="bg-secondary-fixed text-on-secondary-fixed text-[11px] font-bold px-2 py-0.5 rounded-md uppercase">Premium
                                        Burgers</span>
                                    <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                        <div class="flex gap-1">
                                            <span class="material-symbols-outlined text-yellow-500 text-sm"
                                                style="font-variation-settings: 'FILL' 1;">star</span>
                                            <span class="text-xs font-bold text-gray-600">4.9 (128)</span>
                                        </div>
                                        <button
                                            class="text-violet-600 hover:bg-violet-50 p-2 rounded-full transition-colors">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Plate Card 2 -->
                            <div
                                class="bg-surface-container-lowest rounded-xl shadow-md hover:shadow-xl transition-all group overflow-hidden border border-white">
                                <div class="h-48 overflow-hidden relative">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        data-alt="Vibrant mediterranean poke bowl with fresh tuna, avocado, edamame, and pickled ginger, bright natural studio lighting"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCaw2XOl2CZsxl4MAi34jChKMBOAHAaoNizs4nmD9KB2Egb9p02EMH7zN_LdvytFOFCJ_n90gXfRKHZ9ke6XN4fgBAFzjOydVbz7jPVSJWoy9xIpxW5V_cjV22CGUVPyNtSzI0CH1jeSMzqvaIAFDjsTeyPNaa48pgORS1cZb5R5oVa5GExn322JkR64bP__fo20-8FI0FQdaF6KImltbTeAeEbi-Iyv3bc0D9eUJIvUfZq7JuQ7EBq3DRF74RkeeHwMhE4RrV-trw" />
                                    <span
                                        class="absolute top-3 right-3 bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Healthy</span>
                                </div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg text-on-surface">Bowl Thon Mariné</h4>
                                        <span class="text-violet-600 font-extrabold">18.00 €</span>
                                    </div>
                                    <span
                                        class="bg-secondary-fixed text-on-secondary-fixed text-[11px] font-bold px-2 py-0.5 rounded-md uppercase">Healthy
                                        Bowls</span>
                                    <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                        <div class="flex gap-1">
                                            <span class="material-symbols-outlined text-yellow-500 text-sm"
                                                style="font-variation-settings: 'FILL' 1;">star</span>
                                            <span class="text-xs font-bold text-gray-600">4.7 (85)</span>
                                        </div>
                                        <button
                                            class="text-violet-600 hover:bg-violet-50 p-2 rounded-full transition-colors">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Plate Card 3 -->
                            <div
                                class="bg-surface-container-lowest rounded-xl shadow-md hover:shadow-xl transition-all group overflow-hidden border border-white">
                                <div class="h-48 overflow-hidden relative">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        data-alt="Traditional wood-fired Neapolitan pizza with buffalo mozzarella, fresh basil leaves, and vibrant tomato sauce, rustic kitchen setting"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCr3LdaTcY1Gv6euA4EPDC7L4yAmnW34a1Dp1q6aUi3n2jjztbd3efBoOlrLSM8oNgw93CrfZ5CGkggfZyez5xfC1YT3FrYqZDFl3zUbQa9afyxrU9cuzuOBaiy3CoiX9N0JvjEJ8BK7c2y9PNot6Ld-oUUo6G48e0Qt0i0VrSiTycnnjoqUH9Lo0AsWJt-EuHvS9Zb5E994fBZ54gcAuADbqAOneJFpP3ttFJwzWoGG80MjDnsVjHSZmh4IXKnW5nPDJ0InJVwgwY" />
                                </div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg text-on-surface">Pizza Buffalo</h4>
                                        <span class="text-violet-600 font-extrabold">16.50 €</span>
                                    </div>
                                    <span
                                        class="bg-secondary-fixed text-on-secondary-fixed text-[11px] font-bold px-2 py-0.5 rounded-md uppercase">Italien</span>
                                    <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                        <div class="flex gap-1">
                                            <span class="material-symbols-outlined text-yellow-500 text-sm"
                                                style="font-variation-settings: 'FILL' 1;">star</span>
                                            <span class="text-xs font-bold text-gray-600">4.8 (210)</span>
                                        </div>
                                        <button
                                            class="text-violet-600 hover:bg-violet-50 p-2 rounded-full transition-colors">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Plate Card 4 -->
                            <div
                                class="bg-surface-container-lowest rounded-xl shadow-md hover:shadow-xl transition-all group overflow-hidden border border-white">
                                <div class="h-48 overflow-hidden relative">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        data-alt="Delicate matcha green tea mille crepe cake with light cream layers, elegant minimalist dessert presentation on a white plate"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBcwhEssm-WTBs6IPkk0FZZexIY4OPX64VP5BlUOHuDm8RHUjgJ8VfzXI5hQNPF2C_xzRCueftPEY88KgvmPtwfzFbAh-uqVbjTslUEDRkTqZBEMfrQYvSih_611-uMOud8bjzN9TwGlRlNeB0TzQ0jJRpMtkyNyWGKpbCfkLLcacEFQE92npNAIykJaCmAzzdiE6I4XB8MGw3iGcmofi0vIeHpgQWZ2zav_xBLI0V927uk4v8pQgVMDiYSFEyE6HXoqMU1QGLfxw8" />
                                    <span
                                        class="absolute top-3 right-3 bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Chef's
                                        Pick</span>
                                </div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg text-on-surface">Mille-Feuille Matcha</h4>
                                        <span class="text-violet-600 font-extrabold">12.00 €</span>
                                    </div>
                                    <span
                                        class="bg-secondary-fixed text-on-secondary-fixed text-[11px] font-bold px-2 py-0.5 rounded-md uppercase">Desserts</span>
                                    <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                        <div class="flex gap-1">
                                            <span class="material-symbols-outlined text-yellow-500 text-sm"
                                                style="font-variation-settings: 'FILL' 1;">star</span>
                                            <span class="text-xs font-bold text-gray-600">5.0 (42)</span>
                                        </div>
                                        <button
                                            class="text-violet-600 hover:bg-violet-50 p-2 rounded-full transition-colors">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Add New Plate Form Section -->
                    <aside class="col-span-12 lg:col-span-4">
                        <div class="sticky top-24 bg-white rounded-2xl shadow-2xl p-6 border border-violet-50">
                            <div class="flex items-center gap-3 mb-8">
                                <div
                                    class="w-12 h-12 bg-violet-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-violet-200">
                                    <span class="material-symbols-outlined">add_circle</span>
                                </div>
                                <div>
                                    <h3 class="font-headline-lg text-headline-lg text-on-surface leading-tight">Nouveau
                                        Plat</h3>
                                    <p class="text-xs text-gray-500 font-medium">Ajouter à la carte</p>
                                </div>
                            </div>
                            <form class="space-y-5">
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Nom du Plat</label>
                                    <input
                                        class="w-full px-4 py-3 bg-surface-container-low border border-gray-100 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all outline-none"
                                        placeholder="ex: Risotto aux truffes" type="text" />
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Catégorie</label>
                                    <div class="relative">
                                        <select
                                            class="w-full appearance-none px-4 py-3 bg-surface-container-low border border-gray-100 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary transition-all outline-none text-gray-700">
                                            <option>Sélectionner une catégorie</option>
                                            <option>Entrées</option>
                                            <option>Plats Principaux</option>
                                            <option>Desserts</option>
                                            <option>Boissons</option>
                                        </select>
                                        <span
                                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">expand_more</span>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Prix (€)</label>
                                    <div class="relative">
                                        <input
                                            class="w-full px-4 py-3 bg-surface-container-low border border-gray-100 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all outline-none"
                                            placeholder="0.00" step="0.01" type="number" />
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">€</span>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Image du Plat</label>
                                    <div class="relative group cursor-pointer">
                                        <div
                                            class="w-full h-32 border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center gap-2 bg-gray-50 group-hover:bg-violet-50 group-hover:border-violet-200 transition-all">
                                            <span
                                                class="material-symbols-outlined text-gray-400 group-hover:text-violet-500">cloud_upload</span>
                                            <span
                                                class="text-xs font-bold text-gray-500 group-hover:text-violet-600">Cliquez
                                                pour télécharger</span>
                                        </div>
                                        <input class="absolute inset-0 opacity-0 cursor-pointer" type="file" />
                                    </div>
                                </div>
                                <div class="pt-4 space-y-3">
                                    <button
                                        class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-violet-200 active:scale-95 transition-all flex items-center justify-center gap-2"
                                        type="submit">
                                        <span class="material-symbols-outlined">save</span>
                                        Enregistrer le plat
                                    </button>
                                    <button
                                        class="w-full bg-transparent hover:bg-gray-50 text-gray-500 font-bold py-2 rounded-xl transition-all text-sm"
                                        type="reset">
                                        Réinitialiser le formulaire
                                    </button>
                                </div>
                            </form>
                                 <!-- Statistics/Brief Card -->
                        <div class="mt-6 bg-secondary text-white rounded-2xl p-6 shadow-xl relative overflow-hidden bg-violet-600">
                            <div class="relative z-10">
                                <h4 class="font-bold text-lg mb-1">Résumé du Menu</h4>
                                <div class="space-y-3 mt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm opacity-80">Total des plats</span>
                                        <span class="font-black">48</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm opacity-80">Catégories</span>
                                        <span class="font-black">6</span>
                                    </div>
                                    <div class="w-full bg-white/20 h-2 rounded-full mt-2">
                                        <div class="bg-white h-full rounded-full" style="width: 75%"></div>
                                    </div>
                                    <p class="text-[10px] uppercase font-bold tracking-widest opacity-60">75% du menu
                                        optimisé</p>
                                </div>
                            </div>
                            <div class="absolute -right-4 -bottom-4 opacity-10">
                                <span class="material-symbols-outlined !text-8xl">restaurant</span>
                            </div>
                        </div>
                        </div>
                   
                    </aside>
                </div>
            </div>
        </main>
    </div>
</template>