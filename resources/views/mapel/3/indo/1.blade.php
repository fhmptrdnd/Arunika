<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Indonesia Kelas 3 - Level 1: Buku Cerita Ajaib</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <!-- MediaPipe Hand Tracking -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/assessment.js') }}"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&family=Kalam:wght@400;700&display=swap");

        body {
            font-family: "Nunito", sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            touch-action: none;
            user-select: none;
        }

        .font-story {
            font-family: "Kalam", cursive;
        }

        /* Animasi Latar & Elemen */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes drift-slow {
            from {
                transform: translateX(-10%);
            }

            to {
                transform: translateX(110vw);
            }
        }

        .animate-drift-slow {
            animation: drift-slow 45s linear infinite;
        }

        @keyframes bounce-slight {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-bounce-slight {
            animation: bounce-slight 2s ease-in-out infinite;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-10px);
            }

            40%,
            80% {
                transform: translateX(10px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }

        @keyframes pop-in {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            70% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-pop-in {
            animation: pop-in 0.4s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes glow-gold {

            0%,
            100% {
                box-shadow:
                    0 0 20px 5px rgba(250, 204, 21, 0.6),
                    0 8px 0 #b45309;
            }

            50% {
                box-shadow:
                    0 0 40px 15px rgba(250, 204, 21, 1),
                    0 8px 0 #b45309;
                transform: scale(1.05);
            }
        }

        .animate-glow-gold {
            animation: glow-gold 1s ease-in-out;
            border-color: #fde047 !important;
            background-color: #fef08a !important;
        }

        /* Animasi Balik Halaman (Page Turn) */
        @keyframes turn-page {
            0% {
                transform: perspective(1000px) rotateY(0deg);
                opacity: 1;
            }

            50% {
                transform: perspective(1000px) rotateY(-90deg);
                opacity: 0.5;
                filter: brightness(0.8);
            }

            100% {
                transform: perspective(1000px) rotateY(0deg);
                opacity: 1;
            }
        }

        .animate-turn-page {
            animation: turn-page 0.8s ease-in-out forwards;
        }

        /* Animasi Daun Melayang (Magical Leaves) */
        @keyframes falling-leaf {
            0% {
                transform: translateY(-10vh) rotate(0deg) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 0.8;
            }

            90% {
                opacity: 0.8;
            }

            100% {
                transform: translateY(110vh) rotate(360deg) translateX(50px);
                opacity: 0;
            }
        }

        .leaf {
            position: absolute;
            font-size: 2rem;
            will-change: transform;
            z-index: 5;
            opacity: 0;
            animation: falling-leaf linear infinite;
        }

        /* Kursor Kamera Tangan */
        #hand-cursor {
            position: absolute;
            width: 80px;
            height: 80px;
            pointer-events: none;
            z-index: 1000;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.1s linear;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .lucide {
            display: inline-block;
        }

        /* Gaya Buku Cerita */
        .storybook-shadow {
            box-shadow:
                -10px 10px 20px rgba(0, 0, 0, 0.1),
                inset 20px 0 30px -20px rgba(0, 0, 0, 0.1),
                inset -20px 0 30px -20px rgba(0, 0, 0, 0.1);
        }

        .book-spine {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 40px;
            transform: translateX(-50%);
            background: linear-gradient(to right,
                    transparent,
                    rgba(0, 0, 0, 0.1) 50%,
                    transparent);
            z-index: 0;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-amber-100 via-orange-100 to-rose-200 h-screen w-full relative overflow-hidden">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute" width="80" height="80">
            <circle class="progress-ring__circle" stroke="#f59e0b" stroke-width="6" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji"
            style="
          font-size: 3rem;
          filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
          transition: all 0.2s;
        ">
            ✨
        </div>
    </div>

    <!-- --- SCENERY BACKGROUND (MAGICAL FOREST) --- -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Ornamen Hutan Sihir -->
        <div
            class="absolute bottom-0 w-full h-[30vh] bg-emerald-500/30 rounded-t-[100%] scale-x-150 transform translate-y-12 backdrop-blur-sm">
        </div>
        <div
            class="absolute bottom-[-10%] w-[120%] left-[-10%] h-[35vh] bg-emerald-600/30 rounded-t-[100%] scale-x-110 backdrop-blur-sm">
        </div>

        <div class="absolute top-[15%] left-[5%] text-5xl opacity-40 animate-float">
            ✨
        </div>
        <div class="absolute top-[25%] right-[10%] text-6xl opacity-40 animate-float" style="animation-delay: 1s">
            ✨
        </div>
        <div class="absolute bottom-[20%] left-[10%] text-8xl drop-shadow-md opacity-60">
            🍄
        </div>
        <div class="absolute bottom-[15%] right-[15%] text-9xl drop-shadow-md opacity-60 scale-x-[-1]">
            🌲
        </div>

        <!-- Daun Melayang Animasi -->
        <div class="leaf" style="left: 10%; animation-duration: 8s; animation-delay: 0s">
            🍃
        </div>
        <div class="leaf" style="left: 30%; animation-duration: 12s; animation-delay: 2s">
            🍂
        </div>
        <div class="leaf" style="left: 50%; animation-duration: 9s; animation-delay: 4s">
            🍃
        </div>
        <div class="leaf" style="left: 70%; animation-duration: 11s; animation-delay: 1s">
            🍂
        </div>
        <div class="leaf" style="left: 85%; animation-duration: 10s; animation-delay: 3s">
            ✨
        </div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/70 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-amber-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                📖
            </div>
            <div>
                <h2 class="font-black text-xl text-amber-900 tracking-wide drop-shadow-sm">
                    Penjelajah Level 3
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-white/70 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-amber-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div class="w-48 h-5 bg-amber-900/20 rounded-full overflow-hidden shadow-inner border border-amber-200">
                    <div id="xp-bar-fill"
                        class="h-full bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-amber-300 mb-2 max-w-[240px]">
                    <p id="owl-message" class="font-bold text-amber-800 text-sm">
                        Ayo baca ceritanya bersama-sama!
                    </p>
                </div>
                <div class="text-6xl drop-shadow-[0_10px_10px_rgba(0,0,0,0.3)]">
                    🦉
                </div>
            </div>

            <div
                class="bg-slate-800 p-2 rounded-xl border-4 border-slate-600 shadow-xl flex flex-col items-center w-28 h-24 relative overflow-hidden">
                <div class="absolute top-1 left-1 flex items-center gap-1 z-10">
                    <div id="cam-indicator" class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                    <span id="cam-status"
                        class="text-[9px] text-white font-bold tracking-wider drop-shadow-md">LOAD</span>
                </div>
                <video id="input_video" class="w-full h-full object-cover rounded-lg mt-3 scale-x-[-1]" autoplay
                    playsinline></video>
            </div>
        </div>
    </div>

    <!-- --- MAIN GAME AREA (STORYBOOK) --- -->
    <div class="absolute inset-0 top-24 bottom-6 z-10 flex flex-col items-center justify-center pointer-events-none">
        <div class="text-center mb-2 shrink-0 pointer-events-auto">
            <h1
                class="text-2xl md:text-3xl font-black text-amber-900 bg-white/90 backdrop-blur-sm px-6 py-2 rounded-full border-4 border-white shadow-md inline-block">
                Baca dan Pahami Ceritanya!
            </h1>
        </div>

        <!-- BUKU CERITA (STORYBOOK) -->
        <div id="storybook-container"
            class="bg-[#fdfbf7] storybook-shadow p-14 md:p-10 rounded-2xl border-[12px] border-amber-800 w-[95%] max-w-5xl h-full max-h-[550px] flex flex-col pointer-events-auto relative mt-2 transform transition-transform duration-500">
            <!-- Tulang Punggung Buku (Spine) -->
            <div class="book-spine"></div>

            <!-- --- FASE 1: MEMBACA (READING) --- -->
            <div id="phase-reading" class="w-full h-full flex flex-col md:flex-row gap-6 relative z-10">
                <!-- Halaman Kiri (Teks Cerita) -->
                <div class="flex-1 flex flex-col p-4 md:pr-10 relative">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="font-black text-2xl text-amber-900 border-b-4 border-amber-300 pb-2 inline-block">
                            Waktu Membaca
                        </h2>
                        <!-- Timer -->
                        <div
                            class="bg-amber-100 px-4 py-2 rounded-full border-2 border-amber-300 shadow-inner flex items-center gap-2">
                            <i data-lucide="clock" class="text-amber-600 w-5 h-5"></i>
                            <span id="timer-display" class="font-black text-xl text-amber-700">35</span>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <!-- Tombol Speaker -->
                        <button onclick="readStoryAloud()"
                            class="bg-white hover:bg-amber-50 p-3 rounded-full border-2 border-gray-200 shadow-md transition-colors shrink-0 h-fit">
                            <i data-lucide="volume-2" class="text-amber-600 w-6 h-6"></i>
                        </button>
                        <!-- Teks Cerita -->
                        <p id="story-text" class="font-story text-2xl md:text-3xl text-gray-800 leading-relaxed">
                            Pagi ini Rina pergi ke taman bersama ibunya.<br /><br />
                            Di taman, Rina melihat banyak bunga yang indah.<br /><br />
                            Ia juga bermain ayunan dan berlari bersama temannya.
                        </p>
                    </div>
                </div>

                <!-- Garis Pemisah Buku (hanya di Desktop) -->
                <div class="hidden md:block w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>

                <!-- Halaman Kanan (Ilustrasi & Navigasi) -->
                <div class="flex-1 flex flex-col items-center justify-center p-4 md:pl-10 relative">
                    <!-- Ilustrasi Cerita -->
                    <div
                        class="w-full max-w-[300px] bg-sky-100 rounded-3xl border-4 border-white shadow-md p-6 flex flex-col items-center text-center relative overflow-hidden mb-8">
                        <div class="absolute inset-0 bg-green-400 opacity-20 rounded-3xl mt-20"></div>
                        <div class="text-[6rem] drop-shadow-xl mb-2 relative z-10 animate-bounce-slight">
                            🌳👧
                        </div>
                        <div class="text-4xl absolute bottom-4 left-4 z-10">🌼</div>
                        <div class="text-4xl absolute bottom-4 right-4 z-10">🛝</div>
                    </div>

                    <button onclick="skipReading()"
                        class="bg-green-500 hover:bg-green-400 text-white text-xl font-black py-4 px-10 rounded-full shadow-[0_6px_0_#166534] hover:shadow-[0_3px_0_#166534] hover:translate-y-1 transition-all flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-6 h-6"></i> Sudah Selesai
                    </button>
                </div>
            </div>

            <!-- --- FASE 2: PERTANYAAN (QUESTIONS) --- -->
            <div id="phase-questions" class="w-full h-full flex flex-col relative z-10 hidden">
                <div class="text-center mb-6 pt-4">
                    <h2 id="question-text"
                        class="font-black text-2xl md:text-4xl text-gray-800 tracking-wide px-4 leading-tight">
                        <!-- Pertanyaan dirender di sini -->
                    </h2>
                    <p class="text-amber-600 font-bold mt-2">
                        Arahkan tanganmu ke jawaban yang benar!
                    </p>
                </div>

                <!-- Opsi Jawaban -->
                <div id="options-container"
                    class="flex flex-col md:flex-row flex-wrap justify-center items-center gap-4 w-full flex-1">
                    <!-- Opsi dirender di sini -->
                </div>

                <!-- Indikator Progres Pertanyaan -->
                <div class="flex justify-center gap-4 mt-auto pt-4 pb-2" id="progress-dots">
                    <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                    <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                    <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- --- VICTORY OVERLAY --- -->
    <div id="victory-overlay"
        class="hidden fixed inset-0 z-[60] bg-sky-200/90 backdrop-blur-md flex-col items-center justify-center">
        <div id="victory-modal"
            class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl border-8 border-yellow-400 flex flex-col items-center max-w-xl w-[90%] text-center scale-0 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 text-9xl opacity-10 pointer-events-none">
                🎉
            </div>
            <div class="absolute -bottom-10 -left-10 text-9xl opacity-10 pointer-events-none">
                ✨
            </div>

            <div
                class="w-28 h-28 bg-gradient-to-tr from-yellow-300 to-yellow-500 rounded-full border-4 border-white flex items-center justify-center mb-4 shadow-xl animate-bounce">
                <i data-lucide="award" class="text-white w-14 h-14"></i>
            </div>

            <div id="victory-stars" class="flex justify-center gap-3 mb-3"></div>

            <h1 id="victory-title"
                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-orange-500 mb-2 drop-shadow-sm pb-1">
                Level Selesai!
            </h1>
            <p class="text-xl text-gray-600 mb-6 font-bold" id="victory-subtitle">
                Kerja bagus, Penjelajah!
            </p>
            <div id="assessment-container" class="mt-4 w-full mb-4"></div>
            <div class="w-full mb-6 z-10 space-y-5">

                <!-- === XP SUMMARY (SIMPLE) === -->
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200">
                    <div class="flex justify-between text-sm font-bold text-gray-500 mb-2">
                        <span>Jawaban Benar</span>
                        <span id="correct-count">5</span>
                    </div>

                    <div class="flex justify-between text-sm font-bold text-gray-500 mb-2">
                        <span>XP dari Jawaban</span>
                        <span id="xp-answers" class="text-green-500">+25</span>
                    </div>

                    <div class="flex justify-between text-sm font-bold text-gray-500">
                        <span>Bonus Level</span>
                        <span class="text-green-500">+20</span>
                    </div>
                </div>

                <!-- === TOTAL XP (HIGHLIGHT) === -->
                <div
                    class="bg-gradient-to-r from-green-100 to-green-200 border-2 border-green-300 rounded-2xl p-4 flex justify-between items-center shadow-inner">
                    <span class="font-black text-green-800 text-lg">Total XP</span>
                    <span class="font-black text-green-600 text-3xl" id="earned-xp-text">+55</span>
                </div>



            </div>

            <a href="{{ route('mapel.lainnya') }}"
                class="bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white text-2xl font-black py-4 px-12 rounded-full shadow-[0_8px_0_#15803d] hover:shadow-[0_4px_0_#15803d] hover:translate-y-1 transition-all w-full md:w-auto z-10">
                Lanjut ke Level 2
            </a>
        </div>
    </div>

    <!-- --- JAVASCRIPT LOGIC --- -->
    <script>
        const assessmentConfig = {
            literasi: true,
            logika: true,
            visual: true
        };

        let assessment = createAssessment(assessmentConfig);

        function saveScoreToServer() {
            fetch('/save-score', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        xp: xp,
                        true_answers: correctAnswersCount,
                        mapel: 'bahasa-indonesia',
                        kelas: '3',
                        level: '1',
                        ...assessment
                    })
                })
                .then(async res => {
                    const text = await res.text();
                    console.log("RAW RESPONSE:", text); // 🔥 DEBUG

                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error("Response bukan JSON");
                    }
                })
                .then(data => {
                    console.log('Score saved:', data);
                })
                .catch(err => {
                    console.error("ERROR:", err);
                });
        }
        // --- Audio System (Sfx Only) ---
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        function playSound(type) {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === "success") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1);
                osc.frequency.setValueAtTime(783.99, audioCtx.currentTime + 0.2);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.5,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.5);
            } else if (type === "error") {
                osc.type = "triangle";
                osc.frequency.setValueAtTime(200, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    100,
                    audioCtx.currentTime + 0.3,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.3,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
            } else if (type === "page-turn") {
                osc.type = "sawtooth";
                osc.frequency.setValueAtTime(300, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    100,
                    audioCtx.currentTime + 0.2,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.1, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.2,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.2);
            } else if (type === "win") {
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.15);
                osc.frequency.setValueAtTime(783.99, audioCtx.currentTime + 0.3);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.45);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.15, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.8,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.8);
            }
        }

        // --- Data Permainan (Pemahaman Bacaan) ---
        const storyTextContent =
            "Pagi ini Rina pergi ke taman bersama ibunya. Di taman, Rina melihat banyak bunga yang indah. Ia juga bermain ayunan dan berlari bersama temannya.";

        const questions = [{
                q: "Di mana Rina pergi pagi ini?",
                options: [{
                        id: "opt-1",
                        icon: "🏫",
                        text: "Sekolah",
                        isCorrect: false
                    },
                    {
                        id: "opt-2",
                        icon: "🌳",
                        text: "Taman",
                        isCorrect: true
                    },
                    {
                        id: "opt-3",
                        icon: "🏠",
                        text: "Rumah",
                        isCorrect: false
                    },
                ],
            },
            {
                q: "Apa yang dilihat Rina di taman?",
                options: [{
                        id: "opt-1",
                        icon: "🌼",
                        text: "Bunga",
                        isCorrect: true
                    },
                    {
                        id: "opt-2",
                        icon: "🚗",
                        text: "Mobil",
                        isCorrect: false
                    },
                    {
                        id: "opt-3",
                        icon: "🐟",
                        text: "Ikan",
                        isCorrect: false
                    },
                ],
            },
            {
                q: "Apa yang dilakukan Rina di taman?",
                options: [{
                        id: "opt-1",
                        icon: "📚",
                        text: "Membaca buku",
                        isCorrect: false
                    },
                    {
                        id: "opt-2",
                        icon: "🛝",
                        text: "Bermain ayunan",
                        isCorrect: true,
                    },
                    {
                        id: "opt-3",
                        icon: "🍎",
                        text: "Makan apel",
                        isCorrect: false
                    },
                ],
            },
        ];

        const colorPalettes = [{
                bg: "bg-blue-50",
                border: "border-blue-200",
                shadow: "shadow-[0_6px_0_#bfdbfe]",
                text: "text-blue-900",
            },
            {
                bg: "bg-emerald-50",
                border: "border-emerald-200",
                shadow: "shadow-[0_6px_0_#a7f3d0]",
                text: "text-emerald-900",
            },
            {
                bg: "bg-rose-50",
                border: "border-rose-200",
                shadow: "shadow-[0_6px_0_#fecdd3]",
                text: "text-rose-900",
            },
        ];

        let currentPhase = "READING"; // READING, QUESTIONS, TRANSITION
        let currentQuestionIndex = 0;
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        let readingTimerId = null;
        let timeRemaining = 35;

        // DOM Elements
        const storybookContainer = document.getElementById("storybook-container");
        const phaseReading = document.getElementById("phase-reading");
        const phaseQuestions = document.getElementById("phase-questions");
        const timerDisplay = document.getElementById("timer-display");
        const questionTextDisplay = document.getElementById("question-text");
        const optionsContainer = document.getElementById("options-container");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            // Progress based on phase
            let progress = 0;
            if (currentPhase === "QUESTIONS") {
                progress = (currentQuestionIndex / questions.length) * 100;
            }
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        // --- PHASE 1: READING ---
        function startReadingPhase() {
            currentPhase = "READING";
            owlMessage.innerText = "Pahami ceritanya ya. Waktumu 35 detik!";

            phaseQuestions.classList.add("hidden");
            phaseReading.classList.remove("hidden");

            timeRemaining = 35;
            timerDisplay.innerText = timeRemaining;

            readingTimerId = setInterval(() => {
                timeRemaining--;
                timerDisplay.innerText = timeRemaining;

                if (timeRemaining <= 10) {
                    timerDisplay.parentElement.classList.replace(
                        "bg-amber-100",
                        "bg-red-100",
                    );
                    timerDisplay.parentElement.classList.replace(
                        "border-amber-300",
                        "border-red-400",
                    );
                    timerDisplay.classList.replace("text-amber-700", "text-red-600");
                    document
                        .querySelector('[data-lucide="clock"]')
                        .classList.replace("text-amber-600", "text-red-500");
                }

                if (timeRemaining <= 0) {
                    skipReading();
                }
            }, 1000);
        }

        function readStoryAloud() {
            const utterance = new SpeechSynthesisUtterance(storyTextContent);
            utterance.lang = "id-ID";
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        function skipReading() {
            if (currentPhase !== "READING") return;
            clearInterval(readingTimerId);
            window.speechSynthesis.cancel(); // Stop TTS if playing

            transitionToQuestions();
        }

        function transitionToQuestions() {
            currentPhase = "TRANSITION";
            playSound("page-turn");

            storybookContainer.classList.add("animate-turn-page");

            setTimeout(() => {
                phaseReading.classList.add("hidden");
                phaseQuestions.classList.remove("hidden");

                // Reset transform after animation halfway
                storybookContainer.style.transform =
                    "perspective(1000px) rotateY(0deg)";

                renderQuestion();
            }, 400); // Sinkron dengan pertengahan animasi @keyframes turn-page

            setTimeout(() => {
                storybookContainer.classList.remove("animate-turn-page");
                currentPhase = "QUESTIONS";
            }, 800);
        }

        // --- PHASE 2: QUESTIONS ---
        function renderQuestion() {
            if (currentQuestionIndex >= questions.length) {
                showVictory();
                return;
            }

            const qData = questions[currentQuestionIndex];
            questionTextDisplay.innerText = qData.q;
            owlMessage.innerText = "Sekarang jawab pertanyaannya! Arahkan jarimu.";

            optionsContainer.innerHTML = "";

            // Render Options
            qData.options.forEach((opt, index) => {
                const btn = document.createElement("div");
                const palette = colorPalettes[index % colorPalettes.length];

                btn.id = opt.id;
                btn.dataset.correct = opt.isCorrect;

                btn.className =
                    `option-card relative w-full md:flex-1 h-32 md:h-48 rounded-[2rem] flex flex-row md:flex-col items-center justify-start md:justify-center px-6 md:px-2 gap-4 md:gap-2 border-4 transition-all duration-300 cursor-pointer ${palette.bg} ${palette.border} ${palette.shadow}`;

                btn.innerHTML = `
                 <span class="text-5xl md:text-6xl pointer-events-none drop-shadow-md shrink-0">${opt.icon}</span>
                 <span class="font-black ${palette.text} text-xl md:text-2xl pointer-events-none leading-tight md:text-center mt-2">${opt.text}</span>
              `;
                optionsContainer.appendChild(btn);
            });

            updateProgressDots();
            isAnimating = false;
        }

        function handleSelection(selectedId) {
            if (isAnimating || currentPhase !== "QUESTIONS") return;
            isAnimating = true;

            const btn = document.getElementById(selectedId);
            const isCorrect = btn.dataset.correct === "true";

            if (isCorrect) {
                // --- BENAR ---
                playSound("success");
                btn.classList.add("animate-glow-gold");
                storybookContainer.classList.add(
                    "shadow-[0_0_50px_rgba(250,204,21,0.5)]",
                );

                owlMessage.innerText = "Bagus! Kamu mengingat ceritanya.";

                const rect = btn.getBoundingClientRect();
                const x = (rect.left + rect.width / 2) / window.innerWidth;
                const y = (rect.top + rect.height / 2) / window.innerHeight;
                confetti({
                    particleCount: 40,
                    spread: 60,
                    origin: {
                        x,
                        y
                    }
                });

                xp += 5; // Base XP: +5 per question
                levelEarnedXP += 5;
                correctAnswersCount++;
                updateAssessment(assessment, {
                    literasi: 2,
                    logika: 1,
                    visual: 1
                });
                if (
                    mistakesMade === 0 ||
                    roundResults.length < currentQuestionIndex + 1
                ) {
                    roundResults.push("correct");
                }
                updateXPBar();

                setTimeout(() => {
                    storybookContainer.classList.remove(
                        "shadow-[0_0_50px_rgba(250,204,21,0.5)]",
                    );
                    currentQuestionIndex++;
                    renderQuestion();
                }, 2000);
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    visual: -1
                });
                // --- SALAH ---
                playSound("error");
                btn.classList.add(
                    "animate-shake",
                    "!bg-red-100",
                    "!border-red-400",
                    "!shadow-[0_6px_0_#f87171]",
                    "!text-red-900",
                );
                owlMessage.innerText = "Coba ingat lagi ceritanya ya.";

                mistakesMade++;
                if (roundResults.length < currentQuestionIndex + 1)
                    roundResults.push("wrong");
                updateProgressDots(); // Update to red

                setTimeout(() => {
                    btn.classList.remove(
                        "animate-shake",
                        "!bg-red-100",
                        "!border-red-400",
                        "!shadow-[0_6px_0_#f87171]",
                        "!text-red-900",
                    );
                    isAnimating = false;
                }, 1000);
            }
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentQuestionIndex) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-5 h-5 bg-green-500 rounded-full border-2 border-white shadow-inner dot" :
                        "w-5 h-5 bg-red-500 rounded-full border-2 border-white shadow-inner dot";
                } else if (index === currentQuestionIndex) {
                    dot.className =
                        "w-5 h-5 bg-yellow-400 rounded-full border-2 border-white shadow-lg animate-pulse dot";
                } else {
                    dot.className =
                        "w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-inner dot";
                }
            });
        }

        function showVictory() {
            currentPhase = "VICTORY";
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            // XP Rule: Base 20, +5/Q (15), +10 Flawless. Max 45.
            const levelCompletionXP = 20;
            const isFlawlessOverall = roundResults.every((r) => r === "correct");
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;

            // Ensure bar reaches 100% if perfect
            document.getElementById("xp-text").innerText = `${xp} XP`;
            document.getElementById("xp-bar-fill").style.width = `100%`;

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Kamu sudah mencoba dengan baik!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 3 && mistakesMade === 0) {
                stars = 3;
                titleText = "Pemahaman Sempurna!";
                descText = "Luar biasa! Ingatanmu sangat tajam.";
            } else if (correctRounds >= 2) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Kamu cukup paham ceritanya.";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-yellow-400 fill-current drop-shadow-md animate-bounce-slight" style="animation-delay: ${i * 0.1}s"></i>`;
                } else {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-gray-300 fill-current drop-shadow-sm"></i>`;
                }
            }
            lucide.createIcons();

            document.getElementById("victory-title").innerText = titleText;
            document.getElementById("victory-subtitle").innerText = descText;

            document.getElementById("correct-count").innerText =
                correctAnswersCount;
            document.getElementById("xp-answers").innerText =
                `+${correctAnswersCount * 5} XP`;

            const flawlessBadge = document.getElementById("flawless-badge");

            if (flawlessBadge) {
                flawlessBadge.style.display = mistakesMade === 0 ? "flex" : "none";
            }
            document.getElementById("earned-xp-text").innerText =
                `+${levelEarnedXP}`;


            renderAssessmentUI(assessment);
            updateAssessmentBar(assessment);

            overlay.classList.remove("hidden");
            overlay.classList.add("flex");
            modal.classList.add("animate-pop-in");
            playSound("win");

            const duration = 4 * 1000;
            const end = Date.now() + duration;
            (function frame() {
                confetti({
                    particleCount: 8,
                    angle: 60,
                    spread: 55,
                    origin: {
                        x: 0,
                        y: 1
                    },
                    colors: ["#f59e0b", "#fbbf24", "#3b82f6", "#10b981"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#f59e0b", "#fbbf24", "#3b82f6", "#10b981"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        // --- SISTEM PELACAKAN TANGAN & KURSOR ---
        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;
        let hoveredButtonId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_CLICK = 1200; // 1.2 detik hover lock

        function updateCursorUI(timestamp) {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (currentPhase === "QUESTIONS" && !isAnimating) {
                let btnHovered = null;
                const interactableElements =
                    document.querySelectorAll(".option-card");

                interactableElements.forEach((btn) => {
                    const rect = btn.getBoundingClientRect();
                    const padding = 20;
                    if (
                        cursorX >= rect.left - padding &&
                        cursorX <= rect.right + padding &&
                        cursorY >= rect.top - padding &&
                        cursorY <= rect.bottom + padding
                    ) {
                        btnHovered = btn;
                    }
                });

                if (btnHovered) {
                    const currentId = btnHovered.id;

                    cursorEmoji.innerText = "👆";
                    cursorEmoji.style.transform = "scale(1.2)";

                    if (hoveredButtonId === currentId) {
                        if (!hoverStartTime) hoverStartTime = timestamp;
                        const elapsed = timestamp - hoverStartTime;

                        const percentage = Math.min(elapsed / HOVER_DURATION_TO_CLICK, 1);
                        cursorProgress.style.strokeDashoffset = 226.2 * (1 - percentage);

                        if (elapsed >= HOVER_DURATION_TO_CLICK) {
                            handleSelection(currentId);
                            hoveredButtonId = null;
                            hoverStartTime = 0;
                            cursorProgress.style.strokeDashoffset = 226.2;
                        }
                    } else {
                        hoveredButtonId = currentId;
                        hoverStartTime = timestamp;

                        interactableElements.forEach((b) =>
                            b.classList.remove(
                                "scale-105",
                                "shadow-[0_0_20px_rgba(250,204,21,0.5)]",
                            ),
                        );
                        btnHovered.classList.add(
                            "scale-105",
                            "shadow-[0_0_20px_rgba(250,204,21,0.5)]",
                        );
                    }
                } else {
                    cursorEmoji.innerText = "✨";
                    cursorEmoji.style.transform = "scale(1)";

                    if (hoveredButtonId) {
                        const oldBtn = document.getElementById(hoveredButtonId);
                        if (oldBtn)
                            oldBtn.classList.remove(
                                "scale-105",
                                "shadow-[0_0_20px_rgba(250,204,21,0.5)]",
                            );
                    }
                    hoveredButtonId = null;
                    hoverStartTime = 0;
                    cursorProgress.style.strokeDashoffset = 226.2;
                }
            } else {
                // Jika fase membaca, tampilkan efek kursor sparkle saja
                cursorEmoji.innerText = "✨";
                cursorEmoji.style.transform = "scale(1)";
                cursorProgress.style.strokeDashoffset = 226.2;
                hoverStartTime = 0;
                hoveredButtonId = null;
            }

            requestAnimationFrame(updateCursorUI);
        }

        async function initCamera() {
            try {
                const hands = new Hands({
                    locateFile: (file) =>
                        `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`,
                });

                hands.setOptions({
                    maxNumHands: 1,
                    modelComplexity: 0,
                    minDetectionConfidence: 0.5,
                    minTrackingConfidence: 0.5,
                });

                hands.onResults((results) => {
                    cursorElement.style.opacity = "1";
                    if (
                        results.multiHandLandmarks &&
                        results.multiHandLandmarks.length > 0
                    ) {
                        const indexFinger = results.multiHandLandmarks[0][8];
                        targetX = (1 - indexFinger.x) * window.innerWidth;
                        targetY = indexFinger.y * window.innerHeight;
                    }
                });

                const camera = new Camera(videoElement, {
                    onFrame: async () => {
                        await hands.send({
                            image: videoElement
                        });
                    },
                    width: 320,
                    height: 240,
                });

                await camera.start();
                camStatus.innerText = "REC";
                camIndicator.className =
                    "w-2 h-2 bg-red-500 rounded-full animate-pulse";
            } catch (error) {
                camStatus.innerText = "OFF (Mouse)";
                camIndicator.className = "w-2 h-2 bg-gray-500 rounded-full";
            }
        }

        // Dukungan Mouse untuk Testing PC
        document.addEventListener("mousemove", (e) => {
            cursorElement.style.opacity = "1";
            targetX = e.clientX;
            targetY = e.clientY;
        });

        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            startReadingPhase();
            requestAnimationFrame(updateCursorUI);
            initCamera();
        });
    </script>
</body>

</html>
