@extends('layouts.admin')

@section('content')
<div class="animate-slide-up">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-[40px] font-bold text-darkblue tracking-wide leading-tight">
                Data <span class="text-[#05A660]">Guru</span>
            </h1>
            <p class="text-gray-500 text-lg">Kelola seluruh data <br> tenaga pendidik di sekolahmu.</p>
        </div>

        <div class="flex items-center shrink-0">
            <form action="{{ route('admin.guru') }}" method="GET" class="relative mr-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..."
                       class="pl-12 pr-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#05A660] outline-none w-full md:w-64 transition-all text-sm font-semibold text-gray-600 bg-white">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg text-gray-400">🔍</span>
            </form>
            <button onclick="document.getElementById('modalGuru').classList.remove('hidden')" class="bg-[#05A660] text-white px-6 py-3 rounded-full font-bold hover:bg-green-600 transition-colors shadow-md flex items-center gap-2">
                <span class="text-xl leading-none">+</span> <span class="hidden md:inline">Tambah Guru</span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-[30px] border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-gray-100 text-gray-400 text-sm tracking-wider uppercase">
                        <th class="p-6 font-bold rounded-tl-[30px]">Profil Pendidik</th>
                        <th class="p-6 font-bold">Email</th>
                        <th class="p-6 font-bold">Status Aktif</th>
                        <th class="p-6 font-bold text-center rounded-tr-[30px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($guru as $g)
                    <tr class="hover:bg-green-50/50 transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#E6F8F3] rounded-2xl flex items-center justify-center font-bold text-[#05A660] border-2 border-white shadow-sm shrink-0">
                                    {{ strtoupper(substr($g->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-darkblue">{{ $g->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 font-semibold text-gray-600">{{ $g->email }}</td>
                        <td class="p-6">
                            @php
                                // Cek apakah guru online dalam 5 menit terakhir
                                $isOnline = $g->last_seen_at && $g->last_seen_at >= now()->subMinutes(5);
                            @endphp

                            @if($isOnline)
                                <div class="flex items-center gap-2 text-[#05A660] text-sm font-bold">
                                    <div class="w-2.5 h-2.5 bg-[#05A660] rounded-full animate-pulse"></div>
                                    Online
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-gray-400 text-sm font-bold">
                                    <div class="w-2.5 h-2.5 bg-gray-300 rounded-full"></div>
                                    Offline
                                </div>
                            @endif
                        </td>
                        <td class="p-6 text-center">
                            <button class="text-gray-400 hover:text-[#05A660] font-bold px-3 py-1 transition-colors border-none bg-transparent cursor-pointer">Edit</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-gray-400 bg-gray-50/50">
                            <span class="text-4xl block mb-3">👩‍🏫</span>
                            Belum ada data guru. Silakan tambahkan!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="fixed top-10 right-10 bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-lg z-200 flex items-center gap-3 font-bold animate-slide-up" onclick="this.remove()">
        <span>✅</span> {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="fixed top-10 right-10 bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-lg z-200 flex flex-col gap-1 animate-slide-up" onclick="this.remove()">
        @foreach($errors->all() as $error)
            <div class="flex items-center gap-2 font-bold"><span>⚠️</span> {{ $error }}</div>
        @endforeach
    </div>
@endif

<div id="modalGuru" class="fixed inset-0 z-100 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm cursor-pointer" onclick="document.getElementById('modalGuru').classList.add('hidden')"></div>
    <div class="bg-white rounded-[30px] p-8 w-full max-w-md relative z-10 shadow-2xl">
        <h2 class="text-2xl font-bold text-[#05A660] mb-6">Daftarkan Guru Baru</h2>
        <form action="{{ route('admin.guru.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Cth: Ibu Dian Sastro" class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#05A660] outline-none">
            </div>
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Email Sekolah</label>
                <input type="email" name="email" required placeholder="Cth: dian@arunika.com" class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#05A660] outline-none">
            </div>
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Password Sementara</label>
                <input type="text" name="password" required value="guruarunika123" class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#05A660] outline-none">
                <p class="text-xs text-gray-400 ml-2 mt-1">Default: guruarunika123</p>
            </div>
            <button type="submit" class="w-full bg-[#05A660] text-white font-bold py-3 rounded-full mt-2 hover:bg-green-600 transition-all">Daftarkan Guru</button>
        </form>
    </div>
</div>
@endsection
