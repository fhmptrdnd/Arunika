@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col md:flex-row items-stretch justify-center min-h-[70vh] relative z-20">

    <div class="bg-white my-10 rounded-[40px] shadow-2xl flex flex-col md:flex-row w-full overflow-hidden animate-slide-up opacity-0">

        <div class="w-full md:w-1/2 flex flex-col items-center justify-center pt-4 border-r border-gray-100">
            <h2 class="text-4xl font-bold text-darkblue mb-10 text-center">Daftar Sebagai</h2>

            <div class="w-55 h-55 bg-[#12A0D7] rounded-[40px] flex items-center justify-center border-[6px] border-blue-200 shadow-lg mb-6 hover:scale-105 transition-transform">
                 <img src="{{ asset('images/Admin.png') }}" alt="Orang Tua" class="w-full h-full">
            </div>
            <p class="text-2xl font-bold text-darkblue">Admin</p>
        </div>

        <div class="w-full md:w-3/5 p-10">
            <form action="#" method="POST" class="flex flex-col gap-3">
                @csrf

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
                    @error('name') <p class="text-red text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Email Sekolah / Pribadi</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="budi@sekolah.com"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
                    @error('email') <p class="text-red text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••••"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
                    @error('password') <p class="text-red text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Nama Sekolah</label>
                    <input type="text" name="school_name" value="{{ old('school_name') }}" placeholder="Contoh: SD Arunika 1 - Kelas 1A"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
                    @error('school_name') <p class="text-red text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Kode Kelas (Bila ada)</label>
                    <input type="text" name="school_code" value="{{ old('class_code') }}" placeholder="Contoh: ARN001"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors tracking-widest uppercase">
                    <p class="text-gray-400 text-xs mt-1 ml-2">*Kosongkan jika mendaftarkan kelas baru</p>
                    @error('school_code') <p class="text-red text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-yellow text-darkblue font-bold text-xl py-4 rounded-full mt-2 shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all">
                    Daftar
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
