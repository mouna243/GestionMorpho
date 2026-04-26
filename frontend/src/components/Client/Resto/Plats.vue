<template>
    <div class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
        <header
            class="bg-[#fcf9ef]/80 dark:bg-stone-900/80 backdrop-blur-md shadow-[0_20px_40px_rgba(28,28,22,0.06)] sticky top-0 z-50">
            <div class="flex justify-between items-center w-full px-12 py-6 max-w-screen-2xl mx-auto">
                <div class="text-2xl font-['Noto_Serif'] italic text-[#9a401f] dark:text-[#c05c39]">The Sensory Riad
                </div>
                <nav class="hidden md:flex items-center gap-10">
                    <a class="text-[#436182] dark:text-stone-400 font-['Manrope'] uppercase tracking-widest text-[10px] hover:text-[#755717] transition-all duration-300 ease-in-out"
                        href="#">Suites</a>
                    <a class="text-[#9a401f] dark:text-[#c05c39] border-b-2 border-[#755717] pb-1 font-['Manrope'] uppercase tracking-widest text-[10px] hover:text-[#755717] transition-all duration-300 ease-in-out"
                        href="#">Dining</a>
                    <a class="text-[#436182] dark:text-stone-400 font-['Manrope'] uppercase tracking-widest text-[10px] hover:text-[#755717] transition-all duration-300 ease-in-out"
                        href="#">Wellness</a>
                    <a class="text-[#436182] dark:text-stone-400 font-['Manrope'] uppercase tracking-widest text-[10px] hover:text-[#755717] transition-all duration-300 ease-in-out"
                        href="#">Reservations</a>
                </nav>
                <div class="flex items-center gap-6">
                    <span class="material-symbols-outlined text-[#9a401f]"
                        data-icon="account_circle">account_circle</span>
                    <button
                        class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-2.5 rounded-full font-label text-xs uppercase tracking-widest hover:scale-105 transition-all duration-300 shadow-lg">Book
                        Now</button>
                </div>
            </div>
        </header>
        <main class="max-w-screen-2xl mx-auto px-12 pt-16 pb-24 zellige-pattern">
            <div class="flex flex-col md:flex-row gap-16">
                <section class="flex-1">
                    <div class="mb-12">
                        <span class="font-label text-xs uppercase tracking-[0.3em] text-tertiary mb-2 block">In-Room
                            Culinary Service</span>
                        <h1 class="font-headline text-5xl font-light text-on-background tracking-tight mb-4">Kasbah
                            Royale Selection</h1>
                        <p class="text-on-surface-variant max-w-xl font-light leading-relaxed">Savor the essence of the
                            Atlas Mountains from the privacy of your sanctuary. Each dish is a symphony of local harvest
                            and ancient spice.</p>
                    </div>
                    <div class="space-y-12">
                        <div>
                            <h2 class="font-headline text-2xl mb-8 border-b border-outline-variant/20 pb-4">Selected
                                Delicacies</h2>
                            <div class="space-y-6">
                                <div
                                    class="flex items-center gap-6 p-6 bg-surface-container-low rounded-xl group transition-all duration-300 hover:bg-surface-container-high">
                                    <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            data-alt="Close-up of a traditional Moroccan lamb tagine with prunes and almonds in a clay pot"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuANwTARO0NyCiuEx76sNDTKOvrHBy9Twyxfou4On-sN4ZO5Zpk5njnBVOKt0IEZLYLq6qlJn3S-i6vJWchtNOs3t2ZBnya0bx7uF2vRvYKPpc6AKCR34r-pzLU-ybOSG2eO1oEFwYUOhDbYnMMq5dJh94cAqVOcYE5rBb_cGQJ5Ui3j0JBfakzUhd2LR28iodqKF7PAa4RF4R0qsaX44czjvjbdNxM4W0bdoE7tmpIPPAb3t69lzokALmN0YGBIOwE2NsuCHHFO_ANZ" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <h3 class="font-headline text-lg text-on-surface">Royal Lamb Tagine</h3>
                                            <span class="font-label text-sm text-tertiary font-bold">$42.00</span>
                                        </div>
                                        <p class="text-sm text-on-surface-variant font-light mb-4">Slow-braised with
                                            saffron, ginger, and caramelized apricots.</p>
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="flex items-center border border-outline-variant/30 rounded-full px-3 py-1 bg-surface">
                                                <button
                                                    class="material-symbols-outlined text-xs hover:text-primary transition-colors"
                                                    data-icon="remove">remove</button>
                                                <span class="px-4 font-label text-sm">1</span>
                                                <button
                                                    class="material-symbols-outlined text-xs hover:text-primary transition-colors"
                                                    data-icon="add">add</button>
                                            </div>
                                            <button
                                                class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-error transition-colors flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs"
                                                    data-icon="delete">delete</span> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-6 p-6 bg-surface-container-low rounded-xl group transition-all duration-300 hover:bg-surface-container-high">
                                    <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0">
                                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            data-alt="Platter of vibrant Mediterranean couscous with roasted vegetables and fresh herbs"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-0w_ti2IAwO71EHML4q_JtMU9Ib5JcrebEKQFPhsCiSr7s2J2uLXuo1v8tMK35d51SwBr19VONvQ1Quq1meTYnbGfNxPq_dv7QE6mHl0l3U9LZK6rm2T_mCj7LzJjEPVxTx-Z5XdiZmcCs1zORXInWM3ZbJ7BFJ7wc1B5QruWRat1n9CtBDmDagJ2BCOH2Ovy4ZGU3m8o1ieChDz_Ir-rS2f_EJM7Xm-FYQ9eh-8Yezq9hl5rLkBS6AxQbGyHEauu3T28uqpQXgFV" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <h3 class="font-headline text-lg text-on-surface">Garden Couscous</h3>
                                            <span class="font-label text-sm text-tertiary font-bold">$28.00</span>
                                        </div>
                                        <p class="text-sm text-on-surface-variant font-light mb-4">Hand-rolled semolina
                                            with seven seasonal vegetables and herb-infused broth.</p>
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="flex items-center border border-outline-variant/30 rounded-full px-3 py-1 bg-surface">
                                                <button
                                                    class="material-symbols-outlined text-xs hover:text-primary transition-colors"
                                                    data-icon="remove">remove</button>
                                                <span class="px-4 font-label text-sm">2</span>
                                                <button
                                                    class="material-symbols-outlined text-xs hover:text-primary transition-colors"
                                                    data-icon="add">add</button>
                                            </div>
                                            <button
                                                class="text-[10px] uppercase tracking-widest text-on-surface-variant hover:text-error transition-colors flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs"
                                                    data-icon="delete">delete</span> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2 class="font-headline text-2xl mb-8 border-b border-outline-variant/20 pb-4">The Chef's
                                Atélier</h2>
                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant mb-3 block">Dietary
                                        Preferences or Requests</label>
                                    <textarea
                                        class="w-full bg-surface-container-low border-b border-outline-variant/30 focus:border-primary focus:ring-0 rounded-t-xl transition-all p-6 font-light text-sm italic outline-none resize-none"
                                        placeholder="Share your notes for our culinary team..." rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <aside class="w-full md:w-[400px]">
                    <div
                        class="bg-surface-container shadow-[0_20px_40px_rgba(28,28,22,0.06)] rounded-3xl p-8 sticky top-32 overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="material-symbols-outlined text-8xl" data-icon="restaurant">restaurant</span>
                        </div>
                        <h2 class="font-headline text-xl mb-8 relative z-10">Order Summary</h2>
                        <div class="space-y-6 relative z-10 mb-8">
                            <div>
                                <label
                                    class="font-label text-[10px] uppercase tracking-widest text-on-surface-variant mb-4 block">Delivery
                                    Timing</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <button
                                        class="flex flex-col items-center justify-center p-4 rounded-xl border border-primary bg-primary/5 text-primary transition-all">
                                        <span class="material-symbols-outlined mb-1" data-icon="bolt">bolt</span>
                                        <span class="font-label text-[10px] uppercase tracking-widest">ASAP</span>
                                        <span class="text-[9px] font-light">~ 35 mins</span>
                                    </button>
                                    <button
                                        class="flex flex-col items-center justify-center p-4 rounded-xl border border-outline-variant/20 bg-surface hover:border-tertiary transition-all">
                                        <span class="material-symbols-outlined mb-1"
                                            data-icon="schedule">schedule</span>
                                        <span class="font-label text-[10px] uppercase tracking-widest">Schedule</span>
                                        <span class="text-[9px] font-light">Choose time</span>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-4 pt-6 border-t border-outline-variant/10">
                                <div class="flex justify-between text-sm">
                                    <span class="font-light text-on-surface-variant">Subtotal</span>
                                    <span class="font-medium">$98.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="font-light text-on-surface-variant">Service Gratuity (15%)</span>
                                    <span class="font-medium">$14.70</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="font-light text-on-surface-variant">Environmental Contribution</span>
                                    <span class="font-medium">$2.00</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-end pt-6 border-t border-outline-variant/20">
                                <span class="font-label text-xs uppercase tracking-widest">Total Honorarium</span>
                                <span class="font-headline text-3xl text-primary">$114.70</span>
                            </div>
                        </div>
                        <div class="space-y-4 relative z-10">
                            <button
                                class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary py-5 rounded-full font-label text-xs uppercase tracking-[0.2em] shadow-lg hover:scale-[1.02] active:scale-95 transition-all duration-300">
                                Finalize Order
                            </button>
                            <p class="text-center text-[9px] font-light text-on-surface-variant leading-relaxed px-4">
                                All charges will be discreetly applied to your suite account. Prices include luxury VAT.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
            <section class="mt-24">
                <h2 class="font-headline text-2xl mb-12 text-center">To Complement Your Meal</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-surface group">
                        <div class="aspect-[4/5] rounded-t-[100px] overflow-hidden mb-6 relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                data-alt="Traditional Moroccan tea service with silver pot and glasses on an ornate tray"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAIFXJsQ51JNVu7mMOdpOIJ6fp_kFZuyGYIV9i6yNZ9PtCSSQptDHsJ08Bvi7Vw6tSIKGqWnwoV1CRO9dgdCUH7jIynuGo1oIl2veZhsPKMpOMFLsz-nJD9PbYR7dxQEalWxoveJwhs2Fe5a2JUL6Y57Oq_8QzDve3_4ElNUveRwpScIYEmW7hpwgbFixLFgncs8smiY_JKIFZolwX09JhamCaiEVm8Sm2nVesceNjQ8dez435SO3OSbyxB0mVRB04ixAwE8D8e92_" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent flex items-end p-8">
                                <button
                                    class="bg-white/90 backdrop-blur-md text-primary w-12 h-12 rounded-full flex items-center justify-center shadow-xl hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined" data-icon="add">add</span>
                                </button>
                            </div>
                        </div>
                        <div class="px-2">
                            <h4 class="font-headline text-lg mb-1">Mint Tea Ritual</h4>
                            <p class="text-xs text-on-surface-variant font-light tracking-wide uppercase">Silver Service
                                • Fresh Nana Mint</p>
                            <span class="text-tertiary font-bold text-sm block mt-2">$12.00</span>
                        </div>
                    </div>
                    <div class="bg-surface group">
                        <div class="aspect-[4/5] rounded-t-[100px] overflow-hidden mb-6 relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                data-alt="Glass of deep red wine next to a dark wine bottle in a moody, upscale setting"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAj_ItbRXV4EgCoNQpqoO_74JCdfZQEASpciSMwO1E78KV9lAM4fsfIKbV81I8r45n2g282WiozHa6gAUFaqTYPPzyd_yYF3a_stA0YUHxHlizTnHp8Qy7Vduhg21jrBgUDE4qOPFQe-pjJLQs47Q9hS2WEFO5xuY5J9-CUk5joFs0qoN3czWuwGSMTswQEbcwSTob3w36n4rSjcJbc6RYh3W2zEciw7i3f1HSyBkD_OCuRaTyV8Bowp1lmrFLw1pBYNs0bjkdNzUEm" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent flex items-end p-8">
                                <button
                                    class="bg-white/90 backdrop-blur-md text-primary w-12 h-12 rounded-full flex items-center justify-center shadow-xl hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined" data-icon="add">add</span>
                                </button>
                            </div>
                        </div>
                        <div class="px-2">
                            <h4 class="font-headline text-lg mb-1">Syrah des Atlas 2019</h4>
                            <p class="text-xs text-on-surface-variant font-light tracking-wide uppercase">Deep Plum •
                                Desert Spices</p>
                            <span class="text-tertiary font-bold text-sm block mt-2">$85.00</span>
                        </div>
                    </div>
                    <div class="bg-surface group">
                        <div class="aspect-[4/5] rounded-t-[100px] overflow-hidden mb-6 relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                data-alt="Sophisticated arrangement of Moroccan almond pastries on a dark ceramic plate"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuANMkbWMiwRc76Tkx4LO-45JCAGpNS28Au-Q2x38g7pIsSCPeJWXbYQGV-_Qzez_JVmbJtPi7wYm6eK1XifVC9f8cyJYPC8dLKBgd4h8d015ZkuNQ7nQmt1v1xEvXmo3a5vkfhgu2-sGWnnLrMhHQq57Uys0qpnnrAmYFK1nm9QYFnImoUF_uVbbKWW0YEsZkankWRs01Vyg6Bd-23qtab5Y1fCDFYrCin02tTBM7L1hOmusxFGbQyky4QrYoW_K2AEAw0EVrhjWK5a" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent flex items-end p-8">
                                <button
                                    class="bg-white/90 backdrop-blur-md text-primary w-12 h-12 rounded-full flex items-center justify-center shadow-xl hover:bg-primary hover:text-white transition-all">
                                    <span class="material-symbols-outlined" data-icon="add">add</span>
                                </button>
                            </div>
                        </div>
                        <div class="px-2">
                            <h4 class="font-headline text-lg mb-1">Pâtisserie Signature</h4>
                            <p class="text-xs text-on-surface-variant font-light tracking-wide uppercase">Orange Blossom
                                • Atlas Honey</p>
                            <span class="text-tertiary font-bold text-sm block mt-2">$18.00</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="bg-[#fcf9ef] dark:bg-stone-950 w-full border-t border-[#9a401f]/10 mt-20">
            <div class="flex flex-col items-center justify-center py-16 gap-8 w-full">
                <div class="font-['Noto_Serif'] text-lg text-[#755717]">The Sensory Riad</div>
                <div class="flex flex-wrap justify-center gap-10">
                    <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
                        href="#">The Estate</a>
                    <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
                        href="#">Curated Experiences</a>
                    <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
                        href="#">Private Events</a>
                    <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
                        href="#">Contact</a>
                    <a class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-sm uppercase tracking-[0.2em] hover:text-[#755717] underline underline-offset-4 transition-opacity duration-300 ease-in-out"
                        href="#">Privacy</a>
                </div>
                <p class="text-[#436182] dark:text-stone-500 font-['Manrope'] text-xs tracking-widest opacity-60">© 2024
                    The Sensory Riad. A sanctuary of the soul.</p>
            </div>
        </footer>
    </div>
</template>