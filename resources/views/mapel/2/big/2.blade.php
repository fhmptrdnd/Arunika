<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bahasa Inggris Kelas 2 - Level 2: Mengenal Hewan</title>
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

        .font-jungle {
            font-family: "Fredoka One", cursive;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
        }

        /* Background Animations */
        @keyframes drift-slow {
            from {
                transform: translateX(-10%);
            }

            to {
                transform: translateX(110vw);
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
            animation: drift-slow 45s linear infinite;
        }

        .animate-drift-fast {
            animation: drift-fast 30s linear infinite;
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

        @keyframes shake-pan {

            0%,
            100% {
                transform: translateX(-50%) rotate(0deg);
            }

            20%,
            60% {
                transform: translateX(calc(-50% - 15px)) rotate(-10deg);
                filter: hue-rotate(-30deg) brightness(0.8);
            }

            40%,
            80% {
                transform: translateX(calc(-50% + 15px)) rotate(10deg);
                filter: hue-rotate(-30deg) brightness(0.8);
            }
        }

        .animate-shake-pan {
            animation: shake-pan 0.4s ease-in-out;
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

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 20px rgba(34, 197, 94, 0);
            }

            100% {
                transform: scale(0.8);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        .animate-pulse-ring {
            animation: pulse-ring 2s infinite;
        }

        /* Falling Animal Element */
        .falling-animal {
            position: absolute;
            font-size: 4.5rem;
            will-change: top, transform;
            filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.3));
            /* Add slight rotation animation to falling items */
            animation: slow-spin 6s linear infinite;
            z-index: 20;
        }

        @keyframes slow-spin {
            0% {
                transform: rotate(-15deg);
            }

            50% {
                transform: rotate(15deg);
            }

            100% {
                transform: rotate(-15deg);
            }
        }

        /* Kuali (Pan) Setup */
        #player-pan {
            position: absolute;
            bottom: 2%;
            /* Jarak dari bawah layar */
            /* Left akan diatur oleh JS. TranslateX(-50%) memastikan cursor persis di tengah kuali */
            transform: translateX(-50%);
            will-change: left;
            z-index: 30;
            display: flex;
            flex-direction: column;
            align-items: center;
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

<body class="bg-gradient-to-b from-sky-300 via-sky-100 to-green-300 h-screen w-full relative overflow-hidden">
    <!-- --- SCENERY BACKGROUND (JUNGLE PLAYGROUND) --- -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute top-10 left-[-20%] animate-drift-slow opacity-90">
            <svg width="180" height="90" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>
        <div class="absolute top-28 left-[-10%] animate-drift-fast opacity-70 scale-75">
            <svg width="250" height="120" viewBox="0 0 24 24" fill="white">
                <path
                    d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5S19.985 10 17.5 10c-.17 0-.336.01-.5.027A6.49 6.49 0 0011 5c-3.59 0-6.5 2.91-6.5 6.5 0 .238.013.473.039.704A4.5 4.5 0 005.5 21h12z" />
            </svg>
        </div>

        <!-- Jungle Ground & Trees -->
        <div
            class="absolute bottom-0 w-full h-[20vh] bg-green-500 rounded-t-[100%] scale-x-150 transform translate-y-8 shadow-[inset_0_20px_50px_rgba(0,0,0,0.1)]">
        </div>
        <div class="absolute bottom-[-10%] w-[120%] left-[-10%] h-[30vh] bg-green-600 rounded-t-[100%] scale-x-110">
        </div>

        <div class="absolute bottom-[10%] left-[2%] text-8xl drop-shadow-xl z-0">
            🌴
        </div>
        <div class="absolute bottom-[15%] left-[12%] text-6xl drop-shadow-xl z-0">
            🌿
        </div>
        <div class="absolute bottom-[8%] right-[5%] text-9xl drop-shadow-xl z-0 scale-x-[-1]">
            🌴
        </div>
        <div class="absolute bottom-[20%] right-[18%] text-5xl drop-shadow-xl z-0">
            🪴
        </div>
    </div>

    <!-- --- TOP BAR --- -->
    <div class="relative z-20 flex justify-between items-start p-4 md:p-6 w-full pointer-events-none">
        <!-- Info Pemain -->
        <div
            class="flex items-center gap-3 bg-white/80 backdrop-blur-md p-2 pr-6 rounded-full border-4 border-white shadow-lg pointer-events-auto">
            <div
                class="w-12 h-12 bg-green-400 rounded-full border-2 border-white flex items-center justify-center text-2xl shadow-inner">
                👦🏽
            </div>
            <div>
                <h2 class="font-black text-lg text-green-900 tracking-wide">
                    Explorer Level 2
                </h2>
            </div>
        </div>

        <!-- Bar XP -->
        <div class="hidden md:flex flex-col items-center pt-2 pointer-events-auto">
            <div
                class="bg-white/80 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-green-700 text-base mb-1" id="xp-text">0 XP</span>
                <div class="w-40 h-4 bg-green-100 rounded-full overflow-hidden shadow-inner border border-green-200">
                    <div id="xp-bar-fill"
                        class="h-full bg-gradient-to-r from-yellow-300 to-green-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Maskot & Kamera -->
        <div class="flex items-start gap-4 pointer-events-auto">
            <div class="relative hidden lg:flex flex-col items-end pt-2 animate-float">
                <div
                    class="bg-white/95 px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-green-300 mb-2 max-w-[200px]">
                    <p id="owl-message" class="font-bold text-green-800 text-sm">
                        Geser kuali untuk menangkap hewan yang tepat!
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
    <div class="absolute inset-0 top-24 bottom-0 z-10 flex flex-col pointer-events-none">
        <!-- Target Kata (Papan Peringatan Hutan) -->
        <div class="w-full flex justify-center mt-2 z-20">
            <div class="bg-amber-100/95 backdrop-blur-sm px-8 py-3 rounded-[2rem] border-8 border-amber-600 shadow-[0_10px_0_#92400e,_0_20px_25px_rgba(0,0,0,0.3)] flex items-center gap-6 pointer-events-auto animate-bounce-slight"
                style="transform: rotate(-2deg)">
                <button onclick="playCurrentWordSound()"
                    class="bg-amber-500 hover:bg-amber-600 p-3 rounded-full border-4 border-white shadow-md transition-colors">
                    <i data-lucide="volume-2" class="text-white w-8 h-8"></i>
                </button>
                <div class="flex flex-col items-center">
                    <span class="text-sm font-bold text-amber-800 uppercase tracking-widest">Catch The</span>
                    <span id="word-display"
                        class="font-jungle text-5xl md:text-6xl text-amber-900 tracking-wide uppercase">CAT</span>
                </div>
            </div>
        </div>

        <!-- Zona Jatuh (Falling Zone) -->
        <div id="falling-zone" class="relative w-full flex-1 overflow-hidden pointer-events-none">
            <!-- Hewan-hewan akan ditambahkan di sini via JS -->
        </div>

        <!-- KUALI PEMAIN (Player Pan) -->
        <!-- Penggunaan translateX(-50%) membuat titik tengah kuali selalu menempel pada nilai 'left' -->
        <div id="player-pan" class="pointer-events-none">
            <div id="pan-glow"
                class="absolute inset-0 bg-yellow-300 blur-2xl opacity-0 transition-opacity duration-300 rounded-full">
            </div>
            <div class="text-[6rem] md:text-[8rem] drop-shadow-[0_15px_15px_rgba(0,0,0,0.5)] relative z-10">
                🍲
            </div>
            <!-- Hitbox Kuali untuk visual debug (Optional) -->
            <div id="pan-hitbox" class="absolute top-[40%] w-[60%] h-[20%] rounded-full opacity-0"></div>
        </div>
    </div>

    <!-- --- PROGRESS DOTS --- -->
    <div class="absolute bottom-6 left-6 z-20 flex gap-2 pointer-events-auto" id="progress-dots">
        <div class="w-3 h-3 bg-white/50 border-2 border-white rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-white/50 border-2 border-white rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-white/50 border-2 border-white rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-white/50 border-2 border-white rounded-full shadow-sm dot"></div>
        <div class="w-3 h-3 bg-white/50 border-2 border-white rounded-full shadow-sm dot"></div>
    </div>

    <!-- --- VICTORY OVERLAY --- -->
    <div id="victory-overlay"
        class="hidden fixed inset-0 z-[60] bg-green-900/90 backdrop-blur-md flex-col items-center justify-center pointer-events-auto">
        <div id="victory-modal"
            class="bg-white p-8 md:p-12 rounded-[3rem] shadow-[0_0_50px_rgba(34,197,94,0.5)] border-8 border-yellow-400 flex flex-col items-center max-w-xl w-[90%] text-center scale-0 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 text-9xl opacity-10 pointer-events-none">
                🎉
            </div>
            <div class="absolute -bottom-10 -left-10 text-9xl opacity-10 pointer-events-none">
                ✨
            </div>

            <div
                class="w-28 h-28 bg-gradient-to-tr from-green-400 to-emerald-500 rounded-full border-4 border-white flex items-center justify-center mb-4 shadow-[0_0_30px_rgba(52,211,153,0.8)] animate-bounce relative z-10">
                <i data-lucide="award" class="text-white w-14 h-14"></i>
            </div>

            <div id="victory-stars" class="flex justify-center gap-3 mb-3 relative z-10"></div>

            <h1 id="victory-title"
                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-emerald-600 mb-2 drop-shadow-sm pb-1 relative z-10">
                Jungle Master!
            </h1>
            <p class="text-xl text-gray-600 mb-6 font-bold relative z-10" id="victory-subtitle">
                Great job, Explorer!
            </p>
            <div id="assessment-container" class="mt-4 w-full mb-4"></div>
            <div class="flex flex-col gap-3 mb-8 w-full z-10">
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-2xl border-2 border-gray-100">
                    <span class="font-bold text-gray-600 flex items-center gap-2"><i data-lucide="check-circle-2"
                            class="w-5 h-5 text-green-500"></i>
                        Correct Catches (<span id="correct-count">5</span>)</span>
                    <span class="font-black text-green-500" id="xp-answers">+25 XP</span>
                </div>
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-2xl border-2 border-gray-100">
                    <span class="font-bold text-gray-600 flex items-center gap-2"><i data-lucide="flag"
                            class="w-5 h-5 text-blue-500"></i> Level
                        Completed</span>
                    <span class="font-black text-green-500">+20 XP</span>
                </div>
                <div id="flawless-badge"
                    class="flex justify-between items-center bg-yellow-50 p-3 rounded-2xl border-2 border-yellow-200">
                    <span class="font-bold text-yellow-600 flex items-center gap-2"><i data-lucide="star"
                            class="w-5 h-5 text-yellow-500 fill-current"></i>
                        Flawless Bonus!</span>
                    <span class="font-black text-yellow-500">+10 XP</span>
                </div>
                <div
                    class="mt-2 flex justify-between items-center bg-green-100 p-4 rounded-2xl border-4 border-green-300 shadow-inner">
                    <span class="font-black text-green-800 text-lg">Total XP Earned</span>
                    <span class="font-black text-green-600 text-3xl" id="earned-xp-text">+55</span>
                </div>
            </div>

            <a href="{{ route('mapel.lainnya') }}"
                class="bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white text-2xl font-black py-4 px-12 rounded-full shadow-[0_8px_0_#15803d] hover:shadow-[0_4px_0_#15803d] hover:translate-y-1 transition-all w-full md:w-auto z-10">
                Lanjut petualangan
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
                        'level': '2',
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

            if (type === "pop") {
                // Benda muncul
                osc.type = "sine";
                osc.frequency.setValueAtTime(600, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(
                    800,
                    audioCtx.currentTime + 0.1,
                );
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.1, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.1,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.1);
            } else if (type === "catch") {
                // Menangkap yang benar
                osc.type = "square";
                osc.frequency.setValueAtTime(523.25, audioCtx.currentTime); // C5
                osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.1); // A5
                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.05);
                gain.gain.exponentialRampToValueAtTime(
                    0.01,
                    audioCtx.currentTime + 0.3,
                );
                osc.start(audioCtx.currentTime);
                osc.stop(audioCtx.currentTime + 0.3);
            } else if (type === "error") {
                // Menangkap yang salah
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
            } else if (type === "voice-success") {
                osc.type = "sine";
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

        // --- Data Permainan ---
        const rounds = [{
                word: "CAT",
                speechSound: "cat",
                target: "🐱",
                decoys: ["🐶", "🐰", "🐻"],
            },
            {
                word: "DOG",
                speechSound: "dog",
                target: "🐶",
                decoys: ["🐱", "🐻", "🐰"],
            },
            {
                word: "BIRD",
                speechSound: "bird",
                target: "🐦",
                decoys: ["🐰", "🐟", "🐢"],
            },
            {
                word: "FISH",
                speechSound: "fish",
                target: "🐟",
                decoys: ["🐢", "🐬", "🐦"],
            },
            {
                word: "COW",
                speechSound: "cow",
                target: "🐄",
                decoys: ["🐑", "🐐", "🐻"],
            },
        ];

        let currentRound = 0;
        let gameState = "CATCHING"; // CATCHING, TRANSITION

        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = [];

        // Spawning variables
        let spawnIntervalId = null;
        let fallingSpeed = 6; // Kecepatan dipercepat dari 3 menjadi 6

        const wordDisplay = document.getElementById("word-display");
        const fallingZone = document.getElementById("falling-zone");
        const playerPan = document.getElementById("player-pan");
        const panHitbox = document.getElementById("pan-hitbox");
        const owlMessage = document.getElementById("owl-message");

        function updateXPBar(tempRoundOffset = 0) {
            document.getElementById("xp-text").innerText = `${xp} XP`;
            const progress =
                ((currentRound + tempRoundOffset) / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function playCurrentWordSound() {
            const round = rounds[currentRound];
            const utterance = new SpeechSynthesisUtterance(round.speechSound);
            utterance.lang = "en-US";
            utterance.rate = 0.85;
            window.speechSynthesis.speak(utterance);
        }

        function startRound() {
            if (currentRound >= rounds.length) {
                showVictory();
                return;
            }

            const round = rounds[currentRound];
            gameState = "CATCHING";

            fallingZone.innerHTML = ""; // Clear existing animals

            wordDisplay.innerText = round.word;
            owlMessage.innerText = `Geser kualimu dan tangkap ${round.word}!`;

            updateProgressDots();
            setTimeout(playCurrentWordSound, 500);

            // Start spawning animals
            if (spawnIntervalId) clearInterval(spawnIntervalId);
            spawnIntervalId = setInterval(spawnAnimal, 1000); // Waktu jeda hewan muncul dipercepat jadi setiap 1 detik
        }

        function spawnAnimal() {
            if (gameState !== "CATCHING") return;

            const round = rounds[currentRound];
            const isTarget = Math.random() > 0.4; // 60% chance to spawn target

            let emoji = round.target;
            if (!isTarget) {
                emoji = round.decoys[Math.floor(Math.random() * round.decoys.length)];
            }

            const animal = document.createElement("div");
            animal.className = "falling-animal";
            animal.innerText = emoji;
            animal.dataset.isTarget = isTarget ? "true" : "false";

            // Random X position within screen bounds (10% to 90%)
            const randomX = 10 + Math.random() * 80;
            animal.style.left = `${randomX}%`;
            animal.style.top = `-100px`;

            fallingZone.appendChild(animal);
            playSound("pop");
        }

        function updateProgressDots() {
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    dot.className =
                        roundResults[index] === "correct" ?
                        "w-3 h-3 bg-green-400 border-2 border-green-200 rounded-full shadow-[0_0_10px_#4ade80] dot" :
                        "w-3 h-3 bg-red-400 border-2 border-red-200 rounded-full shadow-sm dot";
                } else if (index === currentRound) {
                    dot.className =
                        "w-3 h-3 bg-yellow-400 border-2 border-yellow-200 rounded-full shadow-[0_0_10px_#facc15] animate-pulse dot";
                } else {
                    dot.className =
                        "w-3 h-3 bg-white/50 border-2 border-white rounded-full shadow-sm dot";
                }
            });
        }

        // --- PHYSICS & COLLISION LOOP ---
        let targetX = window.innerWidth / 2;
        let cursorX = window.innerWidth / 2;

        function gameLoop() {
            // Smoothly move the pan based on hand targetX
            cursorX += (targetX - cursorX) * 0.4;

            // Batasi pergerakan kuali agar tidak keluar layar sepenuhnya
            const screenWidth = window.innerWidth;
            const clampedX = Math.max(50, Math.min(screenWidth - 50, cursorX));

            // PENTING: Perbaikan Offset. Transform translateX(-50%) di CSS memastikan
            // nilai 'left' ini persis merupakan pusat kuali.
            playerPan.style.left = `${clampedX}px`;

            if (gameState === "CATCHING") {
                // Update falling animals
                const animals = document.querySelectorAll(".falling-animal");
                const panRect = panHitbox
                    .getBoundingClientRect(); // Menggunakan div khusus di dalam kuali untuk hitbox akurat

                animals.forEach((animal) => {
                    let currentTop = parseFloat(animal.style.top) || -100;
                    currentTop += fallingSpeed;
                    animal.style.top = `${currentTop}px`;

                    const aRect = animal.getBoundingClientRect();

                    // Check collision (AABB) - Cukup presisi
                    if (
                        aRect.bottom >= panRect.top &&
                        aRect.top <= panRect.bottom &&
                        aRect.right >= panRect.left &&
                        aRect.left <= panRect.right
                    ) {
                        handleCatch(animal);
                    }

                    // Remove if it falls off screen
                    if (currentTop > window.innerHeight) {
                        animal.remove();
                    }
                });
            }

            requestAnimationFrame(gameLoop);
        }

        function handleCatch(animal) {
            const isTarget = animal.dataset.isTarget === "true";
            animal.remove();

            if (isTarget) {
                // BENAR!
                gameState = "TRANSITION"; // Pause catching
                if (spawnIntervalId) clearInterval(spawnIntervalId);
                document.getElementById("pan-glow").style.opacity = "1";

                playSound("catch");
                owlMessage.innerText = "Great Catch!";

                const pRect = playerPan.getBoundingClientRect();
                confetti({
                    particleCount: 30,
                    spread: 60,
                    origin: {
                        x: (pRect.left + pRect.width / 2) / window.innerWidth,
                        y: pRect.top / window.innerHeight,
                    },
                    colors: ["#4ade80", "#facc15", "#3b82f6"],
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
                    document.getElementById("pan-glow").style.opacity = "0";
                    currentRound++;
                    startRound();
                }, 1500);
            } else {
                // SALAH!
                playSound("error");
                playerPan.classList.add("animate-shake-pan");
                setTimeout(
                    () => playerPan.classList.remove("animate-shake-pan"),
                    400,
                );
                updateAssessment(assessment, {
                    logika: -1,
                    visual: -1
                });
                owlMessage.innerText = "Oops, itu bukan hewannya!";
                mistakesMade++;

                // Animasi terpental (bikin elemen baru buat visual aja)
                const bounceAnimal = document.createElement("div");
                bounceAnimal.innerText = animal.innerText;
                bounceAnimal.className = "absolute text-6xl drop-shadow-md z-50";
                bounceAnimal.style.left = animal.style.left;
                bounceAnimal.style.top = animal.style.top;
                bounceAnimal.style.transition =
                    "all 0.5s cubic-bezier(0.25, 1, 0.5, 1)";
                document.body.appendChild(bounceAnimal);

                setTimeout(() => {
                    bounceAnimal.style.transform =
                        `translate(${Math.random() > 0.5 ? "100px" : "-100px"}, -150px) rotate(${Math.random() * 180}deg)`;
                    bounceAnimal.style.opacity = "0";
                }, 10);
                setTimeout(() => bounceAnimal.remove(), 500);

                if (roundResults.length < currentRound + 1) {
                    roundResults.push("wrong");
                }
                updateXPBar(); // Update bar aja, ga nambah currentRound
            }
        }

        function showVictory() {
            gameState = "VICTORY";
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
            let descText = "You did your best!";

            const correctRounds = roundResults.filter(
                (r) => r === "correct",
            ).length;

            if (correctRounds === 5) {
                stars = 3;
                titleText = "Jungle Master!";
                descText = "Amazing! You are a great Explorer!";
            } else if (correctRounds >= 3) {
                stars = 2;
                titleText = "Good Job!";
                descText = "Great! You are almost perfect!";
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
                    colors: ["#4ade80", "#3b82f6", "#facc15", "#f87171"],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: ["#4ade80", "#3b82f6", "#facc15", "#f87171"],
                });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
            saveScoreToServer();

        }

        // --- KAMERA MEDIA-PIPE ---
        const videoElement = document.getElementById("input_video");
        const camStatus = document.getElementById("cam-status");
        const camIndicator = document.getElementById("cam-indicator");

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
                    if (
                        results.multiHandLandmarks &&
                        results.multiHandLandmarks.length > 0
                    ) {
                        const indexFinger = results.multiHandLandmarks[0][8];
                        // Map index finger X directly to screen
                        targetX = (1 - indexFinger.x) * window.innerWidth;
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

        // Mouse Support Fallback
        document.addEventListener("mousemove", (e) => {
            targetX = e.clientX;
        });

        document.addEventListener("DOMContentLoaded", () => {
            updateXPBar();
            lucide.createIcons();
            startRound();
            requestAnimationFrame(gameLoop);
            initCamera();
        });
    </script>
</body>

</html>
