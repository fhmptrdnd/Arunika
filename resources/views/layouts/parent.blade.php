<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orang Tua - Arunika</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-gray-800 font-quicksand flex min-h-screen overflow-hidden">

    <aside class="w-70 bg-white border-r border-gray-100 flex flex-col justify-between h-screen fixed left-0 top-0 z-50 shadow-sm">
        <div class="px-8 py-10 overflow-y-auto no-scrollbar">
            <a href="#" class="flex items-center gap-4 mb-12 no-underline">
                <div class="w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('images/logo-arunika.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <span class="text-darkblue text-2xl font-bold">Arunika</span>
            </a>

            <nav class="flex flex-col gap-3">
                <a href="#" class="flex items-center gap-4 bg-[#F8FAFC] text-[#12A0D7] hover:bg-blue-50 px-6 py-4 rounded-full font-bold transition-colors no-underline">
                    <img src="{{ asset('images/icon-beranda-biru.png') }}" class="w-6 h-6 opacity-80"> Beranda
                </a>
                <a href="#" class="flex items-center gap-4 bg-[#F8FAFC] text-[#12A0D7] hover:bg-blue-50 px-6 py-4 rounded-full font-bold transition-colors no-underline">
                    <img src="{{ asset('images/icon-game-biru.png') }}" class="w-6 h-6 opacity-80"> Petualangan
                </a>
                <a href="#" class="flex items-center gap-4 bg-[#F8FAFC] text-[#12A0D7] hover:bg-blue-50 px-6 py-4 rounded-full font-bold transition-colors no-underline">
                    <img src="{{ asset('images/icon-tugas-biru.png') }}" class="w-6 h-6 opacity-80"> Tugas & Tantangan
                </a>
                <a href="#" class="flex items-center gap-4 bg-[#F8FAFC] text-[#12A0D7] hover:bg-blue-50 px-6 py-4 rounded-full font-bold transition-colors no-underline">
                    <img src="{{ asset('images/icon-riwayat-biru.png') }}" class="w-6 h-6 opacity-80"> Riwayat & Capaian
                </a>
                <a href="#" class="flex items-center gap-4 bg-[#F8FAFC] text-[#12A0D7] hover:bg-blue-50 px-6 py-4 rounded-full font-bold transition-colors no-underline">
                    <img src="{{ asset('images/icon-grafik-biru.png') }}" class="w-6 h-6 opacity-80"> Perkembangan
                </a>
                <a href="{{ route('parent.profil') }}" class="flex items-center gap-4 bg-[#12A0D7] text-white px-6 py-4 rounded-full font-bold transition-all shadow-md no-underline">
                    <img src="{{ asset('images/icon-profil-putih.png') }}" class="w-6 h-6"> Profil
                </a>
            </nav>
        </div>

        <div class="p-5 flex flex-col gap-3">

            @if(auth()->user()->role === 'parent' && auth()->user()->children->count() > 0)
            <div class="relative">
                <div id="childMenu" class="absolute bottom-full left-0 mb-3 bg-white border border-gray-100 shadow-[0_10px_40px_rgba(0,0,0,0.1)] rounded-3xl p-4 w-full transform translate-y-4 opacity-0 pointer-events-none transition-all duration-300 ease-out origin-bottom z-50">
                    <h4 class="font-bold text-gray-400 tracking-widest uppercase text-[10px] mb-3 px-2">Masuk ke sesi anak:</h4>

                    <div class="flex flex-col gap-2">
                        @foreach(auth()->user()->children as $child)
                        <a href="{{ route('switch.account', $child->id) }}" class="flex items-center gap-3 p-2 hover:bg-[#F4FBFE] rounded-xl transition-colors no-underline group border border-transparent hover:border-blue-100">
                            <div class="w-10 h-10 bg-[#FEF5D3] rounded-full flex items-center justify-center shrink-0 border-2 border-white shadow-sm">
                                <span class="font-bold text-orange text-sm">{{ strtoupper(substr($child->name, 0, 1)) }}</span>
                            </div>
                            <div class="overflow-hidden">
                                <p class="font-bold text-darkblue text-sm group-hover:text-[#12A0D7] transition-colors leading-tight truncate">{{ $child->name }}</p>
                                <p class="text-[11px] font-semibold text-gray-400 truncate">{{ $child->kelas }}</p>
                            </div>
                        </a>
                        @endforeach
                        <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0 items-center">
                            @csrf
                            <button type="submit" class="bg-gray-300 text-darkblue font-bold px-20 py-2 rounded-full hover:bg-red-400 hover:text-white transition shadow-md cursor-pointer border-none outline-none">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                <div onclick="toggleChildMenu()" class="bg-[#FEF5D3] text-[#7A6311] rounded-full px-6 py-4 flex items-center justify-between cursor-pointer hover:bg-[#D6F0FA] transition-colors shadow-sm border border-blue-50">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">👥</span>
                        <span class="font-bold text-sm truncate w-24">{{ explode(' ', trim(auth()->user()->name))[0] }}</span>
                    </div>
                    <span id="childMenuArrow" class="text-[10px] font-bold transition-transform duration-300">▲</span>
                </div>
            </div>
            @endif

        </div>
    </aside>

    <main class="flex-1 ml-70 h-screen overflow-y-auto p-10 lg:p-14">
        @yield('content')
    </main>

    <script>
        function toggleChildMenu() {
            const menu = document.getElementById('childMenu');
            const arrow = document.getElementById('childMenuArrow');

            if (menu.classList.contains('opacity-0')) {
                menu.classList.remove('translate-y-4', 'opacity-0', 'pointer-events-none');
                menu.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('translate-y-4', 'opacity-0', 'pointer-events-none');
                menu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
                arrow.classList.remove('rotate-180');
            }
        }
    </script>

</body>
</html>
