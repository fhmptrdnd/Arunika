// assessment.js
function createAssessment(config) {
    const result = {};

    Object.keys(config).forEach((key) => {
        if (config[key]) result[key] = 0;
    });

    return result;
}

// update nilai
function updateAssessment(assessment, changes) {
    Object.keys(changes).forEach((key) => {
        if (assessment.hasOwnProperty(key)) {
            assessment[key] += changes[key];

            if (assessment[key] < 0) {
                assessment[key] = 0;
            }
        }
    });
}

// render UI otomatis
function renderAssessmentUI(assessment) {
    const container = document.getElementById("assessment-container");
    if (!container) return;

    const labels = {
        literasi: "📖 Literasi",
        logika: "🧠 Logika",
        visual: "👁️ Visual",
        numerasi: "🔢 Numerasi",
        english: "🇬🇧 English",
    };

    const colors = {
        literasi: "from-blue-400 to-blue-600",
        logika: "from-purple-400 to-purple-600",
        visual: "from-green-400 to-green-600",
        numerasi: "from-yellow-400 to-orange-500",
        english: "from-red-400 to-red-600",
    };

    container.innerHTML = `
    <div class="bg-gradient-to-br mb-4 from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-5 shadow-inner w-full max-w-md mx-auto">
        <h3 class="text-center font-black text-blue-700 mb-5 text-lg">
            Performa Kamu
        </h3>
        <div id="assessment-list" class="space-y-4"></div>
    </div>
`;

    const list = container.querySelector("#assessment-list");

    Object.keys(assessment).forEach((key) => {
        list.innerHTML += `
        <div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    ${labels[key] || key}
                </span>
                <span class="text-sm font-bold text-gray-800">
                    ${assessment[key]}
                </span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div id="bar-${key}"
                    class="h-4 rounded-full bg-gradient-to-r ${colors[key] || "from-gray-400 to-gray-600"} transition-all duration-700 ease-out"
                    style="width:0%">
                </div>
            </div>
        </div>
        `;
    });
}

// update bar
function updateAssessmentBar(assessment) {
    const maxScore = Math.max(...Object.values(assessment), 10);

    Object.keys(assessment).forEach((key) => {
        const bar = document.getElementById(`bar-${key}`);
        const score = document.getElementById(`score-${key}`);

        if (bar) {
            const percent = Math.min((assessment[key] / maxScore) * 100, 100);

            // delay biar animasi smooth
            setTimeout(() => {
                bar.style.width = percent + "%";
            }, 100);
        }

        if (score) {
            score.innerText = assessment[key];
        }
    });
}
