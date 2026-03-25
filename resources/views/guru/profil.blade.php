@extends('layouts.guru')
@section('content')
<div class="animate-slide-up max-w-4xl">
    <h1 class="text-[40px] font-bold text-darkblue mb-10 tracking-wide">
        Profil <span class="text-blue">Guru</span>
    </h1>

    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm p-10 flex flex-col md:flex-row gap-10 items-center md:items-start">
        <div class="w-40 h-40 bg-blue/10 rounded-[30px] flex items-center justify-center text-6xl font-bold text-blue border-4 border-blue/20 shadow-inner">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div class="w-full">
            <h2 class="text-3xl font-bold text-darkblue mb-2">{{ auth()->user()->name }}</h2>
            <span class="bg-blue/10 text-blue font-bold px-4 py-1 rounded-full text-sm uppercase tracking-widest">Guru</span>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 bg-[#F8FAFC] p-6 rounded-[20px] border border-gray-100">
                <div>
                    <p class="text-sm text-gray-400 font-bold mb-1">Email</p>
                    <p class="text-lg font-bold text-gray-700">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-bold mb-1">Nama Sekolah</p>
                    <p class="text-lg font-bold text-gray-700">{{ auth()->user()->school_name ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection