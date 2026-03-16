@extends('layouts.admin')

@section('content')
<div class="animate-slide-up max-w-4xl">

    <h1 class="text-[40px] font-bold text-darkblue mb-10 tracking-wide">
        Profil <span class="text-[#12A0D7]">Admin</span>
    </h1>

    <div class="bg-white rounded-[30px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-10 flex flex-col md:flex-row gap-10 items-center md:items-start mb-8">

        <div class="w-50 h-50 flex items-center justify-center mb-6">
            <img src="{{ asset('images/Admin.png') }}" alt="Admin">
        </div>

        <div class="w-full">
            <h2 class="text-3xl font-bold text-darkblue mb-2">{{ auth()->user()->name ?? 'Administrator' }}</h2>
            <p class="text-gray-500 bg-gray-100 inline-block px-4 py-1 rounded-full text-sm font-semibold mb-6 uppercase tracking-widest">Admin Sekolah</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full bg-[#F8FAFC] p-6 rounded-[20px] border border-gray-100">
                <div>
                    <p class="text-sm text-gray-400 font-bold mb-1">Email</p>
                    <p class="text-lg font-bold text-gray-700">{{ auth()->user()->email ?? 'admin@arunika.com' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-bold mb-1">Nama Sekolah</p>
                    <p class="text-lg font-bold text-gray-700">{{ auth()->user()->school_name ?? 'Sekolah Arunika' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="flex justify-end mt-10 border-t border-gray-200 pt-8">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-8 py-4 rounded-full font-bold transition-all shadow-sm border border-red-100 text-lg flex items-center gap-3 cursor-pointer">
                Keluar dari Aplikasi
            </button>
        </form>
    </div> --}}

</div>
@endsection
