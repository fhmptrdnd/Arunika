<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Matematika Kelas 3 - Level 1: Bangun Angka</title>
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

        /* Gaya Konstruksi (Blueprint) */
        .blueprint-bg {
            background-color: #1e40af;
            /* blue-800 */
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.1) 2px, transparent 2px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.1) 2px, transparent 2px),
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size:
                100px 100px,
                100px 100px,
                20px 20px,
                20px 20px;
            background-position:
                -2px -2px,
                -2px -2px,
                -1px -1px,
                -1px -1px;
        }

        /* Blok Bangunan (Lego Style) */
        .block-item {
            border-bottom: 6px solid rgba(0, 0, 0, 0.3);
            border-right: 4px solid rgba(0, 0, 0, 0.2);
            border-top: 2px solid rgba(255, 255, 255, 0.4);
            border-left: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            will-change: transform;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: white;
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.3);
        }

        .block-100 {
            background-color: #3b82f6;
            width: 120px;
            height: 35px;
            border-radius: 8px;
        }

        /* Blue */
        .block-10 {
            background-color: #22c55e;
            width: 80px;
            height: 35px;
            border-radius: 8px;
        }

        /* Green */
        .block-1 {
            background-color: #eab308;
            width: 35px;
            height: 35px;
            border-radius: 8px;
        }

        /* Yellow */

        /* Area Drop Zone (Kolom) */
        .drop-column {
            transition: all 0.3s;
            background-image: repeating-linear-gradient(0deg,
                    transparent,
                    transparent 33px,
                    rgba(0, 0, 0, 0.05) 33px,
                    rgba(0, 0, 0, 0.05) 35px);
        }

        .drop-column.glow {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: #fde047;
            box-shadow: 0 0 20px rgba(250, 204, 21, 0.5);
        }

        .drop-column.error {
            border-color: #ef4444;
            background-color: rgba(239, 68, 68, 0.2);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
        }

        /* Interaksi Kursor (Hover Items) */
        .interactable {
            transition:
                transform 0.2s,
                filter 0.2s,
                box-shadow 0.2s;
        }

        .interactable.hover-highlight {
            transform: scale(1.15);
            filter: drop-shadow(0 10px 15px rgba(250, 204, 21, 0.8)) brightness(1.1);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.8);
            z-index: 50;
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

        .lucide {
            display: inline-block;
        }
    </style>
</head>

