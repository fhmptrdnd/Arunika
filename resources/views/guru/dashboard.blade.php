@extends('layouts.guru')
@section('content')
<div class="animate-slide-up">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform">
            <div class="w-14 h-14 bg-blue/10 rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-door-open-fill text-teal text-3xl"></i>
            </div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-2">Kelas Diajar</p>
            <h3 class="text-[40px] leading-none font-bold text-darkblue">{{ $kelasDiajar->count() }}</h3>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-people-fill text-[#12A0D7] text-3xl"></i>
            </div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-2">Total Siswa</p>
            <h3 class="text-[40px] leading-none font-bold text-darkblue">{{ $totalSiswa }}</h3>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform">
            <div class="w-14 h-14 bg-orange/10 rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-journal-check text-orange text-3xl"></i>
            </div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-2">Tugas Hari Ini</p>
            <h3 class="text-[40px] leading-none font-bold text-darkblue">{{ $tugasHariIni }}</h3>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform {{ $siswaInaktif > 0 ? 'border-red-200 bg-red-50' : '' }}">
            <div class="w-14 h-14 {{ $siswaInaktif > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-exclamation-triangle-fill {{ $siswaInaktif > 0 ? 'text-red-500' : 'text-gray-400' }} text-3xl"></i>
            </div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-2">Siswa Inaktif</p>
            <h3 class="text-[40px] leading-none font-bold {{ $siswaInaktif > 0 ? 'text-red-500' : 'text-darkblue' }}">{{ $siswaInaktif }}</h3>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-darkblue mb-6">Kelas Saya</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kelasDiajar as $kelas)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 hover:-translate-y-1 transition-transform">
            <div class="w-14 h-14 bg-teal/10 text-teal font-bold text-2xl rounded-2xl flex items-center justify-center mb-4">
                {{ $kelas->name }}
            </div>
            <h3 class="font-bold text-darkblue text-xl mb-1">Kelas {{ $kelas->name }}</h3>
            <p class="text-sm text-gray-500 mb-4">Wali: {{ $kelas->homeroomTeacher->name ?? 'Belum ada' }}</p>
            <a href="{{ route('guru.siswa') }}" class="text-blue font-bold text-sm hover:underline no-underline">Lihat Siswa →</a>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-400">
            <span class="text-4xl block mb-3">🏫</span>
            Kamu belum ditugaskan ke kelas manapun.
        </div>
        @endforelse
    </div>

</div>
@endsection