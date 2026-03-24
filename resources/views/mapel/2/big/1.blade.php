<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Inggris Kelas 2 - Level 1: Magic Potion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <!-- MediaPipe Hand Tracking -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/assessment.js') }}"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&family=Kalam:wght@700&display=swap");

        body {
            font-family: "Nunito", sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            touch-action: none;
            user-select: none;
        }

        .font-chalk {
            font-family: "Kalam", cursive;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Latar Belakang & Animasi Khusus */
        @keyframes float-1 {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(3deg);
            }
        }

        @keyframes float-2 {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(-3deg);
            }
        }

        @keyframes float-3 {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-25px) rotate(2deg);
            }
        }

        .floating-item-1 {
            animation: float-1 4s ease-in-out infinite;
        }

        .floating-item-2 {
            animation: float-2 3.5s ease-in-out infinite;
        }

        .floating-item-3 {
            animation: float-3 4.5s ease-in-out infinite;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0) rotate(0deg);
            }

            20%,
            60% {
                transform: translateX(-10px) rotate(-10deg);
            }

            40%,
            80% {
                transform: translateX(10px) rotate(10deg);
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
            animation: pop-in 0.5s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Animasi Kuali Mendidih */
        @keyframes boil {

            0%,
            100% {
                transform: scale(1) translateY(0);
                filter: drop-shadow(0 0 10px rgba(168, 85, 247, 0.5));
            }

            50% {
                transform: scale(1.05) translateY(-5px);
                filter: drop-shadow(0 0 30px rgba(250, 204, 21, 0.9));
            }
        }

        .animate-boil {
            animation: boil 1s ease-in-out infinite;
        }

        /* Animasi Teks Ajaib Melayang dari Kuali */
        @keyframes float-up-fade {
            0% {
                transform: translateY(0) scale(0.5);
                opacity: 0;
            }

            20% {
                transform: translateY(-20px) scale(1.2);
                opacity: 1;
            }

            80% {
                transform: translateY(-80px) scale(1);
                opacity: 1;
            }

            100% {
                transform: translateY(-100px) scale(0.8);
                opacity: 0;
            }
        }

        .animate-magic-text {
            position: absolute;
            top: -20px;
            color: #fde047;
            font-weight: 900;
            font-size: 2.5rem;
            text-shadow:
                0 0 10px #b45309,
                0 0 20px #facc15;
            animation: float-up-fade 2s ease-out forwards;
            pointer-events: none;
            z-index: 50;
        }

        /* State Item yang Digenggam */
        .magic-item {
            transition:
                transform 0.2s,
                box-shadow 0.2s;
            will-change: transform, left, top;
        }

        .magic-item.hover-highlight {
            transform: scale(1.15) !important;
            box-shadow: 0 0 25px 10px rgba(255, 255, 255, 0.8) !important;
            z-index: 40;
        }

        .magic-item.dragging {
            position: fixed !important;
            z-index: 500;
            opacity: 0.95;
            transform: scale(1.2) rotate(-5deg) !important;
            pointer-events: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            transition: none !important;
            animation: none !important;
        }

        /* Kursor */
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

        .cursor-icon {
            font-size: 3.5rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
            transition: transform 0.1s ease-out;
        }
    </style>
</head>

<body class="bg-slate-900 h-screen w-full relative overflow-hidden">
    <!-- Latar Belakang Sihir Malam -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-b from-indigo-900 via-purple-900 to-slate-900 opacity-90"></div>
        <div class="absolute top-[10%] left-[10%] text-white opacity-20 text-3xl animate-float"
            style="animation-delay: 0s">
            ✨
        </div>
        <div class="absolute top-[30%] right-[15%] text-white opacity-30 text-2xl animate-float"
            style="animation-delay: 1s">
            ✨
        </div>
        <div class="absolute bottom-[40%] left-[20%] text-white opacity-20 text-4xl animate-float"
            style="animation-delay: 2s">
            ✨
        </div>

        <div
            class="absolute bottom-0 w-full h-[25vh] bg-amber-900/80 border-t-8 border-amber-800 backdrop-blur-sm rounded-t-[50%] transform scale-x-150 shadow-[inset_0_20px_50px_rgba(0,0,0,0.5)]">
        </div>
    </div>

    <!-- Kursor Visual -->
    <div id="hand-cursor" style="opacity: 0">
        <div id="cursor-emoji" class="cursor-icon">✨</div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full pointer-events-none">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-slate-800/80 backdrop-blur-md p-2 pr-6 rounded-full border-2 border-purple-500/50 shadow-lg pointer-events-auto">
            <div
                class="w-12 h-12 bg-purple-500 rounded-full border-2 border-white flex items-center justify-center text-2xl shadow-inner">
                🧙‍♀️
            </div>
            <div>
                <h2 class="font-black text-lg text-purple-200 tracking-wide">
                    Penyihir Level 1
                </h2>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-slate-800/80 backdrop-blur-md px-6 py-2 rounded-2xl border-2 border-purple-500/50 shadow-lg flex flex-col items-center">
                <span class="font-black text-purple-300 text-base mb-1" id="xp-text">0 XP</span>
                <div class="w-40 h-4 bg-slate-900 rounded-full overflow-hidden shadow-inner border border-slate-600">
                    <div id="xp-bar-fill"
                        class="h-full bg-gradient-to-r from-fuchsia-400 to-purple-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-slate-800/90 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-2 border-purple-500/50 mb-2 max-w-[240px]">
                    <p id="owl-message" class="font-bold text-purple-200 text-sm">
                        Dengarkan kata-nya, lalu masukkan benda yang benar ke kuali!
                    </p>
                </div>
                <div class="text-6xl drop-shadow-[0_0_15px_rgba(168,85,247,0.6)]">
                    🦉
                </div>
            </div>

            <div
                class="bg-slate-800 p-2 rounded-xl border-2 border-slate-600 shadow-xl flex flex-col items-center w-28 h-24 relative overflow-hidden">
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
    <div class="absolute inset-0 top-20 bottom-0 z-10 flex flex-col items-center justify-between pointer-events-none">
        <!-- Papan Tulis & Target -->
        <div class="mt-4 flex flex-col items-center pointer-events-auto w-full px-4">
            <div
                class="bg-emerald-900/90 backdrop-blur-sm px-8 py-4 rounded-3xl border-8 border-amber-800 shadow-[0_15px_0_#78350f,_0_20px_25px_rgba(0,0,0,0.5)] flex items-center gap-6 min-w-[300px] justify-center relative hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-black/20 rounded-2xl"></div>
                <button onclick="playCurrentLetterSound()"
                    class="relative z-10 bg-white/10 hover:bg-white/20 p-3 rounded-full border border-white/30 transition-colors shadow-lg">
                    <i data-lucide="volume-2" class="text-white w-8 h-8"></i>
                </button>
                <span id="word-display"
                    class="font-chalk text-5xl md:text-6xl text-white relative z-10 tracking-widest uppercase">BOOK</span>
            </div>
        </div>

        <!-- Area Objek Melayang -->
        <div id="objects-yard"
            class="relative w-full max-w-4xl h-[60vh] flex justify-center items-center gap-8 md:gap-20 pointer-events-auto">
            <!-- Objek di-render via JS -->
        </div>

        <!-- Kuali Ajaib (Cauldron) -->
        <div class="relative mb-40 flex flex-col items-center pointer-events-auto" id="cauldron-container">
            <div id="cauldron"
                class="text-[8rem] md:text-[10rem] drop-shadow-[0_20px_20px_rgba(0,0,0,0.8)] relative z-20 transition-all duration-100">
                🍲
            </div>

            <!-- Efek Cahaya Kuali -->
            <div id="cauldron-glow"
                class="absolute bottom-10 w-40 h-20 bg-purple-500 rounded-[100%] blur-3xl opacity-40 z-10 transition-all duration-300">
            </div>
        </div>
    </div>

    <!-- --- PROGRESS DOTS --- -->
    <div class="absolute bottom-6 left-6 z-20 flex gap-2 pointer-events-auto" id="progress-dots">
        <div class="w-3 h-3 bg-slate-600 rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-slate-600 rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-slate-600 rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-slate-600 rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-slate-600 rounded-full shadow-sm dot"></div>
    </div>

    <!-- --- VICTORY OVERLAY --- -->
    <div id="victory-overlay"
        class="hidden fixed inset-0 z-[60] bg-slate-900/95 backdrop-blur-md flex-col items-center justify-center pointer-events-auto">
        <div id="victory-modal"
            class="bg-slate-800 p-8 md:p-12 rounded-[3rem] shadow-[0_0_50px_rgba(168,85,247,0.5)] border-4 border-purple-500 flex flex-col items-center max-w-xl w-[90%] text-center scale-0 relative overflow-hidden">
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPjxyZWN0IHdpZHRoPSI4IiBoZWlnaHQ9IjgiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-30">
            </div>

            <div
                class="w-28 h-28 bg-gradient-to-tr from-purple-500 to-fuchsia-500 rounded-full border-4 border-white flex items-center justify-center mb-4 shadow-[0_0_30px_rgba(192,132,252,0.8)] animate-bounce relative z-10">
                <i data-lucide="award" class="text-white w-14 h-14"></i>
            </div>

            <div id="victory-stars" class="flex justify-center gap-3 mb-3 relative z-10"></div>

            <h1 id="victory-title"
                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-300 to-purple-300 mb-2 drop-shadow-sm pb-1 relative z-10">
                Sihir Sempurna!
            </h1>
            <p class="text-xl text-purple-300 mb-6 font-bold relative z-10" id="victory-subtitle">
                Kerja bagus, Penyihir Cilik!
            </p>
            <div id="assessment-container" class="mt-4 w-full mb-4"></div>

            <div class="flex flex-col gap-3 mb-8 w-full z-10">
                <div class="flex justify-between items-center bg-slate-700/50 p-3 rounded-2xl border border-slate-600">
                    <span class="font-bold text-slate-300 flex items-center gap-2"><i data-lucide="check-circle-2"
                            class="w-5 h-5 text-green-400"></i>
                        Benda Benar (<span id="correct-count">5</span>)</span>
                    <span class="font-black text-green-400" id="xp-answers">+25 XP</span>
                </div>
                <div class="flex justify-between items-center bg-slate-700/50 p-3 rounded-2xl border border-slate-600">
                    <span class="font-bold text-slate-300 flex items-center gap-2"><i data-lucide="flag"
                            class="w-5 h-5 text-blue-400"></i> Selesai
                        Level</span>
                    <span class="font-black text-green-400">+20 XP</span>
                </div>
                <div id="flawless-badge"
                    class="flex justify-between items-center bg-yellow-900/50 p-3 rounded-2xl border border-yellow-600">
                    <span class="font-bold text-yellow-500 flex items-center gap-2"><i data-lucide="star"
                            class="w-5 h-5 text-yellow-400 fill-current"></i>
                        Bonus Sempurna!</span>
                    <span class="font-black text-yellow-400">+10 XP</span>
                </div>
                <div
                    class="mt-2 flex justify-between items-center bg-purple-900/50 p-4 rounded-2xl border-2 border-purple-500 shadow-inner">
                    <span class="font-black text-purple-200 text-lg">Total XP Didapat</span>
                    <span class="font-black text-fuchsia-400 text-3xl" id="earned-xp-text">+45</span>
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
                        kelas: '2',
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
        // --- Audio System ---
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
            } else if (type === "potion-splash") {
                osc.type = "sawtooth";
                osc.frequency.setValueAtTime(200, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    800,
                    audioCtx.currentTime + 0.3,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.3, audioCtx.currentTime + 0.1);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.4,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.4);
            } else if (type === "spell-success") {
                osc.type = "square";
                osc.frequency.setValueAtTime(880, audioCtx.currentTime);
                osc.frequency.setValueAtTime(1108.73, audioCtx.currentTime + 0.1);
                osc.frequency.setValueAtTime(1318.51, audioCtx.currentTime + 0.2);
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
            }
        }

        // --- Data Permainan ---
        const rounds = [{
                word: "BOOK",
                target: "📖",
                options: ["📖", "✏️", "🪑"]
            },
            {
                word: "BALL",
                target: "⚽",
                options: ["⚽", "🚗", "🧸"]
            },
            {
                word: "APPLE",
                target: "🍎",
                options: ["🍎", "🍌", "🍇"]
            },
            {
                word: "BAG",
                target: "🎒",
                options: ["🎒", "👟", "👕"]
            },
            {
                word: "CLOCK",
                target: "⌚",
                options: ["⌚", "📱", "📺"]
            },
        ];

        const floatClasses = [
            "floating-item-1",
            "floating-item-2",
            "floating-item-3",
        ];

        let currentRound = 0;
        let isAnimating = false;

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        const wordDisplay = document.getElementById("word-display");
        const objectsYard = document.getElementById("objects-yard");
        const cauldron = document.getElementById("cauldron");
        const cauldronGlow = document.getElementById("cauldron-glow");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");
        const cauldronContainer = document.getElementById("cauldron-container");

        function updateXPBar(tempRoundOffset = 0) {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress =
                ((currentRound + tempRoundOffset) / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function playCurrentLetterSound() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.word);
            utterance.lang = "en-US"; // Pronounce in English
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        function renderRound() {
            const round = rounds[currentRound];

            // Reset Kuali
            cauldron.classList.remove("animate-boil");
            cauldronGlow.className =
                "absolute bottom-10 w-40 h-20 bg-purple-500 rounded-[100%] blur-3xl opacity-40 z-10 transition-all duration-300";

            wordDisplay.innerText = round.word;
            owlMessage.innerText = `Bantu aku menemukan gambar ${round.word} (bahasa Inggris)!`;

            objectsYard.innerHTML = "";

            const shuffledOptions = [...round.options].sort(
                () => Math.random() - 0.5,
            );

            shuffledOptions.forEach((pic, index) => {
                const wrapper = document.createElement("div");
                wrapper.className = `${floatClasses[index % floatClasses.length]} p-4`;

                const btn = document.createElement("div");
                btn.id = `item-${pic}`;

                btn.className =
                    `magic-item relative w-24 h-24 md:w-32 md:h-32 rounded-full bg-white/10 backdrop-blur-md border-2 border-white/40 shadow-[inset_0_0_15px_rgba(255,255,255,0.5),_0_10px_20px_rgba(0,0,0,0.3)] flex items-center justify-center cursor-pointer text-6xl md:text-7xl`;

                btn.innerHTML = `<span class="drop-shadow-lg pointer-events-none">${pic}</span>`;
                wrapper.appendChild(btn);
                objectsYard.appendChild(wrapper);
            });

            // Update dot progress
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-3 h-3 bg-fuchsia-400 rounded-full shadow-[0_0_10px_#e879f9] dot" :
                        "w-3 h-3 bg-slate-600 rounded-full shadow-sm dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-3 h-3 bg-yellow-400 rounded-full shadow-[0_0_10px_#facc15] animate-pulse dot";
                } else {
                    dot.className = "w-3 h-3 bg-slate-600 rounded-full shadow-sm dot";
                }
            });

            setTimeout(playCurrentLetterSound, 600);
            isAnimating = false;
        }

        // --- SISTEM DRAG & DROP ---
        let targetX = window.innerWidth / 2;
        let targetY = window.innerHeight / 2;
        let cursorX = window.innerWidth / 2;
        let cursorY = window.innerHeight / 2;

        let isPinching = false;
        let grabbedItem = null;
        let grabOffsetX = 0;
        let grabOffsetY = 0;

        function updateGameLoop() {
            cursorX += (targetX - cursorX) * 0.6;
            cursorY += (targetY - cursorY) * 0.6;

            cursorElement.style.left = `${cursorX}px`;
            cursorElement.style.top = `${cursorY}px`;

            if (!isAnimating) {
                if (isPinching) {
                    if (grabbedItem) {
                        updateHoverKuali();
                    } else {
                        tryGrabItem();
                    }
                } else {
                    highlightHoveredItem();
                    if (grabbedItem) {
                        handleDrop();
                    }
                }
            }

            if (grabbedItem && isPinching) {
                grabbedItem.style.left = `${cursorX - grabOffsetX}px`;
                grabbedItem.style.top = `${cursorY - grabOffsetY}px`;
            }

            requestAnimationFrame(updateGameLoop);
        }

        function highlightHoveredItem() {
            const items = document.querySelectorAll(".magic-item:not(.dragging)");
            let minDistance = 70;
            let closest = null;

            items.forEach((i) => i.classList.remove("hover-highlight"));

            for (let item of items) {
                const rect = item.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                const distance = Math.hypot(cursorX - centerX, cursorY - centerY);

                if (distance < minDistance) {
                    minDistance = distance;
                    closest = item;
                }
            }

            if (closest) {
                closest.classList.add("hover-highlight");
                cursorEmoji.innerText = "🤏";
                cursorEmoji.style.transform = "scale(1.2)";
            } else {
                cursorEmoji.innerText = "✨";
                cursorEmoji.style.transform = "scale(1)";
            }
        }

        function tryGrabItem() {
            const items = document.querySelectorAll(".magic-item:not(.dragging)");
            let minDistance = 70;
            let closest = null;

            for (let item of items) {
                const rect = item.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                const distance = Math.hypot(cursorX - centerX, cursorY - centerY);

                if (distance < minDistance) {
                    minDistance = distance;
                    closest = item;
                }
            }

            if (closest) {
                playSound("grab");
                grabbedItem = closest;
                closest.classList.remove("hover-highlight");

                const rect = closest.getBoundingClientRect();

                // FIX OFFSET: Kunci offset persis ke tengah dari item agar tidak lari kemana-mana
                grabOffsetX = rect.width / 2;
                grabOffsetY = rect.height / 2;

                // Pindahkan elemen ke body agar bebas dari animasi melayang induknya (float-classes)
                closest._originalParent = closest.parentElement;
                document.body.appendChild(closest);

                closest.style.width = `${rect.width}px`;
                closest.style.height = `${rect.height}px`;

                closest.classList.add("dragging");

                // Langsung terapkan posisi agar tidak berkedip
                closest.style.left = `${cursorX - grabOffsetX}px`;
                closest.style.top = `${cursorY - grabOffsetY}px`;

                owlMessage.innerText = "Bagus! Masukkan benda itu ke dalam kuali.";
            }
        }

        function updateHoverKuali() {
            const kualiRect = cauldron.getBoundingClientRect();
            const kualiCenterY = kualiRect.top + kualiRect.height / 2;

            if (cursorY > kualiCenterY - 100) {
                cauldron.style.filter = "drop-shadow(0 0 30px rgba(168,85,247,0.8))";
                cauldron.style.transform = "scale(1.1)";
            } else {
                cauldron.style.filter = "";
                cauldron.style.transform = "";
            }
        }

        function handleDrop() {
            if (!grabbedItem) return;

            const kualiRect = cauldron.getBoundingClientRect();
            const kualiCenterY = kualiRect.top + kualiRect.height / 2;

            cauldron.style.filter = "";
            cauldron.style.transform = "";

            if (cursorY > kualiCenterY - 100) {
                const round = rounds[currentRound];
                const droppedId = grabbedItem.id.replace("item-", "");

                if (droppedId === round.target) {
                    isAnimating = true;
                    playSound("potion-splash");

                    grabbedItem.style.display = "none";
                    cauldron.classList.add("animate-boil");
                    cauldronGlow.className =
                        "absolute bottom-10 w-full h-64 bg-amber-400 rounded-[100%] blur-[100px] z-10 transition-all duration-300 opacity-90";

                    // Tampilkan Teks Ajaib dari Kuali
                    const magicText = document.createElement("div");
                    magicText.className = "animate-magic-text";
                    magicText.innerText = "PERFECT!";
                    cauldronContainer.appendChild(magicText);

                    owlMessage.innerText = "Ramuan Berhasil! Hebat sekali!";
                    setTimeout(() => playSound("spell-success"), 300);

                    const rect = cauldron.getBoundingClientRect();
                    const x = (rect.left + rect.width / 2) / window.innerWidth;
                    const y = (rect.top + rect.height / 2) / window.innerHeight;

                    confetti({
                        particleCount: 100,
                        spread: 100,
                        origin: {
                            x,
                            y
                        },
                        startVelocity: 40,
                        colors: ["#fcd34d", "#f472b6", "#a78bfa", "#38bdf8"],
                    });

                    xp += 5;
                    levelEarnedXP += 5;
                    correctAnswersCount++;
                    updateAssessment(assessment, {
                        english: 2,
                        visual: 2,
                        logika: 1
                    });
                    if (mistakesMade === 0 || roundResults.length < currentRound + 1) {
                        roundResults.push("correct");
                    }
                    updateXPBar(1);

                    setTimeout(() => {
                        magicText.remove();
                        currentRound++;
                        if (currentRound < rounds.length) {
                            renderRound();
                        } else {
                            showVictory();
                        }
                    }, 2500);
                } else {
                    updateAssessment(assessment, {
                        logika: -1,
                        visual: -1
                    });
                    playSound("error");
                    grabbedItem.classList.add(
                        "animate-shake",
                        "!border-red-500",
                        "!bg-red-500/50",
                    );
                    owlMessage.innerText = "Itu bukan bahan yang benar!";

                    mistakesMade++;
                    if (roundResults.length < currentRound + 1)
                        roundResults.push("wrong");
                    updateXPBar(1);

                    const itemRef = grabbedItem;

                    setTimeout(() => {
                        resetItemPosition(itemRef);
                        isAnimating = false;
                    }, 1000);

                    grabbedItem = null;
                }
            } else {
                playSound("drop");
                resetItemPosition(grabbedItem);
                owlMessage.innerText = "Kamu harus memasukkannya ke dalam kuali.";
            }

            grabbedItem = null;
        }

        function resetItemPosition(item) {
            if (!item) return;

            item.classList.remove(
                "dragging",
                "animate-shake",
                "!border-red-500",
                "!bg-red-500/50",
            );

            item.style.width = "";
            item.style.height = "";
            item.style.left = "";
            item.style.top = "";

            if (item._originalParent) {
                item._originalParent.appendChild(item);
            }
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

            let stars = 1;
            let titleText = "Keep Trying!";
            let descText = "Sihirmu sudah lumayan!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 5) {
                stars = 3;
                titleText = "Perfect Magic!";
                descText = "Luar biasa! Kamu Ahli Sihir Bahasa Inggris!";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Good Job!";
                descText = "Ramuanmu hampir sempurna!";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-yellow-400 fill-current drop-shadow-[0_0_15px_#facc15] animate-bounce-slight" style="animation-delay: ${i * 0.1}s"></i>`;
                } else {
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-slate-600 fill-current drop-shadow-sm"></i>`;
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
            playSound("spell-success");

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
                    colors: ["#facc15", "#f472b6", "#a855f7", "#60a5fa"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#facc15", "#f472b6", "#a855f7", "#60a5fa"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        // --- KAMERA MEDIA-PIPE ---
        const videoElement = document.getElementById("input_video");
        const cursorElement = document.getElementById("hand-cursor");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

        function setPinchState(pinching) {
            if (isPinching !== pinching) {
                isPinching = pinching;
                if (isPinching) {
                    cursorEmoji.innerText = "🤏";
                    cursorElement.style.transform = "translate(-50%, -50%) scale(0.9)";
                } else {
                    cursorEmoji.innerText = "✨";
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
