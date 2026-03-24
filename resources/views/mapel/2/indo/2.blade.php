<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Indonesia Kelas 2 - Level 2: Buka Peti Kata</title>
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

        .font-treasure {
            font-family: 'Fredoka One', cursive;
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

        @keyframes glow-gold {

            0%,
            100% {
                box-shadow: 0 0 20px 5px rgba(250, 204, 21, 0.6), 0 8px 0 #b45309;
            }

            50% {
                box-shadow: 0 0 40px 15px rgba(250, 204, 21, 1), 0 8px 0 #b45309;
                transform: scale(1.05);
            }
        }

        .animate-glow-gold {
            animation: glow-gold 1s ease-in-out;
            border-color: #fde047 !important;
            background-color: #fef08a !important;
        }

        /* Item Kunci Drag & Drop */
        .key-item {
            transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
            will-change: transform, left, top;
        }

        .key-item.hover-highlight {
            transform: scale(1.2) translateY(-10px);
            filter: drop-shadow(0 10px 15px rgba(250, 204, 21, 0.8)) brightness(1.2);
            z-index: 50;
        }

        .key-item.dragging {
            position: fixed !important;
            z-index: 500;
            opacity: 0.95;
            transform: scale(1.3) rotate(-15deg) !important;
            pointer-events: none;
            filter: drop-shadow(0 25px 30px rgba(0, 0, 0, 0.5)) !important;
            transition: none !important;
        }

        /* Peti Harta Karun (Chest) */
        .chest-card {
            transition: all 0.3s;
        }

        .chest-card.glow {
            background-color: rgba(254, 240, 138, 0.9);
            border-color: #fde047;
            box-shadow: 0 0 25px rgba(250, 204, 21, 0.8), inset 0 0 15px rgba(250, 204, 21, 0.4);
            transform: scale(1.05);
        }

        .chest-card.error {
            border-color: #ef4444;
            background-color: rgba(254, 226, 226, 0.9);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.6);
        }

        /* Animasi Teks XP Melayang */
        @keyframes float-up-fade {
            0% {
                transform: translate(-50%, 0) scale(1);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -60px) scale(1.2);
                opacity: 0;
            }
        }

        .animate-float-up-fade {
            animation: float-up-fade 1s ease-out forwards;
            pointer-events: none;
            z-index: 100;
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
    class="bg-gradient-to-b from-sky-400 via-blue-300 to-yellow-200 h-screen w-full relative overflow-hidden flex flex-col">

    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute inset-0 w-full h-full">
            <circle class="progress-ring__circle" stroke="#f59e0b" stroke-width="8" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji" class="cursor-icon">🖐️</div>
    </div>

    <!-- --- SCENERY BACKGROUND (TREASURE ISLAND) --- -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Awan -->
        <div class="absolute top-10 left-[-20%] animate-drift-slow opacity-90">
            <svg width="180" height="90" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute top-28 left-[-10%] animate-drift-fast opacity-70 scale-75">
            <svg width="250" height="120" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>

        <!-- Pasir Pantai / Pulau -->
        <div
            class="absolute bottom-0 w-full h-[25vh] bg-yellow-300 rounded-t-[100%] scale-x-150 transform translate-y-12 shadow-[inset_0_20px_50px_rgba(0,0,0,0.1)]">
        </div>
        <div class="absolute bottom-[-10%] w-[120%] left-[-10%] h-[35vh] bg-yellow-400 rounded-t-[100%] scale-x-110">
        </div>

        <!-- Ornamen Pulau -->
        <div class="absolute bottom-[20%] left-[5%] text-7xl drop-shadow-md">🌴</div>
        <div class="absolute bottom-[10%] right-[8%] text-8xl drop-shadow-md scale-x-[-1]">🌴</div>
        <div class="absolute bottom-[15%] right-[25%] text-5xl drop-shadow-md">🦀</div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full shrink-0">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/80 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-amber-300 shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-amber-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                🏴‍☠️</div>
            <div>
                <h2 class="font-black text-xl text-amber-900 tracking-wide drop-shadow-sm">Bajak Laut Level 2</h2>
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
                class="bg-white/80 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-amber-300 shadow-lg flex flex-col items-center">
                <span class="font-black text-amber-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-48 h-5 bg-amber-900/20 rounded-full overflow-hidden shadow-inner border border-amber-200 relative">
                    <div id="xp-bar-fill"
                        class="absolute top-0 left-0 h-full bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-amber-400 mb-2 max-w-[240px]">
                    <p id="owl-message" class="font-bold text-amber-800 text-sm">Cubit kunci emas di bawah untuk membuka
                        peti harta karun!</p>
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

    <!-- --- MAIN GAME AREA --- -->
    <div
        class="relative z-10 flex flex-col flex-1 w-full pointer-events-none pb-6 px-4 md:px-8 mt-2 items-center justify-start">

        <!-- PAPAN KALIMAT -->
        <div
            class="bg-amber-100/95 backdrop-blur-sm px-6 py-6 md:px-12 md:py-8 rounded-[2rem] border-8 border-amber-700 shadow-[0_15px_0_#92400e,_0_20px_30px_rgba(0,0,0,0.4)] flex flex-col items-center gap-4 pointer-events-auto w-full max-w-4xl relative z-20 animate-pop-in">

            <button onclick="playTargetSpeech()"
                class="absolute -top-6 -right-6 bg-amber-400 hover:bg-amber-500 p-4 rounded-full border-4 border-white shadow-lg transition-transform hover:scale-110 interactable-button"
                title="Dengarkan Contoh">
                <i data-lucide="volume-2" class="text-white w-8 h-8"></i>
            </button>

            <h3
                class="text-amber-800 font-black uppercase tracking-widest text-sm bg-amber-200/50 px-4 py-1 rounded-full">
                Baca dan temukan artinya:</h3>
            <h2 id="target-text"
                class="text-2xl md:text-4xl font-black text-gray-800 tracking-wide text-center leading-relaxed">
                <!-- Text rendered here -->
            </h2>
        </div>

        <!-- AREA PETI (CHESTS YARD) -->
        <div id="chests-container"
            class="flex flex-col md:flex-row flex-wrap justify-center gap-6 md:gap-10 w-full max-w-5xl mt-12 pointer-events-auto z-10 min-h-[200px]">
            <!-- Peti akan dirender via JS -->
        </div>

        <!-- PANGKALAN KUNCI (Key Spawn) -->
        <div
            class="w-full max-w-md h-[400px] absolute bottom-8 flex justify-center items-center pointer-events-auto z-30">
            <div id="key-container" class="relative w-full h-full flex flex-col items-center justify-center">
                <div id="golden-key"
                    class="key-item text-[5rem] md:text-[6rem] drop-shadow-xl cursor-pointer hover:scale-110 transition-transform origin-center">
                    🗝️</div>
                <span class="text-amber-900 font-bold bg-white/70 px-4 py-1 rounded-full shadow-sm mt-2 text-sm">Cubit &
                    Seret Kunci</span>
            </div>
        </div>

        <!-- Indikator Progres -->
        <div class="absolute bottom-6 left-6 flex gap-3 pointer-events-auto bg-white/50 backdrop-blur-md px-4 py-2 rounded-full border-2 border-white shadow-lg z-40"
            id="progress-dots">
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
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
                // Suara kotak terbuka
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.2);
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

        // --- Data Permainan (Detektif Kata) ---
        const rounds = [{
                fullSentence: "Adi minum susu hangat.",
                prefix: "Adi minum susu ",
                highlight: "hangat",
                suffix: ".",
                options: [{
                        id: "opt-1",
                        text: "panas sedikit",
                        isCorrect: true
                    },
                    {
                        id: "opt-2",
                        text: "dingin sekali",
                        isCorrect: false
                    },
                    {
                        id: "opt-3",
                        text: "berangin",
                        isCorrect: false
                    }
                ]
            },
            {
                fullSentence: "Ibu membeli roti baru.",
                prefix: "Ibu membeli roti ",
                highlight: "baru",
                suffix: ".",
                options: [{
                        id: "opt-1",
                        text: "sudah lama",
                        isCorrect: false
                    },
                    {
                        id: "opt-2",
                        text: "belum lama dibuat",
                        isCorrect: true
                    },
                    {
                        id: "opt-3",
                        text: "roti basi",
                        isCorrect: false
                    }
                ]
            },
            {
                fullSentence: "Bola itu besar.",
                prefix: "Bola itu ",
                highlight: "besar",
                suffix: ".",
                options: [{
                        id: "opt-1",
                        text: "ukurannya besar",
                        isCorrect: true
                    },
                    {
                        id: "opt-2",
                        text: "sangat kecil",
                        isCorrect: false
                    },
                    {
                        id: "opt-3",
                        text: "ringan",
                        isCorrect: false
                    }
                ]
            },
            {
                fullSentence: "Kucing itu cepat berlari.",
                prefix: "Kucing itu ",
                highlight: "cepat",
                suffix: " berlari.",
                options: [{
                        id: "opt-1",
                        text: "bergerak lambat",
                        isCorrect: false
                    },
                    {
                        id: "opt-2",
                        text: "sedang tidur",
                        isCorrect: false
                    },
                    {
                        id: "opt-3",
                        text: "bergerak kilat",
                        isCorrect: true
                    }
                ]
            },
            {
                fullSentence: "Adi membawa tas berat.",
                prefix: "Adi membawa tas ",
                highlight: "berat",
                suffix: ".",
                options: [{
                        id: "opt-1",
                        text: "sulit diangkat",
                        isCorrect: true
                    },
                    {
                        id: "opt-2",
                        text: "sangat ringan",
                        isCorrect: false
                    },
                    {
                        id: "opt-3",
                        text: "melayang",
                        isCorrect: false
                    }
                ]
            }
        ];

        let currentRound = 0;
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        const targetTextDisplay = document.getElementById("target-text");
        const chestsContainer = document.getElementById("chests-container");
        const keyContainer = document.getElementById("key-container");
        const goldenKey = document.getElementById("golden-key");
        const owlMessage = document.getElementById("owl-message");

        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");

        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress = (currentRound / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width = `${Math.min(progress, 100)}%`;
        }

        function playTargetSpeech() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.fullSentence);
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

            // Render Kalimat dengan Highlight
            targetTextDisplay.innerHTML =
                `${round.prefix}<span class="text-orange-600 bg-yellow-200 px-3 py-1 rounded-2xl mx-1 border-2 border-orange-300 drop-shadow-sm">${round.highlight}</span>${round.suffix}`;

            owlMessage.innerText = "Seret kunci emas ke peti yang memiliki arti kata yang benar!";

            // Kembalikan kunci ke tempatnya
            resetKeyToYard();

            chestsContainer.innerHTML = "";

            const shuffledOptions = [...round.options].sort(() => Math.random() - 0.5);

            shuffledOptions.forEach((opt) => {
                const chest = document.createElement("div");

                chest.id = opt.id;
                chest.dataset.correct = opt.isCorrect;

                // Desain Chest
                chest.className =
                    `chest-card relative w-full md:w-64 h-32 rounded-3xl flex flex-col items-center justify-center px-4 gap-2 border-4 border-amber-600 bg-amber-100 shadow-[0_8px_0_#b45309]`;

                chest.innerHTML = `
             <span class="chest-icon text-5xl pointer-events-none drop-shadow-md">🧰</span>
             <span class="font-bold text-amber-900 text-lg md:text-xl pointer-events-none text-center leading-tight bg-white/60 px-3 py-1 rounded-full border border-amber-300">${opt.text}</span>
          `;
                chestsContainer.appendChild(chest);
            });

            updateProgressDots();

            setTimeout(playTargetSpeech, 500);
            isAnimating = false;
        }

        // --- SISTEM DRAG & DROP KUNCI EMAS ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let isPinching = false;
        let grabbedKey = null;
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
                if (!isPinching && !grabbedKey) {
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
                        highlightHoveredKey();
                    }
                } else {
                    // 3. Sedang Pinching / Membawa Magnet
                    if (grabbedKey) {
                        updateHoverChest();
                    } else {
                        tryGrabKey();
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
            if (grabbedKey && isPinching) {
                grabbedKey.style.left = `${cursorX - grabOffsetX}px`;
                grabbedKey.style.top = `${cursorY - grabOffsetY}px`;
            }

            requestAnimationFrame(updateGameLoop);
        }

        function highlightHoveredKey() {
            if (grabbedKey || goldenKey.classList.contains('dragging')) return;

            const rect = goldenKey.getBoundingClientRect();
            const padding = 40;
            if (
                cursorX >= rect.left - padding && cursorX <= rect.right + padding &&
                cursorY >= rect.top - padding && cursorY <= rect.bottom + padding
            ) {
                goldenKey.classList.add("hover-highlight");
                cursorEmoji.innerText = "🤏";
                cursorEmoji.style.transform = "scale(1.2)";
            } else {
                goldenKey.classList.remove("hover-highlight");
                cursorEmoji.innerText = "🖐️";
                cursorEmoji.style.transform = "scale(1)";
            }
        }

        function tryGrabKey() {
            if (goldenKey.classList.contains('dragging')) return;

            const rect = goldenKey.getBoundingClientRect();
            const padding = 40;
            if (
                cursorX >= rect.left - padding && cursorX <= rect.right + padding &&
                cursorY >= rect.top - padding && cursorY <= rect.bottom + padding
            ) {
                playSound("grab");
                grabbedKey = goldenKey;
                goldenKey.classList.remove("hover-highlight");

                grabOffsetX = rect.width / 2;
                grabOffsetY = rect.height / 2;

                grabbedKey._originalParent = grabbedKey.parentElement;
                document.body.appendChild(grabbedKey);

                grabbedKey.style.width = `${rect.width}px`;
                grabbedKey.style.height = `${rect.height}px`;

                grabbedKey.classList.add("dragging");
                grabbedKey.style.left = `${cursorX - grabOffsetX}px`;
                grabbedKey.style.top = `${cursorY - grabOffsetY}px`;

                owlMessage.innerText = "Arahkan kunci ke peti yang benar untuk membukanya!";
            }
        }

        function updateHoverChest() {
            const chests = document.querySelectorAll(".chest-card");
            chests.forEach(c => c.classList.remove("glow", "error"));

            for (let chest of chests) {
                const rect = chest.getBoundingClientRect();
                if (
                    cursorX >= rect.left && cursorX <= rect.right &&
                    cursorY >= rect.top && cursorY <= rect.bottom
                ) {
                    chest.classList.add("glow");
                    break;
                }
            }
        }

        function handleDropKey() {
            if (!grabbedKey) return;

            const chests = document.querySelectorAll(".chest-card");
            let droppedOnChest = null;

            for (let chest of chests) {
                const rect = chest.getBoundingClientRect();
                if (
                    cursorX >= rect.left && cursorX <= rect.right &&
                    cursorY >= rect.top && cursorY <= rect.bottom
                ) {
                    droppedOnChest = chest;
                    break;
                }
            }

            chests.forEach(c => c.classList.remove("glow"));

            if (droppedOnChest) {
                isAnimating = true;

                if (droppedOnChest.dataset.correct === "true") {
                    // --- BENAR ---
                    playSound("success");

                    // Hilangkan Kunci
                    grabbedKey.style.display = "none";

                    // Animasi Peti Terbuka
                    droppedOnChest.classList.add("animate-glow-gold", "border-solid");
                    const iconSpan = droppedOnChest.querySelector(".chest-icon");
                    iconSpan.innerText = "🔓"; // Ganti icon jadi terbuka

                    // Tambah harta karun melayang
                    const gem = document.createElement("div");
                    gem.innerText = "💎";
                    gem.className = "absolute text-6xl z-30 animate-float-up-fade";
                    droppedOnChest.appendChild(gem);

                    owlMessage.innerText = "Peti Berhasil Dibuka! Tepat sekali!";

                    const cRect = droppedOnChest.getBoundingClientRect();
                    const cx = (cRect.left + cRect.width / 2) / window.innerWidth;
                    const cy = (cRect.top + cRect.height / 2) / window.innerHeight;
                    confetti({
                        particleCount: 50,
                        spread: 80,
                        origin: {
                            x: cx,
                            y: cy
                        },
                        colors: ['#facc15', '#fef08a', '#ffffff']
                    });
                    updateAssessment(assessment, {
                        literasi: 2,
                        logika: 1,
                        visual: 1
                    });

                    xp += 10;
                    levelEarnedXP += 10;
                    correctAnswersCount++;


                    if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                        roundResults.push('correct');
                    }
                    updateXPBar();

                    setTimeout(() => {
                        currentRound++;
                        renderRound();
                    }, 2500);

                } else {
                    updateAssessment(assessment, {
                        logika: -1,
                        visual: -1
                    });
                    // --- SALAH ---
                    playSound("error");
                    droppedOnChest.classList.add("error", "animate-shake");
                    owlMessage.innerText = "Kuncinya tidak cocok. Coba peti lain!";

                    mistakesMade++;
                    if (roundResults.length < currentRound + 1) roundResults.push('wrong');
                    updateProgressDots();

                    setTimeout(() => {
                        droppedOnChest.classList.remove("error", "animate-shake");
                        resetKeyToYard();
                        isAnimating = false;
                    }, 1000);
                }
            } else {
                // Jatuh di luar area
                playSound("drop");
                resetKeyToYard();
                owlMessage.innerText = "Pastikan meletakkan kunci di atas peti.";
            }

            grabbedKey = null;
        }

        function resetKeyToYard() {
            const key = goldenKey;
            key.style.display = "block";
            key.classList.remove("dragging");
            key.style.width = "";
            key.style.height = "";
            key.style.left = "";
            key.style.top = "";
            key.style.position = "";
            key.style.transform = "";
            key.style.filter = "";

            if (key._originalParent) {
                key._originalParent.appendChild(key);
            }
            grabbedKey = null;
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className = roundResults[index] === 'correct' ?
                        "w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-sm dot" :
                        "w-4 h-4 bg-red-500 rounded-full border-2 border-white shadow-sm dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-4 h-4 bg-yellow-400 rounded-full border-2 border-white shadow-sm animate-pulse dot";
                } else {
                    dot.className = "w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot";
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
                descText = "Luar biasa! Kamu Detektif Kata Hebat!";
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
                    colors: ['#facc15', '#fef08a', '#ffffff', '#fbbf24']
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ['#facc15', '#fef08a', '#ffffff', '#fbbf24']
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        function setPinchState(pinching) {
            if (isPinching !== pinching) {
                isPinching = pinching;
                if (!isPinching && grabbedKey) {
                    handleDropKey();
                }
            }
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
