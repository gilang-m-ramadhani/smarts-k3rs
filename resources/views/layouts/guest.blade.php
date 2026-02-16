<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Login' }} - {{ config('app.name', 'SMART K3') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-image:
                linear-gradient(
                    145deg,
                    rgba(0, 166, 81, 0.45),  
                    rgba(247, 147, 29, 0.45),
                    rgba(236, 0, 140, 0.18),  
                    rgba(102, 45, 145, 0.18)
                ),
                url('/images/bg-login.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .bg-pattern {
            background-image: 
                radial-gradient(ellipse at 20% 30%, rgba(0, 166, 81, 0.25) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(247, 147, 29, 0.25) 0%, transparent 50%),
                radial-gradient(ellipse at 40% 60%, rgba(236, 0, 140, 0.15) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 20%, rgba(102, 45, 145, 0.15) 0%, transparent 60%);
        }

        .floating-shapes {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .floating-shapes div {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(
                135deg,
                rgba(0, 166, 81, 0.25),
                rgba(247, 147, 29, 0.25)
            );
            animation: float 8s ease-in-out infinite;
        }

        .floating-shapes div:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
        }

        .floating-shapes div:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-shapes div:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(5deg);
            }
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Content -->
    <div class="page-wrapper bg-pattern">
        {{ $slot }}
    </div>
</body>
</html>
