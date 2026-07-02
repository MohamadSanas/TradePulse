<x-app-layout>
    <div class="space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Liquidity Registry</span>
                    <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">Capital Amount</h1>
                    <p class="mt-3 max-w-2xl text-base text-[#b9cacb]">Track each capital source used for your trading account and manage funding records with the same command-center flow.</p>
                </div>

                <a href="{{ route('dashboard') }}" class="tp-btn-secondary">Dashboard</a>
            </div>
        </section>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="tp-panel rounded-2xl p-6">
                <p class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">{{ __('Total Capital') }}</p>
                <p class="tp-headline mt-3 text-3xl font-semibold text-white">LKR {{ number_format((float) ($totalCapital ?? 0), 2) }}</p>
                <p class="mt-3 text-sm text-[#b9cacb]">
                    @if ($currentCapital)
                        {{ __('Latest entry') }}: LKR {{ number_format((float) $currentCapital->capital, 2) }}
                    @else
                        {{ __('No capital amount has been saved yet.') }}
                    @endif
                </p>
            </div>

            <div class="tp-panel rounded-2xl p-6 lg:col-span-2">
                <div>
                    <h2 class="tp-headline text-2xl font-semibold text-white">{{ __('Set Capital Amount') }}</h2>
                    <p class="mt-2 text-sm text-[#849495]">{{ __('Add a separate entry for own money, lent money, investment funds, or any other source.') }}</p>
                </div>

                <form method="POST" action="{{ route('capital-amount.set') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="capital" class="tp-label block text-xs text-[#b9cacb]">{{ __('Capital Amount') }}</label>
                        <div class="mt-2 flex overflow-hidden rounded-xl border border-[#3b494b]">
                            <span class="tp-label inline-flex items-center bg-black/20 px-4 text-xs text-[#849495]">LKR</span>
                            <input id="capital" name="capital" type="number" min="0" step="0.01" required value="{{ old('capital') }}" class="tp-form-input rounded-none border-0">
                        </div>
                        @error('capital')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="tp-label block text-xs text-[#b9cacb]">{{ __('Description') }}</label>
                        <textarea id="description" name="description" rows="4" class="tp-form-textarea mt-2" placeholder="{{ __('Example: Own money, lent from friend, investor funding, bank transfer') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <button type="submit" class="tp-btn-primary">{{ __('Add Capital Entry') }}</button>
                        <a href="{{ route('trades.index') }}" class="tp-btn-secondary">{{ __('View Trades') }}</a>
                    </div>
                </form>
            </div>
        </section>

        <section class="tp-panel overflow-hidden rounded-2xl">
            <div class="border-b border-white/10 px-6 py-5">
                <h2 class="tp-headline text-2xl font-semibold text-white">{{ __('Capital Records') }}</h2>
                <p class="mt-1 text-sm text-[#849495]">{{ __('Each source is saved as a separate capital entry.') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]">{{ __('Capital') }}</th>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]">{{ __('Description') }}</th>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]">{{ __('Updated') }}</th>
                            <th class="tp-label px-6 py-4 text-left text-xs text-[#849495]">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse ($capitalAmounts as $capitalAmount)
                            <tr class="transition hover:bg-white/5">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-white">
                                    LKR {{ number_format((float) $capitalAmount->capital, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-[#b9cacb]">
                                    {{ $capitalAmount->description ?: __('No description') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[#849495]">
                                    {{ $capitalAmount->updated_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="{{ route('capital-amount.edit', $capitalAmount->id) }}" class="text-[#00f0ff] transition hover:text-white">{{ __('Edit') }}</a>
                                        <form action="{{ route('capital-amount.destroy', $capitalAmount->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-300 transition hover:text-red-200">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-[#849495]">
                                    {{ __('No capital amount records found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
