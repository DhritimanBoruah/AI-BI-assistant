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
        
        :root { --glass-bg: rgba(255, 255, 255, 0.7); }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }

        /* Smooth Glassmorphism */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        /* Advanced Shimmer */
        .shimmer {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer-effect 1.6s infinite linear;
        }
        @keyframes shimmer-effect { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* Professional AI Pulse */
        .ai-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            animation: glow-pulse 3s infinite;
        }
        @keyframes glow-pulse { 0%, 100% { opacity: 0.8; } 50% { opacity: 1; box-shadow: 0 0 35px rgba(59, 130, 246, 0.5); } }

        /* Custom Scrollbar for Pro Apps */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-900">

    <aside class="w-20 lg:w-72 bg-[#0f172a] text-slate-400 flex flex-col transition-all duration-300 border-r border-slate-800">
        <div class="h-20 flex items-center px-6 gap-4">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i class="fas fa-terminal text-white"></i>
            </div>
            <span class="hidden lg:block text-white font-extrabold tracking-tight text-xl italic">AI-BI <span class="text-blue-500 underline decoration-2 underline-offset-4">assistant</span></span>
        </div>

        <div class="flex-1 px-4 py-6 space-y-8">
            <div>
                <p class="hidden lg:block text-[10px] uppercase font-black text-slate-500 mb-4 tracking-[0.2em] px-2">Core Operations</p>
                <div class="space-y-1">
                    <a href="#" class="flex items-center gap-4 px-3 py-3 rounded-xl bg-blue-600/10 text-blue-400 border border-blue-500/20 group">
                        <i class="fas fa-compass w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="hidden lg:block font-bold">Insight Center</span>
                    </a>
                    <a href="#" class="flex items-center gap-4 px-3 py-3 rounded-xl hover:bg-slate-800 transition-all group">
                        <i class="fas fa-database w-5 text-center group-hover:text-white"></i>
                        <span class="hidden lg:block font-medium group-hover:text-white">Data Warehouse</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="hidden lg:block text-[10px] uppercase font-black text-slate-500 mb-4 tracking-[0.2em] px-2">System Admin</p>
                <div class="space-y-1">
                    <a href="#" class="flex items-center gap-4 px-3 py-3 rounded-xl hover:bg-slate-800 transition-all group">
                        <i class="fas fa-shield-halved w-5 text-center group-hover:text-white"></i>
                        <span class="hidden lg:block font-medium group-hover:text-white">Security Matrix</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-slate-800">
            <div class="hidden lg:flex items-center gap-3 bg-slate-800/40 p-3 rounded-2xl mb-4 border border-slate-700/50">
                <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_#22c55e]"></div>
                <span class="text-[11px] font-bold text-slate-300">SERVER CLUSTER 01: ON</span>
            </div>
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
        
        <header class="h-20 glass-panel px-10 flex items-center justify-between sticky top-0 z-40 border-b border-slate-200/60">
            <div class="flex flex-col">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Global Dashboard</span>
                <h1 class="text-xl font-extrabold text-slate-800">Operational Intelligence</h1>
            </div>

            <div class="flex items-center gap-8">
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-sm font-bold text-slate-900 leading-none mb-1">{{ auth()->user()->name ?? 'Lead Analyst' }}</span>
                    <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full tracking-wide">LEVEL 4 ACCESS</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center group cursor-pointer hover:border-blue-400 transition-all">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" class="w-9 h-9 rounded-xl" alt="user">
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 lg:p-12 space-y-10">
            
            <div class="max-w-6xl mx-auto">
                <div class="relative bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
                    
                    <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600"></div>

                    <div class="p-10">
                        <div class="flex items-center gap-6 mb-8">
                            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-white ai-glow">
                                <i class="fas fa-bolt-lightning text-xl text-blue-400"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">AI Data Engine</h2>
                                <p class="text-sm font-semibold text-slate-400">Current Context: <span class="text-blue-600 font-bold uppercase tracking-wider text-[11px] ml-1">Student Attendance DB</span></p>
                            </div>
                        </div>

                        <div class="relative group">
                            <textarea id="question" rows="4" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-[2rem] p-8 text-lg font-medium text-slate-700 placeholder:text-slate-300 focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition-all outline-none resize-none shadow-inner"
                                placeholder="e.g. 'Show me the attendance growth over the last 30 days'"></textarea>
                            
                            <div class="absolute bottom-6 right-6 flex items-center gap-4">
                                <div id="status-container" class="hidden flex items-center gap-3 bg-blue-50 px-5 py-2.5 rounded-full border border-blue-100">
                                    <div class="flex gap-1">
                                        <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-ping"></span>
                                        <span class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-ping [animation-delay:0.2s]"></span>
                                    </div>
                                    <span id="status-text" class="text-[10px] font-black text-blue-600 uppercase tracking-[0.15em]">Processing</span>
                                </div>

                                <button onclick="askAI()" id="btn-submit"
                                    class="h-16 px-10 bg-slate-900 text-white rounded-2xl font-bold shadow-2xl hover:bg-blue-600 active:scale-95 transition-all flex items-center gap-3">
                                    <span id="btn-label">Analyze</span>
                                    <i id="btn-icon" class="fas fa-chevron-right text-xs opacity-50"></i>
                                    
                                    <div id="loader" class="hidden flex items-end gap-[3px] h-5">
                                        <div class="w-[4px] bg-white rounded-full animate-[pulse_0.8s_infinite] h-2"></div>
                                        <div class="w-[4px] bg-white rounded-full animate-[pulse_0.8s_infinite_0.2s] h-5"></div>
                                        <div class="w-[4px] bg-white rounded-full animate-[pulse_0.8s_infinite_0.4s] h-3"></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="result-wrapper" class="hidden bg-slate-50/50 border-t border-slate-100 p-10">
                        <div id="skeleton" class="hidden space-y-8">
                            <div class="flex items-start gap-5">
                                <div class="w-12 h-12 rounded-2xl shimmer flex-shrink-0"></div>
                                <div class="space-y-3 w-full">
                                    <div class="h-3 w-32 shimmer rounded-full"></div>
                                    <div class="h-20 w-3/4 shimmer rounded-3xl"></div>
                                </div>
                            </div>
                            <div class="h-64 w-full shimmer rounded-[2rem]"></div>
                        </div>

                        <div id="ai-content" class="space-y-8"></div>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest w-full text-center mb-2">Preset Intelligence Protocols</span>
                    <button onclick="document.getElementById('question').value=this.dataset.q" data-q="Attendance rates by Class ID" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm">Class Performance</button>
                    <button onclick="document.getElementById('question').value=this.dataset.q" data-q="Summary of attendance_status" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm">Status Distribution</button>
                </div>
            </div>
        </main>
    </div>

    <script>
    function askAI() {
        const question = document.getElementById('question').value;
        const resultWrapper = document.getElementById('result-wrapper');
        const skeleton = document.getElementById('skeleton');
        const content = document.getElementById('ai-content');
        const btn = document.getElementById('btn-submit');
        const btnLabel = document.getElementById('btn-label');
        const btnIcon = document.getElementById('btn-icon');
        const loader = document.getElementById('loader');
        const statusContainer = document.getElementById('status-container');
        const statusText = document.getElementById('status-text');

        if (!question.trim()) return;

        // UI LOCK & LOADING
        btn.disabled = true;
        btnLabel.innerText = "Querying";
        btnIcon.classList.add('hidden');
        loader.classList.remove('hidden');
        
        statusContainer.classList.remove('hidden');
        resultWrapper.classList.remove('hidden');
        skeleton.classList.remove('hidden');
        content.classList.add('hidden');
        content.innerHTML = '';

        // Status cycling (Professional AI Persona)
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
            body: JSON.stringify({ question: question })
        })
        .then(res => res.json())
        .then(data => {
            clearInterval(interval);
            renderBusinessData(data);
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

    function renderBusinessData(data) {
        const content = document.getElementById('ai-content');
        let html = '';

        if (data.error) {
            html = `<div class="p-8 bg-red-50 border border-red-100 rounded-[2rem] text-red-700 flex gap-5 italic font-medium"><i class="fas fa-triangle-exclamation mt-1"></i>${data.error}</div>`;
        } else {
            // AI Narrative
            html += `
            <div class="flex gap-6">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-white shadow-xl shadow-indigo-200">
                    <i class="fas fa-message-sparkles text-xl"></i>
                </div>
                <div class="bg-white p-8 rounded-[0.5rem_2rem_2rem_2rem] border border-slate-100 shadow-sm flex-1">
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-3 block">AI Summary</span>
                    <p class="text-lg font-semibold text-slate-700 leading-relaxed italic">"${data.explanation}"</p>
                </div>
            </div>`;

            // Visualization
            if (data.type === 'aggregate') {
                html += `
                <div class="bg-slate-900 p-12 rounded-[3rem] text-center border-b-8 border-blue-600">
                    <p class="text-[11px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Core Metric Result</p>
                    <h3 class="text-7xl font-black text-white tracking-tighter">${data.value}</h3>
                    <div class="mt-6 inline-flex items-center gap-2 text-blue-400 text-xs font-bold px-4 py-2 bg-blue-400/10 rounded-full border border-blue-400/20">
                        <i class="fas fa-check-double"></i> VERIFIED BY AI ENGINE
                    </div>
                </div>`;
            }

            if (data.type === 'table') {
                html += `
                <div class="space-y-4">
                    <div class="flex items-center justify-between px-2">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Enterprise Dataset</h4>
                        <button onclick="window.print()" class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-lg hover:bg-blue-100 transition-colors">EXPORT TO PDF</button>
                    </div>
                    <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-xl">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">
                                        ${Object.keys(data.data[0]).map(key => `<th class="px-8 py-5">${key.replace(/_/g, ' ')}</th>`).join('')}
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    ${data.data.map(row => `
                                        <tr class="hover:bg-blue-50/40 transition-colors group">
                                            ${Object.values(row).map(val => `<td class="px-8 py-5 text-sm font-bold text-slate-600 group-hover:text-blue-700">${val ?? '—'}</td>`).join('')}
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>`;
            }
        }
        content.innerHTML = html;
    }
    </script>
</body>
</html>