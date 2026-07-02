<x-app-layout>
    <div class="mx-auto max-w-3xl space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Support Channel</span>
            <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">Contact Us</h1>
            <p class="mt-3 text-base text-[#b9cacb]">Have a question or need help? Send us a message and it will be delivered to the TradePulse support inbox.</p>
        </section>

        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('support.contact.submit') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="tp-label block text-xs text-[#b9cacb]">Full Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        class="tp-form-input mt-2"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="tp-label block text-xs text-[#b9cacb]">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        class="tp-form-input mt-2"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="tp-label block text-xs text-[#b9cacb]">Subject</label>
                    <input
                        id="subject"
                        name="subject"
                        type="text"
                        value="{{ old('subject') }}"
                        required
                        class="tp-form-input mt-2"
                    >
                    @error('subject')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="tp-label block text-xs text-[#b9cacb]">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        class="tp-form-textarea mt-2"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('support.contact') }}" class="tp-btn-secondary">Reset</a>
                    <button type="submit" class="tp-btn-primary">Send Message</button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
