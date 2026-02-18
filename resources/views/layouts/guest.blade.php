<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="smartk3">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Login' }} - {{ config('app.name', 'SMART K3') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Only load CSS, no JS/Livewire needed for static login page --}}
    @vite(['resources/css/app.css'])

    {{-- Prevent FOUC: apply saved theme instantly --}}
    <script>
        (function(){
            var t = localStorage.getItem('smartk3-theme');
            if (t) document.documentElement.setAttribute('data-theme', t);
        })();
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }

        .mesh-gradient {
            background:
                radial-gradient(ellipse at 10% 20%, rgba(8,131,149,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 80%, rgba(122,178,178,0.10) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 100%, rgba(9,99,126,0.06) 0%, transparent 60%);
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.5;
            animation: orbit 20s ease-in-out infinite;
        }
        .orb-1 { width: 400px; height: 400px; top: -10%; left: -5%; background: rgba(8,131,149,0.12); animation-delay: 0s; }
        .orb-2 { width: 300px; height: 300px; bottom: -5%; right: -5%; background: rgba(122,178,178,0.15); animation-delay: -7s; }
        .orb-3 { width: 200px; height: 200px; top: 50%; left: 50%; background: rgba(9,99,126,0.08); animation-delay: -14s; }

        @keyframes orbit {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(20px, -15px) scale(1.05); }
            66% { transform: translate(-15px, 10px) scale(0.95); }
        }

        .login-card {
            backdrop-filter: blur(24px) saturate(1.8);
            -webkit-backdrop-filter: blur(24px) saturate(1.8);
        }

        .input-modern {
            transition: all 0.2s ease;
        }
        .input-modern:focus {
            box-shadow: 0 0 0 3px rgba(8,131,149,0.12);
        }

        .fade-up {
            animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            opacity: 0;
        }
        .fade-up-delay { animation-delay: 0.1s; }
        .fade-up-delay-2 { animation-delay: 0.2s; }
        .fade-up-delay-3 { animation-delay: 0.3s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen bg-base-200 mesh-gradient">
    {{-- Subtle orb background --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        {{ $slot }}
    </div>
</body>
</html>
