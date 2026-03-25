@extends('layouts.parent')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-darkblue mb-2">Riwayat & Capaian</h1>
    <p class="text-gray-500">Melihat jejak petualangan belajar anak Anda.</p>
</div>

@if($children->count() > 0)
<div class="flex gap-3 mb-8 overflow-x-auto no-scrollbar pb-2">
    @foreach($children as $child)
        <a href="{{ route('parent.riwayat', ['child_id' => $child->id]) }}"
           class="px-6 py-2.5 rounded-full font-bold whitespace-nowrap transition-all no-underline border
           {{ $selectedChild && $selectedChild->id == $child->id ? 'bg-[#12A0D7] text-white border-[#12A0D7] shadow-md' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
           {{ $child->name }}
        </a>
    @endforeach
</div>
@endif

@if($selectedChild)
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 relative">
        <h3 class="text-xl font-bold text-darkblue mb-6 border-b pb-4">Aktivitas Terakhir: {{ $selectedChild->name }}</h3>

        @if($riwayat->count() > 0)
            <div class="space-y-6">
                @foreach($riwayat as $item)
                <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                    <div class="w-12 h-12 bg-[#EAF7FC] rounded-full flex items-center justify-center shrink-0 text-xl">
                        🎮
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-darkblue text-lg">Menyelesaikan Level di {{ ucwords(str_replace('-', ' ', $item->mapel)) }}</h4>
                        <p class="text-sm text-gray-500 mb-1">Mendapatkan <span class="font-bold text-green-500">+{{ $item->xp }} XP</span> dengan {{ $item->true_answers }} jawaban benar.</p>
                        <p class="text-xs text-gray-400"><i class="bi bi-clock"></i> {{ $item->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 text-gray-400">
                <i class="bi bi-inbox text-5xl mb-3 block opacity-50"></i>
                <p>Belum ada aktivitas petualangan yang tercatat.</p>
            </div>
        @endif
    </div>
@endif
@endsection
