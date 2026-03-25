@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto flex flex-col min-h-[75vh] relative z-20 py-10 px-6">

        <div class="flex items-center gap-5 mb-10">
            <a href="{{ route('beranda') }}"
                class="bg-yellow text-darkblue font-bold px-6 py-2 rounded-full shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all no-underline gap-3">
                Kembali ke Beranda
            </a>
        </div>
        <div class="mb-10 animate-slide-up">
            <h1 class="text-5xl font-bold text-darkblue dark:text-white mb-2">{{ $title }}</h1>
            <p class="text-xl text-gray-600 dark:text-white">{{ $subtitle }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-pop-in delay-100">
            @if ($mapel == 'peminatan')
                @foreach ($subjects as $mapel)
                    <a href="{{ route('mapel.levels', ['slug' => $mapel['slug'], 'kelas' => $kelas]) }}"
                        class="bg-white rounded-[40px] p-8 shadow-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center no-underline group border-b-8 border-transparent hover:border-[#12A0D7]">

                        <div
                            class="w-32 h-32 {{ $mapel['color'] }} rounded-full flex items-center justify-center text-6xl shadow-inner mb-6 group-hover:scale-110 transition-transform duration-300">
                            {{ $mapel['icon'] }}
                        </div>

                        <h2 class="text-2xl font-bold text-darkblue mb-2">
                            {{ $mapel['name'] }}
                        </h2>

                        <div class="w-full bg-gray-200 rounded-full h-3 mt-4 overflow-hidden">
                            <div class="bg-yellow h-3 rounded-full" style="width: 0%"></div>
                        </div>

                        <p class="text-sm text-gray-400 mt-2 font-semibold">Belum dimulai</p>
                    </a>
                @endforeach
            @else
                @foreach ($subjects as $mapel)
                    <a href="{{ route('mapel.levels', ['slug' => $mapel['slug'], 'kelas' => $kelas]) }}"
                        class="bg-white rounded-[40px] p-8 shadow-xl hover:-translate-y-3 hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center no-underline group border-b-8 border-transparent hover:border-[#12A0D7]">
                        <div
                            class="w-32 h-32 {{ $mapel['color'] }} rounded-full flex items-center justify-center text-6xl shadow-inner mb-6 group-hover:scale-110 transition-transform duration-300">
                            {{ $mapel['icon'] }}
                        </div>

                        <h2 class="text-2xl font-bold text-darkblue mb-2">{{ $mapel['name'] }}</h2>

                        <div class="w-full bg-gray-200 rounded-full h-3 mt-4 overflow-hidden">
                            <div class="bg-yellow h-3 rounded-full" style="width: 0%"></div>
                        </div>
                        <p class="text-sm text-gray-400 mt-2 font-semibold">Belum dimulai</p>
                    </a>
                @endforeach
            @endif

        </div>
    </div>
@endsection
