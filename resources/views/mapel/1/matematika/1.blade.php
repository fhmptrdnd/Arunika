<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Matematika - Level 1: Mengenal Angka 1-10</title>
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

        @keyframes bubble-pop {
            0% {
                transform: scale(1);
                opacity: 1;
                filter: brightness(1);
            }

            50% {
                transform: scale(1.3);
                opacity: 0.8;
                filter: brightness(1.5);
            }

            100% {
                transform: scale(2);
                opacity: 0;
                filter: brightness(2);
            }
        }

        .animate-bubble-pop {
            animation: bubble-pop 0.3s ease-out forwards;
            pointer-events: none;
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

        /* Animasi Melayang untuk Gelembung */
        @keyframes float-bubble-1 {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(2deg);
            }
        }

        @keyframes float-bubble-2 {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-25px) rotate(-2deg);
            }
        }

        @keyframes float-bubble-3 {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(3deg);
            }
        }

        .float-1 {
            animation: float-bubble-1 4s ease-in-out infinite;
        }

        .float-2 {
            animation: float-bubble-2 5s ease-in-out infinite;
        }

        .float-3 {
            animation: float-bubble-3 3.5s ease-in-out infinite;
        }

        /* Hover pause untuk gelembung agar mudah di-lock */
        .bubble:hover,
        .bubble.hovered {
            animation-play-state: paused !important;
            transform: scale(1.1) !important;
            box-shadow:
                0 0 25px 10px rgba(255, 255, 255, 0.7),
                inset 0 0 20px rgba(255, 255, 255, 0.8);
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

<body class="bg-gradient-to-b from-blue-300 via-sky-200 to-green-300 h-screen w-full relative">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute" width="80" height="80">
            <circle class="progress-ring__circle" stroke="#fbbf24" stroke-width="8" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <div id="cursor-emoji"
            style="
          font-size: 3rem;
          filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
          transition: transform 0.2s;
        ">
            🎯
        </div>
    </div>

    <!-- --- SCENERY BACKGROUND --- -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <!-- Awan -->
        <div class="absolute top-10 left-[-20%] animate-drift-slow opacity-80">
            <svg width="150" height="80" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute top-40 left-[-10%] animate-drift-fast opacity-60 scale-75">
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
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/60 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg">
            <div
                class="w-14 h-14 bg-orange-400 rounded-full border-4 border-white flex items-center justify-center text-3xl shadow-inner">
                👦🏽
            </div>
            <div>
                <h2 class="font-black text-xl text-orange-900 tracking-wide drop-shadow-sm">
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
                <span class="font-black text-orange-600 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-48 h-5 bg-orange-900/20 rounded-full overflow-hidden shadow-inner border-2 border-white/50 relative">
                    <div id="xp-bar-fill"
                        class="absolute top-0 left-0 h-full bg-gradient-to-r from-yellow-300 to-orange-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Kamera Tangan & Maskot -->
        <div class="flex items-start gap-4">
            <div class="relative hidden lg:flex flex-col items-end pt-4 animate-float">
                <div
                    class="bg-white px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-orange-200 mb-2 max-w-[220px]">
                    <p id="owl-message" class="font-bold text-orange-900 text-sm">
                        Hitung dan pecahkan gelembung yang tepat!
                    </p>
                </div>
                <!-- Maskot Rubah (Fox) untuk Matematika biar beda -->
                <div class="text-6xl drop-shadow-lg">🦊</div>
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

    <!-- --- MAIN GAME AREA --- -->
    <div class="absolute inset-0 top-28 bottom-10 z-10 flex flex-col items-center pointer-events-none pt-4">
        <!-- TARGET ANGKA RAKSASA -->
        <div id="target-container"
            class="bg-white/95 backdrop-blur-md px-10 py-4 rounded-[3rem] shadow-[0_15px_30px_rgba(0,0,0,0.15)] border-8 border-orange-300 flex flex-col items-center pointer-events-auto transform transition-transform duration-300 z-20">
            <h3 class="text-lg md:text-xl text-orange-500 font-black uppercase tracking-widest mb-1">
                Cari Gelembung Berisi:
            </h3>
            <div class="flex items-center gap-4">
                <span id="target-number" class="text-6xl md:text-8xl font-black text-orange-600 drop-shadow-sm">5</span>
            </div>
        </div>

        <!-- AREA GELEMBUNG (BUBBLES) -->
        <div id="bubbles-container"
            class="flex flex-wrap justify-center items-center gap-8 md:gap-16 w-full max-w-5xl mt-12 flex-1 pointer-events-auto px-4 pb-8">
            <!-- Bubbles akan dirender di sini oleh JS -->
        </div>

        <!-- Indikator Progres -->
        <div class="flex gap-3 mb-4 pointer-events-auto bg-white/50 backdrop-blur-md px-6 py-3 rounded-full border-2 border-white shadow-lg"
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
                        kelas: '1',
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
        // --- Sistem Audio Sederhana (Web Audio API) ---
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        function playSound(type) {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === "pop") {
                // Suara Pop Gelembung
                osc.type = "sine";
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    200,
                    audioCtx.currentTime + 0.1,
                );
                gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.1,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.1);
            } else if (type === "success") {
                osc.type = "sine";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.1);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.2);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.4,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.4);
            } else if (type === "error") {
                osc.type = "triangle";
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
                osc.frequency.setValueAtTime(659.25, audioCtx.currentTime);
                osc.frequency.setValueAtTime(1046.5, audioCtx.currentTime + 0.15);
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.6,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.6);
            }
        }

        // --- Data Permainan (Matematika Level 1) ---
        const rounds = [{
                targetNum: 3,
                emoji: "🍓",
                options: [2, 3, 4]
            },
            {
                targetNum: 5,
                emoji: "🐟",
                options: [4, 5, 6]
            },
            {
                targetNum: 7,
                emoji: "🎈",
                options: [6, 7, 8]
            },
            {
                targetNum: 4,
                emoji: "🚗",
                options: [2, 4, 5]
            },
            {
                targetNum: 8,
                emoji: "🍩",
                options: [7, 8, 9]
            },
        ];

        // Animasi float untuk gelembung agar terlihat natural
        const floatClasses = ["float-1", "float-2", "float-3"];

        let currentRound = 0;
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        const targetNumberDisplay = document.getElementById("target-number");
        const bubblesContainer = document.getElementById("bubbles-container");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const targetContainer = document.getElementById("target-container");

        function updateXPBar(tempRoundOffset = 0) {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress =
                ((currentRound + tempRoundOffset) / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function renderRound() {
            const round = rounds[currentRound];

            targetContainer.classList.add("animate-pop-in");
            setTimeout(
                () => targetContainer.classList.remove("animate-pop-in"),
                500,
            );

            targetNumberDisplay.innerText = round.targetNum;
            owlMessage.innerText = `Pecahkan gelembung yang berisi ${round.targetNum} benda!`;

            bubblesContainer.innerHTML = "";

            // Acak posisi gelembung
            const shuffledOptions = [...round.options].sort(
                () => Math.random() - 0.5,
            );

            shuffledOptions.forEach((num, index) => {
                const bubbleWrapper = document.createElement("div");
                // Tambahkan kelas float animasi agar gelembung melayang-layang
                bubbleWrapper.className = `${floatClasses[index % floatClasses.length]} p-2`;

                const bubble = document.createElement("div");
                bubble.id = `bubble-${num}`;

                // Desain Gelembung Transparan (Glassmorphism)
                bubble.className =
                    `bubble relative w-40 h-40 md:w-48 md:h-48 rounded-full bg-white/30 backdrop-blur-sm border-2 border-white/80 shadow-[inset_0_0_20px_rgba(255,255,255,0.6),_0_10px_20px_rgba(0,0,0,0.1)] flex flex-wrap justify-center content-center items-center gap-1 p-4 cursor-pointer transition-all duration-300`;

                // Isi gelembung dengan emoji sejumlah angka
                let emojisHtml = "";
                for (let i = 0; i < num; i++) {
                    // Ukuran emoji disesuaikan agar muat banyak
                    const size = num > 6 ? "text-2xl" : "text-3xl md:text-4xl";
                    emojisHtml += `<span class="${size} drop-shadow-md pointer-events-none">${round.emoji}</span>`;
                }
                bubble.innerHTML = emojisHtml;

                // Kilauan cahaya di atas gelembung
                const shine = document.createElement("div");
                shine.className =
                    "absolute top-[15%] left-[15%] w-6 h-6 md:w-8 md:h-8 bg-white/60 rounded-full blur-[2px] pointer-events-none";
                bubble.appendChild(shine);

                bubble.addEventListener(
                    "mouseenter",
                    () => !isAnimating && bubble.classList.add("hovered"),
                );
                bubble.addEventListener(
                    "mouseleave",
                    () => !isAnimating && bubble.classList.remove("hovered"),
                );
                bubble.addEventListener("click", () => handleSelection(num));

                bubbleWrapper.appendChild(bubble);
                bubblesContainer.appendChild(bubbleWrapper);
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

            isAnimating = false;
        }

        function handleSelection(selectedNum) {
            if (isAnimating) return;
            isAnimating = true;

            const round = rounds[currentRound];
            const bubble = document.getElementById(`bubble-${selectedNum}`);

            if (selectedNum === round.targetNum) {
                // --- JIKA BENAR ---
                playSound("pop");
                setTimeout(() => playSound("success"), 100); // Mainkan ting setelah pop

                bubble.classList.add("animate-bubble-pop");
                owlMessage.innerText = "Pintar! Hitunganmu tepat.";

                // Konfeti pecah dari lokasi gelembung
                const rect = bubble.getBoundingClientRect();
                const x = (rect.left + rect.width / 2) / window.innerWidth;
                const y = (rect.top + rect.height / 2) / window.innerHeight;
                confetti({
                    particleCount: 40,
                    spread: 60,
                    origin: {
                        x,
                        y
                    }
                });
                updateAssessment(assessment, {
                    numerasi: 3,
                    logika: 2,
                    visual: 1
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
                }, 1500);
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    numerasi: -1
                });
                // --- JIKA SALAH ---
                playSound("pop"); // Tetap pecah tapi salah
                setTimeout(() => playSound("error"), 100);

                bubble.classList.add("animate-bubble-pop", "!bg-red-400/50"); // Pecah dengan warna merah
                owlMessage.innerText = "Ups, coba hitung lagi yang lain!";

                mistakesMade++;
                roundResults.push("wrong");
                updateXPBar(1);

                // Hilangkan gelembung yang salah dari layar (display:none setelah animasi selesai)
                setTimeout(() => {
                    bubble.parentElement.style.display = "none";
                    isAnimating = false; // Buka kunci agar anak bisa milih gelembung sisa
                }, 300);

                // Jika salah, permainan TIDAK otomatis lanjut ke ronde berikutnya,
                // anak dibiarkan mencoba gelembung yang tersisa sampai ketemu yang benar!
                // (Tetapi skor poin +5 hangus karena sudah salah duluan, dicatat di roundResults)
            }
        }

        function showVictory() {
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
            } else if (mistakesMade <= 2) {
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
        const HOVER_DURATION_TO_CLICK = 1200; // Ditingkatkan sedikit jadi 1.2s agar tidak sengaja terpencet saat lewat

        function updateCursorUI(timestamp) {
            cursorX += (targetX - cursorX) * 0.7;
            cursorY += (targetY - cursorY) * 0.7;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            let btnHovered = null;
            const interactableElements = document.querySelectorAll(
                ".bubble:not(.animate-bubble-pop)",
            );

            interactableElements.forEach((btn) => {
                const rect = btn.getBoundingClientRect();
                // Hitbox menggunakan bentuk lingkaran agar lebih akurat
                const radius = rect.width / 2;
                const centerX = rect.left + radius;
                const centerY = rect.top + radius;
                const distance = Math.hypot(cursorX - centerX, cursorY - centerY);

                if (distance <= radius + 20) {
                    // Toleransi 20px
                    btnHovered = btn;
                }
            });

            if (btnHovered && !isAnimating) {
                const currentId = btnHovered.id.replace("bubble-", "");

                // Mengubah pose tangan jadi pin (jarum/target)
                cursorEmoji.innerText = "📌";
                cursorEmoji.style.transform = "scale(1.3) rotate(-45deg)";

                if (hoveredButtonId === currentId) {
                    if (!hoverStartTime) hoverStartTime = timestamp;
                    const elapsed = timestamp - hoverStartTime;

                    const percentage = Math.min(elapsed / HOVER_DURATION_TO_CLICK, 1);
                    cursorProgress.style.strokeDashoffset = 226.2 * (1 - percentage);

                    if (elapsed >= HOVER_DURATION_TO_CLICK) {
                        handleSelection(parseInt(currentId));
                        hoveredButtonId = null;
                        hoverStartTime = 0;
                        cursorProgress.style.strokeDashoffset = 226.2;
                    }
                } else {
                    hoveredButtonId = currentId;
                    hoverStartTime = timestamp;
                    interactableElements.forEach((b) => b.classList.remove("hovered"));
                    btnHovered.classList.add("hovered");
                }
            } else {
                cursorEmoji.innerText = "🎯";
                cursorEmoji.style.transform = "scale(1)";

                if (hoveredButtonId) {
                    const oldBtn = document.getElementById(`bubble-${hoveredButtonId}`);
                    if (oldBtn) oldBtn.classList.remove("hovered");
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
            renderRound();
            lucide.createIcons();
            requestAnimationFrame(updateCursorUI);
            initCamera();
        });
    </script>
</body>

</html>
