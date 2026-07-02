<x-app-layout>
    <div class="mx-auto max-w-3xl space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Profit Transfer</span>
            <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">Withdraw Profit</h1>
            <p class="mt-3 text-base text-[#b9cacb]">Move realized profit out of the active ledger while keeping the same dashboard command style.</p>
        </section>

        <section class="tp-panel rounded-2xl p-6">
            <form method="POST" action="{{ route('profit.withdraw') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="amount" class="tp-label block text-xs text-[#b9cacb]">Amount</label>
                    <input id="amount" type="number" name="amount" step="0.01" required class="tp-form-input mt-2">
                </div>

                <div>
                    <label for="description" class="tp-label block text-xs text-[#b9cacb]">Description</label>
                    <textarea id="description" name="description" rows="4" class="tp-form-textarea mt-2"></textarea>
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('dashboard') }}" class="tp-btn-secondary">Cancel</a>
                    <button type="submit" class="tp-btn-primary">Withdraw Profit</button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
