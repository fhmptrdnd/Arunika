@extends('layouts.guru')
@section('content')
<div class="animate-slide-up">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('guru.tugas') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center border border-gray-200 text-gray-400 hover:text-blue hover:border-blue transition-colors shadow-sm no-underline text-2xl pb-1">&larr;</a>
        <div>
            <h1 class="text-3xl font-bold text-darkblue">{{ $tugas->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $tugas->subject->name }} · Kelas {{ $tugas->classroom_name }} ·
                Deadline: <span class="font-bold">{{ $tugas->due_date->format('d M Y') }}</span>
            </p>
        </div>
    </div>

    <!-- progress bar -->
    @php
        $total = $tugas->submissions->count();
        $selesai = $tugas->submissions->where('status', 'submitted')->count();
        $persen = $total > 0 ? round(($selesai / $total) * 100) : 0;
    @endphp
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-6">
        <div class="flex justify-between items-center mb-3">
            <h2 class="font-bold text-darkblue text-xl">Progress Pengerjaan</h2>
            <span class="text-2xl font-bold text-blue">{{ $persen }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
            <div class="bg-blue h-4 rounded-full transition-all duration-700" style="width: {{ $persen }}%"></div>
        </div>
        <p class="text-sm text-gray-400 mt-2">{{ $selesai }} dari {{ $total }} siswa telah menyelesaikan tugas</p>
    </div>

    <!-- tabel siswa -->
    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#F8FAFC] border-b border-gray-100 text-gray-400 text-sm uppercase tracking-wider">
                    <th class="p-6 font-bold">Siswa</th>
                    <th class="p-6 font-bold">Status</th>
                    <th class="p-6 font-bold">Skor</th>
                    <th class="p-6 font-bold">Dikerjakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($tugas->submissions as $sub)
                <tr class="hover:bg-blue/5 transition-colors">
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue/10 text-blue rounded-xl flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr($sub->student->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-darkblue">{{ $sub->student->name }}</p>
                                <p class="text-xs text-gray-400">{{ $sub->student->username }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        @if($sub->status === 'submitted')
                            <span class="bg-green-100 text-green-600 text-xs font-bold px-3 py-1.5 rounded-full">✅ Selesai</span>
                        @elseif($sub->status === 'late')
                            <span class="bg-orange/10 text-orange text-xs font-bold px-3 py-1.5 rounded-full">⏰ Terlambat</span>
                        @else
                            <span class="bg-gray-100 text-gray-400 text-xs font-bold px-3 py-1.5 rounded-full">⏳ Belum</span>
                        @endif
                    </td>
                    <td class="p-6 font-bold text-darkblue">
                        {{ $sub->score !== null ? $sub->score . ' / 100' : '—' }}
                    </td>
                    <td class="p-6 text-gray-500 text-sm">
                        {{ $sub->submitted_at ? $sub->submitted_at->format('d M Y, H:i') : '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection