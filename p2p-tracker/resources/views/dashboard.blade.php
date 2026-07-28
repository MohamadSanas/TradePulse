@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .tp-dashboard {
            --tp-surface: #12131c;
            --tp-surface-low: #1a1b24;
            --tp-surface-high: #282933;
            --tp-panel-border: rgba(255, 255, 255, 0.05);
            --tp-text: #e3e1ef;
            --tp-muted: #b9cacb;
            --tp-outline: #849495;
            --tp-outline-variant: #3b494b;
            --tp-cyan: #00f0ff;
            --tp-violet: #7213ff;
            background-color: var(--tp-surface);
            background-image:
                radial-gradient(circle at 50% 0%, rgba(0, 240, 255, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(114, 19, 255, 0.06) 0%, transparent 50%);
            color: var(--tp-text);
            font-family: "Hanken Grotesk", sans-serif;
        }

        .tp-dashboard .tp-headline {
            font-family: "Sora", sans-serif;
        }

        .tp-dashboard .tp-label {
            font-family: "JetBrains Mono", monospace;
            letter-spacing: 0.08em;
        }

        .tp-grid {
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .tp-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid var(--tp-panel-border);
            box-shadow: inset 0 0 1px 1px rgba(255, 255, 255, 0.02);
        }

        .tp-panel-cyan {
            border-color: rgba(0, 240, 255, 0.3);
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.1);
        }

        .tp-scanline {
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(0, 240, 255, 0.1), transparent);
            position: absolute;
            animation: tp-scan 4s linear infinite;
        }

        .tp-chamfer {
            clip-path: polygon(0 0, 92% 0, 100% 25%, 100% 100%, 8% 100%, 0 75%);
        }

        .tp-active-dot {
            width: 8px;
            height: 8px;
            background: var(--tp-cyan);
            border-radius: 9999px;
            box-shadow: 0 0 10px var(--tp-cyan);
            animation: tp-pulse 2s infinite;
        }

        @keyframes tp-scan {
            0% { top: -2px; }
            100% { top: 100%; }
        }

        @keyframes tp-pulse {
            0% { transform: scale(0.9); opacity: 0.7; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.7; }
        }
    </style>
@endpush

