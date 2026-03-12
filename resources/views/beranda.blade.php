@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 pt-10 pb-5 flex flex-col min-h-[80vh] justify-between">

    <div class="flex justify-between items-start">
        <div class="ml-10 max-w-md mt-25 animate-slide-up">
            @php
                $user = auth()->user();
                // 1. Ambil nama
                $namaLengkap = $user ? ($user->child_name ?? $user->name) : 'Pengguna';
                // 2. Pecah lewat indeks spasi pertama
                $namaDepan = explode(' ', trim($namaLengkap))[0];
            @endphp
            <h1 class="text-5xl font-bold text-darkblue dark:text-white mb-4 leading-tight">
                Hai, <span class="text-darkblue dark:text-yellow">{{ $namaDepan }}!</span>
            </h1>
            <p class="text-xl text-darkblue w-100 dark:text-gray-100">
                Mau belajar apa hari ini? Yuk belajar bersama kami dengan cara yang menyenangkan!
            </p>
        </div>

        <div class="relative right-10 w-90 h-90 flex items-center justify-center animate-pop-in">
            <div class="absolute w-full h-full block dark:hidden transition-transform duration-500 hover:scale-110 cursor-pointer group z-10">

                <img src="{{ asset('images/Sun2.png') }}"
                    alt="Matahari Siang"
                    class="w-full h-full object-contain drop-shadow-xl transition-transform duration-100000 ease-out group-hover:rotate-3600 group-hover:duration-100000 group-hover:ease-linear">
            </div>

            <div class="absolute w-full h-full hidden dark:block transition-transform duration-500 hover:scale-110 cursor-pointer group z-10">

                <img src="{{ asset('images/Moon.png') }}"
                    alt="Bulan Malam"
                    class="w-full h-full object-contain drop-shadow-xl transition-transform duration-100000 ease-out group-hover:rotate-3600 group-hover:duration-100000 group-hover:ease-linear">
            </div>
        </div>
    </div>

    <div class="flex justify-center gap-20 mt-10 relative z-20 animate-pop-in">
        <a href="{{ route('mapel.peminatan') }}" class="bg-white rounded-[40px] p-5 w-120 shadow-lg hover:-translate-y-2 transition-transform duration-300 flex items-center gap-6 text-left no-underline">
            <img src="{{ asset('images/Book_Peminatan.png') }}" alt="Peminatan" class="w-20 h-20 object-contain shrink-0">
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-bold text-edu-darkblue">Mapel Peminatan</h2>
                <p class="text-gray-600 text-md leading-relaxed">
                    Sebelumnya kami sudah mengetahui minat belajarmu, yuk asah terus kemampuanmu!
                </p>
            </div>
        </a>

        <a href="{{ route('mapel.lainnya') }}" class="bg-white rounded-[40px] p-5 w-120 shadow-lg hover:-translate-y-2 transition-transform duration-300 flex items-center gap-6 text-left no-underline">
            <img src="{{ asset('images/Book_Lainnya.png') }}" alt="Peminatan" class="w-25 h-25 object-contain shrink-0">
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-bold text-edu-darkblue">Mapel Lainnya</h2>
                <p class="text-gray-600 text-md leading-relaxed">
                    Masih banyak ilmu di dunia ini selain yang kamu ketahui, yuk jelajahi hal baru!
                </p>
            </div>
        </a>
    </div>

    <div class="flex justify-between items-start">

    </div>

</div>
@endsection
