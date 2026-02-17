<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="smartk3">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'SMART K3') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-base-200">

    {{-- DRAWER --}}
    <div class="drawer lg:drawer-open">
        <input id="main-drawer" type="checkbox" class="drawer-toggle" />

        {{-- PAGE CONTENT --}}
        <div class="drawer-content flex flex-col">

            {{-- NAVBAR --}}
            <nav class="navbar bg-base-100 shadow-sm sticky top-0 z-30 border-b border-base-300/50 px-4">
                {{-- Mobile drawer toggle --}}
                <div class="flex-none lg:hidden">
                    <label for="main-drawer" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </label>
                </div>

                {{-- Breadcrumb area --}}
                <div class="flex-1 px-2">
                    <span class="text-sm text-base-content/50 hidden sm:inline">SMART K3</span>
                </div>

                {{-- Right actions --}}
                <div class="flex-none flex items-center gap-1">

                    {{-- Dark mode toggle --}}
                    <button id="theme-toggle" class="btn btn-ghost btn-circle btn-sm" title="Toggle Dark Mode">
                        {{-- Sun icon (shown in light mode) --}}
                        <svg id="icon-sun" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,17.05a1,1,0,0,0,0,1.41l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/>
                        </svg>
                        {{-- Moon icon (shown in dark mode) --}}
                        <svg id="icon-moon" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/>
                        </svg>
                    </button>

                    {{-- Notifications --}}
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box shadow-lg w-72 p-4 mt-2 border border-base-300">
                            <li class="menu-title text-sm font-bold">Notifikasi</li>
                            <li><a class="text-base-content/60 text-sm">Tidak ada notifikasi baru</a></li>
                        </ul>
                    </div>

                    {{-- User avatar --}}
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-9">
                                <span class="text-sm font-semibold">{{ auth()->check() ? auth()->user()->initials : 'G' }}</span>
                            </div>
                        </div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box shadow-lg w-56 p-2 mt-2 border border-base-300">
                            <li class="menu-title">
                                <span>{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                            </li>
                            <li><a href="{{ route('profile') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil
                            </a></li>
                            <div class="divider my-0"></div>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-error w-full text-left flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-4 lg:p-6">
                {{ $slot }}

                {{-- Footer --}}
                <footer class="text-center text-sm text-base-content/40 py-6 mt-8">
                    © {{ date('Y') }} SMART K3 — Sistem Manajemen APAR Rumah Sakit
                </footer>
            </main>
        </div>

        {{-- SIDEBAR --}}
        <div class="drawer-side z-40">
            <label for="main-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

            <aside class="bg-base-100 border-r border-base-300/50 w-64 min-h-full flex flex-col">
                {{-- Brand --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-5">
                    <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-md shadow-primary/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-content" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-extrabold text-lg text-primary tracking-tight">SMART K3</div>
                        <div class="text-xs text-base-content/40 -mt-0.5">Fire Safety System</div>
                    </div>
                </a>

                <div class="divider my-0 mx-4"></div>

                {{-- Menu --}}
                <ul class="menu menu-sm px-3 flex-1 gap-0.5 [&_li>a]:rounded-lg">
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                    </li>

                    <li class="menu-title mt-3 text-xs uppercase tracking-wider text-base-content/40">
                        <span>Inventory</span>
                    </li>
                    <li>
                        <a href="{{ route('apar.index') }}" class="{{ request()->routeIs('apar.*') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                            Data APAR
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lokasi.index') }}" class="{{ request()->routeIs('lokasi.*') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Lokasi
                        </a>
                    </li>

                    <li class="menu-title mt-3 text-xs uppercase tracking-wider text-base-content/40">
                        <span>Operasional</span>
                    </li>
                    <li>
                        <a href="{{ route('inspeksi.index') }}" class="{{ request()->routeIs('inspeksi.*') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Inspeksi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('maintenance.index') }}" class="{{ request()->routeIs('maintenance.*') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Maintenance
                        </a>
                    </li>

                    <li class="menu-title mt-3 text-xs uppercase tracking-wider text-base-content/40">
                        <span>Laporan</span>
                    </li>
                    <li>
                        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Laporan
                        </a>
                    </li>

                    <li class="menu-title mt-3 text-xs uppercase tracking-wider text-base-content/40">
                        <span>Administrasi</span>
                    </li>
                    <li>
                        <a href="{{ route('vendor.index') }}" class="{{ request()->routeIs('vendor.*') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Vendor
                        </a>
                    </li>
                    @can('user.view')
                    <li>
                        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Manajemen User
                        </a>
                    </li>
                    @endcan
                </ul>
            </aside>
        </div>
    </div>

    @livewireScripts

    {{-- ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- Dark mode script --}}
    <script>
        (function() {
            const btn = document.getElementById('theme-toggle');
            const html = document.documentElement;
            const iconSun = document.getElementById('icon-sun');
            const iconMoon = document.getElementById('icon-moon');
            const saved = localStorage.getItem('smartk3-theme');

            function applyTheme(theme) {
                html.setAttribute('data-theme', theme);
                localStorage.setItem('smartk3-theme', theme);
                if (theme === 'smartk3dark') {
                    iconSun.classList.remove('hidden');
                    iconMoon.classList.add('hidden');
                } else {
                    iconSun.classList.add('hidden');
                    iconMoon.classList.remove('hidden');
                }
            }

            // Apply saved or system preference
            if (saved === 'smartk3dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                applyTheme('smartk3dark');
            } else {
                applyTheme('smartk3');
            }

            btn.addEventListener('click', () => {
                const current = html.getAttribute('data-theme');
                applyTheme(current === 'smartk3dark' ? 'smartk3' : 'smartk3dark');
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>