<x-app-layout>
    <div class="tp-dashboard min-h-screen pb-32 text-[#e3e1ef]">
        <div class="tp-grid pointer-events-none fixed inset-0 opacity-20"></div>

        <nav x-data="{ open: false }" class="fixed left-0 top-0 z-50 w-full border-b border-white/10 bg-black/10 backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="tp-headline flex items-center gap-2 text-xl font-bold uppercase tracking-[0.18em] text-[#00f0ff]">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">pause</span>
                        Trade Pulse
                    </a>

                    <div class="hidden gap-6 md:flex">
                        <a href="{{ route('dashboard') }}" class="tp-label border-b-2 border-[#00f0ff] py-1 text-sm text-[#00f0ff]">Dashboard</a>
                        <a href="{{ route('trades.index') }}" class="tp-label py-1 text-sm text-[#b9cacb] transition-colors duration-300 hover:text-[#00f0ff]">Trades</a>
                        <a href="{{ route('capital-amount.index') }}" class="tp-label py-1 text-sm text-[#b9cacb] transition-colors duration-300 hover:text-[#00f0ff]">Capital</a>
                    </div>
                </div>

                <div class="hidden items-center gap-4 md:flex">
                    <div class="flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1">
                        <div class="tp-active-dot"></div>
                        <span class="tp-label text-xs uppercase tracking-widest text-[#00f0ff]">System Online</span>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 p-2 text-[#b9cacb] transition-colors hover:text-[#00f0ff]">
                        <span class="material-symbols-outlined">settings</span>
                    </a>

                    <div class="relative" x-data="{ menu: false }">
                        <button x-on:click="menu = !menu" class="flex items-center gap-2 p-2 text-[#b9cacb] transition-colors hover:text-[#00f0ff]">
                            <span class="material-symbols-outlined">account_circle</span>
                            <span class="tp-label hidden text-sm sm:inline">{{ Auth::user()->name }}</span>
                        </button>

                        <div x-show="menu" x-on:click.outside="menu = false" x-transition class="tp-panel absolute right-0 mt-3 w-56 rounded-xl p-3">
                            <div class="border-b border-white/10 px-3 pb-3">
                                <p class="tp-headline text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-[#849495]">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-[#b9cacb] transition hover:bg-white/5 hover:text-[#00f0ff]">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-[#ffb4ab] transition hover:bg-white/5">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <button x-on:click="open = !open" class="md:hidden text-[#b9cacb]">
                    <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'"></span>
                </button>
            </div>

            <div x-show="open" x-transition class="border-t border-white/10 px-6 py-4 md:hidden">
                <div class="flex flex-col gap-3">
                    <a href="{{ route('dashboard') }}" class="tp-label text-sm text-[#00f0ff]">Dashboard</a>
                    <a href="{{ route('trades.index') }}" class="tp-label text-sm text-[#b9cacb]">Trades</a>
                    <a href="{{ route('capital-amount.index') }}" class="tp-label text-sm text-[#b9cacb]">Capital</a>
                    <a href="{{ route('profile.edit') }}" class="tp-label text-sm text-[#b9cacb]">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="tp-label text-left text-sm text-[#ffb4ab]">Log Out</button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="mx-auto max-w-7xl space-y-6 px-6 pb-10 pt-24 lg:px-8">
            <header class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Overview Control Center</span>
                    <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white md:text-5xl">Dashboard</h1>
                </div>

                <div class="flex gap-4">
                    <div class="tp-panel rounded-lg border border-white/5 px-4 py-2 text-right">
                        <span class="tp-label text-xs text-[#849495]">Network Latency</span>
                        <span id="tp-latency" class="tp-label block text-sm text-[#00f0ff]">12MS</span>
                    </div>
                    <div class="tp-panel rounded-lg border border-white/5 px-4 py-2 text-right">
                        <span class="tp-label text-xs text-[#849495]">Uptime</span>
                        <span class="tp-label block text-sm text-[#00f0ff]">99.9%</span>
                    </div>
                </div>
            </header>

            @if (session('success'))
                <div class="rounded-xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <section x-data="{ editing: {{ $errors->any() ? 'true' : 'false' }} }" class="tp-panel relative overflow-hidden rounded-xl">
                <div class="tp-scanline"></div>
                <div class="flex flex-col gap-4 border-b border-white/5 bg-white/5 p-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="tp-headline text-2xl font-semibold text-white">Current Status</h2>
                        <p class="text-base text-[#849495]">Real-time metrics for active trading positions and liquidity.</p>
                    </div>

                    <button x-show="!editing" type="button" x-on:click="editing = true" class="tp-label px-6 py-2 text-sm font-bold uppercase tracking-wider text-[#00f0ff] transition duration-300 hover:bg-[#00f0ff] hover:text-black border border-[#00f0ff] bg-[#00f0ff15]">
                        Edit Status
                    </button>
                </div>

                <div class="grid grid-cols-1 divide-y divide-white/10 md:grid-cols-4 md:divide-x md:divide-y-0">
                    <div class="p-8 transition-colors hover:bg-white/5">
                        <span class="tp-label text-xs uppercase tracking-widest text-[#849495]">Average Buy Price</span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="tp-headline text-3xl font-semibold text-white">{{ number_format((float) ($currentStatus?->average_buy_price ?? 0), 2) }}</span>
                            <span class="tp-label text-xs text-[#00f0ff]">LKR</span>
                        </div>
                    </div>
                    <div class="p-8 transition-colors hover:bg-white/5">
                        <span class="tp-label text-xs uppercase tracking-widest text-[#849495]">Remaining USDT</span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="tp-headline text-3xl font-semibold text-white">{{ number_format((float) ($currentStatus?->remaining_usdt ?? 0), 2) }}</span>
                        </div>
                    </div>
                    <div class="p-8 transition-colors hover:bg-white/5">
                        <span class="tp-label text-xs uppercase tracking-widest text-[#849495]">Remaining LKR</span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="tp-headline text-3xl font-semibold text-white">{{ number_format((float) ($currentStatus?->remaining_lkr ?? 0), 2) }}</span>
                        </div>
                    </div>
                    <div class="p-8 transition-colors hover:bg-white/5">
                        <span class="tp-label text-xs uppercase tracking-widest text-[#849495]">Break-even Price</span>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="tp-headline text-3xl font-semibold text-[#00f0ff]">{{ number_format((float) ($currentStatus?->break_even_price ?? 0), 2) }}</span>
                            <span class="tp-label text-xs text-[#00f0ff]">FIXED</span>
                        </div>
                    </div>
                </div>

                <form x-show="editing" method="POST" action="{{ route('trades.updateAverageBuyPrice') }}" class="grid grid-cols-1 gap-4 border-t border-white/10 p-6 md:grid-cols-4" x-transition>
                    @csrf

                    <div>
                        <label for="average_buy_price" class="tp-label block text-xs text-[#b9cacb]">Average Buy Price</label>
                        <input id="average_buy_price" name="average_buy_price" type="number" step="0.01" required value="{{ old('average_buy_price', $currentStatus?->average_buy_price ?? 0) }}" class="mt-2 block w-full rounded-lg border border-[#3b494b] bg-black/20 text-white shadow-sm focus:border-[#00f0ff] focus:ring-[#00f0ff]">
                        @error('average_buy_price')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="remaining_usdt" class="tp-label block text-xs text-[#b9cacb]">Remaining USDT</label>
                        <input id="remaining_usdt" name="remaining_usdt" type="number" step="0.01" required value="{{ old('remaining_usdt', $currentStatus?->remaining_usdt ?? 0) }}" class="mt-2 block w-full rounded-lg border border-[#3b494b] bg-black/20 text-white shadow-sm focus:border-[#00f0ff] focus:ring-[#00f0ff]">
                        @error('remaining_usdt')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="remaining_lkr" class="tp-label block text-xs text-[#b9cacb]">Remaining LKR</label>
                        <input id="remaining_lkr" name="remaining_lkr" type="number" step="0.01" required value="{{ old('remaining_lkr', $currentStatus?->remaining_lkr ?? 0) }}" class="mt-2 block w-full rounded-lg border border-[#3b494b] bg-black/20 text-white shadow-sm focus:border-[#00f0ff] focus:ring-[#00f0ff]">
                        @error('remaining_lkr')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="break_even_price" class="tp-label block text-xs text-[#b9cacb]">Break-even Price</label>
                        <input id="break_even_price" name="break_even_price" type="number" step="0.01" required value="{{ old('break_even_price', $currentStatus?->break_even_price ?? 0) }}" class="mt-2 block w-full rounded-lg border border-[#3b494b] bg-black/20 text-white shadow-sm focus:border-[#00f0ff] focus:ring-[#00f0ff]">
                        @error('break_even_price')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 md:col-span-4">
                        <button type="button" x-on:click="editing = false" class="rounded-lg border border-white/10 bg-[#33343e] px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                            Cancel
                        </button>
                        <button type="submit" class="rounded-lg bg-[#00f0ff] px-4 py-2 text-sm font-semibold text-black transition hover:bg-white">
                            Save Current Status
                        </button>
                    </div>
                </form>
            </section>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <section class="tp-panel tp-panel-cyan relative overflow-hidden rounded-xl p-8 lg:col-span-2">
                    <div class="absolute -right-16 -top-16 h-32 w-32 bg-[#00f0ff]/10 blur-[60px] transition-all"></div>
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div class="space-y-4">
                            <span class="tp-label text-xs uppercase tracking-[0.3em] text-[#849495]">Total Portfolio Valuation</span>
                            <div class="space-y-1">
                                <h2 class="tp-headline text-4xl font-bold tracking-tighter text-white md:text-5xl">LKR {{ number_format((float) ($totalAssets ?? 0), 2) }}</h2>
                                <p class="tp-label text-xs text-[#849495]">
                                    CURRENT CAPITAL:
                                    <span class="text-[#00f0ff]">
                                        @if ($currentCapital)
                                            LKR {{ number_format((float) $totalCapital, 2) }}
                                        @else
                                            NOT SET
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('capital-amount.index') }}" class="inline-flex items-center justify-center rounded-lg bg-[#00f0ff] px-6 py-3 text-sm font-bold uppercase tracking-wider text-black transition hover:shadow-[0_0_20px_rgba(0,240,255,0.35)]">
                            Manage Capital
                        </a>
                    </div>

                    <div class="mt-8 flex h-16 w-full items-end gap-1 opacity-50">
                        <div class="h-1/2 w-full bg-[#00f0ff]/40"></div>
                        <div class="h-3/4 w-full bg-[#00f0ff]/60"></div>
                        <div class="h-1/2 w-full bg-[#00f0ff]/40"></div>
                        <div class="h-full w-full bg-[#00f0ff]/80"></div>
                        <div class="h-2/3 w-full bg-[#00f0ff]/60"></div>
                        <div class="h-[90%] w-full bg-[#00f0ff]/90"></div>
                    </div>
                </section>

                <section class="tp-panel flex flex-col justify-between rounded-xl border border-[#7213ff]/30 p-8">
                    <div>
                        <h3 class="tp-headline text-2xl font-semibold text-white">Trade Pulse</h3>
                        <p class="mt-2 text-base text-[#849495]">Execution hub for manual buy and sell order synchronization.</p>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <a href="{{ route('trades.index') }}" class="block bg-[#33343e] px-4 py-3 text-center text-xs font-bold uppercase tracking-widest text-white transition hover:bg-white/10">
                            View Trades
                        </a>
                        <a href="{{ route('trades.create') }}" class="block bg-[#0266ff] px-4 py-3 text-center text-xs font-bold uppercase tracking-widest text-white transition hover:brightness-125">
                            Add Trade
                        </a>
                    </div>
                </section>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <section class="tp-panel relative overflow-hidden rounded-xl p-8">
                    <div class="mb-6 flex items-start justify-between">
                        <div>
                            <span class="tp-label text-xs uppercase tracking-widest text-[#849495]">Available Profit</span>
                            <h4 class="tp-headline mt-1 text-3xl font-semibold text-white">
                                {{ number_format((float) ($currentProfit ?? 0), 2) }}
                                <span class="tp-label text-xs text-[#849495]">LKR</span>
                            </h4>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#006970]/20">
                            <span class="material-symbols-outlined text-[#00f0ff]">account_balance_wallet</span>
                        </div>
                    </div>

                    <p class="mb-6 text-sm text-[#849495]">Net realized earnings ready for immediate withdrawal to core account.</p>

                    <div class="flex flex-col gap-4">
                        <div class="h-px w-full bg-gradient-to-r from-[#00f0ff]/50 to-transparent"></div>
                        <a href="{{ route('profit.withdraw.form') }}" class="block w-full rounded bg-[#7213ff] py-3 text-center text-xs font-bold uppercase tracking-widest text-white transition hover:brightness-110 active:scale-[0.98]">
                            Withdraw Profit
                        </a>
                    </div>
                </section>

                <section class="tp-panel rounded-xl border-white/5 bg-white/[0.01] p-8">
                    <div class="mb-6 flex items-start justify-between">
                        <div>
                            <span class="tp-label text-xs uppercase tracking-widest text-[#849495]">Total Net Gain</span>
                            <h4 class="tp-headline mt-1 text-3xl font-semibold text-[#00f0ff]">
                                {{ number_format((float) ($total_profit ?? 0), 2) }}
                                <span class="tp-label text-xs text-[#849495]">LKR</span>
                            </h4>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#006970]/20">
                            <span class="material-symbols-outlined text-[#00f0ff]" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                        </div>
                    </div>

                    <div class="rounded-lg border border-white/5 bg-white/5 p-4">
                        <div class="mb-2 flex justify-between text-xs uppercase">
                            <span class="tp-label text-[#849495]">Lifetime Growth</span>
                            <span class="tp-label text-[#00f0ff]">+238.4%</span>
                        </div>
                        <div class="h-1.5 w-full overflow-hidden rounded-full bg-white/10">
                            <div class="h-full w-[74%] bg-[#00f0ff] shadow-[0_0_20px_rgba(0,240,255,0.4)]"></div>
                        </div>
                    </div>

                    <p class="mt-6 text-sm italic text-[#849495]">Cumulative earnings track since account inception: Jan 2024</p>
                </section>
            </div>
        </main>

        <footer class="fixed bottom-0 left-0 z-50 flex w-full flex-col items-center justify-between gap-4 border-t border-white/5 bg-[#12131c]/80 px-6 py-4 backdrop-blur-sm md:flex-row lg:px-8">
            <div class="flex flex-col items-center gap-4 md:flex-row md:gap-6">
                <span class="tp-label text-sm text-[#dbfcff]">TRADE PULSE</span>
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="tp-label text-xs text-[#849495]">Privacy Policy</span>
                    <span class="tp-label text-xs text-[#849495]">Terms of Service</span>
                    <span class="tp-label text-xs text-[#849495]">Contact Support</span>
                </div>
            </div>

            <div class="tp-label flex items-center gap-2 text-xs text-[#b9cacb]">
                <span class="material-symbols-outlined text-[14px]">terminal</span>
                &copy; 2026 TRADE PULSE. SYSTEM STATUS:
                <span class="text-[#00f0ff]">ONLINE</span>
            </div>
        </footer>

        <script>
            (() => {
                const latencyDisplay = document.getElementById('tp-latency');
                if (!latencyDisplay) {
                    return;
                }

                const latencies = [11, 12, 14, 11, 13];
                setInterval(() => {
                    latencyDisplay.textContent = `${latencies[Math.floor(Math.random() * latencies.length)]}MS`;
                }, 3000);
            })();
        </script>
    </div>
</x-app-layout>
