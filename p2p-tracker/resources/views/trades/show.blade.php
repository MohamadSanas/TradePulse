<x-app-layout>
    <div class="mx-auto max-w-4xl space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Trade Detail Record</span>
                    <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">{{ __('Trade Details') }}</h1>
                    <p class="mt-2 text-base text-[#b9cacb]">{{ __('Transaction') }} #{{ $trade->id }}</p>
                </div>

                <a href="{{ route('trades.edit', $trade) }}" class="tp-btn-primary">{{ __('Edit Trade') }}</a>
            </div>
        </section>

        <section class="tp-panel overflow-hidden rounded-2xl">
            <div class="border-b border-white/10 px-6 py-5">
                <span class="tp-label inline-flex rounded-full border border-[#00f0ff]/20 bg-[#00f0ff]/10 px-3 py-1 text-xs text-[#00f0ff]">
                    {{ __(ucfirst($trade->type)) }}
                </span>
            </div>

            <dl class="grid grid-cols-1 divide-y divide-white/10 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
                <div class="px-6 py-5">
                    <dt class="tp-label text-xs text-[#849495]">{{ __('USDT Amount') }}</dt>
                    <dd class="tp-headline mt-2 text-3xl font-semibold text-white">{{ number_format((float) $trade->amount_usdt, 2) }}</dd>
                </div>
                <div class="px-6 py-5">
                    <dt class="tp-label text-xs text-[#849495]">{{ __('Total LKR') }}</dt>
                    <dd class="tp-headline mt-2 text-3xl font-semibold text-white">{{ number_format((float) $trade->total_lkr, 2) }}</dd>
                </div>
            </dl>

            <dl class="grid grid-cols-1 gap-0 border-t border-white/10 sm:grid-cols-2">
                <div class="px-6 py-5">
                    <dt class="tp-label text-xs text-[#849495]">{{ __('Bank Fee') }}</dt>
                    <dd class="mt-2 text-base text-[#b9cacb]">{{ number_format((float) ($trade->bank_fee ?? 0), 2) }}</dd>
                </div>
                <div class="px-6 py-5">
                    <dt class="tp-label text-xs text-[#849495]">{{ __('App Fee') }}</dt>
                    <dd class="mt-2 text-base text-[#b9cacb]">{{ number_format((float) ($trade->fee ?? 0), 2) }}%</dd>
                </div>
            </dl>

            <div class="flex flex-col-reverse gap-3 border-t border-white/10 px-6 py-5 sm:flex-row sm:justify-end">
                <a href="{{ route('trades.index') }}" class="tp-btn-secondary">{{ __('Back to Trades') }}</a>
            </div>
        </section>
    </div>
</x-app-layout>
