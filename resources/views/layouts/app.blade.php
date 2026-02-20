@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="smartk3">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'SMART K3') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .body-bg {
            background-image: 
                linear-gradient(
                    145deg,
                    rgba(0, 166, 81, 0.45),   /* #00A651 - Hijau */
                    rgba(247, 147, 29, 0.45), /* #F7931D - Oranye */
                    rgba(0, 77, 38, 0.18),    /* #004D26 - Hijau Gelap */
                    rgba(230, 247, 238, 0.18) /* #E6F7EE - Hijau Muda/Mint */
                ),
                url('/images/bg-app.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .bg-smart-gradient {
            background-image: linear-gradient(to right, #00A651, #F7931D, #004D26, #E6F7EE);
        }

        @media (prefers-reduced-motion: no-preference) {
            .body-bg {
                background-color: #f5f5f5; /* fallback */
            }
        }
    </style>
</head>
<body class="body-bg min-h-screen text-base-content">

    <div class="drawer lg:drawer-open">
        <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />
        
        <div class="drawer-content flex flex-col transition-all duration-300">
            
            <div class="h-1 bg-smart-gradient sticky top-0 z-50 w-full"></div>
            
            <div class="navbar glass-navbar sticky top-1 z-40 px-4">
                <div class="flex-none lg:hidden">
                    <label for="sidebar-drawer" class="btn btn-square btn-ghost text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                
                <div class="flex-1 px-2 mx-2">
                    <div class="flex flex-col">
                        <h1 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">
                            {{ $title }}
                        </h1>
                    </div>
                </div>

                <div class="flex-none gap-2">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle hover:bg-primary/10">
                            <div class="indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-base-content/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="badge badge-xs badge-secondary indicator-item animate-pulse">3</span>
                            </div>
                        </label>
                        <div tabindex="0" class="dropdown-content z-[1] card card-compact w-80 p-2 shadow-xl glass-navbar mt-3 border border-white/50">
                            <div class="card-body">
                                <span class="font-bold text-lg text-primary">Notifikasi</span>
                                <div class="divider my-0"></div>
                                <p class="text-sm text-base-content/60 py-2">Tidak ada notifikasi baru</p>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar placeholder border border-white/40 shadow-sm">
                            <div class="bg-gradient-to-br from-primary to-secondary text-white rounded-full w-10">
                                <span class="text-sm font-semibold">{{ auth()->check() ? substr(auth()->user()->name, 0, 2) : 'G' }}</span>
                            </div>
                        </label>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-xl menu menu-sm dropdown-content glass-navbar rounded-xl w-56 border border-white/50">
                            <li class="menu-title px-4 py-2 bg-gray-50/50 rounded-t-lg mb-2">
                                <span class="text-primary font-bold text-sm">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                            </li>
                            <li><a href="{{ route('profile') }}" class="hover:text-primary hover:bg-primary/5">Profil Saya</a></li>
                            <li><a href="#" class="hover:text-primary hover:bg-primary/5">Pengaturan</a></li>
                            <li class="divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-error font-medium hover:bg-error/10 w-full text-left">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="flex-1 p-6 overflow-y-auto scrollbar-thin">
                {{ $slot }}
            </main>

            <footer class="footer footer-center p-4 text-base-content/70 glass-footer relative">
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-primary/40 to-transparent"></div>
                <div>
                    <p class="font-medium">Copyright © {{ date('Y') }} <span class="text-primary font-bold">SMART K3</span></p>
                    <p class="text-xs opacity-70">Sistem Manajemen APAR Rumah Sakit</p>
                </div>
            </footer>
        </div>
        
        <div class="drawer-side z-50">
            <label for="sidebar-drawer" class="drawer-overlay"></label>
            <aside class="glass-sidebar w-60 min-h-screen flex flex-col">
                
                <div class="h-1 w-full bg-smart-gradient"></div>

                <div class="p-6 border-b border-white/20">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary to-secondary shadow-lg shadow-primary/20 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <h1 class="font-bold text-xl tracking-tight bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">SMART K3</h1>
                            <p class="text-[10px] font-bold tracking-widest text-base-content/50 uppercase">Manajemen APAR</p>
                        </div>
                    </a>
                </div>

                <ul class="menu p-4 gap-1.5 font-medium text-base-content/70 overflow-y-auto">
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <li class="menu-title mt-4 text-xs font-bold text-base-content/40 uppercase tracking-wider px-2"><span>Inventory</span></li>
                    <li>
                        <a href="{{ route('apar.index') }}" class="{{ request()->routeIs('apar.*') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                            </svg>
                            Data APAR
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lokasi.index') }}" class="{{ request()->routeIs('lokasi.*') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lokasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('vendor.index') }}" class="{{ request()->routeIs('vendor.*') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Vendor
                        </a>
                    </li>

                    <li class="menu-title mt-4 text-xs font-bold text-base-content/40 uppercase tracking-wider px-2"><span>Operasional</span></li>
                    <li>
                        <a href="{{ route('inspeksi.index') }}" class="{{ request()->routeIs('inspeksi.*') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Inspeksi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('maintenance.index') }}" class="{{ request()->routeIs('maintenance.*') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Maintenance
                        </a>
                    </li>
                    
                    <li class="menu-title mt-4 text-xs font-bold text-base-content/40 uppercase tracking-wider px-2"><span>Laporan</span></li>
                    <li>
                         <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Laporan
                        </a>
                    </li>

                    @can('user.view')
                    <li class="menu-title mt-4 text-xs font-bold text-base-content/40 uppercase tracking-wider px-2"><span>Pengaturan</span></li>
                    <li>
                         <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'menu-gradient-active' : 'hover:bg-primary/5 hover:text-primary' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Manajemen User
                        </a>
                    </li>
                    @endcan
                </ul>
            </aside>
        </div>
    </div>

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @stack('scripts')
</body>
</html>