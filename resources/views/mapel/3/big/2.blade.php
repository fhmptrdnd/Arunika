<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>English Grade 3 - Level 2: City Explorer</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/assessment.js') }}"></script>
    <!-- MediaPipe Hand Tracking -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

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

        .font-fun {
            font-family: "Fredoka One", cursive;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.1);
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

        @keyframes drift-fast {
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

        .animate-drift-fast {
            animation: drift-fast 30s linear infinite;
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
                transform: translateX(-10px) rotate(-3deg);
            }

            40%,
            80% {
                transform: translateX(10px) rotate(3deg);
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

        /* Bangunan Peta */
        .building-target {
            transition:
                transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275),
                filter 0.3s;
            will-change: transform;
        }

        /* Efek saat dikunci (disorot kaca pembesar) */
        .building-target.scanned {
            transform: scale(1.2) !important;
            filter: drop-shadow(0 0 25px rgba(250, 204, 21, 0.9)) brightness(1.1);
            z-index: 50;
        }

        .building-target.correct-glow {
            transform: scale(1.2) !important;
            filter: drop-shadow(0 0 30px rgba(74, 222, 128, 1)) brightness(1.1);
            z-index: 50;
        }

        /* Animasi Teks XP Melayang */
        @keyframes float-up-fade {
            0% {
                transform: translate(-50%, 0) scale(1);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -80px) scale(1.2);
                opacity: 0;
            }
        }

        .animate-float-up-fade {
            animation: float-up-fade 1s ease-out forwards;
            pointer-events: none;
            z-index: 100;
        }

        /* Kursor Kaca Pembesar (Spyglass) */
        #hand-cursor {
            position: absolute;
            width: 120px;
            height: 120px;
            pointer-events: none;
            z-index: 1000;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.2s;
        }

        /* Lingkaran lensa kaca pembesar */
        .spyglass-lens {
            position: absolute;
            width: 100px;
            height: 100px;
            border: 8px solid #3b82f6;
            /* Warna bingkai */
            border-radius: 50%;
            background-color: rgba(59, 130, 246, 0.1);
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.3),
                inset 0 0 20px rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        /* Gagang kaca pembesar */
        .spyglass-handle {
            position: absolute;
            width: 20px;
            height: 60px;
            background: linear-gradient(to bottom, #1d4ed8, #1e3a8a);
            bottom: -45px;
            right: -10px;
            transform: rotate(-45deg);
            border-radius: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.4);
        }

        /* Efek Lensa saat mendeteksi bangunan */
        #hand-cursor.focused .spyglass-lens {
            border-color: #f59e0b;
            /* Berubah amber */
            background-color: rgba(245, 158, 11, 0.2);
            transform: scale(1.1);
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.1s linear;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .lucide {
            display: inline-block;
        }

        /* Visual Jalan di Peta */
        .town-road {
            position: absolute;
            background-color: #cbd5e1;
            border: 8px solid #94a3b8;
            z-index: 1;
        }

        .road-horizontal {
            width: 100%;
            height: 100px;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }

        .road-vertical {
            width: 100px;
            height: 100%;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .road-dash-h {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 8px;
            background-image: linear-gradient(to right,
                    #f8fafc 50%,
                    transparent 50%);
            background-size: 50px 100%;
            transform: translateY(-50%);
        }

        .road-dash-v {
            position: absolute;
            left: 50%;
            top: 0;
            height: 100%;
            width: 8px;
            background-image: linear-gradient(to bottom,
                    #f8fafc 50%,
                    transparent 50%);
            background-size: 100% 50px;
            transform: translateX(-50%);
        }
    </style>
</head>

<body class="bg-gradient-to-b from-sky-300 via-sky-200 to-green-300 h-screen w-full relative overflow-hidden">
    <!-- Kursor Visual Hand Tracking (Kaca Pembesar) -->
    <div id="hand-cursor" style="opacity: 0">
        <div class="spyglass-handle"></div>
        <div class="spyglass-lens">
            <!-- SVG Progress Ring di dalam Lensa -->
            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                <circle class="progress-ring__circle" stroke="#f59e0b" stroke-width="8" fill="transparent" r="42"
                    cx="50" cy="50" stroke-dasharray="263.89" stroke-dashoffset="263.89"
                    id="cursor-progress" />
            </svg>
            <!-- Titik tengah (Crosshair) -->
            <div class="w-2 h-2 bg-blue-500 rounded-full" id="center-dot"></div>
        </div>
    </div>

    <!-- --- SCENERY BACKGROUND (TOWN MAP) --- -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <!-- Awan -->
        <div class="absolute top-5 left-[-20%] animate-drift-slow opacity-90">
            <svg width="150" height="75" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute top-20 left-[-10%] animate-drift-fast opacity-70 scale-75">
            <svg width="200" height="100" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>

        <!-- Tanah Rumput Hijau Polos -->
        <div class="absolute inset-0 bg-green-400 mt-[15vh]"></div>

        <!-- Jalanan Peta -->
        <div class="town-road road-horizontal">
            <div class="road-dash-h"></div>
        </div>
        <div class="town-road road-vertical">
            <div class="road-dash-v"></div>
        </div>
        <div
            class="absolute w-[100px] h-[100px] bg-[#94a3b8] top-[50%] left-[50%] rounded-xl -translate-x-1/2 -translate-y-1/2 z-1">
        </div>
        <!-- Persimpangan -->
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full pointer-events-none">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/90 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-indigo-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                🔍
            </div>
            <div>
                <h2 class="font-black text-xl text-indigo-900 tracking-wide drop-shadow-sm">
                    Explorer Level 3
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-white/90 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-indigo-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-48 h-5 bg-indigo-100 rounded-full overflow-hidden shadow-inner border border-indigo-200 relative">
                    <div id="xp-bar-fill"
                        class="absolute top-0 left-0 h-full bg-gradient-to-r from-yellow-300 to-amber-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-indigo-300 mb-2 max-w-[240px]">
                    <p id="owl-message" class="font-bold text-indigo-800 text-sm">
                        Gunakan lup pembesar untuk mencari gedungnya!
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

    <!-- --- MAIN GAME AREA (PETA & TARGET) --- -->
    <div class="absolute inset-0 top-24 bottom-4 z-10 flex flex-col items-center pointer-events-none">
        <!-- Target Kata (Misi Detektif) -->
        <div class="text-center shrink-0 pointer-events-auto mt-2 mb-4 animate-bounce-slight">
            <div
                class="bg-white/95 backdrop-blur-sm px-8 py-3 rounded-[2rem] border-8 border-indigo-400 shadow-[0_10px_0_#4f46e5,_0_20px_25px_rgba(0,0,0,0.3)] flex flex-col items-center gap-1">
                <span class="text-sm font-bold text-indigo-600 uppercase tracking-widest leading-none mb-1">Misi:
                    Temukan Lokasi</span>
                <div class="flex items-center gap-4">
                    <button onclick="playTargetSpeech()"
                        class="bg-yellow-400 hover:bg-yellow-500 p-3 rounded-full shadow-md transition-transform hover:scale-110">
                        <i data-lucide="volume-2" class="text-white w-6 h-6"></i>
                    </button>
                    <span id="target-word"
                        class="font-fun text-4xl md:text-5xl text-indigo-900 tracking-wide uppercase drop-shadow-sm">LIBRARY</span>
                </div>
            </div>
        </div>

        <!-- Area Peta (Gedung-gedung) -->
        <div id="town-map" class="relative w-full max-w-5xl flex-1 z-20 pointer-events-auto">
            <!-- Bangunan akan ditempatkan di 4 area kuadran dan tengah via JS -->
        </div>

        <!-- Indikator Progres -->
        <div class="absolute bottom-6 left-6 flex gap-3 pointer-events-auto bg-white/90 backdrop-blur-sm px-6 py-3 rounded-full border-4 border-white shadow-lg z-40"
            id="progress-dots">
            <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-5 h-5 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
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
            english: true,
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
                        mapel: 'bahasa-inggris',
                        kelas: '3',
                        'level': '2',
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
        // DOM Elements Initialization
        const townMap = document.getElementById("town-map");
        const owlMessage = document.getElementById("owl-message");
        const targetWordDisplay = document.getElementById("target-word");
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");
        const centerDot = document.getElementById("center-dot");
        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        // --- Audio System ---
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        function playSound(type) {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === "scan") {
                // Bunyi memindai
                osc.type = "sine";
                osc.frequency.setValueAtTime(600, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    800,
                    audioCtx.currentTime + 0.1,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.1, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.15,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.15);
            } else if (type === "success") {
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.3,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
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

        // --- Data Permainan (Peta Kota) ---
        // Posisi diatur secara absolut mengikuti area layar
        const places = [{
                id: "school",
                word: "SCHOOL",
                icon: "🏫",
                color: "bg-blue-400",
                style: "top: 15%; left: 15%;",
            },
            {
                id: "park",
                word: "PARK",
                icon: "🏞️",
                color: "bg-green-400",
                style: "top: 15%; right: 15%;",
            },
            {
                id: "library",
                word: "LIBRARY",
                icon: "📚",
                color: "bg-purple-400",
                style: "top: 50%; left: 50%; transform: translate(-50%, -50%);",
            },
            {
                id: "store",
                word: "STORE",
                icon: "🏪",
                color: "bg-red-400",
                style: "bottom: 15%; left: 15%;",
            },
            {
                id: "house",
                word: "HOUSE",
                icon: "🏡",
                color: "bg-orange-400",
                style: "bottom: 15%; right: 15%;",
            },
        ];

        // Soal: urutan acak dari 5 tempat
        const rounds = [...places].sort(() => Math.random() - 0.5);

        let currentRound = 0;
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        let currentRoundXP = 10;
        let totalAnswersXP = 0;

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress = (currentRound / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function playTargetSpeech() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(
                `Find the ${round.word}`,
            );
            utterance.lang = "en-US";
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        // Render Peta (Bangunan tetap di posisinya sepanjang game)
        function renderMap() {
            townMap.innerHTML = "";
            places.forEach((place) => {
                const bldgWrapper = document.createElement("div");
                bldgWrapper.id = `bldg-${place.id}`;
                bldgWrapper.dataset.id = place.id;

                // Base class
                bldgWrapper.className =
                    `building-target absolute w-36 h-40 md:w-44 md:h-48 rounded-[2.5rem] border-8 border-white/90 shadow-[0_15px_20px_rgba(0,0,0,0.2)] flex flex-col items-center justify-center bg-gradient-to-br ${place.color.replace("bg-", "from-")}-400 to-${place.color.replace("bg-", "")}-600`;
                bldgWrapper.style = place.style;

                // Ikon besar
                bldgWrapper.innerHTML = `
                 <span class="text-7xl md:text-8xl drop-shadow-lg pointer-events-none">${place.icon}</span>
              `;

                // Rumput dekoratif di bawah
                const grass = document.createElement("div");
                grass.className =
                    "absolute -bottom-6 w-3/4 h-6 bg-black/10 rounded-full blur-md z-[-1]";
                bldgWrapper.appendChild(grass);

                townMap.appendChild(bldgWrapper);
            });
        }

        function renderRound() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            currentRoundXP = 10;

            targetWordDisplay.innerText = round.word;
            owlMessage.innerText = `Arahkan Lup pembesarmu ke bangunan ${round.word}!`;

            // Bersihkan status scanned dari bangunan
            document.querySelectorAll(".building-target").forEach((b) => {
                b.classList.remove("scanned", "correct-glow");
            });

            updateProgressDots();
            isAnimating = false;

            setTimeout(playTargetSpeech, 500);
        }

        // --- SISTEM KACA PEMBESAR (HOVER TO LOCK) ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let hoveredBldgId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_SCAN = 1500; // 1.5 detik untuk mengunci

        function updateGameLoop(timestamp) {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (!isAnimating) {
                let bldgHovered = null;
                const buildings = document.querySelectorAll(".building-target");

                buildings.forEach((bldg) => {
                    const rect = bldg.getBoundingClientRect();
                    // Hitbox lingkaran (Kaca pembesar)
                    const centerX = rect.left + rect.width / 2;
                    const centerY = rect.top + rect.height / 2;
                    const distance = Math.hypot(cursorX - centerX, cursorY - centerY);

                    if (distance <= rect.width / 2 + 30) {
                        bldgHovered = bldg;
                    }
                });

                if (bldgHovered) {
                    const currentId = bldgHovered.dataset.id;

                    // Efek visual kursor saat mendeteksi bangunan
                    cursorElement.classList.add("focused");
                    centerDot.classList.replace("bg-blue-500", "bg-amber-500");

                    if (hoveredBldgId === currentId) {
                        if (!hoverStartTime) hoverStartTime = timestamp;
                        const elapsed = timestamp - hoverStartTime;

                        // Animasi Loading Ring pada kaca pembesar
                        const percentage = Math.min(elapsed / HOVER_DURATION_TO_SCAN, 1);
                        cursorProgress.style.strokeDashoffset = 263.89 * (1 - percentage);

                        // Mainkan sound efek deteksi halus secara berkala
                        if (elapsed > 100 && Math.floor(elapsed) % 200 < 20)
                            playSound("scan");

                        if (elapsed >= HOVER_DURATION_TO_SCAN) {
                            handleScan(bldgHovered);
                            hoveredBldgId = null;
                            hoverStartTime = 0;
                            cursorProgress.style.strokeDashoffset = 263.89;
                        }
                    } else {
                        hoveredBldgId = currentId;
                        hoverStartTime = timestamp;

                        buildings.forEach((c) => c.classList.remove("scanned"));
                        bldgHovered.classList.add("scanned");
                    }
                } else {
                    // Kursor di area kosong
                    cursorElement.classList.remove("focused");
                    centerDot.classList.replace("bg-amber-500", "bg-blue-500");

                    if (hoveredBldgId) {
                        const oldBldg = document.getElementById(`bldg-${hoveredBldgId}`);
                        if (oldBldg) oldBldg.classList.remove("scanned");
                    }
                    hoveredBldgId = null;
                    hoverStartTime = 0;
                    cursorProgress.style.strokeDashoffset = 263.89;
                }
            } else {
                // Sembunyikan efek kursor saat animasi win/lose
                cursorElement.classList.remove("focused");
                cursorProgress.style.strokeDashoffset = 263.89;
                hoverStartTime = 0;
                hoveredBldgId = null;
            }

            requestAnimationFrame(updateGameLoop);
        }

        function handleScan(scannedBldg) {
            if (isAnimating) return;
            isAnimating = true;

            const round = rounds[currentRound];
            const scannedId = scannedBldg.dataset.id;

            const rect = scannedBldg.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            if (scannedId === round.id) {
                // BENAR
                playSound("success");

                scannedBldg.classList.remove("scanned");
                scannedBldg.classList.add("correct-glow");

                owlMessage.innerText = `Deteksi Tepat! (+${currentRoundXP} XP)`;
                confetti({
                    particleCount: 50,
                    spread: 80,
                    origin: {
                        x: centerX / window.innerWidth,
                        y: centerY / window.innerHeight,
                    },
                    colors: ["#4ade80", "#facc15", "#3b82f6"],
                });

                const xpText = document.createElement("div");
                xpText.className =
                    "absolute text-green-500 font-black text-5xl drop-shadow-md animate-float-up-fade z-50";
                xpText.innerText = `+${currentRoundXP} XP`;
                xpText.style.left = `${centerX}px`;
                xpText.style.top = `${rect.top}px`;
                document.body.appendChild(xpText);
                setTimeout(() => xpText.remove(), 1000);

                xp += currentRoundXP;
                levelEarnedXP += currentRoundXP;
                totalAnswersXP += currentRoundXP;
                correctAnswersCount++;
                updateAssessment(assessment, {
                    english: 2,
                    visual: 2,
                    logika: 1
                });
                if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                    roundResults.push("correct");
                }
                updateXPBar();

                setTimeout(() => {
                    scannedBldg.classList.remove("correct-glow");
                    currentRound++;
                    renderRound();
                }, 2500);
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    visual: -1
                });
                // SALAH
                playSound("error");

                scannedBldg.classList.remove("scanned");
                scannedBldg.classList.add("animate-shake");
                scannedBldg.style.filter =
                    "brightness(0.8) hue-rotate(-30deg) drop-shadow(0 0 15px rgba(239, 68, 68, 0.8))";

                let lostXP = 0;
                if (currentRoundXP > 0) {
                    currentRoundXP = Math.max(0, currentRoundXP - 5);
                    lostXP = 5;
                }

                if (lostXP > 0) {
                    owlMessage.innerText = `Bukan disitu! (-5 XP). Coba lagi cari ${round.word}!`;
                    const xpText = document.createElement("div");
                    xpText.className =
                        "absolute text-red-500 font-black text-4xl drop-shadow-md animate-float-up-fade z-50";
                    xpText.innerText = `-5 XP`;
                    xpText.style.left = `${centerX}px`;
                    xpText.style.top = `${rect.top}px`;
                    document.body.appendChild(xpText);
                    setTimeout(() => xpText.remove(), 1000);
                } else {
                    owlMessage.innerText = `Salah target! Ayo cari ${round.word}.`;
                }

                mistakesMade++;
                if (roundResults.length < currentRound + 1)
                    roundResults.push("wrong");
                updateProgressDots();

                setTimeout(() => {
                    scannedBldg.classList.remove("animate-shake");
                    scannedBldg.style.filter = "";
                    isAnimating = false;
                }, 1000);
            }
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-5 h-5 bg-green-500 rounded-full border-4 border-white shadow-sm dot" :
                        "w-5 h-5 bg-red-500 rounded-full border-4 border-white shadow-sm dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-5 h-5 bg-amber-400 rounded-full border-4 border-white shadow-lg animate-pulse dot";
                } else {
                    dot.className =
                        "w-5 h-5 bg-gray-300 rounded-full border-4 border-white shadow-sm dot";
                }
            });
        }

        function showVictory() {
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 25;
            const isFlawlessOverall = roundResults.every((r) => r === "correct");
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;
            updateXPBar();

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Kamu sudah berusaha dengan baik!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 5) {
                stars = 3;
                titleText = "Detektif Kota Hebat!";
                descText = "Luar biasa! Insting pencarianmu sempurna!";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Kamu sangat jeli menemukan tempat!";
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
                `+${totalAnswersXP} XP`;
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
                    colors: ["#4f46e5", "#a855f7", "#facc15", "#4ade80"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#4f46e5", "#a855f7", "#facc15", "#4ade80"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
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

        // Mouse Support for Testing
        document.addEventListener("mousemove", (e) => {
            cursorElement.style.opacity = "1";
            targetX = e.clientX;
            targetY = e.clientY;
        });

        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            renderMap();
            renderRound();
            requestAnimationFrame(updateGameLoop);
            initCamera();
        });
    </script>
</body>

</html>
