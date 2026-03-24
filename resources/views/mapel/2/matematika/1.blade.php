<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Matematika Kelas 2 - Level 1: Mengenal Bilangan 100</title>
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

        .font-numbers {
            font-family: "Fredoka One", cursive;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
        }

        /* Animasi Awan & Latar */
        @keyframes drift-slow {
            from {
                transform: translateX(-20%);
            }

            to {
                transform: translateX(120vw);
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
            animation: drift-slow 40s linear infinite;
        }

        .animate-drift-fast {
            animation: drift-fast 25s linear infinite;
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
            animation: pop-in 0.5s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Animasi Balon Melayang */
        @keyframes float-balloon-1 {

            0%,
            100% {
                transform: translateY(0px) rotate(-2deg);
            }

            50% {
                transform: translateY(-25px) rotate(2deg);
            }
        }

        @keyframes float-balloon-2 {

            0%,
            100% {
                transform: translateY(0px) rotate(3deg);
            }

            50% {
                transform: translateY(-20px) rotate(-3deg);
            }
        }

        @keyframes float-balloon-3 {

            0%,
            100% {
                transform: translateY(0px) rotate(-1deg);
            }

            50% {
                transform: translateY(-30px) rotate(1deg);
            }
        }

        .balloon-float-1 {
            animation: float-balloon-1 4s ease-in-out infinite;
        }

        .balloon-float-2 {
            animation: float-balloon-2 3.5s ease-in-out infinite;
        }

        .balloon-float-3 {
            animation: float-balloon-3 4.5s ease-in-out infinite;
        }

        /* Bentuk Balon CSS Murni */
        .balloon-shape {
            border-radius: 50% 50% 50% 50% / 40% 40% 60% 60%;
            box-shadow:
                inset -10px -10px 20px rgba(0, 0, 0, 0.2),
                inset 10px 10px 20px rgba(255, 255, 255, 0.5),
                0 10px 15px rgba(0, 0, 0, 0.1);
            transition:
                transform 0.2s,
                box-shadow 0.2s;
        }

        /* Ekor Balon */
        .balloon-tail {
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 12px solid currentColor;
        }

        /* Tali Balon */
        .balloon-string {
            position: absolute;
            bottom: -40px;
            left: 50%;
            width: 2px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.6);
            transform-origin: top;
            animation: swing-string 3s ease-in-out infinite;
        }

        @keyframes swing-string {

            0%,
            100% {
                transform: rotate(-10deg);
            }

            50% {
                transform: rotate(10deg);
            }
        }

        /* Animasi Memecahkan Balon */
        @keyframes balloon-pop {
            0% {
                transform: scale(1);
                filter: brightness(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.3);
                filter: brightness(1.5);
                opacity: 0.8;
            }

            100% {
                transform: scale(2);
                filter: brightness(2);
                opacity: 0;
            }
        }

        .animate-balloon-pop {
            animation: balloon-pop 0.3s ease-out forwards;
            pointer-events: none;
        }

        /* Animasi Teks XP Melayang */
        @keyframes float-up-fade {
            0% {
                transform: translate(-50%, 0) scale(1);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50px) scale(1.2);
                opacity: 0;
            }
        }

        .animate-float-up-fade {
            animation: float-up-fade 1s ease-out forwards;
            pointer-events: none;
        }

        /* Animasi Salah */
        @keyframes shake-balloon {

            0%,
            100% {
                transform: translateX(0) rotate(0);
            }

            20%,
            60% {
                transform: translateX(-15px) rotate(-10deg);
            }

            40%,
            80% {
                transform: translateX(15px) rotate(10deg);
            }
        }

        .animate-shake-balloon {
            animation: shake-balloon 0.4s ease-in-out;
        }

        /* Hover highlight */
        .balloon-wrapper.hover-highlight .balloon-shape {
            transform: scale(1.1);
            box-shadow:
                0 0 25px 10px rgba(255, 255, 255, 0.8),
                inset -10px -10px 20px rgba(0, 0, 0, 0.2);
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

        .cursor-icon {
            font-size: 3.5rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
            transition: transform 0.1s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-sky-300 via-sky-200 to-blue-100 h-screen w-full relative overflow-hidden">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute" width="80" height="80">
            <circle class="progress-ring__circle" stroke="#f59e0b" stroke-width="6" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <!-- Kursor diubah menjadi jarum untuk memecahkan balon -->
        <div id="cursor-emoji" class="cursor-icon rotate-[135deg]">📌</div>
    </div>

    <!-- --- SCENERY BACKGROUND --- -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <!-- Matahari -->
        <div class="absolute top-[10%] right-[10%] text-9xl drop-shadow-[0_0_40px_#fef08a] animate-pulse-glow">
            ☀️
        </div>

        <!-- Awan Melayang -->
        <div class="absolute top-[15%] left-[-20%] animate-drift-slow opacity-90">
            <svg width="180" height="90" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute top-[35%] left-[-10%] animate-drift-fast opacity-70 scale-75">
            <svg width="250" height="120" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>

        <!-- Bintang-bintang kecil -->
        <div class="absolute top-[20%] left-[30%] text-white opacity-40 text-2xl">
            ✨
        </div>
        <div class="absolute top-[40%] right-[25%] text-white opacity-50 text-3xl">
            ✨
        </div>
        <div class="absolute bottom-[30%] left-[20%] text-white opacity-40 text-4xl">
            ✨
        </div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full pointer-events-none">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/70 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg pointer-events-auto">
            <div
                class="w-14 h-14 bg-sky-500 rounded-full border-2 border-white flex items-center justify-center text-3xl shadow-inner">
                👦🏽
            </div>
            <div>
                <h2 class="font-black text-xl text-sky-900 tracking-wide drop-shadow-sm">
                    Penjelajah Level 2
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-white/70 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-sky-800 text-lg mb-1" id="xp-text">0 XP</span>
                <div class="w-48 h-5 bg-sky-900/20 rounded-full overflow-hidden shadow-inner border border-sky-200">
                    <div id="xp-bar-fill"
                        class="h-full bg-gradient-to-r from-yellow-300 to-amber-400 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-sky-300 mb-2 max-w-[200px]">
                    <p id="owl-message" class="font-bold text-sky-800 text-sm">
                        Arahkan jarummu untuk memecahkan balon angka!
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

    <!-- --- MAIN GAME AREA --- -->
    <div class="absolute inset-0 top-24 bottom-10 z-10 flex flex-col items-center pointer-events-none">
        <!-- TARGET ANGKA (Kartu Petunjuk) -->
        <div class="text-center mb-8 shrink-0 pointer-events-auto mt-4">
            <div
                class="bg-white/95 backdrop-blur-sm px-10 py-4 rounded-[2rem] border-8 border-sky-300 shadow-[0_15px_0_#bae6fd,_0_20px_25px_rgba(0,0,0,0.3)] flex items-center gap-6">
                <div class="flex flex-col items-center">
                    <span class="text-lg font-black text-sky-600 uppercase tracking-widest mb-1">Cari Angka:</span>
                    <span id="target-number"
                        class="font-numbers text-6xl md:text-8xl text-sky-900 tracking-wide drop-shadow-md">47</span>
                </div>
                <!-- Tombol Speaker -->
                <button onclick="playTargetSpeech()"
                    class="bg-yellow-400 hover:bg-yellow-500 p-4 rounded-full border-4 border-white shadow-md transition-transform hover:scale-110 ml-4">
                    <i data-lucide="volume-2" class="text-white w-10 h-10"></i>
                </button>
            </div>
        </div>

        <!-- AREA BALON (BALLOONS YARD) -->
        <div id="balloons-container"
            class="relative w-full max-w-5xl h-[40vh] flex justify-center items-center gap-6 md:gap-12 pointer-events-auto mt-4">
            <!-- Balon akan dirender di sini via JS -->
        </div>

        <!-- Indikator Progres -->
        <div class="absolute bottom-6 flex gap-3 bg-white/50 backdrop-blur-sm px-6 py-3 rounded-full border-2 border-white shadow-lg pointer-events-auto"
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
                        kelas: '2',
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
        // --- Audio System ---
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        function playSound(type) {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === "pop") {
                // Suara letupan balon yang kencang dan renyah
                osc.type = "sine";
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    100,
                    audioCtx.currentTime + 0.1,
                );
                gain.gain.setValueAtTime(0.8, audioCtx.currentTime);
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
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.3,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
            } else if (type === "error") {
                osc.type = "sawtooth";
                osc.frequency.setValueAtTime(150, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    80,
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

        // --- Data Permainan (Matematika Kelas 2) ---
        const rounds = [{
                target: 12,
                speechText: "Dua belas",
                options: [12, 21, 14, 18]
            },
            {
                target: 25,
                speechText: "Dua puluh lima",
                options: [25, 52, 29, 31]
            },
            {
                target: 40,
                speechText: "Empat puluh",
                options: [40, 44, 34, 60]
            },
            {
                target: 67,
                speechText: "Enam puluh tujuh",
                options: [67, 76, 61, 70],
            },
            {
                target: 83,
                speechText: "Delapan puluh tiga",
                options: [83, 38, 81, 90],
            },
        ];

        const balloonColors = [{
                bg: "bg-pink-400",
                text: "text-pink-900"
            },
            {
                bg: "bg-blue-400",
                text: "text-blue-900"
            },
            {
                bg: "bg-emerald-400",
                text: "text-emerald-900"
            },
            {
                bg: "bg-amber-400",
                text: "text-amber-900"
            },
            {
                bg: "bg-purple-400",
                text: "text-purple-900"
            },
        ];

        const floatClasses = [
            "balloon-float-1",
            "balloon-float-2",
            "balloon-float-3",
        ];

        let currentRound = 0;
        let currentState = "PLAYING";
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        // Variabel baru untuk sistem penalti XP
        let currentRoundXP = 10;
        let totalAnswersXP = 0;

        const targetNumberDisplay = document.getElementById("target-number");
        const balloonsContainer = document.getElementById("balloons-container");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const cursorProgress = document.getElementById("cursor-progress");

        function updateXPBar() {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress = (currentRound / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function playTargetSpeech() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.speechText);
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
            currentState = "PLAYING";
            currentRoundXP = 10; // Reset hadiah maksimal XP di awal ronde

            targetNumberDisplay.innerText = round.target;
            owlMessage.innerText = `Arahkan jarummu ke balon angka ${round.target}!`;

            balloonsContainer.innerHTML = "";

            const shuffledOptions = [...round.options].sort(
                () => Math.random() - 0.5,
            );

            shuffledOptions.forEach((num, index) => {
                const wrapper = document.createElement("div");
                wrapper.className = `balloon-wrapper relative ${floatClasses[index % floatClasses.length]}`;

                // Buat elemen balon utama
                const balloon = document.createElement("div");
                balloon.id = `balloon-${num}`;
                balloon.dataset.val = num;

                const palette = balloonColors[index % balloonColors.length];

                balloon.className =
                    `balloon-shape relative w-24 h-32 md:w-32 md:h-40 flex items-center justify-center font-numbers text-5xl md:text-6xl ${palette.bg} ${palette.text} cursor-pointer z-10`;
                balloon.innerText = num;

                // Tambahkan simpul/ekor di bawah balon menggunakan border CSS
                const tail = document.createElement("div");
                tail.className = `balloon-tail text-${palette.bg.replace("bg-", "")}`;
                balloon.appendChild(tail);

                // Tambahkan tali yang menjuntai ke bawah
                const string = document.createElement("div");
                string.className = "balloon-string";
                balloon.appendChild(string);

                wrapper.appendChild(balloon);
                balloonsContainer.appendChild(wrapper);
            });

            updateProgressDots();

            // Putar suara otomatis di awal ronde
            setTimeout(playTargetSpeech, 500);
            isAnimating = false;
        }

        function handleSelection(selectedNum) {
            if (isAnimating || currentState !== "PLAYING") return;
            isAnimating = true;

            const round = rounds[currentRound];
            // Temukan elemen wrapper karena yang dianimasikan letupan adalah balloon-shape
            const balloonEl = document.getElementById(`balloon-${selectedNum}`);
            const wrapper = balloonEl.parentElement;

            // Ambil posisi balon untuk efek visual
            const rect = balloonEl.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            if (parseInt(selectedNum) === round.target) {
                // --- BENAR ---
                playSound("pop");
                setTimeout(() => playSound("success"), 150);

                balloonEl.classList.add("animate-balloon-pop");
                owlMessage.innerText = `DOR! Kamu memecahkan balon yang benar! (+${currentRoundXP} XP)`;

                confetti({
                    particleCount: 50,
                    spread: 80,
                    origin: {
                        x: centerX / window.innerWidth,
                        y: centerY / window.innerHeight,
                    },
                    colors: ["#facc15", "#f472b6", "#38bdf8"],
                });

                // Memunculkan teks +XP melayang
                const xpText = document.createElement("div");
                xpText.className =
                    "absolute text-green-500 font-black text-4xl drop-shadow-md animate-float-up-fade z-50";
                xpText.innerText = `+${currentRoundXP} XP`;
                xpText.style.left = `${centerX}px`;
                xpText.style.top = `${rect.top}px`;
                document.body.appendChild(xpText);
                setTimeout(() => xpText.remove(), 1000);
                updateAssessment(assessment, {
                    numerasi: 3,
                    logika: 2,
                    visual: 1
                });
                xp += currentRoundXP;
                levelEarnedXP += currentRoundXP;
                totalAnswersXP += currentRoundXP;
                correctAnswersCount++;

                if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                    roundResults.push("correct");
                }
                updateXPBar();

                setTimeout(() => {
                    currentRound++;
                    renderRound();
                }, 1500);
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    numerasi: -1
                });
                // --- SALAH ---
                playSound("error");
                wrapper.classList.add("animate-shake-balloon");

                // Kurangi XP (Penalti 5 XP, minimal 0)
                let lostXP = 0;
                if (currentRoundXP > 0) {
                    currentRoundXP = Math.max(0, currentRoundXP - 5);
                    lostXP = 5;
                }

                if (lostXP > 0) {
                    owlMessage.innerText = `Bukan itu! (-5 XP). Ayo cari angka ${round.target}!`;

                    // Memunculkan teks -5 XP melayang
                    const xpText = document.createElement("div");
                    xpText.className =
                        "absolute text-red-500 font-black text-4xl drop-shadow-md animate-float-up-fade z-50";
                    xpText.innerText = `-5 XP`;
                    xpText.style.left = `${centerX}px`;
                    xpText.style.top = `${rect.top}px`;
                    document.body.appendChild(xpText);
                    setTimeout(() => xpText.remove(), 1000);
                } else {
                    owlMessage.innerText = `Tetap bukan itu! Ayo semangat perhatikan angkanya!`;
                }

                mistakesMade++;
                if (roundResults.length < currentRound + 1)
                    roundResults.push("wrong");
                updateProgressDots();

                setTimeout(() => {
                    wrapper.classList.remove("animate-shake-balloon");
                    isAnimating = false;
                }, 1000);
            }
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-4 h-4 bg-green-400 border-2 border-green-200 rounded-full shadow-[0_0_10px_#4ade80] dot" :
                        "w-4 h-4 bg-red-400 border-2 border-red-200 rounded-full shadow-sm dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-4 h-4 bg-yellow-400 border-2 border-yellow-200 rounded-full shadow-[0_0_10px_#facc15] animate-pulse dot";
                } else {
                    dot.className =
                        "w-4 h-4 bg-white/50 border-2 border-white rounded-full shadow-sm dot";
                }
            });
        }

        function showVictory() {
            currentState = "VICTORY";
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            const levelCompletionXP = 20;
            const isFlawlessOverall = roundResults.every((r) => r === "correct");
            const flawlessBonusXP = isFlawlessOverall ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;
            updateXPBar();

            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Kamu sudah mencoba dengan baik!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 5) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Kamu Ahli Bilangan!";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Pemahaman angkamu hampir sempurna!";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-yellow-400 fill-current drop-shadow-[0_0_15px_#facc15] animate-bounce-slight" style="animation-delay: ${i * 0.1}s"></i>`;
                } else {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-sky-200 fill-current drop-shadow-sm"></i>`;
                }
            }
            lucide.createIcons();

            document.getElementById("victory-title").innerText = titleText;
            document.getElementById("victory-subtitle").innerText = descText;

            document.getElementById("correct-count").innerText =
                correctAnswersCount;
            document.getElementById("xp-answers").innerText =
                `+${totalAnswersXP} XP`; // Tampilkan akumulasi XP sebenarnya

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
                    colors: ["#facc15", "#f472b6", "#38bdf8", "#4ade80"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#facc15", "#f472b6", "#38bdf8", "#4ade80"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        // --- SISTEM PELACAKAN TANGAN & KURSOR ---
        const videoElement = document.getElementById("input_video");
        const cursorElement = document.getElementById("hand-cursor");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let hoveredButtonId = null;
        let hoverStartTime = 0;
        const HOVER_DURATION_TO_CLICK = 1200; // 1.2s agar cukup aman tidak sengaja meledak

        function updateCursorUI(timestamp) {
            cursorX += (targetX - cursorX) * 0.7;
            cursorY += (targetY - cursorY) * 0.7;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (currentState === "PLAYING" && !isAnimating) {
                let btnHovered = null;
                // Cari elemen balon utamanya (.balloon-shape)
                const interactableElements = document.querySelectorAll(
                    ".balloon-shape:not(.animate-balloon-pop)",
                );

                interactableElements.forEach((btn) => {
                    const rect = btn.getBoundingClientRect();
                    // Menggunakan hitbox melingkar
                    const radius = rect.width / 2;
                    const centerX = rect.left + radius;
                    const centerY = rect.top + rect.height / 2; // Pakai tinggi rect agar tengah akurat
                    const distance = Math.hypot(cursorX - centerX, cursorY - centerY);

                    if (distance <= radius + 20) {
                        // Toleransi 20px
                        btnHovered = btn;
                    }
                });

                if (btnHovered) {
                    const currentId = btnHovered.dataset.val;

                    // Ubah rotasi kursor agar seperti mau menusuk
                    cursorEmoji.style.transform = "scale(1.4) rotate(45deg)";

                    if (hoveredButtonId === currentId) {
                        if (!hoverStartTime) hoverStartTime = timestamp;
                        const elapsed = timestamp - hoverStartTime;

                        const percentage = Math.min(elapsed / HOVER_DURATION_TO_CLICK, 1);
                        cursorProgress.style.strokeDashoffset = 226.2 * (1 - percentage);

                        if (elapsed >= HOVER_DURATION_TO_CLICK) {
                            handleSelection(currentId);
                            hoveredButtonId = null;
                            hoverStartTime = 0;
                            cursorProgress.style.strokeDashoffset = 226.2;
                        }
                    } else {
                        hoveredButtonId = currentId;
                        hoverStartTime = timestamp;

                        // Hilangkan hover dari wrapper lain
                        document
                            .querySelectorAll(".balloon-wrapper")
                            .forEach((w) => w.classList.remove("hover-highlight"));
                        btnHovered.parentElement.classList.add("hover-highlight");
                    }
                } else {
                    cursorEmoji.style.transform = "scale(1) rotate(135deg)";

                    if (hoveredButtonId) {
                        const oldWrapper = document.getElementById(
                            `balloon-${hoveredButtonId}`,
                        )?.parentElement;
                        if (oldWrapper) oldWrapper.classList.remove("hover-highlight");
                    }
                    hoveredButtonId = null;
                    hoverStartTime = 0;
                    cursorProgress.style.strokeDashoffset = 226.2;
                }
            } else {
                cursorEmoji.style.transform = "scale(1) rotate(135deg)";
                cursorProgress.style.strokeDashoffset = 226.2;
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
