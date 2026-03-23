@php
    $user = Auth::user();
    $id = $user->id;
@endphp

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Indonesia - Level 2: Kata & Gambar</title>
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
                    Penjelajah Level 2
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
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
                        Pilih gambar yang sesuai dengan kata!
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
            <!-- --- FASE 1: TEBAK GAMBAR --- -->
            <div id="phase-guess" class="w-full flex flex-col items-center">
                <div
                    class="bg-blue-100 text-blue-600 font-black px-6 py-2 rounded-full uppercase tracking-widest text-sm mb-4 inline-block border-2 border-blue-200">
                    Pasangkan Kata dengan Gambar!
                </div>

                <!-- Judul Kata & Speaker -->
                <div class="flex items-center justify-center gap-4 mb-6">
                    <!-- Kartu Kata Besar -->
                    <div id="word-display"
                        class="text-5xl md:text-6xl font-black text-blue-800 bg-white px-8 py-4 rounded-3xl border-4 border-blue-300 shadow-[0_8px_0_#93c5fd] tracking-wider uppercase">
                        KUCING
                    </div>

                    <!-- Ikon Speaker -->
                    <div class="flex flex-col items-center justify-center cursor-pointer option-btn w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full shadow-[0_6px_0_#1e3a8a] border-4 border-white hover:scale-110 transition-transform"
                        id="btn-speaker" onclick="playCurrentLetterSound()">
                        <i data-lucide="volume-2" class="text-white w-8 h-8 md:w-10 md:h-10 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Opsi Jawaban Gambar -->
                <div id="options-container" class="flex flex-wrap justify-center gap-6 w-full mb-6 mt-2">
                    <!-- Di-render oleh JS -->
                </div>
            </div>

            <!-- --- FASE 2: UCAPKAN (MICROPHONE) --- -->
            <div id="phase-voice" class="w-full flex-col items-center justify-center hidden pt-6">
                <h2 class="text-3xl font-black text-gray-800 mb-2">Hebat!</h2>
                <p class="text-xl text-gray-500 font-bold mb-6">
                    Sekarang giliranmu ucapkan kata
                    <span id="target-letter-display" class="text-blue-500 font-black text-3xl uppercase">KUCING</span>
                </p>

                <!-- Ikon Mic -->
                <div id="btn-mic"
                    class="option-btn w-28 h-28 bg-blue-100 rounded-full border-8 border-blue-200 flex items-center justify-center mb-6 relative cursor-pointer hover:scale-105 transition-transform">
                    <div id="mic-pulse" class="absolute inset-0 rounded-full"></div>
                    <i data-lucide="mic" class="text-blue-500 w-14 h-14 relative z-10 pointer-events-none"></i>
                </div>

                <!-- Tempat Teks Speech-to-Text -->
                <div
                    class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-4 w-full max-w-sm shadow-inner mb-4 min-h-[90px] flex items-center justify-center">
                    <p id="recognized-text" class="text-lg font-bold text-gray-600 text-center">
                        Kata yang kamu ucapkan:<br />
                        <span class="text-gray-400 text-base font-normal">Mendengarkan suaramu...</span>
                    </p>
                </div>

                <button onclick="skipVoicePhase()"
                    class="text-gray-400 underline font-bold hover:text-gray-600 z-20 mt-2">
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

            <div class="flex flex-col gap-3 mb-8 w-full z-10">
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-2xl border-2 border-gray-100">
                    <span class="font-bold text-gray-600 flex items-center gap-2"><i data-lucide="check-circle-2"
                            class="w-5 h-5 text-green-500"></i>
                        Jawaban Benar (<span id="correct-count">5</span>)</span>
                    <span class="font-black text-green-500" id="xp-answers">+25 XP</span>
                </div>

                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-2xl border-2 border-gray-100">
                    <span class="font-bold text-gray-600 flex items-center gap-2"><i data-lucide="flag"
                            class="w-5 h-5 text-blue-500"></i> Selesai
                        Level</span>
                    <span class="font-black text-green-500">+20 XP</span>
                </div>

                <div id="flawless-badge"
                    class="flex justify-between items-center bg-yellow-50 p-3 rounded-2xl border-2 border-yellow-200">
                    <span class="font-bold text-yellow-600 flex items-center gap-2"><i data-lucide="star"
                            class="w-5 h-5 text-yellow-500 fill-current"></i>
                        Bonus Sempurna!</span>
                    <span class="font-black text-yellow-500">+10 XP</span>
                </div>

                <div
                    class="mt-2 flex justify-between items-center bg-green-100 p-4 rounded-2xl border-4 border-green-300 shadow-inner">
                    <span class="font-black text-green-800 text-lg">Total XP Didapat</span>
                    <span class="font-black text-green-600 text-3xl" id="earned-xp-text">+55</span>
                </div>
            </div>

            <a href="{{ route('mapel.lainnya') }}"
                class="bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white text-2xl font-black py-4 px-12 rounded-full shadow-[0_8px_0_#15803d] hover:shadow-[0_4px_0_#15803d] hover:translate-y-1 transition-all w-full md:w-auto z-10">
                Lanjut ke Level 3
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
                        'level': '2',
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

        // --- Data Permainan (Level 2: Kata & Gambar) ---
        const rounds = [{
                word: "KUCING",
                speechSound: "kucing",
                target: "🐱",
                options: ["🐱", "🐶", "🐟"],
            },
            {
                word: "APEL",
                speechSound: "apel",
                target: "🍎",
                options: ["🍎", "🍌", "🍇"],
            },
            {
                word: "BUKU",
                speechSound: "buku",
                target: "📖",
                options: ["📖", "✏️", "🧸"],
            },
            {
                word: "BOLA",
                speechSound: "bola",
                target: "⚽",
                options: ["⚽", "🚗", "🏀"],
            },
            {
                word: "IKAN",
                speechSound: "ikan",
                target: "🐟",
                options: ["🐟", "🐔", "🐄"],
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
        let isScoreSaved = false;

        const phaseGuess = document.getElementById("phase-guess");
        const phaseVoice = document.getElementById("phase-voice");
        const optionsContainer = document.getElementById("options-container");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const recognizedTextDisplay = document.getElementById("recognized-text");
        const wordDisplay = document.getElementById("word-display");

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

            // Update Teks Kata
            wordDisplay.innerText = round.word;

            owlMessage.innerText = "Pilih gambar yang sesuai dengan kata!";
            optionsContainer.innerHTML = "";

            const shuffledOptions = [...round.options].sort(
                () => Math.random() - 0.5,
            );

            shuffledOptions.forEach((pic, index) => {
                const btn = document.createElement("div");
                const palette = colorPalettes[index % colorPalettes.length];

                btn.id = `btn-${pic}`;
                btn.className =
                    `option-btn relative w-32 h-40 md:w-36 md:h-44 rounded-3xl flex items-center justify-center border-4 transition-all duration-300 cursor-pointer text-6xl md:text-7xl ${palette.bg} ${palette.border} ${palette.shadow}`;

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
                btn.addEventListener("click", () => handleSelection(pic));

                // Emojis don't need drop shadow for text, but keeping it consistent
                btn.innerHTML = `<span class="drop-shadow-lg pointer-events-none">${pic}</span>`;
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

        function handleSelection(selectedPic) {
            if (isAnimating || currentState !== "GUESSING") return;
            isAnimating = true;

            const round = rounds[currentRound];
            const btn = document.getElementById(`btn-${selectedPic}`);

            if (selectedPic === round.target) {
                playSound("success");
                btn.classList.add("animate-glow-gold");
                owlMessage.innerText = "Pintar! Sekarang ucapkan katanya.";
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
                    if (currentState !== "VOICE") return;

                    analyser.getByteFrequencyData(dataArray);
                    let sum = 0;
                    for (let i = 0; i < bufferLength; i++) {
                        sum += dataArray[i];
                    }
                    let average = sum / bufferLength;
                    let height = Math.min(100, average * 2.5);
                    audioBar.style.height = height + "%";

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
        }

        // --- SISTEM PENGENALAN SUARA (VOICE RECOGNITION) ---
        function startVoicePhase() {
            currentState = "VOICE";
            isAnimating = false;

            phaseGuess.classList.add("hidden");
            phaseGuess.classList.remove("flex");
            phaseVoice.classList.remove("hidden");
            phaseVoice.classList.add("flex");

            startAudioVisualizer();

            const round = rounds[currentRound];
            document.getElementById("target-letter-display").innerText = round.word;

            recognizedTextDisplay.innerHTML =
                `Kata yang kamu ucapkan:<br><span class="text-gray-400 text-base font-normal">Mendengarkan suaramu...</span>`;
            owlMessage.innerText = `Ayo ucapkan kata "${round.word}" dengan lantang!`;

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
                recognition.interimResults = true;
                recognition.continuous = false;
                recognition.maxAlternatives = 1;

                recognition.onstart = () => {
                    isListening = true;
                    document
                        .getElementById("mic-pulse")
                        .classList.add("animate-pulse-ring");
                };

                recognition.onresult = (event) => {
                    if (currentState !== "VOICE") return;

                    let interimTranscript = "";
                    let finalTranscript = "";

                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            finalTranscript += event.results[i][0].transcript;
                        } else {
                            interimTranscript += event.results[i][0].transcript;
                        }
                    }

                    const currentTranscript = (finalTranscript || interimTranscript)
                        .toLowerCase()
                        .trim();
                    console.log("Mendengar:", currentTranscript);

                    if (currentTranscript) {
                        recognizedTextDisplay.innerHTML =
                            `Kata yang kamu ucapkan:<br><span class="text-blue-600 text-2xl font-black">"${currentTranscript}"</span>`;

                        const isCorrect = checkPronunciationMatch(
                            currentTranscript,
                            round.word,
                        );
                        if (isCorrect) {
                            successVoicePhase();
                        } else if (finalTranscript) {
                            failVoicePhase(finalTranscript);
                        }
                    }
                };

                recognition.onerror = (event) => {
                    if (event.error !== "no-speech" && event.error !== "aborted") {
                        console.warn("Mic error:", event.error);
                    }

                    if (currentState !== "VOICE") return;

                    if (event.error === "not-allowed") {
                        recognizedTextDisplay.innerHTML =
                            `Kata yang kamu ucapkan:<br><span class="text-red-500 text-base font-normal">Izin mikrofon ditolak!</span>`;
                        document
                            .getElementById("mic-pulse")
                            .classList.remove("animate-pulse-ring");
                    } else if (event.error === "no-speech") {
                        recognizedTextDisplay.innerHTML =
                            `Kata yang kamu ucapkan:<br><span class="text-orange-500 text-base font-normal">Tidak ada suara terdengar...</span>`;
                    } else if (event.error === "aborted") {
                        // Abort normal
                    } else {
                        recognizedTextDisplay.innerHTML =
                            `Kata yang kamu ucapkan:<br><span class="text-red-500 text-base font-normal">Terjadi kesalahan, coba lewati.</span>`;
                    }
                };

                recognition.onend = () => {
                    isListening = false;
                    document
                        .getElementById("mic-pulse")
                        .classList.remove("animate-pulse-ring");

                    if (currentState === "VOICE" && voiceRetryTimeout === null) {
                        voiceRetryTimeout = setTimeout(() => {
                            voiceRetryTimeout = null;
                            if (currentState === "VOICE" && !isListening) {
                                try {
                                    recognition.start();
                                } catch (e) {}
                            }
                        }, 1000);
                    }
                };

                try {
                    recognition.start();
                } catch (e) {}
            } else {
                recognizedTextDisplay.innerHTML =
                    `Kata yang kamu ucapkan:<br><span class="text-orange-500 text-base font-normal">Browser tidak mendukung mikrofon.</span>`;
            }
        }

        function checkPronunciationMatch(spokenText, targetWord) {
            // Sistem pencocokan fonetik untuk kata-kata
            const validMap = {
                KUCING: ["kucing", "ucing", "kucin", "cing"],
                APEL: ["apel", "apeul", "apelnya", "pel"],
                BUKU: ["buku", "bukunya", "ku"],
                BOLA: ["bola", "bolanya", "la"],
                IKAN: ["ikan", "kan"],
            };
            const validOptions = validMap[targetWord] || [targetWord.toLowerCase()];
            return validOptions.some((opt) => spokenText.includes(opt));
        }

        function failVoicePhase(spokenText) {
            playSound("error");

            if (recognition) {
                try {
                    recognition.abort();
                } catch (e) {}
            }

            clearTimeout(voiceRetryTimeout);
            voiceRetryTimeout = setTimeout(() => {
                voiceRetryTimeout = null;
                if (currentState === "VOICE" && !isListening) {
                    recognizedTextDisplay.innerHTML =
                        `Kata yang kamu ucapkan:<br><span class="text-gray-400 text-base font-normal">Coba ucapkan lagi...</span>`;
                    try {
                        recognition.start();
                        document
                            .getElementById("mic-pulse")
                            .classList.add("animate-pulse-ring");
                    } catch (e) {}
                }
            }, 2000);
        }

        const micBtn = document.getElementById("btn-mic");
        micBtn.onclick = () => {
            if (!isListening && recognition && currentState === "VOICE") {
                clearTimeout(voiceRetryTimeout);
                voiceRetryTimeout = null;
                recognizedTextDisplay.innerHTML =
                    `Kata yang kamu ucapkan:<br><span class="text-gray-400 text-base font-normal">Mendengarkan suaramu...</span>`;
                try {
                    recognition.start();
                } catch (e) {}
            }
        };

        function successVoicePhase() {
            currentState = "SUCCESS";
            clearTimeout(voiceRetryTimeout);
            voiceRetryTimeout = null;

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
            recognizedTextDisplay.innerHTML =
                `Kata yang kamu ucapkan:<br><span class="text-green-500 text-2xl font-black">Sempurna!</span>`;
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
            successVoicePhase();
        }

        function showVictory() {
            currentState = "VICTORY";

            if (isScoreSaved) return;
            isScoreSaved = true;

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
            flawlessBadge.style.display = mistakesMade === 0 ? "flex" : "none";

            document.getElementById("earned-xp-text").innerText =
                `+${levelEarnedXP}`;

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

        // document.addEventListener("DOMContentLoaded", () => {
        //     startCountdown(8, () => {
        //         renderRound();
        //     });
        //     updateXPBar();
        //     lucide.createIcons();
        //     requestAnimationFrame(updateCursorUI);
        //     initCamera();
        //     // MULAI COUNTDOWN DULU
        // });
        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            requestAnimationFrame(updateCursorUI);
            initCamera();
            startCountdown(8, () => {
                renderRound();
            });
        });
    </script>
</body>

</html>
