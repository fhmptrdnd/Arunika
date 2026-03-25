<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Matematika Kelas 2 - Level 2: Susun & Bandingkan</title>
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
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&family=Fredoka+One&display=swap");

        body {
            font-family: "Nunito", sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            touch-action: none;
            user-select: none;
        }

        .font-numbers {
            font-family: "Fredoka One", cursive;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
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

        @keyframes drift {
            from {
                transform: translateX(-10%);
            }

            to {
                transform: translateX(110vw);
            }
        }

        .animate-drift-slow {
            animation: drift 45s linear infinite;
        }

        .animate-drift-fast {
            animation: drift 30s linear infinite;
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
                transform: translateX(-10px) rotate(-5deg);
            }

            40%,
            80% {
                transform: translateX(10px) rotate(5deg);
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
                transform: scale(1.1);
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

        @keyframes glow-green {

            0%,
            100% {
                box-shadow:
                    0 0 20px 5px rgba(74, 222, 128, 0.6),
                    0 8px 0 #166534;
                border-color: #4ade80 !important;
            }

            50% {
                box-shadow:
                    0 0 30px 10px rgba(74, 222, 128, 0.9),
                    0 8px 0 #166534;
                border-color: #86efac !important;
                transform: scale(1.05);
            }
        }

        .animate-glow-green {
            animation: glow-green 1s ease-in-out;
        }

        /* Animasi Teks XP Melayang */
        @keyframes float-up-fade {
            0% {
                transform: translate(-50%, 0) scale(1);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50px) scale(1.2);
                opacity: 0;
            }
        }

        .animate-float-up-fade {
            animation: float-up-fade 1s ease-out forwards;
            pointer-events: none;
        }

        /* Kartu Angka Drag & Drop */
        .number-card {
            transition:
                transform 0.2s,
                box-shadow 0.2s;
            will-change: transform, left, top;
        }

        .number-card.hover-highlight {
            transform: scale(1.1) !important;
            box-shadow: 0 0 25px 10px rgba(255, 255, 255, 0.8) !important;
            z-index: 40;
        }

        .number-card.dragging {
            position: fixed !important;
            z-index: 500;
            opacity: 0.95;
            transform: scale(1.2) rotate(-5deg) !important;
            pointer-events: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            transition: none !important;
        }

        /* Efek Drop Zone Menyala saat Di-hover */
        .slot-glow {
            box-shadow:
                0 0 20px 5px rgba(250, 204, 21, 0.8),
                inset 0 0 15px rgba(250, 204, 21, 0.5) !important;
            border-color: #fde047 !important;
            background-color: rgba(250, 204, 21, 0.2) !important;
            transform: scale(1.05);
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

        .cursor-icon {
            font-size: 3.5rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
            transition: transform 0.1s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-sky-300 via-sky-200 to-indigo-200 h-screen w-full relative overflow-hidden">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute" width="80" height="80">
            <circle class="progress-ring__circle" stroke="#3b82f6" stroke-width="6" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji" class="cursor-icon">🖐️</div>
    </div>

    <!-- --- SCENERY BACKGROUND --- -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-[10%] left-[-20%] animate-drift-slow opacity-90">
            <svg width="180" height="90" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute top-[30%] left-[-10%] animate-drift-fast opacity-70 scale-75">
            <svg width="250" height="120" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>

        <div class="absolute top-[20%] left-[10%] text-white opacity-40 text-4xl animate-float"
            style="animation-delay: 0s">
            ✨
        </div>
        <div class="absolute top-[15%] right-[15%] text-white opacity-50 text-3xl animate-float"
            style="animation-delay: 1s">
            ✨
        </div>

        <div
            class="absolute bottom-0 w-full h-[25vh] bg-green-500 rounded-t-[100%] scale-x-150 transform translate-y-12 shadow-[inset_0_20px_50px_rgba(0,0,0,0.1)]">
        </div>
        <div class="absolute bottom-[-10%] w-[120%] left-[-10%] h-[35vh] bg-green-400 rounded-t-[100%] scale-x-110">
        </div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full pointer-events-none">
        <div
            class="flex items-center gap-3 bg-white/80 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-indigo-400 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                👧🏽
            </div>
            <div>
                <h2 class="font-black text-xl text-indigo-900 tracking-wide drop-shadow-sm">
                    Penjelajah Level 2
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-white/80 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-indigo-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div class="w-48 h-5 bg-indigo-100 rounded-full overflow-hidden shadow-inner border border-indigo-200">
                    <div id="xp-bar-fill"
                        class="h-full bg-gradient-to-r from-yellow-300 to-amber-400 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-indigo-300 mb-2 max-w-[200px]">
                    <p id="owl-message" class="font-bold text-indigo-800 text-sm">
                        Ikuti petunjuk di layar, mari kita mulai!
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

    <!-- --- MAIN GAME AREA --- -->
    <div class="absolute inset-0 top-24 bottom-10 z-10 flex flex-col items-center pointer-events-none">
        <div class="text-center mb-6 shrink-0 pointer-events-auto">
            <h1
                class="text-2xl md:text-3xl font-black text-indigo-900 bg-white/90 backdrop-blur-sm px-6 py-2 rounded-full border-4 border-white shadow-md inline-block">
                Susun dan Bandingkan!
            </h1>
        </div>

        <!-- KARTU PERMAINAN UTAMA -->
        <div id="game-card"
            class="bg-white/95 backdrop-blur-sm p-6 md:p-8 rounded-[3rem] shadow-[0_15px_30px_rgba(0,0,0,0.15)] border-8 border-white w-[95%] max-w-5xl flex flex-col items-center pointer-events-auto transition-transform duration-300 relative min-h-[450px]">
            <!-- TIPE 1: MENGURUTKAN ANGKA (ORDERING) -->
            <div id="phase-order" class="w-full flex-col items-center hidden">
                <h2
                    class="text-2xl font-black text-blue-600 mb-6 uppercase tracking-wide bg-blue-50 px-6 py-2 rounded-full border-2 border-blue-200 shadow-inner">
                    Urutkan dari yang Terkecil!
                </h2>

                <!-- Tempat Drop (Slots) -->
                <div id="slots-container"
                    class="flex flex-wrap justify-center gap-4 md:gap-8 w-full mb-12 min-h-[120px]">
                    <!-- Slots akan di-render via JS -->
                </div>

                <!-- Balok Angka yang bisa di-drag -->
                <div id="drag-yard"
                    class="flex flex-wrap justify-center items-center gap-6 md:gap-10 w-full min-h-[120px] bg-blue-50/50 p-6 rounded-3xl border-4 border-dashed border-blue-200">
                    <!-- Draggable Cards via JS -->
                </div>
            </div>

            <!-- TIPE 2: MEMBANDINGKAN ANGKA (COMPARING) -->
            <div id="phase-compare" class="w-full flex-col items-center hidden">
                <h2
                    class="text-2xl font-black text-purple-600 mb-8 uppercase tracking-wide bg-purple-50 px-6 py-2 rounded-full border-2 border-purple-200 shadow-inner">
                    Angka mana yang Lebih Besar?
                </h2>

                <div id="compare-options" class="flex items-center justify-center gap-8 md:gap-16 w-full">
                    <!-- Option 1 -->
                    <div id="comp-opt-1"
                        class="compare-card relative w-36 h-44 md:w-44 md:h-52 rounded-[2rem] flex items-center justify-center border-4 border-purple-300 bg-purple-100 shadow-[0_10px_0_#c084fc] transition-all duration-300 cursor-pointer font-numbers text-7xl md:text-8xl text-purple-900">
                        45
                    </div>

                    <!-- Tanda VS -->
                    <div
                        class="text-3xl md:text-5xl font-black text-gray-400 bg-gray-100 px-4 py-2 rounded-full shadow-inner border-2 border-gray-200">
                        VS
                    </div>

                    <!-- Option 2 -->
                    <div id="comp-opt-2"
                        class="compare-card relative w-36 h-44 md:w-44 md:h-52 rounded-[2rem] flex items-center justify-center border-4 border-orange-300 bg-orange-100 shadow-[0_10px_0_#fb923c] transition-all duration-300 cursor-pointer font-numbers text-7xl md:text-8xl text-orange-900">
                        67
                    </div>
                </div>
            </div>

            <!-- Indikator Progres -->
            <div class="flex gap-3 mt-auto pt-8" id="progress-dots">
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
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
                Lanjutkan petualangan
            </a>
        </div>
    </div>

    <!-- --- JAVASCRIPT LOGIC --- -->
    <script>
        const assessmentConfig = {
            numerasi: true,
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
                        mapel: 'matematika',
                        kelas: '2',
                        level: '2',
                        ...assessment
                    })
                })
                .then(async res => {
                    const text = await res.text();
                    console.log("RAW RESPONSE:", text);

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
        // --- Audio System ---
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        function playSound(type) {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === "grab") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(600, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    800,
                    audioCtx.currentTime + 0.1,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.15,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.15);
            } else if (type === "drop") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(400, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    200,
                    audioCtx.currentTime + 0.2,
                );
                gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.2,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.2);
            } else if (type === "success") {
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.3,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
            } else if (type === "error") {
                osc.type = "sawtooth";
                osc.frequency.setValueAtTime(150, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    80,
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

        // --- Data Permainan ---
        const rounds = [{
                type: "order",
                numbers: [21, 13, 35],
                target: [13, 21, 35]
            },
            {
                type: "compare",
                numbers: [52, 47],
                target: 52
            },
            {
                type: "order",
                numbers: [40, 12, 28, 36],
                target: [12, 28, 36, 40]
            },
            {
                type: "compare",
                numbers: [68, 86],
                target: 86
            },
            {
                type: "order",
                numbers: [33, 18, 45],
                target: [18, 33, 45]
            },
        ];

        const numberColors = [{
                bg: "bg-blue-400",
                border: "border-blue-200",
                shadow: "shadow-[0_8px_0_#1e3a8a]",
            },
            {
                bg: "bg-emerald-400",
                border: "border-emerald-200",
                shadow: "shadow-[0_8px_0_#064e3b]",
            },
            {
                bg: "bg-rose-400",
                border: "border-rose-200",
                shadow: "shadow-[0_8px_0_#881337]",
            },
            {
                bg: "bg-amber-400",
                border: "border-amber-200",
                shadow: "shadow-[0_8px_0_#78350f]",
            },
        ];

        let currentRound = 0;
        let isAnimating = false;
        let phase = ""; // ORDERING, COMPARING, DONE

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        // Tracking for ordering mode
        let orderedItemsCount = 0;

        // DOM Elements
        const phaseOrderEl = document.getElementById("phase-order");
        const phaseCompareEl = document.getElementById("phase-compare");
        const slotsContainer = document.getElementById("slots-container");
        const dragYard = document.getElementById("drag-yard");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorProgress = document.getElementById("cursor-progress");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} / 100 XP`;
            const progress = Math.min((xp / 100) * 100, 100); // Scale bar to 100 max
            document.getElementById("xp-bar-fill").style.width = `${progress}%`;
        }

        function startRound() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            isAnimating = false;

            if (round.type === "order") {
                phase = "ORDERING";
                phaseCompareEl.classList.add("hidden");
                phaseCompareEl.classList.remove("flex");
                phaseOrderEl.classList.remove("hidden");
                phaseOrderEl.classList.add("flex");

                orderedItemsCount = 0;
                owlMessage.innerText =
                    "Cubit angka dan seret ke kotak yang benar berurutan!";

                slotsContainer.innerHTML = "";
                dragYard.innerHTML = "";

                // Render Empty Slots (Expected order targets)
                round.target.forEach((num) => {
                    const slot = document.createElement("div");
                    slot.className =
                        "track-slot w-24 h-32 md:w-32 md:h-40 border-4 border-dashed border-blue-300 rounded-2xl flex items-center justify-center bg-blue-50/50 transition-all duration-300";
                    slot.dataset.target = num;
                    slotsContainer.appendChild(slot);
                });

                // Render Draggable Cards (Random order)
                const shuffledNumbers = [...round.numbers]; // already mixed or we can mix
                shuffledNumbers.sort(() => Math.random() - 0.5);

                shuffledNumbers.forEach((num, index) => {
                    const palette = numberColors[index % numberColors.length];
                    const card = document.createElement("div");
                    card.id = `card-${num}`;
                    card.dataset.val = num;

                    card.className =
                        `number-card relative w-20 h-28 md:w-28 md:h-36 rounded-2xl flex items-center justify-center border-4 text-white font-numbers text-5xl md:text-6xl cursor-pointer ${palette.bg} ${palette.border} ${palette.shadow}`;
                    card.innerHTML = `<span class="pointer-events-none drop-shadow-md">${num}</span>`;

                    dragYard.appendChild(card);
                });
            } else if (round.type === "compare") {
                phase = "COMPARING";
                phaseOrderEl.classList.add("hidden");
                phaseOrderEl.classList.remove("flex");
                phaseCompareEl.classList.remove("hidden");
                phaseCompareEl.classList.add("flex");

                owlMessage.innerText = "Tahan jarimu di atas angka yang LEBIH BESAR!";

                const opt1 = document.getElementById("comp-opt-1");
                const opt2 = document.getElementById("comp-opt-2");

                opt1.innerText = round.numbers[0];
                opt1.dataset.val = round.numbers[0];
                opt1.className =
                    "compare-card relative w-36 h-44 md:w-44 md:h-52 rounded-[2rem] flex items-center justify-center border-4 border-purple-300 bg-purple-100 shadow-[0_10px_0_#c084fc] transition-all duration-300 cursor-pointer font-numbers text-7xl md:text-8xl text-purple-900";

                opt2.innerText = round.numbers[1];
                opt2.dataset.val = round.numbers[1];
                opt2.className =
                    "compare-card relative w-36 h-44 md:w-44 md:h-52 rounded-[2rem] flex items-center justify-center border-4 border-orange-300 bg-orange-100 shadow-[0_10px_0_#fb923c] transition-all duration-300 cursor-pointer font-numbers text-7xl md:text-8xl text-orange-900";
            }

            updateProgressDots();
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-sm dot" :
                        "w-4 h-4 bg-red-500 rounded-full border-2 border-white shadow-sm dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-4 h-4 bg-yellow-400 rounded-full border-2 border-white shadow-sm animate-pulse dot";
                } else {
                    dot.className =
                        "w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot";
                }
            });
        }

        // --- SISTEM PELACAKAN TANGAN & LOGIKA ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        // Variables for Ordering (Pinch & Drag)
        let isPinching = false;
        let grabbedCard = null;
        let grabOffsetX = 0;
        let grabOffsetY = 0;

        // Variables for Comparing (Hover 1s)
        let hoveredCompareId = null;
        let compareHoverStartTime = 0;
        const HOVER_DURATION_TO_CLICK = 1200;

        function updateGameLoop(timestamp) {
            cursorX += (targetX - cursorX) * 0.7;
            cursorY += (targetY - cursorY) * 0.7;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (!isAnimating) {
                if (phase === "ORDERING") {
                    // Logika Drag & Drop
                    if (isPinching) {
                        if (grabbedCard) {
                            updateHoverSlots();
                        } else {
                            tryGrabCard();
                        }
                    } else {
                        highlightHoveredCard();
                        if (grabbedCard) {
                            handleDrop();
                        }
                    }

                    // Kunci posisi card pada jari
                    if (grabbedCard && isPinching) {
                        grabbedCard.style.left = `${cursorX - grabOffsetX}px`;
                        grabbedCard.style.top = `${cursorY - grabOffsetY}px`;
                    }

                    cursorProgress.style.strokeDashoffset = 226.2; // Matikan ring
                } else if (phase === "COMPARING") {
                    // Logika Hover & Timer
                    let btnHovered = null;
                    const options = document.querySelectorAll(".compare-card");

                    options.forEach((btn) => {
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

                        if (hoveredCompareId === currentId) {
                            if (!compareHoverStartTime) compareHoverStartTime = timestamp;
                            const elapsed = timestamp - compareHoverStartTime;
                            const percentage = Math.min(
                                elapsed / HOVER_DURATION_TO_CLICK,
                                1,
                            );
                            cursorProgress.style.strokeDashoffset =
                                226.2 * (1 - percentage);

                            if (elapsed >= HOVER_DURATION_TO_CLICK) {
                                handleCompareSelection(btnHovered);
                                hoveredCompareId = null;
                                compareHoverStartTime = 0;
                                cursorProgress.style.strokeDashoffset = 226.2;
                            }
                        } else {
                            hoveredCompareId = currentId;
                            compareHoverStartTime = timestamp;
                            options.forEach((b) =>
                                b.classList.remove(
                                    "scale-105",
                                    "shadow-[0_0_20px_rgba(0,0,0,0.2)]",
                                ),
                            );
                            btnHovered.classList.add(
                                "scale-105",
                                "shadow-[0_0_20px_rgba(0,0,0,0.2)]",
                            );
                        }
                    } else {
                        cursorEmoji.innerText = "🖐️";
                        cursorEmoji.style.transform = "scale(1)";
                        if (hoveredCompareId) {
                            const oldBtn = document.getElementById(hoveredCompareId);
                            if (oldBtn)
                                oldBtn.classList.remove(
                                    "scale-105",
                                    "shadow-[0_0_20px_rgba(0,0,0,0.2)]",
                                );
                        }
                        hoveredCompareId = null;
                        compareHoverStartTime = 0;
                        cursorProgress.style.strokeDashoffset = 226.2;
                    }
                }
            }

            requestAnimationFrame(updateGameLoop);
        }

        // --- LOGIKA ORDERING (DRAG DROP) ---
        function highlightHoveredCard() {
            const cards = document.querySelectorAll(".number-card:not(.dragging)");
            let minDistance = 60;
            let closestCard = null;

            cards.forEach((c) => c.classList.remove("hover-highlight"));

            for (let c of cards) {
                if (c.parentElement.classList.contains("track-slot")) continue; // Skip yg sdh dipasang

                const rect = c.getBoundingClientRect();
                const dx = Math.max(rect.left - cursorX, 0, cursorX - rect.right);
                const dy = Math.max(rect.top - cursorY, 0, cursorY - rect.bottom);
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestCard = c;
                }
            }

            if (closestCard) {
                closestCard.classList.add("hover-highlight");
                cursorEmoji.innerText = "🤏"; // Indikasi siap cubit
            } else {
                cursorEmoji.innerText = "🖐️";
            }
        }

        function tryGrabCard() {
            const cards = document.querySelectorAll(".number-card:not(.dragging)");
            let minDistance = 60;
            let closestCard = null;

            for (let c of cards) {
                if (c.parentElement.classList.contains("track-slot")) continue;

                const rect = c.getBoundingClientRect();
                const dx = Math.max(rect.left - cursorX, 0, cursorX - rect.right);
                const dy = Math.max(rect.top - cursorY, 0, cursorY - rect.bottom);
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestCard = c;
                }
            }

            if (closestCard) {
                playSound("grab");
                grabbedCard = closestCard;
                closestCard.classList.remove("hover-highlight");

                const rect = closestCard.getBoundingClientRect();
                grabOffsetX = rect.width / 2;
                grabOffsetY = rect.height / 2;

                closestCard._originalParent = closestCard.parentElement;
                document.body.appendChild(closestCard); // Reparent agar tidak offset gila

                closestCard.style.width = `${rect.width}px`;
                closestCard.style.height = `${rect.height}px`;

                closestCard.classList.add("dragging");
                closestCard.style.left = `${cursorX - grabOffsetX}px`;
                closestCard.style.top = `${cursorY - grabOffsetY}px`;

                owlMessage.innerText = "Seret ke kotak kosong yang benar!";
            }
        }

        function updateHoverSlots() {
            const slots = document.querySelectorAll(".track-slot");
            slots.forEach((s) => s.classList.remove("slot-glow"));

            for (let slot of slots) {
                if (slot.children.length > 0) continue;
                const rect = slot.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;

                if (Math.hypot(cursorX - centerX, cursorY - centerY) < 80) {
                    slot.classList.add("slot-glow");
                    break;
                }
            }
        }

        function handleDrop() {
            if (!grabbedCard) return;

            const slots = document.querySelectorAll(".track-slot");
            let droppedOnSlot = null;

            for (let slot of slots) {
                if (slot.children.length > 0) continue;
                const rect = slot.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;

                if (Math.hypot(cursorX - centerX, cursorY - centerY) < 80) {
                    droppedOnSlot = slot;
                    break;
                }
            }

            slots.forEach((s) => s.classList.remove("slot-glow"));

            if (droppedOnSlot) {
                // Cek apakah angka yang dibawa sesuai dengan target di slot ini
                if (droppedOnSlot.dataset.target === grabbedCard.dataset.val) {
                    // BENAR
                    playSound("success");

                    grabbedCard.classList.remove("dragging");
                    grabbedCard.style.width = "100%";
                    grabbedCard.style.height = "100%";
                    grabbedCard.style.left = "0";
                    grabbedCard.style.top = "0";
                    grabbedCard.style.position = "relative";
                    grabbedCard.style.boxShadow = "none";

                    droppedOnSlot.appendChild(grabbedCard);
                    droppedOnSlot.classList.remove(
                        "border-dashed",
                        "border-blue-300",
                        "bg-blue-50/50",
                    );
                    droppedOnSlot.classList.add("animate-glow-green", "border-solid");

                    owlMessage.innerText = "Tepat sekali!";
                    orderedItemsCount++;

                    if (orderedItemsCount === rounds[currentRound].target.length) {
                        handleChallengeComplete();
                    }
                    updateAssessment(assessment, {
                        numerasi: 3,
                        logika: 2,
                        visual: 1
                    });
                } else {
                    updateAssessment(assessment, {
                        logika: -1,
                        numerasi: -1
                    });
                    // SALAH
                    playSound("error");
                    grabbedCard.classList.add("animate-shake");
                    droppedOnSlot.classList.add("bg-red-200", "border-red-400");
                    setTimeout(
                        () =>
                        droppedOnSlot.classList.remove("bg-red-200", "border-red-400"),
                        500,
                    );

                    owlMessage.innerText = "Urutannya belum pas, coba lagi!";
                    mistakesMade++;
                    if (roundResults.length < currentRound + 1)
                        roundResults.push("wrong");
                    updateProgressDots();

                    setTimeout(() => {
                        resetCardToYard(grabbedCard);
                    }, 400);
                }
            } else {
                playSound("drop");
                resetCardToYard(grabbedCard);
                owlMessage.innerText = "Pastikan angkanya masuk ke dalam kotak.";
            }

            grabbedCard = null;
        }

        function resetCardToYard(card) {
            card.classList.remove("dragging", "animate-shake");
            card.style.width = "";
            card.style.height = "";
            card.style.left = "";
            card.style.top = "";
            card.style.position = "";
            card.style.boxShadow = "";
            if (card._originalParent) card._originalParent.appendChild(card);
        }

        // --- LOGIKA COMPARING ---
        function handleCompareSelection(btn) {
            isAnimating = true;
            const round = rounds[currentRound];
            const selectedVal = parseInt(btn.dataset.val);

            if (selectedVal === round.target) {
                // BENAR
                playSound("success");
                btn.classList.add("animate-glow-green");
                owlMessage.innerText = "Hebat! Pilihanmu benar!";

                const rect = btn.getBoundingClientRect();
                confetti({
                    particleCount: 40,
                    spread: 60,
                    origin: {
                        x: (rect.left + rect.width / 2) / window.innerWidth,
                        y: rect.top / window.innerHeight,
                    },
                });
                updateAssessment(assessment, {
                    numerasi: 3,
                    logika: 2,
                    visual: 1
                });
                handleChallengeComplete();
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    numerasi: -1
                });
                // SALAH
                playSound("error");
                btn.classList.add(
                    "animate-shake",
                    "!bg-red-300",
                    "!border-red-500",
                    "!text-red-900",
                );
                owlMessage.innerText = "Coba pikirkan lagi, mana yang lebih besar?";

                mistakesMade++;
                if (roundResults.length < currentRound + 1)
                    roundResults.push("wrong");
                updateProgressDots();

                setTimeout(() => {
                    btn.classList.remove(
                        "animate-shake",
                        "!bg-red-300",
                        "!border-red-500",
                        "!text-red-900",
                    );
                    isAnimating = false;
                }, 1000);
            }
        }

        // --- GLOBAL SUCCESS ---
        function handleChallengeComplete() {
            if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                roundResults.push("correct");
            }

            xp += 5;
            levelEarnedXP += 5;
            correctAnswersCount++;
            updateXPBar();

            setTimeout(() => {
                currentRound++;
                startRound();
            }, 2000);
        }

        function showVictory() {
            phase = "DONE";
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 25;
            const isFlawlessOverall = roundResults.every((r) => r === "correct");
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            xp += levelCompletionXP + flawlessBonusXP;
            levelEarnedXP += levelCompletionXP + flawlessBonusXP;
            updateXPBar();

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Kamu sudah mencoba dengan baik!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 5) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Kamu Ahli Angka!";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Logikamu sudah sangat baik!";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-yellow-400 fill-current drop-shadow-[0_0_15px_#facc15] animate-bounce-slight" style="animation-delay: ${i * 0.1}s"></i>`;
                } else {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-indigo-300 fill-current drop-shadow-sm"></i>`;
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
                    colors: ["#6366f1", "#a855f7", "#facc15", "#ec4899"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#6366f1", "#a855f7", "#facc15", "#ec4899"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        // --- KAMERA MEDIA-PIPE ---
        const videoElement = document.getElementById("input_video");
        const cursorElement = document.getElementById("hand-cursor");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function setPinchState(pinching) {
            if (isPinching !== pinching) {
                isPinching = pinching;
                if (isPinching && phase === "ORDERING" && !isAnimating) {
                    cursorEmoji.innerText = "🤏";
                    cursorElement.style.transform = "translate(-50%, -50%) scale(0.9)";
                } else if (!isPinching && phase === "ORDERING") {
                    cursorEmoji.innerText = "🖐️";
                    cursorElement.style.transform = "translate(-50%, -50%) scale(1)";
                }
            }
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
                        const landmarks = results.multiHandLandmarks[0];
                        const thumbTip = landmarks[4];
                        const indexTip = landmarks[8];

                        const screenThumbX = (1 - thumbTip.x) * window.innerWidth;
                        const screenThumbY = thumbTip.y * window.innerHeight;
                        const screenIndexX = (1 - indexTip.x) * window.innerWidth;
                        const screenIndexY = indexTip.y * window.innerHeight;

                        const distanceInPixels = Math.hypot(
                            screenThumbX - screenIndexX,
                            screenThumbY - screenIndexY,
                        );

                        if (!isPinching && distanceInPixels < 50) {
                            setPinchState(true);
                        } else if (isPinching && distanceInPixels > 80) {
                            setPinchState(false);
                        }

                        targetX = (screenThumbX + screenIndexX) / 2;
                        targetY = (screenThumbY + screenIndexY) / 2;
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

        document.addEventListener("mousemove", (e) => {
            cursorElement.style.opacity = "1";
            targetX = e.clientX;
            targetY = e.clientY;
        });
        document.addEventListener("mousedown", () => setPinchState(true));
        document.addEventListener("mouseup", () => setPinchState(false));

        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            startRound();
            requestAnimationFrame(updateGameLoop);
            initCamera();
        });
    </script>
</body>

</html>
