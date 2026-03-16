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
            <form action="{{ route('register.parent') }}" method="POST" class="flex flex-col gap-4">
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

                <div id="children-container" class="flex flex-col gap-6 border-t-2 border-dashed border-gray-200 pt-6 mt-2">

                    <div class="child-form bg-blue-50 p-6 rounded-3xl border border-blue-100 relative">
                        <h3 class="font-bold text-darkblue mb-4 text-lg">Data Anak 1</h3>

                        <div class="flex flex-col gap-4">
                            <div>
                                <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Nama Lengkap Anak</label>
                                <input type="text" name="children[0][name]" placeholder="Contoh: Aruna Senja" required
                                       class="w-full px-5 py-3 rounded-full border-2 border-white focus:border-blue outline-none transition-colors">
                            </div>

                            <div>
                                <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Username Anak</label>
                                <input type="text" name="children[0][username]" placeholder="Contoh: aruna123" required
                                       class="w-full px-5 py-3 rounded-full border-2 border-white focus:border-blue outline-none transition-colors lowercase">
                            </div>

                            <div>
                                <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Kelas Anak</label>
                                <select name="children[0][class_age]" required
                                        class="w-full px-5 py-3 rounded-full border-2 border-white focus:border-blue outline-none transition-colors text-gray-600 cursor-pointer">
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="Kelas 1">Kelas 1 SD</option>
                                    <option value="Kelas 2">Kelas 2 SD</option>
                                    <option value="Kelas 3">Kelas 3 SD</option>
                                    <option value="Kelas 4">Kelas 4 SD</option>
                                    <option value="Kelas 5">Kelas 5 SD</option>
                                    <option value="Kelas 6">Kelas 6 SD</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <button type="button" onclick="addChildForm()" class="text-[#12A0D7] font-bold text-sm bg-blue-50 py-3 rounded-full border-2 border-dashed border-[#12A0D7] hover:bg-blue-100 transition-colors mt-2">
                    + Tambah Anak Lainnya
                </button>

                {{-- <button type="submit" class="...">Daftar</button> --}}

                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Kode Kelas (Opsional)</label>
                    <input type="text" name="class_code" value="{{ old('class_code') }}" placeholder="Contoh: ARN001 (Kosongkan jika belajar mandiri)"
                           class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors tracking-widest">
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
<script>
    let childCount = 1;

    function addChildForm() {
        const container = document.getElementById('children-container');

        const newForm = document.createElement('div');
        newForm.className = "child-form bg-blue-50 p-6 rounded-[24px] border border-blue-100 relative animate-slide-up mt-4";
        newForm.innerHTML = `
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-4 right-4 text-red-400 hover:text-red-600 font-bold text-xl">&times;</button>
            <h3 class="font-bold text-darkblue mb-4 text-lg">Data Anak ${childCount + 1}</h3>

            <div class="flex flex-col gap-4">
                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Nama Lengkap Anak</label>
                    <input type="text" name="children[${childCount}][name]" placeholder="Contoh: Aruna Senja" required
                           class="w-full px-5 py-3 rounded-full border-2 border-white focus:border-blue outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Username Anak (Unik)</label>
                    <input type="text" name="children[${childCount}][username]" placeholder="contoh: aruna123" required
                           class="w-full px-5 py-3 rounded-full border-2 border-white focus:border-blue outline-none transition-colors lowercase">
                </div>
                <div>
                    <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Kelas Anak</label>
                    <select name="children[${childCount}][class_age]" required
                            class="w-full px-5 py-3 rounded-full border-2 border-white focus:border-blue outline-none transition-colors text-gray-600 cursor-pointer">
                        <option value="" disabled selected>Pilih Kelas</option>
                        <option value="Kelas 1">Kelas 1 SD</option>
                        <option value="Kelas 2">Kelas 2 SD</option>
                        <option value="Kelas 3">Kelas 3 SD</option>
                        <option value="Kelas 4">Kelas 4 SD</option>
                        <option value="Kelas 5">Kelas 5 SD</option>
                        <option value="Kelas 6">Kelas 6 SD</option>
                    </select>
                </div>
            </div>
        `;

        container.appendChild(newForm);
        childCount++;
    }
</script>
@endsection
