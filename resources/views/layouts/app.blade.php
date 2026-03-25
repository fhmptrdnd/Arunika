<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arunika</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        const jam = new Date().getHours();
        // const jam = 17;
        if (jam >= 17 || jam < 6) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="relative overflow-x-hidden m-0 font-quicksand min-h-screen bg-linear-to-b from-sky1 via-sky2 to-sky3 dark:from-sky4 dark:via-sky5 dark:to-sky6 transition-all duration-700 bg-fixed">

    <img src="{{ asset('images/Background-Sun.png') }}"
         alt="Background Siang"
         class="fixed w-full h-full z-0 block dark:hidden pointer-events-none animate-slide-up">

    <img src="{{ asset('images/Background-Moon.png') }}"
         alt="Background Malam"
         class="fixed w-full h-full z-0 hidden dark:block pointer-events-none animate-slide-up-bg">

    <nav class="p-3 flex justify-between items-center sticky top-0 z-100 bg-white shadow-2xl">
        <div class="flex ml-5 items-center gap-3">
            <img src="{{ asset('images/Logo2.png') }}" class="w-10 h-8 bg-white flex items-center justify-center text-xl">
            <span class="text-darkblue dark:text-darkblue text-xl font-bold">Arunika</span>
        </div>

        <div class="flex mr-5 gap-4 items-center">
            @guest
                <a href="{{ route('login') }}" class="bg-darkblue text-white font-bold px-6 py-2 rounded-full hover:bg-blue-800 transition shadow-md no-underline">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="bg-[#E2E8F0] text-edu-darkblue font-bold px-6 py-2 rounded-full hover:bg-gray-300 transition shadow-md no-underline">
                    Daftar
                </a>
            @endguest

            @auth
            <a href="{{ route('placeholder') }}" class="bg-yellow text-darkblue font-bold px-4 py-2 hover:bg-yellow-400 transition rounded-full shadow-md">1 🔥</a>
            <a href="{{ route('profile') }}" class="bg-darkblue text-white font-bold px-6 py-2 rounded-full hover:bg-blue-800 transition shadow-md">Profil</a>
            <a href="{{ route('placeholder') }}" class="bg-orange text-white font-bold px-6 py-2 rounded-full hover:bg-orange-600 transition shadow-md">Riwayat</a>
            <a href="{{ route('siswa.perkembangan') }}" class="bg-teal text-white font-bold px-4 py-2 rounded-full hover:bg-teal/80 transition shadow-md">Perkembangan</a>
            <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                @csrf
                <button type="submit" class="bg-gray-300 text-darkblue font-bold px-6 py-2 rounded-full hover:bg-red-400 hover:text-white transition shadow-md cursor-pointer border-none outline-none">
                    Keluar
                </button>
            </form>
            @endauth
        </div>
    </nav>

    <main class="relative z-10">
        @yield('content')
    </main>

    </body>
</html>
