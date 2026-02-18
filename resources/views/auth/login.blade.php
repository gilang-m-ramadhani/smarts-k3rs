<x-layouts.guest title="Login">
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-0 rounded-3xl overflow-hidden shadow-2xl shadow-primary/10">

            {{-- LEFT — Branding Panel --}}
            <div class="hidden lg:flex flex-col justify-between p-10 bg-gradient-to-br from-[#088395] via-[#09637E] to-[#064e66] text-white relative overflow-hidden">
                {{-- Decorative circles --}}
                <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-white/5"></div>
                <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-white/5"></div>
                <div class="absolute top-1/2 right-10 w-24 h-24 rounded-full bg-white/5"></div>

                {{-- Top: Brand --}}
                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-sm mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2">SMART K3</h1>
                    <p class="text-white/60 text-sm leading-relaxed">
                        Sistem Manajemen APAR & Keselamatan Kerja Terintegrasi
                    </p>
                </div>

                {{-- Middle: Features --}}
                <div class="relative z-10 space-y-4 my-8">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Inspeksi Digital</p>
                            <p class="text-white/50 text-xs">Checklist standar 11 parameter pemeriksaan</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">QR Code Tracking</p>
                            <p class="text-white/50 text-xs">Identifikasi APAR cepat via QR Code</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Laporan Otomatis</p>
                            <p class="text-white/50 text-xs">Generate laporan bulanan PDF & Excel</p>
                        </div>
                    </div>
                </div>

                {{-- Bottom: Footer --}}
                <div class="relative z-10">
                    <p class="text-white/30 text-xs">© {{ date('Y') }} SMART K3 — Hospital Fire Safety System</p>
                </div>
            </div>

            {{-- RIGHT — Login Form --}}
            <div class="login-card bg-base-100/90 p-8 sm:p-10 lg:p-12 flex flex-col justify-center">

                {{-- Mobile brand (hidden on desktop) --}}
                <div class="text-center mb-8 lg:hidden fade-up">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#088395] to-[#09637E] shadow-lg shadow-primary/20 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-extrabold bg-gradient-to-r from-[#088395] to-[#09637E] bg-clip-text text-transparent">SMART K3</h1>
                    <p class="text-base-content/40 mt-1 text-xs">Sistem Manajemen APAR Terintegrasi</p>
                </div>

                {{-- Greeting --}}
                <div class="mb-8 fade-up">
                    <h2 class="text-2xl font-bold text-base-content">Selamat Datang 👋</h2>
                    <p class="text-base-content/50 text-sm mt-1">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                {{-- Error alert --}}
                @if($errors->any())
                    <div class="bg-error/10 border border-error/20 text-error rounded-xl px-4 py-3 mb-6 flex items-center gap-3 text-sm fade-up">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div class="fade-up fade-up-delay">
                        <label class="block text-sm font-medium text-base-content/70 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}"
                                   class="input-modern w-full pl-10 pr-4 py-3 bg-base-200/50 border border-base-300/60 rounded-xl text-sm focus:outline-none focus:border-primary/40 focus:bg-base-100 transition-all" required autofocus />
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="fade-up fade-up-delay-2">
                        <label class="block text-sm font-medium text-base-content/70 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" placeholder="••••••••"
                                   class="input-modern w-full pl-10 pr-4 py-3 bg-base-200/50 border border-base-300/60 rounded-xl text-sm focus:outline-none focus:border-primary/40 focus:bg-base-100 transition-all" required />
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between fade-up fade-up-delay-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm rounded-md">
                            <span class="text-sm text-base-content/60">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <div class="fade-up fade-up-delay-3">
                        <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-[#088395] to-[#09637E] text-white rounded-xl font-semibold text-sm shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk
                        </button>
                    </div>
                </form>

                {{-- Demo Account --}}
                <div class="mt-8 fade-up fade-up-delay-3">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-base-300/50"></div></div>
                        <div class="relative flex justify-center"><span class="bg-base-100/90 px-3 text-xs text-base-content/30 uppercase tracking-wider">Demo</span></div>
                    </div>
                    <div class="mt-4 bg-base-200/40 border border-base-300/40 rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-base-content/40">Admin Account</p>
                                <p class="text-sm font-medium text-base-content/70">admin@smartk3.com</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-base-content/40">Password</p>
                            <p class="text-sm font-mono font-medium text-base-content/70">password</p>
                        </div>
                    </div>
                </div>

                {{-- Mobile footer --}}
                <p class="text-center text-xs text-base-content/25 mt-6 lg:hidden">
                    © {{ date('Y') }} SMART K3
                </p>
            </div>

        </div>
    </div>
</x-layouts.guest>
