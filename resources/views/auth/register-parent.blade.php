@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col md:flex-row items-stretch justify-center min-h-[70vh] relative z-20">

    <div class="bg-white my-10 rounded-[40px] shadow-2xl flex flex-col md:flex-row w-full overflow-hidden animate-slide-up opacity-0">

        <div class="w-full md:w-2/5 p-10 flex flex-col items-center justify-center border-r border-gray-100">
            <h2 class="text-3xl font-bold text-darkblue mb-8">Daftar Sebagai</h2>

            <div class="w-55 h-55 bg-yellow rounded-[40px] flex items-center justify-center border-4 border-yellow-200 shadow-lg mb-6 hover:scale-105 transition-transform">
                <img src="{{ asset('images/OrangTua.png') }}" alt="Orang Tua" class="w-full h-full">
            </div>
            <p class="text-xl font-bold text-darkblue">Orang Tua</p>
        </div>

        <div class="w-full md:w-3/5 p-10">
            <form action="#" method="POST" class="flex flex-col gap-4">
                @csrf

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Email Anda</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="janedoe@gmail.com"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">

                    @error('email')
                        <p class="text-red text-sm mt-1 ml-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••••"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">

                    @error('password')
                        <p class="text-red text-sm mt-1 ml-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Nama Wali/Orang Tua</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
                    @error('name') <p class="text-red text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Nama Anak</label>
                    <input type="text" name="child_name" placeholder="Aruna"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
                    @error('child_name')
                        <p class="text-red text-sm mt-1 ml-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Kelas Anak</label>

                    <select name="class_age"
                            class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors text-gray-600 bg-white cursor-pointer appearance-none">

                        <option value="" disabled {{ old('class_age') ? '' : 'selected' }}>Pilih Kelas Anak</option>

                        <option value="Kelas 1" {{ old('class_age') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1 SD</option>
                        <option value="Kelas 2" {{ old('class_age') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2 SD</option>
                        <option value="Kelas 3" {{ old('class_age') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3 SD</option>
                        <option value="Kelas 4" {{ old('class_age') == 'Kelas 4' ? 'selected' : '' }}>Kelas 4 SD</option>
                        <option value="Kelas 5" {{ old('class_age') == 'Kelas 5' ? 'selected' : '' }}>Kelas 5 SD</option>
                        <option value="Kelas 6" {{ old('class_age') == 'Kelas 6' ? 'selected' : '' }}>Kelas 6 SD</option>
                    </select>

                    @error('class_age')
                        <p class="text-red text-sm mt-1 ml-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Kode Kelas</label>
                    <input type="text" name="class_code" value="{{ old('class_code') }}" placeholder="Contoh: ARN001"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors tracking-widest uppercase">

                    @error('class_code')
                        <p class="text-red text-sm mt-1 ml-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-yellow text-darkblue font-bold text-xl py-4 rounded-full mt-4 shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all">
                    Daftar
                </button>
            </form>

            <div class="mt-6 text-center text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-teal font-bold hover:underline">Masuk sekarang!</a>
            </div>
        </div>

    </div>
</div>
@endsection
