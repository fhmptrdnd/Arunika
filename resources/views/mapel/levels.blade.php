@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto flex flex-col min-h-[75vh] relative z-20 py-10 px-6">

        <div class="flex items-center justify-between mb-12 animate-slide-up bg-white p-6 rounded-[30px] shadow-lg">
            <div class="flex items-center gap-4">
                <a href="{{ route('mapel.lainnya') }}"
                    class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-xl hover:bg-gray-200 transition-colors no-underline">
                    ←
                </a>
                <h1 class="text-3xl font-bold text-edu-darkblue m-0">Peta Level: {{ $subjectName }}</h1>
            </div>
            <div class="bg-edu-yellow text-edu-darkblue font-bold px-6 py-2 rounded-full text-lg shadow-sm">
                0 / 10 Bintang ⭐
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 animate-pop-in delay-200">
            @php
                $slugClean = trim(strtolower($slug));

                $mapelRoute = [
                    'bahasa-indonesia' => 'indo',
                    'matematika' => 'matematika',
                    'pkn' => 'pkn',
                ];

                $prefix = $mapelRoute[$slugClean] ?? null;

                $kelasNumber = (int) filter_var($kelas, FILTER_SANITIZE_NUMBER_INT);

                $isLevel1Done = $score && strtolower($score->mapel) == $slugClean && $level >= 1;

                $isLevel1Done = \App\Models\Score::where('user_id', auth()->id())
                    ->where('mapel', $slugClean)
                    ->where('kelas', $kelasNumber)
                    ->where('level', '>=', 1)
                    ->exists();

            @endphp

            @if ($kelasNumber === 1 && $prefix)
                {{-- LEVEL 1 --}}
                <a href="{{ route('mapel.' . $prefix . '.1.1') }}"
                    class="bg-[#12A0D7] rounded-[30px] p-6 shadow-[0_6px_0_#0e82b0] hover:-translate-y-1 hover:shadow-[0_8px_0_#0e82b0] active:translate-y-2 active:shadow-[0_0px_0_#0e82b0] transition-all flex flex-col items-center justify-center text-center border-4 border-white h-48">
                    <span class="text-5xl mb-2">🌟</span>
                    <h2 class="text-white font-bold text-2xl">Level 1</h2>
                    <p class="text-blue-100 text-sm font-semibold">Mulai Petualangan</p>
                </a>

                {{-- LEVEL 2 --}}
                @if ($isLevel1Done)
                    <a href="{{ route('mapel.' . $prefix . '.1.2') }}"
                        class="bg-[#12A0D7] rounded-[30px] p-6 shadow-[0_6px_0_#0e82b0] hover:-translate-y-1 hover:shadow-[0_8px_0_#0e82b0] active:translate-y-2 active:shadow-[0_0px_0_#0e82b0] transition-all flex flex-col items-center justify-center text-center border-4 border-white h-48">
                        <span class="text-5xl mb-2">🌟</span>
                        <h2 class="text-white font-bold text-2xl">Level 2</h2>
                        <p class="text-blue-100 text-sm font-semibold">Lanjutkan Petualangan</p>
                    </a>

                    {{-- LEVEL 3 - 8 LOCK --}}
                    @for ($i = 3; $i <= 8; $i++)
                        <div
                            class="bg-gray-200 rounded-[30px] p-6 shadow-[0_6px_0_#cbd5e1] flex flex-col items-center justify-center text-center border-4 border-white h-48 opacity-75 cursor-not-allowed">
                            <span class="text-5xl mb-2 grayscale">🔒</span>
                            <h2 class="text-gray-400 font-bold text-2xl">Level {{ $i }}</h2>
                            <p class="text-gray-400 text-sm font-semibold">Terkunci</p>
                        </div>
                    @endfor
                @else
                    {{-- LEVEL 2 - 8 LOCK --}}
                    @for ($i = 2; $i <= 8; $i++)
                        <div
                            class="bg-gray-200 rounded-[30px] p-6 shadow-[0_6px_0_#cbd5e1] flex flex-col items-center justify-center text-center border-4 border-white h-48 opacity-75 cursor-not-allowed">
                            <span class="text-5xl mb-2 grayscale">🔒</span>
                            <h2 class="text-gray-400 font-bold text-2xl">Level {{ $i }}</h2>
                            <p class="text-gray-400 text-sm font-semibold">Terkunci</p>
                        </div>
                    @endfor
                @endif
            @else
                <div class="col-span-4 text-center text-gray-400 font-semibold">
                    Mapel atau kelas tidak tersedia
                </div>
            @endif

        </div>
    </div>
@endsection
