<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Arunika</title>
    @vite('resources/css/app.css')
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-[#F8FAFC] text-gray-800 font-quicksand flex min-h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between h-screen fixed left-0 top-0 z-50 shadow-sm">
        <div class="px-8 py-10 overflow-y-auto no-scrollbar">
            <a href="#" class="flex items-center gap-4 mb-12 no-underline">
                <img src="{{ asset('images/Logo2.png') }}" class="w-10 h-8 bg-white flex items-center justify-center text-xl">
                <span class="text-darkblue text-2xl font-bold">Arunika</span>
            </a>

            <nav class="flex flex-col gap-4">
                @php
                    $activeClass = 'bg-blue text-white shadow-[0_4px_15px_rgba(61,91,134,0.8)]';
                    $inactiveClass = 'bg-[#F8FAFC] text-blue hover:bg-blue/10 group';
                @endphp

                <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-4 px-6 py-4 rounded-full font-bold transition-all no-underline {{ request()->routeIs('guru.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="bi {{ request()->routeIs('guru.dashboard') ? 'bi-house-door-fill' : 'bi-house-door opacity-80' }} text-2xl leading-none"></i>
                    <span class="text-lg">Beranda</span>
                </a>

                <a href="{{ route('guru.siswa') }}" class="flex items-center gap-4 px-6 py-4 rounded-full font-bold transition-all no-underline {{ request()->routeIs('guru.siswa*') ? $activeClass : $inactiveClass }}">
                    <i class="bi {{ request()->routeIs('guru.siswa*') ? 'bi-people-fill' : 'bi-people opacity-80' }} text-2xl leading-none"></i>
                    <span class="text-lg">Siswa Kelas</span>
                </a>

                <a href="{{ route('guru.tugas') }}" class="flex items-center gap-4 px-6 py-4 rounded-full font-bold transition-all no-underline {{ request()->routeIs('guru.tugas*') ? $activeClass : $inactiveClass }}">
                    <i class="bi {{ request()->routeIs('guru.tugas*') ? 'bi-journal-check' : 'bi-journal opacity-80' }} text-2xl leading-none"></i>
                    <span class="text-lg">Kelola Tugas</span>
                </a>

                <a href="{{ route('guru.profil') }}" class="flex items-center gap-4 px-6 py-4 rounded-full font-bold transition-all no-underline {{ request()->routeIs('guru.profil') ? $activeClass : $inactiveClass }}">
                    <i class="bi {{ request()->routeIs('guru.profil') ? 'bi-person-circle' : 'bi-person-circle opacity-80' }} text-2xl leading-none"></i>
                    <span class="text-lg">Profil & Pengaturan</span>
                </a>
            </nav>
        </div>

        <div class="p-5">
            <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                @csrf
                <button type="submit" class="w-full bg-gray-100 text-gray-500 font-bold px-6 py-3 rounded-full hover:bg-red-50 hover:text-red-500 transition shadow-sm flex justify-center items-center gap-2 cursor-pointer border-none outline-none">
                     Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 h-screen overflow-y-auto p-8 lg:p-12">
        <header class="flex justify-between items-center mb-10">
            <p class="text-gray-500 text-lg">Halo, <span class="font-bold text-darkblue">{{ auth()->user()->name }}!</span></p>
            <div class="bg-white border border-gray-200 text-gray-600 font-semibold px-5 py-2 rounded-full text-sm shadow-sm flex items-center gap-2">
                <i class="bi bi-buildings text-gray-400"></i> {{ auth()->user()->school_name ?? 'Sekolah Arunika' }}
            </div>
        </header>
        @yield('content')
    </main>

</body>
</html>
