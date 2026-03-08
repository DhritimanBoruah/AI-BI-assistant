<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intelligence OS | Enterprise BI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        :root {
            --glass-bg: rgba(255, 255, 255, 0.8);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .shimmer {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer-effect 1.6s infinite linear;
        }

        @keyframes shimmer-effect {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .ai-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
            animation: glow-pulse 3s infinite;
        }

        @keyframes glow-pulse {

            0%,
            100% {
                opacity: 0.9;
            }

            50% {
                opacity: 1;
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.4);
            }
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        #autocomplete-results {
            transition: all 0.2s ease-in-out;
            max-height: 320px;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-slate-900">

    <aside
        class="w-20 lg:w-72 bg-[#0f172a] text-slate-400 flex flex-col transition-all duration-300 border-r border-slate-800 z-50">
        <div class="h-20 flex items-center px-6 gap-4">
            <div
                class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 flex-shrink-0">
                <i class="fas fa-terminal text-white"></i>
            </div>
            <span class="hidden lg:block text-white font-extrabold tracking-tight text-xl italic">AI-BI <span
                    class="text-blue-500 underline decoration-2 underline-offset-4">assistant</span></span>
        </div>

        <div class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">
            <div>
                <p class="hidden lg:block text-[10px] uppercase font-black text-slate-500 mb-4 tracking-[0.2em] px-2">
                    Core Operations</p>
                <div class="space-y-1">
                    <a href="#"
                        class="flex items-center gap-4 px-3 py-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-500/20 group">
                        <i class="fas fa-compass w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="hidden lg:block font-bold">Insight Center</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="hidden lg:block text-[10px] uppercase font-black text-slate-500 mb-4 tracking-[0.2em] px-2">
                    Recent Queries</p>
                <div id="query-history-list" class="space-y-2 px-1"></div>
            </div>
        </div>

        <div class="p-6 border-t border-slate-800">

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="w-full flex items-center justify-center lg:justify-start gap-4 text-slate-500 hover:text-red-400 transition-all p-2 group">
                <i class="fas fa-sign-out-alt group-hover:rotate-12 transition-transform"></i>
                <span class="hidden lg:block font-bold text-sm">Terminate Session</span>
            </button>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-20 glass-panel px-6 lg:px-10 flex items-center justify-between sticky top-0 z-40">
            <div class="flex flex-col">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Global Dashboard</span>
                <h1 class="text-xl font-extrabold text-slate-800">Operational Intelligence</h1>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 lg:p-12 space-y-10">
            <div class="max-w-6xl mx-auto">
                <div
                    class="relative bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600"></div>
                    <div class="p-6 lg:p-10">
                        <div class="flex items-center gap-6 mb-8">
                            <div
                                class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-white ai-glow">
                                <i class="fas fa-bolt-lightning text-xl text-blue-400"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">AI Data Engine</h2>
                                <p class="text-sm font-semibold text-slate-400">Context: <span
                                        class="text-blue-600 font-bold uppercase tracking-wider text-[11px] ml-1">Enterprise
                                        DB</span></p>
                            </div>
                        </div>

                        <div class="relative group">
                            <textarea id="question" rows="3" oninput="handleTyping(this.value)" autocomplete="off"
                                class="w-full bg-slate-50 border border-slate-200 rounded-[2rem] p-6 lg:p-8 text-lg font-medium text-slate-700 placeholder:text-slate-300 focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition-all outline-none resize-none shadow-inner"
                                placeholder="Ask anything about your data..."></textarea>

                            <div id="autocomplete-results"
                                class="hidden absolute left-0 right-0 top-[105%] bg-white border border-slate-200 rounded-2xl z-50 overflow-hidden">
                            </div>

                            <div class="absolute bottom-4 right-4 lg:bottom-6 lg:right-6 flex items-center gap-4">
                                <div id="status-container"
                                    class="hidden flex items-center gap-3 bg-blue-50 px-5 py-2.5 rounded-full border border-blue-100">
                                    <span id="status-text"
                                        class="text-[10px] font-black text-blue-600 uppercase tracking-[0.15em]">Processing</span>
                                </div>

                                <button onclick="askAI()" id="btn-submit"
                                    class="h-14 lg:h-16 px-8 lg:px-10 bg-slate-900 text-white rounded-2xl font-bold shadow-2xl hover:bg-blue-600 active:scale-95 transition-all flex items-center gap-3">
                                    <span id="btn-label">Analyze</span>
                                    <i id="btn-icon" class="fas fa-chevron-right text-xs opacity-50"></i>
                                    <div id="loader" class="hidden flex items-end gap-[3px] h-5">
                                        <div class="w-[4px] bg-white rounded-full animate-[pulse_0.8s_infinite] h-2">
                                        </div>
                                        <div
                                            class="w-[4px] bg-white rounded-full animate-[pulse_0.8s_infinite_0.2s] h-5">
                                        </div>
                                        <div
                                            class="w-[4px] bg-white rounded-full animate-[pulse_0.8s_infinite_0.4s] h-3">
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="result-wrapper" class="hidden bg-slate-50/50 border-t border-slate-100 p-6 lg:p-10">
                        <div id="skeleton" class="hidden space-y-8">
                            <div class="h-20 w-3/4 shimmer rounded-3xl"></div>
                            <div class="h-64 w-full shimmer rounded-[2rem]"></div>
                        </div>
                        <div id="ai-content" class="space-y-8"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let biChartInstance = null;
        let lastAiRawData = null;
        let cachedHistory = []; // Local unique cache

        document.addEventListener('DOMContentLoaded', loadHistory);

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#question')) {
                document.getElementById('autocomplete-results').classList.add('hidden');
            }
        });

        function loadHistory() {
            const historyList = document.getElementById('query-history-list');
            fetch('/ai-history')
                .then(res => res.json())
                .then(data => {
                    // Filter duplicates from the source array by question text
                    const uniqueEntries = [];
                    const seen = new Set();
                    data.forEach(item => {
                        const normalized = item.question.trim().toLowerCase();
                        if (!seen.has(normalized)) {
                            seen.add(normalized);
                            uniqueEntries.push(item);
                        }
                    });

                    cachedHistory = uniqueEntries;
                    if (!uniqueEntries.length) return;

                    historyList.innerHTML = '';
                    uniqueEntries.forEach(item => {
                        const date = new Date(item.created_at).toLocaleDateString(undefined, {
                            month: 'short',
                            day: 'numeric'
                        });
                        const historyItem = `
                        <div onclick="selectSuggestion('${item.question.replace(/'/g, "\\'")}')" 
                            class="p-3 rounded-xl bg-slate-800/30 border border-slate-700/50 cursor-pointer hover:bg-slate-700 transition-all group overflow-hidden">
                            <p class="text-[11px] text-slate-300 truncate font-semibold group-hover:text-white">"${item.question}"</p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-[9px] text-blue-400 font-mono italic font-bold">${item.execution_time_ms}ms</span>
                                <span class="text-[8px] text-slate-500 uppercase font-bold tracking-tighter">${date}</span>
                            </div>
                        </div>`;
                        historyList.insertAdjacentHTML('beforeend', historyItem);
                    });
                })
                .catch(err => console.error("History fetch error", err));
        }

        function handleTyping(val) {
            const dropdown = document.getElementById('autocomplete-results');
            if (val.length < 2) {
                dropdown.classList.add('hidden');
                return;
            }
            const matches = cachedHistory.filter(item =>
                item.question.toLowerCase().includes(val.toLowerCase())
            ).slice(0, 5);

            if (matches.length > 0) {
                dropdown.innerHTML = matches.map(item => `
                <div onclick="selectSuggestion('${item.question.replace(/'/g, "\\'")}')" 
                     class="px-8 py-4 hover:bg-blue-50 cursor-pointer flex items-center gap-4 border-b border-slate-50 last:border-0 group">
                    <i class="fas fa-clock-rotate-left text-slate-300 text-xs group-hover:text-blue-400"></i>
                    <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900">${item.question}</span>
                </div>
            `).join('');
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function selectSuggestion(text) {
            document.getElementById('question').value = text;
            document.getElementById('autocomplete-results').classList.add('hidden');
            askAI(text);
        }

        function askAI(historicalQuestion = null) {
            const questionInput = document.getElementById('question');
            const questionText = (historicalQuestion || questionInput.value).trim();
            if (!questionText) return;

            // Visual UI trigger
            document.getElementById('autocomplete-results').classList.add('hidden');
            if (historicalQuestion) questionInput.value = historicalQuestion;

            const resultWrapper = document.getElementById('result-wrapper');
            const skeleton = document.getElementById('skeleton');
            const content = document.getElementById('ai-content');
            const btn = document.getElementById('btn-submit');
            const btnLabel = document.getElementById('btn-label');
            const btnIcon = document.getElementById('btn-icon');
            const loader = document.getElementById('loader');
            const statusContainer = document.getElementById('status-container');
            const statusText = document.getElementById('status-text');

            btn.disabled = true;
            btnLabel.innerText = "Querying";
            btnIcon.classList.add('hidden');
            loader.classList.remove('hidden');
            statusContainer.classList.remove('hidden');
            resultWrapper.classList.remove('hidden');
            skeleton.classList.remove('hidden');
            content.classList.add('hidden');
            content.innerHTML = '';

            const messages = ["Analyzing Intent", "Schema Mapping", "Executing SQL", "Sanitizing Results"];
            let mIdx = 0;
            const interval = setInterval(() => {
                statusText.innerText = messages[mIdx % messages.length];
                mIdx++;
            }, 1200);

            fetch('/ask-ai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        question: questionText
                    })
                })
                .then(res => res.json())
                .then(data => {
                    clearInterval(interval);
                    renderBusinessData(data, questionText);

                    // ✅ Only reload history if the query is truly new to the current session cache
                    const exists = cachedHistory.some(h => h.question.trim().toLowerCase() === questionText
                    .toLowerCase());
                    if (!exists) {
                        loadHistory();
                    }
                })
                .finally(() => {
                    btn.disabled = false;
                    btnLabel.innerText = "Analyze";
                    btnIcon.classList.remove('hidden');
                    loader.classList.add('hidden');
                    statusContainer.classList.add('hidden');
                    skeleton.classList.add('hidden');
                    content.classList.remove('hidden');
                });
        }

        function renderBusinessData(data, question) {
            const content = document.getElementById('ai-content');
            const aiData = data.data ? data.data : data;
            let html = '';

            if (aiData.error) {
                html = `<div class="p-8 bg-red-50 border border-red-100 rounded-[2rem] text-red-700 flex gap-5 italic font-medium">
                        <i class="fas fa-triangle-exclamation mt-1"></i>${aiData.error}
                    </div>`;
            } else {
                html += `<div class="flex justify-end mb-4">
                <div class="px-3 py-1 bg-slate-100 border border-slate-200 rounded-lg flex items-center gap-2">
                    <i class="fas fa-stopwatch text-slate-400 text-[10px]"></i>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Speed: ${aiData.execution_time ?? '0ms'}</span>
                </div>
            </div>`;

                html += `<div class="flex gap-6">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-white shadow-xl">
                    <i class="fas fa-message-sparkles text-xl"></i>
                </div>
                <div class="bg-white p-8 rounded-[0.5rem_2rem_2rem_2rem] border border-slate-100 shadow-sm flex-1">
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-3 block">AI Summary</span>
                    <p class="text-lg font-semibold text-slate-700 leading-relaxed italic">"${aiData.explanation}"</p>
                </div>
            </div>`;

                const isSingleValue = aiData.type === 'scalar' || aiData.type === 'aggregate' || (aiData.type === 'table' &&
                    aiData.data.length === 1 && Object.keys(aiData.data[0]).length === 1);

                if (isSingleValue) {
                    const rawVal = (aiData.type === 'scalar' || aiData.type === 'aggregate') ? aiData.value : Object.values(
                        aiData.data[0])[0];
                    const displayVal = !isNaN(rawVal) ?
                        "₹" + parseFloat(rawVal).toLocaleString('en-IN', {
                            minimumFractionDigits: 2
                        }) :
                        rawVal;

                    html += `<div class="bg-[#0f172a] rounded-[2.5rem] p-12 text-center shadow-2xl relative overflow-hidden group">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4 block">Core Metric Result</span>
                    <h3 class="text-5xl lg:text-7xl font-black text-white tracking-tighter mb-6">${displayVal}</h3>
                    <div class="flex justify-center">
                        <div class="px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full flex items-center gap-2 text-blue-400 font-bold uppercase text-[10px]">
                            <i class="fas fa-check-circle"></i> Verified by AI Engine
                        </div>
                    </div>
                </div>`;
                }

                if (aiData.chartable) {
                    lastAiRawData = aiData;
                    const dataSource = aiData.type === 'table' ? aiData.data : aiData.rawData;
                    const numericCols = Object.keys(dataSource[0] || {}).filter(key => !isNaN(dataSource[0][key]) && !['id',
                        'year', 'month'
                    ].some(id => key.toLowerCase().includes(id)));
                    const defaultMetric = numericCols.includes('revenue') ? 'revenue' : numericCols[0];
                    const initialValues = dataSource.map(row => parseFloat(row[defaultMetric]) || 0);

                    html += `<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl space-y-4">
                    <div class="flex flex-col">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">Data Trends</h4>
                        <div class="flex flex-wrap gap-2 mt-3">${numericCols.map(col => `
                                <button onclick="updateChartMetric('${col}')" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-blue-600 hover:text-white transition-all border border-blue-100">
                                    <i class="fas fa-chart-line mr-1"></i> ${col.replace(/_/g, ' ')}
                                </button>`).join('')}</div>
                    </div>
                    <div class="relative h-[350px] w-full mt-4"><canvas id="biChart"></canvas></div>
                </div>`;
                    setTimeout(() => initChart(aiData.labels, initialValues, defaultMetric), 50);
                }

                if (aiData.type === 'table' && aiData.data.length > 0) {
                    html += `<div class="space-y-4">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">Enterprise Dataset</h4>
                    <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-xl overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] font-black text-slate-500 uppercase">
                                <tr>${Object.keys(aiData.data[0]).map(k => `<th class="px-8 py-5">${k.replace(/_/g, ' ')}</th>`).join('')}</tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                ${aiData.data.map(row => `<tr class="hover:bg-blue-50/40 transition-colors group">
                                        ${Object.values(row).map(v => `<td class="px-8 py-5 text-sm font-bold text-slate-600 group-hover:text-blue-700">${v ?? '—'}</td>`).join('')}
                                    </tr>`).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>`;
                }
            }
            content.innerHTML = html;
        }

        function initChart(labels, values, labelName) {
            const ctx = document.getElementById('biChart').getContext('2d');
            if (biChartInstance) biChartInstance.destroy();
            biChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: labelName.replace(/_/g, ' '),
                        data: values,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderRadius: 12,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                font: {
                                    weight: '600'
                                },
                                callback: (v) => v >= 1000 ? (v / 1000) + 'k' : v
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });
        }

        window.updateChartMetric = function(metricName) {
            if (!biChartInstance || !lastAiRawData) return;
            const source = lastAiRawData.type === 'table' ? lastAiRawData.data : lastAiRawData.rawData;
            biChartInstance.data.datasets[0].label = metricName.replace(/_/g, ' ');
            biChartInstance.data.datasets[0].data = source.map(row => parseFloat(row[metricName]) || 0);
            biChartInstance.update();
        };
    </script>
</body>

</html>
