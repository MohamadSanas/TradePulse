@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&family=JetBrains+Mono:wght@400;500&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --tp-bg: #12131c;
            --tp-bg-low: #1a1b24;
            --tp-text: #e3e1ef;
            --tp-muted: #b9cacb;
            --tp-outline: #849495;
            --tp-outline-variant: #3b494b;
            --tp-cyan: #00f0ff;
        }

        .tp-register-page {
            background: linear-gradient(to top right, #0d0e17, var(--tp-bg), var(--tp-bg-low));
            color: var(--tp-text);
            font-family: "Hanken Grotesk", sans-serif;
            overflow: hidden;
        }

        .tp-register-page .tp-headline {
            font-family: "Sora", sans-serif;
        }

        .tp-register-page .tp-label {
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
    <div class="tp-register-page relative min-h-screen selection:bg-[#00f0ff] selection:text-[#00363a]">
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
                    <span class="tp-label text-sm text-[#b9cacb]">Login</span>
                    <span class="tp-label border-b-2 border-[#00f0ff] pb-1 text-sm text-[#00f0ff]">Register</span>
                </nav>

                <div class="flex items-center gap-4 text-[#00f0ff]">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="material-symbols-outlined">shield_lock</span>
                </div>
            </div>
        </header>

        <main class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 pb-32 pt-28 md:px-10 md:pt-32">
            <div class="tp-float mb-8 flex flex-col items-center gap-4 md:mb-10">
                <img
                    src="{{ asset('images/trade_pulse_logo_white.png') }}"
                    alt="Trade Pulse Logo"
                    class="h-auto w-24 drop-shadow-[0_0_20px_rgba(0,240,255,0.4)] md:w-32"
                >
                <h1 class="tp-headline text-center text-4xl font-bold tracking-[-0.04em] text-white md:text-5xl">
                    JOIN TRADE PULSE
                </h1>
                <div class="flex items-center gap-2 rounded-full border border-[#00f0ff]/20 bg-[#00f0ff]/10 px-3 py-1">
                    <span class="tp-pulse h-2 w-2 rounded-full bg-[#00f0ff]"></span>
                    <span class="tp-label text-xs text-[#00f0ff]">SECURE ONBOARDING CHANNEL</span>
                </div>
            </div>

            <div class="tp-glass-card w-full max-w-xl rounded-xl p-8 md:p-10" x-data="{ showPassword: false, showPasswordConfirmation: false }">
                <div class="mb-8 flex items-center justify-between border-b border-white/5 pb-4">
                    <h2 class="tp-headline text-2xl font-semibold text-white">Create Account</h2>
                    <span class="tp-label text-xs text-[#849495]">ACCESS-NODE</span>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="name" class="tp-label block text-sm text-[#b9cacb]">
                            OPERATOR NAME
                        </label>
                        <div class="group relative">
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Your full name"
                                class="w-full border-0 border-b border-[#3b494b] bg-transparent px-0 py-3 text-lg text-white placeholder:text-[#3b494b] focus:border-[#00f0ff] focus:ring-0"
                            >
                            <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#00f0ff] shadow-[0_0_15px_rgba(0,240,255,0.35)] transition-all duration-500 group-focus-within:w-full"></div>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="text-sm text-red-300" />
                    </div>

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
                                autocomplete="username"
                                placeholder="node@tradepulse.io"
                                class="w-full border-0 border-b border-[#3b494b] bg-transparent px-0 py-3 text-lg text-white placeholder:text-[#3b494b] focus:border-[#00f0ff] focus:ring-0"
                            >
                            <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#00f0ff] shadow-[0_0_15px_rgba(0,240,255,0.35)] transition-all duration-500 group-focus-within:w-full"></div>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="text-sm text-red-300" />
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label for="password" class="tp-label block text-sm text-[#b9cacb]">
                                ACCESS PROTOCOL
                            </label>
                            <div class="group relative">
                                <input
                                    id="password"
                                    name="password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Create password"
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

                        <div class="space-y-2">
                            <label for="password_confirmation" class="tp-label block text-sm text-[#b9cacb]">
                                CONFIRM PROTOCOL
                            </label>
                            <div class="group relative">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Confirm password"
                                    class="w-full border-0 border-b border-[#3b494b] bg-transparent px-0 py-3 pr-12 text-lg text-white placeholder:text-[#3b494b] focus:border-[#00f0ff] focus:ring-0"
                                >
                                <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-[#00f0ff] shadow-[0_0_15px_rgba(0,240,255,0.35)] transition-all duration-500 group-focus-within:w-full"></div>
                                <button
                                    type="button"
                                    x-on:click="showPasswordConfirmation = !showPasswordConfirmation"
                                    class="absolute right-0 top-1/2 -translate-y-1/2 text-[#849495] transition-colors hover:text-[#00f0ff]"
                                    :aria-label="showPasswordConfirmation ? 'Hide password confirmation' : 'Show password confirmation'"
                                >
                                    <span class="material-symbols-outlined text-[20px]" x-text="showPasswordConfirmation ? 'visibility' : 'visibility_off'"></span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="text-sm text-red-300" />
                        </div>
                    </div>

                    <button type="submit" class="tp-chamfer flex w-full items-center justify-center gap-3 bg-[#00f0ff] px-6 py-4 text-lg font-bold uppercase tracking-[0.18em] text-[#12131c] transition duration-300 hover:bg-white hover:shadow-[0_0_25px_rgba(0,240,255,0.6)] active:scale-[0.98]">
                        Create Account
                        <span class="material-symbols-outlined">person_add</span>
                    </button>
                </form>

                <div class="mt-8 border-t border-white/5 pt-6 text-center">
                    <p class="tp-label text-xs text-[#849495]">
                        ACCOUNT CREATION IS MONITORED UNDER PROTOCOL 84-A
                    </p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-base text-[#b9cacb]">
                    Already registered?
                    <a href="{{ route('login') }}" class="ml-1 font-bold text-[#00f0ff] hover:underline">Sign In</a>
                </p>
            </div>
        </main>

        <footer class="fixed bottom-0 left-0 z-40 flex w-full flex-col items-center justify-between gap-4 border-t border-white/5 bg-black/10 px-6 py-6 backdrop-blur-sm md:flex-row md:px-10">
            <div class="flex items-center gap-2 opacity-80 transition-opacity hover:opacity-100">
                <span class="tp-label text-sm text-[#dbfcff]">TRADE PULSE</span>
                <span class="tp-label text-xs text-[#b9cacb]">&copy; 2026 TRADE PULSE. SYSTEM STATUS: ONLINE</span>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6">
                <span class="tp-label text-xs text-[#849495]">Privacy Policy</span>
                <span class="tp-label text-xs text-[#849495]">Terms of Service</span>
                <span class="tp-label text-xs text-[#849495]">Contact Support</span>
            </div>
        </footer>
    </div>
</x-guest-layout>
