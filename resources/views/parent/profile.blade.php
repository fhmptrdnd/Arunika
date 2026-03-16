@extends('layouts.parent')

@section('content')
<div class="max-w-5xl animate-slide-up">

    <div class="flex justify-between items-center mb-10">
        <h1 class="text-2xl text-gray-600 tracking-wide">
            Halo, <span class="font-bold text-darkblue">{{ auth()->user()->name ?? 'Orang Tua' }}!</span>
        </h1>
        <div class="flex gap-4">
            <div class="bg-[#FEF5D3] text-orange font-bold px-6 py-2.5 rounded-full text-sm shadow-sm flex items-center gap-2">
                🔥 7 Hari
            </div>
            <div class="bg-[#12A0D7] text-white font-bold px-6 py-2.5 rounded-full text-sm shadow-sm flex items-center gap-2">
                ⚡ 450 xp
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.03)] p-10 flex flex-col lg:flex-row gap-12 mb-10">

        <div class="flex flex-col items-center justify-center lg:border-r border-gray-100 lg:pr-12 shrink-0">
            <div class="w-40 h-40 bg-[#FBD740] rounded-[30px] border-[6px] border-[#FEF5D3] flex items-center justify-center shadow-inner mb-6">
                <img src="{{ asset('images/avatar-smiley.png') }}" alt="Avatar" class="w-24 h-24 object-contain">
            </div>
            <span class="bg-[#FEF5D3] text-orange font-bold tracking-widest text-xs px-5 py-2 rounded-full mb-3 uppercase">
                Orang Tua
            </span>
            <h2 class="text-3xl font-bold text-darkblue mb-1">{{ auth()->user()->name }}</h2>
            <p class="text-gray-400 font-semibold">{{ auth()->user()->email }}</p>
        </div>

        <div class="flex-1 w-full">
            <h3 class="text-xl font-bold text-gray-400 mb-4 border-b border-gray-100 pb-4">Informasi Akun</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#F8FAFC] p-6 rounded-3xl">
                    <p class="text-sm text-gray-400 font-bold mb-1">Nama Sekolah</p>
                    <p class="text-lg font-bold text-darkblue">{{ auth()->user()->school_name ?? 'Mandiri' }}</p>
                </div>
                <div class="bg-[#F4FBFE] p-6 rounded-3xl flex justify-between items-center">
                    <div>
                        <p class="text-sm text-[#12A0D7] font-bold mb-1">Kode Sekolah</p>
                        <p class="text-xl font-bold text-[#12A0D7] tracking-widest">{{ auth()->user()->school_code ?? '-' }}</p>
                    </div>
                    <img src="{{ asset('images/icon-copy.png') }}" class="w-6 h-6 opacity-50 cursor-pointer hover:opacity-100">
                </div>
                </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 text-2xl">👩</div>
            <h2 class="text-2xl font-bold text-darkblue">
                <span class="text-[#12A0D7]">{{ auth()->user()->children->count() }}</span> Anak Terdaftar
            </h2>
        </div>
        <button class="bg-[#12A0D7] text-white px-6 py-3 rounded-full font-bold hover:bg-blue-600 transition-colors shadow-md flex items-center gap-2">
            <span class="text-xl leading-none">+</span> Tambah Anak
        </button>
    </div>

    <div class="flex flex-col gap-4">
        @foreach(auth()->user()->children as $index => $child)
            <div class="bg-white border-gray-200 rounded-[30px] border-2 p-6 flex items-center gap-6 cursor-pointer hover:-translate-y-1 transition-transform">

                <div class="w-20 h-20 bg-white rounded-3xl border border-gray-100 flex items-center justify-center shadow-sm shrink-0">
                    <img src="{{ asset('images/avatar-animal-'.($index+1).'.png') }}" alt="Avatar Anak" class="w-12 h-12 object-contain">
                </div>

                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-darkblue mb-1">{{ $child->name }}</h3>
                    <p class="text-gray-500 font-semibold mb-4">{{ $child->kelas }} · {{ $child->school_name ?? 'Belajar Mandiri' }}</p>

                    <div class="flex flex-wrap gap-3">
                        <span class="bg-white border border-gray-100 text-orange px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-1 shadow-sm">
                            ⚡ {{ $child->xp }} XP
                        </span>
                        <span class="bg-white border border-gray-100 text-red-500 px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-1 shadow-sm">
                            🔥 {{ $child->streak }} Hari
                        </span>
                        <span class="bg-white border border-gray-100 text-[#05A660] px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-1 shadow-sm">
                            Aktif hari ini
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
