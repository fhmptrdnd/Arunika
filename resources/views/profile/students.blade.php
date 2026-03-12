@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto flex flex-col min-h-[75vh] relative z-20 py-10 px-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 animate-slide-up">
        <a href="{{ route('profile') }}"
        class="bg-yellow text-darkblue font-bold px-6 py-2 rounded-full shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all no-underline gap-3">
            Kembali ke Profil
        </a>
        <h1 class="text-4xl font-bold text-darkblue dark:text-white m-0">Daftar Murid</h1>
    </div>

    <form action="{{ route('profile.students') }}" method="GET" class="mb-8 animate-pop-in delay-100">
        <div class="relative w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama murid di sini..."
                   class="w-full pl-8 pr-32 py-4 rounded-full border-2 border-white focus:border-blue outline-none transition-colors text-gray-700 shadow-md text-lg bg-white/80 backdrop-blur-sm">

            <button type="submit" class="absolute right-2 top-2 bottom-2 bg-yellow text-darkblue px-8 rounded-full font-bold hover:scale-105 transition-transform shadow-sm border-none cursor-pointer text-lg">
                Cari
            </button>
        </div>
    </form>

    <div class="bg-white rounded-[40px] shadow-2xl p-6 md:p-10 animate-pop-in delay-200">
        <div class="flex justify-between items-center mb-6 px-2 border-b-2 border-gray-100 pb-4">
            <h2 class="text-xl font-bold text-gray-500">Total: <span class="text-darkblue">{{ $students->count() }} Murid</span></h2>
            <span class="bg-blue-100 text-[#12A0D7] font-bold px-4 py-1 rounded-full text-sm">{{ auth()->user()->school_name ?? 'Nama Sekolah' }}</span>
        </div>

        <div class="max-h-[50vh] overflow-y-auto pr-2 custom-scrollbar flex flex-col gap-4">
            @forelse($students as $student)
                <div class="bg-blue-50 border-2 border-blue-100 rounded-24 p-5 flex flex-col md:flex-row items-start md:items-center justify-between hover:shadow-md transition-shadow hover:-translate-y-1">

                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center font-bold text-2xl text-[#12A0D7] shadow-sm border-2 border-blue-200 shrink-0">
                            {{ substr($student->child_name, 0, 1) }}
                        </div>

                        <div>
                            <h3 class="font-bold text-darkblue text-2xl mb-1">{{ $student->child_name }}</h3>
                            <p class="text-md text-gray-500 m-0">{{ $student->class_age }}</p>
                            <p class="text-sm text-gray-400 mt-1">Wali: <span class="font-semibold text-gray-600">{{ $student->name }}</span></p>
                        </div>
                    </div>

                    <a href="{{ route('profile.student.detail', $student->id) }}"class="mt-4 md:mt-0 bg-white text-[#12A0D7] font-bold px-6 py-2 rounded-full border-2 border-blue-200 hover:bg-[#12A0D7] hover:text-white transition-colors cursor-pointer w-full md:w-auto">
                        Lihat Progres
                    </a>
                </div>
            @empty
                <div class="text-center py-16 flex flex-col items-center justify-center">
                    <span class="text-7xl mb-4 opacity-50">🔍</span>
                    <h3 class="text-2xl font-bold text-gray-400">Tidak ada murid yang ditemukan</h3>
                    <p class="text-gray-400 mt-2 max-w-sm">Coba gunakan nama lain, atau tunggu sampai orang tua murid mendaftar menggunakan Kode Sekolahmu.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection
