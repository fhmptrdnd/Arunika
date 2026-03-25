@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 relative z-20">

    <div class="flex items-center gap-3 mb-5">
        <span class="text-2xl">📚</span>
        <h2 class="text-2xl font-bold text-darkblue dark:text-white">Mata Pelajaran Terkuatmu</h2>
    </div>

    @if($placementScore && $placementScore->subject)
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
                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Mata Pelajaran Terkuat (Placement Test)</p>
                <h3 class="text-3xl font-bold text-darkblue">{{ $mapelUtama->name }}</h3>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-2xl font-bold text-darkblue w-20">{{ round($placementScore->score) }}%</span>
            <div class="flex-1 bg-white/60 rounded-full h-4 overflow-hidden shadow-inner">
                <div class="h-4 rounded-full transition-all duration-1000"
                     style="width: {{ round($placementScore->score) }}%; background-color: {{ $w['bar'] }};">
                </div>
            </div>
            <span class="text-sm text-gray-500 font-semibold w-24 text-right">Skor Awal</span>
        </div>
    </div>
    @else
    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-8 mb-10 text-center text-gray-400">
        Belum ada hasil Placement Test.
    </div>
    @endif

    @if($semuaSkor && $semuaSkor->count() > 0)
    <div class="flex items-center gap-3 mb-5">
        <span class="text-2xl">📈</span>
        <h2 class="text-2xl font-bold text-darkblue dark:text-white">Progres Belajar</h2>
    </div>

    @php
        $warnaMapel = [
            'matematika'           => ['name' => 'Matematika', 'icon' => '🧮', 'bar' => '#FBDF54', 'bg' => 'bg-white', 'text' => 'text-[#d4ac1e]'],
            'bahasa-indonesia'     => ['name' => 'Bahasa Indonesia', 'icon' => '📖', 'bar' => '#12A0D7', 'bg' => 'bg-white', 'text' => 'text-[#12A0D7]'],
            'bahasa-inggris'       => ['name' => 'Bahasa Inggris', 'icon' => '🗽', 'bar' => '#6670FF', 'bg' => 'bg-white', 'text' => 'text-[#6670FF]'],
            'sains-alam'           => ['name' => 'Sains Alam', 'icon' => '🔬', 'bar' => '#05A660', 'bg' => 'bg-white', 'text' => 'text-[#05A660]'],
            'seni-budaya'          => ['name' => 'Seni Budaya', 'icon' => '🎨', 'bar' => '#F04F52', 'bg' => 'bg-white', 'text' => 'text-[#F04F52]'],
            'pendidikan-jasmani'   => ['name' => 'Pendidikan Jasmani', 'icon' => '⚽', 'bar' => '#12BAAA', 'bg' => 'bg-white', 'text' => 'text-[#12BAAA]'],
            'pendidikan-pancasila' => ['name' => 'Pendidikan Pancasila', 'icon' => '🦅', 'bar' => '#FF6B9D', 'bg' => 'bg-white', 'text' => 'text-[#FF6B9D]'],
            'muatan-lokal'         => ['name' => 'Muatan Lokal', 'icon' => '🏠', 'bar' => '#F7891F', 'bg' => 'bg-white', 'text' => 'text-[#F7891F]'],
            'pendidikan-agama'     => ['name' => 'Pendidikan Agama', 'icon' => '🕌', 'bar' => '#05A660', 'bg' => 'bg-white', 'text' => 'text-[#05A660]'],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
        @foreach($semuaSkor as $ss)
       @php
            $slug = strtolower(str_replace(' ', '-', trim($ss->mapel)));
            $wm = $warnaMapel[$slug] ?? ['name' => ucwords(str_replace('-', ' ', $slug)), 'icon' => '📘', 'bar' => '#12BAAA', 'bg' => 'bg-white', 'text' => 'text-gray-500'];

            // PERHITUNGAN PERSENTASE (TAMAT LEVEL)
            $totalLevel = 10;

            // Hitung: (Level Selesai / Total Level) * 100
            $persentase = round(($ss->level_selesai / $totalLevel) * 100);

            // Pastikan tidak tembus lebih dari 100%
            $persentase = min(100, $persentase);
        @endphp
        <div class="{{ $wm['bg'] }} rounded-3xl border border-gray-100 shadow-sm p-6 hover:-translate-y-0.5 transition-transform animate-slide-up">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-2xl border border-gray-100">
                    {{ $wm['icon'] }}
                </div>
                <h4 class="font-bold text-darkblue text-lg">{{ $wm['name'] }}</h4>
            </div>
            <div class="flex items-center gap-3">
                <span class="font-bold text-lg w-14" style="color: {{ $wm['bar'] }}">{{ $persentase }}%</span>
                <div class="flex-1 bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div class="h-2.5 rounded-full transition-all duration-1000"
                         style="width: {{ $persentase }}%; background-color: {{ $wm['bar'] }};"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="flex items-center gap-3 mb-5 mt-4">
        <span class="text-2xl">🧠</span>
        <h2 class="text-2xl font-bold text-darkblue dark:text-white">Profil Kognitif</h2>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mb-8 animate-slide-up">
        <div class="flex flex-col lg:flex-row items-center gap-10">

            <div class="w-full lg:w-1/2 flex justify-center">
                <div class="relative w-80 h-80">
                    <canvas id="kognitifChart"></canvas>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="flex flex-col gap-4">
                    @foreach($kognitif as $dimensi => $data)
                    <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl bg-gray-100 w-10 h-10 flex items-center justify-center rounded-full">{{ $data['icon'] ?? '🎯' }}</span>
                            <span class="font-bold text-darkblue text-lg">{{ $dimensi }}</span>
                        </div>
                        <span class="font-bold text-xl" style="color: {{ $data['color'] }}">{{ $data['score'] }}<span class="text-sm text-gray-400">/100</span></span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if($catatanGuru)
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 animate-slide-up mb-8">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 bg-[#FFF4E5] rounded-2xl flex items-center justify-center text-2xl">
                👩‍🏫
            </div>
            <div>
                <h3 class="font-bold text-darkblue text-xl">Catatan dari Guru Kelas</h3>
                <p class="text-sm text-gray-400">
                    {{ $waliKelas->name }} · Wali Kelas {{ $siswa->kelas }} · Ditulis {{ $catatanGuru->updated_at->translatedFormat('d M Y') }}
                </p>
            </div>
        </div>
        <p class="text-gray-700 leading-relaxed text-lg bg-gray-50 p-5 rounded-2xl border border-gray-100">"{{ $catatanGuru->content }}"</p>
    </div>
    @endif

    <div class="flex justify-center mt-6 mb-10">
        <a href="{{ route('beranda') }}"
            class="bg-yellow text-darkblue font-bold px-8 py-3 rounded-full shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all no-underline inline-flex items-center gap-3">
            Kembali ke Beranda
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Ambil data langsung dari array kognitif yang dikirim Controller
    const kognitifData = @json($kognitif);
    const labels  = Object.keys(kognitifData);
    const scores  = Object.values(kognitifData).map(item => item.score);
    const colors  = Object.values(kognitifData).map(item => item.color);
    const emojis  = Object.values(kognitifData).map(item => item.icon || '🎯');

    new Chart(document.getElementById('kognitifChart'), {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                fill: true,
                data: scores,
                backgroundColor: 'rgba(251, 223, 84, 0.4)', // Transparan kuning
                borderColor: '#FBDF54',
                // borderWidth: 2.5,
                pointBackgroundColor: colors,
                pointBorderColor: '#fff',
                // pointBorderWidth: 2.5,
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
                        display: false, // Sembunyikan angka di garis tengah
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    angleLines: { color: 'rgba(0,0,0,0.05)' },
                    pointLabels: {
                        font: { size: 16 },
                        color: 'transparent', // Sembunyikan label asli untuk diganti emoji
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` Skor: ${ctx.raw} / 100`
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

            ctx.save();
            ctx.font = '24px serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            scale._pointLabelItems.forEach((item, i) => {
                ctx.fillText(emojis[i], item.x, item.y);
            });
            ctx.restore();
        }
    });
</script>
@endsection
