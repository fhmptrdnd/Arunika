@extends('layouts.guru')
@section('content')
<div class="animate-slide-up">

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('guru.siswa') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center border border-gray-200 text-gray-400 hover:text-blue hover:border-blue transition-colors shadow-sm no-underline text-2xl pb-1">&larr;</a>
        <div>
            <h1 class="text-3xl font-bold text-darkblue">Profil <span class="text-blue">{{ $siswa->name }}</span></h1>
            <p class="text-sm text-gray-500 mt-1">Kelas {{ $siswa->kelas }} · {{ $siswa->school_name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- stat card -->
        <div class="flex flex-col gap-4">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <div class="w-20 h-20 bg-blue/10 text-blue rounded-3xl flex items-center justify-center font-bold text-4xl mx-auto mb-4">
                    {{ strtoupper(substr($siswa->name, 0, 1)) }}
                </div>
                <h2 class="font-bold text-darkblue text-xl text-center mb-1">{{ $siswa->name }}</h2>
                <p class="text-gray-400 text-sm text-center mb-4">{{ $siswa->username }}</p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-[#FFF4E5] p-3 rounded-2xl text-center">
                        <p class="text-orange font-bold text-xl">⚡ {{ $siswa->xp ?? 0 }}</p>
                        <p class="text-xs text-gray-400 font-semibold">Total XP</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-2xl text-center">
                        <p class="text-red-500 font-bold text-xl">🔥 {{ $siswa->streak ?? 0 }}</p>
                        <p class="text-xs text-gray-400 font-semibold">Hari Streak</p>
                    </div>
                </div>
            </div>

            <!-- riwayat tugas -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-darkblue mb-4">Riwayat Tugas</h3>
                <div class="flex flex-col gap-2">
                    @forelse($submissions as $sub)
                    <div class="flex items-center justify-between p-3 bg-[#F8FAFC] rounded-2xl">
                        <div>
                            <p class="font-bold text-darkblue text-sm">{{ $sub->assignment->title }}</p>
                            <p class="text-xs text-gray-400">{{ $sub->assignment->subject->name ?? '' }}</p>
                        </div>
                        @if($sub->status === 'submitted')
                            <span class="text-green-500 font-bold text-sm">{{ $sub->score ?? '✓' }}</span>
                        @else
                            <span class="text-gray-400 font-bold text-sm">—</span>
                        @endif
                    </div>
                    @empty
                    <p class="text-gray-400 text-sm text-center py-4">Belum ada riwayat tugas.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- spider cart kognitif -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <h3 class="font-bold text-darkblue text-xl mb-1">Perkembangan Kognitif</h3>
                <p class="text-gray-400 text-sm mb-6">5 dimensi kemampuan berdasarkan skor mata pelajaran.</p>

                <div class="flex flex-col items-center gap-8">
                    <div class="w-64 h-64 shrink-0">
                        <canvas id="spiderChart"></canvas>
                    </div>
                    <div class="flex flex-col gap-3 w-full">
                        @foreach($kognitif as $dimensi => $data)
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $data['color'] }}"></div>
                            <span class="font-semibold text-gray-700 flex-1">{{ $dimensi }}</span>
                            <div class="w-32 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="h-2 rounded-full" style="width:{{ $data['score'] }}%; background-color: {{ $data['color'] }};"></div>
                            </div>
                            <span class="font-bold text-darkblue w-8 text-right">{{ $data['score'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- catatan guur -->
                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h4 class="font-bold text-darkblue mb-4">
                        Catatan untuk {{ $siswa->name }}
                        @if($isWaliKelas) <span class="text-xs text-teal font-semibold bg-teal/10 px-2 py-1 rounded-full ml-2">Siswa Kelas</span> @endif
                    </h4>

                    @if($catatanGuru)
                    <div class="bg-[#F8FAFC] rounded-2xl p-5 mb-4">
                        <p class="text-gray-700 leading-relaxed">{{ $catatanGuru->content }}</p>
                        <p class="text-xs text-gray-400 mt-2">Terakhir diperbarui: {{ $catatanGuru->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif

                    @if($isWaliKelas)
                    <form action="{{ route('guru.siswa.catatan', $siswa->id) }}" method="POST">
                        @csrf
                        <textarea name="content" rows="4"
                            placeholder="Tulis catatan perkembangan {{ $siswa->name }} di sini..."
                            class="w-full px-5 py-4 rounded-3xl border-2 border-gray-200 focus:border-teal outline-none resize-none font-quicksand text-gray-700"
                            >{{ $catatanGuru->content ?? '' }}</textarea>
                        @if($errors->any())
                            <p class="text-red text-sm mt-1 font-bold">{{ $errors->first() }}</p>
                        @endif
                        <button type="submit" class="mt-3 bg-teal text-white px-6 py-2.5 rounded-full font-bold hover:bg-teal/80 transition-colors border-none cursor-pointer">
                            💾 Simpan Catatan
                        </button>
                    </form>
                    @else
                    <p class="text-gray-400 text-sm italic">Hanya wali kelas yang bisa menulis catatan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const kognitifData = @json($kognitif);
    const labels = Object.keys(kognitifData);
    const scores = Object.values(kognitifData).map(d => d.score);
    const colors = Object.values(kognitifData).map(d => d.color);

    new Chart(document.getElementById('spiderChart'), {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                data: scores,
                backgroundColor: 'rgba(18, 186, 170, 0.12)',
                borderColor: '#12BAAA',
                borderWidth: 2.5,
                pointBackgroundColor: colors,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    beginAtZero: true, max: 100,
                    ticks: { stepSize: 25, color: '#9ca3af', font: { size: 10, family: 'Quicksand', weight: '600' }, backdropColor: 'transparent' },
                    grid: { color: 'rgba(0,0,0,0.06)' },
                    angleLines: { color: 'rgba(0,0,0,0.06)' },
                    pointLabels: { color: '#0D2552', font: { size: 11, family: 'Quicksand', weight: '700' } }
                }
            },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection