@php
    $user = Auth::user();
    $id = $user->id;
@endphp

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Indonesia - Level 1: Vokal & Konsonan</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MediaPipe Hand Tracking -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&display=swap");

        body {
            font-family: "Nunito", sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            touch-action: none;
            user-select: none;
        }

        /* Latar Belakang & Animasi Dasar */
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
                transform: translateX(-100%);
            }

            to {
                transform: translateX(100vw);
            }
        }

        .animate-drift-slow {
            animation: drift 40s linear infinite;
        }

        .animate-drift-fast {
            animation: drift 25s linear infinite;
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

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-pop-in {
            animation: pop-in 0.5s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
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
                transform: scale(1.1);
            }
        }

        .animate-glow-gold {
            animation: glow-gold 1s ease-in-out;
            border-color: #fde047 !important;
            background-color: #fef08a !important;
            color: #b45309 !important;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 20px rgba(59, 130, 246, 0);
            }

            100% {
                transform: scale(0.8);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .animate-pulse-ring {
            animation: pulse-ring 2s infinite;
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
            transition: opacity 0.2s;
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
<!-- COUNTDOWN OVERLAY -->
<div id="countdown-overlay"
    class="fixed inset-0 bg-black/70 z-[999] flex items-center justify-center flex-col text-white">

    <h1 class="text-3xl font-bold mb-4">Bersiap ya...</h1>
    <div id="countdown-number" class="text-7xl font-black">8</div>
</div>

<body class="bg-gradient-to-b from-sky-200 to-green-200 h-screen w-full relative">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute" width="80" height="80">
            <circle class="progress-ring__circle" stroke="#22c55e" stroke-width="6" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji"
            style="
          font-size: 3rem;
          filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
          transition: all 0.2s;
        ">
            🖐️
        </div>
    </div>

    <!-- --- AUDIO VISUALIZER BAR (KIRI) --- -->
    <div id="audio-visualizer-container"
        class="hidden absolute left-4 md:left-8 top-1/2 transform -translate-y-1/2 w-10 h-64 bg-white/60 backdrop-blur-md rounded-full border-4 border-white shadow-lg flex-col justify-end overflow-hidden z-50">
        <div id="audio-bar" class="w-full bg-green-400 transition-all duration-75" style="height: 0%"></div>
        <div class="absolute top-2 left-1/2 transform -translate-x-1/2 text-gray-400">
            <i data-lucide="mic" class="w-4 h-4"></i>
        </div>
    </div>

    <!-- --- SCENERY BACKGROUND --- -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-10 left-[-20%] animate-drift-slow opacity-80">
            <svg width="150" height="80" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute top-32 left-[-10%] animate-drift-fast opacity-60 scale-75">
            <svg width="200" height="100" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute bottom-0 w-full h-1/4 bg-green-400 rounded-t-[100%] scale-x-150 transform translate-y-12">
        </div>
        <div class="absolute bottom-[-10%] w-[120%] left-[-10%] h-1/2 bg-green-500 rounded-t-[100%] scale-x-110"></div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/60 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg">
            <div
                class="w-14 h-14 bg-blue-400 rounded-full border-4 border-white flex items-center justify-center text-3xl shadow-inner">
                👧🏽
            </div>
            <div>
                <h2 class="font-black text-xl text-blue-900 tracking-wide drop-shadow-sm">
                    Penjelajah Level 1
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2">
            <div
                class="bg-white/70 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-blue-900 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-48 h-5 bg-blue-900/20 rounded-full overflow-hidden shadow-inner border-2 border-white/50 relative">
                    <div id="xp-bar-fill"
                        class="absolute top-0 left-0 h-full bg-gradient-to-r from-yellow-300 to-yellow-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Kamera Tangan & Maskot -->
        <div class="flex items-start gap-4">
            <div class="relative hidden lg:flex flex-col items-end pt-4 animate-float">
                <div
                    class="bg-white px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-blue-200 mb-2 max-w-[220px]">
                    <p id="owl-message" class="font-bold text-blue-900 text-sm">
                        Klik ikon speaker untuk mendengar suara huruf!
                    </p>
                </div>
                <svg width="80" height="80" viewBox="0 0 100 100" class="drop-shadow-lg">
                    <circle cx="50" cy="50" r="40" fill="#8b5cf6" />
                    <circle cx="50" cy="65" r="30" fill="#a78bfa" />
                    <circle cx="35" cy="40" r="14" fill="white" />
                    <circle cx="65" cy="40" r="14" fill="white" />
                    <circle cx="35" cy="40" r="6" fill="#1e1b4b" />
                    <circle cx="65" cy="40" r="6" fill="#1e1b4b" />
                    <path d="M45 50 L55 50 L50 60 Z" fill="#fbbf24" />
                    <path d="M10 50 Q 5 65 20 75 Z" fill="#7c3aed" />
                    <path d="M90 50 Q 95 65 80 75 Z" fill="#7c3aed" />
                </svg>
            </div>

            <!-- Kamera Feed -->
            <div
                class="bg-slate-800 p-2 rounded-2xl border-4 border-slate-600 shadow-xl flex flex-col items-center w-36 h-32 relative overflow-hidden">
                <div class="absolute top-2 left-2 flex items-center gap-1 z-10">
                    <div id="cam-indicator" class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                    <span id="cam-status"
                        class="text-[10px] text-white font-bold tracking-wider drop-shadow-md">LOADING</span>
                </div>
                <video id="input_video" class="w-full h-full object-cover rounded-xl mt-4 scale-x-[-1]" autoplay
                    playsinline></video>
                <div
                    class="absolute bottom-2 text-xs text-white font-bold drop-shadow-md z-10 bg-black/30 px-2 rounded-full">
                    Hand Cam
                </div>
            </div>
        </div>
    </div>

    <!-- --- MAIN GAME CARD --- -->
    <div class="absolute inset-0 top-28 bottom-10 z-10 flex flex-col items-center justify-center pointer-events-none">
        <div id="game-card"
            class="bg-white/95 backdrop-blur-sm p-8 rounded-[3rem] shadow-[0_15px_30px_rgba(0,0,0,0.15)] border-8 border-white max-w-4xl w-[90%] md:w-[700px] flex flex-col items-center pointer-events-auto transition-transform duration-300 min-h-[450px]">
            <!-- --- FASE 1: TEBAK HURUF --- -->
            <div id="phase-guess" class="w-full flex flex-col items-center">
                <!-- Judul & Speaker -->
                <div class="text-center mb-6">
                    <div
                        class="bg-blue-100 text-blue-600 font-black px-6 py-2 rounded-full uppercase tracking-widest text-sm mb-4 inline-block border-2 border-blue-200">
                        Temukan Huruf yang Benar!
                    </div>

                    <div class="flex flex-col items-center justify-center cursor-pointer option-btn" id="btn-speaker"
                        onclick="playCurrentLetterSound()">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full shadow-[0_8px_0_#1e3a8a] border-4 border-white flex items-center justify-center mb-3 animate-bounce-slight hover:scale-110 transition-transform">
                            <i data-lucide="volume-2" class="text-white w-10 h-10 pointer-events-none"></i>
                        </div>
                        <p class="font-bold text-gray-500 text-sm pointer-events-none">
                            Klik untuk mendengar suara
                        </p>
                    </div>
                </div>

                <!-- Opsi Jawaban -->
                <div id="options-container" class="flex flex-wrap justify-center gap-6 w-full mb-6 mt-4">
                    <!-- Di-render oleh JS -->
                </div>
            </div>

            <!-- --- FASE 2: UCAPKAN (MICROPHONE) --- -->
            <div id="phase-voice" class="w-full flex-col items-center justify-center hidden pt-8">
                <h2 class="text-3xl font-black text-gray-800 mb-2">Hebat!</h2>
                <p class="text-xl text-gray-500 font-bold mb-10">
                    Sekarang giliranmu ucapkan huruf
                    <span id="target-letter-display" class="text-blue-500 font-black text-3xl">A</span>
                </p>

                <!-- Ikon Mic -->
                <div id="btn-mic"
                    class="option-btn w-32 h-32 bg-blue-100 rounded-full border-8 border-blue-200 flex items-center justify-center mb-8 relative cursor-pointer hover:scale-105 transition-transform">
                    <div id="mic-pulse" class="absolute inset-0 rounded-full"></div>
                    <i data-lucide="mic" class="text-blue-500 w-16 h-16 relative z-10 pointer-events-none"></i>
                </div>

                <p id="voice-feedback" class="text-lg font-bold text-blue-600 mb-2 text-center">
                    Menyiapkan pendengaran...
                </p>
                <!-- Menambahkan elemen untuk menampilkan teks yang diucapkan -->
                <p id="recognized-text" class="text-md font-semibold text-gray-600 mb-6 text-center italic h-6"></p>

                <button onclick="skipVoicePhase()" class="text-gray-400 underline font-bold hover:text-gray-600 z-20">
                    Lewati / Suara tidak terdengar
                </button>
            </div>

            <!-- Indikator Progres -->
            <div class="flex gap-3 mt-auto pt-4" id="progress-dots">
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            </div>
        </div>
    </div>

    <!-- --- VICTORY OVERLAY TERBARU --- -->
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

                <!-- === PERFORMANCE (LEBIH CLEAN) === -->
                <div class="bg-white border-2 border-blue-200 rounded-2xl p-4">
                    <h3 class="font-black text-blue-700 mb-4 text-lg text-center">
                        Performa Kamu
                    </h3>

                    <!-- Literasi -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm font-bold text-gray-600 mb-1">
                            <span>📖 Literasi</span>
                            <span id="score-literasi">0</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="bar-literasi" class="h-2 bg-blue-500 rounded-full transition-all duration-700"
                                style="width:0%"></div>
                        </div>
                    </div>

                    <!-- Logika -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm font-bold text-gray-600 mb-1">
                            <span>🧠 Logika</span>
                            <span id="score-logika">0</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="bar-logika" class="h-2 bg-purple-500 rounded-full transition-all duration-700"
                                style="width:0%"></div>
                        </div>
                    </div>

                    <!-- Visual -->
                    <div>
                        <div class="flex justify-between text-sm font-bold text-gray-600 mb-1">
                            <span>👁️ Visual</span>
                            <span id="score-visual">0</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="bar-visual" class="h-2 bg-green-500 rounded-full transition-all duration-700"
                                style="width:0%"></div>
                        </div>
                    </div>
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
                        kelas: '1',
                        level: '1',

                        literasi: assessment.literasi,
                        logika: assessment.logika,
                        visual: assessment.visual
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
        // waktu sebelum mulai
        function startCountdown(duration, onFinish) {
            let timeLeft = duration;
            const countdownEl = document.getElementById("countdown-number");
            const overlay = document.getElementById("countdown-overlay");

            countdownEl.innerText = timeLeft;

            const interval = setInterval(() => {
                timeLeft--;
                countdownEl.innerText = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(interval);

                    // Hilangkan overlay
                    overlay.classList.add("hidden");

                    // Jalankan game
                    if (onFinish) onFinish();
                }
            }, 1000);
        }
        // end waktu sebelum mulai
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
            } else if (type === "voice-success") {
                osc.type = "square";
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.15);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.4,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.4);
            }
        }

        // --- Data Permainan ---
        const rounds = [{
                target: "A",
                speechSound: "A",
                options: ["A", "B", "E"]
            },
            {
                target: "I",
                speechSound: "I",
                options: ["I", "U", "O"]
            },
            {
                target: "B",
                speechSound: "B",
                options: ["B", "D", "P"]
            },
            {
                target: "M",
                speechSound: "M",
                options: ["M", "N", "W"]
            },
            {
                target: "S",
                speechSound: "S",
                options: ["S", "C", "T"]
            },
        ];

        const colorPalettes = [{
                bg: "bg-red-400",
                border: "border-red-200",
                shadow: "shadow-[0_10px_0_#991b1b]",
            },
            {
                bg: "bg-green-400",
                border: "border-green-200",
                shadow: "shadow-[0_10px_0_#166534]",
            },
            {
                bg: "bg-yellow-400",
                border: "border-yellow-200",
                shadow: "shadow-[0_10px_0_#b45309]",
            },
            {
                bg: "bg-purple-400",
                border: "border-purple-200",
                shadow: "shadow-[0_10px_0_#581c87]",
            },
            {
                bg: "bg-pink-400",
                border: "border-pink-200",
                shadow: "shadow-[0_10px_0_#9d174d]",
            },
        ];

        let currentRound = 0;
        let isAnimating = false;
        let currentState = "GUESSING";

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];
        let assessment = {
            literasi: 0,
            logika: 0,
            visual: 0
        };

        const phaseGuess = document.getElementById("phase-guess");
        const phaseVoice = document.getElementById("phase-voice");
        const optionsContainer = document.getElementById("options-container");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const voiceFeedback = document.getElementById("voice-feedback");
        const recognizedTextDisplay = document.getElementById("recognized-text");

        let recognition = null;
        let isListening = false;
        let voiceRetryTimeout = null;

        // --- Variabel Visualizer ---
        let visualizerStream = null;
        let visualizerContext = null;
        let visualizerFrameId = null;

        function updateXPBar(tempRoundOffset = 0) {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress =
                ((currentRound + tempRoundOffset) / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function playCurrentLetterSound() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.speechSound);
            utterance.lang = "id-ID";
            utterance.rate = 0.8;
            window.speechSynthesis.speak(utterance);
        }

        function renderRound() {
            const round = rounds[currentRound];
            currentState = "GUESSING";

            phaseVoice.classList.add("hidden");
            phaseVoice.classList.remove("flex");
            phaseGuess.classList.remove("hidden");
            phaseGuess.classList.add("flex");

            owlMessage.innerText = "Klik ikon speaker lalu pilih huruf yang tepat!";
            optionsContainer.innerHTML = "";

            const shuffledOptions = [...round.options].sort(
                () => Math.random() - 0.5,
            );

            shuffledOptions.forEach((letter, index) => {
                const btn = document.createElement("div");
                const palette = colorPalettes[index % colorPalettes.length];

                btn.id = `btn-${letter}`;
                btn.className =
                    `option-btn relative w-32 h-40 md:w-36 md:h-44 rounded-3xl flex items-center justify-center border-4 transition-all duration-300 cursor-pointer text-white font-black text-6xl md:text-7xl ${palette.bg} ${palette.border} ${palette.shadow}`;

                btn.addEventListener(
                    "mouseenter",
                    () =>
                    !isAnimating &&
                    btn.classList.add("scale-105", "animate-bounce-slight"),
                );
                btn.addEventListener(
                    "mouseleave",
                    () =>
                    !isAnimating &&
                    btn.classList.remove("scale-105", "animate-bounce-slight"),
                );
                btn.addEventListener("click", () => handleSelection(letter));

                btn.innerHTML = `<span class="drop-shadow-lg pointer-events-none">${letter}</span>`;
                optionsContainer.appendChild(btn);
            });

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

            setTimeout(playCurrentLetterSound, 500);
            isAnimating = false;
        }

        function handleSelection(selectedLetter) {
            if (isAnimating || currentState !== "GUESSING") return;
            isAnimating = true;

            const round = rounds[currentRound];
            const btn = document.getElementById(`btn-${selectedLetter}`);

            if (selectedLetter === round.target) {
                playSound("success");
                btn.classList.add("animate-glow-gold");
                owlMessage.innerText = "Pintar! Sekarang kita berlatih mengucapkan.";
                confetti({
                    particleCount: 30,
                    spread: 40,
                    origin: {
                        y: 0.6
                    }
                });

                setTimeout(() => {
                    startVoicePhase();
                }, 1500);
            } else {
                playSound("error");
                btn.classList.add(
                    "animate-shake",
                    "!bg-red-400",
                    "!border-red-500",
                    "!shadow-[0_10px_0_#991b1b]",
                );
                owlMessage.innerText = "Ups, kurang tepat!";

                const correctBtn = document.getElementById(`btn-${round.target}`);
                if (correctBtn)
                    correctBtn.classList.add(
                        "animate-pulse",
                        "!bg-green-400",
                        "!border-green-500",
                    );

                mistakesMade++;
                roundResults.push("wrong");
                updateXPBar(1);

                setTimeout(() => {
                    currentRound++;
                    if (currentRound < rounds.length) {
                        renderRound();
                    } else {
                        showVictory();
                    }
                }, 1800);
            }
            if (selectedLetter === round.target) {
                assessment.literasi += 2; // kenal huruf
                assessment.logika += 1; // keputusan benar
                assessment.visual += 1; // respon visual
            } else {
                assessment.logika -= 1;
                assessment.visual -= 1;
            }
        }

        // --- FUNGSI AUDIO VISUALIZER ---
        async function startAudioVisualizer() {
            const container = document.getElementById("audio-visualizer-container");
            container.classList.remove("hidden");
            container.classList.add("flex");

            try {
                if (!visualizerStream) {
                    visualizerStream = await navigator.mediaDevices.getUserMedia({
                        audio: true,
                    });
                }
                if (!visualizerContext) {
                    visualizerContext = new(
                        window.AudioContext || window.webkitAudioContext
                    )();
                }
                if (visualizerContext.state === "suspended") {
                    visualizerContext.resume();
                }

                const analyser = visualizerContext.createAnalyser();
                const source =
                    visualizerContext.createMediaStreamSource(visualizerStream);
                source.connect(analyser);
                analyser.fftSize = 256;
                const bufferLength = analyser.frequencyBinCount;
                const dataArray = new Uint8Array(bufferLength);

                const audioBar = document.getElementById("audio-bar");

                function updateVisualizer() {
                    if (currentState !== "VOICE") return; // Berhenti menggambar jika bukan fase voice

                    analyser.getByteFrequencyData(dataArray);
                    let sum = 0;
                    for (let i = 0; i < bufferLength; i++) {
                        sum += dataArray[i];
                    }
                    let average = sum / bufferLength;
                    // Normalisasi tinggi (dikalikan 2 agar lebih responsif)
                    let height = Math.min(100, average * 2);
                    audioBar.style.height = height + "%";

                    // Ubah warna berdasarkan intensitas suara
                    if (height > 60) {
                        audioBar.className =
                            "w-full bg-red-500 transition-all duration-75";
                    } else if (height > 30) {
                        audioBar.className =
                            "w-full bg-yellow-400 transition-all duration-75";
                    } else {
                        audioBar.className =
                            "w-full bg-green-400 transition-all duration-75";
                    }

                    visualizerFrameId = requestAnimationFrame(updateVisualizer);
                }
                updateVisualizer();
            } catch (err) {
                console.error("Gagal mengakses mikrofon untuk visualizer:", err);
            }
        }

        function stopAudioVisualizer() {
            const container = document.getElementById("audio-visualizer-container");
            container.classList.add("hidden");
            container.classList.remove("flex");

            if (visualizerFrameId) cancelAnimationFrame(visualizerFrameId);
            // Kita biarkan stream tetap menyala untuk ronde berikutnya agar tidak perlu request permission ulang
        }

        // --- SISTEM PENGENALAN SUARA (VOICE RECOGNITION) ---
        function startVoicePhase() {
            currentState = "VOICE";
            isAnimating = false;

            phaseGuess.classList.add("hidden");
            phaseGuess.classList.remove("flex");
            phaseVoice.classList.remove("hidden");
            phaseVoice.classList.add("flex");

            // Nyalakan Visualizer Kiri
            startAudioVisualizer();

            const round = rounds[currentRound];
            document.getElementById("target-letter-display").innerText =
                round.target;
            voiceFeedback.innerText = "Mendengarkan... Ayo ucapkan hurufnya beberapa kali!";
            voiceFeedback.className = "text-lg font-bold text-blue-600 mb-2";
            recognizedTextDisplay.innerText = ""; // Bersihkan teks sebelumnya
            owlMessage.innerText = `Ayo ucapkan huruf "${round.target}" dengan lantang!`;

            window.SpeechRecognition =
                window.SpeechRecognition || window.webkitSpeechRecognition;
            if (window.SpeechRecognition) {
                if (recognition) {
                    try {
                        recognition.abort();
                    } catch (e) {}
                }
                recognition = new SpeechRecognition();
                recognition.lang = "id-ID";
                recognition.interimResults = false;
                recognition.continuous = true;
                recognition.maxAlternatives = 1;

                recognition.onstart = () => {
                    isListening = true;
                    document
                        .getElementById("mic-pulse")
                        .classList.add("animate-pulse-ring");
                    voiceFeedback.innerText = "Mendengarkan... Ayo ucapkan hurufnya beberapa kali!";
                    voiceFeedback.className = "text-lg font-bold text-blue-600 mb-2";
                    recognizedTextDisplay.innerText = "";
                };

                recognition.onresult = (event) => {
                    if (currentState !== "VOICE") return;

                    const transcript = event.results[0][0].transcript
                        .toLowerCase()
                        .trim();

                    // DEBUG
                    console.log("Speech detected:", transcript);
                    console.log("Raw result:", event.results);

                    recognizedTextDisplay.innerText = `Kata yang kamu ucapkan: "${transcript}"`;

                    checkPronunciation(transcript, round.target);
                };

                recognition.onerror = (event) => {
                    // Cegah spam error di console
                    if (event.error !== "no-speech" && event.error !== "aborted") {
                        console.warn("Mic error:", event.error);
                    }

                    if (currentState !== "VOICE") return;

                    if (event.error === "not-allowed") {
                        voiceFeedback.innerText = "Izin mikrofon ditolak.";
                        voiceFeedback.className = "text-lg font-bold text-red-500 mb-2";
                        document
                            .getElementById("mic-pulse")
                            .classList.remove("animate-pulse-ring");
                    } else if (event.error === "no-speech") {
                        // Jika anak diam saja, beri tahu lalu restart diam-diam
                        voiceFeedback.innerText =
                            "Sedang mendengarkan... (Cek bar di kiri)";
                        voiceFeedback.className =
                            "text-lg font-bold text-orange-500 mb-2";
                    } else if (event.error === "aborted") {
                        // Abort normal saat restart
                    } else {
                        voiceFeedback.innerText = "Tekan tombol lewati jika kesulitan.";
                        voiceFeedback.className = "text-lg font-bold text-red-500 mb-2";
                    }
                };

                recognition.onend = () => {
                    isListening = false;

                    document
                        .getElementById("mic-pulse")
                        .classList.remove("animate-pulse-ring");

                    if (currentState === "VOICE") {
                        voiceFeedback.innerText = "Tekan mic lalu ucapkan huruf";
                        voiceFeedback.className = "text-lg font-bold text-blue-600 mb-2";
                    }
                };

                try {
                    recognition.start();
                } catch (e) {}
            } else {
                voiceFeedback.innerText =
                    "Browser tidak mendukung suara. Silakan tekan lewati.";
                voiceFeedback.className = "text-lg font-bold text-orange-500 mb-2";
            }
        }

        const micBtn = document.getElementById("btn-mic");
        micBtn.onclick = () => {
            if (!isListening && recognition && currentState === "VOICE") {
                clearTimeout(voiceRetryTimeout);
                voiceRetryTimeout = null;
                voiceFeedback.innerText = "Mendengarkan... Ayo ucapkan!";
                voiceFeedback.className = "text-lg font-bold text-blue-600 mb-2";
                recognizedTextDisplay.innerText = "";
                try {
                    recognition.start();
                } catch (e) {}
            }
        };

        function checkPronunciation(spokenText, targetLetter) {
            clearTimeout(voiceRetryTimeout);
            voiceRetryTimeout = null;

            const validMap = {
                A: ["a", "aa", "ah", "ha"],
                I: ["i", "ii", "ih", "hi"],
                B: ["b", "be", "beh", "bi", "de"],
                M: ["m", "em", "eum", "ma", "am"],
                S: ["s", "es", "ess", "sa", "as"],
            };

            const validOptions = validMap[targetLetter] || [
                targetLetter.toLowerCase(),
            ];
            const isCorrect = validOptions.some((opt) => spokenText.includes(opt));

            if (isCorrect) {
                successVoicePhase();
            } else {
                playSound("error");
                voiceFeedback.innerText = "Coba lagi!";
                voiceFeedback.className = "text-lg font-bold text-red-500 mb-2";

                voiceRetryTimeout = setTimeout(() => {
                    voiceRetryTimeout = null;
                    if (currentState === "VOICE" && !isListening) {
                        voiceFeedback.innerText = "Mendengarkan... Ayo ucapkan!";
                        voiceFeedback.className = "text-lg font-bold text-blue-600 mb-2";
                        recognizedTextDisplay.innerText = "";
                        try {
                            setTimeout(() => {
                                try {
                                    recognition.start();
                                } catch (e) {}
                            }, 500);
                        } catch (e) {}
                    }
                }, 2000);
            }
        }

        function successVoicePhase() {
            currentState = "SUCCESS";
            clearTimeout(voiceRetryTimeout);
            voiceRetryTimeout = null;
            assessment.literasi += 3; // kemampuan mengucapkan
            assessment.visual += 1; // mengikuti instruksi

            // Matikan visualizer
            stopAudioVisualizer();

            if (recognition) {
                try {
                    recognition.abort();
                } catch (e) {}
            }
            document
                .getElementById("mic-pulse")
                .classList.remove("animate-pulse-ring");

            playSound("voice-success");
            voiceFeedback.innerText = "Bagus sekali!";
            voiceFeedback.className =
                "text-xl font-black text-green-500 mb-2 animate-bounce-slight";
            owlMessage.innerText = "Wah, suaramu sangat lantang!";
            confetti({
                particleCount: 50,
                spread: 60,
                origin: {
                    y: 0.5
                }
            });

            xp += 5;
            levelEarnedXP += 5;
            correctAnswersCount++;
            roundResults.push("correct");
            updateXPBar(1);

            setTimeout(() => {
                currentRound++;
                if (currentRound < rounds.length) {
                    renderRound();
                } else {
                    showVictory();
                }
            }, 2000);
        }

        function skipVoicePhase() {
            // Fungsi jika mic bermasalah, anak tetap bisa lanjut main
            successVoicePhase();
        }

        function showVictory() {
            currentState = "VICTORY";
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 20;
            const flawlessBonusXP = mistakesMade === 0 ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;
            document.getElementById("xp-text").innerText = `${xp} XP`;

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Tidak apa-apa salah, kamu pasti bisa lebih baik!";

            if (mistakesMade === 0) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Kamu Penjelajah Hebat!";
            } else if (mistakesMade <= 1) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Hebat! Kamu hampir sempurna!";
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

            // === TAMPILKAN NILAI ===
            document.getElementById("score-literasi").innerText = assessment.literasi;
            document.getElementById("score-logika").innerText = assessment.logika;
            document.getElementById("score-visual").innerText = assessment.visual;

            // === HITUNG PERSENTASE (biar jadi bar) ===
            const maxScore = 20; // sesuaikan

            const barLiterasi = document.getElementById("bar-literasi");
            const barLogika = document.getElementById("bar-logika");
            const barVisual = document.getElementById("bar-visual");

            if (barLiterasi) {
                barLiterasi.style.width =
                    Math.min((assessment.literasi / maxScore) * 100, 100) + "%";
            }

            if (barLogika) {
                barLogika.style.width =
                    Math.min((assessment.logika / maxScore) * 100, 100) + "%";
            }

            if (barVisual) {
                barVisual.style.width =
                    Math.min((assessment.visual / maxScore) * 100, 100) + "%";
            }
            overlay.classList.remove("hidden");
            overlay.classList.add("flex");
            modal.classList.add("animate-pop-in");

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
                    colors: ["#26ccff", "#a25afd", "#ff5e7e", "#88ff5a", "#fcff42"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#26ccff", "#a25afd", "#ff5e7e", "#88ff5a", "#fcff42"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();
            console.log("XP:", xp);
            console.log("Correct:", correctAnswersCount);
        }

        // --- SISTEM PELACAKAN TANGAN & KURSOR ---
        const videoElement = document.getElementById("input_video");
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let hoveredButtonId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_CLICK = 1000;

        function updateCursorUI(timestamp) {
            cursorX += (targetX - cursorX) * 0.7;
            cursorY += (targetY - cursorY) * 0.7;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            let btnHovered = null;
            const interactableElements = document.querySelectorAll(".option-btn");

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

            // Pastikan hanya mendeteksi tombol yang relevan dengan fase yang sedang aktif
            let isValidHover = false;
            if (btnHovered && !isAnimating) {
                const isMicBtn = btnHovered.id === "btn-mic";
                if (
                    (currentState === "GUESSING" && !isMicBtn) ||
                    (currentState === "VOICE" && isMicBtn)
                ) {
                    isValidHover = true;
                }
            }

            if (isValidHover) {
                const currentId = btnHovered.id.replace("btn-", "");

                cursorEmoji.innerText = "👆";
                cursorEmoji.style.transform = "scale(1.2)";

                if (hoveredButtonId === currentId) {
                    if (!hoverStartTime) hoverStartTime = timestamp;
                    const elapsed = timestamp - hoverStartTime;

                    const percentage = Math.min(elapsed / HOVER_DURATION_TO_CLICK, 1);
                    cursorProgress.style.strokeDashoffset = 226.2 * (1 - percentage);

                    if (elapsed >= HOVER_DURATION_TO_CLICK) {
                        if (currentId === "speaker") {
                            playCurrentLetterSound();
                            hoveredButtonId = null;
                            hoverStartTime = timestamp + 1000;
                        } else if (currentId === "mic") {
                            if (!isListening && recognition && currentState === "VOICE") {
                                clearTimeout(voiceRetryTimeout);
                                voiceRetryTimeout = null;
                                try {
                                    recognition.start();
                                } catch (e) {}
                            }
                            hoveredButtonId = null;
                            hoverStartTime = timestamp + 1000;
                        } else {
                            handleSelection(currentId);
                        }
                        cursorProgress.style.strokeDashoffset = 226.2;
                    }
                } else {
                    hoveredButtonId = currentId;
                    hoverStartTime = timestamp;
                    interactableElements.forEach((b) =>
                        b.classList.remove("scale-105", "animate-bounce-slight"),
                    );
                    btnHovered.classList.add("scale-105", "animate-bounce-slight");
                }
            } else {
                cursorEmoji.innerText = "🖐️";
                cursorEmoji.style.transform = "scale(1)";

                if (hoveredButtonId) {
                    const oldBtn = document.getElementById(`btn-${hoveredButtonId}`);
                    if (oldBtn)
                        oldBtn.classList.remove("scale-105", "animate-bounce-slight");
                }
                hoveredButtonId = null;
                hoverStartTime = 0;
                cursorProgress.style.strokeDashoffset = 226.2;
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

        document.addEventListener("mousemove", (e) => {
            cursorElement.style.opacity = "1";
            targetX = e.clientX;
            targetY = e.clientY;
            cursorX = e.clientX;
            cursorY = e.clientY;
        });

        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            requestAnimationFrame(updateCursorUI);
            initCamera();

            // MULAI COUNTDOWN DULU
            startCountdown(8, () => {
                renderRound();
            });
        });
    </script>
</body>

</html>
