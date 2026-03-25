@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 relative z-20">

    <!-- MAPEL UTAMA -->
    <div class="flex items-center gap-3 mb-5">
        <span class="text-2xl">📚</span>
        <h2 class="text-2xl font-bold text-darkblue">Mata Pelajaran Utama</h2>
    </div>

    @if($placementScore)
    @php
        $mapelUtama = $placementScore->subject;
        $warna = [
            'Matematika'           => ['bar' => '#FBDF54', 'bg' => 'bg-[#FEF5D3]', 'border' => 'border-[#d4ac1e]'],
            'Bahasa Indonesia'     => ['bar' => '#12A0D7', 'bg' => 'bg-[#EAF7FC]', 'border' => 'border-[#12A0D7]'],
            'Bahasa Inggris'       => ['bar' => '#6670FF', 'bg' => 'bg-[#EEEEFF]', 'border' => 'border-[#6670FF]'],
            'Sains Alam'           => ['bar' => '#05A660', 'bg' => 'bg-[#E6F8F3]', 'border' => 'border-[#05A660]'],
            'Seni Budaya'          => ['bar' => '#F04F52', 'bg' => 'bg-[#FEF0F0]', 'border' => 'border-[#F04F52]'],
            'Pendidikan Jasmani'   => ['bar' => '#12BAAA', 'bg' => 'bg-[#E6FAF8]', 'border' => 'border-[#12BAAA]'],
            'Pendidikan Pancasila' => ['bar' => '#FF6B9D', 'bg' => 'bg-[#FFF0F5]', 'border' => 'border-[#FF6B9D]'],
            'Muatan Lokal'         => ['bar' => '#F7891F', 'bg' => 'bg-[#FFF4E5]', 'border' => 'border-[#F7891F]'],
            'Pendidikan Agama'     => ['bar' => '#05A660', 'bg' => 'bg-[#E6F8F3]', 'border' => 'border-[#05A660]'],
        ];
        $w = $warna[$mapelUtama->name] ?? ['bar' => '#12BAAA', 'bg' => 'bg-teal/10', 'border' => 'border-teal'];
    @endphp

    <div class="{{ $w['bg'] }} border-2 {{ $w['border'] }} rounded-3xl p-8 mb-10 animate-slide-up">
        <div class="flex items-center gap-5 mb-6">
            <div class="w-16 h-16 bg-white/80 rounded-2xl flex items-center justify-center text-4xl shadow-sm">
                {{ $mapelUtama->icon ?? '📘' }}
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Mata Pelajaran Terkuat</p>
                <h3 class="text-3xl font-bold text-darkblue">{{ $mapelUtama->name }}</h3>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-2xl font-bold text-darkblue w-20">{{ $placementScore->score }}%</span>
            <div class="flex-1 bg-white/60 rounded-full h-4 overflow-hidden">
                <div class="h-4 rounded-full transition-all duration-1000"
                     style="width: {{ $placementScore->score }}%; background-color: {{ $w['bar'] }};">
                </div>
            </div>
            <span class="text-sm text-gray-500 font-semibold">skor rata-rata</span>
        </div>
    </div>
    @endif

    <!-- MAPEL LAINNYA -->
    @if($semuaSkor->count() > 0)
    <div class="flex items-center gap-3 mb-5">
        <span class="text-2xl">📚</span>
        <h2 class="text-2xl font-bold text-darkblue">Mata Pelajaran Lainnya</h2>
    </div>

    @php
        $warnaMapel = [
            'Matematika'           => ['bar' => '#FBDF54', 'bg' => 'bg-white'],
            'Bahasa Indonesia'     => ['bar' => '#12A0D7', 'bg' => 'bg-white'],
            'Bahasa Inggris'       => ['bar' => '#6670FF', 'bg' => 'bg-white'],
            'Sains Alam'           => ['bar' => '#05A660', 'bg' => 'bg-white'],
            'Seni Budaya'          => ['bar' => '#8B4513', 'bg' => 'bg-white'],
            'Pendidikan Jasmani'   => ['bar' => '#12BAAA', 'bg' => 'bg-white'],
            'Pendidikan Pancasila' => ['bar' => '#FF6B9D', 'bg' => 'bg-white'],
            'Muatan Lokal'         => ['bar' => '#F7891F', 'bg' => 'bg-white'],
            'Pendidikan Agama'     => ['bar' => '#05A660', 'bg' => 'bg-white'],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
        @foreach($semuaSkor as $ss)
        @php $wm = $warnaMapel[$ss->subject->name] ?? ['bar' => '#12BAAA', 'bg' => 'bg-white']; @endphp
        <div class="{{ $wm['bg'] }} rounded-3xl border border-gray-100 shadow-sm p-6 hover:-translate-y-0.5 transition-transform animate-slide-up">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 {{ $ss->subject->color ?? 'bg-gray-100' }} rounded-2xl flex items-center justify-center text-2xl">
                    {{ $ss->subject->icon ?? '📘' }}
                </div>
                <h4 class="font-bold text-darkblue text-lg">{{ $ss->subject->name }}</h4>
            </div>
            <div class="flex items-center gap-3">
                <span class="font-bold text-lg w-14" style="color: {{ $wm['bar'] }}">{{ $ss->score }}%</span>
                <div class="flex-1 bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div class="h-2.5 rounded-full transition-all duration-1000"
                         style="width: {{ $ss->score }}%; background-color: {{ $wm['bar'] }};"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- PERKEMBANGAN KOGNITIF -->
    <div class="flex items-center gap-3 mb-5">
        <span class="text-2xl">🧠</span>
        <h2 class="text-2xl font-bold text-darkblue">Perkembangan Kognitif</h2>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-8 animate-slide-up">
        <div class="flex flex-col lg:flex-row items-center gap-10">

            <div class="w-full lg:w-1/2 flex justify-center">
                <div class="relative w-72 h-72">
                    <canvas id="kognitifChart"></canvas>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="flex flex-col gap-4">
                    @foreach($kognitif as $dimensi => $data)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full shrink-0" style="background-color: {{ $data['color'] }}"></div>
                            <span class="font-semibold text-darkblue text-lg">{{ $dimensi }}</span>
                        </div>
                        <span class="font-bold text-darkblue text-xl">{{ $data['score'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- CATATAN DARI GURU -->
    @if($catatanGuru)
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 animate-slide-up">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 bg-yellow rounded-2xl flex items-center justify-center text-2xl">
                👩‍🏫
            </div>
            <div>
                <h3 class="font-bold text-darkblue text-xl">Catatan dari Guru Kelas</h3>
                <p class="text-sm text-gray-400">
                    {{ $waliKelas->name }} ·
                    Wali Kelas {{ $siswa->kelas }} ·
                    Ditulis {{ $catatanGuru->updated_at->translatedFormat('d M Y') }}
                </p>
            </div>
        </div>
        <p class="text-gray-700 leading-relaxed text-lg">{{ $catatanGuru->content }}</p>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labels  = @json(array_keys($kognitif));
    const scores  = @json(array_column(array_values($kognitif), 'score'));
    const colors  = @json(array_column(array_values($kognitif), 'color'));

    new Chart(document.getElementById('kognitifChart'), {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                data: scores,
                backgroundColor: 'rgba(251, 223, 84, 0.25)',
                borderColor: '#FBDF54',
                borderWidth: 2.5,
                pointBackgroundColor: colors,
                pointBorderColor: '#fff',
                pointBorderWidth: 2.5,
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 25,
                        display: false,
                    },
                    grid: { color: 'rgba(0,0,0,0.07)' },
                    angleLines: { color: 'rgba(0,0,0,0.07)' },
                    pointLabels: {
                        font: { size: 20 }, 
                        color: 'transparent',
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.raw} / 100`
                    }
                }
            }
        }
    });

    Chart.register({
        id: 'emojiLabels',
        afterDraw(chart) {
            const ctx = chart.ctx;
            const scale = chart.scales.r;
            const emojis = @json(array_column(array_values(\App\Helpers\CognitiveMapper::MAPPING), 'icon'));

            ctx.save();
            ctx.font = '22px serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            scale._pointLabelItems.forEach((item, i) => {
                ctx.fillText(emojis[i] ?? '', item.x, item.y);
            });
            ctx.restore();
        }
    });
</script>
@endsection