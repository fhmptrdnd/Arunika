<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Indonesia Kelas 1 - Level 2: Pasangkan Kata</title>
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
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&family=Kalam:wght@700&display=swap");

        body {
            font-family: "Nunito", sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            touch-action: none;
            user-select: none;
        }

        .font-chalk {
            font-family: 'Kalam', cursive;
            letter-spacing: 2px;
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
            animation: pop-in 0.5s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Animasi Glow saat target benar */
        @keyframes glow-green {

            0%,
            100% {
                box-shadow: 0 0 20px 5px rgba(74, 222, 128, 0.6), inset 0 0 20px rgba(74, 222, 128, 0.4);
                border-color: #4ade80 !important;
            }

            50% {
                box-shadow: 0 0 40px 15px rgba(74, 222, 128, 0.9), inset 0 0 30px rgba(74, 222, 128, 0.6);
                border-color: #86efac !important;
                transform: scale(1.05);
            }
        }

        .animate-glow-green {
            animation: glow-green 1.5s ease-in-out;
            background-color: rgba(74, 222, 128, 0.2) !important;
        }

        /* Item Magnet Drag & Drop */
        .magnet-item {
            transition: transform 0.2s, box-shadow 0.2s;
            will-change: transform, left, top;
        }

        .magnet-item.hover-highlight {
            transform: scale(1.15) translateX(-10px);
            box-shadow: 0 10px 25px 5px rgba(250, 204, 21, 0.6) !important;
            border-color: #fde047 !important;
            z-index: 50;
        }

        .magnet-item.dragging {
            position: fixed !important;
            z-index: 500;
            opacity: 0.95;
            transform: scale(1.2) rotate(-5deg) !important;
            pointer-events: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            transition: none !important;
        }

        /* Area Drop Zone (Bingkai Putih) */
        .drop-zone {
            transition: all 0.3s;
            background-image: repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0, rgba(255, 255, 255, 0.05) 10px, transparent 10px, transparent 20px);
        }

        .drop-zone.glow {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: #fde047;
            box-shadow: 0 0 25px rgba(250, 204, 21, 0.6), inset 0 0 15px rgba(250, 204, 21, 0.3);
            transform: scale(1.05);
        }

        .drop-zone.error {
            border-color: #ef4444;
            background-color: rgba(239, 68, 68, 0.3);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.6);
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

        .cursor-icon {
            font-size: 3.5rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
            transition: transform 0.1s ease-out;
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.1s linear;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-sky-300 via-blue-200 to-indigo-300 h-screen w-full relative overflow-hidden flex flex-col">

    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute inset-0 w-full h-full">
            <circle class="progress-ring__circle" stroke="#f59e0b" stroke-width="8" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji" class="cursor-icon">🖐️</div>
    </div>

    <!-- --- SCENERY BACKGROUND --- -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[10%] left-[-20%] opacity-80 animate-drift-slow">☁️</div>
        <div class="absolute top-[25%] left-[-10%] opacity-60 text-5xl animate-drift-fast">☁️</div>
        <div class="absolute top-[15%] right-[10%] text-white opacity-40 text-4xl animate-float"
            style="animation-delay: 0s;">✨</div>
        <div class="absolute bottom-[30%] left-[5%] text-white opacity-50 text-3xl animate-float"
            style="animation-delay: 1s;">✨</div>

        <div
            class="absolute bottom-0 w-full h-[25vh] bg-emerald-500 rounded-t-[100%] scale-x-150 transform translate-y-10 shadow-[inset_0_20px_50px_rgba(0,0,0,0.2)]">
        </div>
        <div class="absolute bottom-[-5%] w-[120%] left-[-10%] h-[30vh] bg-emerald-400 rounded-t-[100%] scale-x-110">
        </div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full shrink-0">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/90 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-indigo-400 shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-indigo-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                👦🏽</div>
            <div>
                <h2 class="font-black text-xl text-indigo-900 tracking-wide drop-shadow-sm">Penjelajah Level 2</h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-300"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-white/90 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-indigo-400 shadow-lg flex flex-col items-center">
                <span class="font-black text-indigo-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-40 h-4 bg-indigo-900/20 rounded-full overflow-hidden shadow-inner border border-indigo-200 relative">
                    <div id="xp-bar-fill"
                        class="absolute top-0 left-0 h-full bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-indigo-300 mb-2 max-w-[240px]">
                    <p id="owl-message" class="font-bold text-indigo-800 text-sm">Baca kata di papan, lalu cubit gambar
                        yang tepat dari kotak kanan!</p>
                </div>
                <div class="text-6xl drop-shadow-[0_10px_10px_rgba(0,0,0,0.3)]">🦉</div>
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

    <!-- --- MAIN GAME LAYOUT (Kiri: Papan Tulis | Kanan: Kotak Magnet) --- -->
    <div class="relative z-10 flex flex-row flex-1 w-full pointer-events-none pb-6 px-4 md:px-8 gap-4 md:gap-8">

        <!-- AREA KERJA (Tengah/Kiri - Papan Tulis) -->
        <div class="flex-1 flex flex-col items-center justify-center pointer-events-auto relative mt-2">

            <div
                class="bg-emerald-900 w-full max-w-3xl h-[65vh] min-h-[400px] rounded-3xl border-[16px] border-amber-800 shadow-[0_20px_40px_rgba(0,0,0,0.5),_inset_0_10px_30px_rgba(0,0,0,0.8)] relative flex flex-col items-center p-8 animate-pop-in">

                <!-- Hiasan Papan Tulis -->
                <div class="absolute top-4 left-4 text-3xl opacity-60">✏️</div>
                <div class="absolute bottom-4 right-4 text-4xl opacity-60">🧽</div>
                <div class="absolute top-2 w-[80%] h-1 bg-white/10 rounded-full"></div>

                <div class="text-center mb-8 flex items-center gap-4">
                    <button onclick="playTargetSpeech()"
                        class="bg-white/10 hover:bg-white/20 p-3 rounded-full border-2 border-white/30 transition-colors shadow-sm cursor-pointer interactable-button"
                        title="Dengarkan Kata">
                        <i data-lucide="volume-2" class="text-white w-8 h-8"></i>
                    </button>
                    <h1 id="target-word"
                        class="text-6xl md:text-8xl text-white font-chalk drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)] tracking-widest uppercase">
                        KUCING
                    </h1>
                </div>

                <!-- Drop Zone (Bingkai Putih Putus-putus) -->
                <div id="drop-zone"
                    class="drop-zone w-48 h-48 md:w-56 md:h-56 border-8 border-dashed border-white/40 rounded-[2.5rem] flex items-center justify-center relative mt-4">
                    <span
                        class="text-white/40 font-bold text-xl uppercase tracking-widest text-center px-4 absolute pointer-events-none drop-text">Taruh
                        di sini</span>
                </div>

            </div>

            <!-- Indikator Progres Dots -->
            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 flex gap-3 pointer-events-auto bg-white/90 backdrop-blur-sm px-6 py-3 rounded-full border-4 border-white shadow-xl z-40"
                id="progress-dots">
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
            </div>
        </div>

        <!-- KOTAK MAGNET (Kanan) -->
        <div
            class="w-36 md:w-64 bg-amber-100/95 backdrop-blur-md shadow-[-10px_0_20px_rgba(0,0,0,0.2)] flex flex-col items-center py-6 px-2 h-[80vh] rounded-3xl border-8 border-amber-500 pointer-events-auto overflow-y-auto hide-scrollbar z-30 shrink-0 self-center">

            <h3
                class="text-amber-800 font-black uppercase tracking-wider text-sm md:text-lg mb-4 text-center bg-white px-4 py-1 rounded-full border-2 border-amber-300 shadow-sm">
                Pilih Magnet</h3>

            <div id="magnet-container" class="flex flex-col gap-6 w-full items-center pb-4">
                <!-- Item Magnet akan dirender JS di sini -->
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
                        kelas: '2',
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

            if (type === "grab") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(600, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(800, audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.15);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.15);
            } else if (type === "drop") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(400, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(200, audioCtx.currentTime + 0.2);
                gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.2);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.2);
            } else if (type === "success") {
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1);
                osc.frequency.setValueAtTime(783.99, audioCtx.currentTime + 0.2);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.5);
            } else if (type === "error") {
                osc.type = "triangle";
                osc.frequency.setValueAtTime(200, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
            } else if (type === "hover-lock") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(1000, audioCtx.currentTime + 0.05);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.05, audioCtx.currentTime + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.05);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.05);
            } else if (type === "win") {
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.15);
                osc.frequency.setValueAtTime(783.99, audioCtx.currentTime + 0.3);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.45);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.15, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.8);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.8);
            }
        }

        // --- Data Permainan (Bahasa Indonesia Kelas 1 Level 2) ---
        const rounds = [{
                word: "KUCING",
                target: "🐱",
                options: ["🐱", "🐶", "🐟"]
            },
            {
                word: "APEL",
                target: "🍎",
                options: ["🍎", "🍌", "🍇"]
            },
            {
                word: "BUKU",
                target: "📖",
                options: ["📖", "✏️", "🧸"]
            },
            {
                word: "BOLA",
                target: "⚽",
                options: ["⚽", "🚗", "🏀"]
            },
            {
                word: "IKAN",
                target: "🐟",
                options: ["🐟", "🐔", "🐄"]
            }
        ];

        const magnetColors = [{
                bg: "bg-red-100",
                border: "border-red-400",
                shadow: "shadow-[0_6px_0_#ef4444]"
            },
            {
                bg: "bg-blue-100",
                border: "border-blue-400",
                shadow: "shadow-[0_6px_0_#3b82f6]"
            },
            {
                bg: "bg-green-100",
                border: "border-green-400",
                shadow: "shadow-[0_6px_0_#22c55e]"
            }
        ];

        let currentRound = 0;
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        // DOM Elements
        const targetWordDisplay = document.getElementById("target-word");
        const dropZone = document.getElementById("drop-zone");
        const dropText = dropZone.querySelector('.drop-text');
        const magnetContainer = document.getElementById("magnet-container");
        const owlMessage = document.getElementById("owl-message");

        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");

        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            let progress = (currentRound / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width = `${Math.min(progress, 100)}%`;
        }

        function playTargetSpeech() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.word);
            utterance.lang = 'id-ID';
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        function renderRound() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            targetWordDisplay.innerText = round.word;
            owlMessage.innerText = `Cubit gambar yang sesuai dengan kata ${round.word} lalu pasang di papan!`;

            // Reset Drop Zone
            dropZone.innerHTML =
                '<span class="text-white/40 font-bold text-lg md:text-xl uppercase tracking-widest text-center px-4 absolute pointer-events-none drop-text">Taruh di sini</span>';
            dropZone.className =
                "drop-zone w-48 h-48 md:w-56 md:h-56 border-8 border-dashed border-white/40 rounded-[2.5rem] flex items-center justify-center relative mt-4";

            magnetContainer.innerHTML = "";

            const shuffledOptions = [...round.options].sort(() => Math.random() - 0.5);

            shuffledOptions.forEach((opt, index) => {
                const palette = magnetColors[index % magnetColors.length];
                const magnet = document.createElement("div");

                magnet.id = `mag-${index}`;
                magnet.dataset.val = opt;

                // Kartu Magnet Bergambar
                magnet.className =
                    `magnet-item relative w-24 h-28 md:w-32 md:h-36 rounded-2xl flex items-center justify-center border-4 border-b-8 cursor-pointer ${palette.bg} ${palette.border} ${palette.shadow}`;
                magnet.innerHTML =
                    `<span class="text-5xl md:text-7xl pointer-events-none drop-shadow-md">${opt}</span>`;

                magnetContainer.appendChild(magnet);
            });

            updateProgressDots();
            isAnimating = false;

            setTimeout(playTargetSpeech, 500);
        }

        // --- SISTEM DRAG & DROP SERTA HOVER BUTTON ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let isPinching = false;
        let grabbedItem = null;
        let grabOffsetX = 0;
        let grabOffsetY = 0;

        let hoveredButtonId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_CLICK = 1200;

        function updateGameLoop(timestamp) {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (!isAnimating) {

                // 1. Interaksi Tombol Speaker (Hover Lock)
                if (!isPinching && !grabbedItem) {
                    let btnHovered = null;
                    const actionBtns = document.querySelectorAll(".interactable-button");

                    actionBtns.forEach((btn) => {
                        const rect = btn.getBoundingClientRect();
                        const padding = 20;
                        if (
                            cursorX >= rect.left - padding && cursorX <= rect.right + padding &&
                            cursorY >= rect.top - padding && cursorY <= rect.bottom + padding
                        ) {
                            btnHovered = btn;
                        }
                    });

                    if (btnHovered) {
                        const currentId = btnHovered.title;

                        cursorEmoji.innerText = "👆";
                        cursorEmoji.style.transform = "scale(1.2)";

                        if (hoveredButtonId === currentId) {
                            if (!hoverStartTime) hoverStartTime = timestamp;
                            const elapsed = timestamp - hoverStartTime;

                            const percentage = Math.min(elapsed / HOVER_DURATION_TO_CLICK, 1);
                            cursorProgress.style.strokeDashoffset = 226.2 * (1 - percentage);

                            if (elapsed > 100 && Math.floor(elapsed) % 200 < 20) playSound("hover-lock");

                            if (elapsed >= HOVER_DURATION_TO_CLICK) {
                                playTargetSpeech();
                                hoveredButtonId = null;
                                hoverStartTime = timestamp + 1000; // Delay before next trigger
                                cursorProgress.style.strokeDashoffset = 226.2;
                            }
                        } else {
                            hoveredButtonId = currentId;
                            hoverStartTime = timestamp;
                            btnHovered.classList.add("scale-110");
                        }
                    } else {
                        if (hoveredButtonId) {
                            actionBtns.forEach(b => b.classList.remove("scale-110"));
                        }
                        hoveredButtonId = null;
                        hoverStartTime = 0;
                        cursorProgress.style.strokeDashoffset = 226.2;

                        // Cek hover magnet jika tidak hover tombol
                        highlightHoveredMagnet();
                    }
                } else {
                    // 3. Sedang Pinching / Membawa Magnet
                    if (grabbedItem) {
                        updateHoverDropZone();
                    } else {
                        tryGrabMagnet();
                    }

                    hoveredButtonId = null;
                    hoverStartTime = 0;
                    cursorProgress.style.strokeDashoffset = 226.2;
                    document.querySelectorAll(".interactable-button").forEach((b) => b.classList.remove("scale-110"));
                }
            } else {
                cursorEmoji.innerText = "🖐️";
                cursorEmoji.style.transform = "scale(1)";
                cursorProgress.style.strokeDashoffset = 226.2;
                hoverStartTime = 0;
                hoveredButtonId = null;
            }

            // Lock posisi item yang didrag
            if (grabbedItem && isPinching) {
                grabbedItem.style.left = `${cursorX - grabOffsetX}px`;
                grabbedItem.style.top = `${cursorY - grabOffsetY}px`;
            }

            requestAnimationFrame(updateGameLoop);
        }

        function highlightHoveredMagnet() {
            const magnets = document.querySelectorAll(".magnet-item:not(.dragging)");
            let hoveredMag = null;

            magnets.forEach((m) => m.classList.remove("hover-highlight"));

            for (let m of magnets) {
                if (m.parentElement.id === "drop-zone") continue; // Jangan highlight yang udah dipasang

                const rect = m.getBoundingClientRect();
                const padding = 30;
                if (
                    cursorX >= rect.left - padding && cursorX <= rect.right + padding &&
                    cursorY >= rect.top - padding && cursorY <= rect.bottom + padding
                ) {
                    hoveredMag = m;
                    break;
                }
            }

            if (hoveredMag) {
                hoveredMag.classList.add("hover-highlight");
                cursorEmoji.innerText = "🤏";
                cursorEmoji.style.transform = "scale(1.2)";
            } else {
                cursorEmoji.innerText = "🖐️";
                cursorEmoji.style.transform = "scale(1)";
            }
        }

        function tryGrabMagnet() {
            const magnets = document.querySelectorAll(".magnet-item:not(.dragging)");
            let targetMag = null;

            for (let m of magnets) {
                if (m.parentElement.id === "drop-zone") continue;

                const rect = m.getBoundingClientRect();
                const padding = 30;
                if (
                    cursorX >= rect.left - padding && cursorX <= rect.right + padding &&
                    cursorY >= rect.top - padding && cursorY <= rect.bottom + padding
                ) {
                    targetMag = m;
                    break;
                }
            }

            if (targetMag) {
                playSound("grab");
                grabbedItem = targetMag;
                targetMag.classList.remove("hover-highlight");

                const rect = targetMag.getBoundingClientRect();
                grabOffsetX = rect.width / 2;
                grabOffsetY = rect.height / 2;

                grabbedItem._originalParent = grabbedItem.parentElement;
                document.body.appendChild(grabbedItem);

                grabbedItem.style.width = `${rect.width}px`;
                grabbedItem.style.height = `${rect.height}px`;

                grabbedItem.classList.add("dragging");
                grabbedItem.style.left = `${cursorX - grabOffsetX}px`;
                grabbedItem.style.top = `${cursorY - grabOffsetY}px`;

                owlMessage.innerText = "Tempelkan gambar itu ke kotak di papan tulis!";
            }
        }

        function updateHoverDropZone() {
            dropZone.classList.remove("glow", "error");

            const rect = dropZone.getBoundingClientRect();
            if (
                cursorX >= rect.left && cursorX <= rect.right &&
                cursorY >= rect.top && cursorY <= rect.bottom
            ) {
                dropZone.classList.add("glow");
            }
        }

        function handleDrop() {
            if (!grabbedItem) return;

            let droppedInside = false;

            const rect = dropZone.getBoundingClientRect();
            if (
                cursorX >= rect.left && cursorX <= rect.right &&
                cursorY >= rect.top && cursorY <= rect.bottom
            ) {
                droppedInside = true;
            }

            dropZone.classList.remove("glow");

            if (droppedInside) {
                isAnimating = true;
                const round = rounds[currentRound];

                if (grabbedItem.dataset.val === round.target) {
                    // BENAR
                    playSound("success");

                    grabbedItem.classList.remove("dragging");
                    grabbedItem.style.width = "80%";
                    grabbedItem.style.height = "80%";
                    grabbedItem.style.left = "0";
                    grabbedItem.style.top = "0";
                    grabbedItem.style.position = "relative";
                    grabbedItem.style.boxShadow = "none";
                    grabbedItem.style.transform = "rotate(0deg)";

                    dropZone.innerHTML = "";
                    dropZone.appendChild(grabbedItem);
                    dropZone.classList.remove("border-dashed", "border-white/40");
                    dropZone.classList.add("animate-glow-green", "border-solid", "bg-transparent");

                    owlMessage.innerText = "Cocok sekali!";

                    const cRect = dropZone.getBoundingClientRect();
                    confetti({
                        particleCount: 50,
                        spread: 80,
                        origin: {
                            x: (cRect.left + cRect.width / 2) / window.innerWidth,
                            y: (cRect.top + cRect.height / 2) / window.innerHeight
                        },
                        colors: ['#4ade80', '#3b82f6', '#facc15']
                    });

                    xp += 10;
                    levelEarnedXP += 10;
                    correctAnswersCount++;

                    if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                        roundResults.push('correct');
                    }
                    updateXPBar();
                    updateAssessment(assessment, {
                        literasi: 2,
                        logika: 1,
                        visual: 1
                    });
                    setTimeout(() => {
                        dropZone.classList.remove("animate-glow-green");
                        currentRound++;
                        renderRound();
                    }, 2000);

                } else {
                    updateAssessment(assessment, {
                        logika: -1,
                        visual: -1
                    });
                    // SALAH
                    playSound("error");
                    dropZone.classList.add("error");
                    grabbedItem.classList.add("animate-shake");
                    owlMessage.innerText = "Gambarnya tidak cocok dengan kata. Coba lagi!";

                    mistakesMade++;
                    if (roundResults.length < currentRound + 1) roundResults.push('wrong');
                    updateProgressDots();

                    setTimeout(() => {
                        dropZone.classList.remove("error");
                        resetMagnetToYard(grabbedItem);
                        isAnimating = false;
                    }, 1000);
                }
            } else {
                // Jatuh di luar area
                playSound("drop");
                resetMagnetToYard(grabbedItem);
                owlMessage.innerText = "Pastikan menempelkannya di dalam bingkai putih.";
            }

            grabbedItem = null;
        }

        function resetMagnetToYard(item) {
            if (!item) return;
            item.classList.remove("dragging", "animate-shake");
            item.style.width = "";
            item.style.height = "";
            item.style.left = "";
            item.style.top = "";
            item.style.position = "";
            item.style.transform = "";
            if (item._originalParent) item._originalParent.appendChild(item);
        }

        function setPinchState(pinching) {
            if (isPinching !== pinching) {
                isPinching = pinching;
                if (!isPinching && grabbedItem) {
                    handleDrop();
                }
            }
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className = roundResults[index] === 'correct' ?
                        "w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-inner dot" :
                        "w-4 h-4 bg-red-500 rounded-full border-2 border-white shadow-inner dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-4 h-4 bg-yellow-400 rounded-full border-2 border-white shadow-lg animate-pulse dot";
                } else {
                    dot.className = "w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot";
                }
            });
        }

        function showVictory() {
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 25;
            const isFlawlessOverall = roundResults.every(r => r === 'correct');
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;

            document.getElementById("xp-text").innerText = `${xp} XP`;
            document.getElementById("xp-bar-fill").style.width = `100%`;

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Tidak apa-apa salah, kamu pasti bisa lebih baik!";

            const correctRounds = roundResults.filter(r => r === 'correct').length;

            if (correctRounds === 5 && mistakesMade === 0) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Kamu sangat pintar membaca.";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Kamu sudah pandai mengenali kata.";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-yellow-400 fill-current drop-shadow-md animate-bounce-slight" style="animation-delay: ${i*0.1}s"></i>`;
                } else {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-gray-300 fill-current drop-shadow-sm"></i>`;
                }
            }
            lucide.createIcons();

            document.getElementById("victory-title").innerText = titleText;
            document.getElementById("victory-subtitle").innerText = descText;

            document.getElementById('correct-count').innerText = correctAnswersCount;
            document.getElementById('xp-answers').innerText = `+${correctAnswersCount * 10} XP`;

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
                    colors: ['#3b82f6', '#10b981', '#facc15']
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ['#3b82f6', '#10b981', '#facc15']
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        async function initCamera() {
            try {
                const hands = new Hands({
                    locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`,
                });

                hands.setOptions({
                    maxNumHands: 1,
                    modelComplexity: 0,
                    minDetectionConfidence: 0.5,
                    minTrackingConfidence: 0.5,
                });

                hands.onResults((results) => {
                    cursorElement.style.opacity = "1";
                    if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
                        const indexFinger = results.multiHandLandmarks[0][8];
                        const thumbTip = results.multiHandLandmarks[0][4];

                        targetX = (1 - indexFinger.x) * window.innerWidth;
                        targetY = indexFinger.y * window.innerHeight;

                        const screenThumbX = (1 - thumbTip.x) * window.innerWidth;
                        const screenThumbY = thumbTip.y * window.innerHeight;

                        const distanceInPixels = Math.hypot(targetX - screenThumbX, targetY - screenThumbY);

                        if (!isPinching && distanceInPixels < 50) {
                            setPinchState(true);
                        } else if (isPinching && distanceInPixels > 80) {
                            setPinchState(false);
                        }
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
                camIndicator.className = "w-2 h-2 bg-red-500 rounded-full animate-pulse";
            } catch (error) {
                camStatus.innerText = "OFF (Mouse)";
                camIndicator.className = "w-2 h-2 bg-gray-500 rounded-full";
            }
        }

        // Mouse Support for Testing
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
            renderRound();
            requestAnimationFrame(updateGameLoop);
            initCamera();
        });
    </script>
</body>

</html>
