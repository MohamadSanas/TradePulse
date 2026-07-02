<x-guest-layout>
    <div class="space-y-6">
        <div>
            <p class="tp-guest-label text-xs uppercase tracking-[0.2em] text-[#849495]">Secure Checkpoint</p>
            <h2 class="tp-guest-headline mt-2 text-3xl font-bold text-white">{{ __('Confirm Password') }}</h2>
            <p class="mt-3 text-sm text-[#b9cacb]">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="mt-2 block w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
