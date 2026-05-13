<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- display current average buy price and current average sell price and profit/loss --}}

    <div class="current_status">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">{{ __('Current Status') }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Here you can see your current average buy price, average sell price, and profit/loss.') }}
                    </p>

                    @if (session('success'))
                        <div class="mt-4 rounded bg-green-100 px-4 py-2 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="mt-4 w-full border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Average Buy Price</th>
                                <th class="border border-gray-300 px-4 py-2">Remaining USDT</th>
                                <th class="border border-gray-300 px-4 py-2">Remaining LKR</th>
                                <th class="border border-gray-300 px-4 py-2">Break-even Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($current_status as $status)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $status->average_buy_price }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $status->remaining_usdt }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $status->remaining_lkr }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $status->break_even_price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-center">
                                        No current status records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div x-data="{ editing: {{ $errors->any() ? 'true' : 'false' }} }" class="mt-4">
                        <div x-show="!editing">
                            <button type="button" x-on:click="editing = true" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                {{ __('Edit Current Status') }}
                            </button>
                        </div>

                        <form x-show="editing" method="POST" action="{{ route('trades.updateAverageBuyPrice') }}" class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-4">
                            @csrf

                            <div>
                                <label for="average_buy_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Average Buy Price') }}
                                </label>
                                <input id="average_buy_price" name="average_buy_price" type="number" step="0.01" required
                                    value="{{ old('average_buy_price', $currentStatus?->average_buy_price ?? 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('average_buy_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="remaining_usdt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Remaining USDT') }}
                                </label>
                                <input id="remaining_usdt" name="remaining_usdt" type="number" step="0.01" required
                                    value="{{ old('remaining_usdt', $currentStatus?->remaining_usdt ?? 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('remaining_usdt')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="remaining_lkr" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Remaining LKR') }}
                                </label>
                                <input id="remaining_lkr" name="remaining_lkr" type="number" step="0.01" required
                                    value="{{ old('remaining_lkr', $currentStatus?->remaining_lkr ?? 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('remaining_lkr')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="break_even_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Break-even Price') }}
                                </label>
                                <input id="break_even_price" name="break_even_price" type="number" step="0.01" required
                                    value="{{ old('break_even_price', $currentStatus?->break_even_price ?? 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('break_even_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-3 md:col-span-4">
                                <button type="button" x-on:click="editing = false" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    {{ __('Cancel') }}
                                </button>

                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    {{ __('Save Current Status') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-left sm:justify-between gap-4">
                        <div>
                            <h4>Current profit: </h4>
                            <input type="text" value="{{ $today_profit ?? 0 }}" readonly class="mt-1 block w-full rounded-md border-gray-300 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold">{{ __('Trade Pulse') }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Manage your buy and sell trades from here.') }}
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('trades.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('View Trades') }}
                            </a>

                            <a href="{{ route('trades.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Add Trade') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
