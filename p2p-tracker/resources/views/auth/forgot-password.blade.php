<x-guest-layout>
    <div class="space-y-6">
        <div>
            <p class="tp-guest-label text-xs uppercase tracking-[0.2em] text-[#849495]">Recovery Protocol</p>
            <h2 class="tp-guest-headline mt-2 text-3xl font-bold text-white">{{ __('Forgot Password') }}</h2>
            <p class="mt-3 text-sm text-[#b9cacb]">
                {{ __('Forgot your password? No problem. Enter your email address and we will email you a reset link so you can choose a new one.') }}
            </p>
        </div>

        <x-auth-session-status :status="session('status')" class="rounded-lg border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
