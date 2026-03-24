<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Matematika - Level 2: Mengurutkan Angka</title>
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

        /* Animasi Kereta Berjalan */
        @keyframes train-depart {
            0% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-20px);
            }

            /* Mundur sedikit ambil ancang-ancang */
            100% {
                transform: translateX(150vw);
            }
        }

        .animate-train-depart {
            animation: train-depart 2s ease-in forwards;
        }

        /* Styling Gerbong Kereta (Wagons) */
        .wagon-card {
            transition:
                transform 0.2s,
                box-shadow 0.2s;
            will-change: transform, left, top;
        }

        .wagon-card.hover-highlight {
            transform: scale(1.05);
            box-shadow: 0 0 20px 5px rgba(255, 255, 255, 0.8) !important;
            z-index: 30;
        }

        .wagon-card.dragging {
            position: fixed !important;
            z-index: 500;
            opacity: 0.95;
            transform: scale(1.1) rotate(-3deg) !important;
            pointer-events: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            transition: none !important;
        }

        .slot-glow {
            box-shadow:
                0 0 20px 5px rgba(74, 222, 128, 0.8),
                inset 0 0 15px rgba(74, 222, 128, 0.5);
            border-color: #4ade80 !important;
            background-color: rgba(74, 222, 128, 0.2) !important;
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

        .cursor-icon {
            font-size: 3.5rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
            transition: transform 0.1s ease-out;
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

<body class="bg-gradient-to-b from-blue-300 via-sky-200 to-green-400 h-screen w-full relative">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <div id="cursor-emoji" class="cursor-icon">🖐️</div>
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
        <!-- Bukit -->
        <div class="absolute bottom-0 w-full h-1/4 bg-green-500 rounded-t-[100%] scale-x-150 transform translate-y-12">
        </div>
        <div class="absolute bottom-[-10%] w-[120%] left-[-10%] h-1/2 bg-green-400 rounded-t-[100%] scale-x-110"></div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full">
        <div
            class="flex items-center gap-3 bg-white/60 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg">
            <div
                class="w-14 h-14 bg-orange-400 rounded-full border-4 border-white flex items-center justify-center text-3xl shadow-inner">
                👦🏽
            </div>
            <div>
                <h2 class="font-black text-xl text-orange-900 tracking-wide drop-shadow-sm">
                    Penjelajah Level 2
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <div class="hidden md:flex flex-col items-center pt-2">
            <div
                class="bg-white/70 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-orange-600 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-48 h-5 bg-orange-900/20 rounded-full overflow-hidden shadow-inner border-2 border-white/50 relative">
                    <div id="xp-bar-fill"
                        class="absolute top-0 left-0 h-full bg-gradient-to-r from-yellow-300 to-orange-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="flex items-start gap-4">
            <div class="relative hidden lg:flex flex-col items-end pt-4 animate-float">
                <div
                    class="bg-white px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-orange-200 mb-2 max-w-[240px]">
                    <p id="owl-message" class="font-bold text-orange-900 text-sm">
                        Cubit gerbong angka di bawah, lalu seret ke rel yang tepat!
                    </p>
                </div>
                <div class="text-6xl drop-shadow-lg">🦊</div>
            </div>

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

    <!-- --- MAIN GAME AREA --- -->
    <div
        class="absolute inset-x-0 top-32 bottom-4 z-10 flex flex-col items-center overflow-y-auto hide-scrollbar pb-10 pointer-events-none">
        <div class="text-center mb-8 shrink-0 pointer-events-auto">
            <div
                class="bg-white/90 backdrop-blur-sm px-8 py-3 rounded-full border-4 border-white shadow-md inline-block mb-2">
                <h1 class="text-2xl md:text-3xl font-black text-gray-800">
                    Susun Kereta Angka!
                </h1>
            </div>
            <br />
            <h3
                class="text-md md:text-lg text-orange-900 font-bold drop-shadow-md bg-white/60 px-4 py-1 rounded-full inline-block">
                Urutkan dari angka terkecil ke terbesar
            </h3>
        </div>

        <!-- AREA REL KERETA (TARGET SLOTS) -->
        <div id="train-track-container"
            class="w-full max-w-6xl flex items-end justify-center mb-16 relative pointer-events-auto">
            <!-- Garis Rel Panjang -->
            <div
                class="absolute bottom-0 w-[90%] h-4 bg-gray-400 rounded-full shadow-[0_4px_0_#4b5563] flex justify-between px-4 z-0">
                <div class="w-2 h-full bg-gray-300"></div>
                <div class="w-2 h-full bg-gray-300"></div>
                <div class="w-2 h-full bg-gray-300"></div>
                <div class="w-2 h-full bg-gray-300"></div>
                <div class="w-2 h-full bg-gray-300"></div>
                <div class="w-2 h-full bg-gray-300"></div>
            </div>

            <div id="train-assembly" class="flex items-end gap-2 md:gap-4 z-10 pb-3">
                <!-- Lokomotif Kepala Kereta -->
                <div class="text-7xl md:text-8xl drop-shadow-xl z-20 animate-bounce-slight"
                    style="transform: scaleX(-1)">
                    🚂
                </div>

                <!-- Slots Rel akan di-render di sini -->
                <div id="slots-container" class="flex gap-2 md:gap-4"></div>
            </div>
        </div>

        <!-- AREA GERBONG ACAK (WAGONS YARD) -->
        <div id="wagons-yard"
            class="flex flex-wrap justify-center gap-6 md:gap-8 w-full max-w-4xl px-4 pointer-events-auto mt-4 min-h-[120px]">
            <!-- Gerbong angka yang bisa diseret akan muncul di sini -->
        </div>

        <!-- Indikator Progres -->
        <div class="flex gap-3 mt-12 pointer-events-auto bg-white/50 backdrop-blur-md px-6 py-3 rounded-full border-2 border-white shadow-lg"
            id="progress-dots">
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
            <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot"></div>
        </div>
    </div>

    <!-- --- TUTORIAL OVERLAY --- -->
    <div id="tutorial-overlay"
        class="fixed inset-0 z-[60] bg-sky-900/80 backdrop-blur-md flex flex-col items-center justify-center pointer-events-auto">
        <div
            class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl border-8 border-orange-400 flex flex-col items-center max-w-3xl text-center animate-pop-in relative overflow-hidden mx-4">
            <div class="absolute -top-10 -right-10 text-9xl opacity-10 pointer-events-none">
                🦊
            </div>

            <h1 class="text-4xl font-black text-gray-800 mb-2">Cara Bermain</h1>
            <p class="text-lg text-gray-600 mb-8 font-bold">
                Gunakan tanganmu untuk merangkai kereta!
            </p>

            <div class="flex flex-col md:flex-row gap-4 mb-8 w-full">
                <div
                    class="flex-1 bg-orange-50 p-4 rounded-3xl border-4 border-orange-200 flex flex-col items-center text-center">
                    <div class="text-5xl mb-4 animate-bounce-slight">🤏</div>
                    <h3 class="font-black text-orange-800 text-lg">1. Cubit</h3>
                    <p class="text-sm text-orange-600 font-bold mt-1">
                        Arahkan tangan ke gerbong, lalu cubit jari telunjuk & jempolmu.
                    </p>
                </div>
                <div
                    class="flex-1 bg-blue-50 p-4 rounded-3xl border-4 border-blue-200 flex flex-col items-center text-center">
                    <div class="text-5xl mb-4 animate-float">↔️</div>
                    <h3 class="font-black text-blue-800 text-lg">2. Seret</h3>
                    <p class="text-sm text-blue-600 font-bold mt-1">
                        Tahan cubitan dan geser tanganmu membawa gerbong ke atas.
                    </p>
                </div>
                <div
                    class="flex-1 bg-green-50 p-4 rounded-3xl border-4 border-green-200 flex flex-col items-center text-center">
                    <div class="text-5xl mb-4">🖐️</div>
                    <h3 class="font-black text-green-800 text-lg">3. Lepas</h3>
                    <p class="text-sm text-green-600 font-bold mt-1">
                        Buka jarimu saat berada di atas rel yang urutannya benar.
                    </p>
                </div>
            </div>

            <button onclick="closeTutorial()"
                class="bg-orange-500 hover:bg-orange-400 text-white text-2xl font-black py-4 px-12 rounded-full shadow-[0_8px_0_#c2410c] hover:shadow-[0_4px_0_#c2410c] hover:translate-y-1 transition-all flex items-center gap-3">
                <i data-lucide="play-circle" class="w-8 h-8"></i> Ayo Mulai Merangkai!
            </button>
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
                Lanjut ke Level 3
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
                        kelas: '1',
                        level: 2,
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
        // --- Sistem Audio Sederhana (Web Audio API) ---
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
                osc.frequency.setValueAtTime(300, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    200,
                    audioCtx.currentTime + 0.1,
                );
                gain.gain.setValueAtTime(0.2, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.1,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.1);
            } else if (type === "success") {
                // Suara sekrup masuk (Click & Ding)
                osc.type = "triangle";
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                osc.frequency.setValueAtTime(1200, audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.2,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.2);
            } else if (type === "error") {
                osc.type = "sawtooth";
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
            } else if (type === "train-whistle") {
                // Suara peluit kereta (Choo Choo!)
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime); // C5
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.2); // E5
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.15, audioCtx.currentTime + 0.05);
                gain.gain.setValueAtTime(0.15, audioCtx.currentTime + 0.4);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.6,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.6);
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

        // --- Data Permainan (Mengurutkan Angka 1-20) ---
        const rounds = [{
                id: 1,
                targets: [1, 2, 3, 4, 5]
            },
            {
                id: 2,
                targets: [6, 7, 8, 9, 10]
            },
            {
                id: 3,
                targets: [11, 12, 13, 14, 15]
            },
            {
                id: 4,
                targets: [16, 17, 18, 19, 20]
            },
            {
                id: 5,
                targets: [4, 5, 6, 7, 8]
            }, // Acak di tengah untuk tantangan akhir
        ];

        // Gaya warna untuk gerbong
        const wagonGradients = [
            "from-red-400 to-red-500 shadow-[0_6px_0_#991b1b]",
            "from-blue-400 to-blue-500 shadow-[0_6px_0_#1e3a8a]",
            "from-green-400 to-green-500 shadow-[0_6px_0_#166534]",
            "from-yellow-400 to-yellow-500 shadow-[0_6px_0_#b45309]",
            "from-purple-400 to-purple-500 shadow-[0_6px_0_#581c87]",
        ];

        let currentRound = 0;
        let isGameActive = false;
        let isTransitioningRound = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        let attachedWagonsCount = 0;

        const slotsContainer = document.getElementById("slots-container");
        const wagonsYard = document.getElementById("wagons-yard");
        const owlMessage = document.getElementById("owl-message");
        const trainAssembly = document.getElementById("train-assembly");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress = (currentRound / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function closeTutorial() {
            document.getElementById("tutorial-overlay").classList.add("hidden");
            if (audioCtx.state === "suspended") audioCtx.resume();
            renderRound();
        }

        function renderRound() {
            isGameActive = true;
            isTransitioningRound = false;
            attachedWagonsCount = 0;

            trainAssembly.classList.remove("animate-train-depart");

            const round = rounds[currentRound];
            owlMessage.innerText = `Mari susun kereta angka dari yang terkecil!`;

            slotsContainer.innerHTML = "";
            wagonsYard.innerHTML = "";

            // Buat Slot (Rel Kosong)
            round.targets.forEach((num) => {
                const slot = document.createElement("div");
                slot.className =
                    "track-slot w-16 h-16 md:w-20 md:h-20 border-4 border-dashed border-white/60 rounded-xl flex items-center justify-center bg-white/20 transition-all duration-300";
                slot.dataset.target = num;
                slotsContainer.appendChild(slot);
            });

            // Buat Gerbong (Acak posisinya)
            const shuffledTargets = [...round.targets].sort(
                () => Math.random() - 0.5,
            );

            shuffledTargets.forEach((num, index) => {
                const wagonWrapper = document.createElement("div");
                wagonWrapper.className = "p-2"; // Ruang untuk hover/shadow

                const wagon = document.createElement("div");
                wagon.id = `wagon-${num}`;
                wagon.dataset.val = num;
                const gradient = wagonGradients[index % wagonGradients.length];

                // Desain Gerbong Kereta
                wagon.className =
                    `wagon-card relative w-16 h-16 md:w-20 md:h-20 rounded-t-xl rounded-b-md flex items-center justify-center text-3xl md:text-4xl font-black text-white border-2 border-white/50 bg-gradient-to-br ${gradient} cursor-pointer`;

                // Roda Kereta
                wagon.innerHTML = `
                ${num}
                <div class="absolute -bottom-3 left-1 md:left-2 w-5 h-5 md:w-6 md:h-6 bg-slate-800 rounded-full border-2 border-gray-400"></div>
                <div class="absolute -bottom-3 right-1 md:right-2 w-5 h-5 md:w-6 md:h-6 bg-slate-800 rounded-full border-2 border-gray-400"></div>
                <div class="absolute top-2 left-2 w-2 h-2 bg-white/40 rounded-full"></div>
            `;

                wagonWrapper.appendChild(wagon);
                wagonsYard.appendChild(wagonWrapper);
            });

            // Update titik progress
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

        // --- SISTEM DRAG & DROP (Cubit) ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let isPinching = false;
        let grabbedWagon = null;
        let grabOffsetX = 0;
        let grabOffsetY = 0;

        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorElement = document.getElementById("hand-cursor");

        function updateGameLoop() {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (isGameActive && !isTransitioningRound) {
                if (isPinching) {
                    if (grabbedWagon) {
                        updateHoverGlow(); // Cek rel mana yang sedang dihover
                    } else {
                        tryGrabWagon();
                    }
                } else {
                    highlightHoveredWagon();
                    if (grabbedWagon) {
                        handleDrop();
                    }
                }
            }

            // Kunci posisi gerbong pada jari saat diseret
            if (grabbedWagon && isPinching) {
                grabbedWagon.style.left = `${cursorX - grabOffsetX}px`;
                grabbedWagon.style.top = `${cursorY - grabOffsetY}px`;
            }

            requestAnimationFrame(updateGameLoop);
        }

        function highlightHoveredWagon() {
            const wagons = document.querySelectorAll(".wagon-card:not(.dragging)");
            let minDistance = 60;
            let closestWagon = null;

            wagons.forEach((w) => w.classList.remove("hover-highlight"));

            for (let w of wagons) {
                // Jangan sorot gerbong yang sudah masuk rel
                if (w.parentElement.classList.contains("track-slot")) continue;

                const rect = w.getBoundingClientRect();
                const dx = Math.max(rect.left - cursorX, 0, cursorX - rect.right);
                const dy = Math.max(rect.top - cursorY, 0, cursorY - rect.bottom);
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestWagon = w;
                }
            }

            if (closestWagon) {
                closestWagon.classList.add("hover-highlight");
                cursorEmoji.innerText = "👆";
            } else {
                cursorEmoji.innerText = "🖐️";
            }
        }

        function tryGrabWagon() {
            const wagons = document.querySelectorAll(".wagon-card:not(.dragging)");
            let minDistance = 60;
            let closestWagon = null;

            for (let w of wagons) {
                if (w.parentElement.classList.contains("track-slot")) continue;

                const rect = w.getBoundingClientRect();
                const dx = Math.max(rect.left - cursorX, 0, cursorX - rect.right);
                const dy = Math.max(rect.top - cursorY, 0, cursorY - rect.bottom);
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestWagon = w;
                }
            }

            if (closestWagon) {
                playSound("grab");
                grabbedWagon = closestWagon;
                closestWagon.classList.remove("hover-highlight");

                const rect = closestWagon.getBoundingClientRect();
                grabOffsetX = cursorX - rect.left;
                grabOffsetY = cursorY - rect.top;

                // Ukuran dikunci saat diseret agar tidak kacau
                closestWagon.style.width = `${rect.width}px`;
                closestWagon.style.height = `${rect.height}px`;

                closestWagon.classList.add("dragging");
                owlMessage.innerText = "Bagus! Seret ke rel yang urutannya benar.";
            }
        }

        function updateHoverGlow() {
            const slots = document.querySelectorAll(".track-slot");
            slots.forEach((s) => s.classList.remove("slot-glow"));

            for (let slot of slots) {
                if (slot.children.length > 0) continue; // Skip jika sudah ada isinya

                const rect = slot.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;

                // Jarak gerbong yang dipegang ke rel
                if (Math.hypot(cursorX - centerX, cursorY - centerY) < 80) {
                    slot.classList.add("slot-glow");
                    break; // Cukup 1 yang glow
                }
            }
        }

        function handleDrop() {
            if (!grabbedWagon) return;

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
                // Cek apakah angka gerbong sesuai dengan target slot
                if (droppedOnSlot.dataset.target === grabbedWagon.dataset.val) {
                    // BENAR
                    playSound("success");

                    // Snap ke dalam slot
                    grabbedWagon.classList.remove("dragging");
                    grabbedWagon.style.width = "100%";
                    grabbedWagon.style.height = "100%";
                    grabbedWagon.style.left = "0";
                    grabbedWagon.style.top = "0";
                    grabbedWagon.style.position = "relative";

                    // Hapus shadow dragging
                    grabbedWagon.style.boxShadow = "";

                    droppedOnSlot.appendChild(grabbedWagon);
                    droppedOnSlot.classList.remove(
                        "border-dashed",
                        "border-white/60",
                        "bg-white/20",
                    );

                    owlMessage.innerText = "Tepat sekali!";
                    attachedWagonsCount++;

                    // Cek Menang Ronde
                    if (attachedWagonsCount === 5) {
                        handleRoundComplete();
                    }
                } else {
                    // SALAH REL
                    playSound("error");
                    grabbedWagon.classList.add("animate-shake");
                    owlMessage.innerText = "Urutannya belum pas, coba lagi!";
                    mistakesMade++;
                    const wagonRef = grabbedWagon;

                    setTimeout(() => {
                        resetWagonToYard(wagonRef);
                    }, 400);

                    grabbedWagon = null;
                }
            } else {
                // Dilepas di sembarang tempat
                playSound("drop");
                resetWagonToYard(grabbedWagon);
                owlMessage.innerText = "Pastikan gerbong masuk ke dalam rel.";
            }

            grabbedWagon = null;
        }

        function resetWagonToYard(wagon) {
            if (!wagon) return;

            wagon.classList.remove("dragging", "animate-shake");
            wagon.style.width = "";
            wagon.style.height = "";
            wagon.style.left = "";
            wagon.style.top = "";
            wagon.style.position = "";
        }

        function handleRoundComplete() {
            isTransitioningRound = true;
            playSound("train-whistle");
            owlMessage.innerText = "Hebat! Kereta siap berangkat!";

            xp += 5;
            levelEarnedXP += 5;
            correctAnswersCount++;

            // ✅ TAMBAHKAN INI
            assessment.numerasi += 1;
            assessment.logika += 1;
            assessment.visual += 1;

            if (mistakesMade === 0) roundResults.push("correct");
            else roundResults.push("wrong");

            updateXPBar(1);

            // Animasi kereta jalan
            setTimeout(() => {
                trainAssembly.classList.add("animate-train-depart");
            }, 500);

            setTimeout(() => {
                currentRound++;
                if (currentRound < rounds.length) {
                    mistakesMade = 0; // Reset kesalahan untuk ronde baru
                    renderRound();
                } else {
                    showVictory();
                }
            }, 3000);
        }

        function showVictory() {
            isGameActive = false;
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            // KALKULASI XP FINAL LEVEL
            // Menggunakan perhitungan sama: +20 selesai, +10 flawless dari seluruh total level
            const levelCompletionXP = 20;
            const isFlawlessOverall = roundResults.every((r) => r === "correct");
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;
            document.getElementById("xp-text").innerText = `${xp} XP`;

            // SISTEM BINTANG & RATING
            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Kamu sudah mencoba dengan baik!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 5) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Kamu Insinyur Kereta Hebat!";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Hebat! Keretamu melaju kencang!";
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
                correctAnswersCount; // Max 5 (5 Ronde)
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
                    colors: ["#fbbf24", "#f97316", "#3b82f6", "#4ade80"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#fbbf24", "#f97316", "#3b82f6", "#4ade80"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        // --- SISTEM PELACAKAN TANGAN CAMERA ---
        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function setPinchState(pinching) {
            if (isPinching !== pinching) {
                isPinching = pinching;
                if (isPinching) {
                    cursorEmoji.innerText = "🤏";
                    cursorElement.style.transform = "translate(-50%, -50%) scale(0.9)";
                } else {
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

                        // Sensitivitas cubitan
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

        // Dukungan Mouse untuk Testing
        document.addEventListener("mousemove", (e) => {
            cursorElement.style.opacity = "1";
            targetX = e.clientX;
            targetY = e.clientY;
        });
        document.addEventListener("mousedown", () => setPinchState(true));
        document.addEventListener("mouseup", () => setPinchState(false));

        // Dukungan Touch untuk HP/Tablet
        document.addEventListener(
            "touchstart",
            (e) => {
                targetX = e.touches[0].clientX;
                targetY = e.touches[0].clientY;
                cursorX = targetX;
                cursorY = targetY; // Hindari lag awal
                setPinchState(true);
            }, {
                passive: false
            },
        );
        document.addEventListener(
            "touchmove",
            (e) => {
                targetX = e.touches[0].clientX;
                targetY = e.touches[0].clientY;
                e.preventDefault(); // Mencegah layar scroll saat main
            }, {
                passive: false
            },
        );
        document.addEventListener("touchend", () => setPinchState(false));

        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            requestAnimationFrame(updateGameLoop);
            initCamera();
            // Mulai dari Tutorial
        });
    </script>
</body>

</html>
