@extends('layouts.placement')

@section('title', 'Tes Penempatan — Arunika')

@section('content')
<div class="min-h-screen flex flex-col relative z-10">

    <!-- MAIN CARD -->
    <div class="flex-1 flex items-start justify-center px-4 py-6">
        <div class="bg-white rounded-[28px] w-full max-w-3xl shadow-xl overflow-hidden">

            <!-- progress header -->
            <div class="px-6 pt-5 pb-3">
                <div class="flex items-center justify-between mb-2">
                    <span id="soal-label"
                          class="text-xs font-bold text-darkblue/40 uppercase tracking-wider">
                        Soal 1
                    </span>
                    <span id="soal-counter"
                          class="text-xs font-bold text-darkblue/40">
                        dari {{ count($questionsFormatted) }}
                    </span>
                </div>
                <!-- progress bar gradient -->
                <div class="w-full h-2 bg-[#E2E8F0] rounded-full overflow-hidden">
                    <div id="progress-bar"
                         class="h-full rounded-full transition-all duration-500"
                         style="width:0%; background:linear-gradient(90deg,#22c55e 0%,#FBE055 100%)">
                    </div>
                </div>
            </div>

            <!-- subject + timer -->
            <div class="px-6 py-3 flex items-center justify-between">
                <div id="subject-chip"
                     class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold border-2 transition-all">
                </div>
                <div id="timer-box"
                     class="flex items-center gap-1.5 border-2 border-[#01A7E1]/30 rounded-full px-3 py-1.5 text-sm font-bold text-darkblue transition-all">
                    <span>⏱️</span>
                    <span id="timer-display">15:00</span>
                </div>
            </div>

            <!-- questions -->
            <div class="px-6 pb-4">
                <p id="question-text"
                   class="text-darkblue font-bold text-lg md:text-xl leading-snug text-center min-h-[3em] flex items-center justify-center">
                </p>
            </div>

            <!-- choices -->
            <div id="options-container" class="px-6 pb-5 flex flex-col gap-3"></div>

            <!-- nav btn -->
            <div class="px-6 pb-6 flex justify-end gap-3">
                <button id="btn-next"
                        onclick="nextQuestion()"
                        class="hidden items-center gap-2 bg-[#01A7E1] text-white font-bold px-7 py-3 rounded-full
                               shadow-[0_4px_0_#0190c4]
                               hover:-translate-y-0.5 hover:shadow-[0_6px_0_#0190c4]
                               active:translate-y-0.5 active:shadow-none
                               transition-all text-sm">
                    Berikutnya →
                </button>
                <button id="btn-submit"
                        onclick="submitTest()"
                        class="hidden items-center gap-2 bg-[#FBE055] text-darkblue font-extrabold px-7 py-3 rounded-full
                               shadow-[0_4px_0_#d9b824]
                               hover:-translate-y-0.5 hover:shadow-[0_6px_0_#d9b824]
                               active:translate-y-0.5 active:shadow-none
                               transition-all text-sm">
                    Lihat Hasil 🏆
                </button>
            </div>

        </div>
    </div>

</div>

<form id="submit-form" action="{{ route('placement.submit') }}" method="POST" class="hidden">
    @csrf
    <div id="hidden-answers"></div>
</form>

<!-- LOADING OVERLAY -->
<div id="loading-overlay"
     class="fixed inset-0 bg-darkblue/85 backdrop-blur-sm z-[200] hidden items-center justify-center flex-col gap-5">
    <div class="w-14 h-14 border-4 border-white/20 border-t-[#FBE055] rounded-full animate-spin"></div>
    <p class="text-white font-bold text-lg">Menghitung hasil tesmu...</p>
    <p class="text-white/50 text-sm font-semibold">Sebentar ya! 🌟</p>
</div>

<script>


const QUESTIONS = @json($questionsFormatted);

// meta mapel
const SUBJECT_META = {
    agama:            { label:'Pend. Agama & Budi Pekerti', icon:'🛐', bg:'#fff7ed', border:'#fed7aa', text:'#9a3412' },
    pancasila:        { label:'Pendidikan Pancasila',        icon:'⚖️', bg:'#f0f9ff', border:'#bae6fd', text:'#0c4a6e' },
    bahasa_indonesia: { label:'Bahasa Indonesia',            icon:'📖', bg:'#e8f4fd', border:'#7cc4ed', text:'#005b99' },
    matematika:       { label:'Matematika',                  icon:'🔢', bg:'#fff0f6', border:'#ffb3d1', text:'#c0006e' },
    pjok:             { label:'PJOK',                        icon:'🏃‍♂️', bg:'#f0fdf4', border:'#bbf7d0', text:'#15803d' },
    seni_budaya:      { label:'Seni dan Budaya',             icon:'🎨', bg:'#fff0e0', border:'#ffb380', text:'#a03000' },
    bahasa_inggris:   { label:'Bahasa Inggris',              icon:'🗣️', bg:'#f3e8ff', border:'#c084fc', text:'#6d00a0' },
    muatan_lokal:     { label:'Muatan Lokal',                icon:'🌎', bg:'#fefce8', border:'#fde68a', text:'#854d0e' },
};

const TOTAL       = QUESTIONS.length;
const answers     = {};
let   currentIdx  = 0;
let   timerSecs   = 15 * 60;
let   timerIntvl;

// RENDER SOAL
function renderQuestion(idx) {
    const q    = QUESTIONS[idx];
    const meta = SUBJECT_META[q.subject] || {
        label: q.subject, icon: '📚',
        bg: '#f1f5f9', border: '#cbd5e1', text: '#475569'
    };
    const pct = Math.round((idx / TOTAL) * 100);

    // progress
    document.getElementById('soal-label').textContent   = `Soal ${idx + 1}`;
    document.getElementById('soal-counter').textContent = `dari ${TOTAL}`;
    document.getElementById('progress-bar').style.width = pct + '%';

    const chip = document.getElementById('subject-chip');
    chip.style.background   = meta.bg;
    chip.style.borderColor  = meta.border;
    chip.style.color        = meta.text;
    chip.innerHTML = `<span style="font-size:14px">${meta.icon}</span>${meta.label}`;

    // qusetions
    const qText = document.getElementById('question-text');
    qText.style.opacity   = '0';
    qText.style.transform = 'translateX(16px)';
    setTimeout(() => {
        qText.textContent     = q.text;
        qText.style.transition = 'all 0.22s ease';
        qText.style.opacity   = '1';
        qText.style.transform = 'translateX(0)';
    }, 55);

    const container = document.getElementById('options-container');
    container.innerHTML = '';
    const letters = ['a','b','c','d'];
    const labels  = ['A','B','C','D'];

    letters.forEach((letter, i) => {
        const isSelected = answers[q.id] === letter;
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.dataset.letter = letter;
        btn.onclick = () => selectOption(q.id, letter);

        btn.className = [
            'w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl border-2 text-left',
            'font-semibold text-darkblue text-sm md:text-base cursor-pointer',
            'transition-all duration-150',
            isSelected
                ? 'border-[#01A7E1] bg-[#e8f7fd]'
                : 'border-[#E2E8F0] bg-white hover:border-[#01A7E1] hover:bg-[#f0faff]',
        ].join(' ');
        btn.style.animationDelay = `${i * 45}ms`;
        btn.style.animation = 'optIn 0.22s ease both';

        const lbox = document.createElement('span');
        lbox.className = [
            'w-8 h-8 rounded-lg flex items-center justify-center',
            'text-xs font-extrabold flex-shrink-0 border-2 transition-all',
            isSelected
                ? 'bg-[#01A7E1] border-[#01A7E1] text-white'
                : 'bg-[#F1F5F9] border-[#E2E8F0] text-[#94a3b8]',
        ].join(' ');
        lbox.textContent = labels[i];

        const txt = document.createElement('span');
        txt.textContent = q.options[letter];

        btn.appendChild(lbox);
        btn.appendChild(txt);
        container.appendChild(btn);
    });

    // nav btn
    const btnNext   = document.getElementById('btn-next');
    const btnSubmit = document.getElementById('btn-submit');

    if (answers[q.id]) {
        if (idx === TOTAL - 1) {
            btnNext.classList.add('hidden');     btnNext.classList.remove('inline-flex');
            btnSubmit.classList.remove('hidden');btnSubmit.classList.add('inline-flex');
        } else {
            btnSubmit.classList.add('hidden');   btnSubmit.classList.remove('inline-flex');
            btnNext.classList.remove('hidden');  btnNext.classList.add('inline-flex');
        }
    } else {
        btnNext.classList.add('hidden');   btnNext.classList.remove('inline-flex');
        btnSubmit.classList.add('hidden'); btnSubmit.classList.remove('inline-flex');
    }
}

// pilih opsi
function selectOption(qId, letter) {
    answers[qId] = letter;
    renderQuestion(currentIdx);
}

// next soal
function nextQuestion() {
    if (currentIdx < TOTAL - 1) {
        currentIdx++;
        renderQuestion(currentIdx);
    }
}

function submitTest() {
    const unanswered = QUESTIONS.filter(q => !answers[q.id]);
    if (unanswered.length > 0) {
        if (!confirm(`Masih ada ${unanswered.length} soal yang belum dijawab.\nLanjutkan submit tetap?`)) {
            return;
        }
    }

    const overlay = document.getElementById('loading-overlay');
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');

    const hiddenDiv = document.getElementById('hidden-answers');
    hiddenDiv.innerHTML = '';
    Object.entries(answers).forEach(([qId, ans]) => {
        const inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = `answers[${qId}]`;
        inp.value = ans;
        hiddenDiv.appendChild(inp);
    });

    document.getElementById('submit-form').submit();
}

// timer
function startTimer() {
    timerIntvl = setInterval(() => {
        timerSecs--;
        const m  = Math.floor(timerSecs / 60).toString().padStart(2, '0');
        const s  = (timerSecs % 60).toString().padStart(2, '0');
        document.getElementById('timer-display').textContent = `${m}:${s}`;

        const box = document.getElementById('timer-box');
        if (timerSecs <= 60) {
            box.className = box.className
                .replace('border-[#01A7E1]/30 text-darkblue', '')
                + ' border-red-400 text-red-500';
        } else if (timerSecs <= 180) {
            box.className = box.className
                .replace('border-[#01A7E1]/30 text-darkblue', '')
                + ' border-orange-400 text-orange-500';
        }

        if (timerSecs <= 0) {
            clearInterval(timerIntvl);
            submitTest();
        }
    }, 1000);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes optIn {
        from { opacity:0; transform:translateY(7px); }
        to   { opacity:1; transform:translateY(0); }
    }
`;
document.head.appendChild(style);

renderQuestion(0);
startTimer();
</script>
@endsection