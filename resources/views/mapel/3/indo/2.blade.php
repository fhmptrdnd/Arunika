<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Indonesia Kelas 3 - Level 2: Detektif Ide Pokok</title>
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
                transform: translateX(-8px);
            }

            40%,
            80% {
                transform: translateX(8px);
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
                    0 0 35px 15px rgba(250, 204, 21, 1),
                    0 8px 0 #b45309;
                transform: scale(1.02);
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
                transform: perspective(1200px) rotateY(0deg);
                opacity: 1;
            }

            50% {
                transform: perspective(1200px) rotateY(-90deg);
                opacity: 0.5;
                filter: brightness(0.8);
            }

            100% {
                transform: perspective(1200px) rotateY(0deg);
                opacity: 1;
            }
        }

        .animate-turn-page {
            animation: turn-page 0.8s ease-in-out forwards;
            transform-origin: left center;
        }

        /* Animasi Kaca Pembesar (Lup) Bekerja */
        @keyframes magnify-scan {
            0% {
                filter: drop-shadow(0 0 5px rgba(250, 204, 21, 0.5));
            }

            50% {
                filter: drop-shadow(0 0 20px rgba(250, 204, 21, 1)) brightness(1.2);
            }

            100% {
                filter: drop-shadow(0 0 5px rgba(250, 204, 21, 0.5));
            }
        }

        /* Kursor Kamera Tangan */
        #hand-cursor {
            position: absolute;
            width: 90px;
            height: 90px;
            pointer-events: none;
            z-index: 1000;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.15s ease-out;
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
                inset 20px 0 30px -20px rgba(0, 0, 0, 0.08),
                inset -20px 0 30px -20px rgba(0, 0, 0, 0.08);
        }

        .book-spine {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 30px;
            transform: translateX(-50%);
            background: linear-gradient(to right,
                    transparent,
                    rgba(0, 0, 0, 0.08) 50%,
                    transparent);
            z-index: 0;
        }

        /* Kartu Kalimat (Sentence Cards) */
        .sentence-card {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .sentence-card.hover-highlight {
            transform: scale(1.02) translateX(10px);
            box-shadow: 0 8px 20px -5px rgba(250, 204, 21, 0.5);
            border-color: #fcd34d;
            background-color: #fffbeb;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-200 via-sky-100 to-amber-100 h-screen w-full relative overflow-hidden">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute inset-0 w-full h-full">
            <circle class="progress-ring__circle" stroke="#f59e0b" stroke-width="8" fill="transparent" r="38"
                cx="45" cy="45" stroke-dasharray="238.7" stroke-dashoffset="238.7" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji"
            style="
          font-size: 3.5rem;
          filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
          transition: all 0.2s;
        ">
            🔍
        </div>
    </div>

    <!-- --- SCENERY BACKGROUND (MAGICAL DETECTIVE THEME) --- -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Ornamen Ruang Baca Klasik -->
        <div class="absolute top-[10%] left-[5%] text-6xl opacity-30 animate-float">
            ☁️
        </div>
        <div class="absolute top-[25%] right-[10%] text-5xl opacity-40 animate-float" style="animation-delay: 1s">
            ✨
        </div>
        <div class="absolute top-[40%] left-[15%] text-4xl opacity-30 animate-float" style="animation-delay: 2s">
            ✨
        </div>

        <div
            class="absolute bottom-0 w-full h-[30vh] bg-amber-900/10 rounded-t-[100%] scale-x-150 transform translate-y-12 backdrop-blur-[2px]">
        </div>

        <div class="absolute bottom-[20%] left-[8%] text-8xl drop-shadow-md opacity-80">
            📚
        </div>
        <div class="absolute bottom-[15%] right-[10%] text-9xl drop-shadow-md opacity-80">
            🪴
        </div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/80 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg pointer-events-auto">
            <div
                class="w-12 h-12 md:w-14 md:h-14 bg-indigo-500 rounded-full border-2 border-white flex items-center justify-center text-2xl md:text-3xl shadow-inner">
                🕵️‍♂️
            </div>
            <div>
                <h2 class="font-black text-lg md:text-xl text-indigo-900 tracking-wide drop-shadow-sm">
                    Penjelajah Level 3
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-3 h-3 md:w-4 md:h-4 fill-current"></i>
                    <i data-lucide="star" class="w-3 h-3 md:w-4 md:h-4 text-gray-300"></i>
                    <i data-lucide="star" class="w-3 h-3 md:w-4 md:h-4 text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-white/80 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-indigo-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-40 h-4 bg-indigo-900/20 rounded-full overflow-hidden shadow-inner border border-indigo-200">
                    <div id="xp-bar-fill"
                        class="h-full bg-gradient-to-r from-amber-400 to-yellow-400 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-indigo-300 mb-2 max-w-[200px]">
                    <p id="owl-message" class="font-bold text-indigo-800 text-sm">
                        Pahami paragrafnya, lalu kita cari ide pokoknya!
                    </p>
                </div>
                <div class="text-5xl md:text-6xl drop-shadow-[0_10px_10px_rgba(0,0,0,0.3)]">
                    🦉
                </div>
            </div>

            <div
                class="bg-slate-800 p-2 rounded-xl border-4 border-slate-600 shadow-xl flex flex-col items-center w-24 h-20 md:w-28 md:h-24 relative overflow-hidden">
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
    <div
        class="absolute inset-0 top-20 md:top-24 bottom-4 z-10 flex flex-col items-center justify-center pointer-events-none px-2">
        <div class="text-center mb-1 shrink-0 pointer-events-auto z-20">
            <h1
                class="text-xl md:text-2xl font-black text-indigo-900 bg-white/95 backdrop-blur-sm px-6 py-1.5 rounded-full border-4 border-indigo-300 shadow-md inline-block">
                Temukan Ide Pokok!
            </h1>
        </div>

        <!-- BUKU CERITA (STORYBOOK) -->
        <div id="storybook-container"
            class="bg-[#fdfbf7] storybook-shadow p-4 md:p-6 lg:p-8 rounded-3xl border-[8px] md:border-[10px] border-amber-800 w-full max-w-6xl h-[75vh] md:h-[80vh] min-h-[450px] max-h-[700px] flex flex-col pointer-events-auto relative mt-2 transform transition-transform duration-500">
            <!-- Tulang Punggung Buku (Spine) -->
            <div class="book-spine hidden md:block"></div>

            <!-- --- FASE 1: MEMBACA (READING) --- -->
            <div id="phase-reading" class="w-full h-full flex flex-col md:flex-row gap-4 relative z-10">
                <!-- Halaman Kiri (Teks Paragraf) -->
                <div class="flex-1 flex flex-col p-2 md:pr-6 relative">
                    <div class="flex justify-between items-center mb-3 border-b-4 border-amber-200 pb-2 shrink-0">
                        <h2 class="font-black text-lg md:text-xl text-amber-900 bg-amber-100 px-4 py-1 rounded-full">
                            Baca Paragraf Ini
                        </h2>
                        <!-- Timer -->
                        <div
                            class="bg-indigo-50 px-3 py-1.5 rounded-full border-2 border-indigo-200 shadow-inner flex items-center gap-2">
                            <i data-lucide="clock" class="text-indigo-600 w-4 h-4"></i>
                            <span id="timer-display" class="font-black text-lg text-indigo-800">40</span>
                        </div>
                    </div>

                    <div
                        class="flex flex-col md:flex-row gap-4 bg-white p-4 md:p-6 rounded-2xl border-2 border-gray-100 shadow-sm flex-1 overflow-hidden relative">
                        <!-- Tombol Speaker -->
                        <button onclick="readStoryAloud()"
                            class="bg-indigo-100 hover:bg-indigo-200 p-3 rounded-full border-2 border-indigo-300 shadow-sm transition-colors shrink-0 h-fit self-start md:self-auto z-10">
                            <i data-lucide="volume-2" class="text-indigo-600 w-5 h-5 md:w-6 md:h-6"></i>
                        </button>
                        <!-- Teks Paragraf -->
                        <div class="flex-1 flex items-center">
                            <p id="story-text"
                                class="font-story text-lg md:text-2xl text-gray-800 leading-snug md:leading-relaxed tracking-wide w-full">
                                <!-- Teks dirender JS -->
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Garis Pemisah Buku (hanya di Desktop) -->
                <div
                    class="hidden md:block w-px bg-gradient-to-b from-transparent via-amber-900/20 to-transparent mx-1">
                </div>

                <!-- Halaman Kanan (Ilustrasi & Navigasi) -->
                <div class="flex-1 flex flex-col items-center justify-center p-2 md:pl-6 relative">
                    <!-- Ilustrasi Tema -->
                    <div
                        class="w-full max-w-[240px] md:max-w-[280px] bg-amber-50 rounded-[2rem] border-4 border-amber-200 shadow-md p-6 flex flex-col items-center text-center relative overflow-hidden mb-6 shrink-0">
                        <div id="story-illustration"
                            class="text-[5rem] md:text-[6rem] drop-shadow-xl relative z-10 animate-float">
                            🏡🌻
                        </div>
                    </div>

                    <button onclick="skipReading()"
                        class="bg-indigo-500 hover:bg-indigo-400 text-white text-lg md:text-xl font-black py-3 px-8 rounded-full shadow-[0_6px_0_#312e81] hover:shadow-[0_3px_0_#312e81] hover:translate-y-1 transition-all flex items-center gap-2 shrink-0">
                        <i data-lucide="search" class="w-5 h-5"></i> Cari Ide Pokok
                    </button>
                </div>
            </div>

            <!-- --- FASE 2: PERTANYAAN IDE POKOK (QUESTIONS) --- -->
            <div id="phase-questions" class="w-full h-full flex flex-col relative z-10 hidden">
                <div class="text-center mb-3 pt-1 shrink-0">
                    <h2
                        class="font-black text-lg md:text-2xl text-indigo-900 tracking-wide px-4 leading-tight bg-indigo-100 border-2 border-indigo-200 inline-block py-1.5 rounded-full shadow-sm">
                        Kalimat manakah yang merupakan ide pokok?
                    </h2>
                    <p class="text-amber-700 font-bold mt-1.5 text-sm md:text-base">
                        <i data-lucide="search" class="w-4 h-4 inline relative -top-0.5"></i>
                        Arahkan Kaca Pembesar ke kalimat yang paling penting!
                    </p>
                </div>

                <!-- Opsi Jawaban (Kartu Kalimat) -->
                <div id="options-container"
                    class="flex flex-col justify-center items-center gap-3 w-full flex-1 px-2 md:px-8 mt-1">
                    <!-- Kalimat dirender di sini -->
                </div>

                <!-- Indikator Progres Pertanyaan -->
                <div class="flex justify-center gap-3 mt-4 mb-2 shrink-0" id="progress-dots">
                    <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                    <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                    <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                    <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                    <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
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
                osc.frequency.setValueAtTime(400, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    150,
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
            } else if (type === "scan") {
                // Bunyi Lup Bekerja (Ticking)
                osc.type = "sine";
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    1000,
                    audioCtx.currentTime + 0.05,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.05, audioCtx.currentTime + 0.02);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.05,
                );
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
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.8,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.8);
            }
        }

        // --- Data Permainan (Menemukan Ide Pokok - Kelas 3) ---
        const rounds = [{
                para: "Setiap pagi Rudi membantu ibunya menyiram tanaman di halaman. Ia sangat suka merawat bunga dan pohon kecil. Tanaman di halaman rumah Rudi selalu terlihat segar.",
                illustration: "🏡🌻",
                sentences: [{
                        id: "s1",
                        text: "Setiap pagi Rudi membantu ibunya menyiram tanaman di halaman.",
                        isCorrect: true,
                    },
                    {
                        id: "s2",
                        text: "Ia sangat suka merawat bunga dan pohon kecil.",
                        isCorrect: false,
                    },
                    {
                        id: "s3",
                        text: "Tanaman di halaman rumah Rudi selalu terlihat segar.",
                        isCorrect: false,
                    },
                ],
            },
            {
                para: "Di sekolah, Sinta sangat rajin membaca buku. Ia sering pergi ke perpustakaan saat waktu istirahat. Karena itu, Sinta memiliki banyak pengetahuan.",
                illustration: "📚🏫",
                sentences: [{
                        id: "s1",
                        text: "Di sekolah, Sinta sangat rajin membaca buku.",
                        isCorrect: true,
                    },
                    {
                        id: "s2",
                        text: "Ia sering pergi ke perpustakaan saat waktu istirahat.",
                        isCorrect: false,
                    },
                    {
                        id: "s3",
                        text: "Karena itu, Sinta memiliki banyak pengetahuan.",
                        isCorrect: false,
                    },
                ],
            },
            {
                para: "Budi suka bermain sepak bola dengan teman-temannya. Setiap sore mereka bermain di lapangan dekat rumah. Budi merasa senang ketika bermain bersama teman.",
                illustration: "⚽👦",
                sentences: [{
                        id: "s1",
                        text: "Setiap sore mereka bermain di lapangan dekat rumah.",
                        isCorrect: false,
                    },
                    {
                        id: "s2",
                        text: "Budi suka bermain sepak bola dengan teman-temannya.",
                        isCorrect: true,
                    },
                    {
                        id: "s3",
                        text: "Budi merasa senang ketika bermain bersama teman.",
                        isCorrect: false,
                    },
                ],
            },
            {
                para: "Makan sayur dan buah membuat tubuh kita sehat. Sayuran mengandung banyak vitamin yang baik. Tubuh yang sehat membuat kita tidak mudah sakit.",
                illustration: "🥗🍎",
                sentences: [{
                        id: "s1",
                        text: "Sayuran mengandung banyak vitamin yang baik.",
                        isCorrect: false,
                    },
                    {
                        id: "s2",
                        text: "Tubuh yang sehat membuat kita tidak mudah sakit.",
                        isCorrect: false,
                    },
                    {
                        id: "s3",
                        text: "Makan sayur dan buah membuat tubuh kita sehat.",
                        isCorrect: true,
                    },
                ],
            },
            {
                para: "Warga desa bergotong royong membersihkan selokan. Mereka bekerja bersama-sama agar lingkungan bersih. Pekerjaan menjadi lebih cepat selesai karena dilakukan bersama.",
                illustration: "🧹🏘️",
                sentences: [{
                        id: "s1",
                        text: "Pekerjaan menjadi lebih cepat selesai karena dilakukan bersama.",
                        isCorrect: false,
                    },
                    {
                        id: "s2",
                        text: "Warga desa bergotong royong membersihkan selokan.",
                        isCorrect: true,
                    },
                    {
                        id: "s3",
                        text: "Mereka bekerja bersama-sama agar lingkungan bersih.",
                        isCorrect: false,
                    },
                ],
            },
        ];

        let currentRound = 0;
        let currentPhase = "READING"; // READING, QUESTIONS, TRANSITION
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        let currentRoundXP = 10;
        let totalAnswersXP = 0;

        let readingTimerId = null;
        let timeRemaining = 40;

        // DOM Elements
        const storybookContainer = document.getElementById("storybook-container");
        const phaseReading = document.getElementById("phase-reading");
        const phaseQuestions = document.getElementById("phase-questions");
        const timerDisplay = document.getElementById("timer-display");
        const storyTextDisplay = document.getElementById("story-text");
        const storyIllustration = document.getElementById("story-illustration");
        const optionsContainer = document.getElementById("options-container");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            let progress = 0;
            if (currentPhase === "QUESTIONS") {
                progress = (currentRound / rounds.length) * 100;
            }
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        // --- PHASE 1: READING ---
        function startReadingPhase() {
            currentPhase = "READING";
            owlMessage.innerText =
                "Pahami paragraf ini baik-baik ya. Waktumu 40 detik!";

            phaseQuestions.classList.add("hidden");
            phaseReading.classList.remove("hidden");

            const round = rounds[currentRound];

            // Mengatur format teks paragraf agar jaraknya lebih pas
            // Memisahkan kalimat dengan satu baris kosong yang kecil
            let formattedPara = round.para.replace(
                /\. /g,
                '.<br><span class="block h-2 md:h-4"></span>',
            );
            storyTextDisplay.innerHTML = formattedPara;
            storyIllustration.innerText = round.illustration;

            timeRemaining = 40;
            timerDisplay.innerText = timeRemaining;

            // Reset Timer Colors
            timerDisplay.parentElement.classList.remove(
                "bg-red-100",
                "border-red-400",
            );
            timerDisplay.parentElement.classList.add(
                "bg-indigo-50",
                "border-indigo-200",
            );
            timerDisplay.classList.remove("text-red-600");
            timerDisplay.classList.add("text-indigo-800");
            document
                .querySelector('[data-lucide="clock"]')
                .classList.remove("text-red-500");
            document
                .querySelector('[data-lucide="clock"]')
                .classList.add("text-indigo-600");

            clearInterval(readingTimerId);
            readingTimerId = setInterval(() => {
                timeRemaining--;
                timerDisplay.innerText = timeRemaining;

                if (timeRemaining === 10) {
                    timerDisplay.parentElement.classList.replace(
                        "bg-indigo-50",
                        "bg-red-100",
                    );
                    timerDisplay.parentElement.classList.replace(
                        "border-indigo-200",
                        "border-red-400",
                    );
                    timerDisplay.classList.replace("text-indigo-800", "text-red-600");
                    document
                        .querySelector('[data-lucide="clock"]')
                        .classList.replace("text-indigo-600", "text-red-500");
                }

                if (timeRemaining <= 0) {
                    skipReading();
                }
            }, 1000);
        }

        function readStoryAloud() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.para);
            utterance.lang = "id-ID";
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        function skipReading() {
            if (currentPhase !== "READING") return;
            clearInterval(readingTimerId);
            window.speechSynthesis.cancel(); // Stop TTS

            transitionToQuestions();
        }

        function transitionToQuestions() {
            currentPhase = "TRANSITION";
            playSound("page-turn");

            storybookContainer.classList.add("animate-turn-page");

            setTimeout(() => {
                phaseReading.classList.add("hidden");
                phaseQuestions.classList.remove("hidden");
                storybookContainer.style.transform =
                    "perspective(1200px) rotateY(0deg)";

                renderQuestion();
            }, 400);

            setTimeout(() => {
                storybookContainer.classList.remove("animate-turn-page");
                currentPhase = "QUESTIONS";
            }, 800);
        }

        // --- PHASE 2: QUESTIONS ---
        function renderQuestion() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            owlMessage.innerText =
                "Arahkan kaca pembesar ke kalimat yang paling penting!";

            optionsContainer.innerHTML = "";

            round.sentences.forEach((opt, index) => {
                const btn = document.createElement("div");

                btn.id = `opt-${index}`;
                btn.dataset.correct = opt.isCorrect;

                // Kartu Kalimat yang lebih proporsional
                btn.className =
                    `sentence-card w-full bg-white border-4 border-gray-200 rounded-2xl p-3 md:p-4 flex items-center gap-3 cursor-pointer shadow-sm shrink-0`;

                btn.innerHTML = `
                 <div class="w-8 h-8 md:w-10 md:h-10 bg-indigo-100 rounded-full border-2 border-indigo-200 flex items-center justify-center font-black text-indigo-600 shrink-0 pointer-events-none text-base md:text-lg">${index + 1}</div>
                 <span class="font-bold text-gray-700 text-sm md:text-lg lg:text-xl pointer-events-none leading-snug md:leading-relaxed">${opt.text}</span>
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

                owlMessage.innerText = "Benar! Itu ide pokoknya.";

                const rect = btn.getBoundingClientRect();
                const x = (rect.left + rect.width / 2) / window.innerWidth;
                const y = (rect.top + rect.height / 2) / window.innerHeight;
                confetti({
                    particleCount: 50,
                    spread: 70,
                    origin: {
                        x,
                        y
                    },
                    colors: ["#facc15", "#4f46e5", "#38bdf8"],
                });

                xp += 5;
                levelEarnedXP += 5;
                correctAnswersCount++;

                updateAssessment(assessment, {
                    literasi: 2,
                    logika: 1,
                    visual: 1
                });

                if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                    roundResults.push("correct");
                }
                updateXPBar();

                setTimeout(() => {
                    currentRound++;
                    if (currentRound < rounds.length) {
                        // Efek transisi balik ke buku membaca
                        playSound("page-turn");
                        storybookContainer.classList.add("animate-turn-page");

                        setTimeout(() => {
                            startReadingPhase();
                            storybookContainer.style.transform =
                                "perspective(1200px) rotateY(0deg)";
                        }, 400);

                        setTimeout(() => {
                            storybookContainer.classList.remove("animate-turn-page");
                        }, 800);
                    } else {
                        showVictory();
                    }
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
                    "!bg-red-50",
                    "!border-red-300",
                    "!shadow-[0_4px_0_#fca5a5]",
                );
                btn
                    .querySelector("span:not(.bg-indigo-100)")
                    .classList.replace("text-gray-700", "text-red-700");

                owlMessage.innerText =
                    "Bukan yang itu. Coba ingat lagi isi seluruh paragrafnya!";

                mistakesMade++;
                if (roundResults.length < currentRound + 1)
                    roundResults.push("wrong");
                updateProgressDots();

                setTimeout(() => {
                    btn.classList.remove(
                        "animate-shake",
                        "!bg-red-50",
                        "!border-red-300",
                        "!shadow-[0_4px_0_#fca5a5]",
                    );
                    btn
                        .querySelector("span:not(.bg-indigo-100)")
                        .classList.replace("text-red-700", "text-gray-700");
                    isAnimating = false;
                }, 1000);
            }
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-4 h-4 md:w-5 md:h-5 bg-green-500 rounded-full border-2 md:border-4 border-white shadow-inner dot" :
                        "w-4 h-4 md:w-5 md:h-5 bg-red-500 rounded-full border-2 md:border-4 border-white shadow-inner dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-4 h-4 md:w-5 md:h-5 bg-yellow-400 rounded-full border-2 md:border-4 border-white shadow-lg animate-pulse dot";
                } else {
                    dot.className =
                        "w-4 h-4 md:w-5 md:h-5 bg-gray-300 rounded-full border-2 md:border-4 border-white shadow-inner dot";
                }
            });
        }

        function showVictory() {
            currentPhase = "VICTORY";
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 25;
            const isFlawlessOverall = roundResults.every((r) => r === "correct");
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;

            document.getElementById("xp-text").innerText = `${xp} XP`;
            document.getElementById("xp-bar-fill").style.width = `100%`;

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Tidak apa-apa salah, kamu pasti bisa lebih baik!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 5 && mistakesMade === 0) {
                stars = 3;
                titleText = "Detektif Sempurna!";
                descText = "Luar biasa! Pemahaman membacamu sangat tajam.";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Kamu sudah bisa menemukan ide pokok.";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-10 h-10 md:w-12 md:h-12 text-yellow-400 fill-current drop-shadow-md animate-bounce-slight" style="animation-delay: ${i * 0.1}s"></i>`;
                } else {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-10 h-10 md:w-12 md:h-12 text-gray-300 fill-current drop-shadow-sm"></i>`;
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
                    colors: ["#f59e0b", "#fbbf24", "#4f46e5", "#10b981"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#f59e0b", "#fbbf24", "#4f46e5", "#10b981"],
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
        const HOVER_DURATION_TO_CLICK = 1200;

        function updateCursorUI(timestamp) {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (currentPhase === "QUESTIONS" && !isAnimating) {
                let btnHovered = null;
                const interactableElements =
                    document.querySelectorAll(".sentence-card");

                interactableElements.forEach((btn) => {
                    const rect = btn.getBoundingClientRect();
                    const padding = 10;
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

                    cursorEmoji.innerText = "🔍";
                    cursorEmoji.style.transform = "scale(1.2)";

                    if (hoveredButtonId === currentId) {
                        if (!hoverStartTime) hoverStartTime = timestamp;
                        const elapsed = timestamp - hoverStartTime;

                        const percentage = Math.min(elapsed / HOVER_DURATION_TO_CLICK, 1);
                        cursorProgress.style.strokeDashoffset = 238.7 * (1 - percentage);

                        if (elapsed > 100 && Math.floor(elapsed) % 200 < 20)
                            playSound("scan");

                        if (elapsed >= HOVER_DURATION_TO_CLICK) {
                            handleSelection(currentId);
                            hoveredButtonId = null;
                            hoverStartTime = 0;
                            cursorProgress.style.strokeDashoffset = 238.7;
                        }
                    } else {
                        hoveredButtonId = currentId;
                        hoverStartTime = timestamp;

                        interactableElements.forEach((b) =>
                            b.classList.remove("hover-highlight"),
                        );
                        btnHovered.classList.add("hover-highlight");
                    }
                } else {
                    cursorEmoji.innerText = "🔍";
                    cursorEmoji.style.transform = "scale(1)";

                    if (hoveredButtonId) {
                        const oldBtn = document.getElementById(hoveredButtonId);
                        if (oldBtn) oldBtn.classList.remove("hover-highlight");
                    }
                    hoveredButtonId = null;
                    hoverStartTime = 0;
                    cursorProgress.style.strokeDashoffset = 238.7;
                }
            } else {
                cursorEmoji.innerText = "🔍";
                cursorEmoji.style.transform = "scale(1)";
                cursorProgress.style.strokeDashoffset = 238.7;
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

        // Dukungan Mouse untuk Testing
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
