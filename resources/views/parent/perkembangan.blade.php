@extends('layouts.parent')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-darkblue mb-2">Perkembangan Anak</h1>
    <p class="text-gray-500">Pantau profil kognitif dan ketuntasan materi.</p>
</div>

@if($children->count() > 0)
<div class="flex gap-3 mb-8 overflow-x-auto no-scrollbar pb-2">
    @foreach($children as $child)
        <a href="{{ route('parent.perkembangan', ['child_id' => $child->id]) }}"
           class="px-6 py-2.5 rounded-full font-bold whitespace-nowrap transition-all no-underline border
           {{ $selectedChild && $selectedChild->id == $child->id ? 'bg-[#12A0D7] text-white border-[#12A0D7] shadow-md' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
           {{ $child->name }}
        </a>
    @endforeach
</div>
@endif

@if($selectedChild)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col items-center">
        <h3 class="text-xl font-bold text-darkblue mb-6 w-full text-left">Profil Kognitif Keseharian</h3>
        <div class="w-full max-w-[300px] relative">
            <canvas id="kognitifChart"></canvas>
        </div>
        <div class="mt-6 w-full grid grid-cols-2 gap-3">
            @foreach($kognitif as $dimensi => $data)
            <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-xl">
                <span class="text-xl">{{ $data['icon'] }}</span>
                <div>
                    <p class="text-xs font-bold text-gray-500">{{ $dimensi }}</p>
                    <p class="text-sm font-bold" style="color: {{ $data['color'] }}">{{ $data['score'] }}/100</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col gap-6">
        <div class="bg-gradient-to-r from-[#12A0D7] to-blue-500 rounded-3xl p-8 shadow-md text-white">
            <p class="text-blue-100 text-sm font-bold uppercase tracking-wider mb-1">Mata Pelajaran Terkuat (Placement Test)</p>
            <h2 class="text-3xl font-black mb-2">{{ $placementScore ?? 'Belum Ujian' }}</h2>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex-1">
            <h3 class="text-xl font-bold text-darkblue mb-5">Ketuntasan Level</h3>
            @if($semuaSkor->count() > 0)
                <div class="space-y-5">
                    @foreach($semuaSkor as $skor)
                    @php
                        // Asumsi total level per mapel adalah 10
                        $persenTamat = min(100, round(($skor->level_selesai / 10) * 100));
                        $namaMapel = ucwords(str_replace('-', ' ', $skor->mapel));
                    @endphp
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-darkblue">{{ $namaMapel }}</span>
                            <span class="text-sm font-bold text-[#F7891F]">{{ $skor->level_selesai }} / 10 Level</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-yellow h-2.5 rounded-full" style="width: {{ $persenTamat }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 italic text-center mt-10">Belum ada mapel yang dimainkan.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const kognitifData = @json($kognitif);
    const labels  = Object.keys(kognitifData);
    const scores  = Object.values(kognitifData).map(item => item.score);
    const colors  = Object.values(kognitifData).map(item => item.color);
    const emojis  = Object.values(kognitifData).map(item => item.icon);

    new Chart(document.getElementById('kognitifChart'), {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                data: scores,
                fill: true,
                backgroundColor: 'rgba(18, 160, 215, 0.2)', // Biru Arunika transparan
                borderColor: '#12A0D7',
                borderWidth: 2,
                pointBackgroundColor: colors,
                pointBorderColor: '#fff',
                pointRadius: 5,
            }]
        },
        options: {
            scales: { r: { min: 0, max: 100, ticks: { display: false } } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endif
@endsection
