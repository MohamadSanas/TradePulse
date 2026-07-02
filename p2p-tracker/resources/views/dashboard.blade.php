<x-app-layout>
    <div class="space-y-6">
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

                <button x-show="!editing" type="button" x-on:click="editing = true" class="tp-label border border-[#00f0ff] bg-[#00f0ff15] px-6 py-2 text-sm font-bold uppercase tracking-wider text-[#00f0ff] transition duration-300 hover:bg-[#00f0ff] hover:text-black">
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
                    <input id="average_buy_price" name="average_buy_price" type="number" step="0.01" required value="{{ old('average_buy_price', $currentStatus?->average_buy_price ?? 0) }}" class="tp-form-input mt-2">
                    @error('average_buy_price')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="remaining_usdt" class="tp-label block text-xs text-[#b9cacb]">Remaining USDT</label>
                    <input id="remaining_usdt" name="remaining_usdt" type="number" step="0.01" required value="{{ old('remaining_usdt', $currentStatus?->remaining_usdt ?? 0) }}" class="tp-form-input mt-2">
                    @error('remaining_usdt')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="remaining_lkr" class="tp-label block text-xs text-[#b9cacb]">Remaining LKR</label>
                    <input id="remaining_lkr" name="remaining_lkr" type="number" step="0.01" required value="{{ old('remaining_lkr', $currentStatus?->remaining_lkr ?? 0) }}" class="tp-form-input mt-2">
                    @error('remaining_lkr')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="break_even_price" class="tp-label block text-xs text-[#b9cacb]">Break-even Price</label>
                    <input id="break_even_price" name="break_even_price" type="number" step="0.01" required value="{{ old('break_even_price', $currentStatus?->break_even_price ?? 0) }}" class="tp-form-input mt-2">
                    @error('break_even_price')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 md:col-span-4">
                    <button type="button" x-on:click="editing = false" class="tp-btn-secondary">Cancel</button>
                    <button type="submit" class="tp-btn-primary">Save Current Status</button>
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
    </div>

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
</x-app-layout>
