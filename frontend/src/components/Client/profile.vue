<template>
  <div class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
    <header class="bg-[#fcf9ef]/80 dark:bg-stone-950/80 backdrop-blur-xl full-width top-0 sticky z-50 shadow-[0_20px_40px_rgba(28,28,22,0.04)]">
      <div class="flex justify-between items-center px-8 py-6 w-full max-w-screen-2xl mx-auto">
        <div class="text-2xl font-serif text-orange-900 dark:text-orange-200 tracking-tighter italic">
          Kasbah Royale
        </div>
        <nav class="hidden md:flex items-center space-x-12">
          <a class="text-stone-500 dark:text-stone-400 font-sans uppercase tracking-widest text-[10px] hover:text-orange-700 transition-colors duration-300" href="#">Sanctuary</a>
          <a class="text-stone-500 dark:text-stone-400 font-sans uppercase tracking-widest text-[10px] hover:text-orange-700 transition-colors duration-300" href="#">Rituals</a>
          <a class="text-stone-500 dark:text-stone-400 font-sans uppercase tracking-widest text-[10px] hover:text-orange-700 transition-colors duration-300" href="#">Journeys</a>
        </nav>
        <div class="flex items-center space-x-6 text-orange-900 dark:text-orange-200">
          <button class="material-symbols-outlined hover:text-orange-700 transition-colors duration-300">notifications</button>
          <button class="material-symbols-outlined hover:text-orange-700 transition-colors duration-300">shopping_bag</button>
          <div class="w-10 h-10 rounded-full overflow-hidden border border-outline-variant/20">
            <img alt="User profile avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDL5qWosoeebzRqtqV9syIxjcq0zyMEToL29E4G87Pit3FjoVovVlV-OkerFP-Y1JmGtXI7xcEkg58qxpKMf1l9pAETh_NBMVhPo_3C8diGWKlKY4ZqmW9dllviLhhAQomXX7AvKlof025khfRhwhwom6srM8eUD1NBObeiCNAfhMWF8edli9OYZ9Nv0IIqU4ugVbR5WiJPNLGL3P3pfI81f8TqQwlX2tHmnhzAiPSGlcwe62ZiDklqXYLy0IBqNJ6de55LJX06KScL"/>
          </div>
        </div>
      </div>
    </header>

    <div class="flex min-h-screen max-w-screen-2xl mx-auto">
      <!-- Side Navigation -->
      <aside class="hidden md:flex flex-col h-[calc(100vh-88px)] w-72 rounded-r-[48px] bg-[#fcf9ef] dark:bg-stone-950 py-12 px-6 sticky top-[88px]">
        <div class="mb-12 px-4">
          <h2 class="font-headline text-xl text-orange-900 dark:text-orange-200 mb-1">Welcome, Traveler</h2>
          <p class="text-stone-500 dark:text-stone-400 text-xs font-sans tracking-tight">Member since 1445 AH</p>
        </div>
        <nav class="flex-1 space-y-2">
          <a class="flex items-center space-x-4 px-6 py-4 bg-stone-100 dark:bg-stone-800 text-orange-800 dark:text-orange-200 font-semibold rounded-l-full hover:translate-x-1 transition-transform duration-300" href="#">
            <span class="material-symbols-outlined">person</span>
            <span class="font-sans tracking-tight">Identity</span>
          </a>
          <a class="flex items-center space-x-4 px-6 py-4 text-stone-500 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900 hover:translate-x-1 transition-transform duration-300" href="#">
            <span class="material-symbols-outlined">bed</span>
            <span class="font-sans tracking-tight">Reservations</span>
          </a>
          <a class="flex items-center space-x-4 px-6 py-4 text-stone-500 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900 hover:translate-x-1 transition-transform duration-300" href="#">
            <span class="material-symbols-outlined">spa</span>
            <span class="font-sans tracking-tight">Wellness</span>
          </a>
          <a class="flex items-center space-x-4 px-6 py-4 text-stone-500 dark:text-stone-400 hover:bg-stone-50 dark:hover:bg-stone-900 hover:translate-x-1 transition-transform duration-300" href="#">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-sans tracking-tight">Settings</span>
          </a>
        </nav>
        <button class="mt-auto bg-gradient-to-r from-primary to-primary-container text-on-primary rounded-full py-4 px-6 font-bold text-sm tracking-wide shadow-lg hover:scale-105 transition-all duration-300">
          Book New Experience
        </button>
      </aside>

      <!-- Main Content Canvas -->
      <main class="flex-1 px-8 py-12 md:px-16 zellige-pattern">
        <!-- Identity Section -->
        <section class="mb-20" id="identity">
          <div class="flex items-baseline justify-between mb-8">
            <h1 class="font-display text-4xl text-on-surface tracking-tight italic">Identity</h1>
            <span class="text-tertiary font-label text-[10px] uppercase tracking-[0.2em]">Mandatory Revelation</span>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10 bg-surface-container-lowest p-10 rounded-[32px] shadow-[0_20px_40px_rgba(28,28,22,0.02)]">
            <div class="group border-b border-outline-variant/20 pb-2 focus-within:border-primary transition-colors duration-300">
              <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Full Name</label>
              <div class="flex justify-between items-center">
                <input class="bg-transparent border-none p-0 font-headline text-lg text-on-surface focus:ring-0 w-full" type="text" value="Amira Al-Fassi"/>
                <span class="material-symbols-outlined text-stone-400 text-sm cursor-pointer hover:text-primary">edit</span>
              </div>
            </div>
            <div class="group border-b border-outline-variant/20 pb-2 focus-within:border-primary transition-colors duration-300">
              <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Email Address</label>
              <div class="flex justify-between items-center">
                <input class="bg-transparent border-none p-0 font-headline text-lg text-on-surface focus:ring-0 w-full" type="email" value="amira.alfassi@heritage.ma"/>
                <span class="material-symbols-outlined text-stone-400 text-sm cursor-pointer hover:text-primary">edit</span>
              </div>
            </div>
            <div class="group border-b border-outline-variant/20 pb-2 focus-within:border-primary transition-colors duration-300">
              <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">Phone Number</label>
              <div class="flex justify-between items-center">
                <input class="bg-transparent border-none p-0 font-headline text-lg text-on-surface focus:ring-0 w-full" type="text" value="+212 661 234 567"/>
                <span class="material-symbols-outlined text-stone-400 text-sm cursor-pointer hover:text-primary">edit</span>
              </div>
            </div>
            <div class="group border-b border-outline-variant/20 pb-2 focus-within:border-primary transition-colors duration-300">
              <label class="block text-[10px] uppercase tracking-widest text-stone-400 mb-1">CIN / Passport</label>
              <div class="flex justify-between items-center">
                <input class="bg-transparent border-none p-0 font-headline text-lg text-on-surface focus:ring-0 w-full" type="text" value="BK 882109"/>
                <span class="material-symbols-outlined text-stone-400 text-sm cursor-pointer hover:text-primary">edit</span>
              </div>
            </div>
          </div>
        </section>

        <!-- My Sanctuary Section -->
        <section class="mb-20" id="sanctuary">
          <div class="flex items-baseline justify-between mb-10">
            <h2 class="font-display text-3xl text-on-surface tracking-tight">My Sanctuary</h2>
            <a class="text-tertiary font-label text-xs hover:underline underline-offset-4 transition-all" href="#">View History</a>
          </div>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Reservation Card 1 -->
            <div class="bg-surface-container-low group overflow-hidden transition-all duration-500 hover:bg-surface-container-high rounded-xl">
              <div class="relative h-64 overflow-hidden arch-container mx-6 mt-6">
                <img alt="The Emerald Suite" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_Ty649celNlfMwIxRrMfgZ9qOSux7HdbF9k85NdmL4d8RkFd7NKMDOKi-LusnzWnJyuLPmVwGSCmrzw1mG6hi3SYbvbDqq0jNLKi9g1oC3tR1WsFPRbQB5wPuUIpslgh_Z458DlpVYXBEOWYA77l7jxwvUPIt7jKm4ZfM6oPX2k-cJO-A5Ui7KNgTl_1eD3h04O5Y9m8tjS4kXkqm2IPOCLkZfscyJIch9HiZ2bg757SZgtB5pkDRER4GCZoY1Sggfc9UG0ABI6Jm"/>
                <div class="absolute inset-0 bg-gradient-to-t from-on-surface/40 to-transparent"></div>
                <div class="absolute bottom-4 left-6">
                  <span class="bg-tertiary-fixed text-on-tertiary-fixed px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">Active Stay</span>
                </div>
              </div>
              <div class="p-8">
                <h3 class="font-headline text-2xl text-on-surface mb-2">The Emerald Suite</h3>
                <div class="flex justify-between items-end">
                  <div class="space-y-1">
                    <p class="text-stone-500 text-sm flex items-center">
                      <span class="material-symbols-outlined text-base mr-2">calendar_today</span>
                      Oct 12 — Oct 18, 2023
                    </p>
                    <p class="text-stone-500 text-sm flex items-center">
                      <span class="material-symbols-outlined text-base mr-2">group</span>
                      2 Guests
                    </p>
                  </div>
                  <div class="text-right">
                    <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Total Price</p>
                    <p class="text-primary font-headline text-xl">12,400 MAD</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Reservation Card 2 -->
            <div class="bg-surface-container-low group overflow-hidden transition-all duration-500 hover:bg-surface-container-high rounded-xl">
              <div class="relative h-64 overflow-hidden arch-container mx-6 mt-6">
                <img alt="Ochre Room" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBwElmv1j2vkDjhjlh0_lnTjV-5tAL0k1Dw36_vxNDaojcXXAeWEimcBw5L8WliqQv7NufYWJA5iDAUXtctMG3RWimhf4e8TCJpazvkes2DTEyaRoYadDVNTcUbWR5SC8jIPlM0wGRsQIRjQ3nMeCI4XwnxGq4ph-bgbDAeGfN399z23_tl3QBgwNKYsEchYD-m-j8uJWasrF68gT3EihFgX-aRADEfYBo0XFk3MX9Zn9_USwvPhgbMNNxvQtpspGIWxoXZuWHbFMOr"/>
              </div>
              <div class="p-8">
                <h3 class="font-headline text-2xl text-on-surface mb-2">Ochre Room</h3>
                <div class="flex justify-between items-end">
                  <div class="space-y-1">
                    <p class="text-stone-500 text-sm flex items-center">
                      <span class="material-symbols-outlined text-base mr-2">calendar_today</span>
                      Dec 04 — Dec 07, 2023
                    </p>
                    <p class="text-stone-500 text-sm flex items-center">
                      <span class="material-symbols-outlined text-base mr-2">group</span>
                      1 Guest
                    </p>
                  </div>
                  <div class="text-right">
                    <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Total Price</p>
                    <p class="text-primary font-headline text-xl">5,200 MAD</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Wellness Rituals Section -->
        <section id="wellness">
          <div class="flex items-baseline justify-between mb-8">
            <h2 class="font-display text-3xl text-on-surface tracking-tight">Wellness Rituals</h2>
          </div>
          <div class="space-y-4">
            <!-- Ritual 1 -->
            <div class="flex items-center justify-between p-6 bg-surface-container-lowest rounded-2xl hover:bg-surface-container transition-colors duration-300">
              <div class="flex items-center space-x-6">
                <div class="w-14 h-14 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">hot_tub</span>
                </div>
                <div>
                  <h4 class="font-headline text-lg text-on-surface">Royal Hammam</h4>
                  <p class="text-stone-400 text-xs font-sans tracking-tight">Full-body exfoliation and herbal steam</p>
                </div>
              </div>
              <div class="flex items-center space-x-12">
                <div class="text-center">
                  <p class="text-[10px] text-stone-400 uppercase tracking-widest">Date</p>
                  <p class="font-body text-sm font-semibold">Oct 14, 15:00</p>
                </div>
                <div class="text-right min-w-[100px]">
                  <p class="text-primary font-headline text-lg">850 MAD</p>
                </div>
                <span class="material-symbols-outlined text-tertiary cursor-pointer">chevron_right</span>
              </div>
            </div>

            <!-- Ritual 2 -->
            <div class="flex items-center justify-between p-6 bg-surface-container-lowest rounded-2xl hover:bg-surface-container transition-colors duration-300">
              <div class="flex items-center space-x-6">
                <div class="w-14 h-14 rounded-full bg-tertiary-container/20 flex items-center justify-center text-tertiary-container">
                  <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">self_care</span>
                </div>
                <div>
                  <h4 class="font-headline text-lg text-on-surface">Argan Oil Massage</h4>
                  <p class="text-stone-400 text-xs font-sans tracking-tight">90-minute therapeutic session</p>
                </div>
              </div>
              <div class="flex items-center space-x-12">
                <div class="text-center">
                  <p class="text-[10px] text-stone-400 uppercase tracking-widest">Date</p>
                  <p class="font-body text-sm font-semibold">Oct 16, 11:30</p>
                </div>
                <div class="text-right min-w-[100px]">
                  <p class="text-primary font-headline text-lg">1,200 MAD</p>
                </div>
                <span class="material-symbols-outlined text-tertiary cursor-pointer">chevron_right</span>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>

    <!-- Mobile Navigation -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 bg-[#fcf9ef]/90 backdrop-blur-2xl flex justify-around items-center px-4 pb-8 pt-4 shadow-[0_-10px_30px_rgba(28,28,22,0.08)] rounded-t-[32px]">
      <a class="flex flex-col items-center justify-center text-stone-400" href="#">
        <span class="material-symbols-outlined">home_app_logo</span>
        <span class="text-[10px] uppercase tracking-widest font-sans font-bold">Home</span>
      </a>
      <a class="flex flex-col items-center justify-center text-stone-400" href="#">
        <span class="material-symbols-outlined">calendar_month</span>
        <span class="text-[10px] uppercase tracking-widest font-sans font-bold">Stays</span>
      </a>
      <a class="flex flex-col items-center justify-center text-stone-400" href="#">
        <span class="material-symbols-outlined">self_care</span>
        <span class="text-[10px] uppercase tracking-widest font-sans font-bold">Spa</span>
      </a>
      <a class="flex flex-col items-center justify-center bg-orange-100/50 text-orange-900 rounded-full px-5 py-2" href="#">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">account_circle</span>
        <span class="text-[10px] uppercase tracking-widest font-sans font-bold">Profile</span>
      </a>
    </nav>
  </div>
</template>