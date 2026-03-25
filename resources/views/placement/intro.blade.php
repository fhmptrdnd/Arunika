@extends('layouts.placement')

@section('title', 'Tes Penempatan — Arunika')

@section('content')

<div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 relative z-10">

    <!-- CARD INTRO -->
    <div class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden animate-slide-up">

        <div class="relative h-36 flex items-end justify-center overflow-hidden">
            <h1 class="text-darkyellow absolute top-13 text-3xl font-extrabold z-10">Tes Penempatan </h1>
            <img src="{{ asset('images/header_placement.png') }}"
                 class="px-2 absolute w-full h-full object-contain">
        </div>

        <div class="px-8 py-8 text-center">

            <p class="text-darkblue text-md font-semibold leading-[25px] mb-6">
                Halo, Aruna!
                Mari kita temukan kekuatan supermu<br class="hidden sm:block">
                sebelum memulai petualangan di Arunika!
            </p>

            <div class="flex items-center justify-center gap-4 mb-6 flex-wrap">
                <div class="flex items-center gap-2 border-2 border-[#01A7E1]/40 rounded-full px-5 py-2 text-sm font-bold text-[#0D2552]">
                    📝 {{ $total }} Soal
                </div>
                <div class="flex items-center gap-2 border-2 border-[#01A7E1]/40 rounded-full px-5 py-2 text-sm font-bold text-[#0D2552]">
                    ⏱️ 15 Menit
                </div>
            </div>

            <p class="text-[#0D2552]/50 text-sm font-semibold mb-7 leading-relaxed">
                Tidak ada jawaban benar atau salah selama tes.<br>
                Kerjakan dengan jujur yaa!
            </p>

            <a href="{{ route('placement.start') }}"
               class="inline-flex items-center justify-center gap-2 w-full
                      bg-yellow text-darkyellow font-extrabold text-lg px-10 py-4 rounded-full
                      shadow-[0_5px_0_#d9b824]
                      hover:-translate-y-1 hover:shadow-[0_7px_0_#d9b824]
                      active:translate-y-1 active:shadow-[0_2px_0_#d9b824]
                      transition-all">
                Mulai Tes →
            </a>

        </div>
    </div>

    <p class="mt-5 text-darkyellow text-xs font-medium">
        Tes untuk <span class="font-bold">{{ $kelas }}</span>
    </p>

</div>
@endsection