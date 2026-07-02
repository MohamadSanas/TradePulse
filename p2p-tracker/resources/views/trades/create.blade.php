<x-app-layout>
    <div class="mx-auto max-w-3xl space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Trade Intake</span>
            <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">{{ __('Add Trade') }}</h1>
            <p class="mt-3 text-base text-[#b9cacb]">{{ __('Record a buy or sell transaction with fees and total value.') }}</p>
        </section>

        <section class="tp-panel rounded-2xl p-6">
            <form method="POST" action="{{ route('trades.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="type" class="tp-label block text-xs text-[#b9cacb]">{{ __('Type') }}</label>
                    <select id="type" name="type" class="tp-form-select mt-2">
                        <option value="buy" @selected(old('type') === 'buy')>{{ __('Buy') }}</option>
                        <option value="sell" @selected(old('type') === 'sell')>{{ __('Sell') }}</option>
                    </select>
                    @error('type')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="amount_usdt" class="tp-label block text-xs text-[#b9cacb]">{{ __('USDT Amount') }}</label>
                        <input id="amount_usdt" name="amount_usdt" type="number" step="0.01" value="{{ old('amount_usdt') }}" class="tp-form-input mt-2">
                        @error('amount_usdt')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_lkr" class="tp-label block text-xs text-[#b9cacb]">{{ __('Total LKR') }}</label>
                        <input id="total_lkr" name="total_lkr" type="number" step="0.01" value="{{ old('total_lkr') }}" class="tp-form-input mt-2">
                        @error('total_lkr')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bank_fee" class="tp-label block text-xs text-[#b9cacb]">{{ __('Bank Fee') }}</label>
                        <input id="bank_fee" name="bank_fee" type="number" step="0.01" value="{{ old('bank_fee') }}" class="tp-form-input mt-2">
                        @error('bank_fee')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fee" class="tp-label block text-xs text-[#b9cacb]">{{ __('App Fee (%)') }}</label>
                        <input id="fee" name="fee" type="number" step="0.01" value="{{ old('fee') }}" class="tp-form-input mt-2">
                        @error('fee')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-white/10 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('trades.index') }}" class="tp-btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="tp-btn-primary">{{ __('Save Trade') }}</button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
