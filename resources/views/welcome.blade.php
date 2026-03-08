<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AI-Powered BI | Learning Project</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col font-sans transition-colors duration-300">
        
        <header class="w-full lg:max-w-5xl max-w-[335px] text-sm mb-12">
            <nav class="flex items-center justify-between gap-4">
                <div class="font-bold tracking-tight text-lg">
                    <span class="text-[#f53003]">Ollama</span> x Laravel
                </div>
                @if (Route::has('login'))
                <div class="flex gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm hover:bg-[#1b1b18] hover:text-white transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-1.5 opacity-70 hover:opacity-100 transition-opacity">Log in</a>
                        <a href="{{ route('register') }}" class="px-5 py-1.5 border border-black dark:border-white bg-black text-white dark:bg-white dark:text-black rounded-sm font-medium">Get Started</a>
                    @endauth
                </div>
                @endif
            </nav>
        </header>

        <main class="w-full lg:max-w-5xl">
            <section class="mb-16 border-b border-[#e3e3e0] dark:border-[#3E3E3A] pb-12 text-center lg:text-left">
                <h1 class="text-4xl lg:text-6xl font-semibold mb-4 leading-tight">Secure AI-Powered <br><span class="text-[#f53003]">BI System Architecture</span></h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A] text-lg lg:max-w-2xl leading-relaxed">
                    A personal research project focused on bridging the gap between Natural Language and Relational Databases using <strong>Ollama (Llama3)</strong>, <strong>Redis</strong>, and <strong>Laravel</strong>.
                </p>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-24">
                <div class="p-6 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg">
                    <div class="w-8 h-8 bg-[#fff2f2] dark:bg-[#1D0002] rounded-full flex items-center justify-center mb-4 text-[#f53003]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-semibold mb-2">AI Logic & Prompts</h3>
                    <ul class="text-sm text-[#706f6c] dark:text-[#A1A09A] space-y-2">
                        <li>• Ollama + Llama3 Integration</li>
                        <li>• Structured JSON Output Control</li>
                        <li>• NL to Dynamic SQL Conversion</li>
                    </ul>
                </div>

                <div class="p-6 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg">
                    <div class="w-8 h-8 bg-blue-50 dark:bg-blue-950 rounded-full flex items-center justify-center mb-4 text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-semibold mb-2">SQL Security Layer</h3>
                    <ul class="text-sm text-[#706f6c] dark:text-[#A1A09A] space-y-2">
                        <li>• Blocking Non-SELECT Queries</li>
                        <li>• Dangerous Keyword Filtering</li>
                        <li>• Safe MySQL Execution Patterns</li>
                    </ul>
                </div>

                <div class="p-6 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg">
                    <div class="w-8 h-8 bg-green-50 dark:bg-green-950 rounded-full flex items-center justify-center mb-4 text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-semibold mb-2">Backend Optimization</h3>
                    <ul class="text-sm text-[#706f6c] dark:text-[#A1A09A] space-y-2">
                        <li>• Redis Driver Troubleshooting</li>
                        <li>• Dynamic Cache Lifetime (H/M/Y)</li>
                        <li>• Response Normalization</li>
                    </ul>
                </div>

                <div class="p-6 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg">
                    <div class="w-8 h-8 bg-purple-50 dark:bg-purple-950 rounded-full flex items-center justify-center mb-4 text-purple-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </div>
                    <h3 class="font-semibold mb-2">Frontend Engineering</h3>
                    <ul class="text-sm text-[#706f6c] dark:text-[#A1A09A] space-y-2">
                        <li>• Vanilla JS Result Visualization</li>
                        <li>• Aggregate vs Table Rendering</li>
                        <li>• AI Status Feedback & Loaders</li>
                    </ul>
                </div>

                <div class="p-6 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1c1c1a] rounded-lg flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold mb-1 italic">Learning Ledger v1.0</h3>
                        <p class="text-xs opacity-70">Focus: Local AI Deployment</p>
                    </div>
                    <div class="text-2xl font-bold tracking-tighter">
                        100% Secure AI-SQL
                    </div>
                </div>
            </div>

            <section class="mb-24">
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold mb-2">The Intelligence Pipeline</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm leading-relaxed">How natural language intent is converted into optimized SQL queries.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="p-6 bg-[#f9f9f7] dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                        <span class="text-[10px] uppercase tracking-widest text-[#f53003] font-bold">Step 01</span>
                        <h4 class="text-sm font-semibold mt-2">NL Processing</h4>
                        <p class="text-xs text-[#706f6c] mt-1">Llama3 interprets the natural language intent.</p>
                    </div>
                    <div class="p-6 bg-[#f9f9f7] dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                        <span class="text-[10px] uppercase tracking-widest text-blue-500 font-bold">Step 02</span>
                        <h4 class="text-sm font-semibold mt-2">Schema Mapping</h4>
                        <p class="text-xs text-[#706f6c] mt-1">Contextual injection of your table structures.</p>
                    </div>
                    <div class="p-6 bg-[#f9f9f7] dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                        <span class="text-[10px] uppercase tracking-widest text-orange-500 font-bold">Step 03</span>
                        <h4 class="text-sm font-semibold mt-2">Security Audit</h4>
                        <p class="text-xs text-[#706f6c] mt-1">RegEx filtering blocks destructive SQL.</p>
                    </div>
                    <div class="p-6 bg-[#1b1b18] text-white rounded-lg shadow-xl">
                        <span class="text-[10px] uppercase tracking-widest text-[#f53003] font-bold">Step 04</span>
                        <h4 class="text-sm font-semibold mt-2">Visual Output</h4>
                        <p class="text-xs opacity-70 mt-1">JSON rendered into dynamic Chart.js views.</p>
                    </div>
                </div>
            </section>

            <section class="p-8 lg:p-12 bg-[#fff2f2] dark:bg-[#1D0002] rounded-2xl flex flex-col lg:flex-row items-center justify-between gap-8 mb-24">
                <div class="flex-1 text-center lg:text-left">
                    <h2 class="text-3xl font-semibold mb-4 leading-tight text-[#1b1b18] dark:text-[#EDEDEC]">Integrated Project <br>Ecosystem</h2>
                    <p class="text-[#706f6c] dark:text-[#EDEDEC]/70 mb-6 text-sm">
                        Supporting complex reporting logic for <strong>Medi Help Ambulance</strong>, <strong>Assam Roll Ball</strong>, and the <strong>JDMP Journal</strong> platform.
                    </p>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-3">
                        <span class="px-3 py-1 bg-white/50 dark:bg-black/30 rounded text-[11px] font-bold uppercase tracking-wider">Laravel 12</span>
                        <span class="px-3 py-1 bg-white/50 dark:bg-black/30 rounded text-[11px] font-bold uppercase tracking-wider">Ollama v0.5</span>
                        <span class="px-3 py-1 bg-white/50 dark:bg-black/30 rounded text-[11px] font-bold uppercase tracking-wider">Redis 7.2</span>
                    </div>
                </div>
                <div class="flex-1 w-full max-w-sm bg-white dark:bg-[#0a0a0a] p-6 rounded-xl shadow-2xl border border-[#f53003]/20">
                     <div class="space-y-4">
                        <div class="h-2 w-3/4 bg-[#f53003]/10 rounded"></div>
                        <div class="h-2 w-full bg-[#f53003]/20 rounded"></div>
                        <div class="h-2 w-1/2 bg-[#f53003]/10 rounded"></div>
                        <div class="pt-4 flex items-center justify-between border-t border-[#f53003]/10">
                            <span class="text-xs font-bold uppercase tracking-tighter">System Health</span>
                            <span class="text-xs text-green-500 font-medium">99.9% Uptime</span>
                        </div>
                     </div>
                </div>
            </section>

            <section class="grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-[#e3e3e0] dark:border-[#3E3E3A] pt-12 pb-20">
                <div>
                    <p class="text-[10px] uppercase text-[#706f6c] tracking-widest mb-1">AI Latency</p>
                    <p class="text-2xl font-semibold">&lt; 1.2s</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase text-[#706f6c] tracking-widest mb-1">Query Cache</p>
                    <p class="text-2xl font-semibold uppercase">Redis</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase text-[#706f6c] tracking-widest mb-1">Data Safety</p>
                    <p class="text-2xl font-semibold">Read-Only</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase text-[#706f6c] tracking-widest mb-1">Stack</p>
                    <p class="text-2xl font-semibold text-[#f53003]">L12 + OLL</p>
                </div>
            </section>
        </main>

        <footer class="mt-auto text-[#706f6c] text-[10px] uppercase tracking-widest pb-8 text-center">
            Built for Learning Purpose &bull; Guwahati, Assam &bull; 2026
        </footer>
    </body>
</html>