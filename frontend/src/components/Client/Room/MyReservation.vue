<template>
<div class="bg-surface font-body text-on-surface antialiased pb-24">
<!-- Top App Bar -->
<header class="fixed top-0 w-full z-50 bg-[#fcf9ef]/80 backdrop-blur-md shadow-[0_20px_40px_rgba(28,28,22,0.06)] flex justify-between items-center px-6 py-4">
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-[#9a401f] cursor-pointer hover:opacity-80 transition-opacity duration-300">menu</span>
</div>
<h1 class="font-['Noto_Serif'] text-xl tracking-widest text-[#9a401f] uppercase font-medium">THE SENSORY RIAD</h1>
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center overflow-hidden border border-outline-variant/15">
<img class="w-full h-full object-cover" data-alt="close-up portrait of a refined middle-aged man with a neat beard, soft natural lighting in a luxury setting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDY0uYXYvFQewz4w1ZR_GUP0VpCQGuOMoOqG0i8vJQZ7SLHb_t-oaSlFXgRpAMvqFQCoLq_K4bmDYTDfPVXbwF_X_QBXb_DobKXF_7pm7RL42pOFYMKC52pCWuIu0TKHY2RVy4hakeXsucYPOSZlnpWpv8px4SsB-jhwJrgwgSc2d0AnHfOabciFt7yy9yQcaoo61nH6WPbwzGi59868DhKy_-EC0Aib6_02KzEz1gkhjYswk9cPwLqbHtuYNjrb21t3JKLLq52Zlxm"/>
</div>
</header>
<main class="pt-24 px-6 max-w-4xl mx-auto zellige-pattern min-h-screen">
<!-- Header Section -->
<section class="mb-12">
<p class="font-label text-xs tracking-[0.2em] uppercase text-tertiary mb-2 font-bold">Your Journeys</p>
<h2 class="font-headline text-4xl font-bold tracking-tight text-on-surface">My Reservations</h2>
<div class="h-px w-24 bg-primary mt-6"></div>
</section>
<!-- Upcoming Stays -->
<section class="mb-16">
<h3 class="font-label text-sm font-bold uppercase tracking-widest text-secondary mb-8">Upcoming Sanctuary</h3>
<div class="grid gap-12">
<!-- Reservation Card 1 -->
<div class="relative group">
<div class="flex flex-col md:flex-row gap-8 items-start">
<div class="w-full md:w-1/2 aspect-[4/5] arch-mask overflow-hidden shadow-2xl">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out" data-alt="interior of a luxury moroccan suite with intricate plasterwork, warm terracotta tones, and soft sunlight streaming through arched windows" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA4hESirrbW9QuiID4X-yJIkX8yOQcHefQWwyHSDQw7K0owyF-FBdrmbWq-BA-lJ8GA582wRmoGruKPy2uxIx5gb2N1o9B87JqmLRBskjjEAuotgcI-7ig70E6xodJFGQtO5AenntlTVKHUMp300aK_1kFFew4TnEch5fq_aqBBafMwnpPbxL9L488P_f1hmGSkyPKammgi5D1Ejy56ki7jdiKfeDrel2H9HD4boQw8HBg5mbNvrsv3GUI_Z-05HyksUFNsAMgFkdb6"/>
</div>
<div class="w-full md:w-1/2 pt-4 flex flex-col h-full justify-between">
<div>
<div class="flex justify-between items-start mb-4">
<span class="px-4 py-1 rounded-full bg-primary/10 text-primary font-label text-[10px] font-bold uppercase tracking-widest">Confirmed</span>
<span class="text-tertiary font-label text-xs font-bold uppercase tracking-widest">Res #SR-8821</span>
</div>
<h4 class="font-headline text-3xl mb-4 text-on-surface">The Sultan's Alcove</h4>
<div class="space-y-3 mb-8">
<div class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-xl">calendar_today</span>
<p class="font-body text-sm font-medium">Oct 14 — Oct 21, 2024</p>
</div>
<div class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-primary text-xl">group</span>
<p class="font-body text-sm font-medium">2 Guests · Master Suite</p>
</div>
</div>
</div>
<div class="flex flex-col gap-4">
<button class="w-full py-4 bg-primary text-on-primary rounded-full font-label text-xs font-bold uppercase tracking-[0.1em] shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-[0.98]">
                                    View Details
                                </button>
<button class="w-full py-4 text-secondary font-label text-xs font-bold uppercase tracking-[0.1em] hover:underline underline-offset-8 transition-all">
                                    Modify Booking
                                </button>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Past & Cancelled Stays -->
<section class="mb-24">
<h3 class="font-label text-sm font-bold uppercase tracking-widest text-secondary mb-8">Past Stays</h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<!-- Past Stay 1 -->
<div class="bg-surface-container-low p-6 rounded-t-[3rem] rounded-b-xl border-b-4 border-surface-container-highest">
<div class="w-full aspect-video rounded-t-[2.5rem] overflow-hidden mb-6">
<img class="w-full h-full object-cover grayscale-[30%] opacity-80" data-alt="deep blue tadelakt walls of a luxury bathroom with golden brass fixtures and soft candle lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPjewR2j0mtryKxEtFtobiQ4JxeNbwgYT-B2tNcZD6o7qipa1jmsLrf2A9v0G0r0VS1vW_oXKo7nqiYOLUkR2JU4FWFMsVc8BuwKfQt_vekHnTBmUuue1aM5IPakoImCfQZ8-0dDhmgenXgHhxgjuleIbr7j36fjaRLSU0w98ALnvZpnxgZCDiOcgP9LuWsTsg3RT0-rxRpWEYQRO0P33ak-xCNsv1T9vIDdJmm3JWG8tOQf2uoWnWSPFCRetOQwpd7byvD0u6fSMq"/>
</div>
<div class="flex justify-between items-center mb-4">
<span class="px-3 py-1 rounded-full bg-secondary/10 text-secondary font-label text-[10px] font-bold uppercase tracking-widest">Completed</span>
<span class="text-on-surface-variant/60 font-label text-[10px] font-bold">June 2024</span>
</div>
<h5 class="font-headline text-xl mb-4 text-on-surface">Indigo Courtyard Suite</h5>
<button class="text-primary font-label text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 hover:translate-x-1 transition-transform">
                        View Receipt <span class="material-symbols-outlined text-xs">arrow_forward</span>
</button>
</div>
<!-- Past Stay 2 (Cancelled) -->
<div class="bg-surface-container-low/50 p-6 rounded-t-[3rem] rounded-b-xl border-b-4 border-surface-container-highest opacity-70">
<div class="w-full aspect-video rounded-t-[2.5rem] overflow-hidden mb-6 filter sepia-[0.3]">
<img class="w-full h-full object-cover grayscale" data-alt="warm sunlit terrace overlooking the Atlas mountains with traditional moroccan rugs and seating" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5Yz-B-vgy3TYOOv6Tzs8rKkFzJQqosIn2fgCuHQVkAVTUx02bBd-zbdRNlkvpypez9jDue6432ojox5xhrBLYAN5JUZ7HeHrqhEfcQXMWDV9VuIsVo4RO9HAjxJyR7F05jzD96L7VSpi93PW4r4Xp5A32yZcLzZE461tvQ4SCl0IktibwS2Wdb6SvYCJSptYc44n9t91eeJfYuBDnlq9WaT9Xm0jFkTjHpx-YTxu5ad-X5Wu9iLh7xWYzJnFzTkgsdQd-BJsLAuoQ"/>
</div>
<div class="flex justify-between items-center mb-4">
<span class="px-3 py-1 rounded-full bg-error/10 text-error font-label text-[10px] font-bold uppercase tracking-widest">Cancelled</span>
<span class="text-on-surface-variant/60 font-label text-[10px] font-bold">April 2024</span>
</div>
<h5 class="font-headline text-xl mb-4 text-on-surface">Atlas View Loft</h5>
<button class="text-secondary font-label text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 hover:translate-x-1 transition-transform">
                        Rebook Now <span class="material-symbols-outlined text-xs">refresh</span>
</button>
</div>
</div>
</section>
</main>
<!-- Bottom Navigation Bar -->
<nav class="fixed bottom-0 left-0 w-full flex justify-around items-center px-4 pb-6 pt-3 bg-[#fcf9ef]/90 backdrop-blur-xl rounded-t-[2rem] z-50 shadow-[0_-10px_30px_rgba(28,28,22,0.04)]">
<a class="flex flex-col items-center justify-center text-[#436182] opacity-60 hover:scale-105 transition-transform duration-300" href="#">
<span class="material-symbols-outlined" data-icon="home">home</span>
<span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Sanctuary</span>
</a>
<a class="flex flex-col items-center justify-center text-[#436182] opacity-60 hover:scale-105 transition-transform duration-300" href="#">
<span class="material-symbols-outlined" data-icon="bed">bed</span>
<span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Stays</span>
</a>
<a class="flex flex-col items-center justify-center text-[#436182] opacity-60 hover:scale-105 transition-transform duration-300" href="#">
<span class="material-symbols-outlined" data-icon="restaurant">restaurant</span>
<span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Dining</span>
</a>
<a class="flex flex-col items-center justify-center text-[#9a401f] bg-[#9a401f]/10 rounded-full px-4 py-1 hover:scale-105 transition-transform duration-300" href="#">
<span class="material-symbols-outlined" data-icon="person" style="font-variation-settings: 'FILL' 1;">person</span>
<span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Profile</span>
</a>
</nav>
</div>
</template>