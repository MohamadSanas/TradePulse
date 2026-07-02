@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&family=JetBrains+Mono:wght@400;500&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --tp-bg: #12131c;
            --tp-bg-low: #1a1b24;
            --tp-bg-high: #1e1f29;
            --tp-bg-panel: #282933;
            --tp-text: #e3e1ef;
            --tp-muted: #b9cacb;
            --tp-outline: #849495;
            --tp-outline-variant: #3b494b;
            --tp-cyan: #00f0ff;
            --tp-cyan-soft: rgba(0, 240, 255, 0.14);
        }

        .tp-login-page {
            background:
                linear-gradient(to top right, #0d0e17, var(--tp-bg), var(--tp-bg-low));
            color: var(--tp-text);
            font-family: "Hanken Grotesk", sans-serif;
            overflow: hidden;
        }

        .tp-login-page .tp-headline {
            font-family: "Sora", sans-serif;
        }

        .tp-login-page .tp-label {
            font-family: "JetBrains Mono", monospace;
            letter-spacing: 0.08em;
        }

        .tp-grid {
            background-image: radial-gradient(rgba(0, 240, 255, 0.14) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .tp-scanline {
            background:
                linear-gradient(0deg, rgba(0, 0, 0, 0) 50%, rgba(0, 240, 255, 0.02) 50.5%),
                linear-gradient(90deg, rgba(0, 0, 0, 0) 50%, rgba(0, 240, 255, 0.02) 50.5%);
            background-size: 4px 4px;
        }

        .tp-glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(40px);
            border: 1px solid rgba(0, 240, 255, 0.15);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .tp-glass-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 240, 255, 0.45), transparent);
        }

        .tp-chamfer {
            clip-path: polygon(0 0, 92% 0, 100% 15%, 100% 100%, 0 100%);
        }

        .tp-float {
            animation: tp-float 6s ease-in-out infinite;
        }

        .tp-pulse {
            animation: tp-pulse 2s infinite;
        }

        @keyframes tp-float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        @keyframes tp-pulse {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }
    </style>
@endpush