<body
    class="bg-gradient-to-b from-sky-300 via-sky-200 to-amber-100 h-screen w-full relative overflow-hidden flex flex-col">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute inset-0 w-full h-full">
            <circle class="progress-ring__circle" stroke="#f59e0b" stroke-width="8" fill="transparent" r="36"
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

    <!-- --- SCENERY BACKGROUND (CONSTRUCTION SITE) --- -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Awan -->
        <div class="absolute top-[10%] left-[-20%] opacity-80 animate-drift-slow">
            ☁️
        </div>
        <div class="absolute top-[20%] left-[-10%] opacity-60 text-4xl animate-drift-slow"
            style="animation-duration: 35s">
            ☁️
        </div>

        <!-- Latar Belakang Kota Bangunan Siluet -->
        <div
            class="absolute bottom-[20vh] w-full h-[30vh] opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIj48cGF0aCBkPSJNMCAxMDBMMCA2MEwxMCA2MEwxMCA0MEwyMCA0MEwyMCAyMEwzMCAyMEwzMCA1MEw0MCA1MEw0MCAzMEw1MCAzMEw1MCAxMEw2MCAxMEw2MCA0MEw3MCA0MEw3MCAyMEw4MCAyMEw4MCA2MEw5MCA2MEw5MCA0MEwxMDAgNDBMMTAwIDEwMFoiIGZpbGw9IiMwMDAiLz48L3N2Zz4=')] bg-repeat-x bg-bottom bg-contain">
        </div>

        <!-- Crane (Bangau Konstruksi) -->
        <div class="absolute right-10 top-20 text-[15rem] opacity-30 origin-bottom scale-x-[-1]">
            🏗️
        </div>
        <div class="absolute left-5 top-40 text-[10rem] opacity-20 origin-bottom">
            🏗️
        </div>

        <!-- Tanah Proyek -->
        <div
            class="absolute bottom-0 w-full h-[20vh] bg-amber-600 rounded-t-[50%] scale-x-125 transform translate-y-8 shadow-[inset_0_20px_50px_rgba(0,0,0,0.3)]">
        </div>
        <div class="absolute bottom-[-5%] w-[120%] left-[-10%] h-[20vh] bg-amber-700 rounded-t-[50%] scale-x-110"></div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full shrink-0">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/90 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-amber-500 shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-amber-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                👷‍♂️
            </div>
            <div>
                <h2 class="font-black text-xl text-amber-900 tracking-wide drop-shadow-sm">
                    Arsitek Level 3
                </h2>
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
                class="bg-white/90 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-amber-500 shadow-lg flex flex-col items-center">
                <span class="font-black text-amber-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-40 h-4 bg-amber-900/20 rounded-full overflow-hidden shadow-inner border border-amber-200 relative">
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
                    <p id="owl-message" class="font-bold text-amber-800 text-sm">
                        Tahan jarimu di atas balok untuk menambahkannya!
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

    <!-- --- MAIN GAME LAYOUT --- -->
    <div class="relative z-10 flex flex-col flex-1 w-full pointer-events-none pb-6 px-4">
        <!-- AREA KERJA TENGAH -->
        <div class="flex-1 flex flex-col items-center justify-start pointer-events-auto relative mt-2 md:mt-4">
            <!-- TOOLBOX ATAS (MATERIAL & TOMBOL AKSI) -->
            <div
                class="w-full max-w-4xl bg-amber-800/90 backdrop-blur-md shadow-[0_10px_20px_rgba(0,0,0,0.3)] flex flex-row items-center justify-between py-4 px-6 rounded-[2rem] border-4 border-amber-900 z-30 mb-4 animate-pop-in">
                <!-- Tombol Hapus (Kiri) -->
                <div id="btn-reset"
                    class="interactable w-16 h-16 md:w-20 md:h-20 bg-red-500 rounded-2xl border-4 border-white shadow-[0_6px_0_#b91c1c] flex flex-col items-center justify-center cursor-pointer shrink-0">
                    <i data-lucide="trash-2" class="text-white w-6 h-6 md:w-8 md:h-8 pointer-events-none mb-1"></i>
                    <span
                        class="text-[9px] md:text-xs font-black text-white uppercase pointer-events-none drop-shadow-md">Hapus</span>
                </div>

                <!-- Pembatas -->
                <div class="hidden md:block w-1 h-16 bg-amber-700/50 rounded-full mx-2"></div>

                <!-- Blok Material (Tahan / Hover Lock) -->
                <div class="flex gap-4 md:gap-8 items-center">
                    <div class="flex flex-col items-center gap-1">
                        <div id="src-100" data-type="100"
                            class="interactable block-item block-100 scale-90 md:scale-100 origin-center cursor-pointer">
                            100
                        </div>
                        <span
                            class="text-[10px] md:text-xs font-bold text-amber-200 uppercase tracking-widest hidden md:block pointer-events-none">Tahan</span>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <div id="src-10" data-type="10"
                            class="interactable block-item block-10 scale-90 md:scale-100 origin-center cursor-pointer">
                            10
                        </div>
                        <span
                            class="text-[10px] md:text-xs font-bold text-amber-200 uppercase tracking-widest hidden md:block pointer-events-none">Tahan</span>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <div id="src-1" data-type="1"
                            class="interactable block-item block-1 scale-90 md:scale-100 origin-center cursor-pointer">
                            1
                        </div>
                        <span
                            class="text-[10px] md:text-xs font-bold text-amber-200 uppercase tracking-widest hidden md:block pointer-events-none">Tahan</span>
                    </div>
                </div>

                <!-- Pembatas -->
                <div class="hidden md:block w-1 h-16 bg-amber-700/50 rounded-full mx-2"></div>

                <!-- Tombol Bangun (Kanan) -->
                <div id="btn-check"
                    class="interactable w-16 h-16 md:w-20 md:h-20 bg-green-500 rounded-2xl border-4 border-white shadow-[0_6px_0_#15803d] flex flex-col items-center justify-center cursor-pointer shrink-0">
                    <i data-lucide="hard-hat" class="text-white w-6 h-6 md:w-8 md:h-8 pointer-events-none mb-1"></i>
                    <span
                        class="text-[9px] md:text-xs font-black text-white uppercase pointer-events-none drop-shadow-md">Bangun</span>
                </div>
            </div>

            <!-- TARGET CARD (Blueprint) -->
            <div
                class="blueprint-bg px-10 py-3 rounded-3xl border-4 border-blue-400 shadow-[0_10px_20px_rgba(0,0,0,0.4)] flex items-center gap-6 z-20 mb-6 md:mb-10">
                <button onclick="playTargetSpeech()"
                    class="bg-white/20 hover:bg-white/30 p-3 rounded-full border-2 border-white/50 transition-colors shadow-sm cursor-pointer interactable-button"
                    title="Dengarkan Angka">
                    <i data-lucide="volume-2" class="text-white w-6 h-6"></i>
                </button>
                <div class="flex flex-col items-center text-white">
                    <span class="text-sm font-bold uppercase tracking-widest text-blue-200">Bangun Angka:</span>
                    <span id="target-number"
                        class="font-fun text-5xl md:text-6xl tracking-wide drop-shadow-lg">347</span>
                </div>
            </div>

            <!-- DROP ZONES (Kolom Ratusan, Puluhan, Satuan) -->
            <div class="flex flex-row items-end justify-center gap-6 md:gap-12 z-10 w-full max-w-4xl">
                <!-- DROP ZONE 1: RATUSAN (Biru) -->
                <div class="flex flex-col items-center gap-2">
                    <span
                        class="font-black text-blue-900 bg-white/80 px-4 py-1 rounded-full text-sm uppercase shadow-sm">Ratusan:
                        <span id="count-100">0</span></span>
                    <div id="col-100" data-type="100"
                        class="drop-column w-[130px] md:w-[150px] h-[220px] md:h-[260px] bg-blue-900/10 border-4 border-dashed border-blue-400/50 rounded-t-3xl rounded-b-md flex flex-col-reverse items-center justify-start pb-2 overflow-visible relative">
                        <!-- Stacking blocks go here -->
                    </div>
                </div>

                <!-- DROP ZONE 2: PULUHAN (Hijau) -->
                <div class="flex flex-col items-center gap-2">
                    <span
                        class="font-black text-green-900 bg-white/80 px-4 py-1 rounded-full text-sm uppercase shadow-sm">Puluhan:
                        <span id="count-10">0</span></span>
                    <div id="col-10" data-type="10"
                        class="drop-column w-[90px] md:w-[100px] h-[220px] md:h-[260px] bg-green-900/10 border-4 border-dashed border-green-400/50 rounded-t-3xl rounded-b-md flex flex-col-reverse items-center justify-start pb-2 overflow-visible relative">
                    </div>
                </div>

                <!-- DROP ZONE 3: SATUAN (Kuning) -->
                <div class="flex flex-col items-center gap-2">
                    <span
                        class="font-black text-yellow-900 bg-white/80 px-4 py-1 rounded-full text-sm uppercase shadow-sm">Satuan:
                        <span id="count-1">0</span></span>
                    <div id="col-1" data-type="1"
                        class="drop-column w-[50px] md:w-[60px] h-[220px] md:h-[260px] bg-yellow-900/10 border-4 border-dashed border-yellow-500/50 rounded-t-3xl rounded-b-md flex flex-col-reverse items-center justify-start pb-2 overflow-visible relative">
                    </div>
                </div>
            </div>

            <!-- Indikator Progres Dots -->
            <div class="absolute bottom-0 left-2 md:left-6 flex gap-3 pointer-events-auto bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full border-2 border-white shadow-lg z-40"
                id="progress-dots">
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
            </div>
        </div>
    </div>

    <!-- --- VICTORY OVERLAY --- -->
    <div id="victory-overlay"
        class="hidden fixed inset-0 z-[60] bg-sky-200/90 backdrop-blur-md flex-col items-center justify-center">
        <div id="victory-modal"
            class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl border-8 border-yellow-400 flex flex-col items-center max-w-xl w-[90%] text-center scale-0 relative overflow-y-auto">
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
                        kelas: '3',
                        level: '1',
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
        // --- Audio System (Sfx Only) ---
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        function playSound(type) {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === "drop") {
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
            } else if (type === "hover-lock") {
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

        // --- Data Permainan (Matematika Kelas 3) ---
        const rounds = [{
                target: 124,
                text: "Seratus dua puluh empat"
            },
            {
                target: 305,
                text: "Tiga ratus lima"
            },
            {
                target: 410,
                text: "Empat ratus sepuluh"
            },
            {
                target: 612,
                text: "Enam ratus dua belas"
            },
            {
                target: 902,
                text: "Sembilan ratus dua"
            },
        ];

        let currentRound = 0;
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        // State Bangunan
        let blocks = {
            100: 0,
            10: 0,
            1: 0
        };

        // DOM Elements
        const targetNumberDisplay = document.getElementById("target-number");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");

        const col100 = document.getElementById("col-100");
        const col10 = document.getElementById("col-10");
        const col1 = document.getElementById("col-1");
        const cols = {
            100: col100,
            10: col10,
            1: col1
        };

        const count100 = document.getElementById("count-100");
        const count10 = document.getElementById("count-10");
        const count1 = document.getElementById("count-1");

        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            let progress = (currentRound / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function playTargetSpeech() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.text);
            utterance.lang = "id-ID";
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        function renderRound() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            targetNumberDisplay.innerText = round.target;
            owlMessage.innerText = `Tahan jarimu di atas blok (100, 10, atau 1) untuk membangun angka ${round.target}!`;

            resetBlocks();
            updateProgressDots();
            isAnimating = false;

            setTimeout(playTargetSpeech, 500);
        }

        function resetBlocks() {
            blocks = {
                100: 0,
                10: 0,
                1: 0
            };

            col100.innerHTML = "";
            col10.innerHTML = "";
            col1.innerHTML = "";

            count100.innerText = "0";
            count10.innerText = "0";
            count1.innerText = "0";

            [col100, col10, col1].forEach((col) =>
                col.classList.remove("error", "glow"),
            );
        }

        function addBlock(type) {
            playSound("drop");
            blocks[type]++;

            if (blocks[type] > 9) {
                blocks[type] = 9;
                owlMessage.innerText = "Maksimal 9 blok per kolom!";
                playSound("error");
            } else {
                document.getElementById(`count-${type}`).innerText =
                    blocks[type] * parseInt(type);

                const targetCol = cols[type];
                const newBlock = document.createElement("div");
                newBlock.className = `block-item block-${type} mt-[2px] shadow-sm animate-pop-in`;
                newBlock.innerText = type;

                targetCol.appendChild(newBlock);
                owlMessage.innerText =
                    "Bagus! Terus tahan jarimu untuk menambah lagi.";
            }
        }

        // --- LOGIKA GAME (CEK JAWABAN) ---
        function checkAnswer() {
            if (isAnimating) return;
            isAnimating = true;

            const round = rounds[currentRound];

            const expected100 = Math.floor(round.target / 100);
            const expected10 = Math.floor((round.target % 100) / 10);
            const expected1 = round.target % 10;

            const is100Correct = blocks[100] === expected100;
            const is10Correct = blocks[10] === expected10;
            const is1Correct = blocks[1] === expected1;

            const isAllCorrect = is100Correct && is10Correct && is1Correct;

            if (isAllCorrect) {
                // --- BENAR ---
                playSound("success");

                [col100, col10, col1].forEach((col) => col.classList.add("glow"));
                owlMessage.innerText = "Konstruksi Sempurna!";

                confetti({
                    particleCount: 60,
                    spread: 80,
                    origin: {
                        y: 0.6
                    },
                    colors: ["#3b82f6", "#22c55e", "#eab308"],
                });

                xp += 5;
                levelEarnedXP += 5;
                correctAnswersCount++;
                updateAssessment(assessment, {
                    numerasi: 3,
                    logika: 2,
                    visual: 1
                });
                if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                    roundResults.push("correct");
                }
                updateXPBar();

                setTimeout(() => {
                    [col100, col10, col1].forEach((col) =>
                        col.classList.remove("glow"),
                    );
                    currentRound++;
                    renderRound();
                }, 2000);
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    numerasi: -1
                });
                // --- SALAH ---
                playSound("error");
                owlMessage.innerText =
                    "Ada yang salah! Hapus jika kelebihan, atau tambah lagi.";

                // Tandai kolom yang salah
                if (!is100Correct) col100.classList.add("error", "animate-shake");
                if (!is10Correct) col10.classList.add("error", "animate-shake");
                if (!is1Correct) col1.classList.add("error", "animate-shake");

                mistakesMade++;
                if (roundResults.length < currentRound + 1)
                    roundResults.push("wrong");
                updateProgressDots();

                setTimeout(() => {
                    [col100, col10, col1].forEach((col) =>
                        col.classList.remove("error", "animate-shake"),
                    );
                    isAnimating = false;
                }, 1000);
            }
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-inner dot" :
                        "w-4 h-4 bg-red-500 rounded-full border-2 border-white shadow-inner dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-4 h-4 bg-yellow-400 rounded-full border-2 border-white shadow-lg animate-pulse dot";
                } else {
                    dot.className =
                        "w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot";
                }
            });
        }

        function showVictory() {
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 20;
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
                titleText = "Arsitek Sempurna!";
                descText = "Luar biasa! Bangunanmu sangat kokoh.";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Kamu sudah pandai menyusun angka.";
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
                    colors: ["#3b82f6", "#22c55e", "#eab308"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#3b82f6", "#22c55e", "#eab308"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        // --- SISTEM HOVER INTERACTION ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let hoveredElementId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_CLICK = 1200; // 0.8 detik agar cukup responsif saat ditahan

        function updateGameLoop(timestamp) {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (!isAnimating) {
                let hoveredEl = null;
                const interactables = document.querySelectorAll(".interactable");

                interactables.forEach((el) => {
                    const rect = el.getBoundingClientRect();
                    const padding = 20;
                    if (
                        cursorX >= rect.left - padding &&
                        cursorX <= rect.right + padding &&
                        cursorY >= rect.top - padding &&
                        cursorY <= rect.bottom + padding
                    ) {
                        hoveredEl = el;
                    }
                });

                if (hoveredEl) {
                    const currentId = hoveredEl.id;

                    cursorEmoji.innerText = "👆";
                    cursorEmoji.style.transform = "scale(1.2)";

                    if (hoveredElementId === currentId) {
                        if (!hoverStartTime) hoverStartTime = timestamp;
                        const elapsed = timestamp - hoverStartTime;

                        const percentage = Math.min(elapsed / HOVER_DURATION_TO_CLICK, 1);
                        cursorProgress.style.strokeDashoffset = 226.2 * (1 - percentage);

                        if (elapsed > 100 && Math.floor(elapsed) % 200 < 20)
                            playSound("hover-lock");

                        if (elapsed >= HOVER_DURATION_TO_CLICK) {
                            // Jalankan Aksi
                            if (currentId === "btn-check") {
                                checkAnswer();
                                hoveredElementId = null;
                            } else if (currentId === "btn-reset") {
                                playSound("drop");
                                resetBlocks();
                                hoveredElementId = null;
                            } else if (currentId.startsWith("src-")) {
                                const type = hoveredEl.dataset.type;
                                addBlock(type);
                                // Mengatur ulang timer ke waktu sekarang agar proses penambahan kontinu (continuous adding)
                                hoverStartTime = timestamp;
                            }

                            cursorProgress.style.strokeDashoffset = 226.2;
                        }
                    } else {
                        hoveredElementId = currentId;
                        hoverStartTime = timestamp;
                        interactables.forEach((b) =>
                            b.classList.remove("hover-highlight"),
                        );
                        hoveredEl.classList.add("hover-highlight");
                    }
                } else {
                    if (hoveredElementId) {
                        const oldEl = document.getElementById(hoveredElementId);
                        if (oldEl) oldEl.classList.remove("hover-highlight");
                    }
                    hoveredElementId = null;
                    hoverStartTime = 0;
                    cursorProgress.style.strokeDashoffset = 226.2;

                    cursorEmoji.innerText = "🖐️";
                    cursorEmoji.style.transform = "scale(1)";
                }
            } else {
                cursorEmoji.innerText = "🖐️";
                cursorEmoji.style.transform = "scale(1)";
                cursorProgress.style.strokeDashoffset = 226.2;
                hoverStartTime = 0;
                hoveredElementId = null;
            }

            requestAnimationFrame(updateGameLoop);
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
            renderRound();
            requestAnimationFrame(updateGameLoop);
            initCamera();
        });
    </script>
</body>

</html>
