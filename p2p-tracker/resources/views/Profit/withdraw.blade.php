<x-app-layout>

    <div class="py-12">
        <div class="max-w-3xl mx-auto">

            <h2 class="text-2xl font-bold mb-6">
                Withdraw Profit
            </h2>

            <form method="POST" action="{{ route('profit.withdraw') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label>Amount</label>

                    <input
                        type="number"
                        name="amount"
                        step="0.01"
                        required
                        class="border rounded w-full p-2">
                </div>

                <div class="mb-4">
                    <label>Description</label>

                    <textarea
                        name="description"
                        class="border rounded w-full p-2"></textarea>
                </div>

                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded">

                    Withdraw Profit
                </button>

            </form>

        </div>
    </div>

</x-app-layout>