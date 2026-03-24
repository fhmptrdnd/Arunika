<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>English Grade 3 - Level 1: Family & Friends</title>
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
            font-family: 'Fredoka One', cursive;
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

        /* Animasi Kamera Flash */
        @keyframes camera-flash {
            0% {
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .animate-camera-flash {
            animation: camera-flash 0.8s ease-out forwards;
        }

        /* Animasi Foto Polaroid Muncul */
        @keyframes polaroid-pop {
            0% {
                transform: scale(0) rotate(-15deg);
                opacity: 0;
            }

            60% {
                transform: scale(1.2) rotate(5deg);
                opacity: 1;
            }

            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        .animate-polaroid {
            animation: polaroid-pop 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
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

        /* Kursor Viewfinder Kamera */
        #hand-cursor {
            position: absolute;
            width: 110px;
            height: 110px;
            pointer-events: none;
            z-index: 1000;
            transform: translate(-50%, -50%);
            transition: opacity 0.2s, transform 0.1s ease-out;
        }

        /* Sudut-sudut bingkai kamera */
        .viewfinder-corner {
            position: absolute;
            width: 25px;
            height: 25px;
            border-color: #3b82f6;
            border-width: 0;
            transition: border-color 0.2s, transform 0.2s;
        }

        .corner-tl {
            top: 0;
            left: 0;
            border-top-width: 6px;
            border-left-width: 6px;
            border-top-left-radius: 12px;
        }

        .corner-tr {
            top: 0;
            right: 0;
            border-top-width: 6px;
            border-right-width: 6px;
            border-top-right-radius: 12px;
        }

        .corner-bl {
            bottom: 0;
            left: 0;
            border-bottom-width: 6px;
            border-left-width: 6px;
            border-bottom-left-radius: 12px;
        }

        .corner-br {
            bottom: 0;
            right: 0;
            border-bottom-width: 6px;
            border-right-width: 6px;
            border-bottom-right-radius: 12px;
        }

        /* Efek Fokus Bingkai (Target Terkunci) */
        #hand-cursor.focused .viewfinder-corner {
            border-color: #10b981;
        }

        #hand-cursor.focused {
            transform: translate(-50%, -50%) scale(0.9);
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.1s linear;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .lucide {
            display: inline-block;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-sky-300 via-sky-200 to-green-300 h-screen w-full relative overflow-hidden">

    <!-- Layar Flash Kamera (Putih) -->
    <div id="flash-overlay" class="fixed inset-0 bg-white z-[9999] opacity-0 pointer-events-none"></div>

    <!-- Kursor Visual Hand Tracking (Viewfinder Kamera) -->
    <div id="hand-cursor" style="opacity: 0">
        <div class="viewfinder-corner corner-tl"></div>
        <div class="viewfinder-corner corner-tr"></div>
        <div class="viewfinder-corner corner-bl"></div>
        <div class="viewfinder-corner corner-br"></div>

        <!-- Lingkaran Loading di tengah -->
        <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="60"
            height="60">
            <circle class="progress-ring__circle" stroke="rgba(59, 130, 246, 0.5)" stroke-width="4" fill="transparent"
                r="26" cx="30" cy="30" stroke-dasharray="163.3" stroke-dashoffset="163.3"
                id="cursor-progress" />
        </svg>

        <!-- Titik fokus tengah -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2 h-2 bg-blue-500 rounded-full"
            id="center-dot"></div>
    </div>

    <!-- --- SCENERY BACKGROUND (Neighborhood) --- -->
    <div class="absolute inset-0 pointer-events-none z-0">
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

        <!-- Hutan & Rumah (Neighborhood) -->
        <div
            class="absolute bottom-0 w-full h-[25vh] bg-green-500 rounded-t-[100%] scale-x-150 transform translate-y-12 shadow-[inset_0_20px_50px_rgba(0,0,0,0.1)]">
        </div>
        <div class="absolute bottom-[-10%] w-[120%] left-[-10%] h-[35vh] bg-green-400 rounded-t-[100%] scale-x-110">
        </div>

        <div class="absolute bottom-[20%] left-[8%] text-8xl drop-shadow-md z-0">🏠</div>
        <div class="absolute bottom-[15%] right-[15%] text-9xl drop-shadow-md z-0 scale-x-[-1]">🏡</div>
        <div class="absolute bottom-[22%] left-[28%] text-6xl drop-shadow-md z-0">🌳</div>
        <div class="absolute bottom-[18%] right-[32%] text-5xl drop-shadow-md z-0">🌲</div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full pointer-events-none">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/80 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                📸</div>
            <div>
                <h2 class="font-black text-xl text-blue-900 tracking-wide drop-shadow-sm">Explorer Level 3</h2>
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
                class="bg-white/80 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-blue-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div class="w-48 h-5 bg-blue-100 rounded-full overflow-hidden shadow-inner border border-blue-200">
                    <div id="xp-bar-fill"
                        class="h-full bg-gradient-to-r from-yellow-300 to-amber-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-blue-300 mb-2 max-w-[200px]">
                    <p id="owl-message" class="font-bold text-blue-800 text-sm">Arahkan kameramu ke orang yang tepat
                        untuk memotret!</p>
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
    <div class="absolute inset-0 top-24 bottom-10 z-10 flex flex-col items-center pointer-events-none">

        <!-- Target Kata (Papan Tugas Fotografer) -->
        <div class="text-center mb-4 shrink-0 pointer-events-auto mt-2">
            <div
                class="bg-white/90 backdrop-blur-sm px-8 py-3 rounded-[2rem] border-8 border-blue-300 shadow-[0_10px_0_#93c5fd,_0_20px_25px_rgba(0,0,0,0.3)] flex flex-col items-center gap-1">
                <span class="text-sm font-bold text-blue-600 uppercase tracking-widest">Take a photo of the:</span>
                <div class="flex items-center gap-4">
                    <button onclick="playTargetSpeech()"
                        class="bg-yellow-400 hover:bg-yellow-500 p-2 rounded-full shadow-md transition-transform hover:scale-110">
                        <i data-lucide="volume-2" class="text-white w-8 h-8"></i>
                    </button>
                    <span id="target-word"
                        class="font-fun text-5xl md:text-6xl text-blue-900 tracking-wide uppercase drop-shadow-sm">FATHER</span>
                </div>
            </div>
        </div>

        <!-- Area Karakter Berdiri (Taman Bermain) -->
        <div id="characters-container"
            class="relative w-full max-w-4xl h-[45vh] flex justify-center items-end pb-8 gap-8 md:gap-16 pointer-events-auto mt-4">
            <!-- Karakter Di-render oleh JS -->
        </div>

        <!-- Tempat Menampilkan Hasil Jepretan (Polaroid) -->
        <div id="polaroid-display"
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-[60] hidden flex-col items-center">
            <div
                class="bg-white p-4 pb-12 rounded-lg shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex flex-col items-center transform rotate-3">
                <div id="polaroid-img"
                    class="w-48 h-48 bg-blue-100 border border-gray-200 flex items-center justify-center text-7xl shadow-inner mb-4">
                    <!-- Icon goes here -->
                </div>
                <span id="polaroid-text" class="font-fun text-3xl text-gray-800">FATHER</span>
            </div>
        </div>

        <!-- Indikator Progres -->
        <div class="absolute bottom-6 flex gap-3 pointer-events-auto bg-white/50 backdrop-blur-sm px-6 py-3 rounded-full border-2 border-white shadow-lg"
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
                        'level': '1',
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
        // Deklarasi DOM Elements di awal
        const targetWordDisplay = document.getElementById("target-word");
        const charactersContainer = document.getElementById("characters-container");
        const owlMessage = document.getElementById("owl-message");

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

            if (type === "snap") {
                // Bunyi Jepretan Kamera (Shutter Flash)
                osc.type = "sawtooth";
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0.8, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.1);

                setTimeout(() => {
                    const osc2 = audioCtx.createOscillator();
                    const gain2 = audioCtx.createGain();
                    osc2.connect(gain2);
                    gain2.connect(audioCtx.destination);
                    osc2.type = "square";
                    osc2.frequency.setValueAtTime(300, audioCtx.currentTime);
                    osc2.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.1);
                    gain2.gain.setValueAtTime(0.3, audioCtx.currentTime);
                    gain2.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
                    osc2.start(audioCtx.currentTime);
                    osc2.stop(audioCtx.currentTime + 0.1);
                }, 100);

            } else if (type === "success") {
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
            } else if (type === "error") {
                osc.type = "triangle";
                osc.frequency.setValueAtTime(200, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
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
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.8);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.8);
            }
        }

        // --- Data Permainan (Family & Friends) ---
        const rounds = [{
                targetWord: "FATHER",
                options: [{
                        id: "father",
                        text: "Father",
                        icon: "👨",
                        color: "bg-blue-200"
                    },
                    {
                        id: "brother",
                        text: "Brother",
                        icon: "👦",
                        color: "bg-green-200"
                    },
                    {
                        id: "mother",
                        text: "Mother",
                        icon: "👩",
                        color: "bg-pink-200"
                    }
                ],
                correct: "father"
            },
            {
                targetWord: "MOTHER",
                options: [{
                        id: "mother",
                        text: "Mother",
                        icon: "👩",
                        color: "bg-pink-200"
                    },
                    {
                        id: "sister",
                        text: "Sister",
                        icon: "👧",
                        color: "bg-rose-200"
                    },
                    {
                        id: "teacher",
                        text: "Teacher",
                        icon: "👨‍🏫",
                        color: "bg-amber-200"
                    }
                ],
                correct: "mother"
            },
            {
                targetWord: "BROTHER",
                options: [{
                        id: "friend",
                        text: "Friend",
                        icon: "🤝",
                        color: "bg-emerald-200"
                    },
                    {
                        id: "brother",
                        text: "Brother",
                        icon: "👦",
                        color: "bg-green-200"
                    },
                    {
                        id: "father",
                        text: "Father",
                        icon: "👨",
                        color: "bg-blue-200"
                    }
                ],
                correct: "brother"
            },
            {
                targetWord: "SISTER",
                options: [{
                        id: "sister",
                        text: "Sister",
                        icon: "👧",
                        color: "bg-rose-200"
                    },
                    {
                        id: "mother",
                        text: "Mother",
                        icon: "👩",
                        color: "bg-pink-200"
                    },
                    {
                        id: "teacher",
                        text: "Teacher",
                        icon: "👩‍🏫",
                        color: "bg-indigo-200"
                    }
                ],
                correct: "sister"
            },
            {
                targetWord: "FRIEND",
                options: [{
                        id: "teacher",
                        text: "Teacher",
                        icon: "👨‍🏫",
                        color: "bg-amber-200"
                    },
                    {
                        id: "brother",
                        text: "Brother",
                        icon: "👦",
                        color: "bg-green-200"
                    },
                    {
                        id: "friend",
                        text: "Friend",
                        icon: "🤝",
                        color: "bg-emerald-200"
                    }
                ],
                correct: "friend"
            }
        ];

        let currentRound = 0;
        let currentState = "PLAYING";
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
            document.getElementById("xp-bar-fill").style.width = `${Math.min(progress, 100)}%`;
        }

        function playTargetSpeech() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(`Take a photo of the ${round.targetWord}`);
            utterance.lang = 'en-US';
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        function renderRound() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            currentState = "PLAYING";
            currentRoundXP = 10;

            targetWordDisplay.innerText = round.targetWord;
            owlMessage.innerText = `Arahkan kamera ke ${round.targetWord} dan tunggu untuk menjepret!`;

            charactersContainer.innerHTML = "";

            const shuffledOptions = [...round.options].sort(() => Math.random() - 0.5);

            shuffledOptions.forEach((opt, index) => {
                const wrapper = document.createElement("div");
                const floatType = `animate-float`;
                wrapper.className = `relative ${floatType} flex flex-col items-center`;
                wrapper.style.animationDelay = `${index * 0.5}s`;

                const charBox = document.createElement("div");
                charBox.id = `char-${opt.id}`;
                charBox.dataset.id = opt.id;

                charBox.className =
                    `character-target relative w-32 h-40 md:w-40 md:h-52 rounded-t-[3rem] rounded-b-2xl border-8 border-white shadow-[0_10px_15px_rgba(0,0,0,0.2)] flex items-center justify-center text-7xl md:text-8xl transition-all duration-300 ${opt.color}`;

                const grass = document.createElement("div");
                grass.className =
                    "absolute -bottom-6 w-full h-8 bg-green-600 rounded-full blur-[2px] opacity-50 z-[-1]";

                charBox.innerHTML = `<span class="drop-shadow-lg pointer-events-none">${opt.icon}</span>`;

                const nameTag = document.createElement("div");
                nameTag.className =
                    "absolute -bottom-4 bg-white px-4 py-1 rounded-full border-2 border-gray-200 font-bold text-gray-700 text-sm shadow-sm";
                nameTag.innerText = opt.text;

                charBox.appendChild(nameTag);
                wrapper.appendChild(grass);
                wrapper.appendChild(charBox);

                charactersContainer.appendChild(wrapper);
            });

            updateProgressDots();
            isAnimating = false;

            setTimeout(playTargetSpeech, 500);
        }

        function handleSnapshot(selectedId) {
            if (isAnimating || currentState !== "PLAYING") return;
            isAnimating = true;
            currentState = "SNAPSHOT";

            const round = rounds[currentRound];
            const charEl = document.getElementById(`char-${selectedId}`);
            const rect = charEl.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            // FLASH EFFECT
            playSound("snap");
            const flashOverlay = document.getElementById("flash-overlay");
            flashOverlay.classList.remove("opacity-0");
            flashOverlay.classList.add("animate-camera-flash");

            if (selectedId === round.correct) {
                // --- BENAR ---
                setTimeout(() => {
                    playSound("success");

                    charactersContainer.style.opacity = "0";

                    const polaroid = document.getElementById("polaroid-display");
                    const polaroidImg = document.getElementById("polaroid-img");
                    const polaroidText = document.getElementById("polaroid-text");

                    const correctOpt = round.options.find(o => o.id === round.correct);
                    polaroidImg.innerText = correctOpt.icon;
                    polaroidImg.className =
                        `w-48 h-48 border border-gray-200 flex items-center justify-center text-7xl shadow-inner mb-4 ${correctOpt.color}`;
                    polaroidText.innerText = correctOpt.text;

                    polaroid.classList.remove("hidden");
                    polaroid.classList.add("flex", "animate-polaroid");

                    owlMessage.innerText = `Jepretan Sempurna! (+${currentRoundXP} XP)`;
                    confetti({
                        particleCount: 50,
                        spread: 80,
                        origin: {
                            x: 0.5,
                            y: 0.5
                        },
                        colors: ['#facc15', '#f472b6', '#38bdf8']
                    });

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
                        roundResults.push('correct');
                    }
                    updateXPBar();

                    setTimeout(() => {
                        polaroid.classList.add("hidden");
                        polaroid.classList.remove("flex", "animate-polaroid");
                        charactersContainer.style.opacity = "1";

                        // PERBAIKAN: Mengembalikan status opacity pada flash
                        flashOverlay.classList.remove("animate-camera-flash");
                        flashOverlay.classList.add("opacity-0");

                        currentRound++;
                        renderRound();
                    }, 3000);
                }, 300);

            } else {

                updateAssessment(assessment, {
                    logika: -1,
                    visual: -1
                });
                // --- SALAH ---
                setTimeout(() => {
                    playSound("error");
                    charEl.classList.add("animate-shake", "!bg-red-300", "!border-red-500");

                    let lostXP = 0;
                    if (currentRoundXP > 0) {
                        currentRoundXP = Math.max(0, currentRoundXP - 5);
                        lostXP = 5;
                    }

                    if (lostXP > 0) {
                        owlMessage.innerText = `Bukan dia! (-5 XP). Ayo cari ${round.targetWord}!`;
                        const xpText = document.createElement("div");
                        xpText.className =
                            "absolute text-red-500 font-black text-4xl drop-shadow-md animate-float-up-fade z-50";
                        xpText.innerText = `-5 XP`;
                        xpText.style.left = `${centerX}px`;
                        xpText.style.top = `${rect.top}px`;
                        document.body.appendChild(xpText);
                        setTimeout(() => xpText.remove(), 1000);
                    } else {
                        owlMessage.innerText = `Foto buram! Coba temukan ${round.targetWord}.`;
                    }

                    mistakesMade++;
                    if (roundResults.length < currentRound + 1) roundResults.push('wrong');
                    updateProgressDots();

                    setTimeout(() => {
                        charEl.classList.remove("animate-shake", "!bg-red-300", "!border-red-500");

                        // PERBAIKAN: Mengembalikan status opacity pada flash agar tidak menutupi layar (putih permanen)
                        flashOverlay.classList.remove("animate-camera-flash");
                        flashOverlay.classList.add("opacity-0");

                        currentState = "PLAYING";
                        isAnimating = false;
                    }, 1000);
                }, 300);
            }
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className = roundResults[index] === 'correct' ?
                        "w-4 h-4 bg-green-400 border-2 border-green-200 rounded-full shadow-[0_0_10px_#4ade80] dot" :
                        "w-4 h-4 bg-red-400 border-2 border-red-200 rounded-full shadow-sm dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-4 h-4 bg-yellow-400 border-2 border-yellow-200 rounded-full shadow-[0_0_10px_#facc15] animate-pulse dot";
                } else {
                    dot.className = "w-4 h-4 bg-white/50 border-2 border-white rounded-full shadow-sm dot";
                }
            });
        }

        function showVictory() {
            currentState = "VICTORY";
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 20;
            const isFlawlessOverall = roundResults.every(r => r === 'correct');
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;
            updateXPBar();

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Kamu fotografer yang gigih!";

            const correctRounds = roundResults.filter(r => r === 'correct').length;

            if (correctRounds === 5) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Album fotomu penuh!";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Hasil jepretanmu hampir sempurna!";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-yellow-400 fill-current drop-shadow-[0_0_15px_#facc15] animate-bounce-slight" style="animation-delay: ${i*0.1}s"></i>`;
                } else {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-sky-200 fill-current drop-shadow-sm"></i>`;
                }
            }
            lucide.createIcons();

            document.getElementById("victory-title").innerText = titleText;
            document.getElementById("victory-subtitle").innerText = descText;

            document.getElementById('correct-count').innerText = correctAnswersCount;
            document.getElementById('xp-answers').innerText = `+${totalAnswersXP} XP`;

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
                    colors: ['#3b82f6', '#60a5fa', '#facc15', '#4ade80']
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ['#3b82f6', '#60a5fa', '#facc15', '#4ade80']
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();
        }

        // --- SISTEM PELACAKAN TANGAN & KURSOR (VIEWFINDER KAMERA) ---
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;

        let hoveredCharId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_SNAP = 1500;

        function updateCursorUI(timestamp) {
            cursorX += (targetX - cursorX) * 0.7;
            cursorY += (targetY - cursorY) * 0.7;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (currentState === "PLAYING" && !isAnimating) {
                let charHovered = null;
                const characters = document.querySelectorAll(".character-target");

                characters.forEach((char) => {
                    const rect = char.getBoundingClientRect();
                    const centerX = rect.left + rect.width / 2;
                    const centerY = rect.top + rect.height / 2;
                    const distance = Math.hypot(cursorX - centerX, cursorY - centerY);

                    if (distance <= rect.width / 2 + 20) {
                        charHovered = char;
                    }
                });

                if (charHovered) {
                    const currentId = charHovered.dataset.id;

                    cursorElement.classList.add("focused");

                    // PERBAIKAN: Menggunakan fungsi add/remove untuk menghindari bug classList.replace di beberapa browser
                    centerDot.classList.remove("bg-blue-500");
                    centerDot.classList.add("bg-emerald-500");

                    if (hoveredCharId === currentId) {
                        if (!hoverStartTime) hoverStartTime = timestamp;
                        const elapsed = timestamp - hoverStartTime;

                        const percentage = Math.min(elapsed / HOVER_DURATION_TO_SNAP, 1);
                        cursorProgress.style.strokeDashoffset = 163.3 * (1 - percentage);
                        cursorProgress.setAttribute("stroke", "#10b981");

                        if (elapsed >= HOVER_DURATION_TO_SNAP) {
                            handleSnapshot(currentId);
                            hoveredCharId = null;
                            hoverStartTime = 0;
                            cursorProgress.style.strokeDashoffset = 163.3;
                        }
                    } else {
                        hoveredCharId = currentId;
                        hoverStartTime = timestamp;

                        characters.forEach((c) => c.classList.remove("scale-110",
                            "shadow-[0_0_30px_rgba(255,255,255,0.8)]"));
                        charHovered.classList.add("scale-110", "shadow-[0_0_30px_rgba(255,255,255,0.8)]");
                    }
                } else {
                    cursorElement.classList.remove("focused");

                    // PERBAIKAN: Menggunakan add/remove
                    centerDot.classList.remove("bg-emerald-500");
                    centerDot.classList.add("bg-blue-500");

                    cursorProgress.setAttribute("stroke", "rgba(59, 130, 246, 0.5)");

                    if (hoveredCharId) {
                        const oldChar = document.getElementById(`char-${hoveredCharId}`);
                        if (oldChar) oldChar.classList.remove("scale-110", "shadow-[0_0_30px_rgba(255,255,255,0.8)]");
                    }
                    hoveredCharId = null;
                    hoverStartTime = 0;
                    cursorProgress.style.strokeDashoffset = 163.3;
                }
            } else {
                cursorElement.classList.remove("focused");
                cursorProgress.style.strokeDashoffset = 163.3;
                hoverStartTime = 0;
                hoveredCharId = null;
            }

            requestAnimationFrame(updateCursorUI);
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
                camIndicator.className = "w-2 h-2 bg-red-500 rounded-full animate-pulse";
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

        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            renderRound();
            requestAnimationFrame(updateCursorUI);
            initCamera();
        });
    </script>
</body>

</html>
