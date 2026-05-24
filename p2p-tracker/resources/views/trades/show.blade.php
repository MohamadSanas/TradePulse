<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Trade Details') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Transaction') }} #{{ $trade->id }}
                </p>
            </div>

            <a href="{{ route('trades.edit', $trade) }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-indigo-500 focus:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-700 dark:focus:ring-offset-gray-800">
                {{ __('Edit Trade') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm dark:bg-gray-800">
                <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-700">
                    <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                        {{ __(ucfirst($trade->type)) }}
                    </span>
                </div>

                <dl class="grid grid-cols-1 divide-y divide-gray-100 dark:divide-gray-700 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
                    <div class="px-6 py-5">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('USDT Amount') }}</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format((float) $trade->amount_usdt, 2) }}</dd>
                    </div>
                    <div class="px-6 py-5">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total LKR') }}</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format((float) $trade->total_lkr, 2) }}</dd>
                    </div>
                </dl>

                <dl class="grid grid-cols-1 gap-0 border-t border-gray-100 dark:border-gray-700 sm:grid-cols-2">
                    <div class="px-6 py-5">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Bank Fee') }}</dt>
                        <dd class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ number_format((float) ($trade->bank_fee ?? 0), 2) }}</dd>
                    </div>
                    <div class="px-6 py-5">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('App Fee') }}</dt>
                        <dd class="mt-1 text-base text-gray-900 dark:text-gray-100">{{ number_format((float) ($trade->fee ?? 0), 2) }}%</dd>
                    </div>
                </dl>

                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-6 py-5 dark:border-gray-700 sm:flex-row sm:justify-end">
                    <a href="{{ route('trades.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        {{ __('Back to Trades') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
