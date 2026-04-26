<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-green-50">
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
                <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                    href="#">
                    <span class="material-symbols-outlined" data-icon="restaurant_menu"
                        style="font-variation-settings: 'FILL' 1;">restaurant_menu</span>
                    <span><router-link to="/admin/plats">Gestion des plats</router-link></span>
                </a>
                <a
                    class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold">
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

        <!-- TopAppBar Component -->
        <header
            class="fixed top-0 right-0 w-[calc(100%-260px)] h-16 z-40 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 shadow-sm border-b border-slate-100">
            <div class="flex items-center space-x-4 flex-1">
                <div class="relative max-w-md w-full">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                    <input
                        class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-[#6b38d4]/20 placeholder:text-slate-400"
                        placeholder="Rechercher un département..." type="text" />
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-4">
                    <button class="text-slate-500 hover:text-[#6b38d4] transition-colors relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span
                            class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full border-2 border-white"></span>
                    </button>
                    <button class="text-slate-500 hover:text-[#6b38d4] transition-colors">
                        <span class="material-symbols-outlined">help_outline</span>
                    </button>
                </div>
                <div class="h-8 w-px bg-slate-200 mx-2"></div>
                <button
                    class="flex items-center space-x-2 text-slate-900 font-medium hover:text-[#6b38d4] transition-colors">
                    <span class="text-sm font-semibold">Morpho Gestion</span>
                    <span class="material-symbols-outlined text-[#6b38d4]">expand_more</span>
                </button>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="ml-[260px] pt-16 min-h-screen p-8"
            style="background-image: radial-gradient(circle at 2px 2px, rgba(107, 56, 212, 0.05) 1px, transparent 0); background-size: 24px 24px;">
            <div class="max-w-7xl mx-auto space-y-8">
                <!-- Page Header -->
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-[28px] leading-9 font-bold text-slate-900">Gestion des Départements</h2>
                        <p class="text-[#494454] text-sm">Organisez et gérez votre structure organisationnelle.</p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">download</span> Exporter
                        </button>
                    </div>
                </div>

                <!-- Bento Layout Content -->
                <div class="grid grid-cols-12 gap-6">
                    <!-- Départements List Section (Left Column) -->
                    <div class="col-span-12 lg:col-span-8 space-y-6">
                        <div
                            class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden">
                            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-slate-900">Liste des Départements</h3>
                                <span class="bg-[#e9ddff] text-[#5516be] text-xs font-bold px-3 py-1 rounded-full">4
                                    Actifs</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50/50">
                                        <tr>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                                Département</th>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                                Description</th>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">
                                                Statut</th>
                                            <th
                                                class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <!-- Hospitality -->
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-[#e9ddff] flex items-center justify-center text-[#6b38d4]">
                                                        <span class="material-symbols-outlined">hotel</span>
                                                    </div>
                                                    <span class="font-bold text-slate-900">Hospitality</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">Gestion de l'accueil et des
                                                services hôteliers</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Actif</span>
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2">
                                                <button
                                                    class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">edit</span>
                                                </button>
                                                <button
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Kitchen -->
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-[#6ffbbe]/20 flex items-center justify-center text-[#006947]">
                                                        <span class="material-symbols-outlined">restaurant</span>
                                                    </div>
                                                    <span class="font-bold text-slate-900">Kitchen</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">Préparation culinaire et
                                                gestion des cuisines</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Actif</span>
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2">
                                                <button
                                                    class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">edit</span>
                                                </button>
                                                <button
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Spa -->
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-[#d8e2ff] flex items-center justify-center text-[#0058be]">
                                                        <span class="material-symbols-outlined">spa</span>
                                                    </div>
                                                    <span class="font-bold text-slate-900">Spa & Wellness</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">Services de bien-être, massage
                                                et détente</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Actif</span>
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2">
                                                <button
                                                    class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">edit</span>
                                                </button>
                                                <button
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Maintenance -->
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="px-6 py-4 border-b-0">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-[#e0e3e5] flex items-center justify-center text-[#494454]">
                                                        <span class="material-symbols-outlined">handyman</span>
                                                    </div>
                                                    <span class="font-bold text-slate-900">Maintenance</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 border-b-0 text-sm text-slate-600">Gestion technique et
                                                maintenance des équipements</td>
                                            <td class="px-6 py-4 border-b-0">
                                                <span
                                                    class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">Inactif</span>
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2 border-b-0">
                                                <button
                                                    class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">edit</span>
                                                </button>
                                                <button
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Statistics Insight Card -->
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-[#6b38d4] text-white p-6 rounded-xl shadow-lg relative overflow-hidden group">
                                <div class="relative z-10">
                                    <p class="text-white/80 font-semibold text-xs mb-1">Total Départements</p>
                                    <h4 class="text-3xl font-black">8</h4>
                                    <div
                                        class="mt-4 inline-flex items-center text-xs font-bold bg-white/20 px-2 py-1 rounded-md">
                                        +2 cette année
                                    </div>
                                </div>
                                <span
                                    class="material-symbols-outlined absolute -bottom-4 -right-4 text-white/10 text-9xl group-hover:scale-110 transition-transform">domain</span>
                            </div>
                            <div
                                class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 relative overflow-hidden">
                                <p class="text-[#494454] font-semibold text-xs mb-1">Taux d'activité</p>
                                <h4 class="text-3xl font-black text-slate-900">75%</h4>
                                <div class="mt-4 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-[#006947] h-full w-[75%]"></div>
                                </div>
                                <p class="mt-2 text-[10px] font-bold text-slate-400">6 départements actifs sur 8</p>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Department Section (Right Column) -->
                    <div class="col-span-12 lg:col-span-4">
                        <div
                            class="sticky top-24 bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] p-6 border border-slate-50">
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-slate-900">Ajouter un Département</h3>
                                <p class="text-[#494454] text-sm mt-1">Créez une nouvelle catégorie organisationnelle.
                                </p>
                            </div>
                            <form class="space-y-6">
                                <!-- Champ Name (obligatoire) -->
                                <div class="space-y-2">
                                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                        Nom du département <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" required
                                        class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                        placeholder="Ex: Marketing, RH, Finance..." />
                                </div>

                                <!-- Champ Description (obligatoire) -->
                                <div class="space-y-2">
                                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="description" required rows="4"
                                        class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"
                                        placeholder="Décrivez les responsabilités et objectifs de ce département..."></textarea>
                                </div>

                                <!-- Champ Is_active (obligatoire) -->
                                <div class="space-y-2">
                                    <label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
                                        Statut <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-6 pt-2">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="is_active" value="active" checked
                                                class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4] focus:ring-2 border-slate-300" />
                                            <span class="text-sm text-slate-700">Actif</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="is_active" value="inactive"
                                                class="w-4 h-4 text-[#6b38d4] focus:ring-[#6b38d4] focus:ring-2 border-slate-300" />
                                            <span class="text-sm text-slate-700">Inactif</span>
                                        </label>
                                    </div>
                                </div>

                       

                                <!-- Bouton de soumission -->
                                <div class="pt-2">
                                    <button
                                        class="w-full bg-[#6b38d4] text-white font-bold py-4 rounded-xl shadow-lg shadow-[#6b38d4]/20 hover:bg-[#8455ef] active:scale-[0.98] transition-all"
                                        type="submit">
                                        Ajouter le département
                                    </button>
                                    <p class="text-xs text-center text-slate-400 mt-3 italic">Formulaire avec champs
                                        obligatoires : nom, description, statut</p>
                                </div>
                            </form>

                            <!-- Message informatif -->
                            <div class="mt-8 p-4 bg-[#d8e2ff] rounded-xl flex items-start space-x-3">
                                <span class="material-symbols-outlined text-[#004395]">info</span>
                                <p class="text-[11px] leading-tight text-[#004395] font-medium">
                                    Les champs <strong>Nom</strong>, <strong>Description</strong> et
                                    <strong>Statut</strong> sont obligatoires pour créer un département.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</template>