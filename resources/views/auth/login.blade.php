<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-black text-slate-900">
            Welcome back
        </h2>
        <p class="text-sm text-slate-500 mt-1">
            Log in to access Barangay JobLink.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full rounded-2xl"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full rounded-2xl"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
                    name="remember"
                >

                <span class="ms-2 text-sm text-slate-600">
                    Remember me
                </span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a
                    class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                    href="{{ route('password.request') }}"
                >
                    Forgot your password?
                </a>
            @endif

            <x-primary-button class="ms-3 bg-slate-900 hover:bg-slate-800 rounded-xl">
                Log in
            </x-primary-button>
        </div>
    </form>

    <!-- Sign Up Section -->
    <div class="mt-6 pt-6 border-t border-slate-200 text-center">
        <p class="text-sm text-slate-600">
            New to Barangay JobLink?
        </p>

        <a
            href="{{ route('register') }}"
            class="mt-3 inline-flex items-center justify-center w-full px-4 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition"
        >
            Sign Up
        </a>

        <p class="text-xs text-slate-500 mt-4">
            Create an account as a job seeker or employer. Admin accounts are created by the system administrator.
        </p>
    </div>
</x-guest-layout>