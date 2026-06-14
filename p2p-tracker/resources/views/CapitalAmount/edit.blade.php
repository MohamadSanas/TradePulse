<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-2xl font-bold mb-6">
                Edit Capital Amount
            </h2>

            <form method="POST"
                  action="{{ route('capital-amount.update', $capitalAmount->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label>Capital</label>
                    <input
                        type="number"
                        step="0.01"
                        name="capital"
                        value="{{ $capitalAmount->capital }}"
                        class="border rounded w-full p-2">
                </div>

                <div class="mb-4">
                    <label>Description</label>
                    <textarea
                        name="description"
                        class="border rounded w-full p-2">{{ $capitalAmount->description }}</textarea>
                </div>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>

            </form>
        </div>
    </div>
</x-app-layout>