<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tes Penempatan — Arunika')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Quicksand', sans-serif; }
    </style>
</head>

<body class="overflow-x-hidden">
    <!-- NAVBAR PLACEMENT-->
    <nav class="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 z-50">
        <div class="mx-auto px-10 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm">🎓</div>
                <span class="text-darkblue font-bold text-lg">Arunika</span>
            </div>
            <span class="text-darkblue/70 text-sm font-bold">
                Halo, Aruna
                <span class="text-darkblue font-extrabold">
                    {{ explode(' ', trim($student->name))[0] }}!
                </span>
            </span>
        </div>
    </nav>
    
    <!-- BACKGROUND SCENE -->
    <div class="absolute w-full h-full block dark:hidden transition-transform duration-500 hover:scale-110 cursor-pointer group z-10">

        <img class="bottom-0 fixed" src="{{ asset('images/bg_placement.png') }}"
        alt="Matahari Siang">
    </div>

    @yield('content')

</body>
</html>