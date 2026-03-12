@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col items-center justify-center min-h-[75vh] relative z-20">

    <h1 class="text-5xl font-bold text-darkblue dark:text-white mb-16 animate-slide-up opacity-0">Daftar Sebagai</h1>

    <div class="flex flex-col md:flex-row gap-16 animate-pop-in opacity-0 delay-200">

        <a href="{{ route('register.parent') }}" class="group flex flex-col items-center outline-none no-underline">

            <div class="w-64 h-64 bg-[#FBD740] rounded-[50px] flex items-center justify-center ring-8 ring-white/50 shadow-xl group-hover:scale-105 group-hover:ring-white transition-all duration-300">
                <img src="{{ asset('images/OrangTua.png') }}" alt="Orang Tua">
            </div>

            <p class="mt-8 text-2xl font-bold text-gray-700 dark:text-white group-hover:text-orange dark:group-hover:[-webkit-text-stroke:1px_white] transition-colors">Orang Tua</p>
        </a>

        <a href="{{ route('register.admin') }}" class="group flex flex-col items-center outline-none no-underline">

            <div class="w-64 h-64 bg-[#12A0D7] rounded-[50px] flex items-center justify-center ring-8 ring-white/50 shadow-xl group-hover:scale-105 group-hover:ring-white transition-all duration-300">
                <img src="{{ asset('images/Admin.png') }}" alt="Admin">
            </div>

            <p class="mt-8 text-2xl font-bold text-gray-700 dark:text-white group-hover:text-[#12A0D7] dark:group-hover:[-webkit-text-stroke:1px_white] transition-colors">Admin</p>
        </a>

    </div>

</div>
@endsection
