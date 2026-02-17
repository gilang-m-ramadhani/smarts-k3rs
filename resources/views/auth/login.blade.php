<x-layouts.guest title="Login">
    <div class="w-full max-w-md animate-slide-up">
        {{-- Logo & Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-primary to-secondary shadow-lg shadow-primary/25 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                SMART K3
            </h1>
            <p class="text-base-content/50 mt-1 text-sm">Sistem Manajemen APAR Terintegrasi</p>
        </div>

        {{-- Login Card --}}
        <div class="card bg-white/80 backdrop-blur-xl shadow-2xl border border-white/30">
            <div class="card-body">
                <h2 class="text-xl font-semibold text-center mb-4">Selamat Datang 👋</h2>

                @if($errors->any())
                    <div class="alert alert-error mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Email</span></div>
                        <input type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}"
                               class="input input-bordered w-full" required autofocus />
                    </label>

                    <label class="form-control w-full">
                        <div class="label"><span class="label-text font-medium">Password</span></div>
                        <input type="password" name="password" placeholder="••••••••"
                               class="input input-bordered w-full" required />
                    </label>

                    <div class="flex items-center justify-between">
                        <label class="label cursor-pointer gap-2">
                            <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm">
                            <span class="label-text text-sm">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-primary hover:underline">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk
                    </button>
                </form>

                {{-- Demo Accounts --}}
                <div class="divider text-xs text-base-content/40">Demo Account</div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-base-200/60 rounded-xl p-3 text-center">
                        <p class="text-xs text-base-content/50">Admin</p>
                        <p class="text-sm font-medium text-primary">admin@smartk3.com</p>
                    </div>
                    <div class="bg-base-200/60 rounded-xl p-3 text-center">
                        <p class="text-xs text-base-content/50">Password</p>
                        <p class="text-sm font-mono font-medium">password</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-sm text-base-content/30 mt-6">
            © {{ date('Y') }} SMART K3. Hospital Fire Safety System.
        </p>
    </div>
</x-layouts.guest>
