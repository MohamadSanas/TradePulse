<x-app-layout>
    <div class="space-y-6">
        <section class="tp-panel rounded-2xl p-6 sm:p-8">
            <span class="tp-label text-xs uppercase tracking-[0.2em] text-[#849495]">Operator Settings</span>
            <h1 class="tp-headline mt-2 text-4xl font-bold tracking-[-0.04em] text-white">{{ __('Profile') }}</h1>
            <p class="mt-3 max-w-2xl text-base text-[#b9cacb]">Manage your identity, credentials, and account lifecycle from the same dashboard system used across TradePulse.</p>
        </section>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="tp-panel rounded-2xl p-4 sm:p-8 xl:col-span-2">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="tp-panel rounded-2xl p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="tp-panel rounded-2xl p-4 sm:p-8">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
