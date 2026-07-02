<x-guest-layout>
    <div class="space-y-6">
        <div>
            <p class="tp-guest-label text-xs uppercase tracking-[0.2em] text-[#849495]">Verification Queue</p>
            <h2 class="tp-guest-headline mt-2 text-3xl font-bold text-white">{{ __('Verify Email') }}</h2>
            <p class="mt-3 text-sm text-[#b9cacb]">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you did not receive the email, we will gladly send you another.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="rounded-lg border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="tp-guest-label text-xs uppercase tracking-[0.18em] text-[#b9cacb] transition hover:text-white">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
