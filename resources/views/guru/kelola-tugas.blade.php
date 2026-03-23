@extends('layouts.guru')
@section('content')
<div class="animate-slide-up">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-[40px] font-bold text-darkblue tracking-wide leading-tight">
                Kelola <span class="text-blue">Tugas</span>
            </h1>
            <p class="text-gray-500 text-lg">Buat dan pantau tugas harian untuk siswa-siswamu.</p>
        </div>
        <button onclick="document.getElementById('modalBuatTugas').classList.remove('hidden')"
            class="bg-blue text-white px-6 py-3 rounded-full font-bold hover:bg-blue/80 transition-colors shadow-md flex items-center gap-2 shrink-0">
            <span class="text-xl leading-none">+</span> Buat Tugas Baru
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3 font-bold animate-slide-up" onclick="this.remove()">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 flex flex-col gap-1 animate-slide-up" onclick="this.remove()">
            @foreach($errors->all() as $error)
                <div class="flex items-center gap-2 font-bold"><span>⚠️</span> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- daftar tugas -->
    <div class="flex flex-col gap-4">
        @forelse($tugas as $t)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 hover:-translate-y-0.5 transition-transform">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl {{ $t->subject->color ?? 'bg-gray-100' }} shrink-0">
                        {{ $t->subject->icon ?? '📘' }}
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h3 class="font-bold text-darkblue text-xl">{{ $t->title }}</h3>
                            @if($t->status === 'active')
                                <span class="bg-green-100 text-green-600 text-xs font-bold px-3 py-1 rounded-full">Aktif</span>
                            @elseif($t->status === 'closed')
                                <span class="bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 rounded-full">Ditutup</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ $t->subject->name }} · Kelas {{ $t->classroom_name }} ·
                            <span class="font-semibold {{ $t->due_date->isPast() ? 'text-red-400' : 'text-gray-600' }}">
                                Deadline: {{ $t->due_date->format('d M Y') }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="text-center bg-blue/10 px-5 py-2 rounded-2xl">
                        <p class="text-xs text-gray-400 font-bold">Selesai</p>
                        <p class="font-bold text-blue text-lg">{{ $t->jumlahSelesai() }}/{{ $t->submissions_count }}</p>
                    </div>
                    <a href="{{ route('guru.tugas.detail', $t->id) }}" class="bg-blue text-white px-5 py-2.5 rounded-full font-bold text-sm hover:bg-blue/80 transition-colors no-underline">
                        Detail
                    </a>
                    @if($t->status === 'active')
                    <form action="{{ route('guru.tugas.tutup', $t->id) }}" method="POST" onsubmit="return confirm('Tutup tugas ini?');">
                        @csrf
                        <button type="submit" class="bg-gray-100 text-gray-500 px-5 py-2.5 rounded-full font-bold text-sm hover:bg-red-100 hover:text-red-500 transition-colors border-none cursor-pointer">
                            Tutup
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($t->description)
            <p class="text-gray-500 text-sm mt-4 pl-[4.75rem]">{{ $t->description }}</p>
            @endif
        </div>
        @empty
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-16 flex flex-col items-center text-center">
            <span class="text-5xl mb-4">📋</span>
            <h3 class="font-bold text-darkblue text-xl mb-2">Belum Ada Tugas</h3>
            <p class="text-gray-400 mb-6">Mulai buat tugas harian pertamamu!</p>
            <button onclick="document.getElementById('modalBuatTugas').classList.remove('hidden')"
                class="bg-blue text-white px-8 py-3 rounded-full font-bold hover:bg-blue/80 transition-colors">
                + Buat Tugas Baru
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- buat tugas -->
<div id="modalBuatTugas" class="fixed inset-0 z-100 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm cursor-pointer" onclick="document.getElementById('modalBuatTugas').classList.add('hidden')"></div>
    <div class="bg-white rounded-[30px] p-8 w-full max-w-lg relative z-10 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-darkblue mb-6">📋 Buat Tugas Baru</h2>
        <form action="{{ route('guru.tugas.buat') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Judul Tugas</label>
                <input type="text" name="title" required placeholder="Cth: Latihan Soal Perkalian Bab 3"
                    class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
            </div>
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" placeholder="Instruksi tambahan untuk siswa..."
                    class="w-full px-5 py-4 rounded-3xl border-2 border-gray-200 focus:border-blue outline-none transition-colors resize-none"></textarea>
            </div>
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Mata Pelajaran</label>
                <select name="subject_id" required class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors bg-white cursor-pointer">
                    <option value="" disabled selected>-- Pilih Mapel --</option>
                    @foreach($mapelDiajar as $m)
                        <option value="{{ $m->id }}">{{ $m->icon }} {{ $m->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Kelas Tujuan</label>
                <select name="classroom_name" required class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors bg-white cursor-pointer">
                    <option value="" disabled selected>-- Pilih Kelas --</option>
                    @foreach($kelasDiajar as $k)
                        <option value="{{ $k->name }}">Kelas {{ $k->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Batas Waktu</label>
                <input type="date" name="due_date" required min="{{ date('Y-m-d') }}"
                    class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-blue outline-none transition-colors">
            </div>
            <button type="submit" class="w-full bg-blue text-white font-bold py-4 rounded-full mt-2 hover:bg-blue/80 transition-all shadow-md text-lg">
                Kirim Tugas ke Siswa 🚀
            </button>
        </form>
    </div>
</div>
@endsection