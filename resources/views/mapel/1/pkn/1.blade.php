<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Level 1: Simbol Pancasila</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Confetti untuk selebrasi -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/assessment.js') }}"></script>
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

        /* Animasi Feedback Jawaban */
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
            animation: shake 0.5s ease-in-out;
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

<body class="bg-linear-to-b from-sky-300 to-green-300 h-screen w-full relative">
    <!-- Kursor Visual Hand Tracking -->
    <div id="hand-cursor" style="opacity: 0">
        <svg class="absolute" width="80" height="80">
            <circle class="progress-ring__circle" stroke="#22c55e" stroke-width="6" fill="transparent" r="36"
                cx="40" cy="40" stroke-dasharray="226.2" stroke-dashoffset="226.2" id="cursor-progress" />
        </svg>
        <!-- Menggunakan Kursor Emoji -->
        <div id="cursor-emoji"
            style="
          font-size: 3rem;
          filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
          transition: all 0.2s;
        ">
            🖐️
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
        <div class="absolute bottom-0 w-full h-1/3 bg-green-500 rounded-t-[100%] scale-x-150 transform translate-y-12">
        </div>
        <div class="absolute bottom-[-10%] w-[120%] left-[-10%] h-1/2 bg-green-400 rounded-t-[100%] scale-x-110"></div>
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
                    Penjelajah Level 1
                </h2>
                <div class="flex text-yellow-500 drop-shadow">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current text-gray-400"></i>
                    <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Bar XP (Dimulai dari 0) -->
        <div class="hidden md:flex flex-col items-center pt-2">
            <div
                class="bg-white/70 backdrop-blur-md px-6 py-2 rounded-2xl border-4 border-white shadow-lg flex flex-col items-center">
                <span class="font-black text-blue-900 text-lg mb-1" id="xp-text">0 XP</span>
                <div
                    class="w-48 h-5 bg-blue-900/20 rounded-full overflow-hidden shadow-inner border-2 border-white/50 relative">
                    <div id="xp-bar-fill"
                        class="absolute top-0 left-0 h-full bg-linear-to-r from-yellow-300 to-yellow-500 rounded-full transition-all duration-1000 ease-out"
                        style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Kamera Tangan & Maskot -->
        <div class="flex items-start gap-4">
            <div class="relative hidden lg:flex flex-col items-end pt-4 animate-float">
                <div
                    class="bg-white px-4 py-3 rounded-2xl rounded-br-none shadow-xl border-4 border-blue-200 mb-2 max-w-55">
                    <p id="owl-message" class="font-bold text-blue-900 text-sm">
                        Arahkan jarimu ke jawaban yang benar!
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
            class="bg-white/95 backdrop-blur-sm p-8 rounded-[3rem] shadow-[0_15px_30px_rgba(0,0,0,0.15)] border-8 border-white max-w-4xl w-[90%] flex flex-col items-center pointer-events-auto transition-transform duration-300">
            <!-- Area Top (CLUE DIHILANGKAN SESUAI PERMINTAAN) -->

            <!-- Area Pertanyaan -->
            <div class="text-center mb-8 mt-4">
                <h3 class="text-xl text-blue-500 font-black mb-2 uppercase tracking-wide">
                    Tunjuk simbol yang benar!
                </h3>
                <h1 id="question-text" class="text-3xl md:text-4xl font-black text-gray-800 leading-tight">
                    Simbol mana yang melambangkan<br />
                    <span class="text-green-500">Ketuhanan Yang Maha Esa</span>?
                </h1>
            </div>

            <!-- Opsi Jawaban (Tombol Raksasa) -->
            <div id="options-container" class="flex flex-wrap justify-center gap-6 w-full mb-6">
                <!-- Di-render oleh JS -->
            </div>

            <!-- Indikator Progres -->
            <div class="flex gap-3 mt-4" id="progress-dots">
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot" id="dot-0">
                </div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot" id="dot-1">
                </div>
                <div class="w-4 h-4 bg-gray-300 rounded-full border-2 border-white shadow-sm dot" id="dot-2">
                </div>
            </div>
        </div>
    </div>

    <!-- --- VICTORY OVERLAY TERBARU --- -->
    <div id="victory-overlay"
        class="hidden fixed inset-0 z-60 bg-sky-200/90 backdrop-blur-md flex-col items-center justify-center">
        <div id="victory-modal"
            class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl border-8 border-yellow-400 flex flex-col items-center max-w-xl w-[90%] text-center scale-0 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 text-9xl opacity-10 pointer-events-none">
                🎉
            </div>
            <div class="absolute -bottom-10 -left-10 text-9xl opacity-10 pointer-events-none">
                ✨
            </div>

            <div
                class="w-28 h-28 bg-linear-to-tr from-yellow-300 to-yellow-500 rounded-full border-4 border-white flex items-center justify-center mb-4 shadow-xl animate-bounce">
                <i data-lucide="award" class="text-white w-14 h-14"></i>
            </div>

            <div id="victory-stars" class="flex justify-center gap-3 mb-3"></div>

            <h1 id="victory-title"
                class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-linear-to-r from-yellow-500 to-orange-500 mb-2 drop-shadow-sm pb-1">
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
                    class="bg-linear-to-r from-green-100 to-green-200 border-2 border-green-300 rounded-2xl p-4 flex justify-between items-center shadow-inner">
                    <span class="font-black text-green-800 text-lg">Total XP</span>
                    <span class="font-black text-green-600 text-3xl" id="earned-xp-text">+55</span>
                </div>



            </div>

            <a href="{{ route('mapel.lainnya') }}"
                class="bg-linear-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white text-2xl font-black py-4 px-12 rounded-full shadow-[0_8px_0_#15803d] hover:shadow-[0_4px_0_#15803d] hover:translate-y-1 transition-all w-full md:w-auto z-10">
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
                        mapel: 'pkn',
                        kelas: '1',
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
        // Audio System menggunakan Web Audio API
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioContext();

        function playSuccessSound() {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);
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
        }

        function playErrorSound() {
            if (audioCtx.state === "suspended") audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);
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

        // Data Permainan
        const rounds = [{
                question: "Ketuhanan Yang Maha Esa",
                correct: "bintang"
            },
            {
                question: "Kemanusiaan yang Adil dan Beradab",
                correct: "rantai"
            },
            {
                question: "Persatuan Indonesia",
                correct: "pohon"
            },
        ];

        const symbols = [{
                id: "bintang",
                icon: "⭐",
                name: "Bintang",
                color: "bg-yellow-400",
                shadow: "shadow-[0_10px_0_#b45309]",
                border: "border-yellow-200",
            },
            {
                id: "rantai",
                icon: "🔗",
                name: "Rantai",
                color: "bg-red-400",
                shadow: "shadow-[0_10px_0_#991b1b]",
                border: "border-red-200",
            },
            {
                id: "pohon",
                icon: "🌳",
                name: "Pohon Beringin",
                color: "bg-green-500",
                shadow: "shadow-[0_10px_0_#15803d]",
                border: "border-green-300",
            },
        ];

        let currentRound = 0;
        let isAnimating = false;

        // SISTEM PENGHITUNGAN XP & TRACKING PROGRESS
        let xp = 0;
        let levelEarnedXP = 0;
        let mistakesMade = 0;
        let correctAnswersCount = 0;
        let roundResults = []; // Mencatat sejarah tiap soal: 'correct' atau 'wrong'

        // Inisialisasi DOM
        const questionText = document.getElementById("question-text");
        const optionsContainer = document.getElementById("options-container");
        const owlMessage = document.getElementById("owl-message");
        const cursorEmoji = document.getElementById("cursor-emoji");

        function updateXPBar(tempRoundOffset = 0) {
            document.getElementById("xp-text").innerText = `${xp} XP`;

            // Progress Bar kini murni melacak progres pertanyaan (terjawab / total soal)
            const progress =
                ((currentRound + tempRoundOffset) / rounds.length) * 100;
            document.getElementById("xp-bar-fill").style.width =
                `${Math.min(progress, 100)}%`;
        }

        function renderRound() {
            const round = rounds[currentRound];
            questionText.innerHTML =
                `Simbol mana yang melambangkan<br/> <span class="text-green-500">"${round.question}"</span>?`;

            optionsContainer.innerHTML = "";

            // Acak urutan opsi
            const shuffledSymbols = [...symbols].sort(() => Math.random() - 0.5);

            shuffledSymbols.forEach((symbol) => {
                const btn = document.createElement("div");
                btn.id = `btn-${symbol.id}`;
                btn.className =
                    `option-btn relative w-36 h-36 md:w-40 md:h-40 rounded-[30px] flex flex-col items-center justify-center border-4 transition-all duration-300 cursor-pointer ${symbol.color} ${symbol.border} ${symbol.shadow}`;

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
                btn.addEventListener("click", () => handleSelection(symbol.id));

                btn.innerHTML = `
            <span class="text-6xl drop-shadow-lg mb-2 pointer-events-none">${symbol.icon}</span>
            <span class="text-white font-bold text-sm bg-black/20 px-3 py-1 rounded-full pointer-events-none">${symbol.name}</span>
          `;

                optionsContainer.appendChild(btn);
            });

            // Update warna dot indikator progres berdasarkan riwayat
            document.querySelectorAll(".dot").forEach((dot, index) => {
                if (index < currentRound) {
                    if (roundResults[index] === "correct") {
                        dot.className =
                            "w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-sm dot";
                    } else {
                        dot.className =
                            "w-4 h-4 bg-red-500 rounded-full border-2 border-white shadow-sm dot";
                    }
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

        function handleSelection(selectedId) {
            if (isAnimating) return;
            isAnimating = true;

            const round = rounds[currentRound];
            const btn = document.getElementById(`btn-${selectedId}`);

            if (selectedId === round.correct) {
                // --- JIKA BENAR ---
                playSuccessSound();
                btn.classList.add("animate-glow-gold");
                owlMessage.innerText = "Hebat! Jawabanmu benar!";
                confetti({
                    particleCount: 30,
                    spread: 40,
                    origin: {
                        y: 0.6
                    }
                });
                updateAssessment(assessment, {
                    literasi: 2,
                    visual: 2,
                    logika: 1
                });
                // Tambah XP
                xp += 5;
                levelEarnedXP += 5;
                correctAnswersCount++;
                roundResults.push("correct");
            } else {
                updateAssessment(assessment, {
                    logika: -1,
                    visual: -1
                });
                // --- JIKA SALAH ---
                playErrorSound();
                // Gunakan !important lewat style Tailwind agar warna merahnya menimpa warna default
                btn.classList.add(
                    "animate-shake",
                    "!bg-red-400",
                    "!border-red-500",
                    "!shadow-[0_10px_0_#991b1b]",
                );
                owlMessage.innerText = "Ups, kurang tepat!";

                // Sorot jawaban yang sebenarnya benar
                const correctBtn = document.getElementById(`btn-${round.correct}`);
                if (correctBtn) {
                    correctBtn.classList.add(
                        "animate-pulse",
                        "!bg-green-400",
                        "!border-green-500",
                    );
                }

                mistakesMade++;
                roundResults.push("wrong");
            }

            // Paksa bar progress untuk maju visualnya mendahului delay 1.5 detik
            updateXPBar(1);

            // Tunggu sebentar agar efek benar/salah bisa terlihat jelas, lalu pindah ke pertanyaan berikutnya
            setTimeout(() => {
                currentRound++;
                if (currentRound < rounds.length) {
                    owlMessage.innerText = "Arahkan jarimu ke jawaban yang benar!";
                    renderRound();
                } else {
                    showVictory();
                }
            }, 1500);
        }

        function showVictory() {
            const overlay = document.getElementById("victory-overlay");
            const modal = document.getElementById("victory-modal");

            // KALKULASI XP FINAL
            const levelCompletionXP = 20;
            const flawlessBonusXP = mistakesMade === 0 ? 10 : 0;

            const finalBonus = levelCompletionXP + flawlessBonusXP;
            xp += finalBonus;
            levelEarnedXP += finalBonus;

            // Pastikan angka bar atas terupdate di layar
            document.getElementById("xp-text").innerText = `${xp} XP`;

            // --- SISTEM BINTANG & DESKRIPSI RATING ---
            let stars = 1;
            let titleText = "Terus Berlatih!";
            let descText = "Tidak apa-apa salah, kamu pasti bisa lebih baik!";

            if (mistakesMade === 0) {
                stars = 3;
                titleText = "Sempurna!";
                descText = "Luar biasa! Kamu Penjelajah Hebat!";
            } else if (mistakesMade === 1) {
                stars = 2;
                titleText = "Kerja Bagus!";
                descText = "Hebat! Kamu hampir sempurna!";
            }

            const starsContainer = document.getElementById("victory-stars");
            starsContainer.innerHTML = "";
            for (let i = 1; i <= 3; i++) {
                if (i <= stars) {
                    // Bintang menyala (kuning)
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-yellow-400 fill-current drop-shadow-md animate-bounce-slight" style="animation-delay: ${i * 0.1}s"></i>`;
                } else {
                    // Bintang kosong (abu-abu)
                    starsContainer.innerHTML +=
                        `<i data-lucide="star" class="w-12 h-12 text-gray-300 fill-current drop-shadow-sm"></i>`;
                }
            }
            lucide.createIcons();

            document.getElementById("victory-title").innerText = titleText;
            document.getElementById("victory-subtitle").innerText = descText;

            // --- UPDATE Papan Skor Rincian XP ---
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

            // Tampilkan Modal
            overlay.classList.remove("hidden");
            overlay.classList.add("flex");
            modal.classList.add("animate-pop-in");

            // ANIMASI PARTY POPPER (Tembakan dari dua sisi bawah layar)
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
                    colors: [
                        "#26ccff",
                        "#a25afd",
                        "#ff5e7e",
                        "#88ff5a",
                        "#fcff42",
                        "#ffa62d",
                        "#ff36ff",
                    ],
                });
                confetti({
                    particleCount: 8,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1,
                        y: 1
                    },
                    colors: [
                        "#26ccff",
                        "#a25afd",
                        "#ff5e7e",
                        "#88ff5a",
                        "#fcff42",
                        "#ffa62d",
                        "#ff36ff",
                    ],
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
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
            const buttons = document.querySelectorAll(".option-btn");

            buttons.forEach((btn) => {
                const rect = btn.getBoundingClientRect();
                const padding = 30;
                if (
                    cursorX >= rect.left - padding &&
                    cursorX <= rect.right + padding &&
                    cursorY >= rect.top - padding &&
                    cursorY <= rect.bottom + padding
                ) {
                    btnHovered = btn;
                }
            });

            if (btnHovered && !isAnimating) {
                const currentId = btnHovered.id.replace("btn-", "");

                // Ubah pose kursor tangan saat masuk area tombol
                cursorEmoji.innerText = "👆";
                cursorEmoji.style.transform = "scale(1.2)";

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
                    document
                        .querySelectorAll(".option-btn")
                        .forEach((b) =>
                            b.classList.remove("scale-105", "animate-bounce-slight"),
                        );
                    btnHovered.classList.add("scale-105", "animate-bounce-slight");
                }
            } else {
                // Kembalikan ke tangan biasa
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
                    locateFile: (file) => {
                        return `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`;
                    },
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
                console.error("Kamera tidak dapat diakses:", error);
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
