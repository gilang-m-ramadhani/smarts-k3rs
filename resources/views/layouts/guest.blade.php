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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .bg-pattern {
            background-image:
                radial-gradient(ellipse at 20% 30%, rgba(8,131,149,0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(122,178,178,0.2) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(235,244,246,0.4) 0%, transparent 70%);
        }
        .floating-shapes div {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(8,131,149,0.12), rgba(122,178,178,0.18));
            animation: float 8s ease-in-out infinite;
        }
        .floating-shapes div:nth-child(1) { width: 300px; height: 300px; top: 10%; left: 10%; animation-delay: 0s; }
        .floating-shapes div:nth-child(2) { width: 200px; height: 200px; top: 60%; right: 15%; animation-delay: 2s; }
        .floating-shapes div:nth-child(3) { width: 150px; height: 150px; bottom: 20%; left: 20%; animation-delay: 4s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-50 via-cyan-50 to-sky-50 bg-pattern">
    <div class="floating-shapes fixed inset-0 overflow-hidden pointer-events-none">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        {{ $slot }}
    </div>
</body>
</html>
