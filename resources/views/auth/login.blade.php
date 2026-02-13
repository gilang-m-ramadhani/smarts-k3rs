<x-layouts.guest title="Login">
    <div class="w-full max-w-md animate-slide-up">
        <!-- Logo & Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-primary to-secondary shadow-lg mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                </svg>
            </div>
            <h1
                class="text-3xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent
                        [text-shadow:0_0_0.5px_rgba(0,0,0,0.4),0_2px_6px_rgba(0,0,0,0.35)]">
                SMART K3
            </h1>
            <p class="text-base-content/70 mt-2 drop-shadow-sm">
                Sistem Manajemen APAR Terintegrasi
            </p>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <h2 class="text-xl font-semibold text-center mb-6 text-base-content">
                Selamat Datang
            </h2>

            @if($errors->any())
            <div class="alert alert-error mb-6 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm">{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Email</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="input input-modern w-full pl-12 h-12 @error('email') input-error @enderror" required autofocus />
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Password</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" class="input input-modern w-full pl-12 h-12 @error('password') input-error @enderror" required />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="label cursor-pointer gap-3">
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm rounded" />
                        <span class="label-text text-sm">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-primary hover:underline">Lupa password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-full h-12 rounded-xl text-base font-semibold shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Masuk
                </button>
            </form>

            <!-- Demo Accounts -->
            <div class="mt-8 pt-6 border-t border-base-300">
                <p class="text-xs text-center text-base-content/50 mb-4">Demo Account</p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-base-200/50 rounded-xl p-3 text-center">
                        <p class="text-xs text-base-content/60">Admin</p>
                        <p class="text-sm font-medium text-primary">admin@smartk3.com</p>
                    </div>
                    <div class="bg-base-200/50 rounded-xl p-3 text-center">
                        <p class="text-xs text-base-content/60">Password</p>
                        <p class="text-sm font-mono font-medium">password</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-base-content/40 mt-8">
            © {{ date('Y') }} SMART K3. Hospital Fire Safety System.
        </p>
    </div>
</x-layouts.guest>