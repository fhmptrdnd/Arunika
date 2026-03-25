<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Matematika Kelas 3 - Level 2: Mesin Hitung Ajaib</title>
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

        @keyframes spin-slow {
            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
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
                transform: scale(1.05);
            }
        }

        .animate-glow-gold {
            animation: glow-gold 1s ease-in-out;
            border-color: #fde047 !important;
            background-color: #fef08a !important;
            color: #b45309 !important;
        }

        /* Animasi Mesin Hitung */
        @keyframes ball-drop {
            0% {
                transform: translateY(-150px) scale(0.5);
                opacity: 0;
            }

            30% {
                transform: translateY(0px) scale(1);
                opacity: 1;
            }

            70% {
                transform: translateY(0px) scale(1);
                opacity: 1;
            }

            100% {
                transform: translateY(100px) scale(0);
                opacity: 0;
            }
        }

        .animate-ball-drop {
            animation: ball-drop 2.5s forwards ease-in-out;
        }

        @keyframes machine-work {

            0%,
            100% {
                filter: brightness(1) drop-shadow(0 0 0px transparent);
                transform: scale(1);
            }

            20%,
            60% {
                transform: scale(1.02) rotate(-1deg);
                filter: brightness(1.2) drop-shadow(0 0 20px rgba(59, 130, 246, 0.8));
            }

            40%,
            80% {
                transform: scale(1.02) rotate(1deg);
                filter: brightness(1.2) drop-shadow(0 0 20px rgba(59, 130, 246, 0.8));
            }
        }

        .animate-machine-work {
            animation: machine-work 1.5s ease-in-out;
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

        /* Pipa dan Mesin */
        .pipe {
            background: linear-gradient(90deg,
                    #94a3b8 0%,
                    #cbd5e1 20%,
                    #e2e8f0 50%,
                    #cbd5e1 80%,
                    #94a3b8 100%);
            border-left: 4px solid #64748b;
            border-right: 4px solid #64748b;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-indigo-200 via-purple-100 to-sky-200 h-screen w-full relative overflow-hidden flex flex-col">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute inset-0 w-full h-full">
            <circle class="progress-ring__circle" stroke="#3b82f6" stroke-width="8" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji"
            style="
          font-size: 3rem;
          filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
          transition: all 0.2s;
        ">
            👆
        </div>
    </div>

    <!-- --- SCENERY BACKGROUND (MATH LAB) --- -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Ornamen Laboratorium -->
        <div class="absolute top-[10%] left-[5%] text-6xl opacity-20 animate-spin-slow">
            ⚙️
        </div>
        <div class="absolute top-[30%] right-[8%] text-5xl opacity-30 animate-spin-slow"
            style="animation-direction: reverse; animation-duration: 6s">
            ⚙️
        </div>
        <div class="absolute bottom-[25%] left-[10%] text-6xl opacity-30 animate-float">
            🧪
        </div>
        <div class="absolute bottom-[15%] right-[15%] text-7xl opacity-20 animate-float" style="animation-delay: 1s">
            🔬
        </div>

        <!-- Latar Meja Lab -->
        <div
            class="absolute bottom-0 w-full h-[25vh] bg-slate-700 rounded-t-[50%] scale-x-125 transform translate-y-8 shadow-[inset_0_20px_50px_rgba(0,0,0,0.3)]">
        </div>
        <div class="absolute bottom-[-5%] w-[120%] left-[-10%] h-[20vh] bg-slate-800 rounded-t-[50%] scale-x-110"></div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full shrink-0">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/90 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-indigo-400 shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-indigo-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                👨‍🔬
            </div>
            <div>
                <h2 class="font-black text-xl text-indigo-900 tracking-wide drop-shadow-sm">
                    Ilmuwan Level 3
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
                    <p id="owl-message" class="font-bold text-indigo-800 text-sm">
                        Lihat angka yang masuk ke mesin, lalu pilih jawaban yang tepat!
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
    <div
        class="relative z-10 flex flex-col md:flex-row flex-1 w-full pointer-events-none pb-6 px-4 md:px-12 items-center justify-center gap-8 md:gap-16">
        <!-- BAGIAN MESIN (Tengah/Kiri) -->
        <div class="flex flex-col items-center relative w-full max-w-md pointer-events-auto">
            <!-- Pipa Input Atas -->
            <div class="flex gap-16 mb-[-20px] relative z-0">
                <div class="relative w-20 flex flex-col items-center">
                    <!-- Bola Angka 1 (Animasi) -->
                    <div id="ball-1"
                        class="absolute -top-10 w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full shadow-[inset_0_0_15px_rgba(255,255,255,0.5),_0_5px_10px_rgba(0,0,0,0.3)] flex items-center justify-center text-white font-black text-xl border-2 border-white/50 opacity-0">
                    </div>
                    <!-- Pipa Fisik -->
                    <div class="pipe w-16 h-24 rounded-t-lg"></div>
                </div>
                <div class="relative w-20 flex flex-col items-center">
                    <!-- Bola Angka 2 (Animasi) -->
                    <div id="ball-2"
                        class="absolute -top-10 w-16 h-16 bg-gradient-to-br from-rose-400 to-rose-600 rounded-full shadow-[inset_0_0_15px_rgba(255,255,255,0.5),_0_5px_10px_rgba(0,0,0,0.3)] flex items-center justify-center text-white font-black text-xl border-2 border-white/50 opacity-0">
                    </div>
                    <!-- Pipa Fisik -->
                    <div class="pipe w-16 h-24 rounded-t-lg"></div>
                </div>
            </div>

            <!-- Body Mesin Hitung -->
            <div id="math-machine"
                class="w-full bg-slate-200 border-[12px] border-slate-400 rounded-[3rem] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.4),_inset_0_5px_20px_rgba(255,255,255,0.8)] relative z-10 flex flex-col items-center transition-all duration-300">
                <!-- Layar Indikator Target Keseluruhan -->
                <div
                    class="w-full bg-slate-900 rounded-2xl border-4 border-slate-700 p-3 mb-6 shadow-inner flex justify-center items-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-blue-500/10 pattern-grid-lg"></div>
                    <span id="equation-display"
                        class="font-fun text-4xl text-cyan-400 drop-shadow-[0_0_8px_rgba(34,211,238,0.8)] tracking-wider">
                        245 + 130 = ?
                    </span>
                </div>

                <!-- Reaktor Inti Mesin -->
                <div
                    class="w-32 h-32 bg-slate-800 rounded-full border-8 border-slate-500 shadow-inner flex items-center justify-center relative overflow-hidden">
                    <div id="reactor-glow"
                        class="absolute inset-0 bg-blue-500 opacity-20 blur-xl transition-all duration-300"></div>
                    <span id="operator-display"
                        class="font-black text-6xl text-white drop-shadow-md relative z-10 animate-pulse">+</span>
                </div>

                <!-- Tombol Mesin Deco -->
                <div class="flex gap-4 mt-6">
                    <div class="w-6 h-6 bg-red-500 rounded-full shadow-[0_4px_0_#991b1b] border-2 border-white/50">
                    </div>
                    <div class="w-6 h-6 bg-yellow-400 rounded-full shadow-[0_4px_0_#a16207] border-2 border-white/50">
                    </div>
                    <div class="w-6 h-6 bg-green-500 rounded-full shadow-[0_4px_0_#166534] border-2 border-white/50">
                    </div>
                </div>
            </div>

            <!-- Pipa Output Bawah -->
            <div class="flex flex-col items-center mt-[-10px] relative z-0">
                <div
                    class="pipe w-20 h-16 rounded-b-xl border-b-8 border-slate-500 shadow-[0_10px_10px_rgba(0,0,0,0.2)]">
                </div>
                <!-- Bola Hasil (Animasi Keluar) -->
                <div id="ball-out"
                    class="absolute top-10 w-20 h-20 bg-gradient-to-br from-amber-300 to-amber-500 rounded-full shadow-[inset_0_0_15px_rgba(255,255,255,0.5),_0_10px_20px_rgba(0,0,0,0.4)] flex items-center justify-center text-amber-900 font-black text-4xl border-4 border-white opacity-0 transition-all duration-500 transform scale-50">
                    ?
                </div>
            </div>
        </div>

        <!-- BAGIAN PILIHAN JAWABAN (Kanan) -->
        <div class="w-full max-w-sm flex flex-col gap-4 md:gap-6 pointer-events-auto z-20 mt-12 md:mt-0">
            <div class="text-center mb-2">
                <span
                    class="bg-indigo-600 text-white font-black px-6 py-2 rounded-full uppercase tracking-widest text-sm shadow-md border-2 border-indigo-300 inline-block">
                    Pilih Hasilnya!
                </span>
            </div>

            <div id="options-container" class="flex flex-col gap-4 w-full">
                <!-- Pilihan Jawaban Dirender via JS -->
            </div>
        </div>
    </div>

    <!-- Indikator Progres Dots -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 md:translate-x-0 md:left-8 flex gap-3 pointer-events-auto bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full border-2 border-white shadow-lg z-40"
        id="progress-dots">
        <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
        <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
        <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
        <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
        <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-inner dot"></div>
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
                // Bunyi bola jatuh (bloop)
                osc.type = "sine";
                osc.frequency.setValueAtTime(600, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    300,
                    audioCtx.currentTime + 0.15,
                );
                gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.15,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.15);
            } else if (type === "machine-process") {
                // Bunyi mesin bekerja (rumble/buzz)
                osc.type = "sawtooth";
                osc.frequency.setValueAtTime(100, audioCtx.currentTime);
                osc.frequency.linearRampToValueAtTime(
                    150,
                    audioCtx.currentTime + 0.5,
                );
                osc.frequency.linearRampToValueAtTime(
                    100,
                    audioCtx.currentTime + 1.0,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.2);
                gain.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 1.0);
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 1.0);
            } else if (type === "success") {
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1);
                osc.frequency.setValueAtTime(783.99, audioCtx.currentTime + 0.2);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.3);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
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

        // --- Data Permainan (Matematika Kelas 3 - Level 2) ---
        const rounds = [{
                num1: 125,
                op: "+",
                num2: 210,
                ans: 335,
                opts: [335, 315, 345]
            },
            {
                num1: 402,
                op: "-",
                num2: 100,
                ans: 302,
                opts: [302, 312, 292]
            },
            {
                num1: 350,
                op: "+",
                num2: 120,
                ans: 470,
                opts: [470, 460, 480]
            },
            {
                num1: 600,
                op: "-",
                num2: 250,
                ans: 350,
                opts: [350, 360, 340]
            },
            {
                num1: 275,
                op: "+",
                num2: 300,
                ans: 575,
                opts: [575, 565, 585]
            },
        ];

        const colorPalettes = [{
                bg: "bg-white",
                border: "border-blue-300",
                shadow: "shadow-[0_8px_0_#93c5fd]",
                text: "text-blue-900",
            },
            {
                bg: "bg-white",
                border: "border-green-300",
                shadow: "shadow-[0_8px_0_#86efac]",
                text: "text-green-900",
            },
            {
                bg: "bg-white",
                border: "border-rose-300",
                shadow: "shadow-[0_8px_0_#fda4af]",
                text: "text-rose-900",
            },
        ];

        let currentRound = 0;
        let currentState = "ANIMATING_MACHINE"; // ANIMATING_MACHINE, SELECTING
        let isAnimating = true;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        // DOM Elements
        const equationDisplay = document.getElementById("equation-display");
        const operatorDisplay = document.getElementById("operator-display");
        const ball1 = document.getElementById("ball-1");
        const ball2 = document.getElementById("ball-2");
        const ballOut = document.getElementById("ball-out");
        const mathMachine = document.getElementById("math-machine");
        const reactorGlow = document.getElementById("reactor-glow");
        const optionsContainer = document.getElementById("options-container");
        const owlMessage = document.getElementById("owl-message");

        // Cursor Elements
        const cursorElement = document.getElementById("hand-cursor");
        const cursorProgress = document.getElementById("cursor-progress");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            let progress = (currentRound / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function renderRound() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            currentState = "ANIMATING_MACHINE";
            isAnimating = true;

            // Reset UI Elements
            equationDisplay.innerText = `${round.num1} ${round.op} ${round.num2} = ?`;
            operatorDisplay.innerText = round.op;

            // Color coding operator
            if (round.op === "+") {
                reactorGlow.className =
                    "absolute inset-0 bg-blue-500 opacity-20 blur-xl transition-all duration-300";
            } else {
                reactorGlow.className =
                    "absolute inset-0 bg-rose-500 opacity-20 blur-xl transition-all duration-300";
            }

            owlMessage.innerText = "Mesin sedang bekerja! Perhatikan angkanya...";
            optionsContainer.innerHTML = "";

            // Reset balls
            ball1.innerText = round.num1;
            ball2.innerText = round.num2;
            ballOut.innerText = "?";

            ball1.classList.remove("animate-ball-drop");
            ball2.classList.remove("animate-ball-drop");
            ballOut.style.opacity = "0";
            ballOut.style.transform = "scale(0.5)";

            // Force reflow
            void ball1.offsetWidth;
            void ball2.offsetWidth;

            // Mulai Sekuens Animasi Mesin
            setTimeout(() => {
                // 1. Bola masuk
                playSound("drop");
                ball1.classList.add("animate-ball-drop");

                setTimeout(() => {
                    playSound("drop");
                    ball2.classList.add("animate-ball-drop");
                }, 400);

                // 2. Mesin memproses
                setTimeout(() => {
                    playSound("machine-process");
                    mathMachine.classList.add("animate-machine-work");
                    if (round.op === "+") {
                        reactorGlow.classList.replace("opacity-20", "opacity-80");
                    } else {
                        reactorGlow.classList.replace("opacity-20", "opacity-80");
                    }
                }, 1200);

                // 3. Keluarkan hasil & Tampilkan Opsi
                setTimeout(() => {
                    mathMachine.classList.remove("animate-machine-work");
                    reactorGlow.classList.replace("opacity-80", "opacity-20");

                    playSound("drop");
                    ballOut.style.opacity = "1";
                    ballOut.style.transform = "scale(1)";

                    // Render Opsi Jawaban
                    renderOptions(round);

                    owlMessage.innerText = "Pilih jawaban yang benar dengan jarimu!";
                    currentState = "SELECTING";
                    isAnimating = false;
                }, 2800);
            }, 500);

            updateProgressDots();
        }

        function renderOptions(round) {
            // Acak posisi pilihan
            const shuffledOptions = [...round.opts].sort(() => Math.random() - 0.5);

            shuffledOptions.forEach((opt, index) => {
                const btn = document.createElement("div");
                const palette = colorPalettes[index % colorPalettes.length];

                btn.id = `opt-${opt}`;
                btn.dataset.correct = opt === round.ans;

                btn.className =
                    `option-card relative w-full h-24 md:h-28 rounded-2xl flex items-center justify-center border-4 transition-all duration-300 cursor-pointer ${palette.bg} ${palette.border} ${palette.shadow} animate-pop-in`;
                btn.style.animationDelay = `${index * 0.1}s`;

                btn.innerHTML =
                    `<span class="font-fun text-5xl md:text-6xl ${palette.text} pointer-events-none tracking-wider">${opt}</span>`;

                optionsContainer.appendChild(btn);
            });
        }

        function handleSelection(selectedAns) {
            if (isAnimating || currentState !== "SELECTING") return;
            isAnimating = true;

            const round = rounds[currentRound];
            const btn = document.getElementById(`opt-${selectedAns}`);
            const isCorrect = parseInt(selectedAns) === round.ans;

            if (isCorrect) {
                // --- BENAR ---
                playSound("success");
                btn.classList.add("animate-glow-gold");

                // Ganti bola hasil jadi jawaban
                ballOut.innerText = round.ans;
                ballOut.classList.replace("from-amber-300", "from-green-400");
                ballOut.classList.replace("to-amber-500", "to-green-600");
                ballOut.classList.add("animate-bounce-slight");

                // Mesin menyala hijau
                reactorGlow.className =
                    "absolute inset-0 bg-green-500 opacity-80 blur-xl transition-all duration-300";
                mathMachine.style.borderColor = "#4ade80"; // green-400

                owlMessage.innerText = "Benar! Kamu sangat teliti.";

                const rect = mathMachine.getBoundingClientRect();
                const x = (rect.left + rect.width / 2) / window.innerWidth;
                const y = (rect.top + rect.height / 2) / window.innerHeight;
                confetti({
                    particleCount: 50,
                    spread: 80,
                    origin: {
                        x,
                        y
                    },
                    colors: ["#4ade80", "#3b82f6", "#facc15"],
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
                    ballOut.classList.remove("animate-bounce-slight");
                    ballOut.classList.replace("from-green-400", "from-amber-300");
                    ballOut.classList.replace("to-green-600", "to-amber-500");
                    mathMachine.style.borderColor = "";
                    currentRound++;
                    renderRound();
                }, 2500);
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    numerasi: -1
                });
                // --- SALAH ---
                playSound("error");
                btn.classList.add(
                    "animate-shake",
                    "!bg-red-100",
                    "!border-red-400",
                    "!shadow-[0_8px_0_#f87171]",
                );
                btn.querySelector("span").classList.add("!text-red-700");

                mathMachine.classList.add("animate-shake");
                reactorGlow.className =
                    "absolute inset-0 bg-red-500 opacity-60 blur-xl transition-all duration-300";

                owlMessage.innerText = "Kurang tepat. Ayo hitung lagi!";

                mistakesMade++;
                if (roundResults.length < currentRound + 1)
                    roundResults.push("wrong");
                updateProgressDots();

                setTimeout(() => {
                    btn.classList.remove(
                        "animate-shake",
                        "!bg-red-100",
                        "!border-red-400",
                        "!shadow-[0_8px_0_#f87171]",
                    );
                    btn.querySelector("span").classList.remove("!text-red-700");
                    mathMachine.classList.remove("animate-shake");

                    // Restore core color
                    if (round.op === "+")
                        reactorGlow.className =
                        "absolute inset-0 bg-blue-500 opacity-20 blur-xl transition-all duration-300";
                    else
                        reactorGlow.className =
                        "absolute inset-0 bg-rose-500 opacity-20 blur-xl transition-all duration-300";

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
            currentState = "VICTORY";
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            // Perhitungan XP sesuai rules
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
                titleText = "Hitungan Sempurna!";
                descText = "Luar biasa! Mesin beroperasi tanpa kendala.";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Kamu sudah pandai berhitung.";
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
                    colors: ["#3b82f6", "#22d3ee", "#facc15", "#4ade80"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#3b82f6", "#22d3ee", "#facc15", "#4ade80"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
        }

        // --- SISTEM HOVER INTERACTION (KAMERA TANGAN) ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let hoveredElementId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_CLICK = 1200; // 1.2s untuk mengunci jawaban

        function updateGameLoop(timestamp) {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (currentState === "SELECTING" && !isAnimating) {
                let btnHovered = null;
                const actionBtns = document.querySelectorAll(".option-card");

                actionBtns.forEach((btn) => {
                    const rect = btn.getBoundingClientRect();
                    const padding = 15;
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
                    const currentId = btnHovered.id.replace("opt-", "");

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
                            handleSelection(currentId);

                            hoveredElementId = null;
                            hoverStartTime = 0;
                            cursorProgress.style.strokeDashoffset = 226.2;
                        }
                    } else {
                        hoveredElementId = currentId;
                        hoverStartTime = timestamp;
                        actionBtns.forEach((b) =>
                            b.classList.remove(
                                "scale-105",
                                "animate-bounce-slight",
                                "shadow-[0_0_20px_rgba(59,130,246,0.5)]",
                            ),
                        );
                        btnHovered.classList.add(
                            "scale-105",
                            "animate-bounce-slight",
                            "shadow-[0_0_20px_rgba(59,130,246,0.5)]",
                        );
                    }
                } else {
                    if (hoveredElementId) {
                        const oldBtn = document.getElementById(`opt-${hoveredElementId}`);
                        if (oldBtn)
                            oldBtn.classList.remove(
                                "scale-105",
                                "animate-bounce-slight",
                                "shadow-[0_0_20px_rgba(59,130,246,0.5)]",
                            );
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
