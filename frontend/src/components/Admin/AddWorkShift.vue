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
            <a class="text-violet-100 hover:text-white px-4 py-2 mx-2 flex items-center gap-3 transition-colors font-plus-jakarta text-sm font-semibold"
                href="#">
                <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                <span><router-link to="/admin/departements">Gestion Départements</router-link></span>
            </a>
            <a class="bg-white text-violet-600 rounded-full px-4 py-2 mx-2 flex items-center gap-3 transition-all font-plus-jakarta text-sm font-semibold"
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
<header class="fixed top-0 right-0 w-[calc(100%-260px)] h-16 z-40 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 shadow-sm border-b border-slate-100">
<div class="flex items-center space-x-4 flex-1">
<div class="relative max-w-md w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
<input class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-[#6b38d4]/20 placeholder:text-slate-400" placeholder="Rechercher un workshift ou employé..." type="text"/>
</div>
</div>
<div class="flex items-center space-x-6">
<div class="flex items-center space-x-4">
<button class="text-slate-500 hover:text-[#6b38d4] transition-colors relative">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full border-2 border-white"></span>
</button>
<button class="text-slate-500 hover:text-[#6b38d4] transition-colors">
<span class="material-symbols-outlined">help_outline</span>
</button>
</div>
<div class="h-8 w-px bg-slate-200 mx-2"></div>
<button class="flex items-center space-x-2 text-slate-900 font-medium hover:text-[#6b38d4] transition-colors">
<span class="text-sm font-semibold">Gestion des présences</span>
<span class="material-symbols-outlined text-[#6b38d4]">expand_more</span>
</button>
</div>
</header>

<!-- Main Content Area -->
<main class="ml-[260px] pt-16 min-h-screen p-8" style="background-image: radial-gradient(circle at 2px 2px, rgba(107, 56, 212, 0.05) 1px, transparent 0); background-size: 24px 24px;">
<div class="max-w-7xl mx-auto space-y-8">
<!-- Page Header -->
<div class="flex justify-between items-end">
<div>
<h2 class="text-[28px] leading-9 font-bold text-slate-900">Gestion des Workshifts & Absences</h2>
<p class="text-[#494454] text-sm">Planifiez les équipes et suivez les absences du personnel.</p>
</div>
<div class="flex space-x-3">
<button class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
<span class="material-symbols-outlined text-lg">download</span> Exporter
</button>
</div>
</div>

<!-- Section 1: Ajout Workshift -->
<div class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden">
<div class="p-6 border-b border-slate-100">
<h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
<span class="material-symbols-outlined text-[#6b38d4]">schedule</span>
Ajouter un Workshift
</h3>
<p class="text-[#494454] text-sm mt-1">Planifiez une nouvelle période de travail</p>
</div>
<div class="p-6">
<form class="grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- departement_id -->
<div class="space-y-2">
<label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
Département <span class="text-red-500">*</span>
</label>
<select name="departement_id" required class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all bg-white">
<option value="">Sélectionner un département</option>
<option value="1">Hospitality</option>
<option value="2">Kitchen</option>
<option value="3">Spa & Wellness</option>
<option value="4">Maintenance</option>
<option value="5">Marketing</option>
<option value="6">Ressources Humaines</option>
</select>
</div>

<!-- date_debut -->
<div class="space-y-2">
<label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
Date de début <span class="text-red-500">*</span>
</label>
<input type="datetime-local" name="date_debut" required class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"/>
</div>

<!-- date_fin -->
<div class="space-y-2">
<label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
Date de fin <span class="text-red-500">*</span>
</label>
<input type="datetime-local" name="date_fin" required class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"/>
</div>

<!-- check_in -->
<div class="space-y-2">
<label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
Check-in (heure d'arrivée) <span class="text-red-500">*</span>
</label>
<input type="time" name="check_in" required class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"/>
<p class="text-xs text-slate-400 mt-1">Heure de début de poste</p>
</div>

<!-- check_out -->
<div class="space-y-2">
<label class="font-semibold text-xs text-slate-700 flex items-center gap-1">
Check-out (heure de sortie) <span class="text-red-500">*</span>
</label>
<input type="time" name="check_out" required class="w-full border-slate-200 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#6b38d4]/20 focus:border-[#6b38d4] transition-all"/>
<p class="text-xs text-slate-400 mt-1">Heure de fin de poste</p>
</div>

<div class="md:col-span-2 pt-4">
<button type="submit" class="w-full md:w-auto bg-[#6b38d4] text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-[#6b38d4]/20 hover:bg-[#8455ef] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined">add</span>
Créer le Workshift
</button>
</div>
</form>

<!-- Récapitulatif des champs obligatoires -->

</div>
</div>

<!-- Section 2: Liste des Workshifts actifs -->
<div class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden mt-6">
<div class="p-6 border-b border-slate-100">
<h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
<span class="material-symbols-outlined text-[#6b38d4]">event_note</span>
Workshifts en cours
</h3>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead class="bg-slate-50/50">
<tr>
<th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Département</th>
<th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Date début</th>
<th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Date fin</th>
<th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Check-in</th>
<th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Check-out</th>
<th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100">
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[#6b38d4] text-lg">restaurant</span>
<span class="font-medium">Kitchen</span>
</div>
</td>
<td class="px-6 py-4 text-sm">2024-12-10 08:00</td>
<td class="px-6 py-4 text-sm">2024-12-10 16:00</td>
<td class="px-6 py-4 text-sm">08:00</td>
<td class="px-6 py-4 text-sm">16:00</td>
<td class="px-6 py-4 text-right">
<button class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
<span class="material-symbols-outlined text-xl">edit</span>
</button>
</td>
</tr>
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[#6b38d4] text-lg">hotel</span>
<span class="font-medium">Hospitality</span>
</div>
</td>
<td class="px-6 py-4 text-sm">2024-12-10 06:00</td>
<td class="px-6 py-4 text-sm">2024-12-10 14:00</td>
<td class="px-6 py-4 text-sm">06:00</td>
<td class="px-6 py-4 text-sm">14:00</td>
<td class="px-6 py-4 text-right">
<button class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
<span class="material-symbols-outlined text-xl">edit</span>
</button>
</td>
</tr>
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[#6b38d4] text-lg">spa</span>
<span class="font-medium">Spa & Wellness</span>
</div>
</td>
<td class="px-6 py-4 text-sm">2024-12-10 09:00</td>
<td class="px-6 py-4 text-sm">2024-12-10 19:00</td>
<td class="px-6 py-4 text-sm">09:00</td>
<td class="px-6 py-4 text-sm">19:00</td>
<td class="px-6 py-4 text-right">
<button class="p-2 text-slate-400 hover:text-[#6b38d4] hover:bg-violet-50 rounded-lg transition-all">
<span class="material-symbols-outlined text-xl">edit</span>
</button>
</td>
</tr>
</tbody>
</table>
</div>
</div>

<!-- Section 3: Gestion des Absences -->
<div class="bg-white rounded-xl shadow-[0_15px_30px_-15px_rgba(109,59,215,0.08)] overflow-hidden mt-6">
<div class="p-6 border-b border-slate-100 flex justify-between items-center flex-wrap gap-4">
<div>
<h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
<span class="material-symbols-outlined text-[#6b38d4]">event_busy</span>
Gestion des Absences
</h3>
<p class="text-[#494454] text-sm mt-1">Suivi, modification du statut et justification</p>
</div>
<div class="bg-[#e9ddff] px-4 py-2 rounded-lg">
<span class="text-sm font-bold text-[#5516be]">Total Absences: 5</span>
</div>
</div>

<div class="overflow-x-auto p-6">
<table class="w-full text-left">
<thead class="bg-slate-50/50">
<tr>
<th class="px-4 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Personnel</th>
<th class="px-4 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Département</th>
<th class="px-4 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Date absence</th>
<th class="px-4 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Statut</th>
<th class="px-4 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Justification</th>
<th class="px-4 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100">
<!-- Absence 1 - Sophie Martin -->
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-4 py-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-[#e9ddff] flex items-center justify-center">
<span class="text-xs font-bold text-[#6b38d4]">SM</span>
</div>
<span class="font-medium text-sm">Sophie Martin</span>
</div>
</td>
<td class="px-4 py-4 text-sm">Hospitality</td>
<td class="px-4 py-4 text-sm">2024-12-05</td>
<td class="px-4 py-4">
<select name="absence_status" class="text-sm border-slate-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-[#6b38d4]/20">
<option value="en_attente" selected>En attente</option>
<option value="justifie">Justifié</option>
<option value="non_justifie">Non justifié</option>
<option value="refuse">Refusé</option>
</select>
</td>
<td class="px-4 py-4">
<input type="text" name="justification" placeholder="Certificat médical, motif familial..." class="w-full text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-[#6b38d4]/20" value="Rendez-vous médical"/>
</td>
<td class="px-4 py-4 text-right">
<div class="flex items-center justify-end gap-2">
<button class="px-3 py-1.5 bg-[#6b38d4] text-white text-xs font-semibold rounded-lg hover:bg-[#8455ef] transition-all">
Enregistrer
</button>
</div>
</td>
</tr>

<!-- Absence 2 - Thomas Dubois -->
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-4 py-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-[#6ffbbe]/30 flex items-center justify-center">
<span class="text-xs font-bold text-[#006947]">TD</span>
</div>
<span class="font-medium text-sm">Thomas Dubois</span>
</div>
</td>
<td class="px-4 py-4 text-sm">Kitchen</td>
<td class="px-4 py-4 text-sm">2024-12-03</td>
<td class="px-4 py-4">
<select name="absence_status" class="text-sm border-slate-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-[#6b38d4]/20">
<option value="en_attente">En attente</option>
<option value="justifie" selected>Justifié</option>
<option value="non_justifie">Non justifié</option>
<option value="refuse">Refusé</option>
</select>
</td>
<td class="px-4 py-4">
<input type="text" name="justification" placeholder="Certificat médical, motif familial..." class="w-full text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-[#6b38d4]/20" value="Arrêt maladie - 3 jours"/>
</td>
<td class="px-4 py-4 text-right">
<button class="px-3 py-1.5 bg-[#6b38d4] text-white text-xs font-semibold rounded-lg hover:bg-[#8455ef] transition-all">
Enregistrer
</button>
</td>
</tr>

<!-- Absence 3 - Laura Bernard -->
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-4 py-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-[#d8e2ff] flex items-center justify-center">
<span class="text-xs font-bold text-[#0058be]">LB</span>
</div>
<span class="font-medium text-sm">Laura Bernard</span>
</div>
</td>
<td class="px-4 py-4 text-sm">Spa & Wellness</td>
<td class="px-4 py-4 text-sm">2024-12-08</td>
<td class="px-4 py-4">
<select name="absence_status" class="text-sm border-slate-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-[#6b38d4]/20">
<option value="en_attente">En attente</option>
<option value="justifie">Justifié</option>
<option value="non_justifie" selected>Non justifié</option>
<option value="refuse">Refusé</option>
</select>
</td>
<td class="px-4 py-4">
<input type="text" name="justification" placeholder="Certificat médical, motif familial..." class="w-full text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-[#6b38d4]/20" value=""/>
</td>
<td class="px-4 py-4 text-right">
<button class="px-3 py-1.5 bg-[#6b38d4] text-white text-xs font-semibold rounded-lg hover:bg-[#8455ef] transition-all">
Enregistrer
</button>
</td>
</tr>

<!-- Absence 4 - Julien Moreau -->
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-4 py-4">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-[#e0e3e5] flex items-center justify-center">
<span class="text-xs font-bold text-[#494454]">JM</span>
</div>
<span class="font-medium text-sm">Julien Moreau</span>
</div>
</td>
<td class="px-4 py-4 text-sm">Maintenance</td>
<td class="px-4 py-4 text-sm">2024-12-04</td>
<td class="px-4 py-4">
<select name="absence_status" class="text-sm border-slate-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-[#6b38d4]/20">
<option value="en_attente">En attente</option>
<option value="justifie" selected>Justifié</option>
<option value="non_justifie">Non justifié</option>
<option value="refuse">Refusé</option>
</select>
</td>
<td class="px-4 py-4">
<input type="text" name="justification" placeholder="Certificat médical, motif familial..." class="w-full text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-[#6b38d4]/20" value="Formation externe - convention"/>
</td>
<td class="px-4 py-4 text-right">
<button class="px-3 py-1.5 bg-[#6b38d4] text-white text-xs font-semibold rounded-lg hover:bg-[#8455ef] transition-all">
Enregistrer
</button>
</td>
</tr>

<!-- Absence 5 - Claire Rousseau -->
<tr class="hover:bg-slate-50/80 transition-colors">
<td class="px-4 py-4 border-b-0">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-[#e9ddff] flex items-center justify-center">
<span class="text-xs font-bold text-[#6b38d4]">CR</span>
</div>
<span class="font-medium text-sm">Claire Rousseau</span>
</div>
</td>
<td class="px-4 py-4 border-b-0 text-sm">Marketing</td>
<td class="px-4 py-4 border-b-0 text-sm">2024-12-09</td>
<td class="px-4 py-4 border-b-0">
<select name="absence_status" class="text-sm border-slate-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-[#6b38d4]/20">
<option value="en_attente" selected>En attente</option>
<option value="justifie">Justifié</option>
<option value="non_justifie">Non justifié</option>
<option value="refuse">Refusé</option>
</select>
</td>
<td class="px-4 py-4 border-b-0">
<input type="text" name="justification" placeholder="Certificat médical, motif familial..." class="w-full text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-[#6b38d4]/20" value="Congés personnels"/>
</td>
<td class="px-4 py-4 text-right border-b-0">
<button class="px-3 py-1.5 bg-[#6b38d4] text-white text-xs font-semibold rounded-lg hover:bg-[#8455ef] transition-all">
Enregistrer
</button>
</td>
</tr>
</tbody>
</table>
</div>

<!-- Résumé des absences par statut -->
<div class="p-6 border-t border-slate-100 bg-slate-50/30">
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
<div class="bg-white rounded-lg p-3 text-center border border-slate-100">
<p class="text-xs text-slate-500">En attente</p>
<p class="text-2xl font-bold text-amber-600">2</p>
</div>
<div class="bg-white rounded-lg p-3 text-center border border-slate-100">
<p class="text-xs text-slate-500">Justifiées</p>
<p class="text-2xl font-bold text-green-600">2</p>
</div>
<div class="bg-white rounded-lg p-3 text-center border border-slate-100">
<p class="text-xs text-slate-500">Non justifiées</p>
<p class="text-2xl font-bold text-red-600">1</p>
</div>
<div class="bg-white rounded-lg p-3 text-center border border-slate-100">
<p class="text-xs text-slate-500">Refusées</p>
<p class="text-2xl font-bold text-slate-600">0</p>
</div>
</div>
</div>
</div>

<!-- Note informative -->
<div class="mt-6 p-4 bg-[#d8e2ff] rounded-xl flex items-start space-x-3">
<span class="material-symbols-outlined text-[#004395]">info</span>
<p class="text-xs leading-tight text-[#004395] font-medium">
<strong>Note:</strong> Les modifications de statut et justifications sont enregistrables via formulaire avec méthode POST vers votre backend Laravel. Ce template intègre tous les champs nécessaires pour la gestion des workshifts (departement_id, date_debut, date_fin, check_in, check_out) et des absences (statut + justification).
</p>
</div>
</div>
</main>
</div>

</template>