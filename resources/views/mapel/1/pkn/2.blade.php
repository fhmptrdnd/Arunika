<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Level 2: Susun Sila Pancasila</title>
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

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-pop-in {
            animation: pop-in 0.5s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
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
            transition: transform 0.15s ease-out;
            /* Efek membesar/mengecil */
        }

        .cursor-icon {
            font-size: 3rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
            transition: all 0.2s;
        }

        /* Mekanik List Baru */
        .sortable-item {
            transition:
                transform 0.2s,
                box-shadow 0.2s,
                border-color 0.3s;
            will-change: transform;
        }

        /* Sorotan hover sebelum dijepit */
        .sortable-item.hover-highlight {
            transform: scale(1.02);
            box-shadow: 0 0 20px 5px rgba(255, 255, 255, 0.8) !important;
            z-index: 30;
        }

        /* State Kartu sedang dipegang/drag */
        .sortable-item.dragging {
            position: fixed !important;
            z-index: 500;
            opacity: 0.95;
            transform: scale(1.05) rotate(-1deg) !important;
            transform-origin: center;
            pointer-events: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3) !important;
            transition: none !important;
            /* Mencegah lag visual saat ditarik */
        }

        /* Efek Visual jika Benar Ditempatkan */
        .correct-glow {
            border-color: #4ade80 !important;
            /* hijau */
            box-shadow:
                0 0 15px 5px rgba(74, 222, 128, 0.6),
                0 6px 0 rgba(0, 0, 0, 0.15) !important;
        }

        /* Ruang Kosong (Placeholder) saat kartu dipindah */
        .placeholder-slot {
            transition:
                height 0.2s ease-in-out,
                opacity 0.2s;
            animation: pop-in 0.2s ease-out forwards;
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

<body class="bg-gradient-to-b from-sky-300 to-green-300 h-screen w-full relative">
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
        <div class="absolute bottom-0 w-full h-1/5 bg-green-500 rounded-t-[100%] scale-x-150 transform translate-y-6">
        </div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/60 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg">
            <div
                class="w-14 h-14 bg-blue-400 rounded-full border-4 border-white flex items-center justify-center text-3xl shadow-inner">
                👦🏽
            </div>
            <div>
                <h2 class="font-black text-xl text-blue-900 tracking-wide drop-shadow-sm">
                    Penjelajah Level 2
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current text-gray-400"></i>
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
                        Geser balok ke atas/bawah untuk mengurutkan!
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

    <!-- --- MAIN GAME UI (LIST REORDERING) --- -->
    <div
        class="absolute inset-x-0 top-32 bottom-4 z-10 flex flex-col items-center pt-2 overflow-y-auto hide-scrollbar pb-10">
        <div class="text-center mb-6 shrink-0">
            <div
                class="bg-white/90 backdrop-blur-sm px-8 py-3 rounded-full border-4 border-white shadow-md inline-block mb-2">
                <h1 class="text-2xl md:text-3xl font-black text-gray-800">
                    Susun Sila Pancasila
                </h1>
            </div>
            <br />
            <h3
                class="text-md md:text-lg text-blue-900 font-bold drop-shadow-md bg-white/60 px-4 py-1 rounded-full inline-block">
                Urutkan dari 1 (Atas) sampai 5 (Bawah)
            </h3>
        </div>

        <div class="flex items-start gap-4 md:gap-6 w-[95%] max-w-4xl mb-8 relative z-10">
            <!-- Kolom Angka Tetap -->
            <div class="flex flex-col gap-4 md:gap-5 pt-1">
                <div
                    class="w-12 h-[88px] md:w-16 md:h-[104px] bg-white/70 backdrop-blur-sm border-4 border-white rounded-[20px] flex items-center justify-center font-black text-2xl md:text-3xl text-blue-900 shadow-md">
                    1
                </div>
                <div
                    class="w-12 h-[88px] md:w-16 md:h-[104px] bg-white/70 backdrop-blur-sm border-4 border-white rounded-[20px] flex items-center justify-center font-black text-2xl md:text-3xl text-blue-900 shadow-md">
                    2
                </div>
                <div
                    class="w-12 h-[88px] md:w-16 md:h-[104px] bg-white/70 backdrop-blur-sm border-4 border-white rounded-[20px] flex items-center justify-center font-black text-2xl md:text-3xl text-blue-900 shadow-md">
                    3
                </div>
                <div
                    class="w-12 h-[88px] md:w-16 md:h-[104px] bg-white/70 backdrop-blur-sm border-4 border-white rounded-[20px] flex items-center justify-center font-black text-2xl md:text-3xl text-blue-900 shadow-md">
                    4
                </div>
                <div
                    class="w-12 h-[88px] md:w-16 md:h-[104px] bg-white/70 backdrop-blur-sm border-4 border-white rounded-[20px] flex items-center justify-center font-black text-2xl md:text-3xl text-blue-900 shadow-md">
                    5
                </div>
            </div>

            <!-- Area Pengurutan -->
            <div id="sortable-list"
                class="flex flex-col gap-4 md:gap-5 flex-1 relative bg-white/30 backdrop-blur-sm p-4 rounded-[32px] border-4 border-dashed border-white/60">
                <!-- Item diisi oleh JS -->
            </div>
        </div>
    </div>

    <!-- --- TUTORIAL OVERLAY --- -->
    <div id="tutorial-overlay"
        class="fixed inset-0 z-[60] bg-sky-900/80 backdrop-blur-md flex flex-col items-center justify-center">
        <div
            class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl border-8 border-yellow-400 flex flex-col items-center max-w-2xl text-center animate-pop-in relative overflow-hidden mx-4">
            <div class="absolute -top-10 -right-10 text-9xl opacity-10 pointer-events-none">
                🦉
            </div>
            <h1 class="text-4xl font-black text-gray-800 mb-2">Cara Mengurutkan</h1>
            <p class="text-lg text-gray-600 mb-8 font-bold">
                Gunakan tanganmu di depan kamera!
            </p>

            <div class="flex flex-col md:flex-row gap-6 mb-8 w-full">
                <div
                    class="flex-1 bg-sky-50 p-4 rounded-3xl border-4 border-sky-200 flex flex-col items-center text-center">
                    <div class="text-6xl mb-4 animate-bounce-slight">🤏</div>
                    <h3 class="font-black text-sky-800 text-lg">1. Jepit Balok</h3>
                    <p class="text-sm text-sky-600 font-bold mt-1">
                        Arahkan tangan ke balok jawaban lalu jepit jarimu.
                    </p>
                </div>
                <div
                    class="flex-1 bg-green-50 p-4 rounded-3xl border-4 border-green-200 flex flex-col items-center text-center">
                    <div class="text-6xl mb-4 animate-float">↕️</div>
                    <h3 class="font-black text-green-800 text-lg">2. Geser & Lepas</h3>
                    <p class="text-sm text-green-600 font-bold mt-1">
                        Geser balok ke atas/bawah, lalu buka jarimu di urutan yang tepat.
                    </p>
                </div>
            </div>

            <button onclick="closeTutorial()"
                class="bg-yellow-400 hover:bg-yellow-300 text-yellow-900 text-2xl font-black py-4 px-12 rounded-full shadow-[0_8px_0_#b45309] hover:shadow-[0_4px_0_#b45309] hover:translate-y-1 transition-all flex items-center gap-3">
                <i data-lucide="play-circle" class="w-8 h-8"></i> Mengerti, Ayo Main!
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
            const formData = new FormData();

            formData.append('xp', xp);
            formData.append('true_answers', correctAnswersCount);
            formData.append('mapel', 'pkn');
            formData.append('kelas', '1');
            formData.append('level', '2');

            formData.append('literasi', assessment.literasi);
            formData.append('logika', assessment.logika);
            formData.append('visual', assessment.visual);

            fetch('/save-score', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => console.log('Score saved:', data))
                .catch(err => console.error(err));
        }
        // --- Sistem Audio Lengkap ---
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
                osc.frequency.setValueAtTime(400, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    600,
                    audioCtx.currentTime + 0.1,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.2,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.2);
            } else if (type === "drop") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(500, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    300,
                    audioCtx.currentTime + 0.15,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.2,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.2);
            } else if (type === "success") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
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
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1);
                osc.frequency.setValueAtTime(783.99, audioCtx.currentTime + 0.2);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.15, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.6,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.6);
            }
        }

        // --- Data Sila Pancasila ---
        const silaData = [{
                id: 1,
                icon: "⭐",
                text: "Ketuhanan Yang Maha Esa",
                color: "bg-yellow-400",
                border: "border-yellow-200",
            },
            {
                id: 2,
                icon: "🔗",
                text: "Kemanusiaan yang Adil dan Beradab",
                color: "bg-red-400",
                border: "border-red-200",
            },
            {
                id: 3,
                icon: "🌳",
                text: "Persatuan Indonesia",
                color: "bg-green-500",
                border: "border-green-300",
            },
            {
                id: 4,
                icon: "🐃",
                text: "Kerakyatan yang Dipimpin oleh Hikmat Kebijaksanaan",
                color: "bg-orange-500",
                border: "border-orange-300",
            },
            {
                id: 5,
                icon: "🌾",
                text: "Keadilan Sosial bagi Seluruh Rakyat Indonesia",
                color: "bg-amber-500",
                border: "border-amber-200",
            },
        ];

        // --- SISTEM TRACKING XP LEVEL 2 ---
        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        const scoredCards = new Set();

        let isGameActive = false;
        const listContainer = document.getElementById("sortable-list");
        const owlMessage = document.getElementById("owl-message");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            // Bar di atas menampilkan total kartu yang telah berada di posisi benar
            const progress = (scoredCards.size / 5) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function initGame() {
            listContainer.innerHTML = "";

            // Mengacak kartu agar dipastikan tidak ada satupun yang berurutan benar di awal (Derangement)
            let shuffledCards;
            let isFullyDeranged = false;
            while (!isFullyDeranged) {
                shuffledCards = [...silaData].sort(() => Math.random() - 0.5);
                isFullyDeranged = shuffledCards.every(
                    (s, index) => s.id !== index + 1,
                );
            }

            shuffledCards.forEach((sila) => {
                const card = document.createElement("div");
                card.className =
                    `sortable-item ${sila.color} ${sila.border} border-4 rounded-[20px] w-full h-[88px] md:h-[104px] flex items-center p-3 md:p-4 shadow-[0_6px_0_rgba(0,0,0,0.15)] cursor-grab relative z-20`;
                card.dataset.id = sila.id;

                card.innerHTML = `
            <div class="w-14 h-14 md:w-16 md:h-16 bg-white/40 rounded-xl flex items-center justify-center text-3xl md:text-4xl drop-shadow-md mr-4 shrink-0 pointer-events-none">${sila.icon}</div>
            <span class="text-white font-bold text-sm md:text-lg lg:text-xl leading-tight pointer-events-none drop-shadow-md mr-2">${sila.text}</span>
            <i data-lucide="grip-vertical" class="text-white/60 w-8 h-8 ml-auto pointer-events-none shrink-0 drag-handle-icon"></i>
          `;
                listContainer.appendChild(card);
            });

            updateXPBar();
        }

        function closeTutorial() {
            document.getElementById("tutorial-overlay").classList.add("hidden");
            isGameActive = true;
            if (audioCtx.state === "suspended") audioCtx.resume();
        }

        // --- SISTEM DRAG & DROP ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let isPinching = false;
        let grabbedCard = null;
        let placeholder = null;
        let grabOffsetX = 0;
        let grabOffsetY = 0;

        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorElement = document.getElementById("hand-cursor");

        function updateGameLoop() {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;
            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (isGameActive) {
                if (isPinching) {
                    if (grabbedCard) {
                        updatePlaceholderPosition();
                    } else {
                        tryGrabCard();
                    }
                } else {
                    highlightHoveredCard();
                    if (grabbedCard) {
                        handleDrop();
                    }
                }
            }

            if (grabbedCard && isPinching) {
                grabbedCard.style.left = `${cursorX - grabOffsetX}px`;
                grabbedCard.style.top = `${cursorY - grabOffsetY}px`;
            }

            requestAnimationFrame(updateGameLoop);
        }

        function highlightHoveredCard() {
            const cards = document.querySelectorAll(
                ".sortable-item:not(.dragging)",
            );
            let minDistance = 130;
            let closestCard = null;

            cards.forEach((card) => card.classList.remove("hover-highlight"));

            for (let card of cards) {
                const rect = card.getBoundingClientRect();
                const dx = Math.max(rect.left - cursorX, 0, cursorX - rect.right);
                const dy = Math.max(rect.top - cursorY, 0, cursorY - rect.bottom);
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestCard = card;
                }
            }

            if (closestCard) {
                closestCard.classList.add("hover-highlight");
                cursorEmoji.innerText = "👆";
                cursorEmoji.style.transform = "scale(1.2)";
            } else {
                cursorEmoji.innerText = "🖐️";
                cursorEmoji.style.transform = "scale(1)";
            }
        }

        function tryGrabCard() {
            const cards = document.querySelectorAll(
                ".sortable-item:not(.dragging)",
            );
            let minDistance = 50;
            let closestCard = null;

            for (let card of cards) {
                const rect = card.getBoundingClientRect();
                const dx = Math.max(rect.left - cursorX, 0, cursorX - rect.right);
                const dy = Math.max(rect.top - cursorY, 0, cursorY - rect.bottom);
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestCard = card;
                }
            }

            if (closestCard) {
                playSound("grab");
                grabbedCard = closestCard;
                closestCard.classList.remove("hover-highlight");

                const rect = closestCard.getBoundingClientRect();
                grabOffsetX = cursorX - rect.left;
                grabOffsetY = cursorY - rect.top;

                closestCard.style.width = `${rect.width}px`;
                closestCard.style.height = `${rect.height}px`;

                placeholder = document.createElement("div");
                placeholder.className =
                    "placeholder-slot w-full h-[88px] md:h-[104px] rounded-[20px] border-4 border-dashed border-white/80 bg-white/20 transition-all";
                listContainer.insertBefore(placeholder, closestCard);

                closestCard.classList.add("dragging");
                closestCard.classList.remove("correct-glow");
                owlMessage.innerText = "Geser ke urutan yang benar lalu buka jarimu.";
            }
        }

        function updatePlaceholderPosition() {
            if (!placeholder || !grabbedCard) return;

            const items = Array.from(
                listContainer.querySelectorAll(".sortable-item:not(.dragging)"),
            );
            let closestItem = null;
            let minOffset = Number.POSITIVE_INFINITY;

            const draggedCenterY =
                cursorY - grabOffsetY + grabbedCard.offsetHeight / 2;

            for (let item of items) {
                const rect = item.getBoundingClientRect();
                const itemCenterY = rect.top + rect.height / 2;
                const offset = draggedCenterY - itemCenterY;

                if (Math.abs(offset) < minOffset) {
                    minOffset = Math.abs(offset);
                    closestItem = item;
                }
            }

            if (closestItem) {
                const rect = closestItem.getBoundingClientRect();
                const itemCenterY = rect.top + rect.height / 2;

                if (draggedCenterY < itemCenterY) {
                    if (placeholder.nextSibling !== closestItem) {
                        listContainer.insertBefore(placeholder, closestItem);
                    }
                } else {
                    if (placeholder.previousSibling !== closestItem) {
                        listContainer.insertBefore(placeholder, closestItem.nextSibling);
                    }
                }
            }
        }

        function handleDrop() {
            if (!grabbedCard) return;

            if (placeholder) {
                listContainer.insertBefore(grabbedCard, placeholder);
                placeholder.remove();
                placeholder = null;
            }

            const currentItems = Array.from(
                listContainer.querySelectorAll(".sortable-item"),
            );
            const droppedCard = grabbedCard;
            let droppedIsCorrect = false;

            // EVALUASI SELURUH KARTU SECARA CERDAS (Real-time feedback)
            currentItems.forEach((item, index) => {
                const expectedIndex = parseInt(item.dataset.id) - 1;
                const isCorrect = index === expectedIndex;

                if (isCorrect) {
                    item.classList.add("correct-glow");

                    if (!scoredCards.has(item.dataset.id)) {
                        scoredCards.add(item.dataset.id);
                        correctAnswersCount++;
                        xp += 5;
                        levelEarnedXP += 5;

                        // ✅ assessment
                        assessment.literasi += 1;
                        assessment.logika += 1;
                        assessment.visual += 1;

                        updateXPBar();
                    }

                    if (item === droppedCard) droppedIsCorrect = true;

                } else {
                    item.classList.remove("correct-glow");

                    if (item === droppedCard) droppedIsCorrect = false;
                }
            });

            // Feedback spesifik untuk kartu yang ditarik oleh user
            if (droppedIsCorrect) {
                playSound("success");
                owlMessage.innerText = `Luar biasa! Posisi Sila ke-${droppedCard.dataset.id} sudah tepat.`;
                confetti({
                    particleCount: 30,
                    spread: 50,
                    origin: {
                        x: cursorX / window.innerWidth,
                        y: cursorY / window.innerHeight,
                    },
                });
            } else {
                playSound("error");
                mistakesMade++;
                droppedCard.classList.add(
                    "animate-shake",
                    "!border-red-500",
                    "!shadow-[0_6px_0_#ef4444]",
                );

                // Timeout yang aman dengan menyimpan referensi droppedCard
                setTimeout(() => {
                    droppedCard.classList.remove(
                        "animate-shake",
                        "!border-red-500",
                        "!shadow-[0_6px_0_#ef4444]",
                    );
                }, 500);

                owlMessage.innerText = `Ups! Itu bukan urutan untuk Sila ke-${droppedCard.dataset.id}.`;
            }

            // Pembersihan State
            grabbedCard.classList.remove("dragging");
            grabbedCard.style.width = "";
            grabbedCard.style.height = "";
            grabbedCard.style.left = "";
            grabbedCard.style.top = "";
            grabbedCard = null;

            checkWinCondition(currentItems);
        }

        function checkWinCondition(currentItems) {
            const currentOrder = currentItems
                .map((item) => item.dataset.id)
                .join(",");

            if (currentOrder === "1,2,3,4,5") {
                isGameActive = false;
                playSound("win");
                owlMessage.innerText = "Sempurna! Susunannya tepat!";

                currentItems.forEach((item) => {
                    item.classList.remove("cursor-grab", "correct-glow");

                    // Perbaikan Bug Crash Lucide JS SVG:
                    const dragIcon = item.querySelector(".drag-handle-icon");
                    if (dragIcon) dragIcon.remove();
                });

                // Tampilkan Modal Pemenang
                setTimeout(showVictory, 1200);
            }
        }

        function showVictory() {
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            // KALKULASI XP FINAL LEVEL 2
            const levelCompletionXP = 20;
            const flawlessBonusXP = mistakesMade === 0 ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;

            // Memperbarui UI angka XP di bar atas sebelum show modal
            document.getElementById("xp-text").innerText = `${xp} XP`;

            // SISTEM BINTANG & RATING
            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Tidak apa-apa salah, kamu pasti bisa lebih baik!";

            // Toleransi kesalahan karena game Drag n Drop cukup sensitif
            if (mistakesMade <= 1) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Kamu Penjelajah Hebat!";
            } else if (mistakesMade <= 4) {
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

            // UPDATE Papan Skor
            document.getElementById("correct-count").innerText =
                correctAnswersCount;
            document.getElementById("xp-answers").innerText =
                `+${correctAnswersCount * 5} XP`;

            const flawlessBadge = document.getElementById("flawless-badge");

            if (flawlessBadge) {
                if (mistakesMade === 0) {
                    flawlessBadge.style.display = "flex";
                } else {
                    flawlessBadge.style.display = "none";
                }
            }
            document.getElementById("earned-xp-text").innerText =
                `+${levelEarnedXP}`;

            renderAssessmentUI(assessment);
            updateAssessmentBar(assessment);

            overlay.classList.remove("hidden");
            overlay.classList.add("flex");
            modal.classList.add("animate-pop-in");

            const end = Date.now() + 4000;
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

        // --- SISTEM PELACAKAN TANGAN CAMERA ---
        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function setPinchState(pinching) {
            if (isPinching !== pinching) {
                isPinching = pinching;
                cursorEmoji.innerText = isPinching ? "🤏" : "🖐️";
                cursorElement.style.transform = isPinching ?
                    "translate(-50%, -50%) scale(1.1)" :
                    "translate(-50%, -50%) scale(1)";
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
                    minTrackingConfidence: 0.7,
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

                        if (!isPinching && distanceInPixels < 70) {
                            setPinchState(true);
                        } else if (isPinching && distanceInPixels > 120) {
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
                console.error("Kamera tidak dapat diakses:", error);
                camStatus.innerText = "MOUSE MODE";
                camIndicator.className = "w-2 h-2 bg-gray-500 rounded-full";
            }
        }

        // Mouse Support
        document.addEventListener("mousemove", (e) => {
            cursorElement.style.opacity = "1";
            targetX = e.clientX;
            targetY = e.clientY;
        });
        document.addEventListener("mousedown", () => setPinchState(true));
        document.addEventListener("mouseup", () => setPinchState(false));
        document.addEventListener(
            "touchstart",
            (e) => {
                targetX = e.touches[0].clientX;
                targetY = e.touches[0].clientY;
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
                e.preventDefault();
            }, {
                passive: false
            },
        );
        document.addEventListener("touchend", () => setPinchState(false));

        document.addEventListener("DOMContentLoaded", () => {
            initGame();
            lucide.createIcons();
            requestAnimationFrame(updateGameLoop);
            initCamera();
        });
    </script>
</body>

</html>
