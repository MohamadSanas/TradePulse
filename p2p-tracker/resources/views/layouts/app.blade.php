<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400;500;700&display=swap" rel="stylesheet">
        <style>
            :root {
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
                --tp-danger: #ff6b7a;
            }

            .tp-app-shell {
                min-height: 100vh;
                background-color: var(--tp-surface);
                background-image:
                    radial-gradient(circle at 20% 0%, rgba(0, 240, 255, 0.08) 0%, transparent 28%),
                    radial-gradient(circle at 100% 100%, rgba(114, 19, 255, 0.08) 0%, transparent 34%);
                color: var(--tp-text);
                font-family: "Hanken Grotesk", sans-serif;
            }

            .tp-grid {
                background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
                background-size: 24px 24px;
            }

            .tp-headline {
                font-family: "Sora", sans-serif;
            }

            .tp-label {
                font-family: "JetBrains Mono", monospace;
                letter-spacing: 0.08em;
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

            .tp-active-dot {
                width: 8px;
                height: 8px;
                background: var(--tp-cyan);
                border-radius: 9999px;
                box-shadow: 0 0 10px var(--tp-cyan);
                animation: tp-pulse 2s infinite;
            }

            .tp-scanline {
                width: 100%;
                height: 2px;
                background: linear-gradient(to right, transparent, rgba(0, 240, 255, 0.1), transparent);
                position: absolute;
                animation: tp-scan 4s linear infinite;
            }

            .tp-form-input,
            .tp-form-select,
            .tp-form-textarea {
                width: 100%;
                border-radius: 0.75rem;
                border: 1px solid var(--tp-outline-variant);
                background: rgba(0, 0, 0, 0.2);
                color: #fff;
                box-shadow: none;
            }

            .tp-form-input::placeholder,
            .tp-form-textarea::placeholder {
                color: #64748b;
            }

            .tp-form-input:focus,
            .tp-form-select:focus,
            .tp-form-textarea:focus {
                border-color: var(--tp-cyan);
                box-shadow: 0 0 0 1px var(--tp-cyan);
                outline: none;
            }

            .tp-btn-primary,
            .tp-btn-secondary,
            .tp-btn-danger {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                border-radius: 0.75rem;
                padding: 0.75rem 1.25rem;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                transition: all 200ms ease;
            }

            .tp-btn-primary {
                border: 1px solid rgba(0, 240, 255, 0.35);
                background: var(--tp-cyan);
                color: #12131c;
            }

            .tp-btn-primary:hover {
                background: #fff;
                box-shadow: 0 0 24px rgba(0, 240, 255, 0.3);
            }

            .tp-btn-secondary {
                border: 1px solid rgba(255, 255, 255, 0.08);
                background: rgba(255, 255, 255, 0.05);
                color: #fff;
            }

            .tp-btn-secondary:hover {
                background: rgba(255, 255, 255, 0.1);
            }

            .tp-btn-danger {
                border: 1px solid rgba(255, 107, 122, 0.3);
                background: rgba(255, 107, 122, 0.12);
                color: #ffb4ab;
            }

            .tp-btn-danger:hover {
                background: rgba(255, 107, 122, 0.2);
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
        @stack('head')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-black antialiased">
        <div class="tp-app-shell relative overflow-hidden">
            <div class="tp-grid pointer-events-none fixed inset-0 opacity-20"></div>

            <nav x-data="{ open: false }" class="fixed left-0 top-0 z-50 w-full border-b border-white/10 bg-black/10 backdrop-blur-md">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                    <div class="flex items-center gap-8">
                        <a href="{{ route('dashboard') }}" class="tp-headline flex items-center gap-2 text-xl font-bold uppercase tracking-[0.18em] text-[#00f0ff]">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">pause</span>
                            Trade Pulse
                        </a>

                        <div class="hidden gap-6 md:flex">
                            <a href="{{ route('dashboard') }}" class="tp-label py-1 text-sm transition-colors duration-300 hover:text-[#00f0ff] {{ request()->routeIs('dashboard') ? 'border-b-2 border-[#00f0ff] text-[#00f0ff]' : 'text-[#b9cacb]' }}">Dashboard</a>
                            <a href="{{ route('trades.index') }}" class="tp-label py-1 text-sm transition-colors duration-300 hover:text-[#00f0ff] {{ request()->routeIs('trades.*') ? 'border-b-2 border-[#00f0ff] text-[#00f0ff]' : 'text-[#b9cacb]' }}">Trades</a>
                            <a href="{{ route('capital-amount.index') }}" class="tp-label py-1 text-sm transition-colors duration-300 hover:text-[#00f0ff] {{ request()->routeIs('capital-amount.*') ? 'border-b-2 border-[#00f0ff] text-[#00f0ff]' : 'text-[#b9cacb]' }}">Capital</a>
                            <a href="{{ route('profit.withdraw.form') }}" class="tp-label py-1 text-sm transition-colors duration-300 hover:text-[#00f0ff] {{ request()->routeIs('profit.withdraw.form') ? 'border-b-2 border-[#00f0ff] text-[#00f0ff]' : 'text-[#b9cacb]' }}">Profit</a>
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

                    <button x-on:click="open = !open" class="text-[#b9cacb] md:hidden">
                        <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'"></span>
                    </button>
                </div>

                <div x-show="open" x-transition class="border-t border-white/10 px-6 py-4 md:hidden">
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('dashboard') }}" class="tp-label text-sm {{ request()->routeIs('dashboard') ? 'text-[#00f0ff]' : 'text-[#b9cacb]' }}">Dashboard</a>
                        <a href="{{ route('trades.index') }}" class="tp-label text-sm {{ request()->routeIs('trades.*') ? 'text-[#00f0ff]' : 'text-[#b9cacb]' }}">Trades</a>
                        <a href="{{ route('capital-amount.index') }}" class="tp-label text-sm {{ request()->routeIs('capital-amount.*') ? 'text-[#00f0ff]' : 'text-[#b9cacb]' }}">Capital</a>
                        <a href="{{ route('profit.withdraw.form') }}" class="tp-label text-sm {{ request()->routeIs('profit.withdraw.form') ? 'text-[#00f0ff]' : 'text-[#b9cacb]' }}">Profit</a>
                        <a href="{{ route('profile.edit') }}" class="tp-label text-sm text-[#b9cacb]">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="tp-label text-left text-sm text-[#ffb4ab]">Log Out</button>
                        </form>
                    </div>
                </div>
            </nav>

            <main class="relative z-10 mx-auto max-w-7xl space-y-8 px-6 pb-32 pt-24 lg:px-8">
                @isset($header)
                    <header class="tp-panel rounded-2xl px-6 py-5">
                        {{ $header }}
                    </header>
                @endisset

                {{ $slot }}
            </main>

            <footer class="fixed bottom-0 left-0 z-50 flex w-full flex-col items-center justify-between gap-4 border-t border-white/5 bg-[#12131c]/80 px-6 py-4 backdrop-blur-sm md:flex-row lg:px-8">
                <div class="flex flex-col items-center gap-4 md:flex-row md:gap-6">
                    <span class="tp-label text-sm text-[#dbfcff]">TRADE PULSE</span>
                    <div class="flex flex-wrap justify-center gap-4">
                        <span class="tp-label text-xs text-[#849495]">Privacy Policy</span>
                        <span class="tp-label text-xs text-[#849495]">Terms of Service</span>
                        <a href="{{ route('support.contact') }}" class="tp-label text-xs text-[#849495] transition hover:text-[#00f0ff]">Contact Support</a>
                    </div>
                </div>

                <div class="tp-label flex items-center gap-2 text-xs text-[#b9cacb]">
                    <span class="material-symbols-outlined text-[14px]">terminal</span>
                    &copy; 2026 TRADE PULSE. SYSTEM STATUS:
                    <span class="text-[#00f0ff]">ONLINE</span>
                </div>
            </footer>
        </div>
    </body>
</html>
