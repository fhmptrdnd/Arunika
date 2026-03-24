@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mt-10 mx-auto flex flex-col items-center justify-center min-h-[75vh] relative z-20">

        <div
            class="bg-white rounded-[40px] shadow-2xl w-full p-10 flex flex-col md:flex-row gap-10 animate-pop-in opacity-0 delay-200">

            <div
                class="w-full md:w-1/3 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100 pb-8 md:pb-0">
                @if ($user->role === 'admin')
                    <div class="w-40 h-40 flex items-center justify-center mb-6">
                        <img src="{{ asset('images/Admin.png') }}" alt="Admin">
                    </div>
                    <span
                        class="bg-blue-100 text-[#12A0D7] font-bold px-4 py-2 rounded-full text-sm tracking-widest uppercase">Admin
                        Sekolah</span>
                @else
                    <div class="w-40 h-40 flex items-center justify-center mb-6">
                        <img src="{{ asset('images/OrangTua.png') }}" alt="Ortu">
                    </div>
                    <span
                        class="bg-yellow-100 text-orange font-bold px-4 py-2 rounded-full text-sm tracking-widest uppercase">Orang
                        Tua</span>
                @endif

                <h2 class="text-2xl font-bold text-darkblue mt-4 text-center">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>

            <div class="w-full md:w-2/3 flex flex-col justify-center">

                <h3 class="text-xl font-bold text-gray-400 mb-6 border-b pb-2">Informasi Akun</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-sm text-gray-500 font-semibold mb-1">Nama Sekolah</p>
                        <p class="font-bold text-darkblue text-lg">{{ $user->school_name ?? 'Belum Terdaftar' }}</p>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                        <p class="text-sm text-[#12A0D7] font-semibold mb-1">Kode Sekolah</p>

                        @if ($user->class_code)
                            <div class="flex items-center justify-between">
                                <p class="font-bold text-[#12A0D7] text-xl tracking-widest">{{ $user->class_code }}</p>
                                <span class="text-blue-300">📋</span>
                            </div>
                        @else
                            <form action="{{ route('profile.update.school') }}" method="POST" class="mt-2">
                                @csrf
                                <div class="flex gap-2">
                                    <input type="text" name="class_code" placeholder="Masukkan Kode"
                                        class="w-full px-3 py-2 rounded-lg border border-blue-200 outline-none text-sm uppercase tracking-widest">
                                    <button type="submit"
                                        class="bg-[#12A0D7] text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-600 transition">
                                        Gabung
                                    </button>
                                </div>
                                @error('class_code')
                                    <p class="text-edu-red text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </form>
                        @endif
                    </div>

                    @if ($user->role === 'parent')
                        <div class="bg-gray-50 p-4 rounded-2xl">
                            <p class="text-sm text-gray-500 font-semibold mb-1">Nama Anak</p>
                            <p class="font-bold text-darkblue text-lg">{{ $user->child_name }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-2xl">
                            <p class="text-sm text-gray-500 font-semibold mb-1">Kelas / Usia</p>
                            <p class="font-bold text-darkblue text-lg">{{ $user->class_age }}</p>
                        </div>
                    @endif

                </div>

            </div>
        </div>
        <div class="flex items-center gap-5 mt-10">
            <a href="{{ route('beranda') }}"
                class="bg-yellow text-darkblue font-bold px-6 py-2 rounded-full shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all no-underline gap-3">
                Kembali ke Beranda
            </a>
            @if ($user->role === 'admin')
                <a href="{{ route('profile.students') }}"
                    class="bg-yellow text-darkblue font-bold px-6 py-2 rounded-full shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all no-underline gap-3">
                    Lihat Daftar Murid
                </a>
            @endif
        </div>

    </div>
@endsection
