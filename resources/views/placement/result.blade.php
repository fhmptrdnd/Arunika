@extends('layouts.placement')

@section('title', 'Hasil Tes — Arunika')

@section('content')

@php
    use App\Models\PlacementQuestion;
    $subjectKeys = array_keys($scores);
    $top1Key     = $subjectKeys[0] ?? null;
    $top2Key     = $subjectKeys[1] ?? null;
    $top1Score   = $top1Key ? ($scores[$top1Key] ?? 0) : 0;
    $top2Score   = $top2Key ? ($scores[$top2Key] ?? 0) : 0;
@endphp

<div class="min-h-screen flex flex-col relative z-10">

    <!-- MAIN CARD -->
    <div class="flex-1 flex items-start justify-center px-4 py-6">
        <div class="bg-white rounded-[28px] w-full max-w-3xl shadow-xl overflow-hidden animate-slide-up">

            <div class="px-6 pt-8 pb-2 text-center">

                <div class="flex items-center justify-center gap-2 mb-3">
                    <span class="text-4xl" style="opacity:0;animation:starPop .4s cubic-bezier(.34,1.56,.64,1) .3s both">⭐</span>
                    <span class="text-4xl" style="opacity:0;animation:starPop .4s cubic-bezier(.34,1.56,.64,1) .5s both">⭐</span>
                    <span class="text-4xl" style="opacity:0;animation:starPop .4s cubic-bezier(.34,1.56,.64,1) .7s both">⭐</span>
                </div>

                <h2 class="text-darkblue font-extrabold text-3xl md:text-4xl mb-1"
                    style="opacity:0;animation:slideUp .4s ease .2s both">
                    Luar Biasa!!!
                </h2>
                <p class="text-darkblue/50 text-sm font-semibold mb-7"
                   style="opacity:0;animation:slideUp .4s ease .3s both">
                    Kamu telah menyelesaikan tes penempatan
                </p>

                <!-- TOP 2 MAPEL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8"
                     style="opacity:0;animation:slideUp .4s ease .4s both">

                    {{-- TOP 1 — Kuning --}}
                    @if($top1Key)
                    <div class="bg-yellow rounded-[22px] p-5 text-left border-2 border-darkyellow/60
                                shadow-[0_4px_0_#d9b824]">
                        <p class="text-darkyellow/50 text-xs font-bold mb-3 uppercase tracking-wide">
                            Mata Pelajaran Utama
                        </p>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-4xl leading-none">
                                {{ PlacementQuestion::subjectIcon($top1Key) }}
                            </span>
                            <span class="text-darkyellow font-extrabold text-lg leading-tight">
                                {{ PlacementQuestion::subjectLabel($top1Key) }}
                            </span>
                        </div>
                        <p class="text-darkyellow/80 text-sm font-bold mb-2">
                            Skor {{ $top1Score }}%
                        </p>
                        <div class="h-1.5 bg-darkyellow/10 rounded-full overflow-hidden">
                            <div id="bar-top1"
                                 class="h-full bg-darkyellow/80 rounded-full transition-all duration-1000 ease-out"
                                 style="width:0%"></div>
                        </div>
                    </div>
                    @endif

                    {{-- TOP 2 — Border biru --}}
                    @if($top2Key)
                    <div class="bg-white rounded-[22px] p-5 text-left border-2 border-blue/60">
                        <p class="text-darkblue/50 text-xs font-bold mb-3 uppercase tracking-wide">
                            Mata Pelajaran Kedua
                        </p>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-4xl leading-none">
                                {{ PlacementQuestion::subjectIcon($top2Key) }}
                            </span>
                            <span class="text-darkblue font-extrabold text-lg leading-tight">
                                {{ PlacementQuestion::subjectLabel($top2Key) }}
                            </span>
                        </div>
                        <p class="text-darkblue/60 text-sm font-bold mb-2">
                            Skor {{ $top2Score }}%
                        </p>
                        <div class="h-1.5 bg-blue rounded-full overflow-hidden">
                            <div id="bar-top2"
                                 class="h-full bg-[#01A7E1] rounded-full transition-all duration-1000 ease-out"
                                 style="width:0%"></div>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- MAPEL LAINNYA -->
                <div class="text-left mb-7"
                     style="opacity:0;animation:slideUp .4s ease .55s both">
                    <h3 class="text-darkblue font-bold text-base mb-4">Semua Mata Pelajaran</h3>

                    <div class="bg-[#F8FAFC] rounded-2xl border border-darkblue/10 overflow-hidden">
                        @foreach($scores as $subj => $score)
                        <div class="flex items-center gap-3 px-4 py-3.5
                                    {{ !$loop->last ? 'border-b border-darkblue/10' : '' }}">
                            <div class="w-9 h-9 bg-white rounded-xl border border-darkblue/10 flex items-center justify-center text-lg flex-shrink-0 shadow-sm">
                                {{ PlacementQuestion::subjectIcon($subj) }}
                            </div>
                            <span class="text-darkblue font-semibold text-sm w-40 flex-shrink-0 leading-tight">
                                {{ PlacementQuestion::subjectLabel($subj) }}
                            </span>
                            <div class="flex-1 h-2.5 bg-darkblue/10 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000 ease-out"
                                     style="width:0%; background:linear-gradient(90deg,#01A7E1 0%,#FBE055 100%)"
                                     data-target="{{ $score }}"
                                     data-bar-all></div>
                            </div>
                            <span class="text-darkblue/60 font-bold text-sm w-10 text-right flex-shrink-0">
                                {{ $score }}%
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- CTA -->
                <div style="opacity:0;animation:slideUp .4s ease .7s both" class="pb-2">
                    <a href="{{ route('beranda') }}"
                       class="inline-flex items-center justify-center gap-2 w-full
                              bg-[#FBE055] text-darkyellow font-extrabold text-base px-8 py-4 rounded-full
                              shadow-[0_5px_0_#d9b824]
                              hover:-translate-y-1 hover:shadow-[0_7px_0_#d9b824]
                              active:translate-y-1 active:shadow-[0_2px_0_#d9b824]
                              transition-all">
                        Mulai Petualangan Belajar! 🚀
                    </a>
                    <p class="text-darkblue/40 text-xs font-semibold mt-3 pb-4">
                        Kamu akan diarahkan ke Dashboard Arunika.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@keyframes starPop {
    from { opacity:0; transform:scale(0) rotate(-30deg); }
    to   { opacity:1; transform:scale(1) rotate(0); }
}
@keyframes slideUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>

<script>
window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        // Animasi bar top 1 & 2
        const b1 = document.getElementById('bar-top1');
        const b2 = document.getElementById('bar-top2');
        if (b1) b1.style.width = '{{ $top1Score }}%';
        if (b2) b2.style.width = '{{ $top2Score }}%';

        // Animasi semua bar mapel
        document.querySelectorAll('[data-bar-all]').forEach(el => {
            el.style.width = el.dataset.target + '%';
        });
    }, 500);
});
</script>
@endsection