<x-guest-layout>
    <div class="tp-login-page relative min-h-screen selection:bg-[#00f0ff] selection:text-[#00363a]">
        <div class="pointer-events-none fixed inset-0 z-0">
            <div class="tp-grid absolute inset-0 opacity-20"></div>
            <div class="tp-scanline absolute inset-0"></div>
            <div class="absolute left-8 top-8 h-32 w-32 border-l border-t border-[#00f0ff]/20"></div>
            <div class="absolute bottom-8 right-8 h-32 w-32 border-b border-r border-[#00f0ff]/20"></div>
        </div>

        <header class="fixed left-0 top-0 z-40 flex w-full items-center justify-between border-b border-white/10 bg-black/10 px-6 py-4 backdrop-blur-md md:px-10">
            <div class="tp-headline text-xl font-bold uppercase tracking-[0.2em] text-[#00f0ff]">
                Trade Pulse
            </div>

            <div class="flex items-center gap-5 md:gap-8">
                <nav class="hidden items-center gap-8 md:flex">
                    <span class="tp-label text-sm text-[#00f0ff] border-b-2 border-[#00f0ff] pb-1">Login</span>
                    <span class="tp-label text-sm text-[#b9cacb]">System Status</span>
                </nav>

                <div class="flex items-center gap-4 text-[#00f0ff]">
                    <span class="material-symbols-outlined">account_circle</span>
                    <span class="material-symbols-outlined">settings</span>
                </div>
            </div>
        </header>

        <main class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 pb-32 pt-28 md:px-10 md:pt-32">
            <div class="tp-float mb-10 flex flex-col items-center gap-4 md:mb-12">
                <img
                    src="{{ asset('images/trade_pulse_logo_white.png') }}"
                    alt="Trade Pulse Logo"
                    class="h-auto w-24 drop-shadow-[0_0_20px_rgba(0,240,255,0.4)] md:w-32"
                >
                <h1 class="tp-headline text-center text-4xl font-bold tracking-[-0.04em] text-white md:text-5xl">
                    TRADE PULSE
                </h1>
                <div class="flex items-center gap-2 rounded-full border border-[#00f0ff]/20 bg-[#00f0ff]/10 px-3 py-1">
                    <span class="tp-pulse h-2 w-2 rounded-full bg-[#00f0ff]"></span>
                    <span class="tp-label text-xs text-[#00f0ff]">ENCRYPTED GATEWAY ACTIVE</span>
                </div>
            </div>

            <div class="tp-glass-card w-full max-w-md rounded-xl p-8 md:p-10" x-data="{ showPassword: false }">
                <div class="mb-8 flex items-center justify-between border-b border-white/5 pb-4">
                    <h2 class="tp-headline text-2xl font-semibold text-white">Authentication</h2>
                    <span class="tp-label text-xs text-[#849495]">SECURE-V4</span>
                </div>

                <x-auth-session-status :status="session('status')" class="mb-6 rounded-lg border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="tp-label block text-sm text-[#b9cacb]">
                            EMAIL IDENTIFIER
                        </label>
                        <div class="group relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="node@tradepulse.io"
                                class="w-full border-0 border-b border-[#3b494b] bg-transparent px-0 py-3 text-lg text-white placeholder:text-[#3b494b] focus:border-[#00f0ff] focus:ring-0"
                            >
                            <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#00f0ff] shadow-[0_0_15px_rgba(0,240,255,0.35)] transition-all duration-500 group-focus-within:w-full"></div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="text-sm text-red-300" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="tp-label block text-sm text-[#b9cacb]">
                                ACCESS PROTOCOL
                            </label>
                        </div>
                        <div class="group relative">
                            <input
                                id="password"
                                name="password"
                                x-bind:type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full border-0 border-b border-[#3b494b] bg-transparent px-0 py-3 pr-12 text-lg text-white placeholder:text-[#3b494b] focus:border-[#00f0ff] focus:ring-0"
                            >
                            <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#00f0ff] shadow-[0_0_15px_rgba(0,240,255,0.35)] transition-all duration-500 group-focus-within:w-full"></div>
                            <button
                                type="button"
                                x-on:click="showPassword = !showPassword"
                                class="absolute right-0 top-1/2 -translate-y-1/2 text-[#849495] transition-colors hover:text-[#00f0ff]"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                            >
                                <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility' : 'visibility_off'"></span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="text-sm text-red-300" />
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <label for="remember_me" class="group flex cursor-pointer items-center gap-3">
                            <div class="relative flex h-5 w-5 items-center justify-center">
                                <input id="remember_me" name="remember" type="checkbox" class="peer sr-only">
                                <div class="h-full w-full rounded-sm border border-[#849495] transition-colors group-hover:border-[#00f0ff]"></div>
                                <div class="absolute h-3 w-3 bg-[#00f0ff] opacity-0 shadow-[0_0_12px_rgba(0,240,255,0.5)] transition-opacity peer-checked:opacity-100"></div>
                            </div>
                            <span class="tp-label text-xs text-[#b9cacb] transition-colors group-hover:text-white">REMEMBER SESSION</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="tp-label text-xs text-[#849495] underline decoration-transparent transition hover:text-[#00f0ff] hover:decoration-[#00f0ff]">
                                Recover
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="tp-chamfer flex w-full items-center justify-center gap-3 bg-[#00f0ff] px-6 py-4 text-lg font-bold uppercase tracking-[0.18em] text-[#12131c] transition duration-300 hover:bg-white hover:shadow-[0_0_25px_rgba(0,240,255,0.6)] active:scale-[0.98]">
                        Initialize Login
                        <span class="material-symbols-outlined">login</span>
                    </button>
                </form>

                <div class="mt-10 border-t border-white/5 pt-6 text-center">
                    <p class="tp-label text-xs text-[#849495]">
                        UNAUTHORIZED ACCESS IS PROHIBITED BY PROTOCOL 84-A
                    </p>
                </div>
            </div>

            @if (Route::has('register'))
                <div class="mt-8 text-center">
                    <p class="text-base text-[#b9cacb]">
                        New network participant?
                        <a href="{{ route('register') }}" class="ml-1 font-bold text-[#00f0ff] hover:underline">Create Account</a>
                    </p>
                </div>
            @endif
        </main>

        <footer class="fixed bottom-0 left-0 z-40 flex w-full flex-col items-center justify-between gap-4 border-t border-white/5 bg-black/10 px-6 py-6 backdrop-blur-sm md:flex-row md:px-10">
            <div class="flex items-center gap-2 opacity-80 transition-opacity hover:opacity-100">
                <span class="tp-label text-sm text-[#dbfcff]">TRADE PULSE</span>
                <span class="tp-label text-xs text-[#b9cacb]">&copy; 2026 TRADE PULSE. SYSTEM STATUS: ONLINE</span>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6">
                <span class="tp-label text-xs text-[#849495]">Privacy Policy</span>
                <span class="tp-label text-xs text-[#849495]">Terms of Service</span>
                <a href="{{ route('support.contact') }}" class="tp-label text-xs text-[#849495] transition hover:text-[#00f0ff]">Contact Support</a>
            </div>
        </footer>
    </div>
</x-guest-layout>
