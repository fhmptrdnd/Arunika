@extends('layouts.guru')
@section('content')
<div class="animate-slide-up">
    
    <h1 class="text-[40px] font-bold text-darkblue mb-2 tracking-wide">
        Siswa <span class="text-blue">Kelas</span>
    </h1>    
    <p class="text-gray-500 text-lg mb-10">Pantau perkembangan belajar seluruh siswa di kelasmu.</p>
    
    <!-- card ratarata -->
    @php
        $avgXP      = $siswa->avg('xp');
        $avgStreak  = $siswa->avg('streak');
        $avgScore   = $siswa->avg('avg_score');
        $avgSelesai = $siswa->avg('total_tugas_selesai');
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 text-center">
            <p class="text-3xl font-bold text-orange">{{ round($avgXP ?? 0) }}</p>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Rata-rata XP</p>
        </div>
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 text-center">
            <p class="text-3xl font-bold text-red-500">{{ round($avgStreak ?? 0) }}<span class="text-lg">hr</span></p>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Rata-rata Streak</p>
        </div>
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 text-center">
            <p class="text-3xl font-bold text-teal">{{ round($avgScore ?? 0) }}</p>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Rata-rata Skor</p>
        </div>
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 text-center">
            <p class="text-3xl font-bold text-[#12A0D7]">{{ round($avgSelesai ?? 0) }}</p>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Tugas Selesai (avg)</p>
        </div>
    </div>

    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#F8FAFC] border-b border-gray-100 text-gray-400 text-sm uppercase tracking-wider">
                    <th class="p-6 font-bold">Siswa</th>
                    <th class="p-6 font-bold">Kelas</th>
                    <th class="p-6 font-bold">Streak</th>
                    <th class="p-6 font-bold">XP</th>
                    <th class="p-6 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($siswa as $s)
                <tr class="hover:bg-blue/5 transition-colors">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue/10 text-blue rounded-2xl flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr($s->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-darkblue">{{ $s->name }}</p>
                                <p class="text-xs text-gray-400">{{ $s->username }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <span class="bg-blue/10 text-blue px-3 py-1.5 rounded-xl text-sm font-bold">{{ $s->kelas }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-orange font-bold">🔥 {{ $s->streak ?? 0 }} hari</span>
                    </td>
                    <td class="p-6">
                        <span class="bg-[#FFF4E5] text-orange px-3 py-1 rounded-lg font-bold text-sm">⚡ {{ $s->xp ?? 0 }} XP</span>
                    </td>
                    <td class="p-6 text-center">
                        <a href="{{ route('guru.siswa.profil', $s->id) }}" class="text-blue font-bold hover:underline text-sm">Lihat Profil</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">
                        <span class="text-4xl block mb-3">📭</span>
                        Belum ada siswa di kelasmu.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection